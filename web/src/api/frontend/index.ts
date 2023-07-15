import createAxios from '/@/utils/axios'
import { useSiteConfig } from '/@/stores/siteConfig'
import { useMemberCenter } from '/@/stores/memberCenter'
import { setTitle, debounce } from '/@/utils/common'
import { handleFrontendRoute } from '/@/utils/router'

export const indexUrl = '/api/index/'

/**
 * 前台初始化请求，获取站点配置信息，动态路由信息等（非会员中心初始化请求，它们是分开的）
 */
export function index() {
    debounce(() => {
        const siteConfig = useSiteConfig()
        const memberCenter = useMemberCenter()

        if (siteConfig.siteName) {
            return
        }

        return createAxios({
            url: indexUrl + 'index',
            method: 'get',
        }).then((res) => {
            setTitle(res.data.site.siteName)
            if (res.data.rules) {
                handleFrontendRoute(res.data.rules)
            }
            siteConfig.dataFill(res.data.site)
            memberCenter.setStatus(res.data.openMemberCenter)
            if (!res.data.openMemberCenter) memberCenter.setLayoutMode('Disable')
        })
    }, 100)()
}
