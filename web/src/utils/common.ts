import { nextTick } from 'vue'
import type { App } from 'vue'
import * as elIcons from '@element-plus/icons-vue'
import router from '/@/router/index'
import Icon from '/@/components/icon/index.vue'
import { useNavTabs } from '/@/stores/navTabs'
import { ElForm } from 'element-plus'
import { useSiteConfig } from '../stores/siteConfig'
import { i18n } from '../lang'
import { getUrl } from './axios'

export function registerIcons(app: App) {
    /*
     * 全局注册 Icon
     * 使用方式: <Icon name="name" size="size" color="color" />
     * 详见<待完善>
     */
    app.component('Icon', Icon)

    /*
     * 全局注册element Plus的icon
     */
    const icons = elIcons as any
    for (const i in icons) {
        app.component(`el-icon-${icons[i].name}`, icons[i])
    }
}

/* 加载网络css文件 */
export function loadCss(url: string): void {
    const link = document.createElement('link')
    link.rel = 'stylesheet'
    link.href = url
    link.crossOrigin = 'anonymous'
    document.getElementsByTagName('head')[0].appendChild(link)
}

/* 加载网络js文件 */
export function loadJs(url: string): void {
    const link = document.createElement('script')
    link.src = url
    document.body.appendChild(link)
}

/**
 * 设置浏览器标题
 */
export function setTitleFromRoute() {
    if (typeof router.currentRoute.value.meta.title != 'string') {
        return
    }
    nextTick(() => {
        let webTitle = ''
        if ((router.currentRoute.value.meta.title as string).indexOf('pagesTitle.') === -1) {
            webTitle = router.currentRoute.value.meta.title as string
        } else {
            webTitle = i18n.global.t(router.currentRoute.value.meta.title as string)
        }
        document.title = `${webTitle}`
    })
}

export function setTitle(title: string) {
    document.title = `${title}`
}

/**
 * 是否是外部链接
 * @param path
 */
export function isExternal(path: string): boolean {
    return /^(https?|ftp|mailto|tel):/.test(path)
}

/**
 * 防抖
 * @param fn 执行函数
 * @param ms 间隔毫秒数
 */
export const debounce = (fn: Function, ms: number) => {
    return (...args: any[]) => {
        if (window.lazy) {
            clearTimeout(window.lazy)
        }
        window.lazy = setTimeout(() => {
            fn(...args)
        }, ms)
    }
}

/**
 * 根据pk字段的值从数组中获取key
 * @param arr
 * @param pk
 * @param value
 */
export const getArrayKey = (arr: any, pk: string, value: string): any => {
    for (const key in arr) {
        if (arr[key][pk] == value) {
            return key
        }
    }
    return false
}

/**
 * 表单重置
 * @param formEl
 */
export const onResetForm = (formEl: InstanceType<typeof ElForm> | undefined) => {
    if (!formEl) return
    formEl.resetFields()
}

/**
 * 将数据构建为ElTree的data {label:'', children: []}
 * @param data
 */
export const buildJsonToElTreeData = (data: any): ElTreeData[] => {
    if (typeof data == 'object') {
        const childrens = []
        for (const key in data) {
            childrens.push({
                label: key + ': ' + data[key],
                children: buildJsonToElTreeData(data[key]),
            })
        }
        return childrens
    } else {
        return []
    }
}

/**
 * 是否在后台应用内
 */
export const isAdminApp = () => {
    if (/^\/admin/.test(router.currentRoute.value.fullPath) || window.location.hash.indexOf('#/admin') === 0) {
        return true
    }
    return false
}

/**
 * 从一个文件路径中获取文件名
 * @param path 文件路径
 */
export const getFileNameFromPath = (path: string) => {
    const paths = path.split('/')
    return paths[paths.length - 1]
}

/**
 * 页面按钮鉴权
 * @param name
 */
export const auth = (name: string) => {
    const navTabs = useNavTabs()
    if (navTabs.state.authNode.has(router.currentRoute.value.path)) {
        if (navTabs.state.authNode.get(router.currentRoute.value.path)!.some((v: string) => v == router.currentRoute.value.path + '/' + name)) {
            return true
        }
    }
    return false
}

/**
 * 获取资源完整地址
 * @param relativeUrl 资源相对地址
 * @param domain 指定域名
 */
export const fullUrl = (relativeUrl: string, domain = '') => {
    const siteConfig = useSiteConfig()
    if (!domain) {
        domain = siteConfig.cdn_url ? siteConfig.cdn_url : getUrl()
    }
    if (!relativeUrl) return domain

    const regUrl = new RegExp(/^http(s)?:\/\//)
    const regexImg = new RegExp(/^((?:[a-z]+:)?\/\/|data:image\/)(.*)/i)
    if (!domain || regUrl.test(relativeUrl) || regexImg.test(relativeUrl)) {
        return relativeUrl
    }
    return domain + relativeUrl
}

export const checkFileMimetype = (fileName: string, fileType: string) => {
    if (!fileName || !fileType) return false
    const siteConfig = useSiteConfig()
    const mimetype = siteConfig.upload.mimetype.toLowerCase().split(',')
    const fileTypeTemp = fileType.toLowerCase().split('/')
    const fileSuffix = fileName.substring(fileName.lastIndexOf('.') + 1)
    if (
        siteConfig.upload.mimetype === '*' ||
        mimetype.includes(fileSuffix) ||
        mimetype.includes('.' + fileSuffix) ||
        mimetype.includes(fileType) ||
        mimetype.includes(fileTypeTemp[0] + '/*')
    ) {
        return true
    }
    return false
}

export const arrayFullUrl = (relativeUrls: string | string[], domain = '') => {
    if (typeof relativeUrls === 'string') {
        relativeUrls = relativeUrls == '' ? [] : relativeUrls.split(',')
    }
    for (const key in relativeUrls) {
        relativeUrls[key] = fullUrl(relativeUrls[key], domain)
    }
    return relativeUrls
}

export const getGreet = () => {
    const now = new Date()
    const hour = now.getHours()
    let greet = ''

    if (hour < 5) {
        greet = i18n.global.t('utils.Late at night, pay attention to your body!')
    } else if (hour < 9) {
        greet = i18n.global.t('utils.good morning!') + i18n.global.t('utils.welcome back')
    } else if (hour < 12) {
        greet = i18n.global.t('utils.Good morning!') + i18n.global.t('utils.welcome back')
    } else if (hour < 14) {
        greet = i18n.global.t('utils.Good noon!') + i18n.global.t('utils.welcome back')
    } else if (hour < 18) {
        greet = i18n.global.t('utils.good afternoon') + i18n.global.t('utils.welcome back')
    } else if (hour < 24) {
        greet = i18n.global.t('utils.Good evening') + i18n.global.t('utils.welcome back')
    } else {
        greet = i18n.global.t('utils.Hello!') + i18n.global.t('utils.welcome back')
    }
    return greet
}

// 随机字符串
export const getRandStr = (len = 16) => {
    var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    var id = '';
    for (let i = 0; i < len; i++) {
        id += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return id;
}

// 	json字符串转json对象
export const parseJson = (jsonStr = '') => {
    return JSON.parse(jsonStr, (k, v) => {
        try{
            if (eval(v) instanceof RegExp) {
                return eval(v);
            }
        }catch(e){
            // nothing
        }
        return v;
    });
}

// json对象转json字符串
export const stringifyJson = (json: anyObj) => {
    return JSON.stringify(json, (k, v) => {
        if(v instanceof RegExp){
            return v.toString();
        }
        return v;
    });
}

// 二维数组根据某字段返回一维数组
export const arrayColumn = (arr: any, name: string) => {
    let val: any = [];
    arr.forEach(function(item: anyObj,index: number) {
        val.push(item[name]);
    })
    return val;
}

// 二维数组根据某元素返回当前下标
export const arrayIndex = (arr: any, value: string, field = "id") => {
    let index = -1;
    arr.forEach(function(val: anyObj, key: number) {
        if (val[field] == value) {
            index = key;
        }
    });
    return index;
}

// 二维数组根据多字段排序
export const arraySort = (objArr: any, keyArr: any, type: string) => {
    if (type != undefined && type != 'asc' && type != 'desc') {
        return 'error';
    }
    var order = 1;
    if (type != undefined && type == 'desc') {
        order = -1;
    }
    var key = keyArr[0];
    objArr.sort(function (objA: anyObj, objB: anyObj) {
        if (objA[key] > objB[key]) {
            return order;
        } else if (objA[key] < objB[key]) {
            return 0 - order;
        } else {
            return 0;
        }
    })
    for (var i = 1; i < keyArr.length; i++) {
        var key = keyArr[i];
        objArr.sort(function (objA: anyObj, objB: anyObj) {
            for (var j = 0; j < i; j++) {
                if (objA[keyArr[j]] != objB[keyArr[j]]) {
                    return 0;
                }
            }
            if (objA[key] > objB[key]) {
                return order;
            } else if (objA[key] < objB[key]){
                return 0 - order;
            } else {
                return 0;
            }
        })
    }
    return objArr;
}


// 自定义字段类型
export const customField = [
    {label: "文本", is: "el-input", value: "", icon: "icon-danhangshurukuang"},
    {label: "文本域", is: "el-input", type: "textarea", value: "", icon: "icon-duohangshurukuang"},
    {label: "编辑器", is: "el-editor", value: "", icon: "icon-fuwenbenbianjiqi_zhonghuaxian"},
    {label: "链接设置", is: "el-link-select", value: {}, icon: "icon-lianjie"},
    {label: "自定义数组", is: "el-array", value: {}, icon: "icon-shuzu"},
    {label: "图片上传", is: "el-file-select", type: "image", value: "", icon: "icon-tupianpic"},
    {label: "图片列表", is: "el-file-list-select", type:"image", value: [], icon: "icon-huadongduotu"},
    {label: "文件上传", is: "el-file-select", type: "all", value: "", icon: "icon-a-wenjianjiawenjian"},
    {label: "文件列表", is: "el-file-list-select", type:"all", value: [], icon: "icon-wenjian1"},
    {label: "分类编号", is: "el-catalog-select", value: 0, icon: "icon-bianhaodanhao"},
    {label: "参数设置", is: "el-parameter", value: [], icon: "icon-chanpincanshu"},
    {label: "颜色选择", is: "el-color-picker", value: "", icon: "icon-yanse1"},
    {label: "开关", is: "el-switch", value: false, icon: "icon-kaiguan"},
]

// 日期时间格式
export const dateTime = (date = new Date()) => {
    let year = date.getFullYear(); // 年
    let month: string|number = date.getMonth() + 1; // 月
    month = month < 10 ? "0" + month : month; // 如果只有一位，则前面补零
    let day: string|number = date.getDate(); // 日
    day = day < 10 ? "0" + day : day; // 如果只有一位，则前面补零
    let hour: string|number = date.getHours(); // 时
    hour = hour < 10 ? "0" + hour : hour; // 如果只有一位，则前面补零
    let minute: string|number = date.getMinutes(); // 分
    minute = minute < 10 ? "0" + minute : minute; // 如果只有一位，则前面补零
    let second: string|number = date.getSeconds(); // 秒
    second = second < 10 ? "0" + second : second; // 如果只有一位，则前面补零
    return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
}