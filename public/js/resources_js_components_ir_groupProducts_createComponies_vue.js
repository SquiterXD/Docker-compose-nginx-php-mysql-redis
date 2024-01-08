(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_groupProducts_createComponies_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=script&lang=js& ***!
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
  props: ["policySetHeaders", "accountsMappings", "assetGroups", 'oldInput'],
  data: function data() {
    return {
      policySelected: this.oldInput.length != 0 ? parseInt(this.oldInput.policy_set_header_id) : '',
      assetGroupsSelected: this.oldInput.length != 0 ? this.oldInput.asset_group_code : '',
      activeFlag: true,
      accountSelected: this.oldInput.length != 0 ? isNaN(parseInt(this.oldInput.account_id)) ? '' : parseInt(this.oldInput.account_id) : '',
      description: this.oldInput.length != 0 ? this.oldInput.description : '',
      accountCombine: ''
    };
  },
  computed: {},
  mounted: function mounted() {
    if (this.oldInput.length != 0) {
      this.getAccountCombine();
    }
  },
  methods: {
    getAccountCombine: function getAccountCombine() {
      var _this = this;

      var accounts = this.accountsMappings.find(function (item) {
        return _this.accountSelected == item.account_id;
      });
      this.accountCombine = accounts.account_combine;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/createComponies.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/createComponies.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _createComponies_vue_vue_type_template_id_f67aa6b4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createComponies.vue?vue&type=template&id=f67aa6b4& */ "./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=template&id=f67aa6b4&");
/* harmony import */ var _createComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./createComponies.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _createComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _createComponies_vue_vue_type_template_id_f67aa6b4___WEBPACK_IMPORTED_MODULE_0__.render,
  _createComponies_vue_vue_type_template_id_f67aa6b4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/groupProducts/createComponies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./createComponies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=template&id=f67aa6b4&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=template&id=f67aa6b4& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponies_vue_vue_type_template_id_f67aa6b4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponies_vue_vue_type_template_id_f67aa6b4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponies_vue_vue_type_template_id_f67aa6b4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./createComponies.vue?vue&type=template&id=f67aa6b4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=template&id=f67aa6b4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=template&id=f67aa6b4&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/createComponies.vue?vue&type=template&id=f67aa6b4& ***!
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
  return _c("div", [
    _c(
      "div",
      {
        staticClass:
          "row col-lg-10 col-md-6 align-items-center justify-content-center my-3",
        staticStyle: { "margin-left": "80px", "margin-right": "80px" }
      },
      [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-7 col-md-7 w-100" },
          [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.policySelected,
                  expression: "policySelected"
                }
              ],
              attrs: { type: "hidden", name: "policy_set_header_id" },
              domProps: { value: _vm.policySelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.policySelected = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  clearable: "",
                  filterable: "",
                  placeholder: "โปรดเลือกกรมธรรม์"
                },
                model: {
                  value: _vm.policySelected,
                  callback: function($$v) {
                    _vm.policySelected = $$v
                  },
                  expression: "policySelected"
                }
              },
              _vm._l(_vm.policySetHeaders, function(policySetHeader) {
                return _c("el-option", {
                  key: policySetHeader.policy_set_header_id,
                  attrs: {
                    label:
                      policySetHeader.policy_set_number +
                      " : " +
                      policySetHeader.policy_set_description,
                    value: policySetHeader.policy_set_header_id
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "row col-lg-10 col-md-6 align-items-center justify-content-center my-3",
        staticStyle: { "margin-left": "80px", "margin-right": "80px" }
      },
      [
        _vm._m(1),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-7 col-md-7 w-100" },
          [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.assetGroupsSelected,
                  expression: "assetGroupsSelected"
                }
              ],
              attrs: { type: "hidden", name: "asset_group_code" },
              domProps: { value: _vm.assetGroupsSelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.assetGroupsSelected = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  clearable: "",
                  filterable: "",
                  placeholder: "โปรดเลือกกลุ่มของทรัพย์สิน"
                },
                model: {
                  value: _vm.assetGroupsSelected,
                  callback: function($$v) {
                    _vm.assetGroupsSelected = $$v
                  },
                  expression: "assetGroupsSelected"
                }
              },
              _vm._l(_vm.assetGroups, function(assetGroup) {
                return _c("el-option", {
                  key: assetGroup.value,
                  attrs: {
                    label: assetGroup.meaning + " : " + assetGroup.description,
                    value: assetGroup.value
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "row col-lg-10 col-md-6 align-items-center justify-content-center my-3",
        staticStyle: { "margin-left": "80px", "margin-right": "80px" }
      },
      [
        _vm._m(2),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-7 col-md-7 w-100" },
          [
            _c("el-input", {
              attrs: { placeholder: "โปรดกรอกรายการ", name: "description" },
              model: {
                value: _vm.description,
                callback: function($$v) {
                  _vm.description = $$v
                },
                expression: "description"
              }
            })
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "row col-lg-10 col-md-6 align-items-center justify-content-center my-3",
        staticStyle: { "margin-left": "80px", "margin-right": "80px" }
      },
      [
        _vm._m(3),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-7 col-md-7 w-100" },
          [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.accountSelected,
                  expression: "accountSelected"
                }
              ],
              attrs: { type: "hidden", name: "account_id" },
              domProps: { value: _vm.accountSelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.accountSelected = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  clearable: "",
                  filterable: "",
                  placeholder: "โปรดเลือก"
                },
                on: {
                  change: function($event) {
                    return _vm.getAccountCombine()
                  }
                },
                model: {
                  value: _vm.accountSelected,
                  callback: function($$v) {
                    _vm.accountSelected = $$v
                  },
                  expression: "accountSelected"
                }
              },
              _vm._l(_vm.accountsMappings, function(accountsMapping) {
                return _c("el-option", {
                  key: accountsMapping.account_id,
                  attrs: {
                    label:
                      accountsMapping.account_code +
                      " : " +
                      accountsMapping.description,
                    value: accountsMapping.account_id
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "row col-lg-10 col-md-6 align-items-center justify-content-center my-3",
        staticStyle: { "margin-left": "80px", "margin-right": "80px" }
      },
      [
        _vm._m(4),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-7 col-md-7 w-100" },
          [
            _c("el-input", {
              staticClass: "w-100",
              attrs: { placeholder: "รหัสบัญชี", disabled: true },
              model: {
                value: _vm.accountCombine,
                callback: function($$v) {
                  _vm.accountCombine = $$v
                },
                expression: "accountCombine"
              }
            })
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "row col-lg-10 col-md-6 align-items-center justify-content-center my-3",
        staticStyle: { "margin-left": "80px", "margin-right": "80px" }
      },
      [
        _vm._m(5),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-lg-7 col-md-7 w-100" },
          [
            _c("input", {
              attrs: { type: "hidden", name: "active_flag" },
              domProps: { value: _vm.activeFlag }
            }),
            _vm._v(" "),
            _c("el-checkbox", {
              staticClass: "w-100",
              attrs: { size: "medium" },
              model: {
                value: _vm.activeFlag,
                callback: function($$v) {
                  _vm.activeFlag = $$v
                },
                expression: "activeFlag"
              }
            })
          ],
          1
        )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-lg-3 col-md-6 col-form-label text-right" },
      [
        _c("strong", [_vm._v(" กรมธรรม์ชุดที่ (Policy No.) ")]),
        _vm._v(" "),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-lg-3 col-md-6 col-form-label text-right" },
      [
        _c("strong", [_vm._v(" กลุ่มของทรัพย์สิน ")]),
        _vm._v(" "),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-lg-3 col-md-6 col-form-label text-right" },
      [
        _c("strong", [_vm._v(" รายการ ")]),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-lg-3 col-md-6 col-form-label text-right" },
      [
        _c("strong", [_vm._v(" ประเภทค่าใช้จ่าย ")]),
        _vm._v(" "),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-lg-3 col-md-6 col-form-label text-right" },
      [_c("strong", [_vm._v(" รหัสบัญชี ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-lg-3 col-md-6 col-form-label text-right" },
      [
        _c("strong", [_vm._v(" Active ")]),
        _vm._v(" "),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ]
    )
  }
]
render._withStripped = true



/***/ })

}]);