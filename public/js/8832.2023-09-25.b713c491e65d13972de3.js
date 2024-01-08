(self.webpackChunk=self.webpackChunk||[]).push([[8832],{98832:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>o});var a=n(87757),i=n.n(a);function s(e,t,n,a,i,s,r){try{var l=e[s](r),o=l.value}catch(e){return void n(e)}l.done?t(o):Promise.resolve(o).then(a,i)}function r(e){return function(){var t=this,n=arguments;return new Promise((function(a,i){var r=e.apply(t,n);function l(e){s(r,a,i,l,o,"next",e)}function o(e){s(r,a,i,l,o,"throw",e)}l(void 0)}))}}const l={data:function(){return{loading:!1,listsMachineGroup:[],listsLineMf:[],listsWork:[],listsMachine:[],machineGroup:null,lineMf:null,work:null,machine:null}},mounted:function(){var e=this;return r(i().mark((function t(){var n;return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.fetchListsMachineGroup();case 2:return n=new URLSearchParams(window.location.href),e.machineGroup=n.get("machineGroup"),t.next=6,e.fetchListsLineMf();case 6:return e.lineMf=n.get("LineMf"),t.next=9,e.fetchListsWork();case 9:return e.work=n.get("work"),t.next=12,e.fetchListsMachine();case 12:e.machine=n.get("machine");case 13:case"end":return t.stop()}}),t)})))()},methods:{fetchListsMachineGroup:function(){var e=this;return r(i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,t.next=3,axios.post("/pm/settings/machine-relation/api/fetch/machine-group").then((function(t){e.listsMachineGroup=t.data})).catch((function(t){e.loading=!1}));case 3:e.loading=!1;case 4:case"end":return t.stop()}}),t)})))()},handleMachineGroupChange:function(){console.log("############# handleMachineGroupChange"),this.fetchListsLineMf(),Vue.set(this,"lineMf",null),Vue.set(this,"work",null),Vue.set(this,"machine",null)},handleChangeLineMf:function(){console.log("############# handleChangeLineMf"),this.fetchListsWork(),Vue.set(this,"work",null),Vue.set(this,"machine",null)},handleChangeWork:function(){console.log("############# handleChangeWork"),this.fetchListsMachine(),Vue.set(this,"machine",null)},resetFilter:function(){Vue.set(this,"machineGroup",null),Vue.set(this,"lineMf",null),Vue.set(this,"work",null),Vue.set(this,"machine",null)},fetchListsLineMf:function(){var e=this;return r(i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,t.next=3,axios.post("/pm/settings/machine-relation/api/fetch/line-mf",{machineGroup:e.machineGroup}).then((function(t){e.listsLineMf=t.data})).catch((function(t){e.loading=!1}));case 3:e.loading=!1;case 4:case"end":return t.stop()}}),t)})))()},fetchListsWork:function(){var e=this;return r(i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,t.next=3,axios.post("/pm/settings/machine-relation/api/fetch/work",{machineGroup:e.machineGroup,lineMf:e.lineMf}).then((function(t){e.listsWork=t.data})).catch((function(t){e.loading=!1}));case 3:e.loading=!1;case 4:case"end":return t.stop()}}),t)})))()},fetchListsMachine:function(){var e=this;return r(i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e.loading=!0,t.next=3,axios.post("/pm/settings/machine-relation/api/fetch/machine",{machineGroup:e.machineGroup,lineMf:e.lineMf,work:e.work}).then((function(t){e.listsMachine=t.data})).catch((function(t){e.loading=!1}));case 3:e.loading=!1;case 4:case"end":return t.stop()}}),t)})))()}}};const o=(0,n(51900).Z)(l,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("form",[n("input",{attrs:{type:"hidden",name:"l",value:"1"}}),e._v(" "),n("div",{staticClass:"ibox"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"ibox-content"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"tw-font-bold",attrs:{for:""}},[e._v("กลุ่มชุดเครื่องจักร(มวน)/กลุ่มผลิตภัณฑ์(ก้นกรอง)")]),e._v(" "),n("el-select",{staticClass:"tw-w-full",attrs:{name:"machineGroup",placeholder:"เลือกข้อมูลกลุ่มชุดเครื่องจักร(มวน)/กลุ่มผลิตภัณฑ์(ก้นกรอง)",clearable:"",filterable:"",remote:"","reserve-keyword":""},on:{change:e.handleMachineGroupChange},model:{value:e.machineGroup,callback:function(t){e.machineGroup=t},expression:"machineGroup"}},e._l(e.listsMachineGroup,(function(e){return n("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)]),e._v(" "),n("div",{staticClass:"col"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"tw-font-bold",attrs:{for:""}},[e._v("เซ็ตเครื่องจักร")]),e._v(" "),n("el-select",{staticClass:"tw-w-full",attrs:{name:"LineMf",placeholder:"เลือกข้อมูลเซ็ตเครื่องจักร",clearable:"",filterable:"",remote:"","reserve-keyword":""},on:{change:e.handleChangeLineMf},model:{value:e.lineMf,callback:function(t){e.lineMf=t},expression:"lineMf"}},e._l(e.listsLineMf,(function(e){return n("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)]),e._v(" "),n("div",{staticClass:"col"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"tw-font-bold",attrs:{for:""}},[e._v("ขั้นตอนการทำงาน")]),e._v(" "),n("el-select",{staticClass:"tw-w-full",attrs:{name:"work",placeholder:"เลือกข้อมูลขั้นตอนการทำงาน",clearable:"",filterable:"",remote:"","reserve-keyword":""},on:{change:e.handleChangeWork},model:{value:e.work,callback:function(t){e.work=t},expression:"work"}},e._l(e.listsWork,(function(e){return n("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)]),e._v(" "),n("div",{staticClass:"col"},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"tw-font-bold",attrs:{for:""}},[e._v("ประเภทเครื่องจักร")]),e._v(" "),n("el-select",{staticClass:"tw-w-full",attrs:{name:"machine",placeholder:"เลือกข้อมูลประเภทเครื่องจักร",clearable:"",filterable:"",remote:"","reserve-keyword":""},model:{value:e.machine,callback:function(t){e.machine=t},expression:"machine"}},e._l(e.listsMachine,(function(e){return n("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)])]),e._v(" "),e._m(0)])])])}),[function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"text-right",staticStyle:{"padding-top":"15px"}},[n("button",{staticClass:"btn btn-light",attrs:{type:"submit"}},[n("i",{staticClass:"fa fa-search",attrs:{"aria-hidden":"true"}}),e._v(" แสดงข้อมูล\n        ")]),e._v(" "),n("a",{staticClass:"btn btn-danger",attrs:{type:"button",href:"/pm/settings/machine-relation"}},[e._v("\n          ล้างค่า\n        ")])])}],!1,null,null,null).exports}}]);