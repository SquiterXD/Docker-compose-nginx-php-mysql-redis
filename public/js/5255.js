(self.webpackChunk=self.webpackChunk||[]).push([[5255],{15255:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>c});var s=a(87757),n=a.n(s),r=a(80455);function i(t,e,a,s,n,r,i){try{var o=t[r](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(s,n)}function o(t){return function(){var e=this,a=arguments;return new Promise((function(s,n){var r=t.apply(e,a);function o(t){i(r,s,n,o,l,"next",t)}function l(t){i(r,s,n,o,l,"throw",t)}o(void 0)}))}}const l={components:{VueNumeric:a.n(r)()},props:["customerLists","bankLists"],data:function(){return{loading:!1,showRequires:!1,saveable:!1,defaultYear:"",year:"",month:"",month_options:[{value:"1",label:"มกราคม"},{value:"2",label:"กุมภาพันธ์"},{value:"3",label:"มีนาคม"},{value:"4",label:"เมษายน"},{value:"5",label:"พฤษภาคม"},{value:"6",label:"มิถุนายน"},{value:"7",label:"กรกฎาคม"},{value:"8",label:"สิงหาคม"},{value:"9",label:"กันยายน"},{value:"10",label:"ตุลาคม"},{value:"11",label:"พฤศจิกายน"},{value:"12",label:"ธันวาคม"}],customer_number:"",customer_name:"",file:"",display_sum:"0.00",pvLists:[],bdLists:[],warningLists:{},requireLists:{},adjustLists:{},removeLists:{},bank:""}},mounted:function(){var t=new Date,e=t.getFullYear(),a=t.getMonth(),s=t.getDate();this.defaultYear=new Date(e+543,a,s),$("#band_table, #province_table").DataTable({destroy:!0})},methods:{findCustomer:function(){var t=this,e=this.customerLists.find((function(e){return e.customer_number==t.customer_number}));this.customer_name=e?e.customer_name:""},handleFileUpload:function(){this.file=this.$refs.file.files.length?this.$refs.file.files[0]:""},handleSearch:function(){var t=this;t.showRequires=!1,t.requireLists={},t.year||(t.showRequires=!0,t.requireLists.year="โปรดเลือกปี"),t.showRequires||(t.loading=!0,$("#band_table, #province_table").DataTable().destroy(),axios.get("/om/pao-tax-mt/search",{params:{year:t.year,month:t.month,customer_number:t.customer_number}}).then((function(e){t.bdLists=e.data.result})).catch((function(t){console.log(t)})).then((function(){t.composePvTable(),t.updateTotalPaotax()})).then((function(){$("#band_table, #province_table").DataTable({columnDefs:[{targets:"no-sort",orderable:!1}],pageLength:10,responsive:!0,destroy:!0}),t.loading=!1,t.showSuccess()})))},handlePrintEx:function(){var t=this,e="/om/pao-tax-mt/ex-report?year="+t.year+"&month="+t.month+"&customer_number="+t.customer_number;window.open(e,"_blank")},handleStore:function(){var t=this;t.loading=!0;var e=new FormData;e.append("year",t.year),e.append("month",t.month),e.append("customer_number",t.customer_number),e.append("file",t.file),axios.post("/om/pao-tax-mt/store",e,{headers:{"Content-Type":"multipart/form-data"}}).then((function(e){t.$refs.file.value="",t.file=""})).catch((function(t){console.log(t)})).then((function(){t.handleSearch()}))},handleChange:function(t,e){var a=this,s=a.bdLists.find((function(e){return e.pao_tax_mt_id==t}));s.adjust_amount=e.target.value,a.saveable=!0,a.composePvTable(),a.updateTotalPaotax(),a.adjustLists[s.pao_tax_mt_id]=s.adjust_amount},removeData:function(t,e){var a=this;return o(n().mark((function e(){var s;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:s=a,swal({title:"แจ้งเตือน",text:"ต้องการจะลบรายการหรือไม่?",icon:"warning",showCancelButton:!0,cancelButtonText:"ยกเลิก",cancelButtonColor:"#d33",confirmButtonText:"ยืนยัน"},function(){var e=o(n().mark((function e(a){var r;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a&&(r=s.bdLists.indexOf(t),s.loading=!0,axios.post("/om/pao-tax-mt/remove",{pao_tax_id:t.pao_tax_mt_id}).then(function(){var t=o(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if("E"!=e.data.status){t.next=4;break}s.showError(e.data.msg),t.next=16;break;case 4:return s.bdLists.splice(r,1),t.next=7,$("#band_table, #province_table").DataTable().destroy();case 7:return t.next=9,$("#band_table, #province_table").DataTable({columnDefs:[{targets:"no-sort",orderable:!1}],pageLength:10,responsive:!0,destroy:!0});case 9:return s.saveable=!0,t.next=12,s.composePvTable();case 12:return t.next=14,s.updateTotalPaotax();case 14:return t.next=16,s.showSuccess(e.data.msg);case 16:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()).catch((function(t){console.log(t)})).then(o(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:s.loading=!1;case 1:case"end":return t.stop()}}),t)})))));case 1:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 2:case"end":return e.stop()}}),e)})))()},handleSaveData:function(){var t=this;t.loading=!0,axios.patch("/om/pao-tax-mt/update",{adjust_lists:t.adjustLists}).then((function(t){})).catch((function(t){console.log(t)})).then((function(){t.loading=!1,t.saveable=!1,t.showSuccess()}))},validateData:function(){var t=this;if(t.showRequires=!1,t.requireLists={},t.year||(t.showRequires=!0,t.requireLists.year="โปรดเลือกปี"),t.month||(t.showRequires=!0,t.requireLists.month="โปรดเลือกเดือน"),t.file||(t.showRequires=!0,t.requireLists.file="โปรดเลือกไฟล์"),!t.showRequires){t.loading=!0;var e=new FormData;e.append("year",t.year),e.append("month",t.month),e.append("customer_number",t.customer_number),e.append("file",t.file),axios.post("/om/pao-tax-mt/validate",e,{headers:{"Content-Type":"multipart/form-data"}}).then((function(e){"E"==e.data.status?(t.loading=!1,t.showError(e.data.msg)):"W"==e.data.status?(t.warningLists=e.data.errors,$("#warningModal").modal({backdrop:"static",keyboard:!1})):t.handleStore()})).catch((function(t){console.log(t)})).then((function(){}))}},handleInterface:function(){var t=this;if(t.showRequires=!1,t.requireLists={},t.year||(t.showRequires=!0,t.requireLists.year="โปรดเลือกปี"),t.month||(t.showRequires=!0,t.requireLists.month="โปรดเลือกเดือน"),t.bank||(t.showRequires=!0,t.requireLists.bank="โปรดเลือกธนาคาร"),!t.showRequires){t.loading=!0;var e=new FormData;e.append("year",t.year),e.append("month",t.month),e.append("customer_number",t.customer_number),e.append("bank",t.bank),axios.post("/om/pao-tax-mt/interface",e).then((function(e){if("S"==e.data.status){var a="group id : "+e.data.group_id;t.showSuccess(a),t.bank=""}else t.showError(e.data.msg)})).catch((function(t){console.log(t)})).then((function(){t.loading=!1}))}},handleClickTab:function(t,e){},updateTotalPaotax:function(){var t=this;return o(n().mark((function e(){var a,s;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:s=0,(a=t).bdLists.forEach((function(t){s+=parseFloat(t.adjust_amount)})),a.display_sum=s;case 4:case"end":return e.stop()}}),e)})))()},composePvTable:function(){var t=this;return o(n().mark((function e(){var a,s;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:s=[],(a=t).bdLists.forEach((function(t){var e=t.customer,a=t.province,n=t.item;s.find((function(t){return t.province_name==a.province_thai&&t.customer_number==e.customer_number}))?s.forEach((function(s){s.province_name==a.province_thai&&s.customer_number==e.customer_number&&(s.quantity+=parseFloat(t.quantity_cg),s.pv_pao_tax+=parseFloat(t.adjust_amount),s.items.push(t))})):s.push({province_name:a.province_thai,customer_number:e.customer_number,customer_name:e.customer_name,quantity:parseFloat(t.quantity_cg),uom:n.uom,pv_pao_tax:parseFloat(t.adjust_amount),items:[t]})})),a.pvLists=s;case 4:case"end":return e.stop()}}),e)})))()},showSuccess:function(t){swal("Success!",t,"success")},showError:function(t){swal("Error!",t,"error")},numberWithCommas:function(t){return parseFloat(t).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")}}};const c=(0,a(51900).Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[a("div",{directives:[{name:"show",rawName:"v-show",value:t.showRequires,expression:"showRequires"}],staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[a("div",{staticClass:"col-md-12"},[a("ul",{staticClass:"text-danger"},t._l(t.requireLists,(function(e,s){return a("li",{key:s},[t._v("\n                    "+t._s(e)+"\n                ")])})),0)])]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[a("div",{staticClass:"col-md-12 text-right"},[a("button",{staticClass:"btn btn-light",on:{click:t.handleSearch}},[a("i",{staticClass:"fa fa-search"}),t._v(" Search\n            ")]),t._v(" "),a("button",{staticClass:"btn btn-primary",on:{click:t.handlePrintEx}},[a("i",{staticClass:"fa fa-print"}),t._v(" พิมพ์ตัวอย่าง\n            ")]),t._v(" "),a("button",{staticClass:"btn btn-light",on:{click:t.validateData}},[a("i",{staticClass:"fa fa-upload"}),t._v(" นำเข้าข้อมูล\n            ")]),t._v(" "),t._m(0)])]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(1),t._v(" "),a("div",{staticClass:"col-md-3"},[a("el-date-picker",{staticClass:"w-100",attrs:{clearable:!1,id:"year",type:"year",placeholder:"ปี พ.ศ.",format:"yyyy","value-format":"yyyy","default-value":t.defaultYear},model:{value:t.year,callback:function(e){t.year=e},expression:"year"}})],1)]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(2),t._v(" "),a("div",{staticClass:"col-md-3"},[a("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select"},model:{value:t.month,callback:function(e){t.month=e},expression:"month"}},t._l(t.month_options,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(3),t._v(" "),a("div",{staticClass:"col-md-3"},[a("el-select",{staticClass:"w-100",attrs:{placeholder:"Select",filterable:"",clearable:""},on:{change:t.findCustomer},model:{value:t.customer_number,callback:function(e){t.customer_number=e},expression:"customer_number"}},t._l(t.customerLists,(function(e){return a("el-option",{key:e.customer_id,attrs:{label:e.customer_number,value:e.customer_number}},[t._v("\n                    "+t._s(e.customer_number+" : "+e.customer_name)+"\n                ")])})),1)],1),t._v(" "),a("div",{staticClass:"col-md-3"},[a("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.customer_name,callback:function(e){t.customer_name=e},expression:"customer_name"}})],1)]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(4),t._v(" "),a("div",{staticClass:"col-md-6"},[a("input",{ref:"file",attrs:{type:"file",id:"file",accept:".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"},on:{change:function(e){return t.handleFileUpload()}}})])]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[t._m(5),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"w-100 el-input"},[a("vue-numeric",{staticClass:"el-input__inner text-right",attrs:{"read-only-class":"el-input__inner text-right",separator:",",precision:2,"read-only":!0},model:{value:t.display_sum,callback:function(e){t.display_sum=e},expression:"display_sum"}})],1)])]),t._v(" "),a("hr"),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12 text-right"},[a("button",{staticClass:"btn btn-primary",on:{click:t.handleSaveData}},[a("i",{staticClass:"fa fa-floppy-o"}),t._v(" บันทึก\n            ")])])]),t._v(" "),a("el-tabs",{attrs:{type:"card"},on:{"tab-click":t.handleClickTab}},[a("el-tab-pane",{attrs:{label:"แยกรายจังหวัด"}},[a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[a("div",{staticClass:"col-md-12 table-responsive"},[a("table",{staticClass:"table",attrs:{id:"province_table"}},[a("thead",[a("tr",[a("th",{staticClass:"text-center"},[t._v("\n                                    รหัสร้านค้า\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    ชื่อร้านค้า\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    จังหวัด\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    จำนวน\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    หน่วยนับ\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    ค่าภาษีอบจ.\n                                ")])])]),t._v(" "),a("tbody",t._l(t.pvLists,(function(e,s){return a("tr",{key:s},[a("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.customer_number)+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.customer_name)+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.province_name)+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-right"},[t._v("\n                                    "+t._s(t.numberWithCommas(e.quantity))+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.uom)+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticClass:"w-100 el-input"},[a("vue-numeric",{staticClass:"el-input__inner text-right",attrs:{"read-only-class":"el-input__inner text-right",separator:",",precision:2,"read-only":!0,value:e.pv_pao_tax}})],1)])])})),0)])])])]),t._v(" "),a("el-tab-pane",{attrs:{label:"แยกรายตรา รายจังหวัด"}},[a("div",{staticClass:"row",staticStyle:{"margin-bottom":"1rem"}},[a("div",{staticClass:"col-md-12 table-responsive"},[a("table",{staticClass:"table",attrs:{id:"band_table"}},[a("thead",[a("tr",[a("th",{staticClass:"text-center"},[t._v("\n                                    รหัสร้านค้า\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    ชื่อร้านค้า\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    จังหวัด\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    รหัสสินค้า\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    ชื่อตราสินค้า\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    จำนวน\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    หน่วยนับ\n                                ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("\n                                    ค่าภาษีอบจ.\n                                ")]),t._v(" "),a("th",{staticClass:"no-sort"})])]),t._v(" "),a("tbody",t._l(t.bdLists,(function(e){return a("tr",{key:e.pao_tax_mt_id},[a("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.customer?e.customer.customer_number:"")+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.customer?e.customer.customer_name:"")+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.province_name)+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.item_code)+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.item?e.item.item_description:"")+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-right"},[t._v("\n                                    "+t._s(t.numberWithCommas(e.quantity_cg))+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.item?e.item.uom:"")+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticClass:"w-100 el-input"},[a("vue-numeric",{staticClass:"el-input__inner text-right",attrs:{separator:",",precision:2,value:e.adjust_amount},on:{change:function(a){return t.handleChange(e.pao_tax_mt_id,a)}}})],1)]),t._v(" "),a("td",[a("a",{attrs:{href:"#"},on:{click:function(a){return a.preventDefault(),t.removeData(e,a)}}},[a("i",{staticClass:"fa fa-times text-danger",attrs:{"aria-hidden":"true"}})])])])})),0)])])])])],1),t._v(" "),a("div",{staticClass:"modal inmodal fade",attrs:{id:"warningModal",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg"},[a("div",{staticClass:"modal-content"},[a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"},on:{click:function(e){t.loading=!1}}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),t._v(" "),a("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),a("h4",[t._v("ดำเนินการต่อ ?")])]),t._v(" "),a("div",{staticClass:"modal-body",staticStyle:{padding:"20px"}},t._l(t.warningLists,(function(e,s){return a("div",{key:s},[a("ul",t._l(e,(function(e,s){return a("li",{key:s},[t._v("\n                                "+t._s(e)+"\n                            ")])})),0)])})),0),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-danger",attrs:{type:"button","data-dismiss":"modal"},on:{click:function(e){t.loading=!1}}},[t._v("ยกเลิก")]),t._v(" "),a("button",{staticClass:"btn btn-primary",attrs:{type:"button","data-dismiss":"modal"},on:{click:t.handleStore}},[t._v("ยืนยัน")])])])])]),t._v(" "),a("div",{staticClass:"modal inmodal fade",attrs:{id:"bankModal",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg"},[a("div",{staticClass:"modal-content"},[a("div",{staticClass:"modal-body",staticStyle:{padding:"15px"}},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[t._v("×")]),t._v(" "),a("h4",[t._v("โปรดเลือก รหัสเจ้าหนี้ หรือธนาคาร ?")]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select","popper-append-to-body":!1},model:{value:t.bank,callback:function(e){t.bank=e},expression:"bank"}},t._l(t.bankLists,(function(t,e){return a("el-option",{key:e,attrs:{label:t.vendor_code+" : "+t.vendor_name+" : "+t.vendor_site_code,value:t.vendor_code+" : "+t.vendor_name+" : "+t.vendor_site_code}})})),1)],1)])]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-primary",attrs:{type:"button","data-dismiss":"modal"},on:{click:t.handleInterface}},[t._v("ตกลง")])])])])])],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("button",{staticClass:"btn btn-info",attrs:{"data-toggle":"modal","data-target":"#bankModal","data-backdrop":"static","data-keyboard":"false"}},[a("i",{staticClass:"fa fa-exchange"}),t._v(" ส่งรายการ Interface\n            ")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-2 text-right"},[a("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"year"}},[t._v("ปี พ.ศ.")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-2 text-right"},[a("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"month"}},[t._v("ประจำเดือน")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-2 text-right"},[a("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"customer_number"}},[t._v("รหัสร้านค้า")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-2 text-right"},[a("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"file"}},[t._v("ไฟล์ Excel")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-2 text-right"},[a("label",{staticStyle:{"padding-top":"10px"},attrs:{for:"display_sum"}},[t._v("รวมค่าภาษีอบจ.ทั้งสิ้น")])])}],!1,null,null,null).exports}}]);