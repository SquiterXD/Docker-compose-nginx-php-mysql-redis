(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_print-machine-group_TableSetupComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['lookupMachineGroup', 'assetList', 'lookupCode', 'printMachineGroup', 'btnTrans', 'assetGroup', 'printTypes'],
  data: function data() {
    return {
      lines: [],
      loading: false,
      isTextNotFound: true
    };
  },
  mounted: function mounted() {},
  methods: {
    addLine: function addLine() {
      this.isTextNotFound = false;
      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
        machine_group: this.lookupCode ? this.lookupCode : '',
        machine_id: '',
        checked: true,
        print_type: ''
      });
    },
    save: function save() {
      var _this = this;

      var params = _objectSpread({}, this.lines);

      this.loading = true;
      return axios.post('/pm/ajax/print-machine-group/store', {
        params: params
      }).then(function (res) {
        _this.loading = false;

        if (res.data == "success") {
          swal({
            title: "Success",
            text: 'บันทึกสำเร็จ',
            timer: 3000,
            type: "success",
            showCancelButton: false,
            showConfirmButton: true
          });
          setTimeout(function () {
            window.location.href = '/pm/settings/print-machine-group';
          }, 3000);
        }

        if (res.data == "duplicate") {
          swal({
            title: "คำเตือน !",
            text: "ไม่สามารถบันทึกได้ เนื่องจากมีข้อมูลซ้ำ",
            type: "warning",
            showConfirmButton: true
          }); // setTimeout(() => {
          //     window.location.href = '/pm/settings/print-machine-group'
          // }, 3000)
        }
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);

      if (this.lines.length == 0) {
        this.isTextNotFound = true;
      } else {
        this.isTextNotFound = false;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/print-machine-group/TableSetupComponent.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/pm/print-machine-group/TableSetupComponent.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableSetupComponent_vue_vue_type_template_id_ed754dde___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableSetupComponent.vue?vue&type=template&id=ed754dde& */ "./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=template&id=ed754dde&");
/* harmony import */ var _TableSetupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableSetupComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableSetupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableSetupComponent_vue_vue_type_template_id_ed754dde___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableSetupComponent_vue_vue_type_template_id_ed754dde___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/print-machine-group/TableSetupComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSetupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSetupComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSetupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=template&id=ed754dde&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=template&id=ed754dde& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSetupComponent_vue_vue_type_template_id_ed754dde___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSetupComponent_vue_vue_type_template_id_ed754dde___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSetupComponent_vue_vue_type_template_id_ed754dde___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSetupComponent.vue?vue&type=template&id=ed754dde& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=template&id=ed754dde&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=template&id=ed754dde&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/print-machine-group/TableSetupComponent.vue?vue&type=template&id=ed754dde& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
      staticClass: "col-lg-12"
    },
    [
      _c("div", { staticClass: "ibox" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _vm.lookupCode.length != 0
            ? _c("div", { staticClass: "text-right" }, [
                _c(
                  "button",
                  {
                    class: _vm.btnTrans.save.class,
                    attrs: { type: "submit" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.save()
                      }
                    }
                  },
                  [
                    _c("i", {
                      class: _vm.btnTrans.save.icon,
                      attrs: { "aria-hidden": "true" }
                    }),
                    _vm._v(
                      " " +
                        _vm._s(_vm.btnTrans.save.text) +
                        " \n                "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    attrs: { type: "submit" },
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
                    _vm._v(" เพิ่มรายการ \n                ")
                  ]
                )
              ])
            : _vm._e(),
          _c("br"),
          _vm._v(" "),
          _c("table", { staticClass: "table table table-bordered" }, [
            _vm._m(1),
            _vm._v(" "),
            _vm.printMachineGroup.length != 0
              ? _c(
                  "tbody",
                  [
                    _vm._l(_vm.printMachineGroup, function(data, index) {
                      return _c("tr", { key: "showdata" + index }, [
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(index + 1) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(data.assetGroup.asset_group) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(data.print_type_label) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-left",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(data.machine_name) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _c("el-checkbox", {
                              attrs: {
                                checked: data.enable_flag == "Y" ? true : false,
                                disabled: ""
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
                        ),
                        _vm._v(" "),
                        _c("td"),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _c(
                              "a",
                              {
                                class: _vm.btnTrans.edit.class,
                                attrs: {
                                  type: "button",
                                  href:
                                    "/pm/settings/print-machine-group/" +
                                    data.id +
                                    "/edit"
                                }
                              },
                              [
                                _c("i", {
                                  class: _vm.btnTrans.edit.icon,
                                  attrs: { "aria-hidden": "true" }
                                }),
                                _vm._v(
                                  " " +
                                    _vm._s(_vm.btnTrans.edit.text) +
                                    "\n                            "
                                )
                              ]
                            )
                          ]
                        )
                      ])
                    }),
                    _vm._v(" "),
                    _vm._l(_vm.lines, function(data, index) {
                      return _c("tr", { key: index }, [
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(data.index) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(_vm.assetGroup) +
                                "\n                            "
                            )
                          ]
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
                              "el-select",
                              {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  placeholder: "โปรดเลือก ระบบการพิมพ์",
                                  clearable: "",
                                  filterable: ""
                                },
                                model: {
                                  value: data.print_type,
                                  callback: function($$v) {
                                    _vm.$set(data, "print_type", $$v)
                                  },
                                  expression: "data.print_type"
                                }
                              },
                              _vm._l(_vm.printTypes, function(item, index) {
                                return _c(
                                  "el-option",
                                  {
                                    key: index,
                                    attrs: {
                                      label: item.print_type_label,
                                      value: item.print_type_value
                                    }
                                  },
                                  [
                                    _c("div", { staticClass: "text-left" }, [
                                      _vm._v(_vm._s(item.print_type_label))
                                    ])
                                  ]
                                )
                              }),
                              1
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c(
                              "el-select",
                              {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  placeholder: "โปรดเลือก ชื่อเครื่องจักร",
                                  clearable: "",
                                  filterable: ""
                                },
                                model: {
                                  value: data.machine_id,
                                  callback: function($$v) {
                                    _vm.$set(data, "machine_id", $$v)
                                  },
                                  expression: "data.machine_id"
                                }
                              },
                              _vm._l(_vm.assetList, function(item, index) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label:
                                      item.asset_number +
                                      " : " +
                                      item.asset_description,
                                    value: item.asset_id
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
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _c("el-checkbox", {
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
                        ),
                        _vm._v(" "),
                        _c("td", {
                          staticClass: "text-center",
                          staticStyle: { "vertical-align": "middle" }
                        })
                      ])
                    })
                  ],
                  2
                )
              : _c(
                  "tbody",
                  [
                    _c("tr", { staticClass: "text-center" }, [
                      _vm.isTextNotFound
                        ? _c("td", { attrs: { colspan: "6" } }, [
                            _vm._v("ไม่มีข้อมูล")
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.lines, function(data, index) {
                      return _c("tr", { key: index }, [
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(data.index) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(_vm.assetGroup) +
                                "\n                            "
                            )
                          ]
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
                              "el-select",
                              {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  placeholder: "โปรดเลือก ระบบการพิมพ์",
                                  clearable: "",
                                  filterable: ""
                                },
                                model: {
                                  value: data.print_type,
                                  callback: function($$v) {
                                    _vm.$set(data, "print_type", $$v)
                                  },
                                  expression: "data.print_type"
                                }
                              },
                              _vm._l(_vm.printTypes, function(item, index) {
                                return _c(
                                  "el-option",
                                  {
                                    key: index,
                                    attrs: {
                                      label: item.print_type_label,
                                      value: item.print_type_value
                                    }
                                  },
                                  [
                                    _c("div", { staticClass: "text-left" }, [
                                      _vm._v(_vm._s(item.print_type_label))
                                    ])
                                  ]
                                )
                              }),
                              1
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c(
                              "el-select",
                              {
                                staticStyle: { width: "100%" },
                                attrs: {
                                  placeholder: "โปรดเลือก ชื่อเครื่องจักร",
                                  clearable: "",
                                  filterable: ""
                                },
                                model: {
                                  value: data.machine_id,
                                  callback: function($$v) {
                                    _vm.$set(data, "machine_id", $$v)
                                  },
                                  expression: "data.machine_id"
                                }
                              },
                              _vm._l(_vm.assetList, function(item, index) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label:
                                      item.asset_number +
                                      " : " +
                                      item.asset_description,
                                    value: item.asset_id
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
                          "td",
                          {
                            staticClass: "text-center",
                            staticStyle: { "vertical-align": "middle" }
                          },
                          [
                            _c("el-checkbox", {
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
                        ),
                        _vm._v(" "),
                        _c("td", {
                          staticClass: "text-center",
                          staticStyle: { "vertical-align": "middle" }
                        })
                      ])
                    })
                  ],
                  2
                )
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h5", [_vm._v("กำหนดกลุ่มเครื่องจักรกับเครื่องจักร")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "180px" } },
          [_c("div", [_vm._v("ลำดับที่")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "180px" } },
          [_c("div", [_vm._v("กลุ่มเครื่องจักร")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "180px" } },
          [_c("div", [_vm._v("ระบบการพิมพ์")])]
        ),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("div", [_vm._v("ชื่อเครื่องจักร")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("div", [_vm._v("สถานะการใช้งาน")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);