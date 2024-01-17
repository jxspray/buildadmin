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
      this.setTemplate(0)
      this.runAfter('requestInit', { res })
    })
  }
  setTemplate = (module_id: number) => {
    this.template.index =  this.templates[module_id]!.index;
    this.template.info =  this.templates[module_id]!.info;
  }
}
