(self.webpackChunk=self.webpackChunk||[]).push([[7769,7269],{87769:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>l});var i=a(87757),n=a.n(i);function r(t,e,a,i,n,r,s){try{var o=t[r](s),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(i,n)}function s(t){return function(){var e=this,a=arguments;return new Promise((function(i,n){var s=t.apply(e,a);function o(t){r(s,i,n,o,l,"next",t)}function l(t){r(s,i,n,o,l,"throw",t)}o(void 0)}))}}const o={components:{ohhandTobaccoForewarnTable:a(77269).default},props:["organizations","org","itemCatSeg1List"],data:function(){return{organization:this.org?parseFloat(this.org.organization_id):"",itemCatSeg1:"",itemCatSeg2:"",itemCatSeg2List:[],itemNumber:"",itemNumberList:[],itemNumberBaseList:[],itemNumbersUpdateList:[],tobaccoForewarnList:[],table:!1,loading:{itemCatSeg2:!1,itemNumber:!1,page:!1},isDisabled:{itemCatSeg2:!0,itemNumber:!0}}},mounted:function(){},methods:{getTobaccoItemcatSeg2:function(t,e){var a=this;return s(n().mark((function i(){var r;return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:return a.loading.itemCatSeg2=!0,a.loading.itemNumber=!0,a.itemCatSeg2="",a.itemNumber="",r={organization:t,itemCatSeg1:e},i.next=7,axios.get("/pd/ajax/ohhand-tobacco-forewarn/get-tobacco-itemcat-seg-2",{params:r}).then((function(t){a.itemCatSeg2List=t.data.itemCatSeg2List,a.loading.itemCatSeg2=!1,a.loading.itemNumber=!1,a.isDisabled.itemCatSeg2=!1,a.isDisabled.itemNumber=!0}));case 7:return i.abrupt("return",i.sent);case 8:case"end":return i.stop()}}),i)})))()},getItemNumber:function(t,e,a){var i=this;return s(n().mark((function r(){var s;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return i.loading.itemNumber=!0,i.itemNumber="",s={organization:t,itemCatSeg1:e,itemCatSeg2:a},n.next=5,axios.get("/pd/ajax/ohhand-tobacco-forewarn/get-item-number",{params:s}).then((function(t){i.itemNumberList=t.data.itemNumberList,i.itemNumberBaseList=t.data.itemNumberList,i.itemNumbersUpdateList=t.data.itemNumbersUpdateList,i.itemNumberShowAllList=t.data.itemNumberShowAllList,i.loading.itemNumber=!1,i.isDisabled.itemNumber=!1}));case 5:return n.abrupt("return",n.sent);case 6:case"end":return n.stop()}}),r)})))()},search:function(t,e,a,i){var r=this;return s(n().mark((function s(){var o;return n().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return r.loading.page=!0,o={organization:t,itemCatSeg1:e,itemCatSeg2:a,itemNumber:i},n.next=4,axios.get("/pd/ajax/ohhand-tobacco-forewarn/search",{params:o}).then((function(t){r.table=!0,r.loading.page=!1,r.tobaccoForewarnList=t.data.tobaccoForewarnList}));case 4:return n.abrupt("return",n.sent);case 5:case"end":return n.stop()}}),s)})))()},remoteMethod:function(t){var e=this;if(""!==t){this.loading.itemNumber=!0;var a={query:t,itemCatSeg1:this.itemCatSeg1,itemCatSeg2:this.itemCatSeg2};return axios.get("/pd/ajax/ohhand-tobacco-forewarn/get-search-item-number",{params:a}).then((function(t){e.itemNumberList=t.data.itemNumberList,e.loading.itemNumber=!1}))}this.itemNumberList=this.itemNumberBaseList}}};const l=(0,a(51900).Z)(o,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.page,expression:"loading.page"}]},[a("div",{staticClass:"ibox"},[a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"text-right"},[a("div",{staticClass:"text-right",staticStyle:{"padding-top":"5px"}},[a("button",{staticClass:"btn btn-light",attrs:{disabled:!t.organization||!t.itemCatSeg1||!t.itemCatSeg2},on:{click:function(e){return e.preventDefault(),t.search(t.organization,t.itemCatSeg1,t.itemCatSeg2,t.itemNumber)}}},[a("i",{staticClass:"fa fa-search",attrs:{"aria-hidden":"true"}}),t._v(" แสดงข้อมูล \n                    ")]),t._v(" "),a("a",{staticClass:"btn btn-danger",attrs:{type:"button",href:"/pd/settings/ohhand-tobacco-forewarn"}},[t._v("\n                        ล้างค่า\n                    ")])])]),t._v(" "),a("div",{staticClass:"row",staticStyle:{"padding-top":"20px"}},[a("div",{staticClass:"col-md-4"},[a("label",[t._v("ประเภทวัตถุดิบ")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.itemCatSeg1,expression:"loading.itemCatSeg1"}],staticClass:"w-100",attrs:{filterable:"",placeholder:"เลือก ประเภทวัตถุดิบ"},on:{change:function(e){return t.getTobaccoItemcatSeg2(t.organization,t.itemCatSeg1)}},model:{value:t.itemCatSeg1,callback:function(e){t.itemCatSeg1=e},expression:"itemCatSeg1"}},t._l(t.itemCatSeg1List,(function(t,e){return a("el-option",{key:e,attrs:{label:t.flex_value_meaning1+": "+t.description1,value:t.flex_value_meaning1}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v("กลุ่มใบยา")]),a("span",{staticClass:"text-danger"},[t._v(" *")]),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.itemCatSeg2,expression:"loading.itemCatSeg2"}],staticClass:"w-100",attrs:{filterable:"",placeholder:"เลือก กลุ่มใบยา",disabled:t.isDisabled.itemCatSeg2},on:{change:function(e){return t.getItemNumber(t.organization,t.itemCatSeg1,t.itemCatSeg2)}},model:{value:t.itemCatSeg2,callback:function(e){t.itemCatSeg2=e},expression:"itemCatSeg2"}},t._l(t.itemCatSeg2List,(function(t,e){return a("el-option",{key:e,attrs:{label:t.flex_value_meaning2+": "+t.description2,value:t.flex_value_meaning2}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v("รหัสวัตถุดิบ")]),t._v(" "),a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.itemNumber,expression:"loading.itemNumber"}],staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"เลือก รหัสวัตถุดิบ","remote-method":t.remoteMethod,loading:t.loading.itemNumber,disabled:t.isDisabled.itemNumber},model:{value:t.itemNumber,callback:function(e){t.itemNumber=e},expression:"itemNumber"}},t._l(t.itemNumberList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_number+": "+t.item_desc,value:t.inventory_item_id}})})),1)],1)])])]),t._v(" "),this.table?a("div",[a("ohhandTobaccoForewarnTable",{attrs:{tobaccoForewarnList:t.tobaccoForewarnList,itemNumbersUpdateList:t.itemNumbersUpdateList,itemNumberShowAllList:t.itemNumberShowAllList}})],1):t._e()])}),[],!1,null,null,null).exports},77269:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>m});var i=a(23570),n=a.n(i),r=a(80455);function s(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,i)}return a}function o(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?s(Object(a),!0).forEach((function(e){l(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):s(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function l(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const c={props:["tobaccoForewarnList","itemNumbersUpdateList","itemNumberShowAllList"],data:function(){return{lines:[],itemNumber:"",warningNum:"",checkText:!0,loading:{page:!1,itemNumberTable:!1},itemNumbersSearchList:this.itemNumbersUpdateList}},components:{VueNumeric:a.n(r)()},mounted:function(){$(".table-data").dataTable({searching:!1,bInfo:!1})},methods:{addLine:function(){this.isDisabledBtu=!1,this.checkText=!1,this.lines.push({id:n()(),itemNumber:"",warningNum:"",inventoryItemId:""})},removeRow:function(t){this.lines.splice(t,1),0==this.lines.length&&(this.checkText=!0)},getValueDetails:function(t,e){this.itemNumberShowAllList.forEach((function(a){a.inventory_item_id==t&&(e.itemNumber=a.item_number,e.inventoryItemId=a.inventory_item_id,e.itemDesc=a.item_desc)}))},save:function(){var t=this,e=!1;if(this.lines.forEach((function(t){if(!t.itemNumber&&!t.warningNum)return swal({title:"คำเตือน !",text:"ไม่สามารถบันทึกได้ เนื่องจากกรอกข้อมูลไม่ครบถ้วน",type:"warning",showConfirmButton:!0}),e=!0})),!e){var a=o({},this.lines),i=o({},this.tobaccoForewarnList);return this.loading.page=!0,axios.post("/pd/ajax/ohhand-tobacco-forewarn/updateOrCreate",{params:a,params1:i}).then((function(e){"succeed"==e.data.data?swal({title:"Success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}):swal({title:"Error !",text:"บันทึกไม่สำเร็จ",type:"error",showConfirmButton:!0}),t.loading.page=!1,setTimeout((function(){window.location.reload(!1)}),3e3)}))}},remoteMethod:function(t){var e=this;if(""!==t){this.loading.itemNumberTable=!0;var a={query:t,itemCatSeg1:this.$parent.itemCatSeg1,itemCatSeg2:this.$parent.itemCatSeg2,UpdateList:"UpdateList"};return axios.get("/pd/ajax/ohhand-tobacco-forewarn/get-search-item-number",{params:a}).then((function(t){e.itemNumbersSearchList=t.data.itemNumberList,e.loading.itemNumberTable=!1}))}this.itemNumbersSearchList=this.itemNumbersUpdateList}}};const m=(0,a(51900).Z)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.page,expression:"loading.page"}],staticClass:"ibox",staticStyle:{"padding-top":"50px"}},[t._m(0),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"text-right",staticStyle:{"padding-bottom":"15px"}},[a("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.addLine(e)}}},[a("i",{staticClass:"fa fa-plus",attrs:{"aria-hidden":"true"}}),t._v(" เพิ่มรายการ \n                    ")])]),t._v(" "),a("table",{staticClass:"table table table-bordered table-data"},[t._m(1),t._v(" "),0!=this.tobaccoForewarnList.data.length?a("tbody",[t._l(t.tobaccoForewarnList.data,(function(e,i){return a("tr",{key:"showData"+i,attrs:{row:i}},[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v(" \n                            "+t._s(e.item_number)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.item_desc)+"\n                        ")]),t._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("vue-numeric",{staticClass:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนการแจ้งเตือน",separator:",",precision:0,minus:!1},model:{value:e.warning_num,callback:function(a){t.$set(e,"warning_num",a)},expression:"tobacco.warning_num"}})],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}})])})),t._v(" "),t._l(t.lines,(function(e,i){return a("tr",{key:i,attrs:{row:i}},[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"เลือก รหัสวัตถุดิบ","remote-method":t.remoteMethod,loading:t.loading.itemNumberTable},on:{input:function(a){return t.getValueDetails(e.itemNumber,e)}},model:{value:e.itemNumber,callback:function(a){t.$set(e,"itemNumber",a)},expression:"line.itemNumber"}},t._l(t.itemNumbersSearchList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.itemDesc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("vue-numeric",{staticClass:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนการแจ้งเตือน",separator:",",precision:0,minus:!1},model:{value:e.warningNum,callback:function(a){t.$set(e,"warningNum",a)},expression:"line.warningNum"}})],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(e){return e.preventDefault(),t.removeRow(i)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])}))],2):a("tbody",[this.checkText?a("tr",[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle","font-size":"18px"},attrs:{colspan:"4"}},[t._v(" \n                            "+t._s("ไม่มีข้อมูลในระบบ")+"\n                        ")])]):t._e(),t._v(" "),t._l(t.lines,(function(e,i){return a("tr",{key:i,attrs:{row:i}},[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"เลือก รหัสวัตถุดิบ","remote-method":t.remoteMethod,loading:t.loading.itemNumberTable},on:{input:function(a){return t.getValueDetails(e.itemNumber,e)}},model:{value:e.itemNumber,callback:function(a){t.$set(e,"itemNumber",a)},expression:"line.itemNumber"}},t._l(t.itemNumbersSearchList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.itemDesc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("vue-numeric",{staticClass:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนการแจ้งเตือน",separator:",",precision:0,minus:!1},model:{value:e.warningNum,callback:function(a){t.$set(e,"warningNum",a)},expression:"line.warningNum"}})],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(e){return e.preventDefault(),t.removeRow(i)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])}))],2)]),t._v(" "),a("div",{staticClass:"col-12 mt-3"},[a("div",{staticClass:"row clearfix text-right"},[a("div",{staticClass:"col",staticStyle:{"margin-top":"15px"}},[a("button",{staticClass:"btn btn-success",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.save()}}},[a("i",{staticClass:"fa fa-floppy-o",attrs:{"aria-hidden":"true"}}),t._v(" บันทึก \n                        ")])])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox-title"},[a("h5",[t._v(" กำหนดแจ้งเตือนปริมาณใบยา ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{width:"30%"}},[a("div",[t._v("รหัสวัตถุดิบ"),a("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"30%"}},[a("div",[t._v("รายละเอียด")])]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"30%"}},[a("div",[t._v("จำนวนเดือนที่แจ้งเตือน"),a("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"10%"}})])])}],!1,null,null,null).exports}}]);