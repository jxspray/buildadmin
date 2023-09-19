<template>
    <div class="default-main ba-table-box">
        <div class="custom-tabs">
            <el-tabs v-model="state.activeName" @tab-click="tabClick">
                <el-tab-pane v-for="(tab, name) in state.configData" :label="t(name)" :name="name">
                    <div class="custom-body">
                        <el-row :gutter="30">
                            <el-col :xs="24" :sm="12" :md="8" :lg="6" :xl="6" v-for="item in tab">
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
                                        <div class="config-item-btn display-flex-c" :style="item.button" @click="operation(item.id,item.title)">立即设置</div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
        
        <!-- 表单 -->
        <!-- <PopupForm :show="state.show" :type="state.type" /> -->
        <el-dialog
            class="ba-operate-dialog"
            :close-on-click-modal="false"
            :model-value="state.modelShow ? true : false"
            @close="closeModel"
            width="50%"
        >
            <template #header>
                <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                    {{ state.modelTitle }}
                </div>
            </template>
            <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
                <div
                    class="ba-operate-form"
                    :class="'ba-edit-form'"
                >
                    <el-form
                        v-if="!baTable.form.loading"
                        ref="formRef"
                        @keyup.enter="onSubmit(formRef)"
                        :model="baTable.form"
                        label-position="right"
                        :rules="rules"
                    >
                        <template v-if="state.type == 'cms'">
                            <FormItem :label="t('网站名称')" type="string" v-model="baTable.form.items!.site_name" prop="site_name" :input-attr="{ placeholder: t('Please input field', { field: t('网站名称') }) }" />
                            <FormItem :label="t('网站网址')" type="string" v-model="baTable.form.items!.site_url" prop="site_url" :input-attr="{ placeholder: t('Please input field', { field: t('网站网址') }) }" />
                            <FormItem :label="t('网站邮箱')" type="string" v-model="baTable.form.items!.site_email" prop="site_email" :input-attr="{ placeholder: t('Please input field', { field: t('网站邮箱') }) }" />
                            <FormItem :label="t('座机号')" type="string" v-model="baTable.form.items!.tel" prop="tel" :input-attr="{ placeholder: t('Please input field', { field: t('座机号') }) }" />
                        </template>
                        <template v-if="state.type == 'base'">
                            <FormItem :label="t('网站head区域')" type="string" v-model="baTable.form.items!.head" prop="head" :input-attr="{ placeholder: t('Please input field', { field: t('网站head区域') }) }" />
                            <FormItem :label="t('网站foot区域')" type="string" v-model="baTable.form.items!.foot" prop="foot" :input-attr="{ placeholder: t('Please input field', { field: t('网站foot区域') }) }" />
                            <FormItem :label="t('电脑端商桥代码')" type="string" v-model="baTable.form.items!.pc_shangqiao" prop="pc_shangqiao" :input-attr="{ placeholder: t('Please input field', { field: t('电脑端商桥代码') }) }" />
                            <FormItem :label="t('移动端商桥代码')" type="string" v-model="baTable.form.items!.wap_shangqiao" prop="wap_shangqiao" :input-attr="{ placeholder: t('Please input field', { field: t('移动端商桥代码') }) }" />
                            <FormItem :label="t('商桥链接')" type="string" v-model="baTable.form.items!.kefu_link" prop="kefu_link" :input-attr="{ placeholder: t('Please input field', { field: t('商桥链接') }) }" />
                        </template>
                    </el-form>
                </div>
            </el-scrollbar>
            <template #footer>
                <div>
                    <el-button @click="baTable.toggleForm('')">{{ t('Cancel') }}</el-button>
                    <el-button v-blur :loading="baTable.form.submitLoading" @click="onSubmit(formRef)" type="primary">
                        {{ t('Save') }}
                    </el-button>
                </div>
            </template>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, inject, provide } from 'vue'
import baTableClass from '/@/utils/baTable'
import { baTableApi } from '/@/api/common'
import type { ElForm, FormInstance, FormItemRule, TabsPaneContext } from 'element-plus'
import FormItem from '/@/components/formItem/index.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const formRef = ref<InstanceType<typeof ElForm>>()
// const baTable = inject('baTable') as baTableClass
const baTable = new baTableClass(
    new baTableApi('/admin/cms.config/'),
    { pk: 'name', column: [] }
)
// import PopupForm from './popupForm.vue'
defineOptions({
    name: 'cms/config',
})
provide('baTable', baTable)

const state: {
    configData: {
        [key: string]: {
            id: string,
            title: string,
            tip: string,
            message: string,
            icon: string,
            leaf: string,
            background: string,
            url: string,
            button: { background: string, color: string }
        }[]
    },
    activeName: string,
    type: string,
    modelShow: boolean,
    modelTitle: string,
} = reactive({
    configData: {
        basic: [
            {
                id: 'cms', 
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
        ],
        block: [
            {
                id: 'base', 
                title: '基础碎片',
                tip: '必要的文本内容',
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
        ],
    },
    activeName: 'basic',
    type: '',
    modelShow: false,
    modelTitle: '',
    loading: false
})

const loadOperation = (id: string) => {
    state.type = id
    
    baTable.form.loading = true
    baTable.form.items = {}
    return baTable.api
        .edit({
            [baTable.table.pk!]: id,
        })
        .then((res) => {
            baTable.form.items = res.data.row.value
            console.log(baTable.form.items)
        })
        .catch((err) => {
            baTable.toggleForm()
        })
        .finally(() => {
            baTable.form.loading = false
        })
}

const operation = ((id: string, title: string) => {
    openModel(title)
    loadOperation(id)
})



    /**
     * 提交表单
     * @param formEl 表单组件ref
     */
const onSubmit = (formEl: FormInstance | undefined = undefined) => {
    let value: { [key: string]: string } = {}
    Object.keys(baTable.form.items!).forEach((item) => {
        value[item] = baTable.form.items![item] === null ? '' : baTable.form.items![item]
    })

    
    // 表单验证通过后执行的api请求操作
    const submitCallback = () => {
        baTable.form.submitLoading = true
        console.log({ name: state.type, value: value })
        baTable.api
            .postData('edit', { name: state.type, value: value })
            .then((res) => {
                baTable.toggleForm()
                state.modelShow = false
            })
            .finally(() => {
                baTable.form.submitLoading = false
            })
    }

    if (formEl) {
        baTable.form.ref = formEl
        formEl.validate((valid: boolean) => {
            if (valid) {
                submitCallback()
            }
        })
    } else {
        submitCallback()
    }
}

const openModel = (title: string) => {
    state.modelShow = true
    state.modelTitle = title
}

const closeModel = () => {
    state.modelShow = false
    state.modelTitle = ''
}

const tabClick = (tab: TabsPaneContext, event: Event) => {

}
const rules: Partial<Record<string, FormItemRule[]>> = reactive({
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
                .config-item-icon-container {
                    margin-top: 30px;
                    position: relative;
                    display: flex;
                    height: 48px;
                    .item-icon-1 {
                        width: 48px;
                        height: 48px;
                        border-radius: 50%;
                    }
                    .item-icon-2 {
                        width: 48px;
                        height: 48px;
                        background: #fff;
                        border-radius: 50%;
                        position: absolute;
                        left: 36px;
                        opacity: 0.5;
                    }
                }
                .config-title {
                    font-size: 22px;
                    margin-top: 28px;
                }
                .config-tip {
                    font-size: 14px;
                    color: rgba(255, 255, 255, 0.8);
                    margin-top: 14px;
                }
            }
            .set-container {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                .config-item-leaf-container {
                    display: flex;
                    flex: 1;
                    .item-leaf-1 {
                        .leaf {
                            width: 54px;
                            height: 54px;
                        }
                        .leaf-11 {
                            background: rgba(255, 255, 255, 0.2);
                            border-radius: 0px 34px;
                        }
                        .leaf-12 {
                            border-radius: 0px 35px;
                            transform: matrix(-1, 0, 0, 1, 0, 0);
                        }
                        .leaf-13 {
                            background: rgba(255, 255, 255, 0.66);
                            border-radius: 0px 34px;
                        }
                    }
                    .item-leaf-2 {
                        width: 40px;
                        height: 40px;
                        background: rgba(255, 255, 255, 0.4);
                        border-radius: 6px;
                        transform: rotate(-45deg);
                        margin-top: 86px;
                        margin-left: 10px;
                    }
                }
                
                .config-item-btn {
                    width: 98px;
                    height: 40px;
                    border-radius: 20px;
                    font-size: 14px;
                    cursor: pointer;
                }
            }
        }
    }
}
</style>
<style>
/* 重写Element样式 */
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
    /* color: #666; */
}

/* 公共样式 */
.display-flex-c {
    display: flex;
    align-items: center;
    justify-content: center;
}
.ellipsis-item {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}
</style>
