import{o as f,j as C,f as ne,N as se,M as de,a0 as ue,s as B,r as T,A as ce,ab as me,p as s,m as r,P as l,w as t,l as M,U as u,a8 as W,O as _,V as p,W as v}from"./vue-BMxP1YH6.js";import{H as fe,F as pe}from"./footer-Dvwp4pUM.js";import{_ as j,b as ge,u as be,a as we,v as _e,h as ve,A as E,B as he,C as ye,D as A,E as K}from"./index-HeYxHBW0.js";import{b as m,v as Ve}from"./validate-BHZlFW4J.js";import{c as z}from"./index-Cmis-gAw.js";import"./darkSwitch-CNSoJAOO.js";import"./router-CX7BRVjm.js";import"./useDark-DBjpfraw.js";function Ce(){return new Promise(P=>P(!1))}const Pe={},ke={class:"login-footer-buried-point"};function Re(P,k){return f(),C("div",ke)}const Fe=j(Pe,[["render",Re]]),Te={class:"login"},ze={key:0,class:"login-box"},xe={class:"login-title"},Ie={key:4,class:"form-footer"},Se={class:"retrieve-password-form"},Le=ne({__name:"login",setup(P){let k;const{t:a}=se(),x=de(),H=ue(),O=ge(),G=be(),J=we(),h=B(),y=B(),e=T({form:{tab:"login",email:"",mobile:"",username:"",password:"",captcha:"",keep:!1,captchaId:_e(),captchaInfo:"",registerType:"email"},formLoading:!1,showRetrievePasswordDialog:!1,retrievePasswordForm:{type:"email",account:"",captcha:"",password:""},dialogWidth:36,accountVerificationType:[],codeSendCountdown:0,submitRetrieveLoading:!1,sendCaptchaLoading:!1,to:x.query.to}),Q=T({email:[m({name:"required",title:a("user.login.email")}),m({name:"email",title:a("user.login.email")})],username:[m({name:"required",title:a("user.login.User name")}),{validator:(i,o,d)=>{if(e.form.tab=="register")return Ve(i,o,d);d()},trigger:"blur"}],password:[m({name:"required",title:a("user.login.password")}),m({name:"password"})],mobile:[m({name:"required",title:a("user.login.mobile")}),m({name:"mobile"})],captcha:[m({name:"required",title:a("user.login.Verification Code")})]}),X=T({account:[m({name:"required",title:a("user.login.Account name")})],captcha:[m({name:"required",title:a("user.login.Verification Code")})],password:[m({name:"required",title:a("user.login.password")}),m({name:"password"})]}),I=()=>{let i=document.documentElement.clientWidth,o=36;i<=790?o=92:i<=910?o=56:i<=1260&&(o=46),e.dialogWidth=o},S=()=>{var i;(i=h.value)==null||i.validate(o=>{o&&(e.form.tab=="login"?z(e.form.captchaId,d=>L(d)):L())})},L=(i="")=>{e.formLoading=!0,e.form.captchaInfo=i,E("post",e.form).then(o=>{if(O.dataFill(o.data.userInfo),e.to)return location.href=e.to;H.push({path:o.data.routePath})}).finally(()=>{e.formLoading=!1})},U=()=>{y.value&&y.value.validate(i=>{i&&(e.submitRetrieveLoading=!0,he(e.retrievePasswordForm).then(o=>{e.submitRetrieveLoading=!1,o.code==1&&(e.showRetrievePasswordDialog=!1,R(),ye(y.value))}).catch(()=>{e.submitRetrieveLoading=!1}))})},Y=()=>{e.codeSendCountdown>0||h.value.validateField([e.form.registerType,"username","password"]).then(i=>{i&&z(e.form.captchaId,o=>Z(o))})},Z=i=>{e.sendCaptchaLoading=!0,(e.form.registerType=="email"?A:K)(e.form[e.form.registerType],"user_register",{captchaInfo:i,captchaId:e.form.captchaId}).then(d=>{d.code==1&&D(60)}).finally(()=>{e.sendCaptchaLoading=!1})},ee=()=>{e.codeSendCountdown>0||y.value.validateField("account").then(i=>{i&&z(e.form.captchaId,o=>oe(o))})},oe=i=>{e.sendCaptchaLoading=!0,(e.retrievePasswordForm.type=="email"?A:K)(e.retrievePasswordForm.account,"user_retrieve_pwd",{captchaInfo:i,captchaId:e.form.captchaId}).then(d=>{d.code==1&&D(60)}).finally(()=>{e.sendCaptchaLoading=!1})},q=(i=void 0,o)=>{e.form.tab=o,o=="register"&&(e.form.username=""),i&&i.clearValidate()},D=i=>{e.codeSendCountdown=i,k=window.setInterval(()=>{e.codeSendCountdown--,e.codeSendCountdown<=0&&R()},1e3)},R=()=>{e.codeSendCountdown=0,clearInterval(k)};return ce(async()=>{await Ce()||(I(),ve(window,"resize",I),E("get").then(i=>{e.accountVerificationType=i.data.accountVerificationType,e.retrievePasswordForm.type=i.data.accountVerificationType.length>0?i.data.accountVerificationType[0]:""}),x.query.type=="register"&&(e.form.tab="register"))}),me(()=>{e.codeSendCountdown=0,R()}),(i,o)=>{const d=s("el-radio"),N=s("el-radio-group"),c=s("el-form-item"),g=s("Icon"),b=s("el-input"),V=s("el-col"),w=s("el-button"),F=s("el-row"),ae=s("el-checkbox"),$=s("el-form"),re=s("el-alert"),le=s("el-main"),te=s("el-container"),ie=s("el-dialog");return f(),C("div",Te,[r(te,{class:"is-vertical"},{default:l(()=>[r(fe),r(le,{class:"frontend-footer-brother"},{default:l(()=>[r(F,{justify:"center"},{default:l(()=>[r(V,{span:16,xs:24},{default:l(()=>[t(J).state.open?(f(),C("div",ze,[M("div",xe,u(t(a)("user.login."+e.form.tab)+t(a)("user.login.reach")+t(G).siteName),1),r($,{ref_key:"formRef",ref:h,onKeyup:W(S,["enter"]),rules:Q,model:e.form},{default:l(()=>[e.form.tab=="register"?(f(),_(c,{key:0},{default:l(()=>[r(N,{size:"large",modelValue:e.form.registerType,"onUpdate:modelValue":o[0]||(o[0]=n=>e.form.registerType=n)},{default:l(()=>[r(d,{class:"register-verification-radio",label:"email",disabled:!e.accountVerificationType.includes("email"),border:""},{default:l(()=>[p(u(t(a)("user.login.Via email")+t(a)("user.login.register")),1)]),_:1},8,["disabled"]),r(d,{class:"register-verification-radio",label:"mobile",disabled:!e.accountVerificationType.includes("mobile"),border:""},{default:l(()=>[p(u(t(a)("user.login.Via mobile number")+t(a)("user.login.register")),1)]),_:1},8,["disabled"])]),_:1},8,["modelValue"])]),_:1})):v("",!0),r(c,{prop:"username"},{default:l(()=>[r(b,{modelValue:e.form.username,"onUpdate:modelValue":o[1]||(o[1]=n=>e.form.username=n),placeholder:e.form.tab=="register"?t(a)("Please input field",{field:t(a)("user.login.User name")}):t(a)("Please input field",{field:t(a)("user.login.account")}),clearable:!0,size:"large"},{prefix:l(()=>[r(g,{name:"fa fa-user",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1}),r(c,{prop:"password"},{default:l(()=>[r(b,{modelValue:e.form.password,"onUpdate:modelValue":o[2]||(o[2]=n=>e.form.password=n),placeholder:t(a)("Please input field",{field:t(a)("user.login.password")}),type:"password","show-password":"",size:"large"},{prefix:l(()=>[r(g,{name:"fa fa-unlock-alt",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1}),e.form.tab=="register"&&e.form.registerType=="mobile"?(f(),_(c,{key:1,prop:"mobile"},{default:l(()=>[r(b,{modelValue:e.form.mobile,"onUpdate:modelValue":o[3]||(o[3]=n=>e.form.mobile=n),placeholder:t(a)("Please input field",{field:t(a)("user.login.mobile")}),clearable:!0,size:"large"},{prefix:l(()=>[r(g,{name:"fa fa-tablet",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1})):v("",!0),e.form.tab=="register"&&e.form.registerType=="email"?(f(),_(c,{key:2,prop:"email"},{default:l(()=>[r(b,{modelValue:e.form.email,"onUpdate:modelValue":o[4]||(o[4]=n=>e.form.email=n),placeholder:t(a)("Please input field",{field:t(a)("user.login.email")}),clearable:!0,size:"large"},{prefix:l(()=>[r(g,{name:"fa fa-envelope",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1})):v("",!0),e.form.tab=="register"?(f(),_(c,{key:3,prop:"captcha"},{default:l(()=>[r(F,{class:"w100"},{default:l(()=>[r(V,{span:16},{default:l(()=>[r(b,{size:"large",modelValue:e.form.captcha,"onUpdate:modelValue":o[5]||(o[5]=n=>e.form.captcha=n),placeholder:t(a)("Please input field",{field:t(a)("user.login.Verification Code")}),autocomplete:"off"},{prefix:l(()=>[r(g,{name:"fa fa-ellipsis-h",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1}),r(V,{class:"captcha-box",span:8},{default:l(()=>[r(w,{size:"large",onClick:Y,loading:e.sendCaptchaLoading,disabled:!(e.codeSendCountdown<=0),type:"primary"},{default:l(()=>[p(u(e.codeSendCountdown<=0?t(a)("user.login.send"):e.codeSendCountdown+t(a)("user.login.seconds")),1)]),_:1},8,["loading","disabled"])]),_:1})]),_:1})]),_:1})):v("",!0),e.form.tab!="register"?(f(),C("div",Ie,[r(ae,{modelValue:e.form.keep,"onUpdate:modelValue":o[6]||(o[6]=n=>e.form.keep=n),label:t(a)("user.login.Remember me"),size:"default"},null,8,["modelValue","label"]),e.accountVerificationType.length>0?(f(),C("div",{key:0,onClick:o[7]||(o[7]=n=>e.showRetrievePasswordDialog=!0),class:"forgot-password"},u(t(a)("user.login.Forgot your password?")),1)):v("",!0)])):v("",!0),r(c,{class:"form-buttons"},{default:l(()=>[r(w,{class:"login-btn",onClick:S,loading:e.formLoading,round:"",type:"primary",size:"large"},{default:l(()=>[p(u(t(a)("user.login."+e.form.tab)),1)]),_:1},8,["loading"]),e.form.tab=="register"?(f(),_(w,{key:0,onClick:o[8]||(o[8]=n=>q(h.value,"login")),round:"",plain:"",type:"info",size:"large"},{default:l(()=>[p(u(t(a)("user.login.Back to login")),1)]),_:1})):(f(),_(w,{key:1,onClick:o[9]||(o[9]=n=>q(h.value,"register")),round:"",plain:"",type:"info",size:"large"},{default:l(()=>[p(u(t(a)("user.login.No account yet? Click Register")),1)]),_:1}))]),_:1}),r(Fe)]),_:1},8,["rules","model"])])):(f(),_(re,{key:1,center:!0,title:i.$t("Member center disabled"),type:"error"},null,8,["title"]))]),_:1})]),_:1})]),_:1}),r(pe)]),_:1}),r(ie,{"close-on-click-modal":!1,"close-on-press-escape":!1,modelValue:e.showRetrievePasswordDialog,"onUpdate:modelValue":o[17]||(o[17]=n=>e.showRetrievePasswordDialog=n),title:t(a)("user.login.Retrieve password"),width:e.dialogWidth+"%",draggable:!0},{default:l(()=>[M("div",Se,[r($,{ref_key:"retrieveFormRef",ref:y,onKeyup:o[16]||(o[16]=W(n=>U(),["enter"])),rules:X,model:e.retrievePasswordForm,"label-width":100},{default:l(()=>[r(c,{label:t(a)("user.login.Retrieval method")},{default:l(()=>[r(N,{modelValue:e.retrievePasswordForm.type,"onUpdate:modelValue":o[10]||(o[10]=n=>e.retrievePasswordForm.type=n)},{default:l(()=>[r(d,{label:"email",disabled:!e.accountVerificationType.includes("email"),border:""},{default:l(()=>[p(u(t(a)("user.login.Via email")),1)]),_:1},8,["disabled"]),r(d,{label:"mobile",disabled:!e.accountVerificationType.includes("mobile"),border:""},{default:l(()=>[p(u(t(a)("user.login.Via mobile number")),1)]),_:1},8,["disabled"])]),_:1},8,["modelValue"])]),_:1},8,["label"]),r(c,{prop:"account",label:e.retrievePasswordForm.type=="email"?t(a)("user.login.email"):t(a)("user.login.mobile")},{default:l(()=>[r(b,{modelValue:e.retrievePasswordForm.account,"onUpdate:modelValue":o[11]||(o[11]=n=>e.retrievePasswordForm.account=n),placeholder:t(a)("Please input field",{field:e.retrievePasswordForm.type=="email"?t(a)("user.login.email"):t(a)("user.login.mobile")}),clearable:!0},{prefix:l(()=>[r(g,{name:"fa fa-user",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1},8,["label"]),r(c,{prop:"captcha",label:t(a)("user.login.Verification Code")},{default:l(()=>[r(F,{class:"w100"},{default:l(()=>[r(V,{span:16},{default:l(()=>[r(b,{modelValue:e.retrievePasswordForm.captcha,"onUpdate:modelValue":o[12]||(o[12]=n=>e.retrievePasswordForm.captcha=n),placeholder:t(a)("Please input field",{field:t(a)("user.login.Verification Code")}),autocomplete:"off"},{prefix:l(()=>[r(g,{name:"fa fa-ellipsis-h",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1}),r(V,{class:"captcha-box",span:8},{default:l(()=>[r(w,{onClick:ee,loading:e.sendCaptchaLoading,disabled:!(e.codeSendCountdown<=0),type:"primary"},{default:l(()=>[p(u(e.codeSendCountdown<=0?t(a)("user.login.send"):e.codeSendCountdown+t(a)("user.login.seconds")),1)]),_:1},8,["loading","disabled"])]),_:1})]),_:1})]),_:1},8,["label"]),r(c,{prop:"password",label:t(a)("user.login.New password")},{default:l(()=>[r(b,{modelValue:e.retrievePasswordForm.password,"onUpdate:modelValue":o[13]||(o[13]=n=>e.retrievePasswordForm.password=n),placeholder:t(a)("Please input field",{field:t(a)("user.login.New password")}),"show-password":""},{prefix:l(()=>[r(g,{name:"fa fa-unlock-alt",size:"16",color:"var(--el-input-icon-color)"})]),_:1},8,["modelValue","placeholder"])]),_:1},8,["label"]),r(c,null,{default:l(()=>[r(w,{onClick:o[14]||(o[14]=n=>e.showRetrievePasswordDialog=!1)},{default:l(()=>[p(u(t(a)("Cancel")),1)]),_:1}),r(w,{loading:e.submitRetrieveLoading,onClick:o[15]||(o[15]=n=>U()),type:"primary"},{default:l(()=>[p(u(t(a)("user.login.second")),1)]),_:1},8,["loading"])]),_:1})]),_:1},8,["rules","model"])])]),_:1},8,["modelValue","title","width"])])}}}),Ee=j(Le,[["__scopeId","data-v-6c990a87"]]);export{Ee as default};
