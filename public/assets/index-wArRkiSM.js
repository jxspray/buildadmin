import{d,b as s,T as u,a as m}from"./index-BhJeeUme.js";import{a0 as h,ae as b}from"./index-HeYxHBW0.js";import{f,N as g,ax as y,al as w,at as L,p as _,o as p,j as k,w as o,O as z,W as I,m as n}from"./vue-BMxP1YH6.js";import T from"./info-Dm3JYvn_.js";import"./index-Con-2NqR.js";const E={class:"default-main ba-table-box"},F=f({name:"auth/adminLog",__name:"index",setup(q){const{t:e}=g();let l=[{render:"tipButton",name:"info",title:"Info",text:"",type:"primary",icon:"fa fa-search-plus",class:"table-row-edit",disabledTip:!1,click:t=>{i(t)}}];l=y(l,d(["delete"]));const a=new s(new h("/admin/auth.AdminLog/"),{column:[{type:"selection",align:"center",operator:!1},{label:e("Id"),prop:"id",align:"center",operator:"=",operatorPlaceholder:e("Id"),width:70},{label:e("auth.adminLog.admin_id"),prop:"admin_id",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),width:70},{label:e("auth.adminLog.username"),prop:"username",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),width:160},{label:e("auth.adminLog.title"),prop:"title",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{show:!1,label:e("auth.adminLog.data"),prop:"data",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),showOverflowTooltip:!0},{label:e("auth.adminLog.url"),prop:"url",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),showOverflowTooltip:!0,render:"url"},{label:e("auth.adminLog.ip"),prop:"ip",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),render:"tag"},{label:e("auth.adminLog.useragent"),prop:"useragent",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),showOverflowTooltip:!0},{label:e("Create time"),prop:"create_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:e("Operate"),align:"center",width:"100",render:"buttons",buttons:l,operator:!1}],dblClickNotEditColumn:[void 0]},{},{onTableDblclick:({row:t})=>(i(t),!1)});a.mount(),a.getIndex(),w("baTable",a);const i=t=>{if(!t)return;let r=L(t);r.data=r.data?[{label:"点击展开",children:b(JSON.parse(r.data))}]:[],a.form.extend.info=r,a.form.operate="Info"};return(t,r)=>{const c=_("el-alert");return p(),k("div",E,[o(a).table.remark?(p(),z(c,{key:0,class:"ba-table-alert",title:o(a).table.remark,type:"info","show-icon":""},null,8,["title"])):I("",!0),n(u,{buttons:["refresh","delete","comSearch","quickSearch","columnDisplay"],"quick-search-placeholder":o(e)("Quick search placeholder",{fields:o(e)("auth.adminLog.title")})},null,8,["quick-search-placeholder"]),n(m),n(T)])}}});export{F as default};
