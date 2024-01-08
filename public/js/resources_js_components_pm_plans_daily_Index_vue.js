(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_plans_daily_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/Index.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/Index.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TablePlanLines__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TablePlanLines */ "./resources/js/components/pm/plans/daily/TablePlanLines.vue");
/* harmony import */ var _ModalSearchPlan__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalSearchPlan */ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue");
/* harmony import */ var _ModalProductPlans__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./ModalProductPlans */ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue");


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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TablePlanLines: _TablePlanLines__WEBPACK_IMPORTED_MODULE_4__.default,
    ModalSearchPlan: _ModalSearchPlan__WEBPACK_IMPORTED_MODULE_5__.default,
    ModalProductPlans: _ModalProductPlans__WEBPACK_IMPORTED_MODULE_6__.default
  },
  props: ["periodYears", "periodYearValue", "periodNameValue", "biweeklyValue", "weeklyValue", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersionValue", "uomCodes", "machines", "machinePowers", "machineTimes", "assets"],
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (!_this.periodYearValue) {
                _context.next = 20;
                break;
              }

              _context.next = 3;
              return _this.getPeriodNames(_this.periodYearValue);

            case 3:
              if (!_this.periodNameValue) {
                _context.next = 20;
                break;
              }

              _this.periodNameLabel = _this.getPeriodNameLabel(_this.periodNames, _this.periodNameValue);
              _context.next = 7;
              return _this.getBiweekOfPlans(_this.periodYearValue, _this.periodNameValue);

            case 7:
              if (!_this.biweeklyValue) {
                _context.next = 20;
                break;
              }

              _context.next = 10;
              return _this.getProductPlans(_this.periodYearValue, _this.periodNameValue, _this.biweeklyValue);

            case 10:
              _context.next = 12;
              return _this.getWeekOfPlans(_this.periodYearValue, _this.periodNameValue, _this.biweeklyValue);

            case 12:
              if (!_this.printTypeValue) {
                _context.next = 20;
                break;
              }

              _this.machineItems = _this.filterMachineItems(_this.machines, _this.printTypeValue);

              if (!_this.saleTypeValue) {
                _context.next = 20;
                break;
              }

              _context.next = 17;
              return _this.getSourceVersions(_this.periodYearValue, _this.periodNameValue, _this.biweeklyValue, _this.printTypeValue, _this.saleTypeValue);

            case 17:
              if (!_this.weeklyValue) {
                _context.next = 20;
                break;
              }

              _context.next = 20;
              return _this.getDailyPlanData(_this.periodYearValue, _this.periodNameValue, _this.biweeklyValue, _this.weeklyValue, _this.printTypeValue, _this.saleTypeValue, _this.sourceVersionValue, null);

            case 20:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      periodName: this.periodNameValue,
      periodNameLabel: "",
      periodNames: [],
      printType: this.printTypeValue ? this.printTypeValue : this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null,
      printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null,
      saleType: this.saleTypeValue ? this.saleTypeValue : this.saleTypes.length > 0 ? this.saleTypes[0].value : null,
      saleTypeLabel: this.saleTypeValue ? this.getPrintTypeLabel(this.saleTypes, this.saleTypeValue) : this.saleTypes.length > 0 ? this.saleTypes[0].description : null,
      sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
      sourceVersions: [],
      biweekly: this.biweeklyValue,
      biweeklys: [],
      weekly: this.weeklyValue,
      weeklys: [],
      dailyPlanHeader: null,
      dailyPlanVersion: null,
      dailyPlanLines: [],
      dailyPlanVersions: [],
      dailyRemainingItems: [],
      productDaily71Dates: [],
      productMachine71Groups: [],
      product71Plans: [],
      productDaily78Dates: [],
      productMachine78Groups: [],
      product78Plans: [],
      machineItems: this.filterMachineItems(this.machines, this.printTypeValue),
      availableMachines: [],
      machineEamSchedules: this.assets.map(function (item) {
        return {
          machine_id: item.asset_id,
          asset_id: item.asset_id,
          asset_number: item.asset_number,
          resource_code: item.resource_code,
          resource_description: item.resource_description,
          eam_schedules: item.eam_plan_lines ? item.eam_plan_lines.map(function (eam) {
            return {
              scheduled_start_date: eam.scheduled_start_date,
              scheduled_completion_date: eam.scheduled_completion_date
            };
          }) : []
        };
      }),
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
      queryParams.set("weekly", this.weekly ? this.weekly : '');
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
      this.weekly = null;
      this.weeklys = [];
      this.sourceVersion = null;
      this.sourceVersions = [];
      this.dailyPlanHeader = null;
      this.dailyPlanVersion = null;
      this.dailyPlanLines = [];
      this.dailyPlanVersions = [];
      this.dailyRemainingItems = [];
      this.getPeriodNames(this.periodYear);
      this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
    },
    onPeriodNameChanged: function onPeriodNameChanged(value) {
      this.periodName = value;
      this.periodNameLabel = this.getPeriodNameLabel(this.periodNames, this.periodName);
      this.setUrlParams(); // REFRESH DATA

      this.biweekly = null;
      this.biweeklys = [];
      this.weekly = null;
      this.weeklys = [];
      this.sourceVersion = null;
      this.sourceVersions = [];
      this.dailyPlanHeader = null;
      this.dailyPlanVersion = null;
      this.dailyPlanLines = [];
      this.dailyPlanVersions = [];
      this.dailyRemainingItems = [];
      this.getBiweekOfPlans(this.periodYear, this.periodName);
      this.availableMachines = this.getAvailableMachines(this.machineItems, this.dailyPlanLines);
    },
    onBiweekOfPlanChanged: function onBiweekOfPlanChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.biweekly = value;

                _this2.setUrlParams(); // REFRESH DATA


                _this2.weekly = null;
                _this2.weeklys = [];
                _this2.sourceVersion = null;
                _this2.sourceVersions = [];
                _this2.dailyPlanHeader = null;
                _this2.dailyPlanVersion = null;
                _this2.dailyPlanLines = [];
                _this2.dailyPlanVersions = [];
                _this2.dailyRemainingItems = [];
                _this2.availableMachines = _this2.getAvailableMachines(_this2.machineItems, _this2.dailyPlanLines);
                _context2.next = 14;
                return _this2.getWeekOfPlans(_this2.periodYear, _this2.periodName, _this2.biweekly);

              case 14:
                _context2.next = 16;
                return _this2.getProductPlans(_this2.periodYear, _this2.periodName, _this2.biweekly);

              case 16:
                if (!(_this2.periodYear && _this2.periodName && _this2.biweekly && _this2.printType && _this2.saleType)) {
                  _context2.next = 20;
                  break;
                }

                _context2.next = 19;
                return _this2.getSourceVersions(_this2.periodYear, _this2.periodName, _this2.biweekly, _this2.printType, _this2.saleType);

              case 19:
                // if(this.weekly && this.sourceVersion) {
                if (_this2.weekly) {
                  _this2.getDailyPlanData(_this2.periodYear, _this2.periodName, _this2.biweekly, _this2.weekly, _this2.printType, _this2.saleType, _this2.sourceVersion, null);
                }

              case 20:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onWeekOfPlanChanged: function onWeekOfPlanChanged(value) {
      this.weekly = value;
      this.setUrlParams(); // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {

      if (this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
        this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onSourceVersionChanged: function onSourceVersionChanged(value) {
      this.sourceVersion = value;
      this.setUrlParams(); //// if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
      // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
      //     this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
      // }
    },
    onPrintTypeChanged: function onPrintTypeChanged(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.printType = value;
                _this3.printTypeLabel = _this3.getPrintTypeLabel(_this3.printTypes, _this3.printType);

                _this3.setUrlParams();

                _this3.machineItems = _this3.filterMachineItems(_this3.machines, _this3.printType);
                _context3.next = 6;
                return _this3.getSourceVersions(_this3.periodYear, _this3.periodName, _this3.biweekly, _this3.printType, _this3.saleType);

              case 6:
                if (!(_this3.periodYear && _this3.periodName && _this3.biweekly && _this3.weekly && _this3.printType && _this3.saleType)) {
                  _context3.next = 9;
                  break;
                }

                _context3.next = 9;
                return _this3.getDailyPlanData(_this3.periodYear, _this3.periodName, _this3.biweekly, _this3.weekly, _this3.printType, _this3.saleType, _this3.sourceVersion, null);

              case 9:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onSaleTypeChanged: function onSaleTypeChanged(value) {
      this.saleType = value;
      this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
      this.setUrlParams(); // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {

      if (this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType) {
        this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onSearchPlanVersion: function onSearchPlanVersion(data) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.periodYear = data.period_year;
                _this4.periodYearLabel = _this4.getPeriodYearLabel(_this4.periodYears, _this4.periodYear);
                _this4.periodName = data.period_name;
                _this4.periodNameLabel = _this4.getPeriodNameLabel(_this4.periodNames, _this4.periodName);
                _this4.biweekly = data.biweekly;
                _this4.weekly = data.weekly;
                _this4.dailyPlanVersion = data.version;
                _this4.printType = data.print_type;
                _this4.printTypeLabel = _this4.getPrintTypeLabel(_this4.printTypes, _this4.printType);
                _this4.saleType = data.sale_type;
                _this4.saleTypeLabel = _this4.getPrintTypeLabel(_this4.saleTypes, _this4.saleType);
                _this4.sourceVersion = data.source_version;
                _this4.sourceVersions = data.source_versions;
                _this4.dailyPlanLines = [];
                _this4.availableMachines = _this4.getAvailableMachines(_this4.machineItems, _this4.dailyPlanLines);
                _context4.next = 17;
                return _this4.getPeriodNames(_this4.periodYear);

              case 17:
                _context4.next = 19;
                return _this4.getBiweekOfPlans(_this4.periodYear, _this4.periodName);

              case 19:
                _context4.next = 21;
                return _this4.getWeekOfPlans(_this4.periodYear, _this4.periodName, _this4.biweekly);

              case 21:
                _context4.next = 23;
                return _this4.getProductPlans(_this4.periodYear, _this4.periodName, _this4.biweekly);

              case 23:
                // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
                if (_this4.periodYear && _this4.periodName && _this4.biweekly && _this4.weekly && _this4.printType && _this4.saleType) {
                  _this4.getDailyPlanData(_this4.periodYear, _this4.periodName, _this4.biweekly, _this4.weekly, _this4.printType, _this4.saleType, _this4.sourceVersion, _this4.dailyPlanVersion);
                }

              case 24:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
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

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // SHOW LOADING
                _this5.isLoading = true;
                params = {
                  period_year: periodYear
                };
                _context5.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-months", {
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
                _this5.periodNames = _context5.sent;
                // HIDE LOADING
                _this5.isLoading = false;

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getBiweekOfPlans: function getBiweekOfPlans(periodYear, periodName) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // SHOW LOADING
                _this6.isLoading = true;
                params = {
                  period_year: periodYear,
                  period_name: periodName
                };
                _context6.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-biweeks", {
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
                _this6.biweeklys = _context6.sent;
                // HIDE LOADING
                _this6.isLoading = false;

              case 6:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getWeekOfPlans: function getWeekOfPlans(periodYear, periodName, biweekly) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // SHOW LOADING
                _this7.isLoading = true;
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly
                };
                _context7.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-weeks", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.weeklys ? JSON.parse(resData.weeklys) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this7.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this7.periodNameLabel, " \u0E1B\u0E35 ").concat(_this7.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this7.weeklys = _context7.sent;
                // HIDE LOADING
                _this7.isLoading = false;

              case 6:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    getDailyPlanData: function getDailyPlanData(periodYear, periodName, biweekly, weekly, printType, saleType, sourceVersion, version) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                // SHOW LOADING
                _this8.isLoading = true; // REFRESH DATA

                _this8.dailyPlanHeader = null;
                _this8.dailyPlanVersion = version;
                _this8.dailyPlanLines = [];
                _this8.dailyPlanVersions = [];
                _this8.dailyRemainingItems = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  weekly: weekly,
                  print_type: printType,
                  sale_type: saleType,
                  source_version: sourceVersion,
                  version: version
                };
                _context8.next = 9;
                return axios.get("/ajax/pm/plans/daily/get-info", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  _this8.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                  _this8.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this8.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this8.periodNameLabel, " \u0E1B\u0E35 ").concat(_this8.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 9:
                if (_this8.dailyPlanHeader) {
                  _context8.next = 12;
                  break;
                }

                _context8.next = 12;
                return _this8.createNewPlanVersion();

              case 12:
                _context8.next = 14;
                return _this8.onGetRemainingItems();

              case 14:
                _context8.next = 16;
                return _this8.onGetDailyPlanLines();

              case 16:
                if (!(_this8.dailyPlanLines.length == 0)) {
                  _context8.next = 19;
                  break;
                }

                _context8.next = 19;
                return _this8.onAddNewMachineLine();

              case 19:
                _this8.setUrlParams(); // HIDE LOADING


                _this8.isLoading = false;

              case 21:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    getProductPlans: function getProductPlans(periodYear, periodName, biweekly) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                // SHOW LOADING
                _this9.isLoading = true;
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly
                };
                _context9.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-product-plans", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    var resDaily71Dates = JSON.parse(resData.daily_71_dates);
                    var resMachine71Groups = JSON.parse(resData.machine_71_groups);
                    var resProduct71Plans = JSON.parse(resData.product_71_plans);
                    var resDaily78Dates = JSON.parse(resData.daily_78_dates);
                    var resMachine78Groups = JSON.parse(resData.machine_78_groups);
                    var resProduct78Plans = JSON.parse(resData.product_78_plans);
                    _this9.productDaily71Dates = resDaily71Dates;
                    _this9.productMachine71Groups = resMachine71Groups;
                    _this9.product71Plans = resProduct71Plans;
                    _this9.productDaily78Dates = resDaily78Dates;
                    _this9.productMachine78Groups = resMachine78Groups;
                    _this9.product78Plans = resProduct78Plans;
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 | ".concat(resData.message), "error");
                  }
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 | ".concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this9.isLoading = false;

              case 5:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    getSourceVersions: function getSourceVersions(periodYear, periodName, biweekly, printType, saleType) {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                // SHOW LOADING
                _this10.isLoading = true; // REFRESH DATA

                _this10.sourceVersion = null;
                _this10.sourceVersions = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  print_type: printType,
                  sale_type: saleType
                };
                _context10.next = 6;
                return axios.get("/ajax/pm/plans/daily/get-source-versions", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this10.sourceVersion = resData.source_version ? resData.source_version : null;
                    _this10.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];

                    if (_this10.sourceVersions.length <= 0) {
                      // MOCKUP PREVENT CHECK ON OFFSET
                      if (printType == "52") {
                        swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C\u0E17\u0E35\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34\u0E41\u0E25\u0E49\u0E27", "error");
                      }
                    }
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(error.message), "error");
                  return;
                });

              case 6:
                // HIDE LOADING
                _this10.isLoading = false;

              case 7:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
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
    filterMachineItems: function filterMachineItems(machines, printTypeValue) {
      var printType = printTypeValue ? printTypeValue : this.printTypes[0].print_type_value;
      var filteredMachines = machines.filter(function (machine) {
        return printType == machine.print_type;
      });
      return filteredMachines;
    },
    getAvailableMachines: function getAvailableMachines(machineItems, planLines) {
      var availableMachines = machineItems.filter(function (machine) {
        var foundMachine = planLines.find(function (planLine) {
          return machine.machine_name == planLine.machine_name;
        });
        return !foundMachine;
      });
      return availableMachines;
    },
    onGetDailyPlanLines: function onGetDailyPlanLines() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                // SHOW LOADING
                _this11.isLoading = true; // const foundWeekly = this.weeklys.find(item => {
                //     return item.weekly_value == this.weekly;
                // });
                // const weekDates = foundWeekly ? foundWeekly.dates : [];

                params = {
                  period_year: _this11.periodYear,
                  period_name: _this11.periodName,
                  biweekly: _this11.biweekly,
                  weekly: _this11.weekly,
                  print_type: _this11.printType,
                  sale_type: _this11.saleType,
                  source_version: _this11.sourceVersion,
                  version: _this11.dailyPlanVersion
                };
                _context11.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-lines", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this11.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this11.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];

                    if (_this11.dailyPlanHeader) {
                      if (_this11.sourceVersions.length > 0) {
                        var foundSourceVersion = _this11.sourceVersions.find(function (item) {
                          return item.source_version == _this11.dailyPlanHeader.source_version;
                        });

                        _this11.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : _this11.sourceVersions[0].source_version;
                      } else {
                        _this11.sourceVersion = null;
                      }

                      _this11.dailyPlanVersion = _this11.dailyPlanHeader.version;
                    }

                    _this11.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this11.availableMachines = _this11.getAvailableMachines(_this11.machineItems, _this11.dailyPlanLines);
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this11.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this11.periodNameLabel, " \u0E1B\u0E35 ").concat(_this11.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this11.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this11.isLoading = false;

              case 5:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    onAddNewMachineLine: function onAddNewMachineLine() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var foundWeekly, weekDates, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                // SHOW LOADING
                _this12.isLoading = true;
                foundWeekly = _this12.weeklys.find(function (item) {
                  return item.weekly_value == _this12.weekly;
                });
                weekDates = foundWeekly ? foundWeekly.dates : [];
                reqBody = {
                  period_year: _this12.periodYear,
                  period_name: _this12.periodName,
                  biweekly: _this12.biweekly,
                  weekly: _this12.weekly,
                  print_type: _this12.printType,
                  sale_type: _this12.saleType,
                  source_version: _this12.sourceVersion,
                  version: _this12.dailyPlanVersion,
                  week_dates: JSON.stringify(weekDates),
                  machines: JSON.stringify(_this12.availableMachines),
                  plan_header: JSON.stringify(_this12.dailyPlanHeader)
                };
                _context12.next = 6;
                return axios.post("/ajax/pm/plans/daily/add-new-machine-line", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this12.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this12.availableMachines = _this12.getAvailableMachines(_this12.machineItems, _this12.dailyPlanLines);
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 \u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this12.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this12.periodNameLabel, " \u0E1B\u0E35 ").concat(_this12.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this12.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 \u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this12.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this12.periodNameLabel, " \u0E1B\u0E35 ").concat(_this12.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this12.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 6:
                // HIDE LOADING
                _this12.isLoading = false;

              case 7:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    onGenerateDailyPlanLines: function onGenerateDailyPlanLines() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var foundWeekly, weekDates, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                // SHOW LOADING
                _this13.isLoading = true;
                foundWeekly = _this13.weeklys.find(function (item) {
                  return item.weekly_value == _this13.weekly;
                });
                weekDates = foundWeekly ? foundWeekly.dates : [];
                reqBody = {
                  period_year: _this13.periodYear,
                  period_name: _this13.periodName,
                  biweekly: _this13.biweekly,
                  weekly: _this13.weekly,
                  print_type: _this13.printType,
                  sale_type: _this13.saleType,
                  source_version: _this13.sourceVersion,
                  version: _this13.dailyPlanVersion,
                  week_dates: JSON.stringify(weekDates),
                  machines: JSON.stringify(_this13.machines)
                };
                _context13.next = 6;
                return axios.post("/ajax/pm/plans/daily/generate-lines", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this13.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this13.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];

                    if (_this13.dailyPlanHeader) {
                      if (_this13.sourceVersions.length > 0) {
                        var foundSourceVersion = _this13.sourceVersions.find(function (item) {
                          return item.source_version == _this13.dailyPlanHeader.source_version;
                        });

                        _this13.sourceVersion = foundSourceVersion ? foundSourceVersion.source_version : _this13.sourceVersions[0].source_version;
                      } else {
                        _this13.sourceVersion = null;
                      }

                      _this13.dailyPlanVersion = _this13.dailyPlanHeader.version;
                    }

                    _this13.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    _this13.isNewlyCreate = resData.is_newly_create;
                    _this13.availableMachines = _this13.getAvailableMachines(_this13.machineItems, _this13.dailyPlanLines);
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this13.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this13.periodNameLabel, " \u0E1B\u0E35 ").concat(_this13.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this13.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this13.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this13.periodNameLabel, " \u0E1B\u0E35 ").concat(_this13.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this13.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 6:
                // HIDE LOADING
                _this13.isLoading = false;

              case 7:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    onGetRemainingItems: function onGetRemainingItems() {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                // SHOW LOADING
                _this14.isLoading = true;
                params = {
                  period_year: _this14.periodYear,
                  period_name: _this14.periodName,
                  biweekly: _this14.biweekly,
                  weekly: _this14.weekly,
                  print_type: _this14.printType,
                  sale_type: _this14.saleType,
                  source_version: _this14.sourceVersion,
                  version: _this14.dailyPlanVersion
                };
                _context14.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-remaining-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this14.dailyRemainingItems = resData.items ? JSON.parse(resData.items) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this14.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this14.periodNameLabel, " \u0E1B\u0E35 ").concat(_this14.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this14.printTypeLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this14.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this14.periodNameLabel, " \u0E1B\u0E35 ").concat(_this14.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this14.printTypeLabel, " | ").concat(error.message), "error");
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
    onMachineLineItemsChanged: function onMachineLineItemsChanged(data) {
      var machineLineItems = data.machineLineItems;
      this.availableMachines = this.machineItems.filter(function (machine) {
        var foundMachine = machineLineItems.find(function (planLine) {
          return machine.machine_name == planLine.machine_name;
        });
        return !foundMachine;
      });
    },
    // async onSaveDailyPlan() {
    //     const reqBody = {
    //         period_year: this.periodYear,
    //         period_name: this.periodName,
    //         biweekly: this.biweekly,
    //         print_type: this.printType,
    //         sale_type: this.saleType,
    //         source_version: this.sourceVersion,
    //         version: this.dailyPlanVersion,
    //         plan_header: JSON.stringify(this.dailyPlanHeader),
    //         plan_lines: JSON.stringify(this.dailyPlanLines)
    //     };
    //     // SHOW LOADING
    //     this.isLoading = true;
    //     // call api
    //     await axios.post(`/ajax/pm/plans/daily/store-lines`, reqBody)
    //     .then(res => {
    //         const resData = res.data.data;
    //         const resMsg = resData.message;
    //         const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
    //         if(resData.status == "success") {
    //             this.dailyPlanHeader = resPlanHeader;
    //             this.dailyPlanVersion = resPlanHeader.version;
    //             this.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
    //             this.isNewlyCreate = false;
    //             swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} version : ${this.dailyPlanVersion}`, "success");
    //         }
    //         if(resData.status == "error") {
    //             swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${resMsg}`, "error");
    //         }
    //         return resData;
    //     }).catch((error) => {
    //         console.log(error);
    //         swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน ปักษ์ : ${this.biweekly} เดือน : ${this.periodNameLabel} ปี ${this.periodYearLabel} ระบบการพิมพ์ ${this.printTypeLabel} | ${error.message}`, "error");
    //     });
    //     // HIDE LOADING
    //     this.isLoading = false;
    // },
    onSubmitDailyPlan: function onSubmitDailyPlan() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                reqBody = {
                  period_year: _this15.periodYear,
                  period_name: _this15.periodName,
                  biweekly: _this15.biweekly,
                  print_type: _this15.printType,
                  sale_type: _this15.saleType,
                  source_version: _this15.sourceVersion,
                  version: _this15.dailyPlanVersion,
                  plan_header: JSON.stringify(_this15.dailyPlanHeader),
                  plan_lines: JSON.stringify(_this15.dailyPlanLines)
                }; // SHOW LOADING

                _this15.isLoading = true; // call api

                _context15.next = 4;
                return axios.post("/ajax/pm/plans/daily/submit-plan", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this15.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this15.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", "\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this15.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this15.periodNameLabel, " \u0E1B\u0E35 ").concat(_this15.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this15.printTypeLabel), "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this15.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this15.periodNameLabel, " \u0E1B\u0E35 ").concat(_this15.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this15.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E2A\u0E48\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this15.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this15.periodNameLabel, " \u0E1B\u0E35 ").concat(_this15.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this15.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 4:
                // REFRESH DAILY PLAN DATA
                // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
                if (_this15.periodYear && _this15.periodName && _this15.biweekly && _this15.weekly && _this15.printType && _this15.saleType) {
                  _this15.getDailyPlanData(_this15.periodYear, _this15.periodName, _this15.biweekly, _this15.weekly, _this15.printType, _this15.saleType, _this15.sourceVersion, null);
                } // HIDE LOADING


                _this15.isLoading = false;

              case 6:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    onCreateNewDailyPlanVersion: function onCreateNewDailyPlanVersion() {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                swal({
                  title: "",
                  text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E2A\u0E23\u0E49\u0E32\u0E07 \u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C \u0E41\u0E1C\u0E19\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\u0E08\u0E33\u0E2B\u0E19\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E08\u0E33\u0E1B\u0E35 : ".concat(_this16.periodYearLabel, " \u0E40\u0E27\u0E2D\u0E23\u0E4C\u0E0A\u0E31\u0E48\u0E19\u0E43\u0E2B\u0E21\u0E48 ?"),
                  showCancelButton: true,
                  confirmButtonClass: "btn-primary",
                  confirmButtonText: "ยืนยัน",
                  cancelButtonText: "ยกเลิก",
                  closeOnConfirm: true
                }, function (isConfirm) {
                  if (isConfirm) {
                    _this16.dailyPlanLines = [];

                    _this16.createNewPlanVersion();

                    _this16.availableMachines = _this16.getAvailableMachines(_this16.machineItems, _this16.dailyPlanLines);
                  }
                });

              case 1:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16);
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
      } // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NOT_COMFIRMED  )
      // => NOT ALLOW TO CREATE NEW VERSION


      var inprogressVersions = versions.filter(function (item) {
        return item.status == 1;
      });

      if (inprogressVersions.length > 0) {
        allowed = false;
      }

      return allowed;
    },
    createNewPlanVersion: function createNewPlanVersion() {
      var _arguments = arguments,
          _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee17() {
        var showAlert, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                showAlert = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : false;
                reqBody = {
                  period_year: _this17.periodYear,
                  period_name: _this17.periodName,
                  biweekly: _this17.biweekly,
                  weekly: _this17.weekly,
                  print_type: _this17.printType,
                  sale_type: _this17.saleType,
                  source_version: _this17.sourceVersion
                }; // SHOW LOADING

                _this17.isLoading = true; // call api

                _context17.next = 5;
                return axios.post("/ajax/pm/plans/daily/add-new-header", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this17.dailyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    _this17.dailyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this17.dailyPlanVersion = resData.version;
                    _this17.dailyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    if (showAlert) {
                      swal("Success", "\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this17.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this17.periodNameLabel, " \u0E1B\u0E35 ").concat(_this17.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this17.printTypeLabel, " version : ").concat(_this17.dailyPlanVersion, " )"), "success");
                    }
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this17.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this17.periodNameLabel, " \u0E1B\u0E35 ").concat(_this17.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this17.printTypeLabel, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 \u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this17.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this17.periodNameLabel, " \u0E1B\u0E35 ").concat(_this17.periodYearLabel, " \u0E23\u0E30\u0E1A\u0E1A\u0E01\u0E32\u0E23\u0E1E\u0E34\u0E21\u0E1E\u0E4C ").concat(_this17.printTypeLabel, " | ").concat(error.message), "error");
                });

              case 5:
                // HIDE LOADING
                _this17.isLoading = false;

              case 6:
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["modalName", "modalWidth", "modalHeight", "periodYearValue", "periodNameValue", "biweeklyValue", "printTypeValue", "saleTypeValue", "productDaily71Dates", "productMachine71Groups", "product71Plans", "productDaily78Dates", "productMachine78Groups", "product78Plans", "uomCodes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    periodNameValue: function periodNameValue(value) {
      this.periodName = value;
    },
    biweeklyValue: function biweeklyValue(value) {
      this.biweekly = value;
    },
    printTypeValue: function printTypeValue(value) {
      this.printType = value;
    },
    saleTypeValue: function saleTypeValue(value) {
      this.saleType = value;
    },
    productDaily71Dates: function productDaily71Dates(value) {
      this.productDaily71DateItems = value;
    },
    productMachine71Groups: function productMachine71Groups(value) {
      this.productMachine71GroupItems = value;
    },
    product71Plans: function product71Plans(value) {
      this.product71PlanItems = value;
    },
    productDaily78Dates: function productDaily78Dates(value) {
      this.productDaily78DateItems = value;
    },
    productMachine78Groups: function productMachine78Groups(value) {
      this.productMachine78GroupItems = value;
    },
    product78Plans: function product78Plans(value) {
      this.product78PlanItems = value;
    }
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      periodYear: this.periodYearValue,
      periodName: this.periodNameValue,
      biweekly: this.biweeklyValue,
      printType: this.printTypeValue,
      saleType: this.saleTypeValue,
      isProduct71Active: true,
      isProduct78Active: false,
      productDaily71DateItems: this.productDaily71Dates.length > 0 ? this.productDaily71Dates : [],
      productMachine71GroupItems: this.productMachine71Groups.length > 0 ? this.productMachine71Groups : [],
      product71PlanItems: this.product71Plans.length > 0 ? this.product71Plans : [],
      productDaily78DateItems: this.productDaily78Dates.length > 0 ? this.productDaily78Dates : [],
      productMachine78GroupItems: this.productMachine78Groups.length > 0 ? this.productMachine78Groups : [],
      product78PlanItems: this.product78Plans.length > 0 ? this.product78Plans : []
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
    toggleProductType: function toggleProductType(productType) {
      var _this = this;

      this.isProduct71Active = false;
      this.isProduct78Active = false;
      this.$nextTick(function () {
        if (productType == '71') {
          _this.isProduct71Active = true;
        }

        if (productType == '78') {
          _this.isProduct78Active = true;
        }
      });
    },
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code == uomCode;
      });
      return foundUomCode ? foundUomCode.unit_of_measure : "";
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    },
    getDayOfWeekTh: function getDayOfWeekTh(date) {
      var result = "-";
      var dayNumber = date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(date).day() : 0;

      switch (dayNumber) {
        case 0:
          result = "อาทิตย์";
          break;

        case 1:
          result = "จันทร์";
          break;

        case 2:
          result = "อังคาร";
          break;

        case 3:
          result = "พุธ";
          break;

        case 4:
          result = "พฤหัสบดี";
          break;

        case 5:
          result = "ศุกร์";
          break;

        case 6:
          result = "เสาร์";
          break;

        default:
          result = "-";
      }

      return result;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["modalName", "modalWidth", "modalHeight", "planHeader", "periodYears", "periodYearValue", "periodNames", "periodNameValue", "biweeklys", "biweeklyValue", "weeklys", "weeklyValue", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "sourceVersions", "sourceVersionValue", "dailyPlanVersions", "dailyPlanVersionValue"],
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
    weeklys: function weeklys(value) {
      this.weeklyOptions = value;
    },
    weeklyValue: function weeklyValue(value) {
      this.weekly = this.weeklyValue;
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
    dailyPlanVersionValue: function dailyPlanVersionValue(value) {
      this.dailyPlanVersion = value;
    },
    dailyPlanVersions: function dailyPlanVersions(value) {
      this.dailyPlanVersionOptions = value;
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
      weekly: this.weeklyValue,
      weeklyOptions: this.weeklys,
      printType: this.printTypeValue,
      saleType: this.saleTypeValue,
      sourceVersion: this.sourceVersionValue,
      sourceVersionOptions: this.sourceVersions,
      dailyPlanVersion: this.dailyPlanVersionValue,
      dailyPlanVersionOptions: this.dailyPlanVersions
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
      this.sourceVersion = null;
      this.sourceVersions = [];
      this.dailyPlanVersion = null;
      this.dailyPlanVersionOptions = [];
      this.getPeriodNames(value);
    },
    onPeriodNameChanged: function onPeriodNameChanged(value) {
      this.periodName = value;
      this.periodNameLabel = this.getPeriodNameLabel(this.periodNameOptions, this.periodName); // REFREH DATA

      this.biweeklyOptions = [];
      this.sourceVersion = null;
      this.sourceVersions = [];
      this.dailyPlanVersion = null;
      this.dailyPlanVersionOptions = [];
      this.getBiweekOfPlans(this.periodYear, value);
    },
    onBiweekOfPlanChanged: function onBiweekOfPlanChanged(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.biweekly = value; // REFREH DATA

                _this.sourceVersion = null;
                _this.sourceVersions = [];
                _this.dailyPlanVersion = null;
                _this.dailyPlanVersionOptions = [];
                _context.next = 7;
                return _this.getWeekOfPlans(_this.periodYear, _this.periodName, _this.biweekly);

              case 7:
                _this.weekly = _this.weeklys.length > 0 ? _this.weeklys[0].weekly_value : null;

                if (!(_this.periodYear && _this.periodName && _this.biweekly && _this.printType && _this.saleType)) {
                  _context.next = 12;
                  break;
                }

                _context.next = 11;
                return _this.getSourceVersions(_this.periodYear, _this.periodName, _this.biweekly, _this.printType, _this.saleType);

              case 11:
                if (_this.weekly && _this.sourceVersion) {
                  _this.getDailyPlanData(_this.periodYear, _this.periodName, _this.biweekly, _this.weekly, _this.printType, _this.saleType, _this.sourceVersion, null);
                }

              case 12:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onWeekOfPlanChanged: function onWeekOfPlanChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.weekly = value;

                if (_this2.periodYear && _this2.periodName && _this2.biweekly && _this2.weekly && _this2.printType && _this2.saleType && _this2.sourceVersion) {
                  _this2.getDailyPlanData(_this2.periodYear, _this2.periodName, _this2.biweekly, _this2.weekly, _this2.printType, _this2.saleType, _this2.sourceVersion, null);
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
      this.sourceVersion = value; // if(this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
      //     this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
      // }
    },
    onPrintTypeChanged: function onPrintTypeChanged(value) {
      this.printType = value;

      if (this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
        this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onSaleTypeChanged: function onSaleTypeChanged(value) {
      this.saleType = value;

      if (this.periodYear && this.periodName && this.biweekly && this.weekly && this.printType && this.saleType && this.sourceVersion) {
        this.getDailyPlanData(this.periodYear, this.periodName, this.biweekly, this.weekly, this.printType, this.saleType, this.sourceVersion, null);
      }
    },
    onBiweeklyPlanVersionChanged: function onBiweeklyPlanVersionChanged(value) {
      this.dailyPlanVersion = value;
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

                _this3.dailyPlanVersion = null;
                _this3.dailyPlanVersionOptions = [];
                params = {
                  period_year: periodYear
                };
                _context3.next = 6;
                return axios.get("/ajax/pm/plans/daily/get-months", {
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
                return axios.get("/ajax/pm/plans/daily/get-biweeks", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.biweeklys ? JSON.parse(resData.biweeklys) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E40\u0E14\u0E37\u0E2D\u0E19 : ".concat(_this4.periodNameLabel, " \u0E1B\u0E35 ").concat(_this4.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
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
    getWeekOfPlans: function getWeekOfPlans(periodYear, periodName, biweekly) {
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
                  biweekly: biweekly
                };
                _context5.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-weeks", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.weeklys ? JSON.parse(resData.weeklys) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1B\u0E31\u0E01\u0E29\u0E4C : ".concat(_this5.biweekly, " \u0E40\u0E14\u0E37\u0E2D\u0E19 : ").concat(_this5.periodNameLabel, " \u0E1B\u0E35 ").concat(_this5.periodYearLabel, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this5.weeklyOptions = _context5.sent;
                // hide loading
                _this5.is_loading = false;

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getDailyPlanData: function getDailyPlanData(periodYear, periodName, biweekly, weekly, printType, saleType, sourceVersion, version) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this6.is_loading = true;
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  weekly: weekly,
                  print_type: printType,
                  sale_type: saleType,
                  source_version: sourceVersion,
                  version: version
                };
                _context6.next = 4;
                return axios.get("/ajax/pm/plans/daily/get-info", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  _this6.dailyPlanVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "".concat(error.message), "error");
                  return;
                });

              case 4:
                _this6.dailyPlanVersion = _this6.dailyPlanVersionOptions.length > 0 ? _this6.dailyPlanVersionOptions[0].version : null; // hide loading

                _this6.is_loading = false;

              case 6:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getSourceVersions: function getSourceVersions(periodYear, periodName, biweekly, printType, saleType) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // show loading
                _this7.isLoading = true; // REFRESH DATA

                _this7.sourceVersion = null;
                _this7.sourceVersionOptions = [];
                params = {
                  period_year: periodYear,
                  period_name: periodName,
                  biweekly: biweekly,
                  print_type: printType,
                  sale_type: saleType
                };
                _context7.next = 6;
                return axios.get("/ajax/pm/plans/daily/get-source-versions", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this7.sourceVersion = resData.source_version ? resData.source_version : null;
                    _this7.sourceVersionOptions = resData.source_versions ? JSON.parse(resData.source_versions) : [];

                    if (_this7.sourceVersionOptions.length <= 0) {
                      swal("ไม่พบข้อมูล", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E23\u0E32\u0E22\u0E1B\u0E31\u0E01\u0E29\u0E4C\u0E17\u0E35\u0E48\u0E2D\u0E19\u0E38\u0E21\u0E31\u0E15\u0E34\u0E41\u0E25\u0E49\u0E27", "error");
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
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onSearchPlanVersion: function onSearchPlanVersion() {
      this.$modal.hide(this.modalName);
      this.$emit("onSearchPlanVersion", {
        period_year: this.periodYear,
        period_name: this.periodName,
        biweekly: this.biweekly,
        weekly: this.weekly,
        print_type: this.printType,
        sale_type: this.saleType,
        source_version: this.sourceVersion,
        source_versions: this.sourceVersionOptions,
        version: this.dailyPlanVersion
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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


function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["planHeader", "planLines", "weeklys", "uomCodes", "machines", "availableMachines", "machinePowers", "machineTimes", "dailyRemainingItems"],
  watch: {
    planHeader: function planHeader(dataPlanHeader) {
      this.planHeaderData = dataPlanHeader;
      this.weekDates = this.getWeekDates(this.weeklys, this.planHeaderData.week_number);
    },
    machines: function machines(items) {
      this.machineItems = items;
    },
    availableMachines: function availableMachines(items) {
      this.availableMachineItems = items;
    },
    dailyRemainingItems: function dailyRemainingItems(items) {
      this.remainingItems = items;
    },
    planLines: function planLines(dataPlanLines) {
      this.machineLineItems = this.mapMachineLineItems(this.weeklys, this.machineItems, this.planHeaderData, this.dailyRemainingItems, dataPlanLines);
    }
  },
  data: function data() {
    return {
      planHeaderData: this.planHeader,
      remainingItems: this.dailyRemainingItems ? this.dailyRemainingItems : [],
      machineItems: this.machines,
      availableMachineItems: this.availableMachines,
      machineLineItems: this.mapMachineLineItems(this.weeklys, this.machines, this.planHeader, this.dailyRemainingItems, this.planLines),
      weekDates: this.getWeekDates(this.weeklys, this.planHeader.week_number),
      isLoading: false
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
    mapMachineLineItems: function mapMachineLineItems(weeklys, machineItems, planHeader, remainingItems, planLines) {
      var _this = this;

      var mappedMachineItems = machineItems.filter(function (mItem) {
        mItem.print_pdf = false;
        return planHeader.print_type == mItem.print_type && planLines.find(function (lineItem) {
          mItem.print_pdf = '/pm/plans/daily?print_pdf=1&daily_plan_line_id=' + lineItem.daily_plan_line_id;
          return mItem.machine_name == lineItem.machine_name;
        });
      }).map(function (item) {
        var foundMachineLine = planLines.find(function (plItem) {
          return plItem.machine_name == item.machine_name;
        });
        return _objectSpread(_objectSpread({}, item), {}, {
          "created_at": foundMachineLine ? foundMachineLine.created_at : null,
          "mon": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Mon"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Mon")
          },
          "tue": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Tue"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Tue")
          },
          "wed": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Wed"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Wed")
          },
          "thu": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Thu"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Thu")
          },
          "fri": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Fri"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Fri")
          },
          "sat": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Sat"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Sat")
          },
          "sun": {
            "plan_time": _this.getMachinePlanTimeByDay(weeklys, planLines, planHeader.week_number, item.machine_name, "Sun"),
            "items": _this.getMachineLineItemsByDay(weeklys, remainingItems, planLines, planHeader.week_number, item.machine_name, "Sun")
          }
        });
      }).sort(function (a, b) {
        return moment__WEBPACK_IMPORTED_MODULE_4___default()(a.created_at) - moment__WEBPACK_IMPORTED_MODULE_4___default()(b.created_at);
      });
      return mappedMachineItems;
    },
    getWeekDates: function getWeekDates(weeklys, weekly) {
      var foundWeekly = weeklys.find(function (item) {
        return item.weekly_value == weekly;
      });
      var weekDates = foundWeekly ? foundWeekly.dates : [];
      return weekDates;
    },
    isDayEnabled: function isDayEnabled(weekDates, day) {
      var foundItem = weekDates.find(function (item) {
        return day == item.day;
      });
      return !!foundItem;
    },
    getDateByDay: function getDateByDay(weekDates, day) {
      var foundItem = weekDates.find(function (item) {
        return day == item.day;
      });
      return foundItem ? this.formatDateTh(foundItem.date) : "-";
    },
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code == uomCode;
      });
      return foundUomCode ? foundUomCode.unit_of_measure : "";
    },
    getMachinePlanTimeByDay: function getMachinePlanTimeByDay(weeklys, planLines, weekly, machineName, day) {
      var planTime = this.machineTimes.length > 0 ? this.machineTimes[0].lookup_code : "";
      var weekDates = this.getWeekDates(weeklys, weekly);
      var foundDayInfo = weekDates.find(function (item) {
        return day == item.day;
      });
      var foundDate = foundDayInfo ? foundDayInfo.date : null;

      if (foundDate) {
        var foundItem = planLines.find(function (item) {
          return item.machine_name == machineName && moment__WEBPACK_IMPORTED_MODULE_4___default()(item.plan_date).format('YYYY-MM-DD') == moment__WEBPACK_IMPORTED_MODULE_4___default()(foundDate).format('YYYY-MM-DD');
        });
        planTime = foundItem.plan_time;
      }

      return planTime;
    },
    getMachinePlanTimeDesc: function getMachinePlanTimeDesc(machineTimes, planTime) {
      var result = null;

      if (planTime) {
        var foundItem = machineTimes.find(function (item) {
          return item.lookup_code == planTime;
        });
        result = foundItem ? foundItem.description : null;
      }

      return result;
    },
    getMachineLineItemCreatedAt: function getMachineLineItemCreatedAt(planLines, machineName) {
      var machineLineCreatedAt = planLines.find(function (item) {
        return item.machine_name == machineName;
      });
      return machineLineCreatedAt;
    },
    getMachineLineItemsByDay: function getMachineLineItemsByDay(weeklys, remainingItems, planLines, weekly, machineName, day) {
      var _this2 = this;

      var machineLineByDayItems = [];
      var weekDates = this.getWeekDates(weeklys, weekly);
      var foundDayInfo = weekDates.find(function (item) {
        return day == item.day;
      });
      var foundDate = foundDayInfo ? foundDayInfo.date : null;

      if (foundDate) {
        var filteredItems = planLines.filter(function (item) {
          return item.machine_name == machineName && moment__WEBPACK_IMPORTED_MODULE_4___default()(item.plan_date).format('YYYY-MM-DD') == moment__WEBPACK_IMPORTED_MODULE_4___default()(foundDate).format('YYYY-MM-DD');
        });
        machineLineByDayItems = filteredItems.map(function (item) {
          var itemInfo = _this2.getItemInfo(remainingItems, item.request_number);

          return _objectSpread(_objectSpread({}, item), {}, {
            uom: itemInfo ? itemInfo.uom : null,
            product_colors: item.attribute12,
            // product_colors == attribute12
            qty: item.qty ? item.qty : 0,
            starttime: item.mes_starttime ? moment__WEBPACK_IMPORTED_MODULE_4___default()(item.mes_starttime).format('HH:mm') : "",
            endtime: item.mes_endtime ? moment__WEBPACK_IMPORTED_MODULE_4___default()(item.mes_endtime).format('HH:mm') : "",
            remark: item.remark ? item.remark : ''
          }); // }).sort((a, b) => {
          //     return moment(a.created_at) - moment(b.created_at);
        });
      }

      return machineLineByDayItems;
    },
    onMachinePlanTimeChanged: function onMachinePlanTimeChanged(planTime, machineData) {
      var _this3 = this;

      var defaultStarttime = "";
      var defaultEndtime = "";
      machineData.plan_time = planTime;

      if (planTime) {
        var foundItem = this.machineTimes.find(function (item) {
          return item.lookup_code == planTime;
        });

        if (foundItem) {
          defaultStarttime = foundItem.attribute3 ? foundItem.attribute3.replace(".", ":") : "";
          defaultEndtime = foundItem.attribute4 ? foundItem.attribute4.replace(".", ":") : "";
        }
      }

      var machineDataItems = machineData.items.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          qty: 0,
          starttime: defaultStarttime ? defaultStarttime : item.starttime,
          endtime: defaultEndtime ? defaultEndtime : item.endtime,
          remark: item.remark,
          plan_time: planTime
        });
      });
      machineData.items = machineDataItems; // SAVE PLAN_TIME

      machineDataItems.map(function (machineLineItem) {
        _this3.onSaveDailyPlanLine(machineLineItem);
      });
    },
    onMachineNameChanged: function onMachineNameChanged(machineName, machineItem) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var previousMachineNName, isAvailable, newMachine, machineMonItems, machineTueItems, machineWedItems, machineThuItems, machineFriItems, machineSatItems, machineSunItems;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                // VALIDATE BEFORE CHANGED
                previousMachineNName = machineItem.machine_name;
                isAvailable = _this4.availableMachineItems.find(function (availableMachine) {
                  return machineName == availableMachine.machine_name;
                });
                machineItem.machine_name = machineName;

                if (isAvailable) {
                  _context8.next = 8;
                  break;
                }

                swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E43\u0E0A\u0E49 \u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E08\u0E31\u0E01\u0E23 \u0E0B\u0E49\u0E33\u0E01\u0E31\u0E19\u0E44\u0E14\u0E49 ( \u0E0A\u0E37\u0E48\u0E2D\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07 : ".concat(machineName, ")"), "error");

                _this4.$nextTick(function () {
                  machineItem.machine_name = previousMachineNName == null ? "" : previousMachineNName == "" ? null : previousMachineNName;

                  _this4.emitMachineLineItemsChanged();
                });

                _context8.next = 39;
                break;

              case 8:
                newMachine = _this4.machineItems.find(function (machine) {
                  return machineName == machine.machine_name;
                });

                if (!newMachine) {
                  _context8.next = 38;
                  break;
                }

                // SAVE MON MACHINE ITEMS
                machineMonItems = machineItem.mon.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.mon.items = machineMonItems;
                _context8.next = 14;
                return Promise.all(machineMonItems.map( /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(machineMonLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                      while (1) {
                        switch (_context.prev = _context.next) {
                          case 0:
                            _context.next = 2;
                            return _this4.onSaveDailyPlanLine(machineMonLineItem);

                          case 2:
                            return _context.abrupt("return", _context.sent);

                          case 3:
                          case "end":
                            return _context.stop();
                        }
                      }
                    }, _callee);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }()));

              case 14:
                // SAVE TUE MACHINE ITEMS
                machineTueItems = machineItem.tue.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.tue.items = machineTueItems;
                _context8.next = 18;
                return Promise.all(machineTueItems.map( /*#__PURE__*/function () {
                  var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(machineTueLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
                      while (1) {
                        switch (_context2.prev = _context2.next) {
                          case 0:
                            _context2.next = 2;
                            return _this4.onSaveDailyPlanLine(machineTueLineItem);

                          case 2:
                            return _context2.abrupt("return", _context2.sent);

                          case 3:
                          case "end":
                            return _context2.stop();
                        }
                      }
                    }, _callee2);
                  }));

                  return function (_x2) {
                    return _ref2.apply(this, arguments);
                  };
                }()));

              case 18:
                // SAVE WED MACHINE ITEMS
                machineWedItems = machineItem.wed.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.wed.items = machineWedItems;
                _context8.next = 22;
                return Promise.all(machineWedItems.map( /*#__PURE__*/function () {
                  var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(machineWedLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
                      while (1) {
                        switch (_context3.prev = _context3.next) {
                          case 0:
                            _context3.next = 2;
                            return _this4.onSaveDailyPlanLine(machineWedLineItem);

                          case 2:
                            return _context3.abrupt("return", _context3.sent);

                          case 3:
                          case "end":
                            return _context3.stop();
                        }
                      }
                    }, _callee3);
                  }));

                  return function (_x3) {
                    return _ref3.apply(this, arguments);
                  };
                }()));

              case 22:
                // SAVE THU MACHINE ITEMS
                machineThuItems = machineItem.thu.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.thu.items = machineThuItems;
                _context8.next = 26;
                return Promise.all(machineThuItems.map( /*#__PURE__*/function () {
                  var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(machineThuLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
                      while (1) {
                        switch (_context4.prev = _context4.next) {
                          case 0:
                            _context4.next = 2;
                            return _this4.onSaveDailyPlanLine(machineThuLineItem);

                          case 2:
                            return _context4.abrupt("return", _context4.sent);

                          case 3:
                          case "end":
                            return _context4.stop();
                        }
                      }
                    }, _callee4);
                  }));

                  return function (_x4) {
                    return _ref4.apply(this, arguments);
                  };
                }()));

              case 26:
                // SAVE FRI MACHINE ITEMS
                machineFriItems = machineItem.fri.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.fri.items = machineFriItems;
                _context8.next = 30;
                return Promise.all(machineFriItems.map( /*#__PURE__*/function () {
                  var _ref5 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(machineFriLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
                      while (1) {
                        switch (_context5.prev = _context5.next) {
                          case 0:
                            _context5.next = 2;
                            return _this4.onSaveDailyPlanLine(machineFriLineItem);

                          case 2:
                            return _context5.abrupt("return", _context5.sent);

                          case 3:
                          case "end":
                            return _context5.stop();
                        }
                      }
                    }, _callee5);
                  }));

                  return function (_x5) {
                    return _ref5.apply(this, arguments);
                  };
                }()));

              case 30:
                // SAVE SAT MACHINE ITEMS
                machineSatItems = machineItem.sat.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.sat.items = machineSatItems;
                _context8.next = 34;
                return Promise.all(machineSatItems.map( /*#__PURE__*/function () {
                  var _ref6 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6(machineSatLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
                      while (1) {
                        switch (_context6.prev = _context6.next) {
                          case 0:
                            _context6.next = 2;
                            return _this4.onSaveDailyPlanLine(machineSatLineItem);

                          case 2:
                            return _context6.abrupt("return", _context6.sent);

                          case 3:
                          case "end":
                            return _context6.stop();
                        }
                      }
                    }, _callee6);
                  }));

                  return function (_x6) {
                    return _ref6.apply(this, arguments);
                  };
                }()));

              case 34:
                // SAVE SUNN MACHINE ITEMS
                machineSunItems = machineItem.sun.items.map(function (item) {
                  return _objectSpread(_objectSpread({}, item), {}, {
                    qty: 0,
                    starttime: item.starttime,
                    endtime: item.endtime,
                    remark: item.remark,
                    machine_name: newMachine.machine_name,
                    machine_group: newMachine.machine_group
                  });
                });
                machineItem.sun.items = machineSunItems;
                _context8.next = 38;
                return Promise.all(machineSunItems.map( /*#__PURE__*/function () {
                  var _ref7 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7(machineSunLineItem) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
                      while (1) {
                        switch (_context7.prev = _context7.next) {
                          case 0:
                            _context7.next = 2;
                            return _this4.onSaveDailyPlanLine(machineSunLineItem);

                          case 2:
                            return _context7.abrupt("return", _context7.sent);

                          case 3:
                          case "end":
                            return _context7.stop();
                        }
                      }
                    }, _callee7);
                  }));

                  return function (_x7) {
                    return _ref7.apply(this, arguments);
                  };
                }()));

              case 38:
                _this4.emitMachineLineItemsChanged();

              case 39:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    onMachineItemChanged: function onMachineItemChanged(requestNumber, machineItem, machineLineItem, day) {
      var itemInfo = this.getItemInfo(this.remainingItems, requestNumber);

      if (itemInfo) {
        var previousInvItemId = machineLineItem.inventory_item_id;
        var previousRequestNumber = machineLineItem.request_number;
        machineLineItem.inventory_item_id = itemInfo.inventory_item_id;
        machineLineItem.request_number = requestNumber;

        if (this.validateMachineItem(machineItem, machineLineItem, day)) {
          // VALIDATE => PASSED
          machineLineItem.inv_item_number = itemInfo.segment1;
          machineLineItem.inv_item_desc = itemInfo.description;
          machineLineItem.colors = itemInfo.colors;
          machineLineItem.product_colors = itemInfo.product_colors;
          machineLineItem.brand = itemInfo.brand;
          machineLineItem.product = itemInfo.product;
          machineLineItem.source_plan_line_id = itemInfo.plan_line_id;
          machineLineItem.uom = itemInfo.uom;
          this.onSaveDailyPlanLine(machineLineItem);
        } else {
          // VALIDATE => FAILED
          swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01 \u0E43\u0E0A\u0E49 job \u0E0B\u0E49\u0E33\u0E01\u0E31\u0E19\u0E44\u0E14\u0E49 \u0E43\u0E19\u0E40\u0E04\u0E23\u0E37\u0E48\u0E2D\u0E07\u0E40\u0E14\u0E35\u0E22\u0E27\u0E01\u0E31\u0E19 ( job number : ".concat(machineLineItem.request_number, ")"), "error");
          this.$nextTick(function () {
            machineLineItem.inventory_item_id = previousInvItemId == null ? "" : previousInvItemId == "" ? null : previousInvItemId;
            machineLineItem.request_number = previousRequestNumber;
          });
        }
      }
    },
    validateMachineItem: function validateMachineItem(machineItem, machineLineItem, day) {
      var valid = true;
      var machineLineItems = machineItem[day].items;
      var duplicates = [];
      var requestNumbers = machineLineItems.map(function (item) {
        return item.request_number;
      }).sort();

      for (var i = 0; i < requestNumbers.length; i++) {
        if (requestNumbers[i]) {
          if (requestNumbers[i + 1] === requestNumbers[i]) {
            duplicates.push(requestNumbers[i]);
          }
        }
      }

      if (duplicates.length > 0) {
        valid = false;
      }

      return valid;
    },
    onMachineItemQtyChanged: function onMachineItemQtyChanged(machineItem, machineLineItem, day) {
      if (this.validateMachineItemQty(machineItem, machineLineItem, day)) {
        // VALIDATE => PASSED
        this.onSaveDailyPlanLine(machineLineItem);
      } else {
        // VALIDATE => FAILED
        machineLineItem.qty = 0;
      }
    },
    validateMachineItemQty: function validateMachineItemQty(machineItem, machineLineItem, day) {
      var valid = true;
      var machineName = machineItem.machine_name;
      var machineProductTime = machineItem[day].plan_time;
      var machinePower = this.machinePowers.find(function (item) {
        return item.product_time == machineProductTime && item.machine_name == machineName;
      });
      var machineLineItems = machineItem[day].items;
      var machineTotalQty = machineLineItems.reduce(function (ac, cur) {
        return ac + (cur.qty ? parseFloat(cur.qty) : 0);
      }, 0);

      if (parseFloat(machinePower.power) < machineTotalQty) {
        valid = false;
        swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01 \u0E08\u0E33\u0E19\u0E27\u0E19\u0E1C\u0E25\u0E34\u0E15 \u0E44\u0E14\u0E49\u0E40\u0E01\u0E34\u0E19 Machine Cap \u0E43\u0E19 1 \u0E27\u0E31\u0E19 (\u0E08\u0E33\u0E19\u0E27\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E23\u0E27\u0E21 : ".concat(machineTotalQty, ", Machine Cap : ").concat(machinePower.power, " )"), "error");
      }

      return valid;
    },
    onMachineItemRemarkChanged: function onMachineItemRemarkChanged(machineItem, machineLineItem, day) {
      this.onSaveDailyPlanLine(machineLineItem);
    },
    onMachineItemStartTimeChanged: function onMachineItemStartTimeChanged(value, machineLineItem) {
      machineLineItem.starttime = value;
    },
    onMachineItemEndTimeChanged: function onMachineItemEndTimeChanged(value, machineLineItem) {
      machineLineItem.endtime = value;
    },
    onMachineItemStartTimeClosed: function onMachineItemStartTimeClosed(value, machineLineItem) {
      this.onSaveDailyPlanLine(machineLineItem);
    },
    onMachineItemEndTimeClosed: function onMachineItemEndTimeClosed(value, machineLineItem) {
      this.onSaveDailyPlanLine(machineLineItem);
    },
    getItemInfo: function getItemInfo(remainingItems, requestNumber) {
      var result = null;

      if (requestNumber) {
        result = remainingItems.find(function (item) {
          return item.request_number == requestNumber;
        });
      }

      return result;
    },
    getItemFullDesc: function getItemFullDesc(remainingItems, requestNumber) {
      var result = null;

      if (requestNumber) {
        var foundItem = remainingItems.find(function (item) {
          return item.request_number == requestNumber;
        });
        result = foundItem ? foundItem.full_item_desc : null;
      }

      return result;
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_4___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    },
    onSaveDailyPlanLine: function onSaveDailyPlanLine(planLine) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var reqBody, resStoreLine;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                reqBody = {
                  plan_header: JSON.stringify(_this5.planHeaderData),
                  plan_line: JSON.stringify(planLine)
                }; // SHOW LOADING

                _this5.isLoading = true; // call store sample result

                _context9.next = 4;
                return axios.post("/ajax/pm/plans/daily/store-line", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message; // const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                  if (resData.status == "success") {// swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน`, "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "".concat(resMsg), "error");
                    planLine.qty = 0;
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(error.message), "error");
                });

              case 4:
                resStoreLine = _context9.sent;
                // HIDE LOADING
                _this5.isLoading = false;
                return _context9.abrupt("return", resStoreLine);

              case 7:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    onAddNewLine: function onAddNewLine(machineIndex, day, planLines) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var cloneLastPlanLineItem, planTime, defaultStarttime, defaultEndtime, foundItem, newplanLine, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                cloneLastPlanLineItem = _objectSpread({}, planLines.find(function (item, index) {
                  return index == planLines.length - 1;
                }));
                planTime = cloneLastPlanLineItem.plan_time;
                defaultStarttime = "";
                defaultEndtime = "";

                if (planTime) {
                  foundItem = _this6.machineTimes.find(function (item) {
                    return item.lookup_code == planTime;
                  });

                  if (foundItem) {
                    defaultStarttime = foundItem.attribute3 ? foundItem.attribute3.replace(".", ":") : "";
                    defaultEndtime = foundItem.attribute4 ? foundItem.attribute4.replace(".", ":") : "";
                  }
                }

                newplanLine = _objectSpread(_objectSpread({}, cloneLastPlanLineItem), {}, {
                  qty: 0,
                  starttime: defaultStarttime,
                  endtime: defaultEndtime,
                  remark: "",
                  daily_plan_line_id: null,
                  inventory_item_id: null,
                  inv_item_number: null,
                  inv_item_desc: null,
                  colors: null,
                  product_colors: null,
                  brand: null,
                  product: null,
                  request_number: null,
                  source_plan_line_id: null
                });
                reqBody = {
                  plan_header: JSON.stringify(_this6.planHeaderData),
                  plan_line: JSON.stringify(newplanLine)
                }; // SHOW LOADING

                _this6.isLoading = true; // call store sample result

                _context10.next = 10;
                return axios.post("/ajax/pm/plans/daily/add-new-line", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                  var resPlanLine = resData.plan_line ? JSON.parse(resData.plan_line) : null;

                  if (resPlanLine) {
                    resPlanLine.starttime = resPlanLine.mes_starttime;
                    resPlanLine.endtime = resPlanLine.mes_endtime;
                    planLines = [].concat(_toConsumableArray(planLines), [resPlanLine]);
                    _this6.machineLineItems[machineIndex][day].items = planLines;
                  }

                  if (resData.status == "success") {// swal("Success", `บันทึกข้อมูลการวางแผนผลิตสิ่งพิมพ์รายวัน`, "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E1E\u0E34\u0E48\u0E21\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E1E\u0E34\u0E48\u0E21\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(error.message), "error");
                });

              case 10:
                // HIDE LOADING
                _this6.isLoading = false;

                _this6.emitMachineLineItemsChanged();

              case 12:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    onDeleteMachineLine: function onDeleteMachineLine(machineName) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                reqBody = {
                  plan_header: JSON.stringify(_this7.planHeaderData),
                  machine_name: machineName
                }; // SHOW LOADING

                _this7.isLoading = true; // call store sample result

                _context11.next = 4;
                return axios.post("/ajax/pm/plans/daily/delete-machine-line", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    var dataPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    _this7.machineLineItems = _this7.mapMachineLineItems(_this7.weeklys, _this7.machineItems, _this7.planHeaderData, _this7.remainingItems, dataPlanLines);
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this7.isLoading = false;

                _this7.emitMachineLineItemsChanged();

              case 6:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    onDeleteLine: function onDeleteLine(planLineItems, planLineItem) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                if (!(planLineItems.length <= 1)) {
                  _context12.next = 14;
                  break;
                }

                // IF LINES (ON THAT DAY) <= 1
                // => CLEAR DATA OF THAT LINE
                planLineItem.inventory_item_id = null;
                planLineItem.inv_item_number = null;
                planLineItem.inv_item_desc = null;
                planLineItem.colors = null;
                planLineItem.product_colors = null;
                planLineItem.brand = null;
                planLineItem.product = null;
                planLineItem.request_number = null;
                planLineItem.source_plan_line_id = null;
                _context12.next = 12;
                return _this8.onSaveDailyPlanLine(planLineItem);

              case 12:
                _context12.next = 19;
                break;

              case 14:
                // IF LINES (ON THAT DAY) > 1
                // => DELETE THAT LINE FROM TABLE
                reqBody = {
                  plan_header: JSON.stringify(_this8.planHeaderData),
                  plan_line: JSON.stringify(planLineItem)
                }; // SHOW LOADING

                _this8.isLoading = true; // call store sample result

                _context12.next = 18;
                return axios.post("/ajax/pm/plans/daily/delete-line", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    // Remove deleted item from 'planLineItems'
                    var foundIndex = planLineItems.findIndex(function (item) {
                      return item.daily_plan_line_id == planLineItem.daily_plan_line_id;
                    });
                    planLineItems.splice(foundIndex, 1);
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E01\u0E32\u0E23\u0E27\u0E32\u0E07\u0E41\u0E1C\u0E19\u0E1C\u0E25\u0E34\u0E15\u0E2A\u0E34\u0E48\u0E07\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E27\u0E31\u0E19 | ".concat(error.message), "error");
                });

              case 18:
                // HIDE LOADING
                _this8.isLoading = false;

              case 19:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    emitMachineLineItemsChanged: function emitMachineLineItemsChanged() {
      this.$emit("onMachineLineItemsChanged", {
        machineLineItems: this.machineLineItems
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-fbe025f4] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-238308fc] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_style_index_0_id_fbe025f4_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_style_index_0_id_fbe025f4_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_style_index_0_id_fbe025f4_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_238308fc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_238308fc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_238308fc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/Index.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/Index.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_0b0ffbd0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=0b0ffbd0& */ "./resources/js/components/pm/plans/daily/Index.vue?vue&type=template&id=0b0ffbd0&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/daily/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_0b0ffbd0___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_0b0ffbd0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/daily/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalProductPlans.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalProductPlans_vue_vue_type_template_id_fbe025f4_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true& */ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true&");
/* harmony import */ var _ModalProductPlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalProductPlans.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalProductPlans_vue_vue_type_style_index_0_id_fbe025f4_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css& */ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalProductPlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalProductPlans_vue_vue_type_template_id_fbe025f4_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalProductPlans_vue_vue_type_template_id_fbe025f4_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "fbe025f4",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/daily/ModalProductPlans.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalSearchPlan.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearchPlan_vue_vue_type_template_id_238308fc_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true& */ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true&");
/* harmony import */ var _ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearchPlan.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSearchPlan_vue_vue_type_style_index_0_id_238308fc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css& */ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearchPlan_vue_vue_type_template_id_238308fc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearchPlan_vue_vue_type_template_id_238308fc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "238308fc",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/daily/ModalSearchPlan.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/TablePlanLines.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/TablePlanLines.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TablePlanLines_vue_vue_type_template_id_1dfce91a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=template&id=1dfce91a& */ "./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=template&id=1dfce91a&");
/* harmony import */ var _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TablePlanLines.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TablePlanLines_vue_vue_type_template_id_1dfce91a___WEBPACK_IMPORTED_MODULE_0__.render,
  _TablePlanLines_vue_vue_type_template_id_1dfce91a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/plans/daily/TablePlanLines.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/Index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/Index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalProductPlans.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css&":
/*!*******************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_style_index_0_id_fbe025f4_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=style&index=0&id=fbe025f4&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_style_index_0_id_238308fc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=style&index=0&id=238308fc&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/pm/plans/daily/Index.vue?vue&type=template&id=0b0ffbd0&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/Index.vue?vue&type=template&id=0b0ffbd0& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_0b0ffbd0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_0b0ffbd0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_0b0ffbd0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=0b0ffbd0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/Index.vue?vue&type=template&id=0b0ffbd0&");


/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_template_id_fbe025f4_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_template_id_fbe025f4_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalProductPlans_vue_vue_type_template_id_fbe025f4_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_template_id_238308fc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_template_id_238308fc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchPlan_vue_vue_type_template_id_238308fc_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true&");


/***/ }),

/***/ "./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=template&id=1dfce91a&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=template&id=1dfce91a& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_1dfce91a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_1dfce91a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePlanLines_vue_vue_type_template_id_1dfce91a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePlanLines.vue?vue&type=template&id=1dfce91a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=template&id=1dfce91a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/Index.vue?vue&type=template&id=0b0ffbd0&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/Index.vue?vue&type=template&id=0b0ffbd0& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
                      _vm.dailyPlanVersions
                    )
                  },
                  on: { click: _vm.onCreateNewDailyPlanVersion }
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
                    "btn btn-inline-block btn-sm btn-warning tw-w-40",
                  attrs: {
                    disabled:
                      (_vm.dailyPlanHeader
                        ? _vm.dailyPlanHeader.status != "1"
                        : true) ||
                      _vm.dailyPlanLines.length == 0 ||
                      _vm.isNewlyCreate
                  },
                  on: { click: _vm.onSubmitDailyPlan }
                },
                [
                  _c("i", { staticClass: "fa fa-check-square tw-mr-1" }),
                  _vm._v(" ยืนยัน \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-info tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.periodYear || !_vm.periodName || !_vm.biweekly
                  },
                  on: {
                    click: function($event) {
                      return _vm.$modal.show("modal-product-plans")
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-print tw-mr-1" }),
                  _vm._v(" ดูแผนการผลิตบุหรี่ \n                ")
                ]
              ),
              _vm._v(" "),
              !_vm.dailyPlanHeader
                ? _c(
                    "button",
                    {
                      staticClass:
                        "btn btn-inline-block btn-sm btn-primary tw-w-40",
                      attrs: {
                        disabled: _vm.dailyPlanHeader
                          ? _vm.dailyPlanHeader.status == "1"
                          : true
                      }
                    },
                    [
                      _c("i", { staticClass: "fa fa-print tw-mr-1" }),
                      _vm._v(" พิมพ์รายงาน \n                ")
                    ]
                  )
                : _c(
                    "a",
                    {
                      staticClass:
                        "btn btn-inline-block btn-sm btn-primary tw-w-40 text-white",
                      attrs: {
                        href:
                          "/pm/plans/daily?print_pdf=1&daily_plan_header_id=" +
                          _vm.dailyPlanHeader.daily_plan_header_id,
                        disabled: _vm.dailyPlanHeader
                          ? _vm.dailyPlanHeader.daily_plan_header_id != "" &&
                            _vm.dailyPlanHeader.daily_plan_header_id != null &&
                            _vm.dailyPlanHeader.daily_plan_header_id !=
                              undefined
                          : false,
                        target: "_blank"
                      }
                    },
                    [
                      _c("i", { staticClass: "fa fa-print tw-mr-1" }),
                      _vm._v(" พิมพ์รายงาน\n                ")
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
                    { staticClass: "col-md-8" },
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
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-6" }, [
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" ปักษ์ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-3" },
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
                        _vm.dailyPlanHeader,
                        _vm.dailyPlanLines
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
                        _vm.dailyPlanHeader,
                        _vm.dailyPlanLines
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
                    [_vm._v(" สัปดาห์ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "weekly",
                          id: "input_weekly",
                          "select-options": _vm.weeklys,
                          "option-key": "weekly_value",
                          "option-value": "weekly_value",
                          "option-label": "weekly_label",
                          value: _vm.weekly,
                          filterable: true
                        },
                        on: { onSelected: _vm.onWeekOfPlanChanged }
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
                  _c("div", { staticClass: "col-md-8" }, [
                    _vm.dailyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(
                                _vm.dailyPlanHeader.version
                                  ? _vm.dailyPlanHeader.version
                                  : "-"
                              ) +
                              " "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.dailyPlanHeader
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
                    _vm.dailyPlanHeader
                      ? _c("p", { staticClass: "col-form-label" }, [
                          _vm._v(
                            " " +
                              _vm._s(
                                _vm.getPlanStatusDesc(
                                  _vm.dailyPlanHeader.status
                                )
                              ) +
                              " "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.dailyPlanHeader
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
          _vm.dailyPlanLines.length > 0
            ? _c("div", { staticClass: "tw-m-8" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    { staticClass: "col-12" },
                    [
                      _c("div", { staticClass: "tw-mb-4" }, [
                        _c(
                          "button",
                          {
                            staticClass:
                              "btn btn-inline-block btn-sm btn-success tw-w-52",
                            attrs: {
                              disabled:
                                !_vm.dailyPlanHeader ||
                                this.availableMachines.length <= 0
                            },
                            on: { click: _vm.onAddNewMachineLine }
                          },
                          [
                            _c("i", { staticClass: "fa fa-plus tw-mr-1" }),
                            _vm._v(" เพิ่มเครื่อง\n                        ")
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("table-plan-lines", {
                        attrs: {
                          "plan-header": _vm.dailyPlanHeader,
                          "plan-lines": _vm.dailyPlanLines,
                          weeklys: _vm.weeklys,
                          "uom-codes": _vm.uomCodes,
                          machines: _vm.machineItems,
                          "available-machines": _vm.availableMachines,
                          "machine-powers": _vm.machinePowers,
                          "machine-times": _vm.machineTimes,
                          "daily-remaining-items": _vm.dailyRemainingItems
                        },
                        on: {
                          onMachineLineItemsChanged:
                            _vm.onMachineLineItemsChanged
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
      _c("modal-product-plans", {
        attrs: {
          "modal-name": "modal-product-plans",
          "modal-width": "960",
          "modal-height": "auto",
          "period-year-value": _vm.periodYear,
          "period-name-value": _vm.periodName,
          "biweekly-value": _vm.biweekly,
          "print-type-value": _vm.printType,
          "sale-type-value": _vm.saleType,
          "product-daily71-dates": _vm.productDaily71Dates,
          "product-machine71-groups": _vm.productMachine71Groups,
          "product71-plans": _vm.product71Plans,
          "product-daily78-dates": _vm.productDaily78Dates,
          "product-machine78-groups": _vm.productMachine78Groups,
          "product78-plans": _vm.product78Plans,
          "uom-codes": _vm.uomCodes
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
          weeklys: _vm.weeklys,
          "weekly-value": _vm.weekly,
          "print-types": _vm.printTypes,
          "print-type-value": _vm.printType,
          "sale-types": _vm.saleTypes,
          "sale-type-value": _vm.saleType,
          "source-versions": _vm.sourceVersions,
          "source-version-value": _vm.sourceVersion,
          "daily-plan-version-value": _vm.dailyPlanVersion,
          "daily-plan-versions": _vm.dailyPlanVersions
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalProductPlans.vue?vue&type=template&id=fbe025f4&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
            _c("div", [
              _c("div", { staticClass: "tw-inline-block tw-px-4" }, [
                _vm._v(" แผนการผลิตบุหรี่ : ")
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "tw-inline-block btn-group",
                  attrs: { role: "group" }
                },
                [
                  _c(
                    "button",
                    {
                      staticClass: "btn",
                      class: [
                        _vm.isProduct71Active ? "btn-primary" : "btn-white"
                      ],
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.toggleProductType("71")
                        }
                      }
                    },
                    [_vm._v(" 7.1 ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn",
                      class: [
                        _vm.isProduct78Active ? "btn-primary" : "btn-white"
                      ],
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.toggleProductType("78")
                        }
                      }
                    },
                    [_vm._v(" 7.8 ")]
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _vm.isProduct71Active
              ? _c(
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
                        staticStyle: { "min-width": "800px" }
                      },
                      [
                        _c("thead", [
                          _c(
                            "tr",
                            [
                              _c(
                                "th",
                                {
                                  staticClass: "text-center freeze-col",
                                  staticStyle: { "min-width": "220px" }
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
                                            "text-center tw-inline-block tw-align-top tw-py-4 tw-py-5",
                                          staticStyle: {
                                            "min-width": "50px",
                                            "max-width": "50px"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        ลำดับ  \n                                    "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "text-center tw-inline-block tw-align-top tw-py-4 tw-py-5",
                                          staticStyle: {
                                            "min-width": "140px",
                                            "max-width": "140px",
                                            "border-left": "1px solid #ddd"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        ขอบเขตเครื่องจักร\n                                    "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _vm._l(_vm.productDaily71Dates, function(
                                productDaily71Date,
                                pdhIndex
                              ) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      key: "pdh_" + pdhIndex,
                                      staticClass: "text-center",
                                      staticStyle: { "min-width": "140px" }
                                    },
                                    [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm.getDayOfWeekTh(
                                                productDaily71Date.daily_date
                                              )
                                            ) +
                                            " "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm.formatDateTh(
                                                productDaily71Date.daily_date
                                              )
                                            ) +
                                            " "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("div", { staticClass: "tw-text-xs" }, [
                                        _vm._v(
                                          " WH : \n                                        "
                                        ),
                                        !productDaily71Date.working_hour
                                          ? _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge badge-default"
                                              },
                                              [_vm._v(" - ")]
                                            )
                                          : _vm._e(),
                                        _vm._v(" "),
                                        parseFloat(
                                          productDaily71Date.working_hour
                                        ) < 10
                                          ? _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge badge-warning"
                                              },
                                              [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      productDaily71Date.working_hour
                                                    ) +
                                                    " "
                                                )
                                              ]
                                            )
                                          : _vm._e(),
                                        _vm._v(" "),
                                        parseFloat(
                                          productDaily71Date.working_hour
                                        ) >= 10
                                          ? _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge badge-danger"
                                              },
                                              [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      productDaily71Date.working_hour
                                                    ) +
                                                    " "
                                                )
                                              ]
                                            )
                                          : _vm._e()
                                      ])
                                    ]
                                  )
                                ]
                              })
                            ],
                            2
                          )
                        ]),
                        _vm._v(" "),
                        _vm.productMachine71GroupItems.length > 0
                          ? _c(
                              "tbody",
                              [
                                _vm._l(_vm.productMachine71GroupItems, function(
                                  productMachine71GroupItem,
                                  index
                                ) {
                                  return [
                                    _c(
                                      "tr",
                                      { key: "1_" + index },
                                      [
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "freeze-col text-center",
                                            staticStyle: {
                                              "min-width": "220px"
                                            },
                                            attrs: { rowspan: "2" }
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "freeze-col-content",
                                                staticStyle: { padding: "0px" }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "text-center tw-inline-block tw-align-top tw-py-5 tw-pr-2",
                                                    staticStyle: {
                                                      "min-width": "50px",
                                                      "max-width": "50px"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(index + 1) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "text-center tw-inline-block tw-align-top tw-py-5 tw-px-2",
                                                    staticStyle: {
                                                      "min-width": "140px",
                                                      "max-width": "140px",
                                                      "border-left":
                                                        "1px solid #ddd"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          productMachine71GroupItem.machine_group_desc
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _vm._l(
                                          _vm.productDaily71Dates,
                                          function(
                                            productDaily71Date,
                                            pddfIndex
                                          ) {
                                            return [
                                              _c(
                                                "td",
                                                {
                                                  key: "pddf_" + pddfIndex,
                                                  staticClass: "text-center",
                                                  staticStyle: {
                                                    "min-width": "140px",
                                                    "border-bottom-color":
                                                      "#f5f5f5"
                                                  }
                                                },
                                                [
                                                  _vm.product71PlanItems.find(
                                                    function(item) {
                                                      return (
                                                        item.daily_date ==
                                                          productDaily71Date.daily_date &&
                                                        item.machine_group ==
                                                          productMachine71GroupItem.machine_group
                                                      )
                                                    }
                                                  )
                                                    ? _c("div", [
                                                        _vm._v(
                                                          "\n                                            " +
                                                            _vm._s(
                                                              _vm.product71PlanItems.find(
                                                                function(item) {
                                                                  return (
                                                                    item.daily_date ==
                                                                      productDaily71Date.daily_date &&
                                                                    item.machine_group ==
                                                                      productMachine71GroupItem.machine_group
                                                                  )
                                                                }
                                                              ).item_description
                                                            ) +
                                                            "\n                                        "
                                                        )
                                                      ])
                                                    : _vm._e()
                                                ]
                                              )
                                            ]
                                          }
                                        )
                                      ],
                                      2
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "tr",
                                      { key: "2_" + index },
                                      [
                                        _vm._l(
                                          _vm.productDaily71Dates,
                                          function(
                                            productDaily71Date,
                                            pddsIndex
                                          ) {
                                            return [
                                              _c(
                                                "td",
                                                {
                                                  key: "pdds_" + pddsIndex,
                                                  staticClass: "text-center",
                                                  staticStyle: {
                                                    "border-top-color":
                                                      "#f5f5f5"
                                                  }
                                                },
                                                [
                                                  _vm.product71PlanItems.find(
                                                    function(item) {
                                                      return (
                                                        item.daily_date ==
                                                          productDaily71Date.daily_date &&
                                                        item.machine_group ==
                                                          productMachine71GroupItem.machine_group
                                                      )
                                                    }
                                                  )
                                                    ? _c("div", [
                                                        _vm._v(
                                                          "\n                                            " +
                                                            _vm._s(
                                                              Number(
                                                                _vm.product71PlanItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.daily_date ==
                                                                        productDaily71Date.daily_date &&
                                                                      item.machine_group ==
                                                                        productMachine71GroupItem.machine_group
                                                                    )
                                                                  }
                                                                )
                                                                  .date_efficiency_product
                                                              ).toLocaleString(
                                                                undefined,
                                                                {
                                                                  minimumFractionDigits: 3,
                                                                  maximumFractionDigits: 3
                                                                }
                                                              )
                                                            ) +
                                                            "\n                                        "
                                                        )
                                                      ])
                                                    : _c("div", [
                                                        _vm._v(" 0.000 ")
                                                      ])
                                                ]
                                              )
                                            ]
                                          }
                                        )
                                      ],
                                      2
                                    )
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
                                    {
                                      staticClass: "p-5 text-center text-muted"
                                    },
                                    [_vm._v(" ไม่พบข้อมูล ")]
                                  )
                                ])
                              ])
                            ])
                      ]
                    )
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.isProduct78Active
              ? _c(
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
                        staticStyle: { "min-width": "800px" }
                      },
                      [
                        _c("thead", [
                          _c(
                            "tr",
                            [
                              _c(
                                "th",
                                {
                                  staticClass: "text-center freeze-col",
                                  staticStyle: { "min-width": "220px" }
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
                                            "text-center tw-inline-block tw-align-top tw-py-5",
                                          staticStyle: {
                                            "min-width": "50px",
                                            "max-width": "50px"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        ลำดับ  \n                                    "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "text-center tw-inline-block tw-align-top tw-py-5",
                                          staticStyle: {
                                            "min-width": "140px",
                                            "max-width": "140px",
                                            "border-left": "1px solid #ddd"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        ขอบเขตเครื่องจักร\n                                    "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _vm._l(_vm.productDaily78Dates, function(
                                productDaily78Date,
                                pdhIndex
                              ) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      key: "pdh_" + pdhIndex,
                                      staticClass: "text-center",
                                      staticStyle: { "min-width": "140px" }
                                    },
                                    [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm.getDayOfWeekTh(
                                                productDaily78Date.daily_date
                                              )
                                            ) +
                                            " "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm.formatDateTh(
                                                productDaily78Date.daily_date
                                              )
                                            ) +
                                            " "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("div", { staticClass: "tw-text-xs" }, [
                                        _vm._v(
                                          " WH : \n                                        "
                                        ),
                                        !productDaily78Date.working_hour
                                          ? _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge badge-default"
                                              },
                                              [_vm._v(" - ")]
                                            )
                                          : _vm._e(),
                                        _vm._v(" "),
                                        parseFloat(
                                          productDaily78Date.working_hour
                                        ) < 10
                                          ? _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge badge-warning"
                                              },
                                              [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      productDaily78Date.working_hour
                                                    ) +
                                                    " "
                                                )
                                              ]
                                            )
                                          : _vm._e(),
                                        _vm._v(" "),
                                        parseFloat(
                                          productDaily78Date.working_hour
                                        ) >= 10
                                          ? _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "badge badge-danger"
                                              },
                                              [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      productDaily78Date.working_hour
                                                    ) +
                                                    " "
                                                )
                                              ]
                                            )
                                          : _vm._e()
                                      ])
                                    ]
                                  )
                                ]
                              })
                            ],
                            2
                          )
                        ]),
                        _vm._v(" "),
                        _vm.productMachine78GroupItems.length > 0
                          ? _c(
                              "tbody",
                              [
                                _vm._l(_vm.productMachine78GroupItems, function(
                                  productMachine78GroupItem,
                                  index
                                ) {
                                  return [
                                    _c(
                                      "tr",
                                      { key: "1_" + index },
                                      [
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "freeze-col text-center",
                                            staticStyle: {
                                              "min-width": "220px"
                                            },
                                            attrs: { rowspan: "2" }
                                          },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass:
                                                  "freeze-col-content",
                                                staticStyle: { padding: "0px" }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "text-center tw-inline-block tw-align-top tw-py-5 tw-pr-2",
                                                    staticStyle: {
                                                      "min-width": "50px",
                                                      "max-width": "50px"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(index + 1) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "text-center tw-inline-block tw-align-top tw-py-5 tw-px-2",
                                                    staticStyle: {
                                                      "min-width": "140px",
                                                      "max-width": "140px",
                                                      "border-left":
                                                        "1px solid #ddd"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            " +
                                                        _vm._s(
                                                          productMachine78GroupItem.machine_group_desc
                                                        ) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _vm._l(
                                          _vm.productDaily78Dates,
                                          function(
                                            productDaily78Date,
                                            pddfIndex
                                          ) {
                                            return [
                                              _c(
                                                "td",
                                                {
                                                  key: "pddf_" + pddfIndex,
                                                  staticClass: "text-center",
                                                  staticStyle: {
                                                    "min-width": "140px",
                                                    "border-bottom-color":
                                                      "#f5f5f5"
                                                  }
                                                },
                                                [
                                                  _vm.product78PlanItems.find(
                                                    function(item) {
                                                      return (
                                                        item.daily_date ==
                                                          productDaily78Date.daily_date &&
                                                        item.machine_group ==
                                                          productMachine78GroupItem.machine_group
                                                      )
                                                    }
                                                  )
                                                    ? _c("div", [
                                                        _vm._v(
                                                          "\n                                            " +
                                                            _vm._s(
                                                              _vm.product78PlanItems.find(
                                                                function(item) {
                                                                  return (
                                                                    item.daily_date ==
                                                                      productDaily78Date.daily_date &&
                                                                    item.machine_group ==
                                                                      productMachine78GroupItem.machine_group
                                                                  )
                                                                }
                                                              ).item_description
                                                            ) +
                                                            "\n                                        "
                                                        )
                                                      ])
                                                    : _vm._e()
                                                ]
                                              )
                                            ]
                                          }
                                        )
                                      ],
                                      2
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "tr",
                                      { key: "2_" + index },
                                      [
                                        _vm._l(
                                          _vm.productDaily78Dates,
                                          function(
                                            productDaily78Date,
                                            pddsIndex
                                          ) {
                                            return [
                                              _c(
                                                "td",
                                                {
                                                  key: "pdds_" + pddsIndex,
                                                  staticClass: "text-center",
                                                  staticStyle: {
                                                    "border-top-color":
                                                      "#f5f5f5"
                                                  }
                                                },
                                                [
                                                  _vm.product78PlanItems.find(
                                                    function(item) {
                                                      return (
                                                        item.daily_date ==
                                                          productDaily78Date.daily_date &&
                                                        item.machine_group ==
                                                          productMachine78GroupItem.machine_group
                                                      )
                                                    }
                                                  )
                                                    ? _c("div", [
                                                        _vm._v(
                                                          "\n                                            " +
                                                            _vm._s(
                                                              Number(
                                                                _vm.product78PlanItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.daily_date ==
                                                                        productDaily78Date.daily_date &&
                                                                      item.machine_group ==
                                                                        productMachine78GroupItem.machine_group
                                                                    )
                                                                  }
                                                                )
                                                                  .date_efficiency_product
                                                              ).toLocaleString(
                                                                undefined,
                                                                {
                                                                  minimumFractionDigits: 3,
                                                                  maximumFractionDigits: 3
                                                                }
                                                              )
                                                            ) +
                                                            "\n                                        "
                                                        )
                                                      ])
                                                    : _c("div", [
                                                        _vm._v(" 0.000 ")
                                                      ])
                                                ]
                                              )
                                            ]
                                          }
                                        )
                                      ],
                                      2
                                    )
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
                                    {
                                      staticClass: "p-5 text-center text-muted"
                                    },
                                    [_vm._v(" ไม่พบข้อมูล ")]
                                  )
                                ])
                              ])
                            ])
                      ]
                    )
                  ]
                )
              : _vm._e()
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/ModalSearchPlan.vue?vue&type=template&id=238308fc&scoped=true& ***!
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
            _c("h4", [_vm._v(" ค้นหาแผนผลิตสิ่งพิมพ์รายวัน ")]),
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
                [_vm._v(" สัปดาห์ ")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-8" },
                [
                  _c("pm-el-select", {
                    attrs: {
                      name: "weekly",
                      id: "input_weekly",
                      "select-options": _vm.weeklyOptions,
                      "option-key": "weekly_value",
                      "option-value": "weekly_value",
                      "option-label": "weekly_label",
                      value: _vm.weekly,
                      filterable: true
                    },
                    on: { onSelected: _vm.onWeekOfPlanChanged }
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
                      "select-options": _vm.dailyPlanVersionOptions,
                      "option-key": "version",
                      "option-value": "version",
                      "option-label": "version",
                      value: _vm.dailyPlanVersion,
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
                      !_vm.weekly ||
                      !_vm.dailyPlanVersion
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=template&id=1dfce91a&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/plans/daily/TablePlanLines.vue?vue&type=template&id=1dfce91a& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
        "div",
        {
          staticClass: "table-responsive",
          staticStyle: { "max-height": "720px" }
        },
        [
          _c(
            "table",
            {
              staticClass: "table table-bordered table-sticky mb-0",
              staticStyle: { "min-width": "4300px" }
            },
            [
              _c("thead", [
                _vm._m(0),
                _vm._v(" "),
                _c("tr", [
                  _vm._m(1),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Mon")) +
                          " "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Tue")) +
                          " "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Wed")) +
                          " "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Thu")) +
                          " "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Fri")) +
                          " "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Sat")) +
                          " "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-lg",
                      staticStyle: { top: "40px" }
                    },
                    [
                      _vm._v(
                        " " +
                          _vm._s(_vm.getDateByDay(_vm.weekDates, "Sun")) +
                          " "
                      )
                    ]
                  )
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                [
                  _vm._l(_vm.machineLineItems, function(machineItem, index) {
                    return [
                      _c(
                        "tr",
                        { key: "" + index, staticClass: "tw-text-xs" },
                        [
                          _c(
                            "td",
                            {
                              staticClass:
                                "freeze-col tw-text-xxl tw-font-bold",
                              staticStyle: {
                                "min-width": "200px",
                                "vertical-align": "top !important"
                              }
                            },
                            [
                              _vm.planHeaderData.status == "1"
                                ? _c(
                                    "div",
                                    { staticClass: "freeze-col-content" },
                                    [
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "pull-right tw-w-full tw-mb-10"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-sm btn-danger",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  return _vm.onDeleteMachineLine(
                                                    machineItem.machine_name
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-trash"
                                              }),
                                              _vm._v(
                                                " ลบเครื่อง \n                                    "
                                              )
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c("pm-el-select", {
                                        attrs: {
                                          name: "machine_name_" + index,
                                          id: "input_machine_name_" + index,
                                          "select-options": _vm.machineItems,
                                          "option-key": "machine_name",
                                          "option-value": "machine_name",
                                          "option-label": "machine_name",
                                          value: machineItem.machine_name,
                                          filterable: true
                                        },
                                        on: {
                                          onSelected: function($event) {
                                            return _vm.onMachineNameChanged(
                                              $event,
                                              machineItem
                                            )
                                          }
                                        }
                                      }),
                                      _vm._v(" "),
                                      machineItem.print_pdf
                                        ? _c(
                                            "a",
                                            {
                                              staticClass:
                                                "btn btn-block btn-sm btn-white mt-2",
                                              attrs: {
                                                href: machineItem.print_pdf,
                                                target: "_blank"
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fa fa-print tw-mr-1"
                                              }),
                                              _vm._v(
                                                " รายงานประจำเครื่อง\n                                "
                                              )
                                            ]
                                          )
                                        : _vm._e()
                                    ],
                                    1
                                  )
                                : _c(
                                    "div",
                                    { staticClass: "freeze-col-content" },
                                    [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(machineItem.machine_name) +
                                          "\n                                "
                                      ),
                                      machineItem.print_pdf
                                        ? _c(
                                            "a",
                                            {
                                              staticClass:
                                                "btn btn-block btn-sm btn-white mt-2",
                                              attrs: {
                                                href: machineItem.print_pdf,
                                                target: "_blank"
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fa fa-print tw-mr-1"
                                              }),
                                              _vm._v(
                                                " รายงานประจำเครื่อง\n                                "
                                              )
                                            ]
                                          )
                                        : _vm._e()
                                    ]
                                  )
                            ]
                          ),
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Mon")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_mon_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_mon_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.mon
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.mon
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.mon
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.mon.items, function(
                                      machineMonItem,
                                      monIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "mon_" +
                                              index +
                                              "_" +
                                              monIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_mon_" +
                                                              index +
                                                              "_" +
                                                              monIndex,
                                                            id:
                                                              "input_request_number_mon_" +
                                                              index +
                                                              "_" +
                                                              monIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineMonItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineMonItem,
                                                                "mon"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineMonItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineMonItem.colors
                                                    ? machineMonItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineMonItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineMonItem.product_colors
                                                    ? machineMonItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineMonItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_mon_" +
                                                              index +
                                                              "_" +
                                                              monIndex,
                                                            id:
                                                              "input_qty_mon_" +
                                                              index +
                                                              "_" +
                                                              monIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineMonItem,
                                                                "mon"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineMonItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineMonItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineMonItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineMonItem.qty
                                                              ? Number(
                                                                  machineMonItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineMonItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineMonItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.mon
                                                                .items,
                                                              machineMonItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "mon_" +
                                              index +
                                              "_" +
                                              monIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineMonItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "mon_" +
                                              index +
                                              "_" +
                                              monIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(2, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      monIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      monIndex,
                                                                    value:
                                                                      machineMonItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineMonItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineMonItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineMonItem.starttime
                                                                ? machineMonItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(3, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      monIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      monIndex,
                                                                    value:
                                                                      machineMonItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineMonItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineMonItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineMonItem.endtime
                                                                ? machineMonItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "mon_" +
                                              index +
                                              "_" +
                                              monIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(4, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineMonItem.remark,
                                                                expression:
                                                                  "machineMonItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_mon_" +
                                                                index +
                                                                "_" +
                                                                monIndex,
                                                              id:
                                                                "input_remark_mon_" +
                                                                index +
                                                                "_" +
                                                                monIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineMonItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineMonItem,
                                                                  "mon"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineMonItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineMonItem.remark
                                                                ? machineMonItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "mon",
                                                        machineItem.mon.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(5, true)],
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Tue")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_tue_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_tue_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.tue
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.tue
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.tue
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.tue.items, function(
                                      machineTueItem,
                                      tueIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "tue_" +
                                              index +
                                              "_" +
                                              tueIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_tue_" +
                                                              index +
                                                              "_" +
                                                              tueIndex,
                                                            id:
                                                              "input_request_number_tue_" +
                                                              index +
                                                              "_" +
                                                              tueIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineTueItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineTueItem,
                                                                "tue"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineTueItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineTueItem.colors
                                                    ? machineTueItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineTueItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineTueItem.product_colors
                                                    ? machineTueItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineTueItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_tue_" +
                                                              index +
                                                              "_" +
                                                              tueIndex,
                                                            id:
                                                              "input_qty_tue_" +
                                                              index +
                                                              "_" +
                                                              tueIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineTueItem,
                                                                "tue"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineTueItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineTueItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineTueItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineTueItem.qty
                                                              ? Number(
                                                                  machineTueItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineTueItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineTueItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.tue
                                                                .items,
                                                              machineTueItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "tue_" +
                                              index +
                                              "_" +
                                              tueIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineTueItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "tue_" +
                                              index +
                                              "_" +
                                              tueIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(6, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      tueIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      tueIndex,
                                                                    value:
                                                                      machineTueItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineTueItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineTueItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineTueItem.starttime
                                                                ? machineTueItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(7, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      tueIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      tueIndex,
                                                                    value:
                                                                      machineTueItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineTueItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineTueItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineTueItem.endtime
                                                                ? machineTueItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "tue_" +
                                              index +
                                              "_" +
                                              tueIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(8, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineTueItem.remark,
                                                                expression:
                                                                  "machineTueItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_tue_" +
                                                                index +
                                                                "_" +
                                                                tueIndex,
                                                              id:
                                                                "input_remark_tue_" +
                                                                index +
                                                                "_" +
                                                                tueIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineTueItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineTueItem,
                                                                  "tue"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineTueItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineTueItem.remark
                                                                ? machineTueItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "tue",
                                                        machineItem.tue.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(9, true)],
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Wed")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_wed_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_wed_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.wed
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.wed
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.wed
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.wed.items, function(
                                      machineWedItem,
                                      wedIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "wed_" +
                                              index +
                                              "_" +
                                              wedIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_wed_" +
                                                              index +
                                                              "_" +
                                                              wedIndex,
                                                            id:
                                                              "input_request_number_wed_" +
                                                              index +
                                                              "_" +
                                                              wedIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineWedItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineWedItem,
                                                                "wed"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineWedItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineWedItem.colors
                                                    ? machineWedItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineWedItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineWedItem.product_colors
                                                    ? machineWedItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineWedItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_wed_" +
                                                              index +
                                                              "_" +
                                                              wedIndex,
                                                            id:
                                                              "input_qty_wed_" +
                                                              index +
                                                              "_" +
                                                              wedIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineWedItem,
                                                                "wed"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineWedItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineWedItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineWedItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineWedItem.qty
                                                              ? Number(
                                                                  machineWedItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineWedItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineWedItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.wed
                                                                .items,
                                                              machineWedItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "wed_" +
                                              index +
                                              "_" +
                                              wedIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineWedItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "wed_" +
                                              index +
                                              "_" +
                                              wedIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(10, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      wedIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      wedIndex,
                                                                    value:
                                                                      machineWedItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineWedItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineWedItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineWedItem.starttime
                                                                ? machineWedItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(11, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      wedIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      wedIndex,
                                                                    value:
                                                                      machineWedItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineWedItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineWedItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineWedItem.endtime
                                                                ? machineWedItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "wed_" +
                                              index +
                                              "_" +
                                              wedIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(12, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineWedItem.remark,
                                                                expression:
                                                                  "machineWedItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_wed_" +
                                                                index +
                                                                "_" +
                                                                wedIndex,
                                                              id:
                                                                "input_remark_wed_" +
                                                                index +
                                                                "_" +
                                                                wedIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineWedItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineWedItem,
                                                                  "wed"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineWedItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineWedItem.remark
                                                                ? machineWedItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "wed",
                                                        machineItem.wed.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(13, true)],
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Thu")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_thu_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_thu_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.thu
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.thu
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.thu
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.thu.items, function(
                                      machineThuItem,
                                      thuIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "thu_" +
                                              index +
                                              "_" +
                                              thuIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_thu_" +
                                                              index +
                                                              "_" +
                                                              thuIndex,
                                                            id:
                                                              "input_request_number_thu_" +
                                                              index +
                                                              "_" +
                                                              thuIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineThuItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineThuItem,
                                                                "thu"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineThuItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineThuItem.colors
                                                    ? machineThuItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineThuItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineThuItem.product_colors
                                                    ? machineThuItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineThuItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_thu_" +
                                                              index +
                                                              "_" +
                                                              thuIndex,
                                                            id:
                                                              "input_qty_thu_" +
                                                              index +
                                                              "_" +
                                                              thuIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineThuItem,
                                                                "thu"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineThuItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineThuItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineThuItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineThuItem.qty
                                                              ? Number(
                                                                  machineThuItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineThuItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineThuItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.thu
                                                                .items,
                                                              machineThuItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "thu_" +
                                              index +
                                              "_" +
                                              thuIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineThuItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "thu_" +
                                              index +
                                              "_" +
                                              thuIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(14, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      thuIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      thuIndex,
                                                                    value:
                                                                      machineThuItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineThuItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineThuItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineThuItem.starttime
                                                                ? machineThuItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(15, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      thuIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      thuIndex,
                                                                    value:
                                                                      machineThuItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineThuItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineThuItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineThuItem.endtime
                                                                ? machineThuItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "thu_" +
                                              index +
                                              "_" +
                                              thuIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(16, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineThuItem.remark,
                                                                expression:
                                                                  "machineThuItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_thu_" +
                                                                index +
                                                                "_" +
                                                                thuIndex,
                                                              id:
                                                                "input_remark_thu_" +
                                                                index +
                                                                "_" +
                                                                thuIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineThuItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineThuItem,
                                                                  "thu"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineThuItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineThuItem.remark
                                                                ? machineThuItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "thu",
                                                        machineItem.thu.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(17, true)],
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Fri")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_fri_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_fri_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.fri
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.fri
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.fri
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.fri.items, function(
                                      machineFriItem,
                                      friIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "fri_" +
                                              index +
                                              "_" +
                                              friIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_fri_" +
                                                              index +
                                                              "_" +
                                                              friIndex,
                                                            id:
                                                              "input_request_number_fri_" +
                                                              index +
                                                              "_" +
                                                              friIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineFriItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineFriItem,
                                                                "fri"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineFriItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineFriItem.colors
                                                    ? machineFriItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineFriItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineFriItem.product_colors
                                                    ? machineFriItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineFriItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_fri_" +
                                                              index +
                                                              "_" +
                                                              friIndex,
                                                            id:
                                                              "input_qty_fri_" +
                                                              index +
                                                              "_" +
                                                              friIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineFriItem,
                                                                "fri"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineFriItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineFriItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineFriItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineFriItem.qty
                                                              ? Number(
                                                                  machineFriItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineFriItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineFriItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.fri
                                                                .items,
                                                              machineFriItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "fri_" +
                                              index +
                                              "_" +
                                              friIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineFriItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "fri_" +
                                              index +
                                              "_" +
                                              friIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(18, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      friIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      friIndex,
                                                                    value:
                                                                      machineFriItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineFriItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineFriItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineFriItem.starttime
                                                                ? machineFriItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(19, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      friIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      friIndex,
                                                                    value:
                                                                      machineFriItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineFriItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineFriItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineFriItem.endtime
                                                                ? machineFriItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "fri_" +
                                              index +
                                              "_" +
                                              friIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(20, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineFriItem.remark,
                                                                expression:
                                                                  "machineFriItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_fri_" +
                                                                index +
                                                                "_" +
                                                                friIndex,
                                                              id:
                                                                "input_remark_fri_" +
                                                                index +
                                                                "_" +
                                                                friIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineFriItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineFriItem,
                                                                  "fri"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineFriItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineFriItem.remark
                                                                ? machineFriItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "fri",
                                                        machineItem.fri.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(21, true)],
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Sat")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_sat_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_sat_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.sat
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.sat
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.sat
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.sat.items, function(
                                      machineSatItem,
                                      satIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sat_" +
                                              index +
                                              "_" +
                                              satIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_sat_" +
                                                              index +
                                                              "_" +
                                                              satIndex,
                                                            id:
                                                              "input_request_number_sat_" +
                                                              index +
                                                              "_" +
                                                              satIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineSatItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineSatItem,
                                                                "sat"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineSatItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineSatItem.colors
                                                    ? machineSatItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineSatItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineSatItem.product_colors
                                                    ? machineSatItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineSatItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_sat_" +
                                                              index +
                                                              "_" +
                                                              satIndex,
                                                            id:
                                                              "input_qty_sat_" +
                                                              index +
                                                              "_" +
                                                              satIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineSatItem,
                                                                "sat"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineSatItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineSatItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineSatItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineSatItem.qty
                                                              ? Number(
                                                                  machineSatItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineSatItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineSatItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.sat
                                                                .items,
                                                              machineSatItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sat_" +
                                              index +
                                              "_" +
                                              satIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineSatItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sat_" +
                                              index +
                                              "_" +
                                              satIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(22, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      satIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      satIndex,
                                                                    value:
                                                                      machineSatItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineSatItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineSatItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineSatItem.starttime
                                                                ? machineSatItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(23, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      satIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      satIndex,
                                                                    value:
                                                                      machineSatItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineSatItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineSatItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineSatItem.endtime
                                                                ? machineSatItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sat_" +
                                              index +
                                              "_" +
                                              satIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(24, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineSatItem.remark,
                                                                expression:
                                                                  "machineSatItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_sat_" +
                                                                index +
                                                                "_" +
                                                                satIndex,
                                                              id:
                                                                "input_remark_sat_" +
                                                                index +
                                                                "_" +
                                                                satIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineSatItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineSatItem,
                                                                  "sat"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineSatItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineSatItem.remark
                                                                ? machineSatItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "sat",
                                                        machineItem.sat.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(25, true)],
                          _vm._v(" "),
                          _vm.isDayEnabled(_vm.weekDates, "Sun")
                            ? [
                                _c(
                                  "td",
                                  {
                                    staticStyle: {
                                      "min-width": "700px",
                                      "vertical-align": "top !important"
                                    }
                                  },
                                  [
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          attrs: { colspan: "7" }
                                        },
                                        [
                                          _vm.planHeaderData.status == "1"
                                            ? _c(
                                                "div",
                                                [
                                                  _c("pm-el-select", {
                                                    attrs: {
                                                      name:
                                                        "plan_time_sun_" +
                                                        index,
                                                      id:
                                                        "input_plan_time_sun_" +
                                                        index,
                                                      "select-options":
                                                        _vm.machineTimes,
                                                      "option-key":
                                                        "lookup_code",
                                                      "option-value":
                                                        "lookup_code",
                                                      "option-label":
                                                        "description",
                                                      value:
                                                        machineItem.sun
                                                          .plan_time,
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onMachinePlanTimeChanged(
                                                          $event,
                                                          machineItem.sun
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            : _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm.getMachinePlanTimeDesc(
                                                        _vm.machineTimes,
                                                        machineItem.sun
                                                          .plan_time
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                        ]
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "280px" }
                                        },
                                        [_vm._v(" Item ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Brand ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "50px" }
                                        },
                                        [_vm._v(" Product ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Quantity ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "60px" }
                                        },
                                        [_vm._v(" UOM ")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass: "text-center",
                                          staticStyle: { "min-width": "100px" }
                                        },
                                        [_vm._v(" Job Number")]
                                      ),
                                      _vm._v(" "),
                                      _vm.planHeaderData.status == "1"
                                        ? _c(
                                            "td",
                                            {
                                              staticClass: "text-center",
                                              staticStyle: {
                                                "min-width": "60px"
                                              }
                                            },
                                            [_vm._v(" Delete ")]
                                          )
                                        : _vm._e()
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(machineItem.sun.items, function(
                                      machineSunItem,
                                      sunIndex
                                    ) {
                                      return [
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sun_" +
                                              index +
                                              "_" +
                                              sunIndex +
                                              "_1"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c(
                                                      "div",
                                                      [
                                                        _c("pm-el-select", {
                                                          attrs: {
                                                            name:
                                                              "request_number_sun_" +
                                                              index +
                                                              "_" +
                                                              sunIndex,
                                                            id:
                                                              "input_request_number_sun_" +
                                                              index +
                                                              "_" +
                                                              sunIndex,
                                                            "select-options":
                                                              _vm.remainingItems,
                                                            "option-key":
                                                              "request_number",
                                                            "option-value":
                                                              "request_number",
                                                            "option-label":
                                                              "full_item_desc",
                                                            value:
                                                              machineSunItem.request_number,
                                                            filterable: true
                                                          },
                                                          on: {
                                                            onSelected: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemChanged(
                                                                $event,
                                                                machineItem,
                                                                machineSunItem,
                                                                "sun"
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineSunItem.inv_item_number
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineSunItem.colors
                                                    ? machineSunItem.colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineSunItem.brand
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-center",
                                                style: {
                                                  backgroundColor: machineSunItem.product_colors
                                                    ? machineSunItem.product_colors
                                                    : "#FFF"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "tw-font-bold"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          machineSunItem.product
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
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
                                                            name:
                                                              "qty_sun_" +
                                                              index +
                                                              "_" +
                                                              sunIndex,
                                                            id:
                                                              "input_qty_sun_" +
                                                              index +
                                                              "_" +
                                                              sunIndex,
                                                            disabled:
                                                              _vm.isLoading
                                                          },
                                                          on: {
                                                            blur: function(
                                                              $event
                                                            ) {
                                                              return _vm.onMachineItemQtyChanged(
                                                                machineItem,
                                                                machineSunItem,
                                                                "sun"
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              machineSunItem.qty,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                machineSunItem,
                                                                "qty",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "machineSunItem.qty"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  : _c("div", [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            machineSunItem.qty
                                                              ? Number(
                                                                  machineSunItem.qty
                                                                ).toLocaleString(
                                                                  undefined,
                                                                  {
                                                                    minimumFractionDigits: 2,
                                                                    maximumFractionDigits: 4
                                                                  }
                                                                )
                                                              : ""
                                                          ) +
                                                          " "
                                                      )
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        _vm.getUomCodeDescription(
                                                          _vm.uomCodes,
                                                          machineSunItem.uom
                                                        )
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineSunItem.request_number
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm.planHeaderData.status == "1"
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c(
                                                      "button",
                                                      {
                                                        staticClass:
                                                          "btn btn-sm btn-danger",
                                                        attrs: {
                                                          type: "button"
                                                        },
                                                        on: {
                                                          click: function(
                                                            $event
                                                          ) {
                                                            return _vm.onDeleteLine(
                                                              machineItem.sun
                                                                .items,
                                                              machineSunItem
                                                            )
                                                          }
                                                        }
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fa fa-trash"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                )
                                              : _vm._e()
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sun_" +
                                              index +
                                              "_" +
                                              sunIndex +
                                              "_2"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        machineSunItem.inv_item_desc
                                                      ) +
                                                      " "
                                                  )
                                                ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sun_" +
                                              index +
                                              "_" +
                                              sunIndex +
                                              "_3"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "2" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(26, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      sunIndex,
                                                                    id:
                                                                      "input_starttime_" +
                                                                      index +
                                                                      "_" +
                                                                      sunIndex,
                                                                    value:
                                                                      machineSunItem.starttime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeClosed(
                                                                        $event,
                                                                        machineSunItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemStartTimeChanged(
                                                                        $event,
                                                                        machineSunItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาเริ่ม : " +
                                                            _vm._s(
                                                              machineSunItem.starttime
                                                                ? machineSunItem.starttime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left tw-p-2",
                                                staticStyle: {
                                                  "padding-top": "5px",
                                                  "padding-bottom": "5px"
                                                },
                                                attrs: { colspan: "5" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(27, true),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "tw-pt-1"
                                                            },
                                                            [
                                                              _c(
                                                                "pm-timepicker",
                                                                {
                                                                  attrs: {
                                                                    name:
                                                                      "endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      sunIndex,
                                                                    id:
                                                                      "input_endtime_" +
                                                                      index +
                                                                      "_" +
                                                                      sunIndex,
                                                                    value:
                                                                      machineSunItem.endtime
                                                                  },
                                                                  on: {
                                                                    close: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeClosed(
                                                                        $event,
                                                                        machineSunItem
                                                                      )
                                                                    },
                                                                    change: function(
                                                                      $event
                                                                    ) {
                                                                      return _vm.onMachineItemEndTimeChanged(
                                                                        $event,
                                                                        machineSunItem
                                                                      )
                                                                    }
                                                                  }
                                                                }
                                                              )
                                                            ],
                                                            1
                                                          )
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " เวลาสิ้นสุด : " +
                                                            _vm._s(
                                                              machineSunItem.endtime
                                                                ? machineSunItem.endtime
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            key:
                                              "sun_" +
                                              index +
                                              "_" +
                                              sunIndex +
                                              "_4"
                                          },
                                          [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-left",
                                                attrs: { colspan: "7" }
                                              },
                                              [
                                                _vm.planHeaderData.status == "1"
                                                  ? _c("div", [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "input-group"
                                                        },
                                                        [
                                                          _vm._m(28, true),
                                                          _vm._v(" "),
                                                          _c("input", {
                                                            directives: [
                                                              {
                                                                name: "model",
                                                                rawName:
                                                                  "v-model",
                                                                value:
                                                                  machineSunItem.remark,
                                                                expression:
                                                                  "machineSunItem.remark"
                                                              }
                                                            ],
                                                            staticClass:
                                                              "form-control input-sm",
                                                            attrs: {
                                                              type: "text",
                                                              name:
                                                                "remark_sun_" +
                                                                index +
                                                                "_" +
                                                                sunIndex,
                                                              id:
                                                                "input_remark_sun_" +
                                                                index +
                                                                "_" +
                                                                sunIndex,
                                                              disabled:
                                                                _vm.isLoading
                                                            },
                                                            domProps: {
                                                              value:
                                                                machineSunItem.remark
                                                            },
                                                            on: {
                                                              blur: function(
                                                                $event
                                                              ) {
                                                                return _vm.onMachineItemRemarkChanged(
                                                                  machineItem,
                                                                  machineSunItem,
                                                                  "sun"
                                                                )
                                                              },
                                                              input: function(
                                                                $event
                                                              ) {
                                                                if (
                                                                  $event.target
                                                                    .composing
                                                                ) {
                                                                  return
                                                                }
                                                                _vm.$set(
                                                                  machineSunItem,
                                                                  "remark",
                                                                  $event.target
                                                                    .value
                                                                )
                                                              }
                                                            }
                                                          })
                                                        ]
                                                      )
                                                    ])
                                                  : _c("div", [
                                                      _c("div", [
                                                        _vm._v(
                                                          " หมายเหตุ : " +
                                                            _vm._s(
                                                              machineSunItem.remark
                                                                ? machineSunItem.remark
                                                                : "-"
                                                            ) +
                                                            " "
                                                        )
                                                      ])
                                                    ])
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm.planHeaderData.status == "1"
                                      ? _c("tr", [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-left",
                                              attrs: { colspan: "7" }
                                            },
                                            [
                                              _c(
                                                "button",
                                                {
                                                  staticClass:
                                                    "btn btn-inline-block btn-xs btn-success tw-w-16",
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.onAddNewLine(
                                                        index,
                                                        "sun",
                                                        machineItem.sun.items
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fa fa-plus tw-mr-1"
                                                  }),
                                                  _vm._v(
                                                    " เพิ่ม\n                                        "
                                                  )
                                                ]
                                              )
                                            ]
                                          )
                                        ])
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                            : [_vm._m(29, true)]
                        ],
                        2
                      )
                    ]
                  })
                ],
                2
              )
            ]
          )
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
    return _c("tr", [
      _c(
        "th",
        {
          staticClass: "text-center freeze-col",
          staticStyle: { "min-width": "200px" }
        },
        [
          _c(
            "div",
            {
              staticClass: "freeze-col-content",
              staticStyle: { padding: "0px" }
            },
            [_vm._v("   ")]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" จันทร์ ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" อังคาร ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" พุธ ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" พฤหัส ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" ศุกร์ ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" เสาร์ ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "text-center tw-text-lg",
          staticStyle: { "min-width": "700px" }
        },
        [_vm._v(" อาทิตย์ ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center freeze-col", staticStyle: { top: "40px" } },
      [
        _c(
          "div",
          {
            staticClass: "freeze-col-content",
            staticStyle: { padding: "0px" }
          },
          [_vm._v("   ")]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาเริ่ม : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" เวลาสิ้นสุด : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        {
          staticClass: "input-group-addon input-sm tw-border-white",
          staticStyle: { "min-width": "90px" }
        },
        [_vm._v(" หมายเหตุ : ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-center",
        staticStyle: {
          "min-width": "700px",
          "vertical-align": "top !important"
        }
      },
      [_c("div")]
    )
  }
]
render._withStripped = true



/***/ })

}]);