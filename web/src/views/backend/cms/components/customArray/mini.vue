<template>
  <div class="el-array" ref="elArray">
    <el-dialog top="20px" title="列表新增字段" :model-value="state.setShow" :close-on-click-modal="false" width="500px" append-to-body>
      <el-form :model="state.setForm" :rules="rules" ref="fieldFormRef" @keyup.enter="addField(fieldFormRef)" label-width="100px" @submit.native.prevent>
        <el-form-item label="字段类型：" prop="type">
          <el-select style="width:100%" v-model="state.fieldForm.type" value-key="label" placeholder="请选择字段类型" filterable>
            <el-option v-for="(item, index) in state.fieldList" :key="index" :label="item.label" :value="item"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="字段标题：" prop="label">
          <el-input v-model="state.fieldForm.label" placeholder="如：内容"></el-input>
        </el-form-item>
        <el-form-item label="字段变量：" prop="field">
          <el-input v-model="state.fieldForm.field" placeholder="如：content"></el-input>
        </el-form-item>
        <el-form-item label="字段宽度：" prop="width" v-if="state.fieldForm.type">
          <el-input v-model="state.fieldForm.type!.width" placeholder="如：500px"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
          <el-button size="small" type="primary" @click="addField(fieldFormRef)">确 定</el-button>
          <el-button size="small" @click="state.dialog = false">取 消</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script setup lang="ts">
import customArray from "./customArray";
import {onMounted} from "vue/dist/vue";
const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])
const state = new customArray(props.modelValue)

onMounted(() => {
})
</script>
