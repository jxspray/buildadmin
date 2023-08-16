import createAxios from '/@/utils/axios'

export const url = '/admin/cms.Config/'

export function param() {
    return createAxios({
        url: url + 'param',
        method: 'get',
    })
}