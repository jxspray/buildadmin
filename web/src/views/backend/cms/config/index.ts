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

    remoteSelect: { group: 'base', label: "远程下拉选择", value: 'remoteSelect', setting: ['remoteSelect'] },
    remoteSelects: { group: 'base', label: "远程下拉选择(多选)", value: 'remoteSelects', setting: ['remoteSelect', 'selectNum'] },
    datePicker: { group: 'base', label: "时间日期选择", value: 'datePicker', setting: ['datePicker'] },
    city: { group: 'base', label: "城市选择", value: 'city', setting: [] },

    image: { group: 'senior', label: "图片上传", value: 'image', setting: ['upload', 'image'] },
    images: { group: 'senior', label: "图片上传-多图", value: 'images', setting: ['uploads', 'image'] },
    file: { group: 'senior', label: "文件上传", value: 'file', setting: ['upload', 'file'] },
    files: { group: 'senior', label: "文件上传-多文件", value: 'files', setting: ['uploads', 'file'] },
    editor: { group: 'senior', label: "富文本编辑器", value: 'editor', setting: ['editor'] },
    // verify: { group: 'senior', label: "验证码", value: 'verify', setting: ['verify'] },
    custom: { group: 'senior', label: "自定义多文本", value: 'custom', setting: ['custom'] },
    tag: { group: 'senior', label: "标签", value: 'tag', setting: ['tag'] },
}
    
//     upload: "上传", 
//     verify: "验证码", 
//     custom: "自定义多文本", 
//     tag: "标签" 

export interface OptionGroup {
    label: 'common' | 'base' | 'senior'
    options: { label: string; value: string }[]
}
export const state: {
    optionGroup: OptionGroup[]
    types: string[]
} = reactive({
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
    ] as OptionGroup[],
    types: [] as string[]
})
for (const key in typeOptions) {
    const element = typeOptions[key];
    if (element.group == 'common') state.optionGroup[0].options.push({ label: element.label, value: element.value })
    if (element.group == 'base') state.optionGroup[1].options.push({ label: element.label, value: element.value })
    if (element.group == 'senior') state.optionGroup[2].options.push({ label: element.label, value: element.value })
    state.types.push(element.value)
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
