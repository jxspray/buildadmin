import{b as n,d as c,T as d,a as m}from"./index-afbe03c0.js";import{_ as u}from"./popupForm.vue_vue_type_script_setup_true_lang-2ef74403.js";import{w as p,a3 as f}from"./index-32d6febb.js";import{h as b,N as _,w as h,am as k,q as g,o,k as y,z as t,O as q,W as w,p as l}from"./vue-69ad5a16.js";import"./index-f98c8d12.js";import"./index-4042c46c.js";import"./customField.vue_vue_type_script_setup_true_lang-b485c055.js";import"./validate-4db1e214.js";const T={class:"default-main ba-table-box"},$=b({name:"cms/fields",__name:"index",setup(x){const s=_(),{t:e}=p(),r=h(),a=new n(new f("/admin/cms.fields/"),{column:[{type:"selection",align:"center",operator:!1},{label:e("cms.module.title"),prop:"module.title",align:"center"},{label:e("cms.fields.field"),prop:"field",align:"center"},{label:e("cms.fields.name"),prop:"name",align:"center"},{label:e("cms.fields.type"),prop:"type",align:"center"},{label:e("cms.fields.status"),prop:"status",align:"center",render:"tag",replaceValue:{0:e("cms.fields.status 0"),1:e("cms.fields.status 1")}},{label:e("Operate"),align:"center",width:100,render:"buttons",buttons:c(["weigh-sort","edit","delete"]),operator:!1}],dblClickNotEditColumn:[void 0],filter:{module_id:s.query.module_id}},{defaultItems:{module_id:s.query.module_id,status:"1"}});return a.mount(),a.getIndex(),k("baTable",a),(C,v)=>{const i=g("el-alert");return o(),y("div",T,[t(a).table.remark?(o(),q(i,{key:0,class:"ba-table-alert",title:t(a).table.remark,type:"info","show-icon":""},null,8,["title"])):w("",!0),l(d,{buttons:["refresh","add","edit","delete","comSearch","quickSearch","columnDisplay"],"quick-search-placeholder":t(e)("Quick search placeholder",{fields:t(e)("cms.fields.quick Search Fields")})},null,8,["quick-search-placeholder"]),l(m,{ref_key:"tableRef",ref:r},null,512),l(u)])}}});export{$ as default};
