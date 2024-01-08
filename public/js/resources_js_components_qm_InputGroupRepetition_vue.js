(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_InputGroupRepetition_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["repeatFlagValue", "repeatTimeHourValue", "repeatTimeMinValue", "repeatQtyValue"],
  data: function data() {
    return {
      repeatFlag: this.repeatFlagValue == 'true',
      repeatTimeHour: this.repeatTimeHourValue,
      repeatTimeMin: this.repeatTimeMinValue,
      repeatQty: this.repeatQtyValue
    };
  },
  mounted: function mounted() {},
  methods: {
    onRepeatTimeHourChanged: function onRepeatTimeHourChanged(e) {
      var value = e.target.value;

      if (value >= 10) {
        this.repeatTimeHour = 10;
        this.repeatTimeMin = 0;
      }
    },
    onRepeatTimeMinChanged: function onRepeatTimeMinChanged(e) {
      var value = e.target.value;

      if (value > 59) {
        this.repeatTimeMin = 59;
      }

      if (this.repeatTimeHour >= 10) {
        this.repeatTimeMin = 0;
      }
    },
    onFlagChanged: function onFlagChanged(value) {
      this.repeatFlag = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/InputGroupRepetition.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/qm/InputGroupRepetition.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputGroupRepetition.vue?vue&type=template&id=414ff45e& */ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&");
/* harmony import */ var _InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputGroupRepetition.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/InputGroupRepetition.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputGroupRepetition.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputGroupRepetition.vue?vue&type=template&id=414ff45e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row form-group" }, [
      _c(
        "div",
        { staticClass: "col-md-12" },
        [
          _c("qm-el-checkbox", {
            attrs: {
              value: _vm.repeatFlag,
              label: "สร้างซ้ำ",
              name: "repeat_flag",
              size: "small"
            },
            on: { change: _vm.onFlagChanged }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _vm.repeatFlag
      ? _c("div", { staticClass: "row form-group" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.repeatTimeHour,
                  expression: "repeatTimeHour"
                }
              ],
              staticClass: "form-control text-center",
              attrs: {
                type: "number",
                name: "repeat_time_hour",
                min: 0,
                max: 12
              },
              domProps: { value: _vm.repeatTimeHour },
              on: {
                blur: _vm.onRepeatTimeHourChanged,
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.repeatTimeHour = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.repeatTimeMin,
                  expression: "repeatTimeMin"
                }
              ],
              staticClass: "form-control text-center",
              attrs: {
                type: "number",
                name: "repeat_time_min",
                min: 0,
                max: 59
              },
              domProps: { value: _vm.repeatTimeMin },
              on: {
                blur: _vm.onRepeatTimeMinChanged,
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.repeatTimeMin = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _vm._m(2)
        ])
      : _vm._e(),
    _vm._v(" "),
    _vm.repeatFlag
      ? _c("div", { staticClass: "row form-group" }, [
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", { staticClass: "required" }, [
                _vm._v(" จำนวนเลขที่ตัวอย่าง ")
              ]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.repeatQty,
                    expression: "repeatQty"
                  }
                ],
                attrs: { type: "hidden", name: "repeat_qty" },
                domProps: { value: _vm.repeatQty },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.repeatQty = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input-number", {
                staticClass: "w-100",
                attrs: { min: 1, max: 10 },
                model: {
                  value: _vm.repeatQty,
                  callback: function($$v) {
                    _vm.repeatQty = $$v
                  },
                  expression: "repeatQty"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _vm._m(3)
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12" }, [
      _c("label", { staticClass: "required" }, [_vm._v(" รอบเวลาที่สร้าง ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2" }, [
      _c(
        "p",
        { staticClass: "form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0" },
        [_vm._v("\n                ชั่วโมง\n            ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2" }, [
      _c(
        "p",
        { staticClass: "form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0" },
        [_vm._v("\n                นาที\n            ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-4" }, [
      _c("label", { staticClass: "md:tw-block tw-hidden" }, [_vm._v(" ")]),
      _vm._v(" "),
      _c(
        "p",
        { staticClass: "form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0" },
        [_vm._v("\n                ชุด\n            ")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);