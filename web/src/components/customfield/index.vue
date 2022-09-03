<template>
    <div class="el-field">
        <el-form class="el-field-push" :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" v-if="ifset"
            @submit.native.prevent>
            <el-form-item label="字段类型：" prop="type">
                <el-select style="width:100%" placeholder="请选择字段类型" v-model="ruleForm.type" value-key="label"
                    filterable>
                    <el-option v-for="(item, index) in common.formType()" :key="index" :label="item.label"
                        :value="item"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="字段标题：" prop="label">
                <el-input v-model="ruleForm.label" placeholder="如：内容"></el-input>
            </el-form-item>
            <el-form-item label="字段变量：" prop="field">
                <el-input v-model="ruleForm.field" placeholder="如：content"></el-input>
            </el-form-item>
            <el-form-item v-if="ruleForm.type != ''" style="width:100%"
                :label="ruleForm.label === '' ? '' : ruleForm.label + '：'" prop="value">
                <component v-model="ruleForm.type.value" :is="ruleForm.type.is" :key="ruleForm.type.field"
                    :type="ruleForm.type.type"></component>
            </el-form-item>
            <el-form-item style="width:100%">
                <el-button size="small" type="primary" @click="addItem()">添加自定义字段</el-button>
            </el-form-item>
        </el-form>
        <el-form :label-width="labelWidth" :label-position="labelPosition" @submit.native.prevent>
            <template v-for="(item, index) in list" :key="index">
                <template v-if="typeof item.label !== 'undefined' && item.label != ''">
                    <el-form-item class="el-form-draggable">
                        <template slot="label">
                            <el-tooltip placement="top" :content="formVariable(item)">
                                <div>{{ item.label }}：</div>
                            </el-tooltip>
                            <div class="el-field-button" v-if="ifset">
                                <el-tooltip content="拖放排序" placement="top">
                                    <el-button size="mini" class="rank" type="info" icon="el-icon-rank" circle>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="设置" placement="top">
                                    <el-button size="mini" type="primary" icon="el-icon-s-tools" circle
                                        @click="setItem(item, index)"></el-button>
                                </el-tooltip>
                                <el-tooltip content="删除" placement="top">
                                    <el-button size="mini" type="danger" icon="el-icon-close" circle
                                        @click="removeItem(item, index)"></el-button>
                                </el-tooltip>
                            </div>
                        </template>
                        <component v-if="show" v-model="item.type.value" :is="item.type.is" :key="item.type.field"
                            :type="item.type.type"></component>
                    </el-form-item>
                </template>
            </template>
        </el-form>
        <el-dialog :visible.sync="setShow" title="字段设置" width="500px" top="30px" :close-on-click-modal="false"
            append-to-body>
            <el-form ref="setForm" :model="setForm" :rules="rules" :label-width="labelWidth" @submit.native.prevent>
                <el-form-item label="字段类型：" prop="type">
                    <el-select style="width: 100%" v-model="setForm.type" value-key="label" placeholder="请选择字段类型"
                        filterable>
                        <el-option v-for="(item, index) in common.formType()" :key="index" :label="item.label"
                            :value="item"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="字段标题：" prop="label">
                    <el-input v-model="setForm.label" placeholder="如：内容"></el-input>
                </el-form-item>
                <el-form-item label="字段变量：" prop="field">
                    <el-input v-model="setForm.field" placeholder="如：content"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button size="small" type="primary" @click="changeItem()">确 定</el-button>
                    <el-button size="small" @click="setShow = false">取 消</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>


<script>
import './css/style.css' // 引入 css
import { getRandStr, customField, arrayIndex } from '/@/utils/common'
import draggable from 'vuedraggable'

export default {
    components: {
        draggable,
    },
    props: {
        labelWidth: {
            type: String,
            default: '120px',
        },
        labelPosition: {
            type: String,
            default: 'right',
        },
        variable: {
            type: String,
            default: '',
        },
        ifset: {
            type: Boolean,
            default: true,
        },
        repeat: {
            type: Array,
            default: [],
        },
        value: {
            type: Array,
            default: [],
        },
    },
    data() {
        var validateRepeatField = (rule, value, callback) => {
            if (arrayIndex(this.list, this.ruleForm.field, 'field') !== -1 || typeof this.repeat[this.ruleForm.field] !== 'undefined') {
                callback(new Error('字段变量不能重复！'));
            } else {
                callback();
            }
        }
        return {
            show: true,
            list: this.value,
            draggable: {
                handle: '.rank',
                animation: 300,
                forceFallback: true,
            },
            ruleForm: {
                label: '',
                field: '',
                type: '',
            },
            rules: {
                label: [
                    { required: true, message: '请填写字段标题', trigger: 'blur' },
                ],
                field: [
                    { required: true, message: '请输入字段变量', trigger: 'blur' },
                    { validator: validateRepeatField, trigger: 'blur' },
                    { pattern: /^[a-zA-Z][a-zA-Z0-9_]*$/, message: '以字母开头只能输入字母、下划线、数字', trigger: 'blur' },
                ],
                type: [
                    { required: true, message: '请选择字段类型', trigger: 'blur' },
                ],
            },
            setForm: {},
            setShow: false,
            setIndex: 0,
        }
    },
    methods: {
        /**
         * 添加
         */
        addItem() {
            this.$refs.ruleForm.validate((valid) => {
                if (valid) {
                    let item = JSON.parse(JSON.stringify(this.ruleForm));
                    this.ruleForm = Object.assign({}, this.ruleForm, { label: "", field: "", type: "" });
                    this.list.push(item);
                } else {
                    return false;
                }
            });
        },
        /**
         * 删除
         */
        removeItem(item, index) {
            let self = this;
            self.list.splice(index, 1);
            if (item.type.is == 'el-array') {
                self.show = false;
                self.$nextTick(() => {
                    self.show = true;
                })
            }
        },
        /**
         * 改变
         */
        changeItem() {
            this.$refs.setForm.validate((valid) => {
                if (valid) {
                    this.$set(this.list, this.setIndex, this.setForm);
                    this.setShow = false;
                } else {
                    return false;
                }
            });
        },
        /**
         * 设置
         */
        setItem(item, index) {
            this.setIndex = index;
            this.setForm = JSON.parse(JSON.stringify(item));
            this.setShow = true;
        },
        /**
         * 表单提示变量
         */
        formVariable(item) {
            let raw = item.type.is == 'el-editor' ? '|raw' : '';
            return this.variable === '' ? item.field : '{$' + this.variable + '.' + item.field + raw + '}';
        },
    },
    watch: {
        value(val) {
            this.list = val;
        },
        list(val) {
            this.value = val;
            this.$emit('input', val);
        }
    }
}

</script>


<script setup lang="ts">
</script>

<style scoped lang="scss">
</style>
