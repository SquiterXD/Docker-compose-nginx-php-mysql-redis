(self.webpackChunk=self.webpackChunk||[]).push([[8873],{13732:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>o});var r=n(23645),a=n.n(r)()((function(t){return t[1]}));a.push([t.id,".btn-p__tr[data-v-1622a08a]{background-color:green}",""]);const o=a},8873:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>g});var r=n(87757),a=n.n(r),o=n(30381),c=n.n(o);function s(t){return function(t){if(Array.isArray(t))return i(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return i(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);"Object"===n&&t.constructor&&(n=t.constructor.name);if("Map"===n||"Set"===n)return Array.from(t);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return i(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function i(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,r=new Array(e);n<e;n++)r[n]=t[n];return r}function l(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function u(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?l(Object(n),!0).forEach((function(e){p(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):l(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function p(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function d(t,e,n,r,a,o,c){try{var s=t[o](c),i=s.value}catch(t){return void n(t)}s.done?e(i):Promise.resolve(i).then(r,a)}const f={data:function(){return{form:{year:c()().format("yyyy")},tableData:[],loading:!1,option:{year:[]}}},mounted:function(){this.getMasterData(),this.getCostCenterView()},methods:{getMasterData:function(){this.getCostCenterView()},del:function(t){var e,n=this;return(e=a().mark((function e(){var r,o,c;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return o="/ct/ajax/cost_center/package",e.next=3,u((p(r={code:t.cost_code,name:t.description,cost_group_code:t.cost_group_code,qty:t.quantity,uom_code:t.uom_code,organization_code:t.organization_code},"cost_group_code",t.cost_group_code),p(r,"type","DELETE"),r),t);case 3:return c=e.sent,e.next=6,axios.post(o,c).then((function(t){n.getMasterData(),0==t.data.status?n.$message({showClose:!0,message:"ศูนย์ต้นทุนมีการ assign item แล้ว ไม่สามารถลบได้",type:"error"}):n.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success",onClose:function(){}})})).catch((function(t){n.$message({showClose:!0,message:"ไม่สามารถบันทึกได้",type:"error"})})).then((function(){n.loading=!1}));case 6:case"end":return e.stop()}}),e)})),function(){var t=this,n=arguments;return new Promise((function(r,a){var o=e.apply(t,n);function c(t){d(o,r,a,c,s,"next",t)}function s(t){d(o,r,a,c,s,"throw",t)}c(void 0)}))})()},addCostCenter:function(){var t=this;axios.post("/ct/ajax/cost_center/package",{}).then((function(e){t.$message({showClose:!0,message:"ประมวลผลสำเร็จ",type:"success"})}))},getYears:function(t){var e=this;axios.get("/ct/ajax/cost_center/years",{params:{text:t}}).then((function(t){var n;(n=e.option.year).push.apply(n,s(t.data))}))},arrayToString:function(t,e){var n=t.map((function(t){return t[e]}));return n=n.toString()},getCostCenterView:function(){var t=this;this.loading=!0,axios.get("/ct/ajax/cost_center/cost-center-view").then((function(e){t.tableData=e.data,t.loading=!1}))},convertBoolean:function(t){return"1"==t||"0"!=t&&void 0},checkboxOnChange:function(t,e){e.is_active=t,this.update(e)},update:function(t){var e=this;axios.post("/ct/ajax/cost_center/update_active",{cost_center_id:t.cost_center_id,is_active:t.is_active}).then((function(t){e.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success"})}))}}};n(31305);const g=(0,n(51900).Z)(f,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"from-group"},[n("div",{staticClass:"col-md-12 mt-4 p-0"},[n("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.tableData}},[n("el-table-column",{attrs:{prop:"cost_code",label:"รหัสศูนย์ต้นทุน",align:"center",width:"130"}}),t._v(" "),n("el-table-column",{attrs:{prop:"description",label:"ศูนย์ต้นทุน",width:"180","header-align":"center"}}),t._v(" "),n("el-table-column",{attrs:{prop:"cost_group_desc",label:"ประเภท","header-align":"center"}}),t._v(" "),n("el-table-column",{attrs:{prop:"organization_code",label:"INV.Org",width:"130",align:"center"}}),t._v(" "),n("el-table-column",{attrs:{label:"ต้นทุนมาตรฐาน","header-align":"center",width:"350"}},[n("el-table-column",{attrs:{prop:"quantity",label:"ปริมาณ",align:"center",width:"150"}}),t._v(" "),n("el-table-column",{attrs:{prop:"uom_code",label:"หน่วยนับ",align:"center",width:"150"}}),t._v(" "),n("el-table-column",{attrs:{prop:"uom_thai",label:"หน่วยนับ (ภาษาไทย)",align:"center",width:"150"}})],1),t._v(" "),n("el-table-column",{attrs:{label:"",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("a",{attrs:{href:"/ct/cost_center/"+e.row.cost_code}},[n("button",{staticClass:"btn btn-warning btn-lg tw-w-24",attrs:{type:"button"}},[t._v("\n                            แก้ไข\n                        ")])]),t._v(" "),n("button",{staticClass:"btn btn-danger btn-lg ml-2 tw-w-24",attrs:{type:"button"},on:{click:function(n){return t.del(e.row)}}},[t._v("\n                        ลบ\n                    ")])]}}])})],1)],1)])}),[],!1,null,"1622a08a",null).exports},31305:(t,e,n)=>{var r=n(13732);r.__esModule&&(r=r.default),"string"==typeof r&&(r=[[t.id,r,""]]),r.locals&&(t.exports=r.locals);(0,n(45346).Z)("6338b226",r,!0,{})}}]);