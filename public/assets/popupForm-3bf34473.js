import{h as W,w as x,ar as $,r as V,F as j,q as d,X as c,o as u,O as f,P as s,_ as h,k as q,V as b,U as y,z as e,m as w,l as K,p as m,$ as G,a9 as L,W as H}from"./vue-b1743f2f.js";import{c as O,e as X,w as J,v as R,_ as M}from"./index-730acb34.js";import{F}from"./index-f319bf92.js";import{b as Q}from"./validate-8c0a813e.js";import"./index-4efe7d0a.js";import"./index-376c0ade.js";function Y(){return O({url:"/admin/auth.Rule/index",method:"get"})}const Z={class:"title"},ee=W({__name:"popupForm",setup(te,{expose:S}){const v=X(),_=x(),g=x(),t=$("baTable"),{t:l}=J(),a=V({treeKey:R(),defaultCheckedKeys:[],menuRules:[]}),I=V({name:[Q({name:"required",title:l("auth.group.Group name")})],auth:[{required:!0,validator:(n,o,r)=>k().length<=0?r(new Error(l("Please select field",{field:l("auth.group.jurisdiction")}))):r()}],pid:[{validator:(n,o,r)=>o&&parseInt(o)==parseInt(t.form.items.id)?r(new Error(l("auth.group.The parent group cannot be the group itself"))):r(),trigger:"blur"}]});Y().then(n=>{a.menuRules=n.data.list});const k=()=>g.value.getCheckedKeys().concat(g.value.getHalfCheckedKeys()),N=(n,o)=>{if(o.isLeaf)return"";let r=!0;for(const p in o.childNodes)o.childNodes[p].isLeaf||(r=!1);return r?"penultimate-node":""};return S({getCheckeds:k}),j(()=>t.form.items.rules,()=>{if(t.form.items.rules&&t.form.items.rules.length)if(t.form.items.rules.includes("*")){let n=[];for(const o in a.menuRules)n.push(a.menuRules[o].id);a.defaultCheckedKeys=n}else a.defaultCheckedKeys=t.form.items.rules;else a.defaultCheckedKeys=[];a.treeKey=R()}),(n,o)=>{const r=d("el-input"),p=d("el-form-item"),z=d("el-tree"),D=d("el-form"),E=d("el-scrollbar"),C=d("el-button"),P=d("el-dialog"),T=c("drag"),U=c("zoom"),A=c("loading"),B=c("blur");return u(),f(P,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":["Add","Edit"].includes(e(t).form.operate),onClose:e(t).toggleForm,"destroy-on-close":!0},{header:s(()=>[h((u(),q("div",Z,[b(y(e(t).form.operate?e(l)(e(t).form.operate):""),1)])),[[T,[".ba-operate-dialog",".el-dialog__header"]],[U,".ba-operate-dialog"]])]),footer:s(()=>[w("div",{style:K("width: calc(100% - "+e(t).form.labelWidth/1.8+"px)")},[m(C,{onClick:o[4]||(o[4]=i=>e(t).toggleForm(""))},{default:s(()=>[b(y(e(l)("Cancel")),1)]),_:1}),h((u(),f(C,{loading:e(t).form.submitLoading,onClick:o[5]||(o[5]=i=>e(t).onSubmit(_.value)),type:"primary"},{default:s(()=>[b(y(e(t).form.operateIds&&e(t).form.operateIds.length>1?e(l)("Save and edit next item"):e(l)("Save")),1)]),_:1},8,["loading"])),[[B]])],4)]),default:s(()=>[h((u(),f(E,{class:"ba-table-form-scrollbar"},{default:s(()=>[w("div",{class:G(["ba-operate-form","ba-"+e(t).form.operate+"-form"]),style:K(e(v).layout.shrink?"":"width: calc(100% - "+e(t).form.labelWidth/2+"px)")},[e(t).form.loading?H("",!0):(u(),f(D,{key:0,ref_key:"formRef",ref:_,onKeyup:o[3]||(o[3]=L(i=>e(t).onSubmit(_.value),["enter"])),model:e(t).form.items,"label-position":e(v).layout.shrink?"top":"right","label-width":e(t).form.labelWidth+"px",rules:I},{default:s(()=>[m(F,{label:e(l)("auth.group.Parent group"),modelValue:e(t).form.items.pid,"onUpdate:modelValue":o[0]||(o[0]=i=>e(t).form.items.pid=i),type:"remoteSelect",prop:"pid","input-attr":{params:{isTree:!0},field:"name","remote-url":e(t).api.actionUrl.get("index"),placeholder:e(l)("Click select")}},null,8,["label","modelValue","input-attr"]),m(p,{prop:"name",label:e(l)("auth.group.Group name")},{default:s(()=>[m(r,{modelValue:e(t).form.items.name,"onUpdate:modelValue":o[1]||(o[1]=i=>e(t).form.items.name=i),type:"string",placeholder:e(l)("Please input field",{field:e(l)("auth.group.Group name")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),m(p,{prop:"auth",label:e(l)("auth.group.jurisdiction")},{default:s(()=>[(u(),f(z,{ref_key:"treeRef",ref:g,key:a.treeKey,"default-checked-keys":a.defaultCheckedKeys,"default-expand-all":!0,"show-checkbox":"","node-key":"id",props:{children:"children",label:"title",class:N},data:a.menuRules},null,8,["default-checked-keys","props","data"]))]),_:1},8,["label"]),m(F,{label:e(l)("State"),modelValue:e(t).form.items.status,"onUpdate:modelValue":o[2]||(o[2]=i=>e(t).form.items.status=i),type:"radio",data:{content:{0:e(l)("Disable"),1:e(l)("Enable")},childrenAttr:{border:!0}}},null,8,["label","modelValue","data"])]),_:1},8,["model","label-position","label-width","rules"]))],6)]),_:1})),[[A,e(t).form.loading]])]),_:1},8,["model-value","onClose"])}}});const ie=M(ee,[["__scopeId","data-v-11e50e80"]]);export{ie as default};
