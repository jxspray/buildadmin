import{d as j,y as k,C as M,w as N,a as p,c as b,b as s,T as x,s as $,R as _,Q as g,u as e,v as L,e as n,t as h,a4 as c,a3 as F,S as q,Y as K,ah as R,r as i,X as y}from"./vue-9a46e809.js";import{a as W}from"./index-ae07247d.js";import{f as A}from"./common-535f3731.js";import{i as E,j as O}from"./controllerUrls-941681c3.js";import{F as Q}from"./index-a7be6d6a.js";import{b as V}from"./validate-61c16ed0.js";import{_ as X}from"./_plugin-vue_export-helper-c27b6911.js";function Y(v){return A({url:E+"add",method:"get",params:{userId:v}})}const G={class:"title"},H=j({__name:"popupForm",setup(v){const{t}=W(),l=R("baTable"),w=k({user_id:[V({name:"required",message:t("Please select field",{field:t("user.moneyLog.User")})})],money:[V({name:"required",title:t("user.moneyLog.Change amount")}),{validator:(m,o,u)=>!o||parseFloat(o)==0?u(new Error(t("Please enter the correct field",{field:t("user.moneyLog.Change amount")}))):u(),trigger:"blur"}],memo:[V({name:"required",title:t("user.moneyLog.remarks")})]}),f=M(),a=k({userInfo:{},after:0}),I=()=>{!l.form.items.user_id||parseInt(l.form.items.user_id)<=0||Y(l.form.items.user_id).then(m=>{a.userInfo=m.data.user,a.after=m.data.user.money})},S=m=>{if(!a.userInfo||typeof a.userInfo>"u"){a.after=0;return}let o=m==""?0:parseFloat(m);a.after=parseFloat((parseFloat(a.userInfo.money)+o).toFixed(2))};return N(()=>l.form.operate,m=>{m&&I()}),(m,o)=>{const u=i("el-input"),d=i("el-form-item"),U=i("el-form"),P=i("el-scrollbar"),C=i("el-button"),z=i("el-dialog"),B=y("drag"),D=y("zoom"),T=y("blur");return p(),b(z,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":!!e(l).form.operate,onClose:e(l).toggleForm},{header:s(()=>[x((p(),$("div",G,[_(g(e(l).form.operate?e(t)(e(l).form.operate):""),1)])),[[B,[".ba-operate-dialog",".el-dialog__header"]],[D,".ba-operate-dialog"]])]),footer:s(()=>[L("div",{style:h("width: calc(100% - "+e(l).form.labelWidth/1.8+"px)")},[n(C,{onClick:o[10]||(o[10]=r=>e(l).toggleForm(""))},{default:s(()=>[_(g(e(t)("Cancel")),1)]),_:1}),x((p(),b(C,{loading:e(l).form.submitLoading,onClick:o[11]||(o[11]=r=>e(l).onSubmit(f.value)),type:"primary"},{default:s(()=>[_(g(e(l).form.operateIds.length>1?e(t)("Save and edit next item"):e(t)("Save")),1)]),_:1},8,["loading"])),[[T]])],4)]),default:s(()=>[n(P,{class:"ba-table-form-scrollbar"},{default:s(()=>[L("div",{class:K(["ba-operate-form","ba-"+e(l).form.operate+"-form"]),style:h("width: calc(100% - "+e(l).form.labelWidth/2+"px)")},[e(l).form.loading?q("",!0):(p(),b(U,{key:0,ref_key:"formRef",ref:f,onKeyup:o[9]||(o[9]=c(r=>e(l).onSubmit(f.value),["enter"])),model:e(l).form.items,"label-position":"right","label-width":e(l).form.labelWidth+"px",rules:w},{default:s(()=>[n(Q,{type:"remoteSelect",prop:"user_id",label:e(t)("user.moneyLog.User ID"),modelValue:e(l).form.items.user_id,"onUpdate:modelValue":o[0]||(o[0]=r=>e(l).form.items.user_id=r),placeholder:e(t)("Click Select"),"input-attr":{pk:"user.id",field:"nickname_text","remote-url":e(O)+"index",onChange:I}},null,8,["label","modelValue","placeholder","input-attr"]),n(d,{label:e(t)("user.moneyLog.User name")},{default:s(()=>[n(u,{modelValue:a.userInfo.username,"onUpdate:modelValue":o[1]||(o[1]=r=>a.userInfo.username=r),disabled:""},null,8,["modelValue"])]),_:1},8,["label"]),n(d,{label:e(t)("user.moneyLog.User nickname")},{default:s(()=>[n(u,{modelValue:a.userInfo.nickname,"onUpdate:modelValue":o[2]||(o[2]=r=>a.userInfo.nickname=r),disabled:""},null,8,["modelValue"])]),_:1},8,["label"]),n(d,{label:e(t)("user.moneyLog.Current balance")},{default:s(()=>[n(u,{modelValue:a.userInfo.money,"onUpdate:modelValue":o[3]||(o[3]=r=>a.userInfo.money=r),disabled:"",type:"number"},null,8,["modelValue"])]),_:1},8,["label"]),n(d,{prop:"money",label:e(t)("user.moneyLog.Change amount")},{default:s(()=>[n(u,{onInput:S,modelValue:e(l).form.items.money,"onUpdate:modelValue":o[4]||(o[4]=r=>e(l).form.items.money=r),type:"number",placeholder:e(t)("user.moneyLog.Please enter the balance change amount")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),n(d,{label:e(t)("user.moneyLog.Balance after change")},{default:s(()=>[n(u,{modelValue:a.after,"onUpdate:modelValue":o[5]||(o[5]=r=>a.after=r),type:"number",disabled:""},null,8,["modelValue"])]),_:1},8,["label"]),n(d,{prop:"memo",label:e(t)("user.moneyLog.remarks")},{default:s(()=>[n(u,{onKeyup:[o[6]||(o[6]=c(F(()=>{},["stop"]),["enter"])),o[7]||(o[7]=c(F(r=>e(l).onSubmit(f.value),["ctrl"]),["enter"]))],modelValue:e(l).form.items.memo,"onUpdate:modelValue":o[8]||(o[8]=r=>e(l).form.items.memo=r),type:"textarea",placeholder:e(t)("user.moneyLog.Please enter change remarks / description")},null,8,["modelValue","placeholder"])]),_:1},8,["label"])]),_:1},8,["model","label-width","rules"]))],6)]),_:1})]),_:1},8,["model-value","onClose"])}}});const J=X(H,[["__scopeId","data-v-9423f746"]]),ne=Object.freeze(Object.defineProperty({__proto__:null,default:J},Symbol.toStringTag,{value:"Module"}));export{J as P,Y as a,ne as p};
