(self.webpackChunk=self.webpackChunk||[]).push([[3978],{13978:(e,o,i)=>{"use strict";i.r(o),i.d(o,{default:()=>n});var t=i(7398),a=i.n(t);i(2223),i(30381);const r={props:["periodYears","periodYearValue","versionNos","cigVersions","filterVersions","versionNoValue","planVersionNos","planVersionNoValue","periodNameFroms","periodNameFromValue","periodNameTos","periodNameToValue","allocateGroupCodes","allocateGroupCodeValue","accountTypes","accountTypeValue"],components:{Loading:a()},data:function(){return{periodYear:this.periodYearValue,versionNo:this.versionNoValue,planVersionNo:this.planVersionNoValue,periodNameFrom:this.periodNameFromValue,periodNameTo:this.periodNameToValue,allocateGroupCode:this.allocateGroupCodeValue,accountType:this.accountTypeValue,versionNoOptions:[],planVersionNoOptions:[],periodNameFromOptions:[],periodNameToOptions:[],allocateGroupCodeOptions:[],accountTypeOptions:this.accountTypes}},mounted:function(){this.periodYearValue&&(this.filterVersionOptions(this.periodYearValue),this.filterPlanVersionNoOptions(this.periodYearValue),this.filterPeriodNameFromOptions(this.periodYearValue),this.filterPeriodNameToOptions(this.periodYearValue),this.filterAllocateGroupCodeOptions(this.periodYearValue))},methods:{setUrlParams:function(){var e=new URLSearchParams(window.location.search);e.set("period_year",this.periodYear?this.periodYear:""),e.set("version_no",this.versionNo?this.versionNo:""),e.set("plan_version_no",this.planVersionNo?this.planVersionNo:""),e.set("period_name_from",this.periodNameFrom?this.periodNameFrom:""),e.set("period_name_to",this.periodNameTo?this.periodNameTo:""),e.set("allocate_group_code",this.allocateGroupCode?this.allocateGroupCode:""),e.set("account_type",this.accountType?this.accountType:""),window.history.replaceState(null,null,"?"+e.toString())},onPeriodYearChanged:function(e){this.periodYear=e,this.filterVersionOptions(this.periodYear),this.versionNoOptions.length>0&&(this.versionNo=this.versionNoOptions[0].version_no),this.filterPlanVersionNoOptions(this.periodYear),this.planVersionNoOptions.length>0&&(this.planVersionNo=this.planVersionNoOptions[0].plan_version_no),this.filterPeriodNameFromOptions(this.periodYear),this.periodNameFromOptions.length>0&&(this.periodNameFrom=this.periodNameFromOptions[0].period_name_value),this.filterPeriodNameToOptions(this.periodYear),this.periodNameToOptions.length>0&&(this.periodNameTo=this.periodNameToOptions[this.periodNameToOptions.length-1].period_name_value),this.filterAllocateGroupCodeOptions(this.periodYear),this.allocateGroupCodeOptions.length>0&&(this.allocateGroupCode=this.allocateGroupCodeOptions[0].allocate_group_code_value),this.setUrlParams()},onVersionNoChanged:function(e){this.versionNo=e,this.setUrlParams()},onPlanVersionNoChanged:function(e){this.planVersionNo=e,this.setUrlParams()},onPeriodNameFromChanged:function(e){this.periodNameFrom=e,this.setUrlParams()},onPeriodNameToChanged:function(e){this.periodNameTo=e,this.setUrlParams()},onAllocateGroupCodeChanged:function(e){this.allocateGroupCode=e,this.setUrlParams()},onAccountTypeChanged:function(e){this.accountType=e,this.setUrlParams()},filterVersionOptions:function(e){this.versionNoOptions=e?this.versionNos.filter((function(o){return o.period_year==e})):[]},filterPlanVersionNoOptions:function(e){this.planVersionNoOptions=e?this.planVersionNos.filter((function(o){return o.period_year==e})):[]},filterPeriodNameFromOptions:function(e){this.periodNameFromOptions=e?this.periodNameFroms.filter((function(o){return o.period_year==e})):[]},filterPeriodNameToOptions:function(e){this.periodNameToOptions=e?this.periodNameTos.filter((function(o){return o.period_year==e})):[]},filterAllocateGroupCodeOptions:function(e){this.allocateGroupCodeOptions=e?this.allocateGroupCodes.filter((function(o){return o.period_year==e})):[]}}};const n=(0,i(51900).Z)(r,(function(){var e=this,o=e.$createElement,i=e._self._c||o;return i("div",{staticClass:"row"},[i("div",{staticClass:"offset-md-2 col-md-8"},[i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ปี ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"period_year",id:"input_period_year",placeholder:"ปี ","option-key":"period_year_value","option-value":"period_year_value","option-label":"period_year_label","select-options":e.periodYears,clearable:!1,filterable:!0,value:e.periodYear},on:{onSelected:function(o){return e.onPeriodYearChanged(o)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ครั้งที่กระดาษปันส่วน ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"version_no",id:"input_version_no",placeholder:"ครั้งที่กระดาษปันส่วน ","option-key":"version_no","option-value":"version_no","option-label":"version_no","select-options":e.versionNoOptions,clearable:!1,filterable:!0,value:e.versionNo},on:{onSelected:function(o){return e.onVersionNoChanged(o)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ครั้งที่กระดาษทำการ ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"plan_version_no",id:"input_plan_version_no",placeholder:"ครั้งที่กระดาษทำการ ","option-key":"plan_version_no","option-value":"plan_version_no","option-label":"plan_version_no","select-options":e.planVersionNoOptions,clearable:!1,filterable:!0,value:e.planVersionNo},on:{onSelected:function(o){return e.onPlanVersionNoChanged(o)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" เปรียบเทียบค่าใช้จ่ายจริงจาก ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"period_name_from",id:"input_period_name_from",placeholder:"เปรียบเทียบค่าใช้จ่ายจริงจาก ","option-key":"period_name_value","option-value":"period_name_value","option-label":"period_name_label","select-options":e.periodNameFromOptions,clearable:!1,filterable:!0,value:e.periodNameFrom},on:{onSelected:function(o){return e.onPeriodNameFromChanged(o)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" เปรียบเทียบค่าใช้จ่ายจริงถึง ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"period_name_to",id:"input_period_name_to",placeholder:"เปรียบเทียบค่าใช้จ่ายจริงถึง ","option-key":"period_name_value","option-value":"period_name_value","option-label":"period_name_label","select-options":e.periodNameToOptions,clearable:!1,filterable:!0,value:e.periodNameTo},on:{onSelected:function(o){return e.onPeriodNameToChanged(o)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" หน่วยงาน ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"allocate_group_code",id:"input_allocate_group_code",placeholder:"หน่วยงาน ","option-key":"allocate_group_code_value","option-value":"allocate_group_code_value","option-label":"allocate_group_code_label","select-options":e.allocateGroupCodeOptions,clearable:!1,filterable:!0,value:e.allocateGroupCode},on:{onSelected:function(o){return e.onAllocateGroupCodeChanged(o)}}})],1)]),e._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 required"},[e._v(" ประเภทบัญชี ")]),e._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"account_type",id:"input_account_type",placeholder:"ประเภทบัญชี ","option-key":"account_type","option-value":"account_type","option-label":"description","select-options":e.accountTypeOptions,clearable:!1,filterable:!0,value:e.accountType},on:{onSelected:function(o){return e.onAccountTypeChanged(o)}}})],1)])]),e._v(" "),i("div",{staticClass:"offset-md-2 col-md-8 text-right tw-mt-2 tw-mb-4"},[i("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"submit",disabled:!(e.periodYear&&e.versionNo&&e.planVersionNo&&e.periodNameFrom&&e.periodNameTo)}},[i("i",{staticClass:"fa fa fa-file-excel-o tw-mr-1"}),e._v(" พิมพ์รายงาน\n        ")])])])}),[],!1,null,null,null).exports}}]);