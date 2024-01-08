(self.webpackChunk=self.webpackChunk||[]).push([[2418],{22418:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>n});const o={name:"ir-settings-compony-create",props:["btnTrans"],data:function(){return{company:{company_number:"",company_name:"",company_address:"",company_telephone:"",vendor_id:"",vendor_site_id:"",customer_id:"",active_flag:"Y",company_id:""},action:"add"}},components:{formComp:a(5641).Z},methods:{getGenCompanyNumber:function(){var e=this;axios.get("/ir/ajax/lov/gen-company-number").then((function(t){var a=t.data.data;e.company.company_number=a.company_number})).catch((function(e){swal("Error",e,"error")}))}},created:function(){this.getGenCompanyNumber()}};const n=(0,a(51900).Z)(o,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("form-comp",{attrs:{company:e.company,action:e.action,"btn-trans":e.btnTrans}})],1)}),[],!1,null,null,null).exports},5641:(e,t,a)=>{"use strict";a.d(t,{Z:()=>v});const o={name:"ir-settings-company-lov-search",data:function(){return{rows:[],loading:!1,result:this.value,code:"",desc:""}},props:["url","value","placeholder","attrName","propCode","propDesc","propCodeDisp","propDescDisp"],computed:{setProperty:function(){var e={};return e[this.propCode]=this.code,e[this.propDesc]=this.desc,e}},methods:{remoteMethod:function(e){this.code="",this.desc=e,this.getDataRows(this.setProperty)},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/".concat(this.url),{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){this.code="",this.desc="",this.getDataRows(this.setProperty)},chang:function(e){this.$emit("change-lov",e)},setCode:function(e){for(var t in this.rows){var a=this.rows[t];if(a[this.propCode].toString()===e)return void(this.result=a[this.propCode]);this.$emit("id-not-match",this.result)}}},mounted:function(){this.code="",this.desc="",this.getDataRows(this.setProperty)},watch:{rows:function(e,t){e&&this.setCode(this.value)},value:function(e,t){e&&(this.code=e,this.desc="",this.getDataRows(this.setProperty))}}};var n=a(51900);const s=(0,n.Z)(o,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:e.placeholder,"remote-method":e.remoteMethod,loading:e.loading,name:e.attrName,clearable:!0},on:{change:e.chang,focus:e.focus},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(t,o){return a("el-option",{key:o,attrs:{label:t[e.propCodeDisp]+": "+t[e.propDescDisp],value:t[e.propCode]}})})),1)],1)}),[],!1,null,null,null).exports;const r={name:"ir-settings-company-lov-supplier",data:function(){return{rows:[],loading:!1,result:this.value?+this.value:this.value,first:!0}},props:["value","name","placeholder","size","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({vendor_id:"",keyword:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/vendor",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){this.result||this.getDataRows({vendor_id:"",keyword:""})},change:function(e){var t={code:"",desc:"",id:""};if(e){for(var a in this.rows)for(var o in this.rows){var n=this.rows[o];n.vendor_id==e&&(t.code=n.vendor_number,t.desc=n.vendor_name,t.id=e)}this.result=+e,this.getDataRows({vendor_id:e,keyword:""})}else t.code="",t.desc="",t.id="",this.result=e;this.$emit("change-lov",t)},onclick:function(){0===this.rows.length&&this.getDataRows({vendor_id:this.result,keyword:""})},onblur:function(){var e=this;this.rows.filter((function(t){t.vendor_id!=e.result&&(e.result="")}))}},watch:{value:function(e,t){this.first&&(this.result=e?+e:e,this.getDataRows({vendor_id:e,keyword:""}),this.first=!1)},result:function(e,t){var a={code:"",desc:"",id:e};this.$emit("change-lov",a)}}};const c=(0,n.Z)(r,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:e.placeholder,"remote-method":e.remoteMethod,loading:e.loading,name:e.name,clearable:!0,size:e.size,"popper-append-to-body":e.popperBody},on:{change:e.change,focus:e.focus,blur:e.onblur},nativeOn:{click:function(t){return e.onclick()}},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.vendor_number+": "+e.vendor_name,value:e.vendor_id}})})),1)],1)}),[],!1,null,null,null).exports;const i={name:"ir-settings-company-lov-customer",data:function(){return{rows:[],loading:!1,result:this.value?+this.value:this.value,first:!0}},props:["value","name","placeholder","size","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({customer_id:"",keyword:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/customer-number",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){this.result||this.getDataRows({customer_id:"",keyword:""})},change:function(e){var t={code:"",desc:"",id:""};if(e){for(var a in this.rows)for(var o in this.rows){var n=this.rows[o];n.customer_id==e&&(t.code=n.customer_number,t.desc=n.customer_name,t.id=e)}this.result=+e,this.getDataRows({customer_id:e,keyword:""})}else t.code="",t.desc="",t.id="";this.$emit("change-lov",t)},onclick:function(){0===this.rows.length&&this.getDataRows({customer_id:this.result,keyword:""})},onblur:function(){var e=this;this.rows.filter((function(t){t.customer_id!=e.result&&(e.result="")}))}},watch:{value:function(e,t){this.first&&(this.result=e?+e:e,this.getDataRows({customer_id:e,keyword:""}),this.first=!1)},result:function(e,t){var a={code:"",desc:"",id:e};this.$emit("change-lov",a)}}};const l=(0,n.Z)(i,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:e.placeholder,"remote-method":e.remoteMethod,loading:e.loading,name:e.name,clearable:!0,size:e.size,"popper-append-to-body":e.popperBody},on:{change:e.change,focus:e.focus,blur:e.onblur},nativeOn:{click:function(t){return e.onclick()}},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.customer_number+": "+e.customer_name,value:e.customer_id}})})),1)],1)}),[],!1,null,null,null).exports;var d=a(67791);function m(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,o)}return a}function u(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?m(Object(a),!0).forEach((function(t){p(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):m(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}function p(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}const h={name:"ir-settings-company-form",data:function(){return{rules:{company_number:[{required:!0,message:"กรุณาระบุรหัส",trigger:"blur"}],company_name:[{required:!0,message:"กรุณาระบุชื่อ",trigger:"blur"}],company_address:[{required:!0,message:"กรุณาระบุที่อยู่",trigger:"blur"}],vendor_id:[{required:!0,message:"กรุณาระบุรหัสเจ้าหนี้",trigger:"change"}],customer_id:[{required:!0,message:"กรุณาระบุรหัสลูกหนี้",trigger:"change"}],vendor_site_id:[{required:!0,message:"กรุณาระบุรหัสสาขา",trigger:"change"}]},branches:[],disabledBranch:!0,funcs:d.sD}},props:["company","action","btnTrans"],methods:{getDataVendor:function(e){this.company.vendor_id=e},getDataBranch:function(e){var t=this,a={vendor_id:e};axios.get("/ir/ajax/lov/branch-code",{params:a}).then((function(e){var a=e.data;t.disabledBranch=!1,t.branches=a.data})).catch((function(e){swal("Error",e,"error")}))},getDataCustomer:function(e){this.company.customer_id=e},clickSave:function(){var e=this;this.$refs.company.validate((function(t){if(!t)return!1;e.company.vendor_id,e.company.customer_id,e.company.vendor_site_id;e.actionSave(e.action)}))},clickCancel:function(){window.location.href="/ir/settings/company"},actionSave:function(e){var t=this;"add"===e||"edit"===e?this.company.active_flag:$(".form_company_active").is(":checked");this.company.active_flag;var a=u(u({},this.company),{},{active_flag:this.company.active_flag,vendor_id:this.company.vendor_id,customer_id:this.company.customer_id,company_id:this.company.company_id});if("add"===e)axios.get("/ir/ajax/check-duplicate/company",{params:a}).then((function(e){e.params;var a=u(u({},t.company),{},{active_flag:t.company.active_flag,program_code:"IRP0001"});axios.post("/ir/ajax/company",{data:a}).then((function(e){var t=e.data;swal({title:"Success",text:t.message,type:"success",showConfirmButton:!0},(function(e){window.location.href="/ir/settings/company"}))})).catch((function(e){400===e.response.data.status?swal("Warning",e.response.data.message,"warning"):swal("Error",e,"error")}))})).catch((function(e){400===e.response.data.status?swal("Warning",e.response.data.message,"warning"):swal("Error",e,"error")}));else{var o=u(u({},this.company),{},{active_flag:this.company.active_flag,program_code:"IRP0001"});axios.put("/ir/ajax/company",{data:o}).then((function(e){var t=e.data;swal({title:"Success",text:t.message,type:"success",showConfirmButton:!0},(function(e){window.location.href="/ir/settings/company"}))})).catch((function(e){400===e.response.data.status?swal("Warning",e.response.data.message,"warning"):swal("Error",e,"error")}))}},notVendorId:function(e){this.company.vendor_id=e},notCustomerId:function(e){this.company.customer_id=e},changeBranch:function(e){if(e)for(var t in this.branches){var a=this.branches[t];a.vendor_site_id==e&&(this.company.company_name=a.vendor_name,this.company.company_address=a.vendor_address,this.company.company_telephone=a.vendor_telephone,this.$refs.company_name.clearValidate(),this.$refs.company_address.clearValidate())}},getValueSupplier:function(e){this.company.vendor_id=e.id,e.id||(this.company.vendor_site_id="",this.company.company_name="",this.company.company_address="",this.company.company_telephone="",this.branches=[])},getValueCustomer:function(e){this.company.customer_id=e.id},changeActiveFlag:function(){axios.put("/ir/ajax/company/check-used-data/".concat(this.company.company_id)).then((function(e){e.data})).catch((function(e){400===e.response.data.status?swal({title:"Warning",text:e.response.data.message,type:"warning"},(function(e){e&&this.funcs.setDefaultActive("form_company_active")})):swal("Error",e,"error")}))}},components:{lovSearch:s,lovSupplier:c,lovCustomer:l},watch:{"company.vendor_id":function(e,t){e?this.getDataBranch(e):(this.disabledBranch=!0,this.company.vendor_site_id="")}}};const v=(0,n.Z)(h,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("el-form",{ref:"company",staticClass:"demo-ruleForm",attrs:{model:e.company,rules:e.rules,"label-width":"120px"}},[a("div",{staticClass:"col-lg-11"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("รหัส (Code) "),a("span",{staticClass:"text-danger"},[e._v(" * ")])])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"company_number"}},[a("el-input",{attrs:{placeholder:"รหัส",disabled:"",maxlength:"50"},model:{value:e.company.company_number,callback:function(t){e.$set(e.company,"company_number",t)},expression:"company.company_number"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ชื่อ (Name) "),a("span",{staticClass:"text-danger"},[e._v(" * ")])])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"company_name",attrs:{prop:"company_name"}},[a("el-input",{attrs:{placeholder:"ชื่อ",disabled:""},model:{value:e.company.company_name,callback:function(t){e.$set(e.company,"company_name",t)},expression:"company.company_name"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ที่อยู่ (Address) "),a("span",{staticClass:"text-danger"},[e._v(" * ")])])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"company_address",attrs:{prop:"company_address"}},[a("el-input",{attrs:{placeholder:"ที่อยู่",disabled:""},model:{value:e.company.company_address,callback:function(t){e.$set(e.company,"company_address",t)},expression:"company.company_address"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("โทรศัพท์ (Telephone)")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("el-input",{attrs:{placeholder:"โทรศัพท์",disabled:""},model:{value:e.company.company_telephone,callback:function(t){e.$set(e.company,"company_telephone",t)},expression:"company.company_telephone"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("รหัสเจ้าหนี้ (Supplier Number) "),a("span",{staticClass:"text-danger"},[e._v(" * ")])])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"vendor_id"}},[a("lov-supplier",{attrs:{name:"vendor",placeholder:"รหัสเจ้าหนี้",size:"",popperBody:!0},on:{"change-lov":e.getValueSupplier},model:{value:e.company.vendor_id,callback:function(t){e.$set(e.company,"vendor_id",t)},expression:"company.vendor_id"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("รหัสสาขา (Branch Number) *")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"vendor_site_id",attrs:{prop:"vendor_site_id"}},[a("el-select",{attrs:{placeholder:"รหัสสาขา",clearable:""},on:{change:e.changeBranch},model:{value:e.company.vendor_site_id,callback:function(t){e.$set(e.company,"vendor_site_id",t)},expression:"company.vendor_site_id"}},e._l(e.branches,(function(e,t){return a("el-option",{key:t,attrs:{label:e.vendor_site_code,value:e.vendor_site_id}})})),1)],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("รหัสลูกหนี้ (Customer Number) "),a("span",{staticClass:"text-danger"},[e._v(" * ")])])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"customer_id"}},[a("lov-customer",{attrs:{name:"customer",placeholder:"รหัสลูกหนี้",size:"",popperBody:!0},on:{"change-lov":e.getValueCustomer},model:{value:e.company.customer_id,callback:function(t){e.$set(e.company,"customer_id",t)},expression:"company.customer_id"}})],1)],1)]),e._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-md-5"}),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{staticStyle:{"margin-bottom":"0px"}},["add"===e.action?a("input",{directives:[{name:"model",rawName:"v-model",value:e.company.active_flag,expression:"company.active_flag"}],attrs:{type:"checkbox",id:"active_flag",name:"active_flag"},domProps:{checked:Array.isArray(e.company.active_flag)?e._i(e.company.active_flag,null)>-1:e.company.active_flag},on:{change:function(t){var a=e.company.active_flag,o=t.target,n=!!o.checked;if(Array.isArray(a)){var s=e._i(a,null);o.checked?s<0&&e.$set(e.company,"active_flag",a.concat([null])):s>-1&&e.$set(e.company,"active_flag",a.slice(0,s).concat(a.slice(s+1)))}else e.$set(e.company,"active_flag",n)}}}):a("input",{directives:[{name:"model",rawName:"v-model",value:e.company.active_flag,expression:"company.active_flag"}],staticClass:"form_company_active",attrs:{type:"checkbox",id:"active_flag",name:"active_flag"},domProps:{checked:Array.isArray(e.company.active_flag)?e._i(e.company.active_flag,null)>-1:e.company.active_flag},on:{change:function(t){var a=e.company.active_flag,o=t.target,n=!!o.checked;if(Array.isArray(a)){var s=e._i(a,null);o.checked?s<0&&e.$set(e.company,"active_flag",a.concat([null])):s>-1&&e.$set(e.company,"active_flag",a.slice(0,s).concat(a.slice(s+1)))}else e.$set(e.company,"active_flag",n)}}}),e._v(" "),e._v("\n            Active\n          ")])],1)])]),e._v(" "),a("div",{staticClass:"text-right"},[a("button",{class:e.btnTrans.save.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(t){return t.preventDefault(),e.clickSave()}}},[a("i",{class:e.btnTrans.save.icon}),e._v("\n          "+e._s(e.btnTrans.save.text)+"\n        ")]),e._v(" "),a("button",{class:e.btnTrans.cancel.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(t){return t.preventDefault(),e.clickCancel()}}},[a("i",{class:e.btnTrans.cancel.icon}),e._v("\n          "+e._s(e.btnTrans.cancel.text)+"\n        ")])])])],1)}),[],!1,null,null,null).exports}}]);