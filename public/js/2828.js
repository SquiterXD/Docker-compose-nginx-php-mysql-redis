(self.webpackChunk=self.webpackChunk||[]).push([[2828],{25791:(t,a,e)=>{"use strict";e.d(a,{Z:()=>n});var s=e(23645),l=e.n(s)()((function(t){return t[1]}));l.push([t.id,"#PPP0006 .xxxx{margin-left:10px}",""]);const n=l},12828:(t,a,e)=>{"use strict";e.r(a),e.d(a,{default:()=>g});var s=e(87757),l=e.n(s);function n(t,a,e,s,l,n,r){try{var i=t[n](r),o=i.value}catch(t){return void e(t)}i.done?a(o):Promise.resolve(o).then(s,l)}const r={props:["budgetYears","pBiweekly","search","productTypes","btnTrans","url"],data:function(){return{budget_year:this.search?this.search.budget_year:"",biweekly:this.search?String(this.search.biweekly):"",status:"Active",statusLists:[{value:"Active",label:"Active"},{value:"Inactive",label:"Inactive"}],biWeeklyLists:[],loading:!1,b_loading:!1,html:""}},mounted:function(){this.budget_year&&this.getBiWeekly()},computed:{},watch:{errors:{handler:function(t){t.budget_year?this.setError("budget_year"):this.resetError("budget_year"),t.biweekly?this.setError("biweekly"):this.resetError("biweekly")},deep:!0}},methods:{openModal:function(){$("#modal_search").modal("show")},searchForm:function(){var t,a=this;return(t=l().mark((function t(){var e;return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return(e=a).loading=!0,t.next=4,axios.get(e.url.ajax_follow_ups_search,{params:{budget_year:e.budget_year,biweekly:e.biweekly}}).then((function(t){e.html=t.data.data.html})).catch((function(t){e.html="";var a=t.response.data;alert(a.message)})).then((function(){e.loading=!1}));case 4:case"end":return t.stop()}}),t)})),function(){var a=this,e=arguments;return new Promise((function(s,l){var r=t.apply(a,e);function i(t){n(r,s,l,i,o,"next",t)}function o(t){n(r,s,l,i,o,"throw",t)}i(void 0)}))})()},getBiWeekly:function(){var t=this;this.search||(this.biweekly="",this.month="",this.times=""),this.biWeeklyLists=this.pBiweekly.filter((function(a){return a.thai_year.indexOf(t.budget_year)>-1}))}}};var i=e(51900);function o(t,a,e,s,l,n,r){try{var i=t[n](r),o=i.value}catch(t){return void e(t)}i.done?a(o):Promise.resolve(o).then(s,l)}function c(t){return function(){var a=this,e=arguments;return new Promise((function(s,l){var n=t.apply(a,e);function r(t){o(n,s,l,r,i,"next",t)}function i(t){o(n,s,l,r,i,"throw",t)}r(void 0)}))}}const d={props:["followUp","btnTrans","canEdit","url","data"],data:function(){return{statusLists:[{value:"Active",label:"Active"},{value:"Inactive",label:"Inactive"}],oldNote:this.followUp.note,product:this.followUp.products[0],note:this.followUp.note,loading:!1}},methods:{updateNoteForm:function(){var t=this;return c(l().mark((function a(){var e;return l().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:e=t,swal({title:"อัพเดทหมายเหตุ",text:"ยืนยันอัพเดทหมายเหตุ ?",html:!0,showCancelButton:!0,confirmButtonText:e.btnTrans.ok.text,cancelButtonText:e.btnTrans.cancel.text,confirmButtonClass:e.btnTrans.ok.class+" btn-lg tw-w-25",cancelButtonClass:e.btnTrans.cancel.class+" btn-lg tw-w-25",closeOnConfirm:!1,closeOnCancel:!0,showLoaderOnConfirm:!0},function(){var t=c(l().mark((function t(a){return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:a&&e.update();case 1:case"end":return t.stop()}}),t)})));return function(a){return t.apply(this,arguments)}}());case 2:case"end":return a.stop()}}),a)})))()},update:function(){var t=this;return c(l().mark((function a(){var e;return l().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return!1,(e=t).loading=!0,a.next=5,axios.patch(e.url.ajax_update_note).then((function(t){"S"==t.data.data.status&&(!0,swal({title:"อัพเดทหมายเหตุ",text:'<span style="font-size: 16px; text-align: left;"> อัพเดทหมายเหตุเรียบร้อย </span>',type:"success",html:!0}),e.oldNote=e.note),"S"!=t.data.data.status&&swal({title:"Error !",text:t.data.data.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var a=t.response.data;alert(a.message)})).then((function(){e.loading=!1}));case 5:case"end":return a.stop()}}),a)})))()}},watch:{},computed:{showSaveNote:function(){return this.note!=this.oldNote}}};function u(t,a,e,s,l,n,r){try{var i=t[n](r),o=i.value}catch(t){return void e(t)}i.done?a(o):Promise.resolve(o).then(s,l)}function v(t){return function(){var a=this,e=arguments;return new Promise((function(s,l){var n=t.apply(a,e);function r(t){u(n,s,l,r,i,"next",t)}function i(t){u(n,s,l,r,i,"throw",t)}r(void 0)}))}}var p,_;const m={components:{ModalSearch:(0,i.Z)(r,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("span",[e("button",{class:t.btnTrans.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:t.openModal}},[e("i",{class:t.btnTrans.search.icon}),t._v("\n        "+t._s(t.btnTrans.search.text)+"\n    ")]),t._v(" "),e("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_search",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[e("div",{staticClass:"modal-dialog modal-lg",staticStyle:{width:"90%","max-width":"950px"}},[e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"modal-content"},[t._m(0),t._v(" "),e("div",{staticClass:"modal-body text-left"},[e("div",{staticClass:"row col-12"},[e("div",{staticClass:"form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"},[e("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ปีงบประมาณ :")]),t._v(" "),e("div",{staticClass:"input-group "},[e("input",{attrs:{type:"hidden",name:"search[budget_year]"},domProps:{value:t.budget_year}}),t._v(" "),e("el-select",{attrs:{size:"large",placeholder:"ปีงบประมาณ",clearable:"",filterable:"","popper-append-to-body":!1},on:{change:t.getBiWeekly},model:{value:t.budget_year,callback:function(a){t.budget_year=a},expression:"budget_year"}},t._l(t.budgetYears,(function(t,a){return e("el-option",{key:a,attrs:{label:t.thai_year,value:t.thai_year}})})),1),t._v(" "),e("div",{staticClass:"error_msg text-left",attrs:{id:"el_explode_budget_year"}})],1)]),t._v(" "),e("div",{staticClass:"form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"},[e("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ปักษ์ที่ :")]),t._v(" "),e("div",{},[e("input",{attrs:{type:"hidden",name:"search[biweekly]"},domProps:{value:t.biweekly}}),t._v(" "),t.budget_year?e("el-select",{attrs:{clearable:"",size:"large",placeholder:"ปักษ์",filterable:"","v-loading":t.b_loading,"popper-append-to-body":!1},model:{value:t.biweekly,callback:function(a){t.biweekly=a},expression:"biweekly"}},t._l(t.biWeeklyLists,(function(t,a){return e("el-option",{key:a,attrs:{label:t.biweekly,value:t.biweekly}})})),1):e("el-select",{attrs:{clearable:"",size:"large",placeholder:"ปักษ์",disabled:""},model:{value:t.biweekly,callback:function(a){t.biweekly=a},expression:"biweekly"}},t._l(t.biWeeklyLists,(function(t,a){return e("el-option",{key:a,attrs:{label:t.biweekly,value:t.biweekly}})})),1),t._v(" "),e("div",{staticClass:"error_msg text-left",attrs:{id:"el_explode_biweekly"}})],1)]),t._v(" "),e("div",{staticClass:"form-group text-right  pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12"},[e("label",{staticClass:" tw-font-bold tw-uppercase mt-2"},[t._v(" ")]),t._v(" "),e("div",{staticClass:"text-left"},[e("button",{class:t.btnTrans.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:t.searchForm}},[e("i",{class:t.btnTrans.search.icon}),t._v("\n                                    "+t._s(t.btnTrans.search.text)+"\n                                ")])])])]),t._v(" "),e("div",{domProps:{innerHTML:t._s(t.html)}})]),t._v(" "),t._m(1)])])])])}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[e("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),e("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),e("h4",{staticClass:"modal-title"},[t._v("ค้นหาแผนประมาณการผลิต")]),t._v(" "),e("small",{staticClass:"font-bold"},[t._v("\n                         \n                    ")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"modal-footer"},[e("button",{staticClass:"btn btn-white",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])}],!1,null,null,null).exports,HeaderDetail:(0,i.Z)(d,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{},[e("form",{attrs:{id:"production-plan-form",action:""}},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-8 b-r"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-lg-6"},[e("dl",{staticClass:"row mb-0"},[t._m(0),t._v(" "),e("div",{staticClass:"col-sm-8 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.followUp.pp_bi_weekly.thai_year)+"\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(1),t._v(" "),e("div",{staticClass:"col-sm-8 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.followUp.pp_bi_weekly.biweekly)+"\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(2),t._v(" "),e("div",{staticClass:"col-sm-8 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.data.approve_no)+"\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(3),t._v(" "),e("div",{staticClass:"col-sm-8 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.followUp.pp_bi_weekly.thai_combine_date)+"\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(4),t._v(" "),e("div",{staticClass:"col-sm-8 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.data.adjust_no)+"\n                                    ")]):t._e()])])])]),t._v(" "),e("div",{staticClass:"col-lg-6",attrs:{id:"cluster_info"}},[e("dl",{staticClass:"row mb-0"},[t._m(5),t._v(" "),e("div",{staticClass:"col-sm-7 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.product?t.product.previous_date_format:"")+"\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(6),t._v(" "),e("div",{staticClass:"col-sm-7 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.product?t.product.as_of_date_format:"")+"\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(7),t._v(" "),e("div",{staticClass:"col-sm-7 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t._f("number2Digit")(t.followUp.day_for_sale))+" วัน\n                                    ")]):t._e()])])]),t._v(" "),e("dl",{staticClass:"row mb-0"},[t._m(8),t._v(" "),e("div",{staticClass:"col-sm-7 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t._f("number2Digit")(t.product?t.product.remain_sale_day:0))+" วัน\n                                    ")]):t._e()])])])])])]),t._v(" "),e("div",{staticClass:"col-4"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-lg-12"},[e("dl",{staticClass:"row mb-0"},[t._m(9),t._v(" "),e("div",{staticClass:"col-sm-6 text-sm-left"},[e("dd",{staticClass:"mb-1"},[t.followUp?e("div",[t._v("\n                                        "+t._s(t.followUp.sysdate_format)+"\n                                    ")]):t._e()])])])])])])])])])}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-4 pl-0 text-sm-right"},[e("dt",[t._v("ปีงบประมาณ:")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-4 pl-0 text-sm-right"},[e("dt",[t._v("ปักษ์ที่:")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-4 pl-0 text-sm-right"},[e("dt",[t._v("ครั้งที่อนุมัติ:")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-4 pl-0 text-sm-right"},[e("dt",[t._v("ประจำวันที่:")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-4 pl-0 text-sm-right"},[e("dt",[t._v("ปรับครั้งที่:")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-5  pl-0 text-sm-right"},[e("dt",[t._v("\n                                    วันที่ผลิต:\n                                ")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-5  pl-0 text-sm-right"},[e("dt",[t._v("\n                                    คงคลังเช้า ณ วันที่:\n                                ")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-5  pl-0 text-sm-right"},[e("dt",[t._v("\n                                    จำนวนวันขาย:\n                                ")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-5  pl-0 text-sm-right"},[e("dt",[t._v("\n                                    คงเหลือวันขาย:\n                                ")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-6 text-sm-right"},[e("dt",{attrs:{title:""}},[t._v("วันที่ปัจจุบัน:")])])}],!1,null,null,null).exports},props:["followUp","modalSearchInput","colorCode","url","btnTrans","pData"],data:function(){return{data:this.pData,loading:!1,selTabName:"tab1",html:{tab1:"",tab2:""},canEdit:!1,canApprove:!1}},mounted:function(){this.getData()},computed:{product_type:function(){this.getData()}},watch:{product_type:(_=v(l().mark((function t(a,e){return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.abrupt("return",data.default_input.product_type);case 1:case"end":return t.stop()}}),t)}))),function(t,a){return _.apply(this,arguments)}),selTabName:(p=v(l().mark((function t(a,e){return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.getData();case 1:case"end":return t.stop()}}),t,this)}))),function(t,a){return p.apply(this,arguments)})},methods:{getData:function(){var t=this;return v(l().mark((function a(){var e,s;return l().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(null!=(e=t).selTabName&&""!=e.selTabName){a.next=3;break}return a.abrupt("return");case 3:if(e.followUp&&e.selTabName){a.next=5;break}return a.abrupt("return");case 5:return e.loading=!0,s={follow_main_id:e.followUp.follow_main_id,tab_name:e.selTabName,product_type:e.data.default_input.product_type},a.next=9,axios.get(e.url.ajax_follow_ups_get_data,{params:s}).then((function(t){var a=t.data.data;e.html[e.selTabName]=a.html})).catch((function(t){console.log("error");var a=t.response.data;alert(a.message)})).then((function(){e.loading=!1}));case 9:$((function(){$('[data-toggle="tooltip"]').tooltip({placement:"top"})}));case 10:case"end":return a.stop()}}),a)})))()}}};var b=e(93379),f=e.n(b),h=e(25791),w={insert:"head",singleton:!1};f()(h.Z,w);h.Z.locals;const g=(0,i.Z)(m,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{attrs:{id:"PPP0006"}},[e("div",{staticClass:"ibox float-e-margins mb-2"},[e("div",{staticClass:"col-12 text-right mt-1"},[t.canEdit?e("button",{class:t.btnTrans.save.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(a){return a.preventDefault(),t.saveTab2AvgChange()}}},[e("i",{class:t.btnTrans.save.icon}),t._v("\n                "+t._s(t.btnTrans.save.text)+"\n            ")]):t._e(),t._v(" "),t.canApprove?e("button",{class:t.btnTrans.approve.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(a){return a.preventDefault(),t.checkApprove()}}},[e("i",{class:t.btnTrans.approve.icon}),t._v("\n                "+t._s(t.btnTrans.approve.text)+"\n            ")]):t._e(),t._v(" "),e("button",{class:t.btnTrans.print.class+" btn-lg tw-w-25",attrs:{type:"button"}},[e("i",{class:t.btnTrans.print.icon}),t._v("\n                "+t._s(t.btnTrans.print.text)+"\n            ")])])]),t._v(" "),e("div",{staticClass:"card border-primary mb-3 mt-3"},[e("div",{staticClass:"card-body"},[e("header-detail",{attrs:{url:t.url,btnTrans:t.btnTrans,followUp:t.followUp,data:t.data}}),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-8 b-r"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-lg-12"},[e("dl",{staticClass:"row mb-0"},[t._m(0),t._v(" "),e("div",{staticClass:"col-sm-8 text-sm-left"},[e("div",[e("el-radio-group",{attrs:{size:"small"},model:{value:t.data.default_input.product_type,callback:function(a){t.$set(t.data.default_input,"product_type",a)},expression:"data.default_input.product_type"}},[t._l(t.data.product_types,(function(a,s){return[e("el-radio",{staticClass:"mr-1 mb-1",attrs:{label:a.lookup_code,border:""},on:{click:t.getData}},[t._v("\n                                                "+t._s(a.meaning)+"\n                                            ")])]})),t._v(" "),e("el-radio",{staticClass:"mr-1 mb-1",attrs:{label:"all",border:""},on:{click:t.getData}},[t._v("\n                                                แสดงทุกประเภท\n                                            ")])],2)],1)])])])])])])],1)]),t._v(" "),e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"tabs-container"},[e("ul",{staticClass:"nav nav-tabs",attrs:{role:"tablist"}},[e("li",[e("a",{staticClass:"nav-link active",attrs:{"data-toggle":"tab",href:"#tab1"},on:{click:function(a){t.selTabName="tab1"}}},[t._v("\n                    คงคลังกองผลิตภัณฑ์\n                ")])]),t._v(" "),e("li",[e("a",{staticClass:"nav-link ",attrs:{"data-toggle":"tab",href:"#tab2"},on:{click:function(a){t.selTabName="tab2"}}},[t._v("\n                    คาดการณ์คงคลังล่วงหน้า\n                ")])])]),t._v(" "),e("div",{staticClass:"tab-content"},[e("div",{staticClass:"tab-pane active",attrs:{role:"tabpanel",id:"tab1"}},[e("div",{staticClass:"panel-body "},[e("div",{domProps:{innerHTML:t._s(t.html.tab1)}})])]),t._v(" "),e("div",{staticClass:"tab-pane ",attrs:{role:"tabpanel",id:"tab2"}},[e("div",{staticClass:"panel-body"},[e("div",{domProps:{innerHTML:t._s(t.html.tab2)}})])])])])])}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"col-sm-2 pl-0 text-sm-right"},[e("dt",[t._v("ประมาณการผลิต:")])])}],!1,null,null,null).exports}}]);