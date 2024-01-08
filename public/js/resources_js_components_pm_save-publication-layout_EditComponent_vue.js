(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_save-publication-layout_EditComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["setupLayout", "listDateLayout", 'customUomList'],
  data: function data() {
    return {
      layoutId: this.setupLayout.layout_id,
      start_date: this.listDateLayout[0] ? this.listDateLayout[0].start_date : '',
      end_date: this.listDateLayout[0] ? this.listDateLayout[0].end_date : '',
      numberLayout: this.setupLayout ? this.setupLayout.layout_qty : '',
      unit: this.setupLayout ? this.setupLayout.primary_uom_code : '',
      unitMeasure: this.setupLayout ? this.setupLayout.primary_unit_of_measure : '',
      customUomCode: this.setupLayout ? this.setupLayout.custom_uom_code : '',
      customUomName: this.setupLayout ? this.setupLayout.custom_uom_name : ''
    };
  },
  mounted: function mounted() {
    console.log(this.setupLayout);
  },
  methods: {}
});

/***/ }),

/***/ "./resources/js/components/pm/save-publication-layout/EditComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/save-publication-layout/EditComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EditComponent_vue_vue_type_template_id_38562150___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=template&id=38562150& */ "./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=template&id=38562150&");
/* harmony import */ var _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EditComponent_vue_vue_type_template_id_38562150___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditComponent_vue_vue_type_template_id_38562150___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/save-publication-layout/EditComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=template&id=38562150&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=template&id=38562150& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_38562150___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_38562150___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_38562150___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=template&id=38562150& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=template&id=38562150&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=template&id=38562150&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/save-publication-layout/EditComponent.vue?vue&type=template&id=38562150& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row justify-content-center" }, [
    _c("div", { staticClass: "col-md-8" }, [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.layoutId,
            expression: "layoutId"
          }
        ],
        attrs: { type: "hidden", name: "layout_id", autocomplete: "off" },
        domProps: { value: _vm.layoutId },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.layoutId = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "row",
          staticStyle: {
            "margin-right": "125px",
            "margin-left": "125px",
            "padding-top": "15px"
          }
        },
        [
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", [_vm._v("วันที่เริ่มต้นการใช้งาน")]),
              _vm._v(" "),
              _c("datepicker-th", {
                staticClass: "form-control md:tw-mb-0 tw-mb-2",
                staticStyle: { width: "100%" },
                attrs: {
                  name: "start_date_active",
                  placeholder: "โปรดเลือกวันที่",
                  format: "DD-MM-YYYY"
                },
                model: {
                  value: _vm.start_date,
                  callback: function($$v) {
                    _vm.start_date = $$v
                  },
                  expression: "start_date"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", [_vm._v("วันที่เลิกใช้งาน")]),
              _vm._v(" "),
              _c("datepicker-th", {
                staticClass: "form-control md:tw-mb-0 tw-mb-2",
                staticStyle: { width: "100%" },
                attrs: {
                  name: "end_date_active",
                  placeholder: "โปรดเลือกวันที่",
                  format: "DD-MM-YYYY"
                },
                model: {
                  value: _vm.end_date,
                  callback: function($$v) {
                    _vm.end_date = $$v
                  },
                  expression: "end_date"
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
          staticClass: "row",
          staticStyle: {
            "margin-right": "125px",
            "margin-left": "125px",
            "padding-top": "15px"
          }
        },
        [
          _c(
            "div",
            { staticClass: "col" },
            [
              _c("label", [_vm._v("จำนวน Layout")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.numberLayout,
                    expression: "numberLayout"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "numberLayout",
                  autocomplete: "off"
                },
                domProps: { value: _vm.numberLayout },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.numberLayout = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("vue-numeric", {
                staticClass: "form-control w-100 text-right",
                attrs: {
                  placeholder: "จำนวน Layout",
                  separator: ",",
                  precision: 0,
                  minus: false
                },
                model: {
                  value: _vm.numberLayout,
                  callback: function($$v) {
                    _vm.numberLayout = $$v
                  },
                  expression: "numberLayout"
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
          staticClass: "row",
          staticStyle: {
            "margin-right": "125px",
            "margin-left": "125px",
            "padding-top": "15px"
          }
        },
        [
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", [_vm._v("หน่วย")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { disabled: true, placeholder: "Please input" },
                model: {
                  value: _vm.unit,
                  callback: function($$v) {
                    _vm.unit = $$v
                  },
                  expression: "unit"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-6", staticStyle: { "padding-top": "26px" } },
            [
              _c("el-input", {
                attrs: { disabled: true, placeholder: "Please input" },
                model: {
                  value: _vm.unitMeasure,
                  callback: function($$v) {
                    _vm.unitMeasure = $$v
                  },
                  expression: "unitMeasure"
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
          staticClass: "row",
          staticStyle: {
            "margin-right": "125px",
            "margin-left": "125px",
            "padding-top": "15px"
          }
        },
        [
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", [_vm._v("หน่วย")]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: {
                    name: "custom_uom_code",
                    placeholder: "Select",
                    clearable: "",
                    filterable: ""
                  },
                  on: {
                    change: function(value) {
                      if (value && _vm.customUomList.length > 0) {
                        var query = _vm.customUomList.findIndex(function(o) {
                          return o.value == value
                        })
                        query = _vm.customUomList[query]
                        _vm.customUomName = query.label
                      } else {
                        _vm.customUomName = ""
                      }
                    }
                  },
                  model: {
                    value: _vm.customUomCode,
                    callback: function($$v) {
                      _vm.customUomCode = $$v
                    },
                    expression: "customUomCode"
                  }
                },
                _vm._l(_vm.customUomList, function(item) {
                  return _c(
                    "el-option",
                    {
                      key: item.value,
                      attrs: { label: item.label, value: item.value }
                    },
                    [
                      _c("span", { staticStyle: { float: "left" } }, [
                        _vm._v(_vm._s(item.label))
                      ])
                    ]
                  )
                }),
                1
              ),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "custom_uom_code" },
                domProps: { value: _vm.customUomCode }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-6", staticStyle: { "padding-top": "26px" } },
            [
              _c("el-input", {
                attrs: { disabled: true },
                model: {
                  value: _vm.customUomName,
                  callback: function($$v) {
                    _vm.customUomName = $$v
                  },
                  expression: "customUomName"
                }
              })
            ],
            1
          )
        ]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);