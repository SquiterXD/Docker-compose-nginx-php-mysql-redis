(self.webpackChunk=self.webpackChunk||[]).push([[8910],{68910:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>g});var n=a(87757),r=a.n(n),s=a(30381),i=a.n(s);function o(t,e,a,n,r,s,i){try{var o=t[s](i),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(n,r)}const c={props:["pHeader","inventoryItemId","url"],computed:{},watch:{},data:function(){return{itemId:null!=this.inventoryItemId&&""!=this.inventoryItemId?parseInt(this.inventoryItemId):"",loading:!1,items:[]}},mounted:function(){""!==this.itemId?this.getItems({inventory_item_id:this.itemId,header:this.pHeader}):this.getItems({header:this.pHeader})},methods:{itemWasSelected:function(t){var e,a=this;return(e=r().mark((function e(){var n,s;return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:(s=(n=a).items.filter((function(e){return e.inventory_item_id==t}))).length&&(s=s[0],n.itemId=s.item_number),n.$emit("itemWasSelected",s);case 4:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(n,r){var s=e.apply(t,a);function i(t){o(s,n,r,i,c,"next",t)}function c(t){o(s,n,r,i,c,"throw",t)}i(void 0)}))})()},remoteMethod:function(t){""!==t?this.getItems({number:t,header:this.pHeader}):this.items=[]},getItems:function(t){var e=this;e.loading=!0,axios.get(e.url.ajax_get_item,{params:t}).then((function(t){var a=t.data.data;e.loading=!1,e.items=a.items,e.items&&e.items.forEach((function(t){e.inventoryItemId==t.inventory_item_id&&(e.itemId=t.item_number)}))}))}}};var l=a(51900);const d=(0,l.Z)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-select",{attrs:{filterable:"",remote:"","reserve-keyword":"",placeholder:"รหัสสินค้าสำเร็จรูป","remote-method":t.remoteMethod,loading:t.loading},on:{change:t.itemWasSelected},model:{value:t.itemId,callback:function(e){t.itemId=e},expression:"itemId"}},t._l(t.items,(function(t,e){return a("el-option",{key:e,attrs:{label:t.display,value:parseInt(t.inventory_item_id)}})})),1)],1)}),[],!1,null,null,null).exports;function u(t,e,a,n,r,s,i){try{var o=t[s](i),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(n,r)}function f(t){return function(){var e=this,a=arguments;return new Promise((function(n,r){var s=t.apply(e,a);function i(t){u(s,n,r,i,o,"next",t)}function o(t){u(s,n,r,i,o,"throw",t)}i(void 0)}))}}var m;const v={props:["header","transBtn","url","countOpen","transDate"],data:function(){return{loading:!1,transferHeaderId:"",transferNumber:"",productDateFormat:"",transferDateFormat:"",transferList:[]}},mounted:function(){},computed:{},watch:{countOpen:(m=f(r().mark((function t(e,a){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:this.openModal();case 1:case"end":return t.stop()}}),t,this)}))),function(t,e){return m.apply(this,arguments)})},methods:{setdate:function(t,e){var a=this;return f(r().mark((function n(){var s;return r().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(s=a,"product_date_format"!=e){n.next=9;break}if(!t){n.next=8;break}return n.next=5,i()(t).format(s.transDate["js-format"]);case 5:s.productDateFormat=n.sent,n.next=9;break;case 8:s.productDateFormat="";case 9:if("transfer_date_format"!=e){n.next=17;break}if(!t){n.next=16;break}return n.next=13,i()(t).format(s.transDate["js-format"]);case 13:s.transferDateFormat=n.sent,n.next=17;break;case 16:s.transferDateFormat="";case 17:case"end":return n.stop()}}),n)})))()},openModal:function(){$("#modal_search").modal("show")},getTransferList:function(t){var e=this;e.loading=!0,axios.get(e.url.index,{params:t}).then((function(t){var a=t.data.data;e.loading=!1,e.transferList=a.data}))},selectTransferHeader:function(t){var e=this;return f(r().mark((function a(){return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:$("#modal_search").modal("hide"),e.$emit("selectTransferHeader",t);case 2:case"end":return a.stop()}}),a)})))()},searchForm:function(){var t=this;return f(r().mark((function e(){return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.getTransferList({transfer_number:t.transferNumber,product_date_format:t.productDateFormat,transfer_date_format:t.transferDateFormat,action:"search"});case 1:case"end":return e.stop()}}),e)})))()}}};function p(t,e,a,n,r,s,i){try{var o=t[s](i),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(n,r)}function h(t){return function(){var e=this,a=arguments;return new Promise((function(n,r){var s=t.apply(e,a);function i(t){p(s,n,r,i,o,"next",t)}function o(t){p(s,n,r,i,o,"throw",t)}i(void 0)}))}}const b={components:{searchItem:d,modalSearch:(0,l.Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("span",[a("div",{staticClass:"modal inmodal fade",attrs:{id:"modal_search",tabindex:"-1",role:"dialog","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-lg",staticStyle:{width:"90%","max-width":"950px"}},[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"modal-content"},[t._m(0),t._v(" "),a("div",{staticClass:"modal-body text-left"},[a("div",{staticClass:"row col-12",staticStyle:{"padding-right":"10px","padding-left":"120px"}},[a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ใบส่งเลขที่ :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.transferNumber,expression:"transferNumber"}],staticClass:"form-control",attrs:{id:"lb-2",type:"text",name:"transfer_number"},domProps:{value:t.transferNumber},on:{input:function(e){e.target.composing||(t.transferNumber=e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" วันที่ได้ผลผลิต :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",value:t.productDateFormat,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,n=Array(a);a--;)n[a]=arguments[a];return t.setdate.apply(void 0,n.concat(["product_date_format"]))}}})],1)]),t._v(" "),a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" วันที่ส่งผลผลิต :")]),t._v(" "),a("div",{staticClass:"input-group "},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{placeholder:"โปรดเลือกวันที่",value:t.transferDateFormat,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,n=Array(a);a--;)n[a]=arguments[a];return t.setdate.apply(void 0,n.concat(["transfer_date_format"]))}}})],1)]),t._v(" "),a("div",{staticClass:"col-3"},[a("label",{staticClass:"text-left tw-font-bold tw-uppercase mb-1"},[t._v(" ")]),t._v(" "),a("div",{staticClass:"text-left"},[a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:t.searchForm}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                                    "+t._s(t.transBtn.search.text)+"\n                                ")])])])]),t._v(" "),a("div",{staticClass:"ibox-content table-responsive m-t mb-3"},[a("table",{staticClass:"table table-hover"},[t._m(1),t._v(" "),a("tbody",t._l(t.transferList,(function(e,n){return a("tr",[a("td",[t._v(t._s(e.transfer_number))]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(e.product_date_format))]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(e.transfer_date_format))]),t._v(" "),a("td",[t._v(t._s(e.objective.description))]),t._v(" "),a("td",[t._v(t._s(e.status.description))]),t._v(" "),a("td",[a("button",{class:t.transBtn.detail.class+" btn-lg tw-w-25",attrs:{type:"button"},on:{click:function(a){return t.selectTransferHeader(e)}}},[a("i",{class:t.transBtn.detail.icon}),t._v("\n                                            "+t._s(t.transBtn.detail.text)+"\n                                        ")])])])})),0)])])]),t._v(" "),t._m(2)])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-header"},[a("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal"}},[a("span",{attrs:{"aria-hidden":"true"}},[t._v("×")]),a("span",{staticClass:"sr-only"},[t._v("Close")])]),t._v(" "),a("h4",{staticClass:"modal-title"},[t._v("ค้นหารายการโอนสินค้าสำเร็จรูป")]),t._v(" "),a("small",{staticClass:"font-bold"},[t._v("\n                         \n                    ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{staticClass:"text-center",attrs:{width:"200px"}},[t._v("ใบส่งเลขที่")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px"}},[t._v("วันที่ได้ผลผลิต")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px"}},[t._v("วันที่ส่งผลผลิต")]),t._v(" "),a("th",{staticClass:"text-center"},[t._v("วัตถุประสงค์")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px"}},[t._v("สถานะขอเบิก")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"150px"}})])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"modal-footer"},[a("button",{staticClass:"btn btn-white",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")])])}],!1,null,null,null).exports},props:["pUrl"],computed:{},watch:{},data:function(){return{url:this.pUrl,data:!1,header:!1,profile:!1,transBtn:{},transDate:{},lines:[],loading:{page:!1,before_mount:!1},firstLoad:!0,countOpen:0,options:""}},beforeMount:function(){this.getInfo()},mounted:function(){},methods:{show:function(t){var e=this;return h(r().mark((function a(){return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:e.header=t,e.getLines(!1,"show");case 2:case"end":return a.stop()}}),a)})))()},getInfo:function(){var t=this;return h(r().mark((function e(){var a,n,s;return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=t,n=window.location.search,s=!1,a.loading.page=!0,a.loading.before_mount=!0,a.lines=[],e.next=8,axios.get(a.url.index+n).then((function(t){"S"==(s=t.data.data).status&&(s=s.info),a.loading.page=!1}));case 8:s&&(a.data=s.data,a.header=s.header,a.profile=s.profile,a.transBtn=s.transBtn,a.transDate=s.transDate,a.url=s.url),a.loading.before_mount=!1,a.getLines(!1,"show");case 11:case"end":return e.stop()}}),e)})))()},setdate:function(t,e){var a=this;return h(r().mark((function n(){var s;return r().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return s=a,n.next=3,i()(t).format(s.transDate["js-format"]);case 3:s.header[e]=n.sent;case 4:case"end":return n.stop()}}),n)})))()},addNewLine:function(){var t=this;return h(r().mark((function e(){var a,n,s;return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=(a=t).lines.length,e.next=4,_.clone(a.data.new_line);case 4:s=e.sent,a.$set(a.lines,n,s);case 6:case"end":return e.stop()}}),e)})))()},itemWasSelected:function(t,e){var a=this;return h(r().mark((function n(){var s,i;return r().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:s=a,e.inventory_item_id=t.inventory_item_id,e.item_classification_code=t.item_classification_code,e.item_desc=t.item_desc,e.item_number=t.item_number,e.organization_id=t.organization_id,e.transaction_uom=t.transaction_uom,e.transaction_uom_desc=t.transaction_uom_desc,e.transaction_type_id_from=t.transaction_type_id_from,e.organization_id_from=t.organization_id_from,e.subinventory_from=t.subinventory_from,e.locator_id_from=t.locator_id_from,e.locator_code_from=t.locator_code_from,e.transaction_type_id_to=t.transaction_type_id_to,e.organization_id_to=t.organization_id_to,e.subinventory_to=t.subinventory_to,e.locator_id_to=t.locator_id_to,e.locator_code_to=t.locator_code_to,e.biweekly=t.biweekly,e.batch_id=t.batch_id,i={inventoryItemId:e.inventory_item_id},axios.get(s.url.ajax_get_uom,{params:i}).then((function(t){e.uom_list=t.data.UomList,e.transaction_uom="CGC"}));case 22:case"end":return n.stop()}}),n)})))()},save:function(){var t=this;return h(r().mark((function e(){var a,n;return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=t,e.next=3,helperAlert.showProgressConfirm("กรุณายืนยันโอนสินค้าสำเร็จรูป");case 3:if(!e.sent){e.next=9;break}return a.loading.page=!0,n=a.lines.filter((function(t){return 1==t.is_selected})),e.next=9,axios.post(a.url.ajax_store,{header:a.header,lines:n}).then((function(t){var e=t.data.data;"S"==e.status&&(a.header=e.header,setTimeout(h(r().mark((function t(){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,a.getLines(!1,"show");case 2:case"end":return t.stop()}}),t)}))),500)),"S"!=e.status&&swal({title:"Error !",text:e.msg,type:"error",showConfirmButton:!0})})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){a.loading.page=!1}));case 9:case"end":return e.stop()}}),e)})))()},setStatus:function(t){var e=this;return h(r().mark((function a(){var n,s,i;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return n=e,!1,s="","confirmTransfer"==t&&(s="กรุณายืนยันโอนวัถุดิบ"),"cancelTransfer"==t&&(s="กรุณายืนยันยกเลิกโอน"),a.next=7,helperAlert.showProgressConfirm(s);case 7:if(!a.sent){a.next=14;break}return n.loading.page=!0,i=n.url.ajax_set_status,""!=n.header.transfer_header_id&&null!=n.header.transfer_header_id&&(i=i.replace("-999",n.header.transfer_header_id)),a.next=14,axios.post(i,{status:t}).then((function(t){var e=t.data.data;"S"==e.status&&(n.header.transfer_status=Number(e.transfer_status),n.header.can=e.can),"S"!=t.data.data.status&&("E"==t.data.data.status&&"Trying to get property 'wip_step' of non-object"===t.data.data.msg?swal({title:"แจ้งเตือน !",text:"ไม่สามารถทำรายการได้ เนื่องจากยังไม่มีการส่งผลผลิตมาจากหน้าเครื่องจักร",type:"error",showConfirmButton:!0}):swal({title:"Error !",text:t.data.data.msg,type:"error",showConfirmButton:!0}))})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){n.loading.page=!1}));case 14:case"end":return a.stop()}}),a)})))()},setData:function(){var t=this;return h(r().mark((function e(){var a;return r().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:null!=(a=t).header.transfer_header_id&&""!=a.header.transfer_header_id&&a.getLines(!1,"show"),a.firstLoad=!1;case 3:case"end":return e.stop()}}),e)})))()},indexPage:function(){this.getInfo()},getLines:function(){var t=arguments,e=this;return h(r().mark((function a(){var n,s,i,o;return r().wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(n=!(t.length>0&&void 0!==t[0])||t[0],s=t.length>1&&void 0!==t[1]?t[1]:"search",i=e,o=!0,!n){a.next=8;break}return a.next=7,helperAlert.showProgressConfirm("กรุณายืนยันการค้นหารายการเบิก");case 7:o=a.sent;case 8:if(!o){a.next=13;break}return i.loading.page=!0,i.lines=[],a.next=13,axios.get(i.url.ajax_get_lines,{params:{header:i.header,action:s}}).then((function(t){var e=t.data.data;i.lines=e.lines})).catch((function(t){var e=t.response.data;alert(e.message)})).then((function(){i.loading.page=!1}));case 13:return a.abrupt("return");case 14:case"end":return a.stop()}}),a)})))()},selectObjectiveCode:function(t){var e=this;return h(r().mark((function t(){return r().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.getLines();case 2:case"end":return t.stop()}}),t)})))()}}};const g=(0,l.Z)(b,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.page,expression:"loading.page"}],staticClass:"ibox float-e-margins"},[t.loading.before_mount?t._e():a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 text-right"},[a("button",{class:t.transBtn.search.class+" btn-lg tw-w-25 ",on:{click:function(e){t.countOpen+=1}}},[a("i",{class:t.transBtn.search.icon}),t._v("\n                        "+t._s(t.transBtn.search.text)+"\n                    ")]),t._v(" "),a("button",{class:t.transBtn.create.class+" btn-lg tw-w-25 mr-2",on:{click:function(e){return e.preventDefault(),t.indexPage(e)}}},[a("i",{class:t.transBtn.create.icon}),t._v("\n                        "+t._s(t.transBtn.create.text)+"\n                    ")]),t._v(" "),a("button",{class:t.transBtn.save.class+" btn-lg tw-w-25",attrs:{disabled:!t.header.can.edit},on:{click:function(e){return e.preventDefault(),t.save(e)}}},[a("i",{class:t.transBtn.save.icon}),t._v("\n                        "+t._s(t.transBtn.save.text)+"\n                    ")]),t._v(" "),a("button",{staticClass:"btn btn-primary btn-lg",attrs:{disabled:!t.header.can.transfer},on:{click:function(e){return e.preventDefault(),t.setStatus("confirmTransfer")}}},[a("strong",[t._v("ยืนยันขอโอนวัตถุดิบ")])]),t._v(" "),a("button",{staticClass:"btn btn-w-m btn-danger btn-lg",attrs:{disabled:!t.header.can.cancel_transfer},on:{click:function(e){return e.preventDefault(),t.setStatus("cancelTransfer")}}},[a("i",{staticClass:"fa fa-times"}),t._v(" ยกเลิกการขอโอนวัตถุดิบ\n                    ")])])])]),t._v(" "),t.loading.before_mount?t._e():a("div",{staticClass:"ibox-content"},[a("modal-search",{attrs:{transDate:t.transDate,transBtn:t.transBtn,url:t.url,countOpen:t.countOpen},on:{selectTransferHeader:t.show}}),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6 b-r"},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right",attrs:{for:"lb-2"}},[t._v("ใบส่งเลขที่: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("input",{staticClass:"form-control",attrs:{id:"lb-2",type:"text",name:"transfer_number",disabled:!0},domProps:{value:t.header.transfer_number}})])]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right",attrs:{for:"lb-3"}},[t._v("วันที่ได้ผลผลิต: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"input_date",id:"input_date",placeholder:"โปรดเลือกวันที่",disabled:!t.header.can.edit,value:t.header.product_date_format,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,n=Array(a);a--;)n[a]=arguments[a];return t.setdate.apply(void 0,n.concat(["product_date_format"]))}}})],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right"},[t._v("วันที่ส่งผลผลิต: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("datepicker-th",{staticClass:"form-control md:tw-mb-0 tw-mb-2",staticStyle:{width:"100%"},attrs:{name:"input_date",id:"input_date",disabled:!t.header.can.edit,placeholder:"โปรดเลือกวันที่",value:t.header.transfer_date_format,format:t.transDate["js-format"]},on:{dateWasSelected:function(e){for(var a=arguments.length,n=Array(a);a--;)n[a]=arguments[a];return t.setdate.apply(void 0,n.concat(["transfer_date_format"]))}}})],1)]),t._v(" "),a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right"},[t._v("วัตถุประสงค์: ")]),t._v(" "),a("div",{staticClass:"col-lg-7"},[a("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"","value-key":"transfer_objective",disabled:!t.header.can.edit,filterable:""},on:{change:t.selectObjectiveCode},model:{value:t.header.transfer_objective,callback:function(e){t.$set(t.header,"transfer_objective",e)},expression:"header.transfer_objective"}},t._l(t.data.objective_code_list,(function(t){return a("el-option",{key:JSON.stringify(t),attrs:{label:t.description,value:t.lookup_code}})})),1)],1)])]),t._v(" "),a("div",{staticClass:"col-lg-6"},[a("div",{staticClass:"form-group row"},[a("label",{staticClass:"col-lg-4 font-weight-bold col-form-label text-right"},[t._v("สถานะขอเบิก: ")]),t._v(" "),a("div",{staticClass:"col-lg-6"},[a("input",{staticClass:"form-control",attrs:{type:"text",readonly:"",disabled:""},domProps:{value:function(){if(t.header.transfer_status){var e=t.data.request_status_list.find((function(e){return e.lookup_code==t.header.transfer_status}));if(e)return e.description}return null}()}})])])])])],1)]),t._v(" "),t.loading.before_mount?t._e():a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading.page,expression:"loading.page"}],staticClass:"ibox float-e-margins"},[a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("div",{staticClass:"text-right"},[a("button",{class:t.transBtn.create.class+" btn-lg tw-w-25",attrs:{disabled:!t.header.can.edit},on:{click:function(e){return e.preventDefault(),t.addNewLine(e)}}},[a("i",{class:t.transBtn.create.icon}),t._v("\n                            เพิ่มรายการ\n                        ")])])])])]),t._v(" "),a("div",{staticClass:"ibox-content"},[a("div",{staticClass:"table-responsive m-t"},[a("table",{staticClass:"table text-nowrap table-bordered"},[t._m(0),t._v(" "),a("tbody",t._l(t.lines,(function(e,n){return t.lines.length?a("tr",[a("td",{staticClass:"align-middle text-center",attrs:{date:n}},[a("input",{directives:[{name:"model",rawName:"v-model",value:e.is_selected,expression:"line.is_selected"}],attrs:{type:"checkbox",disabled:!t.header.can.edit},domProps:{checked:Array.isArray(e.is_selected)?t._i(e.is_selected,null)>-1:e.is_selected},on:{click:function(a){return t.selectLine(n,e)},change:function(a){var n=e.is_selected,r=a.target,s=!!r.checked;if(Array.isArray(n)){var i=t._i(n,null);r.checked?i<0&&t.$set(e,"is_selected",n.concat([null])):i>-1&&t.$set(e,"is_selected",n.slice(0,i).concat(n.slice(i+1)))}else t.$set(e,"is_selected",s)}}})]),t._v(" "),a("td",[e.transfer_line_id&&!t.header.can.edit?[t._v("\n                                    "+t._s(e.item_number)+"\n                                ")]:[a("div",{staticStyle:{display:"flex"}},[e.is_edit_item&&t.header.can.edit?[a("search-item",{attrs:{pHeader:t.header,inventoryItemId:e.inventory_item_id,url:t.url},on:{itemWasSelected:function(a){for(var n=arguments.length,r=Array(n);n--;)r[n]=arguments[n];return t.itemWasSelected.apply(void 0,r.concat([e]))}}}),t._v(" "),t.header.can.edit&&e.request_line_id?a("button",{staticClass:"btn btn-outline btn-xs mb-0",attrs:{type:"button",title:"ยกเลิกแก้ไข"},on:{click:function(t){t.preventDefault(),e.is_edit_item=!1}}},[a("i",{staticClass:"fa fa-refresh"})]):t._e()]:[a("el-input",{attrs:{placeholder:"Please input",value:e.item_number,disabled:!0}}),t._v(" "),t.header.can.edit&&e.transfer_line_id?a("button",{staticClass:"btn btn-outline btn-xs mb-0",attrs:{type:"button",title:"แก้ไข"},on:{click:function(t){t.preventDefault(),e.is_edit_item=!0}}},[a("i",{class:t.transBtn.edit.icon})]):t._e()]],2)]],2),t._v(" "),a("td",{},[t._v(t._s(e.item_desc))]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(e.subinventory_from))]),t._v(" "),a("td",{staticClass:"text-center"},[t._v(t._s(e.locator_code_from))]),t._v(" "),a("td",{staticClass:"text-right"},[a("div",{staticClass:"input-group "},[a("input",{directives:[{name:"model",rawName:"v-model.number",value:e.transaction_qty,expression:"line.transaction_qty",modifiers:{number:!0}}],staticClass:"form-control text-right",staticStyle:{height:"40px"},attrs:{type:"number",disabled:!t.header.can.edit||!e.inventory_item_id},domProps:{value:e.transaction_qty},on:{input:function(a){a.target.composing||t.$set(e,"transaction_qty",t._n(a.target.value))},blur:function(e){return t.$forceUpdate()}}}),t._v(" "),a("div",{staticStyle:{"padding-left":"5px"}},[a("el-select",{attrs:{placeholder:"โปรดเลือกหน่วย",disabled:!e.inventory_item_id},model:{value:e.transaction_uom,callback:function(a){t.$set(e,"transaction_uom",a)},expression:"line.transaction_uom"}},t._l(e.uom_list,(function(t,e){return a("el-option",{key:e,attrs:{label:t.from_unit_of_measure,value:t.from_uom_code}})})),1)],1)])])]):t._e()})),0)])]),t._v(" "),0===t.lines.length?a("div",{staticClass:"text-center"},[a("span",{staticClass:"lead"},[t._v("No Data.")])]):t._e()])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",{attrs:{width:"10px;"}}),t._v(" "),a("th",{attrs:{width:"150px;"}},[t._v("\n                                        \n                                        \n                                รหัสสินค้าสำเร็จรูป\n                                        \n                                        \n                            ")]),t._v(" "),a("th",[t._v("รายละเอียด")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px;"}},[t._v("\n                                คลังสินค้า\n                            ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"100px;"}},[t._v("\n                                คลังสินค้าย่อย\n                            ")]),t._v(" "),a("th",{staticClass:"text-center",attrs:{width:"500px;"}},[t._v("\n                                        \n                                        \n                                จ่ายออก\n                                        \n                                        \n                            ")])])])}],!1,null,null,null).exports}}]);