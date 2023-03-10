<template>
    <FormItem :label="t('cms.field.type')" type="select" v-model="baTable.form.items!.type" prop="type" :data="{ content: form.customType }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.field.type') }) }" />
    <template v-if="baTable.form.items!.type == 'text'">
        <FormItem
            :label="t('cms.field.maxlength')"
            type="number"
            prop="maxlength"
            v-model.number="form.setup!.maxlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxlength') }) }"
        />
        <FormItem
            :label="t('cms.field.minlength')"
            type="number"
            prop="minlength"
            v-model.number="form.setup!.minlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.minlength') }) }"
        />
        <FormItem
            :label="t('验证规则')"
            type="number"
            prop="minlength"
            v-model.number="form.setup!.rule"
            :input-attr="{ placeholder: t('Please input field', { field: t('请输入验证规则') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'textarea'">
        <FormItem
            :label="t('cms.field.maxlength')"
            type="number"
            prop="maxlength"
            v-model.number="form.setup!.maxlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxlength') }) }"
        />
        <FormItem
            :label="t('cms.field.minlength')"
            type="number"
            prop="minlength"
            v-model.number="form.setup!.minlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.minlength') }) }"
        />
        <FormItem
            :label="t('显示行数')"
            type="number"
            prop="linenum"
            v-model.number="form.setup!.linenum"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('显示行数') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'number'">
        <FormItem
            :label="t('cms.field.max')"
            type="number"
            prop="max"
            v-model.number="form.setup!.max"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.max') }) }"
        />
        <FormItem
            :label="t('cms.field.min')"
            type="number"
            prop="min"
            v-model.number="form.setup!.min"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.min') }) }"
        />
        <FormItem
            :label="t('步长')"
            type="number"
            prop="step"
            v-model.number="form.setup!.step"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('步长') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'image'">
        <FormItem
            :label="t('cms.field.allowFormat')"
            type="checkbox"
            v-model="form.setup!.allowFormat"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(imageAllowFormat) }"
        />
        <FormItem
            :label="t('cms.field.maxFileSize')"
            type="number"
            prop="maxFileSize"
            v-model.number="form.setup!.maxFileSize"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxFileSize') }) }"
        />
        <FormItem
            :label="t('图片最大宽度')"
            type="number"
            prop="maxWidth"
            v-model.number="form.setup!.maxWidth"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大宽度') }) }"
        />
        <FormItem
            :label="t('图片最大高度')"
            type="number"
            prop="maxHight"
            v-model.number="form.setup!.maxHight"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大高度') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'file'">
        <FormItem
            :label="t('cms.field.allowFormat')"
            type="checkbox"
            v-model="form.setup!.allowFormat"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(fileAllowFormat) }"
        />
        <FormItem
            :label="t('cms.field.maxFileSize')"
            type="number"
            prop="maxFileSize"
            v-model.number="form.setup!.maxFileSize"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxFileSize') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'images'">
        <FormItem
            :label="t('cms.field.allowFormat')"
            type="checkbox"
            v-model="form.setup!.allowFormat"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(imageAllowFormat) }"
        />
        <FormItem
            :label="t('cms.field.maxFileSize')"
            type="number"
            prop="maxFileSize"
            v-model.number="form.setup!.maxFileSize"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxFileSize') }) }"
        />
        <FormItem
            :label="t('最大上传数')"
            type="number"
            prop="maxUpload"
            v-model.number="form.setup!.maxUpload"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最大上传数') }) }"
        />
        <FormItem
            :label="t('图片最大宽度')"
            type="number"
            prop="maxWidth"
            v-model.number="form.setup!.maxWidth"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大宽度') }) }"
        />
        <FormItem
            :label="t('图片最大高度')"
            type="number"
            prop="maxHight"
            v-model.number="form.setup!.maxHight"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大高度') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'files'">
        <FormItem
            :label="t('cms.field.allowFormat')"
            type="checkbox"
            v-model="form.setup!.allowFormat"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(fileAllowFormat) }"
        />
        <FormItem
            :label="t('cms.field.maxFileSize')"
            type="number"
            prop="maxFileSize"
            v-model.number="form.setup!.maxFileSize"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxFileSize') }) }"
        />
        <FormItem
            :label="t('最大上传数')"
            type="number"
            prop="maxUpload"
            v-model.number="form.setup!.maxUpload"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最大上传数') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'radio'">
        <FormItem
            :label="t('选项类型')"
            type="radio"
            v-model="form.setup!.type"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(['key', 'keyValue']) }"
        />
        <el-form-item style="text-align: center;">
            <el-input style="width:120px" placeholder="选项键" :disabled="true"></el-input>
            <el-input style="width:120px;margin-left: 5px;" placeholder="选项值" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item style="text-align: center;" v-for="(item, index) in form.setup!.options">
            <el-input style="width:120px" placeholder="请输入选项键" v-model="item.key" autocomplete="off" :disabled="form.setup!.type != 'keyValue'"></el-input>
            <el-input style="width:120px;margin-left: 5px;" placeholder="请输入选项值" v-model="item.value" autocomplete="off"></el-input>
            <el-button type="danger" style="margin-left: 5px;" @click="delOption(index)">删除</el-button>
        </el-form-item>
        <div style="text-align: center;margin-bottom: 10px;">
            <el-button type="success" @click="addOption({ key: '', value: '', type: 'select' })">添加</el-button>
        </div>
    </template>
    <template v-if="baTable.form.items!.type == 'select'">
        <FormItem
            :label="t('选项类型')"
            type="radio"
            v-model="form.setup!.type"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(['basic', 'remote']) }"
        />
        <div v-if="form.setup!.type == 'basic'">
            <el-form-item style="text-align: center;">
                <el-input style="width:120px" placeholder="选项键" :disabled="true"></el-input>
                <el-input style="width:120px;margin-left: 5px;" placeholder="选项值" :disabled="true"></el-input>
            </el-form-item>
            <el-form-item style="text-align: center;" v-for="(item, index) in form.setup!.options">
                <el-input style="width:120px" placeholder="请输入选项键" v-model="item.key" autocomplete="off" :disabled="form.setup!.type != 'keyValue'"></el-input>
                <el-input style="width:120px;margin-left: 5px;" placeholder="请输入选项值" v-model="item.value" autocomplete="off"></el-input>
                <el-button type="danger" style="margin-left: 5px;" @click="delOption(index)">删除</el-button>
            </el-form-item>
            <div style="text-align: center;margin-bottom: 10px;">
                <el-button type="success" @click="addOption({ key: '', value: '', type: 'select' })">添加</el-button>
            </div>
        </div>
        <div v-else-if="form.setup!.type == 'remote'">
            <FormItem :label="t('远程接口')" type="string" v-model="form.setup!.remoteUrl" prop="field" :input-attr="{ placeholder: t('Please input field', { field: t('远程接口') }) }" />
        </div>
        <FormItem :label="t('最多选择数')" type="number" prop="weigh" v-model.number="form.setup!.maxselect" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最多选择数') }) }" />
    </template>
    <FormItem
        :label="t('cms.field.default')"
        type="string"
        prop="default"
        v-model="form.setup!.default"
        :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.default') }) }"
    />
</template>

<script setup lang="ts">
import { reactive, inject, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'

const baTable = inject('baTable') as baTableClass

const imageAllowFormat = ['jpg', 'png', 'gif']
const fileAllowFormat = ['txt', 'pdf', 'crt']

// 键值对同位
const checkboxFormat = function (format: any[]){
    return format.reduce((obj, item) => ({...obj,[item]: item}), {})
}

const form: {
    setup: any|any[],
    customType: any|any[],
    customDefalut: any|any[]
} = reactive({
    setup: baTable.form.items!.setup,
    customType: { text: "单行文本", textarea: "多行文本", number: "数字", radio: "单选按钮", checkbox: "复选框", select: "下拉选择", image: "单图上传", images: "多图上传", file: "单附件上传", files: "多附件上传" },
    customDefalut: {
        text: {
            maxlength: 20,
            default: ''
        },
        image: {
            allowFormat: [],
            maxFileSize: 1024,
            default: ''
        },
        radio: {
            type: 'key',
            options: []
        },
        select: {
            type: 'basic',
            options: [],
            maxselect: 1
        }
    }
})

const addOption = function (format: { key: string|number, value: string, type: string }) {
    if (form.setup!.type == 'key') {
        format.key = form.setup!.options.length;
        console.log(format.key);
    }
    form.setup.options.push(format)
}

const delOption = function (index: number) {
    form.setup.options.splice(index, 1)
}

let val:any[]
const setSetup = (type: string) => {
    let setup:any = {}
    if (type in form.customDefalut) {
        val = form.customDefalut[type]
        if (!form.setup) setup = val
        else {
            for(const key in val) {
                setup[key] = form.setup[key] ? form.setup[key] : val[key]
            }
        }
    }
    form.setup = setup
    baTable.form.items!.setup = setup
}
setSetup(baTable.form.items!.type)

watch(() => baTable.form.items!.type, (newVal) => {
    setSetup(newVal)
})

watch(form.setup, (newVal) => {
    console.log(newVal);
    baTable.form.items!.setup = newVal
})

const { t } = useI18n()
</script>

<style scoped lang="scss"></style>
