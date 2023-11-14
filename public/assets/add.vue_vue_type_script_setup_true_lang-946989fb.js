import{h as Ae,r as _,o as s,k as Pe,O as f,z as u,W as V,a9 as M,a8 as z,w as Me,q as A,X as B,P as b,_ as Te,V as O,U as R,m as Ee,l as De,p as h}from"./vue-69ad5a16.js";import{F as c}from"./index-4042c46c.js";import{c as Ie,b as x}from"./validate-4db1e214.js";import{c as q,i as Ue,e as _e,w as qe}from"./index-32d6febb.js";import{i as P}from"./index-afbe03c0.js";const k="/admin/routine.Config/",S=new Map([["index",k+"index"],["add",k+"add"],["edit",k+"edit"],["del",k+"del"],["sendTestMail",k+"sendTestMail"]]);function Fe(){return q({url:S.get("index"),method:"get"})}function Se(g,y){return q({url:S.get(g),method:"post",data:y},{showSuccessMessage:!0})}function Le(g){return q({url:S.get("del"),method:"DELETE",params:{ids:g}},{showSuccessMessage:!0})}function $e(g,y){return q({url:S.get("sendTestMail"),method:"POST",data:Object.assign({},g,{testMail:y})},{showSuccessMessage:!0})}const Ke=Ae({__name:"createData",props:{dataTitle:{default:Ue.global.t("utils.Var")},modelValue:{default:()=>({name:"",title:"",type:"",tip:"",rule:[],extend:"",dict:"",inputExtend:""})},options:{},excludeInputTypes:{default:()=>[]},excludeValidatorRule:{default:()=>[]}},emits:["update:modelValue"],setup(g,{emit:y}){var v,d,C,T,w,E,D,I,U,p,W,F,L,$,G,j,X,H,J,Q,Y,Z,ee,te,le,ae,oe,ie,ne,ue,de,se;const t=g,{t:o}=Ue.global,i=["radio","checkbox","select","selects"],e=_({name:{show:((d=(v=t.options)==null?void 0:v.name)==null?void 0:d.show)!==!1,value:t.modelValue.name,title:((T=(C=t.options)==null?void 0:C.name)==null?void 0:T.title)??t.dataTitle+o("utils.Name")},title:{show:((E=(w=t.options)==null?void 0:w.title)==null?void 0:E.show)!==!1,value:t.modelValue.title,title:((I=(D=t.options)==null?void 0:D.title)==null?void 0:I.title)??t.dataTitle+o("utils.Title")},type:{show:((p=(U=t.options)==null?void 0:U.type)==null?void 0:p.show)!==!1,value:t.modelValue.type,title:((F=(W=t.options)==null?void 0:W.type)==null?void 0:F.title)??t.dataTitle+o("utils.type")},tip:{show:(($=(L=t.options)==null?void 0:L.tip)==null?void 0:$.show)!==!1,value:t.modelValue.tip,title:((j=(G=t.options)==null?void 0:G.tip)==null?void 0:j.title)??o("utils.Tip")},rule:{show:((H=(X=t.options)==null?void 0:X.rule)==null?void 0:H.show)!==!1,value:t.modelValue.rule,title:((Q=(J=t.options)==null?void 0:J.rule)==null?void 0:Q.title)??o("utils.Rule")},extend:{show:((Z=(Y=t.options)==null?void 0:Y.extend)==null?void 0:Z.show)!==!1,value:t.modelValue.extend,title:((te=(ee=t.options)==null?void 0:ee.extend)==null?void 0:te.title)??"FormItem "+o("utils.Extend")},dict:{show:((ae=(le=t.options)==null?void 0:le.dict)==null?void 0:ae.show)!==!1,value:t.modelValue.dict,title:((ie=(oe=t.options)==null?void 0:oe.dict)==null?void 0:ie.title)??o("utils.Dict")},inputExtend:{show:((ue=(ne=t.options)==null?void 0:ne.inputExtend)==null?void 0:ue.show)!==!1,value:t.modelValue.inputExtend,title:((se=(de=t.options)==null?void 0:de.inputExtend)==null?void 0:se.title)??"Input "+o("utils.Extend")}}),a=_({validators:{},inputTypes:{}}),r=()=>{y("update:modelValue",{name:e.name.value??"",title:e.title.value??"",type:e.type.value??"",tip:e.tip.value??"",rule:e.rule.value??[],extend:e.extend.value??"",dict:i.includes(e.type.value??"")?e.dict.value??"":"",inputExtend:e.inputExtend.value??""})};return(()=>{let N={};for(const m in P)t.excludeInputTypes.includes(P[m])||(N[P[m]]=P[m]);a.inputTypes=N;let l={};for(const m in Ie)t.excludeValidatorRule.includes(m)||(l[m]=Ie[m]);a.validators=l,r()})(),(N,l)=>{var m,re,pe,me,fe,ce,ge,ye,Ve,ve,be,he,xe,we,ke,Ce;return s(),Pe("div",null,[e.name.show?(s(),f(c,{key:0,label:e.name.title,type:"string",modelValue:e.name.value,"onUpdate:modelValue":l[0]||(l[0]=n=>e.name.value=n),placeholder:u(o)("Please input field",{field:e.name.title}),"input-attr":{onChange:r,...(re=(m=t.options)==null?void 0:m.name)==null?void 0:re.inputAttr},prop:"name"},null,8,["label","modelValue","placeholder","input-attr"])):V("",!0),e.title.show?(s(),f(c,{key:1,label:e.title.title,type:"string",modelValue:e.title.value,"onUpdate:modelValue":l[1]||(l[1]=n=>e.title.value=n),placeholder:u(o)("Please input field",{field:e.title.title}),"input-attr":{onChange:r,...(me=(pe=t.options)==null?void 0:pe.title)==null?void 0:me.inputAttr},prop:"title"},null,8,["label","modelValue","placeholder","input-attr"])):V("",!0),e.type.show?(s(),f(c,{key:2,label:e.type.title,type:"select",modelValue:e.type.value,"onUpdate:modelValue":l[2]||(l[2]=n=>e.type.value=n),data:{content:a.inputTypes},placeholder:u(o)("Please select field",{field:e.type.title}),"input-attr":{onChange:r,...(ce=(fe=t.options)==null?void 0:fe.type)==null?void 0:ce.inputAttr},prop:"type"},null,8,["label","modelValue","data","placeholder","input-attr"])):V("",!0),e.dict.show&&i.includes(e.type.value)?(s(),f(c,{key:3,label:e.dict.title,type:"textarea",modelValue:e.dict.value,"onUpdate:modelValue":l[3]||(l[3]=n=>e.dict.value=n),"input-attr":{rows:3,placeholder:u(o)("utils.One line at a time, without quotation marks, for example: key1=value1"),onChange:r,...(ye=(ge=t.options)==null?void 0:ge.dict)==null?void 0:ye.inputAttr},prop:"dict",onKeyup:l[4]||(l[4]=M(z(()=>{},["stop"]),["enter"]))},null,8,["label","modelValue","input-attr"])):V("",!0),e.tip.show?(s(),f(c,{key:4,label:e.tip.title,type:"string",modelValue:e.tip.value,"onUpdate:modelValue":l[5]||(l[5]=n=>e.tip.value=n),placeholder:u(o)("Please input field",{field:e.tip.title}),"input-attr":{onChange:r,...(ve=(Ve=t.options)==null?void 0:Ve.tip)==null?void 0:ve.inputAttr},prop:"tip"},null,8,["label","modelValue","placeholder","input-attr"])):V("",!0),e.rule.show?(s(),f(c,{key:5,label:e.rule.title,type:"selects",modelValue:e.rule.value,"onUpdate:modelValue":l[6]||(l[6]=n=>e.rule.value=n),data:{content:a.validators},placeholder:u(o)("Please select field",{field:e.rule.title}),"input-attr":{onChange:r,...(he=(be=t.options)==null?void 0:be.rule)==null?void 0:he.inputAttr},prop:"rule"},null,8,["label","modelValue","data","placeholder","input-attr"])):V("",!0),e.extend.show?(s(),f(c,{key:6,label:e.extend.title,type:"textarea",modelValue:e.extend.value,"onUpdate:modelValue":l[7]||(l[7]=n=>e.extend.value=n),"input-attr":{onChange:r,placeholder:u(o)("utils.One attribute per line without quotation marks(formitem)"),...(we=(xe=t.options)==null?void 0:xe.extend)==null?void 0:we.inputAttr},prop:"extend",onKeyup:l[8]||(l[8]=M(z(()=>{},["stop"]),["enter"]))},null,8,["label","modelValue","input-attr"])):V("",!0),e.inputExtend.show?(s(),f(c,{key:7,label:e.inputExtend.title,type:"textarea",modelValue:e.inputExtend.value,"onUpdate:modelValue":l[9]||(l[9]=n=>e.inputExtend.value=n),"input-attr":{onChange:r,placeholder:u(o)("utils.Extended properties of Input, one line without quotation marks, such as: size=large"),...(Ce=(ke=t.options)==null?void 0:ke.inputExtend)==null?void 0:Ce.inputAttr},prop:"inputExtend",onKeyup:l[10]||(l[10]=M(z(()=>{},["stop"]),["enter"]))},null,8,["label","modelValue","input-attr"])):V("",!0)])}}}),Ne={class:"title"},Ge=Ae({__name:"add",props:{modelValue:{type:Boolean,default:!1},configGroup:{default:()=>({})}},emits:["update:modelValue"],setup(g,{emit:y}){const t=_e(),o=()=>{y("update:modelValue",!1)},{t:i}=qe(),e=Me(),a=_({inputTypes:{},labelWidth:180,submitLoading:!1,addConfig:{group:"",weigh:0,content:""},formItemData:{dict:`key1=value1
key2=value2`}}),r=_({group:[x({name:"required",trigger:"change",message:i("Please select field",{field:i("routine.config.Variable grouping")})})],name:[x({name:"required",title:i("routine.config.Variable name")}),x({name:"varName",message:i("Please enter the correct field",{field:i("routine.config.Variable name")})})],title:[x({name:"required",title:i("routine.config.Variable title")})],type:[x({name:"required",trigger:"change",message:i("Please select field",{field:i("routine.config.Variable type")})})],weigh:[x({name:"integer",title:i("routine.config.number")})]}),K=()=>{e.value&&e.value.validate(v=>{v&&(a.addConfig.content=a.formItemData.dict,delete a.formItemData.dict,Se("add",{...a.addConfig,...a.formItemData}).then(()=>{y("update:modelValue",!1)}))})};return(v,d)=>{const C=A("el-form"),T=A("el-scrollbar"),w=A("el-button"),E=A("el-dialog"),D=B("drag"),I=B("zoom"),U=B("blur");return s(),f(E,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":v.modelValue,onClose:o},{header:b(()=>[Te((s(),Pe("div",Ne,[O(R(u(i)("routine.config.Add configuration item")),1)])),[[D,[".ba-operate-dialog",".el-dialog__header"]],[I,".ba-operate-dialog"]])]),footer:b(()=>[Ee("div",{style:De("width: calc(100% - "+a.labelWidth/1.8+"px)")},[h(w,{onClick:o},{default:b(()=>[O(R(u(i)("Cancel")),1)]),_:1}),Te((s(),f(w,{loading:a.submitLoading,onClick:d[4]||(d[4]=p=>K()),type:"primary"},{default:b(()=>[O(R(u(i)("Add")),1)]),_:1},8,["loading"])),[[U]])],4)]),default:b(()=>[h(T,{class:"ba-table-form-scrollbar"},{default:b(()=>[Ee("div",{class:"ba-operate-form ba-add-form",style:De(u(t).layout.shrink?"":"width: calc(100% - "+a.labelWidth/2+"px)")},[h(C,{ref_key:"formRef",ref:e,onKeyup:d[3]||(d[3]=M(p=>K(),["enter"])),rules:r,model:{...a.addConfig,...a.formItemData},"label-position":u(t).layout.shrink?"top":"right","label-width":160},{default:b(()=>[h(c,{label:u(i)("routine.config.Variable grouping"),type:"select",modelValue:a.addConfig.group,"onUpdate:modelValue":d[0]||(d[0]=p=>a.addConfig.group=p),prop:"group",data:{content:v.configGroup}},null,8,["label","modelValue","data"]),h(Ke,{modelValue:a.formItemData,"onUpdate:modelValue":d[1]||(d[1]=p=>a.formItemData=p)},null,8,["modelValue"]),h(c,{label:u(i)("Weigh"),type:"number",modelValue:a.addConfig.weigh,"onUpdate:modelValue":d[2]||(d[2]=p=>a.addConfig.weigh=p),modelModifiers:{number:!0},prop:"weigh"},null,8,["label","modelValue"])]),_:1},8,["rules","model","label-position"])],4)]),_:1})]),_:1},8,["model-value"])}}});export{Ge as _,$e as a,Le as d,Fe as i,Se as p};
