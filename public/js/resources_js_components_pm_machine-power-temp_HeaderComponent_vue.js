(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_machine-power-temp_HeaderComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['machineGroupList', 'routeIndex', 'productPeriod', 'btnTrans'],
  data: function data() {
    return {
      machineGroup: '',
      printType: '',
      machineGroupDetails: '',
      machine: '',
      respMachineList: [],
      machineList: [],
      printTypeList: [],
      machinePowerTempList: [],
      productPeriodList: this.productPeriod,
      numberColumn: this.productPeriod.length + 4,
      // lookupTypeMachine: [],
      uomList: [],
      loading: {
        machine: false,
        printType: false,
        table: false
      }
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
    getDetails: function getDetails(value) {
      var _this = this;

      // this.loading.machine = true;
      if (!this.machineGroup) {
        this.printType = '';
        this.machine = '';
        this.machinePowerTempList = [];
      }

      this.loading.printType = true;
      this.machineGroupList.forEach(function (element) {
        if (value == element.machine_group) {
          _this.machineGroupDetails = element.asset_group;
        }
      });
      var params = {
        machine_group: value
      };
      return axios.get('/pm/ajax/machine-power-temp/getMachine', {
        params: params
      }).then(function (res) {
        _this.respMachineList = res.data.machineList;
        _this.printTypeList = res.data.printTypeList; // this.loading.machine = false;

        _this.loading.printType = false;
      });
    },
    selectPrintType: function selectPrintType() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this2.printType) {
                  _this2.machine = '';
                }

                _this2.machineList = _this2.respMachineList.filter(function (item) {
                  return item.print_type == _this2.printType;
                }); // this.machineList = this.respMachineList;

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getTable: function getTable(value, value1) {
      var _this3 = this;

      var params = {
        machine_group: value,
        machine_id: value1
      };
      this.loading.table = true;
      return axios.get('/pm/ajax/machine-power-temp/getTable', {
        params: params
      }).then(function (res) {
        _this3.machinePowerTempList = res.data.machinePowerTempList; // this.lookupTypeMachine = res.data.lookupTypeMachine;

        _this3.uomList = res.data.uomList;
        _this3.loading.table = false;
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/HeaderComponent.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/HeaderComponent.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _HeaderComponent_vue_vue_type_template_id_4499353a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderComponent.vue?vue&type=template&id=4499353a& */ "./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=template&id=4499353a&");
/* harmony import */ var _HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _HeaderComponent_vue_vue_type_template_id_4499353a___WEBPACK_IMPORTED_MODULE_0__.render,
  _HeaderComponent_vue_vue_type_template_id_4499353a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/machine-power-temp/HeaderComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=template&id=4499353a&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=template&id=4499353a& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_template_id_4499353a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_template_id_4499353a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderComponent_vue_vue_type_template_id_4499353a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderComponent.vue?vue&type=template&id=4499353a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=template&id=4499353a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=template&id=4499353a&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/machine-power-temp/HeaderComponent.vue?vue&type=template&id=4499353a& ***!
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
  return _c("div", [
    _c("div", { staticClass: "ibox" }, [
      _c("div", { staticClass: "ibox-content" }, [
        _c(
          "div",
          {
            staticClass: "text-right",
            staticStyle: { "padding-bottom": "15px" }
          },
          [
            _c(
              "a",
              {
                staticClass: "btn btn-danger",
                attrs: {
                  type: "button",
                  href: "/pm/settings/machine-power-temp"
                }
              },
              [_vm._v("\n                    ล้างค่า\n                ")]
            )
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกกลุ่มเครื่องจักร",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": ""
                  },
                  on: {
                    change: function($event) {
                      return _vm.getDetails(_vm.machineGroup)
                    }
                  },
                  model: {
                    value: _vm.machineGroup,
                    callback: function($$v) {
                      _vm.machineGroup = $$v
                    },
                    expression: "machineGroup"
                  }
                },
                _vm._l(_vm.machineGroupList, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: item.asset_group,
                      value: item.machine_group
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
            { staticClass: "col-6" },
            [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loading.printType,
                      expression: "loading.printType"
                    }
                  ],
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกระบบการพิมพ์",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": "",
                    disabled: !_vm.machineGroup
                  },
                  on: {
                    change: function(value) {
                      _vm.selectPrintType()
                    }
                  },
                  model: {
                    value: _vm.printType,
                    callback: function($$v) {
                      _vm.printType = $$v
                    },
                    expression: "printType"
                  }
                },
                _vm._l(_vm.printTypeList, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: item.print_type_label,
                      value: item.print_type_value
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
        _c(
          "div",
          { staticClass: "row", staticStyle: { "padding-top": "15px" } },
          [
            _c(
              "div",
              { staticClass: "col-6" },
              [
                _vm._m(2),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.loading.machine,
                        expression: "loading.machine"
                      }
                    ],
                    staticClass: "w-100",
                    attrs: {
                      placeholder: "โปรดเลือกเครื่องจักร",
                      clearable: "",
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      disabled: !_vm.machineGroup || !_vm.printType
                    },
                    on: {
                      change: function($event) {
                        return _vm.getTable(_vm.machineGroup, _vm.machine)
                      }
                    },
                    model: {
                      value: _vm.machine,
                      callback: function($$v) {
                        _vm.machine = $$v
                      },
                      expression: "machine"
                    }
                  },
                  _vm._l(_vm.machineList, function(item, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: {
                        label: item.machine_name,
                        value: item.machine_id
                      }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ]
        )
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "ibox" }, [
      _vm._m(3),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading.table,
              expression: "loading.table"
            }
          ],
          staticClass: "ibox-content"
        },
        [
          _c("machine-power-temp-table", {
            attrs: {
              machinePowerTempList: _vm.machinePowerTempList,
              productPeriodList: _vm.productPeriodList,
              numberColumn: _vm.numberColumn,
              uomList: _vm.uomList,
              machineGroup: _vm.machineGroup,
              machine: _vm.machine,
              btnTrans: _vm.btnTrans
            }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" กลุ่มเครื่องจักร ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" ระบบการพิมพ์ ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" เครื่องจักร ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h5", [_vm._v("บันทึกกำลังผลิตรายเครื่อง")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);