import{f as z,aq as F,N as B,p as d,X as s,o as u,O as f,P as r,_ as c,j as W,V as b,U as p,w as e,l as h,k as V,m as i,$ as I,a8 as N}from"./vue-BMxP1YH6.js";import{p as P}from"./index-Con-2NqR.js";import{e as T,_ as $}from"./index-HeYxHBW0.js";const q={class:"title"},A={class:"block-help"},D=z({__name:"popupForm",setup(E){const g=T(),l=F("baTable"),{t:o}=B();return(H,t)=>{const y=d("el-image"),m=d("el-form-item"),n=d("el-input"),v=d("el-form"),w=d("el-scrollbar"),_=d("el-button"),U=d("el-dialog"),k=s("drag"),x=s("zoom"),C=s("loading"),S=s("blur");return u(),f(U,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":["Add","Edit"].includes(e(l).form.operate),onClose:e(l).toggleForm},{header:r(()=>[c((u(),W("div",q,[b(p(e(l).form.operate?e(o)(e(l).form.operate):""),1)])),[[k,[".ba-operate-dialog",".el-dialog__header"]],[x,".ba-operate-dialog"]])]),footer:r(()=>[h("div",{style:V("width: calc(100% - "+e(l).form.labelWidth/1.8+"px)")},[i(_,{onClick:t[12]||(t[12]=a=>e(l).toggleForm(""))},{default:r(()=>[b(p(e(o)("Cancel")),1)]),_:1}),c((u(),f(_,{loading:e(l).form.submitLoading,onClick:t[13]||(t[13]=a=>e(l).onSubmit()),type:"primary"},{default:r(()=>[b(p(e(l).form.operateIds.length>1?e(o)("Save and edit next item"):e(o)("Save")),1)]),_:1},8,["loading"])),[[S]])],4)]),default:r(()=>[c((u(),f(w,{class:"ba-table-form-scrollbar"},{default:r(()=>[h("div",{class:I(["ba-operate-form","ba-"+e(l).form.operate+"-form"]),style:V(e(g).layout.shrink?"":"width: calc(100% - "+e(l).form.labelWidth/2+"px)")},[i(v,{onKeyup:t[10]||(t[10]=N(a=>e(l).onSubmit(),["enter"])),modelValue:e(l).form.items,"onUpdate:modelValue":t[11]||(t[11]=a=>e(l).form.items=a),"label-position":e(g).layout.shrink?"top":"right","label-width":e(l).form.labelWidth+"px"},{default:r(()=>[i(m,{label:e(o)("utils.preview")},{default:r(()=>[i(y,{class:"preview-img","preview-src-list":[e(l).form.items.full_url],src:e(P)(e(l).form.items,{},e(l).form.items.suffix)},null,8,["preview-src-list","src"])]),_:1},8,["label"]),i(m,{label:e(o)("utils.Breakdown")},{default:r(()=>[i(n,{modelValue:e(l).form.items.topic,"onUpdate:modelValue":t[0]||(t[0]=a=>e(l).form.items.topic=a),type:"string",placeholder:e(o)("routine.attachment.The file is saved in the directory, and the file will not be automatically transferred if the record is modified"),readonly:""},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.Physical path")},{default:r(()=>[i(n,{modelValue:e(l).form.items.url,"onUpdate:modelValue":t[1]||(t[1]=a=>e(l).form.items.url=a),type:"string",placeholder:e(o)("routine.attachment.File saving path Modifying records will not automatically transfer files"),readonly:""},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.image width")},{default:r(()=>[i(n,{modelValue:e(l).form.items.width,"onUpdate:modelValue":t[2]||(t[2]=a=>e(l).form.items.width=a),type:"number",placeholder:e(o)("routine.attachment.Width of picture file")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.Picture height")},{default:r(()=>[i(n,{modelValue:e(l).form.items.height,"onUpdate:modelValue":t[3]||(t[3]=a=>e(l).form.items.height=a),type:"number",placeholder:e(o)("routine.attachment.Height of picture file")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("utils.Original name")},{default:r(()=>[i(n,{modelValue:e(l).form.items.name,"onUpdate:modelValue":t[4]||(t[4]=a=>e(l).form.items.name=a),type:"string",placeholder:e(o)("routine.attachment.Original file name")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.file size")},{default:r(()=>[i(n,{modelValue:e(l).form.items.size,"onUpdate:modelValue":t[5]||(t[5]=a=>e(l).form.items.size=a),type:"number",placeholder:e(o)("routine.attachment.File size (bytes)")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.mime type")},{default:r(()=>[i(n,{modelValue:e(l).form.items.mimetype,"onUpdate:modelValue":t[6]||(t[6]=a=>e(l).form.items.mimetype=a),type:"string",placeholder:e(o)("routine.attachment.File MIME type")},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("utils.Upload (Reference) times")},{default:r(()=>[i(n,{modelValue:e(l).form.items.quote,"onUpdate:modelValue":t[7]||(t[7]=a=>e(l).form.items.quote=a),type:"number",placeholder:e(o)("routine.attachment.Upload (Reference) times of this file")},null,8,["modelValue","placeholder"]),h("span",A,p(e(o)("routine.attachment.When the same file is uploaded multiple times, only one attachment record will be saved and added")),1)]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.Storage mode")},{default:r(()=>[i(n,{modelValue:e(l).form.items.storage,"onUpdate:modelValue":t[8]||(t[8]=a=>e(l).form.items.storage=a),type:"string",placeholder:e(o)("routine.attachment.Storage mode"),readonly:""},null,8,["modelValue","placeholder"])]),_:1},8,["label"]),i(m,{label:e(o)("routine.attachment.SHA1 code")},{default:r(()=>[i(n,{modelValue:e(l).form.items.sha1,"onUpdate:modelValue":t[9]||(t[9]=a=>e(l).form.items.sha1=a),type:"string",placeholder:e(o)("routine.attachment.SHA1 encoding of file"),readonly:""},null,8,["modelValue","placeholder"])]),_:1},8,["label"])]),_:1},8,["modelValue","label-position","label-width"])],6)]),_:1})),[[C,e(l).form.loading]])]),_:1},8,["model-value","onClose"])}}}),j=$(D,[["__scopeId","data-v-5c9ec1d0"]]);export{j as default};
