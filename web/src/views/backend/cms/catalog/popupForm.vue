<template>
    <!-- 对话框表单 -->
    <el-dialog custom-class="ba-operate-dialog" :close-on-click-modal="false"
        :model-value="baTable.form.operate ? true : false" @close="baTable.toggleForm">
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
            <div class="ba-operate-form" :class="'ba-' + baTable.form.operate + '-form'"
                :style="'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'">
                <el-form v-if="!baTable.form.loading" ref="formRef" @keyup.enter="baTable.onSubmit(formRef)"
                    :model="baTable.form.items" label-position="right" :label-width="baTable.form.labelWidth + 'px'"
                    :rules="rules">
                    <FormItem :label="t('cms.catalog.parent_title')" type="remoteSelect" prop="pid"
                        v-model.number="baTable.form.items!.pid"
                        :input-attr="{ field: 'title', params: { isTree: true }, 'remote-url': baTable.api.actionUrl.get('index'), placeholder: t('Please select field', { field: t('，默认一级栏目') }) }" />
                    <FormItem :label="t('cms.catalog.title')" type="string" v-model="baTable.form.items!.title"
                        prop="title"
                        :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.title') }) }" />
                    <FormItem :label="t('cms.catalog.description')" type="string"
                        v-model="baTable.form.items!.description" prop="description"
                        :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.description') }) }" />
                    <FormItem :label="t('cms.catalog.seo_url')" type="string" v-model="baTable.form.items!.seo_url"
                        prop="seo_url"
                        :input-attr="{ placeholder: t('Please input field', { field: t('cms.catalog.seo_url') }) }" />
                    <FormItem :label="t('cms.catalog.blank')" type="select" prop="blank"
                        v-model.number="baTable.form.items!.blank"
                        :data="{ content: { 0: t('cms.catalog.blank 0'), 1: t('cms.catalog.blank 1') } }"
                        :input-attr="{ step: '1', placeholder: t('Please select field', { field: t('cms.catalog.blank') }) }" />
                    <FormItem :label="t('cms.catalog.links_type')" type="select" prop="links_type"
                        v-model.number="baTable.form.items!.links_type"
                        :data="{ content: { 0: t('cms.catalog.links_type 0'), 1: t('cms.catalog.links_type 1') } }"
                        :input-attr="{ step: '1', placeholder: t('Please select field', { field: t('cms.catalog.blank') }) }" />
                    <FormItem :label="t('cms.catalog.show')" type="select" prop="show"
                        v-model.number="baTable.form.items!.show"
                        :data="{ content: { 0: t('cms.catalog.show 0'), 1: t('cms.catalog.show 1'), 2: t('cms.catalog.show 2'), 3: t('cms.catalog.show 3') } }"
                        :input-attr="{ step: '1', placeholder: t('Please select field', { field: t('cms.catalog.show') }) }" />
                    <FormItem :label="t('cms.catalog.status')" type="select" v-model="baTable.form.items!.status"
                        prop="status"
                        :data="{ content: { 0: t('cms.catalog.status 0'), 1: t('cms.catalog.status 1') } }"
                        :input-attr="{ placeholder: t('Please select field', { field: t('cms.catalog.status') }) }" />
                </el-form>
            </div>
        </el-scrollbar>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm('')">{{ t('Cancel') }}</el-button>
                <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)"
                    type="primary">
                    {{ baTable.form.operateIds && baTable.form.operateIds.length > 1 ? t('Save and edit next item') :
                            t('Save')
                    }}
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
    // pid: [buildValidatorData('required', t('cms.catalog.pid'))],
    title: [buildValidatorData('required', t('cms.catalog.title'))],
    description: [buildValidatorData('required', t('cms.catalog.description'))],
    seo_url: [buildValidatorData('required', t('cms.catalog.seo_url'))],
    weigh: [buildValidatorData('required', t('cms.catalog.weigh'))],
    blank: [buildValidatorData('required', t('cms.catalog.blank'))],
    show: [buildValidatorData('required', t('cms.catalog.show'))],
    status: [buildValidatorData('required', t('cms.catalog.status'))],
})

</script>

<style scoped lang="scss">
</style>
