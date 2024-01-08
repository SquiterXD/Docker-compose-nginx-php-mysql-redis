(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_ResultStatusCheckboxes_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
//
//
//
//
//
//
//
//
//
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
  props: ["pendingResultValue", "correctResultValue", "incorrectResultValue", "selectAllValue"],
  data: function data() {
    return {
      pendingResultChecked: this.pendingResultValue,
      correctResultChecked: this.correctResultValue,
      incorrectResultChecked: this.incorrectResultValue,
      selectAllChecked: this.selectAllValue
    };
  },
  methods: {
    onPendingResultChanged: function onPendingResultChanged(value) {
      this.pendingResultChecked = value;
      this.refreshSelectAllValue();
    },
    onCorrectResultChanged: function onCorrectResultChanged(value) {
      this.correctResultChecked = value;
      this.refreshSelectAllValue();
    },
    onIncorrectResultChanged: function onIncorrectResultChanged(value) {
      this.incorrectResultChecked = value;
      this.refreshSelectAllValue();
    },
    refreshSelectAllValue: function refreshSelectAllValue() {
      if (this.pendingResultChecked == true && this.correctResultChecked == true && this.incorrectResultChecked == true) {
        this.selectAllChecked = true;
      } else {
        this.selectAllChecked = false;
      }
    },
    onSelectAllChanged: function onSelectAllChanged(value) {
      this.pendingResultChecked = value;
      this.correctResultChecked = value;
      this.incorrectResultChecked = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/ResultStatusCheckboxes.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/qm/ResultStatusCheckboxes.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ResultStatusCheckboxes_vue_vue_type_template_id_1f9fcbb8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8& */ "./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8&");
/* harmony import */ var _ResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ResultStatusCheckboxes.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ResultStatusCheckboxes_vue_vue_type_template_id_1f9fcbb8___WEBPACK_IMPORTED_MODULE_0__.render,
  _ResultStatusCheckboxes_vue_vue_type_template_id_1f9fcbb8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/ResultStatusCheckboxes.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ResultStatusCheckboxes.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResultStatusCheckboxes_vue_vue_type_template_id_1f9fcbb8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResultStatusCheckboxes_vue_vue_type_template_id_1f9fcbb8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResultStatusCheckboxes_vue_vue_type_template_id_1f9fcbb8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ResultStatusCheckboxes.vue?vue&type=template&id=1f9fcbb8& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
    _c("label", { staticClass: "col-sm-2 col-form-label required" }, [
      _vm._v(" สถานะการตรวจสอบ ")
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-md-2 md:tw-pr-0 tw-pr-4" },
      [
        _c("qm-el-checkbox", {
          attrs: {
            name: "pending_result",
            id: "input_pending_result",
            label: "ยังไม่ลงผลการตรวจสอบ",
            "input-class": "tw-w-full tw-bg-yellow-300",
            value: _vm.pendingResultChecked
          },
          on: { change: _vm.onPendingResultChanged }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-md-2 md:tw-pr-0 tw-pr-4" },
      [
        _c("qm-el-checkbox", {
          attrs: {
            name: "correct_result",
            id: "input_correct_result",
            label: "ลงผลแล้ว ผลทดสอบปกติ",
            "input-class": "tw-w-full tw-bg-green-300",
            value: _vm.correctResultChecked
          },
          on: { change: _vm.onCorrectResultChanged }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-md-3 md:tw-pr-0 tw-pr-4" },
      [
        _c("qm-el-checkbox", {
          attrs: {
            name: "incorrect_result",
            id: "input_incorrect_result",
            label: "ลงผลแล้ว พบค่าความผิดปกติ",
            "input-class": "tw-w-4/5 tw-bg-red-300",
            value: _vm.incorrectResultChecked
          },
          on: { change: _vm.onIncorrectResultChanged }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-md-2 md:tw-pr-0 tw-pr-4" },
      [
        _c("qm-el-checkbox", {
          attrs: {
            name: "select_all_result",
            id: "input_select_all_result",
            label: "เลือกสถานะทั้งหมด",
            "input-class": "tw-w-full tw-bg-blue-300",
            value: _vm.selectAllChecked
          },
          on: { change: _vm.onSelectAllChanged }
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