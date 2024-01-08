(self.webpackChunk=self.webpackChunk||[]).push([[9667],{54546:(t,e,a)=>{"use strict";a.d(e,{Z:()=>s});var n=a(23645),r=a.n(n)()((function(t){return t[1]}));r.push([t.id,"td[data-v-396362a2],th[data-v-396362a2]{padding:.25rem}th[data-v-396362a2]{background:#fff;position:-webkit-sticky;position:sticky;top:0}",""]);const s=r},22385:(t,e,a)=>{"use strict";a.d(e,{Z:()=>r});const n={name:"ir-components-dropdown-active-flag",data:function(){return{result:this.value,rows:[{label:"Active",value:"Y"},{label:"Inactive",value:"N"}]}},props:["value","placeholder","name","disabled","size","popperBody"],methods:{onchange:function(t){this.$emit("change-dropdown",t)}},watch:{value:function(t,e){this.result=t}}};const r=(0,a(51900).Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:t.placeholder,name:t.name,clearable:!0,disabled:t.disabled,size:t.size,"popper-append-to-body":t.popperBody},on:{change:t.onchange},model:{value:t.result,callback:function(e){t.result=e},expression:"result"}},t._l(t.rows,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})})),1)],1)}),[],!1,null,null,null).exports},22377:(t,e,a)=>{"use strict";a.d(e,{Z:()=>r});const n={name:"ir-components-dropdown-return-vat-flag",data:function(){return{result:this.value,rows:[{label:"ขอคืนภาษีได้",value:"Y"},{label:"ขอคืนภาษีไม่ได้",value:"N"}]}},props:["value","placeholder","name","disabled","size","popperBody"],methods:{onchange:function(t){this.$emit("change-dropdown",t)}},watch:{value:function(t,e){this.result=t}}};const r=(0,a(51900).Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"el_field"},[a("el-select",{attrs:{placeholder:t.placeholder,name:t.name,clearable:!0,disabled:t.disabled,size:t.size,"popper-append-to-body":t.popperBody},on:{change:t.onchange},model:{value:t.result,callback:function(e){t.result=e},expression:"result"}},t._l(t.rows,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})})),1)],1)}),[],!1,null,null,null).exports},29667:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>w});var n=a(22377),r=a(22385);const s={name:"ir-settings-gas-station-search",data:function(){return{gas_stations:[],loading:!1,create:{gas_station_id:"",type_code:"",group_code:"",group_name:"",return_vat_flag:!1,vat_percent:"",revenue_stamp_percent:"",type_cost:"",account_combine:"",active_flag:!0,account_id:"",policy_set_header_id:""}}},props:["search","btnTrans"],methods:{clickSearch:function(){this.$emit("click-search",this.search)},clickCancel:function(){window.location.href="/ir/settings/gas-station"},remoteMethod:function(t){this.getDataRows({keyword:t})},focus:function(){this.getDataRows({keyword:""})},change:function(t){this.$emit("change-lov",t)},getDataRows:function(t){var e=this;this.loading=!0,axios.get("/ir/ajax/lov/gas-stations-type",{params:t}).then((function(t){var a=t.data;e.loading=!1,e.gas_stations=a.data})).catch((function(t){swal("Error",t,"error")}))},clickCreate:function(){var t={showIndex:!1,create:this.create};this.$emit("click-create",t)},getValueReturnVatFlag:function(t){this.search.return_vat_flag=t},getValueActiveFlag:function(t){this.search.active_flag=t}},components:{dropdownReturnVatFlag:n.Z,dropdownActiveFlag:r.Z},mounted:function(){this.getDataRows({keyword:""})}};var c=a(51900);const i=(0,c.Z)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-xl-3 col-md-4 padding_12 el_field"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"ระบุประเภทสถานีน้ำมัน","remote-method":t.remoteMethod,loading:t.loading,clearable:!0},on:{change:t.change,focus:t.focus},model:{value:t.search.type_code,callback:function(e){t.$set(t.search,"type_code",e)},expression:"search.type_code"}},t._l(t.gas_stations,(function(t,e){return a("el-option",{key:e,attrs:{label:t.description,value:t.description}})})),1)],1),t._v(" "),a("div",{staticClass:"col-xl-3 col-md-4 padding_12 el_field"},[a("dropdown-return-vat-flag",{attrs:{placeholder:"ขอคืนภาษี",name:"return_vat_flag",disabled:!1,size:"",popperBody:!0},on:{"change-dropdown":t.getValueReturnVatFlag},model:{value:t.search.return_vat_flag,callback:function(e){t.$set(t.search,"return_vat_flag",e)},expression:"search.return_vat_flag"}})],1),t._v(" "),a("div",{staticClass:"col-xl-3 col-md-4 padding_12 el_field"},[a("dropdown-active-flag",{attrs:{placeholder:"Status",name:"active_flag",disabled:!1,size:"",popperBody:!0},on:{"change-dropdown":t.getValueActiveFlag},model:{value:t.search.active_flag,callback:function(e){t.$set(t.search,"active_flag",e)},expression:"search.active_flag"}})],1),t._v(" "),a("div",{staticClass:"col-xl-3 padding_12",staticStyle:{"margin-top":"auto","margin-bottom":"auto"}},[a("button",{class:t.btnTrans.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickSearch()}}},[a("i",{class:t.btnTrans.search.icon}),t._v("\n      "+t._s(t.btnTrans.search.text)+"\n    ")]),t._v(" "),a("button",{class:t.btnTrans.reset.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(e){return e.preventDefault(),t.clickCancel()}}},[a("i",{class:t.btnTrans.reset.icon}),t._v("\n      "+t._s(t.btnTrans.reset.text)+"\n    ")])])])}),[],!1,null,null,null).exports;function l(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,n)}return a}function o(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?l(Object(a),!0).forEach((function(e){u(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):l(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function u(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const d={name:"ir-settings-gas-station-table",data:function(){return{}},props:["isNullOrUndefined","tableGasStation","formatCurrency","btnTrans"],methods:{clickEdit:function(t){var e={showIndex:!1,row:t};this.$emit("click-edit",e)},changeCheckedReturnVatFlg:function(t){var e=o(o({},t),{},{return_vat_flag:t.return_vat_flag?"Y":"N",active_flag:t.active_flag?"Y":"N"});axios.put("/ir/ajax/gas-stations/return-vat-flag",{data:e}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success"})})).catch((function(t){swal("Error",t,"error")}))},changeCheckedActive:function(t){var e=o(o({},t),{},{return_vat_flag:t.return_vat_flag?"Y":"N",active_flag:t.active_flag?"Y":"N"});axios.put("/ir/ajax/gas-stations/active-flag",{data:e}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success"})})).catch((function(t){swal("Error",t,"error")}))}}};var v=a(93379),f=a.n(v),p=a(54546),_={insert:"head",singleton:!1};f()(p.Z,_);p.Z.locals;const h=(0,c.Z)(d,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table-responsive margin_top_20"},[a("table",{staticClass:"table table-bordered",staticStyle:{display:"block",overflow:"auto","max-height":"500px"}},[t._m(0),t._v(" "),a("tbody",[t._l(t.tableGasStation,(function(e,n){return a("tr",{directives:[{name:"show",rawName:"v-show",value:t.tableGasStation.length>0,expression:"tableGasStation.length > 0"}],key:n},[a("td",{staticClass:"text-left"},[t._v(t._s(t.isNullOrUndefined(e.type_code)))]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(t.isNullOrUndefined(e.group_name)))]),t._v(" "),a("td",{staticClass:"text-center"},[a("div",{staticClass:"form-check",staticStyle:{position:"inherit"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.return_vat_flag,expression:"data.return_vat_flag"}],staticClass:"form-check-input",staticStyle:{position:"inherit"},attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.return_vat_flag)?t._i(e.return_vat_flag,null)>-1:e.return_vat_flag},on:{change:[function(a){var n=e.return_vat_flag,r=a.target,s=!!r.checked;if(Array.isArray(n)){var c=t._i(n,null);r.checked?c<0&&t.$set(e,"return_vat_flag",n.concat([null])):c>-1&&t.$set(e,"return_vat_flag",n.slice(0,c).concat(n.slice(c+1)))}else t.$set(e,"return_vat_flag",s)},function(a){return t.changeCheckedReturnVatFlg(e)}]}})])]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n          "+t._s(t.isNullOrUndefined(e.vat_percent)?t.formatCurrency(e.vat_percent):t.isNullOrUndefined(e.vat_percent))+"\n        ")]),t._v(" "),a("td",{staticClass:"text-center"},[t._v("\n          "+t._s(t.isNullOrUndefined(e.revenue_stamp_percent)?t.formatCurrency(e.revenue_stamp_percent):t.isNullOrUndefined(e.revenue_stamp_percent))+"\n        ")]),t._v(" "),a("td",{staticClass:"text-left"},[t._v(t._s(t.isNullOrUndefined(e.account_combine)))]),t._v(" "),a("td",{staticClass:"text-center"},[a("div",{staticClass:"form-check",staticStyle:{position:"inherit"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.active_flag,expression:"data.active_flag"}],staticClass:"form-check-input",staticStyle:{position:"inherit"},attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.active_flag)?t._i(e.active_flag,null)>-1:e.active_flag},on:{change:[function(a){var n=e.active_flag,r=a.target,s=!!r.checked;if(Array.isArray(n)){var c=t._i(n,null);r.checked?c<0&&t.$set(e,"active_flag",n.concat([null])):c>-1&&t.$set(e,"active_flag",n.slice(0,c).concat(n.slice(c+1)))}else t.$set(e,"active_flag",s)},function(a){return t.changeCheckedActive(e)}]}})])]),t._v(" "),a("td",{staticClass:"text-center"},[a("a",{class:t.btnTrans.edit.class+" btn-sm tw-w-25",attrs:{type:"button",href:"/ir/settings/gas-station/edit/"+e.gas_station_id}},[a("i",{class:t.btnTrans.edit.icon}),t._v(" "+t._s(t.btnTrans.edit.text)+"\n          ")])])])})),t._v(" "),0===t.tableGasStation.length?a("tr",{staticClass:"text-center"},[a("td",{attrs:{colspan:"10"}},[t._v("ไม่มีข้อมูล")])]):t._e()],2),t._v(" "),a("tfoot")])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",staticStyle:{"min-width":"200px"}},[t._v("ประเภทสถานีน้ำมัน")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[t._v("กลุ่ม")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[t._v("ขอคืนภาษีได้")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[t._v("ภาษี (%)")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[t._v("อากร (%)")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"200px",width:"1%"}},[t._v("รหัสบัญชี")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[t._v("Active")]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"110px"}},[t._v("Action")])])])}],!1,null,"396362a2",null).exports;var g=a(67791);function b(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,n)}return a}function m(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const y={name:"ir-settings-gas-station-index",props:["btnTrans"],data:function(){return{search:{type_code:"",return_vat_flag:"",active_flag:""},tableGasStation:[],funcs:g.sD}},methods:{getDataSearch:function(t){this.search=t,this.getTableGasStaion()},getTableGasStaion:function(){var t=this,e=function(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?b(Object(a),!0).forEach((function(e){m(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):b(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}({},this.search);axios.get("/ir/ajax/gas-stations",{params:e}).then((function(e){var a=e.data.data;for(var n in a){var r=a[n];r.return_vat_flag="Y"===r.return_vat_flag,r.active_flag="Y"===r.active_flag}t.tableGasStation=a})).catch((function(t){swal("Error",t,"error")}))}},components:{"search-gas":i,"table-gas":h},created:function(){this.getTableGasStaion()}};const w=(0,c.Z)(y,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("search-gas",{attrs:{search:t.search,"btn-trans":t.btnTrans},on:{"click-search":t.getDataSearch}}),t._v(" "),a("table-gas",{attrs:{isNullOrUndefined:t.funcs.isNullOrUndefined,tableGasStation:t.tableGasStation,formatCurrency:t.funcs.formatCurrency,"btn-trans":t.btnTrans}})],1)}),[],!1,null,null,null).exports}}]);