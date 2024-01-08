(self.webpackChunk=self.webpackChunk||[]).push([[1812],{41812:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>n});var i=a(87757),d=a.n(i),s=a(30381),o=a.n(s);function l(t,e,a,i,d,s,o){try{var l=t[s](o),r=l.value}catch(t){return void a(t)}l.done?e(r):Promise.resolve(r).then(i,d)}const r={props:["items","quotaGroups","creditGroups","defaultValue","old"],data:function(){return{item_id:this.old.item_id?this.old.item_id:this.defaultValue?this.defaultValue.item_id:"",quota_group_code:this.old.quota_group_code?this.old.quota_group_code:this.defaultValue?this.defaultValue.quota_group_code:"",credit_group_code:this.old.credit_group_code?this.old.credit_group_code:this.defaultValue?this.defaultValue.credit_group_code:"",disabledEdit:!!this.defaultValue,start_date:this.old.start_date?this.old.start_date:this.defaultValue?this.defaultValue.start_date:"",end_date:this.old.end_date?this.old.end_date:this.defaultValue?this.defaultValue.end_date:"",item_description:"",disabledDateTo:this.start_date?this.start_date:null}},mounted:function(){this.item_id&&this.getSelectedItem(),this.old.start_date&&this.old.end_date||this.showDate()},methods:{getSelectedItem:function(){var t=this;this.selectedItem=this.items.find((function(e){return e.item_id==t.item_id})),this.item_id?this.item_description=this.defaultValue?this.defaultValue.item_description:this.selectedItem.ecom_item_description:this.item_description=""},checkDate:function(){this.start_date&&o()(String(this.end_date)).format("yyyy-MM-DD")<o()(String(this.start_date)).format("yyyy-MM-DD")&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น"}),this.end_date="")},showDate:function(){var t,e=this;return(t=d().mark((function t(){var a,i;return d().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.start_date){t.next=5;break}return t.next=3,helperDate.parseToDateTh(e.start_date,"yyyy-MM-DD");case 3:a=t.sent,e.start_date=a;case 5:if(!e.end_date){t.next=10;break}return t.next=8,helperDate.parseToDateTh(e.end_date,"yyyy-MM-DD");case 8:i=t.sent,e.end_date=i;case 10:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,d){var s=t.apply(e,a);function o(t){l(s,i,d,o,r,"next",t)}function r(t){l(s,i,d,o,r,"throw",t)}o(void 0)}))})()},fromDateWasSelected:function(t){this.disabledDateTo=o()(t).format("DD/MM/YYYY")}}};const n=(0,a(51900).Z)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[t._m(0),t._v(" "),a("input",{attrs:{type:"hidden",name:"item_id",autocomplete:"off"},domProps:{value:t.item_id}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"",disabled:this.disabledEdit},on:{change:function(e){return t.getSelectedItem()}},model:{value:t.item_id,callback:function(e){t.item_id=e},expression:"item_id"}},t._l(t.items,(function(t){return a("el-option",{key:t.item_id,attrs:{label:t.item_code+" : "+t.ecom_item_description,value:t.item_id}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v(" ชื่อผลิตภัณฑ์ ")]),t._v(" "),a("el-input",{attrs:{disabled:""},model:{value:t.item_description,callback:function(e){t.item_description=e},expression:"item_description"}})],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v(" กลุ่มโควต้า")]),t._v(" "),a("input",{attrs:{type:"hidden",name:"quota_group_code",autocomplete:"off"},domProps:{value:t.quota_group_code}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.quota_group_code,callback:function(e){t.quota_group_code=e},expression:"quota_group_code"}},t._l(t.quotaGroups,(function(t){return a("el-option",{key:t.lookup_code,attrs:{label:t.meaning+" : "+t.description,value:t.lookup_code}})})),1)],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-4"},[t._m(1),t._v(" "),a("input",{attrs:{type:"hidden",name:"credit_group_code",autocomplete:"off"},domProps:{value:t.credit_group_code}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.credit_group_code,callback:function(e){t.credit_group_code=e},expression:"credit_group_code"}},t._l(t.creditGroups,(function(t){return a("el-option",{key:t.lookup_code,attrs:{label:t.description,value:t.lookup_code}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v(" วันที่เริ่มต้น")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY"},on:{dateWasSelected:t.fromDateWasSelected},model:{value:t.start_date,callback:function(e){t.start_date=e},expression:"start_date"}})],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v(" วันที่สิ้นสุด")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"end_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY","disabled-date-to":t.disabledDateTo},model:{value:t.end_date,callback:function(e){t.end_date=e},expression:"end_date"}})],1)])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" รหัสผลิตภัณฑ์ "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" กลุ่มวงเงินเขื่อ "),a("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);