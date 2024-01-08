(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_TransferTxtToBank_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransferTxtToBank.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransferTxtToBank.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['bankLists'],
  data: function data() {
    return {
      loading: false,
      loading_option: false,
      disable_params: false,
      disable_pdf: false,
      disable_txt: true,
      customerTypeLists: [{
        value: 'p1',
        label: 'ร้านค้าป.1'
      }, {
        value: 'mt',
        label: 'Modern Trade'
      }],
      customerLists: [],
      defaultDate: '',
      bank: '',
      customer_type: '',
      customer: '',
      check_date: '',
      start_date: '',
      end_date: ''
    };
  },
  mounted: function mounted() {
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    this.defaultDate = new Date(year + 543, month, day);

    if (this.bankLists.length == 1) {
      this.bank = this.bankLists[0].lookup_code;
    }
  },
  methods: {
    getCustomerLists: function getCustomerLists() {
      var vm = this;
      vm.loading_option = true;
      vm.customer = '';
      axios.get('/om/transfer-txt-to-bank/customer-list?type=' + vm.customer_type).then(function (response) {
        vm.customerLists = response.data;
      })["catch"](function (error) {
        console.log(error);
      }).then(function () {
        // always executed
        vm.loading_option = false;
      });
    },
    getPDF: function getPDF() {
      var vm = this;
      var msg = '';
      var error_flag = false;

      if (!vm.bank) {
        msg += 'กรุณาบัญชีธนาคาร <br>';
        error_flag = true;
      }

      if (!vm.customer_type) {
        msg += 'กรุณาเลือกประเภทร้านค้า <br>';
        error_flag = true;
      }

      if (!vm.check_date) {
        msg += 'กรุณาระบุวันที่เช็ค <br>';
        error_flag = true;
      }

      if (!vm.start_date) {
        msg += 'กรุณาระบุวันที่เริ่ม <br>';
        error_flag = true;
      }

      if (!vm.end_date) {
        msg += 'กรุณาระบุวันที่สิ้นสุด <br>';
        error_flag = true;
      }

      if (error_flag) {
        swal({
          html: true,
          title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          text: msg,
          type: 'error'
        });
        return false;
      } // vm.disable_params = true;
      // vm.disable_pdf = true;


      vm.disable_txt = false;
      var url = '/om/transfer-txt-to-bank/pdf?' + 'bank=' + vm.bank + '&customer_type=' + vm.customer_type + '&customer_id=' + vm.customer + '&check_date=' + vm.check_date + '&start_date=' + vm.start_date + '&end_date=' + vm.end_date;
      window.open(url, '_blank');
    },
    getTxt: function getTxt() {
      var vm = this;
      var msg = '';
      var error_flag = false;

      if (!vm.bank) {
        msg += 'กรุณาบัญชีธนาคาร <br>';
        error_flag = true;
      }

      if (!vm.customer_type) {
        msg += 'กรุณาเลือกประเภทร้านค้า <br>';
        error_flag = true;
      }

      if (!vm.check_date) {
        msg += 'กรุณาระบุวันที่เช็ค <br>';
        error_flag = true;
      }

      if (!vm.start_date) {
        msg += 'กรุณาระบุวันที่เริ่ม <br>';
        error_flag = true;
      }

      if (!vm.end_date) {
        msg += 'กรุณาระบุวันที่สิ้นสุด <br>';
        error_flag = true;
      }

      if (error_flag) {
        swal({
          html: true,
          title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          text: msg,
          type: 'error'
        });
        return false;
      } // vm.disable_txt = true;


      var url = '/om/transfer-txt-to-bank/txt?' + 'bank=' + vm.bank + '&customer_type=' + vm.customer_type + '&customer_id=' + vm.customer + '&check_date=' + vm.check_date + '&start_date=' + vm.start_date + '&end_date=' + vm.end_date;
      window.open(url, '_blank');
    },
    checkdateWasSelected: function checkdateWasSelected(value) {
      var vm = this;
      var year = value.getFullYear();
      var month = value.getMonth() + 1;
      var day = value.getDate();
      vm.check_date = day + '/' + month + '/' + year;
    },
    startdateWasSelected: function startdateWasSelected(value) {
      var vm = this;
      var year = value.getFullYear();
      var month = value.getMonth() + 1;
      var day = value.getDate();
      vm.start_date = day + '/' + month + '/' + year;
    },
    enddateWasSelected: function enddateWasSelected(value) {
      var vm = this;
      var year = value.getFullYear();
      var month = value.getMonth() + 1;
      var day = value.getDate();
      vm.end_date = day + '/' + month + '/' + year;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/TransferTxtToBank.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/om/TransferTxtToBank.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TransferTxtToBank_vue_vue_type_template_id_95a8b914___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TransferTxtToBank.vue?vue&type=template&id=95a8b914& */ "./resources/js/components/om/TransferTxtToBank.vue?vue&type=template&id=95a8b914&");
/* harmony import */ var _TransferTxtToBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TransferTxtToBank.vue?vue&type=script&lang=js& */ "./resources/js/components/om/TransferTxtToBank.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TransferTxtToBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TransferTxtToBank_vue_vue_type_template_id_95a8b914___WEBPACK_IMPORTED_MODULE_0__.render,
  _TransferTxtToBank_vue_vue_type_template_id_95a8b914___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/TransferTxtToBank.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/TransferTxtToBank.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/om/TransferTxtToBank.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TransferTxtToBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TransferTxtToBank.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransferTxtToBank.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TransferTxtToBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/TransferTxtToBank.vue?vue&type=template&id=95a8b914&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/om/TransferTxtToBank.vue?vue&type=template&id=95a8b914& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransferTxtToBank_vue_vue_type_template_id_95a8b914___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransferTxtToBank_vue_vue_type_template_id_95a8b914___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransferTxtToBank_vue_vue_type_template_id_95a8b914___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TransferTxtToBank.vue?vue&type=template&id=95a8b914& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransferTxtToBank.vue?vue&type=template&id=95a8b914&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransferTxtToBank.vue?vue&type=template&id=95a8b914&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransferTxtToBank.vue?vue&type=template&id=95a8b914& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* binding */ render,
/* harmony export */   "staticRenderFns": () => /* binding */ staticRenderFns
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ]
    },
    [
      _c("div", { staticClass: "row mb-3" }, [
        _c("div", { staticClass: "col-md-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-6" }, [
          _c("div", { staticClass: "row mb-3" }, [
            _c(
              "div",
              { staticClass: "col-md-12" },
              [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      placeholder: "Select",
                      disabled: _vm.disable_params
                    },
                    model: {
                      value: _vm.bank,
                      callback: function($$v) {
                        _vm.bank = $$v
                      },
                      expression: "bank"
                    }
                  },
                  _vm._l(_vm.bankLists, function(item) {
                    return _c("el-option", {
                      key: item.lookup_code,
                      attrs: { label: item.meaning, value: item.lookup_code }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mb-3" }, [
            _c(
              "div",
              { staticClass: "col-md-12" },
              [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      placeholder: "Select",
                      disabled: _vm.disable_params
                    },
                    on: {
                      input: function($event) {
                        return _vm.getCustomerLists()
                      }
                    },
                    model: {
                      value: _vm.customer_type,
                      callback: function($$v) {
                        _vm.customer_type = $$v
                      },
                      expression: "customer_type"
                    }
                  },
                  _vm._l(_vm.customerTypeLists, function(item) {
                    return _c("el-option", {
                      key: item.value,
                      attrs: { label: item.label, value: item.value }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mb-3" }, [
            _c(
              "div",
              { staticClass: "col-md-12" },
              [
                _c("label", [_vm._v("รหัสร้านค้า")]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      clearable: "true",
                      placeholder: "Select",
                      filterable: "",
                      loading: _vm.loading_option,
                      disabled: _vm.disable_params
                    },
                    model: {
                      value: _vm.customer,
                      callback: function($$v) {
                        _vm.customer = $$v
                      },
                      expression: "customer"
                    }
                  },
                  _vm._l(_vm.customerLists, function(item) {
                    return _c("el-option", {
                      key: item.customer_id,
                      attrs: {
                        label:
                          item.customer_number + " - " + item.customer_name,
                        value: item.customer_id
                      }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mb-3" }, [
            _c(
              "div",
              { staticClass: "col-md-12" },
              [
                _vm._m(2),
                _vm._v(" "),
                _c("datepicker-th", {
                  class: "w-100 form-control md:tw-mb-0 tw-mb-2",
                  attrs: {
                    disabled: _vm.disabledDate,
                    type: "date",
                    value: _vm.check_date,
                    name: "check_date",
                    format: "DD/MM/YYYY"
                  },
                  on: { dateWasSelected: _vm.checkdateWasSelected },
                  model: {
                    value: _vm.check_date,
                    callback: function($$v) {
                      _vm.check_date = $$v
                    },
                    expression: "check_date"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mb-4" }, [
            _c(
              "div",
              { staticClass: "col-md-6" },
              [
                _vm._m(3),
                _vm._v(" "),
                _c("datepicker-th", {
                  class: "w-100 form-control md:tw-mb-0 tw-mb-2",
                  attrs: {
                    disabled: _vm.disabledDate,
                    type: "date",
                    value: _vm.start_date,
                    name: "start_date",
                    format: "DD/MM/YYYY"
                  },
                  on: { dateWasSelected: _vm.startdateWasSelected },
                  model: {
                    value: _vm.start_date,
                    callback: function($$v) {
                      _vm.start_date = $$v
                    },
                    expression: "start_date"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-6" },
              [
                _vm._m(4),
                _vm._v(" "),
                _c("datepicker-th", {
                  class: "w-100 form-control md:tw-mb-0 tw-mb-2",
                  attrs: {
                    disabled: _vm.disabledDate,
                    type: "date",
                    value: _vm.end_date,
                    name: "end_date",
                    format: "DD/MM/YYYY"
                  },
                  on: { dateWasSelected: _vm.enddateWasSelected },
                  model: {
                    value: _vm.end_date,
                    callback: function($$v) {
                      _vm.end_date = $$v
                    },
                    expression: "end_date"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-12 text-center" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-info mt-2 mt-md-0",
                  attrs: { type: "button", disabled: _vm.disable_pdf },
                  on: {
                    click: function($event) {
                      return _vm.getPDF()
                    }
                  }
                },
                [_vm._v(" พิมพ์รายงานเพื่อตรวจสอบ")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary mt-2 mt-md-0",
                  attrs: { type: "button", disabled: _vm.disable_txt },
                  on: {
                    click: function($event) {
                      return _vm.getTxt()
                    }
                  }
                },
                [_vm._v(" Generate Text file")]
              )
            ])
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("บัญชีธนาคาร "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("ประเภทร้านค้า "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("ระบุวันที่เช็ค "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("ตั้งแต่วันที่ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("ถึงวันที่ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);