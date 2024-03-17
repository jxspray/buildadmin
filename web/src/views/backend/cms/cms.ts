import {TemplateFile, CommonField} from "/@/views/backend/cms/interface";
import {config, initialize} from "/@/api/backend/cms";
import {ElLoading} from "element-plus";
let loadingInstance: any
export default class Cms {
    set loadStatus(value: "noloaded" | "loading" | "loadend") {
        this._loadStatus = value;
        if (value === "loading") {
            loadingInstance = ElLoading.service({
                lock: true,
                text: "加载中",
                background: "rgba(0, 0, 0, 0.7)"
            })
        } else if (value === "loadend") {
            loadingInstance.close()
        }
    }
    get templates(): TemplateFile[] {
        return this._templates;
    }

    set templates(value: TemplateFile[]) {
        config.templates = this._templates = value;
    }

    get moduleList(): any[] {
        // 检查是否初始化完成
        return this._moduleList;
    }

    set moduleList(value: any[]) {
        config.moduleList = this._moduleList = value;
    }

    get catalogList(): any[] {
        return this._catalogList;
    }

    set catalogList(value: any[]) {
        config.catalogList = this._catalogList = value;
    }

    get commonField(): CommonField {
        return this._commonField;
    }

    set commonField(value: CommonField) {
        config.commonField = this._commonField = value;
    }
    private _templates: TemplateFile[] = []

    private _moduleList: any[] = []
    private _catalogList: any[] = []
    private _commonField: CommonField = {top: [], foot: []}
    private _loadStatus: 'noloaded' | 'loading' | 'loadend' = 'noloaded'

    constructor() {
        this.loadStatus = 'loading'
        initialize(res => {
            this.moduleList = res.data.moduleList
            this.catalogList = res.data.catalogList
            this.templates = res.data.templates
            this.commonField = res.data.commonField
            this.loadStatus = 'loadend'
        })
    }


    async init(callback: () => void) {
        initialize(res => {
            this._moduleList = res.data._moduleList
            this._catalogList = res.data._catalogList
            this._templates = res.data._templates
            this._commonField = res.data._commonField
            callback()
        })
        return ""
    }
}
