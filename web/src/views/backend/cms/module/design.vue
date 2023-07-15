<template>
    <div class="default-main">
        <el-row v-loading="state.loading.init" class="fields-box" :gutter="20">
            <el-col :xs="24" :span="6">
                <el-collapse class="field-collapse" v-model="state.fieldCollapseName">
                    <el-collapse-item :title="t('crud.crud.Common Fields')" name="common">
                        <div class="field-box" :ref="tabsRefs.set">
                            <div v-for="(field, index) in fieldItem.common" :key="index" class="field-item">
                                <span>{{ field.title }}</span>
                            </div>
                        </div>
                    </el-collapse-item>
                    <el-collapse-item :title="t('crud.crud.Base Fields')" name="base">
                        <div class="field-box" :ref="tabsRefs.set">
                            <div v-for="(field, index) in fieldItem.base" :key="index" class="field-item">
                                <span>{{ field.title }}</span>
                            </div>
                        </div>
                    </el-collapse-item>
                    <el-collapse-item :title="t('crud.crud.Advanced Fields')" name="senior">
                        <div class="field-box" :ref="tabsRefs.set">
                            <div v-for="(field, index) in fieldItem.senior" :key="index" class="field-item">
                                <span>{{ field.title }}</span>
                            </div>
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-col>
            <el-col :xs="24" :span="12">
                <div ref="designWindowRef" class="design-window ba-scroll-style">
                    <div
                        v-for="(field, index) in state.fields"
                        :key="index"
                        :class="index === state.activateField ? 'activate' : ''"
                        @click="onActivateField(index)"
                        class="design-field-box"
                        :data-id="index"
                    >
                        <div class="design-field">
                            <span>{{ t('crud.crud.Field Name') }}：</span>
                            <BaInput
                                @pointerdown.stop
                                class="design-field-name-input"
                                v-model="field.name"
                                type="string"
                                :attr="{
                                    size: 'small',
                                    onChange: onFieldNameChange,
                                }"
                            />
                        </div>
                        <div class="design-field">
                            <span>{{ t('crud.crud.field comment') }}：</span>
                            <BaInput
                                @pointerdown.stop
                                class="design-field-name-comment"
                                v-model="field.comment"
                                type="string"
                                :attr="{
                                    size: 'small',
                                }"
                            />
                        </div>
                        <div class="design-field-right">
                            <el-button
                                v-if="['remoteSelect', 'remoteSelects'].includes(field.designType)"
                                @click.stop="onEditField(index, field)"
                                type="primary"
                                size="small"
                                v-blur
                                circle
                            >
                                <Icon color="var(--el-color-white)" size="15" name="fa fa-pencil icon" />
                            </el-button>
                            <!-- <el-button @click.stop="onDelField(index)" type="danger" size="small" v-blur circle>
                                <Icon color="var(--el-color-white)" size="15" name="fa fa-trash" />
                            </el-button> -->
                        </div>
                    </div>
                    <div class="design-field-empty" v-if="!state.fields.length && !state.draggingField">
                        {{ t('crud.crud.Drag the left element here to start designing CRUD') }}
                    </div>
                </div>
            </el-col>
            
            <el-col :xs="24" :span="6">
                <div class="field-config ba-scroll-style">
                    <div v-if="state.activateField === -1" class="design-field-empty">
                        {{ t('crud.crud.Please select a field from the left first') }}
                    </div>
                    <div v-else :key="'activate-field-' + state.activateField">
                        <el-form label-position="top">
                            <el-divider content-position="left">{{ t('crud.crud.Common') }}</el-divider>
                            <el-form-item :label="t('crud.crud.generate')">
                                <el-select
                                    @change="onFieldDesignTypeChange"
                                    class="w100"
                                    v-model="state.fields[state.activateField].designType"
                                    placement="bottom"
                                >
                                    <el-option v-for="(item, idx) in designTypes" :key="idx" :label="item.name" :value="idx" />
                                </el-select>
                            </el-form-item>
                            <FormItem
                                :label="t('crud.crud.Field comments (CRUD dictionary)')"
                                type="textarea"
                                :input-attr="{
                                    rows: 2,
                                    onChange: onFieldCommentChange,
                                }"
                                :placeholder="
                                    t(
                                        'crud.crud.The field comment will be used as the CRUD dictionary, and will be identified as the field title before the colon, and as the data dictionary after the colon'
                                    )
                                "
                                v-model="state.fields[state.activateField].comment"
                            />
                            <el-divider content-position="left">{{ t('crud.crud.Field Properties') }}</el-divider>
                            <FormItem
                                :label="t('crud.crud.Field Name')"
                                type="string"
                                v-model="state.fields[state.activateField].name"
                                :input-attr="{
                                    onChange: onFieldNameChange,
                                }"
                            />
                            <template v-if="state.fields[state.activateField].dataType">
                                <FormItem :label="t('crud.crud.Field Type')" type="textarea" v-model="state.fields[state.activateField].dataType" />
                            </template>
                            <template v-else>
                                <FormItem :label="t('crud.crud.Field Type')" type="string" v-model="state.fields[state.activateField].type" />
                                <div class="field-inline">
                                    <FormItem
                                        :label="t('crud.crud.length')"
                                        type="number"
                                        v-model.number="state.fields[state.activateField].length"
                                    />
                                    <FormItem
                                        :label="t('crud.crud.decimal point')"
                                        type="number"
                                        v-model.number="state.fields[state.activateField].precision"
                                    />
                                </div>
                            </template>
                            <FormItem
                                :label="t('crud.crud.Field Defaults')"
                                :placeholder="t('crud.crud.You can directly enter null, 0, empty string')"
                                type="string"
                                v-model="state.fields[state.activateField].default"
                            />
                            <div class="field-inline">
                                <FormItem
                                    class="form-item-position-right"
                                    :label="t('crud.state.Primary key')"
                                    type="switch"
                                    v-model="state.fields[state.activateField].primaryKey"
                                />
                                <FormItem
                                    class="form-item-position-right"
                                    :label="t('crud.crud.Auto increment')"
                                    type="switch"
                                    v-model="state.fields[state.activateField].autoIncrement"
                                />
                            </div>
                            <div class="field-inline">
                                <FormItem
                                    class="form-item-position-right"
                                    :label="t('crud.crud.Unsigned')"
                                    type="switch"
                                    v-model="state.fields[state.activateField].unsigned"
                                />
                                <FormItem
                                    class="form-item-position-right"
                                    :label="t('crud.crud.Allow NULL')"
                                    type="switch"
                                    v-model="state.fields[state.activateField].null"
                                />
                            </div>
                            <template v-if="!isEmpty(state.fields[state.activateField].table)">
                                <el-divider content-position="left">{{ t('crud.crud.Field Table Properties') }}</el-divider>
                                <template v-for="(item, idx) in state.fields[state.activateField].table" :key="idx">
                                    <FormItem
                                        :label="$t('crud.crud.' + idx)"
                                        :type="item.type"
                                        v-model="state.fields[state.activateField].table[idx].value"
                                        :placeholder="state.fields[state.activateField].table[idx].placeholder ?? ''"
                                        :data="{
                                            content: state.fields[state.activateField].table[idx].options ?? {},
                                        }"
                                        :input-attr="state.fields[state.activateField].table[idx].attr ?? {}"
                                    />
                                </template>
                            </template>
                            <template v-if="!isEmpty(state.fields[state.activateField].form)">
                                <el-divider content-position="left">{{ t('crud.crud.Field Form Properties') }}</el-divider>
                                <template v-for="(item, idx) in state.fields[state.activateField].form" :key="idx">
                                    <FormItem
                                        :label="$t('crud.crud.' + idx)"
                                        :type="item.type"
                                        v-model="state.fields[state.activateField].form[idx].value"
                                        :placeholder="state.fields[state.activateField].form[idx].placeholder ?? ''"
                                        :data="{
                                            content: state.fields[state.activateField].form[idx].options ?? {},
                                        }"
                                        :input-attr="state.fields[state.activateField].form[idx].attr ?? {}"
                                    />
                                </template>
                            </template>
                        </el-form>
                    </div>
                </div>
            </el-col>
        </el-row>
    </div>
</template>
<script setup lang="ts">
import { ref, reactive, onMounted, nextTick } from 'vue'
import { fieldItem, designTypes, getTableAttr } from '/@/views/backend/crud/index'
import type { FieldItem } from '/@/views/backend/cms/module/fieldItem'
import { ElNotification, FormItemRule, FormInstance, ElMessageBox } from 'element-plus'
import { cloneDeep, range, isEmpty } from 'lodash-es'
import Sortable, { SortableEvent } from 'sortablejs'
import { useTemplateRefsList } from '@vueuse/core'
import { getDatabaseList, getFileData } from '/@/api/backend/crud'
import { getArrayKey } from '/@/utils/common'
import { getTableFieldList } from '/@/api/common'

import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const designWindowRef = ref()
const tabsRefs = useTemplateRefsList<HTMLElement>()
const state: {
    loading: {
        init: boolean
        generate: boolean
        remoteSelect: boolean
    }
    fields: FieldItem[]
    activateField: number
    fieldCollapseName: string[]
    remoteSelectPre: {
        show: boolean
        index: number
        dbList: anyObj
        fieldList: anyObj
        modelFileList: anyObj
        controllerFileList: anyObj
        loading: boolean
        hideDelField: boolean
        form: {
            table: string
            pk: string
            label: string
            joinField: string[]
            modelFile: string
            controllerFile: string
        }
    }
    draggingField: boolean
} = reactive({
    loading: {
        init: false,
        generate: false,
        remoteSelect: false,
    },
    fields: [],
    activateField: -1,
    fieldCollapseName: ['common', 'base', 'senior'],
    remoteSelectPre: {
        show: false,
        index: -1,
        dbList: [],
        fieldList: [],
        modelFileList: [],
        controllerFileList: [],
        loading: false,
        hideDelField: false,
        form: {
            table: '',
            pk: '',
            label: '',
            joinField: [],
            modelFile: '',
            controllerFile: '',
        },
    },
    draggingField: false,
})

const onActivateField = (idx: number) => {
    state.activateField = idx
}

const onFieldNameChange = (val: string) => {
}

const onEditField = (index: number, field: FieldItem) => {
    if (['remoteSelect', 'remoteSelects'].includes(field.designType)) return showRemoteSelectPre(index)
}

const showRemoteSelectPre = (index: number, hideDelField = false) => {
    state.remoteSelectPre.show = true
    state.remoteSelectPre.loading = true
    state.remoteSelectPre.index = index
    state.remoteSelectPre.hideDelField = hideDelField
    getDatabaseList()
        .then((res) => {
            state.remoteSelectPre.dbList = res.data.dbs
            if (state.fields[index] && state.fields[index].form['remote-table'].value) {
                state.remoteSelectPre.form.table = state.fields[index].form['remote-table'].value
                state.remoteSelectPre.form.pk = state.fields[index].form['remote-pk'].value
                state.remoteSelectPre.form.label = state.fields[index].form['remote-field'].value
                state.remoteSelectPre.form.controllerFile = state.fields[index].form['remote-controller'].value
                state.remoteSelectPre.form.modelFile = state.fields[index].form['remote-model'].value
                state.remoteSelectPre.form.joinField = state.fields[index].form['relation-fields'].value.split(',')
                if (isEmpty(state.remoteSelectPre.fieldList)) {
                    getTableFieldList(state.fields[index].form['remote-table'].value).then((res) => {
                        const fieldSelect: anyObj = {}
                        for (const key in res.data.fieldList) {
                            fieldSelect[key] = (key ? key + ' - ' : '') + res.data.fieldList[key]
                        }
                        state.remoteSelectPre.fieldList = fieldSelect
                    })
                }
                if (isEmpty(state.remoteSelectPre.modelFileList) || isEmpty(state.remoteSelectPre.controllerFileList)) {
                    getFileData(state.fields[index].form['remote-table'].value).then((res) => {
                        state.remoteSelectPre.modelFileList = res.data.modelFileList
                        state.remoteSelectPre.controllerFileList = res.data.controllerFileList
                    })
                }
            }
        })
        .finally(() => {
            state.remoteSelectPre.loading = false
        })
}


/**
 * 处理字段的属性
 */
const handleFieldAttr = (field: FieldItem) => {
    const designTypeAttr = cloneDeep(designTypes[field.designType])
    for (const tKey in field.form) {
        if (designTypeAttr.form[tKey]) designTypeAttr.form[tKey].value = field.form[tKey]
        if (tKey == 'image-multi' && field.form[tKey]) {
            designTypeAttr.table['render'] = getTableAttr('render', 'images')
        }
    }
    for (const tKey in field.table) {
        if (designTypeAttr.table[tKey]) designTypeAttr.table[tKey].value = field.table[tKey]
    }
    field.form = designTypeAttr.form
    field.table = designTypeAttr.table
    return field
}

interface SortableEvt extends SortableEvent {
    originalEvent?: DragEvent
}
let nameRepeatCount = 1
onMounted(() => {
    // loadData()
    const sortable = Sortable.create(designWindowRef.value, {
        group: 'design-field',
        animation: 200,
        filter: '.design-field-empty',
        onAdd: (evt: SortableEvt) => {
            const name = evt.originalEvent?.dataTransfer?.getData('name')
            const field = fieldItem[name as keyof typeof fieldItem]
            if (field && field[evt.oldIndex!]) {
                const data = handleFieldAttr(cloneDeep(field[evt.oldIndex!]))

                // name 重复字段自动重命名
                const nameRepeatKey = getArrayKey(state.fields, 'name', data.name)
                if (nameRepeatKey) {
                    data.name = data.name + nameRepeatCount
                    nameRepeatCount++
                }

                state.fields.splice(evt.newIndex!, 0, data)

                // 远程下拉参数预填
                if (['remoteSelect', 'remoteSelects'].includes(data.designType)) {
                    showRemoteSelectPre(evt.newIndex!, true)
                }
            }
            evt.item.remove()
            nextTick(() => {
                sortable.sort(range(state.fields.length).map((value) => value.toString()))
            })
        },
        onEnd: (evt) => {
            const temp = state.fields[evt.oldIndex!]
            state.fields.splice(evt.oldIndex!, 1)
            state.fields.splice(evt.newIndex!, 0, temp)
            nextTick(() => {
                sortable.sort(range(state.fields.length).map((value) => value.toString()))
            })
        },
    })

    tabsRefs.value.forEach((item, index) => {
        Sortable.create(item, {
            sort: false,
            group: {
                name: 'design-field',
                pull: 'clone',
                put: false,
            },
            animation: 200,
            setData: (dataTransfer) => {
                dataTransfer.setData('name', Object.keys(fieldItem)[index])
            },
            onStart: () => {
                state.draggingField = true
            },
            onEnd: () => {
                state.draggingField = false
            },
        })
    })
})



const onFieldDesignTypeChange = () => {
    const field = cloneDeep(state.fields[state.activateField])
    for (const tKey in field.table) {
        field.table[tKey] = field.table[tKey].value
    }
    for (const tKey in field.form) {
        field.form[tKey] = field.form[tKey].value
    }
    state.fields[state.activateField] = handleFieldAttr(field)
}

/**
 * 根据字段字典重新生成字段的数据类型
 */
const onFieldCommentChange = (comment: string) => {
    if (['enum', 'set'].includes(state.fields[state.activateField].type)) {
        if (!comment) {
            state.fields[state.activateField].dataType = `${state.fields[state.activateField].type}()`
            return
        }
        comment = comment.replaceAll('：', ':')
        comment = comment.replaceAll('，', ',')
        let comments = comment.split(':')
        if (comments[1]) {
            comments = comments[1].split(',')
            comments = comments
                .map((value) => {
                    if (!value) return ''
                    let temp = value.split('=')
                    if (temp[0] && temp[1]) {
                        return `'${temp[0]}'`
                    }
                    return ''
                })
                .filter((str: string) => str != '')

            // 字段数据类型
            state.fields[state.activateField].dataType = `${state.fields[state.activateField].type}(${comments.join(',')})`
        }
    }
}

</script>

<style scoped lang="scss">
.form-item-position-right {
    display: flex !important;
    align-items: center;
    :deep(.el-form-item__label) {
        margin-bottom: 0 !important;
    }
}
.default-main {
    margin-bottom: 0;
}
.mr-20 {
    margin-right: 20px;
}
.field-collapse :deep(.el-collapse-item__header) {
    padding-left: 10px;
    user-select: none;
}
.field-box {
    padding: 10px;
}
.field-item {
    display: inline-block;
    padding: 4px 18px;
    border: 1px dashed var(--el-border-color);
    border-radius: var(--el-border-radius-base);
    margin: 6px;
    cursor: pointer;
    user-select: none;
    &:hover {
        border-color: var(--el-color-primary);
    }
}
.header-config-box {
    position: relative;
    .header-senior-config {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        height: 24px;
        bottom: -24px;
        padding: 4px 20px;
        padding-top: 0;
        left: calc(50% - 10px);
        font-size: var(--el-font-size-small);
        border-bottom-left-radius: 50px;
        border-bottom-right-radius: 50px;
        background-color: var(--ba-bg-color-overlay);
        color: var(--el-text-color-primary);
        cursor: pointer;
        user-select: none;
        .senior-config-arrow-icon {
            margin-left: 4px;
        }
    }
}
.header-senior-config-box {
    width: 100%;
    padding: 10px;
    background-color: var(--ba-bg-color-overlay);
}
.header-senior-config-form {
    width: 50%;
    :deep(.el-form-item__label) {
        justify-content: flex-start;
    }
}
.default-sort-field-box {
    display: flex;
    .default-sort-field {
        flex: 6;
    }
    .default-sort-field-type {
        flex: 3;
    }
}
.fields-box {
    margin-top: 36px;
}
.design-field-empty {
    display: flex;
    height: 100%;
    color: var(--el-color-info);
    font-size: var(--el-font-size-medium);
    align-items: center;
    justify-content: center;
}
.design-window {
    overflow-x: auto;
    height: calc(100vh - 200px);
    border-radius: var(--el-border-radius-base);
    background-color: var(--ba-bg-color-overlay);
    border: v-bind('state.draggingField ? "1px dashed var(--el-color-primary)":(state.fields.length ? "none":"1px dashed var(--el-border-color)")');
    .design-field-box {
        display: flex;
        padding: 10px;
        align-items: center;
        border: 1px dashed var(--el-border-color);
        border-radius: var(--el-border-radius-base);
        margin-bottom: 2px;
        cursor: pointer;
        user-select: none;
        .design-field {
            padding-right: 10px;
        }
        .design-field-name-input {
            width: 200px;
        }
        .design-field-name-comment {
            width: 100px;
        }
        .design-field-right {
            margin-left: auto;
        }
        &:hover {
            border-color: var(--el-color-primary);
        }
    }
    .design-field-box.activate {
        border-color: var(--el-color-primary);
    }
}
.field-inline {
    display: flex;
    :deep(.el-form-item) {
        width: 46%;
        margin-right: 2%;
    }
}
.field-config {
    overflow-x: auto;
    height: calc(100vh - 200px);
    padding: 20px;
    background-color: var(--ba-bg-color-overlay);
}
:deep(.confirm-generate-dialog) .el-dialog__body {
    height: unset;
}
.confirm-generate-dialog-body {
    padding: 30px;
}
.confirm-generate-dialog-footer {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
