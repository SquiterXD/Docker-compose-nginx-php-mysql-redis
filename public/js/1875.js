(self.webpackChunk=self.webpackChunk||[]).push([[1875,7457],{25390:(t,e,a)=>{"use strict";a.d(e,{Z:()=>r});var i=a(23645),n=a.n(i)()((function(t){return t[1]}));n.push([t.id,".mx-datepicker-popup{z-index:9999!important}",""]);const r=n},37457:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>h});var i=a(87757),n=a.n(i),r=a(71170),s=(a(68737),a(30381)),l=a.n(s);function d(t,e,a,i,n,r,s){try{var l=t[r](s),d=l.value}catch(t){return void a(t)}l.done?e(d):Promise.resolve(d).then(i,n)}function c(t){return function(){var e=this,a=arguments;return new Promise((function(i,n){var r=t.apply(e,a);function s(t){d(r,i,n,s,l,"next",t)}function l(t){d(r,i,n,s,l,"throw",t)}s(void 0)}))}}var o,u;const m={props:["value","name","id","inputClass","placeholder","disabledDateTo","format","pType","disabled","notBeforeDate","notAfterDate","omType"],mounted:function(){},watch:{disabledDateTo:(u=c(n().mark((function t(e){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,l()(e,this.format).toDate();case 2:if(t.t0=t.sent,t.t1=this.date,!(t.t0>t.t1)){t.next=6;break}this.date=null;case 6:case"end":return t.stop()}}),t,this)}))),function(t){return u.apply(this,arguments)}),value:(o=c(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:console.log("change value: ",e,a),this.date=e&&e?l()(e,this.format).toDate():null;case 2:case"end":return t.stop()}}),t,this)}))),function(t,e){return o.apply(this,arguments)})},components:{DatePicker:r.Z},data:function(){var t=this;return{type:null!=this.pType&&""!=this.pType?this.pType:"date",date:this.value?l()(this.value,this.format).toDate():null,defaultDate:("export"==this.omType?l()().toDate():this.value)?l()(this.value,this.format).toDate():l()().add(543,"years").toDate(),lang:{formatLocale:{months:["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],monthsShort:["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],weekdays:["พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์","จันทร์","อังคาร","อังคาร"],weekdaysShort:["พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์","จันทร์","อังคาร","อังคาร"],weekdaysMin:["พฤ.","ศ.","ส.","อา.","จ.","อ.","พ."],firstDayOfWeek:3},yearFormat:"YYYY",monthFormat:"MMM",monthBeforeYear:!0},disabledDate:function(e){if(t.disabledDateTo)return e<l()(t.disabledDateTo,t.format).toDate()}}},methods:{dateWasSelected:function(t){this.date=t,this.$emit("dateWasSelected",t)},disabledBeforeAndAfter:function(t){return this.disabledDateTo?t<l()(this.disabledDateTo,this.format).toDate():this.notBeforeDate&&this.notAfterDate?t<l()(this.notBeforeDate,this.format).toDate()||t>l()(this.notAfterDate,this.format).toDate():this.notAfterDate?t>l()(this.notAfterDate,this.format).toDate():void 0}}};var p=a(93379),f=a.n(p),_=a(25390),v={insert:"head",singleton:!1};f()(_.Z,v);_.Z.locals;const h=(0,a(51900).Z)(m,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("date-picker",{attrs:{"input-class":[t.inputClass],"default-value":t.defaultDate,"input-attr":{name:t.name,id:t.id},placeholder:t.placeholder,lang:t.lang,type:t.type,disabled:t.disabled,"disabled-date":t.disabledBeforeAndAfter,format:t.format,"om-Type":t.omType},on:{change:t.dateWasSelected},model:{value:t.date,callback:function(e){t.date=e},expression:"date"}})}),[],!1,null,null,null).exports},81875:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>h});var i=a(87757),n=a.n(i),r=a(30381),s=a.n(r),l=a(23570),d=a.n(l),c=a(80455),o=a.n(c),u=a(37457);function m(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,i)}return a}function p(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}function f(t,e,a,i,n,r,s){try{var l=t[r](s),d=l.value}catch(t){return void a(t)}l.done?e(d):Promise.resolve(d).then(i,n)}function _(t){return function(){var e=this,a=arguments;return new Promise((function(i,n){var r=t.apply(e,a);function s(t){f(r,i,n,s,l,"next",t)}function l(t){f(r,i,n,s,l,"throw",t)}s(void 0)}))}}const v={props:["transDate","historyList","transBtn","lastNumberSeq","currentDateTH","historyGroupByList"],data:function(){return{lines:[],arrayDataUpdate:[],subLine:[],medicinalLeafItems:[],isDisabledBtnAddLine:!0,isDisabledBtnSave:!0}},components:{VueNumeric:o(),DatepickerTh:u.default},mounted:function(){},methods:{addLine:function(){var t=this,e={medicinalLeafTypesH:t.$parent.medicinalLeafH,medicinalLeafTypesL:t.$parent.medicinalLeafL,medicinalItem:t.$parent.medicinalItem};axios.get("/pd/ajax/history-instead-grades/get-medicinal-leaf-item-l",{params:e}).then((function(e){t.medicinalLeafItems=e.data.medicinalLeafItemLineList})),this.lines.push({id:d()(),seqNumber:"",approved_date:t.currentDateTH,date_instead_grades:t.currentDateTH,lot_number:"",medicinal_leaf_no:"",quantity_percent:"",medicinal_leaf_description:"",medicinal_leaf_group:"",medicinalLeafItems:t.medicinalLeafItems,lotNumberList:[],isValidate:{medicinal_leaf_no:!1,quantity_percent:!1,lot_number:!1},isDisabled:{lot_number:!0},loading:{lot_number:!1},disabledDateTo:"",validateRemarkLimitPercent:!1,subLine:[]})},checkValue:function(t,e){t>100?(swal({title:"เกิดข้อผิดพลาด !",text:"ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",type:"error",showConfirmButton:!0}),e.validateRemarkLimitPercent=!0):e.validateRemarkLimitPercent=!1},dateApprovedDateSelected:function(t,e){e.approved_date=s()(t).format(this.transDate["oracle-format"]),e.history_id&&(e.status="update")},dateInsteadGradesSelected:function(t,e){e.date_instead_grades=s()(t).format(this.transDate["oracle-format"]),e.history_id&&(e.status="update")},getDescItem:function(t,e){var a=this;return _(n().mark((function i(){var r;return n().wrap((function(i){for(;;)switch(i.prev=i.next){case 0:if(e.loading.lot_number=!0,!t){i.next=9;break}return a.medicinalLeafItems.forEach((function(a){a.item_id==t&&(e.medicinal_leaf_no=a.item_code,e.medicinal_leaf_description=a.item_desc,e.medicinal_leaf_group=a.medicinal_leaf_group)})),r={item_id:t},i.next=6,axios.get("/pd/ajax/history-instead-grades/get-Lot",{params:r}).then((function(t){e.lotNumberList=t.data.lotNumberList,e.isDisabled.lot_number=!1,e.loading.lot_number=!1}));case 6:return i.abrupt("return",i.sent);case 9:e.medicinal_leaf_no="",e.medicinal_leaf_description="",e.medicinal_leaf_group="",e.isDisabled.lot_number=!0,e.loading.lot_number=!1;case 14:case"end":return i.stop()}}),i)})))()},removeRow:function(t){this.lines.splice(t,1)},removeRowTableData:function(t){var e=this;return _(n().mark((function a(){var i,r;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:(i=e).$parent.loading.table=!0,r={id:t},swal({title:"แน่ใจ?",text:"คุณแน่ใจที่ต้องการจะลบข้อมูลชุดนี้ ?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"ยืนยัน",closeOnConfirm:!1},(function(t){var e=this;t?axios.get("/pd/ajax/history-instead-grades/destroy",{params:r}).then((function(t){"SUCCESS"==t.data.status?(swal({title:"Success !",text:"ลบข้อมูลสำเร็จ",type:"success",showConfirmButton:!0}),i.$parent.loading.table=!1,e.lines=[],i.$parent.getMedicinalLeafTypesL(i.$parent.medicinalLeafH),i.$parent.getMedicinalLeafItemV(i.$parent.medicinalLeafH,i.$parent.medicinalLeafL),i.$parent.search(i.$parent.medicinalLeafH,i.$parent.medicinalLeafL,i.$parent.medicinalItem)):(swal({title:"Error !",text:"บันทึกไม่สำเร็จ เนื่องจาก "+t.err_msg,type:"error",showConfirmButton:!0}),i.$parent.loading.table=!1,e.lines=[])})):i.$parent.loading.table=!1}));case 4:case"end":return a.stop()}}),a)})))()},save:function(){var t=this,e=!1;if(this.lines.forEach((function(t){if(!(t.quantity_percent>100))return t.medicinal_leaf_no&&t.quantity_percent?(t.isValidate.medicinal_leaf_no=!1,t.isValidate.quantity_percent=!1,void(e=!0)):t.medicinal_leaf_no||t.quantity_percent?t.medicinal_leaf_no?(t.isValidate.medicinal_leaf_no=!1,t.quantity_percent?void(t.isValidate.quantity_percent=!1):(t.isValidate.quantity_percent=!0,void(e=!1))):(t.isValidate.medicinal_leaf_no=!0,void(e=!1)):(t.isValidate.medicinal_leaf_no=!0,t.isValidate.quantity_percent=!0,void(e=!1));swal({title:"เกิดข้อผิดพลาด !",text:"ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",type:"error",showConfirmButton:!0})})),0!=this.historyList.length&&(this.arrayDataUpdate=this.historyList.filter((function(t){if("update"==t.status)return t}))),e||0!=this.arrayDataUpdate.length){var a=this,i=function(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?m(Object(a),!0).forEach((function(e){p(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):m(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}({},this.lines),n=a.$parent.medicinalLeafH,r=a.$parent.medicinalLeafL,s=this.arrayDataUpdate,l=a.$parent.medicinalItem;s.forEach((function(t,e){!t.quantity_percent>100&&swal({title:"เกิดข้อผิดพลาด !",text:"ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",type:"error",showConfirmButton:!0})})),a.$parent.loading.table=!0,axios.post("/pd/ajax/history-instead-grades/store",{params:i,params1:n,params2:r,params3:s,params4:l}).then((function(e){"SUCCESS"==e.data.status?(swal({title:"Success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}),a.$parent.loading.table=!1,t.lines=[],a.$parent.getMedicinalLeafTypesL(a.$parent.medicinalLeafH),a.$parent.getMedicinalLeafItemV(a.$parent.medicinalLeafH,a.$parent.medicinalLeafL),a.$parent.search(a.$parent.medicinalLeafH,a.$parent.medicinalLeafL,a.$parent.medicinalItem)):(swal({title:"เกิดข้อผิดพลาด !",text:"บันทึกไม่สำเร็จ เนื่องจาก "+e.err_msg,type:"error",showConfirmButton:!0}),a.$parent.loading.table=!1)}))}}}};const h=(0,a(51900).Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"ibox",staticStyle:{"padding-top":"50px"}},[t._m(0),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"text-right",staticStyle:{"padding-bottom":"15px"}},[a("button",{staticClass:"btn btn-success",staticStyle:{"margin-right":"5px"},attrs:{type:"submit",disabled:t.isDisabledBtnSave},on:{click:function(e){return e.preventDefault(),t.save()}}},[a("i",{staticClass:"fa fa-floppy-o",attrs:{"aria-hidden":"true"}}),t._v(" บันทึก \n                ")]),t._v(" "),a("button",{staticClass:"btn btn-primary",attrs:{disabled:t.isDisabledBtnAddLine,id:"addLine"},on:{click:function(e){return e.preventDefault(),t.addLine(e)}}},[a("i",{staticClass:"fa fa-plus",attrs:{"aria-hidden":"true"}}),t._v(" เพิ่มรายการ \n                ")])]),t._v(" "),a("div",[a("table",{staticClass:"table table-bordered table-data",attrs:{id:"tableHistoryInsteadGrades"}},[t._m(1),t._v(" "),a("tbody",[t._l(t.lines,(function(e,i){return a("tr",{key:i,attrs:{row:i}},[a("td",{staticClass:"text-center",staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[t._v("                                    \n                                "+t._s(e.seqNumber=Number(t.lastNumberSeq)+(i+1))+"\n                            ")]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",format:t.transDate["js-format"]},on:{dateWasSelected:function(a){for(var i=arguments.length,n=Array(i);i--;)n[i]=arguments[i];return t.dateApprovedDateSelected.apply(void 0,n.concat([e]))}},model:{value:e.approved_date,callback:function(a){t.$set(e,"approved_date",a)},expression:"line.approved_date"}})],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",format:t.transDate["js-format"]},on:{dateWasSelected:function(a){for(var i=arguments.length,n=Array(i);i--;)n[i]=arguments[i];return t.dateInsteadGradesSelected.apply(void 0,n.concat([e]))}},model:{value:e.date_instead_grades,callback:function(a){t.$set(e,"date_instead_grades",a)},expression:"line.date_instead_grades"}})],1),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("el-select",{staticClass:"w-100",attrs:{placeholder:"เลือกรหัสใบยา",clearable:"",filterable:"","reserve-keyword":""},on:{change:function(a){return t.getDescItem(e.medicinal_leaf_no,e)}},model:{value:e.medicinal_leaf_no,callback:function(a){t.$set(e,"medicinal_leaf_no",a)},expression:"line.medicinal_leaf_no"}},t._l(t.medicinalLeafItems,(function(t,e){return a("el-option",{key:e,attrs:{label:t.item_code+" : "+t.item_desc,value:t.item_id}})})),1),t._v(" "),e.isValidate.medicinal_leaf_no?a("span",[a("span",{staticClass:"form-text m-b-none text-danger",staticStyle:{"vertical-align":"middle"}},[t._v("\n                                        "+t._s("กรุณาเลือกรหัสใบยา")+"\n                                    ")])]):t._e()],1),t._v(" "),a("td",[a("el-input",{staticClass:"w-100",staticStyle:{"vertical-align":"middle"},attrs:{placeholder:"",disabled:!0},model:{value:e.medicinal_leaf_description,callback:function(a){t.$set(e,"medicinal_leaf_description",a)},expression:"line.medicinal_leaf_description"}})],1),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("el-select",{directives:[{name:"loading",rawName:"v-loading",value:e.loading.lot_number,expression:"line.loading.lot_number"}],staticClass:"w-100",attrs:{placeholder:"เลือก Lot",disabled:e.isDisabled.lot_number},model:{value:e.lot_number,callback:function(a){t.$set(e,"lot_number",a)},expression:"line.lot_number"}},t._l(e.lotNumberList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.lot_number,value:t.lot_number}})})),1)],1),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("vue-numeric",{class:"form-control w-100 text-right "+(e.validateRemarkLimitPercent?"is-invalid":""),attrs:{placeholder:"ระบุจำนวนปริมาณ (%)",separator:",",precision:2,minus:!1},on:{change:function(a){return t.checkValue(e.quantity_percent,e)}},model:{value:e.quantity_percent,callback:function(a){t.$set(e,"quantity_percent",a)},expression:"line.quantity_percent"}}),t._v(" "),e.isValidate.quantity_percent?a("div",[a("span",{staticClass:"form-text m-b-none text-danger"},[t._v("\n                                        "+t._s("กรุณากรอกปริมาณ")+"\n                                    ")])]):t._e()],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("button",{class:t.transBtn.delete.class,on:{click:function(e){return e.preventDefault(),t.removeRow(i)}}},[a("i",{class:t.transBtn.delete.icon,attrs:{"aria-hidden":"true"}})])])])})),t._v(" "),t._l(t.historyList,(function(e,i){return a("tr",{key:"line"+i,attrs:{row:i}},[a("td",{staticClass:"text-center",staticStyle:{"min-width":"inherit","vertical-align":"middle",width:"25px"}},[t._v("\n                                "+t._s(e.version_no)+"\n                            ")]),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",format:t.transDate["js-format"],disabled:""},model:{value:e.approved_date,callback:function(a){t.$set(e,"approved_date",a)},expression:"data.approved_date"}})],1),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",format:t.transDate["js-format"],disabled:""},model:{value:e.date_instead_grades,callback:function(a){t.$set(e,"date_instead_grades",a)},expression:"data.date_instead_grades"}})],1),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},t._l(e.history_instead_grades_d,(function(e,i){return a("div",{key:"sub"+i,attrs:{row:"sub"+i}},[a("el-input",{staticStyle:{width:"100%"},attrs:{placeholder:"เลือกรหัสใบยา",disabled:!0},model:{value:e.l_medicinal_leaf_no,callback:function(a){t.$set(e,"l_medicinal_leaf_no",a)},expression:"sub.l_medicinal_leaf_no"}})],1)})),0),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},t._l(e.history_instead_grades_d,(function(e,i){return a("div",{key:"sub"+i,attrs:{row:"sub"+i}},[""!=e.medicinal_leaf_description?a("div",[a("el-input",{staticClass:"w-100",staticStyle:{"vertical-align":"middle"},attrs:{placeholder:"",disabled:!0},model:{value:e.medicinal_leaf_description,callback:function(a){t.$set(e,"medicinal_leaf_description",a)},expression:"sub.medicinal_leaf_description"}})],1):a("div",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                                        "+t._s("")+"\n                                    ")])])})),0),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},t._l(e.history_instead_grades_d,(function(e,i){return a("div",{key:"sub"+i,attrs:{row:"sub"+i}},[a("el-input",{staticClass:"w-100",staticStyle:{"vertical-align":"middle"},attrs:{placeholder:"เลือก Lot",disabled:!0},model:{value:e.lot_number,callback:function(a){t.$set(e,"lot_number",a)},expression:"sub.lot_number"}})],1)})),0),t._v(" "),a("td",{staticStyle:{"min-width":"inherit","vertical-align":"middle"}},t._l(e.history_instead_grades_d,(function(e,i){return a("div",{key:"sub"+i,staticStyle:{"vertical-align":"middle"},attrs:{row:"sub"+i}},[a("vue-numeric",{class:"form-control w-100 text-right",attrs:{placeholder:"ระบุจำนวนปริมาณ (%)",separator:",",precision:2,minus:!1,disabled:!0},model:{value:e.quantity_percent,callback:function(a){t.$set(e,"quantity_percent",a)},expression:"sub.quantity_percent"}})],1)})),0),t._v(" "),a("td",{staticClass:"text-center",staticStyle:{"min-width":"inherit","vertical-align":"middle"}},[a("button",{class:t.transBtn.delete.class,staticStyle:{"vertical-align":"middle"},on:{click:function(a){return a.preventDefault(),t.removeRowTableData(e.history_id)}}},[a("i",{class:t.transBtn.delete.icon,attrs:{"aria-hidden":"true"}})])])])}))],2)])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"ibox-title"},[a("h5",[t._v("บันทึกประวัติแทนเกรดใบยา")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("ครั้งที่")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("วันที่อนุมัติ")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("วันที่แทนเกรด")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("รหัสใบยา "),a("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("รายละเอียดใบยา "),a("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("Lot")])]),t._v(" "),a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v("ปริมาณ (%) "),a("span",{staticClass:"text-danger"},[t._v(" *")])])]),t._v(" "),a("th")])])}],!1,null,null,null).exports}}]);