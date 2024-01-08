(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_Prepare-Sale-Order_SearchComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['setName', 'setData', 'placeholder', 'setOptions', 'url', 'type', 'dependCust'],
  data: function data() {
    return {
      options: [],
      value: '',
      loading: false
    };
  },
  mounted: function mounted() {
    this.value = this.setData;
    this.getValueSetList(this.value);
    this.changeInput();
  },
  watch: {
    setData: function setData() {
      this.value = this.setData;
      this.getValueSetList(this.value);
      this.options = this.setOptions;
    },
    setOptions: function () {
      var _setOptions = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(newValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.options = newValue;

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function setOptions(_x) {
        return _setOptions.apply(this, arguments);
      }

      return setOptions;
    }()
  },
  methods: {
    getValueSetList: function getValueSetList(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this.loading = true;
                _context2.next = 3;
                return axios.get(_this.url, {
                  params: {
                    type: _this.type,
                    set_data: _this.value,
                    depend_cust: _this.dependCust,
                    query: query
                  }
                }).then(function (res) {
                  _this.options = res.data;

                  _this.changeInput();
                })["catch"](function (err) {
                  console.log(err);
                }).then(function () {
                  _this.loading = false;
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    changeInput: function changeInput() {
      var _this2 = this;

      if (this.setName == 'customer') {
        var cust_id = '';
        var cust_name = '';
        this.options.find(function (cust) {
          if (cust.flex_value == _this2.value) {
            cust_id = cust.flex_id;
            cust_name = cust.customer_name;
          }
        });
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          value_id: cust_id,
          value_name: cust_name,
          options: this.options
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['setName', 'setData', 'placeholder', 'setOptions', 'url', 'type', 'dependCust'],
  data: function data() {
    return {
      options: [],
      value: '',
      loading: false
    };
  },
  mounted: function mounted() {
    this.value = this.setData;
    this.getValueSetList(this.value);
    this.changeInput();
  },
  watch: {
    setData: function setData() {
      this.value = this.setData;
      this.getValueSetList(this.value);
      this.options = this.setOptions;
    },
    setOptions: function () {
      var _setOptions = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(newValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.options = newValue;

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function setOptions(_x) {
        return _setOptions.apply(this, arguments);
      }

      return setOptions;
    }()
  },
  methods: {
    getValueSetList: function getValueSetList(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this.loading = true;
                _context2.next = 3;
                return axios.get(_this.url, {
                  params: {
                    type: _this.type,
                    set_data: _this.value,
                    depend_cust: _this.dependCust,
                    query: query
                  }
                }).then(function (res) {
                  _this.options = res.data;

                  _this.changeInput();
                })["catch"](function (err) {
                  console.log(err);
                }).then(function () {
                  _this.loading = false;
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    changeInput: function changeInput() {
      var _this2 = this;

      if (this.setName == 'period') {
        var period_id = '';
        this.options.find(function (period) {
          if (period.flex_value == _this2.value) {
            period_id = period.flex_id;
          }
        });
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          value_id: period_id,
          options: this.options
        });
      }

      if (this.setName == 'pi') {
        var pi_id = '';
        this.options.find(function (pi) {
          if (pi.flex_value == _this2.value) {
            pi_id = pi.order_header_id;
          }
        });
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          value_id: pi_id,
          options: this.options
        });
      }

      if (this.setName == 'invoice') {
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          options: this.options
        });
      }

      if (this.setName == 'order_type') {
        var order_type_id = '';
        this.options.find(function (type) {
          if (type.flex_value == _this2.value) {
            order_type_id = type.flex_id;
          }
        });
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          value_id: order_type_id,
          options: this.options
        });
      }

      if (this.setName == 'so') {
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          options: this.options
        });
      }

      if (this.setName == 'prepare_so') {
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          options: this.options
        });
      }

      if (this.setName == 'sa') {
        this.$emit("def", {
          name: this.setName,
          value: this.value,
          options: this.options
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _InputValueComponent_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputValueComponent.vue */ "./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue");
/* harmony import */ var _CustomerInputValueComponent_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./CustomerInputValueComponent.vue */ "./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    InputValue: _InputValueComponent_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    CustInputValue: _CustomerInputValueComponent_vue__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ['type', 'paymentTypes', 'status', 'url', 'search', 'dateFormat', 'btnTrans', 'deliveryDate'],
  data: function data() {
    return {
      // List Data
      orderLists: [],
      prepareOrderLists: [],
      // prepare no, sa no ใช้ฟังก์ชัน เดียวกัน
      periodLists: [],
      piLists: [],
      invoiceLists: [],
      customerLists: [],
      orderTypeLists: [],
      //----------------------
      // so = sale order
      so_no: this.search && this.search['so_no'] != null ? this.search['so_no'] : '',
      prepare_so_no: this.search && this.search['prepare_so_no'] != null ? this.search['prepare_so_no'] : '',
      sa_no: this.search && this.search['sa_no'] != null ? this.search['sa_no'] : '',
      pi_id: this.search && this.search['pi_id'] != null ? this.search['pi_id'] : '',
      pi_no: this.search && this.search['pi_no'] != null ? this.search['pi_no'] : '',
      invoice_no: this.search && this.search['invoice_no'] != null ? this.search['invoice_no'] : '',
      period_id: this.search && this.search['period_id'] != null ? this.search['period_id'] : '',
      period_name: this.search && this.search['period_name'] != null ? this.search['period_name'] : '',
      customer_id: this.search && this.search['customer_id'] != null ? this.search['customer_id'] : '',
      customer_no: this.search && this.search['customer_no'] != null ? this.search['customer_no'] : '',
      customer_name: '',
      payment_type: this.search && this.search['payment_type'] != null ? this.search['payment_type'] : '',
      order_type_id: this.search && this.search['order_type'] != null ? this.search['order_type'] : '',
      order_type_name: this.search && this.search['order_type_name'] != null ? this.search['order_type_name'] : '',
      order_start_date: this.search && this.search['order_start_date'] != null ? this.search['order_start_date'] : '',
      order_end_date: this.search && this.search['order_end_date'] != null ? this.search['order_end_date'] : '',
      delivery_start_date: this.search && this.search['delivery_start_date'] != null ? this.search['delivery_start_date'] : '',
      delivery_end_date: this.search && this.search['delivery_end_date'] != null ? this.search['delivery_end_date'] : '',
      prepare_so_status: this.search && this.search['prepare_so_status'] != null ? this.search['prepare_so_status'] : this.search && this.search['prepare_so_status'] == null ? '' : 'Draft',
      delivery_date: this.search && this.search['delivery_date'] != null ? this.search['delivery_date'] : '',
      isDisableSelDate: false,
      loading: {
        form: false,
        so: false,
        prepare_so: false,
        period: false,
        pi: false,
        invoice: false,
        customer: false,
        order_type: false
      },
      pickerOptionsOrder: {
        disabledDate: function disabledDate(time) {
          return time.getTime() > moment__WEBPACK_IMPORTED_MODULE_1___default()(this.disabledDateTo, 'DD-MM-YYYY').toDate();
        }
      },
      disabledDate: function disabledDate(order_start_date, order_end_date) {
        if (!order_start_date) {
          return;
        }

        return order_start_date < moment__WEBPACK_IMPORTED_MODULE_1___default()(order_start_date, 'DD-MM-YYYY').toDate();
      },
      // NEW REQUIRE 20220623
      showFlag: false // this.search? true: false

    };
  },
  mounted: function mounted() {
    if (this.type == 'domestic' && this.search == null) {
      var currentDate = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD');
      this.delivery_start_date = this.changeToTh(currentDate);
      this.delivery_end_date = this.changeToTh(currentDate);
    }
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.month ? this.setError('month') : this.resetError('month');
        val.bi_weekly ? this.setError('bi_weekly') : this.resetError('bi_weekly');
      },
      deep: true
    },
    orderLists: function orderLists(newValue) {
      return newValue;
    },
    disabledDateTo: function () {
      var _disabledDateTo = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return moment__WEBPACK_IMPORTED_MODULE_1___default()(value, 'DD/MM/YYYY').toDate();

              case 2:
                _context.t0 = _context.sent;
                _context.t1 = this.order_end_date;

                if (!(_context.t0 > _context.t1)) {
                  _context.next = 6;
                  break;
                }

                this.order_end_date = null;

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function disabledDateTo(_x) {
        return _disabledDateTo.apply(this, arguments);
      }

      return disabledDateTo;
    }()
  },
  methods: {
    getSoLists: function getSoLists(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this.loading.so = true;
                _context2.next = 3;
                return axios.get("/om/prepare-sale-orders/ajax/get-so-lists", {
                  params: {
                    type: _this.type,
                    set_data: _this.so_no,
                    depend_cust: _this.customer_id,
                    query: query
                  }
                }).then(function (res) {
                  console.log(res.data);
                  _this.orderLists = res.data;
                })["catch"](function (err) {
                  console.log(err);
                }).then(function () {
                  _this.loading.so = false;
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getPrepareSOLists: function getPrepareSOLists(query) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var _this2$prepare_so_no;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this2.loading.prepare_so = true;
                _context3.next = 3;
                return axios.get("/om/prepare-sale-orders/ajax/get-prepare-so-lists", {
                  params: {
                    type: _this2.type,
                    set_data: (_this2$prepare_so_no = _this2.prepare_so_no) !== null && _this2$prepare_so_no !== void 0 ? _this2$prepare_so_no : _this2.sa_no,
                    depend_cust: _this2.customer_id,
                    query: query
                  }
                }).then(function (res) {
                  _this2.prepareOrderLists = res.data;
                })["catch"](function (err) {
                  console.log(err);
                }).then(function () {
                  _this2.loading.prepare_so = false;
                });

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    searchForm: function searchForm() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var form, inputs;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                form = $('#search-form');
                inputs = form.serialize();
                _this3.loading = true;
                form.submit();

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    },
    dateOrderFrom: function dateOrderFrom(dateFrom) {
      this.order_start_date = dateFrom ? moment__WEBPACK_IMPORTED_MODULE_1___default()(dateFrom).format(this.dateFormat) : '';
      this.order_end_date = dateFrom ? moment__WEBPACK_IMPORTED_MODULE_1___default()(dateFrom).format(this.dateFormat) : '';
    },
    dateOrderTo: function dateOrderTo(dateTo) {
      this.order_end_date = dateTo ? moment__WEBPACK_IMPORTED_MODULE_1___default()(dateTo).format(this.dateFormat) : '';
    },
    dateDeliveryFrom: function dateDeliveryFrom(dateFrom) {
      this.delivery_start_date = dateFrom ? moment__WEBPACK_IMPORTED_MODULE_1___default()(dateFrom).format(this.dateFormat) : '';
      this.delivery_end_date = dateFrom ? moment__WEBPACK_IMPORTED_MODULE_1___default()(dateFrom).format(this.dateFormat) : '';
    },
    dateDeliveryTo: function dateDeliveryTo(dateTo) {
      this.delivery_end_date = dateTo ? moment__WEBPACK_IMPORTED_MODULE_1___default()(dateTo).format(this.dateFormat) : '';
    },
    getDefaultData: function getDefaultData(res) {
      if (res.name == 'period') {
        this.period_id = res.value_id;
        this.period_name = res.value;
        this.periodLists = res.options;
      }

      if (res.name == 'pi') {
        this.pi_id = res.value_id;
        this.pi_no = res.value;
        this.piLists = res.options;
      }

      if (res.name == 'invoice') {
        this.invoice_no = res.value;
        this.invoiceLists = res.options;
      }

      if (res.name == 'customer') {
        this.customer_id = res.value_id;
        this.customer_no = res.value;
        this.customer_name = res.value_name;
        this.customerLists = res.options;
        this.getSoLists();
        this.getPrepareSOLists();
      }

      if (res.name == 'order_type') {
        this.order_type_id = res.value_id;
        this.order_type_name = res.value;
        this.orderTypeLists = res.options;
      }

      if (res.name == 'so') {
        this.so_no = res.value;
        this.orderLists = res.options;
      }

      if (res.name == 'prepare_so') {
        this.prepare_so_no = res.value;
        this.prepareOrderLists = res.options;
      }

      if (res.name == 'sa') {
        this.sa_no = res.value;
        this.prepareOrderLists = res.options;
      }
    },
    changeToTh: function changeToTh(date) {
      var vm = this;
      var dateTh = '';

      if (date) {
        dateTh = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).add(543, 'year').format('DD-MM-YYYY');
      }

      return dateTh;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CustomerInputValueComponent_vue_vue_type_template_id_7406ca0d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d& */ "./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d&");
/* harmony import */ var _CustomerInputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CustomerInputValueComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CustomerInputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CustomerInputValueComponent_vue_vue_type_template_id_7406ca0d___WEBPACK_IMPORTED_MODULE_0__.render,
  _CustomerInputValueComponent_vue_vue_type_template_id_7406ca0d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputValueComponent_vue_vue_type_template_id_cc240e6a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputValueComponent.vue?vue&type=template&id=cc240e6a& */ "./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=template&id=cc240e6a&");
/* harmony import */ var _InputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputValueComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputValueComponent_vue_vue_type_template_id_cc240e6a___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputValueComponent_vue_vue_type_template_id_cc240e6a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchComponent_vue_vue_type_template_id_53dfb1ec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchComponent.vue?vue&type=template&id=53dfb1ec& */ "./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=template&id=53dfb1ec&");
/* harmony import */ var _SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchComponent_vue_vue_type_template_id_53dfb1ec___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchComponent_vue_vue_type_template_id_53dfb1ec___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerInputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CustomerInputValueComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerInputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputValueComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputValueComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerInputValueComponent_vue_vue_type_template_id_7406ca0d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerInputValueComponent_vue_vue_type_template_id_7406ca0d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomerInputValueComponent_vue_vue_type_template_id_7406ca0d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d&");


/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=template&id=cc240e6a&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=template&id=cc240e6a& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputValueComponent_vue_vue_type_template_id_cc240e6a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputValueComponent_vue_vue_type_template_id_cc240e6a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputValueComponent_vue_vue_type_template_id_cc240e6a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputValueComponent.vue?vue&type=template&id=cc240e6a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=template&id=cc240e6a&");


/***/ }),

/***/ "./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=template&id=53dfb1ec&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=template&id=53dfb1ec& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_53dfb1ec___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_53dfb1ec___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_53dfb1ec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchComponent.vue?vue&type=template&id=53dfb1ec& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=template&id=53dfb1ec&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/CustomerInputValueComponent.vue?vue&type=template&id=7406ca0d& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
    [
      _c(
        "el-select",
        {
          ref: "input",
          staticClass: "w-100 el-select-input-segment",
          staticStyle: { width: "100%" },
          attrs: {
            filterable: "",
            remote: "",
            clearable: "",
            "reserve-keyword": "",
            placeholder: _vm.placeholder,
            "remote-method": _vm.getValueSetList,
            loading: _vm.loading,
            size: "large"
          },
          on: { change: _vm.changeInput },
          model: {
            value: _vm.value,
            callback: function($$v) {
              _vm.value = $$v
            },
            expression: "value"
          }
        },
        _vm._l(_vm.options, function(item, key) {
          return _c("el-option", {
            key: key,
            attrs: {
              label: item.flex_value + " : " + item.customer_name,
              value: item.flex_value
            }
          })
        }),
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=template&id=cc240e6a&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/InputValueComponent.vue?vue&type=template&id=cc240e6a& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
    [
      _c(
        "el-select",
        {
          ref: "input",
          staticClass: "w-100 el-select-input-segment",
          staticStyle: { width: "100%" },
          attrs: {
            filterable: "",
            remote: "",
            clearable: "",
            "reserve-keyword": "",
            placeholder: _vm.placeholder,
            "remote-method": _vm.getValueSetList,
            loading: _vm.loading,
            size: "large"
          },
          on: { change: _vm.changeInput },
          model: {
            value: _vm.value,
            callback: function($$v) {
              _vm.value = $$v
            },
            expression: "value"
          }
        },
        _vm._l(_vm.options, function(item, key) {
          return _c("el-option", {
            key: key,
            attrs: { label: item.flex_value, value: item.flex_value }
          })
        }),
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=template&id=53dfb1ec&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/Prepare-Sale-Order/SearchComponent.vue?vue&type=template&id=53dfb1ec& ***!
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
  return _c(
    "div",
    { directives: [{ name: "loading", rawName: "v-loading" }] },
    [
      _c("div", { staticClass: "card" }, [
        _c("div", { staticClass: "card-body pt-3 pl-1" }, [
          _c("form", { attrs: { id: "search-form", action: _vm.url.search } }, [
            _vm.type == "domestic"
              ? _c("div", { staticClass: "row col-12" }, [
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" วันที่ส่ง จากวันที่ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[delivery_start_date]"
                            },
                            domProps: { value: _vm.delivery_start_date }
                          }),
                          _vm._v(" "),
                          _c("datepicker-th", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            staticStyle: { width: "100%" },
                            attrs: {
                              "om-type": _vm.type,
                              id: "order_start_date",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.delivery_start_date,
                              format: "DD/MM/YYYY",
                              disabled: _vm.isDisableSelDate
                            },
                            on: { dateWasSelected: _vm.dateDeliveryFrom },
                            model: {
                              value: _vm.delivery_start_date,
                              callback: function($$v) {
                                _vm.delivery_start_date = $$v
                              },
                              expression: "delivery_start_date"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_month" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" ถึงวันที่ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[delivery_end_date]"
                            },
                            domProps: { value: _vm.delivery_end_date }
                          }),
                          _vm._v(" "),
                          _c("datepicker-th", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            staticStyle: { width: "100%" },
                            attrs: {
                              "om-type": _vm.type,
                              id: "delivery_end_date",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.delivery_end_date,
                              format: "DD/MM/YYYY",
                              disabled: _vm.isDisableSelDate,
                              "disabled-date-to": _vm.delivery_start_date
                            },
                            on: { dateWasSelected: _vm.dateDeliveryTo },
                            model: {
                              value: _vm.delivery_end_date,
                              callback: function($$v) {
                                _vm.delivery_end_date = $$v
                              },
                              expression: "delivery_end_date"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_month" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _vm.type == "domestic"
                    ? _c(
                        "div",
                        {
                          staticClass:
                            "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            { staticClass: "text-left tw-uppercase mb-1" },
                            [_vm._v(" สถานะใบเตรียมขาย :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "iinput-icon" },
                            [
                              _c("input", {
                                attrs: {
                                  type: "hidden",
                                  name: "search[prepare_so_status]"
                                },
                                domProps: { value: _vm.prepare_so_status }
                              }),
                              _vm._v(" "),
                              _c(
                                "el-select",
                                {
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    size: "large",
                                    placeholder: "สถานะใบเตรียมขาย",
                                    clearable: "",
                                    filterable: ""
                                  },
                                  model: {
                                    value: _vm.prepare_so_status,
                                    callback: function($$v) {
                                      _vm.prepare_so_status = $$v
                                    },
                                    expression: "prepare_so_status"
                                  }
                                },
                                _vm._l(_vm.status, function(val, index) {
                                  return _c("el-option", {
                                    key: val,
                                    attrs: { label: val, value: val }
                                  })
                                }),
                                1
                              ),
                              _vm._v(" "),
                              _c("div", {
                                staticClass: "error_msg text-left",
                                attrs: { id: "el_explode_so_no" }
                              })
                            ],
                            1
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.type == "domestic"
                    ? _c(
                        "div",
                        {
                          staticClass:
                            "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            { staticClass: "text-left tw-uppercase mb-1" },
                            [_vm._v(" วันส่งประจำสัปดาห์ :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-icon" },
                            [
                              _c("input", {
                                attrs: {
                                  type: "hidden",
                                  name: "search[delivery_date]"
                                },
                                domProps: { value: _vm.delivery_date }
                              }),
                              _vm._v(" "),
                              _c("input", {
                                attrs: { type: "hidden", name: "search[type]" },
                                domProps: { value: _vm.type }
                              }),
                              _vm._v(" "),
                              _c(
                                "el-select",
                                {
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    size: "large",
                                    placeholder: "วันส่งประจำสัปดาห์",
                                    filterable: ""
                                  },
                                  model: {
                                    value: _vm.delivery_date,
                                    callback: function($$v) {
                                      _vm.delivery_date = $$v
                                    },
                                    expression: "delivery_date"
                                  }
                                },
                                _vm._l(_vm.deliveryDate, function(date) {
                                  return _c("el-option", {
                                    key: date,
                                    attrs: { label: date, value: date }
                                  })
                                }),
                                1
                              )
                            ],
                            1
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group text-center pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12"
                    },
                    [
                      _c("label", { staticClass: " tw-uppercase m-0" }, [
                        _vm._v(" ")
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-primary tw-w-25",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.searchForm($event)
                              }
                            }
                          },
                          [
                            _c("i", { class: _vm.btnTrans.search.icon }),
                            _vm._v(
                              "\n                                " +
                                _vm._s(_vm.btnTrans.search.text) +
                                "\n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "btn btn-white tw-w-25",
                            attrs: {
                              href: _vm.url.search + "?type=" + _vm.type
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-refresh" }),
                            _vm._v(
                              "\n                                ล้างข้อมูล\n                            "
                            )
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("small", { staticClass: "font-bold" }, [
                        _vm._v(
                          "\n                             \n                        "
                        )
                      ])
                    ]
                  )
                ])
              : _c("div", { staticClass: "row col-12" }, [
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" เลขที่ใบสั่งซื้อ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: { type: "hidden", name: "search[type]" },
                            domProps: { value: _vm.type }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: { type: "hidden", name: "search[so_no]" },
                            domProps: { value: _vm.so_no }
                          }),
                          _vm._v(" "),
                          _c("InputValue", {
                            attrs: {
                              "set-name": "so",
                              "set-data": _vm.so_no,
                              placeholder: "เลขที่ใบสั่งซื้อ",
                              "set-options": _vm.orderLists,
                              url: _vm.url.ajax_get_so,
                              type: _vm.type,
                              "depend-cust": _vm.customer_id
                            },
                            on: { def: _vm.getDefaultData }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" วันที่สั่ง จากวันที่ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[order_start_date]"
                            },
                            domProps: { value: _vm.order_start_date }
                          }),
                          _vm._v(" "),
                          _c("datepicker-en", {
                            staticClass:
                              "form-control md:tw-mb-0 tw-mb-2 approve_date",
                            staticStyle: { width: "100%" },
                            attrs: {
                              "om-type": _vm.type,
                              id: "order_start_date",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.order_start_date,
                              format: "DD/MM/YYYY",
                              disabled: _vm.isDisableSelDate
                            },
                            on: { dateWasSelected: _vm.dateOrderFrom },
                            model: {
                              value: _vm.order_start_date,
                              callback: function($$v) {
                                _vm.order_start_date = $$v
                              },
                              expression: "order_start_date"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_month" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" ถึงวันที่ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[order_end_date]"
                            },
                            domProps: { value: _vm.order_end_date }
                          }),
                          _vm._v(" "),
                          _c("datepicker-en", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            staticStyle: { width: "100%" },
                            attrs: {
                              "om-type": _vm.type,
                              id: "order_end_date",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.order_end_date,
                              format: "DD/MM/YYYY",
                              disabled: _vm.isDisableSelDate,
                              "disabled-date-to": _vm.order_start_date
                            },
                            on: { dateWasSelected: _vm.dateOrderTo },
                            model: {
                              value: _vm.order_end_date,
                              callback: function($$v) {
                                _vm.order_end_date = $$v
                              },
                              expression: "order_end_date"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_month" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" เลขที่ใบ SA :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: { type: "hidden", name: "search[sa_no]" },
                            domProps: { value: _vm.sa_no }
                          }),
                          _vm._v(" "),
                          _c("InputValue", {
                            attrs: {
                              "set-name": "sa",
                              "set-data": _vm.sa_no,
                              placeholder: "เลขที่ใบ SA",
                              "set-options": _vm.prepareOrderLists,
                              url: _vm.url.ajax_get_prepare_so,
                              type: _vm.type,
                              "depend-cust": _vm.customer_id
                            },
                            on: { def: _vm.getDefaultData }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" วันที่ส่ง จากวันที่ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[delivery_start_date]"
                            },
                            domProps: { value: _vm.delivery_start_date }
                          }),
                          _vm._v(" "),
                          _c("datepicker-en", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            staticStyle: { width: "100%" },
                            attrs: {
                              "om-type": _vm.type,
                              id: "order_start_date",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.delivery_start_date,
                              format: "DD/MM/YYYY",
                              disabled: _vm.isDisableSelDate
                            },
                            on: { dateWasSelected: _vm.dateDeliveryFrom },
                            model: {
                              value: _vm.delivery_start_date,
                              callback: function($$v) {
                                _vm.delivery_start_date = $$v
                              },
                              expression: "delivery_start_date"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_month" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" ถึงวันที่ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[delivery_end_date]"
                            },
                            domProps: { value: _vm.delivery_end_date }
                          }),
                          _vm._v(" "),
                          _c("datepicker-en", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            staticStyle: { width: "100%" },
                            attrs: {
                              "om-type": _vm.type,
                              id: "delivery_end_date",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.delivery_end_date,
                              format: "DD/MM/YYYY",
                              disabled: _vm.isDisableSelDate,
                              "disabled-date-to": _vm.delivery_start_date
                            },
                            on: { dateWasSelected: _vm.dateDeliveryTo },
                            model: {
                              value: _vm.delivery_end_date,
                              callback: function($$v) {
                                _vm.delivery_end_date = $$v
                              },
                              expression: "delivery_end_date"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_month" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" เลขที่ใบ PI :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: { type: "hidden", name: "search[pi_id]" },
                            domProps: { value: _vm.pi_id }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: { type: "hidden", name: "search[pi_no]" },
                            domProps: { value: _vm.pi_no }
                          }),
                          _vm._v(" "),
                          _c("InputValue", {
                            attrs: {
                              "set-name": "pi",
                              "set-data": _vm.pi_no,
                              placeholder: "เลขที่ใบ PI",
                              "set-options": _vm.piLists,
                              url: _vm.url.ajax_get_pi,
                              type: _vm.type,
                              "depend-cust": _vm.customer_id
                            },
                            on: { def: _vm.getDefaultData }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" เลขที่ใบ Invoice :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[invoice_no]"
                            },
                            domProps: { value: _vm.invoice_no }
                          }),
                          _vm._v(" "),
                          _c("InputValue", {
                            attrs: {
                              "set-name": "invoice",
                              "set-data": _vm.invoice_no,
                              placeholder: "เลขที่ใบ Invoice",
                              "set-options": _vm.invoiceLists,
                              url: _vm.url.ajax_get_invoice,
                              type: _vm.type,
                              "depend-cust": _vm.customer_id
                            },
                            on: { def: _vm.getDefaultData }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" ประเภทการจ่ายเงิน :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[payment_type]"
                            },
                            domProps: { value: _vm.payment_type }
                          }),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticStyle: { width: "100%" },
                              attrs: {
                                size: "large",
                                placeholder: "สถานะใบเตรียมขาย",
                                clearable: "",
                                filterable: ""
                              },
                              model: {
                                value: _vm.payment_type,
                                callback: function($$v) {
                                  _vm.payment_type = $$v
                                },
                                expression: "payment_type"
                              }
                            },
                            _vm._l(_vm.paymentTypes, function(type, index) {
                              return _c("el-option", {
                                key: index,
                                attrs: {
                                  label: type.meaning,
                                  value: type.lookup_code
                                }
                              })
                            }),
                            1
                          ),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" ลูกค้า :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[customer_id]"
                            },
                            domProps: { value: _vm.customer_id }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[customer_no]"
                            },
                            domProps: { value: _vm.customer_no }
                          }),
                          _vm._v(" "),
                          _c("CustInputValue", {
                            attrs: {
                              "set-name": "customer",
                              "set-data": _vm.customer_no,
                              placeholder: "ลูกค้า",
                              "set-options": _vm.customerLists,
                              url: _vm.url.ajax_get_customer,
                              type: _vm.type,
                              "depend-cust": _vm.customer_id
                            },
                            on: { def: _vm.getDefaultData }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _vm._m(0),
                      _vm._v(" "),
                      _c("div", { staticClass: "iinput-icon p-1" }, [
                        _c("input", {
                          staticClass: "form-control",
                          attrs: { type: "text", disabled: "" },
                          domProps: { value: _vm.customer_name }
                        })
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        { staticClass: "text-left tw-uppercase mb-1" },
                        [_vm._v(" ประเภทคำสั่งซื้อ :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "iinput-icon" },
                        [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[order_type_id]"
                            },
                            domProps: { value: _vm.order_type_id }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "search[order_type_name]"
                            },
                            domProps: { value: _vm.order_type_name }
                          }),
                          _vm._v(" "),
                          _c("InputValue", {
                            attrs: {
                              "set-name": "order_type",
                              "set-data": _vm.order_type_name,
                              placeholder: "ประเภทคำสั่งซื้อ",
                              "set-options": _vm.orderTypeLists,
                              url: _vm.url.ajax_get_order_type,
                              type: _vm.type,
                              "depend-cust": _vm.customer_id
                            },
                            on: { def: _vm.getDefaultData }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_so_no" }
                          })
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "form-group text-right pr-2 mb-0 col-lg-12 col-md-10 col-sm-12 col-xs-12"
                    },
                    [
                      _c("label", { staticClass: " tw-uppercase mt-2" }, [
                        _vm._v(" ")
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-primary tw-w-25",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.searchForm($event)
                              }
                            }
                          },
                          [
                            _c("i", { class: _vm.btnTrans.search.icon }),
                            _vm._v(
                              "\n                                " +
                                _vm._s(_vm.btnTrans.search.text) +
                                "\n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "a",
                          {
                            staticClass: "btn btn-white tw-w-25",
                            attrs: {
                              href: _vm.url.search + "?type=" + _vm.type
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-refresh" }),
                            _vm._v(
                              "\n                                ล้างข้อมูล\n                            "
                            )
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("small", { staticClass: "font-bold" }, [
                        _vm._v(
                          "\n                             \n                        "
                        )
                      ])
                    ]
                  )
                ])
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [_vm._v("   "), _c("br")])
  }
]
render._withStripped = true



/***/ })

}]);