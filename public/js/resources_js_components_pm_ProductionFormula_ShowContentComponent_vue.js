(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_ProductionFormula_ShowContentComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['header', 'wipSteps', 'userName', 'startDate', 'endDate', 'machine', 'uomName', 'wipStep', 'lines', 'oprns', 'items', 'formulaType'],
  data: function data() {
    return {
      routing_desc: this.header ? this.header.routing_desc : '',
      multi_wip_step: '',
      status: '',
      invoice_flag: this.header.invoice_flag == 'Y' ? true : false,
      datas: [],
      oprn_id: ''
    };
  },
  mounted: function mounted() {
    this.multi_wip_step = this.header.oprn_id;
    this.getTable();

    if (this.header.status == 'Approved for General Use') {
      this.status = 'อนุมัติ';
    } else if (this.header.status == 'New') {
      this.status = 'สร้างใหม่';
    } else if (this.header.status == 'Obsolete/Archived') {
      this.status = 'ยกเลิก';
    }
  },
  methods: {
    getTable: function getTable() {
      var _this = this;

      this.datas = [];
      this.lines.forEach(function (line) {
        var row_no = 0;
        var listRows = [];
        var uomDesc = '';
        _this.selectedData = _this.oprns.find(function (i) {
          return i.routingstep_no == line.ingredient_step_line;
        });
        _this.oprn_id = _this.selectedData.oprn_id;

        if (_this.datas.length > 0) {
          _this.selectedRow = _this.datas.find(function (i) {
            if (_this.oprn_id == i.oprn_id) {
              listRows.push({
                oprn_id: _this.oprn_id
              });
            }
          });
          row_no = listRows.length + 1;
        } else {
          row_no += 1;
        }

        _this.selectedItem = _this.items.find(function (i) {
          if (i.inventory_item_id == line.ingredient_item_id) {
            uomDesc = i.primary_unit_of_measure;
          }
        });

        _this.datas.push({
          ingredient_step_line: line.ingredient_step_line,
          ingredient_line: row_no,
          ingredient_item_id: line.ingredient_item_id,
          item_number: line.segment1,
          item_description: line.description,
          ingredient_folmula_qty: Number(line.ingredient_folmula_qty),
          scrap_factor: Number(line.scrap_factor),
          ingredient_qty: Number(line.ingredient_qty),
          ingredient_uom: uomDesc,
          active_flag: line.enable_flag == 'Y' ? true : false,
          oprn_id: _this.oprn_id
        });
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ShowContentComponent_vue_vue_type_template_id_4d4d005a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowContentComponent.vue?vue&type=template&id=4d4d005a& */ "./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=template&id=4d4d005a&");
/* harmony import */ var _ShowContentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowContentComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ShowContentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ShowContentComponent_vue_vue_type_template_id_4d4d005a___WEBPACK_IMPORTED_MODULE_0__.render,
  _ShowContentComponent_vue_vue_type_template_id_4d4d005a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/ProductionFormula/ShowContentComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowContentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowContentComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowContentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=template&id=4d4d005a&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=template&id=4d4d005a& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowContentComponent_vue_vue_type_template_id_4d4d005a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowContentComponent_vue_vue_type_template_id_4d4d005a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowContentComponent_vue_vue_type_template_id_4d4d005a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowContentComponent.vue?vue&type=template&id=4d4d005a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=template&id=4d4d005a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=template&id=4d4d005a&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/ShowContentComponent.vue?vue&type=template&id=4d4d005a& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
    _c("h4", [_vm._v("สูตรการผลิต")]),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(
            _vm._s(
              _vm.header.product_segment1 + " " + _vm.header.product_description
            )
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(1),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v("\n                " + _vm._s(this.status) + "\n            ")
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-3" }, [
        _vm._m(2),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [_vm._v(_vm._s(this.userName))])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(3),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(_vm._s(this.formulaType) + " ")
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(4),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(_vm._s(this.header.version) + " ")
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-3" }, [
        _vm._m(5),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(_vm._s(this.header.period_year) + " ")
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(6),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(" " + _vm._s(this.header.routing_desc) + " ")
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(7),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(
            " " +
              _vm._s(_vm._f("number0Digit")(this.header.qty)) +
              " " +
              _vm._s(this.uomName)
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-3" }, [
        _vm._m(8),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(
            "\n                " + _vm._s(this.startDate) + " \n            "
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-4" }, [
        _c(
          "div",
          { staticClass: "ml-3" },
          [
            _c("div", [
              _vm._m(9),
              _vm._v(" "),
              _c("label", [_vm._v(" " + _vm._s(this.wipStep) + " ")])
            ]),
            _vm._v(" "),
            _vm._l(_vm.wipSteps[_vm.routing_desc], function(wipStepHeader) {
              return [
                _c(
                  "el-radio",
                  {
                    attrs: { label: wipStepHeader.oprn_id },
                    on: {
                      change: function($event) {
                        return _vm.getTable()
                      }
                    },
                    model: {
                      value: _vm.multi_wip_step,
                      callback: function($$v) {
                        _vm.multi_wip_step = $$v
                      },
                      expression: "multi_wip_step"
                    }
                  },
                  [
                    _vm._v(
                      "\n                        " +
                        _vm._s(wipStepHeader.oprn_desc) +
                        "\n                    "
                    )
                  ]
                )
              ]
            })
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _vm._m(10),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v("\n                " + _vm._s(this.machine) + "\n            ")
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-3" }, [
        _vm._m(11),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(
            "\n                " + _vm._s(this.endDate) + " \n            "
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-8" }, [
        _vm._m(12),
        _vm._v(" "),
        _c("label", { staticClass: "ml-3" }, [
          _vm._v(
            "\n                " +
              _vm._s(this.header.comments) +
              " \n            "
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-3" }, [
        _vm._m(13),
        _vm._v(" "),
        _c(
          "label",
          { staticClass: "ml-3" },
          [
            _vm.invoice_flag
              ? [_c("i", { staticClass: "fa fa-check-circle text-success" })]
              : [_c("i", { staticClass: "fa fa-circle text-muted" })]
          ],
          2
        )
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "mt-5" }, [
      _c("h4", [_vm._v("วัตถุดิบที่ใช้")]),
      _vm._v(" "),
      _c("div", { staticClass: "ml-3" }, [
        _c("div", { staticClass: "table-responsive" }, [
          _c("table", { staticClass: "table table-bordered" }, [
            _vm._m(14),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.datas, function(row, index) {
                return _c(
                  "tr",
                  { key: index, attrs: { row: row } },
                  [
                    _vm.multi_wip_step === row.oprn_id
                      ? [
                          _c("td", { staticClass: "text-center" }, [
                            _vm._v(_vm._s(row.ingredient_line))
                          ]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.item_number))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.item_description))]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-right" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.ingredient_folmula_qty) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-right" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.scrap_factor) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-right" }, [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.ingredient_qty) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(row.ingredient_uom) +
                                "\n                                "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center" },
                            [
                              row.active_flag
                                ? [
                                    _c("i", {
                                      staticClass:
                                        "fa fa-check-circle text-success"
                                    })
                                  ]
                                : [
                                    _c("i", {
                                      staticClass: "fa fa-circle text-muted"
                                    })
                                  ]
                            ],
                            2
                          )
                        ]
                      : _vm._e()
                  ],
                  2
                )
              }),
              0
            )
          ])
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
    return _c("label", { staticClass: "ml-3" }, [
      _c("b", [_vm._v("รหัสสินค้า")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("สถานะ")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("ผู้อนุมัติ")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "ml-3" }, [
      _c("b", [_vm._v("ประเภทสูตร")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("Version")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("ปีงบประมาณ")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "ml-3" }, [
      _c("b", [_vm._v("ประเภทสิ่งผลิต")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("จำนวนผลผลิต")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("วันที่เริ่มใช้งาน")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("ขั้นตอนการทำงาน")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("ประเภทเครื่องจักร")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("วันที่สิ้นสุดการใช้งาน")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "ml-3" }, [_c("b", [_vm._v("หมายเหตุ")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("b", [_vm._v("กองบริหารต้นทุนนำไปใช้แล้ว")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "80px" } },
            [_vm._v("ลำดับวัตถุดิบ ")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "80px" } },
            [_vm._v("รหัสวัตถุดิบ")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "180px" } },
            [_vm._v("รายละเอียด")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "90px" } },
            [_vm._v("จำนวนตามสูตร")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "60px" } },
            [_vm._v("% สูญเสีย")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "100px" } },
            [_vm._v("ปริมาณที่ต้องใช้")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "60px" } },
            [_vm._v("หน่วยนับ")]
          )
        ]),
        _vm._v(" "),
        _c("th", [
          _c(
            "div",
            { staticClass: "text-center", staticStyle: { width: "120px" } },
            [_vm._v("สถานะการใช้งาน")]
          )
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);