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
            :label="t('cms.field.default')"
            type="string"
            prop="default"
            v-model="form.setup!.default"
            :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.default') }) }"
        />
    </template>
    <template v-if="baTable.form.items!.type == 'radio'">
        <FormItem
            :label="t('cms.field.maxlength')"
            type="number"
            prop="maxlength"
            v-model.number="form.setup!.maxlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.field.maxlength') }) }"
        />
        <FormItem
            :label="t('cms.field.default')"
            type="string"
            prop="default"
            v-model="form.setup!.default"
            :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.default') }) }"
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
            :label="t('cms.field.default')"
            type="string"
            prop="default"
            v-model="form.setup!.default"
            :input-attr="{ placeholder: t('Please input field', { field: t('cms.field.default') }) }"
        />
    </template>
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
    customType: { text: "单行文本", image: "单图上传", images: "多图上传", file: "单附件上传", files: "多附件上传" },
    customDefalut: {
        text: {
            maxlength: 20,
            default: ''
        },
        image: {
            allowFormat: [],
            maxFileSize: 1024,
            default: ''
        }
    }
})



let val:any|any[]
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
