(self.webpackChunk=self.webpackChunk||[]).push([[1385],{1385:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>n});var a=s(23570),i=s.n(a);const o={props:["policySets","header","subLines","btnTrans"],data:function(){return{lines:[],id:i()(),policyHeader:this.header.policy_set_header_id,activeRow:""}},mounted:function(){var e=this;this.subLines.forEach((function(t){e.lines.push({id:i()(),subId:t.sub_group_id,subCode:t.sub_group_code,subGroupSource:t.sub_group_source,subDescription:t.sub_group_description,active:"Y"==t.active_flag,openRow:!0,delRow:!1})}))},methods:{addLine:function(){this.lines.push({id:"Item #"+this.lines.length,subGroupCode:"",subGroupDescription:"",subGroupSource:"",active:!0,openRow:!1,delRow:!0}),window.scrollTo({top:document.body.scrollHeight,left:0,behavior:"smooth"})},removeRow:function(e,t,s){t&&this.lines.splice(e,1)},checkInactive:function(e,t){var s={active:e.active?"Y":"N",sub_group_code:e.subCode,id:e.subId};return console.log(t),axios.get("/ir/ajax/sub-groups/check-inactive",{params:s}).then((function(t){"success"==t.data.status?swal({title:"Success !",text:"บันทึกสำเร็จ",type:"success",showConfirmButton:!0}):(swal({title:"Error !",text:"ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่ที่หน้าจอ IRM0005",type:"error",showConfirmButton:!0}),e.active=!0)}))},checkDuplicateSubGroupCode:function(e){var t=this;this.lines.forEach((function(s,a){a!=e&&t.lines[e].subCode==s.subCode&&swal({title:"warning !",text:"รหัสข้อมูลซ้ำ",type:"warning",showConfirmButton:!0})}))}}};const n=(0,s(51900).Z)(o,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("input",{directives:[{name:"model",rawName:"v-model",value:e.policyHeader,expression:"policyHeader"}],attrs:{type:"hidden",name:"policyHeader",autocomplete:"off"},domProps:{value:e.policyHeader},on:{input:function(t){t.target.composing||(e.policyHeader=t.target.value)}}}),e._v(" "),s("div",{staticClass:"text-right"},[s("button",{class:e.btnTrans.add.class+" btn-sm",attrs:{type:"submit",id:"myBtn"},on:{click:function(t){return t.preventDefault(),e.addLine(t)}}},[s("i",{class:e.btnTrans.add.icon,attrs:{"aria-hidden":"true"}}),e._v(" \n            "+e._s(e.btnTrans.add.text)+" \n        ")])]),s("br"),e._v(" "),s("table",{staticClass:"table table-responsive-sm"},[e._m(0),e._v(" "),s("tbody",[s("input",{directives:[{name:"model",rawName:"v-model",value:e.policyHeader,expression:"policyHeader"}],attrs:{type:"hidden",name:"policyHeader",autocomplete:"off"},domProps:{value:e.policyHeader},on:{input:function(t){t.target.composing||(e.policyHeader=t.target.value)}}}),e._v(" "),e._l(e.lines,(function(t,a){return s("tr",{key:a,attrs:{row:t}},[s("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[e._v(" "+e._s(a+1)+" ")]),e._v(" "),s("td",[s("input",{directives:[{name:"model",rawName:"v-model",value:t.subId,expression:"row.subId"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][sub_group_id]",autocomplete:"off"},domProps:{value:t.subId},on:{input:function(s){s.target.composing||e.$set(t,"subId",s.target.value)}}}),e._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.subCode,expression:"row.subCode"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][sub_group_code]",autocomplete:"off"},domProps:{value:t.subCode},on:{input:function(s){s.target.composing||e.$set(t,"subCode",s.target.value)}}}),e._v(" "),s("el-input",{attrs:{placeholder:"ระบุรหัส",size:"mediem",disabled:t.openRow},on:{change:function(t){return e.checkDuplicateSubGroupCode(a)}},model:{value:t.subCode,callback:function(s){e.$set(t,"subCode",s)},expression:"row.subCode"}})],1),e._v(" "),s("td",[s("input",{directives:[{name:"model",rawName:"v-model",value:t.subDescription,expression:"row.subDescription"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][sub_group_description]",autocomplete:"off"},domProps:{value:t.subDescription},on:{input:function(s){s.target.composing||e.$set(t,"subDescription",s.target.value)}}}),e._v(" "),s("el-input",{attrs:{placeholder:"ระบุคำอธิบาย",size:"mediem"},model:{value:t.subDescription,callback:function(s){e.$set(t,"subDescription",s)},expression:"row.subDescription"}})],1),e._v(" "),s("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.active,expression:"row.active"}],attrs:{type:"hidden",name:"dataGroup["+t.id+"][active_flag]",autocomplete:"off"},domProps:{value:t.active},on:{input:function(s){s.target.composing||e.$set(t,"active",s.target.value)}}}),e._v(" "),s("el-checkbox",{staticClass:"text-center",on:{change:function(s){return e.checkInactive(t,a)}},model:{value:t.active,callback:function(s){e.$set(t,"active",s)},expression:"row.active"}})],1),e._v(" "),t.delRow?s("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}},[s("button",{staticClass:"btn btn-sm btn-danger",attrs:{id:"click"},on:{click:function(s){return s.preventDefault(),e.removeRow(a,t.delRow,t)}}},[s("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])]):s("td",{staticClass:"text-center",staticStyle:{"vertical-align":"middle"}})])}))],2)])])}),[function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("thead",[s("tr",[s("th",{staticClass:"text-center",attrs:{width:"1%"}}),e._v(" "),s("th",{attrs:{width:"10%"}},[e._v(" รหัส (Code) "),s("span",{staticClass:"text-danger"},[e._v(" *")])]),e._v(" "),s("th",{attrs:{width:"20%"}},[e._v(" คำอธิบาย (Description) "),s("span",{staticClass:"text-danger"},[e._v(" *")])]),e._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}},[e._v(" Active "),s("span",{staticClass:"text-danger"},[e._v(" *")])]),e._v(" "),s("th",{staticClass:"text-center",attrs:{width:"5%"}})])])}],!1,null,null,null).exports}}]);