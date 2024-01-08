(self.webpackChunk=self.webpackChunk||[]).push([[7242],{67242:(t,e,i)=>{"use strict";i.r(e),i.d(e,{default:()=>u});var a=i(23570),n=i.n(a),r=i(80455);function s(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,a)}return i}function l(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?s(Object(i),!0).forEach((function(e){c(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):s(Object(i)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}function c(t,e,i){return e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}const o={props:["tobaccoForewarnList","itemNumbersUpdateList","itemNumberShowAllList"],data:function(){return{lines:[],itemNumber:"",warningNum:"",checkText:!0,loading:{page:!1,itemNumberTable:!1},itemNumbersSearchList:this.itemNumbersUpdateList}},components:{VueNumeric:i.n(r)()},mounted:function(){$(".table-data").dataTable({searching:!1,bInfo:!1})},methods:{addLine:function(){this.isDisabledBtu=!1,this.checkText=!1,this.lines.push({id:n()(),itemNumber:"",warningNum:"",inventoryItemId:""})},removeRow:function(t){this.lines.splice(t,1),0==this.lines.length&&(this.checkText=!0)},getValueDetails:function(t,e){this.itemNumberShowAllList.forEach((function(i){i.inventory_item_id==t&&(e.itemNumber=i.item_number,e.inventoryItemId=i.inventory_item_id,e.itemDesc=i.item_desc)}))},save:function(){var t=this,e=!1;if(this.lines.forEach((function(t){if(!t.itemNumber&&!t.warningNum)return swal({title:"คำเตือน !",text:"ไม่สามารถบันทึกได้ เนื่องจากกรอกข้อมูลไม่ครบถ้วน",type:"warning",showConfirmButton:!0}),e=!0})),!e){var i=l({},this.lines),a=l({},this.tobaccoForewarnList);return this.loading.page=!0,axios.post("/pd/ajax/ohhand-tobacco-forewarn/updateOrCreate",{params:i,params1:a}).then((function(e){"succeed"==e.data.data?swal({title:"Success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}):swal({title:"Error !",text:"บันทึกไม่สำเร็จ",type:"error",showConfirmButton:!0}),t.loading.page=!1,setTimeout((function(){window.location.reload(!1)}),3e3)}))}},remoteMethod:function(t){var e=this;if(""!==t){var i=this;this.loading.itemNumberTable=!0;var a={query:t,itemCatSeg1:i.$parent.itemCatSeg1,itemCatSeg2:i.$parent.itemCatSeg2,inventoryItemId:i.$parent.itemNumber,UpdateList:"UpdateList"};return axios.get("/pd/ajax/ohhand-tobacco-forewarn/get-search-item-number",{params:a}).then((function(t){e.itemNumbersSearchList=t.data.itemNumberList,e.loading.itemNumberTable=!1}))}this.itemNumbersSearchList=this.itemNumbersUpdateList}}};const u=(0,i(51900).Z)(o,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.page,expression:"loading.page"}],staticClass:"ibox",staticStyle:{"padding-top":"50px"}},[t._m(0),t._v(" "),i("div",{staticClass:"ibox-content"},[i("div",{staticClass:"text-right",staticStyle:{"padding-bottom":"15px"}},[i("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.addLine(e)}}},[i("i",{staticClass:"fa fa-plus",attrs:{"aria-hidden":"true"}}),t._v(" เพิ่มรายการ \n                    ")])]),t._v(" "),i("table",{staticClass:"table table table-bordered table-data"},[t._m(1),t._v(" "),0!=this.tobaccoForewarnList.data.length?i("tbody",[t._l(t.tobaccoForewarnList.data,(function(e,a){return i("tr",{key:"showData"+a,attrs:{row:a}},[i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v(" \n                            "+t._s(e.item_number)+"\n                        ")]),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.item_desc)+"\n                        ")]),t._v(" "),i("td",{staticStyle:{"vertical-align":"middle"}},[i("vue-numeric",{staticClass:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนการแจ้งเตือน",separator:",",precision:0,minus:!1},model:{value:e.warning_num,callback:function(i){t.$set(e,"warning_num",i)},expression:"tobacco.warning_num"}})],1),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}})])})),t._v(" "),t._l(t.lines,(function(e,a){return i("tr",{key:a,attrs:{row:a}},[i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[i("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"เลือก รหัสวัตถุดิบ","remote-method":t.remoteMethod,loading:t.loading.itemNumberTable},on:{input:function(i){return t.getValueDetails(e.itemNumber,e)}},model:{value:e.itemNumber,callback:function(i){t.$set(e,"itemNumber",i)},expression:"line.itemNumber"}},t._l(t.itemNumbersSearchList,(function(t,e){return i("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.itemDesc)+"\n                        ")]),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[i("vue-numeric",{staticClass:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนการแจ้งเตือน",separator:",",precision:0,minus:!1},model:{value:e.warningNum,callback:function(i){t.$set(e,"warningNum",i)},expression:"line.warningNum"}})],1),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[i("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(e){return e.preventDefault(),t.removeRow(a)}}},[i("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])}))],2):i("tbody",[this.checkText?i("tr",[i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle","font-size":"18px"},attrs:{colspan:"4"}},[t._v(" \n                            "+t._s("ไม่มีข้อมูลในระบบ")+"\n                        ")])]):t._e(),t._v(" "),t._l(t.lines,(function(e,a){return i("tr",{key:a,attrs:{row:a}},[i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[i("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"เลือก รหัสวัตถุดิบ","remote-method":t.remoteMethod,loading:t.loading.itemNumberTable},on:{input:function(i){return t.getValueDetails(e.itemNumber,e)}},model:{value:e.itemNumber,callback:function(i){t.$set(e,"itemNumber",i)},expression:"line.itemNumber"}},t._l(t.itemNumbersSearchList,(function(t,e){return i("el-option",{key:e,attrs:{label:t.item_number+" : "+t.item_desc,value:t.inventory_item_id}})})),1)],1),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.itemDesc)+"\n                        ")]),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[i("vue-numeric",{staticClass:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนการแจ้งเตือน",separator:",",precision:0,minus:!1},model:{value:e.warningNum,callback:function(i){t.$set(e,"warningNum",i)},expression:"line.warningNum"}})],1),t._v(" "),i("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[i("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(e){return e.preventDefault(),t.removeRow(a)}}},[i("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])}))],2)]),t._v(" "),i("div",{staticClass:"col-12 mt-3"},[i("div",{staticClass:"row clearfix text-right"},[i("div",{staticClass:"col",staticStyle:{"margin-top":"15px"}},[i("button",{staticClass:"btn btn-success",attrs:{type:"submit"},on:{click:function(e){return e.preventDefault(),t.save()}}},[i("i",{staticClass:"fa fa-floppy-o",attrs:{"aria-hidden":"true"}}),t._v(" บันทึก \n                        ")])])])])])])])}),[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"ibox-title"},[i("h5",[t._v(" กำหนดแจ้งเตือนปริมาณใบยา ")])])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("thead",[i("tr",[i("th",{staticClass:"text-center",attrs:{width:"30%"}},[i("div",[t._v("รหัสวัตถุดิบ"),i("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),i("th",{staticClass:"text-center",attrs:{width:"30%"}},[i("div",[t._v("รายละเอียด")])]),t._v(" "),i("th",{staticClass:"text-center",attrs:{width:"30%"}},[i("div",[t._v("จำนวนเดือนที่แจ้งเตือน"),i("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),i("th",{staticClass:"text-center",attrs:{width:"10%"}})])])}],!1,null,null,null).exports}}]);