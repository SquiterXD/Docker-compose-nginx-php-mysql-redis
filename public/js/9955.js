(self.webpackChunk=self.webpackChunk||[]).push([[9955],{22524:(t,e,a)=>{"use strict";a.d(e,{Z:()=>s});var r=a(23645),o=a.n(r)()((function(t){return t[1]}));o.push([t.id,".box-card .el-card__body{padding:0!important}",""]);const s=o},1559:(t,e,a)=>{"use strict";a.d(e,{Z:()=>s});var r=a(23645),o=a.n(r)()((function(t){return t[1]}));o.push([t.id,'.el-card__body[data-v-6a2ce0e2]{padding:0!important}.card_header[data-v-6a2ce0e2]{font-weight:700;font-size:18px}.card_body[data-v-6a2ce0e2]{padding:20px}.card_body[data-v-6a2ce0e2]:not(:last-child){border-bottom:1px solid #ebeef4}.font-bold[data-v-6a2ce0e2]{font-weight:700}.text[data-v-6a2ce0e2]{font-size:12px}.item[data-v-6a2ce0e2]{margin-bottom:18px}.clearfix[data-v-6a2ce0e2]:after,.clearfix[data-v-6a2ce0e2]:before{display:table;content:""}.clearfix[data-v-6a2ce0e2]:after{clear:both}.box-card[data-v-6a2ce0e2]{margin:20px 0}.box-card[data-v-6a2ce0e2],.w-100[data-v-6a2ce0e2]{width:100%}.error-message[data-v-6a2ce0e2]{display:flex;color:#ec4958;margin-top:5px}.error-message strong[data-v-6a2ce0e2]{margin-right:5px}.mt-custom__10[data-v-6a2ce0e2]{margin-top:10px}.text-title[data-v-6a2ce0e2]{font-size:16px;font-weight:600}.btn-info[data-v-6a2ce0e2]{background-color:#02b0ef;border-color:#02b0ef}.btn-success[data-v-6a2ce0e2]{background-color:#1ab394;border-color:#1ab394}.btn-cancel[data-v-6a2ce0e2]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-6a2ce0e2]{color:#ec4958}.td-select[data-v-6a2ce0e2]{cursor:pointer;border:2px solid #eee;border-radius:5px;padding:10px 0}.background-dialog__custom[data-v-6a2ce0e2]{width:100%;height:100%;position:absolute;top:0;left:0;z-index:100;background:#f3f3f4;opacity:.7}.flex_end[data-v-6a2ce0e2]{display:flex;justify-content:flex-end}',""]);const s=o},49955:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>y});var r=a(87757),o=a.n(r),s=a(30381),n=a.n(s),i=a(92077),c=a.n(i),l=a(7869),u=a.n(l);function d(t,e,a,r,o,s,n){try{var i=t[s](n),c=i.value}catch(t){return void a(t)}i.done?e(c):Promise.resolve(c).then(r,o)}function m(t){return function(){var e=this,a=arguments;return new Promise((function(r,o){var s=t.apply(e,a);function n(t){d(s,r,o,n,i,"next",t)}function i(t){d(s,r,o,n,i,"throw",t)}n(void 0)}))}}const p={props:["is_create"],data:function(){return{loadingInput:{},loading:!1,form_error:{},form:{period_year:"",cost_code:"",uom_code:"",description:"",quantity:"",version:"",start_date_thai:"",end_date_thai:"",shot_year_thai:"",approved_status:""},status:{tableData:!1,tableDataLine:!1},option:{fiscal_year:[],cost_center:[],version:[]},tableDataHeader:[],tableDataLine:[],headLine:{}}},computed:{unitPerCostCenter:function(){var t="";return this.form.cost_code&&this.form.quantity&&this.form.uom_code&&(t="".concat(this.form.quantity," ").concat(this.form.uom_code)),t},disableStore:function(){return!(this.form.cost_code&&this.form.period_year&&this.form.version)}},created:function(){this.getMasterData()},methods:{numberWithCommas:function(t){return t.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g,",")},numberFormat:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"0.0[000000000]",a=c()(t).format(e);return"NaN"==a&&(a=t),a},getMasterData:function(){var t=this;return m(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.loading=!0,t.getPeriodYears(),t.getCostCenters(),t.loading=!1;case 4:case"end":return e.stop()}}),e)})))()},getCostCenters:function(){var t=this;this.loading=!0,axios.get("/ct/ajax/cost_center/cost-center-view").then((function(e){t.option.cost_center=e.data})).then((function(){t.loading=!1}))},getPeriodYears:function(){var t=this;this.loadingInput.fiscal_year=!0,axios.get("/ct/ajax/product_plan_amount/years").then((function(e){t.option.fiscal_year=e.data})),this.loadingInput.fiscal_year=!1},errorMessage:function(t){var e=this,a=t.errors;a&&(Object.keys(a).forEach((function(t){e.form_error[t]={},e.form_error[t].title=t,e.form_error[t].message=a[t][0]})),this.resetError())},selectFiscalYear:function(){var t=this,e=this.option.fiscal_year.find((function(e){return e.period_year==t.form.period_year}));this.form.shot_year_thai=e.shot_year_thai,this.getDropDownVersion(),this.getPlanVersion()},selectCostCenter:function(){var t=this,e=this.option.cost_center.find((function(e){return e.cost_code==t.form.cost_code}));this.form.description=e.description,this.form.uom_code=e.uom_code,this.form.quantity=e.quantity},resetError:function(){var t=this;setTimeout((function(){t.form_error={}}),5e3)},getSummaries:function(t){var e=this,a=t.columns,r=t.data,o=[];return a.forEach((function(t,a){if(0!==a){var s=r.map((function(e){return Number(e[t.property])}));if("cost_raw_mate"!=t.property||s.every((function(t){return isNaN(t)})))if("quantity_used"!=t.property||s.every((function(t){return isNaN(t)})))o[a]="";else{var n=_.sumBy(e.tableDataLine,(function(t){return parseFloat(t.quantity_used)}));o[a]=e.numberWithCommas(parseFloat(n).toFixed(9))}else o[a]=0!=e.headLine.summary_cost?e.numberWithCommas(parseFloat(e.headLine.summary_cost).toFixed(9)):e.headLine.summary_cost}else o[a]="รวม"})),o},getTableDataLine:function(t){var e=this;return m(o().mark((function a(){return o().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return e.loading=!0,e.headLine.productGroup="".concat(t.product_group," ").concat(t.product_group_name),e.headLine.productGroupDetail="".concat(t.product_item_number,"-").concat(t.product_item_desc),e.headLine.summary_cost="".concat(t.summary_cost),a.next=6,axios.get("/ct/ajax/std_raw_material_cost/find?allocate_year_id=".concat(t.allocate_year_id,"&product_group=").concat(t.product_group,"&product_item_number=").concat(t.product_item_number)).then((function(t){e.tableDataLine=t.data,e.tableDataLine.sort((function(t,e){return t.item_number-e.item_number})),e.status.tableDataLine=!0,e.$message({showClose:!0,message:"ประมวลผลสำเร็จ",type:"success"})})).catch((function(t){e.errorMessage(t.response),e.$message({showClose:!0,message:"ไม่สามารถประมวลผลได้",type:"error"})})).then((function(){e.loading=!1}));case 6:case"end":return a.stop()}}),a)})))()},getDropDownVersion:function(){var t=this;return m(o().mark((function e(){var a,r,s;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(t.is_create){e.next=4;break}return a=t.form,r=a.period_year,s=a.cost_code,e.next=4,axios.get("/ct/ajax/std_raw_material_cost/version?period_year=".concat(r,"&cost_code=").concat(s)).then((function(e){t.option.version=e.data.version})).catch((function(t){})).then((function(){}));case 4:case"end":return e.stop()}}),e)})))()},search:function(){var t=this;return m(o().mark((function e(){var a,r,s,n;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,a=t.form,r=a.cost_code,s=a.period_year,n=a.version,e.next=4,axios.get("/ct/ajax/std_raw_material_cost?cost_code=".concat(r,"&period_year=").concat(s,"&version_no=").concat(n)).then((function(e){if(e.data.data.length>0&&e.data.std_cost_head){var a=e.data.std_cost_head;t.tableDataHeader=e.data.data,t.tableDataHeader.sort((function(t,e){return t.product_item_number-e.product_item_number})),t.form.start_date_thai=a.start_date_thai,t.form.end_date_thai=a.end_date_thai,t.form.approved_status=t.convertStatus(a.approved_status),t.status.tableData=!0,t.$message({showClose:!0,message:"ประมวลผลสำเร็จ",type:"success"})}else t.tableDataHeader=[],t.form.approved_status="",t.status.tableData=!1,e.data.std_cost_head?e.data.data.length<=0&&t.$message({showClose:!0,message:"ไม่พบข้อมูลต้นทุนวัตถุดิบมาตรฐาน",type:"error"}):t.$message({showClose:!0,message:"ไม่พบข้อมูล std_cost_heads",type:"error"})})).catch((function(e){t.tableDataHeader=[],t.form.approved_status="",t.status.tableData=!1,t.errorMessage(e.response),t.$message({showClose:!0,message:"ไม่สามารถประมวลผลได้",type:"error"})})).then((function(){t.loading=!1}));case 4:case"end":return e.stop()}}),e)})))()},store:function(){var t=this;return m(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,!0;case 2:return t.loading=e.sent,e.next=5,axios.post("/ct/ajax/std_raw_material_cost",t.form).then((function(t){})).catch((function(t){console.log(t.response.data)}));case 5:return e.next=7,t.search();case 7:case"end":return e.stop()}}),e)})))()},approveHeaderData:function(){var t=this;return m(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,e.next=3,axios.post("/ct/ajax/std_raw_material_cost/approve",t.form).then((function(e){t.form.status="ยืนยันแล้ว",t.form.approved_status=t.convertStatus(e.data.data),t.$message({showClose:!0,message:"ประมวลผลสำเร็จ",type:"success"})})).catch((function(e){var a=e.response.data.error?e.response.data.error:"ไม่สามารถประมวลผลได้";t.errorMessage(e.response),t.$message({showClose:!0,message:a,type:"error"})})).then((function(){t.loading=!1}));case 3:case"end":return e.stop()}}),e)})))()},saveTableLine:function(){this.store(),this.closeTableLine()},closeTableLine:function(){this.status.tableDataLine=!1},refresh:function(){this.form={}},queryDataTableLine:function(){var t=this,e=[];this.tableDataLine.forEach((function(a){var r={รหัสวัตถุดิบ:a.item_number||"",ชื่อวัตถุดิบ:a.item_desc||"",ขั้นตอน:a.wip_step||"",จำนวนที่ใช้:a.quantity_used||"",หน่วย:a.uom_code||"",ราคาซื้อครั้งสุดท้าย:t.numberWithCommas(parseFloat(a.last_cost).toFixed(9))||"",ราคามาตรฐานต่อหน่วย:t.numberWithCommas(parseFloat(a.unit_std_cost).toFixed(9))||"",ต้นทุนวัตถุดิบรวม:t.numberWithCommas(parseFloat(a.cost_raw_mate).toFixed(9))||""};e.push(r)})),this.exportJson(e)},queryTableDataHeader:function(){var t=this;return m(o().mark((function e(){var a;return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a=[],t.tableDataHeader.forEach((function(e){var r={ศูนย์ต้นทุน:t.form.cost_code||"",ปีงบประมาณ:t.form.period_year||"",กลุ่มผลิตภัณฑ์:e.product_group+e.product_group_name||"",ผลิตภัณฑ์:e.product_item_number||"",ชื่อผลิตภัณฑ์:e.product_item_desc||"","ต้นทุนวัตถุดิบรวม(บาท)":t.numberWithCommas(parseFloat(e.cost_raw_mate).toFixed(9))||"","ต้นทุนวัตถุดิบมาตรฐานต่อ 1 หน่วย":t.numberWithCommas(parseFloat(e.unit_cost_raw_mate).toFixed(9))||"",วันที่เริ่มใช้:e.start_date||"",วันที่สิ้นสุด:e.end_date||""};a.push(r)})),t.exportJson(a);case 3:case"end":return e.stop()}}),e)})))()},exportJson:function(t){var e=t,a=u().utils.json_to_sheet(e),r=u().utils.book_new();u().utils.book_append_sheet(r,a,"ต้นทุนวัตถุดิบมาตรฐาน"),u().writeFile(r,"ต้นทุนวัตถุดิบมาตรฐาน.xlsx")},convertStatus:function(t){switch(t){case"Active":return"อนุมัติ";case"Inactive":return"ไม่อนุมัติ"}},getPlanVersion:function(){var t=this;return m(o().mark((function e(){return o().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.is_create&&axios.get("/ct/ajax/std_raw_material_cost/get_plan_version",{params:{period_year:t.form.period_year}}).then((function(e){t.form.version=e.data})).catch((function(t){})).then((function(){}));case 1:case"end":return e.stop()}}),e)})))()},selectVersion:function(){this.getCostCenters()},DateFormat:function(t,e){var a=t[e.property];return null==a?"":n()(a).format("DD-MM-YYYY")}}};var f=a(93379),v=a.n(f),h=a(22524),b={insert:"head",singleton:!1};v()(h.Z,b);h.Z.locals;var g=a(1559),w={insert:"head",singleton:!1};v()(g.Z,w);g.Z.locals;const y=(0,a(51900).Z)(p,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[a("div",{staticClass:"m-2 "},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-md-2 col-form-label"},[t._v("ปีบัญชี")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"ปีบัญชีงบ"},on:{change:function(e){return t.selectFiscalYear()}},model:{value:t.form.period_year,callback:function(e){t.$set(t.form,"period_year",e)},expression:"form.period_year"}},t._l(t.option.fiscal_year,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label_year,value:t.period_year}})})),1),t._v(" "),t.form_error.fiscal_year?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.fiscal_year.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.fiscal_year.message)+"\n                    ")])]):t._e()],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label"},[t._v("วันที่เริ่มใช้")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[a("el-input",{attrs:{type:"text",placeholder:"วันที่เริ่มใช้",disabled:""},model:{value:this.form.start_date_thai,callback:function(e){t.$set(this.form,"start_date_thai",e)},expression:"this.form.start_date_thai"}}),t._v(" "),t.form_error.date_from?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.date_from.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.date_from.message)+"\n                    ")])]):t._e()],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-md-2 col-form-label"},[t._v("แผนการผลิตครั้งที่")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[t.is_create?a("el-input",{attrs:{placeholder:"แผนการผลิตครั้งที่",type:"text"},model:{value:t.form.version,callback:function(e){t.$set(t.form,"version",e)},expression:"form.version"}}):t._e(),t._v(" "),t.is_create?t._e():a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"แผนการผลิตครั้งที่"},model:{value:t.form.version,callback:function(e){t.$set(t.form,"version",e)},expression:"form.version"}},t._l(t.option.version,(function(t,e){return a("el-option",{key:e,attrs:{label:t.version_no,value:t.version_no}})})),1),t._v(" "),t.form_error.version?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.version.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.version.message)+"\n                    ")])]):t._e()],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label"},[t._v("วันที่สิ้นสุด")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[a("el-input",{attrs:{type:"text",placeholder:"วันที่สิ้นสุด",disabled:""},model:{value:this.form.end_date_thai,callback:function(e){t.$set(this.form,"end_date_thai",e)},expression:"this.form.end_date_thai"}}),t._v(" "),t.form_error.date_to?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.date_to.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.date_to.message)+"\n                    ")])]):t._e()],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-md-2 col-form-label"},[t._v("ศูนย์ต้นทุน")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"ศูนย์ต้นทุน"},on:{change:function(e){return t.selectCostCenter()}},model:{value:t.form.cost_code,callback:function(e){t.$set(t.form,"cost_code",e)},expression:"form.cost_code"}},t._l(t.option.cost_center,(function(t,e){return a("el-option",{key:e,attrs:{label:t.cost_code+" - "+t.description,value:t.cost_code}})})),1),t._v(" "),t.form_error.code?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.code.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.code.message)+"\n                    ")])]):t._e()],1),t._v(" "),a("label",{staticClass:"col-md-2 col-form-label"},[t._v("สถานะ")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[a("el-input",{staticClass:"w-100",attrs:{placeholder:"สถานะ",disabled:""},model:{value:t.form.approved_status,callback:function(e){t.$set(t.form,"approved_status",e)},expression:"form.approved_status"}}),t._v(" "),t.form_error.status?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.status.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.status.message)+"\n                    ")])]):t._e()],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-md-2 col-form-label"},[t._v("หน่วยนับต่อศูนย์ต้นทุน")]),t._v(" "),a("div",{staticClass:"col-md-4 flex-wrap"},[a("el-input",{attrs:{placeholder:"หน่วยนับต่อศูนย์ต้นทุน",disabled:""},model:{value:t.unitPerCostCenter,callback:function(e){t.unitPerCostCenter=e},expression:"unitPerCostCenter"}}),t._v(" "),t.form_error.qty_per_cost_center?a("div",{staticClass:"error-message"},[a("strong",{staticClass:"font-bold"},[t._v(t._s(t.form_error.qty_per_cost_center.title))]),t._v(" "),a("span",{staticClass:"block sm:inline"},[t._v("\n                        "+t._s(t.form_error.qty_per_cost_center.message)+"\n                    ")])]):t._e()],1)]),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12 text-right mt-2"},[t.is_create?t._e():a("el-button",{staticClass:"btn-info mr-2 ",attrs:{type:"primary",size:"small"},on:{click:function(e){return t.search()}}},[t._v("\n                    ค้นหา\n                ")]),t._v(" "),t.status.tableDataLine?a("el-button",{staticClass:"btn-info mr-2",attrs:{type:"primary",size:"small"},on:{click:t.queryDataTableLine}},[t._v("\n                    EXPORT\n                ")]):t._e(),t._v(" "),t.status.tableData&&!t.status.tableDataLine?a("el-button",{staticClass:"btn-info mr-2",attrs:{type:"primary",size:"small"},on:{click:t.queryTableDataHeader}},[t._v("\n                    EXPORT\n                ")]):t._e(),t._v(" "),t.is_create?a("el-button",{staticClass:"btn-primary mr-2",attrs:{disabled:t.disableStore,type:"primary",size:"small"},on:{click:function(e){return t.store()}}},[t._v("\n                    ดึงต้นทุนวัตถุดิบ\n                ")]):t._e(),t._v(" "),t.status.tableData?a("el-button",{staticClass:"btn-success",attrs:{type:"success",size:"small"},on:{click:t.approveHeaderData}},[t._v("\n                    ยืนยันต้นทุนวัตถุดิบ\n                ")]):t._e()],1)])]),t._v(" "),t.status.tableData?a("div",{staticClass:"form-group row"},[a("div",{staticClass:"col-md-12 mt-2 flex-wrap"},[a("div",{directives:[{name:"show",rawName:"v-show",value:!t.status.tableDataLine,expression:"!status.tableDataLine"}]},[a("div",{staticClass:"col-lg-12 mt-2"},[a("el-table",{staticStyle:{width:"100%","font-size":"13px"},attrs:{border:"",data:t.tableDataHeader}},[a("el-table-column",{attrs:{label:"กลุ่มผลิตภัณฑ์","header-align":"center",width:"180"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                                "+t._s(e.row.product_group)+"\n                                "+t._s(e.row.product_group_name)+"\n                            ")]}}],null,!1,1256899546)}),t._v(" "),a("el-table-column",{attrs:{prop:"product_item_number",label:"ผลิตภัณฑ์","header-align":"center",width:"130"}}),t._v(" "),a("el-table-column",{attrs:{prop:"product_item_desc",label:"ชื่อผลิตภัณฑ์","header-align":"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"cost_raw_mate",label:"ต้นทุนวัตถุดิบรวม (บาท)",align:"right",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                                "+t._s(0!=e.row.cost_raw_mate?t.numberWithCommas(parseFloat(e.row.cost_raw_mate).toFixed(9)):e.row.cost_raw_mate)+"\n                            ")]}}],null,!1,1485172487)}),t._v(" "),a("el-table-column",{attrs:{prop:"unit_cost_raw_mate",label:"ต้นทุนวัตถุดิบต่อ 1 หน่วย",align:"right",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                                "+t._s(0!=e.row.unit_cost_raw_mate?t.numberWithCommas(parseFloat(e.row.unit_cost_raw_mate).toFixed(9)):e.row.unit_cost_raw_mate)+"\n                            ")]}}],null,!1,1522186356)}),t._v(" "),a("el-table-column",{attrs:{prop:"start_date",label:"วันที่เริ่มใช้",align:"center",formatter:t.DateFormat,width:"120"}}),t._v(" "),a("el-table-column",{attrs:{prop:"end_date",align:"center",label:"วันที่สิ้นสุด",formatter:t.DateFormat,width:"120"}}),t._v(" "),a("el-table-column",{attrs:{label:"รายละเอียดวัตถุดิบ",align:"center",width:"140"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{staticClass:"btn btn-info",attrs:{type:"success",size:"small"},on:{click:function(a){return t.getTableDataLine(e.row)}}},[t._v("\n                                    รายละเอียด\n                                ")])]}}],null,!1,3333377470)})],1)],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:t.status.tableDataLine,expression:"status.tableDataLine"}]},[a("div",{staticClass:"my-2"},[a("div",[a("span",{staticClass:"font-bold"},[t._v("กลุ่มผลิตภัณฑ์ :")]),t._v("\n                        "+t._s(t.headLine.productGroup)+"\n                    ")]),t._v(" "),a("div",[a("span",{staticClass:"font-bold"},[t._v("ผลิตภัณฑ์ :")]),t._v("\n                        "+t._s(t.headLine.productGroupDetail)+"\n                    ")])]),t._v(" "),a("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.tableDataLine,"summary-method":t.getSummaries,"show-summary":""}},[a("el-table-column",{attrs:{prop:"item_number",label:"รหัสวัตถุดิบ",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"item_desc",label:"ชื่อวัตถุดิบ",align:"left","header-align":"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"wip_step",label:"ขั้นตอน",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"quantity_used",label:"จำนวนที่ใช้",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                            "+t._s(0!=e.row.quantity_used?t.numberWithCommas(parseFloat(e.row.quantity_used).toFixed(9)):e.row.quantity_used)+"\n                        ")]}}],null,!1,3637904950)}),t._v(" "),a("el-table-column",{attrs:{prop:"uom_code",label:"หน่วย",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"last_cost",label:"ราคาซื้อครั้งสุดท้าย",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                            "+t._s(0!=e.row.last_cost?t.numberWithCommas(parseFloat(e.row.last_cost).toFixed(9)):e.row.last_cost)+"\n                        ")]}}],null,!1,2920870955)}),t._v(" "),a("el-table-column",{attrs:{prop:"unit_std_cost",label:"ราคามาตรฐานต่อหน่วย",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                            "+t._s(0!=e.row.unit_std_cost?t.numberWithCommas(parseFloat(e.row.unit_std_cost).toFixed(9)):e.row.unit_std_cost)+"\n                        ")]}}],null,!1,3710508251)}),t._v(" "),a("el-table-column",{attrs:{prop:"cost_raw_mate",label:"ต้นทุนวัตถุดิบรวม",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                            "+t._s(0!=e.row.cost_raw_mate?t.numberWithCommas(parseFloat(e.row.cost_raw_mate).toFixed(9)):e.row.cost_raw_mate)+"\n                        ")]}}],null,!1,1892111367)})],1),t._v(" "),a("div",{staticClass:"col-md-12 text-right mt-4 px-0"},[a("el-button",{staticClass:"btn-danger",attrs:{type:"danger"},nativeOn:{click:function(e){return e.preventDefault(),t.closeTableLine()}}},[t._v("\n                        ปิด\n                    ")])],1)],1)])]):t._e()])}),[],!1,null,"6a2ce0e2",null).exports}}]);