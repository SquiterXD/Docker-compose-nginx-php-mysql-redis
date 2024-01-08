(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_reports_ctr0020_Form_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=script&lang=js& ***!
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
//
//
//
//



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYears", "periodYearValue", "versionNos", "cigVersions", "filterVersions", "versionNoValue", "planVersionNos", "planVersionNoValue", "periodNameFroms", "periodNameFromValue", "periodNameTos", "periodNameToValue", "accountTypes", "accountTypeValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      versionNo: this.versionNoValue,
      planVersionNo: this.planVersionNoValue,
      periodNameFrom: this.periodNameFromValue,
      periodNameTo: this.periodNameToValue,
      accountType: this.accountTypeValue,
      versionNoOptions: [],
      planVersionNoOptions: [],
      periodNameFromOptions: [],
      periodNameToOptions: [],
      accountTypeOptions: this.accountTypes
    };
  },
  mounted: function mounted() {
    if (this.periodYearValue) {
      this.filterVersionOptions(this.periodYearValue);
      this.filterPlanVersionNoOptions(this.periodYearValue);
      this.filterPeriodNameFromOptions(this.periodYearValue);
      this.filterPeriodNameToOptions(this.periodYearValue); // this.filterAccountTypeOptions(this.periodYearValue);
    }
  },
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("period_year", this.periodYear ? this.periodYear : '');
      queryParams.set("version_no", this.versionNo ? this.versionNo : '');
      queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
      queryParams.set("period_name_from", this.periodNameFrom ? this.periodNameFrom : '');
      queryParams.set("period_name_to", this.periodNameTo ? this.periodNameTo : '');
      queryParams.set("account_type", this.accountType ? this.accountType : '');
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    onPeriodYearChanged: function onPeriodYearChanged(periodYear) {
      this.periodYear = periodYear;
      this.filterVersionOptions(this.periodYear);

      if (this.versionNoOptions.length > 0) {
        this.versionNo = this.versionNoOptions[0].version_no;
      }

      this.filterPlanVersionNoOptions(this.periodYear);

      if (this.planVersionNoOptions.length > 0) {
        this.planVersionNo = this.planVersionNoOptions[0].plan_version_no;
      }

      this.filterPeriodNameFromOptions(this.periodYear);

      if (this.periodNameFromOptions.length > 0) {
        this.periodNameFrom = this.periodNameFromOptions[0].period_name_value;
      }

      this.filterPeriodNameToOptions(this.periodYear);

      if (this.periodNameToOptions.length > 0) {
        this.periodNameTo = this.periodNameToOptions[this.periodNameToOptions.length - 1].period_name_value;
      } // this.filterAccountTypeOptions(this.periodYear);
      // if(this.accountTypeOptions.length > 0) {
      //     this.accountType = this.accountTypeOptions[(this.accountTypeOptions.length-1)].account_type;
      // }


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
    onPeriodNameFromChanged: function onPeriodNameFromChanged(periodNameFrom) {
      this.periodNameFrom = periodNameFrom;
      this.setUrlParams();
    },
    onPeriodNameToChanged: function onPeriodNameToChanged(periodNameTo) {
      this.periodNameTo = periodNameTo;
      this.setUrlParams();
    },
    onAccountTypeChanged: function onAccountTypeChanged(accountType) {
      this.accountType = accountType;
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
    filterPeriodNameFromOptions: function filterPeriodNameFromOptions(periodYear) {
      if (periodYear) {
        this.periodNameFromOptions = this.periodNameFroms.filter(function (item) {
          return item.period_year == periodYear;
        });
      } else {
        this.periodNameFromOptions = [];
      }
    },
    filterPeriodNameToOptions: function filterPeriodNameToOptions(periodYear) {
      if (periodYear) {
        this.periodNameToOptions = this.periodNameTos.filter(function (item) {
          return item.period_year == periodYear;
        });
      } else {
        this.periodNameToOptions = [];
      }
    } // filterAccountTypeOptions(periodYear) {
    //     if(periodYear){
    //         this.accountTypeOptions = this.accountTypes.filter(item => item.period_year == periodYear);
    //     } else {
    //         this.accountTypeOptions = [];
    //     }
    // },

  }
});

/***/ }),

/***/ "./resources/js/components/ct/reports/ctr0020/Form.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/ct/reports/ctr0020/Form.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Form_vue_vue_type_template_id_7f507ac7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Form.vue?vue&type=template&id=7f507ac7& */ "./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=template&id=7f507ac7&");
/* harmony import */ var _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Form.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Form_vue_vue_type_template_id_7f507ac7___WEBPACK_IMPORTED_MODULE_0__.render,
  _Form_vue_vue_type_template_id_7f507ac7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/reports/ctr0020/Form.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=template&id=7f507ac7&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=template&id=7f507ac7& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_7f507ac7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_7f507ac7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_7f507ac7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=template&id=7f507ac7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=template&id=7f507ac7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=template&id=7f507ac7&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/reports/ctr0020/Form.vue?vue&type=template&id=7f507ac7& ***!
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
          _vm._v(" ครั้งที่กระดาษปันส่วน ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "version_no",
                id: "input_version_no",
                placeholder: "ครั้งที่กระดาษปันส่วน ",
                "option-key": "version_no",
                "option-value": "version_no",
                "option-label": "version_no",
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
          _vm._v(" ครั้งที่กระดาษทำการ ")
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
                placeholder: "ครั้งที่กระดาษทำการ ",
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
          _vm._v(" เปรียบเทียบค่าใช้จ่ายจริงจาก ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "period_name_from",
                id: "input_period_name_from",
                placeholder: "เปรียบเทียบค่าใช้จ่ายจริงจาก ",
                "option-key": "period_name_value",
                "option-value": "period_name_value",
                "option-label": "period_name_label",
                "select-options": _vm.periodNameFromOptions,
                clearable: false,
                filterable: true,
                value: _vm.periodNameFrom
              },
              on: {
                onSelected: function($event) {
                  return _vm.onPeriodNameFromChanged($event)
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
          _vm._v(" เปรียบเทียบค่าใช้จ่ายจริงถึง ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "period_name_to",
                id: "input_period_name_to",
                placeholder: "เปรียบเทียบค่าใช้จ่ายจริงถึง ",
                "option-key": "period_name_value",
                "option-value": "period_name_value",
                "option-label": "period_name_label",
                "select-options": _vm.periodNameToOptions,
                clearable: false,
                filterable: true,
                value: _vm.periodNameTo
              },
              on: {
                onSelected: function($event) {
                  return _vm.onPeriodNameToChanged($event)
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
          _vm._v(" ประเภทบัญชี ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("qm-el-select", {
              attrs: {
                name: "account_type",
                id: "input_account_type",
                placeholder: "ประเภทบัญชี ",
                "option-key": "account_type",
                "option-value": "account_type",
                "option-label": "description",
                "select-options": _vm.accountTypeOptions,
                clearable: false,
                filterable: true,
                value: _vm.accountType
              },
              on: {
                onSelected: function($event) {
                  return _vm.onAccountTypeChanged($event)
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
                !_vm.periodNameFrom ||
                !_vm.periodNameTo
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