<!--
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-08-11 11:16:59
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-10-20 11:36:31
 * @FilePath: \web\src\views\backend\cms\catalog\popupForm.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
  <!-- 对话框表单 -->
  <el-dialog
      :fullscreen="true" class="ba-operate-dialog" :close-on-click-modal="false"
      :model-value="!!baTable.form.operate" @close="baTable.toggleForm">
    <template #header>
      <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
        {{ baTable.form.operate ? t(baTable.form.operate) : "" }}
      </div>
    </template>
    <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
      <div
          class="ba-operate-form" :class="'ba-' + baTable.form.operate + '-form'">
        <el-form
            v-if="!baTable.form.loading" ref="formRef" @keyup.enter="baTable.onSubmit(formRef)"
            :model="baTable.form.items" label-position="right" :label-width="baTable.form.labelWidth + 'px'"
            :rules="rules">
          <el-tabs tab-position="left" class="catalog-tabs">
            <el-tab-pane :label="t('cms.catalog.base')">
              <FormItem
                  :label="t('cms.catalog.title')" type="string" v-model="baTable.form.items!.title"
                  prop="title"
                  :input-attr="{
                      placeholder: t('Please input field', { field: t('cms.catalog.title') }),
                  }"/>
              <FormItem
                  :label="t('cms.catalog.catdir')" type="string" v-model="baTable.form.items!.catdir"
                  prop="catdir"
                  :input-attr="{
                      placeholder: t('Please input field', {
                          field: t('cms.catalog.catdir'),
                      }),
                  }"/>
              <el-form-item :label="t('cms.catalog.module_id')" prop="module_id">
                <el-select v-model="baTable.form.items!.module_id" class="w100"
                           :placeholder="t('Please select field', {field: t('cms.catalog.module_id')})">
                  <el-option
                      v-for="item in state.moduleList"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item :label="t('cms.catalog.pid')" prop="pid">
                <el-select v-model="baTable.form.items!.pid" class="w100"
                           :placeholder="t('Please select field', {field: t('cms.catalog.module_id')})">
                  <el-option
                      v-for="item in state.catalogList"
                      :disabled="state.current_id == item.id"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
              <FormItem
                  :label="t('cms.catalog.show')" type="radio" v-model="baTable.form.items!.show"
                  :input-attr="{ size: 'large' }"
                  :data="{
                      childrenAttr: { border: true },
                      content: { 0: '不显示', 1: '都显示', 2: '头部显示', 3: '底部显示' },
                  }"/>
              <FormItem
                  :label="t('cms.catalog.links_type')" type="radio"
                  v-model="baTable.form.items!.links_type" :input-attr="{ size: 'large' }"
                  :data="{
                      childrenAttr: { border: true },
                      content: { 0: '默认', 1: '指定' },
                  }"/>
              <el-form-item :label="t('cms.catalog.links_value')" prop="links_value"
                            :style="baTable.form.items!.links_type == '1' ? 'display: flex' : 'display: none'">
                <ElLinkSelect
                    v-model="baTable.form.items!.links_value" size=""></ElLinkSelect>
              </el-form-item>
              <FormItem
                  :label="t('cms.catalog.description')" type="textarea"
                  v-model="baTable.form.items!.description" prop="description"
                  :input-attr="{
                      rows: 3,
                      placeholder: t('Please input field', {
                          field: t('cms.catalog.description'),
                      }),
                  }"/>
              <FormItem
                  :label="t('cms.catalog.weigh')" type="number" prop="weigh"
                  v-model.number="baTable.form.items!.weigh"
                  :input-attr="{
                      step: '1',
                      placeholder: t('Please input field', { field: t('cms.catalog.weigh') }),
                  }"/>
              <FormItem
                  label="多栏目设置" type="checkbox" v-model="baTable.form.items!.change_all"
                  :input-attr="{ size: 'large' }"
                  :data="{
                      childrenAttr: { border: true },
                      content: { '1': '将以下设置应用到所有子栏目' },
                  }"/>
              <FormItem
                  :label="t('cms.catalog.status')" type="radio" v-model="baTable.form.items!.status"
                  prop="status"
                  :data="{
                      content: { 0: t('cms.catalog.status 0'), 1: t('cms.catalog.status 1') },
                  }"
                  :input-attr="{
                    placeholder: t('Please select field', {
                        field: t('cms.catalog.status'),
                    }),
                }"/>

              <el-form-item :label="t('cms.catalog.template_index')" prop="template_index">
                <el-select
                    v-model="baTable.form.items!.template_index" clearable
                    :placeholder="t('Please select field', { field: t('cms.catalog.template_index') })" class="w100">
                  <el-option v-for="item in state.temp.index" :key="item" :label="item" :value="item"/>
                </el-select>
              </el-form-item>
              <el-form-item :label="t('cms.catalog.template_info')" prop="template_info">
                <el-select
                    v-model="baTable.form.items!.template_info" clearable v-if="baTable.form.items!.module_id > 0"
                    :placeholder="t('Please select field', { field: t('cms.catalog.template_info') })" class="w100">
                  <el-option v-for="item in state.temp.info" :key="item" :label="item" :value="item"/>
                </el-select>
              </el-form-item>
            </el-tab-pane>
            <el-tab-pane :label="t('cms.catalog.seo')">
              <FormItem
                  :label="t('cms.catalog.seo_title')" type="string"
                  v-model="baTable.form.items!.seo_title" prop="seo_title"
                  :input-attr="{
                      placeholder: t('Please input field', {
                          field: t('cms.catalog.seo_title'),
                      }),
                  }"/>
              <FormItem
                  :label="t('cms.catalog.seo_keywords')" type="string"
                  v-model="baTable.form.items!.seo_keywords" prop="seo_keywords"
                  :input-attr="{
                      placeholder: t('Please input field', {
                          field: t('cms.catalog.seo_keywords'),
                      }),
                  }"/>
              <FormItem
                  :label="t('cms.catalog.seo_description')" type="textarea"
                  v-model="baTable.form.items!.seo_description" prop="seo_description"
                  :input-attr="{
                      placeholder: t('Please input field', {
                          field: t('cms.catalog.seo_description'),
                      }),
                  }"/>
            </el-tab-pane>
            <el-tab-pane :label="t('cms.catalog.extend')" style="height: 100%">
              <el-field v-model="baTable.form.items!.field" :ifset="true"></el-field>
            </el-tab-pane>
          </el-tabs>
        </el-form>
      </div>
    </el-scrollbar>
    <template #footer>
      <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
        <el-button @click="baTable.toggleForm('')">{{ t("Cancel") }}</el-button>
        <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)" type="primary">
          {{
            baTable.form.operateIds && baTable.form.operateIds.length > 1
                ? t("Save and edit next item")
                : t("Save")
          }}
        </el-button>
      </div>
    </template>
  </el-dialog>
</template>

<script setup lang="ts">
import {reactive, ref, inject, watch, onMounted} from "vue";
import {useI18n} from "vue-i18n";
import type baTableClass from "/@/utils/baTable";
import FormItem from "/@/components/formItem/index.vue";
import type {ElForm, FormItemRule} from "element-plus";
import {buildValidatorData} from "/@/utils/validate";
import CustomFormItem from "/src/views/backend/cms/components/CustomFormItem/index.vue";
import ElField from "/src/views/backend/cms/components/elField/index.vue";
import createAxios from "/@/utils/axios";
import ElLinkSelect from "/src/views/backend/cms/components/ElLinkSelect/index.vue";

const formRef = ref<InstanceType<typeof ElForm>>();
const baTable = inject("baTable") as baTableClass;

const state: {
  fields: any[]
  template: any[]
  temp: { index: any[]; info: any[] }
  current_id: number

  moduleList: any[]
  catalogList: any[]
} = reactive({
  fields: [],
  template: [],
  temp: {index: [], info: []},
  current_id: 0,

  moduleList: [],
  catalogList: []
});

// 获取template
const getTemplate = () => {
  createAxios(
      {
        url: "/admin/cms.catalog/getTemplate",
        method: "post",
        data: {},
      },
      {
        showSuccessMessage: false,
      }
  ).then((res: any) => {
    state.template = res.data;
    console.log(baTable.form.items);
    const module_id = baTable.form.items!.module_id || 1;
    console.log(state.template, module_id, state.template[module_id]);
    state.temp.index = state.template[module_id]!.index;
    state.temp.info = state.template[module_id]!.info;
  });
};

baTable.before = {
  onSubmit: function (res: any) {
    state.current_id = baTable.form.items!.id;
  },
  toggleForm: function () {
    state.current_id = 0;
  },
};
baTable.after = {
  requestEdit: function (res: any) {
    let fields = [];
    for (const key in res.res.data.fields) {
      fields.push(res.res.data.fields[key]);
    }
    state.fields = fields;
  },
};
getTemplate();
watch(
    () => baTable.form.items!.module_id,
    (newVal) => {
      if (newVal > 0) {
        state.temp.index = state.template[newVal]!["index"];
        state.temp.info = state.template[newVal]!["info"];
      }
    }
);

const {t} = useI18n();

onMounted(() => {
  // 初始化数据表单选项
  createAxios(
      {
        url: "/admin/cms.catalog/initCatalog",
        method: 'post',
        data: {},
      },
      {
        showSuccessMessage: false,
      }
  ).then((res: any) => {
    state.moduleList = res.data.moduleList
    state.catalogList = res.data.catalogList
  })
})

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
  title: [buildValidatorData({name: 'required', title: t('cms.catalog.title')})],
  catdir: [buildValidatorData({name: 'required', title: t('cms.catalog.catdir')})],
});
</script>

<style lang="scss">
// .catalog-tabs .el-tabs__content {
//     padding: 32px;
//     color: #6b778c;
//     font-size: 32px;
//     font-weight: 600;
// }

// .el-tabs--right .el-tabs__content,
// .el-tabs--left .el-tabs__content {
//   height: 100%;
// }
.ba-operate-dialog .el-dialog__body {
  height: 92%;
  padding-top: 0;
  padding-bottom: 52px;
}

.ba-operate-dialog .el-scrollbar__view {
  height: 100%;
}

.ba-operate-form {
  height: 100%;

  .el-form {
    height: 100%;

    .el-tabs {
      height: 100%;

      .el-tabs__content {
        height: 100%;

        .el-tab-pane {
          height: 100%;
        }
      }
    }
  }
}
</style>
