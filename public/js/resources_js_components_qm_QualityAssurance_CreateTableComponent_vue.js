(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_QualityAssurance_CreateTableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: [],
  data: function data() {
    return {
      headers: {
        enabledFlag: true,
        tobaccoQTYProcess: '',
        description: '',
        numberProcessSamples: '',
        UOMprocess: '',
        tobaccoQTYProcess_showed: false
      },
      addNewLine: 'เพิ่มระดับ Line'
    };
  },
  mounted: function mounted() {},
  methods: {
    getTableResults: function getTableResults() {
      var vm = this;
      console.log(this);

      if (vm.headers.UOMprocess && vm.headers.description && vm.headers.numberProcessSamples && vm.headers.tobaccoQTYProcess) {
        vm.headers.tobaccoQTYProcess_showed = true;
      } else {
        vm.headers.tobaccoQTYProcess_showed = false;
        swal({
          title: "คำเตือน !",
          text: "ไม่สามารถเพิ่มข้อมูลระดับ Line ได้เนื่องจากกรอกข้อมูลระดับ header ยังไม่ครบถ้วน",
          type: "warning",
          showConfirmButton: true
        });
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateTableComponent_vue_vue_type_template_id_000a3284___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateTableComponent.vue?vue&type=template&id=000a3284& */ "./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=template&id=000a3284&");
/* harmony import */ var _CreateTableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateTableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CreateTableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CreateTableComponent_vue_vue_type_template_id_000a3284___WEBPACK_IMPORTED_MODULE_0__.render,
  _CreateTableComponent_vue_vue_type_template_id_000a3284___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/QualityAssurance/CreateTableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateTableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=template&id=000a3284&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=template&id=000a3284& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableComponent_vue_vue_type_template_id_000a3284___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableComponent_vue_vue_type_template_id_000a3284___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTableComponent_vue_vue_type_template_id_000a3284___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateTableComponent.vue?vue&type=template&id=000a3284& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=template&id=000a3284&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=template&id=000a3284&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/CreateTableComponent.vue?vue&type=template&id=000a3284& ***!
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
  return _c("div", [
    _c("table", { staticClass: "table program_info_tb" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("tbody", [
        _c("tr", [
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
                    value: _vm.headers.enabledFlag,
                    expression: "headers.enabledFlag"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "headers[enabledFlag]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.headers.enabledFlag },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.headers, "enabledFlag", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("el-checkbox", {
                model: {
                  value: _vm.headers.enabledFlag,
                  callback: function($$v) {
                    _vm.$set(_vm.headers, "enabledFlag", $$v)
                  },
                  expression: "headers.enabledFlag"
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
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.headers.tobaccoQTYProcess,
                    expression: "headers.tobaccoQTYProcess"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "headers[tobaccoQTYProcess]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.headers.tobaccoQTYProcess },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(
                      _vm.headers,
                      "tobaccoQTYProcess",
                      $event.target.value
                    )
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กระบวนการตรวจคุณภาพบุหรี่" },
                model: {
                  value: _vm.headers.tobaccoQTYProcess,
                  callback: function($$v) {
                    _vm.$set(_vm.headers, "tobaccoQTYProcess", $$v)
                  },
                  expression: "headers.tobaccoQTYProcess"
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
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.headers.description,
                    expression: "headers.description"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "headers[description]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.headers.description },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.headers, "description", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "รายละเอียดกระบวนการตรวจคุณภาพบุหรี่" },
                model: {
                  value: _vm.headers.description,
                  callback: function($$v) {
                    _vm.$set(_vm.headers, "description", $$v)
                  },
                  expression: "headers.description"
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
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.headers.numberProcessSamples,
                    expression: "headers.numberProcessSamples"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "headers[numberProcessSamples]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.headers.numberProcessSamples },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(
                      _vm.headers,
                      "numberProcessSamples",
                      $event.target.value
                    )
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "จำนวนตัวอย่างการตรวจสอบ" },
                model: {
                  value: _vm.headers.numberProcessSamples,
                  callback: function($$v) {
                    _vm.$set(_vm.headers, "numberProcessSamples", $$v)
                  },
                  expression: "headers.numberProcessSamples"
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
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.headers.UOMprocess,
                    expression: "headers.UOMprocess"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "headers[UOMprocess]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.headers.UOMprocess },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.headers, "UOMprocess", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "หน่วยการตรวจสอบ" },
                model: {
                  value: _vm.headers.UOMprocess,
                  callback: function($$v) {
                    _vm.$set(_vm.headers, "UOMprocess", $$v)
                  },
                  expression: "headers.UOMprocess"
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
                  staticClass: "btn btn-default",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.getTableResults()
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-edit" }),
                  _vm._v(
                    "\n                        " +
                      _vm._s(this.addNewLine) +
                      "\n                    "
                  )
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _vm.headers.tobaccoQTYProcess_showed
          ? _c("tr", [
              _c(
                "td",
                { attrs: { colspan: "6" } },
                [_c("quality-assurance-create-table-results")],
                1
              )
            ])
          : _vm._e()
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
        _c("th", { staticClass: "text-center" }, [
          _c("label", [_vm._v("สถานะการใช้งาน")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("กระบวนการตรวจคุณภาพบุหรี่ "),
            _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("รายละเอียดกระบวนการตรวจคุณภาพบุหรี่ "),
            _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("จำนวนตัวอย่างการตรวจสอบ "),
            _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("หน่วยการตรวจสอบ "),
            _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);