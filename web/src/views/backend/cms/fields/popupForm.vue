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
                <!-- 字段属性 -->
                <CustomField />

                <FormItem :label="t('cms.field.field')" type="string" v-model="baTable.form.items!.field" prop="field" :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.field') }) }" />
                <FormItem :label="t('cms.field.name')" type="string" v-model="baTable.form.items!.name" prop="name" :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.name') }) }" />
                <FormItem :label="t('cms.field.comment')" type="string" v-model="baTable.form.items!.comment" prop="comment" :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.comment') }) }" />
                <FormItem :label="t('cms.field.remark')" type="textarea" v-model="baTable.form.items!.remark" prop="remark" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('cms.field.remark') }) }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" />
                <FormItem :label="t('cms.field.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 0: t('cms.field.status 0'), 1: t('cms.field.status 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.field.status') }) }" />
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
import CustomField from './customField.vue'


const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    
})

</script>

<style scoped lang="scss"></style>
