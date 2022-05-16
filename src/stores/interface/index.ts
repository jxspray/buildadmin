export interface TaskItem {
    // 任务唯一标识
    uuid: string
    // 创建时间
    createtime: string
    // 状态
    status: number
    // 命令
    command: string
    // 命令执行日志
    message: string[]
    // 显示命令执行日志
    showMessage: boolean
    // 失败阻断后续命令执行
    blockOnFailure: boolean
    // 回调
    callback: Function
}

export interface Terminal {
    show: boolean
    showDot: boolean
    taskList: TaskItem[]
    packageManager: string
    showPackageManagerDialog: boolean
}

export interface Common {
    // 安装步骤
    step: 'check' | 'config' | 'done' | 'manualInstall'
}

export interface CheckState {
    envCheckData: {
        link: anyObj
        state: 'ok' | 'fail' | 'warn'
        describe: string
    }[]
    stateTitle: {
        ok: string
        fail: string
        warn: string
    }
    checkType: {
        base: string
        npm: string
        npminstall: string
        done: string
    }
    checkTypeIndex: 'base' | 'npm' | 'npminstall' | 'done'
    checkDone: {
        ok: string
        fail: string
        executing: string
    }
    checkDoneIndex: 'ok' | 'fail' | 'executing'
    showStartDialog: boolean
    startForm: {
        lang: string
        packageManager: string
    }
}

export interface CheckLink {
    name: string
    type: string
    title?: string
    url?: string
}

export interface ConfigState {
    formItem: any
    showFormItem: boolean
    showError: string
    baseConfigSubmitState: boolean
    databaseCheck: string
    databases: any
    showInstallTips: boolean
    autoJumpSeconds: number
}

export interface DatabaseData {
    hostname: string
    username: string
    password: string
    hostport: string
    database: string
}
