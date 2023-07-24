<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('quick Search Placeholder', { fields: t('cms.module.quick Search Fields') })"
            @action="baTable.onTableHeaderAction"
        >
        </TableHeader>

        <!-- 表格 -->
        <!-- 要使用`el-table`组件原有的属性，直接加在Table标签上即可 -->
        <Table ref="tableRef" @action="baTable.onTableAction" />

        <!-- 表单 -->
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { ref, provide, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import baTableClass from '/@/utils/baTable'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'


const { t } = useI18n()
const tableRef = ref()
const router = useRouter()
let optButtons: {
    name: string;
    icon: string;
    text: string;
    title: string;
    type: string;
    render: string;
    class: string;
    click: (row: TableRow) => void;
    disabledTip: boolean
}[] = [
    {
        render: 'tipButton',
        name: 'fields',
        title: '字段管理',
        text: '字段管理',
        type: 'primary',
        icon: '',
        class: 'table-row-info',
        disabledTip: false,
        click: (row: TableRow) => {
            router.push({ name: 'cms/fields', query: { module_id: row[baTable.table.pk!] } })
        },
    }
]



optButtons = optButtons.concat(defaultOptButtons(["weigh-sort","edit","delete"]))
const baTable = new baTableClass(
    new baTableApi('/admin/cms.module/'),
    {
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('cms.module.id'), prop: 'id', align: 'center', width: 70, sortable: 'custom', operator: 'RANGE' },
            { label: t('cms.module.name'), prop: 'name', align: 'center' },
            { label: t('cms.module.title'), prop: 'title', align: 'center' },
            { label: t('cms.module.description'), prop: 'description', align: 'center' },
            { label: t('cms.module.type'), prop: 'type', align: 'center', render: 'tag', replaceValue: { 1: t('cms.module.type 1'), 2: t('cms.module.type 2') } },
            // { label: t('cms.module.issystem'), prop: 'issystem', align: 'center', render: 'tag', replaceValue: { 1: t('cms.module.issystem 1'), 0: t('cms.module.issystem 0') } },
            // { label: t('cms.module.issearch'), prop: 'issearch', align: 'center', render: 'tag', replaceValue: { 1: t('cms.module.issearch 1'), 0: t('cms.module.issearch 0') } },
            // { label: t('cms.module.listfields'), prop: 'listfields', align: 'center' },
            { label: t('cms.module.weigh'), prop: 'weigh', align: 'center', sortable: 'custom', operator: false },
            { label: t('cms.module.status'), prop: 'status', align: 'center', render: 'tag', replaceValue: { 1: t('cms.module.status 1'), 0: t('cms.module.status 0') } },
            { label: t('operate'), align: 'center', width: 140, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined, ],
        defaultOrder: { prop: 'weigh', order: 'desc' },
    },
    {
        defaultItems: {"template":"empty","type":"1","issystem":"1","issearch":"1","status":"1","generate": {
            "table": {
                "name": "",
                "comment": "",
                "quickSearchField": [
                    "id"
                ],
                "defaultSortField": "id",
                "formFields": [],
                "columnFields": [
                    "id"
                ],
                "defaultSortType": "desc",
                "generateRelativePath": "",
                "isCommonModel": 0,
                "modelFile": "",
                "controllerFile": "",
                "validateFile": "",
                "webViewsDir": ""
            },
            "fields": [
                {
                    "title": "主键",
                    "name": "id",
                    "comment": "ID",
                    "designType": "pk",
                    "formBuildExclude": "1",
                    "table": {
                        "width": "70",
                        "operator": "RANGE",
                        "sortable": "custom"
                    },
                    "form": [],
                    "type": "int",
                    "length": "10",
                    "precision": "0",
                    "default": "",
                    "null": "",
                    "primaryKey": "1",
                    "unsigned": "1",
                    "autoIncrement": "1"
                }
            ]
        }},
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
import baTable from '/@/utils/baTable'
import { fa } from 'element-plus/es/locale'
export default defineComponent({
    name: 'routine/cms/module',
})
</script>

<style scoped lang="scss"></style>
