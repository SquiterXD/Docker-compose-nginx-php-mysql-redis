(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_MaterialGroupComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["departments", "materialGroups"],
  data: function data() {
    return {
      departmentSelected: '',
      departmentDescription: '',
      materialGroupSelected: '',
      typeDescription: ''
    };
  },
  mounted: function mounted() {},
  methods: {
    getDepartmentDescription: function getDepartmentDescription() {
      var _this = this;

      var find = this.departments.find(function (item) {
        if (item.department_code === _this.departmentSelected) {
          return item;
        }
      });
      this.departmentDescription = find ? find.description : '';
    },
    getTypeDescription: function getTypeDescription() {
      var _this2 = this;

      var find = this.materialGroups.find(function (item) {
        if (item.type_code === _this2.materialGroupSelected) {
          return item;
        }
      });
      this.typeDescription = find ? find.type_desc : '';
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/MaterialGroupComponent.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/pm/MaterialGroupComponent.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _MaterialGroupComponent_vue_vue_type_template_id_41bc677c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MaterialGroupComponent.vue?vue&type=template&id=41bc677c& */ "./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=template&id=41bc677c&");
/* harmony import */ var _MaterialGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MaterialGroupComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _MaterialGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MaterialGroupComponent_vue_vue_type_template_id_41bc677c___WEBPACK_IMPORTED_MODULE_0__.render,
  _MaterialGroupComponent_vue_vue_type_template_id_41bc677c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/MaterialGroupComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MaterialGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MaterialGroupComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MaterialGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=template&id=41bc677c&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=template&id=41bc677c& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MaterialGroupComponent_vue_vue_type_template_id_41bc677c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MaterialGroupComponent_vue_vue_type_template_id_41bc677c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MaterialGroupComponent_vue_vue_type_template_id_41bc677c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MaterialGroupComponent.vue?vue&type=template&id=41bc677c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=template&id=41bc677c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=template&id=41bc677c&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaterialGroupComponent.vue?vue&type=template&id=41bc677c& ***!
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
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c("div", { staticClass: "col-md-8" }, [
        _c(
          "div",
          {
            staticClass: "row",
            staticStyle: {
              "padding-left": "15px",
              "padding-top": "15px",
              "padding-bottom": "15px",
              "padding-right": "15px"
            }
          },
          [
            _c(
              "div",
              { staticClass: "col-md-6" },
              [
                _c("label", [_vm._v("รหัสแผนก")]),
                _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.departmentSelected,
                      expression: "departmentSelected"
                    }
                  ],
                  attrs: { type: "hidden", name: "dept_code" },
                  domProps: { value: _vm.departmentSelected },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.departmentSelected = $event.target.value
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
                      placeholder: "เลือกรหัสแผนก"
                    },
                    on: { change: _vm.getDepartmentDescription },
                    model: {
                      value: _vm.departmentSelected,
                      callback: function($$v) {
                        _vm.departmentSelected = $$v
                      },
                      expression: "departmentSelected"
                    }
                  },
                  _vm._l(_vm.departments, function(department) {
                    return _c("el-option", {
                      key: department.department_code,
                      attrs: {
                        label: department.department_code,
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
              { staticClass: "col-md-6" },
              [
                _c("label", [_vm._v("แผนก")]),
                _vm._v(" "),
                _c(
                  "el-input",
                  {
                    staticClass: "w-100",
                    attrs: { disabled: "", placeholder: "เลือกรหัสแผนก" },
                    model: {
                      value: _vm.departmentDescription,
                      callback: function($$v) {
                        _vm.departmentDescription = $$v
                      },
                      expression: "departmentDescription"
                    }
                  },
                  _vm._l(_vm.departments, function(department) {
                    return _c("el-option", {
                      key: department.department_code,
                      attrs: {
                        label: department.description,
                        value: department.department_code
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
            staticClass: "row",
            staticStyle: {
              "padding-left": "15px",
              "padding-top": "15px",
              "padding-bottom": "15px",
              "padding-right": "15px"
            }
          },
          [
            _c(
              "div",
              { staticClass: "col-md-6" },
              [
                _c("label", [_vm._v("รหัส")]),
                _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.materialGroupSelected,
                      expression: "materialGroupSelected"
                    }
                  ],
                  attrs: { type: "hidden", name: "itemcat_group_code" },
                  domProps: { value: _vm.materialGroupSelected },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.materialGroupSelected = $event.target.value
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
                      placeholder: "เลือกรหัส"
                    },
                    on: { change: _vm.getTypeDescription },
                    model: {
                      value: _vm.materialGroupSelected,
                      callback: function($$v) {
                        _vm.materialGroupSelected = $$v
                      },
                      expression: "materialGroupSelected"
                    }
                  },
                  _vm._l(_vm.materialGroups, function(materialGroup) {
                    return _c("el-option", {
                      key: materialGroup.type_code,
                      attrs: {
                        label: materialGroup.type_code,
                        value: materialGroup.type_code
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
              { staticClass: "col-md-6" },
              [
                _c("label", [_vm._v("กลุ่มวัตถุดิบ")]),
                _vm._v(" "),
                _c(
                  "el-input",
                  {
                    staticClass: "w-100",
                    attrs: { disabled: "", placeholder: "เลือกรหัส" },
                    model: {
                      value: _vm.typeDescription,
                      callback: function($$v) {
                        _vm.typeDescription = $$v
                      },
                      expression: "typeDescription"
                    }
                  },
                  _vm._l(_vm.materialGroups, function(materialGroup) {
                    return _c("el-option", {
                      key: materialGroup.type_code,
                      attrs: {
                        label: materialGroup.type_desc,
                        value: materialGroup.type_code
                      }
                    })
                  }),
                  1
                )
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