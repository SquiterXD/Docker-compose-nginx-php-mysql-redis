(self.webpackChunk=self.webpackChunk||[]).push([[8894],{16722:(e,t,r)=>{"use strict";r.d(t,{Z:()=>o});var n=r(23645),s=r.n(n)()((function(e){return e[1]}));s.push([e.id,"tr.duplicate_test_id>td{border:4px solid #ed5565!important}",""]);const o=s},48894:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>i});var n=r(87757),s=r.n(n);function o(e,t,r,n,s,o,c){try{var a=e[o](c),l=a.value}catch(e){return void r(e)}a.done?t(l):Promise.resolve(l).then(n,s)}function c(e){return function(){var t=this,r=arguments;return new Promise((function(n,s){var c=e.apply(t,r);function a(e){o(c,n,s,a,l,"next",e)}function l(e){o(c,n,s,a,l,"throw",e)}a(void 0)}))}}const a={props:["pBrands","pDefBrands","pProductType","pDefProductType","pRequest"],data:function(){return{brands:null!=this.pBrands&&this.pBrands?this.pBrands:[],productType:null!=this.pProductType&&this.pProductType?this.pProductType:[],selected:{brand:null!=this.pDefBrands&&this.pDefBrands?this.pDefBrands:null,productType:null!=this.pDefProductType&&this.pDefProductType?this.pDefProductType:null},testType:this.pRequest.test_type}},watch:{},mounted:function(){this.showData()},methods:{showData:function(){var e=this;return c(s().mark((function t(){var r,n,o;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:""!=(r=e).selected.brand&&null!=r.selected.brand||(r.brands=null!=r.pBrands&&r.pBrands?r.pBrands:[]),""!=r.selected.productType&&null!=r.selected.productType||(r.productType=null!=r.pProductType&&r.pProductType?r.pProductType:[]),r.selected.brand&&(n=r.pBrands.filter((function(e){return e.item_number==r.selected.brand}))).length>0&&(n=n[0],r.productType=r.pProductType.filter((function(e){return e.lookup_code==n.product_type_code})),r.selected.productType=n.product_type_code),r.selected.productType&&(o=r.pProductType.filter((function(e){return e.lookup_code==r.selected.productType}))).length>0&&(o=o[0],r.brands=r.pBrands.filter((function(e){return e.product_type_code==o.lookup_code})));case 5:case"end":return t.stop()}}),t)})))()},changeDept:function(){var e=this;return c(s().mark((function t(){var r;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:(r=e).locator="",r.showData();case 3:case"end":return t.stop()}}),t)})))()}}};var l=r(93379),d=r.n(l),p=r(16722),u={insert:"head",singleton:!1};d()(p.Z,u);p.Z.locals;const i=(0,r(51900).Z)(a,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"row form-group"},[r("input",{directives:[{name:"model",rawName:"v-model",value:e.testType,expression:"testType"}],attrs:{type:"hidden",name:"test_type"},domProps:{value:e.testType},on:{input:function(t){t.target.composing||(e.testType=t.target.value)}}}),e._v(" "),r("div",{staticClass:"col-md-6"},[r("div",{staticClass:"row"},[r("label",{staticClass:"col-md-4 col-form-label"},[e._v(" ตราบุหรี่ ")]),e._v(" "),r("div",{staticClass:"col-md-8"},[r("el-select",{staticClass:"w-100",attrs:{placeholder:"",size:"medium",clearable:!0,filterable:!0},on:{change:e.showData},model:{value:e.selected.brand,callback:function(t){e.$set(e.selected,"brand",t)},expression:"selected.brand"}},e._l(e.brands,(function(e,t){return r("el-option",{key:t,attrs:{label:e.item_number+" : "+e.item_desc,value:e.item_number}})})),1),e._v(" "),r("input",{attrs:{type:"hidden",name:"lot_number"},domProps:{value:e.selected.brand}})],1)])]),e._v(" "),r("div",{staticClass:"col-md-6"},[r("div",{staticClass:"row"},[r("label",{staticClass:"col-md-4 col-form-label"},[e._v(" ขนาดบุหรี่ ")]),e._v(" "),r("div",{staticClass:"col-md-8"},[r("el-select",{staticClass:"w-100",attrs:{placeholder:"",size:"medium",clearable:!0,filterable:!0},on:{change:e.showData},model:{value:e.selected.productType,callback:function(t){e.$set(e.selected,"productType",t)},expression:"selected.productType"}},e._l(e.productType,(function(e,t){return r("el-option",{key:t,attrs:{label:e.lookup_code+" : "+e.meaning,value:e.lookup_code}})})),1),e._v(" "),r("input",{attrs:{type:"hidden",name:"product_type_code"},domProps:{value:e.selected.productType}})],1)])])])}),[],!1,null,null,null).exports}}]);