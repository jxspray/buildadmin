<template>
    <el-input :value="title" :size="size" @focus="dialog = true">
        <i slot="suffix" class="el-input__icon el-icon-arrow-right"></i>
    </el-input>
    <el-dialog v-if="dialog" class="el-link-dialog" top="20px" title="设置链接" width="540px" :visible.sync="dialog" :close-on-click-modal="false" append-to-body>
        <el-form :model="valueForm" ref="valueForm" :rules="rules" label-width="100px" :validate-on-rule-change="false" @submit.native.prevent>
            <el-form-item label="链接类型：" prop="type">
                <el-radio-group v-model="linkForm.type" @change="typeChange()">
                    <el-radio v-for="(item, index) in typeList" :label="String(index)" :key="index">
                        {{item}}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
            <template v-if="linkForm.type == 1">
            <el-form-item label="链接：" prop="url">
                <el-input v-model="valueForm.url" placeholder="请填写链接"></el-input>
            </el-form-item>
            </template>
            <template v-if="linkForm.type == 2">
                <el-form-item label="类型：" prop="table">
                    <el-select placeholder="请选择类型" v-model="valueForm.table" @change="detailsListSearch()" filterable>
                        <el-option v-for="(item, index) in tableList" :label="item.title" :value="item.table"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item v-if="valueForm.table != ''" label="链接：" prop="details">
                    <el-select value-key="id" placeholder="请选择链接，输入标题远程搜索" v-model="valueForm.details" reserve-keyword filterable remote :remote-method="detailsListSearch">
                        <el-option v-for="(item, index) in detailsList" :key="index" :label="item.title" :value="item"></el-option>
                    </el-select>
                </el-form-item>
            </template>
            <template v-if="linkForm.type == 3">
                <el-form-item label="分类：" prop="catalog">
                    <el-select v-model="valueForm.catalog" value-key="id" placeholder="请选择分类" filterable>
                        <el-option v-for="(item, index) in catalogList" :key="index" :label="item.title" :value="item">
                            <span v-html="item.treeString"></span>
                            {{ item.title }}
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="锚点：" prop="anchor">
                    <el-input v-model="valueForm.anchor" placeholder="如：#about"></el-input>
                </el-form-item>
            </template>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button size="small" type="primary" @click="determine">确定</el-button>
            <el-button size="small" @click="dialog = false">取消</el-button>
        </span>
    </el-dialog>
</template>

<script setup lang="ts">
import { reactive, computed, onMounted } from 'vue'
const props = withDefaults(defineProps(['modelValue', 'size']), {
    modelValue: () => []
})
defineEmits(['update:modelValue'])

const state = reactive({
    value: props.modelValue,
    keyTitle: props.keyTitle ? props.keyTitle : t('utils.ArrayKey'),
    valueTitle: props.valueTitle ? props.valueTitle : t('utils.ArrayValue'),
})

onMounted(() => {
  console.log(`the component is now mounted.`)
})
</script>