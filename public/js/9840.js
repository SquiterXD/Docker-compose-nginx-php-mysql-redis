(self.webpackChunk=self.webpackChunk||[]).push([[9840],{86862:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>o});var n=r(23645),a=r.n(n)()((function(e){return e[1]}));a.push([e.id,".loading-progress[data-v-0bee7933]{height:100%;width:100%;margin-top:40px}.text-red[data-v-0bee7933]{color:red}.period-date[data-v-0bee7933]{width:100%}.error-message[data-v-0bee7933]{display:flex;color:#ec4958;margin-top:5px}.error-message strong[data-v-0bee7933]{margin-right:5px}.mt-custom__10[data-v-0bee7933]{margin-top:10px}.text-title[data-v-0bee7933]{font-size:16px;font-weight:600}.btn-info[data-v-0bee7933]{background-color:#02b0ef;border-color:#02b0ef}.btn-success[data-v-0bee7933]{background-color:#1ab394;border-color:#1ab394}.btn-cancel[data-v-0bee7933]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-0bee7933]{color:#ec4958}.td-select[data-v-0bee7933]{cursor:pointer;border:2px solid #eee;border-radius:5px;padding:10px 0}.background-dialog__custom[data-v-0bee7933]{width:100%;height:100%;position:absolute;top:0;left:0;z-index:100;background:#f3f3f4;opacity:.7}.flex_end[data-v-0bee7933]{display:flex;justify-content:flex-end}.btn-disable[data-v-0bee7933],.is-disabled[data-v-0bee7933]{color:#fff;background-color:#b3e19d;border-color:#b3e19d}",""]);const o=a},39840:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>b});var n=r(87757),a=r.n(n),o=r(7869),s=r.n(o);function i(e){return function(e){if(Array.isArray(e))return d(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||u(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function l(e,t){if(null==e)return{};var r,n,a=function(e,t){if(null==e)return{};var r,n,a={},o=Object.keys(e);for(n=0;n<o.length;n++)r=o[n],t.indexOf(r)>=0||(a[r]=e[r]);return a}(e,t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);for(n=0;n<o.length;n++)r=o[n],t.indexOf(r)>=0||Object.prototype.propertyIsEnumerable.call(e,r)&&(a[r]=e[r])}return a}function c(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var r=e&&("undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"]);if(null==r)return;var n,a,o=[],s=!0,i=!1;try{for(r=r.call(e);!(s=(n=r.next()).done)&&(o.push(n.value),!t||o.length!==t);s=!0);}catch(e){i=!0,a=e}finally{try{s||null==r.return||r.return()}finally{if(i)throw a}}return o}(e,t)||u(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function u(e,t){if(e){if("string"==typeof e)return d(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?d(e,t):void 0}}function d(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}function f(e,t,r,n,a,o,s){try{var i=e[o](s),l=i.value}catch(e){return void r(e)}i.done?t(l):Promise.resolve(l).then(n,a)}function p(e){return function(){var t=this,r=arguments;return new Promise((function(n,a){var o=e.apply(t,r);function s(e){f(o,n,a,s,i,"next",e)}function i(e){f(o,n,a,s,i,"throw",e)}s(void 0)}))}}const m={data:function(){return{interval:null,loading_progress:!1,progress:0,loading:!1,file:{},status:{tableData:!1},form:{},tableData:[]}},computed:{tableError:function(){var e=!0;this.tableData.length>0&&this.status.tableData&&(0==_.filter(this.tableData,(function(e){return(null==e?void 0:e.validate.length)>0})).length&&(e=!1));return e}},mounted:function(){console.log(this.toFixedDecimal(.9198076485127896,9))},methods:{uploadFile:function(){this.$refs.file.click()},getQuery:function(){var e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries())},search:function(){var e=this;return p(a().mark((function t(){var r,n,o,s,i;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=e.getQuery(),n=r.version,o=r.period_year,s=r.period_name,i=r.organization_code,t.next=3,axios.get("/ct/ajax/purchase_price_info?version=".concat(n,"&period_year=").concat(o,"&period_name=").concat(s,"&organization_code=").concat(i)).then((function(t){if(t.data){var r=t.data;t.data.material_cost_lines.forEach((function(e){e.validate=[]})),e.tableData=t.data.material_cost_lines,e.form.used_date=[r.date_from,r.date_to],e.form.version=r.version,e.form.std_head_id=r.std_head_id,e.form.status="Y"==r.status?"ยืนยันแล้ว":"N"==r.status?"ยังไม่ยืนยัน":"ไม่มีข้อมูล",e.status.tableData=!0}else e.$message({showClose:!0,message:"ไม่พบข้อมูล",type:"error"})})).catch((function(t){e.errorMessage(t.response),e.$message({showClose:!0,message:"ไม่สามารถประมวลผลได้",type:"error"})})).then((function(){e.form.search=!1}));case 3:case"end":return t.stop()}}),t)})))()},updateImport:function(){var e=this,t=this.tableData;this.loadingProgress(),axios.post("/ct/ajax/purchase_price_info/update_import",{lines:t}).then((function(t){e.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success"})})).then((function(){e.loading_progress=!1}))},checkItemNumber:function(e){return axios.get("/ct/ajax/purchase_price_info/check_item_number/".concat(e)).then((function(e){return{status:!0,msg:e.data.data.description}})).catch((function(e){return{status:!1,msg:"item_number not found"}}))},getMasterData:function(){this.search()},isInt:function(e){return Number(e)===e&&e%1==0},isFloat:function(e){return Number(e)===e&&e%1!=0},loadingProgress:function(){var e=this;this.loading_progress=!0,this.progress=0,this.interval=setInterval((function(){e.loading_progress?e.progress<=60?e.progress+=5:e.progress>=60&&e.progress<99&&(e.progress+=1):(e.progress=100,setTimeout((function(){clearInterval(e.interval),e.interval=null}),1e3))}),500)},checkNumberKey:function(e){for(var t=[],r=0,n=Object.entries(e);r<n.length;r++){var a=c(n[r],2),o=a[0],s=a[1];this.isInt(s)||this.isFloat(s)||0==s||t.push("".concat(o," is not number"))}return t},importToTable:function(e){var t=this;return p(a().mark((function r(){return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,e.forEach(function(){var e=p(a().mark((function e(r){var n,o,s,c,u,d,f;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,!0;case 2:return t.loading=e.sent,e.next=5,{std_line_id:null,std_head_id:t.form.std_head_id,item_number:r["รหัสวัตถุดิบ"],lot_number:r.LOT,item_descrtiption:r["ชื่อวัตถุดิบ"],unit_cost:parseFloat(r["ราคาซื้อ"])?parseFloat(r["ราคาซื้อ"]):r["ราคาซื้อ"],freight_cost:parseFloat(r["ค่าขนส่ง"])?parseFloat(r["ค่าขนส่ง"]):r["ค่าขนส่ง"],subtotal:parseFloat(r["จำนวนเงิน"])?parseFloat(r["จำนวนเงิน"]):r["จำนวนเงิน"],material_percent:parseFloat(r["เปอร์เซ็น"])?parseFloat(r["เปอร์เซ็น"]):r["เปอร์เซ็น"],dm_std_unitcost:parseFloat(r["จำนวนเงินรวม"])?parseFloat(r["จำนวนเงินรวม"]):r["จำนวนเงินรวม"],validate:[]};case 5:return o=e.sent,e.next=8,t.checkItemNumber(o.item_number);case 8:return(s=e.sent).status?o.item_descrtiption=s.msg:s.status||o.validate.push(s.msg),o.item_number,o.lot_number,o.item_descrtiption,o.std_line_id,o.std_head_id,o.validate,c=l(o,["item_number","lot_number","item_descrtiption","std_line_id","std_head_id","validate"]),(n=o.validate).push.apply(n,i(t.checkNumberKey(c))),(u=t.tableData.filter((function(e){return e.item_number==o.item_number&&e.lot_number==o.lot_number}))).length>=1&&(d=u[0].std_line_id),f=t.tableData.filter((function(e){return!(e.item_number==o.item_number&&e.lot_number==o.lot_number)})),t.tableData=f,o.std_line_id=d,e.next=19,t.tableData.push(o);case 19:return e.next=21,!1;case 21:t.loading=e.sent;case 22:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 2:case"end":return r.stop()}}),r)})))()},handleFileUpload:function(){var e=this;return p(a().mark((function t(){var r,n,o;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.file=e.$refs.file.files[0],"csv"==(n=null===(r=e.file.name)||void 0===r?void 0:r.split(".").pop())||"xlsx"==n?((o=new FileReader).onload=function(){var t=o.result,r=s().read(t,{type:"binary"});r.SheetNames.forEach(function(){var t=p(a().mark((function t(n){var o,i;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return o=s().utils.sheet_to_row_object_array(r.Sheets[n]),i=JSON.stringify(o),t.next=4,e.search();case 4:return t.next=6,e.importToTable(JSON.parse(i));case 6:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())},o.readAsBinaryString(e.file)):(e.file="",e.$refs.file.value="",e.$message({showClose:!0,message:"ไม่สามารถอัพโหลดได้ กรุณาอัพโหลดไฟล์ xlsx หรือ csv",type:"error"}));case 3:case"end":return t.stop()}}),t)})))()},numberWithCommas:function(e){return e.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g,",")},toFixedDecimal:function(e,t){return e=parseFloat(e),this.isFloat(e)?Number.parseFloat(e).toFixed(t):e}}};r(24054);const b=(0,r(51900).Z)(m,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}]},[r("input",{ref:"file",attrs:{type:"file",id:"myfile",name:"myfile",hidden:""},on:{change:function(t){return e.handleFileUpload()}}}),e._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-12 text-right mt-2"},[r("a",{attrs:{href:"/ct/purchase_price_info",disabled:e.loading_progress}},[r("el-button",{staticClass:"btn-danger mr-2",attrs:{type:"danger"}},[e._v("\n                    ย้อนกลับ\n                ")])],1),e._v(" "),r("el-button",{staticClass:"btn-info mr-2",attrs:{type:"primary",disabled:e.loading_progress},on:{click:function(t){return e.uploadFile()}}},[e._v("\n                IMPORT FILE\n            ")]),e._v(" "),e.status.tableData?r("el-button",{class:e.tableError?"btn-disable":"btn-success",attrs:{disabled:e.tableError||e.loading_progress,type:"success"},on:{click:function(t){return e.updateImport()}}},[e._v("\n                บันทึก\n            ")]):e._e()],1)]),e._v(" "),e.interval?r("div",{staticClass:"loading-progress"},[r("el-progress",{attrs:{"text-inside":!0,"stroke-width":26,percentage:e.progress}})],1):e._e(),e._v(" "),e.status.tableData&&!e.loading_progress?r("div",{staticClass:"form-group row mt-5"},[r("div",{staticClass:"col-md-12 mt-2 flex-wrap"},[r("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:e.tableData}},[r("el-table-column",{attrs:{prop:"item_number",label:"รหัสวัตถุดิบ",align:"center"}}),e._v(" "),r("el-table-column",{attrs:{prop:"lot_number",label:"LOT",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                        "+e._s(t.row.lot_number)+"\n                    ")]}}],null,!1,4049083030)}),e._v(" "),r("el-table-column",{attrs:{prop:"item_descrtiption",label:"ชื่อวัตถุดิบ",align:"center"}}),e._v(" "),r("el-table-column",{attrs:{prop:"unit_cost",label:"ราคาซื้อ",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                        "+e._s(t.row.unit_cost?e.numberWithCommas(e.toFixedDecimal(t.row.unit_cost,9)):0)+"\n                    ")]}}],null,!1,454756804)}),e._v(" "),r("el-table-column",{attrs:{prop:"freight_cost",label:"ค่าขนส่ง",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                        "+e._s(""!==t.row.freight_cost?e.numberWithCommas(e.toFixedDecimal(t.row.freight_cost,9)):0)+"\n                    ")]}}],null,!1,519787343)}),e._v(" "),r("el-table-column",{attrs:{prop:"subtotal",label:"จำนวนเงิน",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                        "+e._s(e.numberWithCommas(e.toFixedDecimal(t.row.subtotal,9)))+"\n                    ")]}}],null,!1,4178170039)}),e._v(" "),r("el-table-column",{attrs:{prop:"material_percent",label:"%",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                        "+e._s(""!==t.row.material_percent?t.row.material_percent:0)+"\n                    ")]}}],null,!1,1258047465)}),e._v(" "),r("el-table-column",{attrs:{prop:"dm_std_unitcost",label:"จำนวนเงินรวม",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[e._v("\n                        "+e._s(e.numberWithCommas(e.toFixedDecimal(t.row.dm_std_unitcost,9)))+"\n                    ")]}}],null,!1,2897069878)}),e._v(" "),r("el-table-column",{attrs:{width:"200px",prop:"validate",label:"สถานะ",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return e._l(t.row.validate,(function(t,n){return r("div",{key:n,staticClass:"text-red"},[e._v("\n                            "+e._s(t)+"\n                        ")])}))}}],null,!1,3902927939)})],1)],1)]):e._e()])}),[],!1,null,"0bee7933",null).exports},51900:(e,t,r)=>{"use strict";function n(e,t,r,n,a,o,s,i){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=r,c._compiled=!0),n&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),s?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),a&&a.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(s)},c._ssrRegister=l):a&&(l=i?function(){a.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:a),l)if(c.functional){c._injectStyles=l;var u=c.render;c.render=function(e,t){return l.call(t),u(e,t)}}else{var d=c.beforeCreate;c.beforeCreate=d?[].concat(d,l):[l]}return{exports:e,options:c}}r.d(t,{Z:()=>n})},24054:(e,t,r)=>{var n=r(86862);n.__esModule&&(n=n.default),"string"==typeof n&&(n=[[e.id,n,""]]),n.locals&&(e.exports=n.locals);(0,r(45346).Z)("546f0fd4",n,!0,{})}}]);