(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_InputSearchMachineSetByQcArea_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
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
  props: ["qcAreas", "machines", "qcAreaValue", "machineValue"],
  data: function data() {
    return {
      qcArea: this.qcAreaValue,
      machine: this.machineValue,
      qcAreaOptions: this.qcAreas,
      machineOptions: this.getMachineOptionsInQcArea(this.qcAreaValue)
    };
  },
  methods: {
    getMachineOptionsInQcArea: function getMachineOptionsInQcArea(qcAreaValue) {
      var options = this.machines.filter(function (item) {
        return item.qc_area == qcAreaValue;
      });
      return options;
    },
    onQcAreaWasSelected: function onQcAreaWasSelected(value) {
      this.machineOptions = this.getMachineOptionsInQcArea(value);
      this.qcArea = value;
    },
    onMachineSetWasSelected: function onMachineSetWasSelected(value) {
      this.machine = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/InputSearchMachineSetByQcArea.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/qm/InputSearchMachineSetByQcArea.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputSearchMachineSetByQcArea_vue_vue_type_template_id_ad0b1c4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a& */ "./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a&");
/* harmony import */ var _InputSearchMachineSetByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputSearchMachineSetByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputSearchMachineSetByQcArea_vue_vue_type_template_id_ad0b1c4a___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputSearchMachineSetByQcArea_vue_vue_type_template_id_ad0b1c4a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/InputSearchMachineSetByQcArea.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchMachineSetByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchMachineSetByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchMachineSetByQcArea_vue_vue_type_template_id_ad0b1c4a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchMachineSetByQcArea_vue_vue_type_template_id_ad0b1c4a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchMachineSetByQcArea_vue_vue_type_template_id_ad0b1c4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchMachineSetByQcArea.vue?vue&type=template&id=ad0b1c4a& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "col-12" }, [
    _c("div", { staticClass: "row form-group" }, [
      _c("label", { staticClass: "col-md-4 col-form-label" }, [
        _vm._v(" เขตตรวจคุณภาพ ")
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-8" },
        [
          _c("qm-el-select", {
            attrs: {
              name: "qc_area",
              id: "input_qc_area",
              "option-key": "qc_area_value",
              "option-value": "qc_area_value",
              "option-label": "qc_area_label",
              "select-options": _vm.qcAreaOptions,
              value: _vm.qcArea,
              clearable: true,
              filterable: true
            },
            on: { onSelected: _vm.onQcAreaWasSelected }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row form-group" }, [
      _c("label", { staticClass: "col-md-4 col-form-label" }, [
        _vm._v(" หมายเลขเครื่อง ")
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-8" },
        [
          _c("qm-el-select", {
            attrs: {
              name: "machine_set",
              id: "input_machine_set",
              "option-key": "qc_area_machine_set",
              "option-value": "machine_set_value",
              "option-label": "machine_set_label",
              "select-options": _vm.machineOptions,
              value: _vm.machine,
              clearable: true,
              filterable: true
            },
            on: { onSelected: _vm.onMachineSetWasSelected }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);