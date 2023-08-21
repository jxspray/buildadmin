<!--
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-07-17 10:42:44
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-08-21 13:51:15
 * @FilePath: \web\src\views\backend\cms\content\loading.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
    <!-- 表单 -->
    <div class="default-main ba-table-box">
        <!-- 表单 -->
        <!-- <component
            :is="item.comSearchCustomRender"
            :renderRow="item"
            :renderField="item.prop!"
            :renderValue="baTable.comSearch.form[item.prop!]"
        /> -->
        <Index />
    </div>
</template>

<script setup lang="ts">
import { defineAsyncComponent } from 'vue'

const Index = defineAsyncComponent(() => {
    return import('./defalut/index.vue')
})

</script>

<style scoped lang="scss"></style>
