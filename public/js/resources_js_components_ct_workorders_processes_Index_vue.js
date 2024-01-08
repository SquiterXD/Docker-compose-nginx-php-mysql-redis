(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_workorders_processes_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/Index.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/Index.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableWorkorderProcesses__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableWorkorderProcesses */ "./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue");


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TableWorkorderProcesses: _TableWorkorderProcesses__WEBPACK_IMPORTED_MODULE_4__.default
  },
  props: ["defaultData", "paramIdValue", "processStepValue", "periodYearValue", "periodNameValue", "processStatusValue", "postingStatusValue", "costCodeValue", "deptCodeFromValue", "deptCodeToValue", "batchNoFromValue", "batchNoToValue", "processSteps", "periodYears", "processStatuses", "postingStatuses", "costCenters", "uomCodes"],
  mounted: function mounted() {
    var _this = this;

    if (this.periodYearValue) {
      // GET PERIOD NUMBERS
      this.getListPeriodNumbers(this.periodYearValue).then(function (value) {
        if (_this.periodNameValue) {
          _this.paramHeader.period_number = _this.getPeriodNumber(_this.periodNumbers, _this.periodNameValue);
          _this.paramHeader.start_date = _this.getPeriodStartDate(_this.periodNumbers, _this.periodNameValue, "EN");
          _this.paramHeader.end_date = _this.getPeriodEndDate(_this.periodNumbers, _this.periodNameValue, "EN");
          _this.paramHeader.start_date_thai = _this.getPeriodStartDate(_this.periodNumbers, _this.periodNameValue, "TH");
          _this.paramHeader.end_date_thai = _this.getPeriodEndDate(_this.periodNumbers, _this.periodNameValue, "TH");
        }
      });
    }

    if (this.paramIdValue) {
      this.onGetWorkorderProcesss(this.paramIdValue);
    }

    if (this.costCodeValue) {
      this.getListCostDepartment(this.costCodeValue);
      this.getBatchNumbers(this.costCodeValue);
    }
  },
  data: function data() {
    return {
      organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
      organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
      department: this.defaultData ? JSON.parse(this.defaultData).department : null,
      paramId: this.paramIdValue,
      paramHeader: {
        period_year: this.periodYearValue,
        period_year_label: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
        period_name: this.periodNameValue,
        period_number: '',
        start_date: '',
        end_date: '',
        start_date_thai: '',
        end_date_thai: '',
        cost_code: this.costCodeValue,
        dept_code_from: this.deptCodeFromValue,
        dept_code_to: this.deptCodeToValue,
        batch_no_from: this.batchNoFromValue,
        batch_no_to: this.batchNoToValue,
        process_status: this.processStatusValue,
        posting_status: this.postingStatusValue
      },
      batchNumbers: [],
      periodNumbers: [],
      ccDepartments: [],
      workorderProcesses: [],
      workorderImportFileList: [],
      isVerified: false,
      isLoading: false
    };
  },
  computed: {},
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("param_id", this.paramId);
      queryParams.set("period_year", this.paramHeader.period_year);
      queryParams.set("period_name", this.paramHeader.period_name);
      queryParams.set("process_status", this.paramHeader.process_status);
      queryParams.set("posting_status", this.paramHeader.posting_status);
      queryParams.set("cost_code", this.paramHeader.cost_code);
      queryParams.set("dept_code_from", this.paramHeader.dept_code_from);
      queryParams.set("dept_code_to", this.paramHeader.dept_code_to);
      queryParams.set("batch_no_from", this.paramHeader.batch_no_from);
      queryParams.set("batch_no_to", this.paramHeader.batch_no_to);
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    getListPeriodNumbers: function getListPeriodNumbers(periodYear) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                // show loading
                _this2.isLoading = true; // REFRESH DATA

                _this2.periodNumbers = [];
                params = {
                  period_year: periodYear
                };
                _context.next = 5;
                return axios.get("/ajax/ct/workorders/processes/get-period-numbers", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.period_numbers ? JSON.parse(resData.period_numbers) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E35 ".concat(_this2.paramHeader.period_year_label, " \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ").concat(error.message), "error");
                  return;
                });

              case 5:
                _this2.periodNumbers = _context.sent;
                // hide loading
                _this2.isLoading = false;

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getListCostDepartment: function getListCostDepartment(costCode) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // show loading
                _this3.isLoading = true;
                params = {
                  cost_code: costCode
                };
                _context2.next = 4;
                return axios.get("/ajax/ct/workorders/processes/get-cost-departments", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.departments ? JSON.parse(resData.departments) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E2B\u0E19\u0E48\u0E27\u0E22\u0E07\u0E32\u0E19 \u0E08\u0E32\u0E01\u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19 ".concat(costCode, " | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this3.ccDepartments = _context2.sent;
                // hide loading
                _this3.isLoading = false;

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getBatchNumbers: function getBatchNumbers(costCode) {
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
                  cost_code: costCode
                };
                _context3.next = 4;
                return axios.get("/ajax/ct/workorders/processes/get-batch-numbers", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  return resData.batch_numbers ? JSON.parse(resData.batch_numbers) : [];
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15 \u0E08\u0E32\u0E01\u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19 ".concat(costCode, " | ").concat(error.message), "error");
                  return;
                });

              case 4:
                _this4.batchNumbers = _context3.sent;
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
    onPeriodYearChanged: function onPeriodYearChanged(value) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this5.paramHeader.period_year = value;
                _this5.paramHeader.period_year_label = _this5.getPeriodYearLabel(_this5.periodYears, value);
                _this5.paramHeader.period_name = '';
                _this5.paramHeader.period_number = '';
                _this5.paramHeader.start_date = '';
                _this5.paramHeader.end_date = '';
                _this5.paramHeader.start_date_thai = '';
                _this5.paramHeader.end_date_thai = '';

                _this5.getListPeriodNumbers(_this5.paramHeader.period_year);

                _this5.setUrlParams();

              case 10:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onCostCenterCodeChanged: function onCostCenterCodeChanged(value) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this6.paramHeader.cost_code = value;

                _this6.getBatchNumbers(_this6.paramHeader.cost_code);

                _this6.getBatchNumbers(_this6.paramHeader.cost_code);

                _this6.setUrlParams();

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    onPeriodNumberChanged: function onPeriodNumberChanged(value) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _this7.paramHeader.period_name = value;
                _this7.paramHeader.period_number = _this7.getPeriodNumber(_this7.periodNumbers, value);
                _this7.paramHeader.start_date = _this7.getPeriodStartDate(_this7.periodNumbers, value, "EN");
                _this7.paramHeader.end_date = _this7.getPeriodEndDate(_this7.periodNumbers, value, "EN");
                _this7.paramHeader.start_date_thai = _this7.getPeriodStartDate(_this7.periodNumbers, value, "TH");
                _this7.paramHeader.end_date_thai = _this7.getPeriodEndDate(_this7.periodNumbers, value, "TH");

                _this7.setUrlParams();

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onDeptCodeFromChanged: function onDeptCodeFromChanged(value) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _this8.paramHeader.dept_code_from = value;

                _this8.setUrlParams();

              case 2:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onDeptCodeToChanged: function onDeptCodeToChanged(value) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _this9.paramHeader.dept_code_to = value;

                _this9.setUrlParams();

              case 2:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    onBatchNoFromChanged: function onBatchNoFromChanged(value) {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _this10.paramHeader.batch_no_from = value;

                _this10.setUrlParams();

              case 2:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    onBatchNoToChanged: function onBatchNoToChanged(value) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                _this11.paramHeader.batch_no_to = value;

                _this11.setUrlParams();

              case 2:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    onProcessStatusChanged: function onProcessStatusChanged(value) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                _this12.paramHeader.process_status = value;

                _this12.setUrlParams();

              case 2:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    onPostingStatusChanged: function onPostingStatusChanged(value) {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                _this13.paramHeader.posting_status = value;

                _this13.setUrlParams();

              case 2:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    getProcessStepLabel: function getProcessStepLabel(processSteps, stepCode) {
      var foundStep = processSteps.find(function (item) {
        return item.step_code == stepCode;
      });
      return foundStep ? foundStep.description : "";
    },
    getPeriodYearLabel: function getPeriodYearLabel(periodYears, periodYear) {
      var foundPeriodYear = periodYears.find(function (item) {
        return item.period_year_value == periodYear;
      });
      return foundPeriodYear ? foundPeriodYear.period_year_label : "";
    },
    getPeriodNumber: function getPeriodNumber(periodNumbers, periodName) {
      var foundPeriodNumber = periodNumbers.find(function (item) {
        return item.period_number_value == periodName;
      });
      return foundPeriodNumber ? foundPeriodNumber.period_number_label : "";
    },
    getPeriodStartDate: function getPeriodStartDate(periodNumbers, periodName, dateType) {
      var result = null;
      var foundPeriodNumber = periodNumbers.find(function (item) {
        return item.period_number_value == periodName;
      });
      result = foundPeriodNumber ? foundPeriodNumber.start_date : "";

      if (dateType == "TH") {
        result = foundPeriodNumber ? foundPeriodNumber.start_date_thai : "";
      }

      return result;
    },
    getPeriodEndDate: function getPeriodEndDate(periodNumbers, periodName, dateType) {
      var result = null;
      var foundPeriodNumber = periodNumbers.find(function (item) {
        return item.period_number_value == periodName;
      });
      result = foundPeriodNumber ? foundPeriodNumber.end_date : "";

      if (dateType == "TH") {
        result = foundPeriodNumber ? foundPeriodNumber.end_date_thai : "";
      }

      return result;
    },
    getProcessStatusDesc: function getProcessStatusDesc(status) {
      var statusDesc = "-";

      if (status) {
        var foundStatus = this.processStatuses.find(function (item) {
          return item.process_status == status;
        });
        statusDesc = foundStatus ? foundStatus.description : "-";
      }

      return statusDesc;
    },
    getPostingStatusDesc: function getPostingStatusDesc(status) {
      var statusDesc = "-";

      if (status) {
        var foundStatus = this.postingStatuses.find(function (item) {
          return item.posting_status == status;
        });
        statusDesc = foundStatus ? foundStatus.description : "-";
      }

      return statusDesc;
    },
    onClearParamHeader: function onClearParamHeader() {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                _this14.paramHeader.period_year = '';
                _this14.paramHeader.period_year_label = '';
                _this14.paramHeader.period_name = '';
                _this14.paramHeader.period_number = '';
                _this14.paramHeader.start_date = '';
                _this14.paramHeader.end_date = '';
                _this14.paramHeader.start_date_thai = '';
                _this14.paramHeader.end_date_thai = '';
                _this14.paramHeader.cost_code = '';
                _this14.paramHeader.dept_code_from = '';
                _this14.paramHeader.dept_code_to = '';
                _this14.paramHeader.batch_no_from = '';
                _this14.paramHeader.batch_no_to = '';
                _this14.paramHeader.process_status = '';
                _this14.paramHeader.posting_status = '';
                _this14.periodNumbers = [];
                _this14.ccDepartments = [];

                _this14.setUrlParams();

              case 18:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    onQueryWorkorderProcesss: function onQueryWorkorderProcesss() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                _context14.next = 2;
                return _this15.queryWorkorderProcess(true);

              case 2:
                _this15.setUrlParams();

              case 3:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    queryWorkorderProcess: function queryWorkorderProcess(showAlert) {
      var _this16 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var resValidate, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                // SHOW LOADING
                _this16.isLoading = true;
                resValidate = _this16.validateBeforeQuery(_this16.paramHeader);

                if (!resValidate.valid) {
                  _context15.next = 8;
                  break;
                }

                // GENERATE TRANSACTIONS
                reqBody = {
                  process_step: "SELECT",
                  period_year: _this16.paramHeader.period_year,
                  period_year_label: _this16.paramHeader.period_year_label,
                  period_name: _this16.paramHeader.period_name,
                  period_number: _this16.paramHeader.period_number,
                  start_date: _this16.paramHeader.start_date,
                  end_date: _this16.paramHeader.end_date,
                  start_date_thai: _this16.paramHeader.start_date_thai,
                  end_date_thai: _this16.paramHeader.end_date_thai,
                  cost_code: _this16.paramHeader.cost_code,
                  dept_code_from: _this16.paramHeader.dept_code_from,
                  dept_code_to: _this16.paramHeader.dept_code_to,
                  batch_no_from: _this16.paramHeader.batch_no_from,
                  batch_no_to: _this16.paramHeader.batch_no_to,
                  process_status: _this16.paramHeader.process_status,
                  posting_status: _this16.paramHeader.posting_status
                };
                _context15.next = 6;
                return axios.post("/ajax/ct/workorders/processes/query-trans", reqBody).then(function (res) {
                  var resData = res.data.data; // if(resData.status == "success") {

                  _this16.paramId = resData.param_id ? resData.param_id : null;

                  if (_this16.paramId) {
                    // GET WORKER PROESS
                    _this16.onGetWorkorderProcesss(_this16.paramId);

                    if (showAlert) {
                      swal("Success", "\u0E41\u0E2A\u0E14\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15", "success");
                    }
                  } else {// swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูลคำสั่งผลิต | ${resData.message}`, "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E41\u0E2A\u0E14\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15  | ".concat(error.message), "error");
                });

              case 6:
                _context15.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E41\u0E2A\u0E14\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(resValidate.message), "error");

              case 9:
                // HIDE LOADING
                _this16.isLoading = false;

              case 10:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    onProcessWorkorderProcesss: function onProcessWorkorderProcesss(e, processStep) {
      var _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
        var processStepLabel, resValidate, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                // show loading
                _this17.isLoading = true;
                processStepLabel = processStep == "FINAL" ? "ส่งข้อมูลเข้า GL" : "ยกเลิกข้อมูลเข้า GL";
                resValidate = _this17.validateBeforeProcess(_this17.paramHeader);

                if (!resValidate.valid) {
                  _context16.next = 9;
                  break;
                }

                // GENERATE TRANSACTIONS
                reqBody = {
                  process_step: processStep,
                  period_year: _this17.paramHeader.period_year,
                  period_year_label: _this17.paramHeader.period_year_label,
                  period_name: _this17.paramHeader.period_name,
                  period_number: _this17.paramHeader.period_number,
                  start_date: _this17.paramHeader.start_date,
                  end_date: _this17.paramHeader.end_date,
                  start_date_thai: _this17.paramHeader.start_date_thai,
                  end_date_thai: _this17.paramHeader.end_date_thai,
                  cost_code: _this17.paramHeader.cost_code,
                  dept_code_from: _this17.paramHeader.dept_code_from,
                  dept_code_to: _this17.paramHeader.dept_code_to,
                  batch_no_from: _this17.paramHeader.batch_no_from,
                  batch_no_to: _this17.paramHeader.batch_no_to,
                  process_status: _this17.paramHeader.process_status,
                  posting_status: _this17.paramHeader.posting_status
                };
                _context16.next = 7;
                return axios.post("/ajax/ct/workorders/processes/process-trans", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this17.paramId = resData.param_id ? resData.param_id : null;

                    if (_this17.paramId) {
                      // GET WORKER PROESS
                      _this17.onGetWorkorderProcesss(_this17.paramId);

                      swal("Success", "".concat(processStepLabel, " \u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08"), "success");
                    } else {
                      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(processStepLabel, " ( param_id is null ) | ").concat(resData.message), "error");
                    }
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(processStepLabel, " | ").concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(processStepLabel, " | ").concat(error.message), "error");
                });

              case 7:
                _context16.next = 10;
                break;

              case 9:
                swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(processStepLabel, " | ").concat(resValidate.message), "error");

              case 10:
                // hide loading
                _this17.isLoading = false;

                _this17.setUrlParams();

              case 12:
              case "end":
                return _context16.stop();
            }
          }
        }, _callee16);
      }))();
    },
    onGetWorkorderProcesss: function onGetWorkorderProcesss(paramId) {
      var _this18 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee17() {
        var getParams;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee17$(_context17) {
          while (1) {
            switch (_context17.prev = _context17.next) {
              case 0:
                // show loading
                _this18.isLoading = true; // GET DAILY TRANSACTIONS

                getParams = {
                  param_id: paramId
                };
                _context17.next = 4;
                return axios.get("/ajax/ct/workorders/processes/get-trans", {
                  params: getParams
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this18.workorderProcesses = resData.transactions ? JSON.parse(resData.transactions) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E41\u0E2A\u0E14\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E41\u0E2A\u0E14\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E04\u0E33\u0E2A\u0E31\u0E48\u0E07\u0E1C\u0E25\u0E34\u0E15  | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this18.isLoading = false;

              case 5:
              case "end":
                return _context17.stop();
            }
          }
        }, _callee17);
      }))();
    },
    onWorkorderProcessSaved: function onWorkorderProcessSaved(data) {
      var _this19 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee18() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee18$(_context18) {
          while (1) {
            switch (_context18.prev = _context18.next) {
              case 0:
                _context18.next = 2;
                return _this19.queryWorkorderProcess(false);

              case 2:
                _this19.setUrlParams();

              case 3:
              case "end":
                return _context18.stop();
            }
          }
        }, _callee18);
      }))();
    },
    validateBeforeGenerate: function validateBeforeGenerate(paramHeader) {
      var result = {
        valid: true,
        message: ""
      };

      if (!paramHeader.period_year) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35";
      }

      if (!paramHeader.period_number) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E07\u0E27\u0E14\u0E1A\u0E31\u0E0D\u0E0A\u0E35";
      }

      if (!paramHeader.cost_code) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19";
      }

      return result;
    },
    validateBeforeQuery: function validateBeforeQuery(paramHeader) {
      var result = {
        valid: true,
        message: ""
      };

      if (!paramHeader.period_year) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35";
      }

      if (!paramHeader.period_number) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E07\u0E27\u0E14\u0E1A\u0E31\u0E0D\u0E0A\u0E35";
      }

      if (!paramHeader.cost_code) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19";
      }

      return result;
    },
    validateBeforeProcess: function validateBeforeProcess(paramHeader) {
      var result = {
        valid: true,
        message: ""
      };

      if (!paramHeader.period_year) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35";
      }

      if (!paramHeader.period_number) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E07\u0E27\u0E14\u0E1A\u0E31\u0E0D\u0E0A\u0E35";
      }

      if (!paramHeader.cost_code) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19";
      }

      return result;
    },
    validateBeforeSave: function validateBeforeSave(paramHeader, workorderProcesses) {
      var result = {
        valid: true,
        message: ""
      }; // IF NEW LINE ISN'T COMPLETED
      // const incompletedProcesses = workorderProcesses.filter(item => {
      //     return item.is_new_line && (
      //         !item.level ||
      //         !item.ratio
      //     ) && item.marked_as_deleted == false;
      // });
      // if(incompletedProcesses.length > 0) {
      //     result.valid = false;
      //     result.message = `กรอกข้อมูลรายการคำสั่งผลิตไม่ครบถ้วน กรุณาตรวจสอบ`
      // }

      return result;
    } // async onSaveWorkorderProcess() {
    //     const reqBody = {
    //         period_year: this.paramHeader.period_year,
    //         param_header: JSON.stringify(this.paramHeader),
    //         workorder_processes: JSON.stringify(this.workorderProcesses)
    //     };
    //     // show loading
    //     this.isLoading = true;
    //     const resValidate = this.validateBeforeSave(this.paramHeader, this.workorderProcesses);
    //     if(resValidate.valid) {
    //         // call store sample result
    //         await axios.post(`/ajax/ct/workorders/processes/store-processes`, reqBody)
    //         .then(res => {
    //             const resData = res.data.data;
    //             const resMsg = resData.message;
    //             const resPlanHeader = resData.param_header ? resData.param_header : null;
    //             if(resData.status == "success") {
    //                 this.paramHeader = resPlanHeader;
    //             }
    //             if(resData.status == "error") {
    //                 swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลประมวลผลคำสั่งผลิต : ${this.paramHeader.period_year_label} | ${resMsg}`, "error");
    //             }
    //             return resData;
    //         }).catch((error) => {
    //             console.log(error);
    //             swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลประมวลผลคำสั่งผลิต : ${this.paramHeader.period_year_label} | ${error.message}`, "error");
    //         });
    //     } else {
    //         swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลประมวลผลคำสั่งผลิต : ${this.paramHeader.period_year_label} | ${resValidate.message}`, "error");
    //     }
    //     // hide loading
    //     this.isLoading = false;
    // },

  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_3__);


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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["paramIdValue", "paramHeader", "workorderProcesses", "uomCodes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_3___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_2___default())
  },
  watch: {
    paramIdValue: function paramIdValue(data) {
      this.paramId = data;
    },
    paramHeader: function paramHeader(data) {
      this.paramHeaderData = data;
    },
    workorderProcesses: function workorderProcesses(data) {
      var _this = this;

      this.workorderProcessItems = data ? data.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          selected: item.freeze_flag == 'Y' ? true : false,
          uom_code_desc: _this.getUomCodeDescription(_this.uomCodes, item.uom_code),
          complete_date_ts: item.complete_date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(item.complete_date) : null,
          complete_date_thai: item.complete_date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(item.complete_date).add(543, "year").format("DD/MM/YYYY") : "-",
          closed_date_thai: item.closed_date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(item.closed_date).add(543, "year").format("DD/MM/YYYY") : "-"
        });
      }) : [];
    }
  },
  data: function data() {
    var _this2 = this;

    return {
      selectAll: false,
      paramId: this.paramIdValue,
      paramHeaderData: this.paramHeader,
      workorderProcessItems: this.workorderProcesses.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          selected: item.freeze_flag == 'Y' ? true : false,
          uom_code_desc: _this2.getUomCodeDescription(_this2.uomCodes, item.uom_code),
          complete_date_ts: item.complete_date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(item.complete_date) : null,
          complete_date_thai: item.complete_date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(item.complete_date).add(543, "year").format("DD/MM/YYYY") : "-",
          closed_date_thai: item.closed_date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(item.closed_date).add(543, "year").format("DD/MM/YYYY") : "-"
        });
      }),
      isLoading: false
    };
  },
  mounted: function mounted() {// this.emitWorkorderProcessChanged();
  },
  computed: {},
  methods: {
    onSaveProcess: function onSaveProcess() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log('workorderProcessItems : ', _this3.workorderProcessItems); // show loading

                _this3.isLoading = true; // GENERATE TRANSACTIONS

                reqBody = {
                  param_id: _this3.paramId,
                  param_header: JSON.stringify(_this3.paramHeader),
                  workorder_processes: JSON.stringify(_this3.workorderProcessItems)
                };
                _context.next = 5;
                return axios.post("/ajax/ct/workorders/processes/store-processes", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08", "success");

                    _this3.emitWorkorderProcessSaved();
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01 | ".concat(error.message), "error");
                });

              case 5:
                // hide loading
                _this3.isLoading = false;

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    formatter: function formatter(row, column) {
      return row.address;
    },
    numberFormatter: function numberFormatter(row, column, cellValue) {
      var result = cellValue ? Number(cellValue).toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }) : "-";
      return result;
    },
    sortCompleteQty: function sortCompleteQty(a, b) {
      return a.complete_qty - b.complete_qty;
    },
    sortRemainQuantity: function sortRemainQuantity(a, b) {
      return a.remain_quantity - b.remain_quantity;
    },
    sortCompleteDateThai: function sortCompleteDateThai(a, b) {
      return moment__WEBPACK_IMPORTED_MODULE_1___default()(a.complete_date) - moment__WEBPACK_IMPORTED_MODULE_1___default()(b.complete_date);
    },
    sortClosedDateThai: function sortClosedDateThai(a, b) {
      return moment__WEBPACK_IMPORTED_MODULE_1___default()(a.closed_date) - moment__WEBPACK_IMPORTED_MODULE_1___default()(b.closed_date);
    },
    emitWorkorderProcessSaved: function emitWorkorderProcessSaved() {
      this.$emit("onWorkorderProcessSaved", {
        param_id: this.paramId,
        param_header: this.paramHeader,
        workorder_processes: this.workorderProcessItems
      });
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
    },
    getUomCodeDescription: function getUomCodeDescription(uomCodes, uomCode) {
      var foundUomCode = uomCodes.find(function (item) {
        return item.uom_code == uomCode;
      });
      return foundUomCode ? foundUomCode.unit_of_measure : "";
    },
    onSelect: function onSelect(e, data) {
      var countAll = this.workorderProcessItems.length;
      var countSelected = this.workorderProcessItems.filter(function (item) {
        return item.selected == true;
      }).length;
      this.selectAll = countAll == countSelected;
    },
    isSelectionDisabled: function isSelectionDisabled(data) {
      var disabled = false; // if(data.batch_status == "ส่งเข้า GL แล้ว" && data.selected == true ) {

      if ((data.ct_status == 3 || data.ct_status == 4) && data.selected == true) {
        disabled = true;
      }

      return disabled;
    },
    onSelectAll: function onSelectAll(e) {
      var _this4 = this;

      this.$nextTick(function () {
        var selectAllValue = _this4.selectAll;
        _this4.workorderProcessItems = _this4.workorderProcessItems.map(function (item) {
          var selectedValue = selectAllValue; // if(item.batch_status == "ส่งเข้า GL แล้ว") {

          if (item.ct_status == 3 || item.ct_status == 4) {
            if (selectAllValue == false && item.selected == true) {
              selectedValue = true;
            }
          }

          return _objectSpread(_objectSpread({}, item), {}, {
            selected: selectedValue
          });
        });
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ct/workorders/processes/Index.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ct/workorders/processes/Index.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_ed4ccf6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=ed4ccf6c& */ "./resources/js/components/ct/workorders/processes/Index.vue?vue&type=template&id=ed4ccf6c&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/workorders/processes/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_ed4ccf6c___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_ed4ccf6c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/workorders/processes/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableWorkorderProcesses_vue_vue_type_template_id_5b5a8a34___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34& */ "./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34&");
/* harmony import */ var _TableWorkorderProcesses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableWorkorderProcesses.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableWorkorderProcesses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableWorkorderProcesses_vue_vue_type_template_id_5b5a8a34___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableWorkorderProcesses_vue_vue_type_template_id_5b5a8a34___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/workorders/processes/Index.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ct/workorders/processes/Index.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableWorkorderProcesses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableWorkorderProcesses.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableWorkorderProcesses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/workorders/processes/Index.vue?vue&type=template&id=ed4ccf6c&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ct/workorders/processes/Index.vue?vue&type=template&id=ed4ccf6c& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ed4ccf6c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ed4ccf6c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ed4ccf6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=ed4ccf6c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/Index.vue?vue&type=template&id=ed4ccf6c&");


/***/ }),

/***/ "./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableWorkorderProcesses_vue_vue_type_template_id_5b5a8a34___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableWorkorderProcesses_vue_vue_type_template_id_5b5a8a34___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableWorkorderProcesses_vue_vue_type_template_id_5b5a8a34___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/Index.vue?vue&type=template&id=ed4ccf6c&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/Index.vue?vue&type=template&id=ed4ccf6c& ***!
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
    { staticClass: "ibox" },
    [
      _c(
        "div",
        {
          staticClass: "ibox-content tw-pt-8",
          staticStyle: { "min-height": "600px" }
        },
        [
          _c("div", [
            _c("div", { staticClass: "row form-group" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                    },
                    [_vm._v(" ปีบัญชี ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "period_year",
                          id: "input_period_year",
                          "select-options": _vm.periodYears,
                          "option-key": "period_year_value",
                          "option-value": "period_year_value",
                          "option-label": "period_year_label",
                          value: _vm.paramHeader.period_year,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onPeriodYearChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold required"
                    },
                    [_vm._v(" งวดบัญชี ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "period_number",
                          id: "input_period_number",
                          "select-options": _vm.periodNumbers,
                          "option-key": "period_number_value",
                          "option-value": "period_number_value",
                          "option-label": "period_number_full_label",
                          value: _vm.paramHeader.period_number,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onPeriodNumberChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold required"
                    },
                    [_vm._v(" ตั้งแต่วันที่ ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _c("p", { staticClass: "col-form-label" }, [
                      _vm._v(
                        " " +
                          _vm._s(
                            _vm.paramHeader.start_date_thai
                              ? _vm.paramHeader.start_date_thai
                              : "-"
                          ) +
                          " "
                      )
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold required"
                    },
                    [_vm._v(" ถึงวันที่ ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-8" }, [
                    _c("p", { staticClass: "col-form-label" }, [
                      _vm._v(
                        " " +
                          _vm._s(
                            _vm.paramHeader.end_date_thai
                              ? _vm.paramHeader.end_date_thai
                              : "-"
                          ) +
                          " "
                      )
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row form-group" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold required"
                    },
                    [_vm._v(" ศูนย์ต้นทุน ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "cost_code",
                          id: "input_cost_code",
                          "select-options": _vm.costCenters,
                          "option-key": "cost_code_value",
                          "option-value": "cost_code_value",
                          "option-label": "cost_code_label",
                          value: _vm.paramHeader.cost_code,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onCostCenterCodeChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" หน่วยงาน (From) ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "dept_code_from",
                          id: "input_dept_code_from",
                          "select-options": _vm.ccDepartments,
                          "option-key": "department_code",
                          "option-value": "department_code",
                          "option-label": "department_code",
                          value: _vm.paramHeader.dept_code_from,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onDeptCodeFromChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" หน่วยงาน (To) ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "dept_code_to",
                          id: "input_dept_code_to",
                          "select-options": _vm.ccDepartments,
                          "option-key": "department_code",
                          "option-value": "department_code",
                          "option-label": "department_code",
                          value: _vm.paramHeader.dept_code_to,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onDeptCodeToChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row form-group" }, [
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" เลขที่คำสั่งผลิต (From) ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "batch_no_from",
                          id: "input_batch_no_from",
                          "select-options": _vm.batchNumbers,
                          "option-key": "batch_no",
                          "option-value": "batch_no",
                          "option-label": "batch_no",
                          value: _vm.paramHeader.batch_no_from,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onBatchNoFromChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" เลขที่คำสั่งผลิต (To) ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "batch_no_to",
                          id: "input_batch_no_to",
                          "select-options": _vm.batchNumbers,
                          "option-key": "batch_no",
                          "option-value": "batch_no",
                          "option-label": "batch_no",
                          value: _vm.paramHeader.batch_no_to,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onBatchNoToChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-4 col-form-label tw-font-bold" },
                    [_vm._v(" สถานะประมวลผล ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("ct-el-select", {
                        attrs: {
                          name: "process_status",
                          id: "input_process_status",
                          "select-options": _vm.processStatuses,
                          "option-key": "process_status",
                          "option-value": "process_status",
                          "option-label": "description",
                          value: _vm.paramHeader.process_status,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onProcessStatusChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-3" }, [
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
                    staticClass: "row"
                  },
                  [
                    _c(
                      "label",
                      { staticClass: "col-md-4 col-form-label tw-font-bold" },
                      [_vm._v(" สถานะส่งเข้า GL ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-8" },
                      [
                        _c("ct-el-select", {
                          attrs: {
                            name: "posting_status",
                            id: "input_posting_status",
                            "select-options": _vm.postingStatuses,
                            "option-key": "posting_status",
                            "option-value": "posting_status",
                            "option-label": "description",
                            value: _vm.paramHeader.posting_status,
                            filterable: true,
                            clearable: true
                          },
                          on: { onSelected: _vm.onPostingStatusChanged }
                        })
                      ],
                      1
                    )
                  ]
                )
              ])
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("div", [
            _c("div", { staticClass: "text-left tw-mb-2" }, [
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-inline-block btn-sm btn-primary tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.paramHeader.period_year ||
                      !_vm.paramHeader.period_name ||
                      !_vm.paramHeader.cost_code
                  },
                  on: { click: _vm.onQueryWorkorderProcesss }
                },
                [
                  _c("i", { staticClass: "fa fa-search tw-mr-1" }),
                  _vm._v(" แสดงข้อมูล \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-40",
                  on: { click: _vm.onClearParamHeader }
                },
                [
                  _c("i", { staticClass: "fa fa-times tw-mr-1" }),
                  _vm._v(" ล้างการค้นหา \n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-info tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.paramHeader.period_year ||
                      !_vm.paramHeader.period_name ||
                      !_vm.paramHeader.cost_code
                  },
                  on: {
                    click: function($event) {
                      return _vm.onProcessWorkorderProcesss($event, "FINAL")
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-retweet tw-mr-1" }),
                  _vm._v(" ส่งข้อมูลเข้า GL\n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-danger tw-w-40",
                  attrs: {
                    disabled:
                      !_vm.paramHeader.period_year ||
                      !_vm.paramHeader.period_name ||
                      !_vm.paramHeader.cost_code
                  },
                  on: {
                    click: function($event) {
                      return _vm.onProcessWorkorderProcesss($event, "CANCEL")
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-retweet tw-mr-1" }),
                  _vm._v(" ยกเลิกข้อมูลเข้า GL\n                ")
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("div", [
            _c("div", { staticClass: "text-left tw-mb-2" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-52",
                  attrs: { disabled: true }
                },
                [
                  _vm._v(
                    " \n                    รายงานการบันทึกบัญชี \n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-52",
                  attrs: { disabled: true }
                },
                [
                  _vm._v(
                    "\n                    รายงานรายละเอียดวัตถุดิบที่ใช้ไป\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-52",
                  attrs: { disabled: true }
                },
                [
                  _vm._v(
                    " \n                    งานระหว่างผลิตปลายงวด\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-52",
                  attrs: { disabled: true }
                },
                [
                  _vm._v(
                    " \n                    รายงานบัตรต้นทุน\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-sm btn-white tw-w-52",
                  attrs: { disabled: true }
                },
                [
                  _vm._v(
                    " \n                    รายงานสรุปต้นทุนผลิต\n                "
                  )
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("div", { staticClass: "tw-m-8" }, [
            _c("div", { staticClass: "row tw-mb-5" }, [
              _c(
                "div",
                { staticClass: "col-12" },
                [
                  _c("table-workorder-processes", {
                    attrs: {
                      "param-id-value": _vm.paramId,
                      "param-header": _vm.paramHeader,
                      "workorder-processes": _vm.workorderProcesses,
                      "uom-codes": _vm.uomCodes
                    },
                    on: { onWorkorderProcessSaved: _vm.onWorkorderProcessSaved }
                  })
                ],
                1
              )
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/workorders/processes/TableWorkorderProcesses.vue?vue&type=template&id=5b5a8a34& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "text-left tw-mb-2" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-inline-block btn-sm btn-primary tw-w-40",
            attrs: {
              type: "input",
              disabled: _vm.workorderProcessItems.length <= 0
            },
            on: { click: _vm.onSaveProcess }
          },
          [
            _c("i", { staticClass: "fa fa-save tw-mr-1" }),
            _vm._v(" บันทึก \n        ")
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "table-responsive",
          staticStyle: { "max-height": "400px" }
        },
        [
          _c(
            "el-table",
            {
              staticStyle: { width: "100%" },
              attrs: {
                data: _vm.workorderProcessItems,
                "default-sort": {
                  prop: "complete_date_ts",
                  order: "descending"
                },
                height: "400"
              }
            },
            [
              _c("el-table-column", {
                attrs: { label: "", width: "55" },
                scopedSlots: _vm._u([
                  {
                    key: "header",
                    fn: function() {
                      return [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.selectAll,
                              expression: "selectAll"
                            }
                          ],
                          attrs: { type: "checkbox", name: "all_selected" },
                          domProps: {
                            checked: Array.isArray(_vm.selectAll)
                              ? _vm._i(_vm.selectAll, null) > -1
                              : _vm.selectAll
                          },
                          on: {
                            change: [
                              function($event) {
                                var $$a = _vm.selectAll,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      (_vm.selectAll = $$a.concat([$$v]))
                                  } else {
                                    $$i > -1 &&
                                      (_vm.selectAll = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)))
                                  }
                                } else {
                                  _vm.selectAll = $$c
                                }
                              },
                              function($event) {
                                return _vm.onSelectAll($event)
                              }
                            ]
                          }
                        })
                      ]
                    },
                    proxy: true
                  },
                  {
                    key: "default",
                    fn: function(scope) {
                      return [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: scope.row.selected,
                              expression: "scope.row.selected"
                            }
                          ],
                          attrs: {
                            type: "checkbox",
                            name: "selected",
                            disabled: _vm.isSelectionDisabled(scope.row)
                          },
                          domProps: {
                            checked: Array.isArray(scope.row.selected)
                              ? _vm._i(scope.row.selected, null) > -1
                              : scope.row.selected
                          },
                          on: {
                            change: [
                              function($event) {
                                var $$a = scope.row.selected,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      _vm.$set(
                                        scope.row,
                                        "selected",
                                        $$a.concat([$$v])
                                      )
                                  } else {
                                    $$i > -1 &&
                                      _vm.$set(
                                        scope.row,
                                        "selected",
                                        $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1))
                                      )
                                  }
                                } else {
                                  _vm.$set(scope.row, "selected", $$c)
                                }
                              },
                              function($event) {
                                return _vm.onSelect($event, scope.row)
                              }
                            ]
                          }
                        })
                      ]
                    }
                  }
                ])
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "complete_date_thai",
                  label: "วันที่บันทึกผลผลิต",
                  sortable: "",
                  align: "center",
                  "sort-method": _vm.sortCompleteDateThai,
                  width: "160"
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "batch_no",
                  label: "เลขที่คำสั่งผลิต",
                  sortable: "",
                  align: "center",
                  width: "160"
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "batch_status",
                  label: "สถานะ Batch",
                  sortable: "",
                  align: "center",
                  width: "150"
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "product_item_number",
                  label: "รหัสผลิตภัณฑ์",
                  sortable: "",
                  align: "center",
                  width: "150"
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "item_desc",
                  label: "ผลิตภัณฑ์",
                  sortable: "",
                  align: "left",
                  width: "250"
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "complete_qty",
                  label: "จำนวนที่ผลิตได้",
                  sortable: "",
                  align: "right",
                  width: "250",
                  "sort-method": _vm.sortCompleteQty,
                  formatter: _vm.numberFormatter
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "remain_quantity",
                  label: "รวมจำนวนคงค้างในขั้นตอน",
                  sortable: "",
                  align: "right",
                  width: "250",
                  "sort-method": _vm.sortRemainQuantity,
                  formatter: _vm.numberFormatter
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "uom_code_desc",
                  label: "หน่วยนับ",
                  sortable: "",
                  align: "center",
                  width: "100"
                }
              }),
              _vm._v(" "),
              _c("el-table-column", {
                attrs: {
                  prop: "closed_date_thai",
                  label: "วันที่ปิดคำสั่งผลิต",
                  sortable: "",
                  align: "center",
                  "sort-method": _vm.sortClosedDateThai,
                  width: "150"
                }
              })
            ],
            1
          )
        ],
        1
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