(self.webpackChunk=self.webpackChunk||[]).push([[9475],{19475:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>o});var c=s(80455);const n={components:{VueNumeric:s.n(c)()},props:[],data:function(){return{loading:!1,disable_params:!1,disable_report:!1,disable_interface:!1,dateLists:[],documentNoLists:[],document_date:"",document_no:"",interface_status:"",group_id:"",check:{Cons:{send:!1,done:!1,pass:!1,msg:""},SO:{send:!1,done:!1,pass:!1,msg:""},RMA:{send:!1,done:!1,pass:!1,msg:""},INV:{send:!1,done:!1,pass:!1,msg:""},GL:{send:!1,done:!1,pass:!1,msg:""}}}},mounted:function(){this.getDateLists()},methods:{getDateLists:function(){var e=this;e.documentNoLists=[],axios.get("/om/close-daily-sale/date-lists").then((function(t){e.dateLists=t.data})).catch((function(t){e.showError(t.message)})).then((function(){}))},getDocumentNoLists:function(){var e=this;e.document_no="",e.documentNoLists=[],axios.get("/om/close-daily-sale/document-no-lists?document_date="+e.document_date).then((function(t){e.documentNoLists=t.data})).catch((function(t){e.showError(t.message)})).then((function(){}))},callValidate:function(e){var t=this,s="",c=!1;if(t.document_date||(s+="กรุณาระบุวันที่ <br>",c=!0),c)return swal({html:!0,title:"กรุณาระบุข้อมูลให้ครบถ้วน",text:s,type:"error"}),!1;t.loading=!0,axios.post("/om/close-daily-sale/validate-data",{document_date:t.document_date,document_no:t.document_no}).then((function(s){"S"==s.data.status?"report"==e?t.callReport():"interface"==e&&t.callSO():(t.loading=!1,"report"==e?swal({title:"Warning!",text:s.data.msg,type:"warning",showCancelButton:!1,closeOnConfirm:!0},(function(e){e&&t.callReport()})):"interface"==e&&t.showError(s.data.msg))})).catch((function(e){t.showError(e.message)})).then((function(){}))},callSO:function(){var e=this;e.loading=e.disable_interface=!0,e.check.Cons.send=!0,e.check.SO.send=!0,e.check.RMA.send=!0,e.callInterface("Sale-Order-Consignment"),e.callInterface("Sale-Order"),e.callInterface("Sale-Order-RMA")},callInterface:function(e){var t=this,s="";t.loading=t.disable_interface=!0;var c="";"Sale-Order-Consignment"==e?c="/om/close-daily-sale/interface/process-cons":"Sale-Order"==e?c="/om/close-daily-sale/interface/process-so":"Sale-Order-RMA"==e?c="/om/close-daily-sale/interface/process-rma":"Invoice"==e?c="/om/close-daily-sale/interface/process-invoice":"GL"==e&&(c="/om/close-daily-sale/interface/process-gl"),axios.post(c,{document_date:t.document_date,document_no:t.document_no,group_id:t.group_id,type:e}).then((function(c){t.interface_status=c.data.status,"S"==c.data.status?("Sale-Order-Consignment"==e?(t.check.Cons.pass=!0,t.check.Cons.done=!0):"Sale-Order"==e?(t.check.SO.pass=!0,t.check.SO.done=!0):"Sale-Order-RMA"==e&&(t.check.RMA.pass=!0,t.check.RMA.done=!0),"Invoice"==e?(s=c.data.group_id,t.check.INV.pass=!0,t.check.INV.done=!0):"GL"==e&&(s=c.data.group_id,t.check.GL.pass=!0,t.check.GL.done=!0)):"Sale-Order-Consignment"==e?(t.check.Cons.msg=c.data.msg,t.check.Cons.done=!0):"Sale-Order"==e?(t.check.SO.msg=c.data.msg,t.check.SO.done=!0):"Sale-Order-RMA"==e?(t.check.RMA.msg=c.data.msg,t.check.RMA.done=!0):"Invoice"==e?(t.check.INV.msg=c.data.msg,t.check.INV.done=!0):"GL"==e&&(t.check.GL.msg=c.data.msg,t.check.GL.done=!0)})).catch((function(s){"Sale-Order-Consignment"==e?(t.check.Cons.msg=s.message,t.check.Cons.done=!0):"Sale-Order"==e?(t.check.SO.msg=s.message,t.check.SO.done=!0):"Sale-Order-RMA"==e?(t.check.RMA.msg=s.message,t.check.RMA.done=!0):"Invoice"==e?(t.check.INV.msg=s.message,t.check.INV.done=!0):"GL"==e&&(t.check.GL.msg=s.message,t.check.GL.done=!0)})).then((function(){"Invoice"==e||"GL"==e?t.check.INV.pass&&t.check.GL.pass?(t.group_id=s,t.showSuccess("ดำเนินการปิดการขายประจำวันเรียบร้อยแล้ว Group ID : "+t.group_id),t.document_date="",t.document_no="",t.getDateLists(),t.resetSOCheck(),t.resetInvGlCheck(),t.loading=t.disable_interface=!1):t.check.INV.done&&t.check.GL.done&&(t.showInvGlError(),t.loading=t.disable_interface=!1):t.check.Cons.pass&&t.check.SO.pass&&t.check.RMA.pass?(t.callInterface("Invoice"),t.callInterface("GL")):t.check.Cons.done&&t.check.SO.done&&t.check.RMA.done&&(t.showSOError(),t.loading=t.disable_interface=!1)}))},callReport:function(){var e=this;e.loading=e.disable_report=!0,axios.post("/om/close-daily-sale/call-report",{document_date:e.document_date,document_no:e.document_no}).then((function(t){"S"==t.data.status?(e.group_id=t.data.group_id,e.showSuccess(t.data.msg),e.getReport()):(e.group_id="",e.showError(t.data.msg))})).catch((function(t){e.showError(t.message)})).then((function(){e.loading=e.disable_report=!1}))},getReport:function(){var e=this;window.open("/ir/reports/get-param?group_id="+e.group_id+"&document_date="+e.document_date+"&program_code=OMR0035&function_name=OMR0035&output=pdf","_blank"),window.open("/ir/reports/get-param?group_id="+e.group_id+"&document_date="+e.document_date+"&program_code=OMR0064&function_name=OMR0064&output=pdf","_blank")},showSuccess:function(e){swal({title:"Success",text:e,icon:"success",showConfirmButton:!0,showCancelButton:!1,closeOnClickOutside:!1,closeOnEsc:!1})},showError:function(e){swal({title:"Error",text:e,icon:"error",showConfirmButton:!0,showCancelButton:!1,closeOnClickOutside:!1,closeOnEsc:!1})},showSOError:function(){var e=this,t="";e.check.Cons.pass||(t+="Consignment Error : "+e.check.Cons.msg+"<br>"),e.check.SO.pass||(t+="SO Error : "+e.check.SO.msg+"<br>"),e.check.RMA.pass||(t+="RMA Error : "+e.check.RMA.msg),swal({title:"Error",text:t,icon:"error",showConfirmButton:!0,showCancelButton:!1,closeOnClickOutside:!1,closeOnEsc:!1}).then((function(t){e.resetInvGlCheck()}))},resetSOCheck:function(){var e=this;e.check.Cons.send=!1,e.check.Cons.done=!1,e.check.Cons.pass=!1,e.check.Cons.msg="",e.check.SO.send=!1,e.check.SO.done=!1,e.check.SO.pass=!1,e.check.SO.msg="",e.check.RMA.send=!1,e.check.RMA.done=!1,e.check.RMA.pass=!1,e.check.RMA.msg=""},showInvGlError:function(){var e=this,t="";e.check.INV.pass||(t+="Invoice Error : "+e.check.INV.msg+"<br>"),e.check.GL.pass||(t+="GL Error : "+e.check.GL.msg+"<br>"),swal({title:"Error",text:t,icon:"error",showConfirmButton:!0,showCancelButton:!1,closeOnClickOutside:!1,closeOnEsc:!1}).then((function(t){e.resetInvGlCheck()}))},resetInvGlCheck:function(){var e=this;e.check.INV.send=!1,e.check.INV.done=!1,e.check.INV.pass=!1,e.check.INV.msg="",e.check.GL.send=!1,e.check.GL.done=!1,e.check.GL.pass=!1,e.check.GL.msg=""}}};const o=(0,s(51900).Z)(n,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}]},[s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-3"}),e._v(" "),s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[e._m(0),e._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Select",disabled:e.disable_params},on:{focus:function(t){return e.getDateLists()},input:function(t){return e.getDocumentNoLists()}},model:{value:e.document_date,callback:function(t){e.document_date=t},expression:"document_date"}},e._l(e.dateLists,(function(e,t){return s("el-option",{key:t,attrs:{label:e,value:t}})})),1)],1)]),e._v(" "),s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[s("label",[e._v("เลขที่เอกสาร ")]),e._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",clearable:"",placeholder:"Select",disabled:e.disable_params},model:{value:e.document_no,callback:function(t){e.document_no=t},expression:"document_no"}},e._l(e.documentNoLists,(function(e,t){return s("el-option",{key:t,attrs:{label:e,value:t}})})),1)],1)]),e._v(" "),s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[s("label",[e._v("Group ID")]),e._v(" "),s("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:e.group_id,callback:function(t){e.group_id=t},expression:"group_id"}})],1)]),e._v(" "),s("div",{staticClass:"row mb-3"},[s("div",{staticClass:"col-md-12"},[s("label",[e._v("หมายเหตุ")]),e._v(" "),s("el-input",{staticClass:"w-100",attrs:{placeholder:"",disabled:!0},model:{value:e.interface_status,callback:function(t){e.interface_status=t},expression:"interface_status"}})],1)]),e._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 text-center"},[s("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:e.disable_report},on:{click:function(t){return e.callValidate("report")}}},[e._v(" ประมวลผล")]),e._v(" "),s("button",{staticClass:"btn btn-primary mt-2 mt-md-0",attrs:{type:"button",disabled:e.disable_interface},on:{click:function(t){return e.callValidate("interface")}}},[e._v(" Interface")])])])])])])}),[function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("label",[e._v("วันที่ "),s("span",{staticClass:"text-danger"},[e._v("*")])])}],!1,null,null,null).exports}}]);