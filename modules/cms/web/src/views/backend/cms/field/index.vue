<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('quick Search Placeholder', { fields: t('routine.cms.field.quick Search Fields') })"
            @action="baTable.onTableHeaderAction"
        />

        <!-- 表格 -->
        <!-- 要使用`el-table`组件原有的属性，直接加在Table标签上即可 -->
        <Table ref="tableRef" @action="baTable.onTableAction" />

        <!-- 表单 -->
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { ref, provide, onMounted } from 'vue'
import baTableClass from '/@/utils/baTable'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'

const { t } = useI18n()
const tableRef = ref()
const optButtons = defaultOptButtons(["edit","delete"])
const baTable = new baTableClass(
    new baTableApi('/admin/cms.field/'),
    {
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('routine.cms.field.id'), prop: 'id', align: 'center', width: 70, sortable: 'custom', operator: 'RANGE' },
            { label: t('routine.cms.field.module_id'), prop: 'module_id', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.field.field'), prop: 'field', align: 'center' },
            { label: t('routine.cms.field.name'), prop: 'name', align: 'center' },
            { label: t('routine.cms.field.required'), prop: 'required', align: 'center', render: 'tag', replaceValue: { 0: t('routine.cms.field.required 0'), 1: t('routine.cms.field.required 1') } },
            { label: t('routine.cms.field.errormsg'), prop: 'errormsg', align: 'center' },
            { label: t('routine.cms.field.type'), prop: 'type', align: 'center' },
            { label: t('routine.cms.field.issole'), prop: 'issole', align: 'center', render: 'tag', replaceValue: { 0: t('routine.cms.field.issole 0'), 1: t('routine.cms.field.issole 1') } },
            { label: t('routine.cms.field.listorder'), prop: 'listorder', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.field.status'), prop: 'status', align: 'center', render: 'tag', replaceValue: { 0: t('routine.cms.field.status 0'), 1: t('routine.cms.field.status 1') } },
            { label: t('routine.cms.field.issystem'), prop: 'issystem', align: 'center', render: 'tag', replaceValue: { 0: t('routine.cms.field.issystem 0'), 1: t('routine.cms.field.issystem 1') } },
            { label: t('routine.cms.field.description'), prop: 'description', align: 'center' },
            { label: t('operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined, ],
        defaultOrder: { prop: 'id', order: 'desc' },
    },
    {
        defaultItems: {"module_id":"0","required":"0","issole":"0","listorder":"0","status":"1","issystem":"0"},
    }
)

provide('baTable', baTable)

onMounted(() => {
    baTable.table.ref = tableRef.value
    baTable.mount()
    baTable.getIndex()?.then(() => {
        baTable.initSort()
        baTable.dragSort()
    })
})
</script>

<script lang="ts">
import { defineComponent } from 'vue'
export default defineComponent({
    name: 'routine/cms/field',
})
</script>

<style scoped lang="scss"></style>
