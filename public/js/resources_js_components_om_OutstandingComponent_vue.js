(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_OutstandingComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OutstandingComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OutstandingComponent.vue?vue&type=script&lang=js& ***!
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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['customers', 'customer', 'customerTypes', 'days', 'dataSearch', 'creditGroups'],
  data: function data() {
    return {
      customer_id: this.customer ? Number(this.customer.customer_id) : this.dataSearch.customer_id ? Number(this.dataSearch.customer_id) : '',
      customer_name: '',
      date_selected: '',
      DataLists: [],
      isLoading: false,
      disabledDateTo: this.date_selected ? this.date_selected : null,
      test: '',
      // customer: this.customer ? this.customer : '',
      checkCustomer: this.customer ? true : false,
      currentDate: '',
      customer_type: this.dataSearch.customer_type ? this.dataSearch.customer_type : '',
      weekly_delivery_day: this.dataSearch.weekly_delivery_day ? this.dataSearch.weekly_delivery_day : '',
      check_search: this.dataSearch.check_search ? true : false,
      credit_group_code: this.dataSearch.credit_group_code ? this.dataSearch.credit_group_code : ''
    };
  },
  mounted: function mounted() {
    if (this.check_search) {
      if (this.dataSearch.date_selected) {
        this.date_selected = this.dataSearch.date_selected;
        this.showDate();
      }
    } else {
      this.date_selected = new Date();
      this.showDate();
    }
  },
  methods: {
    showDate: function showDate() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var date1;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return helperDate.parseToDateTh(_this.date_selected, 'yyyy/MM/DD');

              case 2:
                date1 = _context.sent;
                _this.date_selected = date1; // }

                console.log('date1 <--> ' + date1);
                console.log('this.date_selected <--> ' + _this.date_selected);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getCustomerName: function getCustomerName() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.customer_name = '';
                _this2.selectedData = _this2.customers.find(function (i) {
                  return i.customer_id == _this2.customer_id;
                });

                if (_this2.selectedData) {
                  _this2.customer_name = _this2.selectedData.customer_name;
                }

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getData: function getData() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.isLoading = true;
                _context3.next = 3;
                return axios.get("/om/outstanding-list", {
                  params: {
                    customer_id: _this3.customer_id,
                    date_selected: _this3.date_selected
                  }
                }).then(function (res) {
                  _this3.DataLists = res.data;
                  _this3.isLoading = false;
                });

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getYear: function getYear(value) {
      // console.log('order_date <---> ' + value.order_date);
      // console.log('outstanding_debt <---> ' + value.outstanding_debt);
      // this.isLoading = true;
      var momentDate = moment__WEBPACK_IMPORTED_MODULE_1___default()(value.order_date).format("YYYY-MM-DD");
      var date = momentDate.split("-");
      var Calyear = '';
      axios.get("/om/outstanding-year", {
        params: {
          year: date[0]
        }
      }).then(function (res) {
        console.log('test diff from controller <---> ' + res.data);
        Calyear = res.data;
        console.log('Calyear <---> ' + Calyear);
        return Calyear; // this.isLoading = false;
        // return year;
      });
    },
    fromDateWasSelected: function fromDateWasSelected(date) {
      // console.log('date -----> ' + date);
      // change disabled_date_to of to_date = from_date
      this.disabledDateTo = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY");
      this.date_selected = date;
    },
    formatPrice: function formatPrice(value) {
      var val = (value / 1).toFixed(2);
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    // async formatHelperDate(value) {
    //     this.currentDate = await helperDate.parseToDateTh(value, 'YYYY-MM-DD');
    //     // console.log('value <---> ' + value);
    //     // console.log('currentDate <---> ' + currentDate);
    //     // var val = moment(currentDate).format("DD/MM/YYYY");
    //     // console.log('val <---> ' + val);
    //     // return this.currentDate;
    // },
    formatDate: function formatDate(value) {
      if (value) {
        return moment__WEBPACK_IMPORTED_MODULE_1___default()(value).format("DD/MM/YYYY");
      } // console.log('parseToDateTh <---> ' + helperDate.parseToDateTh(value, 'DD/MM/YYYY'));
      // var date = this.formatHelperDate(value);
      // console.log('formatHelperDate <---> ' + this.formatHelperDate(value));
      // console.log('currentDate <---> ' + moment(this.currentDate).format("DD/MM/YYYY"));

    },
    fine: function fine(value) {
      var outstanding_debt = value;
      var cal = outstanding_debt * 15 / 100;
      var total = cal / 365;
      return total.toFixed(2);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/OutstandingComponent.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/om/OutstandingComponent.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OutstandingComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OutstandingComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/OutstandingComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;



/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__.default)(
  _OutstandingComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default,
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/OutstandingComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/OutstandingComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/om/OutstandingComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OutstandingComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OutstandingComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OutstandingComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OutstandingComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ })

}]);