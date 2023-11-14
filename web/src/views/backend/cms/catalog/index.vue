<template>
  <div class="default-main ba-table-box">
    <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon/>

    <!-- 表格顶部菜单 -->
    <TableHeader
        :buttons="['refresh', 'add', 'edit', 'delete', 'unfold', 'quickSearch', 'columnDisplay']"
        :quick-search-placeholder="t('Quick search placeholder', { fields: t('cms.catalog.title') })"
    />

    <!-- 表格 -->
    <!-- 要使用`el-table`组件原有的属性，直接加在Table标签上即可 -->
    <Table ref="tableRef" :pagination="false"/>

    <!-- 表单 -->
    <PopupForm/>
  </div>
</template>

<script setup lang="ts">
import {ref, provide, onMounted} from 'vue'
import baTableClass from '/@/utils/baTable'
import {defaultOptButtons} from '/@/components/table'
import {baTableApi} from '/@/api/common'
import {useI18n} from 'vue-i18n'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import createAxios from "/@/utils/axios";

const {t} = useI18n()
const tableRef = ref()
const optButtons = defaultOptButtons(["weigh-sort", "edit", "delete"])
const baTable = new baTableClass(
    new baTableApi('/admin/cms.catalog/'),
    {
      expandAll: true,
      column: [
        {type: 'selection', align: 'center', operator: false},
        {label: t('cms.catalog.title'), prop: 'title', align: 'left', width: 200},
        {label: t('cms.catalog.module'), prop: 'module_name', width: 100, align: 'center'},
        {label: t('cms.catalog.show'), prop: 'show', render: 'tag', replaceValue: {0: '不显示', 1: '都显示', 2: '头部显示', 3: '底部显示'}, width: 100, align: 'left'},
        {label: t('cms.catalog.id'), prop: 'id', align: 'center', width: 100, operator: 'RANGE'},
        {label: t('State'), prop: 'status', align: 'center', render: 'tag', custom: {0: 'danger', 1: 'success'}, replaceValue: {0: t('Disable'), 1: t('Enable')},},
        {label: t('Operate'), align: 'center', width: 140, render: 'buttons', buttons: optButtons, operator: false},
      ],
      dblClickNotEditColumn: [undefined, 'status'],
      // defaultOrder: { prop: 'weigh', order: 'desc' },
      dragSortLimitField: 'pid',
    },
    {
      defaultItems: {"pid": 0, "module_id": 0, "field": [], "weigh": "0", "links_type": "0", "links_value": {}, "blank": "0", "show": "1", "status": "1"},
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

<style lang="scss">
.el-dialog.is-fullscreen {
  overflow: unset;
}

.el-overlay-dialog {
  overflow: unset;
}
</style>
