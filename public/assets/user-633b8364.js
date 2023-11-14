import{b as D,a as N,f as L,_ as C,e as V,w as W,u as G,m as J}from"./index-32d6febb.js";import{H as E,F as P,i as O}from"./footer-3970941c.js";import{o as T,r as X,g as Y}from"./router-b77da531.js";import{h as g,a0 as j,q as r,X as Z,o as c,O as p,P as l,m as d,z as n,p as t,U as b,_ as M,k as h,Y as B,Z as I,W as K,$ as Q,af as ee,ak as q,w as te,am as ne,l as F,N as se,ad as oe,E as ae,i as re,J as le}from"./vue-69ad5a16.js";import{m as H}from"./layout-3cfbed32.js";import"./darkSwitch-ad1c6f1f.js";import"./useDark-4e217d35.js";const ce={class:"userinfo"},ie=["src"],ue={class:"username"},_e={class:"user-menus"},me={key:0,class:"user-menu-max-title"},de=["onClick"],pe=g({__name:"aside",setup(f){const _=j(),s=D(),i=N(),u=(o="",e)=>{document.body.clientWidth<992&&i.toggleMenuExpand(!1),o?_.push({name:o}):e&&T(e)};return(o,e)=>{const a=r("Icon"),v=r("el-button"),m=r("el-button-group"),w=r("el-aside"),R=Z("blur");return c(),p(w,{class:"ba-user-layouts"},{default:l(()=>[d("div",ce,[d("div",{onClick:e[0]||(e[0]=y=>u("account/profile")),class:"user-avatar-box"},[d("img",{class:"user-avatar",src:n(L)(n(s).avatar?n(s).avatar:"/static/images/avatar.png"),alt:""},null,8,ie),t(a,{class:"user-avatar-gender",name:n(s).getGenderIcon().name,size:"14",color:n(s).getGenderIcon().color},null,8,["name","color"])]),d("p",ue,b(n(s).nickname),1),t(m,null,{default:l(()=>[M((c(),p(v,{onClick:e[1]||(e[1]=y=>u("account/integral")),class:"userinfo-button-item",title:o.$t("Integral")+" "+n(s).score,size:"default",plain:""},{default:l(()=>[d("span",null,b(o.$t("Integral")+" "+n(s).score),1)]),_:1},8,["title"])),[[R]]),M((c(),p(v,{onClick:e[2]||(e[2]=y=>u("account/balance")),class:"userinfo-button-item",title:o.$t("Balance")+" "+n(s).money,size:"default",plain:""},{default:l(()=>[d("span",null,b(o.$t("Balance")+" "+n(s).money),1)]),_:1},8,["title"])),[[R]])]),_:1})]),d("div",_e,[(c(!0),h(I,null,B(n(i).state.viewRoutes,(y,U)=>{var $;return c(),h(I,{key:U},[n(i).state.showHeadline?(c(),h("div",me,b(($=y.meta)==null?void 0:$.title),1)):K("",!0),(c(!0),h(I,null,B(y.children,(k,A)=>{var x,S,z;return c(),h("div",{key:A,onClick:we=>u("",k),class:Q(["user-menu-item",((x=n(i).state.activeRoute)==null?void 0:x.name)==k.name?"active":""])},[t(a,{name:(S=k.meta)==null?void 0:S.icon,size:"16",color:"var(--el-text-color-secondary)"},null,8,["name"]),d("span",null,b((z=k.meta)==null?void 0:z.title),1)],10,de)}),128))],64)}),128))])]),_:1})}}});const fe=C(pe,[["__scopeId","data-v-e1f1a266"]]),ve=g({__name:"main",setup(f){const _=V();return(s,i)=>{const u=r("router-view"),o=r("el-main");return c(),p(o,{class:"layout-main"},{default:l(()=>[t(u,null,{default:l(({Component:e})=>[t(ee,{name:n(_).layout.mainAnimation,mode:"out-in"},{default:l(()=>[(c(),p(q(e)))]),_:2},1032,["name"])]),_:1})]),_:1})}}});const ye=C(ve,[["__scopeId","data-v-bc73de31"]]),be=g({__name:"default",setup(f){const _=te();return ne("mainScrollbarRef",_),(s,i)=>{const u=r("el-col"),o=r("el-row"),e=r("el-scrollbar"),a=r("el-container");return c(),p(a,{class:"is-vertical"},{default:l(()=>[t(E),t(e,{style:F(n(H)()),ref_key:"mainScrollbarRef",ref:_},{default:l(()=>[t(o,{class:"frontend-footer-brother",justify:"center"},{default:l(()=>[t(u,{class:"user-layouts",span:16,xs:24},{default:l(()=>[t(fe,{class:"hidden-sm-and-down"}),t(ye)]),_:1})]),_:1}),t(P)]),_:1},8,["style"])]),_:1})}}});const he=C(be,[["__scopeId","data-v-cb5cf4f0"]]),ge=g({__name:"disable",setup(f){return(_,s)=>{const i=r("el-alert"),u=r("el-col"),o=r("el-row"),e=r("el-scrollbar"),a=r("el-container");return c(),p(a,{class:"is-vertical"},{default:l(()=>[t(E),t(e,{style:F(n(H)()),ref:"mainScrollbarRef"},{default:l(()=>[t(o,{class:"frontend-footer-brother",justify:"center"},{default:l(()=>[t(u,{class:"user-layouts",span:16,xs:24},{default:l(()=>[t(i,{center:!0,title:_.$t("Member center disabled"),type:"error"},null,8,["title"])]),_:1})]),_:1}),t(P)]),_:1},8,["style"])]),_:1})}}});const ke=C(ge,[["__scopeId","data-v-e004cd2e"]]);function Ce(){return new Promise(f=>{f({type:"continue"})})}const Be=g({components:{Default:he,Disable:ke},__name:"user",setup(f){const{t:_}=W(),s=se(),i=j(),u=D(),o=G(),e=N();return oe(a=>{e.setActiveRoute(a)}),ae(async()=>{const a=await Ce();if(a.type=="break")return;if(a.type=="reload")return window.location.href=a.url;if(!u.token)return i.push({name:"userLogin"});const v=()=>{if(a.type=="jump")return i.push(a.url);if(s.params.to){const m=JSON.parse(s.params.to);if(m.path!=J){let w=re(m.query)?{}:m.query;X({path:m.path,query:w});return}}if(s.name=="userMainLoading"){let m=Y(e.state.viewRoutes);m?i.push({path:m.path}):le({type:"error",message:_("No route found to jump~")})}};o.userInitialize?v():O(v,!0),document.body.clientWidth<1024?e.setShrink(!0):e.setShrink(!1)}),(a,v)=>(c(),p(q(n(e).state.layoutMode)))}});export{Be as default};
