(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_specify_agency_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_agency/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_agency/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      loading: false,
      agency: "",
      agency_data: [],
      activeName: "under_part",
      agency_options: [{
        code: "11990000",
        name: "สำนักงานโครงการย้ายโรงงานผลิตยาสูบ"
      }, {
        code: "12000100",
        name: "ศูนย์ป้องบุหรี่ปลอมแปลงและบุหรีลักลอบ"
      }, {
        code: "12000101",
        name: "งานด้านแผนงานและวิชาการ"
      }, {
        code: "12000102",
        name: "งานด้านปฏิบัติการ"
      }, {
        code: "12000200",
        name: "สำนักคุณภาพความปลอดภัยและสิ่งแวดล้อม"
      }, {
        code: "12000300",
        name: "หน่วยธุรการ สำนักงานโครงการย้ายโรงงานผลิตยาสูบ"
      }, {
        code: "12010000",
        name: "สำนักงบประมาณ"
      }],
      tableData: {
        tab_under_part: {
          agency_part: [{
            agency_code: "32030000",
            agency_name: "โรงยานยาสูบ 3"
          }, {
            agency_code: "32040000",
            agency_name: "โรงยานยาสูบ 4"
          }, {
            agency_code: "32050000",
            agency_name: "โรงยานยาสูบ 5"
          }],
          division: [{
            agency_code: "32050100",
            agency_name: "งานธุรการ โรงงานผลิตยาสูบ 4"
          }, {
            agency_code: "32050200",
            agency_name: "กองการใบยา รยส.5"
          }, {
            agency_code: "32050300",
            agency_name: "กองการมวนและบรรจุ รยส.5"
          }, {
            agency_code: "32050300",
            agency_name: "กองซ่อมบำรุง รยส.5"
          }]
        },
        tab_under_side: {
          division: [{
            agency_code: "32000300",
            agency_name: "กองการยาเส้นพอง"
          }, {
            agency_code: "32000100",
            agency_name: "กองธุรการ สำนักงานฝ่าย ฝ่ายผลิต"
          }, {
            agency_code: "32000200",
            agency_name: "กองการวางแผนและควบคุมการผลิต"
          }]
        }
      }
    };
  },
  created: function created() {
    this.getMasterData();
  },
  methods: {
    getMasterData: function getMasterData() {
      this.loading = true;
      this.getSetAccountTypeDeptData();
      this.loading = false;
    },
    getSetAccountTypeDeptData: function getSetAccountTypeDeptData() {
      this.agency_data = [{
        code: "01",
        name: "ผ่ายผลิต"
      }];
    },
    selectSetAccountTypeDept: function selectSetAccountTypeDept() {},
    handleClick: function handleClick(tab, event) {
      console.log(tab, event);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ct/specify_agency/Index.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/ct/specify_agency/Index.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_6a2e2ca9_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=6a2e2ca9&scoped=true& */ "./resources/js/components/ct/specify_agency/Index.vue?vue&type=template&id=6a2e2ca9&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/specify_agency/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_6a2e2ca9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_6a2e2ca9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "6a2e2ca9",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/specify_agency/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/specify_agency/Index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/ct/specify_agency/Index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_agency/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/specify_agency/Index.vue?vue&type=template&id=6a2e2ca9&scoped=true&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/ct/specify_agency/Index.vue?vue&type=template&id=6a2e2ca9&scoped=true& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_6a2e2ca9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_6a2e2ca9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_6a2e2ca9_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=6a2e2ca9&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_agency/Index.vue?vue&type=template&id=6a2e2ca9&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_agency/Index.vue?vue&type=template&id=6a2e2ca9&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/specify_agency/Index.vue?vue&type=template&id=6a2e2ca9&scoped=true& ***!
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
      _c(
        "el-select",
        {
          attrs: { placeholder: "หน่วยงานฝ่าย" },
          on: { change: _vm.selectSetAccountTypeDept },
          model: {
            value: _vm.agency,
            callback: function($$v) {
              _vm.agency = $$v
            },
            expression: "agency"
          }
        },
        _vm._l(_vm.agency_data, function(item, index) {
          return _c("el-option", {
            key: index,
            attrs: { label: item.name, value: item.code }
          })
        }),
        1
      ),
      _vm._v(" "),
      _vm.agency
        ? _c(
            "div",
            { staticClass: "mt-4" },
            [
              _c(
                "el-tabs",
                {
                  attrs: { type: "card" },
                  on: { "tab-click": _vm.handleClick },
                  model: {
                    value: _vm.activeName,
                    callback: function($$v) {
                      _vm.activeName = $$v
                    },
                    expression: "activeName"
                  }
                },
                [
                  _c(
                    "el-tab-pane",
                    { attrs: { label: "กองภายใต้ส่วน", name: "under_part" } },
                    [
                      _c(
                        "div",
                        { staticClass: "mt-4" },
                        [
                          _c("label", [
                            _vm._v(
                              "\n                        หน่วยงานส่วน\n                    "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "el-table",
                            {
                              staticStyle: { width: "100%" },
                              attrs: {
                                border: "",
                                data: _vm.tableData.tab_under_part.agency_part
                              }
                            },
                            [
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency_code",
                                  label: "หน่วยงานส่วน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c("el-input", {
                                            staticStyle: { width: "100%" },
                                            attrs: {
                                              type: "text",
                                              controls: false,
                                              placeholder: "หน่วยงานส่วน"
                                            },
                                            model: {
                                              value: scope.row.agency_code,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  scope.row,
                                                  "agency_code",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "scope.row.agency_code"
                                            }
                                          })
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  4136284753
                                )
                              }),
                              _vm._v(" "),
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency_name",
                                  label: "ชื่อหน่วยงาน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c("el-input", {
                                            staticStyle: { width: "100%" },
                                            attrs: {
                                              type: "text",
                                              controls: false,
                                              placeholder: "หน่วยงานส่วน"
                                            },
                                            model: {
                                              value: scope.row.agency_name,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  scope.row,
                                                  "agency_name",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "scope.row.agency_name"
                                            }
                                          })
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  481528731
                                )
                              }),
                              _vm._v(" "),
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency",
                                  label: "หน่วยงาน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c(
                                            "el-select",
                                            {
                                              staticStyle: { width: "100%" },
                                              attrs: {
                                                filterable: "",
                                                placeholder: "หน่วยงาน",
                                                multiple: ""
                                              },
                                              model: {
                                                value: scope.row.agency,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    scope.row,
                                                    "agency",
                                                    $$v
                                                  )
                                                },
                                                expression: "scope.row.agency"
                                              }
                                            },
                                            _vm._l(_vm.agency_options, function(
                                              item,
                                              index
                                            ) {
                                              return _c("el-option", {
                                                key: index,
                                                attrs: {
                                                  label: item.name,
                                                  value: item.code
                                                }
                                              })
                                            }),
                                            1
                                          )
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  909401329
                                )
                              })
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "mt-4" },
                        [
                          _c("label", [
                            _vm._v(
                              "\n                        หน่วยงานกอง\n                    "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "el-table",
                            {
                              staticStyle: { width: "100%" },
                              attrs: {
                                border: "",
                                data: _vm.tableData.tab_under_part.division
                              }
                            },
                            [
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency_code",
                                  label: "หน่วยงานกอง",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c("el-input", {
                                            staticStyle: { width: "100%" },
                                            attrs: {
                                              type: "text",
                                              controls: false,
                                              placeholder: "หน่วยงานส่วน"
                                            },
                                            model: {
                                              value: scope.row.agency_code,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  scope.row,
                                                  "agency_code",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "scope.row.agency_code"
                                            }
                                          })
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  4136284753
                                )
                              }),
                              _vm._v(" "),
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency_name",
                                  label: "ชื่อหน่วยงาน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c("el-input", {
                                            staticStyle: { width: "100%" },
                                            attrs: {
                                              type: "text",
                                              controls: false,
                                              placeholder: "ชื่อหน่วยงาน"
                                            },
                                            model: {
                                              value: scope.row.agency_name,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  scope.row,
                                                  "agency_name",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "scope.row.agency_name"
                                            }
                                          })
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  4060935807
                                )
                              }),
                              _vm._v(" "),
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency",
                                  label: "หน่วยงาน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c(
                                            "el-select",
                                            {
                                              staticStyle: { width: "100%" },
                                              attrs: {
                                                filterable: "",
                                                placeholder: "หน่วยงาน",
                                                multiple: ""
                                              },
                                              model: {
                                                value: scope.row.agency,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    scope.row,
                                                    "agency",
                                                    $$v
                                                  )
                                                },
                                                expression: "scope.row.agency"
                                              }
                                            },
                                            _vm._l(_vm.agency_options, function(
                                              item,
                                              index
                                            ) {
                                              return _c("el-option", {
                                                key: index,
                                                attrs: {
                                                  label: item.name,
                                                  value: item.code
                                                }
                                              })
                                            }),
                                            1
                                          )
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  909401329
                                )
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-tab-pane",
                    { attrs: { label: "กองภายใต้ผ่าย", name: "under_side" } },
                    [
                      _c(
                        "div",
                        { staticClass: "mt-4" },
                        [
                          _c("label", [
                            _vm._v(
                              "\n                        หน่วยงานกอง\n                    "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "el-table",
                            {
                              staticStyle: { width: "100%" },
                              attrs: {
                                border: "",
                                data: _vm.tableData.tab_under_side.division
                              }
                            },
                            [
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency_code",
                                  label: "หน่วยงานกอง",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c("el-input", {
                                            staticStyle: { width: "100%" },
                                            attrs: {
                                              type: "text",
                                              controls: false,
                                              placeholder: "หน่วยงานส่วน"
                                            },
                                            model: {
                                              value: scope.row.agency_code,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  scope.row,
                                                  "agency_code",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "scope.row.agency_code"
                                            }
                                          })
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  4136284753
                                )
                              }),
                              _vm._v(" "),
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency_name",
                                  label: "ชื่อหน่วยงาน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c("el-input", {
                                            staticStyle: { width: "100%" },
                                            attrs: {
                                              type: "text",
                                              controls: false,
                                              placeholder: "ชื่อหน่วยงาน"
                                            },
                                            model: {
                                              value: scope.row.agency_name,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  scope.row,
                                                  "agency_name",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "scope.row.agency_name"
                                            }
                                          })
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  4060935807
                                )
                              }),
                              _vm._v(" "),
                              _c("el-table-column", {
                                attrs: {
                                  prop: "agency",
                                  label: "หน่วยงาน",
                                  align: "center"
                                },
                                scopedSlots: _vm._u(
                                  [
                                    {
                                      key: "default",
                                      fn: function(scope) {
                                        return [
                                          _c(
                                            "el-select",
                                            {
                                              staticStyle: { width: "100%" },
                                              attrs: {
                                                filterable: "",
                                                placeholder: "หน่วยงาน",
                                                multiple: ""
                                              },
                                              model: {
                                                value: scope.row.agency,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    scope.row,
                                                    "agency",
                                                    $$v
                                                  )
                                                },
                                                expression: "scope.row.agency"
                                              }
                                            },
                                            _vm._l(_vm.agency_options, function(
                                              item,
                                              index
                                            ) {
                                              return _c("el-option", {
                                                key: index,
                                                attrs: {
                                                  label: item.name,
                                                  value: item.code
                                                }
                                              })
                                            }),
                                            1
                                          )
                                        ]
                                      }
                                    }
                                  ],
                                  null,
                                  false,
                                  909401329
                                )
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]
                  )
                ],
                1
              )
            ],
            1
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);