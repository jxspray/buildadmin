import{i as f,B as b}from"./index-81eda047.js";import{d as y,q as _,e as l,r as c}from"./vue-9a46e809.js";import{_ as v}from"./_plugin-vue_export-helper-c27b6911.js";import"./common-535f3731.js";import"./index-ae07247d.js";import"./random-1d7fa280.js";import"./iconfont-76d408a9.js";import"./index-01bed986.js";import"./controllerUrls-941681c3.js";import"./index-e2596456.js";const S={catalog:"/admin/cms.catalog/index"},g=y({name:"formItem",props:{label:{type:String},type:{type:String,required:!0,validator:e=>f.includes(e)},modelValue:{required:!0},option:{type:Object,default:()=>{}},inputAttr:{type:Object,default:()=>{}},attr:{type:Object,default:()=>{}},data:{type:Object,default:()=>{}},prop:{type:String,default:""},placeholder:{type:String,default:""}},emits:["update:modelValue"],setup(e,{emit:u}){let{type:a,inputAttr:o,data:d}=e;e.type=="remoteSelect"&&(o={field:e.option.setup.valueField,"remote-url":S[e.option.setup.remoteName]});const m=t=>{u("update:modelValue",t)},n=_(()=>e.attr&&e.attr["block-help"]?e.attr["block-help"]:"");if(["select","selects","radio","checkbox"].includes(a)){let t={};e.option.setup.options.forEach(i=>{t[i.key]=i.value}),d={content:t}}["select","remoteSelect"].includes(a)&&e.option.setup.maxSelect>1&&(o.multiple=!0);const r=()=>{let t=l(b,{type:a,attr:{placeholder:e.placeholder,...o},data:d,modelValue:e.modelValue,"onUpdate:modelValue":m});return n.value?[t,l("div",{class:"block-help"},n.value)]:t},s=["string","password","number","textarea","datetime","year","date","time","select","selects","remoteSelect","city","icon","color"],p=["radio","checkbox","switch","array","image","images","file","files","editor"];if(s.includes(a))return()=>l(c("el-form-item"),{prop:e.prop,...e.attr,label:e.label},{default:r});if(p.includes(a)){let t=e.data&&e.data.title?e.data.title:e.label;const i=()=>[l("div",{class:"ba-form-item-label"},[l("div",null,t),l("div",{class:"ba-form-item-label-tip"},e.data&&e.data.tip?e.data.tip:"")])];return()=>l(c("el-form-item"),{class:"ba-input-item-"+a,prop:e.prop,...e.attr,label:e.label},{label:i,default:r})}}});const A=v(g,[["__scopeId","data-v-560893b9"]]);export{A as default};
