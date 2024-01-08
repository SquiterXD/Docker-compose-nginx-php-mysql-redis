(self.webpackChunk=self.webpackChunk||[]).push([[547],{20547:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>_});var i=a(87757),s=a.n(i),n=a(23570),r=a.n(n),o=a(30381),d=a.n(o);function l(e,t,a,i,s,n,r){try{var o=e[n](r),d=o.value}catch(e){return void a(e)}o.done?t(d):Promise.resolve(d).then(i,s)}const c={props:["currencies","items","uoms","defaultValue","old","urlSave","urlReset","btnTrans","itemAlls"],data:function(){return{csrf:document.querySelector('meta[name="csrf-token"]').getAttribute("content"),nameHeader:this.old.name?this.old.name:this.defaultValue?this.defaultValue.name:"",description:this.old.description?this.old.description:this.defaultValue?this.defaultValue.description:"",currency_code:this.old.currency?this.old.currency:this.defaultValue?this.defaultValue.currency:"",effective_dates_from:this.old.effective_dates_from?this.old.effective_dates_from:this.defaultValue?this.defaultValue.effective_dates_from:"",effective_dates_to:this.old.effective_dates_to?this.old.effective_dates_to:this.defaultValue?this.defaultValue.effective_dates_to:"",comments:this.old.comments?this.old.comments:this.defaultValue?this.defaultValue.comments:"",active_flag:!!this.old.active_flag||(!this.defaultValue||("Y"==this.defaultValue.active_flag||"")),lines:[],disabledData:!!this.defaultValue&&!!this.defaultValue.name}},mounted:function(){var e=this;this.defaultValue&&this.defaultValue.list_lines?this.defaultValue.list_lines.forEach((function(t){var a=e.itemAlls.find((function(e){return e.item_id==t.product_value})),i=a?a.item_code+" : "+a.ecom_item_description:"";e.lines.push({id:t.list_line_id,lineId:"",item_id:t.product_value,uom_code:t.uom,price:t.value.replace(/\B(?=(\d{3})+(?!\d))/g,","),start_date:t.start_date,end_date:t.end_date,status:"update",disabledRow:!0,item_desc:i})})):this.addLine()},methods:{addLine:function(){var e=new Date;console.log("xxxxx ---\x3e "+e);d()(e).format("DDMMyyyy"),String(e.getHours()),String(e.getMinutes()),String(e.getSeconds());this.lines.push({id:r()(),lineId:"",item_id:"",uom_code:"",price:"",start_date:"",end_date:"",status:"new",disabledRow:!1,item_desc:""})},removeRow:function(e){this.lines.splice(e,1)},checkDateHeader:function(e,t){this.effective_dates_from&&e.start_date&&d()(String(e.start_date)).format("yyyy-MM-DD")<d()(String(this.effective_dates_from)).format("yyyy-MM-DD")&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header"}),e.start_date=""),this.effective_dates_to&&(e.start_date&&d()(String(e.start_date)).format("yyyy-MM-DD")>d()(String(this.effective_dates_to)).format("yyyy-MM-DD")&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header"}),e.start_date=""),e.end_date&&d()(String(e.end_date)).format("yyyy-MM-DD")>d()(String(this.effective_dates_to)).format("yyyy-MM-DD")&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header"}),e.end_date=""))},checkDateLine:function(e,t){var a=this;if(e.item_id||(e.price="",e.start_date="",e.end_date=""),t>0)this.lines.find((function(t){t.id!=e.id&&e.item_id==t.item_id&&(t.end_date?(e.start_date&&(console.log("has start date"),d()(String(e.start_date)).format("yyyy-MM-DD")<=d()(String(t.end_date)).format("yyyy-MM-DD")&&(a.$notify.error({title:"มีข้อผิดพลาด",message:"ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้"}),e.start_date="",e.end_date="")),e.end_date&&(console.log("has end date"),e.end_date<=t.end_date&&(a.$notify.error({title:"มีข้อผิดพลาด",message:"ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้"}),e.start_date="",e.end_date="")),e.start_date&&e.end_date&&e.end_date<e.start_date&&(a.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น"}),e.start_date="",e.end_date="")):(a.$notify.error({title:"มีข้อผิดพลาด",message:"ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้"}),e.item_id="",e.uom_code="",e.price="",e.start_date="",e.end_date=""))}));else e.end_date&&e.end_date<e.start_date&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น"}),e.end_date="")},getUom:function(e,t){e.item_id?this.selectedData=this.items.find((function(t){t.item_id==e.item_id&&(e.uom_code=t.uom)})):e.uom_code=""},checkStartDate:function(e){""==e.start_date&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"โปรดเลือกวันที่เริ่มต้นใช้งาน"}),e.end_date="")},onlyNumeric:function(e){e.price&&(e.price=e.price.replace(/[^0-9 .]/g,""),e.price=e.price.replace(/\B(?=(\d{3})+(?!\d))/g,","))},validateHeaderDate:function(){var e=this;this.effective_dates_from&&(this.selectedData=this.lines.find((function(t){return t.start_date?d()(String(t.start_date)).format("yyyy-MM-DD")<d()(String(e.effective_dates_from)).format("yyyy-MM-DD"):t.end_date?d()(String(t.end_date)).format("yyyy-MM-DD")<d()(String(e.effective_dates_from)).format("yyyy-MM-DD"):void 0})),this.selectedData&&(this.effective_dates_from="",this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่ใช้งานและวันที่สิ้นสุด ระดับ Header ต้องอยู่ในช่วงของวันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line"}))),this.effective_dates_to&&(this.selectedData=this.lines.find((function(t){return t.start_date?d()(String(t.start_date)).format("yyyy-MM-DD")>d()(String(e.effective_dates_to)).format("yyyy-MM-DD"):t.end_date?d()(String(t.end_date)).format("yyyy-MM-DD")>d()(String(e.effective_dates_to)).format("yyyy-MM-DD"):void 0})),this.selectedData&&(this.effective_dates_to="",this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่ใช้งานและวันที่สิ้นสุด ระดับ Header ต้องอยู่ในช่วงของวันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line"})))},checkForm:function(e){var t,a=this;return(t=s().mark((function t(){var i;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:console.log("checkForm"),(i=$("#submitForm")).serialize(),a.errors=[],a.nameHeader||(a.errors.push("ชื่อรายการราคาสินค้า"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:a.errors,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1})),a.lines.length||(a.errors.push("ผลิตภัณฑ์, ราคาต่อหน่วย, วันที่เริ่มต้นใช้งาน"),console.log("check validate line <---\x3e "+a.lines.length),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:a.errors,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1})),a.lines.length>0&&a.lines.forEach((function(e){e.item_id||(a.errors.push("ผลิตภัณฑ์"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:a.errors,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1})),e.price||(a.errors.push("ราคาต่อหน่วย"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:a.errors,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1})),e.start_date||(a.errors.push("วันที่เริ่มต้นใช้งาน"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:a.errors,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}))})),a.errors.length||(console.log("form submit"),i.submit()),e.preventDefault();case 9:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,s){var n=t.apply(e,a);function r(e){l(n,i,s,r,o,"next",e)}function o(e){l(n,i,s,r,o,"throw",e)}r(void 0)}))})()}}};const _=(0,a(51900).Z)(c,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("form",{attrs:{id:"submitForm",action:e.urlSave,method:"post"},on:{submit:function(t){return t.preventDefault(),e.checkForm(t)}}},[a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:e.csrf}}),e._v(" "),this.defaultValue?a("div",[a("input",{attrs:{type:"hidden",name:"_method",value:"PUT"}})]):e._e(),e._v(" "),a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal form-inline"},[e._m(0),e._v(" "),a("el-input",{attrs:{name:"nameHeader"},model:{value:e.nameHeader,callback:function(t){e.nameHeader=t},expression:"nameHeader"}})],1)]),e._v(" "),a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal form-inline"},[a("dt",[e._v("\n              รายละเอียด\n          ")]),e._v(" "),a("el-input",{attrs:{name:"description"},model:{value:e.description,callback:function(t){e.description=t},expression:"description"}})],1)]),e._v(" "),a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal form-inline"},[a("dt",[e._v("\n            สกุลเงิน \n          ")]),e._v(" "),a("input",{attrs:{type:"hidden",name:"currency_code",autocomplete:"off"},domProps:{value:e.currency_code}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":""},model:{value:e.currency_code,callback:function(t){e.currency_code=t},expression:"currency_code"}},e._l(e.currencies,(function(e){return a("el-option",{key:e.currency_code,attrs:{label:e.currency_code+" : "+e.name,value:e.currency_code}})})),1)],1)])]),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal form-inline"},[a("dt",[e._v("\n            วันที่ใช้งาน\n          ")]),e._v(" "),a("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date",placeholder:"วันที่เริ่มต้น",name:"effective_dates_from",format:"dd-MM-yyyy"},on:{change:function(t){return e.validateHeaderDate()}},model:{value:e.effective_dates_from,callback:function(t){e.effective_dates_from=t},expression:"effective_dates_from"}})],1)]),e._v(" "),a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal form-inline"},[a("dt",[e._v("\n                วันที่สิ้นสุด\n            ")]),e._v(" "),a("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date",placeholder:"วันที่สิ้นสุด",name:"effective_dates_to",format:"dd-MM-yyyy"},on:{change:function(t){return e.validateHeaderDate()}},model:{value:e.effective_dates_to,callback:function(t){e.effective_dates_to=t},expression:"effective_dates_to"}})],1)]),e._v(" "),a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal form-inline"},[a("dt",[e._v("\n                หมายเหตุรายการ\n            ")]),e._v(" "),a("el-input",{attrs:{name:"comments"},model:{value:e.comments,callback:function(t){e.comments=t},expression:"comments"}})],1)])]),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[a("dl",{staticClass:"dl-horizontal"},[a("dt",[e._v("\n                Active\n              ")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.active_flag,expression:"active_flag"}],attrs:{type:"checkbox",name:"active_flag"},domProps:{checked:Array.isArray(e.active_flag)?e._i(e.active_flag,null)>-1:e.active_flag},on:{change:function(t){var a=e.active_flag,i=t.target,s=!!i.checked;if(Array.isArray(a)){var n=e._i(a,null);i.checked?n<0&&(e.active_flag=a.concat([null])):n>-1&&(e.active_flag=a.slice(0,n).concat(a.slice(n+1)))}else e.active_flag=s}}})])])]),e._v(" "),a("div",{staticClass:"text-right"},[a("button",{staticClass:"btn btn-sm btn-success",attrs:{type:"submit"},on:{click:function(t){return t.preventDefault(),e.addLine(t)}}},[a("i",{staticClass:"fa fa-plus"}),e._v(" เพิ่ม ")])]),e._v(" "),a("table",{staticClass:"table table-responsive-sm"},[e._m(1),e._v(" "),a("tbody",e._l(e.lines,(function(t,i){return a("tr",[a("td",[e._v(" "+e._s(i+1)+" ")]),e._v(" "),a("td",[a("input",{attrs:{type:"hidden",name:"listLine["+t.id+"][status]",autocomplete:"off"},domProps:{value:t.status}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"listLine["+t.id+"][item_id]",autocomplete:"off"},domProps:{value:t.item_id}}),e._v(" "),t.disabledRow?[a("el-input",{staticClass:"w-100",attrs:{type:"text",value:t.item_desc,autocomplete:"off",disabled:""}})]:[a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",disabled:t.disabledRow},on:{change:function(a){e.getUom(t,i),e.checkDateLine(t,i)}},model:{value:t.item_id,callback:function(a){e.$set(t,"item_id",a)},expression:"row.item_id"}},e._l(e.items,(function(e){return a("el-option",{key:e.item_id,attrs:{label:e.item_code+" : "+e.ecom_item_description,value:e.item_id}})})),1)]],2),e._v(" "),a("td",[a("input",{attrs:{type:"hidden",name:"listLine["+t.id+"][uom_code]",autocomplete:"off"},domProps:{value:t.uom_code}}),e._v(" "),a("el-select",{attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",disabled:t.disabledRow},model:{value:t.uom_code,callback:function(a){e.$set(t,"uom_code",a)},expression:"row.uom_code"}},e._l(e.uoms,(function(e){return a("el-option",{key:e.uom_code,attrs:{label:e.uom_code+" : "+e.description,value:e.uom_code}})})),1)],1),e._v(" "),a("td",[a("el-input",{attrs:{name:"listLine["+t.id+"][price]"},on:{input:function(a){return e.onlyNumeric(t)}},model:{value:t.price,callback:function(a){e.$set(t,"price",a)},expression:"row.price"}})],1),e._v(" "),a("td",[a("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date",placeholder:"วันที่เริ่มต้น",name:"listLine["+t.id+"][start_date]",format:"dd-MM-yyyy"},on:{change:function(a){e.checkDateLine(t,i),e.checkDateHeader(t,i)}},model:{value:t.start_date,callback:function(a){e.$set(t,"start_date",a)},expression:"row.start_date"}})],1),e._v(" "),a("td",[a("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date",placeholder:"วันที่สิ้นสุด",name:"listLine["+t.id+"][end_date]",format:"dd-MM-yyyy"},on:{change:function(a){e.checkDateLine(t,i),e.checkDateHeader(t,i)}},model:{value:t.end_date,callback:function(a){e.$set(t,"end_date",a)},expression:"row.end_date"}})],1),e._v(" "),a("td",[t.disabledRow?e._e():a("div",[a("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(t){return t.preventDefault(),e.removeRow(i)}}},[e._v("\n                X\n              ")])])])])})),0)]),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 text-right"},[a("button",{class:e.btnTrans.save.class+" btn-sm",attrs:{type:"submit"}},[a("i",{class:e.btnTrans.save.icon}),e._v("\n            "+e._s(e.btnTrans.save.text)+" \n          ")]),e._v(" "),a("a",{class:e.btnTrans.cancel.class+" btn-sm",attrs:{href:this.urlReset,type:"button"}},[a("i",{class:e.btnTrans.cancel.icon}),e._v(" \n            "+e._s(e.btnTrans.cancel.text)+" \n          ")])])])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("dt",[e._v("\n              ชื่อรายการราคาสินค้า"),a("span",{staticClass:"text-danger"},[e._v("*")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("thead",[a("tr",[a("th",{attrs:{width:"1%"}},[e._v(" # ")]),e._v(" "),a("th",[e._v(" ผลิตภัณฑ์ ")]),e._v(" "),a("th",{attrs:{width:"20%"}},[e._v(" หน่วย ")]),e._v(" "),a("th",{attrs:{width:"15%"}},[e._v("ราคาต่อหน่วย"),a("span",{staticClass:"text-danger"},[e._v("*")])]),e._v(" "),a("th",{attrs:{width:"15%"}},[e._v("วันที่เริ่มต้นใช้งาน"),a("span",{staticClass:"text-danger"},[e._v("*")])]),e._v(" "),a("th",{attrs:{width:"15%"}},[e._v("วันที่สิ้นสุดใช้งาน")]),e._v(" "),a("th")])])}],!1,null,null,null).exports}}]);