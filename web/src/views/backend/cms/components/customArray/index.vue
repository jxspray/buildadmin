<template>
    <div class="el-array" ref="elArray">
        <el-button type="primary" @click="state.unshiftTable()" size="small">新增一行</el-button>
        <el-table :data="state.module.value.table" row-key="id" border v-if="state.module.show">
            <el-table-column v-for="(item, index) in state.module.value.column" :prop="item.field" :key="index"
                             :width="item.type.width">
                <template #header>
                    <el-tooltip :content="item.field" placement="top">
                        <span class="el-array-title">{{ item.label }}</span>
                    </el-tooltip>
                    <el-tooltip content="删除字段" placement="top">
                        <Icon name="el-icon-Delete" class="el-array-remove" color="var(--el-color-error)"
                              @click="state.delField(index)"/>
                    </el-tooltip>
                </template>
                <template #default="scope">
                    <ElLinkSelect v-if="item.type.type == 'link-select'" v-model="scope.row[item.field]" size=""/>
                    <BaInput
                            v-else
                            @pointerdown.stop
                            v-model="scope.row[item.field]"
                            :type="item.type.type"
                    />
                </template>
            </el-table-column>
            <el-table-column>
                <template #header>
                    <el-button type="primary" @click="state.form.setShow = true" size="small">新增字段</el-button>
                </template>
                <template #default="scope">
                    <a href="javascript:" @click="state.removeTable(scope.$index)">删除</a>
                    <a href="javascript:" @click="state.pushTable(scope.$index)">追加</a>
                </template>
            </el-table-column>
        </el-table>
        <el-button type="primary" @click="state.pushTable()" size="small">新增一行</el-button>

        <el-dialog top="20px" title="列表新增字段" :model-value="state.form.setShow" :close-on-click-modal="false"
                   width="500px" append-to-body>
            <el-form :model="state.form.setForm" :rules="state.rules" ref="fieldFormRef"
                     @keyup.enter="state.addField(fieldFormRef)" label-width="100px" @submit.native.prevent>
                <el-form-item label="字段类型：" prop="type">
                    <el-select style="width:100%" v-model="state.form.setForm.type" value-key="label"
                               placeholder="请选择字段类型" filterable>
                        <el-option v-for="(item, index) in state.fieldList" :key="index" :label="item.label"
                                   :value="item"></el-option>
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
import {ElForm} from "element-plus"
import {useI18n} from 'vue-i18n'
import Icon from "/@/components/icon/index.vue";
import BaInput from "/@/components/baInput/index.vue"
import ElLinkSelect from "/@/views/backend/cms/components/elLinkSelect/index.vue"

const fieldFormRef = ref<InstanceType<typeof ElForm>>()
const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])
const state = new customArray(props.modelValue)
const {t} = useI18n()

watch(
    () => state.module.column,
    (newVal) => {
        emit('update:modelValue', {column: state.module.column, table: state.module.table})
    }
)
watch(
    () => state.module.table,
    (newVal) => {
        emit('update:modelValue', {column: state.module.column, table: state.module.table})
    }
)
</script>

<style scoped lang="scss">

.el-table {
  th {
    padding: 0;

    & > .cell {
      color: #001529;
      font-weight: normal;
      font-size: 14px;
      height: 50px;
      line-height: 50px
    }
  }

  img {
    max-width: 100%;
    max-height: 100%;
    vertical-align: middle
  }

  .el-image {
    vertical-align: middle
  }

  .operation {
    font-size: 0
  }

  .cell {
    a {
      font-size: 14px;
      padding: 0 5px;
      border-right: 1px solid rgb(232, 234, 236);
      white-space: nowrap;
      color: #399efd
    }
  }
}

.el-array-title {
  vertical-align: middle;
}

.el-array-remove {
  float: right;
  vertical-align: middle;
  margin-left: 4px;
  margin-top: 9px;
  color: rgb(245, 108, 108);
  font-size: 16px;
  cursor: pointer;
}
</style>
