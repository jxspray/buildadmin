<template>
  <div class="el-array" ref="elArray">
    <el-dialog top="20px" title="列表新增字段" :model-value="state.form.setShow" :close-on-click-modal="false" width="500px" append-to-body>
      <el-form :model="state.form.setForm" :rules="state.rules" ref="fieldFormRef" @keyup.enter="state.addField(fieldFormRef)" label-width="100px" @submit.native.prevent>
        <el-form-item label="字段类型：" prop="type">
          <el-select style="width:100%" v-model="state.form.setForm.type" value-key="label" placeholder="请选择字段类型" filterable>
            <el-option v-for="(item, index) in state.form.fieldList" :key="index" :label="item.label" :value="item"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="字段标题：" prop="label">
          <el-input v-model="state.form.setForm.label" placeholder="如：内容"></el-input>
        </el-form-item>
        <el-form-item label="字段变量：" prop="field">
          <el-input v-model="state.form.setForm.field" placeholder="如：content"></el-input>
        </el-form-item>
        <el-form-item label="字段宽度：" prop="width" v-if="state.form.setForm.type">
          <el-input v-model="state.form.setForm.type!.width" placeholder="如：500px"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
          <el-button size="small" type="primary" @click="state.addField(fieldFormRef)">确 定</el-button>
          <el-button size="small" @click="state.form.setShow = false">取 消</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script setup lang="ts">
import customArray from "./customArray";
import {ref, watch} from 'vue'
import {ElForm, FormInstance} from "element-plus";
const fieldFormRef = ref<InstanceType<typeof ElForm>>();
const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])
const state = new customArray(props.modelValue)

</script>
