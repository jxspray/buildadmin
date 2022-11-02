<template>
    <!-- 对话框表单 -->
    <el-dialog
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
                <FormItem :label="t('cms.module.name')" type="string" v-model="baTable.form.items!.name" prop="name" :input-attr="{ placeholder: t('Please input field', { field: t('cms.module.name') }) }" />
                <FormItem :label="t('cms.module.title')" type="string" v-model="baTable.form.items!.title" prop="title" :input-attr="{ placeholder: t('Please input field', { field: t('cms.module.title') }) }" />
                <FormItem :label="t('cms.module.description')" type="string" v-model="baTable.form.items!.description" prop="description" :input-attr="{ placeholder: t('Please input field', { field: t('cms.module.description') }) }" />
                <FormItem :label="t('cms.module.type')" type="radio" v-model="baTable.form.items!.type" prop="type" :data="{ content: { 1: t('cms.module.type 1'), 2: t('cms.module.type 2') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.module.type') }) }" />
                <!-- <FormItem :label="t('cms.module.issystem')" type="radio" v-model="baTable.form.items!.issystem" prop="issystem" :data="{ content: { 1: t('cms.module.issystem 1'), 0: t('cms.module.issystem 0') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.module.issystem') }) }" /> -->
                <!-- <FormItem :label="t('cms.module.issearch')" type="radio" v-model="baTable.form.items!.issearch" prop="issearch" :data="{ content: { 1: t('cms.module.issearch 1'), 0: t('cms.module.issearch 0') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.module.issearch') }) }" /> -->
                <!-- <FormItem :label="t('cms.module.listfields')" type="string" v-model="baTable.form.items!.listfields" prop="listfields" :input-attr="{ placeholder: t('Please input field', { field: t('cms.module.listfields') }) }" /> -->
                <FormItem :label="t('cms.module.weigh')" type="number" prop="weigh" v-model.number="baTable.form.items!.weigh" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.module.weigh') }) }" />
                <FormItem :label="t('cms.module.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 1: t('cms.module.status 1'), 0: t('cms.module.status 0') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.module.status') }) }" />

                
                <FormItem v-if="baTable.form.operate == 'add'"
                    :label="t('cms.module.template')" 
                    type="radio" v-model="baTable.form.items!.template" 
                    prop="template" 
                    :data="{ content: { 'empty': t('cms.module.empty template'), 'article': t('cms.module.article template') } }" 
                    :input-attr="{ placeholder: t('Please select field', { field: t('cms.module.template') }) }" 
                />
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


const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass
baTable.api.actionUrl.set('createTemplateField', '/admin/cms.module/createTemplateField')
baTable.after = {
    onSubmit: function (res: any){
        if (res.res.code == 1 && res.res.data?.id > 0) {
            // 执行模板字段创建
            baTable.api.postData('createTemplateField', { moduleid: res.res.data.id })
        }
    }
}

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({})

</script>

<style scoped lang="scss"></style>
