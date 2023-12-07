<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
        @close="baTable.toggleForm"
        width="50%"
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
                    @submit.prevent=""
                    @keyup.enter="baTable.onSubmit(formRef)"
                    :model="baTable.form.items"
                    label-position="right"
                    :label-width="baTable.form.labelWidth + 'px'"
                    :rules="rules"
                >
                    <FormItem :label="t('cms.slide.data.slide_id')" type="remoteSelect" v-model="baTable.form.items!.slide_id" prop="slide_id" :input-attr="{ pk: 'ba_cms_slide.id', field: 'name', 'remote-url': '/admin/cms.Slide/index' }" :placeholder="t('Please select field', { field: t('cms.slide.data.slide_id') })" />
                    <FormItem :label="t('cms.slide.data.title')" type="string" v-model="baTable.form.items!.title" prop="title" :placeholder="t('Please input field', { field: t('cms.slide.data.title') })" />

                    <el-form-item v-for="(item, index) in state.extends" :data-id="index" :label="item.label" :key="index" >
                        <div class="w100">
                            <ElLinkSelect v-if="item.type!.type == 'link-select'" v-model="item.type!.value"
                                          size=""/>
                            <CustomArray v-else-if="item.type!.type == 'customArray'" v-model="item.type!.value"/>
                            <BaInput
                                    v-else
                                    @pointerdown.stop
                                    v-model="item.type!.value"
                                    :type="item.type!.type"
                            />
                        </div>
                    </el-form-item>
<!--                    <FormItem :label="t('cms.slide.data.image')" type="image" v-model="baTable.form.items!.image" prop="image" />-->
<!--                    <FormItem :label="t('cms.slide.data.link')" type="string" v-model="baTable.form.items!.link" prop="link" :placeholder="t('Please input field', { field: t('cms.slide.data.link') })" />-->
                    <FormItem :label="t('cms.slide.data.remark')" type="textarea" v-model="baTable.form.items!.remark" prop="remark" :placeholder="t('Please input field', { field: t('cms.slide.data.remark') })" />
                    <FormItem :label="t('cms.slide.data.width')" type="number" prop="width" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.width" :placeholder="t('Please input field', { field: t('cms.slide.data.width') })" />
                    <FormItem :label="t('cms.slide.data.height')" type="number" prop="height" :input-attr="{ step: 1 }" v-model.number="baTable.form.items!.height" :placeholder="t('Please input field', { field: t('cms.slide.data.height') })" />
                    <FormItem :label="t('cms.slide.data.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { '0': t('cms.slide.data.status 0'), '1': t('cms.slide.data.status 1') } }" :placeholder="t('Please select field', { field: t('cms.slide.data.status') })" />
                    <el-form-item :label="t('cms.slide.data.group')" prop="group">
                        <el-select v-model="baTable.form.items!.group" clearable :placeholder="t('Please input field', { field: t('cms.slide.data.group') })" class="w100" @change="onChangeGroup">
                            <el-option
                            v-for="(item, index) in state.groupList"
                            :key="index"
                            :label="item.name + ':' + item.width + 'x' + item.height"
                            :value="item.name"
                            />
                        </el-select>
                    </el-form-item>
                    <FormItem :label="t('cms.slide.data.extends')" type="string" v-model="baTable.form.items!.extends" prop="extends" :placeholder="t('Please input field', { field: t('cms.slide.data.extends') })" />
                </el-form>
            </div>
        </el-scrollbar>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm()">{{ t('Cancel') }}</el-button>
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
import type { FormInstance, FormItemRule } from 'element-plus'
import { buildValidatorData } from '/@/utils/validate'

const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass
import createAxios from '/@/utils/axios'
import { useRoute } from 'vue-router'
import BaInput from "/@/components/baInput/index.vue";
import ElLinkSelect from "/@/views/backend/cms/components/elLinkSelect/index.vue";
import CustomArray from "/@/views/backend/cms/components/customArray/index.vue";
import Icon from "/@/components/icon/index.vue";
const route = useRoute()

const { t } = useI18n()

const state: {
    groupList: { name: string, width: number, height: number }[]
    extends: {
        field: string
        label: string
        type?: {
            value: any
            label: string
            type: string
        }
    }[]
} = reactive({
    groupList: [{ name: '通用', width: 0, height: 0 }],
    extends: [],
})

baTable.after = {
    toggleForm: function () {
        if (!baTable.form.operate) return true
        createAxios(
            {
                url: '/admin/cms.Slide/edit',
                method: 'get',
                params: { id: route.query.slide_id },
            },
            {
                showSuccessMessage: false,
            }
        ).then((res: any) => {
            const groups = res.data.row.groups
            state.extends = res.data.row.extends
            Object.keys(groups).forEach((item) => {
                groups[item].width = parseInt(groups[item].width)
                groups[item].height = parseInt(groups[item].height)
            })

            state.groupList = groups
            if (state.groupList.length === 0) state.groupList =  [{ name: '通用', width: 0, height: 0 }]
            const group = state.groupList[0]
            baTable.form.items!.group = group.name
            if (baTable.form.operate == 'Add') {
                baTable.form.items!.width = group.width
                baTable.form.items!.height = group.height
            }
        })
    }
}

const onChangeGroup = function (val: string) {
    const group = state.groupList.find((item) => item.name === val)
    if (!group) return
    baTable.form.items!.width = group.width
    baTable.form.items!.height = group.height
}

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    width: [buildValidatorData({ name: 'number', title: t('cms.slide.data.width') })],
    height: [buildValidatorData({ name: 'number', title: t('cms.slide.data.height') })],
    create_time: [buildValidatorData({ name: 'date', title: t('cms.slide.data.create_time') })],
    update_time: [buildValidatorData({ name: 'date', title: t('cms.slide.data.update_time') })],
    delete_time: [buildValidatorData({ name: 'date', title: t('cms.slide.data.delete_time') })],
})
</script>

<style scoped lang="scss"></style>
