import { reactive } from 'vue'


export interface TypeOptions { 
    [key: string]: { group: 'common' | 'base' | 'senior', label: string; value: string, setting: string[] } 
}
export const typeOptions: TypeOptions = 
{
    text: { group: 'common', label: "文本框", value: 'text', setting: ['textType'] },
    radio: { group: 'common', label: "单选按钮", value: 'radio', setting: ['select'] },
    checkbox: { group: 'common', label: "复选框", value: 'checkbox', setting: ['select', 'selectNum'] },
    select: { group: 'common', label: "下拉框", value: 'select', setting: ['select'] },
    selects: { group: 'common', label: "下拉框(多选)", value: 'selects', setting: ['select', 'selectNum'] },
    remoteSelect: { group: 'common', label: "远程下拉选择", value: 'remoteSelect', setting: ['remoteSelect'] },
    remoteSelects: { group: 'common', label: "远程下拉选择(多选)", value: 'remoteSelects', setting: ['remoteSelect', 'selectNum'] },
    datePicker: { group: 'common', label: "时间日期选择", value: 'datePicker', setting: ['datePicker'] },
    city: { group: 'common', label: "城市选择", value: 'city', setting: [] },
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

export interface OptionGroup {
    label: 'common' | 'base' | 'senior'
    options: { label: string; value: string }[]
}
export const state = reactive({
    optionGroup: [
        {
            label: 'common',
            options: []
        },
        {
            label: 'base',
            options: []
        },
        {
            label: 'senior',
            options: []
        }
    ] as OptionGroup[]
})
for (const key in typeOptions) {
    const element = typeOptions[key];
    if (element.group == 'common') state.optionGroup[0].options.push({ label: element.label, value: element.value })
    if (element.group == 'base') state.optionGroup[1].options.push({ label: element.label, value: element.value })
    if (element.group == 'senior') state.optionGroup[2].options.push({ label: element.label, value: element.value })
}

// export const customFields: {
// } = {
// }
// typeOptions.forEach((option: TypeOptions, key: number) => {
//     state.typeOptions[key].options.push({
//         label: item.title,
//         value: item.designType
//     })
// });
