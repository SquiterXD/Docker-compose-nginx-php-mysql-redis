(self.webpackChunk=self.webpackChunk||[]).push([[917],{40917:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>v});var s=a(87757),i=a.n(s),o=a(77021),n=a(67791),r=a(4087),c=a(30381),l=a.n(c);function d(t,e,a,s,i,o,n){try{var r=t[o](n),c=r.value}catch(t){return void a(t)}r.done?e(c):Promise.resolve(c).then(s,i)}function _(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function u(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?_(Object(a),!0).forEach((function(e){g(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):_(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function g(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const p={name:"ir-settings-gas-station-edit",data:function(){return{gas_station:{gas_station_id:"",type_code:"",group_code:"",group_name:"",return_vat_flag:!1,vat_percent:"",revenue_stamp_percent:"",type_cost:"",account_combine:"",active_flag:!0,account_id:"",policy_set_header_id:"",insurance_date:"",coverage_amount:""},action:"edit",funcs:n.sD,expireDate:{insurance_expire_date:""},vars:n.gR}},props:["gasStationId","btnTrans"],methods:{getDataEdit:function(t){var e=this;axios.get("/ir/ajax/gas-stations/".concat(t)).then((function(t){var a=t.data.data,s=u(u({},a),{},{return_vat_flag:"Y"===a.return_vat_flag,active_flag:"Y"===a.active_flag,type_cost:"",account_combine:""});e.gas_station=s,e.expireDate=e.setValueExpireDate(s),e.getInsuranceDate(s)})).catch((function(t){swal("Error",t,"error")}))},getAccountCombine:function(t){axios.get("/ir/ajax/lov/account-code-combine",{params:t}).then((function(t){t.data.data})).catch((function(t){swal("Error",t,"error")}))},getValueExpireDate:function(t){this.expireDate=t},setValueExpireDate:function(t){return{insurance_expire_date:t.insurance_expire_date}},getInsuranceDate:function(t){var e,a=this;return(e=i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a.vars.formatDate,t.insurance_date=l()(t.insurance_date).add(543,"years").format(a.vars.formatDate);case 2:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(s,i){var o=e.apply(t,a);function n(t){d(o,s,i,n,r,"next",t)}function r(t){d(o,s,i,n,r,"throw",t)}n(void 0)}))})()}},mounted:function(){this.getDataEdit(this.gasStationId)},components:{formGas:o.Z,modalExpireDate:r.Z}};const v=(0,a(51900).Z)(p,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox"},[a("div",{staticClass:"ibox-title"},[a("h5",[t._v("Detail / Create New")]),a("br"),t._v(" "),a("h5",[t._v("ข้อมูลสถานีน้ำมัน")]),t._v(" "),a("div",{staticClass:"ibox-tools"},[a("button",{staticClass:"btn btn-warning btn-lg",attrs:{type:"button","data-toggle":"modal","data-target":"#modal_expire_date"}},[a("i",{staticClass:"fa fa-calendar"}),t._v(" วันสิ้นอายุประกัน\n      ")])])]),t._v(" "),a("div",{staticClass:"ibox-content"},[a("form-gas",{attrs:{gas_station:t.gas_station,isNullOrUndefined:t.funcs.isNullOrUndefined,action:t.action,expireDate:t.expireDate,"btn-trans":t.btnTrans}}),t._v(" "),a("modal-expire-date",{attrs:{vars:t.vars,expireDate:t.expireDate,"btn-trans":t.btnTrans},on:{"expire-date":t.getValueExpireDate}})],1)])}),[],!1,null,null,null).exports},77021:(t,e,a)=>{"use strict";a.d(e,{Z:()=>f});var s=a(4510);const i={name:"ir-settings-gas-station-lov-type-cost",data:function(){return{rows:[],loading:!1,code:"",desc:"",result:this.value}},props:["value","account_id"],methods:{remoteMethod:function(t){this.getDataRows({account_id:"",keyword:t})},getDataRows:function(t){var e=this,a={code:"",id:"",account_combine:""};this.loading=!0,axios.get("/ir/ajax/lov/account-code-combine",{params:t}).then((function(t){var s=t.data;if(e.loading=!1,e.rows=s.data,e.account_id&&null!==e.account_id&&void 0!==e.account_id)for(var i in e.rows){var o=e.rows[i];o.account_id==e.account_id&&(e.result=o.account_id,a.code=o.account_code,a.id=o.account_id,a.account_combine=o.account_combine)}else a.code="",a.id="",a.account_combine="";e.$emit("change-lov",a)})).catch((function(t){swal("Error",t,"error")}))},focus:function(){this.getDataRows({account_id:"",keyword:""})},change:function(t){var e={code:"",id:"",account_combine:""};if(t)for(var a in this.rows){var s=this.rows[a];s.account_id==t&&(e.code=t,e.id=s.account_id,e.account_combine=s.account_combine)}else e.code="",e.id="",e.account_combine="";this.$emit("change-lov",e)}},created:function(){this.getDataRows({account_id:"",keyword:""})},watch:{account_id:function(t,e){this.getDataRows({account_id:t,keyword:""})}}};var o=a(51900);const n=(0,o.Z)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"ประเภทค่าใช้จ่าย","remote-method":t.remoteMethod,loading:t.loading,name:"type_cost",clearable:!0},on:{change:t.change,focus:t.focus},model:{value:t.result,callback:function(e){t.result=e},expression:"result"}},t._l(t.rows,(function(t,e){return a("el-option",{key:e,attrs:{label:t.account_code+": "+t.description,value:t.account_id}})})),1)],1)}),[],!1,null,null,null).exports;const r={name:"ir-settings-gas-station-lov-policy-group",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","disabled","placeholder","policy_set_header_id"],methods:{remoteMethod:function(t){this.getDataRows({policy_set_header_id:"",keyword:t})},getDataRows:function(t){var e=this;this.loading=!0,axios.get("/ir/ajax/lov/policy-set-header?policy_set_header_id&type=40").then((function(t){var a=t.data;e.loading=!1,e.rows=a.data})).catch((function(t){swal("Error",t,"error")}))},focus:function(){this.getDataRows({policy_set_header_id:"",keyword:""})},change:function(t){var e={code:"",id:"",desc:""};if(t)for(var a in this.rows){var s=this.rows[a];s.policy_set_header_id===t&&(e.code=s.policy_set_number,e.id=t,e.desc=s.policy_set_description)}else e.code="",e.id="",e.desc="";this.$emit("change-lov-policy-group",e)}},watch:{value:function(t,e){t&&(this.result=t)},policy_set_header_id:function(t,e){t&&(this.result=+t),this.getDataRows({policy_set_header_id:t,keyword:""})}}};const c=(0,o.Z)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:t.placeholder,"remote-method":t.remoteMethod,loading:t.loading,name:t.name,clearable:!0,disabled:t.disabled},on:{change:t.change,focus:t.focus},model:{value:t.result,callback:function(e){t.result=e},expression:"result"}},t._l(t.rows,(function(t,e){return a("el-option",{key:e,attrs:{label:t.policy_set_number+" : "+t.policy_set_description,value:t.policy_set_header_id}})})),1)],1)}),[],!1,null,null,null).exports;var l=a(67791),d=a(30381),_=a.n(d);function u(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function g(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?u(Object(a),!0).forEach((function(e){p(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):u(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function p(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const v={name:"ir-settings-gas-station-form",data:function(){return{rules:{type_code:[{required:!0,message:"กรุณาระบุประเภทสถานีน้ำมัน",trigger:"blur"}],policy_set_header_id:[{required:!0,message:"กรุณาระบุกรมธรรม์ชุดที่",trigger:"change"}],type_cost:[{required:!0,message:"กรุณาระบุประเภทค่าใช้จ่าย",trigger:"change"}]},group:[],group_desc:"",tax:"",revenue_stamp:"",valid:!1,vars:l.gR}},props:["gas_station","tableGasStation","isNullOrUndefined","action","expireDate","btnTrans"],methods:{getDataGroup:function(t){var e=this;axios.get("/ir/ajax/lov/group-code-policy",{params:t}).then((function(t){var a=t.data;null===a.data?(e.gas_station.group_code="",e.group_desc=""):(e.gas_station.group_code=a.data.group_code,e.group_desc=a.data.group_desc)})).catch((function(t){swal("Error",t,"error")}))},clickSave:function(){var t=this;this.$refs.save_gas_station.validate((function(e){if(!e)return!1;var a=g(g({},t.gas_station),{},{return_vat_flag:t.gas_station.return_vat_flag?"Y":"N",active_flag:t.gas_station.active_flag?"Y":"N",program_code:"IRM0008"},t.expireDate);t.actionSave(a)}))},clickCancel:function(){window.location.href="/ir/settings/gas-station"},changeGroup:function(t){this.gas_station.group_code=t},actionSave:function(t){"add"===this.action?axios.post("/ir/ajax/gas-stations",{data:t}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success",showConfirmButton:!0},(function(t){window.location.href="/ir/settings/gas-station"}))})).catch((function(t){400===t.response.data.status?swal("Warning",t.response.data.message,"warning"):swal("Error",t,"error")})):axios.put("/ir/ajax/gas-stations",{data:t}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success",showConfirmButton:!0},(function(t){window.location.href="/ir/settings/gas-station"}))})).catch((function(t){swal("Error",t,"error")}))},getDataTypeCostAccountCombine:function(t){this.gas_station.type_cost=t.code,this.gas_station.account_id=t.id,this.gas_station.account_combine=t.account_combine},getDataPocilySetHeader:function(t){this.gas_station.policy_set_header_id=t.id,this.getTaxStamp({policy_set_header_id:t.id})},getTaxStamp:function(t){var e=this;this.valid=!1,axios.get("/ir/ajax/lov/premium-rate",{params:t}).then((function(t){var a=t.data;e.gas_station.vat_percent=a.data.tax})).catch((function(t){e.valid=!0,swal("Error","ไม่มีข้อมูลปีงบประมาณที่หน้าจอ IRM0003","error")}))},getValueInsuranceDate:function(t){var e=this.vars.formatDate;this.gas_station.insurance_date=t?_()(t).format(e):""}},components:{currencyInput:s.Z,lovTypeCost:n,lovPolicyGroup:c},watch:{"gas_station.policy_set_header_id":function(t,e){this.getDataGroup({policy_set_header_id:t})}},created:function(){this.getValueInsuranceDate(this.gas_station.insurance_date)}};const f=(0,o.Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-form",{ref:"save_gas_station",staticClass:"demo-ruleForm",attrs:{model:t.gas_station,rules:t.rules,"label-width":"120px"}},[a("div",{staticClass:"col-lg-11"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("ประเภทสถานีน้ำมัน "),a("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",{attrs:{prop:"type_code"}},[a("el-input",{attrs:{placeholder:"ประเภทสถานีน้ำมัน",disabled:"edit"===t.action},model:{value:t.gas_station.type_code,callback:function(e){t.$set(t.gas_station,"type_code",e)},expression:"gas_station.type_code"}})],1)],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("กรมธรรม์ชุดที่ "),a("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",{attrs:{prop:"policy_set_header_id"}},[a("lov-policy-group",{attrs:{name:"policy_set_header_id",disabled:!1,placeholder:"กรมธรรม์ชุดที่",policy_set_header_id:t.gas_station.policy_set_header_id},on:{"change-lov-policy-group":t.getDataPocilySetHeader},model:{value:t.gas_station.policy_set_header_id,callback:function(e){t.$set(t.gas_station,"policy_set_header_id",e)},expression:"gas_station.policy_set_header_id"}})],1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("วันที่คิดค่าเบี้ยประกัน")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",{attrs:{prop:"insurance_date"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"insurance_date","p-type":"date",placeholder:"วันที่คิดค่าเบี้ยประกัน",format:t.vars.formatDate},on:{dateWasSelected:t.getValueInsuranceDate},model:{value:t.gas_station.insurance_date,callback:function(e){t.$set(t.gas_station,"insurance_date",e)},expression:"gas_station.insurance_date"}})],1)],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("กลุ่ม")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",[a("el-input",{attrs:{placeholder:"กลุ่ม",disabled:!0},model:{value:t.group_desc,callback:function(e){t.group_desc=e},expression:"group_desc"}})],1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("ทุนประกัน")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("currency-input",{attrs:{name:"coverage_amount",sizeSmall:!1,placeholder:"ทุนประกัน"},model:{value:t.gas_station.coverage_amount,callback:function(e){t.$set(t.gas_station,"coverage_amount",e)},expression:"gas_station.coverage_amount"}})],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("ภาษี (%)")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",[a("currency-input",{attrs:{name:"vat_percent",sizeSmall:!1,placeholder:"ภาษี (%)",disabled:!0},model:{value:t.gas_station.vat_percent,callback:function(e){t.$set(t.gas_station,"vat_percent",e)},expression:"gas_station.vat_percent"}})],1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("อากร (บาท)")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",[a("currency-input",{attrs:{name:"revenue_stamp_percent",sizeSmall:!1,placeholder:"อากร (บาท)"},model:{value:t.gas_station.revenue_stamp_percent,callback:function(e){t.$set(t.gas_station,"revenue_stamp_percent",e)},expression:"gas_station.revenue_stamp_percent"}})],1)],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("ประเภทค่าใช้จ่าย "),a("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",{attrs:{prop:"type_cost"}},[a("lov-type-cost",{attrs:{account_id:t.gas_station.account_id},on:{"change-lov":t.getDataTypeCostAccountCombine},model:{value:t.gas_station.type_cost,callback:function(e){t.$set(t.gas_station,"type_cost",e)},expression:"gas_station.type_cost"}})],1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("ภาษีขอคืนได้")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",{staticStyle:{"margin-bottom":"15px"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.gas_station.return_vat_flag,expression:"gas_station.return_vat_flag"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.gas_station.return_vat_flag)?t._i(t.gas_station.return_vat_flag,null)>-1:t.gas_station.return_vat_flag},on:{change:function(e){var a=t.gas_station.return_vat_flag,s=e.target,i=!!s.checked;if(Array.isArray(a)){var o=t._i(a,null);s.checked?o<0&&t.$set(t.gas_station,"return_vat_flag",a.concat([null])):o>-1&&t.$set(t.gas_station,"return_vat_flag",a.slice(0,o).concat(a.slice(o+1)))}else t.$set(t.gas_station,"return_vat_flag",i)}}})])],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("รหัสบัญชี")])]),t._v(" "),a("div",{staticClass:"col-xl-3 col-lg-3 col-md-3 el_field"},[a("el-form-item",[a("el-input",{attrs:{placeholder:"รหัสบัญชี",disabled:""},model:{value:t.gas_station.account_combine,callback:function(e){t.$set(t.gas_station,"account_combine",e)},expression:"gas_station.account_combine"}})],1)],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label lable_align"},[a("strong",[t._v("Active")])]),t._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{staticStyle:{"margin-bottom":"0px"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.gas_station.active_flag,expression:"gas_station.active_flag"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.gas_station.active_flag)?t._i(t.gas_station.active_flag,null)>-1:t.gas_station.active_flag},on:{change:function(e){var a=t.gas_station.active_flag,s=e.target,i=!!s.checked;if(Array.isArray(a)){var o=t._i(a,null);s.checked?o<0&&t.$set(t.gas_station,"active_flag",a.concat([null])):o>-1&&t.$set(t.gas_station,"active_flag",a.slice(0,o).concat(a.slice(o+1)))}else t.$set(t.gas_station,"active_flag",i)}}})])],1)])]),t._v(" "),a("div",{staticClass:"text-right el_field"},[a("el-form-item",[a("button",{class:t.btnTrans.save.class,attrs:{type:"button",disabled:t.valid},on:{click:function(e){return e.preventDefault(),t.clickSave()}}},[a("i",{class:t.btnTrans.save.icon}),t._v("\n          "+t._s(t.btnTrans.save.text)+"\n        ")]),t._v(" "),a("button",{class:t.btnTrans.cancel.class,attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickCancel()}}},[a("i",{class:t.btnTrans.cancel.icon}),t._v("\n          "+t._s(t.btnTrans.cancel.text)+"\n        ")])])],1)])],1)}),[],!1,null,null,null).exports},4087:(t,e,a)=>{"use strict";a.d(e,{Z:()=>n});var s=a(30381),i=a.n(s);const o={name:"ir-settings-gas-station-modal-expire-date",data:function(){return{rules:{insurance_expire_date:[{required:!0,message:"กรุณาระบุวันสิ้นอายุ ประกัน",trigger:"change"}]},modal:this.expireDate}},props:["vars","expireDate"],methods:{clickAgree:function(){var t=this;this.$refs.form_expire_date.validate((function(e){if(!e)return!1;t.$emit("expire-date",t.expireDate),$("#modal_expire_date").modal("hide")}))},getValueInsuranceExpireDate:function(t){var e=this.vars.formatDate;this.expireDate.insurance_expire_date=t?i()(t).format(e):"",this.validateNotElUi(t,"insurance_expire_date")},validateNotElUi:function(t,e){t?this.$refs.form_expire_date.fields.find((function(t){return t.prop==e})).clearValidate():this.$refs.form_expire_date.validateField(e)}}};const n=(0,a(51900).Z)(o,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_expire_date",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-md"},[a("div",{staticClass:"modal-content"},[t._m(0),t._v(" "),a("el-form",{ref:"form_expire_date",staticClass:"demo-dynamic form_table_line",attrs:{model:t.expireDate,"label-width":"120px"}},[a("div",{staticClass:"modal-body"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[t._v("\n              วันสิ้นอายุ ประกัน\n            ")]),t._v(" "),a("div",{staticClass:"col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"insurance_expire_date"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"insurance_expire_date","p-type":"date",placeholder:"วันสิ้นอายุ ประกัน",value:t.expireDate.insurance_expire_date,format:t.vars.formatDate},on:{dateWasSelected:t.getValueInsuranceExpireDate}})],1)],1)])]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:function(e){return t.clickAgree()}}},[a("i",{staticClass:"fa fa-check-circle-o"}),t._v(" ตกลง\n          ")])])])],1)])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),a("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),a("p",{staticClass:"modal-title text-left"},[t._v("วันสิ้นอายุประกัน")])])}],!1,null,null,null).exports}}]);