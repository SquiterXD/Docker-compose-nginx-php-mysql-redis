(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_tax-adjustments-bkk_tableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['lineList', 'btnTrans'],
  data: function data() {
    return {
      text: {
        listFix: 'ยอดจำหน่ายบุหรี่ ยาเส้น-สโมสร กทม.',
        total: 'ยอดรวม',
        notInformation: 'ไม่มีข้อมูล'
      },
      totalAdjust: '',
      totaVatAmountCalculate: '',
      totalAmountAdjustGLTable: '',
      loadingTable: false,
      checkAll: false,
      disableCheckAll: false
    };
  },
  computed: {
    totalAmount: function totalAmount() {
      return this.lineList.reduce(function (previous, current) {
        return Number(previous) + Number(current.total_amount);
      }, 0);
    },
    totalVatAmount: function totalVatAmount() {
      this.totalAdjustAmount();
      return this.lineList.reduce(function (previous, current) {
        return Number(previous) + Number(current.vat_amount);
      }, 0);
    }
  },
  mounted: function mounted() {},
  watch: {
    lineList: function lineList(newList, oldList) {
      // watch it
      this.checkAll = newList.every(function (item) {
        return item.use_tax_adjustments ? item.use_tax_adjustments.post_flag == 'Y' : false;
      });
      this.disableCheckAll = newList.every(function (item) {
        return item.use_tax_adjustments ? true : false;
      });
    }
  },
  methods: {
    setAll: function setAll() {
      var vm = this;
      this.$emit('updateCheckAll', vm.checkAll);
    },
    checkPost: function checkPost() {
      var test = this.lineList.every(function (item) {
        return item.checked;
      });
      this.checkAll = test;
    },
    totalAdjustAmount: function totalAdjustAmount(data, value) {
      var vm = this;

      if (data) {
        this.lineList.forEach(function (element) {
          if (data.consignment_header_id == element.consignment_header_id) {
            element.tax_adjust_amount = value;
          }
        });
        this.totalAdjust = this.lineList.reduce(function (previous, current) {
          if (current.use_tax_adjustments) {
            return Number(previous) + Number(current.use_tax_adjustments.tax_adjust_amount);
          } else {
            return Number(previous) + Number(current.tax_adjust_amount);
          }
        }, 0);
        this.totaVatAmountCalculate = this.lineList.reduce(function (previous, current) {
          return Number(previous) + Number(current.vat_amount);
        }, 0);
        this.totalAmountAdjustGLTable = Number(this.totaVatAmountCalculate) - Number(this.totalAdjust);
        vm.$parent.totalAmountAdjustGL = this.totalAmountAdjustGLTable;
      } else {
        // console.log(this.lineList)
        this.totalAdjust = this.lineList.reduce(function (previous, current) {
          if (current.use_tax_adjustments) {
            return Number(previous) + Number(current.use_tax_adjustments.tax_adjust_amount);
          } else {
            return Number(previous) + Number(current.tax_adjust_amount);
          }
        }, 0);
        this.totaVatAmountCalculate = this.lineList.reduce(function (previous, current) {
          return Number(previous) + Number(current.vat_amount);
        }, 0);
        this.totalAmountAdjustGLTable = Number(this.totaVatAmountCalculate) - Number(this.totalAdjust);
        vm.$parent.totalAmountAdjustGL = this.totalAmountAdjustGLTable;
      }
    },
    getStore: function getStore() {
      var _this = this;

      var vm = this;
      var lineList = this.lineList.filter(function (data) {
        return data.checked == true;
      });

      if (lineList.length != 0) {
        this.loadingTable = true;
        axios.post('ajax/tax-adjustments-bkk/store', {
          lineList: lineList
        }).then(function (res) {
          if (res.data.status == "ERROR") {
            swal({
              title: "error !",
              text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก " + res.data.err_msg,
              type: "error",
              showConfirmButton: true
            });
            _this.loadingTable = false;
            return;
          } else if (res.data.result == "success") {
            swal({
              title: "success !",
              text: "บันทึก สำเร็จ!",
              type: "success",
              showConfirmButton: true
            });
            _this.loadingTable = false;
            vm.$parent.getSearchData(vm.form_search);
          }
        });
      } else {
        swal({
          title: "คำเตือน !",
          text: "กรุณาเลือกรายการที่ต้องการจะ Post",
          type: "warning",
          showConfirmButton: true
        });
        this.loadingTable = false;
        return;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _tableComponent_vue_vue_type_template_id_a68dd88a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tableComponent.vue?vue&type=template&id=a68dd88a& */ "./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=template&id=a68dd88a&");
/* harmony import */ var _tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./tableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _tableComponent_vue_vue_type_template_id_a68dd88a___WEBPACK_IMPORTED_MODULE_0__.render,
  _tableComponent_vue_vue_type_template_id_a68dd88a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/tax-adjustments-bkk/tableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./tableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=template&id=a68dd88a&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=template&id=a68dd88a& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_template_id_a68dd88a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_template_id_a68dd88a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_template_id_a68dd88a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./tableComponent.vue?vue&type=template&id=a68dd88a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=template&id=a68dd88a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=template&id=a68dd88a&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/tax-adjustments-bkk/tableComponent.vue?vue&type=template&id=a68dd88a& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "ibox-content" }, [
    _vm.lineList.length != 0
      ? _c(
          "div",
          {
            staticClass: "text-right",
            staticStyle: { "padding-top": "15px", "padding-bottom": "15px" }
          },
          [
            _c(
              "button",
              {
                class: _vm.btnTrans.save.class,
                attrs: { type: "submit" },
                on: {
                  click: function($event) {
                    return _vm.getStore()
                  }
                }
              },
              [
                _c("i", {
                  class: _vm.btnTrans.save.icon,
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(" " + _vm._s(_vm.btnTrans.save.text) + "\n        ")
              ]
            )
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _c(
      "table",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loadingTable,
            expression: "loadingTable"
          }
        ],
        staticClass: "table table-bordered text-center"
      },
      [
        _c("thead", [
          _c("tr", [
            _vm._m(0),
            _vm._v(" "),
            _vm._m(1),
            _vm._v(" "),
            _vm._m(2),
            _vm._v(" "),
            _vm._m(3),
            _vm._v(" "),
            _vm._m(4),
            _vm._v(" "),
            _vm._m(5),
            _vm._v(" "),
            _c("th", { staticClass: "text-center" }, [
              _c("div", [_vm._v("Post")]),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c("el-checkbox", {
                    attrs: { disabled: _vm.disableCheckAll },
                    on: {
                      change: function($event) {
                        return _vm.setAll()
                      }
                    },
                    model: {
                      value: _vm.checkAll,
                      callback: function($$v) {
                        _vm.checkAll = $$v
                      },
                      expression: "checkAll"
                    }
                  })
                ],
                1
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _vm.lineList.length == 0
          ? _c("tbody", [
              _c("tr", [
                _c(
                  "td",
                  {
                    staticClass: "text-center",
                    staticStyle: {
                      "font-size": "18px",
                      "vertical-align": "middle"
                    },
                    attrs: { colspan: "7" }
                  },
                  [_vm._v(" " + _vm._s(_vm.text.notInformation))]
                )
              ])
            ])
          : _c(
              "tbody",
              [
                _vm._l(_vm.lineList, function(data, index) {
                  return _c("tr", { key: index }, [
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _vm._v(
                        "\n                    " +
                          _vm._s(data.consignment_no) +
                          "\n                "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _vm._v(
                        "\n                    " +
                          _vm._s(data.consignment_date_th) +
                          "\n                "
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-left",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(_vm.text.listFix) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(data.total_amount_decimal_point) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(data.vat_amount_decimal_point) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      data.use_tax_adjustments
                        ? _c(
                            "div",
                            [
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: true
                                },
                                model: {
                                  value:
                                    data.use_tax_adjustments.tax_adjust_amount,
                                  callback: function($$v) {
                                    _vm.$set(
                                      data.use_tax_adjustments,
                                      "tax_adjust_amount",
                                      $$v
                                    )
                                  },
                                  expression:
                                    "data.use_tax_adjustments.tax_adjust_amount"
                                }
                              })
                            ],
                            1
                          )
                        : _c(
                            "div",
                            [
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.totalAdjustAmount(
                                      data,
                                      data.tax_adjust_amount
                                    )
                                  }
                                },
                                model: {
                                  value: data.tax_adjust_amount,
                                  callback: function($$v) {
                                    _vm.$set(data, "tax_adjust_amount", $$v)
                                  },
                                  expression: "data.tax_adjust_amount"
                                }
                              })
                            ],
                            1
                          )
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-checkbox", {
                          attrs: {
                            disabled: data.use_tax_adjustments
                              ? data.use_tax_adjustments.post_flag == "Y"
                              : false
                          },
                          on: {
                            change: function($event) {
                              return _vm.checkPost()
                            }
                          },
                          model: {
                            value: data.checked,
                            callback: function($$v) {
                              _vm.$set(data, "checked", $$v)
                            },
                            expression: "data.checked"
                          }
                        })
                      ],
                      1
                    )
                  ])
                }),
                _vm._v(" "),
                _c("tr", [
                  _c("td", { attrs: { colspan: "3" } }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.text.total) +
                        "\n                "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticClass: "text-right",
                      staticStyle: { "vertical-align": "middle" }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(
                            _vm.totalAmount.toLocaleString(undefined, {
                              minimumFractionDigits: 2
                            })
                          ) +
                          "\n                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticClass: "text-right",
                      staticStyle: { "vertical-align": "middle" }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(
                            _vm.totalVatAmount.toLocaleString(undefined, {
                              minimumFractionDigits: 2
                            })
                          ) +
                          "\n                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticClass: "text-right",
                      staticStyle: { "vertical-align": "middle" }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(
                            this.totalAdjust.toLocaleString(undefined, {
                              minimumFractionDigits: 2
                            })
                          ) +
                          "\n                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("td")
                ])
              ],
              2
            )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("div", [_vm._v("เลขที่")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("div", [_vm._v("วันที่")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("div", [_vm._v("รายการ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-right" }, [
      _c("div", [_vm._v("มูลค่าสินค้า")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-right" }, [
      _c("div", [_vm._v("จำนวนเงินภาษี")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-right" }, [
      _c("div", [_vm._v("ภาษีที่ Adjust")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);