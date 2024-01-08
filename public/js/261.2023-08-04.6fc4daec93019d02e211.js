(self.webpackChunk=self.webpackChunk||[]).push([[261],{60261:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>C});var r=a(87757),o=a.n(r),s=a(7398),n=a.n(s),c=(a(19371),a(30381)),i=a.n(c),d=a(80455),l=a.n(d);function p(e,t,a,r,o,s,n){try{var c=e[s](n),i=c.value}catch(e){return void a(e)}c.done?t(i):Promise.resolve(i).then(r,o)}function u(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,r)}return a}function m(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?u(Object(a),!0).forEach((function(t){_(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):u(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}function _(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}const b={props:["paramIdValue","paramHeader","workorderProcesses","uomCodes"],components:{Loading:n(),VueNumeric:l()},watch:{paramIdValue:function(e){this.paramId=e},paramHeader:function(e){this.paramHeaderData=e},workorderProcesses:function(e){var t=this;this.workorderProcessItems=e?e.map((function(e){return m(m({},e),{},{selected:"Y"==e.freeze_flag,uom_code_desc:t.getUomCodeDescription(t.uomCodes,e.uom_code),complete_date_ts:e.complete_date?i()(e.complete_date):null,complete_date_thai:e.complete_date?i()(e.complete_date).add(543,"year").format("DD/MM/YYYY"):"-",closed_date_thai:e.closed_date?i()(e.closed_date).add(543,"year").format("DD/MM/YYYY"):"-"})})):[]}},data:function(){var e=this;return{selectAll:!1,paramId:this.paramIdValue,paramHeaderData:this.paramHeader,workorderProcessItems:this.workorderProcesses.map((function(t){return m(m({},t),{},{selected:"Y"==t.freeze_flag,uom_code_desc:e.getUomCodeDescription(e.uomCodes,t.uom_code),complete_date_ts:t.complete_date?i()(t.complete_date):null,complete_date_thai:t.complete_date?i()(t.complete_date).add(543,"year").format("DD/MM/YYYY"):"-",closed_date_thai:t.closed_date?i()(t.closed_date).add(543,"year").format("DD/MM/YYYY"):"-"})})),isLoading:!1}},mounted:function(){},computed:{},methods:{onSaveProcess:function(){var e,t=this;return(e=o().mark((function e(){var a;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return console.log("workorderProcessItems : ",t.workorderProcessItems),t.isLoading=!0,a={param_id:t.paramId,param_header:JSON.stringify(t.paramHeader),workorder_processes:JSON.stringify(t.workorderProcessItems)},e.next=5,axios.post("/ajax/ct/workorders/processes/store-processes",a).then((function(e){var a=e.data.data;return"success"==a.status?(swal("Success","บันทึกสำเร็จ","success"),t.emitWorkorderProcessSaved()):swal("เกิดข้อผิดพลาด","ไม่สามารถบันทึก | ".concat(a.message),"error"),a})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ไม่สามารถบันทึก | ".concat(e.message),"error")}));case 5:t.isLoading=!1;case 6:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(r,o){var s=e.apply(t,a);function n(e){p(s,r,o,n,c,"next",e)}function c(e){p(s,r,o,n,c,"throw",e)}n(void 0)}))})()},formatter:function(e,t){return e.address},numberFormatter:function(e,t,a){return a?Number(a).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"-"},sortCompleteQty:function(e,t){return e.complete_qty-t.complete_qty},sortRemainQuantity:function(e,t){return e.remain_quantity-t.remain_quantity},sortCompleteDateThai:function(e,t){return i()(e.complete_date)-i()(t.complete_date)},sortClosedDateThai:function(e,t){return i()(e.closed_date)-i()(t.closed_date)},emitWorkorderProcessSaved:function(){this.$emit("onWorkorderProcessSaved",{param_id:this.paramId,param_header:this.paramHeader,workorder_processes:this.workorderProcessItems})},formatNumber:function(e){return e.toString().replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,",")},isNumber:function(e){var t=(e=e||window.event).which?e.which:e.keyCode;if(!(t>31&&(t<48||t>57)&&46!==t))return!0;e.preventDefault()},getUomCodeDescription:function(e,t){var a=e.find((function(e){return e.uom_code==t}));return a?a.unit_of_measure:""},onSelect:function(e,t){var a=this.workorderProcessItems.length,r=this.workorderProcessItems.filter((function(e){return 1==e.selected})).length;this.selectAll=a==r},isSelectionDisabled:function(e){var t=!1;return 3!=e.ct_status&&4!=e.ct_status||1!=e.selected||(t=!0),t},onSelectAll:function(e){var t=this;this.$nextTick((function(){var e=t.selectAll;t.workorderProcessItems=t.workorderProcessItems.map((function(t){var a=e;return 3!=t.ct_status&&4!=t.ct_status||0==e&&1==t.selected&&(a=!0),m(m({},t),{},{selected:a})}))}))}}};var f=a(51900);const v=(0,f.Z)(b,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("div",{staticClass:"text-left tw-mb-2"},[a("button",{staticClass:"btn btn-inline-block btn-sm btn-primary tw-w-40",attrs:{type:"input",disabled:e.workorderProcessItems.length<=0},on:{click:e.onSaveProcess}},[a("i",{staticClass:"fa fa-save tw-mr-1"}),e._v(" บันทึก \n        ")])]),e._v(" "),a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"400px"}},[a("el-table",{staticStyle:{width:"100%"},attrs:{data:e.workorderProcessItems,"default-sort":{prop:"complete_date_ts",order:"descending"},height:"400"}},[a("el-table-column",{attrs:{label:"",width:"55"},scopedSlots:e._u([{key:"header",fn:function(){return[a("input",{directives:[{name:"model",rawName:"v-model",value:e.selectAll,expression:"selectAll"}],attrs:{type:"checkbox",name:"all_selected"},domProps:{checked:Array.isArray(e.selectAll)?e._i(e.selectAll,null)>-1:e.selectAll},on:{change:[function(t){var a=e.selectAll,r=t.target,o=!!r.checked;if(Array.isArray(a)){var s=e._i(a,null);r.checked?s<0&&(e.selectAll=a.concat([null])):s>-1&&(e.selectAll=a.slice(0,s).concat(a.slice(s+1)))}else e.selectAll=o},function(t){return e.onSelectAll(t)}]}})]},proxy:!0},{key:"default",fn:function(t){return[a("input",{directives:[{name:"model",rawName:"v-model",value:t.row.selected,expression:"scope.row.selected"}],attrs:{type:"checkbox",name:"selected",disabled:e.isSelectionDisabled(t.row)},domProps:{checked:Array.isArray(t.row.selected)?e._i(t.row.selected,null)>-1:t.row.selected},on:{change:[function(a){var r=t.row.selected,o=a.target,s=!!o.checked;if(Array.isArray(r)){var n=e._i(r,null);o.checked?n<0&&e.$set(t.row,"selected",r.concat([null])):n>-1&&e.$set(t.row,"selected",r.slice(0,n).concat(r.slice(n+1)))}else e.$set(t.row,"selected",s)},function(a){return e.onSelect(a,t.row)}]}})]}}])}),e._v(" "),a("el-table-column",{attrs:{prop:"complete_date_thai",label:"วันที่บันทึกผลผลิต",sortable:"",align:"center","sort-method":e.sortCompleteDateThai,width:"160"}}),e._v(" "),a("el-table-column",{attrs:{prop:"batch_no",label:"เลขที่คำสั่งผลิต",sortable:"",align:"center",width:"160"}}),e._v(" "),a("el-table-column",{attrs:{prop:"batch_status",label:"สถานะ Batch",sortable:"",align:"center",width:"150"}}),e._v(" "),a("el-table-column",{attrs:{prop:"product_item_number",label:"รหัสผลิตภัณฑ์",sortable:"",align:"center",width:"150"}}),e._v(" "),a("el-table-column",{attrs:{prop:"item_desc",label:"ผลิตภัณฑ์",sortable:"",align:"left",width:"250"}}),e._v(" "),a("el-table-column",{attrs:{prop:"complete_qty",label:"จำนวนที่ผลิตได้",sortable:"",align:"right",width:"250","sort-method":e.sortCompleteQty,formatter:e.numberFormatter}}),e._v(" "),a("el-table-column",{attrs:{prop:"remain_quantity",label:"รวมจำนวนคงค้างในขั้นตอน",sortable:"",align:"right",width:"250","sort-method":e.sortRemainQuantity,formatter:e.numberFormatter}}),e._v(" "),a("el-table-column",{attrs:{prop:"uom_code_desc",label:"หน่วยนับ",sortable:"",align:"center",width:"100"}}),e._v(" "),a("el-table-column",{attrs:{prop:"closed_date_thai",label:"วันที่ปิดคำสั่งผลิต",sortable:"",align:"center","sort-method":e.sortClosedDateThai,width:"150"}})],1)],1),e._v(" "),a("loading",{attrs:{active:e.isLoading,"is-full-page":!0},on:{"update:active":function(t){e.isLoading=t}}})],1)}),[],!1,null,null,null).exports;function h(e,t,a,r,o,s,n){try{var c=e[s](n),i=c.value}catch(e){return void a(e)}c.done?t(i):Promise.resolve(i).then(r,o)}function w(e){return function(){var t=this,a=arguments;return new Promise((function(r,o){var s=e.apply(t,a);function n(e){h(s,r,o,n,c,"next",e)}function c(e){h(s,r,o,n,c,"throw",e)}n(void 0)}))}}const g={components:{Loading:n(),TableWorkorderProcesses:v},props:["defaultData","paramIdValue","processStepValue","periodYearValue","periodNameValue","processStatusValue","postingStatusValue","costCodeValue","deptCodeFromValue","deptCodeToValue","batchNoFromValue","batchNoToValue","processSteps","periodYears","processStatuses","postingStatuses","costCenters","uomCodes"],mounted:function(){var e=this;this.periodYearValue&&this.getListPeriodNumbers(this.periodYearValue).then((function(t){e.periodNameValue&&(e.paramHeader.period_number=e.getPeriodNumber(e.periodNumbers,e.periodNameValue),e.paramHeader.start_date=e.getPeriodStartDate(e.periodNumbers,e.periodNameValue,"EN"),e.paramHeader.end_date=e.getPeriodEndDate(e.periodNumbers,e.periodNameValue,"EN"),e.paramHeader.start_date_thai=e.getPeriodStartDate(e.periodNumbers,e.periodNameValue,"TH"),e.paramHeader.end_date_thai=e.getPeriodEndDate(e.periodNumbers,e.periodNameValue,"TH"))})),this.paramIdValue&&this.onGetWorkorderProcesss(this.paramIdValue),this.costCodeValue&&(this.getListCostDepartment(this.costCodeValue),this.getBatchNumbers(this.costCodeValue))},data:function(){return{organizationId:this.defaultData?JSON.parse(this.defaultData).organization_id:null,organizationCode:this.defaultData?JSON.parse(this.defaultData).organization_code:null,department:this.defaultData?JSON.parse(this.defaultData).department:null,paramId:this.paramIdValue,paramHeader:{period_year:this.periodYearValue,period_year_label:this.getPeriodYearLabel(this.periodYears,this.periodYearValue),period_name:this.periodNameValue,period_number:"",start_date:"",end_date:"",start_date_thai:"",end_date_thai:"",cost_code:this.costCodeValue,dept_code_from:this.deptCodeFromValue,dept_code_to:this.deptCodeToValue,batch_no_from:this.batchNoFromValue,batch_no_to:this.batchNoToValue,process_status:this.processStatusValue,posting_status:this.postingStatusValue},batchNumbers:[],periodNumbers:[],ccDepartments:[],workorderProcesses:[],workorderImportFileList:[],isVerified:!1,isLoading:!1}},computed:{},methods:{setUrlParams:function(){var e=new URLSearchParams(window.location.search);e.set("param_id",this.paramId),e.set("period_year",this.paramHeader.period_year),e.set("period_name",this.paramHeader.period_name),e.set("process_status",this.paramHeader.process_status),e.set("posting_status",this.paramHeader.posting_status),e.set("cost_code",this.paramHeader.cost_code),e.set("dept_code_from",this.paramHeader.dept_code_from),e.set("dept_code_to",this.paramHeader.dept_code_to),e.set("batch_no_from",this.paramHeader.batch_no_from),e.set("batch_no_to",this.paramHeader.batch_no_to),window.history.replaceState(null,null,"?"+e.toString())},getListPeriodNumbers:function(e){var t=this;return w(o().mark((function a(){var r;return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t.isLoading=!0,t.periodNumbers=[],r={period_year:e},a.next=5,axios.get("/ajax/ct/workorders/processes/get-period-numbers",{params:r}).then((function(e){var t=e.data.data;return t.period_numbers?JSON.parse(t.period_numbers):[]})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ข้อมูลปี ".concat(t.paramHeader.period_year_label," ไม่ถูกต้อง | ").concat(e.message),"error")}));case 5:t.periodNumbers=a.sent,t.isLoading=!1;case 7:case"end":return a.stop()}}),a)})))()},getListCostDepartment:function(e){var t=this;return w(o().mark((function a(){var r;return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t.isLoading=!0,r={cost_code:e},a.next=4,axios.get("/ajax/ct/workorders/processes/get-cost-departments",{params:r}).then((function(e){var t=e.data.data;return t.departments?JSON.parse(t.departments):[]})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล หน่วยงาน จากศูนย์ต้นทุน ".concat(e," | ").concat(t.message),"error")}));case 4:t.ccDepartments=a.sent,t.isLoading=!1;case 6:case"end":return a.stop()}}),a)})))()},getBatchNumbers:function(e){var t=this;return w(o().mark((function a(){var r;return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t.isLoading=!0,r={cost_code:e},a.next=4,axios.get("/ajax/ct/workorders/processes/get-batch-numbers",{params:r}).then((function(e){var t=e.data.data;return t.batch_numbers?JSON.parse(t.batch_numbers):[]})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่พบข้อมูล เลขที่คำสั่งผลิต จากศูนย์ต้นทุน ".concat(e," | ").concat(t.message),"error")}));case 4:t.batchNumbers=a.sent,t.isLoading=!1;case 6:case"end":return a.stop()}}),a)})))()},onPeriodYearChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.period_year=e,t.paramHeader.period_year_label=t.getPeriodYearLabel(t.periodYears,e),t.paramHeader.period_name="",t.paramHeader.period_number="",t.paramHeader.start_date="",t.paramHeader.end_date="",t.paramHeader.start_date_thai="",t.paramHeader.end_date_thai="",t.getListPeriodNumbers(t.paramHeader.period_year),t.setUrlParams();case 10:case"end":return a.stop()}}),a)})))()},onCostCenterCodeChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.cost_code=e,t.getBatchNumbers(t.paramHeader.cost_code),t.getBatchNumbers(t.paramHeader.cost_code),t.setUrlParams();case 4:case"end":return a.stop()}}),a)})))()},onPeriodNumberChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.period_name=e,t.paramHeader.period_number=t.getPeriodNumber(t.periodNumbers,e),t.paramHeader.start_date=t.getPeriodStartDate(t.periodNumbers,e,"EN"),t.paramHeader.end_date=t.getPeriodEndDate(t.periodNumbers,e,"EN"),t.paramHeader.start_date_thai=t.getPeriodStartDate(t.periodNumbers,e,"TH"),t.paramHeader.end_date_thai=t.getPeriodEndDate(t.periodNumbers,e,"TH"),t.setUrlParams();case 7:case"end":return a.stop()}}),a)})))()},onDeptCodeFromChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.dept_code_from=e,t.setUrlParams();case 2:case"end":return a.stop()}}),a)})))()},onDeptCodeToChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.dept_code_to=e,t.setUrlParams();case 2:case"end":return a.stop()}}),a)})))()},onBatchNoFromChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.batch_no_from=e,t.setUrlParams();case 2:case"end":return a.stop()}}),a)})))()},onBatchNoToChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.batch_no_to=e,t.setUrlParams();case 2:case"end":return a.stop()}}),a)})))()},onProcessStatusChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.process_status=e,t.setUrlParams();case 2:case"end":return a.stop()}}),a)})))()},onPostingStatusChanged:function(e){var t=this;return w(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:t.paramHeader.posting_status=e,t.setUrlParams();case 2:case"end":return a.stop()}}),a)})))()},getProcessStepLabel:function(e,t){var a=e.find((function(e){return e.step_code==t}));return a?a.description:""},getPeriodYearLabel:function(e,t){var a=e.find((function(e){return e.period_year_value==t}));return a?a.period_year_label:""},getPeriodNumber:function(e,t){var a=e.find((function(e){return e.period_number_value==t}));return a?a.period_number_label:""},getPeriodStartDate:function(e,t,a){var r=null,o=e.find((function(e){return e.period_number_value==t}));return r=o?o.start_date:"","TH"==a&&(r=o?o.start_date_thai:""),r},getPeriodEndDate:function(e,t,a){var r=null,o=e.find((function(e){return e.period_number_value==t}));return r=o?o.end_date:"","TH"==a&&(r=o?o.end_date_thai:""),r},getProcessStatusDesc:function(e){var t="-";if(e){var a=this.processStatuses.find((function(t){return t.process_status==e}));t=a?a.description:"-"}return t},getPostingStatusDesc:function(e){var t="-";if(e){var a=this.postingStatuses.find((function(t){return t.posting_status==e}));t=a?a.description:"-"}return t},onClearParamHeader:function(){var e=this;return w(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.paramHeader.period_year="",e.paramHeader.period_year_label="",e.paramHeader.period_name="",e.paramHeader.period_number="",e.paramHeader.start_date="",e.paramHeader.end_date="",e.paramHeader.start_date_thai="",e.paramHeader.end_date_thai="",e.paramHeader.cost_code="",e.paramHeader.dept_code_from="",e.paramHeader.dept_code_to="",e.paramHeader.batch_no_from="",e.paramHeader.batch_no_to="",e.paramHeader.process_status="",e.paramHeader.posting_status="",e.periodNumbers=[],e.ccDepartments=[],e.setUrlParams();case 18:case"end":return t.stop()}}),t)})))()},onQueryWorkorderProcesss:function(){var e=this;return w(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.queryWorkorderProcess(!0);case 2:e.setUrlParams();case 3:case"end":return t.stop()}}),t)})))()},queryWorkorderProcess:function(e){var t=this;return w(o().mark((function a(){var r,s;return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(t.isLoading=!0,!(r=t.validateBeforeQuery(t.paramHeader)).valid){a.next=8;break}return s={process_step:"SELECT",period_year:t.paramHeader.period_year,period_year_label:t.paramHeader.period_year_label,period_name:t.paramHeader.period_name,period_number:t.paramHeader.period_number,start_date:t.paramHeader.start_date,end_date:t.paramHeader.end_date,start_date_thai:t.paramHeader.start_date_thai,end_date_thai:t.paramHeader.end_date_thai,cost_code:t.paramHeader.cost_code,dept_code_from:t.paramHeader.dept_code_from,dept_code_to:t.paramHeader.dept_code_to,batch_no_from:t.paramHeader.batch_no_from,batch_no_to:t.paramHeader.batch_no_to,process_status:t.paramHeader.process_status,posting_status:t.paramHeader.posting_status},a.next=6,axios.post("/ajax/ct/workorders/processes/query-trans",s).then((function(a){var r=a.data.data;return t.paramId=r.param_id?r.param_id:null,t.paramId&&(t.onGetWorkorderProcesss(t.paramId),e&&swal("Success","แสดงข้อมูลคำสั่งผลิต","success")),r})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ไม่สามารถแสดงข้อมูลคำสั่งผลิต  | ".concat(e.message),"error")}));case 6:a.next=9;break;case 8:swal("เกิดข้อผิดพลาด","ไม่สามารถแสดงข้อมูลคำสั่งผลิต | ".concat(r.message),"error");case 9:t.isLoading=!1;case 10:case"end":return a.stop()}}),a)})))()},onProcessWorkorderProcesss:function(e,t){var a=this;return w(o().mark((function e(){var r,s,n;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(a.isLoading=!0,r="FINAL"==t?"ส่งข้อมูลเข้า GL":"ยกเลิกข้อมูลเข้า GL",!(s=a.validateBeforeProcess(a.paramHeader)).valid){e.next=9;break}return n={process_step:t,period_year:a.paramHeader.period_year,period_year_label:a.paramHeader.period_year_label,period_name:a.paramHeader.period_name,period_number:a.paramHeader.period_number,start_date:a.paramHeader.start_date,end_date:a.paramHeader.end_date,start_date_thai:a.paramHeader.start_date_thai,end_date_thai:a.paramHeader.end_date_thai,cost_code:a.paramHeader.cost_code,dept_code_from:a.paramHeader.dept_code_from,dept_code_to:a.paramHeader.dept_code_to,batch_no_from:a.paramHeader.batch_no_from,batch_no_to:a.paramHeader.batch_no_to,process_status:a.paramHeader.process_status,posting_status:a.paramHeader.posting_status},e.next=7,axios.post("/ajax/ct/workorders/processes/process-trans",n).then((function(e){var t=e.data.data;return"success"==t.status?(a.paramId=t.param_id?t.param_id:null,a.paramId?(a.onGetWorkorderProcesss(a.paramId),swal("Success","".concat(r," สำเร็จ"),"success")):swal("เกิดข้อผิดพลาด","ไม่สามารถ ".concat(r," ( param_id is null ) | ").concat(t.message),"error")):swal("เกิดข้อผิดพลาด","ไม่สามารถ ".concat(r," | ").concat(t.message),"error"),t})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ไม่สามารถ ".concat(r," | ").concat(e.message),"error")}));case 7:e.next=10;break;case 9:swal("เกิดข้อผิดพลาด","ไม่สามารถ ".concat(r," | ").concat(s.message),"error");case 10:a.isLoading=!1,a.setUrlParams();case 12:case"end":return e.stop()}}),e)})))()},onGetWorkorderProcesss:function(e){var t=this;return w(o().mark((function a(){var r;return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t.isLoading=!0,r={param_id:e},a.next=4,axios.get("/ajax/ct/workorders/processes/get-trans",{params:r}).then((function(e){var a=e.data.data;return"success"==a.status?t.workorderProcesses=a.transactions?JSON.parse(a.transactions):[]:swal("เกิดข้อผิดพลาด","ไม่สามารถแสดงข้อมูลคำสั่งผลิต | ".concat(a.message),"error"),a})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ไม่สามารถแสดงข้อมูลคำสั่งผลิต  | ".concat(e.message),"error")}));case 4:t.isLoading=!1;case 5:case"end":return a.stop()}}),a)})))()},onWorkorderProcessSaved:function(e){var t=this;return w(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.queryWorkorderProcess(!1);case 2:t.setUrlParams();case 3:case"end":return e.stop()}}),e)})))()},validateBeforeGenerate:function(e){var t={valid:!0,message:""};return e.period_year||(t.valid=!1,t.message="กรุณาเลือกข้อมูลปีบัญชี"),e.period_number||(t.valid=!1,t.message="กรุณาเลือกข้อมูลงวดบัญชี"),e.cost_code||(t.valid=!1,t.message="กรุณากรอกข้อมูลศูนย์ต้นทุน"),t},validateBeforeQuery:function(e){var t={valid:!0,message:""};return e.period_year||(t.valid=!1,t.message="กรุณาเลือกข้อมูลปีบัญชี"),e.period_number||(t.valid=!1,t.message="กรุณาเลือกข้อมูลงวดบัญชี"),e.cost_code||(t.valid=!1,t.message="กรุณากรอกข้อมูลศูนย์ต้นทุน"),t},validateBeforeProcess:function(e){var t={valid:!0,message:""};return e.period_year||(t.valid=!1,t.message="กรุณาเลือกข้อมูลปีบัญชี"),e.period_number||(t.valid=!1,t.message="กรุณาเลือกข้อมูลงวดบัญชี"),e.cost_code||(t.valid=!1,t.message="กรุณากรอกข้อมูลศูนย์ต้นทุน"),t},validateBeforeSave:function(e,t){return{valid:!0,message:""}}}};const C=(0,f.Z)(g,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"ibox"},[a("div",{staticClass:"ibox-content tw-pt-8",staticStyle:{"min-height":"600px"}},[a("div",[a("div",{staticClass:"row form-group"},[a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0 required"},[e._v(" ปีบัญชี ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"period_year",id:"input_period_year","select-options":e.periodYears,"option-key":"period_year_value","option-value":"period_year_value","option-label":"period_year_label",value:e.paramHeader.period_year,filterable:!0,clearable:!0},on:{onSelected:e.onPeriodYearChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[e._v(" งวดบัญชี ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"period_number",id:"input_period_number","select-options":e.periodNumbers,"option-key":"period_number_value","option-value":"period_number_value","option-label":"period_number_full_label",value:e.paramHeader.period_number,filterable:!0,clearable:!0},on:{onSelected:e.onPeriodNumberChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[e._v(" ตั้งแต่วันที่ ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("p",{staticClass:"col-form-label"},[e._v(" "+e._s(e.paramHeader.start_date_thai?e.paramHeader.start_date_thai:"-")+" ")])])])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[e._v(" ถึงวันที่ ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("p",{staticClass:"col-form-label"},[e._v(" "+e._s(e.paramHeader.end_date_thai?e.paramHeader.end_date_thai:"-")+" ")])])])])]),e._v(" "),a("div",{staticClass:"row form-group"},[a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[e._v(" ศูนย์ต้นทุน ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"cost_code",id:"input_cost_code","select-options":e.costCenters,"option-key":"cost_code_value","option-value":"cost_code_value","option-label":"cost_code_label",value:e.paramHeader.cost_code,filterable:!0,clearable:!0},on:{onSelected:e.onCostCenterCodeChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" หน่วยงาน (From) ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"dept_code_from",id:"input_dept_code_from","select-options":e.ccDepartments,"option-key":"department_code","option-value":"department_code","option-label":"department_code",value:e.paramHeader.dept_code_from,filterable:!0,clearable:!0},on:{onSelected:e.onDeptCodeFromChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" หน่วยงาน (To) ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"dept_code_to",id:"input_dept_code_to","select-options":e.ccDepartments,"option-key":"department_code","option-value":"department_code","option-label":"department_code",value:e.paramHeader.dept_code_to,filterable:!0,clearable:!0},on:{onSelected:e.onDeptCodeToChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"})]),e._v(" "),a("div",{staticClass:"row form-group"},[a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" เลขที่คำสั่งผลิต (From) ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"batch_no_from",id:"input_batch_no_from","select-options":e.batchNumbers,"option-key":"batch_no","option-value":"batch_no","option-label":"batch_no",value:e.paramHeader.batch_no_from,filterable:!0,clearable:!0},on:{onSelected:e.onBatchNoFromChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" เลขที่คำสั่งผลิต (To) ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"batch_no_to",id:"input_batch_no_to","select-options":e.batchNumbers,"option-key":"batch_no","option-value":"batch_no","option-label":"batch_no",value:e.paramHeader.batch_no_to,filterable:!0,clearable:!0},on:{onSelected:e.onBatchNoToChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" สถานะประมวลผล ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"process_status",id:"input_process_status","select-options":e.processStatuses,"option-key":"process_status","option-value":"process_status","option-label":"description",value:e.paramHeader.process_status,filterable:!0,clearable:!0},on:{onSelected:e.onProcessStatusChanged}})],1)])]),e._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" สถานะส่งเข้า GL ")]),e._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"posting_status",id:"input_posting_status","select-options":e.postingStatuses,"option-key":"posting_status","option-value":"posting_status","option-label":"description",value:e.paramHeader.posting_status,filterable:!0,clearable:!0},on:{onSelected:e.onPostingStatusChanged}})],1)])])])]),e._v(" "),a("hr"),e._v(" "),a("div",[a("div",{staticClass:"text-left tw-mb-2"},[a("button",{staticClass:"btn btn-inline-block btn-sm btn-primary tw-w-40",attrs:{disabled:!e.paramHeader.period_year||!e.paramHeader.period_name||!e.paramHeader.cost_code},on:{click:e.onQueryWorkorderProcesss}},[a("i",{staticClass:"fa fa-search tw-mr-1"}),e._v(" แสดงข้อมูล \n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-40",on:{click:e.onClearParamHeader}},[a("i",{staticClass:"fa fa-times tw-mr-1"}),e._v(" ล้างการค้นหา \n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-info tw-w-40",attrs:{disabled:!e.paramHeader.period_year||!e.paramHeader.period_name||!e.paramHeader.cost_code},on:{click:function(t){return e.onProcessWorkorderProcesss(t,"FINAL")}}},[a("i",{staticClass:"fa fa-retweet tw-mr-1"}),e._v(" ส่งข้อมูลเข้า GL\n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-danger tw-w-40",attrs:{disabled:!e.paramHeader.period_year||!e.paramHeader.period_name||!e.paramHeader.cost_code},on:{click:function(t){return e.onProcessWorkorderProcesss(t,"CANCEL")}}},[a("i",{staticClass:"fa fa-retweet tw-mr-1"}),e._v(" ยกเลิกข้อมูลเข้า GL\n                ")])])]),e._v(" "),a("hr"),e._v(" "),a("div",[a("div",{staticClass:"text-left tw-mb-2"},[a("button",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-52",attrs:{disabled:!0}},[e._v(" \n                    รายงานการบันทึกบัญชี \n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-52",attrs:{disabled:!0}},[e._v("\n                    รายงานรายละเอียดวัตถุดิบที่ใช้ไป\n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-52",attrs:{disabled:!0}},[e._v(" \n                    งานระหว่างผลิตปลายงวด\n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-52",attrs:{disabled:!0}},[e._v(" \n                    รายงานบัตรต้นทุน\n                ")]),e._v(" "),a("button",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-52",attrs:{disabled:!0}},[e._v(" \n                    รายงานสรุปต้นทุนผลิต\n                ")])])]),e._v(" "),a("hr"),e._v(" "),a("div",{staticClass:"tw-m-8"},[a("div",{staticClass:"row tw-mb-5"},[a("div",{staticClass:"col-12"},[a("table-workorder-processes",{attrs:{"param-id-value":e.paramId,"param-header":e.paramHeader,"workorder-processes":e.workorderProcesses,"uom-codes":e.uomCodes},on:{onWorkorderProcessSaved:e.onWorkorderProcessSaved}})],1)])])]),e._v(" "),a("loading",{attrs:{active:e.isLoading,"is-full-page":!0},on:{"update:active":function(t){e.isLoading=t}}})],1)}),[],!1,null,null,null).exports}}]);