(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_rma_domestic_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/rma_domestic/Index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/rma_domestic/Index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _qm_InputGroupRepetition__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../qm/InputGroupRepetition */ "./resources/js/components/qm/InputGroupRepetition.vue");


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Index",
  components: {
    InputGroupRepetition: _qm_InputGroupRepetition__WEBPACK_IMPORTED_MODULE_2__.default
  },
  props: ["numbers", "invoices", "customers", "url", "uomlist"],
  data: function data() {
    return {
      orderLines: [],
      claimLines: [],
      result: [],
      filterNumber: this.numbers,
      filterInvoice: this.invoices,
      filterCustomer: this.customers,
      filterUomList: this.uomlist,
      loading: {
        data: false
      },
      loadingInvoice: false,
      loadingNumber: false,
      selNumber: [],
      numberSelected: '',
      dsaNumber: false,
      selInvoice: [],
      invoiceSelected: '',
      dsaInvoice: false,
      selCustomer: [],
      customerSelected: '',
      dsaCustomer: false,
      firstSearch: true,
      enaSearch: true,
      enaRow: [],
      curRmaQty: [],
      prvRmaQty: [],
      rmaQtyMessage: [],
      enaConfirmRma: true,
      procAdding: false,
      isCigaratte: false,
      isNewRma: false,
      kilometers: 0,
      meters: 0,
      cgc: 0,
      cg2: 0,
      cgp: 0,
      cgk: 0
    };
  },
  mounted: function mounted() {
    console.log("Rma domestic mounted...");
  },
  methods: {
    remoteNumbers: function remoteNumbers(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.loadingNumber = true;
                params = {
                  'keyword': query == '' ? '' : query
                };
                _context.next = 5;
                return axios.get(vm.url.ajax_get_number_list, {
                  params: params
                }).then(function (response) {
                  vm.loadingNumber = false;
                  vm.filterNumber = response.data;
                })["catch"](function (error) {
                  // console.log(error);
                  vm.loadingNumber = false;
                  vm.filterNumber = [];
                }).then(function () {// always executed
                });

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    remoteInvoice: function remoteInvoice(query) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                vm.loadingInvoice = true;
                params = {
                  'keyword': query == '' ? '' : query
                };
                _context2.next = 5;
                return axios.get(vm.url.ajax_get_invoice_list, {
                  params: params
                }).then(function (response) {
                  vm.loadingInvoice = false;
                  vm.filterInvoice = response.data;
                })["catch"](function (error) {
                  // console.log(error);
                  vm.loadingInvoice = false;
                  vm.filterInvoice = [];
                }).then(function () {// always executed
                });

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onClearSearch: function onClearSearch() {
      location.reload();
    },
    onAdd: function onAdd() {
      var vm = this;
      vm.dsaNumber = true;
      vm.selNumber.rma_date = moment__WEBPACK_IMPORTED_MODULE_1___default()().add(543, "years").format("DD/MM/YYYY");
      vm.selNumber.status_rma = 'Draft';
      vm.procAdding = true;
    },
    onSearch: function onSearch() {
      var vm = this;
      console.log(vm.selNumber);

      if (vm.selInvoice.product_type_code == '10') {
        vm.isCigaratte = true;
      }

      Swal.fire({
        title: 'กรุณารอสักครู่'
      });
      Swal.showLoading();
      axios.get(vm.url.ajax_get_lines, {
        params: {
          claim_header_id: vm.selNumber.claim_header_id
        }
      }).then(function (respons) {
        vm.orderLines = respons.data.lines;
        Swal.close();
      })["catch"](function (error) {
        // Error 😨
        Swal.close();

        if (error.response) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          console.log(error.request);
        } else {
          console.log('Error', error.message);
        }

        console.log(error.config);
      });
    },
    onNumberChange: function onNumberChange() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, nIdx, cIdx, iIdx, _iIdx;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this3;
                _context3.next = 3;
                return vm.filterNumber.findIndex(function (o) {
                  return o.rma_number == vm.numberSelected;
                });

              case 3:
                nIdx = _context3.sent;
                vm.selNumber = vm.filterNumber[nIdx];
                vm.selNumber.rma_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selNumber.rma_date).add(543, "years").format("DD/MM/YYYY");

                if (!vm.firstSearch) {
                  _context3.next = 27;
                  break;
                }

                vm.firstSearch = false;
                _context3.next = 10;
                return vm.filterCustomer.findIndex(function (o) {
                  return o.customer_id == vm.selNumber.customer_id;
                });

              case 10:
                cIdx = _context3.sent;
                vm.selCustomer = vm.filterCustomer[cIdx];
                vm.customerSelected = vm.selCustomer.customer_number;
                vm.invoiceSelected = vm.selNumber.ref_invoice_number;
                _context3.next = 16;
                return vm.remoteInvoice(vm.selNumber.ref_invoice_number);

              case 16:
                _context3.next = 18;
                return vm.filterInvoice.findIndex(function (o) {
                  return o.order_header_id == vm.selNumber.invoice_id;
                });

              case 18:
                iIdx = _context3.sent;
                vm.selInvoice = vm.filterInvoice[iIdx];
                vm.selInvoice.pick_release_approve_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selInvoice.pick_release_approve_date).add(543, "years").format("DD/MM/YYYY");
                vm.invoiceSelected = vm.selInvoice.pick_release_no;
                vm.dsaNumber = true;
                vm.dsaCustomer = true;
                vm.dsaInvoice = true;
                _context3.next = 36;
                break;

              case 27:
                if (!(vm.invoiceSelected == '')) {
                  _context3.next = 34;
                  break;
                }

                _context3.next = 30;
                return vm.filterInvoice.findIndex(function (o) {
                  return o.order_header_id == vm.selNumber.invoice_id;
                });

              case 30:
                _iIdx = _context3.sent;
                vm.selInvoice = vm.filterInvoice[_iIdx];
                vm.selInvoice.pick_release_approve_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selInvoice.pick_release_approve_date).add(543, "years").format("DD/MM/YYYY");
                vm.invoiceSelected = vm.selInvoice.pick_release_no;

              case 34:
                vm.dsaNumber = true;
                vm.dsaInvoice = true;

              case 36:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onInvoiceChange: function onInvoiceChange() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, iIdx, cIdx, _iIdx2, _cIdx, _iIdx3;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this4;

                if (!vm.procAdding) {
                  _context4.next = 21;
                  break;
                }

                _context4.next = 4;
                return vm.filterInvoice.findIndex(function (o) {
                  return o.pick_release_no == vm.invoiceSelected;
                });

              case 4:
                iIdx = _context4.sent;
                vm.selInvoice = vm.filterInvoice[iIdx];
                vm.selInvoice.pick_release_approve_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selInvoice.pick_release_approve_date).add(543, "years").format("DD/MM/YYYY");
                vm.dsaInvoice = true;
                _context4.next = 10;
                return vm.filterCustomer.findIndex(function (o) {
                  return o.customer_id == vm.selInvoice.customer_id;
                });

              case 10:
                cIdx = _context4.sent;
                vm.selCustomer = vm.filterCustomer[cIdx];
                vm.customerSelected = vm.selCustomer.customer_number;
                vm.dsaCustomer = true; //Query lines

                if (vm.selInvoice.product_type_code == '10') {
                  vm.isCigaratte = true;
                }

                Swal.fire({
                  title: 'กรุณารอสักครู่'
                });
                Swal.showLoading();
                _context4.next = 19;
                return axios.get(vm.url.ajax_get_invoice_lines, {
                  params: {
                    order_header_id: vm.selInvoice.order_header_id
                  }
                }).then(function (respons) {
                  vm.orderLines = respons.data.lines;
                  Swal.close();
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error', error.message);
                  }

                  console.log(error.config);
                });

              case 19:
                _context4.next = 48;
                break;

              case 21:
                if (!vm.firstSearch) {
                  _context4.next = 42;
                  break;
                }

                // Process adding = false & firstSearch = true
                vm.firstSearch = false; // Filter customer & invoice

                _context4.next = 25;
                return vm.filterInvoice.findIndex(function (o) {
                  return o.pick_release_no == vm.invoiceSelected;
                });

              case 25:
                _iIdx2 = _context4.sent;
                vm.selInvoice = vm.filterInvoice[_iIdx2];
                vm.selInvoice.pick_release_approve_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selInvoice.pick_release_approve_date).add(543, "years").format("DD/MM/YYYY");
                vm.dsaInvoice = true;
                _context4.next = 31;
                return vm.filterCustomer.findIndex(function (o) {
                  return o.customer_id == vm.selInvoice.customer_id;
                });

              case 31:
                _cIdx = _context4.sent;
                vm.selCustomer = vm.filterCustomer[_cIdx];
                vm.customerSelected = vm.selCustomer.customer_number;
                vm.dsaCustomer = true; // Query rma_number related to invoice

                vm.filterNumber = [];
                Swal.fire({
                  title: 'กรุณารอสักครู่'
                });
                Swal.showLoading();
                _context4.next = 40;
                return axios.get(vm.url.ajax_get_by_invoice, {
                  params: {
                    pick_release_no: vm.invoiceSelected
                  }
                }).then(function (respons) {
                  vm.filterNumber = respons.data.numbers;
                  vm.selCustomer = respons.data.customer;
                  Swal.close();
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error, ajax_get_by_invoice', error.message);
                  }

                  console.log(error.config);
                });

              case 40:
                _context4.next = 48;
                break;

              case 42:
                _context4.next = 44;
                return vm.filterInvoice.findIndex(function (o) {
                  return o.pick_release_no == vm.invoiceSelected;
                });

              case 44:
                _iIdx3 = _context4.sent;
                vm.selInvoice = vm.filterInvoice[_iIdx3];
                vm.selInvoice.pick_release_approve_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selInvoice.pick_release_approve_date).add(543, "years").format("DD/MM/YYYY");
                vm.dsaInvoice = true;

              case 48:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onCustomerChange: function onCustomerChange() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm, idx, _idx;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this5;

                if (!vm.procAdding) {
                  _context5.next = 13;
                  break;
                }

                _context5.next = 4;
                return vm.filterCustomer.findIndex(function (o) {
                  return o.customer_number == vm.customerSelected;
                });

              case 4:
                idx = _context5.sent;
                vm.selCustomer = vm.filterCustomer[idx];
                vm.filterInvoice = [];
                Swal.fire({
                  title: 'กรุณารอสักครู่'
                });
                Swal.showLoading();
                _context5.next = 11;
                return axios.get(vm.url.ajax_get_by_customer, {
                  params: {
                    customer_id: vm.selCustomer.customer_id
                  }
                }).then(function (respons) {
                  vm.filterInvoice = respons.data.invoices;
                  Swal.close();
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error', error.message);
                  }

                  console.log(error.config);
                });

              case 11:
                _context5.next = 24;
                break;

              case 13:
                vm.firstSearch = false;
                _context5.next = 16;
                return vm.filterCustomer.findIndex(function (o) {
                  return o.customer_number == vm.customerSelected;
                });

              case 16:
                _idx = _context5.sent;
                vm.selCustomer = vm.filterCustomer[_idx];
                vm.filterNumber = [];
                vm.filterInvoice = [];
                Swal.fire({
                  title: 'กรุณารอสักครู่'
                });
                Swal.showLoading();
                _context5.next = 24;
                return axios.get(vm.url.ajax_get_by_customer, {
                  params: {
                    customer_id: vm.selCustomer.customer_id
                  }
                }).then(function (respons) {
                  vm.filterNumber = respons.data.numbers;
                  vm.filterInvoice = respons.data.invoices;
                  Swal.close();
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error', error.message);
                  }

                  console.log(error.config);
                });

              case 24:
                vm.dsaCustomer = true;

              case 25:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    onSave: function onSave() {
      var vm = this;

      if (vm.selNumber.status_rma != "Draft") {
        Swal.fire({
          icon: 'error',
          title: 'ไม่สามารถบันทึกได้',
          text: 'เนื่องสถานะไม่ใช่ Draft !',
          footer: 'สถานะ : ' + vm.selNumber.status_rma
        });
      } else {
        if (vm.orderLines.length == 0) {
          Swal.fire({
            icon: 'error',
            title: 'ไม่สามารถบันทึกข้อมูล',
            text: 'เนื่องจากไม่มีรายการผลิตภัณฑ์ !'
          });
        } else {
          Swal.fire({
            title: 'กำลังบันทึกข้อมูล'
          });
          Swal.showLoading();

          if (vm.orderLines.length) {
            var lineNo = 0;

            for (var i = 0; i < vm.orderLines.length; i++) {
              if (vm.enaRow[i] == true) {
                lineNo += 1;
                vm.claimLines.push({
                  claim_line_id: vm.orderLines[i]['claim_line_id'],
                  item_id: vm.orderLines[i]['item_id'],
                  item_code: vm.orderLines[i]['item_code'],
                  item_description: vm.orderLines[i]['item_description'],
                  order_quantity: vm.orderLines[i]['approve_quantity'],
                  order_line_id: vm.orderLines[i]['order_line_id'],
                  unit_price: vm.orderLines[i]['unit_price'],
                  uom_code: vm.orderLines[i]['uom_code'],
                  rma_quantity: vm.orderLines[i]['rma_quantity'] == null ? null : vm.orderLines[i]['rma_quantity'],
                  rma_uom_code: vm.orderLines[i]['uom_code'],
                  rma_quantity_cbb: vm.orderLines[i]['rma_quantity_cbb'] == null ? null : vm.orderLines[i]['rma_quantity_cbb'],
                  rma_quantity_carton: vm.orderLines[i]['rma_quantity_carton'] == null ? null : vm.orderLines[i]['rma_quantity_carton'],
                  rma_quantity_pack: vm.orderLines[i]['rma_quantity_pack'] == null ? null : vm.orderLines[i]['rma_quantity_pack'],
                  enter_rma_quantity: vm.orderLines[i]['enter_rma_quantity'] == null ? null : vm.orderLines[i]['enter_rma_quantity'],
                  enter_rma_uom: vm.orderLines[i]['enter_rma_uom'] == null ? null : vm.orderLines[i]['enter_rma_uom'],
                  rma_line_no: lineNo
                });
              }
            }
          }

          if (vm.procAdding) {
            axios.patch(vm.url.ajax_create_rma, {
              invoice: vm.selInvoice,
              lines: vm.claimLines,
              rma_date: vm.selNumber.rma_date,
              status_rma: vm.selNumber.status_rma,
              symptom_description: vm.selNumber.symptom_description
            }).then( /*#__PURE__*/function () {
              var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6(response) {
                var lastHeader, iIdx;
                return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
                  while (1) {
                    switch (_context6.prev = _context6.next) {
                      case 0:
                        if (!(response.data.result['status'] == "S")) {
                          _context6.next = 19;
                          break;
                        }

                        lastHeader = response.data.latestHeader;
                        _context6.next = 4;
                        return axios.get(vm.url.ajax_get_new_number).then(function (response) {
                          vm.filterNumber = response.data.newNumbers;
                        })["catch"](function (error) {
                          // Error 😨
                          Swal.close();

                          if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                          } else if (error.request) {
                            console.log(error.request);
                          } else {
                            console.log('Error ajax_get_new_number', error.message);
                          }

                          console.log(error.config);
                          Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            footer: error.message
                          });
                        });

                      case 4:
                        vm.selNumber = lastHeader;
                        vm.numberSelected = response.data.result['doc_sequence_number'];
                        vm.selNumber.rma_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selNumber.rma_date).add(543, "years").format("DD/MM/YYYY");
                        vm.procAdding = false;
                        _context6.next = 10;
                        return vm.filterInvoice.findIndex(function (o) {
                          return o.order_header_id == vm.selNumber.invoice_id;
                        });

                      case 10:
                        iIdx = _context6.sent;
                        vm.selInvoice = vm.filterInvoice[iIdx];
                        vm.selNumber.province_name = vm.selInvoice.province_name;
                        _context6.next = 15;
                        return axios.get(vm.url.ajax_get_lines, {
                          params: {
                            claim_header_id: vm.selNumber.claim_header_id
                          }
                        }).then(function (respons) {
                          vm.orderLines = respons.data.lines;
                        })["catch"](function (error) {
                          // Error 😨
                          Swal.close();

                          if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                          } else if (error.request) {
                            console.log(error.request);
                          } else {
                            console.log('Error ajax_get_lines', error.message);
                          }

                          console.log(error.config);
                        });

                      case 15:
                        swal.close();
                        Swal.fire({
                          icon: 'success',
                          title: 'บันทึกข้อมูลสำเร็จ',
                          footer: response.data.result['message']
                        });
                        _context6.next = 21;
                        break;

                      case 19:
                        swal.close();
                        Swal.fire({
                          icon: 'error',
                          title: 'บันทึกข้อมูลไม่สำเร็จ!',
                          footer: response.data.result['message']
                        });

                      case 21:
                        vm.procAdding = false;
                        vm.enaRow = [];

                      case 23:
                      case "end":
                        return _context6.stop();
                    }
                  }
                }, _callee6);
              }));

              return function (_x) {
                return _ref.apply(this, arguments);
              };
            }())["catch"](function (error) {
              // Error 😨
              Swal.close();

              if (error.response) {
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
              } else if (error.request) {
                console.log(error.request);
              } else {
                console.log('Error', error.message);
              }

              console.log(error.config);
              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                footer: error.message
              });
            });
          } else {
            axios.patch(vm.url.ajax_update_rma, {
              claim_header_id: vm.selNumber.claim_header_id,
              symptom_description: vm.selNumber.symptom_description,
              claim_lines: vm.claimLines
            }).then(function (response) {
              swal.close();

              if (response.data.result['status'] == "S") {
                Swal.fire({
                  icon: 'success',
                  title: 'บันทึกข้อมูลสำเร็จ',
                  footer: response.data.result['message']
                }); // location.reload();
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'บันทึกข้อมูลไม่สำเร็จ!',
                  footer: response.data.result['message']
                });
              }
            })["catch"](function (error) {
              // Error 😨
              Swal.close();

              if (error.response) {
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
              } else if (error.request) {
                console.log(error.request);
              } else {
                console.log('Error', error.message);
              }

              console.log(error.config);
              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                footer: error.message
              });
            });
            vm.enaRow = [];
          }
        }
      }
    },
    onConfirm: function onConfirm() {
      var vm = this;
      var previousRma = [];
      var errorRma = []; // Check program condition

      if (vm.selNumber.status_rma != "Draft") {
        Swal.fire({
          icon: 'error',
          title: 'ไม่สามารถยืนยันได้',
          text: 'เนื่องสถานะไม่ใช่ Draft !',
          footer: 'สถานะ : ' + vm.selNumber.status_rma
        });
      } else {
        if (vm.orderLines.length == 0) {
          Swal.fire({
            icon: 'error',
            title: 'ไม่สามารถบันทึกข้อมูล',
            text: 'เนื่องจากไม่มีรายการผลิตภัณฑ์ !'
          });
        } else {
          Swal.fire({
            title: 'ต้องการยืนยันการคืนสินค้าหรือไม่',
            text: "โดยหากกดปุ่มยืนยันแล้วระบบจะส่งข้อมูลให้ WMS ทำการคืนของเข้าระบบ และออกใบลดหนี้",
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
          }).then( /*#__PURE__*/function () {
            var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8(result) {
              var errMessage, overOccured, i, j, lineNo, _i, iIdx, params;

              return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
                while (1) {
                  switch (_context8.prev = _context8.next) {
                    case 0:
                      if (!result.isConfirmed) {
                        _context8.next = 33;
                        break;
                      }

                      Swal.fire({
                        title: 'กรุณารอสักครู่'
                      });
                      Swal.showLoading();
                      _context8.next = 5;
                      return axios.get(vm.url.ajax_get_previous_rma, {
                        // Check previous rma quantity
                        params: {
                          invoiceNo: vm.selInvoice.pick_release_no
                        }
                      }).then(function (respons) {
                        vm.previousRma = respons.data.previousRma; // console.clear()
                        // console.log('orderLines =>')
                        // console.log(vm.orderLines)
                        // console.log('previousRma =>')
                        // console.log(vm.previousRma)
                        // console.log('isCigaratte => ' + vm.isCigaratte)
                        // Swal.close()
                      })["catch"](function (error) {
                        // Error 😨
                        Swal.close();

                        if (error.response) {
                          console.log(error.response.data);
                          console.log(error.response.status);
                          console.log(error.response.headers);
                        } else if (error.request) {
                          console.log(error.request);
                        } else {
                          console.log('Error ajax_get_previous_rma', error.message);
                        }

                        console.log(error.config);
                      });

                    case 5:
                      if (!vm.previousRma.length) {
                        _context8.next = 33;
                        break;
                      }

                      errMessage = '';
                      overOccured = false;

                      for (i = 0; i < vm.orderLines.length; i++) {
                        for (j = 0; j < vm.previousRma.length; j++) {
                          if (vm.previousRma[j]['line_id'] == vm.orderLines[i]['order_line_id']) {
                            console.log(vm.orderLines[i]);
                            console.log('item_code =>' + vm.previousRma[j]['line_id'] + ' previousRma =>' + vm.previousRma[j]['prvRmaQty']);
                            console.log('canReturn => ' + vm.previousRma[j]['canReturn'] + ' returnRequest =>' + vm.orderLines[i]['rma_quantity']);

                            if (vm.orderLines[i]['rma_quantity'] > vm.previousRma[j]['canReturn'] || vm.orderLines[i]['rma_quantity'] < 0) {
                              // check over rma or not related uom code
                              overOccured = true;
                              errMessage += vm.orderLines[i]['item_code'] + '/' + vm.orderLines[i]['item_description'] + ', ';
                            }
                          }
                        }
                      }

                      if (!(overOccured == true)) {
                        _context8.next = 14;
                        break;
                      }

                      Swal.close();
                      Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถยืนยันได้',
                        text: 'เนื่องจากขอคืนเกินจำนวนหรือเลือกหน่วยนับไม่ถูกต้อง',
                        footer: 'กรุณาตรวจสอบรหัสผลิตภัณฑ์ : ' + errMessage
                      });
                      overOccured = false;
                      return _context8.abrupt("return");

                    case 14:
                      console.log('Continue rma process...'); // Swal.fire({
                      //     title: 'กรุณารอสักครู่',
                      // });
                      // Swal.showLoading();

                      if (!vm.procAdding) {
                        _context8.next = 29;
                        break;
                      }

                      console.log('Start create rma number...');

                      if (vm.orderLines.length) {
                        lineNo = 0;

                        for (_i = 0; _i < vm.orderLines.length; _i++) {
                          if (vm.enaRow[_i] == true) {
                            lineNo += 1;
                            vm.claimLines.push({
                              // claim_line_id: vm.orderLines[i]['claim_line_id'],
                              item_id: vm.orderLines[_i]['item_id'],
                              item_code: vm.orderLines[_i]['item_code'],
                              item_description: vm.orderLines[_i]['item_description'],
                              order_quantity: vm.orderLines[_i]['approve_quantity'],
                              order_line_id: vm.orderLines[_i]['order_line_id'],
                              unit_price: vm.orderLines[_i]['unit_price'],
                              uom_code: vm.orderLines[_i]['uom_code'],
                              rma_quantity: vm.orderLines[_i]['rma_quantity'] == null ? null : vm.orderLines[_i]['rma_quantity'],
                              rma_uom_code: vm.orderLines[_i]['uom_code'],
                              rma_quantity_cbb: vm.orderLines[_i]['rma_quantity_cbb'] == null ? null : vm.orderLines[_i]['rma_quantity_cbb'],
                              rma_quantity_carton: vm.orderLines[_i]['rma_quantity_carton'] == null ? null : vm.orderLines[_i]['rma_quantity_carton'],
                              rma_quantity_pack: vm.orderLines[_i]['rma_quantity_pack'] == null ? null : vm.orderLines[_i]['rma_quantity_pack'],
                              enter_rma_quantity: vm.orderLines[_i]['enter_rma_quantity'] == null ? null : vm.orderLines[_i]['enter_rma_quantity'],
                              enter_rma_uom: vm.orderLines[_i]['enter_rma_uom'] == null ? null : vm.orderLines[_i]['enter_rma_uom'],
                              rma_line_no: lineNo
                            });
                          }
                        }
                      } // console.log('orderLines')
                      // console.log(vm.orderLines)
                      // console.log('claimLines')
                      // console.log(vm.claimLines)
                      // console.log('selInvoice')
                      // console.log(vm.selInvoice)
                      // console.log('rma_date:' + vm.selNumber.rma_date)
                      // console.log('status_rma:'  + vm.selNumber.status_rma)
                      // Swal.close()


                      _context8.next = 20;
                      return axios.patch(vm.url.ajax_create_rma, {
                        invoice: vm.selInvoice,
                        lines: vm.claimLines,
                        rma_date: vm.selNumber.rma_date,
                        status_rma: vm.selNumber.status_rma,
                        symptom_description: vm.selNumber.symptom_description
                      }).then( /*#__PURE__*/function () {
                        var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7(response) {
                          var lastHeader;
                          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
                            while (1) {
                              switch (_context7.prev = _context7.next) {
                                case 0:
                                  lastHeader = response.data.latestHeader;
                                  _context7.next = 3;
                                  return axios.get(vm.url.ajax_get_new_number).then(function (response) {
                                    vm.filterNumber = response.data.newNumbers;
                                  })["catch"](function (error) {
                                    // Error 😨
                                    Swal.close();

                                    if (error.response) {
                                      console.log(error.response.data);
                                      console.log(error.response.status);
                                      console.log(error.response.headers);
                                    } else if (error.request) {
                                      console.log(error.request);
                                    } else {
                                      console.log('Error ajax_get_new_number', error.message);
                                    }

                                    console.log(error.config);
                                    Swal.fire({
                                      icon: 'error',
                                      title: 'เกิดข้อผิดพลาด!',
                                      footer: error.message
                                    });
                                  });

                                case 3:
                                  vm.selNumber = lastHeader;
                                  vm.numberSelected = response.data.result['doc_sequence_number'];
                                  vm.selNumber.rma_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(vm.selNumber.rma_date).add(543, "years").format("DD/MM/YYYY");
                                  console.log('Create rma number success ...');

                                case 7:
                                case "end":
                                  return _context7.stop();
                              }
                            }
                          }, _callee7);
                        }));

                        return function (_x3) {
                          return _ref3.apply(this, arguments);
                        };
                      }())["catch"](function (error) {
                        // Error 😨
                        Swal.close();

                        if (error.response) {
                          console.log(error.response.data);
                          console.log(error.response.status);
                          console.log(error.response.headers);
                        } else if (error.request) {
                          console.log(error.request);
                        } else {
                          console.log('Error ajax_create_rma', error.message);
                        }

                        console.log(error.config);
                        Swal.fire({
                          icon: 'error',
                          title: 'เกิดข้อผิดพลาด!',
                          footer: error.message
                        });
                      });

                    case 20:
                      vm.procAdding = false;
                      _context8.next = 23;
                      return vm.filterInvoice.findIndex(function (o) {
                        return o.order_header_id == vm.selNumber.invoice_id;
                      });

                    case 23:
                      iIdx = _context8.sent;
                      vm.selInvoice = vm.filterInvoice[iIdx];
                      vm.selNumber.province_name = vm.selInvoice.province_name;
                      console.log('claim_header_id :' + vm.selNumber.claim_header_id);
                      _context8.next = 29;
                      return axios.get(vm.url.ajax_get_lines, {
                        params: {
                          claim_header_id: vm.selNumber.claim_header_id
                        }
                      }).then(function (respons) {
                        vm.orderLines = respons.data.lines;
                      })["catch"](function (error) {
                        // Error 😨
                        Swal.close();

                        if (error.response) {
                          console.log(error.response.data);
                          console.log(error.response.status);
                          console.log(error.response.headers);
                        } else if (error.request) {
                          console.log(error.request);
                        } else {
                          console.log('Error ajax_get_lines', error.message);
                        }

                        console.log(error.config);
                      });

                    case 29:
                      console.log('Start confirm rma...'); // console.log('claimHeader :')
                      // console.log(vm.selNumber)
                      // console.log('claimLines :')
                      // console.log(vm.orderLines)
                      // console.log('orderHeader :')
                      // console.log(vm.selInvoice)

                      params = {
                        claimHeader: vm.selNumber,
                        claimLines: vm.orderLines,
                        orderHeader: vm.selInvoice
                      };
                      _context8.next = 33;
                      return axios.patch(vm.url.ajax_confirm_rma, params).then(function (response) {
                        if (response.data.result['status'] == "S") {
                          vm.selNumber.status_rma = 'Confirm';
                          vm.selNumber.credit_note_number = response.data.result['cnNumber'];
                          console.log(vm.selNumber.status_rma);
                          console.log(vm.selNumber.credit_note_number);
                          vm.procAdding = false;
                          vm.enaRow = [];
                          swal.close();
                          Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            footer: response.data.result['message']
                          }); // location.reload();
                        } else {
                          swal.close();
                          Swal.fire({
                            icon: 'error',
                            title: 'บันทึกข้อมูลไม่สำเร็จ!',
                            footer: response.data.result['message']
                          });
                        }
                      })["catch"](function (error) {
                        // Error 😨
                        Swal.close();

                        if (error.response) {
                          console.log(error.response.data);
                          console.log(error.response.status);
                          console.log(error.response.headers);
                        } else if (error.request) {
                          console.log(error.request);
                        } else {
                          console.log('Error ajax_confirm_rma', error.message);
                        }

                        console.log(error.config);
                        Swal.fire({
                          icon: 'error',
                          title: 'เกิดข้อผิดพลาด!',
                          footer: error.message
                        });
                      });

                    case 33:
                    case "end":
                      return _context8.stop();
                  }
                }
              }, _callee8);
            }));

            return function (_x2) {
              return _ref2.apply(this, arguments);
            };
          }());
        }
      }
    },
    onCancel: function onCancel() {
      var vm = this;

      if (vm.selNumber.status_rma == 'Cancelled') {
        Swal.fire({
          icon: 'error',
          title: 'ไม่สามารถยกเลิกได้',
          text: 'เนื่องสถานะไม่ใช่ Confirm หรือ Draft !',
          footer: 'สถานะ : ' + vm.selNumber.status_rma
        });
      } else {
        Swal.fire({
          title: 'โปรดระบุเหตุผลที่ต้องการยกเลิก',
          input: 'textarea',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          reverseButtons: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ยืนยัน',
          cancelButtonText: 'ยกเลิก',
          preConfirm: function preConfirm(reason) {
            if (reason.length == 0 || reason == null) {
              console.log('Text box is empty.');
              Swal.fire({
                icon: 'error',
                title: 'ไม่สามารถยกเลิกได้',
                text: 'เนื่องจากไม่ระบุเหตุผล!'
              });
              return;
            }

            Swal.fire({
              title: 'กรุณารอสักครู่'
            });
            Swal.showLoading(); // console.log('selNumber => ')
            // console.log(vm.selNumber)

            axios.get(vm.url.ajax_cancel_rma, {
              params: {
                rma_number: vm.selNumber.rma_number,
                cn_number: vm.selNumber.credit_note_number == null ? 'null' : vm.selNumber.credit_note_number,
                rma_status: vm.selNumber.status_rma,
                pick_release_no: vm.selInvoice.pick_release_no,
                rma_cancel_reason: reason
              }
            }).then(function (response) {
              Swal.close();
              console.log(response.data.result);

              if (response.data.result['status'] == "S") {
                // await this.refreshPage(vm.numberSelected)
                vm.selNumber.status_rma = 'Cancelled';
                Swal.fire({
                  icon: 'success',
                  title: 'ยกเลิกสำเร็จ',
                  footer: response.data.result['message']
                }); // location.reload();
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'ยกเลิกไม่สำเร็จ!',
                  footer: response.data.result['message']
                });
              }
            })["catch"](function (error) {
              // Error 😨
              Swal.close();

              if (error.response) {
                console.log(error.response.data);
                console.log(error.response.status);
                console.log(error.response.headers);
              } else if (error.request) {
                console.log(error.request);
              } else {
                console.log('Error, ajax_cancel_rma', error.message);
              }

              console.log(error.config);
              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                footer: error.message
              });
            });
          }
        });
      }
    },
    onTest: function onTest() {
      var rmaNo = '65RMA0035';
      this.numberSelected = rmaNo;
      this.refreshPage(rmaNo);
    },
    onTestUom: function onTestUom() {
      console.clear();
      console.log('orderLines =>');
      console.log(this.orderLines);
      console.log('selNumber =>');
      console.log(this.selNumber);
      console.log('selInvoice =>');
      console.log(this.selInvoice);
    },
    onTest_number: function onTest_number() {
      this.numberSelected = '65RMA0036';
    },
    onTest_a: function onTest_a() {
      Swal.fire({
        icon: 'success',
        title: 'Hello',
        text: 'This is test'
      });
      var vm = this;

      if (vm.selInvoice.product_type_code == '10') {
        vm.isCigaratte = true;
      }

      Swal.fire({
        title: 'กรุณารอสักครู่'
      });
      Swal.showLoading();
      axios.get(vm.url.ajax_get_lines, {
        params: {
          claim_header_id: vm.selNumber.claim_header_id
        }
      }).then(function (respons) {
        vm.orderLines = respons.data.lines;
        console.log('return from ajax_get_line');
        console.log(vm.orderLines);
        Swal.close();
      })["catch"](function (error) {
        // Error 😨
        Swal.close();

        if (error.response) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          console.log(error.request);
        } else {
          console.log('Error', error.message);
        }

        console.log(error.config);
      });
    },
    sumCgkO: function sumCgkO(idx) {
      var totalOrder = 0;

      if (this.isCigaratte) {
        var cgc = 0;
        var cg2 = 0;
        cgc = this.orderLines[idx].cgc_cgk * this.orderLines[idx].approve_cardboardbox;
        cg2 = this.orderLines[idx].cg2_cgk * this.orderLines[idx].approve_carton;
        totalOrder = cgc + cg2;
      } else {
        totalOrder = this.orderLines[idx].rma_quantity;
      }

      return totalOrder;
    },
    sumCgkR: function sumCgkR(idx) {
      var totalCgk = 0;
      var prvRma = 0;
      var cgc = 0;
      var cg2 = 0;
      var cgp = 0; // console.log('cgc_cgk :  ' + this.orderLines[idx].cgc_cgk + 'rma_quantity_cbb  :  ' + this.orderLines[idx].rma_quantity_cbb);
      // console.log('cg2_cgk  :  ' + this.orderLines[idx].cg2_cgk + 'rma_quantity_carton  :  ' + this.orderLines[idx].rma_quantity_carton);

      if (typeof this.orderLines[idx].rma_quantity_cbb == "undefined") {
        cgc = 0;
      } else {
        cgc = this.orderLines[idx].cgc_cgk * this.orderLines[idx].rma_quantity_cbb;
      }

      if (typeof this.orderLines[idx].rma_quantity_carton == "undefined") {
        cg2 = 0;
      } else {
        cg2 = this.orderLines[idx].cg2_cgk * this.orderLines[idx].rma_quantity_carton;
      }

      if (typeof this.orderLines[idx].rma_quantity_pack == "undefined") {
        cgp = 0;
      } else {
        cgp = this.orderLines[idx].cgp_cgk * this.orderLines[idx].rma_quantity_pack;
      }

      totalCgk = cgc + cg2 + cgp;

      if (this.isCigaratte) {
        this.orderLines[idx].rma_quantity = totalCgk;
      }

      this.curRmaQty[idx] = totalCgk;

      if (typeof this.prvRmaQty[idx] == "undefined") {
        prvRma = 0;
      } else {
        prvRma = this.prvRmaQty[idx];
      } // console.log('totalCgk :  ' + totalCgk + '  =>  ' + this.orderLines[idx].rma_quantity);
      // console.log('idx : ', idx);


      console.log(idx + '  Item : ' + '=>' + prvRma + '/' + totalCgk);
      return totalCgk;
    },
    rmaQuantity: function rmaQuantity(idx) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _context9.next = 2;
                return axios.get(_this6.url.ajax_convert_unit, {
                  params: {
                    orgId: _this6.selInvoice.org_id,
                    itemId: _this6.orderLines[idx].item_id,
                    qty: _this6.orderLines[idx].enter_rma_quantity,
                    fromUnit: _this6.orderLines[idx].enter_rma_uom,
                    toUnit: _this6.orderLines[idx].uom_code
                  }
                }).then(function (response) {
                  _this6.orderLines[idx].rma_quantity = response.data.convertResult;
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error, ajax_convert_unit', error.message);
                  }

                  console.log(error.config);
                  Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    footer: error.message
                  });
                });

              case 2:
                console.log('orgId : ' + _this6.selInvoice.org_id);
                console.log('itemId : ' + _this6.orderLines[idx].item_id);
                console.log('qty : ' + _this6.orderLines[idx].enter_rma_quantity);
                console.log('fromUnit :' + _this6.orderLines[idx].enter_rma_uom);
                console.log('toUnit :' + _this6.orderLines[idx].uom_code);
                console.log('result :' + _this6.orderLines[idx].rma_quantity);

              case 8:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    rmaQuantityCi: function rmaQuantityCi(idx) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var totalCgk, cgc, cg2, cgp;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                totalCgk = 0;
                cgc = 0;
                cg2 = 0;
                cgp = 0;

                if (!(typeof _this7.orderLines[idx].rma_quantity_cbb == "undefined")) {
                  _context10.next = 8;
                  break;
                }

                cgc = 0;
                _context10.next = 10;
                break;

              case 8:
                _context10.next = 10;
                return axios.get(_this7.url.ajax_convert_unit, {
                  params: {
                    orgId: _this7.selInvoice.org_id,
                    itemId: _this7.orderLines[idx].item_id,
                    qty: _this7.orderLines[idx].rma_quantity_cbb,
                    fromUnit: 'CGC',
                    toUnit: _this7.orderLines[idx].uom_code
                  }
                }).then(function (response) {
                  cgc = response.data.convertResult;
                  console.log('orgId : ' + _this7.selInvoice.org_id);
                  console.log('itemId : ' + _this7.orderLines[idx].item_id);
                  console.log('qty : ' + _this7.orderLines[idx].enter_rma_quantity);
                  console.log('fromUnit :' + 'CGC');
                  console.log('toUnit :' + _this7.orderLines[idx].uom_code);
                  console.log('result :' + cgc);
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error, ajax_convert_unit', error.message);
                  }

                  console.log(error.config);
                  Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    footer: error.message
                  });
                });

              case 10:
                if (!(typeof _this7.orderLines[idx].rma_quantity_carton == "undefined")) {
                  _context10.next = 14;
                  break;
                }

                cg2 = 0;
                _context10.next = 16;
                break;

              case 14:
                _context10.next = 16;
                return axios.get(_this7.url.ajax_convert_unit, {
                  params: {
                    orgId: _this7.selInvoice.org_id,
                    itemId: _this7.orderLines[idx].item_id,
                    qty: _this7.orderLines[idx].rma_quantity_carton,
                    fromUnit: 'CG2',
                    toUnit: _this7.orderLines[idx].uom_code
                  }
                }).then(function (response) {
                  cg2 = response.data.convertResult;
                  console.log('orgId : ' + _this7.selInvoice.org_id);
                  console.log('itemId : ' + _this7.orderLines[idx].item_id);
                  console.log('qty : ' + _this7.orderLines[idx].enter_rma_quantity);
                  console.log('fromUnit :' + 'CG2');
                  console.log('toUnit :' + _this7.orderLines[idx].uom_code);
                  console.log('result :' + cg2);
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error, ajax_convert_unit', error.message);
                  }

                  console.log(error.config);
                  Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    footer: error.message
                  });
                });

              case 16:
                if (!(typeof _this7.orderLines[idx].rma_quantity_pack == "undefined")) {
                  _context10.next = 20;
                  break;
                }

                cgp = 0;
                _context10.next = 22;
                break;

              case 20:
                _context10.next = 22;
                return axios.get(_this7.url.ajax_convert_unit, {
                  params: {
                    orgId: _this7.selInvoice.org_id,
                    itemId: _this7.orderLines[idx].item_id,
                    qty: _this7.orderLines[idx].rma_quantity_pack,
                    fromUnit: 'CGP',
                    toUnit: _this7.orderLines[idx].uom_code
                  }
                }).then(function (response) {
                  cgp = response.data.convertResult;
                  console.log('orgId : ' + _this7.selInvoice.org_id);
                  console.log('itemId : ' + _this7.orderLines[idx].item_id);
                  console.log('qty : ' + _this7.orderLines[idx].enter_rma_quantity);
                  console.log('fromUnit :' + 'CGP');
                  console.log('toUnit :' + _this7.orderLines[idx].uom_code);
                  console.log('result :' + cgp);
                })["catch"](function (error) {
                  // Error 😨
                  Swal.close();

                  if (error.response) {
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                  } else if (error.request) {
                    console.log(error.request);
                  } else {
                    console.log('Error, ajax_convert_unit', error.message);
                  }

                  console.log(error.config);
                  Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    footer: error.message
                  });
                });

              case 22:
                totalCgk = parseFloat(cgc) + parseFloat(cg2) + parseFloat(cgp);
                _this7.orderLines[idx].rma_quantity = parseFloat(totalCgk);
                console.log('itemIdx => ' + idx);
                console.log('rma_quantity_cbb => ' + _this7.orderLines[idx].rma_quantity_cbb);
                console.log('rma_quantity_carton => ' + _this7.orderLines[idx].rma_quantity_carton);
                console.log('rma_quantity_pack => ' + _this7.orderLines[idx].rma_quantity_pack);
                console.log('rma_quantity => ' + _this7.orderLines[idx].rma_quantity);

              case 29:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    }
  },
  computed: {// totalRmaQuantity() {
    //     let vm = this;
    //     let totalCgk = 0;
    //     let cgc = 0;
    //     let cg2 = 0;
    //     let cgp = 0;
    //     if (vm.orderLines.length){
    //         for (let i = 0; i < vm.orderLines.length; i++) {
    //             cgc = vm.orderLines[i]['cgc_cgk'] * vm.orderLines['rma_quantity_cbb'];
    //             cg2 = vm.orderLines[i]['cg2_cgk'] * vm.orderLines['rma_quantity_carton'];
    //             cgp = vm.orderLines[i]['cgp_cgk'] * vm.orderLines['rma_quantity_pack'];
    //         }
    //     }
    // },
  },
  watch: {
    kilometers: function kilometers(val) {
      this.kilometers = val;
      this.meters = val * 1000;
    },
    meters: function meters(val) {
      this.kilometers = val / 1000;
      this.meters = val;
    },
    cgc: function cgc(val) {
      this.cgc = val;
      this.cg2 = val * 50;
      this.cgp = val * 500;
      this.cgk = val * 10;
    },
    cg2: function cg2(val) {
      this.cg2 = val;
      this.cgc = val * 0.02;
      this.cgp = val * 10;
      this.cgk = val * 0.2;
    },
    cgp: function cgp(val) {
      this.cgp = val;
      this.cgc = val * 0.002;
      this.cg2 = val * 0.1;
      this.cgk = val * 0.02;
    },
    cgk: function cgk(val) {
      this.cgk = val; // this.cgc = val * 0.01;
      // this.cg2 = val * 5;
      // this.cgp = val * 50;
    },
    'selInvoice.rma_quantity': function selInvoiceRma_quantity() {
      if (this.isCigaratte) {} else {}
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["repeatFlagValue", "repeatTimeHourValue", "repeatTimeMinValue", "repeatQtyValue"],
  data: function data() {
    return {
      repeatFlag: this.repeatFlagValue == 'true',
      repeatTimeHour: this.repeatTimeHourValue,
      repeatTimeMin: this.repeatTimeMinValue,
      repeatQty: this.repeatQtyValue
    };
  },
  mounted: function mounted() {},
  methods: {
    onRepeatTimeHourChanged: function onRepeatTimeHourChanged(e) {
      var value = e.target.value;

      if (value >= 10) {
        this.repeatTimeHour = 10;
        this.repeatTimeMin = 0;
      }
    },
    onRepeatTimeMinChanged: function onRepeatTimeMinChanged(e) {
      var value = e.target.value;

      if (value > 59) {
        this.repeatTimeMin = 59;
      }

      if (this.repeatTimeHour >= 10) {
        this.repeatTimeMin = 0;
      }
    },
    onFlagChanged: function onFlagChanged(value) {
      this.repeatFlag = value;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/rma_domestic/Index.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/om/rma_domestic/Index.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_650fa570_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=650fa570&scoped=true& */ "./resources/js/components/om/rma_domestic/Index.vue?vue&type=template&id=650fa570&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/om/rma_domestic/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_650fa570_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_650fa570_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "650fa570",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/rma_domestic/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/InputGroupRepetition.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/qm/InputGroupRepetition.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputGroupRepetition.vue?vue&type=template&id=414ff45e& */ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&");
/* harmony import */ var _InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputGroupRepetition.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/InputGroupRepetition.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/rma_domestic/Index.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/om/rma_domestic/Index.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/rma_domestic/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputGroupRepetition.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/rma_domestic/Index.vue?vue&type=template&id=650fa570&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/om/rma_domestic/Index.vue?vue&type=template&id=650fa570&scoped=true& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_650fa570_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_650fa570_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_650fa570_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=650fa570&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/rma_domestic/Index.vue?vue&type=template&id=650fa570&scoped=true&");


/***/ }),

/***/ "./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputGroupRepetition_vue_vue_type_template_id_414ff45e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputGroupRepetition.vue?vue&type=template&id=414ff45e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/rma_domestic/Index.vue?vue&type=template&id=650fa570&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/rma_domestic/Index.vue?vue&type=template&id=650fa570&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "container-fluid" }, [
    _c("div", { staticClass: "form-group row" }, [
      _c("div", { staticClass: "col-lg-12" }, [
        _c(
          "div",
          {
            directives: [
              {
                name: "loading",
                rawName: "v-loading",
                value: _vm.loading.data,
                expression: "loading.data"
              }
            ],
            staticClass: "ibox"
          },
          [
            _c("div", { staticClass: "ibox-title" }, [
              _c("h5", [_vm._v("คืนสินค้า (RMA)")]),
              _vm._v(" "),
              _c("div", { staticClass: "form-header-buttons" }, [
                _c("div", { staticClass: "d-flex" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-md btn-white",
                      on: { click: _vm.onClearSearch }
                    },
                    [_c("i", { staticClass: "fa fa-repeat" })]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "buttons multiple" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-md btn-success",
                      attrs: { type: "button" },
                      on: { click: _vm.onAdd }
                    },
                    [
                      _c("i", { staticClass: "fa fa-plus" }),
                      _vm._v(
                        "\n                                    สร้าง\n                                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-md btn-white",
                      attrs: { type: "button" },
                      on: { click: _vm.onSearch }
                    },
                    [
                      _c("i", { staticClass: "fa fa-search" }),
                      _vm._v(
                        "\n                                    ค้นหา\n                                "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "dropdown" }, [
                    _vm._m(0),
                    _vm._v(" "),
                    _c("ul", { staticClass: "dropdown-menu" }, [
                      _c("li", [
                        _c(
                          "a",
                          {
                            attrs: { disabled: "" },
                            on: { click: _vm.onSave }
                          },
                          [_vm._v("บันทึก")]
                        )
                      ]),
                      _vm._v(" "),
                      _c("li", [
                        _c("a", { on: { click: _vm.onConfirm } }, [
                          _vm._v("ยืนยัน")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("li", [
                        _c("a", { on: { click: _vm.onCancel } }, [
                          _vm._v("ยกเลิก")
                        ])
                      ])
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "ibox-content" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c("div", { staticClass: "col-sm-4" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c("label", [_vm._v("เลขที่คืนสินค้า")]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          directives: [
                            {
                              name: "loading",
                              rawName: "v-loading",
                              value: _vm.loading.data,
                              expression: "loading.data"
                            }
                          ],
                          staticClass: "col-sm-12 px-0",
                          staticStyle: { width: "100%" },
                          attrs: {
                            filterable: "",
                            remote: "",
                            loading: _vm.loadingNumber,
                            "remote-method": _vm.remoteNumbers,
                            disabled: _vm.dsaNumber,
                            placeholder: "กรุณาเลือกเลขที่คืนสินค้า"
                          },
                          on: { change: _vm.onNumberChange },
                          model: {
                            value: _vm.numberSelected,
                            callback: function($$v) {
                              _vm.numberSelected = $$v
                            },
                            expression: "numberSelected"
                          }
                        },
                        _vm._l(this.filterNumber, function(item) {
                          return _c(
                            "el-option",
                            {
                              key: item.rma_number,
                              attrs: {
                                label: item.rma_number,
                                value: item.rma_number,
                                selected: item.rma_number == _vm.numberSelected
                              }
                            },
                            [
                              _c(
                                "div",
                                {
                                  staticStyle: {
                                    display: "flex",
                                    "flex-direction": "row",
                                    "justify-content": "space-between"
                                  }
                                },
                                [
                                  _c("span", [_vm._v(_vm._s(item.rma_number))]),
                                  _vm._v(" "),
                                  _c(
                                    "span",
                                    {
                                      staticStyle: {
                                        "font-size": ".8rem",
                                        color: "#ccc"
                                      }
                                    },
                                    [
                                      _vm._v(
                                        _vm._s(
                                          item.rma_number +
                                            " : " +
                                            item.ref_invoice_number +
                                            " : " +
                                            item.status_rma
                                        )
                                      )
                                    ]
                                  )
                                ]
                              )
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
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("label", [_vm._v("วันที่คืนสินค้า")]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selNumber.rma_date,
                        expression: "selNumber.rma_date"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.selNumber.rma_date },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.selNumber, "rma_date", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("label", [_vm._v("สถานะ")]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.selNumber.status_rma,
                        expression: "selNumber.status_rma"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.selNumber.status_rma },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.selNumber,
                          "status_rma",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("div", { staticClass: "col-sm-4" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c("label", [_vm._v("อ้างอิง Invoice เลขที่")]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          staticClass: "col-sm-12 px-0",
                          staticStyle: { width: "100%" },
                          attrs: {
                            filterable: "",
                            remote: "",
                            loading: _vm.loadingInvoice,
                            "remote-method": _vm.remoteInvoice,
                            disabled: _vm.dsaInvoice,
                            placeholder: "กรุณาเลือกเลขที่ Invoice"
                          },
                          on: { change: _vm.onInvoiceChange },
                          model: {
                            value: _vm.invoiceSelected,
                            callback: function($$v) {
                              _vm.invoiceSelected = $$v
                            },
                            expression: "invoiceSelected"
                          }
                        },
                        _vm._l(this.filterInvoice, function(item) {
                          return _c("el-option", {
                            key: item.pick_release_no,
                            attrs: {
                              label: item.pick_release_no,
                              value: item.pick_release_no,
                              selected:
                                item.pick_release_no == _vm.invoiceSelected
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
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("วันที่ Invoice")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selInvoice.pick_release_approve_date,
                          expression: "selInvoice.pick_release_approve_date"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: {
                        value: _vm.selInvoice.pick_release_approve_date
                      },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selInvoice,
                            "pick_release_approve_date",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("เลขที่ใบลดหนี้")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selNumber.credit_note_number,
                          expression: "selNumber.credit_note_number"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.selNumber.credit_note_number },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selNumber,
                            "credit_note_number",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("div", { staticClass: "col-sm-4" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c("label", [_vm._v("รหัสร้านค้า")]),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          staticClass: "col-sm-12 px-0",
                          staticStyle: { width: "100%" },
                          attrs: {
                            filterable: "",
                            disabled: _vm.dsaCustomer,
                            placeholder: "กรุณาเลือกรหัสร้านค้า"
                          },
                          on: { change: _vm.onCustomerChange },
                          model: {
                            value: _vm.customerSelected,
                            callback: function($$v) {
                              _vm.customerSelected = $$v
                            },
                            expression: "customerSelected"
                          }
                        },
                        _vm._l(this.filterCustomer, function(item) {
                          return _c("el-option", {
                            key: item.customer_number,
                            attrs: {
                              label:
                                item.customer_number +
                                " : " +
                                item.customer_name,
                              value: item.customer_number,
                              selected:
                                item.customer_number == _vm.customerSelected
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
                _c("div", { staticClass: "col-sm-8" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("ชื่อร้านค้า")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selCustomer.customer_name,
                          expression: "selCustomer.customer_name"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.selCustomer.customer_name },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selCustomer,
                            "customer_name",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("สั่งทาง")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selInvoice.source_system,
                          expression: "selInvoice.source_system"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.selInvoice.source_system },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selInvoice,
                            "source_system",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("หมายเหตุสั่งทาง")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selInvoice.remark_source_system,
                          expression: "selInvoice.remark_source_system"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.selInvoice.remark_source_system },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selInvoice,
                            "remark_source_system",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-4" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("สถานที่จัดส่งสินค้า")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selInvoice.ship_to_site_name,
                          expression: "selInvoice.ship_to_site_name"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", disabled: "" },
                      domProps: { value: _vm.selInvoice.ship_to_site_name },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selInvoice,
                            "ship_to_site_name",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("div", { staticClass: "col-sm-6" }, [
                  _c("div", { staticClass: "form-group" }, [
                    _c("label", [_vm._v("หมายเหตุรายการ")]),
                    _vm._v(" "),
                    _c("textarea", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.selNumber.symptom_description,
                          expression: "selNumber.symptom_description"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { rows: "3" },
                      domProps: { value: _vm.selNumber.symptom_description },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.selNumber,
                            "symptom_description",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "hr-line-dashed" }),
              _vm._v(" "),
              _c("div", { staticClass: "col-xl-12" }, [
                _vm.isCigaratte
                  ? _c("div", { staticClass: "table-responsive" }, [
                      _c(
                        "table",
                        {
                          staticClass:
                            "table table-bordered text-center table-hover f13"
                        },
                        [
                          _vm._m(1),
                          _vm._v(" "),
                          _vm.orderLines.length
                            ? _c(
                                "tbody",
                                _vm._l(_vm.orderLines, function(item, itemIdx) {
                                  return _c("tr", { key: itemIdx }, [
                                    _c("td", [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: _vm.enaRow[itemIdx],
                                            expression: "enaRow[itemIdx]"
                                          }
                                        ],
                                        attrs: {
                                          type: "checkbox",
                                          disabled:
                                            _vm.selNumber.status_rma ==
                                              "Confirm" ||
                                            _vm.selNumber.status_rma ==
                                              "Cancelled"
                                        },
                                        domProps: {
                                          checked: Array.isArray(
                                            _vm.enaRow[itemIdx]
                                          )
                                            ? _vm._i(
                                                _vm.enaRow[itemIdx],
                                                null
                                              ) > -1
                                            : _vm.enaRow[itemIdx]
                                        },
                                        on: {
                                          change: function($event) {
                                            var $$a = _vm.enaRow[itemIdx],
                                              $$el = $event.target,
                                              $$c = $$el.checked ? true : false
                                            if (Array.isArray($$a)) {
                                              var $$v = null,
                                                $$i = _vm._i($$a, $$v)
                                              if ($$el.checked) {
                                                $$i < 0 &&
                                                  _vm.$set(
                                                    _vm.enaRow,
                                                    itemIdx,
                                                    $$a.concat([$$v])
                                                  )
                                              } else {
                                                $$i > -1 &&
                                                  _vm.$set(
                                                    _vm.enaRow,
                                                    itemIdx,
                                                    $$a
                                                      .slice(0, $$i)
                                                      .concat(
                                                        $$a.slice($$i + 1)
                                                      )
                                                  )
                                              }
                                            } else {
                                              _vm.$set(_vm.enaRow, itemIdx, $$c)
                                            }
                                          }
                                        }
                                      })
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(itemIdx + 1))]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(item.item_code))]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(_vm._s(item.item_description))
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(_vm._s(item.approve_cardboardbox))
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(_vm._s(item.approve_carton))
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _c("vue-numeric", {
                                          staticClass: "form-control",
                                          staticStyle: {
                                            "text-align": "right"
                                          },
                                          attrs: {
                                            separator: ",",
                                            disabled: !_vm.enaRow[itemIdx]
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.rmaQuantityCi(itemIdx)
                                            }
                                          },
                                          model: {
                                            value: item.rma_quantity_cbb,
                                            callback: function($$v) {
                                              _vm.$set(
                                                item,
                                                "rma_quantity_cbb",
                                                $$v
                                              )
                                            },
                                            expression: "item.rma_quantity_cbb"
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
                                          staticClass: "form-control",
                                          staticStyle: {
                                            "text-align": "right"
                                          },
                                          attrs: {
                                            separator: ",",
                                            disabled: !_vm.enaRow[itemIdx]
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.rmaQuantityCi(itemIdx)
                                            }
                                          },
                                          model: {
                                            value: item.rma_quantity_carton,
                                            callback: function($$v) {
                                              _vm.$set(
                                                item,
                                                "rma_quantity_carton",
                                                $$v
                                              )
                                            },
                                            expression:
                                              "item.rma_quantity_carton"
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
                                          staticClass: "form-control",
                                          staticStyle: {
                                            "text-align": "right"
                                          },
                                          attrs: {
                                            separator: ",",
                                            disabled: !_vm.enaRow[itemIdx]
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.rmaQuantityCi(itemIdx)
                                            }
                                          },
                                          model: {
                                            value: item.rma_quantity_pack,
                                            callback: function($$v) {
                                              _vm.$set(
                                                item,
                                                "rma_quantity_pack",
                                                $$v
                                              )
                                            },
                                            expression: "item.rma_quantity_pack"
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ])
                                }),
                                0
                              )
                            : _c("tbody", [_vm._m(2)])
                        ]
                      )
                    ])
                  : _c("div", { staticClass: "table-responsive" }, [
                      _c(
                        "table",
                        {
                          staticClass:
                            "table table-bordered text-center table-hover f13"
                        },
                        [
                          _vm._m(3),
                          _vm._v(" "),
                          _vm.orderLines.length
                            ? _c(
                                "tbody",
                                _vm._l(_vm.orderLines, function(item, itemIdx) {
                                  return _c("tr", { key: itemIdx }, [
                                    _c("td", [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: _vm.enaRow[itemIdx],
                                            expression: "enaRow[itemIdx]"
                                          }
                                        ],
                                        attrs: {
                                          type: "checkbox",
                                          disabled:
                                            _vm.selNumber.status_rma != "Draft"
                                        },
                                        domProps: {
                                          checked: Array.isArray(
                                            _vm.enaRow[itemIdx]
                                          )
                                            ? _vm._i(
                                                _vm.enaRow[itemIdx],
                                                null
                                              ) > -1
                                            : _vm.enaRow[itemIdx]
                                        },
                                        on: {
                                          change: function($event) {
                                            var $$a = _vm.enaRow[itemIdx],
                                              $$el = $event.target,
                                              $$c = $$el.checked ? true : false
                                            if (Array.isArray($$a)) {
                                              var $$v = null,
                                                $$i = _vm._i($$a, $$v)
                                              if ($$el.checked) {
                                                $$i < 0 &&
                                                  _vm.$set(
                                                    _vm.enaRow,
                                                    itemIdx,
                                                    $$a.concat([$$v])
                                                  )
                                              } else {
                                                $$i > -1 &&
                                                  _vm.$set(
                                                    _vm.enaRow,
                                                    itemIdx,
                                                    $$a
                                                      .slice(0, $$i)
                                                      .concat(
                                                        $$a.slice($$i + 1)
                                                      )
                                                  )
                                              }
                                            } else {
                                              _vm.$set(_vm.enaRow, itemIdx, $$c)
                                            }
                                          }
                                        }
                                      })
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(itemIdx + 1))]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(item.item_code))]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(_vm._s(item.item_description))
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [
                                      _vm._v(_vm._s(item.order_quantity))
                                    ]),
                                    _vm._v(" "),
                                    _c("td", [_vm._v(_vm._s(item.uom))]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _c("vue-numeric", {
                                          staticClass: "form-control",
                                          staticStyle: {
                                            "text-align": "right"
                                          },
                                          attrs: {
                                            separator: ",",
                                            disabled: !_vm.enaRow[itemIdx]
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.rmaQuantity(itemIdx)
                                            }
                                          },
                                          model: {
                                            value: item.enter_rma_quantity,
                                            callback: function($$v) {
                                              _vm.$set(
                                                item,
                                                "enter_rma_quantity",
                                                $$v
                                              )
                                            },
                                            expression:
                                              "item.enter_rma_quantity"
                                          }
                                        })
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      [
                                        _c(
                                          "el-select",
                                          {
                                            attrs: {
                                              filterable: "",
                                              disabled: !_vm.enaRow[itemIdx],
                                              placeholder: "กรุณาเลือกหน่วยนับ"
                                            },
                                            on: {
                                              change: function($event) {
                                                return _vm.rmaQuantity(itemIdx)
                                              }
                                            },
                                            model: {
                                              value: item.enter_rma_uom,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  item,
                                                  "enter_rma_uom",
                                                  $$v
                                                )
                                              },
                                              expression: "item.enter_rma_uom"
                                            }
                                          },
                                          _vm._l(_vm.filterUomList, function(
                                            ulist
                                          ) {
                                            return _c("el-option", {
                                              key: ulist.uom_code,
                                              attrs: {
                                                label: ulist.unit_of_measure,
                                                value: ulist.uom_code
                                              }
                                            })
                                          }),
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ])
                                }),
                                0
                              )
                            : _c("tbody", [_vm._m(4)])
                        ]
                      )
                    ])
              ])
            ])
          ]
        )
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
      {
        staticClass: "btn btn-md btn-primary m-0",
        attrs: { "data-toggle": "dropdown", type: "button" }
      },
      [
        _vm._v("\n                                        ปุ่มคำสั่ง "),
        _c("i", { staticClass: "fa fa-caret-down" })
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("เลือก")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("รายการที่")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("รหัสผลิตภัณฑ์")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("ชื่อผลิตภัณฑ์")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "2" } }, [_vm._v("จำนวนที่ซื้อ")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "3" } }, [_vm._v("จำนวนที่ขอคืน")])
      ]),
      _vm._v(" "),
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { staticClass: "w-80" }, [_vm._v("หีบ")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80" }, [_vm._v("ห่อ")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80" }, [_vm._v("หีบ")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80" }, [_vm._v("ห่อ")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80" }, [_vm._v("ซอง")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "td",
        { staticStyle: { "text-align": "center" }, attrs: { colspan: "9" } },
        [_vm._v("ไม่พบข้อมูล")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("เลือก")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("รายการที่")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("รหัสผลิตภัณฑ์")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("ชื่อผลิตภัณฑ์")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "2" } }, [_vm._v("จำนวนที่ซื้อ")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "3" } }, [_vm._v("จำนวนที่ขอคืน")])
      ]),
      _vm._v(" "),
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { staticClass: "w-80" }, [_vm._v("จำนวน")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80" }, [_vm._v("หน่วยนับ")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80" }, [_vm._v("จำนวน")]),
        _vm._v(" "),
        _c("th", { staticClass: "w-80", staticStyle: { width: "180px" } }, [
          _vm._v("หน่วยนับ")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "td",
        { staticStyle: { "text-align": "center" }, attrs: { colspan: "9" } },
        [_vm._v("ไม่พบข้อมูล")]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/InputGroupRepetition.vue?vue&type=template&id=414ff45e& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row form-group" }, [
      _c(
        "div",
        { staticClass: "col-md-12" },
        [
          _c("qm-el-checkbox", {
            attrs: {
              value: _vm.repeatFlag,
              label: "สร้างซ้ำ",
              name: "repeat_flag",
              size: "small"
            },
            on: { change: _vm.onFlagChanged }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _vm.repeatFlag
      ? _c("div", { staticClass: "row form-group" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.repeatTimeHour,
                  expression: "repeatTimeHour"
                }
              ],
              staticClass: "form-control text-center",
              attrs: {
                type: "number",
                name: "repeat_time_hour",
                min: 0,
                max: 12
              },
              domProps: { value: _vm.repeatTimeHour },
              on: {
                blur: _vm.onRepeatTimeHourChanged,
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.repeatTimeHour = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.repeatTimeMin,
                  expression: "repeatTimeMin"
                }
              ],
              staticClass: "form-control text-center",
              attrs: {
                type: "number",
                name: "repeat_time_min",
                min: 0,
                max: 59
              },
              domProps: { value: _vm.repeatTimeMin },
              on: {
                blur: _vm.onRepeatTimeMinChanged,
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.repeatTimeMin = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _vm._m(2)
        ])
      : _vm._e(),
    _vm._v(" "),
    _vm.repeatFlag
      ? _c("div", { staticClass: "row form-group" }, [
          _c(
            "div",
            { staticClass: "col-md-6" },
            [
              _c("label", { staticClass: "required" }, [
                _vm._v(" จำนวนเลขที่ตัวอย่าง ")
              ]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.repeatQty,
                    expression: "repeatQty"
                  }
                ],
                attrs: { type: "hidden", name: "repeat_qty" },
                domProps: { value: _vm.repeatQty },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.repeatQty = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input-number", {
                staticClass: "w-100",
                attrs: { min: 1, max: 10 },
                model: {
                  value: _vm.repeatQty,
                  callback: function($$v) {
                    _vm.repeatQty = $$v
                  },
                  expression: "repeatQty"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _vm._m(3)
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12" }, [
      _c("label", { staticClass: "required" }, [_vm._v(" รอบเวลาที่สร้าง ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2" }, [
      _c(
        "p",
        { staticClass: "form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0" },
        [_vm._v("\n                ชั่วโมง\n            ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2" }, [
      _c(
        "p",
        { staticClass: "form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0" },
        [_vm._v("\n                นาที\n            ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-4" }, [
      _c("label", { staticClass: "md:tw-block tw-hidden" }, [_vm._v(" ")]),
      _vm._v(" "),
      _c(
        "p",
        { staticClass: "form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0" },
        [_vm._v("\n                ชุด\n            ")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);