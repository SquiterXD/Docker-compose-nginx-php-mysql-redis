(self.webpackChunk=self.webpackChunk||[]).push([[8626],{91767:(t,e,a)=>{"use strict";a.d(e,{Z:()=>o});var s=a(23645),i=a.n(s)()((function(t){return t[1]}));i.push([t.id,".el-select[data-v-6352391f]{padding:0}.line-container[data-v-6352391f]{overflow:auto}.sticky-col[data-v-6352391f]{position:-webkit-sticky;position:sticky;background-color:#fafafa}.first-col[data-v-6352391f]{width:100px;min-width:100px;max-width:100px;left:0}.second-col[data-v-6352391f]{width:150px;min-width:150px;max-width:150px;left:100px}",""]);const o=i},38626:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>v});var s=a(87757),i=a.n(s),o=a(30381),l=a.n(o);function n(t,e,a,s,i,o,l){try{var n=t[o](l),r=n.value}catch(t){return void a(t)}n.done?e(r):Promise.resolve(r).then(s,i)}function r(t){return function(){var e=this,a=arguments;return new Promise((function(s,i){var o=t.apply(e,a);function l(t){n(o,s,i,l,r,"next",t)}function r(t){n(o,s,i,l,r,"throw",t)}l(void 0)}))}}const c={props:["headers","url","transDate","department","orgId","organizationCode","productPeriod"],data:function(){return{showDistribID:"",dept:"",widthTable:0,ptmesHeaders:"",selValue:{batch_id:"",batch_no:"",product_type:"",item_code:"",item_desc:"",request_qty:"",uom:"",unit_of_measure:"",blend_no:"",start_date_original:"",product_qty:""},loading:{line:!1,loadDist:!1,searchModal:!1,wipStep:!1},ptmesLines:[],modalSearchResult:[],ptmesDistribution:[],firstData:[{productQty:""}],dateRef:"",wipDateRef:[],urlDateLink:"",wipStep:[],selWipStep:{wip_step:"",wip_step_desc:""},wip:"",startDate:"",endDate:"",trFlag:"",pIdx:"",wipDateRange:{start_date:"",end_date:""},wipStartDate:"",wipSelectStartDate:"",wipSelectEndDate:"",wipEndDate:"",distbChange:!1,disBatch:!1,disWip:!0,disWipStart:!0,disWipEnd:!0,disModal1:!0,disModal2:!0,disModal3:!0,disModal4:!0,isMG6:!1,price:0}},mounted:function(){this.initialMethod()},methods:{initialMethod:function(){var t=this.department,e=this.headers,a=this.organizationCode;console.log("initial methods"),console.log("Component confirm loss mounted.","initial data"),console.log("productPeriod",this.productPeriod),this.dept=t,this.ptmesHeaders=e,this.isMG6="M05"==a,0==this.widthTable&&(this.widthTable=$("#item-lines").width()),console.log("init data",{dept:t,ptmesHeaders:e,organizationCode:a})},goto:function(t){this.$refs[t];window.scrollTo(0,0)},configWidthTable:function(){$(".line-container").css("width",this.widthTable-50+"px")},setDate:function(t,e){"startDate"==e?(this.startDate=l()(t).format("YYYY-MM-DD"),this.disWipEnd=!1,this.disModal1=!1):(this.endDate=l()(t).format("YYYY-MM-DD"),this.disWipStart=!0,this.disWipEnd=!0,this.disModal2=!1)},transWip:function(t){var e;return e=parseFloat(this.ptmesLines[t].receive_wip)+parseFloat(this.ptmesLines[t].product_qty)-parseFloat(this.ptmesLines[t].transfer_qty)-parseFloat(this.ptmesLines[t].example_qty),this.ptmesLines[t].transfer_wip=e,parseFloat(t+1)<this.ptmesLines.length&&(this.ptmesLines[t+1].receive_wip=e),e},sumMfg:function(t){var e;return e=parseFloat(this.ptmesDistribution[t].result_qty_01)+parseFloat(this.ptmesDistribution[t].result_qty_02)+parseFloat(this.ptmesDistribution[t].result_qty_03)+parseFloat(this.ptmesDistribution[t].result_qty_04),this.ptmesDistribution[t].product_qty=e,this.distbChange=!0,e},dateTh:function(t){return l()(this.modalSearchResult[t].product_date).add(543,"years").format("DD/MM/YYYY")},onLoadHeaders:function(t){var e=this;e.endDate=l()(t).format("YYYY-MM-DD"),e.loading.searchModal=!0,axios.get(e.url.ajax_get_headers_by_date,{params:{startDate:e.startDate,endDate:e.endDate,departmentCode:e.dept.department_code}}).then((function(t){e.ptmesHeaders=t.data.data,e.loading.searchModal=!1,e.disModal2=!1})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},onLoadLines:function(){var t=this,e=this;Swal.fire({title:"กรุณารอสักครู่"}),console.log(e.ptmesDistribution.length),console.log(e.isMG6),Swal.showLoading(),console.log($.param({batch_id:e.selValue.batch_id,wip_step:e.selWipStep.wip_step,startDate:e.startDate,endDate:e.endDate})),axios.get(e.url.ajax_get_lines+"?"+$.param({batch_id:e.selValue.batch_id,wip_step:e.selWipStep.wip_step,startDate:e.startDate,endDate:e.endDate})).then((function(a){var s=a.data;if(e.ptmesLines=s.data,e.ptmesLines.length)for(var i=0;i<e.ptmesLines.length;i++)e.firstData.push({productQty:e.ptmesLines[i].product_qty});if(s.nextWip.length)for(var o=0;o<s.nextWip.length;o++)void 0!==e.ptmesLines[o]&&("Y"==e.ptmesLines[o].attribute2&&void 0!==e.ptmesLines[o]?e.ptmesLines[o].transfer_qty=e.ptmesLines[o].transfer_qty:e.ptmesLines[o].transfer_qty=s.nextWip[o].product_qty);e.goto("div2"),Swal.close(),t.scrollToLines()})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message+" ["+t.lineNumber+"]"})}))},newGoto:function(t){console.log("new goto id=",t),$("html, body").animate({scrollTop:$(t).offset().top},500)},scrollToLines:function(){$("html, body").animate({scrollTop:$("#item-lines").offset().top},500)},onLoadModalResult:function(){var t=this;t.modalSearchResult=[],t.loading.searchModal=!0,t.onLoadLines(),axios.get(t.url.ajax_get_search,{params:{batch_id:t.selValue.batch_id,wip_step:t.selWipStep.wip_step,startDate:t.startDate,endDate:t.endDate}}).then((function(e){var a=e.data;t.modalSearchResult=a.data,t.loading.searchModal=!1})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},updateattribute2:function(){var t=this,e=0,a=0;if(t.firstData.length){console.log("Updating attribute2...");for(var s=0;s<t.ptmesLines.length;s++)e=parseFloat(t.firstData[s+1].productQty),a=parseFloat(t.ptmesLines[s].product_qty),console.log("Org"+e),console.log("Nor"+a),e!=a&&(t.ptmesLines[s].attribute2="Y",console.log("product_qty changed..."+t.ptmesLines[s].attribute2))}console.log("Updating finished ...")},onClearForm:function(){Object.assign(this.$data,{showDistribID:"",dept:"",widthTable:0,ptmesHeaders:"",selValue:{batch_id:"",batch_no:"",product_type:"",item_code:"",item_desc:"",request_qty:"",uom:"",unit_of_measure:"",blend_no:"",start_date_original:"",product_qty:""},loading:{line:!1,loadDist:!1,searchModal:!1,wipStep:!1},ptmesLines:[],modalSearchResult:[],ptmesDistribution:[],firstData:[{productQty:""}],dateRef:"",wipDateRef:[],urlDateLink:"",wipStep:[],selWipStep:{wip_step:"",wip_step_desc:""},wip:"",startDate:"",endDate:"",trFlag:"",pIdx:"",wipDateRange:{start_date:"",end_date:""},wipStartDate:"",wipSelectStartDate:"",wipSelectEndDate:"",wipEndDate:"",distbChange:!1,disBatch:!1,disWip:!0,disWipStart:!0,disWipEnd:!0,disModal1:!0,disModal2:!0,disModal3:!0,disModal4:!0,isMG6:!1,price:0}),this.initialMethod()},onSelWipStep:function(){var t=this;t.disWipStart=!1,t.disWip=!0,t.ptmesDistribution=[],t.ptmesLines=[];var e=t.wipStep.findIndex((function(e){return e.wip_step==t.selWipStep.wip_step}));t.selWipStep=t.wipStep[e]},onLoadDistribution:function(t,e,a,s){var o=this;return r(i().mark((function n(){var c;return i().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if((c=o).showDistribID=t,console.log("showDistributeID : ",c.showDistribID),console.log(t,e,a,s),c.goto("div3"),c.dateRef=l()(e).add(543,"years").format("DD/MM/YYYY"),!c.distbChange){n.next=10;break}Swal.fire({title:"ข้อมูลมีการเปลี่ยนแปลงและยังไม่ได้บันทึก",text:"คุณต้องการดำเนินการต่อหรือไม่",icon:"คำเตือน",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"ดำเนินการต่อ",cancelButtonText:"ยกเลิก"}).then(function(){var e=r(i().mark((function e(o){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!o.isConfirmed){e.next=11;break}return Swal.fire({title:"กรุณารอสักครู่"}),Swal.showLoading(),c.ptmesDistribution=[],c.trFlag=a,c.pIdx=s,e.next=8,axios.get(c.url.ajax_get_distributions,{params:{wip_step:c.selWipStep.wip_step,batch_id:c.selValue.batch_id,product_line_id:t}}).then((function(t){c.ptmesDistribution=t.data.data})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}));case 8:c.distbChange=!1,Swal.close(),c.goto("div3");case 11:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()),n.next=21;break;case 10:return Swal.fire({title:"กรุณารอสักครู่"}),Swal.showLoading(),c.ptmesDistribution=[],c.trFlag=a,c.pIdx=s,n.next=17,axios.get(c.url.ajax_get_distributions,{params:{wip_step:c.selWipStep.wip_step,batch_id:c.selValue.batch_id,product_line_id:t}}).then((function(t){c.ptmesDistribution=t.data.data,console.log(c.ptmesDistribution)})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}));case 17:c.distbChange=!1,Swal.close(),c.goto("div3"),c.newGoto("#distribution-"+s);case 21:o.configWidthTable();case 22:case"end":return n.stop()}}),n)})))()},onLoadWipStep:function(){var t=this;Swal.fire({title:"กรุณารอสักครู่"}),Swal.showLoading();var e;t.disWip=!1,t.wipStep=[],t.ptmesDistribution=[],t.ptmesLines=[];var a=t.ptmesHeaders.findIndex((function(e){return e.batch_id==t.selValue.batch_id}));t.selValue=t.ptmesHeaders[a],e=l()(t.selValue.start_date_original).format("YYYY-MM-DD"),axios.get(t.url.ajax_get_wipstep,{params:{batch_id:t.selValue.batch_id,date:e}}).then((function(e){t.wipStep=e.data.wip,t.wipDateRange=e.data.dateRange,e.data.currentDate?(t.wipStartDate=l()(t.wipDateRange.start_date).add(543,"years").format("DD/MM/YYYY"),t.wipSelectStartDate=l()().add(543,"years").format("DD/MM/YYYY"),t.wipSelectEndDate=l()().add(543,"years").format("DD/MM/YYYY"),t.wipEndDate=l()(t.wipDateRange.end_date).add(543,"years").format("DD/MM/YYYY"),t.startDate=l()().add(543,"years").format("DD/MM/YYYY"),t.endDate=l()().add(543,"years").format("DD/MM/YYYY")):(t.wipStartDate=l()(t.wipDateRange.start_date).add(543,"years").format("DD/MM/YYYY"),t.wipSelectStartDate=l()(t.wipDateRange.start_date).add(543,"years").format("DD/MM/YYYY"),t.wipSelectEndDate=l()(t.wipDateRange.end_date).add(543,"years").format("DD/MM/YYYY"),t.wipEndDate=l()(t.wipDateRange.end_date).add(543,"years").format("DD/MM/YYYY"),t.startDate=l()(t.wipDateRange.start_date).add(543,"years").format("YYYY-MM-DD"),t.endDate=l()(t.wipDateRange.end_date).add(543,"years").format("YYYY-MM-DD")),t.disBatch=!0,Swal.close()})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},onLoadWipStepM:function(){var t,e=this;e.loading.searchModal=!0,e.wipStep=[],e.ptmesDistribution=[],e.ptmesLines=[];var a=e.ptmesHeaders.findIndex((function(t){return t.batch_id==e.selValue.batch_id}));e.selValue=e.ptmesHeaders[a],t=l()(e.selValue.start_date_original).format("YYYY-MM-DD"),axios.get(e.url.ajax_get_wipstep,{params:{batch_id:e.selValue.batch_id,date:t}}).then((function(t){e.wipStep=t.data.wip,e.wipDateRange=t.data.dateRange,e.wipStartDate=l()(e.wipDateRange.start_date).add(543,"years").format("DD/MM/YYYY"),e.wipEndDate=l()(e.wipDateRange.end_date).add(543,"years").format("DD/MM/YYYY"),e.loading.searchModal=!1,e.disModal3=!1})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"เกิดข้อผิดพลาด!",footer:t.message})}))},onClickSave:function(){var t=this;Swal.fire({title:"คุณต้องการบันทึกข้อมูล, ใช่หรือไม่?",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"บันทึก",cancelButtonText:"ยกเลิก"}).then((function(e){if(e.isConfirmed){Swal.fire({title:"กำลังบันทึกข้อมูล"}),Swal.showLoading();if(t.loading.wipStep=!0,t.loading.line=!0,t.loading.loadDist=!0,t.firstData.length)for(var a=0;a<t.ptmesLines.length;a++)parseFloat(t.firstData[a+1].productQty)!=parseFloat(t.ptmesLines[a].product_qty)?t.ptmesLines[a].attribute2="Y":"Y"!=t.ptmesLines[a].attribute2&&(t.ptmesLines[a].attribute2=null);var s={distributions:t.ptmesDistribution,lines:t.ptmesLines};axios.patch(t.url.ajax_update_orders,s).then((function(e){200==e.status&&(t.distbChange=!1,t.loading.wipStep=!1,t.loading.line=!1,t.loading.loadDist=!1,Swal.close(),Swal.fire({icon:"success",title:"Ok...",text:"บันทึกข้อมูลสำเร็จ"}))})).catch((function(t){Swal.close(),t.response?(console.log(t.response.data),console.log(t.response.status),console.log(t.response.headers)):t.request?console.log(t.request):console.log("Error",t.message),console.log(t.config),Swal.fire({icon:"error",title:"Oops...",text:"บันทึกข้อมูลไม่สำเร็จ!",footer:t.message})}))}}))},onCancel:function(){Swal.fire({title:"Are you sure?",text:"You will not be able to recover this imaginary file!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"No, keep it"}).then((function(t){t.isConfirmed?Swal.fire("Deleted!","Your imaginary file has been deleted.","success"):t.dismiss===Swal.DismissReason.cancel&&Swal.fire("Cancelled","Your imaginary file is safe :)","error")}))}},computed:{totalMfg:function(){var t=0,e=this;if(e.ptmesDistribution.length){for(var a=0;a<e.ptmesDistribution.length;a++)t+=e.ptmesDistribution[a].product_qty;e.ptmesLines[e.pIdx].product_qty=t}return t},totalSample:function(){var t=0,e=this;if(e.ptmesDistribution.length){for(var a=0;a<e.ptmesDistribution.length;a++)t+=parseFloat(e.ptmesDistribution[a].sample_qty);e.ptmesLines[e.pIdx].example_qty=t}return t},totalLoss:function(){var t=0,e=this;if(e.ptmesDistribution.length){for(var a=0;a<e.ptmesDistribution.length;a++)t+=parseFloat(e.ptmesDistribution[a].result_loss_qty);e.ptmesLines[e.pIdx].loss_qty=t}return t},distDate:function(t){return helperDate.parseToDateTh(t,"DD/MM/YYYY")}},watch:{price:function(t){var e=this,a=t.replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,",");Vue.nextTick((function(){return e.price=a}))}}};var d=a(93379),p=a.n(d),u=a(91767),_={insert:"head",singleton:!1};p()(u.Z,_);u.Z.locals;const v=(0,a(51900).Z)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-12"},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.wipStep,expression:"loading.wipStep"}],ref:"div1",staticClass:"ibox"},[a("div",{staticClass:"ibox-title",staticStyle:{"padding-right":"20px"}},[a("div",{staticClass:"row"},[t._m(0),t._v(" "),a("div",{staticClass:"col-lg-4",staticStyle:{"text-align":"right"}},[a("button",{staticClass:"btn btn-default",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onClearForm(e)}}},[a("i",{staticClass:"fa fa-refresh"}),t._v("\n                                ล้างค่า\n                            ")]),t._v(" "),t._m(1),t._v(" "),a("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onClickSave(e)}}},[a("i",{staticClass:"fa fa-save"}),t._v("\n                                บันทึก\n                            ")])])])]),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6 col-sm-12"},[a("div",{staticClass:"form-group row"},[t._m(2),t._v(" "),a("div",{staticClass:"col-lg-9"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.department.description,expression:"department.description"}],staticClass:"form-control",attrs:{disabled:""},domProps:{value:t.department.description},on:{input:function(e){e.target.composing||t.$set(t.department,"description",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(3),t._v(" "),a("div",{staticClass:"col-lg-9"},[a("el-select",{staticClass:"col-lg-12",attrs:{filterable:"",remote:"",placeholder:"ระบุเลขที่คำสั่งผลิต",disabled:1==t.disBatch},on:{change:t.onLoadWipStep},model:{value:t.selValue.batch_id,callback:function(e){t.$set(t.selValue,"batch_id",e)},expression:"selValue.batch_id"}},t._l(t.ptmesHeaders,(function(t){return a("el-option",{key:t.batch_id,attrs:{label:t.batch_no+", "+t.item_desc,value:t.batch_id}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("สินค้าที่จะผลิต:")]),t._v(" "),a("div",{staticClass:"col-lg-9"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-12"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.selValue.item_code,expression:"selValue.item_code"}],staticClass:"form-control",attrs:{type:"text",disabled:""},domProps:{value:t.selValue.item_code},on:{input:function(e){e.target.composing||t.$set(t.selValue,"item_code",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-12"},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.selValue.item_desc,expression:"selValue.item_desc"}],staticClass:"form-control pt-2",attrs:{rows:"3",disabled:""},domProps:{value:t.selValue.item_desc},on:{input:function(e){e.target.composing||t.$set(t.selValue,"item_desc",e.target.value)}}})])])])])]),t._v(" "),a("div",{staticClass:"col-lg-6 col-sm-12"},[a("div",{staticClass:"form-group row"},[t._m(4),t._v(" "),a("div",{staticClass:"col-lg-10"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"ระบุขั้นตอนการทำงาน",disabled:1==t.disWip},on:{change:t.onSelWipStep},model:{value:t.selWipStep.wip_step,callback:function(e){t.$set(t.selWipStep,"wip_step",e)},expression:"selWipStep.wip_step"}},t._l(t.wipStep,(function(t){return a("el-option",{key:t.wip_step,attrs:{label:t.wip_step+" "+t.wip_step_desc,value:t.wip_step}})})),1)],1),t._v(" "),a("div",{staticClass:"col-lg-6"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.selWipStep.wip_step_desc,expression:"selWipStep.wip_step_desc"}],staticClass:"form-control",attrs:{type:"text",disabled:""},domProps:{value:t.selWipStep.wip_step_desc},on:{input:function(e){e.target.composing||t.$set(t.selWipStep,"wip_step_desc",e.target.value)}}})])])])]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(5),t._v(" "),a("div",{staticClass:"col-lg-4"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"startDate",id:"startDate",disabled:1==t.disWipStart,placeholder:"โปรดเลือกวันที่",value:t.wipSelectStartDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,s=Array(a);a--;)s[a]=arguments[a];return t.setDate.apply(void 0,s.concat(["startDate"]))}}})],1),t._v(" "),t._m(6),t._v(" "),a("div",{staticClass:"col-lg-4"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"endDate",id:"endDate",disabled:1==t.disWipEnd,placeholder:"โปรดเลือกวันที่",value:t.wipSelectEndDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,s=Array(a);a--;)s[a]=arguments[a];return t.setDate.apply(void 0,s.concat(["endDate"]))}}})],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-2 col-sm-4 col-form-label"},[t._v("Blend No.:")]),t._v(" "),a("div",{staticClass:"col-lg-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.selValue.blend_no,expression:"selValue.blend_no"}],staticClass:"form-control",attrs:{disabled:""},domProps:{value:t.selValue.blend_no},on:{input:function(e){e.target.composing||t.$set(t.selValue,"blend_no",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-12"},[a("button",{staticClass:"btn btn-default",staticStyle:{float:"right"},attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onLoadLines(e)}}},[t._v("\n                                        แสดงข้อมูล\n                                    ")])])])])])])]),t._v(" "),a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.line,expression:"loading.line"}],ref:"div2",staticClass:"ibox"},[t._m(7),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-bordered",attrs:{id:"item-lines"}},[a("thead",[a("tr",[a("th",[t._v("วันที่ได้ผลผลิต")]),t._v(" "),a("th",[t._v("คงคลังเช้า")]),t._v(" "),a("th",[t._v("ผลผลิตที่ได้")]),t._v(" "),a("th",[t._v("สูญเสีย")]),t._v(" "),t._m(8),t._v(" "),a("th",[t._v("คงคลังเย็น")]),t._v(" "),t.isMG6?t._e():a("th",[t._v("บุหรี่ต้วอย่าง")]),t._v(" "),a("th",[t._v("หน่วยนับ")]),t._v(" "),a("th",[t._v("สถานะการบันทึกผล")]),t._v(" "),a("th",[t._v("ตัดใช้วัตถุดิบ")]),t._v(" "),a("th",[t._v("บันทึกเข้าคลัง")]),t._v(" "),a("th",[t._v("รายละเอียด")])])]),t._v(" "),t.ptmesLines.length?a("tbody",[t._l(t.ptmesLines,(function(e,s){return[a("tr",[a("td",{staticClass:"g"},[t._v("\n                                        "+t._s(e.product_date_format)+"\n                                    ")]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(parseFloat(e.receive_wip).toLocaleString()))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(parseFloat(e.product_qty).toLocaleString()))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(parseFloat(e.loss_qty).toLocaleString()))]),t._v(" "),a("td",[a("vue-numeric",{staticClass:"form-control",attrs:{precision:2,separator:","},model:{value:e.transfer_qty,callback:function(a){t.$set(e,"transfer_qty",a)},expression:"item.transfer_qty"}})],1),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(t.transWip(s).toLocaleString()))]),t._v(" "),t.isMG6?t._e():a("td",{staticClass:"g"},[t._v(t._s(parseFloat(e.example_qty).toLocaleString()))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(e.unit_of_measure))]),t._v(" "),a("td",{staticClass:"g"},["Y"==e.attribute2?a("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:""}},[t._v("ยืนยันยอดผลผลิตแล้ว")]):a("button",{staticClass:"btn btn-danger",attrs:{type:"button",disabled:""}},[t._v("ยังไม่ยืนยันยอดผลผลิต")])]),t._v(" "),a("td",{staticClass:"g",staticStyle:{"text-align":"center"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.transaction_flag,expression:"item.transaction_flag"}],attrs:{type:"checkbox",disabled:""},domProps:{checked:Array.isArray(e.transaction_flag)?t._i(e.transaction_flag,null)>-1:e.transaction_flag},on:{change:function(a){var s=e.transaction_flag,i=a.target,o=!!i.checked;if(Array.isArray(s)){var l=t._i(s,null);i.checked?l<0&&t.$set(e,"transaction_flag",s.concat([null])):l>-1&&t.$set(e,"transaction_flag",s.slice(0,l).concat(s.slice(l+1)))}else t.$set(e,"transaction_flag",o)}}})]),t._v(" "),a("td",{staticClass:"g",staticStyle:{"text-align":"center"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.attribute3,expression:"item.attribute3"}],attrs:{type:"checkbox",disabled:""},domProps:{checked:Array.isArray(e.attribute3)?t._i(e.attribute3,null)>-1:e.attribute3},on:{change:function(a){var s=e.attribute3,i=a.target,o=!!i.checked;if(Array.isArray(s)){var l=t._i(s,null);i.checked?l<0&&t.$set(e,"attribute3",s.concat([null])):l>-1&&t.$set(e,"attribute3",s.slice(0,l).concat(s.slice(l+1)))}else t.$set(e,"attribute3",o)}}})]),t._v(" "),a("td",{staticClass:"g"},[a("a",{staticClass:"btn btn-default",on:{click:function(a){return a.preventDefault(),t.onLoadDistribution(e.product_line_id,e.product_date_original,e.transaction_flag,s)}}},[t._v("รายละเอียด")])])]),t._v(" "),t.showDistribID==e.product_line_id?a("tr",[a("td",{attrs:{colspan:"13"}},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.loadDist,expression:"loading.loadDist"}],ref:"div3",refInFor:!0,staticClass:"ibox",attrs:{id:"distribution-"+s}},[a("div",{staticClass:"ibox-title"},[a("h3",{ref:"distributeFocus",refInFor:!0},[t._v("บันทึกผลผลิตรายวันรายเครื่อง "+t._s(t.dateRef))])]),t._v(" "),a("div",{staticClass:"ibox-content line-container"},[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table"},[a("thead",[a("tr",{attrs:{align:"center"}},[a("th",{staticClass:"sticky-col first-col",attrs:{rowspan:"2"}},[t._v("ชุดเครื่องจักร")]),t._v(" "),a("th",{staticClass:"sticky-col second-col",attrs:{rowspan:"2"}},[t._v("หมายเลขเครื่องจักร")]),t._v(" "),t._l(t.productPeriod,(function(e,s){return a("th",{key:s,attrs:{colspan:"2"}},[t._v(t._s(e.description))])})),t._v(" "),a("th",{staticStyle:{"min-width":"150px"},attrs:{rowspan:"2"}},[t._v("ยอดสูญเสีย")]),t._v(" "),t._m(9,!0),t._v(" "),a("th",{staticStyle:{"min-width":"150px"},attrs:{rowspan:"2"}},[t._v("ยอดผลิตรวมทั้งวัน")]),t._v(" "),t.isMG6?t._e():a("th",{staticStyle:{"min-width":"80px"},attrs:{rowspan:"2"}},[t._v("จำนวนบุหรี่ตัวอย่าง")]),t._v(" "),a("th",{staticStyle:{"min-width":"50px"},attrs:{rowspan:"2"}},[t._v("หน่วยนับ")])],2),t._v(" "),a("tr",{attrs:{align:"center"}},[t._l(t.productPeriod,(function(e){return[a("th",{staticStyle:{"min-width":"150px"}},[t._v("ผลผลิตที่ได้")]),t._v(" "),a("th",{staticStyle:{"min-width":"150px"}},[t._v("ยืนยันยอดผลผลิต"),a("span",{staticStyle:{color:"red"}},[t._v("*")])])]}))],2)]),t._v(" "),t.ptmesDistribution.length?a("tbody",t._l(t.ptmesDistribution,(function(e,s){return a("tr",{key:s,class:{disable:"Y"==t.trFlag}},[a("td",{staticClass:"g sticky-col first-col"},[t._v(t._s(e.machine_set))]),t._v(" "),a("td",{staticClass:"g sticky-col second-col"},[t._v(t._s(e.machine_number))]),t._v(" "),t._l(t.productPeriod,(function(s){return[a("td",{staticClass:"g",attrs:{"data-period":"qty_0"+s.seq}},[t._v(t._s(parseFloat(null!=e["qty_0"+s.seq]?e["qty_0"+s.seq]:"0").toLocaleString()))]),t._v(" "),a("td",{attrs:{"data-period":"result_qty"+s.seq}},[a("vue-numeric",{staticClass:"form-control",attrs:{precision:2,separator:",",disabled:"Y"==t.trFlag},model:{value:e["result_qty_0"+s.seq],callback:function(a){t.$set(e,"result_qty_0"+s.seq,a)},expression:"distribution['result_qty_0'+ period.seq]"}})],1)]})),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(parseFloat(e.loss_qty).toLocaleString()))]),t._v(" "),a("td",[a("vue-numeric",{staticClass:"form-control",attrs:{precision:2,separator:",",disabled:"Y"==t.trFlag},model:{value:e.result_loss_qty,callback:function(a){t.$set(e,"result_loss_qty",a)},expression:"distribution.result_loss_qty"}})],1),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(t.sumMfg(s).toLocaleString()))]),t._v(" "),t.isMG6?t._e():a("td",[a("vue-numeric",{staticClass:"form-control",attrs:{precision:2,separator:",",disabled:"Y"==t.trFlag},model:{value:e.sample_qty,callback:function(a){t.$set(e,"sample_qty",a)},expression:"distribution.sample_qty"}})],1),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(e.unit_of_measure))])],2)})),0):a("tbody",[t._m(10,!0)]),t._v(" "),a("tfoot",[a("tr",[a("td",{staticClass:"g text-right",attrs:{colspan:"11"}},[t._v("ยอดรวมทุกเครื่อง")]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(t.totalLoss.toLocaleString()))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(t.totalMfg.toLocaleString()))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(t.totalSample.toLocaleString()))]),t._v(" "),a("td")])])])])])])])]):t._e()]}))],2):a("tbody",[t._m(11)])])])])])]),t._v(" "),a("div",{staticClass:"modal inmodal fade",staticStyle:{display:"none"},attrs:{id:"modalLines",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-xl"},[a("div",{staticClass:"modal-content"},[t._m(12),t._v(" "),a("div",{staticClass:"modal-body"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-2"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"startDate",id:"startDateM","popper-append-to-body":!1,placeholder:"วันที่เริ่มผลิต",value:t.wipStartDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,s=Array(a);a--;)s[a]=arguments[a];return t.setDate.apply(void 0,s.concat(["startDate"]))}}})],1),t._v(" "),a("div",{staticClass:"col-md-2"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"endDate",id:"endDateM",disabled:t.disModal1,"popper-append-to-body":!1,placeholder:"ถึงวันที่",value:t.wipEndDate,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){return t.onLoadHeaders.apply(void 0,arguments)}}})],1),t._v(" "),a("div",{staticClass:"col-md-3"},[a("el-select",{staticClass:"col-lg-12",attrs:{filterable:"",remote:"",placeholder:"เลขที่คำสั่งการผลิค","popper-append-to-body":!1,disabled:t.disModal2},on:{change:t.onLoadWipStepM},model:{value:t.selValue.batch_id,callback:function(e){t.$set(t.selValue,"batch_id",e)},expression:"selValue.batch_id"}},t._l(t.ptmesHeaders,(function(t){return a("el-option",{key:t.batch_id,attrs:{label:t.batch_no,value:t.batch_id}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-3"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"ขั้นตอนการผลิต","popper-append-to-body":!1,disabled:t.disModal3},on:{change:t.onSelWipStep},model:{value:t.selWipStep.wip_step,callback:function(e){t.$set(t.selWipStep,"wip_step",e)},expression:"selWipStep.wip_step"}},t._l(t.wipStep,(function(t){return a("el-option",{key:t.wip_step,attrs:{label:t.wip_step+" "+t.wip_step_desc,value:t.wip_step}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-2"},[a("button",{staticClass:"btn btn-default pt-1 form-control",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.onLoadModalResult(e)}}},[a("i",{staticClass:"fa fa-search"}),t._v("\n                                    ค้นหา\n                                ")])])]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12 pt-4"},[a("table",{staticClass:"table table-bordered"},[t._m(13),t._v(" "),t.modalSearchResult.length?a("tbody",t._l(t.modalSearchResult,(function(e,s){return a("tr",{key:s,class:{disable:e.transaction_flag},staticStyle:{"text-align":"center"}},[a("td",{staticClass:"g"},["Y"==e.attribute2?a("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:""}},[t._v("ยืนยันยอดผลผลิตแล้ว")]):a("button",{staticClass:"btn btn-danger",attrs:{type:"button",disabled:""}},[t._v("ยังไม่ยืนยันยอดผลผลิต")])]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(e.batch_no))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(e.item_code)+" | "+t._s(e.item_desc))]),t._v(" "),a("td",{staticClass:"g"},[t._v(t._s(e.wip_step))]),t._v(" "),a("td",{staticClass:"g"},[t._v("\n                                        "+t._s(t.dateTh(s))+"\n                                        ")]),t._v(" "),a("td",{staticClass:"g"},[a("a",{staticClass:"btn btn-warning",attrs:{"data-toggle":"modal","data-target":"#modalLines"},on:{click:function(a){return a.preventDefault(),t.onLoadDistribution(e.product_line_id,e.product_date,e.transaction_flag,s)}}},[a("i",{staticClass:"fa fa-edit"}),t._v("\n                                                แก้ไข\n                                            ")])])])})),0):a("tbody",[a("tr",[a("td",{staticStyle:{"text-align":"center"},attrs:{colspan:"6"}},[t.loading.searchModal?a("div",[t._m(14)]):a("div",[t._v("ไม่มีข้อมูล")])])])])])])])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-lg-8"},[a("h3",[t._v("บันทึกผลผลิตประจำวัน")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("button",{staticClass:"btn btn-default",attrs:{type:"button","data-toggle":"modal","data-target":"#modalLines"}},[a("i",{staticClass:"fa fa-search"}),t._v("\n                                ค้นหา\n                            ")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("\n                                    หน่วยงาน :"),a("span",{staticStyle:{color:"white"}},[t._v("test exite more")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-3 col-sm-4 col-form-label"},[t._v("\n                                    เลขที่คำสั่งผลิต"),a("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":\n                                ")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-2 col-sm-4 col-form-label"},[t._v("ขั้นตอนการทำงาน"),a("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-2 col-sm-4 col-form-label"},[t._v("วันที่เริ่ม\n                                    "),a("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-2 col-sm-4 col-form-label"},[t._v("ถึงวันที่\n                                    "),a("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox-title"},[a("h3",[t._v("บันทึกผลผลิตรายวัน")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",[t._v("จ่ายออก"),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticStyle:{"min-width":"150px"},attrs:{rowspan:"2"}},[t._v("ยืนยันยอดสูญเสีย"),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{staticStyle:{"text-align":"center"},attrs:{colspan:"15"}},[t._v("ไม่มีข้อมูล")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{staticStyle:{"text-align":"center"},attrs:{colspan:"13"}},[t._v("ไม่มีข้อมูล")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),a("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),a("h5",{staticClass:"modal-title m-0 p-0"},[t._v("\n                            บันทึกผลผลิตประจำวัน\n                        ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",{staticStyle:{"text-align":"center"}},[a("th",[t._v("สถานะ")]),t._v(" "),a("th",[t._v("เลขที่คำสั่งผลิต")]),t._v(" "),a("th",[t._v("สินค้าที่ผลิต")]),t._v(" "),a("th",[t._v("ขั้นตอนการทำงาน")]),t._v(" "),a("th",[t._v("วันที่ได้ผลผลิต")]),t._v(" "),a("th",[t._v("การจัดการ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"sk-spinner sk-spinner-wave mb-4"},[a("div",{staticClass:"sk-rect1"}),t._v(" "),a("div",{staticClass:"sk-rect2"}),t._v(" "),a("div",{staticClass:"sk-rect3"}),t._v(" "),a("div",{staticClass:"sk-rect4"}),t._v(" "),a("div",{staticClass:"sk-rect5"})])}],!1,null,"6352391f",null).exports}}]);