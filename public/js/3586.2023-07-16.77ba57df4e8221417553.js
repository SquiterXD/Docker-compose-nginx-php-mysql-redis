(self.webpackChunk=self.webpackChunk||[]).push([[3586],{53586:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>s});const i={name:"ir-settings-policy-search",props:["btnTrans","dataSearch"],data:function(){return{policiesLov:[],loading:!1,active_flag:"",policy_set_header_id:"",search_url:this.dataSearch.search_url,activeLists:[{label:"Active",value:"Y"},{label:"Inactive",value:"N"}]}},mounted:function(){this.dataSearch&&(this.active_flag=this.dataSearch.active_flag,this.policy_set_header_id=this.dataSearch.policy_set_header_id?Number(this.dataSearch.policy_set_header_id):""),this.getPolicies()},methods:{getPolicies:function(e){var t=this;console.log("getPolicies -- ",e),this.loading=!0,this.policiesLov=[],axios.get("/ir/ajax/lov/policy-set-header",{params:{policy_set_header_id:this.policy_set_header_id,keyword:e}}).then((function(e){var a=e.data;t.loading=!1,t.policiesLov=a.data})).catch((function(e){swal("Error",e,"error")}))},clickCancel:function(){window.location.href="/ir/settings/policy"},clickSearch:function(){$("#searchForm").submit()}}};const s=(0,a(51900).Z)(i,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("form",{attrs:{action:e.search_url,id:"searchForm"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-sm-4 el_select padding_12"},[a("input",{attrs:{type:"hidden",name:"policy_set_header_id"},domProps:{value:e.policy_set_header_id}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",placeholder:"ระบุชุดกรมธรรม์","remote-method":e.getPolicies,loading:e.loading,remote:"",clearable:""},model:{value:e.policy_set_header_id,callback:function(t){e.policy_set_header_id=t},expression:"policy_set_header_id"}},e._l(e.policiesLov,(function(e){return a("el-option",{key:e.policy_set_header_id,attrs:{label:e.policy_set_number+": "+e.policy_set_description,value:e.policy_set_header_id}})})),1)],1),e._v(" "),a("div",{staticClass:"col-sm-4 el_select padding_12"},[a("input",{attrs:{type:"hidden",name:"active_flag"},domProps:{value:e.active_flag}}),e._v(" "),a("el-select",{staticClass:"w-100",attrs:{filterable:"",clearable:"",remote:"",placeholder:"Status"},model:{value:e.active_flag,callback:function(t){e.active_flag=t},expression:"active_flag"}},e._l(e.activeLists,(function(e,t){return a("el-option",{key:t,attrs:{label:e.label,value:e.value}})})),1)],1),e._v(" "),a("div",{staticClass:"col-sm-4 padding_12 margin_auto"},[a("button",{class:e.btnTrans.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(t){return t.preventDefault(),e.clickSearch(t)}}},[a("i",{class:e.btnTrans.search.icon}),e._v("\n            "+e._s(e.btnTrans.search.text)+"\n            ")]),e._v(" "),a("button",{class:e.btnTrans.reset.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(t){return t.preventDefault(),e.clickCancel()}}},[a("i",{class:e.btnTrans.reset.icon}),e._v("\n            "+e._s(e.btnTrans.reset.text)+"\n            ")])])])])}),[],!1,null,null,null).exports}}]);