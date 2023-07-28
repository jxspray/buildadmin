<template>
    <!-- 对话框表单 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :destroy-on-close="true"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
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
                    ref="formRef"
                    @keyup.enter="baTable.onSubmit(formRef)"
                    :model="baTable.form.items"
                    label-position="right"
                    :label-width="baTable.form.labelWidth + 'px'"
                    :rules="rules"
                    v-if="!baTable.form.loading"
                >
                    <FormItem :label="t('cms.fields.field')" type="string" v-model="baTable.form.items!.field" prop="field" :input-attr="{ placeholder: t('Please input field', { field: t('cms.fields.field') }) }" />
                    <FormItem :label="t('cms.fields.name')" type="string" v-model="baTable.form.items!.name" prop="name" :input-attr="{ placeholder: t('Please input field', { field: t('cms.fields.name') }) }" />
                    
                    <CustomField />
                    <FormItem 
                        :label="t('cms.fields.default')" type="string" prop="default" v-model="baTable.form.items!.default"
                        :input-attr="{ placeholder: t('Please input field', { field: t('cms.fields.default') }) }" />

                    <!-- <FormItem :label="t('cms.fields.comment')" type="string" v-model="baTable.form.items!.comment" prop="comment" :input-attr="{ placeholder: t('Please input field', { field: t('cms.fields.comment') }) }" /> -->
                    <FormItem :label="t('cms.fields.remark')" type="textarea" v-model="baTable.form.items!.remark" prop="remark" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('cms.fields.remark') }) }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" />
                    <FormItem :label="t('cms.fields.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 0: t('cms.fields.status 0'), 1: t('cms.fields.status 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.fields.status') }) }" />
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
import { ref, reactive, inject } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import type { FormInstance, FormItemRule } from 'element-plus'
import FormItem from '/@/components/formItem/index.vue'
import CustomField from './customField.vue'
import { buildValidatorData } from '/@/utils/validate'

const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    field: [buildValidatorData({ name: 'required', title: t('cms.fields.field') }),
        {
            validator: (rule: any, val: string, callback: Function) => {
                if (!val) {
                    return callback()
                }
                if (!/(^_([a-zA-Z0-9]_?)*$)|(^[a-zA-Z](_?[a-zA-Z0-9])*_?$)/.test(val)) {
                    return callback(new Error(t('字段名格式错误！')))
                }
                return callback()
            },
            trigger: 'blur',
        }],
    name: [buildValidatorData({ name: 'required', title: t('cms.fields.name') })],
    type: [buildValidatorData({ name: 'required', title: t('cms.fields.type') })]
})
</script>

<style scoped lang="scss"></style>
