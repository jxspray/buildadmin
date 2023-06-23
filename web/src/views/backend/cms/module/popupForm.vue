<template>
    <!-- 对话框表单 -->
    <el-dialog
        class="ba-design-dialog"
        :close-on-click-modal="false"
        :model-value="baTable.form.operate ? true : false"
        width="95%"
        top="5vh"
        @close="baTable.toggleForm"
    >
        <template #header>
            <div class="title" v-drag="['.ba-design-dialog', '.el-dialog__header']" v-zoom="'.ba-design-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
            <Design />
        </el-scrollbar>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm('')">{{ t('Cancel') }}</el-button>
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
import type { ElForm, FormItemRule } from 'element-plus'


import Design from './design.vue'


const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass
// baTable.api.actionUrl.set('createTemplateField', '/admin/cms.module/createTemplateField')
// baTable.after = {
//     onSubmit: function (res: any){
//         if (res.res.code == 1 && res.res.data?.id > 0) {
//             // 执行模板字段创建
//             baTable.api.postData('createTemplateField', { moduleid: res.res.data.id })
//         }
//     }
// }

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({})

</script>

<style scoped lang="scss"></style>
