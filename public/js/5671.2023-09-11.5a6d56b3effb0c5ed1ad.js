(self.webpackChunk=self.webpackChunk||[]).push([[5671],{65671:(t,s,e)=>{"use strict";e.r(s),e.d(s,{default:()=>r});var a=e(7398);const _={props:["reportItems","reportHeaderItem"],components:{Loading:e.n(a)()},data:function(){return{isLoading:!1}},methods:{}};const r=(0,e(51900).Z)(_,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"table-responsive"},[e("table",{staticClass:"table table-bordered tw-text-xs",staticStyle:{"min-width":"1400px"}},[e("thead",[e("tr",[e("th",{staticClass:"text-center",staticStyle:{"min-width":"80px"},attrs:{rowspan:"3",width:"10%"}},[t._v(" วันที่ ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"40px"},attrs:{rowspan:"3",width:"5%"}},[t._v(" เวลา ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{rowspan:"3",width:"10%"}},[t._v(" จุดตรวจสอบ ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{rowspan:"3",width:"10%"}},[t._v(" ตรา/ชุด ")]),t._v(" "),e("th",{staticClass:"text-center",attrs:{colspan:"2",width:"10%"}},[t._v(" ค่ามาตรฐาน "+t._s(t.reportHeaderItem.MOIST_SILO_SENSOR.min_value)+" - "+t._s(t.reportHeaderItem.MOIST_SILO_SENSOR.max_value)+" % ")]),t._v(" "),e("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" ค่ามาตรฐาน ")]),t._v(" "),e("th",{staticClass:"text-center",attrs:{width:"10%"}}),t._v(" "),e("th",{staticClass:"text-center",attrs:{colspan:"2",width:"10%"}},[t._v(" ค่ามาตรฐาน "+t._s(t.reportHeaderItem.MOIST_CIG_LAB.min_value)+" - "+t._s(t.reportHeaderItem.MOIST_CIG_LAB.max_value)+" % ")])]),t._v(" "),e("tr",[e("th",{staticClass:"text-center",attrs:{colspan:"2",width:"10%"}},[t._v(" SPL "+t._s(t.reportHeaderItem.MOIST_SILO_SENSOR.spl_min_value)+" - "+t._s(t.reportHeaderItem.MOIST_SILO_SENSOR.spl_max_value)+" % ")]),t._v(" "),e("th",{staticClass:"text-center",attrs:{width:"10%"}},[t._v(" > "+t._s(t.reportHeaderItem.EXPAND.min_value)+" cc/g ")]),t._v(" "),e("th",{staticClass:"text-center",attrs:{width:"10%"}}),t._v(" "),e("th",{staticClass:"text-center",attrs:{colspan:"2",width:"10%"}},[t._v(" SPL "+t._s(t.reportHeaderItem.MOIST_CIG_LAB.spl_min_value)+" - "+t._s(t.reportHeaderItem.MOIST_CIG_LAB.spl_max_value)+" % ")])]),t._v(" "),t._m(0)]),t._v(" "),t.reportItems.length>0?e("tbody",[t._l(t.reportItems,(function(s,a){return[e("tr",{key:a,attrs:{clsss:"tw-text-xs"}},[e("td",{staticClass:"text-center"},[t._v(" \n                        "+t._s(s.date_drawn_formatted)+" \n                    ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(s.time_drawn_formatted)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(s.location_desc)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(s.sample_opt)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center",style:{backgroundColor:"LOWER"==s.moist_silo_sensor_result_status?"#aaffaa":"HIGHER"==s.moist_silo_sensor_result_status?"#ffddaa":""}},[t._v(" \n                        "+t._s(s.moist_silo_sensor_result_value)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center",style:{backgroundColor:"LOWER"==s.moist_silo_lab_result_status?"#aaffaa":"HIGHER"==s.moist_silo_lab_result_status?"#ffddaa":""}},[t._v(" \n                        "+t._s(s.moist_silo_lab_result_value)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(s.expand_result_value)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(s.roll_mc_result_value)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center",style:{backgroundColor:"LOWER"==s.moist_cig_lab_result_status?"#aaffaa":"HIGHER"==s.moist_cig_lab_result_status?"#ffddaa":""}},[t._v(" \n                        "+t._s(s.moist_cig_lab_result_value)+"\n                    ")]),t._v(" "),e("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(s.moist_roll_mc_display_result_value)+"\n                    ")])])]}))],2):e("tbody",[t._m(1)])])])}),[function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("tr",[e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ค่าความชื้นในไซโล ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ค่าความชื้นจ่ายเครื่องมวน ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ค่าความพอง ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" หมายเลขเครื่องมวน ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ค่าความชื้นในมวนบุหรี่ ")]),t._v(" "),e("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ค่าความชื้นที่จอแสดงผล ")])])},function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("tr",[e("td",{attrs:{colspan:"16"}},[e("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports}}]);