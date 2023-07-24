<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('quick Search Placeholder', { fields: t('routine.cms.catalog.quick Search Fields') })"
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
const optButtons = defaultOptButtons(["weigh-sort","edit","delete"])
const baTable = new baTableClass(
    new baTableApi('/admin/cms.content/'),
    {
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('routine.cms.catalog.id'), prop: 'id', align: 'center', width: 70, sortable: 'custom', operator: 'RANGE' },
            { label: t('routine.cms.catalog.pid'), prop: 'pid', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.num'), prop: 'num', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.level'), prop: 'level', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.group_id'), prop: 'group_id', align: 'center' },
            { label: t('routine.cms.catalog.title'), prop: 'title', align: 'center' },
            { label: t('routine.cms.catalog.description'), prop: 'description', align: 'center' },
            { label: t('routine.cms.catalog.template_list'), prop: 'template_list', align: 'center', render: 'tag', replaceValue: { } },
            { label: t('routine.cms.catalog.template_info'), prop: 'template_info', align: 'center' },
            { label: t('routine.cms.catalog.seo_url'), prop: 'seo_url', align: 'center' },
            { label: t('routine.cms.catalog.seo_title'), prop: 'seo_title', align: 'center' },
            { label: t('routine.cms.catalog.seo_keywords'), prop: 'seo_keywords', align: 'center' },
            { label: t('routine.cms.catalog.seo_description'), prop: 'seo_description', align: 'center' },
            { label: t('routine.cms.catalog.links_type'), prop: 'links_type', align: 'center', render: 'tag', replaceValue: { 0: t('routine.cms.catalog.links_type 0'), 1: t('routine.cms.catalog.links_type 1') } },
            { label: t('routine.cms.catalog.weigh'), prop: 'weigh', align: 'center', sortable: 'custom', operator: false },
            { label: t('routine.cms.catalog.module'), prop: 'module', align: 'center' },
            { label: t('routine.cms.catalog.module_id'), prop: 'module_id', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.blank'), prop: 'blank', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.show'), prop: 'show', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.status'), prop: 'status', align: 'center', render: 'tag', replaceValue: { 0: t('routine.cms.catalog.status 0'), 1: t('routine.cms.catalog.status 1') } },
            { label: t('routine.cms.catalog.language'), prop: 'language', align: 'center' },
            { label: t('routine.cms.catalog.mobile'), prop: 'mobile', align: 'center', operator: 'RANGE' },
            { label: t('routine.cms.catalog.theme'), prop: 'theme', align: 'center' },
            { label: t('operate'), align: 'center', width: 140, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined, ],
        defaultOrder: { prop: 'weigh', order: 'desc' },
    },
    {
        defaultItems: [],
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
    name: 'routine/cms/content',
})
</script>

<style scoped lang="scss"></style>
