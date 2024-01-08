(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_send-cigarettes_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/Index.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/Index.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _SearchItem__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./SearchItem */ "./resources/js/pm/send-cigarettes/SearchItem.vue");
/* harmony import */ var _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ModalSearch.vue */ "./resources/js/pm/send-cigarettes/ModalSearch.vue");


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    modalSearch: _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    searchItem: _SearchItem__WEBPACK_IMPORTED_MODULE_3__.default
  },
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
  },
  data: function data() {
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
  },
  beforeMount: function beforeMount() {
    console.log('beforeMount');
    this.getInfo();
  },
  mounted: function mounted() {
    console.log('wip-requests: Component mounted.');
  },
  methods: {
    handleFocusoutCgc: function handleFocusoutCgc(line) {
      line.cgc_quantity = this.numberWithCommas(_.ceil(line.cgc_quantity));
    },
    numberWithCommas: function numberWithCommas(x) {
      var parts = x.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
    },
    show: function show(header) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log('show header', header);
                _this.header = header;

                _this.getLines(false, 'show');

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getInfo: function getInfo() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, param, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                param = window.location.search;
                response = false;
                vm.loading.page = true;
                vm.loading.before_mount = true;
                vm.lines = [];
                _context2.next = 8;
                return axios.get(vm.url.index + param).then(function (res) {
                  response = res.data.data;

                  if (response.status == 'S') {
                    response = response.info;
                  }

                  vm.loading.page = false;
                });

              case 8:
                if (response) {
                  vm.data = response.data;
                  vm.header = response.header;
                  vm.profile = response.profile;
                  vm.transBtn = response.transBtn;
                  vm.transDate = response.transDate;
                  vm.url = response.url;
                }

                vm.loading.before_mount = false; // console.log('info success');

                vm.getLines(false, 'show');

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    setdate: function setdate(date, key) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this3;
                _context3.next = 3;
                return moment__WEBPACK_IMPORTED_MODULE_2___default()(date).format(vm.transDate['js-format']);

              case 3:
                vm.header[key] = _context3.sent;
                vm.getLines();

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    addNewLine: function addNewLine() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, row, newLine;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this4; // let row = Object.keys(vm.lineAll).length;

                row = vm.lines.length;
                _context4.next = 4;
                return _.clone(vm.data.new_line);

              case 4:
                newLine = _context4.sent;
                vm.$set(vm.lines, row, newLine);

              case 6:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    itemWasSelected: function itemWasSelected(item, line, i) {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                line.segment1 = item.segment1;
                line.description = item.description;
                line.inventory_item_id = item.inventory_item_id;
                line.organization_id = item.organization_id;
                console.log('itemWasSelected(item, line)', item, line);

              case 5:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    save: function save() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm, confirm, lines;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this5; // if (vm.lines.length == 0) {
                //     await helperAlert.showGenericFailureDialog('ไม่พบรายการ เลขที่คำสั่งผลิต');
                //     return;
                // }
                // if (vm.searchTransactionDateFormat != vm.header.transaction_date_format) {
                //     await helperAlert.showGenericFailureDialog('วันที่ส่งผลผลิต และวันที่เลขที่คำสั่งผลิตไม่ตรงกัน');
                //     return;
                // }

                _context7.next = 3;
                return helperAlert.showProgressConfirm('กรุณายืนยัน ส่งยอดบุหรี่');

              case 3:
                confirm = _context7.sent;

                if (!confirm) {
                  _context7.next = 11;
                  break;
                }

                _.map(vm.lines, function (item, i) {
                  item.cgc_quantity = item.cgc_quantity.replaceAll(',', '');
                  item.cgk_quantity = item.cgk_quantity.replaceAll(',', '');
                  return item;
                });

                vm.loading.page = true; // let lines =  vm.lines;

                lines = vm.lines.filter(function (o) {
                  return o.is_selected == true;
                });
                ;
                _context7.next = 11;
                return axios.post(vm.url.ajax_store, {
                  header: vm.header,
                  lines: lines
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    vm.header = data.header;
                    setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
                        while (1) {
                          switch (_context6.prev = _context6.next) {
                            case 0:
                              _context6.next = 2;
                              return vm.getLines(false, 'show');

                            case 2:
                            case "end":
                              return _context6.stop();
                          }
                        }
                      }, _callee6);
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

              case 11:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    setStatus: function setStatus(status) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var vm, confirm, msg, url;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                vm = _this6;
                confirm = false;
                msg = '';

                if (status == 'confirmTransfer') {
                  msg = 'กรุณายืนยันโอนวัถุดิบ';
                }

                if (status == 'cancelTransfer') {
                  msg = 'กรุณายืนยันยกเลิกโอน';
                }

                _context8.next = 7;
                return helperAlert.showProgressConfirm(msg);

              case 7:
                confirm = _context8.sent;

                if (!confirm) {
                  _context8.next = 14;
                  break;
                }

                vm.loading.page = true;
                url = vm.url.ajax_set_status;

                if (vm.header.storage_header_id != '' && vm.header.storage_header_id != undefined) {
                  url = url.replace("-999", vm.header.storage_header_id);
                }

                _context8.next = 14;
                return axios.post(url, {
                  status: status
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    vm.header.mfg_status = String(data.mfg_status);
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
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    setData: function setData() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                vm = _this7;

                if (vm.header.storage_header_id != undefined && vm.header.storage_header_id != '') {
                  vm.getLines(false, 'show');
                }

                vm.firstLoad = false;

              case 3:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    indexPage: function indexPage() {
      // this.loading.page = true;
      // location.href = this.url.index;
      this.getInfo();
    },
    getLines: function getLines() {
      var _arguments = arguments,
          _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var isShowNoti, action, vm, confirm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                isShowNoti = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : true;
                action = _arguments.length > 1 && _arguments[1] !== undefined ? _arguments[1] : 'search';
                vm = _this8;
                confirm = true; // if (isShowNoti) {
                //     confirm = await helperAlert.showProgressConfirm('ต้องการเปลี่ยนแปลงค้นหาการจัดเก็บบุหรี่ ?');
                // }

                console.log('getLines', isShowNoti, confirm);

                if (!confirm) {
                  _context10.next = 12;
                  break;
                }

                vm.loading.page = true;
                vm.searchTransactionDateFormat = vm.header.transaction_date_format;
                vm.biweekly = {};
                vm.lines = []; // let params = {
                //     number: query,
                //     action: action
                // }

                _context10.next = 12;
                return axios.get(vm.url.ajax_get_lines, {
                  params: {
                    header: vm.header,
                    action: action
                  }
                }).then(function (res) {
                  var data = res.data.data; // console.log('xx', data.lines);

                  vm.lines = data.lines;

                  _.map(vm.lines, function (item, i) {
                    item.cgc_quantity = _this8.numberWithCommas(_.ceil(item.cgc_quantity));
                    item.cgk_quantity = _this8.numberWithCommas(item.cgk_quantity);
                    return item;
                  });

                  vm.biweekly = data.biweekly; // if (res.data.data.status != 'S') {
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

              case 12:
                return _context10.abrupt("return");

              case 13:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    changeQty: function changeQty(line, inputName) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var vm, cgcQty, cgkQty;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                vm = _this9; // let cgcQty = (line.cgc_quantity != '' && line.cgc_quantity != undefined) ? line.cgc_quantity : 0;
                // let cgkQty = (line.cgk_quantity != '' && line.cgk_quantity != undefined) ? line.cgk_quantity : 0;
                // console.log('000', cgcQty, '----', cgkQuantity, inputName);
                // console.log('111', cgcQuantity, cgkQuantity, inputName);

                if (inputName == 'cgc_quantity') {
                  cgcQty = line.cgc_quantity != '' && line.cgc_quantity != undefined ? line.cgc_quantity : 0;
                  line.cgk_quantity = '';
                  line.cgk_quantity = _this9.numberWithCommas(parseFloat(cgcQty) * parseFloat(vm.data.convert_rate));
                } else if (inputName == 'cgk_quantity') {
                  cgkQty = line.cgk_quantity != '' && line.cgk_quantity != undefined ? line.cgk_quantity : 0;
                  line.cgc_quantity = '';
                  line.cgc_quantity = _this9.numberWithCommas(_.ceil(parseFloat(cgkQty) / parseFloat(vm.data.convert_rate)));
                }

              case 2:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['header', "transBtn", "url", "countOpen"],
  data: function data() {
    return {
      loading: false,
      // reqHeaderHeaderId: '',
      wipRequestNo: '',
      requestHeaders: []
    };
  },
  mounted: function mounted() {// if (this.budget_year) {
    //     this.getBiWeekly();
    // }
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
    }()
  },
  methods: {
    openModal: function openModal() {
      $('#modal_search').modal('show');
    },
    remoteMethod: function remoteMethod(query) {
      if (query !== "") {
        this.getWipRequest({
          mfg_order_number: query,
          action: 'search'
        });
      } else {
        this.requestHeaders = [];
      }
    },
    getWipRequest: function getWipRequest(params) {
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
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                $('#modal_search').modal('hide');
                _this.requestHeaders = [];

                _this.$emit("selectWipRequestHeader", reqHeader);

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    searchForm: function searchForm() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this2.getWipRequest({
                  mfg_order_number: _this2.wipRequestNo,
                  action: 'search'
                });

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["pHeader", "inventoryItemId", 'url', 'lines', 'i'],
  computed: {},
  watch: {},
  data: function data() {
    return {
      itemId: this.inventoryItemId != undefined && this.inventoryItemId != '' ? parseInt(this.inventoryItemId) : '',
      loading: false,
      items: []
    };
  },
  mounted: function mounted() {
    console.log('Component mounted.');

    if (this.itemId !== "") {
      this.getItems({
        inventory_item_id: this.itemId,
        header: this.pHeader,
        lines: this.lines
      });
    } else {
      this.items = [];
      this.getItems({
        number: ' ',
        header: this.pHeader,
        lines: this.lines
      });
    }
  },
  methods: {
    itemWasSelected: function itemWasSelected(selectItemId) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, item;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                item = vm.items.filter(function (o) {
                  return o.inventory_item_id == selectItemId;
                });
                setTimeout(function () {
                  var el = $(_this.$refs['selected_' + _this.i].$el).find('input');
                  el.val(el.val().split(" : ")[0]);
                }, 50);

                if (item.length) {
                  item = item[0];
                }

                vm.$emit("itemWasSelected", item);

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    remoteMethod: function remoteMethod(query) {
      if (query !== "") {
        this.getItems({
          number: query,
          header: this.pHeader,
          lines: this.lines
        });
      } else {
        this.items = [];
      }
    },
    getItems: function getItems(params) {
      var _this2 = this;

      var vm = this;
      vm.loading = true;
      axios.get(vm.url.ajax_get_item, {
        params: params
      }).then(function (res) {
        var response = res.data.data;
        vm.loading = false;
        vm.items = response.items;
        setTimeout(function () {
          var el = $(_this2.$refs['selected_' + vm.i].$el).find('input');
          el.val(el.val().split(" : ")[0]);
        }, 50);
      });
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

/***/ "./resources/js/pm/send-cigarettes/Index.vue":
/*!***************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/Index.vue ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_4972ae56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=4972ae56& */ "./resources/js/pm/send-cigarettes/Index.vue?vue&type=template&id=4972ae56&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/send-cigarettes/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_4972ae56___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_4972ae56___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/send-cigarettes/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/send-cigarettes/ModalSearch.vue":
/*!*********************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/ModalSearch.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_60201e10___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=60201e10& */ "./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=template&id=60201e10&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_60201e10___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_60201e10___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/send-cigarettes/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/send-cigarettes/SearchItem.vue":
/*!********************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/SearchItem.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchItem_vue_vue_type_template_id_5ec7d268___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchItem.vue?vue&type=template&id=5ec7d268& */ "./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=template&id=5ec7d268&");
/* harmony import */ var _SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchItem.vue?vue&type=script&lang=js& */ "./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchItem_vue_vue_type_template_id_5ec7d268___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchItem_vue_vue_type_template_id_5ec7d268___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/send-cigarettes/SearchItem.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/send-cigarettes/Index.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/Index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchItem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/send-cigarettes/Index.vue?vue&type=template&id=4972ae56&":
/*!**********************************************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/Index.vue?vue&type=template&id=4972ae56& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_4972ae56___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_4972ae56___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_4972ae56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=4972ae56& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/Index.vue?vue&type=template&id=4972ae56&");


/***/ }),

/***/ "./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=template&id=60201e10&":
/*!****************************************************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=template&id=60201e10& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_60201e10___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_60201e10___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_60201e10___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=60201e10& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=template&id=60201e10&");


/***/ }),

/***/ "./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=template&id=5ec7d268&":
/*!***************************************************************************************!*\
  !*** ./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=template&id=5ec7d268& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_template_id_5ec7d268___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_template_id_5ec7d268___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_template_id_5ec7d268___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchItem.vue?vue&type=template&id=5ec7d268& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=template&id=5ec7d268&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/Index.vue?vue&type=template&id=4972ae56&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/Index.vue?vue&type=template&id=4972ae56& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
                _c("div", { staticClass: "col-12 text-right" }, [
                  _c(
                    "button",
                    {
                      class: _vm.transBtn.create.class + " btn-lg tw-w-25 mr-2",
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.indexPage($event)
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
                      attrs: { disabled: !_vm.header.can.edit },
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
                        "\n                        ส่งยอดบุหรี่\n                    "
                      )
                    ]
                  )
                ])
              ])
            ])
          : _vm._e(),
        _vm._v(" "),
        !_vm.loading.before_mount
          ? _c(
              "div",
              { staticClass: "ibox-content" },
              [
                _c("modal-search", {
                  attrs: {
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
                        "label",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right",
                          attrs: { for: "lb-2" }
                        },
                        [_vm._v("เลขที่ใบส่ง: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _c("div", { staticClass: "input-group " }, [
                          _c("input", {
                            staticClass: "form-control",
                            attrs: {
                              id: "lb-2",
                              type: "text",
                              name: "mfg_order_number",
                              disabled: true
                            },
                            domProps: { value: _vm.header.mfg_order_number }
                          })
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "label",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right",
                          attrs: { for: "lb-2" }
                        },
                        [_vm._v("เลขที่ Lot: ")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-lg-7" }, [
                        _c("div", { staticClass: "input-group " }, [
                          _c("input", {
                            staticClass: "form-control",
                            attrs: {
                              id: "lb-2",
                              type: "text",
                              name: "lot_number",
                              disabled: true
                            },
                            domProps: { value: _vm.header.lot_number }
                          })
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "label",
                        {
                          staticClass:
                            "col-lg-4 font-weight-bold col-form-label text-right"
                        },
                        [_vm._v("วันที่ส่งผลผลิต: ")]
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
                              disabled: !_vm.header.can.edit,
                              placeholder: "โปรดเลือกวันที่",
                              value: _vm.header.transaction_date_format,
                              format: _vm.transDate["js-format"],
                              "value-format": "dd-mm-yyyy"
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
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("div", { staticClass: "form-group row" }, [
                      _c(
                        "label",
                        {
                          staticClass:
                            "col-lg-3 font-weight-bold col-form-label text-right"
                        },
                        [_vm._v("หมายเหตุ: ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-lg-6" },
                        [
                          _c("el-input", {
                            staticClass: "required",
                            attrs: {
                              disabled: !_vm.header.can.edit,
                              type: "textarea",
                              name: "note",
                              rows: "4",
                              maxlength: "240",
                              "show-word-limit": ""
                            },
                            model: {
                              value: _vm.header.remark_msg,
                              callback: function($$v) {
                                _vm.$set(_vm.header, "remark_msg", $$v)
                              },
                              expression: "header.remark_msg"
                            }
                          })
                        ],
                        1
                      )
                    ])
                  ])
                ])
              ],
              1
            )
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
            _c("div", { staticClass: "ibox-content" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-12" }, [
                  _c("div", { staticClass: "text-right" }, [
                    _c(
                      "button",
                      {
                        class: _vm.transBtn.create.class + " btn-lg tw-w-25",
                        attrs: { disabled: !_vm.header.can.edit },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.addNewLine($event)
                          }
                        }
                      },
                      [
                        _c("i", { class: _vm.transBtn.create.icon }),
                        _vm._v(
                          "\n                            เพิ่มรายการ\n                        "
                        )
                      ]
                    )
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "ibox-content" }, [
              _vm._m(0),
              _vm._v(" "),
              _c("div", { staticClass: "table-responsive m-t" }, [
                _c("div", { staticClass: "table-responsive m-t" }, [
                  _c(
                    "table",
                    { staticClass: "table text-nowrap table-bordered" },
                    [
                      _vm._m(1),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.lines, function(line, i) {
                          return _vm.lines.length
                            ? _c("tr", { key: i }, [
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
                                      attrs: {
                                        type: "checkbox",
                                        disabled: !_vm.header.can.edit
                                      },
                                      domProps: {
                                        checked: Array.isArray(line.is_selected)
                                          ? _vm._i(line.is_selected, null) > -1
                                          : line.is_selected
                                      },
                                      on: {
                                        click: function($event) {
                                          return _vm.selectLine(i, line)
                                        },
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
                                _c(
                                  "td",
                                  [
                                    line.storage_line_id && !_vm.header.can.edit
                                      ? [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(line.segment1) +
                                              "\n                                "
                                          )
                                        ]
                                      : [
                                          _c(
                                            "div",
                                            {
                                              staticStyle: { display: "flex" }
                                            },
                                            [
                                              !line.is_edit_item ||
                                              !_vm.header.can.edit
                                                ? [
                                                    _c("el-input", {
                                                      attrs: {
                                                        placeholder:
                                                          "Please input",
                                                        value: line.segment1,
                                                        disabled: true
                                                      }
                                                    }),
                                                    _vm._v(" "),
                                                    _vm.header.can.edit &&
                                                    line.storage_line_id
                                                      ? _c(
                                                          "button",
                                                          {
                                                            staticClass:
                                                              "btn btn-outline btn-xs mb-0",
                                                            attrs: {
                                                              type: "button",
                                                              title: "แก้ไข"
                                                            },
                                                            on: {
                                                              click: function(
                                                                $event
                                                              ) {
                                                                $event.preventDefault()
                                                                line.is_edit_item = true
                                                              }
                                                            }
                                                          },
                                                          [
                                                            _c("i", {
                                                              class:
                                                                _vm.transBtn
                                                                  .edit.icon
                                                            })
                                                          ]
                                                        )
                                                      : _vm._e()
                                                  ]
                                                : [
                                                    _c("search-item", {
                                                      attrs: {
                                                        pHeader: _vm.header,
                                                        i: i,
                                                        inventoryItemId:
                                                          line.inventory_item_id,
                                                        lines: _vm.lines,
                                                        url: _vm.url
                                                      },
                                                      on: {
                                                        itemWasSelected: function(
                                                          $event
                                                        ) {
                                                          var i$1 =
                                                              arguments.length,
                                                            argsArray = Array(
                                                              i$1
                                                            )
                                                          while (i$1--)
                                                            argsArray[i$1] =
                                                              arguments[i$1]
                                                          return _vm.itemWasSelected.apply(
                                                            void 0,
                                                            argsArray.concat(
                                                              [line],
                                                              [i]
                                                            )
                                                          )
                                                        }
                                                      }
                                                    }),
                                                    _vm._v(" "),
                                                    _vm.header.can.edit &&
                                                    line.request_line_id
                                                      ? _c(
                                                          "button",
                                                          {
                                                            staticClass:
                                                              "btn btn-outline btn-xs mb-0",
                                                            attrs: {
                                                              type: "button",
                                                              title:
                                                                "ยกเลิกแก้ไข"
                                                            },
                                                            on: {
                                                              click: function(
                                                                $event
                                                              ) {
                                                                $event.preventDefault()
                                                                line.is_edit_item = false
                                                              }
                                                            }
                                                          },
                                                          [
                                                            _c("i", {
                                                              staticClass:
                                                                "fa fa-refresh"
                                                            })
                                                          ]
                                                        )
                                                      : _vm._e()
                                                  ]
                                            ],
                                            2
                                          )
                                        ]
                                  ],
                                  2
                                ),
                                _vm._v(" "),
                                _c("td", {}, [
                                  _vm._v(_vm._s(line.description))
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-right" }, [
                                  _c("div", { staticClass: "input-group " }, [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model.number",
                                          value: line.cgc_quantity,
                                          expression: "line.cgc_quantity",
                                          modifiers: { number: true }
                                        }
                                      ],
                                      staticClass: "form-control text-right",
                                      attrs: {
                                        type: "text",
                                        disabled:
                                          !_vm.header.can.edit ||
                                          !line.inventory_item_id
                                      },
                                      domProps: { value: line.cgc_quantity },
                                      on: {
                                        focus: function() {
                                          line.cgc_quantity = line.cgc_quantity.replaceAll(
                                            ",",
                                            ""
                                          )
                                        },
                                        focusout: function($event) {
                                          return _vm.handleFocusoutCgc(line)
                                        },
                                        change: function($event) {
                                          return _vm.changeQty(
                                            line,
                                            "cgc_quantity"
                                          )
                                        },
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            line,
                                            "cgc_quantity",
                                            _vm._n($event.target.value)
                                          )
                                        },
                                        blur: function($event) {
                                          return _vm.$forceUpdate()
                                        }
                                      }
                                    })
                                  ])
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-right" }, [
                                  _c("div", { staticClass: "input-group " }, [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model.number",
                                          value: line.cgk_quantity,
                                          expression: "line.cgk_quantity",
                                          modifiers: { number: true }
                                        }
                                      ],
                                      staticClass: "form-control text-right",
                                      attrs: {
                                        type: "text",
                                        disabled:
                                          !_vm.header.can.edit ||
                                          !line.inventory_item_id
                                      },
                                      domProps: { value: line.cgk_quantity },
                                      on: {
                                        focus: function() {
                                          line.cgk_quantity = line.cgk_quantity.replaceAll(
                                            ",",
                                            ""
                                          )
                                        },
                                        focusout: function() {
                                          line.cgk_quantity = _vm.numberWithCommas(
                                            line.cgk_quantity
                                          )
                                        },
                                        change: function($event) {
                                          return _vm.changeQty(
                                            line,
                                            "cgk_quantity"
                                          )
                                        },
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            line,
                                            "cgk_quantity",
                                            _vm._n($event.target.value)
                                          )
                                        },
                                        blur: function($event) {
                                          return _vm.$forceUpdate()
                                        }
                                      }
                                    })
                                  ])
                                ])
                              ])
                            : _vm._e()
                        }),
                        0
                      )
                    ]
                  )
                ])
              ]),
              _vm._v(" "),
              _vm.lines.length === 0
                ? _c("div", { staticClass: "text-center" }, [
                    _c("span", { staticClass: "lead" }, [_vm._v("No Data.")])
                  ])
                : _vm._e()
            ])
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
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-12" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { width: "10px;" } }),
        _vm._v(" "),
        _c(
          "th",
          {
            staticStyle: { "text-align": "center" },
            attrs: { width: "150px" }
          },
          [
            _vm._v(
              "\n                               \n                                รหัสสินค้าสำเร็จรูป\n                                \n                            "
            )
          ]
        ),
        _vm._v(" "),
        _c("th", { staticStyle: { "text-align": "center" } }, [
          _vm._v("รายละเอียด")
        ]),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "text-align": "center" },
            attrs: { width: "250px" }
          },
          [
            _vm._v(
              "\n                                จำนวน(หีบ)\n                            "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "text-align": "center" },
            attrs: { width: "250px" }
          },
          [
            _vm._v(
              "\n                                จำนวน(พันมวน)\n                            "
            )
          ]
        )
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=template&id=60201e10&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/ModalSearch.vue?vue&type=template&id=60201e10& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
                  _c("div", { staticClass: "row col-12" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ใบส่งเลขที่ :")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "input-group " }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wipRequestNo,
                                expression: "wipRequestNo"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: {
                              id: "lb-2",
                              type: "text",
                              name: "wip_request_no"
                            },
                            domProps: { value: _vm.wipRequestNo },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.wipRequestNo = $event.target.value
                              }
                            }
                          })
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group text-right  pr-2 mb-0 col-lg-6 col-md-10 col-sm-12 col-xs-12"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass: " tw-font-bold tw-uppercase mt-2 mb-1"
                          },
                          [_vm._v(" ")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "text-left" }, [
                          _c(
                            "button",
                            {
                              class:
                                _vm.transBtn.search.class + " btn-lg tw-w-25",
                              attrs: { type: "button" },
                              on: { click: _vm.searchForm }
                            },
                            [
                              _c("i", { class: _vm.transBtn.search.icon }),
                              _vm._v(
                                "\n                                    " +
                                  _vm._s(_vm.transBtn.search.text) +
                                  "\n                                "
                              )
                            ]
                          )
                        ])
                      ]
                    )
                  ]),
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
                              _c("td", [
                                _vm._v(_vm._s(reqHeader.mfg_order_number))
                              ]),
                              _vm._v(" "),
                              _c("td", { staticClass: "text-center" }, [
                                _vm._v(_vm._s(reqHeader.status.description))
                              ]),
                              _vm._v(" "),
                              _c("td", [
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
        _vm._v("ค้นหารายการแจ้งยอดประมาณการจัดเก็บบุหรี่")
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
        _c("th", [_vm._v("ใบส่งเลขที่")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "200px" } }, [
          _vm._v("สถานะขอเบิก")
        ]),
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=template&id=5ec7d268&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/send-cigarettes/SearchItem.vue?vue&type=template&id=5ec7d268& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
          ref: "selected_" + _vm.i,
          attrs: {
            filterable: "",
            remote: "",
            placeholder: "รหัสวัตถุดิบ",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading
          },
          on: { change: _vm.itemWasSelected },
          model: {
            value: _vm.itemId,
            callback: function($$v) {
              _vm.itemId = $$v
            },
            expression: "itemId"
          }
        },
        _vm._l(_vm.items, function(item, index) {
          return _c("el-option", {
            key: parseInt(item.inventory_item_id),
            attrs: {
              label: item.display,
              value: parseInt(item.inventory_item_id)
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



/***/ })

}]);