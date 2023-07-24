import createAxios, { getUrl } from '/@/utils/axios'
import { useAdminInfo } from '/@/stores/adminInfo'
const controllerUrl = '/admin/routine.dataexport/'

export function add() {
    return createAxios({
        url: controllerUrl + 'add',
        method: 'get',
    })
}

export function getFieldList(table: string) {
    return createAxios({
        url: controllerUrl + 'getFieldList',
        method: 'get',
        params: {
            table: table,
        },
    })
}

export function getTest(id: number) {
    return createAxios({
        url: controllerUrl + 'test',
        method: 'get',
        params: {
            id: id,
        },
    })
}

export function buildDownloadUrl(id: number) {
    const adminInfo = useAdminInfo()
    return getUrl() + controllerUrl + 'task/subId/0/download/true/id/' + id + '?batoken=' + adminInfo.getToken() + '&server=1'
}

export function buildSubTaskUrl(id: number, subId: number) {
    const adminInfo = useAdminInfo()
    return getUrl() + controllerUrl + 'task/subId/' + subId + '/download/0/id/' + id + '?batoken=' + adminInfo.getToken() + '&server=1'
}

export function getTaskZip(id: number) {
    return createAxios(
        {
            url: controllerUrl + 'taskZip',
            method: 'get',
            params: {
                id: id,
            },
        },
        {
            loading: true,
        }
    )
}

export function getStart(id: number) {
    return createAxios(
        {
            url: controllerUrl + 'start',
            method: 'get',
            params: {
                id: id,
            },
        },
        {
            loading: true,
        }
    )
}

export function getTaskControl(id: string) {
    return createAxios({
        url: controllerUrl + 'taskControl',
        method: 'get',
        params: {
            id: id,
        },
    })
}
