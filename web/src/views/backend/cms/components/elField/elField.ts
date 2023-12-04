import {ElNotification, FormInstance, FormItemRule} from "element-plus";
import Sortable, {SortableEvent} from "sortablejs";
import useClipboard from "vue-clipboard3";
import {range} from "lodash-es";
import {reactive, nextTick} from "vue";
import {buildValidatorData} from "/@/utils/validate";

const {toClipboard} = useClipboard();
export interface SortableEvt extends SortableEvent {
    originalEvent?: DragEvent
}
interface FieldType {
    value: any
    label: string
    icon: string
    type: string
}
interface FormFieldType {
    field: string
    label: string
    type?: FieldType
}

export default class elField {
    // noinspection SpellCheckingInspection 自定义字段类型
    public fields: FieldType[] = [
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
    // 自定义编辑器组件初始化
    public list: FormFieldType[] = []
    // 子组件显示
    public show: boolean = true
    // 拖拽区域默认展示
    public draggingField: boolean = false

    // 组件字段编辑表单展示
    public setShow: boolean = false
    // 编辑组件下标
    public setIndex: number = 0
    // 初始化编辑表单内容
    public setForm: FormFieldType = { field: "", label: "", type: undefined }
    public rules: Partial<Record<string, FormItemRule[]>> = reactive({
        label: [buildValidatorData({name: 'required', title: "字段标题"})],
        field: [buildValidatorData({name: 'required', title: "字段变量"})],
        type: [buildValidatorData({name: 'required', title: "字段类型"})],
    })
    constructor(list: FormFieldType[] = []) {
        this.list = list
    }
    public openItemDialog(item: FormFieldType, index: number) {
        this.setIndex = index
        this.setForm = item
        this.setShow = true
        console.log(this.setShow)
    }

    public closeItemDialog() {
        this.setShow = false
        console.log(this.setShow)
    }

    public submitItem(formEl: FormInstance | undefined = undefined) {
        if (formEl) {
            formEl.validate((valid: boolean) => {
                if (valid) {
                    this.list[this.setIndex] = this.setForm
                    this.closeItemDialog()
                }
            }).then(r => {
                console.error(r)
            })
        } else {
            return false;
        }
    }
    public removeItem (index: number) {
        this.list.splice(index, 1)

        this.show = false
        nextTick(() => {
            this.show = true
        }).then(r => {
            console.error(r)
        })
    }
    public createSortable(ref: HTMLElement) {
        const sortable = Sortable.create(ref, {
            group: 'design-field',
            animation: 200,
            filter: '.design-field-empty',
            handle: ".rank",
            onAdd: (evt: SortableEvt) => {
                if (this.fields[evt.oldIndex!]) {
                    const field: FieldType = this.fields[evt.oldIndex!]
                    const item: FormFieldType =  {
                        field: this.common.id(6),
                        label: '未命名',
                        type: field
                    };
                    // 检查下标是否存在
                    this.list.splice(evt.newIndex!, 0, item)
                    this.openItemDialog(item, evt.newIndex!)
                }
                evt.item.remove()
                this.show = false;
                nextTick(() => {
                    sortable.sort(range(this.fields.length).map((value) => value.toString()))
                    this.show = true;
                }).then(r => {
                    console.error(r)
                })
            },
            onEnd: (evt) => {
                const temp = this.list[evt.oldIndex!]
                this.list.splice(evt.oldIndex!, 1)
                this.list.splice(evt.newIndex!, 0, temp)
                nextTick(() => {
                    sortable.sort(range(this.list.length).map((value) => value.toString()))
                }).then(r => {
                    console.error(r)
                })
            },
        })
    }
    public createTabsRef(ref: HTMLElement, index: number) {
        Sortable.create(ref, {
            sort: false,
            group: {
                name: 'design-field',
                pull: 'clone',
                put: false,
            },
            animation: 200,
            setData: (dataTransfer) => {
                dataTransfer.setData('name', Object.keys(this.fields)[index])
            },
            onStart: () => {
                this.draggingField = true
            },
            onEnd: () => {
                this.draggingField = false
            },
        })
    }
    public async copyItem (item: FormFieldType) {
        let text = item.field;
        try {
            await toClipboard(text);  //实现复制
            ElNotification({
                message: "复制成功",
                type: 'success'
            })
        } catch (e) {
            console.error(e)
        }
    }

    /**
     * 公共函数
     */
    public common = {
        // 随机字符串
        id(len: number = 16) {
            // noinspection SpellCheckingInspection
            const chars: string = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
            let id: string = '';
            for (let i: number = 0; i < len; i++) {
                id += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return id;
        },
        // 随机字段
        field(len: number = 16) {
            // noinspection SpellCheckingInspection
            const chars: string = 'abcdefhijkmnprstwxyz1234567890';
            let id: string = '';
            for (let i: number = 0; i < len; i++) {
                id += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return id;
        }
    }
}
