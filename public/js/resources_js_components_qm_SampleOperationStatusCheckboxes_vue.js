(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_SampleOperationStatusCheckboxes_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["pendingSampleOperationStatusValue", "inprogressSampleOperationStatusValue", "completedSampleOperationStatusValue", "rejectedSampleOperationStatusValue", "selectAllValue"],
  data: function data() {
    return {
      pendingSampleOperationStatusChecked: this.pendingSampleOperationStatusValue,
      inprogressSampleOperationStatusChecked: this.inprogressSampleOperationStatusValue,
      completedSampleOperationStatusChecked: this.completedSampleOperationStatusValue,
      rejectedSampleOperationStatusChecked: this.rejectedSampleOperationStatusValue,
      selectAllChecked: this.selectAllValue
    };
  },
  methods: {
    onPendingSampleOperationStatusChanged: function onPendingSampleOperationStatusChanged(value) {
      this.pendingSampleOperationStatusChecked = value;
      this.refreshSelectAllValue();
    },
    onCorrectSampleOperationStatusChanged: function onCorrectSampleOperationStatusChanged(value) {
      this.inprogressSampleOperationStatusChecked = value;
      this.refreshSelectAllValue();
    },
    onCompletedSampleOperationStatusChanged: function onCompletedSampleOperationStatusChanged(value) {
      this.completedSampleOperationStatusChecked = value;
      this.refreshSelectAllValue();
    },
    onRejectedSampleOperationStatusChanged: function onRejectedSampleOperationStatusChanged(value) {
      this.rejectedSampleOperationStatusChecked = value;
      this.refreshSelectAllValue();
    },
    refreshSelectAllValue: function refreshSelectAllValue() {
      if (this.pendingSampleOperationStatusChecked == true && this.inprogressSampleOperationStatusChecked == true && this.completedSampleOperationStatusChecked == true && this.rejectedSampleOperationStatusChecked == true) {
        this.selectAllChecked = true;
      } else {
        this.selectAllChecked = false;
      }
    },
    onSelectAllChanged: function onSelectAllChanged(value) {
      this.pendingSampleOperationStatusChecked = value;
      this.inprogressSampleOperationStatusChecked = value;
      this.completedSampleOperationStatusChecked = value;
      this.rejectedSampleOperationStatusChecked = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/SampleOperationStatusCheckboxes.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/qm/SampleOperationStatusCheckboxes.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SampleOperationStatusCheckboxes_vue_vue_type_template_id_7409bb38___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38& */ "./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38&");
/* harmony import */ var _SampleOperationStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SampleOperationStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SampleOperationStatusCheckboxes_vue_vue_type_template_id_7409bb38___WEBPACK_IMPORTED_MODULE_0__.render,
  _SampleOperationStatusCheckboxes_vue_vue_type_template_id_7409bb38___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/SampleOperationStatusCheckboxes.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleOperationStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleOperationStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleOperationStatusCheckboxes_vue_vue_type_template_id_7409bb38___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleOperationStatusCheckboxes_vue_vue_type_template_id_7409bb38___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleOperationStatusCheckboxes_vue_vue_type_template_id_7409bb38___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleOperationStatusCheckboxes.vue?vue&type=template&id=7409bb38& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
    _c("label", { staticClass: "col-md-2 col-form-label required" }, [
      _vm._v(" สถานะการลงผล ")
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-md-7 md:tw-pr-20 tw-pr-4" }, [
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-3 md:tw-pr-0 tw-pr-4" },
          [
            _c("qm-el-checkbox", {
              attrs: {
                name: "pending_sample_operation_status",
                id: "input_pending_sample_operation_status",
                label: "ยังไม่ลงผล",
                "input-class": "tw-w-full tw-bg-yellow-200",
                value: _vm.pendingSampleOperationStatusChecked
              },
              on: { change: _vm.onPendingSampleOperationStatusChanged }
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
                name: "inprogress_sample_operation_status",
                id: "input_inprogress_sample_operation_status",
                label: "อยู่ระหว่างลงผล",
                "input-class": "tw-w-full tw-bg-yellow-400",
                value: _vm.inprogressSampleOperationStatusChecked
              },
              on: { change: _vm.onCorrectSampleOperationStatusChanged }
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
                name: "completed_sample_operation_status",
                id: "input_completed_sample_operation_status",
                label: "ลงผลเสร็จแล้ว",
                "input-class": "tw-w-full tw-bg-green-300",
                value: _vm.completedSampleOperationStatusChecked
              },
              on: { change: _vm.onCompletedSampleOperationStatusChanged }
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
                name: "rejected_sample_operation_status",
                id: "input_rejected_sample_operation_status",
                label: "ปฏิเสธผล",
                "input-class": "tw-w-full tw-bg-yellow-600",
                value: _vm.rejectedSampleOperationStatusChecked
              },
              on: { change: _vm.onRejectedSampleOperationStatusChanged }
            })
          ],
          1
        )
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-md-2 md:tw-pr-0 tw-pr-4" },
      [
        _c("qm-el-checkbox", {
          attrs: {
            name: "select_all_sample_operation_status",
            id: "input_select_all_sample_operation_status",
            label: "เลือกสถานะทั้งหมด",
            "input-class": "tw-w-full tw-bg-blue-200",
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