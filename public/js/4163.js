(self.webpackChunk=self.webpackChunk||[]).push([[4163],{94163:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>l});var o=a(87757),n=a.n(o);function i(t,e,a,o,n,i,r){try{var s=t[i](r),l=s.value}catch(t){return void a(t)}s.done?e(l):Promise.resolve(l).then(o,n)}function r(t){return function(){var e=this,a=arguments;return new Promise((function(o,n){var r=t.apply(e,a);function s(t){i(r,o,n,s,l,"next",t)}function l(t){i(r,o,n,s,l,"throw",t)}s(void 0)}))}}const s={props:["dataSetup","wipTransaction","tobaccoItemcats","transactionTypes","parameters","organizationId","dataItemTypes","orgA12"],data:function(){return{wip:this.dataSetup?this.dataSetup.wip_transaction_type_id:"",tobaccoItemcat:this.dataSetup?this.dataSetup.tobacco_group_code:"",transaction:this.dataSetup?this.dataSetup.transaction_type_id:"",id:this.dataSetup?this.dataSetup.id:"",itemType:this.dataSetup?this.dataSetup.inv_item_type:"",olditemType:this.dataSetup?this.dataSetup.inv_item_type:"",organizationFrom:this.dataSetup?this.dataSetup.from_organization_id:"",inventoryFrom:this.dataSetup?this.dataSetup.from_locator_id:"",organizationTo:this.dataSetup?this.dataSetup.to_organization_id:"",inventoryTo:this.dataSetup?this.dataSetup.to_locator_id:"",locationFromLists:[],locationToLists:[],checked:this.dataSetup?"Y"==this.dataSetup.enable_flag:"",oldchecked:this.dataSetup?"Y"==this.dataSetup.enable_flag:"",loading:{inventoryLocationFrome:!1,inventoryLocationTo:!1,transactionTypes:!1},isDisabledLocationFrome:!0,isDisabledLocationTo:!0,isDisabledTransaction:this.organizationId==this.orgA12.organization_id,transactionTypesList:this.transactionTypes}},mounted:function(){this.getLocationsFrom(this.dataSetup?this.dataSetup.from_organization_id:""),this.getLocationsTo(this.dataSetup?this.dataSetup.to_organization_id:"")},methods:{getLocationsFrom:function(t){var e=this;return r(n().mark((function a(){var o;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return o={organization:t},e.loading.inventoryLocationFrome=!0,a.next=4,axios.get("/pm/ajax/org-tranfer/get_locations_from",{params:o}).then((function(t){0==t.data.itemLocationsFrom.length?(swal({title:"warning !",text:"organizationนี้ ไม่มีสถานที่จัดเก็บ",type:"warning",showConfirmButton:!0}),e.locationFromLists="",e.inventoryFrom="",e.isDisabledLocationFrome=!0,e.loading.inventoryLocationFrome=!1):(e.locationFromLists=t.data.itemLocationsFrom,e.loading.inventoryLocationFrome=!1,e.isDisabledLocationFrome=!1)}));case 4:return a.abrupt("return",a.sent);case 5:case"end":return a.stop()}}),a)})))()},getLocationsTo:function(t){var e=this;return r(n().mark((function a(){var o;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return o={organization:t},e.loading.inventoryLocationTo=!0,a.next=4,axios.get("/pm/ajax/org-tranfer/get_locations_to",{params:o}).then((function(t){0==t.data.itemLocationsTo.length?(swal({title:"warning !",text:"organizationนี้ ไม่มีสถานที่จัดเก็บ",type:"warning",showConfirmButton:!0}),e.locationToLists="",e.inventoryTo="",e.isDisabledLocationTo=!0,e.loading.inventoryLocationTo=!1):(e.locationToLists=t.data.itemLocationsTo,e.loading.inventoryLocationTo=!1,e.isDisabledLocationTo=!1)}));case 4:return a.abrupt("return",a.sent);case 5:case"end":return a.stop()}}),a)})))()},remoteMethod:function(t){var e=this;if(""!==t){var a=t;return this.loading.transactionTypes=!0,axios.get("/pm/ajax/org-tranfer/get_transaction_types",{params:a}).then((function(t){e.transactionTypesList=t.data.transactionTypes,e.loading.transactionTypes=!1}))}this.transactionTypesList=this.transactionTypes}}};const l=(0,a(51900).Z)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"container"},[a("div",{staticClass:"row justify-content-center"},[a("div",{staticClass:"col-md-10"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.id,expression:"id"}],attrs:{type:"hidden",name:"id"},domProps:{value:t.id},on:{input:function(e){e.target.composing||(t.id=e.target.value)}}}),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px"}},[a("label",[t._v("คลังสำหรับทำรายการ")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.wip,expression:"wip"}],attrs:{type:"hidden",name:"wip_transaction_type_id"},domProps:{value:t.wip},on:{input:function(e){e.target.composing||(t.wip=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{clearable:"",filterable:"",placeholder:"เลือกคลังเพื่อทำรายการ"},model:{value:t.wip,callback:function(e){t.wip=e},expression:"wip"}},t._l(t.wipTransaction,(function(t,e){return a("el-option",{key:e,attrs:{label:t.attribute3,value:t.transaction_type_id}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px"}},[a("label",[t._v("ประเภท Item")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.tobaccoItemcat,expression:"tobaccoItemcat"}],attrs:{type:"hidden",name:"tobacco_group_code"},domProps:{value:t.tobaccoItemcat},on:{input:function(e){e.target.composing||(t.tobaccoItemcat=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{clearable:"",filterable:"",placeholder:"เลือกประเภท Item"},model:{value:t.tobaccoItemcat,callback:function(e){t.tobaccoItemcat=e},expression:"tobaccoItemcat"}},t._l(t.tobaccoItemcats,(function(t){return a("el-option",{key:t.group_code,attrs:{label:t.meaning+" : "+t.group_desc,value:t.group_code}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-5",staticStyle:{"padding-top":"15px"}},[a("label",[t._v("คลังต้นทาง")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.organizationFrom,expression:"organizationFrom"}],attrs:{type:"hidden",name:"from_organization_id"},domProps:{value:t.organizationFrom},on:{input:function(e){e.target.composing||(t.organizationFrom=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Organization"},on:{change:function(e){return t.getLocationsFrom(t.organizationFrom)}},model:{value:t.organizationFrom,callback:function(e){t.organizationFrom=e},expression:"organizationFrom"}},t._l(t.parameters,(function(t){return a("el-option",{key:t.organization_id,attrs:{label:t.organization_code+" : "+t.hr_all_organization_units.name,value:t.organization_id}})})),1)],1),t._v(" "),a("div",{staticClass:"col-7",staticStyle:{"padding-top":"43px"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.inventoryFrom,expression:"inventoryFrom"}],attrs:{type:"hidden",name:"from_locator_id"},domProps:{value:t.inventoryFrom},on:{input:function(e){e.target.composing||(t.inventoryFrom=e.target.value)}}}),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.inventoryLocationFrome,expression:"loading.inventoryLocationFrome"}],staticClass:"w-100",attrs:{clearable:"",filterable:"",disabled:t.isDisabledLocationFrome,placeholder:"เลือกสถานที่"},model:{value:t.inventoryFrom,callback:function(e){t.inventoryFrom=e},expression:"inventoryFrom"}},t._l(t.locationFromLists,(function(t){return a("el-option",{key:t.inventory_location_id,attrs:{label:t.concatenated_segments+" : "+t.description,value:t.inventory_location_id}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-5",staticStyle:{"padding-top":"15px"}},[a("label",[t._v("คลังปลายทาง")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.organizationTo,expression:"organizationTo"}],attrs:{type:"hidden",name:"to_organization_id"},domProps:{value:t.organizationTo},on:{input:function(e){e.target.composing||(t.organizationTo=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"Organization"},on:{change:function(e){return t.getLocationsTo(t.organizationTo)}},model:{value:t.organizationTo,callback:function(e){t.organizationTo=e},expression:"organizationTo"}},t._l(t.parameters,(function(t){return a("el-option",{key:t.organization_id,attrs:{label:t.organization_code+" : "+t.hr_all_organization_units.name,value:t.organization_id}})})),1)],1),t._v(" "),a("div",{staticClass:"col-7",staticStyle:{"padding-top":"43px"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.inventoryTo,expression:"inventoryTo"}],attrs:{type:"hidden",name:"to_locator_id"},domProps:{value:t.inventoryTo},on:{input:function(e){e.target.composing||(t.inventoryTo=e.target.value)}}}),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.inventoryLocationTo,expression:"loading.inventoryLocationTo"}],staticClass:"w-100",attrs:{clearable:"",filterable:"",disabled:t.isDisabledLocationTo,placeholder:"เลือกสถานที่"},model:{value:t.inventoryTo,callback:function(e){t.inventoryTo=e},expression:"inventoryTo"}},t._l(t.locationToLists,(function(t){return a("el-option",{key:t.inventory_location_id,attrs:{label:t.concatenated_segments+" : "+t.description,value:t.inventory_location_id}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px"}},[a("label",[t._v("ประเภทการทำรายการ")]),t.organizationId!=this.orgA12.organization_id?a("span",{staticClass:"text-danger"},[t._v(" *")]):t._e(),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.transaction,expression:"transaction"}],attrs:{type:"hidden",name:"transaction_type_id"},domProps:{value:t.transaction},on:{input:function(e){e.target.composing||(t.transaction=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{clearable:"",filterable:"",remote:"","reserve-keyword":"",placeholder:"ประเภทการทำรายการ","remote-method":t.remoteMethod,loading:t.loading.transactionTypes,disabled:t.isDisabledTransaction},model:{value:t.transaction,callback:function(e){t.transaction=e},expression:"transaction"}},t._l(t.transactionTypesList,(function(t){return a("el-option",{key:t.transaction_type_id,attrs:{label:t.transaction_type_name,value:t.transaction_type_id}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px"}},[a("label",[t._v("ประเภทวัตถุดิบ")]),t.organizationId==this.orgA12.organization_id?a("span",{staticClass:"text-danger"},[t._v(" *")]):t._e(),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.itemType,expression:"itemType"}],attrs:{type:"hidden",name:"inv_item_type"},domProps:{value:t.itemType},on:{input:function(e){e.target.composing||(t.itemType=e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.olditemType,expression:"olditemType"}],attrs:{type:"hidden",name:"old_inv_item_type"},domProps:{value:t.olditemType},on:{input:function(e){e.target.composing||(t.olditemType=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{clearable:"",filterable:"",placeholder:"ประเภทวัตถุดิบ"},model:{value:t.itemType,callback:function(e){t.itemType=e},expression:"itemType"}},t._l(t.dataItemTypes,(function(t,e){return a("el-option",{key:e,attrs:{label:t.attribute11,value:t.lookup_code}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px","padding-bottom":"15px"}},[a("label",[t._v("เปิดการใช้งาน")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.checked,expression:"checked"}],attrs:{type:"hidden",name:"enable_flag"},domProps:{value:t.checked},on:{input:function(e){e.target.composing||(t.checked=e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.oldchecked,expression:"oldchecked"}],attrs:{type:"hidden",name:"old_enable_flag"},domProps:{value:t.oldchecked},on:{input:function(e){e.target.composing||(t.oldchecked=e.target.value)}}}),t._v(" "),a("el-checkbox",{staticClass:"w-100",model:{value:t.checked,callback:function(e){t.checked=e},expression:"checked"}})],1)])])])])}),[],!1,null,null,null).exports},51900:(t,e,a)=>{"use strict";function o(t,e,a,o,n,i,r,s){var l,c="function"==typeof t?t.options:t;if(e&&(c.render=e,c.staticRenderFns=a,c._compiled=!0),o&&(c.functional=!0),i&&(c._scopeId="data-v-"+i),r?(l=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),n&&n.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},c._ssrRegister=l):n&&(l=s?function(){n.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(t,e){return l.call(e),d(t,e)}}else{var p=c.beforeCreate;c.beforeCreate=p?[].concat(p,l):[l]}return{exports:t,options:c}}a.d(e,{Z:()=>o})}}]);