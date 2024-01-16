<script setup lang="ts">
import {reactive} from "vue";
import ElField from "/@/views/backend/cms/components/elField/index.vue";
import {useI18n} from "vue-i18n";
import baTableClass from "/@/utils/baTable";
import {baTableApi} from "/@/api/common";
const {t} = useI18n();

const state = reactive({
  show: false,
  activeTab: "top",
  loading: false,
  submitLoading: false,
  value: {
    top: []
  }
})
const baTable = new baTableClass(
  new baTableApi('/admin/cms.config/'),
  {pk: 'name', column: []}
)
const onClose = () => {
  state.show = false;
}
const onOpen = () => {
  state.show = true;
  state.loading = true;
  return baTable.api
    .edit({
      [baTable.table.pk!]: "common",
      group: "catalog",
    })
    .then((res) => {
      state.value = res.data.row.value
      state.loading = false;
    })
    .catch((err) => {
      state.loading = false;
      onClose()
    })
}
const onSubmit = () => {
  state.submitLoading = true
  baTable.api
    .postData('edit', {name: "common", group: "catalog", value: state.value})
    .then((res) => {
      state.submitLoading = false
      onClose()
    })
    .finally(() => {
      state.submitLoading = false
    })
}
</script>

<template>
  <el-tooltip content="字段管理" placement="top">
    <el-button @click="onOpen" v-blur class="table-header-operate" type="success">
      <span class="table-header-operate-text">字段管理</span>
    </el-button>
  </el-tooltip>
  <el-dialog
    :fullscreen="true" class="ba-operate-dialog" :close-on-click-modal="false"
    :model-value="state.show" @close="onClose">
    <template #header>
      <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">字段管理</div>
    </template>
    <el-scrollbar v-loading="state.loading" class="ba-table-form-scrollbar">
      <div class="ba-operate-form">
        <el-tabs tab-position="top" v-model="state.activeTab" v-if="!state.loading">
          <el-tab-pane label="头部" name="top">
            <el-field v-model="state.value!.top" :ifset="true" v-if="state.show"></el-field>
          </el-tab-pane>
          <el-tab-pane label="底部" name="foot">
            <el-field v-model="state.value!.foot" :ifset="true" v-if="state.show"></el-field>
          </el-tab-pane>
        </el-tabs>
      </div>
    </el-scrollbar>
    <template #footer>
      <div>
        <el-button @click="onClose">{{ t("Cancel") }}</el-button>
        <el-button v-blur :loading="state.submitLoading" @click="onSubmit" type="primary">{{t("Save")}}</el-button>
      </div>
    </template>
  </el-dialog>
</template>

<style scoped lang="scss">
.ba-operate-dialog {
  .el-dialog__body {
    height: 92%;
    padding-top: 0;
    padding-bottom: 52px;
  }
  .el-scrollbar__view {
    height: 100%;
    .el-tabs__content {
      height: 100%;

      .el-tab-pane {
        height: 100%;
      }
    }
  }
}
</style>
