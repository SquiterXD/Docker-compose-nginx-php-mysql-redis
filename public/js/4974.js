(self.webpackChunk=self.webpackChunk||[]).push([[4974],{29040:(t,e,i)=>{"use strict";i.d(e,{Z:()=>s});var a=i(23645),n=i.n(a)()((function(t){return t[1]}));n.push([t.id,".vld-overlay,.vld-shown{overflow:hidden}.vld-overlay{bottom:0;left:0;position:absolute;right:0;top:0;align-items:center;display:none;justify-content:center;z-index:9999}.vld-overlay.is-active{display:flex}.vld-overlay.is-full-page{z-index:9999;position:fixed}.vld-overlay .vld-background{bottom:0;left:0;position:absolute;right:0;top:0;background:#fff;opacity:.5}.vld-overlay .vld-icon,.vld-parent{position:relative}",""]);const s=n},19371:(t,e,i)=>{"use strict";var a=i(93379),n=i.n(a),s=i(29040),o={insert:"head",singleton:!1};n()(s.Z,o),s.Z.locals},4974:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>_});var a=i(87757),n=i.n(a),s=i(30381),o=i.n(s),r=i(7398),l=i.n(r);i(19371);function c(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,a)}return i}function u(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?c(Object(i),!0).forEach((function(e){p(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):c(Object(i)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}function p(t,e,i){return e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}function d(t){return function(t){if(Array.isArray(t))return m(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return m(t,e);var i=Object.prototype.toString.call(t).slice(8,-1);"Object"===i&&t.constructor&&(i=t.constructor.name);if("Map"===i||"Set"===i)return Array.from(t);if("Arguments"===i||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i))return m(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function m(t,e){(null==e||e>t.length)&&(e=t.length);for(var i=0,a=new Array(e);i<e;i++)a[i]=t[i];return a}function h(t,e,i,a,n,s,o){try{var r=t[s](o),l=r.value}catch(t){return void i(t)}r.done?e(l):Promise.resolve(l).then(a,n)}function f(t){return function(){var e=this,i=arguments;return new Promise((function(a,n){var s=t.apply(e,i);function o(t){h(s,a,n,o,r,"next",t)}function r(t){h(s,a,n,o,r,"throw",t)}o(void 0)}))}}var v;const y={props:["sampleDateValue","sampleTimeValue","repeatFlag","repeatTimeHour","repeatTimeMin","repeatQty","qmGroups","processQmGroups","siloQmGroups","locators","qmGroupValue","qmGroupTypeValue","locatorValue","optSelectionTypeValue","selectedOptValue"],components:{Loading:l()},data:function(){return{sampleDate:this.sampleDateValue?o()(this.sampleDateValue,"DD/MM/YYYY").toDate():"",sampleTime:this.sampleTimeValue,sampleTimeMeridiem:this.getSampleTimeMeridiem(this.sampleTimeValue),qmGroup:this.qmGroupValue,qmGroupType:this.qmGroupTypeValue,locator:this.locatorValue,optSelectionType:this.optSelectionTypeValue?this.optSelectionTypeValue:"CHECKLIST",searchBatchKeyword:"",searchBatchBackInDays:30,searchBlendDateFrom:this.sampleDateValue?o()(this.sampleDateValue).subtract(30,"days").format("DD/MM/YYYY"):"",opts:[],selectedOpts:[],selectedOpt:this.selectedOptValue,qmGroupOptions:this.qmGroups,locatorOptions:this.getLocatorOptionsInQmGroup(this.qmGroupValue),moisturePoints:this.getMoisturePoints(this.locators,this.qmGroupValue,this.locatorValue),batchItems:[],isLoading:!1}},mounted:function(){},watch:{searchBatchBackInDays:(v=f(n().mark((function t(e,i){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e>0&&this.sampleDate?this.searchBlendDateFrom=o()(this.sampleDate).subtract(e,"days").format("DD/MM/YYYY"):this.searchBlendDateFrom=this.sampleDate;case 1:case"end":return t.stop()}}),t,this)}))),function(t,e){return v.apply(this,arguments)})},methods:{getLocatorOptionsInQmGroup:function(t){return"ALL"==t?[{inventory_location_id:"ALL",location_full_desc:"เลือกทั้งหมด"}]:[{inventory_location_id:"ALL",location_full_desc:"เลือกทั้งหมด"}].concat(d(this.locators.filter((function(e){return e.qm_group==t}))))},getLocatorDescByMoisturePoint:function(t,e){var i="";if(e){var a=t.find((function(t){return t.moisture_point==e}));i=a?a.locator_desc:""}return i},getOptDesc:function(t){var e="",i=t.split("_");return i.length>1&&(e=i[1]),e},onSampleDateChanged:function(t){this.sampleDate=t,this.searchBatchBackInDays>0&&this.sampleDate?this.searchBlendDateFrom=o()(this.sampleDate).subtract(this.searchBatchBackInDays,"days").format("DD/MM/YYYY"):this.searchBlendDateFrom=this.sampleDate,this.batchItems=[],this.selectedOpts=this.batchItems.filter((function(t){return t.selected})),this.selectedOpt=null,this.selectedOpts=this.batchItems.filter((function(t){return t.selected}))},onSampleTimeChanged:function(t){this.sampleTime=t,this.sampleTimeMeridiem=this.getSampleTimeMeridiem(this.sampleTime),this.batchItems=[],this.selectedOpts=this.batchItems.filter((function(t){return t.selected})),this.selectedOpt=null,this.selectedOpts=this.batchItems.filter((function(t){return t.selected}))},onQmGroupWasSelected:function(t){this.locatorOptions=this.getLocatorOptionsInQmGroup(t),this.qmGroup=t,this.qmGroupType=this.getQmGroupType(t),this.batchItems=[],this.selectedOpts=this.batchItems.filter((function(t){return t.selected})),this.locator="ALL",this.moisturePoints=this.getMoisturePoints(this.locators,this.qmGroup,this.locator),this.selectedOpt=null,this.selectedOpts=this.batchItems.filter((function(t){return t.selected}))},onLocatorWasSelected:function(t){var e=this;return f(n().mark((function i(){return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return e.locator=t,e.moisturePoints=e.getMoisturePoints(e.locators,e.qmGroup,e.locator),i.next=4,e.getBatchItems(e.qmGroup,e.qmGroupType,e.sampleDate,e.sampleTime,e.locator,e.searchBatchKeyword);case 4:e.batchItems=i.sent,e.selectedOpt=null,e.selectedOpts=e.batchItems.filter((function(t){return t.selected}));case 7:case"end":return i.stop()}}),i)})))()},getQmGroupType:function(t){var e="";return this.processQmGroups.find((function(e){return e.qm_group_value==t}))&&(e="PROCESS"),this.siloQmGroups.find((function(e){return e.qm_group_value==t}))&&(e="SILO"),e},getMoisturePoints:function(t,e,i){var a=t.filter((function(t){return!!t.moisture_point})).map((function(t){return t.moisture_point}));return e&&"ALL"!=e&&(a=t.filter((function(t){return!!t.moisture_point})).filter((function(t){return t.qm_group==e})).map((function(t){return t.moisture_point})),e&&i&&"ALL"!=i&&(a=t.filter((function(t){return!!t.moisture_point})).filter((function(t){return t.qm_group==e&&t.inventory_location_id==i})).map((function(t){return t.moisture_point})))),a},onGetBatchItems:function(){var t=this;return f(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.moisturePoints=t.getMoisturePoints(t.locators,t.qmGroup,t.locator),t.batchItems=[],e.next=4,t.getBatchItems(t.qmGroup,t.qmGroupType,t.sampleDate,t.sampleTime,t.locator,t.searchBatchKeyword);case 4:t.batchItems=e.sent,t.selectedOpt=null,t.selectedOpts=t.batchItems.filter((function(t){return t.selected}));case 7:case"end":return e.stop()}}),e)})))()},getBatchItems:function(t,e,i,a,s,r){var l=this;return f(n().mark((function c(){var p,d,m,h,f,v;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(p=[],!a){n.next=14;break}if(d=o()(i).format("DD/MM/YYYY"),m=l.getSampleTimeMeridiem(a),"CHECKLIST"!=l.optSelectionType&&"SELECT"!=l.optSelectionType){n.next=14;break}return h={opt_selection_type:l.optSelectionType,sample_date:d,sample_time:a,sample_time_meridiem:m,qm_group:t,qm_group_type:e,locator_id:"ALL"!=s?s:null,search_batch_keyword:r,blend_date_from:l.searchBlendDateFrom},l.isLoading=!0,n.next=9,axios.get("/qm/ajax/tobaccos/get-batch-items",{params:h}).then((function(t){var e=t.data.data,i=e.message;return"success"==e.status?e.batch_items?JSON.parse(e.batch_items):[]:(l.isLoading=!1,swal("Error","".concat(i),"error"),[])}));case 9:f=n.sent,v=f.map((function(t){return u(u({},t),{},{locator_desc:l.getLocatorDescByMoisturePoint(l.locators,t.moisture_point),opt_desc:l.getOptDesc(t.batch_id),blend_date_formatted:o()(t.blend_date).add(543,"years").format("DD/MM/YYYY"),blend_time:o()(t.blend_date).format("HH:mm"),blend_meridiem:o()(t.blend_date).format("A"),selected:!1})})),r&&(v=v.filter((function(t){return t.batch_id.includes(r)||t.moisture_point.includes(r)}))),p=v,l.isLoading=!1;case 14:return n.abrupt("return",p);case 15:case"end":return n.stop()}}),c)})))()},onOptSelectionTypeChanged:function(t){this.batchItems=[],this.searchBatchKeyword="",this.selectedOpt=null,this.selectedOpts=this.batchItems.filter((function(t){return t.selected}))},onOptChecked:function(t){this.selectedOpt=null,this.selectedOpts=this.batchItems.filter((function(t){return t.selected}))},onSelectedOptWasSelected:function(t){console.log("this.selectedOpt : ",this.selectedOpt)},getSampleTimeMeridiem:function(t){var e="";return t&&(e=o()("2022-01-01 ".concat(t,":01")).format("A")),e}}};const _=(0,i(51900).Z)(y,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-4"},[i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label required"},[t._v("  กลุ่มงาน ")]),t._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"qm_group",id:"input_qm_group",placeholder:"เลือก กลุ่มงาน","option-key":"qm_group_value","option-value":"qm_group_value","option-label":"qm_group_label","select-options":t.qmGroupOptions,value:t.qmGroup,filterable:!0},on:{onSelected:t.onQmGroupWasSelected}})],1)]),t._v(" "),i("div",{staticClass:"row form-group"},[i("label",{staticClass:"col-md-4 col-form-label required"},[t._v(" จุดตรวจสอบ")]),t._v(" "),i("div",{staticClass:"col-md-8"},[i("qm-el-select",{attrs:{name:"locator_id",id:"input_locator_id",placeholder:"เลือก จุดตรวจสอบ","option-key":"inventory_location_id","option-value":"inventory_location_id","option-label":"location_full_desc","select-options":t.locatorOptions,value:t.locator,filterable:!0},on:{onSelected:t.onLocatorWasSelected}})],1)]),t._v(" "),i("hr"),t._v(" "),i("div",{staticClass:"row form-group"},[i("div",{staticClass:"col-md-12"},[i("label",{staticClass:"required"},[t._v("วัน/เวลา ที่เก็บตัวอย่าง")]),t._v(" "),i("div",{staticClass:"row"},[i("div",{staticClass:"col-md-8"},[i("qm-datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",attrs:{name:"sample_date",id:"input_sample_date",placeholder:"โปรดเลือกวันที่เก็บตัวอย่าง",value:t.sampleDate},on:{dateWasSelected:t.onSampleDateChanged}})],1),t._v(" "),i("div",{staticClass:"col-md-4"},[i("qm-timepicker",{attrs:{name:"sample_time",id:"input_sample_time",value:t.sampleTime},on:{change:t.onSampleTimeChanged}}),t._v(" "),i("input",{directives:[{name:"model",rawName:"v-model",value:t.sampleTimeMeridiem,expression:"sampleTimeMeridiem"}],attrs:{type:"hidden",name:"sample_time_meridiem"},domProps:{value:t.sampleTimeMeridiem},on:{input:function(e){e.target.composing||(t.sampleTimeMeridiem=e.target.value)}}})],1)])])]),t._v(" "),i("div",{staticClass:"row form-group"},[i("div",{staticClass:"col-md-12"},[i("qm-input-group-repeat",{attrs:{"repeat-flag-value":t.repeatFlag,"repeat-time-hour-value":t.repeatTimeHour,"repeat-time-min-value":t.repeatTimeMin,"repeat-qty-value":t.repeatQty}})],1)])]),t._v(" "),i("div",{staticClass:"col-md-8"},[i("div",{staticClass:"row"},[i("div",{staticClass:"col-3"},[i("div",{staticClass:"ibox"},[i("div",{staticClass:"ibox-content tw-p-2"},[i("div",{staticClass:"form-check tw-my-1 tw-text-xs"},[i("input",{directives:[{name:"model",rawName:"v-model",value:t.optSelectionType,expression:"optSelectionType"}],staticClass:"form-check-input",attrs:{type:"radio",name:"opt_selection_type",value:"CHECKLIST",id:"opt_selection_checklist"},domProps:{checked:t._q(t.optSelectionType,"CHECKLIST")},on:{change:[function(e){t.optSelectionType="CHECKLIST"},function(e){return t.onOptSelectionTypeChanged(e)}]}}),t._v(" "),i("label",{staticClass:"form-check-label",attrs:{for:"opt_selection_type1"}},[t._v("\n                                ค้นหาและเลือกรายการตราชุด\n                            ")])]),t._v(" "),i("div",{staticClass:"form-check tw-my-1 tw-text-xs"},[i("input",{directives:[{name:"model",rawName:"v-model",value:t.optSelectionType,expression:"optSelectionType"}],staticClass:"form-check-input",attrs:{type:"radio",name:"opt_selection_type",value:"AUTO",id:"opt_selection_auto"},domProps:{checked:t._q(t.optSelectionType,"AUTO")},on:{change:[function(e){t.optSelectionType="AUTO"},function(e){return t.onOptSelectionTypeChanged(e)}]}}),t._v(" "),i("label",{staticClass:"form-check-label",attrs:{for:"opt_selection_type2"}},[t._v("\n                                ระบบระบุตราชุดให้\n                            ")])]),t._v(" "),i("div",{staticClass:"form-check tw-my-1 tw-text-xs"},[i("input",{directives:[{name:"model",rawName:"v-model",value:t.optSelectionType,expression:"optSelectionType"}],staticClass:"form-check-input",attrs:{type:"radio",name:"opt_selection_type",value:"SELECT",id:"opt_selection_select"},domProps:{checked:t._q(t.optSelectionType,"SELECT")},on:{change:[function(e){t.optSelectionType="SELECT"},function(e){return t.onOptSelectionTypeChanged(e)}]}}),t._v(" "),i("label",{staticClass:"form-check-label",attrs:{for:"opt_selection_type3"}},[t._v("\n                                กำหนดตราชุด\n                            ")])]),t._v(" "),i("div",[i("input",{directives:[{name:"model",rawName:"v-model",value:t.qmGroupType,expression:"qmGroupType"}],attrs:{type:"hidden",name:"qm_group_type"},domProps:{value:t.qmGroupType},on:{input:function(e){e.target.composing||(t.qmGroupType=e.target.value)}}})])])])]),t._v(" "),i("div",{staticClass:"col-9"},[i("div",{staticClass:"tw-w-full"},[i("div",{staticClass:"row tw-mb-1"},[i("div",{class:["SELECT"==t.optSelectionType&&t.locator&&t.moisturePoints.length<=0?"col-md-8 tw-pr-1":"col-md-12"]},[i("div",{staticClass:"input-group"},[i("div",{staticClass:"input-group-prepend"},[i("button",{staticClass:"btn btn-sm btn-outline btn-white tw-w-full",attrs:{type:"button",disabled:!t.qmGroup||!t.sampleDate||!t.sampleTime||"CHECKLIST"!=t.optSelectionType&&"SELECT"!=t.optSelectionType},on:{click:function(e){return t.onGetBatchItems()}}},[i("i",{staticClass:"fa fa-search"}),t._v(" ค้นหา\n                                    ")])]),t._v(" "),i("input",{directives:[{name:"model",rawName:"v-model",value:t.searchBatchKeyword,expression:"searchBatchKeyword"}],staticClass:"form-control input-sm",attrs:{type:"text",name:"search_batch_keyword",disabled:!t.qmGroup||!t.sampleDate||!t.sampleTime||"CHECKLIST"!=t.optSelectionType&&"SELECT"!=t.optSelectionType,placeholder:"ค้นหาจาก ตราชุด, หัววัดความชื้น "},domProps:{value:t.searchBatchKeyword},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:(e.preventDefault(),t.onGetBatchItems(e))},input:function(e){e.target.composing||(t.searchBatchKeyword=e.target.value)}}})])]),t._v(" "),i("div",{class:["SELECT"==t.optSelectionType&&t.locator&&t.moisturePoints.length<=0?"col-md-4 tw-pl-1":"tw-hidden"]},[i("div",{staticClass:"input-group"},[t._m(0),t._v(" "),i("input",{directives:[{name:"model",rawName:"v-model",value:t.searchBatchBackInDays,expression:"searchBatchBackInDays"}],staticClass:"form-control input-sm",attrs:{type:"number",name:"search_batch_back_in_days",min:"0",oninput:"this.value = Math.abs(this.value)",disabled:!t.qmGroup||!t.sampleDate||!t.sampleTime||"CHECKLIST"!=t.optSelectionType&&"SELECT"!=t.optSelectionType,placeholder:"ค้นหาจาก ตราชุด, หัววัดความชื้น "},domProps:{value:t.searchBatchBackInDays},on:{keydown:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:(e.preventDefault(),t.onGetBatchItems(e))},input:function(e){e.target.composing||(t.searchBatchBackInDays=e.target.value)}}}),t._v(" "),i("input",{directives:[{name:"model",rawName:"v-model",value:t.searchBlendDateFrom,expression:"searchBlendDateFrom"}],attrs:{type:"hidden",name:"blend_date_from",moment:""},domProps:{value:t.searchBlendDateFrom},on:{input:function(e){e.target.composing||(t.searchBlendDateFrom=e.target.value)}}}),t._v(" "),t._m(1)])])]),t._v(" "),"CHECKLIST"==t.optSelectionType?i("div",{staticClass:"row"},[t._m(2),t._v(" "),i("div",{staticClass:"col-md-6"},[i("label",{staticClass:"col-form-label tw-w-full text-right"},[t._v(" จำนวน "+t._s(t.selectedOpts?t.selectedOpts.length:"-")+" รายการ ")])])]):t._e()]),t._v(" "),i("div",{staticClass:"table-responsive",staticStyle:{"max-height":"300px"}},[i("table",{staticClass:"table table-bordered",staticStyle:{"min-width":"650px"}},[i("thead",[i("tr",[i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}}),t._v(" "),"SELECT"==t.optSelectionType&&t.locator&&t.moisturePoints.length<=0?t._e():i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs",staticStyle:{"z-index":"auto"},attrs:{width:"20%"}},[t._v("\n                                    จุดตรวจสอบ\n                                ")]),t._v(" "),i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}},[t._v("\n                                    ตราชุด\n                                ")]),t._v(" "),i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"10%"}},[t._v("\n                                    วันที่\n                                ")]),t._v(" "),i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"5%"}},[t._v("\n                                    รอบ\n                                ")]),t._v(" "),i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"8%"}},[t._v("\n                                    เริ่มเวลา\n                                ")]),t._v(" "),i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"12%"}},[t._v("\n                                    กลุ่มงาน\n                                ")]),t._v(" "),"SELECT"==t.optSelectionType&&t.locator&&t.moisturePoints.length<=0?t._e():i("th",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"z-index":"auto"},attrs:{width:"12%"}},[t._v("\n                                    หัววัดความชื้น\n                                ")])])]),t._v(" "),t.batchItems.length>0?i("tbody",[t._l(t.batchItems,(function(e,a){return[i("tr",{key:a},[i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs"},["CHECKLIST"==t.optSelectionType?i("div",{staticClass:"form-check tw-pl-0"},[i("input",{directives:[{name:"model",rawName:"v-model",value:e.selected,expression:"batchItem.selected"}],staticClass:"tw-mt-1",attrs:{type:"checkbox",name:"opts[]"},domProps:{value:e.opt_id,checked:Array.isArray(e.selected)?t._i(e.selected,e.opt_id)>-1:e.selected},on:{change:[function(i){var a=e.selected,n=i.target,s=!!n.checked;if(Array.isArray(a)){var o=e.opt_id,r=t._i(a,o);n.checked?r<0&&t.$set(e,"selected",a.concat([o])):r>-1&&t.$set(e,"selected",a.slice(0,r).concat(a.slice(r+1)))}else t.$set(e,"selected",s)},t.onOptChecked]}})]):t._e(),t._v(" "),"SELECT"==t.optSelectionType?i("div",{staticClass:"form-check tw-pl-0"},[i("input",{directives:[{name:"model",rawName:"v-model",value:t.selectedOpt,expression:"selectedOpt"}],staticClass:"tw-mt-1",attrs:{type:"radio",name:"selected_opt",id:"input_selected_opt"},domProps:{value:e.opt_id,checked:t._q(t.selectedOpt,e.opt_id)},on:{change:[function(i){t.selectedOpt=e.opt_id},function(e){return t.onSelectedOptWasSelected()}]}})]):t._e()]),t._v(" "),"SELECT"==t.optSelectionType&&t.locator&&t.moisturePoints.length<=0?t._e():i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40"},[t._v("\n                                        "+t._s(e.locator_desc)+"\n                                    ")]),t._v(" "),i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs"},[t._v("\n                                        "+t._s(e.opt_desc)+"\n                                    ")]),t._v(" "),i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                                        "+t._s(e.blend_date_formatted)+"\n                                    ")]),t._v(" "),i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                                        "+t._s(e.blend_meridiem)+"\n                                    ")]),t._v(" "),i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                                        "+t._s(e.blend_time)+"\n                                    ")]),t._v(" "),i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                                        "+t._s(t.qmGroup)+"\n                                    ")]),t._v(" "),"SELECT"==t.optSelectionType&&t.locator&&t.moisturePoints.length<=0?t._e():i("td",{staticClass:"tw-text-gray-600 tw-bg-opacity-40 text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                                        "+t._s(e.moisture_point)+"\n                                    ")])])]}))],2):i("tbody",[t._m(3)])])])])])]),t._v(" "),i("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"input-group-prepend"},[i("span",{staticClass:"tw-my-1 tw-px-2"},[t._v(" ย้อนหลัง ")])])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"input-group-append"},[i("span",{staticClass:"input-group-addon tw-px-2"},[t._v(" วัน ")])])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"col-md-6"},[i("label",{staticClass:"col-form-label tw-w-full"},[t._v(" เลือกรายการตราชุดยาเส้น ")])])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("tr",[i("td",{attrs:{colspan:"8"}},[i("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports},7398:function(t){"undefined"!=typeof self&&self,t.exports=function(t){var e={};function i(a){if(e[a])return e[a].exports;var n=e[a]={i:a,l:!1,exports:{}};return t[a].call(n.exports,n,n.exports,i),n.l=!0,n.exports}return i.m=t,i.c=e,i.d=function(t,e,a){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},i.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(a,n,function(e){return t[e]}.bind(null,n));return a},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="",i(i.s=1)}([function(t,e,i){},function(t,e,i){"use strict";i.r(e);var a="undefined"!=typeof window?window.HTMLElement:Object,n={mounted:function(){this.enforceFocus&&document.addEventListener("focusin",this.focusIn)},methods:{focusIn:function(t){if(this.isActive&&t.target!==this.$el&&!this.$el.contains(t.target)){var e=this.container?this.container:this.isFullPage?null:this.$el.parentElement;(this.isFullPage||e&&e.contains(t.target))&&(t.preventDefault(),this.$el.focus())}}},beforeDestroy:function(){document.removeEventListener("focusin",this.focusIn)}};function s(t,e,i,a,n,s,o,r){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=i,c._compiled=!0),a&&(c.functional=!0),s&&(c._scopeId="data-v-"+s),o?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},c._ssrRegister=l):n&&(l=r?function(){n.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(t,e){return l.call(e),u(t,e)}}else{var p=c.beforeCreate;c.beforeCreate=p?[].concat(p,l):[l]}return{exports:t,options:c}}var o=s({name:"spinner",props:{color:{type:String,default:"#000"},height:{type:Number,default:64},width:{type:Number,default:64}}},(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{viewBox:"0 0 38 38",xmlns:"http://www.w3.org/2000/svg",width:this.width,height:this.height,stroke:this.color}},[e("g",{attrs:{fill:"none","fill-rule":"evenodd"}},[e("g",{attrs:{transform:"translate(1 1)","stroke-width":"2"}},[e("circle",{attrs:{"stroke-opacity":".25",cx:"18",cy:"18",r:"18"}}),e("path",{attrs:{d:"M36 18c0-9.94-8.06-18-18-18"}},[e("animateTransform",{attrs:{attributeName:"transform",type:"rotate",from:"0 18 18",to:"360 18 18",dur:"0.8s",repeatCount:"indefinite"}})],1)])])])}),[],!1,null,null,null).exports,r=s({name:"dots",props:{color:{type:String,default:"#000"},height:{type:Number,default:240},width:{type:Number,default:60}}},(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{viewBox:"0 0 120 30",xmlns:"http://www.w3.org/2000/svg",fill:this.color,width:this.width,height:this.height}},[e("circle",{attrs:{cx:"15",cy:"15",r:"15"}},[e("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})]),e("circle",{attrs:{cx:"60",cy:"15",r:"9","fill-opacity":"0.3"}},[e("animate",{attrs:{attributeName:"r",from:"9",to:"9",begin:"0s",dur:"0.8s",values:"9;15;9",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"0.5",to:"0.5",begin:"0s",dur:"0.8s",values:".5;1;.5",calcMode:"linear",repeatCount:"indefinite"}})]),e("circle",{attrs:{cx:"105",cy:"15",r:"15"}},[e("animate",{attrs:{attributeName:"r",from:"15",to:"15",begin:"0s",dur:"0.8s",values:"15;9;15",calcMode:"linear",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"fill-opacity",from:"1",to:"1",begin:"0s",dur:"0.8s",values:"1;.5;1",calcMode:"linear",repeatCount:"indefinite"}})])])}),[],!1,null,null,null).exports,l=s({name:"bars",props:{color:{type:String,default:"#000"},height:{type:Number,default:40},width:{type:Number,default:40}}},(function(){var t=this.$createElement,e=this._self._c||t;return e("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 30 30",height:this.height,width:this.width,fill:this.color}},[e("rect",{attrs:{x:"0",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0s",dur:"0.6s",repeatCount:"indefinite"}})]),e("rect",{attrs:{x:"10",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.15s",dur:"0.6s",repeatCount:"indefinite"}})]),e("rect",{attrs:{x:"20",y:"13",width:"4",height:"5"}},[e("animate",{attrs:{attributeName:"height",attributeType:"XML",values:"5;21;5",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}}),e("animate",{attrs:{attributeName:"y",attributeType:"XML",values:"13; 5; 13",begin:"0.3s",dur:"0.6s",repeatCount:"indefinite"}})])])}),[],!1,null,null,null).exports,c=s({name:"vue-loading",mixins:[n],props:{active:Boolean,programmatic:Boolean,container:[Object,Function,a],isFullPage:{type:Boolean,default:!0},enforceFocus:{type:Boolean,default:!0},lockScroll:{type:Boolean,default:!1},transition:{type:String,default:"fade"},canCancel:Boolean,onCancel:{type:Function,default:function(){}},color:String,backgroundColor:String,blur:{type:String,default:"2px"},opacity:Number,width:Number,height:Number,zIndex:Number,loader:{type:String,default:"spinner"}},data:function(){return{isActive:this.active}},components:{Spinner:o,Dots:r,Bars:l},beforeMount:function(){this.programmatic&&(this.container?(this.isFullPage=!1,this.container.appendChild(this.$el)):document.body.appendChild(this.$el))},mounted:function(){this.programmatic&&(this.isActive=!0),document.addEventListener("keyup",this.keyPress)},methods:{cancel:function(){this.canCancel&&this.isActive&&(this.hide(),this.onCancel.apply(null,arguments))},hide:function(){var t=this;this.$emit("hide"),this.$emit("update:active",!1),this.programmatic&&(this.isActive=!1,setTimeout((function(){var e;t.$destroy(),void 0!==(e=t.$el).remove?e.remove():e.parentNode.removeChild(e)}),150))},disableScroll:function(){this.isFullPage&&this.lockScroll&&document.body.classList.add("vld-shown")},enableScroll:function(){this.isFullPage&&this.lockScroll&&document.body.classList.remove("vld-shown")},keyPress:function(t){27===t.keyCode&&this.cancel()}},watch:{active:function(t){this.isActive=t},isActive:function(t){t?this.disableScroll():this.enableScroll()}},computed:{bgStyle:function(){return{background:this.backgroundColor,opacity:this.opacity,backdropFilter:"blur(".concat(this.blur,")")}}},beforeDestroy:function(){document.removeEventListener("keyup",this.keyPress)}},(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("transition",{attrs:{name:t.transition}},[i("div",{directives:[{name:"show",rawName:"v-show",value:t.isActive,expression:"isActive"}],staticClass:"vld-overlay is-active",class:{"is-full-page":t.isFullPage},style:{zIndex:t.zIndex},attrs:{tabindex:"0","aria-busy":t.isActive,"aria-label":"Loading"}},[i("div",{staticClass:"vld-background",style:t.bgStyle,on:{click:function(e){return e.preventDefault(),t.cancel(e)}}}),i("div",{staticClass:"vld-icon"},[t._t("before"),t._t("default",[i(t.loader,{tag:"component",attrs:{color:t.color,width:t.width,height:t.height}})]),t._t("after")],2)])])}),[],!1,null,null,null).exports,u=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};return{show:function(){var a=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:i,s={programmatic:!0},o=Object.assign({},e,a,s),r=new(t.extend(c))({el:document.createElement("div"),propsData:o}),l=Object.assign({},i,n);return Object.keys(l).map((function(t){r.$slots[t]=l[t]})),r}}};i(0),c.install=function(t){var e=u(t,arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},arguments.length>2&&void 0!==arguments[2]?arguments[2]:{});t.$loading=e,t.prototype.$loading=e},e.default=c}]).default}}]);