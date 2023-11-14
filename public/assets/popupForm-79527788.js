import{h as B,w as L,ar as N,r as T,F as W,q as u,X as _,o as i,O as n,P as s,_ as v,k as Y,V as f,U as b,z as e,m as x,l as A,p as t,$ as j,a9 as w,W as k,a8 as F}from"./vue-69ad5a16.js";import{e as K,w as M,r as G,_ as R}from"./index-32d6febb.js";import{b as g,r as O}from"./validate-4db1e214.js";import{F as c}from"./index-4042c46c.js";import"./index-afbe03c0.js";import"./index-f98c8d12.js";const X={class:"title"},H=B({__name:"popupForm",setup(J){const U=K(),V=L(),l=N("baTable"),{t:o}=M(),P=T({username:[g({name:"required",title:o("user.user.User name")}),g({name:"account"})],nickname:[g({name:"required",title:o("user.user.nickname")})],email:[g({name:"email",title:o("user.user.email")})],mobile:[g({name:"mobile"})],password:[{validator:(p,r,m)=>{if(l.form.operate=="Add"){if(!r)return m(new Error(o("Please input field",{field:o("user.user.password")})))}else if(!r)return m();return O(r)?m():m(new Error(o("validate.Please enter the correct password")))},trigger:"blur"}]}),C=p=>{l.toggleForm(),G.push({name:p=="money"?"user/moneyLog":"user/scoreLog",query:{user_id:l.form.items.id}})};return W(()=>l.form.operate,p=>{P.password[0].required=p=="Add"}),(p,r)=>{const m=u("el-input"),d=u("el-form-item"),S=u("el-date-picker"),y=u("el-button"),h=u("el-form"),D=u("el-scrollbar"),E=u("el-dialog"),$=_("drag"),q=_("zoom"),z=_("loading"),I=_("blur");return i(),n(E,{class:"ba-operate-dialog","close-on-click-modal":!1,"destroy-on-close":!0,"model-value":["Add","Edit"].includes(e(l).form.operate),onClose:e(l).toggleForm},{header:s(()=>[v((i(),Y("div",X,[f(b(e(l).form.operate?e(o)(e(l).form.operate):""),1)])),[[$,[".ba-operate-dialog",".el-dialog__header"]],[q,".ba-operate-dialog"]])]),footer:s(()=>[x("div",{style:A("width: calc(100% - "+e(l).form.labelWidth/1.8+"px)")},[t(y,{onClick:r[18]||(r[18]=a=>e(l).toggleForm(""))},{default:s(()=>[f(b(e(o)("Cancel")),1)]),_:1}),v((i(),n(y,{loading:e(l).form.submitLoading,onClick:r[19]||(r[19]=a=>e(l).onSubmit(V.value)),type:"primary"},{default:s(()=>[f(b(e(l).form.operateIds&&e(l).form.operateIds.length>1?e(o)("Save and edit next item"):e(o)("Save")),1)]),_:1},8,["loading"])),[[I]])],4)]),default:s(()=>[v((i(),n(D,{class:"ba-table-form-scrollbar"},{default:s(()=>[x("div",{class:j(["ba-operate-form","ba-"+e(l).form.operate+"-form"]),style:A(e(U).layout.shrink?"":"width: calc(100% - "+e(l).form.labelWidth/2+"px)")},[e(l).form.loading?k("",!0):(i(),n(h,{key:0,ref_key:"formRef",ref:V,onKeyup:r[17]||(r[17]=w(a=>e(l).onSubmit(V.value),["enter"])),model:e(l).form.items,"label-position":e(U).layout.shrink?"top":"right","label-width":e(l).form.labelWidth+"px",rules:P},{default:s(()=>[t(d,{prop:"username",label:e(o)("user.user.User name")},{default:s(()=>[t(m,{modelValue:e(l).form.items.username,"onUpdate:modelValue":r[0]||(r[0]=a=>e(l).form.items.username=a),type:"string",placeholder:e(o)("Please input field",{field:e(o)("user.user.User name")+"("+e(o)("user.user.Login account")+")"})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),t(d,{prop:"nickname",label:e(o)("user.user.nickname")},{default:s(()=>[t(m,{modelValue:e(l).form.items.nickname,"onUpdate:modelValue":r[1]||(r[1]=a=>e(l).form.items.nickname=a),type:"string",placeholder:e(o)("Please input field",{field:e(o)("user.user.nickname")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),t(c,{type:"remoteSelect",label:e(o)("user.user.grouping"),modelValue:e(l).form.items.group_id,"onUpdate:modelValue":r[2]||(r[2]=a=>e(l).form.items.group_id=a),placeholder:e(o)("user.user.grouping"),"input-attr":{params:{isTree:!0,search:[{field:"status",val:"1",operator:"eq"}]},field:"name","remote-url":"/admin/user.Group/index"}},null,8,["label","modelValue","placeholder","input-attr"]),t(c,{label:e(o)("user.user.head portrait"),type:"image",modelValue:e(l).form.items.avatar,"onUpdate:modelValue":r[3]||(r[3]=a=>e(l).form.items.avatar=a)},null,8,["label","modelValue"]),t(d,{prop:"email",label:e(o)("user.user.email")},{default:s(()=>[t(m,{modelValue:e(l).form.items.email,"onUpdate:modelValue":r[4]||(r[4]=a=>e(l).form.items.email=a),type:"string",placeholder:e(o)("Please input field",{field:e(o)("user.user.email")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),t(d,{prop:"mobile",label:e(o)("user.user.mobile")},{default:s(()=>[t(m,{modelValue:e(l).form.items.mobile,"onUpdate:modelValue":r[5]||(r[5]=a=>e(l).form.items.mobile=a),type:"string",placeholder:e(o)("Please input field",{field:e(o)("user.user.mobile")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),t(c,{label:e(o)("user.user.Gender"),modelValue:e(l).form.items.gender,"onUpdate:modelValue":r[6]||(r[6]=a=>e(l).form.items.gender=a),type:"radio",data:{content:{0:e(o)("Unknown"),1:e(o)("user.user.male"),2:e(o)("user.user.female")},childrenAttr:{border:!0}}},null,8,["label","modelValue","data"]),t(d,{label:e(o)("user.user.birthday")},{default:s(()=>[t(S,{class:"w100","value-format":"YYYY-MM-DD",modelValue:e(l).form.items.birthday,"onUpdate:modelValue":r[7]||(r[7]=a=>e(l).form.items.birthday=a),type:"date",placeholder:e(o)("Please select field",{field:e(o)("user.user.birthday")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),e(l).form.operate=="Edit"?(i(),n(d,{key:0,label:e(o)("user.user.balance")},{default:s(()=>[t(m,{modelValue:e(l).form.items.money,"onUpdate:modelValue":r[9]||(r[9]=a=>e(l).form.items.money=a),readonly:""},{append:s(()=>[t(y,{onClick:r[8]||(r[8]=a=>C("money"))},{default:s(()=>[f(b(e(o)("user.user.Adjustment balance")),1)]),_:1})]),_:1},8,["modelValue"])]),_:1},8,["label"])):k("",!0),e(l).form.operate=="Edit"?(i(),n(d,{key:1,label:e(o)("user.user.integral")},{default:s(()=>[t(m,{modelValue:e(l).form.items.score,"onUpdate:modelValue":r[11]||(r[11]=a=>e(l).form.items.score=a),readonly:""},{append:s(()=>[t(y,{onClick:r[10]||(r[10]=a=>C("score"))},{default:s(()=>[f(b(e(o)("user.user.Adjust integral")),1)]),_:1})]),_:1},8,["modelValue"])]),_:1},8,["label"])):k("",!0),t(d,{prop:"password",label:e(o)("user.user.password")},{default:s(()=>[t(m,{modelValue:e(l).form.items.password,"onUpdate:modelValue":r[12]||(r[12]=a=>e(l).form.items.password=a),type:"password",placeholder:e(l).form.operate=="Add"?e(o)("Please input field",{field:e(o)("user.user.password")}):e(o)("user.user.Please leave blank if not modified")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),t(d,{prop:"motto",label:e(o)("user.user.Personal signature")},{default:s(()=>[t(m,{onKeyup:[r[13]||(r[13]=w(F(()=>{},["stop"]),["enter"])),r[14]||(r[14]=w(F(a=>e(l).onSubmit(V.value),["ctrl"]),["enter"]))],modelValue:e(l).form.items.motto,"onUpdate:modelValue":r[15]||(r[15]=a=>e(l).form.items.motto=a),type:"textarea",placeholder:e(o)("Please input field",{field:e(o)("user.user.Personal signature")})},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),t(c,{label:e(o)("State"),modelValue:e(l).form.items.status,"onUpdate:modelValue":r[16]||(r[16]=a=>e(l).form.items.status=a),type:"radio",data:{content:{disable:e(o)("Disable"),enable:e(o)("Enable")},childrenAttr:{border:!0}}},null,8,["label","modelValue","data"])]),_:1},8,["model","label-position","label-width","rules"]))],6)]),_:1})),[[z,e(l).form.loading]])]),_:1},8,["model-value","onClose"])}}});const ae=R(H,[["__scopeId","data-v-aa74243b"]]);export{ae as default};
