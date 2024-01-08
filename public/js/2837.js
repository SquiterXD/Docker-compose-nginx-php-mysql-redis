(self.webpackChunk=self.webpackChunk||[]).push([[2837],{29040:(e,t,i)=>{"use strict";i.d(t,{Z:()=>r});var o=i(23645),n=i.n(o)()((function(e){return e[1]}));n.push([e.id,".vld-overlay,.vld-shown{overflow:hidden}.vld-overlay{bottom:0;left:0;position:absolute;right:0;top:0;align-items:center;display:none;justify-content:center;z-index:9999}.vld-overlay.is-active{display:flex}.vld-overlay.is-full-page{z-index:9999;position:fixed}.vld-overlay .vld-background{bottom:0;left:0;position:absolute;right:0;top:0;background:#fff;opacity:.5}.vld-overlay .vld-icon,.vld-parent{position:relative}",""]);const r=n},19371:(e,t,i)=>{"use strict";var o=i(93379),n=i.n(o),r=i(29040),a={insert:"head",singleton:!1};n()(r.Z,a),r.Z.locals},52837:(e,t,i)=>{"use strict";i.r(t),i.d(t,{default:()=>a});var o=i(7398),n=i.n(o);i(19371),i(30381);const r={props:["periodYears","periodYearValue","versionNos","cigVersions","filterVersions","versionNoValue","planVersionNos","planVersionNoValue","periodNameFroms","periodNameFromValue","periodNameTos","periodNameToValue","accountTypes","accountTypeValue"],components:{Loading:n()},data:function(){return{periodYear:this.periodYearValue,versionNo:this.versionNoValue,planVersionNo:this.planVersionNoValue,periodNameFrom:this.periodNameFromValue,periodNameTo:this.periodNameToValue,accountType:this.accountTypeValue,versionNoOptions:[],planVersionNoOptions:[],periodNameFromOptions:[],periodNameToOptions:[],accountTypeOptions:this.accountTypes}},mounted:function(){this.periodYearValue&&(this.filterVersionOptions(this.periodYearValue),this.filterPlanVersionNoOptions(this.periodYearValue),this.filterPeriodNameFromOptions(this.periodYearValue),this.filterPeriodNameToOptions(this.periodYearValue))},methods:{setUrlParams:function(){var e=new URLSearchParams(window.location.search);e.set("period_year",this.periodYear?this.periodYear:""),e.set("version_no",this.versionNo?this.versionNo:""),e.set("plan_version_no",this.planVersionNo?this.planVersionNo:""),e.set("period_name_from",this.periodNameFrom?this.periodNameFrom:""),e.set("period_name_to",this.periodNameTo?this.periodNameTo:""),e.set("account_type",this.accountType?this.accountType:""),window.history.replaceState(null,null,"?"+e.toString())},onPeriodYearChanged:function(e){this.periodYear=e,this.filterVersionOptions(this.periodYear),this.versionNoOptions.length>0&&(this.versionNo=this.versionNoOptions[0].version_no),this.filterPlanVersionNoOptions(this.periodYear),this.planVersionNoOptions.length>0&&(this.planVersionNo=this.planVersionNoOptions[0].plan_version_no),this.filterPeriodNameFromOptions(this.periodYear),this.periodNameFromOptions.length>0&&(this.periodNameFrom=this.periodNameFromOptions[0].period_name_value),this.filterPeriodNameToOptions(this.periodYear),this.periodNameToOptions.length>0&&(this.periodNameTo=this.periodNameToOptions[this.periodNameToOptions.length-1].period_name_value),this.setUrlParams()},onVersionNoChanged:function(e){this.versionNo=e,this.setUrlParams()},onPlanVersionNoChanged:function(e){this.planVersionNo=e,this.setUrlParams()},onPeriodNameFromChanged:function(e){this.periodNameFrom=e,this.setUrlParams()},onPeriodNameToChanged:function(e){this.periodNameTo=e,this.setUrlParams()},onAccountTypeChanged:function(e){this.accountType=e,this.setUrlParams()},filterVersionOptions:function(e){this.versionNoOptions=e?this.versionNos.filter((function(t){return t.period_year==e})):[]},filterPlanVersionNoOptions:function(e){this.planVersionNoOptions=e?this.planVersionNos.filter((function(t){return t.period_year==e})):[]},filterPeriodNameFromOptions:function(e){this.periodNameFromOptions=e?this.periodNameFroms.filter((function(t){return t.period_year==e})):[]},filterPeriodNameToOptions:function(e){this.periodNameToOptions=e?this.periodNameTos.filter((function(t){return t.period_year==e})):[]}}};const a=(0,i(51900).Z)(r,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"row"},[i("div",{staticClass:"offset-md-2 col-md-8"},[i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ปี ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"period_year",id:"input_period_year",placeholder:"ปี ","option-key":"period_year_value","option-value":"period_year_value","option-label":"period_year_label","select-options":e.periodYears,clearable:!1,filterable:!0,value:e.periodYear},on:{onSelected:function(t){return e.onPeriodYearChanged(t)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ครั้งที่กระดาษปันส่วน ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"version_no",id:"input_version_no",placeholder:"ครั้งที่กระดาษปันส่วน ","option-key":"version_no","option-value":"version_no","option-label":"version_no","select-options":e.versionNoOptions,clearable:!1,filterable:!0,value:e.versionNo},on:{onSelected:function(t){return e.onVersionNoChanged(t)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ครั้งที่กระดาษทำการ ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"plan_version_no",id:"input_plan_version_no",placeholder:"ครั้งที่กระดาษทำการ ","option-key":"plan_version_no","option-value":"plan_version_no","option-label":"plan_version_no","select-options":e.planVersionNoOptions,clearable:!1,filterable:!0,value:e.planVersionNo},on:{onSelected:function(t){return e.onPlanVersionNoChanged(t)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" เปรียบเทียบค่าใช้จ่ายจริงจาก ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"period_name_from",id:"input_period_name_from",placeholder:"เปรียบเทียบค่าใช้จ่ายจริงจาก ","option-key":"period_name_value","option-value":"period_name_value","option-label":"period_name_label","select-options":e.periodNameFromOptions,clearable:!1,filterable:!0,value:e.periodNameFrom},on:{onSelected:function(t){return e.onPeriodNameFromChanged(t)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" เปรียบเทียบค่าใช้จ่ายจริงถึง ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"period_name_to",id:"input_period_name_to",placeholder:"เปรียบเทียบค่าใช้จ่ายจริงถึง ","option-key":"period_name_value","option-value":"period_name_value","option-label":"period_name_label","select-options":e.periodNameToOptions,clearable:!1,filterable:!0,value:e.periodNameTo},on:{onSelected:function(t){return e.onPeriodNameToChanged(t)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ประเภทบัญชี ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"account_type",id:"input_account_type",placeholder:"ประเภทบัญชี ","option-key":"account_type","option-value":"account_type","option-label":"description","select-options":e.accountTypeOptions,clearable:!1,filterable:!0,value:e.accountType},on:{onSelected:function(t){return e.onAccountTypeChanged(t)}}})],1)])]),e._v(" "),i("div",{staticClass:"offset-md-2 col-md-8 text-right tw-mt-2 tw-mb-4"},[i("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"submit",disabled:!(e.periodYear&&e.versionNo&&e.planVersionNo&&e.periodNameFrom&&e.periodNameTo)}},[i("i",{staticClass:"fa fa fa-file-pdf-o tw-mr-1"}),e._v(" Export PDF\n        ")])])])}),[],!1,null,null,null).exports},7398:function(e){"undefined"!=typeof self&&self,e.exports=function(e){var t={};function i(o){if(t[o])return t[o].exports;var n=t[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,i),n.l=!0,n.exports}return i.m=e,i.c=t,i.d=function(e,t,o){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(i.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(o,n,function(t){return e[t]}.bind(null,n));return o},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="",i(i.s=1)}([function(e,t,i){},function(e,t,i){"use strict";i.r(t);var o="undefined"!=typeof window?window.HTMLElement:Object,n={mounted:function(){this.enforceFocus&&document.addEventListener("focusin",this.focusIn)},methods:{focusIn:function(e){if(this.isActive&&e.target!==this.$el&&!this.$el.contains(e.target)){var t=this.container?this.container:this.isFullPage?null:this.$el.parentElement;(this.isFullPage||t&&t.contains(e.target))&&(e.preventDefault(),this.$el.focus())}}},beforeDestroy:function(){document.removeEventListener("focusin",this.focusIn)}};function r(e,t,i,o,n,r,a,s){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=i,c._compiled=!0),o&&(c.functional=!0),r&&(c._scopeId="data-v-"+r),a?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(a)},c._ssrRegister=l):n&&(l=s?function(){n.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(e,t){return l.call(t),d(e,t)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,l):[l]}return{exports:e,options:c}}var a=r({name:"spinner",props:{color:{type:String,default:"#000"},height:{type:Number,default:64},width:{type:Number,default:64}}},(function(){var e=this.$createElement,t=this._self._c||e;return t("svg",{attrs:{viewBox:"0 0 38 38",xmlns:"http://www.w3.org/2000/svg",width:this.width,height:this.height,stroke:this.color}},[t("g",{attrs:{fill:"none","fill-rule":"evenodd"}},[t("g",{attrs:{transform:"translate(1 1)","stroke-width":"2"}},[t("circle",{attrs:{"stroke-opacity":".25",cx:"18",cy:"18",r:"18"}}),t("path",{attrs:{d:"M36 18c0-9.94-8.06-18-18-18"}},[t("animateTransform",{attrs:{attributeName:"transform",type:"rotate",from:"0 18 18",to:"360 18 18",dur:"0.8s",repeatCount:"indefinite"}})],1)])])])}),[],!1,null,null,null).exports,s=r({name:"dots",props:{color:{type:String,default:"#000"},height:{type:Number,default:240},width:{type:Number,default:60}}},(function(){var e=this.$createElement,t=this._self._c||e;return t("svg",{attrs:{viewBox:"0 0 120 30",xmlns:"http://www.w3.org/2000/svg",fill:this.color,width:this.width,height:this.height}},[t("circle",{attrs:{cx:"15",cy:"15",r:"15"}},[t("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),t("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})]),t("circle",{attrs:{cx:"60",cy:"15",r:"9","fill-opacity":"0.3"}},[t("animate",{attrs:{attributeName:"r",from:"9",to:"9",begin:"0s",dur:"0.8s",values:"9;15;9",calcMode:"linear",repeatCount:"indefinite"}}),t("animate",{attrs:{attributeName:"fill-opacity",from:"0.5",to:"0.5",begin:"0s",dur:"0.8s",values:".5;1;.5",calcMode:"linear",repeatCount:"indefinite"}})]),t("circle",{attrs:{cx:"105",cy:"15",r:"15"}},[t("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),t("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})])])}),[],!1,null,null,null).exports,l=r({name:"bars",props:{color:{type:String,default:"#000"},height:{type:Number,default:40},width:{type:Number,default:40}}},(function(){var e=this.$createElement,t=this._self._c||e;return t("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 30 30",height:this.height,width:this.width,fill:this.color}},[t("rect",{attrs:{x:"0",y:"13",width:"4",height:"5"}},[t("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}}),t("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}})]),t("rect",{attrs:{x:"10",y:"13",width:"4",height:"5"}},[t("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}}),t("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}})]),t("rect",{attrs:{x:"20",y:"13",width:"4",height:"5"}},[t("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}}),t("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}})])])}),[],!1,null,null,null).exports,c=r({name:"vue-loading",mixins:[n],props:{active:Boolean,programmatic:Boolean,container:[Object,Function,o],isFullPage:{type:Boolean,default:!0},enforceFocus:{type:Boolean,default:!0},lockScroll:{type:Boolean,default:!1},transition:{type:String,default:"fade"},canCancel:Boolean,onCancel:{type:Function,default:function(){}},color:String,backgroundColor:String,blur:{type:String,default:"2px"},opacity:Number,width:Number,height:Number,zIndex:Number,loader:{type:String,default:"spinner"}},data:function(){return{isActive:this.active}},components:{Spinner:a,Dots:s,Bars:l},beforeMount:function(){this.programmatic&&(this.container?(this.isFullPage=!1,this.container.appendChild(this.$el)):document.body.appendChild(this.$el))},mounted:function(){this.programmatic&&(this.isActive=!0),document.addEventListener("keyup",this.keyPress)},methods:{cancel:function(){this.canCancel&&this.isActive&&(this.hide(),this.onCancel.apply(null,arguments))},hide:function(){var e=this;this.$emit("hide"),this.$emit("update:active",!1),this.programmatic&&(this.isActive=!1,setTimeout((function(){var t;e.$destroy(),void 0!==(t=e.$el).remove?t.remove():t.parentNode.removeChild(t)}),150))},disableScroll:function(){this.isFullPage&&this.lockScroll&&document.body.classList.add("vld-shown")},enableScroll:function(){this.isFullPage&&this.lockScroll&&document.body.classList.remove("vld-shown")},keyPress:function(e){27===e.keyCode&&this.cancel()}},watch:{active:function(e){this.isActive=e},isActive:function(e){e?this.disableScroll():this.enableScroll()}},computed:{bgStyle:function(){return{background:this.backgroundColor,opacity:this.opacity,backdropFilter:"blur(".concat(this.blur,")")}}},beforeDestroy:function(){document.removeEventListener("keyup",this.keyPress)}},(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("transition",{attrs:{name:e.transition}},[i("div",{directives:[{name:"show",rawName:"v-show",value:e.isActive,expression:"isActive"}],staticClass:"vld-overlay is-active",class:{"is-full-page":e.isFullPage},style:{zIndex:e.zIndex},attrs:{tabindex:"0","aria-busy":e.isActive,"aria-label":"Loading"}},[i("div",{staticClass:"vld-background",style:e.bgStyle,on:{click:function(t){return t.preventDefault(),e.cancel(t)}}}),i("div",{staticClass:"vld-icon"},[e._t("before"),e._t("default",[i(e.loader,{tag:"component",attrs:{color:e.color,width:e.width,height:e.height}})]),e._t("after")],2)])])}),[],!1,null,null,null).exports,d=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return{show:function(){var o=arguments.length>0&&void 0!==arguments[0]?arguments[0]:t,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:i,r={programmatic:!0},a=Object.assign({},t,o,r),s=new(e.extend(c))({el:document.createElement("div"),propsData:a}),l=Object.assign({},i,n);return Object.keys(l).map((function(e){s.$slots[e]=l[e]})),s}}};i(0),c.install=function(e){var t=d(e,arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},arguments.length>2&&void 0!==arguments[2]?arguments[2]:{});e.$loading=t,e.prototype.$loading=t},t.default=c}]).default}}]);