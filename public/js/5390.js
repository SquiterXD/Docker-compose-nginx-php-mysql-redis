(self.webpackChunk=self.webpackChunk||[]).push([[5390],{35390:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>i});var s=a(87757),c=a.n(s);function n(t,e,a,s,c,n,r){try{var i=t[n](r),o=i.value}catch(t){return void a(t)}i.done?e(o):Promise.resolve(o).then(s,c)}const r={props:["headers"],data:function(){return{}},mounted:function(){$(".myTable").dataTable({searching:!1,bInfo:!1})},computed:{},methods:{changeActive:function(t){return(e=c().mark((function e(){var a,s;return c().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=$("#checkbox".concat(t)).is(":checked"),s={header_id:t,active_flag:a?"Y":"N"},e.next=4,axios.get("/ir/ajax/product-header/updateActiveFlag",{params:s}).then((function(e){"success"==e.data.status?swal({title:"Success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}):swal({title:"Error !",text:"ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่",type:"error",showConfirmButton:!0}),"IRM0004Close"==e.data.status&&swal({title:"คุณต้องการเปิดใช้งานใช่ไหม?",text:"ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 และ IRM0005 ใช่ไหม?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"เปิดการใช้งาน",closeOnConfirm:!1},(function(e){var s={header_id:t,confirm:e,active_flag:a?"Y":"N"};e?axios.get("/ir/ajax/product-header/updateActiveFlag",{params:s}).then((function(e){swal({title:"success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}),$("#checkbox".concat(t)).prop("checked",!0)})):$("#checkbox".concat(t)).prop("checked",!1)})),"twoClose"==e.data.status&&swal({title:"คุณต้องการเปิดใช้งานใช่ไหม?",text:"ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า และ IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 IRM0009 และ IRM0005 ใช่ไหม?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"เปิดการใช้งาน",closeOnConfirm:!1},(function(e){var s={header_id:t,confirm:e,active_flag:a?"Y":"N"};e?axios.get("/ir/ajax/product-header/updateActiveFlag",{params:s}).then((function(e){swal({title:"success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}),$("#checkbox".concat(t)).prop("checked",!0)})):$("#checkbox".concat(t)).prop("checked",!1)})),"IRM0009Close"==e.data.status&&swal({title:"คุณต้องการเปิดใช้งานใช่ไหม?",text:"ข้อมูลหน้า IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0009 และ IRM0005 ใช่ไหม?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"เปิดการใช้งาน",closeOnConfirm:!1},(function(e){var s={header_id:t,confirm:e,active_flag:a?"Y":"N"};e?axios.get("/ir/ajax/product-header/updateActiveFlag",{params:s}).then((function(e){swal({title:"success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}),$("#checkbox".concat(t)).prop("checked",!0)})):$("#checkbox".concat(t)).prop("checked",!1)}))}));case 4:return e.abrupt("return",e.sent);case 5:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(s,c){var r=e.apply(t,a);function i(t){n(r,s,c,i,o,"next",t)}function o(t){n(r,s,c,i,o,"throw",t)}i(void 0)}))})();var e}}};const i=(0,a(51900).Z)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"table",attrs:{id:"table"}},[a("table",{staticClass:"table table table-bordered myTable"},[t._m(0),t._v(" "),0!=t.headers.length?a("tbody",t._l(t.headers,(function(e,s){return a("tr",{key:s},[a("td",{staticClass:"text-left",staticStyle:{"font-size":"11px","vertical-align":"middle"},attrs:{"data-sort":e.group_product.policy_set_header.policy_set_number}},[t._v("\n                            "+t._s(e.group_product&&e.group_product.policy_set_header?e.group_product.policy_set_header.policy_set_number+" : "+e.group_product.policy_set_header.policy_set_description:"")+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left",staticStyle:{"font-size":"11px","vertical-align":"middle"}},[t._v("\n                            "+t._s(e.group_product&&e.group_product.asset_group?e.group_product.asset_group.meaning+" : "+e.group_product.asset_group.description:"")+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left",staticStyle:{"font-size":"11px","vertical-align":"middle"}},[t._v("\n                            "+t._s(e.group_product?e.group_product.description:"")+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left",staticStyle:{"font-size":"11px","vertical-align":"middle"}},[t._v("\n                            "+t._s(e.department_code+" : "+e.department_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left",staticStyle:{"font-size":"11px","vertical-align":"middle"}},[t._v("\n                            "+t._s(e.subinventory_code+" : "+e.subinventory_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-left",staticStyle:{"font-size":"11px","vertical-align":"middle"}},[t._v("\n                            "+t._s(e.sub_group_code+" : "+e.sub_group_desc)+"\n                        ")]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"font-size":"12px","vertical-align":"middle"}},[a("input",{attrs:{type:"checkbox",id:"checkbox"+e.header_id},domProps:{checked:e.showFlag},on:{change:function(a){return t.changeActive(e.header_id)}}})]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"font-size":"11px","vertical-align":"middle"}},[a("a",{staticClass:"btn btn-warning btn-xs",attrs:{type:"button",href:"/ir/settings/product-header/"+e.header_id+"/edit"}},[a("i",{staticClass:"fa fa-pencil-square-o",attrs:{"aria-hidden":"true"}}),t._v(" แก้ไข\n                            ")])])])})),0):a("tbody",[t._m(1)])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center"},[t._v("กรมธรรม์ชุดที่")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("กลุ่มของทรัพย์สิน")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("รายการ")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("รหัสหน่วยงาน")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("รหัสคลังสินค้า")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("กลุ่มสินค้าย่อย")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("Active")]),t._v(" "),a("th",{staticStyle:{width:"78px"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{attrs:{colspan:"8"}},[a("h3",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports}}]);