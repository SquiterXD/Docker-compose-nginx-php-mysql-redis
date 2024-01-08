(self.webpackChunk=self.webpackChunk||[]).push([[4810],{17816:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>a});var o=r(23645),s=r.n(o)()((function(e){return e[1]}));s.push([e.id,".error-message[data-v-2432b723]{display:flex;color:#ec4958;margin-top:5px}.error-message strong[data-v-2432b723]{margin-right:5px}.mt-custom__10[data-v-2432b723]{margin-top:10px}.text-title[data-v-2432b723]{font-size:16px;font-weight:600}.btn-info[data-v-2432b723]{background-color:#02b0ef;border-color:#02b0ef}.btn-success[data-v-2432b723]{background-color:#1ab394;border-color:#1ab394}.btn-cancel[data-v-2432b723]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-2432b723]{color:#ec4958}",""]);const a=s},94810:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>c});var o=r(87757),s=r.n(o);function a(e,t,r,o,s,a,n){try{var i=e[a](n),c=i.value}catch(e){return void r(e)}i.done?t(c):Promise.resolve(c).then(o,s)}function n(e){return function(){var t=this,r=arguments;return new Promise((function(o,s){var n=e.apply(t,r);function i(e){a(n,o,s,i,c,"next",e)}function c(e){a(n,o,s,i,c,"throw",e)}i(void 0)}))}}const i={props:["isEdit","taxMedicine"],data:function(){return{loading:!1,form_error:{},form:{},option:{material:[]}}},created:function(){this.getMasterData()},methods:{getMasterData:function(){var e=this;return n(s().mark((function t(){return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.loading=!0,e.getRawMaterail(),e.getDataEdit(),e.loading=!1;case 4:case"end":return t.stop()}}),t)})))()},getDataEdit:function(){if(this.isEdit){var e=this.taxMedicine,t=e.item_number,r=e.code,o=e.name,s=e.tax_medicine_id;this.form={item_number:t,code:r,name:o,tax_medicine_id:s}}},getRawMaterail:function(){var e=this;axios.get("/ct/ajax/get_raw_material").then((function(t){e.option.material=t.data}))},handleSubmit:function(){this.loading=!0,this.isEdit?this.update():this.store()},errorMessage:function(e){var t=this,r=e.errors;r&&(Object.keys(r).forEach((function(e){t.form_error[e]={},t.form_error[e].title=e,t.form_error[e].message=r[e][0]})),this.resetError())},resetError:function(){var e=this;setTimeout((function(){e.form_error={}}),5e3)},update:function(){var e=this;return n(s().mark((function t(){var r;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.taxMedicine.item_number,t.next=3,axios.put("/ct/ajax/tax_medicine/".concat(r),e.form).then((function(t){e.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success",onClose:function(){window.location.href="/ct/tax_medicine"}})})).catch((function(t){e.loading=!1,e.errorMessage(t.response.data),e.$message({showClose:!0,message:"ไม่สามารถบันทึกได้",type:"error"})})).then((function(){e.loading=!1}));case 3:case"end":return t.stop()}}),t)})))()},store:function(){var e=this;return n(s().mark((function t(){return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.post("/ct/ajax/tax_medicine",e.form).then((function(t){e.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success",onClose:function(){window.location.href="/ct/tax_medicine"}})})).catch((function(t){e.loading=!1,e.errorMessage(t.response.data),e.$message({showClose:!0,message:"ไม่สามารถบันทึกได้",type:"error"})})).then((function(){e.loading=!1}));case 2:case"end":return t.stop()}}),t)})))()},refresh:function(){this.form={}}}};r(58078);const c=(0,r(51900).Z)(i,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}]},[r("div",{staticClass:"m-2"},[r("div",{staticClass:"form-group row"},[r("label",{staticClass:"col-md-2 col-form-label"},[e._v("รหัสวัตถุดิบ")]),e._v(" "),r("div",{staticClass:"col-md-4 flex-wrap"},[r("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"รหัสวัตถุดิบ"},model:{value:e.form.item_number,callback:function(t){e.$set(e.form,"item_number",t)},expression:"form.item_number"}},e._l(e.option.material,(function(t,o){return r("el-option",{key:o,attrs:{label:t.item_desc,value:t.item_number}},[r("span",[e._v("\n                            "+e._s(t.item_number+" - "+t.item_desc)+"\n                        ")])])})),1),e._v(" "),e.form_error.item_number?r("div",{staticClass:"error-message"},[r("strong",{staticClass:"font-bold"},[e._v(e._s(e.form_error.item_number.title))]),e._v(" "),r("span",{staticClass:"block sm:inline"},[e._v("\n                        "+e._s(e.form_error.item_number.message)+"\n                    ")])]):e._e()],1)]),e._v(" "),r("div",{staticClass:"form-group row"},[r("label",{staticClass:"col-md-2 col-form-label"},[e._v("รหัสวัตถุดิบ(ภาษี)\n            ")]),e._v(" "),r("div",{staticClass:"col-md-4 flex-wrap"},[r("el-input",{attrs:{placeholder:"ชื่อวัตถุดิบ(ภาษี)"},model:{value:e.form.code,callback:function(t){e.$set(e.form,"code",t)},expression:"form.code"}}),e._v(" "),e.form_error.code?r("div",{staticClass:"error-message"},[r("strong",{staticClass:"font-bold"},[e._v(e._s(e.form_error.code.title))]),e._v(" "),r("span",{staticClass:"block sm:inline"},[e._v("\n                        "+e._s(e.form_error.code.message)+"\n                    ")])]):e._e()],1)]),e._v(" "),r("div",{staticClass:"form-group row"},[r("label",{staticClass:"col-md-2 col-form-label"},[e._v("\n                ชื่อวัตถุดิบ(ภาษี)\n            ")]),e._v(" "),r("div",{staticClass:"col-md-4 flex-wrap"},[r("el-input",{attrs:{placeholder:"ชื่อวัตถุดิบ(ภาษี)"},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}}),e._v(" "),e.form_error.name?r("div",{staticClass:"error-message"},[r("strong",{staticClass:"font-bold"},[e._v(e._s(e.form_error.name.title))]),e._v(" "),r("span",{staticClass:"block sm:inline"},[e._v("\n                        "+e._s(e.form_error.name.message)+"\n                    ")])]):e._e()],1)])]),e._v(" "),r("div",{staticClass:"col-md-12 text-right mt-4 px-0"},[r("el-button",{staticClass:"btn-success",attrs:{type:"success"},on:{click:function(t){return e.handleSubmit()}}},[e._v("\n            ยืนยัน\n        ")]),e._v(" "),r("el-button",{staticClass:"text-refresh",attrs:{type:"text"},nativeOn:{click:function(t){return t.preventDefault(),e.refresh()}}},[e._v("\n            ล้างข้อมูล\n        ")])],1)])}),[],!1,null,"2432b723",null).exports},58078:(e,t,r)=>{var o=r(17816);o.__esModule&&(o=o.default),"string"==typeof o&&(o=[[e.id,o,""]]),o.locals&&(e.exports=o.locals);(0,r(45346).Z)("216e0189",o,!0,{})}}]);