(self.webpackChunk=self.webpackChunk||[]).push([[8306],{78306:(t,a,e)=>{"use strict";e.r(a),e.d(a,{default:()=>r});var s,o=e(80455);function l(t,a,e){return a in t?Object.defineProperty(t,a,{value:e,enumerable:!0,configurable:!0,writable:!0}):t[a]=e,t}const i={components:{VueNumeric:e.n(o)()},props:["saleClass"],data:function(){return{dateLoading:!1,loading:!1,disable_params:!1,disable_report:!1,disable_interface:!0,dateLists:[],documentNoLists:[],close_date:"",interface_status:"",group_id:""}},mounted:function(){},methods:(s={getDateLists:function(){var t=this;t.dateLoading=!0,axios.post("/om/close-daily-payoff/"+t.saleClass+"/date-lists",{sale_class:t.saleClass}).then((function(a){t.dateLists=a.data})).catch((function(a){t.dateLoading=!1,t.showError(a.message)})).then((function(){t.dateLoading=!1}))},resetButton:function(){this.disable_report=!1,this.disable_interface=!0},callValidate:function(t){var a=this,e="",s=!1;if(a.close_date||(e+="กรุณาระบุวันที่ <br>",s=!0),s)return swal({html:!0,title:"กรุณาระบุข้อมูลให้ครบถ้วน",text:e,type:"error"}),!1;a.loading=!0,axios.post("/om/close-daily-payoff/"+a.saleClass+"/validate-data",{close_date:a.close_date,sale_class:a.saleClass}).then((function(e){"S"==e.data.status?"report"==t?a.callReport():"interface"==t&&a.callInterface():(a.loading=!1,("report"==t||"interface"==t)&&a.showError(e.data.msg))})).catch((function(t){a.showError(t.message)})).then((function(){}))},callInterface:function(){var t=this;t.loading=t.disable_interface=!0,axios.post("/om/close-daily-payoff/"+t.saleClass+"/interface",{close_date:t.close_date,sale_class:t.saleClass,group_id:t.group_id}).then((function(a){t.interface_status=a.data.status,"S"==a.data.status?(t.getDateLists(),t.showSuccess(a.data.msg),t.close_date="",t.group_id=a.data.group_id):(t.showError(a.data.msg),t.disable_interface=!1)})).catch((function(a){t.showError(a.message),t.disable_interface=!1})).then((function(){t.loading=!1}))},showSuccess:function(t){swal("Success!",t,"success")},showError:function(t){swal("Error!",t,"error")},callReport:function(){var t=this;t.loading=t.disable_report=!0,axios.post("/om/close-daily-payoff/"+t.saleClass+"/call-report",{close_date:t.close_date,sale_class:t.saleClass}).then((function(a){"S"==a.data.status?(t.group_id=a.data.group_id,t.showSuccess(a.data.msg),t.getReport(t.saleClass),t.disable_interface=!1):(t.group_id="",t.showError(a.data.msg),t.disable_report=!1)})).catch((function(a){t.showError(a.message),t.disable_report=!1})).then((function(){t.loading=!1}))},getReport:function(t){var a=this;"export"===t?window.open("/ir/reports/get-param?group_id="+a.group_id+"&document_date="+a.close_date+"&program_code=OMR0112&function_name=OMR0112&output=pdf","_blank"):window.open("/ir/reports/get-param?group_id="+a.group_id+"&document_date="+a.close_date+"&program_code=OMR0064&function_name=OMR0064&output=pdf","_blank")}},l(s,"showSuccess",(function(t){swal("Success!",t,"success")})),l(s,"showError",(function(t){swal("Error!",t,"error")})),s)};const r=(0,e(51900).Z)(i,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[e("div",{staticClass:"row mb-3"},[e("div",{staticClass:"col-md-3"}),t._v(" "),e("div",{staticClass:"col-md-6"},[e("div",{staticClass:"row mb-3"},[e("div",{staticClass:"col-md-12"},[t._m(0),t._v(" "),e("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select",disabled:t.disable_params,loading:t.dateLoading},on:{focus:function(a){return t.getDateLists()},change:function(a){return t.resetButton()}},model:{value:t.close_date,callback:function(a){t.close_date=a},expression:"close_date"}},t._l(t.dateLists,(function(t,a){return e("el-option",{key:a,attrs:{label:t,value:a}})})),1)],1)]),t._v(" "),e("div",{staticClass:"row mb-3"},[e("div",{staticClass:"col-md-12"},[e("label",[t._v("Group ID")]),t._v(" "),e("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.group_id,callback:function(a){t.group_id=a},expression:"group_id"}})],1)]),t._v(" "),e("div",{staticClass:"row mb-3"},[e("div",{staticClass:"col-md-12"},[e("label",[t._v("หมายเหตุ")]),t._v(" "),e("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:t.interface_status,callback:function(a){t.interface_status=a},expression:"interface_status"}})],1)]),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-12 text-center"},[e("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:t.disable_report},on:{click:function(a){return t.callValidate("report")}}},[t._v(" ประมวลผล")]),t._v(" "),e("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:t.disable_interface},on:{click:function(a){return t.callValidate("interface")}}},[t._v(" Interface")])])])])])])}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v("วันที่ "),e("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);