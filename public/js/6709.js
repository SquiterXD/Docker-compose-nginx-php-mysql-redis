(self.webpackChunk=self.webpackChunk||[]).push([[6709],{38616:(t,e,r)=>{"use strict";r.d(e,{Z:()=>a});var s=r(23645),o=r.n(s)()((function(t){return t[1]}));o.push([t.id,".el-table .warning-row[data-v-ade87832]{background-color:#fdf5e6!important}.el-input-number .el-input__inner[data-v-ade87832]{text-align:left!important}.justify_between[data-v-ade87832]{display:flex;align-items:center;justify-content:space-between}.side_list[data-v-ade87832]{height:500px;border-radius:5px;padding:20px;border:2px solid #eee}.side_list .title[data-v-ade87832]{font-size:14px;font-weight:700;color:#909399}.side_list .show_list[data-v-ade87832]{max-height:400px;overflow:scroll}.side_list .show_list-item[data-v-ade87832]{width:100%;justify-content:space-between}.m-px__5[data-v-ade87832]{margin:5px}.flex[data-v-ade87832]{display:flex}.text-title[data-v-ade87832]{font-size:16px;font-weight:600}.btn-info[data-v-ade87832]{background-color:#02b0ef;border-color:#02b0ef}.btn-success[data-v-ade87832]{background-color:#1ab394;border-color:#1ab394}.btn-cancel[data-v-ade87832]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-ade87832]{color:#ec4958}.show_list[data-v-ade87832]{display:flex;flex-wrap:wrap}.show_list-item[data-v-ade87832]{cursor:pointer;display:flex;margin:5px;background-color:#f4f4f5;padding:3px 10px;color:#909399;border-color:#e9e9eb;border-radius:3px;text-align:left;align-items:center}.show_list-item[data-v-ade87832]:hover{background-color:#ededf0}.show_list-item__close[data-v-ade87832]{margin-left:10px}",""]);const a=o},46709:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>p});var s=r(87757),o=r.n(s);function a(t,e,r,s,o,a,n){try{var i=t[a](n),c=i.value}catch(t){return void r(t)}i.done?e(c):Promise.resolve(c).then(s,o)}function n(t){return function(){var e=this,r=arguments;return new Promise((function(s,o){var n=t.apply(e,r);function i(t){a(n,s,o,i,c,"next",t)}function c(t){a(n,s,o,i,c,"throw",t)}i(void 0)}))}}const i={data:function(){return{form:{period_year:"",plan_version_no:""},loading:!1,periodYears:[],costCenters:[],selectCostCenter:"",items:{productGroupItems:{name:"",children:[]},productGroupPlan:{}},storage:{productGroupPlan:{productGroupItems:[]}},keyViewProduct:"",changeForm:{},edit:{productGroups:[]}}},mounted:function(){this.getMasterData()},methods:{viewProduct:function(t){this.keyViewProduct!=t?this.keyViewProduct=t:this.keyViewProduct=""},findByCostCenter:function(){this.items.productGroupItems=this.storage.productGroupItems[this.selectCostCenter]},getMasterData:function(){var t=this;axios.get("/ct/ajax/year-view").then((function(e){t.periodYears=e.data}))},create:function(){var t=this;axios.post("/ct/ajax/product-group-plan",{period_year:this.form.period_year,plan_version_no:this.form.plan_version_no}).then((function(e){t.setData(e.data),t.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success"})})).catch((function(e){t.loading=!1,t.resetData(),t.$message({showClose:!0,message:e.response.data.error?e.response.data.error:"ไม่สามารถบันทึกได้",type:"error"})}))},prdProductivityQty:function(t){var e=this;return this.storage.prdGrpPlanGroupV.find((function(r){return r.cost_code==e.selectCostCenter&&r.product_group==t.pg_code})).prd_productivity_qty},search:function(){var t=arguments,e=this;return n(o().mark((function r(){var s,a;return o().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return s=t.length>0&&void 0!==t[0]&&t[0],(a=e).loading=!0,console.log("search ----------\x3e",s),r.next=6,axios.get("/ct/ajax/product-group-plan",{params:{period_year:a.form.period_year,plan_version_no:a.form.plan_version_no}}).then((function(t){a.setData(t.data,s),a.loading=!1})).catch((function(t){console.log(t.response.data),a.loading=!1,a.resetData(),e.$message({showClose:!0,message:"ไม่พบข้อมูล",type:"error"})}));case 6:case"end":return r.stop()}}),r)})))()},setData:function(t){var e=arguments,r=this;return n(o().mark((function s(){var a,n,i,c;return o().wrap((function(s){for(;;)switch(s.prev=s.next){case 0:a=e.length>1&&void 0!==e[1]&&e[1],n=t.productGroupItems,r.storage=t,i=n[Object.keys(n)[0]],c=i.cost_code,a&&(i=n[a.toString()],c=a),r.storage=t,r.costCenters=t.costCenters,r.selectCostCenter=c,r.items.productGroupPlan=t.productGroupPlan,r.items.productGroupItems=i;case 11:case"end":return s.stop()}}),s)})))()},resetData:function(){this.items.productGroupPlan={},this.items.productGroupItems={name:"",children:[]},this.selectCostCenter=""},editForm:function(t,e,r){var s=this;return n(o().mark((function a(){var n,i;return o().wrap((function(o){for(;;)switch(o.prev=o.next){case 0:n=s,!0,(i=JSON.parse(JSON.stringify(r))).product_item_number=e,i.product_group=t,n.$set(n.changeForm,"productGroup-"+t+"-item-"+e,i);case 6:case"end":return o.stop()}}),a)})))()},stripNonNumber:function(t){return parseFloat(t.replace(/,/g,""))},numberFormat:function(t){return"".concat(t).replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,",")},submitUpdate:function(){var t=this;return n(o().mark((function e(){var r;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=JSON.parse(JSON.stringify(t.selectCostCenter)),e.next=3,t.updateProductGroup();case 3:return e.next=5,t.updateProduct();case 5:return e.next=7,t.search(r);case 7:case"end":return e.stop()}}),e)})))()},updateProductGroup:function(){var t=this;axios.post("/ct/ajax/product_group/update",{product_groups:this.items.productGroupItems}).then((function(e){"C"==e.data.status?t.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success"}):t.$message({showClose:!0,message:e.data.msg,type:"error"})})).catch((function(t){console.log(t.response.data)}))},updateProduct:function(){var t=this,e=this;JSON.parse(JSON.stringify(e.form)),JSON.parse(JSON.stringify(e.selectCostCenter));axios.post("/ct/ajax/product-group-plan/update-item",{period_year:e.form.period_year,plan_version_no:e.form.plan_version_no,cost_code:e.selectCostCenter,data:e.changeForm}).then((function(e){"C"==e.data.status?t.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success"}):t.$message({showClose:!0,message:e.data.msg,type:"error"})})).catch((function(t){console.log(t.response.data)})),e.changeForm={}}}};var c=r(93379),d=r.n(c),l=r(38616),u={insert:"head",singleton:!1};d()(l.Z,u);l.Z.locals;const p=(0,r(51900).Z)(i,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"list-product-groups"},[r("div",{staticClass:"form-group row"},[r("div",{staticClass:"col-lg-12"},[r("el-select",{attrs:{filterable:"",placeholder:"ปีบัญชีงบประมาณ"},model:{value:t.form.period_year,callback:function(e){t.$set(t.form,"period_year",e)},expression:"form.period_year"}},t._l(t.periodYears,(function(t,e){return r("el-option",{key:e,attrs:{label:t.period_year_thai,value:t.period_year}})})),1),t._v(" "),r("el-input",{staticStyle:{width:"200px"},attrs:{placeholder:"แผนผลิตภัณฑ์"},model:{value:t.form.plan_version_no,callback:function(e){t.$set(t.form,"plan_version_no",e)},expression:"form.plan_version_no"}}),t._v(" "),r("el-button",{staticClass:"btn-info ml-2",attrs:{type:"primary"},on:{click:function(e){return t.search()}}},[t._v("\n                ค้นหา\n            ")]),t._v(" "),r("el-button",{staticClass:"btn-success ml-2",attrs:{type:"success"},on:{click:function(e){return t.create()}}},[t._v("\n                สร้าง\n            ")])],1)]),t._v(" "),r("div",{staticClass:"my-2"},[r("div",[r("span",{staticClass:"font-bold"},[t._v("ปีบัญชีงบประมาณ :")]),t._v("\n            "+t._s(t.items.productGroupPlan.period_year_thai)+"\n        ")]),t._v(" "),r("div",[r("span",{staticClass:"font-bold"},[t._v("แผนผลิตภัณฑ์ :")]),t._v("\n            "+t._s(t.items.productGroupPlan.plan_version_no)+"\n        ")])]),t._v(" "),r("el-card",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"box-card my-2"},[r("div",{staticClass:"clearfix",attrs:{slot:"header"},slot:"header"},[r("el-select",{attrs:{filterable:"",placeholder:"ศูนย์ต้นทุน"},on:{change:t.findByCostCenter},model:{value:t.selectCostCenter,callback:function(e){t.selectCostCenter=e},expression:"selectCostCenter"}},t._l(t.costCenters,(function(t,e){return r("el-option",{key:e,attrs:{label:t.name,value:t.cost_code}})})),1),t._v(" "),r("el-button",{staticClass:"btn-info ml-2 pull-right",attrs:{type:"primary"},on:{click:function(e){return t.submitUpdate()}}},[t._v("\n                บันทึกการแก้ไข\n            ")])],1),t._v(" "),r("div",{staticClass:"text item"},[r("div",{staticClass:"table-responsive px-4 pt-4"},[r("table",{staticClass:"table table-bordered tw-text-xs"},[r("thead",[r("tr",[r("th",[t._v("กลุ่มผลิตภัณฑ์")]),t._v(" "),r("th",{staticClass:"text-center",staticStyle:{width:"25%"}},[t._v("\n                                อัตราส่วน\n                            ")]),t._v(" "),r("th",{staticClass:"text-center",staticStyle:{width:"10%"}},[t._v("\n                                พื้นที่ทำงาน ตร.ซม.\n                            ")]),t._v(" "),r("th",{staticClass:"text-center",staticStyle:{width:"10%"}},[t._v("\n                                จำนวนรอบ\n                            ")]),t._v(" "),r("th",{staticClass:"text-center",staticStyle:{width:"10%"}},[t._v("\n                                ความกว้าง ซม.\n                            ")]),t._v(" "),r("th",{staticClass:"text-center",staticStyle:{width:"10%"}},[t._v("\n                                ความยาว ซม.\n                            ")]),t._v(" "),r("th",{staticClass:"text-center",staticStyle:{width:"15%"}},[t._v("\n                                รวมปริมาณผลผลิต\n                            ")]),t._v(" "),r("th",{staticClass:"text-center"},[t._v("#")])])]),t._v(" "),r("tbody",[t._l(t.items.productGroupItems.children,(function(e,s){return[r("tr",{key:s+"-1",attrs:{clsss:"tw-text-xs"}},[r("td",[t._v(t._s(e.name))]),t._v(" "),r("td",{staticClass:"text-right"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.items.productGroupItems.children[s].ratio,expression:"\n                                            items.productGroupItems\n                                                .children[index].ratio\n                                        "}],staticClass:"form-control text-right",attrs:{type:"text"},domProps:{value:t.items.productGroupItems.children[s].ratio},on:{input:function(e){e.target.composing||t.$set(t.items.productGroupItems.children[s],"ratio",e.target.value)}}})]),t._v(" "),r("td",{staticClass:"text-right"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.items.productGroupItems.children[s].area,expression:"\n                                            items.productGroupItems\n                                                .children[index].area\n                                        "}],staticClass:"form-control text-right",attrs:{type:"text"},domProps:{value:t.items.productGroupItems.children[s].area},on:{input:function(e){e.target.composing||t.$set(t.items.productGroupItems.children[s],"area",e.target.value)}}})]),t._v(" "),r("td",{staticClass:"text-right"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.items.productGroupItems.children[s].around,expression:"\n                                            items.productGroupItems\n                                                .children[index].around\n                                        "}],staticClass:"form-control text-right",attrs:{type:"text"},domProps:{value:t.items.productGroupItems.children[s].around},on:{input:function(e){e.target.composing||t.$set(t.items.productGroupItems.children[s],"around",e.target.value)}}})]),t._v(" "),r("td",{staticClass:"text-right"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.items.productGroupItems.children[s].width,expression:"\n                                            items.productGroupItems\n                                                .children[index].width\n                                        "}],staticClass:"form-control text-right",attrs:{type:"text"},domProps:{value:t.items.productGroupItems.children[s].width},on:{input:function(e){e.target.composing||t.$set(t.items.productGroupItems.children[s],"width",e.target.value)}}})]),t._v(" "),r("td",{staticClass:"text-right"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.items.productGroupItems.children[s].length,expression:"\n                                            items.productGroupItems\n                                                .children[index].length\n                                        "}],staticClass:"form-control text-right",attrs:{type:"text"},domProps:{value:t.items.productGroupItems.children[s].length},on:{input:function(e){e.target.composing||t.$set(t.items.productGroupItems.children[s],"length",e.target.value)}}})]),t._v(" "),r("td",{staticClass:"text-right"},[r("div",{staticClass:"form-control"},[t._v("\n                                        "+t._s(t.items.productGroupItems.children[s].prd_productivity_qty)+"\n                                        ")])]),t._v(" "),r("td",{staticClass:"text-center"},[r("el-button",{staticClass:"btn-info ml-2",attrs:{size:"small",type:"primary"},on:{click:function(r){return t.viewProduct(e.pg_code)}}},[t._v("\n                                        ดูผลิตภัณฑ์\n                                    ")])],1)]),t._v(" "),r("tr",{key:s+"-2",class:t.keyViewProduct==e.pg_code?"":"d-none",attrs:{clsss:"tw-text-xs"}},[r("td",{attrs:{colspan:"7"}},[r("table",{staticClass:"table table-bordered tw-text-xs"},[r("thead",[r("tr",[r("th",{staticClass:"text-center"},[t._v("\n                                                    ผลิตภัณฑ์\n                                                ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"200px;"}},[t._v("\n                                                    ปริมาณผลผลิตตามแผน\n                                                ")])])]),t._v(" "),r("tbody",[t._l(e.children,(function(s,o){return[r("tr",{key:o,attrs:{clsss:"tw-text-xs"}},[r("td",[t._v("\n                                                        "+t._s(s.name)+"\n                                                    ")]),t._v(" "),r("td",{staticClass:"text-right"},[r("input",{staticClass:"form-control text-right",attrs:{type:"text"},domProps:{value:t._f("number2Digit")(s.qty)},on:{change:function(r){s.qty=t.stripNonNumber(r.target.value),s.qty<0&&(s.qty=0),t.editForm(e.pg_code,o,s)}}})])])]}))],2)])])])]})),t._v(" "),0==t.items.productGroupItems.children.length?r("tr",[r("td",{staticClass:"text-center",attrs:{colspan:"8"}},[t._v("\n                                ไม่พบข้อมูล\n                            ")])]):t._e()],2)])])])])],1)}),[],!1,null,"ade87832",null).exports}}]);