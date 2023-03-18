<template>
    <FormItem :label="t('cms.field.type')" type="select" v-model="baTable.form.items!.type" prop="type" :data="{ content: form.customType }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.field.type') }) }" />
    <template v-if="baTable.form.items!.type == 'text'">
        <FormItem
            :label="t('文本框类型')"
            type="radio"
            v-model="form.setup!.type"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(['string', 'textarea', 'number', 'password']) }"
        />
        <!-- 限制内容长度（限制内容在指定长度内格式为：最小-最大，如果只限制最大长度可直接填写数字，如果只限制最小长度可填写 >最小） -->
        <!-- number：限制数值大小 -->
        <FormItem
            v-if="form.setup!.type == 'number'"
            :label="t('数值区间')"
            type="string"
            prop="numSection"
            v-model="form.setup!.numSection"
            :input-attr="{ placeholder: t('Please input field', { field: t('数值区间') }) }"
        />
        <!-- number：设置步长 -->
        <FormItem
            v-if="form.setup!.type == 'number'"
            :label="t('步长')"
            type="number"
            prop="step"
            v-model.number="form.setup!.step"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('步长') }) }"
        />
        <!-- string：限制内容长度 -->
        <FormItem
            v-if="form.setup!.type != 'number'"
            :label="t('cms.field.section')"
            type="string"
            prop="section"
            v-model="form.setup!.section"
            :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.section') }) }"
        />
        <!-- textarea：限制内容长度（额外：-1为不限制）、展示行数 -->
        <FormItem
            v-if="form.setup!.type == 'textarea'"
            :label="t('显示行数')"
            type="number"
            prop="linenum"
            v-model.number="form.setup!.linenum"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('显示行数') }) }"
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
    <template v-if="baTable.form.items!.type == 'checkbox'">
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
        <!-- 设置步长 -->
        <FormItem
            :label="t('最大选择数')"
            type="number"
            prop="maxSelect"
            v-model.number="form.setup!.maxSelect"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最大选择数') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'select'">
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
        <FormItem :label="t('最多选择数')" type="number" prop="weigh" v-model.number="form.setup!.maxselect" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最多选择数') }) }" />
    </template>
    <template v-if="baTable.form.items!.type == 'remoteSelect'">
        <FormItem :label="t('接口名')" type="string" v-model="form.setup!.remoteName" prop="remoteName" :input-attr="{ placeholder: t('Please input field', { field: t('接口名') }) }" />
        <FormItem :label="t('键字段')" type="string" v-model="form.setup!.keyField" prop="keyField" :input-attr="{ placeholder: t('Please input field', { field: t('键字段') }) }" />
        <FormItem :label="t('值字段')" type="string" v-model="form.setup!.valueField" prop="valueField" :input-attr="{ placeholder: t('Please input field', { field: t('值字段') }) }" />
        <FormItem :label="t('最多选择数')" type="number" prop="weigh" v-model.number="form.setup!.maxselect" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('最多选择数') }) }" />
    </template>
    <template v-if="baTable.form.items!.type == 'datePicker'">
        <FormItem
            :label="t('选择类型')"
            type="radio"
            v-model="form.setup!.type"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(['datetime', 'year', 'date', 'time']) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'city'">
    </template>
    <template v-if="baTable.form.items!.type == 'upload'">
        <FormItem
            :label="t('上传类型')"
            type="radio"
            v-model="form.setup!.type"
            :input-attr="{ size: 'large' }"
            :data="{ childrenAttr: { border: false }, content: checkboxFormat(['image', 'file']) }"
        />
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
            v-if="form.setup!.type == 'image'"
            :label="t('图片最大宽度')"
            type="number"
            prop="maxWidth"
            v-model.number="form.setup!.maxWidth"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大宽度') }) }"
        />
        <FormItem
            v-if="form.setup!.type == 'image'"
            :label="t('图片最大高度')"
            type="number"
            prop="maxHight"
            v-model.number="form.setup!.maxHight"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('图片最大高度') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'editor'">
        <FormItem
            :label="t('自动抓取缩略图')"
            type="switch"
            v-model="form.setup!.autoThumb"
            :input-attr="{ size: 'large' }"
        />
        <FormItem
            :label="t('自动抓取关键词')"
            type="switch"
            v-model="form.setup!.autoKeyword"
            :input-attr="{ size: 'large' }"
        />
        <FormItem
            :label="t('关键词至少出现次数')"
            type="number"
            prop="minShow"
            v-model.number="form.setup!.minShow"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('关键词最少出现次数') }) }"
        />
        <FormItem
            :label="t('自动抓取简介')"
            type="switch"
            v-model="form.setup!.autoDescription"
            :input-attr="{ size: 'large' }"
        />
        <FormItem
            :label="t('截取内容前字数')"
            type="number"
            prop="beforeNum"
            v-model.number="form.setup!.beforeNum"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('截取内容前字数N个作为简介') }) }"
        />
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
    customType: { text: "文本框", radio: "单选按钮", checkbox: "复选框", select: "下拉选择", remoteSelect: "远程下拉选择框", datePicker: "日期选择器", city: "省市区选择器", editor: "富文本编辑器", upload: "上传", verify: "验证码", custom: "自定义多文本", tag: "标签" },
    customDefalut: {
        text: {
            type: 'string',
            section: '',
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
            maxselect: 1
        },
        remoteSelect: {
            type: 'key',
            keyField: 'id',
            valueField: 'title',
            remoteName: '',
            maxselect: 1
        },
        datePicker: {
            type: 'datetime'
        },
        upload: {
            type: 'image',
            allowFormat: [],
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
