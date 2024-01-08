(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_CustomerComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CustomerComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CustomerComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['types', 'authoRityLists', 'defaultValue'],
  data: function data() {
    return {
      selectCustomerType: this.defaultValue ? this.defaultValue.customer_type : '',
      selectEmployee: this.defaultValue ? Number(this.defaultValue.authority_id) : '',
      selectStatus: this.defaultValue ? this.defaultValue.status : 'Active',
      geographies: [],
      position_name: this.defaultValue ? this.defaultValue.position_name : '',
      disablePosition: this.defaultValue ? this.defaultValue.position_name ? false : true : true,
      primary_approval: this.defaultValue ? this.defaultValue.primary_approval == 'Y' ? true : false : '',
      email: this.defaultValue ? this.defaultValue.email : '',
      statusData: [{
        value: 'Active',
        label: 'Active'
      }, {
        value: 'Inactive',
        label: 'Inactive'
      }]
    };
  },
  methods: {
    getPosition: function getPosition() {
      var _this = this;

      console.log(this.selectEmployee);

      if (this.selectEmployee) {
        this.selectedData = this.authoRityLists.find(function (i) {
          return i.authority_id == _this.selectEmployee;
        });
        this.position_name = this.selectedData.position_name;
        this.disablePosition = false;
      }
    },
    getCheckPrimary: function getCheckPrimary() {
      var _this2 = this;

      axios.get("/om/settings/customer/primary-approval", {
        params: {
          customer_type: this.selectCustomerType
        }
      }).then(function (res) {
        if (!res.data) {
          _this2.primary_approval = true;
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/CustomerComponent.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/om/CustomerComponent.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CustomerComponent_vue_vue_type_template_id_6f755b0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CustomerComponent.vue?vue&type=template&id=6f755b0e& */ "./resources/js/components/om/CustomerComponent.vue?vue&type=template&id=6f755b0e&");
/* harmony import */ var _CustomerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CustomerComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/CustomerComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CustomerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CustomerComponent_vue_vue_type_template_id_6f755b0e___WEBPACK_IMPORTED_MODULE_0__.render,
  _CustomerComponent_vue_vue_type_template_id_6f755b0e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/CustomerComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/CustomerComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/om/CustomerComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CustomerComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CustomerComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/CustomerComponent.vue?vue&type=template&id=6f755b0e&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/om/CustomerComponent.vue?vue&type=template&id=6f755b0e& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerComponent_vue_vue_type_template_id_6f755b0e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerComponent_vue_vue_type_template_id_6f755b0e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerComponent_vue_vue_type_template_id_6f755b0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CustomerComponent.vue?vue&type=template&id=6f755b0e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CustomerComponent.vue?vue&type=template&id=6f755b0e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CustomerComponent.vue?vue&type=template&id=6f755b0e&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CustomerComponent.vue?vue&type=template&id=6f755b0e& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
          _c("input", {
            attrs: { type: "hidden", name: "customer_type" },
            domProps: { value: _vm.selectCustomerType }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: { filterable: "" },
              on: {
                change: function($event) {
                  return _vm.getCheckPrimary()
                }
              },
              model: {
                value: _vm.selectCustomerType,
                callback: function($$v) {
                  _vm.selectCustomerType = $$v
                },
                expression: "selectCustomerType"
              }
            },
            _vm._l(_vm.types, function(type) {
              return _c("el-option", {
                key: type.meaning,
                attrs: {
                  label: type.meaning + " : " + type.description,
                  value: type.meaning
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
        { staticClass: "col-md-4" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "authority_id" },
            domProps: { value: _vm.selectEmployee }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: { filterable: "" },
              on: {
                change: function($event) {
                  return _vm.getPosition()
                }
              },
              model: {
                value: _vm.selectEmployee,
                callback: function($$v) {
                  _vm.selectEmployee = $$v
                },
                expression: "selectEmployee"
              }
            },
            _vm._l(_vm.authoRityLists, function(authoRity) {
              return _c("el-option", {
                key: authoRity.authority_id,
                attrs: {
                  label:
                    authoRity.employee_name + " : " + authoRity.position_name,
                  value: authoRity.authority_id
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
        { staticClass: "col-md-4" },
        [
          _vm._m(2),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "email" },
            model: {
              value: _vm.email,
              callback: function($$v) {
                _vm.email = $$v
              },
              expression: "email"
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
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: { name: "status" },
              model: {
                value: _vm.selectStatus,
                callback: function($$v) {
                  _vm.selectStatus = $$v
                },
                expression: "selectStatus"
              }
            },
            _vm._l(_vm.statusData, function(item) {
              return _c("el-option", {
                key: item.value,
                attrs: { label: item.label, value: item.value }
              })
            }),
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(4),
        _vm._v(" "),
        _c("div", { staticClass: "ml-2" }, [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.primary_approval,
                expression: "primary_approval"
              }
            ],
            attrs: { type: "checkbox", name: "primary_approval" },
            domProps: {
              checked: Array.isArray(_vm.primary_approval)
                ? _vm._i(_vm.primary_approval, null) > -1
                : _vm.primary_approval
            },
            on: {
              change: function($event) {
                var $$a = _vm.primary_approval,
                  $$el = $event.target,
                  $$c = $$el.checked ? true : false
                if (Array.isArray($$a)) {
                  var $$v = null,
                    $$i = _vm._i($$a, $$v)
                  if ($$el.checked) {
                    $$i < 0 && (_vm.primary_approval = $$a.concat([$$v]))
                  } else {
                    $$i > -1 &&
                      (_vm.primary_approval = $$a
                        .slice(0, $$i)
                        .concat($$a.slice($$i + 1)))
                  }
                } else {
                  _vm.primary_approval = $$c
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
      _vm._v(" ประเภทลูกค้า "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ผู้มีอำนาจอนุมัติ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" Email "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" Status "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" Primary Approval "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);