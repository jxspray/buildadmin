import{b as s,d as u,T as p,a as c}from"./index-BhJeeUme.js";import i from"./popupForm-TJGifthY.js";import{a0 as d}from"./index-HeYxHBW0.js";import{f as m,N as b,s as g,al as f,p as h,o as l,j as _,w as a,O as k,W as y,m as t}from"./vue-BMxP1YH6.js";import"./index-Con-2NqR.js";import"./validate-BHZlFW4J.js";import"./index-OJstKbm-.js";const I={class:"default-main ba-table-box"},v=m({name:"user/user",__name:"index",setup(z){const{t:e}=b(),o=g(),r=new s(new d("/admin/user.User/"),{column:[{type:"selection",align:"center",operator:!1},{label:e("Id"),prop:"id",align:"center",operator:"=",operatorPlaceholder:e("Id"),width:70},{label:e("user.user.User name"),prop:"username",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("user.user.nickname"),prop:"nickname",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("user.user.grouping"),prop:"group.name",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),render:"tag"},{label:e("user.user.head portrait"),prop:"avatar",align:"center",render:"image",operator:!1},{label:e("user.user.Gender"),prop:"gender",align:"center",render:"tag",custom:{0:"info",1:"",2:"success"},replaceValue:{0:e("Unknown"),1:e("user.user.male"),2:e("user.user.female")}},{label:e("user.user.mobile"),prop:"mobile",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("user.user.Last login IP"),prop:"last_login_ip",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),render:"tag"},{label:e("user.user.Last login"),prop:"last_login_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:e("Create time"),prop:"create_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:e("State"),prop:"status",align:"center",render:"tag",custom:{disable:"danger",enable:"success"},replaceValue:{disable:e("Disable"),enable:e("Enable")}},{label:e("Operate"),align:"center",width:"100",render:"buttons",buttons:u(["edit","delete"]),operator:!1}],dblClickNotEditColumn:[void 0]},{defaultItems:{gender:0,money:"0",score:"0",status:"enable"}});return r.mount(),r.getIndex(),f("baTable",r),(E,w)=>{const n=h("el-alert");return l(),_("div",I,[a(r).table.remark?(l(),k(n,{key:0,class:"ba-table-alert",title:a(r).table.remark,type:"info","show-icon":""},null,8,["title"])):y("",!0),t(p,{buttons:["refresh","add","edit","delete","comSearch","quickSearch","columnDisplay"],"quick-search-placeholder":a(e)("Quick search placeholder",{fields:a(e)("user.user.User name")+"/"+a(e)("user.user.nickname")})},null,8,["quick-search-placeholder"]),t(c,{ref_key:"tableRef",ref:o},null,512),t(i)])}}});export{v as default};
