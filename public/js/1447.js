(self.webpackChunk=self.webpackChunk||[]).push([[1447],{21447:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>y});var s=a(87757),n=a.n(s),r=(a(80455),a(30381)),i=a.n(r);function o(t,e,a,s,n,r,i){try{var o=t[r](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(s,n)}function l(t){return function(){var e=this,a=arguments;return new Promise((function(s,n){var r=t.apply(e,a);function i(t){o(r,s,n,i,l,"next",t)}function l(t){o(r,s,n,i,l,"throw",t)}i(void 0)}))}}var c,d;const u={props:["btnTrans","url","createInput","menu"],data:function(){return{loading:!1,loadingVerNo:!1,yearList:this.createInput.budget_year_list,budgetYear:"",budgetYeaVersion:"",adjVersionNo:""}},mounted:function(){},computed:{},watch:{budgetYear:(d=l(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.budgetYeaVersion="";case 1:case"end":return t.stop()}}),t,this)}))),function(t,e){return d.apply(this,arguments)}),budgetYeaVersion:(c=l(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.versionNo="",this.adjVersionNo="",e&&this.getDetail();case 3:case"end":return t.stop()}}),t,this)}))),function(t,e){return c.apply(this,arguments)})},methods:{openModal:function(){var t=this;return l(n().mark((function e(){return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.getDetail();case 2:$("#modal_create").modal("show");case 3:case"end":return e.stop()}}),e)})))()},submit:function(){var t=this,e=this;e.loading=!0,axios.post(e.url.ajax_store,{budget_year:e.budgetYear,budget_year_version:e.budgetYeaVersion,version_no:e.adjVersionNo}).then((function(e){var a=e.data.data;"S"==a.status&&($("#modal_create").modal("hide"),t.$emit("selectRow",a.header)),"S"!=a.status&&swal({title:"Error !",text:a.msg,type:"error",showConfirmButton:!0})})).catch((function(t){})).then((function(){e.loading=!1}))},searchForm:function(){var t=this;return l(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return(a=t).loading=!0,e.next=4,axios.get(a.url.ajax_adjusts_search_create,{params:{budget_year:a.budget_year,biweekly:a.biweekly,approved_status:a.status}}).then((function(t){a.html=t.data.data.html})).catch((function(t){a.html="";var e=t.response.data;alert(e.message)})).then((function(){a.loading=!1}));case 4:case"end":return e.stop()}}),e)})))()},getDetail:function(){var t=this;return l(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if((a=t).budgetYear||a.budgetYeaVersion){e.next=3;break}return e.abrupt("return");case 3:a.loadingVerNo=!0,axios.get(a.url.ajax_modal_create_details,{params:{budget_year:a.budgetYear,budget_year_version:a.budgetYeaVersion}}).then((function(t){var e=t.data.data;a.adjVersionNo=e.adj_version_no,a.loadingVerNo=!1}));case 5:case"end":return e.stop()}}),e)})))()}}};var p=a(51900);const v=(0,p.Z)(u,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("span",[a("button",{class:t.btnTrans.create.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:t.openModal}},[a("i",{class:t.btnTrans.create.icon}),t._v("\n        "+t._s(t.btnTrans.create.text)+"\n    ")]),t._v(" "),a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_create",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg",staticStyle:{"padding-top":"1%"}},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"modal-content"},[a("div",{staticClass:"modal-header"},[t._m(0),t._v(" "),a("h4",{staticClass:"modal-title"},[t._v(t._s(t.menu.menu_title))]),t._v(" "),a("small",{staticClass:"font-bold"},[t._v("\n                         \n                    ")])]),t._v(" "),a("div",{staticClass:"modal-body text-left"},[a("div",{staticClass:"row col-12"},[a("div",{staticClass:"form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ปีงบประมาณ:")]),t._v(" "),a("div",{staticClass:"input-group "},[a("el-select",{attrs:{"popper-append-to-body":!1,size:"large",placeholder:"ปีงบประมาณ",clearable:"",filterable:""},model:{value:t.budgetYear,callback:function(e){t.budgetYear=e},expression:"budgetYear"}},t._l(t.yearList,(function(t,e,s){return a("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ครั้งที่ :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("el-select",{attrs:{"popper-append-to-body":!1,size:"large",placeholder:"",clearable:"",filterable:""},model:{value:t.budgetYeaVersion,callback:function(e){t.budgetYeaVersion=e},expression:"budgetYeaVersion"}},t._l(t.yearList[t.budgetYear],(function(t,e){return a("el-option",{key:t.budget_year_version,attrs:{label:t.budget_year_version,value:t.budget_year_version}})})),1)],1)])])]),t._v(" "),a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-white",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")]),t._v(" "),a("button",{class:t.btnTrans.create.class+" btn-lg tw-w-25",attrs:{type:"button",disabled:!t.budgetYeaVersion},on:{click:function(e){return e.preventDefault(),t.submit()}}},[a("i",{class:t.btnTrans.create.icon}),t._v("\n                        "+t._s(t.btnTrans.create.text)+"\n                    ")])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),a("span",{staticClass:"sr-only"},[t._v("Close")])])}],!1,null,null,null).exports;function h(t,e,a,s,n,r,i){try{var o=t[r](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(s,n)}function f(t){return function(){var e=this,a=arguments;return new Promise((function(s,n){var r=t.apply(e,a);function i(t){h(r,s,n,i,o,"next",t)}function o(t){h(r,s,n,i,o,"throw",t)}i(void 0)}))}}var m;const b={props:["header","transBtn","transDate","url","countOpen","searchInput","menu"],data:function(){return{loading:!1,loadingVerNo:!1,yearList:this.searchInput.budget_year_list,budgetYear:"",budgetYeaVersion:"",adjVersionNo:"",adjVersionNoList:[],requestHeaders:[]}},mounted:function(){},computed:{},watch:{countOpen:(m=f(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.openModal();case 1:case"end":return t.stop()}}),t,this)}))),function(t,e){return m.apply(this,arguments)}),budgetYear:function(){var t=f(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.budgetYeaVersion="";case 1:case"end":return t.stop()}}),t,this)})));return function(e,a){return t.apply(this,arguments)}}(),budgetYeaVersion:function(){var t=f(n().mark((function t(e,a){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.versionNo="",this.adjVersionNo="",this.adjVersionNoList=[],e&&this.getDetail();case 4:case"end":return t.stop()}}),t,this)})));return function(e,a){return t.apply(this,arguments)}}()},methods:{setdate:function(t){var e=this;return f(n().mark((function a(){var s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s=e,a.next=3,i()(t).format(s.transDate["js-format"]);case 3:s.transactionDateFormat=a.sent;case 4:case"end":return a.stop()}}),a)})))()},openModal:function(){$("#modal_search").modal("show")},search:function(t){var e=this;e.loading=!0,axios.get(e.url.index,{params:t}).then((function(t){var a=t.data.data;e.loading=!1,e.requestHeaders=a.data}))},selectRow:function(t){var e=this;return f(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:$("#modal_search").modal("hide"),e.requestHeaders=[],e.$emit("selectRow",t);case 3:case"end":return a.stop()}}),a)})))()},searchForm:function(){var t=this;return f(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a=t,t.search({action:"search",budget_year:a.budgetYear,budget_year_version:a.budgetYeaVersion,version_no:a.adjVersionNo});case 2:case"end":return e.stop()}}),e)})))()},getDetail:function(){var t=this;return f(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if((a=t).budgetYear||a.budgetYeaVersion){e.next=3;break}return e.abrupt("return");case 3:a.loadingVerNo=!0,axios.get(a.url.ajax_modal_search_details,{params:{budget_year:a.budgetYear,budget_year_version:a.budgetYeaVersion}}).then((function(t){var e=t.data.data;a.adjVersionNoList=e.adj_version_no_list,a.loadingVerNo=!1}));case 5:case"end":return e.stop()}}),e)})))()}}};function g(t,e,a,s,n,r,i){try{var o=t[r](i),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(s,n)}function x(t){return function(){var e=this,a=arguments;return new Promise((function(s,n){var r=t.apply(e,a);function i(t){g(r,s,n,i,o,"next",t)}function o(t){g(r,s,n,i,o,"throw",t)}i(void 0)}))}}const w={components:{modalCreate:v,modalSearch:(0,p.Z)(b,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("span",[a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_search",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg",staticStyle:{width:"90%","max-width":"1230px","padding-top":"1%"}},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"modal-content"},[a("div",{staticClass:"modal-header"},[t._m(0),t._v(" "),a("h4",{staticClass:"modal-title"},[t._v("ค้นหา"+t._s(t.menu.menu_title))]),t._v(" "),a("small",{staticClass:"font-bold"},[t._v("\n                         \n                    ")])]),t._v(" "),a("div",{staticClass:"modal-body text-left"},[a("div",{staticClass:"row col-12"},[a("div",{staticClass:"form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ปีงบประมาณ:")]),t._v(" "),a("div",{staticClass:"input-group "},[a("el-select",{attrs:{"popper-append-to-body":!1,size:"large",placeholder:"ปีงบประมาณ",clearable:"",filterable:""},model:{value:t.budgetYear,callback:function(e){t.budgetYear=e},expression:"budgetYear"}},t._l(t.yearList,(function(t,e,s){return a("el-option",{key:e,attrs:{label:e,value:e}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ครั้งที่ :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("el-select",{attrs:{"popper-append-to-body":!1,size:"large",placeholder:"",clearable:"",filterable:""},model:{value:t.budgetYeaVersion,callback:function(e){t.budgetYeaVersion=e},expression:"budgetYeaVersion"}},t._l(t.yearList[t.budgetYear],(function(t,e){return a("el-option",{key:t.budget_year_version,attrs:{label:t.budget_year_version,value:t.budget_year_version}})})),1)],1)]),t._v(" "),a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingVerNo,expression:"loadingVerNo"}],staticClass:"form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ปรับครั้งที่ :")]),t._v(" "),a("div",{},[a("el-select",{attrs:{"popper-append-to-body":!1,size:"large",placeholder:"",clearable:"",filterable:""},model:{value:t.adjVersionNo,callback:function(e){t.adjVersionNo=e},expression:"adjVersionNo"}},t._l(t.adjVersionNoList,(function(t){return a("el-option",{key:t,attrs:{label:t,value:t}})})),1)],1)]),t._v(" "),a("div",{staticClass:"form-group text-right  pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12"},[a("label",{staticClass:" tw-font-bold tw-uppercase mt-2 mb-1"},[t._v(" ")]),t._v(" "),a("div",{staticClass:"text-left"},[a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:t.searchForm}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                                    "+t._s(t.transBtn.search.text)+"\n                                ")])])])]),t._v(" "),a("div",{staticClass:"ibox-content table-responsive m-t mb-3"},[a("table",{staticClass:"table table-hover"},[t._m(1),t._v(" "),a("tbody",t._l(t.requestHeaders,(function(e,s){return a("tr",[a("td",{staticClass:"text-center"},[t._v(t._s(parseInt(e.budget_year)+543))]),t._v(" "),a("td",{staticClass:"text-left"},[t._v(t._s(e.budget_year_version))]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(e.version_no))]),t._v(" "),a("td",{staticClass:"text-left",attrs:{title:e.created_by.name}},[t._v(t._s(e.created_by.username))]),t._v(" "),a("td",{staticClass:"text-right"},[a("button",{class:t.transBtn.detail.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(a){return t.selectRow(e)}}},[a("i",{class:t.transBtn.detail.icon}),t._v("\n                                            "+t._s(t.transBtn.detail.text)+"\n                                        ")])])])})),0)])])]),t._v(" "),t._m(2)])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),a("span",{staticClass:"sr-only"},[t._v("Close")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{width:"100px"}},[t._v("ปีงบประมาณ")]),t._v(" "),a("th",{staticClass:"text-left",attrs:{width:""}},[t._v("ครั้งที่")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"90px"}},[t._v("ปรับครั้งที่")]),t._v(" "),a("th",{staticClass:"text-left",attrs:{width:"90px"}},[t._v("ผู้สร้าง")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"150px"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-white",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])}],!1,null,null,null).exports},props:["pUrl"],computed:{totalQuantity:function(){return this.header?_.sumBy(this.header.lines,(function(t){return parseFloat(t.quantity)})):0},totalAdjustQuantity:function(){return this.header?_.sumBy(this.header.lines,(function(t){return parseFloat(t.adjust_quantity)})):0}},watch:{},data:function(){return{url:this.pUrl,data:!1,header:!1,profile:!1,transBtn:{},transDate:{},loading:{page:!1,before_mount:!1},countOpenModal:0}},beforeMount:function(){console.log("beforeMount"),this.getInfo()},mounted:function(){console.log("Component mounted.")},methods:{addNewLine:function(){var t=this;return x(n().mark((function e(){var a,s,r;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return s=(a=t).header.lines.length,r={adjust_quantity:0,h_adj_sale_for_id:a.header.h_adj_sale_for_id,item_id:"",item_code:"",item_description:"",l_adj_sale_for_id:"",quantity:0,org_id:"",item_list:JSON.parse(JSON.stringify(a.data.item_list))},e.next=5,a.$set(a.header.lines,s,r);case 5:case"end":return e.stop()}}),e)})))()},selectItemId:function(t,e){var a=this;return x(n().mark((function s(){var r,i;return n().wrap((function(s){for(;;)switch(s.prev=s.next){case 0:return r=a,i=t.item_list.findIndex((function(e){return e.value==t.item_id})),i=t.item_list[i],s.next=5,r.header.lines.filter((function(t,a){return a!=e&&t.item_code==i.inventory_item_code}));case 5:if(!s.sent.length){s.next=13;break}return swal({title:"แจ้งเตือน",text:"ไม่สามารถเลือก รหัสบุหรี่: "+i.inventory_item_code+" ซ้ำได้",type:"warning",showConfirmButton:!0}),t.org_id="",t.item_id="",t.item_code="",t.item_description="",s.abrupt("return");case 13:t.org_id=i.organization_id,t.item_code=i.inventory_item_code,t.item_description=i.description;case 16:case"end":return s.stop()}}),s)})))()},show:function(t){var e=this;return x(n().mark((function a(){return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:console.log("show header",t),e.loading.before_mount=!1,e.getInfo(t.h_adj_sale_for_id);case 3:case"end":return a.stop()}}),a)})))()},setdate:function(t,e){var a=this;return x(n().mark((function s(){var r;return n().wrap((function(s){for(;;)switch(s.prev=s.next){case 0:return r=a,s.next=3,i()(t).format(r.transDate["js-format"]);case 3:r.header[e]=s.sent,r.getLines();case 5:case"end":return s.stop()}}),s)})))()},changeAdjustQuantity:function(){var t=arguments,e=this;return x(n().mark((function a(){var s,r,i,o,l,c;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(s=t.length>0&&void 0!==t[0]&&t[0],r=e,i=parseFloat(r.header.adjust_percent),r.header.total_adjust_quantity="",!(i>100||i<0||""==r.header.adjust_percent||null==r.header.adjust_percent)){a.next=8;break}for(o in r.header.adjust_percent="",r.header.lines)r.header.lines[o].adjust_quantity=parseFloat(r.header.lines[o].quantity);return a.abrupt("return");case 8:if(s);else for(l in r.header.lines)parseFloat(i)?(c=parseFloat(r.header.lines[l].quantity)*((100+parseFloat(i))/100),r.header.lines[l].adjust_quantity=c):r.header.lines[l].adjust_quantity=0;case 9:case"end":return a.stop()}}),a)})))()},changeAdjustTotalQuantity:function(){var t=this;return x(n().mark((function e(){var a,s,r,i,o;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:for(r in a=t,s=parseFloat(a.header.sum_quantity),parseFloat(a.header.total_adjust_quantity),a.header.adjust_percent="",a.header.lines)""!=a.header.lines[r].l_adj_sale_for_id&&(i=parseFloat(a.header.lines[r].quantity),""==a.header.total_adjust_quantity||null==a.header.total_adjust_quantity?a.header.lines[r].adjust_quantity=i:s&&i&&(o=i/s*parseFloat(a.header.total_adjust_quantity),a.header.lines[r].adjust_quantity=o));return e.abrupt("return");case 6:case"end":return e.stop()}}),e)})))()},changeStatus:function(){return x(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:case"end":return t.stop()}}),t)})))()},getInfo:function(){var t=arguments,e=this;return x(n().mark((function a(){var s,r,i,o;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return s=t.length>0&&void 0!==t[0]?t[0]:"",i={h_adj_sale_for_id:s},o=!1,(r=e).loading.page=!0,r.loading.before_mount=!0,a.next=8,axios.get(r.url.index,{params:i}).then((function(t){"S"==(o=t.data.data).status&&(o=o.info),r.loading.page=!1}));case 8:o&&(r.data=o.data,r.header=o.header,r.profile=o.profile,r.transBtn=o.transBtn,r.transDate=o.transDate,r.url=o.url,r.header.total_adjust_quantity=""),r.loading.before_mount=!1;case 10:case"end":return a.stop()}}),a)})))()},save:function(){var t=arguments,e=this;return x(n().mark((function a(){var s;return n().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return!(t.length>0&&void 0!==t[0])||t[0],s=e,!0,!0,"",a.next=7,helperAlert.showProgressConfirm("กรุณายืนยันปรับประมาณการจำหน่าย");case 7:if(!a.sent){a.next=12;break}return s.loading.page=!0,a.next=12,axios.post(s.url.ajax_update,{header:s.header}).then((function(t){var e=t.data.data;"S"==e.status&&(s.hasChange=!1,swal({title:"&nbsp;",text:"บันทึกข้อมูลสำเร็จ",type:"success",html:!0}),setTimeout(x(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,s.getInfo(e.header.h_adj_sale_for_id);case 2:case"end":return t.stop()}}),t)}))),500)),"S"!=e.status&&swal({title:"Error !",text:e.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var e=t.response.data;swal({title:"Error !",text:e.message,type:"error",showConfirmButton:!0})})).then((function(){s.loading.page=!1}));case 12:case"end":return a.stop()}}),a)})))()},duplicateAdj:function(){var t=this;return x(n().mark((function e(){var a;return n().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=t,!0,!0,"",e.next=6,helperAlert.showProgressConfirm("กรุณายืนยันคัดลอกปรับประมาณการจำหน่าย");case 6:if(!e.sent){e.next=10;break}return e.next=10,axios.post(a.url.ajax_duplicate,{header:a.header}).then((function(t){var e=t.data.data;"S"==e.status&&(a.hasChange=!1,swal({title:"&nbsp;",text:"คัดลอกมูลสำเร็จ",type:"success",html:!0}),setTimeout(x(n().mark((function t(){return n().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,a.getInfo(e.header.h_adj_sale_for_id);case 2:case"end":return t.stop()}}),t)}))),500)),"S"!=e.status&&swal({title:"Error !",text:e.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var e=t.response.data;swal({title:"Error !",text:e.message,type:"error",showConfirmButton:!0})})).then((function(){a.loading.page=!1}));case 10:case"end":return e.stop()}}),e)})))()}}};const y=(0,p.Z)(w,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("transition",{attrs:{"enter-active-class":"animated fadeIn","leave-active-class":"animated fadeOut"}},[t.loading.before_mount?t._e():a("div",[a("modal-search",{attrs:{transDate:t.transDate,header:t.header,menu:t.data.menu,searchInput:t.data.search_input,transBtn:t.transBtn,url:t.url,countOpen:t.countOpenModal},on:{selectRow:t.show}}),t._v(" "),a("div",{staticClass:"ibox float-e-margins"},[a("div",{staticClass:"ibox-content pb-1",staticStyle:{"border-bottom":"0px"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-3"}),t._v(" "),a("div",{staticClass:"col-9 offset-3 text-right"},[t.data?a("modal-create",{staticClass:"pr-2",attrs:{btnTrans:t.transBtn,menu:t.data.menu,url:t.url,createInput:t.data.create_input},on:{selectRow:t.show}}):t._e(),t._v(" "),a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25 mr-2",on:{click:function(e){e.preventDefault(),t.countOpenModal+=1}}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                        "+t._s(t.transBtn.search.text)+"\n                    ")]),t._v(" "),a("button",{class:t.transBtn.save.class+" btn-lg tw-w-25",attrs:{type:"button",disabled:!t.header.can.edit||""==t.header.h_adj_sale_for_id||null==t.header.h_adj_sale_for_id},on:{click:function(e){return e.preventDefault(),t.save()}}},[a("i",{class:t.transBtn.save.icon}),t._v("\n                        "+t._s(t.transBtn.save.text)+"\n                    ")]),t._v(" "),a("button",{class:t.transBtn.copy.class+" btn-lg tw-w-25 mr-2",attrs:{disabled:""==t.header.h_adj_sale_for_id||null==t.header.h_adj_sale_for_id},on:{click:function(e){return e.preventDefault(),t.duplicateAdj()}}},[a("i",{class:t.transBtn.copy.icon}),t._v("\n                        "+t._s(t.transBtn.copy.text)+"\n                    ")])],1)])]),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-5"},[a("dl",{staticClass:"row mb-1"},[a("div",{staticClass:"col-sm-5 pl-0 col-form-label text-sm-right"},[a("dt",[t._v("ประมาณการจำหน่ายประจำปีงบประมาณ:")])]),t._v(" "),a("div",{staticClass:"col-sm-1 col-form-label text-sm-left"},[a("dd",{staticClass:"mb-1"},[t.header&&parseInt(t.header.budget_year)?a("div",[t._v(t._s(parseInt(t.header.budget_year)+543))]):t._e()])]),t._v(" "),a("div",{staticClass:"col-sm-2 col-form-label text-sm-right"},[a("dt",[t._v("ครั้งที่:")])]),t._v(" "),a("div",{staticClass:"col-sm-1 col-form-label text-sm-left"},[a("dd",{staticClass:"mb-1"},[t.header?a("div",[t._v(t._s(t.header.budget_year_version))]):t._e()])]),t._v(" "),a("div",{staticClass:"col-sm-2 pl-0 col-form-label text-sm-right"},[a("dt",[t._v("ปรับครั้งที่:")])]),t._v(" "),a("div",{staticClass:"col-sm-1 col-form-label text-sm-left"},[a("dd",{staticClass:"mb-1"},[t.header?a("div",[t._v(t._s(t.header.version_no))]):t._e()])])])]),t._v(" "),a("div",{staticClass:"col-7"},[a("dl",{staticClass:"row mb-1"},[a("div",{staticClass:"col-sm-2 pl-0 col-form-label text-sm-right"},[a("dt",[t._v("ปรับเปลี่ยน:")])]),t._v(" "),a("div",{staticClass:"col-sm-3 text-sm-left"},[a("dd",{staticClass:"mb-1"},[a("div",{staticClass:"input-group m-b"},[t.header?a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.adjust_percent,expression:"header.adjust_percent"}],staticClass:"form-control text-right",attrs:{disabled:!t.header.can.edit||null==t.header.h_adj_sale_for_id,max:"100",min:"0",type:"number"},domProps:{value:t.header.adjust_percent},on:{change:function(e){return t.changeAdjustQuantity()},input:function(e){e.target.composing||t.$set(t.header,"adjust_percent",e.target.value)}}}):a("input",{staticClass:"form-control",attrs:{type:"text",disabled:""}}),t._v(" "),a("div",{staticClass:"input-group-append"},[a("span",{staticClass:"input-group-addon"},[t._v("%")])])])])]),t._v(" "),a("div",{staticClass:"col-sm-2 pl-0 col-form-label text-sm-right"},[a("dt",[t._v("ปรับยอดรวม:")])]),t._v(" "),a("div",{staticClass:"col-sm-3 text-sm-left"},[a("dd",{staticClass:"mb-1"},[a("div",{staticClass:"input-group m-b"},[t.header?a("input",{directives:[{name:"model",rawName:"v-model",value:t.header.total_adjust_quantity,expression:"header.total_adjust_quantity"}],staticClass:"form-control text-right",attrs:{disabled:!t.header.can.edit||null==t.header.h_adj_sale_for_id,max:"100",min:"0",type:"number"},domProps:{value:t.header.total_adjust_quantity},on:{change:function(e){return t.changeAdjustTotalQuantity()},input:function(e){e.target.composing||t.$set(t.header,"total_adjust_quantity",e.target.value)}}}):a("input",{staticClass:"form-control",attrs:{type:"text",disabled:""}}),t._v(" "),a("div",{staticClass:"input-group-append"},[a("span",{staticClass:"input-group-addon"},[t._v("ล้านมวน")])])])])]),t._v(" "),a("div",{staticClass:"col-sm-2 align-middle"},[a("button",{staticClass:"btn btn-success btn-block btn-sm  btn-outline",staticStyle:{"margin-top":"2px"},attrs:{disabled:!t.header.can.edit||null==t.header.h_adj_sale_for_id},on:{click:function(e){return t.addNewLine()}}},[a("i",{staticClass:"fa fa-plus"}),t._v("\n                                เพิ่มรายการ\n                            ")])])])])]),t._v(" "),a("div",{staticClass:"table-responsive m-t"},[a("table",{staticClass:"table text-nowrap table-bordered table-hover"},[a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{width:"200px;"}},[t._v("รหัสบุหรี่")]),t._v(" "),a("th",[t._v("ตราบุหรี่")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"300px;"}},[t._v("ประมาณการจำหน่าย"),a("br"),t._v("ทั้งปีงบประมาณ(ล้านมวน)")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"300px;"}},[t._v("ประมาณการจำหน่าย"),a("br"),t._v("หลังปรับเปลี่ยน(ล้านมวน)")])])]),t._v(" "),a("tbody",[t._l(t.header.lines,(function(e,s){return t.header.lines.length>0?a("tr",[a("td",[e.l_adj_sale_for_id?a("div",[t._v("\n                                    "+t._s(e.item_code)+"\n                                ")]):a("el-select",{ref:"input-item-"+s,refInFor:!0,staticStyle:{width:"100%"},attrs:{clearable:"",filterable:"",placeholder:"รหัสบุหรี่"},on:{change:function(a){return t.selectItemId(e,s)}},model:{value:e.item_id,callback:function(a){t.$set(e,"item_id",a)},expression:"line.item_id"}},t._l(e.item_list,(function(t,e){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],1),t._v(" "),a("td",[t._v(t._s(e.item_description))]),t._v(" "),a("td",{staticClass:"text-right"},[t._v(t._s(t._f("number3Digit")(e.quantity)))]),t._v(" "),a("td",{staticClass:"text-right"},[t.header.can.edit?a("vue-numeric",{staticClass:"form-control input-sm text-right",attrs:{separator:",",precision:3,minus:!1},model:{value:e.adjust_quantity,callback:function(a){t.$set(e,"adjust_quantity",a)},expression:"line.adjust_quantity"}}):a("div",[t._v("\n                                    "+t._s(t._f("number3Digit")(e.adjust_quantity))+"\n                                ")])],1)]):t._e()})),t._v(" "),0==t.header.lines.length?a("tr",[a("td",[t._v(" ")]),t._v(" "),a("td",[t._v(" ")]),t._v(" "),a("td",[t._v(" ")]),t._v(" "),a("td",[t._v(" ")])]):t._e(),t._v(" "),a("tr",[a("th",{staticClass:"text-right",attrs:{colspan:"2"}},[a("strong",[t._v("รวม")])]),t._v(" "),a("th",{staticClass:"text-right text-white",staticStyle:{"background-color":"#34d399"}},[t._v("\n                                "+t._s(t._f("number3Digit")(t.header.sum_quantity))+"\n\n                            ")]),t._v(" "),a("th",{staticClass:"text-right text-white",staticStyle:{"background-color":"#34d399"}},[t._v("\n                                "+t._s(t._f("number3Digit")(parseFloat(t.totalAdjustQuantity)))+"\n                            ")])])],2)])])])])],1)])}),[],!1,null,null,null).exports}}]);