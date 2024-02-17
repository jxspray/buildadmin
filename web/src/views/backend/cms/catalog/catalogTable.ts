import baTable from "/@/utils/baTable";
import type {baTableApi} from "/@/api/common";

import Cms from "/@/views/backend/cms/cms";
import {TemplateFile} from "/@/views/backend/cms/interface";
const cms = new Cms()

export default class catalogTable extends baTable {
    public template: TemplateFile = {index: [], info: []}

    public moduleList: any[] = []
    public catalogList: any[] = []

    constructor(api: baTableApi, table: BaTable, form: BaTableForm = {}, before: BaTableBefore = {}, after: BaTableAfter = {}) {
        super(api, table, form, before, after);
        this.api.actionUrl.set("configEdit", "/admin/cms.config/edit?name=common&group=catalog");
        cms.init(() => {
            this.moduleList = cms.moduleList
            this.catalogList = cms.catalogList
            this.form.defaultItems!.top_field = cms.commonField.top
            this.setTemplate(0)
            console.log("初始化完成")
        })
    }
    handleCommonField = (oldCommonField: any[], type: string) => {
        const commonField: any[] = JSON.parse(JSON.stringify(cms.commonField[type]));
        if (oldCommonField && typeof oldCommonField != "undefined" && oldCommonField.length) {
            const fields: any[] = [];
            const oldField: { [key: string]: any } = {}
            oldCommonField.forEach((item: any) => {
                oldField[item.field] = item.type.value
            })
            commonField.forEach((item, commonFieldKey) => {
                const oldTypeof = typeof oldField[item.field]
                if (typeof oldTypeof == "undefined" || oldTypeof != typeof item.type.value) commonField[commonFieldKey] = item
                else {
                    item.type.value = oldField[item.field]
                    fields[commonFieldKey] = item
                }
            })
            return fields;
        } else return commonField;
    }
    setTemplate = (module_id: number) => {
        if (typeof cms.templates[module_id] != "undefined") {
            this.template.index = cms.templates[module_id]!.index;
            this.template.info = cms.templates[module_id]!.info;
        } else {
            this.template.index = [];
            this.template.info = [];
        }
    }
}
