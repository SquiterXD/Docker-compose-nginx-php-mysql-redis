(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_plans_approvals_yearly_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableSalePlans__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableSalePlans */ "./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue");
/* harmony import */ var _TablePlanLines__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TablePlanLines */ "./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    TableSalePlans: _TableSalePlans__WEBPACK_IMPORTED_MODULE_4__.default,
    TablePlanLines: _TablePlanLines__WEBPACK_IMPORTED_MODULE_5__.default
  },
  props: ["defaultData", "periodYears", "periodYearValue", "itemOptions", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "yearlyPlanVersionValue", "uomCodes"],
  mounted: function mounted() {
    var _this = this;

    if (this.periodYearValue && this.printTypeValue && this.saleTypeValue && this.sourceVersionValue) {
      this.getSourceVersions(this.periodYearValue, this.printTypeValue, this.saleTypeValue).then(function (value) {
        _this.getYearlyPlanData(_this.periodYearValue, _this.printTypeValue, _this.saleTypeValue, _this.sourceVersionValue, _this.yearlyPlanVersionValue);
      });
    }
  },
  data: function data() {
    return {
      organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
      organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      printType: this.printTypeValue ? this.printTypeValue : this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null,
      printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null,
      saleType: this.saleTypeValue ? this.saleTypeValue : this.saleTypes.length > 0 ? this.saleTypes[0].value : null,
      saleTypeLabel: this.saleTypeValue ? this.getPrintTypeLabel(this.saleTypes, this.saleTypeValue) : this.saleTypes.length > 0 ? this.saleTypes[0].description : null,
      sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
      sourceVersions: [],
      yearlyPlanHeader: null,
      yearlyPlanVersion: null,
      salePlans: [],
      salePlanSummary: null,
      yearlyPlanLines: [],
      periodYearMonths: [],
      yearlyPlanVersions: [],
      isNewlyCreate: false,
      isLoading: false
    };
  },
  computed: {},
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("period_year", this.periodYear ? this.periodYear : '');
      queryParams.set("print_type", this.printType ? this.printType : '');
      queryParams.set("sale_type", this.saleType ? this.saleType : '');
      queryParams.set("source_version", this.sourceVersion ? this.sourceVersion : '');
      queryParams.set("yearly_plan_version", this.yearlyPlanVersion ? this.yearlyPlanVersion : '');
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    onYearlyPlanChanged: function onYearlyPlanChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.periodYear = value;
                _this2.periodYearLabel = _this2.getPeriodYearLabel(_this2.periodYears, _this2.periodYear);

                _this2.setUrlParams();

                if (!(_this2.periodYear && _this2.printType && _this2.saleType)) {
                  _context.next = 7;
                  break;
                }

                _context.next = 6;
                return _this2.getSourceVersions(_this2.periodYear, _this2.printType, _this2.saleType);

              case 6:
                if (_this2.sourceVersion) {
                  _this2.getYearlyPlanData(_this2.periodYear, _this2.printType, _this2.saleType, _this2.sourceVersion, _this2.yearlyPlanVersion);
                }

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onSourceVersionChanged: function onSourceVersionChanged(value) {
      this.sourceVersion = value;
      this.setUrlParams(); // CLEAR DATA

      if (this.yearlyPlanLines.length == 0) {
        this.salePlans = [];
        this.salePlanSummary = null;
      } // if(this.periodYear && this.printType && this.saleType && this.sourceVersion) {
      //     this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
      // }

    },
    onPrintTypeChanged: function onPrintTypeChanged(value) {
      this.printType = value;
      this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
      this.setUrlParams();

      if (this.periodYear && this.printType && this.saleType && this.sourceVersion) {
        this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
      }
    },
    onSaleTypeChanged: function onSaleTypeChanged(value) {
      this.saleType = value;
      this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
      this.setUrlParams();

      if (this.periodYear && this.printType && this.saleType && this.sourceVersion) {
        this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
      }
    },
    onYearlyPlanVersionChanged: function onYearlyPlanVersionChanged(value) {
      this.yearlyPlanVersion = value;
      this.setUrlParams();

      if (this.periodYear && this.printType && this.saleType && this.sourceVersion) {
        this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.sourceVersion, this.yearlyPlanVersion);
      }
    },
    getPeriodYearLabel: function getPeriodYearLabel(periodYears, periodYear) {
      var foundPeriodYear = periodYears.find(function (item) {
        return item.period_year_value == periodYear;
      });
      return foundPeriodYear ? foundPeriodYear.period_year_label : "";
    },
    getPeriodNameLabel: function getPeriodNameLabel(periodNames, periodName) {
      var foundPeriodName = periodNames.find(function (item) {
        return item.period_name_value == periodName;
      });
      return foundPeriodName ? foundPeriodName.period_name_label : "";
    },
    getPrintTypeLabel: function getPrintTypeLabel(printTypes, printType) {
      var foundPrintType = printTypes.find(function (item) {
        return item.print_type_value == printType;
      });
      return foundPrintType ? foundPrintType.print_type_label : "";
    },
    getSaleTypeLabel: function getSaleTypeLabel(saleTypes, saleType) {
      var foundSaleType = saleTypes.find(function (item) {
        return item.value == saleType;
      });
      return foundSaleType ? foundSaleType.description : "";
    },
    getYearlyPlanData: function getYearlyPlanData(periodYear, printType, saleType, sourceVersion, version) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params, foundSourceVersion;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // show loading
                _this3.isLoading = true; // REFRESH DATA

                _this3.yearlyPlanHeader = null;
                _this3.yearlyPlanLines = [];
                _this3.yearlyPlanVersion = version;
                _this3.yearlyPlanVersions = [];
                _this3.salePlans = [];
                _this3.salePlanSummary = null;
                params = {
                  period_year: periodYear,
                  print_type: printType,
                  sale_type: saleType,
                  source_version: sourceVersion,
                  version: version
                };
                _context2.next = 10;
                return axios.get("/ajax/pm/plans/yearly/get-info", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 ".concat(_this3.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this3.printTypeLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(resData.message), "error");
                  } else {
                    _this3.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this3.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 ".concat(_this3.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this3.printTypeLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 10:
                if (!_this3.yearlyPlanHeader) {
                  _context2.next = 22;
                  break;
                }

                // FOUND PLAN
                _this3.yearlyPlanVersion = _this3.yearlyPlanHeader.version;

                if (!(_this3.sourceVersions.length > 0)) {
                  _context2.next = 20;
                  break;
                }

                foundSourceVersion = _this3.sourceVersions.find(function (item) {
                  return item.version == _this3.yearlyPlanHeader.source_version;
                });
                _this3.sourceVersion = foundSourceVersion ? foundSourceVersion.version : _this3.sourceVersions[0].version;
                _context2.next = 17;
                return _this3.onGetSalePlans();

              case 17:
                _context2.next = 19;
                return _this3.onGetYearlyPlanLines();

              case 19:
                _this3.setUrlParams();

              case 20:
                _context2.next = 23;
                break;

              case 22:
                _this3.yearlyPlanVersion = null;

              case 23:
                // hide loading
                _this3.isLoading = false;

              case 24:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getSourceVersions: function getSourceVersions(periodYear, printType, saleType) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // show loading
                _this4.isLoading = true; // REFRESH DATA

                _this4.sourceVersion = null;
                _this4.sourceVersions = [];
                params = {
                  period_year: periodYear,
                  print_type: printType,
                  sale_type: saleType
                };
                _context3.next = 6;
                return axios.get("/ajax/pm/plans/yearly/get-source-versions", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this4.sourceVersion = resData.source_version ? resData.source_version : null;
                    _this4.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];

                    if (_this4.sourceVersions.length <= 0) {
                      swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 (\u0E1D\u0E48\u0E32\u0E22\u0E02\u0E32\u0E22)", "error");
                    }
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(error.message), "error");
                  return;
                });

              case 6:
                // hide loading
                _this4.isLoading = false;

              case 7:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getPlanStatusDesc: function getPlanStatusDesc(status) {
      var statusDesc = "-";

      if (status) {
        var foundStatus = this.planStatuses.find(function (item) {
          return item.lookup_code == status;
        });
        statusDesc = foundStatus ? foundStatus.description : "-";
      }

      return statusDesc;
    },
    onGetSalePlans: function onGetSalePlans() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                // show loading
                _this5.isLoading = true;
                params = {
                  period_year: _this5.periodYear,
                  print_type: _this5.printType,
                  sale_type: _this5.saleType,
                  source_version: _this5.sourceVersion
                };
                _context4.next = 4;
                return axios.get("/ajax/pm/plans/yearly/get-sale-plans", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 (\u0E1D\u0E48\u0E32\u0E22\u0E02\u0E32\u0E22) ".concat(_this5.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this5.printTypeLabel, " | ").concat(resData.message), "error");
                  } else {
                    if (resData.sale_plans) {
                      var resSalePlans = JSON.parse(resData.sale_plans);

                      if (resSalePlans.length <= 0) {
                        swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 (\u0E1D\u0E48\u0E32\u0E22\u0E02\u0E32\u0E22) ".concat(_this5.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this5.printTypeLabel, " | ").concat(resData.message), "info");
                      } else {
                        _this5.salePlans = resSalePlans.map(function (item) {
                          return _objectSpread(_objectSpread({}, item), {}, {
                            total: _this5.getTotalSalePlanPerItem(item)
                          });
                        });
                        _this5.salePlanSummary = _this5.getSumAllSalePlanItem(resSalePlans);
                      }
                    }
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 (\u0E1D\u0E48\u0E32\u0E22\u0E02\u0E32\u0E22) ".concat(_this5.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this5.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this5.isLoading = false;

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getTotalSalePlanPerItem: function getTotalSalePlanPerItem(item) {
      var total = 0;
      var octValue = !isNaN(parseFloat(item.oct)) ? parseFloat(item.oct) : 0;
      var novValue = !isNaN(parseFloat(item.nov)) ? parseFloat(item.nov) : 0;
      var decValue = !isNaN(parseFloat(item.dec)) ? parseFloat(item.dec) : 0;
      var janValue = !isNaN(parseFloat(item.jan)) ? parseFloat(item.jan) : 0;
      var febValue = !isNaN(parseFloat(item.feb)) ? parseFloat(item.feb) : 0;
      var marValue = !isNaN(parseFloat(item.mar)) ? parseFloat(item.mar) : 0;
      var aprValue = !isNaN(parseFloat(item.apr)) ? parseFloat(item.apr) : 0;
      var mayValue = !isNaN(parseFloat(item.may)) ? parseFloat(item.may) : 0;
      var junValue = !isNaN(parseFloat(item.jun)) ? parseFloat(item.jun) : 0;
      var julValue = !isNaN(parseFloat(item.jul)) ? parseFloat(item.jul) : 0;
      var augValue = !isNaN(parseFloat(item.aug)) ? parseFloat(item.aug) : 0;
      var sepValue = !isNaN(parseFloat(item.sep)) ? parseFloat(item.sep) : 0;
      total = octValue + novValue + decValue + janValue + febValue + marValue + aprValue + mayValue + junValue + julValue + augValue + sepValue;
      return total;
    },
    getSumAllSalePlanItem: function getSumAllSalePlanItem(salePlans) {
      var sumAllItem = {
        oct: 0,
        nov: 0,
        dec: 0,
        jan: 0,
        feb: 0,
        mar: 0,
        apr: 0,
        may: 0,
        jun: 0,
        jul: 0,
        aug: 0,
        sep: 0,
        total: 0
      };
      var octValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.oct)) ? parseFloat(item.oct) : 0;
      });
      sumAllItem.oct = octValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var novValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.nov)) ? parseFloat(item.nov) : 0;
      });
      sumAllItem.nov = novValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var decValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.dec)) ? parseFloat(item.dec) : 0;
      });
      sumAllItem.dec = decValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var janValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.jan)) ? parseFloat(item.jan) : 0;
      });
      sumAllItem.jan = janValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var febValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.feb)) ? parseFloat(item.feb) : 0;
      });
      sumAllItem.feb = febValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var marValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.mar)) ? parseFloat(item.mar) : 0;
      });
      sumAllItem.mar = marValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var aprValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.apr)) ? parseFloat(item.apr) : 0;
      });
      sumAllItem.apr = aprValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var mayValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.may)) ? parseFloat(item.may) : 0;
      });
      sumAllItem.may = mayValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var junValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.jun)) ? parseFloat(item.jun) : 0;
      });
      sumAllItem.jun = junValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var julValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.jul)) ? parseFloat(item.jul) : 0;
      });
      sumAllItem.jul = julValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var augValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.aug)) ? parseFloat(item.aug) : 0;
      });
      sumAllItem.aug = augValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      var sepValues = salePlans.map(function (item) {
        return !isNaN(parseFloat(item.sep)) ? parseFloat(item.sep) : 0;
      });
      sumAllItem.sep = sepValues.reduce(function (acc, currValue) {
        return acc + currValue;
      }, 0);
      sumAllItem.total = sumAllItem.oct + sumAllItem.nov + sumAllItem.dec + sumAllItem.jan + sumAllItem.feb + sumAllItem.mar + sumAllItem.apr + sumAllItem.may + sumAllItem.jun + sumAllItem.jul + sumAllItem.aug + sumAllItem.sep;
      return sumAllItem;
    },
    onGetYearlyPlanLines: function onGetYearlyPlanLines() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // show loading
                _this6.isLoading = true;
                params = {
                  period_year: _this6.periodYear,
                  print_type: _this6.printType,
                  sale_type: _this6.saleType,
                  source_version: _this6.sourceVersion,
                  version: _this6.yearlyPlanVersion
                };
                _context5.next = 4;
                return axios.get("/ajax/pm/plans/yearly/get-lines", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this6.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    _this6.yearlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this6.yearlyPlanVersion = _this6.yearlyPlanHeader.version;
                    _this6.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E02\u0E2D\u0E07 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 ".concat(_this6.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this6.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E02\u0E2D\u0E07 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 ".concat(_this6.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this6.printTypeLabel, "  | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this6.isLoading = false;

              case 5:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    onGenerateYearlyPlanLines: function onGenerateYearlyPlanLines() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this7.isLoading = true;
                reqBody = {
                  period_year: _this7.periodYear,
                  print_type: _this7.printType,
                  sale_type: _this7.saleType,
                  source_version: _this7.sourceVersion,
                  version: _this7.yearlyPlanVersion
                };
                _context6.next = 4;
                return axios.post("/ajax/pm/plans/yearly/generate-lines", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this7.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    _this7.yearlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this7.yearlyPlanVersion = _this7.yearlyPlanHeader.version;
                    _this7.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this7.isNewlyCreate = resData.is_newly_create;
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E02\u0E2D\u0E07 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 ".concat(_this7.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this7.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E02\u0E2D\u0E07 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 ".concat(_this7.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this7.printTypeLabel, "  | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this7.isLoading = false;

              case 5:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onPlanLineChanged: function onPlanLineChanged(data) {
      this.yearlyPlanLines = data.planLineItems;
    },
    isAllowApproval: function isAllowApproval(planHeader, planLines) {
      var allowed = false;

      if (planHeader) {
        // ALLOW WHEN STATUS == 2 (WAIT_FOR_APPROVAL)
        if (planHeader.status == '2') {
          allowed = true;
        }
      }

      return allowed;
    },
    validateBeforeApproval: function validateBeforeApproval(planHeader, planLines) {
      var result = {
        valid: true,
        message: ""
      }; // // IF NEW LINE ISN'T COMPLETED
      // const incompletedLines = planLines.filter(item => {
      //     return item.is_new_line && (
      //         !item.item_code ||
      //         !item.user_gain_loss_qty ||
      //         !item.oct_buy_qty ||
      //         !item.nov_buy_qty ||
      //         !item.dec_buy_qty ||
      //         !item.jan_buy_qty ||
      //         !item.feb_buy_qty ||
      //         !item.mar_buy_qty ||
      //         !item.apr_buy_qty ||
      //         !item.may_buy_qty ||
      //         !item.jun_buy_qty ||
      //         !item.jul_buy_qty ||
      //         !item.aug_buy_qty ||
      //         !item.sep_buy_qty ||
      //         !item.percent
      //     ) && item.marked_as_deleted == false;
      // });
      // if(incompletedLines.length > 0) {
      //     result.valid = false;
      //     result.message = `กรอกข้อมูลรายการประมาณการวัตถุดิบประจำปีไม่ครบถ้วน กรุณาตรวจสอบ`
      // }

      return result;
    },
    onApprove: function onApprove() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                reqBody = {
                  period_year: _this8.periodYear,
                  print_type: _this8.printType,
                  sale_type: _this8.saleType,
                  source_version: _this8.sourceVersion,
                  version: _this8.yearlyPlanVersion,
                  plan_header: JSON.stringify(_this8.yearlyPlanHeader),
                  plan_lines: JSON.stringify(_this8.yearlyPlanLines)
                }; // show loading

                _this8.isLoading = true;
                resValidate = _this8.validateBeforeApproval(_this8.yearlyPlanHeader, _this8.yearlyPlanLines);

                if (!resValidate.valid) {
                  _context7.next = 8;
                  break;
                }

                _context7.next = 6;
                return axios.post("/ajax/pm/plans/yearly/approve", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                  if (resData.status == "success") {
                    _this8.yearlyPlanHeader = resPlanHeader;
                    _this8.yearlyPlanVersion = resPlanHeader.version;
                    _this8.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this8.isNewlyCreate = false;
                    swal("Success", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this8.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this8.printTypeLabel, " version : ").concat(_this8.yearlyPlanVersion, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this8.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this8.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this8.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this8.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 6:
                _context7.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this8.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this8.printTypeLabel, " | ").concat(resValidate.message), "error");

              case 9:
                // hide loading
                _this8.isLoading = false;

              case 10:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onReject: function onReject() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                reqBody = {
                  period_year: _this9.periodYear,
                  print_type: _this9.printType,
                  sale_type: _this9.saleType,
                  source_version: _this9.sourceVersion,
                  version: _this9.yearlyPlanVersion,
                  plan_header: JSON.stringify(_this9.yearlyPlanHeader),
                  plan_lines: JSON.stringify(_this9.yearlyPlanLines)
                }; // show loading

                _this9.isLoading = true;
                resValidate = _this9.validateBeforeApproval(_this9.yearlyPlanHeader, _this9.yearlyPlanLines);

                if (!resValidate.valid) {
                  _context8.next = 8;
                  break;
                }

                _context8.next = 6;
                return axios.post("/ajax/pm/plans/yearly/reject", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                  if (resData.status == "success") {
                    _this9.yearlyPlanHeader = resPlanHeader;
                    _this9.yearlyPlanVersion = resPlanHeader.version;
                    _this9.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this9.isNewlyCreate = false;
                    swal("Success", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this9.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this9.printTypeLabel, " version : ").concat(_this9.yearlyPlanVersion, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this9.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this9.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this9.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this9.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 6:
                _context8.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E43\u0E0A\u0E49 \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this9.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this9.printTypeLabel, " | ").concat(resValidate.message), "error");

              case 9:
                // hide loading
                _this9.isLoading = false;

              case 10:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    isAllowSelectSourceVersion: function isAllowSelectSourceVersion(planHeader, planLines) {
      var allowed = false;

      if (planHeader) {
        // ALLOW WHEN PLAN LINES WERE NOT GENERATED 
        if (planLines.length == 0) {
          allowed = true;
        }
      } else {
        // ALLOW WHEN PLAN'S NEVER BEEN CREATED
        allowed = true;
      }

      return allowed;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["planHeader", "planMonths", "planLines", "salePlanSummary", "itemOptions", "uomCodes"],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    planHeader: function planHeader(value) {
      this.planHeaderData = value;
    }
  },
  data: function data() {
    var _this = this;

    return {
      planHeaderData: this.planHeader,
      planLineItems: this.planLines.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          uom_desc: _this.getUomCodeDescription(_this.uomCodes, item.uom),
          // gain_loss_qty_m: (parseFloat(item.gain_loss_qty) / 1000000).toFixed(2),
          user_gain_loss_qty: item.attribute11 ? Number(item.attribute11).toFixed(2) : Number(item.gain_loss_qty).toFixed(2),
          // attribute11 == user_gain_loss_qty
          user_oct_req_qty: item.oct_req_qty ? item.oct_req_qty : 0,
          user_nov_req_qty: item.nov_req_qty ? item.nov_req_qty : 0,
          user_dec_req_qty: item.dec_req_qty ? item.dec_req_qty : 0,
          user_jan_req_qty: item.jan_req_qty ? item.jan_req_qty : 0,
          user_feb_req_qty: item.feb_req_qty ? item.feb_req_qty : 0,
          user_mar_req_qty: item.mar_req_qty ? item.mar_req_qty : 0,
          user_apr_req_qty: item.apr_req_qty ? item.apr_req_qty : 0,
          user_may_req_qty: item.may_req_qty ? item.may_req_qty : 0,
          user_jun_req_qty: item.jun_req_qty ? item.jun_req_qty : 0,
          user_jul_req_qty: item.jul_req_qty ? item.jul_req_qty : 0,
          user_aug_req_qty: item.aug_req_qty ? item.aug_req_qty : 0,
          user_sep_req_qty: item.sep_req_qty ? item.sep_req_qty : 0,
          oct_buy_qty: item.oct_buy_qty ? Number(item.oct_buy_qty).toFixed(2) : null,
          nov_buy_qty: item.nov_buy_qty ? Number(item.nov_buy_qty).toFixed(2) : null,
          dec_buy_qty: item.dec_buy_qty ? Number(item.dec_buy_qty).toFixed(2) : null,
          jan_buy_qty: item.jan_buy_qty ? Number(item.jan_buy_qty).toFixed(2) : null,
          feb_buy_qty: item.feb_buy_qty ? Number(item.feb_buy_qty).toFixed(2) : null,
          mar_buy_qty: item.mar_buy_qty ? Number(item.mar_buy_qty).toFixed(2) : null,
          apr_buy_qty: item.apr_buy_qty ? Number(item.apr_buy_qty).toFixed(2) : null,
          may_buy_qty: item.may_buy_qty ? Number(item.may_buy_qty).toFixed(2) : null,
          jun_buy_qty: item.jun_buy_qty ? Number(item.jun_buy_qty).toFixed(2) : null,
          jul_buy_qty: item.jul_buy_qty ? Number(item.jul_buy_qty).toFixed(2) : null,
          aug_buy_qty: item.aug_buy_qty ? Number(item.aug_buy_qty).toFixed(2) : null,
          sep_buy_qty: item.sep_buy_qty ? Number(item.sep_buy_qty).toFixed(2) : null,
          percent: item.percent ? item.percent : 100,
          total_req_qty: _this.calTotalReqQty(item),
          total_buy_qty: _this.calTotalBuyQty(item),
          is_new_line: item.attribute10 == "Y" ? true : false,
          // attribute10 == 'Y' => is_new_line == true
          marked_as_deleted: false
        });
      }).filter(function (value, index, self) {
        return index === self.findIndex(function (t) {
          return t.item_code === value.item_code;
        });
      }),
      planMonthItems: this.planMonths ? this.planMonths : []
    };
  },
  mounted: function mounted() {
    var _this2 = this;

    // EMIT UPDATE PARENT PLAN LINES
    this.planLineItems.forEach(function (planLineItem) {
      var userGainLossQty = parseFloat(planLineItem.user_gain_loss_qty);

      if (!isNaN(userGainLossQty)) {
        _this2.autoCalculateUserReqQty(userGainLossQty, planLineItem);

        if (!planLineItem.oct_buy_qty && !planLineItem.nov_buy_qty && !planLineItem.dec_buy_qty && !planLineItem.jan_buy_qty && !planLineItem.feb_buy_qty && !planLineItem.mar_buy_qty && !planLineItem.apr_buy_qty && !planLineItem.may_buy_qty && !planLineItem.jun_buy_qty && !planLineItem.jul_buy_qty && !planLineItem.aug_buy_qty && !planLineItem.sep_buy_qty) {
          // DEFAULT BUY QTY (FOR FIRST COMING LINES)
          _this2.autoCalculateBuyQty(planLineItem);
        }
      }
    });
  },
  computed: {},
  methods: {
    onUserGainLossQtyChanged: function onUserGainLossQtyChanged(planLineItem) {
      var userGainLossQty = parseFloat(planLineItem.user_gain_loss_qty);

      if (!isNaN(userGainLossQty)) {
        this.autoCalculateUserReqQty(userGainLossQty, planLineItem);
        this.autoCalculateBuyQty(planLineItem);
      }
    },
    calUserReqQty: function calUserReqQty(total, reqQty, gainLossQty) {
      return parseFloat(total) > 0 ? gainLossQty * parseFloat(reqQty) / parseFloat(total) : 0;
    },
    autoCalculateUserReqQty: function autoCalculateUserReqQty(userGainLossQty, planLineItem) {
      planLineItem.user_oct_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.oct, userGainLossQty);
      planLineItem.user_nov_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.nov, userGainLossQty);
      planLineItem.user_dec_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.dec, userGainLossQty);
      planLineItem.user_jan_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jan, userGainLossQty);
      planLineItem.user_feb_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.feb, userGainLossQty);
      planLineItem.user_mar_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.mar, userGainLossQty);
      planLineItem.user_apr_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.apr, userGainLossQty);
      planLineItem.user_may_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.may, userGainLossQty);
      planLineItem.user_jun_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jun, userGainLossQty);
      planLineItem.user_jul_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jul, userGainLossQty);
      planLineItem.user_aug_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.aug, userGainLossQty);
      planLineItem.user_sep_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.sep, userGainLossQty);

      if (planLineItem.is_new_line) {
        planLineItem.gain_loss_qty = parseFloat(planLineItem.user_gain_loss_qty);
        planLineItem.oct_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.oct, userGainLossQty);
        planLineItem.nov_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.nov, userGainLossQty);
        planLineItem.dec_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.dec, userGainLossQty);
        planLineItem.jan_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jan, userGainLossQty);
        planLineItem.feb_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.feb, userGainLossQty);
        planLineItem.mar_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.mar, userGainLossQty);
        planLineItem.apr_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.apr, userGainLossQty);
        planLineItem.may_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.may, userGainLossQty);
        planLineItem.jun_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jun, userGainLossQty);
        planLineItem.jul_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.jul, userGainLossQty);
        planLineItem.aug_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.aug, userGainLossQty);
        planLineItem.sep_req_qty = this.calUserReqQty(this.salePlanSummary.total, this.salePlanSummary.sep, userGainLossQty);
      }
    },
    calBuyQtyByPercent: function calBuyQtyByPercent(userReqQty, percent) {
      return userReqQty ? Number(parseFloat(userReqQty) * percent / 100).toFixed(2) : Number(0).toFixed(2);
    },
    onPercentChanged: function onPercentChanged(planLineItem) {
      if (planLineItem.percent < 0) {
        planLineItem.percent = 0;
      }

      if (planLineItem.percent > 100) {
        planLineItem.percent = 100;
      }

      this.autoCalculateBuyQty(planLineItem);
    },
    autoCalculateBuyQty: function autoCalculateBuyQty(planLineItem) {
      var percent = !isNaN(parseFloat(planLineItem.percent)) ? parseFloat(planLineItem.percent) : 100;
      planLineItem.oct_buy_qty = this.calBuyQtyByPercent(planLineItem.user_oct_req_qty, percent);
      planLineItem.nov_buy_qty = this.calBuyQtyByPercent(planLineItem.user_nov_req_qty, percent);
      planLineItem.dec_buy_qty = this.calBuyQtyByPercent(planLineItem.user_dec_req_qty, percent);
      planLineItem.jan_buy_qty = this.calBuyQtyByPercent(planLineItem.user_jan_req_qty, percent);
      planLineItem.feb_buy_qty = this.calBuyQtyByPercent(planLineItem.user_feb_req_qty, percent);
      planLineItem.mar_buy_qty = this.calBuyQtyByPercent(planLineItem.user_mar_req_qty, percent);
      planLineItem.apr_buy_qty = this.calBuyQtyByPercent(planLineItem.user_apr_req_qty, percent);
      planLineItem.may_buy_qty = this.calBuyQtyByPercent(planLineItem.user_may_req_qty, percent);
      planLineItem.jun_buy_qty = this.calBuyQtyByPercent(planLineItem.user_jun_req_qty, percent);
      planLineItem.jul_buy_qty = this.calBuyQtyByPercent(planLineItem.user_jul_req_qty, percent);
      planLineItem.aug_buy_qty = this.calBuyQtyByPercent(planLineItem.user_aug_req_qty, percent);
      planLineItem.sep_buy_qty = this.calBuyQtyByPercent(planLineItem.user_sep_req_qty, percent);
      planLineItem.total_buy_qty = this.calTotalBuyQty(planLineItem);
    },
    onBuyQtyChanged: function onBuyQtyChanged(planLineItem) {
      // formatNumber(value);
      planLineItem.total_buy_qty = this.calTotalBuyQty(planLineItem);
    },
    calTotalBuyQty: function calTotalBuyQty(planLineItem) {
      var total = 0;
      var octBuyQty = !isNaN(parseFloat(planLineItem.oct_buy_qty)) ? parseFloat(planLineItem.oct_buy_qty) : 0;
      var novBuyQty = !isNaN(parseFloat(planLineItem.nov_buy_qty)) ? parseFloat(planLineItem.nov_buy_qty) : 0;
      var decBuyQty = !isNaN(parseFloat(planLineItem.dec_buy_qty)) ? parseFloat(planLineItem.dec_buy_qty) : 0;
      var janBuyQty = !isNaN(parseFloat(planLineItem.jan_buy_qty)) ? parseFloat(planLineItem.jan_buy_qty) : 0;
      var febBuyQty = !isNaN(parseFloat(planLineItem.feb_buy_qty)) ? parseFloat(planLineItem.feb_buy_qty) : 0;
      var marBuyQty = !isNaN(parseFloat(planLineItem.mar_buy_qty)) ? parseFloat(planLineItem.mar_buy_qty) : 0;
      var aprBuyQty = !isNaN(parseFloat(planLineItem.apr_buy_qty)) ? parseFloat(planLineItem.apr_buy_qty) : 0;
      var mayBuyQty = !isNaN(parseFloat(planLineItem.may_buy_qty)) ? parseFloat(planLineItem.may_buy_qty) : 0;
      var junBuyQty = !isNaN(parseFloat(planLineItem.jun_buy_qty)) ? parseFloat(planLineItem.jun_buy_qty) : 0;
      var julBuyQty = !isNaN(parseFloat(planLineItem.jul_buy_qty)) ? parseFloat(planLineItem.jul_buy_qty) : 0;
      var augBuyQty = !isNaN(parseFloat(planLineItem.aug_buy_qty)) ? parseFloat(planLineItem.aug_buy_qty) : 0;
      var sepBuyQty = !isNaN(parseFloat(planLineItem.sep_buy_qty)) ? parseFloat(planLineItem.sep_buy_qty) : 0;
      total = octBuyQty + novBuyQty + decBuyQty + janBuyQty + febBuyQty + marBuyQty + aprBuyQty + mayBuyQty + junBuyQty + julBuyQty + augBuyQty + sepBuyQty;
      return total.toFixed(2);
    },
    calTotalReqQty: function calTotalReqQty(planLineItem) {
      var total = 0;
      var octReqQty = !isNaN(parseFloat(planLineItem.oct_req_qty)) ? parseFloat(planLineItem.oct_req_qty) : 0;
      var novReqQty = !isNaN(parseFloat(planLineItem.nov_req_qty)) ? parseFloat(planLineItem.nov_req_qty) : 0;
      var decReqQty = !isNaN(parseFloat(planLineItem.dec_req_qty)) ? parseFloat(planLineItem.dec_req_qty) : 0;
      var janReqQty = !isNaN(parseFloat(planLineItem.jan_req_qty)) ? parseFloat(planLineItem.jan_req_qty) : 0;
      var febReqQty = !isNaN(parseFloat(planLineItem.feb_req_qty)) ? parseFloat(planLineItem.feb_req_qty) : 0;
      var marReqQty = !isNaN(parseFloat(planLineItem.mar_req_qty)) ? parseFloat(planLineItem.mar_req_qty) : 0;
      var aprReqQty = !isNaN(parseFloat(planLineItem.apr_req_qty)) ? parseFloat(planLineItem.apr_req_qty) : 0;
      var mayReqQty = !isNaN(parseFloat(planLineItem.may_req_qty)) ? parseFloat(planLineItem.may_req_qty) : 0;
      var junReqQty = !isNaN(parseFloat(planLineItem.jun_req_qty)) ? parseFloat(planLineItem.jun_req_qty) : 0;
      var julReqQty = !isNaN(parseFloat(planLineItem.jul_req_qty)) ? parseFloat(planLineItem.jul_req_qty) : 0;
      var augReqQty = !isNaN(parseFloat(planLineItem.aug_req_qty)) ? parseFloat(planLineItem.aug_req_qty) : 0;
      var sepReqQty = !isNaN(parseFloat(planLineItem.sep_req_qty)) ? parseFloat(planLineItem.sep_req_qty) : 0;
      total = octReqQty + novReqQty + decReqQty + janReqQty + febReqQty + marReqQty + aprReqQty + mayReqQty + junReqQty + julReqQty + augReqQty + sepReqQty;
      return total.toFixed(2);
    },
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code == uomCode;
      });
      return foundUomCode ? foundUomCode.unit_of_measure : "";
    },
    formatNumber: function formatNumber(value) {
      var result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return result;
    },
    isNumber: function isNumber(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;

      if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
        evt.preventDefault();
        ;
      } else {
        return true;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["salePlans", "salePlanSummary"],
  data: function data() {
    return {
      salePlanItems: this.salePlans.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          oct_converted: Number(parseFloat(item.oct) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          nov_converted: Number(parseFloat(item.nov) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          dec_converted: Number(parseFloat(item.dec) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          jan_converted: Number(parseFloat(item.jan) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          feb_converted: Number(parseFloat(item.feb) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          mar_converted: Number(parseFloat(item.mar) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          apr_converted: Number(parseFloat(item.apr) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          may_converted: Number(parseFloat(item.may) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          jun_converted: Number(parseFloat(item.jun) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          jul_converted: Number(parseFloat(item.jul) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          aug_converted: Number(parseFloat(item.aug) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          sep_converted: Number(parseFloat(item.sep) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }),
          total_converted: Number(parseFloat(item.total) / 1000).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          })
        });
      }),
      salePlanSummaryItem: _objectSpread(_objectSpread({}, this.salePlanSummary), {}, {
        oct_converted: Number(parseFloat(this.salePlanSummary.oct) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        nov_converted: Number(parseFloat(this.salePlanSummary.nov) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        dec_converted: Number(parseFloat(this.salePlanSummary.dec) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        jan_converted: Number(parseFloat(this.salePlanSummary.jan) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        feb_converted: Number(parseFloat(this.salePlanSummary.feb) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        mar_converted: Number(parseFloat(this.salePlanSummary.mar) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        apr_converted: Number(parseFloat(this.salePlanSummary.apr) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        may_converted: Number(parseFloat(this.salePlanSummary.may) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        jun_converted: Number(parseFloat(this.salePlanSummary.jun) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        jul_converted: Number(parseFloat(this.salePlanSummary.jul) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        aug_converted: Number(parseFloat(this.salePlanSummary.aug) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        sep_converted: Number(parseFloat(this.salePlanSummary.sep) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        }),
        total_converted: Number(parseFloat(this.salePlanSummary.total) / 1000).toLocaleString(undefined, {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
      })
    };
  },
  computed: {},
  methods: {}
});

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/Index.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/Index.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_0a1791b0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=0a1791b0& */ "./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=template&id=0a1791b0&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_0a1791b0___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_0a1791b0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/approvals/yearly/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TablePlanLines_vue_vue_type_template_id_962c1e7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=template&id=962c1e7c& */ "./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=template&id=962c1e7c&");
/* harmony import */ var _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TablePlanLines_vue_vue_type_template_id_962c1e7c___WEBPACK_IMPORTED_MODULE_0__.render,
  _TablePlanLines_vue_vue_type_template_id_962c1e7c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableSalePlans_vue_vue_type_template_id_39210962___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableSalePlans.vue?vue&type=template&id=39210962& */ "./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=template&id=39210962&");
/* harmony import */ var _TableSalePlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableSalePlans.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableSalePlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableSalePlans_vue_vue_type_template_id_39210962___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableSalePlans_vue_vue_type_template_id_39210962___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSalePlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSalePlans.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSalePlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=template&id=0a1791b0&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=template&id=0a1791b0& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_0a1791b0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_0a1791b0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_0a1791b0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=0a1791b0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=template&id=0a1791b0&");


/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=template&id=962c1e7c&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=template&id=962c1e7c& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_962c1e7c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_962c1e7c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_962c1e7c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=template&id=962c1e7c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=template&id=962c1e7c&");


/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=template&id=39210962&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=template&id=39210962& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSalePlans_vue_vue_type_template_id_39210962___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSalePlans_vue_vue_type_template_id_39210962___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSalePlans_vue_vue_type_template_id_39210962___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSalePlans.vue?vue&type=template&id=39210962& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=template&id=39210962&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=template&id=0a1791b0&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/Index.vue?vue&type=template&id=0a1791b0& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
                  staticClass:
                    "btn btn-inline-block btn-sm btn-success tw-w-40",
                  attrs: {
                    disabled: !_vm.isAllowApproval(
                      _vm.yearlyPlanHeader,
                      _vm.yearlyPlanLines
                    )
                  },
                  on: { click: _vm.onApprove }
                },
                [
                  _c("i", { staticClass: "fa fa-check tw-mr-1" }),
                  _vm._v(" อนุมัติ \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-danger tw-w-40",
                  attrs: {
                    disabled: !_vm.isAllowApproval(
                      _vm.yearlyPlanHeader,
                      _vm.yearlyPlanLines
                    )
                  },
                  on: { click: _vm.onReject }
                },
                [
                  _c("i", { staticClass: "fa fa-times tw-mr-1" }),
                  _vm._v(" ไม่อนุมัติ \n                ")
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
                    [_vm._v(" ระบบการพิมพ์ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "print_type",
                          id: "input_print_type",
                          "select-options": _vm.printTypes,
                          "option-key": "print_type_value",
                          "option-value": "print_type_value",
                          "option-label": "print_type_label",
                          value: _vm.printType,
                          filterable: true
                        },
                        on: { onSelected: _vm.onPrintTypeChanged }
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
                    [_vm._v(" ประเภทแผน ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "sale_type",
                          id: "sale_type",
                          "select-options": _vm.saleTypes,
                          "option-key": "value",
                          "option-value": "value",
                          "option-label": "description",
                          value: _vm.saleType,
                          filterable: true
                        },
                        on: { onSelected: _vm.onSaleTypeChanged }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _vm._m(0),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-3" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "period_year",
                          id: "input_period_year",
                          "select-options": _vm.periodYears,
                          "option-key": "period_year_value",
                          "option-value": "period_year_value",
                          "option-label": "period_year_label",
                          value: _vm.periodYear,
                          filterable: true
                        },
                        on: { onSelected: _vm.onYearlyPlanChanged }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "label",
                    { staticClass: "col-md-2 col-form-label tw-font-bold" },
                    [_vm._v(" ครั้งที่ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-3" },
                    [
                      _vm.isAllowSelectSourceVersion(
                        _vm.yearlyPlanHeader,
                        _vm.yearlyPlanLines
                      )
                        ? _c("pm-el-select", {
                            attrs: {
                              name: "source_version",
                              id: "source_version",
                              "select-options": _vm.sourceVersions,
                              "option-key": "version",
                              "option-value": "version",
                              "option-label": "version",
                              value: _vm.sourceVersion,
                              filterable: true
                            },
                            on: { onSelected: _vm.onSourceVersionChanged }
                          })
                        : _vm._e(),
                      _vm._v(" "),
                      !_vm.isAllowSelectSourceVersion(
                        _vm.yearlyPlanHeader,
                        _vm.yearlyPlanLines
                      )
                        ? _c("p", { staticClass: "col-form-label" }, [
                            _vm._v(" " + _vm._s(_vm.sourceVersion) + " ")
                          ])
                        : _vm._e()
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" เวอร์ชั่น ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "yearly_plan_version",
                          id: "input_yearly_plan_version",
                          "select-options": _vm.yearlyPlanVersions,
                          "option-key": "version",
                          "option-value": "version",
                          "option-label": "version",
                          value: _vm.yearlyPlanVersion,
                          filterable: true
                        },
                        on: { onSelected: _vm.onYearlyPlanVersionChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6" }, [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" สถานะ ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.yearlyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(
                                _vm.getPlanStatusDesc(
                                  _vm.yearlyPlanHeader.status
                                )
                              ) +
                              " "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.yearlyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(" - ")
                        ])
                      : _vm._e()
                  ])
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _vm.salePlans.length > 0 ? _c("hr") : _vm._e(),
          _vm._v(" "),
          _vm.salePlans.length > 0
            ? _c("div", { staticClass: "tw-m-8" }, [
                _c("h3", [_vm._v(" แผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย) ")]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-12" },
                    [
                      _c("table-sale-plans", {
                        attrs: {
                          "sale-plans": _vm.salePlans,
                          "sale-plan-summary": _vm.salePlanSummary
                        }
                      })
                    ],
                    1
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.yearlyPlanLines.length > 0 ? _c("hr") : _vm._e(),
          _vm._v(" "),
          _vm.yearlyPlanLines.length > 0
            ? _c("div", { staticClass: "tw-m-8" }, [
                _c("h3", [_vm._v(" รายการวัตถุดิบ ")]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-12" },
                    [
                      _c("table-plan-lines", {
                        attrs: {
                          "plan-header": _vm.yearlyPlanHeader,
                          "plan-lines": _vm.yearlyPlanLines,
                          "plan-months": _vm.periodYearMonths,
                          "uom-codes": _vm.uomCodes,
                          "sale-plan-summary": _vm.salePlanSummary,
                          "item-options": _vm.itemOptions
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
    return _c(
      "label",
      { staticClass: "col-md-4 col-form-label tw-font-bold tw-pt-0" },
      [_vm._v(" แผนประมาณการ "), _c("br"), _vm._v(" จำหน่ายประจำปี ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row form-group" }, [
      _c("label", { staticClass: "col-md-4 col-form-label tw-font-bold" }, [
        _vm._v(" หน่วยงาน ")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-8" }, [
        _c("p", { staticClass: "col-form-label" }, [
          _vm._v(" ฝ่ายการพิมพ์ กองพิมพ์ ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=template&id=962c1e7c&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TablePlanLines.vue?vue&type=template&id=962c1e7c& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
        staticStyle: { "max-height": "400px" }
      },
      [
        _c(
          "table",
          {
            staticClass: "table table-bordered table-sticky mb-0",
            staticStyle: { "min-width": "4100px" }
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm.planLineItems.length > 0
              ? _c(
                  "tbody",
                  { staticClass: "yearly-lines" },
                  [
                    _vm._l(_vm.planLineItems, function(planLineItem, index) {
                      return [
                        !planLineItem.marked_as_deleted
                          ? _c("tr", { key: "" + index }, [
                              _c(
                                "td",
                                {
                                  staticClass: "freeze-col",
                                  staticStyle: { "min-width": "480px" }
                                },
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "freeze-col-content",
                                      staticStyle: { padding: "0px" }
                                    },
                                    [
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-inline-block tw-align-top tw-py-4 tw-pr-2",
                                          staticStyle: {
                                            "min-width": "120px",
                                            "max-width": "120px",
                                            "vertical-align": "top"
                                          }
                                        },
                                        [
                                          _c(
                                            "div",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                        " +
                                                  _vm._s(
                                                    planLineItem.item_code
                                                  ) +
                                                  " \n                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-inline-block tw-align-top tw-py-4 tw-pl-4",
                                          staticStyle: {
                                            "min-height": "30px",
                                            "min-width": "320px",
                                            "max-width": "320px",
                                            "border-left": "1px solid #ddd"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(planLineItem.description) +
                                              "\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-right scroll-col",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.gain_loss_qty
                                          ? Number(
                                              planLineItem.gain_loss_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-right scroll-col",
                                  staticStyle: { "min-width": "152px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.user_gain_loss_qty
                                            ? Number(
                                                planLineItem.user_gain_loss_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-center",
                                  staticStyle: { "min-width": "120px" }
                                },
                                [
                                  _vm._v(
                                    " " + _vm._s(planLineItem.uom_desc) + " "
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
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(planLineItem.percent) +
                                        "\n                            "
                                    )
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.oct_req_qty
                                          ? Number(
                                              planLineItem.oct_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.oct_buy_qty
                                            ? Number(
                                                planLineItem.oct_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.nov_req_qty
                                          ? Number(
                                              planLineItem.nov_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.nov_buy_qty
                                            ? Number(
                                                planLineItem.nov_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.dec_req_qty
                                          ? Number(
                                              planLineItem.dec_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.dec_buy_qty
                                            ? Number(
                                                planLineItem.dec_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.jan_req_qty
                                          ? Number(
                                              planLineItem.jan_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.jan_buy_qty
                                            ? Number(
                                                planLineItem.jan_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.feb_req_qty
                                          ? Number(
                                              planLineItem.feb_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.feb_buy_qty
                                            ? Number(
                                                planLineItem.feb_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.mar_req_qty
                                          ? Number(
                                              planLineItem.mar_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.mar_buy_qty
                                            ? Number(
                                                planLineItem.mar_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.apr_req_qty
                                          ? Number(
                                              planLineItem.apr_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.apr_buy_qty
                                            ? Number(
                                                planLineItem.apr_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.may_req_qty
                                          ? Number(
                                              planLineItem.may_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.may_buy_qty
                                            ? Number(
                                                planLineItem.may_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.jun_req_qty
                                          ? Number(
                                              planLineItem.jun_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.jun_buy_qty
                                            ? Number(
                                                planLineItem.jun_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.jul_req_qty
                                          ? Number(
                                              planLineItem.jul_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.jul_buy_qty
                                            ? Number(
                                                planLineItem.jul_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.aug_req_qty
                                          ? Number(
                                              planLineItem.aug_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.aug_buy_qty
                                            ? Number(
                                                planLineItem.aug_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _vm._v(
                                    " \n                            " +
                                      _vm._s(
                                        planLineItem.sep_req_qty
                                          ? Number(
                                              planLineItem.sep_req_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "140px" }
                                },
                                [
                                  _c("div", [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(
                                          planLineItem.sep_buy_qty
                                            ? Number(
                                                planLineItem.sep_buy_qty
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : ""
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
                                  staticClass: "scroll-col text-right",
                                  staticStyle: { "min-width": "200px" }
                                },
                                [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        planLineItem.total_buy_qty
                                          ? Number(
                                              planLineItem.total_buy_qty
                                            ).toLocaleString(undefined, {
                                              minimumFractionDigits: 2,
                                              maximumFractionDigits: 2
                                            })
                                          : ""
                                      ) +
                                      " "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c("td", {
                                staticClass: "scroll-col text-center",
                                staticStyle: { "min-width": "60px" }
                              })
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
          {
            staticClass: "freeze-col",
            staticStyle: { "min-width": "480px" },
            attrs: { rowspan: "2" }
          },
          [
            _c(
              "div",
              {
                staticClass: "freeze-col-content",
                staticStyle: { padding: "0px" }
              },
              [
                _c(
                  "div",
                  {
                    staticClass:
                      "text-center tw-inline-block tw-align-top tw-py-4",
                    staticStyle: { "min-width": "120px", "max-width": "120px" }
                  },
                  [
                    _vm._v(
                      "\n                                รหัสวัตถุดิบ \n                            "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "text-center tw-inline-block tw-align-top tw-py-4",
                    staticStyle: {
                      "min-height": "30px",
                      "min-width": "320px",
                      "max-width": "320px",
                      "border-left": "1px solid #ddd"
                    }
                  },
                  [
                    _vm._v(
                      "\n                                รายละเอียด \n                            "
                    )
                  ]
                )
              ]
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px" },
            attrs: { rowspan: "2" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "152px" },
            attrs: { rowspan: "2" }
          },
          [_vm._v(" ปริมาณที่ต้องใช้ + สูญเสีย / ล้านมวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "120px" },
            attrs: { rowspan: "2" }
          },
          [_vm._v(" หน่วยนับ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "100px" },
            attrs: { rowspan: "2" }
          },
          [_vm._v(" % การใข้งาน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" ตุลาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" พฤศจิกายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" ธันวาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" มกราคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" กุมภาพันธ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" มีนาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" เมษายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" พฤษภาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" มิถุนายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" กรกฎาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" สิงหาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "280px" },
            attrs: { colspan: "2" }
          },
          [_vm._v(" กันยายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "200px" },
            attrs: { rowspan: "2" }
          },
          [_vm._v(" รวม ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center",
          staticStyle: { "min-width": "60px" },
          attrs: { rowspan: "2" }
        })
      ]),
      _vm._v(" "),
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ระบบคำนวน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "140px", top: "34px" }
          },
          [_vm._v(" ประมาณการใช้ ")]
        )
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=template&id=39210962&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/yearly/TableSalePlans.vue?vue&type=template&id=39210962& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "table-responsive", staticStyle: { "max-height": "320px" } },
    [
      _c(
        "table",
        {
          staticClass: "table table-sticky table-bordered mb-0",
          staticStyle: { "min-width": "1306px" }
        },
        [
          _vm._m(0),
          _vm._v(" "),
          _vm.salePlanItems.length > 0
            ? _c(
                "tbody",
                [
                  _vm._l(_vm.salePlanItems, function(salePlanItem, bIndex) {
                    return [
                      _c("tr", { key: "" + bIndex }, [
                        _c(
                          "td",
                          {
                            staticClass: "text-center freeze-col",
                            staticStyle: { "min-width": "320px" }
                          },
                          [
                            _c(
                              "div",
                              {
                                staticClass: "freeze-col-content",
                                staticStyle: { padding: "0px" }
                              },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "text-center tw-inline-block tw-py-4",
                                    staticStyle: {
                                      "min-width": "100px",
                                      "max-width": "100px"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(salePlanItem.item_code) +
                                        "\n                            "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "text-center tw-inline-block tw-py-4",
                                    staticStyle: {
                                      "min-width": "180px",
                                      "max-width": "180px",
                                      "border-left": "1px solid #ddd"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                " +
                                        _vm._s(salePlanItem.item_description) +
                                        " \n                            "
                                    )
                                  ]
                                )
                              ]
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.oct_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.nov_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.dec_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.jan_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.feb_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.mar_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.apr_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.may_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.jun_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.jul_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.aug_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "92px",
                              "max-width": "92px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.sep_converted) + " "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right",
                            staticStyle: {
                              "min-width": "200px",
                              "max-width": "200px"
                            }
                          },
                          [
                            _vm._v(
                              " " + _vm._s(salePlanItem.total_converted) + " "
                            )
                          ]
                        )
                      ])
                    ]
                  }),
                  _vm._v(" "),
                  _c("tr", [
                    _vm._m(1),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.oct_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.nov_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.dec_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.jan_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.feb_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.mar_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.apr_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.may_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.jun_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.jul_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.aug_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "92px",
                          "max-width": "92px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.sep_converted) +
                            " "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-right",
                        staticStyle: {
                          "min-width": "200px",
                          "max-width": "200px"
                        }
                      },
                      [
                        _vm._v(
                          " " +
                            _vm._s(_vm.salePlanSummaryItem.total_converted) +
                            " "
                        )
                      ]
                    )
                  ])
                ],
                2
              )
            : _c("tbody", [_vm._m(2)])
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
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center freeze-col",
            staticStyle: { "min-width": "320px" }
          },
          [
            _c(
              "div",
              {
                staticClass: "freeze-col-content",
                staticStyle: { padding: "0px" }
              },
              [
                _c(
                  "div",
                  {
                    staticClass: "text-center tw-inline-block tw-py-4",
                    staticStyle: { "min-width": "100px", "max-width": "100px" }
                  },
                  [
                    _vm._v(
                      "\n                            รหัสสินค้า\n                        "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "text-center tw-inline-block tw-py-4",
                    staticStyle: {
                      "min-width": "180px",
                      "max-width": "180px",
                      "border-left": "1px solid #ddd"
                    }
                  },
                  [
                    _vm._v(
                      "\n                            ตราบุหรี่ \n                        "
                    )
                  ]
                )
              ]
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" ตุลาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" พฤศจิกายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" ธันวาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" มกราคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" กุมภาพันธ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" มีนาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" เมษายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" พฤษภาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" มิถุนายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" กรกฎาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" สิงหาคม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "92px", "max-width": "92px" }
          },
          [_vm._v(" กันยายน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "min-width": "200px", "max-width": "200px" }
          },
          [_vm._v(" รวม ")]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-left tw-bg-white freeze-col",
        staticStyle: { "min-width": "320px", "max-width": "320px" }
      },
      [
        _c(
          "div",
          {
            staticClass: "freeze-col-content",
            staticStyle: { padding: "0px" }
          },
          [
            _c("div", { staticClass: "tw-inline-block tw-py-4" }, [
              _vm._v(
                "\n                            ยอดรวมทุกตรา \n                        "
              )
            ])
          ]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "13" } }, [
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