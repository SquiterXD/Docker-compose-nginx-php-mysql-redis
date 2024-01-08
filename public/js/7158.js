(self.webpackChunk=self.webpackChunk||[]).push([[7158],{57158:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>w});var a=s(87757),o=s.n(a),r=s(7398),l=s.n(r),n=s(30381),c=s.n(n);function i(t,e,s,a,o,r,l){try{var n=t[r](l),c=n.value}catch(t){return void s(t)}n.done?e(c):Promise.resolve(c).then(a,o)}function p(t){return function(){var e=this,s=arguments;return new Promise((function(a,o){var r=t.apply(e,s);function l(t){i(r,a,o,l,n,"next",t)}function n(t){i(r,a,o,l,n,"throw",t)}l(void 0)}))}}function _(t,e){var s=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),s.push.apply(s,a)}return s}function d(t){for(var e=1;e<arguments.length;e++){var s=null!=arguments[e]?arguments[e]:{};e%2?_(Object(s),!0).forEach((function(e){u(t,e,s[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(s)):_(Object(s)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(s,e))}))}return t}function u(t,e,s){return e in t?Object.defineProperty(t,e,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[e]=s,t}const v={props:["authUser","showType","items","locators","approvalData","approvalRole","total","page","perPage"],components:{Loading:l()},data:function(){var t=this;return{sampleItems:JSON.parse(this.items).map((function(e){return d(d({},e),{},{approval_status_code:e.gmd_sample.attribute13?e.gmd_sample.attribute13:"10",operator_approval_status:t.getOperatorApprovalStatus(t.approvalData,e.gmd_sample.attribute13),supervisor_approval_status:t.getSupervisorApprovalStatus(t.approvalData,e.gmd_sample.attribute13),leader_approval_status:t.getLeaderApprovalStatus(t.approvalData,e.gmd_sample.attribute13),date_drawn_show:e.date_drawn_formatted?c()(e.date_drawn_formatted).add(543,"years").format("DD/MM/YYYY"):"",locator_desc:t.getLocatorDesc(e),location_full_desc:t.getLocationFullDesc(e),specification_showed:!1,specifications:[],results:[]})})),isLoading:!1}},methods:{getLocatorDesc:function(t){var e=this.locators.find((function(e){return e.inventory_location_id==t.locator_id}));return e?"".concat(e.locator_desc):""},getLocationFullDesc:function(t){var e=this.locators.find((function(e){return e.inventory_location_id==t.locator_id}));return e?"".concat(e.location_desc?e.location_desc:""," : ").concat(e.locator_desc?e.locator_desc:""):""},isAllowApproval:function(t,e){var s=!1;if("CP"==t.sample_operation_status&&e){var a=e.level_code;"1"==a?"10"==t.approval_status_code&&(s=!0):"2"==a?"11"==t.approval_status_code&&(s=!0):"3"==a&&"21"==t.approval_status_code&&(s=!0)}return s},isAllowRejectApproval:function(t,e){var s=!1;if(e){var a=e.level_code;"1"==a?"10"==t.approval_status_code&&(s=!0):"2"==a?"11"==t.approval_status_code&&(s=!0):"3"==a&&"21"==t.approval_status_code&&(s=!0)}return s},isAllowReturnApproval:function(t,e){var s=!1;if(e){var a=e.level_code;"2"==a?"11"==t.approval_status_code&&(s=!0):"3"==a&&"21"==t.approval_status_code&&(s=!0)}return s},getOperatorApprovalStatus:function(t,e){var s=t.find((function(t){return 1==t.level_code})),a="",o="";return e&&"10"!=e?"12"==e?(a=s.reject_status,o="red"):"11"!=e&&"21"!=e&&"22"!=e&&"31"!=e&&"32"!=e||(a=s.approved_status,o="green"):(a=s.pending_status,o="yellow"),{status_desc:a,status_color:o}},getSupervisorApprovalStatus:function(t,e){var s=t.find((function(t){return 2==t.level_code})),a="",o="";return"11"==e?(a=s.pending_status,o="yellow"):"22"==e?(a=s.reject_status,o="red"):"21"!=e&&"31"!=e&&"32"!=e||(a=s.approved_status,o="green"),{status_desc:a,status_color:o}},getLeaderApprovalStatus:function(t,e){var s=t.find((function(t){return 3==t.level_code})),a="",o="";return"21"==e?(a=s.pending_status,o="yellow"):"32"==e?(a=s.reject_status,o="red"):"31"==e&&(a=s.approved_status,o="green"),{status_desc:a,status_color:o}},onResultButtonClicked:function(t,e,s,a,r){var l=this;this.sampleItems.forEach(function(){var r=p(o().mark((function r(n,c){var i;return o().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:if(n.sample_no!==t){o.next=12;break}if(l.sampleItems[c].specification_showed){o.next=9;break}return l.isLoading=!0,o.next=5,l.getSampleSpecifications(t,e,s,a);case 5:i=o.sent,l.sampleItems[c].specifications=i.specifications,l.sampleItems[c].results=i.results,l.isLoading=!1;case 9:l.sampleItems[c].specification_showed=!l.sampleItems[c].specification_showed,o.next=13;break;case 12:l.sampleItems[c].specification_showed=!1;case 13:case"end":return o.stop()}}),r)})));return function(t,e){return r.apply(this,arguments)}}())},getSampleSpecifications:function(t,e,s,a){var o={sample_no:t,organization_id:e,inventory_item_id:s,locator_id:a};return axios.get("/qm/ajax/tobaccos/get-sample-specifications",{params:o}).then((function(t){return{specifications:JSON.parse(t.data.data.specifications),results:JSON.parse(t.data.data.results)}}))},onSampleResultSubmitted:function(t){var e=this;if("success"==t.status){var s=t.sample_no,a=t.sample_disposition,o=t.sample_disposition_desc,r=t.sample_operation_status,l=t.sample_operation_status_desc,n=t.sample_result_status,c=t.sample_result_status_desc,i=t.severity_level_minor,p=t.severity_level_major,_=t.severity_level_critical;this.sampleItems.forEach((function(t,d){e.sampleItems[d].sample_no==s&&(e.sampleItems[d].sample_disposition=a,e.sampleItems[d].sample_disposition_desc=o,e.sampleItems[d].sample_operation_status=r,e.sampleItems[d].sample_operation_status_desc=l,e.sampleItems[d].sample_result_status=n,e.sampleItems[d].sample_result_status_desc=c,e.sampleItems[d].severity_level_minor=i,e.sampleItems[d].severity_level_major=p,e.sampleItems[d].severity_level_critical=_)}))}},onCancelSampleResult:function(t){var e=this;this.sampleItems.forEach((function(t,s){e.sampleItems[s].specification_showed=!1}))},onApproveSampleClicked:function(t,e,s){var a=this,o="",r=e.level_code;"1"==r?o="ส่งอนุมัติ":"2"!=r&&"3"!=r||(o="อนุมัติผลการตรวจสอบ");var l=t.sample_disposition_desc,n="ต้องการ ".concat(o," (เลขที่การตรวจสอบ : ").concat(t.sample_no," | สถานะ : ").concat(l," ) ?");swal({title:"",text:n,showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(s){s&&a.approveSample(t,e,o)}))},onApproveAllSampleClicked:function(t,e){var s=this,a="",o=t.level_code;"1"==o?a="ส่งอนุมัติ":"2"!=o&&"3"!=o||(a="อนุมัติผลการตรวจสอบ");var r=this.sampleItems.filter((function(e){return s.isAllowApproval(e,t)})).map((function(t){return t.sample_no}));if(console.log("Approving SampleNos : "),console.log(r),r.length<=0)swal("Error","ไม่พบเลขที่การตรวจสอบ ที่สามารถ".concat(a,"ได้ "),"error");else{var l="ต้องการ ".concat(a," ทั้งหมด ").concat(r.length," รายการ ) ?");swal({title:"",text:l,showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(e){e&&s.approveAllSamples(r,t,a)}))}},onRejectSampleClicked:function(t,e,s){var a=this,o="",r=e.level_code;"1"==r?o="ยกเลิกผลการทดสอบ":"2"!=r&&"3"!=r||(o="ไม่อนุมัติผลการตรวจสอบ");var l=t.sample_disposition_desc,n="ต้องการ ".concat(o," (เลขที่การตรวจสอบ : ").concat(t.sample_no," | สถานะ : ").concat(l," ) ?");swal({title:"",text:n,showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(s){s&&a.rejectSample(t,e,o)}))},onReturnSampleClicked:function(t,e,s){var a=this,o="ส่งกลับการอนุมัติ";swal({title:"",text:"ต้องการ ".concat(o," (เลขที่การตรวจสอบ : ").concat(t.sample_no," ) ?"),showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(s){s&&a.returnSample(t,e,o)}))},approveSample:function(t,e,s){var a=this;return p(o().mark((function r(){var l;return o().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},a.isLoading=!0,o.next=4,axios.post("/qm/ajax/tobaccos/approval/approve",l).then((function(e){var o=e.data.data,r=o.message,l=(o.sample&&JSON.parse(o.sample),o.approval_status_code?o.approval_status_code:"10");return"success"==o.status&&(swal("Success","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=a.getOperatorApprovalStatus(a.approvalData,l),t.supervisor_approval_status=a.getSupervisorApprovalStatus(a.approvalData,l),t.leader_approval_status=a.getLeaderApprovalStatus(a.approvalData,l)),"error"==o.status&&swal("Error","ไม่สามารถ ".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(r),"error"),o})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:a.isLoading=!1;case 5:case"end":return o.stop()}}),r)})))()},approveAllSamples:function(t,e,s){var a=this;return p(o().mark((function r(){var l;return o().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return l={sample_nos:JSON.stringify(t),approval_level_code:e.level_code},a.isLoading=!0,o.next=4,axios.post("/qm/ajax/tobaccos/approval/approve-all",l).then((function(e){var a=e.data.data,o=a.message;return"success"==a.status&&(swal("Success","".concat(s," ( เลขที่การตรวจสอบ : ").concat(t.length," รายการ } )"),"success"),location.reload()),"error"==a.status&&swal("Error","ไม่สามารถ ".concat(s," (เลขที่การตรวจสอบ : ").concat(t.length," รายการ }) | ").concat(o),"error"),a})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.length," รายการ }) | ").concat(e.message),"error")}));case 4:a.isLoading=!1;case 5:case"end":return o.stop()}}),r)})))()},rejectSample:function(t,e,s){var a=this;return p(o().mark((function r(){var l;return o().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},a.isLoading=!0,o.next=4,axios.post("/qm/ajax/tobaccos/approval/reject",l).then((function(e){var o=e.data.data,r=o.message,l=o.sample?JSON.parse(o.sample):null,n=o.approval_status_code?o.approval_status_code:"10";return"success"==o.status&&(swal("Success","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=n,t.approval_status_code=n,t.operator_approval_status=a.getOperatorApprovalStatus(a.approvalData,n),t.supervisor_approval_status=a.getSupervisorApprovalStatus(a.approvalData,n),t.leader_approval_status=a.getLeaderApprovalStatus(a.approvalData,n),l&&(t.sample_operation_status=l.sample_operation_status,t.sample_operation_status_desc=l.sample_operation_status_desc,t.sample_result_status=l.sample_result_status,t.sample_result_status_desc=l.sample_result_status_desc)),"error"==o.status&&swal("Error","ไม่สามารถ ".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(r),"error"),o})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:a.isLoading=!1;case 5:case"end":return o.stop()}}),r)})))()},returnSample:function(t,e,s){var a=this;return p(o().mark((function r(){var l;return o().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},a.isLoading=!0,o.next=4,axios.post("/qm/ajax/tobaccos/approval/return",l).then((function(e){var o=e.data.data,r=o.message,l=(o.sample&&JSON.parse(o.sample),o.approval_status_code?o.approval_status_code:"10");return"success"==o.status&&(swal("Success","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=a.getOperatorApprovalStatus(a.approvalData,l),t.supervisor_approval_status=a.getSupervisorApprovalStatus(a.approvalData,l),t.leader_approval_status=a.getLeaderApprovalStatus(a.approvalData,l)),"error"==o.status&&swal("Error","ไม่สามารถ ".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(r),"error"),o})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(s," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:a.isLoading=!1;case 5:case"end":return o.stop()}}),r)})))()}}};const w=(0,s(51900).Z)(v,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"table-responsive",staticStyle:{"max-height":"800px"}},[s("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"1900px"}},[s("thead",[s("tr",[t._m(0),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"8%"}},[t._v("\n                    กลุ่มงาน\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"15%"}},[t._v("\n                    จุดตรวจสอบ\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    ตรา/ชุด\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    Feeder\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    วันที่เก็บตัวอย่าง\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"8%"}},[t._v("\n                    เวลาที่เก็บตัวอย่าง\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"12%"}},[t._v("\n                    สถานะการลงผล\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"12%"}},[t._v("\n                    สถานะผลการทดสอบ\n                ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"150px"},attrs:{rowspan:"2",width:"15%"}},[t._v("\n                    สถานะการอนุมัติ\n                ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{colspan:"3"}},[t._v(" \n                    ระดับความรุนแรงของความผิดปกติ (จำนวน)\n                ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{colspan:"3"}},[t._v(" \n                    ระดับความรุนแรงของความผิดปกติ (อาการ)\n                ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v(" สามารถแก้ไขผลการตรวจสอบได้ ")]),t._v(" "),s("th",{staticClass:"freeze-col-right",staticStyle:{"min-width":"100px"},attrs:{rowspan:"2",width:"10%"}},[s("div",{staticClass:"freeze-col-content"},[("2"==t.approvalRole.level_code||"3"==t.approvalRole.level_code)&&t.sampleItems.length>0?s("div",{staticClass:"tw-py-4"},[s("button",{staticClass:"btn btn-success tw-w-32",on:{click:function(e){return t.onApproveAllSampleClicked(t.approvalRole,e)}}},[s("i",{staticClass:"fa fa-check-square-o "}),t._v(" Approve All\n                            ")])]):s("div",[t._v("   ")])])])]),t._v(" "),t._m(1)]),t._v(" "),t.sampleItems.length>0?s("tbody",[t._l(t.sampleItems,(function(e,a){return[s("tr",{key:e.sample_no},[s("td",{staticClass:"freeze-col",staticStyle:{"min-width":"300px"}},[s("div",{staticClass:"freeze-col-content"},[s("div",{staticClass:"tw-inline-block tw-align-top tw-pr-2 tw-py-2",staticStyle:{"min-width":"60px","max-width":"60px"}},[s("div",{staticClass:"text-center"},[t._v("\n                                    "+t._s(a+1)+"\n                                ")])]),t._v(" "),s("div",{staticClass:"tw-inline-block tw-align-top tw-pl-4 tw-py-2",staticStyle:{"min-height":"100px","min-width":"190px","max-width":"190px","border-left":"1px solid #ddd"}},[t._v("\n                                "+t._s(e.sample_no)+"\n                            ")])])]),t._v(" "),s("td",{staticClass:"text-center text-nowarp md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.qm_group)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-left md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.location_full_desc)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.sample_opt)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.feeder_name)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.date_drawn_show)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.time_drawn_formatted)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["PD"==e.sample_operation_status||"IP"==e.sample_operation_status?s("div",{staticClass:"tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_operation_status_desc)+" ")])]):"CP"==e.sample_operation_status?s("div",{staticClass:"tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_operation_status_desc)+" ")])]):"RJ"==e.sample_operation_status?s("div",{staticClass:"tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_operation_status_desc)+" ")])]):t._e()]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["PD"==e.sample_result_status?s("div",{staticClass:"tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):"CF"==e.sample_result_status?s("div",{staticClass:"tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):"NC"==e.sample_result_status?s("div",{staticClass:"tw-text-red-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):"RJ"==e.sample_result_status?s("div",{staticClass:"tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"},[s("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_result_status_desc)+" ")])]):t._e()]),t._v(" "),s("td",{staticClass:"text-left md:tw-table-cell tw-hidden"},[s("div",{staticClass:"tw-pb-1",staticStyle:{"border-bottom":"1px solid #eee"}},[s("span",{staticClass:"tw-font-semibold"},[t._v(" O : ")]),t._v(" "),"yellow"==e.operator_approval_status.status_color?s("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):"green"==e.operator_approval_status.status_color?s("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):"red"==e.operator_approval_status.status_color?s("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):s("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")])]),t._v(" "),s("div",{staticClass:"tw-py-1",staticStyle:{"border-bottom":"1px solid #eee"}},[s("span",{staticClass:"tw-font-semibold"},[t._v(" S : ")]),t._v(" "),"yellow"==e.supervisor_approval_status.status_color?s("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):"green"==e.supervisor_approval_status.status_color?s("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):"red"==e.supervisor_approval_status.status_color?s("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):s("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")])]),t._v(" "),s("div",{staticClass:"tw-pt-1"},[s("span",{staticClass:"tw-font-semibold"},[t._v(" L : ")]),t._v(" "),"yellow"==e.leader_approval_status.status_color?s("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):"green"==e.leader_approval_status.status_color?s("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):"red"==e.leader_approval_status.status_color?s("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):s("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")])])]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_minor?s("span",{staticClass:"fa fa-2x fa-check tw-text-blue-500"}):t._e()]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_major?s("span",{staticClass:"fa fa-2x fa-check tw-text-yellow-500"}):t._e()]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_critical?s("span",{staticClass:"fa fa-2x fa-check tw-text-red-500"}):t._e()]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_minor?s("span",{staticClass:"fa fa-2x fa-check tw-text-blue-500"}):t._e()]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_major?s("span",{staticClass:"fa fa-2x fa-check tw-text-yellow-500"}):t._e()]),t._v(" "),s("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_critical?s("span",{staticClass:"fa fa-2x fa-check tw-text-red-500"}):t._e()]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" - ")]),t._v(" "),s("td",{staticClass:"freeze-col-right text-center text-nowrap",staticStyle:{"min-width":"100px"}},[s("div",{staticClass:"freeze-col-content"},[s("div",{staticClass:"tw-pb-2"},[s("button",{staticClass:"btn btn-sm btn-default tw-text-xs tw-w-20",on:{click:function(s){return t.onResultButtonClicked(e.sample_no,e.organization_id,e.inventory_item_id,e.locator_id,s)}}},[s("i",{staticClass:"fa fa-edit"}),t._v(" Result\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowApproval(e,t.approvalRole)?t._e():s("div",{staticClass:"tw-pt-2",staticStyle:{"border-top":"1px solid #eee"}},[s("button",{staticClass:"btn btn-sm btn-success tw-text-xs tw-w-20",on:{click:function(s){return t.onApproveSampleClicked(e,t.approvalRole,s)}}},[s("i",{staticClass:"fa fa-check-square-o "}),t._v(" Approve\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowRejectApproval(e,t.approvalRole)?t._e():s("div",{staticClass:"tw-pt-2"},[s("button",{staticClass:"btn btn-sm btn-danger tw-text-xs tw-w-20",on:{click:function(s){return t.onRejectSampleClicked(e,t.approvalRole,s)}}},[s("i",{staticClass:"fa fa-times"}),t._v(" Reject\n                                ")])]),t._v(" "),"result"!=t.showType&&"approval"!=t.showType||!t.isAllowReturnApproval(e,t.approvalRole)?t._e():s("div",{staticClass:"tw-pt-2"},[s("button",{staticClass:"btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-20",on:{click:function(s){return t.onReturnSampleClicked(e,t.approvalRole,s)}}},[s("i",{staticClass:"fa fa-reply "}),t._v(" Return\n                                ")])])])])]),t._v(" "),e.specification_showed?s("tr",{key:e.sample_no+"_line"},[s("td",{staticStyle:{"border-right":"0"},attrs:{colspan:"16"}},[s("qm-table-tobacco-results",{attrs:{"auth-user":t.authUser,"show-type":t.showType,"approval-data":t.approvalData,"approval-role":t.approvalRole,sample:e,items:e.specifications,"result-items":e.results},on:{onSampleResultSubmitted:t.onSampleResultSubmitted,onCancelSampleResult:t.onCancelSampleResult}})],1),t._v(" "),s("td",{staticStyle:{"border-left":"0"},attrs:{colspan:"2"}})]):t._e()]}))],2):s("tbody",[t._m(2)])]),t._v(" "),s("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("th",{staticClass:"freeze-col",staticStyle:{"min-width":"300px"},attrs:{rowspan:"2"}},[s("div",{staticClass:"freeze-col-content"},[s("div",{staticClass:"text-center tw-text-xs tw-inline-block tw-align-top tw-py-8",staticStyle:{"min-width":"60px","max-width":"60px"}},[t._v("\n                            ลำดับที่\n                        ")]),t._v(" "),s("div",{staticClass:"text-center tw-text-xs tw-inline-block tw-align-top tw-py-8",staticStyle:{"min-height":"50px","min-width":"190px","max-width":"190px","border-left":"1px solid #ddd"}},[t._v("\n                            เลขที่การตรวจสอบ\n                        ")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.75rem"},attrs:{width:"6%"}},[t._v(" Minor ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.75rem"},attrs:{width:"6%"}},[t._v(" Major ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.75rem"},attrs:{width:"6%"}},[t._v(" Critical ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.75rem"},attrs:{width:"6%"}},[t._v(" Minor ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.75rem"},attrs:{width:"6%"}},[t._v(" Major ")]),t._v(" "),s("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.75rem"},attrs:{width:"6%"}},[t._v(" Critical ")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{attrs:{colspan:"18"}},[s("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports}}]);