(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_InputMachineNameByQcArea_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      var options = [];

      if (qcAreaValue == "ALL") {
        options = [{
          "machine_name_value": "ALL",
          "machine_name_label": "เลือกทั้งหมด"
        }];
      } else {
        options = [{
          "machine_name_value": "ALL",
          "machine_name_label": "เลือกทั้งหมด"
        }].concat(_toConsumableArray(this.machines.filter(function (item) {
          return item.qc_area == qcAreaValue;
        })));
      }

      return options;
    },
    onQcAreaWasSelected: function onQcAreaWasSelected(value) {
      this.machineOptions = this.getMachineOptionsInQcArea(value);
      this.qcArea = value;
      this.machine = "ALL"; // default value
    },
    onMachineNameWasSelected: function onMachineNameWasSelected(value) {
      this.machine = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/InputMachineNameByQcArea.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/qm/InputMachineNameByQcArea.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputMachineNameByQcArea_vue_vue_type_template_id_1a64bf96___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96& */ "./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96&");
/* harmony import */ var _InputMachineNameByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputMachineNameByQcArea.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputMachineNameByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputMachineNameByQcArea_vue_vue_type_template_id_1a64bf96___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputMachineNameByQcArea_vue_vue_type_template_id_1a64bf96___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/InputMachineNameByQcArea.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineNameByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputMachineNameByQcArea.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineNameByQcArea_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineNameByQcArea_vue_vue_type_template_id_1a64bf96___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineNameByQcArea_vue_vue_type_template_id_1a64bf96___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineNameByQcArea_vue_vue_type_template_id_1a64bf96___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineNameByQcArea.vue?vue&type=template&id=1a64bf96& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "col-md-12" }, [
    _c(
      "div",
      { staticClass: "form-group" },
      [
        _c("label", { staticClass: "required" }, [_vm._v(" เขตตรวจคุณภาพ ")]),
        _vm._v(" "),
        _c("qm-el-select", {
          attrs: {
            name: "qc_area",
            id: "input_qc_area",
            placeholder: "เลือกเขตตรวจคุณภาพ",
            "option-key": "qc_area_value",
            "option-value": "qc_area_value",
            "option-label": "qc_area_label",
            "select-options": _vm.qcAreaOptions,
            value: _vm.qcArea,
            filterable: true
          },
          on: { onSelected: _vm.onQcAreaWasSelected }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "form-group" },
      [
        _c("label", { staticClass: "required" }, [_vm._v("หมายเลขเครื่อง")]),
        _vm._v(" "),
        _c("qm-el-select", {
          attrs: {
            name: "machine_name",
            id: "input_machine_name",
            placeholder: "เลือกหมายเลขเครื่อง",
            "option-key": "qc_area_machine_name",
            "option-value": "machine_name_value",
            "option-label": "machine_name_label",
            "select-options": _vm.machineOptions,
            value: _vm.machine,
            filterable: true
          },
          on: { onSelected: _vm.onMachineNameWasSelected }
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