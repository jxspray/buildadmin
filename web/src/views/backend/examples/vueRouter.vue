<template>
    <div class="default-main">
        <el-collapse class="collapse" v-model="state.collapseActiveName">
            <el-collapse-item title="动态添加静态路由" name="create">
                <div class="sub-title">建立组件与路由的映射关系</div>
                <div class="form-box">
                    <el-form label-width="120px" :model="state.createRoute">
                        <FormItem label="路由名称" type="string" placeholder="选填的" v-model="state.createRoute.name" />
                        <FormItem label="路由路径" type="string" v-model="state.createRoute.path" />
                        <FormItem
                            label="组件物理路径"
                            type="string"
                            v-model="state.createRoute.component"
                            :input-attr="{
                                disabled: true,
                            }"
                        />
                        <div class="form-buttons">
                            <el-button @click="createRoute(false)" type="success">创建</el-button>
                        </div>
                    </el-form>
                    <div class="sub-title">路由建立后就可以导航到它对应的组件</div>
                    <div class="sub-buttons">
                        <el-button @click="router.push({ path: state.createRoute.path })">导航到以上添加的路由</el-button>
                        <el-button @click="router.push({ name: state.createRoute.name })">通过路由名称导航到以上添加的路由</el-button>
                    </div>
                </div>
            </el-collapse-item>
            <el-collapse-item title="动态路由" name="dynamic-route">
                <div class="sub-title">可以接受动态参数的路由</div>
                <div class="form-box">
                    <el-form label-width="120px" :model="state.createRoute">
                        <FormItem label="路由名称" type="string" placeholder="选填的" v-model="state.createRoute.name" />
                        <FormItem label="路由路径" type="string" v-model="state.createRoute.path" />
                        <FormItem
                            label="组件物理路径"
                            type="string"
                            v-model="state.createRoute.component"
                            :input-attr="{
                                disabled: true,
                            }"
                        />
                        <div class="form-buttons">
                            <el-button @click="addIdParam"> 为路由路径添加名为 id 的路径参数 </el-button>
                            <el-button @click="createRoute(false)" type="success">创建</el-button>
                        </div>
                    </el-form>
                </div>

                <div class="form-box">
                    <div class="sub-title">请创建一个有路径参数的路由，然后您就可以携带参数导航</div>
                    <el-form label-width="120px" :model="state.createRoute">
                        <FormItem label="id参数值" type="string" v-model="state.createRoute.id" />
                        <div class="form-buttons">
                            <el-button @click="pushRouteWithParam('path')">导航</el-button>
                            <el-button @click="pushRouteWithParam('name')">通过路由名称导航</el-button>
                        </div>
                    </el-form>
                </div>
            </el-collapse-item>
            <el-collapse-item title="BuildAdmin顶栏tab菜单" name="tabs">
                <div class="sub-title">注册 mete.addtab=true 的路由 BuildAdmin 即可自动生成顶栏 tab</div>
                <div class="form-box">
                    <el-form label-width="120px" :model="state.createRoute">
                        <FormItem label="路由名称" type="string" placeholder="选填的" v-model="state.createRoute.name" />
                        <FormItem label="路由路径" type="string" v-model="state.createRoute.path" />
                        <FormItem
                            label="组件物理路径"
                            type="string"
                            v-model="state.createRoute.component"
                            :input-attr="{
                                disabled: true,
                            }"
                        />
                        <div class="form-buttons">
                            <el-button @click="createRoute(true)" type="success">创建可自动生成tab的路由</el-button>
                            <el-button @click="router.push({ path: state.createRoute.path })">导航</el-button>
                            <el-button @click="router.push({ name: state.createRoute.name })">通过路由名称导航</el-button>
                        </div>
                    </el-form>
                </div>
            </el-collapse-item>
        </el-collapse>
        <div class="vue-router-link">
            <el-link target="_blank" type="primary" href="https://router.vuejs.org/zh/introduction.html"> vue-router中文文档 </el-link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import { useRouter } from 'vue-router'
import FormItem from '/@/components/formItem/index.vue'

const router = useRouter()
let removeRoute: any = null

const state = reactive({
    collapseActiveName: ['create', 'dynamic-route', 'tabs'],
    createRoute: {
        id: '',
        name: '',
        path: '/admin/examples/routerExample',
        component: '/@/views/backend/examples/routerExampleComponent.vue',
    },
})

const createRoute = (tab: boolean) => {
    if (!state.createRoute.path) {
        ElMessage({
            message: '路由路径必填！',
            type: 'error',
        })
        return
    }

    removeRoute && removeRoute()

    // 导入组件需要使用字面量，所以不能由用户输入
    const component = () => import('/@/views/backend/examples/routerExampleComponent.vue')

    // 参数一为上级路由name，参数二为要添加的路由数据
    removeRoute = router.addRoute('admin', {
        name: state.createRoute.name,
        path: state.createRoute.path,
        component: component,
        meta: {
            title: '路由导航示例',
            addtab: tab,
        },
    })

    ElMessageBox.alert('路由已经添加，现在可以访问该路由了，我们在F12控制台打印了所有已注册的路由', '提示', {
        confirmButtonText: '我知道了',
        callback: () => {
            console.log(router.getRoutes())
        },
    })
}

const addIdParam = () => {
    const reg = /\/$/gi
    state.createRoute.path = state.createRoute.path.replace(reg, '')
    state.createRoute.path = `${state.createRoute.path}/:id`
}

const pushRouteWithParam = (type: string) => {
    if (!state.createRoute.id) {
        ElMessage({
            message: '请输入 id 值！',
            type: 'error',
        })
        return
    }

    // 通过name导航可直接传递params
    if (type == 'name') {
        router.push({
            name: state.createRoute.name,
            params: {
                id: state.createRoute.id,
            },
        })
        return
    }

    // 通过path导航，手动拼接params
    const reg = /\/:id$/gi
    const path = state.createRoute.path.replace(reg, '')
    router.push(`${path}/${state.createRoute.id}`)
}
</script>

<style scoped lang="scss">
.collapse {
    padding: 20px;
    border-radius: var(--el-border-radius-base);
    background-color: var(--ba-bg-color-overlay);
}
.sub-title {
    text-align: center;
    padding: 20px;
    font-size: var(--el-font-size-medium);
}
.form-box {
    width: 600px;
    margin: 0 auto;
    .form-buttons {
        margin-left: 120px;
    }
}
.sub-buttons {
    display: flex;
    justify-content: center;
}
.vue-router-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 0;
    :deep(.el-link__inner) {
        font-size: var(--el-font-size-large);
    }
}
</style>
