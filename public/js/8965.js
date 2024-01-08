(self.webpackChunk=self.webpackChunk||[]).push([[8965,4782],{68965:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>m});var i=a(87757),n=a.n(i);function r(t,e,a,i,n,r,o){try{var s=t[r](o),m=s.value}catch(t){return void a(t)}s.done?e(m):Promise.resolve(m).then(i,n)}function o(t){return function(){var e=this,a=arguments;return new Promise((function(i,n){var o=t.apply(e,a);function s(t){r(o,i,n,s,m,"next",t)}function m(t){r(o,i,n,s,m,"throw",t)}s(void 0)}))}}const s={components:{SetupMinMaxByItemTable:a(84782).default},props:["tobaccoItemcatList","searchOld","btnTrans"],data:function(){return{organizationSearch:"",organizationShow:"",locationSearch:"",locationShow:"",itemNumber:"",itemcat:this.searchOld?this.searchOld.itemcat:"",primaryUomCode:"",primaryUnitOfMeasure:"",loading:{organizationShow:!1,locationShow:!1,itemNumber:!1,primaryUomCode:!1,primaryUnitOfMeasure:!1,itemcat:!1,tableData:!1},isDisabledItemNumber:!0,organizationList:[],itemLocationsList:[],itemNumberList:[],listSetupMinMax:[],listSearch:[],listSearchItemNumber:[]}},mounted:function(){var t=this;return o(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getOrganization(t.searchOld.itemcat);case 2:return e.next=4,t.search(t.searchOld.organization,t.searchOld.organization,t.searchOld.organization,t.searchOld.itemNumber);case 4:case"end":return e.stop()}}),e)})))()},methods:{fetchData:function(t){var e=this;return o(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return a.next=2,axios.get("/pm/ajax/setup-min-max-by-item/get-organization",{params:t}).then((function(t){""==t.data.organizationSearch||"noInput"==t.data.organizationList?(e.organizationSearch="",e.organizationShow="",e.loading.organizationShow=!1,e.loading.locationShow=!1,e.loading.itemNumber=!1,e.locationSearch="",e.locationShow="",e.itemNumber="",e.isDisabledItemNumber=!0):(e.organizationSearch=t.data.organization.organization_id,e.organizationShow=t.data.organization.organization_code+" : "+t.data.organization.organization_name,e.loading.organizationShow=!1,e.loading.locationShow=!1,e.loading.itemNumber=!1,e.locationSearch=t.data.itemLocation.locator_id,e.locationShow=t.data.itemLocation.locator_code+" : "+t.data.itemLocation.location_desc,e.itemNumberList=t.data.itemNumberList,e.isDisabledItemNumber=!1)}));case 2:case"end":return a.stop()}}),a)})))()},getOrganization:function(t){var e=this;return o(n().mark((function a(){var i;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return i={itemcat:t},e.loading.organizationShow=!0,e.loading.locationShow=!0,e.loading.itemNumber=!0,a.abrupt("return",e.fetchData(i));case 5:case"end":return a.stop()}}),a)})))()},search:function(t,e,a,i){var r=this;return o(n().mark((function o(){var s,m;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return s={organization:t,location:e,itemcat:a,itemNumber:i},r.loading.tableData=!0,m=r,n.next=5,axios.get("/pm/ajax/setup-min-max-by-item/search",{params:s}).then((function(t){r.listSetupMinMax=t.data.data.listSetupMinMax,r.listSearch=t.data.data.listSearch,r.listSearchItemNumber=t.data.data.listSearchItemNumber,m.$children[4].isDisabledBtuAdd=!1,r.loading.tableData=!1}));case 5:return console.log($("#setup-min-max-by-item-datatable").dataTable({searching:!1,ordering:!1})),n.abrupt("return",!0);case 7:case"end":return n.stop()}}),o)})))()}}};const m=(0,a(51900).Z)(s,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"ibox"},[a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-3"},[t._m(0),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.itemcat,expression:"itemcat"}],attrs:{type:"hidden",name:"search[itemcat]",autocomplete:"off"},domProps:{value:t.itemcat},on:{input:function(e){e.target.composing||(t.itemcat=e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.itemcat,expression:"itemcat"}],attrs:{type:"hidden",name:"itemcat",autocomplete:"off"},domProps:{value:t.itemcat},on:{input:function(e){e.target.composing||(t.itemcat=e.target.value)}}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{placeholder:"โปรดเลือกประเภทวัตถุดิบ",clearable:"",filterable:"",remote:"","reserve-keyword":""},on:{change:function(e){return t.getOrganization(t.itemcat)}},model:{value:t.itemcat,callback:function(e){t.itemcat=e},expression:"itemcat"}},t._l(t.tobaccoItemcatList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.tobacco_group_code+" : "+t.tobacco_group,value:t.tobacco_group_code}})})),1)],1),t._v(" "),a("div",{staticClass:"col-3"},[t._m(1),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.organizationSearch,expression:"organizationSearch"}],attrs:{type:"hidden",name:"search[organization]",autocomplete:"off"},domProps:{value:t.organizationSearch},on:{input:function(e){e.target.composing||(t.organizationSearch=e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.organizationSearch,expression:"organizationSearch"}],attrs:{type:"hidden",name:"organization",autocomplete:"off"},domProps:{value:t.organizationSearch},on:{input:function(e){e.target.composing||(t.organizationSearch=e.target.value)}}}),t._v(" "),a("el-input",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.organizationShow,expression:"loading.organizationShow"}],attrs:{placeholder:"organization",disabled:!0},model:{value:t.organizationShow,callback:function(e){t.organizationShow=e},expression:"organizationShow"}})],1),t._v(" "),a("div",{staticClass:"col-3"},[t._m(2),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.locationSearch,expression:"locationSearch"}],attrs:{type:"hidden",name:"search[location]",autocomplete:"off"},domProps:{value:t.locationSearch},on:{input:function(e){e.target.composing||(t.locationSearch=e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.locationSearch,expression:"locationSearch"}],attrs:{type:"hidden",name:"location",autocomplete:"off"},domProps:{value:t.locationSearch},on:{input:function(e){e.target.composing||(t.locationSearch=e.target.value)}}}),t._v(" "),a("el-input",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.locationShow,expression:"loading.locationShow"}],attrs:{placeholder:"คลังจัดเก็บ/สถานที่จัดเก็บ",disabled:!0},model:{value:t.locationShow,callback:function(e){t.locationShow=e},expression:"locationShow"}})],1),t._v(" "),a("div",{staticClass:"col-3"},[t._m(3),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.itemNumber,expression:"itemNumber"}],attrs:{type:"hidden",name:"search[itemNumber]",autocomplete:"off"},domProps:{value:t.itemNumber},on:{input:function(e){e.target.composing||(t.itemNumber=e.target.value)}}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.itemNumber,expression:"itemNumber"}],attrs:{type:"hidden",name:"itemNumber",autocomplete:"off"},domProps:{value:t.itemNumber},on:{input:function(e){e.target.composing||(t.itemNumber=e.target.value)}}}),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.itemNumber,expression:"loading.itemNumber"}],staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",placeholder:"โปรดเลือกรหัสวัตถุดิบ",disabled:t.isDisabledItemNumber},model:{value:t.itemNumber,callback:function(e){t.itemNumber=e},expression:"itemNumber"}},t._l(t.itemNumberList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1)]),t._v(" "),a("div",{staticClass:"text-right",staticStyle:{"padding-top":"15px"}},[a("button",{staticClass:"btn btn-light",on:{click:function(e){return e.preventDefault(),t.search(t.organizationSearch,t.locationSearch,t.itemcat,t.itemNumber)}}},[a("i",{staticClass:"fa fa-search",attrs:{"aria-hidden":"true"}}),t._v(" แสดงข้อมูล\n        ")]),t._v(" "),a("a",{staticClass:"btn btn-danger",attrs:{type:"button",href:"/pm/settings/setup-min-max-by-item"}},[t._v("\n          ล้างค่า\n        ")])])])]),t._v(" "),a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.tableData,expression:"loading.tableData"}]},[a("setup-min-max-by-item-table",{attrs:{organizationSearch:t.organizationSearch,itemNumberSearch:t.itemNumber,listSetupMinMax:t.listSetupMinMax,listSearchItemNumber:t.listSearchItemNumber,btnTrans:t.btnTrans}})],1)])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"w-100 text-left"},[a("strong",[t._v(" ประเภทวัตถุดิบ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"w-100 text-left"},[a("strong",[t._v(" Organization")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"w-100 text-left"},[a("strong",[t._v(" คลังจัดเก็บ/สถานที่จัดเก็บ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"w-100 text-left"},[a("strong",[t._v(" รหัสวัตถุดิบ ")])])}],!1,null,null,null).exports},84782:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>f});var i=a(87757),n=a.n(i),r=a(80455),o=a.n(r),s=a(23570),m=a.n(s);function l(t,e,a,i,n,r,o){try{var s=t[r](o),m=s.value}catch(t){return void a(t)}s.done?e(m):Promise.resolve(m).then(i,n)}function u(t){return function(){var e=this,a=arguments;return new Promise((function(i,n){var r=t.apply(e,a);function o(t){l(r,i,n,o,s,"next",t)}function s(t){l(r,i,n,o,s,"throw",t)}o(void 0)}))}}var c,d,p;const v={props:["organizationSearch","listSetupMinMax","listSearchItemNumber","itemNumberSearch","btnTrans"],watch:{listSetupMinMax:(p=u(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.testList=e;case 1:case"end":return t.stop()}}),t,this)}))),function(t){return p.apply(this,arguments)}),organizationSearch:(d=u(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.organization=e;case 1:case"end":return t.stop()}}),t,this)}))),function(t){return d.apply(this,arguments)}),itemNumberSearch:(c=u(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.itemNumber=e;case 1:case"end":return t.stop()}}),t,this)}))),function(t){return c.apply(this,arguments)})},components:{VueNumeric:o()},data:function(){return{checkedEdit:"",itemNumber:"",primaryUnitOfMeasure:"",minQty:"",maxQty:"",note:"",checkedEditUpdate:"",organization:this.organizationSearch,itemNumberDes:"",statusDup:"",uomList:[],lines:[],isDisabledBtuAdd:!0,testList:this.listSetupMinMax,loading:{location:!1,itemNumber:!1,primaryUnitOfMeasure:!1,itemcat:!1},id:m()(),isTextFlag:!0}},mounted:function(){},computed:{},methods:{checkNumberSmallValue:function(t,e,a){0!=e&&t>e?(a.remarkImpossibleSmallValue=!0,this.isDisabledBtuAdd=!0,swal({title:"เกิดข้อผิดพลาด !",text:"ค่าเฝ้าระวังต่ำสุดมีค่ามากกว่าค่าเฝ้าระวังสูงสุด จะไม่สามารถบันทึกข้อมูลได้",type:"error",showConfirmButton:!0})):(a.remarkImpossibleSmallValue=!1,a.remarkImpossibleHighValue=!1,this.isDisabledBtuAdd=!1)},checkNumberHighValue:function(t,e,a){0!=e&&t>e?(a.remarkImpossibleHighValue=!0,this.isDisabledBtuAdd=!0,swal({title:"เกิดข้อผิดพลาด !",text:"ค่าเฝ้าระวังสูงสุดมีค่าน้อยกว่าค่าเฝ้าระวังต่ำ จะไม่สามารถบันทึกข้อมูลได้",type:"error",showConfirmButton:!0})):(a.remarkImpossibleHighValue=!1,a.remarkImpossibleSmallValue=!1,this.isDisabledBtuAdd=!1)},checkInput:function(){var t=this;this.lines.forEach(function(){var e=u(n().mark((function e(a,i){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a.itemNumber&&a.maxQty&&a.minQty&&a.note?(console.log("have data"),t.isDisabledBtuAdd=!1):(console.log("no data"),t.isDisabledBtuAdd=!0);case 1:case"end":return e.stop()}}),e)})));return function(t,a){return e.apply(this,arguments)}}())},hasItem:function(t){var e=this;return u(n().mark((function a(){var i,r;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return r=!1,"NoSearchData"!=(i=e).listSetupMinMax&&i.listSetupMinMax.forEach(function(){var e=u(n().mark((function e(a,i){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a.item_number==t&&(r=!0);case 1:case"end":return e.stop()}}),e)})));return function(t,a){return e.apply(this,arguments)}}()),i.lines.forEach(function(){var e=u(n().mark((function e(a,i){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a.itemNumber==t&&(r=!0);case 1:case"end":return e.stop()}}),e)})));return function(t,a){return e.apply(this,arguments)}}()),a.abrupt("return",r);case 5:case"end":return a.stop()}}),a)})))()},addLine:function(){var t=this;return u(n().mark((function e(){var a,i;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:i=[],(a=t).listSearchItemNumber.forEach(function(){var t=u(n().mark((function t(e,r){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,a.hasItem(e.item_number);case 2:if(t.sent){t.next=4;break}i.push(e);case 4:case"end":return t.stop()}}),t)})));return function(e,a){return t.apply(this,arguments)}}()),t.lines.push({id:m()(),itemNumber:"",itemNumberDes:"",primaryUnitOfMeasure:"",minQty:"",maxQty:"",note:"",itemNumbersList:i,remarkImpossibleSmallValue:!1,remarkImpossibleHighValue:!1}),t.isDisabledBtuAdd=!0,t.isTextFlag=!1;case 6:case"end":return e.stop()}}),e)})))()},removeRow:function(t){this.lines.splice(t,1),this.isDisabledBtuAdd=!1,0==this.lines.length?this.isTextFlag=!0:this.isTextFlag=!1},getUom:function(t,e,a){var i=this;return u(n().mark((function r(){var o;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return e.itemNumbersList.forEach((function(a){a.inventory_item_id==t&&(e.itemNumber=a.item_number,e.itemNumberDes=a.item_desc)})),o={inventoryItemId:t,organization:a},i.loading.primaryUnitOfMeasure=!0,n.next=5,axios.get("/pm/ajax/setup-min-max-by-item/get-uom",{params:o}).then((function(t){""==t.data.data.dataUom?(e.primaryUnitOfMeasure="",i.loading.primaryUnitOfMeasure=!1):"Dup"==e.statusDup?(i.loading.primaryUnitOfMeasure=!1,e.primaryUnitOfMeasure="",e.statusDup=""):(i.uomList=t.data.data.dataUom,e.primaryUnitOfMeasure=i.uomList[0].primary_unit_of_measure,i.loading.primaryUnitOfMeasure=!1)}));case 5:return n.abrupt("return",n.sent);case 6:case"end":return n.stop()}}),r)})))()},removeRowTableData:function(t,e){var a={row:t,setupMinMaxId:e};swal({title:"คุณแน่ใจ?",text:"คุณต้องการลบข้อมูลใช่หรือไม่",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก",closeOnConfirm:!1},(function(t){t&&axios.get("/pm/ajax/setup-min-max-by-item/destroy",{params:a}).then((function(t){swal({title:"success !",text:"ข้อมูลได้ทำการลบเรียบร้อยแล้ว",type:"success",showConfirmButton:!1}),window.location.reload(!1)}))}))}}};const f=(0,a(51900).Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"ibox"},[t._m(0),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"text-right",staticStyle:{"padding-bottom":"15px"}},[a("button",{staticClass:"btn btn-sm btn-primary",attrs:{disabled:t.isDisabledBtuAdd},on:{click:function(e){return e.preventDefault(),t.addLine(e)}}},[a("i",{staticClass:"fa fa-plus",attrs:{"aria-hidden":"true"}}),t._v(" เพิ่มรายการ \n                ")])]),t._v(" "),a("table",{staticClass:"table",attrs:{id:"setup-min-max-by-item-datatable"}},[t._m(1),t._v(" "),"NoSearchData"==t.testList?a("tbody",[a("tr",[t.isTextFlag?a("td",{staticClass:"text-center",attrs:{colspan:"8"}},[a("h2",[t._v(t._s("ไม่มีข้อมูล กำหนดค่าเฝ้าระวัง"))])]):t._e()]),t._v(" "),t._l(t.lines,(function(e,i){return a("tr",{key:i,attrs:{row:e}},[a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.itemNumber,expression:"row.itemNumber"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][item_number]",autocomplete:"off"},domProps:{value:e.itemNumber},on:{input:function(a){a.target.composing||t.$set(e,"itemNumber",a.target.value)}}}),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.itemNumber,expression:"loading.itemNumber"}],staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"Select"},on:{change:function(a){return t.getUom(e.itemNumber,e,t.organization)}},model:{value:e.itemNumber,callback:function(a){t.$set(e,"itemNumber",a)},expression:"row.itemNumber"}},t._l(e.itemNumbersList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1),t._v(" "),a("td",{staticStyle:{"vertical-align":"middle","padding-left":"10px"}},[t._v("\n                            "+t._s(e.itemNumberDes)+" \n                        ")]),t._v(" "),a("td",[a("el-input",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.primaryUnitOfMeasure,expression:"loading.primaryUnitOfMeasure"}],attrs:{disabled:!0},model:{value:e.primaryUnitOfMeasure,callback:function(a){t.$set(e,"primaryUnitOfMeasure",a)},expression:"row.primaryUnitOfMeasure"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.minQty,expression:"row.minQty"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][min_qty]",autocomplete:"off"},domProps:{value:e.minQty},on:{input:function(a){a.target.composing||t.$set(e,"minQty",a.target.value)}}}),t._v(" "),a("vue-numeric",{class:"form-control text-right "+(e.remarkImpossibleSmallValue?"is-invalid":""),attrs:{separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkNumberSmallValue(e.minQty,e.maxQty,e)}},model:{value:e.minQty,callback:function(a){t.$set(e,"minQty",a)},expression:"row.minQty"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.maxQty,expression:"row.maxQty"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][max_qty]",autocomplete:"off"},domProps:{value:e.maxQty},on:{input:function(a){a.target.composing||t.$set(e,"maxQty",a.target.value)}}}),t._v(" "),a("vue-numeric",{class:"form-control text-right "+(e.remarkImpossibleHighValue?"is-invalid":""),attrs:{separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkNumberHighValue(e.minQty,e.maxQty,e)}},model:{value:e.maxQty,callback:function(a){t.$set(e,"maxQty",a)},expression:"row.maxQty"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.note,expression:"row.note"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][remark_msg]",autocomplete:"off"},domProps:{value:e.note},on:{input:function(a){a.target.composing||t.$set(e,"note",a.target.value)}}}),t._v(" "),a("el-input",{attrs:{type:"textarea",rows:1,placeholder:"Please input"},model:{value:e.note,callback:function(a){t.$set(e,"note",a)},expression:"row.note"}})],1),t._v(" "),a("td",[a("button",{staticClass:"btn btn-sm btn-danger col text-center",on:{click:function(e){return e.preventDefault(),t.removeRow(i)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])}))],2):0!=t.testList.length?a("tbody",[t._l(t.testList,(function(e,i){return a("tr",{key:"showData"+i,attrs:{row:i}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.setup_min_max_id,expression:"test.setup_min_max_id"}],attrs:{type:"hidden",name:"updateDataGroup["+i+"][setup_min_max_id]",autocomplete:"off"},domProps:{value:e.setup_min_max_id},on:{input:function(a){a.target.composing||t.$set(e,"setup_min_max_id",a.target.value)}}}),t._v(" "),a("td",{staticStyle:{"vertical-align":"middle","padding-left":"10px"}},[t._v(" \n                            "+t._s(e.item_number)+"\n                        ")]),t._v(" "),a("td",{staticStyle:{"vertical-align":"middle","padding-left":"10px"}},[t._v("\n                            "+t._s(e.item_desc)+"\n                        ")]),t._v(" "),a("td",{staticStyle:{"vertical-align":"middle","padding-left":"10px"}},[t._v("\n                            "+t._s(e.primary_unit_of_measure)+"\n                        ")]),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.min_qty,expression:"test.min_qty"}],attrs:{type:"hidden",name:"updateDataGroup["+i+"][min_qty]",autocomplete:"off"},domProps:{value:e.min_qty},on:{input:function(a){a.target.composing||t.$set(e,"min_qty",a.target.value)}}}),t._v(" "),a("vue-numeric",{class:"form-control text-right "+(e.remarkImpossibleSmallValue?"is-invalid":""),attrs:{separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkNumberSmallValue(e.min_qty,e.max_qty,e)}},model:{value:e.min_qty,callback:function(a){t.$set(e,"min_qty",a)},expression:"test.min_qty"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.max_qty,expression:"test.max_qty"}],attrs:{type:"hidden",name:"updateDataGroup["+i+"][max_qty]",autocomplete:"off"},domProps:{value:e.max_qty},on:{input:function(a){a.target.composing||t.$set(e,"max_qty",a.target.value)}}}),t._v(" "),a("vue-numeric",{class:"form-control text-right "+(e.remarkImpossibleHighValue?"is-invalid":""),attrs:{separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkNumberHighValue(e.min_qty,e.max_qty,e)}},model:{value:e.max_qty,callback:function(a){t.$set(e,"max_qty",a)},expression:"test.max_qty"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.remark_msg,expression:"test.remark_msg"}],attrs:{type:"hidden",name:"updateDataGroup["+i+"][remark_msg]",autocomplete:"off"},domProps:{value:e.remark_msg},on:{input:function(a){a.target.composing||t.$set(e,"remark_msg",a.target.value)}}}),t._v(" "),a("el-input",{attrs:{type:"textarea",rows:1,placeholder:""},model:{value:e.remark_msg,callback:function(a){t.$set(e,"remark_msg",a)},expression:"test.remark_msg"}})],1),t._v(" "),a("td",[a("button",{staticClass:"btn btn-sm btn-danger",attrs:{"v-model":e.setup_min_max_id},on:{click:function(a){return a.preventDefault(),t.removeRowTableData(i,e.setup_min_max_id)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])})),t._v(" "),t._l(t.lines,(function(e,i){return a("tr",{key:i,attrs:{row:e}},[a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.itemNumber,expression:"row.itemNumber"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][item_number]",autocomplete:"off"},domProps:{value:e.itemNumber},on:{input:function(a){a.target.composing||t.$set(e,"itemNumber",a.target.value)}}}),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.itemNumber,expression:"loading.itemNumber"}],staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"Select"},on:{input:t.checkInput,change:function(a){return t.getUom(e.itemNumber,e,t.organization)}},model:{value:e.itemNumber,callback:function(a){t.$set(e,"itemNumber",a)},expression:"row.itemNumber"}},t._l(e.itemNumbersList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1),t._v(" "),a("td",{staticStyle:{"vertical-align":"middle","padding-left":"10px"}},[t._v(" \n                            "+t._s(e.itemNumberDes)+" \n                        ")]),t._v(" "),a("td",[a("el-input",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.primaryUnitOfMeasure,expression:"loading.primaryUnitOfMeasure"}],attrs:{disabled:!0},model:{value:e.primaryUnitOfMeasure,callback:function(a){t.$set(e,"primaryUnitOfMeasure",a)},expression:"row.primaryUnitOfMeasure"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.minQty,expression:"row.minQty"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][min_qty]",autocomplete:"off"},domProps:{value:e.minQty},on:{input:function(a){a.target.composing||t.$set(e,"minQty",a.target.value)}}}),t._v(" "),a("vue-numeric",{class:"form-control text-right "+(e.remarkImpossibleSmallValue?"is-invalid":""),attrs:{separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkNumberSmallValue(e.minQty,e.maxQty,e)}},model:{value:e.minQty,callback:function(a){t.$set(e,"minQty",a)},expression:"row.minQty"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.maxQty,expression:"row.maxQty"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][max_qty]",autocomplete:"off"},domProps:{value:e.maxQty},on:{input:function(a){a.target.composing||t.$set(e,"maxQty",a.target.value)}}}),t._v(" "),a("vue-numeric",{class:"form-control text-right "+(e.remarkImpossibleHighValue?"is-invalid":""),attrs:{separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkNumberHighValue(e.minQty,e.maxQty,e)}},model:{value:e.maxQty,callback:function(a){t.$set(e,"maxQty",a)},expression:"row.maxQty"}})],1),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.note,expression:"row.note"}],attrs:{type:"hidden",name:"newDataGroup["+e.id+"][remark_msg]",autocomplete:"off"},domProps:{value:e.note},on:{input:function(a){a.target.composing||t.$set(e,"note",a.target.value)}}}),t._v(" "),a("el-input",{attrs:{type:"textarea",rows:1,placeholder:""},on:{input:t.checkInput},model:{value:e.note,callback:function(a){t.$set(e,"note",a)},expression:"row.note"}})],1),t._v(" "),a("td",[a("button",{staticClass:"btn btn-sm btn-danger col text-center",on:{click:function(e){return e.preventDefault(),t.removeRow(i)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])}))],2):a("tbody",[a("tr",[a("td",{staticClass:"text-center",attrs:{colspan:"8"}},[a("h2",[t._v(t._s("โปรดทำการเลือก Organization คลังจัดเก็บ/สถานที่จัดเก็บ และรหัสวัตถุดิบ ก่อน"))])])])])]),t._v(" "),a("div",{staticClass:"col-12 mt-3"},[a("div",{staticClass:"row clearfix text-right"},[a("div",{staticClass:"col",staticStyle:{"margin-top":"15px"}},[a("button",{class:t.btnTrans.save.class,attrs:{disabled:t.isDisabledBtuAdd}},[a("i",{class:t.btnTrans.save.icon,attrs:{"aria-hidden":"true"}}),t._v(" "+t._s(t.btnTrans.save.text)+" \n                        ")])])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox-title"},[a("h5",[t._v(" กำหนดค่าเฝ้าระวัง ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"},attrs:{width:"15%"}},[a("div",[t._v("รหัสวัตถุดิบ "),a("span",{staticClass:"text-danger"},[t._v("*")])])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"},attrs:{width:"40%"}},[a("div",[t._v("รายละเอียด")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"},attrs:{width:"10%"}},[a("div",[t._v("หน่วย")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"},attrs:{width:"10%"}},[a("div",[t._v("ค่าเฝ้าระวังต่ำสุด "),a("span",{staticClass:"text-danger"},[t._v("*")])])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"},attrs:{width:"10%"}},[a("div",[t._v("ค่าเฝ้าระวังสูงสุด "),a("span",{staticClass:"text-danger"},[t._v("*")])])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"},attrs:{width:"20%"}},[a("div",[t._v("หมายเหตุ")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"font-size":"small"}})])])}],!1,null,null,null).exports}}]);