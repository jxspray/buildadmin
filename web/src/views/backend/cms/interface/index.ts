export interface TemplateFile {
    index: string[]
    info: string[]
}

export interface CommonField {
    [key: string]: any[]
}
export interface Config {
    templates: TemplateFile[]
    moduleList: any[]
    catalogList: any[]
    commonField: CommonField
    initialize: boolean
}
