(self.webpackChunk=self.webpackChunk||[]).push([[731],{23118:(t,e,a)=>{"use strict";a.d(e,{Z:()=>n});var s=a(23645),r=a.n(s)()((function(t){return t[1]}));r.push([t.id,".v--modal-overlay[data-v-522f526f]{z-index:2000;padding-top:3rem;padding-bottom:3rem}",""]);const n=r},30731:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>C});var s=a(87757),r=a.n(s),n=a(7398),o=a.n(n),i=a(30381),l=a.n(i);a(19371);function c(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function d(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?c(Object(a),!0).forEach((function(e){u(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):c(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function u(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const p={props:["modalName","modalWidth","modalHeight","sheets","sampleDates","locators","preparedLocators","samples","inputSamples","comparedInputSamples"],components:{Loading:o()},watch:{sheets:function(t){this.sheetItems=t||[],this.sheetActiveStatuses=t?t.map((function(t,e){return{sheet_index:e,sheet_name:t,active:0===e}})):[],this.activatedLocatorLength=this.getActivatedLocators(this.sheetActiveStatuses,this.preparedLocatorItems).length},sampleDates:function(t){this.sampleDateItems=t?t.map((function(t){return d(d({},t),{},{all_selected:!0})})):[]},locators:function(t){this.locatorItems=t||[]},preparedLocators:function(t){this.preparedLocatorItems=t||[],this.activatedLocatorLength=this.getActivatedLocators(this.sheetActiveStatuses,this.preparedLocatorItems).length},samples:function(t){this.sampleItems=t||[]},inputSamples:function(t){this.inputSampleItems=t||[]},comparedInputSamples:function(t){this.cisItems=t||[],this.isAllowConfirmUpload=!!t&&t.filter((function(t){return t.selected})).length>0}},data:function(){return{isLoading:!1,width:this.modalWidth,sheetItems:this.sheets?this.sheets:[],activatedLocatorLength:this.getActivatedLocators([],[]).length,sheetActiveStatuses:this.sheets?this.sheets.map((function(t,e){return{sheet_index:e,sheet_name:t,active:0===e}})):[],sampleDateItems:this.sampleDates?this.sampleDates.map((function(t){return d(d({},t),{},{all_selected:!0})})):[],locatorItems:this.locators?this.locators:[],preparedLocatorItems:this.preparedLocators?this.preparedLocators:[],sampleItems:this.samples?this.samples:[],inputSampleItems:this.inputSamples?this.inputSamples:[],cisItems:this.comparedInputSamples?this.comparedInputSamples:[],isAllowConfirmUpload:!!this.comparedInputSamples&&this.comparedInputSamples.filter((function(t){return t.selected})).length>0}},created:function(){this.handleResize()},mounted:function(){this.activatedLocatorLength=this.getActivatedLocators(this.sheetActiveStatuses,this.preparedLocatorItems).length},methods:{handleResize:function(){window.innerWidth<768?this.width="90%":window.innerWidth<992?this.width="80%":this.width=this.modalWidth},toggleSheet:function(t){this.sheetActiveStatuses=this.sheetItems.map((function(e,a){return{sheet_index:a,sheet_name:e,active:a===t}})),this.activatedLocatorLength=this.getActivatedLocators(this.sheetActiveStatuses,this.preparedLocatorItems).length,this.sampleDateItems=this.sampleDateItems.map((function(t){return d(d({},t),{},{all_selected:!0})}))},isLocatorShow:function(t){var e=!1,a=this.preparedLocatorItems.find((function(e){return e.locator_id===t}));if(a){var s=this.sheetActiveStatuses.find((function(t){return t.sheet_index===a.sheet_index}));e=!!s&&s.active}return e},getActivatedLocators:function(t,e){var a=[],s=t.find((function(t){return!0===t.active}));return s&&(a=e.filter((function(t){return t.sheet_index==s.sheet_index}))),a},onToggleSelectAll:function(t,e){var a=e.all_selected,s=this.sheetActiveStatuses.find((function(t){return!0===t.active})).sheet_index;this.cisItems=this.cisItems.map((function(t){var r=t.selected;return t.sample_date_formatted==e.sample_date_formatted&&t.sheet_index==s&&(t.is_new_sample||t.result_value_has_changed)&&(console.log("found item : ",t),r=a),d(d({},t),{},{selected:r})}))},onSampleItemHasChanged:function(t){this.isAllowConfirmUpload=!!this.comparedInputSamples&&this.comparedInputSamples.filter((function(t){return t.selected})).length>0},onConfirmUpload:function(t){var e=this.cisItems.filter((function(t){return t.selected}));this.$emit("onSampleResultSubmitted",{input_samples:e})},formatDateTh:function(t){return t?l()(t).add(543,"years").format("DD/MM/YYYY"):""}}};var m=a(93379),f=a.n(m),_=a(23118),h={insert:"head",singleton:!1};f()(_.Z,h);_.Z.locals;var v=a(51900);const g=(0,v.Z)(p,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticStyle:{"z-index":"100"}},[a("modal",{attrs:{name:t.modalName,width:t.width,scrollable:!0,height:t.modalHeight,shiftX:.2,shiftY:.4}},[a("div",{staticClass:"p-4 text-left"},[a("h3",{staticClass:"text-left"},[t._v(" Upload ผลการทดสอบ ")]),t._v(" "),a("hr",{staticClass:"tw-mt-1"}),t._v(" "),a("div",{staticClass:"btn-group tw-pb-3",attrs:{role:"group"}},[t._l(t.sheetItems,(function(e,s){return[a("button",{key:""+s,staticClass:"btn",class:[t.sheetActiveStatuses[s].active?"btn-primary":"btn-white"],attrs:{type:"button"},on:{click:function(e){return t.toggleSheet(s)}}},[t._v(" \n                        "+t._s(e)+" \n                    ")])]}))],2),t._v(" "),a("div",{staticClass:"table-responsive",staticStyle:{"max-height":"400px"}},[a("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"800px"}},[a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{rowspan:"2"}},[t._v("\n                                โซนที่ตั้ง  \n                            ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{rowspan:"2"}},[t._v("\n                                บริเวณที่ติดตั้ง\n                            ")]),t._v(" "),t._l(t.sampleDateItems,(function(e,s){return[a("th",{key:""+s,staticClass:"text-center",attrs:{colspan:"3"}},[t._v("\n                                    "+t._s(e.sample_date_formatted)+"\n                                ")])]}))],2),t._v(" "),a("tr",[t._l(t.sampleDateItems,(function(e,s){return[a("th",{key:s+"_1",staticClass:"text-center",staticStyle:{top:"34px",padding:"0px"}},[a("div",{staticClass:"tw-p-2",staticStyle:{"border-top":"1px solid #e7eaec"}},[t._v(" เลือก ")]),t._v(" "),a("div",{staticClass:"tw-p-2",staticStyle:{"border-top":"1px solid #e7eaec"}},[a("span",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.all_selected,expression:"sampleDate.all_selected"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.all_selected)?t._i(e.all_selected,null)>-1:e.all_selected},on:{change:[function(a){var s=e.all_selected,r=a.target,n=!!r.checked;if(Array.isArray(s)){var o=t._i(s,null);r.checked?o<0&&t.$set(e,"all_selected",s.concat([null])):o>-1&&t.$set(e,"all_selected",s.slice(0,o).concat(s.slice(o+1)))}else t.$set(e,"all_selected",n)},function(a){return t.onToggleSelectAll(a,e)}]}})])])]),t._v(" "),a("th",{key:s+"_2",staticClass:"text-center",staticStyle:{top:"34px",padding:"0px"}},[a("div",{staticClass:"tw-py-6 tw-px-2",staticStyle:{"min-height":"70px","border-top":"1px solid #e7eaec"}},[t._v(" มอดยาสูบ ")])]),t._v(" "),a("th",{key:s+"_3",staticClass:"text-center",staticStyle:{top:"34px",padding:"0px"}},[a("div",{staticClass:"tw-py-6 tw-px-2",staticStyle:{"min-height":"70px","border-top":"1px solid #e7eaec"}},[t._v(" สถานะการลงผล ")])])]}))],2)]),t._v(" "),t.activatedLocatorLength>0?a("tbody",[t._l(t.preparedLocatorItems,(function(e,s){return[a("tr",{directives:[{name:"show",rawName:"v-show",value:t.isLocatorShow(e.locator_id),expression:"isLocatorShow(pl.locator_id)"}],key:""+s},[a("td",{staticClass:"text-center"},[t._v("\n                                    "+t._s(e.location_desc)+"\n                                ")]),t._v(" "),a("td",{staticClass:"text-left"},[t._v("\n                                    "+t._s(e.location_full_desc)+"\n                                ")]),t._v(" "),t._l(t.sampleDateItems,(function(s,r){return[a("td",{key:r+"_1",staticClass:"text-center"},[t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted}))?[t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).is_new_sample?a("span",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected,expression:"(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).selected"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected)?t._i(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected,null)>-1:t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected},on:{change:[function(a){var r=t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected,n=a.target,o=!!n.checked;if(Array.isArray(r)){var i=t._i(r,null);n.checked?i<0&&t.$set(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})),"selected",r.concat([null])):i>-1&&t.$set(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})),"selected",r.slice(0,i).concat(r.slice(i+1)))}else t.$set(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})),"selected",o)},function(e){return t.onSampleItemHasChanged(e)}]}})]):t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).result_value_has_changed?a("span",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected,expression:"(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).selected"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected)?t._i(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected,null)>-1:t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected},on:{change:[function(a){var r=t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).selected,n=a.target,o=!!n.checked;if(Array.isArray(r)){var i=t._i(r,null);n.checked?i<0&&t.$set(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})),"selected",r.concat([null])):i>-1&&t.$set(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})),"selected",r.slice(0,i).concat(r.slice(i+1)))}else t.$set(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})),"selected",o)},function(e){return t.onSampleItemHasChanged(e)}]}})]):a("span",[a("input",{attrs:{type:"checkbox",disabled:""},on:{change:function(e){return t.onSampleItemHasChanged(e)}}})])]:t._e()],2),t._v(" "),a("td",{key:r+"_2",staticClass:"text-center"},[t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted}))?[t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).is_new_sample?a("span",{staticClass:"tw-text-green-600 tw-font-bold"},[t._v("\n                                                "+t._s(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).result_value)+"\n                                            ")]):t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).result_value_has_changed?a("span",{staticClass:"tw-text-red-600 tw-font-bold"},[t._v("\n                                                "+t._s(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).result_value)+"\n                                            ")]):a("span",{staticClass:"tw-text-gray-400 tw-font-bold"},[t._v("\n                                                "+t._s(t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).result_value)+"\n                                            ")])]:t._e()],2),t._v(" "),a("td",{key:r+"_3",staticClass:"text-center"},[t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted}))?[t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).is_new_sample?a("span",{staticClass:"tw-text-green-600 tw-font-bold"},[t._v("\n                                                ยังไม่อัพโหลด\n                                            ")]):t.cisItems.find((function(t){return t.locator_id==e.locator_id&&t.sample_date_formatted==s.sample_date_formatted})).result_value_has_changed?a("span",{staticClass:"tw-text-blue-600 tw-font-bold"},[t._v("\n                                                อัพโหลดแล้ว\n                                            ")]):a("span",{staticClass:"tw-text-gray-600 tw-font-bold"},[t._v("\n                                                อัพโหลดแล้ว\n                                            ")])]:t._e()],2)]}))],2)]}))],2):a("tbody",[a("tr",[a("td",{attrs:{colspan:"10"}},[a("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])])])]),t._v(" "),a("hr"),t._v(" "),a("div",{staticClass:"text-right tw-mt-2"},[a("button",{staticClass:"btn btn-primary tw-w-32",attrs:{type:"button",disabled:!t.isAllowConfirmUpload},on:{click:t.onConfirmUpload}},[t._v(" \n                    ยืนยัน\n                ")]),t._v(" "),a("button",{staticClass:"btn btn-link",attrs:{type:"button"},on:{click:function(e){return t.$modal.hide(t.modalName)}}},[t._v(" \n                    ยกเลิก \n                ")])])])]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[],!1,null,"522f526f",null).exports;function w(t,e){var a;if("undefined"==typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(a=function(t,e){if(!t)return;if("string"==typeof t)return b(t,e);var a=Object.prototype.toString.call(t).slice(8,-1);"Object"===a&&t.constructor&&(a=t.constructor.name);if("Map"===a||"Set"===a)return Array.from(t);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return b(t,e)}(t))||e&&t&&"number"==typeof t.length){a&&(t=a);var s=0,r=function(){};return{s:r,n:function(){return s>=t.length?{done:!0}:{done:!1,value:t[s++]}},e:function(t){throw t},f:r}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var n,o=!0,i=!1;return{s:function(){a=t[Symbol.iterator]()},n:function(){var t=a.next();return o=t.done,t},e:function(t){i=!0,n=t},f:function(){try{o||null==a.return||a.return()}finally{if(i)throw n}}}}function b(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,s=new Array(e);a<e;a++)s[a]=t[a];return s}function x(t,e,a,s,r,n,o){try{var i=t[n](o),l=i.value}catch(t){return void a(t)}i.done?e(l):Promise.resolve(l).then(s,r)}function y(t){return function(){var e=this,a=arguments;return new Promise((function(s,r){var n=t.apply(e,a);function o(t){x(n,s,r,o,i,"next",t)}function i(t){x(n,s,r,o,i,"throw",t)}o(void 0)}))}}function S(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,s)}return a}function I(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?S(Object(a),!0).forEach((function(e){k(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):S(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function k(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const L={props:["id","name","action","locators"],components:{Loading:o(),ModalReviewSampleResults:g},data:function(){return{isLoading:!1,isUploading:!1,uploadingPercentage:0,uploadingStatus:"warning",fileList:[],sheets:[],sampleDates:[],preparedLocators:[],samples:[],inputSamples:[],comparedInputSamples:[]}},methods:{submitUpload:function(){var t=this,e=new FormData;this.fileList[0]?(this.isLoading=!0,e.append("file",this.fileList[0].raw),axios.post(this.action,e).then((function(e){var a=e.data.data,s=a.message;return"success"==a.status&&t.showModalReviewSampleResults(a),"error"==a.status&&swal("Error","".concat(s),"error"),t.fileList=[],t.isLoading=!1,a})).catch((function(e){t.isLoading=!1,console.log(e),swal("Error","".concat(e.message),"error")}))):(this.isLoading=!1,swal("Error","กรุณาเลือกไฟล์ที่ต้องการอัพโหลด","error"))},handleUploadChange:function(t,e){this.fileList=e.slice(-1)},handleBeforeUpload:function(t){if(["text/csv","text/plain","application/csv","text/comma-separated-values","application/excel","application/vnd.ms-excel","application/vnd.msexcel","text/anytext","application/octet-stream","application/txt"].includes(t.type))return!0;this.$message.error("ประเภทไฟล์ไม่ถูกต้อง (รองรับ .xlsx .csv เท่านั้น)"),this.fileList.pop(t)},showModalReviewSampleResults:function(t){var e=this;this.inputSamples=t.inputSamples.map((function(t){return I(I({},t),{},{sample_date_formatted:l()(t.sample_date).add(543,"years").format("DD/MM/YYYY")})})),this.samples=t.samples.map((function(t){return I(I({},t),{},{sample_date_formatted:l()(t.date_drawn).add(543,"years").format("DD/MM/YYYY")})})),this.sheets=t.sheets,this.comparedInputSamples=this.inputSamples.map((function(t){var a=e.samples.find((function(e){return e.sample_date_formatted==t.sample_date_formatted&&e.locator_id==t.locator_id})),s=a?a.results[0].result_value:null,r=!a||a.results[0].result_value!=t.result_value;return I(I({},t),{},{is_new_sample:!a,old_result_value:s,result_value_has_changed:r,selected:!!r})})),this.sampleDates=this.comparedInputSamples.map((function(t){return{sample_date_formatted:t.sample_date_formatted}})).filter((function(t,e,a){return e===a.findIndex((function(e){return e.sample_date_formatted===t.sample_date_formatted}))})),this.preparedLocators=this.comparedInputSamples.map((function(t){var a=e.getLocatorDesc(t);return{locator_id:t.locator_id,sheet_index:t.sheet_index,sheet_name:t.sheet_name,location_code:a.location_code,location_desc:a.location_desc,location_full_desc:a.location_full_desc}})).filter((function(t,e,a){return e===a.findIndex((function(e){return e.locator_id===t.locator_id}))})),window.scrollTo(0,150),this.$modal.show("modal-review-sample-results")},onSampleResultSubmitted:function(t){var e=this;return y(r().mark((function a(){var s,n,o,i,l,c,d,u,p,m,f,_,h,v;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(!((s=t.input_samples).length>0)){a.next=53;break}e.$modal.hide("modal-review-sample-results"),e.isUploading=!0,n=[],o=[],i=[],l=0,c=e.sampleDates.length,d=w(e.sampleDates),a.prev=10,p=r().mark((function t(){var a,o,i,d;return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a=u.value,o=a.sample_date_formatted,i=s.filter((function(t){return t.sample_date_formatted==o})),t.next=5,e.storeSamples(i);case 5:"error"==(d=t.sent).status&&n.push(d.message),l+=parseFloat(50/c),console.log("percentage : ",l),e.uploadingPercentage=l,e.uploadingStatus=l>=49?"primary":"warning";case 11:case"end":return t.stop()}}),t)})),d.s();case 13:if((u=d.n()).done){a.next=17;break}return a.delegateYield(p(),"t0",15);case 15:a.next=13;break;case 17:a.next=22;break;case 19:a.prev=19,a.t1=a.catch(10),d.e(a.t1);case 22:return a.prev=22,d.f(),a.finish(22);case 25:if(console.log("errStoreSampleResponses : ",n),!(n.length>0)){a.next=33;break}e.isUploading=!1,m=n.join(", "),swal("Error","บันทึกสร้างตัวอย่างการระบาดของมอดยาสูบ ไม่สำเร็จ : ".concat(m),"error"),a.next=52;break;case 33:f=w(e.sampleDates),a.prev=34,h=r().mark((function t(){var a,n,d,u,p;return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a=_.value,n=a.sample_date_formatted,d=s.filter((function(t){return t.sample_date_formatted==n})),t.next=5,e.storeSampleResults(d);case 5:return"error"==(u=t.sent).status&&o.push(u.message),t.next=9,e.setSampleResultStatus(d);case 9:"error"==(p=t.sent).status&&i.push(p.message),l+=parseFloat(50/c),console.log("percentage : ",l),e.uploadingPercentage=l,e.uploadingStatus=l>=99?"success":"primary";case 15:case"end":return t.stop()}}),t)})),f.s();case 37:if((_=f.n()).done){a.next=41;break}return a.delegateYield(h(),"t2",39);case 39:a.next=37;break;case 41:a.next=46;break;case 43:a.prev=43,a.t3=a.catch(34),f.e(a.t3);case 46:return a.prev=46,f.f(),a.finish(46);case 49:console.log("errStoreSampleResultResponses : ",o),console.log("errStoreSampleResultStatusResponses : ",i),o.length<=0?(setTimeout((function(){e.isUploading=!1,e.uploadingPercentage=0,e.uploadingStatus="warning"}),5e3),swal("Success","บันทึกลงผลการระบาดของมอดยาสูบ","success")):(e.isUploading=!1,v=o.join(", "),swal("Error","บันทึกลงผลการระบาดของมอดยาสูบ ไม่สำเร็จ : ".concat(v),"error"));case 52:e.isLoading=!1;case 53:case"end":return a.stop()}}),a,null,[[10,19,22,25],[34,43,46,49]])})))()},storeSamples:function(t){var e=this;return y(r().mark((function a(){var s,n;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s={input_samples:JSON.stringify(t)},a.next=3,axios.post("/qm/ajax/moth-outbreaks/samples",s).then((function(t){var e=t.data.data;e.message;return e})).catch((function(t){e.isLoading=!1,console.log(t),swal("Error","บันทึกลงผลการการระบาดของมอดยาสูบ | ".concat(t.message),"error")}));case 3:return n=a.sent,a.abrupt("return",n);case 5:case"end":return a.stop()}}),a)})))()},storeSampleResults:function(t){var e=this;return y(r().mark((function a(){var s,n,o,i;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s={input_samples:JSON.stringify(t)},a.next=3,axios.post("/qm/ajax/moth-outbreaks/results",s).then((function(t){var e=t.data.data;e.message;return e})).catch((function(t){e.isUploading=!1,console.log(t),swal("Error","บันทึกลงผลการการระบาดของมอดยาสูบ | ".concat(t.message),"error")}));case 3:if("success"!=(n=a.sent).status){a.next=11;break}return o=n.web_batch_no?n.web_batch_no:null,a.next=8,e.callPackageAddSampleResults(o);case 8:if("error"!=(i=a.sent).status){a.next=11;break}return a.abrupt("return",i);case 11:return a.abrupt("return",n);case 12:case"end":return a.stop()}}),a)})))()},callPackageAddSampleResults:function(t){var e=this;return y(r().mark((function a(){var s,n;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s={web_batch_no:t},a.next=3,axios.post("/qm/ajax/moth-outbreaks/call-pkg-add-results",s).then((function(t){var e=t.data.data;e.message;return e})).catch((function(t){e.isUploading=!1,console.log(t),swal("Error","บันทึกลงผลการการระบาดของมอดยาสูบ | ".concat(t.message),"error")}));case 3:return n=a.sent,a.abrupt("return",n);case 5:case"end":return a.stop()}}),a)})))()},setSampleResultStatus:function(t){var e=this;return y(r().mark((function a(){var s,n;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s={input_samples:JSON.stringify(t)},a.next=3,axios.post("/qm/ajax/moth-outbreaks/set-sample-result-status",s).then((function(t){var e=t.data.data;e.message;return e})).catch((function(t){e.isUploading=!1,console.log(t),swal("Error","บันทึกลงผลการการระบาดของมอดยาสูบ | ".concat(t.message),"error")}));case 3:return n=a.sent,a.abrupt("return",n);case 5:case"end":return a.stop()}}),a)})))()},getLocatorDesc:function(t){var e=this.locators.find((function(e){return e.inventory_location_id==t.locator_id}));return{location_code:e?"".concat(e.location_code?e.location_code:""):"",location_desc:e?"".concat(e.location_desc?e.location_desc:""):"",location_full_desc:e?"".concat(e.location_full_desc?e.location_full_desc:""):""}}}};const C=(0,v.Z)(L,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-3 col-form-label"},[t._v(" ลงผลการตรวจสอบ ")]),t._v(" "),a("div",{staticClass:"col-md-9 text-center tw-border-2 tw-border-dashed tw-border-gray-200 tw-py-4 "},[a("el-upload",{ref:"upload",staticClass:"upload-demo",attrs:{id:t.id,name:t.name,action:"","on-change":t.handleUploadChange,"before-upload":t.handleBeforeUpload,accept:".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel","file-list":t.fileList,"auto-upload":!1,limit:1,disabled:t.isUploading}},[a("el-button",{attrs:{slot:"trigger",disabled:t.isUploading,size:"medium",type:"success"},slot:"trigger"},[a("i",{staticClass:"fa fa fa-file-excel-o tw-mr-1"}),t._v(" Choose file\n                ")]),t._v(" "),a("el-button",{attrs:{disabled:t.isUploading,type:"primary",size:"medium"},on:{click:t.submitUpload}},[a("i",{staticClass:"fa fa-upload tw-mr-1"}),t._v(" Upload ผลการทดสอบ\n                ")]),t._v(" "),a("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"},[t._v("\n                    รองรับ .xlsx .csv เท่านั้น\n                ")])],1)],1)]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}}),t._v(" "),a("modal-review-sample-results",{attrs:{"modal-name":"modal-review-sample-results","modal-width":"1340","modal-height":"640",locators:t.locators,sheets:t.sheets,"sample-dates":t.sampleDates,"prepared-locators":t.preparedLocators,samples:t.samples,"input-samples":t.inputSamples,"compared-input-samples":t.comparedInputSamples},on:{onSampleResultSubmitted:t.onSampleResultSubmitted}}),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:t.isUploading,expression:"isUploading"}],staticClass:"tw-mt-5"},[a("p",{staticClass:"tw-mb-2"},[t._v(" Uploading ... ")]),t._v(" "),a("el-progress",{attrs:{"text-inside":!0,"stroke-width":20,percentage:t.uploadingPercentage,status:t.uploadingStatus}})],1)],1)}),[],!1,null,null,null).exports}}]);