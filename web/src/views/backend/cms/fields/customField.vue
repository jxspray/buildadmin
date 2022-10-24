<template>
    <FormItem :label="t('cms.fields.type')" type="select" v-model="baTable.form.items!.type" prop="type" :data="{ content: form.customType }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.fields.type') }) }" />
    <template v-if="baTable.form.items!.type == 'title'">
        <FormItem
            :label="t('cms.fields.maxlength')"
            type="number"
            prop="maxlength"
            v-model="form.setup!.maxlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.fields.maxlength') }) }"
        />
    </template>
</template>

<script setup lang="ts">
import { reactive, inject, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'

const baTable = inject('baTable') as baTableClass

const form: {
    setup: any|any[],
    customType: any|any[],
    customDefalut: any|any[]
} = reactive({
    setup: baTable.form.items!.setup,
    customType: { title: '标题', text: "单行文本" },
    customDefalut: {
        title: {
            maxlength: 20
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
    console.log(setup);
    baTable.form.items!.setup = form.setup = setup
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
