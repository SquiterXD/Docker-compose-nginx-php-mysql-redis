(self.webpackChunk=self.webpackChunk||[]).push([[1668],{71668:(t,a,e)=>{"use strict";e.r(a),e.d(a,{default:()=>n});var i=e(87757),l=e.n(i),d=e(30381),s=e.n(d);function o(t,a,e,i,l,d,s){try{var o=t[d](s),r=o.value}catch(t){return void e(t)}o.done?a(r):Promise.resolve(r).then(i,l)}const r={props:["authoRityLists","defaultValue","old"],data:function(){return{cbb_range_from:this.old.cbb_range_from?this.old.cbb_range_from:this.defaultValue?this.defaultValue.cbb_range_from:"",cbb_range_to:this.old.cbb_range_to?this.old.cbb_range_to:this.defaultValue?this.defaultValue.cbb_range_to:"",authority_id1:this.old.authority_id1?Number(this.old.authority_id1):this.defaultValue&&this.defaultValue.authority_id1?Number(this.defaultValue.authority_id1):"",authority_id2:this.old.authority_id2?Number(this.old.authority_id2):this.defaultValue&&this.defaultValue.authority_id2?Number(this.defaultValue.authority_id2):"",authority_id3:this.old.authority_id3?Number(this.old.authority_id3):this.defaultValue&&this.defaultValue.authority_id3?Number(this.defaultValue.authority_id3):"",sales_division_id:this.old.sales_division_id?Number(this.old.sales_division_id):this.defaultValue&&this.defaultValue.sales_division_id?Number(this.defaultValue.sales_division_id):"",start_date:this.old.start_date?this.old.start_date:this.defaultValue?this.defaultValue.start_date:"",end_date:this.old.end_date?this.old.end_date:this.defaultValue?this.defaultValue.end_date:"",authority_id1_additional:this.old.authority_id1_additional?this.old.authority_id1_additional:this.defaultValue?this.defaultValue.authority_id1_additional:"",authority_id2_additional:this.old.authority_id2_additional?this.old.authority_id2_additional:this.defaultValue?this.defaultValue.authority_id2_additional:"",authority_id3_additional:this.old.authority_id3_additional?this.old.authority_id3_additional:this.defaultValue?this.defaultValue.authority_id3_additional:"",sales_division_additional:this.old.sales_division_additional?this.old.sales_division_additional:this.defaultValue?this.defaultValue.sales_division_additional:"",disabledDateTo:this.start_date?this.start_date:null}},mounted:function(){console.log("xxxxxxxxxxxxxxxxxx",this.start_date),this.old.start_date&&this.old.end_date||this.showDate()},methods:{checkDate:function(){console.log("1111 ---\x3e"+this.start_date),this.start_date&&(console.log("start -----\x3e "+s()(String(this.end_date)).format("yyyy-MM-DD")),console.log("end -----\x3e "+s()(String(this.start_date)).format("yyyy-MM-DD")),s()(String(this.end_date)).format("yyyy-MM-DD")<s()(String(this.start_date)).format("yyyy-MM-DD")&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น"}),this.end_date=""))},showDate:function(){var t,a=this;return(t=l().mark((function t(){var e,i;return l().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!a.start_date){t.next=5;break}return t.next=3,helperDate.parseToDateTh(a.start_date,"yyyy-MM-DD");case 3:e=t.sent,a.start_date=e;case 5:if(!a.end_date){t.next=10;break}return t.next=8,helperDate.parseToDateTh(a.end_date,"yyyy-MM-DD");case 8:i=t.sent,a.end_date=i;case 10:case"end":return t.stop()}}),t)})),function(){var a=this,e=arguments;return new Promise((function(i,l){var d=t.apply(a,e);function s(t){o(d,i,l,s,r,"next",t)}function r(t){o(d,i,l,s,r,"throw",t)}s(void 0)}))})()},fromDateWasSelected:function(t){this.disabledDateTo=s()(t).format("DD/MM/YYYY")}}};const n=(0,e(51900).Z)(r,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-2"}),t._v(" "),e("div",{staticClass:"col-md-4"},[t._m(0),t._v(" "),e("el-input",{attrs:{name:"cbb_range_from"},model:{value:t.cbb_range_from,callback:function(a){t.cbb_range_from=a},expression:"cbb_range_from"}})],1),t._v(" "),e("div",{staticClass:"col-md-4"},[t._m(1),t._v(" "),e("el-input",{attrs:{name:"cbb_range_to"},model:{value:t.cbb_range_to,callback:function(a){t.cbb_range_to=a},expression:"cbb_range_to"}})],1)]),t._v(" "),e("div",{staticClass:"row mt-2"},[e("div",{staticClass:"col-md-2"}),t._v(" "),e("div",{staticClass:"col-md-4"},[e("label",[t._v(" วันที่เริ่มต้น")]),t._v(" "),e("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY"},on:{dateWasSelected:t.fromDateWasSelected},model:{value:t.start_date,callback:function(a){t.start_date=a},expression:"start_date"}})],1),t._v(" "),e("div",{staticClass:"col-md-4"},[e("label",[t._v(" วันที่สิ้นสุด")]),t._v(" "),e("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"end_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY","disabled-date-to":t.disabledDateTo},model:{value:t.end_date,callback:function(a){t.end_date=a},expression:"end_date"}})],1)]),t._v(" "),e("div",{staticClass:"row mt-2"},[e("div",{staticClass:"col-md-2"}),t._v(" "),e("div",{staticClass:"col-md-4"},[t._m(2),t._v(" "),e("input",{attrs:{type:"hidden",name:"sales_division_id",autocomplete:"off"},domProps:{value:t.sales_division_id}}),t._v(" "),e("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",placeholder:"โปรดเลือก"},model:{value:t.sales_division_id,callback:function(a){t.sales_division_id=a},expression:"sales_division_id"}},t._l(t.authoRityLists,(function(t){return e("el-option",{key:t.authority_id,attrs:{label:t.employee_name+" : "+t.position_name,value:t.authority_id}})})),1)],1),t._v(" "),e("div",{staticClass:"col-md-4"},[t._m(3),t._v(" "),e("input",{attrs:{type:"hidden",name:"sales_division_additional",autocomplete:"off"},domProps:{value:t.sales_division_additional}}),t._v(" "),e("el-input",{attrs:{clearable:""},model:{value:t.sales_division_additional,callback:function(a){t.sales_division_additional=a},expression:"sales_division_additional"}})],1)]),t._v(" "),e("div",{staticClass:"row mt-2"},[e("div",{staticClass:"col-md-2"}),t._v(" "),e("div",{staticClass:"col-md-4"},[e("label",[t._v(" ผู้เรียนพิจารณา 1 ")]),t._v(" "),e("input",{attrs:{type:"hidden",name:"authority_id1",autocomplete:"off"},domProps:{value:t.authority_id1}}),t._v(" "),e("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",placeholder:"โปรดเลือก"},model:{value:t.authority_id1,callback:function(a){t.authority_id1=a},expression:"authority_id1"}},t._l(t.authoRityLists,(function(t){return e("el-option",{key:t.authority_id,attrs:{label:t.employee_name+" : "+t.position_name,value:t.authority_id}})})),1)],1),t._v(" "),e("div",{staticClass:"col-md-4"},[e("label",[t._v(" ตำแหน่งที่แสดงในรายงาน  ")]),t._v(" "),e("input",{attrs:{type:"hidden",name:"authority_id1_additional",autocomplete:"off"},domProps:{value:t.authority_id1_additional}}),t._v(" "),e("el-input",{attrs:{clearable:""},model:{value:t.authority_id1_additional,callback:function(a){t.authority_id1_additional=a},expression:"authority_id1_additional"}})],1)]),t._v(" "),e("div",{staticClass:"row mt-2"},[e("div",{staticClass:"col-md-2"}),t._v(" "),e("div",{staticClass:"col-md-4"},[e("label",[t._v(" ผู้เรียนพิจารณา 2 ")]),t._v(" "),e("input",{attrs:{type:"hidden",name:"authority_id2",autocomplete:"off"},domProps:{value:t.authority_id2}}),t._v(" "),e("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",placeholder:"โปรดเลือก"},model:{value:t.authority_id2,callback:function(a){t.authority_id2=a},expression:"authority_id2"}},t._l(t.authoRityLists,(function(t){return e("el-option",{key:t.authority_id,attrs:{label:t.employee_name+" : "+t.position_name,value:t.authority_id}})})),1)],1),t._v(" "),e("div",{staticClass:"col-md-4"},[e("label",[t._v(" ตำแหน่งที่แสดงในรายงาน ")]),t._v(" "),e("input",{attrs:{type:"hidden",name:"authority_id2_additional",autocomplete:"off"},domProps:{value:t.authority_id2_additional}}),t._v(" "),e("el-input",{attrs:{clearable:""},model:{value:t.authority_id2_additional,callback:function(a){t.authority_id2_additional=a},expression:"authority_id2_additional"}})],1)]),t._v(" "),e("div",{staticClass:"row mt-2"},[e("div",{staticClass:"col-md-2"}),t._v(" "),e("div",{staticClass:"col-md-4"},[t._m(4),t._v(" "),e("input",{attrs:{type:"hidden",name:"authority_id3",autocomplete:"off"},domProps:{value:t.authority_id3}}),t._v(" "),e("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",placeholder:"โปรดเลือก"},model:{value:t.authority_id3,callback:function(a){t.authority_id3=a},expression:"authority_id3"}},t._l(t.authoRityLists,(function(t){return e("el-option",{key:t.authority_id,attrs:{label:t.employee_name+" : "+t.position_name,value:t.authority_id}})})),1)],1),t._v(" "),e("div",{staticClass:"col-md-4"},[t._m(5),t._v(" "),e("input",{attrs:{type:"hidden",name:"authority_id3_additional",autocomplete:"off"},domProps:{value:t.authority_id3_additional}}),t._v(" "),e("el-input",{attrs:{clearable:""},model:{value:t.authority_id3_additional,callback:function(a){t.authority_id3_additional=a},expression:"authority_id3_additional"}})],1)])])}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v(" ช่วงหีบ "),e("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v(" ถึง "),e("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v(" กองบริหารขาย "),e("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v(" ตำแหน่งที่แสดงในรายงาน "),e("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v(" ผู้มีอำนาจอนุมัติ "),e("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("label",[t._v(" ตำแหน่งที่แสดงในรายงาน  "),e("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);