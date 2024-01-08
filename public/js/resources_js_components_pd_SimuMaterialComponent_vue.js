(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pd_SimuMaterialComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_1__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

 // Vue.use(DatePicker);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['simulationTypes', 'uoms', 'defaultValue', 'old', 'checkTransection'],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      start_date: this.defaultValue ? this.defaultValue.start_date : '',
      end_date: this.defaultValue ? this.defaultValue.end_date : '',
      simu_uom: this.old.simu_uom ? this.old.simu_uom : this.defaultValue ? this.defaultValue.simu_uom : '',
      simu_type: this.old.simu_type ? this.old.simu_type : this.defaultValue ? this.defaultValue.simu_type : '',
      simu_raw_num: this.old.simu_raw_num ? this.old.simu_raw_num : this.defaultValue ? this.defaultValue.simu_raw_num : '',
      description: this.old.description ? this.old.description : this.defaultValue ? this.defaultValue.description : '',
      price_per_unit: this.old.price_per_unit ? this.old.price_per_unit : this.defaultValue ? this.defaultValue.price_per_unit : '',
      remark: this.old.remark ? this.old.remark : this.defaultValue ? this.defaultValue.remark : '',
      active_flag: this.old.active_flag == 'Y' ? true : this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
      totalcharacter: 0
    };
  },
  methods: {
    onlyNumeric: function onlyNumeric() {
      this.price_per_unit = this.price_per_unit.replace(/[^0-9 .]/g, '');
    },
    charCount: function charCount() {
      this.totalcharacter = this.remark.length;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pd/SimuMaterialComponent.vue":
/*!**************************************************************!*\
  !*** ./resources/js/components/pd/SimuMaterialComponent.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SimuMaterialComponent_vue_vue_type_template_id_40746788___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SimuMaterialComponent.vue?vue&type=template&id=40746788& */ "./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=template&id=40746788&");
/* harmony import */ var _SimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SimuMaterialComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SimuMaterialComponent_vue_vue_type_template_id_40746788___WEBPACK_IMPORTED_MODULE_0__.render,
  _SimuMaterialComponent_vue_vue_type_template_id_40746788___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pd/SimuMaterialComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SimuMaterialComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=template&id=40746788&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=template&id=40746788& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SimuMaterialComponent_vue_vue_type_template_id_40746788___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SimuMaterialComponent_vue_vue_type_template_id_40746788___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SimuMaterialComponent_vue_vue_type_template_id_40746788___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SimuMaterialComponent.vue?vue&type=template&id=40746788& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=template&id=40746788&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=template&id=40746788&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SimuMaterialComponent.vue?vue&type=template&id=40746788& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { attrs: { align: "center" } }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.simu_raw_num,
                  expression: "simu_raw_num"
                }
              ],
              staticClass: "form-control col-12",
              attrs: {
                type: "text",
                name: "simu_raw_num",
                disabled: this.defaultValue
              },
              domProps: { value: _vm.simu_raw_num },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.simu_raw_num = $event.target.value
                }
              }
            })
          ])
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("div", { attrs: { align: "center" } }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.description,
                  expression: "description"
                }
              ],
              staticClass: "form-control col-12",
              attrs: { type: "text", name: "description" },
              domProps: { value: _vm.description },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.description = $event.target.value
                }
              }
            })
          ])
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { attrs: { align: "center" } },
            [
              _c("input", {
                attrs: {
                  type: "hidden",
                  name: "simu_type",
                  autocomplete: "off"
                },
                domProps: { value: _vm.simu_type }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    filterable: "",
                    remote: "",
                    "reserve-keyword": "",
                    clearable: "",
                    disabled: this.checkTransection
                  },
                  model: {
                    value: _vm.simu_type,
                    callback: function($$v) {
                      _vm.simu_type = $$v
                    },
                    expression: "simu_type"
                  }
                },
                _vm._l(_vm.simulationTypes, function(simulationType) {
                  return _c("el-option", {
                    key: simulationType.lookup_code,
                    attrs: {
                      label: simulationType.meaning,
                      value: simulationType.lookup_code
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
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(3),
          _vm._v(" "),
          _c(
            "div",
            { attrs: { align: "center" } },
            [
              _c("vue-numeric", {
                staticClass: "form-control col-12",
                attrs: { separator: ",", precision: 2, minus: false },
                model: {
                  value: _vm.price_per_unit,
                  callback: function($$v) {
                    _vm.price_per_unit = $$v
                  },
                  expression: "price_per_unit"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "price_per_unit" },
                domProps: { value: _vm.price_per_unit }
              })
            ],
            1
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(4),
          _vm._v(" "),
          _c(
            "div",
            { attrs: { align: "center" } },
            [
              _c("input", {
                attrs: {
                  type: "hidden",
                  name: "simu_uom",
                  autocomplete: "off"
                },
                domProps: { value: _vm.simu_uom }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    filterable: "",
                    remote: "",
                    "reserve-keyword": "",
                    clearable: ""
                  },
                  model: {
                    value: _vm.simu_uom,
                    callback: function($$v) {
                      _vm.simu_uom = $$v
                    },
                    expression: "simu_uom"
                  }
                },
                _vm._l(_vm.uoms, function(uom) {
                  return _c("el-option", {
                    key: uom.uom_code,
                    attrs: { label: uom.description, value: uom.uom_code }
                  })
                }),
                1
              )
            ],
            1
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(5),
          _vm._v(" "),
          _c("div", [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.active_flag,
                  expression: "active_flag"
                }
              ],
              attrs: { type: "checkbox", name: "active_flag" },
              domProps: {
                checked: Array.isArray(_vm.active_flag)
                  ? _vm._i(_vm.active_flag, null) > -1
                  : _vm.active_flag
              },
              on: {
                change: function($event) {
                  var $$a = _vm.active_flag,
                    $$el = $event.target,
                    $$c = $$el.checked ? true : false
                  if (Array.isArray($$a)) {
                    var $$v = null,
                      $$i = _vm._i($$a, $$v)
                    if ($$el.checked) {
                      $$i < 0 && (_vm.active_flag = $$a.concat([$$v]))
                    } else {
                      $$i > -1 &&
                        (_vm.active_flag = $$a
                          .slice(0, $$i)
                          .concat($$a.slice($$i + 1)))
                    }
                  } else {
                    _vm.active_flag = $$c
                  }
                }
              }
            })
          ])
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [
          _vm._m(6),
          _vm._v(" "),
          _c(
            "div",
            [
              _c("el-input", {
                staticClass: "required",
                attrs: {
                  type: "textarea",
                  name: "remark",
                  rows: "3",
                  maxlength: "255",
                  "show-word-limit": ""
                },
                model: {
                  value: _vm.remark,
                  callback: function($$v) {
                    _vm.remark = $$v
                  },
                  expression: "remark"
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
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" รหัสวัตถุดิบ ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" รายละเอียด ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" ประเภทวัตถุดิบจำลอง ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" ราคาต่อหน่วย ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" หน่วย ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" การใช้งาน ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" หมายเหตุ ")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);