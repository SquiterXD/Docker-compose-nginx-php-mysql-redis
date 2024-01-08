(self.webpackChunk=self.webpackChunk||[]).push([[1485],{61485:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>w});var s=a(87757),r=a.n(s),o=a(7398),i=a.n(o),c=(a(19371),a(30381)),n=a.n(c),l=a(80455),d=a.n(l),u=a(79373);function m(t,e,a,s,r,o,i){try{var c=t[o](i),n=c.value}catch(t){return void a(t)}c.done?e(n):Promise.resolve(n).then(s,r)}function _(t){return function(){var e=this,a=arguments;return new Promise((function(s,r){var o=t.apply(e,a);function i(t){m(o,s,r,i,c,"next",t)}function c(t){m(o,s,r,i,c,"throw",t)}i(void 0)}))}}function p(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function g(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?p(Object(a),!0).forEach((function(e){v(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):p(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function v(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const b={props:["periodYearValue","yearControl","stdcostYear","stdcostAccounts","allocateTypes"],components:{Loading:i(),VueNumeric:d(),TableStdCostTargets:u.Z},watch:{periodYearValue:function(t){this.periodYear=t},yearControl:function(t){this.yearControlData=t},stdcostYear:function(t){this.stdcostYearData=t},stdcostAccounts:function(t){this.stdcostAccountItems=t.map((function(t){return g(g({},t),{},{marked_as_deleted:!1})}))}},data:function(){var t=this;return{periodYear:this.periodYearValue,yearControlData:this.yearControl,stdcostYearData:this.stdcostYear,selectedStdcostAccountItem:null,stdcostAccountItems:this.stdcostAccounts.map((function(e){return g(g({},e),{},{allocate_type_label:t.getAllocateTypeLabel(t.allocateTypes,e.allocate_type),marked_as_deleted:!1})})),stdcostTargets:[],totalEstimateExpenseAmount:this.stdcostAccounts.reduce((function(t,e){return t+(e.estimate_expense_amount?parseFloat(e.estimate_expense_amount):0)}),0),isLoading:!1}},mounted:function(){},computed:{},methods:{onGetStdcostTargets:function(t){var e=this;return _(r().mark((function a(){var s;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(!(s=e.validateBeforeGetTargets(t)).valid){a.next=9;break}return e.stdcostTargets=[],e.selectedStdcostAccountItem=t,e.stdcostAccountItems=e.stdcostAccountItems.map((function(t){return g({},t)})),a.next=7,e.getStdcostTargets(e.stdcostYearData,t);case 7:a.next=10;break;case 9:swal("เกิดข้อผิดพลาด","".concat(s.message),"error");case 10:case"end":return a.stop()}}),a)})))()},getAllocateTypeLabel:function(t,e){var a="";if(t.length>0&&e){var s=t.find((function(t){return t.allocate_type_value==e}));a=s?s.allocate_type_label:""}return a},getStdcostTargets:function(t,e){var a=this;return _(r().mark((function s(){var o;return r().wrap((function(s){for(;;)switch(s.prev=s.next){case 0:return a.isLoading=!0,o={period_year:a.periodYear,year_control:JSON.stringify(a.yearControlData),stdcost_year:JSON.stringify(t),stdcost_account:JSON.stringify(e)},s.next=4,axios.get("/ajax/ct/std-cost-papers/account-targets",{params:o}).then((function(t){var s=t.data.data;return"success"==s.status?(a.stdcostTargets=s.stdcost_targets?JSON.parse(s.stdcost_targets):[],a.stdcostTargets.length<0&&swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล รายการบัญชีที่ปัน ของ ค่าแรง/ค่าใช้จ่าย : ".concat(e.account_type_desc," | ").concat(s.message),"error")):swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(s.message),"error"),s})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(t.message),"error")}));case 4:a.isLoading=!1;case 5:case"end":return s.stop()}}),s)})))()},validateBeforeGetTargets:function(t){return{valid:!0,message:""}},formatNumber:function(t){return t.toString().replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,",")},isNumber:function(t){var e=(t=t||window.event).which?t.which:t.keyCode;if(!(e>31&&(e<48||e>57)&&46!==e))return!0;t.preventDefault()}}};var f=a(51900);const h=(0,f.Z)(b,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"300px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0"},[t._m(0),t._v(" "),t.stdcostAccountItems.length>0?a("tbody",[t._l(t.stdcostAccountItems,(function(e,s){return[e.marked_as_deleted?t._e():a("tr",{key:s},[a("td",{staticClass:"text-left md:tw-table-cell"},[t._v("\n                            "+t._s(e.account_type_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell"},[t._v("\n                            "+t._s(e.acc_actual_amount?Number(e.acc_actual_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell"},[t._v("\n                            "+t._s(e.acc_avg_actual_amount?Number(e.acc_avg_actual_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell"},[t._v("\n                            "+t._s(e.acc_budget_amount?Number(e.acc_budget_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell"},[t._v("\n                            "+t._s(e.acc_estimate_expense_amount?Number(e.acc_estimate_expense_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-center text-nowrap"},[a("button",{staticClass:"btn btn-inline-block btn-xs btn-white",on:{click:function(a){return t.onGetStdcostTargets(e)}}},[a("i",{staticClass:"fa fa-list tw-mr-1"}),t._v(" รายการบัญชีที่ปัน\n                            ")])])])]}))],2):a("tbody",[t._m(1)])])]),t._v(" "),a("hr"),t._v(" "),a("div",[a("div",[a("table-std-cost-targets",{attrs:{"period-year-value":t.periodYear,"year-control":t.yearControlData,"stdcost-year":t.stdcostYearData,"stdcost-account":t.selectedStdcostAccountItem,"stdcost-targets":t.stdcostTargets}})],1)]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"15%"}},[t._v(" ค่าแรง/ค่าใช้จ่าย ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",attrs:{width:"15%"}},[t._v(" ค่าแรง/ใช้จ่ายจริง (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",attrs:{width:"15%"}},[t._v(" ค่าใช้จ่ายจริงเฉลี่ย ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",attrs:{width:"15%"}},[t._v(" ค่าแรง/ใช้จ่ายตามงบประมาณ (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",attrs:{width:"15%"}},[t._v(" ค่าแรง/ใช้จ่ายประมาณการ (บาท) ")]),t._v(" "),a("th",{attrs:{width:"10%"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"7"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports;function x(t,e,a,s,r,o,i){try{var c=t[o](i),n=c.value}catch(t){return void a(t)}c.done?e(n):Promise.resolve(n).then(s,r)}const y={components:{Loading:i(),TableStdCostAccounts:h},props:["defaultData","costCode","planVersionNo","versionNo","ct14VersionNo","periodYearData","periodFrom","periodTo","allocateTypes","allocateYear","yearControl","latestStdcostYear","stdcostYear","stdcostAccounts"],mounted:function(){this.yearControl?this.latestStdcostYear?this.stdcostAccounts.length<=0&&this.getStdcostAccounts(this.yearControl.period_year,this.yearControl.prdgrp_year_id,this.yearControl.cost_code,this.latestStdcostYear):swal("เกิดข้อผิดพลาด","ไม่พบข้อมูลต้นทุนมาตรฐาน ค่าแรง/ใช้จ่าย ปีบัญชีงบประมาณ: ".concat(this.periodYearData.period_year_thai,", ศูนย์ต้นทุน: ").concat(this.yearControl.cost_code," ").concat(this.yearControl.cost_description,", แผนการผลิตครั้งที่: ").concat(this.yearControl.plan_version_no,", ครั้งที่: ").concat(this.ct14VersionNo,", กรุณาตรวจสอบอีกครั้ง"),"error"):swal("เกิดข้อผิดพลาด","ไม่พบข้อมูลต้นทุนมาตรฐาน ค่าแรง/ใช้จ่าย ปีบัญชีงบประมาณ: ".concat(this.periodYearData.period_year_thai,", ศูนย์ต้นทุน: ").concat(this.costCode,", แผนการผลิตครั้งที่: ").concat(this.planVersionNo,", ครั้งที่: ").concat(this.ct14VersionNo," , กรุณาตรวจสอบอีกครั้ง"),"error")},data:function(){return{organizationId:this.defaultData?this.defaultData.organization_id:null,organizationCode:this.defaultData?this.defaultData.organization_code:null,department:this.defaultData?this.defaultData.department:null,approvedStatuses:[{value:"Active",label:"อนุมัติ"},{value:"Inactive",label:"ไม่อนุมัติ"}],periodYear:this.periodYearData?this.periodYearData.period_year:null,periodYearLabel:this.periodYearData?this.periodYearData.period_year_thai:null,stdcostYearData:this.stdcostYear?this.stdcostYear:null,stdcostAccountItems:this.stdcostAccounts?this.stdcostAccounts:[],periodFromData:this.periodFrom?this.periodFrom:null,periodToData:this.periodTo?this.periodTo:null,isLoading:!1}},computed:{},methods:{getApprovedStatusLabel:function(t){var e=this.approvedStatuses.find((function(e){return e.value==t}));return e?e.label:""},getStdcostAccounts:function(t,e,a,s){var o,i=this;return(o=r().mark((function o(){var c;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return i.isLoading=!0,c={period_year:t,prdgrp_year_id:e,cost_code:a,year_control:JSON.stringify(i.yearControl),stdcost_year:JSON.stringify(s)},r.next=4,axios.get("/ajax/ct/std-cost-papers/accounts",{params:c}).then((function(t){var e=t.data.data;return"success"==e.status?(i.stdcostYearData=e.stdcost_year?JSON.parse(e.stdcost_year):[],i.stdcostAccountItems=e.stdcost_accounts?JSON.parse(e.stdcost_accounts):[],i.periodToData=e.period_to?JSON.parse(e.period_to):[]):swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(e.message),"error"),e})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(t.message),"error")}));case 4:i.isLoading=!1;case 5:case"end":return r.stop()}}),o)})),function(){var t=this,e=arguments;return new Promise((function(a,s){var r=o.apply(t,e);function i(t){x(r,a,s,i,c,"next",t)}function c(t){x(r,a,s,i,c,"throw",t)}i(void 0)}))})()},getPeriodNameLabel:function(t,e){var a=null;if(e){var s=t.find((function(t){return t.period_name==e}));a=s?s.thai_month:""}return a},formatDateTh:function(t){return t?n()(t).add(543,"years").format("DD/MM/YYYY"):""}}};const w=(0,f.Z)(y,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox"},[a("div",{staticClass:"ibox-content tw-pt-10",staticStyle:{"min-height":"600px"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-6 col-form-label tw-font-bold tw-pt-0"},[t._v(" ปีบัญชีงบประมาณ ")]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.periodYearLabel,expression:"periodYearLabel"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.periodYearLabel},on:{input:function(e){e.target.composing||(t.periodYearLabel=e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"col-md-2"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-7 col-form-label tw-font-bold tw-pt-0"},[t._v(" แผนการผลิตครั้งที่ ")]),t._v(" "),a("div",{staticClass:"col-md-5"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.yearControl.plan_version_no,expression:"yearControl.plan_version_no"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.plan_version_no},on:{input:function(e){e.target.composing||t.$set(t.yearControl,"plan_version_no",e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"col-md-2"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-5 col-form-label tw-font-bold tw-pt-0"},[t._v(" ครั้งที่ ")]),t._v(" "),a("div",{staticClass:"col-md-7"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.yearControl.ct14_last_version_no,expression:"yearControl.ct14_last_version_no"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.ct14_last_version_no},on:{input:function(e){e.target.composing||t.$set(t.yearControl,"ct14_last_version_no",e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-6 col-form-label tw-font-bold tw-pt-0"},[t._v(" วันที่เริ่มใช้ ")]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.yearControl.start_date_thai,expression:"yearControl.start_date_thai"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.start_date_thai},on:{input:function(e){e.target.composing||t.$set(t.yearControl,"start_date_thai",e.target.value)}}})])])])]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-8"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-3 col-form-label tw-font-bold tw-pt-0"},[t._v(" ศูนย์ต้นทุน ")]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.yearControl.cost_code,expression:"yearControl.cost_code"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.cost_code},on:{input:function(e){e.target.composing||t.$set(t.yearControl,"cost_code",e.target.value)}}})]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.yearControl.cost_description,expression:"yearControl.cost_description"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.cost_description},on:{input:function(e){e.target.composing||t.$set(t.yearControl,"cost_description",e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-6 col-form-label tw-font-bold tw-pt-0"},[t._v(" วันที่สิ้นสุด ")]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.yearControl.end_date_thai,expression:"yearControl.end_date_thai"}],staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.end_date_thai},on:{input:function(e){e.target.composing||t.$set(t.yearControl,"end_date_thai",e.target.value)}}})])])])]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-8"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-3 col-form-label tw-font-bold tw-pt-0"},[t._v(" ประเภทศูนย์ต้นทุน ")]),t._v(" "),a("div",{staticClass:"col-md-9"},[a("input",{staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl?t.yearControl.cost_center.cost_group_desc:"-"}})])])]),t._v(" "),a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-6 col-form-label tw-font-bold tw-pt-0"},[t._v(" สถานะ ")]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.yearControl.approved_status?t.getApprovedStatusLabel(t.yearControl.approved_status):""}})])])])]),t._v(" "),a("hr"),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-6 col-form-label tw-font-bold tw-pt-0"},[t._v(" เกณฑ์การปันส่วนครั้งที่ ")]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{staticClass:"form-control input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.allocateYear?t.allocateYear.version_no:"-"}})])])]),t._v(" "),a("div",{staticClass:"col-md-5"},[a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0"},[t._v(" เปรียบเทียบค่าใช้จ่ายจากเดือน ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("div",{staticClass:"input-group input-group-sm mb-3"},[a("input",{staticClass:"form-control text-center input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.periodFromData?t.periodFromData.thai_month:"-"}}),t._v(" "),t._m(0),t._v(" "),a("input",{staticClass:"form-control text-center input-sm",attrs:{type:"text",readonly:""},domProps:{value:t.periodToData?t.periodToData.thai_month:"-"}})])])])]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("button",{staticClass:"btn btn-inline-block btn-primary tw-w-full",attrs:{disabled:!t.yearControl||!t.latestStdcostYear},on:{click:function(e){return t.getStdcostAccounts(t.yearControl.period_year,t.yearControl.prdgrp_year_id,t.yearControl.cost_code,t.latestStdcostYear)}}},[a("i",{staticClass:"fa fa-arrow-down"}),t._v(" คำนวณค่าแรง/ค่าใช้จ่าย\n                ")])])]),t._v(" "),a("hr"),t._v(" "),a("div",{staticClass:"row tw-mb-5"},[a("div",{staticClass:"col-12"},[a("table-std-cost-accounts",{attrs:{"period-year-value":t.periodYear,"year-control":t.yearControl,"stdcost-year":t.stdcostYear,"stdcost-accounts":t.stdcostAccountItems,"allocate-types":t.allocateTypes}})],1)])]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"input-group-prepend input-group-append"},[a("span",{staticClass:"input-group-text",attrs:{id:"inputGroup-sizing-sm"}},[t._v(" ถึง ")])])}],!1,null,null,null).exports},79373:(t,e,a)=>{"use strict";a.d(e,{Z:()=>m});var s=a(87757),r=a.n(s),o=a(80455),i=a.n(o),c=a(7398),n=a.n(c);a(19371),a(30381);function l(t,e,a,s,r,o,i){try{var c=t[o](i),n=c.value}catch(t){return void a(t)}c.done?e(n):Promise.resolve(n).then(s,r)}function d(t){return function(){var e=this,a=arguments;return new Promise((function(s,r){var o=t.apply(e,a);function i(t){l(o,s,r,i,c,"next",t)}function c(t){l(o,s,r,i,c,"throw",t)}i(void 0)}))}}const u={props:["periodYearValue","yearControl","stdcostYear","stdcostAccount","stdcostTargets"],components:{Loading:n(),VueNumeric:i()},watch:{periodYearValue:function(t){this.periodYear=t},yearControl:function(t){this.yearControlData=t},stdcostYear:function(t){this.stdcostYearData=t},stdcostAccount:function(t){this.stdcostAccountData=t},stdcostTargets:function(t){this.stdcostTargetItems=t,this.stdcostTgPrdGroups=[],this.stdcostTgItems=[],1==this.stdcostTargetItems.length&&this.getStdcostTgPrdGroups(this.stdcostTargetItems[0])}},data:function(){return{periodYear:this.periodYearValue,yearControlData:this.yearControl,stdcostYearData:this.stdcostYear,stdcostAccountData:this.stdcostAccount,stdcostTargetItems:this.stdcostTargets,stdcostTgPrdGroups:[],stdcostTgItems:[],isTableTargetActive:!0,isTableTgItemActive:!1,isTableTgPrdGroupActive:!1,isLoading:!1}},mounted:function(){},computed:{},methods:{toggleShowTable:function(t){var e=this;this.isTableTargetActive=!1,this.isTableTgItemActive=!1,this.isTableTgPrdGroupActive=!1,this.$nextTick((function(){"target"==t&&(e.isTableTargetActive=!0),"tgItem"==t&&(e.isTableTgItemActive=!0),"tgPrdGroup"==t&&(e.isTableTgPrdGroupActive=!0)}))},onGetStdcostTgPrdGroups:function(t){var e=this;return d(r().mark((function a(){return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,e.getStdcostTgPrdGroups(t);case 2:e.stdcostTgPrdGroups.length>0&&e.toggleShowTable("tgPrdGroup");case 3:case"end":return a.stop()}}),a)})))()},getStdcostTgPrdGroups:function(t){var e=this;return d(r().mark((function a(){var s,o,i;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s=e.stdcostYearData,o=e.stdcostAccountData,e.isLoading=!0,i={period_year:e.periodYear,year_control:JSON.stringify(e.yearControlData),stdcost_year:JSON.stringify(s),stdcost_account:JSON.stringify(o),stdcost_target:JSON.stringify(t)},a.next=6,axios.get("/ajax/ct/std-cost-papers/account-targets/tg-prd-groups",{params:i}).then((function(a){var s=a.data.data;return"success"==s.status?(e.stdcostTgPrdGroups=s.stdcost_tg_prd_groups?JSON.parse(s.stdcost_tg_prd_groups):[],e.stdcostTgItems=[],e.stdcostTgPrdGroups.length<=0?swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล กลุ่มผลิตภัณฑ์ ของ รหัสบัญชี : ".concat(t.account_code," ").concat(t.account_desc," | ").concat(s.message),"error"):1==e.stdcostTgPrdGroups.length&&e.getStdcostTgItems(e.stdcostTgPrdGroups[0])):swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(s.message),"error"),s})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(t.message),"error")}));case 6:e.isLoading=!1;case 7:case"end":return a.stop()}}),a)})))()},onGetStdcostTgItems:function(t){var e=this;return d(r().mark((function a(){return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,e.getStdcostTgItems(t);case 2:e.stdcostTgItems.length>0&&e.toggleShowTable("tgItem");case 3:case"end":return a.stop()}}),a)})))()},getStdcostTgItems:function(t){var e=this;return d(r().mark((function a(){var s,o,i;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s=e.stdcostYearData,o=e.stdcostAccountData,e.isLoading=!0,i={period_year:e.periodYear,year_control:JSON.stringify(e.yearControlData),stdcost_year:JSON.stringify(s),stdcost_account:JSON.stringify(o),stdcost_tg_prd_group:JSON.stringify(t)},a.next=6,axios.get("/ajax/ct/std-cost-papers/account-targets/tg-items",{params:i}).then((function(a){var s=a.data.data;return"success"==s.status?(e.stdcostTgItems=s.stdcost_tg_items?JSON.parse(s.stdcost_tg_items):[],e.stdcostTgItems.length<=0&&swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล ผลิตภัณฑ์ ของ กลุ่มผลิตภัณฑ์ : ".concat(t.product_group," ").concat(t.product_group_desc," | ").concat(s.message),"error")):swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(s.message),"error"),s})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูล | ".concat(t.message),"error")}));case 6:e.isLoading=!1;case 7:case"end":return a.stop()}}),a)})))()},formatNumber:function(t){return t.toString().replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,",")},isNumber:function(t){var e=(t=t||window.event).which?t.which:t.keyCode;if(!(e>31&&(e<48||e>57)&&46!==e))return!0;t.preventDefault()}}};const m=(0,a(51900).Z)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",[a("div",{staticClass:"btn-group",attrs:{role:"group"}},[a("button",{staticClass:"btn",class:[t.isTableTargetActive?"btn-primary":"btn-white"],attrs:{type:"button"},on:{click:function(e){return t.toggleShowTable("target")}}},[t._v(" รายการบัญชีที่ปัน ")]),t._v(" "),a("button",{staticClass:"btn",class:[t.isTableTgPrdGroupActive?"btn-primary":"btn-white"],attrs:{type:"button"},on:{click:function(e){return t.toggleShowTable("tgPrdGroup")}}},[t._v(" กลุ่มผลิตภัณฑ์ ")]),t._v(" "),a("button",{staticClass:"btn",class:[t.isTableTgItemActive?"btn-primary":"btn-white"],attrs:{type:"button"},on:{click:function(e){return t.toggleShowTable("tgItem")}}},[t._v(" ผลิตภัณฑ์ ")])])]),t._v(" "),t.isTableTargetActive?a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"300px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0"},[t._m(0),t._v(" "),t.stdcostTargetItems.length>0?a("tbody",[t._l(t.stdcostTargetItems,(function(e,s){return[a("tr",{key:s},[a("td",{staticClass:"text-left md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.account_type_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.account_code)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell tw-hidden",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.account_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell tw-hidden",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.allocate_type_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.acc_actual_amount?Number(e.acc_actual_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.acc_avg_actual_amount?Number(e.acc_avg_actual_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.acc_budget_amount?Number(e.acc_budget_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.acc_estimate_expense_amount?Number(e.acc_estimate_expense_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-center text-nowrap"},[a("button",{staticClass:"btn btn-inline-block btn-xs btn-white",on:{click:function(a){return t.onGetStdcostTgPrdGroups(e)}}},[a("i",{staticClass:"fa fa-list tw-mr-1"}),t._v(" กลุ่มผลิตภัณฑ์\n                            ")])])])]}))],2):a("tbody",[t._m(1)])])]):t._e(),t._v(" "),t.isTableTgPrdGroupActive?a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"300px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0"},[t._m(2),t._v(" "),t.stdcostTgPrdGroups.length>0?a("tbody",[t._l(t.stdcostTgPrdGroups,(function(e,s){return[a("tr",{key:s},[a("td",{staticClass:"text-center md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.product_group)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.product_group_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell tw-hidden",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.ratio_rate)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.prd_estimate_expense_amount?Number(e.prd_estimate_expense_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.prd_productivity_qty?Number(e.prd_productivity_qty).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.prd_estimate_per_unit?Number(e.prd_estimate_per_unit).toLocaleString(void 0,{minimumFractionDigits:9,maximumFractsionDigits:9}):"0.000000000")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-center text-nowrap"},[a("button",{staticClass:"btn btn-inline-block btn-xs btn-white",on:{click:function(a){return t.onGetStdcostTgItems(e)}}},[a("i",{staticClass:"fa fa-list tw-mr-1"}),t._v(" ผลิตภัณฑ์\n                            ")])])])]}))],2):a("tbody",[t._m(3)])])]):t._e(),t._v(" "),t.isTableTgItemActive?a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"300px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0"},[t._m(4),t._v(" "),t.stdcostTgItems.length>0?a("tbody",[t._l(t.stdcostTgItems,(function(e,s){return[a("tr",{key:s},[a("td",{staticClass:"text-center md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.product_item_number)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.product_item_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell tw-hidden",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.ratio_rate)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.item_estimate_expense_amount?Number(e.item_estimate_expense_amount).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.item_productivity_qty?Number(e.item_productivity_qty).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"0.00")+" \n                        ")]),t._v(" "),a("td",{staticClass:"text-right md:tw-table-cell",staticStyle:{"border-left":"0","border-right":"0"}},[t._v("\n                            "+t._s(e.item_estimate_per_unit?Number(e.item_estimate_per_unit).toLocaleString(void 0,{minimumFractionDigits:9,maximumFractionDigits:9}):"0.000000000")+" \n                        ")])])]}))],2):a("tbody",[t._m(5)])])]):t._e(),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}},[t._v(" ค่าแรง/ค่าใช้จ่าย ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"8%"}},[t._v(" รหัสบัญชี ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"12%"}},[t._v(" ชื่อบัญชี ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}},[t._v(" เกณฑ์การปันส่วน ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"13%"}},[t._v(" ค่าแรง/ใช้จ่ายจริง (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}},[t._v(" ค่าใช้จ่ายจริงเฉลี่ย ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"13%"}},[t._v(" ค่าแรง/ใช้จ่ายตามงบประมาณ (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"13%"}},[t._v(" ค่าแรง/ใช้จ่ายประมาณการ (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"9"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" กรุณาเลือก ค่าแรง/ค่าใช้จ่าย ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"15%",colspan:"2"}},[t._v(" กลุ่มผลิตภัณฑ์ ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}},[t._v("  สัดส่วน % ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"15%"}},[t._v(" ค่าแรง/ใช้จ่าย ประมาณการ (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"15%"}},[t._v(" ปริมาณผลผลิตมาตรฐาน (ชิ้น/กิโลกรัม/ตร.ซม.) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"30%"}},[t._v(" ค่าประมาณการ(บาท) ต่อหนึ่งหน่วย ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"8"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" กรุณาเลือก รายการบัญชีที่ปัน ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}},[t._v(" ผลิตภัณฑ์ ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"20%"}},[t._v(" รายละเอียด ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"10%"}},[t._v("  สัดส่วน % ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"15%"}},[t._v(" ค่าแรง/ใช้จ่าย ประมาณการ (บาท) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"15%"}},[t._v(" ปริมาณผลผลิตมาตรฐาน (ชิ้น/กิโลกรัม/ตร.ซม.) ")]),t._v(" "),a("th",{staticClass:"text-right tw-text-xs md:tw-table-cell",staticStyle:{"background-color":"#fff0e0","border-left":"0px","border-right":"0px"},attrs:{width:"30%"}},[t._v(" ค่าประมาณการ(บาท) ต่อหนึ่งหน่วย ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"8"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" กรุณาเลือก กลุ่มผลิตภัณฑ์ ")])])])}],!1,null,null,null).exports}}]);