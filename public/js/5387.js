(self.webpackChunk=self.webpackChunk||[]).push([[5387],{75387:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>c});var s=a(87757),i=a.n(s);function n(e,t,a,s,i,n,l){try{var c=e[n](l),r=c.value}catch(e){return void a(e)}c.done?t(r):Promise.resolve(r).then(s,i)}const l={props:["tests","resultSeverites","units","dataTypes","processTestList","entityTestList","processDistinctTestList"],data:function(){return{lines:[],fileList:[],test_type_code:"",hrefTarget:"_blank",entityTestSearchList:[],processTestSearchList:[]}},mounted:function(){var e=this;this.tests.data.forEach((function(t,a){e.getCheckDataType(a,t,t.data_type_code),e.lines.push({test_id:t.test_id,test_code:t.test_code,test_desc:t.test_desc,qcunit_code:t.test_unit_code,data_type:t.data_type,data_type_code:t.data_type_code,negative_flag:"Y"===t.negative_flag,decimals:t.decimals,enable_flag:"Y"===t.enable_flag,qcunit_desc:t.test_unit,attachment_id:t.attachment_id,resultSeverity:t.serverity_code?t.serverity_code:"",disabledEdit:!!t.editable,isNegativeFlag:t.isNegativeFlag,isDecimals:t.isDecimals,attachments:t.attachments,isAttachments:t.isAttachments,limitImage:t.limitImage,isUploadFlag:t.isUploadFlag,entity:t.check_list_code,process:t.qm_process_code,entityTestSearchList:e.entityTestList,processTestSearchList:e.processDistinctTestList,test_type_code:t.test_type_code}),e.test_type_code=t.test_type_code,e.showData(a)}))},methods:{getCheckDataType:function(e,t,a){e==e&&("U"==a||"T"==a?(t.isNegativeFlag=!0,t.isDecimals=!0):(t.isNegativeFlag=!1,t.isDecimals=!1))},getQcunitDesc:function(e,t){var a=this.units.find((function(e){return t==e.qcunit_code}));e.qcunit_desc=a.qcunit_desc},handleRemove:function(e,t){},handlePreview:function(e){console.log(e)},handleExceed:function(e,t){swal({title:"คำเตือน !",text:"ไม่สามารถอัปโหลดรูปภาพเนื่องจากเกินจำนวนของรูปภาพ",type:"warning",showConfirmButton:!0})},beforeRemove:function(e,t){return this.$confirm("Cancel the transfert of ".concat(e.name," ?"))},handleChange:function(e,t){},removeFile:function(e){var t;t=this.test_type_code,swal({title:"คุณแน่ใจ?",text:"คุณที่จะต้องการลบรูปภาพนี้ใช่ไหม ?",type:"warning",showCancelButton:!0,confirmButtonClass:"btn btn-warning",confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก",closeOnConfirm:!1},(function(a){if(a)return axios.get("/qm/ajax/attachments/"+e+"/"+t+"/deleteByPKGDefineTests").then((function(e){console.log(e.data.message),"Success"==e.data.message&&(swal({title:"success !",text:"ลบรูปภาพสำเร็จ !",type:"success",showConfirmButton:!0}),setTimeout((function(){window.location.reload(!1)}),3e3))}))}))},showData:function(e){var t,a=this;return(t=i().mark((function t(){var s,n,l;return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:s=a,void 0!==e&&(""!=s.lines[e].entity&&null!=s.lines[e].entity||(s.lines[e].entityTestSearchList=null!=s.entityTestList&&s.entityTestList?s.entityTestList:[]),""!=s.lines[e].process&&null!=s.lines[e].process||(s.lines[e].processTestSearchList=null!=s.processTestList&&s.processTestList?s.processDistinctTestList:[]),s.lines[e].entity&&(n=s.entityTestList.filter((function(t){return t.entity_code==s.lines[e].entity}))).length>0&&(n=n[0],s.lines[e].processTestSearchList=s.processTestList.filter((function(e){return e.entity_code==n.entity_code}))),s.lines[e].process&&(l=s.processTestList.filter((function(t){return t.process_code==s.lines[e].process}))).length>0&&(l=l[0],s.lines[e].entityTestSearchList=s.entityTestList.filter((function(e){return e.process_code==l.process_code}))));case 2:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(s,i){var l=t.apply(e,a);function c(e){n(l,s,i,c,r,"next",e)}function r(e){n(l,s,i,c,r,"throw",e)}c(void 0)}))})()}}};const c=(0,a(51900).Z)(l,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table program_info_tb text-nowrap"},[a("thead",[a("tr",[e._m(0),e._v(" "),e._m(1),e._v(" "),e._m(2),e._v(" "),e._m(3),e._v(" "),e._m(4),e._v(" "),e._m(5),e._v(" "),e._m(6),e._v(" "),e._m(7),e._v(" "),"2"==this.test_type_code?a("th",{staticClass:"text-center"},[e._m(8)]):a("th",{staticClass:"text-center"},[e._m(9)]),e._v(" "),"2"==this.test_type_code?a("th",{staticClass:"text-center"},[a("label",[e._v("รายการตรวจสอบคุณภาพบุหรี่")])]):e._e(),e._v(" "),"2"==this.test_type_code?a("th",{staticClass:"text-center",staticStyle:{"min-width":"220px"}},[a("label",[e._v("กระบวนการตรวจคุณภาพบุหรี่ ")])]):e._e(),e._v(" "),e._m(10),e._v(" "),e._m(11),e._v(" "),a("th")])]),e._v(" "),e.lines.length?a("tbody",e._l(e.lines,(function(t,s){return a("tr",{key:s,attrs:{row:t}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.test_code,expression:"row.test_code"}],attrs:{type:"hidden",name:"dataGroup["+s+"][test_code]"},domProps:{value:t.test_code},on:{input:function(a){a.target.composing||e.$set(t,"test_code",a.target.value)}}}),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[e._v(e._s(s+1))]),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.enable_flag,expression:"row.enable_flag"}],attrs:{type:"hidden",name:"dataGroup["+s+"][enable_flag]"},domProps:{value:t.enable_flag},on:{input:function(a){a.target.composing||e.$set(t,"enable_flag",a.target.value)}}}),e._v(" "),a("el-checkbox",{model:{value:t.enable_flag,callback:function(a){e.$set(t,"enable_flag",a)},expression:"row.enable_flag"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.test_desc,expression:"row.test_desc"}],attrs:{type:"hidden",name:"dataGroup["+s+"][test_desc]"},domProps:{value:t.test_desc},on:{input:function(a){a.target.composing||e.$set(t,"test_desc",a.target.value)}}}),e._v(" "),a("el-input",{attrs:{placeholder:"กรอกลายละเอียด",type:"textarea"},model:{value:t.test_desc,callback:function(a){e.$set(t,"test_desc",a)},expression:"row.test_desc"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.qcunit_code,expression:"row.qcunit_code"}],attrs:{type:"hidden",name:"dataGroup["+s+"][qcunit_code]"},domProps:{value:t.qcunit_code},on:{input:function(a){a.target.composing||e.$set(t,"qcunit_code",a.target.value)}}}),e._v(" "),a("el-select",{attrs:{placeholder:"เลือก","reserve-keyword":"",filterable:""},on:{change:function(a){return e.getQcunitDesc(t,t.qcunit_code)}},model:{value:t.qcunit_code,callback:function(a){e.$set(t,"qcunit_code",a)},expression:"row.qcunit_code"}},e._l(e.units,(function(e,t){return a("el-option",{key:t,attrs:{label:e.qcunit_code,value:e.qcunit_code}})})),1)],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.qcunit_desc,expression:"row.qcunit_desc"}],attrs:{type:"hidden",name:"dataGroup["+s+"][qcunit_desc]"},domProps:{value:t.qcunit_desc},on:{input:function(a){a.target.composing||e.$set(t,"qcunit_desc",a.target.value)}}}),e._v(" "),a("el-input",{attrs:{disabled:!0},model:{value:t.qcunit_desc,callback:function(a){e.$set(t,"qcunit_desc",a)},expression:"row.qcunit_desc"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.data_type_code,expression:"row.data_type_code"}],attrs:{type:"hidden",name:"dataGroup["+s+"][data_type]"},domProps:{value:t.data_type_code},on:{input:function(a){a.target.composing||e.$set(t,"data_type_code",a.target.value)}}}),e._v(" "),a("el-select",{staticStyle:{width:"100px"},attrs:{placeholder:"เลือก",disabled:!0},on:{change:function(a){return e.getCheckDataType(s,t,t.data_type_code)}},model:{value:t.data_type_code,callback:function(a){e.$set(t,"data_type_code",a)},expression:"row.data_type_code"}},e._l(e.dataTypes,(function(e,t){return a("el-option",{key:t,attrs:{label:e.data_type,value:e.data_type_code}})})),1)],1),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"padding-top":"30px"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.negative_flag,expression:"row.negative_flag"}],attrs:{type:"hidden",name:"dataGroup["+s+"][negative_flag]"},domProps:{value:t.negative_flag},on:{input:function(a){a.target.composing||e.$set(t,"negative_flag",a.target.value)}}}),e._v(" "),a("el-checkbox",{attrs:{disabled:t.disabledEdit||t.isNegativeFlag},model:{value:t.negative_flag,callback:function(a){e.$set(t,"negative_flag",a)},expression:"row.negative_flag"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.decimals,expression:"row.decimals"}],attrs:{type:"hidden",name:"dataGroup["+s+"][decimals]"},domProps:{value:t.decimals},on:{input:function(a){a.target.composing||e.$set(t,"decimals",a.target.value)}}}),e._v(" "),a("el-input",{staticStyle:{width:"80px"},attrs:{disabled:t.disabledEdit||t.isDecimals,placeholder:"ทศนิยม"},model:{value:t.decimals,callback:function(a){e.$set(t,"decimals",a)},expression:"row.decimals"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.resultSeverity,expression:"row.resultSeverity"}],attrs:{type:"hidden",name:"dataGroup["+s+"][resultSeverity]"},domProps:{value:t.resultSeverity},on:{input:function(a){a.target.composing||e.$set(t,"resultSeverity",a.target.value)}}}),e._v(" "),a("el-select",{attrs:{placeholder:"เลือก",disabled:t.disabledEdit,"reserve-keyword":"",clearable:""},model:{value:t.resultSeverity,callback:function(a){e.$set(t,"resultSeverity",a)},expression:"row.resultSeverity"}},e._l(e.resultSeverites,(function(e,t){return a("el-option",{key:t,attrs:{label:e.meaning,value:e.meaning}})})),1)],1),e._v(" "),"2"==t.test_type_code?a("td",{staticStyle:{"vertical-align":"middle"}},[a("el-select",{staticClass:"w-100",attrs:{placeholder:"ไม่มีข้อมูล",clearable:"",filterable:"",remote:"","reserve-keyword":"",disabled:""},on:{change:function(t){return e.showData(s)}},model:{value:t.entity,callback:function(a){e.$set(t,"entity",a)},expression:"row.entity"}},e._l(t.entityTestSearchList,(function(e,t){return a("el-option",{key:t,attrs:{label:e.entity_meaning,value:e.entity_code}})})),1)],1):e._e(),e._v(" "),"2"==t.test_type_code?a("td",{staticStyle:{"vertical-align":"middle"}},[a("el-select",{staticClass:"w-100",attrs:{placeholder:"ไม่มีข้อมูล",clearable:"",filterable:"",remote:"","reserve-keyword":"",disabled:""},on:{change:function(t){return e.showData(s)}},model:{value:t.process,callback:function(a){e.$set(t,"process",a)},expression:"row.process"}},e._l(t.processTestSearchList,(function(e,t){return a("el-option",{key:t,attrs:{label:e.process_meaning,value:e.process_code}})})),1)],1):e._e(),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("el-upload",{staticClass:"upload-demo",attrs:{action:"http://web-service.test/qm/settings/define-tests-tobacco-leaf/update","on-preview":e.handlePreview,"on-remove":e.handleRemove,"before-remove":e.beforeRemove,"auto-upload":!1,name:"dataGroup["+s+"][files][]",multiple:"",limit:t.limitImage,"on-exceed":e.handleExceed,disabled:t.isUploadFlag,"file-list":e.fileList}},[a("el-button",{attrs:{size:"small",type:"primary",disabled:t.isUploadFlag}},[e._v("เพิ่มรูปภาพ")]),e._v(" "),a("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"},[e._v("สามารถเพิ่มได้อีก "+e._s(t.limitImage)+" รูป สูงสุดไม่เกิน 5 รูป")])],1)],1),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("button",{staticClass:"btn btn-primary",attrs:{type:"button","data-toggle":"modal","data-target":"#exampleModalScrollable"+t.test_id,disabled:t.isAttachments}},[a("i",{staticClass:"fa fa-file-image-o",attrs:{"aria-hidden":"true"}}),e._v(" ดูรูปภาพ\n                    ")]),e._v(" "),a("div",{staticClass:"modal fade",attrs:{id:"exampleModalScrollable"+t.test_id,tabindex:"-1",role:"dialog","aria-labelledby":"exampleModalScrollableTitle"+t.test_id,"aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-scrollable",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[e._m(12,!0),e._v(" "),a("div",{staticClass:"modal-body"},[a("ul",e._l(t.attachments,(function(t){return a("li",{key:t.attachment_id,staticStyle:{"text-align":"left"}},[a("a",{attrs:{target:e.hrefTarget,href:"attachments/"+t.attachment_id+"/"+e.test_type_code+"/imageDefineTests"}},[e._v("\n                                            "+e._s(t.file_name)+"\n                                        ")]),e._v(" "),a("a",{on:{click:function(a){return e.removeFile(t.attachment_id)}}},[a("i",{staticClass:"fa fa-close",staticStyle:{color:"red","text-align":"right"}})])])})),0)]),e._v(" "),e._m(13,!0)])])])])])})),0):a("tbody",[e._m(14)])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("ลำดับที่")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("สถานะ"),a("br"),e._v("การใช้งาน")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center",staticStyle:{"min-width":"300px"}},[a("label",[e._v("รายละเอียด การทดสอบ "),a("span",{staticClass:"text-danger"},[e._v(" *")])])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("หน่วยการทดสอบ "),a("span",{staticClass:"text-danger"},[e._v(" *")])])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("รายละเอียด"),a("br"),e._v("หน่วยการทดสอบ")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("ประเภทข้อมูล "),a("span",{staticClass:"text-danger"},[e._v(" *")])])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("สามารถติดลบได้")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("ทศนิยม "),a("span",{staticClass:"text-danger"},[e._v(" *")])])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("label",[e._v("ระดับความรุนแรง"),a("br"),e._v("ของข้อบกพร่อง")])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("label",[e._v("ระดับความรุนแรง"),a("br"),e._v("ของความผิดปกติ (อาการ)")])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("อัปโหลดรูปภาพประกอบ")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("th",{staticClass:"text-center"},[a("label",[e._v("รูปภาพประกอบ")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal-header"},[a("h5",{staticClass:"modal-title",attrs:{id:"exampleModalScrollableTitle"}},[e._v("ดูแนบรูปภาพ")]),e._v(" "),a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[a("span",{attrs:{"aria-hidden":"true"}},[e._v("×")])])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-secondary",attrs:{type:"button","data-dismiss":"modal"}},[e._v("ปิด")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("tr",[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle",width:"100%"},attrs:{colspan:"11"}},[a("h2",[e._v(" ไม่มีข้อมูลในระบบ ")])])])}],!1,null,null,null).exports}}]);