(self.webpackChunk=self.webpackChunk||[]).push([[2756],{96375:(t,e,r)=>{"use strict";r.d(e,{Z:()=>o});var n=r(23645),a=r.n(n)()((function(t){return t[1]}));a.push([t.id,".loading-progress[data-v-aa859ff0]{height:100%;width:100%;margin-top:40px}.text-red[data-v-aa859ff0]{color:red}.period-date[data-v-aa859ff0]{width:100%}.error-message[data-v-aa859ff0]{display:flex;color:#ec4958;margin-top:5px}.error-message strong[data-v-aa859ff0]{margin-right:5px}.mt-custom__10[data-v-aa859ff0]{margin-top:10px}.text-title[data-v-aa859ff0]{font-size:16px;font-weight:600}.btn-info[data-v-aa859ff0]{background-color:#02b0ef;border-color:#02b0ef}.btn-success[data-v-aa859ff0]{background-color:#1ab394;border-color:#1ab394}.btn-cancel[data-v-aa859ff0]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-aa859ff0]{color:#ec4958}.td-select[data-v-aa859ff0]{cursor:pointer;border:2px solid #eee;border-radius:5px;padding:10px 0}.background-dialog__custom[data-v-aa859ff0]{width:100%;height:100%;position:absolute;top:0;left:0;z-index:100;background:#f3f3f4;opacity:.7}.flex_end[data-v-aa859ff0]{display:flex;justify-content:flex-end}.btn-disable[data-v-aa859ff0],.is-disabled[data-v-aa859ff0]{color:#fff;background-color:#b3e19d;border-color:#b3e19d}",""]);const o=a},8015:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>y});var n=r(87757),a=r.n(n),o=r(7869),s=r.n(o);function i(t){return function(t){if(Array.isArray(t))return d(t)}(t)||function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}(t)||c(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function l(t,e){if(null==t)return{};var r,n,a=function(t,e){if(null==t)return{};var r,n,a={},o=Object.keys(t);for(n=0;n<o.length;n++)r=o[n],e.indexOf(r)>=0||(a[r]=t[r]);return a}(t,e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);for(n=0;n<o.length;n++)r=o[n],e.indexOf(r)>=0||Object.prototype.propertyIsEnumerable.call(t,r)&&(a[r]=t[r])}return a}function u(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var r=[],n=!0,a=!1,o=void 0;try{for(var s,i=t[Symbol.iterator]();!(n=(s=i.next()).done)&&(r.push(s.value),!e||r.length!==e);n=!0);}catch(t){a=!0,o=t}finally{try{n||null==i.return||i.return()}finally{if(a)throw o}}return r}(t,e)||c(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function c(t,e){if(t){if("string"==typeof t)return d(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);return"Object"===r&&t.constructor&&(r=t.constructor.name),"Map"===r||"Set"===r?Array.from(t):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?d(t,e):void 0}}function d(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,n=new Array(e);r<e;r++)n[r]=t[r];return n}function f(t,e,r,n,a,o,s){try{var i=t[o](s),l=i.value}catch(t){return void r(t)}i.done?e(l):Promise.resolve(l).then(n,a)}function m(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var o=t.apply(e,r);function s(t){f(o,n,a,s,i,"next",t)}function i(t){f(o,n,a,s,i,"throw",t)}s(void 0)}))}}const p={data:function(){return{interval:null,loading_progress:!1,progress:0,loading:!1,file:{},status:{tableData:!1},form:{},tableData:[]}},computed:{tableError:function(){var t=!0;this.tableData.length>0&&this.status.tableData&&(0==_.filter(this.tableData,(function(t){return(null==t?void 0:t.validate.length)>0})).length&&(t=!1));return t}},methods:{uploadFile:function(){this.$refs.file.click()},getQuery:function(){var t=new URLSearchParams(window.location.search);return Object.fromEntries(t.entries())},search:function(){var t=this;return m(a().mark((function e(){var r,n,o,s,i;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=t.getQuery(),n=r.version,o=r.period_year,s=r.period_name,i=r.organization_code,e.next=3,axios.get("/ct/ajax/purchase_price_info?version=".concat(n,"&period_year=").concat(o,"&period_name=").concat(s,"&organization_code=").concat(i)).then((function(e){if(e.data){var r=e.data;e.data.material_cost_lines.forEach((function(t){t.validate=[]})),t.tableData=e.data.material_cost_lines,t.form.used_date=[r.date_from,r.date_to],t.form.version=r.version,t.form.std_head_id=r.std_head_id,t.form.status="Y"==r.status?"ยืนยันแล้ว":"N"==r.status?"ยังไม่ยืนยัน":"ไม่มีข้อมูล",t.status.tableData=!0}else t.$message({showClose:!0,message:"ไม่พบข้อมูล",type:"error"})})).catch((function(e){t.errorMessage(e.response),t.$message({showClose:!0,message:"ไม่สามารถประมวลผลได้",type:"error"})})).then((function(){t.form.search=!1}));case 3:case"end":return e.stop()}}),e)})))()},updateImport:function(){var t=this,e=this.tableData;this.loadingProgress(),axios.post("/ct/ajax/purchase_price_info/update_import",{lines:e}).then((function(e){t.$message({showClose:!0,message:"บันทึกสำเร็จ",type:"success"})})).then((function(){t.loading_progress=!1}))},checkItemNumber:function(t){return axios.get("/ct/ajax/purchase_price_info/check_item_number/".concat(t)).then((function(t){return{status:!0,msg:t.data.data.description}})).catch((function(t){return{status:!1,msg:"item_number not found"}}))},getMasterData:function(){this.search()},isInt:function(t){return Number(t)===t&&t%1==0},isFloat:function(t){return Number(t)===t&&t%1!=0},loadingProgress:function(){var t=this;this.loading_progress=!0,this.progress=0,this.interval=setInterval((function(){t.loading_progress?t.progress<=60?t.progress+=5:t.progress>=60&&t.progress<99&&(t.progress+=1):(t.progress=100,setTimeout((function(){clearInterval(t.interval),t.interval=null}),1e3))}),500)},checkNumberKey:function(t){for(var e=[],r=0,n=Object.entries(t);r<n.length;r++){var a=u(n[r],2),o=a[0],s=a[1];this.isInt(s)||this.isFloat(s)||0==s||e.push("".concat(o," is not number"))}return e},importToTable:function(t){var e=this;return m(a().mark((function r(){return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.forEach(function(){var t=m(a().mark((function t(r){var n,o,s,u,c,d,f;return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,!0;case 2:return e.loading=t.sent,t.next=5,{std_line_id:null,std_head_id:e.form.std_head_id,item_number:r["รหัสวัตถุดิบ"],lot_number:r.LOT,item_descrtiption:r["ชื่อวัตถุดิบ"],unit_cost:parseFloat(r["ราคาซื้อ"])?parseFloat(r["ราคาซื้อ"]):r["ราคาซื้อ"],freight_cost:parseFloat(r["ค่าขนส่ง"])?parseFloat(r["ค่าขนส่ง"]):r["ค่าขนส่ง"],subtotal:parseFloat(r["จำนวนเงิน"])?parseFloat(r["จำนวนเงิน"]):r["จำนวนเงิน"],material_percent:parseFloat(r["เปอร์เซ็น"])?parseFloat(r["เปอร์เซ็น"]):r["เปอร์เซ็น"],dm_std_unitcost:parseFloat(r["จำนวนเงินรวม"])?parseFloat(r["จำนวนเงินรวม"]):r["จำนวนเงินรวม"],validate:[]};case 5:return o=t.sent,t.next=8,e.checkItemNumber(o.item_number);case 8:return(s=t.sent).status?o.item_descrtiption=s.msg:s.status||o.validate.push(s.msg),o.item_number,o.lot_number,o.item_descrtiption,o.std_line_id,o.std_head_id,o.validate,u=l(o,["item_number","lot_number","item_descrtiption","std_line_id","std_head_id","validate"]),(n=o.validate).push.apply(n,i(e.checkNumberKey(u))),o.lot_number=0!=o.lot_number&&o.lot_number?o.lot_number:null,(c=e.tableData.filter((function(t){return t.lot_number=0!=t.lot_number&&t.lot_number?t.lot_number:null,t.item_number==o.item_number&&t.lot_number==o.lot_number}))).length>=1&&(d=c[0].std_line_id),f=e.tableData.filter((function(t){return t.lot_number=0!=t.lot_number&&t.lot_number?t.lot_number:null,!(t.item_number==o.item_number&&t.lot_number==o.lot_number)})),e.tableData=f,o.std_line_id=d,t.next=20,e.tableData.push(o);case 20:return t.next=22,e.tableData.sort((function(t,e){return t.item_number-e.item_number}));case 22:return t.next=24,!1;case 24:e.loading=t.sent;case 25:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}());case 2:case"end":return r.stop()}}),r)})))()},handleFileUpload:function(){var t=this;return m(a().mark((function e(){var r,n,o;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.file=t.$refs.file.files[0],"csv"==(n=null===(r=t.file.name)||void 0===r?void 0:r.split(".").pop())||"xlsx"==n?((o=new FileReader).onload=function(){var e=o.result,r=s().read(e,{type:"binary"});r.SheetNames.forEach(function(){var e=m(a().mark((function e(n){var o,i;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return o=s().utils.sheet_to_row_object_array(r.Sheets[n]),i=JSON.stringify(o),e.next=4,t.search();case 4:return e.next=6,t.importToTable(JSON.parse(i));case 6:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}())},o.readAsBinaryString(t.file)):(t.file="",t.$refs.file.value="",t.$message({showClose:!0,message:"ไม่สามารถอัพโหลดได้ กรุณาอัพโหลดไฟล์ xlsx หรือ csv",type:"error"}));case 3:case"end":return e.stop()}}),e)})))()},numberWithCommas:function(t){return t.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g,",")},toFixedDecimal:function(t,e){return t=parseFloat(t),this.isFloat(t)?Number.parseFloat(t).toFixed(e):t}}};var b=r(93379),h=r.n(b),v=r(96375),g={insert:"head",singleton:!1};h()(v.Z,g);v.Z.locals;const y=(0,r(51900).Z)(p,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}]},[r("input",{ref:"file",attrs:{type:"file",id:"myfile",name:"myfile",hidden:""},on:{change:function(e){return t.handleFileUpload()}}}),t._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"col-md-12 text-right mt-2"},[r("a",{attrs:{href:"/ct/purchase_price_info",disabled:t.loading_progress}},[r("el-button",{staticClass:"btn-danger mr-2",attrs:{type:"danger"}},[t._v("\n                    ย้อนกลับ\n                ")])],1),t._v(" "),r("el-button",{staticClass:"btn-info mr-2",attrs:{type:"primary",disabled:t.loading_progress},on:{click:function(e){return t.uploadFile()}}},[t._v("\n                IMPORT FILE\n            ")]),t._v(" "),t.status.tableData?r("el-button",{class:t.tableError?"btn-disable":"btn-success",attrs:{disabled:t.tableError||t.loading_progress,type:"success"},on:{click:function(e){return t.updateImport()}}},[t._v("\n                บันทึก\n            ")]):t._e()],1)]),t._v(" "),t.interval?r("div",{staticClass:"loading-progress"},[r("el-progress",{attrs:{"text-inside":!0,"stroke-width":26,percentage:t.progress}})],1):t._e(),t._v(" "),t.status.tableData&&!t.loading_progress?r("div",{staticClass:"form-group row mt-5"},[r("div",{staticClass:"col-md-12 mt-2 flex-wrap"},[r("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.tableData}},[r("el-table-column",{attrs:{prop:"item_number",label:"รหัสวัตถุดิบ",align:"center"}}),t._v(" "),r("el-table-column",{attrs:{prop:"lot_number",label:"LOT",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(e.row.lot_number)+"\n                    ")]}}],null,!1,4049083030)}),t._v(" "),r("el-table-column",{attrs:{prop:"item_descrtiption",label:"ชื่อวัตถุดิบ",align:"center"}}),t._v(" "),r("el-table-column",{attrs:{prop:"unit_cost",label:"ราคาซื้อ",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(e.row.unit_cost?t.numberWithCommas(t.toFixedDecimal(e.row.unit_cost,9)):0)+"\n                    ")]}}],null,!1,454756804)}),t._v(" "),r("el-table-column",{attrs:{prop:"freight_cost",label:"ค่าขนส่ง",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(""!==e.row.freight_cost?t.numberWithCommas(t.toFixedDecimal(e.row.freight_cost,9)):0)+"\n                    ")]}}],null,!1,519787343)}),t._v(" "),r("el-table-column",{attrs:{prop:"subtotal",label:"จำนวนเงิน",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(t.numberWithCommas(t.toFixedDecimal(e.row.subtotal,9)))+"\n                    ")]}}],null,!1,4178170039)}),t._v(" "),r("el-table-column",{attrs:{prop:"dm_std_unitcost",label:"จำนวนเงินรวม",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(t.numberWithCommas(t.toFixedDecimal(e.row.dm_std_unitcost,9)))+"\n                    ")]}}],null,!1,2897069878)}),t._v(" "),r("el-table-column",{attrs:{width:"200px",prop:"validate",label:"สถานะ",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return t._l(e.row.validate,(function(e,n){return r("div",{key:n,staticClass:"text-red"},[t._v("\n                            "+t._s(e)+"\n                        ")])}))}}],null,!1,3902927939)})],1)],1)]):t._e()])}),[],!1,null,"aa859ff0",null).exports}}]);