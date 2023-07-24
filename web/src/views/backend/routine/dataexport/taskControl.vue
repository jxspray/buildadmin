<template>
    <div class="default-main">
        <el-alert
            :title="'《' + (state.task.name ?? '') + '》正在执行中，请勿刷新浏览器或关闭标签页...'"
            type="error"
            :closable="false"
            effect="dark"
            class="mb20"
        />
        <el-table :data="state.task.subtask" border style="width: 100%">
            <el-table-column prop="id" label="序号" align="center" width="60" />
            <el-table-column label="任务标题">
                <template #default="scope">
                    <div style="display: flex; align-items: center">第 {{ scope.row.min }} 到 {{ scope.row.min + scope.row.max }} 行数据</div>
                </template>
            </el-table-column>
            <el-table-column prop="status_text" align="center" label="状态" width="100">
                <template #default="scope">
                    <div>
                        <el-tag v-if="scope.row.status == 0" type="info">{{ scope.row.status_text }}</el-tag>
                        <el-tag v-else-if="scope.row.status == 1">{{ scope.row.status_text }}</el-tag>
                        <el-tag v-else-if="scope.row.status == 2" type="success">{{ scope.row.status_text }}</el-tag>
                        <el-tag v-else type="danger">{{ scope.row.status_text }}</el-tag>
                    </div>
                </template>
            </el-table-column>
        </el-table>
        <el-progress class="task-progress" :color="customColors" :stroke-width="16" :percentage="state.task.lastprogress" :text-inside="true" />
        <el-result icon="success" v-if="Number(state.task.lastprogress) >= 100" title="数据已备好" sub-title="点击下载导出的数据包文件">
            <template #extra>
                <el-button @click="onDownloadTaskZip" type="primary">下载ZIP</el-button>
            </template>
        </el-result>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { useRoute } from 'vue-router'
import createAxios from '/@/utils/axios'
import { getTaskControl, buildSubTaskUrl, getTaskZip } from '/@/api/backend/routine/dataexport'

const route = useRoute()

const state: {
    task: anyObj
    subTask: anyObj[]
    requestIdx: number
} = reactive({
    task: {},
    subTask: [],
    requestIdx: 0,
})

const startTask = () => {
    let request: anyObj[] = []
    for (const key in state.subTask[state.requestIdx]) {
        setSubTaskStatus(state.subTask[state.requestIdx][key].id, 1)
        request.push(
            createAxios({
                url: buildSubTaskUrl(state.task.id, state.subTask[state.requestIdx][key].id),
                method: 'get',
            }).then((res) => {
                setSubTaskStatus(res.data.subId, 2)
                state.task.lastprogress += state.task.subtask_progress
            })
        )
    }
    if (request.length) {
        Promise.all(request).then((res) => {
            request = []
            state.requestIdx++
            startTask()
        })
    } else {
        state.task.lastprogress = 100
    }
}

const setSubTaskStatus = (id: number, status: number) => {
    for (const key in state.task.subtask) {
        if (state.task.subtask[key].id == id) {
            state.task.subtask[key].status = status
            state.task.subtask[key].status_text = getStatusText(status)
            break
        }
    }
}

getTaskControl(route.params.id as string).then((res) => {
    state.task = res.data.task
    state.subTask = res.data.subtaskPage
    for (const key in state.task.subtask) {
        state.task.subtask[key].status_text = getStatusText(state.task.subtask[key].status)
    }
    startTask()
})

const onDownloadTaskZip = () => {
    getTaskZip(state.task.id).then((res) => {
        window.location.href = res.data.url
    })
}

const customColors = [
    { color: '#909399', percentage: 20 },
    { color: '#a0cfff', percentage: 40 },
    { color: '#409eff', percentage: 60 },
    { color: '#95d475', percentage: 80 },
    { color: '#67c23a', percentage: 100 },
]
const getStatusText = (status: number) => {
    let statusText = ''
    switch (status) {
        case 0:
            statusText = '准备好'
            break
        case 1:
            statusText = '进行中'
            break
        case 2:
            statusText = '完成'
            break
        case 3:
            statusText = '失败'
            break
    }
    return statusText
}

defineOptions({
    name: 'routine/dataexport/taskControl',
})
</script>

<style scoped lang="scss">
.mb20 {
    margin-bottom: 10px;
}
.task-progress {
    margin-top: 10px;
}
</style>
