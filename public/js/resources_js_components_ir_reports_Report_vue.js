(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_reports_Report_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/reports/Report.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/reports/Report.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['url', 'trans-date', 'trans-btn'],
  data: function data() {
    return {
      options: [],
      value: [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      infoAttributes: [] // urlTest: 'http://offline.test/ir/ajax/ir-report-get-info-attribute?program_code=IRR0001',

    };
  },
  mounted: function mounted() {// console.log('xxx');
    // this.getData();
    // this.getInfos();
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get(_this.url.getInfor + '?query=' + query).then(function (res) {
                  _this.infos = res.data.ptirReportInfos;
                  _this.programs = res.data.programs;
                }).then(function () {
                  // this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                  _this.remote(query);
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    remote: function remote(query) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (query !== "") {
                  _this2.loading = true;
                  setTimeout(function () {
                    _this2.loading = false;
                    _this2.options = _this2.programs.filter(function (item) {
                      return item.program_code.toLowerCase().indexOf(query.toLowerCase()) > -1;
                    });
                  }, 200);
                } else {
                  _this2.options = [];
                }

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getData: function getData(query) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                axios.get(_this3.url.getInfor).then(function (res) {
                  _this3.infos = res.data.ptirReportInfos;
                  _this3.programs = res.data.programs;
                }).then(function () {
                  _this3.list = _this3.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getInfos: function getInfos() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                axios.get(_this4.url.getInfoAttribute + '?program_code=' + _this4.value // this.urlTest
                ).then(function (res) {
                  _this4.infoAttributes = res.data.reportInfor; // this.programs = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getYear: function getYear(value) {},
    exportReport: function exportReport() {}
  }
});

/***/ }),

/***/ "./resources/js/components/ir/reports/Report.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/ir/reports/Report.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Report_vue_vue_type_template_id_2ef35ce2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Report.vue?vue&type=template&id=2ef35ce2& */ "./resources/js/components/ir/reports/Report.vue?vue&type=template&id=2ef35ce2&");
/* harmony import */ var _Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Report.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/reports/Report.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Report_vue_vue_type_template_id_2ef35ce2___WEBPACK_IMPORTED_MODULE_0__.render,
  _Report_vue_vue_type_template_id_2ef35ce2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/reports/Report.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/reports/Report.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/ir/reports/Report.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Report.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/reports/Report.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/reports/Report.vue?vue&type=template&id=2ef35ce2&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/ir/reports/Report.vue?vue&type=template&id=2ef35ce2& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_2ef35ce2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_2ef35ce2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_2ef35ce2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Report.vue?vue&type=template&id=2ef35ce2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/reports/Report.vue?vue&type=template&id=2ef35ce2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/reports/Report.vue?vue&type=template&id=2ef35ce2&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/reports/Report.vue?vue&type=template&id=2ef35ce2& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
    [
      _c(
        "el-select",
        {
          staticClass: "col-11",
          attrs: {
            filterable: "",
            remote: "",
            "reserve-keyword": "",
            placeholder: "Please enter a report ",
            "remote-method": _vm.remoteMethod
          },
          model: {
            value: _vm.value,
            callback: function($$v) {
              _vm.value = $$v
            },
            expression: "value"
          }
        },
        _vm._l(_vm.options, function(item) {
          return _c("el-option", {
            key: item.program_code,
            attrs: { label: item.program_code, value: item.program_code }
          })
        }),
        1
      ),
      _vm._v(" "),
      _c(
        "button",
        { staticClass: "btn btn-primary", on: { click: _vm.getInfos } },
        [_vm._v("Search ")]
      ),
      _vm._v(" "),
      _c("form", { attrs: { action: _vm.url.getParam, method: "get" } }, [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _vm.infoAttributes.length > 0
          ? _c(
              "div",
              { staticClass: "form-group" },
              [
                _vm._l(_vm.infoAttributes, function(infoAttribute, index) {
                  return _c("div", { key: index }, [
                    infoAttribute.form_type == "text"
                      ? _c("div", { staticClass: "row m-2" }, [
                          _c("div", { staticClass: "m-1 col-3 text-right" }, [
                            _c("div", [
                              _vm._v(_vm._s(infoAttribute.display_value))
                            ])
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-6" }, [
                            _c("input", {
                              staticClass: "form-control w-100 ",
                              attrs: {
                                type: "text",
                                name: infoAttribute.attribute_name
                              }
                            })
                          ])
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    infoAttribute.form_type == "date"
                      ? _c("div", { staticClass: "row m-2" }, [
                          _c("div", { staticClass: "m-1 col-3 text-right" }, [
                            _c("div", [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(infoAttribute.display_value) +
                                  "\n                        "
                              )
                            ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-6" },
                            [
                              _c("datepicker-th", {
                                staticClass: "form-control col-lg-12",
                                staticStyle: {
                                  width: "100%",
                                  "border-radius": "3px"
                                },
                                attrs: {
                                  placeholder: "เลือกวัน",
                                  name: infoAttribute.attribute_name,
                                  id: "input_date",
                                  pType: "year",
                                  format: _vm.transDate["js-year-format"]
                                },
                                on: { dateWasSelected: _vm.getYear },
                                model: {
                                  value: infoAttribute.attribute_name,
                                  callback: function($$v) {
                                    _vm.$set(
                                      infoAttribute,
                                      "attribute_name",
                                      $$v
                                    )
                                  },
                                  expression: "infoAttribute.attribute_name"
                                }
                              })
                            ],
                            1
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    infoAttribute.form_type == "select"
                      ? _c("div", { staticClass: "row m-2" }, [
                          _c("div", { staticClass: "m-1 col-3 text-right" }, [
                            _c("div", [
                              _vm._v(_vm._s(infoAttribute.display_value))
                            ])
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-6" }, [
                            _c(
                              "select",
                              {
                                staticClass: "form-control w-100",
                                attrs: { name: infoAttribute.attribute_name }
                              },
                              _vm._l(infoAttribute.lists, function(list) {
                                return _c(
                                  "option",
                                  {
                                    key: list.value,
                                    domProps: { value: list.value }
                                  },
                                  [
                                    _vm._v(
                                      _vm._s(list.label) +
                                        "\n                            "
                                    )
                                  ]
                                )
                              }),
                              0
                            )
                          ])
                        ])
                      : _vm._e()
                  ])
                }),
                _vm._v(" "),
                _c("input", {
                  attrs: { type: "hidden", name: "program_code" },
                  domProps: { value: _vm.value }
                }),
                _vm._v(" "),
                _vm._m(0)
              ],
              2
            )
          : _vm._e()
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c(
        "button",
        { staticClass: "btn btn-primary mt-4", attrs: { type: "submit" } },
        [_vm._v("Export")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);