(self.webpackChunk=self.webpackChunk||[]).push([[1734],{31734:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>u});var r=a(87757),s=a.n(r),c=a(30381),n=a.n(c);function o(e,t,a,r,s,c,n){try{var o=e[c](n),d=o.value}catch(e){return void a(e)}o.done?t(d):Promise.resolve(d).then(r,s)}function d(e){return function(){var t=this,a=arguments;return new Promise((function(r,s){var c=e.apply(t,a);function n(e){o(c,r,s,n,d,"next",e)}function d(e){o(c,r,s,n,d,"throw",e)}n(void 0)}))}}const i={props:["customers","customer","customerTypes","days","dataSearch","creditGroups"],data:function(){return{customer_id:this.customer?Number(this.customer.customer_id):this.dataSearch.customer_id?Number(this.dataSearch.customer_id):"",customer_name:"",date_selected:"",DataLists:[],isLoading:!1,disabledDateTo:this.date_selected?this.date_selected:null,test:"",checkCustomer:!!this.customer,currentDate:"",customer_type:this.dataSearch.customer_type?this.dataSearch.customer_type:"",weekly_delivery_day:this.dataSearch.weekly_delivery_day?this.dataSearch.weekly_delivery_day:"",check_search:!!this.dataSearch.check_search,credit_group_code:this.dataSearch.credit_group_code?this.dataSearch.credit_group_code:""}},mounted:function(){this.check_search?this.dataSearch.date_selected&&(this.date_selected=this.dataSearch.date_selected,this.showDate()):(this.date_selected=new Date,this.showDate())},methods:{showDate:function(){var e=this;return d(s().mark((function t(){var a;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,helperDate.parseToDateTh(e.date_selected,"yyyy/MM/DD");case 2:a=t.sent,e.date_selected=a,console.log("date1 <--\x3e "+a),console.log("this.date_selected <--\x3e "+e.date_selected);case 6:case"end":return t.stop()}}),t)})))()},getCustomerName:function(){var e=this;return d(s().mark((function t(){return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.customer_name="",e.selectedData=e.customers.find((function(t){return t.customer_id==e.customer_id})),e.selectedData&&(e.customer_name=e.selectedData.customer_name);case 3:case"end":return t.stop()}}),t)})))()},getData:function(){var e=this;return d(s().mark((function t(){return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.isLoading=!0,t.next=3,axios.get("/om/outstanding-list",{params:{customer_id:e.customer_id,date_selected:e.date_selected}}).then((function(t){e.DataLists=t.data,e.isLoading=!1}));case 3:case"end":return t.stop()}}),t)})))()},getYear:function(e){var t=n()(e.order_date).format("YYYY-MM-DD").split("-"),a="";axios.get("/om/outstanding-year",{params:{year:t[0]}}).then((function(e){return console.log("test diff from controller <---\x3e "+e.data),a=e.data,console.log("Calyear <---\x3e "+a),a}))},fromDateWasSelected:function(e){this.disabledDateTo=n()(e).format("DD/MM/YYYY"),this.date_selected=e},formatPrice:function(e){return(e/1).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")},formatDate:function(e){if(e)return n()(e).format("DD/MM/YYYY")},fine:function(e){return(15*e/100/365).toFixed(2)}}};const u=(0,a(51900).Z)(i,undefined,undefined,!1,null,null,null).exports}}]);