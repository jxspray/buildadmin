import{a2 as m,_}from"./index-h9hEbd9y.js";import{k as f}from"./store-NluHfbVR.js";import{a as h}from"./index-15s-llAr.js";import{f as w,r as v,p as n,o as i,j as c,l as a,U as t,m as p,P as k,Z as g,V as $,O as I}from"./vue-FrqQdkED.js";const y={class:"upload-install"},C={class:"tips"},S={class:"title"},U={class:"tip-item"},B={class:"tip-item"},T={class:"tip-item"},V={class:"el-upload__text"},b=w({__name:"uploadInstall",setup(D){const l=v({uploadState:"wait-file"}),u=e=>{if(!e||!e.raw)return;let s=new FormData;s.append("file",e.raw),m(s,{},!0).then(o=>{o.code==1&&f(o.data.file.url).then(d=>{l.uploadState="success",h(d.data.info.uid,0)}).catch(()=>{l.uploadState="wait-file"})})};return(e,s)=>{const o=n("Icon"),d=n("el-result"),r=n("el-upload");return i(),c("div",y,[a("div",C,[a("div",S,t(e.$t("module.Local upload warning")),1),a("div",U,"1. "+t(e.$t("module.The module can modify and add system files")),1),a("div",B,"2. "+t(e.$t("module.The module can execute sql commands and codes")),1),a("div",T,"3. "+t(e.$t("module.The module can install new front and rear dependencies")),1)]),p(r,{class:"upload-module","show-file-list":!1,accept:".zip",drag:"","auto-upload":!1,onChange:u},{default:k(()=>[l.uploadState=="wait-file"?(i(),c(g,{key:0},[p(o,{size:"50px",color:"#909399",name:"el-icon-UploadFilled"}),a("div",V,[$(t(e.$t("module.Drag the module package file here"))+" ",1),a("em",null,t(e.$t("module.Click me to upload")),1)])],64)):(i(),I(d,{key:1,icon:"success","sub-title":e.$t("module.Uploaded, installation is about to start, please wait")},null,8,["sub-title"]))]),_:1})])}}}),q=_(b,[["__scopeId","data-v-5ecde645"]]);export{q as default};
