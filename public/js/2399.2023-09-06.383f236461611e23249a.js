(self.webpackChunk=self.webpackChunk||[]).push([[2399],{52399:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>p});var r=a(87757),n=a.n(r),s=a(30381),i=a.n(s);function o(t,e,a,r,n,s,i){try{var o=t[s](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(r,n)}function l(t){return function(){var e=this,a=arguments;return new Promise((function(r,n){var s=t.apply(e,a);function i(t){o(s,r,n,i,l,"next",t)}function l(t){o(s,r,n,i,l,"throw",t)}i(void 0)}))}}var d;const c={props:["header","transBtn","transDate","url","countOpen"],data:function(){return{loading:!1,getParamlLoading:!1,transactionDateFormat:"",sprinkleNo:"",sprinkleHeaderId:"",requestHeaders:[],transDateFormat:{from_date:"",to_date:""},inputParams:{sprinkle_header_id_list:[]}}},mounted:function(){},computed:{},watch:{countOpen:(d=l(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.openModal();case 1:case"end":return t.stop()}}),t,this)}))),function(t,e){return d.apply(this,arguments)}),"transDateFormat.from_date":function(t){this.getParam()},"transDateFormat.to_date":function(t){this.getParam()}},methods:{setdate:function(t){var e=arguments,a=this;return l(n().mark((function r(){var s,o,l;return n().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(s=e.length>1&&void 0!==e[1]?e[1]:"",o=a,""!=s){r.next=8;break}return r.next=5,i()(t).format(o.transDate["js-format"]);case 5:o.transactionDateFormat=r.sent,r.next=13;break;case 8:return r.next=10,i()(t).format(o.transDate["js-format"]);case 10:"Invalid date"==(l=r.sent)&&(l=""),o.transDateFormat[s]=l;case 13:case"end":return r.stop()}}),r)})))()},openModal:function(){$("#modal_search").modal("show"),this.getParam()},remoteMethod:function(t){""!==t?this.search({wip_request_no:t,transaction_date:this.transactionDateFormat,action:"search"}):this.requestHeaders=[]},search:function(t){var e=this;e.loading=!0,axios.get(e.url.index,{params:t}).then((function(t){var a=t.data.data;e.loading=!1,e.requestHeaders=a.data}))},selectWipRequestHeader:function(t){var e=this;return l(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:$("#modal_search").modal("hide"),e.requestHeaders=[],e.$emit("selectWipRequestHeader",t);case 3:case"end":return a.stop()}}),a)})))()},submitForm:function(){var t=this;return l(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.search({sprinkle_header_id:t.sprinkleHeaderId,from_transaction_date:t.transDateFormat.from_date,to_transaction_date:t.transDateFormat.to_date,action:"search"});case 1:case"end":return e.stop()}}),e)})))()},getParam:function(){var t=this;return l(n().mark((function e(){var a,r;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:(a=t).getParamlLoading=!0,r={action:"search_get_param",from_transaction_date:a.transDateFormat.from_date,to_transaction_date:a.transDateFormat.to_date},axios.get(a.url.index,{params:r}).then((function(t){var e=t.data.data;a.getParamlLoading=!1,a.inputParams.sprinkle_header_id_list=e.data.sprinkle_header_id_list}));case 4:case"end":return e.stop()}}),e)})))()}}};var u=a(51900);function h(t,e,a,r,n,s,i){try{var o=t[s](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(r,n)}function v(t){return function(){var e=this,a=arguments;return new Promise((function(r,n){var s=t.apply(e,a);function i(t){h(s,r,n,i,o,"next",t)}function o(t){h(s,r,n,i,o,"throw",t)}i(void 0)}))}}const m={components:{modalSearch:(0,u.Z)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("span",[a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_search",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg",staticStyle:{width:"90%","max-width":"950px"}},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"modal-content"},[t._m(0),t._v(" "),a("div",{staticClass:"modal-body text-left"},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.getParamlLoading,expression:"getParamlLoading"}],staticClass:"ibox"},[a("div",{staticClass:"row",staticStyle:{"padding-right":"10px","padding-left":"120px"}},[a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v("วันที่ :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",value:t.transDateFormat.from_date,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,r=Array(a);a--;)r[a]=arguments[a];return t.setdate.apply(void 0,r.concat(["from_date"]))}}})],1)]),t._v(" "),a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ")]),t._v(" "),a("div",{staticClass:"input-group "},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",value:t.transDateFormat.to_date,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,r=Array(a);a--;)r[a]=arguments[a];return t.setdate.apply(void 0,r.concat(["to_date"]))}}})],1)]),t._v(" "),a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" เลขที่เอกสาร :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",clearable:"",placeholder:"เลขที่เอกสาร",loading:t.getParamlLoading,"popper-append-to-body":!1},model:{value:t.sprinkleHeaderId,callback:function(e){t.sprinkleHeaderId=e},expression:"sprinkleHeaderId"}},t._l(t.inputParams.sprinkle_header_id_list,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1)]),t._v(" "),a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ")]),t._v(" "),a("div",{staticClass:"text-left"},[a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:t.submitForm}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                                        "+t._s(t.transBtn.search.text)+"\n                                    ")])])])])]),t._v(" "),a("div",{staticClass:"ibox-content table-responsive m-t mb-3"},[a("table",{staticClass:"table table-hover"},[t._m(1),t._v(" "),a("tbody",t._l(t.requestHeaders,(function(e,r){return a("tr",[a("td",{staticClass:"text-center"},[t._v(t._s(e.transaction_date_format))]),t._v(" "),a("td",[t._v(t._s(e.sprinkle_no))]),t._v(" "),a("td",{staticClass:"text-right"},[a("button",{class:t.transBtn.detail.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(a){return t.selectWipRequestHeader(e)}}},[a("i",{class:t.transBtn.detail.icon}),t._v("\n                                            "+t._s(t.transBtn.detail.text)+"\n                                        ")])])])})),0)])])]),t._v(" "),t._m(2)])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),a("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),a("h4",{staticClass:"modal-title"},[t._v("ค้นหาบันทึกใช้ยาเส้น ZoneC48")]),t._v(" "),a("small",{staticClass:"font-bold"},[t._v("\n                         \n                    ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{width:"200px"}},[t._v("วันที่")]),t._v(" "),a("th",[t._v("เลขที่เอกสาร")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"150px"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-white",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])}],!1,null,null,null).exports},props:["url"],computed:{secondaryUomList:function(){}},watch:{"header.transaction_date_format":function(t){this.header.sprinkle_header_id||(""!=t&&"Invalid date"!=t||(this.header.blend_no="",this.header.opt=""),this.getBlendDetail())},"header.blend_no":function(t){var e;this.header.sprinkle_header_id||(this.header.opt="",this.header.batch_id="",this.header.product_item_id="",this.header.receipt_uom_code="",this.header.receipt_quantity="",this.header.to_locator_code="",this.header.to_locator_id="",this.header.to_organization_id="",this.header.to_subinventory="",this.header.transfer_status="",t&&(this.header.batch_id=this.itemList[t].batch_id,this.header.product_item_id=this.itemList[t].product_item_id,this.header.receipt_uom_code=this.itemList[t].uom_code,this.header.to_locator_code=this.itemList[t].to_locator_code,this.header.to_locator_id=this.itemList[t].to_locator_id,this.header.to_organization_id=this.itemList[t].to_organization_id,this.header.to_subinventory=this.itemList[t].to_subinventory,this.header.transfer_status=null!==(e=this.itemList[t].transfer_status)&&void 0!==e?e:1))}},data:function(){return{data:!1,header:!1,profile:!1,searchTransactionDateFormat:"",transBtn:{},transDate:{},lines:[],blendNoList:[],itemList:{},onhandList:[],checkedAll:!1,loading:{page:!1,before_mount:!1,blend_no:!1},firstLoad:!0,countOpen:0,validateFrom:{blend_no:{is_valid:!0,message:""},opt:{is_valid:!0,message:""},receipt_quantity:{is_valid:!0,message:""},receipt_uom_code:{is_valid:!0,message:""},sprinkle_no:{is_valid:!0,message:""},to_organization_id:{is_valid:!0,message:""},to_subinventory:{is_valid:!0,message:""},to_locator_id:{is_valid:!0,message:""},to_locator_code:{is_valid:!0,message:""},transaction_date_format:{is_valid:!0,message:""}}}},beforeMount:function(){this.getInfo()},mounted:function(){},methods:{show:function(t){var e=this;return v(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:console.log("show header",t),e.getInfo(t.sprinkle_header_id);case 2:case"end":return a.stop()}}),a)})))()},changeReceiptquantity:function(){var t=this;return v(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=t,e.next=3,a.assingLot();case 3:case"end":return e.stop()}}),e)})))()},assingLot:function(){var t=this;return v(n().mark((function e(){var a,r;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a=t,r=parseInt(a.header.receipt_quantity?a.header.receipt_quantity:0),a.onhandList.forEach(function(){var t=v(n().mark((function t(e){var a;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:parseInt(e.total_onhand_quantity)>r?(e.can_misc_receipt=!0,a=r,e.lot_list.forEach(function(){var t=v(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:a>0?a>parseInt(e.onhand_quantity)||parseInt(e.onhand_quantity)==a?(e.issue_quantity=parseInt(e.onhand_quantity),a-=e.issue_quantity):a<parseInt(e.onhand_quantity)&&(e.issue_quantity=a,a=0):e.issue_quantity="";case 1:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())):e.can_misc_receipt=!1;case 1:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}());case 3:case"end":return e.stop()}}),e)})))()},selectedItem:function(t){var e=this;return v(n().mark((function a(){var r,s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:r=e,s=t.is_selected,r.onhandList.forEach(function(){var e=v(n().mark((function e(a){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:s?t.inventory_item_id==a.inventory_item_id?(a.is_disable=!1,a.is_selected=!0):(a.is_disable=!0,a.is_selected=!1):(a.is_disable=!1,a.is_selected=!1);case 1:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 3:case"end":return a.stop()}}),a)})))()},getBlendDetail:function(){var t=this;return v(n().mark((function e(){var a,r;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=!1,(a=t).loading.blend_no=!0,a.blendNoList=[],a.itemList={},e.next=7,axios.get(a.url.index,{params:{action:"get-blend-detail",transaction_date_format:a.header.transaction_date_format}}).then((function(t){r=t.data.data,a.blendNoList=r.data.blend_no_list,a.itemList=r.data.item_list,a.loading.blend_no=!1}));case 7:case"end":return e.stop()}}),e)})))()},getInfo:function(){var t=arguments,e=this;return v(n().mark((function a(){var r,s,i,o;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return r=t.length>0&&void 0!==t[0]?t[0]:"",i={sprinkle_header_id:r},o=!1,(s=e).loading.page=!0,s.loading.before_mount=!0,s.lines=[],s.onhandList=[],a.next=10,axios.get(s.url.index,{params:i}).then((function(t){"S"==(o=t.data.data).status&&(o=o.info),s.loading.page=!1}));case 10:o&&(s.data=o.data,s.header=o.header,s.profile=o.profile,s.transBtn=o.transBtn,s.transDate=o.transDate),s.loading.before_mount=!1,s.header.sprinkle_header_id&&(s.onhandList=_.sortBy(s.header.lines,(function(t){return t.blend_no})));case 13:case"end":return a.stop()}}),a)})))()},setdate:function(t,e){var a=this;return v(n().mark((function r(){var s;return n().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return s=a,r.next=3,i()(t).format(s.transDate["js-format"]);case 3:s.header[e]=r.sent;case 4:case"end":return r.stop()}}),r)})))()},cancel:function(){var t=this;return v(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(0!=(a=t).onhandList.length){e.next=5;break}return e.next=4,helperAlert.showGenericFailureDialog("ไม่พบปริมาณคงคลัง");case 4:return e.abrupt("return");case 5:return e.next=7,helperAlert.showProgressConfirm("กรุณายืนยัน ยกเลิกการโรยยาเส้น");case 7:if(!e.sent){e.next=13;break}return a.loading.page=!0,a.lines,e.next=13,axios.post(a.url.ajax_cancel,{header:a.header}).then((function(t){var e=t.data.data;"S"==e.status&&setTimeout(v(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,a.getInfo(e.header.sprinkle_header_id);case 2:case"end":return t.stop()}}),t)}))),500),"S"!=e.status&&swal({title:"Error !",text:e.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){a.loading.page=!1}));case 13:case"end":return e.stop()}}),e)})))()},save:function(){var t=this;return v(n().mark((function e(){var a,r,s,i;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(0!=(a=t).onhandList.length){e.next=5;break}return e.next=4,helperAlert.showGenericFailureDialog("ไม่พบปริมาณคงคลัง");case 4:return e.abrupt("return");case 5:if(a.searchTransactionDateFormat==a.header.transaction_date_format){e.next=9;break}return e.next=8,helperAlert.showGenericFailureDialog("ข้อมูลการค้นหาไม่ตรงกัน\nกรุณากดแสดผลไหม่");case 8:return e.abrupt("return");case 9:return e.next=11,t.validateHeader(!0);case 11:if(e.sent){e.next=14;break}return e.abrupt("return");case 14:if(r=parseInt(a.header.receipt_quantity?a.header.receipt_quantity:0),s=0,i=[],a.onhandList.forEach(function(){var t=v(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.is_selected&&!e.is_disable&&e.can_misc_receipt&&(i=e,e.lot_list.forEach(function(){var t=v(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:s=parseInt(s)+parseInt(e.issue_quantity?e.issue_quantity:0);case 1:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()));case 1:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()),r==s&&0!=r){e.next=22;break}return e.next=21,helperAlert.showGenericFailureDialog("จำนวนที่ต้องการและปริมาณที่นำไปโรยไม่ตรงกัน");case 21:return e.abrupt("return");case 22:return e.next=24,helperAlert.showProgressConfirm("กรุณายืนยัน บันทึกใช้ยาเส้น ZoneC48");case 24:if(!e.sent){e.next=30;break}return a.loading.page=!0,a.lines,e.next=30,axios.post(a.url.ajax_store,{header:a.header,select_onhand:i}).then((function(t){var e=t.data.data;"S"==e.status&&setTimeout(v(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,a.getInfo(e.header.sprinkle_header_id);case 2:case"end":return t.stop()}}),t)}))),500),"S"!=e.status&&swal({title:"Error !",text:e.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){a.loading.page=!1}));case 30:case"end":return e.stop()}}),e)})))()},setData:function(){var t=this;return v(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:null!=(a=t).header.transfer_header_id&&""!=a.header.transfer_header_id&&a.getLines(!1,"show"),a.firstLoad=!1;case 3:case"end":return e.stop()}}),e)})))()},indexPage:function(){this.getInfo()},getLines:function(){var t=arguments,e=this;return v(n().mark((function a(){var r,s,i,o;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(r=!(t.length>0&&void 0!==t[0])||t[0],s=t.length>1&&void 0!==t[1]?t[1]:"search",i=e,o=!0,!r){a.next=10;break}return a.next=7,e.validateHeader(r);case 7:if(a.sent){a.next=10;break}return a.abrupt("return");case 10:if(!o){a.next=17;break}return i.loading.page=!0,i.searchTransactionDateFormat=i.header.transaction_date_format,i.lines=[],i.onhandList={},a.next=17,axios.get(i.url.ajax_get_lines,{params:{header:i.header,action:s}}).then((function(t){var e=t.data.data;i.onhandList=_.sortBy(e.onhand_list,(function(t){return t.blend_no})),i.assingLot()})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){i.loading.page=!1}));case 17:return a.abrupt("return");case 18:case"end":return a.stop()}}),a)})))()},validateHeader:function(){var t=arguments,e=this;return v(n().mark((function a(){var r,s,i;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return!(t.length>0&&void 0!==t[0])||t[0],r=e,s=!0,i="",a.next=6,r.resetValidate();case 6:if(r.header.transaction_date_format&&"Invalid date"!=r.header.transaction_date_format||(r.$set(r.validateFrom,"transaction_date_format",{is_valid:!1,message:"กรุณากรอกวันที่"}),i=i+"\n"+r.validateFrom.transaction_date_format.message,s=!1),r.header.blend_no||(r.$set(r.validateFrom,"blend_no",{is_valid:!1,message:"กรุณากรอก Blend No"}),i=i+"\n"+r.validateFrom.blend_no.message,s=!1),r.header.opt||(r.$set(r.validateFrom,"opt",{is_valid:!1,message:"กรุณากรอก OPT"}),i=i+"\n"+r.validateFrom.opt.message,s=!1),r.header.receipt_quantity||(r.$set(r.validateFrom,"receipt_quantity",{is_valid:!1,message:"กรุณากรอก จำนวนที่ต้องการ"}),i=i+"\n"+r.validateFrom.receipt_quantity.message,s=!1),r.header.receipt_uom_code||(r.$set(r.validateFrom,"receipt_uom_code",{is_valid:!1,message:"กรุณากรอก หน่วยนับ"}),i=i+"\n"+r.validateFrom.receipt_uom_code.message,s=!1),r.header.sprinkle_no||(r.$set(r.validateFrom,"sprinkle_no",{is_valid:!1,message:"กรุณากรอก เลขที่เอกสาร"}),i=i+"\n"+r.validateFrom.sprinkle_no.message,s=!1),r.header.to_subinventory||(r.$set(r.validateFrom,"to_subinventory",{is_valid:!1,message:"กรุณากรอก คลังจัดเก็บ"}),i=i+"\n"+r.validateFrom.to_subinventory.message,s=!1),r.header.to_locator_id||(r.$set(r.validateFrom,"to_locator_code",{is_valid:!1,message:"กรุณากรอก สถานที่จัดเก็บ"}),i=i+"\n"+r.validateFrom.to_locator_code.message,s=!1),s){a.next=17;break}return a.next=17,helperAlert.showGenericFailureDialog(i);case 17:return a.abrupt("return",s);case 18:case"end":return a.stop()}}),a)})))()},resetValidate:function(){var t=arguments,e=this;return v(n().mark((function a(){var r,s,i;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return r=t.length>0&&void 0!==t[0]&&t[0],s=e,i={is_valid:!0,message:""},""!=r?s.validateFrom[r]=i:(s.validateFrom.transaction_date_format=i,s.validateFrom.blend_no=i,s.validateFrom.opt=i,s.validateFrom.receipt_quantity=i,s.validateFrom.receipt_uom_code=i,s.validateFrom.sprinkle_no=i,s.validateFrom.to_subinventory=i,s.validateFrom.to_locator_code=i),a.abrupt("return");case 5:case"end":return a.stop()}}),a)})))()},setStatus:function(t){var e=this;return v(n().mark((function a(){var r,s,i;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return r=e,!1,s="","confirmTransfer"==t&&(s="กรุณายืนยันการโรยยาเส้น"),a.next=6,helperAlert.showProgressConfirm(s);case 6:if(!a.sent){a.next=13;break}return r.loading.page=!0,i=r.url.ajax_set_status,""!=r.header.sprinkle_header_id&&null!=r.header.sprinkle_header_id&&(i=i.replace("-999",r.header.sprinkle_header_id)),a.next=13,axios.post(i,{sprinkle_header_id:r.header.sprinkle_header_id}).then((function(t){var e=t.data.data;"S"==e.status&&setTimeout(v(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,r.getInfo(e.header.sprinkle_header_id);case 2:case"end":return t.stop()}}),t)}))),500),"S"!=t.data.data.status&&swal({title:"Error !",text:t.data.data.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){r.loading.page=!1}));case 13:case"end":return a.stop()}}),a)})))()}}};const p=(0,u.Z)(m,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.page,expression:"loading.page"}],staticClass:"ibox float-e-margins"},[t.loading.before_mount?t._e():a("div",{staticClass:"ibox-content",staticStyle:{"border-bottom":"0px"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 text-right"},[a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25 ",on:{click:function(e){t.countOpen+=1}}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                        "+t._s(t.transBtn.search.text)+" เลขที่เอกสาร\n                    ")]),t._v(" "),a("button",{class:t.transBtn.create.class+" btn-lg tw-w-25 mr-2",on:{click:function(e){return e.preventDefault(),t.getInfo()}}},[a("i",{class:t.transBtn.create.icon}),t._v("\n                        "+t._s(t.transBtn.create.text)+"\n                    ")]),t._v(" "),a("button",{class:t.transBtn.save.class+" btn-lg tw-w-25",attrs:{disabled:!t.header.can.save},on:{click:function(e){return e.preventDefault(),t.save(e)}}},[a("i",{class:t.transBtn.save.icon}),t._v("\n                            "+t._s(t.transBtn.save.text)+"\n                    ")]),t._v(" "),a("button",{staticClass:"btn btn-primary btn-lg",attrs:{disabled:!t.header.can.transfer},on:{click:function(e){return e.preventDefault(),t.setStatus("confirmTransfer")}}},[a("strong",[t._v("ยืนยันการโรยยาเส้น")])]),t._v(" "),a("button",{staticClass:"btn btn-w-m btn-danger btn-lg",attrs:{disabled:!t.header.can.cancel_transfer},on:{click:function(e){return e.preventDefault(),t.cancel()}}},[a("i",{staticClass:"fa fa-times"}),t._v(" ยกเลิกการโรยยาเส้น\n                    ")])])])]),t._v(" "),t.loading.before_mount?t._e():a("div",{staticClass:"ibox-content"},[a("modal-search",{attrs:{transDate:t.transDate,transBtn:t.transBtn,url:t.url,countOpen:t.countOpen},on:{selectWipRequestHeader:t.show}}),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6 b-r"},[a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right require"},[t._v("วันที่: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"input_date",id:"input_date","not-before-date":t.data.preiod_min_max.min_date_th,"not-after-date":t.data.preiod_min_max.max_date_th,disabled:""!=t.header.sprinkle_header_id,placeholder:"โปรดเลือกวันที่",value:t.header.transaction_date_format,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,r=Array(a);a--;)r[a]=arguments[a];return t.setdate.apply(void 0,r.concat(["transaction_date_format"]))}}}),t._v(" "),t.validateFrom.transaction_date_format.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.transaction_date_format.message)+"\n                                ")])])],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right require"},[t._v("Blend no.: ")]),t._v(" "),a("div",{staticClass:"col-lg-3"},[t.header.sprinkle_header_id?a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.blend_no,expression:"header.blend_no"}],staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",disabled:""},domProps:{value:t.header.blend_no},on:{input:function(e){e.target.composing||t.$set(t.header,"blend_no",e.target.value)}}}):a("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",clearable:"",placeholder:""},model:{value:t.header.blend_no,callback:function(e){t.$set(t.header,"blend_no",e)},expression:"header.blend_no"}},t._l(t.blendNoList,(function(e,r){return t.header.transaction_date_format?a("el-option",{key:r,attrs:{label:r,value:r}}):t._e()})),1),t._v(" "),t.validateFrom.blend_no.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.blend_no.message)+"\n                                ")])])],1),t._v(" "),a("div",{staticClass:"col-lg-1 font-weight-bold col-form-label text-right require"},[t._v("OPT: ")]),t._v(" "),a("div",{staticClass:"col-lg-3"},[t.header.sprinkle_header_id?a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.opt,expression:"header.opt"}],staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",disabled:""},domProps:{value:t.header.opt},on:{input:function(e){e.target.composing||t.$set(t.header,"opt",e.target.value)}}}):a("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",clearable:"",placeholder:""},model:{value:t.header.opt,callback:function(e){t.$set(t.header,"opt",e)},expression:"header.opt"}},t._l(t.blendNoList[t.header.blend_no],(function(e,r){return t.header.transaction_date_format?a("el-option",{key:e.opt,attrs:{label:e.opt,value:e.opt}}):t._e()})),1),t._v(" "),t.validateFrom.opt.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.opt.message)+"\n                                ")])])],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right require"},[t._v("จำนวนที่ต้องการ: ")]),t._v(" "),a("div",{staticClass:"col-lg-4"},[t.header.sprinkle_header_id?a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.receipt_quantity,expression:"header.receipt_quantity"}],staticClass:"form-control text-right",staticStyle:{height:"40px"},attrs:{type:"text",disabled:""},domProps:{value:t.header.receipt_quantity},on:{input:function(e){e.target.composing||t.$set(t.header,"receipt_quantity",e.target.value)}}}):a("input",{directives:[{name:"model",rawName:"v-model.number",value:t.header.receipt_quantity,expression:"header.receipt_quantity",modifiers:{number:!0}}],staticClass:"form-control text-right",staticStyle:{height:"40px"},attrs:{type:"number",min:"0",oninput:"validity.valid||(value='');",disabled:!1},domProps:{value:t.header.receipt_quantity},on:{change:function(e){return t.changeReceiptquantity()},input:function(e){e.target.composing||t.$set(t.header,"receipt_quantity",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}}),t._v(" "),t.validateFrom.receipt_quantity.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.receipt_quantity.message)+"\n                                ")])])]),t._v(" "),a("div",{staticClass:"col-lg-3"},[t.header.sprinkle_header_id?a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.uom_desc,expression:"header.uom_desc"}],staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",disabled:""},domProps:{value:t.header.uom_desc},on:{input:function(e){e.target.composing||t.$set(t.header,"uom_desc",e.target.value)}}}):a("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",clearable:"",placeholder:""},model:{value:t.header.receipt_uom_code,callback:function(e){t.$set(t.header,"receipt_uom_code",e)},expression:"header.receipt_uom_code"}},[t.header.blend_no&&Object.keys(t.itemList[t.header.blend_no].secondary_uom_list).length?t._l(t.itemList[t.header.blend_no].secondary_uom_list,(function(t,e){return a("el-option",{key:e,attrs:{label:t.from_uom.unit_of_measure,value:e}})})):t._e()],2),t._v(" "),t.validateFrom.receipt_uom_code.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.receipt_uom_code.message)+"\n                                ")])])],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right require"},[t._v("เลขที่เอกสาร: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.sprinkle_no,expression:"header.sprinkle_no"}],staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",disabled:""!=t.header.sprinkle_header_id},domProps:{value:t.header.sprinkle_no},on:{input:function(e){e.target.composing||t.$set(t.header,"sprinkle_no",e.target.value)}}}),t._v(" "),t.validateFrom.sprinkle_no.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.sprinkle_no.message)+"\n                                ")])])])])]),t._v(" "),a("div",{staticClass:"col-lg-6"},[a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-3 font-weight-bold col-form-label text-right require"},[t._v("สถานะขอเบิก: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("input",{staticClass:"form-control",attrs:{type:"text",readonly:"",disabled:""},domProps:{value:function(){if(t.header.transfer_status){var e=t.header.request_status_list.find((function(e){return e.lookup_code==t.header.transfer_status}));if(e)return e.description}return null}()}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-3 font-weight-bold col-form-label text-right require"},[t._v("รหัสสินค้าสำเร็จรูป: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[t.header.sprinkle_header_id?a("input",{staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",disabled:""},domProps:{value:t.header.item_no+": "+t.header.item_desc}}):a("input",{staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",readonly:"",disabled:""},domProps:{value:function(){if(t.header.blend_no){var e=t.blendNoList[parseInt(t.header.blend_no)][0];return e.item_no+": "+e.item_desc}return null}()}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-3 font-weight-bold col-form-label text-right require"},[t._v("คลังจัดเก็บ: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.to_subinventory,expression:"header.to_subinventory"}],staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",readonly:"",disabled:""},domProps:{value:t.header.to_subinventory},on:{input:function(e){e.target.composing||t.$set(t.header,"to_subinventory",e.target.value)}}}),t._v(" "),t.validateFrom.to_subinventory.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.to_subinventory.message)+"\n                                ")])])])]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-lg-3 font-weight-bold col-form-label text-right require"},[t._v("สถานที่จัดเก็บ: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.to_locator_code,expression:"header.to_locator_code"}],staticClass:"form-control",staticStyle:{height:"40px"},attrs:{type:"text",readonly:"",disabled:""},domProps:{value:t.header.to_locator_code},on:{input:function(e){e.target.composing||t.$set(t.header,"to_locator_code",e.target.value)}}}),t._v(" "),t.validateFrom.to_locator_code.is_valid?t._e():a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                    "+t._s(t.validateFrom.to_locator_code.message)+"\n                                ")])])])])]),t._v(" "),t.header.sprinkle_header_id?t._e():a("div",{staticClass:"col-lg-6 offset-6"},[a("div",{staticClass:" row"},[a("div",{staticClass:"col-lg-11 text-right"},[a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25 mr-2",on:{click:function(e){return e.preventDefault(),t.getLines(!0,"show")}}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                                แสดงข้อมูล\n                            ")])])])])])],1),t._v(" "),t.loading.before_mount?t._e():a("div",{staticClass:"ibox-content",staticStyle:{"border-top":"0px"}},[a("div",{staticClass:"table-responsive m-t"},[t.searchTransactionDateFormat==t.header.transaction_date_format||t.header.sprinkle_header_id?a("table",{staticClass:"table text-nowrap  table-bordered"},[t._m(0),t._v(" "),a("tbody",[t._l(t.onhandList,(function(e,r){return t.onhandList.length?[a("tr",[a("td",{staticClass:"align-middle text-center",attrs:{date:r}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.is_selected,expression:"item.is_selected"}],attrs:{disabled:e.is_disable||!e.can_misc_receipt,type:"checkbox"},domProps:{checked:Array.isArray(e.is_selected)?t._i(e.is_selected,null)>-1:e.is_selected},on:{change:[function(a){var r=e.is_selected,n=a.target,s=!!n.checked;if(Array.isArray(r)){var i=t._i(r,null);n.checked?i<0&&t.$set(e,"is_selected",r.concat([null])):i>-1&&t.$set(e,"is_selected",r.slice(0,i).concat(r.slice(i+1)))}else t.$set(e,"is_selected",s)},function(a){return t.selectedItem(e)}]}})]),t._v(" "),a("td",{staticClass:"align-middle text-left",attrs:{date:r}},[a("strong",[t._v(t._s(e.blend_no))])]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.item_number)+"\n                                ")]),t._v(" "),a("td",[t._v("\n                                    "+t._s(e.item_desc)+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-right"},[t._v("\n                                    "+t._s(e.total_onhand_quantity)+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-center",attrs:{title:e.issue_uom_code}},[t._v("\n                                    "+t._s(e.issue_unit_of_measure)+"\n                                ")])]),t._v(" "),a("transition",{attrs:{"enter-active-class":"animated fadeIn","leave-active-class":"animated fadeOut"}},[e.is_selected&&e.can_misc_receipt||t.header.sprinkle_header_id?a("tr",[a("td",{attrs:{colspan:"6"}},[a("div",{staticClass:" mb-0 col-lg-8 col-md-6 col-sm-6 col-xs-6 offset-md-2 mt-2"},[a("table",{staticClass:"table text-nowrap table-bordered table-hover"},[a("thead",[a("tr",[a("th",{attrs:{width:"130px;"}},[t._v("\n                                                            LOT No.\n                                                        ")]),t._v(" "),a("th",{staticClass:"text-right",attrs:{width:"100px;"}},[t._v("\n                                                            ปริมาณคงคลัง\n                                                        ")]),t._v(" "),a("th",{staticClass:"text-right",attrs:{width:"100px;"}},[t._v("\n                                                            ปริมาณที่นำไปโรย\n                                                        ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px;"}},[t._v("\n                                                            หน่วยนับ\n                                                        ")])])]),t._v(" "),a("tbody",t._l(e.lot_list,(function(r,n){return e.lot_list.length?a("tr",{attrs:{title:r.origination_date}},[a("td",[t._v(t._s(r.lot_number))]),t._v(" "),a("td",{staticClass:"text-right"},[t._v(t._s(r.onhand_quantity))]),t._v(" "),a("td",{staticClass:"text-right"},[t.header.sprinkle_header_id?a("div",[t._v("\n                                                                "+t._s(r.issue_quantity)+"\n                                                            ")]):a("input",{directives:[{name:"model",rawName:"v-model.number",value:r.issue_quantity,expression:"lot.issue_quantity",modifiers:{number:!0}}],staticClass:"form-control text-right",attrs:{type:"number",min:"0",max:r.onhand_quantity,oninput:"validity.valid||(value='');"},domProps:{value:r.issue_quantity},on:{input:function(e){e.target.composing||t.$set(r,"issue_quantity",t._n(e.target.value))},blur:function(e){return t.$forceUpdate()}}})]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(r.issue_unit_of_measure))])]):t._e()})),0)])])])]):t._e()])]:t._e()}))],2)]):t._e()])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{width:"10px;"}}),t._v(" "),a("th",{attrs:{width:"130px;"}},[t._v("\n                                Blend No.\n                            ")]),t._v(" "),a("th",{attrs:{width:"150px;"}},[t._v("\n                                รหัสสินค้าสำเร็จรูป\n                            ")]),t._v(" "),a("th",[t._v("รายละเอียด")]),t._v(" "),a("th",{staticClass:"text-right",attrs:{width:"100px;"}},[t._v("\n                                ปริมาณคงคลัง\n                            ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px;"}},[t._v("\n                                หน่วยนับ\n                            ")])])])}],!1,null,null,null).exports}}]);