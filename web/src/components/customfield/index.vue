<template>
   <div class="el-field" :style="{display: ifset ? 'flex' : 'block'}">
        <div class="el-field-push" v-if="ifset">
            <draggable class="add-draggable" v-model="state.field" v-bind="state.addDraggable" :clone="addItem">
                <div v-for="(item, index) in state.field" class="el-field-move-item">
                    <i class="iconfont" :class="item.icon"></i>
                    <div class="title">{{item.label}}</div>
                </div>
            </draggable>
        </div>
        <el-form class="el-field-content" :class="{notset: ifset == false}" :label-width="labelWidth" :label-position="labelPosition" @submit.native.prevent>
            <draggable :class="{empty: state.list.length == 0 && ifset}" v-model="state.list" v-bind="state.draggable">
                <el-form-item v-for="(item, index) in state.list" :key="index" class="el-form-draggable">
                    <template slot="label">
                        <el-tooltip placement="top" :content="formVariable(item)">
                            <div>{{item.label}}：</div>
                        </el-tooltip>
                        <div class="el-field-button" v-if="ifset">
                            <el-tooltip content="拖放排序" placement="top" >
                                <el-button size="mini" class="rank" type="info" icon="el-icon-rank" circle></el-button>
                            </el-tooltip>
                            <el-tooltip content="设置" placement="top">
                                <el-button size="mini" type="primary" icon="el-icon-s-tools" circle @click="setItem(item, index)"></el-button>
                            </el-tooltip>
                            <el-tooltip content="删除" placement="top">
                                <el-button size="mini" type="danger" icon="el-icon-close" circle @click="removeItem(item,index)"></el-button>
                            </el-tooltip>
                        </div>
                    </template>
                    <component v-if="state.show" v-model="item.type.value" :is="item.type.is" :key="item.type.field" :type="item.type.type"></component>
                </el-form-item>
            </draggable>
        </el-form>
        <el-dialog :visible.sync="state.setShow" title="字段设置" width="500px" top="30px" :close-on-click-modal="false" append-to-body>
            <el-form ref="setForm" :model="state.setForm" :rules="state.rules" :label-width="labelWidth" @submit.native.prevent>
                <el-form-item label="字段类型：" prop="type">
                    <el-select style="width: 100%" v-model="state.setForm.type" value-key="label" placeholder="请选择字段类型" filterable>
                        <el-option v-for="(item, index) in state.field" :key="index" :label="item.label" :value="item"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="字段标题：" prop="label"> 
                    <el-input v-model="state.setForm.label" placeholder="如：内容"></el-input>
                </el-form-item>
                <el-form-item label="字段变量：" prop="field">
                    <el-input v-model="state.setForm.field" placeholder="如：content"></el-input>
                </el-form-item>
                <el-form-item> 
                    <el-button size="small" type="primary" @click="changeItem()">确 定</el-button>
                    <el-button size="small" @click="state.setShow = false">取 消</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
// import './css/onekey.min.css' // 引入 css
import './css/style.css' // 引入 css
import draggable from 'vuedraggable'
import { onBeforeUnmount, onMounted, reactive } from 'vue'
import { getRandStr, customField } from '/@/utils/common'

interface Props {
    labelWidth?: string
    labelPosition?: string
    variable?: string
    ifset?: boolean
    repeat?: any
    value?: any
}
const props = withDefaults(defineProps<Props>(), {
    labelWidth: '120px',
    labelPosition: 'right',
    variable: '',
    ifset: true,
    repeat: () => {
        return []
    },
    value: () => {
        return []
    },
})

const state = reactive({
    show: true,
    list: props.value,
    field: customField,
    draggable: {
        handle: '.rank',
        animation: 300,
        forceFallback: true,
        group:"people"
    },
    addDraggable: {
        animation: 300,
        forceFallback: true,
        sort: false,
        group: {name: 'people', pull: 'clone', put: false},
    },
    rules: {
        label: [
            { required: true, message: '请填写字段标题', trigger: 'blur' },
        ],
        field: [
            { required: true, message: '请输入字段变量', trigger: 'blur' },
            { pattern: /^[a-zA-Z][a-zA-Z0-9_]*$/, message: '以字母开头只能输入字母、下划线、数字', trigger: 'blur' },
        ],
        type: [
            { required: true, message: '请选择字段类型', trigger: 'blur' },
        ],
    },
    setForm: {},
    setShow: false,
    setIndex: 0,
})
console.log(state.field)

const addItem = (item: anyObj) => {
    let arr:anyObj         = {};
    arr.field      = getRandStr(6);
    arr.label      = '未命名';
    arr.type       = item;
    return JSON.parse(JSON.stringify(arr));
}

/**
 * 删除
 */
 const removeItem = (item: anyObj, index: number) => {
    state.list.list.splice(index, 1);
    if (item.type.is == 'el-array') {
        self.show = false;
        self.$nextTick(() => {
            self.show = true;
        })
    }
    let arr         = {};
    arr.field      = getRandStr(6);
    arr.label      = '未命名';
    arr.type       = item;
    return JSON.parse(JSON.stringify(arr));
}

/**
 * 改变
 */
const changeItem = () => {
    // this.$refs.setForm.validate((valid) => {
    //     if (valid) {
    //         this.$set(this.list, this.setIndex, this.setForm);
    //         this.setShow = false;
    //     } else {
    //         return false;
    //     }
    // });
}

/**
 * 设置
 */
const setItem = (item, index) => {
    this.setIndex = index;
    this.setForm  = JSON.parse(JSON.stringify(item));
    this.setShow  = true;
}

/**
 * 表单提示变量
 */
 const formVariable = (item) => {
    let raw = item.type.is == 'el-editor' ? '|raw' : '';
    return this.variable === '' ? item.field : '{$' + this.variable + '.' + item.field + raw +'}';
}

// 生命周期钩子
onMounted(() => {
})

// 组件销毁时，也及时销毁编辑器
onBeforeUnmount(() => {
})

// 把数据导出到父级
defineExpose({
})

</script>

<style scoped lang="scss">
</style>
