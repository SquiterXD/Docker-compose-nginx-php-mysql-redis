(self.webpackChunk=self.webpackChunk||[]).push([[4850],{74850:(t,a,s)=>{"use strict";s.r(a),s.d(a,{default:()=>r});var e,o=s(80455);function l(t,a,s){return a in t?Object.defineProperty(t,a,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[a]=s,t}const i={components:{VueNumeric:s.n(o)()},props:["saleClass"],data:function(){return{dateLoading:!1,loading:!1,disable_params:!1,disable_report:!1,disable_interface:!1,dateLists:[],documentNoLists:[],close_date:"",interface_status:"",show_group_id:"",group_id:""}},mounted:function(){},methods:(e={getDateLists:function(){var t=this;t.dateLoading=!0,axios.post("/om/close-daily-payoff/"+t.saleClass+"/date-lists",{sale_class:t.saleClass}).then((function(a){t.dateLists=a.data})).catch((function(a){t.dateLoading=!1,t.showError(a.message)})).then((function(){t.dateLoading=!1}))},callValidate:function(t){var a=this,s="",e=!1;if(a.close_date||(s+="กรุณาระบุวันที่ <br>",e=!0),e)return swal({html:!0,title:"กรุณาระบุข้อมูลให้ครบถ้วน",text:s,type:"error"}),!1;a.loading=!0,axios.post("/om/close-daily-payoff/"+a.saleClass+"/validate-data",{close_date:a.close_date,sale_class:a.saleClass}).then((function(s){"S"==s.data.status?"report"==t?a.callReport():"interface"==t&&a.callInterface():(a.loading=!1,"report"==t?swal({title:"Warning!",text:s.data.msg,type:"warning",showCancelButton:!1,closeOnConfirm:!0},(function(t){t&&a.callReport()})):"interface"==t&&a.showError(s.data.msg))})).catch((function(t){a.showError(t.message)})).then((function(){}))},callInterface:function(){var t=this;t.loading=!0,axios.post("/om/close-daily-payoff/"+t.saleClass+"/interface",{close_date:t.close_date,sale_class:t.saleClass,group_id:t.group_id}).then((function(a){t.interface_status=a.data.status,"S"==a.data.status?(t.getDateLists(),t.showSuccess(a.data.msg),t.close_date="",t.group_id="",t.show_group_id=a.data.group_id):t.showError(a.data.msg)})).catch((function(a){t.showError(a.message)})).then((function(){t.loading=!1}))},showSuccess:function(t){swal("Success!",t,"success")},showError:function(t){swal("Error!",t,"error")},callReport:function(){var t=this;t.loading=t.disable_report=!0,axios.post("/om/close-daily-payoff/"+t.saleClass+"/call-report",{close_date:t.close_date,sale_class:t.saleClass}).then((function(a){"S"==a.data.status?(t.group_id=a.data.group_id,t.showSuccess(a.data.msg),t.getReport(t.saleClass)):(t.group_id="",t.showError(a.data.msg))})).catch((function(a){t.showError(a.message)})).then((function(){t.loading=t.disable_report=!1}))},getReport:function(t){var a=this;"export"===t?window.open("/ir/reports/get-param?group_id="+a.group_id+"&document_date="+a.close_date+"&program_code=OMR0112&function_name=OMR0112&output=pdf","_blank"):window.open("/ir/reports/get-param?group_id="+a.group_id+"&document_date="+a.close_date+"&program_code=OMR0064&function_name=OMR0064&output=pdf","_blank")}},l(e,"showSuccess",(function(t){swal("Success!",t,"success")})),l(e,"showError",(function(t){swal("Error!",t,"error")})),e)};const r=(0,s(51900).Z)(i,(function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-3"}),t._v(" "),s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[t._m(0),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select",disabled:t.disable_params,loading:t.dateLoading},on:{focus:function(a){return t.getDateLists()}},model:{value:t.close_date,callback:function(a){t.close_date=a},expression:"close_date"}},t._l(t.dateLists,(function(t,a){return s("el-option",{key:a,attrs:{label:t,value:a}})})),1)],1)]),t._v(" "),s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[s("label",[t._v("Group ID")]),t._v(" "),s("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.show_group_id,callback:function(a){t.show_group_id=a},expression:"show_group_id"}})],1)]),t._v(" "),s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[s("label",[t._v("หมายเหตุ")]),t._v(" "),s("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.interface_status,callback:function(a){t.interface_status=a},expression:"interface_status"}})],1)]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 text-center"},[s("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:t.disable_report},on:{click:function(a){return t.callValidate("report")}}},[t._v(" ประมวลผล")]),t._v(" "),s("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:t.disable_interface},on:{click:function(a){return t.callValidate("interface")}}},[t._v(" Interface")])])])])])])}),[function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("label",[t._v("วันที่ "),s("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);