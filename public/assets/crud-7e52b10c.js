import{i as e,c as m}from"./index-32d6febb.js";import{c as d}from"./validate-4db1e214.js";import{f as l,n as b}from"./index-afbe03c0.js";import{r as g}from"./vue-69ad5a16.js";const u=g({step:"Start",type:"",startData:{db:"",sql:"",logId:""}}),v=o=>{if(u.type=o,o=="start"){u.step="Start";for(const r in u.startData)u.startData[r]=""}else u.step="Design"},T={common:[{title:e.global.t("crud.state.Primary key"),name:"id",comment:"ID",designType:"pk",formBuildExclude:!0,table:{},form:{},...l.number,default:"none",primaryKey:!0,unsigned:!0,autoIncrement:!0},{title:e.global.t("crud.state.Primary key (Snowflake ID)"),name:"id",comment:"ID",designType:"spk",formBuildExclude:!0,table:{},form:{},...l.number,type:"bigint",length:20,default:"none",primaryKey:!0,unsigned:!0},{title:e.global.t("crud.state.Weight (drag and drop sorting)"),name:"weigh",comment:e.global.t("Weigh"),designType:"weigh",table:{},form:{},...l.number,default:"0",null:!0},{title:e.global.t("State"),name:"status",comment:e.global.t("crud.state.Status:0=Disabled,1=Enabled"),designType:"switch",table:{},form:{},...l.switch},{title:e.global.t("crud.state.remarks"),name:"remark",comment:e.global.t("crud.state.remarks"),designType:"textarea",tableBuildExclude:!0,table:{},form:{},...l.textarea},{title:e.global.t("Update time"),name:"update_time",comment:e.global.t("Update time"),designType:"timestamp",formBuildExclude:!0,table:{},form:{},...l.datetime},{title:e.global.t("Create time"),name:"create_time",comment:e.global.t("Create time"),designType:"timestamp",formBuildExclude:!0,table:{},form:{},...l.datetime},{title:e.global.t("crud.state.Remote Select (association table)"),name:"remote_select",comment:e.global.t("utils.remote select"),designType:"remoteSelect",tableBuildExclude:!0,table:{},form:{},...l.remoteSelect}],base:[{title:e.global.t("utils.string"),name:"string",comment:e.global.t("utils.string"),designType:"string",table:{},form:{},...l.string},{title:e.global.t("utils.image"),name:"image",comment:e.global.t("utils.image"),designType:"image",table:{},form:{},...l.image},{title:e.global.t("utils.file"),name:"file",comment:e.global.t("utils.file"),designType:"file",tableBuildExclude:!0,table:{},form:{},...l.file},{title:e.global.t("utils.radio"),name:"radio",dataType:"enum('opt0','opt1')",comment:e.global.t("crud.state.Radio:opt0=Option1,opt1=Option2"),designType:"radio",table:{},form:{},...l.radio,default:"opt0"},{title:e.global.t("utils.checkbox"),name:"checkbox",dataType:"set('opt0','opt1')",comment:e.global.t("crud.state.Checkbox:opt0=Option1,opt1=Option2"),designType:"checkbox",table:{},form:{},...l.checkbox,default:"opt0,opt1"},{title:e.global.t("utils.select"),name:"select",dataType:"enum('opt0','opt1')",comment:e.global.t("crud.state.Select:opt0=Option1,opt1=Option2"),designType:"select",table:{},form:{},...l.select,default:"opt0"},{title:e.global.t("utils.switch"),name:"switch",comment:e.global.t("crud.state.Switch:0=off,1=on"),designType:"switch",table:{},form:{},...l.switch},{title:e.global.t("utils.rich Text"),name:"editor",comment:e.global.t("utils.rich Text"),designType:"editor",tableBuildExclude:!0,table:{},form:{},...l.editor},{title:e.global.t("utils.textarea"),name:"textarea",comment:e.global.t("utils.textarea"),designType:"textarea",tableBuildExclude:!0,table:{},form:{},...l.textarea},{title:e.global.t("utils.number"),name:"number",comment:e.global.t("utils.number"),designType:"number",table:{},form:{},...l.number},{title:e.global.t("utils.float"),name:"float",type:"decimal",length:5,precision:2,default:"0",...b(),comment:e.global.t("utils.float"),designType:"float",table:{},form:{}},{title:e.global.t("utils.password"),name:"password",comment:e.global.t("utils.password"),designType:"password",tableBuildExclude:!0,table:{},form:{},...l.password},{title:e.global.t("utils.date"),name:"date",comment:e.global.t("utils.date"),designType:"date",table:{},form:{},...l.date},{title:e.global.t("utils.time"),name:"time",comment:e.global.t("utils.time"),designType:"time",table:{},form:{},...l.time},{title:e.global.t("utils.time date"),name:"datetime",type:"datetime",length:0,precision:0,default:"null",...b(),null:!0,comment:e.global.t("utils.time date"),designType:"datetime",table:{},form:{}},{title:e.global.t("utils.year"),name:"year",comment:e.global.t("utils.year"),designType:"year",table:{},form:{},...l.year},{title:e.global.t("crud.state.Time date (timestamp storage)"),name:"timestamp",comment:e.global.t("utils.time date"),designType:"timestamp",table:{},form:{},...l.datetime}],senior:[{title:e.global.t("utils.array"),name:"array",comment:e.global.t("utils.array"),designType:"array",tableBuildExclude:!0,table:{},form:{},...l.array},{title:e.global.t("utils.city select"),name:"city",comment:e.global.t("utils.city select"),designType:"city",table:{},form:{},...l.city},{title:e.global.t("utils.icon select"),name:"icon",comment:e.global.t("utils.icon select"),designType:"icon",table:{},form:{},...l.icon},{title:e.global.t("utils.color picker"),name:"color",comment:e.global.t("utils.color picker"),designType:"color",table:{},form:{},...l.color},{title:e.global.t("utils.image")+e.global.t("crud.state.Multi"),name:"images",comment:e.global.t("utils.image"),designType:"images",table:{},form:{},...l.images},{title:e.global.t("utils.file")+e.global.t("crud.state.Multi"),name:"files",comment:e.global.t("utils.file"),designType:"files",tableBuildExclude:!0,table:{},form:{},...l.files},{title:e.global.t("utils.select")+e.global.t("crud.state.Multi"),name:"selects",comment:e.global.t("crud.state.Select:opt0=Option1,opt1=Option2"),designType:"selects",table:{},form:{},...l.selects},{title:e.global.t("crud.state.Remote Select (Multi)"),name:"remote_select",comment:e.global.t("utils.remote select"),designType:"remoteSelects",tableBuildExclude:!0,table:{},form:{},...l.remoteSelects}]},i={render:{type:"select",value:"none",options:{none:e.global.t("None"),icon:"Icon",switch:e.global.t("utils.switch"),image:e.global.t("utils.image"),images:e.global.t("utils.multi image"),tag:"Tag",tags:"Tags",url:"URL",datetime:e.global.t("utils.time date"),color:e.global.t("utils.color")}},operator:{type:"select",value:"eq",options:{false:e.global.t("crud.state.Disable Search"),eq:"eq =",ne:"ne !=",gt:"gt >",egt:"egt >=",lt:"lt <",elt:"elt <=",LIKE:"LIKE","NOT LIKE":"NOT LIKE",IN:"IN","NOT IN":"NOT IN",RANGE:"RANGE","NOT RANGE":"NOT RANGE",NULL:"NULL","NOT NULL":"NOT NULL",FIND_IN_SET:"FIND_IN_SET"}},sortable:{type:"select",value:"false",options:{false:e.global.t("Disable"),custom:e.global.t("Enable")}}},a={validator:{type:"selects",value:[],options:d},validatorMsg:{type:"textarea",value:"",placeholder:e.global.t("crud.state.If left blank, the verifier title attribute will be filled in automatically"),attr:{rows:3}}},t=(o,r)=>({...i[o],value:r}),s=(o,r)=>({...a[o],value:r}),w={pk:{name:e.global.t("crud.state.Primary key"),table:{width:{type:"number",value:70},operator:t("operator","RANGE"),sortable:t("sortable","custom")},form:{}},spk:{name:e.global.t("crud.state.Primary key (Snowflake ID)"),table:{width:{type:"number",value:180},operator:t("operator","RANGE"),sortable:t("sortable","custom")},form:{}},weigh:{name:e.global.t("crud.state.Weight (automatically generate drag sort button)"),table:{operator:t("operator","RANGE"),sortable:t("sortable","custom")},form:a},timestamp:{name:e.global.t("crud.state.Time date (timestamp storage)"),table:{render:t("render","datetime"),operator:t("operator","RANGE"),sortable:t("sortable","custom"),width:{type:"number",value:160},timeFormat:{type:"string",value:"yyyy-mm-dd hh:MM:ss"}},form:{...a,validator:s("validator",["date"])}},string:{name:e.global.t("utils.string"),table:{...i,operator:t("operator","LIKE")},form:a},password:{name:e.global.t("utils.password"),table:{operator:t("operator","false")},form:{...a,validator:s("validator",["password"])}},number:{name:e.global.t("utils.number"),table:{...i,operator:t("operator","RANGE")},form:{...a,validator:s("validator",["number"]),step:{type:"number",value:1}}},float:{name:e.global.t("utils.float"),table:{...i,operator:t("operator","RANGE")},form:{...a,validator:s("validator",["float"]),step:{type:"number",value:1}}},radio:{name:e.global.t("utils.radio"),table:{...i,render:t("render","tag")},form:a},checkbox:{name:e.global.t("utils.checkbox"),table:{...i,render:t("render","tags"),operator:t("operator","FIND_IN_SET")},form:a},switch:{name:e.global.t("utils.switch"),table:{...i,render:t("render","switch")},form:a},textarea:{name:e.global.t("utils.textarea"),table:{operator:t("operator","false")},form:{...a,rows:{type:"number",value:3}}},array:{name:e.global.t("utils.array"),table:{operator:t("operator","false")},form:a},datetime:{name:e.global.t("utils.time date")+e.global.t("utils.choice"),table:{operator:t("operator","eq"),sortable:t("sortable","custom"),width:{type:"number",value:160}},form:{...a,validator:s("validator",["date"])}},year:{name:e.global.t("utils.year")+e.global.t("utils.choice"),table:{operator:t("operator","RANGE"),sortable:t("sortable","custom")},form:{...a,validator:s("validator",["date"])}},date:{name:e.global.t("utils.date")+e.global.t("utils.choice"),table:{operator:t("operator","eq"),sortable:t("sortable","custom")},form:{...a,validator:s("validator",["date"])}},time:{name:e.global.t("utils.time")+e.global.t("utils.choice"),table:{operator:t("operator","eq"),sortable:t("sortable","custom")},form:a},select:{name:e.global.t("utils.select"),table:{...i,render:t("render","tag")},form:{...a,"select-multi":{type:"switch",value:!1}}},selects:{name:e.global.t("utils.select")+e.global.t("crud.state.Multi"),table:{...i,render:t("render","tags"),operator:t("operator","FIND_IN_SET")},form:{...a,"select-multi":{type:"switch",value:!0}}},remoteSelect:{name:e.global.t("utils.remote select")+e.global.t("utils.choice"),table:{operator:t("operator","LIKE")},form:{...a,"select-multi":{type:"switch",value:!1},"remote-pk":{type:"string",value:"id"},"remote-field":{type:"string",value:"name"},"remote-table":{type:"string",value:""},"remote-controller":{type:"string",value:""},"remote-model":{type:"string",value:""},"relation-fields":{type:"string",value:""},"remote-url":{type:"string",value:"",placeholder:e.global.t("crud.state.If it is not input, it will be automatically analyzed by the controller")}}},remoteSelects:{name:e.global.t("utils.remote select")+e.global.t("utils.choice")+e.global.t("crud.state.Multi"),table:{operator:t("operator","LIKE")},form:{...a,"select-multi":{type:"switch",value:!0},"remote-pk":{type:"string",value:"id"},"remote-field":{type:"string",value:"name"},"remote-table":{type:"string",value:""},"remote-controller":{type:"string",value:""},"remote-model":{type:"string",value:""},"relation-fields":{type:"string",value:""},"remote-url":{type:"string",value:"",placeholder:e.global.t("crud.state.If it is not input, it will be automatically analyzed by the controller")}}},editor:{name:e.global.t("utils.rich Text"),table:{operator:t("operator","false")},form:{...a,validator:s("validator",["editorRequired"])}},city:{name:e.global.t("utils.city select"),table:{operator:t("operator","false")},form:a},image:{name:e.global.t("utils.image")+e.global.t("Upload"),table:{render:t("render","image"),operator:t("operator","false")},form:{...a,"image-multi":{type:"switch",value:!1}}},images:{name:e.global.t("utils.image")+e.global.t("Upload")+e.global.t("crud.state.Multi"),table:{render:t("render","images"),operator:t("operator","false")},form:{...a,"image-multi":{type:"switch",value:!0}}},file:{name:e.global.t("utils.file")+e.global.t("Upload"),table:{render:t("render","none"),operator:t("operator","false")},form:{...a,"file-multi":{type:"switch",value:!1}}},files:{name:e.global.t("utils.file")+e.global.t("Upload")+e.global.t("crud.state.Multi"),table:{render:t("render","none"),operator:t("operator","false")},form:{...a,"file-multi":{type:"switch",value:!0}}},icon:{name:e.global.t("utils.icon select"),table:{render:t("render","icon"),operator:t("operator","false")},form:a},color:{name:e.global.t("utils.color picker"),table:{render:t("render","color"),operator:t("operator","false")},form:a}},E=["quickSearchField","formFields","columnFields"],n="/admin/crud.Crud/";function N(o){return m({url:n+"generate",method:"post",data:o},{showSuccessMessage:!0})}function x(){return m({url:n+"databaseList",method:"get"})}function k(o,r=0){return m({url:n+"getFileData",method:"get",params:{table:o,commonModel:r}})}function I(o){return m({url:n+"generateCheck",method:"post",data:o},{showCodeMessage:!1})}function S(o,r="",c=""){return m({url:n+"parseFieldData",method:"post",data:{type:o,table:r,sql:c}})}function D(o){return m({url:n+"logStart",method:"post",data:{id:o}})}function L(o){return m({url:n+"delete",method:"post",data:{id:o}})}function A(o){return m({url:n+"checkCrudLog",method:"get",params:{table:o}})}export{k as a,N as b,I as c,w as d,v as e,T as f,x as g,t as h,S as i,A as j,L as k,D as p,u as s,E as t};
