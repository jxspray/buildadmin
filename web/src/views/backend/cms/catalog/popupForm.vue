<!--
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-08-11 11:16:59
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-08-14 17:08:00
 * @FilePath: \web\src\views\backend\cms\catalog\popupForm.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
    <!-- 对话框表单 -->
    <el-dialog
        :fullscreen="true"
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="baTable.form.operate ? true : false"
        @close="baTable.toggleForm"
    >
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
            <div
                class="ba-operate-form"
                :class="'ba-' + baTable.form.operate + '-form'"
                :style="'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'"
            >
                <el-form
                    v-if="!baTable.form.loading"
                    ref="formRef"
                    @keyup.enter="baTable.onSubmit(formRef)"
                    :model="baTable.form.items"
                    label-position="right"
                    :label-width="baTable.form.labelWidth + 'px'"
                    :rules="rules"
                >
                    <el-tabs tab-position="left" class="catalog-tabs">
                        <el-tab-pane :label="t('cms.catalog.base')">
                            <FormItem
                                type="remoteSelect"
                                :label="t('cms.catalog.module_id')"
                                v-model="baTable.form.items!.module_id"
                                :input-attr="{
                                    field: 'title',
                                    'remote-url': '/admin/cms.module/index',
                                    placeholder: t('Please select field', { field: t('cms.catalog.module_id') })
                                }"
                            />
                            <FormItem
                                type="remoteSelect"
                                :label="t('cms.catalog.pid')"
                                v-model="baTable.form.items!.pid"
                                :placeholder="t('Click Select')"
                                :input-attr="{
                                    params: { isTree: true, current_id: baTable.form.items!.id },
                                    field: 'title',
                                    'remote-url': '/admin/cms.catalog/index',
                                }"
                            />
                            <FormItem :label="t('cms.catalog.title')" type="string" v-model="baTable.form.items!.title" prop="title" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.title') }) }" />
                            <FormItem :label="t('cms.catalog.description')" type="textarea" v-model="baTable.form.items!.description" prop="description" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('cms.catalog.description') }) }" />
                            <FormItem :label="t('cms.catalog.catdir')" type="string" v-model="baTable.form.items!.catdir" prop="catdir" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.catdir') }) }" />
                            <FormItem :label="t('cms.catalog.weigh')" type="number" prop="weigh" v-model.number="baTable.form.items!.weigh" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.catalog.weigh') }) }" />
                            <FormItem :label="t('cms.catalog.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 0: t('cms.catalog.status 0'), 1: t('cms.catalog.status 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.status') }) }" />
                            <FormItem :label="t('cms.catalog.template_show')" type="select" v-model="baTable.form.items!.template_show" prop="template_show" :data="{ content: state.template[baTable.form.items!.module_id || 1]!['show'] }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.template_show') }) }" />
                            <FormItem :label="t('cms.catalog.template_info')" type="select" v-model="baTable.form.items!.template_info" prop="template_info" :data="{ content: state.template[baTable.form.items!.module_id || 1]!['info'] }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.template_info') }) }" />
                        </el-tab-pane>
                        <el-tab-pane :label="t('cms.catalog.seo')">
                            <FormItem :label="t('cms.catalog.seo_title')" type="string" v-model="baTable.form.items!.seo_title" prop="seo_title" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_title') }) }" />
                            <FormItem :label="t('cms.catalog.seo_keywords')" type="string" v-model="baTable.form.items!.seo_keywords" prop="seo_keywords" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_keywords') }) }" />
                            <FormItem :label="t('cms.catalog.seo_description')" type="textarea" v-model="baTable.form.items!.seo_description" prop="seo_description" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_description') }) }" />
                        </el-tab-pane>
                        <el-tab-pane :label="t('cms.catalog.extend')" v-if="state.fields.length > 0">
                            <CustomFormItem
                                v-for="(item, index) in state.fields"
                                :type="item.type"
                                :label="t(item.name)"
                                v-model="state.catalogExtend![item.field]"
                                :option="item"
                                :key="index"
                            />
                        </el-tab-pane>
                    </el-tabs>
                </el-form>
            </div>
        </el-scrollbar>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm('')">{{ t('Cancel') }}</el-button>
                <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)" type="primary">
                    {{ baTable.form.operateIds && baTable.form.operateIds.length > 1 ? t('Save and edit next item') : t('Save') }}
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script setup lang="ts">
import { reactive, ref, inject } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'
import type { ElForm, FormItemRule } from 'element-plus'
import { buildValidatorData } from '/@/utils/validate'
import CustomFormItem from '../components/CustomFormItem/index.vue'


const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass

const state: {
    catalogExtend: any[],
    fields: any[],
    template: any[]
} = reactive({
    catalogExtend: [],
    fields: [],
    template: []
})

// 获取template
baTable.api.postData('getTemplate', {}).then((res: any) => {
    state.template = res.data
})

baTable.before = {
    onSubmit: function (res: any) {
        baTable.form.items!.catalogExtend = state.catalogExtend
    }
}
baTable.after = {
    requestEdit: function (res: any) {
        let fields = []
        for(const key in res.res.data.fields) {
            fields.push(res.res.data.fields[key])
        }
        state.fields = fields
        // state.template = res.data.template
    }
}

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
})

</script>

<style scoped lang="scss">
// .catalog-tabs .el-tabs__content {
//     padding: 32px;
//     color: #6b778c;
//     font-size: 32px;
//     font-weight: 600;
// }

// .el-tabs--right .el-tabs__content,
// .el-tabs--left .el-tabs__content {
//   height: 100%;
// }
</style>
