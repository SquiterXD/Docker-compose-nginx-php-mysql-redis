(self.webpackChunk=self.webpackChunk||[]).push([[998],{49301:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>n});var a=r(23645),o=r.n(a)()((function(e){return e[1]}));o.push([e.id,".error-message[data-v-467069a2]{display:flex;color:#ec4958;margin-top:5px}.error-message strong[data-v-467069a2]{margin-right:5px}.mt-custom__10[data-v-467069a2]{margin-top:10px}.text-title[data-v-467069a2]{font-size:16px;font-weight:600}.btn-info[data-v-467069a2]{background-color:#02b0ef;border-color:#02b0ef}.btn-success[data-v-467069a2]{background-color:#1ab394;border-color:#1ab394}.btn-cancel[data-v-467069a2]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-467069a2]{color:#ec4958}",""]);const n=o},32604:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>c});var a=r(87757),o=r.n(a);function n(e,t,r,a,o,n,s){try{var i=e[n](s),c=i.value}catch(e){return void r(e)}i.done?t(c):Promise.resolve(c).then(a,o)}function s(e){return function(){var t=this,r=arguments;return new Promise((function(a,o){var s=e.apply(t,r);function i(e){n(s,a,o,i,c,"next",e)}function c(e){n(s,a,o,i,c,"throw",e)}i(void 0)}))}}const i={props:["isEdit","taxMedicine"],data:function(){return{loading:!1,mtrloading:!1,form_error:{},form:{},option:{material:[],materialTax:[]}}},created:function(){this.getMasterData()},methods:{getMasterData:function(){var e=this;return s(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.loading=!0,e.getRawMaterail(),e.loading=!1;case 3:case"end":return t.stop()}}),t)})))()},getRawMaterail:function(){var e=this;axios.get("/ct/ajax/get_raw_material").then((function(t){e.option.material=t.data}))},selMaterial:function(){var e=this,t=this;t.form.tax_item_number="",axios.get("/ct/ajax/get_raw_material_tax?item="+t.form.item_number).then((function(r){"S"==r.data.status?(t.option.materialTax=r.data.materialTax,t.form.tax_item_number=r.data.defaultMaterialTax.item_number):e.$message({showClose:!0,message:r.data.msg,type:"error"})}))},handleSubmit:function(){this.loading=!0,this.isEdit?this.update():this.store()},errorMessage:function(e){var t=this,r=e.errors;r&&(Object.keys(r).forEach((function(e){t.form_error[e]={},t.form_error[e].title=e,t.form_error[e].message=r[e][0]})),this.resetError())},resetError:function(){var e=this;setTimeout((function(){e.form_error={}}),5e3)},update:function(){var e=this;return s(o().mark((function t(){var r;return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.taxMedicine.item_number,t.next=3,axios.put("/ct/ajax/tax_medicine/".concat(r),e.form).then((function(t){e.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success",onClose:function(){window.location.href="/ct/tax_medicine"}})})).catch((function(t){e.loading=!1,e.errorMessage(t.response.data),e.$message({showClose:!0,message:"ไม่สามารถบันทึกได้",type:"error"})})).then((function(){e.loading=!1}));case 3:case"end":return t.stop()}}),t)})))()},store:function(){var e=this;return s(o().mark((function t(){return o().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,t.next=3,axios.post("/ct/ajax/tax_medicine",e.form).then((function(t){e.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success",onClose:function(){window.location.href="/ct/tax_medicine"}})})).catch((function(t){e.loading=!1,e.errorMessage(t.response.data),e.$message({showClose:!0,message:"ไม่สามารถบันทึกได้",type:"error"})})).then((function(){e.loading=!1}));case 3:case"end":return t.stop()}}),t)})))()},refresh:function(){this.form={}}}};r(21289);const c=(0,r(51900).Z)(i,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}]},[r("div",{staticClass:"m-2"},[r("div",{staticClass:"form-group row"},[r("label",{staticClass:"col-md-2 col-form-label"},[e._v("รหัสวัตถุดิบ")]),e._v(" "),r("div",{staticClass:"col-md-4 flex-wrap"},[r("el-select",{staticStyle:{width:"100%"},attrs:{clearable:"",placeholder:"รหัสวัตถุดิบ"},on:{change:e.selMaterial},model:{value:e.form.item_number,callback:function(t){e.$set(e.form,"item_number",t)},expression:"form.item_number"}},e._l(e.option.material,(function(e,t){return r("el-option",{key:t,attrs:{label:e.item_number+" - "+e.item_desc,value:e.item_number}})})),1),e._v(" "),e.form_error.item_number?r("div",{staticClass:"error-message"},[r("strong",{staticClass:"font-bold"},[e._v(e._s(e.form_error.item_number.title))]),e._v(" "),r("span",{staticClass:"block sm:inline"},[e._v("\n                        "+e._s(e.form_error.item_number.message)+"\n                    ")])]):e._e()],1)]),e._v(" "),r("div",{staticClass:"form-group row"},[r("label",{staticClass:"col-md-2 col-form-label"},[e._v(" รหัสวัตถุดิบ(ภาษี) ")]),e._v(" "),r("div",{staticClass:"col-md-4 flex-wrap"},[r("el-select",{staticStyle:{width:"100%"},attrs:{clearable:"",placeholder:"รหัสวัตถุดิบ(ภาษี)"},model:{value:e.form.tax_item_number,callback:function(t){e.$set(e.form,"tax_item_number",t)},expression:"form.tax_item_number"}},e._l(e.option.materialTax,(function(e,t){return r("el-option",{key:t,attrs:{label:e.item_number+" - "+e.item_desc,value:e.item_number}})})),1),e._v(" "),e.form_error.code?r("div",{staticClass:"error-message"},[r("strong",{staticClass:"font-bold"},[e._v(e._s(e.form_error.code.title))]),e._v(" "),r("span",{staticClass:"block sm:inline"},[e._v("\n                        "+e._s(e.form_error.code.message)+"\n                    ")])]):e._e()],1)])]),e._v(" "),r("div",{staticClass:"col-md-12 text-right mt-4 px-0"},[r("el-button",{staticClass:"btn-success",attrs:{type:"success"},on:{click:function(t){return e.handleSubmit()}}},[e._v("\n            ยืนยัน\n        ")]),e._v(" "),r("el-button",{staticClass:"text-refresh",attrs:{type:"text"},nativeOn:{click:function(t){return t.preventDefault(),e.refresh()}}},[e._v("\n            ล้างข้อมูล\n        ")])],1)])}),[],!1,null,"467069a2",null).exports},21289:(e,t,r)=>{var a=r(49301);a.__esModule&&(a=a.default),"string"==typeof a&&(a=[[e.id,a,""]]),a.locals&&(e.exports=a.locals);(0,r(45346).Z)("0b0b2221",a,!0,{})}}]);