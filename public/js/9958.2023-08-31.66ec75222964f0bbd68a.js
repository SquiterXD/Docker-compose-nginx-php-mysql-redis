(self.webpackChunk=self.webpackChunk||[]).push([[9958],{19958:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>l});var n=a(87757),r=a.n(n),o=a(30381),s=a.n(o);function i(t,e,a,n,r,o,s){try{var i=t[o](s),c=i.value}catch(t){return void a(t)}i.done?e(c):Promise.resolve(c).then(n,r)}function c(t){return function(){var e=this,a=arguments;return new Promise((function(n,r){var o=t.apply(e,a);function s(t){i(o,n,r,s,c,"next",t)}function c(t){i(o,n,r,s,c,"throw",t)}s(void 0)}))}}const u={props:["url","trans-date","trans-btn","default-program-code","infoAttributes","functionName"],data:function(){return{options:[],value:this.defaultProgramCode?this.defaultProgramCode:[],list:[],loading:!1,states:[],infos:[],programs:[],date:{},reportType:"pdf",errorLists:[],groupCodeList:[],carInsuranceeList:[],departmentList:[],departmentListTo:[],month:"",group_code:"",car_insurance:"",department_code_from:"",department_code_to:"",seq_1:!0,seq_2:!0,seq_3:!0,month_value:""}},methods:{getData:function(t){var e=this;return c(r().mark((function t(){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:axios.get(e.url.getInfor).then((function(t){e.programs=t.data.programs})).then((function(){e.list=e.infos.map((function(t){return{value:"value:".concat(t.program_code),label:"label:".concat(t.program_code)}}))})).catch((function(t){}));case 1:case"end":return t.stop()}}),t)})))()},getInfos:function(){var t=this;return c(r().mark((function e(){return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.infoAttributes=[],t.functionName="",t.errorLists=[],axios.get(t.url.getInfoAttribute+"?program_code="+t.value).then((function(e){t.infoAttributes=e.data.reportInfor,t.functionName=e.data.functionName,t.functionReport=e.data.functionReport,t.programs=e.data.programs,t.options=e.data.programs})).then((function(){})).catch((function(t){}));case 4:case"end":return e.stop()}}),e)})))()},getYear:function(t,e){this.group_code_value="x111",this.month=t,console.log("value",t),console.log("month",e),t&&this.getGroupCode(),this.month_value=s()(t).add(-543,"years").format("MM/DD/YYYY")},exportReport:function(){},checkForm:function(t){if(this.month)return!0;swal({title:"Warning",text:"กรุณาระบุเดือน",type:"warning"}),t.preventDefault()},getGroupCode:function(){var t=this;console.log("func getGroupCode"),axios.get("/ir/reports/get-group-code",{params:{month:this.month}}).then((function(e){t.groupCodeList=e.data.data})).catch((function(t){}))},getCarInsurance:function(){var t=this;axios.get("/ir/reports/get-car-insurance",{params:{month:this.month,group_code:this.group_code}}).then((function(e){t.carInsuranceeList=e.data.data})).catch((function(t){}))},getDepartment:function(){var t=this;this.car_insurance&&axios.get("/ir/reports/get-department",{params:{month:this.month,group_code:this.group_code,car_insurance:this.car_insurance}}).then((function(e){t.departmentList=e.data.data})).catch((function(t){}))},getDepartmentTo:function(){var t=this;this.car_insurance&&axios.get("/ir/reports/get-department-to",{params:{month:this.month,group_code:this.group_code,car_insurance:this.car_insurance,department_code_from:this.department_code_from}}).then((function(e){t.departmentListTo=e.data.data})).catch((function(t){}))}}};const l=(0,a(51900).Z)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("form",{attrs:{action:t.url.getParam,method:"get",target:"_blank"},on:{submit:t.checkForm}},[a("hr",{staticClass:"m-3"}),t._v(" "),a("div",{staticClass:"row mb-2"},[t._m(0),t._v(" "),a("div",{staticClass:"col-6"},[a("datepicker-th",{staticClass:"form-control col-lg-12",staticStyle:{width:"100%","border-radius":"3px"},attrs:{id:"input_date",pType:"month",format:"MM/YYYY"},on:{dateWasSelected:function(e){for(var a=arguments.length,n=Array(a);a--;)n[a]=arguments[a];return t.getYear.apply(void 0,n.concat(["month"]))}},model:{value:t.month,callback:function(e){t.month=e},expression:"month"}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"month"},domProps:{value:t.month}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"month_value"},domProps:{value:t.month_value}})],1)]),t._v(" "),a("div",{staticClass:"row"},[t._m(1),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.month},on:{change:function(e){return t.getCarInsurance()}},model:{value:t.group_code,callback:function(e){t.group_code=e},expression:"group_code"}},[t._l(t.groupCodeList,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"group_code"},domProps:{value:t.group_code}})],2)],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[t._m(2),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.group_code},on:{change:function(e){return t.getDepartment()}},model:{value:t.car_insurance,callback:function(e){t.car_insurance=e},expression:"car_insurance"}},[t._l(t.carInsuranceeList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"car_insurance"},domProps:{value:t.car_insurance}})],2)],1)]),t._v(" "),a("div",{staticClass:"row mt-2"},[t._m(3),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.car_insurance},model:{value:t.department_code_from,callback:function(e){t.department_code_from=e},expression:"department_code_from"}},[t._l(t.departmentList,(function(t,e){return a("el-option",{key:e,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"department_code_from"},domProps:{value:t.department_code_from}})],2)],1)]),t._v(" "),a("div",{staticClass:"row mt-2 mb-2"},[t._m(4),t._v(" "),a("div",{staticClass:"col-6"},[a("el-select",{staticClass:"w-100 text-left",attrs:{filterable:"",clearable:"","popper-append-to-body":!1,disabled:!this.car_insurance},model:{value:t.department_code_to,callback:function(e){t.department_code_to=e},expression:"department_code_to"}},[t._l(t.departmentList,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),t._v(" "),a("input",{attrs:{type:"hidden",name:"department_code_to"},domProps:{value:t.department_code_to}})],2)],1)]),t._v(" "),a("input",{attrs:{type:"hidden",name:"program_code"},domProps:{value:t.value}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"function_name"},domProps:{value:t.functionName}}),t._v(" "),a("input",{attrs:{type:"hidden",name:"output"},domProps:{value:t.reportType}}),t._v(" "),a("div",{staticClass:"text-center"},[a("button",{class:t.transBtn.printReport.class,attrs:{type:"submit"}},[a("i",{class:t.transBtn.printReport.icon}),t._v(" "+t._s(t.transBtn.printReport.text))])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    เดือน "),a("span",{staticClass:"tw-text-red-400"},[t._v("* ")])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    กลุ่ม\n                ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    ประเภทประกันภัย\n                ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    หน่วยงานตั้งแต่\n                ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"m-1 col-3 text-right"},[a("div",[t._v("\n                    หน่วยงานถึง\n                ")])])}],!1,null,null,null).exports}}]);