(self.webpackChunk=self.webpackChunk||[]).push([[1410],{61410:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>a});const r={props:["customers","actionUrl","defaultCustomer"],data:function(){return{customer_id:this.defaultCustomer?Number(this.defaultCustomer):""}},mounted:function(){},methods:{}};const a=(0,s(51900).Z)(r,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row"},[t._m(0),t._v(" "),s("div",{staticClass:"col-sm-4",staticStyle:{"text-align":"left"}},[s("input",{attrs:{type:"hidden",name:"customer_id",autocomplete:"off"},domProps:{value:t.customer_id}}),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.customer_id,callback:function(e){t.customer_id=e},expression:"customer_id"}},t._l(t.customers,(function(t){return s("el-option",{key:t.customer_id,attrs:{label:t.customer_number?t.customer_number+" : "+t.customer_name:t.customer_name,value:t.customer_id}})})),1)],1),t._v(" "),s("div",{staticClass:"col-sm-2"},[s("div",{staticClass:"text-right mt-2"},[t._m(1),t._v(" "),s("a",{staticClass:"btn btn-danger btn-sm",attrs:{href:this.actionUrl}},[t._v("ล้าง")])])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-sm-2 text-right mt-2"},[s("label",[t._v(" รหัส - ชื่อลูกค้า ")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("button",{staticClass:"btn btn-light btn-sm",attrs:{type:"submit"}},[s("i",{staticClass:"fa fa-search",attrs:{"aria-hidden":"true"}}),t._v(" ค้นหา\n            ")])}],!1,null,null,null).exports}}]);