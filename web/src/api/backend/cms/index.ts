import createAxios from '/@/utils/axios'
import { useConfig } from '/@/views/backend/cms/cmsStore'
import { debounce } from '/@/utils/common'
import { isEmpty } from 'lodash-es'
import {ElLoading} from "element-plus";

export const config = useConfig()

/**
 * 初始化CMS配置 模板文件、模型、栏目、字段
 * 1. 首次初始化
 */
export function initialize(callback?: (res: ApiResponse) => void) {
    debounce(() => {
        const loadingInstance = ElLoading.service({ fullscreen: true })
        if (config.initialize) {
            loadingInstance.close();
            return typeof callback == 'function' && callback({
                data: {
                    templates: config.templates,
                    moduleList: config.moduleList,
                    catalogList: config.catalogList,
                    commonField: config.commonField
                },
                code: 200,
                msg: '初始化成功',
                time: Date.now()
            })
        }

        createAxios({
            url: '/admin/cms.api/init',
            method: 'get'
        }).then((res) => {
            config.dataFill({
                templates: res.data.templates,
                moduleList: res.data.moduleList,
                catalogList: res.data.catalogList,
                commonField: res.data.commonField,
                initialize: true
            })
            loadingInstance.close();

            typeof callback == 'function' && callback(res)
        })
    }, 200)()
}
