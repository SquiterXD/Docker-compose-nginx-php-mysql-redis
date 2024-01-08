(self.webpackChunk=self.webpackChunk||[]).push([[7649],{77649:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>v});var s=a(87757),l=a.n(s),n=a(80455),i=a.n(n),r=a(7398),u=a.n(r);a(19371);function o(t,e,a,s,l,n,i){try{var r=t[n](i),u=r.value}catch(t){return void a(t)}r.done?e(u):Promise.resolve(u).then(s,l)}function _(t){return function(){var e=this,a=arguments;return new Promise((function(s,l){var n=t.apply(e,a);function i(t){o(n,s,l,i,r,"next",t)}function r(t){o(n,s,l,i,r,"throw",t)}i(void 0)}))}}function c(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function p(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?c(Object(a),!0).forEach((function(e){d(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):c(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function d(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const m={props:["authUser","showType","sample","items","resultItems","listBrands","listLeakPositions","approvalData","approvalRole"],components:{Loading:u(),VueNumeric:i()},data:function(){var t=this;return{sampleData:this.sample,specifications:this.items,sampleResults:this.resultItems.map((function(e){return p(p({},e),{},{result_status:t.calResultStatus(p(p({},e),{},{result_value:e.result_value})),failed_status:t.calFailedStatus(p(p({},e),{},{result_value:e.result_value})),cause_of_defect:e.cause_of_defect?e.cause_of_defect:""})})),listRequiredLeakPositions:this.listLeakPositions.filter((function(t){return"NONE"!=t.position_leak_value})),is_loading:!1}},mounted:function(){var t=this;this.sampleResults.map((function(e){return t.setDefaultLeakSampleInput(e),e}))},methods:{getOptimalValue:function(t,e){var a=t.find((function(t){return t.spec_id==e.spec_id&&t.test_id==e.test_id}));return a?a.optimal_value:""},getResultValue:function(t){var e=this.resultItems.find((function(e){return e.test_id==t.test_id}));return e?e.result_value:""},getBrandLabel:function(t){var e="";if(t){var a=this.listBrands.find((function(e){return e.brand_value==t}));e=a?a.brand_label:""}return e},getLeakPositionLabel:function(t){var e="";if(t){var a=this.listLeakPositions.find((function(e){return e.position_leak_value==t}));e=a?a.position_leak_label:""}return e},isAllowEdit:function(t,e){var a=!1;e&&("1"==e.level_code&&"10"==t.approval_status_code&&(a=!0));return a},onSampleResultChanged:function(t,e){e.result_value=t},calResultStatus:function(t){var e="";return t.min_value&&t.max_value&&t.result_value&&(e=parseFloat(t.result_value)>=parseFloat(t.min_value)&&parseFloat(t.result_value)<=parseFloat(t.max_value)?"PASSED":"FAILED"),this.calFailedStatus(t),t.result_status=e,this.setPositionLeakSampleResult(t),e},setPositionLeakSampleResult:function(t){if(this.sampleResults){var e=t.group_no,a=this.sampleResults.find((function(t){return"Y"==t.position_leak_flag&&t.group_no==e}));t.min_value&&t.max_value&&t.result_value&&(parseFloat(t.result_value)>=parseFloat(t.min_value)&&parseFloat(t.result_value)<=parseFloat(t.max_value)?a&&(a.position_leak_required=null,a.position_leak_entered="Y",0==t.result_value||"0"==t.result_value?a.result_value="NONE":a.result_value||(a.result_value="NONE")):a&&(a.position_leak_required="Y",a.position_leak_entered=null,a.result_value&&"NONE"!=a.result_value||(a.result_value=this.listRequiredLeakPositions[0].position_leak_value)))}},setDefaultLeakSampleInput:function(t){var e=t.group_no,a=this.sampleResults.find((function(t){return"Y"==t.position_leak_flag&&t.group_no==e}));t.min_value&&t.max_value&&t.result_value&&(parseFloat(t.result_value)>=parseFloat(t.min_value)&&parseFloat(t.result_value)<=parseFloat(t.max_value)?a&&(a.position_leak_required=null,a.position_leak_entered="Y",0==t.result_value||t.result_value):a&&(a.position_leak_required="Y",a.position_leak_entered=null))},calFailedStatus:function(t){var e="";return t.min_value&&t.max_value&&t.result_value&&(parseFloat(t.result_value)<parseFloat(t.min_value)&&(e="UNDER"),parseFloat(t.result_value)>parseFloat(t.max_value)&&(e="OVER")),t.failed_status=e,e},onSubmitSampleResult:function(t){var e=this;return _(l().mark((function t(){var a,s,n,i,r,u,o,_,c,p,d,m,v,f;return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(a=e,s=e.sampleResults.map((function(t){return{result_id:t.result_id,test_id:t.test_id,test_code:t.test_code,test_desc:t.test_desc,optimal_value:t.optimal_value,min_value:t.min_value,max_value:t.max_value,result_value:t.result_value?t.result_value:""}})),n={organization_code:e.sampleData.organization_code,oracle_sample_id:e.sampleData.oracle_sample_id,sample_no:e.sampleData.sample_no,sample_desc:e.sampleData.sample_desc,inventory_item_id:e.sampleData.inventory_item_id,item_number:e.sampleData.item_number,item_desc:e.sampleData.item_desc,date_drawn:e.sampleData.date_drawn,sample_disposition:e.sampleData.sample_disposition,sample_disposition_desc:e.sampleData.sample_disposition_desc,sample_operation_status:e.sampleData.sample_operation_status,sample_result_status:e.sampleData.sample_result_status,sample_id:e.sampleData.sample_id,department_code:e.sampleData.department_code,qm_group:e.sampleData.qm_group,organization_id:e.sampleData.organization_id,subinventory_code:e.sampleData.subinventory_code,locator_id:e.sampleData.locator_id,sample_date:e.sampleData.sample_date,batch_id:e.sampleData.batch_id,qc_area:e.sampleData.qc_area,machine_set:e.sampleData.machine_set,program_code:e.sampleData.program_code,result_quality_lines:JSON.stringify(s)},e.is_loading=!0,!(i=e.validateBeforeSave(e.sampleData,e.sampleResults)).valid){t.next=21;break}return r="success",u=e.sampleData.sample_disposition,o=e.sampleData.sample_disposition_desc,_=e.sampleData.sample_operation_status,c=e.sampleData.sample_operation_status_desc,p=e.sampleData.sample_result_status,d=e.sampleData.sample_result_status_desc,m=e.sampleData.severity_level_minor,v=e.sampleData.severity_level_major,f=e.sampleData.severity_level_critical,t.next=18,axios.post("/qm/ajax/packet-air-leaks/result",n).then((function(t){var e=t.data.data,s=e.message,l=e.sample?JSON.parse(e.sample):null;return r=e.status,l&&(u=l.sample_disposition,o=l.sample_disposition_desc,_=l.sample_operation_status,c=l.sample_operation_status_desc,p=l.sample_result_status,d=l.sample_result_status_desc,m=l.severity_level_minor,v=l.severity_level_major,f=l.severity_level_critical),"success"==e.status&&swal("Success","บันทึกลงผลการตรวจอัตราลมรั่วของซองบุหรี่ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no," )"),"success"),"error"==e.status&&swal("Error","บันทึกลงผลการตรวจอัตราลมรั่วของซองบุหรี่ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no,") | ").concat(s),"error"),e})).catch((function(t){console.log(t),r="error",swal("Error","บันทึกลงผลการตรวจอัตราลมรั่วของซองบุหรี่ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no,") | ").concat(t.message),"error")}));case 18:e.$emit("onSampleResultSubmitted",{status:r,sample_no:e.sampleData.sample_no,sample_disposition:u,sample_disposition_desc:o,sample_operation_status:_,sample_operation_status_desc:c,sample_result_status:p,sample_result_status_desc:d,severity_level_minor:m,severity_level_major:v,severity_level_critical:f}),t.next=22;break;case 21:swal("เกิดข้อผิดพลาด","".concat(i.message),"error");case 22:e.is_loading=!1;case 23:case"end":return t.stop()}}),t)})))()},onSubmitCauseOfDefect:function(t){var e=this;return _(l().mark((function t(){var a,s,n;return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a=e,s=e.sampleResults.map((function(t){return{result_id:t.result_id,test_id:t.test_id,test_code:t.test_code,test_desc:t.test_desc,cause_of_defect:t.cause_of_defect?t.cause_of_defect:""}})),n={organization_code:e.sampleData.organization_code,oracle_sample_id:e.sampleData.oracle_sample_id,sample_no:e.sampleData.sample_no,result_quality_lines:JSON.stringify(s)},e.is_loading=!0,"success",t.next=7,axios.post("/qm/ajax/packet-air-leaks/defect",n).then((function(t){var e=t.data.data,s=e.message;e.sample&&JSON.parse(e.sample);return e.status,"success"==e.status&&swal("Success","บันทึกสาเหตุความผิดปกติการตรวจอัตราลมรั่วของซองบุหรี่ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no," )"),"success"),"error"==e.status&&swal("Error","บันทึกสาเหตุความผิดปกติการตรวจอัตราลมรั่วของซองบุหรี่ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no,") | ").concat(s),"error"),e})).catch((function(t){console.log(t),"error",swal("Error","บันทึกสาเหตุความผิดปกติการตรวจอัตราลมรั่วของซองบุหรี่ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no,") | ").concat(t.message),"error")}));case 7:e.is_loading=!1;case 8:case"end":return t.stop()}}),t)})))()},onCancelSampleResult:function(t){this.$emit("onCancelSampleResult",t)},validateBeforeSave:function(t,e){var a={valid:!0,message:""};return e.filter((function(t){return!t.result_value&&"Y"!=t.read_only})).length>0&&(a.valid=!1,a.message='กรูณากรอกข้อมูล "ผลการตรวจสอบ" ให้ครบถ้วน'),a}}};const v=(0,a(51900).Z)(m,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"tw-ml-10 tw-mr-10 tw-py-2"},[a("table",{staticClass:"table table-borderless-horizontal mb-0"},[a("thead",[a("tr",[a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"7%"}},[t._v("\n                    ลำดับที่\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100",staticStyle:{"z-index":"auto"},attrs:{width:"25%"}},[t._v("\n                    ชื่อการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"12%"}},[t._v("\n                    ค่ามาตรฐาน\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"8%"}},[t._v("\n                    ค่าOPTIMAL\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"12%"}},[t._v("\n                    ผลการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}},[t._v("\n                    หน่วยนับ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"8%"}},[t._v("\n                    อยู่ในช่วงควบคุม\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}}),t._v(" "),"defect"==t.showType?a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"20%"}},[t._v("\n                    สาเหตุ\n                ")]):t._e()])]),t._v(" "),t.sampleResults.length>0?a("tbody",[t._l(t.sampleResults,(function(e,s){return[a("tr",{key:s,class:"Y"==e.read_only?"tw-bg-gray-100 tw-bg-opacity-60":""},[a("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.seq)+"\n                    ")]),t._v(" "),a("td",{},[t._v("\n                        "+t._s(e.test_desc)+"\n                        "),"Y"!=e.optional_ind?a("span",{staticClass:"tw-text-red-600"},[t._v(" * ")]):t._e()]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"},[t._v("\n                        "+t._s(e.min_value)+" -\n                        "+t._s(e.max_value)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-text-green-600 tw-font-bold tw-hidden"},[t._v("\n                        "+t._s(e.optimal_value)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center"},["result"==t.showType&&"Y"!=e.read_only&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("div",["Y"==e.brand_flag?[a("qm-el-select",{attrs:{id:"input_result_value_"+s,name:"result_value_"+s,"option-key":"brand_value","option-value":"brand_value","option-label":"brand_label","select-options":t.listBrands,value:e.result_value,size:"small",clearable:!0,filterable:!0},on:{onSelected:function(a){return t.onSampleResultChanged(a,e)}}})]:"Y"==e.position_leak_flag?["Y"==e.position_leak_required?[a("div",{staticClass:"qm-el-select-required"},[a("qm-el-select",{attrs:{id:"input_result_value_"+s,name:"result_value_"+s,"option-key":"position_leak_value","option-value":"position_leak_value","option-label":"position_leak_label","select-options":t.listRequiredLeakPositions,value:e.result_value,size:"small",filterable:!0},on:{onSelected:function(a){return t.onSampleResultChanged(a,e)}}})],1)]:"Y"==e.position_leak_entered?[a("div",{staticClass:"qm-el-select-required"},[a("qm-el-select",{attrs:{id:"input_result_value_"+s,name:"result_value_"+s,"option-key":"position_leak_value","option-value":"position_leak_value","option-label":"position_leak_label","select-options":t.listLeakPositions,value:e.result_value,size:"small",filterable:!0},on:{onSelected:function(a){return t.onSampleResultChanged(a,e)}}})],1)]:[a("qm-el-select",{attrs:{id:"input_result_value_"+s,name:"result_value_"+s,"option-key":"position_leak_value","option-value":"position_leak_value","option-label":"position_leak_label","select-options":t.listLeakPositions,value:e.result_value,size:"small",clearable:!0,filterable:!0},on:{onSelected:function(a){return t.onSampleResultChanged(a,e)}}})]]:e.test&&"Y"==e.test.time_flag?[a("qm-timepicker",{attrs:{id:"input_result_value_"+s,name:"result_value_"+s,value:e.result_value},on:{change:function(a){return t.onSampleResultChanged(a,e)}}})]:"N"==e.data_type_code?[a("input",{directives:[{name:"model",rawName:"v-model",value:e.result_value,expression:"sampleResult.result_value"}],staticClass:"form-control input-sm text-center",attrs:{id:"input_result_value_"+s,type:"number",min:"0",oninput:"this.value = Math.abs(this.value)",name:"result_value_"+s,placeholder:""},domProps:{value:e.result_value},on:{change:function(a){return t.calResultStatus(e)},input:function(a){a.target.composing||t.$set(e,"result_value",a.target.value)}}})]:[a("input",{directives:[{name:"model",rawName:"v-model",value:e.result_value,expression:"sampleResult.result_value"}],staticClass:"form-control input-sm text-center",attrs:{id:"input_result_value_"+s,type:"text",name:"result_value_"+s,placeholder:""},domProps:{value:e.result_value},on:{change:function(a){return t.calResultStatus(e)},input:function(a){a.target.composing||t.$set(e,"result_value",a.target.value)}}})]],2):a("div",{staticClass:"tw-px-2"},["Y"==e.brand_flag?[t._v("\n                                "+t._s(e.result_value?t.getBrandLabel(e.result_value):"-")+"\n                            ")]:"Y"==e.position_leak_flag?[t._v("\n                                "+t._s(e.result_value?t.getLeakPositionLabel(e.result_value):"-")+"\n                            ")]:[t._v("\n                                "+t._s(e.result_value?e.result_value:"-")+"\n                            ")]],2)]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.test_unit?""+e.test_unit:"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["PASSED"==e.result_status?a("span",{staticClass:"fa fa-2x fa-check-circle tw-text-green-500"}):t._e(),t._v(" "),"FAILED"==e.result_status?a("span",{staticClass:"fa fa-2x fa-times tw-text-red-500"}):t._e(),t._v(" "),e.result_status?t._e():a("span",{staticClass:"fa fa-2x fa-minus"})]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["UNDER"==e.failed_status?a("span",{staticClass:"fa fa-2x fa-arrow-down tw-text-blue-500"}):t._e(),t._v(" "),"OVER"==e.failed_status?a("span",{staticClass:"fa fa-2x fa-arrow-up tw-text-red-500"}):t._e()]),t._v(" "),"defect"==t.showType?a("td",{staticClass:"text-left tw-text-xs md:tw-table-cell",staticStyle:{"padding-right":"0px"}},["FAILED"==e.result_status?[a("input",{directives:[{name:"model",rawName:"v-model",value:e.cause_of_defect,expression:"sampleResult.cause_of_defect"}],staticClass:"form-control input-sm text-left",attrs:{type:"text",disabled:!t.isAllowEdit(t.sampleData,t.approvalRole),placeholder:"ระบุสาเหตุ"},domProps:{value:e.cause_of_defect},on:{input:function(a){a.target.composing||t.$set(e,"cause_of_defect",a.target.value)}}})]:[a("input",{staticClass:"form-control input-sm text-left",attrs:{type:"text",disabled:""}})]],2):t._e()])]})),t._v(" "),"result"!=t.showType&&"defect"!=t.showType||!t.isAllowEdit(t.sampleData,t.approvalRole)?t._e():a("tr",[a("td",{attrs:{colspan:"8"}},[a("div",{staticClass:"row justify-content-center clearfix tw-my-4"},[a("div",{staticClass:"col text-center"},["result"==t.showType?a("button",{staticClass:"btn btn-md btn-success tw-w-32",attrs:{type:"button"},on:{click:function(e){return t.onSubmitSampleResult(e)}}},[a("i",{staticClass:"fa fa-save"}),t._v(" บันทึก\n                            ")]):t._e(),t._v(" "),"defect"==t.showType?a("button",{staticClass:"btn btn-md btn-success tw-w-32",attrs:{type:"button"},on:{click:function(e){return t.onSubmitCauseOfDefect(e)}}},[a("i",{staticClass:"fa fa-save"}),t._v(" บันทึก\n                            ")]):t._e(),t._v(" "),a("button",{staticClass:"btn btn-md btn-danger tw-w-32 tw-ml-4",attrs:{type:"button"},on:{click:t.onCancelSampleResult}},[a("i",{staticClass:"fa fa-times"}),t._v(" ปิด\n                            ")])])])])])],2):a("tbody",[t._m(0)])]),t._v(" "),a("loading",{attrs:{active:t.is_loading,"is-full-page":!0},on:{"update:active":function(e){t.is_loading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"7"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports}}]);