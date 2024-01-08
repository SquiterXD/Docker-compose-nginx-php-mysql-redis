(self.webpackChunk=self.webpackChunk||[]).push([[4731],{24731:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>_});var n=a(87757),i=a.n(n);const r={props:["name","value","placeholder","popperBody","size"],data:function(){return{rows:[],loading:!1,result:this.value}},mounted:function(){this.gatDataRows({keyword:""})},watch:{value:function(e,t){this.result=e}},methods:{remoteMethod:function(e){this.gatDataRows({keyword:e})},gatDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/ar-document-number",{params:e}).then((function(e){var a=e.data.data;t.loading=!1,t.rows=a.filter((function(e){return"CONFIRMED"==e.irp0011_status||"INTERFACE"==e.irp0011_status}))})).catch((function(e){swal("Error",e,"error")}))},focus:function(e){this.gatDataRows({keyword:""})},change:function(e){var t="";this.rows.filter((function(a){a.claim_header_id==e&&(t=a.status)})),this.$emit("change-lov",{value:e,status:t})}}};var o=a(51900);const s=(0,o.Z)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_select"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"","popper-append-to-body":e.popperBody,size:e.size},on:{focus:e.focus,change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.document_number,value:e.claim_header_id}})})),1)],1)}),[],!1,null,null,null).exports;const c={name:"ir-confirm-to-ar-lov-ap-interface",data:function(){return{rows:[],loading:!1,result:this.value}},props:["name","value","placeholder","popperBody","size"],methods:{remoteMethod:function(e){this.gatDataRows({keyword:e})},gatDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/ap-interface-type?lookup_code&keyword",{params:e}).then((function(e){var a=e.data.data;t.loading=!1,t.rows=a})).catch((function(e){swal("Error",e,"error")}))},focus:function(e){this.gatDataRows({keyword:""})},change:function(e){this.$emit("change-lov",e)}},mounted:function(){this.gatDataRows({keyword:""})},watch:{value:function(e,t){this.result=e}}};const l=(0,o.Z)(c,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_select"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"","popper-append-to-body":e.popperBody,size:e.size},on:{focus:e.focus,change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.description,value:e.lookup_code}})})),1)],1)}),[],!1,null,null,null).exports;var d=a(30381),f=a.n(d),u=a(67791);function m(e,t,a,n,i,r,o){try{var s=e[r](o),c=s.value}catch(e){return void a(e)}s.done?t(c):Promise.resolve(c).then(n,i)}function h(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}const p={name:"ir-confirm-to-ar-index",data:function(){return{ApClaim:!1,rules:{interface_year:[{required:!0,message:"กรุณาระบุปี",trigger:"change"}],period_name:[{required:!0,message:"กรุณาระบุประเภท",trigger:"change"}]},index:{period_name:f()(f()().add(543,"years")).format("MM/YYYY"),document_number:"",document_status:"",interface_year:""},disabledInterface:!0,funcs:u.sD,vars:u.gR,showLoading:!1}},methods:{clickPrintReport:function(){var e=this;this.$refs.index_ar_invoice_interface.validate((function(t){if(!t)return!1;e.getReport()}))},clickInterface:function(){var e=this;this.$refs.index_ar_invoice_interface.validate((function(t){if(!t)return!1;e.getInterface()}))},clickCancel:function(){var e=this;this.$refs.index_ar_invoice_interface.validate((function(t){if(!t)return!1;e.getCancel()}))},getValuePeriodName:function(e){var t=this.vars.formatMonth;e?(this.index.period_name=f()(e).format(t),this.$refs.index_ar_invoice_interface.fields.find((function(e){return"ar_interface"==e.prop})).clearValidate()):(this.index.period_name="",this.$refs.index_ar_invoice_interface.validateField("period_name"))},getValueDocumentNumber:function(e){this.index.document_number=e.value,this.index.document_status=e.status},getValueArInterface:function(e){this.ApClaim="IRP0010"===e,this.index.ar_interface=e},getInterface:function(){var e=this;this.showLoading=!0;var t={month:this.funcs.setYearCE("month",this.index.period_name),claim_header_id:this.index.document_number,interface_type_code:this.index.ar_interface,interface_year:this.index.interface_year};axios.get("/ir/ajax/confirm-ar",{params:t}).then((function(t){e.showLoading=!1,window.open(t.data.data.redirect_to_export,"_blank"),swal({title:'<div class="mt-4"> Success </div>',text:'<span style="font-size: 16px; text-align: left;"> ทำการ Interface ข้อมูลเข้า AR เรียบร้อยแล้ว </span>',type:"success",html:!0},(function(e){e&&(window.location.href="/ir/confirm-to-ar")}))})).catch((function(t){e.showLoading=!1,swal({title:'<div class="mt-4"> Warning </div>',text:'<span style="font-size: 16px; text-align: left;">'+t.response.data.message.msg+"</span>",type:"warning",html:!0}),e.disabledInterface=!0}))},getReport:function(){var e=this;this.showLoading=!0;var t={month:this.funcs.setYearCE("month",this.index.period_name),claim_header_id:this.index.document_number,interface_type_code:this.index.ar_interface,interface_year:this.index.interface_year};axios.get("/ir/ajax/confirm-ar/report",{params:t}).then((function(t){e.showLoading=!1,window.open(t.data.data.redirect_to_export,"_blank")})).catch((function(t){swal({title:'<div class="mt-4"> Warning </div>',text:'<span style="font-size: 16px; text-align: left;">'+t.response.data.message.msg+"</span>",type:"warning",html:!0}),e.disabledInterface=!0,e.showLoading=!1})).then((function(){e.disabledInterface=!1,e.showLoading=!1}))},getCancel:function(){var e,t=this;swal((h(e={html:!0,title:"ยกเลิกรายการ Interface AR",text:'<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกรายการ Interface AR ใช่หรือไม่? </span></h2>',showCancelButton:!0,confirmButtonText:"ตกลง",cancelButtonText:"ยกเลิก",confirmButtonClass:"#1ab394",cancelButtonClass:"#e7eaec"},"confirmButtonClass","btn btn-primary btn-lg tw-w-25"),h(e,"cancelButtonClass","btn btn-danger btn-lg tw-w-25"),h(e,"closeOnConfirm",!1),h(e,"closeOnCancel",!0),h(e,"showLoaderOnConfirm",!0),e),function(){var e,a=(e=i().mark((function e(a){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a&&t.cancel();case 1:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(n,i){var r=e.apply(t,a);function o(e){m(r,n,i,o,s,"next",e)}function s(e){m(r,n,i,o,s,"throw",e)}o(void 0)}))});return function(e){return a.apply(this,arguments)}}())},cancel:function(){var e=this;this.showLoading=!0;var t={month:this.funcs.setYearCE("month",this.index.period_name),claim_header_id:this.index.document_number,interface_type_code:this.index.ar_interface};axios.get("/ir/ajax/confirm-ar/cancel",{params:t}).then((function(t){t.data;e.showLoading=!1,swal({title:'<div class="mt-4"> Success </div>',text:'<span style="font-size: 16px; text-align: left;"> ยกเลิกรายการสำเร็จ </span>',type:"success",html:!0},(function(e){e&&(window.location.href="/ir/confirm-to-ar")}))})).catch((function(t){e.showLoading=!1,swal({title:'<div class="mt-4"> Warning </div>',text:'<span style="font-size: 16px; text-align: left;">'+t.response.data.message.msg+"</span>",type:"warning",html:!0}),e.disabledInterface=!0}))},clickClear:function(){window.location.href="/ir/confirm-to-ar"},getValueInterfaceYear:function(e){console.log("getValueInterfaceYear ",e,this.index.interface_year);var t=this.vars.formatYear;e?(this.index.interface_year=f()(e).format(t),this.$refs.index_ar_invoice_interface.fields.find((function(e){return"interface_year"==e.prop})).clearValidate()):(this.$refs.interface_year.resetField(),this.$refs.index_ar_invoice_interface.validateField("interface_year"))}},components:{lovDocumentNumber:s,lovApInterface:l}};const _=(0,o.Z)(p,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("form",{attrs:{id:"comfirm-ar"}},[a("el-form",{directives:[{name:"loading",rawName:"v-loading",value:e.showLoading,expression:"showLoading"}],ref:"index_ar_invoice_interface",staticClass:"demo-ruleForm",attrs:{model:e.index,rules:e.rules,"label-width":"120px"}},[a("div",{staticClass:"col-lg-11"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ปี *")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"interface_year",staticStyle:{"margin-bottom":"0px"},attrs:{prop:"interface_year"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"interface_year",id:"interface_year","p-type":"year",placeholder:"ปี",format:e.vars.formatYear},on:{dateWasSelected:e.getValueInterfaceYear},model:{value:e.index.interface_year,callback:function(t){e.$set(e.index,"interface_year",t)},expression:"index.interface_year"}})],1),e._v(" "),a("span",{staticClass:"text-danger"},[a("strong",[e._v(" ** กรณีเคลมประกัน ให้ระบุปีที่เกิดเหตุ ")])]),e._v(" "),a("br"),e._v(" "),a("span",{staticClass:"text-danger"},[a("strong",[e._v(" ** กรณีเรียกเก็บ ให้ระบุปีงบประมาณ ")])])],1)]),e._v(" "),a("br"),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ประเภท *")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"ar_interface",attrs:{prop:"ar_interface"}},[a("lov-ap-interface",{attrs:{placeholder:"ประเภท",name:"ar_interface",popperBody:!0},on:{"change-lov":e.getValueArInterface},model:{value:e.index.ar_interface,callback:function(t){e.$set(e.index,"ar_interface",t)},expression:"index.ar_interface"}})],1)],1)]),e._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:e.ApClaim,expression:"ApClaim"}],staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("เลขที่เอกสาร")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"document_number"}},[a("lov-document-number",{attrs:{placeholder:"เลขที่เอกสาร",name:"document_number",popperBody:!0},on:{"change-lov":e.getValueDocumentNumber},model:{value:e.index.document_number,callback:function(t){e.$set(e.index,"document_number",t)},expression:"index.document_number"}})],1)],1)])]),e._v(" "),a("div",{staticClass:"text-right el_field"},[a("el-form-item",[a("button",{staticClass:"btn btn-info",attrs:{type:"button"},on:{click:function(t){return e.clickPrintReport()}}},[a("i",{staticClass:"fa fa-print"}),e._v(" พิมพ์รายงาน\n          ")]),e._v(" "),a("button",{directives:[{name:"loading",rawName:"v-loading.fullscreen.lock",value:e.showLoading,expression:"showLoading",modifiers:{fullscreen:!0,lock:!0}}],staticClass:"btn btn-primary",attrs:{type:"button",disabled:e.disabledInterface||"INTERFACE"==e.index.document_status},on:{click:function(t){return e.clickInterface()}}},[a("i",{staticClass:"fa fa-exchange"}),e._v(" ส่ง Interface\n          ")]),e._v(" "),a("button",{staticClass:"btn btn-danger",attrs:{type:"button"},on:{click:function(t){return e.clickCancel()}}},[a("i",{staticClass:"fa fa-times"}),e._v(" ยกเลิก\n          ")]),e._v(" "),a("button",{staticClass:"btn btn-warning",attrs:{type:"button"},on:{click:function(t){return e.clickClear()}}},[a("i",{staticClass:"fa fa-repeat"}),e._v("\n                รีเซต\n          ")])])],1)])],1)])}),[],!1,null,null,null).exports}}]);