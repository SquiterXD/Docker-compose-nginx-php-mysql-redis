(self.webpackChunk=self.webpackChunk||[]).push([[3196],{83196:(e,r,a)=>{"use strict";a.r(r),a.d(r,{default:()=>c});var t=a(87757),n=a.n(t),o=a(30381),s=a.n(o);function l(e,r,a,t,n,o,s){try{var l=e[o](s),i=l.value}catch(e){return void a(e)}l.done?r(i):Promise.resolve(i).then(t,n)}function i(e){return function(){var r=this,a=arguments;return new Promise((function(t,n){var o=e.apply(r,a);function s(e){l(o,t,n,s,i,"next",e)}function i(e){l(o,t,n,s,i,"throw",e)}s(void 0)}))}}const u={props:["search_data","trans_btn"],data:function(){return{loading:!1,inputParams:{order_number_list:[],sa_number_list:[],pi_number_list:[],invoice_no_list:[],customer_list:[]},form:{order_number:null,sa_number:null,pi_number:null,invoice_no:null,customer_id:null,total_fine_due:null,due_date:null,fine_flag:null,country_name:null},check_search:!0}},mounted:function(){this.autoLoad()},methods:{autoLoad:function(){var e=this;return i(n().mark((function r(){var a;return n().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:(a=e).form.order_number=""!=a.search_data.order_number?a.search_data.order_number:null,a.form.sa_number=""!=a.search_data.sa_number?a.search_data.sa_number:null,a.form.pi_number=""!=a.search_data.pi_number?a.search_data.pi_number:null,a.form.invoice_no=""!=a.search_data.invoice_no?a.search_data.invoice_no:null,a.form.customer_id=a.search_data.customer_id?Number(a.search_data.customer_id):null,a.form.total_fine_due=a.search_data.check_search?a.search_data.total_fine_due:s()(new Date).format("DD-MM-YYYY"),a.form.due_date=""!=a.search_data.due_date?a.search_data.due_date:null,a.form.fine_flag=!!a.search_data.fine_flag,a.getParam();case 2:case"end":return r.stop()}}),r)})))()},searchForm:function(){return i(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:$("#searchForm").submit();case 1:case"end":return e.stop()}}),e)})))()},clearForm:function(){var e=this;return i(n().mark((function r(){return n().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:e.form.order_number=null,e.form.sa_number=null,e.form.pi_number=null,e.form.invoice_no=null,e.form.customer_id=null,e.getParam();case 6:case"end":return r.stop()}}),r)})))()},getParam:function(){var e=this;return i(n().mark((function r(){var a,t;return n().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:(a=e).loading=!0,t={action:"search_get_param",order_number:a.form.order_number,sa_number:a.form.sa_number,pi_number:a.form.pi_number,invoice_no:a.form.invoice_no,customer_id:a.form.customer_id},axios.get(a.search_data.search_url,{params:t}).then((function(e){var r=e.data;a.loading=!1,a.inputParams.order_number_list=r.order_number_list,a.inputParams.sa_number_list=r.sa_number_list,a.inputParams.pi_number_list=r.pi_number_list,a.inputParams.invoice_no_list=r.invoice_no_list,a.inputParams.customer_list=r.customer_list}));case 4:case"end":return r.stop()}}),r)})))()},sortArrays:function(e){return _.orderBy(e,"value","asc")},getCustomerDetail:function(){var e=this;return i(n().mark((function r(){return n().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:e.form.country_name="",e.selectedData=e.inputParams.customer_list.find((function(r){return r.customer_id==e.form.customer_id})),e.selectedData&&(e.form.country_name=e.selectedData.country_name);case 3:case"end":return r.stop()}}),r)})))()}}};const c=(0,a(51900).Z)(u,(function(){var e=this,r=e.$createElement,a=e._self._c||r;return a("form",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],attrs:{action:e.search_data.search_url,id:"searchForm"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-1"}),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" วันที่สิ้นสุดการคำนวณ ")]),e._v(" "),a("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date",placeholder:"วันที่สิ้นสุดการคำนวณ",name:"total_fine_due",format:"dd/MM/yyyy","value-format":"dd-MM-yyyy"},model:{value:e.form.total_fine_due,callback:function(r){e.$set(e.form,"total_fine_due",r)},expression:"form.total_fine_due"}})],1),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" เลขที่ใบสั่งซื้อ ")]),e._v(" "),a("el-select",{staticClass:"required w-100",attrs:{placeholder:"เลขที่ใบสั่งซื้อ",filterable:"",remote:"","reserve-keyword":"",clearable:"",value:e.form.order_number},on:{change:function(r){e.form.order_number=r,e.getParam()}}},e._l(e.sortArrays(e.inputParams.order_number_list),(function(e){return a("el-option",{key:e.value,attrs:{label:e.value,value:e.value}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-3"},[a("label",[e._v(" แสดงเฉพาะรายการที่มีค่าปรับ เท่านั้น ")]),a("br"),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.form.fine_flag,expression:"form.fine_flag"}],attrs:{type:"checkbox",name:"fine_flag"},domProps:{checked:Array.isArray(e.form.fine_flag)?e._i(e.form.fine_flag,null)>-1:e.form.fine_flag},on:{change:function(r){var a=e.form.fine_flag,t=r.target,n=!!t.checked;if(Array.isArray(a)){var o=e._i(a,null);t.checked?o<0&&e.$set(e.form,"fine_flag",a.concat([null])):o>-1&&e.$set(e.form,"fine_flag",a.slice(0,o).concat(a.slice(o+1)))}else e.$set(e.form,"fine_flag",n)}}})])]),e._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" เลขที่ใบ SA ")]),e._v(" "),a("el-select",{staticClass:"required w-100",attrs:{placeholder:"เลขที่ใบ SA",filterable:"",remote:"","reserve-keyword":"",clearable:"",value:e.form.sa_number},on:{change:function(r){e.form.sa_number=r,e.getParam()}}},e._l(e.sortArrays(e.inputParams.sa_number_list),(function(e){return a("el-option",{key:e.value,attrs:{label:e.value,value:e.value}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" วันครบกำหนดชำระ ")]),e._v(" "),a("el-date-picker",{staticStyle:{width:"100%"},attrs:{type:"date",placeholder:"วันครบกำหนดชำระ",name:"due_date",format:"dd/MM/yyyy","value-format":"dd-MM-yyyy"},model:{value:e.form.due_date,callback:function(r){e.$set(e.form,"due_date",r)},expression:"form.due_date"}})],1)]),e._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" เลขที่ใบ PI ")]),e._v(" "),a("el-select",{staticClass:"required w-100",attrs:{placeholder:"เลขที่ใบ PI",filterable:"",remote:"","reserve-keyword":"",clearable:"",value:e.form.pi_number},on:{change:function(r){e.form.pi_number=r,e.getParam()}}},e._l(e.sortArrays(e.inputParams.pi_number_list),(function(e){return a("el-option",{key:e.value,attrs:{label:e.value,value:e.value}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" เลขที่ Invoice ")]),e._v(" "),a("el-select",{staticClass:"required w-100",attrs:{placeholder:"เลขที่ Invoice",filterable:"",remote:"","reserve-keyword":"",clearable:"",value:e.form.invoice_no},on:{change:function(r){e.form.invoice_no=r,e.getParam()}}},e._l(e.sortArrays(e.inputParams.invoice_no_list),(function(e){return a("el-option",{key:e.value,attrs:{label:e.value,value:e.value}})})),1)],1)]),e._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-1"}),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" ลูกค้า ")]),e._v(" "),a("el-select",{staticClass:"required w-100",attrs:{placeholder:"ลูกค้า",filterable:"",remote:"","reserve-keyword":"",clearable:"",value:e.form.customer_id},on:{change:function(r){e.form.customer_id=r,e.getParam(),e.getCustomerDetail()}}},e._l(e.inputParams.customer_list,(function(e){return a("el-option",{key:e.customer_id,attrs:{label:e.customer_number+" : "+e.customer_name,value:e.customer_id}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-4"},[a("label",[e._v(" ประเทศ ")]),e._v(" "),a("el-input",{attrs:{disabled:""},model:{value:e.form.country_name,callback:function(r){e.$set(e.form,"country_name",r)},expression:"form.country_name"}})],1)]),e._v(" "),a("div",{staticClass:"row mt-2"},[a("div",{staticClass:"col-md-12 text-center"},[a("label",[e._v(" ")]),e._v(" "),a("div",[a("button",{staticClass:"btn btn-sm btn-default",attrs:{type:"button"},on:{click:e.searchForm}},[e._v("\n                    คำนวณค่าปรับ\n                ")]),e._v(" "),a("a",{staticClass:"btn btn-sm btn-warning",attrs:{href:this.search_data.search_url,type:"button"}},[a("i",{staticClass:"fa fa-undo"}),e._v(" ล้างข้อมูล ")])])])]),e._v(" "),a("input",{attrs:{type:"hidden",name:"order_number"},domProps:{value:e.form.order_number}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"sa_number"},domProps:{value:e.form.sa_number}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"pi_number"},domProps:{value:e.form.pi_number}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"invoice_no"},domProps:{value:e.form.invoice_no}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"customer_id"},domProps:{value:e.form.customer_id}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"check_search"},domProps:{value:e.check_search}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"due_date"},domProps:{value:e.form.due_date}}),e._v(" "),a("input",{attrs:{type:"hidden",name:"total_fine_due"},domProps:{value:e.form.total_fine_due}})])}),[],!1,null,null,null).exports}}]);