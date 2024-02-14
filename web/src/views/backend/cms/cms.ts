import type {baTableApi} from "/@/api/common";
import createAxios from "/@/utils/axios";
import baTable from "/@/utils/baTable";
import {TemplateFile, CommonField} from "/@/views/backend/cms/interface";

export default class Cms extends baTable {
    public templates: TemplateFile[] = []
    public template: TemplateFile = {index: [], info: []}

    public moduleList: any[] = []
    public catalogList: any[] = []
    public commonField: CommonField = {top: [], foot: []}
    constructor(api: baTableApi, table: BaTable, form: BaTableForm = {}, before: BaTableBefore = {}, after: BaTableAfter = {}) {
        super(api, table, form, before, after);
        this.api.actionUrl.set("init", "/admin/cms.catalog/init");
        this.api.actionUrl.set("configEdit", "/admin/cms.config/edit");
        this.init()
    }
    init = () => {
        if (this.runBefore('requestInit', {}) === false) return
        return createAxios<{moduleList: any[], catalogList: any[], commonField: CommonField, templates: TemplateFile[] }>({
            url: this.api.actionUrl.get('init'),
            method: 'get',
        }).then((res) => {
            this.moduleList = res.data.moduleList
            this.catalogList = res.data.catalogList
            this.templates = res.data.templates
            this.commonField = res.data.commonField
            this.form.defaultItems!.top_field = this.commonField.top
            this.setTemplate(0)
            this.runAfter('requestInit', { res })
        })
    }
    handleCommonField = (oldCommonField: any[], type: string) => {
        const commonField: any[] = JSON.parse(JSON.stringify(this.commonField[type]));
        if (oldCommonField && typeof oldCommonField != "undefined" && oldCommonField.length) {
            const fields: any[] = [];
            const oldField: { [key: string]: any } = {};
            oldCommonField.forEach((item: any) => {
                oldField[item.field] = item.type.value
            })
            commonField.forEach((item, commonFieldKey) => {
                const oldTypeof = typeof oldField[item.field];
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
        if (typeof this.templates[module_id] != "undefined") {
            this.template.index =  this.templates[module_id]!.index;
            this.template.info =  this.templates[module_id]!.info;
        } else {
            this.template.index = [];
            this.template.info = [];
        }
    }
}
