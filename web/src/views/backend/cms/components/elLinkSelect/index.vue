<template>
  <el-input :value="state.title" :size="props.size" @click="openDialog" :readonly="true"></el-input>
    <el-dialog
        class="el-link-dialog"
        :close-on-click-modal="false"
        :model-value="state.dialog"
        @close="closeDialog"
        top="20px" title="设置链接" width="540px" append-to-body>
        <el-form
            ref="formRef"
            @submit.prevent=""
            @keyup.enter="determine(formRef)"
            :model="state.valueForm"
            :rules="state.rules"
            label-width="100px"
            >
            <el-form-item label="链接类型：" prop="type">
                <el-radio-group v-model="state.linkForm.type" @change="typeChange()">
                    <el-radio v-for="(item, index) in state.typeList" :label="String(index)" :key="index">
                        {{ item }}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
            <template v-if="state.linkForm.type == '1'">
                <el-form-item label="链接：" prop="url">
                    <el-input v-model="state.valueForm.url" placeholder="请填写链接"></el-input>
                </el-form-item>
            </template>
            <template v-if="state.linkForm.type == '2'">
                <el-form-item label="类型：" prop="table">
                    <el-select placeholder="请选择类型" v-model="state.valueForm.table" @change="detailsListSearch()" filterable>
                        <el-option
                            v-for="(item, index) in state.tableList" :label="item.title" :value="item.name"
                            :key="index"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item v-if="state.valueForm.table != ''" label="链接：" prop="details">
                    <el-select
                        value-key="id" placeholder="请选择链接，输入标题远程搜索" v-model="state.valueForm.details" reserve-keyword
                        filterable remote :remote-method="detailsListSearch">
                        <el-option
                            v-for="(item, index) in state.detailsList" :key="index" :label="item.title"
                            :value="item"></el-option>
                    </el-select>
                </el-form-item>
            </template>
            <template v-if="state.linkForm.type == '3'">
                <el-form-item label="分类：" prop="catalog">
                    <el-select v-model="state.valueForm.catalog" value-key="id" placeholder="请选择分类" filterable>
                        <el-option v-for="(item, index) in state.catalogList" :key="index" :label="item.title" :value="item">
                            <span v-html="item.treeString"></span>
                            {{ item.title }}
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="锚点：" prop="anchor">
                    <el-input v-model="state.valueForm.anchor" placeholder="如：#about"></el-input>
                </el-form-item>
            </template>
        </el-form>
        <span class="dialog-footer">
            <el-button size="small" type="primary" @click="determine(formRef)">确定</el-button>
            <el-button size="small" @click="state.dialog = false">取消</el-button>
        </span>
    </el-dialog>
</template>

<script setup lang="ts">
import { ref, reactive, computed, onMounted } from 'vue'
import createAxios from '/@/utils/axios'
import type { FormInstance, FormItemRule } from 'element-plus'
import { buildValidatorData } from '/@/utils/validate'
import { useI18n } from 'vue-i18n'
const { t } = useI18n()

const formRef = ref<FormInstance>()
const props = defineProps(['modelValue', 'size'])
const emit = defineEmits(['update:modelValue'])

const state: {
    url: string
    catalogUrl: string
    linkForm: { type: string, value: any },
    linkDefault: { type: string, value: any[] }
    valueForm: any
    dialog: boolean
    typeList: string[]
    tableList: any[]
    catalogList: any[]
    detailsList: any[]
    title: string
    rules: Partial<Record<string, FormItemRule[]>>
} = reactive({
    url: "/admin/cms.api/link",
    catalogUrl: "/admin/cms.api/catalog",
    linkForm: { type: "0", value: {} },
    linkDefault: {
        type: "0",
        value: [
            {},
            { url: "" },
            { table: "", details: "" },
            { catalog: "", anchor: "" },
        ],
    },
    valueForm: {},
    dialog: false,
    typeList: ['无', '自定义链接', '详情链接', '分类链接'],
    tableList: [],
    detailsList: [],
    catalogList: [],
    title: "",
    rules: {}
})

const value = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})

/**
 * 数组转树形数组/树形字符串
 */
let tree = {
    // 树形数组
    convert(arr: any[], pProp = 'pid', cProp = 'id') {
        let result: any[] = []
        if (!Array.isArray(arr)) {
            return result
        }
        arr.forEach(item => {
            delete item.children;
        });
        let map: any = {};
        arr.forEach(item => {
            map[item[cProp]] = item;
        });
        arr.forEach(item => {
            let parent = map[item[pProp]];
            if (parent) {
                (parent.children || (parent.children = [])).push(item);
            } else {
                result.push(item);
            }
        });
        result = result.filter(ele => ele[pProp] == 0);
        return result;
    },
    // 树形字符串
    convertString(arr: any[], pProp = 'pid', cProp = 'id', pid = 0, format = "└", list = []) {
        arr.forEach(function (v) {
            if (v[pProp] == pid) {
                if (pid != 0) {
                    v['treeString'] = format;
                } else {
                    v['treeString'] = '';
                }
                list.push(v)
                tree.convertString(arr, pProp, cProp, v[cProp], "<span class='el-tree-title'></span>" + format, list);
            }
        });
        return list.length === 0 ? arr : list;
    },
}

/**
 * 打开弹窗
 */
const openDialog = () => {
    state.valueForm = state.linkForm['value'][state.linkForm.type]
    state.dialog = true
}

/**
 * 打开弹窗
 */
const closeDialog = () => {
    state.dialog = false
}
/**
 * 确定
 */
const determine = (formEl: FormInstance | undefined = undefined) => {
    if (formEl) {
        formEl.validate((valid: boolean) => {
            if (valid) {
                titleSearch();
                value.value = state.linkForm
                state.dialog = false
            }
        })
    } else {
        return false;
    }
}
/**
 * 初始化
 */
const catalogListSearch = () => {
    if (state.linkForm.type == '3' && state.catalogList.length == 0) {
        createAxios(
            {
                url: state.catalogUrl,
                method: 'post',
                data: {},
            },
            {
                showSuccessMessage: false,
            }
        ).then((res: any) => {
            state.catalogList = tree.convertString(res.data);
        })
    }
}

/**
 * 类型改变
 */
const typeChange = () => {
    // this.$refs.valueForm.clearValidate();
    state.valueForm = state.linkForm['value'][state.linkForm.type]
    console.log(state.valueForm.value)
    let rules = {}
    switch(state.linkForm.type){
        case '1':
            rules = {}
            break
        case '2':
            rules = {
                table: [buildValidatorData({ name: 'required', title: t('类型') })],
                details: [buildValidatorData({ name: 'required', title: t('链接') })],
            }
            break
        case '3':
            rules = {
                catalog: [buildValidatorData({ name: 'required', title: t('链接') })]
            }
            break
    }
    state.rules = rules
    titleSearch()
    init()
}

/**
 * 初始化
 */
const tableListSearch = () => {
    if (state.linkForm.type == '2' && state.tableList.length == 0) {
        createAxios(
            {
                url: state.url,
                method: 'post',
                data: {},
            },
            {
                showSuccessMessage: false,
            }
        ).then((res: any) => {
            state.tableList = res.data;
            state.valueForm = state.linkForm['value'][state.linkForm.type]
            console.log(state.tableList)
        })
    }
}

/**
 * 初始化
 */
const detailsListSearch = (keyword = "") => {
    if (state.linkForm.type == '2' && state.valueForm.table != '') {
        createAxios(
            {
                url: `${state.url}/table/${state.valueForm.table}`,
                method: 'post',
                data: {
                    keyword: keyword
                },
            },
            {
                showSuccessMessage: false,
            }
        ).then((res: any) => {
            console.log(res.data)
            state.detailsList = res.data;
        })
    }
}

/**
 * 标题
 */
const titleSearch = () => {
    switch (state.linkForm.type) {
        case "0":
        case "1":
            state.title = state.valueForm['url'];
            console.log(state.valueForm['url'])
            break;
        case "2":
            state.title = state.valueForm['details'] !== '' ? state.valueForm['details']['title'] : '';
            break;
        case "3":
            let title = state.valueForm['catalog'] !== '' ? state.valueForm['catalog']['title'] : '';
            state.title = title + state.valueForm['anchor'];
            break;
    }
    console.log(state.title, state.valueForm)
}

/**
 * 初始化
 */
const init = (type = '') => {
    catalogListSearch()
    tableListSearch()
    detailsListSearch()
    if (type != 'load') titleSearch()
}
onMounted(() => {
    state.linkForm = JSON.stringify(value.value) === "{}" || value.value.length === 0 ? state.linkDefault : value.value
    typeChange()
    init('load')
})
</script>
