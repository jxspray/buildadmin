<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('quick Search Placeholder', { fields: t('cms.fields.quick Search Fields') })"
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
import { useRoute } from 'vue-router'
const route = useRoute()

const { t } = useI18n()
const tableRef = ref()
const optButtons = defaultOptButtons(["weigh-sort","edit","delete"])
const baTable = new baTableClass(
    new baTableApi('/admin/cms.fields/'),
    {
        filter: { moduleid: route.query.id },
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            // { label: t('cms.fields.id'), prop: 'id', align: 'center', width: 70, sortable: 'custom', operator: 'RANGE' },
            { label: t('cms.module.title'), prop: 'module.title', align: 'center', operator: 'RANGE' },
            { label: t('cms.fields.field'), prop: 'field', align: 'center' },
            { label: t('cms.fields.name'), prop: 'name', align: 'center' },
            { label: t('cms.fields.type'), prop: 'type', align: 'center' },
            { label: t('cms.fields.status'), prop: 'status', align: 'center', render: 'tag', replaceValue: { 0: t('cms.fields.status 0'), 1: t('cms.fields.status 1') } },
            { label: t('operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined, ],
        defaultOrder: { prop: 'id', order: 'desc' },
    },
    {
        defaultItems: {"moduleid":route.query.id,"status":"1"},
        // defaultItems: {"moduleid":"0","required":"0","issole":"0","listorder":"0","status":"1","issystem":"0"},
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
    name: 'cms/field',
})
</script>

<style scoped lang="scss"></style>
