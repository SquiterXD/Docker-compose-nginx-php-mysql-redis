(self.webpackChunk=self.webpackChunk||[]).push([[9422],{21162:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>a});var l=n(23645),o=n.n(l)()((function(t){return t[1]}));o.push([t.id,"tr.duplicate_test_id>td{border:4px solid #ed5565!important}",""]);const a=o},19422:(t,e,n)=>{"use strict";n.r(e),n.d(e,{default:()=>i});var l=n(87757),o=n.n(l);function a(t,e,n,l,o,a,r){try{var s=t[a](r),i=s.value}catch(t){return void n(t)}s.done?e(i):Promise.resolve(i).then(l,o)}function r(t){return function(){var e=this,n=arguments;return new Promise((function(l,o){var r=t.apply(e,n);function s(t){a(r,l,o,s,i,"next",t)}function i(t){a(r,l,o,s,i,"throw",t)}s(void 0)}))}}const s={props:["mothLocators","mothBuildings","mothDepartments","oldInputs"],data:function(){return{building:null!=this.oldInputs&&this.oldInputs?this.oldInputs.building:null,department:null!=this.oldInputs&&this.oldInputs?this.oldInputs.department:null,departments:[],locator:null!=this.oldInputs&&this.oldInputs?this.oldInputs.locator_id:null,locators:this.mothLocators,loading:!1}},watch:{},mounted:function(){this.showLocation()},methods:{showLocation:function(){var t=this;return r(o().mark((function e(){var n;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:(n=t).departments=[],n.building&&(n.departments=n.mothDepartments[n.building],n.locators=n.mothLocators.filter((function(t){return t.build_name==n.building}))),n.department&&(n.locators=n.locators.filter((function(t){return t.department_name==n.department}))),n.building||(n.locators=n.mothLocators);case 5:case"end":return e.stop()}}),e)})))()},changeDept:function(){var t=this;return r(o().mark((function e(){var n;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:(n=t).locator="",n.showLocation();case 3:case"end":return e.stop()}}),e)})))()}}};n(54302);const i=(0,n(51900).Z)(s,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"col-12"},[n("div",{staticClass:"row form-group"},[n("label",{staticClass:"col-md-2 col-form-label text-right"},[t._v(" อาคาร ")]),t._v(" "),n("div",{staticClass:"col-md-4"},[n("input",{attrs:{type:"hidden",name:"building"},domProps:{value:t.building}}),t._v(" "),n("el-select",{staticClass:"w-100",attrs:{placeholder:"",size:"medium",clearable:!0,filterable:!0},on:{change:t.showLocation},model:{value:t.building,callback:function(e){t.building=e},expression:"building"}},t._l(t.mothBuildings,(function(t,e){return n("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1),t._v(" "),n("label",{staticClass:"col-md-1 col-form-label text-right"},[t._v(" หน่วยงาน ")]),t._v(" "),n("div",{staticClass:"col-md-4"},[n("input",{attrs:{type:"hidden",name:"department"},domProps:{value:t.department}}),t._v(" "),n("el-select",{staticClass:"w-100",attrs:{placeholder:"",size:"medium",clearable:!0,filterable:!0},on:{change:function(e){return t.changeDept()}},model:{value:t.department,callback:function(e){t.department=e},expression:"department"}},t._l(t.departments,(function(t,e){return n("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)]),t._v(" "),n("div",{staticClass:"row form-group mt-3"},[t._m(0),t._v(" "),n("input",{attrs:{type:"hidden",name:"locator_id"},domProps:{value:t.locator}}),t._v(" "),n("div",{staticClass:"col-md-4"},[n("el-select",{staticClass:"w-100",attrs:{placeholder:"",size:"medium",clearable:!0,filterable:!0},model:{value:t.locator,callback:function(e){t.locator=e},expression:"locator"}},t._l(t.locators,(function(t,e){return n("el-option",{key:e,attrs:{label:t.location_desc+" : "+t.locator_desc,value:t.inventory_location_id}})})),1)],1)])])}),[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("label",{staticClass:"col-md-2 col-form-label text-right"},[t._v(" จุดตรวจสอบ "),n("span",{staticStyle:{color:"red"}},[t._v(" * ")])])}],!1,null,null,null).exports},54302:(t,e,n)=>{var l=n(21162);l.__esModule&&(l=l.default),"string"==typeof l&&(l=[[t.id,l,""]]),l.locals&&(t.exports=l.locals);(0,n(45346).Z)("416d8784",l,!0,{})}}]);