<template>
<!-- 字段属性 -->
    <el-form-item :label="t('cms.fields.type')" prop="type">
        <el-select v-model="baTable.form.items!.type" placeholder="请选择">
            <el-option-group v-for="group in stateCustom.optionGroup" :key="group.label" :label="t('cms.fields.' + group.label)">
                <el-option v-for="item in group.options" :key="item.value" :label="item.label" :value="item.value"></el-option>
            </el-option-group>
        </el-select>
    </el-form-item>
    <FormItem 
        :label="t('文本框类型')" type="radio" v-model="form.setup!.type" :input-attr="{ size: 'large' }"
        :data="{ childrenAttr: { border: false }, content: checkboxFormat(['string', 'textarea', 'number', 'password']) }"
        v-if="state!.setting.includes('textType')" />
    <!-- 限制内容长度（限制内容在指定长度内格式为：最小-最大，如果只限制最大长度可直接填写数字，如果只限制最小长度可填写 >最小） -->
    <!-- number：限制数值大小 -->
    <FormItem 
        v-if="state!.setting.includes('textType') && form.setup!.type == 'number'" :label="t('数值区间')" type="string"
        prop="numSection" v-model="form.setup!.numSection"
        :input-attr="{ placeholder: t('Please input field', { field: t('数值区间') }) }" />
    <!-- number：设置步长 -->
    <FormItem 
        v-if="state!.setting.includes('textType') && form.setup!.type == 'number'" :label="t('步长')" type="number"
        prop="step" v-model.number="form.setup!.step"
        :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('步长') }) }" />
    <!-- textarea：限制内容长度（额外：-1为不限制）、展示行数 -->
    <FormItem 
        v-if="state!.setting.includes('textType') && form.setup!.type == 'textarea'" :label="t('显示行数')" type="number"
        prop="linenum" v-model.number="form.setup!.linenum"
        :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('显示行数') }) }" />
    <template v-if="state!.setting.includes('select')">
        <FormItem 
            :label="t('选项类型')" type="radio" v-model="form.setup!.type" :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(['key', 'keyValue']) }" />
        <el-form-item style="text-align: center;">
            <el-input style="width:120px" placeholder="选项键" :disabled="true"></el-input>
            <el-input style="width:120px;margin-left: 5px;" placeholder="选项值" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item style="text-align: center;" v-for="(item, index) in form.setup!.options" :key="index">
            <el-input
                style="width:120px" placeholder="请输入选项键" v-model="item.key" autocomplete="off"
                :disabled="form.setup!.type != 'keyValue'"></el-input>
            <el-input 
                style="width:120px;margin-left: 5px;" placeholder="请输入选项值" v-model="item.value"
                autocomplete="off"></el-input>
            <el-button type="danger" style="margin-left: 5px;" @click="delOption(index)">删除</el-button>
        </el-form-item>
        <div style="text-align: center;margin-bottom: 10px;">
            <el-button type="success" @click="addOption({ key: '', value: '', type: 'select' })">添加</el-button>
        </div>
    </template>
    <!-- 设置步长 -->
    <FormItem 
        v-if="state!.setting.includes('selectNum')" :label="t('最大选择数')" type="number" prop="maxSelect"
        v-model.number="form.setup!.maxSelect"
        :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最大选择数') }) }" />
    <template v-if="state!.setting.includes('remoteSelect')">
        <FormItem 
            :label="t('接口名')" type="string" v-model="form.setup!.remoteName" prop="remoteName"
            :input-attr="{ placeholder: t('Please input field', { field: t('接口名') }) }" />
        <FormItem 
            :label="t('键字段')" type="string" v-model="form.setup!.keyField" prop="keyField"
            :input-attr="{ placeholder: t('Please input field', { field: t('键字段') }) }" />
        <FormItem 
            :label="t('值字段')" type="string" v-model="form.setup!.valueField" prop="valueField"
            :input-attr="{ placeholder: t('Please input field', { field: t('值字段') }) }" />
        <FormItem 
            :label="t('最多选择数')" type="number" prop="weigh" v-model.number="form.setup!.maxSelect"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最多选择数') }) }" />
    </template>
    <FormItem 
        v-if="state!.setting.includes('datePicker')" :label="t('选择类型')" type="radio" v-model="form.setup!.type"
        :input-attr="{ size: 'large' }"
        :data="{ childrenAttr: { border: false }, content: checkboxFormat(['datetime', 'year', 'date', 'time']) }" />
    <template v-if="baTable.form.items!.type == 'city'">
    </template>
    <FormItem 
        v-if="state!.setting.includes('image')"
        :label="t('cms.fields.allowFormat')" type="checkbox" v-model="form.setup!.allowFormat"
        :input-attr="{ size: 'large' }"
        :data="{ childrenAttr: { border: false }, content: checkboxFormat(uploadAllowFormat.image) }" />
    <FormItem 
        v-if="state!.setting.includes('file')"
        :label="t('cms.fields.allowFormat')" type="checkbox" v-model="form.setup!.allowFormat"
        :input-attr="{ size: 'large' }"
        :data="{ childrenAttr: { border: false }, content: checkboxFormat(uploadAllowFormat.file) }" />
    <FormItem 
        v-if="state!.setting.includes('upload') || state!.setting.includes('uploads')"
        :label="t('cms.fields.maxFileSize')" type="number" prop="maxFileSize"
        v-model.number="form.setup!.maxFileSize"
        :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.fields.maxFileSize') }) }" />
    <FormItem 
        v-if="state!.setting.includes('uploads')"
        :label="t('最大上传数')" type="number" prop="maxUpload" v-model.number="form.setup!.maxUpload"
        :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最大上传数') }) }" />
    <template v-if="state!.setting.includes('image')">
        <FormItem 
            :label="t('图片最大宽度')" type="number" prop="maxWidth"
            v-model.number="form.setup!.maxWidth"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大宽度') }) }" />
        <FormItem 
            :label="t('图片最大高度')" type="number" prop="maxHight"
            v-model.number="form.setup!.maxHight"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大高度') }) }" />
    </template>
    <template v-if="state!.setting.includes('editor')">
        <FormItem :label="t('自动抓取缩略图')" type="switch" v-model="form.setup!.autoThumb" :input-attr="{ size: 'large' }" />
        <FormItem :label="t('自动抓取关键词')" type="switch" v-model="form.setup!.autoKeyword" :input-attr="{ size: 'large' }" />
        <FormItem 
            :label="t('关键词至少出现次数')" type="number" prop="minAppear" v-model.number="form.setup!.minAppear"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('关键词最少出现次数') }) }" />
        <FormItem 
            :label="t('自动抓取简介')" type="switch" v-model="form.setup!.autoDescription"
            :input-attr="{ size: 'large' }" />
        <FormItem 
            :label="t('截取内容前字数')" type="number" prop="cutContentNum" v-model.number="form.setup!.cutContentNum"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('截取内容前字数N个作为简介') }) }" />
    </template>
</template>

<script setup lang="ts">
import { reactive, inject, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'
import { state as stateCustom, typeOptions } from './index'

const baTable = inject('baTable') as baTableClass

// 键值对同位
const checkboxFormat = function (format: any[]) {
    return format.reduce((obj, item) => ({ ...obj, [item]: item }), {})
}
const uploadAllowFormat: {
    image: string[],
    file: string[]
} = {
    image: ['jpg', 'png', 'gif'],
    file: ['txt', 'pdf', 'crt']
}
const state: {
    setting: string[]
} = reactive({
    setting: []
})

const form: {
    setup: any | any[],
    customDefalut: any | any[]
} = reactive({
    setup: baTable.form.items!.setup,
    customDefalut: {
        text: {
            type: 'string',
            numSection: '',
            step: 1,
            linenum: 1,
            default: ''
        },
        radio: {
            type: 'key',
            options: []
        },
        checkbox: {
            type: 'key',
            options: [],
            maxSelect: 3
        },
        select: {
            type: 'key',
            options: [],
            maxSelect: 1
        },
        selects: {
            type: 'key',
            options: [],
            maxSelect: 1
        },
        remoteSelect: {
            type: 'key',
            keyField: 'id',
            valueField: 'title',
            remoteName: '',
            maxSelect: 1
        },
        remoteSelects: {
            type: 'key',
            keyField: 'id',
            valueField: 'title',
            remoteName: '',
            maxSelect: 1
        },
        datePicker: {
            type: 'datetime'
        },
        city: {
        },
        image: {
            allowFormat: uploadAllowFormat.image,
            maxFileSize: 1024, // KB
            maxUpload: 1,
            default: ''
        },
        images: {
            allowFormat: uploadAllowFormat.image,
            maxFileSize: 1024,
            maxUpload: 1,
            default: ''
        },
        file: {
            allowFormat: uploadAllowFormat.file,
            maxFileSize: 1024,
            maxUpload: 1,
            default: ''
        },
        files: {
            allowFormat: uploadAllowFormat.file,
            maxFileSize: 1024,
            maxUpload: 1,
            default: ''
        },
        editor: {
            autoThumb: 0,
            autoKeyword: 0,
            minShow: 3,
            autoDescription: 0,
            beforeNum: 200
        },
        custom: {
        },
        tag: {
        },
    }
})

const addOption = function (format: { key: string | number, value: string, type: string }) {
    if (form.setup!.type == 'key') {
        format.key = form.setup!.options.length;
        console.log(format.key);
    }
    form.setup.options.push(format)
}

const delOption = function (index: number) {
    form.setup.options.splice(index, 1)
}

let val: any[]
const setSetup = (type: string) => {
    let setup: any = {}
    if (type in form.customDefalut) {
        state.setting = typeOptions[type]!.setting || []
        val = form.customDefalut[type]
        if (!form.setup) setup = val
        else {
            for (const key in val) {
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
