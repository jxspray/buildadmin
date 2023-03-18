import{d as B,y as C,C as N,w as $,a as p,c,b as n,T as L,s as q,R as b,Q as _,u as e,v as x,e as s,t as S,a4 as g,a3 as h,S as K,Y as R,ah as W,r as i,X as y}from"./vue-9a46e809.js";import{a as A}from"./index-ae07247d.js";import{f as E}from"./common-535f3731.js";import{k as M,j as O}from"./controllerUrls-941681c3.js";import{F as Q}from"./index-a7be6d6a.js";import{b as V}from"./validate-61c16ed0.js";import{_ as X}from"./_plugin-vue_export-helper-c27b6911.js";function Y(v){return E({url:M+"add",method:"get",params:{userId:v}})}const G={class:"title"},H=B({__name:"popupForm",setup(v){const{t}=A(),r=W("baTable"),w=C({user_id:[V({name:"required",message:t("Please select field",{field:t("user.moneyLog.User")})})],score:[V({name:"required",title:t("user.moneyLog.Change amount")}),{validator:(m,o,u)=>!o||parseInt(o)==0?u(new Error(t("Please enter the correct field",{field:t("user.moneyLog.Change amount")}))):u(),trigger:"blur"}],memo:[V({name:"required",title:t("user.moneyLog.remarks")})]}),f=N(),a=C({userInfo:{},after:0}),I=()=>{!r.form.items.user_id||parseInt(r.form.items.user_id)<=0||Y(r.form.items.user_id).then(m=>{a.userInfo=m.data.user,a.after=m.data.user.score})},U=m=>{if(!a.userInfo||typeof a.userInfo>"u"){a.after=0;return}let o=m==""?0:parseFloat(m);a.after=parseFloat(a.userInfo.score)+o};return $(()=>r.form.operate,m=>{m&&I()}),(m,o)=>{const u=i("el-input"),d=i("el-form-item"),F=i("el-form"),P=i("el-scrollbar"),k=i("el-button"),z=i("el-dialog"),D=y("drag"),T=y("zoom"),j=y("blur");return p(),c(z,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":!!e(r).form.operate,onClose:e(r).toggleForm},{header:n(()=>[L((p(),q("div",G,[b(_(e(r).form.operate?e(t)(e(r).form.operate):""),1)])),[[D,[".ba-operate-dialog",".el-dialog__header"]],[T,".ba-operate-dialog"]])]),footer:n(()=>[x("div",{style:S("width: calc(100% - "+e(r).form.labelWidth/1.8+"px)")},[s(k,{onClick:o[10]||(o[10]=l=>e(r).toggleForm(""))},{default:n(()=>[b(_(e(t)("Cancel")),1)]),_:1}),L((p(),c(k,{loading:e(r).form.submitLoading,onClick:o[11]||(o[11]=l=>e(r).onSubmit(f.value)),type:"primary"},{default:n(()=>[b(_(e(r).form.operateIds.length>1?e(t)("Save and edit next item"):e(t)("Save")),1)]),_:1},8,["loading"])),[[j]])],4)]),default:n(()=>[s(P,{class:"ba-table-form-scrollbar"},{default:n(()=>[x("div",{class:R(["ba-operate-form","ba-"+e(r).form.operate+"-form"]),style:S("width: calc(100% - "+e(r).form.labelWidth/2+"px)")},[e(r).form.loading?K("",!0):(p(),c(F,{key:0,ref_key:"formRef",ref:f,onKeyup:o[9]||(o[9]=g(l=>e(r).onSubmit(f.value),["enter"])),model:e(r).form.items,"label-position":"right","label-width":e(r).form.labelWidth+"px",rules:w},{default:n(()=>[s(Q,{type:"remoteSelect",prop:"user_id",label:e(t)("user.moneyLog.User ID"),modelValue:e(r).form.items.user_id,"onUpdate:modelValue":o[0]||(o[0]=l=>e(r).form.items.user_id=l),placeholder:e(t)("Click Select"),"input-attr":{pk:"user.id",field:"nickname_text","remote-url":e(O)+"index",onChange:I}},null,8,["label","modelValue","placeholder","input-attr"]),s(d,{label:e(t)("user.moneyLog.User name")},{default:n(()=>[s(u,{modelValue:a.userInfo.username,"onUpdate:modelValue":o[1]||(o[1]=l=>a.userInfo.username=l),disabled:""},null,8,["modelValue"])]),_:1},8,["label"]),s(d,{label:e(t)("user.moneyLog.User nickname")},{default:n(()=>[s(u,{modelValue:a.userInfo.nickname,"onUpdate:modelValue":o[2]||(o[2]=l=>a.userInfo.nickname=l),disabled:""},null,8,["modelValue"])]),_:1},8,["label"]),s(d,{label:e(t)("user.scoreLog.Current points")},{default:n(()=>[s(u,{modelValue:a.userInfo.score,"onUpdate:modelValue":o[3]||(o[3]=l=>a.userInfo.score=l),disabled:"",type:"number"},null,8,["modelValue"])]),_:1},8,["label"]),s(d,{prop:"score",label:e(t)("user.moneyLog.Change amount")},{default:n(()=>[s(u,{onInput:U,modelValue:e(r).form.items.score,"onUpdate:modelValue":o[4]||(o[4]=l=>e(r).form.items.score=l),type:"number",placeholder:e(t)("user.scoreLog.Please enter the change amount of points")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),s(d,{label:e(t)("user.scoreLog.Points after change")},{default:n(()=>[s(u,{modelValue:a.after,"onUpdate:modelValue":o[5]||(o[5]=l=>a.after=l),type:"number",disabled:""},null,8,["modelValue"])]),_:1},8,["label"]),s(d,{prop:"memo",label:e(t)("user.moneyLog.remarks")},{default:n(()=>[s(u,{onKeyup:[o[6]||(o[6]=g(h(()=>{},["stop"]),["enter"])),o[7]||(o[7]=g(h(l=>e(r).onSubmit(f.value),["ctrl"]),["enter"]))],modelValue:e(r).form.items.memo,"onUpdate:modelValue":o[8]||(o[8]=l=>e(r).form.items.memo=l),type:"textarea",placeholder:e(t)("user.scoreLog.Please enter change remarks / description")},null,8,["modelValue","placeholder"])]),_:1},8,["label"])]),_:1},8,["model","label-width","rules"]))],6)]),_:1})]),_:1},8,["model-value","onClose"])}}});const J=X(H,[["__scopeId","data-v-68565f47"]]),se=Object.freeze(Object.defineProperty({__proto__:null,default:J},Symbol.toStringTag,{value:"Module"}));export{J as P,Y as a,se as p};
