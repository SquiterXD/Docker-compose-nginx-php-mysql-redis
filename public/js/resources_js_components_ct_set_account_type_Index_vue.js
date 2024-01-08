(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_set_account_type_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/set_account_type/Index.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/set_account_type/Index.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      period_year: 'all',
      tableData: [],
      ccGroups: [],
      accountType: [],
      checked: 1,
      value: "",
      loading: false,
      option: {
        fiscal_year: []
      },
      loadingInput: {}
    };
  },
  mounted: function mounted() {
    this.getAccountDeptV();
    this.getDropdownAccountType();
    this.getPeriodYears();
  },
  methods: {
    updateAccountType: function updateAccountType(row) {
      var _this = this;

      axios.post("/ct/ajax/account_dept_v", row).then(function (res) {
        _this.$message({
          showClose: true,
          message: 'อัพเดตสำเร็จ',
          type: 'success'
        });
      })["catch"](function (err) {
        console.log(err.response.data);

        _this.$message({
          showClose: true,
          message: 'อัพเดตไม่สำเร็จ',
          type: 'error'
        });
      });
    },
    selectPeriodYear: function selectPeriodYear() {
      var period_year = this.period_year;

      if (period_year == 'all') {
        this.getAccountDeptV();
      } else {
        var query = "?period_year=".concat(period_year);
        this.getAccountDeptV(query);
      }
    },
    getPeriodYears: function getPeriodYears(query) {
      var _this2 = this;

      this.loadingInput.fiscal_year = true;
      axios.get("/ct/ajax/year-view", {
        params: {
          text: query
        }
      }).then(function (res) {
        _this2.option.fiscal_year = res.data;
      });
      this.loadingInput.fiscal_year = false;
    },
    getDropdownAccountType: function getDropdownAccountType() {
      var _this3 = this;

      axios.get("/ct/ajax/account_type").then(function (res) {
        _this3.accountType = res.data;
      })["catch"](function (err) {
        console.log(err.response.data);
      });
    },
    getAccountDeptV: function getAccountDeptV() {
      var _this4 = this;

      var query = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      this.loading = true;
      axios.get("/ct/ajax/account_dept_v".concat(query)).then(function (res) {
        _this4.tableData = res.data.data;
      })["catch"](function (err) {
        console.log(err.response.data);
      }).then(function () {
        _this4.loading = false;
      });
    },
    getListSetAccountType: function getListSetAccountType() {
      var $this = this;
      axios.get('/ct/ajax/set_account_type').then(function (response) {
        $this.tableData = response.data;
      })["catch"](function (error) {
        console.log('error: ', error);
      });
    },
    getCcGroups: function getCcGroups() {
      var $this = this;
      axios.get('/ct/ajax/cc_group').then(function (response) {
        $this.ccGroups = response.data;
      })["catch"](function (error) {
        console.log('error: ', error);
      });
    },
    convertBoolean: function convertBoolean(value) {
      if (value == 'Y') {
        return true;
      } else if (value == 'N') {
        return false;
      }
    },
    checkboxOnChange: function checkboxOnChange(val, row) {
      // row.is_transfer = val;
      if (val) {
        row.transfer_account_flag = 'Y';
      } else {
        row.transfer_account_flag = 'N';
      }

      this.updateAccountType(row);
    },
    update: function update(row) {
      var _this5 = this;

      axios.post('/ct/ajax/set_account_type/update', {
        acc_code: row.acc_code,
        acc_group: row.acc_group,
        is_transfer: row.is_transfer
      }).then(function (response) {
        _this5.$message({
          showClose: true,
          message: 'บันทึกสำเร็จ',
          type: 'success'
        });
      })["catch"](function (error) {
        this.$message({
          showClose: true,
          message: 'ไม่สามารถบันทึกได้',
          type: 'error'
        });
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ct/set_account_type/Index.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/ct/set_account_type/Index.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_013236e2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=013236e2& */ "./resources/js/components/ct/set_account_type/Index.vue?vue&type=template&id=013236e2&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/set_account_type/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_013236e2___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_013236e2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/set_account_type/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/set_account_type/Index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/ct/set_account_type/Index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/set_account_type/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/set_account_type/Index.vue?vue&type=template&id=013236e2&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ct/set_account_type/Index.vue?vue&type=template&id=013236e2& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_013236e2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_013236e2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_013236e2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=013236e2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/set_account_type/Index.vue?vue&type=template&id=013236e2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/set_account_type/Index.vue?vue&type=template&id=013236e2&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/set_account_type/Index.vue?vue&type=template&id=013236e2& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
      ],
      staticClass: "container"
    },
    [
      _c("div", { staticClass: " row" }, [
        _c(
          "div",
          { staticClass: "col-md-4 flex-wrap form-group" },
          [
            _c("label", { staticClass: "col-form-label" }, [
              _vm._v("ปีงบประมาณ")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: { placeholder: "ปีงบประมาณ" },
                on: {
                  change: function($event) {
                    return _vm.selectPeriodYear()
                  }
                },
                model: {
                  value: _vm.period_year,
                  callback: function($$v) {
                    _vm.period_year = $$v
                  },
                  expression: "period_year"
                }
              },
              [
                _c("el-option", { attrs: { label: "ทั้งหมด", value: "all" } }),
                _vm._v(" "),
                _vm._l(_vm.option.fiscal_year, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: item.year_thai, value: item.period_year }
                  })
                })
              ],
              2
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row justify-content-center" }, [
        _c(
          "div",
          { staticClass: "col-12" },
          [
            [
              _c(
                "el-table",
                {
                  staticStyle: { width: "100%" },
                  attrs: { data: _vm.tableData }
                },
                [
                  _c("el-table-column", {
                    attrs: {
                      prop: "acc_code",
                      label: "รหัสบัญชี",
                      width: "180"
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      prop: "sub_acc_code",
                      label: "รหัสบัญชีย่อย",
                      width: "180"
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { label: "ชื่อบัญชี", width: "180" },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c("div", [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    scope.row.acc_desc +
                                      " " +
                                      (scope.row.sub_acc_desc || "")
                                  ) +
                                  "\n                            "
                              )
                            ])
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      prop: "account_type_desc",
                      label: "ประเภทบัญชี",
                      align: "center"
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  placeholder: "Select"
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.updateAccountType(scope.row)
                                  }
                                },
                                model: {
                                  value:
                                    _vm.tableData[scope.$index].account_type,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.tableData[scope.$index],
                                      "account_type",
                                      $$v
                                    )
                                  },
                                  expression:
                                    "tableData[scope.$index].account_type"
                                }
                              },
                              _vm._l(_vm.accountType, function(item) {
                                return _c("el-option", {
                                  key: item.value,
                                  attrs: {
                                    label: item.label,
                                    value: item.value
                                  }
                                })
                              }),
                              1
                            )
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      prop: "transfer_account_flag",
                      label: "บัญชีรับโอน",
                      align: "center"
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c("el-checkbox", {
                              attrs: {
                                "v-model":
                                  _vm.tableData[scope.$index]
                                    .transfer_account_flag,
                                checked: _vm.convertBoolean(
                                  _vm.tableData[scope.$index]
                                    .transfer_account_flag
                                )
                              },
                              on: {
                                change: function($event) {
                                  return _vm.checkboxOnChange($event, scope.row)
                                }
                              }
                            })
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      prop: "address",
                      label: "กำหนดหน่วยงาน",
                      align: "center"
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c(
                              "a",
                              {
                                attrs: {
                                  href:
                                    "/ct/set_account_type_dept/" +
                                    scope.row.acc_code +
                                    "?sub_acc_code=" +
                                    scope.row.sub_acc_code
                                }
                              },
                              [
                                _c(
                                  "el-button",
                                  { attrs: { type: "primary" } },
                                  [
                                    _vm._v(
                                      "หน่วยงาน\n                                "
                                    )
                                  ]
                                )
                              ],
                              1
                            )
                          ]
                        }
                      }
                    ])
                  })
                ],
                1
              )
            ]
          ],
          2
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);