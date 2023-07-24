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
                <FormItem :label="t('routine.cms.catalog.pid')" type="number" prop="pid" v-model.number="baTable.form.items!.pid" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.pid') }) }" />
                <FormItem :label="t('routine.cms.catalog.num')" type="number" prop="num" v-model.number="baTable.form.items!.num" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.num') }) }" />
                <FormItem :label="t('routine.cms.catalog.level')" type="number" prop="level" v-model.number="baTable.form.items!.level" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.level') }) }" />
                <FormItem :label="t('routine.cms.catalog.group_id')" type="remoteSelect" v-model="baTable.form.items!.group_id" prop="group_id" :input-attr="{ field: 'name', 'remote-url': 'group', pk: 'group.id', placeholder: t('Please select field', { field: t('routine.cms.catalog.group_id') }) }" />
                <FormItem :label="t('routine.cms.catalog.title')" type="string" v-model="baTable.form.items!.title" prop="title" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.title') }) }" />
                <FormItem :label="t('routine.cms.catalog.description')" type="string" v-model="baTable.form.items!.description" prop="description" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.description') }) }" />
                <FormItem :label="t('routine.cms.catalog.field')" type="textarea" v-model="baTable.form.items!.field" prop="field" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('routine.cms.catalog.field') }) }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" />
                <FormItem :label="t('routine.cms.catalog.template_list')" type="select" v-model="baTable.form.items!.template_list" prop="template_list" :data="{ content: { } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.catalog.template_list') }) }" />
                <FormItem :label="t('routine.cms.catalog.template_info')" type="string" v-model="baTable.form.items!.template_info" prop="template_info" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.template_info') }) }" />
                <FormItem :label="t('routine.cms.catalog.seo_url')" type="string" v-model="baTable.form.items!.seo_url" prop="seo_url" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.seo_url') }) }" />
                <FormItem :label="t('routine.cms.catalog.seo_title')" type="string" v-model="baTable.form.items!.seo_title" prop="seo_title" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.seo_title') }) }" />
                <FormItem :label="t('routine.cms.catalog.seo_keywords')" type="string" v-model="baTable.form.items!.seo_keywords" prop="seo_keywords" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.seo_keywords') }) }" />
                <FormItem :label="t('routine.cms.catalog.seo_description')" type="string" v-model="baTable.form.items!.seo_description" prop="seo_description" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.seo_description') }) }" />
                <FormItem :label="t('routine.cms.catalog.links_type')" type="radio" v-model="baTable.form.items!.links_type" prop="links_type" :data="{ content: { 0: t('routine.cms.catalog.links_type 0'), 1: t('routine.cms.catalog.links_type 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.catalog.links_type') }) }" />
                <FormItem :label="t('routine.cms.catalog.links_value')" type="textarea" v-model="baTable.form.items!.links_value" prop="links_value" :input-attr="{ rows: 3, placeholder: t('Please input field', { field: t('routine.cms.catalog.links_value') }) }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" />
                <FormItem :label="t('routine.cms.catalog.weigh')" type="number" prop="weigh" v-model.number="baTable.form.items!.weigh" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.weigh') }) }" />
                <FormItem :label="t('routine.cms.catalog.module')" type="string" v-model="baTable.form.items!.module" prop="module" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.module') }) }" />
                <FormItem :label="t('routine.cms.catalog.module_id')" type="number" prop="module_id" v-model.number="baTable.form.items!.module_id" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.module_id') }) }" />
                <FormItem :label="t('routine.cms.catalog.blank')" type="number" prop="blank" v-model.number="baTable.form.items!.blank" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.blank') }) }" />
                <FormItem :label="t('routine.cms.catalog.show')" type="number" prop="show" v-model.number="baTable.form.items!.show" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.show') }) }" />
                <FormItem :label="t('routine.cms.catalog.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { 0: t('routine.cms.catalog.status 0'), 1: t('routine.cms.catalog.status 1') } }" :input-attr="{ placeholder: t('Please select field', { field: t('routine.cms.catalog.status') }) }" />
                <FormItem :label="t('routine.cms.catalog.language')" type="string" v-model="baTable.form.items!.language" prop="language" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.language') }) }" />
                <FormItem :label="t('routine.cms.catalog.mobile')" type="number" prop="mobile" v-model.number="baTable.form.items!.mobile" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.cms.catalog.mobile') }) }" />
                <FormItem :label="t('routine.cms.catalog.theme')" type="string" v-model="baTable.form.items!.theme" prop="theme" :input-attr="{ placeholder: t('Please input field', { field: t('routine.cms.catalog.theme') }) }" />
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
    pid: [buildValidatorData('required', t('routine.cms.catalog.pid'))],
    num: [buildValidatorData('required', t('routine.cms.catalog.num'))],
    level: [buildValidatorData('required', t('routine.cms.catalog.level'))],
    group_id: [buildValidatorData('required', t('routine.cms.catalog.group_id'))],
    title: [buildValidatorData('required', t('routine.cms.catalog.title'))],
    description: [buildValidatorData('required', t('routine.cms.catalog.description'))],
    field: [buildValidatorData('required', t('routine.cms.catalog.field'))],
    template_list: [buildValidatorData('required', t('routine.cms.catalog.template_list'))],
    template_info: [buildValidatorData('required', t('routine.cms.catalog.template_info'))],
    seo_url: [buildValidatorData('required', t('routine.cms.catalog.seo_url'))],
    seo_title: [buildValidatorData('required', t('routine.cms.catalog.seo_title'))],
    seo_keywords: [buildValidatorData('required', t('routine.cms.catalog.seo_keywords'))],
    seo_description: [buildValidatorData('required', t('routine.cms.catalog.seo_description'))],
    links_type: [buildValidatorData('required', t('routine.cms.catalog.links_type'))],
    links_value: [buildValidatorData('required', t('routine.cms.catalog.links_value'))],
    weigh: [buildValidatorData('required', t('routine.cms.catalog.weigh'))],
    module: [buildValidatorData('required', t('routine.cms.catalog.module'))],
    blank: [buildValidatorData('required', t('routine.cms.catalog.blank'))],
    show: [buildValidatorData('required', t('routine.cms.catalog.show'))],
    status: [buildValidatorData('required', t('routine.cms.catalog.status'))],
    language: [buildValidatorData('required', t('routine.cms.catalog.language'))],
    mobile: [buildValidatorData('required', t('routine.cms.catalog.mobile')), buildValidatorData('mobile', '', 'blur', t('Please enter the correct field', { field: t('routine.cms.catalog.mobile') }))],
    theme: [buildValidatorData('required', t('routine.cms.catalog.theme'))],
})

</script>

<style scoped lang="scss"></style>
