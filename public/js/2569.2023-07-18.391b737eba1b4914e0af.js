(self.webpackChunk=self.webpackChunk||[]).push([[2569],{93186:(e,t,n)=>{"use strict";n.d(t,{Z:()=>o});var r=n(23645),i=n.n(r)()((function(e){return e[1]}));i.push([e.id,".mx-datepicker{height:32px}",""]);const o=i},62569:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>p});var r=n(87757),i=n.n(r),o=n(30381),a=n.n(o);function s(e,t,n,r,i,o,a){try{var s=e[o](a),u=s.value}catch(e){return void n(e)}s.done?t(u):Promise.resolve(u).then(r,i)}const u={props:["url-return"],data:function(){return{budget_year:"",loading:!1,periodLists:[]}},methods:{onlyNumeric:function(){this.budget_year=this.budget_year.replace(/[^0-9 .]/g,"")},fromDateWasSelected:function(e){this.budget_year=a()(e).format("DD/MM/YYYY")},getValueStYear:function(e){console.log("getValueStYear ---- "+e),this.budget_year=e},findPeriod:function(e){var t,n=this;return(t=i().mark((function t(){var r;return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(r=$("#fund-form"),$(r).find("div[id='el_explode_period']").html(""),$(r).find("div[id='el_explode_segment']").html(""),n.loading=!0,n.periodLists=[],!n.budget_year){t.next=10;break}return t.next=8,axios.get("/om/ajax/get-order",{params:{budget_year:n.budget_year,query:e}}).then((function(e){if(e.data.message){var t=e.data;swal({title:"มีข้อผิดพลาด",text:t.message,type:"error"})}else n.periodLists=e.data;console.log(e)})).catch((function(e){n.periodLists=[];var t=e.response.data;swal({title:"มีข้อผิดพลาด",text:t.message,type:"error"})})).then((function(){n.loading=!1}));case 8:t.next=12;break;case 10:swal({title:"มีข้อผิดพลาด",text:"โปรดใส่ปีงบประมาณ",type:"error"}),n.loading=!1;case 12:case"end":return t.stop()}}),t)})),function(){var e=this,n=arguments;return new Promise((function(r,i){var o=t.apply(e,n);function a(e){s(o,r,i,a,u,"next",e)}function u(e){s(o,r,i,a,u,"throw",e)}a(void 0)}))})()},save:function(){var e=this;console.log("xxxxxxx"),this.loading=!0,axios.post("/om/settings/order-period",{budget_year:this.budget_year,periodLists:this.periodLists}).then((function(e){alert("complete")})).then((function(t){window.location.href=e.urlReturn})).catch((function(e){alert(e)}))}}};var d=n(93379),l=n.n(d),c=n(93186),f={insert:"head",singleton:!1};l()(c.Z,f);c.Z.locals;const p=(0,n(51900).Z)(u,undefined,undefined,!1,null,null,null).exports}}]);