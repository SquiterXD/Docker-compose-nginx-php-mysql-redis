(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_SampleResultStatusCheckboxes_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
  props: ["pendingSampleResultStatusValue", "conformSampleResultStatusValue", "nonconformSampleResultStatusValue", "rejectedSampleResultStatusValue", "selectAllValue"],
  data: function data() {
    return {
      pendingSampleResultStatusChecked: this.pendingSampleResultStatusValue,
      conformSampleResultStatusChecked: this.conformSampleResultStatusValue,
      nonconformSampleResultStatusChecked: this.nonconformSampleResultStatusValue,
      rejectedSampleResultStatusChecked: this.rejectedSampleResultStatusValue,
      selectAllChecked: this.selectAllValue
    };
  },
  methods: {
    onPendingSampleResultStatusChanged: function onPendingSampleResultStatusChanged(value) {
      this.pendingSampleResultStatusChecked = value;
      this.refreshSelectAllValue();
    },
    onConformSampleResultStatusChanged: function onConformSampleResultStatusChanged(value) {
      this.conformSampleResultStatusChecked = value;
      this.refreshSelectAllValue();
    },
    onNonconformSampleResultStatusChanged: function onNonconformSampleResultStatusChanged(value) {
      this.nonconformSampleResultStatusChecked = value;
      this.refreshSelectAllValue();
    },
    onRejectedSampleResultStatusChanged: function onRejectedSampleResultStatusChanged(value) {
      this.rejectedSampleResultStatusChecked = value;
      this.refreshSelectAllValue();
    },
    refreshSelectAllValue: function refreshSelectAllValue() {
      if (this.pendingSampleResultStatusChecked == true && this.conformSampleResultStatusChecked == true && this.nonconformSampleResultStatusChecked == true && this.rejectedSampleResultStatusChecked == true) {
        this.selectAllChecked = true;
      } else {
        this.selectAllChecked = false;
      }
    },
    onSelectAllChanged: function onSelectAllChanged(value) {
      this.pendingSampleResultStatusChecked = value;
      this.conformSampleResultStatusChecked = value;
      this.nonconformSampleResultStatusChecked = value;
      this.rejectedSampleResultStatusChecked = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/SampleResultStatusCheckboxes.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/qm/SampleResultStatusCheckboxes.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SampleResultStatusCheckboxes_vue_vue_type_template_id_59e5f5fc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc& */ "./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc&");
/* harmony import */ var _SampleResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SampleResultStatusCheckboxes.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SampleResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SampleResultStatusCheckboxes_vue_vue_type_template_id_59e5f5fc___WEBPACK_IMPORTED_MODULE_0__.render,
  _SampleResultStatusCheckboxes_vue_vue_type_template_id_59e5f5fc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/SampleResultStatusCheckboxes.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SampleResultStatusCheckboxes.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleResultStatusCheckboxes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleResultStatusCheckboxes_vue_vue_type_template_id_59e5f5fc___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleResultStatusCheckboxes_vue_vue_type_template_id_59e5f5fc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SampleResultStatusCheckboxes_vue_vue_type_template_id_59e5f5fc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/SampleResultStatusCheckboxes.vue?vue&type=template&id=59e5f5fc& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
      _vm._v(" สถานะผลการทดสอบ ")
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
                name: "pending_sample_result_status",
                id: "input_pending_sample_result_status",
                label: "ผลยังไม่ออก",
                "input-class": "tw-w-full tw-bg-yellow-200",
                value: _vm.pendingSampleResultStatusChecked
              },
              on: { change: _vm.onPendingSampleResultStatusChanged }
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
                name: "conform_sample_result_status",
                id: "input_conform_sample_result_status",
                label: "ผลทดสอบปกติ",
                "input-class": "tw-w-full tw-bg-green-300",
                value: _vm.conformSampleResultStatusChecked
              },
              on: { change: _vm.onConformSampleResultStatusChanged }
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
                name: "nonconform_sample_result_status",
                id: "input_nonconform_sample_result_status",
                label: "พบค่าความผิดปกติ",
                "input-class": "tw-w-full tw-bg-blue-400",
                value: _vm.nonconformSampleResultStatusChecked
              },
              on: { change: _vm.onNonconformSampleResultStatusChanged }
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
                name: "rejected_sample_result_status",
                id: "input_rejected_sample_result_status",
                label: "ปฏิเสธผล",
                "input-class": "tw-w-full tw-bg-yellow-600",
                value: _vm.rejectedSampleResultStatusChecked
              },
              on: { change: _vm.onRejectedSampleResultStatusChanged }
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
            name: "select_all_sample_result_status",
            id: "input_select_all_sample_result_status",
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