(self.webpackChunk=self.webpackChunk||[]).push([[7935],{77935:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>s});var i=n(87757),a=n.n(i);n(30381);function r(e,t,n,i,a,r,o){try{var c=e[r](o),s=c.value}catch(e){return void n(e)}c.done?t(s):Promise.resolve(s).then(i,a)}function o(e){return function(){var t=this,n=arguments;return new Promise((function(i,a){var o=e.apply(t,n);function c(e){r(o,i,a,c,s,"next",e)}function s(e){r(o,i,a,c,s,"throw",e)}c(void 0)}))}}const c={props:["customers","invoices","customerSearch","dueDateSearch","invoiceNoSearch","fineFlagSearch","totalFineDueSearch","invoiceDateSearch"],data:function(){return{total_fine_due:"",due_date:this.dueDateSearch?this.dueDateSearch:"",fine_flag:!this.fineFlagSearch||"Y"==this.fineFlagSearch,invoice_no:this.invoiceNoSearch?this.invoiceNoSearch:"",invoice_date:this.invoiceDateSearch?this.invoiceDateSearch:"",customer_id:this.customerSearch?Number(this.customerSearch):"",province_name:"",cancel_flag:"",checkCustomer:!!this.customer,invoiceDateDisabled:!1,lists:[],invoiceLists:this.invoices,customerLists:this.customers}},mounted:function(){this.showDate(),this.customer_id&&this.getCustomerDetail(),this.invoice_no&&this.getInvoiceDetail()},methods:{sortArrays:function(e){return _.orderBy(e,"invoice_no","asc")},showDate:function(){var e=this;return o(a().mark((function t(){var n,i,r;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.due_date){t.next=5;break}return t.next=3,helperDate.parseToDateTh(e.due_date,"yyyy/MM/DD");case 3:n=t.sent,e.due_date=n;case 5:if(!e.totalFineDueSearch){t.next=12;break}return t.next=8,helperDate.parseToDateTh(e.totalFineDueSearch,"yyyy/MM/DD");case 8:i=t.sent,e.total_fine_due=i,t.next=16;break;case 12:return t.next=14,helperDate.parseToDateTh(new Date,"yyyy/MM/DD");case 14:r=t.sent,e.total_fine_due=r;case 16:if(!e.invoice_date){t.next=21;break}return t.next=19,helperDate.parseToDateTh(e.invoice_date,"yyyy/MM/DD");case 19:n=t.sent,e.invoice_date=n;case 21:case"end":return t.stop()}}),t)})))()},getCustomerDetail:function(){var e=this;return o(a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.province_name="",e.selectedData=e.customerLists.find((function(t){return t.customer_id==e.customer_id})),e.selectedData&&(e.province_name=e.selectedData.province_name);case 3:case"end":return t.stop()}}),t)})))()},getInvoiceDetail:function(){var e=this;return o(a().mark((function t(){var n;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(console.log("getInvoiceDetail <-> ",e.invoice_no),!e.invoice_no){t.next=12;break}if(e.invoiceDateDisabled=!0,e.selectedData=e.invoiceLists.find((function(t){return t.invoice_no==e.invoice_no})),!e.selectedData){t.next=10;break}if(!e.selectedData.invoice_date){t.next=10;break}return t.next=8,helperDate.parseToDateTh(e.selectedData.invoice_date,"yyyy/MM/DD");case 8:n=t.sent,e.invoice_date=n;case 10:t.next=14;break;case 12:e.invoiceDateDisabled=!1,e.invoice_date="";case 14:case"end":return t.stop()}}),t)})))()},onShowDetailClicked:function(){var e=this;return o(a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:console.log("คำนวณค่าปรับ"),e.lists=[],axios.get("/om/ajax/get-fine-list",{params:{total_fine_due:e.total_fine_due,due_date:e.due_date,fine_flag:e.fine_flag,invoice_no:e.invoice_no,invoice_date:e.invoice_date,customer_id:e.customer_id}}).then((function(t){e.lists=t.data}));case 2:case"end":return t.stop()}}),t)})))()},getInvoiceList:function(e){var t=this;return o(a().mark((function n(){return a().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:t.invoiceLists=[],axios.get("/om/ajax/get-invoice-list",{params:{query:e}}).then((function(e){t.invoiceLists=e.data}));case 2:case"end":return n.stop()}}),n)})))()},getCustomerList:function(e){var t=this;return o(a().mark((function n(){return a().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:console.log("getCustomerList"),t.customerLists=[],axios.get("/om/ajax/get-customer-list",{params:{query:e}}).then((function(e){t.customerLists=e.data}));case 3:case"end":return n.stop()}}),n)})))()}}};const s=(0,n(51900).Z)(c,undefined,undefined,!1,null,null,null).exports}}]);