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
                <el-tabs :tab-position="tabPosition" class="catalog-tabs">
                    <el-tab-pane :label="t('cms.catalog.base')">
                        <FormItem
                            type="remoteSelect"
                            :label="t('cms.catalog.moduleid')"
                            v-model="baTable.form.items!.moduleid"
                            :input-attr="{
                                field: 'title',
                                'remote-url': '/admin/cms.module/index',
                                placeholder: t('Please select field', { field: t('cms.catalog.moduleid') })
                            }"
                        />
                        <FormItem
                            type="remoteSelect"
                            :label="t('cms.catalog.pid')"
                            v-model="baTable.form.items!.pid"
                            :placeholder="t('Click Select')"
                            :input-attr="{
                                params: { isTree: true },
                                field: 'title',
                                'remote-url': '/admin/cms.catalog/index',
                            }"
                        />
                        <FormItem :label="t('cms.catalog.title')" type="string" v-model="baTable.form.items!.title" prop="title" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.title') }) }" />
                        <FormItem :label="t('cms.catalog.description')" type="textarea" v-model="baTable.form.items!.description" prop="description" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('cms.catalog.description') }) }" />
                        <FormItem :label="t('cms.catalog.weigh')" type="number" prop="weigh" v-model.number="baTable.form.items!.weigh" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.catalog.weigh') }) }" />
                        <FormItem :label="t('cms.catalog.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 0: t('cms.catalog.status 0'), 1: t('cms.catalog.status 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.status') }) }" />
                        <!-- <FormItem :label="t('cms.catalog.template_list')" type="select" v-model="baTable.form.items!.template_list" prop="template_list" :data="{ content: { } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.template_list') }) }" />
                        <FormItem :label="t('cms.catalog.template_info')" type="string" v-model="baTable.form.items!.template_info" prop="template_info" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.template_info') }) }" /> -->
                        <!-- <FormItem :label="t('cms.catalog.blank')" type="radio" v-model="baTable.form.items!.blank" prop="blank" :data="{ content: { 0: t('cms.catalog.blank 0'), 1: t('cms.catalog.blank 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.blank') }) }" />
                        <FormItem :label="t('cms.catalog.show')" type="radio" v-model="baTable.form.items!.show" prop="show" :data="{ content: { 0: t('cms.catalog.show 0'), 1: t('cms.catalog.show 1'), 2: t('cms.catalog.show 2'), 3: t('cms.catalog.show 3') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.show') }) }" /> -->
                    </el-tab-pane>
                    <el-tab-pane :label="t('cms.catalog.seo')">
                        <FormItem :label="t('cms.catalog.seo_title')" type="string" v-model="baTable.form.items!.seo_title" prop="seo_title" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_title') }) }" />
                        <FormItem :label="t('cms.catalog.seo_keywords')" type="string" v-model="baTable.form.items!.seo_keywords" prop="seo_keywords" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_keywords') }) }" />
                        <FormItem :label="t('cms.catalog.seo_description')" type="textarea" v-model="baTable.form.items!.seo_description" prop="seo_description" :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_description') }) }" />
                    </el-tab-pane>
                    <el-tab-pane :label="t('cms.catalog.extend')">
                        
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


const tabPosition = ref('left')
const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass

baTable.after = {
    requestEdit: function (res: any) {
        let catalogExtend = {};
        baTable.form.items!.catalogExtend = catalogExtend
    }
}

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    // pid: [buildValidatorData('required', t('cms.catalog.pid'))],
    // num: [buildValidatorData('required', t('cms.catalog.num'))],
    // title: [buildValidatorData('required', t('cms.catalog.title'))],
    // description: [buildValidatorData('required', t('cms.catalog.description'))],
    // template_list: [buildValidatorData('required', t('cms.catalog.template_list'))],
    // template_info: [buildValidatorData('required', t('cms.catalog.template_info'))],
    // seo_url: [buildValidatorData('required', t('cms.catalog.seo_url'))],
    // seo_title: [buildValidatorData('required', t('cms.catalog.seo_title'))],
    // seo_keywords: [buildValidatorData('required', t('cms.catalog.seo_keywords'))],
    // seo_description: [buildValidatorData('required', t('cms.catalog.seo_description'))],
    // links_value: [buildValidatorData('required', t('cms.catalog.links_value'))],
    // weigh: [buildValidatorData('required', t('cms.catalog.weigh'))],
    // module: [buildValidatorData('required', t('cms.catalog.module'))],
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
