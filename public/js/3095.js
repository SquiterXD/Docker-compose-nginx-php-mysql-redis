(self.webpackChunk=self.webpackChunk||[]).push([[3095],{83095:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>_});var a=s(7398);const i={props:["reportItems"],components:{Loading:s.n(a)()},data:function(){return{isLoading:!1}},methods:{}};const _=(0,s(51900).Z)(i,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table table-bordered tw-text-xs",staticStyle:{"min-width":"1800px"}},[t._m(0),t._v(" "),t.reportItems.length>0?s("tbody",[t._l(t.reportItems,(function(e,a){return[s("tr",{key:a,attrs:{clsss:"tw-text-xs"}},[s("td",{staticClass:"text-center"},[t._v(" "+t._s(a+1)+" ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.sample_no)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.result.seq)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" \n                        "+t._s(e.date_drawn_formatted)+" \n                    ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.time_drawn_formatted)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.machine_set)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.machine_type)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.brand)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.brand_desc)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.result.test_code)+"\n                    ")]),t._v(" "),s("td",[t._v("\n                        "+t._s(e.result.test_desc)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.result.test_unit_desc)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.result.result_value)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden"},[t._v("\n                        "+t._s(e.locator_desc)+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v("\n                        "+t._s(e.severity_level?e.severity_level:"-")+"\n                    ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.result.qc_production_process)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.result.qm_process)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.result.check_list)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.brand_category_name)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.operation_class_code)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.maker)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.result_status_label)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.quality_status_label)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.created_by_username)+"  "+t._s(e.result_created_by_username)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.sample_disposition_desc)+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.o_approval_status_label?e.o_approval_status_label:"-")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.s_approval_status_label?e.s_approval_status_label:"-")+" ")]),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(e.l_approval_status_label?e.l_approval_status_label:"-")+" ")])])]}))],2):s("tbody",[t._m(1)])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",[s("th",{staticClass:"text-center",staticStyle:{"min-width":"50px"},attrs:{width:"5%"}},[t._v(" รายการ ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"200px"},attrs:{width:"10%"}},[t._v(" เลขที่การตรวจสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"80px"},attrs:{width:"10%"}},[t._v(" ลำดับ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"80px"},attrs:{width:"10%"}},[t._v(" วันที่ ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"40px"},attrs:{width:"5%"}},[t._v(" เวลา ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"40px"},attrs:{width:"5%"}},[t._v(" หมายเลขเครื่อง ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ประเภทเครื่อง ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"5%"}},[t._v(" รหัสตราบุหรี่ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" ตราบุหรี่ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" รหัสปัญหา ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"200px"},attrs:{width:"12%"}},[t._v(" รายละเอียดปัญหา/ข้อบกพร่อง ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"5%"}},[t._v(" หน่วยนับ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"7%"}},[t._v(" จำนวน ")]),t._v(" "),s("th",{staticClass:"text-center tw-text-xs md:tw-table-cell tw-hidden",staticStyle:{"min-width":"100px"},attrs:{width:"12%"}},[t._v(" สถานที่พบ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"10%"}},[t._v(" ความรุนแรง ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"10%"}},[t._v(" คลังกระบวนการ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" กระบวนการตรวจคุณภาพ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" รายการตรวจคุณภาพ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"10%"}},[t._v(" ขนาดบุหรี่ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"60px"},attrs:{width:"10%"}},[t._v(" ขั้นตอน ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"10%"}},[t._v(" เครื่องจักร ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ผลการตรวจ ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"7%"}},[t._v(" ตามข้อกำหนด ")]),t._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[t._v(" ผู้บันทึก ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"200px"},attrs:{width:"9%"}},[t._v(" สถานะการตรวจสอบ ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"7%"}},[t._v(" สถานะการอนุมัติ-Operator ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"7%"}},[t._v(" สถานะการอนุมัติ-Supervisor ")]),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px"},attrs:{width:"7%"}},[t._v(" สถานะการอนุมัติ-Leader ")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{attrs:{colspan:"16"}},[s("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports}}]);