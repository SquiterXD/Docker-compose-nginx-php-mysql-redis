(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_CloseDailyPayoff_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CloseDailyPayoff.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CloseDailyPayoff.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
var _methods;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
  props: ['saleClass'],
  data: function data() {
    return {
      dateLoading: false,
      loading: false,
      disable_params: false,
      disable_report: false,
      disable_interface: true,
      dateLists: [],
      documentNoLists: [],
      close_date: '',
      interface_status: '',
      group_id: ''
    };
  },
  mounted: function mounted() {// this.getDateLists();
  },
  methods: (_methods = {
    getDateLists: function getDateLists() {
      var vm = this;
      vm.dateLoading = true;
      axios.post('/om/close-daily-payoff/' + vm.saleClass + '/date-lists', {
        'sale_class': vm.saleClass
      }).then(function (response) {
        vm.dateLists = response.data;
      })["catch"](function (error) {
        vm.dateLoading = false;
        vm.showError(error.message);
      }).then(function () {
        // always executed
        vm.dateLoading = false;
      });
    },
    resetButton: function resetButton() {
      var vm = this;
      vm.disable_report = false;
      vm.disable_interface = true;
    },
    callValidate: function callValidate(type) {
      var vm = this;
      var msg = '';
      var error_flag = false;

      if (!vm.close_date) {
        msg += 'กรุณาระบุวันที่ <br>';
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
      }

      vm.loading = true;
      axios.post('/om/close-daily-payoff/' + vm.saleClass + '/validate-data', {
        'close_date': vm.close_date,
        'sale_class': vm.saleClass
      }).then(function (response) {
        if (response.data.status == 'S') {
          if (type == 'report') {
            vm.callReport();
          } else if (type == 'interface') {
            vm.callInterface();
          } else {}
        } else {
          vm.loading = false;

          if (type == 'report') {
            // swal({
            //     title: "Warning!",
            //     text: response.data.msg,
            //     type: "warning",
            //     showCancelButton: false,
            //     closeOnConfirm: true
            // },
            // function (isConfirm) {
            //     if (isConfirm) {
            //         vm.callReport();
            //     }
            // });
            vm.showError(response.data.msg);
          } else if (type == 'interface') {
            vm.showError(response.data.msg);
          } else {}
        }
      })["catch"](function (error) {
        // console.log(error);
        vm.showError(error.message);
      }).then(function () {// always executed
      });
    },
    callInterface: function callInterface() {
      var vm = this;
      vm.loading = vm.disable_interface = true;
      axios.post('/om/close-daily-payoff/' + vm.saleClass + '/interface', {
        'close_date': vm.close_date,
        'sale_class': vm.saleClass,
        'group_id': vm.group_id
      }).then(function (response) {
        vm.interface_status = response.data.status;

        if (response.data.status == 'S') {
          vm.getDateLists();
          vm.showSuccess(response.data.msg);
          vm.close_date = '';
          vm.group_id = response.data.group_id;
        } else {
          vm.showError(response.data.msg);
          vm.disable_interface = false;
        }
      })["catch"](function (error) {
        // console.log(error.message);
        vm.showError(error.message);
        vm.disable_interface = false;
      }).then(function () {
        // always executed
        vm.loading = false;
      });
    },
    showSuccess: function showSuccess(msg) {
      swal("Success!", msg, "success");
    },
    showError: function showError(msg) {
      swal("Error!", msg, "error");
    },
    callReport: function callReport() {
      var vm = this;
      vm.loading = vm.disable_report = true;
      axios.post('/om/close-daily-payoff/' + vm.saleClass + '/call-report', {
        'close_date': vm.close_date,
        'sale_class': vm.saleClass
      }).then(function (response) {
        if (response.data.status == 'S') {
          /// call show report
          vm.group_id = response.data.group_id;
          vm.showSuccess(response.data.msg);
          vm.getReport(vm.saleClass);
          vm.disable_interface = false;
        } else {
          vm.group_id = '';
          vm.showError(response.data.msg);
          vm.disable_report = false;
        }
      })["catch"](function (error) {
        // console.log(error);
        vm.showError(error.message);
        vm.disable_report = false;
      }).then(function () {
        // always executed
        vm.loading = false;
      });
    },
    getReport: function getReport(saleClass) {
      var vm = this;

      if (saleClass === 'export') {
        window.open("/ir/reports/get-param?group_id=" + vm.group_id + "&document_date=" + vm.close_date + "&program_code=OMR0112&function_name=OMR0112&output=pdf", "_blank");
      } else {
        window.open("/ir/reports/get-param?group_id=" + vm.group_id + "&document_date=" + vm.close_date + "&program_code=OMR0064&function_name=OMR0064&output=pdf", "_blank");
      }
    }
  }, _defineProperty(_methods, "showSuccess", function showSuccess(msg) {
    swal("Success!", msg, "success");
  }), _defineProperty(_methods, "showError", function showError(msg) {
    swal("Error!", msg, "error");
  }), _methods)
});

/***/ }),

/***/ "./resources/js/components/om/CloseDailyPayoff.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/om/CloseDailyPayoff.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CloseDailyPayoff_vue_vue_type_template_id_608bafde___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CloseDailyPayoff.vue?vue&type=template&id=608bafde& */ "./resources/js/components/om/CloseDailyPayoff.vue?vue&type=template&id=608bafde&");
/* harmony import */ var _CloseDailyPayoff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CloseDailyPayoff.vue?vue&type=script&lang=js& */ "./resources/js/components/om/CloseDailyPayoff.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CloseDailyPayoff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CloseDailyPayoff_vue_vue_type_template_id_608bafde___WEBPACK_IMPORTED_MODULE_0__.render,
  _CloseDailyPayoff_vue_vue_type_template_id_608bafde___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/CloseDailyPayoff.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/CloseDailyPayoff.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/om/CloseDailyPayoff.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CloseDailyPayoff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CloseDailyPayoff.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CloseDailyPayoff.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CloseDailyPayoff_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/CloseDailyPayoff.vue?vue&type=template&id=608bafde&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/om/CloseDailyPayoff.vue?vue&type=template&id=608bafde& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CloseDailyPayoff_vue_vue_type_template_id_608bafde___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CloseDailyPayoff_vue_vue_type_template_id_608bafde___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CloseDailyPayoff_vue_vue_type_template_id_608bafde___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CloseDailyPayoff.vue?vue&type=template&id=608bafde& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CloseDailyPayoff.vue?vue&type=template&id=608bafde&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CloseDailyPayoff.vue?vue&type=template&id=608bafde&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CloseDailyPayoff.vue?vue&type=template&id=608bafde& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
                      disabled: _vm.disable_params,
                      loading: _vm.dateLoading
                    },
                    on: {
                      focus: function($event) {
                        return _vm.getDateLists()
                      },
                      change: function($event) {
                        return _vm.resetButton()
                      }
                    },
                    model: {
                      value: _vm.close_date,
                      callback: function($$v) {
                        _vm.close_date = $$v
                      },
                      expression: "close_date"
                    }
                  },
                  _vm._l(_vm.dateLists, function(item, key) {
                    return _c("el-option", {
                      key: key,
                      attrs: { label: item, value: key }
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
                _c("label", [_vm._v("Group ID")]),
                _vm._v(" "),
                _c("el-input", {
                  staticClass: "w-100",
                  attrs: { placeholder: "", disabled: true },
                  model: {
                    value: _vm.group_id,
                    callback: function($$v) {
                      _vm.group_id = $$v
                    },
                    expression: "group_id"
                  }
                })
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
                _c("label", [_vm._v("หมายเหตุ")]),
                _vm._v(" "),
                _c("el-input", {
                  staticClass: "w-100",
                  attrs: { placeholder: "", disabled: true },
                  model: {
                    value: _vm.interface_status,
                    callback: function($$v) {
                      _vm.interface_status = $$v
                    },
                    expression: "interface_status"
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
                  staticClass: "btn btn-primary mt-2 mt-md-0",
                  attrs: { type: "button", disabled: _vm.disable_report },
                  on: {
                    click: function($event) {
                      return _vm.callValidate("report")
                    }
                  }
                },
                [_vm._v(" ประมวลผล")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary mt-2 mt-md-0",
                  attrs: { type: "button", disabled: _vm.disable_interface },
                  on: {
                    click: function($event) {
                      return _vm.callValidate("interface")
                    }
                  }
                },
                [_vm._v(" Interface")]
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
      _vm._v("วันที่ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);