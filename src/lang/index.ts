import { createI18n } from 'vue-i18n'

import elementZhcnLocale from 'element-plus/lib/locale/lang/zh-cn'
import elementEnLocale from 'element-plus/lib/locale/lang/en'
import langZhcn from '/@/lang/zh-cn'
import langEn from '/@/lang/en'

const pagesLang = {
    'zh-cn': getLangFileMessage(import.meta.glob('./pages/zh-cn/**/*.ts', { eager: true }), 'zh-cn'),
    en: getLangFileMessage(import.meta.glob('./pages/en/**/*.ts', { eager: true }), 'en'),
}

const messages = {
    'zh-cn': {
        ...langZhcn,
        ...elementZhcnLocale,
        ...pagesLang['zh-cn'],
    },
    en: {
        ...langEn,
        ...elementEnLocale,
        ...pagesLang['en'],
    },
}

export const i18n = createI18n({
    locale: 'zh-cn',
    legacy: false, // 组合式api
    fallbackLocale: 'en',
    messages,
})

function getLangFileMessage(mList: any, locale: string) {
    interface msg {
        [key: string]: any
    }
    const msg: msg = {}
    for (const path in mList) {
        if (mList[path].default) {
            //  获取文件名
            const pathName = path.slice(path.lastIndexOf(locale) + (locale.length + 1), path.lastIndexOf('.'))
            if (pathName.indexOf('/') > 0) {
                const pathNameTmp = pathName.split('/')
                for (const key in pathNameTmp) {
                    if (typeof msg[pathNameTmp[key]] === 'undefined') {
                        msg[pathNameTmp[key]] = []
                    }
                }
                if (pathNameTmp.length == 2) {
                    msg[pathNameTmp[0]][pathNameTmp[1]] = handleMsglist(mList[path].default)
                } else if (pathNameTmp.length == 3) {
                    msg[pathNameTmp[0]][pathNameTmp[1]][pathNameTmp[2]] = handleMsglist(mList[path].default)
                } else {
                    msg[pathName] = handleMsglist(mList[path].default)
                }
            } else {
                msg[pathName] = handleMsglist(mList[path].default)
            }
        }
    }
    return msg
}

function handleMsglist(mlist: anyObj) {
    const newMlist: any = []
    for (const key in mlist) {
        if (key.indexOf('.') > 0) {
            const keyTmp = key.split('.')
            if (typeof newMlist[keyTmp[0]] === 'undefined') {
                newMlist[keyTmp[0]] = []
            } else {
                newMlist[keyTmp[0]][keyTmp[1]] = mlist[key]
            }
        } else {
            newMlist[key] = mlist[key]
        }
    }
    return newMlist
}
