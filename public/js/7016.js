(self.webpackChunk=self.webpackChunk||[]).push([[7016],{97016:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>p});const l={props:["pendingApprovalStatusValue","approvedApprovalStatusValue","rejectedApprovalStatusValue","selectAllValue"],data:function(){return{pendingApprovalStatusChecked:this.pendingApprovalStatusValue,approvedApprovalStatusChecked:this.approvedApprovalStatusValue,rejectedApprovalStatusChecked:this.rejectedApprovalStatusValue,selectAllChecked:this.selectAllValue}},methods:{onPendingApprovalStatusChanged:function(e){this.pendingApprovalStatusChecked=e,this.refreshSelectAllValue()},onApprovedApprovalStatusChanged:function(e){this.approvedApprovalStatusChecked=e,this.refreshSelectAllValue()},onRejectedApprovalStatusChanged:function(e){this.rejectedApprovalStatusChecked=e,this.refreshSelectAllValue()},refreshSelectAllValue:function(){1==this.pendingApprovalStatusChecked&&1==this.approvedApprovalStatusChecked&&1==this.rejectedApprovalStatusChecked?this.selectAllChecked=!0:this.selectAllChecked=!1},onSelectAllChanged:function(e){this.pendingApprovalStatusChecked=e,this.approvedApprovalStatusChecked=e,this.rejectedApprovalStatusChecked=e}}};const p=(0,a(51900).Z)(l,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"row"},[a("label",{staticClass:"col-sm-2 col-form-label required"},[e._v(" สถานะการอนุมัติ ")]),e._v(" "),a("div",{staticClass:"col-md-2 md:tw-pr-0 tw-pr-4"},[a("qm-el-checkbox",{attrs:{name:"pending_approval_status",id:"input_pending_approval_status",label:"รอการอนุมัติ","input-class":"tw-w-full tw-bg-yellow-200",value:e.pendingApprovalStatusChecked},on:{change:e.onPendingApprovalStatusChanged}})],1),e._v(" "),a("div",{staticClass:"col-md-2 md:tw-pr-0 tw-pr-4"},[a("qm-el-checkbox",{attrs:{name:"approved_approval_status",id:"input_approved_approval_status",label:"อนุมัติแล้ว","input-class":"tw-w-full tw-bg-green-300",value:e.approvedApprovalStatusChecked},on:{change:e.onApprovedApprovalStatusChanged}})],1),e._v(" "),a("div",{staticClass:"col-md-3 md:tw-pr-0 tw-pr-4"},[a("qm-el-checkbox",{attrs:{name:"rejected_approval_status",id:"input_rejected_approval_status",label:"ปฏิเสธผล","input-class":"tw-w-4/5 tw-bg-red-300",value:e.rejectedApprovalStatusChecked},on:{change:e.onRejectedApprovalStatusChanged}})],1),e._v(" "),a("div",{staticClass:"col-md-2 md:tw-pr-0 tw-pr-4"},[a("qm-el-checkbox",{attrs:{name:"select_all_approval_status",id:"input_select_all_approval_status",label:"เลือกสถานะทั้งหมด","input-class":"tw-w-full tw-bg-blue-200",value:e.selectAllChecked},on:{change:e.onSelectAllChanged}})],1)])}),[],!1,null,null,null).exports}}]);