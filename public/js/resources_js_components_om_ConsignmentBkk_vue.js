(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_ConsignmentBkk_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue2_datepicker__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue2-datepicker */ "./node_modules/vue2-datepicker/index.esm.js");
/* harmony import */ var vue2_datepicker_index_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue2-datepicker/index.css */ "./node_modules/vue2-datepicker/index.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);


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
// import helpers from './../helpers.js'



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["value", "name", "id", "inputClass", "placeholder", "disabledDateTo", "format", "pType", "disabled", "notBeforeDate", "notAfterDate", "omType"],
  mounted: function mounted() {},
  watch: {
    disabledDateTo: function () {
      var _disabledDateTo = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return moment__WEBPACK_IMPORTED_MODULE_3___default()(value, this.format).toDate();

              case 2:
                _context.t0 = _context.sent;
                _context.t1 = this.date;

                if (!(_context.t0 > _context.t1)) {
                  _context.next = 6;
                  break;
                }

                this.date = null;

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
    }(),
    value: function () {
      var _value2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(_value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                console.log('change value: ', _value, oldValue);

                if (_value) {
                  this.date = _value ? moment__WEBPACK_IMPORTED_MODULE_3___default()(_value, this.format).toDate() : null;
                } else {
                  this.date = null;
                }

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function value(_x2, _x3) {
        return _value2.apply(this, arguments);
      }

      return value;
    }()
  },
  components: {
    DatePicker: vue2_datepicker__WEBPACK_IMPORTED_MODULE_1__.default
  },
  data: function data() {
    var _this = this;

    return {
      type: this.pType != undefined && this.pType != '' ? this.pType : 'date',
      date: this.value ? moment__WEBPACK_IMPORTED_MODULE_3___default()(this.value, this.format).toDate() : null,
      defaultDate: (this.omType == 'export' ? moment__WEBPACK_IMPORTED_MODULE_3___default()().toDate() : this.value) ? moment__WEBPACK_IMPORTED_MODULE_3___default()(this.value, this.format).toDate() : moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, 'years').toDate(),
      lang: {
        formatLocale: {
          months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
          monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
          weekdays: ['พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร'],
          weekdaysShort: ['พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร'],
          weekdaysMin: ['พฤ.', 'ศ.', 'ส.', 'อา.', 'จ.', 'อ.', 'พ.'],
          firstDayOfWeek: 3
        },
        yearFormat: 'YYYY',
        monthFormat: 'MMM',
        monthBeforeYear: true
      },
      disabledDate: function disabledDate(date) {
        if (!_this.disabledDateTo) {
          return;
        }

        return date < moment__WEBPACK_IMPORTED_MODULE_3___default()(_this.disabledDateTo, _this.format).toDate();
      }
    };
  },
  methods: {
    dateWasSelected: function dateWasSelected(date) {
      this.date = date; // console.log('---dateWasSelected----',date,this.format)

      this.$emit("dateWasSelected", date);
    },
    disabledBeforeAndAfter: function disabledBeforeAndAfter(date) {
      if (this.disabledDateTo) {
        return date < moment__WEBPACK_IMPORTED_MODULE_3___default()(this.disabledDateTo, this.format).toDate();
      }

      if (this.notBeforeDate && this.notAfterDate) {
        return date < moment__WEBPACK_IMPORTED_MODULE_3___default()(this.notBeforeDate, this.format).toDate() || date > moment__WEBPACK_IMPORTED_MODULE_3___default()(this.notAfterDate, this.format).toDate();
      }

      if (this.notAfterDate) {
        return date > moment__WEBPACK_IMPORTED_MODULE_3___default()(this.notAfterDate, this.format).toDate();
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ConsignmentBkk.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ConsignmentBkk.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _DatepickerTh__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../DatepickerTh */ "./resources/js/components/DatepickerTh.vue");


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default()),
    DatepickerTh: _DatepickerTh__WEBPACK_IMPORTED_MODULE_2__.default
  },
  props: ['customerLists', 'convertLists'],
  data: function data() {
    return {
      loading: false,
      loadingConsignment: false,
      date: '',
      status: '',
      consignment: '',
      customer: '',
      customer_name: '',
      table_data: [],
      order_headers: [],
      consignment_lists: [],
      attach_files: [],
      files: [],
      total_unit_price: '0.00',
      total_actual_qty: '0.00',
      total_cgk_qty: '0.00',
      total_ptn_qty: '0.00',
      total_actual_amount: '0.00',
      disabledCreate: false,
      disabledSearch: true,
      disabledConfirm: true,
      disabledAttach: true,
      disabledConsignment: false,
      disabledCustomer: false,
      disabledDate: false,
      readOnly: false,
      state: 'search'
    };
  },
  mounted: function mounted() {
    var vm = this;
    vm.getConsignments();
  },
  computed: {
    sortedTable: function sortedTable() {
      function compare(a, b) {
        if (a.item_code < b.item_code) return -1;
        if (a.item_code > b.item_code) return 1;
        return 0;
      }

      return this.table_data.sort(compare);
    }
  },
  methods: {
    reset: function reset() {
      var vm = this;
      vm.state = 'search';
      vm.customer_name = vm.customer = vm.status = vm.consignment = vm.date = '';
      vm.order_headers = vm.table_data = [];
      vm.total_unit_price = vm.total_actual_qty = vm.total_cgk_qty = vm.total_ptn_qty = vm.total_actual_amount = '0.00';
      vm.disabledCreate = vm.disabledConsignment = vm.disabledCustomer = vm.disabledDate = vm.readOnly = false;
      vm.disabledSearch = vm.disabledConfirm = vm.disabledAttach = true;
      vm.getConsignments();
    },
    create: function create() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.state = 'create';
                vm.consignment = '';
                vm.disabledCreate = vm.disabledConsignment = true;
                vm.disabledAttach = false;
                vm.disabledConfirm = false;
                vm.setDate();
                vm.status = 'Draft';
                vm.readOnly = false;

                if (vm.customerLists.length == 1) {
                  vm.disabledCustomer = true;
                  vm.customer = vm.customerLists[0].customer_id;
                  vm.findCustomer();
                } else {
                  vm.disabledCustomer = false;
                }

                vm.table_data = [];
                vm.total_unit_price = vm.total_actual_qty = vm.total_cgk_qty = vm.total_ptn_qty = vm.total_actual_amount = '0.00';

              case 12:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    search: function search() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, total_unit_price, total_actual_qty, total_cgk_qty, total_ptn_qty, total_actual_amount, find;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                find = vm.consignment_lists.find(function (item) {
                  return item.consignment_header_id == vm.consignment;
                });
                vm.attach_files = find.attach;
                vm.table_data = [];

                if (!(find.consignment_status == 'Draft')) {
                  _context2.next = 11;
                  break;
                }

                _context2.next = 7;
                return vm.getOrderHeaders();

              case 7:
                vm.disabledCreate = vm.disabledSearch = vm.disabledConsignment = vm.disabledCustomer = vm.disabledDate = find ? true : false;
                vm.disabledConfirm = vm.disabledDate = vm.readOnly = vm.disabledAttach = find ? false : true;
                _context2.next = 24;
                break;

              case 11:
                total_unit_price = 0;
                total_actual_qty = 0;
                total_cgk_qty = 0;
                total_ptn_qty = 0;
                total_actual_amount = 0;
                vm.readOnly = vm.disabledCreate = vm.disabledSearch = vm.disabledConfirm = vm.disabledConsignment = vm.disabledCustomer = vm.disabledDate = find ? true : false;
                vm.disabledAttach = find ? false : true;
                find.lines.forEach(function (item) {
                  var find = vm.table_data.find(function (i) {
                    return item.item_code == i.item_code;
                  });

                  if (find) {
                    find.actual_qty += parseFloat(item.actual_quantity);
                    find.cgk_qty += parseFloat(item.actual_quantity);
                    find.ptn_qty += vm.convertUom(item.seq_ecom.product_type_code, parseFloat(item.actual_quantity), 'CGK', 'PTN');
                  } else {
                    vm.table_data.push({
                      'item_id': item.item_id,
                      'item_code': item.item_code,
                      'item_description': item.item_description,
                      'product_type_code': item.seq_ecom.product_type_code,
                      'uom': item.uom.unit_of_measure,
                      'qty': parseFloat(item.quantity),
                      'unit_price': parseFloat(item.order_line.unit_price * item.quantity),
                      'sale_qty': parseFloat(item.previous_quantity),
                      'remain_qty': parseFloat(item.remaining_quantity),
                      'actual_qty': parseFloat(item.actual_quantity),
                      'cgk_qty': parseFloat(item.actual_quantity),
                      'ptn_qty': vm.convertUom(item.seq_ecom.product_type_code, parseFloat(item.actual_quantity), 'CGK', 'PTN')
                    });
                  }

                  total_unit_price += parseFloat(item.order_line.unit_price * item.quantity);
                  total_actual_qty += parseFloat(item.actual_quantity);
                  total_cgk_qty += parseFloat(item.actual_quantity);
                  total_ptn_qty += vm.convertUom(item.seq_ecom.product_type_code, parseFloat(item.actual_quantity), 'CGK', 'PTN');
                  total_actual_amount += parseFloat(item.order_line.unit_price * item.actual_quantity);
                });
                vm.total_unit_price = vm.numberWithCommas(total_unit_price);
                vm.total_actual_qty = vm.numberWithCommas(total_actual_qty);
                vm.total_cgk_qty = vm.numberWithCommas(total_cgk_qty);
                vm.total_ptn_qty = vm.numberWithCommas(total_ptn_qty);
                vm.total_actual_amount = vm.numberWithCommas(total_actual_amount);

              case 24:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    save: function save() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this3;
                vm.loading = true;

                if (!(vm.total_actual_qty <= 0)) {
                  _context7.next = 6;
                  break;
                }

                vm.showWarning('กรุณาระบุยอดฝากขาย');
                vm.loading = false;
                return _context7.abrupt("return");

              case 6:
                swal({
                  title: "แจ้งเตือน",
                  text: "ยืนยันรายการฝากขายสโมสรหรือไม่?",
                  icon: "warning",
                  showCancelButton: true,
                  cancelButtonText: 'ยกเลิก',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'ยืนยัน'
                }, /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6(confirm) {
                    var data, formData, i, file;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
                      while (1) {
                        switch (_context6.prev = _context6.next) {
                          case 0:
                            if (!confirm) {
                              _context6.next = 12;
                              break;
                            }

                            data = vm.composeData();
                            formData = new FormData();

                            for (i = 0; i < vm.files.length; i++) {
                              file = vm.files[i];
                              formData.append('attachment[' + i + ']', file);
                            }

                            formData.append('consignment', vm.consignment);
                            formData.append('date', vm.date);
                            formData.append('customer_id', vm.customer);
                            formData.append('data', JSON.stringify(data));
                            _context6.next = 10;
                            return axios.post('/om/consignment-bkk', formData, {
                              headers: {
                                'Content-Type': 'multipart/form-data'
                              }
                            }).then( /*#__PURE__*/function () {
                              var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(response) {
                                return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
                                  while (1) {
                                    switch (_context3.prev = _context3.next) {
                                      case 0:
                                        if (!(response.data.status == 'S')) {
                                          _context3.next = 14;
                                          break;
                                        }

                                        vm.files = [];
                                        vm.consignment = response.data.consignment;
                                        _context3.next = 5;
                                        return vm.getConsignments();

                                      case 5:
                                        _context3.next = 7;
                                        return vm.findConsignment();

                                      case 7:
                                        _context3.next = 9;
                                        return vm.search();

                                      case 9:
                                        vm.clearFile();
                                        _context3.next = 12;
                                        return vm.showSuccess('ยืนยันรายการฝากขายสโมสรเรียบร้อยแล้ว');

                                      case 12:
                                        _context3.next = 16;
                                        break;

                                      case 14:
                                        _context3.next = 16;
                                        return vm.showError('ยืนยันใบรายการฝากขายสโมสรไม่ได้');

                                      case 16:
                                      case "end":
                                        return _context3.stop();
                                    }
                                  }
                                }, _callee3);
                              }));

                              return function (_x2) {
                                return _ref2.apply(this, arguments);
                              };
                            }())["catch"]( /*#__PURE__*/function () {
                              var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(error) {
                                return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
                                  while (1) {
                                    switch (_context4.prev = _context4.next) {
                                      case 0:
                                        console.log(error);

                                      case 1:
                                      case "end":
                                        return _context4.stop();
                                    }
                                  }
                                }, _callee4);
                              }));

                              return function (_x3) {
                                return _ref3.apply(this, arguments);
                              };
                            }()).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
                              return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
                                while (1) {
                                  switch (_context5.prev = _context5.next) {
                                    case 0:
                                      // always executed
                                      vm.loading = false;

                                    case 1:
                                    case "end":
                                      return _context5.stop();
                                  }
                                }
                              }, _callee5);
                            })));

                          case 10:
                            _context6.next = 13;
                            break;

                          case 12:
                            vm.loading = false;

                          case 13:
                          case "end":
                            return _context6.stop();
                        }
                      }
                    }, _callee6);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 7:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    composeData: function composeData() {
      var vm = this;
      var data = [];
      vm.table_data.forEach(function (item) {
        if (item.actual_qty > 0) {
          data.push({
            'item_id': item.item_id,
            'actual': item.actual_qty
          });
        }
      });
      return data;
    },
    setDate: function setDate() {
      var date = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      var vm = this;
      var d = date ? new Date(date) : new Date();
      var year = d.getFullYear() + 543;
      var month = d.getMonth() + 1;
      var day = d.getDate();
      return vm.date = day + '/' + month + '/' + year;
    },
    dateWasSelected: function dateWasSelected(value) {
      var vm = this;
      var year = value.getFullYear();
      var month = value.getMonth() + 1;
      var day = value.getDate();
      vm.date = day + '/' + month + '/' + year;
    },
    findCustomer: function findCustomer() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                vm = _this4;
                vm.setCustomerName();

                if (!(vm.state === 'create')) {
                  _context8.next = 5;
                  break;
                }

                _context8.next = 5;
                return vm.getOrderHeaders();

              case 5:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    setCustomerName: function setCustomerName() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var vm, find;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                vm = _this5;
                find = vm.customerLists.find(function (item) {
                  return item.customer_id == vm.customer;
                });
                vm.customer_name = find ? find.customer_name : '';

              case 3:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    findConsignment: function findConsignment() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm, find;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                vm = _this6;
                find = vm.consignment_lists.find(function (item) {
                  return item.consignment_header_id == vm.consignment;
                });
                vm.disabledSearch = find ? false : true;
                vm.customer_name = find ? find.customer_name : '';
                vm.date = find ? vm.setDate(find.consignment_date) : '';
                vm.customer = find ? find.order_header ? find.order_header.customer.customer_id : find.customer.customer_id : '';
                vm.status = find ? find.consignment_status : '';

                if (vm.customer != '') {
                  vm.setCustomerName();
                }

              case 8:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    getOrderHeaders: function getOrderHeaders() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                vm = _this7;
                vm.table_data = [];
                vm.loading = true;
                _context12.next = 5;
                return axios.get('/om/consignment-bkk/get-order-header', {
                  params: {
                    'customer': vm.customer
                  }
                }).then(function (response) {
                  vm.order_headers = response.data;
                })["catch"](function (error) {
                  console.log(error);
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
                    while (1) {
                      switch (_context11.prev = _context11.next) {
                        case 0:
                          _context11.next = 2;
                          return vm.setCreate();

                        case 2:
                          vm.loading = false;

                        case 3:
                        case "end":
                          return _context11.stop();
                      }
                    }
                  }, _callee11);
                })));

              case 5:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    getConsignments: function getConsignments() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                vm = _this8;
                vm.loading = true;
                vm.consignment_lists = [];
                _context13.next = 5;
                return axios.get('/om/consignment-bkk/get-consignment', {
                  params: {
                    'consignment_id': vm.consignment
                  }
                }).then(function (response) {
                  vm.consignment_lists = response.data;
                })["catch"](function (error) {
                  console.log(error);
                }).then(function () {
                  // always executed
                  vm.loading = false;
                });

              case 5:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    searchConsignment: function searchConsignment(query) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                vm = _this9;
                vm.loadingConsignment = true;
                vm.consignment_lists = [];
                _context14.next = 5;
                return axios.get('/om/consignment-bkk/get-consignment', {
                  params: {
                    'consignment_no': query
                  }
                }).then(function (response) {
                  vm.consignment_lists = response.data;
                })["catch"](function (error) {
                  console.log(error);
                }).then(function () {
                  // always executed
                  vm.loadingConsignment = false;
                });

              case 5:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    setCreate: function setCreate() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var vm, total_unit_price, total_actual_qty, total_cgk_qty, total_ptn_qty, total_actual_amount;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                vm = _this10;
                total_unit_price = 0;
                total_actual_qty = 0;
                total_cgk_qty = 0;
                total_ptn_qty = 0;
                total_actual_amount = 0;
                vm.order_headers.forEach(function (item) {
                  item.lines.forEach(function (line) {
                    var sum_actual_quantity = line.approve_quantity - line.consignment_lines.reduce(function (a, b) {
                      return a + parseFloat(b.actual_quantity || 0);
                    }, 0);

                    if (sum_actual_quantity > 0) {
                      var find = vm.table_data.find(function (i) {
                        return line.item_code == i.item_code;
                      });

                      if (find) {
                        find.qty += parseFloat(line.approve_quantity);
                        find.unit_price += parseFloat(line.unit_price * line.approve_quantity);
                        find.sale_qty += parseFloat(sum_actual_quantity);
                        find.remain_qty += parseFloat(sum_actual_quantity);
                        find.detail.push({
                          'order': item.order_header_id,
                          'price': parseFloat(line.unit_price),
                          'qty': parseFloat(line.approve_quantity),
                          'remain': parseFloat(sum_actual_quantity)
                        });
                      } else {
                        vm.table_data.push({
                          'item_id': line.item_id,
                          'item_code': line.item_code,
                          'item_description': line.item_description,
                          'product_type_code': line.seq_ecom.product_type_code,
                          'uom': line.uom,
                          'qty': parseFloat(line.approve_quantity),
                          'unit_price': parseFloat(line.unit_price * line.approve_quantity),
                          'sale_qty': parseFloat(sum_actual_quantity),
                          'remain_qty': parseFloat(sum_actual_quantity),
                          'actual_qty': 0,
                          'cgk_qty': 0,
                          'ptn_qty': 0,
                          'detail': [{
                            'order': item.order_header_id,
                            'price': parseFloat(line.unit_price),
                            'qty': parseFloat(line.approve_quantity),
                            'remain': parseFloat(sum_actual_quantity)
                          }]
                        });
                      }

                      total_unit_price += parseFloat(line.unit_price * line.approve_quantity);
                    }
                  });
                });
                vm.total_unit_price = vm.numberWithCommas(total_unit_price);
                vm.total_actual_qty = vm.numberWithCommas(total_actual_qty);
                vm.total_cgk_qty = vm.numberWithCommas(total_cgk_qty);
                vm.total_ptn_qty = vm.numberWithCommas(total_ptn_qty);
                vm.total_actual_amount = vm.numberWithCommas(total_actual_amount);

              case 12:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    handleChange: function handleChange(index, from_uom) {
      var vm = this;
      var actual;
      var cgk = Math.round(vm.table_data[index].cgk_qty * 100) / 100;
      var ptn = Math.round(vm.table_data[index].ptn_qty * 100) / 100;
      var sale_qty = Math.round(vm.table_data[index].sale_qty * 100) / 100;
      var product_type_code = vm.table_data[index].product_type_code;

      if (from_uom == 'CGK') {
        actual = cgk;
        ptn = Math.round(vm.convertUom(product_type_code, cgk, 'CGK', 'PTN') * 100) / 100;
      } else {
        actual = Math.round(vm.convertUom(product_type_code, ptn, 'PTN', 'CGK') * 100) / 100;
        cgk = actual;
      }

      if (actual > sale_qty) {
        vm.table_data[index].remain_qty = parseFloat(sale_qty);
        vm.table_data[index].actual_qty = 0;
        vm.table_data[index].cgk_qty = 0;
        vm.table_data[index].ptn_qty = 0;
        vm.showWarning('จำนวนยอดขายที่ระบุมากกว่าจำนวนคงเหลือขาย');
      } else {
        vm.table_data[index].remain_qty = parseFloat(sale_qty - actual);
        vm.table_data[index].actual_qty = actual;
        vm.table_data[index].cgk_qty = cgk;
        vm.table_data[index].ptn_qty = ptn;
      }

      vm.calTotal();
    },
    calTotal: function calTotal() {
      function compare(a, b) {
        if (a.order < b.order) return -1;
        if (a.order > b.order) return 1;
        return 0;
      }

      var vm = this;
      var total_actual_qty = 0;
      var total_cgk_qty = 0;
      var total_ptn_qty = 0;
      var total_actual_amount = 0;
      vm.table_data.forEach(function (item) {
        var qty = item.actual_qty;
        total_actual_qty += parseFloat(item.actual_qty);
        total_cgk_qty += parseFloat(item.cgk_qty);
        total_ptn_qty += parseFloat(item.ptn_qty);
        item.detail.sort(compare);
        item.detail.forEach(function (detail) {
          if (qty > 0) {
            if (qty > detail.remain) {
              total_actual_amount += parseFloat(detail.price * detail.remain);
              qty = parseFloat(qty - detail.remain);
            } else {
              total_actual_amount += parseFloat(detail.price * qty);
              qty = parseFloat(qty - qty);
            }
          }
        });
      });
      vm.total_actual_qty = vm.numberWithCommas(total_actual_qty);
      vm.total_cgk_qty = vm.numberWithCommas(total_cgk_qty);
      vm.total_ptn_qty = vm.numberWithCommas(total_ptn_qty);
      vm.total_actual_amount = vm.numberWithCommas(total_actual_amount);
    },
    clearFile: function clearFile() {
      this.attach = '';
      this.$refs.file.value = null;
      $('.label-attachment').html('Choose file...');
    },
    addFile: function addFile() {
      if (this.$refs.file.files.length) {
        $('.label-attachment').html(this.$refs.file.files[0].name);
      }
    },
    addFileList: function addFileList() {
      if (this.$refs.file.files.length) {
        this.files.push(this.$refs.file.files[0]);
        this.clearFile();
      }
    },
    upload: function upload() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee19() {
        var vm, formData, i, file, _file;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee19$(_context19) {
          while (1) {
            switch (_context19.prev = _context19.next) {
              case 0:
                vm = _this11;
                vm.loading = true;
                $('#attachmentModal').modal('hide');
                formData = new FormData();

                for (i = 0; i < vm.files.length; i++) {
                  file = vm.files[i];
                  formData.append('attachment[' + i + ']', file);
                }

                for (i = 0; i < vm.attach_files.length; i++) {
                  _file = vm.attach_files[i];
                  formData.append('check_attachment[' + i + ']', _file.attachment_id);
                }

                formData.append('consignment', vm.consignment);
                _context19.next = 9;
                return axios.post('/om/consignment-bkk/attach', formData, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
                }).then( /*#__PURE__*/function () {
                  var _ref6 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16(response) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
                      while (1) {
                        switch (_context16.prev = _context16.next) {
                          case 0:
                            if (!(response.data.status != 'E')) {
                              _context16.next = 3;
                              break;
                            }

                            _context16.next = 3;
                            return vm.getConsignments();

                          case 3:
                          case "end":
                            return _context16.stop();
                        }
                      }
                    }, _callee16);
                  }));

                  return function (_x4) {
                    return _ref6.apply(this, arguments);
                  };
                }())["catch"]( /*#__PURE__*/function () {
                  var _ref7 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee17(error) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee17$(_context17) {
                      while (1) {
                        switch (_context17.prev = _context17.next) {
                          case 0:
                            console.log(error);

                          case 1:
                          case "end":
                            return _context17.stop();
                        }
                      }
                    }, _callee17);
                  }));

                  return function (_x5) {
                    return _ref7.apply(this, arguments);
                  };
                }()).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee18() {
                  var find;
                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee18$(_context18) {
                    while (1) {
                      switch (_context18.prev = _context18.next) {
                        case 0:
                          // always executed
                          vm.loading = false;
                          find = vm.consignment_lists.find(function (item) {
                            return item.consignment_header_id == vm.consignment;
                          });
                          vm.attach_files = find.attach;
                          vm.files = [];
                          vm.clearFile();

                        case 5:
                        case "end":
                          return _context18.stop();
                      }
                    }
                  }, _callee18);
                })));

              case 9:
              case "end":
                return _context19.stop();
            }
          }
        }, _callee19);
      }))();
    },
    removeFileLocal: function removeFileLocal(index) {
      this.files.splice(index, 1);
    },
    removeFileAttachment: function removeFileAttachment(index, attach_id) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee20() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee20$(_context20) {
          while (1) {
            switch (_context20.prev = _context20.next) {
              case 0:
                _this12.attach_files.splice(index, 1);

              case 1:
              case "end":
                return _context20.stop();
            }
          }
        }, _callee20);
      }))();
    },
    showSuccess: function showSuccess(msg) {
      swal('', msg, "success");
    },
    showError: function showError(msg) {
      swal('', msg, "error");
    },
    showWarning: function showWarning(msg) {
      swal('', msg, "warning");
    },
    numberWithCommas: function numberWithCommas(x) {
      return parseFloat(x).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    },
    displayDate: function displayDate(date) {
      var d = new Date(date);
      var year = d.getFullYear();
      var month = d.getMonth();
      var day = d.getDate();
      return day + '/' + (month + 1) + '/' + (year + 543);
    },
    getSrc: function getSrc(file) {
      var src = URL.createObjectURL(file);
      return src;
    },
    convertUom: function convertUom(product_type_code, qty, from_uom, to_uom) {
      var vm = this;
      var find = vm.convertLists.find(function (item) {
        return item.product_type_code == product_type_code && item.from_uom == from_uom && item.to_uom == to_uom;
      });
      return qty * find.conversion_rate;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".mx-datepicker-popup{\n  z-index: 9999 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/DatepickerTh.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/DatepickerTh.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _DatepickerTh_vue_vue_type_template_id_0636d53b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DatepickerTh.vue?vue&type=template&id=0636d53b& */ "./resources/js/components/DatepickerTh.vue?vue&type=template&id=0636d53b&");
/* harmony import */ var _DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DatepickerTh.vue?vue&type=script&lang=js& */ "./resources/js/components/DatepickerTh.vue?vue&type=script&lang=js&");
/* harmony import */ var _DatepickerTh_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _DatepickerTh_vue_vue_type_template_id_0636d53b___WEBPACK_IMPORTED_MODULE_0__.render,
  _DatepickerTh_vue_vue_type_template_id_0636d53b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/DatepickerTh.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/ConsignmentBkk.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/om/ConsignmentBkk.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ConsignmentBkk_vue_vue_type_template_id_47f51aca___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ConsignmentBkk.vue?vue&type=template&id=47f51aca& */ "./resources/js/components/om/ConsignmentBkk.vue?vue&type=template&id=47f51aca&");
/* harmony import */ var _ConsignmentBkk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ConsignmentBkk.vue?vue&type=script&lang=js& */ "./resources/js/components/om/ConsignmentBkk.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ConsignmentBkk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ConsignmentBkk_vue_vue_type_template_id_47f51aca___WEBPACK_IMPORTED_MODULE_0__.render,
  _ConsignmentBkk_vue_vue_type_template_id_47f51aca___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/ConsignmentBkk.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/DatepickerTh.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/DatepickerTh.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatepickerTh.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/ConsignmentBkk.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/om/ConsignmentBkk.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ConsignmentBkk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ConsignmentBkk.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ConsignmentBkk.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ConsignmentBkk_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/DatepickerTh.vue?vue&type=template&id=0636d53b&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/DatepickerTh.vue?vue&type=template&id=0636d53b& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_template_id_0636d53b___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_template_id_0636d53b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_template_id_0636d53b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatepickerTh.vue?vue&type=template&id=0636d53b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=template&id=0636d53b&");


/***/ }),

/***/ "./resources/js/components/om/ConsignmentBkk.vue?vue&type=template&id=47f51aca&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/om/ConsignmentBkk.vue?vue&type=template&id=47f51aca& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ConsignmentBkk_vue_vue_type_template_id_47f51aca___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ConsignmentBkk_vue_vue_type_template_id_47f51aca___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ConsignmentBkk_vue_vue_type_template_id_47f51aca___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ConsignmentBkk.vue?vue&type=template&id=47f51aca& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ConsignmentBkk.vue?vue&type=template&id=47f51aca&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=template&id=0636d53b&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/DatepickerTh.vue?vue&type=template&id=0636d53b& ***!
  \************************************************************************************************************************************************************************************************************************/
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
  return _c("date-picker", {
    attrs: {
      "input-class": [_vm.inputClass],
      "default-value": _vm.defaultDate,
      "input-attr": { name: _vm.name, id: _vm.id },
      placeholder: _vm.placeholder,
      lang: _vm.lang,
      type: _vm.type,
      disabled: _vm.disabled,
      "disabled-date": _vm.disabledBeforeAndAfter,
      format: _vm.format,
      "om-Type": _vm.omType
    },
    on: { change: _vm.dateWasSelected },
    model: {
      value: _vm.date,
      callback: function($$v) {
        _vm.date = $$v
      },
      expression: "date"
    }
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ConsignmentBkk.vue?vue&type=template&id=47f51aca&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ConsignmentBkk.vue?vue&type=template&id=47f51aca& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      staticClass: "row"
    },
    [
      _c("div", { staticClass: "col-12" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-3" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-white",
                attrs: { type: "button" },
                on: { click: _vm.reset }
              },
              [_c("i", { staticClass: "fa fa-repeat" })]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-9 text-right" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-success",
                attrs: {
                  disabled: _vm.disabledCreate,
                  type: "button",
                  id: "buttonCreate"
                },
                on: { click: _vm.create }
              },
              [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" สร้าง")]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-white",
                attrs: {
                  disabled: _vm.disabledSearch,
                  type: "button",
                  id: "buttonSearch"
                },
                on: { click: _vm.search }
              },
              [_c("i", { staticClass: "fa fa-search" }), _vm._v(" ค้นหา")]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-info",
                attrs: {
                  disabled: _vm.disabledConfirm,
                  type: "button",
                  id: "buttonConfirm"
                },
                on: { click: _vm.save }
              },
              [_c("i", { staticClass: "fa fa-check" }), _vm._v(" ยืนยันข้อมูล")]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-success",
                attrs: {
                  disabled: _vm.disabledAttach,
                  "data-toggle": "modal",
                  "data-target": "#attachmentModal",
                  type: "button"
                }
              },
              [
                _c("span", { staticClass: "fa fa-upload" }, [
                  _vm._v(" ไฟล์แนบ")
                ])
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "hr-line-dashed" })
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-xl-10 m-auto" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-4" }, [
            _c("div", { staticClass: "form-group" }, [
              _c("label", { staticClass: "d-block" }, [
                _vm._v("เลขที่ใบฝากขายสโมสร")
              ]),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        disabled: _vm.disabledConsignment,
                        name: "consignment",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "remote-method": _vm.searchConsignment,
                        loading: _vm.loadingConsignment,
                        placeholder: ""
                      },
                      on: { input: _vm.findConsignment },
                      model: {
                        value: _vm.consignment,
                        callback: function($$v) {
                          _vm.consignment = $$v
                        },
                        expression: "consignment"
                      }
                    },
                    _vm._l(_vm.consignment_lists, function(item) {
                      return _c(
                        "el-option",
                        {
                          key: item.consignment_header_id,
                          staticStyle: { height: "auto" },
                          attrs: {
                            label: item.consignment_no,
                            value: item.consignment_header_id
                          }
                        },
                        [
                          _c("div", [
                            _c("b", [_vm._v(_vm._s(item.consignment_no))])
                          ]),
                          _vm._v(" "),
                          _c("div", [
                            _vm._v(
                              _vm._s(item.consignment_no) +
                                " : " +
                                _vm._s(_vm.displayDate(item.consignment_date)) +
                                " : " +
                                _vm._s(item.consignment_status)
                            )
                          ])
                        ]
                      )
                    }),
                    1
                  )
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c("div", { staticClass: "form-group" }, [
              _c("label", { staticClass: "d-block" }, [_vm._v("วันที่บันทึก")]),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c("datepicker-th", {
                    class: _vm.disabledDate
                      ? "w-100 bg-readonly form-control md:tw-mb-0 tw-mb-2"
                      : "w-100 form-control md:tw-mb-0 tw-mb-2",
                    attrs: {
                      disabled: _vm.disabledDate,
                      type: "date",
                      value: _vm.date,
                      name: "date",
                      format: "DD/MM/YYYY"
                    },
                    on: { dateWasSelected: _vm.dateWasSelected },
                    model: {
                      value: _vm.date,
                      callback: function($$v) {
                        _vm.date = $$v
                      },
                      expression: "date"
                    }
                  })
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c("div", { staticClass: "form-group" }, [
              _c("label", { staticClass: "d-block" }, [_vm._v("Status")]),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        name: "status",
                        disabled: true,
                        placeholder: ""
                      },
                      model: {
                        value: _vm.status,
                        callback: function($$v) {
                          _vm.status = $$v
                        },
                        expression: "status"
                      }
                    },
                    [
                      _c("el-option", {
                        key: "",
                        attrs: { value: "", label: "" }
                      }),
                      _vm._v(" "),
                      _c("el-option", {
                        key: "Draft",
                        attrs: { value: "Draft", label: "Draft" }
                      }),
                      _vm._v(" "),
                      _c("el-option", {
                        key: "Confirm",
                        attrs: { value: "Confirm", label: "Confirm" }
                      }),
                      _vm._v(" "),
                      _c("el-option", {
                        key: "Cancelled",
                        attrs: { value: "Cancelled", label: "Cancelled" }
                      })
                    ],
                    1
                  )
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-8" }, [
            _c("div", { staticClass: "form-group" }, [
              _c("label", { staticClass: "d-block" }, [_vm._v("รหัสลูกค้า")]),
              _vm._v(" "),
              _c("div", { staticClass: "row space-5" }, [
                _c("div", { staticClass: "col-md-4" }, [
                  _c(
                    "div",
                    [
                      _c(
                        "el-select",
                        {
                          staticClass: "w-100",
                          attrs: {
                            disabled: _vm.disabledCustomer,
                            name: "customer",
                            clearable: "",
                            filterable: "",
                            placeholder: ""
                          },
                          on: { input: _vm.findCustomer },
                          model: {
                            value: _vm.customer,
                            callback: function($$v) {
                              _vm.customer = $$v
                            },
                            expression: "customer"
                          }
                        },
                        _vm._l(_vm.customerLists, function(item) {
                          return _c(
                            "el-option",
                            {
                              key: item.customer_id,
                              staticStyle: { height: "auto" },
                              attrs: {
                                label: item.customer_number,
                                value: item.customer_id
                              }
                            },
                            [
                              _c("div", [
                                _c("b", [_vm._v(_vm._s(item.customer_number))])
                              ]),
                              _vm._v(" "),
                              _c("div", [
                                _vm._v(
                                  _vm._s(item.customer_number) +
                                    " : " +
                                    _vm._s(item.customer_name)
                                )
                              ])
                            ]
                          )
                        }),
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-8 mt-2 mt-md-0" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.customer_name,
                        expression: "customer_name"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { readonly: "" },
                    domProps: { value: _vm.customer_name },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.customer_name = $event.target.value
                      }
                    }
                  })
                ])
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-12" }, [
        _c("hr", { staticClass: "md" }),
        _vm._v(" "),
        _c("div", { staticClass: "table-responsive" }, [
          _c(
            "table",
            {
              staticClass:
                "table table-bordered text-center table-hover min-1000 f13"
            },
            [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "tbody",
                { attrs: { id: "consignmentLines" } },
                [
                  _vm._l(_vm.sortedTable, function(item, index) {
                    return _c(
                      "tr",
                      { key: index, staticClass: "align-middle" },
                      [
                        _c("td", [
                          _vm._v(
                            "\n                            " +
                              _vm._s(index + 1) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(item.item_code) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-left" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(item.item_description) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(_vm.numberWithCommas(item.qty)) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(_vm.numberWithCommas(item.unit_price)) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(_vm.numberWithCommas(item.sale_qty)) +
                              "\n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-right" }, [
                          _vm._v(
                            "\n                            " +
                              _vm._s(_vm.numberWithCommas(item.remain_qty)) +
                              "  \n                        "
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("vue-numeric", {
                              staticClass: "el-input__inner text-right",
                              attrs: {
                                "read-only-class":
                                  "form-control bg-readonly text-right",
                                separator: ",",
                                precision: 2,
                                "read-only": _vm.readOnly
                              },
                              on: {
                                change: function($event) {
                                  return _vm.handleChange(index, "CGK")
                                }
                              },
                              model: {
                                value: _vm.table_data[index].cgk_qty,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.table_data[index],
                                    "cgk_qty",
                                    $$v
                                  )
                                },
                                expression: "table_data[index].cgk_qty"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("vue-numeric", {
                              staticClass: "el-input__inner text-right",
                              attrs: {
                                "read-only-class":
                                  "form-control bg-readonly text-right",
                                separator: ",",
                                precision: 2,
                                "read-only": _vm.readOnly
                              },
                              on: {
                                change: function($event) {
                                  return _vm.handleChange(index, "PTN")
                                }
                              },
                              model: {
                                value: _vm.table_data[index].ptn_qty,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.table_data[index],
                                    "ptn_qty",
                                    $$v
                                  )
                                },
                                expression: "table_data[index].ptn_qty"
                              }
                            })
                          ],
                          1
                        )
                      ]
                    )
                  }),
                  _vm._v(" "),
                  _c("tr", { staticClass: "align-middle" }, [
                    _vm._m(1),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.total_unit_price,
                            expression: "total_unit_price"
                          }
                        ],
                        staticClass: "form-control text-right",
                        attrs: {
                          type: "text",
                          readonly: "",
                          name: "",
                          placeholder: ""
                        },
                        domProps: { value: _vm.total_unit_price },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.total_unit_price = $event.target.value
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _vm._m(2),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.total_cgk_qty,
                            expression: "total_cgk_qty"
                          }
                        ],
                        staticClass: "form-control text-right",
                        attrs: {
                          type: "text",
                          readonly: "",
                          name: "",
                          placeholder: ""
                        },
                        domProps: { value: _vm.total_cgk_qty },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.total_cgk_qty = $event.target.value
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.total_ptn_qty,
                            expression: "total_ptn_qty"
                          }
                        ],
                        staticClass: "form-control text-right",
                        attrs: {
                          type: "text",
                          readonly: "",
                          name: "",
                          placeholder: ""
                        },
                        domProps: { value: _vm.total_ptn_qty },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.total_ptn_qty = $event.target.value
                          }
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("tr", { staticClass: "align-middle" }, [
                    _vm._m(3),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "2" } }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.total_actual_amount,
                            expression: "total_actual_amount"
                          }
                        ],
                        staticClass: "form-control text-right",
                        attrs: {
                          type: "text",
                          readonly: "",
                          name: "",
                          placeholder: ""
                        },
                        domProps: { value: _vm.total_actual_amount },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.total_actual_amount = $event.target.value
                          }
                        }
                      })
                    ])
                  ])
                ],
                2
              )
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "modal",
          attrs: { tabindex: "-1", role: "dialog", id: "attachmentModal" }
        },
        [
          _c(
            "div",
            { staticClass: "modal-dialog", attrs: { role: "document" } },
            [
              _c("div", { staticClass: "modal-content" }, [
                _vm._m(4),
                _vm._v(" "),
                _c("div", { staticClass: "modal-body" }, [
                  _c("div", { staticClass: "attachment-box" }, [
                    _c("div", { staticClass: "form-group d-flex mb-1" }, [
                      _c(
                        "div",
                        {
                          staticClass: "custom-file",
                          staticStyle: { width: "70%" }
                        },
                        [
                          _c("input", {
                            ref: "file",
                            staticClass: "custom-file-input",
                            attrs: {
                              type: "file",
                              accept:
                                ".jpeg, .jpg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .csv"
                            },
                            on: {
                              input: function($event) {
                                return _vm.addFile()
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "label",
                            {
                              staticClass: "custom-file-label label-attachment",
                              attrs: { for: "attachment" }
                            },
                            [_vm._v("Choose file...")]
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "button" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-success",
                            attrs: { type: "button" },
                            on: { click: _vm.addFileList }
                          },
                          [_vm._v("Submit")]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-warning",
                            attrs: { type: "button" },
                            on: { click: _vm.clearFile }
                          },
                          [_vm._v("Clear")]
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _vm._m(5),
                    _vm._v(" "),
                    _c(
                      "ul",
                      { staticClass: "nav files" },
                      [
                        _vm._l(_vm.attach_files, function(item, index) {
                          return _c("li", { key: "attach_files_" + index }, [
                            _c("code", [
                              _c(
                                "a",
                                {
                                  attrs: {
                                    href: "/" + item.path_name,
                                    target: "_blank"
                                  }
                                },
                                [
                                  _c("i", { staticClass: "fa fa-file-pdf-o" }),
                                  _vm._v("  " + _vm._s(item.file_name))
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-xs btn-remove",
                                attrs: { type: "button" },
                                on: {
                                  click: function($event) {
                                    return _vm.removeFileAttachment(
                                      index,
                                      item.attachment_id
                                    )
                                  }
                                }
                              },
                              [_c("i", { staticClass: "fa fa-times" })]
                            )
                          ])
                        }),
                        _vm._v(" "),
                        _vm._l(_vm.files, function(item, index) {
                          return _c("li", { key: "files_" + index }, [
                            _c("code", [
                              _c(
                                "a",
                                {
                                  attrs: {
                                    href: _vm.getSrc(item),
                                    target: "_blank"
                                  }
                                },
                                [
                                  _c("i", { staticClass: "fa fa-file-pdf-o" }),
                                  _vm._v("  " + _vm._s(item.name))
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-xs btn-remove",
                                attrs: { type: "button" },
                                on: {
                                  click: function($event) {
                                    return _vm.removeFileLocal(index)
                                  }
                                }
                              },
                              [_c("i", { staticClass: "fa fa-times" })]
                            )
                          ])
                        })
                      ],
                      2
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "modal-footer center mt-4" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-default",
                      attrs: { type: "button", "data-dismiss": "modal" }
                    },
                    [
                      _vm._v(
                        "\n                        ปิด\n                    "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  !!_vm.consignment
                    ? _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          attrs: { type: "submit" },
                          on: { click: _vm.upload }
                        },
                        [
                          _vm._v(
                            "\n                        ยืนยัน\n                    "
                          )
                        ]
                      )
                    : _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          attrs: { "data-dismiss": "modal", type: "submit" }
                        },
                        [
                          _vm._v(
                            "\n                        ยืนยัน\n                    "
                          )
                        ]
                      )
                ])
              ])
            ]
          )
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v(
            "\n                            ลำดับ\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v(
            "\n                            รหัสผลิตภัณฑ์\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v(
            "\n                            ชื่อผลิตภัณฑ์\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v("\n                            จำนวน "),
          _c("br"),
          _vm._v(
            "\n                            พันมวน/ซอง\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "w-160", attrs: { rowspan: "2" } }, [
          _vm._v(
            "\n                            มูลค่า (บาท)\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v("\n                            ยอดขายได้ "),
          _c("br"),
          _vm._v(
            "\n                            พันมวน/ซอง\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v("\n                            คงเหลือขาย "),
          _c("br"),
          _vm._v(
            "\n                            พันมวน/ซอง\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "w-160", attrs: { colspan: "2" } }, [
          _vm._v(
            "\n                            บันทึกยอดขาย\n                        "
          )
        ])
      ]),
      _vm._v(" "),
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { staticClass: "w-160" }, [
          _vm._v(
            "\n                            พันมวน/ซอง\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "w-160" }, [
          _vm._v("\n                            ห่อ\n                        ")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "text-right", attrs: { colspan: "4" } }, [
      _c("strong", [_vm._v("รวมมูลค่า")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "text-right", attrs: { colspan: "2" } }, [
      _c("strong", [_vm._v("รวมยอดขายฝาก")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "text-right", attrs: { colspan: "7" } }, [
      _c("strong", [_vm._v("รวมมูลค่าขายฝาก")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c("h3", { staticClass: "modal-title" }, [_vm._v("Upload File")]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-label": "Close"
          }
        },
        [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", [
      _c("small", [
        _vm._v(
          "Allow type : jpeg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size < 2mb"
        )
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);