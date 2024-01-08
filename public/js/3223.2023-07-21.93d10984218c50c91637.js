(self.webpackChunk=self.webpackChunk||[]).push([[3223],{13223:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>m});var s=a(87757),l=a.n(s),n=a(80455),i=a.n(n),r=a(7398),u=a.n(r);a(19371),a(30381);function o(t,e,a,s,l,n,i){try{var r=t[n](i),u=r.value}catch(t){return void a(t)}r.done?e(u):Promise.resolve(u).then(s,l)}function c(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function _(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?c(Object(a),!0).forEach((function(e){p(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):c(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function p(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const d={props:["authUser","showType","approvalData","approvalRole","sample","items","resultItems"],components:{Loading:u(),VueNumeric:i()},data:function(){var t=this;return{sampleData:this.sample,specifications:this.items,sampleResults:this.resultItems.map((function(e){return _(_({},e),{},{result_status:t.calResultStatus(_(_({},e),{},{result_value:e.result_value})),failed_status:t.calFailedStatus(_(_({},e),{},{result_value:e.result_value})),cause_of_defect:e.cause_of_defect})})),is_loading:!1}},methods:{getOptimalValue:function(t,e){var a=t.find((function(t){return t.spec_id==e.spec_id&&t.test_id==e.test_id}));return a?a.optimal_value:""},getResultValue:function(t){var e=this.resultItems.find((function(e){return e.test_id==t.test_id}));return e?e.result_value:""},isAllowEdit:function(t,e){var a=!1;e&&("1"==e.level_code&&"10"==t.approval_status_code&&(a=!0));return a},calResultStatus:function(t){var e="";return t.min_value&&t.max_value&&""!==t.result_value&&null!==t.result_value&&(e=parseFloat(t.result_value)>=parseFloat(t.min_value)&&parseFloat(t.result_value)<=parseFloat(t.max_value)?"PASSED":"FAILED",this.calFailedStatus(t)),t.result_status=e,e},calFailedStatus:function(t){var e="";return t.min_value&&t.max_value&&""!==t.result_value&&null!==t.result_value&&(parseFloat(t.result_value)<parseFloat(t.min_value)&&(e="UNDER"),parseFloat(t.result_value)>parseFloat(t.max_value)&&(e="OVER")),t.failed_status=e,e},onSubmitSampleResult:function(t){var e,a=this;return(e=l().mark((function t(){var e,s,n,i,r,u,o,c,_;return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=a.sampleResults.map((function(t){return{result_id:t.result_id,test_id:t.test_id,test_code:t.test_code,test_desc:t.test_desc,optimal_value:t.optimal_value,min_value:t.min_value,max_value:t.max_value,result_value:t.result_value,cause_of_defect:t.cause_of_defect?t.cause_of_defect:""}})),s={organization_code:a.sampleData.organization_code,oracle_sample_id:a.sampleData.oracle_sample_id,sample_no:a.sampleData.sample_no,sample_desc:a.sampleData.sample_desc,inventory_item_id:a.sampleData.inventory_item_id,item_number:a.sampleData.item_number,item_desc:a.sampleData.item_desc,date_drawn:a.sampleData.date_drawn,sample_disposition:a.sampleData.sample_disposition,sample_disposition_desc:a.sampleData.sample_disposition_desc,sample_operation_status:a.sampleData.sample_operation_status,sample_result_status:a.sampleData.sample_result_status,sample_id:a.sampleData.sample_id,department_code:a.sampleData.department_code,qm_group:a.sampleData.qm_group,organization_id:a.sampleData.organization_id,subinventory_code:a.sampleData.subinventory_code,locator_id:a.sampleData.locator_id,sample_date:a.sampleData.sample_date,batch_id:a.sampleData.batch_id,qc_area:a.sampleData.qc_area,machine_set:a.sampleData.machine_set,program_code:a.sampleData.program_code,result_quality_lines:JSON.stringify(e)},a.is_loading=!0,n="success",i=a.sampleData.sample_disposition,r=a.sampleData.sample_disposition_desc,u=a.sampleData.sample_operation_status,o=a.sampleData.sample_operation_status_desc,c=a.sampleData.sample_result_status,_=a.sampleData.sample_result_status_desc,t.next=12,axios.post("/qm/ajax/moth-outbreaks/result",s).then((function(t){var e=t.data.data,s=e.message,l=e.sample?JSON.parse(e.sample):null;return n=e.status,l&&(i=l.sample_disposition,r=l.sample_disposition_desc,u=l.sample_operation_status,o=l.sample_operation_status_desc,c=l.sample_result_status,_=l.sample_result_status_desc),"success"==e.status&&swal("Success","บันทึกลงผลการการระบาดของมอดยาสูบ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no," )"),"success"),"error"==e.status&&swal("Error","บันทึกลงผลการการระบาดของมอดยาสูบ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no,") | ").concat(s),"error"),e})).catch((function(t){console.log(t),n="error",swal("Error","บันทึกลงผลการการระบาดของมอดยาสูบ (เลขที่การตรวจสอบ\t: ".concat(a.sampleData.sample_no,") | ").concat(t.message),"error")}));case 12:a.is_loading=!1,a.$emit("onSampleResultSubmitted",{status:n,sample_no:a.sampleData.sample_no,sample_disposition:i,sample_disposition_desc:r,sample_operation_status:u,sample_operation_status_desc:o,sample_result_status:c,sample_result_status_desc:_});case 14:case"end":return t.stop()}}),t)})),function(){var t=this,a=arguments;return new Promise((function(s,l){var n=e.apply(t,a);function i(t){o(n,s,l,i,r,"next",t)}function r(t){o(n,s,l,i,r,"throw",t)}i(void 0)}))})()},onCancelSampleResult:function(t){this.$emit("onCancelSampleResult",t)}}};const m=(0,a(51900).Z)(d,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"tw-ml-10 tw-mr-20 tw-py-2"},[a("table",{staticClass:"table table-borderless-horizontal mb-0"},[t._m(0),t._v(" "),t.sampleResults.length>0?a("tbody",[t._l(t.sampleResults,(function(e,s){return[a("tr",{key:s,class:"Y"==e.read_only?"tw-bg-gray-100 tw-bg-opacity-60":""},[a("td",{},[t._v("\n                        "+t._s(e.test_desc)+"\n                        "),"Y"!=e.optional_ind?a("span",{staticClass:"tw-text-red-600"},[t._v(" * ")]):t._e()]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"},[t._v("\n                        "+t._s(e.min_value?parseFloat(e.min_value):"")+" -\n                        "+t._s(e.max_value?parseFloat(e.max_value):"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-text-green-600 tw-font-bold tw-hidden"},[t._v("\n                        "+t._s(e.optimal_value)+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.result_value?parseFloat(e.result_value):"-")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.test_unit?""+e.test_unit:"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["PASSED"==e.result_status?a("span",{staticClass:"fa fa-2x fa-check-circle tw-text-green-500"}):t._e(),t._v(" "),"FAILED"==e.result_status?a("span",{staticClass:"fa fa-2x fa-times tw-text-red-500"}):t._e(),t._v(" "),e.result_status?t._e():a("span",{staticClass:"fa fa-2x fa-minus"})]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["UNDER"==e.failed_status?a("span",{staticClass:"fa fa-2x fa-arrow-down tw-text-blue-500"}):t._e(),t._v(" "),"OVER"==e.failed_status?a("span",{staticClass:"fa fa-2x fa-arrow-up tw-text-red-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["result"==t.showType&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("div",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.cause_of_defect,expression:"sampleResult.cause_of_defect"}],staticClass:"form-control input-sm tw-text-xs text-left",attrs:{type:"text",disabled:"PASSED"==e.result_status,placeholder:"วิธีป้องกันและกำจัดมอดยาสูบ"},domProps:{value:e.cause_of_defect},on:{input:function(a){a.target.composing||t.$set(e,"cause_of_defect",a.target.value)}}})]):a("div",{staticClass:"tw-py-2"},["PASSED"!=e.result_status?a("span",[t._v("\n                                "+t._s(e.cause_of_defect)+"\n                            ")]):t._e()])])])]})),t._v(" "),"result"==t.showType&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("tr",[a("td",{attrs:{colspan:"7"}},[a("div",{staticClass:"row justify-content-center clearfix tw-my-4"},[a("div",{staticClass:"col text-center"},[a("button",{staticClass:"btn btn-md btn-success tw-w-32",attrs:{type:"button"},on:{click:function(e){return t.onSubmitSampleResult(e)}}},[a("i",{staticClass:"fa fa-save"}),t._v(" บันทึก\n                            ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-danger tw-w-32 tw-ml-4",attrs:{type:"button"},on:{click:t.onCancelSampleResult}},[a("i",{staticClass:"fa fa-times"}),t._v(" ปิด\n                            ")])])])])]):t._e()],2):a("tbody",[t._m(1)])]),t._v(" "),a("loading",{attrs:{active:t.is_loading,"is-full-page":!0},on:{"update:active":function(e){t.is_loading=e}}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100",staticStyle:{"z-index":"auto"},attrs:{width:"20%"}},[t._v("\n                    ชื่อการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}},[t._v("\n                    ค่าควบคุม\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"7%"}},[t._v("\n                    ค่าOPTIMAL\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}},[t._v("\n                    ผลการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}},[t._v("\n                    หน่วยนับ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}},[t._v("\n                    อยู่ในเกณฑ์มาตรฐาน\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"8%"}}),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"20%"}},[t._v("\n                    วิธีป้องกันและกำจัดมอดยาสูบ\n                ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"7"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports}}]);