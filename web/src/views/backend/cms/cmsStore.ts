import { defineStore } from 'pinia'
import {Config} from "/@/views/backend/cms/interface";

export const useConfig = defineStore('cmsConfig', {
    state: (): Config => {
        return {
            templates: [],
            moduleList: [],
            catalogList: [],
            commonField: {top: [], foot: []},
            initialize: false
        }
    },
    actions: {
        dataFill(state: Config) {
            this.$state = state
        },
    },
})
