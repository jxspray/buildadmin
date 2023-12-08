<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
            :fullscreen="true" class="ba-operate-dialog" :close-on-click-modal="false"
            :model-value="!!baTable.form.operate" @close="baTable.toggleForm">
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
                    <el-tabs tab-position="left" v-model="state.activeTab">
                        <el-tab-pane :label="t('基础字段')" name="base">
                            <FormItem :label="t('cms.slide.name')" type="string" v-model="baTable.form.items!.name" prop="name" :placeholder="t('Please input field', { field: t('cms.slide.name') })" />
                            <FormItem :label="t('cms.slide.remark')" type="textarea" v-model="baTable.form.items!.remark" prop="remark" :input-attr="{ rows: 3 }" @keyup.enter.stop="" @keyup.ctrl.enter="baTable.onSubmit(formRef)" :placeholder="t('Please input field', { field: t('cms.slide.remark') })" />
                            <FormItem :label="t('cms.slide.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { '0': t('cms.slide.status 0'), '1': t('cms.slide.status 1') } }" :placeholder="t('Please select field', { field: t('cms.slide.status') })" />
                        </el-tab-pane>
                        <el-tab-pane :label="t('图册配置')" name="data">
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
                                            <el-button @click="onDelArrayItem('groups', idx)" size="small" icon="el-icon-Delete" circle />
                                        </el-col>
                                    </el-row>
                                    <el-row :gutter="10">
                                        <el-col :span="10" :offset="8">
                                            <el-button v-blur class="ba-add-array-item" @click="onAddArrayItem()" icon="el-icon-Plus">{{ t('Add') }}</el-button>
                                        </el-col>
                                    </el-row>
                                </div>
                            </el-form-item>
                            <el-form-item :label="t('cms.slide.extends')" prop="extends">
                                <div style="width: 100%;">
                                    <el-row :gutter="10">
                                        <el-col :span="6" class="ba-array-name">字段</el-col>
                                        <el-col :span="6" class="ba-array-width">标题</el-col>
                                        <el-col :span="6" class="ba-array-height">类型</el-col>
                                    </el-row>
                                    <el-row class="ba-array-item" v-for="(item, idx) in baTable.form.items!.extends" :gutter="10" :key="idx">
                                        <el-col :span="6">
                                            <el-input v-model="item.field"></el-input>
                                        </el-col>
                                        <el-col :span="6">
                                            <el-input v-model="item.label"></el-input>
                                        </el-col>
                                        <el-col :span="6">
                                            <el-select style="width:100%" v-model="item.type" value-key="label"
                                                       placeholder="请选择字段类型" filterable>
                                                <el-option v-for="(ite, index) in fields" :key="index" :label="ite.label"
                                                           :value="ite"></el-option>
                                            </el-select>
                                        </el-col>
                                        <el-col :span="4">
                                            <el-button @click="onDelArrayItem('extends', idx)" size="small" icon="el-icon-Delete" circle />
                                        </el-col>
                                    </el-row>
                                    <el-row :gutter="10">
                                        <el-col :span="10" :offset="8">
                                            <el-button v-blur class="ba-add-array-item" @click="onAddArrayItem('extends')" icon="el-icon-Plus">{{ t('Add') }}</el-button>
                                        </el-col>
                                    </el-row>
                                </div>
                            </el-form-item>
                        </el-tab-pane>
                        <el-tab-pane :label="t('扩展字段')" name="extend">
                            <el-field v-model="baTable.form.items!.field" :ifset="true" v-if="!!baTable.form.operate"></el-field>
                        </el-tab-pane>
                    </el-tabs>
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
import {ElForm} from "element-plus";
import ElField from "/@/views/backend/cms/components/elField/index.vue";

const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const state = reactive({
    setShow: false,
    setIndex: 0,
    setForm: {field: "", label: "", type: undefined},
    activeTab: "base"
})

const obj = {
    groups: {
        name: '',
        width: 0,
        height: 0
    },
    extends: {
        field: '',
        label: "",
        type: undefined
    }
}

const fields: FieldType[] = [
    {label: "文本", type: "string", value: ""},
    {label: "文本域", type: "textarea", value: ""},
    {label: "编辑器", type: "editor", value: ""},
    {label: "链接设置", type: "link-select", value: {}},
    {label: "图片上传", type: "image", value: ""},
    {label: "图片列表", type: "images", value: []},
    {label: "文件上传", type: "file", value: ""},
    {label: "文件列表", type: "files", value: []},
    {label: "分类编号", type: "remoteSelect", value: 0},
    {label: "参数设置", type: "array", value: []},
    {label: "颜色选择", type: "color", value: ""},
    {label: "开关", type: "switch", value: false},
]
const onAddArrayItem = (field: string) => {
    baTable.form.items![field].push(JSON.parse(JSON.stringify(obj[field])))
}
const onEditExtendsItem = (index: number) => {
    state.setIndex = index
    state.setShow = true
    state.setForm = baTable.form.items!.extends[index].type
}
const addField = (formEl: FormInstance | undefined = undefined) => {
    if (formEl) {
        formEl.validate((valid: boolean) => {
            if (valid) {
                let row = this.form.setForm
                this.module.column.push(row)
                this.module.table.map(item => {
                    item[row.field] = row.type?.value
                    return item
                })
                this.form.setShow = false
                this.form.setForm = {label: '', field: '', type: undefined}
            }
        }).then(r => {
            console.log(r)
        })
    } else {
        return false;
    }
}

const onDelArrayItem = (field: string, idx: number) => {
    baTable.form.items![field].splice(idx, 1)
    console.log(baTable.form.items![field])
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
.ba-operate-dialog .el-dialog__body {
  height: 92%;
  padding-top: 0;
  padding-bottom: 52px;
}

.ba-operate-dialog .el-scrollbar__view {
  height: 100%;
}

.ba-operate-form {
  height: 100%;

  .el-form {
    height: 100%;

    .el-tabs {
      height: 100%;

      .el-tabs__content {
        height: 100%;

        .el-tab-pane {
          height: 100%;
        }
      }
    }
  }
}

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
