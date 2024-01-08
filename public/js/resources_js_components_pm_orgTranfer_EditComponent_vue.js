(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_orgTranfer_EditComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  // props: ['dataSetup', 'wipTransaction', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'organizationId', 'dataItemTypes', 'orgM12'],
  props: ['dataSetup', 'wipTransaction', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'organizationId', 'dataItemTypes'],
  data: function data() {
    return {
      wip: this.dataSetup ? this.dataSetup.wip_transaction_type_id : '',
      tobaccoItemcat: this.dataSetup ? this.dataSetup.tobacco_group_code : '',
      transaction: this.dataSetup ? this.dataSetup.transaction_type_id : '',
      id: this.dataSetup ? this.dataSetup.id : '',
      itemType: this.dataSetup ? this.dataSetup.inv_item_type : '',
      olditemType: this.dataSetup ? this.dataSetup.inv_item_type : '',
      organizationFrom: this.dataSetup ? this.dataSetup.from_organization_id : '',
      inventoryFrom: this.dataSetup ? this.dataSetup.from_locator_id : '',
      organizationTo: this.dataSetup ? this.dataSetup.to_organization_id : '',
      inventoryTo: this.dataSetup ? this.dataSetup.to_locator_id : '',
      oldValueLocationsFrom: this.dataSetup ? this.dataSetup.from_organization_id : '',
      oldValueLocationTo: this.dataSetup ? this.dataSetup.to_organization_id : '',
      locationFromLists: [],
      locationToLists: [],
      checked: this.dataSetup ? this.dataSetup.enable_flag == 'Y' ? true : false : '',
      oldchecked: this.dataSetup ? this.dataSetup.enable_flag == 'Y' ? true : false : '',
      loading: {
        inventoryLocationFrome: false,
        inventoryLocationTo: false,
        transactionTypes: false
      },
      isDisabledLocationFrome: true,
      isDisabledLocationTo: true,
      // isDisabledTransaction: this.organizationId == this.orgM12.organization_id ? true : false,
      transactionTypesList: this.transactionTypes
    };
  },
  mounted: function mounted() {
    this.getLocationsFrom(this.dataSetup ? this.dataSetup.from_organization_id : '');
    this.getLocationsTo(this.dataSetup ? this.dataSetup.to_organization_id : '');
  },
  methods: {
    getLocationsFrom: function getLocationsFrom(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (_this.oldValueLocationsFrom != value) {
                  _this.inventoryFrom = '';
                }

                params = {
                  organization: value
                };
                _this.loading.inventoryLocationFrome = true;
                _context.next = 5;
                return axios.get('/pm/ajax/org-tranfer/get_locations_from', {
                  params: params
                }).then(function (res) {
                  if (res.data.itemLocationsFrom.length == 0) {
                    swal({
                      title: "warning !",
                      text: "organizationนี้ ไม่มีสถานที่จัดเก็บ",
                      type: "warning",
                      showConfirmButton: true
                    });
                    _this.locationFromLists = '';
                    _this.inventoryFrom = '';
                    _this.isDisabledLocationFrome = true;
                    _this.loading.inventoryLocationFrome = false;
                  } else {
                    _this.locationFromLists = res.data.itemLocationsFrom;
                    _this.loading.inventoryLocationFrome = false;
                    _this.isDisabledLocationFrome = false; // this.inventoryFrom = '';
                  }
                });

              case 5:
                return _context.abrupt("return", _context.sent);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getLocationsTo: function getLocationsTo(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (_this2.oldValueLocationTo != value) {
                  _this2.inventoryTo = '';
                }

                params = {
                  organization: value
                };
                _this2.loading.inventoryLocationTo = true;
                _context2.next = 5;
                return axios.get('/pm/ajax/org-tranfer/get_locations_to', {
                  params: params
                }).then(function (res) {
                  if (res.data.itemLocationsTo.length == 0) {
                    swal({
                      title: "warning !",
                      text: "organizationนี้ ไม่มีสถานที่จัดเก็บ",
                      type: "warning",
                      showConfirmButton: true
                    });
                    _this2.locationToLists = '';
                    _this2.inventoryTo = '';
                    _this2.isDisabledLocationTo = true;
                    _this2.loading.inventoryLocationTo = false;
                  } else {
                    _this2.locationToLists = res.data.itemLocationsTo;
                    _this2.loading.inventoryLocationTo = false;
                    _this2.isDisabledLocationTo = false;
                  }
                });

              case 5:
                return _context2.abrupt("return", _context2.sent);

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    remoteMethod: function remoteMethod(query) {
      var _this3 = this;

      if (query !== '') {
        var params = query;
        this.loading.transactionTypes = true;
        return axios.get('/pm/ajax/org-tranfer/get_transaction_types', {
          params: params
        }).then(function (res) {
          _this3.transactionTypesList = res.data.transactionTypes;
          _this3.loading.transactionTypes = false;
        });
      } else {
        this.transactionTypesList = this.transactionTypes;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/orgTranfer/EditComponent.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/pm/orgTranfer/EditComponent.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EditComponent_vue_vue_type_template_id_af73d802___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=template&id=af73d802& */ "./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=template&id=af73d802&");
/* harmony import */ var _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EditComponent_vue_vue_type_template_id_af73d802___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditComponent_vue_vue_type_template_id_af73d802___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/orgTranfer/EditComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=template&id=af73d802&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=template&id=af73d802& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_af73d802___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_af73d802___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_af73d802___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=template&id=af73d802& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=template&id=af73d802&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=template&id=af73d802&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/orgTranfer/EditComponent.vue?vue&type=template&id=af73d802& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.id,
              expression: "id"
            }
          ],
          attrs: { type: "hidden", name: "id" },
          domProps: { value: _vm.id },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.id = $event.target.value
            }
          }
        }),
        _vm._v(" "),
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
                    value: _vm.wip,
                    expression: "wip"
                  }
                ],
                attrs: { type: "hidden", name: "wip_transaction_type_id" },
                domProps: { value: _vm.wip },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.wip = $event.target.value
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
                    value: _vm.wip,
                    callback: function($$v) {
                      _vm.wip = $$v
                    },
                    expression: "wip"
                  }
                },
                _vm._l(_vm.wipTransaction, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: item.attribute3,
                      value: item.transaction_type_id
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
                    value: _vm.tobaccoItemcat,
                    expression: "tobaccoItemcat"
                  }
                ],
                attrs: { type: "hidden", name: "tobacco_group_code" },
                domProps: { value: _vm.tobaccoItemcat },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.tobaccoItemcat = $event.target.value
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
                    value: _vm.tobaccoItemcat,
                    callback: function($$v) {
                      _vm.tobaccoItemcat = $$v
                    },
                    expression: "tobaccoItemcat"
                  }
                },
                _vm._l(_vm.tobaccoItemcats, function(itemcat) {
                  return _c("el-option", {
                    key: itemcat.group_code,
                    attrs: {
                      label: itemcat.meaning + " : " + itemcat.group_desc,
                      value: itemcat.group_code
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
                    value: _vm.organizationFrom,
                    expression: "organizationFrom"
                  }
                ],
                attrs: { type: "hidden", name: "from_organization_id" },
                domProps: { value: _vm.organizationFrom },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.organizationFrom = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: { filterable: "", placeholder: "Organization" },
                  on: {
                    change: function($event) {
                      return _vm.getLocationsFrom(_vm.organizationFrom)
                    }
                  },
                  model: {
                    value: _vm.organizationFrom,
                    callback: function($$v) {
                      _vm.organizationFrom = $$v
                    },
                    expression: "organizationFrom"
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
                    value: _vm.inventoryFrom,
                    expression: "inventoryFrom"
                  }
                ],
                attrs: { type: "hidden", name: "from_locator_id" },
                domProps: { value: _vm.inventoryFrom },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.inventoryFrom = $event.target.value
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
                    disabled: _vm.isDisabledLocationFrome,
                    placeholder: "เลือกสถานที่"
                  },
                  model: {
                    value: _vm.inventoryFrom,
                    callback: function($$v) {
                      _vm.inventoryFrom = $$v
                    },
                    expression: "inventoryFrom"
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
                    value: _vm.organizationTo,
                    expression: "organizationTo"
                  }
                ],
                attrs: { type: "hidden", name: "to_organization_id" },
                domProps: { value: _vm.organizationTo },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.organizationTo = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: { filterable: "", placeholder: "Organization" },
                  on: {
                    change: function($event) {
                      return _vm.getLocationsTo(_vm.organizationTo)
                    }
                  },
                  model: {
                    value: _vm.organizationTo,
                    callback: function($$v) {
                      _vm.organizationTo = $$v
                    },
                    expression: "organizationTo"
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
                    value: _vm.inventoryTo,
                    expression: "inventoryTo"
                  }
                ],
                attrs: { type: "hidden", name: "to_locator_id" },
                domProps: { value: _vm.inventoryTo },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.inventoryTo = $event.target.value
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
                    disabled: _vm.isDisabledLocationTo,
                    placeholder: "เลือกสถานที่"
                  },
                  model: {
                    value: _vm.inventoryTo,
                    callback: function($$v) {
                      _vm.inventoryTo = $$v
                    },
                    expression: "inventoryTo"
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
                    value: _vm.transaction,
                    expression: "transaction"
                  }
                ],
                attrs: { type: "hidden", name: "transaction_type_id" },
                domProps: { value: _vm.transaction },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.transaction = $event.target.value
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
                    value: _vm.transaction,
                    callback: function($$v) {
                      _vm.transaction = $$v
                    },
                    expression: "transaction"
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
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.olditemType,
                    expression: "olditemType"
                  }
                ],
                attrs: { type: "hidden", name: "old_inv_item_type" },
                domProps: { value: _vm.olditemType },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.olditemType = $event.target.value
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
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.oldchecked,
                    expression: "oldchecked"
                  }
                ],
                attrs: { type: "hidden", name: "old_enable_flag" },
                domProps: { value: _vm.oldchecked },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.oldchecked = $event.target.value
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