(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_reports_ctr0026_Form_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["periodYears", "periodYearValue", "versionNos", "cigVersions", "filterVersions", "versionNoValue", "planVersionNos", "planVersionNoValue", "costCodes", "costCodeFromValue", "costCodeToValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      versionNo: this.versionNoValue,
      planVersionNo: this.planVersionNoValue,
      costCodeFrom: this.costCodeFromValue,
      costCodeTo: this.costCodeToValue,
      versionNoOptions: [],
      planVersionNoOptions: [],
      costCodeFromOptions: [],
      costCodeToOptions: [],
      productOfYear: false
    };
  },
  mounted: function mounted() {
    if (this.periodYearValue) {
      this.filterVersionOptions(this.periodYearValue);
      this.filterPlanVersionNoOptions(this.periodYearValue);
      this.filterCostCodeFromOptions(this.periodYearValue);

      if (this.costCodeFromValue) {
        this.filterCostCodeToOptions(this.periodYearValue, this.costCodeFromValue);
      } else {
        this.filterCostCodeToOptions(this.periodYearValue, null);
      }
    }
  },
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("period_year", this.periodYear ? this.periodYear : '');
      queryParams.set("ct14_version_no", this.versionNo ? this.versionNo : '');
      queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
      queryParams.set("cost_code_from", this.costCodeFrom ? this.costCodeFrom : '');
      queryParams.set("cost_code_to", this.costCodeTo ? this.costCodeTo : '');
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    onPeriodYearChanged: function onPeriodYearChanged(periodYear) {
      this.periodYear = periodYear;
      this.filterVersionOptions(this.periodYear);

      if (this.versionNoOptions.length > 0) {
        this.versionNo = this.versionNoOptions[0].ct14_version_no;
      }

      this.filterPlanVersionNoOptions(this.periodYear);

      if (this.planVersionNoOptions.length > 0) {
        this.planVersionNo = this.planVersionNoOptions[0].plan_version_no;
      }

      this.filterCostCodeFromOptions(this.periodYear);

      if (this.costCodeFromOptions.length > 0) {
        this.costCodeFrom = this.costCodeFromOptions[0].cost_code_value;
        this.filterCostCodeToOptions(this.periodYear, this.costCodeFrom);
      } else {
        this.filterCostCodeToOptions(this.periodYear, null);
      }

      if (this.costCodeToOptions.length > 0) {
        this.costCodeTo = this.costCodeToOptions[0].cost_code_value;
      }

      this.setUrlParams();
    },
    onVersionNoChanged: function onVersionNoChanged(versionNo) {
      this.versionNo = versionNo;
      this.setUrlParams();
    },
    onPlanVersionNoChanged: function onPlanVersionNoChanged(planVersionNo) {
      this.planVersionNo = planVersionNo;
      this.setUrlParams();
    },
    onCostCodeFromChanged: function onCostCodeFromChanged(costCode) {
      this.costCodeFrom = costCode;
      this.filterCostCodeToOptions(this.periodYear, this.costCodeFrom);

      if (this.costCodeToOptions.length > 0) {
        this.costCodeTo = this.costCodeToOptions[0].cost_code_value;
      }

      this.setUrlParams();
    },
    onCostCodeToChanged: function onCostCodeToChanged(costCode) {
      this.costCodeTo = costCode;
      this.setUrlParams();
    },
    filterVersionOptions: function filterVersionOptions(periodYear) {
      if (periodYear) {
        this.versionNoOptions = this.versionNos.filter(function (item) {
          return item.period_year == periodYear;
        });
      } else {
        this.versionNoOptions = [];
      }
    },
    filterPlanVersionNoOptions: function filterPlanVersionNoOptions(periodYear) {
      if (periodYear) {
        this.planVersionNoOptions = this.planVersionNos.filter(function (item) {
          return item.period_year == periodYear;
        });
      } else {
        this.planVersionNoOptions = [];
      }
    },
    filterCostCodeFromOptions: function filterCostCodeFromOptions(periodYear) {
      if (periodYear) {
        this.costCodeFromOptions = this.costCodes.filter(function (item) {
          return item.period_year == periodYear;
        });
      } else {
        this.costCodeFromOptions = [];
      }
    },
    filterCostCodeToOptions: function filterCostCodeToOptions(periodYear, fromCostCode) {
      if (periodYear) {
        if (fromCostCode) {
          this.costCodeToOptions = this.costCodes.filter(function (item) {
            return item.period_year == periodYear && parseInt(item.cost_code) >= parseInt(fromCostCode);
          });
        } else {
          this.costCodeToOptions = this.costCodes.filter(function (item) {
            return item.period_year == periodYear;
          });
        }
      } else {
        this.costCodeToOptions = [];
      }
    },
    onProductOfYearChanged: function onProductOfYearChanged(value) {
      this.productOfYear = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ct/reports/ctr0026/Form.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/ct/reports/ctr0026/Form.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Form_vue_vue_type_template_id_39092181___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Form.vue?vue&type=template&id=39092181& */ "./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=template&id=39092181&");
/* harmony import */ var _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Form.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Form_vue_vue_type_template_id_39092181___WEBPACK_IMPORTED_MODULE_0__.render,
  _Form_vue_vue_type_template_id_39092181___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/reports/ctr0026/Form.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=template&id=39092181&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=template&id=39092181& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_39092181___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_39092181___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_39092181___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=template&id=39092181& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=template&id=39092181&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=template&id=39092181&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0026/Form.vue?vue&type=template&id=39092181& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "offset-md-2 col-md-8" }, [
      _c("div", { staticClass: "row form-group" }, [
        _c("label", { staticClass: "col-md-4 required" }, [_vm._v(" ปี ")]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "period_year",
                id: "input_period_year",
                placeholder: "ปี ",
                "option-key": "period_year_value",
                "option-value": "period_year_value",
                "option-label": "period_year_label",
                "select-options": _vm.periodYears,
                clearable: false,
                filterable: true,
                value: _vm.periodYear
              },
              on: {
                onSelected: function($event) {
                  return _vm.onPeriodYearChanged($event)
                }
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row form-group" }, [
        _c("label", { staticClass: "col-md-4 required" }, [
          _vm._v(" ครั้งที่ ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "ct14_version_no",
                id: "input_ct14_version_no",
                placeholder: "ครั้งที่ ",
                "option-key": "ct14_version_no",
                "option-value": "ct14_version_no",
                "option-label": "ct14_version_no",
                "select-options": _vm.versionNoOptions,
                clearable: false,
                filterable: true,
                value: _vm.versionNo
              },
              on: {
                onSelected: function($event) {
                  return _vm.onVersionNoChanged($event)
                }
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row form-group" }, [
        _c("label", { staticClass: "col-md-4 required" }, [
          _vm._v(" แผนการผลิตครั้งที่ ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "plan_version_no",
                id: "input_plan_version_no",
                placeholder: "แผนการผลิตครั้งที่ ",
                "option-key": "plan_version_no",
                "option-value": "plan_version_no",
                "option-label": "plan_version_no",
                "select-options": _vm.planVersionNoOptions,
                clearable: false,
                filterable: true,
                value: _vm.planVersionNo
              },
              on: {
                onSelected: function($event) {
                  return _vm.onPlanVersionNoChanged($event)
                }
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row form-group" }, [
        _c("label", { staticClass: "col-md-4 required" }, [
          _vm._v(" ศูนย์ต้นทุน ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "cost_code_from",
                id: "input_cost_code_from",
                placeholder: "ศูนย์ต้นทุน ",
                "option-key": "cost_code_value",
                "option-value": "cost_code_value",
                "option-label": "cost_code_label",
                "select-options": _vm.costCodeFromOptions,
                clearable: false,
                filterable: true,
                value: _vm.costCodeFrom
              },
              on: {
                onSelected: function($event) {
                  return _vm.onCostCodeFromChanged($event)
                }
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row form-group" }, [
        _c("label", { staticClass: "col-md-4 required" }, [
          _vm._v(" ถึงศูนย์ต้นทุน ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "cost_code_to",
                id: "input_cost_code_to",
                placeholder: "ถึงศูนย์ต้นทุน ",
                "option-key": "cost_code_value",
                "option-value": "cost_code_value",
                "option-label": "cost_code_label",
                "select-options": _vm.costCodeToOptions,
                clearable: false,
                filterable: true,
                value: _vm.costCodeTo
              },
              on: {
                onSelected: function($event) {
                  return _vm.onCostCodeToChanged($event)
                }
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row form-group" }, [
        _c("label", { staticClass: "col-md-4" }, [
          _vm._v(" ผลิตภัณฑ์ใหม่ระหว่างปี ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("el-checkbox", {
              attrs: {
                name: "input_product_of_year",
                id: "input_product_of_year"
              },
              on: {
                change: function($event) {
                  return _vm.onProductOfYearChanged($event)
                }
              }
            }),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.productOfYear,
                  expression: "productOfYear"
                }
              ],
              attrs: { type: "hidden", name: "product_of_year" },
              domProps: { value: _vm.productOfYear },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.productOfYear = $event.target.value
                }
              }
            })
          ],
          1
        )
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "offset-md-2 col-md-8 text-right tw-mt-2 tw-mb-4" },
      [
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-primary",
            attrs: {
              type: "submit",
              disabled:
                !_vm.periodYear ||
                !_vm.versionNo ||
                !_vm.planVersionNo ||
                !_vm.costCodeFrom
            }
          },
          [
            _c("i", { staticClass: "fa fa fa-file-excel-o tw-mr-1" }),
            _vm._v(" พิมพ์รายงาน\n        ")
          ]
        )
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);