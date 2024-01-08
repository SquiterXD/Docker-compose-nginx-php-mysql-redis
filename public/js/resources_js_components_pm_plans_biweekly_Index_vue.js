(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_plans_biweekly_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TablePlanLines__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TablePlanLines */ "./resources/js/components/pm/plans/biweekly/TablePlanLines.vue");
/* harmony import */ var _ModalSearchPlan__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalSearchPlan */ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue");


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TablePlanLines: _TablePlanLines__WEBPACK_IMPORTED_MODULE_4__.default,
    ModalSearchPlan: _ModalSearchPlan__WEBPACK_IMPORTED_MODULE_5__.default
  },
  props: ["periodYears", "periodYearValue", "periodNameValue", "biweeklyValue", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "uomCodes"],
  mounted: function mounted() {
    var _this = this;

    if (this.periodYearValue) {
      // GET MONTH OF PLANS
      this.getPeriodNames(this.periodYearValue).then(function (value) {
        if (_this.periodNameValue) {
          _this.periodNameLabel = _this.getPeriodNameLabel(_this.periodNames, _this.periodNameValue);

          _this.getBiweekOfPlans(_this.periodYearValue, _this.periodNameValue).then(function (value) {
            if (_this.biweeklyValue && _this.printTypeValue && _this.saleTypeValue && _this.sourceVersionValue) {
              // GET HALF-MONTHLY PLAN DATA
              _this.getSourceVersions(_this.periodYearValue, _this.periodNameValue, _this.printTypeValue, _this.saleTypeValue).then(function (value) {
                _this.getBiweeklyPlanData(_this.periodYearValue, _this.periodNameValue, _this.biweeklyValue, _this.printTypeValue, _this.saleTypeValue, _this.sourceVersionValue, null);
              });
            }
          });
        }
      });
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      periodName: this.periodNameValue,
      periodNameLabel: "",
      biweekly: this.biweeklyValue,
      printType: this.printTypeValue ? this.printTypeValue : this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null,
      printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null,
      saleType: this.saleTypeValue ? this.saleTypeValue : this.saleTypes.length > 0 ? this.saleTypes[0].value : null,
      saleTypeLabel: this.saleTypeValue ? this.getPrintTypeLabel(this.saleTypes, this.saleTypeValue) : this.saleTypes.length > 0 ? this.saleTypes[0].description : null,
      sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
      sourceVersions: [],
      periodNames: [],
      biweeklys: [],
      biweeklyPlanHeader: null,
      biweeklyPlanVersion: null,
      biweeklyPlanLines: [],
      biweeklyPlanVersions: [],
      isNewlyCreate: false,
      isLoading: false
    };
  },
  computed: {},
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("period_year", this.periodYear ? this.periodYear : '');
      queryParams.set("period_name", this.periodName ? this.periodName : '');
      queryParams.set("biweekly", this.biweekly ? this.biweekly : '');
      queryParams.set("print_type", this.printType ? this.printType : '');
      queryParams.set("sale_type", this.saleType ? this.saleType : '');
      queryParams.set("source_version", this.sourceVersion ? this.sourceVersion : '');
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    onYearlyPlanChanged: function onYearlyPlanChanged(value) {
      this.periodYear = value;
      this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
      this.setUrlParams(); // REFRESH DATA

      this.periodName = null;
      this.periodNameLabel = "";
      this.periodNames = [];
      this.biweekly = null;
      this.biweeklys = [];
      this.sourceVersion = null;
      this.sourceVersions = [];
      this.biweeklyPlanHeader = null;
      this.biweeklyPlanVersion = null;
      this.biweeklyPlanVersions = [];
      this.biweeklyPlanLines = [];
      this.getPeriodNames(this.periodYear);
    },
    onPeriodNameChanged: function onPeriodNameChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.periodName = value;
                _this2.periodNameLabel = _this2.getPeriodNameLabel(_this2.periodNames, _this2.periodName);

                _this2.setUrlParams(); // REFRESH DATA


                _this2.biweekly = null;
                _this2.biweeklys = [];
                _this2.biweeklyPlanHeader = null;
                _this2.biweeklyPlanVersion = null;
                _this2.biweeklyPlanVersions = [];
                _this2.biweeklyPlanLines = [];
                _context.next = 11;
                return _this2.getSourceVersions(_this2.periodYear, _this2.periodName, _this2.printType, _this2.saleType);

              case 11:
                _this2.getBiweekOfPlans(_this2.periodYear, _this2.periodName);

              case 12:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onBiweekOfPlanChanged: function onBiweekOfPlanChanged(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.biweekly = value;

                _this3.setUrlParams();

                _this3.biweeklyPlanVersion = null;
                _this3.biweeklyPlanVersions = [];

                if (_this3.periodYear && _this3.periodName && _this3.biweekly && _this3.printType && _this3.saleType && _this3.sourceVersion) {
                  _this3.getBiweeklyPlanData(_this3.periodYear, _this3.periodName, _this3.biweekly, _this3.printType, _this3.saleType, _this3.sourceVersion, null);
                }

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onSourceVersionChanged: function onSourceVersionChanged(value) {
      this.sourceVersion = value;
      this.setUrlParams(); // if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
      //     this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
      // }
    },
    onPrintTypeChanged: function onPrintTypeChanged(value) {
      this.printType = value;
      this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
      this.setUrlParams();

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onSaleTypeChanged: function onSaleTypeChanged(value) {
      this.saleType = value;
      this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
      this.setUrlParams();

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onSearchPlanVersion: function onSearchPlanVersion(data) {
      this.periodYear = data.period_year;
      this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
      this.periodName = data.period_name;
      this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);
      this.biweekly = data.biweekly;
      this.biweeklyPlanVersion = data.version;
      this.printType = data.print_type;
      this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
      this.saleType = data.sale_type;
      this.saleTypeLabel = this.getPrintTypeLabel(this.saleTypes, this.saleType);
      this.sourceVersion = data.source_version;
      this.sourceVersions = data.source_versions;
      this.biweeklyPlanLines = [];
      this.getPeriodNames(this.periodYear);
      this.getBiweekOfPlans(this.periodYear, this.periodName);

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, this.biweeklyPlanVersion);
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
    getPeriodNames: function getPeriodNames(periodYear) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // show loading
                _this4.isLoading = true;
                params = {
                  period_year: periodYear
                };
                _context3.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-months", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.period_names ? JSON.parse(resData.period_names) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E35 ".concat(_this4.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this4.periodNames = _context3.sent;
                // hide loading
                _this4.isLoading = false;

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getBiweekOfPlans: function getBiweekOfPlans(periodYear, periodName) {
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
                  period_year: periodYear,
                  period_name: periodName
                };
                _context4.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-biweeks", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E40\u0E14\u0E37\u0E2D\u0E19 : ".concat(_this5.periodNameLabel, " \u0E1B\u0E35 ").concat(_this5.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this5.biweeklys = _context4.sent;
                // hide loading
                _this5.isLoading = false;

              case 6:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getBiweeklyPlanData: function getBiweeklyPlanData(periodYear, periodName, biweekly, printType, saleType, sourceVersion, version) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var params, foundSourceVersion;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // show loading
                _this6.isLoading = true; // REFRESH DATA

                _this6.biweeklyPlanHeader = null;
                _this6.biweeklyPlanVersion = version;
                _this6.biweeklyPlanVersions = [];
                _this6.biweeklyPlanLines = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  print_type: printType,
                  sale_type: saleType,
                  source_version: sourceVersion,
                  version: version
                };
                _context5.next = 8;
                return axios.get("/ajax/pm/plans/biweekly/get-info", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  _this6.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                  _this6.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this6.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this6.periodNameLabel, " \u0E1B\u0E35 ").concat(_this6.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 8:
                if (!_this6.biweeklyPlanHeader) {
                  _context5.next = 18;
                  break;
                }

                // FOUND PLAN
                _this6.biweeklyPlanVersion = _this6.biweeklyPlanHeader.version;

                if (!(_this6.sourceVersions.length > 0)) {
                  _context5.next = 16;
                  break;
                }

                foundSourceVersion = _this6.sourceVersions.find(function (item) {
                  return item.source_version == _this6.biweeklyPlanHeader.source_version;
                });
                _this6.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : _this6.sourceVersions[0].source_version;
                _context5.next = 15;
                return _this6.onGetBiweeklyPlanLines();

              case 15:
                _this6.setUrlParams();

              case 16:
                _context5.next = 19;
                break;

              case 18:
                _this6.biweeklyPlanVersion = null;

              case 19:
                // hide loading
                _this6.isLoading = false;

              case 20:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getSourceVersions: function getSourceVersions(periodYear, periodName, printType, saleType) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this7.isLoading = true; // REFRESH DATA

                _this7.sourceVersion = null;
                _this7.sourceVersions = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  print_type: printType,
                  sale_type: saleType
                };
                _context6.next = 6;
                return axios.get("/ajax/pm/plans/biweekly/get-source-versions", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this7.sourceVersion = resData.source_version ? resData.source_version : null;
                    _this7.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];

                    if (_this7.sourceVersions.length <= 0) {
                      swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E23\u0E32\u0E22\u0E40\u0E14\u0E37\u0E2D\u0E19\u0E17\u0E35\u0E48\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E41\u0E25\u0E49\u0E27 ", "error");
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
                _this7.isLoading = false;

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
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
    onGetBiweeklyPlanLines: function onGetBiweeklyPlanLines() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // show loading
                _this8.isLoading = true;
                params = {
                  period_year: _this8.periodYear,
                  period_name: _this8.periodName,
                  biweekly: _this8.biweekly,
                  print_type: _this8.printType,
                  sale_type: _this8.saleType,
                  source_version: _this8.sourceVersion,
                  version: _this8.biweeklyPlanVersion
                };
                _context7.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-lines", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this8.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    _this8.biweeklyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this8.biweeklyPlanVersion = _this8.biweeklyPlanHeader.version;
                    _this8.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this8.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this8.periodNameLabel, " \u0E1B\u0E35 ").concat(_this8.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this8.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this8.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this8.periodNameLabel, " \u0E1B\u0E35 ").concat(_this8.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this8.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this8.isLoading = false;

              case 5:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onGenerateBiweeklyPlanLines: function onGenerateBiweeklyPlanLines() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                if (_this9.biweeklyPlanLines.length > 0) {
                  swal({
                    title: "",
                    text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E40\u0E23\u0E35\u0E22\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E08\u0E32\u0E01\u0E41\u0E1C\u0E19 \u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07 ?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                  }, function (isConfirm) {
                    if (isConfirm) {
                      _this9.biweeklyPlanLines = [];

                      _this9.generateBiweeklyPlanLines();
                    }
                  });
                } else {
                  _this9.generateBiweeklyPlanLines();
                }

              case 1:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    generateBiweeklyPlanLines: function generateBiweeklyPlanLines() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                // show loading
                _this10.isLoading = true;
                reqBody = {
                  period_year: _this10.periodYear,
                  period_name: _this10.periodName,
                  biweekly: _this10.biweekly,
                  print_type: _this10.printType,
                  sale_type: _this10.saleType,
                  source_version: _this10.sourceVersion,
                  version: _this10.biweeklyPlanVersion
                };
                _context9.next = 4;
                return axios.post("/ajax/pm/plans/biweekly/generate-lines", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this10.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    _this10.biweeklyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this10.biweeklyPlanVersion = _this10.biweeklyPlanHeader.version;
                    _this10.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this10.isNewlyCreate = resData.is_newly_create;
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this10.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this10.periodNameLabel, " \u0E1B\u0E35 ").concat(_this10.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this10.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this10.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this10.periodNameLabel, " \u0E1B\u0E35 ").concat(_this10.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this10.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this10.isLoading = false;

              case 5:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    onPlanLineChanged: function onPlanLineChanged(data) {
      this.biweeklyPlanLines = data.planLineItems;
    },
    onSaveBiweeklyPlan: function onSaveBiweeklyPlan() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                reqBody = {
                  period_year: _this11.periodYear,
                  period_name: _this11.periodName,
                  biweekly: _this11.biweekly,
                  print_type: _this11.printType,
                  sale_type: _this11.saleType,
                  source_version: _this11.sourceVersion,
                  version: _this11.biweeklyPlanVersion,
                  plan_header: JSON.stringify(_this11.biweeklyPlanHeader),
                  plan_lines: JSON.stringify(_this11.biweeklyPlanLines)
                }; // show loading

                _this11.isLoading = true; // CALL SAVE LINES

                _context10.next = 4;
                return axios.post("/ajax/pm/plans/biweekly/store-lines", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                  if (resData.status == "success") {
                    _this11.biweeklyPlanHeader = resPlanHeader;
                    _this11.biweeklyPlanVersion = resPlanHeader.version;
                    _this11.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this11.isNewlyCreate = false;
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " version : ").concat(_this11.biweeklyPlanVersion), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this11.isLoading = false;

              case 5:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    onSubmitApprovalBiweeklyPlan: function onSubmitApprovalBiweeklyPlan() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                reqBody = {
                  period_year: _this12.periodYear,
                  period_name: _this12.periodName,
                  biweekly: _this12.biweekly,
                  print_type: _this12.printType,
                  sale_type: _this12.saleType,
                  source_version: _this12.sourceVersion,
                  version: _this12.biweeklyPlanVersion,
                  plan_header: JSON.stringify(_this12.biweeklyPlanHeader),
                  plan_lines: JSON.stringify(_this12.biweeklyPlanLines)
                }; // show loading

                _this12.isLoading = true; // CALL SAVE BEFORE SUBMIT

                _context11.next = 4;
                return axios.post("/ajax/pm/plans/biweekly/store-lines", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    console.log(resData.message);
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                });

              case 4:
                _context11.next = 6;
                return axios.post("/ajax/pm/plans/biweekly/submit-approval", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this12.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this12.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", "\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this12.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this12.periodNameLabel, " \u0E1B\u0E35 ").concat(_this12.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this12.printTypeLabel), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this12.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this12.periodNameLabel, " \u0E1B\u0E35 ").concat(_this12.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this12.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this12.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this12.periodNameLabel, " \u0E1B\u0E35 ").concat(_this12.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this12.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 6:
                // hide loading
                _this12.isLoading = false;

              case 7:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    onCreateNewBiweeklyPlanVersion: function onCreateNewBiweeklyPlanVersion() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                swal({
                  title: "",
                  text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E2A\u0E23\u0E49\u0E32\u0E07 \u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this13.periodYearLabel, " \u0E40\u0E27\u0E2D\u0E23\u0E4C\u0E0A\u0E31\u0E48\u0E19\u0E43\u0E2B\u0E21\u0E48 ?"),
                  showCancelButton: true,
                  confirmButtonClass: "btn-primary",
                  confirmButtonText: "ยืนยัน",
                  cancelButtonText: "ยกเลิก",
                  closeOnConfirm: true
                }, function (isConfirm) {
                  if (isConfirm) {
                    _this13.biweeklyPlanLines = [];

                    _this13.createNewPlanVersion();
                  }
                });

              case 1:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
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
    },
    isAllowCreateNewPlanVersion: function isAllowCreateNewPlanVersion(versions) {
      var allowed = true; // IF THERE IS NO PLAN VERSION

      if (versions.length == 0) {
        allowed = false;
      } // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NEW || 2 : WAITING_FOR_APPROVAL )
      // => NOT ALLOW TO CREATE NEW VERSION


      var inprogressVersions = versions.filter(function (item) {
        return item.status == 1 || item.status == 2;
      });

      if (inprogressVersions.length > 0) {
        allowed = false;
      }

      return allowed;
    },
    createNewPlanVersion: function createNewPlanVersion() {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                reqBody = {
                  period_year: _this14.periodYear,
                  period_name: _this14.periodName,
                  biweekly: _this14.biweekly,
                  print_type: _this14.printType,
                  sale_type: _this14.saleType,
                  source_version: _this14.sourceVersion
                }; // show loading

                _this14.isLoading = true; // call store sample result

                _context13.next = 4;
                return axios.post("/ajax/pm/plans/biweekly/add-new-header", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this14.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this14.biweeklyPlanVersion = resData.version;
                    _this14.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", "\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this14.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this14.periodNameLabel, " \u0E1B\u0E35 ").concat(_this14.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this14.printTypeLabel, " version : ").concat(_this14.biweeklyPlanVersion, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this14.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this14.periodNameLabel, " \u0E1B\u0E35 ").concat(_this14.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this14.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this14.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this14.periodNameLabel, " \u0E1B\u0E35 ").concat(_this14.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this14.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this14.isLoading = false;

              case 5:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_3___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight", "planHeader", "periodYears", "periodYearValue", "periodNames", "periodNameValue", "biweeklys", "biweeklyValue", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersions", "sourceVersionValue", "biweeklyPlanVersions", "biweeklyPlanVersionValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default())
  },
  watch: {
    planHeader: function planHeader(value) {
      this.planHeaderData = value;
    },
    periodYears: function periodYears(value) {
      this.periodYearOptions = value;
    },
    periodYearValue: function periodYearValue(value) {
      this.periodYear = this.periodYearValue;
      this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, this.periodYear);
    },
    periodNames: function periodNames(value) {
      this.periodNameOptions = value;
    },
    periodNameValue: function periodNameValue(value) {
      this.periodName = this.periodNameValue;
      this.periodNameLabel = this.getPeriodNameLabel(this.periodNameOptions, this.periodName);
    },
    biweeklys: function biweeklys(value) {
      this.biweeklyOptions = value;
    },
    biweeklyValue: function biweeklyValue(value) {
      this.biweekly = this.biweeklyValue;
    },
    printTypeValue: function printTypeValue(value) {
      this.printType = value;
    },
    saleTypeValue: function saleTypeValue(value) {
      this.saleType = value;
    },
    sourceVersionValue: function sourceVersionValue(value) {
      this.sourceVersion = value;
    },
    sourceVersions: function sourceVersions(value) {
      this.sourceVersionOptions = value;
    },
    biweeklyPlanVersionValue: function biweeklyPlanVersionValue(value) {
      this.biweeklyPlanVersion = value;
    },
    biweeklyPlanVersions: function biweeklyPlanVersions(value) {
      this.biweeklyPlanVersionOptions = value;
    }
  },
  data: function data() {
    return {
      is_loading: false,
      width: this.modalWidth,
      planHeaderData: this.planHeader,
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      periodYearOptions: this.periodYears,
      periodName: this.periodNameValue,
      periodNameOptions: this.periodNames,
      biweekly: this.biweeklyValue,
      biweeklyOptions: this.biweeklys,
      printType: this.printTypeValue,
      saleType: this.saleTypeValue,
      sourceVersion: this.sourceVersionValue,
      sourceVersionOptions: this.sourceVersions,
      biweeklyPlanVersion: this.biweeklyPlanVersionValue,
      biweeklyPlanVersionOptions: this.biweeklyPlanVersions
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
    onYearlyPlanChanged: function onYearlyPlanChanged(value) {
      this.periodYear = value;
      this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, this.periodYear); // REFREH DATA

      this.periodName = null;
      this.periodNameLabel = "";
      this.periodNameOptions = [];
      this.biweeklyOptions = [];
      this.sourceVersion = null;
      this.sourceVersions = [];
      this.biweeklyPlanVersion = null;
      this.biweeklyPlanVersionOptions = [];
      this.getPeriodNames(value);
    },
    onPeriodNameChanged: function onPeriodNameChanged(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.periodName = value;
                _this.periodNameLabel = _this.getPeriodNameLabel(_this.periodNameOptions, _this.periodName); // REFREH DATA

                _this.biweeklyPlanVersion = null;
                _this.biweeklyPlanVersionOptions = [];
                _this.biweeklyOptions = [];
                _context.next = 7;
                return _this.getSourceVersions(_this.periodYear, _this.periodName, _this.printType, _this.saleType);

              case 7:
                _this.getBiweekOfPlans(_this.periodYear, value);

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onBiweekOfPlanChanged: function onBiweekOfPlanChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.biweekly = value;

                if (_this2.periodYear && _this2.periodName && _this2.biweekly && _this2.printType && _this2.saleType && _this2.sourceVersion) {
                  _this2.getBiweeklyPlanData(_this2.periodYear, _this2.periodName, _this2.biweekly, _this2.printType, _this2.saleType, _this2.sourceVersion, null);
                }

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onSourceVersionChanged: function onSourceVersionChanged(value) {
      this.sourceVersion = value; // if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
      //     this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
      // }
    },
    onPrintTypeChanged: function onPrintTypeChanged(value) {
      this.printType = value;

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onSaleTypeChanged: function onSaleTypeChanged(value) {
      this.saleType = value;

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onBiweeklyPlanVersionChanged: function onBiweeklyPlanVersionChanged(value) {
      this.biweeklyPlanVersion = value;
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
    getPeriodNames: function getPeriodNames(periodYear) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                // show loading
                _this3.is_loading = true; // REFRESH DATA

                _this3.biweeklyPlanVersion = null;
                _this3.biweeklyPlanVersionOptions = [];
                params = {
                  period_year: periodYear
                };
                _context3.next = 6;
                return axios.get("/ajax/pm/plans/biweekly/get-months", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.period_names ? JSON.parse(resData.period_names) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E35 ".concat(_this3.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 6:
                _this3.periodNameOptions = _context3.sent;
                // hide loading
                _this3.is_loading = false;

              case 8:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getBiweekOfPlans: function getBiweekOfPlans(periodYear, periodName) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                // show loading
                _this4.is_loading = true;
                params = {
                  period_year: periodYear,
                  period_name: periodName
                };
                _context4.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-biweeks", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E35 ".concat(_this4.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this4.biweeklyOptions = _context4.sent;
                // hide loading
                _this4.is_loading = false;

              case 6:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getBiweeklyPlanData: function getBiweeklyPlanData(periodYear, periodName, biweekly, printType, saleType, sourceVersion, version) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // show loading
                _this5.is_loading = true;
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  print_type: printType,
                  sale_type: saleType,
                  source_version: sourceVersion,
                  version: version
                };
                _context5.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-info", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  _this5.biweeklyPlanVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "".concat(error.message), "error");
                  return;
                });

              case 4:
                _this5.biweeklyPlanVersion = _this5.biweeklyPlanVersionOptions.length > 0 ? _this5.biweeklyPlanVersionOptions[0].version : null; // hide loading

                _this5.is_loading = false;

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getSourceVersions: function getSourceVersions(periodYear, periodName, printType, saleType) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this6.isLoading = true; // REFRESH DATA

                _this6.sourceVersion = null;
                _this6.sourceVersionOptions = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  print_type: printType,
                  sale_type: saleType
                };
                _context6.next = 6;
                return axios.get("/ajax/pm/plans/biweekly/get-source-versions", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this6.sourceVersion = resData.source_version ? resData.source_version : null;
                    _this6.sourceVersionOptions = resData.source_versions ? JSON.parse(resData.source_versions) : [];

                    if (_this6.sourceVersionOptions.length <= 0) {
                      swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E23\u0E32\u0E22\u0E40\u0E14\u0E37\u0E2D\u0E19\u0E17\u0E35\u0E48\u0E22\u0E37\u0E19\u0E22\u0E31\u0E19\u0E41\u0E25\u0E49\u0E27", "error");
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
                _this6.isLoading = false;

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onSearchPlanVersion: function onSearchPlanVersion() {
      this.$modal.hide(this.modalName);
      this.$emit("onSearchPlanVersion", {
        period_year: this.periodYear,
        period_name: this.periodName,
        biweekly: this.biweekly,
        print_type: this.printType,
        sale_type: this.saleType,
        source_version: this.sourceVersion,
        source_versions: this.sourceVersionOptions,
        version: this.biweeklyPlanVersion
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: ["planHeader", "planLines", "uomCodes"],
  watch: {
    planHeader: function planHeader(data) {
      this.planHeaderData = data;
    },
    planLines: function planLines(data) {
      var _this = this;

      this.planLineItems = data.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          product_qty: item.product_qty ? item.product_qty : 0,
          period_name_remain_qty: _this.calPeriodNameRemainQty(item.period_name_request, item.period_name_qty, item.product_qty),
          uom_desc: _this.getUomCodeDescription(_this.uomCodes, item.uom)
        });
      }).sort(function (a, b) {
        if (a.inv_item_number < b.inv_item_number) {
          return -1;
        }

        if (a.inv_item_number > b.inv_item_number) {
          return 1;
        }

        return 0;
      });
    }
  },
  data: function data() {
    var _this2 = this;

    return {
      planHeaderData: this.planHeader,
      planLineItems: this.planLines.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          product_qty: item.product_qty ? item.product_qty : 0,
          period_name_remain_qty: _this2.calPeriodNameRemainQty(item.period_name_request, item.period_name_qty, item.product_qty),
          uom_desc: _this2.getUomCodeDescription(_this2.uomCodes, item.uom)
        });
      }).sort(function (a, b) {
        if (a.inv_item_number < b.inv_item_number) {
          return -1;
        }

        if (a.inv_item_number > b.inv_item_number) {
          return 1;
        }

        return 0;
      }),
      isLoading: false
    };
  },
  mounted: function mounted() {
    // EMIT UPDATE PARENT PLAN LINES
    this.emitPlanLineChanged();
  },
  computed: {},
  methods: {
    calPeriodNameRemainQty: function calPeriodNameRemainQty(periodNameRequest, periodNameQty, productQty) {
      // const fPeriodNameRequest = periodNameRequest ? parseFloat(Math.round(periodNameRequest * 100) / 100) : 0;
      var fPeriodNameQty = periodNameQty ? parseFloat(Math.round(periodNameQty * 100) / 100) : 0;
      var fProductQty = productQty ? parseFloat(Math.round(productQty * 100) / 100) : 0; // const periodNameRemainQty = fPeriodNameRequest - (fPeriodNameQty + fProductQty);

      var periodNameRemainQty = fPeriodNameQty - fProductQty;
      return periodNameRemainQty;
    },
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code == uomCode;
      });
      return foundUomCode ? foundUomCode.unit_of_measure : "";
    },
    onProductQtyValueChanged: function onProductQtyValueChanged(planLineItem) {
      planLineItem.period_name_remain_qty = this.calPeriodNameRemainQty(planLineItem.period_name_request, planLineItem.period_name_qty, planLineItem.product_qty);
      this.emitPlanLineChanged();
    },
    onSubmitOpenOrderBiweeklyPlan: function onSubmitOpenOrderBiweeklyPlan() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                reqBody = {
                  period_year: _this3.planHeaderData.period_year,
                  period_name: _this3.planHeaderData.period_name,
                  biweekly: _this3.planHeaderData.biweekly,
                  version: _this3.planHeaderData.version,
                  plan_header: JSON.stringify(_this3.planHeaderData),
                  plan_lines: JSON.stringify(_this3.planLines)
                }; // show loading

                _this3.isLoading = true; // call store sample result

                _context.next = 4;
                return axios.post("/ajax/pm/plans/biweekly/submit-open-order", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    var resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    var resPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : null;

                    if (resPlanLines) {
                      _this3.planLineItems = resPlanLines.map(function (item) {
                        return _objectSpread(_objectSpread({}, item), {}, {
                          // period_name_qty: item.product_qty ? (parseFloat(item.period_name_request) - parseFloat(item.product_qty)).toFixed(2) : parseFloat(item.period_name_request).toFixed(2),
                          period_name_remain_qty: _this3.calPeriodNameRemainQty(item.period_name_request, item.period_name_qty, item.product_qty),
                          uom_desc: _this3.getUomCodeDescription(_this3.uomCodes, item.uom)
                        });
                      }).sort(function (a, b) {
                        if (a.inv_item_number < b.inv_item_number) {
                          return -1;
                        }

                        if (a.inv_item_number > b.inv_item_number) {
                          return 1;
                        }

                        return 0;
                      });
                    }

                    swal("Success", "\u0E40\u0E1B\u0E34\u0E14\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08", "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E1B\u0E34\u0E14\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E1B\u0E34\u0E14\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this3.isLoading = false;

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getRequestNumber: function getRequestNumber(planLineItem) {
      var requestNumber = "";

      if (Number(planLineItem.product_qty == 0) && this.isOrderOpened(this.planLineItems)) {
        requestNumber = "ไม่ผลิต";
      } else {
        requestNumber = planLineItem.request_number;
      }

      return requestNumber;
    },
    isOrderOpened: function isOrderOpened(planLineItems) {
      var foundRequestNumber = planLineItems.find(function (item) {
        return !!item.request_number;
      });
      return !!foundRequestNumber;
    },
    emitPlanLineChanged: function emitPlanLineChanged() {
      this.$emit("onPlanLineChanged", {
        planLineItems: this.planLineItems
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-72303973] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_72303973_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_72303973_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_72303973_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/Index.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/Index.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_1cd20507___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=1cd20507& */ "./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=template&id=1cd20507&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_1cd20507___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_1cd20507___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/biweekly/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearchPlan_vue_vue_type_template_id_72303973_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true& */ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true&");
/* harmony import */ var _ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearchPlan.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSearchPlan_vue_vue_type_style_index_0_id_72303973_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css& */ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearchPlan_vue_vue_type_template_id_72303973_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearchPlan_vue_vue_type_template_id_72303973_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "72303973",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/TablePlanLines.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/TablePlanLines.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TablePlanLines_vue_vue_type_template_id_1187647a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=template&id=1187647a& */ "./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=template&id=1187647a&");
/* harmony import */ var _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TablePlanLines_vue_vue_type_template_id_1187647a___WEBPACK_IMPORTED_MODULE_0__.render,
  _TablePlanLines_vue_vue_type_template_id_1187647a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/biweekly/TablePlanLines.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css&":
/*!********************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css& ***!
  \********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_72303973_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=style&index=0&id=72303973&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=template&id=1cd20507&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=template&id=1cd20507& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_1cd20507___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_1cd20507___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_1cd20507___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=1cd20507& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=template&id=1cd20507&");


/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_template_id_72303973_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_template_id_72303973_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_template_id_72303973_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=template&id=1187647a&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=template&id=1187647a& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_1187647a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_1187647a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_1187647a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=template&id=1187647a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=template&id=1187647a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=template&id=1cd20507&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/Index.vue?vue&type=template&id=1cd20507& ***!
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
                    disabled: !_vm.isAllowCreateNewPlanVersion(
                      _vm.biweeklyPlanVersions
                    )
                  },
                  on: { click: _vm.onCreateNewBiweeklyPlanVersion }
                },
                [
                  _c("i", { staticClass: "fa fa-plus tw-mr-1" }),
                  _vm._v(" สร้าง \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-inline-block btn-sm btn-primary tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.periodYear ||
                      !_vm.periodName ||
                      !_vm.biweekly ||
                      _vm.biweeklyPlanLines.length == 0 ||
                      (_vm.biweeklyPlanHeader
                        ? _vm.biweeklyPlanHeader.status != "1"
                        : true)
                  },
                  on: { click: _vm.onSaveBiweeklyPlan }
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
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-40",
                  on: {
                    click: function($event) {
                      return _vm.$modal.show("modal-search-plan")
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
                  staticClass: "btn btn-inline-block btn-sm btn-info tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.periodYear ||
                      !_vm.periodName ||
                      !_vm.biweekly ||
                      (_vm.biweeklyPlanHeader
                        ? _vm.biweeklyPlanHeader.status != "1"
                        : false)
                  },
                  on: { click: _vm.onGenerateBiweeklyPlanLines }
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
                  staticClass:
                    "btn btn-inline-block btn-sm btn-warning tw-w-40",
                  attrs: {
                    disabled:
                      (_vm.biweeklyPlanHeader
                        ? _vm.biweeklyPlanHeader.status != "1"
                        : true) ||
                      _vm.biweeklyPlanLines.length == 0 ||
                      _vm.isNewlyCreate
                  },
                  on: { click: _vm.onSubmitApprovalBiweeklyPlan }
                },
                [
                  _c("i", { staticClass: "fa fa-check-square tw-mr-1" }),
                  _vm._v(" ส่งอนุมัติ \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-inline-block btn-sm btn-primary tw-w-40",
                  attrs: {
                    disabled: _vm.biweeklyPlanHeader
                      ? _vm.biweeklyPlanHeader.status == "1"
                      : true
                  }
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
                        }
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
                    { staticClass: "col-md-8" },
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
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" ประจำเดือน ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-3" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "period_name",
                          id: "input_period_name",
                          "select-options": _vm.periodNames,
                          "option-key": "period_name_value",
                          "option-value": "period_name_value",
                          "option-label": "period_name_label",
                          value: _vm.periodName,
                          filterable: true
                        },
                        on: { onSelected: _vm.onPeriodNameChanged }
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
                        _vm.biweeklyPlanHeader,
                        _vm.biweeklyPlanLines
                      )
                        ? _c("pm-el-select", {
                            attrs: {
                              name: "source_version",
                              id: "source_version",
                              "select-options": _vm.sourceVersions,
                              "option-key": "source_version",
                              "option-value": "source_version",
                              "option-label": "source_version",
                              value: _vm.sourceVersion,
                              filterable: true
                            },
                            on: { onSelected: _vm.onSourceVersionChanged }
                          })
                        : _vm._e(),
                      _vm._v(" "),
                      !_vm.isAllowSelectSourceVersion(
                        _vm.biweeklyPlanHeader,
                        _vm.biweeklyPlanLines
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
                    [_vm._v(" ปักษ์ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "biweekly",
                          id: "input_biweekly",
                          "select-options": _vm.biweeklys,
                          "option-key": "biweekly_value",
                          "option-value": "biweekly_value",
                          "option-label": "biweekly_label",
                          value: _vm.biweekly,
                          filterable: true
                        },
                        on: { onSelected: _vm.onBiweekOfPlanChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6" }, [
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" เวอร์ชั่น ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(
                                _vm.biweeklyPlanHeader.version
                                  ? _vm.biweeklyPlanHeader.version
                                  : "-"
                              ) +
                              " "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(" - ")
                        ])
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" สถานะ ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(
                                _vm.getPlanStatusDesc(
                                  _vm.biweeklyPlanHeader.status
                                )
                              ) +
                              " "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(" - ")
                        ])
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" ผู้อนุมัติ ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(
                                _vm.biweeklyPlanHeader.attribute12
                                  ? _vm.biweeklyPlanHeader.attribute12
                                  : "-"
                              ) +
                              " "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(" - ")
                        ])
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" วันที่อนุมัติ ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " \n                                " +
                              _vm._s(
                                _vm.biweeklyPlanHeader.approved_date
                                  ? _vm.formatDateTh(
                                      _vm.biweeklyPlanHeader.approved_date
                                    )
                                  : ""
                              ) +
                              "\n                            "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(" - ")
                        ])
                      : _vm._e()
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" วันที่แก้ไขล่าสุด ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.biweeklyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " \n                                " +
                              _vm._s(
                                _vm.biweeklyPlanHeader.last_update_date
                                  ? _vm.formatDateTh(
                                      _vm.biweeklyPlanHeader.last_update_date
                                    )
                                  : ""
                              ) +
                              "\n                            "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.biweeklyPlanHeader
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
          _c("hr"),
          _vm._v(" "),
          _vm.biweeklyPlanLines.length > 0
            ? _c("div", { staticClass: "tw-m-8" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-12" },
                    [
                      _c("table-plan-lines", {
                        attrs: {
                          "plan-header": _vm.biweeklyPlanHeader,
                          "plan-lines": _vm.biweeklyPlanLines,
                          "uom-codes": _vm.uomCodes
                        },
                        on: { onPlanLineChanged: _vm.onPlanLineChanged }
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
      _c("modal-search-plan", {
        attrs: {
          "modal-name": "modal-search-plan",
          "modal-width": "640",
          "modal-height": "auto",
          "period-years": _vm.periodYears,
          "period-year-value": _vm.periodYear,
          "period-names": _vm.periodNames,
          "period-name-value": _vm.periodName,
          biweeklys: _vm.biweeklys,
          "biweekly-value": _vm.biweekly,
          "print-types": _vm.printTypes,
          "print-type-value": _vm.printType,
          "sale-types": _vm.saleTypes,
          "sale-type-value": _vm.saleType,
          "source-versions": _vm.sourceVersions,
          "source-version-value": _vm.sourceVersion,
          "biweekly-plan-version-value": _vm.biweeklyPlanVersion,
          "biweekly-plan-versions": _vm.biweeklyPlanVersions
        },
        on: { onSearchPlanVersion: _vm.onSearchPlanVersion }
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/ModalSearchPlan.vue?vue&type=template&id=72303973&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
            _c("h4", [_vm._v(" ค้นหาแผนผลิตสิ่งพิมพ์รายปักษ์ ")]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
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
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label tw-font-bold tw-pt-0" },
                [_vm._v(" แผนประมาณการ "), _c("br"), _vm._v(" จำหน่ายประจำปี ")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-8" },
                [
                  _c("pm-el-select", {
                    attrs: {
                      name: "period_year",
                      id: "input_period_year",
                      "select-options": _vm.periodYearOptions,
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
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row form-group" }, [
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label tw-font-bold" },
                [_vm._v(" ประจำเดือน ")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-8" },
                [
                  _c("pm-el-select", {
                    attrs: {
                      name: "period_name",
                      id: "input_period_name",
                      "select-options": _vm.periodNameOptions,
                      "option-key": "period_name_value",
                      "option-value": "period_name_value",
                      "option-label": "period_name_label",
                      value: _vm.periodName,
                      filterable: true
                    },
                    on: { onSelected: _vm.onPeriodNameChanged }
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
                [_vm._v(" ปักษ์ ")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-8" },
                [
                  _c("pm-el-select", {
                    attrs: {
                      name: "biweekly",
                      id: "input_biweekly",
                      "select-options": _vm.biweeklyOptions,
                      "option-key": "biweekly_value",
                      "option-value": "biweekly_value",
                      "option-label": "biweekly_label",
                      value: _vm.biweekly,
                      filterable: true
                    },
                    on: { onSelected: _vm.onBiweekOfPlanChanged }
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
                [_vm._v(" เวอร์ชั่น ")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-8" },
                [
                  _c("pm-el-select", {
                    attrs: {
                      name: "monthly_plan_version",
                      id: "input_monthly_plan_version",
                      "select-options": _vm.biweeklyPlanVersionOptions,
                      "option-key": "version",
                      "option-value": "version",
                      "option-label": "version",
                      value: _vm.biweeklyPlanVersion,
                      filterable: true
                    },
                    on: { onSelected: _vm.onBiweeklyPlanVersionChanged }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "text-right tw-mt-8" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-primary tw-w-32",
                  attrs: {
                    type: "button",
                    disabled:
                      !_vm.periodYear ||
                      !_vm.periodName ||
                      !_vm.biweekly ||
                      !_vm.biweeklyPlanVersion
                  },
                  on: { click: _vm.onSearchPlanVersion }
                },
                [_vm._v(" \n                    เลือก \n                ")]
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
                [_vm._v(" \n                    ยกเลิก \n                ")]
              )
            ])
          ])
        ]
      ),
      _vm._v(" "),
      _c("loading", {
        attrs: { active: _vm.is_loading, "is-full-page": true },
        on: {
          "update:active": function($event) {
            _vm.is_loading = $event
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=template&id=1187647a&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/biweekly/TablePlanLines.vue?vue&type=template&id=1187647a& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
      _vm.planHeaderData.status == 3
        ? _c("div", { staticClass: "text-right tw-mb-2" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-inline-block btn-sm btn-success tw-w-40",
                attrs: { disabled: _vm.isOrderOpened(_vm.planLineItems) },
                on: { click: _vm.onSubmitOpenOrderBiweeklyPlan }
              },
              [
                _c("i", { staticClass: "fa fa-check-o tw-mr-1" }),
                _vm._v(" เปิดคำสั่งผลิต \n        ")
              ]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c(
          "table",
          {
            staticClass: "table table-bordered table-sticky mb-0",
            staticStyle: { "min-width": "1400px" }
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm.planLineItems.length > 0
              ? _c(
                  "tbody",
                  [
                    _vm._l(_vm.planLineItems, function(planLineItem, index) {
                      return [
                        _c(
                          "tr",
                          {
                            key: "" + index,
                            style: {
                              backgroundColor:
                                parseInt(planLineItem.product_qty) == 0
                                  ? "#FDF5EF"
                                  : ""
                            }
                          },
                          [
                            _c(
                              "td",
                              {
                                staticClass: "freeze-col",
                                staticStyle: { "min-width": "700px" }
                              },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass: "freeze-col-content",
                                    staticStyle: { padding: "0px" },
                                    style: {
                                      backgroundColor:
                                        parseInt(planLineItem.product_qty) == 0
                                          ? "#FDF5EF"
                                          : ""
                                    }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "text-center tw-inline-block tw-align-top tw-py-4 tw-pr-2",
                                        staticStyle: {
                                          "min-width": "140px",
                                          "max-width": "140px"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(
                                              planLineItem.product_item_desc
                                                ? planLineItem.product_item_desc
                                                : "-"
                                            ) +
                                            " \n                                "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "text-center tw-inline-block tw-align-top tw-py-4 tw-px-2",
                                        staticStyle: {
                                          "min-width": "120px",
                                          "max-width": "120px",
                                          "border-left": "1px solid #ddd"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(
                                              planLineItem.inv_item_type
                                                ? planLineItem.inv_item_type
                                                : "-"
                                            ) +
                                            "\n                                "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "text-center tw-inline-block tw-align-top tw-py-4 tw-px-2",
                                        staticStyle: {
                                          "min-width": "120px",
                                          "max-width": "120px",
                                          "border-left": "1px solid #ddd"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(
                                              planLineItem.inv_item_number
                                                ? planLineItem.inv_item_number
                                                : "-"
                                            ) +
                                            "\n                                "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "text-left tw-inline-block tw-align-top tw-py-4 tw-px-2",
                                        staticStyle: {
                                          "min-width": "280px",
                                          "max-width": "280px",
                                          "border-left": "1px solid #ddd"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(
                                              planLineItem.inv_item_desc
                                                ? planLineItem.inv_item_desc
                                                : "-"
                                            ) +
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
                                staticClass: "text-right",
                                staticStyle: { "min-width": "160px" }
                              },
                              [
                                _vm.planHeaderData.status == "1"
                                  ? _c(
                                      "div",
                                      [
                                        _c("vue-numeric", {
                                          staticClass:
                                            "form-control input-sm text-right",
                                          attrs: {
                                            separator: ",",
                                            precision: 2,
                                            minus: false,
                                            id: "input_product_qty_" + index,
                                            name: "product_qty_" + index,
                                            placeholder: ""
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.onProductQtyValueChanged(
                                                planLineItem
                                              )
                                            }
                                          },
                                          model: {
                                            value: planLineItem.product_qty,
                                            callback: function($$v) {
                                              _vm.$set(
                                                planLineItem,
                                                "product_qty",
                                                $$v
                                              )
                                            },
                                            expression:
                                              "planLineItem.product_qty"
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  : _c("div", [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            planLineItem.product_qty
                                              ? Number(
                                                  planLineItem.product_qty
                                                ).toLocaleString(undefined, {
                                                  minimumFractionDigits: 2,
                                                  maximumFractionDigits: 2
                                                })
                                              : "0.00"
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
                                staticClass: "text-right",
                                staticStyle: {
                                  "min-width": "130px",
                                  "max-width": "130px"
                                }
                              },
                              [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      planLineItem.period_name_request
                                        ? Number(
                                            planLineItem.period_name_request
                                          ).toLocaleString(undefined, {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                          })
                                        : "0.00"
                                    ) +
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
                                  "min-width": "130px",
                                  "max-width": "130px"
                                }
                              },
                              [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      planLineItem.period_name_remain_qty
                                        ? Number(
                                            planLineItem.period_name_remain_qty
                                          ).toLocaleString(undefined, {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                          })
                                        : "0.00"
                                    ) +
                                    " "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              {
                                staticClass: "text-center",
                                staticStyle: {
                                  "min-width": "130px",
                                  "max-width": "130px"
                                }
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
                                staticClass: "text-center",
                                staticStyle: {
                                  "min-width": "130px",
                                  "max-width": "130px"
                                }
                              },
                              [
                                _vm._v(
                                  " " +
                                    _vm._s(_vm.getRequestNumber(planLineItem)) +
                                    " "
                                )
                              ]
                            )
                          ]
                        )
                      ]
                    })
                  ],
                  2
                )
              : _c("tbody", [_vm._m(1)])
          ]
        )
      ]),
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
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "freeze-col",
            staticStyle: { height: "50px", "min-width": "700px" }
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
                    staticStyle: { "min-width": "140px", "max-width": "140px" }
                  },
                  [
                    _vm._v(
                      "\n                                ตราบุหรี่ \n                            "
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
                      "min-width": "120px",
                      "max-width": "120px",
                      "border-left": "1px solid #ddd"
                    }
                  },
                  [
                    _vm._v(
                      "\n                                ประเภทสิ่งพิมพ์\n                            "
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
                      "min-width": "120px",
                      "max-width": "120px",
                      "border-left": "1px solid #ddd"
                    }
                  },
                  [
                    _vm._v(
                      "\n                                รหัสสินค้าสำเร็จรูป\n                            "
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
                      "min-width": "280px",
                      "max-width": "280px",
                      "border-left": "1px solid #ddd"
                    }
                  },
                  [
                    _vm._v(
                      "\n                                รายละเอียด\n                            "
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
            staticStyle: { height: "50px", "min-width": "160px" }
          },
          [_vm._v(" สั่งผลิต(ม้วนใหญ่) ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              height: "50px",
              "min-width": "130px",
              "max-width": "130px"
            }
          },
          [_vm._v(" คำสั่งทั้งเดือน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              height: "50px",
              "min-width": "130px",
              "max-width": "130px"
            }
          },
          [_vm._v(" เหลือที่ต้องผลิต ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              height: "50px",
              "min-width": "130px",
              "max-width": "130px"
            }
          },
          [_vm._v(" หน่วย (ผลิต) ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              height: "50px",
              "min-width": "130px",
              "max-width": "130px"
            }
          },
          [_vm._v(" เลขคำสั่งผลิต ")]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "10" } }, [
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