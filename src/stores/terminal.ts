import { nextTick, reactive } from 'vue'
import { defineStore } from 'pinia'
import { STORE_TERMINAL } from '/@/stores/constant/cacheKey'
import { Terminal } from '/@/stores/interface/index'
import { timeFormat } from '/@/utils/common'
import { buildTerminalUrl } from '/@/api/install/index'
import { uuid } from '/@/utils/common'
import { taskStatus } from '/@/components/terminal/constant'
import { useCommon } from './common'

export const useTerminal = defineStore(
    'terminal',
    () => {
        const state: Terminal = reactive({
            show: false,
            showDot: false,
            taskList: [],
            packageManager: 'pnpm',
            showPackageManagerDialog: false,
        })

        function init() {
            for (const key in state.taskList) {
                if (state.taskList[key].status == taskStatus.Connecting || state.taskList[key].status == taskStatus.Executing) {
                    state.taskList[key].status = taskStatus.Unknown
                }
            }
        }

        function toggle(val = !state.show) {
            state.show = val
            if (val) {
                toggleDot(false)
            }
        }

        function toggleDot(val = !state.showDot) {
            state.showDot = val
        }

        function togglePackageManagerDialog(val = !state.showPackageManagerDialog) {
            toggle(!val)
            state.showPackageManagerDialog = val
        }

        function changePackageManager(val: string) {
            state.packageManager = val
        }

        function setTaskStatus(idx: number, status: number) {
            if (!state.taskList[idx]) {
                return
            }
            state.taskList[idx].status = status
            if ((status == taskStatus.Failed || status == taskStatus.Unknown) && state.taskList[idx].blockOnFailure) {
                setTaskShowMessage(idx, true)
            }
        }

        function taskCompleted(idx: number) {
            if (!state.taskList[idx]) {
                return
            }
            if (typeof state.taskList[idx].callback != 'function') {
                return
            }
            const status = state.taskList[idx].status
            if (status == taskStatus.Failed || status == taskStatus.Unknown) {
                state.taskList[idx].callback(taskStatus.Failed, idx)
            } else if (status == taskStatus.Success) {
                state.taskList[idx].callback(taskStatus.Success, idx)

                if (state.taskList[idx].command == 'web-build' + '.' + state.packageManager) {
                    const common = useCommon()
                    if (common.state.step == 'manualInstall') {
                        toggle(false)
                        common.setStep('done')
                    }
                }
            }
        }

        function setTaskShowMessage(idx: number, val = !state.taskList[idx].showMessage) {
            state.taskList[idx].showMessage = val
        }

        function addTaskMessage(idx: number, message: string) {
            if (!state.show) toggleDot(true)
            state.taskList[idx].message = state.taskList[idx].message.concat(message)
            nextTick(() => {
                execMessageScrollbarKeep(state.taskList[idx].uuid)
            })
        }

        function addTask(command: string, blockOnFailure = true, callback: Function = () => {}) {
            if (!state.show) toggleDot(true)
            state.taskList = state.taskList.concat({
                uuid: uuid(),
                createtime: timeFormat(),
                status: taskStatus.Waiting,
                command: command,
                message: [],
                showMessage: false,
                blockOnFailure: blockOnFailure,
                callback: callback,
            })

            // 清理任务列表
            // clearSuccessTask()

            startTask()
        }

        function addTaskPM(command: string, blockOnFailure = true, callback: Function = () => {}) {
            addTask(command + '.' + state.packageManager, blockOnFailure, callback)
        }

        function delTask(idx: number) {
            if (state.taskList[idx].status != taskStatus.Connecting && state.taskList[idx].status != taskStatus.Executing) {
                state.taskList.splice(idx, 1)
            }
            startTask()
        }

        function startTask() {
            let taskKey = null

            // 寻找可以开始执行的命令
            for (const key in state.taskList) {
                if (state.taskList[key].status == taskStatus.Waiting) {
                    taskKey = parseInt(key)
                    break
                }
                if (state.taskList[key].status == taskStatus.Connecting || state.taskList[key].status == taskStatus.Executing) {
                    break
                }
                if (state.taskList[key].status == taskStatus.Success) {
                    continue
                }
                if (state.taskList[key].status == taskStatus.Failed || state.taskList[key].status == taskStatus.Unknown) {
                    if (state.taskList[key].blockOnFailure) {
                        break
                    } else {
                        continue
                    }
                }
            }
            if (taskKey !== null) {
                setTaskStatus(taskKey, taskStatus.Connecting)
                startEventSource(taskKey)
            }
        }

        function startEventSource(taskKey: number) {
            window.eventSource = new EventSource(buildTerminalUrl(state.taskList[taskKey].command, state.taskList[taskKey].uuid))
            window.eventSource.onmessage = function (e) {
                const data = JSON.parse(e.data)
                if (!data || !data.data) {
                    return
                }

                const taskIdx = findTaskIdxFromUuid(data.extend)
                if (taskIdx === false) {
                    return
                }

                if (data.data == 'command-exec-error') {
                    setTaskStatus(taskIdx, taskStatus.Failed)
                    window.eventSource.close()
                    taskCompleted(taskIdx)
                    startTask()
                } else if (data.data == 'command-exec-completed') {
                    window.eventSource.close()
                    if (state.taskList[taskIdx].status != taskStatus.Success) {
                        setTaskStatus(taskIdx, taskStatus.Failed)
                    }
                    taskCompleted(taskIdx)
                    startTask()
                } else if (data.data == 'command-link-success') {
                    setTaskStatus(taskIdx, taskStatus.Executing)
                } else if (data.data == 'command-exec-success') {
                    setTaskStatus(taskIdx, taskStatus.Success)
                } else {
                    addTaskMessage(taskIdx, data.data)
                }
            }
            window.eventSource.onerror = function () {
                window.eventSource.close()
                const taskIdx = findTaskIdxFromGuess(taskKey)
                if (taskIdx === false) return
                setTaskStatus(taskIdx, taskStatus.Failed)
                taskCompleted(taskIdx)
            }
        }

        function retryTask(idx: number) {
            state.taskList[idx].message = []
            setTaskStatus(idx, taskStatus.Waiting)
            startTask()
        }

        function clearSuccessTask() {
            state.taskList = state.taskList.filter((item) => item.status != taskStatus.Success)
        }

        function findTaskIdxFromUuid(uuid: string) {
            for (const key in state.taskList) {
                if (state.taskList[key].uuid == uuid) {
                    return parseInt(key)
                }
            }
            return false
        }

        function findTaskIdxFromGuess(idx: number) {
            if (!state.taskList[idx]) {
                let taskKey = -1
                for (const key in state.taskList) {
                    if (state.taskList[key].status == taskStatus.Connecting || state.taskList[key].status == taskStatus.Executing) {
                        taskKey = parseInt(key)
                    }
                }
                return taskKey === -1 ? false : taskKey
            } else {
                return idx
            }
        }

        function execMessageScrollbarKeep(uuid: string) {
            const execMessageEl = document.querySelector('.exec-message-' + uuid) as Element
            if (execMessageEl && execMessageEl.scrollHeight) {
                execMessageEl.scrollTop = execMessageEl.scrollHeight
            }
        }

        return {
            state,
            init,
            toggle,
            toggleDot,
            setTaskStatus,
            setTaskShowMessage,
            addTaskMessage,
            addTask,
            addTaskPM,
            delTask,
            startTask,
            retryTask,
            clearSuccessTask,
            togglePackageManagerDialog,
            changePackageManager,
        }
    },
    {
        persist: {
            key: STORE_TERMINAL,
        },
    }
)
