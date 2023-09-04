<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="$props.type ? true : false"
        width="50%"
    >
    </el-dialog>
</template>

<script setup lang="ts">
const props = defineProps({
    type: String,
    show: Boolean
})
console.log(props.type)
</script>

<style scoped lang="scss"></style>
