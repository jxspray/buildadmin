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
                    <FormItem :label="t('cms.slide.name')" type="string" v-model="baTable.form.items!.name" prop="name" :placeholder="t('Please input field', { field: t('cms.slide.name') })" />
                    <FormItem :label="t('cms.slide.remark')" type="textarea" v-model="baTable.form.items!.remark" prop="remark" :input-attr="{ rows: 3 }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" :placeholder="t('Please input field', { field: t('cms.slide.remark') })" />
                    <FormItem :label="t('cms.slide.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { '0': t('cms.slide.status 0'), '1': t('cms.slide.status 1') } }" :placeholder="t('Please select field', { field: t('cms.slide.status') })" />
                    <el-form-item :label="t('cms.slide.groups')" prop="groups">
                        <div style="width: 100%;">
                            <el-row :gutter="10">
                                <el-col :span="6" class="ba-array-name">分组名</el-col>
                                <el-col :span="6" class="ba-array-width">宽</el-col>
                                <el-col :span="6" class="ba-array-height">高</el-col>
                            </el-row>
                            <el-row class="ba-array-item" v-for="(item, idx) in baTable.form.items!.groups" :gutter="10" :key="idx">
                                <el-col :span="6">
                                    <el-input v-model="item.name"></el-input>
                                </el-col>
                                <el-col :span="6">
                                    <el-input v-model.number="item.width" :step="1"></el-input>
                                </el-col>
                                <el-col :span="6">
                                    <el-input v-model.number="item.height" :step="1"></el-input>
                                </el-col>
                                <el-col :span="4">
                                    <el-button @click="onDelArrayItem(idx)" size="small" icon="el-icon-Delete" circle />
                                </el-col>
                            </el-row>
                            <el-row :gutter="10">
                                <el-col :span="10" :offset="8">
                                    <el-button v-blur class="ba-add-array-item" @click="onAddArrayItem" icon="el-icon-Plus">{{ t('Add') }}</el-button>
                                </el-col>
                            </el-row>
                        </div>
                    </el-form-item>
                    <FormItem :label="t('cms.slide.extends')" type="array" v-model="baTable.form.items!.extends" prop="extends" :placeholder="t('Please input field', { field: t('cms.slide.extends') })" />
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

const { t } = useI18n()



const onAddArrayItem = () => {
    baTable.form.items!.groups.push({
        name: '',
        width: 0,
        height: 0,
    })
}

const onDelArrayItem = (idx: number) => {
    baTable.form.items!.groups.splice(idx, 1)
}

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    width: [buildValidatorData({ name: 'number', title: t('cms.slide.width') })],
    height: [buildValidatorData({ name: 'number', title: t('cms.slide.height') })],
    create_time: [buildValidatorData({ name: 'date', title: t('cms.slide.create_time') })],
    update_time: [buildValidatorData({ name: 'date', title: t('cms.slide.update_time') })],
    delete_time: [buildValidatorData({ name: 'date', title: t('cms.slide.delete_time') })],
})
</script>



<style scoped lang="scss">
.ba-array-name,
.ba-array-width,
.ba-array-height {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 0;
    color: var(--el-text-color-secondary);
}
.ba-array-item {
    margin-bottom: 6px;
}
.ba-add-array-item {
    float: right;
}
</style>
