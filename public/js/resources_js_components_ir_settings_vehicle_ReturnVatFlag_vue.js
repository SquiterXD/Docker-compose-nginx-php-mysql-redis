(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_vehicle_ReturnVatFlag_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
  props: ['vehicle'],
  data: function data() {
    return {
      active_flag: this.vehicle.active_flag
    };
  },
  methods: {
    changeCheckedActive: function changeCheckedActive(dataRow) {
      var data = _objectSpread(_objectSpread({}, dataRow), {}, {
        return_vat_flag: dataRow.return_vat_flag ? 'Y' : 'N',
        active_flag: dataRow.active_flag ? 'Y' : 'N',
        program_code: 'IRM0007'
      });

      axios.put("/ir/ajax/vehicles/active-flag", {
        data: data
      }).then(function (_ref) {
        var data = _ref.data;
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          timer: 3000,
          showConfirmButton: false,
          closeOnConfirm: false
        });
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ReturnVatFlag_vue_vue_type_template_id_0e20e321___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ReturnVatFlag.vue?vue&type=template&id=0e20e321& */ "./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=template&id=0e20e321&");
/* harmony import */ var _ReturnVatFlag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ReturnVatFlag.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ReturnVatFlag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ReturnVatFlag_vue_vue_type_template_id_0e20e321___WEBPACK_IMPORTED_MODULE_0__.render,
  _ReturnVatFlag_vue_vue_type_template_id_0e20e321___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ReturnVatFlag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ReturnVatFlag.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ReturnVatFlag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=template&id=0e20e321&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=template&id=0e20e321& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReturnVatFlag_vue_vue_type_template_id_0e20e321___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReturnVatFlag_vue_vue_type_template_id_0e20e321___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReturnVatFlag_vue_vue_type_template_id_0e20e321___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ReturnVatFlag.vue?vue&type=template&id=0e20e321& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=template&id=0e20e321&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=template&id=0e20e321&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/ReturnVatFlag.vue?vue&type=template&id=0e20e321& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
    _c(
      "div",
      { staticClass: "form-check", staticStyle: { position: "inherit" } },
      [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.vehicle.active_flag,
              expression: "vehicle.active_flag"
            }
          ],
          staticClass: "form-check-input",
          staticStyle: { position: "inherit" },
          attrs: {
            type: "checkbox",
            disabled: _vm.vehicle.reason != "" || _vm.vehicle.sold_flag != ""
          },
          domProps: {
            checked: Array.isArray(_vm.vehicle.active_flag)
              ? _vm._i(_vm.vehicle.active_flag, null) > -1
              : _vm.vehicle.active_flag
          },
          on: {
            change: [
              function($event) {
                var $$a = _vm.vehicle.active_flag,
                  $$el = $event.target,
                  $$c = $$el.checked ? true : false
                if (Array.isArray($$a)) {
                  var $$v = null,
                    $$i = _vm._i($$a, $$v)
                  if ($$el.checked) {
                    $$i < 0 &&
                      _vm.$set(_vm.vehicle, "active_flag", $$a.concat([$$v]))
                  } else {
                    $$i > -1 &&
                      _vm.$set(
                        _vm.vehicle,
                        "active_flag",
                        $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                      )
                  }
                } else {
                  _vm.$set(_vm.vehicle, "active_flag", $$c)
                }
              },
              function($event) {
                return _vm.changeCheckedActive(_vm.vehicle)
              }
            ]
          }
        })
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);