(self.webpackChunk=self.webpackChunk||[]).push([[5486],{15486:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>o});var s=r(7398),a=r.n(s);r(19371);function n(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,s)}return r}function _(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?n(Object(r),!0).forEach((function(e){c(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):n(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function c(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}const i={props:["reportDates","reportDateTimes","reportItems"],components:{Loading:a()},data:function(){var t=this;return{is_loading:!1,reportQuantumNeoItems:this.reportDates.map((function(e){var r=t.reportDateTimes.filter((function(t){return t.date_drawn_formatted==e.date_drawn_formatted})).map((function(e){var r=t.reportItems.filter((function(t){return t.date_drawn_formatted==e.date_drawn_formatted&&t.time_drawn_formatted==e.time_drawn_formatted}));return _(_({},e),{},{report_items:r})}));return _(_({},e),{},{report_datetime_items:r})}))}},methods:{}};const o=(0,r(51900).Z)(i,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"table-responsive"},[r("table",{staticClass:"table table-bordered table-sticky mb-0"},[t._m(0),t._v(" "),t.reportQuantumNeoItems.length>0?r("tbody",[t._l(t.reportQuantumNeoItems,(function(e,s){return[t._l(e.report_datetime_items,(function(a,n){return[t._l(a.report_items,(function(_,c){return[r("tr",{key:s+"_"+n+"_"+c,attrs:{clsss:"tw-text-xs"}},[e.first_sample_no==_.sample_no&&e.first_test_code==_.result.test_code?r("td",{staticClass:"text-center",staticStyle:{"vertical-align":"top !important"},attrs:{rowspan:e.count_items}},[t._v(" \n                                "+t._s(_.date_drawn_formatted)+" \n                            ")]):t._e(),t._v(" "),a.first_sample_no==_.sample_no&&a.first_test_code==_.result.test_code?r("td",{staticClass:"text-center",staticStyle:{"vertical-align":"top !important"},attrs:{rowspan:a.count_items}},[t._v("  \n                                "+t._s(_.time_drawn_formatted)+" \n                            ")]):t._e(),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.machine_set)+" ")]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.brand)+" ")]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.result.test_desc)+" ")]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.result.result_value)+" ")]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.result.test_unit)+" ")]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.result.min_value)+" ")]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.result.max_value))]),t._v(" "),r("td",{staticClass:"text-center"},[t._v(" "+t._s(_.result_status_label))])])]}))]}))]}))],2):r("tbody",[t._m(1)])])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("thead",[r("tr",[r("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" วันที่ ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" เวลา ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" หมายเลขเครื่อง ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" บุหรี่ / ก้นกรอง ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" ชื่อการทดสอบ ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" ผลการทดสอบ ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" หน่วยนับ ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" ค่าควบคุม-Min ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" ค่าควบคุม-Max ")]),t._v(" "),r("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ผลการตรวจ ")])])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("tr",[r("td",{attrs:{colspan:"12"}},[r("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports}}]);