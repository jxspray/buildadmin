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
                <FormItem :label="t('routine.cms.module.name')" type="string" v-model="baTable.form.items!.name" prop="name" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.module.name') }) }" />
                <FormItem :label="t('routine.cms.module.title')" type="string" v-model="baTable.form.items!.title" prop="title" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.module.title') }) }" />
                <FormItem :label="t('routine.cms.module.description')" type="string" v-model="baTable.form.items!.description" prop="description" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.module.description') }) }" />
                <FormItem :label="t('routine.cms.module.type')" type="radio" v-model="baTable.form.items!.type" prop="type" :data="{ content: { 1: t('routine.cms.module.type 1'), 2: t('routine.cms.module.type 2') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.module.type') }) }" />
                <FormItem :label="t('routine.cms.module.issystem')" type="radio" v-model="baTable.form.items!.issystem" prop="issystem" :data="{ content: { 1: t('routine.cms.module.issystem 1'), 0: t('routine.cms.module.issystem 0') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.module.issystem') }) }" />
                <FormItem :label="t('routine.cms.module.issearch')" type="radio" v-model="baTable.form.items!.issearch" prop="issearch" :data="{ content: { 1: t('routine.cms.module.issearch 1'), 0: t('routine.cms.module.issearch 0') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.module.issearch') }) }" />
                <FormItem :label="t('routine.cms.module.listfields')" type="string" v-model="baTable.form.items!.listfields" prop="listfields" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.module.listfields') }) }" />
                <FormItem :label="t('routine.cms.module.weigh')" type="number" prop="weigh" v-model.number="baTable.form.items!.weigh" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.module.weigh') }) }" />
                <FormItem :label="t('routine.cms.module.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 1: t('routine.cms.module.status 1'), 0: t('routine.cms.module.status 0') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.module.status') }) }" />
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

const rules: Partial<Record<string, FormItemRule[]>> = reactive({})

</script>

<style scoped lang="scss"></style>
