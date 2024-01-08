(self.webpackChunk=self.webpackChunk||[]).push([[5262],{55262:(t,a,e)=>{"use strict";e.r(a),e.d(a,{default:()=>c});var s=e(87757),n=e.n(s),r=e(80455);function i(t,a,e,s,n,r,i){try{var o=t[r](i),l=o.value}catch(t){return void e(t)}o.done?a(l):Promise.resolve(l).then(s,n)}function o(t){return function(){var a=this,e=arguments;return new Promise((function(s,n){var r=t.apply(a,e);function o(t){i(r,s,n,o,l,"next",t)}function l(t){i(r,s,n,o,l,"throw",t)}o(void 0)}))}}const l={components:{VueNumeric:e.n(r)()},props:["customerLists","bankLists","defaultBank"],data:function(){return{loading:!1,showRequires:!1,saveable:!1,defaultYear:"",year:"",month:"",month_options:[{value:"1",label:"มกราคม"},{value:"2",label:"กุมภาพันธ์"},{value:"3",label:"มีนาคม"},{value:"4",label:"เมษายน"},{value:"5",label:"พฤษภาคม"},{value:"6",label:"มิถุนายน"},{value:"7",label:"กรกฎาคม"},{value:"8",label:"สิงหาคม"},{value:"9",label:"กันยายน"},{value:"10",label:"ตุลาคม"},{value:"11",label:"พฤศจิกายน"},{value:"12",label:"ธันวาคม"}],customer_number:"",customer_name:"",file:"",display_sum:"0.00",pvLists:[],bdLists:[],warningLists:{},requireLists:{},adjustLists:{},removeLists:{},bank:this.defaultBank,batch_ap:"",batch_gl:""}},mounted:function(){var t=new Date,a=t.getFullYear(),e=t.getMonth(),s=t.getDate();this.defaultYear=new Date(a+543,e,s),$("#band_table, #province_table").DataTable({destroy:!0})},methods:{findCustomer:function(){var t=this,a=this.customerLists.find((function(a){return a.customer_number==t.customer_number}));this.customer_name=a?a.customer_name:""},handleFileUpload:function(){this.file=this.$refs.file.files.length?this.$refs.file.files[0]:""},handleSearch:function(){var t=this;t.showRequires=!1,t.requireLists={},t.year||(t.showRequires=!0,t.requireLists.year="โปรดเลือกปี"),t.showRequires||(t.bank=t.defaultBank,t.batch_ap="",t.batch_gl="",t.loading=!0,$("#band_table, #province_table").DataTable().destroy(),axios.get("/om/pao-tax-mt/search",{params:{year:t.year,month:t.month,customer_number:t.customer_number}}).then((function(a){t.bdLists=a.data.result})).catch((function(t){console.log(t)})).then((function(){t.composePvTable(),t.updateTotalPaotax()})).then((function(){$("#band_table, #province_table").DataTable({columnDefs:[{targets:"no-sort",orderable:!1}],pageLength:10,responsive:!0,destroy:!0}),t.loading=!1,t.showSuccess()})))},handlePrintEx:function(){var t=this,a="/om/pao-tax-mt/ex-report?year="+t.year+"&month="+t.month+"&customer_number="+t.customer_number;window.open(a,"_blank")},handleStore:function(){var t=this;t.loading=!0;var a=new FormData;a.append("year",t.year),a.append("month",t.month),a.append("customer_number",t.customer_number),a.append("file",t.file),axios.post("/om/pao-tax-mt/store",a,{headers:{"Content-Type":"multipart/form-data"}}).then((function(a){t.$refs.file.value="",t.file=""})).catch((function(t){console.log(t)})).then((function(){t.handleSearch()}))},handleChange:function(t,a){var e=this,s=e.bdLists.find((function(a){return a.pao_tax_mt_id==t}));s.adjust_amount=a.target.value,e.saveable=!0,e.composePvTable(),e.updateTotalPaotax(),e.adjustLists[s.pao_tax_mt_id]=s.adjust_amount},removeData:function(t,a){var e=this;return o(n().mark((function a(){var s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:s=e,swal({title:"แจ้งเตือน",text:"ต้องการจะลบรายการหรือไม่?",icon:"warning",showCancelButton:!0,cancelButtonText:"ยกเลิก",cancelButtonColor:"#d33",confirmButtonText:"ยืนยัน"},function(){var a=o(n().mark((function a(e){var r;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:e&&(r=s.bdLists.indexOf(t),s.loading=!0,axios.post("/om/pao-tax-mt/remove",{pao_tax_id:t.pao_tax_mt_id}).then(function(){var t=o(n().mark((function t(a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if("E"!=a.data.status){t.next=4;break}s.showError(a.data.msg),t.next=16;break;case 4:return s.bdLists.splice(r,1),t.next=7,$("#band_table, #province_table").DataTable().destroy();case 7:return t.next=9,$("#band_table, #province_table").DataTable({columnDefs:[{targets:"no-sort",orderable:!1}],pageLength:10,responsive:!0,destroy:!0});case 9:return s.saveable=!0,t.next=12,s.composePvTable();case 12:return t.next=14,s.updateTotalPaotax();case 14:return t.next=16,s.showSuccess(a.data.msg);case 16:case"end":return t.stop()}}),t)})));return function(a){return t.apply(this,arguments)}}()).catch((function(t){console.log(t)})).then(o(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:s.loading=!1;case 1:case"end":return t.stop()}}),t)})))));case 1:case"end":return a.stop()}}),a)})));return function(t){return a.apply(this,arguments)}}());case 2:case"end":return a.stop()}}),a)})))()},handleSaveData:function(){var t=this;t.loading=!0,axios.patch("/om/pao-tax-mt/update",{adjust_lists:t.adjustLists}).then((function(t){})).catch((function(t){console.log(t)})).then((function(){t.loading=!1,t.saveable=!1,t.showSuccess()}))},validateData:function(){var t=this;if(t.showRequires=!1,t.requireLists={},t.year||(t.showRequires=!0,t.requireLists.year="โปรดเลือกปี"),t.month||(t.showRequires=!0,t.requireLists.month="โปรดเลือกเดือน"),t.file||(t.showRequires=!0,t.requireLists.file="โปรดเลือกไฟล์"),!t.showRequires){t.loading=!0;var a=new FormData;a.append("year",t.year),a.append("month",t.month),a.append("customer_number",t.customer_number),a.append("file",t.file),axios.post("/om/pao-tax-mt/validate",a,{headers:{"Content-Type":"multipart/form-data"}}).then((function(a){"E"==a.data.status?(t.loading=!1,t.showError(a.data.msg)):"W"==a.data.status?(t.warningLists=a.data.errors,$("#warningModal").modal({backdrop:"static",keyboard:!1})):t.handleStore()})).catch((function(t){console.log(t)})).then((function(){}))}},handleInterface:function(){var t=this;if(t.showRequires=!1,t.requireLists={},t.year||(t.showRequires=!0,t.requireLists.year="โปรดเลือกปี"),t.month||(t.showRequires=!0,t.requireLists.month="โปรดเลือกเดือน"),t.bank||(t.showRequires=!0,t.requireLists.bank="โปรดเลือกธนาคาร"),!t.showRequires){t.loading=!0;var a=new FormData;a.append("year",t.year),a.append("month",t.month),a.append("customer_number",t.customer_number),a.append("bank",t.bank),axios.post("/om/pao-tax-mt/interface",a).then((function(a){if("S"==a.data.status){var e="group id : "+a.data.group_id;t.showSuccess(e),t.batch_ap=a.data.group_id,t.bank=""}else t.showError(a.data.msg)})).catch((function(t){console.log(t)})).then((function(){t.loading=!1}))}},handleGl:function(){var t=this;return o(n().mark((function a(){var e;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:(e=t).showRequires=!1,e.requireLists={},e.year||(e.showRequires=!0,e.requireLists.year="โปรดเลือกปี"),e.month||(e.showRequires=!0,e.requireLists.month="โปรดเลือกเดือน"),e.showRequires||(e.loading=!0,swal({title:"แจ้งเตือน",text:"ส่งรายการปรับรายได้ GL?",icon:"warning",showCancelButton:!0,cancelButtonText:"ยกเลิก",cancelButtonColor:"#d33",confirmButtonText:"ยืนยัน"},function(){var t=o(n().mark((function t(a){var s;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:a?((s=new FormData).append("year",e.year),s.append("month",e.month),s.append("customer_number",e.customer_number),axios.post("/om/pao-tax-mt/send-gl",s).then((function(t){if("S"==t.data.status){var a="group id : "+t.data.group_id;e.showSuccess(a),e.batch_gl=t.data.group_id,e.bank=""}else e.showError(t.data.msg)})).catch((function(t){console.log(t)})).then((function(){e.loading=!1}))):e.loading=!1;case 1:case"end":return t.stop()}}),t)})));return function(a){return t.apply(this,arguments)}}()));case 6:case"end":return a.stop()}}),a)})))()},handleClickTab:function(t,a){},updateTotalPaotax:function(){var t=this;return o(n().mark((function a(){var e,s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:s=0,(e=t).bdLists.forEach((function(t){s+=parseFloat(t.adjust_amount)})),e.display_sum=s;case 4:case"end":return a.stop()}}),a)})))()},composePvTable:function(){var t=this;return o(n().mark((function a(){var e,s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:s=[],(e=t).bdLists.forEach((function(t){var a=t.customer,e=t.province;t.item;s.find((function(t){return t.province_name==e.province_thai&&t.customer_number==a.customer_number}))?s.forEach((function(s){s.province_name==e.province_thai&&s.customer_number==a.customer_number&&(s.quantity+=parseFloat(t.quantity_cg),s.pv_pao_tax+=parseFloat(t.adjust_amount),s.items.push(t))})):s.push({province_name:e.province_thai,customer_number:a.customer_number,customer_name:a.customer_name,quantity:parseFloat(t.quantity_cg),uom:t.uom_v?t.uom_v.unit_of_measure:t.uom_code,pv_pao_tax:parseFloat(t.adjust_amount),items:[t]})})),e.pvLists=s;case 4:case"end":return a.stop()}}),a)})))()},showSuccess:function(t){swal("Success!",t,"success")},showError:function(t){swal("Error!",t,"error")},numberWithCommas:function(t){return parseFloat(t).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")}}};const c=(0,e(51900).Z)(l,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[e("div",{directives:[{name:"show",rawName:"v-show",value:t.showRequires,expression:"showRequires"}],staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[e("div",{staticClass:"col-md-12"},[e("ul",{staticClass:"text-danger"},t._l(t.requireLists,(function(a,s){return e("li",{key:s},[t._v("\n                    "+t._s(a)+"\n                ")])})),0)])]),t._v(" "),e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[e("div",{staticClass:"col-md-12 text-right"},[e("button",{staticClass:"btn btn-light",on:{click:t.handleSearch}},[e("i",{staticClass:"fa fa-search"}),t._v(" Search\n            ")]),t._v(" "),e("button",{staticClass:"btn btn-primary",on:{click:t.handlePrintEx}},[e("i",{staticClass:"fa fa-print"}),t._v(" พิมพ์ตัวอย่าง\n            ")]),t._v(" "),e("button",{staticClass:"btn btn-light",on:{click:t.validateData}},[e("i",{staticClass:"fa fa-upload"}),t._v(" นำเข้าข้อมูล\n            ")]),t._v(" "),t._m(0),t._v(" "),e("button",{staticClass:"btn btn-warning",on:{click:t.handleGl}},[e("i",{staticClass:"fa fa-exchange"}),t._v(" ส่งรายการปรับรายได้ GL\n            ")])])]),t._v(" "),e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(1),t._v(" "),e("div",{staticClass:"col-md-3"},[e("el-date-picker",{staticClass:"w-100",attrs:{clearable:!1,id:"year",type:"year",placeholder:"ปี พ.ศ.",format:"yyyy","value-format":"yyyy","default-value":t.defaultYear},model:{value:t.year,callback:function(a){t.year=a},expression:"year"}})],1),t._v(" "),t._m(2),t._v(" "),e("div",{staticClass:"col-md-3"},[e("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.batch_ap,callback:function(a){t.batch_ap=a},expression:"batch_ap"}})],1)]),t._v(" "),e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(3),t._v(" "),e("div",{staticClass:"col-md-3"},[e("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select"},model:{value:t.month,callback:function(a){t.month=a},expression:"month"}},t._l(t.month_options,(function(t){return e("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),t._m(4),t._v(" "),e("div",{staticClass:"col-md-3"},[e("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.batch_gl,callback:function(a){t.batch_gl=a},expression:"batch_gl"}})],1)]),t._v(" "),e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(5),t._v(" "),e("div",{staticClass:"col-md-3"},[e("el-select",{staticClass:"w-100",attrs:{placeholder:"Select",filterable:"",clearable:""},on:{change:t.findCustomer},model:{value:t.customer_number,callback:function(a){t.customer_number=a},expression:"customer_number"}},t._l(t.customerLists,(function(a){return e("el-option",{key:a.customer_id,attrs:{label:a.customer_number,value:a.customer_number}},[t._v("\n                    "+t._s(a.customer_number+" : "+a.customer_name)+"\n                ")])})),1)],1),t._v(" "),e("div",{staticClass:"col-md-3"},[e("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.customer_name,callback:function(a){t.customer_name=a},expression:"customer_name"}})],1)]),t._v(" "),e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(6),t._v(" "),e("div",{staticClass:"col-md-6"},[e("input",{ref:"file",attrs:{type:"file",id:"file",accept:".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"},on:{change:function(a){return t.handleFileUpload()}}})])]),t._v(" "),e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(7),t._v(" "),e("div",{staticClass:"col-md-6"},[e("div",{staticClass:"w-100 el-input"},[e("vue-numeric",{staticClass:"el-input__inner text-right",attrs:{"read-only-class":"el-input__inner text-right",separator:",",precision:2,"read-only":!0},model:{value:t.display_sum,callback:function(a){t.display_sum=a},expression:"display_sum"}})],1)])]),t._v(" "),e("hr"),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-12 text-right"},[e("button",{staticClass:"btn btn-primary",on:{click:t.handleSaveData}},[e("i",{staticClass:"fa fa-floppy-o"}),t._v(" บันทึก\n            ")])])]),t._v(" "),e("el-tabs",{attrs:{type:"card"},on:{"tab-click":t.handleClickTab}},[e("el-tab-pane",{attrs:{label:"แยกรายจังหวัด"}},[e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[e("div",{staticClass:"col-md-12 table-responsive"},[e("table",{staticClass:"table",attrs:{id:"province_table"}},[e("thead",[e("tr",[e("th",{staticClass:"text-center"},[t._v("\n                                    รหัสร้านค้า\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    ชื่อร้านค้า\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    จังหวัด\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    จำนวน\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    หน่วยนับ\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    ค่าภาษีอบจ.\n                                ")])])]),t._v(" "),e("tbody",t._l(t.pvLists,(function(a,s){return e("tr",{key:s},[e("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(a.customer_number)+"\n                                ")]),t._v(" "),e("td",[t._v("\n                                    "+t._s(a.customer_name)+"\n                                ")]),t._v(" "),e("td",[t._v("\n                                    "+t._s(a.province_name)+"\n                                ")]),t._v(" "),e("td",{staticClass:"text-right"},[t._v("\n                                    "+t._s(t.numberWithCommas(a.quantity))+"\n                                ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(a.uom)+"\n                                ")]),t._v(" "),e("td",{staticClass:"text-right"},[e("div",{staticClass:"w-100 el-input"},[e("vue-numeric",{staticClass:"el-input__inner text-right",attrs:{"read-only-class":"el-input__inner text-right",separator:",",precision:2,"read-only":!0,value:a.pv_pao_tax}})],1)])])})),0)])])])]),t._v(" "),e("el-tab-pane",{attrs:{label:"แยกรายตรา รายจังหวัด"}},[e("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[e("div",{staticClass:"col-md-12 table-responsive"},[e("table",{staticClass:"table",attrs:{id:"band_table"}},[e("thead",[e("tr",[e("th",{staticClass:"text-center"},[t._v("\n                                    รหัสร้านค้า\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    ชื่อร้านค้า\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    จังหวัด\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    รหัสสินค้า\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    ชื่อตราสินค้า\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    จำนวน\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    หน่วยนับ\n                                ")]),t._v(" "),e("th",{staticClass:"text-center"},[t._v("\n                                    ค่าภาษีอบจ.\n                                ")]),t._v(" "),e("th",{staticClass:"no-sort"})])]),t._v(" "),e("tbody",t._l(t.bdLists,(function(a){return e("tr",{key:a.pao_tax_mt_id},[e("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(a.customer?a.customer.customer_number:"")+"\n                                ")]),t._v(" "),e("td",[t._v("\n                                    "+t._s(a.customer?a.customer.customer_name:"")+"\n                                ")]),t._v(" "),e("td",[t._v("\n                                    "+t._s(a.province_name)+"\n                                ")]),t._v(" "),e("td",[t._v("\n                                    "+t._s(a.item_code)+"\n                                ")]),t._v(" "),e("td",[t._v("\n                                    "+t._s(a.item?a.item.item_description:"")+"\n                                ")]),t._v(" "),e("td",{staticClass:"text-right"},[t._v("\n                                    "+t._s(t.numberWithCommas(a.quantity_cg))+"\n                                ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(a.uom_v?a.uom_v.unit_of_measure:a.uom_code)+"\n                                ")]),t._v(" "),e("td",{staticClass:"text-right"},[e("div",{staticClass:"w-100 el-input"},[e("vue-numeric",{staticClass:"el-input__inner text-right",attrs:{separator:",",precision:2,value:a.adjust_amount},on:{change:function(e){return t.handleChange(a.pao_tax_mt_id,e)}}})],1)]),t._v(" "),e("td",[e("a",{attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.removeData(a,e)}}},[e("i",{staticClass:"fa fa-times text-danger",attrs:{"aria-hidden":"true"}})])])])})),0)])])])])],1),t._v(" "),e("div",{staticClass:"modal inmodal fade",attrs:{id:"warningModal",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[e("div",{staticClass:"modal-dialog modal-lg"},[e("div",{staticClass:"modal-content"},[e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"},on:{click:function(a){t.loading=!1}}},[e("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),t._v(" "),e("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),e("h4",[t._v("ดำเนินการต่อ ?")])]),t._v(" "),e("div",{staticClass:"modal-body",staticStyle:{padding:"20px"}},t._l(t.warningLists,(function(a,s){return e("div",{key:s},[e("ul",t._l(a,(function(a,s){return e("li",{key:s},[t._v("\n                                "+t._s(a)+"\n                            ")])})),0)])})),0),t._v(" "),e("div",{staticClass:"modal-footer"},[e("button",{staticClass:"btn btn-danger",attrs:{type:"button","data-dismiss":"modal"},on:{click:function(a){t.loading=!1}}},[t._v("ยกเลิก")]),t._v(" "),e("button",{staticClass:"btn btn-primary",attrs:{type:"button","data-dismiss":"modal"},on:{click:t.handleStore}},[t._v("ยืนยัน")])])])])]),t._v(" "),e("div",{staticClass:"modal inmodal fade",attrs:{id:"bankModal",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[e("div",{staticClass:"modal-dialog modal-lg"},[e("div",{staticClass:"modal-content"},[e("div",{staticClass:"modal-body",staticStyle:{padding:"15px"}},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[t._v("×")]),t._v(" "),e("h4",[t._v("โปรดเลือก รหัสเจ้าหนี้ หรือธนาคาร ?")]),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-12"},[e("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select","popper-append-to-body":!1},model:{value:t.bank,callback:function(a){t.bank=a},expression:"bank"}},t._l(t.bankLists,(function(t,a){return e("el-option",{key:a,attrs:{label:t.vendor_code+" : "+t.vendor_name+" : "+t.vendor_site_code,value:t.vendor_code+" : "+t.vendor_name+" : "+t.vendor_site_code}})})),1)],1)])]),t._v(" "),e("div",{staticClass:"modal-footer"},[e("button",{staticClass:"btn btn-primary",attrs:{type:"button","data-dismiss":"modal"},on:{click:t.handleInterface}},[t._v("ตกลง")])])])])])],1)}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("button",{staticClass:"btn btn-info",attrs:{"data-toggle":"modal","data-target":"#bankModal","data-backdrop":"static","data-keyboard":"false"}},[e("i",{staticClass:"fa fa-exchange"}),t._v(" ส่งรายการ Interface\n            ")])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-2 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"year"}},[t._v("ปี พ.ศ.")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-4 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"batch_ap"}},[t._v("Batch AP")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-2 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"month"}},[t._v("ประจำเดือน")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-4 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"batch_gl"}},[t._v("Batch GL")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-2 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"customer_number"}},[t._v("รหัสร้านค้า")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-2 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"file"}},[t._v("ไฟล์ Excel")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-md-2 text-right"},[e("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"display_sum"}},[t._v("รวมค่าภาษีอบจ.ทั้งสิ้น")])])}],!1,null,null,null).exports}}]);