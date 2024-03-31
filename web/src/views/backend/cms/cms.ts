import {TemplateFile, CommonField} from "/@/views/backend/cms/interface";
// import {config, initialize} from "/@/api/backend/cms";
import {config, initialize} from "/@/api/backend/cms";
import {ElLoading} from "element-plus";
import {debounce} from "/@/utils/common";
import createAxios from "/@/utils/axios";
let loadingInstance: any
export default class Cms {
  private static _instance: Cms;
  private constructor() {
    // 私有构造函数，确保外部无法直接创建实例
  }
  static getInstance(): Cms {
    if (!Cms._instance) {
      Cms._instance = new Cms();
    }
    return Cms._instance;
  }


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
    get loadStatus(): "noloaded" | "loading" | "loadend" {
        return this._loadStatus;
    }
    get templates(): TemplateFile[] {
      console.log(this._templates)
        return this._templates;
    }

    set templates(value: TemplateFile[]) {
        // config.templates =
          this._templates = value;
    }

    get moduleList(): any[] {
        // 检查是否初始化完成
        return this._moduleList;
    }

    set moduleList(value: any[]) {
        // config.moduleList =
          this._moduleList = value;
    }

    get catalogList(): any[] {
        return this._catalogList;
    }

    set catalogList(value: any[]) {
        // config.catalogList =
          this._catalogList = value;
    }

    get commonField(): CommonField {
        return this._commonField;
    }

    set commonField(value: CommonField) {
        // config.commonField =
          this._commonField = value;
    }
    private _templates: TemplateFile[] = []

    private _moduleList: any[] = []
    private _catalogList: any[] = []
    private _commonField: CommonField = {top: [], foot: []}
    private _loadStatus: 'noloaded' | 'loading' | 'loadend' = 'noloaded'

    async init() {
      this.loadStatus = 'loading'
      const loadingInstance = ElLoading.service({ fullscreen: true })
      await createAxios({
        url: '/admin/cms.api/init',
        method: 'get'
      }).then(async (res) => {
        this.moduleList = res.data.moduleList
        this.catalogList = res.data.catalogList
        this.templates = res.data.templates
        this.commonField = res.data.commonField
        this.loadStatus = 'loadend'
        console.log("初始化CMS配置完成")
        loadingInstance.close();
      })
    }

    async update(scene: "module" | "catalog" | "templates" | "common", data: any) {
      this.loadStatus = 'loading'
      const loadingInstance = ElLoading.service({ fullscreen: true })
      await createAxios({
        url: '/admin/cms.api/init',
        method: 'get',
        data: {
          scene: scene
        }
      }).then(async (res) => {
        switch (scene) {
          case 'module':
            this.moduleList = res.data.moduleList;
            break;
          case 'catalog':
            this.catalogList = res.data.catalogList;
            break;
          case 'templates':
            this.templates = res.data.templates;
            break;
          case 'common':
            this.commonField = res.data.commonField;
            break;
        }
        this.loadStatus = 'loadend'
        loadingInstance.close();
      })
    }
}
