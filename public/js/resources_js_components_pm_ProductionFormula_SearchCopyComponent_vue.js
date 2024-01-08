(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_ProductionFormula_SearchCopyComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['search_data', 'trans_btn'],
  data: function data() {
    return {
      loading: false,
      inputParams: {
        status_list: [],
        inventory_item_id_list: [],
        folmula_type_list: [],
        wip_list: [],
        machine_list: [],
        version_list: [],
        period_year_list: []
      },
      form: {
        status: null,
        inventory_item_id: null,
        folmula_type: null,
        wip: null,
        machine: null,
        version: null,
        period_year: null
      }
    };
  },
  mounted: function mounted() {
    this.autoLoad();
  },
  computed: {},
  watch: {// "transDateFormat.to_date": function (newValue) {
    //     this.getParam();
    // },
    // // wipRequestNo : async function (value, oldValue) {
    // //     this.getParam();
    // // },
    // wipRequestStatus : async function (value, oldValue) {
    //     this.getParam();
    // },
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
                vm.form.status = vm.search_data.status != '' ? vm.search_data.status : null, vm.form.inventory_item_id = vm.search_data.inventory_item_id != '' ? vm.search_data.inventory_item_id : null, vm.form.folmula_type = vm.search_data.folmula_type != '' ? vm.search_data.folmula_type : null, vm.form.wip = vm.search_data.wip != '' ? vm.search_data.wip : null, vm.form.machine = vm.search_data.machine != '' ? vm.search_data.machine : null, vm.form.version = vm.search_data.version != '' ? vm.search_data.version : null, vm.form.period_year = vm.search_data.period_year != '' ? vm.search_data.period_year : null, vm.getParam();

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
                _this2.form.status = null;
                _this2.form.inventory_item_id = null;
                _this2.form.folmula_type = null;
                _this2.form.wip = null;
                _this2.form.machine = null;
                _this2.form.version = null;
                _this2.form.period_year = null;

                _this2.getParam();

              case 8:
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
                  status: vm.form.status,
                  inventory_item_id: vm.form.inventory_item_id,
                  folmula_type: vm.form.folmula_type,
                  wip: vm.form.wip,
                  machine: vm.form.machine,
                  version: vm.form.version,
                  period_year: vm.form.period_year
                };
                axios.get(vm.search_data.search_url, {
                  params: params
                }).then(function (res) {
                  var response = res.data;
                  vm.loading = false;
                  vm.inputParams.status_list = response.status_list;
                  vm.inputParams.inventory_item_id_list = response.inventory_item_id_list;
                  vm.inputParams.folmula_type_list = response.folmula_type_list;
                  vm.inputParams.wip_list = response.wip_list;
                  vm.inputParams.machine_list = response.machine_list;
                  vm.inputParams.version_list = response.version_list;
                  vm.inputParams.period_year_list = response.period_year_list;
                });

              case 4:
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

/***/ "./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchCopyComponent_vue_vue_type_template_id_2d2353d2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchCopyComponent.vue?vue&type=template&id=2d2353d2& */ "./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=template&id=2d2353d2&");
/* harmony import */ var _SearchCopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchCopyComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchCopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchCopyComponent_vue_vue_type_template_id_2d2353d2___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchCopyComponent_vue_vue_type_template_id_2d2353d2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchCopyComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=template&id=2d2353d2&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=template&id=2d2353d2& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCopyComponent_vue_vue_type_template_id_2d2353d2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCopyComponent_vue_vue_type_template_id_2d2353d2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCopyComponent_vue_vue_type_template_id_2d2353d2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchCopyComponent.vue?vue&type=template&id=2d2353d2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=template&id=2d2353d2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=template&id=2d2353d2&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/SearchCopyComponent.vue?vue&type=template&id=2d2353d2& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
        _c(
          "div",
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("สถานะ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "สถานะ",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.status
                },
                on: {
                  change: function(value) {
                    _vm.form.status = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.status_list, function(item) {
                return _c("el-option", {
                  key: item.value,
                  attrs: { label: item.label, value: item.value }
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
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("รหัสสินค้า")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "รหัสสินค้า",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.inventory_item_id
                },
                on: {
                  change: function(value) {
                    _vm.form.inventory_item_id = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.inventory_item_id_list, function(item) {
                return _c("el-option", {
                  key: item.value,
                  attrs: { label: item.label, value: item.value }
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
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("ประเภทสูตร")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "ประเภทสูตร",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.folmula_type
                },
                on: {
                  change: function(value) {
                    _vm.form.folmula_type = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.folmula_type_list, function(item) {
                return item.label == "สูตรมาตรฐาน"
                  ? _c("el-option", {
                      key: item.value,
                      attrs: { label: item.label, value: item.value }
                    })
                  : _vm._e()
              }),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("ขั้นตอนการทำงาน")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "ขั้นตอนการทำงาน",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.wip
                },
                on: {
                  change: function(value) {
                    _vm.form.wip = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.wip_list, function(item) {
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
      _c("div", { staticClass: "row mt-2" }, [
        _c(
          "div",
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("ประเภทเครื่องจักร")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "ประเภทเครื่องจักร",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.machine
                },
                on: {
                  change: function(value) {
                    _vm.form.machine = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.machine_list, function(item) {
                return _c("el-option", {
                  key: item.value,
                  attrs: { label: item.label, value: item.value }
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
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("เวอร์ชั่น")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "เวอร์ชั่น",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.version
                },
                on: {
                  change: function(value) {
                    _vm.form.version = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.version_list, function(item) {
                return _c("el-option", {
                  key: item.value,
                  attrs: { label: item.label, value: item.value }
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
          { staticClass: "col-lg-3 col-md-6 col-sm-12 col-xs-12" },
          [
            _c("label", [_vm._v("ปีงบประมาณ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  placeholder: "ปีงบประมาณ",
                  clearable: "",
                  filterable: "",
                  value: _vm.form.period_year
                },
                on: {
                  change: function(value) {
                    _vm.form.period_year = value
                    _vm.getParam()
                  }
                }
              },
              _vm._l(_vm.inputParams.period_year_list, function(item) {
                return _c("el-option", {
                  key: item.value,
                  attrs: { label: item.label, value: item.value }
                })
              }),
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "col-12 text-right" }, [
          _c("label", [_vm._v(" ")]),
          _vm._v(" "),
          _c("div", [
            _c(
              "button",
              {
                class: _vm.trans_btn.search.class,
                attrs: { type: "button" },
                on: { click: _vm.searchForm }
              },
              [
                _c("i", { class: _vm.trans_btn.search.icon }),
                _vm._v("\n                    แสดงข้อมูล\n                ")
              ]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-danger",
                attrs: { type: "button" },
                on: { click: _vm.clearForm }
              },
              [_vm._v("\n                    ล้างค่า\n                ")]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "status" },
        domProps: { value: _vm.form.status }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "inventory_item_id" },
        domProps: { value: _vm.form.inventory_item_id }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "folmula_type" },
        domProps: { value: _vm.form.folmula_type }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "wip" },
        domProps: { value: _vm.form.wip }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "machine" },
        domProps: { value: _vm.form.machine }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "version" },
        domProps: { value: _vm.form.version }
      }),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: "period_year" },
        domProps: { value: _vm.form.period_year }
      })
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);