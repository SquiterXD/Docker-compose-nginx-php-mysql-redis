(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_reports_IRR0005_3_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['url', 'trans-date', 'trans-btn', // 'module',
  // 'url-ger-param',
  'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      // infoAttributes:[],
      date: {},
      // functionName : "",
      // functionReport: "",
      reportType: 'pdf',
      errorLists: [],
      groupCodeList: [],
      carInsuranceeList: [],
      departmentList: [],
      departmentListTo: [],
      month: '',
      group_code: '',
      car_insurance: '',
      department_code_from: '',
      department_code_to: '',
      seq_1: true,
      seq_2: true,
      seq_3: true,
      month_value: ''
    };
  },
  methods: {
    getData: function getData(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get(_this.url.getInfor).then(function (res) {
                  _this.programs = res.data.programs;
                }).then(function () {
                  _this.list = _this.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {});

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getInfos: function getInfos() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.infoAttributes = [];
                _this2.functionName = "";
                _this2.errorLists = []; // this.value = [];

                axios.get(_this2.url.getInfoAttribute + '?program_code=' + _this2.value // this.urlTest
                ).then(function (res) {
                  // console.log(res);
                  _this2.infoAttributes = res.data.reportInfor;
                  _this2.functionName = res.data.functionName;
                  _this2.functionReport = res.data.functionReport;
                  _this2.programs = res.data.programs;
                  _this2.options = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getYear: function getYear(value, month) {
      this.group_code_value = 'x111'; // this.infoAttributes.find(data => {
      //     if (data.attribute_name == month) {
      //         data.form_value = value;
      //     }
      // });

      this.month = value;
      console.log('value', value);
      console.log('month', month); // this.month = moment(value)
      //                 .add(+543, "years")
      //                 .format(this.transDate["js-datatime-format"]);
      // this.month = moment(value).format(this.transDate["js-datatime-format"]);

      if (value) {
        this.getGroupCode();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    exportReport: function exportReport() {},
    checkForm: function checkForm(e) {
      if (!this.month) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุเดือน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getGroupCode: function getGroupCode() {
      var _this3 = this;

      console.log('func getGroupCode');
      axios.get("/ir/reports/get-group-code", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this3.groupCodeList = res.data.data;
      })["catch"](function (error) {});
    },
    getCarInsurance: function getCarInsurance() {
      var _this4 = this;

      // console.log('func getCarInsurance', this.group_code);
      axios.get("/ir/reports/get-car-insurance", {
        params: {
          month: this.month,
          group_code: this.group_code
        }
      }).then(function (res) {
        _this4.carInsuranceeList = res.data.data;
      })["catch"](function (error) {});
    },
    getDepartment: function getDepartment() {
      var _this5 = this;

      if (this.car_insurance) {
        axios.get("/ir/reports/get-department", {
          params: {
            month: this.month,
            group_code: this.group_code,
            car_insurance: this.car_insurance
          }
        }).then(function (res) {
          _this5.departmentList = res.data.data;
        })["catch"](function (error) {});
      }
    },
    getDepartmentTo: function getDepartmentTo() {
      var _this6 = this;

      if (this.car_insurance) {
        axios.get("/ir/reports/get-department-to", {
          params: {
            month: this.month,
            group_code: this.group_code,
            car_insurance: this.car_insurance,
            department_code_from: this.department_code_from
          }
        }).then(function (res) {
          _this6.departmentListTo = res.data.data;
        })["catch"](function (error) {});
      }
    }
  } // watch: {
  //     componentDetail : async function () {
  //         this.$emit('componentDetail', this.componentDetail)           
  //     },
  // }

});

/***/ }),

/***/ "./resources/js/components/reports/IRR0005_3.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0005_3.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0005_3.vue?vue&type=template&id=7b8133f7& */ "./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&");
/* harmony import */ var _IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0005_3.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0005_3.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0005_3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0005_3.vue?vue&type=template&id=7b8133f7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7& ***!
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
  return _c("div", [
    _c(
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  on: {
                    change: function($event) {
                      return _vm.getCarInsurance()
                    }
                  },
                  model: {
                    value: _vm.group_code,
                    callback: function($$v) {
                      _vm.group_code = $$v
                    },
                    expression: "group_code"
                  }
                },
                [
                  _vm._l(_vm.groupCodeList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "group_code" },
                    domProps: { value: _vm.group_code }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.group_code
                  },
                  on: {
                    change: function($event) {
                      return _vm.getDepartment()
                    }
                  },
                  model: {
                    value: _vm.car_insurance,
                    callback: function($$v) {
                      _vm.car_insurance = $$v
                    },
                    expression: "car_insurance"
                  }
                },
                [
                  _vm._l(_vm.carInsuranceeList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "car_insurance" },
                    domProps: { value: _vm.car_insurance }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(3),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.car_insurance
                  },
                  model: {
                    value: _vm.department_code_from,
                    callback: function($$v) {
                      _vm.department_code_from = $$v
                    },
                    expression: "department_code_from"
                  }
                },
                [
                  _vm._l(_vm.departmentList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "department_code_from" },
                    domProps: { value: _vm.department_code_from }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2 mb-2" }, [
          _vm._m(4),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.car_insurance
                  },
                  model: {
                    value: _vm.department_code_to,
                    callback: function($$v) {
                      _vm.department_code_to = $$v
                    },
                    expression: "department_code_to"
                  }
                },
                [
                  _vm._l(_vm.departmentList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "department_code_to" },
                    domProps: { value: _vm.department_code_to }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
            ]
          )
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [_vm._v("\n                    กลุ่ม\n                ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ประเภทประกันภัย\n                ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    หน่วยงานตั้งแต่\n                ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [_vm._v("\n                    หน่วยงานถึง\n                ")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);