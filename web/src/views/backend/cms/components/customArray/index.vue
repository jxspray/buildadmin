<template>
  <div class="el-array" ref="elArray">
    <el-button type="primary" @click="unshiftTable()" size="small">新增一行</el-button>
    <el-table :data="state.table" row-key="id" border>
      <el-table-column v-for="(item, index) in state.column" :prop="item.field" :key="index" :width="item.type.width">
        <template #header>
          <el-tooltip :content="item.field" placement="top">
            <span class="el-array-title">{{item.label}}</span>
          </el-tooltip>
          <el-tooltip content="删除字段" placement="top">
            <Icon name="el-icon-Delete" class="el-array-remove" color="var(--el-color-error)" @click="delField(index)"/>
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
          <el-button type="primary" @click="state.dialog = true" size="small">新增字段</el-button>
        </template>
        <template #default="scope">
          <a href="javascript:" @click="removeTable(scope.$index)">删除</a>
          <a href="javascript:" @click="pushTable(scope.$index)">追加</a>
        </template>
      </el-table-column>
    </el-table>
    <el-button type="primary" @click="pushTable()" size="small">新增一行</el-button>
    <el-dialog top="20px" title="列表新增字段" :model-value="state.dialog" :close-on-click-modal="false" width="500px" append-to-body>
      <el-form :model="state.fieldForm" :rules="rules" ref="fieldFormRef" @keyup.enter="addField(fieldFormRef)" label-width="100px" @submit.native.prevent>
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
import {onMounted, reactive, ref, watch} from 'vue'
import { useI18n } from 'vue-i18n'
import {ElForm, FormInstance, FormItemRule} from "element-plus";
import {buildValidatorData} from "/@/utils/validate";
import BaInput from "/@/components/baInput/index.vue";
import ElLinkSelect from "/@/views/backend/cms/components/elLinkSelect/index.vue";

interface FieldType { label: string, type: string, width: string, value: any }
interface ValueProps {
  column: { label: string, field: string, type: FieldType }[]
  table: any[]
}

const { t } = useI18n()

const fieldFormRef = ref<InstanceType<typeof ElForm>>();
const props = withDefaults(defineProps<{ modelValue: ValueProps }>(), {
    modelValue: () => []
})
const emit = defineEmits(['update:modelValue'])

const state: {
  value: ValueProps
  column: { type: FieldType, label: string, field: string }[]
  table: any[]
  dialog: boolean
  fieldForm: { type: FieldType, label: string, field: string }
  fieldList: FieldType[]
} = reactive({
  value: props.modelValue,
  column: [],
  table: [],
  dialog: false,
  fieldForm: {
    label: '',
    field: '',
    type: {},
  },
  fieldList: [
    {label: '文本', type: 'string', width:'200px', value: ''},
    {label: '文本域', type: 'textarea', width:'300px', value: ''},
    {label: '编辑器', type: 'editor', width:'700px', value: ''},
    {label: '图片上传', type: 'image', width:'344px', value: ''},
    {label: '文件上传', type: 'file', width:'344px', value: ''},
    {label: '链接', type: 'link-select', width:'300px', value: {}}
  ]
})
const unshiftTable = () => {
  let ob = {};
  state.column.forEach( function (item, index) {
    ob[item.field] = item.type.value;
  });
  console.log(ob)
  state.table.unshift(ob);
}
/**
 * 新增字段
 */
const addField = (formEl: FormInstance | undefined = undefined) => {
  if (formEl) {
    formEl.validate((valid: boolean) => {
      if (valid) {
        let row = JSON.parse(JSON.stringify(state.fieldForm))
        state.column.push(row)
        state.table.map(item => {
          item[row.field] = row.type.value
          return item
        })
        state.dialog = false
        state.fieldForm = {}
      }
    })
  } else {
    return false;
  }
}
/**
 * 删除字段
 */
const delField = (index) => {
  let prop = state.column[index]['field'];
  state.column.splice(index, 1);
  state.table.forEach(function(item, index) {
    this.$delete(item, prop);
  });
}
/**
 * 新增行
 */
const pushTable = (index = "") => {
  let ob = {};
  state.column.forEach( function (item, index) {
    ob[item.field] = item.type.value;
  });
  index === "" ? state.table.push(ob) : state.table.splice(index + 1, 0, ob);
}

/**
 * 删除数组
 */
const removeTable = (index) => {
  state.table.splice(index, 1);
}

onMounted(() => {
  let bool = JSON.stringify(state.value) == "{}" || state.value == '';
  state.table = bool ?  [] : state.value.table;
  state.column = bool ? [{label: '标题', field: 'title', type: {label: '文本', type: 'string', width: "300px", value: ''}}] : state.value.column;
})
watch(
    () => state.value,
    (newVal) => {
      let bool = JSON.stringify(newVal) == "{}" || newVal == '';
      state.table = bool ?  [] : newVal.table;
      state.column = bool ? [{label: '标题', field: 'title', type: {label: '文本', is: 'el-input', value: ''}}] : newVal.column;
    }
)
watch(
    () => state.column,
    (newVal) => {
      emit('update:modelValue', {column: state.column, table: state.table})
    }
)
watch(
    () => state.table,
    (newVal) => {
      emit('update:modelValue', {column: state.column, table: state.table})
    }
)

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
  label: [buildValidatorData({name: 'required', title: t('字段标题')})],
  field: [buildValidatorData({name: 'required', title: t('字段变量')})],
  type: [buildValidatorData({name: 'required', title: t('字段类型')})],
})
</script>

<style scoped lang="scss">

.el-table {
  th {
    padding: 0;
    &>.cell {
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
  color: rgb(245,108,108);
  font-size: 16px;
  cursor: pointer;
}
</style>
