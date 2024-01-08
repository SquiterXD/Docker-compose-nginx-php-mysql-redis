(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_QualityAssurance_CreateTableResultsComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: [],
  data: function data() {
    return {
      lines: []
    };
  },
  mounted: function mounted() {
    this.addLine();
  },
  methods: {
    addLine: function addLine() {
      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
        enabledFlag: true,
        tobaccoQTYchecklist: '',
        description: ''
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateTableResultsComponent_vue_vue_type_template_id_571dc870___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateTableResultsComponent.vue?vue&type=template&id=571dc870& */ "./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=template&id=571dc870&");
/* harmony import */ var _CreateTableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateTableResultsComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CreateTableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CreateTableResultsComponent_vue_vue_type_template_id_571dc870___WEBPACK_IMPORTED_MODULE_0__.render,
  _CreateTableResultsComponent_vue_vue_type_template_id_571dc870___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateTableResultsComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=template&id=571dc870&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=template&id=571dc870& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableResultsComponent_vue_vue_type_template_id_571dc870___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableResultsComponent_vue_vue_type_template_id_571dc870___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableResultsComponent_vue_vue_type_template_id_571dc870___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateTableResultsComponent.vue?vue&type=template&id=571dc870& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=template&id=571dc870&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=template&id=571dc870&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableResultsComponent.vue?vue&type=template&id=571dc870& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "table-responsive" }, [
    _c(
      "div",
      {
        staticClass: "text-right",
        staticStyle: {
          "padding-bottom": "15px",
          "padding-top": "15px",
          "padding-right": "15px"
        }
      },
      [
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-primary",
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.addLine($event)
              }
            }
          },
          [
            _c("i", {
              staticClass: "fa fa-plus",
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(" เพิ่มรายการ \n        ")
          ]
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "table-responsive" }, [
      _c("table", { staticClass: "table table-bordered mb-0" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.lines, function(data, index) {
            return _c("tr", { key: index }, [
              _c(
                "td",
                {
                  staticClass: "text-center",
                  staticStyle: { "vertical-align": "middle" }
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: data.enabledFlag,
                        expression: "data.enabledFlag"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "lines[" + data.id + "][enabledFlag]",
                      autocomplete: "off"
                    },
                    domProps: { value: data.enabledFlag },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(data, "enabledFlag", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-checkbox", {
                    model: {
                      value: data.enabledFlag,
                      callback: function($$v) {
                        _vm.$set(data, "enabledFlag", $$v)
                      },
                      expression: "data.enabledFlag"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "td",
                { staticStyle: { "vertical-align": "middle" } },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: data.tobaccoQTYchecklist,
                        expression: "data.tobaccoQTYchecklist"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "lines[" + data.id + "][tobaccoQTYchecklist]",
                      autocomplete: "off"
                    },
                    domProps: { value: data.tobaccoQTYchecklist },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          data,
                          "tobaccoQTYchecklist",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-input", {
                    attrs: { placeholder: "รายการตรวจสอบคุณภาพบุหรี่" },
                    model: {
                      value: data.tobaccoQTYchecklist,
                      callback: function($$v) {
                        _vm.$set(data, "tobaccoQTYchecklist", $$v)
                      },
                      expression: "data.tobaccoQTYchecklist"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "td",
                { staticStyle: { "vertical-align": "middle" } },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: data.description,
                        expression: "data.description"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "lines[" + data.id + "][description]",
                      autocomplete: "off"
                    },
                    domProps: { value: data.description },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(data, "description", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-input", {
                    attrs: { placeholder: "รายละเอียดการตรวจสอบคุณภาพบุหรี่" },
                    model: {
                      value: data.description,
                      callback: function($$v) {
                        _vm.$set(data, "description", $$v)
                      },
                      expression: "data.description"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "td",
                {
                  staticClass: "text-center",
                  staticStyle: { "vertical-align": "middle" }
                },
                [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-sm btn-danger",
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.removeRow(index)
                        }
                      }
                    },
                    [
                      _c("i", {
                        staticClass: "fa fa-times",
                        attrs: { "aria-hidden": "true" }
                      })
                    ]
                  )
                ]
              )
            ])
          }),
          0
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [_c("div", [_vm._v("สถานะการใช้งาน")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [
            _c("div", [
              _vm._v("รายการตรวจสอบคุณภาพบุหรี่ "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [
            _c("div", [
              _vm._v("รายละเอียดการตรวจสอบคุณภาพบุหรี่ "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c("th")
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);