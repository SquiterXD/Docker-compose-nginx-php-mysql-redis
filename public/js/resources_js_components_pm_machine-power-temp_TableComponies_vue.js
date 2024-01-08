(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_machine-power-temp_TableComponies_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['machinePowerTempList', 'productPeriodList', 'numberColumn', 'uomList', 'machineGroup', 'machine', 'btnTrans'],
  data: function data() {
    return {
      lines: [],
      statusBtuSave: false,
      checkText: true,
      disabledAddLine: false,
      disabledSave: false
    };
  },
  computed: {
    getDataMachineType: function getDataMachineType() {
      if (this.machinePowerTempList.length == 0) {
        this.disabledAddLine = false;
        this.disabledSave = false;
      } else {
        this.disabledAddLine = true;
        this.disabledSave = true;
      }

      return _.groupBy(this.machinePowerTempList, "machine_name");
    }
  },
  mounted: function mounted() {},
  methods: {
    addLine: function addLine() {
      this.checkText = false;
      this.lines.push({
        machine_id: this.machine ? this.machine : '',
        machine_group: this.machineGroup ? this.machineGroup : '',
        // machine_type: '',
        // uom_description: '',
        power: [],
        lookupCode: [],
        uom: ''
      });
      this.disabledAddLine = true;
    },
    // getDetailsUom(value, arrayData){
    //     this.lookupTypeMachine.forEach(element => {
    //         if(value == element.lookup_code){
    //             // arrayData.uom = element.attribute1
    //             arrayData.uom_description = element.description
    //             arrayData.uom_code = element.uom_code
    //         }
    //     });
    // },
    checkValue: function checkValue(value, index, indexLine, indexPeriod) {
      var _this = this;

      var vm = this;
      vm.lines.forEach(function (element, i) {
        element.power.forEach(function (data, key) {
          if (indexLine == i) {
            if (index > key) {
              if (Number(data) > Number(value)) {
                _this.showAlert();

                _this.statusBtuSave = true;
                return;
              } else {
                _this.statusBtuSave = false;
              }
            }

            element.lookupCode[indexPeriod] = index;
          }
        });
      });
    },
    showAlert: function showAlert() {
      swal({
        title: "Error !",
        text: "ไม่สามารถกรอกจำนวนเลขนี้ได้",
        type: "error",
        showConfirmButton: true
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);

      if (this.lines.length == 0) {
        this.checkText = true;
      } else {
        this.checkText = false;
      }

      this.disabledAddLine = false;
    },
    saveDataToTable: function saveDataToTable() {
      var params = _objectSpread({}, this.lines);

      return axios.post('/pm/ajax/machine-power-temp/store', {
        params: params
      }).then(function (res) {
        if (res.data.data == "succeed") {
          swal({
            title: "Success",
            text: 'บันทึกสำเร็จ',
            timer: 3000,
            type: "success",
            showCancelButton: false,
            showConfirmButton: true
          });
          setTimeout(function () {
            window.location.href = '/pm/settings/machine-power-temp';
          }, 3000);
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/TableComponies.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/TableComponies.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponies_vue_vue_type_template_id_6542783e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponies.vue?vue&type=template&id=6542783e& */ "./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=template&id=6542783e&");
/* harmony import */ var _TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponies.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponies_vue_vue_type_template_id_6542783e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponies_vue_vue_type_template_id_6542783e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/machine-power-temp/TableComponies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=template&id=6542783e&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=template&id=6542783e& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_template_id_6542783e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_template_id_6542783e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_template_id_6542783e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponies.vue?vue&type=template&id=6542783e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=template&id=6542783e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=template&id=6542783e&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/TableComponies.vue?vue&type=template&id=6542783e& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
    this.machineGroup && this.machine
      ? _c(
          "div",
          {
            staticClass: "text-right",
            staticStyle: { "padding-bottom": "15px" }
          },
          [
            _c(
              "button",
              {
                class: _vm.btnTrans.save.class,
                attrs: { disabled: this.disabledAddLine },
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
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                class: _vm.btnTrans.save.class,
                attrs: { disabled: this.disabledSave },
                on: {
                  click: function($event) {
                    return _vm.saveDataToTable()
                  }
                }
              },
              [
                _c("i", {
                  class: _vm.btnTrans.save.icon,
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(" " + _vm._s(_vm.btnTrans.save.text) + " \n        ")
              ]
            )
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _c("table", { staticClass: "table table table-bordered" }, [
      _c("thead", [
        _c(
          "tr",
          [
            _vm._l(_vm.productPeriodList, function(item) {
              return _c(
                "th",
                {
                  key: item.key,
                  staticClass: "text-center",
                  attrs: { width: "10%" }
                },
                [_c("div", [_vm._v(_vm._s(item.description))])]
              )
            }),
            _vm._v(" "),
            _vm._m(0),
            _vm._v(" "),
            _c("th", { staticClass: "text-center", attrs: { width: "5%" } }),
            _vm._v(" "),
            _c("th", { staticClass: "text-center", attrs: { width: "5%" } })
          ],
          2
        )
      ]),
      _vm._v(" "),
      this.machinePowerTempList === undefined ||
      this.machinePowerTempList.length === 0
        ? _c(
            "tbody",
            [
              _vm.checkText
                ? _c("tr", { staticClass: "text-center" }, [
                    _c("td", { attrs: { colspan: _vm.numberColumn } }, [
                      _vm._v("ไม่มีข้อมูล")
                    ])
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm._l(_vm.lines, function(data, index) {
                return _c(
                  "tr",
                  { key: index },
                  [
                    _vm._l(_vm.productPeriodList, function(item, key) {
                      return _c(
                        "td",
                        { key: key },
                        [
                          _c("el-input", {
                            attrs: { placeholder: item.description },
                            on: {
                              change: function($event) {
                                return _vm.checkValue(
                                  data.power[key + 1],
                                  item.lookup_code,
                                  index,
                                  key + 1
                                )
                              }
                            },
                            model: {
                              value: data.power[key + 1],
                              callback: function($$v) {
                                _vm.$set(data.power, key + 1, $$v)
                              },
                              expression: "data.power[key+1]"
                            }
                          })
                        ],
                        1
                      )
                    }),
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
                            staticClass: "w-100",
                            attrs: {
                              placeholder: "เลือก หน่วย",
                              clearable: "",
                              filterable: "",
                              remote: "",
                              "reserve-keyword": ""
                            },
                            model: {
                              value: data.uom,
                              callback: function($$v) {
                                _vm.$set(data, "uom", $$v)
                              },
                              expression: "data.uom"
                            }
                          },
                          _vm._l(_vm.uomList, function(uom, index) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label: uom.unit_of_measure,
                                value: uom.uom_code
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
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
                    ]),
                    _vm._v(" "),
                    _c("td")
                  ],
                  2
                )
              })
            ],
            2
          )
        : _c(
            "tbody",
            [
              _vm._l(_vm.getDataMachineType, function(data, index) {
                return _c(
                  "tr",
                  { key: index },
                  [
                    _vm._l(_vm.productPeriodList, function(time, key) {
                      return _c(
                        "td",
                        {
                          key: key,
                          staticClass: "text-center",
                          staticStyle: { "vertical-align": "middle" }
                        },
                        _vm._l(data, function(item, itemKey) {
                          return _c("div", { key: itemKey }, [
                            item.machine_name == index &&
                            item.product_time == time.lookup_code
                              ? _c("div", [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(item.power) +
                                      "\n                        "
                                  )
                                ])
                              : _vm._e()
                          ])
                        }),
                        0
                      )
                    }),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(
                              data[0].uom_v ? data[0].uom_v.unit_of_measure : ""
                            ) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("td"),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "font-size": "12px" }
                      },
                      [
                        _c(
                          "a",
                          {
                            class: _vm.btnTrans.edit.class,
                            attrs: {
                              type: "button",
                              href:
                                "/pm/settings/machine-power-temp/" +
                                data[0].machine_group +
                                "/" +
                                data[0].machine_id +
                                "/" +
                                data[0].machine_type +
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
                                "\n                    "
                            )
                          ]
                        )
                      ]
                    )
                  ],
                  2
                )
              }),
              _vm._v(" "),
              _vm._l(_vm.lines, function(data, index) {
                return _c(
                  "tr",
                  { key: index },
                  [
                    _vm._l(_vm.productPeriodList, function(item, key) {
                      return _c(
                        "td",
                        { key: key },
                        [
                          _c("el-input", {
                            attrs: { placeholder: item.description },
                            on: {
                              change: function($event) {
                                return _vm.checkValue(
                                  data.power[key + 1],
                                  item.lookup_code,
                                  index,
                                  key + 1
                                )
                              }
                            },
                            model: {
                              value: data.power[key + 1],
                              callback: function($$v) {
                                _vm.$set(data.power, key + 1, $$v)
                              },
                              expression: "data.power[key+1]"
                            }
                          })
                        ],
                        1
                      )
                    }),
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
                            staticClass: "w-100",
                            attrs: {
                              placeholder: "เลือก หน่วย",
                              clearable: "",
                              filterable: "",
                              remote: "",
                              "reserve-keyword": ""
                            },
                            model: {
                              value: data.uom,
                              callback: function($$v) {
                                _vm.$set(data, "uom", $$v)
                              },
                              expression: "data.uom"
                            }
                          },
                          _vm._l(_vm.uomList, function(uom, index) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label: uom.unit_of_measure,
                                value: uom.uom_code
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _c(
                        "button",
                        {
                          class: _vm.btnTrans.delete.class,
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.removeRow(index)
                            }
                          }
                        },
                        [
                          _c("i", {
                            class: _vm.btnTrans.delete.icon,
                            attrs: { "aria-hidden": "true" }
                          })
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _c("td")
                  ],
                  2
                )
              })
            ],
            2
          )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center", attrs: { width: "5%" } }, [
      _c("div", [_vm._v("หน่วย")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);