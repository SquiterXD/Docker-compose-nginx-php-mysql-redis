(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_vehicle_fetch_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-settings-vehicle-fetch',
  props: ['btnTrans', 'urlCreate'],
  methods: {
    clickFetch: function clickFetch() {
      console.log('clickFetch clickFetch');
      axios.get("/ir/settings/vehicle/get_fa_location").then(function (_ref) {
        var data = _ref.data;
        console.log(data);

        if (data.status === 'S') {
          swal({
            title: "Success",
            text: 'ดึงข้อมูลสำเร็จ',
            type: "success",
            showCancelButton: false,
            showConfirmButton: true
          }, function (confirm) {
            if (confirm) {
              window.location.href = '/ir/settings/vehicle';
            }
          });
        } else {
          swal("Error", data.msg, "error");
        }
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/settings/vehicle/fetch.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/ir/settings/vehicle/fetch.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _fetch_vue_vue_type_template_id_dacaced4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./fetch.vue?vue&type=template&id=dacaced4& */ "./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=template&id=dacaced4&");
/* harmony import */ var _fetch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./fetch.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _fetch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _fetch_vue_vue_type_template_id_dacaced4___WEBPACK_IMPORTED_MODULE_0__.render,
  _fetch_vue_vue_type_template_id_dacaced4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/vehicle/fetch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_fetch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./fetch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_fetch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=template&id=dacaced4&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=template&id=dacaced4& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_fetch_vue_vue_type_template_id_dacaced4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_fetch_vue_vue_type_template_id_dacaced4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_fetch_vue_vue_type_template_id_dacaced4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./fetch.vue?vue&type=template&id=dacaced4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=template&id=dacaced4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=template&id=dacaced4&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/vehicle/fetch.vue?vue&type=template&id=dacaced4& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
      "a",
      {
        class: _vm.btnTrans.create.class + " btn-lg tw-w-25",
        attrs: { href: this.urlCreate }
      },
      [
        _c("i", { class: _vm.btnTrans.create.icon }),
        _vm._v(" " + _vm._s(_vm.btnTrans.create.text))
      ]
    ),
    _vm._v(" "),
    _c(
      "button",
      {
        staticClass: "btn btn-success btn-lg tw-w-25",
        attrs: { type: "button" },
        on: {
          click: function($event) {
            return _vm.clickFetch()
          }
        }
      },
      [
        _c("i", { class: _vm.btnTrans.pull.icon }),
        _vm._v(" " + _vm._s(_vm.btnTrans.pull.text) + "\n    ")
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);