(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_product-inv_searchProductComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["policySetHeaders", "assetGroups", "departments", "subInventories", "subGroups", "groupProducts", 'search'],
  data: function data() {
    return {
      options: [{
        value: 'Y',
        label: 'Active'
      }, {
        value: 'N',
        label: 'Inactive'
      }],
      subGroupLists: [],
      policySelect: this.search ? isNaN(parseInt(this.search.policy_set_header_id)) ? '' : this.search.policy_set_header_id : '',
      assetGroupSelect: this.search ? this.search.asset_group : '',
      statusSelect: this.search ? this.search.status : '',
      departmentSelect: this.search ? this.search.department_code : '',
      subGroupSelect: this.search ? this.search.sub_group_code : '',
      groupProductsSelect: this.search ? isNaN(parseInt(this.search.group_products)) ? '' : parseInt(this.search.group_products) : '',
      subinventorySelect: this.search ? this.search.subinventory_code : ''
    };
  },
  mounted: function mounted() {
    this.getSubGroup();
  },
  computed: {
    getSubGroupOrderBy: function getSubGroupOrderBy() {
      return _.orderBy(this.subGroupLists, 'sub_group_code');
    }
  },
  methods: {
    getSubGroup: function getSubGroup() {
      var _this = this;

      this.subGroupLists = this.subGroups.filter(function (subGroups) {
        return subGroups.policy_set_header_id == _this.policySelect;
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/product-inv/searchProductComponent.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/searchProductComponent.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _searchProductComponent_vue_vue_type_template_id_3e9cf17d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./searchProductComponent.vue?vue&type=template&id=3e9cf17d& */ "./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=template&id=3e9cf17d&");
/* harmony import */ var _searchProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./searchProductComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _searchProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _searchProductComponent_vue_vue_type_template_id_3e9cf17d___WEBPACK_IMPORTED_MODULE_0__.render,
  _searchProductComponent_vue_vue_type_template_id_3e9cf17d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/product-inv/searchProductComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_searchProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./searchProductComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_searchProductComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=template&id=3e9cf17d&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=template&id=3e9cf17d& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_searchProductComponent_vue_vue_type_template_id_3e9cf17d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_searchProductComponent_vue_vue_type_template_id_3e9cf17d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_searchProductComponent_vue_vue_type_template_id_3e9cf17d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./searchProductComponent.vue?vue&type=template&id=3e9cf17d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=template&id=3e9cf17d&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=template&id=3e9cf17d&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/searchProductComponent.vue?vue&type=template&id=3e9cf17d& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    ระบุชุดกรมธรรม์\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.policySelect,
                expression: "policySelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[policy_set_header_id]",
              autocomplete: "off"
            },
            domProps: { value: _vm.policySelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.policySelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                placeholder: "ระบุชุดกรมธรรม์"
              },
              on: {
                change: function($event) {
                  return _vm.getSubGroup(_vm.policySelect)
                }
              },
              model: {
                value: _vm.policySelect,
                callback: function($$v) {
                  _vm.policySelect = $$v
                },
                expression: "policySelect"
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
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    ระบุกลุ่มของทรัพย์สิน\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.assetGroupSelect,
                expression: "assetGroupSelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[asset_group]",
              autocomplete: "off"
            },
            domProps: { value: _vm.assetGroupSelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.assetGroupSelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                placeholder: "ระบุกลุ่มของทรัพย์สิน"
              },
              model: {
                value: _vm.assetGroupSelect,
                callback: function($$v) {
                  _vm.assetGroupSelect = $$v
                },
                expression: "assetGroupSelect"
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
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    ระบุรายการ\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.groupProductsSelect,
                expression: "groupProductsSelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[group_products]",
              autocomplete: "off"
            },
            domProps: { value: _vm.groupProductsSelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.groupProductsSelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                placeholder: "ระบุรายการ"
              },
              model: {
                value: _vm.groupProductsSelect,
                callback: function($$v) {
                  _vm.groupProductsSelect = $$v
                },
                expression: "groupProductsSelect"
              }
            },
            _vm._l(_vm.groupProducts, function(groupProduct) {
              return _c("el-option", {
                key: groupProduct.group_product_id,
                attrs: {
                  label: groupProduct.description,
                  value: groupProduct.group_product_id
                }
              })
            }),
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    สถานะ\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.statusSelect,
                expression: "statusSelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[status]",
              autocomplete: "off"
            },
            domProps: { value: _vm.statusSelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.statusSelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                placeholder: "สถานะ"
              },
              model: {
                value: _vm.statusSelect,
                callback: function($$v) {
                  _vm.statusSelect = $$v
                },
                expression: "statusSelect"
              }
            },
            _vm._l(_vm.options, function(option) {
              return _c("el-option", {
                key: option.value,
                attrs: { label: option.label, value: option.value }
              })
            }),
            1
          )
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row", staticStyle: { "padding-top": "15px" } }, [
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    ระบุรหัสหน่วยงาน\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.departmentSelect,
                expression: "departmentSelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[department_code]",
              autocomplete: "off"
            },
            domProps: { value: _vm.departmentSelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.departmentSelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                placeholder: "ระบุรหัสหน่วยงาน"
              },
              model: {
                value: _vm.departmentSelect,
                callback: function($$v) {
                  _vm.departmentSelect = $$v
                },
                expression: "departmentSelect"
              }
            },
            _vm._l(_vm.departments, function(department) {
              return _c("el-option", {
                key: department.department_code,
                attrs: {
                  label: department.meaning + " : " + department.description,
                  value: department.department_code
                }
              })
            }),
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    ระบุรหัสคลังสินค้า\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.subinventorySelect,
                expression: "subinventorySelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[subinventory_code]",
              autocomplete: "off"
            },
            domProps: { value: _vm.subinventorySelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.subinventorySelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                placeholder: "ระบุรหัสคลังสินค้า"
              },
              model: {
                value: _vm.subinventorySelect,
                callback: function($$v) {
                  _vm.subinventorySelect = $$v
                },
                expression: "subinventorySelect"
              }
            },
            _vm._l(_vm.subInventories, function(subInventory, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label:
                    subInventory.subinventory_code +
                    " : " +
                    subInventory.subinventory_desc,
                  value:
                    subInventory.subinventory_code +
                    "," +
                    subInventory.subinventory_desc
                }
              })
            }),
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-sm-3", staticStyle: { "text-align": "left" } },
        [
          _c("label", { staticClass: "control-label" }, [
            _vm._v("\n                    ระบุกลุ่มสินค้าย่อย\n            ")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.subGroupSelect,
                expression: "subGroupSelect"
              }
            ],
            attrs: {
              type: "hidden",
              name: "search[sub_group_code]",
              autocomplete: "off"
            },
            domProps: { value: _vm.subGroupSelect },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.subGroupSelect = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                filterable: "",
                remote: "",
                clearable: "",
                "reserve-keyword": "",
                disabled: !_vm.getSubGroupOrderBy.length,
                placeholder: "ระบุกลุ่มสินค้าย่อย"
              },
              model: {
                value: _vm.subGroupSelect,
                callback: function($$v) {
                  _vm.subGroupSelect = $$v
                },
                expression: "subGroupSelect"
              }
            },
            _vm._l(_vm.getSubGroupOrderBy, function(subGroup, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label:
                    subGroup.sub_group_code +
                    " : " +
                    subGroup.sub_group_description,
                  value:
                    subGroup.sub_group_code +
                    " : " +
                    subGroup.sub_group_description
                }
              })
            }),
            1
          )
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