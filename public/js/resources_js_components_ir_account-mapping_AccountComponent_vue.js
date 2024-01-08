(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_account-mapping_AccountComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      account_code: '',
      description: '',
      segment1: '',
      segment2: '',
      segment3: '',
      segment4: '',
      segment5: '',
      segment6: '',
      segment7: '',
      segment8: '',
      segment9: '',
      segment10: '',
      segment11: '',
      segment12: '',
      value: '',
      active_flag: true
    };
  },
  methods: {
    updateCoaFrom: function updateCoaFrom(res) {
      // if (res.name == 'TTM_GL_ACCT_CODE-COMPANY_CODE') { this.segment1 = res.segment1;}
      // if (res.name == 'TTM_GL_ACCT_CODE-EVM') { this.segment2 = res.segment2;}
      if (res.name == 'TTM_GL_ACCT_CODE-DEPT_CODE') {
        this.segment3 = res.segment3;
        this.segment4 = null;
      } // if (res.name == 'TTM_GL_ACCT_CODE-COST_CENTER') { this.segment4 = res.segment4;}
      // if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_YEAR') { this.segment5 = res.segment5;}


      if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_TYPE') {
        this.segment6 = res.segment6;
        this.segment7 = null;
      } // if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_DETAIL') { this.segment7 = res.segment7;}
      // if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_REASON') { this.segment8 = res.segment8;}


      if (res.name == 'TTM_GL_ACCT_CODE-MAIN_ACCOUNT') {
        this.segment9 = res.segment9;
        this.segment10 = null;
      } // if (res.name == 'TTM_GL_ACCT_CODE-SUB_ACCOUNT') { this.segment10 = res.segment10;}
      // if (res.name == 'TTM_GL_ACCT_CODE-RESERVED1') { this.segment11 = res.segment11;}
      // if (res.name == 'TTM_GL_ACCT_CODE-RESERVED2') { this.segment12 = res.segment12;}

    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/account-mapping/AccountComponent.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ir/account-mapping/AccountComponent.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _AccountComponent_vue_vue_type_template_id_4113c648___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountComponent.vue?vue&type=template&id=4113c648& */ "./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=template&id=4113c648&");
/* harmony import */ var _AccountComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _AccountComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _AccountComponent_vue_vue_type_template_id_4113c648___WEBPACK_IMPORTED_MODULE_0__.render,
  _AccountComponent_vue_vue_type_template_id_4113c648___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/account-mapping/AccountComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=template&id=4113c648&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=template&id=4113c648& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountComponent_vue_vue_type_template_id_4113c648___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountComponent_vue_vue_type_template_id_4113c648___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountComponent_vue_vue_type_template_id_4113c648___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountComponent.vue?vue&type=template&id=4113c648& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=template&id=4113c648&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=template&id=4113c648&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountComponent.vue?vue&type=template&id=4113c648& ***!
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
  return _c("div", [
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(0),
          _vm._v(" "),
          _c("el-input", {
            attrs: {
              type: "text",
              name: "account_code",
              placeholder: "Please enter a value",
              autocomplete: "off",
              size: "small",
              maxlength: "5"
            },
            model: {
              value: _vm.account_code,
              callback: function($$v) {
                _vm.account_code = $$v
              },
              expression: "account_code"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("el-input", {
            attrs: {
              type: "text",
              name: "description",
              placeholder: "Please enter a value",
              autocomplete: "off",
              size: "small"
            },
            model: {
              value: _vm.description,
              callback: function($$v) {
                _vm.description = $$v
              },
              expression: "description"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(2),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-COMPANY_CODE",
              "set-data": _vm.segment1,
              placeholder: "Company",
              name: "segment1"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(3),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-EVM",
              "set-data": _vm.segment2,
              placeholder: "EVM",
              name: "segment2"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(4),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-DEPT_CODE",
              "set-data": _vm.segment3,
              placeholder: "Department",
              name: "segment3"
            },
            on: { coa: _vm.updateCoaFrom }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(5),
          _vm._v(" "),
          !_vm.segment3
            ? [
                _c("el-select", {
                  staticClass: "w-100",
                  staticStyle: { width: "100%" },
                  attrs: {
                    filterable: "",
                    remote: "",
                    clearable: "",
                    size: "small",
                    disabled: ""
                  },
                  model: {
                    value: _vm.value,
                    callback: function($$v) {
                      _vm.value = $$v
                    },
                    expression: "value"
                  }
                })
              ]
            : _c("input-segment", {
                attrs: {
                  "set-name": "TTM_GL_ACCT_CODE-COST_CENTER",
                  "set-data": _vm.segment4,
                  "set-parent": _vm.segment3,
                  placeholder: "Cost Center",
                  name: "segment4"
                }
              })
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(6),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-BUDGET_YEAR",
              "set-data": _vm.segment5,
              placeholder: "BUDGET YEAR",
              name: "segment5"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(7),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-BUDGET_TYPE",
              "set-data": _vm.segment6,
              placeholder: "BUDGET TYPE",
              name: "segment6"
            },
            on: { coa: _vm.updateCoaFrom }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(8),
          _vm._v(" "),
          !_vm.segment6
            ? [
                _c("el-select", {
                  staticClass: "w-100",
                  staticStyle: { width: "100%" },
                  attrs: {
                    filterable: "",
                    remote: "",
                    clearable: "",
                    size: "small",
                    disabled: ""
                  },
                  model: {
                    value: _vm.value,
                    callback: function($$v) {
                      _vm.value = $$v
                    },
                    expression: "value"
                  }
                })
              ]
            : _c("input-segment", {
                attrs: {
                  "set-name": "TTM_GL_ACCT_CODE-BUDGET_DETAIL",
                  "set-data": _vm.segment7,
                  "set-parent": _vm.segment6,
                  placeholder: "BUDGET DETAIL",
                  name: "segment7"
                }
              })
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(9),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-BUDGET_REASON",
              "set-data": _vm.segment8,
              placeholder: "BUDGET REASON",
              name: "segment8"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(10),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-MAIN_ACCOUNT",
              "set-data": _vm.segment9,
              placeholder: "MAIN ACCOUNT",
              name: "segment9"
            },
            on: { coa: _vm.updateCoaFrom }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(11),
          _vm._v(" "),
          !_vm.segment9
            ? [
                _c("el-select", {
                  staticClass: "w-100",
                  staticStyle: { width: "100%" },
                  attrs: {
                    filterable: "",
                    remote: "",
                    clearable: "",
                    size: "small",
                    disabled: ""
                  },
                  model: {
                    value: _vm.value,
                    callback: function($$v) {
                      _vm.value = $$v
                    },
                    expression: "value"
                  }
                })
              ]
            : _c("input-segment", {
                attrs: {
                  "set-name": "TTM_GL_ACCT_CODE-SUB_ACCOUNT",
                  "set-data": _vm.segment10,
                  "set-parent": _vm.segment9,
                  placeholder: "SUB ACCOUNT",
                  name: "segment10"
                }
              })
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(12),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-RESERVED1",
              "set-data": _vm.segment11,
              placeholder: "RESERVED 1",
              name: "segment11"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(13),
          _vm._v(" "),
          _c("input-segment", {
            attrs: {
              "set-name": "TTM_GL_ACCT_CODE-RESERVED2",
              "set-data": _vm.segment12,
              placeholder: "RESERVED 2",
              name: "segment12"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _c("label", [_vm._v(" Active ")]),
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
            staticClass: "i-checks",
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
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" Code "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" Description "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" COMPANY "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" EVM "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" DEPARTMENT "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" COST CENTER "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" BUDGET YEAR "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" BUDGET TYPE "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" BUDGET DETAIL "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" BUDGET REASON "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" MAIN ACCOUNT "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" SUB ACCOUNT "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" RESERVED1 "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" RESERVED2 "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);