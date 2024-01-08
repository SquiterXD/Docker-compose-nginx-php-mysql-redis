(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pd_HistoryInsteadGrades_HeaderComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['medicinalLeafTypesH', 'transDate', 'transBtn', 'currentDateTH'],
  data: function data() {
    return {
      medicinalLeafH: '',
      medicinalLeafHOld: '',
      medicinalLeafL: '',
      medicinalLeafLOld: '',
      medicinalItem: '',
      medicinalLeafTypesL: [],
      medicinalLeafItems: [],
      historyList: [],
      historyGroupByList: [],
      loading: {
        medicinalLeafL: false,
        medicinalItem: false,
        table: false
      },
      isDisabled: {
        medicinalLeafL: true,
        medicinalItem: true // btnAddLine: true,

      },
      isValidate: {
        medicinalLeafH: false,
        medicinalLeafL: false,
        medicinalItem: false
      },
      lastNumberSeq: ''
    };
  },
  mounted: function mounted() {// this.setDataTable();
  },
  methods: {
    getMedicinalLeafTypesL: function getMedicinalLeafTypesL(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.loading.medicinalLeafL = true;
                _this.loading.medicinalItem = true; // $(".table-data").DataTable().destroy();
                // this.setDataTable();

                params = {
                  medicinalLeafTypesH: value
                };
                _context.next = 5;
                return axios.get('/pd/ajax/history-instead-grades/get-medicinal-leaf-types-l', {
                  params: params
                }).then(function (res) {
                  _this.medicinalLeafTypesL = res.data.medicinalLeafTypesL;

                  if (_this.medicinalLeafHOld != value) {
                    _this.medicinalLeafL = '';
                    _this.medicinalItem = '';
                  }

                  if (_this.medicinalLeafTypesL.length != 0) {
                    _this.medicinalLeafHOld = value; // ชนิดใบยา

                    _this.medicinalLeafL = _this.medicinalLeafL ? _this.medicinalLeafL : '';
                    _this.loading.medicinalLeafL = false;
                    _this.isDisabled.medicinalLeafL = false; //รหัสใบยา

                    _this.medicinalItem = _this.medicinalItem ? _this.medicinalLeafL == _this.medicinalLeafLOld ? _this.medicinalItem : '' : '';
                    _this.loading.medicinalItem = false;
                    _this.isDisabled.medicinalItem = _this.medicinalItem ? false : true;
                    _this.$children[3].isDisabledBtnAddLine = true;
                    _this.$children[3].isDisabledBtnSave = true;
                  } else {
                    // ชนิดใบยา
                    _this.medicinalLeafL = '';
                    _this.loading.medicinalLeafL = false;
                    _this.isDisabled.medicinalLeafL = true; //รหัสใบยา 

                    _this.medicinalItem = '';
                    _this.loading.medicinalItem = false;
                    _this.isDisabled.medicinalItem = true;
                    _this.$children[3].isDisabledBtnAddLine = true;
                    _this.$children[3].isDisabledBtnSave = true;
                  }
                });

              case 5:
                return _context.abrupt("return", _context.sent);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getMedicinalLeafItemV: function getMedicinalLeafItemV(medicinalLeafH, medicinalLeafL) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // $(".table-data").DataTable().destroy();
                // this.setDataTable();
                _this2.loading.medicinalItem = true;
                params = {
                  medicinalLeafTypesH: medicinalLeafH,
                  medicinalLeafTypesL: medicinalLeafL
                };
                _context2.next = 4;
                return axios.get('/pd/ajax/history-instead-grades/get-medicinal-leaf-item-v', {
                  params: params
                }).then(function (res) {
                  _this2.medicinalLeafItems = res.data.medicinalLeafItemV;

                  if (_this2.medicinalLeafItems.length != 0) {
                    _this2.medicinalItem = _this2.medicinalItem ? _this2.medicinalLeafL == _this2.medicinalLeafLOld ? _this2.medicinalItem : '' : '';
                    _this2.loading.medicinalItem = false;
                    _this2.isDisabled.medicinalItem = false;
                    _this2.medicinalLeafLOld = _this2.medicinalLeafL;
                    _this2.$children[3].isDisabledBtnAddLine = true;
                    _this2.$children[3].isDisabledBtnSave = true;
                  } else {
                    _this2.medicinalItem = '';
                    _this2.loading.medicinalItem = false;
                    _this2.isDisabled.medicinalItem = true;
                    _this2.$children[3].isDisabledBtnAddLine = true;
                    _this2.$children[3].isDisabledBtnSave = true;
                  }
                });

              case 4:
                return _context2.abrupt("return", _context2.sent);

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getMedicinalItem: function getMedicinalItem(medicinalLeafH, medicinalLeafL, medicinalItem) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // $(".table-data").DataTable().destroy();
                // this.setDataTable();
                if (medicinalItem == '') {
                  _this3.$children[3].isDisabledBtnAddLine = true;
                  _this3.$children[3].isDisabledBtnSave = true;
                  _this3.historyList = [];
                }

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    search: function search(medicinalLeafH, medicinalLeafL, medicinalItem) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this4;

                if (vm.medicinalLeafH) {
                  _context4.next = 6;
                  break;
                }

                vm.isValidate.medicinalLeafH = true;
                return _context4.abrupt("return");

              case 6:
                vm.isValidate.medicinalLeafH = false;

              case 7:
                if (!(!vm.medicinalLeafL && vm.isDisabled.medicinalLeafL == false)) {
                  _context4.next = 12;
                  break;
                }

                vm.isValidate.medicinalLeafL = true;
                return _context4.abrupt("return");

              case 12:
                vm.isValidate.medicinalLeafL = false;

              case 13:
                if (!(!vm.medicinalItem && vm.isDisabled.medicinalItem == false)) {
                  _context4.next = 18;
                  break;
                }

                vm.isValidate.medicinalItem = true;
                return _context4.abrupt("return");

              case 18:
                vm.isValidate.medicinalItem = false;

              case 19:
                if (!(_this4.isValidate.medicinalLeafH == true && _this4.isValidate.medicinalLeafL == true)) {
                  _context4.next = 21;
                  break;
                }

                return _context4.abrupt("return");

              case 21:
                params = {
                  medicinalLeafH: medicinalLeafH,
                  medicinalLeafL: medicinalLeafL,
                  medicinalItem: medicinalItem
                };
                _this4.medicinalItem = _this4.medicinalItem ? _this4.medicinalItem : '';
                _this4.loading.table = true; // $(".table-data").DataTable().destroy();

                _context4.next = 26;
                return axios.get('/pd/ajax/history-instead-grades/search', {
                  params: params
                }).then(function (res) {
                  _this4.historyList = res.data.historyList;
                  _this4.historyGroupByList = res.data.historyGroupByList;
                  _this4.lastNumberSeq = res.data.lastNumberSeq;
                  _this4.loading.table = false;
                  _this4.$children[3].isDisabledBtnAddLine = false;
                  _this4.$children[3].isDisabledBtnSave = false;
                });

              case 26:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _HeaderComponent_vue_vue_type_template_id_7e6f23cb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderComponent.vue?vue&type=template&id=7e6f23cb& */ "./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=template&id=7e6f23cb&");
/* harmony import */ var _HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _HeaderComponent_vue_vue_type_template_id_7e6f23cb___WEBPACK_IMPORTED_MODULE_0__.render,
  _HeaderComponent_vue_vue_type_template_id_7e6f23cb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=template&id=7e6f23cb&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=template&id=7e6f23cb& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_template_id_7e6f23cb___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_template_id_7e6f23cb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_template_id_7e6f23cb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderComponent.vue?vue&type=template&id=7e6f23cb& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=template&id=7e6f23cb&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=template&id=7e6f23cb&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/HistoryInsteadGrades/HeaderComponent.vue?vue&type=template&id=7e6f23cb& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", [
    _c("div", { staticClass: "ibox" }, [
      _c("div", { staticClass: "ibox-content" }, [
        _c("div", { staticClass: "text-right" }, [
          _c(
            "div",
            {
              staticClass: "text-right",
              staticStyle: { "padding-top": "5px" }
            },
            [
              _c(
                "button",
                {
                  staticClass: "btn btn-light",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.search(
                        _vm.medicinalLeafH,
                        _vm.medicinalLeafL,
                        _vm.medicinalItem
                      )
                    }
                  }
                },
                [
                  _c("i", {
                    staticClass: "fa fa-search",
                    attrs: { "aria-hidden": "true" }
                  }),
                  _vm._v(" ค้นหา \n                    ")
                ]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn btn-danger",
                  attrs: { type: "button", href: "/pd/history-instead-grades" }
                },
                [
                  _vm._v(
                    "\n                        ล้างค่า\n                    "
                  )
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "row", staticStyle: { "padding-top": "20px" } },
          [
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("label", [_vm._v("ประเภทใบยา")]),
                _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      placeholder: "เลือกประเภทใบยา",
                      clearable: "",
                      filterable: "",
                      "reserve-keyword": ""
                    },
                    on: {
                      change: function($event) {
                        return _vm.getMedicinalLeafTypesL(_vm.medicinalLeafH)
                      }
                    },
                    model: {
                      value: _vm.medicinalLeafH,
                      callback: function($$v) {
                        _vm.medicinalLeafH = $$v
                      },
                      expression: "medicinalLeafH"
                    }
                  },
                  _vm._l(_vm.medicinalLeafTypesH, function(item, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: {
                        label:
                          item.category_code_1 + " : " + item.category_desc_1,
                        value: item.category_code_1 + "." + item.category_desc_1
                      }
                    })
                  }),
                  1
                ),
                _vm._v(" "),
                this.isValidate.medicinalLeafH
                  ? _c("div", [
                      _c(
                        "span",
                        { staticClass: "form-text m-b-none text-danger" },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s("กรุณาเลือกประเภทใบยา") +
                              "\n                        "
                          )
                        ]
                      )
                    ])
                  : _vm._e()
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("label", [_vm._v("ชนิดใบยา")]),
                _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.loading.medicinalLeafL,
                        expression: "loading.medicinalLeafL"
                      }
                    ],
                    staticClass: "w-100",
                    attrs: {
                      placeholder: "เลือกชนิดใบยา",
                      clearable: "",
                      filterable: "",
                      "reserve-keyword": "",
                      disabled: _vm.isDisabled.medicinalLeafL
                    },
                    on: {
                      change: function($event) {
                        return _vm.getMedicinalLeafItemV(
                          _vm.medicinalLeafH,
                          _vm.medicinalLeafL
                        )
                      }
                    },
                    model: {
                      value: _vm.medicinalLeafL,
                      callback: function($$v) {
                        _vm.medicinalLeafL = $$v
                      },
                      expression: "medicinalLeafL"
                    }
                  },
                  _vm._l(_vm.medicinalLeafTypesL, function(item, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: {
                        label:
                          item.category_code_2 + " : " + item.category_desc_2,
                        value: item.category_code_2 + "." + item.category_desc_2
                      }
                    })
                  }),
                  1
                ),
                _vm._v(" "),
                this.isValidate.medicinalLeafL
                  ? _c("div", [
                      _c(
                        "span",
                        { staticClass: "form-text m-b-none text-danger" },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s("กรุณาเลือกชนิดใบยา") +
                              "\n                        "
                          )
                        ]
                      )
                    ])
                  : _vm._e()
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("label", [_vm._v("กลุ่มใบยา")]),
                _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.loading.medicinalItem,
                        expression: "loading.medicinalItem"
                      }
                    ],
                    staticClass: "w-100",
                    attrs: {
                      placeholder: "เลือกกลุ่มใบยา",
                      clearable: "",
                      filterable: "",
                      "reserve-keyword": "",
                      disabled: _vm.isDisabled.medicinalItem
                    },
                    on: {
                      change: function($event) {
                        return _vm.getMedicinalItem(
                          _vm.medicinalLeafH,
                          _vm.medicinalLeafL,
                          _vm.medicinalItem
                        )
                      }
                    },
                    model: {
                      value: _vm.medicinalItem,
                      callback: function($$v) {
                        _vm.medicinalItem = $$v
                      },
                      expression: "medicinalItem"
                    }
                  },
                  _vm._l(_vm.medicinalLeafItems, function(item, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: {
                        label: item.medicinal_leaf_group,
                        value: item.medicinal_leaf_group
                      }
                    })
                  }),
                  1
                ),
                _vm._v(" "),
                this.isValidate.medicinalItem
                  ? _c("div", [
                      _c(
                        "span",
                        { staticClass: "form-text m-b-none text-danger" },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s("กรุณาเลือกกลุ่มใบยา") +
                              "\n                        "
                          )
                        ]
                      )
                    ])
                  : _vm._e()
              ],
              1
            )
          ]
        )
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loading.table,
            expression: "loading.table"
          }
        ]
      },
      [
        _c("history-instead-grades-table", {
          attrs: {
            transDate: _vm.transDate,
            historyList: _vm.historyList,
            transBtn: _vm.transBtn,
            lastNumberSeq: _vm.lastNumberSeq,
            currentDateTH: _vm.currentDateTH,
            historyGroupByList: _vm.historyGroupByList
          }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);