(self.webpackChunk=self.webpackChunk||[]).push([[3555],{4599:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>a});var r=o(23645),n=o.n(r)()((function(t){return t[1]}));n.push([t.id,".v--modal-overlay[data-v-05ed469e]{z-index:2000;padding-top:3rem;padding-bottom:3rem}.vm--overlay[data-modal=modal-search-allocate-year][data-v-05ed469e]{height:100%!important}",""]);const a=n},98309:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>a});var r=o(23645),n=o.n(r)()((function(t){return t[1]}));n.push([t.id,".v--modal-overlay[data-v-e756d9f4]{z-index:2000;padding-top:3rem;padding-bottom:3rem}.vm--overlay[data-modal=modal-search-allocate-year][data-v-e756d9f4]{height:100%!important}",""]);const a=n},13555:(t,e,o)=>{"use strict";o.r(e),o.d(e,{default:()=>k});var r=o(87757),n=o.n(r),a=o(7398),s=o.n(a),i=(o(2223),o(30381)),l=o.n(i);function c(t,e,o,r,n,a,s){try{var i=t[a](s),l=i.value}catch(t){return void o(t)}i.done?e(l):Promise.resolve(l).then(r,n)}const d={props:["modalName","modalWidth","modalHeight","yearControlItem","approvedStatuses"],components:{Loading:s()},watch:{yearControlItem:function(t){this.yearControl=t,this.approvedStatus=t.approved_status}},mounted:function(){this.yearControl&&(this.approvedStatus=this.yearControl.approved_status,this.approvedStatusLabel=this.getApprovedStatusLabel(this.approvedStatus))},data:function(){return{isLoading:!1,width:this.modalWidth,yearControl:this.yearControlItem,approvedStatus:this.yearControlItem?this.yearControlItem.approved_status:"Inactive",approvedStatusLabel:this.getApprovedStatusLabel(this.yearControlItem?this.yearControlItem.approved_status:"Inactive")}},created:function(){this.handleResize()},methods:{handleResize:function(){window.innerWidth<768?this.width="90%":window.innerWidth<992?this.width="80%":this.width=this.modalWidth},onApprovedStatusChanged:function(t){var e,o=this;return(e=n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:o.approvedStatus=t,o.approvedStatusLabel=o.getApprovedStatusLabel(o.approvedStatus);case 2:case"end":return e.stop()}}),e)})),function(){var t=this,o=arguments;return new Promise((function(r,n){var a=e.apply(t,o);function s(t){c(a,r,n,s,i,"next",t)}function i(t){c(a,r,n,s,i,"throw",t)}s(void 0)}))})()},getApprovedStatusLabel:function(t){var e=this.approvedStatuses.find((function(e){return e.value==t}));return e?e.label:""},onSaveApprovedStatus:function(){this.$modal.hide(this.modalName),this.$emit("onSaveApprovedStatus",{year_control:this.yearControl,approved_status:this.approvedStatus})}}};o(38554);var p=o(51900);const u=(0,p.Z)(d,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticStyle:{position:"fixed","z-index":"100"}},[o("modal",{attrs:{name:t.modalName,width:t.width,scrollable:!0,height:t.modalHeight,shiftX:.3,shiftY:.3}},[o("div",{staticClass:"p-4"},[o("h4",[t._v(" สถานะกระดาษทำการ ")]),t._v(" "),o("hr"),t._v(" "),o("div",{staticClass:"tw-p-4"},[o("div",{staticClass:"row form-group"},[o("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0"},[t._v(" สถานะ ")]),t._v(" "),o("div",{staticClass:"col-md-8"},[o("pm-el-select",{attrs:{name:"approved_status",id:"input_approved_status","select-options":t.approvedStatuses,"option-key":"value","option-value":"value","option-label":"label",value:t.approvedStatus,filterable:!0},on:{onSelected:t.onApprovedStatusChanged}})],1)])]),t._v(" "),o("hr"),t._v(" "),o("div",{staticClass:"text-right tw-mt-4"},[o("button",{staticClass:"btn btn-primary tw-w-32",attrs:{type:"button"},on:{click:t.onSaveApprovedStatus}},[t._v(" \n                    บันทึก \n                ")]),t._v(" "),o("button",{staticClass:"btn btn-link",attrs:{type:"button"},on:{click:function(e){return t.$modal.hide(t.modalName)}}},[t._v(" \n                    ยกเลิก \n                ")])])])]),t._v(" "),o("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[],!1,null,"05ed469e",null).exports;function _(t,e,o,r,n,a,s){try{var i=t[a](s),l=i.value}catch(t){return void o(t)}i.done?e(l):Promise.resolve(l).then(r,n)}function v(t,e){var o=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),o.push.apply(o,r)}return o}function h(t){for(var e=1;e<arguments.length;e++){var o=null!=arguments[e]?arguments[e]:{};e%2?v(Object(o),!0).forEach((function(e){m(t,e,o[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(o)):v(Object(o)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(o,e))}))}return t}function m(t,e,o){return e in t?Object.defineProperty(t,e,{value:o,enumerable:!0,configurable:!0,writable:!0}):t[e]=o,t}const f={props:["yearControls"],components:{Loading:s(),ModalApprovalYearControl:u},watch:{yearControls:function(t){this.yearControlItems=t.map((function(t){return h(h({},t),{},{period_year_thai:t.period_year?parseInt(t.period_year)+543:""})}))}},data:function(){return{yearControlItems:this.yearControls.map((function(t){return h(h({},t),{},{period_year_thai:t.period_year?parseInt(t.period_year)+543:""})})),selectedYearControl:null,approvedStatuses:[{value:"Active",label:"อนุมัติ"},{value:"Inactive",label:"ไม่อนุมัติ"}],isLoading:!1}},mounted:function(){},computed:{},methods:{getApprovedStatusLabel:function(t){var e=this.approvedStatuses.find((function(e){return e.value==t}));return e?e.label:""},onShowModalApprovalYearControl:function(t){console.log(t),this.selectedYearControl=t,this.$modal.show("modal-approval-year-control")},onSaveApprovedStatus:function(t){var e,o=this;return(e=n().mark((function e(){var r;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r={period_year:o.selectedYearControl.period_year,prdgrp_year_id:o.selectedYearControl.prdgrp_year_id,allocate_year_id:o.selectedYearControl.allocate_year_id,cost_code:o.selectedYearControl.cost_code,plan_version_no:o.selectedYearControl.plan_version_no,version_no:o.selectedYearControl.version_no,ct14_version_no:o.selectedYearControl.ct14_last_version_no,ct14_allocate_year_id:o.selectedYearControl.ct14_allocate_year_id,approved_status:t.approved_status},o.isLoading=!0,e.next=4,axios.post("/ajax/ct/std-cost-papers/approved-status",r).then((function(t){var e=t.data.data,r=e.message,n=e.year_control?JSON.parse(e.year_control):null;return"success"==e.status&&n&&(o.selectedYearControl.approved_status=n.approved_status),"error"==e.status&&swal("เกิดข้อผิดพลาด","บันทึกข้อมูลสถานะไม่สำเร็จ | ".concat(r),"error"),e})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","บันทึกข้อมูลสถานะไม่สำเร็จ | ".concat(t.message),"error")}));case 4:o.isLoading=!1;case 5:case"end":return e.stop()}}),e)})),function(){var t=this,o=arguments;return new Promise((function(r,n){var a=e.apply(t,o);function s(t){_(a,r,n,s,i,"next",t)}function i(t){_(a,r,n,s,i,"throw",t)}s(void 0)}))})()}}};const y=(0,p.Z)(f,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",[o("div",{staticClass:"table-responsive",staticStyle:{"max-height":"600px"}},[o("table",{staticClass:"table table-bordered table-sticky mb-0"},[t._m(0),t._v(" "),t.yearControlItems.length>0?o("tbody",[t._l(t.yearControlItems,(function(e,r){return[e.is_showed?o("tr",{key:r},[o("td",{staticClass:"text-center md:tw-table-cell"},[t._v("\n                            "+t._s(e.period_year_thai)+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-center md:tw-table-cell"},[t._v("\n                            "+t._s(e.plan_version_no)+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-center md:tw-table-cell"},[t._v("\n                            "+t._s(e.ct14_last_version_no)+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-left md:tw-table-cell"},[t._v("\n                            "+t._s(e.cost_code)+" : "+t._s(e.cost_description)+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-center md:tw-table-cell"},[t._v("\n                            "+t._s(e.start_date_thai)+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-center md:tw-table-cell"},[t._v("\n                            "+t._s(e.end_date_thai)+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-center md:tw-table-cell"},[t._v("\n                            "+t._s(e.approved_status?t.getApprovedStatusLabel(e.approved_status):"")+"\n                        ")]),t._v(" "),o("td",{staticClass:"text-center text-nowrap"},[o("a",{staticClass:"btn btn-inline-block btn-xs btn-white",attrs:{href:"/ct/std-cost-papers/materials?period_year="+e.period_year+"&prdgrp_year_id="+e.prdgrp_year_id+"&cost_code="+e.cost_code+"&plan_version_no="+e.plan_version_no+"&version_no="+(e.version_no?e.version_no:"")+"&ct14_last_version_no="+(e.ct14_last_version_no?e.ct14_last_version_no:""),target:"_blank"}},[t._v(" วัตถุดิบ ")]),t._v(" "),o("a",{staticClass:"btn btn-inline-block btn-xs btn-white tw-ml-2",attrs:{href:"/ct/std-cost-papers/account-targets?period_year="+e.period_year+"&prdgrp_year_id="+e.prdgrp_year_id+"&cost_code="+e.cost_code+"&plan_version_no="+e.plan_version_no+"&version_no="+(e.version_no?e.version_no:"")+"&ct14_last_version_no="+(e.ct14_last_version_no?e.ct14_last_version_no:""),target:"_blank"}},[t._v(" ค่าแรง/ใช้จ่าย ")]),t._v(" "),o("a",{staticClass:"btn btn-inline-block btn-xs btn-white tw-ml-2",attrs:{href:"/ct/std-cost-papers/summarizes?period_year="+e.period_year+"&prdgrp_year_id="+e.prdgrp_year_id+"&cost_code="+e.cost_code+"&plan_version_no="+e.plan_version_no+"&version_no="+(e.version_no?e.version_no:"")+"&ct14_last_version_no="+(e.ct14_last_version_no?e.ct14_last_version_no:""),target:"_blank"}},[t._v(" สรุปต้นทุน ")]),t._v(" "),o("button",{staticClass:"btn btn-inline-block btn-xs btn-primary btn-outline tw-w-20",on:{click:function(o){return t.onShowModalApprovalYearControl(e)}}},[t._v("\n                                สถานะ \n                            ")])])]):t._e()]}))],2):o("tbody",[t._m(1)])])]),t._v(" "),o("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}}),t._v(" "),o("modal-approval-year-control",{attrs:{"modal-name":"modal-approval-year-control","modal-width":"640","modal-height":"auto","year-control-item":t.selectedYearControl,"approved-statuses":t.approvedStatuses},on:{onSaveApprovedStatus:t.onSaveApprovedStatus}})],1)}),[function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("thead",[o("tr",[o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"10%"}},[t._v(" ปีบัญชีงบประมาณ ")]),t._v(" "),o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"7%"}},[t._v(" แผนผลิตครั้งที่ ")]),t._v(" "),o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"8%"}},[t._v(" ครั้งที่ ")]),t._v(" "),o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"20%"}},[t._v(" ศูนย์ต้นทุน ")]),t._v(" "),o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"12%"}},[t._v(" วันที่เริ่มใช้อัตรามาตรฐาน ")]),t._v(" "),o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"12%"}},[t._v(" วันที่สิ้นสุดอัตรามาตรฐาน ")]),t._v(" "),o("th",{staticClass:"text-center tw-text-xs md:tw-table-cell",attrs:{width:"10%"}},[t._v(" สถานะ ")]),t._v(" "),o("th",{attrs:{width:"35%"}})])])},function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("tr",[o("td",{attrs:{colspan:"8"}},[o("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports;function b(t,e,o,r,n,a,s){try{var i=t[a](s),l=i.value}catch(t){return void o(t)}i.done?e(l):Promise.resolve(l).then(r,n)}function w(t){return function(){var e=this,o=arguments;return new Promise((function(r,n){var a=t.apply(e,o);function s(t){b(a,r,n,s,i,"next",t)}function i(t){b(a,r,n,s,i,"throw",t)}s(void 0)}))}}const C={props:["modalName","modalWidth","modalHeight","yearControlItems","readyStdcostYearItems","periodYearValue"],components:{Loading:s()},watch:{yearControlItems:function(t){this.yearControls=t},readyStdcostYearItems:function(t){this.readyStdcostYears=t,this.periodYears=this.getListPeriodYears(t)},periodYearValue:function(t){this.periodYear=t,this.planVersionNo=null,this.versionNo=null,this.costCode=null,this.planVersionNoItems=this.getListPlanVersionNoItems(this.readyStdcostYearItems,this.periodYear),this.versionNoItems=this.getListVersionNoItems(this.readyStdcostYearItems,this.periodYear,this.planVersionNo),this.costCodeItems=this.getListCostCodeItems(this.readyStdcostYearItems,this.periodYear,this.planVersionNo)}},mounted:function(){},data:function(){return{isLoading:!1,width:this.modalWidth,yearControls:this.yearControlItems,readyStdcostYears:this.readyStdcostYearItems,periodYears:this.getListPeriodYears(this.readyStdcostYearItems),planVersionNoItems:[],versionNoItems:[],costCodeItems:[],periodYear:this.periodYearValue,planVersionNo:null,versionNo:null,costCode:null}},created:function(){this.handleResize()},methods:{handleResize:function(){window.innerWidth<768?this.width="90%":window.innerWidth<992?this.width="80%":this.width=this.modalWidth},onPeriodYearChanged:function(t){var e=this;return w(n().mark((function o(){return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:e.periodYear=t,e.planVersionNo=null,e.versionNo=null,e.costCode=null,e.planVersionNoItems=e.getListPlanVersionNoItems(e.readyStdcostYears,e.periodYear),e.versionNoItems=e.getListVersionNoItems(e.readyStdcostYears,e.periodYear,e.planVersionNo),e.costCodeItems=e.getListCostCodeItems(e.readyStdcostYears,e.periodYear,e.planVersionNo);case 7:case"end":return o.stop()}}),o)})))()},onPlanVersionNoChanged:function(t){var e=this;return w(n().mark((function o(){return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:e.planVersionNo=t,e.versionNo=null,e.costCode=null,e.versionNoItems=e.getListVersionNoItems(e.readyStdcostYears,e.periodYear,e.planVersionNo),e.costCodeItems=e.getListCostCodeItems(e.readyStdcostYears,e.periodYear,e.planVersionNo);case 5:case"end":return o.stop()}}),o)})))()},onVersionNoChanged:function(t){var e=this;return w(n().mark((function o(){return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:e.versionNo=t;case 1:case"end":return o.stop()}}),o)})))()},onCostCodeChanged:function(t){var e=this;return w(n().mark((function o(){return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:e.costCode=t;case 1:case"end":return o.stop()}}),o)})))()},getListPeriodYears:function(t){return t.map((function(t){return{period_year:t.period_year,period_year_thai:t.period_year?parseInt(t.period_year)+543:""}})).filter((function(t,e,o){return e===o.findIndex((function(e){return e.period_year===t.period_year}))})).sort((function(t,e){return e.period_year-t.period_year}))},getListPlanVersionNoItems:function(t,e){var o=[];return e&&(o=t.filter((function(t){return t.period_year==e})).map((function(t){return{plan_version_no:t.plan_version_no}})).filter((function(t,e,o){return e===o.findIndex((function(e){return e.plan_version_no===t.plan_version_no}))}))),o},getListVersionNoItems:function(t,e,o){var r=[];return e&&o&&(r=t.filter((function(t){return t.period_year==e&&t.plan_version_no==o&&!!t.ct14_version_no})).map((function(t){return{ct14_version_no:t.ct14_version_no}})).filter((function(t,e,o){return e===o.findIndex((function(e){return e.ct14_version_no===t.ct14_version_no}))}))),r},getListCostCodeItems:function(t,e,o){var r=[];return e&&o&&(r=t.filter((function(t){return t.period_year==e&&t.plan_version_no==o})).map((function(t){return{cost_code:t.cost_code,cost_code_value:t.cost_code_value,cost_code_label:t.cost_code_label}})).filter((function(t,e,o){return e===o.findIndex((function(e){return e.cost_code===t.cost_code}))}))),r},onSelectStdcostYear:function(){var t=this,e=this.readyStdcostYears.find((function(e){return t.versionNo?t.costCode?e.period_year==t.periodYear&&e.plan_version_no==t.planVersionNo&&e.ct14_version_no==t.versionNo&&e.cost_code==t.costCode:e.period_year==t.periodYear&&e.plan_version_no==t.planVersionNo&&e.ct14_version_no==t.versionNo:t.costCode?e.period_year==t.periodYear&&e.plan_version_no==t.planVersionNo&&e.cost_code==t.costCode:e.period_year==t.periodYear&&e.plan_version_no==t.planVersionNo}));e||(this.versionNo?swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล ปีบัญชีงบประมาณ: ".concat(this.periodYear,", แผนผลิตครั้งที่: ").concat(this.planVersionNo,", ครั้งที่: ").concat(this.versionNo),"error"):swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล ปีบัญชีงบประมาณ: ".concat(this.periodYear,", แผนผลิตครั้งที่: ").concat(this.planVersionNo),"error")),this.$modal.hide(this.modalName),this.$emit("onSelectReadyStdcostYear",{ready_stdcost_year:e,ct14_version_no:this.versionNo,ct14_allocate_year_id:this.versionNo&&this.costCode&&e?e.ct14_allocate_year_id:null,cost_code:this.costCode})}}};o(59164);const g=(0,p.Z)(C,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticStyle:{position:"fixed","z-index":"100"}},[o("modal",{attrs:{name:t.modalName,width:t.width,scrollable:!0,height:t.modalHeight,shiftX:.5,shiftY:.3}},[o("div",{staticClass:"p-4"},[o("h4",[t._v(" สถานะกระดาษทำการ ")]),t._v(" "),o("hr"),t._v(" "),o("div",{staticClass:"tw-p-4"},[o("div",{staticClass:"row form-group"},[o("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0 required"},[t._v(" ปีบัญชีงบประมาณ ")]),t._v(" "),o("div",{staticClass:"col-md-8"},[o("pm-el-select",{attrs:{name:"period_year",id:"input_period_year","select-options":t.periodYears,"option-key":"period_year","option-value":"period_year","option-label":"period_year_thai",value:t.periodYear,filterable:!0},on:{onSelected:t.onPeriodYearChanged}})],1)]),t._v(" "),o("div",{staticClass:"row form-group"},[o("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0 required"},[t._v(" แผนผลิตครั้งที่ ")]),t._v(" "),o("div",{staticClass:"col-md-8"},[o("pm-el-select",{attrs:{name:"plan_version_no",id:"input_plan_version_no","select-options":t.planVersionNoItems,"option-key":"plan_version_no","option-value":"plan_version_no","option-label":"plan_version_no",value:t.planVersionNo,filterable:!0},on:{onSelected:t.onPlanVersionNoChanged}})],1)]),t._v(" "),o("div",{staticClass:"row form-group"},[o("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0"},[t._v(" ครั้งที่ ")]),t._v(" "),o("div",{staticClass:"col-md-8"},[o("pm-el-select",{attrs:{name:"version_no",id:"input_version_no","select-options":t.versionNoItems,"option-key":"ct14_version_no","option-value":"ct14_version_no","option-label":"ct14_version_no",value:t.versionNo,filterable:!0,clearable:!0},on:{onSelected:t.onVersionNoChanged}})],1)]),t._v(" "),o("div",{staticClass:"row form-group"},[o("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0"},[t._v(" ศูนย์ต้นทุน ")]),t._v(" "),o("div",{staticClass:"col-md-8"},[o("pm-el-select",{attrs:{name:"cost_code",id:"input_cost_code","select-options":t.costCodeItems,"option-key":"cost_code","option-value":"cost_code","option-label":"cost_code_label",value:t.costCode,filterable:!0,clearable:!0},on:{onSelected:t.onCostCodeChanged}})],1)])]),t._v(" "),o("hr"),t._v(" "),o("div",{staticClass:"text-right tw-mt-4"},[o("button",{staticClass:"btn btn-primary tw-w-32",attrs:{type:"button",disabled:!t.periodYear||!t.planVersionNo},on:{click:t.onSelectStdcostYear}},[t._v(" \n                    เลือก \n                ")]),t._v(" "),o("button",{staticClass:"btn btn-link",attrs:{type:"button"},on:{click:function(e){return t.$modal.hide(t.modalName)}}},[t._v(" \n                    ยกเลิก \n                ")])])])]),t._v(" "),o("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[],!1,null,"e756d9f4",null).exports;function S(t,e,o,r,n,a,s){try{var i=t[a](s),l=i.value}catch(t){return void o(t)}i.done?e(l):Promise.resolve(l).then(r,n)}function Y(t){return function(){var e=this,o=arguments;return new Promise((function(r,n){var a=t.apply(e,o);function s(t){S(a,r,n,s,i,"next",t)}function i(t){S(a,r,n,s,i,"throw",t)}s(void 0)}))}}function x(t){return function(t){if(Array.isArray(t))return I(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return I(t,e);var o=Object.prototype.toString.call(t).slice(8,-1);"Object"===o&&t.constructor&&(o=t.constructor.name);if("Map"===o||"Set"===o)return Array.from(t);if("Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o))return I(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function I(t,e){(null==e||e>t.length)&&(e=t.length);for(var o=0,r=new Array(e);o<e;o++)r[o]=t[o];return r}function N(t,e){var o=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),o.push.apply(o,r)}return o}function L(t){for(var e=1;e<arguments.length;e++){var o=null!=arguments[e]?arguments[e]:{};e%2?N(Object(o),!0).forEach((function(e){P(t,e,o[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(o)):N(Object(o)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(o,e))}))}return t}function P(t,e,o){return e in t?Object.defineProperty(t,e,{value:o,enumerable:!0,configurable:!0,writable:!0}):t[e]=o,t}const O={components:{Loading:s(),TableYearControls:y,ModalGetStdCostData:g},props:["defaultData","yearControls","readyStdcostYears"],mounted:function(){},data:function(){return{organizationId:this.defaultData?this.defaultData.organization_id:null,organizationCode:this.defaultData?this.defaultData.organization_code:null,department:this.defaultData?this.defaultData.department:null,yearControlItems:this.yearControls.map((function(t){return L(L({},t),{},{is_showed:!0})})),periodYears:this.getListPeriodYears(this.yearControls),periodYear:"",isLoading:!1}},computed:{},methods:{getListPeriodYears:function(t){var e=t.map((function(t){return{period_year:t.period_year,period_year_thai:t.period_year_thai,budget_year:t.budget_year}})).filter((function(t,e,o){return e===o.findIndex((function(e){return e.period_year===t.period_year}))})).sort((function(t,e){return e.period_year-t.period_year}));return[{period_year:"",period_year_thai:"แสดงทั้งหมด",budget_year:""}].concat(x(e))},onPeriodYearChanged:function(t){var e=this;return Y(n().mark((function o(){return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:e.periodYear=t,e.periodYear?e.yearControlItems=e.yearControlItems.map((function(t){return L(L({},t),{},{is_showed:e.periodYear==t.period_year})})):e.yearControlItems=e.yearControlItems.map((function(t){return L(L({},t),{},{is_showed:!0})}));case 2:case"end":return o.stop()}}),o)})))()},onGetStdCostData:function(t){var e=this;return Y(n().mark((function o(){var r,a,s,i,l;return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return r=t.ready_stdcost_year,a=t.ct14_version_no,s=t.ct14_allocate_year_id,i=t.cost_code,l={period_year:r.period_year,plan_version_no:r.plan_version_no,prdgrp_year_id:r.prdgrp_year_id,allocate_year_id:r.allocate_year_id,version_no:r.version_no,ct14_version_no:a,ct14_allocate_year_id:s,cost_code:i},e.isLoading=!0,o.next=8,axios.post("/ajax/ct/std-cost-papers/get-std-cost-data",l).then((function(t){var e=t.data.data,o=e.message;return"success"==e.status&&(swal("สำเร็จ","ดึงข้อมูลสำเร็จ","success"),window.setTimeout((function(){window.location.reload()}),2e3)),"error"==e.status&&swal("เกิดข้อผิดพลาด","บันทึกข้อมูลสถานะไม่สำเร็จ | ".concat(o),"error"),e})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","บันทึกข้อมูลสถานะไม่สำเร็จ | ".concat(t.message),"error")}));case 8:e.isLoading=!1;case 9:case"end":return o.stop()}}),o)})))()},formatDateTh:function(t){return t?l()(t).add(543,"years").format("DD/MM/YYYY"):""}}};const k=(0,p.Z)(O,(function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"ibox"},[o("div",{staticClass:"ibox-content tw-pt-10",staticStyle:{"min-height":"600px"}},[o("div",{staticClass:"row tw-mb-5"},[o("div",{staticClass:"col-12"},[o("div",{staticClass:"row tw-mb-2"},[o("div",{staticClass:"col-md-4"},[o("div",{staticClass:"row"},[o("div",{staticClass:"col-md-6"},[o("pm-el-select",{attrs:{name:"period_year",id:"input_period_year","select-options":t.periodYears,"option-key":"period_year","option-value":"period_year","option-label":"period_year_thai",value:t.periodYear,filterable:!0},on:{onSelected:t.onPeriodYearChanged}})],1),t._v(" "),o("label",{staticClass:"col-md-6 col-form-label tw-font-bold"},[t._v(" ปีบัญชีงบประมาณ ")])])]),t._v(" "),o("div",{staticClass:"col-md-8 text-right"},[o("button",{staticClass:"btn btn-inline-block btn-sm btn-primary tw-w-32",on:{click:function(e){return t.$modal.show("modal-get-std-cost-data")}}},[o("i",{staticClass:"fa fa-arrow-down tw-mr-1"}),t._v(" ดึงข้อมูล \n                        ")])])]),t._v(" "),o("table-year-controls",{attrs:{"year-controls":t.yearControlItems}})],1)])]),t._v(" "),o("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}}),t._v(" "),o("modal-get-std-cost-data",{attrs:{"modal-name":"modal-get-std-cost-data","modal-width":"640","modal-height":"auto","year-control-items":t.yearControlItems,"ready-stdcost-year-items":t.readyStdcostYears,"period-year-value":t.periodYear},on:{onSelectReadyStdcostYear:t.onGetStdCostData}})],1)}),[],!1,null,null,null).exports},38554:(t,e,o)=>{var r=o(4599);r.__esModule&&(r=r.default),"string"==typeof r&&(r=[[t.id,r,""]]),r.locals&&(t.exports=r.locals);(0,o(45346).Z)("5fabe0e8",r,!0,{})},59164:(t,e,o)=>{var r=o(98309);r.__esModule&&(r=r.default),"string"==typeof r&&(r=[[t.id,r,""]]),r.locals&&(t.exports=r.locals);(0,o(45346).Z)("6a4c26fc",r,!0,{})}}]);