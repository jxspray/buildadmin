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
                <FormItem :label="t('routine.cms.field.module_id')" type="number" prop="module_id" v-model.number="baTable.form.items!.module_id" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.field.module_id') }) }" />
                <FormItem :label="t('routine.cms.field.field')" type="string" v-model="baTable.form.items!.field" prop="field" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.field.field') }) }" />
                <FormItem :label="t('routine.cms.field.name')" type="string" v-model="baTable.form.items!.name" prop="name" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.field.name') }) }" />
                <FormItem :label="t('routine.cms.field.required')" type="radio" v-model="baTable.form.items!.required" prop="required" :data="{ content: { 0: t('routine.cms.field.required 0'), 1: t('routine.cms.field.required 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.field.required') }) }" />
                <FormItem :label="t('routine.cms.field.errormsg')" type="string" v-model="baTable.form.items!.errormsg" prop="errormsg" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.field.errormsg') }) }" />
                <FormItem :label="t('routine.cms.field.type')" type="string" v-model="baTable.form.items!.type" prop="type" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.field.type') }) }" />
                <FormItem :label="t('routine.cms.field.setup')" type="textarea" v-model="baTable.form.items!.setup" prop="setup" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('routine.cms.field.setup') }) }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" />
                <FormItem :label="t('routine.cms.field.issole')" type="radio" v-model="baTable.form.items!.issole" prop="issole" :data="{ content: { 0: t('routine.cms.field.issole 0'), 1: t('routine.cms.field.issole 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.field.issole') }) }" />
                <FormItem :label="t('routine.cms.field.listorder')" type="number" prop="listorder" v-model.number="baTable.form.items!.listorder" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.field.listorder') }) }" />
                <FormItem :label="t('routine.cms.field.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 0: t('routine.cms.field.status 0'), 1: t('routine.cms.field.status 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.field.status') }) }" />
                <FormItem :label="t('routine.cms.field.issystem')" type="radio" v-model="baTable.form.items!.issystem" prop="issystem" :data="{ content: { 0: t('routine.cms.field.issystem 0'), 1: t('routine.cms.field.issystem 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.field.issystem') }) }" />
                <FormItem :label="t('routine.cms.field.description')" type="string" v-model="baTable.form.items!.description" prop="description" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.field.description') }) }" />
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

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    module_id: [buildValidatorData('required', t('routine.cms.field.module_id'))],
    field: [buildValidatorData('required', t('routine.cms.field.field'))],
    name: [buildValidatorData('required', t('routine.cms.field.name'))],
    errormsg: [buildValidatorData('required', t('routine.cms.field.errormsg'))],
    type: [buildValidatorData('required', t('routine.cms.field.type'))],
    setup: [buildValidatorData('required', t('routine.cms.field.setup'))],
    listorder: [buildValidatorData('required', t('routine.cms.field.listorder'))],
})

</script>

<style scoped lang="scss"></style>
