(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_calculate-insurance_index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/calculate-insurance/index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/calculate-insurance/index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/calendar/dateInput */ "./resources/js/components/ir/components/calendar/dateInput.vue");
/* harmony import */ var _components_calendar_yearInput__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/calendar/yearInput */ "./resources/js/components/ir/components/calendar/yearInput.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    dateInput: _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_0__.default,
    yearInput: _components_calendar_yearInput__WEBPACK_IMPORTED_MODULE_1__.default
  },
  name: 'ir-calculate-insurance-index',
  props: ['policyLists', 'companyLists', 'yearLists', 'effectDateLists'],
  data: function data() {
    return {
      loading: false,
      disableForm: false,
      disableReport: false,
      disableInterface: true,
      amountInReport: 0,
      dateStart: '',
      dateEnd: '',
      invoiceDate: '',
      invalidInvoiceDate: false,
      batchNo: '',
      invalidBatchNo: false,
      year: 0,
      insuranceNo: '',
      company: '',
      pickerOptions: {
        disabledDate: this.pickerYearOptions
      }
    };
  },
  created: function created() {
    var currentYear = new Date().getFullYear();
    var cycle = new Date(currentYear, 8, 30); // month start at 0

    var now = new Date();
    var offset = now.getTime() > cycle.getTime() ? 544 : 543;
    this.year = (currentYear + offset).toString();
    this.dateStart = '30/09/' + (currentYear + offset - 1);
    this.dateEnd = '30/09/' + (currentYear + offset);
  },
  methods: {
    pickerYearOptions: function pickerYearOptions(time) {
      return !this.yearLists.includes(time.getFullYear());
    },
    callReport: function callReport() {
      var vm = this;
      vm.loading = true;
      axios.post('/ir/calculate-insurance/check-report', {
        company: vm.company,
        insuranceNo: vm.insuranceNo,
        year: vm.year,
        dateStart: vm.dateStart,
        dateEnd: vm.dateEnd
      }).then(function (response) {
        if (response.data.status == 'C') {
          vm.amountInReport = response.data.amount;
          vm.printReport();
        } else {
          swal({
            html: true,
            title: 'Error',
            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">' + response.data.msg + '</span></h2>'
          });
        }
      })["catch"](function (error) {}).then(function () {
        vm.loading = false;
      });
    },
    printReport: function printReport() {
      var vm = this;
      var url = "/ir/calculate-insurance/report?company=" + vm.company + "&insuranceNo=" + vm.insuranceNo + "&year=" + vm.year + "&dateStart=" + vm.dateStart + "&dateEnd=" + vm.dateEnd;
      window.open(url, "_blank");
      vm.disableInterface = false;
      vm.disableForm = vm.disableReport = true;
    },
    clickInterface: function clickInterface() {
      var vm = this;
      var check = true;
      vm.invalidBatchNo = false;
      vm.invalidInvoiceDate = false;

      if (vm.amountInReport >= 0) {
        if (!vm.batchNo) {
          vm.invalidBatchNo = true;
          check = false;
        }
      }

      if (!vm.invoiceDate) {
        vm.invalidInvoiceDate = true;
        check = false;
      }

      if (check) {
        vm.loading = true;
        axios.post('/ir/calculate-insurance/interface', {
          company: vm.company,
          insuranceNo: vm.insuranceNo,
          year: vm.year,
          dateStart: vm.dateStart,
          dateEnd: vm.dateEnd,
          invoiceDate: vm.invoiceDate,
          invoiceBatch: vm.batchNo
        }).then(function (response) {
          if (response.data.status == 'S') {
            swal({
              html: true,
              title: 'Success',
              text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">Interface Complete</span></h2>'
            });
            vm.disableInterface = true;
          } else {
            swal({
              html: true,
              title: 'Error',
              text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px">' + response.data.msg + '</span></h2>'
            });
          }
        })["catch"](function (error) {}).then(function () {
          vm.loading = false;
        });
      }
    },
    clickCancel: function clickCancel() {
      var vm = this;
      vm.insuranceNo = '', vm.dateStart = '';
      vm.dateEnd = '';
      vm.year = (new Date().getFullYear() + 543).toString();
    },
    handleChange: function handleChange() {},
    getDateStart: function getDateStart(obj) {
      var vm = this;
      vm.dateStart = obj.value;
    },
    getDateEnd: function getDateEnd(obj) {
      var vm = this;
      vm.dateEnd = obj.value;
    },
    getinvoiceDate: function getinvoiceDate(obj) {
      var vm = this;
      vm.invoiceDate = obj.value;
    },
    getYear: function getYear(obj) {
      var vm = this;
      var y = obj.getFullYear() - 543;
      var efDate = vm.effectDateLists.find(function (date, index) {
        if (date.lookup_code == y) return true;
      });
      var startDate = new Date(efDate.start_date_active);
      vm.year = obj.getFullYear().toString();
      vm.dateStart = ("0" + startDate.getDate()).slice(-2) + '/' + ("0" + (startDate.getMonth() + 1)).slice(-2) + '/' + (startDate.getFullYear() + 543);
      vm.dateEnd = ("0" + startDate.getDate()).slice(-2) + '/' + ("0" + (startDate.getMonth() + 1)).slice(-2) + '/' + (startDate.getFullYear() + 544);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/calculate-insurance/index.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/ir/calculate-insurance/index.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _index_vue_vue_type_template_id_1cea3d4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=1cea3d4a& */ "./resources/js/components/ir/calculate-insurance/index.vue?vue&type=template&id=1cea3d4a&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/calculate-insurance/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _index_vue_vue_type_template_id_1cea3d4a___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_1cea3d4a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/calculate-insurance/index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/calculate-insurance/index.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/ir/calculate-insurance/index.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/calculate-insurance/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/calculate-insurance/index.vue?vue&type=template&id=1cea3d4a&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/ir/calculate-insurance/index.vue?vue&type=template&id=1cea3d4a& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1cea3d4a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1cea3d4a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1cea3d4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=1cea3d4a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/calculate-insurance/index.vue?vue&type=template&id=1cea3d4a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/calculate-insurance/index.vue?vue&type=template&id=1cea3d4a&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/calculate-insurance/index.vue?vue&type=template&id=1cea3d4a& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "row my-3" }, [
        _c("div", { staticClass: "col-md-4" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-4" },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  placeholder: "บริษัท",
                  clearable: "",
                  disabled: _vm.disableForm
                },
                model: {
                  value: _vm.company,
                  callback: function($$v) {
                    _vm.company = $$v
                  },
                  expression: "company"
                }
              },
              _vm._l(_vm.companyLists, function(item) {
                return _c("el-option", {
                  key: item.company_number,
                  attrs: {
                    label: item.company_name,
                    value: item.company_number
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
      _c("div", { staticClass: "row my-3" }, [
        _c("div", { staticClass: "col-md-4" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-2" },
          [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  placeholder: "กรมธรรม์ชุดที่",
                  clearable: "",
                  disabled: _vm.disableForm
                },
                model: {
                  value: _vm.insuranceNo,
                  callback: function($$v) {
                    _vm.insuranceNo = $$v
                  },
                  expression: "insuranceNo"
                }
              },
              _vm._l(_vm.policyLists, function(item) {
                return _c("el-option", {
                  key: item.policy_set_header_id,
                  attrs: {
                    label:
                      item.policy_set_number +
                      " : " +
                      item.policy_set_description,
                    value: item.policy_set_header_id
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
          { staticClass: "col-md-2" },
          [
            _vm._m(2),
            _vm._v(" "),
            _c("el-date-picker", {
              staticClass: "w-100 text-center",
              attrs: {
                "picker-options": _vm.pickerOptions,
                clearable: false,
                type: "year",
                placeholder: "ปี",
                disabled: _vm.disableForm
              },
              on: { change: _vm.getYear },
              model: {
                value: _vm.year,
                callback: function($$v) {
                  _vm.year = $$v
                },
                expression: "year"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row my-3" }, [
        _c("div", { staticClass: "col-md-4" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-2" },
          [
            _vm._m(3),
            _vm._v(" "),
            _c("date-input", {
              attrs: {
                attrName: "start_date",
                sizeSmall: false,
                value: _vm.dateStart,
                disabled: true,
                placeholder: "วันที่คุ้มครอง"
              },
              on: { "change-date": _vm.getDateStart },
              model: {
                value: _vm.dateStart,
                callback: function($$v) {
                  _vm.dateStart = $$v
                },
                expression: "dateStart"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-2" },
          [
            _vm._m(4),
            _vm._v(" "),
            _c("date-input", {
              attrs: {
                attrName: "start_end",
                sizeSmall: false,
                value: _vm.dateEnd,
                disabled: true,
                placeholder: "ถึง"
              },
              on: { "change-date": _vm.getDateEnd },
              model: {
                value: _vm.dateEnd,
                callback: function($$v) {
                  _vm.dateEnd = $$v
                },
                expression: "dateEnd"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-12 padding_12 text-center" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-info m-1",
              attrs: { disabled: _vm.disableReport },
              on: {
                click: function($event) {
                  return _vm.callReport()
                }
              }
            },
            [_c("i", { staticClass: "fa fa-file" }), _vm._v(" Print Report")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn m-1",
              staticStyle: {
                color: "#fff",
                "background-color": "#13abad",
                "border-color": "#13abad"
              },
              attrs: {
                disabled: _vm.disableInterface,
                "data-toggle": "modal",
                "data-target": "#modal-interface"
              }
            },
            [
              _c("i", { staticClass: "fa fa-exchange" }),
              _vm._v(" \n                Interface\n            ")
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-danger m-1",
              on: {
                click: function($event) {
                  return _vm.clickCancel()
                }
              }
            },
            [_c("i", { staticClass: "fa fa-times" }), _vm._v(" Cancel")]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "modal fade",
          attrs: { id: "modal-interface", "aria-hidden": "true" }
        },
        [
          _c("div", { staticClass: "modal-dialog pt-0 modal-lg" }, [
            _c("div", { staticClass: "modal-content" }, [
              _c("div", { staticClass: "modal-body" }, [
                _c("div", { staticClass: "m-l-xs m-r-lg mm-xs" }, [
                  _c("div", { staticClass: "row my-3" }, [
                    _vm._m(5),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-5" },
                      [
                        _vm.invalidInvoiceDate
                          ? _c("span", { staticClass: "text-danger" }, [
                              _vm._v("required")
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("date-input", {
                          attrs: {
                            attrName: "invoice_date",
                            sizeSmall: false,
                            value: _vm.invoiceDate,
                            placeholder: "วันที่คุ้มครอง"
                          },
                          on: { "change-date": _vm.getinvoiceDate },
                          model: {
                            value: _vm.invoiceDate,
                            callback: function($$v) {
                              _vm.invoiceDate = $$v
                            },
                            expression: "invoiceDate"
                          }
                        })
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "row my-3" }, [
                    _c(
                      "label",
                      { staticClass: "col-md-4 col-form-label lable_align" },
                      [
                        _c("strong", [
                          _vm._v("Invoice Batch "),
                          _vm.amountInReport >= 0
                            ? _c("span", { staticClass: "text-danger" }, [
                                _vm._v("*")
                              ])
                            : _vm._e()
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-5" },
                      [
                        _vm.invalidBatchNo
                          ? _c("span", { staticClass: "text-danger" }, [
                              _vm._v("required")
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("el-input", {
                          attrs: {
                            placeholder: "Invoice Batch",
                            disabled: _vm.amountInReport < 0
                          },
                          model: {
                            value: _vm.batchNo,
                            callback: function($$v) {
                              _vm.batchNo = $$v
                            },
                            expression: "batchNo"
                          }
                        })
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("hr", { staticClass: "m-t-sm m-b-sm" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-sm-12 text-right" }, [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-danger",
                          attrs: { type: "button", "data-dismiss": "modal" }
                        },
                        [_vm._v("Cancel")]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          attrs: { type: "button", "data-dismiss": "modal" },
                          on: {
                            click: function($event) {
                              return _vm.clickInterface()
                            }
                          }
                        },
                        [_vm._v("Confirm")]
                      )
                    ])
                  ])
                ])
              ])
            ])
          ])
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("strong", [_vm._v("บริษัท")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("strong", [_vm._v("กรมธรรม์ชุดที่")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("strong", [_vm._v("ปี")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("strong", [_vm._v("วันที่คุ้มครอง")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("strong", [_vm._v("ถึง")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-md-4 col-form-label lable_align" }, [
      _c("strong", [
        _vm._v("วันที่ใบแจ้งหนี้ "),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);