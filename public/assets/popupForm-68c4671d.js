import{d as G,C,y as x,w as L,a as f,c,b as a,T as h,s as P,R as g,Q as y,u as e,v as K,e as m,t as R,a4 as U,Y as W,ah as $,r as i,X as p}from"./vue-9a46e809.js";import{a as q}from"./index-ae07247d.js";import{f as A}from"./common-535f3731.js";import{h as H}from"./controllerUrls-941681c3.js";import{u as w}from"./random-1d7fa280.js";import{F as Q}from"./index-a7be6d6a.js";import{b as X}from"./validate-61c16ed0.js";import{_ as Y}from"./_plugin-vue_export-helper-c27b6911.js";import"./index-81eda047.js";import"./iconfont-76d408a9.js";import"./index-01bed986.js";import"./index-e2596456.js";function J(){return A({url:H+"index",method:"get"})}const M={class:"title"},O=G({__name:"popupForm",setup(Z,{expose:V}){const _=C(),b=C(),t=$("baTable"),{t:l}=q(),r=x({treeKey:w(),defaultCheckedKeys:[],menuRules:[]}),F=x({name:[X({name:"required",title:l("user.group.Group name")})],auth:[{required:!0,validator:(s,o,n)=>v().length<=0?n(new Error(l("Please select field",{field:l("user.group.jurisdiction")}))):n()}]});J().then(s=>{r.menuRules=s.data.list});const v=()=>_.value.getCheckedKeys().concat(_.value.getHalfCheckedKeys()),N=(s,o)=>{if(o.isLeaf)return"";let n=!0;for(const u in o.childNodes)o.childNodes[u].isLeaf||(n=!1);return n?"penultimate-node":""};return V({getCheckeds:v}),L(()=>t.form.items.rules,()=>{if(t.form.items.rules&&t.form.items.rules.length)if(t.form.items.rules.includes("*")){let s=[];for(const o in r.menuRules)s.push(r.menuRules[o].id);r.defaultCheckedKeys=s}else r.defaultCheckedKeys=t.form.items.rules;else r.defaultCheckedKeys=[];r.treeKey=w()}),(s,o)=>{const n=i("el-input"),u=i("el-form-item"),S=i("el-tree"),D=i("el-form"),I=i("el-scrollbar"),k=i("el-button"),z=i("el-dialog"),B=p("drag"),T=p("zoom"),j=p("loading"),E=p("blur");return f(),c(z,{class:"ba-operate-dialog",top:"10vh","close-on-click-modal":!1,"model-value":!!e(t).form.operate,onClose:e(t).toggleForm,"destroy-on-close":!0},{header:a(()=>[h((f(),P("div",M,[g(y(e(t).form.operate?e(l)(e(t).form.operate):""),1)])),[[B,[".ba-operate-dialog",".el-dialog__header"]],[T,".ba-operate-dialog"]])]),footer:a(()=>[K("div",{style:R("width: calc(100% - "+e(t).form.labelWidth/1.8+"px)")},[m(k,{onClick:o[3]||(o[3]=d=>e(t).toggleForm(""))},{default:a(()=>[g(y(e(l)("Cancel")),1)]),_:1}),h((f(),c(k,{loading:e(t).form.submitLoading,onClick:o[4]||(o[4]=d=>e(t).onSubmit(b.value)),type:"primary"},{default:a(()=>[g(y(e(t).form.operateIds&&e(t).form.operateIds.length>1?e(l)("Save and edit next item"):e(l)("Save")),1)]),_:1},8,["loading"])),[[E]])],4)]),default:a(()=>[h((f(),c(I,{class:"ba-table-form-scrollbar"},{default:a(()=>[K("div",{class:W(["ba-operate-form","ba-"+e(t).form.operate+"-form"]),style:R("width: calc(100% - "+e(t).form.labelWidth/2+"px)")},[m(D,{ref_key:"formRef",ref:b,onKeyup:o[2]||(o[2]=U(d=>e(t).onSubmit(b.value),["enter"])),model:e(t).form.items,"label-position":"right","label-width":e(t).form.labelWidth+"px",rules:F},{default:a(()=>[m(u,{prop:"name",label:e(l)("user.group.Group name")},{default:a(()=>[m(n,{modelValue:e(t).form.items.name,"onUpdate:modelValue":o[0]||(o[0]=d=>e(t).form.items.name=d),type:"string",placeholder:e(l)("Please input field",{field:e(l)("user.group.Group name")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),m(u,{prop:"auth",label:e(l)("user.group.jurisdiction")},{default:a(()=>[(f(),c(S,{ref_key:"treeRef",ref:_,key:r.treeKey,"default-checked-keys":r.defaultCheckedKeys,"default-expand-all":!0,"show-checkbox":"","node-key":"id",props:{children:"children",label:"title",class:N},data:r.menuRules},null,8,["default-checked-keys","props","data"]))]),_:1},8,["label"]),m(Q,{label:e(l)("state"),modelValue:e(t).form.items.status,"onUpdate:modelValue":o[1]||(o[1]=d=>e(t).form.items.status=d),type:"radio",data:{content:{0:e(l)("Disable"),1:e(l)("Enable")},childrenAttr:{border:!0}}},null,8,["label","modelValue","data"])]),_:1},8,["model","label-width","rules"])],6)]),_:1})),[[j,e(t).form.loading]])]),_:1},8,["model-value","onClose"])}}});const fe=Y(O,[["__scopeId","data-v-72027edc"]]);export{fe as default};
