(self.webpackChunk=self.webpackChunk||[]).push([[1776],{81776:(t,r,o)=>{"use strict";o.r(r),o.d(r,{default:()=>u});const e={props:["pMachineGroup","pTotalProductArr","pResPlanDate"],data:function(){return{machineGroup:this.pMachineGroup,productArr:this.pTotalProductArr,resPlanDate:this.pResPlanDate,totalEffProductByGroup:0}},mounted:function(){},watch:{effProductByGroup:function(t){return t}},computed:{effProductByGroup:function(){var t=this,r=0;t.resPlanDate.filter((function(o){t.pTotalProductArr[t.machineGroup+o.res_plan_date_display]&&(r+=Number(t.productArr[t.machineGroup+o.res_plan_date_display][0].total.toFixed(3)))})),t.totalEffProductByGroup=r.toFixed(3)}}};const u=(0,o(51900).Z)(e,(function(){var t=this,r=t.$createElement,o=t._self._c||r;return o("div",[o("span",[t._v(" "+t._s(t.totalEffProductByGroup)+" ")])])}),[],!1,null,null,null).exports}}]);