(self.webpackChunk=self.webpackChunk||[]).push([[4112],{44112:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>v});var s=a(87757),r=a.n(s),o=a(7398),l=a.n(o),n=(a(19371),a(30381)),c=a.n(n);function i(t,e,a,s,r,o,l){try{var n=t[o](l),c=n.value}catch(t){return void a(t)}n.done?e(c):Promise.resolve(c).then(s,r)}function p(t){return function(){var e=this,a=arguments;return new Promise((function(s,r){var o=t.apply(e,a);function l(t){i(o,s,r,l,n,"next",t)}function n(t){i(o,s,r,l,n,"throw",t)}l(void 0)}))}}function _(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function d(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?_(Object(a),!0).forEach((function(e){u(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):_(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function u(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const m={props:["authUser","showType","items","total","page","perPage","searchInputs","machines","listBrands","listMakers","confirmStatuses","approvalData","approvalRole"],components:{Loading:l()},data:function(){var t=this;return{sampleItems:JSON.parse(this.items).map((function(e){return d(d({},e),{},{confirm_code:e.gmd_sample.attribute12?e.gmd_sample.attribute12:"1",confirm_status:t.getConfirmStatus(t.confirmStatuses,e.gmd_sample.attribute12?e.gmd_sample.attribute12:"1"),reject_reason:e.gmd_sample.attribute16?e.gmd_sample.attribute16:"",approval_status_code:e.gmd_sample.attribute13?e.gmd_sample.attribute13:"10",operator_approval_status:t.getOperatorApprovalStatus(t.approvalData,e.gmd_sample.attribute13),supervisor_approval_status:t.getSupervisorApprovalStatus(t.approvalData,e.gmd_sample.attribute13),leader_approval_status:t.getLeaderApprovalStatus(t.approvalData,e.gmd_sample.attribute13),machine_full_name:t.getMachineFullname(e.machine_name),date_drawn_show:e.date_drawn_formatted?c()(e.date_drawn_formatted).add(543,"years").format("DD/MM/YYYY"):"",specification_showed:!1,specifications:[],results:[]})})),isLoading:!1}},methods:{getConfirmStatus:function(t,e){var a="",s=t.find((function(t){return t.confirm_code==e}));return s&&(a=s.confirm_status),a},isAllowEdit:function(t,e){var a=!1;e&&("1"==e.level_code&&"10"==t.approval_status_code&&(a=!0));return a},isAllowApproval:function(t,e){var a=!1;if("CP"==t.sample_operation_status&&e){var s=e.level_code;"1"==s?"10"==t.approval_status_code&&(a=!0):"2"==s?"11"==t.approval_status_code&&(a=!0):"3"==s&&"21"==t.approval_status_code&&(a=!0)}return a},isAllowRejectApproval:function(t,e){var a=!1;if(e){var s=e.level_code;"1"==s?"10"==t.approval_status_code&&(a=!0):"2"==s?"11"==t.approval_status_code&&(a=!0):"3"==s&&"21"==t.approval_status_code&&(a=!0)}return a},isAllowReturnApproval:function(t,e){var a=!1;if(e){var s=e.level_code;"2"==s?"11"==t.approval_status_code&&(a=!0):"3"==s&&"21"==t.approval_status_code&&(a=!0)}return a},isAllowUnapproveApproval:function(t,e){var a=!1;e&&("3"==e.level_code&&"31"==t.approval_status_code&&(a=!0));return a},getOperatorApprovalStatus:function(t,e){var a=t.find((function(t){return 1==t.level_code})),s="",r="";return e&&"10"!=e?"12"==e?(s=a.reject_status,r="red"):"11"!=e&&"21"!=e&&"22"!=e&&"31"!=e&&"32"!=e||(s=a.approved_status,r="green"):(s=a.pending_status,r="yellow"),{status_desc:s,status_color:r}},getSupervisorApprovalStatus:function(t,e){var a=t.find((function(t){return 2==t.level_code})),s="",r="";return"11"==e?(s=a.pending_status,r="yellow"):"22"==e?(s=a.reject_status,r="red"):"21"!=e&&"31"!=e&&"32"!=e||(s=a.approved_status,r="green"),{status_desc:s,status_color:r}},getLeaderApprovalStatus:function(t,e){var a=t.find((function(t){return 3==t.level_code})),s="",r="";return"21"==e?(s=a.pending_status,r="yellow"):"32"==e?(s=a.reject_status,r="red"):"31"==e&&(s=a.approved_status,r="green"),{status_desc:s,status_color:r}},getMachineFullname:function(t){var e="";return t&&(e="QTM".concat(t)),e},onResultButtonClicked:function(t,e,a,s){var o=this;this.sampleItems.forEach(function(){var s=p(r().mark((function s(l,n){var c;return r().wrap((function(s){for(;;)switch(s.prev=s.next){case 0:if(l.sample_no!==t){s.next=12;break}if(o.sampleItems[n].specification_showed){s.next=9;break}return o.isLoading=!0,s.next=5,o.getSampleSpecifications(t,e,a);case 5:c=s.sent,o.sampleItems[n].specifications=c.specifications,o.sampleItems[n].results=c.results,o.isLoading=!1;case 9:o.sampleItems[n].specification_showed=!o.sampleItems[n].specification_showed,s.next=13;break;case 12:o.sampleItems[n].specification_showed=!1;case 13:case"end":return s.stop()}}),s)})));return function(t,e){return s.apply(this,arguments)}}())},getSampleSpecifications:function(t,e,a){var s={sample_no:t,organization_id:e,inventory_item_id:a};return axios.get("/qm/ajax/qtm-machines/get-sample-specifications",{params:s}).then((function(t){return{specifications:JSON.parse(t.data.data.specifications),results:JSON.parse(t.data.data.results)}}))},onSampleTimeDrawnChanged:function(t,e){e.time_drawn_formatted=t},onSampleTimeDrawnClosed:function(t,e){var a=this;this.isLoading=!0;var s={organization_code:e.organization_code,oracle_sample_id:e.oracle_sample_id,sample_no:e.sample_no,time_drawn_formatted:e.time_drawn_formatted};axios.post("/qm/ajax/qtm-machines/update-time-drawn",s).then((function(t){var s=t.data.data,r=s.message;a.isLoading=!1,s.status,"error"==s.status&&swal("Error","ไม่สามารถแก้ไขข้อมูลเวลาที่เก็บตัวอย่าง (เลขที่การตรวจสอบ : ".concat(e.sample_no,") | ").concat(r),"error")})).catch((function(t){console.log(t),a.isLoading=!1,swal("Error","ไม่สามารถแก้ไขข้อมูลเวลาที่เก็บตัวอย่าง (เลขที่การตรวจสอบ : ".concat(e.sample_no,")  | ").concat(t.message),"error")}))},onSampleResultSubmitted:function(t){var e=this;if("success"==t.status){var a=t.sample_no,s=t.sample_disposition,r=t.sample_disposition_desc,o=t.sample_operation_status,l=t.sample_operation_status_desc,n=t.sample_result_status,c=t.sample_result_status_desc,i=t.severity_level_minor,p=t.severity_level_major,_=t.severity_level_critical,d=t.test_time,u=t.brand,m=t.maker;this.sampleItems.forEach((function(t,v){e.sampleItems[v].sample_no==a&&(e.sampleItems[v].sample_disposition=s,e.sampleItems[v].sample_disposition_desc=r,e.sampleItems[v].sample_operation_status=o,e.sampleItems[v].sample_operation_status_desc=l,e.sampleItems[v].sample_result_status=n,e.sampleItems[v].sample_result_status_desc=c,e.sampleItems[v].severity_level_minor=i,e.sampleItems[v].severity_level_major=p,e.sampleItems[v].severity_level_critical=_,e.sampleItems[v].brand=u,e.sampleItems[v].maker=m,e.sampleItems[v].test_time=d)}))}},onConfirmSampleResult:function(t){var e=this;console.log(t);var a=t.sample_no,s=t.confirm_code;this.sampleItems.forEach((function(r,o){e.sampleItems[o].specification_showed=!1,e.sampleItems[o].sample_no==a&&(e.sampleItems[o].confirm_code=s,e.sampleItems[o].confirm_status=e.getConfirmStatus(e.confirmStatuses,s||"1"),e.sampleItems[o].reject_reason="",e.sampleItems[o].sample_operation_status=t.sample_operation_status,e.sampleItems[o].sample_operation_status_desc=t.sample_operation_status_desc,e.sampleItems[o].sample_result_status=t.sample_result_status,e.sampleItems[o].sample_result_status_desc=t.sample_result_status_desc)}))},onRejectSampleResult:function(t){var e=this;console.log(t);var a=t.sample_no,s=t.confirm_code,r=t.reject_reason;this.sampleItems.forEach((function(o,l){e.sampleItems[l].specification_showed=!1,e.sampleItems[l].sample_no==a&&(e.sampleItems[l].confirm_code=s,e.sampleItems[l].confirm_status=e.getConfirmStatus(e.confirmStatuses,s||"1"),e.sampleItems[l].reject_reason=r,e.sampleItems[l].sample_operation_status=t.sample_operation_status,e.sampleItems[l].sample_operation_status_desc=t.sample_operation_status_desc,e.sampleItems[l].sample_result_status=t.sample_result_status,e.sampleItems[l].sample_result_status_desc=t.sample_result_status_desc)}))},onCancelSampleResult:function(t){var e=this;this.sampleItems.forEach((function(t,a){e.sampleItems[a].specification_showed=!1}))},onApproveSampleClicked:function(t,e,a){var s=this,r="",o=e.level_code;"1"==o?r="ส่งอนุมัติ":"2"!=o&&"3"!=o||(r="อนุมัติผลการตรวจสอบ");var l=t.sample_disposition_desc,n="ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," | สถานะ : ").concat(l," ) ?");swal({title:"",text:n,showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.approveSample(t,e,r)}))},onApproveAllSampleClicked:function(t,e){var a=this,s="",r=t.level_code;"1"==r?s="ส่งอนุมัติ":"2"!=r&&"3"!=r||(s="อนุมัติผลการตรวจสอบ");var o=this.sampleItems.filter((function(e){return a.isAllowApproval(e,t)})).map((function(t){return t.sample_no}));if(console.log("Approving SampleNos : "),console.log(o),o.length<=0)swal("Error","ไม่พบเลขที่การตรวจสอบ ที่สามารถ".concat(s,"ได้ "),"error");else{var l="ต้องการ ".concat(s," ทั้งหมด ").concat(o.length," รายการ ) ?");swal({title:"",text:l,showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(e){e&&a.approveAllSamples(o,t,s)}))}},onRejectSampleClicked:function(t,e,a){var s=this,r="",o=e.level_code;"1"==o?r="ยกเลิกผลการทดสอบ":"2"!=o&&"3"!=o||(r="ไม่อนุมัติผลการตรวจสอบ");var l=t.sample_disposition_desc,n="ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," | สถานะ : ").concat(l," ) ?");swal({title:"",text:n,showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.rejectSample(t,e,r)}))},onReturnSampleClicked:function(t,e,a){var s=this,r="ส่งกลับการอนุมัติ";swal({title:"",text:"ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," ) ?"),showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.returnSample(t,e,r)}))},onUnapproveSampleClicked:function(t,e,a){var s=this,r="ยกเลิกการอนุมัติ";swal({title:"",text:"ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," ) ?"),showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.unapproveSample(t,e,r)}))},approveSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.isLoading=!0,r.next=4,axios.post("/qm/ajax/qtm-machines/approval/approve",l).then((function(e){var r=e.data.data,o=r.message,l=(r.sample&&JSON.parse(r.sample),r.approval_status_code?r.approval_status_code:"10");return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,l),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,l),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,l)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.isLoading=!1;case 5:case"end":return r.stop()}}),o)})))()},approveAllSamples:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={sample_nos:JSON.stringify(t),approval_level_code:e.level_code},s.isLoading=!0,r.next=4,axios.post("/qm/ajax/qtm-machines/approval/approve-all",l).then((function(e){var s=e.data.data,r=s.message;return"success"==s.status&&(swal("Success","".concat(a," ( เลขที่การตรวจสอบ : ").concat(t.length," รายการ } )"),"success"),location.reload()),"error"==s.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.length," รายการ }) | ").concat(r),"error"),s})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.length," รายการ }) | ").concat(e.message),"error")}));case 4:s.isLoading=!1;case 5:case"end":return r.stop()}}),o)})))()},rejectSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.isLoading=!0,r.next=4,axios.post("/qm/ajax/qtm-machines/approval/reject",l).then((function(e){var r=e.data.data,o=r.message,l=r.sample?JSON.parse(r.sample):null,n=r.approval_status_code?r.approval_status_code:"10";return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=n,t.approval_status_code=n,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,n),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,n),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,n),l&&(t.sample_operation_status=l.sample_operation_status,t.sample_operation_status_desc=l.sample_operation_status_desc,t.sample_result_status=l.sample_result_status,t.sample_result_status_desc=l.sample_result_status_desc)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.isLoading=!1;case 5:case"end":return r.stop()}}),o)})))()},returnSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.isLoading=!0,r.next=4,axios.post("/qm/ajax/qtm-machines/approval/return",l).then((function(e){var r=e.data.data,o=r.message,l=(r.sample&&JSON.parse(r.sample),r.approval_status_code?r.approval_status_code:"10");return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,l),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,l),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,l)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.isLoading=!1;case 5:case"end":return r.stop()}}),o)})))()},unapproveSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.isLoading=!0,r.next=4,axios.post("/qm/ajax/qtm-machines/approval/unapprove",l).then((function(e){var r=e.data.data,o=r.message,l=(r.sample&&JSON.parse(r.sample),r.approval_status_code?r.approval_status_code:"10");return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,l),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,l),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,l)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.isLoading=!1;case 5:case"end":return r.stop()}}),o)})))()}}};const v=(0,a(51900).Z)(m,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"800px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"2300px"}},[a("thead",[a("tr",[t._m(0),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    หมายเลขเครื่อง QTM\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    ประเภทของเครื่อง QTM\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"160px"},attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    Brand\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    Maker\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    วันที่เก็บตัวอย่าง\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"9%"}},[t._v("\n                    เวลาที่เก็บตัวอย่าง\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"9%"}},[t._v("\n                    เวลาที่วัด\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    สถานะการลงผล\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    สถานะผลการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    สถานะการยืนยันข้อมูล\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"150px"},attrs:{rowspan:"2",width:"18%"}},[t._v("\n                    สถานะการอนุมัติ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{colspan:"3",width:"9%"}},[t._v(" \n                    ระดับความรุนแรงของความผิดปกติ (จำนวน)\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{colspan:"3",width:"9%"}},[t._v(" \n                    ระดับความรุนแรงของความผิดปกติ (อาการ)\n                ")]),t._v(" "),a("th",{staticClass:"text-center md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"12%"}},[t._v("\n                    ชื่อไฟล์\n                ")]),t._v(" "),a("th",{staticClass:"text-center md:tw-table-cell tw-hidden",staticStyle:{"min-width":"120px"},attrs:{rowspan:"2",width:"8%"}},["result"==t.showType?a("div",[t._v("\n                        สามารถแก้ไขผลการตรวจสอบได้ \n                    ")]):a("div",[a("div",[t._v(" ยืนยันการรับทราบความผิดปกติ ")]),t._v(" "),a("div",{staticClass:"tw-text-2xs tw-text-gray-400"},[t._v(" (จากหน่วยงานต้นทาง) ")])])]),t._v(" "),a("th",{staticClass:"freeze-col-right",staticStyle:{"min-width":"100px"},attrs:{rowspan:"2",width:"10%"}},[a("div",{staticClass:"freeze-col-content"},[("2"==t.approvalRole.level_code||"3"==t.approvalRole.level_code)&&t.sampleItems.length>0?a("div",{staticClass:"tw-py-4"},[a("button",{staticClass:"btn btn-success tw-w-32",on:{click:function(e){return t.onApproveAllSampleClicked(t.approvalRole,e)}}},[a("i",{staticClass:"fa fa-check-square-o "}),t._v(" Approve All\n                            ")])]):a("div",[t._v("   ")])])])]),t._v(" "),t._m(1)]),t._v(" "),t.sampleItems.length>0?a("tbody",[t._l(t.sampleItems,(function(e,s){return[a("tr",{key:e.sample_no},[a("td",{staticClass:"freeze-col",staticStyle:{"min-width":"270px"}},[a("div",{staticClass:"freeze-col-content"},[a("div",{staticClass:"tw-inline-block tw-align-top tw-pr-2 tw-py-2",staticStyle:{"min-width":"45px","max-width":"45px"}},[a("div",{staticClass:"text-center"},[t._v("\n                                    "+t._s(s+1)+"\n                                ")])]),t._v(" "),a("div",{staticClass:"tw-inline-block tw-align-top tw-pl-4 tw-py-2",staticStyle:{"min-height":"100px","min-width":"190px","max-width":"190px","border-left":"1px solid #ddd"}},[t._v("\n                                "+t._s(e.sample_no)+"\n                            ")])])]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.machine_full_name)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.equipment_type?"QTM "+e.equipment_type:"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.brand)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.maker)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.date_drawn_show)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["result"==t.showType&&e.file_name&&t.isAllowEdit(e,t.approvalRole)?a("div",[a("qm-timepicker",{attrs:{id:"input_time_drawn_formatted_"+s,name:"time_drawn_formatted_"+s,value:e.time_drawn_formatted,clearable:!1},on:{close:function(a){return t.onSampleTimeDrawnClosed(a,e)},change:function(a){return t.onSampleTimeDrawnChanged(a,e)}}})],1):a("div",[t._v("\n                            "+t._s(e.time_drawn_formatted)+"\n                        ")])]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.test_time)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["PD"==e.sample_operation_status||"IP"==e.sample_operation_status?a("div",{staticClass:"tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_operation_status_desc)+" ")])]):"CP"==e.sample_operation_status?a("div",{staticClass:"tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_operation_status_desc)+" ")])]):"RJ"==e.sample_operation_status?a("div",{staticClass:"tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_operation_status_desc)+" ")])]):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["PD"==e.sample_result_status?a("div",{staticClass:"tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):"CF"==e.sample_result_status?a("div",{staticClass:"tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):"NC"==e.sample_result_status?a("div",{staticClass:"tw-text-red-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):"RJ"==e.sample_result_status?a("div",{staticClass:"tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["2"==e.confirm_code?a("span",{staticClass:"tw-font-semibold tw-text-green-500"},[t._v(" "+t._s(e.confirm_status?e.confirm_status:"")+" ")]):"3"==e.confirm_code?a("span",{staticClass:"tw-font-semibold tw-text-red-500"},[t._v(" "+t._s(e.confirm_status?e.confirm_status:"")+" ")]):a("span",{staticClass:"tw-font-semibold tw-text-gray-400"},[t._v(" "+t._s(e.confirm_status?e.confirm_status:"")+" ")])]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell tw-hidden"},[a("div",{staticClass:"tw-pb-1",staticStyle:{"border-bottom":"1px solid #eee"}},[a("span",{staticClass:"tw-font-semibold"},[t._v(" O : ")]),t._v(" "),"yellow"==e.operator_approval_status.status_color?a("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):"green"==e.operator_approval_status.status_color?a("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):"red"==e.operator_approval_status.status_color?a("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):a("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")])]),t._v(" "),a("div",{staticClass:"tw-py-1",staticStyle:{"border-bottom":"1px solid #eee"}},[a("span",{staticClass:"tw-font-semibold"},[t._v(" S : ")]),t._v(" "),"yellow"==e.supervisor_approval_status.status_color?a("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):"green"==e.supervisor_approval_status.status_color?a("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):"red"==e.supervisor_approval_status.status_color?a("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):a("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")])]),t._v(" "),a("div",{staticClass:"tw-pt-1"},[a("span",{staticClass:"tw-font-semibold"},[t._v(" L : ")]),t._v(" "),"yellow"==e.leader_approval_status.status_color?a("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):"green"==e.leader_approval_status.status_color?a("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):"red"==e.leader_approval_status.status_color?a("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):a("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")])])]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_minor?a("span",{staticClass:"fa fa-2x fa-check tw-text-blue-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_major?a("span",{staticClass:"fa fa-2x fa-check tw-text-yellow-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_critical?a("span",{staticClass:"fa fa-2x fa-check tw-text-red-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_minor?a("span",{staticClass:"fa fa-2x fa-check tw-text-blue-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_major?a("span",{staticClass:"fa fa-2x fa-check tw-text-yellow-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_critical?a("span",{staticClass:"fa fa-2x fa-check tw-text-red-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.file_name)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center"},["result"==t.showType?a("div",[t._v("\n                            -\n                        ")]):t._e(),t._v(" "),"track"==t.showType?a("div",[t._v("\n                            -\n                        ")]):t._e()]),t._v(" "),a("td",{staticClass:"freeze-col-right text-center text-nowrap",staticStyle:{"min-width":"100px"}},[a("div",{staticClass:"freeze-col-content"},[a("div",{staticClass:"tw-pb-2"},[a("button",{staticClass:"btn btn-sm btn-default tw-text-xs tw-w-20",on:{click:function(a){return t.onResultButtonClicked(e.sample_no,e.organization_id,e.inventory_item_id,a)}}},[a("i",{staticClass:"fa fa-edit"}),t._v(" Result\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowApproval(e,t.approvalRole)?t._e():a("div",{staticClass:"tw-pt-2",staticStyle:{"border-top":"1px solid #eee"}},[a("button",{staticClass:"btn btn-sm btn-success tw-text-xs tw-w-20",on:{click:function(a){return t.onApproveSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-check-square-o "}),t._v(" Approve\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowRejectApproval(e,t.approvalRole)?t._e():a("div",{staticClass:"tw-pt-2"},[a("button",{staticClass:"btn btn-sm btn-danger tw-text-xs tw-w-20",on:{click:function(a){return t.onRejectSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-times"}),t._v(" Reject\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowReturnApproval(e,t.approvalRole)?t._e():a("div",{staticClass:"tw-pt-2"},[a("button",{staticClass:"btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-20",on:{click:function(a){return t.onReturnSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-reply "}),t._v(" Return\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowUnapproveApproval(e,t.approvalRole)?t._e():a("div",{staticClass:"tw-pt-2",staticStyle:{"border-top":"1px solid #eee"}},[a("button",{staticClass:"btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-24",on:{click:function(a){return t.onUnapproveSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-times "}),t._v(" Unapprove\n                                ")])])])])]),t._v(" "),e.specification_showed?a("tr",{key:e.sample_no+"_line"},[a("td",{staticStyle:{"border-right":"0"},attrs:{colspan:"18"}},[a("qm-table-qtm-machine-results",{attrs:{"auth-user":t.authUser,"show-type":t.showType,"search-inputs":t.searchInputs,sample:e,items:e.specifications,"list-brands":t.listBrands,"list-makers":t.listMakers,"approval-data":t.approvalData,"approval-role":t.approvalRole,"result-items":e.results},on:{onSampleResultSubmitted:t.onSampleResultSubmitted,onConfirmSampleResult:t.onConfirmSampleResult,onRejectSampleResult:t.onRejectSampleResult,onCancelSampleResult:t.onCancelSampleResult}})],1),t._v(" "),a("td",{staticStyle:{"border-left":"0"},attrs:{colspan:"3"}})]):t._e()]}))],2):a("tbody",[t._m(2)])]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"freeze-col",staticStyle:{"min-width":"270px"},attrs:{rowspan:"2"}},[a("div",{staticClass:"freeze-col-content"},[a("div",{staticClass:"text-center tw-text-xs tw-inline-block tw-align-top tw-py-6",staticStyle:{"min-width":"45px","max-width":"45px"}},[t._v("\n                            ลำดับที่\n                        ")]),t._v(" "),a("div",{staticClass:"text-center tw-text-xs tw-inline-block tw-align-top tw-py-6",staticStyle:{"min-height":"50px","min-width":"190px","max-width":"190px","border-left":"1px solid #ddd"}},[t._v("\n                            เลขที่การตรวจสอบ\n                        ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.2rem"},attrs:{width:"5%"}},[t._v(" Minor ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.2rem"},attrs:{width:"5%"}},[t._v(" Major ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.2rem"},attrs:{width:"5%"}},[t._v(" Critical ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.2rem"},attrs:{width:"5%"}},[t._v(" Minor ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.2rem"},attrs:{width:"5%"}},[t._v(" Major ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.2rem"},attrs:{width:"5%"}},[t._v(" Critical ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"21"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports}}]);