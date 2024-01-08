(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_specify_percentage_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_percentage/Create.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_percentage/Create.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      tableData: [],
      options: [],
      cost_center: ""
    };
  },
  computed: {
    sum_dl_absorption_rate: function sum_dl_absorption_rate() {
      var result = 0;

      var data = _.filter(this.tableData, function (item) {
        return !item.disable;
      });

      result = _.sumBy(data, function (item) {
        return parseFloat(item.dl_absorption_rate) || 0;
      });
      return result;
    },
    sum_voh_absorption_rate: function sum_voh_absorption_rate() {
      var result = 0;

      var data = _.filter(this.tableData, function (item) {
        return !item.disable;
      });

      result = _.sumBy(data, function (item) {
        return parseFloat(item.voh_absorption_rate) || 0;
      });
      return result;
    },
    sum_foh_absorption_rate: function sum_foh_absorption_rate() {
      var result = 0;

      var data = _.filter(this.tableData, function (item) {
        return !item.disable;
      });

      result = _.sumBy(data, function (item) {
        return parseFloat(item.foh_absorption_rate) || 0;
      });
      return result;
    }
  },
  mounted: function mounted() {
    this.getCostCenters();
  },
  methods: {
    getCostCenters: function getCostCenters() {
      var _this = this;

      axios.get("/ct/ajax/cost_center/cost-center-view").then(function (res) {
        _this.options = res.data;
      });
    },
    sumTableData: function sumTableData() {
      _.sumBy(this.data_test, function (o) {
        return o.percen_of_wage;
      });

      var data = {
        code: "",
        name: "รวม",
        percen_of_wage: 0,
        percen_of_cp_vc: 0,
        percen_of_cp_fe: 0,
        disable: true
      };
      return data;
    },
    selectCostCenter: function selectCostCenter() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get("/ct/ajax/product_processes/".concat(_this2.cost_center)).then(function (res) {
                  console.log('selectCostCenter: ', res.data);
                  _this2.tableData = res.data;

                  _this2.tableData.push(_this2.sumTableData());
                });

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    submitForm: function submitForm() {
      var data = _.filter(this.tableData, function (item) {
        return !item.disable;
      }); // const data = this.tableData;


      var form_input = [];
      data.forEach(function (item) {
        form_input.push({
          // id: item.cc_production_process_id,
          oprn_id: item.oprn_id,
          routing_id: item.routing_id,
          cost_code: item.cost_code,
          percen_of_wage: item.dl_absorption_rate,
          percen_of_cp_vc: item.voh_absorption_rate,
          percen_of_cp_fe: item.foh_absorption_rate
        });
      });
      console.log({
        data: data,
        form_input: form_input
      });
      axios.put("/ct/ajax/product_processes/", form_input).then(function (res) {
        swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08", "success");
      })["catch"](function (err) {
        swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E44\u0E14\u0E49 | ".concat(err.response.data.error), "error");
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ct/specify_percentage/Create.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/ct/specify_percentage/Create.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_3a68ea00_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=3a68ea00&scoped=true& */ "./resources/js/components/ct/specify_percentage/Create.vue?vue&type=template&id=3a68ea00&scoped=true&");
/* harmony import */ var _Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/specify_percentage/Create.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Create_vue_vue_type_template_id_3a68ea00_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Create_vue_vue_type_template_id_3a68ea00_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3a68ea00",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/specify_percentage/Create.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/specify_percentage/Create.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/ct/specify_percentage/Create.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_percentage/Create.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/specify_percentage/Create.vue?vue&type=template&id=3a68ea00&scoped=true&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/ct/specify_percentage/Create.vue?vue&type=template&id=3a68ea00&scoped=true& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_3a68ea00_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_3a68ea00_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_3a68ea00_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=template&id=3a68ea00&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_percentage/Create.vue?vue&type=template&id=3a68ea00&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_percentage/Create.vue?vue&type=template&id=3a68ea00&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_percentage/Create.vue?vue&type=template&id=3a68ea00&scoped=true& ***!
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
    "div",
    [
      _c(
        "el-select",
        {
          attrs: { placeholder: "เลือกศูนย์ต้นทุน" },
          on: { change: _vm.selectCostCenter },
          model: {
            value: _vm.cost_center,
            callback: function($$v) {
              _vm.cost_center = $$v
            },
            expression: "cost_center"
          }
        },
        _vm._l(_vm.options, function(item) {
          return _c("el-option", {
            key: item.cost_code,
            attrs: {
              label: item.cost_code + "-" + item.description,
              value: item.cost_code
            }
          })
        }),
        1
      ),
      _vm._v(" "),
      _vm.cost_center
        ? _c("div", [
            _c(
              "div",
              { staticClass: "mt-4" },
              [
                _c(
                  "el-table",
                  {
                    staticStyle: { width: "100%" },
                    attrs: { border: "", data: _vm.tableData }
                  },
                  [
                    _c("el-table-column", {
                      attrs: {
                        prop: "wip_step",
                        label: "รหัสขั้นตอน",
                        align: "center"
                      }
                    }),
                    _vm._v(" "),
                    _c("el-table-column", {
                      attrs: {
                        prop: "wip_step_desc",
                        label: "ขั้นตอนการผลิต",
                        width: "180",
                        align: "center"
                      }
                    }),
                    _vm._v(" "),
                    _c("el-table-column", {
                      attrs: {
                        prop: "dl_absorption_rate",
                        label: "%เทียบสำเร็จค่าแรง",
                        align: "center"
                      },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                scope.row.disable
                                  ? _c("el-input-number", {
                                      staticStyle: { width: "100%" },
                                      attrs: {
                                        value: _vm.sum_dl_absorption_rate,
                                        placeholder: "%เทียบสำเร็จค่าแรง",
                                        disabled: scope.row.disable,
                                        controls: false,
                                        precision: 2
                                      }
                                    })
                                  : _c("el-input-number", {
                                      staticStyle: { width: "100%" },
                                      attrs: {
                                        min: 0,
                                        controls: false,
                                        precision: 2,
                                        placeholder: "%เทียบสำเร็จค่าแรง",
                                        disabled: scope.row.disable
                                      },
                                      model: {
                                        value: scope.row.dl_absorption_rate,
                                        callback: function($$v) {
                                          _vm.$set(
                                            scope.row,
                                            "dl_absorption_rate",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "scope.row.dl_absorption_rate"
                                      }
                                    })
                              ]
                            }
                          }
                        ],
                        null,
                        false,
                        3980652853
                      )
                    }),
                    _vm._v(" "),
                    _c("el-table-column", {
                      attrs: {
                        prop: "voh_absorption_rate",
                        label: "%เทียบสำเร็จค่าใช้จ่ายผันแปร",
                        align: "center"
                      },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                scope.row.disable
                                  ? _c("el-input-number", {
                                      staticStyle: { width: "100%" },
                                      attrs: {
                                        placeholder:
                                          "%เทียบสำเร็จค่าใช้จ่ายผันแปร",
                                        value: _vm.sum_voh_absorption_rate,
                                        disabled: scope.row.disable,
                                        controls: false,
                                        precision: 2
                                      }
                                    })
                                  : _c("el-input-number", {
                                      staticStyle: { width: "100%" },
                                      attrs: {
                                        min: 0,
                                        controls: false,
                                        precision: 2,
                                        placeholder:
                                          "%เทียบสำเร็จค่าใช้จ่ายผันแปร"
                                      },
                                      model: {
                                        value: scope.row.voh_absorption_rate,
                                        callback: function($$v) {
                                          _vm.$set(
                                            scope.row,
                                            "voh_absorption_rate",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "scope.row.voh_absorption_rate"
                                      }
                                    })
                              ]
                            }
                          }
                        ],
                        null,
                        false,
                        1594927495
                      )
                    }),
                    _vm._v(" "),
                    _c("el-table-column", {
                      attrs: {
                        label: "%เทียบสำเร็จค่าใช้จ่ายคงที่",
                        align: "center",
                        prop: "foh_absorption_rate"
                      },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                scope.row.disable
                                  ? _c("el-input-number", {
                                      staticStyle: { width: "100%" },
                                      attrs: {
                                        placeholder:
                                          "%เทียบสำเร็จค่าใช้จ่ายคงที่",
                                        value: _vm.sum_foh_absorption_rate,
                                        disabled: scope.row.disable,
                                        controls: false,
                                        precision: 2
                                      }
                                    })
                                  : _c("el-input-number", {
                                      staticStyle: { width: "100%" },
                                      attrs: {
                                        min: 0,
                                        controls: false,
                                        precision: 2,
                                        placeholder:
                                          "%เทียบสำเร็จค่าใช้จ่ายคงที่"
                                      },
                                      model: {
                                        value: scope.row.foh_absorption_rate,
                                        callback: function($$v) {
                                          _vm.$set(
                                            scope.row,
                                            "foh_absorption_rate",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "scope.row.foh_absorption_rate"
                                      }
                                    })
                              ]
                            }
                          }
                        ],
                        null,
                        false,
                        4076021607
                      )
                    })
                  ],
                  1
                )
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "mt-4 text-right" },
              [
                _c(
                  "el-button",
                  {
                    staticClass: "btn-success",
                    attrs: { type: "success" },
                    on: {
                      click: function($event) {
                        return _vm.submitForm()
                      }
                    }
                  },
                  [_vm._v("บันทึก\n            ")]
                )
              ],
              1
            )
          ])
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);