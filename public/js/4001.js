(self.webpackChunk=self.webpackChunk||[]).push([[4001],{4001:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>a});var i=n(7398);const s={props:["reportItems"],components:{Loading:n.n(i)()},data:function(){return{isLoading:!1}},methods:{}};const a=(0,n(51900).Z)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"table-responsive"},[n("table",{staticClass:"table table-bordered tw-text-xs"},[t._m(0),t._v(" "),t.reportItems.length>0?n("tbody",[t._l(t.reportItems,(function(e,i){return[n("tr",{key:i,attrs:{clsss:"tw-text-xs"}},[n("td",{staticClass:"text-center"},[t._v(" "+t._s(i+1)+" ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v(" \n                        "+t._s(e.date_drawn_formatted)+" \n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.time_drawn_formatted)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.sample_no)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.brand_desc)+"\n                    ")]),t._v(" "),n("td",[t._v("\n                        "+t._s(e.test_desc)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.result_value)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.test_unit_desc)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.locator_desc)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.severity_level?e.severity_level:"-")+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.remark)+"\n                    ")]),t._v(" "),n("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._l(e.attachments,(function(t,e){return[n("a",{key:e,staticClass:"tw-m-1",attrs:{href:"/qm/files/image/qm/finished-products/result-quality-line/"+t.file_name,target:"_blank"}},[n("span",{staticClass:"fa fa-picture-o"})])]}))],2)])]}))],2):n("tbody",[t._m(1)])])])}),[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",[n("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" รายการ ")]),t._v(" "),n("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" วันที่ ")]),t._v(" "),n("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{width:"5%"}},[t._v(" เวลา ")]),t._v(" "),n("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{width:"10%"}},[t._v(" เลขที่การตรวจสอบ ")]),t._v(" "),n("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" ตราบุหรี่ ")]),t._v(" "),n("th",{attrs:{width:"12%"}},[t._v(" ปัญหา/ข้อบกพร่อง ")]),t._v(" "),n("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" จำนวน ")]),t._v(" "),n("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" หน่วยนับ ")]),t._v(" "),n("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{width:"12%"}},[t._v("\n                    สถานที่พบ\n                ")]),t._v(" "),n("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" ระดับความรุนแรงของความผิดปกติ (จำนวน) ")]),t._v(" "),n("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{width:"10%"}},[t._v("\n                    หมายเหตุ\n                ")]),t._v(" "),n("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{width:"15%"}},[t._v("\n                    รูปภาพประกอบ\n                ")])])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("tr",[n("td",{attrs:{colspan:"11"}},[n("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports},7398:function(t){"undefined"!=typeof self&&self,t.exports=function(t){var e={};function n(i){if(e[i])return e[i].exports;var s=e[i]={i,l:!1,exports:{}};return t[i].call(s.exports,s,s.exports,n),s.l=!0,s.exports}return n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var s in t)n.d(i,s,function(e){return t[e]}.bind(null,s));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=1)}([function(t,e,n){},function(t,e,n){"use strict";n.r(e);var i="undefined"!=typeof window?window.HTMLElement:Object,s={mounted:function(){this.enforceFocus&&document.addEventListener("focusin",this.focusIn)},methods:{focusIn:function(t){if(this.isActive&&t.target!==this.$el&&!this.$el.contains(t.target)){var e=this.container?this.container:this.isFullPage?null:this.$el.parentElement;(this.isFullPage||e&&e.contains(t.target))&&(t.preventDefault(),this.$el.focus())}}},beforeDestroy:function(){document.removeEventListener("focusin",this.focusIn)}};function a(t,e,n,i,s,a,r,l){var o,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=n,c._compiled=!0),i&&(c.functional=!0),a&&(c._scopeId="data-v-"+a),r?(o=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),s&&s.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},c._ssrRegister=o):s&&(o=l?function(){s.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:s),o)if(c.functional){c._injectStyles=o;var d=c.render;c.render=function(t,e){return o.call(e),d(t,e)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,o):[o]}return{exports:t,options:c}}var r=a({name:"spinner",props:{color:{type:String,default:"#000"},height:{type:Number,default:64},width:{type:Number,default:64}}},(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{viewBox:"0 0 38 38",xmlns:"http://www.w3.org/2000/svg",width:this.width,height:this.height,stroke:this.color}},[e("g",{attrs:{fill:"none","fill-rule":"evenodd"}},[e("g",{attrs:{transform:"translate(1 1)","stroke-width":"2"}},[e("circle",{attrs:{"stroke-opacity":".25",cx:"18",cy:"18",r:"18"}}),e("path",{attrs:{d:"M36 18c0-9.94-8.06-18-18-18"}},[e("animateTransform",{attrs:{attributeName:"transform",type:"rotate",from:"0 18 18",to:"360 18 18",dur:"0.8s",repeatCount:"indefinite"}})],1)])])])}),[],!1,null,null,null).exports,l=a({name:"dots",props:{color:{type:String,default:"#000"},height:{type:Number,default:240},width:{type:Number,default:60}}},(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{viewBox:"0 0 120 30",xmlns:"http://www.w3.org/2000/svg",fill:this.color,width:this.width,height:this.height}},[e("circle",{attrs:{cx:"15",cy:"15",r:"15"}},[e("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})]),e("circle",{attrs:{cx:"60",cy:"15",r:"9","fill-opacity":"0.3"}},[e("animate",{attrs:{attributeName:"r",from:"9",to:"9",begin:"0s",dur:"0.8s",values:"9;15;9",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"0.5",to:"0.5",begin:"0s",dur:"0.8s",values:".5;1;.5",calcMode:"linear",repeatCount:"indefinite"}})]),e("circle",{attrs:{cx:"105",cy:"15",r:"15"}},[e("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})])])}),[],!1,null,null,null).exports,o=a({name:"bars",props:{color:{type:String,default:"#000"},height:{type:Number,default:40},width:{type:Number,default:40}}},(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 30 30",height:this.height,width:this.width,fill:this.color}},[e("rect",{attrs:{x:"0",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}})]),e("rect",{attrs:{x:"10",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}})]),e("rect",{attrs:{x:"20",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}})])])}),[],!1,null,null,null).exports,c=a({name:"vue-loading",mixins:[s],props:{active:Boolean,programmatic:Boolean,container:[Object,Function,i],isFullPage:{type:Boolean,default:!0},enforceFocus:{type:Boolean,default:!0},lockScroll:{type:Boolean,default:!1},transition:{type:String,default:"fade"},canCancel:Boolean,onCancel:{type:Function,default:function(){}},color:String,backgroundColor:String,blur:{type:String,default:"2px"},opacity:Number,width:Number,height:Number,zIndex:Number,loader:{type:String,default:"spinner"}},data:function(){return{isActive:this.active}},components:{Spinner:r,Dots:l,Bars:o},beforeMount:function(){this.programmatic&&(this.container?(this.isFullPage=!1,this.container.appendChild(this.$el)):document.body.appendChild(this.$el))},mounted:function(){this.programmatic&&(this.isActive=!0),document.addEventListener("keyup",this.keyPress)},methods:{cancel:function(){this.canCancel&&this.isActive&&(this.hide(),this.onCancel.apply(null,arguments))},hide:function(){var t=this;this.$emit("hide"),this.$emit("update:active",!1),this.programmatic&&(this.isActive=!1,setTimeout((function(){var e;t.$destroy(),void 0!==(e=t.$el).remove?e.remove():e.parentNode.removeChild(e)}),150))},disableScroll:function(){this.isFullPage&&this.lockScroll&&document.body.classList.add("vld-shown")},enableScroll:function(){this.isFullPage&&this.lockScroll&&document.body.classList.remove("vld-shown")},keyPress:function(t){27===t.keyCode&&this.cancel()}},watch:{active:function(t){this.isActive=t},isActive:function(t){t?this.disableScroll():this.enableScroll()}},computed:{bgStyle:function(){return{background:this.backgroundColor,opacity:this.opacity,backdropFilter:"blur(".concat(this.blur,")")}}},beforeDestroy:function(){document.removeEventListener("keyup",this.keyPress)}},(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("transition",{attrs:{name:t.transition}},[n("div",{directives:[{name:"show",rawName:"v-show",value:t.isActive,expression:"isActive"}],staticClass:"vld-overlay is-active",class:{"is-full-page":t.isFullPage},style:{zIndex:t.zIndex},attrs:{tabindex:"0","aria-busy":t.isActive,"aria-label":"Loading"}},[n("div",{staticClass:"vld-background",style:t.bgStyle,on:{click:function(e){return e.preventDefault(),t.cancel(e)}}}),n("div",{staticClass:"vld-icon"},[t._t("before"),t._t("default",[n(t.loader,{tag:"component",attrs:{color:t.color,width:t.width,height:t.height}})]),t._t("after")],2)])])}),[],!1,null,null,null).exports,d=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return{show:function(){var i=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,s=arguments.length>1&&void 0!==arguments[1]?arguments[1]:n,a={programmatic:!0},r=Object.assign({},e,i,a),l=new(t.extend(c))({el:document.createElement("div"),propsData:r}),o=Object.assign({},n,s);return Object.keys(o).map((function(t){l.$slots[t]=o[t]})),l}}};n(0),c.install=function(t){var e=d(t,arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},arguments.length>2&&void 0!==arguments[2]?arguments[2]:{});t.$loading=e,t.prototype.$loading=e},e.default=c}]).default}}]);