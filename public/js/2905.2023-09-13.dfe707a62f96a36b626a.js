(self.webpackChunk=self.webpackChunk||[]).push([[2905],{52905:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>n});var r=s(7398);const c={props:["queryStringSearchInputs","reportMachineSets","reportQmProcesses","reportQmProcessCheckLists","reportItems"],components:{Loading:s.n(r)()},data:function(){return{isLoading:!1}},methods:{getSumResultValue:function(t,e){var s=e.find((function(e){return e.check_list_code==t}));return s&&s.count_result_value?s.count_result_value:null},getAllTotalSumResultValue:function(t){return t.reduce((function(t,e){return t+e.total_count_result_value}),0)}}};const n=(0,s(51900).Z)(c,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"table-responsive"},[s("table",{staticClass:"table table-bordered tw-text-xs",staticStyle:{"min-width":"1400px"}},[s("thead",[s("tr",[s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px","max-width":"100px"}},[t._v(" กระบวนการผลิต ")]),t._v(" "),t._l(t.reportQmProcesses,(function(e,r){return[s("th",{key:r,staticClass:"text-center",attrs:{colspan:e.count_check_lists}},[t._v("\n                        "+t._s(e.qm_process)+"\n                    ")])]})),t._v(" "),s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px","max-width":"100px"},attrs:{rowspan:"2"}},[t._v(" รวม ")])],2),t._v(" "),s("tr",[s("th",{staticClass:"text-center",staticStyle:{"min-width":"100px","max-width":"100px"}},[t._v(" รายการตรวจ / หมายเลขเครื่อง ")]),t._v(" "),t._l(t.reportQmProcessCheckLists,(function(e,r){return[s("th",{key:r,staticClass:"text-center",staticStyle:{"min-width":"60px"}},[t._v("\n                        "+t._s(e.check_list)+"\n                    ")])]}))],2)]),t._v(" "),t.reportMachineSets.length>0?s("tbody",[t._l(t.reportMachineSets,(function(e,r){return[s("tr",{key:""+r},[s("td",{key:""+r,staticClass:"text-center"},[t._v(" "+t._s(e.machine_set)+" ")]),t._v(" "),t._l(t.reportItems,(function(c,n){return[c.machine_set==e.machine_set?[c.results.length>0?[t._l(t.reportQmProcessCheckLists,(function(e,a){return[t.getSumResultValue(e.check_list_code,c.results)?s("td",{key:r+"_"+n+"_"+a,staticClass:"text-center tw-font-bold",staticStyle:{"background-color":"#fff0a0"}},[s("a",{attrs:{href:"/qm/finished-products/report-issue-details?"+t.queryStringSearchInputs+"&machine_set="+c.machine_set+"&qm_process_seq="+e.qm_process_seq+"&check_list_code="+e.check_list_code,target:"_blank"}},[t._v("\n                                            "+t._s(t.getSumResultValue(e.check_list_code,c.results))+"\n                                        ")])]):s("td",{key:r+"_"+n+"_"+a,staticClass:"text-center"},[t._v(" \n                                        -\n                                    ")])]})),t._v(" "),s("td",{key:r+"_"+n+"_total",staticClass:"text-center"},[t._v(" "+t._s(c.total_count_result_value?c.total_count_result_value:"-")+" ")])]:[t._l(t.reportQmProcessCheckLists,(function(e,c){return[s("td",{key:r+"_"+n+"_"+c,staticClass:"text-center"},[s("span",[t._v(" - ")])])]})),t._v(" "),s("td",{key:r+"_"+n+"_total",staticClass:"text-center"},[t._v(" - ")])]]:t._e()]}))],2)]})),t._v(" "),s("tr",[s("td",{staticClass:"text-center tw-font-bold"},[t._v(" รวม ")]),t._v(" "),t._l(t.reportQmProcessCheckLists,(function(e,r){return[s("td",{key:""+r,staticClass:"text-center tw-font-bold"},[t._v(" \n                        "+t._s(e.total_count_result_value)+"\n                    ")])]})),t._v(" "),s("td",{staticClass:"text-center"},[t._v(" "+t._s(t.getAllTotalSumResultValue(t.reportQmProcessCheckLists))+" ")])],2)],2):s("tbody",[t._m(0)])])])}),[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("tr",[s("td",{attrs:{colspan:"13"}},[s("h2",{staticClass:"p-5 text-center text-muted"},[t._v(" ไม่พบข้อมูล ")])])])}],!1,null,null,null).exports}}]);