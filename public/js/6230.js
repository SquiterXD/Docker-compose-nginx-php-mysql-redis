(self.webpackChunk=self.webpackChunk||[]).push([[6230],{80393:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>o});var a=s(23645),i=s.n(a)()((function(t){return t[1]}));i.push([t.id,".el-select[data-v-d5800056]{padding:0}.line-container[data-v-d5800056]{overflow:auto}.sticky-col[data-v-d5800056]{position:sticky;background-color:#fafafa}.first-col[data-v-d5800056]{width:100px;min-width:100px;max-width:100px;left:0}.second-col[data-v-d5800056]{width:150px;min-width:150px;max-width:150px;left:100px}",""]);const o=i},26230:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>d});var a=s(87757),i=s.n(a),o=s(30381),n=s.n(o);function l(t,e,s,a,i,o,n){try{var l=t[o](n),r=l.value}catch(t){return void s(t)}l.done?e(r):Promise.resolve(r).then(a,i)}function r(t){return function(){var e=this,s=arguments;return new Promise((function(a,i){var o=t.apply(e,s);function n(t){l(o,a,i,n,r,"next",t)}function r(t){l(o,a,i,n,r,"throw",t)}n(void 0)}))}}const c={props:["now","now_show","headers","url","transDate","department","orgId","organizationCode","productPeriod"],data:function(){return{showDistribID:"",dept:"",widthTable:0,ptmesHeaders:"",selValue:{batch_id:"",batch_no:"",product_type:"",item_code:"",item_desc:"",request_qty:"",uom:"",unit_of_measure:"",blend_no:"",start_date_original:"",product_qty:""},loading:{line:!1,loadDist:!1,searchModal:!1,wipStep:!1},ptmesLines:[],modalSearchResult:[],ptmesDistribution:[],firstData:[{productQty:""}],dateRef:"",wipDateRef:[],urlDateLink:"",wipStep:[],selWipStep:{wip_step:"",wip_step_desc:""},wip:"",startDate:"",endDate:"",trFlag:"",pIdx:"",wipDateRange:{start_date:"",end_date:""},wipStartDate:"",wipSelectStartDate:"",wipSelectEndDate:"",wipEndDate:"",distbChange:!1,disBatch:!1,disWip:!0,disWipStart:!0,disWipEnd:!0,disModal1:!0,disModal2:!0,disModal3:!0,disModal4:!0,isMG6:!1,price:0}},mounted:function(){this.initialMethod()},methods:{initialMethod:function(){var t=this,e=this.department,s=this.headers,a=this.organizationCode;Vue.set(t,"startDate",t.now.value),Vue.set(t,"endDate",t.now.value),t.wipSelectStartDate=t.now.show,t.wipSelectEndDate=t.now.show,console.log("initial methods"),console.log("Component confirm loss mounted.","initial data"),console.log("productPeriod",this.productPeriod),this.dept=e,this.ptmesHeaders=s,this.ptmesHeaders=[],this.isMG6="M05"==a,0==this.widthTable&&(this.widthTable=$("#item-lines").width()),console.log("init data",{dept:e,organizationCode:a})},goto:function(t){this.$refs[t];window.scrollTo(0,0)},configWidthTable:function(){$(".line-container").css("width",this.widthTable-50+"px")},addNewLine:function(){this.firstData.push({productQty:0}),this.ptmesLines.push({receive_wip:0,product_qty:0,loss_qty:0,example_qty:0,unit_of_measure:"ชิ้น",is_new:!0})},setDate:function(t,e){"startDate"==e?(this.startDate=n()(t).format("YYYY-MM-DD"),this.disWipEnd=!1,this.disModal1=!1):(this.endDate=n()(t).format("YYYY-MM-DD"),this.disWipStart=!0,this.disWipEnd=!0,this.disModal2=!1)},setProductDate:function(t,e,s){var a=n()(t).format("DD/MM/YYYY"),i=_.map(this.ptmesLines,(function(t){return{date:t.product_date_format}})),o=_.filter(i,(function(t){return t.date==a}));if(console.log(i,o,a),o.length>0)return setTimeout((function(){$("[name='product_date_format_"+s+"']").val("")}),500),this.$message({type:"warning",message:"กรุณาตรวจสอบวันที่ใหม่อีกครั้ง"}),!1;e.product_date_format=a},transWip:function(t){var e;return console.log(parseFloat(this.ptmesLines[t].receive_wip),parseFloat(this.ptmesLines[t].product_qty),parseFloat(this.ptmesLines[t].transfer_qty)),e=parseFloat(this.ptmesLines[t].receive_wip)+parseFloat(this.ptmesLines[t].product_qty)-parseFloat(this.ptmesLines[t].transfer_qty),this.ptmesLines[t].transfer_wip=e,parseFloat(t+1)<this.ptmesLines.length&&(this.ptmesLines[t+1].receive_wip=e),e},sumMfg:function(t){var e;return e=parseFloat(this.ptmesDistribution[t].result_qty_01)+parseFloat(this.ptmesDistribution[t].result_qty_02)+parseFloat(this.ptmesDistribution[t].result_qty_03)+parseFloat(this.ptmesDistribution[t].result_qty_04),this.ptmesDistribution[t].product_qty=e,this.distbChange=!0,e},dateTh:function(t){return n()(this.modalSearchResult[t].product_date).add(543,"years").format("DD/MM/YYYY")},onLoadHeaders:function(t){var e=this;e.endDate=n()(t).format("YYYY-MM-DD"),e.loading.searchModal=!0,axios.get(e.url.ajax_get_headers_by_date,{params:{startDate:e.startDate,endDate:e.endDate,departmentCode:e.dept.department_code}}).then((function(t){e.ptmesHeaders=t.data.data,e.loading.searchModal=!1,e.disModal2=!1})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},onLoadLines:function(){var t=this,e=this;Swal.fire({title:"กรุณารอสักครู่"}),console.log(e.ptmesDistribution.length),console.log(e.isMG6),Swal.showLoading(),console.log($.param({batch_id:e.selValue.batch_id,wip_step:e.selWipStep.wip_step,startDate:e.startDate,endDate:e.endDate})),e.firstData=[{productQty:""}],axios.get(e.url.ajax_get_lines+"?"+$.param({batch_id:e.selValue.batch_id,wip_step:e.selWipStep.wip_step,startDate:e.startDate,endDate:e.endDate})).then((function(s){var a=s.data;if(e.ptmesLines=a.data,e.ptmesLines.length)for(var i=0;i<e.ptmesLines.length;i++)e.firstData.push({productQty:e.ptmesLines[i].product_qty});if(a.nextWip.length)for(var o=function(t){var s,i,o,n,l=_.filter(a.nextWip,(function(s){var a;return s.product_date==(null===(a=e.ptmesLines[t])||void 0===a?void 0:a.product_date)})),r={product_date:null===(s=e.ptmesLines[t])||void 0===s?void 0:s.product_date,transfer_qty:null===(i=e.ptmesLines[t])||void 0===i?void 0:i.transfer_qty},c={product_date:null===(o=l[0])||void 0===o?void 0:o.product_date,transfer_qty:null===(n=l[0])||void 0===n?void 0:n.product_qty};console.log(r,c),void 0!==e.ptmesLines[t]&&("Y"==e.ptmesLines[t].attribute2&&void 0!==e.ptmesLines[t]?e.ptmesLines[t].transfer_qty=e.ptmesLines[t].transfer_qty:e.ptmesLines[t].transfer_qty=l[0].product_qty)},n=0;n<a.nextWip.length;n++)o(n);e.goto("div2"),Swal.close(),t.scrollToLines()})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message+" ["+t.lineNumber+"]"})}))},newGoto:function(t){console.log("new goto id=",t),$("html, body").animate({scrollTop:$(t).offset().top},500)},scrollToLines:function(){$("html, body").animate({scrollTop:$("#item-lines").offset().top},500)},onLoadModalResult:function(){var t=this;t.modalSearchResult=[],t.loading.searchModal=!0,t.onLoadLines(),axios.get(t.url.ajax_get_search,{params:{batch_id:t.selValue.batch_id,wip_step:t.selWipStep.wip_step,startDate:t.startDate,endDate:t.endDate}}).then((function(e){var s=e.data;t.modalSearchResult=s.data,t.loading.searchModal=!1})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},updateattribute2:function(){var t=this,e=0,s=0;if(t.firstData.length){console.log("Updating attribute2...");for(var a=0;a<t.ptmesLines.length;a++)e=parseFloat(t.firstData[a+1].productQty),s=parseFloat(t.ptmesLines[a].product_qty),console.log("Org"+e),console.log("Nor"+s),e!=s&&(t.ptmesLines[a].attribute2="Y",console.log("product_qty changed..."+t.ptmesLines[a].attribute2))}console.log("Updating finished ...")},onClearForm:function(){Object.assign(this.$data,{showDistribID:"",dept:"",widthTable:0,ptmesHeaders:"",selValue:{batch_id:"",batch_no:"",product_type:"",item_code:"",item_desc:"",request_qty:"",uom:"",unit_of_measure:"",blend_no:"",start_date_original:"",product_qty:""},loading:{line:!1,loadDist:!1,searchModal:!1,wipStep:!1},ptmesLines:[],modalSearchResult:[],ptmesDistribution:[],firstData:[{productQty:""}],dateRef:"",wipDateRef:[],urlDateLink:"",wipStep:[],selWipStep:{wip_step:"",wip_step_desc:""},wip:"",startDate:"",endDate:"",trFlag:"",pIdx:"",wipDateRange:{start_date:"",end_date:""},wipStartDate:"",wipSelectStartDate:"",wipSelectEndDate:"",wipEndDate:"",distbChange:!1,disBatch:!1,disWip:!0,disWipStart:!0,disWipEnd:!0,disModal1:!0,disModal2:!0,disModal3:!0,disModal4:!0,isMG6:!1,price:0}),this.initialMethod()},onSelWipStep:function(){},onLoadDistribution:function(t,e,s,a){var o=this;return r(i().mark((function l(){var c;return i().wrap((function(l){for(;;)switch(l.prev=l.next){case 0:if((c=o).showDistribID==t?c.showDistribID="":c.showDistribID=t,console.log("showDistributeID : ",c.showDistribID),console.log(t,e,s,a),c.goto("div3"),c.dateRef=n()(e).add(543,"years").format("DD/MM/YYYY"),!c.distbChange){l.next=10;break}Swal.fire({title:"ข้อมูลมีการเปลี่ยนแปลงและยังไม่ได้บันทึก",text:"คุณต้องการดำเนินการต่อหรือไม่",icon:"คำเตือน",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"ดำเนินการต่อ",cancelButtonText:"ยกเลิก"}).then(function(){var e=r(i().mark((function e(o){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!o.isConfirmed){e.next=11;break}return Swal.fire({title:"กรุณารอสักครู่"}),Swal.showLoading(),c.ptmesDistribution=[],c.trFlag=s,c.pIdx=a,e.next=8,axios.get(c.url.ajax_get_distributions,{params:{wip_step:c.selWipStep.wip_step,batch_id:c.selValue.batch_id,product_line_id:t}}).then((function(t){c.ptmesDistribution=t.data.data})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}));case 8:c.distbChange=!1,Swal.close(),c.goto("div3");case 11:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()),l.next=21;break;case 10:return Swal.fire({title:"กรุณารอสักครู่"}),Swal.showLoading(),c.ptmesDistribution=[],c.trFlag=s,c.pIdx=a,l.next=17,axios.get(c.url.ajax_get_distributions,{params:{wip_step:c.selWipStep.wip_step,batch_id:c.selValue.batch_id,product_line_id:t}}).then((function(t){c.ptmesDistribution=t.data.data,console.log(c.ptmesDistribution)})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}));case 17:c.distbChange=!1,Swal.close(),c.goto("div3"),c.newGoto("#distribution-"+a);case 21:o.configWidthTable();case 22:case"end":return l.stop()}}),l)})))()},onLoadWipStep:function(t){console.log(t);var e=this;Swal.fire({title:"กรุณารอสักครู่"}),Swal.showLoading();e.disWip=!1,e.wipStep=[],e.ptmesDistribution=[],e.ptmesLines=[],Swal.close();var s=e.ptmesHeaders.findIndex((function(t){return t.batch_id==e.selValue.batch_id}));console.log(e.selValue);var a=e.ptmesHeaders[s];e.selValue.item_code=a.segment1,e.selValue.item_desc=a.description,axios.get(e.url.ajax_get_wipstep,{params:{inventory_item_id:a.inventory_item_id}}).then((function(t){e.wipStep=t.data,t.data.currentDate,Swal.close()})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},onLoadWipStepM:function(){var t,e=this;e.loading.searchModal=!0,e.wipStep=[],e.ptmesDistribution=[],e.ptmesLines=[];var s=e.ptmesHeaders.findIndex((function(t){return t.batch_id==e.selValue.batch_id}));e.selValue=e.ptmesHeaders[s],t=n()(e.selValue.start_date_original).format("YYYY-MM-DD"),axios.get(e.url.ajax_get_wipstep,{params:{batch_id:e.selValue.batch_id,date:t}}).then((function(t){e.wipStep=t.data.wip,e.wipDateRange=t.data.dateRange,e.wipStartDate=n()(e.wipDateRange.start_date).add(543,"years").format("DD/MM/YYYY"),e.wipEndDate=n()(e.wipDateRange.end_date).add(543,"years").format("DD/MM/YYYY"),e.loading.searchModal=!1,e.disModal3=!1})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},fetchLov:function(){var t=this;""!=this.startDate&&""!=this.endDate&&axios.post(this.url.ajax_fetch_lov,{startDate:this.startDate,endDate:this.endDate}).then((function(e){console.log(e.data),t.ptmesHeaders=e.data}))},onClickSave:function(){var t=this;Swal.fire({title:"คุณต้องการบันทึกข้อมูล, ใช่หรือไม่?",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"บันทึก",cancelButtonText:"ยกเลิก"}).then((function(e){if(e.isConfirmed){Swal.fire({title:"กำลังบันทึกข้อมูล"}),Swal.showLoading();var s=0,a=0;if(t.loading.wipStep=!0,t.loading.line=!0,t.loading.loadDist=!0,t.firstData.length)for(var i=0;i<t.ptmesLines.length;i++){try{s=parseFloat(t.firstData[i+1].productQty),a=parseFloat(t.ptmesLines[i].product_qty)}catch(e){console.log(t.ptmesLines[i],{error:e}),t.loading.wipStep=!1,t.loading.line=!1,t.loading.loadDist=!1}s!=a?t.ptmesLines[i].attribute2="Y":"Y"!=t.ptmesLines[i].attribute2&&(t.ptmesLines[i].attribute2=null)}var o={distributions:t.ptmesDistribution,lines:t.ptmesLines,wip:t.selWipStep,val:t.selValue,orgId:t.orgId,organizationCode:t.organizationCode};axios.patch(t.url.ajax_update_orders,o).then((function(e){200==e.status&&(t.distbChange=!1,t.loading.wipStep=!1,t.loading.line=!1,t.loading.loadDist=!1,Swal.close(),Swal.fire({icon:"success",title:"Ok...",text:"บันทึกข้อมูลสำเร็จ"}))})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"บันทึกข้อมูลไม่สำเร็จ!",footer:t.message})}))}}))},onCancel:function(){Swal.fire({title:"Are you sure?",text:"You will not be able to recover this imaginary file!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"No, keep it"}).then((function(t){t.isConfirmed?Swal.fire("Deleted!","Your imaginary file has been deleted.","success"):t.dismiss===Swal.DismissReason.cancel&&Swal.fire("Cancelled","Your imaginary file is safe :)","error")}))}},computed:{totalMfg:function(){var t=0,e=this;if(e.ptmesDistribution.length){for(var s=0;s<e.ptmesDistribution.length;s++)t+=e.ptmesDistribution[s].product_qty;e.ptmesLines[e.pIdx].product_qty=t}return t},totalSample:function(){var t=0,e=this;if(e.ptmesDistribution.length){for(var s=0;s<e.ptmesDistribution.length;s++)t+=parseFloat(e.ptmesDistribution[s].sample_qty);e.ptmesLines[e.pIdx].example_qty=t}return t},totalLoss:function(){var t=0,e=this;if(e.ptmesDistribution.length){for(var s=0;s<e.ptmesDistribution.length;s++)t+=parseFloat(e.ptmesDistribution[s].result_loss_qty);e.ptmesLines[e.pIdx].loss_qty=t}return t},distDate:function(t){return helperDate.parseToDateTh(t,"DD/MM/YYYY")}},watch:{price:function(t){var e=this,s=t.replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,",");Vue.nextTick((function(){return e.price=s}))},endDate:{handler:function(t){this.fetchLov()},deep:!0},startDate:{handler:function(t){this.fetchLov()},deep:!0}}};s(74550);const d=(0,s(51900).Z)(c,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-12"},[s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.wipStep,expression:"loading.wipStep"}],ref:"div1",staticClass:"ibox"},[s("div",{staticClass:"ibox-title",staticStyle:{"padding-right":"20px"}},[s("div",{staticClass:"row"},[t._m(0),t._v(" "),s("div",{staticClass:"col-lg-4",staticStyle:{"text-align":"right"}},[s("button",{staticClass:"btn btn-default",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onClearForm(e)}}},[s("i",{staticClass:"fa fa-refresh"}),t._v("\n              ล้างค่า\n            ")]),t._v(" "),t._m(1),t._v(" "),s("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onClickSave(e)}}},[s("i",{staticClass:"fa fa-save"}),t._v("\n              บันทึก\n            ")])])])]),t._v(" "),s("div",{staticClass:"ibox-content"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6 col-sm-12"},[t._e(),t._v(" "),s("div",{staticClass:"form-group row"},[t._m(3),t._v(" "),s("div",{staticClass:"col-md-9"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6"},[s("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"startDate",id:"startDate",disabled:!1,placeholder:"โปรดเลือกวันที่เริ่มต้น",value:t.wipSelectStartDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var s=arguments.length,a=Array(s);s--;)a[s]=arguments[s];return t.setDate.apply(void 0,a.concat(["startDate"]))}}})],1),t._v(" "),s("div",{staticClass:"col-lg-6"},[s("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"endDate",id:"endDate",disabled:!1,placeholder:"โปรดเลือกวันที่สิ้นสุด",value:t.wipSelectEndDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var s=arguments.length,a=Array(s);s--;)a[s]=arguments[s];return t.setDate.apply(void 0,a.concat(["endDate"]))}}})],1)])])]),t._v(" "),s("div",{staticClass:"form-group row"},[t._m(4),t._v(" "),s("div",{staticClass:"col-lg-9"},[s("el-select",{staticClass:"col-lg-12",attrs:{filterable:"",remote:"",placeholder:"ระบุเลขที่คำสั่งผลิต",disabled:!(""!=t.startDate&&""!=t.endDate)},on:{change:t.onLoadWipStep},model:{value:t.selValue.batch_id,callback:function(e){t.$set(t.selValue,"batch_id",e)},expression:"selValue.batch_id"}},t._l(t.ptmesHeaders,(function(t){return s("el-option",{key:t.batch_id,attrs:{label:t.batch_no+", "+t.description,value:t.batch_id}})})),1)],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("สินค้าที่จะผลิต:")]),t._v(" "),s("div",{staticClass:"col-lg-9"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-12"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.selValue.item_code,expression:"selValue.item_code"}],staticClass:"form-control",attrs:{type:"text",disabled:""},domProps:{value:t.selValue.item_code},on:{input:function(e){e.target.composing||t.$set(t.selValue,"item_code",e.target.value)}}})])])])])]),t._v(" "),s("div",{staticClass:"col-lg-6 col-sm-12"},[t._m(5),t._v(" "),s("div",{staticClass:"form-group row"},[t._m(6),t._v(" "),s("div",{staticClass:"col-lg-9"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6"},[s("el-select",{attrs:{filterable:"",remote:"",placeholder:"ระบุขั้นตอนการทำงาน",disabled:1==t.disWip},on:{change:t.onSelWipStep},model:{value:t.selWipStep.wip_step,callback:function(e){t.$set(t.selWipStep,"wip_step",e)},expression:"selWipStep.wip_step"}},t._l(t.wipStep,(function(t){return s("el-option",{key:t.oprn_class_desc,attrs:{label:t.oprn_class_desc+" "+t.oprn_desc,value:t.oprn_class_desc}})})),1)],1),t._v(" "),s("div",{staticClass:"col-lg-6"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.selWipStep.wip_step_desc,expression:"selWipStep.wip_step_desc"}],staticClass:"form-control",attrs:{type:"text",disabled:""},domProps:{value:t.selWipStep.wip_step_desc},on:{input:function(e){e.target.composing||t.$set(t.selWipStep,"wip_step_desc",e.target.value)}}})])])])]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("รายละเอียดสินค้าที่จะผลิต:")]),t._v(" "),s("div",{staticClass:"col-lg-9"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-12"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.selValue.item_desc,expression:"selValue.item_desc"}],staticClass:"form-control pt-2",attrs:{disabled:""},domProps:{value:t.selValue.item_desc},on:{input:function(e){e.target.composing||t.$set(t.selValue,"item_desc",e.target.value)}}})])])])]),t._v(" "),t._e(),t._v(" "),s("div",{staticClass:"form-group row"},[s("div",{staticClass:"col-lg-12"},[s("button",{staticClass:"btn btn-default",staticStyle:{float:"right"},attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onLoadLines(e)}}},[t._v("\n                  แสดงข้อมูล\n                ")])])])])])])]),t._v(" "),s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.line,expression:"loading.line"}],ref:"div2",staticClass:"ibox"},[s("div",{staticClass:"ibox-title"},[s("h3",[t._v("บันทึกผลผลิตรายวัน")]),t._v(" "),s("button",{staticClass:"pull-right btn btn-primary",attrs:{type:"button"},on:{click:function(e){return t.addNewLine()}}},[t._v("เพิ่มรายการ")])]),t._v(" "),s("div",{staticClass:"ibox-content"},[s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table table-bordered",attrs:{id:"item-lines"}},[s("thead",[s("tr",[s("th",[t._v("วันที่ได้ผลผลิต")]),t._v(" "),s("th",[t._v("คงคลังเช้า")]),t._v(" "),s("th",[t._v("ผลผลิตที่ได้")]),t._v(" "),s("th",[t._v("สูญเสีย")]),t._v(" "),t._m(7),t._v(" "),s("th",[t._v("คงคลังเย็น")]),t._v(" "),t.isMG6?t._e():s("th",[t._v("บุหรี่ต้วอย่าง")]),t._v(" "),s("th",[t._v("หน่วยนับ")]),t._v(" "),s("th",[t._v("สถานะการบันทึกผล")]),t._v(" "),s("th",[t._v("ตัดใช้วัตถุดิบ")]),t._v(" "),s("th",[t._v("บันทึกเข้าคลัง")]),t._v(" "),s("th",[t._v("รายละเอียด")])])]),t._v(" "),t.ptmesLines.length?s("tbody",[t._l(t.ptmesLines,(function(e,a){return[s("tr",[s("td",{staticClass:"g"},[!0===e.is_new?[s("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"product_date_format_"+a,disabled:!1,placeholder:"",value:e.product_date_format,format:t.transDate["js-format"]},on:{dateWasSelected:function(s){for(var i=arguments.length,o=Array(i);i--;)o[i]=arguments[i];return t.setProductDate.apply(void 0,o.concat([e],[a]))}}})]:[t._v("\n                    "+t._s(e.product_date_format)+"\n                   ")]],2),t._v(" "),s("td",{staticClass:"g text-right"},[t._v("\n                    "+t._s(parseFloat(e.receive_wip).toLocaleString())+"\n                  ")]),t._v(" "),s("td",{staticClass:"g text-right"},[t._v("\n                    "+t._s(parseFloat(e.product_qty).toLocaleString())+"\n                  ")]),t._v(" "),s("td",{staticClass:"g text-right"},[t._v("\n                    "+t._s(parseFloat(e.loss_qty).toLocaleString())+"\n                  ")]),t._v(" "),s("td",[s("vue-numeric",{staticClass:"form-control",staticStyle:{"text-align":"right"},attrs:{precision:2,separator:","},model:{value:e.transfer_qty,callback:function(s){t.$set(e,"transfer_qty",s)},expression:"item.transfer_qty"}})],1),t._v(" "),s("td",{staticClass:"g text-right"},[t._v(t._s(t.transWip(a).toLocaleString()))]),t._v(" "),t.isMG6?t._e():s("td",{staticClass:"g text-right"},[t._v("\n                    "+t._s(parseFloat(e.example_qty).toLocaleString())+"\n                  ")]),t._v(" "),s("td",{staticClass:"g"},[t._v(t._s(e.unit_of_measure))]),t._v(" "),s("td",{staticClass:"g"},["Y"==e.attribute2?s("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:""}},[t._v("\n                      ยืนยันยอดผลผลิตแล้ว\n                    ")]):s("button",{staticClass:"btn btn-danger",attrs:{type:"button",disabled:""}},[t._v("\n                      ยังไม่ยืนยันยอดผลผลิต\n                    ")])]),t._v(" "),s("td",{staticClass:"g",staticStyle:{"text-align":"center"}},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.transaction_flag,expression:"item.transaction_flag"}],attrs:{type:"checkbox",disabled:""},domProps:{checked:Array.isArray(e.transaction_flag)?t._i(e.transaction_flag,null)>-1:e.transaction_flag},on:{change:function(s){var a=e.transaction_flag,i=s.target,o=!!i.checked;if(Array.isArray(a)){var n=t._i(a,null);i.checked?n<0&&t.$set(e,"transaction_flag",a.concat([null])):n>-1&&t.$set(e,"transaction_flag",a.slice(0,n).concat(a.slice(n+1)))}else t.$set(e,"transaction_flag",o)}}})]),t._v(" "),s("td",{staticClass:"g",staticStyle:{"text-align":"center"}},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.attribute3,expression:"item.attribute3"}],attrs:{type:"checkbox",disabled:""},domProps:{checked:Array.isArray(e.attribute3)?t._i(e.attribute3,null)>-1:e.attribute3},on:{change:function(s){var a=e.attribute3,i=s.target,o=!!i.checked;if(Array.isArray(a)){var n=t._i(a,null);i.checked?n<0&&t.$set(e,"attribute3",a.concat([null])):n>-1&&t.$set(e,"attribute3",a.slice(0,n).concat(a.slice(n+1)))}else t.$set(e,"attribute3",o)}}})]),t._v(" "),s("td",{staticClass:"g"},[s("a",{staticClass:"btn btn-default",on:{click:function(s){return s.preventDefault(),t.onLoadDistribution(e.product_line_id,e.product_date_original,e.transaction_flag,a)}}},[t._v("รายละเอียด")])])]),t._v(" "),t.showDistribID==e.product_line_id?s("tr",[s("td",{attrs:{colspan:"13"}},[s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.loadDist,expression:"loading.loadDist"}],ref:"div3",refInFor:!0,staticClass:"ibox",attrs:{id:"distribution-"+a}},[s("div",{staticClass:"ibox-title"},[s("h3",{ref:"distributeFocus",refInFor:!0},[t._v("\n                          บันทึกผลผลิตรายวันรายเครื่อง "+t._s(t.dateRef)+"\n                        ")])]),t._v(" "),s("div",{staticClass:"ibox-content line-container"},[s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table"},[s("thead",[s("tr",{attrs:{align:"center"}},[s("th",{staticClass:"sticky-col first-col",attrs:{rowspan:"2"}},[t._v("\n                                  ชุดเครื่องจักร\n                                ")]),t._v(" "),s("th",{staticClass:"sticky-col second-col",attrs:{rowspan:"2"}},[t._v("\n                                  หมายเลขเครื่องจักร\n                                ")]),t._v(" "),t._l(t.productPeriod,(function(e,a){return s("th",{key:a,attrs:{colspan:"2"}},[t._v("\n                                  "+t._s(e.description)+"\n                                ")])})),t._v(" "),s("th",{staticStyle:{"min-width":"150px"},attrs:{rowspan:"2"}},[t._v("ยอดสูญเสีย")]),t._v(" "),t._m(8,!0),t._v(" "),s("th",{staticStyle:{"min-width":"150px"},attrs:{rowspan:"2"}},[t._v("\n                                  ยอดผลิตรวมทั้งวัน\n                                ")]),t._v(" "),t.isMG6?t._e():s("th",{staticStyle:{"min-width":"80px"},attrs:{rowspan:"2"}},[t._v("\n                                  จำนวนบุหรี่ตัวอย่าง\n                                ")]),t._v(" "),s("th",{staticStyle:{"min-width":"50px"},attrs:{rowspan:"2"}},[t._v("หน่วยนับ")])],2),t._v(" "),s("tr",{attrs:{align:"center"}},[t._l(t.productPeriod,(function(e){return[s("th",{staticStyle:{"min-width":"150px"}},[t._v("ผลผลิตที่ได้")]),t._v(" "),s("th",{staticStyle:{"min-width":"150px"}},[t._v("\n                                    ยืนยันยอดผลผลิต"),s("span",{staticStyle:{color:"red"}},[t._v("*")])])]}))],2)]),t._v(" "),t.ptmesDistribution.length?s("tbody",t._l(t.ptmesDistribution,(function(e,a){return s("tr",{key:a,class:{disable:"Y"==t.trFlag}},[s("td",{staticClass:"g sticky-col first-col"},[t._v("\n                                  "+t._s(e.machine_set)+"\n                                ")]),t._v(" "),s("td",{staticClass:"g sticky-col second-col"},[t._v("\n                                  "+t._s(e.machine_number)+"\n                                ")]),t._v(" "),t._l(t.productPeriod,(function(a){return[s("td",{staticClass:"g text-right",attrs:{"data-period":"qty_0"+a.seq}},[t._v("\n                                    "+t._s(parseFloat(null!=e["qty_0"+a.seq]?e["qty_0"+a.seq]:"0").toLocaleString())+"\n                                  ")]),t._v(" "),s("td",{staticClass:"text-right",attrs:{"data-period":"result_qty"+a.seq}},[s("vue-numeric",{staticClass:"form-control text-right",attrs:{precision:2,separator:",",disabled:"Y"==t.trFlag},model:{value:e["result_qty_0"+a.seq],callback:function(s){t.$set(e,"result_qty_0"+a.seq,s)},expression:"\n                                        distribution['result_qty_0' + period.seq]\n                                      "}})],1)]})),t._v(" "),s("td",{staticClass:"g text-right"},[t._v("\n                                  "+t._s(parseFloat(e.loss_qty).toLocaleString())+"\n                                ")]),t._v(" "),s("td",[s("vue-numeric",{staticClass:"form-control  text-right",attrs:{precision:2,separator:",",disabled:"Y"==t.trFlag},model:{value:e.result_loss_qty,callback:function(s){t.$set(e,"result_loss_qty",s)},expression:"distribution.result_loss_qty"}})],1),t._v(" "),s("td",{staticClass:"g text-right"},[t._v("\n                                  "+t._s(t.sumMfg(a).toLocaleString())+"\n                                ")]),t._v(" "),t.isMG6?t._e():s("td",[s("vue-numeric",{staticClass:"form-control  text-right",attrs:{precision:2,separator:",",disabled:"Y"==t.trFlag},model:{value:e.sample_qty,callback:function(s){t.$set(e,"sample_qty",s)},expression:"distribution.sample_qty"}})],1),t._v(" "),s("td",{staticClass:"g"},[t._v(t._s(e.unit_of_measure))])],2)})),0):s("tbody",[t._m(9,!0)]),t._v(" "),s("tfoot",[s("tr",[s("td",{staticClass:"g text-right",attrs:{colspan:"11"}},[t._v("\n                                  ยอดรวมทุกเครื่อง\n                                ")]),t._v(" "),s("td",{staticClass:"g  text-right"},[t._v(t._s(t.totalLoss.toLocaleString()))]),t._v(" "),s("td",{staticClass:"g  text-right"},[t._v(t._s(t.totalMfg.toLocaleString()))]),t._v(" "),s("td",{staticClass:"g  text-right"},[t._v(t._s(t.totalSample.toLocaleString()))]),t._v(" "),s("td")])])])])])])])]):t._e()]}))],2):s("tbody",[t._m(10)])])])])])]),t._v(" "),s("div",{staticClass:"modal inmodal fade",staticStyle:{display:"none"},attrs:{id:"modalLines",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog modal-xl"},[s("div",{staticClass:"modal-content"},[t._m(11),t._v(" "),s("div",{staticClass:"modal-body"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-2"},[s("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"startDate",id:"startDateM","popper-append-to-body":!1,placeholder:"วันที่เริ่มผลิต",value:t.wipStartDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var s=arguments.length,a=Array(s);s--;)a[s]=arguments[s];return t.setDate.apply(void 0,a.concat(["startDate"]))}}})],1),t._v(" "),s("div",{staticClass:"col-md-2"},[s("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"endDate",id:"endDateM",disabled:t.disModal1,"popper-append-to-body":!1,placeholder:"ถึงวันที่",value:t.wipEndDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){return t.onLoadHeaders.apply(void 0,arguments)}}})],1),t._v(" "),s("div",{staticClass:"col-md-3"},[s("el-select",{staticClass:"col-lg-12",attrs:{filterable:"",remote:"",placeholder:"เลขที่คำสั่งการผลิค","popper-append-to-body":!1,disabled:t.disModal2},on:{change:t.onLoadWipStepM},model:{value:t.selValue.batch_id,callback:function(e){t.$set(t.selValue,"batch_id",e)},expression:"selValue.batch_id"}},t._l(t.ptmesHeaders,(function(t){return s("el-option",{key:t.batch_id,attrs:{label:t.description,value:t.batch_id}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-3"},[s("el-select",{attrs:{filterable:"",remote:"",placeholder:"ขั้นตอนการผลิต","popper-append-to-body":!1,disabled:t.disModal3},on:{change:t.onSelWipStep},model:{value:t.selWipStep.wip_step,callback:function(e){t.$set(t.selWipStep,"wip_step",e)},expression:"selWipStep.wip_step"}},t._l(t.wipStep,(function(t){return s("el-option",{key:t.wip_step,attrs:{label:t.wip_step+" "+t.wip_step_desc,value:t.wip_step}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-2"},[s("button",{staticClass:"btn btn-default pt-1 form-control",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onLoadModalResult(e)}}},[s("i",{staticClass:"fa fa-search"}),t._v("\n                ค้นหา\n              ")])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-12 pt-4"},[s("table",{staticClass:"table table-bordered"},[t._m(12),t._v(" "),t.modalSearchResult.length?s("tbody",t._l(t.modalSearchResult,(function(e,a){return s("tr",{key:a,class:{disable:e.transaction_flag},staticStyle:{"text-align":"center"}},[s("td",{staticClass:"g"},["Y"==e.attribute2?s("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:""}},[t._v("\n                        ยืนยันยอดผลผลิตแล้ว\n                      ")]):s("button",{staticClass:"btn btn-danger",attrs:{type:"button",disabled:""}},[t._v("\n                        ยังไม่ยืนยันยอดผลผลิต\n                      ")])]),t._v(" "),s("td",{staticClass:"g"},[t._v(t._s(e.batch_no))]),t._v(" "),s("td",{staticClass:"g"},[t._v(t._s(e.item_code)+" | "+t._s(e.item_desc))]),t._v(" "),s("td",{staticClass:"g"},[t._v(t._s(e.wip_step))]),t._v(" "),s("td",{staticClass:"g"},[t._v("\n                      "+t._s(t.dateTh(a))+"\n                    ")]),t._v(" "),s("td",{staticClass:"g"},[s("a",{staticClass:"btn btn-warning",attrs:{"data-toggle":"modal","data-target":"#modalLines"},on:{click:function(s){return s.preventDefault(),t.onLoadDistribution(e.product_line_id,e.product_date,e.transaction_flag,a)}}},[s("i",{staticClass:"fa fa-edit"}),t._v("\n                        แก้ไข\n                      ")])])])})),0):s("tbody",[s("tr",[s("td",{staticStyle:{"text-align":"center"},attrs:{colspan:"6"}},[t.loading.searchModal?s("div",[t._m(13)]):s("div",[t._v("ไม่มีข้อมูล")])])])])])])])])])])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-lg-8"},[s("h3",[t._v("บันทึกผลผลิตประจำวัน")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("button",{staticClass:"btn btn-default",attrs:{type:"button","data-toggle":"modal","data-target":"#modalLines"}},[s("i",{staticClass:"fa fa-search"}),t._v("\n              ค้นหา\n            ")])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("\n                หน่วยงาน :"),s("span",{staticStyle:{color:"white"}},[t._v("test exite more")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("วันที่เริ่ม "),s("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":")])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("\n                เลขที่คำสั่งผลิต"),s("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":\n              ")])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-lg-2 col-sm-4 col-form-label"},[s("span",{staticStyle:{color:"red"}})]),t._v(" "),s("div",{staticClass:"col-lg-10"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-6"}),t._v(" "),s("div",{staticClass:"col-lg-6"})])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("ขั้นตอนการทำงาน"),s("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":")])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("th",[t._v("จ่ายออก"),s("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("th",{staticStyle:{"min-width":"150px"},attrs:{rowspan:"2"}},[t._v("\n                                  ยืนยันยอดสูญเสีย"),s("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{staticStyle:{"text-align":"center"},attrs:{colspan:"15"}},[t._v("\n                                  ไม่มีข้อมูล\n                                ")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{staticStyle:{"text-align":"center"},attrs:{colspan:"13"}},[t._v("ไม่มีข้อมูล")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal-header"},[s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[s("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),s("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),s("h5",{staticClass:"modal-title m-0 p-0"},[t._v("บันทึกผลผลิตประจำวัน")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",{staticStyle:{"text-align":"center"}},[s("th",[t._v("สถานะ")]),t._v(" "),s("th",[t._v("เลขที่คำสั่งผลิต")]),t._v(" "),s("th",[t._v("สินค้าที่ผลิต")]),t._v(" "),s("th",[t._v("ขั้นตอนการทำงาน")]),t._v(" "),s("th",[t._v("วันที่ได้ผลผลิต")]),t._v(" "),s("th",[t._v("การจัดการ")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"sk-spinner sk-spinner-wave mb-4"},[s("div",{staticClass:"sk-rect1"}),t._v(" "),s("div",{staticClass:"sk-rect2"}),t._v(" "),s("div",{staticClass:"sk-rect3"}),t._v(" "),s("div",{staticClass:"sk-rect4"}),t._v(" "),s("div",{staticClass:"sk-rect5"})])}],!1,null,"d5800056",null).exports},74550:(t,e,s)=>{var a=s(80393);a.__esModule&&(a=a.default),"string"==typeof a&&(a=[[t.id,a,""]]),a.locals&&(t.exports=a.locals);(0,s(45346).Z)("0725e0dc",a,!0,{})}}]);