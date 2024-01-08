(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_products_transfers_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/DatepickerTh.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/DatepickerTh.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
// import helpers from './../helpers.js'



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["value", "name", "id", "inputClass", "placeholder", "disabledDateTo", "format", "pType"],
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
                if (_value) {
                  this.date = _value ? moment__WEBPACK_IMPORTED_MODULE_3___default()(_value, this.format).toDate() : null;
                } else {
                  this.date = null;
                }

              case 1:
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
      defaultDate: this.value ? moment__WEBPACK_IMPORTED_MODULE_3___default()(this.value, this.format).toDate() : moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, 'years').toDate(),
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
      this.date = date;
      this.$emit("dateWasSelected", date);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/Index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/Index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _ModalSearchHeader_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalSearchHeader.vue */ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue");
/* harmony import */ var _DatepickerTh__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../DatepickerTh */ "./resources/js/components/pm/DatepickerTh.vue");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    ModalSearchHeader: _ModalSearchHeader_vue__WEBPACK_IMPORTED_MODULE_5__.default,
    DatepickerTh: _DatepickerTh__WEBPACK_IMPORTED_MODULE_6__.default,
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: ["pUrl", "organizationCode", "transferNumberValue", "transferDateValue", "profile", "transBtn", "transferObjectives", "transferObjectiveValue", "locators", "toLocatorIdValue", "deptCodes", "requestStatuses"],
  computed: {},
  watch: {
    transferInvItemLines: function transferInvItemLines(val, oldVal) {
      this.checkConversItem();
    }
  },
  data: function data() {
    return {
      isLoading: false,
      transferNumber: this.transferNumberValue ? this.transferNumberValue : '',
      transferDate: this.transferDateValue ? moment__WEBPACK_IMPORTED_MODULE_4___default()(this.transferDateValue, 'DD/MM/YYYY').toDate() : moment__WEBPACK_IMPORTED_MODULE_4___default()().add(543, 'years').toDate(),
      transferDateFormatted: this.transferDateValue ? this.transferDateValue : this.getDateFormatted(moment__WEBPACK_IMPORTED_MODULE_4___default()().add(543, 'years').toDate()),
      transferObjective: this.transferObjectiveValue ? this.transferObjectiveValue : this.transferObjectives[0].lookup_code,
      transferObjectiveLabel: this.getTransObjectiveLabel(this.transferObjectives, this.transferObjectiveValue ? this.transferObjectiveValue : this.transferObjectives[0].lookup_code),
      inputToLocator: this.locators,
      toLocatorId: this.toLocatorIdValue ? this.toLocatorIdValue : null,
      toLocatorDesc: this.toLocatorIdValue ? this.getLocatorDesc(this.locators, this.toLocatorIdValue) : '',
      invItems: [],
      availableInvItems: [],
      transferHeader: null,
      transferInvItemLines: [],
      confirmInvItems: [],
      transactionItems: [],
      availableTransactionItems: [],
      // Report
      reportUrl: ''
    };
  },
  beforeMount: function beforeMount() {},
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (!_this.transferNumber) {
                _context.next = 13;
                break;
              }

              _context.next = 3;
              return _this.findHeader();

            case 3:
              if (!_this.transferHeader) {
                _context.next = 12;
                break;
              }

              _context.next = 6;
              return _this.getLines();

            case 6:
              _context.next = 8;
              return _this.getConfirmItems(false);

            case 8:
              _context.next = 10;
              return _this.checkConversItem();

            case 10:
              _context.next = 13;
              break;

            case 12:
              swal({
                title: "ไม่พบข้อมูล",
                type: "warning",
                text: "\u0E43\u0E1A\u0E2A\u0E48\u0E07\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48 : ".concat(_this.transferNumber),
                confirmButtonClass: "btn-primary",
                confirmButtonText: "รับทราบ",
                showCancelButton: false,
                closeOnConfirm: true
              }, function () {
                var rootUrl = _this.pUrl.index.substr(0, _this.pUrl.index.lastIndexOf("?"));

                location.href = rootUrl;
              });

            case 13:
              _this.setReportUrlParams();

            case 14:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("transfer_number", this.transferNumber ? this.transferNumber : ''); // queryParams.set("product_date", this.productDateFormatted ? this.productDateFormatted : '');

      queryParams.set("transfer_date", this.transferDateFormatted ? this.transferDateFormatted : ''); // queryParams.set("to_department_code", this.toDepartmentCode ? this.toDepartmentCode : '');

      queryParams.set("to_locator_id", this.toLocatorId ? this.toLocatorId : '');
      this.setReportUrlParams();
    },
    setReportUrlParams: function setReportUrlParams() {
      var vm = this;
      var transferNumber = this.transferNumber ? this.transferNumber : '';
      var transferDateFormatted = this.transferDateFormatted ? this.transferDateFormatted : '';
      var toLocatorId = this.toLocatorId ? this.toLocatorId : '';
      vm.reportUrl = '';

      if (transferNumber && toLocatorId) {
        vm.reportUrl = window.location.origin + window.location.pathname;
        vm.reportUrl = vm.reportUrl + '?transfer_number=' + transferNumber;
        vm.reportUrl = vm.reportUrl + '&transfer_date=' + transferDateFormatted;
        vm.reportUrl = vm.reportUrl + '&to_locator_id=' + toLocatorId;
        vm.reportUrl = vm.reportUrl + '&report=pdf';
      }
    },
    // ############################
    // ON EVENT HAPPENED
    onSearchRequestHeader: function onSearchRequestHeader(data) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.transferHeader = data.transferHeader;

                if (!data.transferHeader) {
                  _context2.next = 14;
                  break;
                }

                _this2.transferNumber = _this2.transferHeader.transfer_number;
                _this2.toLocatorId = _this2.transferHeader ? _this2.transferHeader.attribute11 : _this2.toLocatorId;
                _this2.transferObjective = _this2.transferHeader.transaction_type;
                _this2.transferDate = moment__WEBPACK_IMPORTED_MODULE_4___default()(_this2.transferHeader.transfer_date).add(543, 'years').toDate();
                _this2.transferDateFormatted = _this2.getDateFormatted(_this2.transferDate); // GET HEADER
                // if(this.productDate) {

                _context2.next = 9;
                return _this2.findHeader();

              case 9:
                _context2.next = 11;
                return _this2.getLines();

              case 11:
                _context2.next = 13;
                return _this2.getConfirmItems();

              case 13:
                // }
                _this2.setUrlParams();

              case 14:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onTransferInvItemChanged: function onTransferInvItemChanged(inventoryItemId, transferInvItemLine, index) {
      var _this3 = this;

      var previousInventoryItemId = transferInvItemLine.inventory_item_id;
      var previousItemNumber = transferInvItemLine.item_number; // VALIDATE BEFORE CHANGED
      // ## CASE : NORMAL

      var newItem = this.invItems.find(function (invItem) {
        return inventoryItemId == invItem.inventory_item_id;
      });
      var foundAvailableItem = this.availableInvItems.find(function (availableInvItem) {
        return inventoryItemId == availableInvItem.inventory_item_id;
      });
      var foundAvailableItemLines = this.transferInvItemLines.filter(function (o, idx) {
        if (index != idx) {
          return inventoryItemId == o.inventory_item_id;
        }
      });
      transferInvItemLine.inventory_item_id = inventoryItemId;

      if (foundAvailableItemLines.length > 0) {
        swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E43\u0E0A\u0E49 \u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B \u0E0B\u0E49\u0E33\u0E01\u0E31\u0E19\u0E44\u0E14\u0E49 ( \u0E23\u0E2B\u0E31\u0E2A\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B : ".concat(newItem.item_number, ")"), "error");
        this.$nextTick(function () {
          transferInvItemLine.inventory_item_id = previousInventoryItemId == null ? "" : previousInventoryItemId == "" ? null : previousInventoryItemId;
        });
      } else {
        this.$nextTick(function () {
          console.log("onTransferInvItemChanged ---------->", newItem);
          transferInvItemLine.item_number = newItem.item_number;
          transferInvItemLine.item_desc = newItem.item_desc;
          transferInvItemLine.organization_id = newItem.organization_id;
          transferInvItemLine.organization_id_from = newItem.organization_id_from;
          transferInvItemLine.transaction_qty = newItem.transaction_qty;
          transferInvItemLine.transaction_uom = newItem.transaction_uom;
          transferInvItemLine.uom_code = newItem.uom_code;
          transferInvItemLine.unit_of_measure = newItem.unit_of_measure;
          transferInvItemLine.convert_flag = newItem.convert_flag;
          transferInvItemLine.destination_organization_id = newItem.destination_organization_id;
          transferInvItemLine.destination_locator_id = newItem.destination_locator_id;
          transferInvItemLine.locators = newItem.locators;

          _this3.checkConversItem();
        });
      }
    },
    onAddNewLine: function onAddNewLine() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var newtransferInvItemLine, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                newtransferInvItemLine = _this4.availableInvItems.length > 0 ? _this4.availableInvItems[0] : null;

                if (newtransferInvItemLine) {
                  // ## CASE : NORMAL
                  _this4.transferInvItemLines = [].concat(_toConsumableArray(_this4.transferInvItemLines), [_objectSpread({}, newtransferInvItemLine)]);
                }

                reqBody = {
                  transfer_header: JSON.stringify(_this4.transferHeader),
                  transfer_inv_item_line: JSON.stringify(newtransferInvItemLine)
                }; // SHOW LOADING

                _this4.isLoading = true;
                _this4.availableInvItems = _this4.getAvailableInvItems(_this4.invItems, _this4.transferInvItemLines); // HIDE LOADING

                _this4.isLoading = false;

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onDeleteLine: function onDeleteLine(transferInvItemLines, transferInvItemLine, index) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var text;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (index == 0) {
                  // ลบรายการแรก ที่เป็น
                  text = "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 ".concat(transferInvItemLine.item_desc ? transferInvItemLine.item_desc : "", " ?");

                  if (_this5.transferInvItemLines.length > 1) {
                    text = "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 ".concat(transferInvItemLine.item_desc ? transferInvItemLine.item_desc : "", " ? (\u0E2B\u0E32\u0E01\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E41\u0E23\u0E01\u0E23\u0E30\u0E1A\u0E1A\u0E08\u0E30\u0E17\u0E33\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14)");
                  }

                  swal({
                    title: "",
                    text: text,
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "ลบ",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                  }, function (isConfirm) {
                    if (isConfirm) {
                      _this5.transferInvItemLines = [];
                    }
                  });
                } else {
                  swal({
                    title: "",
                    text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 ".concat(transferInvItemLine.item_desc ? transferInvItemLine.item_desc : "", " ?"),
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "ลบ",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                  }, function (isConfirm) {
                    if (isConfirm) {
                      // transferInvItemLine.marked_as_deleted = true;
                      var foundIndex = _this5.transferInvItemLines.findIndex(function (item) {
                        return item == transferInvItemLine;
                      });

                      _this5.transferInvItemLines.splice(foundIndex, 1);

                      _this5.availableInvItems = _this5.getAvailableInvItems(_this5.invItems, _this5.transferInvItemLines);
                    }
                  });
                }

                _this5.checkConversItem();

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onTransObjectiveWasChanged: function onTransObjectiveWasChanged(value) {
      this.transferObjective = value;
      this.transferObjectiveLabel = this.getTransObjectiveLabel(this.transferObjectives, this.transferObjective);
      this.setUrlParams();
    },
    onToLocatorWasChanged: function onToLocatorWasChanged(value) {
      this.toLocatorId = value;
      this.toLocatorDesc = this.getLocatorDesc(this.locators, value);
      this.setUrlParams();
    },
    onTransferDateWasSelected: function onTransferDateWasSelected(value) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this6.transferDate = value;
                _this6.transferDateFormatted = _this6.getDateFormatted(_this6.transferDate);
                _this6.confirmInvItems = [];
                _this6.transactionItems = [];
                _this6.invItems = [];
                _this6.availableInvItems = [];
                _this6.availableTransactionItems = [];
                _this6.transferInvItemLines = [];

                _this6.setUrlParams();

              case 9:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    onCreateNew: function onCreateNew() {
      var rootUrl = this.pUrl.index.substr(0, this.pUrl.index.lastIndexOf("?"));
      location.href = rootUrl;
    },
    onGetConfirmItems: function onGetConfirmItems() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return _this7.getConfirmItems();

              case 2:
                // AUTO RECONCILE LINE ITEMS
                if (_this7.transferInvItemLines.length > 0) {
                  _this7.$nextTick(function () {
                    _this7.transferInvItemLines.map(function (transferInvItemLine) {
                      var foundConfirmInvItem = _this7.confirmInvItems.find(function (citem) {
                        return citem.inventory_item_id == transferInvItemLine.inventory_item_id;
                      });

                      transferInvItemLine.transaction_qty = foundConfirmInvItem.transaction_qty;
                      return transferInvItemLine;
                    });
                  });
                }

              case 3:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getDateFormatted: function getDateFormatted(date) {
      return moment__WEBPACK_IMPORTED_MODULE_4___default()(date).format("DD/MM/YYYY");
    },
    onSave: function onSave() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _context7.next = 2;
                return _this8.saveHeader();

              case 2:
                _context7.next = 4;
                return _this8.saveLines();

              case 4:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    findHeader: function findHeader() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                // SHOW LOADING
                _this9.isLoading = true;
                params = {
                  transfer_number: _this9.transferNumber
                };
                _context8.next = 4;
                return axios.get("/ajax/pm/products/transfers/find-header", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this9.transferNumber = _this9.transferHeader ? _this9.transferHeader.transfer_number : _this9.transferNumber;
                    _this9.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : _this9.transferHeader; // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;

                    _this9.toLocatorId = _this9.transferHeader ? _this9.transferHeader.attribute11 : _this9.toLocatorId;
                  } else {
                    swal("เกิดข้อผิดพลาด", "".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "".concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this9.isLoading = false; // if(this.transferHeader) {
                // IF FOUND HEADER
                // => GET LINES
                // await this.getLines();
                // }

              case 5:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    validateBeforeSaveHeader: function validateBeforeSaveHeader(transferHeader) {
      var result = {
        valid: true,
        message: ""
      };
      return result;
    },
    saveHeader: function saveHeader() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                reqBody = {
                  transfer_number: _this10.transferNumber,
                  // product_date: this.productDateFormatted,
                  transfer_date: _this10.transferDateFormatted,
                  transfer_objective: _this10.transferObjective,
                  to_locator_id: _this10.toLocatorId,
                  // to_department_code: this.toDepartmentCode,
                  transfer_header: JSON.stringify(_this10.transferHeader)
                }; // SHOW LOADING

                _this10.isLoading = true;
                resValidate = _this10.validateBeforeSaveHeader(_this10.transferHeader);

                if (!resValidate.valid) {
                  _context9.next = 8;
                  break;
                }

                _context9.next = 6;
                return axios.post("/ajax/pm/products/transfers/store-header", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this10.isNewlyCreate = false;
                    _this10.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : _this10.transferHeader;
                    _this10.transferNumber = _this10.transferHeader ? _this10.transferHeader.transfer_number : _this10.transferNumber; // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;

                    _this10.toLocatorId = _this10.transferHeader ? _this10.transferHeader.attribute11 : _this10.toLocatorId;

                    if (_this10.transferNumber) {
                      _this10.setUrlParams();
                    }
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "".concat(error.message), "error");
                });

              case 6:
                _context9.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "".concat(resValidate.message), "error");

              case 9:
                // HIDE LOADING
                _this10.isLoading = false;

              case 10:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    validateBeforeSaveLines: function validateBeforeSaveLines(transferHeader, transferInvItemLines) {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                result = {
                  valid: true,
                  message: ""
                }; // // IF NEW LINE ISN'T COMPLETED
                // const incompletedLines = transferInvItemLines.filter(item => {
                //     return item.is_new_line && (
                //         !item.inventory_item_id ||
                //         !item.transaction_qty
                //     ) && item.marked_as_deleted == false;
                // });
                // if(incompletedLines.length > 0) {
                //     result.valid = false;
                //     result.message = `กรอกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักรไม่ครบถ้วน กรุณาตรวจสอบ`
                // }

                return _context10.abrupt("return", result);

              case 2:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    saveLines: function saveLines() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                reqBody = {
                  transfer_number: _this11.transferNumber,
                  // product_date: this.productDateFormatted,
                  transfer_date: _this11.transferDateFormatted,
                  transfer_objective: _this11.transferObjective,
                  to_locator_id: _this11.toLocatorId,
                  // to_department_code: this.toDepartmentCode,
                  transfer_header: JSON.stringify(_this11.transferHeader),
                  transfer_inv_item_lines: JSON.stringify(_this11.transferInvItemLines)
                }; // SHOW LOADING

                _this11.isLoading = true;
                _context11.next = 4;
                return _this11.validateBeforeSaveLines(_this11.transferHeader, _this11.transferInvItemLines);

              case 4:
                resValidate = _context11.sent;

                if (!resValidate.valid) {
                  _context11.next = 10;
                  break;
                }

                _context11.next = 8;
                return axios.post("/ajax/pm/products/transfers/store-lines", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this11.isNewlyCreate = false;
                    _this11.transferInvItemLines = resData.transfer_inv_item_lines ? JSON.parse(resData.transfer_inv_item_lines) : [];
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this11.transferNumber, " "), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this11.transferNumber, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this11.transferNumber, " | ").concat(error.message), "error");
                });

              case 8:
                _context11.next = 11;
                break;

              case 10:
                swal("เกิดข้อผิดพลาด", "\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this11.transferNumber, " | ").concat(resValidate.message), "error");

              case 11:
                // HIDE LOADING
                _this11.isLoading = false;

              case 12:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    // async validateBeforeConfirmRequest(transferHeader, transferInvItemLines) {
    //     const result = {
    //         valid: true,
    //         message: "",
    //     };
    //     // VALIDATE CANNOT ENTER TRANSACTION_QTY > ONHAND_QTY
    //     const onhandInvItemLines = await this.getOnhands(transferHeader, transferInvItemLines);
    //     if(onhandInvItemLines) {
    //         const overOnhandQtyLines = transferInvItemLines.filter(item => {
    //             const foundOnhandItem = onhandInvItemLines.find(ohItem => item.inventory_item_id == ohItem.inventory_item_id);
    //             console.log("item.item_number : ", item.item_number ,"item.transaction_qty : ", item.transaction_qty, "foundOnhandItem.onhand_qty : ", foundOnhandItem.onhand_qty, " Result : ", Number(parseFloat(item.transaction_qty).toFixed(2)) > Number(parseFloat(foundOnhandItem.onhand_qty).toFixed(2)));
    //             return Number(parseFloat(item.transaction_qty).toFixed(2)) > Number(parseFloat(foundOnhandItem.onhand_qty).toFixed(2));
    //         });
    //         console.log(overOnhandQtyLines);
    //         if(overOnhandQtyLines.length > 0) {
    //             const foundItemNumbers = overOnhandQtyLines.map(item => item.item_number);
    //             result.valid = false;
    //             result.message = `ไม่สามารถกรอก จำนวนส่งเข้าคลังได้มากกว่า จำนวน onhand กรุณาตรวจสอบ ( รหัสสินค้าสำเร็จรูป : ${foundItemNumbers.join(", ")} )`;
    //         }
    //     }
    //     return result;
    // },
    // async getOnhands(transferHeader, transferInvItemLines) {
    //     let onhandInvItemLines = [];
    //     // SHOW LOADING
    //     this.isLoading = true;
    //     var params = { 
    //         transfer_header: JSON.stringify(transferHeader),
    //         transfer_inv_item_lines: JSON.stringify(transferInvItemLines)
    //     };
    //     await axios.get(`/ajax/pm/products/transfers/get-onhands`, { params })
    //     .then(res => {
    //         const resData = res.data.data;
    //         if(resData.status == "success") {
    //             onhandInvItemLines = resData.onhand_inv_item_lines ? JSON.parse(resData.onhand_inv_item_lines) : [];
    //         } else {
    //             swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล onhand | ${resData.message}`, "error");                    
    //             onhandInvItemLines = [];
    //         }
    //         return resData;
    //     }).catch((error) => {
    //         console.log(error);
    //         swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล onhand | ${error.message}`, "error");
    //     });
    //     // HIDE LOADING
    //     this.isLoading = false;
    //     return onhandInvItemLines;
    // },
    confirmRequest: function confirmRequest() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                reqBody = {
                  transfer_header: JSON.stringify(_this12.transferHeader)
                }; // SHOW LOADING

                _this12.isLoading = true; // const resValidate = await this.validateBeforeConfirmRequest(this.transferHeader, this.transferInvItemLines);
                // if(resValidate.valid) {

                _context12.next = 4;
                return axios.post("/ajax/pm/products/transfers/confirm-request", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this12.isNewlyCreate = false;
                    _this12.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : _this12.transferHeader;
                    _this12.transferNumber = _this12.transferHeader ? _this12.transferHeader.transfer_number : _this12.transferNumber; // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;

                    _this12.toLocatorId = _this12.transferHeader ? _this12.transferHeader.attribute11 : _this12.toLocatorId;
                    swal("Success", "\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E2A\u0E48\u0E07\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this12.transferNumber, " "), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E2A\u0E48\u0E07\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this12.transferNumber, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E2A\u0E48\u0E07\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this12.transferNumber, " | ").concat(error.message), "error");
                });

              case 4:
                // } else {
                //     swal("เกิดข้อผิดพลาด", `ไม่สามารถยืนยันส่งสินค้าสำเร็จรูป เลขที่ใบส่ง : ${this.transferNumber} | ${resValidate.message}`, "error");
                // }
                // HIDE LOADING
                _this12.isLoading = false;

              case 5:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    discardConfirmedRequest: function discardConfirmedRequest() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                reqBody = {
                  transfer_number: _this13.transferNumber,
                  transfer_header: JSON.stringify(_this13.transferHeader)
                }; // SHOW LOADING

                _this13.isLoading = true;
                _context13.next = 4;
                return axios.post("/ajax/pm/products/transfers/discard-confirmed-request", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this13.isNewlyCreate = false;
                    _this13.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : _this13.transferHeader;
                    _this13.transferNumber = _this13.transferHeader ? _this13.transferHeader.transfer_number : _this13.transferNumber; // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;

                    _this13.toLocatorId = _this13.transferHeader ? _this13.transferHeader.attribute11 : _this13.toLocatorId;
                    swal("Success", "\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this13.transferNumber, " "), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this13.transferNumber, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this13.transferNumber, " | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this13.isLoading = false;

              case 5:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    cancelRequest: function cancelRequest() {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                reqBody = {
                  transfer_number: _this14.transferNumber,
                  transfer_header: JSON.stringify(_this14.transferHeader)
                }; // SHOW LOADING

                _this14.isLoading = true;
                _context14.next = 4;
                return axios.post("/ajax/pm/products/transfers/cancel-request", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this14.isNewlyCreate = false;
                    _this14.transferHeader = resData.transfer_header ? JSON.parse(resData.transfer_header) : _this14.transferHeader;
                    _this14.transferNumber = _this14.transferHeader ? _this14.transferHeader.transfer_number : _this14.transferNumber; // this.toDepartmentCode = this.transferHeader ? this.transferHeader.attribute10 : this.toDepartmentCode;

                    _this14.toLocatorId = _this14.transferHeader ? _this14.transferHeader.attribute11 : _this14.toLocatorId;
                    swal("Success", "\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this14.transferNumber, " "), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this14.transferNumber, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E43\u0E1A\u0E2A\u0E48\u0E07 : ".concat(_this14.transferNumber, " | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this14.isLoading = false;

              case 5:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    getConfirmItems: function getConfirmItems() {
      var _arguments = arguments,
          _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var showAlert, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                showAlert = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : true;
                // SHOW LOADING
                _this15.isLoading = true;
                params = {
                  transfer_date: _this15.transferDateFormatted
                };
                _context15.next = 5;
                return axios.get("/ajax/pm/products/transfers/get-confirm-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this15.confirmInvItems = resData.confirm_inv_items ? JSON.parse(resData.confirm_inv_items) : [];
                    _this15.transactionItems = resData.transaction_items ? JSON.parse(resData.transaction_items) : [];
                    _this15.invItems = _this15.confirmInvItems.map(function (item) {
                      return item;
                    });
                    _this15.availableInvItems = _this15.getAvailableInvItems(_this15.invItems, _this15.transferInvItemLines);

                    if (_this15.confirmInvItems.length <= 0) {
                      if (showAlert) {
                        swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48\u0E2A\u0E48\u0E07\u0E1C\u0E25\u0E1C\u0E25\u0E34\u0E15 ".concat(_this15.transferDateFormatted), "info");
                      }
                    }
                  } else {
                    swal("เกิดข้อผิดพลาด", "".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "".concat(error.message), "error");
                });

              case 5:
                // HIDE LOADING
                _this15.isLoading = false;

              case 6:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    getLines: function getLines() {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                // SHOW LOADING
                _this16.isLoading = true;
                params = {
                  transfer_number: _this16.transferNumber
                };
                _context16.next = 4;
                return axios.get("/ajax/pm/products/transfers/get-lines", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this16.transferInvItemLines = resData.transfer_inv_item_lines ? JSON.parse(resData.transfer_inv_item_lines) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "".concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this16.isLoading = false;

              case 5:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16);
      }))();
    },
    getAvailableInvItems: function getAvailableInvItems(invItems, transferInvItemLines) {
      var availableInvItems = []; // ## CASE : NORMAL

      availableInvItems = invItems.filter(function (invItem) {
        var foundInvItem = transferInvItemLines.find(function (transferInvItemLine) {
          return invItem.inventory_item_id == transferInvItemLine.inventory_item_id;
        });
        return !foundInvItem;
      });
      return availableInvItems;
    },
    getAvailableTransactionItems: function getAvailableTransactionItems(transactionItems, transferInvItemLines) {
      var availableTransactionItems = [];
      return availableTransactionItems;
    },
    // ############################
    // GET DESCRIPTION
    getTransObjectiveLabel: function getTransObjectiveLabel(transferObjectives, transferObjective) {
      var foundTransObjective = transferObjectives.find(function (item) {
        return item.lookup_code == transferObjective;
      });
      return foundTransObjective ? foundTransObjective.description : "";
    },
    getLocatorDesc: function getLocatorDesc(locators, locatorId) {
      var foundLocator = locators.find(function (item) {
        return item.locator_id == locatorId;
      });
      return foundLocator ? foundLocator.locator_full_desc : "";
    },
    getDepartmentDesc: function getDepartmentDesc(deptCodes, departmentCode) {
      var foundDept = deptCodes.find(function (item) {
        return item.department_code == departmentCode;
      });
      return foundDept ? foundDept.department_desc : "";
    },
    getTransferStatusDesc: function getTransferStatusDesc(transferHeader) {
      var statusDesc = "";
      var requestStatus = transferHeader ? transferHeader.transfer_status : "";

      if (requestStatus) {
        var foundTransferStatus = this.requestStatuses.find(function (item) {
          return item.lookup_code == requestStatus;
        });

        if (foundTransferStatus) {
          statusDesc = foundTransferStatus.description;
        }
      }

      return statusDesc;
    },
    // ############################
    // PERMISSION DEFINED FUNTIONS
    isAllowAddNewLine: function isAllowAddNewLine(transferHeader) {
      var allowed = true; // ## CASE : NORMAL

      if (!transferHeader) {
        if (this.availableInvItems.length <= 0) {
          allowed = false;
        }
      } else {
        if (transferHeader.transfer_status != "1") {
          allowed = false;
        }

        if (this.availableInvItems.length <= 0) {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowDeleteLine: function isAllowDeleteLine(transferHeader) {
      var allowed = true;

      if (transferHeader) {
        if (transferHeader.transfer_status != "1") {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowCreateNewTransfer: function isAllowCreateNewTransfer(transferHeader) {
      var allowed = true; // if(!transferHeader) {
      //     allowed = true;
      // } else {
      //     // IF HEADER STATUS == 1 (NEW)
      //     if(transferHeader.transfer_status == "1") {
      //         allowed = true;
      //     }else{
      //         allowed = true;
      //     }
      // }

      return allowed;
    },
    isAllowGetConfirmItems: function isAllowGetConfirmItems(transferHeader) {
      var allowed = true;

      if (!transferHeader) {
        allowed = true;
      } else {
        // IF HEADER STATUS == 1 (NEW)
        if (transferHeader.transfer_status == "1") {
          allowed = true;
        } else {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowUpdateTransfer: function isAllowUpdateTransfer(transferHeader) {
      var allowed = true;

      if (!transferHeader) {
        allowed = true;
      } else {
        // IF HEADER STATUS == 1 (NEW)
        if (transferHeader.transfer_status == "1") {
          allowed = true;
        } else {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowConfirmTransfer: function isAllowConfirmTransfer(transferHeader) {
      var allowed = true;

      if (!transferHeader) {
        allowed = false;
      } else {
        // IF HEADER STATUS == 1 (NEW)
        if (transferHeader.transfer_status == "1") {
          allowed = true;
        } else {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowDiscardTransfer: function isAllowDiscardTransfer(transferHeader) {
      var allowed = true;

      if (!transferHeader) {
        allowed = false;
      } else {
        // IF HEADER STATUS == 1 (NEW)
        if (transferHeader.transfer_status == "1") {
          allowed = false;
        } // IF HEADER STATUS == 2 (COMFIRMED)


        if (transferHeader.transfer_status == "2") {
          allowed = true;
        } // IF HEADER STATUS == 3 (WMS COMFIRMED)


        if (transferHeader.transfer_status == "3") {
          allowed = false;
        } // IF HEADER STATUS == 4 (CANCELLED)


        if (transferHeader.transfer_status == "4") {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowCancelTransfer: function isAllowCancelTransfer(transferHeader) {
      var allowed = true;

      if (!transferHeader) {
        allowed = false;
      } else {
        // IF HEADER STATUS == 1 (NEW)
        if (transferHeader.transfer_status == "1") {
          allowed = true;
        } // IF HEADER STATUS == 2 (COMFIRMED)


        if (transferHeader.transfer_status == "2") {
          allowed = true;
        } // IF HEADER STATUS == 3 (WMS COMFIRMED)


        if (transferHeader.transfer_status == "3") {
          allowed = false;
        } // IF HEADER STATUS == 4 (CANCELLED)


        if (transferHeader.transfer_status == "4") {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowInputTransactionQty: function isAllowInputTransactionQty(transferHeader) {
      var allowed = true; // ## CASE : NORMAL

      allowed = false;
      return allowed;
    },
    checkConversItem: function checkConversItem() {
      var _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee17() {
        var vm, firstLine, foundLocator;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                vm = _this17;
                firstLine = vm.transferInvItemLines[0]; // ## CASE : NORMAL

                vm.availableInvItems = vm.getAvailableInvItems(vm.invItems, vm.transferInvItemLines);
                vm.inputToLocator = vm.locators;

                if (vm.transferInvItemLines.length == 1) {
                  // เมื่อเพิ่มรายการแรก
                  console.log("seq: 1", firstLine);
                  vm.invItems = vm.confirmInvItems.map(function (item) {
                    return item;
                  });
                  vm.availableInvItems = vm.availableInvItems.filter(function (item) {
                    return item.convert_flag == firstLine.convert_flag && item.destination_organization_id == firstLine.destination_organization_id;
                  });
                  console.log("e seq: 1", vm.availableInvItems);

                  if (firstLine.convert_flag == 'Y') {
                    console.log('===========>', firstLine.locators);
                    vm.inputToLocator = firstLine.locators;
                  }
                } else if (vm.transferInvItemLines.length > 1) {
                  console.log("seq: > 1");
                  vm.invItems = vm.invItems.filter(function (item) {
                    return item.convert_flag == firstLine.convert_flag && item.destination_organization_id == firstLine.destination_organization_id;
                  });
                  vm.availableInvItems = vm.availableInvItems.filter(function (item) {
                    return item.convert_flag == firstLine.convert_flag && item.destination_organization_id == firstLine.destination_organization_id;
                  });
                } //  else if (vm.transferInvItemLines.length == 0) {
                //     console.log("seq: 0")
                // }


                console.log('>>>>>>>>>>>>>>>>>', vm.toLocatorId, vm.inputToLocator);

                if (vm.toLocatorId) {
                  foundLocator = vm.inputToLocator.find(function (o) {
                    return o.locator_id == vm.toLocatorId;
                  });

                  if (!foundLocator) {
                    vm.toLocatorId = '';
                  }

                  console.log("end foundLocator", vm.inputToLocator, foundLocator);
                }

                console.log("end checkConversItem", vm.availableInvItems);

              case 8:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _DatepickerTh__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../DatepickerTh */ "./resources/js/components/pm/DatepickerTh.vue");


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight", "transBtn", "transferDateFromValue", "transferDateToValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    DatepickerTh: _DatepickerTh__WEBPACK_IMPORTED_MODULE_4__.default
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      searchTransferNumber: "",
      transferDateFrom: this.transferDateFromValue ? moment__WEBPACK_IMPORTED_MODULE_3___default()(this.transferDateFromValue).toDate() : null,
      transferDateFromFormatted: this.transferDateFromValue ? this.getDateFormatted(moment__WEBPACK_IMPORTED_MODULE_3___default()(this.transferDateFromValue).toDate()) : null,
      transferDateTo: this.transferDateValue ? moment__WEBPACK_IMPORTED_MODULE_3___default()(this.transferDateValue).toDate() : null,
      transferDateToFormatted: this.transferDateValue ? this.getDateFormatted(moment__WEBPACK_IMPORTED_MODULE_3___default()(this.transferDateValue).toDate()) : null,
      transferHeaders: []
    };
  },
  mounted: function mounted() {},
  computed: {},
  watch: {},
  methods: {
    onTransferDateFromWasSelected: function onTransferDateFromWasSelected(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.transferDateFrom = value;
                _this.transferDateFromFormatted = _this.getDateFormatted(_this.transferDateFrom);

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onTransferDateToWasSelected: function onTransferDateToWasSelected(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.transferDateTo = value;
                _this2.transferDateToFormatted = _this2.getDateFormatted(_this2.transferDateTo);

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getDateFormatted: function getDateFormatted(date) {
      return moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format("DD/MM/YYYY");
    },
    getHeaders: function getHeaders() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // show loading
                _this3.isLoading = true;
                params = {
                  search_transfer_number: _this3.searchTransferNumber,
                  // product_date_from: this.productDateFromFormatted,
                  // product_date_to: this.productDateToFormatted,
                  transfer_date_from: _this3.transferDateFromFormatted,
                  transfer_date_to: _this3.transferDateToFormatted,
                  transfer_objective: _this3.transferObjective
                };
                _context3.next = 4;
                return axios.get("/ajax/pm/products/transfers/get-headers", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this3.transferHeaders = resData.transfer_headers ? JSON.parse(resData.transfer_headers) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25  | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this3.isLoading = false;

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    selectRequestHeader: function selectRequestHeader(transferHeader) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.transferHeaders = [];

                _this4.$modal.hide(_this4.modalName);

                _this4.$emit("onSearchRequestHeader", {
                  transferHeader: transferHeader
                });

              case 3:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-f57e3772] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_style_index_0_id_f57e3772_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_style_index_0_id_f57e3772_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_style_index_0_id_f57e3772_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/pm/DatepickerTh.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/pm/DatepickerTh.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _DatepickerTh_vue_vue_type_template_id_49c7b7c7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DatepickerTh.vue?vue&type=template&id=49c7b7c7& */ "./resources/js/components/pm/DatepickerTh.vue?vue&type=template&id=49c7b7c7&");
/* harmony import */ var _DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DatepickerTh.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/DatepickerTh.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _DatepickerTh_vue_vue_type_template_id_49c7b7c7___WEBPACK_IMPORTED_MODULE_0__.render,
  _DatepickerTh_vue_vue_type_template_id_49c7b7c7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/DatepickerTh.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/products/transfers/Index.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/Index.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_2f4d56f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=2f4d56f7& */ "./resources/js/components/pm/products/transfers/Index.vue?vue&type=template&id=2f4d56f7&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/products/transfers/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_2f4d56f7___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_2f4d56f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/products/transfers/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/ModalSearchHeader.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearchHeader_vue_vue_type_template_id_f57e3772_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true& */ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true&");
/* harmony import */ var _ModalSearchHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearchHeader.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSearchHeader_vue_vue_type_style_index_0_id_f57e3772_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css& */ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSearchHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearchHeader_vue_vue_type_template_id_f57e3772_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearchHeader_vue_vue_type_template_id_f57e3772_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "f57e3772",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/products/transfers/ModalSearchHeader.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/DatepickerTh.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/DatepickerTh.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatepickerTh.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/DatepickerTh.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/products/transfers/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchHeader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css&":
/*!**************************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_style_index_0_id_f57e3772_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=style&index=0&id=f57e3772&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/pm/DatepickerTh.vue?vue&type=template&id=49c7b7c7&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/pm/DatepickerTh.vue?vue&type=template&id=49c7b7c7& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_template_id_49c7b7c7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_template_id_49c7b7c7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DatepickerTh_vue_vue_type_template_id_49c7b7c7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatepickerTh.vue?vue&type=template&id=49c7b7c7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/DatepickerTh.vue?vue&type=template&id=49c7b7c7&");


/***/ }),

/***/ "./resources/js/components/pm/products/transfers/Index.vue?vue&type=template&id=2f4d56f7&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/Index.vue?vue&type=template&id=2f4d56f7& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_2f4d56f7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_2f4d56f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_2f4d56f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=2f4d56f7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/Index.vue?vue&type=template&id=2f4d56f7&");


/***/ }),

/***/ "./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_template_id_f57e3772_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_template_id_f57e3772_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchHeader_vue_vue_type_template_id_f57e3772_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/DatepickerTh.vue?vue&type=template&id=49c7b7c7&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/DatepickerTh.vue?vue&type=template&id=49c7b7c7& ***!
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
  return _c("date-picker", {
    attrs: {
      "input-class": [_vm.inputClass],
      "default-value": _vm.defaultDate,
      "input-attr": { name: _vm.name, id: _vm.id },
      placeholder: _vm.placeholder,
      lang: _vm.lang,
      type: _vm.type,
      "disabled-date": _vm.disabledDate,
      format: _vm.format
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/Index.vue?vue&type=template&id=2f4d56f7&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/Index.vue?vue&type=template&id=2f4d56f7& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "ibox float-e-margins" }, [
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "row tw-mb-2" }, [
            _c("div", { staticClass: "col-12 text-right" }, [
              _c(
                "button",
                {
                  class: _vm.transBtn.search.class + " btn-lg tw-w-40 mr-2",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      return _vm.$modal.show("modal-search-header")
                    }
                  }
                },
                [
                  _c("i", { class: _vm.transBtn.search.icon }),
                  _vm._v(
                    " \n                        " +
                      _vm._s(_vm.transBtn.search.text) +
                      "\n                    "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  class: _vm.transBtn.create.class + " btn-lg tw-w-25 mr-2",
                  attrs: {
                    type: "button",
                    disabled: !_vm.isAllowCreateNewTransfer(_vm.transferHeader)
                  },
                  on: { click: _vm.onCreateNew }
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
                  class: _vm.transBtn.save.class + " btn-lg tw-w-25 mr-2",
                  attrs: {
                    type: "button",
                    disabled: !_vm.isAllowUpdateTransfer(_vm.transferHeader)
                  },
                  on: { click: _vm.onSave }
                },
                [
                  _c("i", { class: _vm.transBtn.save.icon }),
                  _vm._v(
                    "\n                        " +
                      _vm._s(_vm.transBtn.save.text) +
                      "\n                    "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary btn-lg tw-w-48 mr-2",
                  attrs: {
                    type: "button",
                    disabled: !_vm.isAllowConfirmTransfer(_vm.transferHeader)
                  },
                  on: { click: _vm.confirmRequest }
                },
                [
                  _c("i", { staticClass: "fa fa-check" }),
                  _vm._v(" "),
                  _c("strong", [_vm._v(" ยืนยันส่งสินค้าสำเร็จรูป ")])
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-w-m btn-danger btn-lg tw-w-48 mr-2",
                  attrs: {
                    type: "button",
                    disabled: !_vm.isAllowDiscardTransfer(_vm.transferHeader)
                  },
                  on: { click: _vm.discardConfirmedRequest }
                },
                [
                  _c("i", { staticClass: "fa fa-times" }),
                  _vm._v(" ยกเลิกส่งสินค้าสำเร็จรูป\n                    ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-w-m btn-danger btn-lg tw-w-32",
                  attrs: {
                    type: "button",
                    disabled: !_vm.isAllowCancelTransfer(_vm.transferHeader)
                  },
                  on: { click: _vm.cancelRequest }
                },
                [
                  _c("i", { staticClass: "fa fa-times" }),
                  _vm._v(" ยกเลิกใบส่ง\n                    ")
                ]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  class: _vm.reportUrl
                    ? "btn btn-info btn-lg tw-w-25"
                    : "btn btn-info btn-lg tw-w-25 disabled",
                  attrs: { target: "_blank", href: _vm.reportUrl }
                },
                [
                  _c("i", { staticClass: "fa fa-print" }),
                  _vm._v("พิมพ์\n                    ")
                ]
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
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
                  [_vm._v("ใบส่งเลขที่: ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-7" }, [
                  _c("input", {
                    staticClass: "form-control",
                    attrs: {
                      id: "lb-2",
                      type: "text",
                      name: "transfer_number",
                      disabled: true
                    },
                    domProps: { value: _vm.transferNumber }
                  })
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
                _c("div", { staticClass: "col-lg-7" }, [
                  _vm.isAllowUpdateTransfer(_vm.transferHeader)
                    ? _c(
                        "div",
                        [
                          _c("datepicker-th", {
                            staticClass: "form-control md:tw-mb-0 tw-mb-2",
                            attrs: {
                              name: "transfer_date",
                              id: "input_transfer_date",
                              placeholder: "โปรดเลือกวันที่",
                              format: "DD/MM/YYYY",
                              value: _vm.transferDate,
                              disabled: !_vm.isAllowUpdateTransfer(
                                _vm.transferHeader
                              )
                            },
                            on: {
                              dateWasSelected: _vm.onTransferDateWasSelected
                            }
                          })
                        ],
                        1
                      )
                    : _c("div", [
                        _c("input", {
                          staticClass: "form-control",
                          attrs: {
                            id: "lb-2",
                            type: "text",
                            name: "transfer_date",
                            disabled: true
                          },
                          domProps: { value: _vm.transferDateFormatted }
                        })
                      ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-lg-6" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-lg-5 font-weight-bold col-form-label text-right"
                  },
                  [_vm._v(" สถานะส่งสินค้าสำเร็จรูป : ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-6" }, [
                  _c("input", {
                    staticClass: "form-control",
                    attrs: { type: "text", readonly: "", disabled: "" },
                    domProps: {
                      value: _vm.getTransferStatusDesc(_vm.transferHeader)
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: false,
                      expression: "false"
                    }
                  ],
                  staticClass: "form-group row"
                },
                [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-5 font-weight-bold col-form-label text-right"
                    },
                    [_vm._v(" Transaction Objective : ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _vm.isAllowUpdateTransfer(_vm.transferHeader)
                      ? _c(
                          "div",
                          [
                            _c("pm-el-select", {
                              attrs: {
                                name: "transfer_objective",
                                id: "transfer_objective",
                                "select-options": _vm.transferObjectives,
                                "option-key": "lookup_code",
                                "option-value": "lookup_code",
                                "option-label": "description",
                                value: _vm.transferObjective,
                                filterable: true,
                                disabled: !_vm.isAllowUpdateTransfer(
                                  _vm.transferHeader
                                )
                              },
                              on: { onSelected: _vm.onTransObjectiveWasChanged }
                            })
                          ],
                          1
                        )
                      : _c("div", [
                          _c("input", {
                            staticClass: "form-control",
                            attrs: {
                              id: "lb-2",
                              type: "text",
                              name: "transfer_objective",
                              disabled: true
                            },
                            domProps: { value: _vm.transferObjective }
                          })
                        ])
                  ])
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-lg-5 font-weight-bold col-form-label text-right required"
                  },
                  [_vm._v(" สถานที่จัดเก็บปลายทาง : ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-6" }, [
                  _vm.isAllowUpdateTransfer(_vm.transferHeader)
                    ? _c(
                        "div",
                        [
                          _c("pm-el-select", {
                            attrs: {
                              name: "to_locator_id",
                              id: "input_to_locator_id",
                              "select-options": _vm.inputToLocator,
                              "option-key": "locator_id",
                              "option-value": "locator_id",
                              "option-label": "locator_full_desc",
                              value: _vm.toLocatorId,
                              filterable: true
                            },
                            on: { onSelected: _vm.onToLocatorWasChanged }
                          })
                        ],
                        1
                      )
                    : _c("div", [
                        _c("input", {
                          staticClass: "form-control",
                          attrs: {
                            id: "lb-2",
                            type: "text",
                            name: "locator_id",
                            disabled: true
                          },
                          domProps: { value: _vm.toLocatorDesc }
                        })
                      ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("div", { staticClass: "col-lg-11 text-right" }, [
                  _c(
                    "button",
                    {
                      class: _vm.transBtn.search.class + " btn-lg tw-w-32",
                      attrs: {
                        disabled: !_vm.isAllowGetConfirmItems(
                          _vm.transferHeader
                        )
                      },
                      on: { click: _vm.onGetConfirmItems }
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
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ibox float-e-margins" }, [
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "text-right tw-mb-2" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-inline-block btn-sm btn-success tw-w-32",
                attrs: { disabled: !_vm.isAllowAddNewLine(_vm.transferHeader) },
                on: { click: _vm.onAddNewLine }
              },
              [
                _c("i", { staticClass: "fa fa-plus tw-mr-1" }),
                _vm._v(" เพิ่มรายการ \n                ")
              ]
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "table-responsive",
              staticStyle: { "max-height": "600px" }
            },
            [
              _c(
                "table",
                { staticClass: "table table-bordered table-sticky" },
                [
                  _c("thead", [
                    _c("tr", [
                      _c("th", {
                        staticClass: "text-center",
                        attrs: { width: "30px;" }
                      }),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticClass: "text-center",
                          attrs: { width: "170px;" }
                        },
                        [
                          _vm._v(
                            "\n                                รหัสสินค้าสำเร็จรูป\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("th", { staticClass: "text-center" }, [
                        _vm._v(
                          " \n                                รายละเอียด \n                            "
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticClass: "text-center",
                          attrs: { width: "140px;" }
                        },
                        [
                          _vm._v(
                            "\n                                จำนวนส่งเข้าคลัง\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        {
                          staticClass: "text-center",
                          attrs: { width: "100px;" }
                        },
                        [
                          _vm._v(
                            "\n                                หน่วยนับ\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _vm.isAllowDeleteLine(_vm.transferHeader)
                        ? _c("th", {
                            staticClass: "text-center",
                            attrs: { width: "30px;" }
                          })
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.transferInvItemLines.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.transferInvItemLines, function(
                            transferInvItemLine,
                            index
                          ) {
                            return [
                              _c("tr", { key: "" + index }, [
                                _c(
                                  "td",
                                  { staticClass: "align-middle text-center" },
                                  [_vm._v(" " + _vm._s(index + 1) + " ")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "align-middle text-center" },
                                  [
                                    _vm.isAllowUpdateTransfer(
                                      _vm.transferHeader
                                    )
                                      ? [
                                          _c("pm-el-select", {
                                            attrs: {
                                              name: "item_number_" + index,
                                              id: "input_item_number_" + index,
                                              "select-options": _vm.invItems,
                                              "option-key": "inventory_item_id",
                                              "option-value":
                                                "inventory_item_id",
                                              "option-label": "item_number",
                                              value:
                                                transferInvItemLine.inventory_item_id,
                                              filterable: true
                                            },
                                            on: {
                                              onSelected: function($event) {
                                                return _vm.onTransferInvItemChanged(
                                                  $event,
                                                  transferInvItemLine,
                                                  index
                                                )
                                              }
                                            }
                                          })
                                        ]
                                      : [
                                          _vm._v(
                                            "\n                                        " +
                                              _vm._s(
                                                transferInvItemLine.item_number
                                              ) +
                                              "\n                                    "
                                          )
                                        ]
                                  ],
                                  2
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "align-middle text-left" },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(transferInvItemLine.item_desc) +
                                        "\n                                "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "align-middle text-right" },
                                  [
                                    _vm.isAllowInputTransactionQty(
                                      _vm.transferHeader
                                    )
                                      ? [
                                          _c("vue-numeric", {
                                            staticClass:
                                              "form-control input-sm text-right",
                                            staticStyle: {
                                              "min-width": "120px"
                                            },
                                            attrs: {
                                              separator: ",",
                                              precision: 2,
                                              minus: false,
                                              id:
                                                "input_transaction_qty_" +
                                                index,
                                              name: "transaction_qty_" + index
                                            },
                                            on: {
                                              change: function($event) {
                                                return _vm.onTransactionQtyChanged(
                                                  transferInvItemLine
                                                )
                                              }
                                            },
                                            model: {
                                              value:
                                                transferInvItemLine.transaction_qty,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  transferInvItemLine,
                                                  "transaction_qty",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "transferInvItemLine.transaction_qty"
                                            }
                                          })
                                        ]
                                      : [
                                          _vm._v(
                                            "\n                                        " +
                                              _vm._s(
                                                Number(
                                                  transferInvItemLine.transaction_qty
                                                ).toLocaleString(undefined, {
                                                  minimumFractionDigits: 2,
                                                  maximumFractionDigits: 2
                                                })
                                              ) +
                                              "\n                                    "
                                          )
                                        ]
                                  ],
                                  2
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "align-middle text-center",
                                    attrs: {
                                      title: transferInvItemLine.unit_of_measure
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          transferInvItemLine.unit_of_measure
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _vm.isAllowDeleteLine(_vm.transferHeader)
                                  ? _c("td", [
                                      _vm.isAllowDeleteLine(_vm.transferHeader)
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-sm btn-danger",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  return _vm.onDeleteLine(
                                                    _vm.transferInvItemLines,
                                                    transferInvItemLine,
                                                    index
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-trash"
                                              })
                                            ]
                                          )
                                        : _vm._e()
                                    ])
                                  : _vm._e()
                              ])
                            ]
                          })
                        ],
                        2
                      )
                    : _c("tbody", [_vm._m(0)])
                ]
              )
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c("modal-search-header", {
        attrs: {
          "modal-name": "modal-search-header",
          "modal-width": "1000",
          "modal-height": "auto",
          "trans-btn": _vm.transBtn
        },
        on: { onSearchRequestHeader: _vm.onSearchRequestHeader }
      }),
      _vm._v(" "),
      _c("loading", {
        attrs: { active: _vm.isLoading, "is-full-page": true },
        on: {
          "update:active": function($event) {
            _vm.isLoading = $event
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "11" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" ไม่พบข้อมูล ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/transfers/ModalSearchHeader.vue?vue&type=template&id=f57e3772&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
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
    { staticStyle: { position: "fixed", "z-index": "100" } },
    [
      _c(
        "modal",
        {
          attrs: {
            name: _vm.modalName,
            width: _vm.width,
            scrollable: true,
            height: _vm.modalHeight,
            shiftX: 0.3,
            shiftY: 0.3
          }
        },
        [
          _c("div", { staticClass: "p-4" }, [
            _c("h4", [_vm._v(" ค้นหารายการบันทึกส่งสินค้าสำเร็จรูป ")]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-9" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-3 font-weight-bold col-form-label text-right",
                      attrs: { for: "lb-2" }
                    },
                    [_vm._v("ใบส่งเลขที่: ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-9" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.searchTransferNumber,
                          expression: "searchTransferNumber"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: {
                        id: "lb-2",
                        type: "text",
                        name: "transfer_number"
                      },
                      domProps: { value: _vm.searchTransferNumber },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.searchTransferNumber = $event.target.value
                        }
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-3 font-weight-bold col-form-label text-right"
                    },
                    [_vm._v("วันที่ส่งผลผลิต: ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-4" },
                    [
                      _c("datepicker-th", {
                        staticClass: "form-control md:tw-mb-0 tw-mb-2",
                        attrs: {
                          name: "transfer_date_from",
                          id: "input_transfer_date_from",
                          placeholder: "โปรดเลือกวันที่",
                          format: "DD/MM/YYYY",
                          value: _vm.transferDateFrom
                        },
                        on: {
                          dateWasSelected: _vm.onTransferDateFromWasSelected
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-1 font-weight-bold col-form-label text-right"
                    },
                    [_vm._v(" ถึง ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-4" },
                    [
                      _c("datepicker-th", {
                        staticClass: "form-control md:tw-mb-0 tw-mb-2",
                        attrs: {
                          name: "transfer_to",
                          id: "input_transfer_to",
                          placeholder: "โปรดเลือกวันที่",
                          format: "DD/MM/YYYY",
                          value: _vm.transferDateTo,
                          "disabled-date-to": _vm.transferDateFromFormatted
                        },
                        on: { dateWasSelected: _vm.onTransferDateToWasSelected }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-3" }, [
                _c(
                  "button",
                  {
                    class: _vm.transBtn.search.class + " btn-lg tw-w-full",
                    attrs: { type: "button" },
                    on: { click: _vm.getHeaders }
                  },
                  [
                    _c("i", { class: _vm.transBtn.search.icon }),
                    _vm._v(
                      " \n                        " +
                        _vm._s(_vm.transBtn.search.text) +
                        "\n                    "
                    )
                  ]
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "table-responsive mb-3" }, [
              _c("table", { staticClass: "table table-hover" }, [
                _c("thead", [
                  _c("tr", [
                    _c(
                      "th",
                      { staticClass: "text-center", attrs: { width: "200px" } },
                      [_vm._v("วันที่ส่งผลผลิต")]
                    ),
                    _vm._v(" "),
                    _c("th", [_vm._v("ใบส่งเลขที่")]),
                    _vm._v(" "),
                    _c(
                      "th",
                      { staticClass: "text-center", attrs: { width: "200px" } },
                      [_vm._v("สถานะขอเบิก")]
                    ),
                    _vm._v(" "),
                    _c("th", {
                      staticClass: "text-center",
                      attrs: { width: "150px" }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.transferHeaders, function(transferHeader, index) {
                    return _c("tr", { key: index }, [
                      _c("td", { staticClass: "text-center" }, [
                        _vm._v(
                          _vm._s(
                            _vm.getDateFormatted(transferHeader.transfer_date)
                          )
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(_vm._s(transferHeader.transfer_number))
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        transferHeader.status
                          ? _c("div", [
                              _vm._v(
                                "\n                                    " +
                                  _vm._s(transferHeader.status.description) +
                                  "\n                                "
                              )
                            ])
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-right" }, [
                        _c(
                          "button",
                          {
                            class:
                              _vm.transBtn.detail.class + " btn-lg tw-w-25",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                return _vm.selectRequestHeader(transferHeader)
                              }
                            }
                          },
                          [
                            _c("i", { class: _vm.transBtn.detail.icon }),
                            _vm._v(
                              "\n                                    " +
                                _vm._s(_vm.transBtn.detail.text) +
                                "\n                                "
                            )
                          ]
                        )
                      ])
                    ])
                  }),
                  0
                )
              ])
            ])
          ])
        ]
      ),
      _vm._v(" "),
      _c("loading", {
        attrs: { active: _vm.isLoading, "is-full-page": true },
        on: {
          "update:active": function($event) {
            _vm.isLoading = $event
          }
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