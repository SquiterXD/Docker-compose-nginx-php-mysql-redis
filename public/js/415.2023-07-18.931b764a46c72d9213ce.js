(self.webpackChunk=self.webpackChunk||[]).push([[415],{80415:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>s});const a={props:["defaultIssueHeader"],data:function(){return{loading:!1}},created:function(){},methods:{cancel:function(){var e=this;confirm("ยืนยันการยกเลิกรายการเบิกจ่ายเครื่องเขียน ?")&&axios.patch("/inv/requisition_stationery/".concat(this.defaultIssueHeader.issue_header_id,"/cancel")).then((function(t){e.loading=!0,e.$notify({title:"Success",message:"Cancle Successfully",type:"success"}),window.location.replace("/inv/requisition_stationery/")})).catch((function(t){e.loading=!1;var n=e.$formatErrorMessage(error);alert(n)}))}}};const s=(0,n(51900).Z)(a,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"col-md-12 text-right mt-2 p-0"},[n("el-button",{staticClass:"btn-danger",attrs:{size:"small",type:"danger"},on:{click:e.cancel}},[e._v("Cancel\n        ")])],1)])}),[],!1,null,null,null).exports}}]);