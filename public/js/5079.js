(self.webpackChunk=self.webpackChunk||[]).push([[5079],{68967:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>i});function a(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function n(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?a(Object(r),!0).forEach((function(e){c(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):a(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function c(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}const s={props:["gasStation"],data:function(){return{return_vat_flag:"Y"==this.gasStation.return_vat_flag}},methods:{changeChecked:function(t,e){var r=this,a=n(n({},t),{},{return_vat_flag:e?"Y":"N"});axios.put("/ir/ajax/gas-stations/return-vat-flag",{data:a}).then((function(t){var e=t.data;swal({title:"Success",text:e.message,type:"success"})})).catch((function(t){400===t.response.data.status?(swal({title:"Warning",text:t.response.data.message,type:"warning"}),r.return_vat_flag=r.gasStation.return_vat_flag):swal("Error",t,"error")}))}}};const i=(0,r(51900).Z)(s,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("div",{staticClass:"form-check",staticStyle:{position:"inherit"}},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.return_vat_flag,expression:"return_vat_flag"}],staticClass:"form-check-input",staticStyle:{position:"inherit"},attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.return_vat_flag)?t._i(t.return_vat_flag,null)>-1:t.return_vat_flag},on:{change:[function(e){var r=t.return_vat_flag,a=e.target,n=!!a.checked;if(Array.isArray(r)){var c=t._i(r,null);a.checked?c<0&&(t.return_vat_flag=r.concat([null])):c>-1&&(t.return_vat_flag=r.slice(0,c).concat(r.slice(c+1)))}else t.return_vat_flag=n},function(e){return t.changeChecked(t.gasStation,t.return_vat_flag)}]}})])])}),[],!1,null,null,null).exports}}]);