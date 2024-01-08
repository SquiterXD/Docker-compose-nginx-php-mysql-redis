(self.webpackChunk=self.webpackChunk||[]).push([[4067],{74067:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>d});var o=a(87757),n=a.n(o),i=a(23570),r=a.n(i);function s(e,t,a,o,n,i,r){try{var s=e[i](r),c=s.value}catch(e){return void a(e)}s.done?t(c):Promise.resolve(c).then(o,n)}function c(e){return function(){var t=this,a=arguments;return new Promise((function(o,n){var i=e.apply(t,a);function r(e){s(i,o,n,r,c,"next",e)}function c(e){s(i,o,n,r,c,"throw",e)}r(void 0)}))}}const l={props:["header","itemLocators","itemCategories","backUrl","data","btnTrans"],data:function(){return{flag:"",activeFlag:"Y"==this.header.active_flag,confirmActiveFlag:"",openProgamFlag:"",isDisabled:!1,cate_code:"",lines:[],linesOld:[],id:r()(),productInvHeader:this.header.header_id,subinventoryCode:this.header.subinventory_code,subinventoryDesc:this.header.subinventory_desc,groupProductId:this.header.group_product_id,loading:{locator:"",page:!1},itemLocatorsLists:this.itemLocators}},mounted:function(){var e=this;this.header.product_inv_lines.forEach((function(t){e.lines.push({id:r()(),lineId:t.line_id,cate_code:Number(t.category_code),locator:t.zone_code,delRow:!0})})),0==this.itemLocatorsLists.length&&(this.isDisabled=!0),this.header.product_inv_lines.forEach((function(t){e.linesOld.push({id:r()(),lineId:t.line_id,cate_code_old:Number(t.category_code),locator_old:t.zone_code,delRow:!0})})),"DuplicateLine"==this.data&&swal({title:"warning !",text:"มีข้อมูลซ้ำ ระดับ Line",type:"warning",showConfirmButton:!0})},methods:{checkDuplicateCategory:function(e){var t=this;this.lines.forEach((function(a,o){if(o!=e&&t.lines[e].cate_code==a.cate_code&&t.lines[e].locator==a.locator)return t.showAlert(),t.lines[e].locator="",void(t.lines[e].cate_code="")}))},checkDuplicateLocators:function(e){var t=this;this.lines.forEach((function(a,o){if(o!=e&&t.lines[e].locator==a.locator&&t.lines[e].cate_code==a.cate_code)return t.showAlert(),t.lines[e].cate_code="",void(t.lines[e].locator="")})),""!=this.lines.locator&&this.searchFunction()},showAlert:function(){swal({title:"Error !",text:"ไม่สามารถเลือกชุดข้อมูลนี้ได้ เนื่องจากมีชุดข้อมูลซ้ำ",type:"error",showConfirmButton:!0})},addLine:function(){this.lines.push({id:r()(),lineId:"",cate_code:"",locator:"",delRow:!1})},removeRow:function(e,t,a){var o={sub_group_id:a.lineId};t?swal({title:"Are you sure?",text:"You will not be able to recover this data!",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"Confirm",closeOnConfirm:!1},(function(e){e&&axios.get("/ir/ajax/destroy",{params:o}).then((function(e){"s"===e.data.status&&(swal({title:"Deleted!",text:"Your data has been deleted.",type:"success",showConfirmButton:!1}),window.location.reload(!1))}))})):this.lines.splice(e,1)},searchFunction:function(e){var t=this;return c(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t.loading.locator=!0,a.next=3,axios.get("/ir/ajax/get-value-set",{params:{subinventory_code:t.subinventoryCode,status:"Edit",query:e}}).then((function(e){t.itemLocatorsLists=e.data.data})).catch((function(e){console.log(e)})).then((function(){t.loading.locator=!1}));case 3:case"end":return a.stop()}}),a)})))()},checkActive:function(e,t){var a=this;return c(n().mark((function o(){var i,r;return n().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:return i={header_id:e,active_flag:t?"Y":"N"},a.loading.page=!0,r=a,o.next=5,axios.get("/ir/ajax/product-header/getDataActiveFlag",{params:i}).then((function(e){"IRM0004Close"==e.data.status&&(swal({title:"คุณต้องการเปิดใช้งานใช่ไหม?",text:"ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 และ IRM0005 ใช่ไหม?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"เปิดการใช้งาน",closeOnConfirm:!1},(function(t){t&&(r.confirmActiveFlag=!0,r.openProgamFlag=e.data.status,swal.close())})),a.loading.page=!1),"twoClose"==e.data.status&&(swal({title:"คุณต้องการเปิดใช้งานใช่ไหม?",text:"ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า และ IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 IRM0009 และ IRM0005 ใช่ไหม?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"เปิดการใช้งาน",closeOnConfirm:!1},(function(t){t&&(r.confirmActiveFlag=!0,r.openProgamFlag=e.data.status,swal.close())})),a.loading.page=!1),"IRM0009Close"==e.data.status&&(swal({title:"คุณต้องการเปิดใช้งานใช่ไหม?",text:"ข้อมูลหน้า IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0009 และ IRM0005 ใช่ไหม?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"เปิดการใช้งาน",closeOnConfirm:!1},(function(t){t&&(r.confirmActiveFlag=!0,r.openProgamFlag=e.data.status,swal.close())})),a.loading.page=!1),"success"==e.data.status&&(a.loading.page=!1)}));case 5:return o.abrupt("return",o.sent);case 6:case"end":return o.stop()}}),o)})))()}}};const d=(0,a(51900).Z)(l,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.page,expression:"loading.page"}]},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.subinventoryDesc,expression:"subinventoryDesc"}],attrs:{type:"hidden",name:"subinventory_desc",autocomplete:"off"},domProps:{value:e.subinventoryDesc},on:{input:function(t){t.target.composing||(e.subinventoryDesc=t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.subinventoryCode,expression:"subinventoryCode"}],attrs:{type:"hidden",name:"subinventory_code",autocomplete:"off"},domProps:{value:e.subinventoryCode},on:{input:function(t){t.target.composing||(e.subinventoryCode=t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.productInvHeader,expression:"productInvHeader"}],attrs:{type:"hidden",name:"productInvHeader",autocomplete:"off"},domProps:{value:e.productInvHeader},on:{input:function(t){t.target.composing||(e.productInvHeader=t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.groupProductId,expression:"groupProductId"}],attrs:{type:"hidden",name:"groupProductId",autocomplete:"off"},domProps:{value:e.groupProductId},on:{input:function(t){t.target.composing||(e.groupProductId=t.target.value)}}}),e._v(" "),a("div",{staticClass:"mt-2"},[a("div",{staticClass:"text-right"},[a("button",{class:e.btnTrans.add.class+" btn-sm",attrs:{type:"submit"},on:{click:function(t){return t.preventDefault(),e.addLine(t)}}},[a("i",{class:e.btnTrans.add.icon,attrs:{"aria-hidden":"true"}}),e._v(" "+e._s(e.btnTrans.add.text)+" \n            ")])]),a("br"),e._v(" "),a("table",{staticClass:"table table-responsive-sm"},[e._m(0),e._v(" "),a("tbody",e._l(e.lines,(function(t,o){return a("tr",{key:o,attrs:{row:t}},[a("td",{staticStyle:{"vertical-align":"middle"}},[e._v(" "+e._s(o+1)+" ")]),e._v(" "),a("td",{attrs:{id:"message"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.lineId,expression:"row.lineId"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][line_id]",autocomplete:"off"},domProps:{value:t.lineId},on:{input:function(a){a.target.composing||e.$set(t,"lineId",a.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.cate_code,expression:"row.cate_code"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][cate_codes]",autocomplete:"off"},domProps:{value:t.cate_code},on:{input:function(a){a.target.composing||e.$set(t,"cate_code",a.target.value)}}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"",clearable:"","reserve-keyword":""},on:{change:function(t){return e.checkDuplicateCategory(o)}},model:{value:t.cate_code,callback:function(a){e.$set(t,"cate_code",a)},expression:"row.cate_code"}},e._l(e.itemCategories,(function(e,t){return a("el-option",{key:t,attrs:{label:e.lookup_code+" : "+e.description,value:e.lookup_code}})})),1)],1),e._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.locator,expression:"row.locator"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][locators]",autocomplete:"off"},domProps:{value:t.locator},on:{input:function(a){a.target.composing||e.$set(t,"locator",a.target.value)}}}),e._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.locator,expression:"loading.locator"}],staticClass:"w-100",attrs:{filterable:"",remote:"",clearable:"","reserve-keyword":"",disabled:e.isDisabled,"remote-method":e.searchFunction},on:{change:function(t){return e.checkDuplicateLocators(o)}},model:{value:t.locator,callback:function(a){e.$set(t,"locator",a)},expression:"row.locator"}},e._l(e.itemLocatorsLists,(function(e,t){return a("el-option",{key:t,attrs:{label:e.meaning+" : "+e.description,value:e.flex_value}})})),1)],1),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(a){return a.preventDefault(),e.removeRow(o,t.delRow,t)},change:function(a){return e.removeRowData(t,o)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])})),0)]),e._v(" "),e._l(e.linesOld,(function(t,o){return a("div",{key:o,attrs:{row:t}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.lineId,expression:"row.lineId"}],attrs:{type:"hidden",name:"dataGroupOld["+t.id+"][line_id]",autocomplete:"off"},domProps:{value:t.lineId},on:{input:function(a){a.target.composing||e.$set(t,"lineId",a.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.cate_code_old,expression:"row.cate_code_old"}],attrs:{type:"hidden",name:"dataGroupOld["+t.id+"][cate_code_old]",autocomplete:"off"},domProps:{value:t.cate_code_old},on:{input:function(a){a.target.composing||e.$set(t,"cate_code_old",a.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.locator_old,expression:"row.locator_old"}],attrs:{type:"hidden",name:"dataGroupOld["+t.id+"][locators_old]",autocomplete:"off"},domProps:{value:t.locator_old},on:{input:function(a){a.target.composing||e.$set(t,"locator_old",a.target.value)}}})])}))],2),e._v(" "),a("div",{staticClass:"row",staticStyle:{"padding-left":"15px","padding-top":"10px"}},[a("label",[e._v("Active")]),a("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.flag,expression:"flag"}],attrs:{type:"hidden",name:"activeFlag"},domProps:{value:e.flag},on:{input:function(t){t.target.composing||(e.flag=t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.confirmActiveFlag,expression:"confirmActiveFlag"}],attrs:{type:"hidden",name:"confirmActiveFlag"},domProps:{value:e.confirmActiveFlag},on:{input:function(t){t.target.composing||(e.confirmActiveFlag=t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.openProgamFlag,expression:"openProgamFlag"}],attrs:{type:"hidden",name:"openProgamFlag"},domProps:{value:e.openProgamFlag},on:{input:function(t){t.target.composing||(e.openProgamFlag=t.target.value)}}}),e._v(" "),a("el-checkbox",{staticStyle:{"margin-left":"45px"},attrs:{checked:e.activeFlag},on:{change:function(t){return e.checkActive(e.header.header_id,e.flag)}},model:{value:e.flag,callback:function(t){e.flag=t},expression:"flag"}})],1),e._v(" "),a("div",{staticClass:"row clearfix text-right"},[a("div",{staticClass:"col",staticStyle:{"margin-top":"15px"}},[a("button",{class:e.btnTrans.save.class+" btn-sm",attrs:{type:"submit"}},[a("i",{class:e.btnTrans.save.icon,attrs:{"aria-hidden":"true"}}),e._v(" \n                "+e._s(e.btnTrans.save.text)+" \n            ")]),e._v(" "),a("a",{class:e.btnTrans.cancel.class+" btn-sm",attrs:{href:e.backUrl,type:"button"}},[a("i",{class:e.btnTrans.cancel.icon,attrs:{"aria-hidden":"true"}}),e._v(" \n                "+e._s(e.btnTrans.cancel.text)+"\n            ")])])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("thead",[a("tr",[a("th",{attrs:{width:"1%"}}),e._v(" "),a("th",{attrs:{width:"70%"}},[e._v(" รหัสประเภท (Category Code) ")]),e._v(" "),a("th",{attrs:{width:"30%"}},[e._v(" Locator ")]),e._v(" "),a("th",{attrs:{width:"1%"}})])])}],!1,null,null,null).exports}}]);