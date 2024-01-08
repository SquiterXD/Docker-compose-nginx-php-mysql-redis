(self.webpackChunk=self.webpackChunk||[]).push([[1832],{41832:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>s});var n=a(80455);const o={components:{VueNumeric:a.n(n)()},props:[],data:function(){return{loading:!1,disable_params:!1,disable_report:!1,disable_interface:!1,dateLists:[],documentNoLists:[],document_date:"",document_no:"",interface_status:"",group_id:"",check:{Cons:!1,SO:!1,RMA:!1}}},mounted:function(){this.getDateLists()},methods:{getDateLists:function(){var t=this;t.documentNoLists=[],axios.get("/om/close-daily-sale/date-lists").then((function(e){t.dateLists=e.data})).catch((function(e){t.showError(e.message)})).then((function(){}))},getDocumentNoLists:function(){var t=this;t.document_no="",t.documentNoLists=[],axios.get("/om/close-daily-sale/document-no-lists?document_date="+t.document_date).then((function(e){t.documentNoLists=e.data})).catch((function(e){t.showError(e.message)})).then((function(){}))},callValidate:function(t){var e=this,a="",n=!1;if(e.document_date||(a+="กรุณาระบุวันที่ <br>",n=!0),n)return swal({html:!0,title:"กรุณาระบุข้อมูลให้ครบถ้วน",text:a,type:"error"}),!1;e.loading=!0,axios.post("/om/close-daily-sale/validate-data",{document_date:e.document_date,document_no:e.document_no}).then((function(a){"S"==a.data.status?"report"==t?e.callReport():"interface"==t&&e.callSO():(e.loading=!1,"report"==t?swal({title:"Warning!",text:a.data.msg,type:"warning",showCancelButton:!1,closeOnConfirm:!0},(function(t){t&&e.callReport()})):"interface"==t&&e.showError(a.data.msg))})).catch((function(t){e.showError(t.message)})).then((function(){}))},callSO:function(){var t=this;t.loading=t.disable_interface=!0,t.callInterface("Sale-Order-Consignment"),t.callInterface("Sale-Order"),t.callInterface("Sale-Order-RMA")},callInterface:function(t){var e=this;e.loading=e.disable_interface=!0,axios.post("/om/close-daily-sale/interface",{document_date:e.document_date,document_no:e.document_no,group_id:e.group_id,type:t}).then((function(a){e.interface_status=a.data.status,"S"==a.data.status?("Sale-Order-Consignment"==t?(e.check.Cons=!0,e.check.Cons&&e.check.SO&&e.check.RMA&&e.callInterface("Invoice")):"Sale-Order"==t?(e.check.SO=!0,e.check.Cons&&e.check.SO&&e.check.RMA&&e.callInterface("Invoice")):"Sale-Order-RMA"==t&&(e.check.RMA=!0,e.check.Cons&&e.check.SO&&e.check.RMA&&e.callInterface("Invoice")),"Invoice"==t&&(e.showSuccess(a.data.msg),e.group_id=a.data.group_id,e.document_date="",e.document_no="",e.getDateLists())):e.showError(a.data.msg)})).catch((function(t){e.showError(t.message)})).then((function(){"Invoice"==t&&(e.loading=e.disable_interface=!1)}))},callReport:function(){var t=this;t.loading=t.disable_report=!0,axios.post("/om/close-daily-sale/call-report",{document_date:t.document_date,document_no:t.document_no}).then((function(e){"S"==e.data.status?(t.group_id=e.data.group_id,t.showSuccess(e.data.msg),t.getReport()):(t.group_id="",t.showError(e.data.msg))})).catch((function(e){t.showError(e.message)})).then((function(){t.loading=t.disable_report=!1}))},getReport:function(){var t=this;window.open("/ir/reports/get-param?group_id="+t.group_id+"&document_date="+t.document_date+"&program_code=OMR0035&function_name=OMR0035&output=pdf","_blank"),window.open("/ir/reports/get-param?group_id="+t.group_id+"&document_date="+t.document_date+"&program_code=OMR0064&function_name=OMR0064&output=pdf","_blank")},showSuccess:function(t){swal("Success!",t,"success")},showError:function(t){swal("Error!",t,"error")}}};const s=(0,a(51900).Z)(o,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[a("div",{staticClass:"row mb-3"},[a("div",{staticClass:"col-md-3"}),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"row mb-3"},[a("div",{staticClass:"col-md-12"},[t._m(0),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select",disabled:t.disable_params},on:{focus:function(e){return t.getDateLists()},input:function(e){return t.getDocumentNoLists()}},model:{value:t.document_date,callback:function(e){t.document_date=e},expression:"document_date"}},t._l(t.dateLists,(function(t,e){return a("el-option",{key:e,attrs:{label:t,value:e}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row mb-3"},[a("div",{staticClass:"col-md-12"},[a("label",[t._v("เลขที่เอกสาร ")]),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",clearable:"",placeholder:"Select",disabled:t.disable_params},model:{value:t.document_no,callback:function(e){t.document_no=e},expression:"document_no"}},t._l(t.documentNoLists,(function(t,e){return a("el-option",{key:e,attrs:{label:t,value:e}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row mb-3"},[a("div",{staticClass:"col-md-12"},[a("label",[t._v("Group ID")]),t._v(" "),a("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.group_id,callback:function(e){t.group_id=e},expression:"group_id"}})],1)]),t._v(" "),a("div",{staticClass:"row mb-3"},[a("div",{staticClass:"col-md-12"},[a("label",[t._v("หมายเหตุ")]),t._v(" "),a("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.interface_status,callback:function(e){t.interface_status=e},expression:"interface_status"}})],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 text-center"},[a("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:t.disable_report},on:{click:function(e){return t.callValidate("report")}}},[t._v(" ประมวลผล")]),t._v(" "),a("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:t.disable_interface},on:{click:function(e){return t.callValidate("interface")}}},[t._v(" Interface")])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v("วันที่ "),a("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);