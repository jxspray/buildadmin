<template>
   <div class="el-field" :style="{display: ifset ? 'flex' : 'block'}">
        <div class="el-field-push" v-if="ifset">
            <draggable class="add-draggable" :list="field" v-bind="addDraggable" :clone="addItem">
                <div v-for="(item, index) in field" class="el-field-move-item">
                    <i class="iconfont" :class="item.icon"></i>
                    <div class="title">{{item.label}}</div>
                </div>
            </draggable>
        </div>
        <el-form class="el-field-content" :class="{notset: ifset == false}" :label-width="labelWidth" :label-position="labelPosition" @submit.native.prevent>
            <draggable :class="{empty: list.length == 0 && ifset}" v-model="list" v-bind="draggable">
                <el-form-item v-for="(item, index) in list" :key="index" class="el-form-draggable">
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
                    <component v-if="show" v-model="item.type.value" :is="item.type.is" :key="item.type.field" :type="item.type.type"></component>
                </el-form-item>
            </draggable>
        </el-form>
        <el-dialog :model-value="setShow" title="字段设置" width="500px" top="30px" :close-on-click-modal="false" append-to-body>
            <el-form ref="setForm" :model="setForm" :rules="rules" :label-width="labelWidth" @submit.native.prevent>
                <el-form-item label="字段类型：" prop="type">
                    <el-select style="width: 100%" v-model="setForm.type" value-key="label" placeholder="请选择字段类型" filterable>
                        <el-option v-for="(item, index) in field" :key="index" :label="item.label" :value="item"></el-option>
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
import { VueDraggableNext } from 'vue-draggable-next'
import { getRandStr, customField } from '/@/utils/common'

export default {
  components: {
    draggable: VueDraggableNext
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
  computed: {
    dragOptions() { // 拖拽动画效果
      return {
        animation: 0,
        group: 'description',
        disabled: false,
        ghostClass: 'ghost',
      }
    },
  },
  data(){
    return {
        show: true,
        list: this.value,
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
    }
  },
  methods: {
    addItem(){

    },
    add: function() {
      this.list.push({ name: "Juan" });
    },
    replace: function() {
      this.list = [{ name: "Edgard" }];
    },
    clone: function(el) {
      return {
        name: el.name + " cloned"
      };
    },
    log: function(evt) {
      window.console.log(evt);
    }
  }
}

</script>


<script setup lang="ts">
</script>

<style scoped lang="scss">
</style>
