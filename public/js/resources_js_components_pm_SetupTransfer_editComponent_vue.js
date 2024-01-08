(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_SetupTransfer_editComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['transfers', 'itemCats', 'requestTypes'],
  data: function data() {
    return {
      setupTransId: this.transfers ? this.transfers.setup_trans_id : '',
      fromOrganization: this.transfers ? this.transfers.organization_code + ' : ' + this.transfers.organization_name : '',
      oldItemCat: this.transfers ? Number(this.transfers.item_cat_code) : '',
      itemCat: this.transfers ? Number(this.transfers.item_cat_code) : '',
      oldEnableFlag: this.transfers ? this.transfers.enable_flag == 'Y' ? true : false : false,
      newEnableFlag: this.transfers ? this.transfers.enable_flag == 'Y' ? true : false : false,
      oldToOrganization: this.transfers ? this.transfers.to_organization_id : '',
      toOrganization: '',
      oldSubinventoryCode: this.transfers ? this.transfers.to_subinventory_code : '',
      toSubinventory: '',
      oldInventoryLocationId: this.transfers ? this.transfers.to_locator_id : '',
      toLocations: this.transfers ? this.transfers.to_locator_id : '',
      toOrganizationId: this.transfers ? this.transfers.to_organization_id : '',
      itemCatId: this.transfers ? this.transfers.item_cat_code : '',
      oldRequestType: this.transfers ? this.transfers.request_type_code : '',
      requestType: this.transfers ? this.transfers.request_type_code : '',
      locationsList: [],
      subinventoryList: [],
      organizationList: [],
      isDisabledToLocations: true,
      isDisabledSubinventory: true,
      isDisabledOrganization: true,
      loading: {
        toOrganization: false,
        toLocations: false,
        toSubinventory: false
      },
      firstLoad: true
    };
  },
  mounted: function mounted() {
    // console.log(this.transfers)
    this.getOrganization(this.transfers ? this.transfers.item_cat_code : ''); // this.getSubinventory(this.transfers ? this.transfers.to_organization_id : '');
    // this.getLocations(this.transfers ? this.transfers.to_subinventory_code : '', this.transfers ? this.transfers.to_organization_id : '');
  },
  methods: {
    getOrganization: function getOrganization(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                params = {
                  itemCat: value
                };
                _this.loading.toOrganization = true;
                _this.loading.toSubinventory = true;
                _this.loading.toLocations = true;
                _context.next = 6;
                return axios.get('/pm/ajax/setup-transfer/get-organization', {
                  params: params
                }).then(function (res) {
                  // console.log(res.data.organizationList);
                  if (_this.itemCat == _this.itemCatId) {
                    _this.toOrganization = _this.transfers ? _this.transfers.to_organization_id : '';
                    _this.isDisabledOrganization = false;
                    _this.organizationList = res.data.organizationList;
                    _this.loading.toOrganization = false;

                    _this.getSubinventory(_this.transfers ? _this.transfers.to_organization_id : '');

                    _this.getLocations(_this.transfers ? _this.transfers.to_subinventory_code : '', _this.transfers ? _this.transfers.to_organization_id : '');
                  } else {
                    _this.toOrganization = '';
                    _this.isDisabledOrganization = false;
                    _this.organizationList = res.data.organizationList;
                    _this.loading.toOrganization = false;
                    _this.toSubinventory = '';
                    _this.isDisabledSubinventory = true;
                    _this.subinventoryList = res.data.subinventoryList;
                    _this.loading.toSubinventory = false;
                    _this.toLocations = '';
                    _this.isDisabledToLocations = true;
                    _this.loading.toLocations = false;
                  }
                });

              case 6:
                return _context.abrupt("return", _context.sent);

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getSubinventory: function getSubinventory(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                params = {
                  toOrganization: value
                };
                _this2.loading.toSubinventory = true;
                _this2.loading.toLocations = true;
                _context2.next = 5;
                return axios.get('/pm/ajax/setup-transfer/get-subinventory', {
                  params: params
                }).then(function (res) {
                  // console.log(res.data.subinventoryList);
                  if (res.data.subinventoryList == '') {
                    _this2.toSubinventory = '';
                    _this2.isDisabledSubinventory = true;
                    _this2.loading.toSubinventory = false;
                    _this2.toLocations = '';
                    _this2.isDisabledToLocations = true;
                    _this2.loading.toLocations = false;
                    swal({
                      title: "warning !",
                      text: "Organizationนี้ ยังไม่มีคลังจัดเก็บ",
                      type: "warning",
                      showConfirmButton: true
                    });
                  } else {
                    if (_this2.toOrganization == _this2.toOrganizationId) {
                      _this2.toSubinventory = _this2.transfers ? _this2.transfers.to_subinventory_code : '';
                      _this2.isDisabledSubinventory = false;
                      _this2.subinventoryList = res.data.subinventoryList;
                      _this2.loading.toSubinventory = false;
                    } else {
                      _this2.toSubinventory = '';
                      _this2.isDisabledSubinventory = false;
                      _this2.subinventoryList = res.data.subinventoryList;
                      _this2.loading.toSubinventory = false;
                      _this2.toLocations = '';
                      _this2.isDisabledToLocations = true;
                      _this2.loading.toLocations = false;
                    }
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
    getLocations: function getLocations(value, value1) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                params = {
                  subinventory: value,
                  toOrganizationId: value1
                };
                _this3.loading.toLocations = true;
                _context3.next = 4;
                return axios.get('/pm/ajax/setup-transfer/get-locations', {
                  params: params
                }).then(function (res) {
                  // console.log(res.data.ListLocations);
                  if (res.data.locationsList == '') {
                    _this3.toLocations = '';
                    _this3.isDisabledToLocations = true;
                    _this3.loading.toLocations = false;
                    swal({
                      title: "warning !",
                      text: "คลังจัดเก็บนี้ ยังไม่มีสถานที่จัดเก็บ",
                      type: "warning",
                      showConfirmButton: true
                    });
                  } else {
                    // if(this.toOrganization == this.toOrganizationId){
                    //     this.toLocations = this.transfers ? this.transfers.to_locator_id : '';
                    //     this.isDisabledToLocations = false;
                    //     this.locationsList = res.data.locationsList;
                    //     this.loading.toLocations = false;
                    // }else{
                    //     this.toLocations = '';
                    //     this.isDisabledToLocations = false;
                    //     this.locationsList = res.data.locationsList;
                    //     this.loading.toLocations = false;
                    // }
                    if (_this3.firstLoad) {
                      _this3.toLocations = _this3.transfers ? _this3.transfers.to_locator_id : '';
                      _this3.isDisabledToLocations = false;
                      _this3.locationsList = res.data.locationsList;
                      _this3.loading.toLocations = false;
                      _this3.firstLoad = false;
                    } else {
                      _this3.toLocations = '';
                      _this3.isDisabledToLocations = false;
                      _this3.locationsList = res.data.locationsList;
                      _this3.loading.toLocations = false;
                    }
                  }
                });

              case 4:
                return _context3.abrupt("return", _context3.sent);

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/SetupTransfer/editComponent.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/pm/SetupTransfer/editComponent.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _editComponent_vue_vue_type_template_id_03a52eb6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editComponent.vue?vue&type=template&id=03a52eb6& */ "./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=template&id=03a52eb6&");
/* harmony import */ var _editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _editComponent_vue_vue_type_template_id_03a52eb6___WEBPACK_IMPORTED_MODULE_0__.render,
  _editComponent_vue_vue_type_template_id_03a52eb6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/SetupTransfer/editComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./editComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=template&id=03a52eb6&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=template&id=03a52eb6& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_template_id_03a52eb6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_template_id_03a52eb6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_template_id_03a52eb6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./editComponent.vue?vue&type=template&id=03a52eb6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=template&id=03a52eb6&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=template&id=03a52eb6&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/SetupTransfer/editComponent.vue?vue&type=template&id=03a52eb6& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        {
          staticClass: "col",
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.oldRequestType,
                expression: "oldRequestType"
              }
            ],
            attrs: { type: "hidden", name: "oldRequestType" },
            domProps: { value: _vm.oldRequestType },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.oldRequestType = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.requestType,
                expression: "requestType"
              }
            ],
            attrs: { type: "hidden", name: "request_type" },
            domProps: { value: _vm.requestType },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.requestType = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("ประเภทการเบิก")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                placeholder: "โปรดเลือก ประเภทการเบิก",
                "reserve-keyword": "",
                filterable: ""
              },
              model: {
                value: _vm.requestType,
                callback: function($$v) {
                  _vm.requestType = $$v
                },
                expression: "requestType"
              }
            },
            _vm._l(_vm.requestTypes, function(Type, index) {
              return _c("el-option", {
                key: index,
                attrs: { label: Type.description, value: Type.lookup_code }
              })
            }),
            1
          )
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.setupTransId,
          expression: "setupTransId"
        }
      ],
      attrs: { type: "hidden", name: "setup_trans_id" },
      domProps: { value: _vm.setupTransId },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.setupTransId = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        {
          staticClass: "col",
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("label", [_vm._v("Organization")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: true },
            model: {
              value: _vm.fromOrganization,
              callback: function($$v) {
                _vm.fromOrganization = $$v
              },
              expression: "fromOrganization"
            }
          })
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
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.oldItemCat,
                expression: "oldItemCat"
              }
            ],
            attrs: { type: "hidden", name: "old_item_cat" },
            domProps: { value: _vm.oldItemCat },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.oldItemCat = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.itemCat,
                expression: "itemCat"
              }
            ],
            attrs: { type: "hidden", name: "item_cat" },
            domProps: { value: _vm.itemCat },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.itemCat = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("ประเภทวัตถุดิบ")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                placeholder: "Select",
                "reserve-keyword": "",
                filterable: ""
              },
              on: {
                change: function($event) {
                  return _vm.getOrganization(_vm.itemCat)
                }
              },
              model: {
                value: _vm.itemCat,
                callback: function($$v) {
                  _vm.itemCat = $$v
                },
                expression: "itemCat"
              }
            },
            _vm._l(_vm.itemCats, function(itemCat, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: itemCat.meaning + " : " + itemCat.description,
                  value: itemCat.lookup_code
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
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.toOrganization,
          expression: "toOrganization"
        }
      ],
      attrs: { type: "hidden", name: "toOrganization" },
      domProps: { value: _vm.toOrganization },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.toOrganization = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        {
          staticClass: "col",
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.oldToOrganization,
                expression: "oldToOrganization"
              }
            ],
            attrs: { type: "hidden", name: "oldToOrganization" },
            domProps: { value: _vm.oldToOrganization },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.oldToOrganization = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.toOrganization,
                expression: "toOrganization"
              }
            ],
            attrs: { type: "hidden", name: "toOrganization" },
            domProps: { value: _vm.toOrganization },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.toOrganization = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("Organization รับวัตถุดิบ")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading.toOrganization,
                  expression: "loading.toOrganization"
                }
              ],
              staticClass: "w-100",
              attrs: {
                placeholder: "Select",
                disabled: _vm.isDisabledOrganization,
                "reserve-keyword": "",
                filterable: ""
              },
              on: {
                change: function($event) {
                  return _vm.getSubinventory(_vm.toOrganization)
                }
              },
              model: {
                value: _vm.toOrganization,
                callback: function($$v) {
                  _vm.toOrganization = $$v
                },
                expression: "toOrganization"
              }
            },
            _vm._l(_vm.organizationList, function(org, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: org.organization
                    ? org.organization.organization_code +
                      " : " +
                      org.organization.organization_name
                    : org.parameter.organization_code,
                  value: org.organization_id
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
        {
          staticClass: "col",
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.oldSubinventoryCode,
                expression: "oldSubinventoryCode"
              }
            ],
            attrs: { type: "hidden", name: "oldSubinventoryCode" },
            domProps: { value: _vm.oldSubinventoryCode },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.oldSubinventoryCode = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.toSubinventory,
                expression: "toSubinventory"
              }
            ],
            attrs: { type: "hidden", name: "subinventory_code" },
            domProps: { value: _vm.toSubinventory },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.toSubinventory = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("คลังจัดเก็บ")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading.toSubinventory,
                  expression: "loading.toSubinventory"
                }
              ],
              staticClass: "w-100",
              attrs: {
                placeholder: "โปรดเลือก คลังจัดเก็บ",
                disabled: _vm.isDisabledSubinventory,
                "reserve-keyword": "",
                filterable: ""
              },
              on: {
                change: function($event) {
                  return _vm.getLocations(
                    _vm.toSubinventory,
                    _vm.toOrganization
                  )
                }
              },
              model: {
                value: _vm.toSubinventory,
                callback: function($$v) {
                  _vm.toSubinventory = $$v
                },
                expression: "toSubinventory"
              }
            },
            _vm._l(_vm.subinventoryList, function(subinventory, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label:
                    subinventory.subinventory_code +
                    " : " +
                    subinventory.subinventory_desc,
                  value: subinventory.subinventory_code
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
        {
          staticClass: "col",
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.oldInventoryLocationId,
                expression: "oldInventoryLocationId"
              }
            ],
            attrs: { type: "hidden", name: "oldInventoryLocationId" },
            domProps: { value: _vm.oldInventoryLocationId },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.oldInventoryLocationId = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.toLocations,
                expression: "toLocations"
              }
            ],
            attrs: { type: "hidden", name: "inventory_location_id" },
            domProps: { value: _vm.toLocations },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.toLocations = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("สถานที่จัดเก็บ")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading.toLocations,
                  expression: "loading.toLocations"
                }
              ],
              staticClass: "w-100",
              attrs: {
                placeholder: "โปรดเลือก สถานที่จัดเก็บ",
                disabled: _vm.isDisabledToLocations,
                "reserve-keyword": "",
                filterable: ""
              },
              model: {
                value: _vm.toLocations,
                callback: function($$v) {
                  _vm.toLocations = $$v
                },
                expression: "toLocations"
              }
            },
            _vm._l(_vm.locationsList, function(locations, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: locations.segment2 + " : " + locations.description,
                  value: locations.inventory_location_id
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
        {
          staticClass: "col",
          staticStyle: {
            "margin-right": "300px",
            "margin-left": "300px",
            "padding-top": "15px"
          }
        },
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.oldEnableFlag,
                expression: "oldEnableFlag"
              }
            ],
            attrs: { type: "hidden", name: "oldEnableFlag" },
            domProps: { value: _vm.oldEnableFlag },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.oldEnableFlag = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.newEnableFlag,
                expression: "newEnableFlag"
              }
            ],
            attrs: { type: "hidden", name: "newEnableFlag" },
            domProps: { value: _vm.newEnableFlag },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.newEnableFlag = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("label", [_vm._v("สถานะการใช้งาน")]),
          _vm._v(" "),
          _c("el-checkbox", {
            staticClass: "w-100",
            model: {
              value: _vm.newEnableFlag,
              callback: function($$v) {
                _vm.newEnableFlag = $$v
              },
              expression: "newEnableFlag"
            }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);