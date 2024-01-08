(self.webpackChunk=self.webpackChunk||[]).push([[6101],{96101:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>l});var s=n(30381),r=n.n(s);function a(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);t&&(s=s.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,s)}return n}function o(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?a(Object(n),!0).forEach((function(t){c(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function c(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}const i={props:["user-profile","user-profile","trans-date","trans-btn","provinces","sys-date","p-node-headers"],data:function(){return{nodeHeaders:this.pNodeHeaders?this.pNodeHeaders:[],value1:[],nodeHeader:{},node:"",search:{node:"",province:""}}},mounted:function(){},methods:{fromDateWasSelected:function(e){this.disabledDateTo=r()(e).format("DD/MM/YYYY")},addRow:function(){this.nodeHeader={node_name:"",start_date:1,end_date:1,province_ids:[]},this.nodeHeaders.push(this.nodeHeader)},saveData:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;console.log(e,t),null==t?axios.post("/om/settings/node-province/store",o({},this.nodeHeaders[e])).then((function(e){return swal({title:"Success !",text:"Success !",type:"success",showConfirmButton:!0})})).catch((function(e){return swal({title:"Error !",text:"Error !",type:"error",showConfirmButton:!0})})):this.update(e,t)},update:function(e,t){axios.post("/om/settings/node-province/update/"+t,o({},this.nodeHeaders[e])).then((function(e){return console.log(e),swal({title:"Success !",text:"Success !",type:"success",showConfirmButton:!0})})).catch((function(e){alert(e)}))},delRaw:function(e,t){console.log(e,t),null==t?this.nodeHeaders.splice(this.nodeHeaders.indexOf(this.nodeHeaders[e]),1):this.deleteRaw(e,t)},deleteRaw:function(e,t){var n=this;axios.post("/om/settings/node-province/delete/"+t,o({},this.nodeHeaders[e])).then((function(t){return n.nodeHeaders.splice(n.nodeHeaders.indexOf(n.nodeHeaders[e]),1),swal({title:"Success !",text:"Success !",type:"success",showConfirmButton:!0})})).catch((function(e){return swal({title:"Error !",text:"Error",type:"error",showConfirmButton:!0})}))},disabledOption:function(e,t){return this.nodeHeaders.forEach((function(e){})),!1},getDate:function(e){console.log(e)},changeDate:function(e){}}};const l=(0,n(51900).Z)(i,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("div",{staticClass:"text-center"},[n("span",[e._v(" Node : ")]),e._v(" "),n("el-select",{attrs:{filterable:"",placeholder:"Select",clearable:""},model:{value:e.search.node,callback:function(t){e.$set(e.search,"node",t)},expression:"search.node"}},e._l(e.nodeHeaders,(function(e){return n("el-option",{key:e.node_header_id,attrs:{label:e.node_name,value:e.node_header_id}})})),1),e._v(" "),n("span",[e._v(" จังหวัด : ")]),e._v(" "),n("el-select",{attrs:{filterable:"",placeholder:"Select",clearable:""},model:{value:e.search.province,callback:function(t){e.$set(e.search,"province",t)},expression:"search.province"}},e._l(e.provinces,(function(e){return n("el-option",{key:e.province_id,attrs:{label:e.province_thai,value:e.province_id}})})),1),e._v(" "),n("button",{class:e.transBtn.search.class+" btn-sm mb-1"},[n("i",{class:e.transBtn.search.icon+" btn-lg tw-w-25 "}),e._v("\n                "+e._s(e.transBtn.search.text)+"\n        ")])],1),e._v(" "),n("div",{staticClass:"table-responsive mt-2"},[n("table",{staticClass:"table table-bordered"},[e._m(0),e._v(" "),e._l(e.nodeHeaders,(function(t,s){return n("tbody",{key:s},[n("tr",[n("td",{staticClass:"text-right"},[n("el-input",{attrs:{placeholder:"Please input"},model:{value:e.nodeHeaders[s].node_name,callback:function(t){e.$set(e.nodeHeaders[s],"node_name",t)},expression:"nodeHeaders[index].node_name"}})],1),e._v(" "),n("td",[n("el-select",{staticClass:"form-control-file",attrs:{multiple:"",placeholder:"Select"},model:{value:e.nodeHeaders[s].province_ids,callback:function(t){e.$set(e.nodeHeaders[s],"province_ids",t)},expression:"nodeHeaders[index].province_ids"}},e._l(e.provinces,(function(e){return n("el-option",{key:e.province_id,attrs:{label:e.province_thai,value:e.province_id}})})),1)],1),e._v(" "),n("td",[n("el-input",{attrs:{placeholder:"Please input"},model:{value:e.nodeHeaders[s].start_date,callback:function(t){e.$set(e.nodeHeaders[s],"start_date",t)},expression:"nodeHeaders[index].start_date"}})],1),e._v(" "),n("td"),e._v(" "),e._m(1,!0),e._v(" "),n("td",{staticClass:"text-center"},[n("button",{class:e.transBtn.save.class+" btn-lg  btn-sm",on:{click:function(n){return n.preventDefault(),e.saveData(s,t.node_header_id)}}},[n("i",{class:e.transBtn.save.icon}),e._v("\n                            "+e._s(e.transBtn.save.text)+"\n                        ")]),e._v(" "),n("button",{class:e.transBtn.delete.class+" btn-lg  btn-sm",on:{click:function(n){return n.preventDefault(),e.delRaw(s,t.node_header_id)}}},[n("i",{class:e.transBtn.delete.icon}),e._v("\n                            "+e._s(e.transBtn.delete.text)+"\n                        ")])])])])}))],2),e._v(" "),n("div",{staticClass:"text-right"},[n("button",{class:e.transBtn.add.class+" btn-lg  btn-sm",on:{click:function(t){return t.preventDefault(),e.addRow()}}},[n("i",{class:e.transBtn.add.icon}),e._v("\n                "+e._s(e.transBtn.add.text)+"\n            ")])])])])}),[function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("thead",[n("tr",[n("th",{staticClass:"text-center",attrs:{width:"6%"}},[e._v("Node")]),e._v(" "),n("th",{staticClass:"text-center",attrs:{width:"45%"}},[e._v("จังหวัด")]),e._v(" "),n("th",{staticClass:"text-center",attrs:{width:"10%"}},[e._v("วันที่เริ่มต้น")]),e._v(" "),n("th",{staticClass:"text-center",attrs:{width:"10%"}},[e._v("วันที่สิ้นสุด")]),e._v(" "),n("th",{staticClass:"text-center",attrs:{width:"10%"}},[e._v("สถานะ")]),e._v(" "),n("th",{staticClass:"text-center",attrs:{width:"15%"}})])])},function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("td",[n("select",{staticClass:"form-control",attrs:{name:"",id:""}},[n("option",{attrs:{value:""}},[e._v("active")]),e._v(" "),n("option",{attrs:{value:""}},[e._v("inactive")])])])}],!1,null,null,null).exports}}]);