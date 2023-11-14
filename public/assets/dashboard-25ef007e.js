import{_ as P}from"./login-header-0d634706.js";import{i as A}from"./echarts-02f2616f.js";import{c as j,w as J,k as K,t as X,G as $,h as Q,ab as Z,f as tt,L as x,ai as k,_ as st}from"./index-32d6febb.js";import{h as et,r as at,ax as ot,E as nt,al as it,ac as rt,F as lt,q as F,o as ct,k as dt,m as s,p as c,P as u,z as d,U as b,V as ht,n as H,a1 as ut,a2 as mt}from"./vue-69ad5a16.js";const pt="/assets/header-1-2575ae78.svg",ft="/assets/coffee-d68d7748.svg";var D=function(){return D=Object.assign||function(m){for(var a,h=1,e=arguments.length;h<e;h++)for(var t in a=arguments[h])Object.prototype.hasOwnProperty.call(a,t)&&(m[t]=a[t]);return m},D.apply(this,arguments)},_t=function(){function m(a,h,e){var t=this;this.endVal=h,this.options=e,this.version="2.6.2",this.defaults={startVal:0,decimalPlaces:0,duration:2,useEasing:!0,useGrouping:!0,useIndianSeparators:!1,smartEasingThreshold:999,smartEasingAmount:333,separator:",",decimal:".",prefix:"",suffix:"",enableScrollSpy:!1,scrollSpyDelay:200,scrollSpyOnce:!1},this.finalEndVal=null,this.useEasing=!0,this.countDown=!1,this.error="",this.startVal=0,this.paused=!0,this.once=!1,this.count=function(_){t.startTime||(t.startTime=_);var p=_-t.startTime;t.remaining=t.duration-p,t.useEasing?t.countDown?t.frameVal=t.startVal-t.easingFn(p,0,t.startVal-t.endVal,t.duration):t.frameVal=t.easingFn(p,t.startVal,t.endVal-t.startVal,t.duration):t.frameVal=t.startVal+(t.endVal-t.startVal)*(p/t.duration);var r=t.countDown?t.frameVal<t.endVal:t.frameVal>t.endVal;t.frameVal=r?t.endVal:t.frameVal,t.frameVal=Number(t.frameVal.toFixed(t.options.decimalPlaces)),t.printValue(t.frameVal),p<t.duration?t.rAF=requestAnimationFrame(t.count):t.finalEndVal!==null?t.update(t.finalEndVal):t.options.onCompleteCallback&&t.options.onCompleteCallback()},this.formatNumber=function(_){var p,r,w,y,I=_<0?"-":"";p=Math.abs(_).toFixed(t.options.decimalPlaces);var S=(p+="").split(".");if(r=S[0],w=S.length>1?t.options.decimal+S[1]:"",t.options.useGrouping){y="";for(var z=3,T=0,V=0,C=r.length;V<C;++V)t.options.useIndianSeparators&&V===4&&(z=2,T=1),V!==0&&T%z==0&&(y=t.options.separator+y),T++,y=r[C-V-1]+y;r=y}return t.options.numerals&&t.options.numerals.length&&(r=r.replace(/[0-9]/g,function(M){return t.options.numerals[+M]}),w=w.replace(/[0-9]/g,function(M){return t.options.numerals[+M]})),I+t.options.prefix+r+w+t.options.suffix},this.easeOutExpo=function(_,p,r,w){return r*(1-Math.pow(2,-10*_/w))*1024/1023+p},this.options=D(D({},this.defaults),e),this.formattingFn=this.options.formattingFn?this.options.formattingFn:this.formatNumber,this.easingFn=this.options.easingFn?this.options.easingFn:this.easeOutExpo,this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.endVal=this.validateValue(h),this.options.decimalPlaces=Math.max(this.options.decimalPlaces),this.resetDuration(),this.options.separator=String(this.options.separator),this.useEasing=this.options.useEasing,this.options.separator===""&&(this.options.useGrouping=!1),this.el=typeof a=="string"?document.getElementById(a):a,this.el?this.printValue(this.startVal):this.error="[CountUp] target is null or undefined",typeof window<"u"&&this.options.enableScrollSpy&&(this.error?console.error(this.error,a):(window.onScrollFns=window.onScrollFns||[],window.onScrollFns.push(function(){return t.handleScroll(t)}),window.onscroll=function(){window.onScrollFns.forEach(function(_){return _()})},this.handleScroll(this)))}return m.prototype.handleScroll=function(a){if(a&&window&&!a.once){var h=window.innerHeight+window.scrollY,e=a.el.getBoundingClientRect(),t=e.top+window.pageYOffset,_=e.top+e.height+window.pageYOffset;_<h&&_>window.scrollY&&a.paused?(a.paused=!1,setTimeout(function(){return a.start()},a.options.scrollSpyDelay),a.options.scrollSpyOnce&&(a.once=!0)):(window.scrollY>_||t>h)&&!a.paused&&a.reset()}},m.prototype.determineDirectionAndSmartEasing=function(){var a=this.finalEndVal?this.finalEndVal:this.endVal;this.countDown=this.startVal>a;var h=a-this.startVal;if(Math.abs(h)>this.options.smartEasingThreshold&&this.options.useEasing){this.finalEndVal=a;var e=this.countDown?1:-1;this.endVal=a+e*this.options.smartEasingAmount,this.duration=this.duration/2}else this.endVal=a,this.finalEndVal=null;this.finalEndVal!==null?this.useEasing=!1:this.useEasing=this.options.useEasing},m.prototype.start=function(a){this.error||(a&&(this.options.onCompleteCallback=a),this.duration>0?(this.determineDirectionAndSmartEasing(),this.paused=!1,this.rAF=requestAnimationFrame(this.count)):this.printValue(this.endVal))},m.prototype.pauseResume=function(){this.paused?(this.startTime=null,this.duration=this.remaining,this.startVal=this.frameVal,this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count)):cancelAnimationFrame(this.rAF),this.paused=!this.paused},m.prototype.reset=function(){cancelAnimationFrame(this.rAF),this.paused=!0,this.resetDuration(),this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.printValue(this.startVal)},m.prototype.update=function(a){cancelAnimationFrame(this.rAF),this.startTime=null,this.endVal=this.validateValue(a),this.endVal!==this.frameVal&&(this.startVal=this.frameVal,this.finalEndVal==null&&this.resetDuration(),this.finalEndVal=null,this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count))},m.prototype.printValue=function(a){var h;if(this.el){var e=this.formattingFn(a);!((h=this.options.plugin)===null||h===void 0)&&h.render?this.options.plugin.render(this.el,e):this.el.tagName==="INPUT"?this.el.value=e:this.el.tagName==="text"||this.el.tagName==="tspan"?this.el.textContent=e:this.el.innerHTML=e}},m.prototype.ensureNumber=function(a){return typeof a=="number"&&!isNaN(a)},m.prototype.validateValue=function(a){var h=Number(a);return this.ensureNumber(h)?h:(this.error="[CountUp] invalid start or end value: ".concat(a),null)},m.prototype.resetDuration=function(){this.startTime=null,this.duration=1e3*Number(this.options.duration),this.remaining=this.duration},m}();const gt="/admin/Dashboard/";function vt(){return j({url:gt+"index",method:"get"})}const g=m=>(ut("data-v-625c9aa0"),m=m(),mt(),m),bt={class:"default-main"},wt={class:"banner"},Vt={class:"welcome suspension"},yt=["src"],Mt={class:"welcome-text"},St={class:"welcome-title"},Tt={class:"welcome-note"},xt={class:"working"},kt=["src"],Ft={class:"working-text"},zt={class:"time"},Ct={class:"small-panel-box"},Et={class:"small-panel user-reg suspension"},At={class:"small-panel-title"},Dt={class:"small-panel-content"},It={class:"content-left"},Lt=g(()=>s("span",{id:"user_reg_number"},"5456",-1)),Nt=g(()=>s("div",{class:"content-right"},"+14%",-1)),Pt={class:"small-panel file suspension"},Ot={class:"small-panel-title"},Ut={class:"small-panel-content"},Wt={class:"content-left"},Bt=g(()=>s("span",{id:"file_number"},"1234",-1)),Gt=g(()=>s("div",{class:"content-right"},"+50%",-1)),Ht={class:"small-panel users suspension"},Rt={class:"small-panel-title"},Yt={class:"small-panel-content"},qt={class:"content-left"},jt=g(()=>s("span",{id:"users_number"},"9486",-1)),Jt=g(()=>s("div",{class:"content-right"},"+28%",-1)),Kt={class:"small-panel addons suspension"},Xt={class:"small-panel-title"},$t={class:"small-panel-content"},Qt={class:"content-left"},Zt=g(()=>s("span",{id:"addons_number"},"875",-1)),ts=g(()=>s("div",{class:"content-right"},"+88%",-1)),ss={class:"growth-chart"},es={class:"new-user-growth"},as={class:"new-user-item"},os=g(()=>s("img",{class:"new-user-avatar",src:P,alt:""},null,-1)),ns={class:"new-user-base"},is=g(()=>s("div",{class:"new-user-name"},"妙码生花",-1)),rs={class:"new-user-time"},ls={class:"new-user-item"},cs=g(()=>s("img",{class:"new-user-avatar",src:P,alt:""},null,-1)),ds={class:"new-user-base"},hs=g(()=>s("div",{class:"new-user-name"},"码上生花",-1)),us={class:"new-user-time"},ms={class:"new-user-item"},ps=g(()=>s("img",{class:"new-user-avatar",src:P,alt:""},null,-1)),fs={class:"new-user-base"},_s=g(()=>s("div",{class:"new-user-name"},"Admin",-1)),gs={class:"new-user-time"},vs={class:"new-user-item"},bs=["src"],ws={class:"new-user-base"},Vs=g(()=>s("div",{class:"new-user-name"},"纯属虚构",-1)),ys={class:"new-user-time"},Ms={class:"growth-chart"},Ss=et({name:"dashboard",__name:"dashboard",setup(m){let a;const h=new Date,{t:e}=J(),t=K(),_=X(),p=$(),r=at({charts:[],remark:"dashboard.Loading",workingTimeFormat:"",pauseWork:!1});vt().then(o=>{r.remark=o.data.remark});const w=o=>{H(()=>{var n;let i=(n=document.getElementById(o))==null?void 0:n.innerText;i&&new _t(o,parseInt(i),{startVal:0,duration:3}).start()})},y=()=>{w("user_reg_number"),w("file_number"),w("users_number"),w("addons_number")},I=()=>{const o=A(p.value[0]),i={grid:{top:0,right:0,bottom:20,left:0},xAxis:{data:[e("dashboard.Monday"),e("dashboard.Tuesday"),e("dashboard.Wednesday"),e("dashboard.Thursday"),e("dashboard.Friday"),e("dashboard.Saturday"),e("dashboard.Sunday")]},yAxis:{},legend:{data:[e("dashboard.Visits"),e("dashboard.Registration volume")],textStyle:{color:"#73767a"}},series:[{name:e("dashboard.Visits"),data:[100,160,280,230,190,200,480],type:"line",smooth:!0,areaStyle:{color:"#8595F4"}},{name:e("dashboard.Registration volume"),data:[45,180,146,99,210,127,288],type:"line",smooth:!0,areaStyle:{color:"#F48595",opacity:.5}}]};o.setOption(i),r.charts.push(o)},S=()=>{const o=A(p.value[1]),i={grid:{top:30,right:0,bottom:20,left:0},tooltip:{trigger:"item"},legend:{type:"scroll",bottom:15,data:function(){for(var n=[],l=1;l<=12;l++)n.push(l+e("dashboard.month"));return n}(),textStyle:{color:"#73767a"}},visualMap:{top:"middle",right:10,color:["red","yellow"],calculable:!0},radar:{indicator:[{name:e("dashboard.picture")},{name:e("dashboard.file")},{name:e("dashboard.table")},{name:e("dashboard.Compressed package")}]},series:function(){for(var n=[],l=1;l<=12;l++)n.push({type:"radar",symbol:"none",lineStyle:{width:1},emphasis:{areaStyle:{color:"rgba(0,250,0,0.3)"}},data:[{value:[(40-l)*10,(38-l)*4+60,l*5+10,l*20],name:l+e("dashboard.month")}]});return n}()};o.setOption(i),r.charts.push(o)},z=()=>{const o=A(p.value[2]),i={reindeer:"path://M-22.788,24.521c2.08-0.986,3.611-3.905,4.984-5.892 c-2.686,2.782-5.047,5.884-9.102,7.312c-0.992,0.005-0.25-2.016,0.34-2.362l1.852-0.41c0.564-0.218,0.785-0.842,0.902-1.347 c2.133-0.727,4.91-4.129,6.031-6.194c1.748-0.7,4.443-0.679,5.734-2.293c1.176-1.468,0.393-3.992,1.215-6.557 c0.24-0.754,0.574-1.581,1.008-2.293c-0.611,0.011-1.348-0.061-1.959-0.608c-1.391-1.245-0.785-2.086-1.297-3.313 c1.684,0.744,2.5,2.584,4.426,2.586C-8.46,3.012-8.255,2.901-8.04,2.824c6.031-1.952,15.182-0.165,19.498-3.937 c1.15-3.933-1.24-9.846-1.229-9.938c0.008-0.062-1.314-0.004-1.803-0.258c-1.119-0.771-6.531-3.75-0.17-3.33 c0.314-0.045,0.943,0.259,1.439,0.435c-0.289-1.694-0.92-0.144-3.311-1.946c0,0-1.1-0.855-1.764-1.98 c-0.836-1.09-2.01-2.825-2.992-4.031c-1.523-2.476,1.367,0.709,1.816,1.108c1.768,1.704,1.844,3.281,3.232,3.983 c0.195,0.203,1.453,0.164,0.926-0.468c-0.525-0.632-1.367-1.278-1.775-2.341c-0.293-0.703-1.311-2.326-1.566-2.711 c-0.256-0.384-0.959-1.718-1.67-2.351c-1.047-1.187-0.268-0.902,0.521-0.07c0.789,0.834,1.537,1.821,1.672,2.023 c0.135,0.203,1.584,2.521,1.725,2.387c0.102-0.259-0.035-0.428-0.158-0.852c-0.125-0.423-0.912-2.032-0.961-2.083 c-0.357-0.852-0.566-1.908-0.598-3.333c0.4-2.375,0.648-2.486,0.549-0.705c0.014,1.143,0.031,2.215,0.602,3.247 c0.807,1.496,1.764,4.064,1.836,4.474c0.561,3.176,2.904,1.749,2.281-0.126c-0.068-0.446-0.109-2.014-0.287-2.862 c-0.18-0.849-0.219-1.688-0.113-3.056c0.066-1.389,0.232-2.055,0.277-2.299c0.285-1.023,0.4-1.088,0.408,0.135 c-0.059,0.399-0.131,1.687-0.125,2.655c0.064,0.642-0.043,1.768,0.172,2.486c0.654,1.928-0.027,3.496,1,3.514 c1.805-0.424,2.428-1.218,2.428-2.346c-0.086-0.704-0.121-0.843-0.031-1.193c0.221-0.568,0.359-0.67,0.312-0.076 c-0.055,0.287,0.031,0.533,0.082,0.794c0.264,1.197,0.912,0.114,1.283-0.782c0.15-0.238,0.539-2.154,0.545-2.522 c-0.023-0.617,0.285-0.645,0.309,0.01c0.064,0.422-0.248,2.646-0.205,2.334c-0.338,1.24-1.105,3.402-3.379,4.712 c-0.389,0.12-1.186,1.286-3.328,2.178c0,0,1.729,0.321,3.156,0.246c1.102-0.19,3.707-0.027,4.654,0.269 c1.752,0.494,1.531-0.053,4.084,0.164c2.26-0.4,2.154,2.391-1.496,3.68c-2.549,1.405-3.107,1.475-2.293,2.984 c3.484,7.906,2.865,13.183,2.193,16.466c2.41,0.271,5.732-0.62,7.301,0.725c0.506,0.333,0.648,1.866-0.457,2.86 c-4.105,2.745-9.283,7.022-13.904,7.662c-0.977-0.194,0.156-2.025,0.803-2.247l1.898-0.03c0.596-0.101,0.936-0.669,1.152-1.139 c3.16-0.404,5.045-3.775,8.246-4.818c-4.035-0.718-9.588,3.981-12.162,1.051c-5.043,1.423-11.449,1.84-15.895,1.111 c-3.105,2.687-7.934,4.021-12.115,5.866c-3.271,3.511-5.188,8.086-9.967,10.414c-0.986,0.119-0.48-1.974,0.066-2.385l1.795-0.618 C-22.995,25.682-22.849,25.035-22.788,24.521z",plane:"path://M1.112,32.559l2.998,1.205l-2.882,2.268l-2.215-0.012L1.112,32.559z M37.803,23.96 c0.158-0.838,0.5-1.509,0.961-1.904c-0.096-0.037-0.205-0.071-0.344-0.071c-0.777-0.005-2.068-0.009-3.047-0.009 c-0.633,0-1.217,0.066-1.754,0.18l2.199,1.804H37.803z M39.738,23.036c-0.111,0-0.377,0.325-0.537,0.924h1.076 C40.115,23.361,39.854,23.036,39.738,23.036z M39.934,39.867c-0.166,0-0.674,0.705-0.674,1.986s0.506,1.986,0.674,1.986 s0.672-0.705,0.672-1.986S40.102,39.867,39.934,39.867z M38.963,38.889c-0.098-0.038-0.209-0.07-0.348-0.073 c-0.082,0-0.174,0-0.268-0.001l-7.127,4.671c0.879,0.821,2.42,1.417,4.348,1.417c0.979,0,2.27-0.006,3.047-0.01 c0.139,0,0.25-0.034,0.348-0.072c-0.646-0.555-1.07-1.643-1.07-2.967C37.891,40.529,38.316,39.441,38.963,38.889z M32.713,23.96 l-12.37-10.116l-4.693-0.004c0,0,4,8.222,4.827,10.121H32.713z M59.311,32.374c-0.248,2.104-5.305,3.172-8.018,3.172H39.629 l-25.325,16.61L9.607,52.16c0,0,6.687-8.479,7.95-10.207c1.17-1.6,3.019-3.699,3.027-6.407h-2.138 c-5.839,0-13.816-3.789-18.472-5.583c-2.818-1.085-2.396-4.04-0.031-4.04h0.039l-3.299-11.371h3.617c0,0,4.352,5.696,5.846,7.5 c2,2.416,4.503,3.678,8.228,3.87h30.727c2.17,0,4.311,0.417,6.252,1.046c3.49,1.175,5.863,2.7,7.199,4.027 C59.145,31.584,59.352,32.025,59.311,32.374z M22.069,30.408c0-0.815-0.661-1.475-1.469-1.475c-0.812,0-1.471,0.66-1.471,1.475 s0.658,1.475,1.471,1.475C21.408,31.883,22.069,31.224,22.069,30.408z M27.06,30.408c0-0.815-0.656-1.478-1.466-1.478 c-0.812,0-1.471,0.662-1.471,1.478s0.658,1.477,1.471,1.477C26.404,31.885,27.06,31.224,27.06,30.408z M32.055,30.408 c0-0.815-0.66-1.475-1.469-1.475c-0.808,0-1.466,0.66-1.466,1.475s0.658,1.475,1.466,1.475 C31.398,31.883,32.055,31.224,32.055,30.408z M37.049,30.408c0-0.815-0.658-1.478-1.467-1.478c-0.812,0-1.469,0.662-1.469,1.478 s0.656,1.477,1.469,1.477C36.389,31.885,37.049,31.224,37.049,30.408z M42.039,30.408c0-0.815-0.656-1.478-1.465-1.478 c-0.811,0-1.469,0.662-1.469,1.478s0.658,1.477,1.469,1.477C41.383,31.885,42.039,31.224,42.039,30.408z M55.479,30.565 c-0.701-0.436-1.568-0.896-2.627-1.347c-0.613,0.289-1.551,0.476-2.73,0.476c-1.527,0-1.639,2.263,0.164,2.316 C52.389,32.074,54.627,31.373,55.479,30.565z",rocket:"path://M-244.396,44.399c0,0,0.47-2.931-2.427-6.512c2.819-8.221,3.21-15.709,3.21-15.709s5.795,1.383,5.795,7.325C-237.818,39.679-244.396,44.399-244.396,44.399z M-260.371,40.827c0,0-3.881-12.946-3.881-18.319c0-2.416,0.262-4.566,0.669-6.517h17.684c0.411,1.952,0.675,4.104,0.675,6.519c0,5.291-3.87,18.317-3.87,18.317H-260.371z M-254.745,18.951c-1.99,0-3.603,1.676-3.603,3.744c0,2.068,1.612,3.744,3.603,3.744c1.988,0,3.602-1.676,3.602-3.744S-252.757,18.951-254.745,18.951z M-255.521,2.228v-5.098h1.402v4.969c1.603,1.213,5.941,5.069,7.901,12.5h-17.05C-261.373,7.373-257.245,3.558-255.521,2.228zM-265.07,44.399c0,0-6.577-4.721-6.577-14.896c0-5.942,5.794-7.325,5.794-7.325s0.393,7.488,3.211,15.708C-265.539,41.469-265.07,44.399-265.07,44.399z M-252.36,45.15l-1.176-1.22L-254.789,48l-1.487-4.069l-1.019,2.116l-1.488-3.826h8.067L-252.36,45.15z",train:"path://M67.335,33.596L67.335,33.596c-0.002-1.39-1.153-3.183-3.328-4.218h-9.096v-2.07h5.371 c-4.939-2.07-11.199-4.141-14.89-4.141H19.72v12.421v5.176h38.373c4.033,0,8.457-1.035,9.142-5.176h-0.027 c0.076-0.367,0.129-0.751,0.129-1.165L67.335,33.596L67.335,33.596z M27.999,30.413h-3.105v-4.141h3.105V30.413z M35.245,30.413 h-3.104v-4.141h3.104V30.413z M42.491,30.413h-3.104v-4.141h3.104V30.413z M49.736,30.413h-3.104v-4.141h3.104V30.413z  M14.544,40.764c1.143,0,2.07-0.927,2.07-2.07V35.59V25.237c0-1.145-0.928-2.07-2.07-2.07H-9.265c-1.143,0-2.068,0.926-2.068,2.07 v10.351v3.105c0,1.144,0.926,2.07,2.068,2.07H14.544L14.544,40.764z M8.333,26.272h3.105v4.141H8.333V26.272z M1.087,26.272h3.105 v4.141H1.087V26.272z M-6.159,26.272h3.105v4.141h-3.105V26.272z M-9.265,41.798h69.352v1.035H-9.265V41.798z"},n={tooltip:{trigger:"axis",axisPointer:{type:"none"},formatter:function(l){return l[0].name+": "+l[0].value}},xAxis:{data:[e("dashboard.Baidu"),e("dashboard.Direct access"),e("dashboard.take a plane"),e("dashboard.Take the high-speed railway")],axisTick:{show:!1},axisLine:{show:!1},axisLabel:{color:"#e54035"}},yAxis:{splitLine:{show:!1},axisTick:{show:!1},axisLine:{show:!1},axisLabel:{show:!1}},color:["#e54035"],series:[{name:"hill",type:"pictorialBar",barCategoryGap:"-130%",symbol:"path://M0,10 L10,10 C5.5,10 5.5,5 5,0 C4.5,5 4.5,10 0,10 z",itemStyle:{opacity:.5},emphasis:{itemStyle:{opacity:1}},data:[123,60,25,80],z:10},{name:"glyph",type:"pictorialBar",barGap:"-100%",symbolPosition:"end",symbolSize:50,symbolOffset:[0,"-120%"],data:[{value:123,symbol:i.reindeer,symbolSize:[60,60]},{value:60,symbol:i.rocket,symbolSize:[50,60]},{value:25,symbol:i.plane,symbolSize:[65,35]},{value:80,symbol:i.train,symbolSize:[50,30]}]}]};o.setOption(n),r.charts.push(o)},T=()=>{const o=A(p.value[3]),i=l(50),n={tooltip:{trigger:"item",formatter:"{a} <br/>{b} : {c} ({d}%)"},legend:{type:"scroll",orient:"vertical",right:10,top:20,bottom:20,data:i.legendData,textStyle:{color:"#73767a"}},series:[{name:e("dashboard.full name"),type:"pie",radius:"55%",center:["40%","50%"],data:i.seriesData,emphasis:{itemStyle:{shadowBlur:10,shadowOffsetX:0,shadowColor:"rgba(0, 0, 0, 0.5)"}}}]};function l(f){const v=["赵","钱","孙","李","周","吴","郑","王","冯","陈","褚","卫","蒋","沈","韩","杨","朱","秦","尤","许","何","吕","施","张","孔","曹","严","华","金","魏","陶","姜","戚","谢","邹","喻","柏","水","窦","章","云","苏","潘","葛","奚","范","彭","郎","鲁","韦","昌","马","苗","凤","花","方","俞","任","袁","柳","酆","鲍","史","唐","费","廉","岑","薛","雷","贺","倪","汤","滕","殷","罗","毕","郝","邬","安","常","乐","于","时","傅","皮","卞","齐","康","伍","余","元","卜","顾","孟","平","黄","和","穆","萧","尹","姚","邵","湛","汪","祁","毛","禹","狄","米","贝","明","臧","计","伏","成","戴","谈","宋","茅","庞","熊","纪","舒","屈","项","祝","董","梁","杜","阮","蓝","闵","席","季","麻","强","贾","路","娄","危"],E=[],L=[];for(var U=0;U<f;U++){var W=Math.random()>.65?N(4,1)+"·"+N(3,0):N(2,1);E.push(W),L.push({name:W,value:Math.round(Math.random()*1e5)})}return{legendData:E,seriesData:L};function N(R,Y){const q=Math.ceil(Math.random()*R+Y),B=[];for(var G=0;G<q;G++)B.push(v[Math.round(Math.random()*v.length-1)]);return B.join("")}}o.setOption(n),r.charts.push(o)},V=()=>{H(()=>{for(const o in r.charts)r.charts[o].resize()})},C=()=>{const o=parseInt((new Date().getTime()/1e3).toString()),i=x.get(k);r.pauseWork?(i.pauseTime+=o-i.startPauseTime,i.startPauseTime=0,x.set(k,i),r.pauseWork=!1,M()):(i.startPauseTime=o,x.set(k,i),clearInterval(a),r.pauseWork=!0)},M=()=>{const o=x.get(k)||{date:"",startTime:0,pauseTime:0,startPauseTime:0},i=h.getFullYear()+"-"+(h.getMonth()+1)+"-"+h.getDate(),n=parseInt((new Date().getTime()/1e3).toString());o.date!=i&&(o.date=i,o.startTime=n,o.pauseTime=o.startPauseTime=0,x.set(k,o));let l=0;o.startPauseTime<=0?(r.pauseWork=!1,l=0):(r.pauseWork=!0,l=n-o.startPauseTime);let f=n-o.startTime-o.pauseTime-l;r.workingTimeFormat=O(f),r.pauseWork||(a=window.setInterval(()=>{f++,r.workingTimeFormat=O(f)},1e3))},O=o=>{var i=0,n=0,l=0,f=0,v="";return o<60?i=o:(n=Math.floor(o/60),i=Math.floor(o%60),n>=60&&(l=Math.floor(n/60),n=Math.floor(n%60),l>=24&&(f=Math.floor(l/24),l=Math.floor(l%24)))),v=l+e("dashboard.hour")+((n>=10?n:"0"+n)+e("dashboard.minute"))+((i>=10?i:"0"+i)+e("dashboard.second")),f>0&&(v=f+e("dashboard.day")+v),v};return ot(()=>{V()}),nt(()=>{M(),y(),I(),S(),z(),T(),Q(window,"resize",V)}),it(()=>{for(const o in r.charts)r.charts[o].dispose()}),rt(()=>{clearInterval(a)}),lt(()=>t.state.tabFullScreen,()=>{V()}),(o,i)=>{const n=F("el-col"),l=F("el-row"),f=F("Icon"),v=F("el-card"),E=F("el-scrollbar");return ct(),dt("div",bt,[s("div",wt,[c(l,{gutter:10},{default:u(()=>[c(n,{md:24,lg:18},{default:u(()=>[s("div",Vt,[s("img",{class:"welcome-img",src:d(pt),alt:""},null,8,yt),s("div",Mt,[s("div",St,b(d(_).nickname+d(e)("utils.comma")+d(Z)()),1),s("div",Tt,b(r.remark),1)])])]),_:1}),c(n,{lg:6,class:"hidden-md-and-down"},{default:u(()=>[s("div",xt,[s("img",{class:"working-coffee",src:d(ft),alt:""},null,8,kt),s("div",Ft,[ht(b(d(e)("dashboard.You have worked today")),1),s("span",zt,b(r.workingTimeFormat),1)]),s("div",{onClick:i[0]||(i[0]=L=>C()),class:"working-opt working-rest"},b(r.pauseWork?d(e)("dashboard.Continue to work"):d(e)("dashboard.have a bit of rest")),1)])]),_:1})]),_:1})]),s("div",Ct,[c(l,{gutter:20},{default:u(()=>[c(n,{sm:12,lg:6},{default:u(()=>[s("div",Et,[s("div",At,b(d(e)("dashboard.Member registration")),1),s("div",Dt,[s("div",It,[c(f,{color:"#8595F4",size:"20",name:"fa fa-line-chart"}),Lt]),Nt])])]),_:1}),c(n,{sm:12,lg:6},{default:u(()=>[s("div",Pt,[s("div",Ot,b(d(e)("dashboard.Number of attachments Uploaded")),1),s("div",Ut,[s("div",Wt,[c(f,{color:"#AD85F4",size:"20",name:"fa fa-file-text"}),Bt]),Gt])])]),_:1}),c(n,{sm:12,lg:6},{default:u(()=>[s("div",Ht,[s("div",Rt,b(d(e)("dashboard.Total number of members")),1),s("div",Yt,[s("div",qt,[c(f,{color:"#74A8B5",size:"20",name:"fa fa-users"}),jt]),Jt])])]),_:1}),c(n,{sm:12,lg:6},{default:u(()=>[s("div",Kt,[s("div",Xt,b(d(e)("dashboard.Number of installed plug-ins")),1),s("div",$t,[s("div",Qt,[c(f,{color:"#F48595",size:"20",name:"fa fa-object-group"}),Zt]),ts])])]),_:1})]),_:1})]),s("div",ss,[c(l,{gutter:20},{default:u(()=>[c(n,{class:"lg-mb-20",xs:24,sm:24,md:12,lg:9},{default:u(()=>[c(v,{shadow:"hover",header:d(e)("dashboard.Membership growth")},{default:u(()=>[s("div",{class:"user-growth-chart",ref:d(p).set},null,512)]),_:1},8,["header"])]),_:1}),c(n,{class:"lg-mb-20",xs:24,sm:24,md:12,lg:9},{default:u(()=>[c(v,{shadow:"hover",header:d(e)("dashboard.Annex growth")},{default:u(()=>[s("div",{class:"file-growth-chart",ref:d(p).set},null,512)]),_:1},8,["header"])]),_:1}),c(n,{xs:24,sm:24,md:24,lg:6},{default:u(()=>[c(v,{class:"new-user-card",shadow:"hover",header:d(e)("dashboard.New member")},{default:u(()=>[s("div",es,[c(E,null,{default:u(()=>[s("div",as,[os,s("div",ns,[is,s("div",rs,"12分钟前"+b(d(e)("dashboard.Joined us")),1)]),c(f,{class:"new-user-arrow",color:"#8595F4",name:"fa fa-angle-right"})]),s("div",ls,[cs,s("div",ds,[hs,s("div",us,"12分钟前"+b(d(e)("dashboard.Joined us")),1)]),c(f,{class:"new-user-arrow",color:"#8595F4",name:"fa fa-angle-right"})]),s("div",ms,[ps,s("div",fs,[_s,s("div",gs,"12分钟前"+b(d(e)("dashboard.Joined us")),1)]),c(f,{class:"new-user-arrow",color:"#8595F4",name:"fa fa-angle-right"})]),s("div",vs,[s("img",{class:"new-user-avatar",src:d(tt)("/static/images/avatar.png"),alt:""},null,8,bs),s("div",ws,[Vs,s("div",ys,"12分钟前"+b(d(e)("dashboard.Joined us")),1)]),c(f,{class:"new-user-arrow",color:"#8595F4",name:"fa fa-angle-right"})])]),_:1})])]),_:1},8,["header"])]),_:1})]),_:1})]),s("div",Ms,[c(l,{gutter:20},{default:u(()=>[c(n,{class:"lg-mb-20",xs:24,sm:24,md:24,lg:12},{default:u(()=>[c(v,{shadow:"hover",header:d(e)("dashboard.Member source")},{default:u(()=>[s("div",{class:"user-source-chart",ref:d(p).set},null,512)]),_:1},8,["header"])]),_:1}),c(n,{class:"lg-mb-20",xs:24,sm:24,md:24,lg:12},{default:u(()=>[c(v,{shadow:"hover",header:d(e)("dashboard.Member last name")},{default:u(()=>[s("div",{class:"user-surname-chart",ref:d(p).set},null,512)]),_:1},8,["header"])]),_:1})]),_:1})])])}}});const zs=st(Ss,[["__scopeId","data-v-625c9aa0"]]);export{zs as default};
