<!--
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-08-11 15:39:56
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-08-31 18:23:15
 * @FilePath: \web\src\views\backend\cms\config\index.vue
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
-->
<template>
    <div class="default-main ba-table-box">
        <div class="custom-tabs">
            <el-tabs>
                <el-tab-pane label="基础配置" name="basic">
                    <div class="custom-body">
                        <el-row :gutter="30">
                            <el-col :xs="24" :sm="12" :md="8" :lg="6" :xl="6" v-for="(item, baseIndex) in state.configData.basic">
                                <div class="config-item" :style="{background:item.background}">
                                    <div class="tip-container">
                                        <div class="config-item-icon-container"
                                            style="margin-top: 30px;position: relative;display: flex;">
                                            <div class="item-icon-1"><img :src="'/src/assets/addons/cms/img/config/' + item.icon + '.png'" />
                                            </div>
                                            <div class="item-icon-2"></div>
                                        </div>
                                        <div class="config-title">{{item.title}}</div>
                                        <div class="config-tip ellipsis-item">{{item.tip}}</div>
                                        <div class="config-message ellipsis-item">{{item.message}}</div>
                                    </div>
                                    <div class="set-container">
                                        <div class="config-item-leaf-container">
                                            <div class="item-leaf-1">
                                                <div class="leaf leaf-11"></div>
                                                <div class="leaf leaf-12" :style="{background:item.leaf}"></div>
                                                <div class="leaf leaf-13"></div>
                                            </div>
                                            <div class="item-leaf-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
defineOptions({
    name: 'cms/config',
})

const state: {
    configData: { 
        basic: {
            id: string,
            title: string,
            tip: string,
            message: string,
            icon: string,
            leaf: string,
            background: string,
            url: string,
            button: object
        }[] 
    }
} = reactive({
    configData: {
        basic: [
            {
                id: 'share',
                title: '基本配置',
                tip: '配置默认站点基本信息',
                message: '',
                icon: 'cms-icon',
                leaf: '#915CF9',
                background: 'linear-gradient(180deg, #D5B8FA 0%, #8F62C9 100%)',
                url: "",
                button: {
                    background: '#E7DEF6',
                    color: '#6625CF'
                },
            },
            {
                id: 'share',
                title: '基本配置',
                tip: '配置默认站点基本信息',
                message: '',
                icon: 'cms-icon',
                leaf: '#915CF9',
                background: 'linear-gradient(180deg, #D5B8FA 0%, #8F62C9 100%)',
                url: "",
                button: {
                    background: '#E7DEF6',
                    color: '#6625CF'
                },
            },
            {
                id: 'share',
                title: '基本配置',
                tip: '配置默认站点基本信息',
                message: '',
                icon: 'cms-icon',
                leaf: '#915CF9',
                background: 'linear-gradient(180deg, #D5B8FA 0%, #8F62C9 100%)',
                url: "",
                button: {
                    background: '#E7DEF6',
                    color: '#6625CF'
                },
            }
        ]
    },
})
</script>

<style scoped lang="scss">
.default-main {
    background: #fff;
    border-radius: 10px 10px 0px 0px;
    color: #444;
    font-weight: 500;
    .custom-tabs {
        padding-top: 12px;
    }

    .custom-body {
        padding: 30px 30px 0;
        .config-item {
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            /* max-width: 370px; */
            height: 254px;
            border-radius: 20px;
            padding: 0 10px 24px;
            margin-bottom: 30px;
            display: flex;
            align-items: stretch;
            color: #fff;
            justify-content: space-between;
            .tip-container {
                padding: 0 10px;
            }
        }
    }
}
</style>
<!-- 重写Element样式 -->
<style>
.default-main .custom-tabs .el-tabs__nav {
    margin-left: 30px;
}
.default-main .custom-tabs .el-tabs__item {
    margin-bottom: 8px;
    width: 120px;
}
.default-main .custom-tabs .el-tabs__item {
    width: 80px;
    padding: 0;
    padding-right: 20px;
    text-align: center;
    color: #666;
}
</style>
