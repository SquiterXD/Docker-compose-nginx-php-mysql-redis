(self.webpackChunk=self.webpackChunk||[]).push([[4925],{54925:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>c});var s=a(87757),n=a.n(s),r=a(30381),l=a.n(r);function o(t,e,a,s,n,r,l){try{var o=t[r](l),i=o.value}catch(t){return void a(t)}o.done?e(i):Promise.resolve(i).then(s,n)}function i(t){return function(){var e=this,a=arguments;return new Promise((function(s,n){var r=t.apply(e,a);function l(t){o(r,s,n,l,i,"next",t)}function i(t){o(r,s,n,l,i,"throw",t)}l(void 0)}))}}const d={props:["po-vendors","url","url-return","url-update","default-value","vendor-selected"],data:function(){return{start_date:this.defaultValue?this.defaultValue.start_date:"",end_date:this.defaultValue?this.defaultValue.end_date:"",stop_flag:!!this.defaultValue&&"N"!=this.defaultValue.stop_flag,vendor_id:this.defaultValue?Number(this.defaultValue.vendor_id):"",transport_owner_code:this.defaultValue?this.defaultValue.transport_owner_code:"",transport_owner_name:this.defaultValue?this.defaultValue.transport_owner_name:"",VendorList:[],disabledDateTo:this.start_date?this.start_date:null,api_url:this.defaultValue?this.defaultValue.api_url:"",api_token:this.defaultValue?this.defaultValue.api_token:"",api_user:this.defaultValue?this.defaultValue.api_user:""}},mounted:function(){this.getVendorList(),this.showDate()},methods:{showDate:function(){var t=this;return i(n().mark((function e(){var a,s;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!t.start_date){e.next=5;break}return e.next=3,helperDate.parseToDateTh(t.start_date,"yyyy-MM-DD");case 3:a=e.sent,t.start_date=a;case 5:if(!t.end_date){e.next=10;break}return e.next=8,helperDate.parseToDateTh(t.end_date,"yyyy-MM-DD");case 8:s=e.sent,t.end_date=s;case 10:case"end":return e.stop()}}),e)})))()},fromDateWasSelected:function(t){this.disabledDateTo=l()(t).format("DD/MM/YYYY")},getVendorList:function(t){var e=this;return i(n().mark((function a(){var s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return console.log("query --\x3e "+t),s=e.defaultValue?e.defaultValue.vendor_id:"",console.log(s),a.next=5,axios.get("/om/ajax/vendor",{params:{query:t,vender:s}}).then((function(t){e.VendorList=t.data})).catch((function(t){console.log(t)})).then((function(){e.loading=!1}));case 5:case"end":return a.stop()}}),a)})))()},save:function(){var t=this;console.log("xxxxxxx"),this.loading=!0,axios.post(this.url,{start_date:this.start_date,end_date:this.end_date,stop_flag:this.stop_flag,vendor_id:this.vendor_id,transport_owner_code:this.transport_owner_code,transport_owner_name:this.transport_owner_name}).then((function(t){alert("complete")})).then((function(e){window.location.href=t.urlReturn})).catch((function(t){alert(t)}))},update:function(){var t=this;console.log("update"),this.loading=!0,axios.put(this.urlUpdate,{start_date:this.start_date,end_date:this.end_date,stop_flag:this.stop_flag,vendor_id:this.vendor_id,transport_owner_code:this.transport_owner_code,transport_owner_name:this.transport_owner_name}).then((function(t){alert("complete")})).then((function(e){window.location.href=t.urlReturn})).catch((function(t){alert(t)}))},enableFlag:function(t){this.enable_flag=!1,this.stop_flag=!1,"N"==t&&(this.enable_flag=!1,this.stop_flag=!0),"Y"==t&&(this.enable_flag=!0,this.stop_flag=!1)}}};const c=(0,a(51900).Z)(d,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(0),t._v(" "),a("el-input",{attrs:{name:"transport_owner_code",size:"medium"},model:{value:t.transport_owner_code,callback:function(e){t.transport_owner_code=e},expression:"transport_owner_code"}})],1),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(1),t._v(" "),a("el-input",{attrs:{name:"transport_owner_name",size:"medium"},model:{value:t.transport_owner_name,callback:function(e){t.transport_owner_name=e},expression:"transport_owner_name"}})],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(2),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{size:"medium",name:"start_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY"},on:{dateWasSelected:t.fromDateWasSelected},model:{value:t.start_date,callback:function(e){t.start_date=e},expression:"start_date"}})],1),t._v(" "),a("div",{staticClass:"col-md-5"},[a("label",[t._v(" วันที่สิ้นสุด  ")]),t._v(" "),a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{size:"medium",name:"end_date",placeholder:"โปรดเลือกวันที่",format:"DD-MM-YYYY","disabled-date-to":t.disabledDateTo},model:{value:t.end_date,callback:function(e){t.end_date=e},expression:"end_date"}})],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(3),t._v(" "),a("input",{attrs:{type:"hidden",name:"vendor_id",autocomplete:"off"},domProps:{value:t.vendor_id}}),t._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",remote:"","reserve-keyword":"",clearable:"","remote-method":t.getVendorList,size:"medium"},model:{value:t.vendor_id,callback:function(e){t.vendor_id=e},expression:"vendor_id"}},t._l(t.VendorList,(function(t){return a("el-option",{key:t.vendor_id,attrs:{label:t.vendor_code+" - "+t.vendor_name,value:t.vendor_id}})})),1)],1),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(4),t._v(" "),a("el-input",{attrs:{name:"api_url",size:"medium"},model:{value:t.api_url,callback:function(e){t.api_url=e},expression:"api_url"}})],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(5),t._v(" "),a("el-input",{attrs:{name:"api_token",size:"medium"},model:{value:t.api_token,callback:function(e){t.api_token=e},expression:"api_token"}})],1),t._v(" "),a("div",{staticClass:"col-md-5"},[t._m(6),t._v(" "),a("el-input",{attrs:{name:"api_user",size:"medium"},model:{value:t.api_user,callback:function(e){t.api_user=e},expression:"api_user"}})],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),t._v(" "),a("div",{staticClass:"col-md-5"},[a("label",[t._v(" หยุดการใช้งาน ")]),a("br"),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.stop_flag,expression:"stop_flag"}],attrs:{type:"checkbox",name:"stop_flag"},domProps:{checked:Array.isArray(t.stop_flag)?t._i(t.stop_flag,null)>-1:t.stop_flag},on:{change:function(e){var a=t.stop_flag,s=e.target,n=!!s.checked;if(Array.isArray(a)){var r=t._i(a,null);s.checked?r<0&&(t.stop_flag=a.concat([null])):r>-1&&(t.stop_flag=a.slice(0,r).concat(a.slice(r+1)))}else t.stop_flag=n}}})])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" เจ้าของรถขนส่ง "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" ชื่อเจ้าของรถขนส่ง "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" วันที่เริ่มต้น "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" รหัสเจ้าหนี้ "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" API URL "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" API TOKEN "),a("span",{staticClass:"text-danger"},[t._v("*")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[t._v(" API USER "),a("span",{staticClass:"text-danger"},[t._v("*")])])}],!1,null,null,null).exports}}]);