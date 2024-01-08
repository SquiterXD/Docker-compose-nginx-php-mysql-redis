(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_std-cost-papers_Summarizes_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=script&lang=js& ***!
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
/* harmony import */ var _TableSummaryPrdGroups__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableSummaryPrdGroups */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue");
/* harmony import */ var _TableSummaryPrdGroupTotals__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TableSummaryPrdGroupTotals */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue");
/* harmony import */ var _TableSummaryPrdGroupTotalsNoApprove__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./TableSummaryPrdGroupTotalsNoApprove */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue");


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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TableSummaryPrdGroups: _TableSummaryPrdGroups__WEBPACK_IMPORTED_MODULE_4__.default,
    TableSummaryPrdGroupTotals: _TableSummaryPrdGroupTotals__WEBPACK_IMPORTED_MODULE_5__.default,
    TableSummaryPrdGroupTotalsNoApprove: _TableSummaryPrdGroupTotalsNoApprove__WEBPACK_IMPORTED_MODULE_6__.default
  },
  props: ["defaultData", "uomCodes", "costCode", "planVersionNo", "versionNo", "ct14VersionNo", "periodYearData", "periodFrom", "periodTo", "allocateTypes", "allocateYear", "yearControl", "latestStdcostYear", "stdcostYear", "stdcostPrdGroups", "stdcostPrdGroupTotals", "stdcostPrdGroupTotalsNoApprove"],
  mounted: function mounted() {
    if (this.yearControl) {
      if (!this.latestStdcostYear) {
        swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19 \"\u0E2A\u0E23\u0E38\u0E1B\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\" \u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13: ".concat(this.periodYearData.period_year_thai, ", \u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19: ").concat(this.yearControl.cost_code, " ").concat(this.yearControl.cost_description, ", \u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48: ").concat(this.yearControl.plan_version_no, ", \u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48: ").concat(this.ct14VersionNo, ", \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07"), "error");
      } else {
        if (this.stdcostPrdGroups.length <= 0) {
          this.getStdcostPrdGroups(this.yearControl.period_year, this.yearControl.prdgrp_year_id, this.yearControl.cost_code, this.latestStdcostYear);
        }
      }
    } else {
      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19 \"\u0E2A\u0E23\u0E38\u0E1B\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\" \u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13: ".concat(this.periodYearData.period_year_thai, ", \u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19: ").concat(this.costCode, ", \u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48: ").concat(this.planVersionNo, ", \u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48: ").concat(this.ct14VersionNo, " , \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07"), "error");
    }
  },
  data: function data() {
    return {
      organizationId: this.defaultData ? this.defaultData.organization_id : null,
      organizationCode: this.defaultData ? this.defaultData.organization_code : null,
      department: this.defaultData ? this.defaultData.department : null,
      approvedStatuses: [{
        value: "Active",
        label: "อนุมัติ"
      }, {
        value: "Inactive",
        label: "ไม่อนุมัติ"
      }],
      periodYear: this.periodYearData ? this.periodYearData.period_year : null,
      periodYearLabel: this.periodYearData ? this.periodYearData.period_year_thai : null,
      stdcostYearData: this.stdcostYear ? this.stdcostYear : null,
      stdcostPrdGroupItems: this.stdcostPrdGroups ? this.stdcostPrdGroups : [],
      stdcostPrdGroupTotalItems: this.stdcostPrdGroupTotals ? this.stdcostPrdGroupTotals : [],
      stdcostPrdGroupTotalsNoApproveItems: this.stdcostPrdGroupTotalsNoApprove ? this.stdcostPrdGroupTotalsNoApprove : [],
      periodFromData: this.periodFrom ? this.periodFrom : null,
      periodToData: this.periodTo ? this.periodTo : null,
      isLoading: false
    };
  },
  computed: {},
  methods: {
    getApprovedStatusLabel: function getApprovedStatusLabel(approvedStatus) {
      var foundApprovedStatus = this.approvedStatuses.find(function (item) {
        return item.value == approvedStatus;
      });
      return foundApprovedStatus ? foundApprovedStatus.label : "";
    },
    getStdcostPrdGroups: function getStdcostPrdGroups(periodYear, prdgrpYearId, costCode, stdcostYearData) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                // show loading
                _this.isLoading = true;
                params = {
                  period_year: periodYear,
                  prdgrp_year_id: prdgrpYearId,
                  cost_code: costCode,
                  year_control: JSON.stringify(_this.yearControl),
                  stdcost_year: JSON.stringify(stdcostYearData)
                };
                _context.next = 4;
                return axios.get("/ajax/ct/std-cost-papers/summary-prd-groups", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this.periodToData = resData.period_to ? JSON.parse(resData.period_to) : [];
                    _this.stdcostYearData = resData.stdcost_year ? JSON.parse(resData.stdcost_year) : [];
                    _this.stdcostPrdGroupItems = resData.stdcost_prd_groups ? JSON.parse(resData.stdcost_prd_groups) : [];
                    _this.stdcostPrdGroupTotalItems = resData.stdcost_prd_group_totals ? JSON.parse(resData.stdcost_prd_group_totals) : [];
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this.isLoading = false;

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
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
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_3___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["periodYearValue", "stdcostYear", "stdcostPrdGroup", "stdcostPrdGroupInvTotal", "stdcostPrdGroupInvItems"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostPrdGroup: function stdcostPrdGroup(value) {
      this.stdcostPrdGroupData = value;
    },
    stdcostPrdGroupInvTotal: function stdcostPrdGroupInvTotal(value) {
      this.stdcostPrdGroupInvTotalData = value;
    },
    stdcostPrdGroupInvItems: function stdcostPrdGroupInvItems(value) {
      this.stdcostPrdGroupInvItemItems = value;
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      stdcostYearData: this.stdcostYear,
      stdcostPrdGroupData: this.stdcostPrdGroup,
      stdcostPrdGroupInvTotalData: this.stdcostPrdGroupInvTotal,
      stdcostPrdGroupInvItemItems: this.stdcostPrdGroupInvItems,
      isLoading: false
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableSummaryPrdGroupInvItems__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TableSummaryPrdGroupInvItems */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue");


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "stdcostYear", "stdcostPrdGroup", "stdcostPrdGroupTotals"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default()),
    TableSummaryPrdGroupInvItems: _TableSummaryPrdGroupInvItems__WEBPACK_IMPORTED_MODULE_5__.default
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostPrdGroup: function stdcostPrdGroup(value) {
      this.stdcostPrdGroupData = value;
    },
    stdcostPrdGroupTotals: function stdcostPrdGroupTotals(value) {
      this.stdcostPrdGroupTotalItems = value;
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      stdcostYearData: this.stdcostYear,
      stdcostPrdGroupData: this.stdcostPrdGroup,
      selectedStdcostPrdGroupTotalItem: null,
      stdcostPrdGroupTotalItems: this.stdcostPrdGroupTotals,
      stdcostPrdGroupInvItems: [],
      isLoading: false,
      productItemNumber: this.productItemNumber,
      ct14VersionNo: this.ct14VersionNo
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
    onGetStdcostPrdGroupInvItems: function onGetStdcostPrdGroupInvItems(e, stdcostPrdGroupTotalItem) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.stdcostPrdGroupInvItems = [];
                _this.selectedStdcostPrdGroupTotalItem = stdcostPrdGroupTotalItem;
                _this.productItemNumber = _this.selectedStdcostPrdGroupTotalItem['product_item_number'];
                _this.ct14VersionNo = _this.selectedStdcostPrdGroupTotalItem['ct14_version_no'];
                _context.next = 6;
                return _this.getStdcostPrdGroupInvItems(_this.stdcostYearData, stdcostPrdGroupTotalItem);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getStdcostPrdGroupInvItems: function getStdcostPrdGroupInvItems(stdcostYearData, stdcostPrdGroupTotalItem) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // show loading
                _this2.isLoading = true;
                params = {
                  product_item_number: _this2.productItemNumber,
                  ct14_allocate_year_id: _this2.ct14VersionNo,
                  period_year: _this2.periodYear,
                  stdcost_year: JSON.stringify(stdcostYearData),
                  stdcost_prd_group_total: JSON.stringify(stdcostPrdGroupTotalItem)
                };
                _context2.next = 4;
                return axios.get("/ajax/ct/std-cost-papers/summary-prd-group-inv-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this2.stdcostPrdGroupInvItems = resData.stdcost_prd_group_inv_items ? JSON.parse(resData.stdcost_prd_group_inv_items) : [];

                    if (_this2.stdcostPrdGroupInvItems.length <= 0) {
                      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C: ".concat(stdcostPrdGroupTotalItem.product_group, ", \u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C: ").concat(stdcostPrdGroupTotalItem.product_item_number, " ").concat(stdcostPrdGroupTotalItem.product_item_desc), "error");
                    }
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this2.isLoading = false;

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableSummaryPrdGroupInvItems__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TableSummaryPrdGroupInvItems */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue");


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "stdcostYear", "stdcostPrdGroup", "stdcostPrdGroupTotalsNoApprove"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default()),
    TableSummaryPrdGroupInvItems: _TableSummaryPrdGroupInvItems__WEBPACK_IMPORTED_MODULE_5__.default
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostPrdGroup: function stdcostPrdGroup(value) {
      this.stdcostPrdGroupData = value;
    },
    stdcostPrdGroupTotalsNoApprove: function stdcostPrdGroupTotalsNoApprove(value) {
      this.stdcostPrdGroupTotalsNoApproveItems = value;
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      stdcostYearData: this.stdcostYear,
      stdcostPrdGroupData: this.stdcostPrdGroup,
      selectedStdcostPrdGroupTotalItem: null,
      stdcostPrdGroupTotalsNoApproveItems: this.stdcostPrdGroupTotalsNoApprove,
      stdcostPrdGroupInvItemsNoApprove: [],
      isLoading: false,
      productItemNumber: this.productItemNumber,
      ct14VersionNo: this.ct14VersionNo
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
    onGetStdcostPrdGroupInvItems: function onGetStdcostPrdGroupInvItems(e, stdcostPrdGroupTotalsNoApproveItems) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.stdcostPrdGroupInvItemsNoApprove = [];
                _this.selectedStdcostPrdGroupTotalItem = stdcostPrdGroupTotalsNoApproveItems;
                _this.productItemNumber = _this.selectedStdcostPrdGroupTotalItem['product_item_number'];
                _this.ct14VersionNo = _this.selectedStdcostPrdGroupTotalItem['ct14_version_no'];
                _context.next = 6;
                return _this.getStdcostPrdGroupInvItems(_this.stdcostYearData, stdcostPrdGroupTotalsNoApproveItems);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getStdcostPrdGroupInvItems: function getStdcostPrdGroupInvItems(stdcostYearData, stdcostPrdGroupTotalsNoApproveItems) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // show loading
                _this2.isLoading = true;
                params = {
                  product_item_number: _this2.productItemNumber,
                  ct14_allocate_year_id: _this2.ct14VersionNo,
                  period_year: _this2.periodYear,
                  stdcost_year: JSON.stringify(stdcostYearData),
                  stdcost_prd_group_total: JSON.stringify(stdcostPrdGroupTotalsNoApproveItems)
                };
                _context2.next = 4;
                return axios.get("/ajax/ct/std-cost-papers/summary-prd-group-inv-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this2.stdcostPrdGroupInvItemsNoApprove = resData.stdcost_prd_group_inv_items ? JSON.parse(resData.stdcost_prd_group_inv_items) : [];

                    if (_this2.stdcostPrdGroupInvItemsNoApprove.length <= 0) {
                      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C: ".concat(stdcostPrdGroupTotalsNoApproveItems.product_group, ", \u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C: ").concat(stdcostPrdGroupTotalsNoApproveItems.product_item_number, " ").concat(stdcostPrdGroupTotalsNoApproveItems.product_item_desc), "error");
                    }
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this2.isLoading = false;

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onGetcostPrdActiveNewItem: function onGetcostPrdActiveNewItem(e, stdcostPrdGroupTotalsNoApproveItems) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.stdcostPrdGroupInvItemsNoApprove = [];
                _this3.selectedStdcostPrdGroupTotalItem = stdcostPrdGroupTotalsNoApproveItems;
                _context3.next = 4;
                return _this3.getStdcostPrdActiveNewItem();

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getStdcostPrdActiveNewItem: function getStdcostPrdActiveNewItem() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                // show loading
                _this4.isLoading = true;
                reqBody = {
                  period_year: _this4.selectedStdcostPrdGroupTotalItem.period_year,
                  prdgrp_year_id: _this4.selectedStdcostPrdGroupTotalItem.prdgrp_year_id,
                  allocate_year_id: _this4.selectedStdcostPrdGroupTotalItem.allocate_year_id,
                  cost_code: _this4.selectedStdcostPrdGroupTotalItem.cost_code,
                  plan_version_no: _this4.selectedStdcostPrdGroupTotalItem.plan_version_no,
                  version_no: _this4.selectedStdcostPrdGroupTotalItem.version_no,
                  ct14_version_no: _this4.selectedStdcostPrdGroupTotalItem.ct14_version_no,
                  ct14_allocate_year_id: _this4.selectedStdcostPrdGroupTotalItem.ct14_allocate_year_id,
                  product_inventory_item_id: _this4.selectedStdcostPrdGroupTotalItem.product_inventory_item_id
                };
                _context4.next = 4;
                return axios.post("/ajax/ct/std-cost-papers/active-new-item", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resYearControl = resData.year_control ? JSON.parse(resData.year_control) : null;

                  if (resData.status == "success") {
                    if (resYearControl) {
                      _this4.selectedStdcostPrdGroupTotalItem.product_inventory_item_id = resYearControl.product_inventory_item_id;
                    }
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2A\u0E16\u0E32\u0E19\u0E30\u0E44\u0E21\u0E48\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E2A\u0E16\u0E32\u0E19\u0E30\u0E44\u0E21\u0E48\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08 | ".concat(error.message), "error");
                });

              case 4:
                // hide loading
                _this4.isLoading = false;

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["uomCodes", "periodYearValue", "stdcostYear", "stdcostPrdGroups", "allocateTypes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostPrdGroups: function stdcostPrdGroups(value) {
      var _this = this;

      this.stdcostPrdGroupItems = value.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          cost_uom_code_desc: _this.getUomCodeDesc(_this.uomCodes, item.cost_uom_code),
          marked_as_deleted: false
        });
      });
    }
  },
  data: function data() {
    var _this2 = this;

    return {
      periodYear: this.periodYearValue,
      stdcostYearData: this.stdcostYear,
      selectedStdcostPrdGroupItem: null,
      stdcostPrdGroupItems: this.stdcostPrdGroups.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          cost_uom_code_desc: _this2.getUomCodeDesc(_this2.uomCodes, item.cost_uom_code),
          allocate_type_label: _this2.getAllocateTypeLabel(_this2.allocateTypes, item.allocate_type),
          marked_as_deleted: false
        });
      }),
      stdcostPrdGroupTotals: [],
      totalEstimateExpenseAmount: this.stdcostPrdGroups.reduce(function (pv, cv) {
        return pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0);
      }, 0),
      isLoading: false
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
    getUomCodeDesc: function getUomCodeDesc(uomCodes, uomCode) {
      var result = "";

      if (uomCodes.length > 0 && uomCode) {
        var foundUomCode = uomCodes.find(function (item) {
          return item.uom_code == uomCode;
        });
        result = foundUomCode ? foundUomCode.unit_of_measure : "";
      }

      return result;
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

/***/ "./resources/js/components/ct/std-cost-papers/Summarizes.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/Summarizes.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Summarizes_vue_vue_type_template_id_0e7d3027___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Summarizes.vue?vue&type=template&id=0e7d3027& */ "./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=template&id=0e7d3027&");
/* harmony import */ var _Summarizes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Summarizes.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Summarizes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Summarizes_vue_vue_type_template_id_0e7d3027___WEBPACK_IMPORTED_MODULE_0__.render,
  _Summarizes_vue_vue_type_template_id_0e7d3027___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/Summarizes.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableSummaryPrdGroupInvItems_vue_vue_type_template_id_46db55ce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce&");
/* harmony import */ var _TableSummaryPrdGroupInvItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableSummaryPrdGroupInvItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableSummaryPrdGroupInvItems_vue_vue_type_template_id_46db55ce___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableSummaryPrdGroupInvItems_vue_vue_type_template_id_46db55ce___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableSummaryPrdGroupTotals_vue_vue_type_template_id_66d46e0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e&");
/* harmony import */ var _TableSummaryPrdGroupTotals_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableSummaryPrdGroupTotals_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableSummaryPrdGroupTotals_vue_vue_type_template_id_66d46e0e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableSummaryPrdGroupTotals_vue_vue_type_template_id_66d46e0e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_template_id_411f2583___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583&");
/* harmony import */ var _TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_template_id_411f2583___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_template_id_411f2583___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableSummaryPrdGroups_vue_vue_type_template_id_5dd56239___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239&");
/* harmony import */ var _TableSummaryPrdGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableSummaryPrdGroups.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableSummaryPrdGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableSummaryPrdGroups_vue_vue_type_template_id_5dd56239___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableSummaryPrdGroups_vue_vue_type_template_id_5dd56239___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Summarizes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Summarizes.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Summarizes_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupInvItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupInvItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotals_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotals_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroups.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=template&id=0e7d3027&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=template&id=0e7d3027& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Summarizes_vue_vue_type_template_id_0e7d3027___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Summarizes_vue_vue_type_template_id_0e7d3027___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Summarizes_vue_vue_type_template_id_0e7d3027___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Summarizes.vue?vue&type=template&id=0e7d3027& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=template&id=0e7d3027&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupInvItems_vue_vue_type_template_id_46db55ce___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupInvItems_vue_vue_type_template_id_46db55ce___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupInvItems_vue_vue_type_template_id_46db55ce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotals_vue_vue_type_template_id_66d46e0e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotals_vue_vue_type_template_id_66d46e0e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotals_vue_vue_type_template_id_66d46e0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_template_id_411f2583___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_template_id_411f2583___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroupTotalsNoApprove_vue_vue_type_template_id_411f2583___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroups_vue_vue_type_template_id_5dd56239___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroups_vue_vue_type_template_id_5dd56239___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableSummaryPrdGroups_vue_vue_type_template_id_5dd56239___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=template&id=0e7d3027&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Summarizes.vue?vue&type=template&id=0e7d3027& ***!
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
                    staticClass: "col-md-6 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" ปีบัญชีงบประมาณ ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.periodYearLabel,
                        expression: "periodYearLabel"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.periodYearLabel },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.periodYearLabel = $event.target.value
                      }
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-2" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-7 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" แผนการผลิตครั้งที่ ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-5" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.yearControl.plan_version_no,
                        expression: "yearControl.plan_version_no"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.yearControl.plan_version_no },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.yearControl,
                          "plan_version_no",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-2" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-5 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" ครั้งที่ ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-7" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.yearControl.ct14_last_version_no,
                        expression: "yearControl.ct14_last_version_no"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.yearControl.ct14_last_version_no },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.yearControl,
                          "ct14_last_version_no",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-4" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-6 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" วันที่เริ่มใช้ ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.yearControl.start_date_thai,
                        expression: "yearControl.start_date_thai"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.yearControl.start_date_thai },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.yearControl,
                          "start_date_thai",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-8" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-3 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" ศูนย์ต้นทุน ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-3" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.yearControl.cost_code,
                        expression: "yearControl.cost_code"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.yearControl.cost_code },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.yearControl,
                          "cost_code",
                          $event.target.value
                        )
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.yearControl.cost_description,
                        expression: "yearControl.cost_description"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.yearControl.cost_description },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.yearControl,
                          "cost_description",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-4" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-6 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" วันที่สิ้นสุด ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.yearControl.end_date_thai,
                        expression: "yearControl.end_date_thai"
                      }
                    ],
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: { value: _vm.yearControl.end_date_thai },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.yearControl,
                          "end_date_thai",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-8" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-3 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" ประเภทศูนย์ต้นทุน ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-9" }, [
                  _c("input", {
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: {
                      value: _vm.yearControl
                        ? _vm.yearControl.cost_center.cost_group_desc
                        : "-"
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-4" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-6 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" สถานะ ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("input", {
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: {
                      value: _vm.yearControl.approved_status
                        ? _vm.getApprovedStatusLabel(
                            _vm.yearControl.approved_status
                          )
                        : ""
                    }
                  })
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-4" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-6 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" เกณฑ์การปันส่วนครั้งที่ ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("input", {
                    staticClass: "form-control input-sm",
                    attrs: { type: "text", readonly: "" },
                    domProps: {
                      value: _vm.allocateYear
                        ? _vm.allocateYear.version_no
                        : "-"
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-5" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-md-4 col-form-label tw-font-bold tw-pt-0"
                  },
                  [_vm._v(" เปรียบเทียบค่าใช้จ่ายจากเดือน ")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-8" }, [
                  _c(
                    "div",
                    { staticClass: "input-group input-group-sm mb-3" },
                    [
                      _c("input", {
                        staticClass: "form-control text-center input-sm",
                        attrs: { type: "text", readonly: "" },
                        domProps: {
                          value: _vm.periodFromData
                            ? _vm.periodFromData.thai_month
                            : "-"
                        }
                      }),
                      _vm._v(" "),
                      _vm._m(0),
                      _vm._v(" "),
                      _c("input", {
                        staticClass: "form-control text-center input-sm",
                        attrs: { type: "text", readonly: "" },
                        domProps: {
                          value: _vm.periodToData
                            ? _vm.periodToData.thai_month
                            : "-"
                        }
                      })
                    ]
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-3" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-inline-block btn-primary tw-w-full",
                  attrs: {
                    disabled: !_vm.yearControl || !_vm.latestStdcostYear
                  },
                  on: {
                    click: function($event) {
                      return _vm.getStdcostPrdGroups(
                        _vm.yearControl.period_year,
                        _vm.yearControl.prdgrp_year_id,
                        _vm.yearControl.cost_code,
                        _vm.latestStdcostYear
                      )
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-arrow-down" }),
                  _vm._v(" คำนวณสรุปต้นทุน\n                ")
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }, [
            _c(
              "div",
              { staticClass: "col-12" },
              [
                _c("table-summary-prd-groups", {
                  attrs: {
                    "uom-codes": _vm.uomCodes,
                    "period-year-value": _vm.periodYear,
                    "stdcost-year": _vm.stdcostYear,
                    "stdcost-prd-groups": _vm.stdcostPrdGroupItems,
                    "allocate-types": _vm.allocateTypes
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c(
            "div",
            {
              staticStyle: {
                "background-color": "#d9d9d9",
                color: "black",
                "font-weight": "bold"
              }
            },
            [
              _vm._v(
                "\n            ผลิตภัณฑ์ที่ยังไม่อนุมัติราคาต้นทุนมาตรฐาน\n        "
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }, [
            _c(
              "div",
              { staticClass: "col-12" },
              [
                _c("table-summary-prd-group-totals-no-approve", {
                  attrs: {
                    "period-year-value": _vm.periodYear,
                    "stdcost-year": _vm.stdcostYearData,
                    "stdcost-prd-group-totals-no-approve":
                      _vm.stdcostPrdGroupTotalsNoApproveItems,
                    "allocate-types": _vm.allocateTypes
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticStyle: {
                "background-color": "#d9d9d9",
                color: "black",
                "font-weight": "bold"
              }
            },
            [
              _vm._v(
                "\n            ผลิตภัณฑ์ที่อนุมัติราคาต้นทุนมาตรฐานแล้ว\n        "
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }, [
            _c(
              "div",
              { staticClass: "col-12" },
              [
                _c("table-summary-prd-group-totals", {
                  attrs: {
                    "period-year-value": _vm.periodYear,
                    "stdcost-year": _vm.stdcostYearData,
                    "stdcost-prd-group-totals": _vm.stdcostPrdGroupTotalItems,
                    "allocate-types": _vm.allocateTypes
                  }
                })
              ],
              1
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
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "input-group-prepend input-group-append" },
      [
        _c(
          "span",
          {
            staticClass: "input-group-text",
            attrs: { id: "inputGroup-sizing-sm" }
          },
          [_vm._v(" ถึง ")]
        )
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupInvItems.vue?vue&type=template&id=46db55ce& ***!
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
      _c(
        "div",
        {
          staticClass: "table-responsive tw-pl-10",
          staticStyle: { "max-height": "300px" }
        },
        [
          _c(
            "table",
            { staticClass: "table table-bordered table-sticky mb-0" },
            [
              _vm._m(0),
              _vm._v(" "),
              _vm.stdcostPrdGroupInvItemItems.length > 0
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.stdcostPrdGroupInvItemItems, function(
                        stdcostPrdGroupInvItemItem,
                        index
                      ) {
                        return [
                          !stdcostPrdGroupInvItemItem.marked_as_deleted
                            ? _c("tr", { key: index }, [
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.product_group
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.product_item_number
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.item_number
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-left md:tw-table-cell" },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.item_desc
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.wip_step
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.wip_type
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.quantity_used
                                            ? Number(
                                                stdcostPrdGroupInvItemItem.quantity_used
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.uom_code
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.std_cost_rate
                                            ? Number(
                                                stdcostPrdGroupInvItemItem.std_cost_rate
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupInvItemItem.std_cost_amount
                                            ? Number(
                                                stdcostPrdGroupInvItemItem.std_cost_amount
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
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
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "5%" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "10%" }
          },
          [_vm._v(" ผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "8%" }
          },
          [_vm._v(" รหัสวัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "13%" }
          },
          [_vm._v(" วัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "8%" }
          },
          [_vm._v(" ขั้นตอน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "8%" }
          },
          [_vm._v(" ประเภท ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "12%" }
          },
          [_vm._v(" จำนวนรวม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "5%" }
          },
          [_vm._v(" หน่วย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "12%" }
          },
          [_vm._v(" อัตรามาตรฐาน/หน่วย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            staticStyle: { "background-color": "#fdf4e0" },
            attrs: { width: "12%" }
          },
          [_vm._v(" ต้นทุนวัตถุดิบ ")]
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
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotals.vue?vue&type=template&id=66d46e0e& ***!
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
    [
      _c(
        "div",
        {
          staticClass: "table-responsive",
          staticStyle: { "max-height": "300px" }
        },
        [
          _c(
            "table",
            { staticClass: "table table-bordered table-sticky mb-0" },
            [
              _vm._m(0),
              _vm._v(" "),
              _vm.stdcostPrdGroupTotalItems.length > 0
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.stdcostPrdGroupTotalItems, function(
                        stdcostPrdGroupTotalItem,
                        index
                      ) {
                        return [
                          !stdcostPrdGroupTotalItem.marked_as_deleted
                            ? _c("tr", { key: index }, [
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.product_group
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.product_item_number
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-left md:tw-table-cell" },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.product_item_desc
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.cost_raw_mate
                                            ? Number(
                                                stdcostPrdGroupTotalItem.cost_raw_mate
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.wage_cost
                                            ? Number(
                                                stdcostPrdGroupTotalItem.wage_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.vary_cost
                                            ? Number(
                                                stdcostPrdGroupTotalItem.vary_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.fixed_cost
                                            ? Number(
                                                stdcostPrdGroupTotalItem.fixed_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalItem.total_cost
                                            ? Number(
                                                stdcostPrdGroupTotalItem.total_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-center text-nowrap" },
                                  [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-inline-block btn-xs btn-white",
                                        on: {
                                          click: function($event) {
                                            return _vm.onGetStdcostPrdGroupInvItems(
                                              $event,
                                              stdcostPrdGroupTotalItem
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-list tw-mr-1"
                                        }),
                                        _vm._v(
                                          " เลือก\n                            "
                                        )
                                      ]
                                    )
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
      ),
      _vm._v(" "),
      _c("hr"),
      _vm._v(" "),
      _c("div", [
        _vm.stdcostPrdGroupInvItems.length > 0
          ? _c(
              "div",
              [
                _c("table-summary-prd-group-inv-items", {
                  attrs: {
                    "period-year-value": _vm.periodYear,
                    "stdcost-year": _vm.stdcostYearData,
                    "stdcost-prd-group-total":
                      _vm.selectedStdcostPrdGroupTotalItem,
                    "stdcost-prd-group-inv-items": _vm.stdcostPrdGroupInvItems
                  }
                })
              ],
              1
            )
          : _vm._e()
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
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "5%" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "10%" }
          },
          [_vm._v(" ผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "15%" }
          },
          [_vm._v(" รายละเอียด ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ต้นทุนวัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ค่าแรง ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ค่าใช้จ่ายผันแปร ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ค่าใช้จ่ายคงที่ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" รวม ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-right tw-text-xs md:tw-table-cell",
          attrs: { width: "10%" }
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
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583&":
/*!******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroupTotalsNoApprove.vue?vue&type=template&id=411f2583& ***!
  \******************************************************************************************************************************************************************************************************************************************************************/
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
          staticStyle: { "max-height": "300px" }
        },
        [
          _c(
            "table",
            { staticClass: "table table-bordered table-sticky mb-0" },
            [
              _vm._m(0),
              _vm._v(" "),
              _vm.stdcostPrdGroupTotalsNoApproveItems.length > 0
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.stdcostPrdGroupTotalsNoApproveItems, function(
                        stdcostPrdGroupTotalsNoApproveItems,
                        index
                      ) {
                        return [
                          !stdcostPrdGroupTotalsNoApproveItems.marked_as_deleted
                            ? _c("tr", { key: index }, [
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.product_group
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.product_item_number
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-left md:tw-table-cell" },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.product_item_desc
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.cost_raw_mate
                                            ? Number(
                                                stdcostPrdGroupTotalsNoApproveItems.cost_raw_mate
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.wage_cost
                                            ? Number(
                                                stdcostPrdGroupTotalsNoApproveItems.wage_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.vary_cost
                                            ? Number(
                                                stdcostPrdGroupTotalsNoApproveItems.vary_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.fixed_cost
                                            ? Number(
                                                stdcostPrdGroupTotalsNoApproveItems.fixed_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupTotalsNoApproveItems.total_cost
                                            ? Number(
                                                stdcostPrdGroupTotalsNoApproveItems.total_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-center text-nowrap" },
                                  [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-inline-block btn-xs btn-white",
                                        on: {
                                          click: function($event) {
                                            return _vm.onGetStdcostPrdGroupInvItems(
                                              $event,
                                              stdcostPrdGroupTotalsNoApproveItems
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-list tw-mr-1"
                                        }),
                                        _vm._v(
                                          " เลือก\n                            "
                                        )
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-center text-nowrap" },
                                  [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-inline-block btn-primary tw-w-full",
                                        on: {
                                          click: function($event) {
                                            return _vm.onGetcostPrdActiveNewItem(
                                              $event,
                                              stdcostPrdGroupTotalsNoApproveItems
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-list tw-mr-1"
                                        }),
                                        _vm._v(
                                          " อนุมัติต้นทุนมาตรฐาน\n                            "
                                        )
                                      ]
                                    )
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
      ),
      _vm._v(" "),
      _c("hr"),
      _vm._v(" "),
      _c("div", [
        _vm.stdcostPrdGroupInvItemsNoApprove.length > 0
          ? _c(
              "div",
              [
                _c("table-summary-prd-group-inv-items", {
                  attrs: {
                    "period-year-value": _vm.periodYear,
                    "stdcost-year": _vm.stdcostYearData,
                    "stdcost-prd-group-total":
                      _vm.selectedStdcostPrdGroupTotalItem,
                    "stdcost-prd-group-inv-items":
                      _vm.stdcostPrdGroupInvItemsNoApprove
                  }
                })
              ],
              1
            )
          : _vm._e()
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
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "5%" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "10%" }
          },
          [_vm._v(" ผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "15%" }
          },
          [_vm._v(" รายละเอียด ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ต้นทุนวัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ค่าแรง ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ค่าใช้จ่ายผันแปร ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" ค่าใช้จ่ายคงที่ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "11%" }
          },
          [_vm._v(" รวม ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-right tw-text-xs md:tw-table-cell",
          attrs: { width: "10%" }
        }),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "5%" }
          },
          [_vm._v(" อนุมัติต้นทุนมาตรฐาน ")]
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
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableSummaryPrdGroups.vue?vue&type=template&id=5dd56239& ***!
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
    [
      _c(
        "div",
        {
          staticClass: "table-responsive",
          staticStyle: { "max-height": "300px" }
        },
        [
          _c(
            "table",
            { staticClass: "table table-bordered table-sticky mb-0" },
            [
              _vm._m(0),
              _vm._v(" "),
              _vm.stdcostPrdGroupItems.length > 0
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.stdcostPrdGroupItems, function(
                        stdcostPrdGroupItem,
                        index
                      ) {
                        return [
                          !stdcostPrdGroupItem.marked_as_deleted
                            ? _c("tr", { key: index }, [
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.product_group
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-left md:tw-table-cell" },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.product_group_desc
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.cost_quantity
                                            ? Number(
                                                stdcostPrdGroupItem.cost_quantity
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                              })
                                            : "0.00"
                                        ) +
                                        " \n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.cost_uom_code_desc
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.wage_cost
                                            ? Number(
                                                stdcostPrdGroupItem.wage_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        " \n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.vary_cost
                                            ? Number(
                                                stdcostPrdGroupItem.vary_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        " \n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass: "text-right md:tw-table-cell"
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostPrdGroupItem.fixed_cost
                                            ? Number(
                                                stdcostPrdGroupItem.fixed_cost
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractionDigits: 9
                                              })
                                            : "0.000000000"
                                        ) +
                                        " \n                        "
                                    )
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
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "10%" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "15%" }
          },
          [_vm._v(" รายละเอียด ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" แสดงค่าหน่วยนับต่อศูนย์ต้นทุน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "7%" }
          },
          [_vm._v(" หน่วยนับ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "15%" }
          },
          [_vm._v(" ค่าแรง ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "15%" }
          },
          [_vm._v(" ค่าใช้จ่ายผันแปร ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "15%" }
          },
          [_vm._v(" ค่าใช้จ่ายคงที่ ")]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "7" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v("ไม่พบข้อมูล")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);