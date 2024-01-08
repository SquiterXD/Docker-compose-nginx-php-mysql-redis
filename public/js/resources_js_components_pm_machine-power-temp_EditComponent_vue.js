(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_machine-power-temp_EditComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['productPeriod', 'dataMachinePowerTemp', 'btnTrans', 'uomList'],
  data: function data() {
    return {
      // machineType: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].machine_type : '',
      productPeriodShow: this.productPeriod,
      dataMachinePowerTempShow: this.dataMachinePowerTemp,
      uom: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].uom : '',
      // uom_description: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].uomList.description : '',
      machineId: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].machine_id : '',
      machineGroup: this.dataMachinePowerTemp ? this.dataMachinePowerTemp[0].machine_group : '',
      statusBtuSave: false
    };
  },
  mounted: function mounted() {},
  methods: {
    checkValue: function checkValue(value, indexPeriod, index) {
      var _this = this;

      var vm = this;
      vm.dataMachinePowerTemp.forEach(function (element, i) {
        if (index < element.product_time) {
          if (index != element.product_time) {
            if (Number(value) > Number(element.power)) {
              _this.showAlert();

              _this.statusBtuSave = true;
              return;
            } else {
              _this.statusBtuSave = false;
            }
          }
        }
      });
    },
    showAlert: function showAlert() {
      swal({
        title: "Error !",
        text: "ไม่สามารถกรอกจำนวนเลขนี้ได้",
        type: "error",
        showConfirmButton: true
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/EditComponent.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/EditComponent.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EditComponent_vue_vue_type_template_id_7220c15d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=template&id=7220c15d& */ "./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=template&id=7220c15d&");
/* harmony import */ var _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EditComponent_vue_vue_type_template_id_7220c15d___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditComponent_vue_vue_type_template_id_7220c15d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/machine-power-temp/EditComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=template&id=7220c15d&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=template&id=7220c15d& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_7220c15d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_7220c15d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_7220c15d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=template&id=7220c15d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=template&id=7220c15d&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=template&id=7220c15d&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/EditComponent.vue?vue&type=template&id=7220c15d& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "col-lg-12" }, [
    _c("div", { staticClass: "ibox" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "form",
        {
          attrs: {
            action: "/pm/settings/machine-power-temp/update",
            method: "get"
          }
        },
        [
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "row justify-content-center" }, [
              _c(
                "div",
                { staticClass: "col-md-8" },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.machineId,
                        expression: "machineId"
                      }
                    ],
                    attrs: { type: "hidden", name: "machineId" },
                    domProps: { value: _vm.machineId },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.machineId = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.machineGroup,
                        expression: "machineGroup"
                      }
                    ],
                    attrs: { type: "hidden", name: "machineGroup" },
                    domProps: { value: _vm.machineGroup },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.machineGroup = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _vm._l(_vm.productPeriodShow, function(data, index) {
                    return _c(
                      "div",
                      { key: index },
                      _vm._l(_vm.dataMachinePowerTempShow, function(
                        value,
                        key
                      ) {
                        return _c("div", { key: key }, [
                          data.lookup_code == value.product_time
                            ? _c("div", [
                                _c("div", { staticClass: "row" }, [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "col",
                                      staticStyle: { "padding-top": "15px" }
                                    },
                                    [
                                      _c("label", [
                                        _vm._v(_vm._s(data.description))
                                      ]),
                                      _c(
                                        "span",
                                        { staticClass: "text-danger" },
                                        [_vm._v(" *")]
                                      ),
                                      _vm._v(" "),
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: value.power,
                                            expression: "value.power"
                                          }
                                        ],
                                        attrs: {
                                          type: "hidden",
                                          name: "power[" + [index + 1] + "]"
                                        },
                                        domProps: { value: value.power },
                                        on: {
                                          input: function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.$set(
                                              value,
                                              "power",
                                              $event.target.value
                                            )
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: value.product_time,
                                            expression: "value.product_time"
                                          }
                                        ],
                                        attrs: {
                                          type: "hidden",
                                          name:
                                            "lookupCode[" + [index + 1] + "]"
                                        },
                                        domProps: { value: value.product_time },
                                        on: {
                                          input: function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.$set(
                                              value,
                                              "product_time",
                                              $event.target.value
                                            )
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("el-input", {
                                        attrs: {
                                          placeholder: "โปรดกรอกกำลังการผลิต"
                                        },
                                        on: {
                                          change: function($event) {
                                            return _vm.checkValue(
                                              value.power,
                                              value.product_time,
                                              index + 1
                                            )
                                          }
                                        },
                                        model: {
                                          value: value.power,
                                          callback: function($$v) {
                                            _vm.$set(value, "power", $$v)
                                          },
                                          expression: "value.power"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ])
                              ])
                            : _vm._e()
                        ])
                      }),
                      0
                    )
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      {
                        staticClass: "col",
                        staticStyle: { "padding-top": "15px" }
                      },
                      [
                        _c("label", [_vm._v("หน่วย")]),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v(" *")
                        ]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.uom,
                              expression: "uom"
                            }
                          ],
                          attrs: { type: "hidden", name: "uom" },
                          domProps: { value: _vm.uom },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.uom = $event.target.value
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            staticClass: "w-100",
                            attrs: {
                              placeholder: "เลือก หน่วย",
                              clearable: "",
                              filterable: "",
                              remote: "",
                              "reserve-keyword": ""
                            },
                            model: {
                              value: _vm.uom,
                              callback: function($$v) {
                                _vm.uom = $$v
                              },
                              expression: "uom"
                            }
                          },
                          _vm._l(_vm.uomList, function(uom, index) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label: uom.unit_of_measure,
                                value: uom.uom_code
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    )
                  ])
                ],
                2
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row clearfix text-right" }, [
              _c(
                "div",
                { staticClass: "col", staticStyle: { "margin-top": "15px" } },
                [
                  _c(
                    "button",
                    {
                      class: _vm.btnTrans.save.class,
                      attrs: { type: "submit", disabled: this.statusBtuSave }
                    },
                    [
                      _c("i", {
                        class: _vm.btnTrans.save.icon,
                        attrs: { "aria-hidden": "true" }
                      }),
                      _vm._v(
                        " " +
                          _vm._s(_vm.btnTrans.save.text) +
                          " \n                    "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      class: _vm.btnTrans.cancel.class,
                      attrs: {
                        type: "button",
                        href: "/pm/settings/machine-power-temp"
                      }
                    },
                    [
                      _c("i", {
                        class: _vm.btnTrans.cancel.icon,
                        attrs: { "aria-hidden": "true" }
                      }),
                      _vm._v(
                        " " +
                          _vm._s(_vm.btnTrans.cancel.text) +
                          "\n                    "
                      )
                    ]
                  )
                ]
              )
            ])
          ])
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
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h5", [_vm._v("แก้ไขบันทึกกำลังผลิตรายเครื่อง")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);