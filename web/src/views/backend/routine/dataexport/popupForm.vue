<template>
    <div>
        <!-- 对话框表单 -->
        <el-dialog
            class="ba-operate-dialog"
            :close-on-click-modal="false"
            :model-value="baTable.form.operate ? true : false"
            @close="baTable.toggleForm"
            :destroy-on-close="true"
        >
            <template #header>
                <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                    {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
                </div>
            </template>
            <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
                <el-form
                    v-if="!baTable.form.loading"
                    ref="formRef"
                    @keyup.enter="baTable.onSubmit(formRef)"
                    :model="baTable.form.items"
                    label-position="top"
                    :rules="rules"
                >
                    <el-tabs class="config-tabs" @tab-change="onTabChange" v-model="state.tab">
                        <el-tab-pane label="基础配置" name="base">
                            <FormItem
                                :label="t('routine.dataexport.name')"
                                type="string"
                                v-model="baTable.form.items!.name"
                                prop="name"
                                :input-attr="{ placeholder: t('Please input field', { field: t('routine.dataexport.name') }) }"
                            />
                            <FormItem
                                :label="t('routine.dataexport.main_table')"
                                type="select"
                                v-model="baTable.form.items!.main_table"
                                prop="main_table"
                                :data="{ content: baTable.form.extend!.tables }"
                                :input-attr="{
                                    placeholder: t('Please select field', { field: t('routine.dataexport.main_table') }),
                                    onChange: onTableChange,
                                }"
                                v-loading="baTable.form.extend!.fieldLoading"
                            />
                            <FormItem
                                v-if="baTable.form.extend!.fieldSelectOpt"
                                label="导出字段"
                                type="selects"
                                v-model="baTable.form.items!.fields"
                                :key="baTable.form.extend!.fieldSelectKey"
                                prop="fields"
                                placeholder="请先选择导出数据源表，随后在此选择导出字段"
                                :data="{ content: baTable.form.extend!.fieldSelectOpt }"
                                v-loading="baTable.form.extend!.fieldLoading"
                            />
                            <el-row v-for="item in baTable.form.items!.fields" :key="item" class="field-row">
                                <el-col :span="4" class="field-title">
                                    <el-tooltip placement="top" :content="baTable.form.extend!.fieldSelect[item].name">
                                        <div>{{ baTable.form.extend!.fieldSelect[item].name }}:</div>
                                    </el-tooltip>
                                </el-col>
                                <el-col :span="4">
                                    <el-input
                                        type="text"
                                        placeholder="字段标题"
                                        v-model="baTable.form.extend!.fieldSelect[item].title"
                                        class="field-title-input"
                                    />
                                </el-col>
                                <el-col :span="3" class="field-title-input-title">数据识别:</el-col>
                                <el-col :span="4">
                                    <el-select v-model="baTable.form.extend!.fieldSelect[item].discern">
                                        <el-option label="文本" value="text" />
                                        <el-option label="数字" value="int" />
                                        <el-option label="时间日期" value="time" />
                                        <el-option label="值替换" value="valuation" />
                                    </el-select>
                                </el-col>
                                <el-col :span="3" class="field-title-input-title">
                                    <div v-if="baTable.form.extend!.fieldSelect[item].discern == 'valuation'">替换方案:</div>
                                </el-col>
                                <el-col :span="6">
                                    <div v-if="baTable.form.extend!.fieldSelect[item].discern == 'valuation'">
                                        <el-input
                                            type="text"
                                            placeholder="值替换方案"
                                            v-model="baTable.form.extend!.fieldSelect[item].comment"
                                            class="field-title-input"
                                        />
                                    </div>
                                </el-col>
                            </el-row>
                        </el-tab-pane>
                        <el-tab-pane label="关联表配置" name="join">
                            <FormItem label="关联表数量" type="number" v-model.number="baTable.form.items!.joinTableNumber" />
                            <div v-for="item in baTable.form.items!.joinTableNumber" :key="item" class="join-table-item">
                                <div class="form-hr"></div>
                                <el-form-item :label="'关联表' + item">
                                    <el-select
                                        class="w100"
                                        :placeholder="t('Please select field', { field: '关联表' + item })"
                                        v-model="baTable.form.items!.joinTable[item - 1]"
                                        @change="onJoinTableChange($event, item - 1)"
                                        v-loading="baTable.form.extend!.fieldLoading"
                                    >
                                        <el-option v-for="(table, tidx) in baTable.form.extend!.tables" :label="table" :value="tidx" :key="tidx" />
                                    </el-select>
                                </el-form-item>
                                <FormItem
                                    type="string"
                                    placeholder="非必填，设置别名后则源表可与关联表相同"
                                    label="关联表别名"
                                    v-model="baTable.form.items!.joinTableAsName[item - 1]"
                                />
                                <FormItem
                                    v-if="baTable.form.extend!.fieldSelectOpt"
                                    label="关联外键"
                                    type="select"
                                    v-model="baTable.form.items!.joinTableFk[item - 1]"
                                    :key="baTable.form.extend!.fieldSelectKey + 'fk'"
                                    :placeholder="'请先选择源表，随后在此关联外键'"
                                    :data="{ content: baTable.form.extend!.fieldSelectOpt }"
                                    v-loading="baTable.form.extend!.fieldLoading"
                                />
                                <FormItem
                                    v-if="baTable.form.extend!.joinTableFieldSelectOpt && baTable.form.extend!.joinTableFieldSelectOpt[item - 1]"
                                    label="关联主键"
                                    type="select"
                                    v-model="baTable.form.items!.joinTablePk[item - 1]"
                                    :key="baTable.form.extend!.joinTableFieldSelectKey[item - 1] + 'pk'"
                                    :placeholder="'请先选择关联表' + item + '，随后在此选择关联主键'"
                                    :data="{ content: baTable.form.extend!.joinTableFieldSelectOpt[item - 1] }"
                                    v-loading="baTable.form.extend!.fieldLoading"
                                />
                                <FormItem
                                    label="关联类型"
                                    type="select"
                                    v-model="baTable.form.items!.joinTableType[item - 1]"
                                    placeholder="请选择关联类型"
                                    :data="{
                                        content: {
                                            INNER: 'INNER - 至少一个匹配',
                                            LEFT: 'LEFT - 从左表返回所有行',
                                            RIGHT: 'RIGHT - 从右表返回所有行',
                                            FULL: 'FULL - 返回所有行',
                                        },
                                    }"
                                />
                                <FormItem
                                    v-if="baTable.form.extend!.joinTableFieldSelectOpt && baTable.form.extend!.joinTableFieldSelectOpt[item - 1]"
                                    label="导出字段"
                                    type="selects"
                                    v-model="baTable.form.items!.joinTableFields[item - 1]"
                                    :key="baTable.form.extend!.joinTableFieldSelectKey[item - 1]"
                                    :placeholder="'请先选择关联表' + item + '，随后在此选择该表的导出字段'"
                                    :data="{ content: baTable.form.extend!.joinTableFieldSelectOpt[item - 1] }"
                                    v-loading="baTable.form.extend!.fieldLoading"
                                />
                                <template v-if="baTable.form.items!.joinTableFields && baTable.form.items!.joinTableFields[item - 1]">
                                    <el-row v-for="field in baTable.form.items!.joinTableFields[item - 1]" :key="field" class="field-row">
                                        <el-col :span="4" class="field-title">
                                            <el-tooltip placement="top" :content="baTable.form.extend!.joinTableFieldSelect[item - 1][field].name">
                                                <div>{{ baTable.form.extend!.joinTableFieldSelect[item - 1][field].name }}:</div>
                                            </el-tooltip>
                                        </el-col>
                                        <el-col :span="4">
                                            <el-input
                                                type="text"
                                                placeholder="字段标题"
                                                v-model="baTable.form.extend!.joinTableFieldSelect[item - 1][field].title"
                                                class="field-title-input"
                                            />
                                        </el-col>
                                        <el-col :span="3" class="field-title-input-title">数据识别:</el-col>
                                        <el-col :span="4">
                                            <el-select v-model="baTable.form.extend!.joinTableFieldSelect[item - 1][field].discern">
                                                <el-option label="文本" value="text" />
                                                <el-option label="数字" value="int" />
                                                <el-option label="时间日期" value="time" />
                                                <el-option label="值替换" value="valuation" />
                                            </el-select>
                                        </el-col>
                                        <el-col :span="3" class="field-title-input-title">
                                            <div v-if="baTable.form.extend!.joinTableFieldSelect[item - 1][field].discern == 'valuation'">
                                                替换方案:
                                            </div>
                                        </el-col>
                                        <el-col :span="6">
                                            <div v-if="baTable.form.extend!.joinTableFieldSelect[item - 1][field].discern == 'valuation'">
                                                <el-input
                                                    type="text"
                                                    placeholder="值替换方案"
                                                    v-model="baTable.form.extend!.joinTableFieldSelect[item - 1][field].comment"
                                                    class="field-title-input"
                                                />
                                            </div>
                                        </el-col>
                                    </el-row>
                                </template>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane label="数据筛选配置" name="where">
                            <FormItem
                                v-if="baTable.form.extend!.allTableField"
                                label="筛选字段"
                                type="selects"
                                v-model="baTable.form.items!.where_field"
                                :placeholder="'请先选择源表和关联表，随后在此选择数据筛选字段'"
                                :data="{ content: baTable.form.extend!.allTableField }"
                                v-loading="baTable.form.extend!.fieldLoading"
                                :key="baTable.form.extend!.allTableFieldKey"
                                :input-attr="{ onChange: onWhereChange }"
                            />
                            <el-row v-for="item in baTable.form.items!.where" :key="item" :gutter="10" class="field-row">
                                <el-col :span="6" class="field-title">
                                    <el-tooltip placement="top" :content="item.field">
                                        <div>{{ item.field }}:</div>
                                    </el-tooltip>
                                </el-col>
                                <el-col :span="6">
                                    <el-select v-model="item.operator">
                                        <el-option label="等于" value="=" />
                                        <el-option label="不等于" value="<>" />
                                        <el-option label="大于" value=">" />
                                        <el-option label="大于等于" value=">=" />
                                        <el-option label="小于" value="<" />
                                        <el-option label="小于等于" value="<=" />
                                        <el-option label="LIKE" value="LIKE" />
                                        <el-option label="NOT LIKE" value="NOT LIKE" />
                                        <el-option label="IN" value="IN" />
                                        <el-option label="NOT IN" value="NOT IN" />
                                    </el-select>
                                </el-col>
                                <el-col :span="10">
                                    <div>
                                        <el-input type="text" placeholder="筛选值" v-model="item.value" class="field-title-input" />
                                    </div>
                                </el-col>
                            </el-row>
                            <div class="form-hr"></div>
                            <FormItem
                                v-if="baTable.form.extend!.allTableField"
                                label="排序字段"
                                type="selects"
                                v-model="baTable.form.items!.order_field"
                                :placeholder="'请先选择源表和关联表，随后在此选择数据排序字段'"
                                :data="{ content: baTable.form.extend!.allTableField }"
                                v-loading="baTable.form.extend!.fieldLoading"
                                :key="baTable.form.extend!.allTableFieldKey + 'order'"
                                :input-attr="{ onChange: onOrderChange }"
                            />
                            <el-row v-for="item in baTable.form.items!.order" :key="item" :gutter="10" class="field-row">
                                <el-col :span="6" class="field-title">
                                    <el-tooltip placement="top" :content="item.field">
                                        <div>{{ item.field }}:</div>
                                    </el-tooltip>
                                </el-col>
                                <el-col :span="6">
                                    <el-select v-model="item.value">
                                        <el-option label="倒序(从大到小)" value="DESC" />
                                        <el-option label="正序(从小到大)" value="ASC" />
                                    </el-select>
                                </el-col>
                            </el-row>
                        </el-tab-pane>
                        <el-tab-pane label="其他配置" name="other">
                            <FormItem
                                :label="t('routine.dataexport.xls_max_number')"
                                type="number"
                                prop="xls_max_number"
                                v-model.number="baTable.form.items!.xls_max_number"
                                :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.dataexport.xls_max_number') }) }"
                            />
                            <FormItem
                                :label="t('routine.dataexport.concurrent_create_xls')"
                                type="number"
                                prop="concurrent_create_xls"
                                v-model.number="baTable.form.items!.concurrent_create_xls"
                                :input-attr="{
                                    step: '1',
                                    placeholder: t('Please input field', { field: t('routine.dataexport.concurrent_create_xls') }),
                                }"
                            />
                            <FormItem
                                :label="t('routine.dataexport.memory_limit')"
                                type="number"
                                prop="memory_limit"
                                v-model.number="baTable.form.items!.memory_limit"
                                :input-attr="{ step: '1', placeholder: t('Please input field', { field: t('routine.dataexport.memory_limit') }) }"
                            />
                            <FormItem
                                :label="t('routine.dataexport.export_number')"
                                type="number"
                                prop="export_number"
                                v-model.number="baTable.form.items!.export_number"
                                :input-attr="{
                                    step: '1',
                                    placeholder:
                                        t('Please input field', { field: t('routine.dataexport.export_number') }) + '，留空或输入 0 则导出全部',
                                }"
                            />
                        </el-tab-pane>
                    </el-tabs>
                </el-form>
            </el-scrollbar>
            <template #footer>
                <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                    <el-button @click="baTable.toggleForm('')">{{ t('Cancel') }}</el-button>
                    <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)" type="primary">
                        {{ baTable.form.operateIds && baTable.form.operateIds.length > 1 ? t('Save and edit next item') : t('Save') }}
                    </el-button>
                </div>
            </template>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, inject } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'
import type { ElForm, FormItemRule, TabPaneName } from 'element-plus'
import { buildValidatorData } from '/@/utils/validate'
import { getFieldList } from '/@/api/backend/routine/dataexport'
import { uuid } from '/@/utils/random'

const formRef = ref<InstanceType<typeof ElForm>>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const state = reactive({
    tab: 'base',
})

const onTableChange = (val: string) => {
    baTable.form.extend!.fieldLoading = true
    getFieldList(val)
        .then((res) => {
            baTable.form.extend!.fieldSelect = res.data.fields
            const fields: anyObj = []
            const fieldSelectOpt: anyObj = []
            for (const key in res.data.fields) {
                fields.push(key)
                fieldSelectOpt[key] = res.data.fields[key].name + (res.data.fields[key].title ? ' - ' + res.data.fields[key].title : '')
            }
            baTable.form.extend!.fieldSelectOpt = fieldSelectOpt
            baTable.form.extend!.fieldSelectKey = uuid()
            baTable.form.items!.fields = fields
            if (typeof baTable.form.extend!.onTableChangeCallback == 'function') {
                baTable.form.extend!.onTableChangeCallback()
                baTable.form.extend!.onTableChangeCallback = null
            }
        })
        .finally(() => {
            baTable.form.extend!.fieldLoading = false
        })
}

const onJoinTableChange = (val: string, joinTableIdx: number) => {
    baTable.form.extend!.fieldLoading = true
    getFieldList(val)
        .then((res) => {
            if (typeof baTable.form.extend!.joinTableFieldSelect == 'undefined') {
                baTable.form.extend!.joinTableFieldSelect = []
                baTable.form.extend!.joinTableFieldSelectOpt = []
                baTable.form.extend!.joinTableFieldSelectKey = []
            }
            baTable.form.extend!.joinTableFieldSelect[joinTableIdx] = res.data.fields
            const fieldSelectOpt: anyObj = []
            for (const key in res.data.fields) {
                fieldSelectOpt[key] = res.data.fields[key].name + (res.data.fields[key].title ? ' - ' + res.data.fields[key].title : '')
            }
            baTable.form.extend!.joinTableFieldSelectOpt[joinTableIdx] = fieldSelectOpt
            baTable.form.extend!.joinTableFieldSelectKey[joinTableIdx] = uuid()

            if (
                baTable.form.items!.onJoinTableChangeCallback &&
                baTable.form.items!.onJoinTableChangeCallback[joinTableIdx] &&
                typeof baTable.form.items!.onJoinTableChangeCallback[joinTableIdx] == 'function'
            ) {
                baTable.form.items!.onJoinTableChangeCallback[joinTableIdx]()
                baTable.form.items!.onJoinTableChangeCallback[joinTableIdx] = null
            }
        })
        .finally(() => {
            baTable.form.extend!.fieldLoading = false
        })
}

const onTabChange = (name: TabPaneName) => {
    if (name == 'where') {
        baTable.form.extend!.fieldLoading = true
        const allTableField: anyObj = []
        for (const key in baTable.form.extend!.fieldSelectOpt) {
            allTableField[baTable.form.items!.main_table + '.' + key] =
                baTable.form.items!.main_table + '.' + baTable.form.extend!.fieldSelectOpt[key]
        }
        for (const tableKey in baTable.form.items!.joinTable) {
            const tableName = baTable.form.items!.joinTableAsName[tableKey]
                ? baTable.form.items!.joinTableAsName[tableKey]
                : baTable.form.items!.joinTable[tableKey]
            for (const key in baTable.form.extend!.joinTableFieldSelectOpt[tableKey]) {
                allTableField[tableName + '.' + key] = tableName + '.' + baTable.form.extend!.joinTableFieldSelectOpt[tableKey][key]
            }
        }
        baTable.form.extend!.allTableField = allTableField
        baTable.form.extend!.fieldLoading = false
        baTable.form.extend!.allTableFieldKey = uuid()
    }
}

const onWhereChange = () => {
    const where: anyObj = []
    for (const key in baTable.form.items!.where_field) {
        let value = ''
        let operator = '='
        for (const wkey in baTable.form.items!.where) {
            if (baTable.form.items!.where[wkey].field == baTable.form.items!.where_field[key]) {
                value = baTable.form.items!.where[wkey].value
                operator = baTable.form.items!.where[wkey].operator
                break
            }
        }
        where[key] = {
            operator: operator,
            value: value,
            field: baTable.form.items!.where_field[key],
        }
    }
    baTable.form.items!.where = where
}

const onOrderChange = () => {
    const order: anyObj = []
    for (const key in baTable.form.items!.order_field) {
        let orderValue = 'DESC'
        for (const okey in baTable.form.items!.order) {
            if (baTable.form.items!.order[okey].field == baTable.form.items!.order_field[key]) {
                orderValue = baTable.form.items!.order[okey].value
                break
            }
        }
        order[key] = {
            value: orderValue,
            field: baTable.form.items!.order_field[key],
        }
    }
    baTable.form.items!.order = order
}

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    name: [buildValidatorData({ name: 'required', title: t('routine.dataexport.name') })],
    main_table: [buildValidatorData({ name: 'required', message: t('Please select field', { field: t('routine.dataexport.main_table') }) })],
    concurrent_create_xls: [buildValidatorData({ name: 'required', title: t('routine.dataexport.concurrent_create_xls') })],
    memory_limit: [
        buildValidatorData({ name: 'required', title: t('routine.dataexport.memory_limit') }),
        {
            validator: (rule: any, val: string, callback: Function) => {
                let fieldCount = (baTable.form.items!.fields && baTable.form.items!.fields.length) ?? 0
                for (const key in baTable.form.items!.joinTableFields) {
                    fieldCount += baTable.form.items!.joinTableFields[key].length
                }
                if (fieldCount <= 0) {
                    return callback(new Error('请先在基础配置中选择导出字段'))
                }
                const memory = (fieldCount * baTable.form.items!.xls_max_number) / 1024
                if (memory >= baTable.form.items!.memory_limit) {
                    return callback(new Error('预计需要更多内存 > ' + (memory + 50).toFixed(0) + 'MB'))
                }
                return callback()
            },
            trigger: 'blur',
        },
    ],
    fields: [buildValidatorData({ name: 'required', message: t('Please select field', { field: '导出字段' }) })],
})

defineExpose({
    onTableChange,
    onJoinTableChange,
})
</script>

<style scoped lang="scss">
:deep(.ba-operate-dialog) .el-dialog__header {
    border: none;
}
.config-tabs {
    padding-bottom: 40px;
}
.field-row {
    display: flex;
    align-items: center;
    padding: 4px 0;
    .field-title {
        display: flex;
        align-items: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .field-title-input-title {
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
.form-hr {
    border-bottom: 1px solid #dcdfe6;
    margin: 16px 0;
}
</style>
