import{b as B,a8 as G,h as N,f as z,a9 as A,Z as R,_ as U}from"./index-HeYxHBW0.js";import{f as V,N as D,a0 as F,s as L,r as S,aw as E,A as M,ak as O,p as d,X as P,o as k,j as T,m as t,P as a,l as r,U as l,_ as j,O as q,w as o,V as i,n as X}from"./vue-BMxP1YH6.js";import{i as Z}from"./echarts-DnlKIcX7.js";const H={class:"user-views"},J={class:"card-header"},K={class:"overview-userinfo"},Q={class:"user-avatar"},W=["src"],Y={class:"user-avatar-icons"},x={class:"user-data"},ee={class:"welcome-words"},te=V({__name:"overview",setup(ae){const{t:p}=D(),v=F(),c=B(),f=L(),n=S({days:[],score:[],money:[],charts:[]}),b=()=>{const e=Z(f.value),s={grid:{top:10,right:0,bottom:20,left:50},xAxis:{data:n.days},yAxis:{},legend:{data:[p("Integral"),p("Balance")]},series:[{name:p("Integral"),data:n.score,type:"line",smooth:!0,show:!1,color:"#f56c6c",emphasis:{label:{show:!0}},areaStyle:{}},{name:p("Balance"),data:n.money,type:"line",smooth:!0,show:!1,color:"#409eff",emphasis:{label:{show:!0}},areaStyle:{opacity:.4}}]};e.setOption(s),n.charts.push(e)},_=()=>{X(()=>{for(const e in n.charts)n.charts[e].resize()})};return E(()=>{_()}),M(()=>{G().then(e=>{n.days=e.data.days,n.score=e.data.score,n.money=e.data.money,b()}),N(window,"resize",_)}),O(()=>{for(const e in n.charts)n.charts[e].dispose()}),(e,s)=>{const C=d("el-button"),h=d("Icon"),w=d("el-tooltip"),u=d("el-col"),y=d("el-link"),g=d("el-row"),$=d("el-card"),I=P("blur");return k(),T("div",H,[t($,{class:"user-views-card",shadow:"hover"},{header:a(()=>[r("div",J,[r("span",null,l(e.$t("user.account.overview.Account information")),1),j((k(),q(C,{onClick:s[0]||(s[0]=m=>o(v).push({name:"account/profile"})),type:"info",plain:""},{default:a(()=>[i(l(e.$t("user.account.overview.personal data")),1)]),_:1})),[[I]])])]),default:a(()=>[r("div",K,[r("div",Q,[r("img",{src:o(z)(o(c).avatar),alt:""},null,8,W),r("div",Y,[r("div",{onClick:s[1]||(s[1]=m=>o(v).push({name:"account/profile"})),class:"avatar-icon-item"},[t(w,{effect:"light",placement:"right",content:(o(c).mobile?e.$t("user.account.overview.Filled in"):e.$t("user.account.overview.Not filled in"))+e.$t("user.account.overview.mobile")},{default:a(()=>[t(h,{name:"fa fa-tablet",size:"16",color:o(c).mobile?"var(--el-color-primary)":"var(--el-text-color-secondary)"},null,8,["color"])]),_:1},8,["content"])]),r("div",{onClick:s[2]||(s[2]=m=>o(v).push({name:"account/profile"})),class:"avatar-icon-item"},[t(w,{effect:"light",placement:"right",content:(o(c).email?e.$t("user.account.overview.Filled in"):e.$t("user.account.overview.Not filled in"))+e.$t("user.account.overview.email")},{default:a(()=>[t(h,{name:"fa fa-envelope-square",size:"14",color:o(c).email?"var(--el-color-primary)":"var(--el-text-color-secondary)"},null,8,["color"])]),_:1},8,["content"])])])]),r("div",x,[r("div",ee,l(o(c).nickname+e.$t("utils.comma")+o(A)()),1),t(g,{class:"data-item"},{default:a(()=>[t(u,{span:4},{default:a(()=>[i(l(e.$t("Integral")),1)]),_:1}),t(u,{span:8},{default:a(()=>[t(y,{onClick:s[3]||(s[3]=m=>o(v).push({name:"account/integral"})),type:"primary"},{default:a(()=>[i(l(o(c).score),1)]),_:1})]),_:1}),t(u,{span:4},{default:a(()=>[i(l(e.$t("Balance")),1)]),_:1}),t(u,{span:8},{default:a(()=>[t(y,{onClick:s[4]||(s[4]=m=>o(v).push({name:"account/balance"})),type:"primary"},{default:a(()=>[i(l(o(c).money),1)]),_:1})]),_:1})]),_:1}),t(g,{class:"data-item"},{default:a(()=>[t(u,{class:"lastlogin title",span:4},{default:a(()=>[i(l(e.$t("user.account.overview.Last login")),1)]),_:1}),t(u,{class:"lastlogin value",span:8},{default:a(()=>[i(l(o(R)(o(c).last_login_time)),1)]),_:1}),t(u,{class:"lastip",span:4},{default:a(()=>[i(l(e.$t("user.account.overview.Last login IP")),1)]),_:1}),t(u,{class:"lastip",span:8},{default:a(()=>[i(l(o(c).last_login_ip),1)]),_:1})]),_:1})])])]),_:1}),t($,{class:"user-views-card",shadow:"hover",header:e.$t("user.account.overview.Growth statistics")},{default:a(()=>[r("div",{class:"account-growth",ref_key:"accountGrowthChartRef",ref:f},null,512)]),_:1},8,["header"])])}}}),re=U(te,[["__scopeId","data-v-ceccd0d9"]]);export{re as default};
