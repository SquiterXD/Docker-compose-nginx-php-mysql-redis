(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_products_machine-requests_Index_vue"],{

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableMachineRequests__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableMachineRequests */ "./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue");
/* harmony import */ var _ModalSearch__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalSearch */ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue");
/* harmony import */ var _DatepickerTh__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../DatepickerTh */ "./resources/js/components/pm/DatepickerTh.vue");


function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TableMachineRequests: _TableMachineRequests__WEBPACK_IMPORTED_MODULE_4__.default,
    ModalSearch: _ModalSearch__WEBPACK_IMPORTED_MODULE_5__.default,
    DatepickerTh: _DatepickerTh__WEBPACK_IMPORTED_MODULE_6__.default
  },
  props: ["requestNumberValue", "requestDateValue", "objectiveRequestValue", "inventoryItemIdValue", "machineNameValue", "itemOptions", "uomCodes", "objectiveRequests"],
  mounted: function mounted() {
    if (this.requestNumberValue) {
      this.getMachineRequests(this.requestNumberValue);
    }

    if (this.requestDateValue) {
      var requestDate = moment__WEBPACK_IMPORTED_MODULE_3___default()(this.requestDateValue, "DD/MM/YYYY").toDate();
      this.getInvItems(requestDate);

      if (this.inventoryItemIdValue) {
        this.getItemMachineName(requestDate, this.inventoryItemIdValue);
      }
    }
  },
  data: function data() {
    return {
      requestNumber: this.requestNumberValue,
      requestDate: this.requestDateValue ? moment__WEBPACK_IMPORTED_MODULE_3___default()(this.requestDateValue, "DD/MM/YYYY").toDate() : null,
      requestDateFormatted: this.requestDateValue,
      objectiveRequest: this.objectiveRequestValue,
      inventoryItemId: this.inventoryItemIdValue,
      machineName: this.machineNameValue,
      invItems: [],
      machineRequests: [],
      isNewlyCreate: false,
      isLoading: false
    };
  },
  computed: {},
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("request_number", this.requestNumber ? this.requestNumber : '');
      queryParams.set("request_date", this.requestDateFormatted ? this.requestDateFormatted : '');
      queryParams.set("objective_request", this.objectiveRequest ? this.objectiveRequest : '');
      queryParams.set("inventory_item_id", this.inventoryItemId ? this.inventoryItemId : '');
      queryParams.set("machine_name", this.machineName ? this.machineName : '');
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    requestDateWasSelected: function requestDateWasSelected(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                // CLEAR DATA 
                _this.inventoryItemId = null;
                _this.machineName = null;
                _this.invItems = [];
                _this.requestNumber = null;
                _this.machineRequests = [];
                _this.requestDate = value;
                _this.requestDateFormatted = _this.getRequestDateFormatted(_this.requestDate);
                _context.next = 9;
                return _this.getInvItems(_this.requestDate);

              case 9:
                _this.setUrlParams();

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onObjectiveRequestWasSelected: function onObjectiveRequestWasSelected(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // CLEAR DATA 
                _this2.requestNumber = null;
                _this2.machineRequests = [];
                _this2.objectiveRequest = value;

                _this2.setUrlParams();

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onInventoryItemIdWasSelected: function onInventoryItemIdWasSelected(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // CLEAR DATA 
                _this3.inventoryItemId = null;
                _this3.machineName = null;
                _this3.requestNumber = null;
                _this3.machineRequests = [];
                _this3.inventoryItemId = value;
                _context3.next = 7;
                return _this3.getItemMachineName(_this3.requestDate, _this3.inventoryItemId);

              case 7:
                _this3.setUrlParams();

              case 8:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onSelectedSearchMachineRequest: function onSelectedSearchMachineRequest(data) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.requestNumber = data.request_number;
                _this4.requestDateFormatted = data.request_date;
                _this4.requestDate = moment__WEBPACK_IMPORTED_MODULE_3___default()(_this4.requestDateFormatted, "DD/MM/YYYY").toDate();
                _context4.next = 5;
                return _this4.getInvItems(_this4.requestDate);

              case 5:
                if (!_this4.requestNumber) {
                  _context4.next = 8;
                  break;
                }

                _context4.next = 8;
                return _this4.getMachineRequests(_this4.requestNumber);

              case 8:
                _this4.setUrlParams();

              case 9:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getRequestDateFormatted: function getRequestDateFormatted(requestDate) {
      return moment__WEBPACK_IMPORTED_MODULE_3___default()(requestDate).format("DD/MM/YYYY");
    },
    getPeriodNameLabel: function getPeriodNameLabel(periodNames, periodName) {
      var foundPeriodName = periodNames.find(function (item) {
        return item.period_name_value == periodName;
      });
      return foundPeriodName ? foundPeriodName.period_name_label : "";
    },
    getInvItems: function getInvItems(requestDate) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var requestDateFormatted, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // show loading
                _this5.isLoading = true; // REFRESH DATA

                _this5.invItems = [];
                requestDateFormatted = moment__WEBPACK_IMPORTED_MODULE_3___default()(requestDate).format("DD/MM/YYYY");
                params = {
                  request_date: requestDateFormatted
                };
                _context5.next = 6;
                return axios.get("/ajax/pm/products/machine-requests/get-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestDateFormatted, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(resData.message), "error");
                  } else {
                    _this5.invItems = resData.inv_items ? JSON.parse(resData.inv_items) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestDateFormatted, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 6:
                // hide loading
                _this5.isLoading = false;

              case 7:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getItemMachineName: function getItemMachineName(requestDate, inventoryItemId) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var requestDateFormatted, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this6.isLoading = true; // REFRESH DATA

                _this6.machineName = "";
                requestDateFormatted = moment__WEBPACK_IMPORTED_MODULE_3___default()(requestDate).format("DD/MM/YYYY");
                params = {
                  request_date: requestDateFormatted,
                  inventory_item_id: inventoryItemId
                };
                _context6.next = 6;
                return axios.get("/ajax/pm/products/machine-requests/get-item-machine-name", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestDateFormatted, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(resData.message), "error");
                  } else {
                    _this6.machineName = resData.machine_name;
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestDateFormatted, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 6:
                // hide loading
                _this6.isLoading = false;

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getMachineRequests: function getMachineRequests(requestNumber) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // show loading
                _this7.isLoading = true; // REFRESH DATA

                _this7.machineRequests = [];
                params = {
                  request_number: requestNumber
                };
                _context7.next = 5;
                return axios.get("/ajax/pm/products/machine-requests/get-requests", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestNumber, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(resData.message), "error");
                  } else {
                    _this7.machineRequests = resData.machine_requests ? JSON.parse(resData.machine_requests) : [];

                    if (_this7.machineRequests.length > 0) {
                      _this7.machineName = _this7.machineRequests[0].machine_name;
                      _this7.inventoryItemId = _this7.machineRequests[0].inventory_item_id;

                      if (_this7.machineRequests[0].objective_request) {
                        _this7.objectiveRequest = _this7.machineRequests[0].objective_request;
                      }
                    }
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestNumber, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 5:
                // hide loading
                _this7.isLoading = false;

              case 6:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onGenerateMachineRequests: function onGenerateMachineRequests() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                // show loading
                _this8.isLoading = true;
                reqBody = {
                  request_date: _this8.requestDateFormatted,
                  objective_request: _this8.objectiveRequest,
                  machine_name: _this8.machineName,
                  inventory_item_id: _this8.inventoryItemId
                };
                _context8.next = 4;
                return axios.post("/ajax/pm/products/machine-requests/generate-requests", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this8.machineRequests = resData.machine_requests ? JSON.parse(resData.machine_requests) : [];

                    if (_this8.machineRequests.length <= 0) {
                      swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E08\u0E32\u0E01\u0E41\u0E1C\u0E19 \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this8.requestDateFormatted), "error");
                    }

                    _this8.isNewlyCreate = resData.is_newly_create;
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E23\u0E35\u0E22\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E08\u0E32\u0E01\u0E41\u0E1C\u0E19 \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this8.requestDateFormatted, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E23\u0E35\u0E22\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E08\u0E32\u0E01\u0E41\u0E1C\u0E19 \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this8.requestDateFormatted, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this8.isLoading = false;

              case 5:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    onMachineRequestChanged: function onMachineRequestChanged(data) {
      this.machineRequests = data.machineRequestItems;
    },
    validateBeforeSave: function validateBeforeSave(machineRequests) {
      var result = {
        valid: true,
        message: ""
      }; // IF NEW LINE ISN'T COMPLETED

      var incompletedLines = machineRequests.filter(function (item) {
        return item.is_new_line && (!item.inventory_item_id || !item.request_qty) && item.marked_as_deleted == false;
      });

      if (incompletedLines.length > 0) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23\u0E44\u0E21\u0E48\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      }

      return result;
    },
    onAddMachineRequest: function onAddMachineRequest() {
      var _this9 = this;

      var cloneLastMachineRequestItem = _objectSpread({}, this.machineRequests.find(function (item, index) {
        return index == _this9.machineRequests.length - 1;
      }));

      Object.keys(cloneLastMachineRequestItem).forEach(function (k) {
        if (k != "request_number" || k != "creation_date" || k != "request_date" || k != "organization_id") {
          cloneLastMachineRequestItem[k] = null;
        }
      });
      this.machineRequests = [].concat(_toConsumableArray(this.machineRequests), [_objectSpread(_objectSpread({}, cloneLastMachineRequestItem), {}, {
        request_qty: 0,
        is_new_line: true,
        marked_as_deleted: false
      })]);
    },
    onSaveMachineRequests: function onSaveMachineRequests() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                reqBody = {
                  request_date: _this10.requestDateFormatted,
                  machine_requests: JSON.stringify(_this10.machineRequests)
                }; // show loading

                _this10.isLoading = true;
                resValidate = _this10.validateBeforeSave(_this10.machineRequests);

                if (!resValidate.valid) {
                  _context9.next = 8;
                  break;
                }

                _context9.next = 6;
                return axios.post("/ajax/pm/products/machine-requests/store-requests", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this10.isNewlyCreate = false;
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 : ".concat(_this10.requestDateFormatted, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 : \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this10.requestDateFormatted, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 : \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this10.requestDateFormatted, " | ").concat(error.message), "error");
                });

              case 6:
                _context9.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 : \u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this10.requestDateFormatted, " | ").concat(resValidate.message), "error");

              case 9:
                // hide loading
                _this10.isLoading = false;

              case 10:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    onSubmitMachineRequests: function onSubmitMachineRequests() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                reqBody = {
                  request_date: _this11.requestDateFormatted,
                  machine_requests: JSON.stringify(_this11.machineRequests)
                }; // show loading

                _this11.isLoading = true; // CALL SAVE BEFORE SUBMIT APPROVAL

                _context10.next = 4;
                return axios.post("/ajax/pm/products/machine-requests/store-requests", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    console.log(resData.message);
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                });

              case 4:
                _context10.next = 6;
                return axios.post("/ajax/pm/products/machine-requests/submit-requests", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    swal("Success", "\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E1B WMS (\u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this11.requestDateFormatted, ")"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E1B WMS (\u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this11.requestDateFormatted, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E1B WMS (\u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this11.requestDateFormatted, ") | ").concat(error.message), "error");
                });

              case 6:
                // hide loading
                _this11.isLoading = false;

              case 7:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    onExportPdf: function onExportPdf() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                reqBody = {
                  request_date: _this12.requestDateFormatted,
                  machine_requests: JSON.stringify(_this12.machineRequests)
                }; // show loading

                _this12.isLoading = true; // CALL SAVE BEFORE SUBMIT APPROVAL

                _context11.next = 4;
                return axios.post("/ajax/pm/products/machine-requests/export-pdf", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E07\u0E32\u0E19 (\u0E27\u0E31\u0E19\u0E17\u0E35\u0E48 : ".concat(_this12.requestDateFormatted, ") | ").concat(resMsg), "error");
                  } else {
                    window.open("/pm/files/download/pm/products/machine-requests/pdf/".concat(resData.file_name), '_blank');
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                });

              case 4:
                // hide loading
                _this12.isLoading = false;

              case 5:
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _DatepickerTh__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../DatepickerTh */ "./resources/js/components/pm/DatepickerTh.vue");
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    DatepickerTh: _DatepickerTh__WEBPACK_IMPORTED_MODULE_3__.default
  },
  watch: {},
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      requestDate: null,
      headerRequests: []
    };
  },
  created: function created() {
    this.handleResize();
  },
  methods: {
    handleResize: function handleResize() {
      if (window.innerWidth < 768) {
        // set modal width = 90% when screen width < 769px
        this.width = "90%";
      } else if (window.innerWidth < 992) {
        // set modal width = 80% when screen width < 992px
        this.width = "80%";
      } else {
        this.width = this.modalWidth;
      }
    },
    requestDateWasSelected: function requestDateWasSelected(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.requestDate = value;

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onSearchMachineRequests: function onSearchMachineRequests() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var requestDateFormatted, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // REFRESH DATA
                _this2.headerRequests = []; // show loading

                _this2.isLoading = true;
                requestDateFormatted = _this2.requestDate ? moment__WEBPACK_IMPORTED_MODULE_2___default()(_this2.requestDate).format("DD/MM/YYYY") : "";
                params = {
                  request_date: requestDateFormatted
                };
                _context2.next = 6;
                return axios.get("/ajax/pm/products/machine-requests/search-request-headers", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestDateFormatted, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(resData.message), "error");
                  } else {
                    _this2.headerRequests = resData.header_requests ? JSON.parse(resData.header_requests).map(function (item) {
                      return _objectSpread(_objectSpread({}, item), {}, {
                        request_date_formatted: item.request_date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(item.request_date).add(543, 'years').format("DD/MM/YYYY") : ""
                      });
                    }) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E1A\u0E34\u0E01\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E2B\u0E02\u0E49\u0E32\u0E2B\u0E19\u0E49\u0E32\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 ".concat(requestDateFormatted, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 6:
                // hide loading
                _this2.isLoading = false;

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onSelectedSearchMachineRequest: function onSelectedSearchMachineRequest(requestDate, requestNumber) {
      this.$modal.hide(this.modalName);
      this.$emit("onSelectedSearchMachineRequest", {
        request_date: requestDate,
        request_number: requestNumber
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["requestDateValue", "machineRequests", "itemOptions", "uomCodes"],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    machineRequests: function machineRequests(value) {
      this.machineRequestItems = value;
    }
  },
  data: function data() {
    var _this = this;

    return {
      requestDate: this.requestDateValue,
      machineRequestItems: this.machineRequests.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          request_qty: item.request_qty ? item.request_qty : 0,
          uom2: item.uom2 ? item.uom2 : item.uom,
          uom_desc: _this.getUomCodeDescriptionByCode(_this.uomCodes, item.uom),
          uom2_desc: _this.getUomCodeDescriptionByCode(_this.uomCodes, item.uom2 ? item.uom2 : item.uom),
          is_new_line: item.attribute10 == "Y" ? true : false,
          // attribute10 == 'Y' => is_new_line == true
          marked_as_deleted: false
        });
      })
    };
  },
  mounted: function mounted() {
    this.emitMachineRequestChanged();
  },
  computed: {},
  methods: {
    onRequestQtyChanged: function onRequestQtyChanged(machineRequestItem) {
      this.emitMachineRequestChanged();
    },
    onUOM2Changed: function onUOM2Changed(value, machineRequestItem) {
      machineRequestItem.uom2 = value;
      machineRequestItem.uom2_desc = this.getUomCodeDescription(this.uomCodes, value);
    },
    onDeleteItem: function onDeleteItem(machineRequestItem) {
      var _this2 = this;

      swal({
        title: "",
        text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 ".concat(machineRequestItem.inv_item_desc ? machineRequestItem.inv_item_desc : "", " ?"),
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "ลบ",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: true
      }, function (isConfirm) {
        if (isConfirm) {
          machineRequestItem.marked_as_deleted = true;

          _this2.emitMachineRequestChanged();
        }
      });
    },
    onInvItemChanged: function onInvItemChanged(value, machineRequestItem) {
      machineRequestItem.inventory_item_id = value;
      var foundItem = this.itemOptions.find(function (i) {
        return i.inventory_item_id == value;
      });
      machineRequestItem.inv_item_number = foundItem.item_number;
      machineRequestItem.inv_item_desc = foundItem.item_desc;
      machineRequestItem.uom = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code);
      machineRequestItem.uom_desc = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code);
      machineRequestItem.uom2 = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code);
      machineRequestItem.uom2_desc = this.getUomCodeDescriptionByCode(this.uomCodes, foundItem.primary_uom_code);
      this.emitMachineRequestChanged();
    },
    getUomCodeDescriptionByCode: function getUomCodeDescriptionByCode(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code_value == uomCode;
      });
      return foundUomCode ? foundUomCode.uom_code_label : "";
    },
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code_label == uomCode;
      });
      return foundUomCode ? foundUomCode.uom_code_label : "";
    },
    emitMachineRequestChanged: function emitMachineRequestChanged() {
      this.$emit("onMachineRequestChanged", {
        machineRequestItems: this.machineRequestItems
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-37e3b994] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_style_index_0_id_37e3b994_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_style_index_0_id_37e3b994_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_style_index_0_id_37e3b994_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

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

/***/ "./resources/js/components/pm/products/machine-requests/Index.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/Index.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_15741671___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=15741671& */ "./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=template&id=15741671&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_15741671___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_15741671___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/products/machine-requests/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/ModalSearch.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_37e3b994_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true& */ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSearch_vue_vue_type_style_index_0_id_37e3b994_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css& */ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_37e3b994_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_37e3b994_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "37e3b994",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/products/machine-requests/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableMachineRequests_vue_vue_type_template_id_330bc0ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableMachineRequests.vue?vue&type=template&id=330bc0ae& */ "./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=template&id=330bc0ae&");
/* harmony import */ var _TableMachineRequests_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableMachineRequests.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableMachineRequests_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableMachineRequests_vue_vue_type_template_id_330bc0ae___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableMachineRequests_vue_vue_type_template_id_330bc0ae___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/products/machine-requests/TableMachineRequests.vue"
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

/***/ "./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMachineRequests_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableMachineRequests.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMachineRequests_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css&":
/*!***************************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_style_index_0_id_37e3b994_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=style&index=0&id=37e3b994&scoped=true&lang=css&");


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

/***/ "./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=template&id=15741671&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=template&id=15741671& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_15741671___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_15741671___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_15741671___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=15741671& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=template&id=15741671&");


/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_37e3b994_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_37e3b994_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_37e3b994_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=template&id=330bc0ae&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=template&id=330bc0ae& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMachineRequests_vue_vue_type_template_id_330bc0ae___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMachineRequests_vue_vue_type_template_id_330bc0ae___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMachineRequests_vue_vue_type_template_id_330bc0ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableMachineRequests.vue?vue&type=template&id=330bc0ae& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=template&id=330bc0ae&");


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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=template&id=15741671&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/Index.vue?vue&type=template&id=15741671& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "ibox" },
    [
      _c(
        "div",
        { staticClass: "ibox-content", staticStyle: { "min-height": "600px" } },
        [
          _c("div", { staticClass: "tw-mb-4" }, [
            _c("div", { staticClass: "text-right tw-mb-2" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-info tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.requestDate ||
                      !_vm.objectiveRequest ||
                      !_vm.inventoryItemId ||
                      _vm.machineRequests.length > 0
                  },
                  on: { click: _vm.onGenerateMachineRequests }
                },
                [
                  _c("i", { staticClass: "fa fa-calculator tw-mr-1" }),
                  _vm._v(" เรียกข้อมูลจากแผน \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-40",
                  on: {
                    click: function($event) {
                      return _vm.$modal.show("modal-search")
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-search tw-mr-1" }),
                  _vm._v(" ค้นหา \n                ")
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "text-right" }, [
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-inline-block btn-sm btn-primary tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.requestDate || _vm.machineRequests.length == 0
                  },
                  on: { click: _vm.onSaveMachineRequests }
                },
                [
                  _c("i", { staticClass: "fa fa-save tw-mr-1" }),
                  _vm._v(" บันทึก \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-inline-block btn-sm btn-warning tw-w-40",
                  attrs: {
                    disabled:
                      _vm.machineRequests.length == 0 || _vm.isNewlyCreate
                  },
                  on: { click: _vm.onSubmitMachineRequests }
                },
                [
                  _c("i", { staticClass: "fa fa-check-square tw-mr-1" }),
                  _vm._v(" ยืนยันส่งข้อมูลไป WMS \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-inline-block btn-sm btn-primary tw-w-40",
                  attrs: { disabled: _vm.machineRequests.length == 0 },
                  on: { click: _vm.onExportPdf }
                },
                [
                  _c("i", { staticClass: "fa fa-print tw-mr-1" }),
                  _vm._v(" พิมพ์รายงาน \n                ")
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("div", [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-6" }, [
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" วันที่ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("datepicker-th", {
                        staticClass: "form-control md:tw-mb-0 tw-mb-2",
                        attrs: {
                          name: "request_date",
                          id: "input_request_date",
                          placeholder: "โปรดเลือกวันที่",
                          format: "DD/MM/YYYY",
                          value: _vm.requestDate
                        },
                        on: { dateWasSelected: _vm.requestDateWasSelected }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" วัตถุประสงค์ในการเบิก ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "objective_request",
                          id: "objective_request",
                          "select-options": _vm.objectiveRequests,
                          "option-key": "objective_request_value",
                          "option-value": "objective_request_value",
                          "option-label": "objective_request_label",
                          value: _vm.objectiveRequest,
                          filterable: true
                        },
                        on: { onSelected: _vm.onObjectiveRequestWasSelected }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" เลขที่ใบเบิก ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.machineRequests.length == 0
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(" - ")
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.machineRequests.length > 0
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(_vm.machineRequests[0].request_number) +
                              " "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6" }, [
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" สินค้าที่จะผลิต ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "inventory_item_id",
                          id: "inventory_item_id",
                          "select-options": _vm.invItems,
                          "option-key": "inventory_item_id",
                          "option-value": "inventory_item_id",
                          "option-label": "inv_item_fulldesc",
                          value: _vm.inventoryItemId,
                          filterable: true
                        },
                        on: { onSelected: _vm.onInventoryItemIdWasSelected }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" เครื่องจักร ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _c("p", { staticClass: "col-form-label" }, [
                      _vm._v(
                        " " +
                          _vm._s(_vm.machineName ? _vm.machineName : "-") +
                          " "
                      )
                    ])
                  ])
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _vm.machineRequests.length > 0
            ? _c("div", [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-12" },
                    [
                      _c("table-machine-requests", {
                        attrs: {
                          "machine-requests": _vm.machineRequests,
                          "uom-codes": _vm.uomCodes,
                          "item-options": _vm.itemOptions
                        },
                        on: {
                          onMachineRequestChanged: _vm.onMachineRequestChanged
                        }
                      })
                    ],
                    1
                  )
                ])
              ])
            : _vm._e()
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
      }),
      _vm._v(" "),
      _c("modal-search", {
        attrs: {
          "modal-name": "modal-search",
          "modal-width": "720",
          "modal-height": "auto",
          "plan-date-value": _vm.requestDate
        },
        on: {
          onSelectedSearchMachineRequest: _vm.onSelectedSearchMachineRequest
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/ModalSearch.vue?vue&type=template&id=37e3b994&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
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
            _c("h4", [_vm._v(" ค้นหาประมาณการวัตถุดิบประจำปี ")]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c("div", { staticClass: "row form-group" }, [
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label tw-font-bold" },
                [_vm._v(" วันที่ ")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-4" },
                [
                  _c("datepicker-th", {
                    staticClass: "form-control md:tw-mb-0 tw-mb-2",
                    attrs: {
                      name: "request_date",
                      id: "input_request_date",
                      placeholder: "โปรดเลือกวันที่",
                      format: "DD/MM/YYYY",
                      value: _vm.requestDate
                    },
                    on: { dateWasSelected: _vm.requestDateWasSelected }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-4" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-white tw-w-32",
                    attrs: { type: "button" },
                    on: { click: _vm.onSearchMachineRequests }
                  },
                  [
                    _c("i", { staticClass: "fa fa-search" }),
                    _vm._v(" ค้นหา \n                    ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-link",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.$modal.hide(_vm.modalName)
                      }
                    }
                  },
                  [
                    _vm._v(
                      " \n                        ยกเลิก \n                    "
                    )
                  ]
                )
              ])
            ]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "table-responsive",
                staticStyle: { "max-height": "300px" }
              },
              [
                _c("table", { staticClass: "table table-bordered mb-0" }, [
                  _c("thead", [
                    _c("tr", [
                      _c(
                        "th",
                        { staticClass: "text-center", attrs: { width: "20%" } },
                        [_vm._v(" ลำดับที่ ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        { staticClass: "text-center", attrs: { width: "30%" } },
                        [_vm._v(" วันที่เบิก ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "th",
                        { staticClass: "text-center", attrs: { width: "30%" } },
                        [_vm._v(" เลขที่ใบเบิก ")]
                      ),
                      _vm._v(" "),
                      _c("th", {
                        staticClass: "text-center",
                        attrs: { width: "20%" }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.headerRequests.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.headerRequests, function(
                            headerRequest,
                            index
                          ) {
                            return [
                              _c("tr", { key: "" + index }, [
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(" " + _vm._s(index + 1) + " ")
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        headerRequest.request_date_formatted
                                      ) +
                                      " "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    " " +
                                      _vm._s(headerRequest.request_number) +
                                      " "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _c(
                                    "button",
                                    {
                                      staticClass: "btn btn-xs btn-primary",
                                      attrs: { type: "button" },
                                      on: {
                                        click: function($event) {
                                          return _vm.onSelectedSearchMachineRequest(
                                            headerRequest.request_date_formatted,
                                            headerRequest.request_number
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        " \n                                        เลือก \n                                    "
                                      )
                                    ]
                                  )
                                ])
                              ])
                            ]
                          })
                        ],
                        2
                      )
                    : _c("tbody", [
                        _c("tr", [
                          _c("td", { attrs: { colspan: "4" } }, [
                            _c(
                              "h2",
                              { staticClass: "p-5 text-center text-muted" },
                              [_vm._v(" ไม่พบข้อมูล ")]
                            )
                          ])
                        ])
                      ])
                ])
              ]
            )
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=template&id=330bc0ae&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/products/machine-requests/TableMachineRequests.vue?vue&type=template&id=330bc0ae& ***!
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
  return _c("div", [
    _c(
      "div",
      {
        staticClass: "table-responsive",
        staticStyle: { "max-height": "600px" }
      },
      [
        _c(
          "table",
          {
            staticClass: "table table-bordered table-sticky mb-0",
            staticStyle: { "min-width": "800px" }
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm.machineRequestItems.length > 0
              ? _c(
                  "tbody",
                  { staticClass: "yearly-lines" },
                  [
                    _vm._l(_vm.machineRequestItems, function(
                      machineRequestItem,
                      index
                    ) {
                      return [
                        !machineRequestItem.marked_as_deleted
                          ? _c("tr", { key: "" + index }, [
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-center",
                                  staticStyle: { "min-width": "60px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(index + 1) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-center",
                                  staticStyle: { "min-width": "100px" }
                                },
                                [
                                  machineRequestItem.is_new_line
                                    ? _c(
                                        "div",
                                        [
                                          _c("pm-el-select", {
                                            attrs: {
                                              name: "inventory_item_id",
                                              id: "input_inventory_item_id",
                                              "select-options": _vm.itemOptions,
                                              "option-key": "inventory_item_id",
                                              "option-value":
                                                "inventory_item_id",
                                              "option-label": "full_item_desc",
                                              value:
                                                machineRequestItem.inventory_item_id,
                                              filterable: true
                                            },
                                            on: {
                                              onSelected: function($event) {
                                                return _vm.onInvItemChanged(
                                                  $event,
                                                  machineRequestItem
                                                )
                                              }
                                            }
                                          })
                                        ],
                                        1
                                      )
                                    : _c("div", [
                                        _vm._v(
                                          "\n                                " +
                                            _vm._s(
                                              machineRequestItem.inv_item_number
                                            ) +
                                            "\n                            "
                                        )
                                      ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-left",
                                  staticStyle: { "min-width": "300px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(machineRequestItem.inv_item_desc) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-center",
                                  staticStyle: { "min-width": "100px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(machineRequestItem.uom_desc) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "160px" }
                                },
                                [
                                  _c("vue-numeric", {
                                    staticClass:
                                      "form-control input-sm text-right",
                                    staticStyle: { "min-width": "120px" },
                                    attrs: {
                                      separator: ",",
                                      precision: 2,
                                      minus: false,
                                      id: "input_request_qty_" + index,
                                      name: "request_qty_" + index
                                    },
                                    on: {
                                      change: function($event) {
                                        return _vm.onRequestQtyChanged(
                                          machineRequestItem
                                        )
                                      }
                                    },
                                    model: {
                                      value: machineRequestItem.request_qty,
                                      callback: function($$v) {
                                        _vm.$set(
                                          machineRequestItem,
                                          "request_qty",
                                          $$v
                                        )
                                      },
                                      expression:
                                        "machineRequestItem.request_qty"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-center",
                                  staticStyle: { "min-width": "60px" }
                                },
                                [
                                  _c("pm-el-select", {
                                    attrs: {
                                      name: "uom2",
                                      id: "input_uom2",
                                      "select-options": _vm.uomCodes,
                                      "option-key": "uom_code_value",
                                      "option-value": "uom_code_value",
                                      "option-label": "uom_code_label",
                                      value: machineRequestItem.uom2,
                                      filterable: true
                                    },
                                    on: {
                                      onSelected: function($event) {
                                        return _vm.onUOM2Changed(
                                          $event,
                                          machineRequestItem
                                        )
                                      }
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-center",
                                  staticStyle: { "min-width": "60px" }
                                },
                                [
                                  machineRequestItem.is_new_line
                                    ? _c(
                                        "button",
                                        {
                                          staticClass: "btn btn-sm btn-danger",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              return _vm.onDeleteItem(
                                                machineRequestItem
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
                                ]
                              )
                            ])
                          : _vm._e()
                      ]
                    })
                  ],
                  2
                )
              : _c("tbody", [_vm._m(1)])
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
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "60px" } },
          [_vm._v(" ลำดับที่ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "100px" } },
          [_vm._v(" รหัสวัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "300px" } },
          [_vm._v(" รายละเอียด ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "100px" } },
          [_vm._v(" หน่วยนับ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "160px" } },
          [_vm._v(" จำนวนที่ขอเบิกจากกองซ่อม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "60px" } },
          [_vm._v(" หน่วยเบิก ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center",
          staticStyle: { "min-width": "60px" }
        })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "9" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" ไม่พบข้อมูล ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);