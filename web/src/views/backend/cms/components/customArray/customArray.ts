import {reactive} from "vue";
import {FormInstance} from "element-plus";

interface FieldType { label: string, type: string, width: string, value: any }
interface ValueProps {
    column: { label: string, field: string, type?: FieldType }[]
    table: any[]
}
interface CustomArrayForm {
    setShow: boolean
    setForm: { label: string, field: string, type?: FieldType}
    fieldList: FieldType[]
}
export default class customArray {
    public module: {value: ValueProps, column: { label: string, field: string, type?: FieldType }[], table: any[]} = reactive({
        value: {column: [], table: []},
        column: [],
        table: []
    })
    public form: CustomArrayForm = reactive({
        setShow: false,
        setForm: {label: '', field: '', type: undefined},
        fieldList: [
            {label: '文本', type: 'string', width:'200px', value: ''},
            {label: '文本域', type: 'textarea', width:'300px', value: ''},
            {label: '编辑器', type: 'editor', width:'700px', value: ''},
            {label: '图片上传', type: 'image', width:'344px', value: ''},
            {label: '文件上传', type: 'file', width:'344px', value: ''},
            {label: '链接', type: 'link-select', width:'300px', value: {}}
        ]
    })

    constructor(value: ValueProps|string) {
		this.module.value = typeof(value) != 'string'
            ? value
            : {table: [], column: [{label: '标题', field: 'title', type: {label: '文本', type: 'string', width: "300px", value: ''}}]}
	}
	/**
	 * 新增字段
	 */
	public addField = (formEl: FormInstance | undefined = undefined) => {
		if (formEl) {
			formEl.validate((valid: boolean) => {
				if (valid) {
					let row = this.form.setForm
					this.module.column.push(row)
					this.module.table.map(item => {
						item[row.field] = row.type?.value
						return item
					})
					this.form.setShow = false
					this.form.setForm = {label: '', field: '', type: undefined}
				}
			}).then(r => {
                console.log(r)
            })
		} else {
			return false;
		}
	}
	/**
	 * 删除字段
	 */
	public delField(index: number) {
		let prop = this.module.column[index]['field']
		this.module.column.splice(index, 1)
		this.module.table.forEach(function(item, index) {
            delete item[prop]
		})
        console.log(this.module.table.toString())
	}
	/**
	 * 新增行
	 */
	public pushTable(index: number|string) {
		let ob: any = {};
		this.module.column.forEach( function (item, index) {
			ob[item.field] = item.type?.value;
		});
		index === "" ? this.module.table.push(ob) : this.module.table.splice(index + 1, 0, ob);
	}
	/**
	 * 删除数组
	 */
	public removeTable(index: number) {
		this.module.table.splice(index, 1);
	}

	public unshiftTable() {
		let ob: any = {};
		this.module.column.forEach( function (item, index) {
			ob[item.field] = item.type?.value;
		});
		this.module.table.unshift(ob);
	}
}
