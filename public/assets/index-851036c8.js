import{s as a,i as T,m as E,a as D,p as L,d as _,g as h,e as N,f as y,u as C,h as A}from"./store-738c13c8.js";import{u as p,t as w}from"./terminal-7801ad11.js";import{u as x}from"./random-1d7fa280.js";import{i as S}from"./common-535f3731.js";import{I as c}from"./vue-9a46e809.js";var i=(o=>(o[o.UNINSTALLED=0]="UNINSTALLED",o[o.INSTALLED=1]="INSTALLED",o[o.WAIT_INSTALL=2]="WAIT_INSTALL",o[o.CONFLICT_PENDING=3]="CONFLICT_PENDING",o[o.DEPENDENT_WAIT_INSTALL=4]="DEPENDENT_WAIT_INSTALL",o[o.DIRECTORY_OCCUPIED=5]="DIRECTORY_OCCUPIED",o[o.DISABLE=6]="DISABLE",o))(i||{});const k=()=>{a.loading.table=!0,a.table.indexLoaded?g():v().then(()=>{g()})},m=()=>{a.table.indexLoaded=!1;for(const o in a.table.modulesEbak)a.table.modulesEbak[o]=void 0;k()},v=()=>T().then(o=>{a.table.indexLoaded=!0,a.installedModule=o.data.installed;const e=[];if(o.data.installed){for(const n in o.data.installed)e.push(o.data.installed[n].uid);a.installedModuleUids=e}}),g=()=>{if(typeof a.table.modulesEbak[a.table.params.activeTab]<"u"){a.table.modules[a.table.params.activeTab]=b(a.table.modulesEbak[a.table.params.activeTab]),a.loading.table=!1;return}const o={};for(const t in a.table.params)a.table.params[t]!=""&&(o[t]=a.table.params[t]);const e=[],n=[];a.installedModule.forEach(t=>{n.push({uid:t.uid,version:t.version})}),o.installed=n,E(o).then(t=>{o.activeTab=="all"&&(t.data.rows.forEach(l=>{e.push(l.uid)}),a.installedModule.forEach(l=>{e.indexOf(l.uid)===-1&&t.data.rows.push(l)})),a.table.remark=t.data.remark,a.table.modulesEbak[o.activeTab]=t.data.rows.map(l=>{const d=a.installedModuleUids.indexOf(l.uid);return d!==-1?(l.state=a.installedModule[d].state,l.version=a.installedModule[d].version,l.website=a.installedModule[d].website,l.stateTag=M(l.state)):l.state=0,l.new_version&&l.tags&&l.tags.push({name:"有新版本",type:"danger"}),l}),a.table.modules[o.activeTab]=b(a.table.modulesEbak[o.activeTab]),a.table.category=t.data.category}).finally(()=>{a.loading.table=!1})},W=o=>{a.dialog.goodsInfo=!0,a.loading.goodsInfo=!0;const e=a.installedModule.find(n=>n.uid==o);A({uid:o,localVersion:e==null?void 0:e.version}).then(n=>{e?(n.data.info.type=="local"?(n.data.info=e,n.data.info.images=[S("/static/images/local-module-logo.png")],n.data.info.type="local"):(n.data.info.type="online",n.data.info.state=e.state,n.data.info.version=e.version),n.data.info.enable=e.state!==i.DISABLE):(n.data.info.state=0,n.data.info.type="online"),a.goodsInfo=n.data.info}).catch(n=>{f(n)&&(a.dialog.goodsInfo=!1)}).finally(()=>{a.loading.goodsInfo=!1})},H=()=>{a.dialog.buy=!0,a.loading.buy=!0,D({goods_id:a.goodsInfo.id}).then(o=>{a.loading.buy=!1,a.buy.info=o.data.info}).catch(o=>{a.dialog.buy=!1,a.loading.buy=!1,f(o)})},G=o=>{a.loading.common=!0,L(a.buy.info.id,o).then(e=>{if(o=="wx"){a.dialog.buy=!1,a.dialog.goodsInfo=!1,a.dialog.pay=!0,a.payInfo=e.data;const n=setInterval(()=>{_(a.payInfo.info.sn).then(()=>{a.payInfo.pay.status="success",clearInterval(n),r(e.data.info.uid,e.data.info.id),a.dialog.pay=!1}).catch(()=>{})},3e3)}else r(e.data.info.uid,e.data.info.id)}).catch(e=>{f(e)}).finally(()=>{a.loading.common=!1})},u=o=>{a.common.type="loading",a.common.loadingTitle=o,a.common.loadingComponentKey=x()},r=(o,e)=>{a.dialog.common=!0,u("init"),a.common.dialogTitle="安装",h(o).then(n=>{n.data.state===i.INSTALLED||n.data.state===i.DISABLE||n.data.state===i.DIRECTORY_OCCUPIED?(c({type:"error",message:n.data.state===i.INSTALLED||n.data.state===i.DISABLE?"安装取消，因为模块已经存在！":"安装取消，因为模块所需目录被占用！"}),a.dialog.common=!1):(u(n.data.state===i.UNINSTALLED?"download":"install"),I(o,e),a.dialog.baAccount=!1,a.dialog.buy=!1,a.dialog.goodsInfo=!1)})},I=(o,e,n={})=>{a.common.disableHmr=!0,N(o,e,n).then(()=>{a.common.dialogTitle="安装完成",a.common.moduleState=i.INSTALLED,a.common.type="done"}).catch(t=>{if(!f(t))if(t.code==-1)a.common.uid=t.data.uid,a.common.type="InstallConflict",a.common.dialogTitle="发现冲突，请手动处理",a.common.fileConflict=t.data.fileConflict,a.common.dependConflict=t.data.dependConflict;else if(t.code==-2){a.common.type="done",a.common.uid=t.data.uid,a.common.dialogTitle="等待依赖安装",a.common.moduleState=i.DEPENDENT_WAIT_INSTALL,a.common.waitInstallDepend=t.data.wait_install,a.common.dependInstallState="executing";const l=p();t.data.wait_install.includes("npm_dependent_wait_install")&&l.addTaskPM("web-install",!0,"module-install:"+t.data.uid,d=>{s(d,"npm_dependent_wait_install")}),t.data.wait_install.includes("nuxt_npm_dependent_wait_install")&&l.addTaskPM("nuxt-install",!0,"module-install:"+t.data.uid,d=>{s(d,"nuxt_npm_dependent_wait_install")}),t.data.wait_install.includes("composer_dependent_wait_install")&&l.addTask("composer.update",!0,"module-install:"+t.data.uid,d=>{s(d,"composer_dependent_wait_install")})}else t.code==0&&(c({type:"error",message:t.msg}),a.dialog.common=!1)}).finally(()=>{a.loading.common=!1,a.common.disableHmr=!0,m()})},s=(o,e)=>{o==w.Success?(a.common.waitInstallDepend=a.common.waitInstallDepend.filter(n=>n!=e),a.common.waitInstallDepend.length==0&&(a.common.dependInstallState="success")):(p().toggle(!0),a.common.dependInstallState="fail"),m()},Y=(o=!1)=>{if(a.loading.common=!0,a.common.disableHmr=!0,o){const e={};for(const n in a.common.disableDependConflict)a.common.disableDependConflict[n].solution=="delete"&&(typeof e[a.common.disableDependConflict[n].env]>"u"&&(e[a.common.disableDependConflict[n].env]=[]),e[a.common.disableDependConflict[n].env].push(a.common.disableDependConflict[n].depend));a.common.disableParams.confirmConflict=1,a.common.disableParams.dependConflictSolution=e}y(a.common.disableParams).then(()=>{c({type:"success",message:"操作成功，请清理系统缓存并刷新浏览器~"}),a.dialog.common=!1,m()}).catch(e=>{if(e.code==-1){if(a.dialog.common=!0,a.common.dialogTitle="处理冲突",a.common.type="disableConfirmConflict",a.common.disableDependConflict=e.data.dependConflict,e.data.conflictFile&&e.data.conflictFile.length){const n=[];for(const t in e.data.conflictFile)n.push({file:e.data.conflictFile[t]});a.common.disableConflictFile=n}}else if(e.code==-2){a.dialog.common=!0;const n={type:"disable",commands:e.data.wait_install};a.common.uid=a.goodsInfo.uid,P(n),m()}else e.code==-3?r(a.goodsInfo.uid,a.goodsInfo.purchased):c({type:"error",message:e.msg})}).finally(()=>{a.loading.common=!1,a.common.disableHmr=!0})},K=o=>{a.loading.common=!0,y({uid:o,state:1}).then(()=>{a.dialog.common=!0,u("init"),a.common.dialogTitle="启用",I(o,0),a.dialog.goodsInfo=!1}).catch(e=>{c({type:"error",message:e.msg})})},f=o=>{const e=C();return o.code==301||o.code==408?(e.removeToken(),a.dialog.baAccount=!0,!0):!1},b=o=>a.table.onlyLocal?o.filter(e=>e.state>i.UNINSTALLED):o,P=o=>{if(o.type=="disable"){a.dialog.common=!0,a.common.type="done",a.common.dialogTitle="等待依赖安装",a.common.moduleState=i.DISABLE,a.common.dependInstallState="executing";const e=p();o.commands.forEach(n=>{a.common.waitInstallDepend.push(n.type),n.pm?e.addTaskPM(n.command,!0,"",t=>{s(t,n.type)}):e.addTask(n.command,!0,"",t=>{s(t,n.type)})})}},V=o=>o.nickname+"（"+(o.email||o.mobile||"ID:"+o.id)+"）",j=(o,e)=>typeof o>"u"||typeof e>"u"?"-":e==0?parseInt(o.toString())+"积分":"￥"+o,M=o=>{switch(o){case i.INSTALLED:return{type:"",text:"已安装"};case i.WAIT_INSTALL:return{type:"success",text:"等待安装"};case i.CONFLICT_PENDING:return{type:"danger",text:"冲突待处理"};case i.DEPENDENT_WAIT_INSTALL:return{type:"warning",text:"依赖待安装"};case i.DISABLE:return{type:"warning",text:"禁用"};default:return{type:"info",text:"未知"}}};export{r as a,m as b,j as c,Y as d,I as e,H as f,K as g,W as h,k as i,f as l,i as m,G as o,V as s};
