(self.webpackChunk=self.webpackChunk||[]).push([[7991],{51585:(t,e,s)=>{"use strict";s.d(e,{Z:()=>n});var a=s(23645),i=s.n(a)()((function(t){return t[1]}));i.push([t.id,".input-label[data-v-6ea0286a]{display:inline-block;width:130px}.btn-success[data-v-6ea0286a]{background-color:#1ab394;border-color:#1ab394}",""]);const n=i},47991:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>h});var a=s(87757),i=s.n(a),n=s(30381),o=s.n(n);function r(t,e,s,a,i,n,o){try{var r=t[n](o),l=r.value}catch(t){return void s(t)}r.done?e(l):Promise.resolve(l).then(a,i)}function l(t,e){var s=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),s.push.apply(s,a)}return s}function d(t){for(var e=1;e<arguments.length;e++){var s=null!=arguments[e]?arguments[e]:{};e%2?l(Object(s),!0).forEach((function(e){c(t,e,s[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(s)):l(Object(s)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(s,e))}))}return t}function c(t,e,s){return e in t?Object.defineProperty(t,e,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[e]=s,t}const u={props:["defaultIssueHeader","copy","department","edit","create"],data:function(){var t,e,s,a,i,n,r,l,c,u,m,f,_,v,h,p,g,b;return{coaDeptCodes:[],secondaryInventory:[],aLiasNames:[],systemItems:[],organizations:[],glCodeCombinations:[],costCenters:[],gl_alias_name:(null===(t=this.defaultIssueHeader)||void 0===t?void 0:t.gl_alias_name)||"",account_combine:(null===(e=this.defaultIssueHeader)||void 0===e?void 0:e.account_code)||"",department_code:(null===(s=this.defaultIssueHeader)||void 0===s?void 0:s.department_code)||"",selectItem:"",form:{issue_header_id:(null===(a=this.defaultIssueHeader)||void 0===a?void 0:a.issue_header_id)||"",issue_number:(null===(i=this.defaultIssueHeader)||void 0===i?void 0:i.issue_number)||"",transaction_date:this.defaultIssueHeader?o()(this.defaultIssueHeader.transaction_date).add(543,"year").format("DD/MM/YYYY"):o()().add(543,"year").format("DD/MM/YYYY"),created_at:this.defaultIssueHeader?o()(this.defaultIssueHeader.created_at).add(543,"year").format("DD/MM/YYYY"):o()().add(543,"year").format("DD/MM/YYYY"),inventory_item_id:(null===(n=this.defaultIssueHeader)||void 0===n?void 0:n.inventory_item_id)||"",description:(null===(r=this.defaultIssueHeader)||void 0===r?void 0:r.description)||"",department_code:(null===(l=this.defaultIssueHeader)||void 0===l?void 0:l.department_code)||"",subinventory_code:(null===(c=this.defaultIssueHeader)||void 0===c?void 0:c.subinventory_code)||"",gl_alias_name:(null===(u=this.defaultIssueHeader)||void 0===u?void 0:u.gl_alias_name)||"",issue_status:"WAITING"==(null===(m=this.defaultIssueHeader)||void 0===m?void 0:m.issue_status)?"รอตัดจ่าย":"APPROVED"==(null===(f=this.defaultIssueHeader)||void 0===f?void 0:f.issue_status)?"ตัดจ่ายสำเร็จ":"CANCELLED"==(null===(_=this.defaultIssueHeader)||void 0===_?void 0:_.issue_status)||"RETURN"==(null===(v=this.defaultIssueHeader)||void 0===v?void 0:v.issue_status)?"ยกเลิก":"DRAFT"==(null===(h=this.defaultIssueHeader)||void 0===h?void 0:h.issue_status)?"ร่างรายการเบิก":"รอตัดจ่าย",account_code:"",organization_id:(null===(p=this.defaultIssueHeader)||void 0===p?void 0:p.organization_id)||"",items:(null===(g=this.defaultIssueHeader)||void 0===g?void 0:g.details.map((function(t){return d(d(d(d({},t),{item:t.inventory_item.segment1}),{primary_unit_of_measure:t.inventory_item.primary_unit_of_measure}),{item_cost:t.transaction_cost})})))||[],cost_center:(null===(b=this.defaultIssueHeader)||void 0===b?void 0:b.acc_segment4)||""},loadingInput:{coaDeptCodes:!1,secondaryInventory:!1,aliasName:!1,systemItem:!1,organization:!1,costCenters:!1},loading:!1}},created:function(){this.getMasterData()},watch:{department_code:function(t){this.gl_alias_name="",this.form.gl_alias_name="",this.account_combine="",this.form.department_code=t,this.form.cost_center="",this.getCostCenters()},gl_alias_name:function(t){if(this.form.gl_alias_name=t,this.aliasNameOnchange(),""!=t){this.department===this.form.department_code&&(this.form.department_code=this.department.department_code);var e=this.form.account_code.split(".");e[2]=this.form.department_code,e[3]=this.form.cost_center;var s=e.join(".");if(!this.glCodeCombinations.find((function(t){return t.concatenated_segments===s})))return this.form.gl_alias_name="",this.gl_alias_name="",alert("ไม่สามารถเพิ่มสินค้าได้เนื่องจากไม่มีเลขทางบัญชีนี้ในระบบ กรุณาติดต่อฝ่ายบัญชี");this.account_combine=s;for(var a=0;a<this.form.items.length;a++)this.form.items[a].transaction_account=s}}},mounted:function(){var t,e=this;return(t=i().mark((function t(){var s;return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(!e.create){t.next=4;break}return t.next=3,e.getCOAsWithDefault(e.department.department_code);case 3:e.department_code=e.department.department_code+"";case 4:if(!e.edit){t.next=9;break}return s=e.defaultIssueHeader.department_code,t.next=8,e.getCOAsWithDefault(s);case 8:e.department_code=e.defaultIssueHeader.department_code+"";case 9:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(a,i){var n=t.apply(e,s);function o(t){r(n,a,i,o,l,"next",t)}function l(t){r(n,a,i,o,l,"throw",t)}o(void 0)}))})()},methods:{indexMethod:function(t){return t+1},getMasterData:function(){this.getAliasName(),this.getSecondaryInventory(this.form.subinventory_code),this.getOrganization(),this.getGlCodeCombination()},getItemMaster:function(t){var e=this;this.loadingInput.systemItem=!0,axios.get("/inv/ajax/system_item",{params:{text:t,organization_id:this.form.organization_id,subinventory_code:this.form.subinventory_code}}).then((function(t){e.systemItems=t.data})).then((function(){e.loadingInput.systemItem=!1}))},getAliasName:function(t){var e=this;this.loadingInput.aliasName=!0,axios.get("/inv/ajax/alias_name",{params:{text:t,prefix:"A91:จ่ายค่าเครื่องเขียน%"}}).then((function(t){e.aLiasNames=t.data})).catch((function(t){console.log("error get alias name")})).then((function(){e.loadingInput.aliasName=!1}))},getCOAsWithDefault:function(t){var e=this;this.loadingInput.coaDeptCodes=!0;var s=axios.get("/inv/ajax/coa_dept_code",{params:{text:t}}),a=axios.get("/inv/ajax/coa_dept_code",{});axios.all([s,a]).then((function(t){t[0].data.map((function(t){e.coaDeptCodes.push(t)})),t[1].data.map((function(t){e.coaDeptCodes.push(t)}))})).then((function(){e.loadingInput.coaDeptCodes=!1}))},getCOAs:function(t){var e=this;axios.get("/inv/ajax/coa_dept_code",{params:{text:t}}).then((function(t){e.coaDeptCodes=t.data})).then((function(){e.loadingInput.coaDeptCodes=!1}))},getSecondaryInventory:function(t){var e=this;this.loadingInput.secondaryInventory=!0,axios.get("/inv/ajax/secondary_inventories",{params:{text:t,attribute3:"Yes",organization_code:"A91"}}).then((function(t){e.secondaryInventory=t.data,e.form.subinventory_code=e.secondaryInventory[0].secondary_inventory_name})).then((function(){e.loadingInput.secondaryInventory=!1}))},getOrganization:function(t){var e=this;this.loadingInput.organization=!0,axios.get("/inv/ajax/organization_units",{params:{text:t,organization_code:"A91"}}).then((function(t){e.organizations=t.data,e.form.organization_id=e.organizations[0].organization_id,e.getItemMaster()})).then((function(){e.loadingInput.organization=!1}))},getGlCodeCombination:function(){var t=this;axios.get("/inv/ajax/gl_code_combinations").then((function(e){t.glCodeCombinations=e.data}))},getCostCenters:function(t){var e=this;axios.get("/inv/ajax/cost_centers",{params:{text:t,department_code:this.form.department_code}}).then((function(t){e.costCenters=t.data,1==e.costCenters.length&&(e.form.cost_center=e.costCenters[0].flex_value)})).then((function(){e.loadingInput.costCenters=!1}))},deleteRow:function(t,e){e.splice(t,1)},addRow:function(){var t=this;if(!this.selectItem)return alert("กรุณาเลือกรายการก่อน");if(this.form.items.find((function(e){return e.item==t.selectItem})))return alert("สินค้านี้ถูกเลือกไปแล้ว");var e=this.systemItems.find((function(e){return e.segment1==t.selectItem}));if(this.selectItem=void 0,e.onhand_quantity<="0")return alert("จำนวนคงเหลือของสินค้าเท่ากับ 0");""!=e&&this.form.items.push({item:e.segment1,description:e.description,onhand_quantity:e.onhand_quantity,transaction_quantity:"",primary_unit_of_measure:e.primary_unit_of_measure,transaction_uom:e.primary_uom_code,transaction_account:this.account_combine,inventory_item_id:e.inventory_item_id,item_cost:e.item_cost_type.item_cost})},submitForm:function(t){var e,s,a,i,n,o=this;if(this.form.issue_status=t,this.loading=!0,this.form.items.filter((function(t){return t.transaction_quantity<=0||""==t.transaction_quantity})).length>0)return this.loading=!1,this.form.issue_status="WAITING"==(null===(e=this.defaultIssueHeader)||void 0===e?void 0:e.issue_status)?"รอตัดจ่าย":"APPROVED"==(null===(s=this.defaultIssueHeader)||void 0===s?void 0:s.issue_status)?"ตัดจ่ายสำเร็จ":"CANCELLED"==(null===(a=this.defaultIssueHeader)||void 0===a?void 0:a.issue_status)||"RETURN"==(null===(i=this.defaultIssueHeader)||void 0===i?void 0:i.issue_status)?"ยกเลิก":"DRAFT"==(null===(n=this.defaultIssueHeader)||void 0===n?void 0:n.issue_status)?"ร่างรายการเบิก":"รอตัดจ่าย",void alert("ไม่สามารถระบุจำนวนติดลบ (-) หรือระบุจำนวนเท่ากับ 0 ได้");if(this.form.department_code.department_code&&(this.form.department_code=this.form.department_code.department_code),"UPDATE"==t){for(var r=0;r<this.form.items.length;r++)if(parseInt(this.form.items[r].onhand_quantity)<parseInt(this.form.items[r].transaction_quantity))return alert("จำนวนรายการสินค้า "+this.form.items[r].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ"),void(this.loading=!1);var l,d,c,u,m;if(confirm("บันทึกการแก้ไขรายการเบิกจ่ายเครื่องเขียน ?"))axios.patch("/inv/requisition_stationery/"+this.form.issue_header_id,this.form).then((function(t){o.loading=!0,o.$notify({title:"Success",message:"Successfully",type:"success"}),window.location.replace("/inv/requisition_stationery/")})).catch((function(t){var e=o.$formatErrorMessage(error);alert(e)}));else this.form.issue_status="WAITING"==(null===(l=this.defaultIssueHeader)||void 0===l?void 0:l.issue_status)?"รอตัดจ่าย":"APPROVED"==(null===(d=this.defaultIssueHeader)||void 0===d?void 0:d.issue_status)?"ตัดจ่ายสำเร็จ":"CANCELLED"==(null===(c=this.defaultIssueHeader)||void 0===c?void 0:c.issue_status)||"RETURN"==(null===(u=this.defaultIssueHeader)||void 0===u?void 0:u.issue_status)?"ยกเลิก":"DRAFT"==(null===(m=this.defaultIssueHeader)||void 0===m?void 0:m.issue_status)?"ร่างรายการเบิก":"รอตัดจ่าย",this.loading=!1}else if("DRAFT"==t){for(var f=0;f<this.form.items.length;f++)if(parseInt(this.form.items[f].onhand_quantity)<parseInt(this.form.items[f].transaction_quantity))return alert("จำนวนรายการสินค้า "+this.form.items[f].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ"),void(this.loading=!1);var _,v,h,p,g;if(confirm("บันทึกร่างรายการเบิกจ่ายเครื่องเขียน ?"))axios.post("/inv/requisition_stationery",this.form).then((function(t){o.$notify({title:"Success",message:"Successfully",type:"success"}),window.location.replace("/inv/requisition_stationery/")})).catch((function(t){o.loading=!1;var e=o.$formatErrorMessage(error);alert(e)}));else this.form.issue_status="WAITING"==(null===(_=this.defaultIssueHeader)||void 0===_?void 0:_.issue_status)?"รอตัดจ่าย":"APPROVED"==(null===(v=this.defaultIssueHeader)||void 0===v?void 0:v.issue_status)?"ตัดจ่ายสำเร็จ":"CANCELLED"==(null===(h=this.defaultIssueHeader)||void 0===h?void 0:h.issue_status)||"RETURN"==(null===(p=this.defaultIssueHeader)||void 0===p?void 0:p.issue_status)?"ยกเลิก":"DRAFT"==(null===(g=this.defaultIssueHeader)||void 0===g?void 0:g.issue_status)?"ร่างรายการเบิก":"รอตัดจ่าย",this.loading=!1}else if("WAITING"==t){for(var b=0;b<this.form.items.length;b++)if(parseInt(this.form.items[b].onhand_quantity)<parseInt(this.form.items[b].transaction_quantity))return alert("จำนวนรายการสินค้า "+this.form.items[b].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ"),void(this.loading=!1);var y,I,C,x,w;if(confirm("ขออนุมัติการเบิกจ่ายเครื่องเขียน ?"))axios.post("/inv/requisition_stationery",this.form).then((function(t){o.$notify({title:"Success",message:"Successfully",type:"success"}),window.location.replace("/inv/requisition_stationery/")})).catch((function(t){o.loading=!1;var e=o.$formatErrorMessage(error);alert(e)}));else this.form.issue_status="WAITING"==(null===(y=this.defaultIssueHeader)||void 0===y?void 0:y.issue_status)?"รอตัดจ่าย":"APPROVED"==(null===(I=this.defaultIssueHeader)||void 0===I?void 0:I.issue_status)?"ตัดจ่ายสำเร็จ":"CANCELLED"==(null===(C=this.defaultIssueHeader)||void 0===C?void 0:C.issue_status)||"RETURN"==(null===(x=this.defaultIssueHeader)||void 0===x?void 0:x.issue_status)?"ยกเลิก":"DRAFT"==(null===(w=this.defaultIssueHeader)||void 0===w?void 0:w.issue_status)?"ร่างรายการเบิก":"รอตัดจ่าย",this.loading=!1}else"APPROVE"==t&&(confirm("อนุมัติการเบิกจ่ายเครื่องเขียน ?")?axios.patch("/inv/requisition_stationery/".concat(this.form.issue_header_id,"/approve")).then((function(t){window.location.replace("/inv/requisition_stationery/")})).catch((function(t){o.loading=!1;var e=o.$formatErrorMessage(error);alert(e)})).then((function(){})):this.loading=!1)},aliasNameOnchange:function(){var t=this;if(this.aLiasNames.length>0&&""!=this.form.gl_alias_name){var e=this.aLiasNames.find((function(e){return e.alias_name==t.form.gl_alias_name}));this.form.account_code=e.template}}},computed:{valid:function(){return!(""===this.form.description||""===this.form.department_code||""===this.form.organization_id||""===this.form.subinventory_code||""===this.form.gl_alias_name||0===this.form.items.length)},validDraft:function(){return!(""===this.form.description||""===this.form.department_code||""===this.form.organization_id||""===this.form.subinventory_code||""===this.form.gl_alias_name)}}};var m=s(93379),f=s.n(m),_=s(51585),v={insert:"head",singleton:!1};f()(_.Z,v);_.Z.locals;const h=(0,s(51900).Z)(u,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"container"},[s("div",{staticClass:"row justify-content-center"},[s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label"},[t._v("เลขที่ใบเบิก")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-input",{attrs:{disabled:!0,placeholder:"เลขที่ใบเบิกจะถูกสร้างหลังการบันทึก",disable:""},model:{value:t.form.issue_number,callback:function(e){t.$set(t.form,"issue_number",e)},expression:"form.issue_number"}})],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label required"},[t._v("รายละเอียดขอเบิก")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-input",{attrs:{autosize:{minRows:3,maxRows:3},type:"textarea",placeholder:"รายละเอียดขอเบิก"},model:{value:t.form.description,callback:function(e){t.$set(t.form,"description",e)},expression:"form.description"}})],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label"},[t._v("สถานะ")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-input",{attrs:{disabled:!0,placeholder:"สถานะ"},model:{value:t.form.issue_status,callback:function(e){t.$set(t.form,"issue_status",e)},expression:"form.issue_status"}})],1)])]),t._v(" "),s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label"},[t._v("วันที่สร้างรายการ")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-input",{attrs:{disabled:!0,placeholder:"วันที่สร้างรายการ"},model:{value:t.form.created_at,callback:function(e){t.$set(t.form,"created_at",e)},expression:"form.created_at"}})],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label required"},[t._v("หน่วยงานผู้ขอเบิก")]),t._v(" "),s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingInput.coaDeptCode,expression:"loadingInput.coaDeptCode"}],staticClass:"col-md-9"},[s("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getCOAs,placeholder:"หน่วยงานผู้ขอเบิก",loading:t.loadingInput.coaDeptCodes},model:{value:t.department_code,callback:function(e){t.department_code=e},expression:"department_code"}},t._l(t.coaDeptCodes,(function(t){return s("el-option",{key:t.department_code,attrs:{label:t.department_code+" - "+t.description,value:t.department_code}})})),1)],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label required"},[t._v("Cost Center")]),t._v(" "),s("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingInput.costCenters,expression:"loadingInput.costCenters"}],staticClass:"col-md-9"},[s("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getCostCenters,placeholder:"Cost Center",loading:t.loadingInput.costCenters},model:{value:t.form.cost_center,callback:function(e){t.$set(t.form,"cost_center",e)},expression:"form.cost_center"}},t._l(t.costCenters,(function(t){return s("el-option",{key:t.flex_value_id,attrs:{label:t.flex_value+" - "+t.description,value:t.flex_value}})})),1)],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label required"},[t._v("Org")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,placeholder:"คลังสินค้า"},model:{value:t.form.organization_id,callback:function(e){t.$set(t.form,"organization_id",e)},expression:"form.organization_id"}},t._l(t.organizations,(function(t,e){return s("el-option",{key:e,attrs:{label:t.parameter.organization_code+" - "+t.name,value:t.organization_id}})})),1)],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label required"},[t._v("Subinventory")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getSecondaryInventory,placeholder:"คลังสินค้าย่อย",loading:t.loadingInput.secondaryInventory},model:{value:t.form.subinventory_code,callback:function(e){t.$set(t.form,"subinventory_code",e)},expression:"form.subinventory_code"}},t._l(t.secondaryInventory,(function(t,e){return s("el-option",{key:e,attrs:{label:t.secondary_inventory_name+" - "+t.description,value:t.secondary_inventory_name}})})),1)],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("label",{staticClass:"col-md-3 col-form-label required"},[t._v("รหัสบัญชี")]),t._v(" "),s("div",{staticClass:"col-md-9"},[s("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getAliasName,placeholder:"รหัสบัญชี",loading:t.loadingInput.aliasName,change:t.aliasNameOnchange()},model:{value:t.gl_alias_name,callback:function(e){t.gl_alias_name=e},expression:"gl_alias_name"}},t._l(t.aLiasNames,(function(t,e){return s("el-option",{key:e,attrs:{label:t.description,value:t.alias_name}})})),1)],1)]),t._v(" "),s("div",{staticClass:"form-group row"},[s("div",{staticClass:"col-md-9 offset-md-3"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.account_combine,expression:"account_combine"}],staticClass:"form-control-plaintext",attrs:{type:"plaintext",readonly:""},domProps:{value:t.account_combine},on:{input:function(e){e.target.composing||(t.account_combine=e.target.value)}}})])])]),t._v(" "),s("el-divider"),t._v(" "),s("div",{staticClass:"col-md-9 mb-2"},[s("el-select",{staticClass:"mb-2",staticStyle:{width:"100%"},attrs:{filterable:"",placeholder:"เลือกสินค้า",remote:"","remote-method":t.getItemMaster,loading:t.loadingInput.systemItem},model:{value:t.selectItem,callback:function(e){t.selectItem=e},expression:"selectItem"}},t._l(t.systemItems,(function(t,e){return s("el-option",{key:e,attrs:{label:t.segment1+" - "+t.description,value:t.segment1}})})),1)],1),t._v(" "),s("div",{staticClass:"col-md-3 mb-2"},[s("el-button",{staticClass:"btn-success",staticStyle:{width:"100%"},attrs:{type:"success"},nativeOn:{click:function(e){return e.preventDefault(),t.addRow()}}},[t._v("Add")])],1),t._v(" "),s("div",{staticClass:"col-md-12"},[s("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.form.items}},[s("el-table-column",{attrs:{"class-name":"text-center",label:"Line",type:"index",width:"60",index:t.indexMethod}}),t._v(" "),s("el-table-column",{attrs:{prop:"item",label:"Item",width:"120"}}),t._v(" "),s("el-table-column",{attrs:{prop:"description",label:"รายละเอียดสินค้า"}}),t._v(" "),s("el-table-column",{attrs:{"class-name":"text-center",prop:"onhand_quantity",label:"จำนวนคงเหลือ",width:"150"}}),t._v(" "),s("el-table-column",{attrs:{prop:"transaction_quantity",label:"จำนวนที่ขอเบิก",width:"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[s("el-input",{attrs:{type:"number",placeholder:"จำนวนที่ขอเบิก",min:"1",required:""},model:{value:e.row.transaction_quantity,callback:function(s){t.$set(e.row,"transaction_quantity",s)},expression:"scope.row.transaction_quantity"}})]}}])}),t._v(" "),s("el-table-column",{attrs:{"class-name":"text-center",prop:"primary_unit_of_measure",label:"หน่วยนับ",width:"80"}}),t._v(" "),s("el-table-column",{attrs:{prop:"transaction_account",label:"เลขทางบัญชี"}}),t._v(" "),s("el-table-column",{attrs:{"class-name":"text-center",width:"100"},scopedSlots:t._u([{key:"default",fn:function(e){return[s("el-button",{attrs:{size:"mini",type:"danger"},nativeOn:{click:function(s){return s.preventDefault(),t.deleteRow(e.$index,t.form.items)}}},[s("i",{staticClass:"el-icon-delete"}),t._v("Delete")])]}}])})],1)],1),t._v(" "),s("div",{staticClass:"col-md-12 text-right mt-2"},[t.form.issue_header_id?t._e():s("el-button",{staticClass:"btn-success",attrs:{size:"mini",type:"success",disabled:!t.validDraft},on:{click:function(e){return t.submitForm("DRAFT")}}},[t._v("บันทึก")]),t._v(" "),t.form.issue_header_id?t._e():s("el-button",{staticClass:"btn-success",attrs:{size:"mini",type:"success",disabled:!t.valid},on:{click:function(e){return t.submitForm("WAITING")}}},[t._v("ส่งรายการเบิก")]),t._v(" "),t.copy?s("el-button",{staticClass:"btn-success",attrs:{size:"mini",type:"success"},on:{click:function(e){return t.submitForm("WAITING")}}},[t._v("บันทึก")]):t._e(),t._v(" "),t.form.issue_header_id&&!t.copy?s("el-button",{staticClass:"btn-success",attrs:{size:"mini",type:"success"},on:{click:function(e){return t.submitForm("UPDATE")}}},[t._v("บันทึกและส่งรายการเบิก")]):t._e()],1)],1)])}),[],!1,null,"6ea0286a",null).exports}}]);