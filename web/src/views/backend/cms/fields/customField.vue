<template>
    <FormItem :label="t('cms.fields.type')" type="select" v-model="baTable.form.items!.type" prop="type" :data="{ content: customType }" :input-attr="{ placeholder: t('Please select field', { field: t('cms.fields.type') }) }" />
    <template v-if="baTable.form.items!.type == 'title'">
        <FormItem
            :label="t('cms.fields.maxlength')"
            type="number"
            prop="maxlength"
            v-model.number="baTable.form.items!.setup!.maxlength"
            :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.fields.maxlength') }) }"
        />
    </template>
</template>

<script setup lang="ts">
import { inject, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'

const baTable = inject('baTable') as baTableClass

const customType = { title: '标题' }
const customDefalut = new Map([
    ['title', new Map([
        ['maxlength', 20]
    ])]
])

let val:any|any[]
const getSetup = (type: string) => {
    if (customDefalut.has(type)) {
        val = customDefalut.get(type)
        if (!baTable.form.items!.setup) baTable.form.items!.setup = val
        else {
            val.forEach((value: any, key: string) => {
                !baTable.form.items!.setup[key] && (baTable.form.items!.setup[key] = value)
            });
        }
        console.log(baTable.form.items!.setup)
    }
}
getSetup(baTable.form.items!.type)

watch(
    () => baTable.form.items!.type,
    (newVal) => {
        getSetup(newVal)
    }
)

const { t } = useI18n()
</script>

<style scoped lang="scss"></style>
