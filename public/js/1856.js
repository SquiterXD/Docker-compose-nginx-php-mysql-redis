(self.webpackChunk=self.webpackChunk||[]).push([[1856],{15226:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>n});var o=a(23645),s=a.n(o)()((function(t){return t[1]}));s.push([t.id,".btn-success[data-v-4d618958]{color:#fff!important;background-color:#1c84c6!important;border-color:#1c84c6!important}",""]);const n=s},61856:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>l});var o=a(87757),s=a.n(o),n=a(30381),d=a.n(n);function r(t,e,a,o,s,n,d){try{var r=t[n](d),i=r.value}catch(t){return void a(t)}r.done?e(i):Promise.resolve(i).then(o,s)}function i(t){return function(){var e=this,a=arguments;return new Promise((function(o,s){var n=t.apply(e,a);function d(t){r(n,o,s,d,i,"next",t)}function i(t){r(n,o,s,d,i,"throw",t)}d(void 0)}))}}const p={props:["deliveryDates","budgetYear"],data:function(){return{customers:[],customer_select:[],years:[],installments:[],removed:[],options:[],data_list:[{postpone_order_id:0,customer_number:"",customer_name:"",year:"",installment:"",from_date:"",to_date:"",budgetYear:[],period:[],fix:!0,old:!1,selected:0}],loading:!1,data_postpone:{year:"",period:"",from_date:"",to_date:"",disabled:{year:!0,period:!0,from_date:!0,to_date:!0},periodList:[],customers:[],loading:{postpone:!1,table:!1}}}},mounted:function(){this.customerList(),this.getParams(),this.yearsList()},methods:{remoteMethod:function(t){var e=this;""!==t?(this.loading=!0,setTimeout((function(){e.loading=!1,e.options=e.customers.filter((function(e){return e.customer_name.indexOf(t)>-1||e.customer_number.indexOf(t)>-1}))}),200)):this.options=[]},getParams:function(){var t=this,e=new URLSearchParams(window.location.search);if(e.has("customer_number")){var a={customer_number:e.get("customer_number"),year:e.get("year"),installment:e.get("installment"),date:e.get("date")};axios.post("/om/ajax/postpone-delivery/search",a).then((function(e){t.data_list=e.data.data})).catch((function(t){})).finally((function(){}))}},customerList:function(){var t=this;axios.get("/api/v1/customer").then((function(e){t.customers=e.data.data,t.options=e.data.data}))},yearsList:function(){var t=this;axios.get("/om/ajax/postpone-delivery/years").then((function(e){t.years=e.data.data}))},changeYear:function(t,e){var a=t;this.data_list[e].year=a,this.data_list[e].installment="",this.installmentList(a,e)},changeChecked:function(t,e){var a=this;1==a.data_list[t].selected?a.data_list[t].selected=0:a.data_list[t].selected=1,$("td input:checkbox:checked").length!=$("td input:checkbox").length?$("#checkboxAll").prop("checked",!1):$("#checkboxAll").prop("checked",!0)},installmentList:function(t,e){var a=this;axios.get("/om/ajax/postpone-delivery/installments/"+t).then((function(t){a.data_list[e].period=t.data.data}))},changeInstallment:function(t,e){var a=this;axios.get("/om/ajax/postpone-delivery/date-by-no/"+a.data_list[e].customer_number+"/"+t).then((function(t){a.data_list[e].from_date=t.data.data})),this.data_list[e].installment=t},createNewRow:function(){this.data_list.push({postpone_order_id:0,customer_number:"",customer_name:"",year:"",installment:"",from_date:"",to_date:"",budgetYear:[],period:[],fix:!0,old:!1,selected:0})},getCustomerName:function(t,e){var a=this;a.data_list[e].customer_number=t,a.customers.filter((function(o){o.customer_number==t&&(a.data_list[e].customer_name=o.customer_name)}))},sourceChanged:function(t,e){this.getCustomerName(t,e),this.getNextDate(t,e),this.data_list[e].year=d()().year()+543,this.installmentList(d()().year(),e)},getNextDate:function(t,e){var a=this;axios.get("/om/ajax/postpone-delivery/next-date/"+t).then((function(t){a.data_list[e].from_date=t.data.data}))},changeFromDate:function(t,e){this.data_list[e].from_date=t},changeToDate:function(t,e){this.data_list[e].to_date=d()(t).format("DD/MM/Y")},removeData:function(){var t=this,e=[{postpone:t.data_list}];swal({title:"แจ้งเตือน",text:"ต้องการลบข้อมูลเลื่อนส่งประจำสัปดาห์",type:"warning",showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก",closeOnConfirm:!1,closeOnCancel:!1},(function(a){a?axios.post("/om/ajax/postpone-delivery/remove",e).then((function(e){e.data.status&&t.getParams()})).catch((function(t){})).finally(i(s().mark((function e(){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:$("input[type=checkbox]").prop("checked",!1),t.data_list=t.data_list.filter((function(t){return 0==t.selected})),swal.close();case 3:case"end":return e.stop()}}),e)})))):swal.close()}))},savePostpone:function(){var t=this,e=[{postpone:t.data_list}];swal({title:"แจ้งเตือน",text:"ต้องการบันทึกข้อมูลเลื่อนส่งประจำสัปดาห์",type:"warning",showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก",closeOnConfirm:!1,closeOnCancel:!1},(function(a){a?axios.post("/om/ajax/postpone-delivery/create",e).then((function(e){e.data.status&&(e.data.error?(swal("Warning!","เกิดข้อผิดพลาดบางรายการ","error"),t.getParams()):(swal("Success","บันทึกข้อมูลสำเร็จ","success"),t.getParams()))})).catch((function(t){})).finally((function(){})):swal.close()}))},radioClick:function(){var t=this,e=this,a=$('input[name="delivery_date"]:checked').val();e.data_postpone.customers=[],e.data_postpone.loading.postpone=!0,e.data_postpone.loading.table=!0,axios.get("/om/ajax/postpone-delivery/get-customers/"+a).then((function(a){0!=a.data.data.length?(e.data_postpone.customers=a.data.data,e.data_postpone.disabled.year=!1,e.data_postpone.disabled.period=!1,e.data_postpone.disabled.from_date=!1,e.data_postpone.disabled.to_date=!1,e.data_postpone.year=(new Date).getFullYear().toString(),t.getPeriodPostPone((new Date).getFullYear().toString()),e.data_postpone.loading.postpone=!1,e.data_postpone.loading.table=!1):(e.data_postpone.disabled.year=!0,e.data_postpone.disabled.period=!0,e.data_postpone.disabled.from_date=!0,e.data_postpone.disabled.to_date=!0,e.data_postpone.year="",e.data_postpone.loading.postpone=!1,e.data_postpone.loading.table=!1)}))},getPeriodPostPone:function(t){var e=this,a=this,o=$('input[name="delivery_date"]:checked').val();a.data_postpone.loading.postpone=!0,a.data_postpone.loading.table=!0,t?axios.get("/om/ajax/postpone-delivery/get-period-post-pone/"+t,{params:{days:o}}).then((function(t){0!=t.data.data.length?(a.data_postpone.periodList=t.data.data,a.data_postpone.period=t.data.data2[0].period_line_id,a.data_postpone.from_date=t.data.data3):(a.data_postpone.periodList=[],a.data_postpone.period="",a.data_postpone.from_date="",a.data_postpone.loading.postpone=!1,a.data_postpone.loading.table=!1),console.log(t.data.data4),0!=t.data.data4.length?(a.data_list=[],t.data.data4.forEach((function(t){a.data_list.push({postpone_order_id:t.postpone_order_id?t.postpone_order_id:0,customer_number:t.customer_number?t.customer_number:"",customer_name:t.customer_name?t.customer_name:"",year:a.data_postpone.year?a.data_postpone.year:"",installment:a.data_postpone.period?a.data_postpone.period:"",from_date:a.data_postpone.from_date?a.data_postpone.from_date:"",to_date:t.to_period_date?t.to_period_date:"",budgetYear:e.budgetYear,period:a.data_postpone.periodList?a.data_postpone.periodList:"",fix:!0,old:!1,selected:0})})),a.data_postpone.loading.table=!1):a.data_list=[],a.data_postpone.loading.postpone=!1})):(a.data_postpone.period="",a.data_postpone.periodList=[],a.data_postpone.from_date="")},applyData:function(){var t=this,e=this;e.data_list=[],0!=e.data_postpone.customers.length&&e.data_postpone.customers.forEach((function(a){e.data_list.push({postpone_order_id:a.postpone_order_id?a.postpone_order_id:0,customer_number:a.customer_number?a.customer_number:"",customer_name:a.customer_name?a.customer_name:"",year:e.data_postpone.year?e.data_postpone.year:"",installment:e.data_postpone.period?e.data_postpone.period:"",from_date:e.data_postpone.from_date?e.data_postpone.from_date:"",to_date:e.data_postpone.to_date?e.data_postpone.to_date:"",budgetYear:t.budgetYear,period:e.data_postpone.periodList?e.data_postpone.periodList:"",fix:!0,old:!1,selected:0})}))},getValueFromDate:function(t){var e=this;return i(s().mark((function a(){var o,n;return s().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:(o=e).data_postpone.from_date=t,n=t?d()(t).format("DD/MM/YYYY"):"",o.data_postpone.customers=[],o.data_postpone.loading.postpone=!0,o.data_postpone.loading.table=!0,axios.get("/om/ajax/postpone-delivery/get-date-by-period-post-pone",{params:{days:n}}).then((function(t){0!=t.data.data.length&&(o.data_postpone.period=t.data.data[0].period_line_id,o.data_postpone.customers=t.data.data3,t.data.data2&&$("#"+t.data.data2).prop("checked",!0)),0!=t.data.data4.length?(o.data_list=[],t.data.data4.forEach((function(t){o.data_list.push({postpone_order_id:t.postpone_order_id?t.postpone_order_id:0,customer_number:t.customer_number?t.customer_number:"",customer_name:t.customer_name?t.customer_name:"",year:o.data_postpone.year?o.data_postpone.year:"",installment:o.data_postpone.period?o.data_postpone.period:"",from_date:o.data_postpone.from_date?o.data_postpone.from_date:"",to_date:t.to_period_date?t.to_period_date:"",budgetYear:e.budgetYear,period:o.data_postpone.periodList?o.data_postpone.periodList:"",fix:!0,old:!1,selected:0})})),o.data_postpone.loading.table=!1):o.data_list=[],o.data_postpone.loading.postpone=!1,o.data_postpone.loading.table=!1}));case 7:case"end":return a.stop()}}),a)})))()},getValueToDate:function(t){this.data_postpone.to_date=d()(t).format("DD/MM/YYYY")},clearDataPostPone:function(){var t=this;t.data_postpone.year="",t.data_postpone.period="",t.data_postpone.from_date="",t.data_postpone.to_date="",t.data_postpone.periodList=[],t.data_postpone.customers=[],t.data_postpone.disabled.year=!0,t.data_postpone.disabled.period=!0,t.data_postpone.disabled.from_date=!0,t.data_postpone.disabled.to_date=!0,t.data_list=[]},checkboxAll:function(){$("#checkboxAll").prop("checked")?$("td input:checkbox").prop("checked",$("#checkboxAll").prop("checked")):$("td input:checkbox").prop("checked",!1),this.data_list.forEach((function(t){t.selected=1}))},getPeriodPostPoneByDate:function(){var t=this,e=this,a=$('input[name="delivery_date"]:checked').val();e.data_postpone.from_date="",e.data_postpone.to_date="",e.data_postpone.loading.postpone=!0,e.data_postpone.loading.table=!0,e.data_postpone.period&&axios.get("/om/ajax/postpone-delivery/get-period-post-pone-by-date",{params:{period:e.data_postpone.period,days:a}}).then((function(a){0!=a.data.data.length&&(e.data_postpone.from_date=a.data.data),0!=a.data.data2.length?(e.data_list=[],a.data.data2.forEach((function(a){e.data_list.push({postpone_order_id:a.postpone_order_id?a.postpone_order_id:0,customer_number:a.customer_number?a.customer_number:"",customer_name:a.customer_name?a.customer_name:"",year:e.data_postpone.year?e.data_postpone.year:"",installment:e.data_postpone.period?e.data_postpone.period:"",from_date:e.data_postpone.from_date?e.data_postpone.from_date:"",to_date:a.to_period_date?a.to_period_date:"",budgetYear:t.budgetYear,period:e.data_postpone.periodList?e.data_postpone.periodList:"",fix:!0,old:!1,selected:0})})),e.data_postpone.loading.table=!1):e.data_list=[],e.data_postpone.loading.postpone=!1,e.data_postpone.loading.table=!1}))}}};a(17489);const l=(0,a(51900).Z)(p,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{directives:[{name:"loading",rawName:"v-loading",value:this.data_postpone.loading.postpone,expression:"this.data_postpone.loading.postpone"}],staticClass:"col-xl-12 m-auto"},[a("hr",{staticClass:"lg"}),t._v(" "),a("div",{staticClass:"row mb-3"},[a("label",{staticClass:"d-block mr-3"},[t._v("วันส่งร้านค้า")]),t._v(" "),t._l(t.deliveryDates,(function(e,o){return a("div",{key:o},[a("label",{staticClass:"pr-3"},[a("input",{staticStyle:{height:"20px",width:"20px","vertical-align":"middle"},attrs:{type:"radio",name:"delivery_date",id:e.meaning},domProps:{value:e.meaning},on:{click:function(e){return t.radioClick()}}}),t._v(" "),a("span",[t._v(" "+t._s(e.meaning)+" ")])])])}))],2),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"form-group col-sm-3"},[a("label",{staticClass:"d-block"},[t._v("ปีงบประมาณ")]),t._v(" "),a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"ปีงบประมาณ",disabled:t.data_postpone.disabled.year,clearable:""},on:{change:function(e){return t.getPeriodPostPone(t.data_postpone.year)}},model:{value:t.data_postpone.year,callback:function(e){t.$set(t.data_postpone,"year",e)},expression:"data_postpone.year"}},t._l(t.budgetYear,(function(t,e){return a("el-option",{key:e,attrs:{label:parseInt(t.budget_year)+parseInt(543),value:t.budget_year}})})),1)],1),t._v(" "),a("div",{staticClass:"form-group col-sm-3"},[a("label",{staticClass:"d-block"},[t._v("งวด")]),t._v(" "),a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"งวด",disabled:t.data_postpone.disabled.period,clearable:""},on:{change:function(e){return t.getPeriodPostPoneByDate()}},model:{value:t.data_postpone.period,callback:function(e){t.$set(t.data_postpone,"period",e)},expression:"data_postpone.period"}},t._l(t.data_postpone.periodList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.period_no,value:t.period_line_id}})})),1)],1),t._v(" "),a("div",{staticClass:"form-group col-sm-3"},[a("label",{staticClass:"d-block"},[t._v("วันส่งประจำงวด")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD/MM/YYYY",disabled:t.data_postpone.disabled.from_date},on:{dateWasSelected:t.getValueFromDate},model:{value:t.data_postpone.from_date,callback:function(e){t.$set(t.data_postpone,"from_date",e)},expression:"data_postpone.from_date"}})],1),t._v(" "),a("div",{staticClass:"form-group col-sm-3"},[a("label",{staticClass:"d-block"},[t._v("เลื่อนเป็นวันที่")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD/MM/YYYY",disabled:t.data_postpone.disabled.to_date},on:{dateWasSelected:t.getValueToDate},model:{value:t.data_postpone.to_date,callback:function(e){t.$set(t.data_postpone,"to_date",e)},expression:"data_postpone.to_date"}})],1)]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12 text-right"},[a("button",{staticClass:"btn btn-md btn-success",attrs:{type:"button",disabled:0==this.data_postpone.customers.length},on:{click:function(e){return t.applyData()}}},[a("i",{staticClass:"fa fa-plus"}),t._v(" Apply\n            ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-danger",attrs:{type:"button",disabled:0==this.data_postpone.customers.length},on:{click:function(e){return t.clearDataPostPone()}}},[a("i",{staticClass:"fa fa-refresh"}),t._v(" ล้างค่า\n            ")])])])]),t._v(" "),a("div",{staticClass:"col-xl-12 m-auto"},[a("hr",{staticClass:"lg"}),t._v(" "),a("div",{staticClass:"form-header-buttons"},[a("div",{staticClass:"buttons d-flex"},[a("button",{staticClass:"btn btn-md btn-success",attrs:{type:"button"},on:{click:function(e){return t.createNewRow()}}},[a("i",{staticClass:"fa fa-plus"}),t._v(" สร้าง\n        ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-danger",attrs:{type:"button"},on:{click:function(e){return t.removeData()}}},[a("i",{staticClass:"fa fa-times"}),t._v(" ลบ\n        ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-primary",attrs:{type:"button"},on:{click:function(e){return t.savePostpone()}}},[a("i",{staticClass:"fa fa-save"}),t._v(" บันทึก\n        ")])])]),t._v(" "),a("div",{staticClass:"hr-line-dashed"}),t._v(" "),a("div",{staticClass:"text-right",staticStyle:{"padding-bottom":"10px"}},[t._v("\n      จำนวนบรรทัดของข้อมูล: "+t._s(this.data_list.length)+"\n    ")]),t._v(" "),a("div",{staticClass:"table-responsive-xl"},[a("table",{directives:[{name:"loading",rawName:"v-loading",value:this.data_postpone.loading.table,expression:"this.data_postpone.loading.table"}],staticClass:"table table-bordered text-center"},[a("thead",[a("tr",{staticClass:"text-center"},[a("th",{staticClass:"w-40"},[t._v("\n              เลือกทั้งหมด \n              "),a("input",{staticClass:"form-control",staticStyle:{"margin-top":"10px"},attrs:{type:"checkbox",id:"checkboxAll"},on:{click:function(e){return t.checkboxAll()}}})]),t._v(" "),a("th",{staticClass:"w-150"},[t._v("รหัสร้านค้า")]),t._v(" "),a("th",{staticClass:"min-150"},[t._v("ชื่อร้านค้า")]),t._v(" "),a("th",{staticClass:"w-130"},[t._v("ปีงบประมาณ")]),t._v(" "),a("th",{staticClass:"w-90"},[t._v("งวดที่")]),t._v(" "),a("th",{staticClass:"w-150"},[t._v("วันส่งประจำงวด")]),t._v(" "),a("th",{staticClass:"w-150"},[t._v("เลื่อนเป็นวันที่")])])]),t._v(" "),a("tbody",t._l(t.data_list,(function(e,o){return a("tr",{key:o},[a("td",[a("input",{staticClass:"form-control",staticStyle:{"margin-top":"10px"},attrs:{type:"checkbox",disabled:!e.fix},domProps:{value:e.selected},on:{change:function(e){return t.changeChecked(o)}}})]),t._v(" "),a("td",[a("el-select",{attrs:{filterable:"",remote:"","reserve-keyword":"","remote-method":t.remoteMethod,loading:t.loading},on:{change:function(e){return t.sourceChanged(e,o)}},model:{value:e.customer_number,callback:function(a){t.$set(e,"customer_number",a)},expression:"v.customer_number"}},t._l(t.options,(function(e){return a("el-option",{key:e.customer_id,attrs:{value:e.customer_number}},[t._v(t._s(e.customer_number+" : "+e.customer_name)+"\n                ")])})),1)],1),t._v(" "),a("td",[a("el-input",{attrs:{placeholder:"ชื่อร้าน",value:e.customer_name,disabled:""}})],1),t._v(" "),a("td",[a("el-select",{attrs:{filterable:"",placeholder:"Select",disabled:!e.fix},on:{change:function(e){return t.changeYear(e,o)}},model:{value:e.year,callback:function(a){t.$set(e,"year",a)},expression:"v.year"}},t._l(t.years,(function(t){return a("el-option",{key:t.budget_year,attrs:{label:parseInt(t.budget_year)+parseInt(543),value:t.budget_year}})})),1)],1),t._v(" "),a("td",[a("el-select",{attrs:{filterable:"",placeholder:"Select",disabled:!e.fix},on:{change:function(e){return t.changeInstallment(e,o)}},model:{value:e.installment,callback:function(a){t.$set(e,"installment",a)},expression:"v.installment"}},t._l(e.period,(function(t){return a("el-option",{key:t.period_line_id,attrs:{label:t.period_no,value:t.period_line_id}})})),1)],1),t._v(" "),a("td",[a("datepicker-th",{staticClass:"form-control",staticStyle:{width:"100%"},attrs:{placeholder:"วันส่งประจำงวด",value:e.from_date,format:"DD/MM/Y"},model:{value:e.from_date,callback:function(a){t.$set(e,"from_date",a)},expression:"v.from_date"}})],1),t._v(" "),a("td",[a("datepicker-th",{staticClass:"form-control",staticStyle:{width:"100%"},attrs:{placeholder:"เลื่อนเป็นวันที่",value:e.to_date,disabled:!e.fix,disabledDateTo:"[0]",format:"DD/MM/Y"},on:{dateWasSelected:function(e){return t.changeToDate(e,o)}},model:{value:e.to_date,callback:function(a){t.$set(e,"to_date",a)},expression:"v.to_date"}})],1)])})),0)])])])])}),[],!1,null,"4d618958",null).exports},17489:(t,e,a)=>{var o=a(15226);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,a(45346).Z)("6fd14ea8",o,!0,{})}}]);