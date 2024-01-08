(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Commons_Machine_SummaryEfficiencyProductByGroup_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['pMachineGroup', 'pTotalProductArr', 'pResPlanDate'],
  data: function data() {
    return {
      machineGroup: this.pMachineGroup,
      productArr: this.pTotalProductArr,
      resPlanDate: this.pResPlanDate,
      totalEffProductByGroup: 0
    };
  },
  mounted: function mounted() {//
  },
  watch: {
    effProductByGroup: function effProductByGroup(newValue) {
      return newValue;
    }
  },
  computed: {
    effProductByGroup: function effProductByGroup() {
      var vue = this;
      var totalByGroup = 0;
      vue.resPlanDate.filter(function (planDate) {
        if (vue.pTotalProductArr[vue.machineGroup + planDate.res_plan_date_display]) {
          totalByGroup += Number(vue.productArr[vue.machineGroup + planDate.res_plan_date_display][0].total.toFixed(3));
        }
      });
      vue.totalEffProductByGroup = totalByGroup.toFixed(3);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SummaryEfficiencyProductByGroup_vue_vue_type_template_id_5331d0f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2& */ "./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2&");
/* harmony import */ var _SummaryEfficiencyProductByGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SummaryEfficiencyProductByGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SummaryEfficiencyProductByGroup_vue_vue_type_template_id_5331d0f2___WEBPACK_IMPORTED_MODULE_0__.render,
  _SummaryEfficiencyProductByGroup_vue_vue_type_template_id_5331d0f2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SummaryEfficiencyProductByGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SummaryEfficiencyProductByGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2& ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SummaryEfficiencyProductByGroup_vue_vue_type_template_id_5331d0f2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SummaryEfficiencyProductByGroup_vue_vue_type_template_id_5331d0f2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SummaryEfficiencyProductByGroup_vue_vue_type_template_id_5331d0f2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2&":
/*!********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue?vue&type=template&id=5331d0f2& ***!
  \********************************************************************************************************************************************************************************************************************************************************************/
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
    _c("span", [
      _vm._v(
        " " + _vm._s(_vm._f("number2Digit")(_vm.totalEffProductByGroup)) + " "
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);