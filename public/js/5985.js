(self.webpackChunk=self.webpackChunk||[]).push([[5985],{5985:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>c});var s=a(87757),i=a.n(s);function n(e,t,a,s,i,n,l){try{var c=e[n](l),r=c.value}catch(e){return void a(e)}c.done?t(r):Promise.resolve(r).then(s,i)}const l={props:["units","dataTypes","resultSeverites","processTestList","entityTestList","processDistinctTestList"],data:function(){return{test_desc:"",qcunit_code:"",data_type_code:"",negative_flag:!1,decimals:"",enable_flag:!0,qcunit_desc:"",lines:[],fileList:[],isNegativeFlag:!1,isDecimals:!1}},mounted:function(){this.addLine()},methods:{addLine:function(){this.lines.push({test_desc:"",qcunit_code:"",data_type_code:"",negative_flag:!1,decimals:"",enable_flag:!0,qcunit_desc:"",fileList:[],resultSeverity:"",entity:"",process:"",entityTestSearchList:this.entityTestList,processTestSearchList:this.processDistinctTestList}),this.showData()},getQcunitDesc:function(e,t){var a=this.units.find((function(e){return t==e.qcunit_code}));e.qcunit_desc=a.qcunit_desc},getCheckDataType:function(e,t,a){e==e&&("U"==a||"T"==a?(t.isNegativeFlag=!0,t.isDecimals=!0,t.decimals="",t.isNegativeFlag=!1):(t.isNegativeFlag=!1,t.isDecimals=!1))},removeRow:function(e){this.lines.splice(e,1)},handleRemove:function(e,t){},handlePreview:function(e){console.log(e)},handleExceed:function(e,t){swal({title:"คำเตือน !",text:"สามารถเลือกไฟล์รูปภาพได้สูงสุด 5 ไฟล์",type:"warning",showConfirmButton:!0})},beforeRemove:function(e,t){return this.$confirm("Cancel the transfert of ".concat(e.name," ?"))},handleChange:function(e,t){},showData:function(e){var t,a=this;return(t=i().mark((function t(){var s,n,l;return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:s=a,void 0!==e&&(""!=s.lines[e].entity&&null!=s.lines[e].entity||(s.lines[e].entityTestSearchList=null!=s.entityTestList&&s.entityTestList?s.entityTestList:[]),""!=s.lines[e].process&&null!=s.lines[e].process||(s.lines[e].processTestSearchList=null!=s.processTestList&&s.processTestList?s.processDistinctTestList:[]),s.lines[e].entity&&(n=s.entityTestList.filter((function(t){return t.entity_code==s.lines[e].entity}))).length>0&&(n=n[0],s.lines[e].processTestSearchList=s.processTestList.filter((function(e){return e.entity_code==n.entity_code}))),s.lines[e].process&&(l=s.processTestList.filter((function(t){return t.process_code==s.lines[e].process}))).length>0&&(l=l[0],s.lines[e].entityTestSearchList=s.entityTestList.filter((function(e){return e.process_code==l.process_code}))));case 2:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(s,i){var l=t.apply(e,a);function c(e){n(l,s,i,c,r,"next",e)}function r(e){n(l,s,i,c,r,"throw",e)}c(void 0)}))})()}}};const c=(0,a(51900).Z)(l,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("div",{staticClass:"text-right",staticStyle:{"padding-bottom":"20px"}},[a("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"submit"},on:{click:function(t){return t.preventDefault(),e.addLine(t)}}},[a("i",{staticClass:"fa fa-plus",attrs:{"aria-hidden":"true"}}),e._v(" เพิ่มรายการ \n        ")])]),e._v(" "),a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table program_info_tb text-nowrap"},[e._m(0),e._v(" "),e.lines.length?a("tbody",e._l(e.lines,(function(t,s){return a("tr",{key:s,attrs:{row:t}},[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[e._v(e._s(s+1))]),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.enable_flag,expression:"row.enable_flag"}],attrs:{type:"hidden",name:"dataGroup["+s+"][enable_flag]"},domProps:{value:t.enable_flag},on:{input:function(a){a.target.composing||e.$set(t,"enable_flag",a.target.value)}}}),e._v(" "),a("el-checkbox",{model:{value:t.enable_flag,callback:function(a){e.$set(t,"enable_flag",a)},expression:"row.enable_flag"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.test_desc,expression:"row.test_desc"}],attrs:{type:"hidden",name:"dataGroup["+s+"][test_desc]"},domProps:{value:t.test_desc},on:{input:function(a){a.target.composing||e.$set(t,"test_desc",a.target.value)}}}),e._v(" "),a("el-input",{attrs:{placeholder:"กรอกลายละเอียด",type:"textarea"},model:{value:t.test_desc,callback:function(a){e.$set(t,"test_desc",a)},expression:"row.test_desc"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.qcunit_code,expression:"row.qcunit_code"}],attrs:{type:"hidden",name:"dataGroup["+s+"][qcunit_code]"},domProps:{value:t.qcunit_code},on:{input:function(a){a.target.composing||e.$set(t,"qcunit_code",a.target.value)}}}),e._v(" "),a("el-select",{attrs:{placeholder:"เลือก","reserve-keyword":""},on:{change:function(a){return e.getQcunitDesc(t,t.qcunit_code)}},model:{value:t.qcunit_code,callback:function(a){e.$set(t,"qcunit_code",a)},expression:"row.qcunit_code"}},e._l(e.units,(function(e,t){return a("el-option",{key:t,attrs:{label:e.qcunit_code,value:e.qcunit_code}})})),1)],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("el-input",{attrs:{disabled:!0},model:{value:t.qcunit_desc,callback:function(a){e.$set(t,"qcunit_desc",a)},expression:"row.qcunit_desc"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.data_type_code,expression:"row.data_type_code"}],attrs:{type:"hidden",name:"dataGroup["+s+"][data_type_code]"},domProps:{value:t.data_type_code},on:{input:function(a){a.target.composing||e.$set(t,"data_type_code",a.target.value)}}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{placeholder:"เลือก"},on:{change:function(a){return e.getCheckDataType(s,t,t.data_type_code)}},model:{value:t.data_type_code,callback:function(a){e.$set(t,"data_type_code",a)},expression:"row.data_type_code"}},e._l(e.dataTypes,(function(e,t){return a("el-option",{key:t,attrs:{label:e.data_type,value:e.data_type_code}})})),1)],1),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.negative_flag,expression:"row.negative_flag"}],attrs:{type:"hidden",name:"dataGroup["+s+"][negative_flag]"},domProps:{value:t.negative_flag},on:{input:function(a){a.target.composing||e.$set(t,"negative_flag",a.target.value)}}}),e._v(" "),a("el-checkbox",{attrs:{disabled:t.isNegativeFlag},model:{value:t.negative_flag,callback:function(a){e.$set(t,"negative_flag",a)},expression:"row.negative_flag"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.decimals,expression:"row.decimals"}],attrs:{type:"hidden",name:"dataGroup["+s+"][decimals]"},domProps:{value:t.decimals},on:{input:function(a){a.target.composing||e.$set(t,"decimals",a.target.value)}}}),e._v(" "),a("el-input",{staticClass:"w-100",attrs:{placeholder:"ทศนิยม",disabled:t.isDecimals},model:{value:t.decimals,callback:function(a){e.$set(t,"decimals",a)},expression:"row.decimals"}})],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.resultSeverity,expression:"row.resultSeverity"}],attrs:{type:"hidden",name:"dataGroup["+s+"][resultSeverity]"},domProps:{value:t.resultSeverity},on:{input:function(a){a.target.composing||e.$set(t,"resultSeverity",a.target.value)}}}),e._v(" "),a("el-select",{attrs:{placeholder:"เลือก",clearable:"","reserve-keyword":""},model:{value:t.resultSeverity,callback:function(a){e.$set(t,"resultSeverity",a)},expression:"row.resultSeverity"}},e._l(e.resultSeverites,(function(e,t){return a("el-option",{key:t,attrs:{label:e.meaning,value:e.meaning}})})),1)],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.entity,expression:"row.entity"}],attrs:{type:"hidden",name:"dataGroup["+s+"][entity]"},domProps:{value:t.entity},on:{input:function(a){a.target.composing||e.$set(t,"entity",a.target.value)}}}),e._v(" "),a("el-select",{attrs:{placeholder:"เลือก",clearable:"","reserve-keyword":""},on:{change:function(t){return e.showData(s)}},model:{value:t.entity,callback:function(a){e.$set(t,"entity",a)},expression:"row.entity"}},e._l(t.entityTestSearchList,(function(e,t){return a("el-option",{key:t,attrs:{label:e.entity_meaning,value:e.entity_code}})})),1)],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.process,expression:"row.process"}],attrs:{type:"hidden",name:"dataGroup["+s+"][process]"},domProps:{value:t.process},on:{input:function(a){a.target.composing||e.$set(t,"process",a.target.value)}}}),e._v(" "),a("el-select",{attrs:{placeholder:"เลือก",clearable:"","reserve-keyword":""},on:{change:function(t){return e.showData(s)}},model:{value:t.process,callback:function(a){e.$set(t,"process",a)},expression:"row.process"}},e._l(t.processTestSearchList,(function(e,t){return a("el-option",{key:t,attrs:{label:e.process_meaning,value:e.process_code}})})),1)],1),e._v(" "),a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[a("el-upload",{staticClass:"upload-demo",attrs:{action:"http://web-service.test/qm/settings/define-tests-tobacco-leaf/store","on-preview":e.handlePreview,"on-remove":e.handleRemove,"before-remove":e.beforeRemove,"auto-upload":!1,name:"dataGroup["+s+"][files][]",multiple:"",limit:5,"on-exceed":e.handleExceed,"file-list":e.fileList}},[a("el-button",{attrs:{size:"small",type:"primary"}},[e._v("เพิ่มรูปภาพ")]),e._v(" "),a("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"},[e._v("สามารถอัปโหลดรูปภาพสูงสุด 5 รูปภาพ")])],1)],1),e._v(" "),a("td",{staticStyle:{"vertical-align":"middle"}},[a("button",{staticClass:"btn btn-sm btn-danger",on:{click:function(t){return t.preventDefault(),e.removeRow(s)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])})),0):a("tbody",[e._m(1)])])])])}),[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("thead",[a("tr",[a("th",{staticClass:"text-center"},[a("label",[e._v("ลำดับที่")])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("สถานะ"),a("br"),e._v("การใช้งาน")])]),e._v(" "),a("th",{staticClass:"text-center",staticStyle:{"min-width":"300px"}},[a("label",[e._v("รายละเอียด การทดสอบ "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("หน่วยการทดสอบ "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("รายละเอียด หน่วยการทดสอบ")])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("ประเภทข้อมูล "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("สามารถติดลบได้")])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("ทศนิยม "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("ระดับความรุนแรงของข้อบกพร่อง "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("รายการตรวจสอบคุณภาพบุหรี่ "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("กระบวนการตรวจคุณภาพบุหรี่ "),a("span",{staticClass:"text-danger"},[e._v(" *")])])]),e._v(" "),a("th",{staticClass:"text-center"},[a("label",[e._v("รูปภาพประกอบ")])]),e._v(" "),a("th")])])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("tr",[a("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle",width:"100%"},attrs:{colspan:"11"}},[a("h2",[e._v(' ยังไม่มีข้อมูลที่จะสร้างใหม่ในตอนนี้ กรุณา "กด เพิ่มรายการ" ')])])])}],!1,null,null,null).exports}}]);