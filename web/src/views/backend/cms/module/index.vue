<!--
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-08-11 11:16:59
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-08-14 15:02:24
 * @FilePath: \web\src\views\backend\cms\module\index.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('cms.module.quick Search Fields') })"
        />

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
import { useRouter } from 'vue-router'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'


const router = useRouter()
defineOptions({
    name: 'cms/module',
})

const { t } = useI18n()
const tableRef = ref()

let optButtons: OptButton[] = [
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
optButtons = optButtons.concat(defaultOptButtons(["edit", "delete", "weigh-sort"]))
const baTable = new baTableClass(
    new baTableApi('/admin/cms.module/'),
    {
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('cms.module.id'), prop: 'id', align: 'center', width: 70, sortable: 'custom', operator: 'RANGE' },
            { label: t('cms.module.name'), prop: 'name', align: 'center' },
            { label: t('cms.module.title'), prop: 'title', align: 'center' },
            { label: t('cms.module.description'), prop: 'description', align: 'center' },
            { label: t('cms.module.type'), prop: 'type', align: 'center', render: 'tag', replaceValue: { 0: t('cms.module.type 0'), 1: t('cms.module.type 1'), 2: t('cms.module.type 2') } },
            { label: t('cms.module.weigh'), prop: 'weigh', align: 'center', sortable: 'custom', operator: false },
            { label: t('cms.module.status'), prop: 'status', align: 'center', render: 'tag', replaceValue: { 1: t('cms.module.status 1'), 0: t('cms.module.status 0') } },
            { label: t('Operate'), align: 'center', width: 140, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined],
        defaultOrder: { prop: 'weigh', order: 'desc' },
    },
    {
        defaultItems: {
            "type": "0",
            "status": "1",
            "template": "basics"
        },
    }
)

baTable.mount()
baTable.getIndex()

provide('baTable', baTable)
</script>

<style scoped lang="scss"></style>
