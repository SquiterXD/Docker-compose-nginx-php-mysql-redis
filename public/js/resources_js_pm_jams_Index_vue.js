(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_jams_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/jams/Index.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/jams/Index.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************/
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


var _props$computed$watch;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_props$computed$watch = {
  // components: {
  //     modalSearch, searchItem
  // },
  props: ["pUrl"],
  computed: {
    secondaryUomList: function secondaryUomList() {
      var vm = this;

      if (vm.header.inventory_item_id) {
        var item = vm.data.item_list.filter(function (o) {
          return o.inventory_item_id == vm.header.inventory_item_id;
        });

        if (item.length) {
          if (!vm.header.attribute1) {
            vm.header.attribute1 = item[0].primary_uom_code;
          }

          return item[0].secondary_uom_list;
        }
      }

      return [];
    }
  },
  watch: {// ingredient_group(newValue, oldValue) {
    //     console.log('ingredient_group', ingredient_group);
    // },
    // lines: {
    //     transaction_qty(newValue, oldValue){
    //         console.log('watch: transaction_qty', newValue, oldValue);
    //     },
    //     deep: true,
    // },
    // lines: {
    //     handler(val){
    //         console.log('watch lines', val)
    //     },
    //     deep: true,
    // },
    // lines: {
    //     handler(val){
    //         let vm = this;
    //         val.forEach(async function(line, index) {
    //             await vm.adjQty(line);
    //         })
    //     },
    // }
    // lines.transaction_qty: {
    //     handler(val){
    //         console.log('watch lines', val)
    //     },
    //     deep: true,
    // }
  }
}, _defineProperty(_props$computed$watch, "computed", {}), _defineProperty(_props$computed$watch, "data", function data() {
  return {
    url: this.pUrl,
    data: false,
    header: false,
    profile: false,
    searchTransactionDateFormat: '',
    transBtn: {},
    transDate: {},
    biweekly: {},
    lines: [],
    loading: {
      page: false,
      before_mount: false
    },
    firstLoad: true,
    countOpen: 0
  };
}), _defineProperty(_props$computed$watch, "beforeMount", function beforeMount() {
  console.log('beforeMount');
  this.getInfo();
}), _defineProperty(_props$computed$watch, "mounted", function mounted() {
  console.log('Component mounted.');
}), _defineProperty(_props$computed$watch, "methods", {
  setdate: function setdate(date, key) {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      var vm;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              vm = _this; // console.log('setdate', date, key, vm.transDate['js-format']);

              _context.next = 3;
              return moment__WEBPACK_IMPORTED_MODULE_2___default()(date).format(vm.transDate['js-format']);

            case 3:
              vm.header[key] = _context.sent;

              if (vm.header[key]) {
                _this.getInfo();
              }

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  show: function show(header) {
    var _this2 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              console.log('show header', header);
              _this2.header = header;

              _this2.getLines(false, 'show');

            case 3:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  },
  adjQty: function adjQty(line) {
    var _arguments = arguments,
        _this3 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
      var resetData, vm, a3;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              resetData = _arguments.length > 1 && _arguments[1] !== undefined ? _arguments[1] : true;
              vm = _this3;

              if (resetData) {
                line.transaction_qty = Math.ceil(parseFloat(line.ratio_require_per_unit) * parseFloat(vm.header.request_quantity));
                line.ca_qty = Math.trunc(parseFloat(line.transaction_qty) / parseFloat(line.ca_convert_rate)); // line.a3_qty = (parseFloat(line.transaction_qty) % parseFloat(line.ca_convert_rate)) / 10;
                // line.a3_qty = Math.trunc(line.a3_qty * parseFloat(line.ca_convert_rate));
                // line.a3_qty = Math.trunc(line.a3_qty / parseFloat(line.a3_convert_rate));

                a3 = parseFloat(line.transaction_qty) / parseFloat(line.ca_convert_rate) - line.ca_qty;
                a3 = Math.ceil(a3 * line.ca_convert_rate) / line.a3_convert_rate; // line.a3_qty = Math.round(a3);

                line.a3_qty = a3;
              }

              line.transaction_qty = line.ca_qty * line.ca_convert_rate + line.a3_qty * line.a3_convert_rate;
              line.transaction_qty = Math.ceil(line.transaction_qty);

              if (line.transaction_qty <= 0) {
                line.is_selected = false;
              } else {
                line.is_selected = true;
              }

            case 6:
            case "end":
              return _context3.stop();
          }
        }
      }, _callee3);
    }))();
  },
  resetQty: function resetQty() {
    var _this4 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
      var vm;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
        while (1) {
          switch (_context5.prev = _context5.next) {
            case 0:
              vm = _this4;

              _this4.lines.forEach( /*#__PURE__*/function () {
                var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(line, index) {
                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
                    while (1) {
                      switch (_context4.prev = _context4.next) {
                        case 0:
                          _context4.next = 2;
                          return vm.adjQty(line);

                        case 2:
                        case "end":
                          return _context4.stop();
                      }
                    }
                  }, _callee4);
                }));

                return function (_x, _x2) {
                  return _ref.apply(this, arguments);
                };
              }());

            case 2:
            case "end":
              return _context5.stop();
          }
        }
      }, _callee5);
    }))();
  },
  getInfo: function getInfo() {
    var _this5 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
      var vm, transactionDate, param, response;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
        while (1) {
          switch (_context6.prev = _context6.next) {
            case 0:
              vm = _this5;
              transactionDate = vm.header.transaction_date_format;

              if (transactionDate == '' || transactionDate == undefined || transactionDate == null) {
                transactionDate = '';
              }

              param = window.location.search;
              response = false;
              vm.loading.page = true;
              vm.loading.before_mount = true;
              vm.lines = []; // await axios.get(vm.url.index + param).then(res => {

              _context6.next = 10;
              return axios.get(vm.url.index_ony + "?transaction_date_format='" + transactionDate + "'").then(function (res) {
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
                vm.url = response.url;
              }

              vm.loading.before_mount = false;

            case 12:
            case "end":
              return _context6.stop();
          }
        }
      }, _callee6);
    }))();
  },
  selectInventoryItem: function selectInventoryItem(inputName) {
    var _this6 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
      var vm, item, _item, idx;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
        while (1) {
          switch (_context7.prev = _context7.next) {
            case 0:
              vm = _this6;

              if (inputName == 'blend_no') {
                vm.header.inventory_item_id = '';
                vm.header.product_unit_of_measure = '';

                if (vm.header.blend_no) {
                  item = vm.data.item_list.filter(function (o) {
                    return o.blend_no == vm.header.blend_no;
                  });

                  if (item.length) {
                    vm.header.inventory_item_id = item[0]['inventory_item_id'];
                    vm.header.product_unit_of_measure = item[0]['product_unit_of_measure'];
                  }
                }
              }

              if (inputName == 'inventory_item_id') {
                vm.header.blend_no = '';
                vm.header.product_unit_of_measure = '';

                if (vm.header.inventory_item_id) {
                  _item = vm.data.item_list.filter(function (o) {
                    return o.inventory_item_id == vm.header.inventory_item_id;
                  });
                  vm.selectProdItem = {};

                  if (_item.length) {
                    vm.header.blend_no = _item[0]['blend_no'];
                    vm.selectProdItem = _item[0];
                    vm.header.product_unit_of_measure = _item[0]['product_unit_of_measure'];
                  }
                }
              }

              vm.data.tobacco_type_list = [];
              vm.header.tobacco_type_code = '';

              if (vm.header.inventory_item_id) {
                idx = vm.data.item_list.findIndex(function (o) {
                  return o.inventory_item_id == vm.header.inventory_item_id;
                });
                vm.data.tobacco_type_list = vm.data.item_list[idx].tobacco_type_list;
                vm.header.tobacco_type_code = vm.data.tobacco_type_list[0].tobacco_type_code;
              } // if (!vm.firstLoad) {
              //     vm.getLines();
              // }


            case 6:
            case "end":
              return _context7.stop();
          }
        }
      }, _callee7);
    }))();
  },
  changeRequestQuantity: function changeRequestQuantity() {
    var _this7 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
        while (1) {
          switch (_context8.prev = _context8.next) {
            case 0:
              _this7.resetQty();

              return _context8.abrupt("return");

            case 2:
            case "end":
              return _context8.stop();
          }
        }
      }, _callee8);
    }))();
  },
  addNewLine: function addNewLine() {
    var _this8 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
      var vm, row, newLine;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
        while (1) {
          switch (_context9.prev = _context9.next) {
            case 0:
              vm = _this8; // let row = Object.keys(vm.lineAll).length;

              row = vm.lines.length;
              _context9.next = 4;
              return _.clone(vm.data.new_line);

            case 4:
              newLine = _context9.sent;
              vm.$set(vm.lines, row, newLine);

            case 6:
            case "end":
              return _context9.stop();
          }
        }
      }, _callee9);
    }))();
  },
  itemWasSelected: function itemWasSelected(item, line) {
    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
        while (1) {
          switch (_context10.prev = _context10.next) {
            case 0:
              line.segment1 = item.segment1;
              line.description = item.description;
              line.inventory_item_id = item.inventory_item_id;
              line.organization_id = item.organization_id;
              console.log('itemWasSelected(item, line)', item, line);

            case 5:
            case "end":
              return _context10.stop();
          }
        }
      }, _callee10);
    }))();
  },
  save: function save() {
    var _this9 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
      var vm, confirm, lines;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
        while (1) {
          switch (_context12.prev = _context12.next) {
            case 0:
              vm = _this9; // if (vm.lines.length == 0) {
              //     await helperAlert.showGenericFailureDialog('ไม่พบรายการ เลขที่คำสั่งผลิต');
              //     return;
              // }
              // if (vm.searchTransactionDateFormat != vm.header.transaction_date_format) {
              //     await helperAlert.showGenericFailureDialog('วันที่ส่งผลผลิต และวันที่เลขที่คำสั่งผลิตไม่ตรงกัน');
              //     return;
              // }

              _context12.next = 3;
              return helperAlert.showProgressConfirm('กรุณายืนยัน บันทึกเรียกใบยา');

            case 3:
              confirm = _context12.sent;

              if (!confirm) {
                _context12.next = 9;
                break;
              }

              vm.loading.page = true; // let lines =  vm.lines;

              lines = vm.lines.filter(function (o) {
                return o.is_selected == true;
              });
              _context12.next = 9;
              return axios.post(vm.url.ajax_store, {
                header: vm.header,
                lines: lines
              }).then(function (res) {
                var data = res.data.data;

                if (data.status == 'S') {
                  // vm.header = data.header;
                  swal({
                    title: "Success",
                    text: 'ยืนยันเรียกใบยาสำเร็จ',
                    type: "success",
                    showConfirmButton: true
                  });
                  setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
                      while (1) {
                        switch (_context11.prev = _context11.next) {
                          case 0:
                            _context11.next = 2;
                            return vm.getInfo();

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
                vm.loading.page = false; // swal.close();
              });

            case 9:
            case "end":
              return _context12.stop();
          }
        }
      }, _callee12);
    }))();
  },
  setStatus: function setStatus(status) {
    var _this10 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
      var vm, confirm, msg, url;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
        while (1) {
          switch (_context13.prev = _context13.next) {
            case 0:
              vm = _this10;
              confirm = false;
              msg = '';

              if (status == 'confirmTransfer') {
                msg = 'กรุณายืนยันโอนวัถุดิบ';
              }

              if (status == 'cancelTransfer') {
                msg = 'กรุณายืนยันยกเลิกโอน';
              }

              _context13.next = 7;
              return helperAlert.showProgressConfirm(msg);

            case 7:
              confirm = _context13.sent;

              if (!confirm) {
                _context13.next = 14;
                break;
              }

              vm.loading.page = true;
              url = vm.url.ajax_set_status;

              if (vm.header.storage_header_id != '' && vm.header.storage_header_id != undefined) {
                url = url.replace("-999", vm.header.storage_header_id);
              }

              _context13.next = 14;
              return axios.post(url, {
                status: status
              }).then(function (res) {
                var data = res.data.data;

                if (data.status == 'S') {
                  vm.header.request_status = String(data.request_status);
                  vm.header.can = data.can;
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

            case 14:
            case "end":
              return _context13.stop();
          }
        }
      }, _callee13);
    }))();
  },
  setData: function setData() {
    var _this11 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
      var vm;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
        while (1) {
          switch (_context14.prev = _context14.next) {
            case 0:
              vm = _this11;

              if (vm.header.storage_header_id != undefined && vm.header.storage_header_id != '') {
                vm.getLines(false, 'show');
              }

              vm.firstLoad = false;

            case 3:
            case "end":
              return _context14.stop();
          }
        }
      }, _callee14);
    }))();
  },
  indexPage: function indexPage() {
    // this.loading.page = true;
    // location.href = this.url.index;
    this.getInfo();
  },
  getLines: function getLines() {
    var _arguments2 = arguments,
        _this12 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
      var isShowNoti, action, vm, confirm;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
        while (1) {
          switch (_context15.prev = _context15.next) {
            case 0:
              isShowNoti = _arguments2.length > 0 && _arguments2[0] !== undefined ? _arguments2[0] : true;
              action = _arguments2.length > 1 && _arguments2[1] !== undefined ? _arguments2[1] : 'search';
              vm = _this12;
              confirm = true;

              if (!isShowNoti) {
                _context15.next = 8;
                break;
              }

              _context15.next = 7;
              return helperAlert.showProgressConfirm('ต้องการเปลี่ยนแปลงค้นหาเรียกใบยา ?');

            case 7:
              confirm = _context15.sent;

            case 8:
              console.log('getLines', isShowNoti, confirm);

              if (!confirm) {
                _context15.next = 14;
                break;
              }

              vm.loading.page = true; // vm.searchTransactionDateFormat = vm.header.transaction_date_format;
              // vm.biweekly = {};

              vm.lines = []; // let params = {
              //     number: query,
              //     action: action
              // }

              _context15.next = 14;
              return axios.get(vm.url.ajax_get_lines, {
                params: {
                  header: vm.header,
                  action: action
                }
              }).then(function (res) {
                var data = res.data.data; // console.log('xx', data.lines);

                vm.lines = data.lines;
                vm.resetQty(); // vm.biweekly = data.biweekly;
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

            case 14:
              return _context15.abrupt("return");

            case 15:
            case "end":
              return _context15.stop();
          }
        }
      }, _callee15);
    }))();
  },
  changeQty: function changeQty(line, inputName) {
    var _this13 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
      var vm, cgcQty, cgkQty;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
        while (1) {
          switch (_context16.prev = _context16.next) {
            case 0:
              vm = _this13; // let cgcQty = (line.cgc_quantity != '' && line.cgc_quantity != undefined) ? line.cgc_quantity : 0;
              // let cgkQty = (line.cgk_quantity != '' && line.cgk_quantity != undefined) ? line.cgk_quantity : 0;
              // console.log('000', cgcQty, '----', cgkQuantity, inputName);
              // console.log('111', cgcQuantity, cgkQuantity, inputName);

              if (inputName == 'cgc_quantity') {
                cgcQty = line.cgc_quantity != '' && line.cgc_quantity != undefined ? line.cgc_quantity : 0;
                line.cgk_quantity = '';
                line.cgk_quantity = parseFloat(cgcQty) * parseFloat(vm.data.convert_rate);
              } else if (inputName == 'cgk_quantity') {
                cgkQty = line.cgk_quantity != '' && line.cgk_quantity != undefined ? line.cgk_quantity : 0;
                line.cgc_quantity = '';
                line.cgc_quantity = parseFloat(cgkQty) / parseFloat(vm.data.convert_rate);
              }

            case 2:
            case "end":
              return _context16.stop();
          }
        }
      }, _callee16);
    }))();
  }
}), _props$computed$watch);

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

/***/ "./resources/js/pm/jams/Index.vue":
/*!****************************************!*\
  !*** ./resources/js/pm/jams/Index.vue ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_08d0c204___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=08d0c204& */ "./resources/js/pm/jams/Index.vue?vue&type=template&id=08d0c204&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/jams/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_08d0c204___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_08d0c204___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/jams/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/jams/Index.vue?vue&type=script&lang=js&":
/*!*****************************************************************!*\
  !*** ./resources/js/pm/jams/Index.vue?vue&type=script&lang=js& ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/jams/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/jams/Index.vue?vue&type=template&id=08d0c204&":
/*!***********************************************************************!*\
  !*** ./resources/js/pm/jams/Index.vue?vue&type=template&id=08d0c204& ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_08d0c204___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_08d0c204___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_08d0c204___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=08d0c204& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/jams/Index.vue?vue&type=template&id=08d0c204&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/jams/Index.vue?vue&type=template&id=08d0c204&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/jams/Index.vue?vue&type=template&id=08d0c204& ***!
  \**************************************************************************************************************************************************************************************************************/
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
          ? _c("div", { staticClass: "ibox-content" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-lg-7 offset-1" }, [
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-lg-6 font-weight-bold col-form-label text-right"
                      },
                      [_vm._v("วันที่เรียกใบยา :")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-lg-6" },
                      [
                        _c("datepicker-th", {
                          staticClass: "form-control md:tw-mb-0 tw-mb-2",
                          staticStyle: { width: "100%" },
                          attrs: {
                            name: "input_date",
                            disabled: false,
                            id: "input_date",
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
                        })
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-lg-6 font-weight-bold col-form-label text-right"
                      },
                      [_vm._v("Blend No.: ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-lg-6" },
                      [
                        _c(
                          "el-select",
                          {
                            staticStyle: { width: "100%" },
                            attrs: {
                              placeholder: "",
                              "value-key": "blend_no",
                              clearable: "",
                              filterable: ""
                            },
                            on: {
                              change: function($event) {
                                return _vm.selectInventoryItem("blend_no")
                              }
                            },
                            model: {
                              value: _vm.header.blend_no,
                              callback: function($$v) {
                                _vm.$set(_vm.header, "blend_no", $$v)
                              },
                              expression: "header.blend_no"
                            }
                          },
                          _vm._l(_vm.data.blend_no_list, function(item) {
                            return _c("el-option", {
                              key: JSON.stringify(item),
                              attrs: { label: item, value: item }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-lg-6 font-weight-bold col-form-label text-right"
                      },
                      [_vm._v("สินค้าที่จะผลิต: ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-lg-6" },
                      [
                        _c(
                          "el-select",
                          {
                            staticStyle: { width: "100%" },
                            attrs: {
                              placeholder: "",
                              "value-key": "blend_no",
                              clearable: "",
                              filterable: ""
                            },
                            on: {
                              change: function($event) {
                                return _vm.selectInventoryItem(
                                  "inventory_item_id"
                                )
                              }
                            },
                            model: {
                              value: _vm.header.inventory_item_id,
                              callback: function($$v) {
                                _vm.$set(_vm.header, "inventory_item_id", $$v)
                              },
                              expression: "header.inventory_item_id"
                            }
                          },
                          _vm._l(_vm.data.item_list, function(item) {
                            return _c("el-option", {
                              key: JSON.stringify(item),
                              attrs: {
                                label: item.display,
                                value: item.inventory_item_id
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
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-lg-6 font-weight-bold col-form-label text-right require"
                      },
                      [_vm._v("ประเภทใบยาที่ต้องการเรียก *: ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-lg-6" },
                      [
                        _c(
                          "el-select",
                          {
                            staticStyle: { width: "100%" },
                            attrs: {
                              placeholder: "",
                              "value-key": "blend_no",
                              clearable: "",
                              filterable: ""
                            },
                            model: {
                              value: _vm.header.tobacco_type_code,
                              callback: function($$v) {
                                _vm.$set(_vm.header, "tobacco_type_code", $$v)
                              },
                              expression: "header.tobacco_type_code"
                            }
                          },
                          _vm._l(_vm.data.tobacco_type_list, function(item) {
                            return _c("el-option", {
                              key: JSON.stringify(item),
                              attrs: {
                                label:
                                  item.tobacco_type_code +
                                  " : " +
                                  item.tobacco_type,
                                value: item.tobacco_type_code
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
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-lg-6 font-weight-bold col-form-label text-right"
                      },
                      [_vm._v("จำนวนที่สั่งผลิต: ")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-lg-3" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model.number",
                            value: _vm.header.request_quantity,
                            expression: "header.request_quantity",
                            modifiers: { number: true }
                          }
                        ],
                        staticClass: "form-control text-right",
                        attrs: {
                          type: "number",
                          disabled: !_vm.header.inventory_item_id
                        },
                        domProps: { value: _vm.header.request_quantity },
                        on: {
                          change: _vm.changeRequestQuantity,
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.header,
                              "request_quantity",
                              _vm._n($event.target.value)
                            )
                          },
                          blur: function($event) {
                            return _vm.$forceUpdate()
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-lg-3" }, [
                      _c("input", {
                        staticClass: "form-control",
                        attrs: {
                          title: _vm.header.primary_uom_code,
                          disabled: ""
                        },
                        domProps: { value: _vm.header.product_unit_of_measure }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("div", { staticClass: "col-lg-12 text-right" }, [
                      _c(
                        "button",
                        {
                          class: _vm.transBtn.search.class + " btn-lg tw-w-25",
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.getLines(false)
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.transBtn.search.icon }),
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.transBtn.search.text) +
                              "\n                            "
                          )
                        ]
                      )
                    ])
                  ])
                ])
              ])
            ])
          : _vm._e()
      ]
    ),
    _vm._v(" "),
    !_vm.loading.before_mount
      ? _c(
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
            _c(
              "div",
              { staticClass: "ibox-content" },
              [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-12" }, [
                    _vm._v("\n                    ค้นหาข้อมูลปักษ์ที่ : "),
                    _vm.biweekly
                      ? _c("span", [
                          _vm._v(" " + _vm._s(_vm.biweekly.biweekly) + " ")
                        ])
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "table-responsive m-t" }, [
                  _c(
                    "table",
                    { staticClass: "table text-nowrap table-bordered" },
                    [
                      _vm._m(0),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.lines, function(line, i) {
                          return _vm.lines.length
                            ? _c("tr", [
                                _c(
                                  "td",
                                  {
                                    staticClass: "align-middle text-center",
                                    attrs: { date: i }
                                  },
                                  [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: line.is_selected,
                                          expression: "line.is_selected"
                                        }
                                      ],
                                      attrs: { type: "checkbox" },
                                      domProps: {
                                        checked: Array.isArray(line.is_selected)
                                          ? _vm._i(line.is_selected, null) > -1
                                          : line.is_selected
                                      },
                                      on: {
                                        change: function($event) {
                                          var $$a = line.is_selected,
                                            $$el = $event.target,
                                            $$c = $$el.checked ? true : false
                                          if (Array.isArray($$a)) {
                                            var $$v = null,
                                              $$i = _vm._i($$a, $$v)
                                            if ($$el.checked) {
                                              $$i < 0 &&
                                                _vm.$set(
                                                  line,
                                                  "is_selected",
                                                  $$a.concat([$$v])
                                                )
                                            } else {
                                              $$i > -1 &&
                                                _vm.$set(
                                                  line,
                                                  "is_selected",
                                                  $$a
                                                    .slice(0, $$i)
                                                    .concat($$a.slice($$i + 1))
                                                )
                                            }
                                          } else {
                                            _vm.$set(line, "is_selected", $$c)
                                          }
                                        }
                                      }
                                    })
                                  ]
                                ),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(line.leaf_fomula) +
                                      "\n                            "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(line.item_number) +
                                      "\n                            "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(line.item_desc) +
                                      "\n                                "
                                  )
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right",
                                    attrs: { title: line.require_qty }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          Math.ceil(
                                            line.ratio_require_per_unit *
                                              _vm.header.request_quantity
                                          )
                                        ) +
                                        "\n                                " +
                                        _vm._s(line.uom.unit_of_measure) +
                                        "\n                            "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-right" }, [
                                  line.transaction_qty != NaN
                                    ? _c("span", [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(line.transaction_qty) +
                                            "\n                                "
                                        )
                                      ])
                                    : _vm._e(),
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(line.uom.unit_of_measure) +
                                      "\n                            "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _c("div", { staticClass: "input-group " }, [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model.number",
                                          value: line.ca_qty,
                                          expression: "line.ca_qty",
                                          modifiers: { number: true }
                                        }
                                      ],
                                      staticClass: "form-control text-right",
                                      attrs: { type: "number" },
                                      domProps: { value: line.ca_qty },
                                      on: {
                                        change: function($event) {
                                          return _vm.adjQty(line, false)
                                        },
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            line,
                                            "ca_qty",
                                            _vm._n($event.target.value)
                                          )
                                        },
                                        blur: function($event) {
                                          return _vm.$forceUpdate()
                                        }
                                      }
                                    }),
                                    _vm._v(" "),
                                    _vm._m(1, true)
                                  ])
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _c("div", { staticClass: "input-group " }, [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model.number",
                                          value: line.a3_qty,
                                          expression: "line.a3_qty",
                                          modifiers: { number: true }
                                        }
                                      ],
                                      staticClass: "form-control text-right",
                                      attrs: { type: "number" },
                                      domProps: { value: line.a3_qty },
                                      on: {
                                        change: function($event) {
                                          return _vm.adjQty(line, false)
                                        },
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            line,
                                            "a3_qty",
                                            _vm._n($event.target.value)
                                          )
                                        },
                                        blur: function($event) {
                                          return _vm.$forceUpdate()
                                        }
                                      }
                                    }),
                                    _vm._v(" "),
                                    _vm._m(2, true)
                                  ])
                                ])
                              ])
                            : _vm._e()
                        }),
                        0
                      )
                    ]
                  )
                ]),
                _vm._v(" "),
                _vm.lines.length === 0
                  ? _c("div", { staticClass: "text-center" }, [
                      _c("span", { staticClass: "lead" }, [_vm._v("No Data.")])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "transition",
                  {
                    attrs: {
                      "enter-active-class": "animated fadeInUp",
                      "leave-active-class": "animated fadeOutDown"
                    }
                  },
                  [
                    _vm.lines.length > 0 && !_vm.loading.before_mount
                      ? _c("div", { staticClass: "text-center" }, [
                          _c(
                            "button",
                            {
                              class:
                                _vm.transBtn.save.class + " btn-lg tw-w-25",
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.save($event)
                                }
                              }
                            },
                            [
                              _c("i", { class: _vm.transBtn.save.icon }),
                              _vm._v(" "),
                              _vm._v(
                                "\n                        ยืนยันเรียกใบยา\n                    "
                              )
                            ]
                          )
                        ])
                      : _vm._e()
                  ]
                )
              ],
              1
            )
          ]
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { width: "10px;" } }),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "50px;" } }, [
          _vm._v(
            "\n                                กลุ่มใบยา\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "150px;" } }, [
          _vm._v(
            "\n                                รหัสวัตถุดิบ\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("รายละเอียด")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "200px;" } }, [
          _vm._v(
            "\n                                ปริมาณที่ใช้\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "200px;" } }, [
          _vm._v(
            "\n                                ปริมาณเบิก\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "400px;" } }, [
          _vm._v("\n                                ปริมาณ"),
          _c("br"),
          _vm._v("\n                                ที่ต้องการเบิก"),
          _c("br"),
          _vm._v(
            "\n                                FULL/ASRS\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "400px;" } }, [
          _vm._v("\n                                ปริมาณ"),
          _c("br"),
          _vm._v("\n                                ที่ต้องการเบิก"),
          _c("br"),
          _vm._v(
            "\n                                Quarter/RGV\n                            "
          )
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "input-group-append",
        attrs: { title: "line.transaction_uom" }
      },
      [_c("span", { staticClass: "input-group-addon" }, [_vm._v("หีบ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "input-group-append",
        attrs: { title: "line.transaction_uom" }
      },
      [_c("span", { staticClass: "input-group-addon" }, [_vm._v("ลูก")])]
    )
  }
]
render._withStripped = true



/***/ })

}]);