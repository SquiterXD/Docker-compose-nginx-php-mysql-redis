(self.webpackChunk=self.webpackChunk||[]).push([[1038],{91038:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>i});var s=a(87757),r=a.n(s),d=a(30381),n=a.n(d);function o(t,e,a,s,r,d,n){try{var o=t[d](n),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(s,r)}const l={props:["customers","defaultValue","old"],data:function(){return{customer_id:this.old.customer_id?Number(this.old.customer_id):this.defaultValue?Number(this.defaultValue.customer_id):"",start_date:this.old.start_date?this.old.start_date:this.defaultValue?this.defaultValue.start_date:"",end_date:this.old.end_date?this.old.end_date:this.defaultValue?this.defaultValue.end_date:"",disabledDateTo:this.start_date?this.start_date:null}},mounted:function(){this.old.start_date&&this.old.end_date||this.showDate()},methods:{checkDate:function(){this.start_date&&n()(String(this.end_date)).format("yyyy-MM-DD")<n()(String(this.start_date)).format("yyyy-MM-DD")&&(this.$notify.error({title:"มีข้อผิดพลาด",message:"วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น"}),this.end_date="")},showDate:function(){var t,e=this;return(t=r().mark((function t(){var a,s;return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.start_date){t.next=5;break}return t.next=3,helperDate.parseToDateTh(e.start_date,"yyyy-MM-DD");case 3:a=t.sent,e.start_date=a;case 5:if(!e.end_date){t.next=10;break}return t.next=8,helperDate.parseToDateTh(e.end_date,"yyyy-MM-DD");case 8:s=t.sent,e.end_date=s;case 10:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(s,r){var d=t.apply(e,a);function n(t){o(d,s,r,n,l,"next",t)}function l(t){o(d,s,r,n,l,"throw",t)}n(void 0)}))})()},fromDateWasSelected:function(t){this.disabledDateTo=n()(t).format("DD/MM/YYYY")}}};const i=(0,a(51900).Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4"},[t._m(0),t._v(" "),a("input",{attrs:{type:"hidden",name:"customer_id",autocomplete:"off"},domProps:{value:t.customer_id}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:""},model:{value:t.customer_id,callback:function(e){t.customer_id=e},expression:"customer_id"}},t._l(t.customers,(function(t){return a("el-option",{key:t.customer_id,attrs:{label:t.customer_number+" : "+t.customer_name,value:t.customer_id}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v(" วันที่เริ่มต้น ")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY"},on:{dateWasSelected:t.fromDateWasSelected},model:{value:t.start_date,callback:function(e){t.start_date=e},expression:"start_date"}})],1),t._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[t._v(" วันที่สิ้นสุด ")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"end_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY","disabled-date-to":t.disabledDateTo},model:{value:t.end_date,callback:function(e){t.end_date=e},expression:"end_date"}})],1)])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" รหัส - ชื่อร้านค้า "),a("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);