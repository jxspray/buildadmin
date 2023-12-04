import {ElNotification, FormInstance} from "element-plus";
import {nextTick} from "vue/dist/vue";
import Sortable from "sortablejs";
import {common, fields, SortableEvt} from "/@/views/backend/cms/components/elField/elField";
import {range} from "lodash-es";

interface FieldType {
    value: any
    label: string
    icon: string
    field?: string
    type?: string
}
interface FormFieldType {
    field: string
    label: string
    type: FieldType
}
export default class elField {
    // 自定义编辑器组件初始化
    public list: FormFieldType[] = []
    // 子组件显示
    public show: boolean = false
    // 拖拽区域默认展示
    public draggingField: boolean = false

    // 组件字段编辑表单展示
    public setShow: boolean = false
    // 编辑组件下标
    public setIndex: number = 0
    // 初始化编辑表单内容
    public setForm: FormFieldType|undefined
    constructor(list: FormFieldType[] = []) {
        this.list = list
    }
    public openItemDialog(item: FormFieldType, index: number) {
        this.setIndex = index
        this.setForm = item
        this.setShow = true
    }

    public closeItemDialog() {
        this.setShow = false
    }

    public submitItem(formEl: FormInstance | undefined = undefined) {
        if (this.setForm) {
            if (formEl) {
                formEl.validate((valid: boolean) => {
                    if (valid) {
                        this.list[this.setIndex] = this.setForm
                        this.closeItemDialog()
                    }
                })
            } else {
                return false;
            }
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
            console.error("error")
        })
    }
    public createSortable(ref: HTMLElement) {
        const sortable = Sortable.create(ref, {
            group: 'design-field',
            animation: 200,
            filter: '.design-field-empty',
            handle: ".rank",
            onAdd: (evt: SortableEvt) => {
                if (fields[evt.oldIndex!]) {
                    const field: FieldType = fields[evt.oldIndex!]
                    const item: FormFieldType =  {
                        field: common.id(6),
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
                    sortable.sort(range(fields.length).map((value) => value.toString()))
                    this.show = true;
                })
            },
            onEnd: (evt) => {
                const temp = this.list[evt.oldIndex!]
                this.list.splice(evt.oldIndex!, 1)
                this.list.splice(evt.newIndex!, 0, temp)
                nextTick(() => {
                    sortable.sort(range(this.list.length).map((value) => value.toString()))
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
                dataTransfer.setData('name', Object.keys(fields)[index])
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
                type: 'success',
            })
        } catch (e) {
            console.error(e)
        }
    }
}
