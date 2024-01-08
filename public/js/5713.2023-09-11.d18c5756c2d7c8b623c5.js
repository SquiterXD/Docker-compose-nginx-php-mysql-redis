(self.webpackChunk=self.webpackChunk||[]).push([[5713],{35713:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>l});var a=s(87757),i=s.n(a);function o(t,e,s,a,i,o,c){try{var l=t[o](c),r=l.value}catch(t){return void s(t)}l.done?e(r):Promise.resolve(r).then(a,i)}const c={props:["sequenceEcoms","salesTypes","productTypeDomestics","productTypeExports","searchData","actionUrl"],data:function(){return{item_id:"",ecom_item:"",sales_type:"",status:"",product_type:"",itemLoading:!1,productTypes:[],itemLists:[],productTypeLoading:!0,statusOptions:[{value:"Active",label:"Active"},{value:"Inactive",label:"Inactive"}]}},mounted:function(){this.getItems(),this.searchData&&(this.item_id=this.searchData.item_id?this.searchData.item_id:"",this.ecom_item=this.searchData.ecom_item?this.searchData.ecom_item:"",this.sales_type=this.searchData.sales_type?this.searchData.sales_type:"",this.status=this.searchData.status?this.searchData.status:"",this.product_type=this.searchData.product_type?this.searchData.product_type:""),this.sales_type&&this.getSelectesalesType()},methods:{getSelectesalesType:function(){var t=this;this.productTypeLoading=!0,this.sales_type?("DOMESTIC"==this.sales_type?(this.productTypes=this.productTypeDomestics,this.searchData.product_type&&(this.selectedData=this.productTypes.find((function(e){return e.lookup_code==t.searchData.product_type})),this.product_type=this.selectedData.lookup_code)):(this.productTypes=this.productTypeExports,this.searchData.product_type&&(this.selectedData=this.productTypes.find((function(e){return e.lookup_code==t.searchData.product_type})),this.product_type=this.selectedData.lookup_code)),this.productTypeLoading=!1):this.product_type=""},getItems:function(){var t,e=this;return(t=i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.itemLoading=!0,e.itemLists=[],t.next=4,axios.get("/om/ajax/get-item-search",{params:{sales_type:e.sales_type,product_type:e.product_type}}).then((function(t){e.itemLoading=!1,e.itemLists=t.data})).catch((function(t){console.log(t)}));case 4:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(a,i){var c=t.apply(e,s);function l(t){o(c,a,i,l,r,"next",t)}function r(t){o(c,a,i,l,r,"throw",t)}l(void 0)}))})()}}};const l=(0,s(51900).Z)(c,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-1"}),t._v(" "),s("div",{staticClass:"col-md-4"},[s("label",[t._v(" ประเภทการขาย : ")]),t._v(" "),s("input",{attrs:{type:"hidden",name:"sales_type",autocomplete:"off"},domProps:{value:t.sales_type}}),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},on:{change:function(e){t.getSelectesalesType(),t.getItems()}},model:{value:t.sales_type,callback:function(e){t.sales_type=e},expression:"sales_type"}},t._l(t.salesTypes,(function(t){return s("el-option",{key:t.value,attrs:{label:t.description,value:t.value}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-4"},[s("label",[t._v(" ชนิดผลิตภัณฑ์ : ")]),t._v(" "),s("input",{attrs:{type:"hidden",name:"product_type",autocomplete:"off"},domProps:{value:t.product_type}}),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",disabled:this.productTypeLoading},on:{change:function(e){return t.getItems()}},model:{value:t.product_type,callback:function(e){t.product_type=e},expression:"product_type"}},t._l(t.productTypes,(function(t){return s("el-option",{key:t.lookup_code,attrs:{label:t.description,value:t.lookup_code}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-2"},[s("label",[t._v(" สถานะการใช้งาน : ")]),t._v(" "),s("input",{attrs:{type:"hidden",name:"status",autocomplete:"off"},domProps:{value:t.status}}),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.status,callback:function(e){t.status=e},expression:"status"}},t._l(t.statusOptions,(function(t){return s("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1)]),t._v(" "),s("div",{staticClass:"row mt-2"},[s("div",{staticClass:"col-md-1"}),t._v(" "),s("div",{staticClass:"col-md-4"},[s("label",[t._v(" ชื่อตราผลิตภัณฑ์ : ")]),t._v(" "),s("input",{attrs:{type:"hidden",name:"item_id",autocomplete:"off"},domProps:{value:t.item_id}}),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.item_id,callback:function(e){t.item_id=e},expression:"item_id"}},t._l(t.itemLists,(function(t,e){return s("el-option",{key:e,attrs:{label:t.item_code+" : "+t.item_description,value:t.item_id}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-4"},[s("label",[t._v(" ชื่อที่ปรากฏในหน้าจอ E-Commerce : ")]),t._v(" "),s("input",{attrs:{type:"hidden",name:"ecom_item",autocomplete:"off"},domProps:{value:t.ecom_item}}),t._v(" "),s("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.ecom_item,callback:function(e){t.ecom_item=e},expression:"ecom_item"}},t._l(t.itemLists,(function(t,e){return s("el-option",{key:e,attrs:{label:t.item_code+" : "+t.item_description,value:t.item_id}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-2"},[s("label",{staticClass:" tw-font-bold tw-uppercase mb-0"},[t._v(" ")]),t._v(" "),s("div",{staticClass:"text-right"},[t._m(0),t._v(" "),s("a",{staticClass:"btn btn-warning btn-sm",attrs:{href:this.actionUrl}},[s("i",{staticClass:"fa fa-undo"}),t._v(" รีเซต")])])])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("button",{staticClass:"btn btn-light btn-sm",attrs:{type:"submit"}},[s("i",{staticClass:"fa fa-search",attrs:{"aria-hidden":"true"}}),t._v(" ค้นหา\n                ")])}],!1,null,null,null).exports}}]);