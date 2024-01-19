import baTable from "/@/utils/baTable";
import type {baTableApi} from "/@/api/common";
import createAxios from "/@/utils/axios";

export interface CmsTemplate {
  index: string[]
  info: string[]
}
export interface CmsCommonField {
  [key: string]: any[]
}
export default class catalogTable extends baTable {
  public templates: CmsTemplate[] = []
  public template: CmsTemplate = {index: [], info: []}

  public moduleList: any[] = []
  public catalogList: any[] = []
  public commonField: CmsCommonField = {top: [], foot: []}
  constructor(api: baTableApi, table: BaTable, form: BaTableForm = {}, before: BaTableBefore = {}, after: BaTableAfter = {}) {
    super(api, table, form, before, after);
    this.api.actionUrl.set("init", "/admin/cms.catalog/init");
    this.api.actionUrl.set("configEdit", "/admin/cms.config/edit");
    this.init()
  }
  init = () => {
    if (this.runBefore('requestInit', {}) === false) return
    return createAxios<{moduleList: any[], catalogList: any[], commonField: CmsCommonField, templates: CmsTemplate[] }>({
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
    var commonField: any[] = JSON.parse(JSON.stringify(this.commonField[type]))
    if (oldCommonField && typeof oldCommonField != "undefined" && oldCommonField.length) {
      var fields: any[] = []
      var oldField: { [key: string]: any } = {}
      oldCommonField.forEach((item: any) => {
        oldField[item.field] = item.type.value
      })
      commonField.forEach((item, commonFieldKey) => {
        var oldTypeof = typeof oldField[item.field]
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
