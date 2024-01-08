(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_qtm-machines_TableQtmMachineReportQuantumNeo_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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
// Import loading-overlay component
 // Import loading-overlay stylesheet


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["reportDates", "reportDateTimes", "reportItems"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    var _this = this;

    return {
      is_loading: false,
      reportQuantumNeoItems: this.reportDates.map(function (rdItem) {
        var filterDateTimeItems = _this.reportDateTimes.filter(function (rdtItem) {
          return rdtItem.date_drawn_formatted == rdItem.date_drawn_formatted;
        });

        var reportDateTimeItems = filterDateTimeItems.map(function (fdtItem) {
          var filteredReportItems = _this.reportItems.filter(function (rItem) {
            return rItem.date_drawn_formatted == fdtItem.date_drawn_formatted && rItem.time_drawn_formatted == fdtItem.time_drawn_formatted;
          });

          return _objectSpread(_objectSpread({}, fdtItem), {}, {
            report_items: filteredReportItems
          });
        });
        return _objectSpread(_objectSpread({}, rdItem), {}, {
          report_datetime_items: reportDateTimeItems
        });
      })
    };
  },
  methods: {}
});

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableQtmMachineReportQuantumNeo_vue_vue_type_template_id_4f0cdf58___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58& */ "./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58&");
/* harmony import */ var _TableQtmMachineReportQuantumNeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableQtmMachineReportQuantumNeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableQtmMachineReportQuantumNeo_vue_vue_type_template_id_4f0cdf58___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableQtmMachineReportQuantumNeo_vue_vue_type_template_id_4f0cdf58___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableQtmMachineReportQuantumNeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableQtmMachineReportQuantumNeo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableQtmMachineReportQuantumNeo_vue_vue_type_template_id_4f0cdf58___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableQtmMachineReportQuantumNeo_vue_vue_type_template_id_4f0cdf58___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableQtmMachineReportQuantumNeo_vue_vue_type_template_id_4f0cdf58___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/TableQtmMachineReportQuantumNeo.vue?vue&type=template&id=4f0cdf58& ***!
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
    _c("table", { staticClass: "table table-bordered table-sticky mb-0" }, [
      _vm._m(0),
      _vm._v(" "),
      _vm.reportQuantumNeoItems.length > 0
        ? _c(
            "tbody",
            [
              _vm._l(_vm.reportQuantumNeoItems, function(reportDate, indexD) {
                return [
                  _vm._l(reportDate.report_datetime_items, function(
                    reportDateTime,
                    indexT
                  ) {
                    return [
                      _vm._l(reportDateTime.report_items, function(
                        reportItem,
                        index
                      ) {
                        return [
                          _c(
                            "tr",
                            {
                              key: indexD + "_" + indexT + "_" + index,
                              attrs: { clsss: "tw-text-xs" }
                            },
                            [
                              reportDate.first_sample_no ==
                                reportItem.sample_no &&
                              reportDate.first_test_code ==
                                reportItem.result.test_code
                                ? _c(
                                    "td",
                                    {
                                      staticClass: "text-center",
                                      staticStyle: {
                                        "vertical-align": "top !important"
                                      },
                                      attrs: { rowspan: reportDate.count_items }
                                    },
                                    [
                                      _vm._v(
                                        " \n                                " +
                                          _vm._s(
                                            reportItem.date_drawn_formatted
                                          ) +
                                          " \n                            "
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              reportDateTime.first_sample_no ==
                                reportItem.sample_no &&
                              reportDateTime.first_test_code ==
                                reportItem.result.test_code
                                ? _c(
                                    "td",
                                    {
                                      staticClass: "text-center",
                                      staticStyle: {
                                        "vertical-align": "top !important"
                                      },
                                      attrs: {
                                        rowspan: reportDateTime.count_items
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "  \n                                " +
                                          _vm._s(
                                            reportItem.time_drawn_formatted
                                          ) +
                                          " \n                            "
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " + _vm._s(reportItem.machine_set) + " "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(" " + _vm._s(reportItem.brand) + " ")
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " +
                                    _vm._s(reportItem.result.test_desc) +
                                    " "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      reportItem.result.result_value != null
                                        ? parseFloat(
                                            reportItem.result.result_value
                                          )
                                        : ""
                                    ) +
                                    " "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " +
                                    _vm._s(reportItem.result.test_unit) +
                                    " "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      reportItem.result.min_value
                                        ? parseFloat(
                                            reportItem.result.min_value
                                          )
                                        : ""
                                    ) +
                                    " "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      reportItem.result.max_value
                                        ? parseFloat(
                                            reportItem.result.max_value
                                          )
                                        : ""
                                    ) +
                                    " "
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  " " + _vm._s(reportItem.result_status_label)
                                )
                              ])
                            ]
                          )
                        ]
                      })
                    ]
                  })
                ]
              })
            ],
            2
          )
        : _c("tbody", [_vm._m(1)])
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
        _c("th", { staticClass: "text-center", attrs: { width: "7%" } }, [
          _vm._v(" วันที่ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } }, [
          _vm._v(" เวลา ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "7%" } }, [
          _vm._v(" หมายเลขเครื่อง ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "10%" } }, [
          _vm._v(" บุหรี่ / ก้นกรอง ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "10%" } }, [
          _vm._v(" ชื่อการทดสอบ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "7%" } }, [
          _vm._v(" ผลการทดสอบ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } }, [
          _vm._v(" หน่วยนับ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "7%" } }, [
          _vm._v(" ค่าควบคุม-Min ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "7%" } }, [
          _vm._v(" ค่าควบคุม-Max ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } }, [
          _vm._v(" ผลการตรวจ ")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "12" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" ไม่พบข้อมูล ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);