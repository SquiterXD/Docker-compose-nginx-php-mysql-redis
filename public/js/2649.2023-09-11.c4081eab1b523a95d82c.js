(self.webpackChunk=self.webpackChunk||[]).push([[2649],{72649:(e,t,i)=>{"use strict";i.r(t),i.d(t,{default:()=>w});var a=i(87757),n=i.n(a),r=i(7398),s=i.n(r),o=(i(19371),i(30381),i(80455)),l=i.n(o);function p(e,t){var i=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),i.push.apply(i,a)}return i}function c(e){for(var t=1;t<arguments.length;t++){var i=null!=arguments[t]?arguments[t]:{};t%2?p(Object(i),!0).forEach((function(t){d(e,t,i[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(i)):p(Object(i)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(i,t))}))}return e}function d(e,t,i){return t in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i,e}const u={components:{Loading:s(),VueNumeric:l()},props:["planHeader","planLines","uomCodes"],watch:{planHeader:function(e){this.planHeaderData=e},planLines:function(e){var t=this;this.planLineItems=e.map((function(e){return c(c({},e),{},{period_name_qty:e.product_qty?(parseFloat(e.period_name_request)-parseFloat(e.product_qty)).toFixed(2):parseFloat(e.period_name_request).toFixed(2),uom_desc:t.getUomCodeDescription(t.uomCodes,e.uom)})})).sort((function(e,t){return e.inv_item_number<t.inv_item_number?-1:e.inv_item_number>t.inv_item_number?1:0}))}},data:function(){var e=this;return{planHeaderData:this.planHeader,planLineItems:this.planLines.map((function(t){return c(c({},t),{},{period_name_qty:t.product_qty?(parseFloat(t.period_name_request)-parseFloat(t.product_qty)).toFixed(2):parseFloat(t.period_name_request).toFixed(2),uom_desc:e.getUomCodeDescription(e.uomCodes,t.uom)})})).sort((function(e,t){return e.inv_item_number<t.inv_item_number?-1:e.inv_item_number>t.inv_item_number?1:0})),isLoading:!1}},mounted:function(){},computed:{},methods:{getUomCodeDescription:function(e,t){var i=e.find((function(e){return e.uom_code==t}));return i?i.unit_of_measure:""},onProductQtyValueChanged:function(e){e.product_qty?e.period_name_qty=(parseFloat(e.period_name_request)-parseFloat(e.product_qty)).toFixed(2):e.period_name_qty=parseFloat(e.period_name_request).toFixed(2)},getRequestNumber:function(e){return Number(0==e.product_qty)&&this.isOrderOpened(this.planLineItems)?"ไม่ผลิต":e.request_number},isOrderOpened:function(e){return!!e.find((function(e){return!!e.request_number}))}}};var y=i(51900);const b=(0,y.Z)(u,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",[i("div",{staticClass:"table-responsive"},[i("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"1400px"}},[e._m(0),e._v(" "),e.planLineItems.length>0?i("tbody",[e._l(e.planLineItems,(function(t,a){return[i("tr",{key:""+a,style:{backgroundColor:0==parseInt(t.product_qty)?"#FDF5EF":""}},[i("td",{staticClass:"freeze-col",staticStyle:{"min-width":"700px"}},[i("div",{staticClass:"freeze-col-content",staticStyle:{padding:"0px"},style:{backgroundColor:0==parseInt(t.product_qty)?"#FDF5EF":""}},[i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4 tw-pr-2",staticStyle:{"min-width":"140px","max-width":"140px"}},[e._v("\n                                    "+e._s(t.product_item_desc?t.product_item_desc:"-")+" \n                                ")]),e._v(" "),i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4 tw-px-2",staticStyle:{"min-width":"120px","max-width":"120px","border-left":"1px solid #ddd"}},[e._v("\n                                    "+e._s(t.inv_item_type?t.inv_item_type:"-")+"\n                                ")]),e._v(" "),i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4 tw-px-2",staticStyle:{"min-width":"120px","max-width":"120px","border-left":"1px solid #ddd"}},[e._v("\n                                    "+e._s(t.inv_item_number?t.inv_item_number:"-")+"\n                                ")]),e._v(" "),i("div",{staticClass:"text-left tw-inline-block tw-align-top tw-py-4 tw-px-2",staticStyle:{"min-width":"280px","max-width":"280px","border-left":"1px solid #ddd"}},[e._v("\n                                    "+e._s(t.inv_item_desc?t.inv_item_desc:"-")+"\n                                ")])])]),e._v(" "),i("td",{staticClass:"text-right",staticStyle:{"min-width":"160px"}},[i("div",[e._v("\n                                "+e._s(t.product_qty?Number(t.product_qty).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"")+"\n                            ")])]),e._v(" "),i("td",{staticClass:"text-center",staticStyle:{"min-width":"130px","max-width":"130px"}},[e._v(" "+e._s(t.uom_desc)+" ")]),e._v(" "),i("td",{staticClass:"text-right",staticStyle:{"min-width":"130px","max-width":"130px"}},[e._v(" "+e._s(t.period_name_request?Number(t.period_name_request).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"")+" ")]),e._v(" "),i("td",{staticClass:"text-right",staticStyle:{"min-width":"130px","max-width":"130px"}},[e._v(" "+e._s(t.period_name_qty?Number(t.period_name_qty).toLocaleString(void 0,{minimumFractionDigits:2,maximumFractionDigits:2}):"")+" ")]),e._v(" "),i("td",{staticClass:"text-center",staticStyle:{"min-width":"130px","max-width":"130px"}},[e._v(" "+e._s(e.getRequestNumber(t))+" ")])])]}))],2):i("tbody",[e._m(1)])])]),e._v(" "),i("loading",{attrs:{active:e.isLoading,"is-full-page":!0},on:{"update:active":function(t){e.isLoading=t}}})],1)}),[function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("thead",[i("tr",[i("th",{staticClass:"freeze-col",staticStyle:{height:"50px","min-width":"700px"}},[i("div",{staticClass:"freeze-col-content",staticStyle:{padding:"0px"}},[i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4",staticStyle:{"min-width":"140px","max-width":"140px"}},[e._v("\n                                ตราบุหรี่ \n                            ")]),e._v(" "),i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4",staticStyle:{"min-width":"120px","max-width":"120px","border-left":"1px solid #ddd"}},[e._v("\n                                ประเภทสิ่งพิมพ์\n                            ")]),e._v(" "),i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4",staticStyle:{"min-width":"120px","max-width":"120px","border-left":"1px solid #ddd"}},[e._v("\n                                รหัสสินค้าสำเร็จรูป\n                            ")]),e._v(" "),i("div",{staticClass:"text-center tw-inline-block tw-align-top tw-py-4",staticStyle:{"min-width":"280px","max-width":"280px","border-left":"1px solid #ddd"}},[e._v("\n                                รายละเอียด\n                            ")])])]),e._v(" "),i("th",{staticClass:"text-center",staticStyle:{height:"50px","min-width":"160px"}},[e._v(" สั่งผลิต(ม้วนใหญ่) ")]),e._v(" "),i("th",{staticClass:"text-center",staticStyle:{height:"50px","min-width":"130px","max-width":"130px"}},[e._v(" หน่วย (ผลิต) ")]),e._v(" "),i("th",{staticClass:"text-center",staticStyle:{height:"50px","min-width":"130px","max-width":"130px"}},[e._v(" คำสั่งทั้งเดือน ")]),e._v(" "),i("th",{staticClass:"text-center",staticStyle:{height:"50px","min-width":"130px","max-width":"130px"}},[e._v(" เหลือที่ต้องผลิต ")]),e._v(" "),i("th",{staticClass:"text-center",staticStyle:{height:"50px","min-width":"130px","max-width":"130px"}},[e._v(" เลขคำสั่งผลิต ")])])])},function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("tr",[i("td",{attrs:{colspan:"10"}},[i("h2",{staticClass:"p-5 text-center text-muted"},[e._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports;function m(e,t,i,a,n,r,s){try{var o=e[r](s),l=o.value}catch(e){return void i(e)}o.done?t(l):Promise.resolve(l).then(a,n)}function h(e){return function(){var t=this,i=arguments;return new Promise((function(a,n){var r=e.apply(t,i);function s(e){m(r,a,n,s,o,"next",e)}function o(e){m(r,a,n,s,o,"throw",e)}s(void 0)}))}}const _={components:{Loading:s(),TablePlanLines:b},props:["periodYears","periodYearValue","periodNameValue","biweeklyValue","planStatuses","printTypes","printTypeValue","saleTypes","saleTypeValue","sourceVersionValue","biweeklyPlanVersionValue","uomCodes"],mounted:function(){var e=this;this.periodYearValue&&this.getPeriodNames(this.periodYearValue).then((function(t){e.periodNameValue&&(e.periodNameLabel=e.getPeriodNameLabel(e.periodNames,e.periodNameValue),e.getBiweekOfPlans(e.periodYearValue,e.periodNameValue).then((function(t){e.biweeklyValue&&e.printTypeValue&&e.saleTypeValue&&e.sourceVersionValue&&e.getSourceVersions(e.periodYearValue,e.periodNameValue,e.printTypeValue,e.saleTypeValue).then((function(t){e.getBiweeklyPlanData(e.periodYearValue,e.periodNameValue,e.biweeklyValue,e.printTypeValue,e.saleTypeValue,e.sourceVersionValue,e.biweeklyPlanVersionValue)}))})))}))},data:function(){return{periodYear:this.periodYearValue,periodYearLabel:this.getPeriodYearLabel(this.periodYears,this.periodYearValue),periodName:this.periodNameValue,periodNameLabel:"",biweekly:this.biweeklyValue,printType:this.printTypeValue?this.printTypeValue:this.printTypes.length>0?this.printTypes[0].print_type_value:null,printTypeLabel:this.printTypeValue?this.getPrintTypeLabel(this.printTypes,this.printTypeValue):this.printTypes.length>0?this.printTypes[0].print_type_label:null,saleType:this.saleTypeValue?this.saleTypeValue:this.saleTypes.length>0?this.saleTypes[0].value:null,saleTypeLabel:this.saleTypeValue?this.getPrintTypeLabel(this.saleTypes,this.saleTypeValue):this.saleTypes.length>0?this.saleTypes[0].description:null,sourceVersion:this.sourceVersionValue?this.sourceVersionValue:null,sourceVersions:[],periodNames:[],biweeklys:[],biweeklyPlanHeader:null,biweeklyPlanVersion:null,biweeklyPlanLines:[],biweeklyPlanVersions:[],isNewlyCreate:!1,isLoading:!1}},computed:{},methods:{setUrlParams:function(){var e=new URLSearchParams(window.location.search);e.set("period_year",this.periodYear?this.periodYear:""),e.set("period_name",this.periodName?this.periodName:""),e.set("biweekly",this.biweekly?this.biweekly:""),e.set("print_type",this.printType?this.printType:""),e.set("sale_type",this.saleType?this.saleType:""),e.set("source_version",this.sourceVersion?this.sourceVersion:""),window.history.replaceState(null,null,"?"+e.toString())},onYearlyPlanChanged:function(e){this.periodYear=e,this.periodYearLabel=this.getPeriodYearLabel(this.periodYears,this.periodYear),this.setUrlParams(),this.periodName=null,this.periodNameLabel="",this.periodNames=[],this.biweekly=null,this.biweeklys=[],this.sourceVersion=null,this.sourceVersions=[],this.biweeklyPlanHeader=null,this.biweeklyPlanVersion=null,this.biweeklyPlanVersions=[],this.biweeklyPlanLines=[],this.getPeriodNames(this.periodYear)},onPeriodNameChanged:function(e){var t=this;return h(n().mark((function i(){return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return t.periodName=e,t.periodNameLabel=t.getPeriodNameLabel(t.periodNames,t.periodName),t.setUrlParams(),t.biweekly=null,t.biweeklys=[],t.biweeklyPlanHeader=null,t.biweeklyPlanVersion=null,t.biweeklyPlanVersions=[],t.biweeklyPlanLines=[],i.next=11,t.getSourceVersions(t.periodYear,t.periodName,t.printType,t.saleType);case 11:t.getBiweekOfPlans(t.periodYear,t.periodName);case 12:case"end":return i.stop()}}),i)})))()},onBiweekOfPlanChanged:function(e){var t=this;return h(n().mark((function i(){return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:t.biweekly=e,t.setUrlParams(),t.biweeklyPlanVersion=null,t.biweeklyPlanVersions=[],t.periodYear&&t.periodName&&t.biweekly&&t.printType&&t.saleType&&t.sourceVersion&&t.getBiweeklyPlanData(t.periodYear,t.periodName,t.biweekly,t.printType,t.saleType,t.sourceVersion,null);case 5:case"end":return i.stop()}}),i)})))()},onBiweeklyPlanVersionChanged:function(e){var t=this;return h(n().mark((function i(){return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:t.biweeklyPlanVersion=e,t.setUrlParams(),t.periodYear&&t.periodName&&t.biweekly&&t.printType&&t.saleType&&t.sourceVersion&&t.getBiweeklyPlanData(t.periodYear,t.periodName,t.biweekly,t.printType,t.saleType,t.sourceVersion,t.biweeklyPlanVersion);case 3:case"end":return i.stop()}}),i)})))()},onSourceVersionChanged:function(e){this.sourceVersion=e,this.setUrlParams()},onPrintTypeChanged:function(e){this.printType=e,this.printTypeLabel=this.getPrintTypeLabel(this.printTypes,this.printType),this.setUrlParams(),this.periodYear&&this.periodName&&this.biweekly&&this.printType&&this.saleType&&this.sourceVersion&&this.getBiweeklyPlanData(this.periodYear,this.periodName,this.biweekly,this.printType,this.saleType,this.sourceVersion,this.biweeklyPlanVersion)},onSaleTypeChanged:function(e){this.saleType=e,this.saleTypeLabel=this.getSaleTypeLabel(this.saleTypes,this.saleType),this.setUrlParams(),this.periodYear&&this.periodName&&this.biweekly&&this.printType&&this.saleType&&this.sourceVersion&&this.getBiweeklyPlanData(this.periodYear,this.periodName,this.biweekly,this.printType,this.saleType,this.sourceVersion,this.biweeklyPlanVersion)},onSearchPlanVersion:function(e){this.periodYear=e.period_year,this.periodYearLabel=this.getPeriodYearLabel(this.periodYears,this.periodYear),this.periodName=e.period_name,this.periodNameLabel=this.getPeriodNameLabel(this.periodNames,this.periodName),this.biweekly=e.biweekly,this.biweeklyPlanVersion=e.version,this.printType=e.print_type,this.printTypeLabel=this.getPrintTypeLabel(this.printTypes,this.printType),this.saleType=e.sale_type,this.saleTypeLabel=this.getPrintTypeLabel(this.saleTypes,this.saleType),this.sourceVersion=e.source_version,this.sourceVersions=e.source_versions,this.biweeklyPlanLines=[],this.getPeriodNames(this.periodYear),this.getBiweekOfPlans(this.periodYear,this.periodName),this.periodYear&&this.periodName&&this.biweekly&&this.printType&&this.saleType&&this.sourceVersion&&this.getBiweeklyPlanData(this.periodYear,this.periodName,this.biweekly,this.printType,this.saleType,this.sourceVersion,this.biweeklyPlanVersion)},getPeriodYearLabel:function(e,t){var i=e.find((function(e){return e.period_year_value==t}));return i?i.period_year_label:""},getPeriodNameLabel:function(e,t){var i=e.find((function(e){return e.period_name_value==t}));return i?i.period_name_label:""},getPrintTypeLabel:function(e,t){var i=e.find((function(e){return e.print_type_value==t}));return i?i.print_type_label:""},getSaleTypeLabel:function(e,t){var i=e.find((function(e){return e.value==t}));return i?i.description:""},getPeriodNames:function(e){var t=this;return h(n().mark((function i(){var a;return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return t.isLoading=!0,a={period_year:e},i.next=4,axios.get("/ajax/pm/plans/biweekly/get-months",{params:a}).then((function(e){var t=e.data.data;return t.period_names?JSON.parse(t.period_names):[]})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ปี ".concat(t.periodYearLabel," ไม่ถูกต้อง | ").concat(e.message),"error")}));case 4:t.periodNames=i.sent,t.isLoading=!1;case 6:case"end":return i.stop()}}),i)})))()},getBiweekOfPlans:function(e,t){var i=this;return h(n().mark((function a(){var r;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return i.isLoading=!0,r={period_year:e,period_name:t},a.next=4,axios.get("/ajax/pm/plans/biweekly/get-biweeks",{params:r}).then((function(e){var t=e.data.data;return t.biweeklys?JSON.parse(t.biweeklys):[]})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","เดือน : ".concat(i.periodNameLabel," ปี ").concat(i.periodYearLabel," ไม่ถูกต้อง | ").concat(e.message),"error")}));case 4:i.biweeklys=a.sent,i.isLoading=!1;case 6:case"end":return a.stop()}}),a)})))()},getBiweeklyPlanData:function(e,t,i,a,r,s,o){var l=this;return h(n().mark((function p(){var c,d;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return l.isLoading=!0,l.biweeklyPlanHeader=null,l.biweeklyPlanVersion=o,l.biweeklyPlanVersions=[],l.biweeklyPlanLines=[],c={period_year:e,period_name:t,biweekly:i,print_type:a,sale_type:r,source_version:s,version:o},n.next=8,axios.get("/ajax/pm/plans/biweekly/get-info",{params:c}).then((function(e){var t=e.data.data;return l.biweeklyPlanHeader=t.plan_header?JSON.parse(t.plan_header):null,l.biweeklyPlanVersions=t.versions?JSON.parse(t.versions):[],t})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ปักษ์ : ".concat(l.biweekly," เดือน : ").concat(l.periodNameLabel," ปี ").concat(l.periodYearLabel," ไม่ถูกต้อง | ").concat(e.message),"error")}));case 8:if(!l.biweeklyPlanHeader){n.next=18;break}if(l.biweeklyPlanVersion=l.biweeklyPlanHeader.version,!(l.sourceVersions.length>0)){n.next=16;break}return d=l.sourceVersions.find((function(e){return e.source_version==l.biweeklyPlanHeader.source_version})),l.sourceVersion=d?d.source_version:l.sourceVersions[0].source_version,n.next=15,l.onGetBiweeklyPlanLines();case 15:l.setUrlParams();case 16:n.next=19;break;case 18:l.biweeklyPlanVersion=null;case 19:l.isLoading=!1;case 20:case"end":return n.stop()}}),p)})))()},getSourceVersions:function(e,t,i,a){var r=this;return h(n().mark((function s(){var o;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return r.isLoading=!0,r.sourceVersion=null,r.sourceVersions=[],o={period_year:e,period_name:t,print_type:i,sale_type:a},n.next=6,axios.get("/ajax/pm/plans/biweekly/get-source-versions",{params:o}).then((function(e){var t=e.data.data;return"error"==t.status?swal("เกิดข้อผิดพลาด","ข้อมูลไม่ถูกต้อง | ".concat(t.message),"error"):(r.sourceVersion=t.source_version?t.source_version:null,r.sourceVersions=t.source_versions?JSON.parse(t.source_versions):[],r.sourceVersions.length<=0&&swal("ไม่พบข้อมูล","ไม่พบข้อมูลแผนรายเดือนที่ยืนยันแล้ว ","error")),t})).catch((function(e){console.log(e),swal("เกิดข้อผิดพลาด","ข้อมูลไม่ถูกต้อง | ".concat(e.message),"error")}));case 6:r.isLoading=!1;case 7:case"end":return n.stop()}}),s)})))()},getPlanStatusDesc:function(e){var t="-";if(e){var i=this.planStatuses.find((function(t){return t.lookup_code==e}));t=i?i.description:"-"}return t},onGetBiweeklyPlanLines:function(){var e=this;return h(n().mark((function t(){var i;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.isLoading=!0,i={period_year:e.periodYear,period_name:e.periodName,biweekly:e.biweekly,print_type:e.printType,sale_type:e.saleType,source_version:e.sourceVersion,version:e.biweeklyPlanVersion},t.next=4,axios.get("/ajax/pm/plans/biweekly/get-lines",{params:i}).then((function(t){var i=t.data.data;return"success"==i.status?(e.biweeklyPlanHeader=i.plan_header?JSON.parse(i.plan_header):[],e.biweeklyPlanLines=i.plan_lines?JSON.parse(i.plan_lines):[],e.biweeklyPlanVersion=e.biweeklyPlanHeader.version,e.biweeklyPlanVersions=i.versions?JSON.parse(i.versions):[]):swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," | ").concat(i.message),"error"),i})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่สามารถดึงข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," | ").concat(t.message),"error")}));case 4:e.isLoading=!1;case 5:case"end":return t.stop()}}),t)})))()},isAllowSelectSourceVersion:function(e,t){var i=!1;return e?0==t.length&&(i=!0):i=!0,i},isAllowApproval:function(e,t){var i=!1;return e&&"2"==e.status&&(i=!0),i},validateBeforeApproval:function(e,t){return{valid:!0,message:""}},onApprove:function(){var e=this;return h(n().mark((function t(){var i;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(i={period_year:e.periodYear,period_name:e.periodName,biweekly:e.biweekly,print_type:e.printType,sale_type:e.saleType,source_version:e.sourceVersion,plan_header:JSON.stringify(e.biweeklyPlanHeader),plan_lines:JSON.stringify(e.biweeklyPlanLines)},e.isLoading=!0,!e.validateBeforeApproval(e.biweeklyPlanHeader,e.biweeklyPlanLines).valid){t.next=6;break}return t.next=6,axios.post("/ajax/pm/plans/biweekly/approve",i).then((function(t){var i=t.data.data,a=i.message;return"success"==i.status&&(e.biweeklyPlanHeader=i.plan_header?JSON.parse(i.plan_header):null,e.biweeklyPlanVersion=i.version,e.biweeklyPlanVersions=i.versions?JSON.parse(i.versions):[],swal("Success","อนุมัติ ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," version : ").concat(e.biweeklyPlanVersion," )"),"success")),"error"==i.status&&swal("เกิดข้อผิดพลาด","อนุมัติ ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," | ").concat(a),"error"),i})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","อนุมัติ ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," | ").concat(t.message),"error")}));case 6:e.isLoading=!1;case 7:case"end":return t.stop()}}),t)})))()},onReject:function(){var e=this;return h(n().mark((function t(){var i;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(i={period_year:e.periodYear,period_name:e.periodName,biweekly:e.biweekly,print_type:e.printType,sale_type:e.saleType,source_version:e.sourceVersion,plan_header:JSON.stringify(e.biweeklyPlanHeader),plan_lines:JSON.stringify(e.biweeklyPlanLines)},e.isLoading=!0,!e.validateBeforeApproval(e.biweeklyPlanHeader,e.biweeklyPlanLines).valid){t.next=6;break}return t.next=6,axios.post("/ajax/pm/plans/biweekly/reject",i).then((function(t){var i=t.data.data,a=i.message;return"success"==i.status&&(e.biweeklyPlanHeader=i.plan_header?JSON.parse(i.plan_header):null,e.biweeklyPlanVersion=i.version,e.biweeklyPlanVersions=i.versions?JSON.parse(i.versions):[],swal("Success","ไม่อนุมัติ ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," version : ").concat(e.biweeklyPlanVersion," )"),"success")),"error"==i.status&&swal("เกิดข้อผิดพลาด","ไม่อนุมัติ ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," | ").concat(a),"error"),i})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ไม่อนุมัติ ข้อมูลการวางแผนผลิตสิ่งพิมพ์รายปักษ์ : ".concat(e.biweekly," เดือน : ").concat(e.periodNameLabel," ปี ").concat(e.periodYearLabel," ระบบการพิมพ์ ").concat(e.printTypeLabel," | ").concat(t.message),"error")}));case 6:e.isLoading=!1;case 7:case"end":return t.stop()}}),t)})))()}}};const w=(0,y.Z)(_,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticClass:"ibox"},[i("div",{staticClass:"ibox-content",staticStyle:{"min-height":"600px"}},[i("div",{staticClass:"tw-mb-4"},[i("div",{staticClass:"text-right tw-mb-2"},[i("button",{staticClass:"btn btn-inline-block btn-sm btn-success tw-w-40",attrs:{disabled:!e.isAllowApproval(e.biweeklyPlanHeader,e.biweeklyPlanLines)},on:{click:e.onApprove}},[i("i",{staticClass:"fa fa-check tw-mr-1"}),e._v(" อนุมัติ \n                ")]),e._v(" "),i("button",{staticClass:"btn btn-inline-block btn-sm btn-danger tw-w-40",attrs:{disabled:!e.isAllowApproval(e.biweeklyPlanHeader,e.biweeklyPlanLines)},on:{click:e.onReject}},[i("i",{staticClass:"fa fa-times tw-mr-1"}),e._v(" ไม่อนุมัติ \n                ")])])]),e._v(" "),i("hr"),e._v(" "),i("div",[i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" ระบบการพิมพ์ ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("pm-el-select",{attrs:{name:"print_type",id:"input_print_type","select-options":e.printTypes,"option-key":"print_type_value","option-value":"print_type_value","option-label":"print_type_label",value:e.printType,filterable:!0}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" ประเภทแผน ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("pm-el-select",{attrs:{name:"sale_type",id:"sale_type","select-options":e.saleTypes,"option-key":"value","option-value":"value","option-label":"description",value:e.saleType,filterable:!0},on:{onSelected:e.onSaleTypeChanged}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[e._m(0),e._v(" "),i("div",{staticClass:"col-md-8"},[i("pm-el-select",{attrs:{name:"period_year",id:"input_period_year","select-options":e.periodYears,"option-key":"period_year_value","option-value":"period_year_value","option-label":"period_year_label",value:e.periodYear,filterable:!0},on:{onSelected:e.onYearlyPlanChanged}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" ประจำเดือน ")]),e._v(" "),i("div",{staticClass:"col-md-3"},[i("pm-el-select",{attrs:{name:"period_name",id:"input_period_name","select-options":e.periodNames,"option-key":"period_name_value","option-value":"period_name_value","option-label":"period_name_label",value:e.periodName,filterable:!0},on:{onSelected:e.onPeriodNameChanged}})],1),e._v(" "),i("label",{staticClass:"col-md-2 col-form-label tw-font-bold"},[e._v(" ครั้งที่ ")]),e._v(" "),i("div",{staticClass:"col-md-3"},[e.isAllowSelectSourceVersion(e.biweeklyPlanHeader,e.biweeklyPlanLines)?i("pm-el-select",{attrs:{name:"source_version",id:"source_version","select-options":e.sourceVersions,"option-key":"source_version","option-value":"source_version","option-label":"source_version",value:e.sourceVersion,filterable:!0},on:{onSelected:e.onSourceVersionChanged}}):e._e(),e._v(" "),e.isAllowSelectSourceVersion(e.biweeklyPlanHeader,e.biweeklyPlanLines)?e._e():i("p",{staticClass:"col-form-label"},[e._v(" "+e._s(e.sourceVersion)+" ")])],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" ปักษ์ ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("pm-el-select",{attrs:{name:"biweekly",id:"input_biweekly","select-options":e.biweeklys,"option-key":"biweekly_value","option-value":"biweekly_value","option-label":"biweekly_label",value:e.biweekly,filterable:!0},on:{onSelected:e.onBiweekOfPlanChanged}})],1)])]),e._v(" "),i("div",{staticClass:"col-md-6"},[i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" ผู้อนุมัติ ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[e.biweeklyPlanHeader?i("p",{staticClass:"col-form-label"},[e._v(" "+e._s(e.biweeklyPlanHeader.attribute12?e.biweeklyPlanHeader.attribute12:"-")+" ")]):e._e(),e._v(" "),e.biweeklyPlanHeader?e._e():i("p",{staticClass:"col-form-label"},[e._v(" - ")])])]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" เวอร์ชั่น ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("pm-el-select",{attrs:{name:"biweekly_plan_version",id:"input_biweekly_plan_version","select-options":e.biweeklyPlanVersions,"option-key":"version","option-value":"version","option-label":"version",value:e.biweeklyPlanVersion,filterable:!0},on:{onSelected:e.onBiweeklyPlanVersionChanged}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label tw-font-bold"},[e._v(" สถานะ ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[e.biweeklyPlanHeader?i("p",{staticClass:"col-form-label"},[e._v(" "+e._s(e.getPlanStatusDesc(e.biweeklyPlanHeader.status))+" ")]):e._e(),e._v(" "),e.biweeklyPlanHeader?e._e():i("p",{staticClass:"col-form-label"},[e._v(" - ")])])])])])]),e._v(" "),i("hr"),e._v(" "),e.biweeklyPlanLines.length>0?i("div",{staticClass:"tw-m-8"},[i("div",{staticClass:"row"},[i("div",{staticClass:"col-12"},[i("table-plan-lines",{attrs:{"plan-header":e.biweeklyPlanHeader,"plan-lines":e.biweeklyPlanLines,"uom-codes":e.uomCodes}})],1)])]):e._e()]),e._v(" "),i("loading",{attrs:{active:e.isLoading,"is-full-page":!0},on:{"update:active":function(t){e.isLoading=t}}})],1)}),[function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0"},[e._v(" แผนประมาณการ "),i("br"),e._v(" จำหน่ายประจำปี ")])}],!1,null,null,null).exports}}]);