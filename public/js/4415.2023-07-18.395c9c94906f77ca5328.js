(self.webpackChunk=self.webpackChunk||[]).push([[4415],{54415:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>u});var s=a(87757),n=a.n(s),o=a(30381),i=a.n(o);function l(e,t,a,s,n,o,i){try{var l=e[o](i),r=l.value}catch(e){return void a(e)}l.done?t(r):Promise.resolve(r).then(s,n)}function r(e){return function(){var t=this,a=arguments;return new Promise((function(s,n){var o=e.apply(t,a);function i(e){l(o,s,n,i,r,"next",e)}function r(e){l(o,s,n,i,r,"throw",e)}i(void 0)}))}}const d={props:["employees","defaultValue","old"],data:function(){return{employeesList:this.employees,authority_number:this.old.authority_number?this.old.authority_number:this.defaultValue?this.defaultValue.authority_number:"",employee_number:this.old.employee_number?this.old.employee_number:this.defaultValue?this.defaultValue.employee_number:"",position_name:this.old.position_name?this.old.position_name:this.defaultValue?this.defaultValue.position_name:"",start_date:this.old.start_date?this.old.start_date:this.defaultValue?this.defaultValue.start_date:"",end_date:this.old.end_date?this.old.end_date:this.defaultValue?this.defaultValue.end_date:"",disabledDateTo:this.start_date?this.start_date:null}},mounted:function(){this.old.start_date&&this.old.end_date||this.showDate()},methods:{showDate:function(){var e=this;return r(n().mark((function t(){var a,s;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.start_date){t.next=5;break}return t.next=3,helperDate.parseToDateTh(e.start_date,"yyyy-MM-DD");case 3:a=t.sent,e.start_date=a;case 5:if(!e.end_date){t.next=10;break}return t.next=8,helperDate.parseToDateTh(e.end_date,"yyyy-MM-DD");case 8:s=t.sent,e.end_date=s;case 10:case"end":return t.stop()}}),t)})))()},fromDateWasSelected:function(e){this.disabledDateTo=i()(e).format("DD/MM/YYYY")},getPosition:function(){var e=this;this.position_name="",this.selectedData=this.employeesList.find((function(t){return t.pnps_psnl_no==e.employee_number})),this.employee_number?this.position_name=this.selectedData.pnpm_pos_name:this.position_name=""},remoteMethod:function(e){""!==e?this.getHr({name:e}):this.users=[]},getHr:function(e){var t=this;return r(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.employeesList=[],axios.get("/om/settings/authority-list/create",{params:e}).then((function(e){t.employeesList=e.data}));case 2:case"end":return a.stop()}}),a)})))()}}};const u=(0,a(51900).Z)(d,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-2"}),e._v(" "),a("div",{staticClass:"col-md-4"},[e._m(0),e._v(" "),a("input",{attrs:{type:"hidden",name:"employee_number",autocomplete:"off"},domProps:{value:e.employee_number}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",disabled:null!=e.defaultValue,remote:"","reserve-keyword":"",clearable:"","remote-method":e.remoteMethod},on:{change:function(t){return e.getPosition()}},model:{value:e.employee_number,callback:function(t){e.employee_number=t},expression:"employee_number"}},e._l(e.employeesList,(function(e){return a("el-option",{key:e.pnps_psnl_no,attrs:{label:e.psn_name,value:e.pnps_psnl_no}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-4"},[e._m(1),e._v(" "),a("el-input",{attrs:{name:"position_name"},model:{value:e.position_name,callback:function(t){e.position_name=t},expression:"position_name"}})],1)]),e._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-2"}),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" วันที่เริ่มต้น ")]),e._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY"},on:{dateWasSelected:e.fromDateWasSelected},model:{value:e.start_date,callback:function(t){e.start_date=t},expression:"start_date"}})],1),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" วันที่สิ้นสุด ")]),e._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"end_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY","disabled-date-to":e.disabledDateTo},model:{value:e.end_date,callback:function(t){e.end_date=t},expression:"end_date"}})],1)])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("label",[e._v(" ผู้มีอำนาจ "),a("span",{staticClass:"text-danger"},[e._v("*")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("label",[e._v(" ตำแหน่ง "),a("span",{staticClass:"text-danger"},[e._v("*")])])}],!1,null,null,null).exports}}]);