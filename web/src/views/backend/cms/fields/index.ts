import { reactive } from 'vue'

export interface TypeOptions {
    label: 'common' | 'base' | 'senior'
    options: { label: string; value: string }[]
}[]

export const typeOptions: TypeOptions[] = [
    {
        label: 'common',
        options: [
            { label: "文本框", value: 'text' },
            { label: "单选按钮", value: 'radio' },
            { label: "复选框", value: 'checkbox' },
            { label: "下拉框", value: 'select' },
            { label: "下拉框(多选)", value: 'selects' },
            { label: "远程下拉选择", value: 'remoteSelect' },
            { label: "远程下拉选择(多选)", value: 'remoteSelects' },
            { label: "时间日期选择", value: 'datePicker' },
            { label: "城市选择", value: 'city' },
        ],
    },
    {
        label: 'base',
        options: [],
    },
    {
        label: 'senior',
        options: [],
    }
    
//     text: "文本框", 
//     radio: "单选按钮", 
//     checkbox: "复选框", 
//     select: "下拉选择", 
//     remoteSelect: "远程下拉选择框", 
//     datePicker: "日期选择器", 
//     city: "省市区选择器", 
//     editor: "富文本编辑器", 
//     upload: "上传", 
//     verify: "验证码", 
//     custom: "自定义多文本", 
//     tag: "标签" 
]

// export const customFields: {
// } = {
// }
// typeOptions.forEach((option: TypeOptions, key: number) => {
//     state.typeOptions[key].options.push({
//         label: item.title,
//         value: item.designType
//     })
// });



// export const state = reactive({