(self.webpackChunk=self.webpackChunk||[]).push([[7500],{34827:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>i});var r=s(23645),n=s.n(r)()((function(e){return e[1]}));n.push([e.id,".mx-datepicker{height:32px}",""]);const i=n},67500:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>l});var r=s(87757),n=s.n(r);s(30381);function i(e,t,s,r,n,i,o){try{var m=e[i](o),a=m.value}catch(e){return void s(e)}m.done?t(a):Promise.resolve(a).then(r,n)}function o(e){return function(){var t=this,s=arguments;return new Promise((function(r,n){var o=e.apply(t,s);function m(e){i(o,r,n,m,a,"next",e)}function a(e){i(o,r,n,m,a,"throw",e)}m(void 0)}))}}var m;const a={props:["search","defaultValueSetName","defaultValue","urlSave","urlReset"],data:function(){return{loading:!1,value:"",detail:"",account_code:this.defaultValue?this.defaultValue.account_code:"",description:this.defaultValue?this.defaultValue.description:"",segment1:this.defaultValue?this.defaultValue.segment_1:"",segment2:this.defaultValue?this.defaultValue.segment_2:"",segment3:this.defaultValue?this.defaultValue.segment_3:"",segment4:this.defaultValue?this.defaultValue.segment_4:"",segment5:this.defaultValue?this.defaultValue.segment_5:"",segment6:this.defaultValue?this.defaultValue.segment_6:"",segment7:this.defaultValue?this.defaultValue.segment_7:"",segment8:this.defaultValue?this.defaultValue.segment_8:"",segment9:this.defaultValue?this.defaultValue.segment_9:"",segment10:this.defaultValue?this.defaultValue.segment_10:"",segment11:this.defaultValue?this.defaultValue.segment_11:"",segment12:this.defaultValue?this.defaultValue.segment_12:"",active_flag:!this.defaultValue||"Y"==this.defaultValue.active_flag,start_date:this.defaultValue?this.defaultValue.start_date:"",end_date:this.defaultValue?this.defaultValue.end_date:"",disableEdit:!!this.defaultValue&&!!this.defaultValue.account_code,option1:[],option2:[],option3:[],option4:[],option5:[],option6:[],option7:[],option8:[],option9:[],option10:[],option11:[],option12:[],coaEnter:this.search?this.search.account_from:"",encumbrances:[],errors:{period:!1,segmentOverride:!1,account_code:!1,description:!1,segment1:!1,segment2:!1,segment3:!1,segment4:!1,segment5:!1,segment6:!1,segment7:!1,segment8:!1,segment9:!1,segment10:!1,segment11:!1,segment12:!1},get_data_flag:!1,sel_concate_segment:"",check_duplicate_code:"",check_duplicate_description:"",errorForms:[],successForm:!1,csrf:document.querySelector('meta[name="csrf-token"]').getAttribute("content"),account_id:this.defaultValue?this.defaultValue.account_id:""}},watch:{errors:{handler:function(e){e.segmentOverride?this.setError("segmentOverride"):this.resetError("segmentOverride"),e.account_code?this.setError("account_code"):this.resetError("account_code"),e.description?this.setError("description"):this.resetError("description")},deep:!0},successForm:(m=o(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:this.successForm&&(this.errorForms.length||submitForm.submit());case 1:case"end":return e.stop()}}),e,this)}))),function(){return m.apply(this,arguments)})},methods:{checkDuplicateCode:function(){var e=this;return o(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.check_duplicate_code="",axios.get("/ir/ajax/validate-account-mapping",{params:{type:"code",account_code:e.account_code}}).then((function(t){e.check_duplicate_code=t.data,e.check_duplicate_code&&(swal({title:"มีข้อผิดพลาด",text:"Code ซ้ำกับในระบบ",timer:5e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),e.account_code="")})).catch((function(e){}));case 2:case"end":return t.stop()}}),t)})))()},checkDuplicateDscription:function(){var e=this;return o(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.check_duplicate_description="",axios.get("/ir/ajax/validate-account-mapping",{params:{type:"description",description:e.description}}).then((function(t){e.check_duplicate_description=t.data,e.check_duplicate_description&&(swal({title:"มีข้อผิดพลาด",text:"description ซ้ำกับในระบบ",timer:5e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),e.description="")})).catch((function(e){}));case 2:case"end":return t.stop()}}),t)})))()},updateCoa:function(e){e.name==this.defaultValueSetName.segment1&&(this.segment1=e.segment1),e.name==this.defaultValueSetName.segment2&&(this.segment2=e.segment2),e.name==this.defaultValueSetName.segment3&&(this.segment3=e.segment3,this.segment4="",this.option3=e.options),e.name==this.defaultValueSetName.segment4&&(this.segment4=e.segment4,this.option4=e.options),e.name==this.defaultValueSetName.segment5&&(this.segment5=e.segment5,this.option5=e.options),e.name==this.defaultValueSetName.segment6&&(this.segment6=e.segment6,this.segment7="",this.option6=e.options),e.name==this.defaultValueSetName.segment7&&(this.segment7=e.segment7,this.option7=e.options),e.name==this.defaultValueSetName.segment8&&(this.segment8=e.segment8,this.option8=e.options),e.name==this.defaultValueSetName.segment9&&(this.segment9=e.segment9,this.segment10="",this.option9=e.options),e.name==this.defaultValueSetName.segment10&&(this.segment10=e.segment10,this.option10=e.options),e.name==this.defaultValueSetName.segment11&&(this.segment11=e.segment11,this.option11=e.options),e.name==this.defaultValueSetName.segment12&&(this.segment12=e.segment12,this.option12=e.options)},enterAccSegment:function(){var e,t=this,s=$("#modal-flexfield");this.errors.segmentOverride=!1,$(s).find("div[id='el_explode_segment']").html("");var r=this.coaEnter.split(".");return 12!=r.length||""==r[0]||""==r[1]||""==r[2]||""==r[3]||""==r[4]||""==r[5]||""==r[6]||""==r[7]||""==r[8]||""==r[9]||""==r[10]||""==r[11]?(swal({title:"Warning",text:"กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ",timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),this.errors.segmentOverride=!0,!1,e="กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ",$(s).find("div[id='el_explode_segment']").html(e),this.segment1="",this.segment2="",this.segment3="",this.segment4="",this.segment5="",this.segment6="",this.segment7="",this.segment8="",this.segment9="",this.segment10="",this.segment11="",void(this.segment12="")):void axios.get("/ir/ajax/validate-combination",{params:{segmentAlls:r,account_code:this.coaEnter}}).then((function(n){return"E"==n.data.status?(swal({title:"Warning",text:n.data.error_msg,type:"warning"}),t.errors.segmentOverride=!0,!1,e="กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ",$(s).find("div[id='el_explode_segment']").html(e),t.segment1="",t.segment2="",t.segment3="",t.segment4="",t.segment5="",t.segment6="",t.segment7="",t.segment8="",t.segment9="",t.segment10="",t.segment11="",void(t.segment12="")):"S"==n.data.status?(t.segment1=r[0],t.segment2=r[1],t.segment3=r[2],t.segment4=r[3],t.segment5=r[4],t.segment6=r[5],t.segment7=r[6],t.segment8=r[7],t.segment9=r[8],t.segment10=r[9],t.segment11=r[10],void(t.segment12=r[11])):void 0}))},clearAccSegment:function(){var e=$("#modal-flexfield");this.errors.segmentOverride=!1,$(e).find("div[id='el_explode_segment']").html(""),this.coaEnter="",this.segment1="",this.segment2="",this.segment3="",this.segment4="",this.segment5="",this.segment6="",this.segment7="",this.segment8="",this.segment9="",this.segment10="",this.segment11="",this.segment12=""},setError:function(e){(this.$refs[e].$refs.reference?this.$refs[e].$refs.reference.$refs.input:this.$refs[e].$refs.textarea?this.$refs[e].$refs.textarea:this.$refs[e].$refs.input.$refs?this.$refs[e].$refs.input.$refs.input:this.$refs[e].$refs.input).style="border: 1px solid red;"},resetError:function(e){(this.$refs[e].$refs.reference?this.$refs[e].$refs.reference.$refs.input:this.$refs[e].$refs.textarea?this.$refs[e].$refs.textarea:this.$refs[e].$refs.input.$refs?this.$refs[e].$refs.input.$refs.input:this.$refs[e].$refs.input).style=""},errorRef:function(e){var t=this;t.errors.account_code=e.err.account_code,t.errors.description=e.err.description,t.errors.segment1=e.err.segment1,t.errors.segment2=e.err.segment2,t.errors.segment3=e.err.segment3,t.errors.segment4=e.err.segment4,t.errors.segment5=e.err.segment5,t.errors.segment6=e.err.segment6,t.errors.segment7=e.err.segment7,t.errors.segment8=e.err.segment8,t.errors.segment9=e.err.segment9,t.errors.segment10=e.err.segment10,t.errors.segment11=e.err.segment11,t.errors.segment12=e.err.segment12},submit:function(){var e=this;console.log("submit func");var t=this.segment1+"."+this.segment2+"."+this.segment3+"."+this.segment4+"."+this.segment5+"."+this.segment6+"."+this.segment7+"."+this.segment8+"."+this.segment9+"."+this.segment10+"."+this.segment11+"."+this.segment12,s=t.split(".");axios.get("/ir/ajax/validate-combination",{params:{segmentAlls:s,account_code:t}}).then((function(t){if("E"==t.data.status)return swal({title:"Warning",text:t.data.error_msg,type:"warning"}),e.segment1="",e.segment2="",e.segment3="",e.segment4="",e.segment5="",e.segment6="",e.segment7="",e.segment8="",e.segment9="",e.segment10="",e.segment11="",void(e.segment12="");"S"==t.data.status&&e.checkForm()}))},checkForm:function(e){var t=this;return o(n().mark((function s(){var r,i,o;return n().wrap((function(s){for(;;)switch(s.prev=s.next){case 0:r=t,i=$("#submitForm"),i.serialize(),r.errorForms=[],!0,o="",r.errors.account_code=!1,r.errors.description=!1,r.errors.segment1=!1,r.errors.segment2=!1,r.errors.segment3=!1,r.errors.segment4=!1,r.errors.segment5=!1,r.errors.segment6=!1,r.errors.segment7=!1,r.errors.segment8=!1,r.errors.segment9=!1,r.errors.segment10=!1,r.errors.segment11=!1,r.errors.segment12=!1,$(i).find("div[id='el_explode_account_code']").html(""),$(i).find("div[id='el_explode_description']").html(""),$(i).find("div[id='el_explode_segment1']").html(""),$(i).find("div[id='el_explode_segment2']").html(""),$(i).find("div[id='el_explode_segment3']").html(""),$(i).find("div[id='el_explode_segment4']").html(""),$(i).find("div[id='el_explode_segment5']").html(""),$(i).find("div[id='el_explode_segment6']").html(""),$(i).find("div[id='el_explode_segment7']").html(""),$(i).find("div[id='el_explode_segment8']").html(""),$(i).find("div[id='el_explode_segment9']").html(""),$(i).find("div[id='el_explode_segment10']").html(""),$(i).find("div[id='el_explode_segment11']").html(""),$(i).find("div[id='el_explode_segment12']").html(""),r.account_code?r.disableEdit||(r.check_duplicate_code="",axios.get("/ir/ajax/validate-account-mapping",{params:{type:"code",account_code:r.account_code}}).then((function(e){r.check_duplicate_code=e.data,r.check_duplicate_code?swal({title:"มีข้อผิดพลาด",text:"Code ซ้ำกับในระบบ",timer:5e3,type:"error",showCancelButton:!1,showConfirmButton:!1}):r.successForm=!0})).catch((function(e){}))):(r.errorForms.push("Code"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.account_code=!0,!1,o="กรุณาระบุ Code",$(i).find("div[id='el_explode_account_code']").html(o)),r.description?(r.check_duplicate_description="",axios.get("/ir/ajax/validate-account-mapping",{params:{type:"description",description:r.description,account_id:r.account_id}}).then((function(e){r.check_duplicate_description=e.data,r.check_duplicate_description?(r.errorForms.push("description ซ้ำกับในระบบ"),swal({title:"มีข้อผิดพลาด",text:r.errorForms,timer:5e3,type:"error",showCancelButton:!1,showConfirmButton:!1})):r.successForm=!0})).catch((function(e){}))):(r.errorForms.push("Description"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.description=!0,!1,o="กรุณาระบุ Description",$(i).find("div[id='el_explode_description']").html(o)),r.segment1||(r.errorForms.push("COMPANY"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment1=!0,!1,o="กรุณาเลือก COMPANY",$(i).find("div[id='el_explode_segment1']").html(o)),r.segment2||(r.errorForms.push("EVM"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment2=!0,!1,o="กรุณาเลือก EVM",$(i).find("div[id='el_explode_segment2']").html(o)),r.segment3||(r.errorForms.push("DEPARTMENT"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment3=!0,!1,o="กรุณาเลือก DEPARTMENT",$(i).find("div[id='el_explode_segment3']").html(o)),r.segment4||(r.errorForms.push("COST CENTER"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment4=!0,!1,o="กรุณาเลือก COST CENTER",$(i).find("div[id='el_explode_segment4']").html(o)),r.segment5||(r.errorForms.push("BUDGET YEAR"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment5=!0,!1,o="กรุณาเลือก BUDGET YEAR",$(i).find("div[id='el_explode_segment5']").html(o)),r.segment6||(r.errorForms.push("BUDGET TYPE"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment6=!0,!1,o="กรุณาเลือก BUDGET TYPE",$(i).find("div[id='el_explode_segment6']").html(o)),r.segment7||(r.errorForms.push("BUDGET DETAIL"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment7=!0,!1,o="กรุณาเลือก BUDGET DETAIL",$(i).find("div[id='el_explode_segment7']").html(o)),r.segment8||(r.errorForms.push("BUDGET REASON"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment8=!0,!1,o="กรุณาเลือก BUDGET REASON",$(i).find("div[id='el_explode_segment8']").html(o)),r.segment9||(r.errorForms.push("MAIN ACCOUNT"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment9=!0,!1,o="กรุณาเลือก MAIN ACCOUNT",$(i).find("div[id='el_explode_segment9']").html(o)),r.segment10||(r.errorForms.push("SUB ACCOUNT"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment10=!0,!1,o="กรุณาเลือก SUB ACCOUNT",$(i).find("div[id='el_explode_segment10']").html(o)),r.segment11||(r.errorForms.push("RESERVED1"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment11=!0,!1,o="กรุณาเลือก RESERVED1",$(i).find("div[id='el_explode_segment11']").html(o)),r.segment12||(r.errorForms.push("RESERVED2"),swal({title:"มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",text:r.errorForms,timer:3e3,type:"error",showCancelButton:!1,showConfirmButton:!1}),r.errors.segment12=!0,!1,o="กรุณาเลือก RESERVED2",$(i).find("div[id='el_explode_segment12']").html(o)),r.successForm&&(r.errorForms.length||i.submit()),r.errorForms.length||r.successForm&&i.submit(),e.preventDefault();case 51:case"end":return s.stop()}}),s)})))()}}};s(56792);const l=(0,s(51900).Z)(a,undefined,undefined,!1,null,null,null).exports},56792:(e,t,s)=>{var r=s(34827);r.__esModule&&(r=r.default),"string"==typeof r&&(r=[[e.id,r,""]]),r.locals&&(e.exports=r.locals);(0,s(45346).Z)("7e14699b",r,!0,{})}}]);