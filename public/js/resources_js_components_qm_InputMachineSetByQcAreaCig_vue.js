(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_InputMachineSetByQcAreaCig_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
  props: ["qcAreas", "machineSets", "qcAreaValue", "machineSetValue"],
  data: function data() {
    return {
      qcArea: this.qcAreaValue,
      machineSet: this.machineSetValue,
      qcAreaOptions: this.qcAreas,
      machineSetOptions: this.getMachineOptionsInQcArea(this.qcAreaValue)
    };
  },
  methods: {
    getMachineOptionsInQcArea: function getMachineOptionsInQcArea(qcAreaValue) {
      var options = [];

      if (qcAreaValue == "ALL") {
        options = this.machineSets;
      } else {
        options = [{
          "machine_set_value": "ALL",
          "machine_set_label": "เลือกทั้งหมด"
        }].concat(_toConsumableArray(this.machineSets.filter(function (item) {
          return item.qc_area_cig == qcAreaValue;
        })));
      }

      return options;
    },
    onQcAreaWasSelected: function onQcAreaWasSelected(value) {
      this.machineSetOptions = this.getMachineOptionsInQcArea(value);
      this.qcArea = value;
      this.machineSet = "ALL"; // default value
    },
    onMachineSetWasSelected: function onMachineSetWasSelected(value) {
      var _this = this;

      this.machineSet = value;

      if (value && value != "ALL") {
        var foundMachineSet = this.machineSets.find(function (item) {
          return item.machine_set_value == _this.machineSet;
        });
        this.qcArea = foundMachineSet ? foundMachineSet.qc_area_cig : "ALL";
        this.machineSetOptions = this.getMachineOptionsInQcArea(this.qcArea);
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/InputMachineSetByQcAreaCig.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/qm/InputMachineSetByQcAreaCig.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputMachineSetByQcAreaCig_vue_vue_type_template_id_3c667c44___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44& */ "./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44&");
/* harmony import */ var _InputMachineSetByQcAreaCig_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputMachineSetByQcAreaCig_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputMachineSetByQcAreaCig_vue_vue_type_template_id_3c667c44___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputMachineSetByQcAreaCig_vue_vue_type_template_id_3c667c44___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/InputMachineSetByQcAreaCig.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineSetByQcAreaCig_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineSetByQcAreaCig_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineSetByQcAreaCig_vue_vue_type_template_id_3c667c44___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineSetByQcAreaCig_vue_vue_type_template_id_3c667c44___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputMachineSetByQcAreaCig_vue_vue_type_template_id_3c667c44___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputMachineSetByQcAreaCig.vue?vue&type=template&id=3c667c44& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row form-group" }, [
    _c(
      "div",
      { staticClass: "col-md-6" },
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
      { staticClass: "col-md-6" },
      [
        _c("label", { staticClass: "required" }, [
          _vm._v(" เลขชุดเครื่องจักร ")
        ]),
        _vm._v(" "),
        _c("qm-el-select", {
          attrs: {
            name: "machine_set",
            id: "input_machine_set",
            placeholder: "เลือกเลขชุดเครื่องจักร",
            "option-key": "qc_area_machine_set",
            "option-value": "machine_set_value",
            "option-label": "machine_set_label",
            "select-options": _vm.machineSetOptions,
            value: _vm.machineSet,
            filterable: true
          },
          on: { onSelected: _vm.onMachineSetWasSelected }
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