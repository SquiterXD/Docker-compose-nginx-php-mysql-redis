(self.webpackChunk=self.webpackChunk||[]).push([[1119],{61119:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>c});var n=r(87757),a=r.n(n);function o(t,e,r,n,a,o,s){try{var i=t[o](s),c=i.value}catch(t){return void r(t)}i.done?e(c):Promise.resolve(c).then(n,a)}function s(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var s=t.apply(e,r);function i(t){o(s,n,a,i,c,"next",t)}function c(t){o(s,n,a,i,c,"throw",t)}i(void 0)}))}}const i={props:["url","trans-date","trans-btn"],data:function(){return{options:[],value:[],list:[],loading:!1,states:[],infos:[],programs:[],infoAttributes:[]}},mounted:function(){},methods:{remoteMethod:function(t){var e=this;return s(a().mark((function r(){return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:axios.get(e.url.getInfor+"?query="+t).then((function(t){e.infos=t.data.ptirReportInfos,e.programs=t.data.programs})).then((function(){e.remote(t)})).catch((function(t){}));case 1:case"end":return r.stop()}}),r)})))()},remote:function(t){var e=this;return s(a().mark((function r(){return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:""!==t?(e.loading=!0,setTimeout((function(){e.loading=!1,e.options=e.programs.filter((function(e){return e.program_code.toLowerCase().indexOf(t.toLowerCase())>-1}))}),200)):e.options=[];case 1:case"end":return r.stop()}}),r)})))()},getData:function(t){var e=this;return s(a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:axios.get(e.url.getInfor).then((function(t){e.infos=t.data.ptirReportInfos,e.programs=t.data.programs})).then((function(){e.list=e.infos.map((function(t){return{value:"value:".concat(t.program_code),label:"label:".concat(t.program_code)}}))})).catch((function(t){}));case 1:case"end":return t.stop()}}),t)})))()},getInfos:function(){var t=this;return s(a().mark((function e(){return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:axios.get(t.url.getInfoAttribute+"?program_code="+t.value).then((function(e){t.infoAttributes=e.data.reportInfor})).then((function(){})).catch((function(t){}));case 1:case"end":return e.stop()}}),e)})))()},getYear:function(t){},exportReport:function(){}}};const c=(0,r(51900).Z)(i,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("el-select",{staticClass:"col-11",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"Please enter a report ","remote-method":t.remoteMethod},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.options,(function(t){return r("el-option",{key:t.program_code,attrs:{label:t.program_code,value:t.program_code}})})),1),t._v(" "),r("button",{staticClass:"btn btn-primary",on:{click:t.getInfos}},[t._v("Search ")]),t._v(" "),r("form",{attrs:{action:t.url.getParam,method:"get"}},[r("hr",{staticClass:"m-3"}),t._v(" "),t.infoAttributes.length>0?r("div",{staticClass:"form-group"},[t._l(t.infoAttributes,(function(e,n){return r("div",{key:n},["text"==e.form_type?r("div",{staticClass:"row m-2"},[r("div",{staticClass:"m-1 col-3 text-right"},[r("div",[t._v(t._s(e.display_value))])]),t._v(" "),r("div",{staticClass:"col-6"},[r("input",{staticClass:"form-control w-100 ",attrs:{type:"text",name:e.attribute_name}})])]):t._e(),t._v(" "),"date"==e.form_type?r("div",{staticClass:"row m-2"},[r("div",{staticClass:"m-1 col-3 text-right"},[r("div",[t._v("\n                            "+t._s(e.display_value)+"\n                        ")])]),t._v(" "),r("div",{staticClass:"col-6"},[r("datepicker-th",{staticClass:"form-control col-lg-12",staticStyle:{width:"100%","border-radius":"3px"},attrs:{placeholder:"เลือกวัน",name:e.attribute_name,id:"input_date",pType:"year",format:t.transDate["js-year-format"]},on:{dateWasSelected:t.getYear},model:{value:e.attribute_name,callback:function(r){t.$set(e,"attribute_name",r)},expression:"infoAttribute.attribute_name"}})],1)]):t._e(),t._v(" "),"select"==e.form_type?r("div",{staticClass:"row m-2"},[r("div",{staticClass:"m-1 col-3 text-right"},[r("div",[t._v(t._s(e.display_value))])]),t._v(" "),r("div",{staticClass:"col-6"},[r("select",{staticClass:"form-control w-100",attrs:{name:e.attribute_name}},t._l(e.lists,(function(e){return r("option",{key:e.value,domProps:{value:e.value}},[t._v(t._s(e.label)+"\n                            ")])})),0)])]):t._e()])})),t._v(" "),r("input",{attrs:{type:"hidden",name:"program_code"},domProps:{value:t.value}}),t._v(" "),t._m(0)],2):t._e()])],1)}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("button",{staticClass:"btn btn-primary mt-4",attrs:{type:"submit"}},[t._v("Export")])])}],!1,null,null,null).exports}}]);