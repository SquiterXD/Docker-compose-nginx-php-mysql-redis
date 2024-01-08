(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_PrintProductType_TableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['products', 'listProducts', 'btnTrans'],
  data: function data() {
    return {
      // listProducts: this.products.data,
      listData: this.listProducts,
      // start_date: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : moment().add(543, 'years').toDate(),
      start_date: '',
      end_date: '',
      checkedEditUpdate: ''
    };
  },
  mounted: function mounted() {},
  methods: {
    checkEdit: function checkEdit(checkedEditUpdate, products) {
      if (checkedEditUpdate) {
        products.is_select = false;
      } else {
        products.is_select = true;
      }
    },
    removeRowTableData: function removeRowTableData(index, flexValueId) {
      var params = {
        index: index,
        flexValueId: flexValueId
      };
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-warning',
        confirmButtonText: "Confirm",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          axios.get('/pm/ajax/print-product-type/destroy', {
            params: params
          }).then(function (res) {
            swal({
              title: "success !",
              text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว",
              type: "success",
              showConfirmButton: false
            });
            window.location.reload(false);
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/PrintProductType/TableComponent.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/pm/PrintProductType/TableComponent.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponent_vue_vue_type_template_id_afdab24a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=template&id=afdab24a& */ "./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=template&id=afdab24a&");
/* harmony import */ var _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponent_vue_vue_type_template_id_afdab24a___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponent_vue_vue_type_template_id_afdab24a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/PrintProductType/TableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=template&id=afdab24a&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=template&id=afdab24a& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_afdab24a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_afdab24a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_afdab24a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=template&id=afdab24a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=template&id=afdab24a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=template&id=afdab24a&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintProductType/TableComponent.vue?vue&type=template&id=afdab24a& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
      _c(
        "tbody",
        _vm._l(_vm.listData, function(product, index) {
          return _c("tr", { key: index, attrs: { row: index } }, [
            _c(
              "td",
              [
                _c("el-checkbox", {
                  on: {
                    change: function($event) {
                      return _vm.checkEdit(product.checkedEditUpdate, product)
                    }
                  },
                  model: {
                    value: product.checkedEditUpdate,
                    callback: function($$v) {
                      _vm.$set(product, "checkedEditUpdate", $$v)
                    },
                    expression: "product.checkedEditUpdate"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: product.flex_value_id,
                  expression: "product.flex_value_id"
                }
              ],
              attrs: {
                type: "hidden",
                name: "dataGroup[" + index + "][flex_value_id]",
                autocomplete: "off"
              },
              domProps: { value: product.flex_value_id },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(product, "flex_value_id", $event.target.value)
                }
              }
            }),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: product.flex_value_set_id,
                  expression: "product.flex_value_set_id"
                }
              ],
              attrs: {
                type: "hidden",
                name: "dataGroup[" + index + "][flex_value_set_id]",
                autocomplete: "off"
              },
              domProps: { value: product.flex_value_set_id },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(product, "flex_value_set_id", $event.target.value)
                }
              }
            }),
            _vm._v(" "),
            _c(
              "td",
              [
                _c("el-input", {
                  attrs: { disabled: true },
                  model: {
                    value: product.description,
                    callback: function($$v) {
                      _vm.$set(product, "description", $$v)
                    },
                    expression: "product.description"
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
                      value: product.attribute26,
                      expression: "product.attribute26"
                    }
                  ],
                  attrs: {
                    type: "hidden",
                    name: "dataGroup[" + index + "][attribute26]",
                    autocomplete: "off"
                  },
                  domProps: { value: product.attribute26 },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(product, "attribute26", $event.target.value)
                    }
                  }
                }),
                _vm._v(" "),
                _c("el-input", {
                  attrs: {
                    placeholder: "โปรดกรอก Product",
                    disabled: product.is_select
                  },
                  model: {
                    value: product.attribute26,
                    callback: function($$v) {
                      _vm.$set(product, "attribute26", $$v)
                    },
                    expression: "product.attribute26"
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
                      value: product.start_date_active,
                      expression: "product.start_date_active"
                    }
                  ],
                  attrs: {
                    type: "hidden",
                    name: "dataGroup[" + index + "][start_date_active]",
                    autocomplete: "off"
                  },
                  domProps: { value: product.start_date_active },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(
                        product,
                        "start_date_active",
                        $event.target.value
                      )
                    }
                  }
                }),
                _vm._v(" "),
                _c("datepicker-th", {
                  staticClass: "form-control md:tw-mb-0 tw-mb-2",
                  staticStyle: { width: "100%" },
                  attrs: {
                    name: "dataGroup[" + index + "][start_date]",
                    placeholder: product.start_date_active
                      ? product.start_date_active
                      : "",
                    format: "DD-MM-YYYY",
                    disabled: product.is_select
                  },
                  model: {
                    value: index.start_date,
                    callback: function($$v) {
                      _vm.$set(index, "start_date", $$v)
                    },
                    expression: "index.start_date"
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
                      value: product.end_date_active,
                      expression: "product.end_date_active"
                    }
                  ],
                  attrs: {
                    type: "hidden",
                    name: "dataGroup[" + index + "][end_date_active]",
                    autocomplete: "off"
                  },
                  domProps: { value: product.end_date_active },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(product, "end_date_active", $event.target.value)
                    }
                  }
                }),
                _vm._v(" "),
                _c("datepicker-th", {
                  staticClass: "form-control md:tw-mb-0 tw-mb-2",
                  staticStyle: { width: "100%" },
                  attrs: {
                    name: "dataGroup[" + index + "][end_date]",
                    placeholder: product.end_date_active
                      ? product.end_date_active
                      : "",
                    format: "DD-MM-YYYY",
                    disabled: product.is_select
                  },
                  model: {
                    value: index.end_date,
                    callback: function($$v) {
                      _vm.$set(index, "end_date", $$v)
                    },
                    expression: "index.end_date"
                  }
                })
              ],
              1
            )
          ])
        }),
        0
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-12 mt-3" }, [
      _c("div", { staticClass: "row clearfix text-right" }, [
        _c(
          "div",
          { staticClass: "col", staticStyle: { "margin-top": "15px" } },
          [
            _c(
              "button",
              { class: _vm.btnTrans.save.class, attrs: { type: "submit" } },
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
            )
          ]
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
        _c("th"),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [_c("div", [_vm._v("ประเภทสิ่งพิมพ์")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [_c("div", [_vm._v("Product")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [_c("div", [_vm._v("วันที่เริ่มต้นใช้งาน")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [_c("div", [_vm._v("วันที่สิ้นสุดใช้งาน")])]
        )
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);