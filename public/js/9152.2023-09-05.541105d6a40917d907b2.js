(self.webpackChunk=self.webpackChunk||[]).push([[9152],{89152:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>l});var a=s(7398),r=s.n(a);s(2223);function _(t,e){var s=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),s.push.apply(s,a)}return s}function i(t){for(var e=1;e<arguments.length;e++){var s=null!=arguments[e]?arguments[e]:{};e%2?_(Object(s),!0).forEach((function(e){c(t,e,s[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(s)):_(Object(s)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(s,e))}))}return t}function c(t,e,s){return e in t?Object.defineProperty(t,e,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[e]=s,t}const n={props:["reportDates","reportDateTimes","reportItems"],components:{Loading:r()},data:function(){var t=this;return{is_loading:!1,reportProductQualityItems:this.reportDates.map((function(e){var s=t.reportDateTimes.filter((function(t){return t.date_drawn_formatted==e.date_drawn_formatted})).map((function(e){var s=t.reportItems.filter((function(t){return t.date_drawn_formatted==e.date_drawn_formatted&&t.time_drawn_formatted==e.time_drawn_formatted}));return i(i({},e),{},{report_items:s})}));return i(i({},e),{},{report_datetime_items:s})}))}},methods:{}};const l=(0,s(51900).Z)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table table-bordered table-sticky mb-0",staticStyle:{"min-width":"3200px"}},[t._m(0),t._v(" "),t.reportProductQualityItems.length>0?s("tbody",[t._l(t.reportProductQualityItems,(function(e,a){return[t._l(e.report_datetime_items,(function(r,_){return[t._l(r.report_items,(function(i,c){return[s("tr",{key:a+"_"+_+"_"+c,attrs:{clsss:"tw-text-xs"}},[e.first_sample_no==i.sample_no&&e.first_test_code==i.result.test_code?s("td",{staticClass:"text-center",staticStyle:{"vertical-align":"top !important"},attrs:{rowspan:e.count_items}},[t._v(" \n                                "+t._s(i.date_drawn_formatted)+" \n                            ")]):t._e(),t._v(" "),r.first_sample_no==i.sample_no&&r.first_test_code==i.result.test_code?s("td",{staticClass:"text-center",staticStyle:{"vertical-align":"top !important"},attrs:{rowspan:r.count_items}},[t._v("  \n                                "+t._s(i.time_drawn_formatted)+" \n                            ")]):t._e(),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.machine_set)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.brand)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.result.test_desc)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(null!==i.result.result_value?parseFloat(i.result.result_value):"")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.result.test_unit)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.result.min_value?parseFloat(i.result.min_value):"")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.result.max_value?parseFloat(i.result.max_value):""))]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.result_status_label))]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.quality_status_label))]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.sample_no)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.result.test_code)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.maker)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.machine_type_desc)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.machine_name?"QTM"+i.machine_name:"")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.equipment_type?"QTM "+i.equipment_type:"")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.test_time)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.lot_number)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.brand_category_name)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.confirm_status?i.confirm_status:"")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.sample_operation_status_desc)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.sample_result_status_desc)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.o_approval_status_label?i.o_approval_status_label:"-")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.s_approval_status_label?i.s_approval_status_label:"-")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.l_approval_status_label?i.l_approval_status_label:"-")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(i.file_name)+"  ")])])]}))]}))]}))],2):s("tbody",[t._m(1)])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",[s("th",{staticClass:"text-center",attrs:{width:"6%"}},[t._v(" วันที่ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"4%"}},[t._v(" เวลา ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"4%"}},[t._v(" หมายเลขเครื่อง ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" บุหรี่ / ก้นกรอง ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ชื่อการทดสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"4%"}},[t._v(" ผลการทดสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"3%"}},[t._v(" หน่วยนับ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"4%"}},[t._v(" ค่าควบคุม-Min ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"4%"}},[t._v(" ค่าควบคุม-Max ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ผลการตรวจ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ตามข้อกำหนด ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"120px"},attrs:{width:"10%"}},[t._v(" เลขที่การตรวจสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" รหัสการทดสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" หมายเลขเครื่อง Maker ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ประเภทเครื่อง Maker ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" หมายเลขเครื่อง QTM ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ประเภทเครื่อง QTM ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" เวลาวัดผล ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" รหัสบุหรี่ / ก้นกรอง ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"80px"},attrs:{width:"5%"}},[t._v(" ขนาดบุหรี่ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"5%"}},[t._v(" สถานะการยืนยันผล ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"80px"},attrs:{width:"5%"}},[t._v(" สถานะการลงผล ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"80px"},attrs:{width:"5%"}},[t._v(" สถานะการทดสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"5%"}},[t._v(" สถานะการอนุมัติ-Operator ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"5%"}},[t._v(" สถานะการอนุมัติ-Supervisor ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"5%"}},[t._v(" สถานะการอนุมัติ-Leader ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ชื่อไฟล์ผลการทดสอบ  ")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{attrs:{colspan:"26"}},[s("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports}}]);