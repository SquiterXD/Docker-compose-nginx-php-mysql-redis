(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_sub-groups_createComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
var _methods;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["policySetHeaders", 'oldInput', 'url', 'btnTrans'],
  data: function data() {
    return {
      policySelected: this.oldInput ? this.oldInput.oldPolicyHeaders : '',
      create: false,
      lines: [],
      id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
      checked: true,
      subGroupCode: '',
      subGroupDescription: '',
      activeFlag: true,
      loading: false
    };
  },
  mounted: function mounted() {//
  },
  methods: (_methods = {
    createLine: function createLine() {
      this.create = true;
    },
    addLine: function addLine() {
      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
        checked: true,
        subGroupCode: '',
        subGroupDescription: ''
      });
      window.scrollTo({
        top: document.body.scrollHeight,
        left: 0,
        behavior: 'smooth'
      });
    }
  }, _defineProperty(_methods, "addLine", function addLine() {
    this.lines.push({
      id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
      checked: true,
      subGroupCode: '',
      subGroupDescription: '',
      subGroupSource: '',
      activeFlag: ''
    });
  }), _defineProperty(_methods, "removeRow", function removeRow(index) {
    this.lines.splice(index, 1);
  }), _methods),
  checkDuplicateSubGroupCode: function checkDuplicateSubGroupCode(index) {
    var _this = this;

    this.lines.forEach(function (element, i) {
      if (i != index) {
        if (_this.lines[index].subGroupCode == element.subGroupCode) {
          swal({
            title: "warning !",
            text: "รหัสข้อมูลซ้ำ",
            type: "warning",
            showConfirmButton: true
          });
        }
      }
    });
  }
});

/***/ }),

/***/ "./resources/js/components/ir/sub-groups/createComponent.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ir/sub-groups/createComponent.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _createComponent_vue_vue_type_template_id_80043d84___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createComponent.vue?vue&type=template&id=80043d84& */ "./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=template&id=80043d84&");
/* harmony import */ var _createComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./createComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _createComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _createComponent_vue_vue_type_template_id_80043d84___WEBPACK_IMPORTED_MODULE_0__.render,
  _createComponent_vue_vue_type_template_id_80043d84___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/sub-groups/createComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./createComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=template&id=80043d84&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=template&id=80043d84& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponent_vue_vue_type_template_id_80043d84___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponent_vue_vue_type_template_id_80043d84___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_createComponent_vue_vue_type_template_id_80043d84___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./createComponent.vue?vue&type=template&id=80043d84& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=template&id=80043d84&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=template&id=80043d84&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/createComponent.vue?vue&type=template&id=80043d84& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ]
    },
    [
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            staticClass: "col-md",
            staticStyle: {
              "margin-left": "5px",
              width: "530px",
              "padding-left": "250px",
              "padding-right": "250px"
            }
          },
          [
            _c("label", [_vm._v("กรมธรรม์ชุดที่ (Policy No.)")]),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.policySelected,
                  expression: "policySelected"
                }
              ],
              attrs: { type: "hidden", name: "policy" },
              domProps: { value: _vm.policySelected },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.policySelected = $event.target.value
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
                  placeholder: "เลือกชื่อจุดตรวจสอบ"
                },
                on: { change: _vm.createLine },
                model: {
                  value: _vm.policySelected,
                  callback: function($$v) {
                    _vm.policySelected = $$v
                  },
                  expression: "policySelected"
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
        )
      ]),
      _vm._v(" "),
      this.create
        ? _c("div", { staticClass: "mt-2" }, [
            _c("hr"),
            _vm._v(" "),
            _c("div", { staticClass: "text-right" }, [
              _c(
                "button",
                {
                  class: _vm.btnTrans.add.class + " btn-sm",
                  attrs: { type: "submit" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.addLine($event)
                    }
                  }
                },
                [
                  _c("i", {
                    class: _vm.btnTrans.add.icon,
                    attrs: { "aria-hidden": "true" }
                  }),
                  _vm._v(
                    " \n                " +
                      _vm._s(_vm.btnTrans.add.text) +
                      " \n            "
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c("table", { staticClass: "table table-responsive-sm" }, [
              _vm._m(0),
              _vm._v(" "),
              this.lines.length == 0
                ? _c("tbody", [_vm._m(1)])
                : _c(
                    "tbody",
                    _vm._l(_vm.lines, function(row, index) {
                      return _c("tr", { key: index, attrs: { row: row } }, [
                        _c(
                          "td",
                          { staticStyle: { "vertical-align": "middle" } },
                          [_vm._v(" " + _vm._s(index + 1) + " ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.subGroupCode,
                                  expression: "row.subGroupCode"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "dataGroup[" + row.id + "][sub_group_code]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.subGroupCode },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    row,
                                    "subGroupCode",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { placeholder: "ระบุรหัส" },
                              on: {
                                change: function($event) {
                                  return _vm.checkDuplicateSubGroupCode(index)
                                }
                              },
                              model: {
                                value: row.subGroupCode,
                                callback: function($$v) {
                                  _vm.$set(row, "subGroupCode", $$v)
                                },
                                expression: "row.subGroupCode"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.subGroupDescription,
                                  expression: "row.subGroupDescription"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "dataGroup[" +
                                  row.id +
                                  "][sub_group_description]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.subGroupDescription },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    row,
                                    "subGroupDescription",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { placeholder: "ระบุคำอธิบาย" },
                              on: {
                                change: function($event) {
                                  return _vm.checkDuplicatesubGroupDescription(
                                    index
                                  )
                                }
                              },
                              model: {
                                value: row.subGroupDescription,
                                callback: function($$v) {
                                  _vm.$set(row, "subGroupDescription", $$v)
                                },
                                expression: "row.subGroupDescription"
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
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c(
                "div",
                {
                  staticClass: "col-md",
                  staticStyle: {
                    "margin-left": "5px",
                    width: "530px",
                    "padding-right": "250px",
                    "padding-top": "25px"
                  }
                },
                [
                  _c("label", [_vm._v("Active")]),
                  _c(
                    "span",
                    {
                      staticClass: "text-danger",
                      staticStyle: { "padding-right": "15px" }
                    },
                    [_vm._v(" *")]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.activeFlag,
                        expression: "activeFlag"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "active_flag",
                      autocomplete: "off"
                    },
                    domProps: { value: _vm.activeFlag },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.activeFlag = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-checkbox", {
                    model: {
                      value: _vm.activeFlag,
                      callback: function($$v) {
                        _vm.activeFlag = $$v
                      },
                      expression: "activeFlag"
                    }
                  })
                ],
                1
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
                      class: _vm.btnTrans.save.class + " btn-sm",
                      attrs: { type: "submit" }
                    },
                    [
                      _c("i", {
                        class: _vm.btnTrans.save.icon,
                        attrs: { "aria-hidden": "true" }
                      }),
                      _vm._v(
                        " \n                    " +
                          _vm._s(_vm.btnTrans.save.text) +
                          " \n                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      class: _vm.btnTrans.cancel.class + " btn-sm",
                      attrs: { href: _vm.url, type: "button" }
                    },
                    [
                      _c("i", {
                        class: _vm.btnTrans.cancel.icon,
                        attrs: { "aria-hidden": "true" }
                      }),
                      _vm._v(
                        " \n                    " +
                          _vm._s(_vm.btnTrans.cancel.text) +
                          "\n                "
                      )
                    ]
                  )
                ]
              )
            ])
          ])
        : _vm._e()
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { width: "1%" } }),
        _vm._v(" "),
        _c("th", { attrs: { width: "40%" } }, [
          _vm._v(" รหัส (Code) "),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "40%" } }, [
          _vm._v(" คำอธิบาย (Description) "),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "4%" } })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "td",
        {
          staticClass: "text-center",
          staticStyle: { "vertical-align": "middle" },
          attrs: { colspan: "4" }
        },
        [_c("h2", [_vm._v(" ยังไม่มีการเพิ่มรายการใหม่ ")])]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);