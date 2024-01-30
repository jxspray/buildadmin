import createAxios from '/@/utils/axios'

const controllerUrl = "/admin/cms.module/";
export const actionUrl = new Map([
    ['index', controllerUrl + 'index'],
    ['edit', controllerUrl + 'edit'],
])
export function index() {
    return createAxios({
        url: actionUrl.get('index'),
        method: 'get',
    })
}

export function postData(data: anyObj) {
    return createAxios(
        {
            url: actionUrl.get('edit'),
            method: 'post',
            data: data,
        },
        {
            showSuccessMessage: true,
        }
    )
}

export function generate(data: anyObj) {
    return createAxios(
        {
            url: controllerUrl + 'generate',
            method: 'post',
            data: data,
        },
        {
            showSuccessMessage: true,
        }
    )
}

export function getDatabaseList() {
    return createAxios({
        url: controllerUrl + 'databaseList',
        method: 'get',
    })
}

export function getFileData(table: string) {
    return createAxios({
        url: controllerUrl + 'getFileData',
        method: 'get',
        params: {
            table: table,
        },
    })
}

export function generateCheck(data: anyObj) {
    return createAxios(
        {
            url: controllerUrl + 'generateCheck',
            method: 'post',
            data: data,
        },
        {
            showCodeMessage: false,
        }
    )
}

export function parseFieldData(type: string, table = '', sql = '') {
    return createAxios({
        url: controllerUrl + 'parseFieldData',
        method: 'post',
        data: {
            type: type,
            table: table,
            sql: sql,
        },
    })
}

export function postLogStart(id: number) {
    return createAxios({
        url: controllerUrl + 'logStart',
        method: 'post',
        data: {
            id: id,
        },
    })
}

export function postDel(id: number) {
    return createAxios({
        url: controllerUrl + 'delete',
        method: 'post',
        data: {
            id: id,
        },
    })
}