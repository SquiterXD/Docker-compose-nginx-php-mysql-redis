(self.webpackChunk=self.webpackChunk||[]).push([[859],{40859:(t,o,r)=>{"use strict";r.r(o),r.d(o,{default:()=>a});function e(t){return function(t){if(Array.isArray(t))return n(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,o){if(!t)return;if("string"==typeof t)return n(t,o);var r=Object.prototype.toString.call(t).slice(8,-1);"Object"===r&&t.constructor&&(r=t.constructor.name);if("Map"===r||"Set"===r)return Array.from(t);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return n(t,o)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(t,o){(null==o||o>t.length)&&(o=t.length);for(var r=0,e=new Array(o);r<o;r++)e[r]=t[r];return e}const l={props:["qmGroups","locators","qmGroupFromValue","qmGroupToValue","locatorValue"],data:function(){return{qmGroupFrom:this.qmGroupFromValue,qmGroupTo:this.qmGroupToValue,locator:this.locatorValue,qmGroupOptions:this.qmGroups,locatorOptions:this.qmGroupFromValue||this.qmGroupToValue?this.getLocatorOptions(this.qmGroupFromValue,this.qmGroupToValue):[]}},methods:{getLocatorOptions:function(t,o){console.log(t,o);var r=t?this.locators.filter((function(o){return o.qm_group==t})):[],n=o?this.locators.filter((function(t){return t.qm_group==o})):[];return[].concat(e(r),e(n)).filter((function(t,o,r){return o===r.findIndex((function(o){return o.inventory_location_id===t.inventory_location_id}))})).sort((function(t,o){return t.location_desc-o.location_desc}))},onQmGroupFromWasSelected:function(t){var o=this;this.qmGroupFrom=t,this.locatorOptions=this.getLocatorOptions(t,this.qmGroupTo),this.locator&&this.locatorOptions.find((function(t){return t.inventory_location_id==o.locator}))||(this.locator=null)},onLocatorWasSelected:function(t){this.locator=t}}};const a=(0,r(51900).Z)(l,(function(){var t=this,o=t.$createElement,r=t._self._c||o;return r("div",{staticClass:"col-12"},[r("div",{staticClass:"row form-group"},[t._m(0),t._v(" "),r("div",{staticClass:"col-md-8"},[r("qm-el-select",{attrs:{name:"qm_group_from",id:"input_qm_group_from","option-key":"qm_group_value","option-value":"qm_group_value","option-label":"qm_group_label","select-options":t.qmGroupOptions,value:t.qmGroupFrom,clearable:!0,filterable:!0},on:{onSelected:t.onQmGroupFromWasSelected}})],1)]),t._v(" "),r("div",{staticClass:"row form-group"},[t._m(1),t._v(" "),r("div",{staticClass:"col-md-8"},[r("qm-el-select",{attrs:{name:"locator_id",id:"input_locator_id","option-key":"inventory_location_id","option-value":"inventory_location_id","option-label":"location_full_desc","select-options":t.locatorOptions,value:t.locator,clearable:!0,filterable:!0},on:{onSelected:t.onLocatorWasSelected}})],1)])])}),[function(){var t=this,o=t.$createElement,r=t._self._c||o;return r("label",{staticClass:"col-md-4 col-form-label"},[t._v("กลุ่มงาน "),r("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,o=t.$createElement,r=t._self._c||o;return r("label",{staticClass:"col-md-4 col-form-label"},[t._v("จุดตรวจสอบ "),r("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);