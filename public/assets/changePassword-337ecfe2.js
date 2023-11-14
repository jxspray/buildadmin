import{h as v,w as b,r as V,q as w,o as y,k as C,p as t,P as l,m as S,a9 as N,z as r,V as p,U as f}from"./vue-69ad5a16.js";import{w as $,b as I,C as L,a8 as U,_ as k}from"./index-32d6febb.js";import{b as u}from"./validate-4db1e214.js";import{F as i}from"./index-4042c46c.js";import"./index-afbe03c0.js";import"./index-f98c8d12.js";const q={class:"user-views"},x={class:"change-password"},R=v({__name:"changePassword",setup(B){const{t:s}=$(),P=I(),m=b(),e=V({formSubmitLoading:!1,form:{oldPassword:"",newPassword:"",confirmPassword:""},rules:{oldPassword:[u({name:"required",title:s("user.account.changePassword.Old password")})],newPassword:[u({name:"required",title:s("user.account.changePassword.New password")}),u({name:"password"})],confirmPassword:[u({name:"required",title:s("user.account.changePassword.Confirm new password")}),u({name:"password"}),{validator:(d,o,n)=>{(e.form.newPassword||e.form.confirmPassword)&&(e.form.newPassword==e.form.confirmPassword?n():n(new Error(s("user.account.changePassword.The duplicate password does not match the new password")))),n()},trigger:"blur"}]}}),c=()=>{m.value&&m.value.validate(d=>{d&&(e.formSubmitLoading=!0,U(e.form).then(o=>{e.formSubmitLoading=!1,o.code==1&&P.logout()}).catch(()=>{e.formSubmitLoading=!1}))})};return(d,o)=>{const n=w("el-button"),_=w("el-form-item"),g=w("el-form"),h=w("el-card");return y(),C("div",q,[t(h,{class:"user-views-card",shadow:"hover",header:r(s)("user.account.changePassword.Change Password")},{default:l(()=>[S("div",x,[t(g,{model:e.form,rules:e.rules,"label-position":"top",ref_key:"formRef",ref:m,onKeyup:o[5]||(o[5]=N(a=>c(),["enter"]))},{default:l(()=>[t(i,{label:r(s)("user.account.changePassword.Old password"),type:"password",modelValue:e.form.oldPassword,"onUpdate:modelValue":o[0]||(o[0]=a=>e.form.oldPassword=a),prop:"oldPassword","input-attr":{"show-password":!0},placeholder:r(s)("user.account.changePassword.Please enter your current password")},null,8,["label","modelValue","placeholder"]),t(i,{label:r(s)("user.account.changePassword.New password"),type:"password",modelValue:e.form.newPassword,"onUpdate:modelValue":o[1]||(o[1]=a=>e.form.newPassword=a),prop:"newPassword","input-attr":{"show-password":!0},placeholder:r(s)("Please input field",{field:r(s)("user.account.changePassword.New password")})},null,8,["label","modelValue","placeholder"]),t(i,{label:r(s)("user.account.changePassword.Confirm new password"),type:"password",modelValue:e.form.confirmPassword,"onUpdate:modelValue":o[2]||(o[2]=a=>e.form.confirmPassword=a),prop:"confirmPassword","input-attr":{"show-password":!0},placeholder:r(s)("Please input field",{field:r(s)("user.account.changePassword.Confirm new password")})},null,8,["label","modelValue","placeholder"]),t(_,{class:"submit-buttons"},{default:l(()=>[t(n,{onClick:o[3]||(o[3]=a=>r(L)(m.value))},{default:l(()=>[p(f(d.$t("Reset")),1)]),_:1}),t(n,{type:"primary",loading:e.formSubmitLoading,onClick:o[4]||(o[4]=a=>c())},{default:l(()=>[p(f(d.$t("Save")),1)]),_:1},8,["loading"])]),_:1})]),_:1},8,["model","rules"])])]),_:1},8,["header"])])}}});const z=k(R,[["__scopeId","data-v-c46cf517"]]);export{z as default};
