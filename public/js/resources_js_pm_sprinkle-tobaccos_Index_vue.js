(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_sprinkle-tobaccos_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _commonDialogs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../commonDialogs */ "./resources/js/commonDialogs.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ModalSearch.vue */ "./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue");


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

 // import searchItem from './SearchItem';


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    modalSearch: _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ["url"],
  computed: {
    secondaryUomList: function secondaryUomList() {// let vm = this;
      // if (vm.header.inventory_item_id) {
      //     let item = vm.data.item_list.filter(o => o.inventory_item_id == vm.header.inventory_item_id);
      //     if (item.length) {
      //         if (!vm.header.attribute1) {
      //             vm.header.attribute1 = item[0].primary_uom_code;
      //         }
      //         return item[0].secondary_uom_list;
      //     }
      // }
      // return [];
    }
  },
  watch: {
    'header.transaction_date_format': function headerTransaction_date_format(val) {
      if (this.header.sprinkle_header_id) {
        return;
      } // console.log('transaction_date_format', val)


      if (val == '' || val == 'Invalid date') {
        this.header.blend_no = '';
        this.header.opt = '';
      }

      this.getBlendDetail();
    },
    'header.blend_no': function headerBlend_no(val) {
      if (this.header.sprinkle_header_id) {
        return;
      }

      this.header.opt = '';
      this.header.batch_id = '';
      this.header.product_item_id = '';
      this.header.receipt_uom_code = '';
      this.header.receipt_quantity = '';
      this.header.to_locator_code = '';
      this.header.to_locator_id = '';
      this.header.to_organization_id = '';
      this.header.to_subinventory = '';
      this.header.transfer_status = '';

      if (val) {
        var _this$itemList$val$tr;

        this.header.batch_id = this.itemList[val]['batch_id'];
        this.header.product_item_id = this.itemList[val]['product_item_id'];
        this.header.receipt_uom_code = this.itemList[val]['uom_code'];
        this.header.to_locator_code = this.itemList[val]['to_locator_code'];
        this.header.to_locator_id = this.itemList[val]['to_locator_id'];
        this.header.to_organization_id = this.itemList[val]['to_organization_id'];
        this.header.to_subinventory = this.itemList[val]['to_subinventory'];
        this.header.transfer_status = (_this$itemList$val$tr = this.itemList[val]['transfer_status']) !== null && _this$itemList$val$tr !== void 0 ? _this$itemList$val$tr : 1;
      }
    }
  },
  data: function data() {
    return {
      data: false,
      header: false,
      profile: false,
      searchTransactionDateFormat: '',
      transBtn: {},
      transDate: {},
      lines: [],
      blendNoList: [],
      itemList: {},
      onhandList: [],
      checkedAll: false,
      loading: {
        page: false,
        before_mount: false,
        blend_no: false
      },
      firstLoad: true,
      countOpen: 0,
      validateFrom: {
        blend_no: {
          is_valid: true,
          message: ''
        },
        opt: {
          is_valid: true,
          message: ''
        },
        receipt_quantity: {
          is_valid: true,
          message: ''
        },
        receipt_uom_code: {
          is_valid: true,
          message: ''
        },
        sprinkle_no: {
          is_valid: true,
          message: ''
        },
        to_organization_id: {
          is_valid: true,
          message: ''
        },
        to_subinventory: {
          is_valid: true,
          message: ''
        },
        to_locator_id: {
          is_valid: true,
          message: ''
        },
        to_locator_code: {
          is_valid: true,
          message: ''
        },
        transaction_date_format: {
          is_valid: true,
          message: ''
        }
      }
    };
  },
  beforeMount: function beforeMount() {
    // console.log('beforeMount');
    this.getInfo();
  },
  mounted: function mounted() {// console.log('wip-requests: Component mounted.');
  },
  methods: {
    show: function show(header) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log('show header', header);

                _this.getInfo(header.sprinkle_header_id);

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    changeReceiptquantity: function changeReceiptquantity() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                _context2.next = 3;
                return vm.assingLot();

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    assingLot: function assingLot() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm, receiptQty;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this3;
                receiptQty = parseInt(vm.header.receipt_quantity ? vm.header.receipt_quantity : 0);
                vm.onhandList.forEach( /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(o) {
                    var remainQty;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
                      while (1) {
                        switch (_context4.prev = _context4.next) {
                          case 0:
                            if (parseInt(o.total_onhand_quantity) > receiptQty) {
                              o.can_misc_receipt = true;
                              remainQty = receiptQty;
                              o.lot_list.forEach( /*#__PURE__*/function () {
                                var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(lot) {
                                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
                                    while (1) {
                                      switch (_context3.prev = _context3.next) {
                                        case 0:
                                          if (remainQty > 0) {
                                            if (remainQty > parseInt(lot.onhand_quantity) || parseInt(lot.onhand_quantity) == remainQty) {
                                              lot.issue_quantity = parseInt(lot.onhand_quantity);
                                              remainQty = remainQty - lot.issue_quantity;
                                            } else if (remainQty < parseInt(lot.onhand_quantity)) {
                                              lot.issue_quantity = remainQty;
                                              remainQty = 0;
                                            }
                                          } else {
                                            lot.issue_quantity = '';
                                          }

                                        case 1:
                                        case "end":
                                          return _context3.stop();
                                      }
                                    }
                                  }, _callee3);
                                }));

                                return function (_x2) {
                                  return _ref2.apply(this, arguments);
                                };
                              }());
                            } else {
                              o.can_misc_receipt = false;
                            }

                          case 1:
                          case "end":
                            return _context4.stop();
                        }
                      }
                    }, _callee4);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    selectedItem: function selectedItem(item) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm, isSelected;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this4;
                isSelected = item.is_selected;
                vm.onhandList.forEach( /*#__PURE__*/function () {
                  var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6(o) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
                      while (1) {
                        switch (_context6.prev = _context6.next) {
                          case 0:
                            if (isSelected) {
                              if (item.inventory_item_id == o.inventory_item_id) {
                                o.is_disable = false;
                                o.is_selected = true;
                              } else {
                                o.is_disable = true;
                                o.is_selected = false;
                              }
                            } else {
                              o.is_disable = false;
                              o.is_selected = false;
                            }

                          case 1:
                          case "end":
                            return _context6.stop();
                        }
                      }
                    }, _callee6);
                  }));

                  return function (_x3) {
                    return _ref3.apply(this, arguments);
                  };
                }());

              case 3:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    getBlendDetail: function getBlendDetail() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var vm, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                vm = _this5;
                response = false; // let param = ;

                vm.loading.blend_no = true;
                vm.blendNoList = [];
                vm.itemList = {};
                _context8.next = 7;
                return axios.get(vm.url.index, {
                  params: {
                    action: 'get-blend-detail',
                    transaction_date_format: vm.header.transaction_date_format
                  }
                }).then(function (res) {
                  response = res.data.data;
                  vm.blendNoList = response.data.blend_no_list;
                  vm.itemList = response.data.item_list;
                  vm.loading.blend_no = false;
                });

              case 7:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    getInfo: function getInfo() {
      var _arguments = arguments,
          _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var sprinkleHeaderId, vm, params, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                sprinkleHeaderId = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : '';
                vm = _this6;
                params = {
                  sprinkle_header_id: sprinkleHeaderId
                };
                response = false;
                vm.loading.page = true;
                vm.loading.before_mount = true;
                vm.lines = [];
                vm.onhandList = [];
                _context9.next = 10;
                return axios.get(vm.url.index, {
                  params: params
                }).then(function (res) {
                  response = res.data.data;

                  if (response.status == 'S') {
                    response = response.info;
                  }

                  vm.loading.page = false;
                });

              case 10:
                if (response) {
                  vm.data = response.data;
                  vm.header = response.header;
                  vm.profile = response.profile;
                  vm.transBtn = response.transBtn;
                  vm.transDate = response.transDate;
                }

                vm.loading.before_mount = false; // console.log('info success');
                // vm.getLines(false, 'show');

                if (vm.header.sprinkle_header_id) {
                  vm.onhandList = _.sortBy(vm.header.lines, function (o) {
                    return o.blend_no;
                  });
                }

              case 13:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    setdate: function setdate(date, key) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                vm = _this7;
                _context10.next = 3;
                return moment__WEBPACK_IMPORTED_MODULE_2___default()(date).format(vm.transDate['js-format']);

              case 3:
                vm.header[key] = _context10.sent;

              case 4:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    cancel: function cancel() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var vm, confirm, lines;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                vm = _this8;

                if (!(vm.onhandList.length == 0)) {
                  _context12.next = 5;
                  break;
                }

                _context12.next = 4;
                return helperAlert.showGenericFailureDialog('ไม่พบปริมาณคงคลัง');

              case 4:
                return _context12.abrupt("return");

              case 5:
                _context12.next = 7;
                return helperAlert.showProgressConfirm('กรุณายืนยัน ยกเลิกการโรยยาเส้น');

              case 7:
                confirm = _context12.sent;

                if (!confirm) {
                  _context12.next = 13;
                  break;
                }

                vm.loading.page = true;
                lines = vm.lines;
                _context12.next = 13;
                return axios.post(vm.url.ajax_cancel, {
                  header: vm.header
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
                        while (1) {
                          switch (_context11.prev = _context11.next) {
                            case 0:
                              _context11.next = 2;
                              return vm.getInfo(data.header.sprinkle_header_id);

                            case 2:
                            case "end":
                              return _context11.stop();
                          }
                        }
                      }, _callee11);
                    })), 500);
                  }

                  if (data.status != 'S') {
                    swal({
                      title: "Error !",
                      text: data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.page = false;
                });

              case 13:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    save: function save() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
        var vm, vaild, receiptQty, totalIssue, selectOnhand, confirm, lines;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                vm = _this9;

                if (!(vm.onhandList.length == 0)) {
                  _context16.next = 5;
                  break;
                }

                _context16.next = 4;
                return helperAlert.showGenericFailureDialog('ไม่พบปริมาณคงคลัง');

              case 4:
                return _context16.abrupt("return");

              case 5:
                if (!(vm.searchTransactionDateFormat != vm.header.transaction_date_format)) {
                  _context16.next = 9;
                  break;
                }

                _context16.next = 8;
                return helperAlert.showGenericFailureDialog('ข้อมูลการค้นหาไม่ตรงกัน\nกรุณากดแสดผลไหม่');

              case 8:
                return _context16.abrupt("return");

              case 9:
                _context16.next = 11;
                return _this9.validateHeader(true);

              case 11:
                vaild = _context16.sent;

                if (vaild) {
                  _context16.next = 14;
                  break;
                }

                return _context16.abrupt("return");

              case 14:
                receiptQty = parseInt(vm.header.receipt_quantity ? vm.header.receipt_quantity : 0);
                totalIssue = 0;
                selectOnhand = [];
                vm.onhandList.forEach( /*#__PURE__*/function () {
                  var _ref5 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14(o) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
                      while (1) {
                        switch (_context14.prev = _context14.next) {
                          case 0:
                            if (o.is_selected && !o.is_disable && o.can_misc_receipt) {
                              selectOnhand = o;
                              o.lot_list.forEach( /*#__PURE__*/function () {
                                var _ref6 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13(lot) {
                                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
                                    while (1) {
                                      switch (_context13.prev = _context13.next) {
                                        case 0:
                                          totalIssue = parseInt(totalIssue) + parseInt(lot.issue_quantity ? lot.issue_quantity : 0);

                                        case 1:
                                        case "end":
                                          return _context13.stop();
                                      }
                                    }
                                  }, _callee13);
                                }));

                                return function (_x5) {
                                  return _ref6.apply(this, arguments);
                                };
                              }());
                            }

                          case 1:
                          case "end":
                            return _context14.stop();
                        }
                      }
                    }, _callee14);
                  }));

                  return function (_x4) {
                    return _ref5.apply(this, arguments);
                  };
                }());

                if (!(receiptQty != totalIssue || receiptQty == 0)) {
                  _context16.next = 22;
                  break;
                }

                _context16.next = 21;
                return helperAlert.showGenericFailureDialog('จำนวนที่ต้องการและปริมาณที่นำไปโรยไม่ตรงกัน');

              case 21:
                return _context16.abrupt("return");

              case 22:
                _context16.next = 24;
                return helperAlert.showProgressConfirm('กรุณายืนยัน บันทึกใช้ยาเส้น ZoneC48');

              case 24:
                confirm = _context16.sent;

                if (!confirm) {
                  _context16.next = 30;
                  break;
                }

                vm.loading.page = true;
                lines = vm.lines;
                _context16.next = 30;
                return axios.post(vm.url.ajax_store, {
                  header: vm.header,
                  select_onhand: selectOnhand
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
                        while (1) {
                          switch (_context15.prev = _context15.next) {
                            case 0:
                              _context15.next = 2;
                              return vm.getInfo(data.header.sprinkle_header_id);

                            case 2:
                            case "end":
                              return _context15.stop();
                          }
                        }
                      }, _callee15);
                    })), 500);
                  }

                  if (data.status != 'S') {
                    swal({
                      title: "Error !",
                      text: data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.page = false; // swal.close();
                });

              case 30:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16);
      }))();
    },
    setData: function setData() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee17() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                vm = _this10;

                if (vm.header.transfer_header_id != undefined && vm.header.transfer_header_id != '') {
                  vm.getLines(false, 'show');
                }

                vm.firstLoad = false;

              case 3:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17);
      }))();
    },
    indexPage: function indexPage() {
      // this.loading.page = true;
      // location.href = this.url.index;
      this.getInfo();
    },
    getLines: function getLines() {
      var _arguments2 = arguments,
          _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee18() {
        var isShowNoti, action, vm, confirm, vaild;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee18$(_context18) {
          while (1) {
            switch (_context18.prev = _context18.next) {
              case 0:
                isShowNoti = _arguments2.length > 0 && _arguments2[0] !== undefined ? _arguments2[0] : true;
                action = _arguments2.length > 1 && _arguments2[1] !== undefined ? _arguments2[1] : 'search';
                vm = _this11;
                confirm = true; // if (isShowNoti) {
                //     confirm = await helperAlert.showProgressConfirm('ค้นหารายการใช้ยาเส้น ZoneC48');
                // }

                if (!isShowNoti) {
                  _context18.next = 10;
                  break;
                }

                _context18.next = 7;
                return _this11.validateHeader(isShowNoti);

              case 7:
                vaild = _context18.sent;

                if (vaild) {
                  _context18.next = 10;
                  break;
                }

                return _context18.abrupt("return");

              case 10:
                if (!confirm) {
                  _context18.next = 17;
                  break;
                }

                vm.loading.page = true;
                vm.searchTransactionDateFormat = vm.header.transaction_date_format;
                vm.lines = [];
                vm.onhandList = {};
                _context18.next = 17;
                return axios.get(vm.url.ajax_get_lines, {
                  params: {
                    header: vm.header,
                    action: action
                  }
                }).then(function (res) {
                  var data = res.data.data; // console.log('xx', data.lines);
                  // vm.lines = data.lines;

                  vm.onhandList = _.sortBy(data.onhand_list, function (o) {
                    return o.blend_no;
                  });
                  vm.assingLot(); // _.sortBy(this.items, function(o) { return o.item_display_name; })
                  // if (res.data.data.status != 'S') {
                  //     swal({
                  //         title: "Error !",
                  //         text: res.data.data.msg,
                  //         type: "error",
                  //         showConfirmButton: true
                  //     });
                  // }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.page = false;
                });

              case 17:
                return _context18.abrupt("return");

              case 18:
              case "end":
                return _context18.stop();
            }
          }
        }, _callee18);
      }))();
    },
    validateHeader: function validateHeader() {
      var _arguments3 = arguments,
          _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee19() {
        var isShowNoti, vm, vaild, message;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee19$(_context19) {
          while (1) {
            switch (_context19.prev = _context19.next) {
              case 0:
                isShowNoti = _arguments3.length > 0 && _arguments3[0] !== undefined ? _arguments3[0] : true;
                vm = _this12;
                vaild = true;
                message = '';
                _context19.next = 6;
                return vm.resetValidate();

              case 6:
                if (!vm.header.transaction_date_format || vm.header.transaction_date_format == 'Invalid date') {
                  vm.$set(vm.validateFrom, 'transaction_date_format', {
                    is_valid: false,
                    message: 'กรุณากรอกวันที่'
                  });
                  message = message + '\n' + vm.validateFrom.transaction_date_format.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.transaction_date_format.message);

                  vaild = false;
                }

                if (!vm.header.blend_no) {
                  vm.$set(vm.validateFrom, 'blend_no', {
                    is_valid: false,
                    message: 'กรุณากรอก Blend No'
                  });
                  message = message + '\n' + vm.validateFrom.blend_no.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.blend_no.message);

                  vaild = false;
                }

                if (!vm.header.opt) {
                  vm.$set(vm.validateFrom, 'opt', {
                    is_valid: false,
                    message: 'กรุณากรอก OPT'
                  });
                  message = message + '\n' + vm.validateFrom.opt.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.opt.message);

                  vaild = false;
                }

                if (!vm.header.receipt_quantity) {
                  vm.$set(vm.validateFrom, 'receipt_quantity', {
                    is_valid: false,
                    message: 'กรุณากรอก จำนวนที่ต้องการ'
                  });
                  message = message + '\n' + vm.validateFrom.receipt_quantity.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.receipt_quantity.message);

                  vaild = false;
                }

                if (!vm.header.receipt_uom_code) {
                  vm.$set(vm.validateFrom, 'receipt_uom_code', {
                    is_valid: false,
                    message: 'กรุณากรอก หน่วยนับ'
                  });
                  message = message + '\n' + vm.validateFrom.receipt_uom_code.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.receipt_uom_code.message);

                  vaild = false;
                }

                if (!vm.header.sprinkle_no) {
                  vm.$set(vm.validateFrom, 'sprinkle_no', {
                    is_valid: false,
                    message: 'กรุณากรอก เลขที่เอกสาร'
                  });
                  message = message + '\n' + vm.validateFrom.sprinkle_no.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.sprinkle_no.message);

                  vaild = false;
                }

                if (!vm.header.to_subinventory) {
                  vm.$set(vm.validateFrom, 'to_subinventory', {
                    is_valid: false,
                    message: 'กรุณากรอก คลังจัดเก็บ'
                  });
                  message = message + '\n' + vm.validateFrom.to_subinventory.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.to_subinventory.message);

                  vaild = false;
                }

                if (!vm.header.to_locator_id) {
                  vm.$set(vm.validateFrom, 'to_locator_code', {
                    is_valid: false,
                    message: 'กรุณากรอก สถานที่จัดเก็บ'
                  });
                  message = message + '\n' + vm.validateFrom.to_locator_code.message; // await helperAlert.showGenericFailureDialog(vm.validateFrom.to_locator_code.message);

                  vaild = false;
                }

                if (vaild) {
                  _context19.next = 17;
                  break;
                }

                _context19.next = 17;
                return helperAlert.showGenericFailureDialog(message);

              case 17:
                return _context19.abrupt("return", vaild);

              case 18:
              case "end":
                return _context19.stop();
            }
          }
        }, _callee19);
      }))();
    },
    resetValidate: function resetValidate() {
      var _arguments4 = arguments,
          _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee20() {
        var inputName, vm, value;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee20$(_context20) {
          while (1) {
            switch (_context20.prev = _context20.next) {
              case 0:
                inputName = _arguments4.length > 0 && _arguments4[0] !== undefined ? _arguments4[0] : false;
                vm = _this13;
                value = {
                  is_valid: true,
                  message: ''
                };

                if (inputName != '') {
                  vm.validateFrom[inputName] = value;
                } else {
                  vm.validateFrom.transaction_date_format = value;
                  vm.validateFrom.blend_no = value;
                  vm.validateFrom.opt = value;
                  vm.validateFrom.receipt_quantity = value;
                  vm.validateFrom.receipt_uom_code = value;
                  vm.validateFrom.sprinkle_no = value;
                  vm.validateFrom.to_subinventory = value;
                  vm.validateFrom.to_locator_code = value;
                }

                return _context20.abrupt("return");

              case 5:
              case "end":
                return _context20.stop();
            }
          }
        }, _callee20);
      }))();
    },
    setStatus: function setStatus(status) {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee22() {
        var vm, confirm, msg, url;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee22$(_context22) {
          while (1) {
            switch (_context22.prev = _context22.next) {
              case 0:
                vm = _this14;
                confirm = false;
                msg = '';

                if (status == 'confirmTransfer') {
                  msg = 'กรุณายืนยันการโรยยาเส้น';
                }

                _context22.next = 6;
                return helperAlert.showProgressConfirm(msg);

              case 6:
                confirm = _context22.sent;

                if (!confirm) {
                  _context22.next = 13;
                  break;
                }

                vm.loading.page = true;
                url = vm.url.ajax_set_status;

                if (vm.header.sprinkle_header_id != '' && vm.header.sprinkle_header_id != undefined) {
                  url = url.replace("-999", vm.header.sprinkle_header_id);
                }

                _context22.next = 13;
                return axios.post(url, {
                  sprinkle_header_id: vm.header.sprinkle_header_id
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee21() {
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee21$(_context21) {
                        while (1) {
                          switch (_context21.prev = _context21.next) {
                            case 0:
                              _context21.next = 2;
                              return vm.getInfo(data.header.sprinkle_header_id);

                            case 2:
                            case "end":
                              return _context21.stop();
                          }
                        }
                      }, _callee21);
                    })), 500);
                  }

                  if (res.data.data.status != 'S') {
                    swal({
                      title: "Error !",
                      text: res.data.data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.page = false;
                });

              case 13:
              case "end":
                return _context22.stop();
            }
          }
        }, _callee22);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=script&lang=js& ***!
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['header', "transBtn", "transDate", "url", "countOpen"],
  data: function data() {
    return {
      loading: false,
      getParamlLoading: false,
      // reqHeaderHeaderId: '',
      transactionDateFormat: '',
      sprinkleNo: '',
      sprinkleHeaderId: '',
      requestHeaders: [],
      transDateFormat: {
        from_date: '',
        to_date: ''
      },
      inputParams: {
        sprinkle_header_id_list: []
      }
    };
  },
  mounted: function mounted() {// if (this.budget_year) {
    //     this.getBiWeekly();
    // }
    // this.openModal();
  },
  computed: {},
  watch: {
    countOpen: function () {
      var _countOpen = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.openModal();

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function countOpen(_x, _x2) {
        return _countOpen.apply(this, arguments);
      }

      return countOpen;
    }(),
    "transDateFormat.from_date": function transDateFormatFrom_date(newValue) {
      this.getParam();
    },
    "transDateFormat.to_date": function transDateFormatTo_date(newValue) {
      this.getParam();
    }
  },
  methods: {
    setdate: function setdate(date) {
      var _arguments = arguments,
          _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var input, vm, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                input = _arguments.length > 1 && _arguments[1] !== undefined ? _arguments[1] : '';
                vm = _this;

                if (!(input == '')) {
                  _context2.next = 8;
                  break;
                }

                _context2.next = 5;
                return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format(vm.transDate['js-format']);

              case 5:
                vm.transactionDateFormat = _context2.sent;
                _context2.next = 13;
                break;

              case 8:
                _context2.next = 10;
                return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format(vm.transDate['js-format']);

              case 10:
                data = _context2.sent;

                if (data == 'Invalid date') {
                  data = '';
                }

                vm.transDateFormat[input] = data;

              case 13:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    openModal: function openModal() {
      $('#modal_search').modal('show');
      this.getParam();
    },
    remoteMethod: function remoteMethod(query) {
      if (query !== "") {
        this.search({
          wip_request_no: query,
          transaction_date: this.transactionDateFormat,
          action: 'search'
        });
      } else {
        this.requestHeaders = [];
      }
    },
    search: function search(params) {
      var vm = this;
      vm.loading = true;
      axios.get(vm.url.index, {
        params: params
      }).then(function (res) {
        var response = res.data.data;
        vm.loading = false;
        vm.requestHeaders = response.data;
      });
    },
    selectWipRequestHeader: function selectWipRequestHeader(reqHeader) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                $('#modal_search').modal('hide');
                _this2.requestHeaders = [];

                _this2.$emit("selectWipRequestHeader", reqHeader);

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    submitForm: function submitForm() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this3.search({
                  sprinkle_header_id: _this3.sprinkleHeaderId,
                  // transaction_date: this.transactionDateFormat,
                  from_transaction_date: _this3.transDateFormat.from_date,
                  to_transaction_date: _this3.transDateFormat.to_date,
                  action: 'search'
                });

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getParam: function getParam() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this4;
                vm.getParamlLoading = true;
                params = {
                  action: 'search_get_param',
                  from_transaction_date: vm.transDateFormat.from_date,
                  to_transaction_date: vm.transDateFormat.to_date
                };
                axios.get(vm.url.index, {
                  params: params
                }).then(function (res) {
                  var response = res.data.data;
                  vm.getParamlLoading = false;
                  vm.inputParams.sprinkle_header_id_list = response.data.sprinkle_header_id_list;
                });

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/commonDialogs.js":
/*!***************************************!*\
  !*** ./resources/js/commonDialogs.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showSimpleConfirmationDialog": () => /* binding */ showSimpleConfirmationDialog,
/* harmony export */   "showProgressWithUnsavedChangesWarningDialog": () => /* binding */ showProgressWithUnsavedChangesWarningDialog,
/* harmony export */   "showValidationFailedDialog": () => /* binding */ showValidationFailedDialog,
/* harmony export */   "showLoadingDialog": () => /* binding */ showLoadingDialog,
/* harmony export */   "showSaveSuccessDialog": () => /* binding */ showSaveSuccessDialog,
/* harmony export */   "showSaveFailureDialog": () => /* binding */ showSaveFailureDialog,
/* harmony export */   "showGenericFailureDialog": () => /* binding */ showGenericFailureDialog,
/* harmony export */   "showRemoveLineConfirmationDialog": () => /* binding */ showRemoveLineConfirmationDialog
/* harmony export */ });
function showSimpleConfirmationDialog(title) {
  return new Promise(function (resolve) {
    swal({
      title: title,
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ยืนยัน'
    }, function (value) {
      resolve(value);
    });
  });
}
function showProgressWithUnsavedChangesWarningDialog() {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E04\u0E38\u0E13\u0E41\u0E19\u0E48\u0E43\u0E08\u0E44\u0E2B\u0E21?",
      // new line is a workaround for icon cover text
      text: 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก คุณต้องการดำเนินการต่อหรือไม่',
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ดำเนินการต่อ',
      allowClickOutside: true,
      closeOnClickOutside: true
    }, function (value) {
      resolve(value);
    });
  });
}
function showValidationFailedDialog(errorMessages) {
  var errorText = '<div style="text-align:left;">' + 'ข้อมูลที่คุณใส่ไม่ถูกต้องหรือไม่ครบถ้วน กรุณาตรวจสอบข้อมูลและลองใหม่อีกครั้ง<br/><br/>' + '</div>';
  errorText += '<div style="text-align:left;color:red">';
  errorText += '<ul>';
  errorMessages.forEach(function (message) {
    errorText += "<li>".concat(message, "<br/></li>");
  });
  errorText += '</ul>';
  errorText += '</div>';
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      html: true,
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ตกลง'
    }, function (value) {
      resolve(value);
    });
  });
}
function showLoadingDialog() {
  console.debug('showLoadingDialog');
  return new Promise(function (resolve) {
    swal({
      // new line is a workaround for icon cover text
      title: "\n                    <div class=\"sk-spinner sk-spinner-wave mb-4\">\n                        <div class=\"sk-rect1\"></div>\n                        <div class=\"sk-rect2\"></div>\n                        <div class=\"sk-rect3\"></div>\n                        <div class=\"sk-rect4\"></div>\n                        <div class=\"sk-rect5\"></div>\n                    </div>\n                    \u0E01\u0E33\u0E25\u0E31\u0E07\u0E14\u0E33\u0E40\u0E19\u0E34\u0E19\u0E01\u0E32\u0E23\n                    ",
      html: true,
      showConfirmButton: false,
      closeOnConfirm: false
    }, function (value) {
      resolve(value);
    });
  });
}
function showSaveSuccessDialog() {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08",
      // new line is a workaround for icon cover text
      text: 'บันทึกข้อมูลเรียบร้อย',
      type: 'success',
      dangerMode: false,
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showSaveFailureDialog() {
  var errorText = "\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14\u0E40\u0E01\u0E34\u0E14\u0E02\u0E36\u0E49\u0E19 \u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E14\u0E49 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E25\u0E2D\u0E07\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07\n";
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showGenericFailureDialog() {
  var errorText = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14\u0E40\u0E01\u0E34\u0E14\u0E02\u0E36\u0E49\u0E19 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E25\u0E2D\u0E07\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07\n";
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showRemoveLineConfirmationDialog(rowCount) {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E04\u0E38\u0E13\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E17\u0E35\u0E48\u0E16\u0E39\u0E01\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14 ".concat(rowCount, " \u0E41\u0E16\u0E27\u0E43\u0E0A\u0E48\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48?"),
      // new line is a workaround for icon cover text
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ยืนยัน'
    }, function (value) {
      resolve(value);
    });
  });
}

/***/ }),

/***/ "./resources/js/pm/sprinkle-tobaccos/Index.vue":
/*!*****************************************************!*\
  !*** ./resources/js/pm/sprinkle-tobaccos/Index.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_706d8920___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=706d8920& */ "./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=template&id=706d8920&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_706d8920___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_706d8920___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/sprinkle-tobaccos/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue":
/*!***********************************************************!*\
  !*** ./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_2822e353___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=2822e353& */ "./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=template&id=2822e353&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_2822e353___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_2822e353___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/sprinkle-tobaccos/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=template&id=706d8920&":
/*!************************************************************************************!*\
  !*** ./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=template&id=706d8920& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_706d8920___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_706d8920___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_706d8920___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=706d8920& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=template&id=706d8920&");


/***/ }),

/***/ "./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=template&id=2822e353&":
/*!******************************************************************************************!*\
  !*** ./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=template&id=2822e353& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_2822e353___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_2822e353___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_2822e353___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=2822e353& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=template&id=2822e353&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=template&id=706d8920&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/Index.vue?vue&type=template&id=706d8920& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    _c(
      "div",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loading.page,
            expression: "loading.page"
          }
        ],
        staticClass: "ibox float-e-margins"
      },
      [
        !_vm.loading.before_mount
          ? _c(
              "div",
              {
                staticClass: "ibox-content",
                staticStyle: { "border-bottom": "0px" }
              },
              [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-12 text-right" }, [
                    _c(
                      "button",
                      {
                        class: _vm.transBtn.search.class + " btn-lg tw-w-25 ",
                        on: {
                          click: function($event) {
                            _vm.countOpen += 1
                          }
                        }
                      },
                      [
                        _c("i", { class: _vm.transBtn.search.icon }),
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.transBtn.search.text) +
                            " เลขที่เอกสาร\n                    "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        class:
                          _vm.transBtn.create.class + " btn-lg tw-w-25 mr-2",
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.getInfo()
                          }
                        }
                      },
                      [
                        _c("i", { class: _vm.transBtn.create.icon }),
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.transBtn.create.text) +
                            "\n                    "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        class: _vm.transBtn.save.class + " btn-lg tw-w-25",
                        attrs: { disabled: !_vm.header.can.save },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.save($event)
                          }
                        }
                      },
                      [
                        _c("i", { class: _vm.transBtn.save.icon }),
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm.transBtn.save.text) +
                            "\n                    "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary btn-lg",
                        attrs: { disabled: !_vm.header.can.transfer },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.setStatus("confirmTransfer")
                          }
                        }
                      },
                      [_c("strong", [_vm._v("ยืนยันการโรยยาเส้น")])]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-w-m btn-danger btn-lg",
                        attrs: { disabled: !_vm.header.can.cancel_transfer },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.cancel()
                          }
                        }
                      },
                      [
                        _c("i", { staticClass: "fa fa-times" }),
                        _vm._v(" ยกเลิกการโรยยาเส้น\n                    ")
                      ]
                    )
                  ])
                ])
              ]
            )
          : _vm._e(),
        _vm._v(" "),
        !_vm.loading.before_mount
          ? _c(
              "div",
              { staticClass: "ibox-content" },
              [
                _c("modal-search", {
                  attrs: {
                    transDate: _vm.transDate,
                    transBtn: _vm.transBtn,
                    url: _vm.url,
                    countOpen: _vm.countOpen
                  },
                  on: { selectWipRequestHeader: _vm.show }
                }),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-lg-6 b-r" }, [
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("วันที่: ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-lg-7" },
                        [
                          _c("datepicker-th", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            staticStyle: { width: "100%" },
                            attrs: {
                              name: "input_date",
                              id: "input_date",
                              "not-before-date":
                                _vm.data.preiod_min_max.min_date_th,
                              "not-after-date":
                                _vm.data.preiod_min_max.max_date_th,
                              disabled: _vm.header.sprinkle_header_id != "",
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.header.transaction_date_format,
                              format: _vm.transDate["js-format"]
                            },
                            on: {
                              dateWasSelected: function($event) {
                                var i = arguments.length,
                                  argsArray = Array(i)
                                while (i--) argsArray[i] = arguments[i]
                                return _vm.setdate.apply(
                                  void 0,
                                  argsArray.concat(["transaction_date_format"])
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          !_vm.validateFrom.transaction_date_format.is_valid
                            ? _c("div", [
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "form-text m-b-none text-danger"
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm.validateFrom
                                            .transaction_date_format.message
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ])
                            : _vm._e()
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("Blend no.: ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-lg-3" },
                        [
                          _vm.header.sprinkle_header_id
                            ? _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.header.blend_no,
                                    expression: "header.blend_no"
                                  }
                                ],
                                staticClass: "form-control",
                                staticStyle: { height: "40px" },
                                attrs: { type: "text", disabled: "" },
                                domProps: { value: _vm.header.blend_no },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.header,
                                      "blend_no",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            : _c(
                                "el-select",
                                {
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    filterable: "",
                                    clearable: "",
                                    placeholder: ""
                                  },
                                  model: {
                                    value: _vm.header.blend_no,
                                    callback: function($$v) {
                                      _vm.$set(_vm.header, "blend_no", $$v)
                                    },
                                    expression: "header.blend_no"
                                  }
                                },
                                _vm._l(_vm.blendNoList, function(item, idx) {
                                  return _vm.header.transaction_date_format
                                    ? _c("el-option", {
                                        key: idx,
                                        attrs: { label: idx, value: idx }
                                      })
                                    : _vm._e()
                                }),
                                1
                              ),
                          _vm._v(" "),
                          !_vm.validateFrom.blend_no.is_valid
                            ? _c("div", [
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "form-text m-b-none text-danger"
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm.validateFrom.blend_no.message
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ])
                            : _vm._e()
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-1 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("OPT: ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-lg-3" },
                        [
                          _vm.header.sprinkle_header_id
                            ? _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.header.opt,
                                    expression: "header.opt"
                                  }
                                ],
                                staticClass: "form-control",
                                staticStyle: { height: "40px" },
                                attrs: { type: "text", disabled: "" },
                                domProps: { value: _vm.header.opt },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.header,
                                      "opt",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            : _c(
                                "el-select",
                                {
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    filterable: "",
                                    clearable: "",
                                    placeholder: ""
                                  },
                                  model: {
                                    value: _vm.header.opt,
                                    callback: function($$v) {
                                      _vm.$set(_vm.header, "opt", $$v)
                                    },
                                    expression: "header.opt"
                                  }
                                },
                                _vm._l(
                                  _vm.blendNoList[_vm.header.blend_no],
                                  function(item, idx) {
                                    return _vm.header.transaction_date_format
                                      ? _c("el-option", {
                                          key: item.opt,
                                          attrs: {
                                            label: item.opt,
                                            value: item.opt
                                          }
                                        })
                                      : _vm._e()
                                  }
                                ),
                                1
                              ),
                          _vm._v(" "),
                          !_vm.validateFrom.opt.is_valid
                            ? _c("div", [
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "form-text m-b-none text-danger"
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(_vm.validateFrom.opt.message) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ])
                            : _vm._e()
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("จำนวนที่ต้องการ: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-4" }, [
                        _vm.header.sprinkle_header_id
                          ? _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.header.receipt_quantity,
                                  expression: "header.receipt_quantity"
                                }
                              ],
                              staticClass: "form-control text-right",
                              staticStyle: { height: "40px" },
                              attrs: { type: "text", disabled: "" },
                              domProps: { value: _vm.header.receipt_quantity },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.header,
                                    "receipt_quantity",
                                    $event.target.value
                                  )
                                }
                              }
                            })
                          : _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model.number",
                                  value: _vm.header.receipt_quantity,
                                  expression: "header.receipt_quantity",
                                  modifiers: { number: true }
                                }
                              ],
                              staticClass: "form-control text-right",
                              staticStyle: { height: "40px" },
                              attrs: {
                                type: "number",
                                min: "0",
                                oninput: "validity.valid||(value='');",
                                disabled: false
                              },
                              domProps: { value: _vm.header.receipt_quantity },
                              on: {
                                change: function($event) {
                                  return _vm.changeReceiptquantity()
                                },
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.header,
                                    "receipt_quantity",
                                    _vm._n($event.target.value)
                                  )
                                },
                                blur: function($event) {
                                  return _vm.$forceUpdate()
                                }
                              }
                            }),
                        _vm._v(" "),
                        !_vm.validateFrom.receipt_quantity.is_valid
                          ? _c("div", [
                              _c(
                                "span",
                                {
                                  staticClass: "form-text m-b-none text-danger"
                                },
                                [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        _vm.validateFrom.receipt_quantity
                                          .message
                                      ) +
                                      "\n                                "
                                  )
                                ]
                              )
                            ])
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-lg-3" },
                        [
                          _vm.header.sprinkle_header_id
                            ? _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.header.uom_desc,
                                    expression: "header.uom_desc"
                                  }
                                ],
                                staticClass: "form-control",
                                staticStyle: { height: "40px" },
                                attrs: { type: "text", disabled: "" },
                                domProps: { value: _vm.header.uom_desc },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.header,
                                      "uom_desc",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            : _c(
                                "el-select",
                                {
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    filterable: "",
                                    clearable: "",
                                    placeholder: ""
                                  },
                                  model: {
                                    value: _vm.header.receipt_uom_code,
                                    callback: function($$v) {
                                      _vm.$set(
                                        _vm.header,
                                        "receipt_uom_code",
                                        $$v
                                      )
                                    },
                                    expression: "header.receipt_uom_code"
                                  }
                                },
                                [
                                  _vm.header.blend_no &&
                                  Object.keys(
                                    _vm.itemList[_vm.header.blend_no][
                                      "secondary_uom_list"
                                    ]
                                  ).length
                                    ? _vm._l(
                                        _vm.itemList[_vm.header.blend_no][
                                          "secondary_uom_list"
                                        ],
                                        function(item, idx) {
                                          return _c("el-option", {
                                            key: idx,
                                            attrs: {
                                              label:
                                                item.from_uom.unit_of_measure,
                                              value: idx
                                            }
                                          })
                                        }
                                      )
                                    : _vm._e()
                                ],
                                2
                              ),
                          _vm._v(" "),
                          !_vm.validateFrom.receipt_uom_code.is_valid
                            ? _c("div", [
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "form-text m-b-none text-danger"
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm.validateFrom.receipt_uom_code
                                            .message
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ])
                            : _vm._e()
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("เลขที่เอกสาร: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.header.sprinkle_no,
                              expression: "header.sprinkle_no"
                            }
                          ],
                          staticClass: "form-control",
                          staticStyle: { height: "40px" },
                          attrs: {
                            type: "text",
                            disabled: _vm.header.sprinkle_header_id != ""
                          },
                          domProps: { value: _vm.header.sprinkle_no },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.header,
                                "sprinkle_no",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        !_vm.validateFrom.sprinkle_no.is_valid
                          ? _c("div", [
                              _c(
                                "span",
                                {
                                  staticClass: "form-text m-b-none text-danger"
                                },
                                [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        _vm.validateFrom.sprinkle_no.message
                                      ) +
                                      "\n                                "
                                  )
                                ]
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-3 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("สถานะขอเบิก: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _c("input", {
                          staticClass: "form-control",
                          attrs: { type: "text", readonly: "", disabled: "" },
                          domProps: {
                            value: (function() {
                              if (_vm.header.transfer_status) {
                                var result = _vm.header.request_status_list.find(
                                  function(o) {
                                    return (
                                      o.lookup_code ==
                                      _vm.header.transfer_status
                                    )
                                  }
                                )
                                if (result) {
                                  return result.description
                                }
                              }
                              return null
                            })()
                          }
                        })
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-3 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("รหัสสินค้าสำเร็จรูป: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _vm.header.sprinkle_header_id
                          ? _c("input", {
                              staticClass: "form-control",
                              staticStyle: { height: "40px" },
                              attrs: { type: "text", disabled: "" },
                              domProps: {
                                value:
                                  _vm.header.item_no +
                                  ": " +
                                  _vm.header.item_desc
                              }
                            })
                          : _c("input", {
                              staticClass: "form-control",
                              staticStyle: { height: "40px" },
                              attrs: {
                                type: "text",
                                readonly: "",
                                disabled: ""
                              },
                              domProps: {
                                value: (function() {
                                  if (_vm.header.blend_no) {
                                    var item =
                                      _vm.blendNoList[
                                        parseInt(_vm.header.blend_no)
                                      ][0]
                                    return item.item_no + ": " + item.item_desc
                                  }
                                  return null
                                })()
                              }
                            })
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-3 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("คลังจัดเก็บ: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.header.to_subinventory,
                              expression: "header.to_subinventory"
                            }
                          ],
                          staticClass: "form-control",
                          staticStyle: { height: "40px" },
                          attrs: { type: "text", readonly: "", disabled: "" },
                          domProps: { value: _vm.header.to_subinventory },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.header,
                                "to_subinventory",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        !_vm.validateFrom.to_subinventory.is_valid
                          ? _c("div", [
                              _c(
                                "span",
                                {
                                  staticClass: "form-text m-b-none text-danger"
                                },
                                [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        _vm.validateFrom.to_subinventory.message
                                      ) +
                                      "\n                                "
                                  )
                                ]
                              )
                            ])
                          : _vm._e()
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "col-lg-3 font-weight-bold col-form-label text-right require"
                        },
                        [_vm._v("สถานที่จัดเก็บ: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.header.to_locator_code,
                              expression: "header.to_locator_code"
                            }
                          ],
                          staticClass: "form-control",
                          staticStyle: { height: "40px" },
                          attrs: { type: "text", readonly: "", disabled: "" },
                          domProps: { value: _vm.header.to_locator_code },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.header,
                                "to_locator_code",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        !_vm.validateFrom.to_locator_code.is_valid
                          ? _c("div", [
                              _c(
                                "span",
                                {
                                  staticClass: "form-text m-b-none text-danger"
                                },
                                [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        _vm.validateFrom.to_locator_code.message
                                      ) +
                                      "\n                                "
                                  )
                                ]
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  !_vm.header.sprinkle_header_id
                    ? _c("div", { staticClass: "col-lg-6 offset-6" }, [
                        _c("div", { staticClass: " row" }, [
                          _c("div", { staticClass: "col-lg-11 text-right" }, [
                            _c(
                              "button",
                              {
                                class:
                                  _vm.transBtn.search.class +
                                  " btn-lg tw-w-25 mr-2",
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.getLines(true, "show")
                                  }
                                }
                              },
                              [
                                _c("i", { class: _vm.transBtn.search.icon }),
                                _vm._v(
                                  "\n                                แสดงข้อมูล\n                            "
                                )
                              ]
                            )
                          ])
                        ])
                      ])
                    : _vm._e()
                ])
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        !_vm.loading.before_mount
          ? _c(
              "div",
              {
                staticClass: "ibox-content",
                staticStyle: { "border-top": "0px" }
              },
              [
                _c("div", { staticClass: "table-responsive m-t" }, [
                  _vm.searchTransactionDateFormat ==
                    _vm.header.transaction_date_format ||
                  _vm.header.sprinkle_header_id
                    ? _c(
                        "table",
                        { staticClass: "table text-nowrap  table-bordered" },
                        [
                          _vm._m(0),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            [
                              _vm._l(_vm.onhandList, function(item, i) {
                                return _vm.onhandList.length
                                  ? [
                                      _c("tr", [
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "align-middle text-center",
                                            attrs: { date: i }
                                          },
                                          [
                                            _c("input", {
                                              directives: [
                                                {
                                                  name: "model",
                                                  rawName: "v-model",
                                                  value: item.is_selected,
                                                  expression: "item.is_selected"
                                                }
                                              ],
                                              attrs: {
                                                disabled:
                                                  item.is_disable ||
                                                  !item.can_misc_receipt,
                                                type: "checkbox"
                                              },
                                              domProps: {
                                                checked: Array.isArray(
                                                  item.is_selected
                                                )
                                                  ? _vm._i(
                                                      item.is_selected,
                                                      null
                                                    ) > -1
                                                  : item.is_selected
                                              },
                                              on: {
                                                change: [
                                                  function($event) {
                                                    var $$a = item.is_selected,
                                                      $$el = $event.target,
                                                      $$c = $$el.checked
                                                        ? true
                                                        : false
                                                    if (Array.isArray($$a)) {
                                                      var $$v = null,
                                                        $$i = _vm._i($$a, $$v)
                                                      if ($$el.checked) {
                                                        $$i < 0 &&
                                                          _vm.$set(
                                                            item,
                                                            "is_selected",
                                                            $$a.concat([$$v])
                                                          )
                                                      } else {
                                                        $$i > -1 &&
                                                          _vm.$set(
                                                            item,
                                                            "is_selected",
                                                            $$a
                                                              .slice(0, $$i)
                                                              .concat(
                                                                $$a.slice(
                                                                  $$i + 1
                                                                )
                                                              )
                                                          )
                                                      }
                                                    } else {
                                                      _vm.$set(
                                                        item,
                                                        "is_selected",
                                                        $$c
                                                      )
                                                    }
                                                  },
                                                  function($event) {
                                                    return _vm.selectedItem(
                                                      item
                                                    )
                                                  }
                                                ]
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "align-middle text-left",
                                            attrs: { date: i }
                                          },
                                          [
                                            _c("strong", [
                                              _vm._v(_vm._s(item.blend_no))
                                            ])
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("td", [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(item.item_number) +
                                              "\n                                "
                                          )
                                        ]),
                                        _vm._v(" "),
                                        _c("td", [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(item.item_desc) +
                                              "\n                                "
                                          )
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          { staticClass: "text-right" },
                                          [
                                            _vm._v(
                                              "\n                                    " +
                                                _vm._s(
                                                  item.total_onhand_quantity
                                                ) +
                                                "\n                                "
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass: "text-center",
                                            attrs: {
                                              title: item.issue_uom_code
                                            }
                                          },
                                          [
                                            _vm._v(
                                              "\n                                    " +
                                                _vm._s(
                                                  item.issue_unit_of_measure
                                                ) +
                                                "\n                                "
                                            )
                                          ]
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "transition",
                                        {
                                          attrs: {
                                            "enter-active-class":
                                              "animated fadeIn",
                                            "leave-active-class":
                                              "animated fadeOut"
                                          }
                                        },
                                        [
                                          (item.is_selected &&
                                            item.can_misc_receipt) ||
                                          _vm.header.sprinkle_header_id
                                            ? _c("tr", [
                                                _c(
                                                  "td",
                                                  { attrs: { colspan: "6" } },
                                                  [
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          " mb-0 col-lg-8 col-md-6 col-sm-6 col-xs-6 offset-md-2 mt-2"
                                                      },
                                                      [
                                                        _c(
                                                          "table",
                                                          {
                                                            staticClass:
                                                              "table text-nowrap table-bordered table-hover"
                                                          },
                                                          [
                                                            _c("thead", [
                                                              _c("tr", [
                                                                _c(
                                                                  "th",
                                                                  {
                                                                    attrs: {
                                                                      width:
                                                                        "130px;"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "\n                                                            LOT No.\n                                                        "
                                                                    )
                                                                  ]
                                                                ),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "th",
                                                                  {
                                                                    staticClass:
                                                                      "text-right",
                                                                    attrs: {
                                                                      width:
                                                                        "100px;"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "\n                                                            ปริมาณคงคลัง\n                                                        "
                                                                    )
                                                                  ]
                                                                ),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "th",
                                                                  {
                                                                    staticClass:
                                                                      "text-right",
                                                                    attrs: {
                                                                      width:
                                                                        "100px;"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "\n                                                            ปริมาณที่นำไปโรย\n                                                        "
                                                                    )
                                                                  ]
                                                                ),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "th",
                                                                  {
                                                                    staticClass:
                                                                      "text-center",
                                                                    attrs: {
                                                                      width:
                                                                        "100px;"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "\n                                                            หน่วยนับ\n                                                        "
                                                                    )
                                                                  ]
                                                                )
                                                              ])
                                                            ]),
                                                            _vm._v(" "),
                                                            _c(
                                                              "tbody",
                                                              _vm._l(
                                                                item.lot_list,
                                                                function(
                                                                  lot,
                                                                  i
                                                                ) {
                                                                  return item
                                                                    .lot_list
                                                                    .length
                                                                    ? _c(
                                                                        "tr",
                                                                        {
                                                                          attrs: {
                                                                            title:
                                                                              lot.origination_date
                                                                          }
                                                                        },
                                                                        [
                                                                          _c(
                                                                            "td",
                                                                            [
                                                                              _vm._v(
                                                                                _vm._s(
                                                                                  lot.lot_number
                                                                                )
                                                                              )
                                                                            ]
                                                                          ),
                                                                          _vm._v(
                                                                            " "
                                                                          ),
                                                                          _c(
                                                                            "td",
                                                                            {
                                                                              staticClass:
                                                                                "text-right"
                                                                            },
                                                                            [
                                                                              _vm._v(
                                                                                _vm._s(
                                                                                  lot.onhand_quantity
                                                                                )
                                                                              )
                                                                            ]
                                                                          ),
                                                                          _vm._v(
                                                                            " "
                                                                          ),
                                                                          _c(
                                                                            "td",
                                                                            {
                                                                              staticClass:
                                                                                "text-right"
                                                                            },
                                                                            [
                                                                              _vm
                                                                                .header
                                                                                .sprinkle_header_id
                                                                                ? _c(
                                                                                    "div",
                                                                                    [
                                                                                      _vm._v(
                                                                                        "\n                                                                " +
                                                                                          _vm._s(
                                                                                            lot.issue_quantity
                                                                                          ) +
                                                                                          "\n                                                            "
                                                                                      )
                                                                                    ]
                                                                                  )
                                                                                : _c(
                                                                                    "input",
                                                                                    {
                                                                                      directives: [
                                                                                        {
                                                                                          name:
                                                                                            "model",
                                                                                          rawName:
                                                                                            "v-model.number",
                                                                                          value:
                                                                                            lot.issue_quantity,
                                                                                          expression:
                                                                                            "lot.issue_quantity",
                                                                                          modifiers: {
                                                                                            number: true
                                                                                          }
                                                                                        }
                                                                                      ],
                                                                                      staticClass:
                                                                                        "form-control text-right",
                                                                                      attrs: {
                                                                                        type:
                                                                                          "number",
                                                                                        min:
                                                                                          "0",
                                                                                        max:
                                                                                          lot.onhand_quantity,
                                                                                        oninput:
                                                                                          "validity.valid||(value='');"
                                                                                      },
                                                                                      domProps: {
                                                                                        value:
                                                                                          lot.issue_quantity
                                                                                      },
                                                                                      on: {
                                                                                        input: function(
                                                                                          $event
                                                                                        ) {
                                                                                          if (
                                                                                            $event
                                                                                              .target
                                                                                              .composing
                                                                                          ) {
                                                                                            return
                                                                                          }
                                                                                          _vm.$set(
                                                                                            lot,
                                                                                            "issue_quantity",
                                                                                            _vm._n(
                                                                                              $event
                                                                                                .target
                                                                                                .value
                                                                                            )
                                                                                          )
                                                                                        },
                                                                                        blur: function(
                                                                                          $event
                                                                                        ) {
                                                                                          return _vm.$forceUpdate()
                                                                                        }
                                                                                      }
                                                                                    }
                                                                                  )
                                                                            ]
                                                                          ),
                                                                          _vm._v(
                                                                            " "
                                                                          ),
                                                                          _c(
                                                                            "td",
                                                                            {
                                                                              staticClass:
                                                                                "text-center"
                                                                            },
                                                                            [
                                                                              _vm._v(
                                                                                _vm._s(
                                                                                  lot.issue_unit_of_measure
                                                                                )
                                                                              )
                                                                            ]
                                                                          )
                                                                        ]
                                                                      )
                                                                    : _vm._e()
                                                                }
                                                              ),
                                                              0
                                                            )
                                                          ]
                                                        )
                                                      ]
                                                    )
                                                  ]
                                                )
                                              ])
                                            : _vm._e()
                                        ]
                                      )
                                    ]
                                  : _vm._e()
                              })
                            ],
                            2
                          )
                        ]
                      )
                    : _vm._e()
                ])
              ]
            )
          : _vm._e()
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "10px;" } }),
        _vm._v(" "),
        _c("th", { attrs: { width: "130px;" } }, [
          _vm._v(
            "\n                                Blend No.\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "150px;" } }, [
          _vm._v(
            "\n                                รหัสสินค้าสำเร็จรูป\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("รายละเอียด")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-right", attrs: { width: "100px;" } }, [
          _vm._v(
            "\n                                ปริมาณคงคลัง\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "100px;" } }, [
          _vm._v(
            "\n                                หน่วยนับ\n                            "
          )
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=template&id=2822e353&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/sprinkle-tobaccos/ModalSearch.vue?vue&type=template&id=2822e353& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c("span", [
    _c(
      "div",
      {
        staticClass: "modal inmodal fade",
        attrs: {
          id: "modal_search",
          tabindex: "-1",
          role: "dialog",
          "aria-hidden": "true"
        }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg",
            staticStyle: { width: "90%", "max-width": "950px" }
          },
          [
            _c(
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
                staticClass: "modal-content"
              },
              [
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "modal-body text-left" }, [
                  _c(
                    "div",
                    {
                      directives: [
                        {
                          name: "loading",
                          rawName: "v-loading",
                          value: _vm.getParamlLoading,
                          expression: "getParamlLoading"
                        }
                      ],
                      staticClass: "ibox"
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "row",
                          staticStyle: {
                            "padding-right": "10px",
                            "padding-left": "120px"
                          }
                        },
                        [
                          _c("div", { staticClass: "col-3" }, [
                            _c(
                              "label",
                              {
                                staticClass:
                                  "text-left tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v("วันที่ :")]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "input-group " },
                              [
                                _c("datepicker-th", {
                                  staticClass:
                                    "form-control md:tw-mb-0 tw-mb-2",
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    placeholder: "โปรดเลือกวันที่",
                                    value: _vm.transDateFormat.from_date,
                                    format: _vm.transDate["js-format"]
                                  },
                                  on: {
                                    dateWasSelected: function($event) {
                                      var i = arguments.length,
                                        argsArray = Array(i)
                                      while (i--) argsArray[i] = arguments[i]
                                      return _vm.setdate.apply(
                                        void 0,
                                        argsArray.concat(["from_date"])
                                      )
                                    }
                                  }
                                })
                              ],
                              1
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-3" }, [
                            _c(
                              "label",
                              {
                                staticClass:
                                  "text-left tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" ")]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "input-group " },
                              [
                                _c("datepicker-th", {
                                  staticClass:
                                    "form-control md:tw-mb-0 tw-mb-2",
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    placeholder: "โปรดเลือกวันที่",
                                    value: _vm.transDateFormat.to_date,
                                    format: _vm.transDate["js-format"]
                                  },
                                  on: {
                                    dateWasSelected: function($event) {
                                      var i = arguments.length,
                                        argsArray = Array(i)
                                      while (i--) argsArray[i] = arguments[i]
                                      return _vm.setdate.apply(
                                        void 0,
                                        argsArray.concat(["to_date"])
                                      )
                                    }
                                  }
                                })
                              ],
                              1
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-3" }, [
                            _c(
                              "label",
                              {
                                staticClass:
                                  "text-left tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" เลขที่เอกสาร :")]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "input-group " },
                              [
                                _c(
                                  "el-select",
                                  {
                                    staticStyle: { width: "100%" },
                                    attrs: {
                                      filterable: "",
                                      clearable: "",
                                      placeholder: "เลขที่เอกสาร",
                                      loading: _vm.getParamlLoading,
                                      "popper-append-to-body": false
                                    },
                                    model: {
                                      value: _vm.sprinkleHeaderId,
                                      callback: function($$v) {
                                        _vm.sprinkleHeaderId = $$v
                                      },
                                      expression: "sprinkleHeaderId"
                                    }
                                  },
                                  _vm._l(
                                    _vm.inputParams.sprinkle_header_id_list,
                                    function(data) {
                                      return _c("el-option", {
                                        key: data.value,
                                        attrs: {
                                          label: data.label,
                                          value: data.value
                                        }
                                      })
                                    }
                                  ),
                                  1
                                )
                              ],
                              1
                            )
                          ]),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-3" }, [
                            _c(
                              "label",
                              {
                                staticClass:
                                  "text-left tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" ")]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "text-left" }, [
                              _c(
                                "button",
                                {
                                  class:
                                    _vm.transBtn.search.class +
                                    " btn-lg tw-w-25",
                                  attrs: { type: "button" },
                                  on: { click: _vm.submitForm }
                                },
                                [
                                  _c("i", { class: _vm.transBtn.search.icon }),
                                  _vm._v(
                                    "\n                                        " +
                                      _vm._s(_vm.transBtn.search.text) +
                                      "\n                                    "
                                  )
                                ]
                              )
                            ])
                          ])
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "ibox-content table-responsive m-t mb-3" },
                    [
                      _c("table", { staticClass: "table table-hover" }, [
                        _vm._m(1),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.requestHeaders, function(
                            reqHeader,
                            index
                          ) {
                            return _c("tr", [
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(
                                  _vm._s(reqHeader.transaction_date_format)
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(reqHeader.sprinkle_no))]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-right" }, [
                                _c(
                                  "button",
                                  {
                                    class:
                                      _vm.transBtn.detail.class +
                                      " btn-lg tw-w-25",
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        return _vm.selectWipRequestHeader(
                                          reqHeader
                                        )
                                      }
                                    }
                                  },
                                  [
                                    _c("i", {
                                      class: _vm.transBtn.detail.icon
                                    }),
                                    _vm._v(
                                      "\n                                            " +
                                        _vm._s(_vm.transBtn.detail.text) +
                                        "\n                                        "
                                    )
                                  ]
                                )
                              ])
                            ])
                          }),
                          0
                        )
                      ])
                    ]
                  )
                ]),
                _vm._v(" "),
                _vm._m(2)
              ]
            )
          ]
        )
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "button",
        {
          staticClass: "close",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [
          _c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")]),
          _c("span", { staticClass: "sr-only" }, [_vm._v("Close")])
        ]
      ),
      _vm._v(" "),
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("ค้นหาบันทึกใช้ยาเส้น ZoneC48")
      ]),
      _vm._v(" "),
      _c("small", { staticClass: "font-bold" }, [
        _vm._v("\n                         \n                    ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "200px" } }, [
          _vm._v("วันที่")
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("เลขที่เอกสาร")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "150px" } })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-white",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("Close")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);