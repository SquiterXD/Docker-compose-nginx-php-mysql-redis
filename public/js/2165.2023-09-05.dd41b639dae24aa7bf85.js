(self.webpackChunk=self.webpackChunk||[]).push([[2165],{72165:(e,s,t)=>{"use strict";t.r(s),t.d(s,{default:()=>o});const a={props:["personId","pDisabled"],data:function(){return{employees:[],person_id:null!=this.personId&&""!=this.personId?parseInt(this.personId):"",loading:!1,states:[],disabled:!!this.pDisabled}},mounted:function(){""!==this.personId?this.getEmployees({person_id:this.personId}):this.employees=[]},methods:{remoteMethod:function(e){""!==e?this.getEmployees({name:e}):this.employees=[]},getEmployees:function(e){var s=this;this.loading=!0,axios.get("/example/ajax/users",{params:e}).then((function(e){var t=e.data;s.loading=!1,s.employees=t.data}))}}};const o=(0,t(51900).Z)(a,(function(){var e=this,s=e.$createElement,t=e._self._c||s;return t("div",{staticClass:"container"},[t("div",{staticClass:"row justify-content-center"},[t("div",{staticClass:"col-md-8"},[t("div",{staticClass:"card"},[t("div",{staticClass:"card-header"},[e._v("Example Vue")]),e._v(" "),t("div",{staticClass:"card-body"},[t("p",[e._v("I'm an example Vue.")]),e._v(" "),t("input",{attrs:{type:"hidden",name:"person_id",autocomplete:"off"},domProps:{value:e.person_id}}),e._v(" "),t("el-select",{attrs:{filterable:"",remote:"",disabled:e.disabled,placeholder:"ชื่อ หรือ นามสกุล","remote-method":e.remoteMethod,loading:e.loading},model:{value:e.person_id,callback:function(s){e.person_id=s},expression:"person_id"}},e._l(e.employees,(function(e){return t("el-option",{key:e.person_id,attrs:{label:e.full_name,value:e.person_id}})})),1)],1)])])])])}),[],!1,null,null,null).exports}}]);