import{b,d as h,T as g,a as _}from"./index-BhJeeUme.js";import k from"./popupForm-BhT1KSvg.js";import{a0 as w}from"./index-HeYxHBW0.js";import{f as y,N as C,s as d,at as I,al as v,A as T,p as N,o as p,j as A,w as s,O as R,W as x,m as n}from"./vue-BMxP1YH6.js";import"./index-Con-2NqR.js";import"./index-OJstKbm-.js";import"./validate-BHZlFW4J.js";const E={class:"default-main ba-table-box"},P=y({name:"user/group",__name:"index",setup(G){const{t}=C(),i=d(),c=d(),e=new b(new w("/admin/user.Group/"),{column:[{type:"selection",align:"center",operator:!1},{label:t("Id"),prop:"id",align:"center",operator:"=",operatorPlaceholder:t("Id"),width:70},{label:t("user.group.Group name"),prop:"name",align:"center",operator:"LIKE",operatorPlaceholder:t("Fuzzy query")},{label:t("State"),prop:"status",align:"center",render:"tag",custom:{0:"danger",1:"success"},replaceValue:{0:t("Disable"),1:t("Enable")}},{label:t("Update time"),prop:"update_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:t("Create time"),prop:"create_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:t("Operate"),align:"center",width:"130",render:"buttons",buttons:h(["edit","delete"]),operator:!1}],dblClickNotEditColumn:[void 0]},{defaultItems:{status:"1"}},{onSubmit:({formEl:l,operate:r,items:a})=>{var a=I(a);a.rules=c.value.getCheckeds();for(const o in a)a[o]===null&&delete a[o];r=r.replace(r[0],r[0].toLowerCase());let m=()=>{e.form.submitLoading=!0,e.api.postData(r,a).then(o=>{var u;e.onTableHeaderAction("refresh",{}),e.form.submitLoading=!1,(u=e.form.operateIds)==null||u.shift(),e.form.operateIds.length>0?e.toggleForm("Edit",e.form.operateIds):e.toggleForm(),e.runAfter("onSubmit",{res:o})}).catch(()=>{e.form.submitLoading=!1})};return l?(e.form.ref=l,l.validate(o=>{o&&m()})):m(),!1}});return v("baTable",e),T(()=>{e.table.ref=i.value,e.mount(),e.getIndex()}),(l,r)=>{const f=N("el-alert");return p(),A("div",E,[s(e).table.remark?(p(),R(f,{key:0,class:"ba-table-alert",title:s(e).table.remark,type:"info","show-icon":""},null,8,["title"])):x("",!0),n(g,{buttons:["refresh","add","edit","delete","comSearch","quickSearch","columnDisplay"],"quick-search-placeholder":s(t)("Quick search placeholder",{fields:s(t)("user.group.GroupName")})},null,8,["quick-search-placeholder"]),n(_,{ref_key:"tableRef",ref:i},null,512),n(k,{ref_key:"formRef",ref:c},null,512)])}}});export{P as default};
