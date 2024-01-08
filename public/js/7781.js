(self.webpackChunk=self.webpackChunk||[]).push([[7781],{27781:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>w});var s=a(87757),r=a.n(s),o=a(7398),l=a.n(o),n=a(30381),i=a.n(n);function c(t,e,a,s,r,o,l){try{var n=t[o](l),i=n.value}catch(t){return void a(t)}n.done?e(i):Promise.resolve(i).then(s,r)}function p(t){return function(){var e=this,a=arguments;return new Promise((function(s,r){var o=t.apply(e,a);function l(t){c(o,s,r,l,n,"next",t)}function n(t){c(o,s,r,l,n,"throw",t)}l(void 0)}))}}function _(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function d(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?_(Object(a),!0).forEach((function(e){u(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):_(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function u(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const v={props:["authUser","showType","items","locators","approvalData","total","page","perPage"],components:{Loading:l()},data:function(){var t=this;return{approvalRole:this.getApprovalRole(this.authUser,this.approvalData),sampleItems:JSON.parse(this.items).map((function(e){return d(d({},e),{},{approval_status_code:e.gmd_sample.attribute13?e.gmd_sample.attribute13:"10",operator_approval_status:t.getOperatorApprovalStatus(t.approvalData,e.gmd_sample.attribute13),supervisor_approval_status:t.getSupervisorApprovalStatus(t.approvalData,e.gmd_sample.attribute13),leader_approval_status:t.getLeaderApprovalStatus(t.approvalData,e.gmd_sample.attribute13),date_drawn_show:e.date_drawn_formatted?i()(e.date_drawn_formatted).add(543,"years").format("DD/MM/YYYY"):"",locator_desc:t.getLocatorDesc(e),location_full_desc:t.getLocationFullDesc(e),specification_showed:!1,specifications:[],results:[]})})),is_loading:!1}},methods:{getLocatorDesc:function(t){var e=this.locators.find((function(e){return e.inventory_location_id==t.locator_id}));return e?"".concat(e.locator_desc):""},getLocationFullDesc:function(t){var e=this.locators.find((function(e){return e.inventory_location_id==t.locator_id}));return e?"".concat(e.location_desc?e.location_desc:""," : ").concat(e.locator_desc?e.locator_desc:""):""},getApprovalRole:function(t,e){var a=t.username?t.username.toUpperCase():"";return e.map((function(t){return d(d({},t),{},{username:t.username,username_prefix:t.username.replace("-%","-")})})).find((function(t){return a.startsWith(t.username_prefix)}))},isAllowApproval:function(t,e){var a=!1;if(e){var s=e.level_code;"1"==s?"10"==t.approval_status_code&&(a=!0):"2"==s?"11"==t.approval_status_code&&(a=!0):"3"==s&&"21"==t.approval_status_code&&(a=!0)}return a},isAllowReturnApproval:function(t,e){var a=!1;if(e){var s=e.level_code;"2"==s?"11"==t.approval_status_code&&(a=!0):"3"==s&&"21"==t.approval_status_code&&(a=!0)}return a},getOperatorApprovalStatus:function(t,e){var a=t.find((function(t){return 1==t.level_code})),s="",r="";return e&&"10"!=e?"12"==e?(s=a.reject_status,r="red"):"11"!=e&&"21"!=e&&"22"!=e&&"31"!=e&&"32"!=e||(s=a.approved_status,r="green"):(s=a.pending_status,r="yellow"),{status_desc:s,status_color:r}},getSupervisorApprovalStatus:function(t,e){var a=t.find((function(t){return 2==t.level_code})),s="",r="";return"11"==e?(s=a.pending_status,r="yellow"):"22"==e?(s=a.reject_status,r="red"):"21"!=e&&"31"!=e&&"32"!=e||(s=a.approved_status,r="green"),{status_desc:s,status_color:r}},getLeaderApprovalStatus:function(t,e){var a=t.find((function(t){return 3==t.level_code})),s="",r="";return"21"==e?(s=a.pending_status,r="yellow"):"32"==e?(s=a.reject_status,r="red"):"31"==e&&(s=a.approved_status,r="green"),{status_desc:s,status_color:r}},onResultButtonClicked:function(t,e,a,s,o){var l=this;this.sampleItems.forEach(function(){var o=p(r().mark((function o(n,i){var c;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(n.sample_no!==t){r.next=12;break}if(l.sampleItems[i].specification_showed){r.next=9;break}return l.is_loading=!0,r.next=5,l.getSampleSpecifications(t,e,a,s);case 5:c=r.sent,l.sampleItems[i].specifications=c.specifications,l.sampleItems[i].results=c.results,l.is_loading=!1;case 9:l.sampleItems[i].specification_showed=!l.sampleItems[i].specification_showed,r.next=13;break;case 12:l.sampleItems[i].specification_showed=!1;case 13:case"end":return r.stop()}}),o)})));return function(t,e){return o.apply(this,arguments)}}())},getSampleSpecifications:function(t,e,a,s){var r={sample_no:t,organization_id:e,inventory_item_id:a,locator_id:s};return axios.get("/qm/ajax/tobaccos/get-sample-specifications",{params:r}).then((function(t){return{specifications:JSON.parse(t.data.data.specifications),results:JSON.parse(t.data.data.results)}}))},onSampleResultSubmitted:function(t){var e=this;if("success"==t.status){var a=t.sample_no,s=t.sample_disposition,r=t.sample_disposition_desc,o=t.severity_level_minor,l=t.severity_level_major,n=t.severity_level_critical;this.sampleItems.forEach((function(t,i){e.sampleItems[i].specification_showed=!1,e.sampleItems[i].sample_no==a&&(e.sampleItems[i].sample_disposition=s,e.sampleItems[i].sample_disposition_desc=r,e.sampleItems[i].severity_level_minor=o,e.sampleItems[i].severity_level_major=l,e.sampleItems[i].severity_level_critical=n)}))}},onCancelSampleResult:function(t){var e=this;this.sampleItems.forEach((function(t,a){e.sampleItems[a].specification_showed=!1}))},onApproveSampleClicked:function(t,e,a){var s=this,r="",o=e.level_code;"1"==o?r="ส่งอนุมัติ":"2"!=o&&"3"!=o||(r="อนุมัติผลการตรวจสอบ"),swal({title:"",text:"ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," ) ?"),showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.approveSample(t,e,r)}))},onRejectSampleClicked:function(t,e,a){var s=this,r="",o=e.level_code;"1"==o?r="ยกเลิกผลการทดสอบ":"2"!=o&&"3"!=o||(r="ไม่อนุมัติผลการตรวจสอบ"),swal({title:"",text:"ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," ) ?"),showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.rejectSample(t,e,r)}))},onReturnSampleClicked:function(t,e,a){var s=this,r="ส่งกลับการอนุมัติ";swal({title:"",text:"ต้องการ ".concat(r," (เลขที่การตรวจสอบ : ").concat(t.sample_no," ) ?"),showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ปิด",closeOnConfirm:!1},(function(a){a&&s.returnSample(t,e,r)}))},approveSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.is_loading=!0,r.next=4,axios.post("/qm/ajax/tobaccos/approval/approve",l).then((function(e){var r=e.data.data,o=r.message,l=(r.sample&&JSON.parse(r.sample),r.approval_status_code?r.approval_status_code:"10");return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,l),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,l),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,l)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.is_loading=!1;case 5:case"end":return r.stop()}}),o)})))()},rejectSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.is_loading=!0,r.next=4,axios.post("/qm/ajax/tobaccos/approval/reject",l).then((function(e){var r=e.data.data,o=r.message,l=(r.sample&&JSON.parse(r.sample),r.approval_status_code?r.approval_status_code:"10");return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,l),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,l),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,l)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.is_loading=!1;case 5:case"end":return r.stop()}}),o)})))()},returnSample:function(t,e,a){var s=this;return p(r().mark((function o(){var l;return r().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return l={organization_code:t.organization_code,oracle_sample_id:t.oracle_sample_id,sample_no:t.sample_no,approval_level_code:e.level_code},s.is_loading=!0,r.next=4,axios.post("/qm/ajax/tobaccos/approval/return",l).then((function(e){var r=e.data.data,o=r.message,l=(r.sample&&JSON.parse(r.sample),r.approval_status_code?r.approval_status_code:"10");return"success"==r.status&&(swal("Success","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no," )"),"success"),t.gmd_sample.attribute13=l,t.approval_status_code=l,t.operator_approval_status=s.getOperatorApprovalStatus(s.approvalData,l),t.supervisor_approval_status=s.getSupervisorApprovalStatus(s.approvalData,l),t.leader_approval_status=s.getLeaderApprovalStatus(s.approvalData,l)),"error"==r.status&&swal("Error","ไม่สามารถ ".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(o),"error"),r})).catch((function(e){console.log(e),resStoreSampleResultStatus="error",swal("Error","".concat(a," (เลขที่การตรวจสอบ : ").concat(t.sample_no,") | ").concat(e.message),"error")}));case 4:s.is_loading=!1;case 5:case"end":return r.stop()}}),o)})))()}}};const w=(0,a(51900).Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"800px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"1700px"}},[t._m(0),t._v(" "),t.sampleItems.length>0?a("tbody",[t._l(t.sampleItems,(function(e,s){return[a("tr",{key:e.sample_no},[a("td",{staticClass:"freeze-col",staticStyle:{"min-width":"300px"}},[a("div",{staticClass:"freeze-col-content"},[a("div",{staticClass:"tw-inline-block tw-align-top tw-pr-2 tw-py-2",staticStyle:{"min-width":"60px","max-width":"60px"}},[a("div",{staticClass:"text-center"},[t._v("\n                                    "+t._s(s+1)+"\n                                ")])]),t._v(" "),a("div",{staticClass:"tw-inline-block tw-align-top tw-pl-4 tw-py-2",staticStyle:{"min-height":"30px","min-width":"190px","max-width":"190px","border-left":"1px solid #ddd"}},[t._v("\n                                "+t._s(e.sample_no)+"\n                            ")])])]),t._v(" "),a("td",{staticClass:"text-center text-nowarp md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.qm_group)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.location_full_desc)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.sample_opt)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.feeder_name)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.date_drawn_show)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.time_drawn_formatted)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["1P"==e.sample_disposition?a("div",{staticClass:"tw-bg-yellow-300 tw-rounded tw-p-2 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_disposition_desc)+" ")])]):"3C"==e.sample_disposition?a("div",{staticClass:"tw-bg-green-300 tw-rounded tw-p-2 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_disposition_desc)+" ")])]):"2I"==e.sample_disposition?a("div",{staticClass:"tw-bg-red-300 tw-rounded tw-p-2 tw-leading-3 tw-font-semibold"},[a("span",{staticClass:"tw-text-xs"},[t._v(" "+t._s(e.sample_disposition_desc)+" ")])]):t._e()]),t._v(" "),a("td",{staticClass:"text-left md:tw-table-cell tw-hidden"},[a("div",{staticClass:"tw-pb-1",staticStyle:{"border-bottom":"1px solid #eee"}},[a("span",{staticClass:"tw-font-semibold"},[t._v(" O : ")]),t._v(" "),"yellow"==e.operator_approval_status.status_color?a("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):"green"==e.operator_approval_status.status_color?a("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):"red"==e.operator_approval_status.status_color?a("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")]):a("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.operator_approval_status.status_desc)+" ")])]),t._v(" "),a("div",{staticClass:"tw-py-1",staticStyle:{"border-bottom":"1px solid #eee"}},[a("span",{staticClass:"tw-font-semibold"},[t._v(" S : ")]),t._v(" "),"yellow"==e.supervisor_approval_status.status_color?a("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):"green"==e.supervisor_approval_status.status_color?a("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):"red"==e.supervisor_approval_status.status_color?a("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")]):a("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.supervisor_approval_status.status_desc)+" ")])]),t._v(" "),a("div",{staticClass:"tw-pt-1"},[a("span",{staticClass:"tw-font-semibold"},[t._v(" L : ")]),t._v(" "),"yellow"==e.leader_approval_status.status_color?a("span",{staticClass:"tw-text-yellow-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):"green"==e.leader_approval_status.status_color?a("span",{staticClass:"tw-text-green-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):"red"==e.leader_approval_status.status_color?a("span",{staticClass:"tw-text-red-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")]):a("span",{staticClass:"tw-text-gray-600 tw-text-xs tw-font-semibold"},[t._v(" "+t._s(e.leader_approval_status.status_desc)+" ")])])]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_minor?a("span",{staticClass:"fa fa-2x fa-check tw-text-blue-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_major?a("span",{staticClass:"fa fa-2x fa-check tw-text-yellow-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.severity_level_critical?a("span",{staticClass:"fa fa-2x fa-check tw-text-red-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_minor?a("span",{staticClass:"fa fa-2x fa-check tw-text-blue-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_major?a("span",{staticClass:"fa fa-2x fa-check tw-text-yellow-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center md:tw-table-cell tw-hidden"},["true"==e.test_serverity_code_critical?a("span",{staticClass:"fa fa-2x fa-check tw-text-red-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(" - ")]),t._v(" "),a("td",{staticClass:"freeze-col-right text-center text-nowrap",staticStyle:{"min-width":"100px"}},[a("div",{staticClass:"freeze-col-content"},[a("div",{staticClass:"tw-pb-2"},[a("button",{staticClass:"btn btn-sm btn-default tw-text-xs tw-w-20",on:{click:function(a){return t.onResultButtonClicked(e.sample_no,e.organization_id,e.inventory_item_id,e.locator_id,a)}}},[a("i",{staticClass:"fa fa-edit"}),t._v(" Result\n                                ")])]),t._v(" "),"approval"==t.showType&&t.isAllowApproval(e,t.approvalRole)?a("div",{staticClass:"tw-pt-2",staticStyle:{"border-top":"1px solid #eee"}},[a("button",{staticClass:"btn btn-sm btn-success tw-text-xs tw-w-20",on:{click:function(a){return t.onApproveSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-check-square-o "}),t._v(" Approve\n                                ")])]):t._e(),t._v(" "),"approval"==t.showType&&t.isAllowApproval(e,t.approvalRole)?a("div",{staticClass:"tw-pt-2"},[a("button",{staticClass:"btn btn-sm btn-danger tw-text-xs tw-w-20",on:{click:function(a){return t.onRejectSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-times"}),t._v(" Reject\n                                ")])]):t._e(),t._v(" "),"approval"==t.showType&&t.isAllowReturnApproval(e,t.approvalRole)?a("div",{staticClass:"tw-pt-2"},[a("button",{staticClass:"btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-20",on:{click:function(a){return t.onReturnSampleClicked(e,t.approvalRole,a)}}},[a("i",{staticClass:"fa fa-reply "}),t._v(" Return\n                                ")])]):t._e()])])]),t._v(" "),e.specification_showed?a("tr",{key:e.sample_no+"_line"},[a("td",{staticStyle:{"border-right":"0"},attrs:{colspan:"15"}},[a("qm-table-tobacco-results",{attrs:{"auth-user":t.authUser,"show-type":t.showType,"approval-data":t.approvalData,sample:JSON.stringify(e),items:JSON.stringify(e.specifications),"result-items":JSON.stringify(e.results)},on:{onSampleResultSubmitted:t.onSampleResultSubmitted,onCancelSampleResult:t.onCancelSampleResult}})],1),t._v(" "),a("td",{staticStyle:{"border-left":"0"},attrs:{colspan:"2"}})]):t._e()]}))],2):a("tbody",[t._m(1)])]),t._v(" "),a("loading",{attrs:{active:t.is_loading,"is-full-page":!0},on:{"update:active":function(e){t.is_loading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"freeze-col",staticStyle:{"min-width":"300px"},attrs:{rowspan:"2"}},[a("div",{staticClass:"freeze-col-content"},[a("div",{staticClass:"text-center tw-text-xs tw-inline-block tw-align-top tw-py-8",staticStyle:{"min-width":"60px","max-width":"60px"}},[t._v("\n                            ลำดับที่\n                        ")]),t._v(" "),a("div",{staticClass:"text-center tw-text-xs tw-inline-block tw-align-top tw-py-8",staticStyle:{"min-height":"30px","min-width":"190px","max-width":"190px","border-left":"1px solid #ddd"}},[t._v("\n                            เลขที่การตรวจสอบ\n                        ")])])]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"8%"}},[t._v("\n                    กลุ่มงาน\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"15%"}},[t._v("\n                    จุดตรวจสอบ\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    ตรา/ชุด\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"7%"}},[t._v("\n                    Feeder\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v("\n                    วันที่เก็บตัวอย่าง\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"8%"}},[t._v("\n                    เวลาที่เก็บตัวอย่าง\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"12%"}},[t._v("\n                    สถานะการตรวจสอบ\n                ")]),t._v(" "),a("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"150px"},attrs:{rowspan:"2",width:"15%"}},[t._v("\n                    สถานะการอนุมัติ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{colspan:"3"}},[t._v(" \n                    ระดับความรุนแรงของความผิดปกติ (จำนวน)\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{colspan:"3"}},[t._v(" \n                    ระดับความรุนแรงของความผิดปกติ (อาการ)\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",attrs:{rowspan:"2",width:"10%"}},[t._v(" สามารถแก้ไขผลการตรวจสอบได้ ")]),t._v(" "),a("th",{staticClass:"freeze-col-right",staticStyle:{"min-width":"100px"},attrs:{rowspan:"2",width:"10%"}},[a("div",{staticClass:"freeze-col-content"},[t._v("   ")])])]),t._v(" "),a("tr",[a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.35rem"},attrs:{width:"6%"}},[t._v(" Minor ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.35rem"},attrs:{width:"6%"}},[t._v(" Major ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.35rem"},attrs:{width:"6%"}},[t._v(" Critical ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.35rem"},attrs:{width:"6%"}},[t._v(" Minor ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.35rem"},attrs:{width:"6%"}},[t._v(" Major ")]),t._v(" "),a("th",{staticClass:"tw-text-xs text-center md:tw-table-cell tw-hidden",staticStyle:{top:"3.35rem"},attrs:{width:"6%"}},[t._v(" Critical ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"17"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports}}]);