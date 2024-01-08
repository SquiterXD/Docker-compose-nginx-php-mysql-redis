(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_groupProducts_editComponies_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
  props: ["policySetHeaders", "accountsMappings", "assetGroups", "groupProducts", "oldInput"],
  data: function data() {
    return {
      policySetHeaderEditSelected: this.groupProducts ? isNaN(parseInt(this.groupProducts.policy_set_header_id)) ? '' : parseInt(this.groupProducts.policy_set_header_id) : '',
      groupProductEdit: this.groupProducts ? this.groupProducts.group_product_id : '',
      assetGroupsEditSelected: this.groupProducts ? this.groupProducts.asset_group_code : '',
      descriptionEdit: this.groupProducts ? this.groupProducts.description : '',
      accountEditSelected: this.groupProducts ? parseInt(this.groupProducts.account_id) : '',
      accountCombine: this.groupProducts.mapping_acc ? this.groupProducts.mapping_acc.account_combine : '',
      activeFlagEdit: this.groupProducts ? this.groupProducts.active_flag === 'Y' ? true : false : '',
      policySetHeaderChecker: this.groupProducts ? isNaN(parseInt(this.groupProducts.policy_set_header_id)) ? '' : parseInt(this.groupProducts.policy_set_header_id) : '',
      assetGroupsChecker: this.groupProducts ? this.groupProducts.asset_group_code : '',
      descriptionChecker: this.groupProducts ? this.groupProducts.description : '',
      accountChecker: this.groupProducts ? parseInt(this.groupProducts.account_id) : '',
      activeFlagChecker: this.groupProducts ? this.groupProducts.active_flag === 'Y' ? true : false : ''
    };
  },
  computed: {},
  mounted: function mounted() {// console.log(this.policySetHeaders)
  },
  methods: {
    getAccountCombine: function getAccountCombine() {
      var _this = this;

      var accounts = this.accountsMappings.find(function (item) {
        return _this.accountEditSelected == item.account_id;
      });
      this.accountCombine = accounts.account_combine;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/editComponies.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/editComponies.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _editComponies_vue_vue_type_template_id_eb7e3ad0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editComponies.vue?vue&type=template&id=eb7e3ad0& */ "./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=template&id=eb7e3ad0&");
/* harmony import */ var _editComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editComponies.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _editComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _editComponies_vue_vue_type_template_id_eb7e3ad0___WEBPACK_IMPORTED_MODULE_0__.render,
  _editComponies_vue_vue_type_template_id_eb7e3ad0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/groupProducts/editComponies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./editComponies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=template&id=eb7e3ad0&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=template&id=eb7e3ad0& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponies_vue_vue_type_template_id_eb7e3ad0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponies_vue_vue_type_template_id_eb7e3ad0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponies_vue_vue_type_template_id_eb7e3ad0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./editComponies.vue?vue&type=template&id=eb7e3ad0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=template&id=eb7e3ad0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=template&id=eb7e3ad0&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/editComponies.vue?vue&type=template&id=eb7e3ad0& ***!
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
  return _c("div", [
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.groupProductEdit,
          expression: "groupProductEdit"
        }
      ],
      attrs: { type: "hidden", name: "group_product_id" },
      domProps: { value: _vm.groupProductEdit },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.groupProductEdit = $event.target.value
        }
      }
    }),
    _vm._v(" "),
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
                  value: _vm.policySetHeaderEditSelected,
                  expression: "policySetHeaderEditSelected"
                }
              ],
              attrs: { type: "hidden", name: "policy_set_header_id" },
              domProps: { value: _vm.policySetHeaderEditSelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.policySetHeaderEditSelected = $event.target.value
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
                  placeholder: "โปรดเลือกกลุ่มของทรัพย์สิน",
                  disabled: true
                },
                model: {
                  value: _vm.policySetHeaderEditSelected,
                  callback: function($$v) {
                    _vm.policySetHeaderEditSelected = $$v
                  },
                  expression: "policySetHeaderEditSelected"
                }
              },
              _vm._l(_vm.policySetHeaders, function(policy) {
                return _c("el-option", {
                  key: policy.policy_set_header_id,
                  attrs: {
                    label:
                      policy.policy_set_number +
                      " : " +
                      policy.policy_set_description,
                    value: policy.policy_set_header_id
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
                  value: _vm.assetGroupsEditSelected,
                  expression: "assetGroupsEditSelected"
                }
              ],
              attrs: { type: "hidden", name: "asset_group_code" },
              domProps: { value: _vm.assetGroupsEditSelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.assetGroupsEditSelected = $event.target.value
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
                  value: _vm.assetGroupsEditSelected,
                  callback: function($$v) {
                    _vm.assetGroupsEditSelected = $$v
                  },
                  expression: "assetGroupsEditSelected"
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
                value: _vm.descriptionEdit,
                callback: function($$v) {
                  _vm.descriptionEdit = $$v
                },
                expression: "descriptionEdit"
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
                  value: _vm.accountEditSelected,
                  expression: "accountEditSelected"
                }
              ],
              attrs: { type: "hidden", name: "account_id" },
              domProps: { value: _vm.accountEditSelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.accountEditSelected = $event.target.value
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
                  placeholder: "โปรดเลือกประเภทค่าใช้จ่าย"
                },
                on: {
                  change: function($event) {
                    return _vm.getAccountCombine()
                  }
                },
                model: {
                  value: _vm.accountEditSelected,
                  callback: function($$v) {
                    _vm.accountEditSelected = $$v
                  },
                  expression: "accountEditSelected"
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
              domProps: { value: _vm.activeFlagEdit }
            }),
            _vm._v(" "),
            _c("el-checkbox", {
              staticClass: "w-100",
              attrs: { size: "medium" },
              model: {
                value: _vm.activeFlagEdit,
                callback: function($$v) {
                  _vm.activeFlagEdit = $$v
                },
                expression: "activeFlagEdit"
              }
            })
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.policySetHeaderChecker,
          expression: "policySetHeaderChecker"
        }
      ],
      attrs: { type: "hidden", name: "old_checker_policy_set_header_id" },
      domProps: { value: _vm.policySetHeaderChecker },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.policySetHeaderChecker = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.assetGroupsChecker,
          expression: "assetGroupsChecker"
        }
      ],
      attrs: { type: "hidden", name: "old_checker_asset_group_code" },
      domProps: { value: _vm.assetGroupsChecker },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.assetGroupsChecker = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.descriptionChecker,
          expression: "descriptionChecker"
        }
      ],
      attrs: { type: "hidden", name: "old_checker_description" },
      domProps: { value: _vm.descriptionChecker },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.descriptionChecker = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.accountChecker,
          expression: "accountChecker"
        }
      ],
      attrs: { type: "hidden", name: "old_checker_account_id" },
      domProps: { value: _vm.accountChecker },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.accountChecker = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.activeFlagChecker,
          expression: "activeFlagChecker"
        }
      ],
      attrs: { type: "hidden", name: "old_checker_active_flag" },
      domProps: { value: _vm.activeFlagChecker },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.activeFlagChecker = $event.target.value
        }
      }
    })
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
      [
        _c("strong", [_vm._v(" รหัสบัญชี ")]),
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