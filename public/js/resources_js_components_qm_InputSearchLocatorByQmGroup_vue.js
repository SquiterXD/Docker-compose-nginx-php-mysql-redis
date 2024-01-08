(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_InputSearchLocatorByQmGroup_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["qmGroups", "locators", "qmGroupFromValue", "qmGroupToValue", "locatorValue"],
  mounted: function mounted() {},
  data: function data() {
    return {
      qmGroupFrom: this.qmGroupFromValue,
      // qmGroupTo: this.qmGroupToValue,
      locator: this.locatorValue,
      qmGroupOptions: this.qmGroups,
      locatorOptions: this.qmGroupFromValue || this.qmGroupToValue ? this.getLocatorOptions(this.qmGroupFromValue, this.qmGroupToValue) : []
    };
  },
  methods: {
    getLocatorOptions: function getLocatorOptions(qmGroupFrom) {
      var locatorQmGroupFromOptions = qmGroupFrom ? this.locators.filter(function (item) {
        return item.qm_group == qmGroupFrom;
      }) : [];

      var resultOptions = _toConsumableArray(locatorQmGroupFromOptions).filter(function (value, index, self) {
        return index === self.findIndex(function (item) {
          return item.inventory_location_id === value.inventory_location_id;
        });
      }).sort(function (a, b) {
        return a.location_desc - b.location_desc;
      });

      return resultOptions;
    },
    onQmGroupFromWasSelected: function onQmGroupFromWasSelected(value) {
      var _this = this;

      this.qmGroupFrom = value;
      this.locatorOptions = this.getLocatorOptions(value);

      if (!this.locator || !this.locatorOptions.find(function (item) {
        return item.inventory_location_id == _this.locator;
      })) {
        this.locator = null;
      }
    } // getLocatorOptions(qmGroupFrom, qmGroupTo) {
    //     console.log(qmGroupFrom, qmGroupTo);
    //     const locatorQmGroupFromOptions = qmGroupFrom ? this.locators.filter(item => item.qm_group == qmGroupFrom) : [];
    //     const locatorQmGroupToOptions = qmGroupTo ? this.locators.filter(item => item.qm_group == qmGroupTo) : [];
    //     const resultOptions = [
    //         ...locatorQmGroupFromOptions,
    //         ...locatorQmGroupToOptions,
    //     ].filter((value, index, self) => {
    //         return index === self.findIndex(item => item.inventory_location_id === value.inventory_location_id);
    //     }).sort((a, b) => {
    //         return a.location_desc - b.location_desc;
    //     });
    //     return resultOptions;
    // },
    // onQmGroupFromWasSelected(value) {
    //     this.qmGroupFrom = value;
    //     this.locatorOptions = this.getLocatorOptions(value, this.qmGroupTo);
    //     if(!this.locator || !this.locatorOptions.find(item => item.inventory_location_id == this.locator)){
    //         this.locator = null;
    //     }
    // },
    // onQmGroupToWasSelected(value) {
    //     this.qmGroupTo = value;
    //     this.locatorOptions = this.getLocatorOptions(this.qmGroupFrom, value);
    //     if(!this.locator || !this.locatorOptions.find(item => item.inventory_location_id == this.locator)){
    //         this.locator = null;
    //     }
    // },
    // onLocatorWasSelected(value) {
    //     this.locator = value;
    // }

  }
});

/***/ }),

/***/ "./resources/js/components/qm/InputSearchLocatorByQmGroup.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/qm/InputSearchLocatorByQmGroup.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputSearchLocatorByQmGroup_vue_vue_type_template_id_a12f1ec0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0& */ "./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0&");
/* harmony import */ var _InputSearchLocatorByQmGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputSearchLocatorByQmGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputSearchLocatorByQmGroup_vue_vue_type_template_id_a12f1ec0___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputSearchLocatorByQmGroup_vue_vue_type_template_id_a12f1ec0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/InputSearchLocatorByQmGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchLocatorByQmGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchLocatorByQmGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchLocatorByQmGroup_vue_vue_type_template_id_a12f1ec0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchLocatorByQmGroup_vue_vue_type_template_id_a12f1ec0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputSearchLocatorByQmGroup_vue_vue_type_template_id_a12f1ec0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputSearchLocatorByQmGroup.vue?vue&type=template&id=a12f1ec0& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-8" },
        [
          _c("qm-el-select", {
            attrs: {
              name: "qm_group_from",
              id: "input_qm_group_from",
              "option-key": "qm_group_value",
              "option-value": "qm_group_value",
              "option-label": "qm_group_label",
              "select-options": _vm.qmGroupOptions,
              value: _vm.qmGroupFrom,
              clearable: true,
              filterable: true
            },
            on: { onSelected: _vm.onQmGroupFromWasSelected }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row form-group" }, [
      _vm._m(1),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-8" },
        [
          _c("qm-el-select", {
            attrs: {
              name: "locator_id",
              id: "input_locator_id",
              "option-key": "inventory_location_id",
              "option-value": "inventory_location_id",
              "option-label": "location_full_desc",
              "select-options": _vm.locatorOptions,
              value: _vm.locator,
              clearable: true,
              filterable: true
            }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-md-4 col-form-label" }, [
      _vm._v("กลุ่มงาน "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-md-4 col-form-label" }, [
      _vm._v("จุดตรวจสอบ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);