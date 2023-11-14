import{h as T,w as E,ar as L,r as R,q as m,X as b,o as n,O as p,P as o,_ as g,k as S,V as i,U as V,z as e,m as w,l as I,p as s,$ as j,a8 as k,a9 as x,Z as q,Y as O,W as X}from"./vue-69ad5a16.js";import{w as Y,_ as Z}from"./index-32d6febb.js";import{F as v}from"./index-4042c46c.js";import{b as f}from"./validate-4db1e214.js";import"./index-afbe03c0.js";import"./index-f98c8d12.js";const G={class:"title"},H={style:{width:"100%"}},J=T({__name:"popupForm",setup(Q){const c=E(),l=L("baTable"),{t}=Y(),P=()=>{l.form.items.groups.push({name:"",width:0,height:0})},z=C=>{l.form.items.groups.splice(C,1)},D=R({width:[f({name:"number",title:t("cms.slide.width")})],height:[f({name:"number",title:t("cms.slide.height")})],create_time:[f({name:"date",title:t("cms.slide.create_time")})],update_time:[f({name:"date",title:t("cms.slide.update_time")})],delete_time:[f({name:"date",title:t("cms.slide.delete_time")})]});return(C,a)=>{const d=m("el-col"),h=m("el-row"),y=m("el-input"),_=m("el-button"),$=m("el-form-item"),A=m("el-form"),B=m("el-scrollbar"),N=m("el-dialog"),W=b("drag"),K=b("zoom"),U=b("blur"),M=b("loading");return n(),p(N,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":["Add","Edit"].includes(e(l).form.operate),onClose:e(l).toggleForm,width:"50%"},{header:o(()=>[g((n(),S("div",G,[i(V(e(l).form.operate?e(t)(e(l).form.operate):""),1)])),[[W,[".ba-operate-dialog",".el-dialog__header"]],[K,".ba-operate-dialog"]])]),footer:o(()=>[w("div",{style:I("width: calc(100% - "+e(l).form.labelWidth/1.8+"px)")},[s(_,{onClick:a[8]||(a[8]=r=>e(l).toggleForm())},{default:o(()=>[i(V(e(t)("Cancel")),1)]),_:1}),g((n(),p(_,{loading:e(l).form.submitLoading,onClick:a[9]||(a[9]=r=>e(l).onSubmit(c.value)),type:"primary"},{default:o(()=>[i(V(e(l).form.operateIds&&e(l).form.operateIds.length>1?e(t)("Save and edit next item"):e(t)("Save")),1)]),_:1},8,["loading"])),[[U]])],4)]),default:o(()=>[g((n(),p(B,{class:"ba-table-form-scrollbar"},{default:o(()=>[w("div",{class:j(["ba-operate-form","ba-"+e(l).form.operate+"-form"]),style:I("width: calc(100% - "+e(l).form.labelWidth/2+"px)")},[e(l).form.loading?X("",!0):(n(),p(A,{key:0,ref_key:"formRef",ref:c,onSubmit:a[6]||(a[6]=k(()=>{},["prevent"])),onKeyup:a[7]||(a[7]=x(r=>e(l).onSubmit(c.value),["enter"])),model:e(l).form.items,"label-position":"right","label-width":e(l).form.labelWidth+"px",rules:D},{default:o(()=>[s(v,{label:e(t)("cms.slide.name"),type:"string",modelValue:e(l).form.items.name,"onUpdate:modelValue":a[0]||(a[0]=r=>e(l).form.items.name=r),prop:"name",placeholder:e(t)("Please input field",{field:e(t)("cms.slide.name")})},null,8,["label","modelValue","placeholder"]),s(v,{label:e(t)("cms.slide.remark"),type:"textarea",modelValue:e(l).form.items.remark,"onUpdate:modelValue":a[1]||(a[1]=r=>e(l).form.items.remark=r),prop:"remark","input-attr":{rows:3},onKeyup:[a[2]||(a[2]=x(k(()=>{},["stop"]),["enter"])),a[3]||(a[3]=x(k(r=>e(l).onSubmit(c.value),["ctrl"]),["enter"]))],placeholder:e(t)("Please input field",{field:e(t)("cms.slide.remark")})},null,8,["label","modelValue","placeholder"]),s(v,{label:e(t)("cms.slide.status"),type:"radio",modelValue:e(l).form.items.status,"onUpdate:modelValue":a[4]||(a[4]=r=>e(l).form.items.status=r),prop:"status",data:{content:{0:e(t)("cms.slide.status 0"),1:e(t)("cms.slide.status 1")}},placeholder:e(t)("Please select field",{field:e(t)("cms.slide.status")})},null,8,["label","modelValue","data","placeholder"]),s($,{label:e(t)("cms.slide.groups"),prop:"groups"},{default:o(()=>[w("div",H,[s(h,{gutter:10},{default:o(()=>[s(d,{span:6,class:"ba-array-name"},{default:o(()=>[i("分组名")]),_:1}),s(d,{span:6,class:"ba-array-width"},{default:o(()=>[i("宽")]),_:1}),s(d,{span:6,class:"ba-array-height"},{default:o(()=>[i("高")]),_:1})]),_:1}),(n(!0),S(q,null,O(e(l).form.items.groups,(r,F)=>(n(),p(h,{class:"ba-array-item",gutter:10,key:F},{default:o(()=>[s(d,{span:6},{default:o(()=>[s(y,{modelValue:r.name,"onUpdate:modelValue":u=>r.name=u},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),s(d,{span:6},{default:o(()=>[s(y,{modelValue:r.width,"onUpdate:modelValue":u=>r.width=u,modelModifiers:{number:!0},step:1},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),s(d,{span:6},{default:o(()=>[s(y,{modelValue:r.height,"onUpdate:modelValue":u=>r.height=u,modelModifiers:{number:!0},step:1},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),s(d,{span:4},{default:o(()=>[s(_,{onClick:u=>z(F),size:"small",icon:"el-icon-Delete",circle:""},null,8,["onClick"])]),_:2},1024)]),_:2},1024))),128)),s(h,{gutter:10},{default:o(()=>[s(d,{span:10,offset:8},{default:o(()=>[g((n(),p(_,{class:"ba-add-array-item",onClick:P,icon:"el-icon-Plus"},{default:o(()=>[i(V(e(t)("Add")),1)]),_:1})),[[U]])]),_:1})]),_:1})])]),_:1},8,["label"]),s(v,{label:e(t)("cms.slide.extends"),type:"array",modelValue:e(l).form.items.extends,"onUpdate:modelValue":a[5]||(a[5]=r=>e(l).form.items.extends=r),prop:"extends",placeholder:e(t)("Please input field",{field:e(t)("cms.slide.extends")})},null,8,["label","modelValue","placeholder"])]),_:1},8,["model","label-width","rules"]))],6)]),_:1})),[[M,e(l).form.loading]])]),_:1},8,["model-value","onClose"])}}});const re=Z(J,[["__scopeId","data-v-fbcf76aa"]]);export{re as default};
