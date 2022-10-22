<template>
    <el-form
        ref="formRef"
        @keyup.enter="baTable.onSubmit(formRef)"
        :model="formSetup"
        label-position="right"
        :label-width="baTable.form.labelWidth + 'px'"
        :rules="rules"
    >
    <template v-if="baTable.form.items!.type == 'title'">
        <FormItem :label="t('cms.fields.maxlength')" type="number" prop="maxlength" v-model.number="formSetup!.maxlength" :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('cms.fields.maxlength') }) }" />
    </template>
    </el-form>
</template>

<script setup lang="ts">
import { reactive, ref, inject, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'
import type { ElForm, FormItemRule } from 'element-plus'


const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass

const customType = { title: '标题' }
const customDefalut = {
    title: {
        maxlength: 20
    }
}

let formSetup = {}
function isValidKey(key: string | number | symbol , object: object): key is keyof typeof object {
  return key in object;
}
if (baTable.form.items!.type && isValidKey(baTable.form.items!.type, customDefalut)) {
    formSetup = customDefalut[baTable.form.items!.type]
}

const { t } = useI18n()
const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    
})



watch(
    () => formSetup,
    (newVal) => {
        baTable.form.items!.setup = newVal
    }
)

</script>


<style scoped lang="scss"></style>
