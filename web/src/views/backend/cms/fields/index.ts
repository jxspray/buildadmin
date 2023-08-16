/*
 * @Author: jxspray 1532946322@qq.com
 * @Date: 2023-07-17 10:42:44
 * @LastEditors: jxspray 1532946322@qq.com
 * @LastEditTime: 2023-08-16 17:55:32
 * @FilePath: \web\src\views\backend\cms\fields\index.ts
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
import { reactive } from 'vue'
import { param } from '/@/api/backend/cms/config'


export interface TypeOptions { 
    [key: string]: { group: 'common' | 'base' | 'senior', label: string; value: string, setting: string[], setup: { [key: string]: any } } 
}
export interface OptionGroup {
    label: 'common' | 'base' | 'senior'
    options: { label: string; value: string }[]
}

export const state: {
    typeOptions: TypeOptions
    optionGroup: OptionGroup[]
    types: string[]
    uploadAllowFormat: { file: string[], image: string[] }
    customDefalut: { [key: string]: any }
} = reactive({
    typeOptions: {} as TypeOptions,
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
    types: [] as string[],
    uploadAllowFormat: {
        file: [],
        image: []
    },
    customDefalut: {}
})
// 实现初始化方法
export const init = async () => {
    param().then(res => {
        if (res.code === 1) {
            state.typeOptions = res.data.typeOptions
            state.uploadAllowFormat = res.data.uploadAllowFormat
            state.types = []
            for (const key in state.optionGroup) state.optionGroup[key].options = []
            state.customDefalut = {}
            for (const key in state.typeOptions) {
                const element = state.typeOptions[key];
                if (element.group == 'common') state.optionGroup[0].options.push({ label: element.label, value: element.value })
                if (element.group == 'base') state.optionGroup[1].options.push({ label: element.label, value: element.value })
                if (element.group == 'senior') state.optionGroup[2].options.push({ label: element.label, value: element.value })
                state.types.push(element.value)
                state.customDefalut[key] = element.setup
            }
        }
    })
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
