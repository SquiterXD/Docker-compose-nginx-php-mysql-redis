(self.webpackChunk=self.webpackChunk||[]).push([[1293],{51293:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>i});const o={props:["productPeriod","dataMachinePowerTemp","btnTrans","uomList"],data:function(){return{productPeriodShow:this.productPeriod,dataMachinePowerTempShow:this.dataMachinePowerTemp,uom:this.dataMachinePowerTemp?this.dataMachinePowerTemp[0].uom:"",machineId:this.dataMachinePowerTemp?this.dataMachinePowerTemp[0].machine_id:"",machineGroup:this.dataMachinePowerTemp?this.dataMachinePowerTemp[0].machine_group:"",statusBtuSave:!1}},mounted:function(){},methods:{checkValue:function(e,t,a){var o=this;this.dataMachinePowerTemp.forEach((function(t,i){if(a<t.product_time&&a!=t.product_time){if(Number(e)>Number(t.power))return o.showAlert(),void(o.statusBtuSave=!0);o.statusBtuSave=!1}}))},showAlert:function(){swal({title:"Error !",text:"ไม่สามารถกรอกจำนวนเลขนี้ได้",type:"error",showConfirmButton:!0})}}};const i=(0,a(51900).Z)(o,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"col-lg-12"},[a("div",{staticClass:"ibox"},[e._m(0),e._v(" "),a("form",{attrs:{action:"/pm/settings/machine-power-temp/update",method:"get"}},[a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row justify-content-center"},[a("div",{staticClass:"col-md-8"},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.machineId,expression:"machineId"}],attrs:{type:"hidden",name:"machineId"},domProps:{value:e.machineId},on:{input:function(t){t.target.composing||(e.machineId=t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.machineGroup,expression:"machineGroup"}],attrs:{type:"hidden",name:"machineGroup"},domProps:{value:e.machineGroup},on:{input:function(t){t.target.composing||(e.machineGroup=t.target.value)}}}),e._v(" "),e._l(e.productPeriodShow,(function(t,o){return a("div",{key:o},e._l(e.dataMachinePowerTempShow,(function(i,n){return a("div",{key:n},[t.lookup_code==i.product_time?a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px"}},[a("label",[e._v(e._s(t.description))]),a("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:i.power,expression:"value.power"}],attrs:{type:"hidden",name:"power["+[o+1]+"]"},domProps:{value:i.power},on:{input:function(t){t.target.composing||e.$set(i,"power",t.target.value)}}}),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:i.product_time,expression:"value.product_time"}],attrs:{type:"hidden",name:"lookupCode["+[o+1]+"]"},domProps:{value:i.product_time},on:{input:function(t){t.target.composing||e.$set(i,"product_time",t.target.value)}}}),e._v(" "),a("el-input",{attrs:{placeholder:"โปรดกรอกกำลังการผลิต"},on:{change:function(t){return e.checkValue(i.power,i.product_time,o+1)}},model:{value:i.power,callback:function(t){e.$set(i,"power",t)},expression:"value.power"}})],1)])]):e._e()])})),0)})),e._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col",staticStyle:{"padding-top":"15px"}},[a("label",[e._v("หน่วย")]),a("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.uom,expression:"uom"}],attrs:{type:"hidden",name:"uom"},domProps:{value:e.uom},on:{input:function(t){t.target.composing||(e.uom=t.target.value)}}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{placeholder:"เลือก หน่วย",clearable:"",filterable:"",remote:"","reserve-keyword":""},model:{value:e.uom,callback:function(t){e.uom=t},expression:"uom"}},e._l(e.uomList,(function(e,t){return a("el-option",{key:t,attrs:{label:e.unit_of_measure,value:e.uom_code}})})),1)],1)])],2)]),e._v(" "),a("div",{staticClass:"row clearfix text-right"},[a("div",{staticClass:"col",staticStyle:{"margin-top":"15px"}},[a("button",{class:e.btnTrans.save.class,attrs:{type:"submit",disabled:this.statusBtuSave}},[a("i",{class:e.btnTrans.save.icon,attrs:{"aria-hidden":"true"}}),e._v(" "+e._s(e.btnTrans.save.text)+" \n                    ")]),e._v(" "),a("a",{class:e.btnTrans.cancel.class,attrs:{type:"button",href:"/pm/settings/machine-power-temp"}},[a("i",{class:e.btnTrans.cancel.icon,attrs:{"aria-hidden":"true"}}),e._v(" "+e._s(e.btnTrans.cancel.text)+"\n                    ")])])])])])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"ibox-title"},[a("h5",[e._v("แก้ไขบันทึกกำลังผลิตรายเครื่อง")])])}],!1,null,null,null).exports}}]);