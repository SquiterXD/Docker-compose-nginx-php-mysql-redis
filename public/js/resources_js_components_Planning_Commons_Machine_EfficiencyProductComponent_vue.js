(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Commons_Machine_EfficiencyProductComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
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
  props: ['pEfficiencyProducts', 'pLines', 'pPlanDate', 'pMachineGroup', 'pTotalProductArr', 'pMachineMaintenances', 'pMachineDowntimes'],
  data: function data() {
    return {
      efficiency: 0,
      efficiencyProducts: this.pEfficiencyProducts,
      lines: this.pLines,
      planDate: this.pPlanDate,
      machineGroup: this.pMachineGroup,
      productArr: this.pTotalProductArr,
      machineMaintenances: this.pMachineMaintenances,
      machineDowntimes: this.pMachineDowntimes
    };
  },
  mounted: function mounted() {//
  },
  watch: {
    product: function product(newValue) {
      return newValue;
    },
    productToLine: function productToLine(newValue) {
      return newValue;
    }
  },
  computed: {
    product: function product() {
      var vue = this;
      var result = 0;
      Object.values(vue.lines[vue.machineGroup]).filter(function (line, index) {
        if (vue.machineMaintenances[vue.planDate.res_plan_date_display][line.machine_name] || vue.machineDowntimes[vue.planDate.res_plan_date_display][line.machine_name] || vue.planDate.working_hour == 0) {
          // vue.planDate.holiday_flag == 'Y'
          result += 0;
        } else {
          result += Number(vue.efficiencyProducts[vue.planDate.res_plan_date_display][line.machine_name]);
        }

        return;
      });
      vue.efficiency = Number(result);
    },
    //return ค่าไปยัง line --total all line
    productToLine: function productToLine() {
      var vue = this;
      var result = [];
      Object.values(vue.lines[vue.machineGroup]).reduce(function (res, line) {
        if (!res[vue.machineGroup]) {
          res[vue.machineGroup] = {
            total: 0
          };
          result.push(res[vue.machineGroup]);
        }

        if (vue.machineMaintenances[vue.planDate.res_plan_date_display][line.machine_name] || vue.machineDowntimes[vue.planDate.res_plan_date_display][line.machine_name] || vue.planDate.working_hour == 0) {
          // vue.planDate.holiday_flag == 'Y'
          res[vue.machineGroup].total += 0;
        } else {
          res[vue.machineGroup].total += Number(vue.efficiencyProducts[vue.planDate.res_plan_date_display][line.machine_name]);
        }

        return res;
      }, {});
      Vue.set(vue.productArr, vue.machineGroup + vue.planDate.res_plan_date_display, result);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EfficiencyProductComponent_vue_vue_type_template_id_0d830fdd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd& */ "./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd&");
/* harmony import */ var _EfficiencyProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EfficiencyProductComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EfficiencyProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EfficiencyProductComponent_vue_vue_type_template_id_0d830fdd___WEBPACK_IMPORTED_MODULE_0__.render,
  _EfficiencyProductComponent_vue_vue_type_template_id_0d830fdd___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EfficiencyProductComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyProductComponent_vue_vue_type_template_id_0d830fdd___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyProductComponent_vue_vue_type_template_id_0d830fdd___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyProductComponent_vue_vue_type_template_id_0d830fdd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyProductComponent.vue?vue&type=template&id=0d830fdd& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
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
      _vm._v(" " + _vm._s(_vm._f("number2Digit")(_vm.efficiency)) + " ")
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);