(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_approval-claim_indexComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['claimStatusList', 'headersList', 'customerList', 'btnTrans'],
  mounted: function mounted() {
    this.datatable = $("#datatable").dataTable({
      searching: false,
      ordering: false,
      responsive: true
    });
  },
  data: function data() {
    var _ref;

    return _ref = {
      form_search: {
        customerNumber: '',
        customerCompany: '',
        claimNumber: '',
        claimDate: '',
        statusClaim: '',
        headerList: []
      },
      lineList: [],
      loading: false,
      table: false,
      disenable: {
        checkStatusDisenable: '',
        checkStatusEnable: ''
      }
    }, _defineProperty(_ref, "loading", false), _defineProperty(_ref, "customersList", this.customerList), _defineProperty(_ref, "datatable", ''), _ref;
  },
  methods: {
    getCustomerCompany: function getCustomerCompany(customerId) {
      var vm = this;
      this.customerList.forEach(function (element) {
        if (element.customer_id == customerId) {
          vm.form_search.customerCompany = element.customer_id ? element.customer_id : '';
        }

        if (!customerId) {
          vm.form_search.customerCompany = '';
        }
      });
    },
    getSearch: function getSearch() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.datatable.fnDestroy();
                _this.loading = true; // console.log(vm.form_search)

                _context.next = 5;
                return axios.post('ajax/approval-claim/get-search', _objectSpread({}, vm.form_search)).then(function (res) {
                  _this.lineList = res.data.headerList;
                });

              case 5:
                vm.datatable = $("#datatable").dataTable({
                  searching: false,
                  ordering: false,
                  responsive: true
                });
                vm.loading = false;

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getDateFormatted: function getDateFormatted(date) {
      return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY");
    },
    onDateFromWasSelected: function onDateFromWasSelected(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                vm.form_search.claimDate = _this2.getDateFormatted(value);

              case 2:
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
        this.loading = true;
        setTimeout(function () {
          _this3.loading = false;
          _this3.customersList = _this3.customerList.filter(function (item) {
            return item.customer_name.toLowerCase().indexOf(query.toLowerCase()) > -1 || item.customer_number.toLowerCase().indexOf(query.toLowerCase()) > -1;
          });
        }, 200);
      } else {
        this.customersList = this.customerList;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/approval-claim/indexComponent.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/om/approval-claim/indexComponent.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _indexComponent_vue_vue_type_template_id_9facbfbc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./indexComponent.vue?vue&type=template&id=9facbfbc& */ "./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=template&id=9facbfbc&");
/* harmony import */ var _indexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./indexComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _indexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _indexComponent_vue_vue_type_template_id_9facbfbc___WEBPACK_IMPORTED_MODULE_0__.render,
  _indexComponent_vue_vue_type_template_id_9facbfbc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/approval-claim/indexComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_indexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./indexComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_indexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=template&id=9facbfbc&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=template&id=9facbfbc& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_indexComponent_vue_vue_type_template_id_9facbfbc___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_indexComponent_vue_vue_type_template_id_9facbfbc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_indexComponent_vue_vue_type_template_id_9facbfbc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./indexComponent.vue?vue&type=template&id=9facbfbc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=template&id=9facbfbc&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=template&id=9facbfbc&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/indexComponent.vue?vue&type=template&id=9facbfbc& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
      staticClass: "row col-md-12"
    },
    [
      _c("div", { staticClass: "col-xl-6 m-auto" }, [
        _c("h3", { staticClass: "black mb-3" }, [
          _vm._v("ค้นหารายการที่ต้องการ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "form-group" },
          [
            _c("label", { staticClass: "d-block" }, [_vm._v("รหัสร้านค้า")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  placeholder: "รหัสร้านค้า",
                  clearable: "",
                  filterable: "",
                  remote: "",
                  "remote-method": _vm.remoteMethod,
                  loading: _vm.loading
                },
                on: {
                  change: function($event) {
                    return _vm.getCustomerCompany(
                      _vm.form_search.customerNumber
                    )
                  }
                },
                model: {
                  value: _vm.form_search.customerNumber,
                  callback: function($$v) {
                    _vm.$set(_vm.form_search, "customerNumber", $$v)
                  },
                  expression: "form_search.customerNumber"
                }
              },
              _vm._l(_vm.customersList, function(customer, index) {
                return _c(
                  "el-option",
                  {
                    key: index,
                    staticStyle: { height: "60px" },
                    attrs: {
                      label: customer.customer_number,
                      value: customer.customer_id
                    }
                  },
                  [
                    _c("span", { staticStyle: { float: "left" } }, [
                      _vm._v(_vm._s(customer.customer_number))
                    ]),
                    _c("br"),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        staticStyle: {
                          float: "left",
                          color: "#8492a6",
                          "font-size": "14px"
                        }
                      },
                      [_vm._v(_vm._s(customer.customer_name))]
                    )
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
          "div",
          { staticClass: "form-group" },
          [
            _c("label", { staticClass: "d-block" }, [_vm._v("ชื่อร้านค้า")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: { placeholder: "ชื่อร้านค้า", disabled: "" },
                model: {
                  value: _vm.form_search.customerCompany,
                  callback: function($$v) {
                    _vm.$set(_vm.form_search, "customerCompany", $$v)
                  },
                  expression: "form_search.customerCompany"
                }
              },
              _vm._l(_vm.customerList, function(customer, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: customer.customer_name,
                    value: customer.customer_id
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
          { staticClass: "form-group" },
          [
            _c("label", { staticClass: "d-block" }, [
              _vm._v("เลขที่ใบแจ้งเคลมสินค้า")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  placeholder: "เลขที่ใบแจ้งเคลมสินค้า",
                  clearable: "",
                  filterable: ""
                },
                model: {
                  value: _vm.form_search.claimNumber,
                  callback: function($$v) {
                    _vm.$set(_vm.form_search, "claimNumber", $$v)
                  },
                  expression: "form_search.claimNumber"
                }
              },
              _vm._l(_vm.headersList, function(header, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: header.claim_number,
                    value: header.claim_number
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
          { staticClass: "form-group" },
          [
            _c("label", { staticClass: "d-block" }, [
              _vm._v("วันที่แจ้งเคลมสินค้า")
            ]),
            _vm._v(" "),
            _c("datepicker-th", {
              staticClass: "w-100 form-control md:tw-mb-0 tw-mb-2",
              attrs: {
                placeholder: "วันที่แจ้งเคลมสินค้า",
                format: "DD/MM/YYYY"
              },
              on: { dateWasSelected: _vm.onDateFromWasSelected },
              model: {
                value: _vm.form_search.claimDate,
                callback: function($$v) {
                  _vm.$set(_vm.form_search, "claimDate", $$v)
                },
                expression: "form_search.claimDate"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "form-group" },
          [
            _c("label", { staticClass: "d-block" }, [_vm._v("สถานะ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: { placeholder: "สถานะ", clearable: "" },
                model: {
                  value: _vm.form_search.statusClaim,
                  callback: function($$v) {
                    _vm.$set(_vm.form_search, "statusClaim", $$v)
                  },
                  expression: "form_search.statusClaim"
                }
              },
              _vm._l(_vm.claimStatusList, function(statu, index) {
                return _c("el-option", {
                  key: index,
                  attrs: { label: statu.meaning, value: statu.lookup_code }
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
          {
            staticClass: "form-buttons no-border",
            staticStyle: { "text-align": "center" }
          },
          [
            _c(
              "button",
              {
                class: _vm.btnTrans.search.class,
                staticStyle: { height: "52px", width: "222px" },
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.getSearch()
                  }
                }
              },
              [
                _c("i", { class: _vm.btnTrans.search.icon }),
                _vm._v(
                  "\n                " +
                    _vm._s(_vm.btnTrans.search.text) +
                    "\n            "
                )
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c("approval-claim-table", {
        attrs: {
          lineList: _vm.lineList,
          checkStatus: _vm.disenable.checkStatusDisenable,
          checkStatusEnable: _vm.disenable.checkStatusEnable,
          btnTrans: _vm.btnTrans
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);