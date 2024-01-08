(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_SearchSequenceEcomComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['sequenceEcoms', 'salesTypes', 'productTypeDomestics', 'productTypeExports', 'searchData', 'actionUrl'],
  data: function data() {
    return {
      item_id: '',
      ecom_item: '',
      sales_type: '',
      status: '',
      product_type: '',
      itemLoading: false,
      productTypes: [],
      itemLists: [],
      productTypeLoading: true,
      statusOptions: [{
        value: 'Active',
        label: 'Active'
      }, {
        value: 'Inactive',
        label: 'Inactive'
      }]
    };
  },
  mounted: function mounted() {
    this.getItems();

    if (this.searchData) {
      this.item_id = this.searchData.item_id ? this.searchData.item_id : '';
      this.ecom_item = this.searchData.ecom_item ? this.searchData.ecom_item : '';
      this.sales_type = this.searchData.sales_type ? this.searchData.sales_type : '';
      this.status = this.searchData.status ? this.searchData.status : '';
      this.product_type = this.searchData.product_type ? this.searchData.product_type : ''; // console.log('searchData <---> ' + this.searchData.product_type);
    }

    if (this.sales_type) {
      this.getSelectesalesType();
    }
  },
  methods: {
    getSelectesalesType: function getSelectesalesType() {
      var _this = this;

      this.productTypeLoading = true;

      if (this.sales_type) {
        if (this.sales_type == 'DOMESTIC') {
          this.productTypes = this.productTypeDomestics;

          if (this.searchData.product_type) {
            this.selectedData = this.productTypes.find(function (i) {
              return i.lookup_code == _this.searchData.product_type;
            });
            this.product_type = this.selectedData.lookup_code;
          }
        } else {
          this.productTypes = this.productTypeExports;

          if (this.searchData.product_type) {
            this.selectedData = this.productTypes.find(function (i) {
              return i.lookup_code == _this.searchData.product_type;
            });
            this.product_type = this.selectedData.lookup_code;
          }
        }

        this.productTypeLoading = false;
      } else {
        this.product_type = "";
      }
    },
    getItems: function getItems() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.itemLoading = true;
                _this2.itemLists = [];
                _context.next = 4;
                return axios.get("/om/ajax/get-item-search", {
                  params: {
                    sales_type: _this2.sales_type,
                    product_type: _this2.product_type
                  }
                }).then(function (res) {
                  _this2.itemLoading = false;
                  _this2.itemLists = res.data;
                })["catch"](function (err) {
                  console.log(err);
                });

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/SearchSequenceEcomComponent.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/om/SearchSequenceEcomComponent.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchSequenceEcomComponent_vue_vue_type_template_id_6c7e4f12___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12& */ "./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12&");
/* harmony import */ var _SearchSequenceEcomComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchSequenceEcomComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchSequenceEcomComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchSequenceEcomComponent_vue_vue_type_template_id_6c7e4f12___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchSequenceEcomComponent_vue_vue_type_template_id_6c7e4f12___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/SearchSequenceEcomComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSequenceEcomComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchSequenceEcomComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSequenceEcomComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSequenceEcomComponent_vue_vue_type_template_id_6c7e4f12___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSequenceEcomComponent_vue_vue_type_template_id_6c7e4f12___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSequenceEcomComponent_vue_vue_type_template_id_6c7e4f12___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/SearchSequenceEcomComponent.vue?vue&type=template&id=6c7e4f12& ***!
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
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ประเภทการขาย : ")]),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "sales_type", autocomplete: "off" },
            domProps: { value: _vm.sales_type }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: ""
              },
              on: {
                change: function($event) {
                  _vm.getSelectesalesType()
                  _vm.getItems()
                }
              },
              model: {
                value: _vm.sales_type,
                callback: function($$v) {
                  _vm.sales_type = $$v
                },
                expression: "sales_type"
              }
            },
            _vm._l(_vm.salesTypes, function(type) {
              return _c("el-option", {
                key: type.value,
                attrs: { label: type.description, value: type.value }
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
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ชนิดผลิตภัณฑ์ : ")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "product_type",
              autocomplete: "off"
            },
            domProps: { value: _vm.product_type }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: "",
                disabled: this.productTypeLoading
              },
              on: {
                change: function($event) {
                  return _vm.getItems()
                }
              },
              model: {
                value: _vm.product_type,
                callback: function($$v) {
                  _vm.product_type = $$v
                },
                expression: "product_type"
              }
            },
            _vm._l(_vm.productTypes, function(productType) {
              return _c("el-option", {
                key: productType.lookup_code,
                attrs: {
                  label: productType.description,
                  value: productType.lookup_code
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
          _c("label", [_vm._v(" สถานะการใช้งาน : ")]),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "status", autocomplete: "off" },
            domProps: { value: _vm.status }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: ""
              },
              model: {
                value: _vm.status,
                callback: function($$v) {
                  _vm.status = $$v
                },
                expression: "status"
              }
            },
            _vm._l(_vm.statusOptions, function(statusOption) {
              return _c("el-option", {
                key: statusOption.value,
                attrs: { label: statusOption.label, value: statusOption.value }
              })
            }),
            1
          )
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ชื่อตราผลิตภัณฑ์ : ")]),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "item_id", autocomplete: "off" },
            domProps: { value: _vm.item_id }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: ""
              },
              model: {
                value: _vm.item_id,
                callback: function($$v) {
                  _vm.item_id = $$v
                },
                expression: "item_id"
              }
            },
            _vm._l(_vm.itemLists, function(data, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: data.item_code + " : " + data.item_description,
                  value: data.item_id
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
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ชื่อที่ปรากฏในหน้าจอ E-Commerce : ")]),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "ecom_item", autocomplete: "off" },
            domProps: { value: _vm.ecom_item }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: ""
              },
              model: {
                value: _vm.ecom_item,
                callback: function($$v) {
                  _vm.ecom_item = $$v
                },
                expression: "ecom_item"
              }
            },
            _vm._l(_vm.itemLists, function(data, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: data.item_code + " : " + data.item_description,
                  value: data.item_id
                }
              })
            }),
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-2" }, [
        _c("label", { staticClass: " tw-font-bold tw-uppercase mb-0" }, [
          _vm._v(" ")
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "text-right" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass: "btn btn-warning btn-sm",
              attrs: { href: this.actionUrl }
            },
            [_c("i", { staticClass: "fa fa-undo" }), _vm._v(" รีเซต")]
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      { staticClass: "btn btn-light btn-sm", attrs: { type: "submit" } },
      [
        _c("i", {
          staticClass: "fa fa-search",
          attrs: { "aria-hidden": "true" }
        }),
        _vm._v(" ค้นหา\n                ")
      ]
    )
  }
]
render._withStripped = true



/***/ })

}]);