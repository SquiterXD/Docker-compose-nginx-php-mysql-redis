(self.webpackChunk=self.webpackChunk||[]).push([[3490],{39996:(e,t,a)=>{"use strict";a.d(t,{Z:()=>s});var n=a(23645),o=a.n(n)()((function(e){return e[1]}));o.push([e.id,"td[data-v-189211cc],th[data-v-189211cc]{padding:.25rem}th[data-v-189211cc]{background:#fff;position:-webkit-sticky;position:sticky;top:0}",""]);const s=o},2438:(e,t,a)=>{"use strict";a.d(t,{Z:()=>o});const n={name:"ir-components-lov-group-code",data:function(){return{rows:[],result:this.value}},props:["value","name","size","placeholder","popperBody"],methods:{getDataRows:function(){var e=this;axios.get("/ir/ajax/lov/group-code",{params:{group_code:""}}).then((function(t){var a=t.data;e.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},change:function(e){this.$emit("change-lov",e)}},created:function(){this.getDataRows()}};const o=(0,a(51900).Z)(n,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,clearable:!0,"popper-append-to-body":e.popperBody,size:e.size},on:{change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.meaning,value:e.group_code}})})),1)],1)}),[],!1,null,null,null).exports},22773:(e,t,a)=>{"use strict";a.d(t,{Z:()=>o});const n={name:"ir-components-lov-status-ir",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","size","popperBody"],methods:{getDataRows:function(){var e=this;axios.get("/ir/ajax/lov/status").then((function(t){var a=t.data;e.rows=a})).catch((function(e){swal("Error",e,"error")}))},change:function(e){this.$emit("change-lov",e)}},watch:{value:function(e,t){this.result=e}},created:function(){this.getDataRows()}};const o=(0,a(51900).Z)(n,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:"สถานะ",name:e.name,clearable:!0,"popper-append-to-body":e.popperBody,size:e.size},on:{change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.description,value:e.lookup_code}})})),1)],1)}),[],!1,null,null,null).exports},43490:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>P});var n=a(22773);const o={name:"ir-expense-car-gas-lov-expense-type-code",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","index","size","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({lookup_code:"",keyword:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/exp-car-gas-type",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){0===this.rows.length&&this.getDataRows({lookup_code:"",keyword:""})},change:function(e){this.$emit("change-lov",e)}},created:function(){this.getDataRows({lookup_code:"",keyword:""})}};var s=a(51900);const r=(0,s.Z)(o,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"ประเภทของประกันภัย","remote-method":e.remoteMethod,loading:e.loading,name:e.name,clearable:!0,"popper-append-to-body":e.popperBody,size:e.size},on:{change:e.change,focus:e.focus},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.description,value:e.lookup_code}})})),1)],1)}),[],!1,null,null,null).exports;var l=a(2438);const c={name:"ir-components-lov-gas-station-type",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","size","placeholder","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({keyword:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/gas-stations-type",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){0===this.rows.length&&this.getDataRows({keyword:""})},change:function(e){this.$emit("change-lov",e)}},created:function(){this.getDataRows({keyword:""})}};const i=(0,s.Z)(c,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"","popper-append-to-body":e.popperBody,size:e.size},on:{focus:e.focus,change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.description,value:e.description}})})),1)],1)}),[],!1,null,null,null).exports;const d={name:"ir-components-lov-license-plate",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","size","placeholder","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({license_plate:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/license-plate",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){0===this.rows.length&&this.getDataRows({license_plate:""})},change:function(e){this.$emit("change-lov",e)}},created:function(){this.getDataRows({license_plate:""})},mounted:function(){}};const u=(0,s.Z)(d,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"","popper-append-to-body":e.popperBody,size:e.size},on:{focus:e.focus,change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.license_plate,value:e.license_plate}})})),1)],1)}),[],!1,null,null,null).exports;const p={name:"ir-components-lov-renew-type",data:function(){return{rows:[],loading:!1,result:this.value}},props:["value","name","size","placeholder","popperBody"],methods:{remoteMethod:function(e){this.getDataRows({renew_type:e})},getDataRows:function(e){var t=this;this.loading=!0,axios.get("/ir/ajax/lov/renew-type",{params:e}).then((function(e){var a=e.data;t.loading=!1,t.rows=a.data})).catch((function(e){swal("Error",e,"error")}))},focus:function(){this.getDataRows({renew_type:""})},change:function(e){this.$emit("change-lov",e)}},mounted:function(){this.getDataRows({renew_type:""})}};const h=(0,s.Z)(p,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:e.placeholder,name:e.name,"remote-method":e.remoteMethod,loading:e.loading,remote:"",clearable:!0,filterable:"","popper-append-to-body":e.popperBody,size:e.size},on:{focus:e.focus,change:e.change},model:{value:e.result,callback:function(t){e.result=t},expression:"result"}},e._l(e.rows,(function(e,t){return a("el-option",{key:t,attrs:{label:e.description,value:e.lookup_code}})})),1)],1)}),[],!1,null,null,null).exports;var _=a(30381),f=a.n(_);const m={name:"ir-stock-monthly-modal-fetch",data:function(){return{fetch:{period_name:"",expense_type_code:"",group_code:"",gas_station_type:"",license_plate:"",renew_type:"",policy_set_header_id:""},rules:{period_name:[{required:!0,message:"กรุณาระบุเดือนปิดบัญชี",trigger:"change"}],expense_type_code:[{required:!0,message:"กรุณาระบุประเภทของประกันภัย",trigger:"change"}]},years:[],budget_period_year:[],months:[],showLoading:!1}},props:["setYearCE","showYearBE","vars"],methods:{clickSearch:function(){var e=this;this.$refs.form_stock_monthly_fetch.validate((function(t){if(!t)return!1;e.getDataRows()}))},clickClear:function(){this.resetFields()},getDataRows:function(){var e=this;this.showLoading=!0;var t={period_name:this.setYearCE("month",this.fetch.period_name),type:this.fetch.expense_type_code,group_code:this.fetch.group_code,type_code:this.fetch.gas_station_type,license_plate:this.fetch.license_plate,renew_type:this.fetch.renew_type,program_code:"IRP0009",policy_set_header_id:this.fetch.policy_set_header_id};axios.get("/ir/ajax/expense-car-gas/fetch",{params:t}).then((function(t){var a=t.data;e.showLoading=!1,e.$emit("fetch-table-header",a.data),$("#modal_expense_car_gas").modal("hide")})).catch((function(e){swal("Error",e,"error")}))},resetFields:function(){this.$refs.form_stock_monthly_fetch.resetFields()},getValuePeriodFrom:function(e){var t=this.vars.formatMonth;this.fetch.period_name=e?f()(e).format(t):""},getValueExpenseTypeCode:function(e){this.fetch.expense_type_code=e},getValueGroupCode:function(e){this.fetch.group_code=e},getValueGasStation:function(e){this.fetch.gas_station_type=e},getValueLicensePlate:function(e){this.fetch.license_plate=e},getValueRenewType:function(e){this.fetch.renew_type=e}},components:{lovStatusIr:n.Z,lovExpenseTypeCode:r,lovGroupCode:l.Z,lovGasStationType:i,lovLicensePlate:u,lovRenewType:h},created:function(){}};const v={name:"ir-expense-car-gas-search",data:function(){return{rules:{year:[{required:!0,message:"กรุณาระบุปี",trigger:"change"}],period_name:[{required:!0,message:"กรุณาระบุเดือน",trigger:"change"}],expense_type_code:[{required:!0,message:"กรุณาระบุประเภทของประกันภัย",trigger:"change"}]},period_name:[],budget_period_year:[],months:[],years:[]}},props:["search","showYearBE","vars","setYearCE"],methods:{changeYear:function(e){this.search.year=e,this.months=e?this.budget_period_year.filter((function(t){if(e===t.period_year)return t})):[],this.search.month=""},clickSearch:function(){var e=this;this.$refs.search_expense_car_gas.validate((function(t){if(!t)return!1;e.$emit("click-search",e.search)}))},clickFetch:function(){},clickClear:function(){window.location.href="/ir/expense-car-gas"},getValueStatus:function(e){this.search.status=e},getDataBudgetPeriodYear:function(){var e=this;axios.get("/ir/ajax/lov/budget-period-year").then((function(t){var a=t.data;e.budget_period_year=e.setPropertyPeriodYear(a.data)})).catch((function(e){swal("Error",e,"error")}))},setPropertyPeriodYear:function(e){return e.filter((function(e){return e}))},onlyUnique:function(e,t,a){return a.indexOf(e)===t},unique:function(){var e=[];return $.each(this.budget_period_year,(function(t,a){-1==$.inArray(a.period_year,e)&&e.push(a.period_year)})),e},getValueExpenseTypeCode:function(e){this.search.expense_type_code=e},getValueGroupCode:function(e){this.search.group_code=e},getValueGasStation:function(e){this.search.gas_station_type=e},getValueLicensePlate:function(e){this.search.license_plate=e},getValueRenewType:function(e){this.search.renew_type=e},getValuePeriodFrom:function(e){var t=this.vars.formatMonth;this.search.period_name=e?f()(e).format(t):""},fetchTableHeader:function(e){this.$emit("fetch-show-table-header",e)}},components:{modalFetch:(0,s.Z)(m,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_expense_car_gas",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-md"},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:e.showLoading,expression:"showLoading"}]},[a("div",{staticClass:"modal-content"},[e._m(0),e._v(" "),a("el-form",{ref:"form_stock_monthly_fetch",staticClass:"demo-dynamic form_table_line",attrs:{model:e.fetch,"label-width":"120px",rules:e.rules}},[a("div",{staticClass:"modal-body"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("เดือนปิดบัญชี *")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-6 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"period_name"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"period_name","p-type":"month",placeholder:"เดือนปิดบัญชี",value:e.fetch.period_name,format:e.vars.formatMonth},on:{dateWasSelected:e.getValuePeriodFrom}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ประเภทของประกันภัย *")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-6 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"expense_type_code"}},[a("lov-expense-type-code",{attrs:{name:"expense_type_code",size:"",popperBody:!1},on:{"change-lov":e.getValueExpenseTypeCode},model:{value:e.fetch.expense_type_code,callback:function(t){e.$set(e.fetch,"expense_type_code",t)},expression:"fetch.expense_type_code"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("กลุ่ม")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-6 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"group_code"}},[a("lov-group-code",{attrs:{name:"group_code",size:"",popperBody:!1,placeholder:"กลุ่ม"},on:{"change-lov":e.getValueGroupCode},model:{value:e.fetch.group_code,callback:function(t){e.$set(e.fetch,"group_code",t)},expression:"fetch.group_code"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ประเภทสถานีน้ำมัน")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-6 col-md-6 el_field"},[a("el-form-item",[a("lov-gas-station-type",{attrs:{name:"gas_station_type",size:"",popperBody:!1,placeholder:"ประเภทสถานีน้ำมัน"},on:{"change-lov":e.getValueGasStation},model:{value:e.fetch.gas_station_type,callback:function(t){e.$set(e.fetch,"gas_station_type",t)},expression:"fetch.gas_station_type"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ทะเบียนรถยนต์")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-6 col-md-6 el_field"},[a("el-form-item",[a("lov-license-plate",{attrs:{name:"license_plate",size:"",popperBody:!1,placeholder:"ทะเบียนรถยนต์"},on:{"change-lov":e.getValueLicensePlate},model:{value:e.fetch.license_plate,callback:function(t){e.$set(e.fetch,"license_plate",t)},expression:"fetch.license_plate"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ประเภทการต่ออายุ")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-6 col-md-6 el_field"},[a("el-form-item",[a("lov-renew-type",{attrs:{name:"renew_type",size:"",popperBody:!1,placeholder:"ประเภทการต่ออายุ"},on:{"change-lov":e.getValueRenewType},model:{value:e.fetch.renew_type,callback:function(t){e.$set(e.fetch,"renew_type",t)},expression:"fetch.renew_type"}})],1)],1)])]),e._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-success",attrs:{type:"button"},on:{click:function(t){return e.clickSearch()}}},[a("i",{staticClass:"fa fa-database"}),e._v(" ดึงข้อมูล\n            ")]),e._v(" "),a("button",{staticClass:"btn btn-warning",attrs:{type:"button"},on:{click:function(t){return e.clickClear()}}},[a("i",{staticClass:"fa fa-repeat"}),e._v(" รีเซต\n            ")])])])],1)])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[e._v("×")]),a("span",{staticClass:"sr-only"},[e._v("Close")])]),e._v(" "),a("p",{staticClass:"modal-title text-left"},[e._v("การดึงข้อมูล")])])}],!1,null,null,null).exports,lovStatusIr:n.Z,lovExpenseTypeCode:r,lovGroupCode:l.Z,lovGasStationType:i,lovLicensePlate:u,lovRenewType:h},watch:{budget_period_year:function(e,t){e.length>0&&(this.years=this.unique())}},created:function(){this.getDataBudgetPeriodYear()}};const g=(0,s.Z)(v,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("el-form",{ref:"search_expense_car_gas",staticClass:"demo-ruleForm",attrs:{model:e.search,rules:e.rules,"label-width":"120px"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("เดือนปิดบัญชี *")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"period_name"}},[a("datepicker-th",{staticClass:"el-input__inner",staticStyle:{width:"100%"},attrs:{name:"period_name","p-type":"month",placeholder:"เดือนปิดบัญชี",value:e.search.period_name,format:e.vars.formatMonth},on:{dateWasSelected:e.getValuePeriodFrom}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ทะเบียนรถยนต์")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("lov-license-plate",{attrs:{name:"license_plate",size:"",placeholder:"ทะเบียนรถยนต์"},on:{"change-lov":e.getValueLicensePlate},model:{value:e.search.license_plate,callback:function(t){e.$set(e.search,"license_plate",t)},expression:"search.license_plate"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("ประเภทการต่ออายุ")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("lov-renew-type",{attrs:{name:"renew_type",size:"",placeholder:"ประเภทการต่ออายุ"},on:{"change-lov":e.getValueRenewType},model:{value:e.search.renew_type,callback:function(t){e.$set(e.search,"renew_type",t)},expression:"search.renew_type"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-5 col-form-label lable_align"},[a("strong",[e._v("สถานะ")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("lov-status-ir",{attrs:{name:"status",size:""},on:{"change-lov":e.getValueStatus},model:{value:e.search.status,callback:function(t){e.$set(e.search,"status",t)},expression:"search.status"}})],1)],1)])]),e._v(" "),a("div",{staticClass:"col-lg-6"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label lable_align"},[a("strong",[e._v("ประเภทของประกันภัย *")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"expense_type_code"}},[a("lov-expense-type-code",{attrs:{name:"expense_type_code",size:""},on:{"change-lov":e.getValueExpenseTypeCode},model:{value:e.search.expense_type_code,callback:function(t){e.$set(e.search,"expense_type_code",t)},expression:"search.expense_type_code"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label lable_align"},[a("strong",[e._v("ประเภทสถานีน้ำมัน")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",[a("lov-gas-station-type",{attrs:{name:"gas_station_type",size:"",placeholder:"ประเภทสถานีน้ำมัน"},on:{"change-lov":e.getValueGasStation},model:{value:e.search.gas_station_type,callback:function(t){e.$set(e.search,"gas_station_type",t)},expression:"search.gas_station_type"}})],1)],1)]),e._v(" "),a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label lable_align"},[a("strong",[e._v("กลุ่ม")])]),e._v(" "),a("div",{staticClass:"col-xl-6 col-lg-5 col-md-6 el_field"},[a("el-form-item",{attrs:{prop:"group_code"}},[a("lov-group-code",{attrs:{name:"group_code",size:"",placeholder:"กลุ่ม"},on:{"change-lov":e.getValueGroupCode},model:{value:e.search.group_code,callback:function(t){e.$set(e.search,"group_code",t)},expression:"search.group_code"}})],1)],1)])])]),e._v(" "),a("div",{staticClass:"text-right el_field"},[a("el-form-item",[a("button",{staticClass:"btn btn-default",attrs:{type:"button"},on:{click:function(t){return e.clickSearch()}}},[a("i",{staticClass:"fa fa-search"}),e._v(" ค้นหา\n        ")]),e._v(" "),a("button",{staticClass:"btn btn-success",attrs:{type:"button","data-toggle":"modal","data-target":"#modal_expense_car_gas"},on:{click:function(t){return e.clickFetch()}}},[a("i",{staticClass:"fa fa-database"}),e._v(" ดึงข้อมูล\n        ")]),e._v(" "),a("button",{staticClass:"btn btn-warning",attrs:{type:"button"},on:{click:function(t){return e.clickClear()}}},[a("i",{staticClass:"fa fa-repeat"}),e._v(" รีเซต\n        ")])])],1)]),e._v(" "),a("modal-fetch",{ref:"modal_fetch",attrs:{setYearCE:e.setYearCE,vars:e.vars},on:{"fetch-table-header":e.fetchTableHeader}})],1)}),[],!1,null,null,null).exports;function b(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,n)}return a}function y(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?b(Object(a),!0).forEach((function(t){w(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):b(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}function w(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}const x={name:"ir-expense-car-gas-table-line",data:function(){return{columnSelected:[],columnSelectedId:[],selected:[],complete:!0,locked:!0,setDataRowsNotInterface:[],res_rows_id:[],fields:[{key:"selected",sortable:!1,class:"text-center text-nowrap"},{key:"status",sortable:!0,thClass:"text-center text-nowrap"},{key:"period_name",sortable:!0,class:"text-center text-nowrap"},{key:"expense_type_desc",sortable:!0,thClass:"text-center text-nowrap"},{key:"department_code",sortable:!0,class:"text-center text-nowrap"},{key:"department_name",sortable:!0,class:"text-center text-nowrap text-nowrap"},{key:"group_name",sortable:!0,thClass:"text-center text-nowrap"},{key:"renew_type",sortable:!0,thClass:"text-center text-nowrap"},{key:"license_plate",sortable:!0,thClass:"text-center text-nowrap",tdClass:"text-nowrap"},{key:"gas_station_type_name",sortable:!0,thClass:"text-center text-nowrap",tdClass:"text-nowrap"},{key:"net_amount",sortable:!0,thClass:"text-center text-nowrap",tdClass:"text-right"},{key:"start_date",sortable:!0,class:"text-center text-nowrap"},{key:"end_date",sortable:!0,class:"text-center text-nowrap"},{key:"total_days",sortable:!0,class:"text-center text-nowrap"},{key:"expense_account",sortable:!0,class:"text-center text-nowrap"},{key:"expense_account_desc",sortable:!0,class:"text-center text-nowrap"},{key:"prepaid_account",sortable:!0,class:"text-center text-nowrap"},{key:"prepaid_account_desc",sortable:!0,class:"text-center text-nowrap"}],totalRows:0,currentPage:1,perPage:250,sortBy:"",sortDesc:!1,sortDirection:"asc"}},props:["form","setFirstLetterUpperCase","isNullOrUndefined","showYearBE","formatCurrency","expense_id","checkStatusInterface","checkStatusCancelled","vars","setValuePeriodNameFormat","formatfloat"],methods:{onRowSelected:function(e){this.selected=e},rowClass:function(e,t){},chkeckCancelled:function(e){return"CANCELLED"===e.toUpperCase()||(!!this.checkStatusInterface(e)||!this.complete)},clickSelectAll:function(){var e=this;e.columnSelected=[],e.columnSelectedId=[];var t=$('input[name="expense_car_gas_select_all"]').is(":checked");e.form.tableLine.forEach((function(a,n){t&&!e.chkeckCancelled(a.status)&&e.setSelectedColumn(a)}))},setSelectedColumn:function(e){this.columnSelected.push(e),this.columnSelectedId.push(e.expense_id)},clickSelectRow:function(e,t){var a=this;if($('input[name="expense_car_gas_select'.concat(e,'"]')).is(":checked"))a.setSelectedColumn(t),a.setDataRowsNotInterface=a.form.tableLine.filter((function(e,t){return!a.chkeckCancelled(e.status)})),a.setDataRowsNotInterface.length===a.columnSelected.length&&$('input[name="expense_car_gas_select_all"]').prop("checked",!0);else{var n=a.columnSelected.indexOf(t);n>-1&&(a.columnSelected.splice(n,1),a.columnSelectedId.splice(n,1)),$('input[name="expense_car_gas_select_all"]').prop("checked",!1)}},clickConfirm:function(){0!==this.columnSelected.length?this.columnSelected.filter((function(e){return e.status="CONFIRMED",e})):swal("Warning","กรุณาเลือกข้อมูลที่ต้องการยืนยัน!","warning")},clickCancel:function(){0===this.columnSelected.length?swal("Warning","กรุณาเลือกข้อมูลที่ต้องการยกเลิก!","warning"):this.columnSelected.filter((function(e){return e.status="CANCELLED",e}))},clickClear:function(){0!==this.columnSelected.length?this.columnSelected.filter((function(e){return e.status="NEW",e})):swal("Warning","กรุณาเลือกข้อมูลที่ต้องการรีเซต!","warning")},clickIncomplete:function(){this.complete=!this.complete,this.$emit("complete",this.complete)},clickComplete:function(){var e=this,t=[];this.form.tableLine.filter((function(a){t.push(y(y({},a),{},{period_name:e.setValuePeriodNameFormat(f()(a.period_name,e.vars.formatMonth).toDate())}))}));var a={data:t};axios.post("/ir/ajax/expense-car-gas",a).then((function(t){var a=t.data,n=a.data;e.complete=!e.complete,e.locked=!e.locked,swal({title:"Success",text:a.message,type:"success",timer:3e3,showConfirmButton:!1,closeOnConfirm:!1}),e.$emit("complete",e.complete),e.res_rows_id=n.rows,e.form.tableLine=e.setDocumentNumber()})).catch((function(e){swal("Error",e,"error")}))},setDocumentNumber:function(){var e=this;return console.log("setDocumentNumber ",this.form.tableLine,this.res_rows_id),this.form.tableLine.filter((function(t){return e.res_rows_id.filter((function(e){t.document_number=t.rowId==e.row_id?e.document_number:t.document_number,t.expense_id=t.rowId==e.row_id?e.expense_id:t.expense_id})),t}))}},watch:{complete:function(e,t){this.$emit("complete",e),e?($("#table_line").find("input").prop("disabled",!1),$('input[name="expense_car_gas_select_all"]').prop("disabled",!1)):($("#table_line").find("input").prop("disabled",!0),$('input[name="expense_car_gas_select_all"]').prop("checked",!1),$('input[name="expense_car_gas_select_all"]').prop("disabled",!0),$("#table_line").find('input[type="checkbox"]').prop("checked",!1),this.columnSelected=[],this.columnSelectedId=[]),$(".checkbox_edit_disabled").prop("disabled",!0)},document_number:function(e,t){this.form.tableLine.length>0?this.complete=!e:this.complete=!0},"form.tableLine":function(e,t){$('input[name="expense_car_gas_select_all"]').prop("checked",!1),this.columnSelected=[],this.columnSelectedId=[],this.totalRows=this.form.tableLine.length}},mounted:function(){},computed:{checkCancelAll:function(){return this.form.tableLine.every((function(e){return"cancelled"===e.status.toLowerCase()}))},checkAllInterface:function(){return this.form.tableLine.every((function(e){return"INTERFACE"===e.status.toUpperCase()}))}}};var C=a(93379),k=a.n(C),S=a(39996),E={insert:"head",singleton:!1};k()(S.Z,E);S.Z.locals;const D=(0,s.Z)(x,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"margin_top_20"},[a("el-form",{staticClass:"demo-dynamic"},[a("div",{staticClass:"table-responsive"},[a("b-table",{staticStyle:{display:"block",overflow:"auto","max-height":"500px"},attrs:{"table-class":"table table-bordered",items:e.form.tableLine,fields:e.fields,"current-page":e.currentPage,"per-page":e.perPage,"sort-by":e.sortBy,"sort-desc":e.sortDesc,"sort-direction":e.sortDirection,"tbody-tr-class":e.rowClass,"primary-key":"expense_id","show-empty":"",small:"","select-mode":"single",selectable:""},on:{"update:sortBy":function(t){e.sortBy=t},"update:sort-by":function(t){e.sortBy=t},"update:sortDesc":function(t){e.sortDesc=t},"update:sort-desc":function(t){e.sortDesc=t},"row-selected":e.onRowSelected},scopedSlots:e._u([{key:"head(selected)",fn:function(t){return[e._v("\n          Select All "),a("br"),e._v(" "),a("div",{staticClass:"form-check",staticStyle:{position:"inherit"}},[a("input",{staticClass:"form-check-input",staticStyle:{position:"inherit"},attrs:{type:"checkbox",name:"expense_car_gas_select_all",disabled:!(e.complete&&!e.checkAllInterface)},on:{click:function(t){return e.clickSelectAll()}}})])]}},{key:"head(status)",fn:function(t){return[a("div",[e._v("\n            IR Status"),a("br"),e._v("สถานะ\n          ")])]}},{key:"head(period)",fn:function(t){return[a("div",[e._v("\n            Period "),a("br"),e._v("เดือนปิดบัญชี\n          ")])]}},{key:"head(expense_type_desc)",fn:function(t){return[a("div",[e._v("\n            ประเภทของประกันภัย\n          ")])]}},{key:"head(department_code)",fn:function(t){return[a("div",[e._v("\n            Department Code"),a("br"),e._v("รหัสหน่วยงาน\n          ")])]}},{key:"head(department_name)",fn:function(t){return[a("div",[e._v("\n            Department"),a("br"),e._v("หน่วยงาน\n          ")])]}},{key:"head(group_name)",fn:function(t){return[a("div",[e._v("\n            Group"),a("br"),e._v("กลุ่ม\n          ")])]}},{key:"head(renew_type)",fn:function(t){return[a("div",[e._v("\n            Renew Type"),a("br"),e._v("ประเภทการต่ออายุ\n          ")])]}},{key:"head(license_plate)",fn:function(t){return[a("div",[e._v("\n            ทะเบียนรถ\n          ")])]}},{key:"head(gas_station_type_name)",fn:function(t){return[a("div",[e._v("\n            Gas Station Type"),a("br"),e._v("ประเภทสถานีน้ำมัน\n          ")])]}},{key:"head(net_amount)",fn:function(t){return[a("div",[e._v("\n            Net Amount"),a("br"),e._v("ค่าเบี้ยประกันสุทธิต่อเดือน\n          ")])]}},{key:"head(start_date)",fn:function(t){return[a("div",[e._v("\n            Start Date"),a("br"),e._v("วันที่เริ่มต้นการคิดเบี้ยประกัน\n          ")])]}},{key:"head(end_date)",fn:function(t){return[a("div",[e._v("\n            End Date"),a("br"),e._v("วันที่สิ้นสุดการคิดเบี้ยประกัน\n          ")])]}},{key:"head(total_days)",fn:function(t){return[a("div",[e._v("\n            Days"),a("br"),e._v(" จำนวนวัน\n          ")])]}},{key:"head(expense_account)",fn:function(t){return[a("div",[e._v("\n            Expense Account Code"),a("br"),e._v("รหัสบัญชีค่าใช้จ่าย\n          ")])]}},{key:"head(expense_account_desc)",fn:function(t){return[a("div",[e._v("\n            Expense Account Description"),a("br"),e._v("บัญชีค่าใช้จ่าย\n          ")])]}},{key:"head(prepaid_account)",fn:function(t){return[a("div",[e._v("\n            Prepaid Account Code"),a("br"),e._v("รหัสบัญชีจ่ายล่วงหน้า\n          ")])]}},{key:"head(prepaid_account_desc)",fn:function(t){return[a("div",[e._v("\n            Prepaid Account Description"),a("br"),e._v("บัญชีจ่ายล่วงหน้า\n          ")])]}},{key:"cell(selected)",fn:function(t){return[a("div",{staticClass:"form-check",staticStyle:{position:"inherit"}},[a("input",{class:"form-check-input "+(e.chkeckCancelled(t.item.status)?"checkbox_edit_disabled":""),staticStyle:{position:"inherit"},attrs:{type:"checkbox",name:"expense_car_gas_select"+t.item.expense_id,disabled:e.chkeckCancelled(t.item.status)},domProps:{value:""+t.item.expense_id,checked:e.columnSelectedId.includes(t.item.expense_id)},on:{click:function(a){return e.clickSelectRow(t.item.expense_id,t.item)}}})])]}},{key:"cell(status)",fn:function(t){return[e._v("\n          "+e._s(e.setFirstLetterUpperCase(t.item.status))+"\n        ")]}},{key:"cell(start_date)",fn:function(t){return[e._v("\n          "+e._s(e.showYearBE("date",t.item.start_date))+"\n        ")]}},{key:"cell(end_date)",fn:function(t){return[e._v("\n          "+e._s(e.showYearBE("date",t.item.end_date))+"\n        ")]}}])})],1),e._v(" "),e.totalRows>e.perPage?a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("b-pagination",{attrs:{"total-rows":e.totalRows,"per-page":e.perPage,align:"right"},model:{value:e.currentPage,callback:function(t){e.currentPage=t},expression:"currentPage"}})],1)]):e._e(),e._v(" "),a("div",{staticClass:"row margin_top_20"},[a("div",{staticClass:"col-md-6"},[a("div",{staticClass:"form-group el_field"},[a("el-form-item",[a("button",{staticClass:"btn btn-primary",attrs:{type:"button",disabled:!e.complete||e.checkAllInterface},on:{click:function(t){return e.clickConfirm()}}},[a("i",{staticClass:"fa fa-check"}),e._v("\n              ยืนยัน\n            ")]),e._v(" "),a("button",{staticClass:"btn btn-warning",attrs:{type:"button",disabled:!e.complete||e.checkAllInterface},on:{click:function(t){return e.clickClear()}}},[a("i",{staticClass:"fa fa-repeat"}),e._v("\n              รีเซต\n            ")])])],1)]),e._v(" "),a("div",{staticClass:"col-md-6 lable_align"},[a("div",{staticClass:"form-group el_field"},[a("el-form-item",[a("button",{directives:[{name:"show",rawName:"v-show",value:e.complete,expression:"complete"}],staticClass:"btn btn-primary",attrs:{type:"button",disabled:e.checkAllInterface},on:{click:function(t){return e.clickComplete()}}},[a("i",{staticClass:"fa fa-check-square-o"}),e._v(" บันทึก (ล็อค)\n            ")]),e._v(" "),e.complete?e._e():a("button",{staticClass:"btn btn-danger btn_incomplete",attrs:{type:"button",disabled:e.checkCancelAll||e.checkAllInterface},on:{click:function(t){return e.clickIncomplete()}}},[a("i",{staticClass:"fa fa-minus-square-o"}),e._v(" แก้ไข (ปลดล็อค)\n            ")])])],1)])])])],1)}),[],!1,null,"189211cc",null).exports;var T=a(67791);const L={name:"ir-expense-car-gas-index",data:function(){return{tableTotal:[],search:{year:"",month:"",expense_type_code:"",group_code:"",gas_station_type:"",license_plate:"",renew_type:"",status:"",period_name:""},form:{tableLine:[]},account_code_combine:[],expenseTypeCode:[],expense_id:"",funcs:T.sD,vars:T.gR,showLoading:!1}},methods:{getDataSearch:function(e){this.search=e,this.getTableLine()},getTableLine:function(){var e=this;console.log("this month",this.search.month),this.showLoading=!0;var t={year:this.search.year,month:this.funcs.setYearCE("month",this.search.month),group_code:this.search.group_code,type_code:this.search.gas_station_type,status:this.search.status,license_plate:this.search.license_plate,type:this.search.expense_type_code,renew_type:this.search.renew_type,period_name:this.funcs.setYearCE("month",this.search.period_name)};axios.get("/ir/ajax/expense-car-gas",{params:t}).then((function(t){var a=t.data;e.showLoading=!1,e.form.tableLine=e.setPropertyTableLine(a.data),0===e.form.tableLine.length&&(e.tableTotal=[])})).catch((function(e){swal("Error",e,"error")})).then((function(){}))},fetchShowTableHeader:function(e){var t=this;this.showLoading=!0,this.form.tableLine=this.setPropertyTableLine(e),0===this.form.tableLine.length&&(this.tableTotal=[]),setTimeout((function(){t.showLoading=!1}),2e3)},setPropertyTableLine:function(e){return e.filter((function(e,t){var a,n;return e.program_code="IRP0009",e.gas_station_type_name=null!==(a=e.gas_station_type_name)&&void 0!==a?a:e.type_name,e.gas_station_type_code=null!==(n=e.gas_station_type_code)&&void 0!==n?n:e.type_code,e.document_line_id="",e.rowId=t,e}))},getAccountCodeCombine:function(){var e=this;axios.get("/ir/ajax/lov/account-code-combine",{params:{account_id:"",keyword:""}}).then((function(t){var a=t.data;e.account_code_combine=a.data})).catch((function(e){swal("Error",e,"error")}))},setZeroWhenIsNullOrUndefined:function(e){return""===e||null==e?this.funcs.formatCurrency("0"):this.funcs.formatCurrency(e)},calTableTotal:function(){var e=this,t=null,a=0;this.tableTotal=[],e.form.tableLine.forEach((function(n){t=null,(t=e.tableTotal.find((function(e){return e.group_name==n.group_name})))?t.net_amount+=parseFloat(n.net_amount):e.tableTotal.push({group_name:n.group_name,net_amount:parseFloat(n.net_amount)}),a+=parseFloat(n.net_amount)})),1==this.tableTotal.length?this.tableTotal=[{group_name:"Total",net_amount:a}]:this.tableTotal.push({group_name:"Total",net_amount:a})},getExpenseTypeCode:function(){var e=this;return this.form.tableLine.filter((function(t){e.expenseTypeCode.filter((function(e){if(t.flag===e.lookup_code)return t.expense_type_code=e.lookup_code,t.expense_type_desc=e.description,t}))}))},calNetAmount:function(e,t){return"Y"===e.vat_refund?e.net_amount=t.insurance_amount-t.discount+t.duty_amount*t.dayOfMonth/365:"N"===e.vat_refund&&(e.net_amount=t.net_amount*t.dayOfMonth/365),e},getDataExpenseType:function(){var e=this;axios.get("/ir/ajax/lov/exp-car-gas-type",{params:{lookup_code:"",keyword:""}}).then((function(t){var a=t.data;e.expenseTypeCode=a.data})).catch((function(e){swal("Error",e,"error")}))}},components:{"expense-search":g,"expense-table-line":D},watch:{"form.tableLine":function(e,t){e.length>0?(this.getExpenseTypeCode(),this.calTableTotal()):this.tableTotal=[]}},created:function(){this.getDataExpenseType()}};const P=(0,s.Z)(L,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:e.showLoading,expression:"showLoading"}]},[a("expense-search",{attrs:{search:e.search,showYearBE:e.funcs.showYearBE,setYearCE:e.funcs.setYearCE,vars:e.vars},on:{"click-search":e.getDataSearch,"fetch-show-table-header":e.fetchShowTableHeader}}),e._v(" "),a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-striped"},[e._m(0),e._v(" "),a("tbody",{attrs:{id:"table_search"}},[e._l(e.tableTotal,(function(t,n){return a("tr",{directives:[{name:"show",rawName:"v-show",value:e.tableTotal.length>0,expression:"tableTotal.length > 0"}],key:n,staticClass:"text-center"},[a("td",{staticStyle:{"font-weight":"bold"}},[e._v(e._s(t.group_name))]),e._v(" "),a("td",{staticStyle:{"padding-right":"120px"}},[e._v(e._s(e.setZeroWhenIsNullOrUndefined(t.net_amount)))])])})),e._v(" "),0===e.tableTotal.length?a("tr",{staticClass:"text-center"},[a("td",{attrs:{colspan:"2"}},[e._v("ไม่มีข้อมูล")])]):e._e()],2),e._v(" "),a("tfoot")])]),e._v(" "),a("expense-table-line",{ref:"tableline",attrs:{form:e.form,setFirstLetterUpperCase:e.funcs.setFirstLetterUpperCase,isNullOrUndefined:e.funcs.isNullOrUndefined,showYearBE:e.funcs.showYearBE,formatCurrency:e.funcs.formatCurrency,formatfloat:e.funcs.formatfloat,expense_id:e.expense_id,checkStatusInterface:e.funcs.checkStatusInterface,checkStatusCancelled:e.funcs.checkStatusCancelled,vars:e.vars,setValuePeriodNameFormat:e.funcs.setValuePeriodNameFormat}})],1)}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("thead",[a("tr",{staticClass:"text-center"},[a("th",{attrs:{width:"120px"}}),e._v(" "),a("th",{staticStyle:{"padding-right":"120px"}},[e._v("Total Net Amount"),a("br"),e._v(" ค่าเบี้ยประกันสุทธิต่อเดือนรวม ")])])])}],!1,null,null,null).exports}}]);