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
                    <el-tab-pane :label="t('cms.catalog.base')" v-if="baseFields.length">
                        <CustomFormItem
                            v-for="(item, index) in baseFields"
                            :type="item.type"
                            :label="t(item.name)"
                            v-model="baTable.form.items![item.field]"
                            :option="item"
                            :key="index"
                        />
                    </el-tab-pane>
                    <el-tab-pane :label="t('cms.catalog.seo')" v-if="seoFields.length">
                        <CustomFormItem
                            v-for="(item, index) in seoFields"
                            :type="item.type"
                            :label="t(item.name)"
                            v-model="baTable.form.items![item.field]"
                            :option="item"
                            :key="index"
                        />
                    </el-tab-pane>
                    <el-tab-pane :label="t('cms.catalog.extend')" v-if="extendFields.length">
                        <CustomFormItem
                            v-for="(item, index) in extendFields"
                            :type="item.type"
                            :label="t(item.name)"
                            v-model="baTable.form.items![item.field]"
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
import type { ElForm, FormItemRule } from 'element-plus'
import CustomFormItem from '../../components/CustomFormItem/index.vue'


const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass

const state: {
    data: any
} = reactive({
    data: {}
})
// 获取模块字段信息

const baseType = ['text', 'number', 'radio', 'checkbox', 'select', 'remoteSelect'];
const baseFields: any[] = [];

const seoField = ['seo_title', 'seo_keywords', 'seo_description'];
const seoFields: any[] = [];

// const extendType = ['text', 'textarea', 'number', 'radio', 'checkbox', 'select'];
const extendFields: any[] = [];

baTable.before = {
    onSubmit: function (res: any) {
    }
}
baTable.after = {
    getIndex: function() {
        baTable.form.extend!.fields.forEach((item: any) => {
            if (seoField.includes(item.field)) seoFields.push(item)
            else if (baseType.includes(item.type)) baseFields.push(item);
            else extendFields.push(item)
        });
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
