(self.webpackChunk=self.webpackChunk||[]).push([[7272],{37272:(t,a,e)=>{"use strict";e.r(a),e.d(a,{default:()=>i});var s=e(80455);const n={components:{VueNumeric:e.n(s)()},props:["lineList","btnTrans"],data:function(){return{text:{listFix:"ยอดจำหน่ายบุหรี่ ยาเส้น-สโมสร กทม.",total:"ยอดรวม",notInformation:"ไม่มีข้อมูล"},totalAdjust:"",totaVatAmountCalculate:"",totalAmountAdjustGLTable:"",loadingTable:!1}},computed:{totalAmount:function(){return this.lineList.reduce((function(t,a){return Number(t)+Number(a.total_amount)}),0)},totalVatAmount:function(){return this.totalAdjustAmount(),this.lineList.reduce((function(t,a){return Number(t)+Number(a.vat_amount)}),0)}},mounted:function(){},methods:{totalAdjustAmount:function(t,a){t?(this.lineList.forEach((function(e){t.consignment_header_id==e.consignment_header_id&&(e.tax_adjust_amount=a)})),this.totalAdjust=this.lineList.reduce((function(t,a){return a.use_tax_adjustments?Number(t)+Number(a.use_tax_adjustments.tax_adjust_amount):Number(t)+Number(a.tax_adjust_amount)}),0),this.totaVatAmountCalculate=this.lineList.reduce((function(t,a){return Number(t)+Number(a.vat_amount)}),0),this.totalAmountAdjustGLTable=Number(this.totaVatAmountCalculate)-Number(this.totalAdjust),this.$parent.totalAmountAdjustGL=this.totalAmountAdjustGLTable):(this.totalAdjust=this.lineList.reduce((function(t,a){return a.use_tax_adjustments?Number(t)+Number(a.use_tax_adjustments.tax_adjust_amount):Number(t)+Number(a.tax_adjust_amount)}),0),this.totaVatAmountCalculate=this.lineList.reduce((function(t,a){return Number(t)+Number(a.vat_amount)}),0),this.totalAmountAdjustGLTable=Number(this.totaVatAmountCalculate)-Number(this.totalAdjust),this.$parent.totalAmountAdjustGL=this.totalAmountAdjustGLTable)},getStore:function(){var t=this,a=this,e=this.lineList.filter((function(t){return 1==t.checked}));if(0==e.length)return swal({title:"คำเตือน !",text:"กรุณาเลือกรายการที่ต้องการจะ Post",type:"warning",showConfirmButton:!0}),void(this.loadingTable=!1);this.loadingTable=!0,axios.post("ajax/tax-adjustments-bkk/store",{lineList:e}).then((function(e){if("ERROR"==e.data.status)return swal({title:"error !",text:"ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก "+e.data.err_msg,type:"error",showConfirmButton:!0}),void(t.loadingTable=!1);"success"==e.data.result&&(swal({title:"success !",text:"บันทึก สำเร็จ!",type:"success",showConfirmButton:!0}),t.loadingTable=!1,a.$parent.getSearchData(a.form_search))}))}}};const i=(0,e(51900).Z)(n,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"ibox-content"},[0!=t.lineList.length?e("div",{staticClass:"text-right",staticStyle:{"padding-top":"15px","padding-bottom":"15px"}},[e("button",{class:t.btnTrans.save.class,attrs:{type:"submit"},on:{click:function(a){return t.getStore()}}},[e("i",{class:t.btnTrans.save.icon,attrs:{"aria-hidden":"true"}}),t._v(" "+t._s(t.btnTrans.save.text)+"\n        ")])]):t._e(),t._v(" "),e("table",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingTable,expression:"loadingTable"}],staticClass:"table table-bordered text-center"},[t._m(0),t._v(" "),0==t.lineList.length?e("tbody",[e("tr",[e("td",{staticClass:"text-center",staticStyle:{"font-size":"18px","vertical-align":"middle"},attrs:{colspan:"7"}},[t._v(" "+t._s(t.text.notInformation))])])]):e("tbody",[t._l(t.lineList,(function(a,s){return e("tr",{key:s},[e("td",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(a.consignment_no)+"\n                ")]),t._v(" "),e("td",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(a.consignment_date_th)+"\n                ")]),t._v(" "),e("td",{staticClass:"text-left",staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(t.text.listFix)+"\n                ")]),t._v(" "),e("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(a.total_amount_decimal_point)+"\n                ")]),t._v(" "),e("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(a.vat_amount_decimal_point)+"\n                ")]),t._v(" "),e("td",{staticStyle:{"vertical-align":"middle"}},[a.use_tax_adjustments?e("div",[e("vue-numeric",{staticClass:"form-control text-right",attrs:{separator:",",precision:2,minus:!1,disabled:!0},model:{value:a.use_tax_adjustments.tax_adjust_amount,callback:function(e){t.$set(a.use_tax_adjustments,"tax_adjust_amount",e)},expression:"data.use_tax_adjustments.tax_adjust_amount"}})],1):e("div",[e("vue-numeric",{staticClass:"form-control text-right",attrs:{separator:",",precision:2,minus:!1},on:{change:function(e){return t.totalAdjustAmount(a,a.tax_adjust_amount)}},model:{value:a.tax_adjust_amount,callback:function(e){t.$set(a,"tax_adjust_amount",e)},expression:"data.tax_adjust_amount"}})],1)]),t._v(" "),e("td",{staticStyle:{"vertical-align":"middle"}},[e("el-checkbox",{attrs:{disabled:!!a.use_tax_adjustments},model:{value:a.checked,callback:function(e){t.$set(a,"checked",e)},expression:"data.checked"}})],1)])})),t._v(" "),e("tr",[e("td",{attrs:{colspan:"3"}},[t._v("\n                    "+t._s(t.text.total)+"\n                ")]),t._v(" "),e("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(t.totalAmount.toLocaleString(void 0,{minimumFractionDigits:2}))+"\n                ")]),t._v(" "),e("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(t.totalVatAmount.toLocaleString(void 0,{minimumFractionDigits:2}))+"\n                ")]),t._v(" "),e("td",{staticClass:"text-right",staticStyle:{"vertical-align":"middle"}},[t._v("\n                    "+t._s(this.totalAdjust.toLocaleString(void 0,{minimumFractionDigits:2}))+"\n                ")]),t._v(" "),e("td")])],2)])])}),[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("thead",[e("tr",[e("th",{staticClass:"text-center"},[e("div",[t._v("เลขที่")])]),t._v(" "),e("th",{staticClass:"text-center"},[e("div",[t._v("วันที่")])]),t._v(" "),e("th",{staticClass:"text-center"},[e("div",[t._v("รายการ")])]),t._v(" "),e("th",{staticClass:"text-right"},[e("div",[t._v("มูลค่าสินค้า")])]),t._v(" "),e("th",{staticClass:"text-right"},[e("div",[t._v("จำนวนเงินภาษี")])]),t._v(" "),e("th",{staticClass:"text-right"},[e("div",[t._v("ภาษีที่ Adjust")])]),t._v(" "),e("th",{staticClass:"text-center"},[e("div",[t._v("Post")])])])])}],!1,null,null,null).exports}}]);