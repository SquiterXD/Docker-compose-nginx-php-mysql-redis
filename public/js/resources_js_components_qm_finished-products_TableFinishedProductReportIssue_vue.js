(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_finished-products_TableFinishedProductReportIssue_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["queryStringSearchInputs", "reportMachineSets", "reportQmProcesses", "reportQmProcessCheckLists", "reportItems"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      isLoading: false
    };
  },
  methods: {
    getSumResultValue: function getSumResultValue(checkListCode, reportItemResults) {
      var foundResult = reportItemResults.find(function (item) {
        return item.check_list_code == checkListCode;
      });
      var result = foundResult ? foundResult.count_result_value ? foundResult.count_result_value : null : null;
      return result;
    },
    getAllTotalSumResultValue: function getAllTotalSumResultValue(reportQmProcessCheckLists) {
      var result = reportQmProcessCheckLists.reduce(function (accA, reportQmProcessCheckList) {
        return accA + reportQmProcessCheckList.total_count_result_value;
      }, 0);
      return result;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableFinishedProductReportIssue_vue_vue_type_template_id_2b45925e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e& */ "./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e&");
/* harmony import */ var _TableFinishedProductReportIssue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableFinishedProductReportIssue.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableFinishedProductReportIssue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableFinishedProductReportIssue_vue_vue_type_template_id_2b45925e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableFinishedProductReportIssue_vue_vue_type_template_id_2b45925e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductReportIssue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableFinishedProductReportIssue.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductReportIssue_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductReportIssue_vue_vue_type_template_id_2b45925e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductReportIssue_vue_vue_type_template_id_2b45925e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductReportIssue_vue_vue_type_template_id_2b45925e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductReportIssue.vue?vue&type=template&id=2b45925e& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
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
    _c(
      "table",
      {
        staticClass: "table table-bordered tw-text-xs",
        staticStyle: { "min-width": "1400px" }
      },
      [
        _c("thead", [
          _c(
            "tr",
            [
              _c(
                "th",
                {
                  staticClass: "text-center",
                  staticStyle: { "min-width": "100px", "max-width": "100px" }
                },
                [_vm._v(" กระบวนการผลิต ")]
              ),
              _vm._v(" "),
              _vm._l(_vm.reportQmProcesses, function(
                reportQmProcess,
                indexQMP
              ) {
                return [
                  _c(
                    "th",
                    {
                      key: indexQMP,
                      staticClass: "text-center",
                      attrs: { colspan: reportQmProcess.count_check_lists }
                    },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(reportQmProcess.qm_process) +
                          "\n                    "
                      )
                    ]
                  )
                ]
              }),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "text-center",
                  staticStyle: { "min-width": "100px", "max-width": "100px" },
                  attrs: { rowspan: "2" }
                },
                [_vm._v(" รวม ")]
              )
            ],
            2
          ),
          _vm._v(" "),
          _c(
            "tr",
            [
              _c(
                "th",
                {
                  staticClass: "text-center",
                  staticStyle: { "min-width": "100px", "max-width": "100px" }
                },
                [_vm._v(" รายการตรวจ / หมายเลขเครื่อง ")]
              ),
              _vm._v(" "),
              _vm._l(_vm.reportQmProcessCheckLists, function(
                reportQmProcessCheckList,
                indexCL
              ) {
                return [
                  _c(
                    "th",
                    {
                      key: indexCL,
                      staticClass: "text-center",
                      staticStyle: { "min-width": "60px" }
                    },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(reportQmProcessCheckList.check_list) +
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
        _vm.reportMachineSets.length > 0
          ? _c(
              "tbody",
              [
                _vm._l(_vm.reportMachineSets, function(
                  reportMachineSet,
                  indexM
                ) {
                  return [
                    _c(
                      "tr",
                      { key: "" + indexM },
                      [
                        _c(
                          "td",
                          { key: "" + indexM, staticClass: "text-center" },
                          [
                            _vm._v(
                              " " + _vm._s(reportMachineSet.machine_set) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _vm._l(_vm.reportItems, function(reportItem, index) {
                          return [
                            reportItem.machine_set ==
                            reportMachineSet.machine_set
                              ? [
                                  reportItem.results.length > 0
                                    ? [
                                        _vm._l(
                                          _vm.reportQmProcessCheckLists,
                                          function(
                                            reportQmProcessCheckList,
                                            indexCL
                                          ) {
                                            return [
                                              _vm.getSumResultValue(
                                                reportQmProcessCheckList.check_list_code,
                                                reportItem.results
                                              )
                                                ? _c(
                                                    "td",
                                                    {
                                                      key:
                                                        indexM +
                                                        "_" +
                                                        index +
                                                        "_" +
                                                        indexCL,
                                                      staticClass:
                                                        "text-center tw-font-bold",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#fff0a0"
                                                      }
                                                    },
                                                    [
                                                      _c(
                                                        "a",
                                                        {
                                                          attrs: {
                                                            href:
                                                              "/qm/finished-products/report-issue-details?" +
                                                              _vm.queryStringSearchInputs +
                                                              "&machine_set=" +
                                                              reportItem.machine_set +
                                                              "&qm_process_seq=" +
                                                              reportQmProcessCheckList.qm_process_seq +
                                                              "&check_list_code=" +
                                                              reportQmProcessCheckList.check_list_code,
                                                            target: "_blank"
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                            " +
                                                              _vm._s(
                                                                _vm.getSumResultValue(
                                                                  reportQmProcessCheckList.check_list_code,
                                                                  reportItem.results
                                                                )
                                                              ) +
                                                              "\n                                        "
                                                          )
                                                        ]
                                                      )
                                                    ]
                                                  )
                                                : _c(
                                                    "td",
                                                    {
                                                      key:
                                                        indexM +
                                                        "_" +
                                                        index +
                                                        "_" +
                                                        indexCL,
                                                      staticClass: "text-center"
                                                    },
                                                    [
                                                      _vm._v(
                                                        " \n                                        -\n                                    "
                                                      )
                                                    ]
                                                  )
                                            ]
                                          }
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            key:
                                              indexM + "_" + index + "_total",
                                            staticClass: "text-center"
                                          },
                                          [
                                            _vm._v(
                                              " " +
                                                _vm._s(
                                                  reportItem.total_count_result_value
                                                    ? reportItem.total_count_result_value
                                                    : "-"
                                                ) +
                                                " "
                                            )
                                          ]
                                        )
                                      ]
                                    : [
                                        _vm._l(
                                          _vm.reportQmProcessCheckLists,
                                          function(
                                            reportQmProcessCheckList,
                                            indexCL
                                          ) {
                                            return [
                                              _c(
                                                "td",
                                                {
                                                  key:
                                                    indexM +
                                                    "_" +
                                                    index +
                                                    "_" +
                                                    indexCL,
                                                  staticClass: "text-center"
                                                },
                                                [_c("span", [_vm._v(" - ")])]
                                              )
                                            ]
                                          }
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            key:
                                              indexM + "_" + index + "_total",
                                            staticClass: "text-center"
                                          },
                                          [_vm._v(" - ")]
                                        )
                                      ]
                                ]
                              : _vm._e()
                          ]
                        })
                      ],
                      2
                    )
                  ]
                }),
                _vm._v(" "),
                _c(
                  "tr",
                  [
                    _c("td", { staticClass: "text-center tw-font-bold" }, [
                      _vm._v(" รวม ")
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.reportQmProcessCheckLists, function(
                      reportQmProcessCheckList,
                      indexSummaryCL
                    ) {
                      return [
                        _c(
                          "td",
                          {
                            key: "" + indexSummaryCL,
                            staticClass: "text-center tw-font-bold"
                          },
                          [
                            _vm._v(
                              " \n                        " +
                                _vm._s(
                                  reportQmProcessCheckList.total_count_result_value
                                ) +
                                "\n                    "
                            )
                          ]
                        )
                      ]
                    }),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(
                        " " +
                          _vm._s(
                            _vm.getAllTotalSumResultValue(
                              _vm.reportQmProcessCheckLists
                            )
                          ) +
                          " "
                      )
                    ])
                  ],
                  2
                )
              ],
              2
            )
          : _c("tbody", [_vm._m(0)])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "13" } }, [
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