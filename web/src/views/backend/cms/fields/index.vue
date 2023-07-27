<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('cms.fields.quick Search Fields') })" />

        <!-- 表格 -->
        <!-- 要使用`el-table`组件原有的属性，直接加在Table标签上即可 -->
        <Table ref="tableRef" />

        <!-- 表单 -->
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { ref, provide } from 'vue'
import baTableClass from '/@/utils/baTable'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'
const route = useRoute()

defineOptions({
    name: 'cms/fields',
})

const { t } = useI18n()
const tableRef = ref()
const baTable = new baTableClass(
    new baTableApi('/admin/cms.fields/'),
    {
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('cms.module.title'), prop: 'module.title', align: 'center', operator: 'RANGE' },
            { label: t('cms.fields.field'), prop: 'field', align: 'center' },
            { label: t('cms.fields.name'), prop: 'name', align: 'center' },
            { label: t('cms.fields.type'), prop: 'type', align: 'center' },
            { label: t('cms.fields.status'), prop: 'status', align: 'center', render: 'tag', replaceValue: { 0: t('cms.fields.status 0'), 1: t('cms.fields.status 1') } },
            { label: t('Operate'), align: 'center', width: 100, render: 'buttons', buttons: defaultOptButtons(["weigh-sort", "edit", "delete"]), operator: false },
        ],
        dblClickNotEditColumn: [undefined],
    },
    {
        defaultItems: { "module_id": route.query.module_id, "status": "1",
            "comment": "test" },
    }
)

baTable.mount()
baTable.getIndex()

provide('baTable', baTable)
</script>

<style scoped lang="scss"></style>
