(self.webpackChunk=self.webpackChunk||[]).push([[3046],{78813:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>n});var s=a(23645),l=a.n(s)()((function(t){return t[1]}));l.push([t.id,".v--modal-overlay[data-v-0a22a09c]{z-index:2000;padding-top:3rem;padding-bottom:3rem}",""]);const n=l},63046:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>x});var s=a(87757),l=a.n(s),n=a(80455),i=a.n(n),r=a(7398),o=a.n(r),u=(a(2223),a(30381)),c=a.n(u);const m={props:["modalName","modalWidth","modalHeight","sample","sampleResult","batchItems"],components:{Loading:o()},watch:{sample:function(t){this.sampleItem=t||[]},sampleResult:function(t){this.sampleResultItem=t||[]},batchItems:function(t){this.inputBatchItems=t||[]}},data:function(){return{isLoading:!1,width:this.modalWidth,sampleItem:this.sample?this.sample:null,sampleResultItem:this.sampleResult?this.sampleResult:null,inputBatchItems:this.batchItems?this.batchItems:[]}},created:function(){this.handleResize()},mounted:function(){},methods:{handleResize:function(){window.innerWidth<768?this.width="90%":window.innerWidth<992?this.width="80%":this.width=this.modalWidth},onSelectMesBatchItem:function(t,e){this.$modal.hide(this.modalName),this.$emit("onSelectMesBatchItem",{sample:this.sampleItem,sample_result:this.sampleResultItem,batch_item:e})},formatDateTh:function(t){return t?c()(t).add(543,"years").format("DD/MM/YYYY"):""}}};a(37883);var _=a(51900);const d=(0,_.Z)(m,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticStyle:{"z-index":"100"}},[a("modal",{attrs:{name:t.modalName,width:t.width,scrollable:!0,height:t.modalHeight,shiftX:.5,shiftY:.5}},[a("div",{staticClass:"p-2 text-left"},[a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"480px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"600px"}},[a("thead",[a("tr",[a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"15%"}},[t._v("\n                                BATCH ID\n                            ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"15%"}},[t._v("\n                                หัววัดความชื้น\n                            ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"15%"}},[t._v("\n                                เวลา\n                            ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-right md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"30%"}},[t._v("\n                                ค่าความชื้น\n                            ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}})])]),t._v(" "),t.inputBatchItems.length>0?a("tbody",[t._l(t.inputBatchItems,(function(e,s){return[a("tr",{key:s},[a("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden"},[t._v("\n                                    "+t._s(e.batch_id)+"\n                                ")]),t._v(" "),a("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden"},[t._v("\n                                    "+t._s(e.moisture_point)+"\n                                ")]),t._v(" "),a("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden"},[a("strong",[t._v(" "+t._s(e.blend_time)+" ")])]),t._v(" "),a("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-right md:tw-table-cell tw-hidden"},[a("strong",[t._v(" "+t._s(e.moisture_value)+" ")])]),t._v(" "),a("td",{staticClass:"text-center"},[a("button",{staticClass:"btn btn-xs btn-primary",attrs:{type:"button"},on:{click:function(a){return t.onSelectMesBatchItem(a,e)}}},[t._v(" \n                                        เลือก\n                                    ")])])])]}))],2):a("tbody",[a("tr",[a("td",{attrs:{colspan:"6"}},[a("h2",{staticClass:"px-5 tw-py-40 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])])])])])]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[],!1,null,"0a22a09c",null).exports;function p(t,e,a,s,l,n,i){try{var r=t[n](i),o=r.value}catch(t){return void a(t)}r.done?e(o):Promise.resolve(o).then(s,l)}function v(t){return function(){var e=this,a=arguments;return new Promise((function(s,l){var n=t.apply(e,a);function i(t){p(n,s,l,i,r,"next",t)}function r(t){p(n,s,l,i,r,"throw",t)}i(void 0)}))}}function h(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function w(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?h(Object(a),!0).forEach((function(e){f(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):h(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function f(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const b={props:["authUser","showType","approvalData","approvalRole","sample","items","resultItems"],components:{Loading:o(),VueNumeric:i(),ModalMesFlagSampleResults:d},watch:{sample:function(t){this.sampleData=t,this.getMesBatchItems(this.sampleData)},items:function(t){this.specifications=t},resultItems:function(t){var e=this;this.sampleResults=t.map((function(t){return w(w({},item),{},{result_status:e.calResultStatus(w(w({},item),{},{result_value:item.result_value})),failed_status:e.calFailedStatus(w(w({},item),{},{result_value:item.result_value}))})}))}},data:function(){var t=this;return{sampleData:this.sample,specifications:this.items,sampleResults:this.resultItems.map((function(e){return w(w({},e),{},{result_status:t.calResultStatus(w(w({},e),{},{result_value:e.result_value})),failed_status:t.calFailedStatus(w(w({},e),{},{result_value:e.result_value}))})})),mesBatchItems:[],selectedMesSampleResult:null,is_loading:!1}},mounted:function(){this.sample&&this.getMesBatchItems(this.sample)},methods:{getResultValue:function(t){var e=this.resultItems.find((function(e){return e.test_id==t.test_id}));return e?e.result_value:""},getMesBatchItems:function(t){var e=this;return v(l().mark((function a(){var s;return l().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s={sample_no:t.sample_no},a.abrupt("return",axios.get("/qm/ajax/tobaccos/get-mes-batch-items",{params:s}).then((function(t){var a=t.data.data;return e.mesBatchItems=a.batch_items?JSON.parse(a.batch_items):[],a.batch_items?JSON.parse(a.batch_items):[]})));case 2:case"end":return a.stop()}}),a)})))()},isAllowEdit:function(t,e){var a=!1;e&&("1"==e.level_code&&"10"==t.approval_status_code&&(a=!0));return a},calResultStatus:function(t){var e="";return t.min_value&&t.max_value&&""!==t.result_value&&null!==t.result_value&&(e=parseFloat(t.result_value)>=parseFloat(t.min_value)&&parseFloat(t.result_value)<=parseFloat(t.max_value)?"PASSED":"FAILED",this.calFailedStatus(t)),t.result_status=e,e},calFailedStatus:function(t){var e="";return t.min_value&&t.max_value&&""!==t.result_value&&null!==t.result_value&&(parseFloat(t.result_value)<parseFloat(t.min_value)&&(e="UNDER"),parseFloat(t.result_value)>parseFloat(t.max_value)&&(e="OVER")),t.failed_status=e,e},onShowModalUpdateMesResultValue:function(t,e){this.selectedMesSampleResult=e,window.scrollTo(0,150),this.$modal.show("modal-mes-flag-sample-results")},onSelectMesBatchItem:function(t){var e=this.sampleResults.find((function(e){return e.test_id==t.sample_result.test_id}));e&&(e.result_value=t.batch_item.moisture_value)},onSubmitSampleResult:function(t){var e=this;return v(l().mark((function t(){var a,s,n,i,r,o,u,c,m,_,d,p,v;return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(a=e.sampleResults.map((function(t){return{result_id:t.result_id,test_id:t.test_id,test_code:t.test_code,test_desc:t.test_desc,optimal_value:t.optimal_value,min_value:t.min_value,max_value:t.max_value,result_value:t.result_value,remark_no_result:t.remark_no_result?t.remark_no_result:""}})),s={organization_code:e.sampleData.organization_code,oracle_sample_id:e.sampleData.oracle_sample_id,sample_no:e.sampleData.sample_no,sample_desc:e.sampleData.sample_desc,inventory_item_id:e.sampleData.inventory_item_id,item_number:e.sampleData.item_number,item_desc:e.sampleData.item_desc,date_drawn:e.sampleData.date_drawn,sample_disposition:e.sampleData.sample_disposition,sample_disposition_desc:e.sampleData.sample_disposition_desc,sample_operation_status:e.sampleData.sample_operation_status,sample_result_status:e.sampleData.sample_result_status,sample_id:e.sampleData.sample_id,department_code:e.sampleData.department_code,qm_group:e.sampleData.qm_group,organization_id:e.sampleData.organization_id,subinventory_code:e.sampleData.subinventory_code,locator_id:e.sampleData.locator_id,sample_date:e.sampleData.sample_date,opt:e.sampleData.opt,qc_area:e.sampleData.qc_area,machine_set:e.sampleData.machine_set,program_code:e.sampleData.program_code,result_quality_lines:JSON.stringify(a)},e.is_loading=!0,!(n=e.validateBeforeSave(e.sampleData,e.sampleResults)).valid){t.next=20;break}return i="success",r=e.sampleData.sample_disposition,o=e.sampleData.sample_disposition_desc,u=e.sampleData.sample_operation_status,c=e.sampleData.sample_operation_status_desc,m=e.sampleData.sample_result_status,_=e.sampleData.sample_result_status_desc,d=e.sampleData.severity_level_minor,p=e.sampleData.severity_level_major,v=e.sampleData.severity_level_critical,t.next=17,axios.post("/qm/ajax/tobaccos/result",s).then((function(t){var a=t.data.data,s=a.message,l=a.sample?JSON.parse(a.sample):null;return i=a.status,l&&(r=l.sample_disposition,o=l.sample_disposition_desc,u=l.sample_operation_status,c=l.sample_operation_status_desc,m=l.sample_result_status,_=l.sample_result_status_desc,d=l.severity_level_minor,p=l.severity_level_major,v=l.severity_level_critical),"success"==a.status&&swal("Success",'บันทึกผลการตรวจสอบคุณภาพ กลุ่มผลิตด้านใบยา (จุดตรวจสอบ : "'.concat(e.sampleData.location_full_desc,'", วัน/เวลา : "').concat(e.sampleData.date_drawn_show," ").concat(e.sampleData.time_drawn_formatted,'", เลขที่การตรวจสอบ : "').concat(e.sampleData.sample_no,'" )'),"success"),"error"==a.status&&swal("Error",'บันทึกผลการตรวจสอบคุณภาพ กลุ่มผลิตด้านใบยา (จุดตรวจสอบ : "'.concat(e.sampleData.location_full_desc,'", วัน/เวลา : "').concat(e.sampleData.date_drawn_show," ").concat(e.sampleData.time_drawn_formatted,'", เลขที่การตรวจสอบ : "').concat(e.sampleData.sample_no,'" ) | ').concat(s),"error"),a})).catch((function(t){console.log(t),i="error",swal("Error",'บันทึกผลการตรวจสอบคุณภาพ กลุ่มผลิตด้านใบยา (จุดตรวจสอบ : "'.concat(e.sampleData.location_full_desc,'", วัน/เวลา : "').concat(e.sampleData.date_drawn_show," ").concat(e.sampleData.time_drawn_formatted,'", เลขที่การตรวจสอบ : "').concat(e.sampleData.sample_no,'" ) | ').concat(t.message),"error")}));case 17:e.$emit("onSampleResultSubmitted",{status:i,sample_no:e.sampleData.sample_no,sample_disposition:r,sample_disposition_desc:o,sample_operation_status:u,sample_operation_status_desc:c,sample_result_status:m,sample_result_status_desc:_,severity_level_minor:d,severity_level_major:p,severity_level_critical:v}),t.next=21;break;case 20:swal("เกิดข้อผิดพลาด","".concat(n.message),"error");case 21:e.is_loading=!1;case 22:case"end":return t.stop()}}),t)})))()},onCancelSampleResult:function(t){this.$emit("onCancelSampleResult",t)},validateBeforeSave:function(t,e){var a={valid:!0,message:""};if(e.filter((function(t){return(""===t.result_value||null===t.result_value)&&!t.remark_no_result&&"Y"!=t.read_only})).length>0)a.valid=!1,a.message='กรุณากรอกข้อมูล "ผลการตรวจสอบ" ให้ครบถ้วน';else{var s=e.filter((function(t){return"N"==t.data_type_code&&(parseFloat(t.result_value)<parseFloat(t.test_min_value_num)||parseFloat(t.result_value)>parseFloat(t.test_max_value_num))}));s.length>0&&(a.valid=!1,a.message='ผลการตรวจสอบ : "'.concat(s[0].test_desc,'" ไม่ถูกต้อง กรุณาตรวจสอบ (ค่าต่ำสุด: ').concat(s[0].test_min_value_num,", ค่าสูงสุด: ").concat(s[0].test_max_value_num,")"))}return a}}};const x=(0,_.Z)(b,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"tw-ml-10 tw-mr-10 tw-py-2"},[a("table",{staticClass:"table table-borderless-horizontal mb-0"},[t._m(0),t._v(" "),t.sampleResults.length>0?a("tbody",[t._l(t.sampleResults,(function(e,s){return[a("tr",{key:s,class:"Y"==e.read_only?"tw-bg-gray-100 tw-bg-opacity-60":""},[a("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.seq)+"\n                    ")]),t._v(" "),a("td",{},[t._v("\n                        "+t._s(e.test_desc)+"\n                        "),"Y"!=e.optional_ind?a("span",{staticClass:"tw-text-red-600"},[t._v(" * ")]):t._e()]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"},[t._v("\n                        "+t._s(e.min_value?parseFloat(e.min_value):"")+" -\n                        "+t._s(e.max_value?parseFloat(e.max_value):"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-text-green-600 tw-font-bold tw-hidden"},[t._v("\n                        "+t._s(e.optimal_value?parseFloat(e.optimal_value):"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center"},["result"==t.showType&&"Y"!=e.read_only&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("div",["N"==e.data_type_code?[a("input",{directives:[{name:"model",rawName:"v-model",value:e.result_value,expression:"sampleResult.result_value"}],staticClass:"form-control input-sm text-center",attrs:{id:"input_result_value_"+s,type:"number",name:"result_value_"+s,placeholder:""},domProps:{value:e.result_value},on:{change:function(a){return t.calResultStatus(e)},input:function(a){a.target.composing||t.$set(e,"result_value",a.target.value)}}})]:[a("input",{directives:[{name:"model",rawName:"v-model",value:e.result_value,expression:"sampleResult.result_value"}],staticClass:"form-control input-sm text-center",attrs:{id:"input_result_value_"+s,type:"text",name:"result_value_"+s,placeholder:""},domProps:{value:e.result_value},on:{change:function(a){return t.calResultStatus(e)},input:function(a){a.target.composing||t.$set(e,"result_value",a.target.value)}}})]],2):a("div",{staticClass:"tw-px-2"},["result"==t.showType&&t.isAllowEdit(t.sampleData,t.approvalRole)&&"Y"==e.mes_flag&&!t.sampleData.batch_id?[a("input",{directives:[{name:"model",rawName:"v-model",value:e.result_value,expression:"sampleResult.result_value"}],staticClass:"form-control input-sm text-center",attrs:{id:"input_result_value_"+s,type:"number",name:"result_value_"+s,placeholder:""},domProps:{value:e.result_value},on:{change:function(a){return t.calResultStatus(e)},input:function(a){a.target.composing||t.$set(e,"result_value",a.target.value)}}})]:[t._v("\n                                "+t._s(null!=e.result_value?parseFloat(e.result_value):"-")+"\n                            ")]],2)]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.test_unit?""+e.test_unit:"")+"\n                    ")]),t._v(" "),a("td",{staticClass:"text-center"},["Y"==e.mes_flag&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("button",{staticClass:"btn btn-xs btn-warning",attrs:{type:"button"},on:{click:function(a){return t.onShowModalUpdateMesResultValue(a,e)}}},[t._v("\n                            แก้ไขผล\n                        ")]):t._e()]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["PASSED"==e.result_status?a("span",{staticClass:"fa fa-2x fa-check-circle tw-text-green-500"}):t._e(),t._v(" "),"FAILED"==e.result_status?a("span",{staticClass:"fa fa-2x fa-times tw-text-red-500"}):t._e(),t._v(" "),e.result_status?t._e():a("span",{staticClass:"fa fa-2x fa-minus"})]),t._v(" "),a("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},["UNDER"==e.failed_status?a("span",{staticClass:"fa fa-2x fa-arrow-down tw-text-blue-500"}):t._e(),t._v(" "),"OVER"==e.failed_status?a("span",{staticClass:"fa fa-2x fa-arrow-up tw-text-red-500"}):t._e()]),t._v(" "),a("td",{staticClass:"text-center"},["result"==t.showType&&"Y"!=e.read_only&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("div",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.remark_no_result,expression:"sampleResult.remark_no_result"}],staticClass:"form-control input-sm text-center",attrs:{id:"input_remark_no_result_"+s,type:"text",name:"remark_no_result_"+s,placeholder:""},domProps:{value:e.remark_no_result},on:{input:function(a){a.target.composing||t.$set(e,"remark_no_result",a.target.value)}}})]):a("div",{staticClass:"tw-px-2"},[t._v("\n                            "+t._s(e.remark_no_result?e.remark_no_result:"-")+"\n                        ")])])])]})),t._v(" "),"result"==t.showType&&t.isAllowEdit(t.sampleData,t.approvalRole)?a("tr",[a("td",{attrs:{colspan:"7"}},[a("div",{staticClass:"row justify-content-center clearfix tw-my-4"},[a("div",{staticClass:"col text-center"},[a("button",{staticClass:"btn btn-md btn-success tw-w-32",attrs:{type:"button"},on:{click:function(e){return t.onSubmitSampleResult(e)}}},[a("i",{staticClass:"fa fa-save"}),t._v(" บันทึก\n                            ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-danger tw-w-32 tw-ml-4",attrs:{type:"button"},on:{click:t.onCancelSampleResult}},[a("i",{staticClass:"fa fa-times"}),t._v(" ปิด\n                            ")])])])])]):t._e()],2):a("tbody",[t._m(1)])]),t._v(" "),a("loading",{attrs:{active:t.is_loading,"is-full-page":!0},on:{"update:active":function(e){t.is_loading=e}}}),t._v(" "),a("modal-mes-flag-sample-results",{attrs:{"modal-name":"modal-mes-flag-sample-results","modal-width":"640","modal-height":"400",sample:t.sampleData,"sample-result":t.selectedMesSampleResult,"batch-items":t.mesBatchItems},on:{onSelectMesBatchItem:t.onSelectMesBatchItem}})],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"7%"}},[t._v("\n                    ลำดับที่\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100",staticStyle:{"z-index":"auto"},attrs:{width:"25%"}},[t._v("\n                    ชื่อการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"15%"}},[t._v("\n                    ค่ามาตรฐาน\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}},[t._v("\n                    ค่าOPTIMAL\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"12%"}},[t._v("\n                    ผลการทดสอบ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}},[t._v("\n                    หน่วยนับ\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",staticStyle:{"z-index":"auto"},attrs:{width:"6%"}}),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"8%"}},[t._v("\n                    อยู่ในเกณฑ์มาตรฐาน\n                ")]),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}}),t._v(" "),a("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"12%"}},[t._v("\n                    หมายเหตุไม่ลงผลการทดสอบ\n                ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"8"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v("ไม่พบข้อมูล")])])])}],!1,null,null,null).exports},37883:(t,e,a)=>{var s=a(78813);s.__esModule&&(s=s.default),"string"==typeof s&&(s=[[t.id,s,""]]),s.locals&&(t.exports=s.locals);(0,a(45346).Z)("7391a496",s,!0,{})}}]);