(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_QualityAssurance_TableResultsComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['showqualityAssuranceLineList', 'showqualityAssuranceList', 'qualityAssuranceId'],
  data: function data() {
    return {
      lines: [],
      showqualityAssuranceLines: this.showqualityAssuranceLineList,
      is_loading: false,
      isBtnSave: false,
      checkKeyWord: true
    };
  },
  mounted: function mounted() {},
  methods: {
    addLine: function addLine() {
      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
        enabledFlag: true,
        tobaccoQTYchecklist: '',
        description: ''
      });
      this.checkKeyWord = false;
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);

      if (this.lines.length == 0) {
        this.checkKeyWord = true;
      }
    },
    saveDataToTable: function saveDataToTable() {
      var _this = this;

      var newLines = _objectSpread({}, this.lines);

      var headers = this.showqualityAssuranceList;
      var lines = this.showqualityAssuranceLines;
      var id = this.qualityAssuranceId;
      this.is_loading = true;

      if (Object.keys(newLines).length !== 0) {
        if (newLines[0].description != [] && newLines[0].tobaccoQTYchecklist != []) {
          return axios.post('/qm/ajax/quality-assurance/update', {
            newLines: newLines,
            headers: headers,
            lines: lines,
            id: id
          }).then(function (res) {
            console.log(res.data.status);

            if (res.data == "succeed") {
              swal({
                title: "Success !",
                text: "บันทึกสำเร็จ",
                type: "success",
                showConfirmButton: true
              });
              _this.is_loading = false;
              setTimeout(function () {
                window.location.reload(false);
              }, 3000);
            }

            if (res.data.status = "ERROR") {
              swal({
                title: "เกิดข้อผิดพลาก !",
                text: "เนื่องจาก " + res.data.err_msg,
                type: "error",
                showConfirmButton: true
              });
              _this.is_loading = false;
            }
          });
        } else {
          swal({
            title: "คำเตือน !",
            text: "ไม่สามารถบันทึกข้อมูลระดับ Line ได้เนื่องจากกรอกข้อมูลระดับ Line ยังไม่ครบถ้วน",
            type: "warning",
            showConfirmButton: true
          });
        }
      } else {
        return axios.post('/qm/ajax/quality-assurance/update', {
          newLines: newLines,
          headers: headers,
          lines: lines,
          id: id
        }).then(function (res) {
          if (res.data == "succeed") {
            swal({
              title: "Success !",
              text: "บันทึกสำเร็จ",
              type: "success",
              showConfirmButton: true
            });
            _this.is_loading = false;
            setTimeout(function () {
              window.location.reload(false);
            }, 3000);
          }

          if (res.data.status = "ERROR") {
            swal({
              title: "เกิดข้อผิดพลาก !",
              text: "เนื่องจาก " + res.data.err_msg,
              type: "error",
              showConfirmButton: true
            });
            _this.is_loading = false;
          }
        });
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableResultsComponent_vue_vue_type_template_id_8998ad68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableResultsComponent.vue?vue&type=template&id=8998ad68& */ "./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=template&id=8998ad68&");
/* harmony import */ var _TableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableResultsComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableResultsComponent_vue_vue_type_template_id_8998ad68___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableResultsComponent_vue_vue_type_template_id_8998ad68___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/QualityAssurance/TableResultsComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableResultsComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableResultsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=template&id=8998ad68&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=template&id=8998ad68& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableResultsComponent_vue_vue_type_template_id_8998ad68___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableResultsComponent_vue_vue_type_template_id_8998ad68___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableResultsComponent_vue_vue_type_template_id_8998ad68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableResultsComponent.vue?vue&type=template&id=8998ad68& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=template&id=8998ad68&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=template&id=8998ad68&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/QualityAssurance/TableResultsComponent.vue?vue&type=template&id=8998ad68& ***!
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
  return _c("div", { staticClass: "table-responsive" }, [
    _c(
      "div",
      {
        staticClass: "text-right",
        staticStyle: {
          "padding-bottom": "15px",
          "padding-top": "15px",
          "padding-right": "15px"
        }
      },
      [
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-primary",
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.addLine($event)
              }
            }
          },
          [
            _c("i", {
              staticClass: "fa fa-plus",
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(" เพิ่มรายการ \n        ")
          ]
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "table-responsive" }, [
      _c("table", { staticClass: "table table-bordered mb-0" }, [
        _vm._m(0),
        _vm._v(" "),
        _vm.showqualityAssuranceLines.length != 0
          ? _c(
              "tbody",
              {
                directives: [
                  {
                    name: "loading",
                    rawName: "v-loading",
                    value: _vm.is_loading,
                    expression: "is_loading"
                  }
                ]
              },
              [
                _vm._l(_vm.showqualityAssuranceLines, function(value, index) {
                  return _c("tr", { key: "showData" + index }, [
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _c("el-checkbox", {
                          model: {
                            value: value.enabledFlagShowWeb,
                            callback: function($$v) {
                              _vm.$set(value, "enabledFlagShowWeb", $$v)
                            },
                            expression: "value.enabledFlagShowWeb"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-input", {
                          attrs: { placeholder: "รายการตรวจสอบคุณภาพบุหรี่" },
                          model: {
                            value: value.tobacco_qty_checklist,
                            callback: function($$v) {
                              _vm.$set(value, "tobacco_qty_checklist", $$v)
                            },
                            expression: "value.tobacco_qty_checklist"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-input", {
                          attrs: {
                            placeholder: "รายละเอียดการตรวจสอบคุณภาพบุหรี่"
                          },
                          model: {
                            value: value.description,
                            callback: function($$v) {
                              _vm.$set(value, "description", $$v)
                            },
                            expression: "value.description"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", {
                      staticClass: "text-center",
                      staticStyle: { "vertical-align": "middle" }
                    })
                  ])
                }),
                _vm._v(" "),
                _vm._l(_vm.lines, function(dataLine, index) {
                  return _c("tr", { key: index }, [
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _c("el-checkbox", {
                          model: {
                            value: dataLine.enabledFlag,
                            callback: function($$v) {
                              _vm.$set(dataLine, "enabledFlag", $$v)
                            },
                            expression: "dataLine.enabledFlag"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-input", {
                          attrs: { placeholder: "รายการตรวจสอบคุณภาพบุหรี่" },
                          model: {
                            value: dataLine.tobaccoQTYchecklist,
                            callback: function($$v) {
                              _vm.$set(dataLine, "tobaccoQTYchecklist", $$v)
                            },
                            expression: "dataLine.tobaccoQTYchecklist"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-input", {
                          attrs: {
                            placeholder: "รายละเอียดการตรวจสอบคุณภาพบุหรี่"
                          },
                          model: {
                            value: dataLine.description,
                            callback: function($$v) {
                              _vm.$set(dataLine, "description", $$v)
                            },
                            expression: "dataLine.description"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-danger",
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.removeRow(index)
                              }
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "fa fa-times",
                              attrs: { "aria-hidden": "true" }
                            })
                          ]
                        )
                      ]
                    )
                  ])
                }),
                _vm._v(" "),
                _c("tr", [
                  _c("td", { attrs: { colspan: "4" } }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "row justify-content-center clearfix tw-my-4"
                      },
                      [
                        _c("div", { staticClass: "col text-center" }, [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-sm btn-success",
                              attrs: {
                                type: "button",
                                disabled: _vm.isBtnSave
                              },
                              on: {
                                click: function($event) {
                                  return _vm.saveDataToTable()
                                }
                              }
                            },
                            [
                              _c("i", { staticClass: "fa fa-plus" }),
                              _vm._v(
                                " บันทึก\n                                "
                              )
                            ]
                          )
                        ])
                      ]
                    )
                  ])
                ])
              ],
              2
            )
          : _c(
              "tbody",
              {
                directives: [
                  {
                    name: "loading",
                    rawName: "v-loading",
                    value: _vm.is_loading,
                    expression: "is_loading"
                  }
                ]
              },
              [
                _vm.checkKeyWord ? _c("tr", [_vm._m(1)]) : _vm._e(),
                _vm._v(" "),
                _vm._l(_vm.lines, function(dataLine, index) {
                  return _c("tr", { key: index }, [
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _c("el-checkbox", {
                          model: {
                            value: dataLine.enabledFlag,
                            callback: function($$v) {
                              _vm.$set(dataLine, "enabledFlag", $$v)
                            },
                            expression: "dataLine.enabledFlag"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-input", {
                          attrs: { placeholder: "รายการตรวจสอบคุณภาพบุหรี่" },
                          model: {
                            value: dataLine.tobaccoQTYchecklist,
                            callback: function($$v) {
                              _vm.$set(dataLine, "tobaccoQTYchecklist", $$v)
                            },
                            expression: "dataLine.tobaccoQTYchecklist"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c("el-input", {
                          attrs: {
                            placeholder: "รายละเอียดการตรวจสอบคุณภาพบุหรี่"
                          },
                          model: {
                            value: dataLine.description,
                            callback: function($$v) {
                              _vm.$set(dataLine, "description", $$v)
                            },
                            expression: "dataLine.description"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-danger",
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.removeRow(index)
                              }
                            }
                          },
                          [
                            _c("i", {
                              staticClass: "fa fa-times",
                              attrs: { "aria-hidden": "true" }
                            })
                          ]
                        )
                      ]
                    )
                  ])
                }),
                _vm._v(" "),
                _c("tr", [
                  _c("td", { attrs: { colspan: "4" } }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "row justify-content-center clearfix tw-my-4"
                      },
                      [
                        _c("div", { staticClass: "col text-center" }, [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-sm btn-success",
                              attrs: {
                                type: "button",
                                disabled: _vm.isBtnSave
                              },
                              on: {
                                click: function($event) {
                                  return _vm.saveDataToTable()
                                }
                              }
                            },
                            [
                              _c("i", { staticClass: "fa fa-plus" }),
                              _vm._v(
                                " บันทึก\n                                "
                              )
                            ]
                          )
                        ])
                      ]
                    )
                  ])
                ])
              ],
              2
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
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [_c("div", [_vm._v("สถานะการใช้งาน")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [
            _c("div", [
              _vm._v("รายการตรวจสอบคุณภาพบุหรี่ "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "font-size": "small" } },
          [
            _c("div", [
              _vm._v("รายละเอียดการตรวจสอบคุณภาพบุหรี่ "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c("th")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: { "vertical-align": "middle", width: "100%" },
        attrs: { colspan: "4" }
      },
      [_c("h2", [_vm._v(" ไม่มีข้อมูลในระบบ ")])]
    )
  }
]
render._withStripped = true



/***/ })

}]);