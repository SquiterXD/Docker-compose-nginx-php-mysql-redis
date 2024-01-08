(self.webpackChunk=self.webpackChunk||[]).push([[2521,9809],{89809:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>u});var r=a(87757),n=a.n(r),o=a(30381),s=a.n(o);function i(t,e,a,r,n,o,s){try{var i=t[o](s),c=i.value}catch(t){return void a(t)}i.done?e(c):Promise.resolve(c).then(r,n)}function c(t){return function(){var e=this,a=arguments;return new Promise((function(r,n){var o=t.apply(e,a);function s(t){i(o,r,n,s,c,"next",t)}function c(t){i(o,r,n,s,c,"throw",t)}s(void 0)}))}}const l={props:["url","trans-date","trans-btn","default-program-code","infoAttributes","functionName"],data:function(){return{options:[],value:this.defaultProgramCode?this.defaultProgramCode:[],list:[],loading:!1,states:[],infos:[],programs:[],date:{},reportType:"pdf",errorLists:[],groupCodeList:[],carInsuranceeList:[],departmentList:[],departmentListTo:[],month:"",group_code:"",car_insurance:"",department_code_from:"",department_code_to:"",seq_1:!0,seq_2:!0,seq_3:!0,month_value:""}},methods:{getData:function(t){var e=this;return c(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:axios.get(e.url.getInfor).then((function(t){e.programs=t.data.programs})).then((function(){e.list=e.infos.map((function(t){return{value:"value:".concat(t.program_code),label:"label:".concat(t.program_code)}}))})).catch((function(t){}));case 1:case"end":return t.stop()}}),t)})))()},getInfos:function(){var t=this;return c(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.infoAttributes=[],t.functionName="",t.errorLists=[],axios.get(t.url.getInfoAttribute+"?program_code="+t.value).then((function(e){t.infoAttributes=e.data.reportInfor,t.functionName=e.data.functionName,t.functionReport=e.data.functionReport,t.programs=e.data.programs,t.options=e.data.programs})).then((function(){})).catch((function(t){}));case 4:case"end":return e.stop()}}),e)})))()},getYear:function(t,e){this.group_code_value="x111",this.month=t,console.log("value",t),console.log("month",e),t&&this.getGroupCode(),this.month_value=s()(t).add(-543,"years").format("Y-M-d")},exportReport:function(){},checkForm:function(t){if(this.month)return!0;swal({title:"Warning",text:"กรุณาระบุเดือน",type:"warning"}),t.preventDefault()},getGroupCode:function(){var t=this;console.log("func getGroupCode"),axios.get("/ir/reports/get-group-code",{params:{month:this.month}}).then((function(e){t.groupCodeList=e.data.data})).catch((function(t){}))},getCarInsurance:function(){var t=this;axios.get("/ir/reports/get-car-insurance",{params:{month:this.month,group_code:this.group_code}}).then((function(e){t.carInsuranceeList=e.data.data})).catch((function(t){}))},getDepartment:function(){var t=this;this.car_insurance&&axios.get("/ir/reports/get-department",{params:{month:this.month,group_code:this.group_code,car_insurance:this.car_insurance}}).then((function(e){t.departmentList=e.data.data})).catch((function(t){}))},getDepartmentTo:function(){var t=this;this.car_insurance&&axios.get("/ir/reports/get-department-to",{params:{month:this.month,group_code:this.group_code,car_insurance:this.car_insurance,department_code_from:this.department_code_from}}).then((function(e){t.departmentListTo=e.data.data})).catch((function(t){}))}}};const u=(0,a(51900).Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("form",{attrs:{action:t.url.getParam,method:"get",target:"_blank"},on:{submit:t.checkForm}},[a("hr",{staticClass:"m-3"}),t._v(" "),a("div",{staticClass:"row mb-2"},[t._m(0),t._v(" "),a("div",{staticClass:"col-6"},[a("datepicker-th",{staticClass:"form-control col-lg-12",staticStyle:{width:"100%","border-radius":"3px"},attrs:{id:"input_date",pType:"month",format:"MM/YYYY"},on:{dateWasSelected:function(e){for(var a=arguments.length,r=Array(a);a--;)r[a]=arguments[a];return t.getYear.apply(void 0,r.concat(["month"]))}},model:{value:t.month,callback:function(e){t.month=e},expression:"month"}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"month"},domProps:{value:t.month}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"month_value"},domProps:{value:t.month_value}})],1)]),t._v(" "),a("div",{staticClass:"row"},[t._m(1),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.month},on:{change:function(e){return t.getCarInsurance()}},model:{value:t.group_code,callback:function(e){t.group_code=e},expression:"group_code"}},[t._l(t.groupCodeList,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"group_code"},domProps:{value:t.group_code}})],2)],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[t._m(2),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.group_code},on:{change:function(e){return t.getDepartment()}},model:{value:t.car_insurance,callback:function(e){t.car_insurance=e},expression:"car_insurance"}},[t._l(t.carInsuranceeList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"car_insurance"},domProps:{value:t.car_insurance}})],2)],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[t._m(3),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.car_insurance},model:{value:t.department_code_from,callback:function(e){t.department_code_from=e},expression:"department_code_from"}},[t._l(t.departmentList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"department_code_from"},domProps:{value:t.department_code_from}})],2)],1)]),t._v(" "),a("div",{staticClass:"row mt-2 mb-2"},[t._m(4),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.car_insurance},model:{value:t.department_code_to,callback:function(e){t.department_code_to=e},expression:"department_code_to"}},[t._l(t.departmentList,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"department_code_to"},domProps:{value:t.department_code_to}})],2)],1)]),t._v(" "),a("input",{attrs:{type:"hidden",name:"program_code"},domProps:{value:t.value}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"function_name"},domProps:{value:t.functionName}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"output"},domProps:{value:t.reportType}}),t._v(" "),a("div",{staticClass:"text-center"},[a("button",{class:t.transBtn.printReport.class,attrs:{type:"submit"}},[a("i",{class:t.transBtn.printReport.icon}),t._v(" "+t._s(t.transBtn.printReport.text))])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    เดือน "),a("span",{staticClass:"tw-text-red-400"},[t._v("* ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    กลุ่ม\n                ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    ประเภทประกันภัย\n                ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    หน่วยงานตั้งแต่\n                ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    หน่วยงานถึง\n                ")])])}],!1,null,null,null).exports},72521:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>u});var r=a(87757),n=a.n(r),o=a(30381),s=a.n(o);function i(t,e,a,r,n,o,s){try{var i=t[o](s),c=i.value}catch(t){return void a(t)}i.done?e(c):Promise.resolve(c).then(r,n)}function c(t){return function(){var e=this,a=arguments;return new Promise((function(r,n){var o=t.apply(e,a);function s(t){i(o,r,n,s,c,"next",t)}function c(t){i(o,r,n,s,c,"throw",t)}s(void 0)}))}}const l={props:["url","trans-date","trans-btn","module","url-ger-param","default-program-code"],data:function(){return{options:[],value:this.defaultProgramCode?this.defaultProgramCode:[],list:[],loading:!1,states:[],infos:[],programs:[],infoAttributes:[],date:{},functionName:"",functionReport:"",reportType:"pdf",errorLists:[]}},mounted:function(){this.defaultProgramCode&&this.getInfos()},methods:{remoteMethod:function(t){var e=this;return c(n().mark((function a(){var r;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:r={params:{module:[e.module],uQuery:t}},axios.get(e.urlGerParam,r).then((function(t){e.programs=t.data.programs,e.options=t.data.programs})).catch((function(t){}));case 2:case"end":return a.stop()}}),a)})))()},remote:function(t){var e=this;return c(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:""!==t?(e.loading=!0,setTimeout((function(){e.loading=!1,e.options=e.programs.filter((function(e){if(e.program_code)return e.program_code.toLowerCase().indexOf(t.toLowerCase())>-1}))}),200)):e.options=[];case 1:case"end":return a.stop()}}),a)})))()},getData:function(t){var e=this;return c(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:axios.get(e.url.getInfor).then((function(t){e.programs=t.data.programs})).then((function(){e.list=e.infos.map((function(t){return{value:"value:".concat(t.program_code),label:"label:".concat(t.program_code)}}))})).catch((function(t){}));case 1:case"end":return t.stop()}}),t)})))()},getInfos:function(){var t=this;return c(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.infoAttributes=[],t.functionName="",t.errorLists=[],axios.get(t.url.getInfoAttribute+"?program_code="+t.value).then((function(e){t.infoAttributes=e.data.reportInfor,t.functionName=e.data.functionName,t.functionReport=e.data.functionReport,t.programs=e.data.programs,t.options=e.data.programs})).then((function(){})).catch((function(t){}));case 4:case"end":return e.stop()}}),e)})))()},getYear:function(t,e){"month"==e.date_type&&(e.form_value=s()(t).add(-543,"years").format(this.transDate["js-datatime-format"])),"year"==e.date_type&&(e.form_value=s()(t).add(-543,"years").format(this.transDate["js-year-format"])),"date"==e.date_type&&(e.form_value=s()(t).add(-543,"years").format(this.transDate["js-format"]))},exportReport:function(){},checkForm:function(t){var e=this;return"IRR0005_3"==this.functionName||(this.errorLists=[],this.infoAttributes.forEach((function(t){if(1==t.required&null==t.form_value){var a="โปรดระบุ.  "+t.display_value;e.errorLists.push(a)}})),0==this.errorLists.length||void t.preventDefault())},selectedList:function(t){return t.value},selectCheck:function(t,e){}},components:{IRR0005_3:a(89809).default}};const u=(0,a(51900).Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-select",{staticClass:"col-11",attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"Please enter a report ","remote-method":t.remoteMethod,clearable:""},on:{change:t.getInfos,input:function(e){return t.remoteMethod(" ")}},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.options,(function(t){return a("el-option",{key:t.program_code,attrs:{label:t.program_code+" "+t.description,value:t.program_code}})})),1),t._v(" "),"IRR0005_3"==t.functionName?a("div",[a("IRR0005_3",{attrs:{url:this.url,"trans-btn":this.transBtn,"trans-date":this.transDate,"default-program-code":this.value,"info-attributes":this.infoAttributes,"function-name":this.functionName}})],1):a("div",[a("form",{attrs:{action:t.url.getParam,method:"get",target:"_blank"},on:{submit:t.checkForm}},[a("hr",{staticClass:"m-3"}),t._v(" "),t.infoAttributes.length>0?a("div",{staticClass:"form-group"},[t._l(t.infoAttributes,(function(e,r){return a("div",{key:r},["text"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("  "+t._s(e.display_value)+" "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("input",{staticClass:"form-control w-100 ",attrs:{type:"text",name:e.attribute_name}})])]):t._e(),t._v(" "),"date"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                                "+t._s(e.display_value)+"  "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("datepicker-th",{staticClass:"form-control col-lg-12",staticStyle:{width:"100%","border-radius":"3px"},attrs:{id:"input_date",pType:e.date_type,format:e.format_date},on:{dateWasSelected:function(a){for(var r=arguments.length,n=Array(r);r--;)n[r]=arguments[r];return t.getYear.apply(void 0,n.concat([e]))}},model:{value:e.attribute_name[e.id],callback:function(a){t.$set(e.attribute_name,e.id,a)},expression:"infoAttribute.attribute_name[infoAttribute.id]"}}),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.form_value,expression:"infoAttribute.form_value"}],attrs:{type:"hidden",name:e.attribute_name},domProps:{value:e.form_value},on:{input:function(a){a.target.composing||t.$set(e,"form_value",a.target.value)}}})],1)]):t._e(),t._v(" "),"select"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v(t._s(e.display_value)+" "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1},on:{change:function(a){return t.selectCheck(e.attribute_3)}},model:{value:e.form_value,callback:function(a){t.$set(e,"form_value",a)},expression:"infoAttribute.form_value"}},[t._l(e.lists,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:e.attribute_name},domProps:{value:e.form_value}})],2)],1)]):t._e(),t._v(" "),"options"==e.form_type?a("div",{staticClass:"row m-2"},[a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v(t._s(e.display_value)+" "),"1"==e.required?a("span",{staticClass:"tw-text-red-400"},[t._v("* ")]):t._e()])]),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1},model:{value:e.form_value,callback:function(a){t.$set(e,"form_value",a)},expression:"infoAttribute.form_value"}},[t._l(e.lists,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:e.attribute_name},domProps:{value:e.form_value}})],2)],1)]):t._e()])})),t._v(" "),"Y"==t.functionReport.attribute_9?a("div",{staticClass:"row m-2"},[t._m(0),t._v(" "),a("div",{staticClass:"col-6"},[a("el-radio",{attrs:{label:"pdf"},model:{value:t.reportType,callback:function(e){t.reportType=e},expression:"reportType"}},[t._v(" PDF ")]),t._v(" "),a("el-radio",{attrs:{label:"excel"},model:{value:t.reportType,callback:function(e){t.reportType=e},expression:"reportType"}},[t._v(" Excel ")])],1)]):t._e(),t._v(" "),a("div",{staticClass:"row m-2"},[a("div",{staticClass:"col-12 text-center"},[t.errorLists.length>0?a("p"):t._e(),t._l(t.errorLists,(function(e,r){return a("div",{key:r,staticClass:"font-weight-bold text-danger"},[t._v("\n                                "+t._s(e)+"\n                            ")])})),t._v(" "),a("p")],2)]),t._v(" "),a("input",{attrs:{type:"hidden",name:"program_code"},domProps:{value:t.value}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"function_name"},domProps:{value:t.functionName}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"output"},domProps:{value:t.reportType}}),t._v(" "),a("div",{staticClass:"text-center"},[a("button",{class:t.transBtn.printReport.class,attrs:{type:"submit"}},[a("i",{class:t.transBtn.printReport.icon}),t._v(" "+t._s(t.transBtn.printReport.text))])])],2):t._e()])])],1)}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v(" ประเภทรายงาน "),a("span",{staticClass:"tw-text-red-400"},[t._v("* ")])])])}],!1,null,null,null).exports}}]);