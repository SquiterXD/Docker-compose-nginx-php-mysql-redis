(self.webpackChunk=self.webpackChunk||[]).push([[1476],{51476:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>d});var s=a(87757),i=a.n(s);const r={props:["program","infos","list-form-types","info","url","method-url","csrf"],data:function(){return{defaultListFormType:"",dateTypes:{year:"Year",month:"Month",date:"Date"},orderByTypes:{asc:"ASC",desc:"DESC"},errors:[],form:{seq:this.info.seq?this.info.seq:"",attributeName:this.info.attribute_name?this.info.attribute_name:"",formType:this.info?this.info.form_type:"",displayValue:this.info?this.info.display_value:"",purpose:this.info?this.info.purpose:"",defaultValue:this.info?this.info.default_value:"",input:"",required:this.info?this.info.required:"",dateTypeSelected:this.info?this.info.date_ty:"",viewOrTable:this.info?this.info.view_or_table:"",fieldValue:this.info?this.info.field_value:"",fieldDescription:this.info?this.info.field_description:"",groupBy:this.info?this.info.group_by:"",orderBy:this.info?this.info.order_by:"",orderByType:this.info?this.info.order_by_type:"",program_code:this.program.program_code}}},components:{},mounted:function(){},methods:{modalOpen:function(){},checkForm:function(t){if(this.errors=[],this.form.seq)return!0;this.form.seq||this.errors.push("Name seq."),t.preventDefault()},updateForm:function(){this.form.seq=this.info.seq?this.info.seq:"",this.form.attributeName=this.info.attribute_name?this.info.attribute_name:"",this.form.formType=this.info?this.info.form_type:"",this.form.displayValue="",this.form.purpose="",this.form.defaultValue="",this.form.input="",this.form.required="",this.form.dateTypeSelected="",this.form.viewOrTable="",this.form.fieldValue="",this.form.fieldDescription="",this.form.groupBy="",this.form.orderBy="",this.form.orderByType="",this.form.program_code=this.program.program_code}},watch:{}};var o=a(51900);const n={props:["program","infos","list-form-types","info","url","method-url"],data:function(){return{}},components:{},mounted:function(){},methods:{modalOpen:function(){},checkForm:function(t){},updateForm:function(){},getYear:function(t){}},watch:{}};function l(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}const m={props:["program","infos","list-form-types","info","url","method-url","csrf","trans-date"],data:function(){var t;return{defaultListFormType:"",dateTypes:{year:"Year",month:"Month",date:"Date"},orderByTypes:{asc:"ASC",desc:"DESC"},errors:[],form:(t={seq:this.info.seq?this.info.seq:"",attributeName:this.info.attribute_name?this.info.attribute_name:"",formType:this.info?this.info.form_type:"",displayValue:this.info?this.info.display_value:"",purpose:this.info?this.info.purpose:"",defaultValue:this.info?this.info.default_value:"",input:"",required:!!this.info&&"1"==this.info.required,dateTypeSelected:this.info?this.info.date_ty:"",viewOrTable:this.info?this.info.view_or_table:"",fieldValue:this.info?this.info.field_value:"",fieldDescription:this.info?this.info.field_description:"",groupBy:this.info?this.info.group_by:"",orderBy:this.info?this.info.order_by:"",orderByType:this.info?this.info.order_by_type:"",program_code:this.program.program_code,options:this.info?this.info.options:""},l(t,"dateTypeSelected",this.info?this.info.date_type:""),l(t,"formatDate",this.info?this.info.attribute_1:""),l(t,"defaultFromField",this.info?this.info.attribute_2:""),l(t,"dependent",this.info?this.info.attribute_3:""),t)}},components:{},mounted:function(){},methods:{modalOpen:function(){},checkForm:function(t){if(this.errors=[],this.form.seq)return!0;this.form.seq||this.errors.push("Name seq."),t.preventDefault()},updateForm:function(){this.form.seq=this.info.seq?this.info.seq:"",this.form.attributeName=this.info.attribute_name?this.info.attribute_name:"",this.form.formType=this.info?this.info.form_type:"",this.form.displayValue="",this.form.purpose="",this.form.defaultValue="",this.form.input="",this.form.required="",this.form.dateTypeSelected="",this.form.viewOrTable="",this.form.fieldValue="",this.form.fieldDescription="",this.form.groupBy="",this.form.orderBy="",this.form.orderByType="",this.form.program_code=this.program.program_code,this.form.defaultFromField="",this.form.dependent=""}},watch:{}};function c(t,e,a,s,i,r,o){try{var n=t[r](o),l=n.value}catch(t){return void a(t)}n.done?e(l):Promise.resolve(l).then(s,i)}const u={name:"settings-report-info",props:["program","infos","list-form-types","url","csrf","trans-date","sys-date","func"],data:function(){return{info:"",newInfos:this.infos,functionName:this.func?this.func.function:"",mulTiType:!!this.func&&"Y"==this.func.attribute_9,form:{attributeName:""},copyShowForm:!1,value:"",options:[],programs:[],module:null}},components:{createInfo:(0,o.Z)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("form",{attrs:{action:"create"===t.methodUrl?t.url.storeInfo:t.url.storeInfo+"/"+t.info.report_info_id,method:"POST"},on:{submit:t.checkForm}},[t._m(0),t._v(" "),t._m(1),t._v(" "),a("hr",{staticClass:"m-b-xs"}),t._v(" "),a("div",{staticClass:"row clearfix"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(2),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.seq,expression:"form.seq"}],staticClass:"form-control",attrs:{type:"text",name:"seq",autocomplet:"off"},domProps:{value:t.form.seq},on:{input:function(e){e.target.composing||t.$set(t.form,"seq",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(3),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.attributeName,expression:"form.attributeName"}],staticClass:"form-control",attrs:{name:"attribute_name",type:"text",autocomplet:"off"},domProps:{value:t.form.attributeName},on:{input:function(e){e.target.composing||t.$set(t.form,"attributeName",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(4),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.form.formType,expression:"form.formType"}],staticClass:"form-control",attrs:{name:"form_type"},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.form,"formType",e.target.multiple?a:a[0])}}},t._l(t.listFormTypes,(function(e,s){return a("option",{key:s,domProps:{value:s}},[t._v(t._s(e)+"\n                            ")])})),0)])]),t._v(" "),"select"===t.form.formType?a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(5),t._v(" "),a("div",{attrs:{id:"div_txt_form_value_create"}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.viewOrTable,expression:"form.viewOrTable"}],staticClass:"form-control",attrs:{autocomplet:"off",name:"view_or_table"},domProps:{value:t.form.viewOrTable},on:{input:function(e){e.target.composing||t.$set(t.form,"viewOrTable",e.target.value)}}})])])]):t._e(),t._v(" "),"date"===t.form.formType?a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(6),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.form.dateTypeSelected,expression:"form.dateTypeSelected"}],staticClass:"form-control",attrs:{name:"date_type"},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.form,"dateTypeSelected",e.target.multiple?a:a[0])}}},t._l(t.dateTypes,(function(e){return a("option",{key:e,domProps:{value:e}},[t._v(t._s(e)+"\n                            ")])})),0)])]):t._e(),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(7),t._v(" "),a("div",{attrs:{id:"div_txt_form_value_create"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.defaultValue,expression:"form.defaultValue"}],staticClass:"form-control",attrs:{name:"default_value",type:"text",autocomplet:"off"},domProps:{value:t.form.defaultValue},on:{input:function(e){e.target.composing||t.$set(t.form,"defaultValue",e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(8),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.displayValue,expression:"form.displayValue"}],staticClass:"form-control",attrs:{name:"display_value",type:"text",autocomplet:"off"},domProps:{value:t.form.displayValue},on:{input:function(e){e.target.composing||t.$set(t.form,"displayValue",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(9),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.purpose,expression:"form.purpose"}],staticClass:"form-control",attrs:{name:"purpose",type:"text",autocomplet:"off"},domProps:{value:t.form.purpose},on:{input:function(e){e.target.composing||t.$set(t.form,"purpose",e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"checkbox"},[a("label",[t._v("\n                                required (บังคับกรอก)\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.required,expression:"form.required"}],attrs:{type:"checkbox",id:"required",name:"required"},domProps:{checked:Array.isArray(t.form.required)?t._i(t.form.required,null)>-1:t.form.required},on:{change:function(e){var a=t.form.required,s=e.target,i=!!s.checked;if(Array.isArray(a)){var r=t._i(a,null);s.checked?r<0&&t.$set(t.form,"required",a.concat([null])):r>-1&&t.$set(t.form,"required",a.slice(0,r).concat(a.slice(r+1)))}else t.$set(t.form,"required",i)}}})])])])]),t._v(" "),a("div",{staticClass:"row m-t-sm"},[t.errors.length>0?a("p",[a("ul",t._l(t.errors,(function(e,s){return a("li",{key:s},[t._v("\n                                "+t._s(e)+"\n                            ")])})),0)]):t._e()])]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.program_code,expression:"form.program_code"}],attrs:{type:"hidden",name:"program_code"},domProps:{value:t.form.program_code},on:{input:function(e){e.target.composing||t.$set(t.form,"program_code",e.target.value)}}})]),t._v(" "),a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),t._m(10)])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("h3",{staticClass:"m-b-md"},[a("div",[t._v("Create Report Infomation")]),t._v(" "),a("div",[a("small",[t._v("สร้างข้อมูลรายละเอียดของรายงานใหม่")])]),t._v(" "),a("span",{staticClass:"pull-right hide",attrs:{id:"progress_modal"}})])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Seq\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ลำดับที่")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Attribute Name\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ชื่อแอตทริบิวต์")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Form Type\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ประเภทข้อมูล")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("label",[a("div",[t._v("\n                                    View or table\n                                    "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Date picker Type\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ประเภทข้อมูล date picker")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("label",[a("div",[t._v("\n                                    Default Value\n                                ")]),t._v(" "),a("div",[a("small",[t._v("ข้อมูล")])])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("Display")]),t._v(" "),a("div",[a("small",[t._v("แสดง")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("Purpose")]),t._v(" "),a("div",[a("small",[t._v("จุดประสงค์")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row clearfix text-right"},[a("div",{staticClass:"col-sm-12"},[a("button",{staticClass:"btn btn-sm btn-primary",attrs:{id:"btn_create",type:"submit"}},[t._v("\n                    save\n                ")]),t._v(" "),a("button",{staticClass:"btn btn-sm btn-white",attrs:{type:"button","data-dismiss":"modal"}},[t._v("\n                    Cancel\n                ")])])])}],!1,null,null,null).exports,previewInfo:(0,o.Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"form-group"},["text"==t.info.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v(t._s(t.info.display_value))])]),t._v(" "),a("div",{staticClass:"col-6"},[a("el-input",{attrs:{name:t.info.attribute_name},model:{value:t.info.default_value,callback:function(e){t.$set(t.info,"default_value",e)},expression:"info.default_value"}})],1)]):t._e(),t._v(" "),"date"==t.info.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    "+t._s(t.info.display_value)+"\n                ")])]),t._v(" "),a("div",{staticClass:"col-6"},[a("datepicker-th",{staticClass:"form-control col-lg-12",staticStyle:{width:"100%","border-radius":"3px"},attrs:{placeholder:"เลือกวัน",name:t.info.attribute_name,id:"input_date",pType:t.info.date_type},on:{dateWasSelected:t.getYear},model:{value:t.info.default_value,callback:function(e){t.$set(t.info,"default_value",e)},expression:"info.default_value"}})],1)]):t._e(),t._v(" "),"select"==t.info.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v(t._s(t.info.display_value))])]),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"",name:t.info.attribute_name,"popper-append-to-body":!1},model:{value:t.info.default_value,callback:function(e){t.$set(t.info,"default_value",e)},expression:"info.default_value"}},t._l(t.info.lists,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("button",{staticClass:"btn btn-primary btn-xs col-2"},[t._v(" Save ")])]):t._e()])}),[],!1,null,null,null).exports,formCreate:(0,o.Z)(m,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("form",{attrs:{action:"create"===t.methodUrl?t.url.storeInfo:t.url.storeInfo+"/"+t.info.report_info_id,method:"POST"}},[a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),t._m(0),t._v(" "),a("div",{staticClass:"row clearfix"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(1),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.seq,expression:"form.seq"}],staticClass:"form-control",attrs:{name:"seq",type:"text",autocomplet:"off"},domProps:{value:t.form.seq},on:{input:function(e){e.target.composing||t.$set(t.form,"seq",e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"col-sm-6"},[a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(2),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.attributeName,expression:"form.attributeName"}],staticClass:"form-control",attrs:{name:"attribute_name",type:"text",autocomplet:"off"},domProps:{value:t.form.attributeName},on:{input:function(e){e.target.composing||t.$set(t.form,"attributeName",e.target.value)}}})])])]),t._v(" "),a("div",{staticClass:"col-sm-6"},[a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(3),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.displayValue,expression:"form.displayValue"}],staticClass:"form-control",attrs:{name:"display_value",type:"text",autocomplet:"off"},domProps:{value:t.form.displayValue},on:{input:function(e){e.target.composing||t.$set(t.form,"displayValue",e.target.value)}}})])])])]),t._v(" "),a("div",{staticClass:"row clearfix"},[a("div",{staticClass:"col-sm-6"},[a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(4),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.form.formType,expression:"form.formType"}],staticClass:"form-control",attrs:{name:"form_type"},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.form,"formType",e.target.multiple?a:a[0])}}},t._l(t.listFormTypes,(function(e,s){return a("option",{key:s,domProps:{value:s}},[t._v(t._s(e)+"\n                            ")])})),0)])])]),t._v(" "),a("div",{staticClass:"col-sm-6"},["select"===t.form.formType?a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(5),t._v(" "),a("div",{attrs:{id:"div_txt_form_value_create"}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.viewOrTable,expression:"form.viewOrTable"}],staticClass:"form-control",attrs:{autocomplet:"off",name:"view_or_table"},domProps:{value:t.form.viewOrTable},on:{input:function(e){e.target.composing||t.$set(t.form,"viewOrTable",e.target.value)}}})])])]):t._e(),t._v(" "),"options"===t.form.formType?a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(6),t._v(" "),a("div",{attrs:{id:"div_txt_form_value_create"}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.form.options,expression:"form.options"}],staticClass:"form-control",attrs:{autocomplet:"off",name:"options"},domProps:{value:t.form.options},on:{input:function(e){e.target.composing||t.$set(t.form,"options",e.target.value)}}})])])]):t._e(),t._v(" "),"date"===t.form.formType?a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[t._m(7),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.form.dateTypeSelected,expression:"form.dateTypeSelected"}],staticClass:"form-control",attrs:{name:"date_type"},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.form,"dateTypeSelected",e.target.multiple?a:a[0])}}},t._l(t.dateTypes,(function(e,s){return a("option",{key:s,domProps:{value:s}},[t._v(" "+t._s(s)+"\n                            ")])})),0),t._v(" "),t._m(8),t._v(" "),a("select",{directives:[{name:"model",rawName:"v-model",value:t.form.formatDate,expression:"form.formatDate"}],staticClass:"form-control",attrs:{name:"format_date"},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.$set(t.form,"formatDate",e.target.multiple?a:a[0])}}},t._l(t.transDate,(function(e,s){return a("option",{key:s,domProps:{value:e}},[t._v(" "+t._s(s+" : "+e)+"\n                            ")])})),0)])]):t._e(),t._v(" "),"text"===t.form.formType?a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"})]):t._e()])]),t._v(" "),a("div",{staticClass:"row clearfix"},[a("div",{staticClass:"col-sm-6"},[a("div",{staticClass:"row m-t-sm"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"checkbox"},[a("label",[t._v("\n                                required (บังคับกรอก)\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:t.form.required,expression:"form.required"}],attrs:{type:"checkbox",id:"required",name:"required"},domProps:{checked:Array.isArray(t.form.required)?t._i(t.form.required,null)>-1:t.form.required},on:{change:function(e){var a=t.form.required,s=e.target,i=!!s.checked;if(Array.isArray(a)){var r=t._i(a,null);s.checked?r<0&&t.$set(t.form,"required",a.concat([null])):r>-1&&t.$set(t.form,"required",a.slice(0,r).concat(a.slice(r+1)))}else t.$set(t.form,"required",i)}}})])])])])])]),t._v(" "),a("div",{staticClass:"row clearfix text-right pt-4"},[a("div",{staticClass:"col-sm-12"},[a("button",{staticClass:"btn btn-sm btn-primary",attrs:{id:"btn_create",type:"submit"}},[t._v("\n                   "+t._s("create"==t.methodUrl?"Create":"Update")+"\n                ")])])])]),t._v(" "),a("hr",{staticClass:"m-b-xs"})])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("h3",{staticClass:"m-b-md"},[a("div",[t._v("Create Report Infomation")]),t._v(" "),a("div",[a("small",[t._v("สร้างข้อมูลรายละเอียดของรายงานใหม่")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                SEQ\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ลำดับ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Attribute Name\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ชื่อแอตทริบิวต์")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("Display")]),t._v(" "),a("div",[a("small",[t._v("แสดง")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Form Type\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ประเภทข้อมูล")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("label",[a("div",[t._v("\n                                    SQL\n                                    "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("label",[a("div",[t._v("\n                                    Options\n                                    "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("label",[a("div",[t._v("\n                                Date picker Type\n                                "),a("span",{staticClass:"text-danger"},[t._v("*")])]),t._v(" "),a("div",[a("small",[t._v("ประเภทข้อมูล date picker")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"mt-2 mb-2"},[a("small",[t._v("Format date")])])}],!1,null,null,null).exports},methods:{update:function(){this.newInfos.map((function(t,e){t.new_seq=e+1}))},modalOpen:function(t){this.info=null!==t?t:{}},getYear:function(t){},showCopy:function(){this.copyShowForm=!this.copyShowForm},remoteMethod:function(t){var e,a=this;return(e=i().mark((function e(){var s;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:s={params:{module:[a.module],uQuery:t}},axios.get("/report/ajax/get-report-programs",s).then((function(t){a.programs=t.data.programs,a.options=t.data.programs})).catch((function(t){}));case 2:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(s,i){var r=e.apply(t,a);function o(t){c(r,s,i,o,n,"next",t)}function n(t){c(r,s,i,o,n,"throw",t)}o(void 0)}))})()}}};const d=(0,o.Z)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-3 b-r hidden-xs hidden-sm"},[a("form",{attrs:{action:t.url.saveFunction,method:"POST"}},[a("h4",[t._v("Report Detail")]),t._v(" "),a("ul",{staticClass:"list-group clear-list m-t"},[a("li",{staticClass:"list-group-item fist-item"},[t._v("\n                Program Code :\n                "),a("span",{staticClass:"pull-right"},[t._v("\n                    "+t._s(t.program.program_code)+"\n                ")])]),t._v(" "),a("li",{staticClass:"list-group-item fist-item"},[t._v("\n                Report Name :\n                "),a("span",{staticClass:"pull-right"},[t._v("\n                    "+t._s(t.program.description)+"\n                ")])]),t._v(" "),a("li",{staticClass:"list-group-item fist-item"},[t._v("\n                Input Function Report\n            ")]),t._v(" "),a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),a("li",{staticClass:"list-group-item fist-item"},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.functionName,expression:"functionName"}],staticClass:"form-control",attrs:{name:"function_name",rows:"2"},domProps:{value:t.functionName},on:{input:function(e){e.target.composing||(t.functionName=e.target.value)}}})]),t._v(" "),a("li",{staticClass:"list-group-item fist-item mt-2"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.mulTiType,expression:"mulTiType"}],attrs:{type:"checkbox",id:"required",name:"multi_type"},domProps:{checked:Array.isArray(t.mulTiType)?t._i(t.mulTiType,null)>-1:t.mulTiType},on:{change:function(e){var a=t.mulTiType,s=e.target,i=!!s.checked;if(Array.isArray(a)){var r=t._i(a,null);s.checked?r<0&&(t.mulTiType=a.concat([null])):r>-1&&(t.mulTiType=a.slice(0,r).concat(a.slice(r+1)))}else t.mulTiType=i}}}),t._v(" "),a("label",[t._v(" Multi Type Report ")])])]),t._v(" "),a("button",{staticClass:"pull-right btn btn-primary btn-xs",attrs:{type:"submit"}},[t._v(" Save ")])])]),t._v(" "),a("div",{staticClass:"col-md-9"},[a("form",{attrs:{action:"/report/report-info/report-info-copy/copy-program/"+t.value+"/"+t.program.program_code,method:"GET"}},[a("div",{staticClass:"row m-2 p-2 ",attrs:{alight:"right"}},[a("div",{staticClass:"col-12 text-right"},[a("button",{staticClass:"btn btn-outline-dark",attrs:{type:"button"},on:{click:t.showCopy}},[t._v(" Copy from program")])])]),t._v(" "),1==t.copyShowForm?a("div",{staticClass:"bg-muted row text-right p-4"},[a("el-select",{staticClass:"col-8",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"Please enter a report ","remote-method":t.remoteMethod,clearable:""},on:{input:function(e){return t.remoteMethod(" ")}},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.options,(function(t){return a("el-option",{key:t.program_code,attrs:{label:t.program_code+" "+t.description,value:t.program_code}})})),1),t._v(" "),a("button",{staticClass:"btn btn-primary pull-right",attrs:{type:"submit"}},[t._v(" Copy program ")])],1):t._e()]),t._v(" "),a("div",{staticClass:"clearfix"},[a("formCreate",{attrs:{program:t.program,infos:t.infos,"list-form-types":t.listFormTypes,url:t.url,info:t.info,"method-url":"create",csrf:t.csrf,transDate:t.transDate}})],1),t._v(" "),a("div",{staticClass:"table-responsive"},[t.newInfos.length>0?a("div",{staticClass:"form-group"},t._l(t.newInfos,(function(e,s){return a("div",{key:s},["text"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-1 text-right"},[a("div",[t._v(t._s(e.seq))])]),t._v(" "),a("div",{staticClass:"m-1 col-2 text-right"},[a("div",[t._v(t._s(e.display_value)+"  "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("input",{staticClass:"form-control w-100 ",attrs:{type:"text",name:e.attribute_name}})]),t._v(" "),a("div",{staticClass:"pull-right form-inline"},[a("a",{staticClass:"btn btn-outline btn-warning btn-xs",attrs:{href:"#","data-toggle":"modal","data-target":"#edit_"+e.report_info_id},on:{click:function(a){return t.modalOpen(e)}}},[a("i",{staticClass:"fa fa-pencil"}),t._v("แก้ไข\n                                ")]),t._v(" "),a("form",{staticClass:"m-2",attrs:{action:t.url.storeInfo+"/"+e.report_info_id+"/delete",method:"post",onsubmit:"return confirm('Do you really want to submit the form?');"}},[a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),t._m(0,!0)])])]):t._e(),t._v(" "),"date"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-1 text-right"},[a("div",[t._v(t._s(e.seq))])]),t._v(" "),a("div",{staticClass:"m-1 col-2 text-right"},[a("div",[t._v("\n                                    "+t._s(e.display_value)+" "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("datepicker-th",{staticClass:"form-control col-lg-12",staticStyle:{width:"100%","border-radius":"3px"},attrs:{placeholder:"เลือกวัน",name:e.attribute_name,id:"input_date",pType:e.date_type,format:e.attribute_1},on:{dateWasSelected:t.getYear},model:{value:e.attribute_name,callback:function(a){t.$set(e,"attribute_name",a)},expression:"info.attribute_name"}})],1),t._v(" "),a("div",{staticClass:"pull-right form-inline"},[a("a",{staticClass:"btn btn-outline btn-warning btn-xs",attrs:{href:"#","data-toggle":"modal","data-target":"#edit_"+e.report_info_id},on:{click:function(a){return t.modalOpen(e)}}},[a("i",{staticClass:"fa fa-pencil"}),t._v("แก้ไข\n                                ")]),t._v(" "),a("form",{staticClass:"m-2",attrs:{action:t.url.storeInfo+"/"+e.report_info_id+"/delete",method:"post",onsubmit:"return confirm('Do you really want to submit the form?');"}},[a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),t._m(1,!0)])])]):t._e(),t._v(" "),"select"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-1 text-right"},[a("div",[t._v(t._s(e.seq))])]),t._v(" "),a("div",{staticClass:"m-1 col-2 text-right"},[a("div",[t._v(t._s(e.display_value)+" "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"",name:e.attribute_name,"popper-append-to-body":!1},model:{value:e.default_value,callback:function(a){t.$set(e,"default_value",a)},expression:"info.default_value"}},t._l(e.lists,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("div",{staticClass:"pull-right form-inline"},[a("a",{staticClass:"btn btn-outline btn-warning btn-xs",attrs:{href:"#","data-toggle":"modal","data-target":"#edit_"+e.report_info_id},on:{click:function(a){return t.modalOpen(e)}}},[a("i",{staticClass:"fa fa-pencil"}),t._v("แก้ไข\n                                ")]),t._v(" "),a("form",{staticClass:"m-2",attrs:{action:t.url.storeInfo+"/"+e.report_info_id+"/delete",method:"post",onsubmit:"return confirm('Do you really want to submit the form?');"}},[a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),t._m(2,!0)])])]):t._e(),t._v(" "),"options"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-1 text-right"},[a("div",[t._v(t._s(e.seq))])]),t._v(" "),a("div",{staticClass:"m-1 col-2 text-right"},[a("div",[t._v(t._s(e.display_value)+" "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("select",{staticClass:"form-control w-100",attrs:{name:e.attribute_name}},t._l(e.lists,(function(e){return a("option",{key:e.value,domProps:{value:e.value}},[t._v(t._s(e.label)+"\n                                    ")])})),0)]),t._v(" "),a("div",{staticClass:"pull-right form-inline"},[a("a",{staticClass:"btn btn-outline btn-warning btn-xs",attrs:{href:"#","data-toggle":"modal","data-target":"#edit_"+e.report_info_id},on:{click:function(a){return t.modalOpen(e)}}},[a("i",{staticClass:"fa fa-pencil"}),t._v("แก้ไข\n                                ")]),t._v(" "),a("form",{staticClass:"m-2",attrs:{action:t.url.storeInfo+"/"+e.report_info_id+"/delete",method:"post",onsubmit:"return confirm('Do you really want to submit the form?');"}},[a("input",{attrs:{type:"hidden",name:"_token"},domProps:{value:t.csrf}}),t._v(" "),t._m(3,!0)])])]):t._e(),t._v(" "),a("div",{staticClass:"modal inmodal fade",staticStyle:{display:"none"},attrs:{id:"edit_"+e.report_info_id,tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg"},[a("div",{staticClass:"modal-content"},[a("div",{staticClass:"modal-content"},[a("div",{staticClass:"modal-body"},[a("formCreate",{attrs:{program:t.program,infos:t.infos,"list-form-types":t.listFormTypes,url:t.url,info:e,"method-url":"update",csrf:t.csrf,transDate:t.transDate}})],1)])])])])])})),0):t._e()])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-outline btn-danger btn-xs",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-times"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-outline btn-danger btn-xs",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-times"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-outline btn-danger btn-xs",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-times"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-outline btn-danger btn-xs",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-times"})])}],!1,null,null,null).exports}}]);