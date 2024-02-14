import {ElNotification, FormInstance, FormItemRule} from "element-plus";
import Sortable, {SortableEvent} from "sortablejs";
import useClipboard from "vue-clipboard3";
import {range} from "lodash-es";
import {nextTick, reactive} from "vue";
import {buildValidatorData} from "/@/utils/validate";
import {FieldType, FormFieldType, ElFieldForm} from "/@/views/backend/cms/interface/field";



const {toClipboard} = useClipboard();

export interface SortableEvt extends SortableEvent {
  originalEvent?: DragEvent
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
  public module: { list: FormFieldType[], show: boolean, draggingField: boolean } = reactive({
    list: [],
    // 子组件显示
    show: true,
    // 拖拽区域默认展示
    draggingField: false,
  })

  // 组件字段编辑
  public form: ElFieldForm = reactive({
    setShow: false,
    setIndex: 0,
    setForm: {field: "", label: "", type: undefined}
  })

  public rules: Partial<Record<string, FormItemRule[]>> = reactive({
    label: [buildValidatorData({name: 'required', title: "字段标题"})],
    field: [buildValidatorData({name: 'required', title: "字段变量"})],
    type: [buildValidatorData({name: 'required', title: "字段类型"})],
  })

  constructor(list: FormFieldType[] = []) {
    this.module.list = list
  }

  public openItemDialog(item: FormFieldType, index: number) {
    this.form.setIndex = index
    this.form.setForm = JSON.parse(JSON.stringify(item))
    this.form.setShow = true
  }

  public closeItemDialog() {
    this.form.setShow = false
  }

  public submitItem(formEl: FormInstance | undefined = undefined) {
    if (formEl) {
      formEl.validate((valid: boolean) => {
        if (valid) {
          this.module.list[this.form.setIndex] = this.form.setForm
          this.module.show = false
          nextTick(() => {
            this.module.show = true
          }).then(r => {
            // console.error(r)
          })
          this.closeItemDialog()
        }
      }).then(r => {
        // console.error(r)
      })
    } else {
      return false;
    }
  }

  public removeItem(index: number) {
    this.module.list.splice(index, 1)

    this.module.show = false
    nextTick(() => {
      this.module.show = true
    }).then(r => {
      // console.error(r)
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
          const item: FormFieldType = {
            field: this.common.id(6),
            label: '未命名',
            type: field
          };
          // 检查下标是否存在
          this.module.list.splice(evt.newIndex!, 0, item)
          this.openItemDialog(item, evt.newIndex!)
        }
        evt.item.remove()
        this.module.show = false;
        nextTick(() => {
          sortable.sort(range(this.fields.length).map((value) => value.toString()))
          this.module.show = true;
        }).then(r => {
          // console.error(r)
        })
        console.log(6666)
      },
      onEnd: (evt) => {
        const temp = this.module.list[evt.oldIndex!]
        this.module.list.splice(evt.oldIndex!, 1)
        this.module.list.splice(evt.newIndex!, 0, temp)
        this.module.show = false;
        nextTick(() => {
          sortable.sort(range(this.module.list.length).map((value) => value.toString()))
          this.module.show = true;
        }).then(r => {
          // console.error(r)
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
        this.module.draggingField = true
      },
      onEnd: () => {
        this.module.draggingField = false
      },
    })
  }

  public async copyItem(item: FormFieldType) {
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
