(self.webpackChunk=self.webpackChunk||[]).push([[6779],{51546:(t,e,a)=>{"use strict";function n(t){return new Promise((function(e){swal({title:t,type:"warning",dangerMode:!0,showCancelButton:!0,closeOnCancel:!0,cancelButtonText:"ยกเลิก",showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ยืนยัน"},(function(t){e(t)}))}))}function i(){return new Promise((function(t){swal({title:"\nคุณแน่ใจไหม?",text:"มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก คุณต้องการดำเนินการต่อหรือไม่",type:"warning",dangerMode:!0,showCancelButton:!0,closeOnCancel:!0,cancelButtonText:"ยกเลิก",showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ดำเนินการต่อ",allowClickOutside:!0,closeOnClickOutside:!0},(function(e){t(e)}))}))}function s(t){var e='<div style="text-align:left;">ข้อมูลที่คุณใส่ไม่ถูกต้องหรือไม่ครบถ้วน กรุณาตรวจสอบข้อมูลและลองใหม่อีกครั้ง<br/><br/></div>';return e+='<div style="text-align:left;color:red">',e+="<ul>",t.forEach((function(t){e+="<li>".concat(t,"<br/></li>")})),e+="</ul>",e+="</div>",new Promise((function(t){swal({title:"\nเกิดข้อผิดพลาด",text:e,type:"error",html:!0,showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ตกลง"},(function(e){t(e)}))}))}function o(){return console.debug("showLoadingDialog"),new Promise((function(t){swal({title:'\n                    <div class="sk-spinner sk-spinner-wave mb-4">\n                        <div class="sk-rect1"></div>\n                        <div class="sk-rect2"></div>\n                        <div class="sk-rect3"></div>\n                        <div class="sk-rect4"></div>\n                        <div class="sk-rect5"></div>\n                    </div>\n                    กำลังดำเนินการ\n                    ',html:!0,showConfirmButton:!1,closeOnConfirm:!1},(function(e){t(e)}))}))}function l(){return new Promise((function(t){swal({title:"\nสำเร็จ",text:"บันทึกข้อมูลเรียบร้อย",type:"success",dangerMode:!1,showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ปิด"},(function(e){t(e)}))}))}function r(){return new Promise((function(t){swal({title:"\nมีข้อผิดพลาด",text:"มีข้อผิดพลาดเกิดขึ้น ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง\n",type:"error",showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ปิด"},(function(e){t(e)}))}))}function c(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง\n";return new Promise((function(e){swal({title:"\nเกิดข้อผิดพลาด",text:t,type:"error",showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ปิด"},(function(t){e(t)}))}))}function d(t){return new Promise((function(e){swal({title:"\nคุณต้องการลบข้อมูลที่ถูกเลือกทั้งหมด ".concat(t," แถวใช่หรือไม่?"),type:"warning",dangerMode:!0,showCancelButton:!0,closeOnCancel:!0,cancelButtonText:"ยกเลิก",showConfirmButton:!0,closeOnConfirm:!0,confirmButtonText:"ยืนยัน"},(function(t){e(t)}))}))}a.d(e,{Y6:()=>n,HR:()=>i,BT:()=>s,ZD:()=>o,xK:()=>l,YM:()=>r,qV:()=>c,gC:()=>d})},70510:(t,e,a)=>{"use strict";a.d(e,{Z:()=>s});var n=a(23645),i=a.n(n)()((function(t){return t[1]}));i.push([t.id,"td[data-v-53b986b6],th[data-v-53b986b6]{vertical-align:middle!important;text-align:center}input.form-control.input-field[data-v-53b986b6]{border:0}.mx-datepicker[data-v-53b986b6]{width:inherit!important}.col-readonly[data-v-53b986b6]{background:rgba(233,236,239,.25882352941176473)!important}",""]);const s=i},76779:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>u});var n=a(51546);function i(t){return function(t){if(Array.isArray(t))return s(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return s(t,e);var a=Object.prototype.toString.call(t).slice(8,-1);"Object"===a&&t.constructor&&(a=t.constructor.name);if("Map"===a||"Set"===a)return Array.from(t);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return s(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function s(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,n=new Array(e);a<e;a++)n[a]=t[a];return n}const o={props:["lookups","items","dep_code","req_by","def_period_year"],mounted:function(){},data:function(){return{current_date:this.getCurrentDate(),header_id:"",thai_year:this.def_period_year,thai_month:"",biweekly:"",biweekly_id:"",req_date:this.getCurrentDate(),item_code:"",start_date:"",end_date:"",min_date:"",max_date:"",send_date:this.getCurrentDate(),lines:[],isCheckedAll:!1,checked:[]}},computed:{maxSelectedDate:function(){var t=new Date,e=new Date;return e.setDate(t.getDate()+365),e.getFullYear()+543+"-"+(e.getMonth()+1)+"-"+e.getDate()},checkDisableBtn:function(){return!(this.thai_year&&this.thai_month&&this.biweekly&&this.item_code)},yearLists:function(){return i(new Set(Array.from(this.lookups,(function(t){return t.thai_year}))))},monthLists:function(){var t=this,e=this.lookups.filter((function(e){return e.thai_year==t.thai_year}));return i(new Set(Array.from(e,(function(t){return t.thai_month}))))},biweeklyLists:function(){var t=this,e=this.lookups.filter((function(e){return e.thai_year==t.thai_year&&e.thai_month==t.thai_month}));return i(new Set(Array.from(e,(function(t){return t.biweekly}))))}},methods:{onClickCreate:function(){this.thai_year=this.def_period_year,this.thai_month="",this.biweekly="",this.biweekly_id="",this.req_date=this.getCurrentDate(),this.item_code="",this.start_date="",this.end_date="",this.send_date=this.getCurrentDate(),this.lines=""},onClickSave:function(){var t=this,e={biweekly_id:this.biweekly_id,department_code:this.dep_code,request_date:this.convertFormatDate(this.req_date),tobacco_group:this.item_code,product_date_from:this.convertFormatDate(this.start_date),product_date_to:this.convertFormatDate(this.end_date),request_by:this.req_by,send_date:this.convertFormatDate(this.send_date)};(0,n.ZD)(),axios.post("/api/pm/0019/",e).then((function(e){200==e.status&&(console.log(e),(0,n.xK)(),t.lines=e.data.lines,t.header_id=e.data.header.bi_request_header_id)})).catch((function(t){console.log(t)}))},getCurrentDate:function(){return(new Date).getFullYear()+543+"-"+((new Date).getMonth()+1)+"-"+(new Date).getDate()},convertToThaiDate:function(t){return parseInt(t.split("-")[0])+543+"-"+t.split("-")[1]+"-"+t.split("-")[2]},convertFormatDate:function(t){return new Date(t).getFullYear()-543+"-"+(new Date(t).getMonth()+1)+"-"+new Date(t).getDate()},onChangeYear:function(){},onChangeMonth:function(){},onChangeBiweekly:function(){var t=this,e=this.lookups.filter((function(e){return e.thai_year==t.thai_year&&e.thai_month==t.thai_month&&e.biweekly==t.biweekly}))[0];this.biweekly_id=e.biweekly_id,this.start_date=this.convertToThaiDate(e.start_date),this.min_date=this.convertToThaiDate(e.start_date),this.end_date=this.convertToThaiDate(e.end_date),this.max_date=this.convertToThaiDate(e.end_date)},validate:function(){var t=this,e=[];return this.checked.length>0&&this.checked.forEach((function(a){t.lines.filter((function(t){return t.bi_request_line_id==a}))[0].request_qty||e.push("ปริมาณเบิก")})),!(e.length>0)||((0,n.BT)(i(new Set(e))),!1)},onClickSaveLines:function(){if(this.validate()){var t={lines:this.lines,checked:this.checked};(0,n.ZD)(),axios.put("/api/pm/0019/"+this.header_id,t).then((function(t){200==t.status&&(swal.close(),t.data.req_header_id.length>0?window.location.href="/pm/0005/"+t.data.req_header_id[0]:(0,n.BT)(t.data.errors))})).catch((function(t){swal.close(),console.log(t)}))}},checkedAll:function(){var t=this;this.checked=[],this.isCheckedAll=!this.isCheckedAll,this.isCheckedAll&&this.lines.forEach((function(e){e.request_qty&&t.checked.push(e.bi_request_line_id)}))},updateChecked:function(){this.isCheckedAll=this.checked.length===this.lines.length}}};var l=a(93379),r=a.n(l),c=a(70510),d={insert:"head",singleton:!1};r()(c.Z,d);c.Z.locals;const u=(0,a(51900).Z)(o,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-12"},[a("div",{staticClass:"float-right mb-3"},[a("button",{staticClass:"btn btn-success",on:{click:t.onClickCreate}},[a("i",{staticClass:"fa fa-plus"}),t._v(" สร้าง")]),t._v(" "),a("button",{staticClass:"btn btn-primary",attrs:{disabled:t.checkDisableBtn}},[t._v("\n            แผนประจำปักษ์")]),t._v(" "),a("button",{staticClass:"btn btn-primary",attrs:{disabled:t.checkDisableBtn},on:{click:function(e){return e.preventDefault(),t.onClickSave(e)}}},[a("i",{staticClass:"fa fa-save"}),t._v(" ประมาณการเบิก")])]),t._v(" "),a("div",{staticClass:"ibox"},[t._m(0),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6 b-r"},[a("div",{staticClass:"form-group row"},[t._m(1),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"เลือกปี"},on:{change:t.onChangeYear},model:{value:t.thai_year,callback:function(e){t.thai_year=e},expression:"thai_year"}},t._l(t.yearLists,(function(t){return a("el-option",{key:t,attrs:{label:t,value:t}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(2),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"เลือกเดือน"},on:{change:t.onChangeMonth},model:{value:t.thai_month,callback:function(e){t.thai_month=e},expression:"thai_month"}},t._l(t.monthLists,(function(t){return a("el-option",{key:t,attrs:{label:t,value:t}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(3),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"เลือกปักษ์"},on:{change:t.onChangeBiweekly},model:{value:t.biweekly,callback:function(e){t.biweekly=e},expression:"biweekly"}},t._l(t.biweeklyLists,(function(t){return a("el-option",{key:t,attrs:{label:t,value:t}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(4),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("datepicker-th",{staticClass:"form-control",attrs:{placeholder:"เลือกวันที่ขอเบิก","not-before-date":t.current_date,"not-after-date":t.maxSelectedDate,value:t.req_date,format:"YYYY-MM-DD"},on:{dateWasSelected:function(e){return t.req_date=e}}})],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(5),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("el-select",{attrs:{filterable:"",remote:"",placeholder:"เลือกประเภทวัตถุดิบ"},model:{value:t.item_code,callback:function(e){t.item_code=e},expression:"item_code"}},t._l(t.items,(function(t){return a("el-option",{key:t.item_classification_code,attrs:{label:t.item_classification,value:t.item_classification_code}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(6),t._v(" "),a("label",{staticClass:"col-lg-1 col-form-label"},[t._v("ตั้งแต่")]),t._v(" "),a("div",{staticClass:"col-lg-4"},[a("datepicker-th",{staticClass:"form-control",attrs:{placeholder:"เลือกวันที่","not-before-date":t.min_date,"not-after-date":t.max_date,value:t.start_date,format:"YYYY-MM-DD"},on:{dateWasSelected:function(e){return t.start_date=e}}})],1),t._v(" "),a("label",{staticClass:"col-lg-1 col-form-label"},[t._v("ถึง")]),t._v(" "),a("div",{staticClass:"col-lg-4"},[a("datepicker-th",{staticClass:"form-control",attrs:{placeholder:"เลือกวันที่","not-before-date":t.min_date,"not-after-date":t.max_date,value:t.end_date,format:"YYYY-MM-DD"},on:{dateWasSelected:function(e){return t.end_date=e}}})],1)])]),t._v(" "),a("div",{staticClass:"col-lg-6"},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("หน่วยงานที่ขอเบิก:")]),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.dep_code,expression:"dep_code"}],staticClass:"form-control",attrs:{type:"text",disabled:""},domProps:{value:t.dep_code},on:{input:function(e){e.target.composing||(t.dep_code=e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("ผู้ขอเบิก:")]),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.req_by,expression:"req_by"}],staticClass:"form-control",attrs:{type:"text",disabled:""},domProps:{value:t.req_by},on:{input:function(e){e.target.composing||(t.req_by=e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[t._m(7),t._v(" "),a("div",{staticClass:"col-lg-8"},[a("datepicker-th",{staticClass:"form-control",attrs:{placeholder:"เลือกวันที่นำส่ง ยสท.","not-before-date":t.req_date,"not-after-date":t.maxSelectedDate,value:t.send_date,format:"YYYY-MM-DD"},on:{dateWasSelected:function(e){return t.send_date=e}}})],1)])])])])]),t._v(" "),a("div",{staticClass:"float-right mb-3"},[a("button",{staticClass:"btn btn-w-m btn-success",attrs:{type:"button",disabled:0==t.checked.length},on:{click:function(e){return e.preventDefault(),t.onClickSaveLines(e)}}},[a("i",{staticClass:"fa fa-plus"}),t._v(" สร้างรายการขอเบิก")])]),t._v(" "),a("div",{staticClass:"ibox"},[t._m(8),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-bordered"},[a("thead",[a("tr",[a("th",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.isCheckedAll,expression:"isCheckedAll"}],staticClass:"align-middle",attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.isCheckedAll)?t._i(t.isCheckedAll,null)>-1:t.isCheckedAll},on:{click:t.checkedAll,change:function(e){var a=t.isCheckedAll,n=e.target,i=!!n.checked;if(Array.isArray(a)){var s=t._i(a,null);n.checked?s<0&&(t.isCheckedAll=a.concat([null])):s>-1&&(t.isCheckedAll=a.slice(0,s).concat(a.slice(s+1)))}else t.isCheckedAll=i}}})])]),t._v(" "),a("th",[t._v("กลุ่มใบยา")]),t._v(" "),a("th",[t._v("รหัสวัตถุดิบ")]),t._v(" "),a("th",[t._v("รายละเอียด")]),t._v(" "),a("th",[t._v("ปริมาณที่ต้องใช้+สูญเสีย")]),t._v(" "),a("th",[t._v("หน่วยนับ")]),t._v(" "),a("th",[t._v("ปริมาณคงคลังฝ่ายจัดหา")]),t._v(" "),a("th",[t._v("ปริมาณที่คงคลังฝ่ายผลิต")]),t._v(" "),a("th",[t._v("หน่วยนับ2")]),t._v(" "),a("th",[t._v("ปริมาณจัดเก็บต่ำสุด")]),t._v(" "),a("th",[t._v("ปริมาณจัดเก็บสูงสุด")]),t._v(" "),a("th",[t._v("ปริมาณเต็มแป้น")]),t._v(" "),a("th",[t._v("ปริมาณเบิก")]),t._v(" "),a("th",[t._v("หน่วยเบิก")])])]),t._v(" "),a("tbody",t._l(t.lines,(function(e,n){return a("tr",{key:n},[a("td",[a("label",[a("input",{directives:[{name:"model",rawName:"v-model",value:t.checked,expression:"checked"}],staticClass:"align-middle",attrs:{type:"checkbox",disabled:!e.request_qty},domProps:{value:e.bi_request_line_id,checked:Array.isArray(t.checked)?t._i(t.checked,e.bi_request_line_id)>-1:t.checked},on:{change:[function(a){var n=t.checked,i=a.target,s=!!i.checked;if(Array.isArray(n)){var o=e.bi_request_line_id,l=t._i(n,o);i.checked?l<0&&(t.checked=n.concat([o])):l>-1&&(t.checked=n.slice(0,l).concat(n.slice(l+1)))}else t.checked=s},t.updateChecked]}})])]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.item_type))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.item_code))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.description))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.total_qty))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.uom))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.request_onhand))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.product_onhand))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.uom2))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.min_qty))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.max_qty))]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.machine_max))]),t._v(" "),a("td",[a("input",{directives:[{name:"model",rawName:"v-model",value:e.request_qty,expression:"line.request_qty"}],staticClass:"form-control input-field",attrs:{type:"number",min:"0"},domProps:{value:e.request_qty},on:{input:function(a){a.target.composing||t.$set(e,"request_qty",a.target.value)}}})]),t._v(" "),a("td",{staticClass:"col-readonly"},[t._v(t._s(e.request_uom))])])})),0)])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox-title"},[a("h5",[t._v("ขอเบิกวัตถุดิบตามแผนรายปักษ์")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("แผนการผลิตประจำปี: "),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("แผนการผลิตประจำเดือน: "),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("ปักษ์ที่: "),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("วันที่ขอเบิก: "),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("ประเภทวัตถุดิบ: "),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-2 col-form-label"},[t._v("วันที่ผลิต"),a("span",{staticStyle:{color:"red"}},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",{staticClass:"col-lg-4 col-form-label"},[t._v("วันที่นำส่ง ยสท."),a("span",{staticStyle:{color:"red"}},[t._v("*")]),t._v(":")])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox-title"},[a("h5",[t._v("รายการวัตถุดิบ")])])}],!1,null,"53b986b6",null).exports}}]);