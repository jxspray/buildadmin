<!--
 * @Author: jxspray_D 1532946322@qq.com
 * @Date: 2023-08-27 17:44:23
 * @LastEditors: jxspray_D 1532946322@qq.com
 * @LastEditTime: 2023-08-27 20:52:47
 * @FilePath: \web\src\views\backend\cms\slide\index.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <!-- 自定义按钮请使用插槽，甚至公共搜索也可以使用具名插槽渲染，参见文档 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('cms.slide.quick Search Fields') })"
        ></TableHeader>

        <!-- 表格 -->
        <!-- 表格列有多种自定义渲染方式，比如自定义组件、具名插槽等，参见文档 -->
        <!-- 要使用 el-table 组件原有的属性，直接加在 Table 标签上即可 -->
        <Table ref="tableRef"></Table>

        <!-- 表单 -->
        <PopupForm />
    </div>
</template>

<script setup lang="ts">
import { ref, provide, onMounted } from 'vue'
import baTableClass from '/@/utils/baTable'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'

const router = useRouter()

defineOptions({
    name: 'cms/slide',
})

const { t } = useI18n()
const tableRef = ref()

let optButtons: OptButton[] = [
    {
        render: 'tipButton',
        name: 'picMange',
        title: '图册管理',
        text: '图册管理',
        type: 'primary',
        icon: '',
        class: 'table-row-info',
        disabledTip: false,
        click: (row: TableRow) => {
            router.push({ name: 'cms/slide/data', query: { slide_id: row[baTable.table.pk!] } })
        },
    }
]
optButtons = optButtons.concat(defaultOptButtons(['edit', 'delete']))

/**
 * baTable 内包含了表格的所有数据且数据具备响应性，然后通过 provide 注入给了后代组件
 */
const baTable = new baTableClass(
    new baTableApi('/admin/cms.Slide/'),
    {
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('cms.slide.id'), prop: 'id', align: 'center', width: 70, operator: 'RANGE', sortable: 'custom' },
            { label: t('cms.slide.name'), prop: 'name', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
            { label: t('cms.slide.remark'), prop: 'remark', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE' },

            { label: t('cms.slide.status'), prop: 'status', align: 'center', render: 'tag', operator: 'eq', sortable: false, replaceValue: { '0': t('cms.slide.status 0'), '1': t('cms.slide.status 1') } },
            { label: t('cms.slide.groups'), prop: 'groups', align: 'center', operatorPlaceholder: t('Fuzzy query'), render: 'customTemplate', customTemplate: (row: TableRow, field: TableColumn, value: any, column: TableColumnCtx<TableRow>, index: number) => {
                var str = ''
                for (let i = 0; i < value.length; i++) {
                    str += `<span class="el-tag el-tag--default el-tag--light"><span class="el-tag__content">${value[i].name}:${value[i].width}*${value[i].height}</span></span>`
                }
                return str;
            }, operator: false },
            { label: t('cms.slide.create_time'), prop: 'create_time', align: 'center', render: 'datetime', operator: 'RANGE', sortable: 'custom', width: 160, timeFormat: 'yyyy-mm-dd hh:MM:ss' },
            { label: t('cms.slide.update_time'), prop: 'update_time', align: 'center', render: 'datetime', operator: 'RANGE', sortable: 'custom', width: 160, timeFormat: 'yyyy-mm-dd hh:MM:ss' },
            
            { label: t('Operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined],
    },
    {
        defaultItems: { name: null, remark: null, width: 0, height: 0, status: '1', groups: [], delete_time: null, extends: [] },
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

<style scoped lang="scss"></style>
