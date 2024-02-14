import createAxios from '/@/utils/axios'
import { useConfig } from '/@/views/backend/cms/cmsStore'
import { debounce } from '/@/utils/common'
import router from '/@/router/index'
import { isEmpty } from 'lodash-es'


/**
 * 初始化CMS配置 模板文件、模型、栏目、字段
 * 1. 首次初始化
 */
export function initialize(callback?: (res: ApiResponse) => void) {
    debounce(() => {
        if (router.currentRoute.value.meta.initialize === false) return

        const config = useConfig()

        createAxios({
            url: '/admin/cms.api/init',
            method: 'get'
        }).then((res) => {
            config.dataFill({
                templates: res.data.templates,
                moduleList: res.data.moduleList,
                commonField: res.data.commonField
            })

            typeof callback == 'function' && callback(res)
        })
    }, 200)()
}
