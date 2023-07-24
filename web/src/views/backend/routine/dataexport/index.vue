<template>
    <div class="default-main ba-table-box">
        <el-alert class="ba-table-alert" v-if="baTable.table.remark" :title="baTable.table.remark" type="info" show-icon />

        <!-- 表格顶部菜单 -->
        <TableHeader
            :buttons="['refresh', 'add', 'edit', 'delete', 'comSearch', 'quickSearch', 'columnDisplay']"
            :quick-search-placeholder="t('Quick search placeholder', { fields: t('routine.dataexport.quick Search Fields') })"
        />

        <!-- 表格 -->
        <!-- 要使用`el-table`组件原有的属性，直接加在Table标签上即可 -->
        <Table ref="tableRef" />

        <!-- 表单 -->
        <PopupForm ref="formRef" />
    </div>
</template>

<script setup lang="ts">
import { ref, provide, onMounted, toRaw } from 'vue'
import baTableClass from '/@/utils/baTable'
import { defaultOptButtons } from '/@/components/table'
import { baTableApi } from '/@/api/common'
import { useI18n } from 'vue-i18n'
import PopupForm from './popupForm.vue'
import Table from '/@/components/table/index.vue'
import TableHeader from '/@/components/table/header/index.vue'
import { add } from '/@/api/backend/routine/dataexport'
import { ElNotification } from 'element-plus'
import { ValidateFieldsError } from 'async-validator'
import { buildDownloadUrl, getTest, getStart } from '/@/api/backend/routine/dataexport'
import { useRouter } from 'vue-router'

const { t } = useI18n()
const formRef = ref()
const tableRef = ref()
const router = useRouter()
let optButtons: OptButton[] = [
    {
        render: 'confirmButton',
        name: 'test',
        title: 'routine.dataexport.test',
        text: '',
        type: 'primary',
        icon: 'fa fa-wrench',
        class: 'table-row-test',
        popconfirm: {
            confirmButtonText: t('Confirm'),
            cancelButtonText: t('Cancel'),
            confirmButtonType: 'primary',
            width: '180px',
            title: '将导出前10条数据，请目检数据是否正常且完整',
        },
        disabledTip: false,
        click: (row: TableRow) => {
            getTest(row['id']).then((res) => {
                window.location.href = buildDownloadUrl(res.data.taskId)
            })
        },
    },
    {
        render: 'confirmButton',
        name: 'export',
        title: 'routine.dataexport.export',
        text: '',
        type: 'danger',
        icon: 'fa fa-play-circle',
        class: 'table-row-export',
        popconfirm: {
            confirmButtonText: t('Confirm'),
            cancelButtonText: t('Cancel'),
            confirmButtonType: 'danger',
            width: '200px',
            title: '导出为高磁盘I/O操作，大数据导出任务请在闲时执行，确认开始导出任务吗？',
        },
        disabledTip: false,
        click: (row: TableRow) => {
            getStart(row['id']).then((res) => {
                if (res.data.download) {
                    window.location.href = buildDownloadUrl(res.data.id)
                } else {
                    router.push({ name: 'routine/dataexport/taskControl', params: { id: res.data.id } })
                }
            })
        },
    },
]
optButtons = optButtons.concat(defaultOptButtons(['edit', 'delete']))

const baTable = new baTableClass(
    new baTableApi('/admin/routine.dataexport/'),
    {
        pk: 'id',
        column: [
            { type: 'selection', align: 'center', operator: false },
            { label: t('routine.dataexport.id'), prop: 'id', align: 'center', width: 70, sortable: 'custom', operator: 'RANGE' },
            { label: t('routine.dataexport.admin_id'), prop: 'admin.nickname', operator: 'LIKE', align: 'center' },
            { label: t('routine.dataexport.name'), prop: 'name', align: 'center' },
            { label: t('routine.dataexport.main_table'), prop: 'main_table', align: 'center' },
            { label: t('routine.dataexport.lastprogress'), prop: 'lastprogress', align: 'center', operator: 'RANGE' },
            {
                label: t('routine.dataexport.lastexporttime'),
                prop: 'lastexporttime',
                align: 'center',
                render: 'datetime',
                sortable: 'custom',
                operator: 'RANGE',
                width: 160,
            },
            { label: t('routine.dataexport.lastfile'), prop: 'lastfile', align: 'center', operator: false, render: 'url' },
            {
                label: t('routine.dataexport.createtime'),
                prop: 'createtime',
                align: 'center',
                render: 'datetime',
                sortable: 'custom',
                operator: 'RANGE',
                width: 160,
            },
            { label: t('Operate'), align: 'center', width: 160, render: 'buttons', buttons: optButtons, operator: false },
        ],
        dblClickNotEditColumn: [undefined],
        defaultOrder: { prop: 'id', order: 'desc' },
    },
    {
        defaultItems: { xls_max_number: '10000', concurrent_create_xls: '3', memory_limit: '128', lastprogress: '0' },
    },
    {
        // 添加前获取数据表
        toggleForm: ({ operate }) => {
            if (operate == 'Add') {
                baTable.form.loading = true
                add().then((res) => {
                    baTable.form.extend!['tables'] = res.data.tables
                    baTable.form.loading = false
                    baTable.form.items!.joinTableNumber = 0
                    baTable.form.items!.joinTable = []
                    baTable.form.items!.joinTableAsName = []
                    baTable.form.items!.joinTableFields = []
                    baTable.form.items!.joinTablePk = []
                    baTable.form.items!.joinTableFk = []
                    baTable.form.items!.joinTableType = []
                })
            }
        },
        onSubmit: ({ formEl, operate, items }) => {
            const fields: anyObj = []
            for (const key in items.fields) {
                fields.push(baTable.form.extend!.fieldSelect[items.fields[key]])
            }
            const joinTable: anyObj = []
            for (const key in items.joinTable) {
                if (key == baTable.form.items!.joinTableNumber) {
                    break
                }
                const joinTableField: anyObj = []
                for (const fkey in items.joinTableFields[key]) {
                    joinTableField.push(toRaw(baTable.form.extend!.joinTableFieldSelect[key][items.joinTableFields[key][fkey]]))
                }
                joinTable[key] = {
                    table: items.joinTable[key],
                    pk: items.joinTablePk[key],
                    fk: items.joinTableFk[key],
                    asname: items.joinTableAsName[key],
                    fields: joinTableField,
                    type: items.joinTableType[key],
                }
            }

            // 表单验证通过后执行的api请求操作
            operate = operate.replace(operate[0], operate[0].toLowerCase())
            const submitCallback = () => {
                baTable.form.submitLoading = true
                baTable.api
                    .postData(operate, {
                        id: baTable.form.items!.id,
                        name: baTable.form.items!.name,
                        main_table: baTable.form.items!.main_table,
                        field_config: fields,
                        join_table: joinTable,
                        where_field: toRaw(baTable.form.items!.where),
                        order_field: toRaw(baTable.form.items!.order),
                        xls_max_number: baTable.form.items!.xls_max_number,
                        concurrent_create_xls: baTable.form.items!.concurrent_create_xls,
                        memory_limit: baTable.form.items!.memory_limit,
                        export_number: baTable.form.items!.export_number,
                    })
                    .then((res) => {
                        baTable.onTableHeaderAction('refresh', {})
                        baTable.form.submitLoading = false
                        baTable.form.operateIds?.shift()
                        if (baTable.form.operateIds!.length > 0) {
                            baTable.toggleForm('Edit', baTable.form.operateIds)
                        } else {
                            baTable.toggleForm()
                        }
                        baTable.runAfter('onSubmit', { res })
                    })
                    .catch(() => {
                        baTable.form.submitLoading = false
                    })
            }

            if (formEl) {
                baTable.form.ref = formEl
                formEl.validate((valid, invalidFields?: ValidateFieldsError) => {
                    if (valid) {
                        submitCallback()
                    } else {
                        for (const key in invalidFields) {
                            ElNotification({
                                message: invalidFields[key][0].message,
                                type: 'error',
                            })
                        }
                    }
                })
            } else {
                submitCallback()
            }
            return false
        },
    },
    {
        requestEdit: ({ res }) => {
            baTable.form.extend!['tables'] = res.data.tables
            baTable.form.extend!.onTableChangeCallback = () => {
                const fields: anyObj = []
                for (const key in res.data.row.field_config) {
                    fields.push(res.data.row.field_config[key].name)
                    for (const fkey in baTable.form.extend!.fieldSelect) {
                        if (baTable.form.extend!.fieldSelect[fkey].name == res.data.row.field_config[key].name) {
                            baTable.form.extend!.fieldSelect[fkey] = res.data.row.field_config[key]
                        }
                    }
                }
                baTable.form.items!.fields = fields
            }
            formRef.value.onTableChange(res.data.row['main_table'])
            baTable.form.items!.joinTableNumber = res.data.row.join_table.length
            baTable.form.items!.joinTable = []
            baTable.form.items!.joinTableAsName = []
            baTable.form.items!.joinTableFields = []
            baTable.form.items!.joinTablePk = []
            baTable.form.items!.joinTableFk = []
            baTable.form.items!.joinTableType = []
            baTable.form.items!.onJoinTableChangeCallback = []
            for (const key in res.data.row.join_table) {
                baTable.form.items!.joinTable.push(res.data.row.join_table[key].table)
                baTable.form.items!.joinTableAsName.push(res.data.row.join_table[key].asname)
                baTable.form.items!.joinTablePk.push(res.data.row.join_table[key].pk)
                baTable.form.items!.joinTableFk.push(res.data.row.join_table[key].fk)
                baTable.form.items!.joinTableType.push(res.data.row.join_table[key].type)
                formRef.value.onJoinTableChange(res.data.row.join_table[key].table, key)
                baTable.form.items!.onJoinTableChangeCallback[key] = () => {
                    const fields: anyObj = []
                    for (const jKey in res.data.row.join_table[key].fields) {
                        fields.push(res.data.row.join_table[key].fields[jKey].name)
                        for (const jfkey in baTable.form.extend!.joinTableFieldSelect[key]) {
                            if (baTable.form.extend!.joinTableFieldSelect[key][jfkey].name == res.data.row.join_table[key].fields[jKey].name) {
                                baTable.form.extend!.joinTableFieldSelect[key][jfkey] = res.data.row.join_table[key].fields[jKey]
                            }
                        }
                    }
                    baTable.form.items!.joinTableFields[key] = fields
                }
            }
            baTable.form.items!.where = res.data.row.where_field
            const where: anyObj = []
            for (const key in baTable.form.items!.where) {
                where.push(baTable.form.items!.where[key].field)
            }
            baTable.form.items!.where_field = where

            baTable.form.items!.order = res.data.row.order_field
            const order: anyObj = []
            for (const key in baTable.form.items!.order) {
                order.push(baTable.form.items!.order[key].field)
            }
            baTable.form.items!.order_field = order
        },
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

defineOptions({
    name: 'routine/dataexport',
})
</script>

<style scoped lang="scss"></style>
