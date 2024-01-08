(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_ImproveFineExpComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ImproveFineExpComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ImproveFineExpComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['customers', 'customer', 'invoices', 'orderNumbers', 'saNumbers', 'piNumbers', 'dataSearch'],
  data: function data() {
    return {
      total_fine_due: '',
      order_number: this.dataSearch ? this.dataSearch.order_number : '',
      sa_number: this.dataSearch ? this.dataSearch.sa_number : '',
      due_date: this.dataSearch ? this.dataSearch.due_date : '',
      pi_number: this.dataSearch ? this.dataSearch.pi_number : '',
      fine_flag: this.dataSearch ? this.dataSearch.fine_flag : '',
      invoice_no: this.dataSearch ? this.dataSearch.invoice_no : '',
      customer_id: this.dataSearch ? this.dataSearch.customer_id ? Number(this.dataSearch.customer_id) : '' : '',
      country_name: '',
      checkCustomer: this.customer ? true : false,
      check_search: true,
      saNumberList: [],
      orderNumberList: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.total_fine_due = new Date();

    if (this.customer_id) {
      this.selectedData = this.customers.find(function (i) {
        return i.customer_id == _this.customer_id;
      });

      if (this.selectedData) {
        // ประเทศ
        this.country_name = this.selectedData.country_name;
      }
    }
  },
  methods: {
    sortArrays: function sortArrays(arrays) {
      return _.orderBy(arrays, 'value', 'asc');
    },
    getDataFilter: function getDataFilter() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var saFilter, orderFilter;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.saNumberList = [];
                _this2.orderNumberList = [];

                if (_this2.customer_id) {
                  _this2.selectedData = _this2.customers.find(function (i) {
                    return i.customer_id == _this2.customer_id;
                  });
                  saFilter = _this2.saNumbers.filter(function (data) {
                    return data.customer_number == _this2.selectedData.customer_number;
                  });
                  _this2.saNumberList = saFilter;
                  orderFilter = _this2.orderNumbers.filter(function (data) {
                    return data.customer_number == _this2.selectedData.customer_number;
                  });
                  _this2.orderNumberList = orderFilter;
                }

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getCustomerDetail: function getCustomerDetail() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.country_name = '';
                _this3.invoice_no = '';
                _this3.order_number = '', _this3.sa_number = '', _this3.pi_number = '', _this3.selectedData = _this3.customers.find(function (i) {
                  return i.customer_id == _this3.customer_id;
                });

                if (_this3.selectedData) {
                  // ประเทศ
                  _this3.country_name = _this3.selectedData.country_name; // // เลข invoice
                  // this.selectedInvoice = this.invoices.find( data => {
                  //     return data.customer_number == this.selectedData.customer_number;
                  // });
                  // if (this.selectedInvoice) {
                  //     this.invoice_no = this.selectedInvoice.value;
                  // }
                  // // เลขที่ใบสั่งซื้อ
                  // this.selectedOrderNumber = this.orderNumbers.find( data => {
                  //     return data.customer_number == this.selectedData.customer_number;
                  // });
                  // if (this.selectedOrderNumber) {
                  //     this.order_number = this.selectedOrderNumber.value;
                  // }
                  // // เลขที่ใบ SA
                  // this.selecteSA = this.saNumbers.find( data => {
                  //     return data.customer_number == this.selectedData.customer_number;
                  // });
                  // if (this.selecteSA) {
                  //     this.sa_number = this.selecteSA.value;
                  // }
                  // // เลขที่ใบ PI
                  // this.selectePI = this.piNumbers.find( data => {
                  //     return data.customer_number == this.selectedData.customer_number;
                  // });
                  // if (this.selectePI) {
                  //     this.pi_number = this.selectePI.value;
                  // }
                }

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/ImproveFineExpComponent.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/om/ImproveFineExpComponent.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImproveFineExpComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/ImproveFineExpComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;



/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__.default)(
  _ImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default,
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/ImproveFineExpComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/ImproveFineExpComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/om/ImproveFineExpComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImproveFineExpComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ImproveFineExpComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImproveFineExpComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ })

}]);