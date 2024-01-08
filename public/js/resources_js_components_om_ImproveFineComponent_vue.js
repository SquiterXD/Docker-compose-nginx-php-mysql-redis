(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_ImproveFineComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ImproveFineComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ImproveFineComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
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


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['customers', 'invoices', 'customerSearch', 'dueDateSearch', 'invoiceNoSearch', 'fineFlagSearch', 'totalFineDueSearch', 'invoiceDateSearch'],
  data: function data() {
    return {
      total_fine_due: '',
      due_date: this.dueDateSearch ? this.dueDateSearch : '',
      fine_flag: this.fineFlagSearch ? this.fineFlagSearch == 'Y' ? true : false : true,
      invoice_no: this.invoiceNoSearch ? this.invoiceNoSearch : '',
      invoice_date: this.invoiceDateSearch ? this.invoiceDateSearch : '',
      customer_id: this.customerSearch ? Number(this.customerSearch) : '',
      province_name: '',
      cancel_flag: '',
      checkCustomer: this.customer ? true : false,
      invoiceDateDisabled: false,
      // fine_flag: true,
      lists: [],
      invoiceLists: this.invoices,
      customerLists: this.customers
    };
  },
  mounted: function mounted() {
    // if (this.due_date) {
    //     this.due_date = this.showDate(this.due_date);
    // }
    // if (this.totalFineDueSearch) {
    //     console.log('Date Search');
    //     this.total_fine_due = this.showDate(this.totalFineDueSearch);
    // } else {
    //     console.log('Date');
    //     this.total_fine_due = this.showDate(new Date());
    // }   
    this.showDate();

    if (this.customer_id) {
      this.getCustomerDetail();
    }

    if (this.invoice_no) {
      this.getInvoiceDetail();
    }
  },
  methods: {
    sortArrays: function sortArrays(arrays) {
      return _.orderBy(arrays, 'invoice_no', 'asc');
    },
    showDate: function showDate() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var date1, date, _date;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.due_date) {
                  _context.next = 5;
                  break;
                }

                _context.next = 3;
                return helperDate.parseToDateTh(_this.due_date, 'yyyy/MM/DD');

              case 3:
                date1 = _context.sent;
                _this.due_date = date1;

              case 5:
                if (!_this.totalFineDueSearch) {
                  _context.next = 12;
                  break;
                }

                _context.next = 8;
                return helperDate.parseToDateTh(_this.totalFineDueSearch, 'yyyy/MM/DD');

              case 8:
                date = _context.sent;
                _this.total_fine_due = date;
                _context.next = 16;
                break;

              case 12:
                _context.next = 14;
                return helperDate.parseToDateTh(new Date(), 'yyyy/MM/DD');

              case 14:
                _date = _context.sent;
                _this.total_fine_due = _date;

              case 16:
                if (!_this.invoice_date) {
                  _context.next = 21;
                  break;
                }

                _context.next = 19;
                return helperDate.parseToDateTh(_this.invoice_date, 'yyyy/MM/DD');

              case 19:
                date1 = _context.sent;
                _this.invoice_date = date1;

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getCustomerDetail: function getCustomerDetail() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.province_name = '';
                _this2.selectedData = _this2.customerLists.find(function (i) {
                  return i.customer_id == _this2.customer_id;
                });

                if (_this2.selectedData) {
                  _this2.province_name = _this2.selectedData.province_name;
                }

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getInvoiceDetail: function getInvoiceDetail() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var pick_date;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                console.log('getInvoiceDetail <-> ', _this3.invoice_no);

                if (!_this3.invoice_no) {
                  _context3.next = 12;
                  break;
                }

                _this3.invoiceDateDisabled = true;
                _this3.selectedData = _this3.invoiceLists.find(function (data) {
                  return data.invoice_no == _this3.invoice_no;
                });

                if (!_this3.selectedData) {
                  _context3.next = 10;
                  break;
                }

                if (!_this3.selectedData.invoice_date) {
                  _context3.next = 10;
                  break;
                }

                _context3.next = 8;
                return helperDate.parseToDateTh(_this3.selectedData.invoice_date, 'yyyy/MM/DD');

              case 8:
                pick_date = _context3.sent;
                _this3.invoice_date = pick_date;

              case 10:
                _context3.next = 14;
                break;

              case 12:
                _this3.invoiceDateDisabled = false;
                _this3.invoice_date = '';

              case 14:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onShowDetailClicked: function onShowDetailClicked() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                console.log('คำนวณค่าปรับ');
                _this4.lists = [], axios.get("/om/ajax/get-fine-list", {
                  params: {
                    total_fine_due: _this4.total_fine_due,
                    due_date: _this4.due_date,
                    fine_flag: _this4.fine_flag,
                    invoice_no: _this4.invoice_no,
                    invoice_date: _this4.invoice_date,
                    customer_id: _this4.customer_id
                  }
                }).then(function (res) {
                  _this4.lists = res.data;
                });

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getInvoiceList: function getInvoiceList(query) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // console.log('getInvoiceList');
                _this5.invoiceLists = [];
                axios.get("/om/ajax/get-invoice-list", {
                  params: {
                    query: query
                  }
                }).then(function (res) {
                  _this5.invoiceLists = res.data;
                });

              case 2:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getCustomerList: function getCustomerList(query) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                console.log('getCustomerList');
                _this6.customerLists = [];
                axios.get("/om/ajax/get-customer-list", {
                  params: {
                    query: query
                  }
                }).then(function (res) {
                  _this6.customerLists = res.data;
                });

              case 3:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/ImproveFineComponent.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/om/ImproveFineComponent.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ImproveFineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImproveFineComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/ImproveFineComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;



/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__.default)(
  _ImproveFineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default,
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/ImproveFineComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/ImproveFineComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/om/ImproveFineComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImproveFineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImproveFineComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ImproveFineComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImproveFineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ })

}]);