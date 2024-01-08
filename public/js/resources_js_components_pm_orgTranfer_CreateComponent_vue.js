(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_orgTranfer_CreateComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue2_datepicker_index_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue2-datepicker/index.css */ "./node_modules/vue2-datepicker/index.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  // props: ['deprtments','tobaccoItemcats', 'transactionTypes', 'parameters', 'wipTransaction', 'organizationId', 'dataItemTypes', 'orgM12'],
  props: ['deprtments', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'wipTransaction', 'organizationId', 'dataItemTypes'],
  data: function data() {
    return {
      deprtmentSelected: '',
      tobaccoItemcatSelected: '',
      transactionSelected: '',
      itemType: '',
      organizationFromSelected: '',
      inventoryFromSelected: '',
      organizationToSelected: '',
      inventoryToSelected: '',
      wipTransactionSelected: '',
      locationFromLists: [],
      locationToLists: [],
      checked: true,
      transactionTypesList: this.transactionTypes,
      loading: {
        inventoryLocationFrome: false,
        inventoryLocationTo: false,
        transactionTypes: false
      },
      start_date: this.value ? moment__WEBPACK_IMPORTED_MODULE_2___default()(this.value, "DD/MM/YYYY").toDate() : moment__WEBPACK_IMPORTED_MODULE_2___default()().add(543, 'years').toDate(),
      end_date: '' // isDisabledTransaction: this.organizationId == this.orgM12.organization_id ? true : false,

    };
  },
  methods: {
    getLocationsTo: function getLocationsTo(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                params = {
                  organization: value
                };
                _this.loading.inventoryLocationTo = true;
                _context.next = 4;
                return axios.get('/pm/ajax/org-tranfer/get_locations_to', {
                  params: params
                }).then(function (res) {
                  _this.locationToLists = res.data.itemLocationsTo;
                  _this.loading.inventoryLocationTo = false;
                  _this.inventoryToSelected = '';
                });

              case 4:
                return _context.abrupt("return", _context.sent);

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getLocationsFrom: function getLocationsFrom(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                params = {
                  organization: value
                };
                _this2.loading.inventoryLocationFrome = true;
                _context2.next = 4;
                return axios.get('/pm/ajax/org-tranfer/get_locations_from', {
                  params: params
                }).then(function (res) {
                  // console.log(res.data.itemLocationsFrom);
                  _this2.locationFromLists = res.data.itemLocationsFrom;
                  _this2.loading.inventoryLocationFrome = false;
                  _this2.inventoryFromSelected = '';
                });

              case 4:
                return _context2.abrupt("return", _context2.sent);

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    remoteMethod: function remoteMethod(query) {
      var vm = this;

      if (query !== '') {
        var params = query;
        this.loading.transactionTypes = true;
        return axios.get('/pm/ajax/org-tranfer/get_transaction_types', {
          params: params
        }).then(function (res) {
          vm.transactionTypesList = res.data.transactionTypes;
          vm.loading.transactionTypes = false;
          vm.transactionSelected = '';
        });
      } else {
        vm.transactionTypesList = this.transactionTypes;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/orgTranfer/CreateComponent.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/pm/orgTranfer/CreateComponent.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateComponent_vue_vue_type_template_id_315a5566___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=template&id=315a5566& */ "./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=template&id=315a5566&");
/* harmony import */ var _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CreateComponent_vue_vue_type_template_id_315a5566___WEBPACK_IMPORTED_MODULE_0__.render,
  _CreateComponent_vue_vue_type_template_id_315a5566___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/orgTranfer/CreateComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=template&id=315a5566&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=template&id=315a5566& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_315a5566___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_315a5566___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_315a5566___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=template&id=315a5566& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=template&id=315a5566&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=template&id=315a5566&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/CreateComponent.vue?vue&type=template&id=315a5566& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c("div", { staticClass: "col-md-10" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col", staticStyle: { "padding-top": "15px" } },
            [
              _c("label", [_vm._v("คลังสำหรับทำรายการ")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.wipTransactionSelected,
                    expression: "wipTransactionSelected"
                  }
                ],
                attrs: { type: "hidden", name: "wip_transaction_type_id" },
                domProps: { value: _vm.wipTransactionSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.wipTransactionSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    placeholder: "เลือกคลังเพื่อทำรายการ"
                  },
                  model: {
                    value: _vm.wipTransactionSelected,
                    callback: function($$v) {
                      _vm.wipTransactionSelected = $$v
                    },
                    expression: "wipTransactionSelected"
                  }
                },
                _vm._l(_vm.wipTransaction, function(itemWipTransaction) {
                  return _c("el-option", {
                    key: itemWipTransaction.transaction_type_id,
                    attrs: {
                      label: itemWipTransaction.attribute3,
                      value: itemWipTransaction.transaction_type_id
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
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col", staticStyle: { "padding-top": "15px" } },
            [
              _c("label", [_vm._v("ประเภท Item")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.tobaccoItemcatSelected,
                    expression: "tobaccoItemcatSelected"
                  }
                ],
                attrs: { type: "hidden", name: "item_type" },
                domProps: { value: _vm.tobaccoItemcatSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.tobaccoItemcatSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    placeholder: "เลือกประเภท Item"
                  },
                  model: {
                    value: _vm.tobaccoItemcatSelected,
                    callback: function($$v) {
                      _vm.tobaccoItemcatSelected = $$v
                    },
                    expression: "tobaccoItemcatSelected"
                  }
                },
                _vm._l(_vm.tobaccoItemcats, function(tobaccoItemcat) {
                  return _c("el-option", {
                    key: tobaccoItemcat.group_code,
                    attrs: {
                      label:
                        tobaccoItemcat.meaning +
                        " : " +
                        tobaccoItemcat.group_desc,
                      value: tobaccoItemcat.group_code
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
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-5", staticStyle: { "padding-top": "15px" } },
            [
              _c("label", [_vm._v("คลังต้นทาง")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.organizationFromSelected,
                    expression: "organizationFromSelected"
                  }
                ],
                attrs: { type: "hidden", name: "from_organization_id" },
                domProps: { value: _vm.organizationFromSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.organizationFromSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    placeholder: "Organization"
                  },
                  on: {
                    change: function($event) {
                      return _vm.getLocationsFrom(_vm.organizationFromSelected)
                    }
                  },
                  model: {
                    value: _vm.organizationFromSelected,
                    callback: function($$v) {
                      _vm.organizationFromSelected = $$v
                    },
                    expression: "organizationFromSelected"
                  }
                },
                _vm._l(_vm.parameters, function(parameter) {
                  return _c("el-option", {
                    key: parameter.organization_id,
                    attrs: {
                      label:
                        parameter.organization_code +
                        " : " +
                        parameter.hr_all_organization_units.name,
                      value: parameter.organization_id
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
            { staticClass: "col-7", staticStyle: { "padding-top": "43px" } },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.inventoryFromSelected,
                    expression: "inventoryFromSelected"
                  }
                ],
                attrs: { type: "hidden", name: "from_locator_id" },
                domProps: { value: _vm.inventoryFromSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.inventoryFromSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loading.inventoryLocationFrome,
                      expression: "loading.inventoryLocationFrome"
                    }
                  ],
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    disabled: !_vm.organizationFromSelected,
                    placeholder: "สถานที่จัดเก็บ"
                  },
                  model: {
                    value: _vm.inventoryFromSelected,
                    callback: function($$v) {
                      _vm.inventoryFromSelected = $$v
                    },
                    expression: "inventoryFromSelected"
                  }
                },
                _vm._l(_vm.locationFromLists, function(locationFromList) {
                  return _c("el-option", {
                    key: locationFromList.inventory_location_id,
                    attrs: {
                      label:
                        locationFromList.concatenated_segments +
                        " : " +
                        locationFromList.description,
                      value: locationFromList.inventory_location_id
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
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-5", staticStyle: { "padding-top": "15px" } },
            [
              _c("label", [_vm._v("คลังปลายทาง")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.organizationToSelected,
                    expression: "organizationToSelected"
                  }
                ],
                attrs: { type: "hidden", name: "to_organization_id" },
                domProps: { value: _vm.organizationToSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.organizationToSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    placeholder: "Organization"
                  },
                  on: {
                    change: function($event) {
                      return _vm.getLocationsTo(_vm.organizationToSelected)
                    }
                  },
                  model: {
                    value: _vm.organizationToSelected,
                    callback: function($$v) {
                      _vm.organizationToSelected = $$v
                    },
                    expression: "organizationToSelected"
                  }
                },
                _vm._l(_vm.parameters, function(parameter) {
                  return _c("el-option", {
                    key: parameter.organization_id,
                    attrs: {
                      label:
                        parameter.organization_code +
                        " : " +
                        parameter.hr_all_organization_units.name,
                      value: parameter.organization_id
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
            { staticClass: "col-7", staticStyle: { "padding-top": "43px" } },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.inventoryToSelected,
                    expression: "inventoryToSelected"
                  }
                ],
                attrs: { type: "hidden", name: "to_locator_id" },
                domProps: { value: _vm.inventoryToSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.inventoryToSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loading.inventoryLocationTo,
                      expression: "loading.inventoryLocationTo"
                    }
                  ],
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    disabled: !_vm.organizationToSelected,
                    placeholder: "สถานที่จัดเก็บ"
                  },
                  model: {
                    value: _vm.inventoryToSelected,
                    callback: function($$v) {
                      _vm.inventoryToSelected = $$v
                    },
                    expression: "inventoryToSelected"
                  }
                },
                _vm._l(_vm.locationToLists, function(locationToList) {
                  return _c("el-option", {
                    key: locationToList.inventory_location_id,
                    attrs: {
                      label:
                        locationToList.concatenated_segments +
                        " : " +
                        locationToList.description,
                      value: locationToList.inventory_location_id
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
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col", staticStyle: { "padding-top": "15px" } },
            [
              _c("label", [_vm._v("ประเภทการทำรายการ")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.transactionSelected,
                    expression: "transactionSelected"
                  }
                ],
                attrs: { type: "hidden", name: "transaction_type_id" },
                domProps: { value: _vm.transactionSelected },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.transactionSelected = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": "",
                    placeholder: "ประเภทการทำรายการ",
                    "remote-method": _vm.remoteMethod,
                    loading: _vm.loading.transactionTypes
                  },
                  model: {
                    value: _vm.transactionSelected,
                    callback: function($$v) {
                      _vm.transactionSelected = $$v
                    },
                    expression: "transactionSelected"
                  }
                },
                _vm._l(_vm.transactionTypesList, function(transactionType) {
                  return _c("el-option", {
                    key: transactionType.transaction_type_id,
                    attrs: {
                      label: transactionType.transaction_type_name,
                      value: transactionType.transaction_type_id
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
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col", staticStyle: { "padding-top": "15px" } },
            [
              _c("label", [_vm._v("ประเภทวัตถุดิบ")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.itemType,
                    expression: "itemType"
                  }
                ],
                attrs: { type: "hidden", name: "inv_item_type" },
                domProps: { value: _vm.itemType },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.itemType = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    placeholder: "ประเภทวัตถุดิบ"
                  },
                  model: {
                    value: _vm.itemType,
                    callback: function($$v) {
                      _vm.itemType = $$v
                    },
                    expression: "itemType"
                  }
                },
                _vm._l(_vm.dataItemTypes, function(data, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: data.attribute11, value: data.lookup_code }
                  })
                }),
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: { "padding-top": "15px", "padding-bottom": "15px" }
            },
            [
              _c("label", [_vm._v("สถานะการใช้งาน")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.checked,
                    expression: "checked"
                  }
                ],
                attrs: { type: "hidden", name: "enable_flag" },
                domProps: { value: _vm.checked },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.checked = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-checkbox", {
                staticClass: "w-100",
                model: {
                  value: _vm.checked,
                  callback: function($$v) {
                    _vm.checked = $$v
                  },
                  expression: "checked"
                }
              })
            ],
            1
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);