import {SortableEvent} from "sortablejs";
import {ElNotification} from "element-plus";

import useClipboard from "vue-clipboard3";
const {toClipboard} = useClipboard();

export interface SortableEvt extends SortableEvent {
    originalEvent?: DragEvent
}
export interface FieldType {
    label: string
    value: any
    icon: string
    field?: string
    type?: string
}

// 自定义字段类型
// noinspection SpellCheckingInspection
export const fields: FieldType[] = [
    {label: "文本", type: "string", value: "", icon: "local-danhangshurukuang"},
    {label: "文本域", type: "textarea", value: "", icon: "local-duohangshurukuang"},
    {label: "编辑器", type: "editor", value: "", icon: "local-fuwenbenbianjiqi"},
    {label: "链接设置", type: "link-select", value: {}, icon: "local-lianjie"},
    {label: "自定义数组", type: "customArray", value: {}, icon: "local-shuzu"},
    {label: "图片上传", type: "image", value: "", icon: "local-tupianpic"},
    {label: "图片列表", type: "images", value: [], icon: "local-huadongduotu"},
    {label: "文件上传", type: "file", value: "", icon: "local-wenjianjiawenjian"},
    {label: "文件列表", type: "files", value: [], icon: "local-wenjian1"},
    {label: "分类编号", type: "remoteSelect", value: 0, icon: "local-bianhaodanhao"},
    {label: "参数设置", type: "array", value: [], icon: "local-chanpincanshu"},
    {label: "颜色选择", type: "color", value: "", icon: "local-yanse1"},
    {label: "开关", type: "switch", value: false, icon: "local-kaiguan"},
]

/**
 * 公共函数
 */
export const common = {
    // 随机字符串
    id(len: number = 16) {
        const chars: string = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
        let id: string = '';
        for (let i: number = 0; i < len; i++) {
            id += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return id;
    },
    // 随机字段
    field(len: number = 16) {
        const chars: string = 'abcdefhijkmnprstwxyz1234567890';
        let id: string = '';
        for (let i: number = 0; i < len; i++) {
            id += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return id;
    }
}


/**
 * 复制字段
 */
export const copyItem = async (item: FieldType, index: number) => {
    let text = item.field;
    try {
        await toClipboard(text);  //实现复制
        ElNotification({
            message: "复制成功",
            type: 'success',
        })
    } catch (e) {
        console.error(e)
    }
}
