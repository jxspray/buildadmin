<template>
    <div class="default-main">
        <p>路由导航示例，您现在位于：/@/views/backend/examples/routerExampleComponent.vue 组件</p>
        <p>路由路径是：{{ route.path }}</p>
        <p>路由名称是：{{ route.name }}</p>
        <p>路由参数：{{ route.params }}</p>
        <p>路由query：{{ route.query }}</p>
        <p>路由hash：{{ route.hash }}</p>
    </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'
const route = useRoute()
</script>

<style scoped lang="scss"></style>
