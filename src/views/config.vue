<template>
    <div>
        <Header />
        <div class="container">
            <div class="table-title">{{ t('Site configuration') }}</div>
            <div v-if="state.showInstallTips" class="install-tips-box">
                <div class="install-tips">
                    <img
                        class="install-tips-close"
                        @click="state.showInstallTips = false"
                        src="~assets/img/install/fail.png"
                        :alt="t('Close the prompt of completing unfinished matters manually')"
                    />
                    <div class="install-tips-title">
                        <span>{{ t('Install Tips Title 1') }}</span>
                        <span class="change-route" @click="common.setStep('check')">
                            {{ t('Back to previous page') }}
                        </span>
                        <span>{{ t('Install Tips Title 2') }}</span>
                    </div>
                    <div class="install-tips-item">
                        {{ t("If you don't want to open the corresponding permission due to some security factors, please check ") }}
                        <span @click="goUrl('https://wonderful-code.gitee.io/guide/install/senior.html')" class="change-route">
                            {{ t('how installation services ensure system security') }}
                        </span>
                    </div>
                    <div class="install-tips-item">
                        {{ t("If you really can't adjust all the tests to pass, please ") }}
                        <a class="change-route" href="https://gitee.com/wonderful-code/buildadmin/issues" target="_blank">
                            {{ t('click to feed back to us') }}
                        </a>
                        {{ t('continue installation') }}
                    </div>
                </div>
            </div>
            <div class="table">
                <el-form ref="formRef" label-width="150px" @keyup.enter="submitBaseConfig(formRef)" :rules="rules" :model="state.formItem">
                    <transition name="slide-bottom">
                        <div v-show="state.showError" class="table-column table-error">{{ state.showError }}</div>
                    </transition>
                    <transition-group name="slide-bottom">
                        <div v-show="state.showFormItem" v-for="(item, idx) in state.formItem" :key="idx">
                            <div v-if="item.type == 'br'" class="table-item-br"></div>
                            <div v-else class="table-column table-item">
                                <el-form-item :prop="item.name" class="table-label" :label="item.label">
                                    <el-input
                                        :placeholder="item.placeholder ? item.placeholder : ''"
                                        v-model="item.value"
                                        class="table-input"
                                        :type="item.type"
                                    ></el-input>
                                    <div class="block-help" v-if="item.blockHelp">{{ item.blockHelp }}</div>
                                </el-form-item>
                            </div>
                        </div>
                    </transition-group>
                    <transition name="slide-bottom">
                        <div v-show="state.showFormItem">
                            <div v-show="state.databaseCheck == 'connecting'" class="connecting-prompt">
                                <span>{{ t('Test connection to data server') }}</span>
                            </div>
                            <div class="footer-buttons">
                                <el-button class="button" @click="common.setStep('check')">{{ t('Previous step') }}</el-button>
                                <el-button type="primary" class="button" @click="submitBaseConfig(formRef)" :loading="state.baseConfigSubmitState">
                                    {{ t('Install now') }}
                                </el-button>
                            </div>
                        </div>
                    </transition>
                </el-form>
            </div>
        </div>
    </div>
    <el-dialog
        v-model="state.execMigrateFail"
        top="5vh"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :show-close="false"
        :title="t('Table migration failed')"
    >
        <el-alert :title="t('We use Phinx to manage the data table, which can version the data table')" :closable="false" center type="info" />
        <div class="phinx-fail-box">
            <div class="title">
                {{ t('Data table automatic migration failed, please manually migrate as follows:') }}
            </div>
            <div class="content-item">1、{{ t('Open terminal (windows PowerShell)') }}</div>
            <div class="content-item">
                <div>2、{{ t('Execute command') }}</div>
                <div class="command">cd {{ state.rootPath }}</div>
            </div>
            <div class="content-item">
                <div>3、{{ t('Execute command') }}</div>
                <div class="command">php think migrate:run</div>
                <div class="block-help">
                    {{ t('If the command fails to be executed, add sudo or press the error message') }}
                </div>
            </div>
            <div class="content-item">
                <div>4、{{ t('Migration check') }}</div>
                <div class="text">
                    {{ t('When the command is executed successfully, the output is similar to:') }}
                </div>
                <div class="output-box">
                    <div class="output">PS E:\build-admin> php think migrate:run</div>
                    <div class="output mt10">== 20230620180908 Install: migrating</div>
                    <div class="output">== 20230620180908 Install: migrated 0.0165s</div>
                    <div class="output mt10">== 20230620180916 InstallData: migrating</div>
                    <div class="output">== 20230620180916 InstallData: migrated 0.0573s</div>
                    <div class="output mt10">All Done. Took 0.0898s</div>
                </div>
                <div class="block-help mt10">
                    {{
                        t(
                            'After the command is executed successfully, multiple data tables will be automatically created in the database, and then click below to '
                        )
                    }}
                    <span class="command">{{ t('continue install') }}</span>
                </div>
            </div>
        </div>
        <div class="phinx-fail-footer-button">
            <el-button type="primary" @click="migrateDone">{{ t('continue install') }}</el-button>
        </div>
    </el-dialog>
</template>

<script setup lang="ts">
import { reactive, onMounted, onUnmounted, ref } from 'vue'
import Header from '../components/header/index.vue'
import { postTestDatabase, getBaseConfig, postBaseConfig, commandExecComplete } from '/@/api/install/index'
import { useI18n } from 'vue-i18n'
import { ConfigState, DatabaseData } from '/@/stores/interface/index'
import { useCommon } from '/@/stores/common'
import { useTerminal } from '/@/stores/terminal'
import { ElForm, ElMessage, FormItemRule } from 'element-plus'
import { taskStatus } from '/@/components/terminal/constant'

var timer: NodeJS.Timer
var databaseData: Partial<DatabaseData> = { hostname: '', username: '', password: '', hostport: '' }
const { t } = useI18n()
const common = useCommon()
const terminal = useTerminal()
const formRef = ref<InstanceType<typeof ElForm>>()

const state: ConfigState = reactive({
    formItem: {
        hostname: {
            label: t('Mysql database address'),
            value: '127.0.0.1',
            name: 'hostname',
            type: 'text',
        },
        username: {
            label: t('MySQL connection user name'),
            value: 'root',
            name: 'username',
            type: 'text',
        },
        password: {
            label: t('MySQL connection password'),
            value: '',
            name: 'password',
            type: 'password',
        },
        hostport: {
            label: t('MySQL connection port number'),
            value: '3306',
            name: 'hostport',
            type: 'number',
        },
        database: {
            label: t('Mysql database name'),
            value: '',
            name: 'database',
            type: 'text',
            blockHelp: '',
        },
        prefix: {
            label: t('MySQL data table prefix'),
            value: 'ba_',
            name: 'prefix',
            type: 'text',
        },
        br1: {
            type: 'br',
        },
        adminname: {
            label: t('Administrator user name'),
            value: 'admin',
            name: 'adminname',
            type: 'text',
        },
        adminpassword: {
            label: t('Administrator password'),
            value: '',
            name: 'adminpassword',
            type: 'password',
            placeholder: t('Backend login password'),
        },
        repeatadminpassword: {
            label: t('Duplicate administrator password'),
            value: '',
            name: 'repeatadminpassword',
            type: 'password',
        },
        br2: {
            type: 'br',
        },
        sitename: {
            label: t('Site name'),
            value: 'BuildAdmin',
            name: 'sitename',
            type: 'text',
        },
    },
    showFormItem: false,
    showError: '',
    baseConfigSubmitState: false,
    databaseCheck: 'wait',
    databases: [],
    showInstallTips: false,
    autoJumpSeconds: 5,
    // 失败自动重试1次，目前只用于 install 命令
    maximumCommandFailures: 1,
    commandFailureCount: 0,
    executionWebCommand: true,
    execMigrateFail: false,
    execMigrateIdx: 0,
    rootPath: '',
})

const connectDatabase = async () => {
    databaseData = {
        hostname: state.formItem.hostname.value,
        username: state.formItem.username.value,
        password: state.formItem.password.value,
        hostport: state.formItem.hostport.value,
        database: state.formItem.database.value,
    }
    if (databaseData.hostname && databaseData.username && databaseData.hostport) {
        state.databaseCheck = 'connecting'
        await postTestDatabase(databaseData).then((res) => {
            if (res.data.code == 1) {
                state.databaseCheck = 'connect-ok'
                state.databases = res.data.data.databases
                if (state.formItem.database.value) validation.findDatabase(state.formItem.database.value)
            } else {
                state.databaseCheck = 'wait'
                state.databases = []
                ElMessage({
                    type: 'error',
                    message: res.data.msg,
                    center: true,
                })
                throw new Error(res.data.msg)
            }
        })
    }
}

const validation = {
    required: (rule: any, field: { value: string; label: string }, callback: any) => {
        if (field.value == '' || !field.value) {
            return callback(new Error(field.label + t('Required')))
        }
        return callback()
    },
    findDatabase: (database: string) => {
        if (state.databaseCheck != 'connect-ok') return
        if (database && state.databases.indexOf(database) === -1) {
            state.formItem.database.blockHelp = t('The entered database was not found!')
        } else {
            state.formItem.database.blockHelp = ''
        }
    },
    database: (rule: any, field: { value: string; label: string }, callback: any) => {
        validation.findDatabase(field.value)
        return callback()
    },
    connect: (rule: any, field: { value: string; label: string }, callback: any) => {
        let flag = false
        for (const key in databaseData) {
            if (databaseData[key as keyof DatabaseData] != state.formItem[key].value) {
                flag = true
            }
        }
        if (!flag) {
            return callback()
        }
        connectDatabase()
        return callback()
    },
    prefix: function (rule: any, field: { value: string; label: string }, callback: any) {
        if (field.value) {
            var reg = new RegExp(/^[a-zA-Z][a-zA-Z0-9_]*$/i)
            if (!reg.test(field.value)) {
                return callback(new Error(t('The table prefix can only contain alphanumeric characters and underscores, and starts with a letter')))
            }
        }
        return callback()
    },
    adminname: function (rule: any, field: { value: string; label: string }, callback: any) {
        if (!/^[a-zA-Z][a-zA-Z0-9_]{2,15}$/.test(field.value)) {
            return callback(new Error(t('It is composed of letters, numbers and underscores, starting with letters (3-15 digits)')))
        }
        return callback()
    },
    adminpassword: function (rule: any, field: { value: string; label: string }, callback: any) {
        if (!/^(?!.*[&<>"'\n\r]).{6,32}$/.test(field.value)) {
            return callback(new Error(t('Please enter the correct password')))
        }
        return callback()
    },
    repeatadminpassword: function (rule: any, field: { value: string; label: string }, callback: any) {
        if (state.formItem.adminpassword.value && field.value && state.formItem.adminpassword.value != field.value) {
            return callback(new Error(t('Duplicate passwords do not match')))
        }
        return callback()
    },
}

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    hostname: [{ validator: validation.required, trigger: 'blur' }],
    username: [{ validator: validation.required, trigger: 'blur' }],
    hostport: [{ validator: validation.required, trigger: 'blur' }],
    database: [
        { validator: validation.required, trigger: 'blur' },
        { validator: validation.database, trigger: 'blur' },
    ],
    prefix: [
        { validator: validation.connect, trigger: 'blur' },
        { validator: validation.prefix, trigger: 'blur' },
    ],
    adminname: [
        { validator: validation.required, trigger: 'blur' },
        { validator: validation.connect, trigger: 'blur' },
        { validator: validation.adminname, trigger: 'blur' },
    ],
    adminpassword: [
        { validator: validation.required, trigger: 'blur' },
        { validator: validation.connect, trigger: 'blur' },
        { validator: validation.adminpassword, trigger: 'blur' },
    ],
    repeatadminpassword: [
        { validator: validation.required, trigger: 'blur' },
        { validator: validation.repeatadminpassword, trigger: 'blur' },
    ],
    sitename: [{ validator: validation.required, trigger: 'blur' }],
})

const goUrl = (url: string) => {
    window.open(url)
}

const setGlobalError = (msg: string) => {
    state.showError = msg
}

/**
 * 执行`php think migrate:run`命令
 */
const execMigrate = () => {
    terminal.addTask('migrate.run', true, '', (res: number, idx: number) => {
        if (res == taskStatus.Success) {
            migrateDone()
        } else {
            state.execMigrateIdx = idx
            state.execMigrateFail = true
        }
    })
}

const migrateDone = () => {
    if (state.execMigrateIdx) terminal.delTask(state.execMigrateIdx)
    setTimeout(() => {
        commandExecComplete({
            type: 'migrate',
            adminname: state.formItem.adminname.value,
            adminpassword: state.formItem.adminpassword.value,
            sitename: state.formItem.sitename.value,
        }).then(() => {
            execWebCommand()
        })
    }, 1500)
}

/**
 * 执行`npm install`和`npm build`命令
 */
const execWebCommand = () => {
    state.execMigrateFail = false
    if (!state.executionWebCommand) {
        state.showInstallTips = false // 隐藏手动操作安装未尽事宜提示
        common.setStep('manualInstall') // 跳转到手动完成未尽事宜页面
        return
    }
    terminal.toggle(true)
    terminal.addTaskPM('web-install', true, '', (res: number, idx: number) => {
        if (res == taskStatus.Success) {
            terminal.addTaskPM('web-build', true, '', (res: number) => {
                state.baseConfigSubmitState = false
                if (res == taskStatus.Success) {
                    commandExecComplete({ type: 'web' })
                    terminal.toggle(false)
                    common.setStep('done')
                } else if (res == taskStatus.Failed) {
                    commandFail()
                }
            })
        } else if (res == taskStatus.Failed) {
            if (state.commandFailureCount < state.maximumCommandFailures) {
                state.commandFailureCount++
                terminal.retryTask(idx)
            } else {
                state.baseConfigSubmitState = false
                commandFail()
            }
        }
    })
}

const submitBaseConfig = (formEl: InstanceType<typeof ElForm> | undefined = undefined) => {
    if (!formEl) return
    state.baseConfigSubmitState = true
    connectDatabase()
        .then(() => {
            formEl.validate((valid) => {
                if (valid) {
                    let values = {}
                    for (const key in state.formItem) {
                        values = Object.assign(values, {
                            [key]: state.formItem[key].value,
                        })
                    }

                    postBaseConfig(values)
                        .then((res) => {
                            if (res.data.code == 1) {
                                state.rootPath = res.data.data.rootPath
                                state.executionWebCommand = res.data.data.executionWebCommand
                                execMigrate()
                            } else {
                                ElMessage({
                                    type: 'error',
                                    message: res.data.msg,
                                    center: true,
                                })
                                state.baseConfigSubmitState = false
                            }
                        })
                        .catch(() => {
                            state.baseConfigSubmitState = false
                        })
                } else {
                    state.baseConfigSubmitState = false
                }
            })
        })
        .catch(() => {
            state.baseConfigSubmitState = false
        })
}

getBaseConfig().then((res) => {
    if (res.data.code == 1) {
        state.rootPath = res.data.data.rootPath
        state.showInstallTips = !res.data.data.executionWebCommand
        state.executionWebCommand = res.data.data.executionWebCommand
    } else if (res.data.code == 0) {
        ElMessage({
            type: 'error',
            message: res.data.msg,
            center: true,
            duration: 0,
        })
    } else {
        state.showInstallTips = true
    }
})

const commandFail = () => {
    terminal.toggle(false)
    timer = setInterval(() => {
        if (state.autoJumpSeconds <= 0) {
            clearInterval(timer)
            common.setStep('manualInstall')
        } else {
            state.autoJumpSeconds--
            setGlobalError(t('Manual Install 1') + t('Manual Install 2', { seconds: state.autoJumpSeconds }))
        }
    }, 1000)
}

onMounted(() => {
    state.showFormItem = true
})
onUnmounted(() => {
    clearInterval(timer)
})
</script>

<style scoped lang="scss">
.phinx-fail-box {
    display: block;
    margin-top: 20px;
    padding: 15px;
    margin: 15px auto;
    background-color: #fff;
    border-radius: 4px;
    .content-item {
        line-height: 1.3;
        border-radius: 4px;
        padding: 10px;
        background-color: #f5f5f5;
        word-break: break-all;
        font-family: Consolas, Monaco, Andale Mono, Ubuntu Mono, monospace;
        margin: 15px 0;
        .command {
            line-height: 2;
            font-weight: bold;
        }
        .block-help {
            display: inline-block;
            line-height: 2;
            font-size: 13px;
            color: #909399;
        }
        .text {
            padding: 6px 0;
            font-size: 14px;
        }
        .output-box {
            position: relative;
            border-radius: 5px;
            box-shadow: #0005 0 2px 2px;
            padding: 5px;
            font-size: 13px;
            background-color: #282c34;
        }
        .output {
            color: #a9b7c6;
        }
        .mt10 {
            margin-top: 10px;
        }
    }
}
.phinx-fail-footer-button {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.container {
    margin-top: 10px;
    .table-title {
        display: block;
        text-align: center;
        font-size: 20px;
        color: #303133;
    }
    .table {
        max-width: 560px;
        padding: 20px;
        margin: 0 auto;
        .table-item-br {
            height: 20px;
        }
        .table-item:focus-within {
            .table-input {
                color: #303133;
            }
            border: 2px solid #4e73df;
        }
        .table-column {
            padding: 12px;
            border-radius: 3px;
            border: 2px solid #fff;
            transition: all 0.3s ease;
        }
        .table-error {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            background-color: #f56c6c;
            color: #fff;
        }
        .table-item {
            display: flex;
            align-items: center;
            margin-bottom: 2px;
            background-color: #fff;
            color: #909399;
            .table-label {
                flex: 1;
                font-size: 15px;
                margin-bottom: 0;
                .block-help {
                    display: block;
                    width: 100%;
                    color: #909399;
                    font-size: 13px;
                    line-height: 16px;
                    padding: 0 11px;
                }
            }
        }
    }
    .footer-buttons {
        margin-top: 20px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        .button {
            width: 50%;
            height: 42px;
        }
    }
    .connecting-prompt {
        position: fixed;
        top: 60px;
        right: 100px;
        font-size: 14px;
        margin-top: 20px;
        text-align: right;
        color: #606266;
    }
    :deep(.el-input__wrapper) {
        box-shadow: none;
    }
    :deep(.el-input__wrapper.is-focus) {
        box-shadow: none;
    }
    :deep(.el-form-item.is-error .el-input__wrapper) {
        box-shadow: none;
    }
    :deep(.el-form-item__error) {
        left: 11px;
        margin-top: -6px;
    }
    :deep(.el-input__inner) {
        line-height: 29px;
    }
}
.install-tips-box {
    padding: 0 20px;
    .install-tips-close {
        position: absolute;
        width: 22px;
        height: 22px;
        top: -11px;
        right: -11px;
        border: 1px solid #d50600;
        border-radius: 50%;
    }
    .install-tips {
        position: relative;
        padding: 10px;
        background-color: #ffcdcd;
        color: #d50600;
        max-width: 570px;
        margin: 20px auto 0 auto;
        border-radius: 4px;
        font-size: 14px;
        .install-tips-title,
        .install-tips-item {
            text-indent: 1em;
            background-color: #ffe5e5;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 5px;
        }
        .install-tips-item:last-child {
            margin-bottom: 0;
        }
    }
    .change-route {
        cursor: pointer;
        color: #3f6ad8;
    }
}
</style>
