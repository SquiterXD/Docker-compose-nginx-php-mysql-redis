(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_inv_disbursement_fuel_SearchCarLicense_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    name: {
      type: String,
      "default": 'car_license_plate'
    },
    "default": {
      type: String
    }
  },
  data: function data() {
    return {
      carInfos: [],
      car_license_plate: this["default"],
      loadingInput: {
        carInfos: false
      }
    };
  },
  created: function created() {
    this.getMasterData();
  },
  methods: {
    getMasterData: function getMasterData() {
      this.getCarInfos(this.car_license_plate);
    },
    getCarInfos: function getCarInfos(query) {
      var _this = this;

      this.loadingInput.carInfos = true;
      axios.get("/inv/ajax/car_info", {
        params: {
          text: query,
          organization_code: "A32"
        }
      }).then(function (response) {
        _this.carInfos = response.data;
      })["catch"](function (err) {
        console.log("error get car info");
      }).then(function () {
        _this.loadingInput.carInfos = false;
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchCarLicense_vue_vue_type_template_id_16a7538e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchCarLicense.vue?vue&type=template&id=16a7538e& */ "./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=template&id=16a7538e&");
/* harmony import */ var _SearchCarLicense_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchCarLicense.vue?vue&type=script&lang=js& */ "./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchCarLicense_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchCarLicense_vue_vue_type_template_id_16a7538e___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchCarLicense_vue_vue_type_template_id_16a7538e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCarLicense_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchCarLicense.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCarLicense_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=template&id=16a7538e&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=template&id=16a7538e& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCarLicense_vue_vue_type_template_id_16a7538e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCarLicense_vue_vue_type_template_id_16a7538e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchCarLicense_vue_vue_type_template_id_16a7538e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchCarLicense.vue?vue&type=template&id=16a7538e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=template&id=16a7538e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=template&id=16a7538e&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/SearchCarLicense.vue?vue&type=template&id=16a7538e& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    [
      _c(
        "el-select",
        {
          staticStyle: { width: "100%" },
          attrs: {
            filterable: "",
            remote: "",
            debounce: 2000,
            "remote-method": _vm.getCarInfos,
            placeholder: "ทะเบียนรถ",
            loading: _vm.loadingInput.carInfos
          },
          model: {
            value: _vm.car_license_plate,
            callback: function($$v) {
              _vm.car_license_plate = $$v
            },
            expression: "car_license_plate"
          }
        },
        _vm._l(_vm.carInfos, function(item, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: item.car_license_plate,
              value: item.car_license_plate
            }
          })
        }),
        1
      ),
      _vm._v(" "),
      _c("input", {
        attrs: { type: "hidden", name: _vm.name },
        domProps: { value: _vm.car_license_plate }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);