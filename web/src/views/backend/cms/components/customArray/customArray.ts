import {nextTick, reactive} from "vue";
import {FormInstance, FormItemRule} from "element-plus";
import {buildValidatorData} from "/@/utils/validate";

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
	public module: {value: ValueProps, column: { label: string, field: string, type?: FieldType }[], table: any[], show: boolean} = reactive({
		value: {column: [], table: []},
		column: [],
		table: [],
		show: true
	})
	public form: CustomArrayForm = reactive({
		setShow: false,
		setForm: {label: '', field: '', type: undefined},
		fieldList: []
	})
	public fieldList: FieldType[] =  [
		{label: '文本', type: 'string', width:'200px', value: ''},
		{label: '文本域', type: 'textarea', width:'300px', value: ''},
		{label: '编辑器', type: 'editor', width:'700px', value: ''},
		{label: '图片上传', type: 'image', width:'344px', value: ''},
		{label: '文件上传', type: 'file', width:'344px', value: ''},
		{label: '链接', type: 'link-select', width:'300px', value: {}}
	]
	public rules: Partial<Record<string, FormItemRule[]>> = reactive({
		label: [buildValidatorData({name: 'required', title: '字段标题'})],
		field: [buildValidatorData({name: 'required', title: '字段变量'})],
		type: [buildValidatorData({name: 'required', title: '字段类型'})],
	})

	constructor(value: ValueProps|string) {
		this.module.value = typeof(value) != 'string'
			? value
			: {table: [], column: [{label: '标题', field: 'title', type: {label: '文本', type: 'string', width: "300px", value: ''}}]}
		this.module.column = this.module.value.column
		this.module.table = this.module.value.table
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
		let prop = this.module.column[index].field
		this.module.column.splice(index, 1)
		this.module.table.forEach(item => {
			delete item[prop]
		})
		this.module.show = false
		nextTick(() => {
			this.module.show = true
		}).then(r => {
			// console.error(r)
		})
	}
	/**
	 * 新增行
	 */
	public pushTable(index: number|undefined) {
		let ob: any = {};
		this.module.column.forEach( item => {
			ob[item.field] = item.type?.value;
		});
		index === undefined ? this.module.table.push(ob) : this.module.table.splice(index + 1, 0, ob);
	}
	/**
	 * 删除数组
	 */
	public removeTable(index: number) {
		this.module.table.splice(index, 1);
	}

	public unshiftTable() {
		let ob: any = {};
		this.module.column.forEach( item => {
			ob[item.field] = item.type?.value;
		});
		this.module.table.unshift(ob);
	}
}
