(self.webpackChunk=self.webpackChunk||[]).push([[6391],{53057:(e,t,a)=>{"use strict";a.d(t,{Z:()=>i});var s=a(23645),r=a.n(s)()((function(e){return e[1]}));r.push([e.id,"td[data-v-ddffa024],th[data-v-ddffa024]{padding:.25rem}th[data-v-ddffa024]{background:#fff;position:-webkit-sticky;position:sticky;top:0}.mouse-over[data-v-ddffa024]:hover{background-color:#d4edda!important}",""]);const i=r},26391:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>E});var s=a(12364),r=a(43126),i=a(21341),l=a(83030),n=a(30381),o=a.n(n),c=a(75943);const d={name:"ir-asset-plan-modal-fetch",data:function(){return{fetch:{year:"",insurance_start_date:"",insurance_end_date:"",policy_set_header_id_start:"",policy_set_header_id_end:"",as_of_date:"",asset_group:"",asset_status:""},rules:{year:[{required:!0,message:"กรุณาระบุปี",trigger:"change"}],as_of_date:[{required:!0,message:"กรุณาระบุ ณ วันที่",trigger:"change"}]},showLoading:!1}},props:["setYearCE","vars"],methods:{clickSearch:function(){var e=this;this.$refs.form_asset_plan_fetch.validate((function(t){if(!t)return!1;e.getDataRows()}))},clickClear:function(){this.resetFields()},validateNotElUi:function(e,t){e?this.$refs.form_asset_plan_fetch.fields.find((function(e){return e.prop==t})).clearValidate():this.$refs.form_asset_plan_fetch.validateField(t)},getDataRows:function(){var e=this;e.showLoading=!0;var t={year:this.setYearCE("year",e.fetch.year),insurance_start_date:e.setYearCE("date",e.fetch.insurance_start_date),insurance_end_date:e.setYearCE("date",e.fetch.insurance_end_date),program_code:"IRP0003",policy_set_header_start:e.fetch.policy_set_header_id_start,policy_set_header_end:e.fetch.policy_set_header_id_end,as_of_date:e.setYearCE("date",e.fetch.as_of_date),asset_group:e.fetch.asset_group,asset_status:e.fetch.asset_status};axios.get("/ir/ajax/asset/fetch",{params:t}).then((function(t){var a=t.data;"E"==a.status?(swal("Warning",a.msg,"warning"),e.showLoading=!1):"W"==a.status?(console.log("data.data <---\x3e",a.data),swal({title:"Warning",text:a.msg,type:"warning",showCancelButton:!1},(function(t){t&&(e.showLoading=!1,e.$emit("fetch-table-header",a.data),$("#modal_asset_plan_fetch").modal("hide"))}))):(e.showLoading=!1,e.$emit("fetch-table-header",a.data),$("#modal_asset_plan_fetch").modal("hide"))})).catch((function(t){swal({title:"Warning",text:"รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว",type:"warning",showCancelButton:!0}),e.showLoading=!1}))},getDataInsuranceDate:function(){var e=this,t={year:this.setYearCE("year",this.fetch.year),keyword:""};axios.get("/ir/ajax/lov/effective-date",{params:t}).then((function(t){var a=t.data.data;null===a?(e.$refs.fetch_insurance_start_date.resetField(),e.$refs.fetch_insurance_end_date.resetField()):(e.fetch.insurance_start_date=a.start_date_active,e.fetch.insurance_end_date=a.end_date_active)})).catch((function(e){swal("Error",e,"error")}))},resetFields:function(){this.$refs.form_asset_plan_fetch.resetFields()},getValuePolicyStModal:function(e){this.fetch.policy_set_header_id_start=e,this.fetch.policy_set_header_id_end=e},getValuePolicyEnModal:function(e){this.fetch.policy_set_header_id_end=e},getValueAssetGroupModal:function(e){this.fetch.asset_group=e.code},getValueYearModal:function(e){var t=this.vars.formatYear;e?this.fetch.year=o()(e).format(t):(this.fetch.year="",this.$refs.fetch_insurance_start_date.resetField(),this.$refs.fetch_insurance_end_date.resetField()),this.validateNotElUi(e,"year"),this.getDataInsuranceDate()},getValueAsOfDateModal:function(e){var t=this.vars.formatDate;e?this.fetch.as_of_date=o()(e).format(t):this.$refs.fetch_as_of_date.resetField(),this.validateNotElUi(e,"as_of_date")},getValueAssetStatusModal:function(e){this.fetch.asset_status=e}},components:{lovPolicySetHeaderId:r.Z,dateInput:i.Z,lovAssetGroup:l.Z,dropdownStatusAsset:c.Z}};var _=a(51900);const u=(0,_.Z)(d,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_asset_plan_fetch",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-md"},[a("div",{staticClass:"modal-content"},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:e.showLoading,expression:"showLoading"}]},[e._m(0),e._v(" "),a("el-form",{ref:"form_asset_plan_fetch",staticClass:"demo-dynamic form_table_line",attrs:{model:e.fetch,"label-width":"120px",rules:e.rules}},[a("div",{staticClass:"modal-body"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ปี *")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_year",attrs:{prop:"year"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"fetch_year","p-type":"year",placeholder:"ปี",value:e.fetch.year,format:e.vars.formatYear},on:{dateWasSelected:e.getValueYearModal}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("วันที่คุ้มครอง")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_insurance_start_date",attrs:{prop:"insurance_start_date"}},[a("el-input",{attrs:{placeholder:"วันที่คุ้มครอง",disabled:""},model:{value:e.fetch.insurance_start_date,callback:function(t){e.$set(e.fetch,"insurance_start_date",t)},expression:"fetch.insurance_start_date"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ถึง")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_insurance_end_date",attrs:{prop:"insurance_end_date"}},[a("el-input",{attrs:{placeholder:"ถึงวันที่คุ้มครอง",disabled:""},model:{value:e.fetch.insurance_end_date,callback:function(t){e.$set(e.fetch,"insurance_end_date",t)},expression:"fetch.insurance_end_date"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("กรมธรรม์ชุดที่")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_policy_set_header_id_start",attrs:{prop:"policy_set_header_id_start"}},[a("lov-policy-set-header-id",{attrs:{name:"fetch_policy_set_header_id_start",size:"",placeholder:"กรมธรรม์ชุดที่",popperBody:!1,fixTypeFr:"20",fixTypeSc:""},on:{"change-lov":e.getValuePolicyStModal},model:{value:e.fetch.policy_set_header_id_start,callback:function(t){e.$set(e.fetch,"policy_set_header_id_start",t)},expression:"fetch.policy_set_header_id_start"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ถึง")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_policy_set_header_id_end",attrs:{prop:"policy_set_header_id_end"}},[a("lov-policy-set-header-id",{attrs:{name:"fetch_policy_set_header_id_end",size:"",placeholder:"ถึงกรมธรรม์ชุดที่",popperBody:!1,fixTypeFr:"20",fixTypeSc:""},on:{"change-lov":e.getValuePolicyEnModal},model:{value:e.fetch.policy_set_header_id_end,callback:function(t){e.$set(e.fetch,"policy_set_header_id_end",t)},expression:"fetch.policy_set_header_id_end"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ณ วันที่ *")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_as_of_date",attrs:{prop:"as_of_date"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"fetch_as_of_date","p-type":"date",placeholder:"ณ วันที่",value:e.fetch.as_of_date,format:e.vars.formatDate},on:{dateWasSelected:e.getValueAsOfDateModal}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("กลุ่มของทรัพย์สิน")])]),e._v(" "),a("div",{staticClass:"col-lg-5 col-md-6 el_field"},[a("el-form-item",{ref:"fetch_asset_group",attrs:{prop:"asset_group"}},[a("lov-asset-group",{attrs:{placeholder:"กลุ่มของทรัพย์สิน",name:"fetch_asset_group",size:"",popperBody:!1},on:{"change-lov":e.getValueAssetGroupModal},model:{value:e.fetch.asset_group,callback:function(t){e.$set(e.fetch,"asset_group",t)},expression:"fetch.asset_group"}})],1)],1)])]),e._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-success",attrs:{type:"button"},on:{click:function(t){return e.clickSearch()}}},[a("i",{staticClass:"fa fa-database"}),e._v(" ดึงข้อมูล\n          ")]),e._v(" "),a("button",{staticClass:"btn btn-warning",attrs:{type:"button"},on:{click:function(t){return e.clickClear()}}},[a("i",{staticClass:"fa fa-repeat"}),e._v(" รีเซต\n          ")])])])],1)])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[e._v("×")]),a("span",{staticClass:"sr-only"},[e._v("Close")])]),e._v(" "),a("p",{staticClass:"modal-title text-left"},[e._v("การดึงข้อมูล")])])}],!1,null,null,null).exports;var h=a(87150);const f={name:"ir-asset-plan-index-search",data:function(){return{rules:{year:[{required:!0,message:"กรุณาระบุปี",trigger:"change"}],as_of_date:[{required:!0,message:"กรุณาระบุ ณ วันที่",trigger:"change"}]},status:[],getTimeInsuSt:"",getTimeInsuEn:"",policies:[],loading:!1}},props:["search","setYearCE","vars"],computed:{checkInsuranceDate:function(){var e=this.search.insurance_start_date,t=this.search.insurance_end_date;return!e||!t||this.getTimeInsuSt<=this.getTimeInsuEn}},methods:{clickSearch:function(){var e=this;this.$refs.search_index_asset_plan.validate((function(t){if(!t)return console.log("error submit!!"),!1;e.reqDate()&&e.$emit("click-search",e.search)}))},clickClear:function(){window.location.href="/ir/assets/asset-plan"},getDataStatus:function(){var e=this;axios.get("/ir/ajax/lov/status").then((function(t){var a=t.data;console.log("response getDataStatus ",a),e.status=a})).catch((function(e){swal("Error",e,"error")}))},getDataAssetGroup:function(e){this.search.asset_group=e},reqDate:function(){if(this.checkInsuranceDate)return!0;swal("Warning","ฟิลด์วันที่คุ้มครองต้องน้อยกว่าหรือเท่ากับฟิลด์วันที่คุ้มครองถึง!","warning")},getDataPolicySetHeaderId:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/policy-set-header",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.policies=a.data})).catch((function(e){swal("Error",e,"error")}))},remoteMethodPolicySt:function(e){this.getDataPolicySetHeaderId({policy_set_header_id:"",keyword:e,type:"20",type2:""})},focusPolicySt:function(e){this.getDataPolicySetHeaderId({policy_set_header_id:"",keyword:"",type:"20",type2:""})},changePolicySt:function(e){this.search.policy_set_header_id_start=e,this.search.policy_set_header_id_end=e},remoteMethodPolicyEn:function(e){this.getDataPolicySetHeaderId({policy_set_header_id:"",keyword:e,type:"20",type2:""})},focusPolicyEn:function(e){this.getDataPolicySetHeaderId({policy_set_header_id:"",keyword:"",type:"20",type2:""})},changePolicyEn:function(e){console.log("changePolicyEn ",e),this.search.policy_set_header_id_end=e},getDataInsuranceDate:function(e){var t=this;axios.get("/ir/ajax/lov/effective-date",{params:e}).then((function(e){var a=e.data.data;null===a?(t.search.insurance_start_date="",t.search.insurance_end_date=""):(t.search.insurance_start_date=a.start_date_active,t.search.insurance_end_date=a.end_date_active)})).catch((function(e){swal("Error",e,"error")}))},clickCancel:function(){window.location.href="/ir/assets/asset-plan"},fetchTableHeader:function(e){this.$emit("fetch-show-table-header",e)},clickFetch:function(){this.$refs.modal_fetch.resetFields()},getValueYear:function(e){var t=this.vars.formatYear;e?(this.search.year=o()(e).format(t),this.getDataInsuranceDate({year:this.setYearCE("year",this.search.year),keyword:""})):(this.search.year="",this.search.insurance_start_date="",this.search.insurance_end_date="",this.getDataInsuranceDate({year:this.search.year,keyword:""}))},getValueAsOfDate:function(e){var t=this.vars.formatDate;this.search.as_of_date=e?o()(e).format(t):""},getValueAssetStatus:function(e){this.search.asset_status=e},getValueStatus:function(e){this.search.status=e}},components:{lovAssetGroup:s.Z,modalFetch:u,dropdownStatusAsset:c.Z,dropdownStatusIr:h.Z},mounted:function(){this.getDataPolicySetHeaderId({policy_set_header_id:"",keyword:"",type:"20",type2:""})}};const p=(0,_.Z)(f,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("el-form",{ref:"search_index_asset_plan",staticClass:"demo-ruleForm",attrs:{model:e.search,"label-width":"120px"}},[a("div",{staticClass:"col-lg-11"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ปี")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"year"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"year","p-type":"year",placeholder:"ปี",value:e.search.year,format:e.vars.formatYear},on:{dateWasSelected:e.getValueYear}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("วันที่คุ้มครอง")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("el-input",{attrs:{placeholder:"วันที่คุ้มครอง",disabled:""},model:{value:e.search.insurance_start_date,callback:function(t){e.$set(e.search,"insurance_start_date",t)},expression:"search.insurance_start_date"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ถึง")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("el-input",{attrs:{placeholder:"ถึงวันที่คุ้มครอง",disabled:""},model:{value:e.search.insurance_end_date,callback:function(t){e.$set(e.search,"insurance_end_date",t)},expression:"search.insurance_end_date"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("กรมธรรม์ชุดที่")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("el-select",{attrs:{placeholder:"กรมธรรม์ชุดที่",name:"policy_set_header_id_start","remote-method":e.remoteMethodPolicySt,loading:e.loading,remote:"",clearable:!0,filterable:""},on:{focus:e.focusPolicySt,change:e.changePolicySt},model:{value:e.search.policy_set_header_id_start,callback:function(t){e.$set(e.search,"policy_set_header_id_start",t)},expression:"search.policy_set_header_id_start"}},e._l(e.policies,(function(e,t){return a("el-option",{key:t,attrs:{label:e.policy_set_number+": "+e.policy_set_description,value:e.policy_set_header_id}})})),1)],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ถึง")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("el-select",{attrs:{placeholder:"ถึงกรมธรรม์ชุดที่",name:"policy_set_header_id_end","remote-method":e.remoteMethodPolicyEn,loading:e.loading,remote:"",clearable:!0,filterable:""},on:{focus:e.focusPolicyEn,change:e.changePolicyEn},model:{value:e.search.policy_set_header_id_end,callback:function(t){e.$set(e.search,"policy_set_header_id_end",t)},expression:"search.policy_set_header_id_end"}},e._l(e.policies,(function(e,t){return a("el-option",{key:t,attrs:{label:e.policy_set_number+": "+e.policy_set_description,value:e.policy_set_header_id}})})),1)],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ณ วันที่")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"as_of_date"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"as_of_date","p-type":"date",placeholder:"ณ วันที่",value:e.search.as_of_date,format:e.vars.formatDate},on:{dateWasSelected:e.getValueAsOfDate}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("กลุ่มของทรัพย์สิน")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("lov-asset-group",{attrs:{attrName:"asset_group",isTable:!1,size:""},on:{"change-value-asset-group":e.getDataAssetGroup},model:{value:e.search.asset_group,callback:function(t){e.$set(e.search,"asset_group",t)},expression:"search.asset_group"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("สถานะ")])]),e._v(" "),a("div",{staticClass:"col-xl-4 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("dropdown-status-ir",{attrs:{name:"status",size:"",popperBody:!0,disabled:!1,placeholder:"สถานะ"},on:{"change-lov":e.getValueStatus},model:{value:e.search.status,callback:function(t){e.$set(e.search,"status",t)},expression:"search.status"}})],1)],1)])]),e._v(" "),a("div",{staticClass:"text-right el_field"},[a("el-form-item",[a("button",{staticClass:"btn btn-default",attrs:{type:"button"},on:{click:function(t){return e.clickSearch()}}},[a("i",{staticClass:"fa fa-search"}),e._v(" ค้นหา\n        ")]),e._v(" "),a("button",{staticClass:"btn btn-success",attrs:{type:"button","data-toggle":"modal","data-target":"#modal_asset_plan_fetch"},on:{click:function(t){return e.clickFetch()}}},[a("i",{staticClass:"fa fa-database"}),e._v(" ดึงข้อมูล\n        ")]),e._v(" "),a("button",{staticClass:"btn btn-warning",attrs:{type:"button"},on:{click:function(t){return e.clickCancel()}}},[a("i",{staticClass:"fa fa-repeat"}),e._v(" รีเซต\n        ")])])],1)]),e._v(" "),a("modal-fetch",{ref:"modal_fetch",attrs:{setYearCE:e.setYearCE,vars:e.vars},on:{"fetch-table-header":e.fetchTableHeader}})],1)}),[],!1,null,null,null).exports;const v={name:"ir-asset-plan-index-table-header",data:function(){return{activeIndex:""}},props:["isNullOrUndefined","tableHeader","formatCurrency","search","setFirstLetterUpperCase","showYearBE","checkStatusNew"],methods:{clickRow:function(e,t){var a={header_id:e.header_id,document_number:this.isNullOrUndefined(e.document_number),asset_status:this.isNullOrUndefined(e.asset_status),policy_set_description:this.isNullOrUndefined(e.policy_set_description),policy_set_header_id:this.isNullOrUndefined(e.policy_set_header_id),status:this.isNullOrUndefined(e.status),count_asset:this.isNullOrUndefined(e.count_asset),as_of_date:this.isNullOrUndefined(e.as_of_date),insurance_start_date:this.isNullOrUndefined(e.insurance_start_date),insurance_end_date:this.isNullOrUndefined(e.insurance_end_date),year:this.isNullOrUndefined(e.year),total_cost:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_cost),total_cover_amount:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_cover_amount),total_insu_amount:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_insu_amount),total_vat_amount:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_vat_amount),total_net_amount:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_net_amount),total_rec_insu_amount:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_rec_insu_amount),receivables:e.type,total_duty_amount:this.checkStatusNew(e.status)?0:this.isNullOrUndefined(e.total_duty_amount)};this.$emit("click-row",a),this.activeIndex=t}},watch:{tableHeader:function(e,t){this.activeIndex=""}}};var m=a(93379),g=a.n(m),b=a(53057),y={insert:"head",singleton:!1};g()(b.Z,y);b.Z.locals;const w=(0,_.Z)(v,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-bordered",staticStyle:{display:"block",overflow:"auto","max-height":"500px"}},[e._m(0),e._v(" "),a("tbody",{attrs:{id:"table_search"}},[e._l(e.tableHeader,(function(t,s){return a("tr",{directives:[{name:"show",rawName:"v-show",value:e.tableHeader.length>0,expression:"tableHeader.length > 0"}],key:s,staticClass:"mouse-over",class:"style_row_show "+(s===e.activeIndex?"highlight":""),on:{click:function(a){return e.clickRow(t,s)}}},[a("td",{staticClass:"text-center"},[a("a",{staticClass:"btn btn-warning btn-xs",attrs:{type:"button",href:"/ir/assets/asset-plan/edit/"+t.header_id}},[e.isNullOrUndefined(t.document_number)?a("span",[e._v("View / Edit")]):a("span",[e._v("Select")])])]),e._v(" "),a("td",[e._v(e._s(e.isNullOrUndefined(t.document_number)))]),e._v(" "),a("td",[e._v(e._s(e.isNullOrUndefined(t.reference_document_number)))]),e._v(" "),a("td",[e._v(e._s(e.setFirstLetterUpperCase(t.status)))]),e._v(" "),a("td",{staticClass:"text-center"},[e._v(e._s(e.showYearBE("year",t.year)))]),e._v(" "),a("td",{staticClass:"text-center"},[e._v("\n          "+e._s(e.isNullOrUndefined(t.policy_set_number))+"\n        ")]),e._v(" "),a("td",[e._v(e._s(e.isNullOrUndefined(t.policy_set_description)))]),e._v(" "),a("td",{staticClass:"text-right"},[e._v(e._s(e.formatCurrency(t.count_asset)))]),e._v(" "),a("td",{staticClass:"text-center"},[e._v(e._s(e.showYearBE("date",t.as_of_date)))]),e._v(" "),a("td",{staticClass:"text-center"},[e._v(e._s(e.showYearBE("date",t.insurance_start_date)))]),e._v(" "),a("td",{staticClass:"text-center"},[e._v(e._s(e.showYearBE("date",t.insurance_end_date)))])])})),e._v(" "),0===e.tableHeader.length?a("tr",{staticClass:"text-center mouse-over"},[a("td",{attrs:{colspan:"11"}},[e._v("ไม่มีข้อมูล")])]):e._e()],2),e._v(" "),a("tfoot")])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("thead",[a("tr",[a("th",{staticClass:"text-center",staticStyle:{"min-width":"120px"}},[e._v("Action")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"200px"}},[e._v("Document Number "),a("br"),e._v("เลขที่เอกสาร")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"200px"}},[e._v("Reference "),a("br"),e._v("Document")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[e._v("IR Status "),a("br"),e._v("สถานะ")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[e._v("Year "),a("br"),e._v("ปี")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"130px"}},[e._v("Policy No. "),a("br"),e._v("กรมธรรม์ชุดที่")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"200px",width:"1%"}},[e._v("Policy Description "),a("br"),e._v("รายละเอียดกรมธรรม์ชุดที่")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"120px"}},[e._v("Count "),a("br"),e._v("จำนวนรายการ")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"140px"}},[e._v("As Of Date "),a("br"),e._v("ณ วันที่")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"140px"}},[e._v("วันที่คุ้มครองตั้งแต่")]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"140px"}},[e._v("วันที่คุ้มครองถึง")])])])}],!1,null,"ddffa024",null).exports;function C(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var a=[],s=!0,r=!1,i=void 0;try{for(var l,n=e[Symbol.iterator]();!(s=(l=n.next()).done)&&(a.push(l.value),!t||a.length!==t);s=!0);}catch(e){r=!0,i=e}finally{try{s||null==n.return||n.return()}finally{if(r)throw i}}return a}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return x(e,t);var a=Object.prototype.toString.call(e).slice(8,-1);"Object"===a&&e.constructor&&(a=e.constructor.name);if("Map"===a||"Set"===a)return Array.from(e);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return x(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function x(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,s=new Array(t);a<t;a++)s[a]=e[a];return s}const k={name:"ir-asset-plan-index-table-total",data:function(){return{}},props:["tableTotal","formatCurrency","isNullOrUndefined","statusRowTableHeader","checkStatusNew","receivables"],computed:{newDataReceivables:function(){return Array.from(this.receivables.reduce((function(e,t){var a=t.receivable_name,s=t.net_amount;return e.set(a,(e.get(a)||0)+ +s)}),new Map),(function(e){var t=C(e,2);return{receivable_name:t[0],net_amount:t[1]}}))},totalRecInsuAmount:function(){var e=0;return this.receivables.filter((function(t){e+=+Number(t.net_amount).toFixed(2)})),e}},methods:{setZeroWhenIsNullOrUndefined:function(e){return""===e||null==e||isNaN(e)?this.formatCurrency("0"):this.formatCurrency(e)},formatSum:function(e,t,a){return Number(Number(Number(e).toFixed(2))+Number(Number(t).toFixed(2))+Number(Number(a).toFixed(2))).toLocaleString("en-US",{minimumFractionDigits:2,maximumFractionDigits:2})},formatData:function(e,t){var a=0;return t.filter((function(t){t.receivable_name==e&&(a+=+Number(t.net_amount).toFixed(2))})),a}}};const S=(0,_.Z)(k,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"table-responsive margin_top_20"},[a("table",{staticClass:"table table-striped"},[e._m(0),e._v(" "),a("tbody",{attrs:{id:"table_total"}},[e._l(e.tableTotal,(function(t,s){return a("tr",{directives:[{name:"show",rawName:"v-show",value:e.tableTotal.length>0,expression:"tableTotal.length > 0"}],key:s,staticClass:"text-right"},[a("td",[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.total_cost)))]),e._v(" "),a("td",[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.total_cover_amount)))]),e._v(" "),a("td",[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.total_insu_amount)))]),e._v(" "),a("td",[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.total_duty_amount)))]),e._v(" "),a("td",[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.total_vat_amount)))]),e._v(" "),a("td",[e._v(e._s(e.formatSum(t.total_insu_amount,t.total_duty_amount,t.total_vat_amount)))]),e._v(" "),a("td",[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.total_rec_insu_amount)))])])})),e._v(" "),e._l(e.newDataReceivables,(function(t,s){return a("tr",{directives:[{name:"show",rawName:"v-show",value:e.receivables.length>0&&e.tableTotal.length>0&&!e.checkStatusNew(e.statusRowTableHeader),expression:"receivables.length > 0 && tableTotal.length > 0 && !checkStatusNew(statusRowTableHeader)"}],key:"rec_"+s,staticClass:"text-right"},[a("td",{attrs:{colspan:"6"}},[e._v(e._s(e.isNullOrUndefined(t.receivable_name)))]),e._v(" "),a("td",[e._v(e._s(e.formatCurrency(e.formatData(t.receivable_name,e.receivables))))])])})),e._v(" "),0===e.tableTotal.length?a("tr",{staticClass:"text-center"},[a("td",{attrs:{colspan:"7"}},[e._v("ไม่มีข้อมูล")])]):e._e()],2),e._v(" "),a("tfoot")])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("thead",[a("tr",{staticClass:"text-right"},[a("th",{staticClass:"width_table"},[e._v("Total Asset Cost "),a("br"),e._v("ราคาทุนรวม (บาท)")]),e._v(" "),a("th",{staticClass:"width_table"},[e._v("Total Coverage Amount "),a("br"),e._v("มูลค่าทุนประกันรวม")]),e._v(" "),a("th",{staticClass:"width_table"},[e._v("Total Premium "),a("br"),e._v("ค่าเบี้ยประกันรวม")]),e._v(" "),a("th",{staticClass:"width_table"},[e._v("Total Duty Fee "),a("br"),e._v("อากรรวม")]),e._v(" "),a("th",{staticClass:"width_table"},[e._v("Total Vat "),a("br"),e._v("ภาษีมูลค่าเพิ่มรวม")]),e._v(" "),a("th",{staticClass:"width_table"},[e._v("Total Net Amount "),a("br"),e._v("ค่าเบี้ยประกันสุทธิรวม")]),e._v(" "),a("th",{staticClass:"width_table",staticStyle:{"vertical-align":"middle"}},[e._v("ค่าเบี้ยประกันเรียกเก็บสุทธิรวม")])])])}],!1,null,null,null).exports;var N=a(67791);const D={name:"ir-asset-plan-index",data:function(){return{search:{year:"",insurance_start_date:"",insurance_end_date:"",policy_set_header_id_start:"",policy_set_header_id_end:"",as_of_date:"",asset_group:"",asset_status:"",status:""},tableHeader:[],tableTotal:[],headerRow:{header_id:"",document_number:"",status:"",year:"",policy_set_header_id:"",policy_set_description:"",count_asset:"",as_of_date:"",insurance_start_date:"",insurance_end_date:"",total_cost:"",total_cover_amount:"",total_insu_amount:"",total_vat_amount:"",total_net_amount:"",total_rec_insu_amount:"",total_duty_amount:""},year:"",funcs:N.sD,vars:N.gR,statusRowTableHeader:"",receivables:[],showLoading:!1}},methods:{getDataSearch:function(e){this.search=e,this.getDataRowsTableHeader()},getDataRowShowTableTotal:function(e){this.tableTotal=[e],this.statusRowTableHeader=e.status,this.receivables=e.receivables},getDataRowsTableHeader:function(){var e=this;this.showLoading=!0;var t={year:this.funcs.setYearCE("year",this.search.year),insurance_start_date:this.funcs.setYearCE("date",this.search.insurance_start_date),insurance_end_date:this.funcs.setYearCE("date",this.search.insurance_end_date),policy_set_header_start:this.search.policy_set_header_id_start,policy_set_header_end:this.search.policy_set_header_id_end,as_of_date:this.funcs.setYearCE("date",this.search.as_of_date),location_code:this.search.asset_group,asset_status:this.search.asset_status,status:this.search.status};axios.get("/ir/ajax/asset",{params:t}).then((function(t){var a=t.data;e.showLoading=!1,e.tableHeader=a.data,e.tableTotal=[]})).catch((function(e){swal("Error",e,"error")}))},fetchShowTableHeader:function(e){this.tableHeader=e,this.tableTotal=[]}},components:{indexSearch:p,indexTableHeader:w,indexTableTotal:S}};const E=(0,_.Z)(D,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:e.showLoading,expression:"showLoading"}]},[a("index-search",{attrs:{search:e.search,setYearCE:e.funcs.setYearCE,vars:e.vars},on:{"click-search":e.getDataSearch,"fetch-show-table-header":e.fetchShowTableHeader}}),e._v(" "),a("index-table-header",{attrs:{isNullOrUndefined:e.funcs.isNullOrUndefined,tableHeader:e.tableHeader,formatCurrency:e.funcs.formatCurrency,search:e.search,setFirstLetterUpperCase:e.funcs.setFirstLetterUpperCase,showYearBE:e.funcs.showYearBE,checkStatusNew:e.funcs.checkStatusNew},on:{"click-row":e.getDataRowShowTableTotal}}),e._v(" "),a("index-table-total",{attrs:{tableTotal:e.tableTotal,formatCurrency:e.funcs.formatCurrency,isNullOrUndefined:e.funcs.isNullOrUndefined,statusRowTableHeader:e.statusRowTableHeader,checkStatusNew:e.funcs.checkStatusNew,receivables:e.receivables}})],1)}),[],!1,null,null,null).exports},12364:(e,t,a)=>{"use strict";a.d(t,{Z:()=>r});const s={name:"ir-asset-plan-lov-asset-group",data:function(){return{assetGroup:[],loading:!1,asset_group_code:this.value}},props:["attrName","value","isTable","indexTable","size"],methods:{remoteMethodAssetGroup:function(e){this.getAssetGroup({meaning:"",keyword:e})},getAssetGroup:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/location",{params:e}).then((function(e){var a=e.data.data;t.loading=!1,t.assetGroup=a})).catch((function(e){swal("Error",e,"error")}))},focusAssetGroup:function(e){this.getAssetGroup({meaning:"",keyword:""})},changeAssetGroup:function(e){var t={asset_group:"",rowId:"",asset_group_name:"",id:""};if(this.isTable&&e)for(var a in this.assetGroup){var s=this.assetGroup[a];s.meaning===e&&(t.asset_group=e,t.rowId=this.indexTable,t.asset_group_name=s.description,t.id=s.value,this.$emit("change-value-asset-group",t))}else this.isTable&&!e?this.$emit("change-value-asset-group",t):this.$emit("change-value-asset-group",e)}},mounted:function(){this.getAssetGroup({meaning:"",keyword:""})},watch:{value:function(e,t){this.asset_group_code=e}}};const r=(0,a(51900).Z)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_select"},[a("el-select",{attrs:{placeholder:"กลุ่มของทรัพย์สิน",name:e.attrName,"remote-method":e.remoteMethodAssetGroup,loading:e.loading,remote:"",clearable:!0,filterable:"",size:e.size},on:{focus:e.focusAssetGroup,change:e.changeAssetGroup},model:{value:e.asset_group_code,callback:function(t){e.asset_group_code=t},expression:"asset_group_code"}},e._l(e.assetGroup,(function(e,t){return a("el-option",{key:t,attrs:{label:e.meaning+": "+e.description,value:e.meaning}})})),1)],1)}),[],!1,null,null,null).exports},75943:(e,t,a)=>{"use strict";a.d(t,{Z:()=>r});const s={name:"ir-components-dropdown-status-asset",data:function(){return{rows:[{label:"Active",value:"Y"},{label:"Inactive",value:"N"}],loading:!1,result:this.value}},props:["value","name","size","popperBody","disabled","placeholder"],methods:{onchange:function(e){this.$emit("change-dropdown",e)}},watch:{value:function(e,t){this.result=e}}};const r=(0,a(51900).Z)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,clearable:!0,size:e.size,"popper-append-to-body":e.popperBody,disabled:e.disabled},on:{change:e.onchange},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.label,value:e.value}})})),1)],1)}),[],!1,null,null,null).exports},87150:(e,t,a)=>{"use strict";a.d(t,{Z:()=>r});const s={name:"ir-components-lov-status-ir",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","size","popperBody","disabled","placeholder"],methods:{getDataRows:function(){var e=this;axios.get("/ir/ajax/lov/status").then((function(t){var a=t.data;e.rows=a})).catch((function(e){swal("Error",e,"error")}))},change:function(e){this.$emit("change-lov",e)}},watch:{value:function(e,t){this.result=e}},created:function(){this.getDataRows()}};const r=(0,a(51900).Z)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:"สถานะ",name:e.name,clearable:!0,size:e.size,"popper-append-to-body":e.popperBody,disabled:e.disabled},on:{change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.description,value:e.lookup_code}})})),1)],1)}),[],!1,null,null,null).exports},83030:(e,t,a)=>{"use strict";a.d(t,{Z:()=>r});const s={name:"ir-components-lov-asset-group",data:function(){return{rows:[],loading:!1,result:this.value}},props:["placeholder","name","value","size","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({meaning:"",keyword:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/location",{params:e}).then((function(e){var a=e.data.data;t.loading=!1,t.rows=a})).catch((function(e){swal("Error",e,"error")}))},focus:function(e){this.getDataRows({meaning:"",keyword:""})},change:function(e){var t={id:"",code:"",desc:""};if(e)for(var a in this.rows){var s=this.rows[a];s.meaning===e&&(t.code=e,t.desc=s.description,t.id=s.meaning)}else t.id="",t.code="",t.desc="";this.$emit("change-lov",t)}},mounted:function(){this.getDataRows({meaning:"",keyword:""})},watch:{value:function(e,t){this.result=e}}};const r=(0,a(51900).Z)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_select"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"",size:e.size,"popper-append-to-body":e.popperBody},on:{focus:e.focus,change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.meaning+": "+e.description,value:e.meaning}})})),1)],1)}),[],!1,null,null,null).exports},43126:(e,t,a)=>{"use strict";a.d(t,{Z:()=>r});const s={name:"ir-components-lov-policy-set-header-id",data:function(){return{rows:[],dataSet:[],loading:!1,result:this.value,isDisabled:void 0!==this.disabled&&this.disabled}},props:["value","name","size","placeholder","popperBody","fixTypeFr","fixTypeSc","check","disabled"],methods:{remoteMethod:function(e){this.dataSet=this.rows.filter((function(t){return t.policy_set_number.toLowerCase().indexOf(e.toLowerCase())>-1||t.policy_set_description.toLowerCase().indexOf(e.toLowerCase())>-1}))},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/policy-set-header",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.check?t.dataSet=t.rows=a.data.filter((function(e){return e.meaning.toLowerCase()==t.check.toLowerCase()})):t.dataSet=t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},onfocus:function(){this.getDataRows({policy_set_header_id:"",keyword:"",type:this.fixTypeFr,type2:this.fixTypeSc})},onchange:function(e){console.log("onchange ",e),this.$emit("change-lov",e)}},mounted:function(){console.log("mounted policy_set_header_id ",this.value),this.result=this.value?+this.value:this.value,this.getDataRows({policy_set_header_id:this.value,keyword:"",type:this.fixTypeFr,type2:this.fixTypeSc})},watch:{value:function(e,t){this.result=e?+e:e,this.getDataRows({policy_set_header_id:e,keyword:"",type:this.fixTypeFr,type2:this.fixTypeSc})},disabled:function(){this.isDisabled=this.disabled}}};const r=(0,a(51900).Z)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"",size:e.size,"popper-append-to-body":e.popperBody,disabled:e.isDisabled},on:{focus:e.onfocus,change:e.onchange},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.dataSet,(function(e,t){return a("el-option",{key:t,attrs:{label:e.policy_set_number+": "+e.policy_set_description,value:e.policy_set_header_id}})})),1)],1)}),[],!1,null,null,null).exports}}]);