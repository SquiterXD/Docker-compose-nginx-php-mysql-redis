(self.webpackChunk=self.webpackChunk||[]).push([[7774],{36257:(t,a,e)=>{"use strict";e.d(a,{Z:()=>o});var s=e(23645),l=e.n(s)()((function(t){return t[1]}));l.push([t.id,".btn-success[data-v-53789990]{background-color:#1ab394;border-color:#1ab394}.btn-cancle[data-v-53789990]{background-color:#ec4958;border-color:#ec4958;color:#fff}.text-refresh[data-v-53789990]{color:#ec4958}",""]);const o=l},77774:(t,a,e)=>{"use strict";e.r(a),e.d(a,{default:()=>n});const s={props:["carInfo"],data:function(){var t,a,e,s,l,o,r,c;return{carInfos:[],carTypes:[],carBrands:[],carFuels:[],aLiasNames:[],form:[],selectedCar:{},car_license_plate:(null===(t=this.carInfo)||void 0===t?void 0:t.car_license_plate)||"",account_code:(null===(a=this.carInfo)||void 0===a?void 0:a.account_code)||"",car_group:(null===(e=this.carInfo)||void 0===e?void 0:e.car_group)||"",car_brand:(null===(s=this.carInfo)||void 0===s?void 0:s.car_brand)||"",car_fuel:(null===(l=this.carInfo)||void 0===l?void 0:l.car_fuel)||"",asset_number:"",asset_id:(null===(o=this.carInfo)||void 0===o?void 0:o.asset_id)||"",department_code:"",quota_per_month:"",car_vehicle_number:(null===(r=this.carInfo)||void 0===r?void 0:r.car_vehicle_number)||"",tax_refund_yn:(null===(c=this.carInfo)||void 0===c?void 0:c.tax_refund_yn)||"",loadingInput:{carInfos:!1,carTypes:!1,carBrands:!1,carFuels:!1,aliasName:!1},loading:!1}},watch:{car_license_plate:function(t){var a,e,s,l,o,r,c,n,i,d,u=this;this.selectedCar=this.carInfos.find((function(t){return t.car_license_plate==u.car_license_plate})),this.asset_number=null===(a=this.selectedCar)||void 0===a?void 0:a.asset_number,this.car_group=null===(e=this.selectedCar)||void 0===e?void 0:e.car_group,this.car_brand=null===(s=this.selectedCar)||void 0===s?void 0:s.car_brand,this.car_fuel=null===(l=this.selectedCar)||void 0===l?void 0:l.car_fuel,this.car_user=null===(o=this.selectedCar)||void 0===o?void 0:o.car_user,this.account_code=null===(r=this.selectedCar)||void 0===r?void 0:r.account_code,this.department_code=null===(c=this.selectedCar)||void 0===c?void 0:c.department_code,this.quota_per_month=null===(n=this.selectedCar)||void 0===n?void 0:n.quota_per_month,this.asset_id=null===(i=this.selectedCar)||void 0===i?void 0:i.asset_id,this.tax_refund_yn=null===(d=this.selectedCar)||void 0===d?void 0:d.tax_refund_yn}},created:function(){this.getMasterData()},mounted:function(){var t,a;this.carInfo&&(this.selectedCar=this.carInfo,this.account_code=null===(t=this.selectedCar)||void 0===t?void 0:t.account_code,this.quota_per_month=null===(a=this.selectedCar)||void 0===a?void 0:a.quota_per_month)},methods:{getMasterData:function(){this.getCarInfos(),this.getCarType(),this.getCarBrand(),this.getCarFuel(),this.getAliasName()},getCarInfos:function(t){var a=this;this.loadingInput.carInfos=!0,axios.get("/inv/ajax/car_info",{params:{text:t,source_data:"FA"}}).then((function(t){a.carInfos=t.data})).catch((function(t){console.log("error get car info")})).then((function(){a.loadingInput.carInfos=!1}))},getCarType:function(t){var a=this;this.loadingInput.carTypes=!0,axios.get("/inv/ajax/car_types",{params:{text:t}}).then((function(t){a.carTypes=t.data})).catch((function(t){console.log("error get car types")})).then((function(){a.loadingInput.carTypes=!1}))},getCarBrand:function(t){var a=this;this.loadingInput.carBrands=!0,axios.get("/inv/ajax/car_brands",{params:{text:t}}).then((function(t){a.carBrands=t.data})).catch((function(t){console.log("error get car brands")})).then((function(){a.loadingInput.carBrands=!1}))},getCarFuel:function(t){var a=this;this.loadingInput.carFuels=!0,axios.get("/inv/ajax/car_fuels",{params:{text:t}}).then((function(t){a.carFuels=t.data})).catch((function(t){console.log("error get car fuels")})).then((function(){a.loadingInput.carFuels=!1}))},getAliasName:function(t){var a=this;this.loadingInput.aliasName=!0,axios.get("/inv/ajax/alias_name",{params:{text:t,prefix:"T21"}}).then((function(t){a.aLiasNames=t.data})).catch((function(t){console.log("error get alias name")})).then((function(){a.loadingInput.aliasName=!1}))},refresh:function(){window.location.reload()},confirm:function(t){function a(){return t.apply(this,arguments)}return a.toString=function(){return t.toString()},a}((function(){var t=this;confirm("ยืนยันการขอสิทธิ์เติมน้ำมัน ?")&&(this.loading=!0,axios.get("/inv/disbursement_fuel/update-car-interface",{params:{car_license_plate:this.car_license_plate,asset_id:this.asset_id,car_group:this.car_group,car_brand:this.car_brand,car_fuel:this.car_fuel,account_code:this.account_code,quota_per_month:this.quota_per_month,tax_refund_yn:this.tax_refund_yn}}).then((function(a){t.$notify({title:"Success",message:"Update Successfully",type:"success"}),window.location("/inv/disbursement_fuel/show")})).catch((function(a){t.loading=!1;for(var e=t.$formatErrorMessage(a).getElementsByTagName("li"),s=0,l=e.length;s<l;s++)t.$notify.error({title:"Error",message:e[s].innerHTML,duration:2e3})})))}))},computed:{acc_segment:function(){var t,a=this;return(null===(t=this.aLiasNames.find((function(t){return t.alias_name==a.account_code})))||void 0===t?void 0:t.template)||""}}};var l=e(93379),o=e.n(l),r=e(36257),c={insert:"head",singleton:!1};o()(r.Z,c);r.Z.locals;const n=(0,e(51900).Z)(s,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"container"},[e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ทะเบียนรถ")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getCarInfos,placeholder:"ทะเบียนรถ",loading:t.loadingInput.carInfos},model:{value:t.car_license_plate,callback:function(a){t.car_license_plate=a},expression:"car_license_plate"}},t._l(t.carInfos,(function(t,a){return e("el-option",{key:a,attrs:{label:t.car_license_plate,value:t.car_license_plate}})})),1)],1)]),t._v(" "),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("รหัสสินทรัพย์")]),t._v(" "),e("div",{staticClass:"col-md-6"},[t.selectedCar.asset_number?e("input",{staticClass:"form-control",attrs:{type:"text",readonly:""},domProps:{value:t.selectedCar.asset_number||""}}):t._e()])]),t._v(" "),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("กลุ่มรถยนต์")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getCarType,placeholder:"กลุ่มรถยนต์",loading:t.loadingInput.carTypes},model:{value:t.car_group,callback:function(a){t.car_group=a},expression:"car_group"}},t._l(t.carTypes,(function(t,a){return e("el-option",{key:a,attrs:{label:t.description,value:t.flex_value}})})),1)],1)]),t._v(" "),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ยี่ห้อรถ")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getCarBrand,placeholder:"ยี่ห้อรถ",loading:t.loadingInput.carBrands},model:{value:t.car_brand,callback:function(a){t.car_brand=a},expression:"car_brand"}},t._l(t.carBrands,(function(t,a){return e("el-option",{key:a,attrs:{label:t.description,value:t.flex_value}})})),1)],1)]),t._v(" "),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ชนิดน้ำมันที่เติม")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getCarFuel,placeholder:"ชนิดน้ำมันที่เติม",loading:t.loadingInput.carFuels},model:{value:t.car_fuel,callback:function(a){t.car_fuel=a},expression:"car_fuel"}},t._l(t.carFuels,(function(t,a){return e("el-option",{key:a,attrs:{label:t.description,value:t.segment1}})})),1)],1)]),t._v(" "),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ภาษีรถยนต์ขอคืนได้")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-select",{staticStyle:{width:"100%"},attrs:{placeholder:"ภาษีรถยนต์ขอคืนได้"},model:{value:t.tax_refund_yn,callback:function(a){t.tax_refund_yn=a},expression:"tax_refund_yn"}},[e("el-option",{attrs:{label:"Y",value:"Y"}}),t._v(" "),e("el-option",{attrs:{label:"N",value:"N"}})],1)],1)]),t._v(" "),e("div",{staticClass:"form-group row",attrs:{hidden:""}},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("รหัสพนักงาน")]),t._v(" "),e("div",{staticClass:"col-md-6"},[t.selectedCar.car_user?e("input",{staticClass:"form-control-plaintext",attrs:{type:"text",readonly:""},domProps:{value:t.selectedCar.car_user||""}}):t._e()])]),t._v(" "),e("div",{staticClass:"form-group row",attrs:{hidden:""}},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ประเภท")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-input",{attrs:{disabled:""}})],1)]),t._v(" "),e("div",{staticClass:"form-group row",attrs:{hidden:""}},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ตำแหน่ง")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-input",{attrs:{disabled:""}})],1)]),t._v(" "),e("div",{staticClass:"form-group row",attrs:{hidden:""}},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("สังกัด")]),t._v(" "),e("div",{staticClass:"col-md-6"},[t.selectedCar.department?e("input",{staticClass:"form-control-plaintext",attrs:{type:"text",readonly:""},domProps:{value:t.selectedCar.department.description||""}}):t._e()])]),t._v(" "),e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("รหัสบัญชี")]),t._v(" "),e("div",{staticClass:"col-md-6"},[e("el-select",{staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",debounce:2e3,"remote-method":t.getAliasName,placeholder:"รหัสบัญชี",loading:t.loadingInput.aliasName},model:{value:t.account_code,callback:function(a){t.account_code=a},expression:"account_code"}},t._l(t.aLiasNames,(function(t,a){return e("el-option",{key:a,attrs:{label:t.alias_name+" - "+t.description,value:t.alias_name}})})),1)],1)]),t._v(" "),e("div",{staticClass:"form-group row"},[e("div",{staticClass:"offset-md-2 col-md-6"},[t._v("\n            "+t._s(this.acc_segment)+"\n        ")])]),t._v(" "),e("div",{staticClass:"card"},[e("div",{staticClass:"card-body"},[e("div",{staticClass:"form-group row"},[e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ขอสิทธิ์จำนวน")]),t._v(" "),e("div",{staticClass:"col-md-2 p-0"},[e("el-input",{attrs:{type:"number"},model:{value:t.quota_per_month,callback:function(a){t.quota_per_month=a},expression:"quota_per_month"}})],1),t._v(" "),e("label",{staticClass:"col-md-2 col-form-label"},[t._v("ลิตร / เดือน")])])])]),t._v(" "),e("div",{staticClass:"col-md-12 text-right mt-4 p-0"},[e("el-button",{staticClass:"btn-success",attrs:{type:"primary"},on:{click:function(a){return t.confirm()}}},[t._v("ยืนยัน")]),t._v(" "),e("el-button",{staticClass:"text-refresh",attrs:{type:"text"},nativeOn:{click:function(a){return a.preventDefault(),t.refresh()}}},[t._v("ล้างข้อมูล")])],1)])}),[],!1,null,"53789990",null).exports}}]);