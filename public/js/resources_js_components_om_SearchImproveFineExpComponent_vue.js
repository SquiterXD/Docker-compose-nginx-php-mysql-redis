(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_SearchImproveFineExpComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
  props: ['search_data', 'trans_btn'],
  data: function data() {
    return {
      loading: false,
      inputParams: {
        order_number_list: [],
        sa_number_list: [],
        pi_number_list: [],
        invoice_no_list: [],
        customer_list: []
      },
      form: {
        order_number: null,
        sa_number: null,
        pi_number: null,
        invoice_no: null,
        customer_id: null,
        total_fine_due: null,
        due_date: null,
        fine_flag: null,
        country_name: null
      },
      check_search: true
    };
  },
  mounted: function mounted() {
    this.autoLoad();
  },
  methods: {
    autoLoad: function autoLoad() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.form.order_number = vm.search_data.order_number != '' ? vm.search_data.order_number : null, vm.form.sa_number = vm.search_data.sa_number != '' ? vm.search_data.sa_number : null, vm.form.pi_number = vm.search_data.pi_number != '' ? vm.search_data.pi_number : null, vm.form.invoice_no = vm.search_data.invoice_no != '' ? vm.search_data.invoice_no : null, vm.form.customer_id = vm.search_data.customer_id ? Number(vm.search_data.customer_id) : null, vm.form.total_fine_due = vm.search_data.check_search ? vm.search_data.total_fine_due : moment__WEBPACK_IMPORTED_MODULE_1___default()(new Date()).format('DD-MM-YYYY'), vm.form.due_date = vm.search_data.due_date != '' ? vm.search_data.due_date : null, vm.form.fine_flag = vm.search_data.fine_flag ? true : false, vm.getParam();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    searchForm: function searchForm() {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                $("#searchForm").submit();

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    clearForm: function clearForm() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this2.form.order_number = null;
                _this2.form.sa_number = null;
                _this2.form.pi_number = null;
                _this2.form.invoice_no = null;
                _this2.form.customer_id = null;

                _this2.getParam();

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getParam: function getParam() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this3;
                vm.loading = true;
                params = {
                  action: 'search_get_param',
                  order_number: vm.form.order_number,
                  sa_number: vm.form.sa_number,
                  pi_number: vm.form.pi_number,
                  invoice_no: vm.form.invoice_no,
                  customer_id: vm.form.customer_id
                };
                axios.get(vm.search_data.search_url, {
                  params: params
                }).then(function (res) {
                  var response = res.data;
                  vm.loading = false;
                  vm.inputParams.order_number_list = response.order_number_list;
                  vm.inputParams.sa_number_list = response.sa_number_list;
                  vm.inputParams.pi_number_list = response.pi_number_list;
                  vm.inputParams.invoice_no_list = response.invoice_no_list;
                  vm.inputParams.customer_list = response.customer_list;
                });

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    sortArrays: function sortArrays(arrays) {
      return _.orderBy(arrays, 'value', 'asc');
    },
    getCustomerDetail: function getCustomerDetail() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this4.form.country_name = '';
                _this4.selectedData = _this4.inputParams.customer_list.find(function (i) {
                  return i.customer_id == _this4.form.customer_id;
                });

                if (_this4.selectedData) {
                  // ประเทศ
                  _this4.form.country_name = _this4.selectedData.country_name;
                }

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/SearchImproveFineExpComponent.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/om/SearchImproveFineExpComponent.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchImproveFineExpComponent_vue_vue_type_template_id_21bbc378___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378& */ "./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378&");
/* harmony import */ var _SearchImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchImproveFineExpComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchImproveFineExpComponent_vue_vue_type_template_id_21bbc378___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchImproveFineExpComponent_vue_vue_type_template_id_21bbc378___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/SearchImproveFineExpComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchImproveFineExpComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchImproveFineExpComponent_vue_vue_type_template_id_21bbc378___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchImproveFineExpComponent_vue_vue_type_template_id_21bbc378___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchImproveFineExpComponent_vue_vue_type_template_id_21bbc378___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchImproveFineExpComponent.vue?vue&type=template&id=21bbc378& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
    "form",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      attrs: { action: _vm.search_data.search_url, id: "searchForm" }
    },
    [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" วันที่สิ้นสุดการคำนวณ ")]),
            _vm._v(" "),
            _c("el-date-picker", {
              staticStyle: { width: "100%" },
              attrs: {
                type: "date",
                placeholder: "วันที่สิ้นสุดการคำนวณ",
                name: "total_fine_due",
                format: "dd/MM/yyyy",
                "value-format": "dd-MM-yyyy"
              },
              model: {
                value: _vm.form.total_fine_due,
                callback: function($$v) {
                  _vm.$set(_vm.form, "total_fine_due", $$v)
                },
                expression: "form.total_fine_due"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" เลขที่ใบสั่งซื้อ ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "required w-100",
                attrs: {
                  placeholder: "เลขที่ใบสั่งซื้อ",
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  value: _vm.form.order_number
                },
                on: {
                  change: function(value) {
                    _vm.form.order_number = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(
                _vm.sortArrays(_vm.inputParams.order_number_list),
                function(order) {
                  return _c("el-option", {
                    key: order.value,
                    attrs: { label: order.value, value: order.value }
                  })
                }
              ),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-3" }, [
          _c("label", [_vm._v(" แสดงเฉพาะรายการที่มีค่าปรับ เท่านั้น ")]),
          _c("br"),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.fine_flag,
                expression: "form.fine_flag"
              }
            ],
            attrs: { type: "checkbox", name: "fine_flag" },
            domProps: {
              checked: Array.isArray(_vm.form.fine_flag)
                ? _vm._i(_vm.form.fine_flag, null) > -1
                : _vm.form.fine_flag
            },
            on: {
              change: function($event) {
                var $$a = _vm.form.fine_flag,
                  $$el = $event.target,
                  $$c = $$el.checked ? true : false
                if (Array.isArray($$a)) {
                  var $$v = null,
                    $$i = _vm._i($$a, $$v)
                  if ($$el.checked) {
                    $$i < 0 &&
                      _vm.$set(_vm.form, "fine_flag", $$a.concat([$$v]))
                  } else {
                    $$i > -1 &&
                      _vm.$set(
                        _vm.form,
                        "fine_flag",
                        $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                      )
                  }
                } else {
                  _vm.$set(_vm.form, "fine_flag", $$c)
                }
              }
            }
          })
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" เลขที่ใบ SA ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "required w-100",
                attrs: {
                  placeholder: "เลขที่ใบ SA",
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  value: _vm.form.sa_number
                },
                on: {
                  change: function(value) {
                    _vm.form.sa_number = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.sortArrays(_vm.inputParams.sa_number_list), function(
                sa
              ) {
                return _c("el-option", {
                  key: sa.value,
                  attrs: { label: sa.value, value: sa.value }
                })
              }),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" วันครบกำหนดชำระ ")]),
            _vm._v(" "),
            _c("el-date-picker", {
              staticStyle: { width: "100%" },
              attrs: {
                type: "date",
                placeholder: "วันครบกำหนดชำระ",
                name: "due_date",
                format: "dd/MM/yyyy",
                "value-format": "dd-MM-yyyy"
              },
              model: {
                value: _vm.form.due_date,
                callback: function($$v) {
                  _vm.$set(_vm.form, "due_date", $$v)
                },
                expression: "form.due_date"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" เลขที่ใบ PI ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "required w-100",
                attrs: {
                  placeholder: "เลขที่ใบ PI",
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  value: _vm.form.pi_number
                },
                on: {
                  change: function(value) {
                    _vm.form.pi_number = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.sortArrays(_vm.inputParams.pi_number_list), function(
                pi
              ) {
                return _c("el-option", {
                  key: pi.value,
                  attrs: { label: pi.value, value: pi.value }
                })
              }),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" เลขที่ Invoice ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "required w-100",
                attrs: {
                  placeholder: "เลขที่ Invoice",
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  value: _vm.form.invoice_no
                },
                on: {
                  change: function(value) {
                    _vm.form.invoice_no = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.sortArrays(_vm.inputParams.invoice_no_list), function(
                invoice
              ) {
                return _c("el-option", {
                  key: invoice.value,
                  attrs: { label: invoice.value, value: invoice.value }
                })
              }),
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" ลูกค้า ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "required w-100",
                attrs: {
                  placeholder: "ลูกค้า",
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  value: _vm.form.customer_id
                },
                on: {
                  change: function(value) {
                    _vm.form.customer_id = value
                    _vm.getParam()
                    _vm.getCustomerDetail()
                  }
                }
              },
              _vm._l(_vm.inputParams.customer_list, function(customer) {
                return _c("el-option", {
                  key: customer.customer_id,
                  attrs: {
                    label:
                      customer.customer_number + " : " + customer.customer_name,
                    value: customer.customer_id
                  }
                })
              }),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _c("label", [_vm._v(" ประเทศ ")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { disabled: "" },
              model: {
                value: _vm.form.country_name,
                callback: function($$v) {
                  _vm.$set(_vm.form, "country_name", $$v)
                },
                expression: "form.country_name"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-12 text-center" }, [
          _c("label", [_vm._v(" ")]),
          _vm._v(" "),
          _c("div", [
            _c(
              "button",
              {
                staticClass: "btn btn-sm btn-default",
                attrs: { type: "button" },
                on: { click: _vm.searchForm }
              },
              [_vm._v("\n                    คำนวณค่าปรับ\n                ")]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-sm btn-warning",
                attrs: { href: this.search_data.search_url, type: "button" }
              },
              [_c("i", { staticClass: "fa fa-undo" }), _vm._v(" ล้างข้อมูล ")]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "order_number" },
        domProps: { value: _vm.form.order_number }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "sa_number" },
        domProps: { value: _vm.form.sa_number }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "pi_number" },
        domProps: { value: _vm.form.pi_number }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "invoice_no" },
        domProps: { value: _vm.form.invoice_no }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "customer_id" },
        domProps: { value: _vm.form.customer_id }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "check_search" },
        domProps: { value: _vm.check_search }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "due_date" },
        domProps: { value: _vm.form.due_date }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "total_fine_due" },
        domProps: { value: _vm.form.total_fine_due }
      })
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);