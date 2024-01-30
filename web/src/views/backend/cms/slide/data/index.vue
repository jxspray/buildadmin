<!--
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-08-28 09:58:54
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-09-19 11:26:31
 * @FilePath: \web\src\views\backend\cms\slide\data\index.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <!-- 自定义按钮请使用插槽，甚至公共搜索也可以使用具名插槽渲染，参见文档 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('cms.slide.data.quick Search Fields') })"
        ></TableHeader>

        <!-- 表格 -->
        <!-- 表格列有多种自定义渲染方式，比如自定义组件、具名插槽等，参见文档 -->
        <!-- 要使用 el-table 组件原有的属性，直接加在 Table 标签上即可 -->
        <Table ref="tableRef"></Table>

        <!-- 表单 -->
        <PopupForm :slide="state.slide" :groupList="state.groupList" />
    </div>
</template>

<script setup lang="ts">
import {ref, provide, onMounted, reactive} from 'vue'
import baTableClass from '/@/utils/baTable'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import { useRoute } from 'vue-router'
import createAxios from "/@/utils/axios";
const route = useRoute()
interface Groups {name: string, width: number, height: number}
interface Slide {id: number, name: string, groups: Groups[], extends: {[key: string]: any}}
const state: {
	slide: Slide
	groupList: Groups[]
} = reactive({
    slide: {id: 0, name: "", groups:[], extends: {}},
	groupList: []
})

defineOptions({
    name: 'cms/slide/data'
})

const { t } = useI18n()
const tableRef = ref()
const optButtons: OptButton[] = defaultOptButtons(['edit', 'delete'])

/**
 * baTable 内包含了表格的所有数据且数据具备响应性，然后通过 provide 注入给了后代组件
 */
const baTable = new baTableClass(
    new baTableApi('/admin/cms.slide.Data/'),
    {
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('cms.slide.data.id'), prop: 'id', align: 'center', width: 70, operator: 'RANGE', sortable: 'custom' },
            { label: t('cms.slide.data.slide__name'), prop: 'slide.name', align: 'center', operatorPlaceholder: t('Fuzzy query'), render: 'tags', operator: 'LIKE' },
            { label: t('cms.slide.data.title'), prop: 'title', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
            { label: t('cms.slide.data.cdn_image'), prop: 'image', align: 'center', render: 'image', sortable: false },
            { label: t('cms.slide.data.remark'), prop: 'remark', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
            { label: t('cms.slide.data.width'), prop: 'width', align: 'center', operator: 'RANGE', sortable: false },
            { label: t('cms.slide.data.height'), prop: 'height', align: 'center', operator: 'RANGE', sortable: false },
            { label: t('cms.slide.data.status'), prop: 'status', align: 'center', render: 'tag', operator: 'eq', sortable: false, replaceValue: { '0': t('cms.slide.data.status 0'), '1': t('cms.slide.data.status 1') } },
            { label: t('cms.slide.data.group'), prop: 'group', align: 'center', operatorPlaceholder: t('Fuzzy query'), operator: 'LIKE', sortable: false },
            { label: t('cms.slide.data.create_time'), prop: 'create_time', align: 'center', render: 'datetime', operator: 'RANGE', sortable: 'custom', width: 160, timeFormat: 'yyyy-mm-dd hh:MM:ss' },
            { label: t('cms.slide.data.update_time'), prop: 'update_time', align: 'center', render: 'datetime', operator: 'RANGE', sortable: 'custom', width: 160, timeFormat: 'yyyy-mm-dd hh:MM:ss' },
            { label: t('Operate'), align: 'center', width: 100, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined],
        filter: { slide_id: route.query.slide_id },
    },
    {
        defaultItems: { slide_id: route.query.slide_id, title: null, remark: null, width: 0, height: 0, status: '1', group: null, extends: {} },
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
	createAxios(
		{
			url: '/admin/cms.Slide/edit',
			method: 'get',
			params: { id: route.query.slide_id },
		},
		{
			showSuccessMessage: false,
		}
	).then((res: any) => {
		state.slide = res.data.row
		state.groupList = state.slide.groups
		if (state.groupList.length === 0) state.groupList =  [{ name: '通用', width: 0, height: 0 }]
		state.slide.extends.map((item: any) => {
			baTable.form.defaultItems!.extends[item.field] = item.type.value
		})
	})
})
</script>

<style scoped lang="scss"></style>
