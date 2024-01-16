<template>
  <div class="el-field" :class="{'el-field-set': ifset}" :style="{display: ifset ? 'flex' : 'block'}">
    <el-row class="fields-box" :gutter="20">
      <el-col :xs="24" :span="4" style="height: 100%">
        <div class="el-field-push" v-if="ifset">
          <div class="add-draggable" :ref="tabsRefs.set">
            <div v-for="item in state.fields" class="el-field-move-item">
              <Icon :name="item.icon" color="var(--el-text-color-primary)"/>
              <div class="title">{{ item.label }}</div>
            </div>
          </div>
        </div>
      </el-col>
      <el-col :xs="24" :span="20" style="height: 100%">
        <el-scrollbar class="ba-table-form-scrollbar">
          <div ref="designWindowRef" class="ba-scroll-style" style="height: 100%">
            <div
              v-for="(item, index) in state.module.list"
              :key="index"
              :class="{notset: ifset == false, set: ifset}"
              class="el-field-content"
              :data-id="index"
            >
              <el-form-item :data-id="index" :label="item.label" :key="index" class="el-form-draggable"
                            :class="{'el-form-set': ifset}" v-if="state.module.show">
                <div class="curd-icon" v-if="ifset">
                  <Icon name="el-icon-CopyDocument" class="myicon" color="var(--el-bg-color-overlay)"
                        @click="state.copyItem(item)" title="复制"/>
                  <Icon name="el-icon-Edit" class="myicon" color="var(--el-bg-color-overlay)"
                        @click="state.openItemDialog(item, index)" title="编辑"/>
                  <Icon name="el-icon-Rank" class="rank myicon" color="var(--el-bg-color-overlay)"
                        title="移动"/>
                  <Icon name="el-icon-Delete" class="myicon" color="var(--el-bg-color-overlay)"
                        @click="state.removeItem(index)" title="删除"/>
                </div>
                <div class="w100">
                  <ElLinkSelect v-if="item.type!.type == 'link-select'" v-model="item.type!.value"
                                size=""/>
                  <CustomArray v-else-if="item.type!.type == 'customArray'" v-model="item.type!.value"/>
                  <BaInput
                    v-else
                    @pointerdown.stop
                    v-model="item.type!.value"
                    :type="item.type!.type"
                  />
                </div>
              </el-form-item>
            </div>
            <div class="design-field-empty" v-if="!state.module.list.length && !state.module.draggingField">
              拖动左侧元素至此处开始设计表单
            </div>
          </div>
        </el-scrollbar>
      </el-col>
    </el-row>

    <el-dialog :model-value="state.form.setShow" title="字段设置" width="500px" top="30px" :close-on-click-modal="false"
               append-to-body>
      <template #header>
        <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
          字段设置
        </div>
      </template>
      <el-form
        ref="setFormRef" @keyup.enter="state.submitItem(setFormRef)"
        :model="state.form.setForm" :label-width="labelWidth">
        <el-form-item label="字段标题：" prop="label">
          <el-input v-model="state.form.setForm.label" placeholder="如：内容"></el-input>
        </el-form-item>
        <el-form-item label="字段变量：" prop="field">
          <el-input v-model="state.form.setForm.field" placeholder="如：content"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
          <el-button size="small" type="primary" @click="state.submitItem(setFormRef)">确 定</el-button>
          <el-button size="small" @click="state.closeItemDialog()">取 消</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script setup lang="ts">
import elField from "./elField";
import {onMounted, ref, watch} from "vue";
import {useTemplateRefsList} from "@vueuse/core";
import {ElForm} from "element-plus";
import Icon from "/@/components/icon/index.vue";
import ElLinkSelect from "/@/views/backend/cms/components/elLinkSelect/index.vue";
import CustomArray from "/@/views/backend/cms/components/customArray/index.vue";
import BaInput from "/@/components/baInput/index.vue";
import {useI18n} from "vue-i18n";

const {t} = useI18n()

const designWindowRef = ref()
const setFormRef = ref<InstanceType<typeof ElForm>>();
const props = defineProps(['modelValue', 'labelWidth', 'labelPosition', 'variable', 'ifset', 'repeat'])
const emit = defineEmits(['update:modelValue'])
const state = new elField(props.modelValue)
const tabsRefs = useTemplateRefsList<HTMLElement>()


onMounted(() => {
  state.createSortable(designWindowRef.value)
  tabsRefs.value.forEach((item, index) => {
    state.createTabsRef(item, index)
  })
})
watch(
  state.module.list,
  (newVal) => {
    emit('update:modelValue', newVal)
  }
);
</script>

<style scoped lang="scss">
.el-field {
  height: 100%;

  .fields-box {
    width: 100%;

    .el-field-push {
      height: 100%;
      width: 200px;
      overflow-y: auto;
      overflow-x: hidden;
      padding-right: 10px;

      &::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0);
      }

      &::-webkit-scrollbar {
        width: 6px;
      }

      &:hover::-webkit-scrollbar-thumb {
        background-color: #ccc
      }

      .add-draggable {
        margin: 0 -10px
      }
    }

    .design-field-empty {
      display: flex;
      height: 100%;
      color: var(--el-color-info);
      font-size: var(--el-font-size-medium);
      align-items: center;
      justify-content: center;
    }

    .el-field-content {
      &.set {
        //width: calc(100% - 200px);
        //width: -webkit-calc(100% - 200px);
        //width: -moz-calc(100% - 200px);
        overflow-y: auto;
        overflow-x: hidden;
        padding-left: 10px;
      }

      &.notset {
        height: auto
      }

      &:hover::-webkit-scrollbar-thumb {
        background-color: #ccc;
      }

      &::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0)
      }

      &::-webkit-scrollbar {
        width: 6px;
      }

      .el-form-draggable {
        position: relative;
        margin-bottom: 22px !important;
      }

      .el-form-set {
        position: relative;
        padding: 10px;
        border: 1px dashed #fff;
        margin-bottom: 12px !important;

        &:hover {
          border: 1px dashed #409EFF;

          .curd-icon {
            display: block;
          }
        }

        .curd-icon {
          position: absolute;
          top: -10px;
          right: -10px;
          background: #409EFF;
          display: none;
          cursor: pointer;
          z-index: 2;
          line-height: 26px;

          .myicon {
            color: #fff;
            font-size: 16px;
            margin: 5px;
          }

          .rank {
            cursor: move
          }
        }
      }

      .empty {
        min-height: 400px;

        &:before {
          content: "请拖动表单到此处";
        }
      }
    }
  }
}

.el-field-move-item {
  width: 169px;
  text-align: center;
  cursor: move;
  overflow: hidden;
  border: 1px dashed #ccc;
  padding: 10px;
  margin: 10px;

  &:first-child {
    margin-top: 0
  }

  .iconfont {
    margin-bottom: 10px;
    display: block;
    font-size: 20px;
    color: #333;
    height: 20px;
    line-height: 20px;
  }

  .title {
    height: 20px;
    line-height: 20px;
    overflow: hidden;
  }
}
</style>
