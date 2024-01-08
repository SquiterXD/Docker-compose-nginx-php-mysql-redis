(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_print-item-setup_EditComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["printItemSetup", "itemNumberList", "sizeList", "printTypeList"],
  mounted: function mounted() {},
  data: function data() {
    return {
      enabledFlag: this.printItemSetup.enable_flag == 'Y' ? true : false,
      itemInventory: this.printItemSetup ? this.printItemSetup.inventory_item_id : '',
      tobaccoSize: this.printItemSetup ? this.printItemSetup.tobacco_size : '',
      brand: this.printItemSetup ? this.printItemSetup.brand : '',
      product: this.printItemSetup ? this.printItemSetup.product : '',
      pmPrintSetId: this.printItemSetup.pm_print_set_id,
      printType: this.printItemSetup.print_type ? this.printItemSetup.print_type : ''
    };
  },
  methods: {}
});

/***/ }),

/***/ "./resources/js/components/pm/print-item-setup/EditComponent.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/pm/print-item-setup/EditComponent.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EditComponent_vue_vue_type_template_id_0215345e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=template&id=0215345e& */ "./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=template&id=0215345e&");
/* harmony import */ var _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EditComponent_vue_vue_type_template_id_0215345e___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditComponent_vue_vue_type_template_id_0215345e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/print-item-setup/EditComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=template&id=0215345e&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=template&id=0215345e& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_0215345e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_0215345e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_0215345e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=template&id=0215345e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=template&id=0215345e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=template&id=0215345e&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-item-setup/EditComponent.vue?vue&type=template&id=0215345e& ***!
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
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c("div", { staticClass: "col-md-10" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.pmPrintSetId,
              expression: "pmPrintSetId"
            }
          ],
          attrs: { type: "hidden", name: "pm_print_set_id" },
          domProps: { value: _vm.pmPrintSetId },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.pmPrintSetId = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("รหัสสินค้า")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.itemInventory,
                    expression: "itemInventory"
                  }
                ],
                attrs: { type: "hidden", name: "inventory_item_id" },
                domProps: { value: _vm.itemInventory },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.itemInventory = $event.target.value
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
                    placeholder: "รหัสสินค้า",
                    disabled: ""
                  },
                  model: {
                    value: _vm.itemInventory,
                    callback: function($$v) {
                      _vm.itemInventory = $$v
                    },
                    expression: "itemInventory"
                  }
                },
                _vm._l(_vm.itemNumberList, function(itemNumber) {
                  return _c("el-option", {
                    key: itemNumber.inventory_item_id,
                    attrs: {
                      label:
                        itemNumber.item_number + " : " + itemNumber.item_desc,
                      value: itemNumber.inventory_item_id
                    }
                  })
                }),
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("ขนาดบุหรี่")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.tobaccoSize,
                    expression: "tobaccoSize"
                  }
                ],
                attrs: { type: "hidden", name: "tobacco_size" },
                domProps: { value: _vm.tobaccoSize },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.tobaccoSize = $event.target.value
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
                    placeholder: "ขนาดบุหรี่",
                    disabled: ""
                  },
                  model: {
                    value: _vm.tobaccoSize,
                    callback: function($$v) {
                      _vm.tobaccoSize = $$v
                    },
                    expression: "tobaccoSize"
                  }
                },
                _vm._l(_vm.sizeList, function(size, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: size.meaning, value: size.lookup_code }
                  })
                }),
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("Brand")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.brand,
                    expression: "brand"
                  }
                ],
                attrs: { type: "hidden", name: "brand" },
                domProps: { value: _vm.brand },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.brand = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "โปรดกรอก Brand" },
                model: {
                  value: _vm.brand,
                  callback: function($$v) {
                    _vm.brand = $$v
                  },
                  expression: "brand"
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("Brand Color")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                staticClass: "form-control col-12",
                attrs: { type: "color", name: "brand_colors" },
                domProps: { value: this.printItemSetup.brand_colors }
              })
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("Product")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.product,
                    expression: "product"
                  }
                ],
                attrs: { type: "hidden", name: "product" },
                domProps: { value: _vm.product },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.product = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "โปรดกรอก Product" },
                model: {
                  value: _vm.product,
                  callback: function($$v) {
                    _vm.product = $$v
                  },
                  expression: "product"
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("Product Color")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                staticClass: "form-control col-12",
                attrs: { type: "color", name: "product_colors" },
                domProps: { value: this.printItemSetup.product_colors }
              })
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("ระบบการพิมพ์")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.printType,
                    expression: "printType"
                  }
                ],
                attrs: { type: "hidden", name: "print_type" },
                domProps: { value: _vm.printType },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.printType = $event.target.value
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
                    placeholder: "Print Type"
                  },
                  model: {
                    value: _vm.printType,
                    callback: function($$v) {
                      _vm.printType = $$v
                    },
                    expression: "printType"
                  }
                },
                _vm._l(_vm.printTypeList, function(printType, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: printType.description,
                      value: printType.lookup_code
                    }
                  })
                }),
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "row",
            staticStyle: {
              "margin-left": "110px",
              "margin-right": "110px",
              "padding-top": "15px"
            }
          },
          [
            _c(
              "div",
              { staticClass: "col" },
              [
                _c("label", [_vm._v("เปิดการใช้งาน")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.enabledFlag,
                      expression: "enabledFlag"
                    }
                  ],
                  attrs: { type: "hidden", name: "enabled_flag" },
                  domProps: { value: _vm.enabledFlag },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.enabledFlag = $event.target.value
                    }
                  }
                }),
                _vm._v(" "),
                _c("el-checkbox", {
                  staticClass: "w-100",
                  model: {
                    value: _vm.enabledFlag,
                    callback: function($$v) {
                      _vm.enabledFlag = $$v
                    },
                    expression: "enabledFlag"
                  }
                })
              ],
              1
            )
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);