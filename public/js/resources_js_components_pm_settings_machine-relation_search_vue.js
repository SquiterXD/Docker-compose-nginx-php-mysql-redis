(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_settings_machine-relation_search_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false,
      listsMachineGroup: [],
      listsLineMf: [],
      listsWork: [],
      listsMachine: [],
      machineGroup: null,
      lineMf: null,
      work: null,
      machine: null
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      var urlParams;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return _this.fetchListsMachineGroup();

            case 2:
              urlParams = new URLSearchParams(window.location.href);
              _this.machineGroup = urlParams.get('machineGroup');
              _context.next = 6;
              return _this.fetchListsLineMf();

            case 6:
              _this.lineMf = urlParams.get('LineMf');
              _context.next = 9;
              return _this.fetchListsWork();

            case 9:
              _this.work = urlParams.get('work');
              _context.next = 12;
              return _this.fetchListsMachine();

            case 12:
              _this.machine = urlParams.get('machine');

            case 13:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    fetchListsMachineGroup: function fetchListsMachineGroup() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.loading = true;
                _context2.next = 3;
                return axios.post("/pm/settings/machine-relation/api/fetch/machine-group").then(function (result) {
                  _this2.listsMachineGroup = result.data;
                })["catch"](function (ex) {
                  _this2.loading = false;
                });

              case 3:
                _this2.loading = false;

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    handleMachineGroupChange: function handleMachineGroupChange() {
      console.log("############# handleMachineGroupChange");
      this.fetchListsLineMf();
      Vue.set(this, "lineMf", null);
      Vue.set(this, "work", null);
      Vue.set(this, "machine", null);
    },
    handleChangeLineMf: function handleChangeLineMf() {
      console.log("############# handleChangeLineMf");
      this.fetchListsWork();
      Vue.set(this, "work", null);
      Vue.set(this, "machine", null);
    },
    handleChangeWork: function handleChangeWork() {
      console.log("############# handleChangeWork");
      this.fetchListsMachine();
      Vue.set(this, "machine", null);
    },
    resetFilter: function resetFilter() {
      Vue.set(this, "machineGroup", null);
      Vue.set(this, "lineMf", null);
      Vue.set(this, "work", null);
      Vue.set(this, "machine", null);
    },
    fetchListsLineMf: function fetchListsLineMf() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.loading = true;
                _context3.next = 3;
                return axios.post("/pm/settings/machine-relation/api/fetch/line-mf", {
                  machineGroup: _this3.machineGroup
                }).then(function (result) {
                  _this3.listsLineMf = result.data;
                })["catch"](function (ex) {
                  _this3.loading = false;
                });

              case 3:
                _this3.loading = false;

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    fetchListsWork: function fetchListsWork() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.loading = true;
                _context4.next = 3;
                return axios.post("/pm/settings/machine-relation/api/fetch/work", {
                  machineGroup: _this4.machineGroup,
                  lineMf: _this4.lineMf
                }).then(function (result) {
                  _this4.listsWork = result.data;
                })["catch"](function (ex) {
                  _this4.loading = false;
                });

              case 3:
                _this4.loading = false;

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    fetchListsMachine: function fetchListsMachine() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this5.loading = true;
                _context5.next = 3;
                return axios.post("/pm/settings/machine-relation/api/fetch/machine", {
                  machineGroup: _this5.machineGroup,
                  lineMf: _this5.lineMf,
                  work: _this5.work
                }).then(function (result) {
                  _this5.listsMachine = result.data;
                })["catch"](function (ex) {
                  _this5.loading = false;
                });

              case 3:
                _this5.loading = false;

              case 4:
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

/***/ "./resources/js/components/pm/settings/machine-relation/search.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/pm/settings/machine-relation/search.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _search_vue_vue_type_template_id_29832400___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search.vue?vue&type=template&id=29832400& */ "./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=template&id=29832400&");
/* harmony import */ var _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./search.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _search_vue_vue_type_template_id_29832400___WEBPACK_IMPORTED_MODULE_0__.render,
  _search_vue_vue_type_template_id_29832400___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/settings/machine-relation/search.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./search.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=template&id=29832400&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=template&id=29832400& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_29832400___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_29832400___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_29832400___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./search.vue?vue&type=template&id=29832400& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=template&id=29832400&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=template&id=29832400&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/machine-relation/search.vue?vue&type=template&id=29832400& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
  return _c("form", [
    _c("input", { attrs: { type: "hidden", name: "l", value: "1" } }),
    _vm._v(" "),
    _c("div", { staticClass: "ibox" }, [
      _c(
        "div",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading,
              expression: "loading"
            }
          ],
          staticClass: "ibox-content"
        },
        [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    { staticClass: "tw-font-bold", attrs: { for: "" } },
                    [_vm._v("กลุ่มชุดเครื่องจักร(มวน)/กลุ่มผลิตภัณฑ์(ก้นกรอง)")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "tw-w-full",
                      attrs: {
                        name: "machineGroup",
                        placeholder:
                          "เลือกข้อมูลกลุ่มชุดเครื่องจักร(มวน)/กลุ่มผลิตภัณฑ์(ก้นกรอง)",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "reserve-keyword": ""
                      },
                      on: { change: _vm.handleMachineGroupChange },
                      model: {
                        value: _vm.machineGroup,
                        callback: function($$v) {
                          _vm.machineGroup = $$v
                        },
                        expression: "machineGroup"
                      }
                    },
                    _vm._l(_vm.listsMachineGroup, function(item) {
                      return _c("el-option", {
                        key: item,
                        attrs: { label: item, value: item }
                      })
                    }),
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    { staticClass: "tw-font-bold", attrs: { for: "" } },
                    [_vm._v("เซ็ตเครื่องจักร")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "tw-w-full",
                      attrs: {
                        name: "LineMf",
                        placeholder: "เลือกข้อมูลเซ็ตเครื่องจักร",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "reserve-keyword": ""
                      },
                      on: { change: _vm.handleChangeLineMf },
                      model: {
                        value: _vm.lineMf,
                        callback: function($$v) {
                          _vm.lineMf = $$v
                        },
                        expression: "lineMf"
                      }
                    },
                    _vm._l(_vm.listsLineMf, function(item) {
                      return _c("el-option", {
                        key: item,
                        attrs: { label: item, value: item }
                      })
                    }),
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    { staticClass: "tw-font-bold", attrs: { for: "" } },
                    [_vm._v("ขั้นตอนการทำงาน")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "tw-w-full",
                      attrs: {
                        name: "work",
                        placeholder: "เลือกข้อมูลขั้นตอนการทำงาน",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "reserve-keyword": ""
                      },
                      on: { change: _vm.handleChangeWork },
                      model: {
                        value: _vm.work,
                        callback: function($$v) {
                          _vm.work = $$v
                        },
                        expression: "work"
                      }
                    },
                    _vm._l(_vm.listsWork, function(item) {
                      return _c("el-option", {
                        key: item,
                        attrs: { label: item, value: item }
                      })
                    }),
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "form-group" },
                [
                  _c(
                    "label",
                    { staticClass: "tw-font-bold", attrs: { for: "" } },
                    [_vm._v("ประเภทเครื่องจักร")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "tw-w-full",
                      attrs: {
                        name: "machine",
                        placeholder: "เลือกข้อมูลประเภทเครื่องจักร",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "reserve-keyword": ""
                      },
                      model: {
                        value: _vm.machine,
                        callback: function($$v) {
                          _vm.machine = $$v
                        },
                        expression: "machine"
                      }
                    },
                    _vm._l(_vm.listsMachine, function(item) {
                      return _c("el-option", {
                        key: item,
                        attrs: { label: item, value: item }
                      })
                    }),
                    1
                  )
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _vm._m(0)
        ]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "text-right", staticStyle: { "padding-top": "15px" } },
      [
        _c(
          "button",
          { staticClass: "btn btn-light", attrs: { type: "submit" } },
          [
            _c("i", {
              staticClass: "fa fa-search",
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(" แสดงข้อมูล\n        ")
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "btn btn-danger",
            attrs: { type: "button", href: "/pm/settings/machine-relation" }
          },
          [_vm._v("\n          ล้างค่า\n        ")]
        )
      ]
    )
  }
]
render._withStripped = true



/***/ })

}]);