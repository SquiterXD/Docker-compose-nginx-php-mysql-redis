(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_std-costs_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/Index.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/Index.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableStdCostAccounts__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableStdCostAccounts */ "./resources/js/components/ct/std-costs/TableStdCostAccounts.vue");
/* harmony import */ var _ModalSearchStdcost__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalSearchStdcost */ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue");


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TableStdCostAccounts: _TableStdCostAccounts__WEBPACK_IMPORTED_MODULE_4__.default,
    ModalSearchStdcost: _ModalSearchStdcost__WEBPACK_IMPORTED_MODULE_5__.default
  },
  props: ["defaultData", "periodYearValue", "prdgrpYearIdValue", "allocateAccountVersionValue", "allocateYearIdValue", "allocateGroupValue", "periodNameFromValue", "periodNameToValue", "periodYears", "existPeriodYears", "listAllocateGroups", "allocateTypes"],
  mounted: function mounted() {
    var _this = this;

    if (this.periodYearValue) {
      this.getListPeriods(this.periodYearValue).then(function (value) {
        if (_this.periodNameFromValue) {
          _this.periodNameFrom = _this.periodNameFromValue;
          _this.periodNameFromLabel = _this.getPeriodNameLabel(_this.periodNameFroms, _this.periodNameFrom);
        }

        if (_this.periodNameToValue) {
          _this.periodNameTo = _this.periodNameToValue;
          _this.periodNameToLabel = _this.getPeriodNameLabel(_this.periodNameTos, _this.periodNameTo);
        }
      });
      this.getListPrdgrps(this.periodYearValue).then(function (value) {
        _this.planVersionNo = _this.getPrdgrpPlanVersionNo(_this.prdgrpVersions, _this.prdgrpYearIdValue);
      });
      this.getAllocateAccounts(this.periodYearValue).then(function (value) {
        if (_this.allocateAccountVersionValue) {
          var foundAlcAccVersion = _this.allocateAccountVersions.find(function (item) {
            return item.version_no == _this.allocateAccountVersionValue;
          });

          _this.allocateYearId = foundAlcAccVersion ? foundAlcAccVersion.allocate_year_id : null;
        }
      });
      this.getAllocateGroupCodes(this.periodYearValue, this.allocateAccountVersionValue);
    }
  },
  data: function data() {
    return {
      organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
      organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
      department: this.defaultData ? JSON.parse(this.defaultData).department : null,
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      existPeriodYearOptions: this.existPeriodYears,
      periodNameFroms: [],
      periodNameFrom: this.periodNameFromValue,
      periodNameFromLabel: null,
      periodNameTos: [],
      periodNameTo: this.periodNameToValue,
      periodNameToLabel: null,
      prdgrpVersions: [],
      prdgrpYearId: this.prdgrpYearIdValue,
      planVersionNo: null,
      allocateAccountVersions: [],
      allocateAccountVersion: this.allocateAccountVersionValue,
      allocateYearId: this.allocateAccountVersionValue,
      // allocateGroup: this.allocateGroupValue ? this.allocateGroupValue : "DEPT",
      // allocateGroupLevel: this.getAllocateGroupLevel(this.listAllocateGroups, this.allocateGroupValue ? this.allocateGroupValue : "DEPT"),
      // allocateGroupLabel: this.getAllocateGroupLabel(this.listAllocateGroups, this.allocateGroupValue ? this.allocateGroupValue : "DEPT"),
      allocateGroupCodes: [],
      stdcostYear: null,
      stdcostYearVersion: this.versionValue,
      stdcostYearVersions: [],
      selectedStdcostYearData: {},
      stdcostAccounts: [],
      listAllAllocateGroupCodes: [],
      listDeptAllocateGroupCodes: [],
      listCostAllocateGroupCodes: [],
      listProductAllocateGroupCodes: [],
      showTableStdcostAccounts: false,
      isLoading: false
    };
  },
  computed: {},
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("period_year", this.periodYear ? this.periodYear : '');
      queryParams.set("prdgrp_year_id", this.prdgrpYearId ? this.prdgrpYearId : '');
      queryParams.set("allocate_account_version", this.allocateAccountVersion ? this.allocateAccountVersion : '');
      queryParams.set("allocate_year_id", this.allocateYearId ? this.allocateYearId : '');
      queryParams.set("allocate_group", this.allocateGroup ? this.allocateGroup : 'DEPT');
      queryParams.set("period_name_from", this.periodNameFrom ? this.periodNameFrom : '');
      queryParams.set("period_name_to", this.periodNameTo ? this.periodNameTo : '');
      window.history.replaceState(null, null, "?" + queryParams.toString());
    },
    onPeriodYearChanged: function onPeriodYearChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.periodYear = value;
                _this2.periodYearLabel = _this2.getPeriodYearLabel(_this2.periodYears, _this2.periodYear);

                _this2.setUrlParams(); // REFRESH DATA


                _this2.stdcostYear = null;
                _this2.stdcostAccounts = [];
                _this2.listAllAllocateGroupCodes = [];
                _this2.listDeptAllocateGroupCodes = [];
                _this2.listCostAllocateGroupCodes = [];
                _this2.listProductAllocateGroupCodes = []; // REFRESH DATA

                _this2.periodNameFrom = null;
                _this2.periodNameTo = null;
                _this2.allocateAccountVersion = null;
                _this2.allocateYearId = null;
                _this2.prdgrpYearId = null;

                _this2.getListPeriods(_this2.periodYear);

                _this2.getListPrdgrps(_this2.periodYear);

                _context.next = 18;
                return _this2.getAllocateGroupCodes(_this2.periodYear, _this2.allocateGroup, _this2.allocateAccountVersion);

              case 18:
                _context.next = 20;
                return _this2.getAllocateAccounts(_this2.periodYear);

              case 20:
                _this2.showTableStdcostAccounts = false;

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onPrdgrpVersionChanged: function onPrdgrpVersionChanged(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var foundAlcAccVersion;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.prdgrpYearId = value;
                _this3.planVersionNo = _this3.getPrdgrpPlanVersionNo(_this3.prdgrpVersions, _this3.prdgrpYearId);
                foundAlcAccVersion = _this3.allocateAccountVersions.find(function (item) {
                  return item.version_no == _this3.planVersionNo;
                });

                if (foundAlcAccVersion) {
                  _this3.allocateAccountVersion = _this3.planVersionNo;
                }

                _this3.stdcostAccounts = [];
                _this3.listAllAllocateGroupCodes = [];
                _this3.listDeptAllocateGroupCodes = [];
                _this3.listCostAllocateGroupCodes = [];
                _this3.listProductAllocateGroupCodes = [];

                _this3.setUrlParams();

              case 10:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onAllocateAccountVersionChanged: function onAllocateAccountVersionChanged(value) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var foundAlcAccVersion;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.allocateAccountVersion = value;

                _this4.getAllocateGroupCodes(_this4.periodYear, _this4.allocateGroup, _this4.allocateAccountVersion);

                foundAlcAccVersion = _this4.allocateAccountVersions.find(function (item) {
                  return item.version_no == value;
                });
                _this4.allocateYearId = foundAlcAccVersion ? foundAlcAccVersion.allocate_year_id : null; // REFRESH DATA

                _this4.stdcostYear = null;
                _this4.stdcostAccounts = [];
                _this4.listAllAllocateGroupCodes = [];
                _this4.listDeptAllocateGroupCodes = [];
                _this4.listCostAllocateGroupCodes = [];
                _this4.listProductAllocateGroupCodes = [];
                _this4.showTableStdcostAccounts = false;

                _this4.setUrlParams();

              case 12:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onPeriodNameFromChanged: function onPeriodNameFromChanged(value) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var foundPeriodNameFrom;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this5.periodNameFrom = value;
                _this5.periodNameFromLabel = _this5.getPeriodNameLabel(_this5.periodNameFroms, _this5.periodNameFrom);
                foundPeriodNameFrom = _this5.periodNameFroms.find(function (item) {
                  return item.period_name == _this5.periodNameFrom;
                });
                _this5.periodNameTos = _this5.periodNameFroms.filter(function (item) {
                  return item.period_num >= foundPeriodNameFrom.period_num && item.period_num < 12;
                });
                _this5.periodNameTo = null;
                _this5.periodNameToLabel = null;

                _this5.setUrlParams();

              case 7:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onPeriodNameToChanged: function onPeriodNameToChanged(value) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this6.periodNameTo = value;
                _this6.periodNameToLabel = _this6.getPeriodNameLabel(_this6.periodNameTos, _this6.periodNameTo);

                _this6.setUrlParams();

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getPeriodYearLabel: function getPeriodYearLabel(periodYears, periodYear) {
      var result = null;

      if (periodYear) {
        var foundPeriodYear = periodYears.find(function (item) {
          return item.period_year_value == periodYear;
        });
        result = foundPeriodYear ? foundPeriodYear.period_year_label : "";
      }

      return result;
    },
    getPeriodNameLabel: function getPeriodNameLabel(periodNames, periodName) {
      var result = null;

      if (periodName) {
        var foundPeriodName = periodNames.find(function (item) {
          return item.period_name == periodName;
        });
        result = foundPeriodName ? foundPeriodName.thai_month : "";
      }

      return result;
    },
    getPrdgrpPlanVersionNo: function getPrdgrpPlanVersionNo(prdgrpVersions, prdgrpYearIdValue) {
      var result = null;

      if (prdgrpYearIdValue) {
        var foundPrdgrp = prdgrpVersions.find(function (item) {
          return item.prdgrp_year_id == prdgrpYearIdValue;
        });
        result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
      }

      return result;
    },
    getAllocateGroupLevel: function getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
      var foundAllocateGroup = listAllocateGroups.find(function (item) {
        return item.allocate_group == allocateGroupValue;
      });
      return foundAllocateGroup ? foundAllocateGroup.level_no : "";
    },
    getAllocateGroupLabel: function getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
      var foundAllocateGroup = listAllocateGroups.find(function (item) {
        return item.allocate_group == allocateGroupValue;
      });
      return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
    },
    validateBeforeGetStdcostYear: function validateBeforeGetStdcostYear(periodYear, allocateAccountVersion) {
      var valid = false;

      if (periodYear && allocateAccountVersion) {
        valid = true;
      }

      return valid;
    },
    validateBeforeSaveStdcostYear: function validateBeforeSaveStdcostYear(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo) {
      var valid = false;

      if (periodYear && prdgrpYearId && allocateAccountVersion && allocateYearId && periodNameFrom && periodNameTo) {
        valid = true;
      }

      return valid;
    },
    validateBeforeGetDeptCodes: function validateBeforeGetDeptCodes(periodYear) {
      var valid = false;

      if (periodYear) {
        valid = true;
      }

      return valid;
    },
    validateBeforeGetStdcostAccounts: function validateBeforeGetStdcostAccounts(periodYear, stdcostYear) {
      var valid = false;

      if (periodYear && stdcostYear) {
        valid = true;
      }

      return valid;
    },
    validateBeforeGenerateAccountTargets: function validateBeforeGenerateAccountTargets(periodYear, stdcostYear) {
      var valid = false;

      if (periodYear && stdcostYear) {
        valid = true;
      }

      return valid;
    },
    getStdcostYearData: function getStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo, isCreateNew) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var params, isValid, resGetStdcostYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                // show loading
                _this7.isLoading = true; // REFRESH DATA

                _this7.stdcostYear = null;
                params = {
                  period_year: periodYear,
                  allocate_account_version: allocateAccountVersion,
                  prdgrp_year_id: prdgrpYearId,
                  period_name_from: periodNameFrom,
                  period_name_to: periodNameTo
                };
                _this7.selectedStdcostYearData = {
                  period_year: periodYear,
                  allocate_account_version: allocateAccountVersion,
                  prdgrp_year_id: prdgrpYearId,
                  allocate_year_id: allocateYearId,
                  period_name_from: periodNameFrom,
                  period_name_to: periodNameTo
                }; // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE

                isValid = _this7.validateBeforeGetStdcostYear(periodYear, allocateAccountVersion);

                if (!isValid) {
                  _context6.next = 16;
                  break;
                }

                _context6.next = 8;
                return axios.get("/ajax/ct/std-costs/year", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  } else {
                    _this7.stdcostYear = resData.stdcost_year ? JSON.parse(resData.stdcost_year) : null;

                    if (_this7.stdcostYear && !isCreateNew) {
                      _this7.prdgrpYearId = _this7.stdcostYear.prdgrp_year_id;
                      _this7.allocateYearId = _this7.stdcostYear.allocate_year_id;
                      _this7.periodNameFrom = _this7.stdcostYear.period_name_from;
                      _this7.periodNameTo = _this7.stdcostYear.period_name_to;
                      _this7.planVersionNo = _this7.getPrdgrpPlanVersionNo(_this7.prdgrpVersions, _this7.prdgrpYearId);
                      _this7.periodNameFromLabel = _this7.getPeriodNameLabel(_this7.periodNameFroms, _this7.periodNameFrom);
                      _this7.periodNameToLabel = _this7.getPeriodNameLabel(_this7.periodNameTos, _this7.periodNameTo);
                    }
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                  return;
                });

              case 8:
                resGetStdcostYear = _context6.sent;

                if (!(resGetStdcostYear.status != "error")) {
                  _context6.next = 13;
                  break;
                }

                if (isCreateNew) {
                  _context6.next = 13;
                  break;
                }

                _context6.next = 13;
                return _this7.getStdcostAccounts(_this7.periodYear, _this7.stdcostYear);

              case 13:
                _this7.setUrlParams();

                _context6.next = 17;
                break;

              case 16:
                swal("เกิดข้อผิดพลาด", "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19", "error");

              case 17:
                // hide loading
                _this7.isLoading = false;

              case 18:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onGenerateStdcostYearData: function onGenerateStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _context8.next = 2;
                return _this8.getStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo, true);

              case 2:
                if (!_this8.stdcostYear) {
                  _context8.next = 6;
                  break;
                }

                swal({
                  title: "",
                  text: "\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E0B\u0E49\u0E33 (\u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13: ".concat(_this8.periodYearLabel, ", \u0E40\u0E01\u0E13\u0E11\u0E4C\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48: ").concat(_this8.allocateAccountVersion, ", \u0E40\u0E1B\u0E23\u0E35\u0E22\u0E1A\u0E40\u0E17\u0E35\u0E22\u0E1A\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22\u0E08\u0E23\u0E34\u0E07\u0E08\u0E32\u0E01: ").concat(_this8.periodNameFromLabel, " \u0E16\u0E36\u0E07 ").concat(_this8.periodNameToLabel, ") \u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E2B\u0E21\u0E48 ?"),
                  showCancelButton: true,
                  confirmButtonClass: "btn-primary",
                  confirmButtonText: "ยืนยัน",
                  cancelButtonText: "ยกเลิก",
                  closeOnConfirm: true
                }, /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7(isConfirm) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
                      while (1) {
                        switch (_context7.prev = _context7.next) {
                          case 0:
                            if (!isConfirm) {
                              _context7.next = 12;
                              break;
                            }

                            _this8.prdgrpYearId = _this8.selectedStdcostYearData.prdgrp_year_id;
                            _this8.allocateYearId = _this8.selectedStdcostYearData.allocate_year_id;
                            _this8.periodNameFrom = _this8.selectedStdcostYearData.period_name_from;
                            _this8.periodNameTo = _this8.selectedStdcostYearData.period_name_to;
                            _this8.planVersionNo = _this8.getPrdgrpPlanVersionNo(_this8.prdgrpVersions, _this8.prdgrpYearId);
                            _this8.periodNameFromLabel = _this8.getPeriodNameLabel(_this8.periodNameFroms, _this8.periodNameFrom);
                            _this8.periodNameToLabel = _this8.getPeriodNameLabel(_this8.periodNameTos, _this8.periodNameTo);
                            _context7.next = 10;
                            return _this8.onSaveStdcostYear();

                          case 10:
                            _context7.next = 12;
                            return _this8.getStdcostAccounts(_this8.periodYear, _this8.stdcostYear);

                          case 12:
                          case "end":
                            return _context7.stop();
                        }
                      }
                    }, _callee7);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());
                _context8.next = 10;
                break;

              case 6:
                _context8.next = 8;
                return _this8.onSaveStdcostYear();

              case 8:
                _context8.next = 10;
                return _this8.getStdcostAccounts(_this8.periodYear, _this8.stdcostYear);

              case 10:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    getListPeriods: function getListPeriods(periodYear) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var resultData, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                resultData = null; // show loading

                _this9.isLoading = true;
                params = {
                  period_year: periodYear
                };

                if (!periodYear) {
                  _context9.next = 7;
                  break;
                }

                _context9.next = 6;
                return axios.get("/ajax/ct/std-costs/list-periods", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E14\u0E37\u0E2D\u0E19\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E02\u0E2D\u0E07\u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this9.periodNameFroms = resData.periods ? JSON.parse(resData.periods) : [];
                    _this9.periodNameFroms = _this9.periodNameFroms.filter(function (item) {
                      return item.period_num < 12;
                    });
                    _this9.periodNameTos = resData.periods ? JSON.parse(resData.periods) : [];
                    _this9.periodNameTos = _this9.periodNameTos.filter(function (item) {
                      return item.period_num < 12;
                    });
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E14\u0E37\u0E2D\u0E19\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E02\u0E2D\u0E07\u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 6:
                resultData = _context9.sent;

              case 7:
                // hide loading
                _this9.isLoading = false;
                return _context9.abrupt("return", resultData);

              case 9:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    getListPrdgrps: function getListPrdgrps(periodYear) {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var resultData, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                resultData = null; // show loading

                _this10.isLoading = true;
                params = {
                  period_year: periodYear
                };

                if (!periodYear) {
                  _context10.next = 7;
                  break;
                }

                _context10.next = 6;
                return axios.get("/ajax/ct/std-costs/list-prdgrps", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this10.prdgrpVersions = resData.prdgrps ? JSON.parse(resData.prdgrps) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 6:
                resultData = _context10.sent;

              case 7:
                // hide loading
                _this10.isLoading = false;
                return _context10.abrupt("return", resultData);

              case 9:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    getAllocateGroupCodes: function getAllocateGroupCodes(periodYear, versionNo) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var resultData, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                resultData = null; // show loading

                _this11.isLoading = true;
                params = {
                  period_year: periodYear,
                  version_no: versionNo
                };

                if (!periodYear) {
                  _context11.next = 7;
                  break;
                }

                _context11.next = 6;
                return axios.get("/ajax/ct/std-costs/allocate-group-codes", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2B\u0E19\u0E48\u0E27\u0E22\u0E07\u0E32\u0E19\u0E17\u0E35\u0E48\u0E1B\u0E31\u0E19 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this11.allocateGroupCodes = resData.allocate_group_codes ? JSON.parse(resData.allocate_group_codes) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2B\u0E19\u0E48\u0E27\u0E22\u0E07\u0E32\u0E19\u0E17\u0E35\u0E48\u0E1B\u0E31\u0E19 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 6:
                resultData = _context11.sent;

              case 7:
                // hide loading
                _this11.isLoading = false;
                return _context11.abrupt("return", resultData);

              case 9:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    getAllocateAccounts: function getAllocateAccounts(periodYear) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var resultData, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                resultData = null; // show loading

                _this12.isLoading = true;
                params = {
                  period_year: periodYear
                };

                if (!periodYear) {
                  _context12.next = 7;
                  break;
                }

                _context12.next = 6;
                return axios.get("/ajax/ct/std-costs/allocate-accounts", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E01\u0E13\u0E11\u0E4C\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this12.allocateAccountVersions = resData.allocate_account_versions ? JSON.parse(resData.allocate_account_versions) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E01\u0E13\u0E11\u0E4C\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 6:
                resultData = _context12.sent;

              case 7:
                // hide loading
                _this12.isLoading = false;
                return _context12.abrupt("return", resultData);

              case 9:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    getStdcostAccounts: function getStdcostAccounts(periodYear, stdcostYear) {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var resultData, params, isValid;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                resultData = null; // show loading

                _this13.isLoading = true; // REFRESH DATA

                _this13.stdcostAccounts = [];
                _this13.listAllAllocateGroupCodes = [];
                _this13.listDeptAllocateGroupCodes = [];
                _this13.listCostAllocateGroupCodes = [];
                _this13.listProductAllocateGroupCodes = [];
                params = {
                  period_year: periodYear,
                  input_stdcost_year: JSON.stringify(stdcostYear)
                };
                isValid = _this13.validateBeforeGetStdcostAccounts(periodYear, stdcostYear);

                if (!isValid) {
                  _context13.next = 14;
                  break;
                }

                _context13.next = 12;
                return axios.get("/ajax/ct/std-costs/accounts", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1A\u0E31\u0E0D\u0E0A\u0E35\u0E23\u0E31\u0E1A\u0E1B\u0E31\u0E19 | ".concat(resData.message), "error");
                  } else {
                    _this13.stdcostAccounts = resData.stdcost_accounts ? JSON.parse(resData.stdcost_accounts) : [];
                    _this13.listAllAllocateGroupCodes = resData.list_all_allocate_group_codes ? JSON.parse(resData.list_all_allocate_group_codes) : [];
                    _this13.listDeptAllocateGroupCodes = resData.list_dept_allocate_group_codes ? JSON.parse(resData.list_dept_allocate_group_codes) : [];
                    _this13.listCostAllocateGroupCodes = resData.list_cost_allocate_group_codes ? JSON.parse(resData.list_cost_allocate_group_codes) : [];
                    _this13.listProductAllocateGroupCodes = resData.list_product_allocate_group_codes ? JSON.parse(resData.list_product_allocate_group_codes) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1A\u0E31\u0E0D\u0E0A\u0E35\u0E23\u0E31\u0E1A\u0E1B\u0E31\u0E19 | ".concat(error.message), "error");
                  return;
                });

              case 12:
                resultData = _context13.sent;
                _this13.showTableStdcostAccounts = true;

              case 14:
                // hide loading
                _this13.isLoading = false;
                return _context13.abrupt("return", resultData);

              case 16:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    // async generateStdcostAccountTargets(periodYear, stdcostYear) {
    //     let resultData = null;
    //     // show loading
    //     this.isLoading = true;
    //     // REFRESH DATA
    //     this.stdcostAccounts = [];
    //     const reqBody = {
    //         period_year: periodYear,
    //         input_stdcost_year: JSON.stringify(stdcostYear),
    //     };
    //     const isValid = this.validateBeforeGenerateAccountTargets(periodYear, stdcostYear);
    //     if(isValid) {
    //         await axios.post(`/ajax/ct/std-costs/generate-account-targets`, reqBody)
    //         .then(res => {
    //             const resData = res.data.data;
    //             if(resData.status == "error") {
    //                 swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${resData.message}`, "error");
    //             } else {
    //             }
    //             return resData;
    //         }).catch((error) => {
    //             console.log(error);
    //             swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${error.message}`, "error");
    //             return ;
    //         });
    //         // REFRESH STD_COST_ACCOUNTS
    //         await this.getStdcostAccounts(this.periodYear, this.stdcostYear);
    //     }
    //     // hide loading
    //     this.isLoading = false;
    //     return resultData;
    // },
    getApproveStatusDesc: function getApproveStatusDesc(status) {
      var statusDesc = "-";

      if (status) {
        var foundStatus = this.approveStatuses.find(function (item) {
          return item.lookup_code == status;
        });
        statusDesc = foundStatus ? foundStatus.description : "-";
      }

      return statusDesc;
    },
    onStdcostAccountsChanged: function onStdcostAccountsChanged(data) {
      this.stdcostAccounts = data.stdcostAccounts;
    },
    onSearchStdcostVersion: function onSearchStdcostVersion(data) {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                _this14.stdcostYear = data.stdcost_year;
                _this14.allocateGroup = data.allocate_group;
                _this14.periodYear = _this14.stdcostYear.period_year;
                _this14.periodYearLabel = _this14.getPeriodYearLabel(_this14.periodYears, _this14.periodYear);
                _this14.prdgrpYearId = _this14.stdcostYear.prdgrp_year_id;
                _this14.allocateAccountVersion = _this14.stdcostYear.version_no;
                _this14.allocateYearId = _this14.stdcostYear.allocate_year_id;
                _this14.periodNameFrom = _this14.stdcostYear.period_name_from;
                _this14.periodNameTo = _this14.stdcostYear.period_name_to;
                _this14.planVersionNo = _this14.getPrdgrpPlanVersionNo(_this14.prdgrpVersions, _this14.prdgrpYearId);
                _this14.periodNameFromLabel = _this14.getPeriodNameLabel(_this14.periodNameFroms, _this14.periodNameFrom);
                _this14.periodNameToLabel = _this14.getPeriodNameLabel(_this14.periodNameTos, _this14.periodNameTo);

                if (!_this14.periodYear) {
                  _context14.next = 21;
                  break;
                }

                _context14.next = 15;
                return _this14.getListPeriods(_this14.periodYear);

              case 15:
                _context14.next = 17;
                return _this14.getListPrdgrps(_this14.periodYear);

              case 17:
                _context14.next = 19;
                return _this14.getAllocateGroupCodes(_this14.periodYear, _this14.allocateGroup, _this14.allocateAccountVersion);

              case 19:
                _context14.next = 21;
                return _this14.getAllocateAccounts(_this14.periodYear);

              case 21:
                _context14.next = 23;
                return _this14.getStdcostYearData(_this14.periodYear, _this14.prdgrpYearId, _this14.allocateAccountVersion, _this14.allocateYearId, _this14.periodNameFrom, _this14.periodNameTo, false);

              case 23:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    onSaveStdcostYear: function onSaveStdcostYear() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var reqBody, isValid;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                reqBody = {
                  period_year: _this15.periodYear,
                  prdgrp_year_id: _this15.prdgrpYearId,
                  allocate_account_version: _this15.allocateAccountVersion,
                  allocate_year_id: _this15.allocateYearId,
                  period_name_from: _this15.periodNameFrom,
                  period_name_to: _this15.periodNameTo
                }; // show loading

                _this15.isLoading = true;
                isValid = _this15.validateBeforeSaveStdcostYear(_this15.periodYear, _this15.prdgrpYearId, _this15.allocateAccountVersion, _this15.allocateYearId, _this15.periodNameFrom, _this15.periodNameTo);

                if (!isValid) {
                  _context15.next = 8;
                  break;
                }

                _context15.next = 6;
                return axios.post("/ajax/ct/std-costs/year", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this15.stdcostYear = resData.stdcost_year ? JSON.parse(resData.stdcost_year) : null;
                    _this15.existPeriodYearOptions = resData.exist_period_years ? JSON.parse(resData.exist_period_years) : [];
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 | ".concat(error.message), "error");
                });

              case 6:
                _context15.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 | ".concat(resValidate.message), "error");

              case 9:
                // hide loading
                _this15.isLoading = false;

              case 10:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_3___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=script&lang=js& ***!
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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight", "organizationCode", "periodYears", "periodYearValue", "listAllocateGroups"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default())
  },
  watch: {
    periodYears: function periodYears(value) {
      this.periodYearOptions = value;
    },
    periodYearValue: function periodYearValue(value) {
      this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, value);

      if (this.periodYearLabel) {
        this.periodYear = value;
        this.getListPeriods(this.periodYear);
        this.getListPrdgrps(this.periodYear);
        this.getAllocateGroupCodes(this.periodYear, this.allocateAccountVersion);
        this.getAllocateAccounts(this.periodYear);
      }
    }
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      periodNames: [],
      periodYearOptions: this.periodYears,
      prdgrpVersions: [],
      prdgrpYearId: this.prdgrpYearIdValue,
      planVersionNo: null,
      allocateAccountVersions: [],
      allocateAccountVersion: this.allocateAccountVersionValue,
      allocateYearId: this.allocateAccountVersionValue,
      allocateGroupCodes: [],
      stdcostYears: [],
      selectedStdcostYear: null
    };
  },
  created: function created() {
    this.handleResize();
  },
  mounted: function mounted() {
    this.periodYearOptions = this.periodYears;
    this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYearValue);

    if (this.periodYearLabel) {
      this.periodYear = this.periodYearValue;
      this.getListPeriods(this.periodYear);
      this.getListPrdgrps(this.periodYear);
      this.getAllocateGroupCodes(this.periodYear, this.allocateAccountVersionValue);
      this.getAllocateAccounts(this.periodYear);
    }
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
    onPeriodYearChanged: function onPeriodYearChanged(value) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.periodYear = value;
                _this.periodYearLabel = _this.getPeriodYearLabel(_this.periodYears, _this.periodYear); // REFRESH DATA

                _this.periodNameFrom = null;
                _this.periodNameTo = null;
                _this.allocateAccountVersion = null;
                _this.allocateYearId = null;
                _this.prdgrpYearId = null;

                _this.getListPeriods(_this.periodYear);

                _this.getListPrdgrps(_this.periodYear);

                _this.getAllocateGroupCodes(_this.periodYear, _this.allocateAccountVersion);

                _this.getAllocateAccounts(_this.periodYear);

              case 11:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onPrdgrpVersionChanged: function onPrdgrpVersionChanged(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.prdgrpYearId = value;
                _this2.planVersionNo = _this2.getPrdgrpPlanVersionNo(_this2.prdgrpVersions, _this2.prdgrpYearId);

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onAllocateAccountVersionChanged: function onAllocateAccountVersionChanged(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var foundAlcAccVersion;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.allocateAccountVersion = value;

                _this3.getAllocateGroupCodes(_this3.periodYear, _this3.allocateAccountVersion);

                foundAlcAccVersion = _this3.allocateAccountVersions.find(function (item) {
                  return item.version_no == value;
                });
                _this3.allocateYearId = foundAlcAccVersion ? foundAlcAccVersion.allocate_year_id : null;

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getPeriodYearLabel: function getPeriodYearLabel(periodYears, periodYear) {
      var foundPeriodYear = null;

      if (periodYears && periodYear) {
        if (periodYears.length > 0) {
          foundPeriodYear = periodYears.find(function (item) {
            return item.period_year_value == periodYear;
          });
        }
      }

      return foundPeriodYear ? foundPeriodYear.period_year_label : "";
    },
    getPrdgrpPlanVersionNo: function getPrdgrpPlanVersionNo(prdgrpVersions, prdgrpYearIdValue) {
      var result = null;

      if (prdgrpYearIdValue) {
        var foundPrdgrp = prdgrpVersions.find(function (item) {
          return item.prdgrp_year_id == prdgrpYearIdValue;
        });
        result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
      }

      return result;
    },
    getPeriodNameLabel: function getPeriodNameLabel(periodNames, periodName) {
      var result = null;

      if (periodName) {
        var foundPeriodName = periodNames.find(function (item) {
          return item.period_name == periodName;
        });
        result = foundPeriodName ? foundPeriodName.thai_month : "";
      }

      return result;
    },
    getAllocateGroupLevel: function getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
      var foundAllocateGroup = listAllocateGroups.find(function (item) {
        return item.allocate_group == allocateGroupValue;
      });
      return foundAllocateGroup ? foundAllocateGroup.level_no : "";
    },
    getAllocateGroupLabel: function getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
      var foundAllocateGroup = listAllocateGroups.find(function (item) {
        return item.allocate_group == allocateGroupValue;
      });
      return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
    },
    getListStdcostYears: function getListStdcostYears() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var params, foundPeriodYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                // show loading
                _this4.isLoading = true; // REFRESH DATA

                _this4.stdcostYears = [];
                _this4.selectedStdcostYear = null;
                params = {
                  period_year: _this4.periodYear,
                  allocate_account_version: _this4.allocateAccountVersion,
                  allocate_group: _this4.allocateGroup,
                  prdgrp_year_id: _this4.prdgrpYearId
                };
                foundPeriodYear = null;

                if (_this4.periodYearOptions && _this4.periodYear) {
                  if (_this4.periodYearOptions.length > 0) {
                    foundPeriodYear = _this4.periodYearOptions.find(function (item) {
                      return item.period_year_value == _this4.periodYear;
                    });
                  }
                } // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE


                if (!foundPeriodYear) {
                  _context4.next = 11;
                  break;
                }

                _context4.next = 9;
                return axios.get("/ajax/ct/std-costs/list-years", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E02\u0E2D\u0E07\u0E1B\u0E35\u0E1B\u0E31\u0E0D\u0E0A\u0E35 \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this4.stdcostYears = resData.stdcost_years ? JSON.parse(resData.stdcost_years) : null;
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E02\u0E2D\u0E07\u0E1B\u0E35\u0E1B\u0E31\u0E0D\u0E0A\u0E35 \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(error.message), "error");
                  return;
                });

              case 9:
                _context4.next = 12;
                break;

              case 11:
                swal("เกิดข้อผิดพลาด", "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19", "error");

              case 12:
                // hide loading
                _this4.isLoading = false;

              case 13:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getListPeriods: function getListPeriods(periodYear) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var resultData, params, foundPeriodYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                resultData = null; // show loading

                _this5.isLoading = true;
                params = {
                  period_year: periodYear
                };
                foundPeriodYear = null;

                if (_this5.periodYearOptions && periodYear) {
                  if (_this5.periodYearOptions.length > 0) {
                    foundPeriodYear = _this5.periodYearOptions.find(function (item) {
                      return item.period_year_value == periodYear;
                    });
                  }
                }

                if (!foundPeriodYear) {
                  _context5.next = 9;
                  break;
                }

                _context5.next = 8;
                return axios.get("/ajax/ct/std-costs/list-periods", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E14\u0E37\u0E2D\u0E19\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E02\u0E2D\u0E07\u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this5.periodNames = resData.periods ? JSON.parse(resData.periods) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E14\u0E37\u0E2D\u0E19\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E02\u0E2D\u0E07\u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 8:
                resultData = _context5.sent;

              case 9:
                // hide loading
                _this5.isLoading = false;
                return _context5.abrupt("return", resultData);

              case 11:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getListPrdgrps: function getListPrdgrps(periodYear) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var resultData, params, foundPeriodYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                resultData = null; // show loading

                _this6.isLoading = true;
                params = {
                  period_year: periodYear,
                  only_exist: true
                };
                foundPeriodYear = null;

                if (_this6.periodYearOptions && periodYear) {
                  if (_this6.periodYearOptions.length > 0) {
                    foundPeriodYear = _this6.periodYearOptions.find(function (item) {
                      return item.period_year_value == periodYear;
                    });
                  }
                }

                if (!foundPeriodYear) {
                  _context6.next = 9;
                  break;
                }

                _context6.next = 8;
                return axios.get("/ajax/ct/std-costs/list-prdgrps", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this6.prdgrpVersions = resData.prdgrps ? JSON.parse(resData.prdgrps) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 8:
                resultData = _context6.sent;

              case 9:
                // hide loading
                _this6.isLoading = false;
                return _context6.abrupt("return", resultData);

              case 11:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getAllocateGroupCodes: function getAllocateGroupCodes(periodYear, versionNo) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var resultData, params, foundPeriodYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                resultData = null; // show loading

                _this7.isLoading = true;
                params = {
                  period_year: periodYear,
                  version_no: versionNo,
                  only_exist: true
                };
                foundPeriodYear = null;

                if (_this7.periodYearOptions && periodYear) {
                  if (_this7.periodYearOptions.length > 0) {
                    foundPeriodYear = _this7.periodYearOptions.find(function (item) {
                      return item.period_year_value == periodYear;
                    });
                  }
                }

                if (!foundPeriodYear) {
                  _context7.next = 9;
                  break;
                }

                _context7.next = 8;
                return axios.get("/ajax/ct/std-costs/allocate-group-codes", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2B\u0E19\u0E48\u0E27\u0E22\u0E07\u0E32\u0E19\u0E17\u0E35\u0E48\u0E1B\u0E31\u0E19 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this7.allocateGroupCodes = resData.allocate_group_codes ? JSON.parse(resData.allocate_group_codes) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2B\u0E19\u0E48\u0E27\u0E22\u0E07\u0E32\u0E19\u0E17\u0E35\u0E48\u0E1B\u0E31\u0E19 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 8:
                resultData = _context7.sent;

              case 9:
                // hide loading
                _this7.isLoading = false;
                return _context7.abrupt("return", resultData);

              case 11:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    getAllocateAccounts: function getAllocateAccounts(periodYear) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var resultData, params, foundPeriodYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                resultData = null; // show loading

                _this8.isLoading = true;
                params = {
                  period_year: periodYear,
                  only_exist: true
                };
                foundPeriodYear = null;

                if (_this8.periodYearOptions && periodYear) {
                  if (_this8.periodYearOptions.length > 0) {
                    foundPeriodYear = _this8.periodYearOptions.find(function (item) {
                      return item.period_year_value == periodYear;
                    });
                  }
                }

                if (!foundPeriodYear) {
                  _context8.next = 9;
                  break;
                }

                _context8.next = 8;
                return axios.get("/ajax/ct/std-costs/allocate-accounts", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E01\u0E13\u0E11\u0E4C\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(resData.message), "error");
                  } else {
                    _this8.allocateAccountVersions = resData.allocate_account_versions ? JSON.parse(resData.allocate_account_versions) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E40\u0E01\u0E13\u0E11\u0E4C\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48 \u0E1B\u0E35 ".concat(periodYear, " | ").concat(error.message), "error");
                  return;
                });

              case 8:
                resultData = _context8.sent;

              case 9:
                // hide loading
                _this8.isLoading = false;
                return _context8.abrupt("return", resultData);

              case 11:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    onSelectStdcostYearVersion: function onSelectStdcostYearVersion(stdcostYear) {
      this.selectedStdcostYear = stdcostYear;
      this.onSearchStdcostVersion();
    },
    onSearchStdcostVersion: function onSearchStdcostVersion() {
      this.$modal.hide(this.modalName);
      this.$emit("onSearchStdcostVersion", {
        stdcost_year: this.selectedStdcostYear,
        allocate_group: this.allocateGroup
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableStdCostTargets__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TableStdCostTargets */ "./resources/js/components/ct/std-costs/TableStdCostTargets.vue");


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "planVersionNoValue", "stdcostYear", "stdcostAccounts", "allocateTypes", "listAllocateGroups", "listAllAllocateGroupCodes", "listDeptAllocateGroupCodes", "listCostAllocateGroupCodes", "listProductAllocateGroupCodes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default()),
    TableStdCostTargets: _TableStdCostTargets__WEBPACK_IMPORTED_MODULE_5__.default
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    planVersionNoValue: function planVersionNoValue(value) {
      this.planVersionNo = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostAccounts: function stdcostAccounts(value) {
      var _this = this;

      this.stdcostAccountItems = value.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this.getAllocateTypeLabel(_this.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      });
      this.deptStdcostAccountItems = value.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this.getAllocateTypeLabel(_this.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      });
      this.costStdcostAccountItems = value.filter(function (item) {
        return item.allocate_group == "COST";
      }).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this.getAllocateTypeLabel(_this.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      });
      this.productStdcostAccountItems = value.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this.getAllocateTypeLabel(_this.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      });
    }
  },
  data: function data() {
    var _this2 = this;

    return {
      periodYear: this.periodYearValue,
      planVersionNo: this.planVersionNoValue,
      isTableDeptActive: true,
      isTableCostActive: false,
      isTableProductActive: false,
      isTableDeptShowTargets: false,
      isTableCostShowTargets: false,
      isTableProductShowTargets: false,
      selectedDeptAllocateGroupCode: "",
      selectedCostAllocateGroupCode: "",
      selectedProductAllocateGroupCode: "",
      filterAllAllocateGroupCode: "ALL_DEPT",
      filterDeptAllocateGroupCode: "",
      filterCostAllocateGroupCode: "",
      filterProductAllocateGroupCode: "",
      stdcostYearData: this.stdcostYear,
      stdcostAccountItems: this.stdcostAccounts.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this2.getAllocateTypeLabel(_this2.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      }),
      deptStdcostAccountItems: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this2.getAllocateTypeLabel(_this2.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      }),
      costStdcostAccountItems: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this2.getAllocateTypeLabel(_this2.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      }),
      productStdcostAccountItems: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              reason_name: accItem.reason_name ? accItem.reason_name : "",
              estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
              allocate_type_label: _this2.getAllocateTypeLabel(_this2.allocateTypes, accItem.allocate_type),
              is_show: true,
              is_show_targets: false,
              marked_as_deleted: false
            });
          })
        });
      }),
      stdcostTargets: [],
      totalEstimateExpenseAmount: this.stdcostAccounts.reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      deptTotalActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
      }, 0),
      deptTotalAvgActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
      }, 0),
      deptTotalBudgetAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
      }, 0),
      deptTotalEstimateExpenseAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      costTotalActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
      }, 0),
      costTotalAvgActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
      }, 0),
      costTotalBudgetAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
      }, 0),
      costTotalEstimateExpenseAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      productTotalActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
      }, 0),
      productTotalAvgActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
      }, 0),
      productTotalBudgetAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
      }, 0),
      productTotalEstimateExpenseAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      deptSumFilteredActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
      }, 0),
      deptSumFilteredAvgActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
      }, 0),
      deptSumFilteredBudgetAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
      }, 0),
      deptSumFilteredEstimateExpenseAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "DEPT";
      }).reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      costSumFilteredActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
      }, 0),
      costSumFilteredAvgActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
      }, 0),
      costSumFilteredBudgetAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
      }, 0),
      costSumFilteredEstimateExpenseAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "COST";
      }).reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      productSumFilteredActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
      }, 0),
      productSumFilteredAvgActualAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
      }, 0),
      productSumFilteredBudgetAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
      }, 0),
      productSumFilteredEstimateExpenseAmount: this.stdcostAccounts.filter(function (item) {
        return item.allocate_group == "PRODUCT";
      }).reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      isLoading: false
    };
  },
  mounted: function mounted() {// this.emitStdcostAccountsChanged();
  },
  computed: {},
  methods: {
    toggleShowTable: function toggleShowTable(showTable) {
      var _this3 = this;

      this.isTableDeptActive = false;
      this.isTableCostActive = false;
      this.isTableProductActive = false;
      this.deptStdcostAccountItems = this.deptStdcostAccountItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              is_show: true,
              is_show_targets: false
            });
          })
        });
      });
      this.costStdcostAccountItems = this.costStdcostAccountItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              is_show: true,
              is_show_targets: false
            });
          })
        });
      });
      this.productStdcostAccountItems = this.productStdcostAccountItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            return _objectSpread(_objectSpread({}, accItem), {}, {
              is_show: true,
              is_show_targets: false
            });
          })
        });
      });
      this.$nextTick(function () {
        if (showTable == 'DEPT') {
          _this3.isTableDeptActive = true;
        }

        if (showTable == 'COST') {
          _this3.isTableCostActive = true;
        }

        if (showTable == 'PRODUCT') {
          _this3.isTableProductActive = true;
        }
      });
    },
    onGetStdcostTargets: function onGetStdcostTargets(stdcostAccountItem) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var resValidate, toggleShowTargets;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                resValidate = _this4.validateBeforeGetTargets(stdcostAccountItem);

                if (!resValidate.valid) {
                  _context.next = 20;
                  break;
                }

                _this4.stdcostTargets = [];
                toggleShowTargets = !stdcostAccountItem.is_show_targets;
                stdcostAccountItem.is_show_targets = toggleShowTargets;

                if (stdcostAccountItem.allocate_group == "DEPT") {
                  _this4.deptStdcostAccountItems = _this4.deptStdcostAccountItems.map(function (item) {
                    return _objectSpread(_objectSpread({}, item), {}, {
                      account_items: item.account_items.map(function (accItem) {
                        return _objectSpread(_objectSpread({}, accItem), {}, {
                          is_show_targets: accItem.target_account_code == stdcostAccountItem.target_account_code ? accItem.is_show_targets : false
                        });
                      })
                    });
                  });
                } else if (stdcostAccountItem.allocate_group == "COST") {
                  _this4.costStdcostAccountItems = _this4.costStdcostAccountItems.map(function (item) {
                    return _objectSpread(_objectSpread({}, item), {}, {
                      account_items: item.account_items.map(function (accItem) {
                        return _objectSpread(_objectSpread({}, accItem), {}, {
                          is_show_targets: accItem.target_account_code == stdcostAccountItem.target_account_code ? accItem.is_show_targets : false
                        });
                      })
                    });
                  });
                } else if (stdcostAccountItem.allocate_group == "PRODUCT") {
                  _this4.productStdcostAccountItems = _this4.productStdcostAccountItems.map(function (item) {
                    return _objectSpread(_objectSpread({}, item), {}, {
                      account_items: item.account_items.map(function (accItem) {
                        return _objectSpread(_objectSpread({}, accItem), {}, {
                          is_show_targets: accItem.target_account_code == stdcostAccountItem.target_account_code ? accItem.is_show_targets : false
                        });
                      })
                    });
                  });
                }

                _this4.isTableDeptShowTargets = false;
                _this4.isTableCostShowTargets = false;
                _this4.isTableProductShowTargets = false;
                _this4.selectedDeptAllocateGroupCode = "";
                _this4.selectedCostAllocateGroupCode = "";
                _this4.selectedProductAllocateGroupCode = "";

                if (!toggleShowTargets) {
                  _context.next = 18;
                  break;
                }

                if (stdcostAccountItem.allocate_group == "DEPT") {
                  _this4.isTableDeptShowTargets = true;
                  _this4.selectedDeptAllocateGroupCode = stdcostAccountItem.allocate_group_code;
                }

                if (stdcostAccountItem.allocate_group == "COST") {
                  _this4.isTableCostShowTargets = true;
                  _this4.selectedCostAllocateGroupCode = stdcostAccountItem.allocate_group_code;
                }

                if (stdcostAccountItem.allocate_group == "PRODUCT") {
                  _this4.isTableProductShowTargets = true;
                  _this4.selectedProductAllocateGroupCode = stdcostAccountItem.allocate_group_code;
                }

                _context.next = 18;
                return _this4.getStdcostTargets(_this4.stdcostYearData, stdcostAccountItem);

              case 18:
                _context.next = 21;
                break;

              case 20:
                swal("เกิดข้อผิดพลาด", "".concat(resValidate.message), "error");

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getAllocateTypeLabel: function getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
      var result = "";

      if (listAllocateTypes.length > 0 && allocateTypeValue) {
        var foundAllocateType = listAllocateTypes.find(function (item) {
          return item.allocate_type_value == allocateTypeValue;
        });
        result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
      }

      return result;
    },
    getAllocateGroupLevel: function getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
      var foundAllocateGroup = listAllocateGroups.find(function (item) {
        return item.allocate_group == allocateGroupValue;
      });
      return foundAllocateGroup ? foundAllocateGroup.level_no : "";
    },
    getAllocateGroupLabel: function getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
      var foundAllocateGroup = listAllocateGroups.find(function (item) {
        return item.allocate_group == allocateGroupValue;
      });
      return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
    },
    getStdcostTargets: function getStdcostTargets(stdcostYearData, stdcostAccountItem) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // SHOW LOADING
                _this5.isLoading = true;
                params = {
                  period_year: _this5.periodYear,
                  input_stdcost_year: JSON.stringify(stdcostYearData),
                  input_stdcost_account: JSON.stringify(stdcostAccountItem)
                };
                _context2.next = 4;
                return axios.get("/ajax/ct/std-costs/targets", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this5.stdcostTargets = resData.stdcost_targets ? JSON.parse(resData.stdcost_targets) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this5.isLoading = false;

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    isAllowAddStdcostAccount: function isAllowAddStdcostAccount(stdcostAccounts) {
      var valid = true;
      var incompletedLines = stdcostAccounts.filter(function (item) {
        return item.is_new_line && !item.estimate_expense_amount;
      });

      if (incompletedLines.length > 0) {
        valid = false;
      }

      return valid;
    },
    saveStdcostAccount: function saveStdcostAccount(stdcostAccountItem) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                reqBody = {
                  period_year: _this6.periodYear,
                  input_stdcost_year: JSON.stringify(_this6.stdcostYear),
                  input_stdcost_account: JSON.stringify(stdcostAccountItem)
                }; // SHOW LOADING

                _this6.isLoading = true;
                _context3.next = 4;
                return axios.post("/ajax/ct/std-costs/account", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    var resStdcostAccount = resData.stdcost_account ? JSON.parse(resData.stdcost_account) : null;
                    console.log(resStdcostAccount);
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this6.isLoading = false;

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    saveStdcostAccountExpense: function saveStdcostAccountExpense(stdcostAccountItem) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                reqBody = {
                  period_year: _this7.periodYear,
                  input_stdcost_year: JSON.stringify(_this7.stdcostYear),
                  input_stdcost_account: JSON.stringify(stdcostAccountItem)
                }; // SHOW LOADING

                _this7.isLoading = true;
                resValidate = _this7.validateBeforeSaveAccount(stdcostAccountItem);

                if (!resValidate.valid) {
                  _context4.next = 8;
                  break;
                }

                _context4.next = 6;
                return axios.post("/ajax/ct/std-costs/account-expense", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    var resStdcostAccount = resData.stdcost_account ? JSON.parse(resData.stdcost_account) : null;
                    console.log(resStdcostAccount);
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 6:
                _context4.next = 9;
                break;

              case 8:
                // swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${resValidate.message}`, "error");
                console.log("\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14 : \u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resValidate.message));

              case 9:
                // HIDE LOADING
                _this7.isLoading = false;

              case 10:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    validateBeforeGetTargets: function validateBeforeGetTargets(stdcostAccountItem) {
      var result = {
        valid: true,
        message: ""
      }; // if(!stdcostAccountItem.estimate_expense_amount) {
      //     result.valid = false;
      //     result.message = `กรอกข้อมูลรายการบัญชีที่รับปันไม่ครบถ้วน กรุณาตรวจสอบ`
      // }

      return result;
    },
    validateBeforeSaveAccount: function validateBeforeSaveAccount(stdcostAccountItem) {
      var result = {
        valid: true,
        message: ""
      };

      if (stdcostAccountItem.estimate_expense_amount === undefined || stdcostAccountItem.estimate_expense_amount == null) {
        result.valid = false;
        result.message = "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\" \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      }

      return result;
    },
    onFilterAllAllocateGroupCodeChanged: function onFilterAllAllocateGroupCodeChanged(value) {
      this.filterAllAllocateGroupCode = value;
      var foundAllocateGroupCodeItem = this.listAllAllocateGroupCodes.find(function (item) {
        return item.allocate_group_code_value == value;
      });

      if (foundAllocateGroupCodeItem) {
        this.isTableDeptActive = false;
        this.isTableCostActive = false;
        this.isTableProductActive = false;

        if (foundAllocateGroupCodeItem.allocate_group_code_type == "DEPT") {
          this.isTableDeptActive = true;
          this.onFilterDeptAllocateGroupCodeChanged(value);
        } else if (foundAllocateGroupCodeItem.allocate_group_code_type == "COST") {
          this.isTableCostActive = true;
          this.onFilterCostAllocateGroupCodeChanged(value);
        } else if (foundAllocateGroupCodeItem.allocate_group_code_type == "PRODUCT") {
          this.isTableProductActive = true;
          this.onFilterProductAllocateGroupCodeChanged(value);
        }
      }
    },
    onFilterDeptAllocateGroupCodeChanged: function onFilterDeptAllocateGroupCodeChanged(value) {
      var _this8 = this;

      this.filterDeptAllocateGroupCode = value;
      this.isTableDeptShowTargets = false;
      this.selectedDeptAllocateGroupCode = "";
      this.deptStdcostAccountItems = this.deptStdcostAccountItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            var isShow = _this8.filterDeptAllocateGroupCode == "" || _this8.filterDeptAllocateGroupCode == "ALL_DEPT" || _this8.filterDeptAllocateGroupCode == accItem.allocate_group_code;
            return _objectSpread(_objectSpread({}, accItem), {}, {
              is_show: isShow,
              is_show_targets: false
            });
          })
        });
      });
      this.calFilteredSummaryAmount("DEPT");
    },
    onFilterCostAllocateGroupCodeChanged: function onFilterCostAllocateGroupCodeChanged(value) {
      var _this9 = this;

      this.filterCostAllocateGroupCode = value;
      this.isTableCostShowTargets = false;
      this.selectedCostAllocateGroupCode = "";
      this.costStdcostAccountItems = this.costStdcostAccountItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            var isShow = _this9.filterCostAllocateGroupCode == "" || _this9.filterCostAllocateGroupCode == "ALL_COST" || _this9.filterCostAllocateGroupCode == accItem.allocate_group_code;
            return _objectSpread(_objectSpread({}, accItem), {}, {
              is_show: isShow,
              is_show_targets: false
            });
          })
        });
      });
      this.calFilteredSummaryAmount("COST");
    },
    onFilterProductAllocateGroupCodeChanged: function onFilterProductAllocateGroupCodeChanged(value) {
      var _this10 = this;

      this.filterProductAllocateGroupCode = value;
      this.isTableProductShowTargets = false;
      this.selectedProductAllocateGroupCode = "";
      this.productStdcostAccountItems = this.productStdcostAccountItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          account_items: item.account_items.map(function (accItem) {
            var isShow = _this10.filterProductAllocateGroupCode == "" || _this10.filterProductAllocateGroupCode == "ALL_PRODUCT" || _this10.filterProductAllocateGroupCode == accItem.allocate_group_code;
            return _objectSpread(_objectSpread({}, accItem), {}, {
              is_show: isShow,
              is_show_targets: false
            });
          })
        });
      });
      this.calFilteredSummaryAmount("PRODUCT");
    },
    calTotalSummaryAmount: function calTotalSummaryAmount(allocateGroup) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (allocateGroup == "DEPT") {
                  _this11.deptTotalActualAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "DEPT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
                  }, 0);
                  _this11.deptTotalAvgActualAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "DEPT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
                  }, 0);
                  _this11.deptTotalBudgetAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "DEPT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
                  }, 0);
                  _this11.deptTotalEstimateExpenseAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "DEPT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                  }, 0);
                }

                if (allocateGroup == "COST") {
                  _this11.costTotalActualAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "COST";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
                  }, 0);
                  _this11.costTotalAvgActualAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "COST";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
                  }, 0);
                  _this11.costTotalBudgetAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "COST";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
                  }, 0);
                  _this11.costTotalEstimateExpenseAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "COST";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                  }, 0);
                }

                if (allocateGroup == "PRODUCT") {
                  _this11.productTotalActualAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "PRODUCT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
                  }, 0);
                  _this11.productTotalAvgActualAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "PRODUCT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
                  }, 0);
                  _this11.productTotalBudgetAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "PRODUCT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
                  }, 0);
                  _this11.productTotalEstimateExpenseAmount = _this11.stdcostAccounts.filter(function (item) {
                    return item.allocate_group == "PRODUCT";
                  }).reduce(function (pv, cv) {
                    return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                  }, 0);
                }

              case 3:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    calFilteredSummaryAmount: function calFilteredSummaryAmount(allocateGroup) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                if (allocateGroup == "DEPT") {
                  if (!_this12.filterDeptAllocateGroupCode || _this12.filterDeptAllocateGroupCode == "ALL_DEPT") {
                    _this12.deptSumFilteredActualAmount = _this12.deptTotalActualAmount;
                    _this12.deptSumFilteredAvgActualAmount = _this12.deptTotalAvgActualAmount;
                    _this12.deptSumFilteredBudgetAmount = _this12.deptTotalBudgetAmount;
                    _this12.deptSumFilteredEstimateExpenseAmount = _this12.deptTotalEstimateExpenseAmount;
                  } else {
                    _this12.deptSumFilteredActualAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "DEPT" && item.allocate_group_code == _this12.filterDeptAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
                    }, 0);
                    _this12.deptSumFilteredAvgActualAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "DEPT" && item.allocate_group_code == _this12.filterDeptAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
                    }, 0);
                    _this12.deptSumFilteredBudgetAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "DEPT" && item.allocate_group_code == _this12.filterDeptAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
                    }, 0);
                    _this12.deptSumFilteredEstimateExpenseAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "DEPT" && item.allocate_group_code == _this12.filterDeptAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                    }, 0);
                  }
                }

                if (allocateGroup == "COST") {
                  if (!_this12.filterCostAllocateGroupCode || _this12.filterCostAllocateGroupCode == "ALL_COST") {
                    _this12.costSumFilteredActualAmount = _this12.costTotalActualAmount;
                    _this12.costSumFilteredAvgActualAmount = _this12.costTotalAvgActualAmount;
                    _this12.costSumFilteredBudgetAmount = _this12.costTotalBudgetAmount;
                    _this12.costSumFilteredEstimateExpenseAmount = _this12.costTotalEstimateExpenseAmount;
                  } else {
                    _this12.costSumFilteredActualAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "COST" && item.allocate_group_code == _this12.filterCostAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
                    }, 0);
                    _this12.costSumFilteredAvgActualAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "COST" && item.allocate_group_code == _this12.filterCostAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
                    }, 0);
                    _this12.costSumFilteredBudgetAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "COST" && item.allocate_group_code == _this12.filterCostAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
                    }, 0);
                    _this12.costSumFilteredEstimateExpenseAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "COST" && item.allocate_group_code == _this12.filterCostAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                    }, 0);
                  }
                }

                if (allocateGroup == "PRODUCT") {
                  if (!_this12.filterProductAllocateGroupCode || _this12.filterProductAllocateGroupCode == "ALL_PRODUCT") {
                    _this12.productSumFilteredActualAmount = _this12.productTotalActualAmount;
                    _this12.productSumFilteredAvgActualAmount = _this12.productTotalAvgActualAmount;
                    _this12.productSumFilteredBudgetAmount = _this12.productTotalBudgetAmount;
                    _this12.productSumFilteredEstimateExpenseAmount = _this12.productTotalEstimateExpenseAmount;
                  } else {
                    _this12.productSumFilteredActualAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "PRODUCT" && item.allocate_group_code == _this12.filterProductAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0);
                    }, 0);
                    _this12.productSumFilteredAvgActualAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "PRODUCT" && item.allocate_group_code == _this12.filterProductAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0);
                    }, 0);
                    _this12.productSumFilteredBudgetAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "PRODUCT" && item.allocate_group_code == _this12.filterProductAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0);
                    }, 0);
                    _this12.productSumFilteredEstimateExpenseAmount = _this12.stdcostAccounts.filter(function (item) {
                      return item.allocate_group == "PRODUCT" && item.allocate_group_code == _this12.filterProductAllocateGroupCode;
                    }).reduce(function (pv, cv) {
                      return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                    }, 0);
                  }
                }

              case 3:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onStdcostAccountEstimateExpenseAmountChanged: function onStdcostAccountEstimateExpenseAmountChanged(stdCostAccountItem, accountItem) {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var sumStdCostAccountEstimateExpenseAmount, mainStdcostAccountItem;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                sumStdCostAccountEstimateExpenseAmount = stdCostAccountItem.account_items.reduce(function (pv, cv) {
                  return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
                }, 0);
                stdCostAccountItem.estimate_expense_amount = sumStdCostAccountEstimateExpenseAmount;
                mainStdcostAccountItem = _this13.stdcostAccounts.find(function (item) {
                  return item.allocate_group == stdCostAccountItem.allocate_group && item.allocate_group_code == stdCostAccountItem.allocate_group_code;
                });

                if (mainStdcostAccountItem) {
                  mainStdcostAccountItem.estimate_expense_amount = sumStdCostAccountEstimateExpenseAmount;
                }

                _context7.next = 6;
                return _this13.saveStdcostAccountExpense(accountItem);

              case 6:
                if (accountItem.is_show_targets) {
                  _this13.onGetStdcostTargets(accountItem);
                }

                _this13.calTotalSummaryAmount(accountItem.allocate_group);

                _this13.calFilteredSummaryAmount(accountItem.allocate_group); // this.emitStdcostAccountsChanged();


              case 9:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onStdcostAccountReasonNameChanged: function onStdcostAccountReasonNameChanged(accountItem) {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                _context8.next = 2;
                return _this14.saveStdcostAccount(accountItem);

              case 2:
                if (accountItem.is_show_targets) {
                  _this14.onGetStdcostTargets(accountItem);
                } // this.emitStdcostAccountsChanged();


              case 3:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    onStdcostTargetsChanged: function onStdcostTargetsChanged(data) {
      this.stdcostTargets = data.stdcostTargets;
    },
    emitStdcostAccountsChanged: function emitStdcostAccountsChanged() {
      this.$emit("onStdcostAccountsChanged", {
        stdcostAccounts: this.stdcostAccountItems
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
    onExportExcel: function onExportExcel() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var foundAllocateGroupCodeItem, allocateGroup, allocateGroupCode, reportItems, reportSummaryItem, reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                // let reportItems = [];
                foundAllocateGroupCodeItem = _this15.listAllAllocateGroupCodes.find(function (item) {
                  return item.allocate_group_code_value == _this15.filterAllAllocateGroupCode;
                });
                allocateGroup = foundAllocateGroupCodeItem ? foundAllocateGroupCodeItem.allocate_group_code_type : "DEPT";
                allocateGroupCode = foundAllocateGroupCodeItem ? foundAllocateGroupCodeItem.allocate_group_code_value : "ALL_DEPT";
                reportItems = allocateGroup == "DEPT" ? _this15.deptStdcostAccountItems : _this15.costStdcostAccountItems;
                reportSummaryItem = {
                  actual_amount: allocateGroup == "DEPT" ? _this15.deptSumFilteredActualAmount : _this15.costSumFilteredActualAmount,
                  avg_actual_amount: allocateGroup == "DEPT" ? _this15.deptSumFilteredAvgActualAmount : _this15.costSumFilteredAvgActualAmount,
                  budget_amount: allocateGroup == "DEPT" ? _this15.deptSumFilteredBudgetAmount : _this15.costSumFilteredBudgetAmount,
                  estimate_expense_amount: allocateGroup == "DEPT" ? _this15.deptSumFilteredEstimateExpenseAmount : _this15.costSumFilteredEstimateExpenseAmount
                };
                reqBody = {
                  period_year: _this15.periodYear,
                  version_no: _this15.stdcostYearData.version_no,
                  plan_version_no: _this15.planVersionNo,
                  period_name_from: _this15.stdcostYearData.period_name_from,
                  period_name_to: _this15.stdcostYearData.period_name_to,
                  allocate_group: allocateGroup,
                  allocate_group_code: allocateGroupCode,
                  list_all_allocate_group_codes: JSON.stringify(_this15.listAllAllocateGroupCodes),
                  stdcost_year: JSON.stringify(_this15.stdcostYearData),
                  report_items: JSON.stringify(reportItems),
                  report_summary_item: JSON.stringify(reportSummaryItem)
                }; // show loading

                _this15.isLoading = true; // CALL SAVE BEFORE SUBMIT APPROVAL

                _context9.next = 9;
                return axios.post("/ajax/ct/std-costs/export", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1E\u0E34\u0E21\u0E1E\u0E4C\u0E23\u0E32\u0E22\u0E07\u0E32\u0E19 | ".concat(resMsg), "error");
                  } else {
                    window.open("/ct/files/download/ct/std-costs/export/excel/".concat(resData.file_name), '_blank');
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                });

              case 9:
                // hide loading
                _this15.isLoading = false;

              case 10:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=script&lang=js& ***!
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "allocateGroupValue", "stdcostYear", "stdcostAccount", "stdcostTargets"],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    allocateGroupValue: function allocateGroupValue(value) {
      this.allocateGroup = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostAccount: function stdcostAccount(value) {
      this.stdcostAccountData = value;
    },
    stdcostTargets: function stdcostTargets(value) {
      this.stdcostTargetItems = value;
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      allocateGroup: this.allocateGroupValue,
      stdcostYearData: this.stdcostYear,
      stdcostAccountData: this.stdcostAccount,
      stdcostTargetItems: this.stdcostTargets
    };
  },
  mounted: function mounted() {// this.emitStdcostTargetsChanged();
  },
  computed: {},
  methods: {
    saveStdcostTarget: function saveStdcostTarget(stdcostAccountItem, stdcostTargets, stdcostTargetItem) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var reqBody, resValidate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                reqBody = {
                  period_year: _this.periodYearData,
                  input_stdcost_year: JSON.stringify(_this.stdcostYearData),
                  input_stdcost_account: JSON.stringify(stdcostAccountItem),
                  input_stdcost_target: JSON.stringify(stdcostTargetItem)
                }; // show loading

                _this.isLoading = true;
                resValidate = _this.validateBeforeSaveTarget(stdcostAccountItem, stdcostTargets, stdcostTargetItem);

                if (!resValidate.valid) {
                  _context.next = 8;
                  break;
                }

                _context.next = 6;
                return axios.post("/ajax/ct/std-costs/target", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {// swal("Success", `บันทึกข้อมูล )`, "success");
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 6:
                _context.next = 9;
                break;

              case 8:
                swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resValidate.message), "error");

              case 9:
                // hide loading
                _this.isLoading = false;

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    validateBeforeSaveTarget: function validateBeforeSaveTarget(stdcostAccountItem, stdcostTargets, stdcostTargetItem) {
      var result = {
        valid: true,
        message: ""
      }; // IF NEW LINE ISN'T COMPLETED

      if (!stdcostAccountItem.quantity || !stdcostAccountItem.ratio_rate) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E40\u0E1B\u0E49\u0E32\u0E2B\u0E21\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E44\u0E21\u0E48\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      } // IF NEW LINE ISN'T COMPLETED


      if (!stdcostTargetItem.quantity || !stdcostTargetItem.ratio_rate) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E40\u0E1B\u0E49\u0E32\u0E2B\u0E21\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E44\u0E21\u0E48\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      } // VALIDATE TOTAL "quantity"


      var totalQty = stdcostTargets.reduce(function (previousValue, item) {
        return previousValue + parseFloat(item.quantity);
      }, 0);

      if (totalQty > parseFloat(stdcostAccountItem.quantity)) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2A\u0E31\u0E14\u0E2A\u0E48\u0E27\u0E19\u0E40\u0E1B\u0E49\u0E32\u0E2B\u0E21\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      } // VALIDATE TOTAL "ratio_rate"


      var totalRatioRate = stdcostTargets.reduce(function (previousValue, item) {
        return previousValue + parseFloat(item.ratio_rate);
      }, 0);

      if (totalRatioRate > parseFloat(stdcostAccountItem.ratio_rate)) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 % \u0E40\u0E1B\u0E49\u0E32\u0E2B\u0E21\u0E32\u0E22\u0E01\u0E32\u0E23\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      }

      return result;
    },
    onStdcostTargetQuantityChanged: function onStdcostTargetQuantityChanged(stdcostTargetItem) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return _this2.saveStdcostTarget(_this2.stdcostAccountData, _this2.stdcostTargetItems, stdcostTargetItem);

              case 2:
                _this2.emitStdcostTargetsChanged();

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onStdcostTargetRatioRateChanged: function onStdcostTargetRatioRateChanged(stdcostTargetItem) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this3.saveStdcostTarget(_this3.stdcostAccountData, _this3.stdcostTargetItems, stdcostTargetItem);

              case 2:
                _this3.emitStdcostTargetsChanged();

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    emitStdcostTargetsChanged: function emitStdcostTargetsChanged() {
      this.$emit("onStdcostTargetsChanged", {
        stdcostTargets: this.stdcostTargetItems
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
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-00cb8f5e] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n.vm--overlay[data-modal=\"modal-search-allocate-year\"][data-v-00cb8f5e] {\n  height: 100% !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_style_index_0_id_00cb8f5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_style_index_0_id_00cb8f5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_style_index_0_id_00cb8f5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/std-costs/Index.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/ct/std-costs/Index.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_d7c9cb28___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=d7c9cb28& */ "./resources/js/components/ct/std-costs/Index.vue?vue&type=template&id=d7c9cb28&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-costs/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_d7c9cb28___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_d7c9cb28___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-costs/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/ModalSearchStdcost.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearchStdcost_vue_vue_type_template_id_00cb8f5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true& */ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true&");
/* harmony import */ var _ModalSearchStdcost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearchStdcost.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSearchStdcost_vue_vue_type_style_index_0_id_00cb8f5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css& */ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSearchStdcost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearchStdcost_vue_vue_type_template_id_00cb8f5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearchStdcost_vue_vue_type_template_id_00cb8f5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "00cb8f5e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-costs/ModalSearchStdcost.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-costs/TableStdCostAccounts.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/TableStdCostAccounts.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableStdCostAccounts_vue_vue_type_template_id_2210113e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableStdCostAccounts.vue?vue&type=template&id=2210113e& */ "./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=template&id=2210113e&");
/* harmony import */ var _TableStdCostAccounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableStdCostAccounts.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableStdCostAccounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableStdCostAccounts_vue_vue_type_template_id_2210113e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableStdCostAccounts_vue_vue_type_template_id_2210113e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-costs/TableStdCostAccounts.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-costs/TableStdCostTargets.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/TableStdCostTargets.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableStdCostTargets_vue_vue_type_template_id_b68b364c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableStdCostTargets.vue?vue&type=template&id=b68b364c& */ "./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=template&id=b68b364c&");
/* harmony import */ var _TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableStdCostTargets.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableStdCostTargets_vue_vue_type_template_id_b68b364c___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableStdCostTargets_vue_vue_type_template_id_b68b364c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-costs/TableStdCostTargets.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-costs/Index.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/Index.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchStdcost.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostAccounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostAccounts.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostAccounts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostTargets.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css&":
/*!******************************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css& ***!
  \******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_style_index_0_id_00cb8f5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=style&index=0&id=00cb8f5e&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ct/std-costs/Index.vue?vue&type=template&id=d7c9cb28&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/Index.vue?vue&type=template&id=d7c9cb28& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_d7c9cb28___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_d7c9cb28___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_d7c9cb28___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=d7c9cb28& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/Index.vue?vue&type=template&id=d7c9cb28&");


/***/ }),

/***/ "./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_template_id_00cb8f5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_template_id_00cb8f5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchStdcost_vue_vue_type_template_id_00cb8f5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=template&id=2210113e&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=template&id=2210113e& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostAccounts_vue_vue_type_template_id_2210113e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostAccounts_vue_vue_type_template_id_2210113e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostAccounts_vue_vue_type_template_id_2210113e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostAccounts.vue?vue&type=template&id=2210113e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=template&id=2210113e&");


/***/ }),

/***/ "./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=template&id=b68b364c&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=template&id=b68b364c& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_template_id_b68b364c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_template_id_b68b364c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_template_id_b68b364c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostTargets.vue?vue&type=template&id=b68b364c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=template&id=b68b364c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/Index.vue?vue&type=template&id=d7c9cb28&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/Index.vue?vue&type=template&id=d7c9cb28& ***!
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
    { staticClass: "ibox" },
    [
      _c(
        "div",
        {
          staticClass: "ibox-content tw-pt-10",
          staticStyle: { "min-height": "600px" }
        },
        [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-4" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                  },
                  [_vm._v(" ปีบัญชีงบประมาณ ")]
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
                        "select-options": _vm.periodYears,
                        "option-key": "period_year_value",
                        "option-value": "period_year_value",
                        "option-label": "period_year_label",
                        value: _vm.periodYear,
                        filterable: true
                      },
                      on: { onSelected: _vm.onPeriodYearChanged }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                  },
                  [_vm._v(" เกณฑ์การปันส่วนครั้งที่ ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-8" },
                  [
                    _c("pm-el-select", {
                      attrs: {
                        name: "allocate_account_version",
                        id: "input_allocate_account_version",
                        "select-options": _vm.allocateAccountVersions,
                        "option-key": "version_no",
                        "option-value": "version_no",
                        "option-label": "version_no",
                        value: _vm.allocateAccountVersion,
                        filterable: true
                      },
                      on: { onSelected: _vm.onAllocateAccountVersionChanged }
                    })
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-8" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _c("div", { staticClass: "row form-group" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                      },
                      [_vm._v(" แผนการผลิตครั้งที่ ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-8" },
                      [
                        _c("pm-el-select", {
                          attrs: {
                            name: "prdgrp_year_id",
                            id: "input_prdgrp_year_id",
                            "select-options": _vm.prdgrpVersions,
                            "option-key": "prdgrp_year_id",
                            "option-value": "prdgrp_year_id",
                            "option-label": "plan_version_no",
                            value: _vm.prdgrpYearId,
                            filterable: true
                          },
                          on: { onSelected: _vm.onPrdgrpVersionChanged }
                        })
                      ],
                      1
                    )
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _c("div", { staticClass: "row form-group" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                      },
                      [_vm._v(" เปรียบเทียบค่าใช้จ่ายจริงจาก ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-8" },
                      [
                        _c("pm-el-select", {
                          attrs: {
                            name: "period_name_from",
                            id: "input_period_name_from",
                            "select-options": _vm.periodNameFroms,
                            "option-key": "period_name_value",
                            "option-value": "period_name_value",
                            "option-label": "period_name_label",
                            value: _vm.periodNameFrom,
                            filterable: true
                          },
                          on: { onSelected: _vm.onPeriodNameFromChanged }
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
                      {
                        staticClass:
                          "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                      },
                      [_vm._v(" ถึง ")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-8" },
                      [
                        _c("pm-el-select", {
                          attrs: {
                            name: "period_name_to",
                            id: "input_period_name_to",
                            "select-options": _vm.periodNameTos,
                            "option-key": "period_name_value",
                            "option-value": "period_name_value",
                            "option-label": "period_name_label",
                            value: _vm.periodNameTo,
                            filterable: true
                          },
                          on: { onSelected: _vm.onPeriodNameToChanged }
                        })
                      ],
                      1
                    )
                  ])
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "text-right" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-inline-block btn-white tw-w-32",
                on: {
                  click: function($event) {
                    return _vm.$modal.show("modal-search-stdcost")
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-search tw-mr-1" }),
                _vm._v(" ค้นหา \n            ")
              ]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-inline-block btn-primary tw-w-52",
                attrs: {
                  disabled:
                    !_vm.periodYear ||
                    !_vm.prdgrpYearId ||
                    !_vm.allocateAccountVersion ||
                    !_vm.periodNameFrom ||
                    !_vm.periodNameTo
                },
                on: {
                  click: function($event) {
                    return _vm.onGenerateStdcostYearData(
                      _vm.periodYear,
                      _vm.prdgrpYearId,
                      _vm.allocateAccountVersion,
                      _vm.allocateYearId,
                      _vm.periodNameFrom,
                      _vm.periodNameTo
                    )
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-arrow-down" }),
                _vm._v(" ดึงข้อมูลงบทดลอง\n            ")
              ]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-inline-block btn-danger tw-w-32",
                attrs: { href: "/ct/std-costs" }
              },
              [_vm._v(" ล้าง ")]
            )
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _vm.showTableStdcostAccounts
            ? _c("div", { staticClass: "row tw-mb-5" }, [
                _c(
                  "div",
                  { staticClass: "col-12" },
                  [
                    _c("table-std-cost-accounts", {
                      attrs: {
                        "period-year-value": _vm.periodYear,
                        "plan-version-no-value": _vm.planVersionNo,
                        "stdcost-year": _vm.stdcostYear,
                        "stdcost-accounts": _vm.stdcostAccounts,
                        "allocate-types": _vm.allocateTypes,
                        "list-allocate-groups": _vm.listAllocateGroups,
                        "list-all-allocate-group-codes":
                          _vm.listAllAllocateGroupCodes,
                        "list-dept-allocate-group-codes":
                          _vm.listDeptAllocateGroupCodes,
                        "list-cost-allocate-group-codes":
                          _vm.listCostAllocateGroupCodes,
                        "list-product-allocate-group-codes":
                          _vm.listProductAllocateGroupCodes
                      },
                      on: {
                        onStdcostAccountsChanged: _vm.onStdcostAccountsChanged
                      }
                    })
                  ],
                  1
                )
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
      _c("modal-search-stdcost", {
        attrs: {
          "modal-name": "modal-search-stdcost",
          "modal-width": "1024",
          "modal-height": "auto",
          "organization-code": _vm.organizationCode,
          "period-years": _vm.existPeriodYearOptions,
          "period-year-value": _vm.periodYear,
          "list-allocate-groups": _vm.listAllocateGroups
        },
        on: { onSearchStdcostVersion: _vm.onSearchStdcostVersion }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/ModalSearchStdcost.vue?vue&type=template&id=00cb8f5e&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
            _c("h4", [_vm._v(" ค้นหากำหนดเกณฑ์การปันส่วน ")]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-5" }, [
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                    },
                    [_vm._v(" ปีบัญชีงบประมาณ ")]
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
                        on: { onSelected: _vm.onPeriodYearChanged }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold tw-pt-0"
                    },
                    [_vm._v(" แผนการผลิตครั้งที่ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "prdgrp_year_id",
                          id: "input_prdgrp_year_id",
                          "select-options": _vm.prdgrpVersions,
                          "option-key": "prdgrp_year_id",
                          "option-value": "prdgrp_year_id",
                          "option-label": "plan_version_no",
                          value: _vm.prdgrpYearId,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onPrdgrpVersionChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-5" }, [
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold tw-pt-0"
                    },
                    [_vm._v(" เกณฑ์การปันส่วนครั้งที่ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "allocate_account_version",
                          id: "input_allocate_account_version",
                          "select-options": _vm.allocateAccountVersions,
                          "option-key": "version_no",
                          "option-value": "version_no",
                          "option-label": "version_no",
                          value: _vm.allocateAccountVersion,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onAllocateAccountVersionChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-2" }, [
                _c("div", { staticClass: "text-right" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary tw-w-32",
                      attrs: { type: "button", disabled: !_vm.periodYear },
                      on: { click: _vm.getListStdcostYears }
                    },
                    [
                      _vm._v(
                        " \n                            ค้นหา \n                        "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-link tw-w-32 tw-mt-2",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          return _vm.$modal.hide(_vm.modalName)
                        }
                      }
                    },
                    [
                      _vm._v(
                        " \n                            ยกเลิก \n                        "
                      )
                    ]
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "table-responsive",
                staticStyle: { "max-height": "360px" }
              },
              [
                _c(
                  "table",
                  { staticClass: "table table-bordered table-sticky mb-0" },
                  [
                    _c("thead", [
                      _c("tr", [
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" ปีบัญชีงบประมาณ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" แผนการผลิตครั้งที่ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "20%" }
                          },
                          [_vm._v(" เปรียบเทียบค่าใช้จ่ายจริงจาก-ถึง ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" เกณฑ์การปันส่วนครั้งที่ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" วันที่สร้าง ")]
                        ),
                        _vm._v(" "),
                        _c("th", { attrs: { width: "10%" } })
                      ])
                    ]),
                    _vm._v(" "),
                    _vm.stdcostYears.length > 0
                      ? _c(
                          "tbody",
                          [
                            _vm._l(_vm.stdcostYears, function(
                              stdcostYear,
                              index
                            ) {
                              return [
                                _c("tr", { key: index }, [
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "text-center md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            stdcostYear.period_year
                                              ? _vm.getPeriodYearLabel(
                                                  _vm.periodYears,
                                                  stdcostYear.period_year
                                                )
                                              : "-"
                                          ) +
                                          " "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "text-center md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            stdcostYear.prdgrp_year_id
                                              ? _vm.getPrdgrpPlanVersionNo(
                                                  _vm.prdgrpVersions,
                                                  stdcostYear.prdgrp_year_id
                                                )
                                              : "-"
                                          ) +
                                          " "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "text-center md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            stdcostYear.period_name_from
                                              ? _vm.getPeriodNameLabel(
                                                  _vm.periodNames,
                                                  stdcostYear.period_name_from
                                                )
                                              : ""
                                          ) +
                                          " - " +
                                          _vm._s(
                                            stdcostYear.period_name_to
                                              ? _vm.getPeriodNameLabel(
                                                  _vm.periodNames,
                                                  stdcostYear.period_name_to
                                                )
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
                                      staticClass:
                                        "text-center md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(stdcostYear.version_no) +
                                          " "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "text-center md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(stdcostYear.creation_date) +
                                          " "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass:
                                        "text-center md:tw-table-cell"
                                    },
                                    [
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-inline-block btn-primary",
                                          on: {
                                            click: function($event) {
                                              return _vm.onSelectStdcostYearVersion(
                                                stdcostYear
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        เลือก\n                                    "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ])
                              ]
                            })
                          ],
                          2
                        )
                      : _c("tbody", [
                          _c("tr", [
                            _c("td", { attrs: { colspan: "7" } }, [
                              _c(
                                "h2",
                                { staticClass: "p-5 text-center text-muted" },
                                [_vm._v("ไม่พบข้อมูล")]
                              )
                            ])
                          ])
                        ])
                  ]
                )
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=template&id=2210113e&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostAccounts.vue?vue&type=template&id=2210113e& ***!
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
    [
      _c("div", { staticClass: "text-right tw-mb-4" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-success tw-w-40",
            staticStyle: {
              "background-color": "#1c84c6",
              "border-color": "#1c84c6"
            },
            attrs: { type: "button" },
            on: { click: _vm.onExportExcel }
          },
          [
            _c("i", { staticClass: "fa fa fa-file-excel-o tw-mr-1" }),
            _vm._v(" Export\n        ")
          ]
        )
      ]),
      _vm._v(" "),
      _vm.listAllAllocateGroupCodes.length > 0
        ? _c("div", { staticClass: "row tw-my-2" }, [
            _c(
              "label",
              {
                staticClass:
                  "col-md-2 col-form-label tw-font-bold text-center tw-pl-4"
              },
              [_vm._v(" หน่วยงานที่ปัน : ")]
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("pm-el-select", {
                  attrs: {
                    name: "allocate_group_code",
                    id: "input_allocate_group_code",
                    "select-options": _vm.listAllAllocateGroupCodes,
                    "option-key": "allocate_group_code_value",
                    "option-value": "allocate_group_code_value",
                    "option-label": "allocate_group_code_label",
                    value: _vm.filterAllAllocateGroupCode,
                    filterable: true
                  },
                  on: { onSelected: _vm.onFilterAllAllocateGroupCodeChanged }
                })
              ],
              1
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", [
        _c(
          "button",
          {
            staticClass: "tw-w-52 btn btn-lg",
            class: [
              _vm.isTableDeptActive ? "btn-primary" : "btn-white tw-hidden"
            ],
            attrs: { type: "button" },
            on: {
              click: function($event) {
                return _vm.toggleShowTable("DEPT")
              }
            }
          },
          [
            _vm._v(
              " " +
                _vm._s(
                  _vm.getAllocateGroupLevel(_vm.listAllocateGroups, "DEPT")
                ) +
                " : " +
                _vm._s(
                  _vm.getAllocateGroupLabel(_vm.listAllocateGroups, "DEPT")
                ) +
                " "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "tw-w-52 btn btn-lg",
            class: [
              _vm.isTableCostActive ? "btn-primary" : "btn-white tw-hidden"
            ],
            attrs: { type: "button" },
            on: {
              click: function($event) {
                return _vm.toggleShowTable("COST")
              }
            }
          },
          [
            _vm._v(
              " " +
                _vm._s(
                  _vm.getAllocateGroupLevel(_vm.listAllocateGroups, "COST")
                ) +
                " : " +
                _vm._s(
                  _vm.getAllocateGroupLabel(_vm.listAllocateGroups, "COST")
                ) +
                " "
            )
          ]
        )
      ]),
      _vm._v(" "),
      _vm.isTableDeptActive
        ? _c(
            "div",
            {
              staticClass: "table-responsive",
              staticStyle: { "max-height": "600px" }
            },
            [
              _c(
                "table",
                { staticClass: "table table-bordered table-sticky mb-0" },
                [
                  _vm._m(0),
                  _vm._v(" "),
                  _vm.deptStdcostAccountItems.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.deptStdcostAccountItems, function(
                            deptStdcostAccountItem,
                            index
                          ) {
                            return [
                              _vm._l(
                                deptStdcostAccountItem.account_items,
                                function(deptAccountItem, indexT) {
                                  return [
                                    deptAccountItem.is_show
                                      ? _c(
                                          "tr",
                                          {
                                            key: index + "_" + indexT,
                                            style:
                                              "" +
                                              (indexT + 1 ==
                                              deptStdcostAccountItem.count_account
                                                ? "border-bottom : 1px solid rgb(231 231 231);"
                                                : "")
                                          },
                                          [
                                            indexT == 0
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "text-center md:tw-table-cell",
                                                    staticStyle: {
                                                      "border-bottom":
                                                        "1px solid rgb(231 231 231)",
                                                      "border-left": "0",
                                                      "border-right": "0",
                                                      "vertical-align":
                                                        "top !important"
                                                    },
                                                    attrs: {
                                                      rowspan:
                                                        deptStdcostAccountItem.count_account +
                                                        1
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                " +
                                                        _vm._s(
                                                          deptAccountItem.allocate_group_code
                                                        ) +
                                                        "\n                            "
                                                    )
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-center md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      deptAccountItem.target_account_code
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-left md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      deptAccountItem.target_sub_acc_code_desc
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-left md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      deptAccountItem.allocate_type_label
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      deptAccountItem.actual_amount
                                                        ? Number(
                                                            deptAccountItem.actual_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      deptAccountItem.avg_actual_amount
                                                        ? Number(
                                                            deptAccountItem.avg_actual_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      deptAccountItem.budget_amount
                                                        ? Number(
                                                            deptAccountItem.budget_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _c("vue-numeric", {
                                                  staticClass:
                                                    "form-control input-sm text-right",
                                                  attrs: {
                                                    separator: ",",
                                                    precision: 2,
                                                    minus: true,
                                                    name:
                                                      "estimate_expense_amount_" +
                                                      index,
                                                    id:
                                                      "input_estimate_expense_amount_" +
                                                      index,
                                                    disabled: _vm.isLoading
                                                  },
                                                  on: {
                                                    blur: function($event) {
                                                      return _vm.onStdcostAccountEstimateExpenseAmountChanged(
                                                        deptStdcostAccountItem,
                                                        deptAccountItem
                                                      )
                                                    }
                                                  },
                                                  model: {
                                                    value:
                                                      deptAccountItem.estimate_expense_amount,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        deptAccountItem,
                                                        "estimate_expense_amount",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "deptAccountItem.estimate_expense_amount"
                                                  }
                                                })
                                              ],
                                              1
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _c("input", {
                                                  directives: [
                                                    {
                                                      name: "model",
                                                      rawName: "v-model",
                                                      value:
                                                        deptAccountItem.reason_name,
                                                      expression:
                                                        "deptAccountItem.reason_name"
                                                    }
                                                  ],
                                                  staticClass:
                                                    "input-sm form-control",
                                                  attrs: {
                                                    type: "text",
                                                    name: "reason_name",
                                                    id: "input_reason_name",
                                                    disabled: _vm.isLoading
                                                  },
                                                  domProps: {
                                                    value:
                                                      deptAccountItem.reason_name
                                                  },
                                                  on: {
                                                    blur: function($event) {
                                                      return _vm.onStdcostAccountReasonNameChanged(
                                                        deptAccountItem
                                                      )
                                                    },
                                                    input: function($event) {
                                                      if (
                                                        $event.target.composing
                                                      ) {
                                                        return
                                                      }
                                                      _vm.$set(
                                                        deptAccountItem,
                                                        "reason_name",
                                                        $event.target.value
                                                      )
                                                    }
                                                  }
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-center text-nowrap"
                                              },
                                              [
                                                _c(
                                                  "button",
                                                  {
                                                    staticClass:
                                                      "btn btn-inline-block btn-xs btn-white",
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.onGetStdcostTargets(
                                                          deptAccountItem
                                                        )
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _c("i", {
                                                      staticClass:
                                                        "fa fa-list tw-mr-1"
                                                    }),
                                                    _vm._v(
                                                      " เป้าหมายที่รับปัน\n                                "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    deptAccountItem.is_show_targets
                                      ? _c(
                                          "tr",
                                          {
                                            key:
                                              "targets_" + index + "_" + indexT
                                          },
                                          [
                                            _c(
                                              "td",
                                              { attrs: { colspan: "9" } },
                                              [
                                                _c("table-std-cost-targets", {
                                                  attrs: {
                                                    "period-year-value":
                                                      _vm.periodYear,
                                                    "allocate-group-value":
                                                      deptAccountItem.allocate_group,
                                                    "stdcost-year":
                                                      _vm.stdcostYearData,
                                                    "stdcost-account": deptAccountItem,
                                                    "stdcost-targets":
                                                      _vm.stdcostTargets
                                                  },
                                                  on: {
                                                    onStdcostTargetsChanged:
                                                      _vm.onStdcostTargetsChanged
                                                  }
                                                })
                                              ],
                                              1
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    indexT == 0 &&
                                    (!_vm.isTableDeptShowTargets ||
                                      _vm.selectedDeptAllocateGroupCode !=
                                        deptStdcostAccountItem.allocate_group_code) &&
                                    _vm.filterAllAllocateGroupCode == "ALL_DEPT"
                                      ? _c(
                                          "tr",
                                          {
                                            key:
                                              "targets_" + index + "_" + indexT
                                          },
                                          [
                                            _c("td", {
                                              staticStyle: {
                                                padding: "0px",
                                                "border-color": "#fff"
                                              },
                                              attrs: { colspan: "9" }
                                            })
                                          ]
                                        )
                                      : _vm._e()
                                  ]
                                }
                              )
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
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableDeptActive && _vm.deptStdcostAccountItems.length > 0
        ? _c("div", [
            _c(
              "table",
              { staticClass: "table table-bordered table-sticky mb-0" },
              [
                _c("thead", [
                  _vm.deptStdcostAccountItems.length > 0
                    ? _c("tr", [
                        _c(
                          "td",
                          {
                            staticClass: "text-left md:tw-table-cell",
                            staticStyle: { "border-right": "0" },
                            attrs: { width: "31%", colspan: "3" }
                          },
                          [
                            _c("b", [
                              _vm._v(
                                " ประเภทการปันส่วน : " +
                                  _vm._s(
                                    _vm.getAllocateGroupLevel(
                                      _vm.listAllocateGroups,
                                      "DEPT"
                                    )
                                  ) +
                                  " " +
                                  _vm._s(
                                    _vm.getAllocateGroupLabel(
                                      _vm.listAllocateGroups,
                                      "DEPT"
                                    )
                                  ) +
                                  " "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _vm._m(2),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterDeptAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptSumFilteredActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptTotalActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterDeptAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptSumFilteredAvgActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptTotalAvgActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterDeptAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptSumFilteredBudgetAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptTotalBudgetAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "13%", colspan: "3" }
                          },
                          [
                            _vm.filterDeptAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptSumFilteredEstimateExpenseAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.deptTotalEstimateExpenseAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", {
                          staticClass: "text-left md:tw-table-cell",
                          attrs: { width: "20%" }
                        })
                      ])
                    : _vm._e()
                ])
              ]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableCostActive
        ? _c(
            "div",
            {
              staticClass: "table-responsive",
              staticStyle: { "max-height": "600px" }
            },
            [
              _c(
                "table",
                { staticClass: "table table-bordered table-sticky mb-0" },
                [
                  _vm._m(3),
                  _vm._v(" "),
                  _vm.costStdcostAccountItems.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.costStdcostAccountItems, function(
                            costStdcostAccountItem,
                            index
                          ) {
                            return [
                              _vm._l(
                                costStdcostAccountItem.account_items,
                                function(costAccountItem, indexT) {
                                  return [
                                    costAccountItem.is_show
                                      ? _c(
                                          "tr",
                                          {
                                            key: index + "_" + indexT,
                                            style:
                                              "" +
                                              (indexT + 1 ==
                                              costStdcostAccountItem.count_account
                                                ? "border-bottom : 1px solid rgb(231 231 231);"
                                                : "")
                                          },
                                          [
                                            indexT == 0
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "text-center md:tw-table-cell",
                                                    staticStyle: {
                                                      "border-bottom":
                                                        "1px solid rgb(231 231 231)",
                                                      "border-left": "0",
                                                      "border-right": "0",
                                                      "vertical-align":
                                                        "top !important"
                                                    },
                                                    attrs: {
                                                      rowspan:
                                                        costStdcostAccountItem.count_account +
                                                        1
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                " +
                                                        _vm._s(
                                                          costAccountItem.allocate_group_code
                                                        ) +
                                                        "\n                            "
                                                    )
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-center md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      costAccountItem.target_account_code
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-left md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      costAccountItem.target_sub_acc_code_desc
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-left md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      costAccountItem.allocate_type_label
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      costAccountItem.actual_amount
                                                        ? Number(
                                                            costAccountItem.actual_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      costAccountItem.avg_actual_amount
                                                        ? Number(
                                                            costAccountItem.avg_actual_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      costAccountItem.budget_amount
                                                        ? Number(
                                                            costAccountItem.budget_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _c("vue-numeric", {
                                                  staticClass:
                                                    "form-control input-sm text-right",
                                                  attrs: {
                                                    separator: ",",
                                                    precision: 2,
                                                    minus: true,
                                                    name:
                                                      "estimate_expense_amount_" +
                                                      index,
                                                    id:
                                                      "input_estimate_expense_amount_" +
                                                      index,
                                                    disabled: _vm.isLoading
                                                  },
                                                  on: {
                                                    blur: function($event) {
                                                      return _vm.onStdcostAccountEstimateExpenseAmountChanged(
                                                        costStdcostAccountItem,
                                                        costAccountItem
                                                      )
                                                    }
                                                  },
                                                  model: {
                                                    value:
                                                      costAccountItem.estimate_expense_amount,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        costAccountItem,
                                                        "estimate_expense_amount",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "costAccountItem.estimate_expense_amount"
                                                  }
                                                })
                                              ],
                                              1
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _c("input", {
                                                  directives: [
                                                    {
                                                      name: "model",
                                                      rawName: "v-model",
                                                      value:
                                                        costAccountItem.reason_name,
                                                      expression:
                                                        "costAccountItem.reason_name"
                                                    }
                                                  ],
                                                  staticClass:
                                                    "input-sm form-control",
                                                  attrs: {
                                                    type: "text",
                                                    name: "reason_name",
                                                    id: "input_reason_name",
                                                    disabled: _vm.isLoading
                                                  },
                                                  domProps: {
                                                    value:
                                                      costAccountItem.reason_name
                                                  },
                                                  on: {
                                                    blur: function($event) {
                                                      return _vm.onStdcostAccountReasonNameChanged(
                                                        costAccountItem
                                                      )
                                                    },
                                                    input: function($event) {
                                                      if (
                                                        $event.target.composing
                                                      ) {
                                                        return
                                                      }
                                                      _vm.$set(
                                                        costAccountItem,
                                                        "reason_name",
                                                        $event.target.value
                                                      )
                                                    }
                                                  }
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-center text-nowrap"
                                              },
                                              [
                                                _c(
                                                  "button",
                                                  {
                                                    staticClass:
                                                      "btn btn-inline-block btn-xs btn-white",
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.onGetStdcostTargets(
                                                          costAccountItem
                                                        )
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _c("i", {
                                                      staticClass:
                                                        "fa fa-list tw-mr-1"
                                                    }),
                                                    _vm._v(
                                                      " เป้าหมายที่รับปัน\n                                "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    costAccountItem.is_show_targets
                                      ? _c(
                                          "tr",
                                          {
                                            key:
                                              "targets_" + index + "_" + indexT
                                          },
                                          [
                                            _c(
                                              "td",
                                              { attrs: { colspan: "9" } },
                                              [
                                                _c("table-std-cost-targets", {
                                                  attrs: {
                                                    "period-year-value":
                                                      _vm.periodYear,
                                                    "allocate-group-value":
                                                      costAccountItem.allocate_group,
                                                    "stdcost-year":
                                                      _vm.stdcostYearData,
                                                    "stdcost-account": costAccountItem,
                                                    "stdcost-targets":
                                                      _vm.stdcostTargets
                                                  },
                                                  on: {
                                                    onStdcostTargetsChanged:
                                                      _vm.onStdcostTargetsChanged
                                                  }
                                                })
                                              ],
                                              1
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    indexT == 0 &&
                                    (!_vm.isTableCostShowTargets ||
                                      _vm.selectedCostAllocateGroupCode !=
                                        costStdcostAccountItem.allocate_group_code) &&
                                    _vm.filterAllAllocateGroupCode == "ALL_COST"
                                      ? _c(
                                          "tr",
                                          {
                                            key:
                                              "targets_" + index + "_" + indexT
                                          },
                                          [
                                            _c("td", {
                                              staticStyle: {
                                                padding: "0px",
                                                "border-color": "#fff"
                                              },
                                              attrs: { colspan: "9" }
                                            })
                                          ]
                                        )
                                      : _vm._e()
                                  ]
                                }
                              )
                            ]
                          })
                        ],
                        2
                      )
                    : _c("tbody", [_vm._m(4)])
                ]
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableCostActive && _vm.costStdcostAccountItems.length > 0
        ? _c("div", [
            _c(
              "table",
              { staticClass: "table table-bordered table-sticky mb-0" },
              [
                _c("thead", [
                  _vm.costStdcostAccountItems.length > 0
                    ? _c("tr", [
                        _c(
                          "td",
                          {
                            staticClass: "text-left md:tw-table-cell",
                            staticStyle: { "border-right": "0" },
                            attrs: { width: "32%", colspan: "4" }
                          },
                          [
                            _c("b", [
                              _vm._v(
                                " ประเภทการปันส่วน : " +
                                  _vm._s(
                                    _vm.getAllocateGroupLevel(
                                      _vm.listAllocateGroups,
                                      "COST"
                                    )
                                  ) +
                                  " " +
                                  _vm._s(
                                    _vm.getAllocateGroupLabel(
                                      _vm.listAllocateGroups,
                                      "COST"
                                    )
                                  ) +
                                  " "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _vm._m(5),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterCostAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costSumFilteredActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costTotalActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterCostAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costSumFilteredAvgActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costTotalAvgActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterCostAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costSumFilteredBudgetAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costTotalBudgetAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "13%", colspan: "3" }
                          },
                          [
                            _vm.filterCostAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costSumFilteredEstimateExpenseAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.costTotalEstimateExpenseAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", {
                          staticClass: "text-left md:tw-table-cell",
                          attrs: { width: "20%" }
                        })
                      ])
                    : _vm._e()
                ])
              ]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableProductActive
        ? _c(
            "div",
            {
              staticClass: "table-responsive",
              staticStyle: { "max-height": "600px" }
            },
            [
              _c(
                "table",
                { staticClass: "table table-bordered table-sticky mb-0" },
                [
                  _vm._m(6),
                  _vm._v(" "),
                  _vm.productStdcostAccountItems.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.productStdcostAccountItems, function(
                            productStdcostAccountItem,
                            index
                          ) {
                            return [
                              _vm._l(
                                productStdcostAccountItem.account_items,
                                function(productAccountItem, indexT) {
                                  return [
                                    productAccountItem.is_show
                                      ? _c(
                                          "tr",
                                          {
                                            key: index + "_" + indexT,
                                            style:
                                              "" +
                                              (indexT + 1 ==
                                              productStdcostAccountItem.count_account
                                                ? "border-bottom : 1px solid rgb(231 231 231);"
                                                : "")
                                          },
                                          [
                                            indexT == 0
                                              ? _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "text-center md:tw-table-cell",
                                                    staticStyle: {
                                                      "border-bottom":
                                                        "1px solid rgb(231 231 231)",
                                                      "border-left": "0",
                                                      "border-right": "0",
                                                      "vertical-align":
                                                        "top !important"
                                                    },
                                                    attrs: {
                                                      rowspan:
                                                        productStdcostAccountItem.count_account +
                                                        1
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                " +
                                                        _vm._s(
                                                          productAccountItem.allocate_group_code
                                                        ) +
                                                        "\n                            "
                                                    )
                                                  ]
                                                )
                                              : _vm._e(),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-center md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.target_account_code
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-left md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.target_sub_acc_code_desc
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-left md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.allocate_type_label
                                                    ) +
                                                    "\n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.actual_amount
                                                        ? Number(
                                                            productAccountItem.actual_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.avg_actual_amount
                                                        ? Number(
                                                            productAccountItem.avg_actual_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.budget_amount
                                                        ? Number(
                                                            productAccountItem.budget_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right md:tw-table-cell"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                " +
                                                    _vm._s(
                                                      productAccountItem.estimate_expense_amount
                                                        ? Number(
                                                            productAccountItem.estimate_expense_amount
                                                          ).toLocaleString(
                                                            undefined,
                                                            {
                                                              minimumFractionDigits: 2,
                                                              maximumFractionDigits: 2
                                                            }
                                                          )
                                                        : "0.00"
                                                    ) +
                                                    " \n                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-center text-nowrap"
                                              },
                                              [
                                                _c(
                                                  "button",
                                                  {
                                                    staticClass:
                                                      "btn btn-inline-block btn-xs btn-white",
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.onGetStdcostTargets(
                                                          productAccountItem
                                                        )
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _c("i", {
                                                      staticClass:
                                                        "fa fa-list tw-mr-1"
                                                    }),
                                                    _vm._v(
                                                      " เป้าหมายที่รับปัน\n                                "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    productAccountItem.is_show_targets
                                      ? _c(
                                          "tr",
                                          {
                                            key:
                                              "targets_" + index + "_" + indexT
                                          },
                                          [
                                            _c(
                                              "td",
                                              { attrs: { colspan: "9" } },
                                              [
                                                _c("table-std-cost-targets", {
                                                  attrs: {
                                                    "period-year-value":
                                                      _vm.periodYear,
                                                    "allocate-group-value":
                                                      productAccountItem.allocate_group,
                                                    "stdcost-year":
                                                      _vm.stdcostYearData,
                                                    "stdcost-account": productAccountItem,
                                                    "stdcost-targets":
                                                      _vm.stdcostTargets
                                                  },
                                                  on: {
                                                    onStdcostTargetsChanged:
                                                      _vm.onStdcostTargetsChanged
                                                  }
                                                })
                                              ],
                                              1
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    indexT == 0 &&
                                    (!_vm.isTableProductShowTargets ||
                                      _vm.selectedProductAllocateGroupCode !=
                                        productStdcostAccountItem.allocate_group_code) &&
                                    _vm.filterAllAllocateGroupCode ==
                                      "ALL_PRODUCT"
                                      ? _c(
                                          "tr",
                                          {
                                            key:
                                              "targets_" + index + "_" + indexT
                                          },
                                          [
                                            _c("td", {
                                              staticStyle: {
                                                padding: "0px",
                                                "border-color": "#fff"
                                              },
                                              attrs: { colspan: "9" }
                                            })
                                          ]
                                        )
                                      : _vm._e()
                                  ]
                                }
                              )
                            ]
                          })
                        ],
                        2
                      )
                    : _c("tbody", [_vm._m(7)])
                ]
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableProductActive && _vm.productStdcostAccountItems.length > 0
        ? _c("div", [
            _c(
              "table",
              { staticClass: "table table-bordered table-sticky mb-0" },
              [
                _c("thead", [
                  _vm.productStdcostAccountItems.length > 0
                    ? _c("tr", [
                        _c(
                          "td",
                          {
                            staticClass: "text-left md:tw-table-cell",
                            staticStyle: { "border-right": "0" },
                            attrs: { width: "32%", colspan: "4" }
                          },
                          [
                            _c("b", [
                              _vm._v(
                                " ประเภทการปันส่วน : " +
                                  _vm._s(
                                    _vm.getAllocateGroupLevel(
                                      _vm.listAllocateGroups,
                                      "PRODUCT"
                                    )
                                  ) +
                                  " " +
                                  _vm._s(
                                    _vm.getAllocateGroupLabel(
                                      _vm.listAllocateGroups,
                                      "PRODUCT"
                                    )
                                  ) +
                                  " "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _vm._m(8),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterProductAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productSumFilteredActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productTotalActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterProductAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productSumFilteredAvgActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productTotalAvgActualAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "10%", colspan: "3" }
                          },
                          [
                            _vm.filterProductAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productSumFilteredBudgetAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productTotalBudgetAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "13%", colspan: "3" }
                          },
                          [
                            _vm.filterProductAllocateGroupCode
                              ? _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productSumFilteredEstimateExpenseAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                              : _c("b", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        Number(
                                          _vm.productTotalEstimateExpenseAmount
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "  "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", {
                          staticClass: "text-left md:tw-table-cell",
                          attrs: { width: "10%" }
                        })
                      ])
                    : _vm._e()
                ])
              ]
            )
          ])
        : _vm._e(),
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
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "7%" }
          },
          [_vm._v(" หน่วยงานที่ปัน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "7%" }
          },
          [_vm._v(" รหัสบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "12%" }
          },
          [_vm._v(" ชื่อบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" เกณฑ์การปันส่วน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริง ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริงเฉลี่ย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายตามงบประมาณ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "13%" }
          },
          [_vm._v(" ค่าใช้จ่ายประมาณการ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" หมายเหตุ ")]
        ),
        _vm._v(" "),
        _c("th", { attrs: { width: "10%" } })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "11" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-left md:tw-table-cell",
        staticStyle: { "border-left": "0" },
        attrs: { width: "5%" }
      },
      [_c("b", [_vm._v(" รวม ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "7%" }
          },
          [_vm._v(" หน่วยงานที่ปัน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "7%" }
          },
          [_vm._v(" รหัสบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "13%" }
          },
          [_vm._v(" ชื่อบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" เกณฑ์การปันส่วน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริง ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริงเฉลี่ย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายตามงบประมาณ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "13%" }
          },
          [_vm._v(" ค่าใช้จ่ายประมาณการ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" หมายเหตุ ")]
        ),
        _vm._v(" "),
        _c("th", { attrs: { width: "10%" } })
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
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-left md:tw-table-cell",
        staticStyle: { "border-left": "0" },
        attrs: { width: "5%" }
      },
      [_c("b", [_vm._v(" รวม ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "7%" }
          },
          [_vm._v(" ศูนย์ต้นทุนที่ปัน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "7%" }
          },
          [_vm._v(" รหัสบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "13%" }
          },
          [_vm._v(" ชื่อบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" เกณฑ์การปันส่วน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริง ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริงเฉลี่ย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายตามงบประมาณ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "z-index": "2" },
            attrs: { width: "13%" }
          },
          [_vm._v(" ค่าใช้จ่ายประมาณการ ")]
        ),
        _vm._v(" "),
        _c("th", { attrs: { width: "10%" } })
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
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-left md:tw-table-cell",
        staticStyle: { "border-left": "0" },
        attrs: { width: "5%" }
      },
      [_c("b", [_vm._v(" รวม ")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=template&id=b68b364c&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-costs/TableStdCostTargets.vue?vue&type=template&id=b68b364c& ***!
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
  return _c("div", { staticClass: "tw-pl-10" }, [
    _c(
      "div",
      {
        staticClass: "table-responsive",
        staticStyle: { "max-height": "600px" }
      },
      [
        _c("table", { staticClass: "table table-bordered table-sticky mb-0" }, [
          _c("thead", [
            _c("tr", [
              _c(
                "th",
                {
                  staticClass: "text-center tw-text-xs md:tw-table-cell",
                  staticStyle: {
                    "background-color": "#fff0e0",
                    "border-left": "0px",
                    "border-right": "0px"
                  },
                  attrs: { width: "20%" }
                },
                [
                  _vm.allocateGroup == "DEPT"
                    ? _c("span", [_vm._v(" หน่วยงาน ")])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.allocateGroup == "COST"
                    ? _c("span", [_vm._v(" ศูนย์ต้นทุน ")])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.allocateGroup == "PRODUCT"
                    ? _c("span", [_vm._v(" กลุ่มสินค้า ")])
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "text-center tw-text-xs md:tw-table-cell",
                  staticStyle: {
                    "background-color": "#fff0e0",
                    "border-left": "0px",
                    "border-right": "0px"
                  },
                  attrs: { width: "20%" }
                },
                [_vm._v(" รายละเอียด ")]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-right tw-text-xs md:tw-table-cell tw-hidden",
                  staticStyle: {
                    "background-color": "#fff0e0",
                    "border-left": "0px",
                    "border-right": "0px"
                  },
                  attrs: { width: "15%" }
                },
                [_vm._v("  สัดส่วน % ")]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "text-right tw-text-xs md:tw-table-cell",
                  staticStyle: {
                    "background-color": "#fff0e0",
                    "border-left": "0px",
                    "border-right": "0px"
                  },
                  attrs: { width: "25%" }
                },
                [_vm._v(" ค่าใช้จ่ายประมาณการ ")]
              )
            ])
          ]),
          _vm._v(" "),
          _vm.stdcostTargetItems.length > 0
            ? _c(
                "tbody",
                [
                  _vm._l(_vm.stdcostTargetItems, function(
                    stdcostTargetItem,
                    index
                  ) {
                    return [
                      _vm._l(stdcostTargetItem.target_items, function(
                        targetItem,
                        indexT
                      ) {
                        return [
                          _c("tr", { key: index + "_" + indexT }, [
                            _c(
                              "td",
                              {
                                staticClass: "text-center md:tw-table-cell",
                                staticStyle: {
                                  "border-left": "0",
                                  "border-right": "0"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                " +
                                    _vm._s(targetItem.target_code) +
                                    "\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              {
                                staticClass: "text-left md:tw-table-cell",
                                staticStyle: {
                                  "border-left": "0",
                                  "border-right": "0"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                " +
                                    _vm._s(targetItem.target_code_desc) +
                                    "\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              {
                                staticClass:
                                  "text-right md:tw-table-cell tw-hidden",
                                staticStyle: {
                                  "border-left": "0",
                                  "border-right": "0"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                " +
                                    _vm._s(targetItem.ratio_rate) +
                                    "\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              {
                                staticClass: "text-right md:tw-table-cell",
                                staticStyle: {
                                  "border-left": "0",
                                  "border-right": "0"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                " +
                                    _vm._s(
                                      targetItem.estimate_expense_amount
                                        ? Number(
                                            targetItem.estimate_expense_amount
                                          ).toLocaleString(undefined, {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                          })
                                        : "0.00"
                                    ) +
                                    " \n                            "
                                )
                              ]
                            )
                          ])
                        ]
                      })
                    ]
                  })
                ],
                2
              )
            : _c("tbody", [_vm._m(0)])
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "5" } }, [
        _c("h2", { staticClass: "p-3 text-center text-muted" }, [
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);