(self.webpackChunk=self.webpackChunk||[]).push([[3838],{93838:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>n});const l={props:["departments","materialGroups"],data:function(){return{departmentSelected:"",departmentDescription:"",materialGroupSelected:"",typeDescription:""}},mounted:function(){},methods:{getDepartmentDescription:function(){var e=this,t=this.departments.find((function(t){if(t.department_code===e.departmentSelected)return t}));this.departmentDescription=t?t.description:""},getTypeDescription:function(){var e=this,t=this.materialGroups.find((function(t){if(t.type_code===e.materialGroupSelected)return t}));this.typeDescription=t?t.type_desc:""}}};const n=(0,a(51900).Z)(l,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"container"},[a("div",{staticClass:"row justify-content-center"},[a("div",{staticClass:"col-md-8"},[a("div",{staticClass:"row",staticStyle:{"padding-left":"15px","padding-top":"15px","padding-bottom":"15px","padding-right":"15px"}},[a("div",{staticClass:"col-md-6"},[a("label",[e._v("รหัสแผนก")]),a("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.departmentSelected,expression:"departmentSelected"}],attrs:{type:"hidden",name:"dept_code"},domProps:{value:e.departmentSelected},on:{input:function(t){t.target.composing||(e.departmentSelected=t.target.value)}}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{clearable:"",filterable:"",placeholder:"เลือกรหัสแผนก"},on:{change:e.getDepartmentDescription},model:{value:e.departmentSelected,callback:function(t){e.departmentSelected=t},expression:"departmentSelected"}},e._l(e.departments,(function(e){return a("el-option",{key:e.department_code,attrs:{label:e.department_code,value:e.department_code}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-6"},[a("label",[e._v("แผนก")]),e._v(" "),a("el-input",{staticClass:"w-100",attrs:{disabled:"",placeholder:"เลือกรหัสแผนก"},model:{value:e.departmentDescription,callback:function(t){e.departmentDescription=t},expression:"departmentDescription"}},e._l(e.departments,(function(e){return a("el-option",{key:e.department_code,attrs:{label:e.description,value:e.department_code}})})),1)],1)]),e._v(" "),a("div",{staticClass:"row",staticStyle:{"padding-left":"15px","padding-top":"15px","padding-bottom":"15px","padding-right":"15px"}},[a("div",{staticClass:"col-md-6"},[a("label",[e._v("รหัส")]),a("span",{staticClass:"text-danger"},[e._v(" *")]),e._v(" "),a("input",{directives:[{name:"model",rawName:"v-model",value:e.materialGroupSelected,expression:"materialGroupSelected"}],attrs:{type:"hidden",name:"itemcat_group_code"},domProps:{value:e.materialGroupSelected},on:{input:function(t){t.target.composing||(e.materialGroupSelected=t.target.value)}}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{clearable:"",filterable:"",placeholder:"เลือกรหัส"},on:{change:e.getTypeDescription},model:{value:e.materialGroupSelected,callback:function(t){e.materialGroupSelected=t},expression:"materialGroupSelected"}},e._l(e.materialGroups,(function(e){return a("el-option",{key:e.type_code,attrs:{label:e.type_code,value:e.type_code}})})),1)],1),e._v(" "),a("div",{staticClass:"col-md-6"},[a("label",[e._v("กลุ่มวัตถุดิบ")]),e._v(" "),a("el-input",{staticClass:"w-100",attrs:{disabled:"",placeholder:"เลือกรหัส"},model:{value:e.typeDescription,callback:function(t){e.typeDescription=t},expression:"typeDescription"}},e._l(e.materialGroups,(function(e){return a("el-option",{key:e.type_code,attrs:{label:e.type_desc,value:e.type_code}})})),1)],1)])])])])}),[],!1,null,null,null).exports}}]);