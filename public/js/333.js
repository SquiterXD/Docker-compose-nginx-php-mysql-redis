(self.webpackChunk=self.webpackChunk||[]).push([[333],{10333:(e,a,i)=>{"use strict";i.r(a),i.d(a,{default:()=>d});var t=i(87757),n=i.n(t);function s(e,a,i,t,n,s,l){try{var r=e[s](l),d=r.value}catch(e){return void i(e)}r.done?a(d):Promise.resolve(d).then(t,n)}function l(e){return function(){var a=this,i=arguments;return new Promise((function(t,n){var l=e.apply(a,i);function r(e){s(l,t,n,r,d,"next",e)}function d(e){s(l,t,n,r,d,"throw",e)}r(void 0)}))}}const r={props:["medicinalLeafTypesH","transDate","transBtn","currentDateTH"],data:function(){return{medicinalLeafH:"",medicinalLeafL:"",medicinalItem:"",medicinalLeafTypesL:[],medicinalLeafItems:[],historyList:[],loading:{medicinalLeafL:!1,medicinalItem:!1,table:!1},isDisabled:{medicinalLeafL:!0,medicinalItem:!0,btnAddLine:!0},isValidate:{medicinalLeafH:!1,medicinalLeafL:!1,medicinalItem:!1},lastNumberSeq:""}},mounted:function(){$(".table-data").dataTable({searching:!1,order:[[0,"desc"]],columnDefs:[{orderable:!1,targets:0},{orderable:!1,targets:1},{orderable:!1,targets:2},{orderable:!1,targets:7}]})},methods:{getMedicinalLeafTypesL:function(e){var a=this;return l(n().mark((function i(){var t;return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return a.loading.medicinalLeafL=!0,a.loading.medicinalItem=!0,t={medicinalLeafTypesH:e},i.next=5,axios.get("/pd/ajax/history-instead-grades/get-medicinal-leaf-types-l",{params:t}).then((function(e){a.medicinalLeafTypesL=e.data.medicinalLeafTypesL,0!=a.medicinalLeafTypesL.length?(a.medicinalLeafL=a.medicinalLeafL?a.medicinalLeafL:"",a.loading.medicinalLeafL=!1,a.isDisabled.medicinalLeafL=!1,a.loading.medicinalItem=!1):(a.medicinalLeafL="",a.loading.medicinalLeafL=!1,a.isDisabled.medicinalLeafL=!0,a.medicinalItem="",a.loading.medicinalItem=!1,a.isDisabled.medicinalItem=!0,a.isDisabled.btnAddLine=!0)}));case 5:return i.abrupt("return",i.sent);case 6:case"end":return i.stop()}}),i)})))()},getMedicinalLeafItemV:function(e,a){var i=this;return l(n().mark((function t(){var s;return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return i.loading.medicinalItem=!0,s={medicinalLeafTypesH:e,medicinalLeafTypesL:a},t.next=4,axios.get("/pd/ajax/history-instead-grades/get-medicinal-leaf-item-v",{params:s}).then((function(e){i.medicinalLeafItems=e.data.medicinalLeafItemV,0!=i.medicinalLeafItems.length?(i.medicinalItem=i.medicinalItem?i.medicinalItem:"",i.loading.medicinalItem=!1,i.isDisabled.medicinalItem=!1):(i.medicinalItem="",i.loading.medicinalItem=!1,i.isDisabled.medicinalItem=!0)}));case 4:return t.abrupt("return",t.sent);case 5:case"end":return t.stop()}}),t)})))()},getMedicinalItem:function(e,a,i){var t=this;return l(n().mark((function s(){return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:t.isDisabled.btnAddLine=!(e&&a&&i);case 1:case"end":return n.stop()}}),s)})))()},search:function(e,a,i){var t=this;return l(n().mark((function s(){var l,r;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if((l=t).medicinalLeafH){n.next=6;break}return l.isValidate.medicinalLeafH=!0,n.abrupt("return");case 6:l.isValidate.medicinalLeafH=!1;case 7:if(l.medicinalLeafL||0!=l.isDisabled.medicinalLeafL){n.next=12;break}return l.isValidate.medicinalLeafL=!0,n.abrupt("return");case 12:l.isValidate.medicinalLeafL=!1;case 13:if(l.medicinalItem||0!=l.isDisabled.medicinalItem){n.next=18;break}return l.isValidate.medicinalItem=!0,n.abrupt("return");case 18:l.isValidate.medicinalItem=!1;case 19:if(1!=t.isValidate.medicinalLeafH||1!=t.isValidate.medicinalLeafL){n.next=21;break}return n.abrupt("return");case 21:return r={medicinalLeafH:e,medicinalLeafL:a,medicinalItem:i},t.medicinalItem=t.medicinalItem?t.medicinalItem:"",t.loading.table=!0,$(".table-data").DataTable().destroy(),n.next=27,axios.get("/pd/ajax/history-instead-grades/search",{params:r}).then((function(e){t.historyList=e.data.historyList,t.lastNumberSeq=e.data.lastNumberSeq,t.loading.table=!1}));case 27:$(".table-data").dataTable({searching:!1,order:[[0,"desc"]],columnDefs:[{orderable:!1,targets:0},{orderable:!1,targets:1},{orderable:!1,targets:2},{orderable:!1,targets:7}]});case 28:case"end":return n.stop()}}),s)})))()}}};const d=(0,i(51900).Z)(r,(function(){var e=this,a=e.$createElement,i=e._self._c||a;return i("div",[i("div",{staticClass:"ibox"},[i("div",{staticClass:"ibox-content"},[i("div",{staticClass:"text-right"},[i("div",{staticClass:"text-right",staticStyle:{"padding-top":"5px"}},[i("button",{staticClass:"btn btn-light",on:{click:function(a){return a.preventDefault(),e.search(e.medicinalLeafH,e.medicinalLeafL,e.medicinalItem)}}},[i("i",{staticClass:"fa fa-search",attrs:{"aria-hidden":"true"}}),e._v(" ค้นหา \n                    ")]),e._v(" "),i("a",{staticClass:"btn btn-danger",attrs:{type:"button",href:"/pd/history-instead-grades"}},[e._v("\n                        ล้างค่า\n                    ")])])]),e._v(" "),i("div",{staticClass:"row",staticStyle:{"padding-top":"20px"}},[i("div",{staticClass:"col-md-4"},[i("label",[e._v("ประเภทใบยา")]),i("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),i("el-select",{staticClass:"w-100",attrs:{placeholder:"เลือกประเภทใบยา",clearable:"",filterable:"","reserve-keyword":""},on:{change:function(a){return e.getMedicinalLeafTypesL(e.medicinalLeafH)}},model:{value:e.medicinalLeafH,callback:function(a){e.medicinalLeafH=a},expression:"medicinalLeafH"}},e._l(e.medicinalLeafTypesH,(function(e,a){return i("el-option",{key:a,attrs:{label:e.category_code_1+" : "+e.category_desc_1,value:e.category_code_1+"."+e.category_desc_1}})})),1),e._v(" "),this.isValidate.medicinalLeafH?i("div",[i("span",{staticClass:"form-text m-b-none text-danger"},[e._v("\n                            "+e._s("กรุณาเลือกประเภทใบยา")+"\n                        ")])]):e._e()],1),e._v(" "),i("div",{staticClass:"col-md-4"},[i("label",[e._v("ชนิดใบยา")]),i("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),i("el-select",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.medicinalLeafL,expression:"loading.medicinalLeafL"}],staticClass:"w-100",attrs:{placeholder:"เลือกชนิดใบยา",clearable:"",filterable:"","reserve-keyword":"",disabled:e.isDisabled.medicinalLeafL},on:{change:function(a){return e.getMedicinalLeafItemV(e.medicinalLeafH,e.medicinalLeafL)}},model:{value:e.medicinalLeafL,callback:function(a){e.medicinalLeafL=a},expression:"medicinalLeafL"}},e._l(e.medicinalLeafTypesL,(function(e,a){return i("el-option",{key:a,attrs:{label:e.category_code_2+" : "+e.category_desc_2,value:e.category_code_2+"."+e.category_desc_2}})})),1),e._v(" "),this.isValidate.medicinalLeafL?i("div",[i("span",{staticClass:"form-text m-b-none text-danger"},[e._v("\n                            "+e._s("กรุณาเลือกชนิดใบยา")+"\n                        ")])]):e._e()],1),e._v(" "),i("div",{staticClass:"col-md-4"},[i("label",[e._v("รหัสใบยา")]),i("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),i("el-select",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.medicinalItem,expression:"loading.medicinalItem"}],staticClass:"w-100",attrs:{placeholder:"เลือกรหัสใบยา",clearable:"",filterable:"","reserve-keyword":"",disabled:e.isDisabled.medicinalItem},on:{change:function(a){return e.getMedicinalItem(e.medicinalLeafH,e.medicinalLeafL,e.medicinalItem)}},model:{value:e.medicinalItem,callback:function(a){e.medicinalItem=a},expression:"medicinalItem"}},e._l(e.medicinalLeafItems,(function(e,a){return i("el-option",{key:a,attrs:{label:e.item_code+" : "+e.item_desc,value:e.item_id}})})),1),e._v(" "),this.isValidate.medicinalItem?i("div",[i("span",{staticClass:"form-text m-b-none text-danger"},[e._v("\n                            "+e._s("กรุณาเลือกรหัสใบยา")+"\n                        ")])]):e._e()],1)])])]),e._v(" "),i("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.table,expression:"loading.table"}]},[i("history-instead-grades-table",{attrs:{medicinalLeafItems:e.medicinalLeafItems,isDisabledBtnAddLine:e.isDisabled.btnAddLine,transDate:e.transDate,historyList:e.historyList,transBtn:e.transBtn,lastNumberSeq:e.lastNumberSeq,currentDateTH:e.currentDateTH}})],1)])}),[],!1,null,null,null).exports},51900:(e,a,i)=>{"use strict";function t(e,a,i,t,n,s,l,r){var d,c="function"==typeof e?e.options:e;if(a&&(c.render=a,c.staticRenderFns=i,c._compiled=!0),t&&(c.functional=!0),s&&(c._scopeId="data-v-"+s),l?(d=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(l)},c._ssrRegister=d):n&&(d=r?function(){n.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:n),d)if(c.functional){c._injectStyles=d;var o=c.render;c.render=function(e,a){return d.call(a),o(e,a)}}else{var m=c.beforeCreate;c.beforeCreate=m?[].concat(m,d):[d]}return{exports:e,options:c}}i.d(a,{Z:()=>t})}}]);