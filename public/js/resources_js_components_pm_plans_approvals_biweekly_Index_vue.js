(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_plans_approvals_biweekly_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=script&lang=js& ***!
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _TablePlanLines__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TablePlanLines */ "./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue");


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TablePlanLines: _TablePlanLines__WEBPACK_IMPORTED_MODULE_4__.default
  },
  props: ["periodYears", "periodYearValue", "periodNameValue", "biweeklyValue", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "biweeklyPlanVersionValue", "uomCodes"],
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
                _this.getBiweeklyPlanData(_this.periodYearValue, _this.periodNameValue, _this.biweeklyValue, _this.printTypeValue, _this.saleTypeValue, _this.sourceVersionValue, _this.biweeklyPlanVersionValue);
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
    onBiweeklyPlanVersionChanged: function onBiweeklyPlanVersionChanged(value) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.biweeklyPlanVersion = value;

                _this4.setUrlParams();

                if (_this4.periodYear && _this4.periodName && _this4.biweekly && _this4.printType && _this4.saleType && _this4.sourceVersion) {
                  _this4.getBiweeklyPlanData(_this4.periodYear, _this4.periodName, _this4.biweekly, _this4.printType, _this4.saleType, _this4.sourceVersion, _this4.biweeklyPlanVersion);
                }

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onSourceVersionChanged: function onSourceVersionChanged(value) {
      this.sourceVersion = value;
      this.setUrlParams(); // if(this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
      //     this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, this.biweeklyPlanVersion);
      // }
    },
    onPrintTypeChanged: function onPrintTypeChanged(value) {
      this.printType = value;
      this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
      this.setUrlParams();

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, this.biweeklyPlanVersion);
      }
    },
    onSaleTypeChanged: function onSaleTypeChanged(value) {
      this.saleType = value;
      this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
      this.setUrlParams();

      if (this.periodYear && this.periodName && this.biweekly && this.printType && this.saleType && this.sourceVersion) {
        this.getBiweeklyPlanData(this.periodYear, this.periodName, this.biweekly, this.printType, this.saleType, this.sourceVersion, this.biweeklyPlanVersion);
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
                  period_year: periodYear
                };
                _context4.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-months", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.period_names ? JSON.parse(resData.period_names) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E35 ".concat(_this5.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this5.periodNames = _context4.sent;
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
    getBiweekOfPlans: function getBiweekOfPlans(periodYear, periodName) {
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
                  period_year: periodYear,
                  period_name: periodName
                };
                _context5.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-biweeks", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E40\u0E14\u0E37\u0E2D\u0E19 : ".concat(_this6.periodNameLabel, " \u0E1B\u0E35 ").concat(_this6.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this6.biweeklys = _context5.sent;
                // hide loading
                _this6.isLoading = false;

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getBiweeklyPlanData: function getBiweeklyPlanData(periodYear, periodName, biweekly, printType, saleType, sourceVersion, version) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var params, foundSourceVersion;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this7.isLoading = true; // REFRESH DATA

                _this7.biweeklyPlanHeader = null;
                _this7.biweeklyPlanVersion = version;
                _this7.biweeklyPlanVersions = [];
                _this7.biweeklyPlanLines = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  print_type: printType,
                  sale_type: saleType,
                  source_version: sourceVersion,
                  version: version
                };
                _context6.next = 8;
                return axios.get("/ajax/pm/plans/biweekly/get-info", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  _this7.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                  _this7.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this7.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this7.periodNameLabel, " \u0E1B\u0E35 ").concat(_this7.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 8:
                if (!_this7.biweeklyPlanHeader) {
                  _context6.next = 18;
                  break;
                }

                // FOUND PLAN
                _this7.biweeklyPlanVersion = _this7.biweeklyPlanHeader.version;

                if (!(_this7.sourceVersions.length > 0)) {
                  _context6.next = 16;
                  break;
                }

                foundSourceVersion = _this7.sourceVersions.find(function (item) {
                  return item.source_version == _this7.biweeklyPlanHeader.source_version;
                });
                _this7.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : _this7.sourceVersions[0].source_version;
                _context6.next = 15;
                return _this7.onGetBiweeklyPlanLines();

              case 15:
                _this7.setUrlParams();

              case 16:
                _context6.next = 19;
                break;

              case 18:
                _this7.biweeklyPlanVersion = null;

              case 19:
                // hide loading
                _this7.isLoading = false;

              case 20:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getSourceVersions: function getSourceVersions(periodYear, periodName, printType, saleType) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // show loading
                _this8.isLoading = true; // REFRESH DATA

                _this8.sourceVersion = null;
                _this8.sourceVersions = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  print_type: printType,
                  sale_type: saleType
                };
                _context7.next = 6;
                return axios.get("/ajax/pm/plans/biweekly/get-source-versions", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this8.sourceVersion = resData.source_version ? resData.source_version : null;
                    _this8.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];

                    if (_this8.sourceVersions.length <= 0) {
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
                _this8.isLoading = false;

              case 7:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
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
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                // show loading
                _this9.isLoading = true;
                params = {
                  period_year: _this9.periodYear,
                  period_name: _this9.periodName,
                  biweekly: _this9.biweekly,
                  print_type: _this9.printType,
                  sale_type: _this9.saleType,
                  source_version: _this9.sourceVersion,
                  version: _this9.biweeklyPlanVersion
                };
                _context8.next = 4;
                return axios.get("/ajax/pm/plans/biweekly/get-lines", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this9.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    _this9.biweeklyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this9.biweeklyPlanVersion = _this9.biweeklyPlanHeader.version;
                    _this9.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this9.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this9.periodNameLabel, " \u0E1B\u0E35 ").concat(_this9.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this9.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this9.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this9.periodNameLabel, " \u0E1B\u0E35 ").concat(_this9.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this9.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this9.isLoading = false;

              case 5:
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
      };
      return result;
    },
    onApprove: function onApprove() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                reqBody = {
                  period_year: _this10.periodYear,
                  period_name: _this10.periodName,
                  biweekly: _this10.biweekly,
                  print_type: _this10.printType,
                  sale_type: _this10.saleType,
                  source_version: _this10.sourceVersion,
                  plan_header: JSON.stringify(_this10.biweeklyPlanHeader),
                  plan_lines: JSON.stringify(_this10.biweeklyPlanLines)
                }; // show loading

                _this10.isLoading = true;
                resValidate = _this10.validateBeforeApproval(_this10.biweeklyPlanHeader, _this10.biweeklyPlanLines);

                if (!resValidate.valid) {
                  _context9.next = 6;
                  break;
                }

                _context9.next = 6;
                return axios.post("/ajax/pm/plans/biweekly/approve", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this10.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this10.biweeklyPlanVersion = resData.version;
                    _this10.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this10.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this10.periodNameLabel, " \u0E1B\u0E35 ").concat(_this10.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this10.printTypeLabel, " version : ").concat(_this10.biweeklyPlanVersion, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this10.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this10.periodNameLabel, " \u0E1B\u0E35 ").concat(_this10.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this10.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this10.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this10.periodNameLabel, " \u0E1B\u0E35 ").concat(_this10.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this10.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 6:
                // hide loading
                _this10.isLoading = false;

              case 7:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    onReject: function onReject() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var reqBody, resValidate;
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
                  plan_header: JSON.stringify(_this11.biweeklyPlanHeader),
                  plan_lines: JSON.stringify(_this11.biweeklyPlanLines)
                }; // show loading

                _this11.isLoading = true;
                resValidate = _this11.validateBeforeApproval(_this11.biweeklyPlanHeader, _this11.biweeklyPlanLines);

                if (!resValidate.valid) {
                  _context10.next = 6;
                  break;
                }

                _context10.next = 6;
                return axios.post("/ajax/pm/plans/biweekly/reject", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this11.biweeklyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this11.biweeklyPlanVersion = resData.version;
                    _this11.biweeklyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " version : ").concat(_this11.biweeklyPlanVersion, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34 \u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " | ").concat(error.message), "error");
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
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ["planHeader", "planLines", "uomCodes"],
  watch: {
    planHeader: function planHeader(value) {
      this.planHeaderData = value;
    },
    planLines: function planLines(data) {
      var _this = this;

      this.planLineItems = data.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          period_name_qty: item.product_qty ? (parseFloat(item.period_name_request) - parseFloat(item.product_qty)).toFixed(2) : parseFloat(item.period_name_request).toFixed(2),
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
          period_name_qty: item.product_qty ? (parseFloat(item.period_name_request) - parseFloat(item.product_qty)).toFixed(2) : parseFloat(item.period_name_request).toFixed(2),
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
  mounted: function mounted() {},
  computed: {},
  methods: {
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code == uomCode;
      });
      return foundUomCode ? foundUomCode.unit_of_measure : "";
    },
    onProductQtyValueChanged: function onProductQtyValueChanged(planLineItem) {
      if (planLineItem.product_qty) {
        planLineItem.period_name_qty = (parseFloat(planLineItem.period_name_request) - parseFloat(planLineItem.product_qty)).toFixed(2);
      } else {
        planLineItem.period_name_qty = parseFloat(planLineItem.period_name_request).toFixed(2);
      }
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
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/biweekly/Index.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/biweekly/Index.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_242915e6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=242915e6& */ "./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=template&id=242915e6&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_242915e6___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_242915e6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/approvals/biweekly/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TablePlanLines_vue_vue_type_template_id_b65e7078___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=template&id=b65e7078& */ "./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=template&id=b65e7078&");
/* harmony import */ var _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TablePlanLines_vue_vue_type_template_id_b65e7078___WEBPACK_IMPORTED_MODULE_0__.render,
  _TablePlanLines_vue_vue_type_template_id_b65e7078___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=template&id=242915e6&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=template&id=242915e6& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_242915e6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_242915e6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_242915e6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=242915e6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=template&id=242915e6&");


/***/ }),

/***/ "./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=template&id=b65e7078&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=template&id=b65e7078& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_b65e7078___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_b65e7078___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_b65e7078___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=template&id=b65e7078& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=template&id=b65e7078&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=template&id=242915e6&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/Index.vue?vue&type=template&id=242915e6& ***!
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
                      _vm.biweeklyPlanHeader,
                      _vm.biweeklyPlanLines
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
                      _vm.biweeklyPlanHeader,
                      _vm.biweeklyPlanLines
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
                    [_vm._v(" เวอร์ชั่น ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "biweekly_plan_version",
                          id: "input_biweekly_plan_version",
                          "select-options": _vm.biweeklyPlanVersions,
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=template&id=b65e7078&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/approvals/biweekly/TablePlanLines.vue?vue&type=template&id=b65e7078& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
                                _c("div", [
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
                                        : ""
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
                                      planLineItem.period_name_qty
                                        ? Number(
                                            planLineItem.period_name_qty
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