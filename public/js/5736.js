(self.webpackChunk=self.webpackChunk||[]).push([[5736],{45857:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el-form-item-irm0002{margin-bottom:10px}",""]);const i=a},82862:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el_select .el-select{width:100%}.padding_12{padding:12px}.margin_auto{margin:auto}",""]);const i=a},83993:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el_select .el-select{width:100%}",""]);const i=a},19829:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el_select .el-select{width:100%}",""]);const i=a},7337:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el_select .el-select{width:100%}",""]);const i=a},28010:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el_select .el-select{width:100%}",""]);const i=a},84662:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>i});var o=c(23645),a=c.n(o)()((function(t){return t[1]}));a.push([t.id,".el_select .el-select{width:100%}",""]);const i=a},12567:(t,e,c)=>{"use strict";c.d(e,{Z:()=>f});const o={name:"ir-select-option-policy-type",data:function(){return{typeCosts:[],loading:!1,type_cost:this.valueTypeCost}},props:["valueTypeCost","id_account"],mounted:function(){this.getTypeCosts({account_id:"",keyword:""})},methods:{remoteMethod:function(t){this.getTypeCosts({account_id:"",keyword:t})},getTypeCosts:function(t){var e=this;this.loading=!0,axios.get("/ir/ajax/lov/account-code-combine",{params:t}).then((function(t){var c=t.data;if(e.loading=!1,e.typeCosts=c.data,e.id_account)for(var o in e.typeCosts){var a=e.typeCosts[o];parseInt(e.id_account)===parseInt(a.account_id)&&(e.type_cost=a.account_code,e.callbackTypeCode(a.account_combine,a.account_id))}}))},change:function(t){if(t)for(var e in this.typeCosts){var c=this.typeCosts[e];t===c.account_code&&this.callbackTypeCode(c.account_combine,c.account_id)}else this.callbackTypeCode("","")},callbackTypeCode:function(t,e){this.$emit("typeCode",t,e)}},updated:function(){this.$nextTick((function(){var t=window.localStorage.getItem("data");JSON.parse(t);this.account_id=location.href.split("/")[7]}))},watch:{account_id:function(t,e){this.getTypeCosts({account_id:"",keyword:""})},id_account:function(t,e){this.getTypeCosts({account_id:"",keyword:""})}}};c(22153);var a=c(51900);const i=(0,a.Z)(o,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",{staticClass:"el_select"},[c("input",{attrs:{type:"hidden",name:"type_cost",autocomplete:"off"},domProps:{value:t.type_cost}}),t._v(" "),c("el-select",{attrs:{filterable:"",remote:"","remote-method":t.remoteMethod,loading:t.loading,clearable:!0,placeholder:"ประเภทค่าใช้จ่าย"},on:{change:t.change},model:{value:t.type_cost,callback:function(e){t.type_cost=e},expression:"type_cost"}},t._l(t.typeCosts,(function(t,e){return c("el-option",{key:e,attrs:{label:t.account_code+": "+t.description,value:t.account_code}})})),1)],1)}),[],!1,null,null,null).exports;const l={name:"ir-select-option-policy-type",data:function(){return{typeCosts:[],loading:!1,type_cost:this.valueTypeCost}},props:["valueTypeCost","id_account"],mounted:function(){this.getTypeCosts({account_id:"",keyword:""})},methods:{remoteMethod:function(t){this.getTypeCosts({account_id:"",keyword:t})},getTypeCosts:function(t){var e=this;this.loading=!0,axios.get("/ir/ajax/lov/account-code-combine",{params:t}).then((function(t){var c=t.data;if(e.loading=!1,e.typeCosts=c.data,e.id_account)for(var o in e.typeCosts){var a=e.typeCosts[o];parseInt(e.id_account)===parseInt(a.account_id)&&(e.type_cost=a.account_code,e.callbackTypeCode(a.account_combine,a.account_id))}}))},change:function(t){if(t)for(var e in this.typeCosts){var c=this.typeCosts[e];t===c.account_code&&this.callbackTypeCode(c.account_combine,c.account_id)}else this.callbackTypeCode("","")},callbackTypeCode:function(t,e){this.$emit("typeCode",t,e)}},updated:function(){this.$nextTick((function(){var t=window.localStorage.getItem("data");JSON.parse(t);this.account_id=location.href.split("/")[7]}))},watch:{account_id:function(t,e){this.getTypeCosts({account_id:"",keyword:""})},id_account:function(t,e){this.getTypeCosts({account_id:"",keyword:""})}}};c(23140);const s=(0,a.Z)(l,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",{staticClass:"el_select"},[c("input",{attrs:{type:"hidden",name:"type_cost",autocomplete:"off"},domProps:{value:t.type_cost}}),t._v(" "),c("el-select",{attrs:{filterable:"",remote:"","remote-method":t.remoteMethod,loading:t.loading,clearable:!0,placeholder:"ประเภทค่าใช้จ่าย"},on:{change:t.change},model:{value:t.type_cost,callback:function(e){t.type_cost=e},expression:"type_cost"}},t._l(t.typeCosts,(function(t,e){return c("el-option",{key:e,attrs:{label:t.account_code+": "+t.description,value:t.account_code}})})),1)],1)}),[],!1,null,null,null).exports;const n={name:"ir-select-policy-type",data:function(){return{policy:[],loading:!1,policy_type_code:"",account_id:""}},mounted:function(){this.getPolicies({account_id:"",keyword:""})},methods:{remoteMethod:function(t){this.getPolicies({department_code:"",keyword:t})},getPolicies:function(t){var e=this;this.loading=!0,axios.get("/ir/ajax/lov/department-code",{params:t}).then((function(t){var c=t.data;e.loading=!1,e.policy=c.data}))},change:function(t){if(t)for(var e in this.policy){var c=this.policy[e];t===c.account_code&&($('input[name="account_combine"]').val(c.account_combine),$('input[name="account_id"]').val(c.account_id))}else $('input[name="account_combine"]').val(""),$('input[name="account_id"]').val("")},updateDropdowns:function(t){this.$emit("policy",t)}},watch:{account_id:function(t,e){this.getPolicies({department_code:t,keyword:""})}}};c(95664);const r=(0,a.Z)(n,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",{staticClass:"el_select"},[c("input",{attrs:{type:"hidden",name:"policy_type_code",autocomplete:"off"},domProps:{value:t.policy_type_code}}),t._v(" "),c("el-select",{attrs:{filterable:"",remote:"","remote-method":t.remoteMethod,loading:t.loading,clearable:!0,placeholder:"แบบของการประกัน","validate-event":!0,required:""},on:{change:t.updateDropdowns},model:{value:t.policy_type_code,callback:function(e){t.policy_type_code=e},expression:"policy_type_code"}},t._l(t.policy,(function(t,e){return c("el-option",{key:e,attrs:{label:t.department_code+": "+t.description,value:t.department_code}})})),1)],1)}),[],!1,null,null,null).exports;const d={name:"ir-select-group",data:function(){return{groups:[],loading:!1,group_code:this.valueTypeCost,account_id:""}},props:["valueTypeCost"],mounted:function(){this.getGroupCode({account_id:"",keyword:""})},methods:{remoteMethod:function(){this.getGroupCode()},getGroupCode:function(){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/group-code").then((function(e){var c=e.data;t.loading=!1,t.groups=c.data}))},change:function(t){t?this.callbackGroupCode(t):this.callbackGroupCode("")},callbackGroupCode:function(t){this.$emit("group",t)}},updated:function(){this.$nextTick((function(){var t=window.localStorage.getItem("data");JSON.parse(t);this.account_id=location.href.split("/")[7]}))},watch:{valueTypeCost:function(t,e){this.group_code=t}}};c(28414);const p=(0,a.Z)(d,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",{staticClass:"el_select"},[c("input",{attrs:{type:"hidden",name:"group_code",autocomplete:"off"},domProps:{value:t.group_code}}),t._v(" "),c("el-select",{attrs:{filterable:"",remote:"","remote-method":t.remoteMethod,loading:t.loading,clearable:!0,placeholder:"กลุ่ม"},on:{change:t.change},model:{value:t.group_code,callback:function(e){t.group_code=e},expression:"group_code"}},t._l(t.groups,(function(t,e){return c("el-option",{key:e,attrs:{label:""+t.meaning,value:t.group_code}})})),1)],1)}),[],!1,null,null,null).exports;const u={name:"ir-select-group",data:function(){return{categories:[],loading:!1,policy_lookup:this.valueTypeCost,account_id:""}},props:["url","valueTypeCost"],mounted:function(){this.getPolicyCategory({account_id:"",keyword:""})},methods:{remoteMethod:function(){this.getPolicyCategory({account_id:"",keyword:query})},getPolicyCategory:function(){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/policy-category").then((function(e){var c=e.data;t.loading=!1,t.categories=c.data}))},change:function(t){t?this.callbackCategory(t):this.callbackCategory("")},callbackCategory:function(t){this.$emit("category",t)}},updated:function(){this.$nextTick((function(){var t=window.localStorage.getItem("data");JSON.parse(t);this.account_id=location.href.split("/")[7]}))},watch:{valueTypeCost:function(t,e){this.policy_lookup=t}}};c(74415);const _=(0,a.Z)(u,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",{staticClass:"el_select"},[c("input",{attrs:{type:"hidden",name:"policy_lookup",autocomplete:"off"},domProps:{value:t.policy_lookup}}),t._v(" "),c("el-select",{attrs:{filterable:"",remote:"","remote-method":t.remoteMethod,loading:t.loading,clearable:!0,placeholder:"ประเภทกรมธรรม์"},on:{change:t.change},model:{value:t.policy_lookup,callback:function(e){t.policy_lookup=e},expression:"policy_lookup"}},t._l(t.categories,(function(t,e){return c("el-option",{key:e,attrs:{label:""+t.description,value:t.lookup_code}})})),1)],1)}),[],!1,null,null,null).exports;var y=c(67791);const g={name:"ir-form-policy",data:function(){return{policyTypeCodes:[],id_account:"",id_account_gl:"",rules:{policy_set_number:[{required:!0,message:"กรุณาระบุชุดกรมธรรม์",trigger:"change"}],policy_set_description:[{required:!0,message:"กรุณาระบุคำอธิบาย",trigger:"change"}],policy_type_code:[{required:!0,message:"กรุณาระบุแบบของการประกัน",trigger:"change"}],policy_age:[{required:!0,message:"กรุณาระบุอายุกรมธรรม์",trigger:"change"}],type_cost:[{required:!0,message:"กรุณาระบุประเภทค่าใช้จ่าย",trigger:"change"}],account_combine:[{required:!0,message:"กรุณาระบุชุดรหัสบัญชี",trigger:"change"}],include_tax_flag:[{required:!0,message:"กรุณาระบุชุดกรมธรรม์",trigger:"change"}],group_code:[{required:!0,message:"กรุณาระบุกลุ่ม",trigger:"change"}],policy_category_code:[{required:!0,message:"กรุณาระบุประเภทกรมธรรม์",trigger:"change"}],account_combine_gl:[{required:!0,message:"กรุณาระบุชุดรหัสบัญชี",trigger:"change"}],gl_expense_account_id:[{required:!0,message:"กรุณาระบุประเภทค่าใช้จ่าย",trigger:"change"}]},funcs:y.sD}},props:["policy","updateUrl","btnTrans"],methods:{getPolicyTypeCodes:function(){var t=this;axios.get("/ir/ajax/lov/policy-type").then((function(e){var c=e.data;t.policyTypeCodes=c.data})).catch((function(t){}))},save:function(){var t=this;this.$refs.save_policy.validate((function(e){if(!e)return!1;if("edit"==t.policy.mode){var c=$(".form_company_active").is(":checked")?"Y":"N";axios.put("/ir/ajax/policy/update",{policy_set_header_id:t.policy.policy_set_header_id,policy_set_number:t.policy.policy_set_number,policy_set_description:t.policy.policy_set_description,policy_type_code:t.policy.policy_type_code,policy_age:t.policy.policy_age,type_cost:t.policy.type_cost,gl_expense_account_id:t.policy.gl_expense_account_id,include_tax_flag:t.policy.include_tax_flag?"Y":"N",account_combine:t.policy.account_combine,account_combine_gl:t.policy.account_combine_gl,policy_category_code:t.policy.policy_category_code,group_code:t.policy.group_code,active_flag:c,account_id:t.policy.account_id,account_id_gl:t.policy.account_id_gl}).then((function(t){swal({title:"Success",text:"บันทึกสำเร็จ",type:"success"},(function(t){window.location.href="/ir/settings/policy"}))})).catch((function(t){400===t.response.data.status?swal({title:"Warning",text:t.response.data.message,type:"warning"}):swal({title:"Error",text:t.response.data.message,type:"error"})}))}else axios.post("/ir/ajax/policy/save",{policy_set_number:t.policy.policy_set_number,policy_set_description:t.policy.policy_set_description,policy_type_code:t.policy.policy_type_code,policy_age:t.policy.policy_age,type_cost:t.policy.type_cost,gl_expense_account_id:t.policy.gl_expense_account_id,include_tax_flag:t.policy.include_tax_flag?"Y":"N",policy_category_code:t.policy.policy_category_code,group_code:t.policy.group_code,account_combine:t.policy.account_combine,account_combine_gl:t.policy.account_combine_gl,active_flag:t.policy.active_flag?"Y":"N",account_id:t.policy.account_id,account_id_gl:t.policy.account_id_gl,program_code:"IRM0002"}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success",showCancelButton:!1,showConfirmButton:!0},(function(t){window.location.href="/ir/settings/policy"}))})).catch((function(t){400===t.response.data.status?swal({title:"Warning",text:t.response.data.message,type:"warning"}):swal({title:"Error",text:t.response.data.message,type:"error"})}))}))},receivedTypeCode:function(t,e){this.policy.account_combine=t,this.policy.type_cost=e,this.policy.account_id=e},receivedTypeCodeGL:function(t,e){this.policy.account_combine_gl=t,this.policy.gl_expense_account_id=e,this.policy.account_id_gl=e},receivedGroupCode:function(t){this.policy.group_code=t},receivedPolicyCategory:function(t){this.policy.policy_category_code=t},clickCancel:function(){window.location.href="/ir/settings/policy"},changeActiveFlag:function(){var t=this;axios.put("/ir/ajax/policy/check-used-data/".concat(this.policy.policy_set_header_id)).then((function(t){t.data})).catch((function(e){400===e.response.data.status?swal({title:"Warning",text:e.response.data.message,type:"warning"},(function(e){e&&t.funcs.setDefaultActive("form_company_active")})):swal("Error",e,"error")}))},onlyNumeric:function(){}},computed:{disabledField:function(){return"edit"===this.policy.mode}},components:{"type-cost":i,"type-cost-gl":s,policy:r,"group-code":p,"policy-category":_},created:function(){this.getPolicyTypeCodes()}};c(22760);const f=(0,a.Z)(g,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",{staticClass:"mt-3"},[c("el-form",{ref:"save_policy",attrs:{model:t.policy,rules:t.rules}},[c("div",{staticClass:"row"},[c("div",{staticClass:"col-xl-7 col-md-7 col-sm-12 col-xs-12 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-sm-12 col-xs-12 col-form-label lable_align"},[c("strong",[t._v("กรมธรรม์ชุดที่ (Policy No) "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6 col-sm-12 col-xs-12 align-item-center"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"policy_set_number"}},[c("el-input",{attrs:{disabled:!0},model:{value:t.policy.policy_set_number,callback:function(e){t.$set(t.policy,"policy_set_number",e)},expression:"policy.policy_set_number"}})],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("คำอธิบาย (Description) "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"policy_set_description"}},[c("el-input",{model:{value:t.policy.policy_set_description,callback:function(e){t.$set(t.policy,"policy_set_description",e)},expression:"policy.policy_set_description"}})],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("แบบของการประกัน (Policy Type) "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"policy_type_code"}},[c("el-select",{staticClass:"w-100",attrs:{placeholder:"เลือก",clearable:!0},model:{value:t.policy.policy_type_code,callback:function(e){t.$set(t.policy,"policy_type_code",e)},expression:"policy.policy_type_code"}},t._l(t.policyTypeCodes,(function(t,e){return c("el-option",{key:e,attrs:{label:t.meaning,value:t.policy_type_code}})})),1)],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("อายุกรมธรรม์ "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-4 col-md-5 col-sm-11 col-xs-11"},[c("div",{staticClass:"input-group"},[c("el-form-item",{staticClass:"w-100 el-form-item-irm0002",attrs:{prop:"policy_age"}},[c("el-input-number",{staticClass:"w-100",attrs:{controls:!1},on:{input:t.onlyNumeric},model:{value:t.policy.policy_age,callback:function(e){t.$set(t.policy,"policy_age",e)},expression:"policy.policy_age"}})],1)],1)]),t._v(" "),c("label",{staticClass:"col-lg-1 col-md-1 col-sm-1 col-xs-1 col-form-label"},[c("strong",[t._v("ปี")])])])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("ประเภทค่าใช้จ่าย (AP) "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"type_cost"}},[c("type-cost",{attrs:{valueTypeCost:t.policy.id_account,id_account:t.policy.id_account},on:{typeCode:t.receivedTypeCode},model:{value:t.policy.type_cost,callback:function(e){t.$set(t.policy,"type_cost",e)},expression:"policy.type_cost"}})],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("รหัสบัญชีจ่ายล่วงหน้า "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"account_combine"}},[c("el-input",{attrs:{disabled:!0},model:{value:t.policy.account_combine,callback:function(e){t.$set(t.policy,"account_combine",e)},expression:"policy.account_combine"}})],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("ประเภทค่าใช้จ่าย (GL) "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"gl_expense_account_id"}},[c("type-cost-gl",{attrs:{valueTypeCost:t.policy.id_account_gl,id_account:t.policy.id_account_gl},on:{typeCode:t.receivedTypeCodeGL},model:{value:t.policy.gl_expense_account_id,callback:function(e){t.$set(t.policy,"gl_expense_account_id",e)},expression:"policy.gl_expense_account_id"}})],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("รหัสบัญชีตัดค่าใช้จ่ายล่วงหน้า "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"account_combine_gl"}},[c("el-input",{attrs:{disabled:!0},model:{value:t.policy.account_combine_gl,callback:function(e){t.$set(t.policy,"account_combine_gl",e)},expression:"policy.account_combine_gl"}})],1)],1)])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"}),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("div",{staticClass:"form-check mt-0 d-flex align-items-center"},[c("input",{directives:[{name:"model",rawName:"v-model",value:t.policy.include_tax_flag,expression:"policy.include_tax_flag"}],staticClass:"form-check-input mt-0",attrs:{type:"checkbox",id:"include_tax_flag",name:"include_tax_flag"},domProps:{checked:Array.isArray(t.policy.include_tax_flag)?t._i(t.policy.include_tax_flag,null)>-1:t.policy.include_tax_flag},on:{change:function(e){var c=t.policy.include_tax_flag,o=e.target,a=!!o.checked;if(Array.isArray(c)){var i=t._i(c,null);o.checked?i<0&&t.$set(t.policy,"include_tax_flag",c.concat([null])):i>-1&&t.$set(t.policy,"include_tax_flag",c.slice(0,i).concat(c.slice(i+1)))}else t.$set(t.policy,"include_tax_flag",a)}}}),t._v(" "),c("label",{staticClass:"form-check-label",attrs:{name:"active_flag",for:"include_tax_flag"}},[t._v("\n                      รวมภาษีมูลค่าเพิ่ม\n                  ")])])])])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row",attrs:{id:"policy-type-code"}},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("กลุ่ม "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("div",{staticClass:"mb-3"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"group_code"}},[c("group-code",{attrs:{required:"",valueTypeCost:t.policy.group_code},on:{group:t.receivedGroupCode},model:{value:t.policy.group_code,callback:function(e){t.$set(t.policy,"group_code",e)},expression:"policy.group_code"}})],1)],1)])])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row",attrs:{id:"policy-type-code"}},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"},[c("strong",[t._v("ประเภทกรมธรรม์ "),c("span",{staticClass:"text-danger"},[t._v(" * ")])])]),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("div",{staticClass:"mb-3"},[c("el-form-item",{staticClass:"el-form-item-irm0002",attrs:{prop:"policy_category_code"}},[c("policy-category",{attrs:{required:"",valueTypeCost:t.policy.policy_category_code},on:{category:t.receivedPolicyCategory},model:{value:t.policy.policy_category_code,callback:function(e){t.$set(t.policy,"policy_category_code",e)},expression:"policy.policy_category_code"}})],1)],1)])])]),t._v(" "),c("div",{staticClass:"col-xl-7 col-md-7 offset-md-2"},[c("div",{staticClass:"form-group row"},[c("label",{staticClass:"col-lg-5 col-md-6 col-form-label lable_align"}),t._v(" "),c("div",{staticClass:"col-lg-7 col-md-6"},[c("div",{staticClass:"form-check align-items-center d-flex"},["create"==t.policy.mode?c("input",{directives:[{name:"model",rawName:"v-model",value:t.policy.active_flag,expression:"policy.active_flag"}],staticClass:"form-check-input mt-0",attrs:{type:"checkbox",id:"active_flag",name:"active_flag"},domProps:{checked:Array.isArray(t.policy.active_flag)?t._i(t.policy.active_flag,null)>-1:t.policy.active_flag},on:{change:function(e){var c=t.policy.active_flag,o=e.target,a=!!o.checked;if(Array.isArray(c)){var i=t._i(c,null);o.checked?i<0&&t.$set(t.policy,"active_flag",c.concat([null])):i>-1&&t.$set(t.policy,"active_flag",c.slice(0,i).concat(c.slice(i+1)))}else t.$set(t.policy,"active_flag",a)}}}):c("input",{directives:[{name:"model",rawName:"v-model",value:t.policy.active_flag,expression:"policy.active_flag"}],staticClass:"form-check-input mt-0 form_company_active",attrs:{type:"checkbox",id:"active_flag",name:"active_flag"},domProps:{checked:Array.isArray(t.policy.active_flag)?t._i(t.policy.active_flag,null)>-1:t.policy.active_flag},on:{change:[function(e){var c=t.policy.active_flag,o=e.target,a=!!o.checked;if(Array.isArray(c)){var i=t._i(c,null);o.checked?i<0&&t.$set(t.policy,"active_flag",c.concat([null])):i>-1&&t.$set(t.policy,"active_flag",c.slice(0,i).concat(c.slice(i+1)))}else t.$set(t.policy,"active_flag",a)},function(e){return t.changeActiveFlag()}]}}),t._v(" "),c("label",{staticClass:"form-check-label",attrs:{for:"active_flag"}},[t._v("\n                    Active\n                  ")])])])])]),t._v(" "),c("div",{staticClass:"col-12 mt-3"},[c("div",{staticClass:"row clearfix m-t-lg text-right"},[c("div",{staticClass:"col-sm-12"},[c("button",{class:t.btnTrans.save.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.save()}}},[c("i",{class:t.btnTrans.save.icon}),t._v("\n              "+t._s(t.btnTrans.save.text)+"\n            ")]),t._v(" "),c("button",{class:t.btnTrans.cancel.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickCancel()}}},[c("i",{class:t.btnTrans.cancel.icon}),t._v("\n              "+t._s(t.btnTrans.cancel.text)+"\n            ")])])])])])])],1)}),[],!1,null,null,null).exports},35736:(t,e,c)=>{"use strict";c.r(e),c.d(e,{default:()=>g});function o(t,e){var c=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),c.push.apply(c,o)}return c}function a(t){for(var e=1;e<arguments.length;e++){var c=null!=arguments[e]?arguments[e]:{};e%2?o(Object(c),!0).forEach((function(e){i(t,e,c[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(c)):o(Object(c)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(c,e))}))}return t}function i(t,e,c){return e in t?Object.defineProperty(t,e,{value:c,enumerable:!0,configurable:!0,writable:!0}):t[e]=c,t}const l={name:"ir-index-header-policy",data:function(){return{policiesLov:[],policy:{id:"",desc:""},loading:!1,disabled:!1,status:"",options:[],tableLoading:!1,policiesList:[]}},props:["setDefaultActive","btnTrans"],mounted:function(){this.getPoliciesLov({policy_set_header_id:"",keyword:""}),this.getPolicy({policy_set_header_id:"",active_flag:""})},methods:{remoteMethod:function(t){""!==t?this.getPoliciesLov({policy_set_header_id:"",keyword:t}):this.policiesLov=[]},getPoliciesLov:function(t){var e=this;this.tableLoading=!0,axios.get("/ir/ajax/lov/policy-set-header",{params:t}).then((function(t){var c=t.data;e.tableLoading=!1,e.policiesLov=c.data}))},clickSearch:function(){var t={policy_set_header_id:this.policy.id,active_flag:this.status};this.getPolicy(t)},getPolicy:function(t){var e=this;e.tableLoading=!0,axios.get("/ir/ajax/policy",{params:t}).then((function(t){var c=t.data;e.tableLoading=!1,e.policiesList=c.data.map((function(t){return"Y"==t.active_flag?t.active_flag=!0:"N"==t.active_flag&&(t.active_flag=!1),t}))}))},clickClear:function(){this.policy_id="",this.status="",location.replace("/ir/settings/policy")},focusPolicies:function(t){this.getPoliciesLov({policy_set_header_id:""})},addPolicy:function(){window.location.replace("/ir/settings/policy/create")},clickEdit:function(t,e){window.location.href="/ir/settings/policy/edit/".concat(e.policy_set_header_id)},changeChecked:function(t,e){var c=this,o=a(a({},t),{},{active_flag:t.active_flag?"Y":"N"});axios.put("/ir/ajax/policy/active-flag",{data:o}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success"})})).catch((function(t){400===t.response.data.status?swal({title:"Warning",text:t.response.data.message,type:"warning"},(function(t){t&&c.setDefaultActive("table_company_active".concat(e))})):swal({title:"Error",text:t.response.data.message,type:"error"})}))},isChecked:function(t){return"Y"===t},getStatus:function(){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/status").then((function(e){var c=e.data;t.loading=!1,t.options=c}))}}};c(97554);var s=c(51900);const n=(0,s.Z)(l,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",[c("div",{staticClass:"row"},[c("div",{staticClass:"col-sm-4 el_select padding_12"},[c("el-select",{attrs:{filterable:"",placeholder:"ระบุชุดกรมธรรม์",name:"policy_desc","remote-method":t.remoteMethod,loading:t.loading,remote:"",disabled:t.disabled,clearable:!0},on:{focus:t.focusPolicies},model:{value:t.policy.id,callback:function(e){t.$set(t.policy,"id",e)},expression:"policy.id"}},t._l(t.policiesLov,(function(t){return c("el-option",{key:t.policy_set_header_id,attrs:{label:t.policy_set_number+" : "+t.policy_set_description,value:t.policy_set_header_id}})})),1)],1),t._v(" "),c("div",{staticClass:"col-sm-4 el_select padding_12"},[c("el-select",{attrs:{placeholder:"Status",name:"active_flag",clearable:!0},model:{value:t.status,callback:function(e){t.status=e},expression:"status"}},[c("el-option",{attrs:{label:"Active",value:"Y"}}),t._v(" "),c("el-option",{attrs:{label:"Inactive",value:"N"}})],1)],1),t._v(" "),c("div",{staticClass:"col-sm-4 padding_12 margin_auto"},[c("button",{class:t.btnTrans.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickSearch()}}},[c("i",{class:t.btnTrans.search.icon}),t._v("\n        "+t._s(t.btnTrans.search.text)+"\n      ")]),t._v(" "),c("button",{class:t.btnTrans.reset.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickClear()}}},[c("i",{class:t.btnTrans.reset.icon}),t._v("\n        "+t._s(t.btnTrans.reset.text)+"\n      ")])])]),t._v(" "),c("div",{staticClass:"table-responsive margin_top_20"},[c("table",{staticClass:"table table-bordered"},[t._m(0),t._v(" "),c("tbody",{attrs:{id:"table_total"}},[t._l(t.policiesList,(function(e,o){return c("tr",{directives:[{name:"show",rawName:"v-show",value:t.policiesList.length>0,expression:"policiesList.length > 0"}],key:o},[c("td",{staticClass:"text-center"},[t._v(t._s(e.policy_set_number))]),t._v(" "),c("td",[t._v(t._s(e.policy_set_description))]),t._v(" "),c("td",{staticClass:"text-center"},[t._v(t._s(e.policy_type_description))]),t._v(" "),c("td",{staticClass:"text-center"},[c("input",{directives:[{name:"model",rawName:"v-model",value:e.active_flag,expression:"data.active_flag"}],class:"table_company_active"+o,attrs:{type:"checkbox",id:"active_flag",name:"active_flag"},domProps:{checked:Array.isArray(e.active_flag)?t._i(e.active_flag,null)>-1:e.active_flag},on:{change:[function(c){var o=e.active_flag,a=c.target,i=!!a.checked;if(Array.isArray(o)){var l=t._i(o,null);a.checked?l<0&&t.$set(e,"active_flag",o.concat([null])):l>-1&&t.$set(e,"active_flag",o.slice(0,l).concat(o.slice(l+1)))}else t.$set(e,"active_flag",i)},function(c){return t.changeChecked(e,o)}]}})]),t._v(" "),c("td",{staticClass:"width_table text-center"},[c("button",{class:t.btnTrans.edit.class+" btn-sm tw-w-25",attrs:{type:"button"},on:{click:function(c){return c.preventDefault(),t.clickEdit(o,e)}}},[c("i",{class:t.btnTrans.edit.icon}),t._v("\n              "+t._s(t.btnTrans.edit.text)+"\n            ")])])])})),t._v(" "),c("tr",{directives:[{name:"show",rawName:"v-show",value:0===t.policiesList.length,expression:"policiesList.length === 0"}],staticClass:"text-center"},[c("td",{attrs:{colspan:"6"}},[t._v("ไม่มีข้อมูล")])])],2),t._v(" "),c("tfoot")])])])}),[function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("thead",[c("tr",{staticClass:"text-center"},[c("th",{staticClass:"text-center",staticStyle:{width:"150px"}},[t._v("กรมธรรม์ชุดที่"),c("br"),t._v("(Policy No)")]),t._v(" "),c("th",{staticClass:"text-center",staticStyle:{width:"450px"}},[t._v("คำอธิบาย"),c("br"),t._v("(Description)")]),t._v(" "),c("th",{staticClass:"text-center",staticStyle:{width:"300px"}},[t._v("แบบของการประกัน"),c("br"),t._v("(Policy Type)")]),t._v(" "),c("th",{staticClass:"text-center",staticStyle:{width:"80px","vertical-align":"middle"}},[t._v("Active")]),t._v(" "),c("th",{staticClass:"text-center",staticStyle:{width:"50px","vertical-align":"middle"}},[t._v("Action")])])])}],!1,null,null,null).exports;var r=c(12567),d=c(67791);function p(t,e){var c=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),c.push.apply(c,o)}return c}function u(t){for(var e=1;e<arguments.length;e++){var c=null!=arguments[e]?arguments[e]:{};e%2?p(Object(c),!0).forEach((function(e){_(t,e,c[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(c)):p(Object(c)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(c,e))}))}return t}function _(t,e,c){return e in t?Object.defineProperty(t,e,{value:c,enumerable:!0,configurable:!0,writable:!0}):t[e]=c,t}const y={components:{IndexHeader:n,FormPolicy:r.Z},name:"index-policy",props:["btnTrans"],data:function(){return{showIndex:!0,policy:{policy_set_number:"",policy_set_description:"",policy_type_code:"",policy_age:"",type_cost:"",account_combine:"",include_tax_flag:!0,active_flag:!0,policy_set_header_id:"",policyTypeCodes:[],group_code:"",policy_category_code:"",id_account:"",mode:"create"},funcs:d.sD}},methods:{clickEdit:function(t){var e=this;e.showIndex=t.showIndex,e.policy=u(u(u({},e.policy),t.row),{},{mode:"edit"})},changeModeCreate:function(){this.showIndex=!1}},computed:{textStatus:function(){return this.showIndex||"create"!==this.policy.mode?this.showIndex||"edit"!==this.policy.mode?"":" / Edit":" / Create"}}};const g=(0,s.Z)(y,(function(){var t=this,e=t.$createElement,c=t._self._c||e;return c("div",[c("index-header",{attrs:{setDefaultActive:t.funcs.setDefaultActive,"btn-trans":t.btnTrans},on:{"click-edit":t.clickEdit,changeMode:t.changeModeCreate}})],1)}),[],!1,null,null,null).exports},22760:(t,e,c)=>{var o=c(45857);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("6c8789a2",o,!0,{})},97554:(t,e,c)=>{var o=c(82862);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("557dece0",o,!0,{})},28414:(t,e,c)=>{var o=c(83993);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("680ce9a8",o,!0,{})},22153:(t,e,c)=>{var o=c(19829);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("4d06ae1c",o,!0,{})},23140:(t,e,c)=>{var o=c(7337);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("e8d382dc",o,!0,{})},74415:(t,e,c)=>{var o=c(28010);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("45276552",o,!0,{})},95664:(t,e,c)=>{var o=c(84662);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[t.id,o,""]]),o.locals&&(t.exports=o.locals);(0,c(45346).Z)("55481c5c",o,!0,{})}}]);