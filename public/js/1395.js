(self.webpackChunk=self.webpackChunk||[]).push([[1395],{88777:(t,e,a)=>{"use strict";a.d(e,{Z:()=>o});var n=a(23645),s=a.n(n)()((function(t){return t[1]}));s.push([t.id,".btn-success[data-v-f00cc3c4]{color:#fff!important;background-color:#1c84c6!important;border-color:#1c84c6!important}",""]);const o=s},31395:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>_});var n=a(87757),s=a.n(n),o=a(30381),r=a.n(o);function i(t,e,a,n,s,o,r){try{var i=t[o](r),c=i.value}catch(t){return void a(t)}i.done?e(c):Promise.resolve(c).then(n,s)}function c(t){return function(){var e=this,a=arguments;return new Promise((function(n,s){var o=t.apply(e,a);function r(t){i(o,n,s,r,c,"next",t)}function c(t){i(o,n,s,r,c,"throw",t)}r(void 0)}))}}const l={data:function(){return{customers:[],customer_select:[],years:[],installments:[],removed:[],options:[],data_list:[{postpone_order_id:0,customer_number:"",customer_name:"",year:"",installment:"",from_date:"",to_date:"",budgetYear:[],period:[],fix:!0,old:!1,selected:0}],loading:!1}},mounted:function(){this.customerList(),this.getParams(),this.yearsList()},methods:{remoteMethod:function(t){var e=this;""!==t?(this.loading=!0,setTimeout((function(){e.loading=!1,e.options=e.customers.filter((function(e){return e.customer_name.indexOf(t)>-1||e.customer_number.indexOf(t)>-1}))}),200)):this.options=[]},getParams:function(){var t=this,e=new URLSearchParams(window.location.search);if(e.has("customer_number")){var a={customer_number:e.get("customer_number"),year:e.get("year"),installment:e.get("installment"),date:e.get("date")};axios.post("/om/ajax/postpone-delivery/search",a).then((function(e){t.data_list=e.data.data})).catch((function(t){})).finally((function(){}))}},customerList:function(){var t=this;axios.get("/api/v1/customer").then((function(e){t.customers=e.data.data,t.options=e.data.data}))},yearsList:function(){var t=this;axios.get("/om/ajax/postpone-delivery/years").then((function(e){t.years=e.data.data}))},changeYear:function(t,e){var a=t;this.data_list[e].year=a,this.data_list[e].installment="",this.installmentList(a,e)},changeChecked:function(t,e){var a=this;1==a.data_list[t].selected?a.data_list[t].selected=0:a.data_list[t].selected=1},installmentList:function(t,e){var a=this;axios.get("/om/ajax/postpone-delivery/installments/"+t).then((function(t){a.data_list[e].period=t.data.data}))},changeInstallment:function(t,e){var a=this;console.log(t),axios.get("/om/ajax/postpone-delivery/date-by-no/"+a.data_list[e].customer_number+"/"+t).then((function(t){a.data_list[e].from_date=t.data.data})),this.data_list[e].installment=t},createNewRow:function(){this.data_list.push({postpone_order_id:0,customer_number:"",customer_name:"",year:"",installment:"",from_date:"",to_date:"",budgetYear:[],period:[],fix:!0,old:!1,selected:0})},getCustomerName:function(t,e){var a=this;a.data_list[e].customer_number=t,a.customers.filter((function(n){n.customer_number==t&&(a.data_list[e].customer_name=n.customer_name)}))},sourceChanged:function(t,e){this.getCustomerName(t,e),this.getNextDate(t,e),this.data_list[e].year=r()().year()+543,this.installmentList(r()().year(),e)},getNextDate:function(t,e){var a=this;axios.get("/om/ajax/postpone-delivery/next-date/"+t).then((function(t){a.data_list[e].from_date=t.data.data}))},changeFromDate:function(t,e){this.data_list[e].from_date=t},changeToDate:function(t,e){this.data_list[e].to_date=r()(t).format("DD/MM/Y")},removeData:function(){var t=this,e=[{postpone:t.data_list}];swal({title:"แจ้งเตือน",text:"ต้องการลบข้อมูลเลื่อนส่งประจำสัปดาห์",type:"warning",showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก",closeOnConfirm:!1,closeOnCancel:!1},(function(a){a?axios.post("/om/ajax/postpone-delivery/remove",e).then((function(e){e.data.status&&t.getParams()})).catch((function(t){})).finally(c(s().mark((function e(){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:$("input[type=checkbox]").prop("checked",!1),t.data_list=t.data_list.filter((function(t){return 0==t.selected})),swal.close();case 3:case"end":return e.stop()}}),e)})))):swal.close()}))},savePostpone:function(){var t=this,e=[{postpone:t.data_list}];swal({title:"แจ้งเตือน",text:"ต้องการบันทึกข้อมูลเลื่อนส่งประจำสัปดาห์",type:"warning",showCancelButton:!0,confirmButtonClass:"btn-primary",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก",closeOnConfirm:!1,closeOnCancel:!1},(function(a){a?axios.post("/om/ajax/postpone-delivery/create",e).then((function(e){e.data.status&&(e.data.error?(swal("Warning!","เกิดข้อผิดพลาดบางรายการ","error"),t.getParams()):(swal("Success","บันทึกข้อมูลสำเร็จ","success"),t.getParams()))})).catch((function(t){})).finally((function(){})):swal.close()}))}}};var u=a(93379),d=a.n(u),m=a(88777),f={insert:"head",singleton:!1};d()(m.Z,f);m.Z.locals;const _=(0,a(51900).Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-xl-12 m-auto"},[a("hr",{staticClass:"lg"}),t._v(" "),a("div",{staticClass:"form-header-buttons"},[a("div",{staticClass:"buttons d-flex"},[a("button",{staticClass:"btn btn-md btn-success",attrs:{type:"button"},on:{click:function(e){return t.createNewRow()}}},[a("i",{staticClass:"fa fa-plus"}),t._v(" สร้าง\n      ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-danger",attrs:{type:"button"},on:{click:function(e){return t.removeData()}}},[a("i",{staticClass:"fa fa-times"}),t._v(" ลบ\n      ")]),t._v(" "),a("button",{staticClass:"btn btn-md btn-primary",attrs:{type:"button"},on:{click:function(e){return t.savePostpone()}}},[a("i",{staticClass:"fa fa-save"}),t._v(" บันทึก\n      ")])])]),t._v(" "),a("div",{staticClass:"hr-line-dashed"}),t._v(" "),a("div",{staticClass:"table-responsive-xl"},[a("table",{staticClass:"table table-bordered text-center"},[t._m(0),t._v(" "),a("tbody",t._l(t.data_list,(function(e,n){return a("tr",{key:n},[a("td",[a("input",{staticClass:"form-control",staticStyle:{"margin-top":"10px"},attrs:{type:"checkbox",disabled:!e.fix},domProps:{value:e.selected},on:{change:function(e){return t.changeChecked(n)}}})]),t._v(" "),a("td",[a("el-select",{attrs:{filterable:"",remote:"","reserve-keyword":"","remote-method":t.remoteMethod,loading:t.loading},on:{change:function(e){return t.sourceChanged(e,n)}},model:{value:e.customer_number,callback:function(a){t.$set(e,"customer_number",a)},expression:"v.customer_number"}},t._l(t.options,(function(e){return a("el-option",{key:e.customer_id,attrs:{value:e.customer_number}},[t._v(t._s(e.customer_number+" : "+e.customer_name)+"\n              ")])})),1)],1),t._v(" "),a("td",[a("el-input",{attrs:{placeholder:"ชื่อร้าน",value:e.customer_name,disabled:""}})],1),t._v(" "),a("td",[a("el-select",{attrs:{filterable:"",placeholder:"Select",disabled:!e.fix},on:{change:function(e){return t.changeYear(e,n)}},model:{value:e.year,callback:function(a){t.$set(e,"year",a)},expression:"v.year"}},t._l(t.years,(function(t){return a("el-option",{key:t.budget_year,attrs:{label:parseInt(t.budget_year)+parseInt(543),value:t.budget_year}})})),1)],1),t._v(" "),a("td",[a("el-select",{attrs:{filterable:"",placeholder:"Select",disabled:!e.fix},on:{change:function(e){return t.changeInstallment(e,n)}},model:{value:e.installment,callback:function(a){t.$set(e,"installment",a)},expression:"v.installment"}},t._l(e.period,(function(t){return a("el-option",{key:t.period_line_id,attrs:{label:t.period_no,value:t.period_line_id}})})),1)],1),t._v(" "),a("td",[a("datepicker-th",{staticClass:"form-control",staticStyle:{width:"100%"},attrs:{placeholder:"วันส่งประจำงวด",value:e.from_date,format:"DD/MM/Y"},model:{value:e.from_date,callback:function(a){t.$set(e,"from_date",a)},expression:"v.from_date"}})],1),t._v(" "),a("td",[a("datepicker-th",{staticClass:"form-control",staticStyle:{width:"100%"},attrs:{placeholder:"เลื่อนเป็นวันที่",value:e.to_date,disabled:!e.fix,disabledDateTo:"[0]",format:"DD/MM/Y"},on:{dateWasSelected:function(e){return t.changeToDate(e,n)}},model:{value:e.to_date,callback:function(a){t.$set(e,"to_date",a)},expression:"v.to_date"}})],1)])})),0)])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",{staticClass:"text-center"},[a("th",{staticClass:"w-40"},[t._v("เลือก")]),t._v(" "),a("th",{staticClass:"w-150"},[t._v("รหัสร้านค้า")]),t._v(" "),a("th",{staticClass:"min-150"},[t._v("ชื่อร้านค้า")]),t._v(" "),a("th",{staticClass:"w-130"},[t._v("ปีงบประมาณ")]),t._v(" "),a("th",{staticClass:"w-90"},[t._v("งวดที่")]),t._v(" "),a("th",{staticClass:"w-150"},[t._v("วันส่งประจำงวด")]),t._v(" "),a("th",{staticClass:"w-150"},[t._v("เลื่อนเป็นวันที่")])])])}],!1,null,"f00cc3c4",null).exports}}]);