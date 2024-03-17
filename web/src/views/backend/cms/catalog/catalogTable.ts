import baTable from "/@/utils/baTable";
import type {baTableApi} from "/@/api/common";

import Cms from "/@/views/backend/cms/cms";
import {TemplateFile} from "/@/views/backend/cms/interface";

const cms = new Cms()

export default class catalogTable extends baTable {
   get moduleList(): any[] {
    return this._moduleList;
  }

  set moduleList(value: any[]) {
    this._moduleList = value;
  }

  get catalogList(): any[] {
    return this._catalogList;
  }

  set catalogList(value: any[]) {
    this._catalogList = value;
  }

  public template: TemplateFile = {index: [], info: []}

  private _moduleList: any[] = []
  private _catalogList: any[] = []

  constructor(api: baTableApi, table: BaTable, form: BaTableForm = {}, before: BaTableBefore = {}, after: BaTableAfter = {}) {
    super(api, table, form, before, after);
    this.api.actionUrl.set("configEdit", "/admin/cms.config/edit?name=common&group=catalog");
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
