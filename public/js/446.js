(self.webpackChunk=self.webpackChunk||[]).push([[446],{20446:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>P});var n=a(87757),i=a.n(n),r=(a(19371),a(7398)),s=a.n(r),l=a(30381),c=a.n(l);function o(t,e,a,n,i,r,s){try{var l=t[r](s),c=l.value}catch(t){return void a(t)}l.done?e(c):Promise.resolve(c).then(n,i)}function d(t){return function(){var e=this,a=arguments;return new Promise((function(n,i){var r=t.apply(e,a);function s(t){o(r,n,i,s,l,"next",t)}function l(t){o(r,n,i,s,l,"throw",t)}s(void 0)}))}}const u={components:{Loading:s()},props:["periodYears","searchInputs","url","periodYearValue","periodNameValue","btnTrans","interfaceGlFlag","validData"],mounted:function(){var t=this;this.periodYearValue&&this.getListPeriodNumbers(this.periodYearValue).then((function(e){t.periodNameValue&&(t.paramHeader.period_number=t.getPeriodNumber(t.periodNumbers,t.periodNameValue),t.paramHeader.start_date=t.getPeriodStartDate(t.periodNumbers,t.periodNameValue,"EN"),t.paramHeader.end_date=t.getPeriodEndDate(t.periodNumbers,t.periodNameValue,"EN"),t.paramHeader.start_date_thai=t.getPeriodStartDate(t.periodNumbers,t.periodNameValue,"TH"),t.paramHeader.end_date_thai=t.getPeriodEndDate(t.periodNumbers,t.periodNameValue,"TH"))}))},data:function(){return{paramHeader:{period_year:this.periodYearValue,period_year_label:this.getPeriodYearLabel(this.periodYears,this.periodYearValue),period_name:this.periodNameValue,period_number:"",start_date:"",end_date:"",start_date_thai:"",end_date_thai:""},periodNumbers:[],queryParams:[],isVerified:!1,isLoading:!1,interfaceFlag:this.interfaceGlFlag}},methods:{setUrlParams:function(){var t=new URLSearchParams(window.location.search);t.set("period_year",this.paramHeader.period_year),t.set("period_name",this.paramHeader.period_name),window.history.replaceState(null,null,"?"+t.toString())},getListPeriodNumbers:function(t){var e=this;return d(i().mark((function a(){var n;return i().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return e.isLoading=!0,e.periodNumbers=[],n={period_year:t},a.next=5,axios.get("/ajax/ct/workorders/processes/get-period-numbers",{params:n}).then((function(t){var e=t.data.data;return e.period_numbers?JSON.parse(e.period_numbers):[]})).catch((function(t){console.log(t),swal("เกิดข้อผิดพลาด","ข้อมูลปี ".concat(e.paramHeader.period_year_label," ไม่ถูกต้อง | ").concat(t.message),"error")}));case 5:e.periodNumbers=a.sent,e.isLoading=!1;case 7:case"end":return a.stop()}}),a)})))()},onPeriodYearChanged:function(t){var e=this;return d(i().mark((function a(){return i().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:e.paramHeader.period_year=t,e.paramHeader.period_year_label=e.getPeriodYearLabel(e.periodYears,t),e.paramHeader.period_name="",e.paramHeader.period_number="",e.paramHeader.start_date="",e.paramHeader.end_date="",e.paramHeader.start_date_thai="",e.paramHeader.end_date_thai="",e.getListPeriodNumbers(e.paramHeader.period_year);case 9:case"end":return a.stop()}}),a)})))()},onPeriodNumberChanged:function(t){var e=this;return d(i().mark((function a(){return i().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:e.paramHeader.period_name=t,e.paramHeader.period_number=e.getPeriodNumber(e.periodNumbers,t),e.paramHeader.start_date=e.getPeriodStartDate(e.periodNumbers,t,"EN"),e.paramHeader.end_date=e.getPeriodEndDate(e.periodNumbers,t,"EN"),e.paramHeader.start_date_thai=e.getPeriodStartDate(e.periodNumbers,t,"TH"),e.paramHeader.end_date_thai=e.getPeriodEndDate(e.periodNumbers,t,"TH");case 6:case"end":return a.stop()}}),a)})))()},getPeriodYearLabel:function(t,e){var a=t.find((function(t){return t.period_year_value==e}));return a?a.period_year_label:""},getPeriodNumber:function(t,e){var a=t.find((function(t){return t.period_number_value==e}));return a?a.period_number_label:""},getPeriodStartDate:function(t,e,a){var n=null,i=t.find((function(t){return t.period_number_value==e}));return n=i?i.start_date:"","TH"==a&&(n=i?i.start_date_thai:""),n},getPeriodEndDate:function(t,e,a){var n=null,i=t.find((function(t){return t.period_number_value==e}));return n=i?i.end_date:"","TH"==a&&(n=i?i.end_date_thai:""),n},onClearParamHeader:function(){var t=this;return d(i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.paramHeader.period_year="",t.paramHeader.period_year_label="",t.paramHeader.period_name="",t.paramHeader.period_number="",t.paramHeader.start_date="",t.paramHeader.end_date="",t.paramHeader.start_date_thai="",t.paramHeader.end_date_thai="",t.periodNumbers=[];case 9:case"end":return e.stop()}}),e)})))()},stampInterfaceGL:function(){var t=this;return d(i().mark((function e(){var a,n;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a={period_year:t.paramHeader.period_year,period_name:t.paramHeader.period_name},n=t,swal({html:!0,title:'<span style="font-size: 18px;"><strong> ส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',text:'<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL ? </span></h2>',showCancelButton:!0,confirmButtonText:n.btnTrans.ok.text,cancelButtonText:n.btnTrans.cancel.text,confirmButtonClass:n.btnTrans.ok.class+" btn-lg tw-w-25",cancelButtonClass:n.btnTrans.cancel.class+" btn-lg tw-w-25",closeOnConfirm:!1,closeOnCancel:!0,showLoaderOnConfirm:!0},function(){var t=d(i().mark((function t(e){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e){t.next=3;break}return t.next=3,axios.post(n.url.ajax_interface_gl,a).then((function(t){"S"==t.data.status?(n.interfaceFlag=t.data.interfaceGLFlag,n.$emit("updateInterfaceFlag",{flag:t.data.interfaceGLFlag}),swal({title:'<span style="font-size: 22px;"><strong> ส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',text:'<span style="font-size: 15px; text-align: left;"> ทำการส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL เรียบร้อยแล้ว </span>',type:"success",html:!0})):swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.data.msg+"</span>",type:"warning",html:!0})})).catch((function(t){console.log(t),swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.response+"</span>",type:"warning",html:!0})})).then((function(){n.isLoading=!1}));case 3:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}());case 3:case"end":return e.stop()}}),e)})))()},stampCancelInterfaceGL:function(){var t=this;return d(i().mark((function e(){var a,n;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a={period_year:t.paramHeader.period_year,period_name:t.paramHeader.period_name},n=t,swal({html:!0,title:'<span style="font-size: 18px;"> <strong> ยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong> </span>',text:'<h2 class="m-t-sm m-b-lg text-left"> <span style="font-size: 16px;"> คุณต้องการยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL ? </span> </h2>',showCancelButton:!0,confirmButtonText:n.btnTrans.ok.text,cancelButtonText:n.btnTrans.cancel.text,confirmButtonClass:n.btnTrans.ok.class+" btn-lg tw-w-25",cancelButtonClass:n.btnTrans.cancel.class+" btn-lg tw-w-25",closeOnConfirm:!1,closeOnCancel:!0,showLoaderOnConfirm:!0},function(){var t=d(i().mark((function t(e){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e){t.next=3;break}return t.next=3,axios.post(n.url.ajax_cancel_interface_gl,a).then((function(t){"S"==t.data.status?(n.interfaceFlag=t.data.interfaceGLFlag,n.$emit("updateInterfaceFlag",{flag:t.data.interfaceGLFlag}),swal({title:'<span style="font-size: 20px;"><strong> ยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',text:'<span style="font-size: 14.5px; text-align: left;"> ทำการยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL เรียบร้อยแล้ว </span>',type:"success",html:!0})):swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.data.msg+"</span>",type:"warning",html:!0})})).catch((function(t){console.log(t),swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.response+"</span>",type:"warning",html:!0})})).then((function(){n.isLoading=!1}));case 3:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}());case 3:case"end":return e.stop()}}),e)})))()}}};var p=a(51900);const m=(0,p.Z)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("form",{attrs:{id:"stamp-adjust",action:t.url.search}},[a("div",[a("div",{staticClass:"row form-group"},[a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold tw-pt-0 required"},[t._v(" ปีบัญชี ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("ct-el-select",{attrs:{name:"period_year",id:"input_period_year","select-options":t.periodYears,"option-key":"period_year_value","option-value":"period_year_value","option-label":"period_year_label",value:t.paramHeader.period_year,filterable:!0,clearable:!0},on:{onSelected:t.onPeriodYearChanged}})],1)])]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[t._v(" งวดบัญชี ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("input",{attrs:{type:"hidden",name:"period_name"},domProps:{value:t.paramHeader.period_name}}),t._v(" "),a("ct-el-select",{attrs:{name:"period_number",id:"input_period_number","select-options":t.periodNumbers,"option-key":"period_number_value","option-value":"period_number_value","option-label":"period_number_full_label",value:t.paramHeader.period_number,filterable:!0,clearable:!0},on:{onSelected:t.onPeriodNumberChanged}})],1)])]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[t._v(" ตั้งแต่วันที่ ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("p",{staticClass:"col-form-label"},[t._v(" "+t._s(t.paramHeader.start_date_thai?t.paramHeader.start_date_thai:"-")+" ")])])])]),t._v(" "),a("div",{staticClass:"col-md-3"},[a("div",{staticClass:"row"},[a("label",{staticClass:"col-md-4 col-form-label tw-font-bold required"},[t._v(" ถึงวันที่ ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("p",{staticClass:"col-form-label"},[t._v(" "+t._s(t.paramHeader.end_date_thai?t.paramHeader.end_date_thai:"-")+" ")])])])])])]),t._v(" "),a("hr"),t._v(" "),a("div",[a("div",{staticClass:"tw-mb-2",staticStyle:{"text-align":"right"}},[a("button",{staticClass:"btn btn-inline-block btn-sm btn-primary tw-w-40",attrs:{type:"submit",disabled:!t.paramHeader.period_year||!t.paramHeader.period_name}},[a("i",{staticClass:"fa fa-search tw-mr-1"}),t._v(" แสดงข้อมูล \n                ")]),t._v(" "),a("a",{staticClass:"btn btn-inline-block btn-sm btn-white tw-w-40",attrs:{href:t.url.search}},[a("i",{staticClass:"fa fa-times tw-mr-1"}),t._v(" ล้างการค้นหา\n                ")]),t._v(" "),t.interfaceFlag?a("button",{staticClass:"btn btn-inline-block btn-sm btn-danger tw-w-40",attrs:{type:"button",disabled:!t.paramHeader.period_year||!t.paramHeader.period_name},on:{click:function(e){return t.stampCancelInterfaceGL()}}},[a("i",{staticClass:"fa fa-retweet tw-mr-1"}),t._v(" ยกเลิกส่งข้อมูลเข้า GL\n                ")]):a("button",{staticClass:"btn btn-inline-block btn-sm btn-info tw-w-40",attrs:{type:"button",disabled:!t.paramHeader.period_year||!t.paramHeader.period_name||!t.validData},on:{click:function(e){return t.stampInterfaceGL()}}},[a("i",{staticClass:"fa fa-retweet tw-mr-1"}),t._v(" ส่งข้อมูลเข้า GL\n                ")])])])]),t._v(" "),a("loading",{attrs:{active:t.isLoading,"is-full-page":!0},on:{"update:active":function(e){t.isLoading=e}}})],1)}),[],!1,null,null,null).exports;var _=a(80455),f=a.n(_);const v={components:{VueNumeric:f()},props:["line","editFlag","lineStampEdit"],data:function(){return{oldCartonQty:this.line.order_quantity_carton}},mounted:function(){},watch:{editFlag:function(t){0==t&&(this.line.order_quantity_carton=Number(this.oldCartonQty))}},methods:{inputStampCarton:function(){var t=this;Vue.set(t.lineStampEdit,t.line.item_code,Number(t.line.order_quantity_carton))}}};const h=(0,p.Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"text-right"},[t.editFlag?a("vue-numeric",{staticClass:"form-control input-sm text-right",staticStyle:{width:"100%"},attrs:{separator:",",precision:2,minus:!1,min:0,max:99999999999},on:{change:function(e){return t.inputStampCarton()},blur:function(e){return t.inputStampCarton()}},model:{value:t.line.order_quantity_carton,callback:function(e){t.$set(t.line,"order_quantity_carton",e)},expression:"line.order_quantity_carton"}}):a("div",{staticStyle:{width:"100%"}},[t._v(" "+t._s(t._f("number2Digit")(t.line.order_quantity_carton))+" ")])],1)}),[],!1,null,null,null).exports;const g={components:{VueNumeric:f()},props:["line","editFlag","linePriceEdit"],data:function(){return{oldUnitPrice:this.line.unit_price}},mounted:function(){},watch:{editFlag:function(t){0==t&&(this.line.unit_price=Number(this.oldUnitPrice))}},methods:{inputUnitPrice:function(){var t=this;Vue.set(t.linePriceEdit,t.line.item_code,Number(t.line.unit_price))}}};const b=(0,p.Z)(g,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"text-right"},[t.editFlag?a("vue-numeric",{staticClass:"form-control input-sm text-right",staticStyle:{width:"100%"},attrs:{precision:7,minus:!1,min:0,max:999999999999999},on:{change:function(e){return t.inputUnitPrice()},blur:function(e){return t.inputUnitPrice()}},model:{value:t.line.unit_price,callback:function(e){t.$set(t.line,"unit_price",e)},expression:"line.unit_price"}}):a("div",{staticStyle:{width:"100%"}},[t._v(" "+t._s(Number(t.line.unit_price).toFixed(7))+" ")])],1)}),[],!1,null,null,null).exports;function y(t,e,a,n,i,r,s){try{var l=t[r](s),c=l.value}catch(t){return void a(t)}l.done?e(c):Promise.resolve(c).then(n,i)}function x(t){return function(){var e=this,a=arguments;return new Promise((function(n,i){var r=t.apply(e,a);function s(t){y(r,n,i,s,l,"next",t)}function l(t){y(r,n,i,s,l,"throw",t)}s(void 0)}))}}const w={components:{StampCarton:h,UnitPrice:b},props:["stampCigarets","percentCigarets","setupStamps","url","btnTrans","interfaceFlag"],data:function(){return{canEdit:!1,edit_flag:!1,isLoading:!1,valid:!1,lines:this.stampCigarets,percent:this.percentCigarets,lineStampEdit:{},linePriceEdit:{},totalStampAdjByCigarets:[],totalStampAdjAll:0,totalStampCarton:0,totalStampQuantity:0,totalStampAmountPercent:0}},mounted:function(){},computed:{calStampAdjust:function(){var t=this;t.lines.filter((function(e){var a=Number(e.order_quantity_carton)/20;e.stamp_quantity=a;var n=a*e.unit_price;e.stamp_amount=n.toFixed(2),t.setupStamps.filter((function(a){var n=t.setupStamps[0].percent;-1==a.stamp_adj_id?t.percent[a.stamp_adj_id][e.item_code]=e.stamp_amount:t.percent[a.stamp_adj_id][e.item_code]=e.stamp_amount*a.percent/n}))}))},summaryStampCigarets:function(){var t=this,e=[];t.lines.reduce((function(a,n){return t.setupStamps.filter((function(i){a[n.item_code]||(a[n.item_code]={item_code:n.item_code,total:0},e.push(a[n.item_code])),-1!=i.stamp_adj_id&&1!=i.stamp_adj_id&&(a[n.item_code].total+=Number(t.percent[i.stamp_adj_id][n.item_code]))})),a}),{}),t.totalStampAdjByCigarets=e},summaryTotalAll:function(){var t=0;this.totalStampAdjByCigarets.filter((function(e){t+=Number(e.total)})),this.totalStampAdjAll=t},summaryStampCarton:function(){var t=0;this.lines.filter((function(e){t+=Number(e.order_quantity_carton)})),this.totalStampCarton=t},summaryStampQuantity:function(){var t=0;this.lines.filter((function(e){t+=Number(e.stamp_quantity)})),this.totalStampQuantity=t},summaryStampAmountPercent:function(){var t=this,e=[];t.lines.reduce((function(a,n){return t.setupStamps.filter((function(i){a[i.stamp_adj_id]||(a[i.stamp_adj_id]={stamp_adj_id:i.stamp_adj_id,total:0},e.push(a[i.stamp_adj_id])),a[i.stamp_adj_id].total+=Number(t.percent[i.stamp_adj_id][n.item_code])})),a}),{}),t.totalStampAmountPercent=e}},watch:{edit_flag:function(t){0==t&&(this.lineStampEdit={},this.linePriceEdit={})},calStampAdjust:function(t){return t},summaryStampCigarets:function(t){return t},summaryTotalAll:function(t){return t},summaryStampCarton:function(t){return t},summaryStampQuantity:function(t){return t},summaryStampAmountPercent:function(t){return t}},methods:{changeStampData:function(){this.valid=this.edit_flag=!this.edit_flag,this.$emit("validAction",this.valid)},updateChangeInput:function(){var t=this;return x(i().mark((function e(){var a,n;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(n=(a=t).url.update_stamp_adjust,0!=Object.keys(a.lineStampEdit).length||0!=Object.keys(a.linePriceEdit).length){e.next=5;break}return swal({title:"อัพเดทต้นทุนขายแยกแสตมป์และกองทุน",text:'<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดทต้นทุนขายแยกแสตมป์และกองทุน </span>',type:"warning",html:!0}),e.abrupt("return");case 5:swal({html:!0,title:"อัพเดทต้นทุนขายแยกแสตมป์และกองทุน",text:'<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทต้นทุนขายแยกแสตมป์และกองทุน ? </span></h2>',showCancelButton:!0,confirmButtonText:a.btnTrans.ok.text,cancelButtonText:a.btnTrans.cancel.text,confirmButtonClass:a.btnTrans.ok.class+" btn-lg tw-w-25",cancelButtonClass:a.btnTrans.cancel.class+" btn-lg tw-w-25",closeOnConfirm:!1,closeOnCancel:!0,showLoaderOnConfirm:!0},function(){var t=x(i().mark((function t(e){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e){t.next=3;break}return t.next=3,axios.patch(n,{lineStampEdit:a.lineStampEdit,linePriceEdit:a.linePriceEdit}).then((function(t){"S"==t.data.status?(a.lineStampEdit={},a.linePriceEdit={},swal({title:"อัพเดทต้นทุนขายแยกแสตมป์และกองทุน",text:'<span style="font-size: 16px; text-align: left;"> ทำการอัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเรียบร้อยแล้ว </span>',type:"success",html:!0}),window.setTimeout((function(){window.location.reload()}),1e3)):swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.data.msg+"</span>",type:"warning",html:!0})})).catch((function(t){swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.response+"</span>",type:"warning",html:!0})})).then((function(){a.isLoading=!0}));case 3:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}());case 6:case"end":return e.stop()}}),e)})))()},checkCanEdit:function(){c()(this.lines[this.lines.length-1].follow_date).format("YYYY-MM-DD")>c()().format("YYYY-MM-DD")&&(this.canEdit=!0)},editProcess:function(t){this.valid=t,this.$emit("checkStampWorking",{flag:t})}}};function C(t,e,a,n,i,r,s){try{var l=t[r](s),c=l.value}catch(t){return void a(t)}l.done?e(c):Promise.resolve(c).then(n,i)}function S(t){return function(){var e=this,a=arguments;return new Promise((function(n,i){var r=t.apply(e,a);function s(t){C(r,n,i,s,l,"next",t)}function l(t){C(r,n,i,s,l,"throw",t)}s(void 0)}))}}const T={components:{StampCarton:h,UnitPrice:b},props:["stampTobaccos","percentTobaccos","setupStamps","url","btnTrans","interfaceFlag"],data:function(){return{isLoading:!1,edit_flag:!1,valid:!1,canEdit:!1,lines:this.stampTobaccos,percent:this.percentTobaccos,lineStampEdit:{},linePriceEdit:{},totalStampAdjByTobaccos:[],totalStampAdjAll:0,totalStampCarton:0,totalStampQuantity:0,totalStampAmountPercent:0}},mounted:function(){},computed:{calStampAdjust:function(){var t=this;t.lines.filter((function(e){var a=120*Number(e.order_quantity_carton);e.stamp_quantity=a;var n=a*e.unit_price;e.stamp_amount=n.toFixed(2),t.setupStamps.filter((function(a){var n=t.setupStamps[0].percent;-1==a.stamp_adj_id?t.percent[a.stamp_adj_id][e.item_code]=e.stamp_amount:t.percent[a.stamp_adj_id][e.item_code]=e.stamp_amount*a.percent/n}))}))},summaryStampTobaccos:function(){var t=this,e=[];t.lines.reduce((function(a,n){return t.setupStamps.filter((function(i){console.log(n.item_code),a[n.item_code]||(a[n.item_code]={item_code:n.item_code,total:0},e.push(a[n.item_code])),-1!=i.stamp_adj_id&&1!=i.stamp_adj_id&&(a[n.item_code].total+=Number(t.percent[i.stamp_adj_id][n.item_code]))})),a}),{}),t.totalStampAdjByTobaccos=e},summaryTotalAll:function(){var t=0;this.totalStampAdjByTobaccos.filter((function(e){t+=Number(e.total)})),this.totalStampAdjAll=t},summaryStampCarton:function(){var t=0;this.lines.filter((function(e){t+=Number(e.order_quantity_carton)})),this.totalStampCarton=t},summaryStampQuantity:function(){var t=0;this.lines.filter((function(e){t+=Number(e.stamp_quantity)})),this.totalStampQuantity=t},summaryStampAmountPercent:function(){var t=this,e=[];t.lines.reduce((function(a,n){return t.setupStamps.filter((function(i){a[i.stamp_adj_id]||(a[i.stamp_adj_id]={stamp_adj_id:i.stamp_adj_id,total:0},e.push(a[i.stamp_adj_id])),a[i.stamp_adj_id].total+=Number(t.percent[i.stamp_adj_id][n.item_code])})),a}),{}),t.totalStampAmountPercent=e}},watch:{edit_flag:function(t){0==t&&(this.lineWeeklyDailyEdit={},this.lineRollDailyEdit={})},calStampAdjust:function(t){return t},summaryStampTobaccos:function(t){return t},summaryTotalAll:function(t){return t},summaryStampCarton:function(t){return t},summaryStampQuantity:function(t){return t},summaryStampAmountPercent:function(t){return t}},methods:{changeStampData:function(){this.valid=this.edit_flag=!this.edit_flag,this.$emit("validAction",this.valid)},updateChangeInput:function(){var t=this;return S(i().mark((function e(){var a,n;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(n=(a=t).url.update_stamp_adjust,0!=Object.keys(a.lineStampEdit).length||0!=Object.keys(a.linePriceEdit).length){e.next=5;break}return swal({title:"อัพเดทต้นทุนขายแยกแสตมป์และกองทุน",text:'<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดทต้นทุนขายแยกแสตมป์และกองทุน </span>',type:"warning",html:!0}),e.abrupt("return");case 5:swal({html:!0,title:"อัพเดทต้นทุนขายแยกแสตมป์และกองทุน",text:'<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทต้นทุนขายแยกแสตมป์และกองทุน ? </span></h2>',showCancelButton:!0,confirmButtonText:a.btnTrans.ok.text,cancelButtonText:a.btnTrans.cancel.text,confirmButtonClass:a.btnTrans.ok.class+" btn-lg tw-w-25",cancelButtonClass:a.btnTrans.cancel.class+" btn-lg tw-w-25",closeOnConfirm:!1,closeOnCancel:!0,showLoaderOnConfirm:!0},function(){var t=S(i().mark((function t(e){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e){t.next=5;break}return a.isLoading=!0,a.valid=!1,t.next=5,axios.patch(n,{lineStampEdit:a.lineStampEdit,linePriceEdit:a.linePriceEdit}).then((function(t){"S"==t.data.status?(swal({title:"อัพเดทต้นทุนขายแยกแสตมป์และกองทุน",text:'<span style="font-size: 16px; text-align: left;"> ทำการอัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเรียบร้อยแล้ว </span>',type:"success",html:!0}),window.setTimeout((function(){window.location.reload()}),1e3)):(ห,swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.data.msg+"</span>",type:"warning",html:!0}))})).catch((function(t){swal({title:"มีข้อผิดพลาด",text:'<span style="font-size: 15px; text-align: left;">'+t.response+"</span>",type:"warning",html:!0})})).then((function(){a.isLoading=!0}));case 5:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}());case 6:case"end":return e.stop()}}),e)})))()},checkCanEdit:function(){c()(this.lines[this.lines.length-1].follow_date).format("YYYY-MM-DD")>c()().format("YYYY-MM-DD")&&(this.canEdit=!0)},editProcess:function(t){this.valid=t,this.$emit("checkStampWorking",{flag:t})}}};const k={components:{StampCigaretTable:(0,p.Z)(w,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.lines?a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4 offset-md-8 text-right"},[t.edit_flag||t.interfaceFlag?t._e():a("button",{class:t.btnTrans.edit.class+" btn-sm tw-w-25",on:{click:function(e){return t.editProcess(t.edit_flag=!t.edit_flag)}}},[a("i",{class:t.btnTrans.edit.icon}),t._v(" "+t._s(t.btnTrans.edit.text)+"\n            ")]),t._v(" "),t.edit_flag?a("button",{class:t.btnTrans.save.class+" btn-sm tw-w-25",on:{click:function(e){return e.preventDefault(),t.updateChangeInput()}}},[a("i",{class:t.btnTrans.save.icon}),t._v(" "+t._s(t.btnTrans.save.text)+"\n            ")]):t._e(),t._v(" "),t.edit_flag?a("button",{class:t.btnTrans.cancel.class+" btn-sm tw-w-25",on:{click:function(e){return t.editProcess(t.edit_flag=!t.edit_flag)}}},[a("i",{class:t.btnTrans.cancel.icon}),t._v(" "+t._s(t.btnTrans.cancel.text)+"\n            ")]):t._e()]),t._v(" "),a("div",{staticClass:"hr-line-dashed"})]):t._e(),t._v(" "),a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-bordered"},[a("thead",[a("tr",[t._m(0),t._v(" "),t._m(1),t._v(" "),t._m(2),t._v(" "),t._m(3),t._v(" "),t._m(4),t._v(" "),t._l(t.setupStamps,(function(e){return["total"==e.fund_location?a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" "+t._s(e.percent)+"% "),a("br"),t._v(" แสตมป์รวมกองทุน ")])]):a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" "+t._s(e.percent)+"% "),a("br"),t._v(" "+t._s(e.fund_location)+" ")])])]})),t._v(" "),t._m(5)],2)]),t._v(" "),a("tbody",[t.lines.length<=0?[t._m(6)]:[t._l(t.lines,(function(e,n){return[a("tr",[a("td",{staticClass:"text-center"},[a("div",{staticStyle:{width:"100px"}},[t._v(" "+t._s(e.item_code)+" ")])]),t._v(" "),a("td",{staticClass:"text-left"},[a("div",{staticStyle:{width:"200px"}},[t._v(" "+t._s(e.item_description)+" ")])]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[a("stamp-carton",{staticStyle:{width:"150px"},attrs:{line:e,"edit-flag":t.edit_flag,"can-edit":t.canEdit,"line-stamp-edit":t.lineStampEdit}})],1)]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[t._v(" "+t._s(t._f("number0Digit")(e.stamp_quantity))+" ")])]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[a("unit-price",{staticStyle:{width:"150px"},attrs:{line:e,"edit-flag":t.edit_flag,"can-edit":t.canEdit,"line-price-edit":t.linePriceEdit}})],1)]),t._v(" "),t._l(t.setupStamps,(function(n){return[a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[t._v(" "+t._s(t._f("number2Digit")(t.percent[n.stamp_adj_id][e.item_code]))+" ")])])]})),t._v(" "),a("td",{staticClass:"text-right"},[t._l(t.totalStampAdjByCigarets,(function(n){return[e.item_code==n.item_code?[a("div",{staticStyle:{width:"150px"}},[t._v(" "+t._s(t._f("number2Digit")(n.total))+" ")])]:t._e()]}))],2)],2)]})),t._v(" "),a("tr",[t._m(7),t._v(" "),a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                "+t._s(t._f("number2Digit")(t.totalStampCarton))+"\n                            ")])]),t._v(" "),a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                "+t._s(t._f("number0Digit")(t.totalStampQuantity))+"\n                            ")])]),t._v(" "),t._m(8),t._v(" "),t._l(t.setupStamps,(function(e){return[a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[t._l(t.totalStampAmountPercent,(function(n){return[n.stamp_adj_id==e.stamp_adj_id?[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                            "+t._s(t._f("number2Digit")(n.total))+"\n                                        ")])]:t._e()]}))],2)]})),t._v(" "),a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                "+t._s(t._f("number2Digit")(t.totalStampAdjAll))+"\n                            ")])])],2)]],2)])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" รหัสบุหรี่ ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ตราบุหรี่ ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ปริมาณจำหน่าย "),a("br"),t._v(" (มวน) ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ปริมาณแสตมป์ "),a("br"),t._v(" (ดวง) ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ราคาแสตมป์ต่อดวง ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" รวมกองทุน ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"},attrs:{colspan:"17"}},[a("h2",[t._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"},attrs:{colspan:"2"}},[a("strong",[t._v(" รวม ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v(" - ")])])}],!1,null,null,null).exports,StampTobaccoTable:(0,p.Z)(T,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.lines?a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-4 offset-md-8 text-right"},[t.edit_flag||t.interfaceFlag?t._e():a("button",{class:t.btnTrans.edit.class+" btn-sm tw-w-25",on:{click:function(e){return t.editProcess(t.edit_flag=!t.edit_flag)}}},[a("i",{class:t.btnTrans.edit.icon}),t._v(" "+t._s(t.btnTrans.edit.text)+"\n            ")]),t._v(" "),t.edit_flag?a("button",{class:t.btnTrans.save.class+" btn-sm tw-w-25",on:{click:function(e){return e.preventDefault(),t.updateChangeInput()}}},[a("i",{class:t.btnTrans.save.icon}),t._v(" "+t._s(t.btnTrans.save.text)+"\n            ")]):t._e(),t._v(" "),t.edit_flag?a("button",{class:t.btnTrans.cancel.class+" btn-sm tw-w-25",on:{click:function(e){return t.editProcess(t.edit_flag=!t.edit_flag)}}},[a("i",{class:t.btnTrans.cancel.icon}),t._v(" "+t._s(t.btnTrans.cancel.text)+"\n            ")]):t._e()]),t._v(" "),a("div",{staticClass:"hr-line-dashed"})]):t._e(),t._v(" "),a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-bordered"},[a("thead",[a("tr",[t._m(0),t._v(" "),t._m(1),t._v(" "),t._m(2),t._v(" "),t._m(3),t._v(" "),t._m(4),t._v(" "),t._l(t.setupStamps,(function(e){return["total"==e.fund_location?a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" "+t._s(e.percent)+"% "),a("br"),t._v(" แสตมป์รวมกองทุน ")])]):a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" "+t._s(e.percent)+"% "),a("br"),t._v(" "+t._s(e.fund_location)+" ")])])]})),t._v(" "),t._m(5)],2)]),t._v(" "),a("tbody",[t.lines.length<=0?[t._m(6)]:[t._l(t.lines,(function(e,n){return[a("tr",[a("td",{staticClass:"text-center"},[a("div",{staticStyle:{width:"100px"}},[t._v(" "+t._s(e.item_code)+" ")])]),t._v(" "),a("td",{staticClass:"text-left"},[a("div",{staticStyle:{width:"200px"}},[t._v(" "+t._s(e.item_description)+" ")])]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[a("stamp-carton",{staticStyle:{width:"150px"},attrs:{line:e,"edit-flag":t.edit_flag,"line-stamp-edit":t.lineStampEdit}})],1)]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[t._v(" "+t._s(t._f("number0Digit")(e.stamp_quantity))+" ")])]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[a("unit-price",{staticStyle:{width:"150px"},attrs:{line:e,"edit-flag":t.edit_flag,"line-price-edit":t.linePriceEdit}})],1)]),t._v(" "),t._l(t.setupStamps,(function(n){return[a("td",{staticClass:"text-right"},[a("div",{staticStyle:{width:"150px"}},[t._v(" "+t._s(t._f("number2Digit")(t.percent[n.stamp_adj_id][e.item_code]))+" ")])])]})),t._v(" "),a("td",{staticClass:"text-right"},[t._l(t.totalStampAdjByTobaccos,(function(n){return[e.item_code==n.item_code?[a("div",{staticStyle:{width:"150px"}},[t._v(" "+t._s(t._f("number2Digit")(n.total))+" ")])]:t._e()]}))],2)],2)]})),t._v(" "),a("tr",[t._m(7),t._v(" "),a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                "+t._s(t._f("number2Digit")(t.totalStampCarton))+"\n                            ")])]),t._v(" "),a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                "+t._s(t._f("number0Digit")(t.totalStampQuantity))+"\n                            ")])]),t._v(" "),t._m(8),t._v(" "),t._l(t.setupStamps,(function(e){return[a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[t._l(t.totalStampAmountPercent,(function(n){return[n.stamp_adj_id==e.stamp_adj_id?[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                            "+t._s(t._f("number2Digit")(n.total))+"\n                                        ")])]:t._e()]}))],2)]})),t._v(" "),a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v("\n                                "+t._s(t._f("number2Digit")(t.totalStampAdjAll))+"\n                            ")])])],2)]],2)])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" รหัสยาเส้น ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ตรายาเส้นไม่ปรุง ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ปริมาณจำหน่าย "),a("br"),t._v(" (หีบ) ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ปริมาณแสตมป์ "),a("br"),t._v(" (ดวง) ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" ราคาแสตมป์ต่อดวง ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("th",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("div",[t._v(" รวมกองทุน ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"},attrs:{colspan:"17"}},[a("h2",[t._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"},attrs:{colspan:"2"}},[a("strong",[t._v(" รวม ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle","background-color":"#70d200"}},[a("div",{staticClass:"tw-font-bold text-right",staticStyle:{width:"100%"}},[t._v(" - ")])])}],!1,null,null,null).exports},props:["stampCigarets","percentCigarets","stampTobaccos","percentTobaccos","setupStamps","setupTobaccos","url","btnTrans","interfaceGlFlag"],data:function(){return{valid:!1,interfaceFlag:this.interfaceGlFlag}},watch:{interfaceGlFlag:function(t){this.interfaceFlag=t}},methods:{checkStampWorking:function(t){this.valid=t.flag}}};const E={components:{HeaderDetail:m,StampAdjust:(0,p.Z)(k,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"tabs-container mb-3"},[a("ul",{staticClass:"nav nav-tabs",attrs:{role:"tablist"}},[a("li",[a("a",{class:t.valid?"nav-link active disabled":"nav-link active",attrs:{"data-toggle":"tab",href:"#tab1"}},[t._v("\n                    บุหรี่\n                ")])]),t._v(" "),a("li",[a("a",{class:t.valid?"nav-link disabled":"nav-link",attrs:{"data-toggle":"tab",href:"#tab2"}},[t._v("\n                    ยาเส้น\n                ")])])]),t._v(" "),a("div",{directives:[{name:"loading",rawName:"v-loading"}],staticClass:"tab-content"},[a("div",{staticClass:"tab-pane active",attrs:{role:"tabpanel",id:"tab1"}},[a("div",{staticClass:"panel-body"},[t.stampCigarets.length>0?a("div",[a("stamp-cigaret-table",{attrs:{stampCigarets:t.stampCigarets,percentCigarets:t.percentCigarets,setupStamps:t.setupStamps,url:t.url,btnTrans:t.btnTrans,interfaceFlag:t.interfaceFlag},on:{checkStampWorking:t.checkStampWorking}})],1):t._e()])]),t._v(" "),a("div",{staticClass:"tab-pane",attrs:{role:"tabpanel",id:"tab2"}},[a("div",{staticClass:"panel-body "},[t.stampTobaccos.length>0?a("div",[a("stamp-tobacco-table",{attrs:{stampTobaccos:t.stampTobaccos,percentTobaccos:t.percentTobaccos,setupStamps:t.setupTobaccos,url:t.url,btnTrans:t.btnTrans,interfaceFlag:t.interfaceFlag},on:{checkStampWorking:t.checkStampWorking}})],1):t._e()])])])])])}),[],!1,null,null,null).exports},props:["stampCigarets","percentCigarets","stampTobaccos","percentTobaccos","setupStamps","setupTobaccos","periodYears","periodYearValue","periodNameValue","url","btnTrans","interfaceGlFlag"],data:function(){return{stamp_main:this.header,loading:!1,interfaceFlag:this.interfaceGlFlag}},methods:{updateInterfaceFlag:function(t){this.interfaceFlag=t.flag}}};const P=(0,p.Z)(E,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[a("div",{staticClass:"mb-3 mt-2"},[a("div",{staticClass:"card-body"},[a("header-detail",{attrs:{periodYears:t.periodYears,periodYearValue:t.periodYearValue,periodNameValue:t.periodNameValue,url:t.url,btnTrans:t.btnTrans,interfaceGlFlag:t.interfaceFlag,validData:t.stampCigarets.length>0||t.stampTobaccos.length>0},on:{updateInterfaceFlag:t.updateInterfaceFlag}})],1)]),t._v(" "),t.stampCigarets.length>0||t.stampTobaccos.length>0?a("stamp-adjust",{attrs:{setupStamps:t.setupStamps,stampCigarets:t.stampCigarets,percentCigarets:t.percentCigarets,setupTobaccos:t.setupTobaccos,stampTobaccos:t.stampTobaccos,percentTobaccos:t.percentTobaccos,url:t.url,btnTrans:t.btnTrans,interfaceGlFlag:t.interfaceFlag}}):t._e()],1)}),[],!1,null,null,null).exports}}]);