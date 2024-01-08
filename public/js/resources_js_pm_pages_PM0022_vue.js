(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_PM0022_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _httpClient__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../httpClient */ "./resources/js/pm/httpClient.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash/cloneDeep */ "./node_modules/lodash/cloneDeep.js");
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var lodash_isNil__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash/isNil */ "./node_modules/lodash/isNil.js");
/* harmony import */ var lodash_isNil__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash_isNil__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../router */ "./resources/js/router.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






function getDailyReports(date) {
  console.debug('getDailyReports');
  return _httpClient__WEBPACK_IMPORTED_MODULE_0__.instance.get((0,_router__WEBPACK_IMPORTED_MODULE_4__.$route)(_router__WEBPACK_IMPORTED_MODULE_4__.api_pm_ingredientPreparationList_index), {
    params: {
      'date': date
    }
  });
}

function getDailyReportDetails(reportId, token) {
  console.debug('getDailyReportDetails');
  return _httpClient__WEBPACK_IMPORTED_MODULE_0__.instance.get((0,_router__WEBPACK_IMPORTED_MODULE_4__.$route)(_router__WEBPACK_IMPORTED_MODULE_4__.api_pm_ingredientPreparationList_reports, {
    id: reportId
  }), {
    cancelToken: token
  });
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      lodash: {
        cloneDeep: (lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2___default()),
        isNil: (lodash_isNil__WEBPACK_IMPORTED_MODULE_3___default())
      },
      dailyRawMaterials: lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2___default()(this.daily_raw_materials),
      reportDate: this.date,
      isLoading: false,
      isReportDetailsLoading: false,
      currentReport: null,
      reportDetails: null,
      currentRequestSource: null,
      currentItemDesc1: null,
      currentItemCode: null,
      currentItemDesc2: null,
      currentQRCode: null
    };
  },
  props: {
    daily_raw_materials: {
      type: Array,
      "default": null
    },
    date: {
      type: String,
      "default": null
    }
  },
  methods: {
    onRequestDateChanged: function onRequestDateChanged(event) {
      var _this = this;

      console.debug('onRequestDateChanged', event);
      var newRequestDate = event.target.value;
      this.isLoading = true;
      getDailyReports(newRequestDate).then(function (result) {
        console.debug(result);
        _this.isLoading = false;
        _this.dailyRawMaterials = result.data.dailyRawMaterials;
      })["catch"](function (err) {
        console.debug(err);
        _this.isLoading = false;
      });
    },
    onShowDetailClicked: function onShowDetailClicked(report) {
      var _this2 = this;

      console.debug('report', report, this.currentRequestSource);
      this.reportDetails = null;
      this.currentReport = report;
      this.currentItemDesc1 = report.item_desc1;
      this.currentItemDesc2 = report.item_desc2;
      this.currentItemCode = report.item_code;
      this.currentQRCode = report.qr_code;

      if (this.currentRequestSource) {
        this.currentRequestSource.cancel('CancelRequest');
      }

      this.currentRequestSource = axios__WEBPACK_IMPORTED_MODULE_1___default().CancelToken.source();
      this.isReportDetailsLoading = true;
      getDailyReportDetails(report.report_id, this.currentRequestSource.token).then(function (result) {
        console.debug(result);
        _this2.isReportDetailsLoading = false;
        _this2.reportDetails = result.data.reportDetails;
      })["catch"](function (err) {
        console.debug(err, axios__WEBPACK_IMPORTED_MODULE_1___default().isCancel(err));

        if (!axios__WEBPACK_IMPORTED_MODULE_1___default().isCancel(err)) {
          _this2.isReportDetailsLoading = false;
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/pm/httpClient.js":
/*!***************************************!*\
  !*** ./resources/js/pm/httpClient.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "instance": () => /* binding */ instance
/* harmony export */ });
var defaultOptions = {
  baseURL: '/',
  headers: {
    'Content-Type': 'application/json'
  }
};

var _instance = axios.create(defaultOptions);

_instance.interceptors.request.use(function (config) {
  return config;
});

var instance = _instance;

/***/ }),

/***/ "./resources/js/router.js":
/*!********************************!*\
  !*** ./resources/js/router.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "$route": () => /* binding */ $route,
/* harmony export */   "debugbar_openhandler": () => /* binding */ debugbar_openhandler,
/* harmony export */   "debugbar_clockwork": () => /* binding */ debugbar_clockwork,
/* harmony export */   "debugbar_telescope": () => /* binding */ debugbar_telescope,
/* harmony export */   "debugbar_assets_css": () => /* binding */ debugbar_assets_css,
/* harmony export */   "debugbar_assets_js": () => /* binding */ debugbar_assets_js,
/* harmony export */   "debugbar_cache_delete": () => /* binding */ debugbar_cache_delete,
/* harmony export */   "horizon_stats_index": () => /* binding */ horizon_stats_index,
/* harmony export */   "horizon_workload_index": () => /* binding */ horizon_workload_index,
/* harmony export */   "horizon_masters_index": () => /* binding */ horizon_masters_index,
/* harmony export */   "horizon_monitoring_index": () => /* binding */ horizon_monitoring_index,
/* harmony export */   "horizon_monitoring_store": () => /* binding */ horizon_monitoring_store,
/* harmony export */   "horizon_monitoringTag_paginate": () => /* binding */ horizon_monitoringTag_paginate,
/* harmony export */   "horizon_monitoringTag_destroy": () => /* binding */ horizon_monitoringTag_destroy,
/* harmony export */   "horizon_jobsMetrics_index": () => /* binding */ horizon_jobsMetrics_index,
/* harmony export */   "horizon_jobsMetrics_show": () => /* binding */ horizon_jobsMetrics_show,
/* harmony export */   "horizon_queuesMetrics_index": () => /* binding */ horizon_queuesMetrics_index,
/* harmony export */   "horizon_queuesMetrics_show": () => /* binding */ horizon_queuesMetrics_show,
/* harmony export */   "horizon_jobsBatches_index": () => /* binding */ horizon_jobsBatches_index,
/* harmony export */   "horizon_jobsBatches_show": () => /* binding */ horizon_jobsBatches_show,
/* harmony export */   "horizon_jobsBatches_retry": () => /* binding */ horizon_jobsBatches_retry,
/* harmony export */   "horizon_pendingJobs_index": () => /* binding */ horizon_pendingJobs_index,
/* harmony export */   "horizon_completedJobs_index": () => /* binding */ horizon_completedJobs_index,
/* harmony export */   "horizon_failedJobs_index": () => /* binding */ horizon_failedJobs_index,
/* harmony export */   "horizon_failedJobs_show": () => /* binding */ horizon_failedJobs_show,
/* harmony export */   "horizon_retryJobs_show": () => /* binding */ horizon_retryJobs_show,
/* harmony export */   "horizon_jobs_show": () => /* binding */ horizon_jobs_show,
/* harmony export */   "horizon_index": () => /* binding */ horizon_index,
/* harmony export */   "ajax_pm_plans_yearly_getInfo": () => /* binding */ ajax_pm_plans_yearly_getInfo,
/* harmony export */   "ajax_pm_plans_yearly_getSourceVersions": () => /* binding */ ajax_pm_plans_yearly_getSourceVersions,
/* harmony export */   "ajax_pm_plans_yearly_addNewHeader": () => /* binding */ ajax_pm_plans_yearly_addNewHeader,
/* harmony export */   "ajax_pm_plans_yearly_getSalePlans": () => /* binding */ ajax_pm_plans_yearly_getSalePlans,
/* harmony export */   "ajax_pm_plans_yearly_getLines": () => /* binding */ ajax_pm_plans_yearly_getLines,
/* harmony export */   "ajax_pm_plans_yearly_generateLines": () => /* binding */ ajax_pm_plans_yearly_generateLines,
/* harmony export */   "ajax_pm_plans_yearly_storeLines": () => /* binding */ ajax_pm_plans_yearly_storeLines,
/* harmony export */   "ajax_pm_plans_yearly_submitApproval": () => /* binding */ ajax_pm_plans_yearly_submitApproval,
/* harmony export */   "ajax_pm_plans_yearly_submitPlan": () => /* binding */ ajax_pm_plans_yearly_submitPlan,
/* harmony export */   "ajax_pm_plans_yearly_approve": () => /* binding */ ajax_pm_plans_yearly_approve,
/* harmony export */   "ajax_pm_plans_yearly_reject": () => /* binding */ ajax_pm_plans_yearly_reject,
/* harmony export */   "ajax_pm_plans_monthly_getInfo": () => /* binding */ ajax_pm_plans_monthly_getInfo,
/* harmony export */   "ajax_pm_plans_monthly_getSourceVersions": () => /* binding */ ajax_pm_plans_monthly_getSourceVersions,
/* harmony export */   "ajax_pm_plans_monthly_addNewHeader": () => /* binding */ ajax_pm_plans_monthly_addNewHeader,
/* harmony export */   "ajax_pm_plans_monthly_getMonths": () => /* binding */ ajax_pm_plans_monthly_getMonths,
/* harmony export */   "ajax_pm_plans_monthly_getSalePlans": () => /* binding */ ajax_pm_plans_monthly_getSalePlans,
/* harmony export */   "ajax_pm_plans_monthly_getLines": () => /* binding */ ajax_pm_plans_monthly_getLines,
/* harmony export */   "ajax_pm_plans_monthly_generateLines": () => /* binding */ ajax_pm_plans_monthly_generateLines,
/* harmony export */   "ajax_pm_plans_monthly_storeLines": () => /* binding */ ajax_pm_plans_monthly_storeLines,
/* harmony export */   "ajax_pm_plans_monthly_submitPlan": () => /* binding */ ajax_pm_plans_monthly_submitPlan,
/* harmony export */   "ajax_pm_plans_biweekly_getInfo": () => /* binding */ ajax_pm_plans_biweekly_getInfo,
/* harmony export */   "ajax_pm_plans_biweekly_getSourceVersions": () => /* binding */ ajax_pm_plans_biweekly_getSourceVersions,
/* harmony export */   "ajax_pm_plans_biweekly_addNewHeader": () => /* binding */ ajax_pm_plans_biweekly_addNewHeader,
/* harmony export */   "ajax_pm_plans_biweekly_getMonths": () => /* binding */ ajax_pm_plans_biweekly_getMonths,
/* harmony export */   "ajax_pm_plans_biweekly_getBiweeks": () => /* binding */ ajax_pm_plans_biweekly_getBiweeks,
/* harmony export */   "ajax_pm_plans_biweekly_getLines": () => /* binding */ ajax_pm_plans_biweekly_getLines,
/* harmony export */   "ajax_pm_plans_biweekly_generateLines": () => /* binding */ ajax_pm_plans_biweekly_generateLines,
/* harmony export */   "ajax_pm_plans_biweekly_storeLines": () => /* binding */ ajax_pm_plans_biweekly_storeLines,
/* harmony export */   "ajax_pm_plans_biweekly_submitApproval": () => /* binding */ ajax_pm_plans_biweekly_submitApproval,
/* harmony export */   "ajax_pm_plans_biweekly_submitOpenOrder": () => /* binding */ ajax_pm_plans_biweekly_submitOpenOrder,
/* harmony export */   "ajax_pm_plans_biweekly_approve": () => /* binding */ ajax_pm_plans_biweekly_approve,
/* harmony export */   "ajax_pm_plans_biweekly_reject": () => /* binding */ ajax_pm_plans_biweekly_reject,
/* harmony export */   "ajax_pm_plans_daily_getInfo": () => /* binding */ ajax_pm_plans_daily_getInfo,
/* harmony export */   "ajax_pm_plans_daily_getSourceVersions": () => /* binding */ ajax_pm_plans_daily_getSourceVersions,
/* harmony export */   "ajax_pm_plans_daily_addNewHeader": () => /* binding */ ajax_pm_plans_daily_addNewHeader,
/* harmony export */   "ajax_pm_plans_daily_getMonths": () => /* binding */ ajax_pm_plans_daily_getMonths,
/* harmony export */   "ajax_pm_plans_daily_getBiweeks": () => /* binding */ ajax_pm_plans_daily_getBiweeks,
/* harmony export */   "ajax_pm_plans_daily_getWeeks": () => /* binding */ ajax_pm_plans_daily_getWeeks,
/* harmony export */   "ajax_pm_plans_daily_getLines": () => /* binding */ ajax_pm_plans_daily_getLines,
/* harmony export */   "ajax_pm_plans_daily_generateLines": () => /* binding */ ajax_pm_plans_daily_generateLines,
/* harmony export */   "ajax_pm_plans_daily_getRemianingItems": () => /* binding */ ajax_pm_plans_daily_getRemianingItems,
/* harmony export */   "ajax_pm_plans_daily_storeLine": () => /* binding */ ajax_pm_plans_daily_storeLine,
/* harmony export */   "ajax_pm_plans_daily_addNewMachineLine": () => /* binding */ ajax_pm_plans_daily_addNewMachineLine,
/* harmony export */   "ajax_pm_plans_daily_addNewLine": () => /* binding */ ajax_pm_plans_daily_addNewLine,
/* harmony export */   "ajax_pm_plans_daily_deleteMachineLine": () => /* binding */ ajax_pm_plans_daily_deleteMachineLine,
/* harmony export */   "ajax_pm_plans_daily_deleteLine": () => /* binding */ ajax_pm_plans_daily_deleteLine,
/* harmony export */   "ajax_pm_plans_daily_submitPlan": () => /* binding */ ajax_pm_plans_daily_submitPlan,
/* harmony export */   "ajax_pm_products_machineRequests_getRequests": () => /* binding */ ajax_pm_products_machineRequests_getRequests,
/* harmony export */   "ajax_pm_products_machineRequests_generateRequests": () => /* binding */ ajax_pm_products_machineRequests_generateRequests,
/* harmony export */   "ajax_pm_products_machineRequests_storeRequests": () => /* binding */ ajax_pm_products_machineRequests_storeRequests,
/* harmony export */   "ajax_pm_products_machineRequests_exportPdf": () => /* binding */ ajax_pm_products_machineRequests_exportPdf,
/* harmony export */   "ajax_pm_products_transfers_findHeader": () => /* binding */ ajax_pm_products_transfers_findHeader,
/* harmony export */   "ajax_pm_products_transfers_getHeaders": () => /* binding */ ajax_pm_products_transfers_getHeaders,
/* harmony export */   "ajax_pm_products_transfers_storeHeader": () => /* binding */ ajax_pm_products_transfers_storeHeader,
/* harmony export */   "ajax_pm_products_transfers_getLines": () => /* binding */ ajax_pm_products_transfers_getLines,
/* harmony export */   "ajax_pm_products_transfers_getConfirmItems": () => /* binding */ ajax_pm_products_transfers_getConfirmItems,
/* harmony export */   "ajax_pm_products_transfers_getOnhands": () => /* binding */ ajax_pm_products_transfers_getOnhands,
/* harmony export */   "ajax_pm_products_transfers_storeLines": () => /* binding */ ajax_pm_products_transfers_storeLines,
/* harmony export */   "ajax_pm_products_transfers_confirmRequest": () => /* binding */ ajax_pm_products_transfers_confirmRequest,
/* harmony export */   "ajax_pm_products_transfers_discardConfirmedRequest": () => /* binding */ ajax_pm_products_transfers_discardConfirmedRequest,
/* harmony export */   "ajax_pm_products_transfers_cancelRequest": () => /* binding */ ajax_pm_products_transfers_cancelRequest,
/* harmony export */   "ajax_pm_products_transfers_submitRequest": () => /* binding */ ajax_pm_products_transfers_submitRequest,
/* harmony export */   "api_db_lookup": () => /* binding */ api_db_lookup,
/* harmony export */   "outstandingTest_index": () => /* binding */ outstandingTest_index,
/* harmony export */   "api_kms_expenseAll": () => /* binding */ api_kms_expenseAll,
/* harmony export */   "api_kms_expenseDept": () => /* binding */ api_kms_expenseDept,
/* harmony export */   "api_pd_lookup": () => /* binding */ api_pd_lookup,
/* harmony export */   "api_pd_": () => /* binding */ api_pd_,
/* harmony export */   "api_pd_flavorNo_search": () => /* binding */ api_pd_flavorNo_search,
/* harmony export */   "api_pd_flavorNo_store": () => /* binding */ api_pd_flavorNo_store,
/* harmony export */   "api_pd_invMaterialItem_update": () => /* binding */ api_pd_invMaterialItem_update,
/* harmony export */   "api_pd_invMaterialItem_create": () => /* binding */ api_pd_invMaterialItem_create,
/* harmony export */   "api_pd_0004_store": () => /* binding */ api_pd_0004_store,
/* harmony export */   "api_pd_invMaterialItem_store": () => /* binding */ api_pd_invMaterialItem_store,
/* harmony export */   "api_pd_0004_show": () => /* binding */ api_pd_0004_show,
/* harmony export */   "api_pd_invMaterialItem_show": () => /* binding */ api_pd_invMaterialItem_show,
/* harmony export */   "api_pd_0004_update": () => /* binding */ api_pd_0004_update,
/* harmony export */   "api_pd_0005_search": () => /* binding */ api_pd_0005_search,
/* harmony export */   "api_pd_exampleCigarettes_search": () => /* binding */ api_pd_exampleCigarettes_search,
/* harmony export */   "api_pd_0005_store": () => /* binding */ api_pd_0005_store,
/* harmony export */   "api_pd_exampleCigarettes_store": () => /* binding */ api_pd_exampleCigarettes_store,
/* harmony export */   "api_pd_0005_show": () => /* binding */ api_pd_0005_show,
/* harmony export */   "api_pd_exampleCigarettes_show": () => /* binding */ api_pd_exampleCigarettes_show,
/* harmony export */   "api_pd_0005_update": () => /* binding */ api_pd_0005_update,
/* harmony export */   "api_pd_exampleCigarettes_update": () => /* binding */ api_pd_exampleCigarettes_update,
/* harmony export */   "api_pd_0006_blendFormulae_index": () => /* binding */ api_pd_0006_blendFormulae_index,
/* harmony export */   "api_pd_createTrialTobaccoFormula_blendFormulae_index": () => /* binding */ api_pd_createTrialTobaccoFormula_blendFormulae_index,
/* harmony export */   "api_pd_0006_blendFormulae_show": () => /* binding */ api_pd_0006_blendFormulae_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_blendFormulae_show": () => /* binding */ api_pd_createTrialTobaccoFormula_blendFormulae_show,
/* harmony export */   "api_pd_0006_blendFormulae_update": () => /* binding */ api_pd_0006_blendFormulae_update,
/* harmony export */   "api_pd_createTrialTobaccoFormula_blendFormulae_update": () => /* binding */ api_pd_createTrialTobaccoFormula_blendFormulae_update,
/* harmony export */   "api_pd_0006_mfgFormulae_show": () => /* binding */ api_pd_0006_mfgFormulae_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_mfgFormulae_show": () => /* binding */ api_pd_createTrialTobaccoFormula_mfgFormulae_show,
/* harmony export */   "api_pd_0006_leafFormulae_show": () => /* binding */ api_pd_0006_leafFormulae_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_leafFormulae_show": () => /* binding */ api_pd_createTrialTobaccoFormula_leafFormulae_show,
/* harmony export */   "api_pd_0006_lookupItemNumbers_show": () => /* binding */ api_pd_0006_lookupItemNumbers_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_lookupItemNumbers_show": () => /* binding */ api_pd_createTrialTobaccoFormula_lookupItemNumbers_show,
/* harmony export */   "api_pd_0006_lookupCasings_show": () => /* binding */ api_pd_0006_lookupCasings_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_lookupCasings_show": () => /* binding */ api_pd_createTrialTobaccoFormula_lookupCasings_show,
/* harmony export */   "api_pd_0006_lookupFlavours_show": () => /* binding */ api_pd_0006_lookupFlavours_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_lookupFlavours_show": () => /* binding */ api_pd_createTrialTobaccoFormula_lookupFlavours_show,
/* harmony export */   "api_pd_0006_lookupExampleCigarettes_show": () => /* binding */ api_pd_0006_lookupExampleCigarettes_show,
/* harmony export */   "api_pd_createTrialTobaccoFormula_lookupExampleCigarettes_show": () => /* binding */ api_pd_createTrialTobaccoFormula_lookupExampleCigarettes_show,
/* harmony export */   "api_pd_expandedTobacco_index": () => /* binding */ api_pd_expandedTobacco_index,
/* harmony export */   "api_pd_expandedTobacco_create": () => /* binding */ api_pd_expandedTobacco_create,
/* harmony export */   "api_pd_expandedTobacco_store": () => /* binding */ api_pd_expandedTobacco_store,
/* harmony export */   "api_pd_expandedTobacco_show": () => /* binding */ api_pd_expandedTobacco_show,
/* harmony export */   "api_pd_expandedTobacco_edit": () => /* binding */ api_pd_expandedTobacco_edit,
/* harmony export */   "api_pd_expandedTobacco_update": () => /* binding */ api_pd_expandedTobacco_update,
/* harmony export */   "api_pd_expandedTobacco_destroy": () => /* binding */ api_pd_expandedTobacco_destroy,
/* harmony export */   "api_pd_0009_search": () => /* binding */ api_pd_0009_search,
/* harmony export */   "api_pm_0001_search": () => /* binding */ api_pm_0001_search,
/* harmony export */   "api_pm_productionOrder_search": () => /* binding */ api_pm_productionOrder_search,
/* harmony export */   "api_pm_0001_uom": () => /* binding */ api_pm_0001_uom,
/* harmony export */   "api_pm_productionOrder_uom": () => /* binding */ api_pm_productionOrder_uom,
/* harmony export */   "api_pm_0001_store": () => /* binding */ api_pm_0001_store,
/* harmony export */   "api_pm_productionOrder_store": () => /* binding */ api_pm_productionOrder_store,
/* harmony export */   "api_pm_0001_update": () => /* binding */ api_pm_0001_update,
/* harmony export */   "api_pm_productionOrder_update": () => /* binding */ api_pm_productionOrder_update,
/* harmony export */   "api_pm_ajax_productionOrder_batchStatus": () => /* binding */ api_pm_ajax_productionOrder_batchStatus,
/* harmony export */   "api_pm_ajax_productionOrder_jobType": () => /* binding */ api_pm_ajax_productionOrder_jobType,
/* harmony export */   "api_pm_0005_index": () => /* binding */ api_pm_0005_index,
/* harmony export */   "api_pm_requestMaterials_index": () => /* binding */ api_pm_requestMaterials_index,
/* harmony export */   "api_pm_0005_lines": () => /* binding */ api_pm_0005_lines,
/* harmony export */   "api_pm_requestMaterials_lines": () => /* binding */ api_pm_requestMaterials_lines,
/* harmony export */   "api_pm_0005_save": () => /* binding */ api_pm_0005_save,
/* harmony export */   "api_pm_requestMaterials_save": () => /* binding */ api_pm_requestMaterials_save,
/* harmony export */   "api_pm_0005_confirmTransfer": () => /* binding */ api_pm_0005_confirmTransfer,
/* harmony export */   "api_pm_requestMaterials_confirmTransfer": () => /* binding */ api_pm_requestMaterials_confirmTransfer,
/* harmony export */   "api_pm_00052_index": () => /* binding */ api_pm_00052_index,
/* harmony export */   "api_pm_00052_lines": () => /* binding */ api_pm_00052_lines,
/* harmony export */   "api_pm_00052_save": () => /* binding */ api_pm_00052_save,
/* harmony export */   "api_pm_00052_confirmTransfer": () => /* binding */ api_pm_00052_confirmTransfer,
/* harmony export */   "api_pm_0006_jobs_index": () => /* binding */ api_pm_0006_jobs_index,
/* harmony export */   "api_pm_reportProductInProcess_jobs_index": () => /* binding */ api_pm_reportProductInProcess_jobs_index,
/* harmony export */   "api_pm_0006_jobs_show": () => /* binding */ api_pm_0006_jobs_show,
/* harmony export */   "api_pm_reportProductInProcess_jobs_show": () => /* binding */ api_pm_reportProductInProcess_jobs_show,
/* harmony export */   "api_pm_0006_jobLines_show": () => /* binding */ api_pm_0006_jobLines_show,
/* harmony export */   "api_pm_reportProductInProcess_jobLines_show": () => /* binding */ api_pm_reportProductInProcess_jobLines_show,
/* harmony export */   "api_pm_0006_jobLines_update": () => /* binding */ api_pm_0006_jobLines_update,
/* harmony export */   "api_pm_reportProductInProcess_jobLines_update": () => /* binding */ api_pm_reportProductInProcess_jobLines_update,
/* harmony export */   "api_pm_0006_importMesData": () => /* binding */ api_pm_0006_importMesData,
/* harmony export */   "api_pm_reportProductInProcess_importMesData": () => /* binding */ api_pm_reportProductInProcess_importMesData,
/* harmony export */   "api_pm_0007_show": () => /* binding */ api_pm_0007_show,
/* harmony export */   "api_pm_cutRawMaterial_show": () => /* binding */ api_pm_cutRawMaterial_show,
/* harmony export */   "api_pm_0007_lookupTransactionDate": () => /* binding */ api_pm_0007_lookupTransactionDate,
/* harmony export */   "api_pm_cutRawMaterial_lookupTransactionDate": () => /* binding */ api_pm_cutRawMaterial_lookupTransactionDate,
/* harmony export */   "api_pm_0007_save": () => /* binding */ api_pm_0007_save,
/* harmony export */   "api_pm_cutRawMaterial_save": () => /* binding */ api_pm_cutRawMaterial_save,
/* harmony export */   "api_pm_0007_cutIssue": () => /* binding */ api_pm_0007_cutIssue,
/* harmony export */   "api_pm_cutRawMaterial_cutIssue": () => /* binding */ api_pm_cutRawMaterial_cutIssue,
/* harmony export */   "api_pm_": () => /* binding */ api_pm_,
/* harmony export */   "api_pm_reviewComplete_index": () => /* binding */ api_pm_reviewComplete_index,
/* harmony export */   "api_pm_0011_index": () => /* binding */ api_pm_0011_index,
/* harmony export */   "api_pm_reviewComplete_search": () => /* binding */ api_pm_reviewComplete_search,
/* harmony export */   "api_pm_0011_search": () => /* binding */ api_pm_0011_search,
/* harmony export */   "api_pm_reviewComplete_save": () => /* binding */ api_pm_reviewComplete_save,
/* harmony export */   "api_pm_0011_save": () => /* binding */ api_pm_0011_save,
/* harmony export */   "api_pm_planningJobLines_lines": () => /* binding */ api_pm_planningJobLines_lines,
/* harmony export */   "api_pm_0011_lines": () => /* binding */ api_pm_0011_lines,
/* harmony export */   "api_pm_planningJobLines_lookupBlendNo": () => /* binding */ api_pm_planningJobLines_lookupBlendNo,
/* harmony export */   "api_pm_0011_lookupBlendNo": () => /* binding */ api_pm_0011_lookupBlendNo,
/* harmony export */   "api_pm_planningJobLines_updateLines": () => /* binding */ api_pm_planningJobLines_updateLines,
/* harmony export */   "api_pm_0011_updateLines": () => /* binding */ api_pm_0011_updateLines,
/* harmony export */   "api_pm_0018_": () => /* binding */ api_pm_0018_,
/* harmony export */   "api_pm_0019_": () => /* binding */ api_pm_0019_,
/* harmony export */   "api_pm_0020_show": () => /* binding */ api_pm_0020_show,
/* harmony export */   "api_pm_machineIngredientRequests_show": () => /* binding */ api_pm_machineIngredientRequests_show,
/* harmony export */   "api_pm_0020_update": () => /* binding */ api_pm_0020_update,
/* harmony export */   "api_pm_machineIngredientRequests_update": () => /* binding */ api_pm_machineIngredientRequests_update,
/* harmony export */   "api_pm_0020_store": () => /* binding */ api_pm_0020_store,
/* harmony export */   "api_pm_machineIngredientRequests_store": () => /* binding */ api_pm_machineIngredientRequests_store,
/* harmony export */   "api_pm_0020_lines": () => /* binding */ api_pm_0020_lines,
/* harmony export */   "api_pm_machineIngredientRequests_lines": () => /* binding */ api_pm_machineIngredientRequests_lines,
/* harmony export */   "api_pm_0021_index": () => /* binding */ api_pm_0021_index,
/* harmony export */   "api_pm_ingredientRequests_index": () => /* binding */ api_pm_ingredientRequests_index,
/* harmony export */   "api_pm_0022_index": () => /* binding */ api_pm_0022_index,
/* harmony export */   "api_pm_ingredientPreparationList_index": () => /* binding */ api_pm_ingredientPreparationList_index,
/* harmony export */   "api_pm_0022_reports": () => /* binding */ api_pm_0022_reports,
/* harmony export */   "api_pm_ingredientPreparationList_reports": () => /* binding */ api_pm_ingredientPreparationList_reports,
/* harmony export */   "api_pm_0023_rawMaterials": () => /* binding */ api_pm_0023_rawMaterials,
/* harmony export */   "api_pm_transactionPnkCheckMaterial_rawMaterials": () => /* binding */ api_pm_transactionPnkCheckMaterial_rawMaterials,
/* harmony export */   "api_pm_0023_compareRawMaterials": () => /* binding */ api_pm_0023_compareRawMaterials,
/* harmony export */   "api_pm_transactionPnkCheckMaterial_compareRawMaterials": () => /* binding */ api_pm_transactionPnkCheckMaterial_compareRawMaterials,
/* harmony export */   "api_pm_0027_index": () => /* binding */ api_pm_0027_index,
/* harmony export */   "api_pm_sampleCigarettes_index": () => /* binding */ api_pm_sampleCigarettes_index,
/* harmony export */   "api_pm_0027_show": () => /* binding */ api_pm_0027_show,
/* harmony export */   "api_pm_sampleCigarettes_show": () => /* binding */ api_pm_sampleCigarettes_show,
/* harmony export */   "api_pm_0027_update": () => /* binding */ api_pm_0027_update,
/* harmony export */   "api_pm_sampleCigarettes_update": () => /* binding */ api_pm_sampleCigarettes_update,
/* harmony export */   "api_pm_0027_delete": () => /* binding */ api_pm_0027_delete,
/* harmony export */   "api_pm_sampleCigarettes_delete": () => /* binding */ api_pm_sampleCigarettes_delete,
/* harmony export */   "api_pm_0028_getProductByDate": () => /* binding */ api_pm_0028_getProductByDate,
/* harmony export */   "api_pm_freeProducts_getProductByDate": () => /* binding */ api_pm_freeProducts_getProductByDate,
/* harmony export */   "api_pm_0028_update": () => /* binding */ api_pm_0028_update,
/* harmony export */   "api_pm_freeProducts_update": () => /* binding */ api_pm_freeProducts_update,
/* harmony export */   "api_pm_0028_deleteLines": () => /* binding */ api_pm_0028_deleteLines,
/* harmony export */   "api_pm_freeProducts_deleteLines": () => /* binding */ api_pm_freeProducts_deleteLines,
/* harmony export */   "api_pm_0031_index": () => /* binding */ api_pm_0031_index,
/* harmony export */   "api_pm_0031_getBatches": () => /* binding */ api_pm_0031_getBatches,
/* harmony export */   "api_pm_0031_getListBatchHeaders": () => /* binding */ api_pm_0031_getListBatchHeaders,
/* harmony export */   "api_pm_0031_getWipSteps": () => /* binding */ api_pm_0031_getWipSteps,
/* harmony export */   "api_pm_0031_search": () => /* binding */ api_pm_0031_search,
/* harmony export */   "api_pm_0031_save": () => /* binding */ api_pm_0031_save,
/* harmony export */   "api_pm_0032_index": () => /* binding */ api_pm_0032_index,
/* harmony export */   "api_pm_stampUsing_index": () => /* binding */ api_pm_stampUsing_index,
/* harmony export */   "api_pm_0032_show": () => /* binding */ api_pm_0032_show,
/* harmony export */   "api_pm_stampUsing_show": () => /* binding */ api_pm_stampUsing_show,
/* harmony export */   "api_pm_0032_store": () => /* binding */ api_pm_0032_store,
/* harmony export */   "api_pm_stampUsing_store": () => /* binding */ api_pm_stampUsing_store,
/* harmony export */   "api_pm_0032_update": () => /* binding */ api_pm_0032_update,
/* harmony export */   "api_pm_stampUsing_update": () => /* binding */ api_pm_stampUsing_update,
/* harmony export */   "api_pm_0032_search": () => /* binding */ api_pm_0032_search,
/* harmony export */   "api_pm_stampUsing_search": () => /* binding */ api_pm_stampUsing_search,
/* harmony export */   "api_pm_0032_transferStamp": () => /* binding */ api_pm_0032_transferStamp,
/* harmony export */   "api_pm_stampUsing_transferStamp": () => /* binding */ api_pm_stampUsing_transferStamp,
/* harmony export */   "api_pm_0032_deleteLines": () => /* binding */ api_pm_0032_deleteLines,
/* harmony export */   "api_pm_stampUsing_deleteLines": () => /* binding */ api_pm_stampUsing_deleteLines,
/* harmony export */   "api_pm_0033_get": () => /* binding */ api_pm_0033_get,
/* harmony export */   "api_pm_confirmStampUsing_get": () => /* binding */ api_pm_confirmStampUsing_get,
/* harmony export */   "api_pm_0033_updateStampUsage": () => /* binding */ api_pm_0033_updateStampUsage,
/* harmony export */   "api_pm_confirmStampUsing_updateStampUsage": () => /* binding */ api_pm_confirmStampUsing_updateStampUsage,
/* harmony export */   "api_pm_0033_useStamp": () => /* binding */ api_pm_0033_useStamp,
/* harmony export */   "api_pm_confirmStampUsing_useStamp": () => /* binding */ api_pm_confirmStampUsing_useStamp,
/* harmony export */   "api_pm_0036_index": () => /* binding */ api_pm_0036_index,
/* harmony export */   "api_pm_closeProductOrder_index": () => /* binding */ api_pm_closeProductOrder_index,
/* harmony export */   "api_pm_0036_jobOptRelations": () => /* binding */ api_pm_0036_jobOptRelations,
/* harmony export */   "api_pm_closeProductOrder_jobOptRelations": () => /* binding */ api_pm_closeProductOrder_jobOptRelations,
/* harmony export */   "api_pm_0036_closeBatch": () => /* binding */ api_pm_0036_closeBatch,
/* harmony export */   "api_pm_closeProductOrder_closeBatch": () => /* binding */ api_pm_closeProductOrder_closeBatch,
/* harmony export */   "api_pm_0038_": () => /* binding */ api_pm_0038_,
/* harmony export */   "api_pm_0038_cancelCloseJob": () => /* binding */ api_pm_0038_cancelCloseJob,
/* harmony export */   "api_pm_0038_productDetail": () => /* binding */ api_pm_0038_productDetail,
/* harmony export */   "api_pm_0041_index": () => /* binding */ api_pm_0041_index,
/* harmony export */   "api_pm_examineCasingAfterExpiryDate_index": () => /* binding */ api_pm_examineCasingAfterExpiryDate_index,
/* harmony export */   "api_pm_0041_updateExamineCasing": () => /* binding */ api_pm_0041_updateExamineCasing,
/* harmony export */   "api_pm_examineCasingAfterExpiryDate_updateExamineCasing": () => /* binding */ api_pm_examineCasingAfterExpiryDate_updateExamineCasing,
/* harmony export */   "api_pm_0041_updateExpirationDate": () => /* binding */ api_pm_0041_updateExpirationDate,
/* harmony export */   "api_pm_examineCasingAfterExpiryDate_updateExpirationDate": () => /* binding */ api_pm_examineCasingAfterExpiryDate_updateExpirationDate,
/* harmony export */   "api_pm_0042_index": () => /* binding */ api_pm_0042_index,
/* harmony export */   "api_pm_0042_approveRequest": () => /* binding */ api_pm_0042_approveRequest,
/* harmony export */   "api_pm_0042_rejectRequest": () => /* binding */ api_pm_0042_rejectRequest,
/* harmony export */   "api_pm_0043_": () => /* binding */ api_pm_0043_,
/* harmony export */   "api_pm_0045_approveRequest": () => /* binding */ api_pm_0045_approveRequest,
/* harmony export */   "api_pm_examineAfterManufactured_approveRequest": () => /* binding */ api_pm_examineAfterManufactured_approveRequest,
/* harmony export */   "api_pm_0045_cancelRequest": () => /* binding */ api_pm_0045_cancelRequest,
/* harmony export */   "api_pm_examineAfterManufactured_cancelRequest": () => /* binding */ api_pm_examineAfterManufactured_cancelRequest,
/* harmony export */   "api_pm_0045_": () => /* binding */ api_pm_0045_,
/* harmony export */   "api_pm_examineAfterManufactured_": () => /* binding */ api_pm_examineAfterManufactured_,
/* harmony export */   "api_pm_test_pat_get": () => /* binding */ api_pm_test_pat_get,
/* harmony export */   "ajax_roles_getMenuByModule": () => /* binding */ ajax_roles_getMenuByModule,
/* harmony export */   "ajax_roles_getPermission": () => /* binding */ ajax_roles_getPermission,
/* harmony export */   "ajax_roles_assignPermission": () => /* binding */ ajax_roles_assignPermission,
/* harmony export */   "ajax_roles_store": () => /* binding */ ajax_roles_store,
/* harmony export */   "ajax_roles_update": () => /* binding */ ajax_roles_update,
/* harmony export */   "ajax_users_store": () => /* binding */ ajax_users_store,
/* harmony export */   "ajax_users_update": () => /* binding */ ajax_users_update,
/* harmony export */   "ajax_users_getUser": () => /* binding */ ajax_users_getUser,
/* harmony export */   "ajax_users_getDepartment": () => /* binding */ ajax_users_getDepartment,
/* harmony export */   "ajax_users_getOaUser": () => /* binding */ ajax_users_getOaUser,
/* harmony export */   "ajax_users_getRole": () => /* binding */ ajax_users_getRole,
/* harmony export */   "menus_index": () => /* binding */ menus_index,
/* harmony export */   "menus_create": () => /* binding */ menus_create,
/* harmony export */   "menus_store": () => /* binding */ menus_store,
/* harmony export */   "menus_edit": () => /* binding */ menus_edit,
/* harmony export */   "menus_update": () => /* binding */ menus_update,
/* harmony export */   "users_permissions": () => /* binding */ users_permissions,
/* harmony export */   "users_assignPermission": () => /* binding */ users_assignPermission,
/* harmony export */   "users_changeDeparment": () => /* binding */ users_changeDeparment,
/* harmony export */   "users_changeOrg": () => /* binding */ users_changeOrg,
/* harmony export */   "users_index": () => /* binding */ users_index,
/* harmony export */   "users_create": () => /* binding */ users_create,
/* harmony export */   "users_edit": () => /* binding */ users_edit,
/* harmony export */   "roles_index": () => /* binding */ roles_index,
/* harmony export */   "roles_create": () => /* binding */ roles_create,
/* harmony export */   "roles_edit": () => /* binding */ roles_edit,
/* harmony export */   "home": () => /* binding */ home,
/* harmony export */   "funds_index": () => /* binding */ funds_index,
/* harmony export */   "funds_show": () => /* binding */ funds_show,
/* harmony export */   "program_type_index": () => /* binding */ program_type_index,
/* harmony export */   "program_type_create": () => /* binding */ program_type_create,
/* harmony export */   "program_type_store": () => /* binding */ program_type_store,
/* harmony export */   "program_type_edit": () => /* binding */ program_type_edit,
/* harmony export */   "program_type_update": () => /* binding */ program_type_update,
/* harmony export */   "program_info_index": () => /* binding */ program_info_index,
/* harmony export */   "program_info_create": () => /* binding */ program_info_create,
/* harmony export */   "program_info_store": () => /* binding */ program_info_store,
/* harmony export */   "program_info_edit": () => /* binding */ program_info_edit,
/* harmony export */   "program_info_update": () => /* binding */ program_info_update,
/* harmony export */   "lookup_index": () => /* binding */ lookup_index,
/* harmony export */   "lookup_create": () => /* binding */ lookup_create,
/* harmony export */   "lookup_store": () => /* binding */ lookup_store,
/* harmony export */   "lookup_edit": () => /* binding */ lookup_edit,
/* harmony export */   "lookup_update": () => /* binding */ lookup_update,
/* harmony export */   "lookup_delete": () => /* binding */ lookup_delete,
/* harmony export */   "setUp_index": () => /* binding */ setUp_index,
/* harmony export */   "setUp_show": () => /* binding */ setUp_show,
/* harmony export */   "setUp_update": () => /* binding */ setUp_update,
/* harmony export */   "runningNumber_index": () => /* binding */ runningNumber_index,
/* harmony export */   "runningNumber_create": () => /* binding */ runningNumber_create,
/* harmony export */   "runningNumber_store": () => /* binding */ runningNumber_store,
/* harmony export */   "runningNumber_edit": () => /* binding */ runningNumber_edit,
/* harmony export */   "runningNumber_update": () => /* binding */ runningNumber_update,
/* harmony export */   "logout": () => /* binding */ logout,
/* harmony export */   "login": () => /* binding */ login,
/* harmony export */   "register": () => /* binding */ register,
/* harmony export */   "password_request": () => /* binding */ password_request,
/* harmony export */   "password_email": () => /* binding */ password_email,
/* harmony export */   "password_reset": () => /* binding */ password_reset,
/* harmony export */   "password_update": () => /* binding */ password_update,
/* harmony export */   "password_confirm": () => /* binding */ password_confirm,
/* harmony export */   "example_ajax_users_index": () => /* binding */ example_ajax_users_index,
/* harmony export */   "example_users_exportExcel": () => /* binding */ example_users_exportExcel,
/* harmony export */   "example_users_exportPdf": () => /* binding */ example_users_exportPdf,
/* harmony export */   "example_users_interface": () => /* binding */ example_users_interface,
/* harmony export */   "example_users_interfaceError": () => /* binding */ example_users_interfaceError,
/* harmony export */   "example_users_index": () => /* binding */ example_users_index,
/* harmony export */   "example_users_create": () => /* binding */ example_users_create,
/* harmony export */   "example_users_store": () => /* binding */ example_users_store,
/* harmony export */   "example_users_show": () => /* binding */ example_users_show,
/* harmony export */   "example_users_edit": () => /* binding */ example_users_edit,
/* harmony export */   "example_users_update": () => /* binding */ example_users_update,
/* harmony export */   "example_users_destroy": () => /* binding */ example_users_destroy,
/* harmony export */   "pd_ajax_": () => /* binding */ pd_ajax_,
/* harmony export */   "pd_settings_simuRawMaterial_index": () => /* binding */ pd_settings_simuRawMaterial_index,
/* harmony export */   "pd_settings_simuRawMaterial_create": () => /* binding */ pd_settings_simuRawMaterial_create,
/* harmony export */   "pd_settings_simuRawMaterial_store": () => /* binding */ pd_settings_simuRawMaterial_store,
/* harmony export */   "pd_settings_simuRawMaterial_edit": () => /* binding */ pd_settings_simuRawMaterial_edit,
/* harmony export */   "pd_settings_simuRawMaterial_update": () => /* binding */ pd_settings_simuRawMaterial_update,
/* harmony export */   "pd_settings_simuRawMaterial_delete": () => /* binding */ pd_settings_simuRawMaterial_delete,
/* harmony export */   "pd_settings_simuRawMaterial_createInv": () => /* binding */ pd_settings_simuRawMaterial_createInv,
/* harmony export */   "pd_settings_ohhandTobaccoForewarn_index": () => /* binding */ pd_settings_ohhandTobaccoForewarn_index,
/* harmony export */   "pd_settings_ohhandTobaccoForewarn_store": () => /* binding */ pd_settings_ohhandTobaccoForewarn_store,
/* harmony export */   "pd_settings_ohhandTobaccoForewarn_update": () => /* binding */ pd_settings_ohhandTobaccoForewarn_update,
/* harmony export */   "pd_0001_index": () => /* binding */ pd_0001_index,
/* harmony export */   "pd_casingSimuAdditive_index": () => /* binding */ pd_casingSimuAdditive_index,
/* harmony export */   "pd_0002_index": () => /* binding */ pd_0002_index,
/* harmony export */   "pd_flavorSimuAdditive_index": () => /* binding */ pd_flavorSimuAdditive_index,
/* harmony export */   "pd_0003_index": () => /* binding */ pd_0003_index,
/* harmony export */   "pd_pd0003_index": () => /* binding */ pd_pd0003_index,
/* harmony export */   "pd_0004_index": () => /* binding */ pd_0004_index,
/* harmony export */   "pd_invMaterialItems_index": () => /* binding */ pd_invMaterialItems_index,
/* harmony export */   "pd_0004_show": () => /* binding */ pd_0004_show,
/* harmony export */   "pd_invMaterialItems_show": () => /* binding */ pd_invMaterialItems_show,
/* harmony export */   "pd_0005_index": () => /* binding */ pd_0005_index,
/* harmony export */   "pd_exampleCigarettes_index": () => /* binding */ pd_exampleCigarettes_index,
/* harmony export */   "pd_0005_show": () => /* binding */ pd_0005_show,
/* harmony export */   "pd_exampleCigarettes_show": () => /* binding */ pd_exampleCigarettes_show,
/* harmony export */   "pd_0006_index": () => /* binding */ pd_0006_index,
/* harmony export */   "pd_0006_show": () => /* binding */ pd_0006_show,
/* harmony export */   "pd_0007_index": () => /* binding */ pd_0007_index,
/* harmony export */   "pd_0008_index": () => /* binding */ pd_0008_index,
/* harmony export */   "pd_0010_index": () => /* binding */ pd_0010_index,
/* harmony export */   "pd_0011_index": () => /* binding */ pd_0011_index,
/* harmony export */   "pd_0012_index": () => /* binding */ pd_0012_index,
/* harmony export */   "pd_0013_index": () => /* binding */ pd_0013_index,
/* harmony export */   "pd_0009_index": () => /* binding */ pd_0009_index,
/* harmony export */   "pd_expandedTobacco_index": () => /* binding */ pd_expandedTobacco_index,
/* harmony export */   "pd_0009_test": () => /* binding */ pd_0009_test,
/* harmony export */   "pd_expandedTobacco_test": () => /* binding */ pd_expandedTobacco_test,
/* harmony export */   "pd_0014_index": () => /* binding */ pd_0014_index,
/* harmony export */   "pd_pd0014_index": () => /* binding */ pd_pd0014_index,
/* harmony export */   "pm_ajax_": () => /* binding */ pm_ajax_,
/* harmony export */   "pm_ajax_getOrganization": () => /* binding */ pm_ajax_getOrganization,
/* harmony export */   "pm_ajax_getLocations": () => /* binding */ pm_ajax_getLocations,
/* harmony export */   "pm_ajax_getItemNumber": () => /* binding */ pm_ajax_getItemNumber,
/* harmony export */   "pm_ajax_getUom": () => /* binding */ pm_ajax_getUom,
/* harmony export */   "pm_ajax_destroy": () => /* binding */ pm_ajax_destroy,
/* harmony export */   "pm_ajax_search": () => /* binding */ pm_ajax_search,
/* harmony export */   "pm_ajax_printConversion_destroy": () => /* binding */ pm_ajax_printConversion_destroy,
/* harmony export */   "pm_ajax_maxStorage_getUom": () => /* binding */ pm_ajax_maxStorage_getUom,
/* harmony export */   "pm_settings_materialGroup_index": () => /* binding */ pm_settings_materialGroup_index,
/* harmony export */   "pm_settings_materialGroup_create": () => /* binding */ pm_settings_materialGroup_create,
/* harmony export */   "pm_settings_materialGroup_store": () => /* binding */ pm_settings_materialGroup_store,
/* harmony export */   "pm_settings_relationFeeder_index": () => /* binding */ pm_settings_relationFeeder_index,
/* harmony export */   "pm_settings_relationFeeder_create": () => /* binding */ pm_settings_relationFeeder_create,
/* harmony export */   "pm_settings_relationFeeder_store": () => /* binding */ pm_settings_relationFeeder_store,
/* harmony export */   "pm_settings_relationFeeder_edit": () => /* binding */ pm_settings_relationFeeder_edit,
/* harmony export */   "pm_settings_relationFeeder_update": () => /* binding */ pm_settings_relationFeeder_update,
/* harmony export */   "pm_settings_orgTranfer_index": () => /* binding */ pm_settings_orgTranfer_index,
/* harmony export */   "pm_settings_orgTranfer_create": () => /* binding */ pm_settings_orgTranfer_create,
/* harmony export */   "pm_settings_orgTranfer_store": () => /* binding */ pm_settings_orgTranfer_store,
/* harmony export */   "pm_settings_orgTranfer_edit": () => /* binding */ pm_settings_orgTranfer_edit,
/* harmony export */   "pm_settings_orgTranfer_update": () => /* binding */ pm_settings_orgTranfer_update,
/* harmony export */   "pm_settings_wipStep_index": () => /* binding */ pm_settings_wipStep_index,
/* harmony export */   "pm_settings_wipStep_create": () => /* binding */ pm_settings_wipStep_create,
/* harmony export */   "pm_settings_wipStep_store": () => /* binding */ pm_settings_wipStep_store,
/* harmony export */   "pm_settings_wipStep_edit": () => /* binding */ pm_settings_wipStep_edit,
/* harmony export */   "pm_settings_wipStep_update": () => /* binding */ pm_settings_wipStep_update,
/* harmony export */   "pm_settings_wipStep_show": () => /* binding */ pm_settings_wipStep_show,
/* harmony export */   "pm_settings_productionFormula_index": () => /* binding */ pm_settings_productionFormula_index,
/* harmony export */   "pm_settings_productionFormula_create": () => /* binding */ pm_settings_productionFormula_create,
/* harmony export */   "pm_settings_productionFormula_store": () => /* binding */ pm_settings_productionFormula_store,
/* harmony export */   "pm_settings_productionFormula_edit": () => /* binding */ pm_settings_productionFormula_edit,
/* harmony export */   "pm_settings_productionFormula_update": () => /* binding */ pm_settings_productionFormula_update,
/* harmony export */   "pm_settings_productionFormula_show": () => /* binding */ pm_settings_productionFormula_show,
/* harmony export */   "pm_settings_productionFormula_copy": () => /* binding */ pm_settings_productionFormula_copy,
/* harmony export */   "pm_settings_productionFormula_approve": () => /* binding */ pm_settings_productionFormula_approve,
/* harmony export */   "pm_settings_savePublicationLayout_index": () => /* binding */ pm_settings_savePublicationLayout_index,
/* harmony export */   "pm_settings_savePublicationLayout_edit": () => /* binding */ pm_settings_savePublicationLayout_edit,
/* harmony export */   "pm_settings_savePublicationLayout_update": () => /* binding */ pm_settings_savePublicationLayout_update,
/* harmony export */   "pm_settings_machineRelation_index": () => /* binding */ pm_settings_machineRelation_index,
/* harmony export */   "pm_settings_machineRelation_create": () => /* binding */ pm_settings_machineRelation_create,
/* harmony export */   "pm_settings_machineRelation_store": () => /* binding */ pm_settings_machineRelation_store,
/* harmony export */   "pm_settings_machineRelation_edit": () => /* binding */ pm_settings_machineRelation_edit,
/* harmony export */   "pm_settings_machineRelation_update": () => /* binding */ pm_settings_machineRelation_update,
/* harmony export */   "pm_settings_setupMinMaxByItem_index": () => /* binding */ pm_settings_setupMinMaxByItem_index,
/* harmony export */   "pm_settings_setupMinMaxByItem_updateOrCreate": () => /* binding */ pm_settings_setupMinMaxByItem_updateOrCreate,
/* harmony export */   "pm_settings_setupTransfer_index": () => /* binding */ pm_settings_setupTransfer_index,
/* harmony export */   "pm_settings_setupTransfer_edit": () => /* binding */ pm_settings_setupTransfer_edit,
/* harmony export */   "pm_settings_setupTransfer_update": () => /* binding */ pm_settings_setupTransfer_update,
/* harmony export */   "pm_settings_setupTransfer_create": () => /* binding */ pm_settings_setupTransfer_create,
/* harmony export */   "pm_settings_setupTransfer_store": () => /* binding */ pm_settings_setupTransfer_store,
/* harmony export */   "pm_settings_printConversion_index": () => /* binding */ pm_settings_printConversion_index,
/* harmony export */   "pm_settings_printConversion_createOrUpdate": () => /* binding */ pm_settings_printConversion_createOrUpdate,
/* harmony export */   "pm_settings_printProductType_index": () => /* binding */ pm_settings_printProductType_index,
/* harmony export */   "pm_settings_printProductType_update": () => /* binding */ pm_settings_printProductType_update,
/* harmony export */   "pm_settings_maxStorage_index": () => /* binding */ pm_settings_maxStorage_index,
/* harmony export */   "pm_settings_maxStorage_create": () => /* binding */ pm_settings_maxStorage_create,
/* harmony export */   "pm_settings_maxStorage_store": () => /* binding */ pm_settings_maxStorage_store,
/* harmony export */   "pm_settings_maxStorage_edit": () => /* binding */ pm_settings_maxStorage_edit,
/* harmony export */   "pm_settings_maxStorage_update": () => /* binding */ pm_settings_maxStorage_update,
/* harmony export */   "pm_settings_savePublicationLayout_store": () => /* binding */ pm_settings_savePublicationLayout_store,
/* harmony export */   "pm_settings_setupBeforeNotice_index": () => /* binding */ pm_settings_setupBeforeNotice_index,
/* harmony export */   "pm_settings_setupBeforeNotice_store": () => /* binding */ pm_settings_setupBeforeNotice_store,
/* harmony export */   "pm_settings_": () => /* binding */ pm_settings_,
/* harmony export */   "pm_0001_index": () => /* binding */ pm_0001_index,
/* harmony export */   "pm_0001_show": () => /* binding */ pm_0001_show,
/* harmony export */   "pm_productionOrder_index": () => /* binding */ pm_productionOrder_index,
/* harmony export */   "pm_productionOrder_show": () => /* binding */ pm_productionOrder_show,
/* harmony export */   "pm_0002_index": () => /* binding */ pm_0002_index,
/* harmony export */   "pm_requestCreation_index": () => /* binding */ pm_requestCreation_index,
/* harmony export */   "pm_0003_index": () => /* binding */ pm_0003_index,
/* harmony export */   "pm_annualProductionPlan_index": () => /* binding */ pm_annualProductionPlan_index,
/* harmony export */   "pm_0004_index": () => /* binding */ pm_0004_index,
/* harmony export */   "pm_0005_index": () => /* binding */ pm_0005_index,
/* harmony export */   "pm_requestMaterials_index": () => /* binding */ pm_requestMaterials_index,
/* harmony export */   "pm_00052_index": () => /* binding */ pm_00052_index,
/* harmony export */   "pm_0006_index": () => /* binding */ pm_0006_index,
/* harmony export */   "pm_reportProductInProcess_index": () => /* binding */ pm_reportProductInProcess_index,
/* harmony export */   "pm_0006_jobs": () => /* binding */ pm_0006_jobs,
/* harmony export */   "pm_reportProductInProcess_jobs": () => /* binding */ pm_reportProductInProcess_jobs,
/* harmony export */   "pm_0007_index": () => /* binding */ pm_0007_index,
/* harmony export */   "pm_cutRawMaterial_index": () => /* binding */ pm_cutRawMaterial_index,
/* harmony export */   "pm_0008_index": () => /* binding */ pm_0008_index,
/* harmony export */   "pm_inventoryList_index": () => /* binding */ pm_inventoryList_index,
/* harmony export */   "pm_0009_index": () => /* binding */ pm_0009_index,
/* harmony export */   "pm_testRawMaterial_index": () => /* binding */ pm_testRawMaterial_index,
/* harmony export */   "pm_0010_index": () => /* binding */ pm_0010_index,
/* harmony export */   "pm_reviewComplete_index": () => /* binding */ pm_reviewComplete_index,
/* harmony export */   "pm_0011_index": () => /* binding */ pm_0011_index,
/* harmony export */   "pm_planningJobLines_index": () => /* binding */ pm_planningJobLines_index,
/* harmony export */   "pm_0012_index": () => /* binding */ pm_0012_index,
/* harmony export */   "pm_0013_index": () => /* binding */ pm_0013_index,
/* harmony export */   "pm_recordTobaccoUsageZoneC48_index": () => /* binding */ pm_recordTobaccoUsageZoneC48_index,
/* harmony export */   "pm_0014_index": () => /* binding */ pm_0014_index,
/* harmony export */   "pm_0015_index": () => /* binding */ pm_0015_index,
/* harmony export */   "pm_regionalTobaccoProductionPlanning_index": () => /* binding */ pm_regionalTobaccoProductionPlanning_index,
/* harmony export */   "pm_0016_index": () => /* binding */ pm_0016_index,
/* harmony export */   "pm_0017_index": () => /* binding */ pm_0017_index,
/* harmony export */   "pm_domesticPrintingProductionPlanning_index": () => /* binding */ pm_domesticPrintingProductionPlanning_index,
/* harmony export */   "pm_0018_index": () => /* binding */ pm_0018_index,
/* harmony export */   "pm_fortnightlyTobaccoProductionOrder_index": () => /* binding */ pm_fortnightlyTobaccoProductionOrder_index,
/* harmony export */   "pm_0019_index": () => /* binding */ pm_0019_index,
/* harmony export */   "pm_fortnightlyRawMaterialRequest_index": () => /* binding */ pm_fortnightlyRawMaterialRequest_index,
/* harmony export */   "pm_0020_index": () => /* binding */ pm_0020_index,
/* harmony export */   "pm_machineIngredientRequests_index": () => /* binding */ pm_machineIngredientRequests_index,
/* harmony export */   "pm_0020_show": () => /* binding */ pm_0020_show,
/* harmony export */   "pm_machineIngredientRequests_show": () => /* binding */ pm_machineIngredientRequests_show,
/* harmony export */   "pm_0021_index": () => /* binding */ pm_0021_index,
/* harmony export */   "pm_ingredientRequests_index": () => /* binding */ pm_ingredientRequests_index,
/* harmony export */   "pm_0022_index": () => /* binding */ pm_0022_index,
/* harmony export */   "pm_ingredientPreparationList_index": () => /* binding */ pm_ingredientPreparationList_index,
/* harmony export */   "pm_0023_index": () => /* binding */ pm_0023_index,
/* harmony export */   "pm_transactionPnkCheckMaterial_index": () => /* binding */ pm_transactionPnkCheckMaterial_index,
/* harmony export */   "pm_0023_rawMaterials": () => /* binding */ pm_0023_rawMaterials,
/* harmony export */   "pm_transactionPnkCheckMaterial_rawMaterials": () => /* binding */ pm_transactionPnkCheckMaterial_rawMaterials,
/* harmony export */   "pm_0023_compareRawMaterials": () => /* binding */ pm_0023_compareRawMaterials,
/* harmony export */   "pm_transactionPnkCheckMaterial_compareRawMaterials": () => /* binding */ pm_transactionPnkCheckMaterial_compareRawMaterials,
/* harmony export */   "pm_0024_index": () => /* binding */ pm_0024_index,
/* harmony export */   "pm_transactionPnkMaterialTransfer_index": () => /* binding */ pm_transactionPnkMaterialTransfer_index,
/* harmony export */   "pm_0025_index": () => /* binding */ pm_0025_index,
/* harmony export */   "pm_confirmOrders_index": () => /* binding */ pm_confirmOrders_index,
/* harmony export */   "pm_0026_index": () => /* binding */ pm_0026_index,
/* harmony export */   "pm_finishedProductsStoringRecord_index": () => /* binding */ pm_finishedProductsStoringRecord_index,
/* harmony export */   "pm_0027_index": () => /* binding */ pm_0027_index,
/* harmony export */   "pm_sampleCigarettes_index": () => /* binding */ pm_sampleCigarettes_index,
/* harmony export */   "pm_0027_show": () => /* binding */ pm_0027_show,
/* harmony export */   "pm_sampleCigarettes_show": () => /* binding */ pm_sampleCigarettes_show,
/* harmony export */   "pm_0028_index": () => /* binding */ pm_0028_index,
/* harmony export */   "pm_freeProducts_index": () => /* binding */ pm_freeProducts_index,
/* harmony export */   "pm_0028_date": () => /* binding */ pm_0028_date,
/* harmony export */   "pm_freeProducts_date": () => /* binding */ pm_freeProducts_date,
/* harmony export */   "pm_0029_index": () => /* binding */ pm_0029_index,
/* harmony export */   "pm_ingredientInventory_index": () => /* binding */ pm_ingredientInventory_index,
/* harmony export */   "pm_0030_index": () => /* binding */ pm_0030_index,
/* harmony export */   "pm_confirmProductionYieldLossForTips_index": () => /* binding */ pm_confirmProductionYieldLossForTips_index,
/* harmony export */   "pm_0031_index": () => /* binding */ pm_0031_index,
/* harmony export */   "pm_0032_index": () => /* binding */ pm_0032_index,
/* harmony export */   "pm_stampUsing_index": () => /* binding */ pm_stampUsing_index,
/* harmony export */   "pm_0032_show": () => /* binding */ pm_0032_show,
/* harmony export */   "pm_stampUsing_show": () => /* binding */ pm_stampUsing_show,
/* harmony export */   "pm_0032_create": () => /* binding */ pm_0032_create,
/* harmony export */   "pm_stampUsing_create": () => /* binding */ pm_stampUsing_create,
/* harmony export */   "pm_0033_index": () => /* binding */ pm_0033_index,
/* harmony export */   "pm_confirmStampUsing_index": () => /* binding */ pm_confirmStampUsing_index,
/* harmony export */   "pm_0034_index": () => /* binding */ pm_0034_index,
/* harmony export */   "pm_planningProduceMonthly_index": () => /* binding */ pm_planningProduceMonthly_index,
/* harmony export */   "pm_0035_index": () => /* binding */ pm_0035_index,
/* harmony export */   "pm_receiveRawMaterialTransferAtTemporaryStorage_index": () => /* binding */ pm_receiveRawMaterialTransferAtTemporaryStorage_index,
/* harmony export */   "pm_0036_index": () => /* binding */ pm_0036_index,
/* harmony export */   "pm_closeProductOrder_index": () => /* binding */ pm_closeProductOrder_index,
/* harmony export */   "pm_0037_index": () => /* binding */ pm_0037_index,
/* harmony export */   "pm_rawMaterialPreparation_index": () => /* binding */ pm_rawMaterialPreparation_index,
/* harmony export */   "pm_0038_index": () => /* binding */ pm_0038_index,
/* harmony export */   "pm_productionOrderList_index": () => /* binding */ pm_productionOrderList_index,
/* harmony export */   "pm_0039_index": () => /* binding */ pm_0039_index,
/* harmony export */   "pm_additiveInventoryAlert_index": () => /* binding */ pm_additiveInventoryAlert_index,
/* harmony export */   "pm_0040_index": () => /* binding */ pm_0040_index,
/* harmony export */   "pm_rawMaterialInventoryAlert_index": () => /* binding */ pm_rawMaterialInventoryAlert_index,
/* harmony export */   "pm_0041_index": () => /* binding */ pm_0041_index,
/* harmony export */   "pm_examineCasingAfterExpiryDate_index": () => /* binding */ pm_examineCasingAfterExpiryDate_index,
/* harmony export */   "pm_0042_index": () => /* binding */ pm_0042_index,
/* harmony export */   "pm_approvalCasingNewExpiryDate_index": () => /* binding */ pm_approvalCasingNewExpiryDate_index,
/* harmony export */   "pm_0043_index": () => /* binding */ pm_0043_index,
/* harmony export */   "pm_transferFinishGoods_index": () => /* binding */ pm_transferFinishGoods_index,
/* harmony export */   "pm_0044_index": () => /* binding */ pm_0044_index,
/* harmony export */   "pm_0045_index": () => /* binding */ pm_0045_index,
/* harmony export */   "pm_dbLookupExample_index": () => /* binding */ pm_dbLookupExample_index,
/* harmony export */   "pm_plans_yearly": () => /* binding */ pm_plans_yearly,
/* harmony export */   "pm_plans_monthly": () => /* binding */ pm_plans_monthly,
/* harmony export */   "pm_plans_biweekly": () => /* binding */ pm_plans_biweekly,
/* harmony export */   "pm_plans_daily": () => /* binding */ pm_plans_daily,
/* harmony export */   "pm_plans_approvals_yearly": () => /* binding */ pm_plans_approvals_yearly,
/* harmony export */   "pm_plans_approvals_biweekly": () => /* binding */ pm_plans_approvals_biweekly,
/* harmony export */   "pm_products_machineRequests_index": () => /* binding */ pm_products_machineRequests_index,
/* harmony export */   "pm_products_transfers_index": () => /* binding */ pm_products_transfers_index,
/* harmony export */   "pm_files_image": () => /* binding */ pm_files_image,
/* harmony export */   "pm_files_imageThumbnail": () => /* binding */ pm_files_imageThumbnail,
/* harmony export */   "pm_files_download": () => /* binding */ pm_files_download,
/* harmony export */   "pp_0000_index": () => /* binding */ pp_0000_index,
/* harmony export */   "pp_example_index": () => /* binding */ pp_example_index,
/* harmony export */   "pp_0001_index": () => /* binding */ pp_0001_index,
/* harmony export */   "pp_0002_index": () => /* binding */ pp_0002_index,
/* harmony export */   "pp_0003_index": () => /* binding */ pp_0003_index,
/* harmony export */   "pp_0004_index": () => /* binding */ pp_0004_index,
/* harmony export */   "pp_0005_index": () => /* binding */ pp_0005_index,
/* harmony export */   "pp_0006_index": () => /* binding */ pp_0006_index,
/* harmony export */   "pp_0007_index": () => /* binding */ pp_0007_index,
/* harmony export */   "pp_0008_index": () => /* binding */ pp_0008_index,
/* harmony export */   "eam_ajax_lov_assetNumber": () => /* binding */ eam_ajax_lov_assetNumber,
/* harmony export */   "eam_ajax_lov_assetVAssetNumber": () => /* binding */ eam_ajax_lov_assetVAssetNumber,
/* harmony export */   "eam_ajax_lov_childAssetNumber": () => /* binding */ eam_ajax_lov_childAssetNumber,
/* harmony export */   "eam_ajax_lov_departments": () => /* binding */ eam_ajax_lov_departments,
/* harmony export */   "eam_ajax_lov_workRequestStatus": () => /* binding */ eam_ajax_lov_workRequestStatus,
/* harmony export */   "eam_ajax_lov_workReceiptStatus": () => /* binding */ eam_ajax_lov_workReceiptStatus,
/* harmony export */   "eam_ajax_lov_employee": () => /* binding */ eam_ajax_lov_employee,
/* harmony export */   "eam_ajax_lov_workRequestType": () => /* binding */ eam_ajax_lov_workRequestType,
/* harmony export */   "eam_ajax_lov_activityPriority": () => /* binding */ eam_ajax_lov_activityPriority,
/* harmony export */   "eam_ajax_lov_workRequestNumber": () => /* binding */ eam_ajax_lov_workRequestNumber,
/* harmony export */   "eam_ajax_lov_workOrderHId": () => /* binding */ eam_ajax_lov_workOrderHId,
/* harmony export */   "eam_ajax_lov_workOrderOpNumseq": () => /* binding */ eam_ajax_lov_workOrderOpNumseq,
/* harmony export */   "eam_ajax_lov_wipClass": () => /* binding */ eam_ajax_lov_wipClass,
/* harmony export */   "eam_ajax_lov_depResource": () => /* binding */ eam_ajax_lov_depResource,
/* harmony export */   "eam_ajax_lov_statusYn": () => /* binding */ eam_ajax_lov_statusYn,
/* harmony export */   "eam_ajax_lov_itemInventory": () => /* binding */ eam_ajax_lov_itemInventory,
/* harmony export */   "eam_ajax_lov_itemNonstock": () => /* binding */ eam_ajax_lov_itemNonstock,
/* harmony export */   "eam_ajax_lov_materialType": () => /* binding */ eam_ajax_lov_materialType,
/* harmony export */   "eam_ajax_lov_suvinventory": () => /* binding */ eam_ajax_lov_suvinventory,
/* harmony export */   "eam_ajax_lov_locatorv": () => /* binding */ eam_ajax_lov_locatorv,
/* harmony export */   "eam_ajax_lov_assetActivity": () => /* binding */ eam_ajax_lov_assetActivity,
/* harmony export */   "eam_ajax_lov_issue": () => /* binding */ eam_ajax_lov_issue,
/* harmony export */   "eam_ajax_lov_workOrderStatus": () => /* binding */ eam_ajax_lov_workOrderStatus,
/* harmony export */   "eam_ajax_lov_workOrderType": () => /* binding */ eam_ajax_lov_workOrderType,
/* harmony export */   "eam_ajax_lov_shutdownType": () => /* binding */ eam_ajax_lov_shutdownType,
/* harmony export */   "eam_ajax_lov_workOrderReNumseq": () => /* binding */ eam_ajax_lov_workOrderReNumseq,
/* harmony export */   "eam_ajax_lov_workOrderReResource": () => /* binding */ eam_ajax_lov_workOrderReResource,
/* harmony export */   "eam_ajax_lov_area": () => /* binding */ eam_ajax_lov_area,
/* harmony export */   "eam_ajax_lov_resourceAssetNumber": () => /* binding */ eam_ajax_lov_resourceAssetNumber,
/* harmony export */   "eam_ajax_lov_assetGroup": () => /* binding */ eam_ajax_lov_assetGroup,
/* harmony export */   "eam_ajax_lov_productionOrganization": () => /* binding */ eam_ajax_lov_productionOrganization,
/* harmony export */   "eam_ajax_lov_usageUom": () => /* binding */ eam_ajax_lov_usageUom,
/* harmony export */   "eam_ajax_lov_resourceAssetLocator": () => /* binding */ eam_ajax_lov_resourceAssetLocator,
/* harmony export */   "eam_ajax_lov_operation": () => /* binding */ eam_ajax_lov_operation,
/* harmony export */   "eam_ajax_lov_machineType": () => /* binding */ eam_ajax_lov_machineType,
/* harmony export */   "eam_ajax_lov_periodYear": () => /* binding */ eam_ajax_lov_periodYear,
/* harmony export */   "eam_ajax_lov_activity": () => /* binding */ eam_ajax_lov_activity,
/* harmony export */   "eam_ajax_lov_woMtLot": () => /* binding */ eam_ajax_lov_woMtLot,
/* harmony export */   "eam_ajax_lov_organization": () => /* binding */ eam_ajax_lov_organization,
/* harmony export */   "eam_ajax_lov_departmentResources": () => /* binding */ eam_ajax_lov_departmentResources,
/* harmony export */   "eam_ajax_lov_assetResources": () => /* binding */ eam_ajax_lov_assetResources,
/* harmony export */   "eam_ajax_lov_requestEquipNo": () => /* binding */ eam_ajax_lov_requestEquipNo,
/* harmony export */   "eam_ajax_lov_requestStatus": () => /* binding */ eam_ajax_lov_requestStatus,
/* harmony export */   "eam_ajax_lov_periodName": () => /* binding */ eam_ajax_lov_periodName,
/* harmony export */   "eam_ajax_lov_resource": () => /* binding */ eam_ajax_lov_resource,
/* harmony export */   "eam_ajax_lov_jobStatus": () => /* binding */ eam_ajax_lov_jobStatus,
/* harmony export */   "eam_ajax_lov_resourceEmployee": () => /* binding */ eam_ajax_lov_resourceEmployee,
/* harmony export */   "eam_ajax_workRequests_permissionApprove": () => /* binding */ eam_ajax_workRequests_permissionApprove,
/* harmony export */   "eam_ajax_workRequests_cancel": () => /* binding */ eam_ajax_workRequests_cancel,
/* harmony export */   "eam_ajax_workRequests_cancelApproval": () => /* binding */ eam_ajax_workRequests_cancelApproval,
/* harmony export */   "eam_ajax_workRequests_store": () => /* binding */ eam_ajax_workRequests_store,
/* harmony export */   "eam_ajax_workRequests_updateStatus": () => /* binding */ eam_ajax_workRequests_updateStatus,
/* harmony export */   "eam_ajax_workRequests_report": () => /* binding */ eam_ajax_workRequests_report,
/* harmony export */   "eam_ajax_workRequests_sendApprove": () => /* binding */ eam_ajax_workRequests_sendApprove,
/* harmony export */   "eam_ajax_workRequests_search": () => /* binding */ eam_ajax_workRequests_search,
/* harmony export */   "eam_ajax_workRequests_images_index": () => /* binding */ eam_ajax_workRequests_images_index,
/* harmony export */   "eam_ajax_workRequests_images_upload": () => /* binding */ eam_ajax_workRequests_images_upload,
/* harmony export */   "eam_ajax_workRequests_images_delete": () => /* binding */ eam_ajax_workRequests_images_delete,
/* harmony export */   "eam_ajax_workRequests_images_show": () => /* binding */ eam_ajax_workRequests_images_show,
/* harmony export */   "eam_ajax_workRequests_show": () => /* binding */ eam_ajax_workRequests_show,
/* harmony export */   "eam_ajax_checkOnHand_search": () => /* binding */ eam_ajax_checkOnHand_search,
/* harmony export */   "eam_ajax_checkOnHand_images": () => /* binding */ eam_ajax_checkOnHand_images,
/* harmony export */   "eam_ajax_checkOnHand_image_upload": () => /* binding */ eam_ajax_checkOnHand_image_upload,
/* harmony export */   "eam_ajax_checkOnHand_image_delete": () => /* binding */ eam_ajax_checkOnHand_image_delete,
/* harmony export */   "eam_ajax_checkOnHand_image_show": () => /* binding */ eam_ajax_checkOnHand_image_show,
/* harmony export */   "eam_ajax_checkTransaction_search": () => /* binding */ eam_ajax_checkTransaction_search,
/* harmony export */   "eam_ajax_resourceAsset_show": () => /* binding */ eam_ajax_resourceAsset_show,
/* harmony export */   "eam_ajax_resourceAsset_store": () => /* binding */ eam_ajax_resourceAsset_store,
/* harmony export */   "eam_ajax_resourceAsset_assetCategory": () => /* binding */ eam_ajax_resourceAsset_assetCategory,
/* harmony export */   "eam_ajax_resourceAsset_assetCategorySubgroup": () => /* binding */ eam_ajax_resourceAsset_assetCategorySubgroup,
/* harmony export */   "eam_ajax_resourceAsset_assetCategorySubmachine": () => /* binding */ eam_ajax_resourceAsset_assetCategorySubmachine,
/* harmony export */   "eam_ajax_workOrder_head_index": () => /* binding */ eam_ajax_workOrder_head_index,
/* harmony export */   "eam_ajax_workOrder_head_show": () => /* binding */ eam_ajax_workOrder_head_show,
/* harmony export */   "eam_ajax_workOrder_head_store": () => /* binding */ eam_ajax_workOrder_head_store,
/* harmony export */   "eam_ajax_workOrder_head_delete": () => /* binding */ eam_ajax_workOrder_head_delete,
/* harmony export */   "eam_ajax_workOrder_head_unclose": () => /* binding */ eam_ajax_workOrder_head_unclose,
/* harmony export */   "eam_ajax_workOrder_head_waitingConfirm": () => /* binding */ eam_ajax_workOrder_head_waitingConfirm,
/* harmony export */   "eam_ajax_workOrder_head_updateStatus": () => /* binding */ eam_ajax_workOrder_head_updateStatus,
/* harmony export */   "eam_ajax_workOrder_head_closeJp": () => /* binding */ eam_ajax_workOrder_head_closeJp,
/* harmony export */   "eam_ajax_workOrder_op_all": () => /* binding */ eam_ajax_workOrder_op_all,
/* harmony export */   "eam_ajax_workOrder_op_store": () => /* binding */ eam_ajax_workOrder_op_store,
/* harmony export */   "eam_ajax_workOrder_op_delete": () => /* binding */ eam_ajax_workOrder_op_delete,
/* harmony export */   "eam_ajax_workOrder_re_all": () => /* binding */ eam_ajax_workOrder_re_all,
/* harmony export */   "eam_ajax_workOrder_report": () => /* binding */ eam_ajax_workOrder_report,
/* harmony export */   "eam_ajax_workOrder_report_part": () => /* binding */ eam_ajax_workOrder_report_part,
/* harmony export */   "eam_ajax_workOrder_re_store": () => /* binding */ eam_ajax_workOrder_re_store,
/* harmony export */   "eam_ajax_workOrder_re_delete": () => /* binding */ eam_ajax_workOrder_re_delete,
/* harmony export */   "eam_ajax_workOrder_mt_all": () => /* binding */ eam_ajax_workOrder_mt_all,
/* harmony export */   "eam_ajax_workOrder_mt_store": () => /* binding */ eam_ajax_workOrder_mt_store,
/* harmony export */   "eam_ajax_workOrder_mt_delete": () => /* binding */ eam_ajax_workOrder_mt_delete,
/* harmony export */   "eam_ajax_workOrder_mt_return": () => /* binding */ eam_ajax_workOrder_mt_return,
/* harmony export */   "eam_ajax_workOrder_mt_issue": () => /* binding */ eam_ajax_workOrder_mt_issue,
/* harmony export */   "eam_ajax_workOrder_lb_all": () => /* binding */ eam_ajax_workOrder_lb_all,
/* harmony export */   "eam_ajax_workOrder_lb_store": () => /* binding */ eam_ajax_workOrder_lb_store,
/* harmony export */   "eam_ajax_workOrder_lb_delete": () => /* binding */ eam_ajax_workOrder_lb_delete,
/* harmony export */   "eam_ajax_workOrder_cp_all": () => /* binding */ eam_ajax_workOrder_cp_all,
/* harmony export */   "eam_ajax_workOrder_cp_store": () => /* binding */ eam_ajax_workOrder_cp_store,
/* harmony export */   "eam_ajax_workOrder_cost_all": () => /* binding */ eam_ajax_workOrder_cost_all,
/* harmony export */   "eam_ajax_workOrder_itemcost_get": () => /* binding */ eam_ajax_workOrder_itemcost_get,
/* harmony export */   "eam_ajax_workOrder_itemonhand_get": () => /* binding */ eam_ajax_workOrder_itemonhand_get,
/* harmony export */   "eam_ajax_workOrder_defaultWipClass": () => /* binding */ eam_ajax_workOrder_defaultWipClass,
/* harmony export */   "eam_ajax_workOrder_report_summaryMonth": () => /* binding */ eam_ajax_workOrder_report_summaryMonth,
/* harmony export */   "eam_ajax_workOrder_report_summaryMonthExcel": () => /* binding */ eam_ajax_workOrder_report_summaryMonthExcel,
/* harmony export */   "eam_ajax_workOrder_report_payable": () => /* binding */ eam_ajax_workOrder_report_payable,
/* harmony export */   "eam_ajax_workOrder_report_closeWoJp": () => /* binding */ eam_ajax_workOrder_report_closeWoJp,
/* harmony export */   "eam_ajax_workOrder_report_mntHistory": () => /* binding */ eam_ajax_workOrder_report_mntHistory,
/* harmony export */   "eam_ajax_workOrder_report_maintenanceExcel": () => /* binding */ eam_ajax_workOrder_report_maintenanceExcel,
/* harmony export */   "eam_ajax_workOrder_report_purchaseExcel": () => /* binding */ eam_ajax_workOrder_report_purchaseExcel,
/* harmony export */   "eam_ajax_workOrder_report_jobAccount": () => /* binding */ eam_ajax_workOrder_report_jobAccount,
/* harmony export */   "eam_ajax_workOrder_report_laborAccount": () => /* binding */ eam_ajax_workOrder_report_laborAccount,
/* harmony export */   "eam_ajax_workOrder_report_woCost": () => /* binding */ eam_ajax_workOrder_report_woCost,
/* harmony export */   "eam_ajax_workOrder_report_laborExcel": () => /* binding */ eam_ajax_workOrder_report_laborExcel,
/* harmony export */   "eam_ajax_workOrder_report_summaryLabor": () => /* binding */ eam_ajax_workOrder_report_summaryLabor,
/* harmony export */   "eam_ajax_workOrder_report_receiptMat": () => /* binding */ eam_ajax_workOrder_report_receiptMat,
/* harmony export */   "eam_ajax_plan_versionPlan": () => /* binding */ eam_ajax_plan_versionPlan,
/* harmony export */   "eam_ajax_plan_confirm": () => /* binding */ eam_ajax_plan_confirm,
/* harmony export */   "eam_ajax_plan_store": () => /* binding */ eam_ajax_plan_store,
/* harmony export */   "eam_ajax_plan_search": () => /* binding */ eam_ajax_plan_search,
/* harmony export */   "eam_ajax_plan_openWorkOrder": () => /* binding */ eam_ajax_plan_openWorkOrder,
/* harmony export */   "eam_ajax_plan_deleteLine": () => /* binding */ eam_ajax_plan_deleteLine,
/* harmony export */   "eam_ajax_plan_fileImport": () => /* binding */ eam_ajax_plan_fileImport,
/* harmony export */   "eam_ajax_billMaterials_show": () => /* binding */ eam_ajax_billMaterials_show,
/* harmony export */   "eam_ajax_billMaterials_store": () => /* binding */ eam_ajax_billMaterials_store,
/* harmony export */   "eam_ajax_billMaterials_deleteLine": () => /* binding */ eam_ajax_billMaterials_deleteLine,
/* harmony export */   "eam_ajax_billMaterials_confirm": () => /* binding */ eam_ajax_billMaterials_confirm,
/* harmony export */   "eam_ajax_billMaterials_cancel": () => /* binding */ eam_ajax_billMaterials_cancel,
/* harmony export */   "eam_ajax_report_issueMatExcel": () => /* binding */ eam_ajax_report_issueMatExcel,
/* harmony export */   "eam_ajax_report_closedWo": () => /* binding */ eam_ajax_report_closedWo,
/* harmony export */   "eam_ajax_report_closedWo2": () => /* binding */ eam_ajax_report_closedWo2,
/* harmony export */   "eam_ajax_report_jobAccountDel": () => /* binding */ eam_ajax_report_jobAccountDel,
/* harmony export */   "eam_ajax_report_requestMatInv": () => /* binding */ eam_ajax_report_requestMatInv,
/* harmony export */   "eam_ajax_report_requestMatNon": () => /* binding */ eam_ajax_report_requestMatNon,
/* harmony export */   "eam_ajax_report_woComStatus": () => /* binding */ eam_ajax_report_woComStatus,
/* harmony export */   "eam_ajax_report_summaryMatStatus": () => /* binding */ eam_ajax_report_summaryMatStatus,
/* harmony export */   "eam_workRequests_create": () => /* binding */ eam_workRequests_create,
/* harmony export */   "eam_workRequests_index": () => /* binding */ eam_workRequests_index,
/* harmony export */   "eam_workRequests_waitingApprove": () => /* binding */ eam_workRequests_waitingApprove,
/* harmony export */   "eam_workOrders_create": () => /* binding */ eam_workOrders_create,
/* harmony export */   "eam_workOrders_waitingOpenWork": () => /* binding */ eam_workOrders_waitingOpenWork,
/* harmony export */   "eam_workOrders_listAllRepairJobs": () => /* binding */ eam_workOrders_listAllRepairJobs,
/* harmony export */   "eam_workOrders_listRepairJobsWaitingClose": () => /* binding */ eam_workOrders_listRepairJobsWaitingClose,
/* harmony export */   "eam_workOrders_confirmedListRepairWork": () => /* binding */ eam_workOrders_confirmedListRepairWork,
/* harmony export */   "eam_askForInformation_partsTransferredWarehouse": () => /* binding */ eam_askForInformation_partsTransferredWarehouse,
/* harmony export */   "eam_askForInformation_checkSparePartsInventory": () => /* binding */ eam_askForInformation_checkSparePartsInventory,
/* harmony export */   "eam_setup_machine": () => /* binding */ eam_setup_machine,
/* harmony export */   "eam_transaction_preventiveMaintenancePlan": () => /* binding */ eam_transaction_preventiveMaintenancePlan,
/* harmony export */   "eam_report_billMaterials": () => /* binding */ eam_report_billMaterials,
/* harmony export */   "eam_report_summaryMonth": () => /* binding */ eam_report_summaryMonth,
/* harmony export */   "eam_report_summaryMonthExcel": () => /* binding */ eam_report_summaryMonthExcel,
/* harmony export */   "eam_report_issueMatExcel": () => /* binding */ eam_report_issueMatExcel,
/* harmony export */   "eam_report_payable": () => /* binding */ eam_report_payable,
/* harmony export */   "eam_report_closedWo": () => /* binding */ eam_report_closedWo,
/* harmony export */   "eam_report_closedWo2": () => /* binding */ eam_report_closedWo2,
/* harmony export */   "eam_report_closedWoJp": () => /* binding */ eam_report_closedWoJp,
/* harmony export */   "eam_report_mntHistory": () => /* binding */ eam_report_mntHistory,
/* harmony export */   "eam_report_maintenance": () => /* binding */ eam_report_maintenance,
/* harmony export */   "eam_report_jobAccountDel": () => /* binding */ eam_report_jobAccountDel,
/* harmony export */   "eam_report_purchase": () => /* binding */ eam_report_purchase,
/* harmony export */   "eam_report_requestMatInv": () => /* binding */ eam_report_requestMatInv,
/* harmony export */   "eam_report_requestMatNon": () => /* binding */ eam_report_requestMatNon,
/* harmony export */   "eam_report_jobAccount": () => /* binding */ eam_report_jobAccount,
/* harmony export */   "eam_report_laborAccount": () => /* binding */ eam_report_laborAccount,
/* harmony export */   "eam_report_woComStatus": () => /* binding */ eam_report_woComStatus,
/* harmony export */   "eam_report_labor": () => /* binding */ eam_report_labor,
/* harmony export */   "eam_report_woCost": () => /* binding */ eam_report_woCost,
/* harmony export */   "eam_report_summaryLabor": () => /* binding */ eam_report_summaryLabor,
/* harmony export */   "eam_report_receiptMat": () => /* binding */ eam_report_receiptMat,
/* harmony export */   "eam_report_summaryMatStatus": () => /* binding */ eam_report_summaryMatStatus,
/* harmony export */   "om_ajax_": () => /* binding */ om_ajax_,
/* harmony export */   "om_ajax_coaMapping_index": () => /* binding */ om_ajax_coaMapping_index,
/* harmony export */   "om_ajax_vendor_index": () => /* binding */ om_ajax_vendor_index,
/* harmony export */   "om_ajax_searchOrder_index": () => /* binding */ om_ajax_searchOrder_index,
/* harmony export */   "om_ajax_getOrder_index": () => /* binding */ om_ajax_getOrder_index,
/* harmony export */   "om_ajax_getItemCate_index": () => /* binding */ om_ajax_getItemCate_index,
/* harmony export */   "om_ajax_getItem_index": () => /* binding */ om_ajax_getItem_index,
/* harmony export */   "om_ajax_getBankBranchs_index": () => /* binding */ om_ajax_getBankBranchs_index,
/* harmony export */   "om_ajax_getCheckHeader_index": () => /* binding */ om_ajax_getCheckHeader_index,
/* harmony export */   "om_ajax_getCheckHeaderDateTo_index": () => /* binding */ om_ajax_getCheckHeaderDateTo_index,
/* harmony export */   "om_settings_term_index": () => /* binding */ om_settings_term_index,
/* harmony export */   "om_settings_term_create": () => /* binding */ om_settings_term_create,
/* harmony export */   "om_settings_term_store": () => /* binding */ om_settings_term_store,
/* harmony export */   "om_settings_term_edit": () => /* binding */ om_settings_term_edit,
/* harmony export */   "om_settings_term_update": () => /* binding */ om_settings_term_update,
/* harmony export */   "om_settings_termExport_index": () => /* binding */ om_settings_termExport_index,
/* harmony export */   "om_settings_termExport_create": () => /* binding */ om_settings_termExport_create,
/* harmony export */   "om_settings_termExport_store": () => /* binding */ om_settings_termExport_store,
/* harmony export */   "om_settings_termExport_edit": () => /* binding */ om_settings_termExport_edit,
/* harmony export */   "om_settings_termExport_update": () => /* binding */ om_settings_termExport_update,
/* harmony export */   "om_settings_country_index": () => /* binding */ om_settings_country_index,
/* harmony export */   "om_settings_country_create": () => /* binding */ om_settings_country_create,
/* harmony export */   "om_settings_country_store": () => /* binding */ om_settings_country_store,
/* harmony export */   "om_settings_country_edit": () => /* binding */ om_settings_country_edit,
/* harmony export */   "om_settings_country_update": () => /* binding */ om_settings_country_update,
/* harmony export */   "om_settings_customer_index": () => /* binding */ om_settings_customer_index,
/* harmony export */   "om_settings_customer_create": () => /* binding */ om_settings_customer_create,
/* harmony export */   "om_settings_customer_store": () => /* binding */ om_settings_customer_store,
/* harmony export */   "om_settings_customer_edit": () => /* binding */ om_settings_customer_edit,
/* harmony export */   "om_settings_customer_update": () => /* binding */ om_settings_customer_update,
/* harmony export */   "om_settings_customer_primaryApproval": () => /* binding */ om_settings_customer_primaryApproval,
/* harmony export */   "om_settings_sequenceEcom_index": () => /* binding */ om_settings_sequenceEcom_index,
/* harmony export */   "om_settings_sequenceEcom_create": () => /* binding */ om_settings_sequenceEcom_create,
/* harmony export */   "om_settings_sequenceEcom_store": () => /* binding */ om_settings_sequenceEcom_store,
/* harmony export */   "om_settings_sequenceEcom_edit": () => /* binding */ om_settings_sequenceEcom_edit,
/* harmony export */   "om_settings_sequenceEcom_update": () => /* binding */ om_settings_sequenceEcom_update,
/* harmony export */   "om_settings_quotaCreditGroup_index": () => /* binding */ om_settings_quotaCreditGroup_index,
/* harmony export */   "om_settings_quotaCreditGroup_create": () => /* binding */ om_settings_quotaCreditGroup_create,
/* harmony export */   "om_settings_quotaCreditGroup_store": () => /* binding */ om_settings_quotaCreditGroup_store,
/* harmony export */   "om_settings_quotaCreditGroup_edit": () => /* binding */ om_settings_quotaCreditGroup_edit,
/* harmony export */   "om_settings_quotaCreditGroup_update": () => /* binding */ om_settings_quotaCreditGroup_update,
/* harmony export */   "om_settings_grantSpacialCase_index": () => /* binding */ om_settings_grantSpacialCase_index,
/* harmony export */   "om_settings_grantSpacialCase_create": () => /* binding */ om_settings_grantSpacialCase_create,
/* harmony export */   "om_settings_grantSpacialCase_store": () => /* binding */ om_settings_grantSpacialCase_store,
/* harmony export */   "om_settings_grantSpacialCase_edit": () => /* binding */ om_settings_grantSpacialCase_edit,
/* harmony export */   "om_settings_grantSpacialCase_update": () => /* binding */ om_settings_grantSpacialCase_update,
/* harmony export */   "om_settings_grantSpacialCase_delete": () => /* binding */ om_settings_grantSpacialCase_delete,
/* harmony export */   "om_settings_authorityList_index": () => /* binding */ om_settings_authorityList_index,
/* harmony export */   "om_settings_authorityList_create": () => /* binding */ om_settings_authorityList_create,
/* harmony export */   "om_settings_authorityList_store": () => /* binding */ om_settings_authorityList_store,
/* harmony export */   "om_settings_authorityList_edit": () => /* binding */ om_settings_authorityList_edit,
/* harmony export */   "om_settings_authorityList_update": () => /* binding */ om_settings_authorityList_update,
/* harmony export */   "om_settings_overQuotaApproval_index": () => /* binding */ om_settings_overQuotaApproval_index,
/* harmony export */   "om_settings_overQuotaApproval_create": () => /* binding */ om_settings_overQuotaApproval_create,
/* harmony export */   "om_settings_overQuotaApproval_store": () => /* binding */ om_settings_overQuotaApproval_store,
/* harmony export */   "om_settings_overQuotaApproval_edit": () => /* binding */ om_settings_overQuotaApproval_edit,
/* harmony export */   "om_settings_overQuotaApproval_update": () => /* binding */ om_settings_overQuotaApproval_update,
/* harmony export */   "om_settings_overQuotaApproval_delete": () => /* binding */ om_settings_overQuotaApproval_delete,
/* harmony export */   "om_settings_itemWeight_index": () => /* binding */ om_settings_itemWeight_index,
/* harmony export */   "om_settings_itemWeight_create": () => /* binding */ om_settings_itemWeight_create,
/* harmony export */   "om_settings_itemWeight_store": () => /* binding */ om_settings_itemWeight_store,
/* harmony export */   "om_settings_itemWeight_edit": () => /* binding */ om_settings_itemWeight_edit,
/* harmony export */   "om_settings_itemWeight_update": () => /* binding */ om_settings_itemWeight_update,
/* harmony export */   "om_settings_thailandTerritory_index": () => /* binding */ om_settings_thailandTerritory_index,
/* harmony export */   "om_settings_thailandTerritory_previewImport": () => /* binding */ om_settings_thailandTerritory_previewImport,
/* harmony export */   "om_settings_thailandTerritory_import": () => /* binding */ om_settings_thailandTerritory_import,
/* harmony export */   "om_settings_thailandTerritory_downloadExcelTemplate": () => /* binding */ om_settings_thailandTerritory_downloadExcelTemplate,
/* harmony export */   "om_settings_directDebitDomestic_index": () => /* binding */ om_settings_directDebitDomestic_index,
/* harmony export */   "om_settings_directDebitDomestic_create": () => /* binding */ om_settings_directDebitDomestic_create,
/* harmony export */   "om_settings_directDebitDomestic_store": () => /* binding */ om_settings_directDebitDomestic_store,
/* harmony export */   "om_settings_directDebitDomestic_edit": () => /* binding */ om_settings_directDebitDomestic_edit,
/* harmony export */   "om_settings_directDebitDomestic_update": () => /* binding */ om_settings_directDebitDomestic_update,
/* harmony export */   "om_settings_directDebitExport_index": () => /* binding */ om_settings_directDebitExport_index,
/* harmony export */   "om_settings_directDebitExport_create": () => /* binding */ om_settings_directDebitExport_create,
/* harmony export */   "om_settings_directDebitExport_store": () => /* binding */ om_settings_directDebitExport_store,
/* harmony export */   "om_settings_directDebitExport_edit": () => /* binding */ om_settings_directDebitExport_edit,
/* harmony export */   "om_settings_directDebitExport_update": () => /* binding */ om_settings_directDebitExport_update,
/* harmony export */   "om_settings_notAutoRelease_index": () => /* binding */ om_settings_notAutoRelease_index,
/* harmony export */   "om_settings_notAutoRelease_create": () => /* binding */ om_settings_notAutoRelease_create,
/* harmony export */   "om_settings_notAutoRelease_store": () => /* binding */ om_settings_notAutoRelease_store,
/* harmony export */   "om_settings_notAutoRelease_edit": () => /* binding */ om_settings_notAutoRelease_edit,
/* harmony export */   "om_settings_notAutoRelease_update": () => /* binding */ om_settings_notAutoRelease_update,
/* harmony export */   "om_settings_approverOrder_index": () => /* binding */ om_settings_approverOrder_index,
/* harmony export */   "om_settings_approverOrder_create": () => /* binding */ om_settings_approverOrder_create,
/* harmony export */   "om_settings_approverOrder_store": () => /* binding */ om_settings_approverOrder_store,
/* harmony export */   "om_settings_approverOrder_edit": () => /* binding */ om_settings_approverOrder_edit,
/* harmony export */   "om_settings_approverOrder_update": () => /* binding */ om_settings_approverOrder_update,
/* harmony export */   "om_settings_accountMapping_index": () => /* binding */ om_settings_accountMapping_index,
/* harmony export */   "om_settings_accountMapping_create": () => /* binding */ om_settings_accountMapping_create,
/* harmony export */   "om_settings_accountMapping_store": () => /* binding */ om_settings_accountMapping_store,
/* harmony export */   "om_settings_accountMapping_edit": () => /* binding */ om_settings_accountMapping_edit,
/* harmony export */   "om_settings_accountMapping_update": () => /* binding */ om_settings_accountMapping_update,
/* harmony export */   "om_settings_transportOwner_index": () => /* binding */ om_settings_transportOwner_index,
/* harmony export */   "om_settings_transportOwner_create": () => /* binding */ om_settings_transportOwner_create,
/* harmony export */   "om_settings_transportOwner_store": () => /* binding */ om_settings_transportOwner_store,
/* harmony export */   "om_settings_transportOwner_edit": () => /* binding */ om_settings_transportOwner_edit,
/* harmony export */   "om_settings_transportOwner_update": () => /* binding */ om_settings_transportOwner_update,
/* harmony export */   "om_settings_transportOwner_delete": () => /* binding */ om_settings_transportOwner_delete,
/* harmony export */   "om_settings_transportationRoute_index": () => /* binding */ om_settings_transportationRoute_index,
/* harmony export */   "om_settings_transportationRoute_create": () => /* binding */ om_settings_transportationRoute_create,
/* harmony export */   "om_settings_transportationRoute_store": () => /* binding */ om_settings_transportationRoute_store,
/* harmony export */   "om_settings_transportationRoute_edit": () => /* binding */ om_settings_transportationRoute_edit,
/* harmony export */   "om_settings_transportationRoute_update": () => /* binding */ om_settings_transportationRoute_update,
/* harmony export */   "om_settings_transportationRoute_delete": () => /* binding */ om_settings_transportationRoute_delete,
/* harmony export */   "om_settings_orderPeriod_index": () => /* binding */ om_settings_orderPeriod_index,
/* harmony export */   "om_settings_orderPeriod_create": () => /* binding */ om_settings_orderPeriod_create,
/* harmony export */   "om_settings_orderPeriod_store": () => /* binding */ om_settings_orderPeriod_store,
/* harmony export */   "om_settings_orderPeriod_edit": () => /* binding */ om_settings_orderPeriod_edit,
/* harmony export */   "om_settings_orderPeriod_update": () => /* binding */ om_settings_orderPeriod_update,
/* harmony export */   "om_settings_approverOrderExport_index": () => /* binding */ om_settings_approverOrderExport_index,
/* harmony export */   "om_settings_approverOrderExport_create": () => /* binding */ om_settings_approverOrderExport_create,
/* harmony export */   "om_settings_approverOrderExport_store": () => /* binding */ om_settings_approverOrderExport_store,
/* harmony export */   "om_settings_approverOrderExport_edit": () => /* binding */ om_settings_approverOrderExport_edit,
/* harmony export */   "om_settings_approverOrderExport_update": () => /* binding */ om_settings_approverOrderExport_update,
/* harmony export */   "om_approvalClaim_index": () => /* binding */ om_approvalClaim_index,
/* harmony export */   "om_outstanding_index": () => /* binding */ om_outstanding_index,
/* harmony export */   "om_outstanding_getData": () => /* binding */ om_outstanding_getData,
/* harmony export */   "om_outstanding_getYear": () => /* binding */ om_outstanding_getYear,
/* harmony export */   "om_improveFine_index": () => /* binding */ om_improveFine_index,
/* harmony export */   "om_improveFine_store": () => /* binding */ om_improveFine_store,
/* harmony export */   "om_settings_priceList_index": () => /* binding */ om_settings_priceList_index,
/* harmony export */   "om_settings_priceList_create": () => /* binding */ om_settings_priceList_create,
/* harmony export */   "om_settings_priceList_store": () => /* binding */ om_settings_priceList_store,
/* harmony export */   "om_settings_priceList_show": () => /* binding */ om_settings_priceList_show,
/* harmony export */   "om_settings_priceList_edit": () => /* binding */ om_settings_priceList_edit,
/* harmony export */   "om_settings_priceList_update": () => /* binding */ om_settings_priceList_update,
/* harmony export */   "om_settings_priceListExport_index": () => /* binding */ om_settings_priceListExport_index,
/* harmony export */   "om_settings_priceListExport_create": () => /* binding */ om_settings_priceListExport_create,
/* harmony export */   "om_settings_priceListExport_store": () => /* binding */ om_settings_priceListExport_store,
/* harmony export */   "om_settings_priceListExport_show": () => /* binding */ om_settings_priceListExport_show,
/* harmony export */   "om_settings_priceListExport_edit": () => /* binding */ om_settings_priceListExport_edit,
/* harmony export */   "om_settings_priceListExport_update": () => /* binding */ om_settings_priceListExport_update,
/* harmony export */   "om_ajax_customers_exports_exports_list": () => /* binding */ om_ajax_customers_exports_exports_list,
/* harmony export */   "om_ajax_customers_exports_exports_type": () => /* binding */ om_ajax_customers_exports_exports_type,
/* harmony export */   "om_ajax_customers_exports_exports_country": () => /* binding */ om_ajax_customers_exports_exports_country,
/* harmony export */   "om_ajax_customers_exports_": () => /* binding */ om_ajax_customers_exports_,
/* harmony export */   "om_ajax_customers_exports_foreign_customercontactList": () => /* binding */ om_ajax_customers_exports_foreign_customercontactList,
/* harmony export */   "om_ajax_customers_exports_foreign_customershippingList": () => /* binding */ om_ajax_customers_exports_foreign_customershippingList,
/* harmony export */   "om_ajax_customers_exports_foreign_insertcustomercontact": () => /* binding */ om_ajax_customers_exports_foreign_insertcustomercontact,
/* harmony export */   "om_ajax_customers_exports_foreign_updatecustomercontact": () => /* binding */ om_ajax_customers_exports_foreign_updatecustomercontact,
/* harmony export */   "om_ajax_customers_exports_foreign_insertcustomershipping": () => /* binding */ om_ajax_customers_exports_foreign_insertcustomershipping,
/* harmony export */   "om_ajax_customers_exports_foreign_updatecustomershipping": () => /* binding */ om_ajax_customers_exports_foreign_updatecustomershipping,
/* harmony export */   "om_ajax_customers_domestics_": () => /* binding */ om_ajax_customers_domestics_,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customers": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customers,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersShipsites": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersShipsites,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersPrevious": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersPrevious,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersOwner": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersOwner,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersContracts": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersContracts,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersContractbooks": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersContractbooks,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersContractgroup": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersContractgroup,
/* harmony export */   "om_ajax_customers_domestics_domestics_insert_customersQuota": () => /* binding */ om_ajax_customers_domestics_domestics_insert_customersQuota,
/* harmony export */   "om_ajax_customers_domestics_domestics_update_customers": () => /* binding */ om_ajax_customers_domestics_domestics_update_customers,
/* harmony export */   "om_ajax_customers_domestics_domestics_update_customersPrevious": () => /* binding */ om_ajax_customers_domestics_domestics_update_customersPrevious,
/* harmony export */   "om_ajax_customers_domestics_domestics_update_customersOwner": () => /* binding */ om_ajax_customers_domestics_domestics_update_customersOwner,
/* harmony export */   "om_ajax_customers_domestics_domestics_update_customersShipsites": () => /* binding */ om_ajax_customers_domestics_domestics_update_customersShipsites,
/* harmony export */   "om_ajax_customers_domestics_domestics_update_customersQuota": () => /* binding */ om_ajax_customers_domestics_domestics_update_customersQuota,
/* harmony export */   "om_ajax_customers_domestics_previous": () => /* binding */ om_ajax_customers_domestics_previous,
/* harmony export */   "om_ajax_customers_domestics_owner": () => /* binding */ om_ajax_customers_domestics_owner,
/* harmony export */   "om_ajax_customers_domestics_quotaHeaders": () => /* binding */ om_ajax_customers_domestics_quotaHeaders,
/* harmony export */   "om_ajax_customers_domestics_shipSites": () => /* binding */ om_ajax_customers_domestics_shipSites,
/* harmony export */   "om_ajax_customers_domestics_quota_lines_items": () => /* binding */ om_ajax_customers_domestics_quota_lines_items,
/* harmony export */   "om_ajax_customers_domestics_province_list": () => /* binding */ om_ajax_customers_domestics_province_list,
/* harmony export */   "om_ajax_customers_domestics_city_list": () => /* binding */ om_ajax_customers_domestics_city_list,
/* harmony export */   "om_ajax_customers_domestics_district_list": () => /* binding */ om_ajax_customers_domestics_district_list,
/* harmony export */   "om_ajax_customers_domestics_postcode": () => /* binding */ om_ajax_customers_domestics_postcode,
/* harmony export */   "om_ajax_customers_domestics_get_ship_site_name": () => /* binding */ om_ajax_customers_domestics_get_ship_site_name,
/* harmony export */   "om_ajax_customers_domestics_get_customer_name": () => /* binding */ om_ajax_customers_domestics_get_customer_name,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersShipsites": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersShipsites,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersPrevious": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersPrevious,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersOwner": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersOwner,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersContracts": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersContracts,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersContractbooks": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersContractbooks,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersContractgroups": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersContractgroups,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersQuota": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersQuota,
/* harmony export */   "om_ajax_customers_domestics_domestics_delete_customersQuotaLine": () => /* binding */ om_ajax_customers_domestics_domestics_delete_customersQuotaLine,
/* harmony export */   "om_ajax_promotions_": () => /* binding */ om_ajax_promotions_,
/* harmony export */   "om_ajax_promotions_store": () => /* binding */ om_ajax_promotions_store,
/* harmony export */   "om_ajax_promotions_update": () => /* binding */ om_ajax_promotions_update,
/* harmony export */   "om_ajax_promotions_remove": () => /* binding */ om_ajax_promotions_remove,
/* harmony export */   "om_ajax_promotions_copy": () => /* binding */ om_ajax_promotions_copy,
/* harmony export */   "om_ajax_releaseCredit_": () => /* binding */ om_ajax_releaseCredit_,
/* harmony export */   "om_ajax_bank_": () => /* binding */ om_ajax_bank_,
/* harmony export */   "om_ajax_postponeDelivery_": () => /* binding */ om_ajax_postponeDelivery_,
/* harmony export */   "om_ajax_postponeDelivery_periodByYears": () => /* binding */ om_ajax_postponeDelivery_periodByYears,
/* harmony export */   "om_ajax_transferBiWeekly_": () => /* binding */ om_ajax_transferBiWeekly_,
/* harmony export */   "om_ajax_overdueDebt_": () => /* binding */ om_ajax_overdueDebt_,
/* harmony export */   "om_ajax_overdueDebt_getCustomerName": () => /* binding */ om_ajax_overdueDebt_getCustomerName,
/* harmony export */   "om_ajax_fortnightly": () => /* binding */ om_ajax_fortnightly,
/* harmony export */   "om_ajax_fortnightlyupdate_sequence_ecom": () => /* binding */ om_ajax_fortnightlyupdate_sequence_ecom,
/* harmony export */   "om_ajax_fortnightlydelete_sequence_ecom": () => /* binding */ om_ajax_fortnightlydelete_sequence_ecom,
/* harmony export */   "om_ajax_fortnightlyfilter_sequence_ecom": () => /* binding */ om_ajax_fortnightlyfilter_sequence_ecom,
/* harmony export */   "om_ajax_biweeklyupdate_periods": () => /* binding */ om_ajax_biweeklyupdate_periods,
/* harmony export */   "om_ajax_biweeklyget_holiday": () => /* binding */ om_ajax_biweeklyget_holiday,
/* harmony export */   "om_ajax_biweeklysearch_periods": () => /* binding */ om_ajax_biweeklysearch_periods,
/* harmony export */   "om_ajax_transferMonthly_": () => /* binding */ om_ajax_transferMonthly_,
/* harmony export */   "om_ajax_consignmentClubsearch_consignment": () => /* binding */ om_ajax_consignmentClubsearch_consignment,
/* harmony export */   "om_ajax_consignmentClubget_order_lines": () => /* binding */ om_ajax_consignmentClubget_order_lines,
/* harmony export */   "om_ajax_consignmentClubsearch_consignment_club": () => /* binding */ om_ajax_consignmentClubsearch_consignment_club,
/* harmony export */   "om_ajax_consignmentClubupdate_consignment_club": () => /* binding */ om_ajax_consignmentClubupdate_consignment_club,
/* harmony export */   "om_ajax_saleConfirmationupdate_order": () => /* binding */ om_ajax_saleConfirmationupdate_order,
/* harmony export */   "om_ajax_saleConfirmationsearch": () => /* binding */ om_ajax_saleConfirmationsearch,
/* harmony export */   "om_ajax_saleConfirmationcreate_sale_confirmation": () => /* binding */ om_ajax_saleConfirmationcreate_sale_confirmation,
/* harmony export */   "om_ajax_saleConfirmationcopy_sale_number": () => /* binding */ om_ajax_saleConfirmationcopy_sale_number,
/* harmony export */   "om_ajax_saleConfirmationcreate_sale_number": () => /* binding */ om_ajax_saleConfirmationcreate_sale_number,
/* harmony export */   "om_ajax_saleConfirmationupdate_sale_confirmation": () => /* binding */ om_ajax_saleConfirmationupdate_sale_confirmation,
/* harmony export */   "om_ajax_saleConfirmationconfirm_sale_confirmation": () => /* binding */ om_ajax_saleConfirmationconfirm_sale_confirmation,
/* harmony export */   "om_ajax_saleConfirmationcopy_to_proforma_invoice": () => /* binding */ om_ajax_saleConfirmationcopy_to_proforma_invoice,
/* harmony export */   "om_ajax_saleConfirmationcheckCancel": () => /* binding */ om_ajax_saleConfirmationcheckCancel,
/* harmony export */   "om_ajax_saleConfirmationcancel": () => /* binding */ om_ajax_saleConfirmationcancel,
/* harmony export */   "om_ajax_saleConfirmationcustomerShipsite": () => /* binding */ om_ajax_saleConfirmationcustomerShipsite,
/* harmony export */   "om_ajax_approvePrepareOrdersearch": () => /* binding */ om_ajax_approvePrepareOrdersearch,
/* harmony export */   "om_ajax_approvePrepareOrdermanage": () => /* binding */ om_ajax_approvePrepareOrdermanage,
/* harmony export */   "om_ajax_order_approveprepare_search": () => /* binding */ om_ajax_order_approveprepare_search,
/* harmony export */   "om_ajax_order_approveprepare_search_customer": () => /* binding */ om_ajax_order_approveprepare_search_customer,
/* harmony export */   "om_ajax_order_approveprepare_confirm": () => /* binding */ om_ajax_order_approveprepare_confirm,
/* harmony export */   "om_ajax_order_approveprepare_cancel": () => /* binding */ om_ajax_order_approveprepare_cancel,
/* harmony export */   "om_ajax_order_prepare_runNumber": () => /* binding */ om_ajax_order_prepare_runNumber,
/* harmony export */   "om_ajax_order_prepare_dataCustomer": () => /* binding */ om_ajax_order_prepare_dataCustomer,
/* harmony export */   "om_ajax_order_prepare_dataItem": () => /* binding */ om_ajax_order_prepare_dataItem,
/* harmony export */   "om_ajax_order_prepare_setDayamount": () => /* binding */ om_ajax_order_prepare_setDayamount,
/* harmony export */   "om_ajax_order_approve_search_item": () => /* binding */ om_ajax_order_approve_search_item,
/* harmony export */   "om_ajax_order_approve_submit": () => /* binding */ om_ajax_order_approve_submit,
/* harmony export */   "om_ajax_order_approve_cancel": () => /* binding */ om_ajax_order_approve_cancel,
/* harmony export */   "om_order_approveprepare": () => /* binding */ om_order_approveprepare,
/* harmony export */   "om_ajax_proformaInvoicesearch_sale_number": () => /* binding */ om_ajax_proformaInvoicesearch_sale_number,
/* harmony export */   "om_ajax_proformaInvoicesearch": () => /* binding */ om_ajax_proformaInvoicesearch,
/* harmony export */   "om_ajax_proformaInvoicecreate_proforma_invoice": () => /* binding */ om_ajax_proformaInvoicecreate_proforma_invoice,
/* harmony export */   "om_proformaInvoicecreate_proforma_invoice": () => /* binding */ om_proformaInvoicecreate_proforma_invoice,
/* harmony export */   "om_ajax_proformaInvoicemanage_proforma_invoice": () => /* binding */ om_ajax_proformaInvoicemanage_proforma_invoice,
/* harmony export */   "om_ajax_proformaInvoicecreate_proforma_lot": () => /* binding */ om_ajax_proformaInvoicecreate_proforma_lot,
/* harmony export */   "om_ajax_proformaInvoiceget_proforma_lot": () => /* binding */ om_ajax_proformaInvoiceget_proforma_lot,
/* harmony export */   "om_ajax_proformaInvoicecheckCancel": () => /* binding */ om_ajax_proformaInvoicecheckCancel,
/* harmony export */   "om_ajax_proformaInvoicecancel": () => /* binding */ om_ajax_proformaInvoicecancel,
/* harmony export */   "om_ajax_proformaInvoiceupdateLot": () => /* binding */ om_ajax_proformaInvoiceupdateLot,
/* harmony export */   "om_ajax_proformaInvoicedelete_all_lot": () => /* binding */ om_ajax_proformaInvoicedelete_all_lot,
/* harmony export */   "om_ajax_taxInvoiceExportcreate": () => /* binding */ om_ajax_taxInvoiceExportcreate,
/* harmony export */   "om_ajax_taxInvoiceExportsearch": () => /* binding */ om_ajax_taxInvoiceExportsearch,
/* harmony export */   "om_ajax_taxInvoiceExportmanage": () => /* binding */ om_ajax_taxInvoiceExportmanage,
/* harmony export */   "om_ajax_taxInvoiceExportcheck_cancel": () => /* binding */ om_ajax_taxInvoiceExportcheck_cancel,
/* harmony export */   "om_ajax_taxInvoiceExportcancel": () => /* binding */ om_ajax_taxInvoiceExportcancel,
/* harmony export */   "om_ajax_taxInvoiceExportclose_work": () => /* binding */ om_ajax_taxInvoiceExportclose_work,
/* harmony export */   "om_ajax_exchangeExportsearch": () => /* binding */ om_ajax_exchangeExportsearch,
/* harmony export */   "om_ajax_exchangeExportupdate": () => /* binding */ om_ajax_exchangeExportupdate,
/* harmony export */   "om_order_approveprepareapproveprepare_index": () => /* binding */ om_order_approveprepareapproveprepare_index,
/* harmony export */   "om_order_approvepreparaapproveprepara_index": () => /* binding */ om_order_approvepreparaapproveprepara_index,
/* harmony export */   "om_proformaInvoicesearch_sale_number": () => /* binding */ om_proformaInvoicesearch_sale_number,
/* harmony export */   "om_customers_exports_index": () => /* binding */ om_customers_exports_index,
/* harmony export */   "om_customers_exports_show": () => /* binding */ om_customers_exports_show,
/* harmony export */   "om_customers_exports_edit": () => /* binding */ om_customers_exports_edit,
/* harmony export */   "om_customers_exports_update": () => /* binding */ om_customers_exports_update,
/* harmony export */   "om_customers_approves_": () => /* binding */ om_customers_approves_,
/* harmony export */   "om_customers_approves_view": () => /* binding */ om_customers_approves_view,
/* harmony export */   "om_customers_domesticsBroker": () => /* binding */ om_customers_domesticsBroker,
/* harmony export */   "om_customers_domestics_index": () => /* binding */ om_customers_domestics_index,
/* harmony export */   "om_customers_domestics_create": () => /* binding */ om_customers_domestics_create,
/* harmony export */   "om_customers_domestics_show": () => /* binding */ om_customers_domestics_show,
/* harmony export */   "om_customers_detail": () => /* binding */ om_customers_detail,
/* harmony export */   "om_releaseCredit_": () => /* binding */ om_releaseCredit_,
/* harmony export */   "om_releaseCredit_update": () => /* binding */ om_releaseCredit_update,
/* harmony export */   "om_promotions_": () => /* binding */ om_promotions_,
/* harmony export */   "om_promotions_storeHeader": () => /* binding */ om_promotions_storeHeader,
/* harmony export */   "om_postponeDelivery_": () => /* binding */ om_postponeDelivery_,
/* harmony export */   "om_auto_": () => /* binding */ om_auto_,
/* harmony export */   "om_": () => /* binding */ om_,
/* harmony export */   "om_additionIndex": () => /* binding */ om_additionIndex,
/* harmony export */   "om_additionQuota": () => /* binding */ om_additionQuota,
/* harmony export */   "om_additionUpload": () => /* binding */ om_additionUpload,
/* harmony export */   "om_additionFilesdelete": () => /* binding */ om_additionFilesdelete,
/* harmony export */   "om_additionQuotaUpdate": () => /* binding */ om_additionQuotaUpdate,
/* harmony export */   "om_additionDownload": () => /* binding */ om_additionDownload,
/* harmony export */   "om_cancelConsignment": () => /* binding */ om_cancelConsignment,
/* harmony export */   "om_canceledConsignment": () => /* binding */ om_canceledConsignment,
/* harmony export */   "om_deliveryRateIndex": () => /* binding */ om_deliveryRateIndex,
/* harmony export */   "om_deliveryRateServiceCall": () => /* binding */ om_deliveryRateServiceCall,
/* harmony export */   "om_deliveryRateGetnewoil": () => /* binding */ om_deliveryRateGetnewoil,
/* harmony export */   "om_deliveryRateStore": () => /* binding */ om_deliveryRateStore,
/* harmony export */   "om_deliveryRatePriceNew": () => /* binding */ om_deliveryRatePriceNew,
/* harmony export */   "om_draftPayoutIndex": () => /* binding */ om_draftPayoutIndex,
/* harmony export */   "om_draftPayoutListproduct": () => /* binding */ om_draftPayoutListproduct,
/* harmony export */   "om_draftPayoutStoreDraft": () => /* binding */ om_draftPayoutStoreDraft,
/* harmony export */   "om_draftPayoutPrint": () => /* binding */ om_draftPayoutPrint,
/* harmony export */   "om_domesticMatchingIndex": () => /* binding */ om_domesticMatchingIndex,
/* harmony export */   "om_domesticMatchingGetData": () => /* binding */ om_domesticMatchingGetData,
/* harmony export */   "om_domesticMatchingUploaded": () => /* binding */ om_domesticMatchingUploaded,
/* harmony export */   "om_domesticMatchingUploadDeleted": () => /* binding */ om_domesticMatchingUploadDeleted,
/* harmony export */   "om_domesticMatchingUnmatching": () => /* binding */ om_domesticMatchingUnmatching,
/* harmony export */   "om_domesticMatchingMatching": () => /* binding */ om_domesticMatchingMatching,
/* harmony export */   "om_domesticMatchingGetinvoice": () => /* binding */ om_domesticMatchingGetinvoice,
/* harmony export */   "om_domesticMatchingGetamount": () => /* binding */ om_domesticMatchingGetamount,
/* harmony export */   "om_domesticMatchingUpload": () => /* binding */ om_domesticMatchingUpload,
/* harmony export */   "om_domesticMatchingDelete": () => /* binding */ om_domesticMatchingDelete,
/* harmony export */   "om_domesticMatchingDownload": () => /* binding */ om_domesticMatchingDownload,
/* harmony export */   "om_paymentMethodIndex": () => /* binding */ om_paymentMethodIndex,
/* harmony export */   "om_paymentMethodPrint": () => /* binding */ om_paymentMethodPrint,
/* harmony export */   "om_paymentMethodGetlistbank": () => /* binding */ om_paymentMethodGetlistbank,
/* harmony export */   "om_paymentMethodGetinfofordraft": () => /* binding */ om_paymentMethodGetinfofordraft,
/* harmony export */   "om_paymentMethodGetvaluebank": () => /* binding */ om_paymentMethodGetvaluebank,
/* harmony export */   "om_paymentMethodGetpaymentnumber": () => /* binding */ om_paymentMethodGetpaymentnumber,
/* harmony export */   "om_paymentMethodDraftpayment": () => /* binding */ om_paymentMethodDraftpayment,
/* harmony export */   "om_paymentMethodPayment": () => /* binding */ om_paymentMethodPayment,
/* harmony export */   "om_paymentMethodPaymentUpload": () => /* binding */ om_paymentMethodPaymentUpload,
/* harmony export */   "om_paymentMethodPaymentDelete": () => /* binding */ om_paymentMethodPaymentDelete,
/* harmony export */   "om_paymentMethodGetvaluefromnumber": () => /* binding */ om_paymentMethodGetvaluefromnumber,
/* harmony export */   "om_paymentMethodPaymentverify": () => /* binding */ om_paymentMethodPaymentverify,
/* harmony export */   "om_paymentMethodPaymentUploadRemove": () => /* binding */ om_paymentMethodPaymentUploadRemove,
/* harmony export */   "om_paymentMethodDownload": () => /* binding */ om_paymentMethodDownload,
/* harmony export */   "om_exportPayoutIndex": () => /* binding */ om_exportPayoutIndex,
/* harmony export */   "om_exportPayoutGetlistbank": () => /* binding */ om_exportPayoutGetlistbank,
/* harmony export */   "om_exportPayoutGetvaluebank": () => /* binding */ om_exportPayoutGetvaluebank,
/* harmony export */   "om_exportPayoutGetpaymentnumber": () => /* binding */ om_exportPayoutGetpaymentnumber,
/* harmony export */   "om_exportPaymentMethodDraftpayment": () => /* binding */ om_exportPaymentMethodDraftpayment,
/* harmony export */   "om_exportMethodPaymentDelete": () => /* binding */ om_exportMethodPaymentDelete,
/* harmony export */   "om_exportMethodPayment": () => /* binding */ om_exportMethodPayment,
/* harmony export */   "om_exportMethodPrint": () => /* binding */ om_exportMethodPrint,
/* harmony export */   "om_exportMethodGetinfofordraft": () => /* binding */ om_exportMethodGetinfofordraft,
/* harmony export */   "om_exportMethodGetvaluefromnumber": () => /* binding */ om_exportMethodGetvaluefromnumber,
/* harmony export */   "om_exportMethodPaymentUpload": () => /* binding */ om_exportMethodPaymentUpload,
/* harmony export */   "om_exportMatchingIndex": () => /* binding */ om_exportMatchingIndex,
/* harmony export */   "om_exportMatchingUnmatching": () => /* binding */ om_exportMatchingUnmatching,
/* harmony export */   "om_exportMatchingUploaded": () => /* binding */ om_exportMatchingUploaded,
/* harmony export */   "om_exportMatchingUploadDeleted": () => /* binding */ om_exportMatchingUploadDeleted,
/* harmony export */   "om_exportMatchingGetData": () => /* binding */ om_exportMatchingGetData,
/* harmony export */   "om_exportMatchingMatching": () => /* binding */ om_exportMatchingMatching,
/* harmony export */   "om_exportMatchingGetinvoice": () => /* binding */ om_exportMatchingGetinvoice,
/* harmony export */   "om_exportMatchingGetamount": () => /* binding */ om_exportMatchingGetamount,
/* harmony export */   "om_exportMatchingGetDataexchangerate": () => /* binding */ om_exportMatchingGetDataexchangerate,
/* harmony export */   "om_taxAdjustIndex": () => /* binding */ om_taxAdjustIndex,
/* harmony export */   "om_taxAdjustRecivedata": () => /* binding */ om_taxAdjustRecivedata,
/* harmony export */   "om_taxAdjustSenddata": () => /* binding */ om_taxAdjustSenddata,
/* harmony export */   "om_indexTransferCommission": () => /* binding */ om_indexTransferCommission,
/* harmony export */   "om_sendapTransferCommission": () => /* binding */ om_sendapTransferCommission,
/* harmony export */   "om_indexTransferProvince": () => /* binding */ om_indexTransferProvince,
/* harmony export */   "om_calculateTransferProvince": () => /* binding */ om_calculateTransferProvince,
/* harmony export */   "om_closeFlagIndex": () => /* binding */ om_closeFlagIndex,
/* harmony export */   "om_closeFlagRelease": () => /* binding */ om_closeFlagRelease,
/* harmony export */   "om_closeFlagProcess": () => /* binding */ om_closeFlagProcess,
/* harmony export */   "om_closeFlagProcessExport": () => /* binding */ om_closeFlagProcessExport,
/* harmony export */   "om_transferBiWeekly_": () => /* binding */ om_transferBiWeekly_,
/* harmony export */   "om_overdueDebt_index": () => /* binding */ om_overdueDebt_index,
/* harmony export */   "om_overdueDebt_show": () => /* binding */ om_overdueDebt_show,
/* harmony export */   "om_saleConfirmation_index": () => /* binding */ om_saleConfirmation_index,
/* harmony export */   "om_saleConfirmation_show": () => /* binding */ om_saleConfirmation_show,
/* harmony export */   "om_sequenceFortnightly_index": () => /* binding */ om_sequenceFortnightly_index,
/* harmony export */   "om_sequenceFortnightly_show": () => /* binding */ om_sequenceFortnightly_show,
/* harmony export */   "om_biweeklyPeriods_index": () => /* binding */ om_biweeklyPeriods_index,
/* harmony export */   "om_transferMonthly_": () => /* binding */ om_transferMonthly_,
/* harmony export */   "om_order_prepare_order": () => /* binding */ om_order_prepare_order,
/* harmony export */   "om_order_prepare_search": () => /* binding */ om_order_prepare_search,
/* harmony export */   "om_order_prepare_create_show": () => /* binding */ om_order_prepare_create_show,
/* harmony export */   "om_order_prepare_prepare_edit": () => /* binding */ om_order_prepare_prepare_edit,
/* harmony export */   "om_order_prepare_": () => /* binding */ om_order_prepare_,
/* harmony export */   "om_order_prepare_create_submit": () => /* binding */ om_order_prepare_create_submit,
/* harmony export */   "om_order_prepare_update_submit": () => /* binding */ om_order_prepare_update_submit,
/* harmony export */   "om_order_prepare_approve": () => /* binding */ om_order_prepare_approve,
/* harmony export */   "om_order_prepare_cancel": () => /* binding */ om_order_prepare_cancel,
/* harmony export */   "om_order_prepare_copy": () => /* binding */ om_order_prepare_copy,
/* harmony export */   "om_order_approveapprove_index": () => /* binding */ om_order_approveapprove_index,
/* harmony export */   "om_getInvoiceHeader": () => /* binding */ om_getInvoiceHeader,
/* harmony export */   "om_getInvoiceHeaderSave": () => /* binding */ om_getInvoiceHeaderSave,
/* harmony export */   "om_proformaInvoice_index": () => /* binding */ om_proformaInvoice_index,
/* harmony export */   "om_proformaInvoice_show": () => /* binding */ om_proformaInvoice_show,
/* harmony export */   "om_taxInvoiceExport_index": () => /* binding */ om_taxInvoiceExport_index,
/* harmony export */   "om_taxInvoiceExport_show": () => /* binding */ om_taxInvoiceExport_show,
/* harmony export */   "om_transpotReportIndex": () => /* binding */ om_transpotReportIndex,
/* harmony export */   "om_transpotReportDraftData": () => /* binding */ om_transpotReportDraftData,
/* harmony export */   "om_transpotReportCreateDataone": () => /* binding */ om_transpotReportCreateDataone,
/* harmony export */   "om_transpotReportCreateDatatwo": () => /* binding */ om_transpotReportCreateDatatwo,
/* harmony export */   "om_order_direct_debit": () => /* binding */ om_order_direct_debit,
/* harmony export */   "om_consignment": () => /* binding */ om_consignment,
/* harmony export */   "om_consignmentgetData": () => /* binding */ om_consignmentgetData,
/* harmony export */   "om_invoice_cancelInvoice": () => /* binding */ om_invoice_cancelInvoice,
/* harmony export */   "om_invoice_canceledInvoice": () => /* binding */ om_invoice_canceledInvoice,
/* harmony export */   "om_invoice_getlistCancelInvoice": () => /* binding */ om_invoice_getlistCancelInvoice,
/* harmony export */   "om_consignmentClub_index": () => /* binding */ om_consignmentClub_index,
/* harmony export */   "om_consignmentClub_show": () => /* binding */ om_consignmentClub_show,
/* harmony export */   "om_approvePrepare_index": () => /* binding */ om_approvePrepare_index,
/* harmony export */   "om_approvePrepare_show": () => /* binding */ om_approvePrepare_show,
/* harmony export */   "om_rmaExport_index": () => /* binding */ om_rmaExport_index,
/* harmony export */   "om_rmaExport_show": () => /* binding */ om_rmaExport_show,
/* harmony export */   "om_exchangeExport_index": () => /* binding */ om_exchangeExport_index,
/* harmony export */   "om_exchangeExport_show": () => /* binding */ om_exchangeExport_show,
/* harmony export */   "om_approvePrepare_print": () => /* binding */ om_approvePrepare_print,
/* harmony export */   "om_paoTaxMt_index": () => /* binding */ om_paoTaxMt_index,
/* harmony export */   "om_paoTaxMt_search": () => /* binding */ om_paoTaxMt_search,
/* harmony export */   "om_paoTaxMt_validate": () => /* binding */ om_paoTaxMt_validate,
/* harmony export */   "om_paoTaxMt_store": () => /* binding */ om_paoTaxMt_store,
/* harmony export */   "om_paoTaxMt_update": () => /* binding */ om_paoTaxMt_update,
/* harmony export */   "om_paoTaxMt_exReport": () => /* binding */ om_paoTaxMt_exReport,
/* harmony export */   "ir_ajax_subGroups_show": () => /* binding */ ir_ajax_subGroups_show,
/* harmony export */   "ir_ajax_productGroups_updateActiveFlag": () => /* binding */ ir_ajax_productGroups_updateActiveFlag,
/* harmony export */   "ir_ajax_subGroups_checkInactive": () => /* binding */ ir_ajax_subGroups_checkInactive,
/* harmony export */   "ir_ajax_productGroup": () => /* binding */ ir_ajax_productGroup,
/* harmony export */   "ir_settings_productGroup": () => /* binding */ ir_settings_productGroup,
/* harmony export */   "ir_ajax_getLocator": () => /* binding */ ir_ajax_getLocator,
/* harmony export */   "ir_settings_getLocator": () => /* binding */ ir_settings_getLocator,
/* harmony export */   "ir_ajax_updateActiveFlag": () => /* binding */ ir_ajax_updateActiveFlag,
/* harmony export */   "ir_ajax_destroy": () => /* binding */ ir_ajax_destroy,
/* harmony export */   "ir_ajax_getValueSet": () => /* binding */ ir_ajax_getValueSet,
/* harmony export */   "ir_ajax_": () => /* binding */ ir_ajax_,
/* harmony export */   "ir_ajax_subGroups_destroy": () => /* binding */ ir_ajax_subGroups_destroy,
/* harmony export */   "ir_settings_productGroups_index": () => /* binding */ ir_settings_productGroups_index,
/* harmony export */   "ir_settings_productGroups_create": () => /* binding */ ir_settings_productGroups_create,
/* harmony export */   "ir_settings_productGroups_store": () => /* binding */ ir_settings_productGroups_store,
/* harmony export */   "ir_settings_productGroups_update": () => /* binding */ ir_settings_productGroups_update,
/* harmony export */   "ir_settings_productGroups_edit": () => /* binding */ ir_settings_productGroups_edit,
/* harmony export */   "ir_settings_productHeader_index": () => /* binding */ ir_settings_productHeader_index,
/* harmony export */   "ir_settings_productHeader_create": () => /* binding */ ir_settings_productHeader_create,
/* harmony export */   "ir_settings_productHeader_store": () => /* binding */ ir_settings_productHeader_store,
/* harmony export */   "ir_settings_productHeader_search": () => /* binding */ ir_settings_productHeader_search,
/* harmony export */   "ir_settings_productHeader_edit": () => /* binding */ ir_settings_productHeader_edit,
/* harmony export */   "ir_settings_productHeader_update": () => /* binding */ ir_settings_productHeader_update,
/* harmony export */   "ir_settings_subGroups_index": () => /* binding */ ir_settings_subGroups_index,
/* harmony export */   "ir_settings_subGroups_create": () => /* binding */ ir_settings_subGroups_create,
/* harmony export */   "ir_settings_subGroups_update": () => /* binding */ ir_settings_subGroups_update,
/* harmony export */   "ir_settings_subGroups_store": () => /* binding */ ir_settings_subGroups_store,
/* harmony export */   "ir_settings_subGroups_search": () => /* binding */ ir_settings_subGroups_search,
/* harmony export */   "ir_settings_subGroups_edit": () => /* binding */ ir_settings_subGroups_edit,
/* harmony export */   "ir_ajax_Lov_lovCompanies": () => /* binding */ ir_ajax_Lov_lovCompanies,
/* harmony export */   "ir_ajax_Lov_lovVendor": () => /* binding */ ir_ajax_Lov_lovVendor,
/* harmony export */   "ir_ajax_Lov_lovBranchCode": () => /* binding */ ir_ajax_Lov_lovBranchCode,
/* harmony export */   "ir_ajax_Lov_lovCustomerNumber": () => /* binding */ ir_ajax_Lov_lovCustomerNumber,
/* harmony export */   "ir_ajax_Lov_lovPolicySetHeader": () => /* binding */ ir_ajax_Lov_lovPolicySetHeader,
/* harmony export */   "ir_ajax_Lov_lovPolicyType": () => /* binding */ ir_ajax_Lov_lovPolicyType,
/* harmony export */   "ir_ajax_Lov_lovAccountCodeCombine": () => /* binding */ ir_ajax_Lov_lovAccountCodeCombine,
/* harmony export */   "ir_ajax_Lov_lovGasStationsGroups": () => /* binding */ ir_ajax_Lov_lovGasStationsGroups,
/* harmony export */   "ir_ajax_Lov_lovGroup": () => /* binding */ ir_ajax_Lov_lovGroup,
/* harmony export */   "ir_ajax_Lov_lovPolicyCategory": () => /* binding */ ir_ajax_Lov_lovPolicyCategory,
/* harmony export */   "ir_ajax_Lov_lovPolicyGroupHeaders": () => /* binding */ ir_ajax_Lov_lovPolicyGroupHeaders,
/* harmony export */   "ir_ajax_Lov_lovPremiumRate": () => /* binding */ ir_ajax_Lov_lovPremiumRate,
/* harmony export */   "ir_ajax_Lov_companiesCode": () => /* binding */ ir_ajax_Lov_companiesCode,
/* harmony export */   "ir_ajax_Lov_lovEvmCode": () => /* binding */ ir_ajax_Lov_lovEvmCode,
/* harmony export */   "ir_ajax_Lov_lovDepartmentCode": () => /* binding */ ir_ajax_Lov_lovDepartmentCode,
/* harmony export */   "ir_ajax_Lov_lovCostCenterCode": () => /* binding */ ir_ajax_Lov_lovCostCenterCode,
/* harmony export */   "ir_ajax_Lov_lovBudgetYear": () => /* binding */ ir_ajax_Lov_lovBudgetYear,
/* harmony export */   "ir_ajax_Lov_lovBudgetType": () => /* binding */ ir_ajax_Lov_lovBudgetType,
/* harmony export */   "ir_ajax_Lov_lovBudgetDetail": () => /* binding */ ir_ajax_Lov_lovBudgetDetail,
/* harmony export */   "ir_ajax_Lov_lovBudgetReason": () => /* binding */ ir_ajax_Lov_lovBudgetReason,
/* harmony export */   "ir_ajax_Lov_lovMainAccount": () => /* binding */ ir_ajax_Lov_lovMainAccount,
/* harmony export */   "ir_ajax_Lov_lovSubAccount": () => /* binding */ ir_ajax_Lov_lovSubAccount,
/* harmony export */   "ir_ajax_Lov_lovReserverd1": () => /* binding */ ir_ajax_Lov_lovReserverd1,
/* harmony export */   "ir_ajax_Lov_lovReserverd2": () => /* binding */ ir_ajax_Lov_lovReserverd2,
/* harmony export */   "ir_ajax_Lov_lovLicensePlate": () => /* binding */ ir_ajax_Lov_lovLicensePlate,
/* harmony export */   "ir_ajax_Lov_lovVehiclesType": () => /* binding */ ir_ajax_Lov_lovVehiclesType,
/* harmony export */   "ir_ajax_Lov_lovRenewType": () => /* binding */ ir_ajax_Lov_lovRenewType,
/* harmony export */   "ir_ajax_Lov_lovGasStationsType": () => /* binding */ ir_ajax_Lov_lovGasStationsType,
/* harmony export */   "ir_ajax_Lov_lovStatus": () => /* binding */ ir_ajax_Lov_lovStatus,
/* harmony export */   "ir_ajax_Lov_lovPeriods": () => /* binding */ ir_ajax_Lov_lovPeriods,
/* harmony export */   "ir_ajax_Lov_lovGroupLocation": () => /* binding */ ir_ajax_Lov_lovGroupLocation,
/* harmony export */   "ir_ajax_Lov_lovSubGroup": () => /* binding */ ir_ajax_Lov_lovSubGroup,
/* harmony export */   "ir_ajax_Lov_lovOrg": () => /* binding */ ir_ajax_Lov_lovOrg,
/* harmony export */   "ir_ajax_Lov_lovSubInventory": () => /* binding */ ir_ajax_Lov_lovSubInventory,
/* harmony export */   "ir_ajax_Lov_lovUom": () => /* binding */ ir_ajax_Lov_lovUom,
/* harmony export */   "ir_ajax_Lov_lovInvoice": () => /* binding */ ir_ajax_Lov_lovInvoice,
/* harmony export */   "ir_ajax_Lov_lovGovernerPolicyType": () => /* binding */ ir_ajax_Lov_lovGovernerPolicyType,
/* harmony export */   "ir_ajax_Lov_lovInvoiceNumber": () => /* binding */ ir_ajax_Lov_lovInvoiceNumber,
/* harmony export */   "ir_ajax_Lov_lovInterfaceType": () => /* binding */ ir_ajax_Lov_lovInterfaceType,
/* harmony export */   "ir_ajax_Lov_lovInterfaceGlType": () => /* binding */ ir_ajax_Lov_lovInterfaceGlType,
/* harmony export */   "ir_ajax_Lov_lovDepartmentLocation": () => /* binding */ ir_ajax_Lov_lovDepartmentLocation,
/* harmony export */   "ir_ajax_Lov_lovLocation": () => /* binding */ ir_ajax_Lov_lovLocation,
/* harmony export */   "ir_ajax_Lov_lovCatSegment1": () => /* binding */ ir_ajax_Lov_lovCatSegment1,
/* harmony export */   "ir_ajax_Lov_lovCatSegment3": () => /* binding */ ir_ajax_Lov_lovCatSegment3,
/* harmony export */   "ir_ajax_Lov_lovReceivableCharge": () => /* binding */ ir_ajax_Lov_lovReceivableCharge,
/* harmony export */   "ir_ajax_Lov_lovEffectiveDate": () => /* binding */ ir_ajax_Lov_lovEffectiveDate,
/* harmony export */   "ir_ajax_Lov_lovExpAssetStockType": () => /* binding */ ir_ajax_Lov_lovExpAssetStockType,
/* harmony export */   "ir_ajax_Lov_lovExpCarGasType": () => /* binding */ ir_ajax_Lov_lovExpCarGasType,
/* harmony export */   "ir_ajax_Lov_lovArInvoiceNum": () => /* binding */ ir_ajax_Lov_lovArInvoiceNum,
/* harmony export */   "ir_ajax_Lov_lovPolicyVehicle": () => /* binding */ ir_ajax_Lov_lovPolicyVehicle,
/* harmony export */   "ir_ajax_Lov_lovGroupCodePolicy": () => /* binding */ ir_ajax_Lov_lovGroupCodePolicy,
/* harmony export */   "ir_ajax_Lov_lovRevision": () => /* binding */ ir_ajax_Lov_lovRevision,
/* harmony export */   "ir_ajax_Lov_lovBudgetPeriodYear": () => /* binding */ ir_ajax_Lov_lovBudgetPeriodYear,
/* harmony export */   "ir_ajax_Lov_lovAssetStatus": () => /* binding */ ir_ajax_Lov_lovAssetStatus,
/* harmony export */   "ir_ajax_Lov_lovVehicleLicensePlate": () => /* binding */ ir_ajax_Lov_lovVehicleLicensePlate,
/* harmony export */   "ir_ajax_Lov_lovGasStationTypeMaster": () => /* binding */ ir_ajax_Lov_lovGasStationTypeMaster,
/* harmony export */   "ir_ajax_Lov_lovClaimDocumentNumber": () => /* binding */ ir_ajax_Lov_lovClaimDocumentNumber,
/* harmony export */   "ir_ajax_Lov_lovGenCompanyNumber": () => /* binding */ ir_ajax_Lov_lovGenCompanyNumber,
/* harmony export */   "ir_ajax_Lov_lovClaimPolicyNumber": () => /* binding */ ir_ajax_Lov_lovClaimPolicyNumber,
/* harmony export */   "ir_ajax_Lov_lovCompanyPercent": () => /* binding */ ir_ajax_Lov_lovCompanyPercent,
/* harmony export */   "ir_ajax_Lov_lovPolicySetHeaderGroup": () => /* binding */ ir_ajax_Lov_lovPolicySetHeaderGroup,
/* harmony export */   "ir_ajax_Lov_lovVehicleBrand": () => /* binding */ ir_ajax_Lov_lovVehicleBrand,
/* harmony export */   "ir_ajax_Lov_lovCategory4": () => /* binding */ ir_ajax_Lov_lovCategory4,
/* harmony export */   "ir_ajax_Lov_lovCategory5": () => /* binding */ ir_ajax_Lov_lovCategory5,
/* harmony export */   "ir_ajax_Lov_lovAssetGroup": () => /* binding */ ir_ajax_Lov_lovAssetGroup,
/* harmony export */   "ir_ajax_Lov_lovApInterfaceType": () => /* binding */ ir_ajax_Lov_lovApInterfaceType,
/* harmony export */   "ir_ajax_Lov_lovVehicleRate": () => /* binding */ ir_ajax_Lov_lovVehicleRate,
/* harmony export */   "ir_ajax_companyIndex": () => /* binding */ ir_ajax_companyIndex,
/* harmony export */   "ir_ajax_companyShow": () => /* binding */ ir_ajax_companyShow,
/* harmony export */   "ir_ajax_companyStore": () => /* binding */ ir_ajax_companyStore,
/* harmony export */   "ir_ajax_companyUpdate": () => /* binding */ ir_ajax_companyUpdate,
/* harmony export */   "ir_ajax_companyActiveFlag": () => /* binding */ ir_ajax_companyActiveFlag,
/* harmony export */   "ir_ajax_companyCheckUsedData": () => /* binding */ ir_ajax_companyCheckUsedData,
/* harmony export */   "ir_ajax_policyIndex": () => /* binding */ ir_ajax_policyIndex,
/* harmony export */   "ir_ajax_policyShow": () => /* binding */ ir_ajax_policyShow,
/* harmony export */   "ir_ajax_policyStore": () => /* binding */ ir_ajax_policyStore,
/* harmony export */   "ir_ajax_policyUpdate": () => /* binding */ ir_ajax_policyUpdate,
/* harmony export */   "ir_ajax_policyUpdateActiveFlag": () => /* binding */ ir_ajax_policyUpdateActiveFlag,
/* harmony export */   "ir_ajax_policyCheckUsedData": () => /* binding */ ir_ajax_policyCheckUsedData,
/* harmony export */   "ir_ajax_policyGroupHeaderIndex": () => /* binding */ ir_ajax_policyGroupHeaderIndex,
/* harmony export */   "ir_ajax_policyGroupHeaderOverlapCheck": () => /* binding */ ir_ajax_policyGroupHeaderOverlapCheck,
/* harmony export */   "ir_ajax_policyGroupHeaderShow": () => /* binding */ ir_ajax_policyGroupHeaderShow,
/* harmony export */   "ir_ajax_policyGroupHeaderGroupDists": () => /* binding */ ir_ajax_policyGroupHeaderGroupDists,
/* harmony export */   "ir_ajax_policyGroupHeaderStore": () => /* binding */ ir_ajax_policyGroupHeaderStore,
/* harmony export */   "ir_ajax_policyGroupHeaderStoreIndex": () => /* binding */ ir_ajax_policyGroupHeaderStoreIndex,
/* harmony export */   "ir_ajax_policyGroupSetDelete": () => /* binding */ ir_ajax_policyGroupSetDelete,
/* harmony export */   "ir_ajax_policyGroupHeaderUpdateActiveFlag": () => /* binding */ ir_ajax_policyGroupHeaderUpdateActiveFlag,
/* harmony export */   "ir_ajax_policyGroupHeaderDuplicateCheck": () => /* binding */ ir_ajax_policyGroupHeaderDuplicateCheck,
/* harmony export */   "ir_ajax_vehiclesIndex": () => /* binding */ ir_ajax_vehiclesIndex,
/* harmony export */   "ir_ajax_vehiclesShow": () => /* binding */ ir_ajax_vehiclesShow,
/* harmony export */   "ir_ajax_vehiclesCreateOrUpdate": () => /* binding */ ir_ajax_vehiclesCreateOrUpdate,
/* harmony export */   "ir_ajax_vehiclesActiveFlag": () => /* binding */ ir_ajax_vehiclesActiveFlag,
/* harmony export */   "ir_ajax_vehiclesUpdateActiveFlag": () => /* binding */ ir_ajax_vehiclesUpdateActiveFlag,
/* harmony export */   "ir_ajax_vehiclesReturnVatFlag": () => /* binding */ ir_ajax_vehiclesReturnVatFlag,
/* harmony export */   "ir_ajax_vehiclesUpdateReturnVatFlag": () => /* binding */ ir_ajax_vehiclesUpdateReturnVatFlag,
/* harmony export */   "ir_ajax_vehiclesDuplicateCheck": () => /* binding */ ir_ajax_vehiclesDuplicateCheck,
/* harmony export */   "ir_ajax_gasStationsIndex": () => /* binding */ ir_ajax_gasStationsIndex,
/* harmony export */   "ir_ajax_gasStationsShow": () => /* binding */ ir_ajax_gasStationsShow,
/* harmony export */   "ir_ajax_gasStationsStore": () => /* binding */ ir_ajax_gasStationsStore,
/* harmony export */   "ir_ajax_gasStationsUpdate": () => /* binding */ ir_ajax_gasStationsUpdate,
/* harmony export */   "ir_ajax_gasStationsReturnVatFlag": () => /* binding */ ir_ajax_gasStationsReturnVatFlag,
/* harmony export */   "ir_ajax_gasStationsUpdateReturnVatFlag": () => /* binding */ ir_ajax_gasStationsUpdateReturnVatFlag,
/* harmony export */   "ir_ajax_gasStationsActiveFlag": () => /* binding */ ir_ajax_gasStationsActiveFlag,
/* harmony export */   "ir_ajax_gasStationsUpdateActiveFlag": () => /* binding */ ir_ajax_gasStationsUpdateActiveFlag,
/* harmony export */   "ir_ajax_stocksIndex": () => /* binding */ ir_ajax_stocksIndex,
/* harmony export */   "ir_ajax_stocksFetch": () => /* binding */ ir_ajax_stocksFetch,
/* harmony export */   "ir_ajax_stocksShow": () => /* binding */ ir_ajax_stocksShow,
/* harmony export */   "ir_ajax_stocksCreateOrUpdate": () => /* binding */ ir_ajax_stocksCreateOrUpdate,
/* harmony export */   "ir_ajax_assetIndex": () => /* binding */ ir_ajax_assetIndex,
/* harmony export */   "ir_ajax_assetFetch": () => /* binding */ ir_ajax_assetFetch,
/* harmony export */   "ir_ajax_assetIndexAdjust": () => /* binding */ ir_ajax_assetIndexAdjust,
/* harmony export */   "ir_ajax_assetFetchAdjust": () => /* binding */ ir_ajax_assetFetchAdjust,
/* harmony export */   "ir_ajax_assetShow": () => /* binding */ ir_ajax_assetShow,
/* harmony export */   "ir_ajax_assetShowAdjust": () => /* binding */ ir_ajax_assetShowAdjust,
/* harmony export */   "ir_ajax_assetCreateOrUpdate": () => /* binding */ ir_ajax_assetCreateOrUpdate,
/* harmony export */   "ir_ajax_carsIndex": () => /* binding */ ir_ajax_carsIndex,
/* harmony export */   "ir_ajax_carsFetch": () => /* binding */ ir_ajax_carsFetch,
/* harmony export */   "ir_ajax_carsCreateOrUpdate": () => /* binding */ ir_ajax_carsCreateOrUpdate,
/* harmony export */   "ir_ajax_carsDuplicateCheck": () => /* binding */ ir_ajax_carsDuplicateCheck,
/* harmony export */   "ir_ajax_carsStatus": () => /* binding */ ir_ajax_carsStatus,
/* harmony export */   "ir_ajax_extendGasStationsIndex": () => /* binding */ ir_ajax_extendGasStationsIndex,
/* harmony export */   "ir_ajax_extendGasStationsFetch": () => /* binding */ ir_ajax_extendGasStationsFetch,
/* harmony export */   "ir_ajax_extendGasStationsCreateOrUpdate": () => /* binding */ ir_ajax_extendGasStationsCreateOrUpdate,
/* harmony export */   "ir_ajax_extendGasStationsDuplicateCheck": () => /* binding */ ir_ajax_extendGasStationsDuplicateCheck,
/* harmony export */   "ir_ajax_extendGasStationsStatus": () => /* binding */ ir_ajax_extendGasStationsStatus,
/* harmony export */   "ir_ajax_personsIndex": () => /* binding */ ir_ajax_personsIndex,
/* harmony export */   "ir_ajax_personsCreateOrUpdate": () => /* binding */ ir_ajax_personsCreateOrUpdate,
/* harmony export */   "ir_ajax_personsDuplicateCheck": () => /* binding */ ir_ajax_personsDuplicateCheck,
/* harmony export */   "ir_ajax_personsDuplicateCheckInvoiceNumber": () => /* binding */ ir_ajax_personsDuplicateCheckInvoiceNumber,
/* harmony export */   "ir_ajax_personsStatus": () => /* binding */ ir_ajax_personsStatus,
/* harmony export */   "ir_ajax_expenseAssetStockIndex": () => /* binding */ ir_ajax_expenseAssetStockIndex,
/* harmony export */   "ir_ajax_expenseAssetStockStore": () => /* binding */ ir_ajax_expenseAssetStockStore,
/* harmony export */   "ir_ajax_expenseCarGasIndex": () => /* binding */ ir_ajax_expenseCarGasIndex,
/* harmony export */   "ir_ajax_expenseCarGasStore": () => /* binding */ ir_ajax_expenseCarGasStore,
/* harmony export */   "ir_ajax_claimIndex": () => /* binding */ ir_ajax_claimIndex,
/* harmony export */   "ir_ajax_claimShow": () => /* binding */ ir_ajax_claimShow,
/* harmony export */   "ir_ajax_claimCreateOrUpdate": () => /* binding */ ir_ajax_claimCreateOrUpdate,
/* harmony export */   "ir_ajax_claimDelete": () => /* binding */ ir_ajax_claimDelete,
/* harmony export */   "ir_ajax_claimDeleteCompany": () => /* binding */ ir_ajax_claimDeleteCompany,
/* harmony export */   "ir_ajax_claimUpload": () => /* binding */ ir_ajax_claimUpload,
/* harmony export */   "ir_ajax_claimDeleteFile": () => /* binding */ ir_ajax_claimDeleteFile,
/* harmony export */   "ir_ajax_confirmApInterface": () => /* binding */ ir_ajax_confirmApInterface,
/* harmony export */   "ir_ajax_confirmApCancel": () => /* binding */ ir_ajax_confirmApCancel,
/* harmony export */   "ir_ajax_confirmGlInterface": () => /* binding */ ir_ajax_confirmGlInterface,
/* harmony export */   "ir_ajax_confirmGlCancel": () => /* binding */ ir_ajax_confirmGlCancel,
/* harmony export */   "ir_ajax_confirmArInterface": () => /* binding */ ir_ajax_confirmArInterface,
/* harmony export */   "ir_ajax_confirmArCancel": () => /* binding */ ir_ajax_confirmArCancel,
/* harmony export */   "ir_ajax_accountMapping_index": () => /* binding */ ir_ajax_accountMapping_index,
/* harmony export */   "ir_ajax_validateCombination": () => /* binding */ ir_ajax_validateCombination,
/* harmony export */   "ir_ajax_showAccountMapping": () => /* binding */ ir_ajax_showAccountMapping,
/* harmony export */   "ir_ajax_companiesCode": () => /* binding */ ir_ajax_companiesCode,
/* harmony export */   "ir_ajax_evmCode": () => /* binding */ ir_ajax_evmCode,
/* harmony export */   "ir_ajax_departmentCode": () => /* binding */ ir_ajax_departmentCode,
/* harmony export */   "ir_ajax_costcenterCode": () => /* binding */ ir_ajax_costcenterCode,
/* harmony export */   "ir_ajax_budgetYear": () => /* binding */ ir_ajax_budgetYear,
/* harmony export */   "ir_ajax_budgetType": () => /* binding */ ir_ajax_budgetType,
/* harmony export */   "ir_ajax_budgetDetail": () => /* binding */ ir_ajax_budgetDetail,
/* harmony export */   "ir_ajax_budgetReason": () => /* binding */ ir_ajax_budgetReason,
/* harmony export */   "ir_ajax_mainAccount": () => /* binding */ ir_ajax_mainAccount,
/* harmony export */   "ir_ajax_subAccount": () => /* binding */ ir_ajax_subAccount,
/* harmony export */   "ir_ajax_reserverd1": () => /* binding */ ir_ajax_reserverd1,
/* harmony export */   "ir_ajax_reserverd2": () => /* binding */ ir_ajax_reserverd2,
/* harmony export */   "ir_ajax_codeCombineLov": () => /* binding */ ir_ajax_codeCombineLov,
/* harmony export */   "ir_ajax_accountDesc": () => /* binding */ ir_ajax_accountDesc,
/* harmony export */   "ir_ajax_vehiclesLovLicensePlate": () => /* binding */ ir_ajax_vehiclesLovLicensePlate,
/* harmony export */   "ir_ajax_vehiclesLovType": () => /* binding */ ir_ajax_vehiclesLovType,
/* harmony export */   "ir_ajax_vehiclesUpdateOrCreate": () => /* binding */ ir_ajax_vehiclesUpdateOrCreate,
/* harmony export */   "ir_ajax_lookupGasStationsLovType": () => /* binding */ ir_ajax_lookupGasStationsLovType,
/* harmony export */   "ir_ajax_lookupGasStationsLovGroups": () => /* binding */ ir_ajax_lookupGasStationsLovGroups,
/* harmony export */   "ir_ajax_irReportGetInfo": () => /* binding */ ir_ajax_irReportGetInfo,
/* harmony export */   "report_ajax_reportGetInfo": () => /* binding */ report_ajax_reportGetInfo,
/* harmony export */   "ir_ajax_irReportGetInfoAttribute": () => /* binding */ ir_ajax_irReportGetInfoAttribute,
/* harmony export */   "report_ajax_reportGetInfoAttribute": () => /* binding */ report_ajax_reportGetInfoAttribute,
/* harmony export */   "ir_ajax_irReportSubmit": () => /* binding */ ir_ajax_irReportSubmit,
/* harmony export */   "report_ajax_irReportSubmit": () => /* binding */ report_ajax_irReportSubmit,
/* harmony export */   "ir_settings_storeAccountMapping": () => /* binding */ ir_settings_storeAccountMapping,
/* harmony export */   "ir_settings_updateAccountMapping": () => /* binding */ ir_settings_updateAccountMapping,
/* harmony export */   "ir_settings_policy_index": () => /* binding */ ir_settings_policy_index,
/* harmony export */   "ir_settings_policies_index": () => /* binding */ ir_settings_policies_index,
/* harmony export */   "ir_settings_policy_create": () => /* binding */ ir_settings_policy_create,
/* harmony export */   "ir_settings_policies_create": () => /* binding */ ir_settings_policies_create,
/* harmony export */   "ir_settings_policy_edit": () => /* binding */ ir_settings_policy_edit,
/* harmony export */   "ir_settings_policies_edit": () => /* binding */ ir_settings_policies_edit,
/* harmony export */   "ir_settings_vehicle_index": () => /* binding */ ir_settings_vehicle_index,
/* harmony export */   "ir_settings_vehicle_create": () => /* binding */ ir_settings_vehicle_create,
/* harmony export */   "ir_settings_vehicle_edit": () => /* binding */ ir_settings_vehicle_edit,
/* harmony export */   "ir_settings_gasStations_index": () => /* binding */ ir_settings_gasStations_index,
/* harmony export */   "ir_gasStations_gasStation_index": () => /* binding */ ir_gasStations_gasStation_index,
/* harmony export */   "ir_settings_gasStations_create": () => /* binding */ ir_settings_gasStations_create,
/* harmony export */   "ir_settings_gasStations_edit": () => /* binding */ ir_settings_gasStations_edit,
/* harmony export */   "ir_settings_policyGroup_index": () => /* binding */ ir_settings_policyGroup_index,
/* harmony export */   "ir_settings_policyGroup_edit": () => /* binding */ ir_settings_policyGroup_edit,
/* harmony export */   "ir_settings_irp0008_index": () => /* binding */ ir_settings_irp0008_index,
/* harmony export */   "ir_expenseStockAsset_index": () => /* binding */ ir_expenseStockAsset_index,
/* harmony export */   "ir_settings_reportInfo_index": () => /* binding */ ir_settings_reportInfo_index,
/* harmony export */   "report_reportInfo_reportInfo_index": () => /* binding */ report_reportInfo_reportInfo_index,
/* harmony export */   "ir_settings_reportInfo_show": () => /* binding */ ir_settings_reportInfo_show,
/* harmony export */   "report_reportInfo_reportInfo_show": () => /* binding */ report_reportInfo_reportInfo_show,
/* harmony export */   "ir_settings_reportInfo_store": () => /* binding */ ir_settings_reportInfo_store,
/* harmony export */   "report_reportInfo_reportInfo_store": () => /* binding */ report_reportInfo_reportInfo_store,
/* harmony export */   "ir_settings_reportInfo_update": () => /* binding */ ir_settings_reportInfo_update,
/* harmony export */   "report_reportInfo_reportInfo_update": () => /* binding */ report_reportInfo_reportInfo_update,
/* harmony export */   "ir_settings_reportInfo_destroy": () => /* binding */ ir_settings_reportInfo_destroy,
/* harmony export */   "report_reportInfo_reportInfo_destroy": () => /* binding */ report_reportInfo_reportInfo_destroy,
/* harmony export */   "ir_settings_company_index": () => /* binding */ ir_settings_company_index,
/* harmony export */   "ir_settings_company_create": () => /* binding */ ir_settings_company_create,
/* harmony export */   "ir_settings_company_edit": () => /* binding */ ir_settings_company_edit,
/* harmony export */   "ir_settings_gasStation_index": () => /* binding */ ir_settings_gasStation_index,
/* harmony export */   "ir_settings_accountMapping_index": () => /* binding */ ir_settings_accountMapping_index,
/* harmony export */   "ir_settings_accountMapping_create": () => /* binding */ ir_settings_accountMapping_create,
/* harmony export */   "ir_settings_accountMapping_store": () => /* binding */ ir_settings_accountMapping_store,
/* harmony export */   "ir_settings_accountMapping_show": () => /* binding */ ir_settings_accountMapping_show,
/* harmony export */   "ir_settings_accountMapping_edit": () => /* binding */ ir_settings_accountMapping_edit,
/* harmony export */   "ir_settings_accountMapping_update": () => /* binding */ ir_settings_accountMapping_update,
/* harmony export */   "ir_settings_accountMapping_destroy": () => /* binding */ ir_settings_accountMapping_destroy,
/* harmony export */   "ir_settings_gasStation_create": () => /* binding */ ir_settings_gasStation_create,
/* harmony export */   "ir_settings_gasStation_edit": () => /* binding */ ir_settings_gasStation_edit,
/* harmony export */   "ir_stocks_yearly_index": () => /* binding */ ir_stocks_yearly_index,
/* harmony export */   "ir_stocks_yearly_edit": () => /* binding */ ir_stocks_yearly_edit,
/* harmony export */   "ir_stocks_monthly_index": () => /* binding */ ir_stocks_monthly_index,
/* harmony export */   "ir_stocks_monthly_edit": () => /* binding */ ir_stocks_monthly_edit,
/* harmony export */   "ir_assets_assetPlan_index": () => /* binding */ ir_assets_assetPlan_index,
/* harmony export */   "ir_assets_assetPlan_edit": () => /* binding */ ir_assets_assetPlan_edit,
/* harmony export */   "ir_assets_assetIncrease_index": () => /* binding */ ir_assets_assetIncrease_index,
/* harmony export */   "ir_assets_assetIncrease_edit": () => /* binding */ ir_assets_assetIncrease_edit,
/* harmony export */   "ir_cars_car_index": () => /* binding */ ir_cars_car_index,
/* harmony export */   "ir_governors_governor_index": () => /* binding */ ir_governors_governor_index,
/* harmony export */   "ir_calculateInsurance_index": () => /* binding */ ir_calculateInsurance_index,
/* harmony export */   "ir_calculateInsurance_report": () => /* binding */ ir_calculateInsurance_report,
/* harmony export */   "ir_calculateInsurance_interface": () => /* binding */ ir_calculateInsurance_interface,
/* harmony export */   "ir_calculateInsurance_cancel": () => /* binding */ ir_calculateInsurance_cancel,
/* harmony export */   "ir_expenseCarGas_index": () => /* binding */ ir_expenseCarGas_index,
/* harmony export */   "ir_claimInsurance_index": () => /* binding */ ir_claimInsurance_index,
/* harmony export */   "ir_claimInsurance_create": () => /* binding */ ir_claimInsurance_create,
/* harmony export */   "ir_claimInsurance_edit": () => /* binding */ ir_claimInsurance_edit,
/* harmony export */   "ir_confirmToAp_index": () => /* binding */ ir_confirmToAp_index,
/* harmony export */   "ir_confirmToGl_index": () => /* binding */ ir_confirmToGl_index,
/* harmony export */   "ir_confirmToAr_index": () => /* binding */ ir_confirmToAr_index,
/* harmony export */   "ir_report_export": () => /* binding */ ir_report_export,
/* harmony export */   "ir_report_index": () => /* binding */ ir_report_index,
/* harmony export */   "ir_report_getParam": () => /* binding */ ir_report_getParam,
/* harmony export */   "ie_ajax_icon_index": () => /* binding */ ie_ajax_icon_index,
/* harmony export */   "ie_cashAdvances_getSuppliers": () => /* binding */ ie_cashAdvances_getSuppliers,
/* harmony export */   "ie_cashAdvances_getSupplierSites": () => /* binding */ ie_cashAdvances_getSupplierSites,
/* harmony export */   "ie_cashAdvances_getRequesterData": () => /* binding */ ie_cashAdvances_getRequesterData,
/* harmony export */   "ie_cashAdvances_indexPending": () => /* binding */ ie_cashAdvances_indexPending,
/* harmony export */   "ie_cashAdvances_getSubCategories": () => /* binding */ ie_cashAdvances_getSubCategories,
/* harmony export */   "ie_cashAdvances_getFormInformations": () => /* binding */ ie_cashAdvances_getFormInformations,
/* harmony export */   "ie_cashAdvances_index": () => /* binding */ ie_cashAdvances_index,
/* harmony export */   "ie_cashAdvances_create": () => /* binding */ ie_cashAdvances_create,
/* harmony export */   "ie_cashAdvances_show": () => /* binding */ ie_cashAdvances_show,
/* harmony export */   "ie_cashAdvances_update": () => /* binding */ ie_cashAdvances_update,
/* harmony export */   "ie_cashAdvances_store": () => /* binding */ ie_cashAdvances_store,
/* harmony export */   "ie_cashAdvances_export": () => /* binding */ ie_cashAdvances_export,
/* harmony export */   "ie_cashAdvances_updateCl": () => /* binding */ ie_cashAdvances_updateCl,
/* harmony export */   "ie_cashAdvances_formEdit": () => /* binding */ ie_cashAdvances_formEdit,
/* harmony export */   "ie_cashAdvances_formEditCl": () => /* binding */ ie_cashAdvances_formEditCl,
/* harmony export */   "ie_cashAdvances_report": () => /* binding */ ie_cashAdvances_report,
/* harmony export */   "ie_cashAdvances_getTotalAmount": () => /* binding */ ie_cashAdvances_getTotalAmount,
/* harmony export */   "ie_cashAdvances_updateDff": () => /* binding */ ie_cashAdvances_updateDff,
/* harmony export */   "ie_cashAdvances_changeApprover": () => /* binding */ ie_cashAdvances_changeApprover,
/* harmony export */   "ie_cashAdvances_setStatus": () => /* binding */ ie_cashAdvances_setStatus,
/* harmony export */   "ie_cashAdvances_addAttachment": () => /* binding */ ie_cashAdvances_addAttachment,
/* harmony export */   "ie_cashAdvances_setDueDate": () => /* binding */ ie_cashAdvances_setDueDate,
/* harmony export */   "ie_cashAdvances_getDiffCaAndClearingAmount": () => /* binding */ ie_cashAdvances_getDiffCaAndClearingAmount,
/* harmony export */   "ie_cashAdvances_getDiffCaAndClearingData": () => /* binding */ ie_cashAdvances_getDiffCaAndClearingData,
/* harmony export */   "ie_cashAdvances_duplicate": () => /* binding */ ie_cashAdvances_duplicate,
/* harmony export */   "ie_cashAdvances_clearRequest": () => /* binding */ ie_cashAdvances_clearRequest,
/* harmony export */   "ie_cashAdvances_clear": () => /* binding */ ie_cashAdvances_clear,
/* harmony export */   "ie_cashAdvances_checkCaAttachment": () => /* binding */ ie_cashAdvances_checkCaAttachment,
/* harmony export */   "ie_cashAdvances_checkCaMinAmount": () => /* binding */ ie_cashAdvances_checkCaMinAmount,
/* harmony export */   "ie_cashAdvances_checkCaMaxAmount": () => /* binding */ ie_cashAdvances_checkCaMaxAmount,
/* harmony export */   "ie_cashAdvances_combineReceiptGlCodeCombination": () => /* binding */ ie_cashAdvances_combineReceiptGlCodeCombination,
/* harmony export */   "ie_cashAdvances_checkOverBudget": () => /* binding */ ie_cashAdvances_checkOverBudget,
/* harmony export */   "ie_cashAdvances_checkExceedPolicy": () => /* binding */ ie_cashAdvances_checkExceedPolicy,
/* harmony export */   "ie_cashAdvances_validateReceipt": () => /* binding */ ie_cashAdvances_validateReceipt,
/* harmony export */   "ie_cashAdvances_formSendRequestWithReason": () => /* binding */ ie_cashAdvances_formSendRequestWithReason,
/* harmony export */   "ie_reimbursements_getSuppliers": () => /* binding */ ie_reimbursements_getSuppliers,
/* harmony export */   "ie_reimbursements_getSupplierSites": () => /* binding */ ie_reimbursements_getSupplierSites,
/* harmony export */   "ie_reimbursements_getRequesterData": () => /* binding */ ie_reimbursements_getRequesterData,
/* harmony export */   "ie_reimbursements_indexPending": () => /* binding */ ie_reimbursements_indexPending,
/* harmony export */   "ie_reimbursements_index": () => /* binding */ ie_reimbursements_index,
/* harmony export */   "ie_reimbursements_create": () => /* binding */ ie_reimbursements_create,
/* harmony export */   "ie_reimbursements_show": () => /* binding */ ie_reimbursements_show,
/* harmony export */   "ie_reimbursements_update": () => /* binding */ ie_reimbursements_update,
/* harmony export */   "ie_reimbursements_store": () => /* binding */ ie_reimbursements_store,
/* harmony export */   "ie_reimbursements_export": () => /* binding */ ie_reimbursements_export,
/* harmony export */   "ie_reimbursements_formEdit": () => /* binding */ ie_reimbursements_formEdit,
/* harmony export */   "ie_reimbursements_getTotalAmount": () => /* binding */ ie_reimbursements_getTotalAmount,
/* harmony export */   "ie_reimbursements_updateDff": () => /* binding */ ie_reimbursements_updateDff,
/* harmony export */   "ie_reimbursements_changeApprover": () => /* binding */ ie_reimbursements_changeApprover,
/* harmony export */   "ie_reimbursements_setStatus": () => /* binding */ ie_reimbursements_setStatus,
/* harmony export */   "ie_reimbursements_addAttachment": () => /* binding */ ie_reimbursements_addAttachment,
/* harmony export */   "ie_reimbursements_setDueDate": () => /* binding */ ie_reimbursements_setDueDate,
/* harmony export */   "ie_reimbursements_duplicate": () => /* binding */ ie_reimbursements_duplicate,
/* harmony export */   "ie_reimbursements_combineReceiptGlCodeCombination": () => /* binding */ ie_reimbursements_combineReceiptGlCodeCombination,
/* harmony export */   "ie_reimbursements_checkOverBudget": () => /* binding */ ie_reimbursements_checkOverBudget,
/* harmony export */   "ie_reimbursements_checkExceedPolicy": () => /* binding */ ie_reimbursements_checkExceedPolicy,
/* harmony export */   "ie_reimbursements_validateReceipt": () => /* binding */ ie_reimbursements_validateReceipt,
/* harmony export */   "ie_reimbursements_formSendRequestWithReason": () => /* binding */ ie_reimbursements_formSendRequestWithReason,
/* harmony export */   "ie_receipts_getInvTobacco": () => /* binding */ ie_receipts_getInvTobacco,
/* harmony export */   "ie_receipts_getVendorSites": () => /* binding */ ie_receipts_getVendorSites,
/* harmony export */   "ie_receipts_getVendorDetail": () => /* binding */ ie_receipts_getVendorDetail,
/* harmony export */   "ie_receipts_getRows": () => /* binding */ ie_receipts_getRows,
/* harmony export */   "ie_receipts_getTableTotalRows": () => /* binding */ ie_receipts_getTableTotalRows,
/* harmony export */   "ie_receipts_formCreate": () => /* binding */ ie_receipts_formCreate,
/* harmony export */   "ie_receipts_indexPending": () => /* binding */ ie_receipts_indexPending,
/* harmony export */   "ie_receipts_create": () => /* binding */ ie_receipts_create,
/* harmony export */   "ie_receipts_show": () => /* binding */ ie_receipts_show,
/* harmony export */   "ie_receipts_update": () => /* binding */ ie_receipts_update,
/* harmony export */   "ie_receipts_store": () => /* binding */ ie_receipts_store,
/* harmony export */   "ie_receipts_export": () => /* binding */ ie_receipts_export,
/* harmony export */   "ie_receipts_setStatus": () => /* binding */ ie_receipts_setStatus,
/* harmony export */   "ie_receipts_addAttachment": () => /* binding */ ie_receipts_addAttachment,
/* harmony export */   "ie_receipts_formEdit": () => /* binding */ ie_receipts_formEdit,
/* harmony export */   "ie_receipts_duplicate": () => /* binding */ ie_receipts_duplicate,
/* harmony export */   "ie_receipts_remove": () => /* binding */ ie_receipts_remove,
/* harmony export */   "ie_receipts_lines_store": () => /* binding */ ie_receipts_lines_store,
/* harmony export */   "ie_receipts_lines_update": () => /* binding */ ie_receipts_lines_update,
/* harmony export */   "ie_receipts_lines_updateCoa": () => /* binding */ ie_receipts_lines_updateCoa,
/* harmony export */   "ie_receipts_lines_updateDff": () => /* binding */ ie_receipts_lines_updateDff,
/* harmony export */   "ie_receipts_lines_duplicate": () => /* binding */ ie_receipts_lines_duplicate,
/* harmony export */   "ie_receipts_lines_remove": () => /* binding */ ie_receipts_lines_remove,
/* harmony export */   "ie_receipts_lines_getShowInfos": () => /* binding */ ie_receipts_lines_getShowInfos,
/* harmony export */   "ie_receipts_lines_formCreate": () => /* binding */ ie_receipts_lines_formCreate,
/* harmony export */   "ie_receipts_lines_getSubCategories": () => /* binding */ ie_receipts_lines_getSubCategories,
/* harmony export */   "ie_receipts_lines_subCategory_getFormInformations": () => /* binding */ ie_receipts_lines_subCategory_getFormInformations,
/* harmony export */   "ie_receipts_lines_subCategory_getFormAmount": () => /* binding */ ie_receipts_lines_subCategory_getFormAmount,
/* harmony export */   "ie_receipts_lines_formCoa": () => /* binding */ ie_receipts_lines_formCoa,
/* harmony export */   "ie_receipts_lines_inputCostCenterCode": () => /* binding */ ie_receipts_lines_inputCostCenterCode,
/* harmony export */   "ie_settings_inputCostCenterCode": () => /* binding */ ie_settings_inputCostCenterCode,
/* harmony export */   "ie_receipts_lines_inputBudgetDetailCode": () => /* binding */ ie_receipts_lines_inputBudgetDetailCode,
/* harmony export */   "ie_settings_inputBudgetDetailCode": () => /* binding */ ie_settings_inputBudgetDetailCode,
/* harmony export */   "ie_receipts_lines_inputSubAccountCode": () => /* binding */ ie_receipts_lines_inputSubAccountCode,
/* harmony export */   "ie_settings_inputSubAccountCode": () => /* binding */ ie_settings_inputSubAccountCode,
/* harmony export */   "ie_receipts_lines_validateCombination": () => /* binding */ ie_receipts_lines_validateCombination,
/* harmony export */   "ie_receipts_lines_formEdit": () => /* binding */ ie_receipts_lines_formEdit,
/* harmony export */   "ie_receipts_lines_getFormEditInformations": () => /* binding */ ie_receipts_lines_getFormEditInformations,
/* harmony export */   "ie_receipts_lines_getFormEditAmount": () => /* binding */ ie_receipts_lines_getFormEditAmount,
/* harmony export */   "ie_dff_getForm": () => /* binding */ ie_dff_getForm,
/* harmony export */   "ie_dff_getFormHeader": () => /* binding */ ie_dff_getFormHeader,
/* harmony export */   "ie_dff_getFormLine": () => /* binding */ ie_dff_getFormLine,
/* harmony export */   "ie_attachments_download": () => /* binding */ ie_attachments_download,
/* harmony export */   "ie_attachments_image": () => /* binding */ ie_attachments_image,
/* harmony export */   "ie_attachments_imageModal": () => /* binding */ ie_attachments_imageModal,
/* harmony export */   "ie_attachments_remove": () => /* binding */ ie_attachments_remove,
/* harmony export */   "ie_settings_locations_index": () => /* binding */ ie_settings_locations_index,
/* harmony export */   "ie_settings_locations_create": () => /* binding */ ie_settings_locations_create,
/* harmony export */   "ie_settings_locations_edit": () => /* binding */ ie_settings_locations_edit,
/* harmony export */   "ie_settings_locations_update": () => /* binding */ ie_settings_locations_update,
/* harmony export */   "ie_settings_categories_index": () => /* binding */ ie_settings_categories_index,
/* harmony export */   "ie_settings_categories_create": () => /* binding */ ie_settings_categories_create,
/* harmony export */   "ie_settings_categories_store": () => /* binding */ ie_settings_categories_store,
/* harmony export */   "ie_settings_categories_edit": () => /* binding */ ie_settings_categories_edit,
/* harmony export */   "ie_settings_categories_update": () => /* binding */ ie_settings_categories_update,
/* harmony export */   "ie_settings_categories_remove": () => /* binding */ ie_settings_categories_remove,
/* harmony export */   "ie_settings_validateCombination": () => /* binding */ ie_settings_validateCombination,
/* harmony export */   "ie_settings_formSetAccount": () => /* binding */ ie_settings_formSetAccount,
/* harmony export */   "ie_settings_subCategories_index": () => /* binding */ ie_settings_subCategories_index,
/* harmony export */   "ie_settings_subCategories_create": () => /* binding */ ie_settings_subCategories_create,
/* harmony export */   "ie_settings_subCategories_store": () => /* binding */ ie_settings_subCategories_store,
/* harmony export */   "ie_settings_subCategories_show": () => /* binding */ ie_settings_subCategories_show,
/* harmony export */   "ie_settings_subCategories_edit": () => /* binding */ ie_settings_subCategories_edit,
/* harmony export */   "ie_settings_subCategories_update": () => /* binding */ ie_settings_subCategories_update,
/* harmony export */   "ie_settings_subCategories_destroy": () => /* binding */ ie_settings_subCategories_destroy,
/* harmony export */   "ie_settings_subCategories_infos_index": () => /* binding */ ie_settings_subCategories_infos_index,
/* harmony export */   "ie_settings_subCategories_infos_create": () => /* binding */ ie_settings_subCategories_infos_create,
/* harmony export */   "ie_settings_subCategories_infos_store": () => /* binding */ ie_settings_subCategories_infos_store,
/* harmony export */   "ie_settings_subCategories_infos_show": () => /* binding */ ie_settings_subCategories_infos_show,
/* harmony export */   "ie_settings_subCategories_infos_edit": () => /* binding */ ie_settings_subCategories_infos_edit,
/* harmony export */   "ie_settings_subCategories_infos_update": () => /* binding */ ie_settings_subCategories_infos_update,
/* harmony export */   "ie_settings_subCategories_infos_destroy": () => /* binding */ ie_settings_subCategories_infos_destroy,
/* harmony export */   "ie_settings_subCategories_inputFormType": () => /* binding */ ie_settings_subCategories_inputFormType,
/* harmony export */   "ie_settings_subCategories_infos_inactive": () => /* binding */ ie_settings_subCategories_infos_inactive,
/* harmony export */   "ie_settings_policies_index": () => /* binding */ ie_settings_policies_index,
/* harmony export */   "ie_settings_policies_create": () => /* binding */ ie_settings_policies_create,
/* harmony export */   "ie_settings_policies_store": () => /* binding */ ie_settings_policies_store,
/* harmony export */   "ie_settings_policies_inactive": () => /* binding */ ie_settings_policies_inactive,
/* harmony export */   "ie_settings_policies_rates_index": () => /* binding */ ie_settings_policies_rates_index,
/* harmony export */   "ie_settings_policies_rates_create": () => /* binding */ ie_settings_policies_rates_create,
/* harmony export */   "ie_settings_policies_rates_store": () => /* binding */ ie_settings_policies_rates_store,
/* harmony export */   "ie_settings_policies_rates_show": () => /* binding */ ie_settings_policies_rates_show,
/* harmony export */   "ie_settings_policies_rates_edit": () => /* binding */ ie_settings_policies_rates_edit,
/* harmony export */   "ie_settings_policies_rates_update": () => /* binding */ ie_settings_policies_rates_update,
/* harmony export */   "ie_settings_policies_rates_destroy": () => /* binding */ ie_settings_policies_rates_destroy,
/* harmony export */   "ie_settings_policies_rates_inactive": () => /* binding */ ie_settings_policies_rates_inactive,
/* harmony export */   "ie_settings_caCategories_index": () => /* binding */ ie_settings_caCategories_index,
/* harmony export */   "ie_settings_caCategories_create": () => /* binding */ ie_settings_caCategories_create,
/* harmony export */   "ie_settings_caCategories_store": () => /* binding */ ie_settings_caCategories_store,
/* harmony export */   "ie_settings_caCategories_edit": () => /* binding */ ie_settings_caCategories_edit,
/* harmony export */   "ie_settings_caCategories_update": () => /* binding */ ie_settings_caCategories_update,
/* harmony export */   "ie_settings_caCategories_remove": () => /* binding */ ie_settings_caCategories_remove,
/* harmony export */   "ie_settings_caSubCategories_index": () => /* binding */ ie_settings_caSubCategories_index,
/* harmony export */   "ie_settings_caSubCategories_create": () => /* binding */ ie_settings_caSubCategories_create,
/* harmony export */   "ie_settings_caSubCategories_store": () => /* binding */ ie_settings_caSubCategories_store,
/* harmony export */   "ie_settings_caSubCategories_show": () => /* binding */ ie_settings_caSubCategories_show,
/* harmony export */   "ie_settings_caSubCategories_edit": () => /* binding */ ie_settings_caSubCategories_edit,
/* harmony export */   "ie_settings_caSubCategories_update": () => /* binding */ ie_settings_caSubCategories_update,
/* harmony export */   "ie_settings_caSubCategories_destroy": () => /* binding */ ie_settings_caSubCategories_destroy,
/* harmony export */   "ie_settings_caSubCategories_infos_index": () => /* binding */ ie_settings_caSubCategories_infos_index,
/* harmony export */   "ie_settings_caSubCategories_infos_create": () => /* binding */ ie_settings_caSubCategories_infos_create,
/* harmony export */   "ie_settings_caSubCategories_infos_store": () => /* binding */ ie_settings_caSubCategories_infos_store,
/* harmony export */   "ie_settings_caSubCategories_infos_show": () => /* binding */ ie_settings_caSubCategories_infos_show,
/* harmony export */   "ie_settings_caSubCategories_infos_edit": () => /* binding */ ie_settings_caSubCategories_infos_edit,
/* harmony export */   "ie_settings_caSubCategories_infos_update": () => /* binding */ ie_settings_caSubCategories_infos_update,
/* harmony export */   "ie_settings_caSubCategories_infos_destroy": () => /* binding */ ie_settings_caSubCategories_infos_destroy,
/* harmony export */   "ie_settings_caSubCategories_inputFormType": () => /* binding */ ie_settings_caSubCategories_inputFormType,
/* harmony export */   "ie_settings_caSubCategories_infos_inactive": () => /* binding */ ie_settings_caSubCategories_infos_inactive,
/* harmony export */   "ie_settings_preferences_index": () => /* binding */ ie_settings_preferences_index,
/* harmony export */   "ie_settings_preferences_update": () => /* binding */ ie_settings_preferences_update,
/* harmony export */   "ie_settings_preferences_updateMappingOus": () => /* binding */ ie_settings_preferences_updateMappingOus,
/* harmony export */   "ie_settings_preferences_sliceJson": () => /* binding */ ie_settings_preferences_sliceJson,
/* harmony export */   "ie_settings_userAccounts_index": () => /* binding */ ie_settings_userAccounts_index,
/* harmony export */   "ie_settings_userAccounts_store": () => /* binding */ ie_settings_userAccounts_store,
/* harmony export */   "ie_settings_userAccounts_update": () => /* binding */ ie_settings_userAccounts_update,
/* harmony export */   "ie_settings_userAccounts_destroy": () => /* binding */ ie_settings_userAccounts_destroy,
/* harmony export */   "ie_settings_userAccounts_formEdit": () => /* binding */ ie_settings_userAccounts_formEdit,
/* harmony export */   "ie_settings_userAccounts_sync": () => /* binding */ ie_settings_userAccounts_sync,
/* harmony export */   "ie_report_index": () => /* binding */ ie_report_index,
/* harmony export */   "ie_report_ctInvoice": () => /* binding */ ie_report_ctInvoice,
/* harmony export */   "ie_report_ctWht": () => /* binding */ ie_report_ctWht,
/* harmony export */   "ie_report_request": () => /* binding */ ie_report_request,
/* harmony export */   "inv_requisitionStationery_summaryWebStationeryPdf": () => /* binding */ inv_requisitionStationery_summaryWebStationeryPdf,
/* harmony export */   "inv_requisitionStationery_orderHistoryPdf": () => /* binding */ inv_requisitionStationery_orderHistoryPdf,
/* harmony export */   "inv_requisitionStationery_summaryWebStationeryReport": () => /* binding */ inv_requisitionStationery_summaryWebStationeryReport,
/* harmony export */   "inv_requisitionStationery_orderHistoryReport": () => /* binding */ inv_requisitionStationery_orderHistoryReport,
/* harmony export */   "inv_requisitionStationery_copy": () => /* binding */ inv_requisitionStationery_copy,
/* harmony export */   "inv_requisitionStationery_approve": () => /* binding */ inv_requisitionStationery_approve,
/* harmony export */   "inv_requisitionStationery_cancel": () => /* binding */ inv_requisitionStationery_cancel,
/* harmony export */   "inv_requisitionStationery_index": () => /* binding */ inv_requisitionStationery_index,
/* harmony export */   "inv_requisitionStationery_create": () => /* binding */ inv_requisitionStationery_create,
/* harmony export */   "inv_requisitionStationery_store": () => /* binding */ inv_requisitionStationery_store,
/* harmony export */   "inv_requisitionStationery_show": () => /* binding */ inv_requisitionStationery_show,
/* harmony export */   "inv_requisitionStationery_edit": () => /* binding */ inv_requisitionStationery_edit,
/* harmony export */   "inv_requisitionStationery_update": () => /* binding */ inv_requisitionStationery_update,
/* harmony export */   "inv_issueApproveDetail_index": () => /* binding */ inv_issueApproveDetail_index,
/* harmony export */   "inv_issueApproveDetail_store": () => /* binding */ inv_issueApproveDetail_store,
/* harmony export */   "inv_disbursementFuel_updateCarInterface": () => /* binding */ inv_disbursementFuel_updateCarInterface,
/* harmony export */   "inv_disbursementFuel_addNewCar": () => /* binding */ inv_disbursementFuel_addNewCar,
/* harmony export */   "inv_disbursementFuel_report": () => /* binding */ inv_disbursementFuel_report,
/* harmony export */   "inv_disbursementFuel_show": () => /* binding */ inv_disbursementFuel_show,
/* harmony export */   "inv_disbursementFuel_index": () => /* binding */ inv_disbursementFuel_index,
/* harmony export */   "inv_disbursementFuel_create": () => /* binding */ inv_disbursementFuel_create,
/* harmony export */   "inv_disbursementFuel_store": () => /* binding */ inv_disbursementFuel_store,
/* harmony export */   "inv_disbursementFuel_edit": () => /* binding */ inv_disbursementFuel_edit,
/* harmony export */   "inv_disbursementFuel_update": () => /* binding */ inv_disbursementFuel_update,
/* harmony export */   "inv_ajax_issueHeader": () => /* binding */ inv_ajax_issueHeader,
/* harmony export */   "inv_ajax_issueProfileV": () => /* binding */ inv_ajax_issueProfileV,
/* harmony export */   "inv_ajax_coaDeptCode": () => /* binding */ inv_ajax_coaDeptCode,
/* harmony export */   "inv_ajax_subinventory": () => /* binding */ inv_ajax_subinventory,
/* harmony export */   "inv_ajax_secondaryInventories": () => /* binding */ inv_ajax_secondaryInventories,
/* harmony export */   "inv_ajax_aliasName": () => /* binding */ inv_ajax_aliasName,
/* harmony export */   "inv_ajax_systemItem": () => /* binding */ inv_ajax_systemItem,
/* harmony export */   "inv_ajax_carInfo": () => /* binding */ inv_ajax_carInfo,
/* harmony export */   "inv_ajax_carHistory": () => /* binding */ inv_ajax_carHistory,
/* harmony export */   "inv_ajax_glCodeCombinations": () => /* binding */ inv_ajax_glCodeCombinations,
/* harmony export */   "inv_ajax_webFuelDist": () => /* binding */ inv_ajax_webFuelDist,
/* harmony export */   "inv_ajax_webFuelOil": () => /* binding */ inv_ajax_webFuelOil,
/* harmony export */   "inv_ajax_itemLocations": () => /* binding */ inv_ajax_itemLocations,
/* harmony export */   "inv_ajax_carTypes": () => /* binding */ inv_ajax_carTypes,
/* harmony export */   "inv_ajax_carBrands": () => /* binding */ inv_ajax_carBrands,
/* harmony export */   "inv_ajax_carFuels": () => /* binding */ inv_ajax_carFuels,
/* harmony export */   "inv_ajax_employees": () => /* binding */ inv_ajax_employees,
/* harmony export */   "inv_ajax_lookupTypes": () => /* binding */ inv_ajax_lookupTypes,
/* harmony export */   "inv_ajax_lookupValues": () => /* binding */ inv_ajax_lookupValues,
/* harmony export */   "inv_ajax_organizationUnits": () => /* binding */ inv_ajax_organizationUnits,
/* harmony export */   "inv_ajax_poDistributionsAll": () => /* binding */ inv_ajax_poDistributionsAll,
/* harmony export */   "inv_ajax_poHeadersAll": () => /* binding */ inv_ajax_poHeadersAll,
/* harmony export */   "inv_ajax_poLinesAll": () => /* binding */ inv_ajax_poLinesAll,
/* harmony export */   "inv_ajax_lotOnhands": () => /* binding */ inv_ajax_lotOnhands,
/* harmony export */   "qm_api_settings_specifications_store": () => /* binding */ qm_api_settings_specifications_store,
/* harmony export */   "qm_settings_checkPointsTobaccoLeaf_index": () => /* binding */ qm_settings_checkPointsTobaccoLeaf_index,
/* harmony export */   "qm_settings_checkPointsTobaccoLeaf_create": () => /* binding */ qm_settings_checkPointsTobaccoLeaf_create,
/* harmony export */   "qm_settings_checkPointsTobaccoLeaf_store": () => /* binding */ qm_settings_checkPointsTobaccoLeaf_store,
/* harmony export */   "qm_settings_checkPointsTobaccoLeaf_update": () => /* binding */ qm_settings_checkPointsTobaccoLeaf_update,
/* harmony export */   "qm_settings_checkPointsTobaccoLeaf_edit": () => /* binding */ qm_settings_checkPointsTobaccoLeaf_edit,
/* harmony export */   "qm_settings_checkPointsTobaccoBeetle_index": () => /* binding */ qm_settings_checkPointsTobaccoBeetle_index,
/* harmony export */   "qm_settings_checkPointsTobaccoBeetle_create": () => /* binding */ qm_settings_checkPointsTobaccoBeetle_create,
/* harmony export */   "qm_settings_checkPointsTobaccoBeetle_store": () => /* binding */ qm_settings_checkPointsTobaccoBeetle_store,
/* harmony export */   "qm_settings_checkPointsTobaccoBeetle_edit": () => /* binding */ qm_settings_checkPointsTobaccoBeetle_edit,
/* harmony export */   "qm_settings_checkPointsTobaccoBeetle_update": () => /* binding */ qm_settings_checkPointsTobaccoBeetle_update,
/* harmony export */   "qm_settings_attachments_download": () => /* binding */ qm_settings_attachments_download,
/* harmony export */   "qm_settings_attachments_image": () => /* binding */ qm_settings_attachments_image,
/* harmony export */   "qm_settings_testUnit_index": () => /* binding */ qm_settings_testUnit_index,
/* harmony export */   "qm_settings_testUnit_create": () => /* binding */ qm_settings_testUnit_create,
/* harmony export */   "qm_settings_testUnit_edit": () => /* binding */ qm_settings_testUnit_edit,
/* harmony export */   "qm_settings_testUnit_store": () => /* binding */ qm_settings_testUnit_store,
/* harmony export */   "qm_settings_testUnit_update": () => /* binding */ qm_settings_testUnit_update,
/* harmony export */   "qm_settings_qcArea_index": () => /* binding */ qm_settings_qcArea_index,
/* harmony export */   "qm_settings_qcArea_update": () => /* binding */ qm_settings_qcArea_update,
/* harmony export */   "qm_settings_defineTestsTobaccoLeaf_index": () => /* binding */ qm_settings_defineTestsTobaccoLeaf_index,
/* harmony export */   "qm_settings_defineTestsTobaccoLeaf_create": () => /* binding */ qm_settings_defineTestsTobaccoLeaf_create,
/* harmony export */   "qm_settings_defineTestsTobaccoLeaf_store": () => /* binding */ qm_settings_defineTestsTobaccoLeaf_store,
/* harmony export */   "qm_settings_defineTestsTobaccoLeaf_update": () => /* binding */ qm_settings_defineTestsTobaccoLeaf_update,
/* harmony export */   "qm_settings_defineTestsTobaccoBeetle_index": () => /* binding */ qm_settings_defineTestsTobaccoBeetle_index,
/* harmony export */   "qm_settings_defineTestsTobaccoBeetle_create": () => /* binding */ qm_settings_defineTestsTobaccoBeetle_create,
/* harmony export */   "qm_settings_defineTestsTobaccoBeetle_store": () => /* binding */ qm_settings_defineTestsTobaccoBeetle_store,
/* harmony export */   "qm_settings_defineTestsTobaccoBeetle_update": () => /* binding */ qm_settings_defineTestsTobaccoBeetle_update,
/* harmony export */   "qm_settings_defineTestsFinishedProducts_index": () => /* binding */ qm_settings_defineTestsFinishedProducts_index,
/* harmony export */   "qm_settings_defineTestsFinishedProducts_create": () => /* binding */ qm_settings_defineTestsFinishedProducts_create,
/* harmony export */   "qm_settings_defineTestsFinishedProducts_store": () => /* binding */ qm_settings_defineTestsFinishedProducts_store,
/* harmony export */   "qm_settings_defineTestsFinishedProducts_update": () => /* binding */ qm_settings_defineTestsFinishedProducts_update,
/* harmony export */   "qm_settings_defineTestsQtmMachines_index": () => /* binding */ qm_settings_defineTestsQtmMachines_index,
/* harmony export */   "qm_settings_defineTestsQtmMachines_create": () => /* binding */ qm_settings_defineTestsQtmMachines_create,
/* harmony export */   "qm_settings_defineTestsQtmMachines_store": () => /* binding */ qm_settings_defineTestsQtmMachines_store,
/* harmony export */   "qm_settings_defineTestsQtmMachines_update": () => /* binding */ qm_settings_defineTestsQtmMachines_update,
/* harmony export */   "qm_settings_defineTestsPacketAirLeaks_index": () => /* binding */ qm_settings_defineTestsPacketAirLeaks_index,
/* harmony export */   "qm_settings_defineTestsPacketAirLeaks_create": () => /* binding */ qm_settings_defineTestsPacketAirLeaks_create,
/* harmony export */   "qm_settings_defineTestsPacketAirLeaks_store": () => /* binding */ qm_settings_defineTestsPacketAirLeaks_store,
/* harmony export */   "qm_settings_defineTestsPacketAirLeaks_update": () => /* binding */ qm_settings_defineTestsPacketAirLeaks_update,
/* harmony export */   "qm_settings_specifications_index": () => /* binding */ qm_settings_specifications_index,
/* harmony export */   "qm_ajax_tobaccos_getSampleSpecifications": () => /* binding */ qm_ajax_tobaccos_getSampleSpecifications,
/* harmony export */   "qm_ajax_tobaccos_storeSampleResult": () => /* binding */ qm_ajax_tobaccos_storeSampleResult,
/* harmony export */   "qm_ajax_finishedProducts_getSampleSpecifications": () => /* binding */ qm_ajax_finishedProducts_getSampleSpecifications,
/* harmony export */   "qm_ajax_finishedProducts_storeSampleResult": () => /* binding */ qm_ajax_finishedProducts_storeSampleResult,
/* harmony export */   "qm_ajax_qtmMachines_getSampleSpecifications": () => /* binding */ qm_ajax_qtmMachines_getSampleSpecifications,
/* harmony export */   "qm_ajax_qtmMachines_storeSampleResult": () => /* binding */ qm_ajax_qtmMachines_storeSampleResult,
/* harmony export */   "qm_ajax_packetAirLeaks_getSampleSpecifications": () => /* binding */ qm_ajax_packetAirLeaks_getSampleSpecifications,
/* harmony export */   "qm_ajax_packetAirLeaks_storeSampleResult": () => /* binding */ qm_ajax_packetAirLeaks_storeSampleResult,
/* harmony export */   "qm_ajax_mothOutbreaks_getSampleSpecifications": () => /* binding */ qm_ajax_mothOutbreaks_getSampleSpecifications,
/* harmony export */   "qm_ajax_mothOutbreaks_storeSampleResult": () => /* binding */ qm_ajax_mothOutbreaks_storeSampleResult,
/* harmony export */   "qm_ajax_mothOutbreaks_uploadExcelFile": () => /* binding */ qm_ajax_mothOutbreaks_uploadExcelFile,
/* harmony export */   "qm_tobaccos_create": () => /* binding */ qm_tobaccos_create,
/* harmony export */   "qm_tobaccos_result": () => /* binding */ qm_tobaccos_result,
/* harmony export */   "qm_tobaccos_reportSummary": () => /* binding */ qm_tobaccos_reportSummary,
/* harmony export */   "qm_tobaccos_exportExcel_reportSummary": () => /* binding */ qm_tobaccos_exportExcel_reportSummary,
/* harmony export */   "qm_tobaccos_store": () => /* binding */ qm_tobaccos_store,
/* harmony export */   "qm_finishedProducts_create": () => /* binding */ qm_finishedProducts_create,
/* harmony export */   "qm_finishedProducts_result": () => /* binding */ qm_finishedProducts_result,
/* harmony export */   "qm_finishedProducts_track": () => /* binding */ qm_finishedProducts_track,
/* harmony export */   "qm_finishedProducts_reportSummary": () => /* binding */ qm_finishedProducts_reportSummary,
/* harmony export */   "qm_finishedProducts_reportIssue": () => /* binding */ qm_finishedProducts_reportIssue,
/* harmony export */   "qm_finishedProducts_exportExcel_reportSummary": () => /* binding */ qm_finishedProducts_exportExcel_reportSummary,
/* harmony export */   "qm_finishedProducts_exportExcel_reportIssue": () => /* binding */ qm_finishedProducts_exportExcel_reportIssue,
/* harmony export */   "qm_finishedProducts_store": () => /* binding */ qm_finishedProducts_store,
/* harmony export */   "qm_finishedProducts_storeResult": () => /* binding */ qm_finishedProducts_storeResult,
/* harmony export */   "qm_qtmMachines_create": () => /* binding */ qm_qtmMachines_create,
/* harmony export */   "qm_qtmMachines_result": () => /* binding */ qm_qtmMachines_result,
/* harmony export */   "qm_qtmMachines_track": () => /* binding */ qm_qtmMachines_track,
/* harmony export */   "qm_qtmMachines_reportSummary": () => /* binding */ qm_qtmMachines_reportSummary,
/* harmony export */   "qm_qtmMachines_reportUnderAverage": () => /* binding */ qm_qtmMachines_reportUnderAverage,
/* harmony export */   "qm_qtmMachines_reportProductQuality": () => /* binding */ qm_qtmMachines_reportProductQuality,
/* harmony export */   "qm_qtmMachines_reportPhysicalValue": () => /* binding */ qm_qtmMachines_reportPhysicalValue,
/* harmony export */   "qm_qtmMachines_exportExcel_reportUnderAverage": () => /* binding */ qm_qtmMachines_exportExcel_reportUnderAverage,
/* harmony export */   "qm_qtmMachines_exportExcel_reportProductQuality": () => /* binding */ qm_qtmMachines_exportExcel_reportProductQuality,
/* harmony export */   "qm_qtmMachines_exportExcel_reportPhysicalValue": () => /* binding */ qm_qtmMachines_exportExcel_reportPhysicalValue,
/* harmony export */   "qm_qtmMachines_store": () => /* binding */ qm_qtmMachines_store,
/* harmony export */   "qm_qtmMachines_storeResult": () => /* binding */ qm_qtmMachines_storeResult,
/* harmony export */   "qm_packetAirLeaks_create": () => /* binding */ qm_packetAirLeaks_create,
/* harmony export */   "qm_packetAirLeaks_result": () => /* binding */ qm_packetAirLeaks_result,
/* harmony export */   "qm_packetAirLeaks_track": () => /* binding */ qm_packetAirLeaks_track,
/* harmony export */   "qm_packetAirLeaks_reportSummary": () => /* binding */ qm_packetAirLeaks_reportSummary,
/* harmony export */   "qm_packetAirLeaks_reportLeakRate": () => /* binding */ qm_packetAirLeaks_reportLeakRate,
/* harmony export */   "qm_packetAirLeaks_exportExcel_reportSummary": () => /* binding */ qm_packetAirLeaks_exportExcel_reportSummary,
/* harmony export */   "qm_packetAirLeaks_exportExcel_reportLeakRate": () => /* binding */ qm_packetAirLeaks_exportExcel_reportLeakRate,
/* harmony export */   "qm_packetAirLeaks_store": () => /* binding */ qm_packetAirLeaks_store,
/* harmony export */   "qm_packetAirLeaks_storeResult": () => /* binding */ qm_packetAirLeaks_storeResult,
/* harmony export */   "qm_mothOutbreaks_create": () => /* binding */ qm_mothOutbreaks_create,
/* harmony export */   "qm_mothOutbreaks_result": () => /* binding */ qm_mothOutbreaks_result,
/* harmony export */   "qm_mothOutbreaks_track": () => /* binding */ qm_mothOutbreaks_track,
/* harmony export */   "qm_mothOutbreaks_reportSummary": () => /* binding */ qm_mothOutbreaks_reportSummary,
/* harmony export */   "qm_mothOutbreaks_exportExcel_reportSummary": () => /* binding */ qm_mothOutbreaks_exportExcel_reportSummary,
/* harmony export */   "qm_mothOutbreaks_store": () => /* binding */ qm_mothOutbreaks_store,
/* harmony export */   "qm_mothOutbreaks_storeResult": () => /* binding */ qm_mothOutbreaks_storeResult,
/* harmony export */   "qm_files_image": () => /* binding */ qm_files_image,
/* harmony export */   "qm_files_imageThumbnail": () => /* binding */ qm_files_imageThumbnail,
/* harmony export */   "qm_files_download": () => /* binding */ qm_files_download,
/* harmony export */   "planning_machineYearly_index": () => /* binding */ planning_machineYearly_index,
/* harmony export */   "planning_machineYearly_store": () => /* binding */ planning_machineYearly_store,
/* harmony export */   "planning_machineYearly_update": () => /* binding */ planning_machineYearly_update,
/* harmony export */   "planning_machineYearly_updateLines": () => /* binding */ planning_machineYearly_updateLines,
/* harmony export */   "planning_machineYearly_machineDetail": () => /* binding */ planning_machineYearly_machineDetail,
/* harmony export */   "planning_machineYearly_updatePlanPmYearly": () => /* binding */ planning_machineYearly_updatePlanPmYearly,
/* harmony export */   "planning_machineYearly_downtime": () => /* binding */ planning_machineYearly_downtime,
/* harmony export */   "planning_machineBiweekly_index": () => /* binding */ planning_machineBiweekly_index,
/* harmony export */   "planning_machineBiweekly_store": () => /* binding */ planning_machineBiweekly_store,
/* harmony export */   "planning_machineBiweekly_update": () => /* binding */ planning_machineBiweekly_update,
/* harmony export */   "planning_machineBiweekly_updateLines": () => /* binding */ planning_machineBiweekly_updateLines,
/* harmony export */   "planning_machineBiweekly_updatePlanPmBiweekly": () => /* binding */ planning_machineBiweekly_updatePlanPmBiweekly,
/* harmony export */   "planning_machineBiweekly_downtime": () => /* binding */ planning_machineBiweekly_downtime,
/* harmony export */   "planning_productionBiweekly_index": () => /* binding */ planning_productionBiweekly_index,
/* harmony export */   "planning_productionBiweekly_show": () => /* binding */ planning_productionBiweekly_show,
/* harmony export */   "planning_adjusts_store": () => /* binding */ planning_adjusts_store,
/* harmony export */   "planning_adjusts_show": () => /* binding */ planning_adjusts_show,
/* harmony export */   "planning_followUps_index": () => /* binding */ planning_followUps_index,
/* harmony export */   "planning_productionDaily_show": () => /* binding */ planning_productionDaily_show,
/* harmony export */   "planning_stampMonthly_index": () => /* binding */ planning_stampMonthly_index,
/* harmony export */   "planning_stampFollow": () => /* binding */ planning_stampFollow,
/* harmony export */   "planning_stampFollow_export": () => /* binding */ planning_stampFollow_export,
/* harmony export */   "planning_ajax_": () => /* binding */ planning_ajax_,
/* harmony export */   "planning_ajax_biWeekly_": () => /* binding */ planning_ajax_biWeekly_,
/* harmony export */   "planning_ajax_biWeekly_prod_getEstData": () => /* binding */ planning_ajax_biWeekly_prod_getEstData,
/* harmony export */   "planning_ajax_biWeekly_prod_getAvgData": () => /* binding */ planning_ajax_biWeekly_prod_getAvgData,
/* harmony export */   "planning_ajax_productionBiweekly_modalCreateDetails": () => /* binding */ planning_ajax_productionBiweekly_modalCreateDetails,
/* harmony export */   "planning_ajax_productionBiweekly_search": () => /* binding */ planning_ajax_productionBiweekly_search,
/* harmony export */   "planning_ajax_productionBiweekly_store": () => /* binding */ planning_ajax_productionBiweekly_store,
/* harmony export */   "planning_ajax_productionBiweekly_update": () => /* binding */ planning_ajax_productionBiweekly_update,
/* harmony export */   "planning_ajax_productionBiweekly_approve": () => /* binding */ planning_ajax_productionBiweekly_approve,
/* harmony export */   "planning_ajax_productionBiweekly_checkApprove": () => /* binding */ planning_ajax_productionBiweekly_checkApprove,
/* harmony export */   "planning_ajax_productionBiweekly_getPlanMachine": () => /* binding */ planning_ajax_productionBiweekly_getPlanMachine,
/* harmony export */   "planning_ajax_productionBiweekly_getEstData": () => /* binding */ planning_ajax_productionBiweekly_getEstData,
/* harmony export */   "planning_ajax_productionBiweekly_getAvgData": () => /* binding */ planning_ajax_productionBiweekly_getAvgData,
/* harmony export */   "planning_ajax_productionBiweekly_getEstByBiweekly": () => /* binding */ planning_ajax_productionBiweekly_getEstByBiweekly,
/* harmony export */   "planning_ajax_adjusts_search": () => /* binding */ planning_ajax_adjusts_search,
/* harmony export */   "planning_ajax_adjusts_searchCreate": () => /* binding */ planning_ajax_adjusts_searchCreate,
/* harmony export */   "planning_ajax_adjusts_searchItem": () => /* binding */ planning_ajax_adjusts_searchItem,
/* harmony export */   "planning_ajax_adjusts_update": () => /* binding */ planning_ajax_adjusts_update,
/* harmony export */   "planning_ajax_adjusts_updateNote": () => /* binding */ planning_ajax_adjusts_updateNote,
/* harmony export */   "planning_ajax_adjusts_getAdjData": () => /* binding */ planning_ajax_adjusts_getAdjData,
/* harmony export */   "planning_ajax_adjusts_approve": () => /* binding */ planning_ajax_adjusts_approve,
/* harmony export */   "planning_ajax_adjusts_checkApprove": () => /* binding */ planning_ajax_adjusts_checkApprove,
/* harmony export */   "planning_ajax_followUps_search": () => /* binding */ planning_ajax_followUps_search,
/* harmony export */   "planning_ajax_followUps_getData": () => /* binding */ planning_ajax_followUps_getData,
/* harmony export */   "planning_ajax_productionDaily_modalCreateDetails": () => /* binding */ planning_ajax_productionDaily_modalCreateDetails,
/* harmony export */   "planning_ajax_productionDaily_search": () => /* binding */ planning_ajax_productionDaily_search,
/* harmony export */   "planning_ajax_productionDaily_create": () => /* binding */ planning_ajax_productionDaily_create,
/* harmony export */   "planning_ajax_productionDaily_getOmSalesForecast": () => /* binding */ planning_ajax_productionDaily_getOmSalesForecast,
/* harmony export */   "planning_ajax_productionDaily_getProductionMachine": () => /* binding */ planning_ajax_productionDaily_getProductionMachine,
/* harmony export */   "planning_ajax_productionDaily_getProductionItem": () => /* binding */ planning_ajax_productionDaily_getProductionItem,
/* harmony export */   "planning_ajax_productionDaily_submitProductionMachine": () => /* binding */ planning_ajax_productionDaily_submitProductionMachine,
/* harmony export */   "planning_ajax_productionDaily_checkApprove": () => /* binding */ planning_ajax_productionDaily_checkApprove,
/* harmony export */   "planning_ajax_productionDaily_approve": () => /* binding */ planning_ajax_productionDaily_approve,
/* harmony export */   "planning_ajax_productionDaily_checkUnapprove": () => /* binding */ planning_ajax_productionDaily_checkUnapprove,
/* harmony export */   "planning_ajax_productionDaily_unapprove": () => /* binding */ planning_ajax_productionDaily_unapprove,
/* harmony export */   "planning_ajax_productionDaily_getGrpEfficiencyProduct": () => /* binding */ planning_ajax_productionDaily_getGrpEfficiencyProduct,
/* harmony export */   "planning_ajax_productionDaily_updateWorkingHour": () => /* binding */ planning_ajax_productionDaily_updateWorkingHour,
/* harmony export */   "planning_ajax_stampMonthly_modalCreateDetails": () => /* binding */ planning_ajax_stampMonthly_modalCreateDetails,
/* harmony export */   "planning_ajax_stampMonthly_getEstData": () => /* binding */ planning_ajax_stampMonthly_getEstData,
/* harmony export */   "planning_ajax_stampMonthly_store": () => /* binding */ planning_ajax_stampMonthly_store,
/* harmony export */   "planning_ajax_stampMonthly_update": () => /* binding */ planning_ajax_stampMonthly_update,
/* harmony export */   "planning_ajax_stampMonthly_duplicate": () => /* binding */ planning_ajax_stampMonthly_duplicate,
/* harmony export */   "planning_ajax_stampMonthly_updateEst": () => /* binding */ planning_ajax_stampMonthly_updateEst,
/* harmony export */   "planning_ajax_stampMonthly_search": () => /* binding */ planning_ajax_stampMonthly_search,
/* harmony export */   "planning_ajax_stampMonthly_approve": () => /* binding */ planning_ajax_stampMonthly_approve,
/* harmony export */   "planning_ajax_stampMonthly_checkApprove": () => /* binding */ planning_ajax_stampMonthly_checkApprove,
/* harmony export */   "planning_ajax_stampFollow_getStampDaily": () => /* binding */ planning_ajax_stampFollow_getStampDaily,
/* harmony export */   "planning_ajax_stampFollow_store": () => /* binding */ planning_ajax_stampFollow_store,
/* harmony export */   "planning_ajax_stampFollow_update": () => /* binding */ planning_ajax_stampFollow_update,
/* harmony export */   "pm_ajax_materialRequests_lines": () => /* binding */ pm_ajax_materialRequests_lines,
/* harmony export */   "pm_ajax_materialRequests_getItem": () => /* binding */ pm_ajax_materialRequests_getItem,
/* harmony export */   "pm_ajax_materialRequests_store": () => /* binding */ pm_ajax_materialRequests_store,
/* harmony export */   "pm_ajax_materialRequests_setStatus": () => /* binding */ pm_ajax_materialRequests_setStatus,
/* harmony export */   "pm_ajax_transferProducts_getLines": () => /* binding */ pm_ajax_transferProducts_getLines,
/* harmony export */   "pm_ajax_transferProducts_getItem": () => /* binding */ pm_ajax_transferProducts_getItem,
/* harmony export */   "pm_ajax_transferProducts_store": () => /* binding */ pm_ajax_transferProducts_store,
/* harmony export */   "pm_ajax_transferProducts_setStatus": () => /* binding */ pm_ajax_transferProducts_setStatus,
/* harmony export */   "pm_ajax_sendCigarettes_getLines": () => /* binding */ pm_ajax_sendCigarettes_getLines,
/* harmony export */   "pm_ajax_sendCigarettes_getItem": () => /* binding */ pm_ajax_sendCigarettes_getItem,
/* harmony export */   "pm_ajax_sendCigarettes_store": () => /* binding */ pm_ajax_sendCigarettes_store,
/* harmony export */   "pm_ajax_sendCigarettes_setStatus": () => /* binding */ pm_ajax_sendCigarettes_setStatus,
/* harmony export */   "pm_ajax_wipRequests_getLines": () => /* binding */ pm_ajax_wipRequests_getLines,
/* harmony export */   "pm_ajax_wipRequests_getItem": () => /* binding */ pm_ajax_wipRequests_getItem,
/* harmony export */   "pm_ajax_wipRequests_store": () => /* binding */ pm_ajax_wipRequests_store,
/* harmony export */   "pm_ajax_wipRequests_setStatus": () => /* binding */ pm_ajax_wipRequests_setStatus,
/* harmony export */   "pm_ajax_jams_getLines": () => /* binding */ pm_ajax_jams_getLines,
/* harmony export */   "pm_ajax_jams_getItem": () => /* binding */ pm_ajax_jams_getItem,
/* harmony export */   "pm_ajax_jams_store": () => /* binding */ pm_ajax_jams_store,
/* harmony export */   "pm_ajax_jams_setStatus": () => /* binding */ pm_ajax_jams_setStatus,
/* harmony export */   "pm_ajax_ingredientPreparationQrcode": () => /* binding */ pm_ajax_ingredientPreparationQrcode,
/* harmony export */   "pm_ajax_ingredientPreparationDetail": () => /* binding */ pm_ajax_ingredientPreparationDetail,
/* harmony export */   "pm_ajax_sprinkleTobaccos_getLines": () => /* binding */ pm_ajax_sprinkleTobaccos_getLines,
/* harmony export */   "pm_ajax_sprinkleTobaccos_getItem": () => /* binding */ pm_ajax_sprinkleTobaccos_getItem,
/* harmony export */   "pm_ajax_sprinkleTobaccos_store": () => /* binding */ pm_ajax_sprinkleTobaccos_store,
/* harmony export */   "pm_ajax_sprinkleTobaccos_cancel": () => /* binding */ pm_ajax_sprinkleTobaccos_cancel,
/* harmony export */   "pm_ajax_sprinkleTobaccos_setStatus": () => /* binding */ pm_ajax_sprinkleTobaccos_setStatus,
/* harmony export */   "pm_materialRequests_index": () => /* binding */ pm_materialRequests_index,
/* harmony export */   "pm_transferProducts_index": () => /* binding */ pm_transferProducts_index,
/* harmony export */   "pm_sendCigarettes_index": () => /* binding */ pm_sendCigarettes_index,
/* harmony export */   "pm_wipRequests_index": () => /* binding */ pm_wipRequests_index,
/* harmony export */   "pm_jams_index": () => /* binding */ pm_jams_index,
/* harmony export */   "pm_ingredientPreparation_index": () => /* binding */ pm_ingredientPreparation_index,
/* harmony export */   "pm_ingredientPreparation_printPdf": () => /* binding */ pm_ingredientPreparation_printPdf,
/* harmony export */   "pm_sprinkleTobaccos_index": () => /* binding */ pm_sprinkleTobaccos_index,
/* harmony export */   "pm_ajax_qrcodeCheckMtls_detail": () => /* binding */ pm_ajax_qrcodeCheckMtls_detail,
/* harmony export */   "pm_ajax_qrcodeTransferMtls_detail": () => /* binding */ pm_ajax_qrcodeTransferMtls_detail,
/* harmony export */   "pm_ajax_qrcodeRcvTransferMtls_detail": () => /* binding */ pm_ajax_qrcodeRcvTransferMtls_detail,
/* harmony export */   "pm_ajax_qrcodeReturnMtls_detail": () => /* binding */ pm_ajax_qrcodeReturnMtls_detail,
/* harmony export */   "pm_qrcodeCheckMtls_index": () => /* binding */ pm_qrcodeCheckMtls_index,
/* harmony export */   "pm_qrcodeTransferMtls_index": () => /* binding */ pm_qrcodeTransferMtls_index,
/* harmony export */   "pm_qrcodeRcvTransferMtls_index": () => /* binding */ pm_qrcodeRcvTransferMtls_index,
/* harmony export */   "pm_qrcodeReturnMtls_index": () => /* binding */ pm_qrcodeReturnMtls_index,
/* harmony export */   "ajax_pm_planningJobs_index": () => /* binding */ ajax_pm_planningJobs_index,
/* harmony export */   "pm_planningJobs_index": () => /* binding */ pm_planningJobs_index,
/* harmony export */   "pm_ajax_confirmOrder_store": () => /* binding */ pm_ajax_confirmOrder_store,
/* harmony export */   "pm_ajax_confirmOrder_getLines": () => /* binding */ pm_ajax_confirmOrder_getLines,
/* harmony export */   "pm_ajax_confirmOrder_getDistributions": () => /* binding */ pm_ajax_confirmOrder_getDistributions,
/* harmony export */   "pm_ajax_confirmOrder_getWipstep": () => /* binding */ pm_ajax_confirmOrder_getWipstep,
/* harmony export */   "pm_ajax_confirmOrder_getSearch": () => /* binding */ pm_ajax_confirmOrder_getSearch,
/* harmony export */   "pm_ajax_confirmOrder_getHeadersByDate": () => /* binding */ pm_ajax_confirmOrder_getHeadersByDate,
/* harmony export */   "pm_ajax_confirmOrder_updateOrders": () => /* binding */ pm_ajax_confirmOrder_updateOrders,
/* harmony export */   "pm_confirmOrder_index": () => /* binding */ pm_confirmOrder_index,
/* harmony export */   "pm_sampleReport_report": () => /* binding */ pm_sampleReport_report,
/* harmony export */   "pm_sampleReport_report1Pdf": () => /* binding */ pm_sampleReport_report1Pdf,
/* harmony export */   "pm_sampleReport_reportInventoryPdf": () => /* binding */ pm_sampleReport_reportInventoryPdf,
/* harmony export */   "pm_sampleReport_reportSummaryPdf": () => /* binding */ pm_sampleReport_reportSummaryPdf,
/* harmony export */   "pm_sampleReport_reportVue": () => /* binding */ pm_sampleReport_reportVue,
/* harmony export */   "pm_sampleReport_report1": () => /* binding */ pm_sampleReport_report1,
/* harmony export */   "pm_sampleReport_report2": () => /* binding */ pm_sampleReport_report2,
/* harmony export */   "pm_sampleReport_testPdf": () => /* binding */ pm_sampleReport_testPdf,
/* harmony export */   "pm_ajax_wipConfirm_importMesData": () => /* binding */ pm_ajax_wipConfirm_importMesData,
/* harmony export */   "pm_ajax_wipConfirm_lines": () => /* binding */ pm_ajax_wipConfirm_lines,
/* harmony export */   "pm_ajax_wipConfirm_store": () => /* binding */ pm_ajax_wipConfirm_store,
/* harmony export */   "pm_wipConfirm_index": () => /* binding */ pm_wipConfirm_index,
/* harmony export */   "pm_wipConfirm_search": () => /* binding */ pm_wipConfirm_search,
/* harmony export */   "pm_wipConfirm_jobs": () => /* binding */ pm_wipConfirm_jobs,
/* harmony export */   "pm_wipConfirm_exportPdfParameters": () => /* binding */ pm_wipConfirm_exportPdfParameters,
/* harmony export */   "pm_wipConfirm_exportPdf": () => /* binding */ pm_wipConfirm_exportPdf,
/* harmony export */   "pm_ajax_getMeReviewIssuesV": () => /* binding */ pm_ajax_getMeReviewIssuesV,
/* harmony export */   "pm_ajax_optFromBlendNo": () => /* binding */ pm_ajax_optFromBlendNo,
/* harmony export */   "pm_ajax_getOprnByItem": () => /* binding */ pm_ajax_getOprnByItem,
/* harmony export */   "pm_ajax_getFormulas": () => /* binding */ pm_ajax_getFormulas,
/* harmony export */   "pm_ajax_saveData": () => /* binding */ pm_ajax_saveData,
/* harmony export */   "pm_ajax_updateData": () => /* binding */ pm_ajax_updateData,
/* harmony export */   "pm_ajax_findClassification": () => /* binding */ pm_ajax_findClassification,
/* harmony export */   "pm_ajax_getHeaders": () => /* binding */ pm_ajax_getHeaders,
/* harmony export */   "pm_ajax_cancelData": () => /* binding */ pm_ajax_cancelData,
/* harmony export */   "pm_ajax_searchHeader": () => /* binding */ pm_ajax_searchHeader,
/* harmony export */   "pm_wipIssue_index": () => /* binding */ pm_wipIssue_index,
/* harmony export */   "pm_wipIssue_casingFlavorIndex": () => /* binding */ pm_wipIssue_casingFlavorIndex,
/* harmony export */   "pm_wipIssue_issue": () => /* binding */ pm_wipIssue_issue,
/* harmony export */   "pm_wipIssue_cutOf": () => /* binding */ pm_wipIssue_cutOf,
/* harmony export */   "pd_ajax_expFormulas_getLines": () => /* binding */ pd_ajax_expFormulas_getLines,
/* harmony export */   "pd_ajax_expFormulas_getData": () => /* binding */ pd_ajax_expFormulas_getData,
/* harmony export */   "pd_ajax_expFormulas_compareData": () => /* binding */ pd_ajax_expFormulas_compareData,
/* harmony export */   "pd_ajax_expFormulas_store": () => /* binding */ pd_ajax_expFormulas_store,
/* harmony export */   "pd_ajax_expFormulas_setStatus": () => /* binding */ pd_ajax_expFormulas_setStatus,
/* harmony export */   "pd_ajax_adjSalForecasts_store": () => /* binding */ pd_ajax_adjSalForecasts_store,
/* harmony export */   "pd_ajax_adjSalForecasts_update": () => /* binding */ pd_ajax_adjSalForecasts_update,
/* harmony export */   "pd_ajax_adjSalForecasts_modalCreateDetails": () => /* binding */ pd_ajax_adjSalForecasts_modalCreateDetails,
/* harmony export */   "pd_ajax_adjSalForecasts_modalSearchDetails": () => /* binding */ pd_ajax_adjSalForecasts_modalSearchDetails,
/* harmony export */   "pd_expFormulas_index": () => /* binding */ pd_expFormulas_index,
/* harmony export */   "pd_adjSalForecasts_index": () => /* binding */ pd_adjSalForecasts_index,
/* harmony export */   "ct_costCenter_index": () => /* binding */ ct_costCenter_index,
/* harmony export */   "ct_costCenter_create": () => /* binding */ ct_costCenter_create,
/* harmony export */   "ct_costCenter_edit": () => /* binding */ ct_costCenter_edit,
/* harmony export */   "ct_specifyPercentage_create": () => /* binding */ ct_specifyPercentage_create,
/* harmony export */   "ct_productGroup_index": () => /* binding */ ct_productGroup_index,
/* harmony export */   "ct_criterionAllocate_index": () => /* binding */ ct_criterionAllocate_index,
/* harmony export */   "ct_setAccountType_index": () => /* binding */ ct_setAccountType_index,
/* harmony export */   "ct_accountCodeLedger_index": () => /* binding */ ct_accountCodeLedger_index,
/* harmony export */   "ct_agency_show": () => /* binding */ ct_agency_show,
/* harmony export */   "ct_specifyAgency_index": () => /* binding */ ct_specifyAgency_index,
/* harmony export */   "ct_productPlanAmount_index": () => /* binding */ ct_productPlanAmount_index,
/* harmony export */   "ct_purchasePriceInfo_index": () => /* binding */ ct_purchasePriceInfo_index,
/* harmony export */   "ct_taxMedicine_index": () => /* binding */ ct_taxMedicine_index,
/* harmony export */   "ct_taxMedicine_create": () => /* binding */ ct_taxMedicine_create,
/* harmony export */   "ct_taxMedicine_edit": () => /* binding */ ct_taxMedicine_edit,
/* harmony export */   "ct_ajax_account_index": () => /* binding */ ct_ajax_account_index,
/* harmony export */   "ct_ajax_ptglAccountsInfo_getDataBySegment": () => /* binding */ ct_ajax_ptglAccountsInfo_getDataBySegment,
/* harmony export */   "ct_ajax_ptpmItemNumberV_getCategory": () => /* binding */ ct_ajax_ptpmItemNumberV_getCategory,
/* harmony export */   "ct_ajax_ptpmItemNumberV_getOrganizations": () => /* binding */ ct_ajax_ptpmItemNumberV_getOrganizations,
/* harmony export */   "ct_ajax_ptpmItemNumberV_organizationSourceItemCost": () => /* binding */ ct_ajax_ptpmItemNumberV_organizationSourceItemCost,
/* harmony export */   "ct_ajax_": () => /* binding */ ct_ajax_,
/* harmony export */   "ct_ajax_ptpmItemNumberV_getRawMaterial": () => /* binding */ ct_ajax_ptpmItemNumberV_getRawMaterial,
/* harmony export */   "ct_ajax_costCenter_": () => /* binding */ ct_ajax_costCenter_,
/* harmony export */   "ct_ajax_costCenter_index": () => /* binding */ ct_ajax_costCenter_index,
/* harmony export */   "ct_ajax_costCenter_find": () => /* binding */ ct_ajax_costCenter_find,
/* harmony export */   "ct_ajax_costCenter_updateActive": () => /* binding */ ct_ajax_costCenter_updateActive,
/* harmony export */   "ct_ajax_costCenter_periodYears": () => /* binding */ ct_ajax_costCenter_periodYears,
/* harmony export */   "ct_ajax_costCenter_updateCt": () => /* binding */ ct_ajax_costCenter_updateCt,
/* harmony export */   "ct_ajax_costCenter_update": () => /* binding */ ct_ajax_costCenter_update,
/* harmony export */   "ct_ajax_costCenter_years": () => /* binding */ ct_ajax_costCenter_years,
/* harmony export */   "ct_ajax_costCenter_codes": () => /* binding */ ct_ajax_costCenter_codes,
/* harmony export */   "ct_ajax_costCenter_ptpmItems": () => /* binding */ ct_ajax_costCenter_ptpmItems,
/* harmony export */   "ct_ajax_productGroup_index": () => /* binding */ ct_ajax_productGroup_index,
/* harmony export */   "ct_ajax_productGroup_find": () => /* binding */ ct_ajax_productGroup_find,
/* harmony export */   "ct_ajax_productGroup_copy_get": () => /* binding */ ct_ajax_productGroup_copy_get,
/* harmony export */   "ct_ajax_productGroup_copy_post": () => /* binding */ ct_ajax_productGroup_copy_post,
/* harmony export */   "ct_ajax_productGroupDetail_update": () => /* binding */ ct_ajax_productGroupDetail_update,
/* harmony export */   "ct_ajax_productGroupDetail_findWithProductGroup": () => /* binding */ ct_ajax_productGroupDetail_findWithProductGroup,
/* harmony export */   "ct_ajax_productPlanAmount_update": () => /* binding */ ct_ajax_productPlanAmount_update,
/* harmony export */   "ct_ajax_productProcesses_update": () => /* binding */ ct_ajax_productProcesses_update,
/* harmony export */   "ct_ajax_productProcesses_show": () => /* binding */ ct_ajax_productProcesses_show,
/* harmony export */   "ct_ajax_designateAgency_getDepartment": () => /* binding */ ct_ajax_designateAgency_getDepartment,
/* harmony export */   "ct_ajax_setAccountType_getListSetAccountType": () => /* binding */ ct_ajax_setAccountType_getListSetAccountType,
/* harmony export */   "ct_ajax_setAccountType_update": () => /* binding */ ct_ajax_setAccountType_update,
/* harmony export */   "ct_ajax_agency_update": () => /* binding */ ct_ajax_agency_update,
/* harmony export */   "ct_ajax_accountCodeLedger_store": () => /* binding */ ct_ajax_accountCodeLedger_store,
/* harmony export */   "ct_ajax_criterionAllocate_index": () => /* binding */ ct_ajax_criterionAllocate_index,
/* harmony export */   "ct_ajax_criterionAllocate_update": () => /* binding */ ct_ajax_criterionAllocate_update,
/* harmony export */   "ct_ajax_taxMedicine_index": () => /* binding */ ct_ajax_taxMedicine_index,
/* harmony export */   "ct_ajax_taxMedicine_store": () => /* binding */ ct_ajax_taxMedicine_store,
/* harmony export */   "ct_ajax_taxMedicine_determine": () => /* binding */ ct_ajax_taxMedicine_determine,
/* harmony export */   "ct_ajax_taxMedicine_notDetermine": () => /* binding */ ct_ajax_taxMedicine_notDetermine,
/* harmony export */   "ct_ajax_taxMedicine_update": () => /* binding */ ct_ajax_taxMedicine_update,
/* harmony export */   "ct_ajax_taxMedicine_show": () => /* binding */ ct_ajax_taxMedicine_show,
/* harmony export */   "ct_ajax_purchasePriceInfo_index": () => /* binding */ ct_ajax_purchasePriceInfo_index,
/* harmony export */   "ct_ajax_purchasePriceInfo_store": () => /* binding */ ct_ajax_purchasePriceInfo_store,
/* harmony export */   "ct_ajax_purchasePriceInfo_updateLine": () => /* binding */ ct_ajax_purchasePriceInfo_updateLine,
/* harmony export */   "ct_ajax_purchasePriceInfo_updateStatus": () => /* binding */ ct_ajax_purchasePriceInfo_updateStatus,
/* harmony export */   "pm_ajax_additiveInventoryAlert_index": () => /* binding */ pm_ajax_additiveInventoryAlert_index,
/* harmony export */   "pm_ajax_additiveInventoryAlert_store": () => /* binding */ pm_ajax_additiveInventoryAlert_store,
/* harmony export */   "pm_ajax_additiveInventoryAlert_getTypeOrder": () => /* binding */ pm_ajax_additiveInventoryAlert_getTypeOrder,
/* harmony export */   "pm_ajax_additiveInventoryAlert_saveReportNumber": () => /* binding */ pm_ajax_additiveInventoryAlert_saveReportNumber,
/* harmony export */   "pm_ajax_additiveInventoryAlert_productLists": () => /* binding */ pm_ajax_additiveInventoryAlert_productLists,
/* harmony export */   "pm_ajax_rawMaterialInventoryAlert_index": () => /* binding */ pm_ajax_rawMaterialInventoryAlert_index,
/* harmony export */   "pm_ajax_rawMaterialInventoryAlert_store": () => /* binding */ pm_ajax_rawMaterialInventoryAlert_store,
/* harmony export */   "pm_ajax_rawMaterialInventoryAlert_productLists": () => /* binding */ pm_ajax_rawMaterialInventoryAlert_productLists,
/* harmony export */   "pm_ajax_rawMaterialReport_index": () => /* binding */ pm_ajax_rawMaterialReport_index,
/* harmony export */   "pm_ajax_rawMaterialReport_updateFlag": () => /* binding */ pm_ajax_rawMaterialReport_updateFlag,
/* harmony export */   "pm_ajax_rawMaterialList_index": () => /* binding */ pm_ajax_rawMaterialList_index,
/* harmony export */   "pm_ajax_rawMaterialList_find": () => /* binding */ pm_ajax_rawMaterialList_find,
/* harmony export */   "pm_ajax_rawMaterialList_imageUpload": () => /* binding */ pm_ajax_rawMaterialList_imageUpload,
/* harmony export */   "pm_ajax_rawMaterialList_imageRemove": () => /* binding */ pm_ajax_rawMaterialList_imageRemove,
/* harmony export */   "pm_ajax_rawMaterialList_store": () => /* binding */ pm_ajax_rawMaterialList_store,
/* harmony export */   "pm_rawMaterialList_index": () => /* binding */ pm_rawMaterialList_index,
/* harmony export */   "pm_rawMaterialList_requestRawMaterial": () => /* binding */ pm_rawMaterialList_requestRawMaterial,
/* harmony export */   "pm_rawMaterialList_informRawMaterial": () => /* binding */ pm_rawMaterialList_informRawMaterial,
/* harmony export */   "pm_rawMaterialReport_index": () => /* binding */ pm_rawMaterialReport_index,
/* harmony export */   "pm_ajax_store": () => /* binding */ pm_ajax_store,
/* harmony export */   "pm_ajax_update": () => /* binding */ pm_ajax_update,
/* harmony export */   "pm_ajax_getListItemConvUomV": () => /* binding */ pm_ajax_getListItemConvUomV,
/* harmony export */   "pm_requestRawMaterials_": () => /* binding */ pm_requestRawMaterials_,
/* harmony export */   "pm_ajax_wipLossQuantity_lines": () => /* binding */ pm_ajax_wipLossQuantity_lines,
/* harmony export */   "pm_ajax_wipLossQuantity_store": () => /* binding */ pm_ajax_wipLossQuantity_store,
/* harmony export */   "pm_wipLossQuantity_index": () => /* binding */ pm_wipLossQuantity_index,
/* harmony export */   "report_ajax_getReportPrograms": () => /* binding */ report_ajax_getReportPrograms,
/* harmony export */   "report_reportInfo_index": () => /* binding */ report_reportInfo_index,
/* harmony export */   "report_reportInfo_report_index": () => /* binding */ report_reportInfo_report_index,
/* harmony export */   "report_reportInfo_report_export": () => /* binding */ report_reportInfo_report_export,
/* harmony export */   "report_reportInfo_report_getParam": () => /* binding */ report_reportInfo_report_getParam,
/* harmony export */   "pm_ajax_pmp0031_process": () => /* binding */ pm_ajax_pmp0031_process,
/* harmony export */   "pm_ajax_getSaleForecasts": () => /* binding */ pm_ajax_getSaleForecasts,
/* harmony export */   "pm_ajax_getBiweeklies": () => /* binding */ pm_ajax_getBiweeklies,
/* harmony export */   "pm_ajax_pmp0031_openJob": () => /* binding */ pm_ajax_pmp0031_openJob,
/* harmony export */   "pm_pmp0031_index": () => /* binding */ pm_pmp0031_index,
/* harmony export */   "om_claim_claimApprove_index": () => /* binding */ om_claim_claimApprove_index,
/* harmony export */   "om_claim_requestForChange_requestForChange": () => /* binding */ om_claim_requestForChange_requestForChange,
/* harmony export */   "om_claim_requestForChange_requestPdf": () => /* binding */ om_claim_requestForChange_requestPdf,
/* harmony export */   "om_claim_requestForChange_requestClaimPdf": () => /* binding */ om_claim_requestForChange_requestClaimPdf,
/* harmony export */   "om_api_getClaimNumber": () => /* binding */ om_api_getClaimNumber,
/* harmony export */   "om_api_getListHeader": () => /* binding */ om_api_getListHeader,
/* harmony export */   "om_api_claimStatusList": () => /* binding */ om_api_claimStatusList,
/* harmony export */   "om_api_get_claimStatusList": () => /* binding */ om_api_get_claimStatusList,
/* harmony export */   "om_api_updateHeader": () => /* binding */ om_api_updateHeader,
/* harmony export */   "om_api_closeHeaderClaim": () => /* binding */ om_api_closeHeaderClaim,
/* harmony export */   "om_api_get_listInvoice": () => /* binding */ om_api_get_listInvoice,
/* harmony export */   "om_api_get_genarateClaimDoc": () => /* binding */ om_api_get_genarateClaimDoc,
/* harmony export */   "api_om_": () => /* binding */ api_om_
/* harmony export */ });
/* harmony import */ var _routes_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./routes.json */ "./resources/js/routes.json");

function $route() {
  var routeName = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
  var replacements = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  if (routeName == null) return _routes_json__WEBPACK_IMPORTED_MODULE_0__;
  var uri = _routes_json__WEBPACK_IMPORTED_MODULE_0__[routeName];

  if (uri === undefined) {
    console.error('Cannot find route:', routeName);
    throw new Exception("Cannot find route: ".concat(routeName));
  }

  Object.keys(replacements).forEach(function (key) {
    return uri = uri.replace(new RegExp('{' + key + '\\??}'), replacements[key]);
  }); // finally, remove any leftover optional parameters (inc leading slash)

  return uri.replace(/\/{[a-zA-Z]+\?}/, '');
} //=== generate ===

var debugbar_openhandler = 'debugbar.openhandler'; //uri: /_debugbar/open -> Barryvdh\Debugbar\Controllers\OpenHandlerController.handle()

var debugbar_clockwork = 'debugbar.clockwork'; //uri: /_debugbar/clockwork/{id} -> Barryvdh\Debugbar\Controllers\OpenHandlerController.clockwork()

var debugbar_telescope = 'debugbar.telescope'; //uri: /_debugbar/telescope/{id} -> Barryvdh\Debugbar\Controllers\TelescopeController.show()

var debugbar_assets_css = 'debugbar.assets.css'; //uri: /_debugbar/assets/stylesheets -> Barryvdh\Debugbar\Controllers\AssetController.css()

var debugbar_assets_js = 'debugbar.assets.js'; //uri: /_debugbar/assets/javascript -> Barryvdh\Debugbar\Controllers\AssetController.js()

var debugbar_cache_delete = 'debugbar.cache.delete'; //uri: /_debugbar/cache/{key}/{tags?} -> Barryvdh\Debugbar\Controllers\CacheController.delete()

var horizon_stats_index = 'horizon.stats.index'; //uri: /horizon/api/stats -> Laravel\Horizon\Http\Controllers\DashboardStatsController.index()

var horizon_workload_index = 'horizon.workload.index'; //uri: /horizon/api/workload -> Laravel\Horizon\Http\Controllers\WorkloadController.index()

var horizon_masters_index = 'horizon.masters.index'; //uri: /horizon/api/masters -> Laravel\Horizon\Http\Controllers\MasterSupervisorController.index()

var horizon_monitoring_index = 'horizon.monitoring.index'; //uri: /horizon/api/monitoring -> Laravel\Horizon\Http\Controllers\MonitoringController.index()

var horizon_monitoring_store = 'horizon.monitoring.store'; //uri: /horizon/api/monitoring -> Laravel\Horizon\Http\Controllers\MonitoringController.store()

var horizon_monitoringTag_paginate = 'horizon.monitoring-tag.paginate'; //uri: /horizon/api/monitoring/{tag} -> Laravel\Horizon\Http\Controllers\MonitoringController.paginate()

var horizon_monitoringTag_destroy = 'horizon.monitoring-tag.destroy'; //uri: /horizon/api/monitoring/{tag} -> Laravel\Horizon\Http\Controllers\MonitoringController.destroy()

var horizon_jobsMetrics_index = 'horizon.jobs-metrics.index'; //uri: /horizon/api/metrics/jobs -> Laravel\Horizon\Http\Controllers\JobMetricsController.index()

var horizon_jobsMetrics_show = 'horizon.jobs-metrics.show'; //uri: /horizon/api/metrics/jobs/{id} -> Laravel\Horizon\Http\Controllers\JobMetricsController.show()

var horizon_queuesMetrics_index = 'horizon.queues-metrics.index'; //uri: /horizon/api/metrics/queues -> Laravel\Horizon\Http\Controllers\QueueMetricsController.index()

var horizon_queuesMetrics_show = 'horizon.queues-metrics.show'; //uri: /horizon/api/metrics/queues/{id} -> Laravel\Horizon\Http\Controllers\QueueMetricsController.show()

var horizon_jobsBatches_index = 'horizon.jobs-batches.index'; //uri: /horizon/api/batches -> Laravel\Horizon\Http\Controllers\BatchesController.index()

var horizon_jobsBatches_show = 'horizon.jobs-batches.show'; //uri: /horizon/api/batches/{id} -> Laravel\Horizon\Http\Controllers\BatchesController.show()

var horizon_jobsBatches_retry = 'horizon.jobs-batches.retry'; //uri: /horizon/api/batches/retry/{id} -> Laravel\Horizon\Http\Controllers\BatchesController.retry()

var horizon_pendingJobs_index = 'horizon.pending-jobs.index'; //uri: /horizon/api/jobs/pending -> Laravel\Horizon\Http\Controllers\PendingJobsController.index()

var horizon_completedJobs_index = 'horizon.completed-jobs.index'; //uri: /horizon/api/jobs/completed -> Laravel\Horizon\Http\Controllers\CompletedJobsController.index()

var horizon_failedJobs_index = 'horizon.failed-jobs.index'; //uri: /horizon/api/jobs/failed -> Laravel\Horizon\Http\Controllers\FailedJobsController.index()

var horizon_failedJobs_show = 'horizon.failed-jobs.show'; //uri: /horizon/api/jobs/failed/{id} -> Laravel\Horizon\Http\Controllers\FailedJobsController.show()

var horizon_retryJobs_show = 'horizon.retry-jobs.show'; //uri: /horizon/api/jobs/retry/{id} -> Laravel\Horizon\Http\Controllers\RetryController.store()

var horizon_jobs_show = 'horizon.jobs.show'; //uri: /horizon/api/jobs/{id} -> Laravel\Horizon\Http\Controllers\JobsController.show()

var horizon_index = 'horizon.index'; //uri: /horizon/{view?} -> Laravel\Horizon\Http\Controllers\HomeController.index()

var ajax_pm_plans_yearly_getInfo = 'ajax.pm.plans.yearly.get-info'; //uri: /ajax/pm/plans/yearly/get-info -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getInfo()

var ajax_pm_plans_yearly_getSourceVersions = 'ajax.pm.plans.yearly.get-source-versions'; //uri: /ajax/pm/plans/yearly/get-source-versions -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getSourceVersions()

var ajax_pm_plans_yearly_addNewHeader = 'ajax.pm.plans.yearly.add-new-header'; //uri: /ajax/pm/plans/yearly/add-new-header -> App\Http\Controllers\PM\Ajax\PlanYearlyController.addNewHeader()

var ajax_pm_plans_yearly_getSalePlans = 'ajax.pm.plans.yearly.get-sale-plans'; //uri: /ajax/pm/plans/yearly/get-sale-plans -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getSalePlans()

var ajax_pm_plans_yearly_getLines = 'ajax.pm.plans.yearly.get-lines'; //uri: /ajax/pm/plans/yearly/get-lines -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getLines()

var ajax_pm_plans_yearly_generateLines = 'ajax.pm.plans.yearly.generate-lines'; //uri: /ajax/pm/plans/yearly/generate-lines -> App\Http\Controllers\PM\Ajax\PlanYearlyController.generateLines()

var ajax_pm_plans_yearly_storeLines = 'ajax.pm.plans.yearly.store-lines'; //uri: /ajax/pm/plans/yearly/store-lines -> App\Http\Controllers\PM\Ajax\PlanYearlyController.storeLines()

var ajax_pm_plans_yearly_submitApproval = 'ajax.pm.plans.yearly.submit-approval'; //uri: /ajax/pm/plans/yearly/submit-approval -> App\Http\Controllers\PM\Ajax\PlanYearlyController.submitApproval()

var ajax_pm_plans_yearly_submitPlan = 'ajax.pm.plans.yearly.submit-plan'; //uri: /ajax/pm/plans/yearly/submit-plan -> App\Http\Controllers\PM\Ajax\PlanYearlyController.submitPlan()

var ajax_pm_plans_yearly_approve = 'ajax.pm.plans.yearly.approve'; //uri: /ajax/pm/plans/yearly/approve -> App\Http\Controllers\PM\Ajax\PlanYearlyController.approve()

var ajax_pm_plans_yearly_reject = 'ajax.pm.plans.yearly.reject'; //uri: /ajax/pm/plans/yearly/reject -> App\Http\Controllers\PM\Ajax\PlanYearlyController.reject()

var ajax_pm_plans_monthly_getInfo = 'ajax.pm.plans.monthly.get-info'; //uri: /ajax/pm/plans/monthly/get-info -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.getInfo()

var ajax_pm_plans_monthly_getSourceVersions = 'ajax.pm.plans.monthly.get-source-versions'; //uri: /ajax/pm/plans/monthly/get-source-versions -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.getSourceVersions()

var ajax_pm_plans_monthly_addNewHeader = 'ajax.pm.plans.monthly.add-new-header'; //uri: /ajax/pm/plans/monthly/add-new-header -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.addNewHeader()

var ajax_pm_plans_monthly_getMonths = 'ajax.pm.plans.monthly.get-months'; //uri: /ajax/pm/plans/monthly/get-months -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.getMonths()

var ajax_pm_plans_monthly_getSalePlans = 'ajax.pm.plans.monthly.get-sale-plans'; //uri: /ajax/pm/plans/monthly/get-sale-plans -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.getSalePlans()

var ajax_pm_plans_monthly_getLines = 'ajax.pm.plans.monthly.get-lines'; //uri: /ajax/pm/plans/monthly/get-lines -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.getLines()

var ajax_pm_plans_monthly_generateLines = 'ajax.pm.plans.monthly.generate-lines'; //uri: /ajax/pm/plans/monthly/generate-lines -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.generateLines()

var ajax_pm_plans_monthly_storeLines = 'ajax.pm.plans.monthly.store-lines'; //uri: /ajax/pm/plans/monthly/store-lines -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.storeLines()

var ajax_pm_plans_monthly_submitPlan = 'ajax.pm.plans.monthly.submit-plan'; //uri: /ajax/pm/plans/monthly/submit-plan -> App\Http\Controllers\PM\Ajax\PlanMonthlyController.submitPlan()

var ajax_pm_plans_biweekly_getInfo = 'ajax.pm.plans.biweekly.get-info'; //uri: /ajax/pm/plans/biweekly/get-info -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.getInfo()

var ajax_pm_plans_biweekly_getSourceVersions = 'ajax.pm.plans.biweekly.get-source-versions'; //uri: /ajax/pm/plans/biweekly/get-source-versions -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.getSourceVersions()

var ajax_pm_plans_biweekly_addNewHeader = 'ajax.pm.plans.biweekly.add-new-header'; //uri: /ajax/pm/plans/biweekly/add-new-header -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.addNewHeader()

var ajax_pm_plans_biweekly_getMonths = 'ajax.pm.plans.biweekly.get-months'; //uri: /ajax/pm/plans/biweekly/get-months -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.getMonths()

var ajax_pm_plans_biweekly_getBiweeks = 'ajax.pm.plans.biweekly.get-biweeks'; //uri: /ajax/pm/plans/biweekly/get-biweeks -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.getBiweeks()

var ajax_pm_plans_biweekly_getLines = 'ajax.pm.plans.biweekly.get-lines'; //uri: /ajax/pm/plans/biweekly/get-lines -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.getLines()

var ajax_pm_plans_biweekly_generateLines = 'ajax.pm.plans.biweekly.generate-lines'; //uri: /ajax/pm/plans/biweekly/generate-lines -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.generateLines()

var ajax_pm_plans_biweekly_storeLines = 'ajax.pm.plans.biweekly.store-lines'; //uri: /ajax/pm/plans/biweekly/store-lines -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.storeLines()

var ajax_pm_plans_biweekly_submitApproval = 'ajax.pm.plans.biweekly.submit-approval'; //uri: /ajax/pm/plans/biweekly/submit-approval -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.submitApproval()

var ajax_pm_plans_biweekly_submitOpenOrder = 'ajax.pm.plans.biweekly.submit-open-order'; //uri: /ajax/pm/plans/biweekly/submit-open-order -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.submitOpenOrder()

var ajax_pm_plans_biweekly_approve = 'ajax.pm.plans.biweekly.approve'; //uri: /ajax/pm/plans/biweekly/approve -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.approve()

var ajax_pm_plans_biweekly_reject = 'ajax.pm.plans.biweekly.reject'; //uri: /ajax/pm/plans/biweekly/reject -> App\Http\Controllers\PM\Ajax\PlanBiweeklyController.reject()

var ajax_pm_plans_daily_getInfo = 'ajax.pm.plans.daily.get-info'; //uri: /ajax/pm/plans/daily/get-info -> App\Http\Controllers\PM\Ajax\PlanDailyController.getInfo()

var ajax_pm_plans_daily_getSourceVersions = 'ajax.pm.plans.daily.get-source-versions'; //uri: /ajax/pm/plans/daily/get-source-versions -> App\Http\Controllers\PM\Ajax\PlanDailyController.getSourceVersions()

var ajax_pm_plans_daily_addNewHeader = 'ajax.pm.plans.daily.add-new-header'; //uri: /ajax/pm/plans/daily/add-new-header -> App\Http\Controllers\PM\Ajax\PlanDailyController.addNewHeader()

var ajax_pm_plans_daily_getMonths = 'ajax.pm.plans.daily.get-months'; //uri: /ajax/pm/plans/daily/get-months -> App\Http\Controllers\PM\Ajax\PlanDailyController.getMonths()

var ajax_pm_plans_daily_getBiweeks = 'ajax.pm.plans.daily.get-biweeks'; //uri: /ajax/pm/plans/daily/get-biweeks -> App\Http\Controllers\PM\Ajax\PlanDailyController.getBiweeks()

var ajax_pm_plans_daily_getWeeks = 'ajax.pm.plans.daily.get-weeks'; //uri: /ajax/pm/plans/daily/get-weeks -> App\Http\Controllers\PM\Ajax\PlanDailyController.getWeeks()

var ajax_pm_plans_daily_getLines = 'ajax.pm.plans.daily.get-lines'; //uri: /ajax/pm/plans/daily/get-lines -> App\Http\Controllers\PM\Ajax\PlanDailyController.getLines()

var ajax_pm_plans_daily_generateLines = 'ajax.pm.plans.daily.generate-lines'; //uri: /ajax/pm/plans/daily/generate-lines -> App\Http\Controllers\PM\Ajax\PlanDailyController.generateLines()

var ajax_pm_plans_daily_getRemianingItems = 'ajax.pm.plans.daily.get-remianing-items'; //uri: /ajax/pm/plans/daily/get-remianing-items -> App\Http\Controllers\PM\Ajax\PlanDailyController.getRemainingItems()

var ajax_pm_plans_daily_storeLine = 'ajax.pm.plans.daily.store-line'; //uri: /ajax/pm/plans/daily/store-line -> App\Http\Controllers\PM\Ajax\PlanDailyController.storeLine()

var ajax_pm_plans_daily_addNewMachineLine = 'ajax.pm.plans.daily.add-new-machine-line'; //uri: /ajax/pm/plans/daily/add-new-machine-line -> App\Http\Controllers\PM\Ajax\PlanDailyController.addNewMachineLine()

var ajax_pm_plans_daily_addNewLine = 'ajax.pm.plans.daily.add-new-line'; //uri: /ajax/pm/plans/daily/add-new-line -> App\Http\Controllers\PM\Ajax\PlanDailyController.addNewLine()

var ajax_pm_plans_daily_deleteMachineLine = 'ajax.pm.plans.daily.delete-machine-line'; //uri: /ajax/pm/plans/daily/delete-machine-line -> App\Http\Controllers\PM\Ajax\PlanDailyController.deleteMachineLine()

var ajax_pm_plans_daily_deleteLine = 'ajax.pm.plans.daily.delete-line'; //uri: /ajax/pm/plans/daily/delete-line -> App\Http\Controllers\PM\Ajax\PlanDailyController.deleteLine()

var ajax_pm_plans_daily_submitPlan = 'ajax.pm.plans.daily.submit-plan'; //uri: /ajax/pm/plans/daily/submit-plan -> App\Http\Controllers\PM\Ajax\PlanDailyController.submitPlan()

var ajax_pm_products_machineRequests_getRequests = 'ajax.pm.products.machine-requests.get-requests'; //uri: /ajax/pm/products/machine-requests/get-requests -> App\Http\Controllers\PM\Ajax\ProductMachineRequestController.getRequests()

var ajax_pm_products_machineRequests_generateRequests = 'ajax.pm.products.machine-requests.generate-requests'; //uri: /ajax/pm/products/machine-requests/generate-requests -> App\Http\Controllers\PM\Ajax\ProductMachineRequestController.generateRequests()

var ajax_pm_products_machineRequests_storeRequests = 'ajax.pm.products.machine-requests.store-requests'; //uri: /ajax/pm/products/machine-requests/store-requests -> App\Http\Controllers\PM\Ajax\ProductMachineRequestController.storeRequests()

var ajax_pm_products_machineRequests_exportPdf = 'ajax.pm.products.machine-requests.export-pdf'; //uri: /ajax/pm/products/machine-requests/export-pdf -> App\Http\Controllers\PM\Ajax\ProductMachineRequestController.exportPdf()

var ajax_pm_products_transfers_findHeader = 'ajax.pm.products.transfers.find-header'; //uri: /ajax/pm/products/transfers/find-header -> App\Http\Controllers\PM\Ajax\ProductTransferController.findHeader()

var ajax_pm_products_transfers_getHeaders = 'ajax.pm.products.transfers.get-headers'; //uri: /ajax/pm/products/transfers/get-headers -> App\Http\Controllers\PM\Ajax\ProductTransferController.getHeaders()

var ajax_pm_products_transfers_storeHeader = 'ajax.pm.products.transfers.store-header'; //uri: /ajax/pm/products/transfers/store-header -> App\Http\Controllers\PM\Ajax\ProductTransferController.storeHeader()

var ajax_pm_products_transfers_getLines = 'ajax.pm.products.transfers.get-lines'; //uri: /ajax/pm/products/transfers/get-lines -> App\Http\Controllers\PM\Ajax\ProductTransferController.getLines()

var ajax_pm_products_transfers_getConfirmItems = 'ajax.pm.products.transfers.get-confirm-items'; //uri: /ajax/pm/products/transfers/get-confirm-items -> App\Http\Controllers\PM\Ajax\ProductTransferController.getConfirmItems()

var ajax_pm_products_transfers_getOnhands = 'ajax.pm.products.transfers.get-onhands'; //uri: /ajax/pm/products/transfers/get-onhands -> App\Http\Controllers\PM\Ajax\ProductTransferController.getOnhands()

var ajax_pm_products_transfers_storeLines = 'ajax.pm.products.transfers.store-lines'; //uri: /ajax/pm/products/transfers/store-lines -> App\Http\Controllers\PM\Ajax\ProductTransferController.storeLines()

var ajax_pm_products_transfers_confirmRequest = 'ajax.pm.products.transfers.confirm-request'; //uri: /ajax/pm/products/transfers/confirm-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.confirmRequest()

var ajax_pm_products_transfers_discardConfirmedRequest = 'ajax.pm.products.transfers.discard-confirmed-request'; //uri: /ajax/pm/products/transfers/discard-confirmed-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.discardConfirmedRequest()

var ajax_pm_products_transfers_cancelRequest = 'ajax.pm.products.transfers.cancel-request'; //uri: /ajax/pm/products/transfers/cancel-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.cancelRequest()

var ajax_pm_products_transfers_submitRequest = 'ajax.pm.products.transfers.submit-request'; //uri: /ajax/pm/products/transfers/submit-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.submitRequest()

var api_db_lookup = 'api.db.lookup'; //uri: /api/lookup -> App\Http\Controllers\DbLookupController.lookup()

var outstandingTest_index = 'outstanding-test.index'; //uri: /api/outstanding-test -> App\Http\Controllers\OM\Api\OutstandingController.index()

var api_kms_expenseAll = 'api.kms.expense-all'; //uri: /api/kms/expense-all/type/{type}/budget-year/{budgetYear}/period/{periodNo} -> App\Http\Controllers\Api\KmsController.expenseAll()

var api_kms_expenseDept = 'api.kms.expense-dept'; //uri: /api/kms/expense-dept/department/{department}/budget-year/{budgetYear}/period/{periodNo} -> App\Http\Controllers\Api\KmsController.expenseDept()

var api_pd_lookup = 'api.pd.lookup'; //uri: /api/pd/lookup/{table} -> App\Http\Controllers\PM\Api\LookupController.lookupView()

var api_pd_ = 'api.pd.'; //uri: /api/pd/flavor-no -> App\Http\Controllers\PD\Api\InvMaterialItemApiController.index()

var api_pd_flavorNo_search = 'api.pd.flavor-no.search'; //uri: /api/pd/flavor-no/search -> App\Http\Controllers\PD\Api\FlavorNoApiController.search()

var api_pd_flavorNo_store = 'api.pd.flavor-no.store'; //uri: /api/pd/flavor-no/store -> App\Http\Controllers\PD\Api\FlavorNoApiController.store()

var api_pd_invMaterialItem_update = 'api.pd.inv-material-item.update'; //uri: /api/pd/0004/{rawMaterialId} -> App\Http\Controllers\PD\Api\PD0004ApiController.update()

var api_pd_invMaterialItem_create = 'api.pd.inv-material-item.create'; //uri: /api/pd/flavor-no -> App\Http\Controllers\PD\Api\InvMaterialItemApiController.create()

var api_pd_0004_store = 'api.pd.0004.store'; //uri: /api/pd/0004 -> App\Http\Controllers\PD\Api\PD0004ApiController.store()

var api_pd_invMaterialItem_store = 'api.pd.inv-material-item.store'; //uri: /api/pd/0004 -> App\Http\Controllers\PD\Api\PD0004ApiController.store()

var api_pd_0004_show = 'api.pd.0004.show'; //uri: /api/pd/0004/{inventoryItemId} -> App\Http\Controllers\PD\Api\PD0004ApiController.show()

var api_pd_invMaterialItem_show = 'api.pd.inv-material-item.show'; //uri: /api/pd/0004/{inventoryItemId} -> App\Http\Controllers\PD\Api\PD0004ApiController.show()

var api_pd_0004_update = 'api.pd.0004.update'; //uri: /api/pd/0004/{rawMaterialId} -> App\Http\Controllers\PD\Api\PD0004ApiController.update()

var api_pd_0005_search = 'api.pd.0005.search'; //uri: /api/pd/0005 -> App\Http\Controllers\PD\Api\PD0005ApiController.search()

var api_pd_exampleCigarettes_search = 'api.pd.example-cigarettes.search'; //uri: /api/pd/0005 -> App\Http\Controllers\PD\Api\PD0005ApiController.search()

var api_pd_0005_store = 'api.pd.0005.store'; //uri: /api/pd/0005 -> App\Http\Controllers\PD\Api\PD0005ApiController.store()

var api_pd_exampleCigarettes_store = 'api.pd.example-cigarettes.store'; //uri: /api/pd/0005 -> App\Http\Controllers\PD\Api\PD0005ApiController.store()

var api_pd_0005_show = 'api.pd.0005.show'; //uri: /api/pd/0005/{inventoryItemCode} -> App\Http\Controllers\PD\Api\PD0005ApiController.show()

var api_pd_exampleCigarettes_show = 'api.pd.example-cigarettes.show'; //uri: /api/pd/0005/{inventoryItemCode} -> App\Http\Controllers\PD\Api\PD0005ApiController.show()

var api_pd_0005_update = 'api.pd.0005.update'; //uri: /api/pd/0005/{rawMaterialId} -> App\Http\Controllers\PD\Api\PD0005ApiController.update()

var api_pd_exampleCigarettes_update = 'api.pd.example-cigarettes.update'; //uri: /api/pd/0005/{rawMaterialId} -> App\Http\Controllers\PD\Api\PD0005ApiController.update()

var api_pd_0006_blendFormulae_index = 'api.pd.0006.blendFormulae.index'; //uri: /api/pd/0006/blendFormulae -> App\Http\Controllers\PD\Api\PD0006ApiController.index()

var api_pd_createTrialTobaccoFormula_blendFormulae_index = 'api.pd.create-trial-tobacco-formula.blendFormulae.index'; //uri: /api/pd/0006/blendFormulae -> App\Http\Controllers\PD\Api\PD0006ApiController.index()

var api_pd_0006_blendFormulae_show = 'api.pd.0006.blendFormulae.show'; //uri: /api/pd/0006/blendFormulae/{blendId} -> App\Http\Controllers\PD\Api\PD0006ApiController.show()

var api_pd_createTrialTobaccoFormula_blendFormulae_show = 'api.pd.create-trial-tobacco-formula.blendFormulae.show'; //uri: /api/pd/0006/blendFormulae/{blendId} -> App\Http\Controllers\PD\Api\PD0006ApiController.show()

var api_pd_0006_blendFormulae_update = 'api.pd.0006.blendFormulae.update'; //uri: /api/pd/0006/blendFormulae/{blendId} -> App\Http\Controllers\PD\Api\PD0006ApiController.update()

var api_pd_createTrialTobaccoFormula_blendFormulae_update = 'api.pd.create-trial-tobacco-formula.blendFormulae.update'; //uri: /api/pd/0006/blendFormulae/{blendId} -> App\Http\Controllers\PD\Api\PD0006ApiController.update()

var api_pd_0006_mfgFormulae_show = 'api.pd.0006.mfgFormulae.show'; //uri: /api/pd/0006/mfgFormulae -> App\Http\Controllers\PD\Api\PD0006ApiController.getMfgFormulae()

var api_pd_createTrialTobaccoFormula_mfgFormulae_show = 'api.pd.create-trial-tobacco-formula.mfgFormulae.show'; //uri: /api/pd/0006/mfgFormulae -> App\Http\Controllers\PD\Api\PD0006ApiController.getMfgFormulae()

var api_pd_0006_leafFormulae_show = 'api.pd.0006.leafFormulae.show'; //uri: /api/pd/0006/leafFormulae -> App\Http\Controllers\PD\Api\PD0006ApiController.getLeafFormulae()

var api_pd_createTrialTobaccoFormula_leafFormulae_show = 'api.pd.create-trial-tobacco-formula.leafFormulae.show'; //uri: /api/pd/0006/leafFormulae -> App\Http\Controllers\PD\Api\PD0006ApiController.getLeafFormulae()

var api_pd_0006_lookupItemNumbers_show = 'api.pd.0006.lookupItemNumbers.show'; //uri: /api/pd/0006/lookupItemNumbers -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupItemNumbers()

var api_pd_createTrialTobaccoFormula_lookupItemNumbers_show = 'api.pd.create-trial-tobacco-formula.lookupItemNumbers.show'; //uri: /api/pd/0006/lookupItemNumbers -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupItemNumbers()

var api_pd_0006_lookupCasings_show = 'api.pd.0006.lookupCasings.show'; //uri: /api/pd/0006/lookupCasings -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupCasings()

var api_pd_createTrialTobaccoFormula_lookupCasings_show = 'api.pd.create-trial-tobacco-formula.lookupCasings.show'; //uri: /api/pd/0006/lookupCasings -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupCasings()

var api_pd_0006_lookupFlavours_show = 'api.pd.0006.lookupFlavours.show'; //uri: /api/pd/0006/lookupFlavours -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupFlavours()

var api_pd_createTrialTobaccoFormula_lookupFlavours_show = 'api.pd.create-trial-tobacco-formula.lookupFlavours.show'; //uri: /api/pd/0006/lookupFlavours -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupFlavours()

var api_pd_0006_lookupExampleCigarettes_show = 'api.pd.0006.lookupExampleCigarettes.show'; //uri: /api/pd/0006/lookupExampleCigarettes -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupExampleCigarettes()

var api_pd_createTrialTobaccoFormula_lookupExampleCigarettes_show = 'api.pd.create-trial-tobacco-formula.lookupExampleCigarettes.show'; //uri: /api/pd/0006/lookupExampleCigarettes -> App\Http\Controllers\PD\Api\PD0006ApiController.lookupExampleCigarettes()

var api_pd_expandedTobacco_index = 'api.pd.expanded-tobacco.index'; //uri: /api/pd/expanded-tobacco -> App\Http\Controllers\PD\Api\PD0009ApiController.index()

var api_pd_expandedTobacco_create = 'api.pd.expanded-tobacco.create'; //uri: /api/pd/expanded-tobacco/create -> App\Http\Controllers\PD\Api\PD0009ApiController.create()

var api_pd_expandedTobacco_store = 'api.pd.expanded-tobacco.store'; //uri: /api/pd/expanded-tobacco -> App\Http\Controllers\PD\Api\PD0009ApiController.store()

var api_pd_expandedTobacco_show = 'api.pd.expanded-tobacco.show'; //uri: /api/pd/expanded-tobacco/{expanded_tobacco} -> App\Http\Controllers\PD\Api\PD0009ApiController.show()

var api_pd_expandedTobacco_edit = 'api.pd.expanded-tobacco.edit'; //uri: /api/pd/expanded-tobacco/{expanded_tobacco}/edit -> App\Http\Controllers\PD\Api\PD0009ApiController.edit()

var api_pd_expandedTobacco_update = 'api.pd.expanded-tobacco.update'; //uri: /api/pd/expanded-tobacco/{expanded_tobacco} -> App\Http\Controllers\PD\Api\PD0009ApiController.update()

var api_pd_expandedTobacco_destroy = 'api.pd.expanded-tobacco.destroy'; //uri: /api/pd/expanded-tobacco/{expanded_tobacco} -> App\Http\Controllers\PD\Api\PD0009ApiController.destroy()

var api_pd_0009_search = 'api.pd.0009.search'; //uri: /api/pd/0009/search -> App\Http\Controllers\PD\Api\PD0009ApiController.search()

var api_pm_0001_search = 'api.pm.0001.search'; //uri: /api/pm/0001/search -> App\Http\Controllers\PM\Api\PM0001ApiController.search()

var api_pm_productionOrder_search = 'api.pm.production-order.search'; //uri: /api/pm/0001/search -> App\Http\Controllers\PM\Api\PM0001ApiController.search()

var api_pm_0001_uom = 'api.pm.0001.uom'; //uri: /api/pm/0001/uom -> App\Http\Controllers\PM\Api\PM0001ApiController.uom()

var api_pm_productionOrder_uom = 'api.pm.production-order.uom'; //uri: /api/pm/0001/uom -> App\Http\Controllers\PM\Api\PM0001ApiController.uom()

var api_pm_0001_store = 'api.pm.0001.store'; //uri: /api/pm/0001 -> App\Http\Controllers\PM\Api\PM0001ApiController.store()

var api_pm_productionOrder_store = 'api.pm.production-order.store'; //uri: /api/pm/0001 -> App\Http\Controllers\PM\Api\PM0001ApiController.store()

var api_pm_0001_update = 'api.pm.0001.update'; //uri: /api/pm/0001 -> App\Http\Controllers\PM\Api\PM0001ApiController.update()

var api_pm_productionOrder_update = 'api.pm.production-order.update'; //uri: /api/pm/0001 -> App\Http\Controllers\PM\Api\PM0001ApiController.update()

var api_pm_ajax_productionOrder_batchStatus = 'api.pm.ajax.production-order.batchStatus'; //uri: /api/pm/ajax/batchStatus -> App\Http\Controllers\PM\Api\PM0001ApiController.batchStatus()

var api_pm_ajax_productionOrder_jobType = 'api.pm.ajax.production-order.jobType'; //uri: /api/pm/ajax/jobType -> App\Http\Controllers\PM\Api\PM0001ApiController.jobType()

var api_pm_0005_index = 'api.pm.0005.index'; //uri: /api/pm/0005/index/{id?} -> App\Http\Controllers\PM\Api\PM0005ApiController.index()

var api_pm_requestMaterials_index = 'api.pm.request-materials.index'; //uri: /api/pm/0005/index/{id?} -> App\Http\Controllers\PM\Api\PM0005ApiController.index()

var api_pm_0005_lines = 'api.pm.0005.lines'; //uri: /api/pm/0005/lines/{id?} -> App\Http\Controllers\PM\Api\PM0005ApiController.lines()

var api_pm_requestMaterials_lines = 'api.pm.request-materials.lines'; //uri: /api/pm/0005/lines/{id?} -> App\Http\Controllers\PM\Api\PM0005ApiController.lines()

var api_pm_0005_save = 'api.pm.0005.save'; //uri: /api/pm/0005/save -> App\Http\Controllers\PM\Api\PM0005ApiController.save()

var api_pm_requestMaterials_save = 'api.pm.request-materials.save'; //uri: /api/pm/0005/save -> App\Http\Controllers\PM\Api\PM0005ApiController.save()

var api_pm_0005_confirmTransfer = 'api.pm.0005.confirmTransfer'; //uri: /api/pm/0005/confirmTransfer -> App\Http\Controllers\PM\Api\PM0005ApiController.confirmTransfer()

var api_pm_requestMaterials_confirmTransfer = 'api.pm.request-materials.confirmTransfer'; //uri: /api/pm/0005/confirmTransfer -> App\Http\Controllers\PM\Api\PM0005ApiController.confirmTransfer()

var api_pm_00052_index = 'api.pm.0005-2.index'; //uri: /api/pm/0005-2/index/{id?} -> App\Http\Controllers\PM\Api\PM0005_2ApiController.index()

var api_pm_00052_lines = 'api.pm.0005-2.lines'; //uri: /api/pm/0005-2/lines/{id?} -> App\Http\Controllers\PM\Api\PM0005_2ApiController.lines()

var api_pm_00052_save = 'api.pm.0005-2.save'; //uri: /api/pm/0005-2/save -> App\Http\Controllers\PM\Api\PM0005_2ApiController.save()

var api_pm_00052_confirmTransfer = 'api.pm.0005-2.confirmTransfer'; //uri: /api/pm/0005-2/confirmTransfer -> App\Http\Controllers\PM\Api\PM0005_2ApiController.confirmTransfer()

var api_pm_0006_jobs_index = 'api.pm.0006.jobs.index'; //uri: /api/pm/0006/jobs -> App\Http\Controllers\PM\Api\PM0006ApiController.showJobs()

var api_pm_reportProductInProcess_jobs_index = 'api.pm.report-product-in-process.jobs.index'; //uri: /api/pm/0006/jobs -> App\Http\Controllers\PM\Api\PM0006ApiController.showJobs()

var api_pm_0006_jobs_show = 'api.pm.0006.jobs.show'; //uri: /api/pm/0006/jobs/{batchNo} -> App\Http\Controllers\PM\Api\PM0006ApiController.showJob()

var api_pm_reportProductInProcess_jobs_show = 'api.pm.report-product-in-process.jobs.show'; //uri: /api/pm/0006/jobs/{batchNo} -> App\Http\Controllers\PM\Api\PM0006ApiController.showJob()

var api_pm_0006_jobLines_show = 'api.pm.0006.jobLines.show'; //uri: /api/pm/0006/jobLines -> App\Http\Controllers\PM\Api\PM0006ApiController.showJobLines()

var api_pm_reportProductInProcess_jobLines_show = 'api.pm.report-product-in-process.jobLines.show'; //uri: /api/pm/0006/jobLines -> App\Http\Controllers\PM\Api\PM0006ApiController.showJobLines()

var api_pm_0006_jobLines_update = 'api.pm.0006.jobLines.update'; //uri: /api/pm/0006/jobLines -> App\Http\Controllers\PM\Api\PM0006ApiController.updateJobLines()

var api_pm_reportProductInProcess_jobLines_update = 'api.pm.report-product-in-process.jobLines.update'; //uri: /api/pm/0006/jobLines -> App\Http\Controllers\PM\Api\PM0006ApiController.updateJobLines()

var api_pm_0006_importMesData = 'api.pm.0006.importMesData'; //uri: /api/pm/0006/importMesData/{id} -> App\Http\Controllers\PM\Api\PM0006ApiController.importMesData()

var api_pm_reportProductInProcess_importMesData = 'api.pm.report-product-in-process.importMesData'; //uri: /api/pm/0006/importMesData/{id} -> App\Http\Controllers\PM\Api\PM0006ApiController.importMesData()

var api_pm_0007_show = 'api.pm.0007.show'; //uri: /api/pm/0007 -> App\Http\Controllers\PM\Api\PM0007ApiController.show()

var api_pm_cutRawMaterial_show = 'api.pm.cut-raw-material.show'; //uri: /api/pm/0007 -> App\Http\Controllers\PM\Api\PM0007ApiController.show()

var api_pm_0007_lookupTransactionDate = 'api.pm.0007.lookupTransactionDate'; //uri: /api/pm/0007/lookupTransactionDate -> App\Http\Controllers\PM\Api\PM0007ApiController.lookupTransactionDate()

var api_pm_cutRawMaterial_lookupTransactionDate = 'api.pm.cut-raw-material.lookupTransactionDate'; //uri: /api/pm/0007/lookupTransactionDate -> App\Http\Controllers\PM\Api\PM0007ApiController.lookupTransactionDate()

var api_pm_0007_save = 'api.pm.0007.save'; //uri: /api/pm/0007/save -> App\Http\Controllers\PM\Api\PM0007ApiController.save()

var api_pm_cutRawMaterial_save = 'api.pm.cut-raw-material.save'; //uri: /api/pm/0007/save -> App\Http\Controllers\PM\Api\PM0007ApiController.save()

var api_pm_0007_cutIssue = 'api.pm.0007.cutIssue'; //uri: /api/pm/0007/cutIssue -> App\Http\Controllers\PM\Api\PM0007ApiController.cutIssue()

var api_pm_cutRawMaterial_cutIssue = 'api.pm.cut-raw-material.cutIssue'; //uri: /api/pm/0007/cutIssue -> App\Http\Controllers\PM\Api\PM0007ApiController.cutIssue()

var api_pm_ = 'api.pm.'; //uri: /api/pm/transaction-pkg-product -> App\Http\Controllers\PM\API\TransactionPkgProductAPIController.App\Http\Controllers\PM\Api\TransactionPkgProductAPIController()

var api_pm_reviewComplete_index = 'api.pm.review-complete.index'; //uri: /api/pm/review-complete -> App\Http\Controllers\PM\Api\PM0010ApiController.index()

var api_pm_0011_index = 'api.pm.0011.index'; //uri: /api/pm/review-complete -> App\Http\Controllers\PM\Api\PM0010ApiController.index()

var api_pm_reviewComplete_search = 'api.pm.review-complete.search'; //uri: /api/pm/review-complete/search -> App\Http\Controllers\PM\Api\PM0010ApiController.search()

var api_pm_0011_search = 'api.pm.0011.search'; //uri: /api/pm/review-complete/search -> App\Http\Controllers\PM\Api\PM0010ApiController.search()

var api_pm_reviewComplete_save = 'api.pm.review-complete.save'; //uri: /api/pm/review-complete/save -> App\Http\Controllers\PM\Api\PM0010ApiController.save()

var api_pm_0011_save = 'api.pm.0011.save'; //uri: /api/pm/review-complete/save -> App\Http\Controllers\PM\Api\PM0010ApiController.save()

var api_pm_planningJobLines_lines = 'api.pm.planning-job-lines.lines'; //uri: /api/pm/planning-job-lines/lines -> App\Http\Controllers\PM\Api\PM0011ApiController.getLines()

var api_pm_0011_lines = 'api.pm.0011.lines'; //uri: /api/pm/planning-job-lines/lines -> App\Http\Controllers\PM\Api\PM0011ApiController.getLines()

var api_pm_planningJobLines_lookupBlendNo = 'api.pm.planning-job-lines.lookupBlendNo'; //uri: /api/pm/planning-job-lines/lookupBlendNo -> App\Http\Controllers\PM\Api\PM0011ApiController.lookupBlendNo()

var api_pm_0011_lookupBlendNo = 'api.pm.0011.lookupBlendNo'; //uri: /api/pm/planning-job-lines/lookupBlendNo -> App\Http\Controllers\PM\Api\PM0011ApiController.lookupBlendNo()

var api_pm_planningJobLines_updateLines = 'api.pm.planning-job-lines.updateLines'; //uri: /api/pm/planning-job-lines/updateLines -> App\Http\Controllers\PM\Api\PM0011ApiController.updateLines()

var api_pm_0011_updateLines = 'api.pm.0011.updateLines'; //uri: /api/pm/planning-job-lines/updateLines -> App\Http\Controllers\PM\Api\PM0011ApiController.updateLines()

var api_pm_0018_ = 'api.pm.0018.'; //uri: /api/pm/0018 -> App\Http\Controllers\PM\Api\PM0018ApiController.show()

var api_pm_0019_ = 'api.pm.0019.'; //uri: /api/pm/0019/{id} -> App\Http\Controllers\PM\Api\PM0019ApiController.update()

var api_pm_0020_show = 'api.pm.0020.show'; //uri: /api/pm/0020/{id} -> App\Http\Controllers\PM\Api\PM0020ApiController.show()

var api_pm_machineIngredientRequests_show = 'api.pm.machine-ingredient-requests.show'; //uri: /api/pm/0020/{id} -> App\Http\Controllers\PM\Api\PM0020ApiController.show()

var api_pm_0020_update = 'api.pm.0020.update'; //uri: /api/pm/0020/{id} -> App\Http\Controllers\PM\Api\PM0020ApiController.update()

var api_pm_machineIngredientRequests_update = 'api.pm.machine-ingredient-requests.update'; //uri: /api/pm/0020/{id} -> App\Http\Controllers\PM\Api\PM0020ApiController.update()

var api_pm_0020_store = 'api.pm.0020.store'; //uri: /api/pm/0020 -> App\Http\Controllers\PM\Api\PM0020ApiController.store()

var api_pm_machineIngredientRequests_store = 'api.pm.machine-ingredient-requests.store'; //uri: /api/pm/0020 -> App\Http\Controllers\PM\Api\PM0020ApiController.store()

var api_pm_0020_lines = 'api.pm.0020.lines'; //uri: /api/pm/0020/lines -> App\Http\Controllers\PM\Api\PM0020ApiController.deleteLines()

var api_pm_machineIngredientRequests_lines = 'api.pm.machine-ingredient-requests.lines'; //uri: /api/pm/0020/lines -> App\Http\Controllers\PM\Api\PM0020ApiController.deleteLines()

var api_pm_0021_index = 'api.pm.0021.index'; //uri: /api/pm/0021 -> App\Http\Controllers\PM\Api\PM0021ApiController.index()

var api_pm_ingredientRequests_index = 'api.pm.ingredient-requests.index'; //uri: /api/pm/0021 -> App\Http\Controllers\PM\Api\PM0021ApiController.index()

var api_pm_0022_index = 'api.pm.0022.index'; //uri: /api/pm/0022 -> App\Http\Controllers\PM\Api\PM0022ApiController.index()

var api_pm_ingredientPreparationList_index = 'api.pm.ingredient-preparation-list.index'; //uri: /api/pm/0022 -> App\Http\Controllers\PM\Api\PM0022ApiController.index()

var api_pm_0022_reports = 'api.pm.0022.reports'; //uri: /api/pm/0022/reports/{id} -> App\Http\Controllers\PM\Api\PM0022ApiController.showReport()

var api_pm_ingredientPreparationList_reports = 'api.pm.ingredient-preparation-list.reports'; //uri: /api/pm/0022/reports/{id} -> App\Http\Controllers\PM\Api\PM0022ApiController.showReport()

var api_pm_0023_rawMaterials = 'api.pm.0023.rawMaterials'; //uri: /api/pm/0023/rawMaterials/{id} -> App\Http\Controllers\PM\Api\PM0023ApiController.showRawMaterial()

var api_pm_transactionPnkCheckMaterial_rawMaterials = 'api.pm.transaction-pnk-check-material.rawMaterials'; //uri: /api/pm/0023/rawMaterials/{id} -> App\Http\Controllers\PM\Api\PM0023ApiController.showRawMaterial()

var api_pm_0023_compareRawMaterials = 'api.pm.0023.compareRawMaterials'; //uri: /api/pm/0023/compareRawMaterials -> App\Http\Controllers\PM\Api\PM0023ApiController.compareRequestAndOnShelfRawMaterial()

var api_pm_transactionPnkCheckMaterial_compareRawMaterials = 'api.pm.transaction-pnk-check-material.compareRawMaterials'; //uri: /api/pm/0023/compareRawMaterials -> App\Http\Controllers\PM\Api\PM0023ApiController.compareRequestAndOnShelfRawMaterial()

var api_pm_0027_index = 'api.pm.0027.index'; //uri: /api/pm/0027 -> App\Http\Controllers\PM\Api\PM0027ApiController.index()

var api_pm_sampleCigarettes_index = 'api.pm.sample-cigarettes.index'; //uri: /api/pm/0027 -> App\Http\Controllers\PM\Api\PM0027ApiController.index()

var api_pm_0027_show = 'api.pm.0027.show'; //uri: /api/pm/0027/{date} -> App\Http\Controllers\PM\Api\PM0027ApiController.show()

var api_pm_sampleCigarettes_show = 'api.pm.sample-cigarettes.show'; //uri: /api/pm/0027/{date} -> App\Http\Controllers\PM\Api\PM0027ApiController.show()

var api_pm_0027_update = 'api.pm.0027.update'; //uri: /api/pm/0027/{date} -> App\Http\Controllers\PM\Api\PM0027ApiController.update()

var api_pm_sampleCigarettes_update = 'api.pm.sample-cigarettes.update'; //uri: /api/pm/0027/{date} -> App\Http\Controllers\PM\Api\PM0027ApiController.update()

var api_pm_0027_delete = 'api.pm.0027.delete'; //uri: /api/pm/0027 -> App\Http\Controllers\PM\Api\PM0027ApiController.delete()

var api_pm_sampleCigarettes_delete = 'api.pm.sample-cigarettes.delete'; //uri: /api/pm/0027 -> App\Http\Controllers\PM\Api\PM0027ApiController.delete()

var api_pm_0028_getProductByDate = 'api.pm.0028.getProductByDate'; //uri: /api/pm/0028/{date} -> App\Http\Controllers\PM\Api\PM0028ApiController.getProductByDate()

var api_pm_freeProducts_getProductByDate = 'api.pm.free-products.getProductByDate'; //uri: /api/pm/0028/{date} -> App\Http\Controllers\PM\Api\PM0028ApiController.getProductByDate()

var api_pm_0028_update = 'api.pm.0028.update'; //uri: /api/pm/0028/{date} -> App\Http\Controllers\PM\Api\PM0028ApiController.update()

var api_pm_freeProducts_update = 'api.pm.free-products.update'; //uri: /api/pm/0028/{date} -> App\Http\Controllers\PM\Api\PM0028ApiController.update()

var api_pm_0028_deleteLines = 'api.pm.0028.deleteLines'; //uri: /api/pm/0028 -> App\Http\Controllers\PM\Api\PM0028ApiController.deleteLine()

var api_pm_freeProducts_deleteLines = 'api.pm.free-products.deleteLines'; //uri: /api/pm/0028 -> App\Http\Controllers\PM\Api\PM0028ApiController.deleteLine()

var api_pm_0031_index = 'api.pm.0031.index'; //uri: /api/pm/0031 -> App\Http\Controllers\PM\Api\PM0031ApiController.index()

var api_pm_0031_getBatches = 'api.pm.0031.get-batches'; //uri: /api/pm/0031/get-batches -> App\Http\Controllers\PM\Api\PM0031ApiController.getBatches()

var api_pm_0031_getListBatchHeaders = 'api.pm.0031.get-list-batch-headers'; //uri: /api/pm/0031/get-list-batch-headers -> App\Http\Controllers\PM\Api\PM0031ApiController.getListBatchHeaders()

var api_pm_0031_getWipSteps = 'api.pm.0031.get-wip-steps'; //uri: /api/pm/0031/get-wip-steps -> App\Http\Controllers\PM\Api\PM0031ApiController.getWipSteps()

var api_pm_0031_search = 'api.pm.0031.search'; //uri: /api/pm/0031/search -> App\Http\Controllers\PM\Api\PM0031ApiController.search()

var api_pm_0031_save = 'api.pm.0031.save'; //uri: /api/pm/0031/save -> App\Http\Controllers\PM\Api\PM0031ApiController.save()

var api_pm_0032_index = 'api.pm.0032.index'; //uri: /api/pm/0032 -> App\Http\Controllers\PM\Api\PM0032ApiController.index()

var api_pm_stampUsing_index = 'api.pm.stamp-using.index'; //uri: /api/pm/0032 -> App\Http\Controllers\PM\Api\PM0032ApiController.index()

var api_pm_0032_show = 'api.pm.0032.show'; //uri: /api/pm/0032/{stampHeaderId} -> App\Http\Controllers\PM\Api\PM0032ApiController.show()

var api_pm_stampUsing_show = 'api.pm.stamp-using.show'; //uri: /api/pm/0032/{stampHeaderId} -> App\Http\Controllers\PM\Api\PM0032ApiController.show()

var api_pm_0032_store = 'api.pm.0032.store'; //uri: /api/pm/0032 -> App\Http\Controllers\PM\Api\PM0032ApiController.store()

var api_pm_stampUsing_store = 'api.pm.stamp-using.store'; //uri: /api/pm/0032 -> App\Http\Controllers\PM\Api\PM0032ApiController.store()

var api_pm_0032_update = 'api.pm.0032.update'; //uri: /api/pm/0032/{stampHeaderId} -> App\Http\Controllers\PM\Api\PM0032ApiController.update()

var api_pm_stampUsing_update = 'api.pm.stamp-using.update'; //uri: /api/pm/0032/{stampHeaderId} -> App\Http\Controllers\PM\Api\PM0032ApiController.update()

var api_pm_0032_search = 'api.pm.0032.search'; //uri: /api/pm/0032/search -> App\Http\Controllers\PM\Api\PM0032ApiController.search()

var api_pm_stampUsing_search = 'api.pm.stamp-using.search'; //uri: /api/pm/0032/search -> App\Http\Controllers\PM\Api\PM0032ApiController.search()

var api_pm_0032_transferStamp = 'api.pm.0032.transferStamp'; //uri: /api/pm/0032/transfer -> App\Http\Controllers\PM\Api\PM0032ApiController.transferStamp()

var api_pm_stampUsing_transferStamp = 'api.pm.stamp-using.transferStamp'; //uri: /api/pm/0032/transfer -> App\Http\Controllers\PM\Api\PM0032ApiController.transferStamp()

var api_pm_0032_deleteLines = 'api.pm.0032.deleteLines'; //uri: /api/pm/0032/lines -> App\Http\Controllers\PM\Api\PM0032ApiController.deleteLines()

var api_pm_stampUsing_deleteLines = 'api.pm.stamp-using.deleteLines'; //uri: /api/pm/0032/lines -> App\Http\Controllers\PM\Api\PM0032ApiController.deleteLines()

var api_pm_0033_get = 'api.pm.0033.get'; //uri: /api/pm/0033 -> App\Http\Controllers\PM\Api\PM0033ApiController.getIndex()

var api_pm_confirmStampUsing_get = 'api.pm.confirm-stamp-using.get'; //uri: /api/pm/0033 -> App\Http\Controllers\PM\Api\PM0033ApiController.getIndex()

var api_pm_0033_updateStampUsage = 'api.pm.0033.update-stamp-usage'; //uri: /api/pm/0033 -> App\Http\Controllers\PM\Api\PM0033ApiController.updateStampUsage()

var api_pm_confirmStampUsing_updateStampUsage = 'api.pm.confirm-stamp-using.update-stamp-usage'; //uri: /api/pm/0033 -> App\Http\Controllers\PM\Api\PM0033ApiController.updateStampUsage()

var api_pm_0033_useStamp = 'api.pm.0033.use-stamp'; //uri: /api/pm/0033/useStamp -> App\Http\Controllers\PM\Api\PM0033ApiController.useStamp()

var api_pm_confirmStampUsing_useStamp = 'api.pm.confirm-stamp-using.use-stamp'; //uri: /api/pm/0033/useStamp -> App\Http\Controllers\PM\Api\PM0033ApiController.useStamp()

var api_pm_0036_index = 'api.pm.0036.index'; //uri: /api/pm/0036 -> App\Http\Controllers\PM\Api\PM0036ApiController.index()

var api_pm_closeProductOrder_index = 'api.pm.close-product-order.index'; //uri: /api/pm/0036 -> App\Http\Controllers\PM\Api\PM0036ApiController.index()

var api_pm_0036_jobOptRelations = 'api.pm.0036.job-opt-relations'; //uri: /api/pm/0036/jobOptRelations -> App\Http\Controllers\PM\Api\PM0036ApiController.getJobOptRelations()

var api_pm_closeProductOrder_jobOptRelations = 'api.pm.close-product-order.job-opt-relations'; //uri: /api/pm/0036/jobOptRelations -> App\Http\Controllers\PM\Api\PM0036ApiController.getJobOptRelations()

var api_pm_0036_closeBatch = 'api.pm.0036.close-batch'; //uri: /api/pm/0036/closeBatch -> App\Http\Controllers\PM\Api\PM0036ApiController.execCloseBatch()

var api_pm_closeProductOrder_closeBatch = 'api.pm.close-product-order.close-batch'; //uri: /api/pm/0036/closeBatch -> App\Http\Controllers\PM\Api\PM0036ApiController.execCloseBatch()

var api_pm_0038_ = 'api.pm.0038.'; //uri: /api/pm/0038/close-job -> App\Http\Controllers\PM\Api\PM0038ApiController.close_job()

var api_pm_0038_cancelCloseJob = 'api.pm.0038.cancel-close-job'; //uri: /api/pm/0038/cancel-close-job -> App\Http\Controllers\PM\Api\PM0038ApiController.cancelCloseJob()

var api_pm_0038_productDetail = 'api.pm.0038.product-detail'; //uri: /api/pm/0038/product-detail -> App\Http\Controllers\PM\Api\PM0038ApiController.productDetail()

var api_pm_0041_index = 'api.pm.0041.index'; //uri: /api/pm/0041 -> App\Http\Controllers\PM\Api\PM0041ApiController.index()

var api_pm_examineCasingAfterExpiryDate_index = 'api.pm.examine-casing-after-expiry-date.index'; //uri: /api/pm/0041 -> App\Http\Controllers\PM\Api\PM0041ApiController.index()

var api_pm_0041_updateExamineCasing = 'api.pm.0041.updateExamineCasing'; //uri: /api/pm/0041/updateExamineCasing -> App\Http\Controllers\PM\Api\PM0041ApiController.updateExamineCasing()

var api_pm_examineCasingAfterExpiryDate_updateExamineCasing = 'api.pm.examine-casing-after-expiry-date.updateExamineCasing'; //uri: /api/pm/0041/updateExamineCasing -> App\Http\Controllers\PM\Api\PM0041ApiController.updateExamineCasing()

var api_pm_0041_updateExpirationDate = 'api.pm.0041.updateExpirationDate'; //uri: /api/pm/0041/updateExpirationDate -> App\Http\Controllers\PM\Api\PM0041ApiController.updateExpirationDate()

var api_pm_examineCasingAfterExpiryDate_updateExpirationDate = 'api.pm.examine-casing-after-expiry-date.updateExpirationDate'; //uri: /api/pm/0041/updateExpirationDate -> App\Http\Controllers\PM\Api\PM0041ApiController.updateExpirationDate()

var api_pm_0042_index = 'api.pm.0042.index'; //uri: /api/pm/0042 -> App\Http\Controllers\PM\Api\PM0042ApiController.index()

var api_pm_0042_approveRequest = 'api.pm.0042.approveRequest'; //uri: /api/pm/0042/approveRequest -> App\Http\Controllers\PM\Api\PM0042ApiController.approveRequest()

var api_pm_0042_rejectRequest = 'api.pm.0042.rejectRequest'; //uri: /api/pm/0042/rejectRequest -> App\Http\Controllers\PM\Api\PM0042ApiController.rejectRequest()

var api_pm_0043_ = 'api.pm.0043.'; //uri: /api/pm/0043 -> App\Http\Controllers\PM\Api\PM0043ApiController.destroy()

var api_pm_0045_approveRequest = 'api.pm.0045.approveRequest'; //uri: /api/pm/0045/approveRequest -> App\Http\Controllers\PM\Api\PM0045ApiController.approveRequest()

var api_pm_examineAfterManufactured_approveRequest = 'api.pm.examine-after-manufactured.approveRequest'; //uri: /api/pm/0045/approveRequest -> App\Http\Controllers\PM\Api\PM0045ApiController.approveRequest()

var api_pm_0045_cancelRequest = 'api.pm.0045.cancelRequest'; //uri: /api/pm/0045/cancelRequest -> App\Http\Controllers\PM\Api\PM0045ApiController.cancelRequest()

var api_pm_examineAfterManufactured_cancelRequest = 'api.pm.examine-after-manufactured.cancelRequest'; //uri: /api/pm/0045/cancelRequest -> App\Http\Controllers\PM\Api\PM0045ApiController.cancelRequest()

var api_pm_0045_ = 'api.pm.0045.'; //uri: /api/pm/0045/{id} -> App\Http\Controllers\PM\Api\PM0045ApiController.update()

var api_pm_examineAfterManufactured_ = 'api.pm.examine-after-manufactured.'; //uri: /api/pm/0045/{id} -> App\Http\Controllers\PM\Api\PM0045ApiController.update()

var api_pm_test_pat_get = 'api.pm.test/pat.get'; //uri: /api/pm/test/pat -> App\Http\Controllers\PM\Api\TestPatController.get()

var ajax_roles_getMenuByModule = 'ajax.roles.get-menu-by-module'; //uri: /ajax/roles/get-menu-by-module -> App\Http\Controllers\Ajax\RoleController.getMenuByModule()

var ajax_roles_getPermission = 'ajax.roles.get-permission'; //uri: /ajax/roles/get-permission -> App\Http\Controllers\Ajax\RoleController.getPermission()

var ajax_roles_assignPermission = 'ajax.roles.assign-permission'; //uri: /ajax/roles/{role}/assign-permission -> App\Http\Controllers\Ajax\RoleController.assignPermission()

var ajax_roles_store = 'ajax.roles.store'; //uri: /ajax/roles -> App\Http\Controllers\Ajax\RoleController.store()

var ajax_roles_update = 'ajax.roles.update'; //uri: /ajax/roles/{role} -> App\Http\Controllers\Ajax\RoleController.update()

var ajax_users_store = 'ajax.users.store'; //uri: /ajax/users -> App\Http\Controllers\Ajax\UserController.store()

var ajax_users_update = 'ajax.users.update'; //uri: /ajax/users/{user} -> App\Http\Controllers\Ajax\UserController.update()

var ajax_users_getUser = 'ajax.users.get-user'; //uri: /ajax/users/get-user -> App\Http\Controllers\Ajax\UserController.getUser()

var ajax_users_getDepartment = 'ajax.users.get-department'; //uri: /ajax/users/get-department -> App\Http\Controllers\Ajax\UserController.getDepartment()

var ajax_users_getOaUser = 'ajax.users.get-oa-user'; //uri: /ajax/users/get-oa-user -> App\Http\Controllers\Ajax\UserController.getOaUser()

var ajax_users_getRole = 'ajax.users.get-role'; //uri: /ajax/users/get-role -> App\Http\Controllers\Ajax\UserController.getRole()

var menus_index = 'menus.index'; //uri: /menus -> App\Http\Controllers\MenuController.index()

var menus_create = 'menus.create'; //uri: /menus/create -> App\Http\Controllers\MenuController.create()

var menus_store = 'menus.store'; //uri: /menus -> App\Http\Controllers\MenuController.store()

var menus_edit = 'menus.edit'; //uri: /menus/{menu}/edit -> App\Http\Controllers\MenuController.edit()

var menus_update = 'menus.update'; //uri: /menus/{menu} -> App\Http\Controllers\MenuController.update()

var users_permissions = 'users.permissions'; //uri: /users/{user}/permissions -> App\Http\Controllers\UserController.permissions()

var users_assignPermission = 'users.assign-permission'; //uri: /users/{user}/assign-permission -> App\Http\Controllers\UserController.assignPermission()

var users_changeDeparment = 'users.change-deparment'; //uri: /users/{user}/change-deparment -> App\Http\Controllers\UserController.changeDeparment()

var users_changeOrg = 'users.change-org'; //uri: /users/{user}/change-org -> App\Http\Controllers\UserController.changeOrg()

var users_index = 'users.index'; //uri: /users -> App\Http\Controllers\UserController.index()

var users_create = 'users.create'; //uri: /users/create -> App\Http\Controllers\UserController.create()

var users_edit = 'users.edit'; //uri: /users/{user}/edit -> App\Http\Controllers\UserController.edit()

var roles_index = 'roles.index'; //uri: /roles -> App\Http\Controllers\RoleController.index()

var roles_create = 'roles.create'; //uri: /roles/create -> App\Http\Controllers\RoleController.create()

var roles_edit = 'roles.edit'; //uri: /roles/{role}/edit -> App\Http\Controllers\RoleController.edit()

var home = 'home'; //uri: /home -> App\Http\Controllers\HomeController.index()

var funds_index = 'funds.index'; //uri: /inquiry-funds -> App\Http\Controllers\Budget\InquiryFundsController.index()

var funds_show = 'funds.show'; //uri: /inquiry-funds -> App\Http\Controllers\Budget\Ajax\InquiryFundsController.getInquriyFunds()

var program_type_index = 'program.type.index'; //uri: /program/type -> App\Http\Controllers\Program\ProgramTypeController.index()

var program_type_create = 'program.type.create'; //uri: /program/type/create -> App\Http\Controllers\Program\ProgramTypeController.create()

var program_type_store = 'program.type.store'; //uri: /program/type -> App\Http\Controllers\Program\ProgramTypeController.store()

var program_type_edit = 'program.type.edit'; //uri: /program/type/{program_type}/edit -> App\Http\Controllers\Program\ProgramTypeController.edit()

var program_type_update = 'program.type.update'; //uri: /program/type/update -> App\Http\Controllers\Program\ProgramTypeController.update()

var program_info_index = 'program.info.index'; //uri: /program/info -> App\Http\Controllers\Program\ProgramInfoController.index()

var program_info_create = 'program.info.create'; //uri: /program/info/create -> App\Http\Controllers\Program\ProgramInfoController.create()

var program_info_store = 'program.info.store'; //uri: /program/info -> App\Http\Controllers\Program\ProgramInfoController.store()

var program_info_edit = 'program.info.edit'; //uri: /program/info/{program_code}/edit -> App\Http\Controllers\Program\ProgramInfoController.edit()

var program_info_update = 'program.info.update'; //uri: /program/info/update -> App\Http\Controllers\Program\ProgramInfoController.update()

var lookup_index = 'lookup.index'; //uri: /lookup -> App\Http\Controllers\LookupController.index()

var lookup_create = 'lookup.create'; //uri: /lookup/create -> App\Http\Controllers\LookupController.create()

var lookup_store = 'lookup.store'; //uri: /lookup -> App\Http\Controllers\LookupController.store()

var lookup_edit = 'lookup.edit'; //uri: /lookup/{lookup}/edit -> App\Http\Controllers\LookupController.edit()

var lookup_update = 'lookup.update'; //uri: /lookup/{lookup} -> App\Http\Controllers\LookupController.update()

var lookup_delete = 'lookup.delete'; //uri: /lookup/{lookup} -> App\Http\Controllers\LookupController.destroy()

var setUp_index = 'set-up.index'; //uri: /set-up -> App\Http\Controllers\PD\Settings\ProgramColumnController.index()

var setUp_show = 'set-up.show'; //uri: /set-up/{program_code}/show -> App\Http\Controllers\PD\Settings\ProgramColumnController.show()

var setUp_update = 'set-up.update'; //uri: /set-up/{program_code}/{column_name} -> App\Http\Controllers\PD\Settings\ProgramColumnController.update()

var runningNumber_index = 'running-number.index'; //uri: /running-number -> App\Http\Controllers\RunningNumberController.index()

var runningNumber_create = 'running-number.create'; //uri: /running-number/create -> App\Http\Controllers\RunningNumberController.create()

var runningNumber_store = 'running-number.store'; //uri: /running-number -> App\Http\Controllers\RunningNumberController.store()

var runningNumber_edit = 'running-number.edit'; //uri: /running-number/{running_number}/edit -> App\Http\Controllers\RunningNumberController.edit()

var runningNumber_update = 'running-number.update'; //uri: /running-number/{running_number} -> App\Http\Controllers\RunningNumberController.update()

var logout = 'logout'; //uri: /logout -> App\Http\Controllers\Auth\LoginController.logout()

var login = 'login'; //uri: /login -> App\Http\Controllers\Auth\LoginController.showLoginForm()

var register = 'register'; //uri: /register -> App\Http\Controllers\Auth\RegisterController.showRegistrationForm()

var password_request = 'password.request'; //uri: /password/reset -> App\Http\Controllers\Auth\ForgotPasswordController.showLinkRequestForm()

var password_email = 'password.email'; //uri: /password/email -> App\Http\Controllers\Auth\ForgotPasswordController.sendResetLinkEmail()

var password_reset = 'password.reset'; //uri: /password/reset/{token} -> App\Http\Controllers\Auth\ResetPasswordController.showResetForm()

var password_update = 'password.update'; //uri: /password/reset -> App\Http\Controllers\Auth\ResetPasswordController.reset()

var password_confirm = 'password.confirm'; //uri: /password/confirm -> App\Http\Controllers\Auth\ConfirmPasswordController.showConfirmForm()

var example_ajax_users_index = 'example.ajax.users.index'; //uri: /example/ajax/users -> App\Http\Controllers\Example\Ajax\UserController.index()

var example_users_exportExcel = 'example.users.export-excel'; //uri: /example/users/export-excel -> App\Http\Controllers\Example\UserController.exportExcel()

var example_users_exportPdf = 'example.users.export-pdf'; //uri: /example/users/export-pdf -> App\Http\Controllers\Example\UserController.exportPdf()

var example_users_interface = 'example.users.interface'; //uri: /example/users/{user}/interface -> App\Http\Controllers\Example\UserController.interface()

var example_users_interfaceError = 'example.users.interface-error'; //uri: /example/users/interface-error -> App\Http\Controllers\Example\UserController.interfaceError()

var example_users_index = 'example.users.index'; //uri: /example/users -> App\Http\Controllers\Example\UserController.index()

var example_users_create = 'example.users.create'; //uri: /example/users/create -> App\Http\Controllers\Example\UserController.create()

var example_users_store = 'example.users.store'; //uri: /example/users -> App\Http\Controllers\Example\UserController.store()

var example_users_show = 'example.users.show'; //uri: /example/users/{user} -> App\Http\Controllers\Example\UserController.show()

var example_users_edit = 'example.users.edit'; //uri: /example/users/{user}/edit -> App\Http\Controllers\Example\UserController.edit()

var example_users_update = 'example.users.update'; //uri: /example/users/{user} -> App\Http\Controllers\Example\UserController.update()

var example_users_destroy = 'example.users.destroy'; //uri: /example/users/{user} -> App\Http\Controllers\Example\UserController.destroy()

var pd_ajax_ = 'pd.ajax.'; //uri: /pd/ajax/ohhand-tobacco-forewarn/search -> App\Http\Controllers\PD\Settings\Ajax\OhhandTobaccoForewarnController.search()

var pd_settings_simuRawMaterial_index = 'pd.settings.simu-raw-material.index'; //uri: /pd/settings/simu-raw-material -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.index()

var pd_settings_simuRawMaterial_create = 'pd.settings.simu-raw-material.create'; //uri: /pd/settings/simu-raw-material/create -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.create()

var pd_settings_simuRawMaterial_store = 'pd.settings.simu-raw-material.store'; //uri: /pd/settings/simu-raw-material -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.store()

var pd_settings_simuRawMaterial_edit = 'pd.settings.simu-raw-material.edit'; //uri: /pd/settings/simu-raw-material/{simu_raw_id}/edit -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.edit()

var pd_settings_simuRawMaterial_update = 'pd.settings.simu-raw-material.update'; //uri: /pd/settings/simu-raw-material/{simu_raw_id} -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.update()

var pd_settings_simuRawMaterial_delete = 'pd.settings.simu-raw-material.delete'; //uri: /pd/settings/simu-raw-material/{simu_raw_id} -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.destroy()

var pd_settings_simuRawMaterial_createInv = 'pd.settings.simu-raw-material.createInv'; //uri: /pd/settings/simu-raw-material/{simu_raw_id}/create-inv -> App\Http\Controllers\PD\Settings\SimuRawMaterialController.createInv()

var pd_settings_ohhandTobaccoForewarn_index = 'pd.settings.ohhand-tobacco-forewarn.index'; //uri: /pd/settings/ohhand-tobacco-forewarn -> App\Http\Controllers\PD\Settings\OhhandTobaccoForewarnController.index()

var pd_settings_ohhandTobaccoForewarn_store = 'pd.settings.ohhand-tobacco-forewarn.store'; //uri: /pd/settings/ohhand-tobacco-forewarn/store -> App\Http\Controllers\PD\Settings\OhhandTobaccoForewarnController.store()

var pd_settings_ohhandTobaccoForewarn_update = 'pd.settings.ohhand-tobacco-forewarn.update'; //uri: /pd/settings/ohhand-tobacco-forewarn/store/update/{forewarn_id}/{inventory_item_id} -> App\Http\Controllers\PD\Settings\OhhandTobaccoForewarnController.update()

var pd_0001_index = 'pd.0001.index'; //uri: /pd/0001 -> App\Http\Controllers\PD\Web\PD0001Controller.index()

var pd_casingSimuAdditive_index = 'pd.casing-simu-additive.index'; //uri: /pd/0001 -> App\Http\Controllers\PD\Web\PD0001Controller.index()

var pd_0002_index = 'pd.0002.index'; //uri: /pd/0002 -> App\Http\Controllers\PD\Web\PD0002Controller.index()

var pd_flavorSimuAdditive_index = 'pd.flavor-simu-additive.index'; //uri: /pd/0002 -> App\Http\Controllers\PD\Web\PD0002Controller.index()

var pd_0003_index = 'pd.0003.index'; //uri: /pd/0003 -> App\Http\Controllers\PD\Web\PD0003Controller.index()

var pd_pd0003_index = 'pd.pd-0003.index'; //uri: /pd/0003 -> App\Http\Controllers\PD\Web\PD0003Controller.index()

var pd_0004_index = 'pd.0004.index'; //uri: /pd/0004 -> App\Http\Controllers\PD\Web\PD0004Controller.index()

var pd_invMaterialItems_index = 'pd.inv-material-items.index'; //uri: /pd/0004 -> App\Http\Controllers\PD\Web\PD0004Controller.index()

var pd_0004_show = 'pd.0004.show'; //uri: /pd/0004/{inventoryItemId} -> App\Http\Controllers\PD\Web\PD0004Controller.show()

var pd_invMaterialItems_show = 'pd.inv-material-items.show'; //uri: /pd/0004/{inventoryItemId} -> App\Http\Controllers\PD\Web\PD0004Controller.show()

var pd_0005_index = 'pd.0005.index'; //uri: /pd/0005 -> App\Http\Controllers\PD\Web\PD0005Controller.index()

var pd_exampleCigarettes_index = 'pd.example-cigarettes.index'; //uri: /pd/0005 -> App\Http\Controllers\PD\Web\PD0005Controller.index()

var pd_0005_show = 'pd.0005.show'; //uri: /pd/0005/{inventoryItemCode} -> App\Http\Controllers\PD\Web\PD0005Controller.show()

var pd_exampleCigarettes_show = 'pd.example-cigarettes.show'; //uri: /pd/0005/{inventoryItemCode} -> App\Http\Controllers\PD\Web\PD0005Controller.show()

var pd_0006_index = 'pd.0006.index'; //uri: /pd/0006 -> App\Http\Controllers\PD\Web\PD0006Controller.index()

var pd_0006_show = 'pd.0006.show'; //uri: /pd/0006/{blendId} -> App\Http\Controllers\PD\Web\PD0006Controller.show()

var pd_0007_index = 'pd.0007.index'; //uri: /pd/0007 -> App\Http\Controllers\PD\Web\PD0007Controller.index()

var pd_0008_index = 'pd.0008.index'; //uri: /pd/0008 -> App\Http\Controllers\PD\Web\PD0008Controller.index()

var pd_0010_index = 'pd.0010.index'; //uri: /pd/0010 -> App\Http\Controllers\PD\Web\PD0010Controller.index()

var pd_0011_index = 'pd.0011.index'; //uri: /pd/0011 -> App\Http\Controllers\PD\Web\PD0011Controller.index()

var pd_0012_index = 'pd.0012.index'; //uri: /pd/0012 -> App\Http\Controllers\PD\Web\PD0012Controller.index()

var pd_0013_index = 'pd.0013.index'; //uri: /pd/0013 -> App\Http\Controllers\PD\Web\PD0013Controller.index()

var pd_0009_index = 'pd.0009.index'; //uri: /pd/0009/{id?} -> App\Http\Controllers\PD\Web\PD0009Controller.index()

var pd_expandedTobacco_index = 'pd.expanded-tobacco.index'; //uri: /pd/0009/{id?} -> App\Http\Controllers\PD\Web\PD0009Controller.index()

var pd_0009_test = 'pd.0009.test'; //uri: /pd/0009/test -> App\Http\Controllers\PD\Web\PD0009Controller.test()

var pd_expandedTobacco_test = 'pd.expanded-tobacco.test'; //uri: /pd/0009/test -> App\Http\Controllers\PD\Web\PD0009Controller.test()

var pd_0014_index = 'pd.0014.index'; //uri: /pd/0014 -> App\Http\Controllers\PD\Web\PD0014Controller.index()

var pd_pd0014_index = 'pd.pd-0014.index'; //uri: /pd/0014 -> App\Http\Controllers\PD\Web\PD0014Controller.index()

var pm_ajax_ = 'pm.ajax.'; //uri: /pm/ajax/print-machine-group/store -> App\Http\Controllers\PM\Settings\Ajax\PrintMachineGroupController.store()

var pm_ajax_getOrganization = 'pm.ajax.get-organization'; //uri: /pm/ajax/setup-min-max-by-item/get-organization -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getOrganization()

var pm_ajax_getLocations = 'pm.ajax.get-locations'; //uri: /pm/ajax/setup-min-max-by-item/get-locations -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getLocations()

var pm_ajax_getItemNumber = 'pm.ajax.get-item-number'; //uri: /pm/ajax/setup-min-max-by-item/get-item-number -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getItemNumber()

var pm_ajax_getUom = 'pm.ajax.get-uom'; //uri: /pm/ajax/setup-min-max-by-item/get-uom -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getUom()

var pm_ajax_destroy = 'pm.ajax.destroy'; //uri: /pm/ajax/setup-min-max-by-item/destroy -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.destroy()

var pm_ajax_search = 'pm.ajax.search'; //uri: /pm/ajax/setup-min-max-by-item/search -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.search()

var pm_ajax_printConversion_destroy = 'pm.ajax.print-conversion.destroy'; //uri: /pm/ajax/print-conversion/destroy -> App\Http\Controllers\PM\Settings\Ajax\PrintConversionController.destroy()

var pm_ajax_maxStorage_getUom = 'pm.ajax.max-storage.getUom'; //uri: /pm/ajax/max-storage/get-uom -> App\Http\Controllers\PM\Settings\Ajax\MaxStorageController.getUom()

var pm_settings_materialGroup_index = 'pm.settings.material-group.index'; //uri: /pm/settings/material-group -> App\Http\Controllers\PM\Settings\MaterialGroupController.index()

var pm_settings_materialGroup_create = 'pm.settings.material-group.create'; //uri: /pm/settings/material-group/create -> App\Http\Controllers\PM\Settings\MaterialGroupController.create()

var pm_settings_materialGroup_store = 'pm.settings.material-group.store'; //uri: /pm/settings/material-group/store -> App\Http\Controllers\PM\Settings\MaterialGroupController.store()

var pm_settings_relationFeeder_index = 'pm.settings.relation-feeder.index'; //uri: /pm/settings/relation-feeder -> App\Http\Controllers\PM\Settings\RelationFeederController.index()

var pm_settings_relationFeeder_create = 'pm.settings.relation-feeder.create'; //uri: /pm/settings/relation-feeder/create -> App\Http\Controllers\PM\Settings\RelationFeederController.create()

var pm_settings_relationFeeder_store = 'pm.settings.relation-feeder.store'; //uri: /pm/settings/relation-feeder/store -> App\Http\Controllers\PM\Settings\RelationFeederController.store()

var pm_settings_relationFeeder_edit = 'pm.settings.relation-feeder.edit'; //uri: /pm/settings/relation-feeder/{machnie_group}/{feeder_code}/edit -> App\Http\Controllers\PM\Settings\RelationFeederController.edit()

var pm_settings_relationFeeder_update = 'pm.settings.relation-feeder.update'; //uri: /pm/settings/relation-feeder/update -> App\Http\Controllers\PM\Settings\RelationFeederController.update()

var pm_settings_orgTranfer_index = 'pm.settings.org-tranfer.index'; //uri: /pm/settings/org-tranfer -> App\Http\Controllers\PM\Settings\OrgTransferController.index()

var pm_settings_orgTranfer_create = 'pm.settings.org-tranfer.create'; //uri: /pm/settings/org-tranfer/create -> App\Http\Controllers\PM\Settings\OrgTransferController.create()

var pm_settings_orgTranfer_store = 'pm.settings.org-tranfer.store'; //uri: /pm/settings/org-tranfer/store -> App\Http\Controllers\PM\Settings\OrgTransferController.store()

var pm_settings_orgTranfer_edit = 'pm.settings.org-tranfer.edit'; //uri: /pm/settings/org-tranfer/edit/{id} -> App\Http\Controllers\PM\Settings\OrgTransferController.edit()

var pm_settings_orgTranfer_update = 'pm.settings.org-tranfer.update'; //uri: /pm/settings/org-tranfer/update -> App\Http\Controllers\PM\Settings\OrgTransferController.update()

var pm_settings_wipStep_index = 'pm.settings.wip-step.index'; //uri: /pm/settings/wip-step -> App\Http\Controllers\PM\Settings\WipStepController.index()

var pm_settings_wipStep_create = 'pm.settings.wip-step.create'; //uri: /pm/settings/wip-step/create -> App\Http\Controllers\PM\Settings\WipStepController.create()

var pm_settings_wipStep_store = 'pm.settings.wip-step.store'; //uri: /pm/settings/wip-step -> App\Http\Controllers\PM\Settings\WipStepController.store()

var pm_settings_wipStep_edit = 'pm.settings.wip-step.edit'; //uri: /pm/settings/wip-step/{id}/edit -> App\Http\Controllers\PM\Settings\WipStepController.edit()

var pm_settings_wipStep_update = 'pm.settings.wip-step.update'; //uri: /pm/settings/wip-step/{id} -> App\Http\Controllers\PM\Settings\WipStepController.update()

var pm_settings_wipStep_show = 'pm.settings.wip-step.show'; //uri: /pm/settings/wip-step/{id}/show -> App\Http\Controllers\PM\Settings\WipStepController.show()

var pm_settings_productionFormula_index = 'pm.settings.production-formula.index'; //uri: /pm/settings/production-formula -> App\Http\Controllers\PM\Settings\ProductionFormulaController.index()

var pm_settings_productionFormula_create = 'pm.settings.production-formula.create'; //uri: /pm/settings/production-formula/create -> App\Http\Controllers\PM\Settings\ProductionFormulaController.create()

var pm_settings_productionFormula_store = 'pm.settings.production-formula.store'; //uri: /pm/settings/production-formula -> App\Http\Controllers\PM\Settings\ProductionFormulaController.store()

var pm_settings_productionFormula_edit = 'pm.settings.production-formula.edit'; //uri: /pm/settings/production-formula/{id}/edit -> App\Http\Controllers\PM\Settings\ProductionFormulaController.edit()

var pm_settings_productionFormula_update = 'pm.settings.production-formula.update'; //uri: /pm/settings/production-formula/{id} -> App\Http\Controllers\PM\Settings\ProductionFormulaController.update()

var pm_settings_productionFormula_show = 'pm.settings.production-formula.show'; //uri: /pm/settings/production-formula/{id}/show -> App\Http\Controllers\PM\Settings\ProductionFormulaController.show()

var pm_settings_productionFormula_copy = 'pm.settings.production-formula.copy'; //uri: /pm/settings/production-formula/copy/{id} -> App\Http\Controllers\PM\Settings\ProductionFormulaController.copy()

var pm_settings_productionFormula_approve = 'pm.settings.production-formula.approve'; //uri: /pm/settings/production-formula/{id}/approve -> App\Http\Controllers\PM\Settings\ProductionFormulaController.approve()

var pm_settings_savePublicationLayout_index = 'pm.settings.save-publication-layout.index'; //uri: /pm/settings/save-publication-layout -> App\Http\Controllers\PM\Settings\SavePublicationLayoutController.index()

var pm_settings_savePublicationLayout_edit = 'pm.settings.save-publication-layout.edit'; //uri: /pm/settings/save-publication-layout/{id}/edit -> App\Http\Controllers\PM\Settings\SavePublicationLayoutController.edit()

var pm_settings_savePublicationLayout_update = 'pm.settings.save-publication-layout.update'; //uri: /pm/settings/save-publication-layout/update -> App\Http\Controllers\PM\Settings\SavePublicationLayoutController.update()

var pm_settings_machineRelation_index = 'pm.settings.machine-relation.index'; //uri: /pm/settings/machine-relation -> App\Http\Controllers\PM\Settings\MachineRelationController.index()

var pm_settings_machineRelation_create = 'pm.settings.machine-relation.create'; //uri: /pm/settings/machine-relation/create -> App\Http\Controllers\PM\Settings\MachineRelationController.create()

var pm_settings_machineRelation_store = 'pm.settings.machine-relation.store'; //uri: /pm/settings/machine-relation -> App\Http\Controllers\PM\Settings\MachineRelationController.store()

var pm_settings_machineRelation_edit = 'pm.settings.machine-relation.edit'; //uri: /pm/settings/machine-relation/{id}/edit -> App\Http\Controllers\PM\Settings\MachineRelationController.edit()

var pm_settings_machineRelation_update = 'pm.settings.machine-relation.update'; //uri: /pm/settings/machine-relation/{id} -> App\Http\Controllers\PM\Settings\MachineRelationController.update()

var pm_settings_setupMinMaxByItem_index = 'pm.settings.setup-min-max-by-item.index'; //uri: /pm/settings/setup-min-max-by-item -> App\Http\Controllers\PM\Settings\SetupMinMaxByItemController.index()

var pm_settings_setupMinMaxByItem_updateOrCreate = 'pm.settings.setup-min-max-by-item.updateOrCreate'; //uri: /pm/settings/setup-min-max-by-item/updateOrCreate -> App\Http\Controllers\PM\Settings\SetupMinMaxByItemController.updateOrCreate()

var pm_settings_setupTransfer_index = 'pm.settings.setup-transfer.index'; //uri: /pm/settings/setup-transfer -> App\Http\Controllers\PM\Settings\SetupTransferController.index()

var pm_settings_setupTransfer_edit = 'pm.settings.setup-transfer.edit'; //uri: /pm/settings/setup-transfer/edit/{id} -> App\Http\Controllers\PM\Settings\SetupTransferController.edit()

var pm_settings_setupTransfer_update = 'pm.settings.setup-transfer.update'; //uri: /pm/settings/setup-transfer/update -> App\Http\Controllers\PM\Settings\SetupTransferController.update()

var pm_settings_setupTransfer_create = 'pm.settings.setup-transfer.create'; //uri: /pm/settings/setup-transfer/create -> App\Http\Controllers\PM\Settings\SetupTransferController.create()

var pm_settings_setupTransfer_store = 'pm.settings.setup-transfer.store'; //uri: /pm/settings/setup-transfer/store -> App\Http\Controllers\PM\Settings\SetupTransferController.store()

var pm_settings_printConversion_index = 'pm.settings.print-conversion.index'; //uri: /pm/settings/print-conversion -> App\Http\Controllers\PM\Settings\PrintConversionController.index()

var pm_settings_printConversion_createOrUpdate = 'pm.settings.print-conversion.createOrUpdate'; //uri: /pm/settings/print-conversion/createOrUpdate -> App\Http\Controllers\PM\Settings\PrintConversionController.createOrUpdate()

var pm_settings_printProductType_index = 'pm.settings.print-product-type.index'; //uri: /pm/settings/print-product-type -> App\Http\Controllers\PM\Settings\PrintProductTypeController.index()

var pm_settings_printProductType_update = 'pm.settings.print-product-type.update'; //uri: /pm/settings/print-product-type/update -> App\Http\Controllers\PM\Settings\PrintProductTypeController.update()

var pm_settings_maxStorage_index = 'pm.settings.max-storage.index'; //uri: /pm/settings/max-storage -> App\Http\Controllers\PM\Settings\MaxStorageController.index()

var pm_settings_maxStorage_create = 'pm.settings.max-storage.create'; //uri: /pm/settings/max-storage/create -> App\Http\Controllers\PM\Settings\MaxStorageController.create()

var pm_settings_maxStorage_store = 'pm.settings.max-storage.store'; //uri: /pm/settings/max-storage -> App\Http\Controllers\PM\Settings\MaxStorageController.store()

var pm_settings_maxStorage_edit = 'pm.settings.max-storage.edit'; //uri: /pm/settings/max-storage/{id}/edit -> App\Http\Controllers\PM\Settings\MaxStorageController.edit()

var pm_settings_maxStorage_update = 'pm.settings.max-storage.update'; //uri: /pm/settings/max-storage/{id} -> App\Http\Controllers\PM\Settings\MaxStorageController.update()

var pm_settings_savePublicationLayout_store = 'pm.settings.save-publication-layout.store'; //uri: /pm/settings/save-publication-layout-store -> App\Http\Controllers\PM\Settings\SavePublicationLayoutController.store()

var pm_settings_setupBeforeNotice_index = 'pm.settings.setup-before-notice.index'; //uri: /pm/settings/setup-before-notice -> App\Http\Controllers\PM\Settings\SetupBeforeNoticeController.index()

var pm_settings_setupBeforeNotice_store = 'pm.settings.setup-before-notice.store'; //uri: /pm/settings/setup-before-notice -> App\Http\Controllers\PM\Settings\SetupBeforeNoticeController.store()

var pm_settings_ = 'pm.settings.'; //uri: /pm/settings/print-machine-group -> App\Http\Controllers\PM\Settings\PrintMachineGroupController.index()

var pm_0001_index = 'pm.0001.index'; //uri: /pm/0001 -> App\Http\Controllers\PM\Web\PM0001Controller.index()

var pm_0001_show = 'pm.0001.show'; //uri: /pm/0001 -> App\Http\Controllers\PM\Web\PM0001Controller.index()

var pm_productionOrder_index = 'pm.production-order.index'; //uri: /pm/0001 -> App\Http\Controllers\PM\Web\PM0001Controller.index()

var pm_productionOrder_show = 'pm.production-order.show'; //uri: /pm/0001 -> App\Http\Controllers\PM\Web\PM0001Controller.index()

var pm_0002_index = 'pm.0002.index'; //uri: /pm/0002 -> App\Http\Controllers\PM\Web\PM0002Controller.index()

var pm_requestCreation_index = 'pm.request-creation.index'; //uri: /pm/0002 -> App\Http\Controllers\PM\Web\PM0002Controller.index()

var pm_0003_index = 'pm.0003.index'; //uri: /pm/0003 -> App\Http\Controllers\PM\Web\PM0003Controller.index()

var pm_annualProductionPlan_index = 'pm.annual-production-plan.index'; //uri: /pm/0003 -> App\Http\Controllers\PM\Web\PM0003Controller.index()

var pm_0004_index = 'pm.0004.index'; //uri: /pm/0004 -> App\Http\Controllers\PM\Web\PM0004Controller.index()

var pm_0005_index = 'pm.0005.index'; //uri: /pm/0005/{id?} -> App\Http\Controllers\PM\Web\PM0005Controller.index()

var pm_requestMaterials_index = 'pm.request-materials.index'; //uri: /pm/0005/{id?} -> App\Http\Controllers\PM\Web\PM0005Controller.index()

var pm_00052_index = 'pm.0005-2.index'; //uri: /pm/0005-2/{id?} -> App\Http\Controllers\PM\Web\PM0005_2Controller.index()

var pm_0006_index = 'pm.0006.index'; //uri: /pm/0006 -> App\Http\Controllers\PM\Web\PM0006Controller.index()

var pm_reportProductInProcess_index = 'pm.report-product-in-process.index'; //uri: /pm/0006 -> App\Http\Controllers\PM\Web\PM0006Controller.index()

var pm_0006_jobs = 'pm.0006.jobs'; //uri: /pm/0006/jobs/{batchNo} -> App\Http\Controllers\PM\Web\PM0006Controller.showJob()

var pm_reportProductInProcess_jobs = 'pm.report-product-in-process.jobs'; //uri: /pm/0006/jobs/{batchNo} -> App\Http\Controllers\PM\Web\PM0006Controller.showJob()

var pm_0007_index = 'pm.0007.index'; //uri: /pm/0007 -> App\Http\Controllers\PM\Web\PM0007Controller.index()

var pm_cutRawMaterial_index = 'pm.cut-raw-material.index'; //uri: /pm/0007 -> App\Http\Controllers\PM\Web\PM0007Controller.index()

var pm_0008_index = 'pm.0008.index'; //uri: /pm/0008 -> App\Http\Controllers\PM\Web\PM0008Controller.index()

var pm_inventoryList_index = 'pm.inventory-list.index'; //uri: /pm/0008 -> App\Http\Controllers\PM\Web\PM0008Controller.index()

var pm_0009_index = 'pm.0009.index'; //uri: /pm/0009 -> App\Http\Controllers\PM\Web\PM0009Controller.index()

var pm_testRawMaterial_index = 'pm.test-raw-material.index'; //uri: /pm/0009 -> App\Http\Controllers\PM\Web\PM0009Controller.index()

var pm_0010_index = 'pm.0010.index'; //uri: /pm/0010 -> App\Http\Controllers\PM\Web\PM0010Controller.index()

var pm_reviewComplete_index = 'pm.review-complete.index'; //uri: /pm/0010 -> App\Http\Controllers\PM\Web\PM0010Controller.index()

var pm_0011_index = 'pm.0011.index'; //uri: /pm/0011 -> App\Http\Controllers\PM\Web\PM0011Controller.index()

var pm_planningJobLines_index = 'pm.planning-job-lines.index'; //uri: /pm/0011 -> App\Http\Controllers\PM\Web\PM0011Controller.index()

var pm_0012_index = 'pm.0012.index'; //uri: /pm/0012 -> App\Http\Controllers\PM\Web\PM0012Controller.index()

var pm_0013_index = 'pm.0013.index'; //uri: /pm/0013 -> App\Http\Controllers\PM\Web\PM0013Controller.index()

var pm_recordTobaccoUsageZoneC48_index = 'pm.record-tobacco-usage-zone-c48.index'; //uri: /pm/0013 -> App\Http\Controllers\PM\Web\PM0013Controller.index()

var pm_0014_index = 'pm.0014.index'; //uri: /pm/0014 -> App\Http\Controllers\PM\Web\PM0014Controller.index()

var pm_0015_index = 'pm.0015.index'; //uri: /pm/0015 -> App\Http\Controllers\PM\Web\PM0015Controller.index()

var pm_regionalTobaccoProductionPlanning_index = 'pm.regional-tobacco-production-planning.index'; //uri: /pm/0015 -> App\Http\Controllers\PM\Web\PM0015Controller.index()

var pm_0016_index = 'pm.0016.index'; //uri: /pm/0016 -> App\Http\Controllers\PM\Web\PM0016Controller.index()

var pm_0017_index = 'pm.0017.index'; //uri: /pm/0017 -> App\Http\Controllers\PM\Web\PM0017Controller.index()

var pm_domesticPrintingProductionPlanning_index = 'pm.domestic-printing-production-planning.index'; //uri: /pm/0017 -> App\Http\Controllers\PM\Web\PM0017Controller.index()

var pm_0018_index = 'pm.0018.index'; //uri: /pm/0018 -> App\Http\Controllers\PM\Web\PM0018Controller.index()

var pm_fortnightlyTobaccoProductionOrder_index = 'pm.fortnightly-tobacco-production-order.index'; //uri: /pm/0018 -> App\Http\Controllers\PM\Web\PM0018Controller.index()

var pm_0019_index = 'pm.0019.index'; //uri: /pm/0019 -> App\Http\Controllers\PM\Web\PM0019Controller.index()

var pm_fortnightlyRawMaterialRequest_index = 'pm.fortnightly-raw-material-request.index'; //uri: /pm/0019 -> App\Http\Controllers\PM\Web\PM0019Controller.index()

var pm_0020_index = 'pm.0020.index'; //uri: /pm/0020 -> App\Http\Controllers\PM\Web\PM0020Controller.index()

var pm_machineIngredientRequests_index = 'pm.machine-ingredient-requests.index'; //uri: /pm/0020 -> App\Http\Controllers\PM\Web\PM0020Controller.index()

var pm_0020_show = 'pm.0020.show'; //uri: /pm/0020/{id} -> App\Http\Controllers\PM\Web\PM0020Controller.show()

var pm_machineIngredientRequests_show = 'pm.machine-ingredient-requests.show'; //uri: /pm/0020/{id} -> App\Http\Controllers\PM\Web\PM0020Controller.show()

var pm_0021_index = 'pm.0021.index'; //uri: /pm/0021 -> App\Http\Controllers\PM\Web\PM0021Controller.index()

var pm_ingredientRequests_index = 'pm.ingredient-requests.index'; //uri: /pm/0021 -> App\Http\Controllers\PM\Web\PM0021Controller.index()

var pm_0022_index = 'pm.0022.index'; //uri: /pm/0022 -> App\Http\Controllers\PM\Web\PM0022Controller.index()

var pm_ingredientPreparationList_index = 'pm.ingredient-preparation-list.index'; //uri: /pm/0022 -> App\Http\Controllers\PM\Web\PM0022Controller.index()

var pm_0023_index = 'pm.0023.index'; //uri: /pm/0023 -> App\Http\Controllers\PM\Web\PM0023Controller.index()

var pm_transactionPnkCheckMaterial_index = 'pm.transaction-pnk-check-material.index'; //uri: /pm/0023 -> App\Http\Controllers\PM\Web\PM0023Controller.index()

var pm_0023_rawMaterials = 'pm.0023.rawMaterials'; //uri: /pm/0023/rawMaterials/{id} -> App\Http\Controllers\PM\Web\PM0023Controller.showRawMaterial()

var pm_transactionPnkCheckMaterial_rawMaterials = 'pm.transaction-pnk-check-material.rawMaterials'; //uri: /pm/0023/rawMaterials/{id} -> App\Http\Controllers\PM\Web\PM0023Controller.showRawMaterial()

var pm_0023_compareRawMaterials = 'pm.0023.compareRawMaterials'; //uri: /pm/0023/compareRawMaterials -> App\Http\Controllers\PM\Web\PM0023Controller.compareRequestAndOnShelfRawMaterial()

var pm_transactionPnkCheckMaterial_compareRawMaterials = 'pm.transaction-pnk-check-material.compareRawMaterials'; //uri: /pm/0023/compareRawMaterials -> App\Http\Controllers\PM\Web\PM0023Controller.compareRequestAndOnShelfRawMaterial()

var pm_0024_index = 'pm.0024.index'; //uri: /pm/0024 -> App\Http\Controllers\PM\Web\PM0024Controller.index()

var pm_transactionPnkMaterialTransfer_index = 'pm.transaction-pnk-material-transfer.index'; //uri: /pm/0024 -> App\Http\Controllers\PM\Web\PM0024Controller.index()

var pm_0025_index = 'pm.0025.index'; //uri: /pm/0025 -> App\Http\Controllers\PM\Web\PM0025controller.index()

var pm_confirmOrders_index = 'pm.confirm-orders.index'; //uri: /pm/0025 -> App\Http\Controllers\PM\Web\PM0025controller.index()

var pm_0026_index = 'pm.0026.index'; //uri: /pm/0026 -> App\Http\Controllers\PM\Web\PM0026Controller.index()

var pm_finishedProductsStoringRecord_index = 'pm.finished-products-storing-record.index'; //uri: /pm/0026 -> App\Http\Controllers\PM\Web\PM0026Controller.index()

var pm_0027_index = 'pm.0027.index'; //uri: /pm/0027 -> App\Http\Controllers\PM\Web\PM0027Controller.index()

var pm_sampleCigarettes_index = 'pm.sample-cigarettes.index'; //uri: /pm/0027 -> App\Http\Controllers\PM\Web\PM0027Controller.index()

var pm_0027_show = 'pm.0027.show'; //uri: /pm/0027/{date} -> App\Http\Controllers\PM\Web\PM0027Controller.show()

var pm_sampleCigarettes_show = 'pm.sample-cigarettes.show'; //uri: /pm/0027/{date} -> App\Http\Controllers\PM\Web\PM0027Controller.show()

var pm_0028_index = 'pm.0028.index'; //uri: /pm/0028 -> App\Http\Controllers\PM\Web\PM0028Controller.index()

var pm_freeProducts_index = 'pm.free-products.index'; //uri: /pm/0028 -> App\Http\Controllers\PM\Web\PM0028Controller.index()

var pm_0028_date = 'pm.0028.date'; //uri: /pm/0028/{date} -> App\Http\Controllers\PM\Web\PM0028Controller.getProductByDate()

var pm_freeProducts_date = 'pm.free-products.date'; //uri: /pm/0028/{date} -> App\Http\Controllers\PM\Web\PM0028Controller.getProductByDate()

var pm_0029_index = 'pm.0029.index'; //uri: /pm/0029 -> App\Http\Controllers\PM\Web\PM0029Controller.index()

var pm_ingredientInventory_index = 'pm.ingredient-inventory.index'; //uri: /pm/0029 -> App\Http\Controllers\PM\Web\PM0029Controller.index()

var pm_0030_index = 'pm.0030.index'; //uri: /pm/0030 -> App\Http\Controllers\PM\Web\PM0030controller.index()

var pm_confirmProductionYieldLossForTips_index = 'pm.confirm-production-yield-loss-for-tips.index'; //uri: /pm/0030 -> App\Http\Controllers\PM\Web\PM0030controller.index()

var pm_0031_index = 'pm.0031.index'; //uri: /pm/0031 -> App\Http\Controllers\PM\Web\PM0031Controller.index()

var pm_0032_index = 'pm.0032.index'; //uri: /pm/0032 -> App\Http\Controllers\PM\Web\PM0032Controller.index()

var pm_stampUsing_index = 'pm.stamp-using.index'; //uri: /pm/0032 -> App\Http\Controllers\PM\Web\PM0032Controller.index()

var pm_0032_show = 'pm.0032.show'; //uri: /pm/0032/{stampHeaderId} -> App\Http\Controllers\PM\Web\PM0032Controller.show()

var pm_stampUsing_show = 'pm.stamp-using.show'; //uri: /pm/0032/{stampHeaderId} -> App\Http\Controllers\PM\Web\PM0032Controller.show()

var pm_0032_create = 'pm.0032.create'; //uri: /pm/0032 -> App\Http\Controllers\PM\Web\PM0032Controller.create()

var pm_stampUsing_create = 'pm.stamp-using.create'; //uri: /pm/0032 -> App\Http\Controllers\PM\Web\PM0032Controller.create()

var pm_0033_index = 'pm.0033.index'; //uri: /pm/0033 -> App\Http\Controllers\PM\Web\PM0033Controller.index()

var pm_confirmStampUsing_index = 'pm.confirm-stamp-using.index'; //uri: /pm/0033 -> App\Http\Controllers\PM\Web\PM0033Controller.index()

var pm_0034_index = 'pm.0034.index'; //uri: /pm/0034 -> App\Http\Controllers\PM\Web\PM0034Controller.index()

var pm_planningProduceMonthly_index = 'pm.planning-produce-monthly.index'; //uri: /pm/0034 -> App\Http\Controllers\PM\Web\PM0034Controller.index()

var pm_0035_index = 'pm.0035.index'; //uri: /pm/0035 -> App\Http\Controllers\PM\Web\PM0035Controller.index()

var pm_receiveRawMaterialTransferAtTemporaryStorage_index = 'pm.receive-raw-material-transfer-at-temporary-storage.index'; //uri: /pm/0035 -> App\Http\Controllers\PM\Web\PM0035Controller.index()

var pm_0036_index = 'pm.0036.index'; //uri: /pm/0036 -> App\Http\Controllers\PM\Web\PM0036Controller.index()

var pm_closeProductOrder_index = 'pm.close-product-order.index'; //uri: /pm/0036 -> App\Http\Controllers\PM\Web\PM0036Controller.index()

var pm_0037_index = 'pm.0037.index'; //uri: /pm/0037 -> App\Http\Controllers\PM\Web\PM0037Controller.index()

var pm_rawMaterialPreparation_index = 'pm.raw-material-preparation.index'; //uri: /pm/0037 -> App\Http\Controllers\PM\Web\PM0037Controller.index()

var pm_0038_index = 'pm.0038.index'; //uri: /pm/0038 -> App\Http\Controllers\PM\Web\PM0038Controller.index()

var pm_productionOrderList_index = 'pm.production-order-list.index'; //uri: /pm/0038 -> App\Http\Controllers\PM\Web\PM0038Controller.index()

var pm_0039_index = 'pm.0039.index'; //uri: /pm/0039 -> App\Http\Controllers\PM\Web\AdditiveInventoryAlertController.index()

var pm_additiveInventoryAlert_index = 'pm.additive-inventory-alert.index'; //uri: /pm/additive-inventory-alert -> App\Http\Controllers\PM\Web\PM0039Controller.index()

var pm_0040_index = 'pm.0040.index'; //uri: /pm/0040 -> App\Http\Controllers\PM\Web\RawMaterialInventoryAlertController.index()

var pm_rawMaterialInventoryAlert_index = 'pm.raw-material-inventory-alert.index'; //uri: /pm/raw-material-inventory-alert -> App\Http\Controllers\PM\Web\PM0040Controller.index()

var pm_0041_index = 'pm.0041.index'; //uri: /pm/0041 -> App\Http\Controllers\PM\Web\PM0041Controller.index()

var pm_examineCasingAfterExpiryDate_index = 'pm.examine-casing-after-expiry-date.index'; //uri: /pm/0041 -> App\Http\Controllers\PM\Web\PM0041Controller.index()

var pm_0042_index = 'pm.0042.index'; //uri: /pm/0042 -> App\Http\Controllers\PM\Web\PM0042Controller.index()

var pm_approvalCasingNewExpiryDate_index = 'pm.approval-casing-new-expiry-date.index'; //uri: /pm/0042 -> App\Http\Controllers\PM\Web\PM0042Controller.index()

var pm_0043_index = 'pm.0043.index'; //uri: /pm/0043 -> App\Http\Controllers\PM\Web\PM0043Controller.index()

var pm_transferFinishGoods_index = 'pm.transfer-finish-goods.index'; //uri: /pm/0043 -> App\Http\Controllers\PM\Web\PM0043Controller.index()

var pm_0044_index = 'pm.0044.index'; //uri: /pm/0044 -> App\Http\Controllers\PM\Web\PM0044Controller.index()

var pm_0045_index = 'pm.0045.index'; //uri: /pm/0045 -> App\Http\Controllers\PM\Web\PM0045Controller.index()

var pm_dbLookupExample_index = 'pm.dbLookupExample.index'; //uri: /pm/dbLookupExample -> App\Http\Controllers\PM\Web\ExampleDbLookupController.index()

var pm_plans_yearly = 'pm.plans.yearly'; //uri: /pm/plans/yearly -> App\Http\Controllers\PM\PlanYearlyController.index()

var pm_plans_monthly = 'pm.plans.monthly'; //uri: /pm/plans/monthly -> App\Http\Controllers\PM\PlanMonthlyController.index()

var pm_plans_biweekly = 'pm.plans.biweekly'; //uri: /pm/plans/biweekly -> App\Http\Controllers\PM\PlanBiweeklyController.index()

var pm_plans_daily = 'pm.plans.daily'; //uri: /pm/plans/daily -> App\Http\Controllers\PM\PlanDailyController.index()

var pm_plans_approvals_yearly = 'pm.plans.approvals.yearly'; //uri: /pm/plans/approvals/yearly -> App\Http\Controllers\PM\PlanApprovalYearlyController.index()

var pm_plans_approvals_biweekly = 'pm.plans.approvals.biweekly'; //uri: /pm/plans/approvals/biweekly -> App\Http\Controllers\PM\PlanApprovalBiweeklyController.index()

var pm_products_machineRequests_index = 'pm.products.machine-requests.index'; //uri: /pm/products/machine-requests -> App\Http\Controllers\PM\ProductMachineRequestController.index()

var pm_products_transfers_index = 'pm.products.transfers.index'; //uri: /pm/products/transfers -> App\Http\Controllers\PM\ProductTransferController.index()

var pm_files_image = 'pm.files.image'; //uri: /pm/files/image/{module}/{menu}/{feature}/{fileName} -> App\Http\Controllers\PM\FileController.image()

var pm_files_imageThumbnail = 'pm.files.image-thumbnail'; //uri: /pm/files/image-thumbnail/{module}/{menu}/{feature}/{fileName} -> App\Http\Controllers\PM\FileController.imageThumbnail()

var pm_files_download = 'pm.files.download'; //uri: /pm/files/download/{module}/{menu}/{feature}/{fileType}/{fileName} -> App\Http\Controllers\PM\FileController.download()

var pp_0000_index = 'pp.0000.index'; //uri: /pp/0000 -> App\Http\Controllers\PP\Web\PP0000Controller.index()

var pp_example_index = 'pp.example.index'; //uri: /pp/0000 -> App\Http\Controllers\PP\Web\PP0000Controller.index()

var pp_0001_index = 'pp.0001.index'; //uri: /pp/0001 -> App\Http\Controllers\PP\Web\PP0001Controller.index()

var pp_0002_index = 'pp.0002.index'; //uri: /pp/0002 -> App\Http\Controllers\PP\Web\PP0002Controller.index()

var pp_0003_index = 'pp.0003.index'; //uri: /pp/0003 -> App\Http\Controllers\PP\Web\PP0003Controller.index()

var pp_0004_index = 'pp.0004.index'; //uri: /pp/0004 -> App\Http\Controllers\PP\Web\PP0004Controller.index()

var pp_0005_index = 'pp.0005.index'; //uri: /pp/0005 -> App\Http\Controllers\PP\Web\PP0005Controller.index()

var pp_0006_index = 'pp.0006.index'; //uri: /pp/0006 -> App\Http\Controllers\PP\Web\PP0006Controller.index()

var pp_0007_index = 'pp.0007.index'; //uri: /pp/0007 -> App\Http\Controllers\PP\Web\PP0007Controller.index()

var pp_0008_index = 'pp.0008.index'; //uri: /pp/0008 -> App\Http\Controllers\PP\Web\PP0008Controller.index()

var eam_ajax_lov_assetNumber = 'eam.ajax.lov.asset-number'; //uri: /eam/ajax/lov/assetnumber -> App\Http\Controllers\EAM\Ajax\LovController.assetNumber()

var eam_ajax_lov_assetVAssetNumber = 'eam.ajax.lov.asset-v-asset-number'; //uri: /eam/ajax/lov/assetv/assetnumber -> App\Http\Controllers\EAM\Ajax\LovController.assetVAssetNumber()

var eam_ajax_lov_childAssetNumber = 'eam.ajax.lov.child-asset-number'; //uri: /eam/ajax/lov/child-assetnumber/{p_parent} -> App\Http\Controllers\EAM\Ajax\LovController.childAssetNumber()

var eam_ajax_lov_departments = 'eam.ajax.lov.departments'; //uri: /eam/ajax/lov/departments -> App\Http\Controllers\EAM\Ajax\LovController.departments()

var eam_ajax_lov_workRequestStatus = 'eam.ajax.lov.work-request-status'; //uri: /eam/ajax/lov/work-request-status -> App\Http\Controllers\EAM\Ajax\LovController.workRequestStatus()

var eam_ajax_lov_workReceiptStatus = 'eam.ajax.lov.work-receipt-status'; //uri: /eam/ajax/lov/work-receipt-status -> App\Http\Controllers\EAM\Ajax\LovController.workReceiptStatus()

var eam_ajax_lov_employee = 'eam.ajax.lov.employee'; //uri: /eam/ajax/lov/employee -> App\Http\Controllers\EAM\Ajax\LovController.employee()

var eam_ajax_lov_workRequestType = 'eam.ajax.lov.work-request-type'; //uri: /eam/ajax/lov/work-request-type -> App\Http\Controllers\EAM\Ajax\LovController.workRequestType()

var eam_ajax_lov_activityPriority = 'eam.ajax.lov.activity-priority'; //uri: /eam/ajax/lov/activity-priority -> App\Http\Controllers\EAM\Ajax\LovController.activityPriority()

var eam_ajax_lov_workRequestNumber = 'eam.ajax.lov.work-request-number'; //uri: /eam/ajax/lov/work-request-number -> App\Http\Controllers\EAM\Ajax\LovController.workRequestView()

var eam_ajax_lov_workOrderHId = 'eam.ajax.lov.work-order-h-id'; //uri: /eam/ajax/lov/workorderhvid -> App\Http\Controllers\EAM\Ajax\LovController.workOrderHVId()

var eam_ajax_lov_workOrderOpNumseq = 'eam.ajax.lov.work-order-op-numseq'; //uri: /eam/ajax/lov/workorderopnumseq -> App\Http\Controllers\EAM\Ajax\LovController.WorkOrderOpVseqnum()

var eam_ajax_lov_wipClass = 'eam.ajax.lov.wip-class'; //uri: /eam/ajax/lov/wipclass -> App\Http\Controllers\EAM\Ajax\LovController.wipClass()

var eam_ajax_lov_depResource = 'eam.ajax.lov.dep-resource'; //uri: /eam/ajax/lov/dep-resource -> App\Http\Controllers\EAM\Ajax\LovController.depResource()

var eam_ajax_lov_statusYn = 'eam.ajax.lov.status-yn'; //uri: /eam/ajax/lov/status-yn -> App\Http\Controllers\EAM\Ajax\LovController.statusYN()

var eam_ajax_lov_itemInventory = 'eam.ajax.lov.item-inventory'; //uri: /eam/ajax/lov/item-inventory -> App\Http\Controllers\EAM\Ajax\LovController.ItemInventory()

var eam_ajax_lov_itemNonstock = 'eam.ajax.lov.item-nonstock'; //uri: /eam/ajax/lov/item-nonstock -> App\Http\Controllers\EAM\Ajax\LovController.ItemNonstock()

var eam_ajax_lov_materialType = 'eam.ajax.lov.material-type'; //uri: /eam/ajax/lov/material-type -> App\Http\Controllers\EAM\Ajax\LovController.MaterialType()

var eam_ajax_lov_suvinventory = 'eam.ajax.lov.suvinventory'; //uri: /eam/ajax/lov/suvinventory -> App\Http\Controllers\EAM\Ajax\LovController.Suvinventory()

var eam_ajax_lov_locatorv = 'eam.ajax.lov.locatorv'; //uri: /eam/ajax/lov/locatorv -> App\Http\Controllers\EAM\Ajax\LovController.LocatorV()

var eam_ajax_lov_assetActivity = 'eam.ajax.lov.asset-activity'; //uri: /eam/ajax/lov/assetactivity -> App\Http\Controllers\EAM\Ajax\LovController.AssetActivity()

var eam_ajax_lov_issue = 'eam.ajax.lov.issue'; //uri: /eam/ajax/lov/issue -> App\Http\Controllers\EAM\Ajax\LovController.Issue()

var eam_ajax_lov_workOrderStatus = 'eam.ajax.lov.work-order-status'; //uri: /eam/ajax/lov/work-order-status -> App\Http\Controllers\EAM\Ajax\LovController.workOrderStatus()

var eam_ajax_lov_workOrderType = 'eam.ajax.lov.work-order-type'; //uri: /eam/ajax/lov/work-order-type -> App\Http\Controllers\EAM\Ajax\LovController.workOrderType()

var eam_ajax_lov_shutdownType = 'eam.ajax.lov.shutdown-type'; //uri: /eam/ajax/lov/shutdown-type -> App\Http\Controllers\EAM\Ajax\LovController.ShutdownType()

var eam_ajax_lov_workOrderReNumseq = 'eam.ajax.lov.work-order-re-numseq'; //uri: /eam/ajax/lov/workorderrenumseq -> App\Http\Controllers\EAM\Ajax\LovController.WorkOrderReVseqnum()

var eam_ajax_lov_workOrderReResource = 'eam.ajax.lov.work-order-re-resource'; //uri: /eam/ajax/lov/workorderreresource -> App\Http\Controllers\EAM\Ajax\LovController.WorkOrderReVResource()

var eam_ajax_lov_area = 'eam.ajax.lov.area'; //uri: /eam/ajax/lov/area -> App\Http\Controllers\EAM\Ajax\LovController.area()

var eam_ajax_lov_resourceAssetNumber = 'eam.ajax.lov.resource-asset-number'; //uri: /eam/ajax/lov/resource-asset-number -> App\Http\Controllers\EAM\Ajax\LovController.assetVNumber()

var eam_ajax_lov_assetGroup = 'eam.ajax.lov.asset-group'; //uri: /eam/ajax/lov/asset-group -> App\Http\Controllers\EAM\Ajax\LovController.assetGroup()

var eam_ajax_lov_productionOrganization = 'eam.ajax.lov.production-organization'; //uri: /eam/ajax/lov/production-organization -> App\Http\Controllers\EAM\Ajax\LovController.productionOrganization()

var eam_ajax_lov_usageUom = 'eam.ajax.lov.usage-uom'; //uri: /eam/ajax/lov/usage-uom -> App\Http\Controllers\EAM\Ajax\LovController.usageUom()

var eam_ajax_lov_resourceAssetLocator = 'eam.ajax.lov.resource-asset-locator'; //uri: /eam/ajax/lov/resource-asset-locator -> App\Http\Controllers\EAM\Ajax\LovController.resAssetLocator()

var eam_ajax_lov_operation = 'eam.ajax.lov.operation'; //uri: /eam/ajax/lov/operation -> App\Http\Controllers\EAM\Ajax\LovController.operation()

var eam_ajax_lov_machineType = 'eam.ajax.lov.machine-type'; //uri: /eam/ajax/lov/machine-type -> App\Http\Controllers\EAM\Ajax\LovController.machineType()

var eam_ajax_lov_periodYear = 'eam.ajax.lov.period-year'; //uri: /eam/ajax/lov/period-year -> App\Http\Controllers\EAM\Ajax\LovController.periodYear()

var eam_ajax_lov_activity = 'eam.ajax.lov.activity'; //uri: /eam/ajax/lov/activity -> App\Http\Controllers\EAM\Ajax\LovController.activity()

var eam_ajax_lov_woMtLot = 'eam.ajax.lov.wo-mt-lot'; //uri: /eam/ajax/lov/wo-mt-lot -> App\Http\Controllers\EAM\Ajax\LovController.woMtLot()

var eam_ajax_lov_organization = 'eam.ajax.lov.organization'; //uri: /eam/ajax/lov/organization -> App\Http\Controllers\EAM\Ajax\LovController.organization()

var eam_ajax_lov_departmentResources = 'eam.ajax.lov.department-resources'; //uri: /eam/ajax/lov/department-resources -> App\Http\Controllers\EAM\Ajax\LovController.departmentResourcesV()

var eam_ajax_lov_assetResources = 'eam.ajax.lov.asset-resources'; //uri: /eam/ajax/lov/asset-resources -> App\Http\Controllers\EAM\Ajax\LovController.assetVResource()

var eam_ajax_lov_requestEquipNo = 'eam.ajax.lov.request-equip-no'; //uri: /eam/ajax/lov/request-equip-no -> App\Http\Controllers\EAM\Ajax\LovController.requestEquipNo()

var eam_ajax_lov_requestStatus = 'eam.ajax.lov.request-status'; //uri: /eam/ajax/lov/request-status -> App\Http\Controllers\EAM\Ajax\LovController.requestStatus()

var eam_ajax_lov_periodName = 'eam.ajax.lov.period-name'; //uri: /eam/ajax/lov/period-name -> App\Http\Controllers\EAM\Ajax\LovController.periodName()

var eam_ajax_lov_resource = 'eam.ajax.lov.resource'; //uri: /eam/ajax/lov/resource -> App\Http\Controllers\EAM\Ajax\LovController.resourceV()

var eam_ajax_lov_jobStatus = 'eam.ajax.lov.job-status'; //uri: /eam/ajax/lov/jobstatus -> App\Http\Controllers\EAM\Ajax\LovController.jobStatusV()

var eam_ajax_lov_resourceEmployee = 'eam.ajax.lov.resource-employee'; //uri: /eam/ajax/lov/resource-employee -> App\Http\Controllers\EAM\Ajax\LovController.resourceEmployeeV()

var eam_ajax_workRequests_permissionApprove = 'eam.ajax.work-requests.permission-approve'; //uri: /eam/ajax/work-requests/permission-approve -> App\Http\Controllers\EAM\Ajax\WorkRequestController.checkPermissionApprove()

var eam_ajax_workRequests_cancel = 'eam.ajax.work-requests.cancel'; //uri: /eam/ajax/work-requests/cancel/{p_work_request_number} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.cancel()

var eam_ajax_workRequests_cancelApproval = 'eam.ajax.work-requests.cancel-approval'; //uri: /eam/ajax/work-requests/cancel-approval/{p_work_request_number} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.cancelApproval()

var eam_ajax_workRequests_store = 'eam.ajax.work-requests.store'; //uri: /eam/ajax/work-requests -> App\Http\Controllers\EAM\Ajax\WorkRequestController.store()

var eam_ajax_workRequests_updateStatus = 'eam.ajax.work-requests.update-status'; //uri: /eam/ajax/work-requests/status -> App\Http\Controllers\EAM\Ajax\WorkRequestController.updateStatus()

var eam_ajax_workRequests_report = 'eam.ajax.work-requests.report'; //uri: /eam/ajax/work-requests/report -> App\Http\Controllers\EAM\Ajax\WorkRequestController.report()

var eam_ajax_workRequests_sendApprove = 'eam.ajax.work-requests.send-approve'; //uri: /eam/ajax/work-requests/send-approve/{p_work_request_id} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.sendApprove()

var eam_ajax_workRequests_search = 'eam.ajax.work-requests.search'; //uri: /eam/ajax/work-requests/search -> App\Http\Controllers\EAM\Ajax\WorkRequestController.search()

var eam_ajax_workRequests_images_index = 'eam.ajax.work-requests.images.index'; //uri: /eam/ajax/work-requests/images/{p_work_request_id} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.images()

var eam_ajax_workRequests_images_upload = 'eam.ajax.work-requests.images.upload'; //uri: /eam/ajax/work-requests/images/{p_work_request_id} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.uploadImage()

var eam_ajax_workRequests_images_delete = 'eam.ajax.work-requests.images.delete'; //uri: /eam/ajax/work-requests/images/{p_attachment_id} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.deleteImage()

var eam_ajax_workRequests_images_show = 'eam.ajax.work-requests.images.show'; //uri: /eam/ajax/work-requests/images/show/{p_attachment_id} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.showImage()

var eam_ajax_workRequests_show = 'eam.ajax.work-requests.show'; //uri: /eam/ajax/work-requests/{p_work_request_number} -> App\Http\Controllers\EAM\Ajax\WorkRequestController.show()

var eam_ajax_checkOnHand_search = 'eam.ajax.check-on-hand.search'; //uri: /eam/ajax/check-on-hand/search -> App\Http\Controllers\EAM\Ajax\CheckOnHandController.search()

var eam_ajax_checkOnHand_images = 'eam.ajax.check-on-hand.images'; //uri: /eam/ajax/check-on-hand/images/{p_item_code} -> App\Http\Controllers\EAM\Ajax\CheckOnHandController.images()

var eam_ajax_checkOnHand_image_upload = 'eam.ajax.check-on-hand.image.upload'; //uri: /eam/ajax/check-on-hand/image/{p_item_code} -> App\Http\Controllers\EAM\Ajax\CheckOnHandController.uploadImage()

var eam_ajax_checkOnHand_image_delete = 'eam.ajax.check-on-hand.image.delete'; //uri: /eam/ajax/check-on-hand/image/{p_attachment_id} -> App\Http\Controllers\EAM\Ajax\CheckOnHandController.deleteImage()

var eam_ajax_checkOnHand_image_show = 'eam.ajax.check-on-hand.image.show'; //uri: /eam/ajax/check-on-hand/image/{p_attachment_id} -> App\Http\Controllers\EAM\Ajax\CheckOnHandController.showImage()

var eam_ajax_checkTransaction_search = 'eam.ajax.check-transaction.search'; //uri: /eam/ajax/check-transaction/search -> App\Http\Controllers\EAM\Ajax\CheckTransactionController.search()

var eam_ajax_resourceAsset_show = 'eam.ajax.resource-asset.show'; //uri: /eam/ajax/resource-asset/show/{p_asset_number} -> App\Http\Controllers\EAM\Ajax\ResourceAssetController.show()

var eam_ajax_resourceAsset_store = 'eam.ajax.resource-asset.store'; //uri: /eam/ajax/resource-asset/save -> App\Http\Controllers\EAM\Ajax\ResourceAssetController.store()

var eam_ajax_resourceAsset_assetCategory = 'eam.ajax.resource-asset.asset-category'; //uri: /eam/ajax/resource-asset/asset-category -> App\Http\Controllers\EAM\Ajax\ResourceAssetController.assetCategory()

var eam_ajax_resourceAsset_assetCategorySubgroup = 'eam.ajax.resource-asset.asset-category-subgroup'; //uri: /eam/ajax/resource-asset/asset-category/sub-group -> App\Http\Controllers\EAM\Ajax\ResourceAssetController.assetCategorySubGroup()

var eam_ajax_resourceAsset_assetCategorySubmachine = 'eam.ajax.resource-asset.asset-category-submachine'; //uri: /eam/ajax/resource-asset/asset-category/sub-machine -> App\Http\Controllers\EAM\Ajax\ResourceAssetController.assetCategorySubMachine()

var eam_ajax_workOrder_head_index = 'eam.ajax.work-order.head.index'; //uri: /eam/ajax/work-order/head -> App\Http\Controllers\EAM\Ajax\WorkOrderController.headSearch()

var eam_ajax_workOrder_head_show = 'eam.ajax.work-order.head.show'; //uri: /eam/ajax/work-order/head/show/{p_wip_entity_name} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.headShow()

var eam_ajax_workOrder_head_store = 'eam.ajax.work-order.head.store'; //uri: /eam/ajax/work-order/head/save -> App\Http\Controllers\EAM\Ajax\WorkOrderController.headStore()

var eam_ajax_workOrder_head_delete = 'eam.ajax.work-order.head.delete'; //uri: /eam/ajax/work-order/head/delete -> App\Http\Controllers\EAM\Ajax\WorkOrderController.headDelete()

var eam_ajax_workOrder_head_unclose = 'eam.ajax.work-order.head.unclose'; //uri: /eam/ajax/work-order/head/unclose -> App\Http\Controllers\EAM\Ajax\WorkOrderController.headUnclose()

var eam_ajax_workOrder_head_waitingConfirm = 'eam.ajax.work-order.head.waiting-confirm'; //uri: /eam/ajax/work-order/head/waiting-confirm -> App\Http\Controllers\EAM\Ajax\WorkOrderController.waitingConfirm()

var eam_ajax_workOrder_head_updateStatus = 'eam.ajax.work-order.head.update-status'; //uri: /eam/ajax/work-order/head/status -> App\Http\Controllers\EAM\Ajax\WorkOrderController.closeAndUncompleteWorkOrder()

var eam_ajax_workOrder_head_closeJp = 'eam.ajax.work-order.head.close-jp'; //uri: /eam/ajax/work-order/head/close-jp/{p_wip_entity_name} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.closeJP()

var eam_ajax_workOrder_op_all = 'eam.ajax.work-order.op.all'; //uri: /eam/ajax/work-order/op/all/{p_wip_entity_id} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.opAll()

var eam_ajax_workOrder_op_store = 'eam.ajax.work-order.op.store'; //uri: /eam/ajax/work-order/op/save -> App\Http\Controllers\EAM\Ajax\WorkOrderController.opStore()

var eam_ajax_workOrder_op_delete = 'eam.ajax.work-order.op.delete'; //uri: /eam/ajax/work-order/op/delete -> App\Http\Controllers\EAM\Ajax\WorkOrderController.opDelete()

var eam_ajax_workOrder_re_all = 'eam.ajax.work-order.re.all'; //uri: /eam/ajax/work-order/re/all/{p_wip_entity_id} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reAll()

var eam_ajax_workOrder_report = 'eam.ajax.work-order.report'; //uri: /eam/ajax/work-order/report -> App\Http\Controllers\EAM\Ajax\WorkOrderController.report()

var eam_ajax_workOrder_report_part = 'eam.ajax.work-order.report.part'; //uri: /eam/ajax/work-order/report-part -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportPart()

var eam_ajax_workOrder_re_store = 'eam.ajax.work-order.re.store'; //uri: /eam/ajax/work-order/re/save -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reStore()

var eam_ajax_workOrder_re_delete = 'eam.ajax.work-order.re.delete'; //uri: /eam/ajax/work-order/re/delete -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reDelete()

var eam_ajax_workOrder_mt_all = 'eam.ajax.work-order.mt.all'; //uri: /eam/ajax/work-order/mt/all/{p_wip_entity_id} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.mtAll()

var eam_ajax_workOrder_mt_store = 'eam.ajax.work-order.mt.store'; //uri: /eam/ajax/work-order/mt/save -> App\Http\Controllers\EAM\Ajax\WorkOrderController.mtStore()

var eam_ajax_workOrder_mt_delete = 'eam.ajax.work-order.mt.delete'; //uri: /eam/ajax/work-order/mt/delete -> App\Http\Controllers\EAM\Ajax\WorkOrderController.mtDelete()

var eam_ajax_workOrder_mt_return = 'eam.ajax.work-order.mt.return'; //uri: /eam/ajax/work-order/mt/return -> App\Http\Controllers\EAM\Ajax\WorkOrderController.mtReturn()

var eam_ajax_workOrder_mt_issue = 'eam.ajax.work-order.mt.issue'; //uri: /eam/ajax/work-order/mt/issue -> App\Http\Controllers\EAM\Ajax\WorkOrderController.mtIssue()

var eam_ajax_workOrder_lb_all = 'eam.ajax.work-order.lb.all'; //uri: /eam/ajax/work-order/lb/all/{p_wip_entity_id} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.lbAll()

var eam_ajax_workOrder_lb_store = 'eam.ajax.work-order.lb.store'; //uri: /eam/ajax/work-order/lb/save -> App\Http\Controllers\EAM\Ajax\WorkOrderController.lbStore()

var eam_ajax_workOrder_lb_delete = 'eam.ajax.work-order.lb.delete'; //uri: /eam/ajax/work-order/lb/delete -> App\Http\Controllers\EAM\Ajax\WorkOrderController.lbDelete()

var eam_ajax_workOrder_cp_all = 'eam.ajax.work-order.cp.all'; //uri: /eam/ajax/work-order/cp/all/{p_wip_entity_id} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.cpAll()

var eam_ajax_workOrder_cp_store = 'eam.ajax.work-order.cp.store'; //uri: /eam/ajax/work-order/cp/save -> App\Http\Controllers\EAM\Ajax\WorkOrderController.cpStore()

var eam_ajax_workOrder_cost_all = 'eam.ajax.work-order.cost.all'; //uri: /eam/ajax/work-order/cost/all/{p_wip_entity_id} -> App\Http\Controllers\EAM\Ajax\WorkOrderController.costAll()

var eam_ajax_workOrder_itemcost_get = 'eam.ajax.work-order.itemcost.get'; //uri: /eam/ajax/work-order/item-cost -> App\Http\Controllers\EAM\Ajax\WorkOrderController.getItemCost()

var eam_ajax_workOrder_itemonhand_get = 'eam.ajax.work-order.itemonhand.get'; //uri: /eam/ajax/work-order/item-onhand -> App\Http\Controllers\EAM\Ajax\WorkOrderController.getItemOnhand()

var eam_ajax_workOrder_defaultWipClass = 'eam.ajax.work-order.default-wip-class'; //uri: /eam/ajax/work-order/defaultwipclass -> App\Http\Controllers\EAM\Ajax\WorkOrderController.defaultWipClass()

var eam_ajax_workOrder_report_summaryMonth = 'eam.ajax.work-order.report.summary-month'; //uri: /eam/ajax/work-order/report/summary-month -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportSummaryMonth()

var eam_ajax_workOrder_report_summaryMonthExcel = 'eam.ajax.work-order.report.summary-month-excel'; //uri: /eam/ajax/work-order/report/summary-month-excel -> App\Http\Controllers\EAM\Ajax\WorkOrderController.exportSummaryMonth()

var eam_ajax_workOrder_report_payable = 'eam.ajax.work-order.report.payable'; //uri: /eam/ajax/work-order/report/payable -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportPayable()

var eam_ajax_workOrder_report_closeWoJp = 'eam.ajax.work-order.report.close-wo-jp'; //uri: /eam/ajax/work-order/report/close-wo-jp -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportCloseWoJp()

var eam_ajax_workOrder_report_mntHistory = 'eam.ajax.work-order.report.mnt-history'; //uri: /eam/ajax/work-order/report/mnt-history -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportMntHistory()

var eam_ajax_workOrder_report_maintenanceExcel = 'eam.ajax.work-order.report.maintenance-excel'; //uri: /eam/ajax/work-order/report/maintenance-excel -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportMaintenance()

var eam_ajax_workOrder_report_purchaseExcel = 'eam.ajax.work-order.report.purchase-excel'; //uri: /eam/ajax/work-order/report/purchase-excel -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportPurchase()

var eam_ajax_workOrder_report_jobAccount = 'eam.ajax.work-order.report.job-account'; //uri: /eam/ajax/work-order/report/job-account -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportJobAccount()

var eam_ajax_workOrder_report_laborAccount = 'eam.ajax.work-order.report.labor-account'; //uri: /eam/ajax/work-order/report/labor-account -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportLaborAccount()

var eam_ajax_workOrder_report_woCost = 'eam.ajax.work-order.report.wo-cost'; //uri: /eam/ajax/work-order/report/wo-cost -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportWoCost()

var eam_ajax_workOrder_report_laborExcel = 'eam.ajax.work-order.report.labor-excel'; //uri: /eam/ajax/work-order/report/labor-excel -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportLabor()

var eam_ajax_workOrder_report_summaryLabor = 'eam.ajax.work-order.report.summary-labor'; //uri: /eam/ajax/work-order/report/summary-labor -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportSummaryLabor()

var eam_ajax_workOrder_report_receiptMat = 'eam.ajax.work-order.report.receipt-mat'; //uri: /eam/ajax/work-order/report/receipt-mat -> App\Http\Controllers\EAM\Ajax\WorkOrderController.reportReceiptMat()

var eam_ajax_plan_versionPlan = 'eam.ajax.plan.version-plan'; //uri: /eam/ajax/plan/version_plan/{p_year} -> App\Http\Controllers\EAM\Ajax\PMPlanController.listVersionPlan()

var eam_ajax_plan_confirm = 'eam.ajax.plan.confirm'; //uri: /eam/ajax/plan/confirm/{p_plan_id} -> App\Http\Controllers\EAM\Ajax\PMPlanController.confirm()

var eam_ajax_plan_store = 'eam.ajax.plan.store'; //uri: /eam/ajax/plan -> App\Http\Controllers\EAM\Ajax\PMPlanController.store()

var eam_ajax_plan_search = 'eam.ajax.plan.search'; //uri: /eam/ajax/plan/{p_year}/{p_version} -> App\Http\Controllers\EAM\Ajax\PMPlanController.search()

var eam_ajax_plan_openWorkOrder = 'eam.ajax.plan.open-work-order'; //uri: /eam/ajax/plan/work-order -> App\Http\Controllers\EAM\Ajax\PMPlanController.openWorkOrder()

var eam_ajax_plan_deleteLine = 'eam.ajax.plan.delete-line'; //uri: /eam/ajax/plan/line/{p_plan_id} -> App\Http\Controllers\EAM\Ajax\PMPlanController.deleteLine()

var eam_ajax_plan_fileImport = 'eam.ajax.plan.file-import'; //uri: /eam/ajax/plan/file-import -> App\Http\Controllers\EAM\Ajax\PMPlanController.fileImport()

var eam_ajax_billMaterials_show = 'eam.ajax.bill-materials.show'; //uri: /eam/ajax/bill-materials -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.show()

var eam_ajax_billMaterials_store = 'eam.ajax.bill-materials.store'; //uri: /eam/ajax/bill-materials -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.store()

var eam_ajax_billMaterials_deleteLine = 'eam.ajax.bill-materials.delete-line'; //uri: /eam/ajax/bill-materials -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.deleteLine()

var eam_ajax_billMaterials_confirm = 'eam.ajax.bill-materials.confirm'; //uri: /eam/ajax/bill-materials/{request_equip_no}/confirm -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.confirm()

var eam_ajax_billMaterials_cancel = 'eam.ajax.bill-materials.cancel'; //uri: /eam/ajax/bill-materials/{request_equip_no}/cancel -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.cancel()

var eam_ajax_report_issueMatExcel = 'eam.ajax.report.issue-mat-excel'; //uri: /eam/ajax/report/issue-mat-excel -> App\Http\Controllers\EAM\Ajax\ReportController.exportSummaryMonth()

var eam_ajax_report_closedWo = 'eam.ajax.report.closed-wo'; //uri: /eam/ajax/report/closed-wo -> App\Http\Controllers\EAM\Ajax\ReportController.closedWorkOrder()

var eam_ajax_report_closedWo2 = 'eam.ajax.report.closed-wo2'; //uri: /eam/ajax/report/closed-wo2 -> App\Http\Controllers\EAM\Ajax\ReportController.closedWorkOrder2()

var eam_ajax_report_jobAccountDel = 'eam.ajax.report.job-account-del'; //uri: /eam/ajax/report/job-account-del -> App\Http\Controllers\EAM\Ajax\ReportController.jobAccountDel()

var eam_ajax_report_requestMatInv = 'eam.ajax.report.request-mat-inv'; //uri: /eam/ajax/report/request-mat-inv -> App\Http\Controllers\EAM\Ajax\ReportController.requestMatInv()

var eam_ajax_report_requestMatNon = 'eam.ajax.report.request-mat-non'; //uri: /eam/ajax/report/request-mat-non -> App\Http\Controllers\EAM\Ajax\ReportController.requestMatNon()

var eam_ajax_report_woComStatus = 'eam.ajax.report.wo-com-status'; //uri: /eam/ajax/report/wo-com-status -> App\Http\Controllers\EAM\Ajax\ReportController.woComStatus()

var eam_ajax_report_summaryMatStatus = 'eam.ajax.report.summary-mat-status'; //uri: /eam/ajax/report/summary-mat-status -> App\Http\Controllers\EAM\Ajax\ReportController.summaryMatStatus()

var eam_workRequests_create = 'eam.work-requests.create'; //uri: /eam/work-requests/create -> App\Http\Controllers\EAM\WorkRequestController.create()

var eam_workRequests_index = 'eam.work-requests.index'; //uri: /eam/work-requests -> App\Http\Controllers\EAM\WorkRequestController.index()

var eam_workRequests_waitingApprove = 'eam.work-requests.waiting-approve'; //uri: /eam/work-requests/waiting-approve -> App\Http\Controllers\EAM\WorkRequestController.waitingApprove()

var eam_workOrders_create = 'eam.work-orders.create'; //uri: /eam/work-orders/create -> App\Http\Controllers\EAM\WorkOrderController.create()

var eam_workOrders_waitingOpenWork = 'eam.work-orders.waiting-open-work'; //uri: /eam/work-orders/waiting-open-work -> App\Http\Controllers\EAM\WorkOrderController.waitingOpenWork()

var eam_workOrders_listAllRepairJobs = 'eam.work-orders.list-all-repair-jobs'; //uri: /eam/work-orders/list-all-repair-jobs -> App\Http\Controllers\EAM\WorkOrderController.listAllRepairJobs()

var eam_workOrders_listRepairJobsWaitingClose = 'eam.work-orders.list-repair-jobs-waiting-close'; //uri: /eam/work-orders/list-repair-jobs-waiting-close -> App\Http\Controllers\EAM\WorkOrderController.listRepairJobsWaitingClose()

var eam_workOrders_confirmedListRepairWork = 'eam.work-orders.confirmed-list-repair-work'; //uri: /eam/work-orders/confirmed-list-repair-work -> App\Http\Controllers\EAM\WorkOrderController.confirmedListRepairWork()

var eam_askForInformation_partsTransferredWarehouse = 'eam.ask-for-information.parts-transferred-warehouse'; //uri: /eam/ask-for-information/parts-transferred-warehouse -> App\Http\Controllers\EAM\AskForInformationController.partsTransferredWarehouse()

var eam_askForInformation_checkSparePartsInventory = 'eam.ask-for-information.check-spare-parts-inventory'; //uri: /eam/ask-for-information/check-spare-parts-inventory -> App\Http\Controllers\EAM\AskForInformationController.checkSparePartsInventory()

var eam_setup_machine = 'eam.setup.machine'; //uri: /eam/setup/machine -> App\Http\Controllers\EAM\SetupController.machine()

var eam_transaction_preventiveMaintenancePlan = 'eam.transaction.preventive-maintenance-plan'; //uri: /eam/transaction/preventive-maintenance-plan -> App\Http\Controllers\EAM\TransactionController.preventiveMaintenancePlan()

var eam_report_billMaterials = 'eam.report.bill-materials'; //uri: /eam/report/bill-materials -> App\Http\Controllers\EAM\ReportController.billMaterials()

var eam_report_summaryMonth = 'eam.report.summary-month'; //uri: /eam/report/summary-month -> App\Http\Controllers\EAM\ReportController.summaryMonth()

var eam_report_summaryMonthExcel = 'eam.report.summary-month-excel'; //uri: /eam/report/summary-month-excel -> App\Http\Controllers\EAM\ReportController.summaryMonthExcel()

var eam_report_issueMatExcel = 'eam.report.issue-mat-excel'; //uri: /eam/report/issue-mat-excel -> App\Http\Controllers\EAM\ReportController.issueMatExcel()

var eam_report_payable = 'eam.report.payable'; //uri: /eam/report/payable -> App\Http\Controllers\EAM\ReportController.payable()

var eam_report_closedWo = 'eam.report.closed-wo'; //uri: /eam/report/closed-wo -> App\Http\Controllers\EAM\ReportController.closedWo()

var eam_report_closedWo2 = 'eam.report.closed-wo2'; //uri: /eam/report/closed-wo2 -> App\Http\Controllers\EAM\ReportController.closedWo2()

var eam_report_closedWoJp = 'eam.report.closed-wo-jp'; //uri: /eam/report/closed-wo-jp -> App\Http\Controllers\EAM\ReportController.closedWoJp()

var eam_report_mntHistory = 'eam.report.mnt-history'; //uri: /eam/report/mnt-history -> App\Http\Controllers\EAM\ReportController.mntHistory()

var eam_report_maintenance = 'eam.report.maintenance'; //uri: /eam/report/maintenance -> App\Http\Controllers\EAM\ReportController.maintenance()

var eam_report_jobAccountDel = 'eam.report.job-account-del'; //uri: /eam/report/job-account-del -> App\Http\Controllers\EAM\ReportController.jobAccountDel()

var eam_report_purchase = 'eam.report.purchase'; //uri: /eam/report/purchase -> App\Http\Controllers\EAM\ReportController.purchase()

var eam_report_requestMatInv = 'eam.report.request-mat-inv'; //uri: /eam/report/request-mat-inv -> App\Http\Controllers\EAM\ReportController.requestMatInv()

var eam_report_requestMatNon = 'eam.report.request-mat-non'; //uri: /eam/report/request-mat-non -> App\Http\Controllers\EAM\ReportController.requestMatNon()

var eam_report_jobAccount = 'eam.report.job-account'; //uri: /eam/report/job-account -> App\Http\Controllers\EAM\ReportController.jobAccount()

var eam_report_laborAccount = 'eam.report.labor-account'; //uri: /eam/report/labor-account -> App\Http\Controllers\EAM\ReportController.laborAccount()

var eam_report_woComStatus = 'eam.report.wo-com-status'; //uri: /eam/report/wo-com-status -> App\Http\Controllers\EAM\ReportController.woComStatus()

var eam_report_labor = 'eam.report.labor'; //uri: /eam/report/labor -> App\Http\Controllers\EAM\ReportController.labor()

var eam_report_woCost = 'eam.report.wo-cost'; //uri: /eam/report/wo-cost -> App\Http\Controllers\EAM\ReportController.woCost()

var eam_report_summaryLabor = 'eam.report.summary-labor'; //uri: /eam/report/summary-labor -> App\Http\Controllers\EAM\ReportController.summaryLabor()

var eam_report_receiptMat = 'eam.report.receipt-mat'; //uri: /eam/report/receipt-mat -> App\Http\Controllers\EAM\ReportController.receiptMat()

var eam_report_summaryMatStatus = 'eam.report.summary-mat-status'; //uri: /eam/report/summary-mat-status -> App\Http\Controllers\EAM\ReportController.summaryMatStatus()

var om_ajax_ = 'om.ajax.'; //uri: /om/ajax/debitnote_ranchtran_export/getorderlist -> App\Http\Controllers\OM\Ajex\DebitNote\DebitNoteExportAjaxController.getOrderList()

var om_ajax_coaMapping_index = 'om.ajax.coa-mapping.index'; //uri: /om/ajax/coa-mapping -> App\Http\Controllers\OM\Ajax\AccountSegmentController.index()

var om_ajax_vendor_index = 'om.ajax.vendor.index'; //uri: /om/ajax/vendor -> App\Http\Controllers\OM\Ajax\VendorController.index()

var om_ajax_searchOrder_index = 'om.ajax.search-order.index'; //uri: /om/ajax/search-order -> App\Http\Controllers\OM\Ajax\SearchOrderPeriodController.index()

var om_ajax_getOrder_index = 'om.ajax.get-order.index'; //uri: /om/ajax/get-order -> App\Http\Controllers\OM\Ajax\SearchOrderPeriodController.getOrder()

var om_ajax_getItemCate_index = 'om.ajax.get-item-cate.index'; //uri: /om/ajax/get-item-cate -> App\Http\Controllers\OM\Ajax\SequenceEcomItemController.getItemCate()

var om_ajax_getItem_index = 'om.ajax.get-item.index'; //uri: /om/ajax/get-item -> App\Http\Controllers\OM\Ajax\SequenceEcomItemController.getItem()

var om_ajax_getBankBranchs_index = 'om.ajax.get-bank-branchs.index'; //uri: /om/ajax/get-bank-branchs -> App\Http\Controllers\OM\Ajax\DirectDebitBankController.getBankBranchs()

var om_ajax_getCheckHeader_index = 'om.ajax.get-check-header.index'; //uri: /om/ajax/get-check-header -> App\Http\Controllers\OM\Ajax\PriceListCheckController.checkHeader()

var om_ajax_getCheckHeaderDateTo_index = 'om.ajax.get-check-header-date-to.index'; //uri: /om/ajax/get-check-header-date-to -> App\Http\Controllers\OM\Ajax\PriceListCheckController.checkHeaderDateTo()

var om_settings_term_index = 'om.settings.term.index'; //uri: /om/settings/term -> App\Http\Controllers\OM\Settings\PaymentTermController.index()

var om_settings_term_create = 'om.settings.term.create'; //uri: /om/settings/term/create -> App\Http\Controllers\OM\Settings\PaymentTermController.create()

var om_settings_term_store = 'om.settings.term.store'; //uri: /om/settings/term -> App\Http\Controllers\OM\Settings\PaymentTermController.store()

var om_settings_term_edit = 'om.settings.term.edit'; //uri: /om/settings/term/{term}/edit -> App\Http\Controllers\OM\Settings\PaymentTermController.edit()

var om_settings_term_update = 'om.settings.term.update'; //uri: /om/settings/term/{term} -> App\Http\Controllers\OM\Settings\PaymentTermController.update()

var om_settings_termExport_index = 'om.settings.term-export.index'; //uri: /om/settings/term-export -> App\Http\Controllers\OM\Settings\PaymentTermExportController.index()

var om_settings_termExport_create = 'om.settings.term-export.create'; //uri: /om/settings/term-export/create -> App\Http\Controllers\OM\Settings\PaymentTermExportController.create()

var om_settings_termExport_store = 'om.settings.term-export.store'; //uri: /om/settings/term-export -> App\Http\Controllers\OM\Settings\PaymentTermExportController.store()

var om_settings_termExport_edit = 'om.settings.term-export.edit'; //uri: /om/settings/term-export/{term}/edit -> App\Http\Controllers\OM\Settings\PaymentTermExportController.edit()

var om_settings_termExport_update = 'om.settings.term-export.update'; //uri: /om/settings/term-export/{term} -> App\Http\Controllers\OM\Settings\PaymentTermExportController.update()

var om_settings_country_index = 'om.settings.country.index'; //uri: /om/settings/country -> App\Http\Controllers\OM\Settings\CountryController.index()

var om_settings_country_create = 'om.settings.country.create'; //uri: /om/settings/country/create -> App\Http\Controllers\OM\Settings\CountryController.create()

var om_settings_country_store = 'om.settings.country.store'; //uri: /om/settings/country -> App\Http\Controllers\OM\Settings\CountryController.store()

var om_settings_country_edit = 'om.settings.country.edit'; //uri: /om/settings/country/{id}/edit -> App\Http\Controllers\OM\Settings\CountryController.edit()

var om_settings_country_update = 'om.settings.country.update'; //uri: /om/settings/country/{id} -> App\Http\Controllers\OM\Settings\CountryController.update()

var om_settings_customer_index = 'om.settings.customer.index'; //uri: /om/settings/customer -> App\Http\Controllers\OM\Settings\CustomerApprovalController.index()

var om_settings_customer_create = 'om.settings.customer.create'; //uri: /om/settings/customer/create -> App\Http\Controllers\OM\Settings\CustomerApprovalController.create()

var om_settings_customer_store = 'om.settings.customer.store'; //uri: /om/settings/customer -> App\Http\Controllers\OM\Settings\CustomerApprovalController.store()

var om_settings_customer_edit = 'om.settings.customer.edit'; //uri: /om/settings/customer/{id}/edit -> App\Http\Controllers\OM\Settings\CustomerApprovalController.edit()

var om_settings_customer_update = 'om.settings.customer.update'; //uri: /om/settings/customer/{id} -> App\Http\Controllers\OM\Settings\CustomerApprovalController.update()

var om_settings_customer_primaryApproval = 'om.settings.customer.primary-approval'; //uri: /om/settings/customer/primary-approval -> App\Http\Controllers\OM\Settings\CustomerApprovalController.primaryApproval()

var om_settings_sequenceEcom_index = 'om.settings.sequence-ecom.index'; //uri: /om/settings/sequence-ecom -> App\Http\Controllers\OM\Settings\SequenceEcomController.index()

var om_settings_sequenceEcom_create = 'om.settings.sequence-ecom.create'; //uri: /om/settings/sequence-ecom/create -> App\Http\Controllers\OM\Settings\SequenceEcomController.create()

var om_settings_sequenceEcom_store = 'om.settings.sequence-ecom.store'; //uri: /om/settings/sequence-ecom -> App\Http\Controllers\OM\Settings\SequenceEcomController.store()

var om_settings_sequenceEcom_edit = 'om.settings.sequence-ecom.edit'; //uri: /om/settings/sequence-ecom/{ecom}/edit -> App\Http\Controllers\OM\Settings\SequenceEcomController.edit()

var om_settings_sequenceEcom_update = 'om.settings.sequence-ecom.update'; //uri: /om/settings/sequence-ecom/{ecom} -> App\Http\Controllers\OM\Settings\SequenceEcomController.update()

var om_settings_quotaCreditGroup_index = 'om.settings.quota-credit-group.index'; //uri: /om/settings/quota-credit-group -> App\Http\Controllers\OM\Settings\QuotaCreditGroupController.index()

var om_settings_quotaCreditGroup_create = 'om.settings.quota-credit-group.create'; //uri: /om/settings/quota-credit-group/create -> App\Http\Controllers\OM\Settings\QuotaCreditGroupController.create()

var om_settings_quotaCreditGroup_store = 'om.settings.quota-credit-group.store'; //uri: /om/settings/quota-credit-group -> App\Http\Controllers\OM\Settings\QuotaCreditGroupController.store()

var om_settings_quotaCreditGroup_edit = 'om.settings.quota-credit-group.edit'; //uri: /om/settings/quota-credit-group/{id}/edit -> App\Http\Controllers\OM\Settings\QuotaCreditGroupController.edit()

var om_settings_quotaCreditGroup_update = 'om.settings.quota-credit-group.update'; //uri: /om/settings/quota-credit-group/{id} -> App\Http\Controllers\OM\Settings\QuotaCreditGroupController.update()

var om_settings_grantSpacialCase_index = 'om.settings.grant-spacial-case.index'; //uri: /om/settings/grant-spacial-case -> App\Http\Controllers\OM\Settings\GrantSpacialCaseController.index()

var om_settings_grantSpacialCase_create = 'om.settings.grant-spacial-case.create'; //uri: /om/settings/grant-spacial-case/create -> App\Http\Controllers\OM\Settings\GrantSpacialCaseController.create()

var om_settings_grantSpacialCase_store = 'om.settings.grant-spacial-case.store'; //uri: /om/settings/grant-spacial-case -> App\Http\Controllers\OM\Settings\GrantSpacialCaseController.store()

var om_settings_grantSpacialCase_edit = 'om.settings.grant-spacial-case.edit'; //uri: /om/settings/grant-spacial-case/{id}/edit -> App\Http\Controllers\OM\Settings\GrantSpacialCaseController.edit()

var om_settings_grantSpacialCase_update = 'om.settings.grant-spacial-case.update'; //uri: /om/settings/grant-spacial-case/{id} -> App\Http\Controllers\OM\Settings\GrantSpacialCaseController.update()

var om_settings_grantSpacialCase_delete = 'om.settings.grant-spacial-case.delete'; //uri: /om/settings/grant-spacial-case/{id} -> App\Http\Controllers\OM\Settings\GrantSpacialCaseController.destroy()

var om_settings_authorityList_index = 'om.settings.authority-list.index'; //uri: /om/settings/authority-list -> App\Http\Controllers\OM\Settings\AuthoRityListController.index()

var om_settings_authorityList_create = 'om.settings.authority-list.create'; //uri: /om/settings/authority-list/create -> App\Http\Controllers\OM\Settings\AuthoRityListController.create()

var om_settings_authorityList_store = 'om.settings.authority-list.store'; //uri: /om/settings/authority-list -> App\Http\Controllers\OM\Settings\AuthoRityListController.store()

var om_settings_authorityList_edit = 'om.settings.authority-list.edit'; //uri: /om/settings/authority-list/{id}/edit -> App\Http\Controllers\OM\Settings\AuthoRityListController.edit()

var om_settings_authorityList_update = 'om.settings.authority-list.update'; //uri: /om/settings/authority-list/{id} -> App\Http\Controllers\OM\Settings\AuthoRityListController.update()

var om_settings_overQuotaApproval_index = 'om.settings.over-quota-approval.index'; //uri: /om/settings/over-quota-approval -> App\Http\Controllers\OM\Settings\OverQuotaApprovalController.index()

var om_settings_overQuotaApproval_create = 'om.settings.over-quota-approval.create'; //uri: /om/settings/over-quota-approval/create -> App\Http\Controllers\OM\Settings\OverQuotaApprovalController.create()

var om_settings_overQuotaApproval_store = 'om.settings.over-quota-approval.store'; //uri: /om/settings/over-quota-approval -> App\Http\Controllers\OM\Settings\OverQuotaApprovalController.store()

var om_settings_overQuotaApproval_edit = 'om.settings.over-quota-approval.edit'; //uri: /om/settings/over-quota-approval/{id}/edit -> App\Http\Controllers\OM\Settings\OverQuotaApprovalController.edit()

var om_settings_overQuotaApproval_update = 'om.settings.over-quota-approval.update'; //uri: /om/settings/over-quota-approval/{id} -> App\Http\Controllers\OM\Settings\OverQuotaApprovalController.update()

var om_settings_overQuotaApproval_delete = 'om.settings.over-quota-approval.delete'; //uri: /om/settings/over-quota-approval/{id} -> App\Http\Controllers\OM\Settings\OverQuotaApprovalController.destroy()

var om_settings_itemWeight_index = 'om.settings.item-weight.index'; //uri: /om/settings/item-weight -> App\Http\Controllers\OM\Settings\ItemWeightController.index()

var om_settings_itemWeight_create = 'om.settings.item-weight.create'; //uri: /om/settings/item-weight/create -> App\Http\Controllers\OM\Settings\ItemWeightController.create()

var om_settings_itemWeight_store = 'om.settings.item-weight.store'; //uri: /om/settings/item-weight -> App\Http\Controllers\OM\Settings\ItemWeightController.store()

var om_settings_itemWeight_edit = 'om.settings.item-weight.edit'; //uri: /om/settings/item-weight/{id}/edit -> App\Http\Controllers\OM\Settings\ItemWeightController.edit()

var om_settings_itemWeight_update = 'om.settings.item-weight.update'; //uri: /om/settings/item-weight/{id} -> App\Http\Controllers\OM\Settings\ItemWeightController.update()

var om_settings_thailandTerritory_index = 'om.settings.thailand-territory.index'; //uri: /om/settings/thailand-territory -> App\Http\Controllers\OM\Settings\ThailandTerritoryController.index()

var om_settings_thailandTerritory_previewImport = 'om.settings.thailand-territory.preview-import'; //uri: /om/settings/thailand-territory/preview-import -> App\Http\Controllers\OM\Settings\ThailandTerritoryController.previewImport()

var om_settings_thailandTerritory_import = 'om.settings.thailand-territory.import'; //uri: /om/settings/thailand-territory/import -> App\Http\Controllers\OM\Settings\ThailandTerritoryController.import()

var om_settings_thailandTerritory_downloadExcelTemplate = 'om.settings.thailand-territory.download-excel-template'; //uri: /om/settings/thailand-territory/download-excel-template -> App\Http\Controllers\OM\Settings\ThailandTerritoryController.export()

var om_settings_directDebitDomestic_index = 'om.settings.direct-debit-domestic.index'; //uri: /om/settings/direct-debit-domestic -> App\Http\Controllers\OM\Settings\DirectDebitDomesticController.index()

var om_settings_directDebitDomestic_create = 'om.settings.direct-debit-domestic.create'; //uri: /om/settings/direct-debit-domestic/create -> App\Http\Controllers\OM\Settings\DirectDebitDomesticController.create()

var om_settings_directDebitDomestic_store = 'om.settings.direct-debit-domestic.store'; //uri: /om/settings/direct-debit-domestic -> App\Http\Controllers\OM\Settings\DirectDebitDomesticController.store()

var om_settings_directDebitDomestic_edit = 'om.settings.direct-debit-domestic.edit'; //uri: /om/settings/direct-debit-domestic/{id}/edit -> App\Http\Controllers\OM\Settings\DirectDebitDomesticController.edit()

var om_settings_directDebitDomestic_update = 'om.settings.direct-debit-domestic.update'; //uri: /om/settings/direct-debit-domestic/{id} -> App\Http\Controllers\OM\Settings\DirectDebitDomesticController.update()

var om_settings_directDebitExport_index = 'om.settings.direct-debit-export.index'; //uri: /om/settings/direct-debit-export -> App\Http\Controllers\OM\Settings\DirectDebitExportController.index()

var om_settings_directDebitExport_create = 'om.settings.direct-debit-export.create'; //uri: /om/settings/direct-debit-export/create -> App\Http\Controllers\OM\Settings\DirectDebitExportController.create()

var om_settings_directDebitExport_store = 'om.settings.direct-debit-export.store'; //uri: /om/settings/direct-debit-export -> App\Http\Controllers\OM\Settings\DirectDebitExportController.store()

var om_settings_directDebitExport_edit = 'om.settings.direct-debit-export.edit'; //uri: /om/settings/direct-debit-export/{id}/edit -> App\Http\Controllers\OM\Settings\DirectDebitExportController.edit()

var om_settings_directDebitExport_update = 'om.settings.direct-debit-export.update'; //uri: /om/settings/direct-debit-export/{id} -> App\Http\Controllers\OM\Settings\DirectDebitExportController.update()

var om_settings_notAutoRelease_index = 'om.settings.not-auto-release.index'; //uri: /om/settings/not-auto-release -> App\Http\Controllers\OM\Settings\NotAutoReleaseReceiptController.index()

var om_settings_notAutoRelease_create = 'om.settings.not-auto-release.create'; //uri: /om/settings/not-auto-release/create -> App\Http\Controllers\OM\Settings\NotAutoReleaseReceiptController.create()

var om_settings_notAutoRelease_store = 'om.settings.not-auto-release.store'; //uri: /om/settings/not-auto-release -> App\Http\Controllers\OM\Settings\NotAutoReleaseReceiptController.store()

var om_settings_notAutoRelease_edit = 'om.settings.not-auto-release.edit'; //uri: /om/settings/not-auto-release/{id}/edit -> App\Http\Controllers\OM\Settings\NotAutoReleaseReceiptController.edit()

var om_settings_notAutoRelease_update = 'om.settings.not-auto-release.update'; //uri: /om/settings/not-auto-release/{id} -> App\Http\Controllers\OM\Settings\NotAutoReleaseReceiptController.update()

var om_settings_approverOrder_index = 'om.settings.approver-order.index'; //uri: /om/settings/approver-order -> App\Http\Controllers\OM\Settings\ApproverOrderController.index()

var om_settings_approverOrder_create = 'om.settings.approver-order.create'; //uri: /om/settings/approver-order/create -> App\Http\Controllers\OM\Settings\ApproverOrderController.create()

var om_settings_approverOrder_store = 'om.settings.approver-order.store'; //uri: /om/settings/approver-order -> App\Http\Controllers\OM\Settings\ApproverOrderController.store()

var om_settings_approverOrder_edit = 'om.settings.approver-order.edit'; //uri: /om/settings/approver-order/{id}/edit -> App\Http\Controllers\OM\Settings\ApproverOrderController.edit()

var om_settings_approverOrder_update = 'om.settings.approver-order.update'; //uri: /om/settings/approver-order/{id} -> App\Http\Controllers\OM\Settings\ApproverOrderController.update()

var om_settings_accountMapping_index = 'om.settings.account-mapping.index'; //uri: /om/settings/account-mapping -> App\Http\Controllers\OM\Settings\AccountMappingController.index()

var om_settings_accountMapping_create = 'om.settings.account-mapping.create'; //uri: /om/settings/account-mapping/create -> App\Http\Controllers\OM\Settings\AccountMappingController.create()

var om_settings_accountMapping_store = 'om.settings.account-mapping.store'; //uri: /om/settings/account-mapping -> App\Http\Controllers\OM\Settings\AccountMappingController.store()

var om_settings_accountMapping_edit = 'om.settings.account-mapping.edit'; //uri: /om/settings/account-mapping/{id}/edit -> App\Http\Controllers\OM\Settings\AccountMappingController.edit()

var om_settings_accountMapping_update = 'om.settings.account-mapping.update'; //uri: /om/settings/account-mapping/{id} -> App\Http\Controllers\OM\Settings\AccountMappingController.update()

var om_settings_transportOwner_index = 'om.settings.transport-owner.index'; //uri: /om/settings/transport-owner -> App\Http\Controllers\OM\Settings\TransportOwnersController.index()

var om_settings_transportOwner_create = 'om.settings.transport-owner.create'; //uri: /om/settings/transport-owner/create -> App\Http\Controllers\OM\Settings\TransportOwnersController.create()

var om_settings_transportOwner_store = 'om.settings.transport-owner.store'; //uri: /om/settings/transport-owner -> App\Http\Controllers\OM\Settings\TransportOwnersController.store()

var om_settings_transportOwner_edit = 'om.settings.transport-owner.edit'; //uri: /om/settings/transport-owner/{id}/edit -> App\Http\Controllers\OM\Settings\TransportOwnersController.edit()

var om_settings_transportOwner_update = 'om.settings.transport-owner.update'; //uri: /om/settings/transport-owner/{id} -> App\Http\Controllers\OM\Settings\TransportOwnersController.update()

var om_settings_transportOwner_delete = 'om.settings.transport-owner.delete'; //uri: /om/settings/transport-owner/{id} -> App\Http\Controllers\OM\Settings\TransportOwnersController.destroy()

var om_settings_transportationRoute_index = 'om.settings.transportation-route.index'; //uri: /om/settings/transportation-route -> App\Http\Controllers\OM\Settings\TransportationRoutesController.index()

var om_settings_transportationRoute_create = 'om.settings.transportation-route.create'; //uri: /om/settings/transportation-route/create -> App\Http\Controllers\OM\Settings\TransportationRoutesController.create()

var om_settings_transportationRoute_store = 'om.settings.transportation-route.store'; //uri: /om/settings/transportation-route -> App\Http\Controllers\OM\Settings\TransportationRoutesController.store()

var om_settings_transportationRoute_edit = 'om.settings.transportation-route.edit'; //uri: /om/settings/transportation-route/{id}/edit -> App\Http\Controllers\OM\Settings\TransportationRoutesController.edit()

var om_settings_transportationRoute_update = 'om.settings.transportation-route.update'; //uri: /om/settings/transportation-route/{id} -> App\Http\Controllers\OM\Settings\TransportationRoutesController.update()

var om_settings_transportationRoute_delete = 'om.settings.transportation-route.delete'; //uri: /om/settings/transportation-route/{id} -> App\Http\Controllers\OM\Settings\TransportationRoutesController.destroy()

var om_settings_orderPeriod_index = 'om.settings.order-period.index'; //uri: /om/settings/order-period -> App\Http\Controllers\OM\Settings\OrderPeriodController.index()

var om_settings_orderPeriod_create = 'om.settings.order-period.create'; //uri: /om/settings/order-period/create -> App\Http\Controllers\OM\Settings\OrderPeriodController.create()

var om_settings_orderPeriod_store = 'om.settings.order-period.store'; //uri: /om/settings/order-period -> App\Http\Controllers\OM\Settings\OrderPeriodController.store()

var om_settings_orderPeriod_edit = 'om.settings.order-period.edit'; //uri: /om/settings/order-period/{id}/edit -> App\Http\Controllers\OM\Settings\OrderPeriodController.edit()

var om_settings_orderPeriod_update = 'om.settings.order-period.update'; //uri: /om/settings/order-period/{id} -> App\Http\Controllers\OM\Settings\OrderPeriodController.update()

var om_settings_approverOrderExport_index = 'om.settings.approver-order-export.index'; //uri: /om/settings/approver-order-export -> App\Http\Controllers\OM\Settings\ApproverOrderExportController.index()

var om_settings_approverOrderExport_create = 'om.settings.approver-order-export.create'; //uri: /om/settings/approver-order-export/create -> App\Http\Controllers\OM\Settings\ApproverOrderExportController.create()

var om_settings_approverOrderExport_store = 'om.settings.approver-order-export.store'; //uri: /om/settings/approver-order-export -> App\Http\Controllers\OM\Settings\ApproverOrderExportController.store()

var om_settings_approverOrderExport_edit = 'om.settings.approver-order-export.edit'; //uri: /om/settings/approver-order-export/{id}/edit -> App\Http\Controllers\OM\Settings\ApproverOrderExportController.edit()

var om_settings_approverOrderExport_update = 'om.settings.approver-order-export.update'; //uri: /om/settings/approver-order-export/{id} -> App\Http\Controllers\OM\Settings\ApproverOrderExportController.update()

var om_approvalClaim_index = 'om.approval-claim.index'; //uri: /om/approval-claim -> App\Http\Controllers\OM\ApprovalClaimController.index()

var om_outstanding_index = 'om.outstanding.index'; //uri: /om/outstanding -> App\Http\Controllers\OM\OutstandingController.index()

var om_outstanding_getData = 'om.outstanding.getData'; //uri: /om/outstanding-list -> App\Http\Controllers\OM\OutstandingController.getData()

var om_outstanding_getYear = 'om.outstanding.getYear'; //uri: /om/outstanding-year -> App\Http\Controllers\OM\OutstandingController.getYear()

var om_improveFine_index = 'om.improve-fine.index'; //uri: /om/improve-fine -> App\Http\Controllers\OM\ImproveFineController.index()

var om_improveFine_store = 'om.improve-fine.store'; //uri: /om/improve-fine -> App\Http\Controllers\OM\ImproveFineController.store()

var om_settings_priceList_index = 'om.settings.price-list.index'; //uri: /om/settings/price-list -> App\Http\Controllers\OM\Settings\PriceListController.index()

var om_settings_priceList_create = 'om.settings.price-list.create'; //uri: /om/settings/price-list/create -> App\Http\Controllers\OM\Settings\PriceListController.create()

var om_settings_priceList_store = 'om.settings.price-list.store'; //uri: /om/settings/price-list -> App\Http\Controllers\OM\Settings\PriceListController.store()

var om_settings_priceList_show = 'om.settings.price-list.show'; //uri: /om/settings/price-list/{id}/show -> App\Http\Controllers\OM\Settings\PriceListController.show()

var om_settings_priceList_edit = 'om.settings.price-list.edit'; //uri: /om/settings/price-list/{id}/edit -> App\Http\Controllers\OM\Settings\PriceListController.edit()

var om_settings_priceList_update = 'om.settings.price-list.update'; //uri: /om/settings/price-list/{id} -> App\Http\Controllers\OM\Settings\PriceListController.update()

var om_settings_priceListExport_index = 'om.settings.price-list-export.index'; //uri: /om/settings/price-list-export -> App\Http\Controllers\OM\Settings\PriceListExportController.index()

var om_settings_priceListExport_create = 'om.settings.price-list-export.create'; //uri: /om/settings/price-list-export/create -> App\Http\Controllers\OM\Settings\PriceListExportController.create()

var om_settings_priceListExport_store = 'om.settings.price-list-export.store'; //uri: /om/settings/price-list-export -> App\Http\Controllers\OM\Settings\PriceListExportController.store()

var om_settings_priceListExport_show = 'om.settings.price-list-export.show'; //uri: /om/settings/price-list-export/{id}/show -> App\Http\Controllers\OM\Settings\PriceListExportController.show()

var om_settings_priceListExport_edit = 'om.settings.price-list-export.edit'; //uri: /om/settings/price-list-export/{id}/edit -> App\Http\Controllers\OM\Settings\PriceListExportController.edit()

var om_settings_priceListExport_update = 'om.settings.price-list-export.update'; //uri: /om/settings/price-list-export/{id} -> App\Http\Controllers\OM\Settings\PriceListExportController.update()

var om_ajax_customers_exports_exports_list = 'om.ajax.customers.exports.exports.list'; //uri: /om/ajax/customers/exports/list -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.List()

var om_ajax_customers_exports_exports_type = 'om.ajax.customers.exports.exports.type'; //uri: /om/ajax/customers/exports/type -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.Type()

var om_ajax_customers_exports_exports_country = 'om.ajax.customers.exports.exports.country'; //uri: /om/ajax/customers/exports/country -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.Country()

var om_ajax_customers_exports_ = 'om.ajax.customers.exports.'; //uri: /om/ajax/customers/exports/delcustomershipping/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.delCustomerShipping()

var om_ajax_customers_exports_foreign_customercontactList = 'om.ajax.customers.exports.foreign.customercontact_list'; //uri: /om/ajax/customers/exports/customercontact_list/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.CustomerContactList()

var om_ajax_customers_exports_foreign_customershippingList = 'om.ajax.customers.exports.foreign.customershipping_list'; //uri: /om/ajax/customers/exports/customershipping_list/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.CustomerShippingList()

var om_ajax_customers_exports_foreign_insertcustomercontact = 'om.ajax.customers.exports.foreign.insertcustomercontact'; //uri: /om/ajax/customers/exports/insertcustomercontact/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.insertCustomerContact()

var om_ajax_customers_exports_foreign_updatecustomercontact = 'om.ajax.customers.exports.foreign.updatecustomercontact'; //uri: /om/ajax/customers/exports/updatecustomercontact/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.updateCustomerContact()

var om_ajax_customers_exports_foreign_insertcustomershipping = 'om.ajax.customers.exports.foreign.insertcustomershipping'; //uri: /om/ajax/customers/exports/insertcustomershipping/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.insertCustomerShipping()

var om_ajax_customers_exports_foreign_updatecustomershipping = 'om.ajax.customers.exports.foreign.updatecustomershipping'; //uri: /om/ajax/customers/exports/updatecustomershipping/{id} -> App\Http\Controllers\OM\Ajex\Customers\Export\ExportAjaxController.updateCustomerShipping()

var om_ajax_customers_domestics_ = 'om.ajax.customers.domestics.'; //uri: /om/ajax/customers/domestics/remove -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteAgent()

var om_ajax_customers_domestics_domestics_insert_customers = 'om.ajax.customers.domestics.domestics.insert.customers'; //uri: /om/ajax/customers/domestics/insert-customers -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomers()

var om_ajax_customers_domestics_domestics_insert_customersShipsites = 'om.ajax.customers.domestics.domestics.insert.customers-shipsites'; //uri: /om/ajax/customers/domestics/insert-customers-shipsites -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersShipSites()

var om_ajax_customers_domestics_domestics_insert_customersPrevious = 'om.ajax.customers.domestics.domestics.insert.customers-previous'; //uri: /om/ajax/customers/domestics/insert-customers-previous -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersPrevious()

var om_ajax_customers_domestics_domestics_insert_customersOwner = 'om.ajax.customers.domestics.domestics.insert.customers-owner'; //uri: /om/ajax/customers/domestics/insert-customers-owner -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersOwner()

var om_ajax_customers_domestics_domestics_insert_customersContracts = 'om.ajax.customers.domestics.domestics.insert.customers-contracts'; //uri: /om/ajax/customers/domestics/insert-customers-contracts -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersContracts()

var om_ajax_customers_domestics_domestics_insert_customersContractbooks = 'om.ajax.customers.domestics.domestics.insert.customers-contractbooks'; //uri: /om/ajax/customers/domestics/insert-customers-contractbooks -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersContractBooks()

var om_ajax_customers_domestics_domestics_insert_customersContractgroup = 'om.ajax.customers.domestics.domestics.insert.customers-contractgroup'; //uri: /om/ajax/customers/domestics/insert-customers-contractgroup -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersContractGroups()

var om_ajax_customers_domestics_domestics_insert_customersQuota = 'om.ajax.customers.domestics.domestics.insert.customers-quota'; //uri: /om/ajax/customers/domestics/insert-customers-quota -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.insertCustomersQuota()

var om_ajax_customers_domestics_domestics_update_customers = 'om.ajax.customers.domestics.domestics.update.customers'; //uri: /om/ajax/customers/domestics/update-customers/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.updateCustomers()

var om_ajax_customers_domestics_domestics_update_customersPrevious = 'om.ajax.customers.domestics.domestics.update.customers-previous'; //uri: /om/ajax/customers/domestics/update-customers-previous/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.updateCustomersPrevious()

var om_ajax_customers_domestics_domestics_update_customersOwner = 'om.ajax.customers.domestics.domestics.update.customers-owner'; //uri: /om/ajax/customers/domestics/update-customers-owner/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.updateCustomersOwner()

var om_ajax_customers_domestics_domestics_update_customersShipsites = 'om.ajax.customers.domestics.domestics.update.customers-shipsites'; //uri: /om/ajax/customers/domestics/update-customers-shipsites/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.updateCustomersShipSites()

var om_ajax_customers_domestics_domestics_update_customersQuota = 'om.ajax.customers.domestics.domestics.update.customers-quota'; //uri: /om/ajax/customers/domestics/update-customers-quota/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.updateCustomersQuota()

var om_ajax_customers_domestics_previous = 'om.ajax.customers.domestics.previous'; //uri: /om/ajax/customers/domestics/previous/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.showPrevious()

var om_ajax_customers_domestics_owner = 'om.ajax.customers.domestics.owner'; //uri: /om/ajax/customers/domestics/owner/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.showOwner()

var om_ajax_customers_domestics_quotaHeaders = 'om.ajax.customers.domestics.quota-headers'; //uri: /om/ajax/customers/domestics/quota-headers/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.showQuotaHeaders()

var om_ajax_customers_domestics_shipSites = 'om.ajax.customers.domestics.ship-sites'; //uri: /om/ajax/customers/domestics/ship-sites/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.showShipSites()

var om_ajax_customers_domestics_quota_lines_items = 'om.ajax.customers.domestics.quota.lines.items'; //uri: /om/ajax/customers/domestics/quota-lines-item/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.showLinesItems()

var om_ajax_customers_domestics_province_list = 'om.ajax.customers.domestics.province.list'; //uri: /om/ajax/customers/domestics/province-list/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.provinceList()

var om_ajax_customers_domestics_city_list = 'om.ajax.customers.domestics.city.list'; //uri: /om/ajax/customers/domestics/city-list/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.cityList()

var om_ajax_customers_domestics_district_list = 'om.ajax.customers.domestics.district.list'; //uri: /om/ajax/customers/domestics/district-list/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.districtList()

var om_ajax_customers_domestics_postcode = 'om.ajax.customers.domestics.postcode'; //uri: /om/ajax/customers/domestics/postcode/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.postCode()

var om_ajax_customers_domestics_get_ship_site_name = 'om.ajax.customers.domestics.get.ship.site.name'; //uri: /om/ajax/customers/domestics/get-ship-site-name/{id}/{shipid} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.getShiptoSiteName()

var om_ajax_customers_domestics_get_customer_name = 'om.ajax.customers.domestics.get.customer.name'; //uri: /om/ajax/customers/domestics/get-customer-name/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.getCustomerName()

var om_ajax_customers_domestics_domestics_delete_customersShipsites = 'om.ajax.customers.domestics.domestics.delete.customers-shipsites'; //uri: /om/ajax/customers/domestics/delete-customers-shipsites/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersShipSites()

var om_ajax_customers_domestics_domestics_delete_customersPrevious = 'om.ajax.customers.domestics.domestics.delete.customers-previous'; //uri: /om/ajax/customers/domestics/delete-customers-previous/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersPrevious()

var om_ajax_customers_domestics_domestics_delete_customersOwner = 'om.ajax.customers.domestics.domestics.delete.customers-owner'; //uri: /om/ajax/customers/domestics/delete-customers-owner/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersOwner()

var om_ajax_customers_domestics_domestics_delete_customersContracts = 'om.ajax.customers.domestics.domestics.delete.customers-contracts'; //uri: /om/ajax/customers/domestics/delete-customers-contracts/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersContracts()

var om_ajax_customers_domestics_domestics_delete_customersContractbooks = 'om.ajax.customers.domestics.domestics.delete.customers-contractbooks'; //uri: /om/ajax/customers/domestics/delete-customers-contractbooks/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersContractBooks()

var om_ajax_customers_domestics_domestics_delete_customersContractgroups = 'om.ajax.customers.domestics.domestics.delete.customers-contractgroups'; //uri: /om/ajax/customers/domestics/delete-customers-contractgroups/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersContractGroups()

var om_ajax_customers_domestics_domestics_delete_customersQuota = 'om.ajax.customers.domestics.domestics.delete.customers-quota'; //uri: /om/ajax/customers/domestics/delete-customers-quota/{id}/{customer_id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersQuota()

var om_ajax_customers_domestics_domestics_delete_customersQuotaLine = 'om.ajax.customers.domestics.domestics.delete.customers-quota-line'; //uri: /om/ajax/customers/domestics/delete-customers-quota-line/{id} -> App\Http\Controllers\OM\Ajex\Customers\Domestics\DomesticsAjaxController.deleteCustomersQuotaLines()

var om_ajax_promotions_ = 'om.ajax.promotions.'; //uri: /om/ajax/promotions/search-group-product/{itemId} -> App\Http\Controllers\OM\Ajex\PromotionAjaxController.searchGroupProduct()

var om_ajax_promotions_store = 'om.ajax.promotions.store'; //uri: /om/ajax/promotions/store -> App\Http\Controllers\OM\Ajex\PromotionAjaxController.store()

var om_ajax_promotions_update = 'om.ajax.promotions.update'; //uri: /om/ajax/promotions/update -> App\Http\Controllers\OM\Ajex\PromotionAjaxController.update()

var om_ajax_promotions_remove = 'om.ajax.promotions.remove'; //uri: /om/ajax/promotions/remove -> App\Http\Controllers\OM\Ajex\PromotionAjaxController.remove()

var om_ajax_promotions_copy = 'om.ajax.promotions.copy'; //uri: /om/ajax/promotions/copy -> App\Http\Controllers\OM\Ajex\PromotionAjaxController.copyPromotion()

var om_ajax_releaseCredit_ = 'om.ajax.release_credit.'; //uri: /om/ajax/release-credit/customers/{id} -> App\Http\Controllers\OM\Ajex\ReleaseCreditAjaxController.customers()

var om_ajax_bank_ = 'om.ajax.bank.'; //uri: /om/ajax/bank/by-short-name/{id} -> App\Http\Controllers\OM\Ajex\BankAccountAjaxController.byShortName()

var om_ajax_postponeDelivery_ = 'om.ajax.postpone-delivery.'; //uri: /om/ajax/postpone-delivery/next-date/{number} -> App\Http\Controllers\OM\Ajex\PostponeDeliveryAjaxController.nextDate()

var om_ajax_postponeDelivery_periodByYears = 'om.ajax.postpone-delivery.period_by_years'; //uri: /om/ajax/postpone-delivery/period-by-years/{year} -> App\Http\Controllers\OM\Ajex\PostponeDeliveryAjaxController.periodByBudgetYear()

var om_ajax_transferBiWeekly_ = 'om.ajax.transfer-bi-weekly.'; //uri: /om/ajax/transfer-bi-weekly-export/sendfactory -> App\Http\Controllers\OM\Ajex\Saleorder\Export\TranferBiWeeklyExportAjaxController.sendFactory()

var om_ajax_overdueDebt_ = 'om.ajax.overdue-debt.'; //uri: /om/ajax/overdue-debt/search -> App\Http\Controllers\OM\Ajex\OverdueDebtAjaxController.searchOverdueDebt()

var om_ajax_overdueDebt_getCustomerName = 'om.ajax.overdue-debt.get-customer-name'; //uri: /om/ajax/overdue-debt/get-customer-name/{id} -> App\Http\Controllers\OM\Ajex\OverdueDebtAjaxController.getCustomersName()

var om_ajax_fortnightly = 'om.ajax.fortnightly'; //uri: /om/ajax/fortnightly/sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.sequenceEcoms()

var om_ajax_fortnightlyupdate_sequence_ecom = 'om.ajax.fortnightlyupdate.sequence.ecom'; //uri: /om/ajax/fortnightly/update-sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.updateSequenceEcoms()

var om_ajax_fortnightlydelete_sequence_ecom = 'om.ajax.fortnightlydelete.sequence.ecom'; //uri: /om/ajax/fortnightly/delete-sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.deleteSequenceEcoms()

var om_ajax_fortnightlyfilter_sequence_ecom = 'om.ajax.fortnightlyfilter.sequence.ecom'; //uri: /om/ajax/fortnightly/filter-sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.filterSequenceEcoms()

var om_ajax_biweeklyupdate_periods = 'om.ajax.biweeklyupdate.periods'; //uri: /om/ajax/biweekly/update-periods -> App\Http\Controllers\OM\Ajex\BiweeklyPeriodsdAjaxController.updateBiweeklyPeriods()

var om_ajax_biweeklyget_holiday = 'om.ajax.biweeklyget.holiday'; //uri: /om/ajax/biweekly/get-holiday/{number} -> App\Http\Controllers\OM\Ajex\BiweeklyPeriodsdAjaxController.getHoliday()

var om_ajax_biweeklysearch_periods = 'om.ajax.biweeklysearch.periods'; //uri: /om/ajax/biweekly/search-periods/{number} -> App\Http\Controllers\OM\Ajex\BiweeklyPeriodsdAjaxController.searchBiweeklyPeriods()

var om_ajax_transferMonthly_ = 'om.ajax.transfer-monthly.'; //uri: /om/ajax/transfer-monthly/inportexcel -> App\Http\Controllers\OM\Ajex\Saleorder\Domestic\TransferMonthlyAjaxController.importexcel()

var om_ajax_consignmentClubsearch_consignment = 'om.ajax.consignment-clubsearch.consignment'; //uri: /om/ajax/consignment-club/search-create -> App\Http\Controllers\OM\Ajex\ConsignmentClubAjaxController.createConsignment()

var om_ajax_consignmentClubget_order_lines = 'om.ajax.consignment-clubget.order.lines'; //uri: /om/ajax/consignment-club/get-order-lines/{number} -> App\Http\Controllers\OM\Ajex\ConsignmentClubAjaxController.getOrderLines()

var om_ajax_consignmentClubsearch_consignment_club = 'om.ajax.consignment-clubsearch.consignment.club'; //uri: /om/ajax/consignment-club/search-consignment-club -> App\Http\Controllers\OM\Ajex\ConsignmentClubAjaxController.searConsignment()

var om_ajax_consignmentClubupdate_consignment_club = 'om.ajax.consignment-clubupdate.consignment.club'; //uri: /om/ajax/consignment-club/update-consignment-club -> App\Http\Controllers\OM\Ajex\ConsignmentClubAjaxController.updateConsignment()

var om_ajax_saleConfirmationupdate_order = 'om.ajax.sale-confirmationupdate.order'; //uri: /om/ajax/sale-confirmation/update-order -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.updateOrderHeaders()

var om_ajax_saleConfirmationsearch = 'om.ajax.sale-confirmationsearch'; //uri: /om/ajax/sale-confirmation/search -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.search()

var om_ajax_saleConfirmationcreate_sale_confirmation = 'om.ajax.sale-confirmationcreate.sale.confirmation'; //uri: /om/ajax/sale-confirmation/create-sale-confirmation -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.createSaleConfirmation()

var om_ajax_saleConfirmationcopy_sale_number = 'om.ajax.sale-confirmationcopy.sale.number'; //uri: /om/ajax/sale-confirmation/copy-sale-number/{number} -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.copySaleConfirmationNumber()

var om_ajax_saleConfirmationcreate_sale_number = 'om.ajax.sale-confirmationcreate.sale.number'; //uri: /om/ajax/sale-confirmation/create-sale-number -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.createSaleConfirmationNumber()

var om_ajax_saleConfirmationupdate_sale_confirmation = 'om.ajax.sale-confirmationupdate.sale.confirmation'; //uri: /om/ajax/sale-confirmation/update-sale-confirmation -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.updateSaleConfirmation()

var om_ajax_saleConfirmationconfirm_sale_confirmation = 'om.ajax.sale-confirmationconfirm.sale.confirmation'; //uri: /om/ajax/sale-confirmation/confirm-sale-confirmation -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.confirmSaleConfirmation()

var om_ajax_saleConfirmationcopy_to_proforma_invoice = 'om.ajax.sale-confirmationcopy.to.proforma.invoice'; //uri: /om/ajax/sale-confirmation/copy-to-proforma-invoice -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.copyToProformaInvoice()

var om_ajax_saleConfirmationcheckCancel = 'om.ajax.sale-confirmationcheck-cancel'; //uri: /om/ajax/sale-confirmation/check-cancel/{number} -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.checkCancel()

var om_ajax_saleConfirmationcancel = 'om.ajax.sale-confirmationcancel'; //uri: /om/ajax/sale-confirmation/cancel -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.cancel()

var om_ajax_saleConfirmationcustomerShipsite = 'om.ajax.sale-confirmationcustomer-shipsite'; //uri: /om/ajax/sale-confirmation/customer-shipsite/{number} -> App\Http\Controllers\OM\Ajex\SaleConfirmationAjaxController.customerShipsite()

var om_ajax_approvePrepareOrdersearch = 'om.ajax.approve-prepare-ordersearch'; //uri: /om/ajax/approve-prepare-order/search -> App\Http\Controllers\OM\Ajex\ApprovePrepareOrderAjaxController.searchApprovePrepareOrder()

var om_ajax_approvePrepareOrdermanage = 'om.ajax.approve-prepare-ordermanage'; //uri: /om/ajax/approve-prepare-order/manage -> App\Http\Controllers\OM\Ajex\ApprovePrepareOrderAjaxController.managePrepareOrder()

var om_ajax_order_approveprepare_search = 'om.ajax.order.approveprepare.search'; //uri: /om/ajax/order/approveprepara/search -> App\Http\Controllers\OM\ApprovePrepareController.search()

var om_ajax_order_approveprepare_search_customer = 'om.ajax.order.approveprepare.search.customer'; //uri: /om/ajax/order/approveprepara/search/customer -> App\Http\Controllers\OM\ApprovePrepareController.searchCustomer()

var om_ajax_order_approveprepare_confirm = 'om.ajax.order.approveprepare.confirm'; //uri: /om/ajax/order/approveprepara/confirm -> App\Http\Controllers\OM\ApprovePrepareController.confirmOrder()

var om_ajax_order_approveprepare_cancel = 'om.ajax.order.approveprepare.cancel'; //uri: /om/ajax/order/approveprepara/cancel -> App\Http\Controllers\OM\ApprovePrepareController.cancelOrder()

var om_ajax_order_prepare_runNumber = 'om.ajax.order.prepare.run_number'; //uri: /om/ajax/order/prepare/run-number -> App\Http\Controllers\OM\Ajex\PrepareOrderAjaxController.runPrepareNumber()

var om_ajax_order_prepare_dataCustomer = 'om.ajax.order.prepare.data_customer'; //uri: /om/ajax/order/prepare/data-customer -> App\Http\Controllers\OM\Ajex\PrepareOrderAjaxController.dataByCustomer()

var om_ajax_order_prepare_dataItem = 'om.ajax.order.prepare.data_item'; //uri: /om/ajax/order/prepare/data-item -> App\Http\Controllers\OM\Ajex\PrepareOrderAjaxController.dataByItem()

var om_ajax_order_prepare_setDayamount = 'om.ajax.order.prepare.set_dayamount'; //uri: /om/ajax/order/prepare/set-dayamount -> App\Http\Controllers\OM\Ajex\PrepareOrderAjaxController.setDayAmount()

var om_ajax_order_approve_search_item = 'om.ajax.order.approve.search.item'; //uri: /om/ajax/order/approve/search -> App\Http\Controllers\OM\ApproveOrderController.searchItem()

var om_ajax_order_approve_submit = 'om.ajax.order.approve.submit'; //uri: /om/ajax/order/approve/approve -> App\Http\Controllers\OM\ApproveOrderController.approve()

var om_ajax_order_approve_cancel = 'om.ajax.order.approve.cancel'; //uri: /om/ajax/order/approve/cancel -> App\Http\Controllers\OM\ApproveOrderController.cancel()

var om_order_approveprepare = 'om.order.approveprepare'; //uri: /om/ajax/print-receipt/print_data -> App\Http\Controllers\OM\Ajex\PrintReceipt\PrintReceiptAjaxController.print_receipt()

var om_ajax_proformaInvoicesearch_sale_number = 'om.ajax.proforma-invoicesearch.sale.number'; //uri: /om/ajax/proforma-invoice/search-pi-number/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.searchProformaInvoiceNumber()

var om_ajax_proformaInvoicesearch = 'om.ajax.proforma-invoicesearch'; //uri: /om/ajax/proforma-invoice/search -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.search()

var om_ajax_proformaInvoicecreate_proforma_invoice = 'om.ajax.proforma-invoicecreate.proforma.invoice'; //uri: /om/ajax/proforma-invoice/create-proforma-invoice/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.createProformaInvoice()

var om_proformaInvoicecreate_proforma_invoice = 'om.proforma-invoicecreate.proforma.invoice'; //uri: /om/ajax/proforma-invoice/create-proforma-invoice/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.createProformaInvoice()

var om_ajax_proformaInvoicemanage_proforma_invoice = 'om.ajax.proforma-invoicemanage.proforma.invoice'; //uri: /om/ajax/proforma-invoice/manage-proforma-invoice -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.manageProformaInvoice()

var om_ajax_proformaInvoicecreate_proforma_lot = 'om.ajax.proforma-invoicecreate.proforma.lot'; //uri: /om/ajax/proforma-invoice/create-proforma-lot/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.createProformaLot()

var om_ajax_proformaInvoiceget_proforma_lot = 'om.ajax.proforma-invoiceget.proforma.lot'; //uri: /om/ajax/proforma-invoice/get-proforma-lot/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.getProformaLot()

var om_ajax_proformaInvoicecheckCancel = 'om.ajax.proforma-invoicecheck-cancel'; //uri: /om/ajax/proforma-invoice/check-cancel/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.checkCancel()

var om_ajax_proformaInvoicecancel = 'om.ajax.proforma-invoicecancel'; //uri: /om/ajax/proforma-invoice/cancel -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.cancel()

var om_ajax_proformaInvoiceupdateLot = 'om.ajax.proforma-invoiceupdate-lot'; //uri: /om/ajax/proforma-invoice/update-lot -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.updateLot()

var om_ajax_proformaInvoicedelete_all_lot = 'om.ajax.proforma-invoicedelete.all.lot'; //uri: /om/ajax/proforma-invoice/delete-all-lot -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.deleteAllLot()

var om_ajax_taxInvoiceExportcreate = 'om.ajax.tax-invoice-exportcreate'; //uri: /om/ajax/tax-invoice-export/create -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.create()

var om_ajax_taxInvoiceExportsearch = 'om.ajax.tax-invoice-exportsearch'; //uri: /om/ajax/tax-invoice-export/search -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.search()

var om_ajax_taxInvoiceExportmanage = 'om.ajax.tax-invoice-exportmanage'; //uri: /om/ajax/tax-invoice-export/manage -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.manage()

var om_ajax_taxInvoiceExportcheck_cancel = 'om.ajax.tax-invoice-exportcheck.cancel'; //uri: /om/ajax/tax-invoice-export/check-cancel/{number} -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.checkCancel()

var om_ajax_taxInvoiceExportcancel = 'om.ajax.tax-invoice-exportcancel'; //uri: /om/ajax/tax-invoice-export/cancel -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.cancel()

var om_ajax_taxInvoiceExportclose_work = 'om.ajax.tax-invoice-exportclose.work'; //uri: /om/ajax/tax-invoice-export/close-work/{number} -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.closeWork()

var om_ajax_exchangeExportsearch = 'om.ajax.exchange-exportsearch'; //uri: /om/ajax/exchange-export/search -> App\Http\Controllers\OM\Ajex\ExchangeExportAjaxController.search()

var om_ajax_exchangeExportupdate = 'om.ajax.exchange-exportupdate'; //uri: /om/ajax/exchange-export/update -> App\Http\Controllers\OM\Ajex\ExchangeExportAjaxController.update()

var om_order_approveprepareapproveprepare_index = 'om.order.approveprepareapproveprepare.index'; //uri: /om/order/approveprepare -> App\Http\Controllers\OM\ApprovePrepareController.index()

var om_order_approvepreparaapproveprepara_index = 'om.order.approvepreparaapproveprepara.index'; //uri: /om/order/approveprepare -> App\Http\Controllers\OM\ApprovePrepareController.index()

var om_proformaInvoicesearch_sale_number = 'om.proforma-invoicesearch.sale.number'; //uri: /om/proforma-invoice/search-pi-number/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.searchProformaInovoiceNumber()

var om_customers_exports_index = 'om.customers.exports.index'; //uri: /om/customers/exports -> App\Http\Controllers\OM\Customers\Export\ExportController.index()

var om_customers_exports_show = 'om.customers.exports.show'; //uri: /om/customers/exports/{export} -> App\Http\Controllers\OM\Customers\Export\ExportController.show()

var om_customers_exports_edit = 'om.customers.exports.edit'; //uri: /om/customers/exports/{export}/edit -> App\Http\Controllers\OM\Customers\Export\ExportController.edit()

var om_customers_exports_update = 'om.customers.exports.update'; //uri: /om/customers/exports/{export} -> App\Http\Controllers\OM\Customers\Export\ExportController.update()

var om_customers_approves_ = 'om.customers.approves.'; //uri: /om/customers/approves/reassign/{id} -> App\Http\Controllers\OM\CustomerApprovesController.reassign()

var om_customers_approves_view = 'om.customers.approves.view'; //uri: /om/customers/approves/view/{id} -> App\Http\Controllers\OM\CustomerApprovesController.show()

var om_customers_domesticsBroker = 'om.customers.domestics-broker'; //uri: /om/customers/domestics/broker -> App\Http\Controllers\OM\Customers\Domestics\DomesticController.Broker()

var om_customers_domestics_index = 'om.customers.domestics.index'; //uri: /om/customers/domestics -> App\Http\Controllers\OM\Customers\Domestics\DomesticController.index()

var om_customers_domestics_create = 'om.customers.domestics.create'; //uri: /om/customers/domestics/create -> App\Http\Controllers\OM\Customers\Domestics\DomesticController.create()

var om_customers_domestics_show = 'om.customers.domestics.show'; //uri: /om/customers/domestics/{domestic} -> App\Http\Controllers\OM\Customers\Domestics\DomesticController.show()

var om_customers_detail = 'om.customers.detail'; //uri: /om/customers/domestics/{domestic} -> App\Http\Controllers\OM\Customers\Domestics\DomesticController.show()

var om_releaseCredit_ = 'om.release-credit.'; //uri: /om/release-credit/create -> App\Http\Controllers\OM\ReleaseCreditController.create()

var om_releaseCredit_update = 'om.release-credit.update'; //uri: /om/release-credit/update -> App\Http\Controllers\OM\ReleaseCreditController.update()

var om_promotions_ = 'om.promotions.'; //uri: /om/transfer-bank/domestic -> App\Http\Controllers\OM\TransferFileBankController.domestic()

var om_promotions_storeHeader = 'om.promotions.store-header'; //uri: /om/promotions/store-header -> App\Http\Controllers\OM\PromotionController.storeHeader()

var om_postponeDelivery_ = 'om.postpone-delivery.'; //uri: /om/postpone-delivery/search -> App\Http\Controllers\OM\PostponeDeliveryController.search()

var om_auto_ = 'om.auto.'; //uri: /om/auto/postpone-delivery -> App\Http\Controllers\OM\AutoController.postponeDelivery()

var om_ = 'om.'; //uri: /om/credit-note-other-export -> App\Http\Controllers\OM\CreditNote\CreditNoteExportOtherController.index()

var om_additionIndex = 'om.addition-index'; //uri: /om/addition-quota -> App\Http\Controllers\OM\AdditionQuotaController.index()

var om_additionQuota = 'om.addition-quota'; //uri: /om/addition-quota/approve/step/{id}/{step} -> App\Http\Controllers\OM\AdditionQuotaController.stepone()

var om_additionUpload = 'om.addition-upload'; //uri: /om/addition-quota/upload/file -> App\Http\Controllers\OM\AdditionQuotaController.upload()

var om_additionFilesdelete = 'om.addition-filesdelete'; //uri: /om/addition-quota/delete/file -> App\Http\Controllers\OM\AdditionQuotaController.filesdelete()

var om_additionQuotaUpdate = 'om.addition-quota-update'; //uri: /om/addition-quota/approve/step/update -> App\Http\Controllers\OM\AdditionQuotaController.stepupdate()

var om_additionDownload = 'om.addition-download'; //uri: /om/addition-quota/download/files/{id} -> App\Http\Controllers\OM\AdditionQuotaController.download()

var om_cancelConsignment = 'om.cancel-consignment'; //uri: /om/consignment/cancel -> App\Http\Controllers\OM\ConsignmentController.cancel()

var om_canceledConsignment = 'om.canceled-consignment'; //uri: /om/consignment/canceled -> App\Http\Controllers\OM\ConsignmentController.canceled()

var om_deliveryRateIndex = 'om.delivery-rate-index'; //uri: /om/delivery-rate -> App\Http\Controllers\OM\DeliveryRateController.index()

var om_deliveryRateServiceCall = 'om.delivery-rate-service-call'; //uri: /om/delivery-rate/service/ptt/call/date/{date} -> App\Http\Controllers\OM\DeliveryRateController.autocallservicepttfromdate()

var om_deliveryRateGetnewoil = 'om.delivery-rate-getnewoil'; //uri: /om/delivery-rate/getnewoil -> App\Http\Controllers\OM\DeliveryRateController.getnewoil()

var om_deliveryRateStore = 'om.delivery-rate-store'; //uri: /om/delivery-rate/store -> App\Http\Controllers\OM\DeliveryRateController.store()

var om_deliveryRatePriceNew = 'om.delivery-rate-price-new'; //uri: /om/delivery-rate/count/price/new -> App\Http\Controllers\OM\DeliveryRateController.countpriceoil()

var om_draftPayoutIndex = 'om.draft-payout-index'; //uri: /om/draft-payout -> App\Http\Controllers\OM\DraftPayOutController.index()

var om_draftPayoutListproduct = 'om.draft-payout-listproduct'; //uri: /om/draft-payout/listproduct -> App\Http\Controllers\OM\DraftPayOutController.listProduct()

var om_draftPayoutStoreDraft = 'om.draft-payout-storeDraft'; //uri: /om/draft-payout/storeDraft -> App\Http\Controllers\OM\DraftPayOutController.storeDraft()

var om_draftPayoutPrint = 'om.draft-payout-print'; //uri: /om/draft-payout/print/{id} -> App\Http\Controllers\OM\DraftPayOutController.print()

var om_domesticMatchingIndex = 'om.domestic-matching-index'; //uri: /om/domestic-matching -> App\Http\Controllers\OM\PaymentMethodMatchingController.index()

var om_domesticMatchingGetData = 'om.domestic-matching-getData'; //uri: /om/domestic-matching/getData -> App\Http\Controllers\OM\PaymentMethodMatchingController.getDataFirsttime()

var om_domesticMatchingUploaded = 'om.domestic-matching-uploaded'; //uri: /om/domestic-matching/uploaded -> App\Http\Controllers\OM\PaymentMethodMatchingController.uploaded()

var om_domesticMatchingUploadDeleted = 'om.domestic-matching-upload-deleted'; //uri: /om/domestic-matching/uploaded -> App\Http\Controllers\OM\PaymentMethodMatchingController.uploaded()

var om_domesticMatchingUnmatching = 'om.domestic-matching-unmatching'; //uri: /om/domestic-matching/unmatching -> App\Http\Controllers\OM\PaymentMethodMatchingController.unmatching()

var om_domesticMatchingMatching = 'om.domestic-matching-matching'; //uri: /om/domestic-matching/matching -> App\Http\Controllers\OM\PaymentMethodMatchingController.matching()

var om_domesticMatchingGetinvoice = 'om.domestic-matching-getinvoice'; //uri: /om/domestic-matching/getinvoice -> App\Http\Controllers\OM\PaymentMethodMatchingController.getinvoice()

var om_domesticMatchingGetamount = 'om.domestic-matching-getamount'; //uri: /om/domestic-matching/getamount -> App\Http\Controllers\OM\PaymentMethodMatchingController.getamount()

var om_domesticMatchingUpload = 'om.domestic-matching-upload'; //uri: /om/domestic-matching/upload -> App\Http\Controllers\OM\PaymentMethodMatchingController.fileupload()

var om_domesticMatchingDelete = 'om.domestic-matching-delete'; //uri: /om/domestic-matching/files/delete -> App\Http\Controllers\OM\PaymentMethodMatchingController.filesdelete()

var om_domesticMatchingDownload = 'om.domestic-matching-download'; //uri: /om/domestic-matching/download/files/{id} -> App\Http\Controllers\OM\PaymentMethodMatchingController.download()

var om_paymentMethodIndex = 'om.payment-method-index'; //uri: /om/payment-method/{type} -> App\Http\Controllers\OM\PaymentMethodController.index()

var om_paymentMethodPrint = 'om.payment-method-print'; //uri: /om/payment-method/{type}/{id} -> App\Http\Controllers\OM\PaymentMethodController.print()

var om_paymentMethodGetlistbank = 'om.payment-method-getlistbank'; //uri: /om/payment-method/getlistbank -> App\Http\Controllers\OM\PaymentMethodController.getBankfromLogic()

var om_paymentMethodGetinfofordraft = 'om.payment-method-getinfofordraft'; //uri: /om/payment-method/getinfofordraft -> App\Http\Controllers\OM\PaymentMethodController.getinfofordraft()

var om_paymentMethodGetvaluebank = 'om.payment-method-getvaluebank'; //uri: /om/payment-method/getvaluebank -> App\Http\Controllers\OM\PaymentMethodController.getvaluebank()

var om_paymentMethodGetpaymentnumber = 'om.payment-method-getpaymentnumber'; //uri: /om/payment-method/getpaymentnumber -> App\Http\Controllers\OM\PaymentMethodController.getPaymentNumber()

var om_paymentMethodDraftpayment = 'om.payment-method-draftpayment'; //uri: /om/payment-method/draftpayment -> App\Http\Controllers\OM\PaymentMethodController.draftpayment()

var om_paymentMethodPayment = 'om.payment-method-payment'; //uri: /om/payment-method/payment -> App\Http\Controllers\OM\PaymentMethodController.payment()

var om_paymentMethodPaymentUpload = 'om.payment-method-payment-upload'; //uri: /om/payment-method/payment/upload -> App\Http\Controllers\OM\PaymentMethodController.paymentupload()

var om_paymentMethodPaymentDelete = 'om.payment-method-payment-delete'; //uri: /om/payment-method/payment/files/delete -> App\Http\Controllers\OM\PaymentMethodController.filesdelete()

var om_paymentMethodGetvaluefromnumber = 'om.payment-method-getvaluefromnumber'; //uri: /om/payment-method/getvaluefromnumber -> App\Http\Controllers\OM\PaymentMethodController.getvaluefromnumber()

var om_paymentMethodPaymentverify = 'om.payment-method-paymentverify'; //uri: /om/payment-method/paymentverify -> App\Http\Controllers\OM\PaymentMethodController.paymentverify()

var om_paymentMethodPaymentUploadRemove = 'om.payment-method-payment-upload-remove'; //uri: /om/payment-method/remove-attachment/{id} -> App\Http\Controllers\OM\PaymentMethodController.removeAttachmentFile()

var om_paymentMethodDownload = 'om.payment-method-download'; //uri: /om/payment-method/download/files/{id} -> App\Http\Controllers\OM\PaymentMethodController.download()

var om_exportPayoutIndex = 'om.export-payout-index'; //uri: /om/export-payout -> App\Http\Controllers\OM\Export\PaymentMethodController.index()

var om_exportPayoutGetlistbank = 'om.export-payout-getlistbank'; //uri: /om/export-payout/getlistbank -> App\Http\Controllers\OM\Export\PaymentMethodController.getBankfromLogic()

var om_exportPayoutGetvaluebank = 'om.export-payout-getvaluebank'; //uri: /om/export-payout/getvaluebank -> App\Http\Controllers\OM\Export\PaymentMethodController.getvaluebank()

var om_exportPayoutGetpaymentnumber = 'om.export-payout-getpaymentnumber'; //uri: /om/export-payout/getpaymentnumber -> App\Http\Controllers\OM\Export\PaymentMethodController.getPaymentNumber()

var om_exportPaymentMethodDraftpayment = 'om.export-payment-method-draftpayment'; //uri: /om/export-payout/draftpayment -> App\Http\Controllers\OM\Export\PaymentMethodController.draftpayment()

var om_exportMethodPaymentDelete = 'om.export-method-payment-delete'; //uri: /om/export-payout/payment/files/delete -> App\Http\Controllers\OM\Export\PaymentMethodController.filesdelete()

var om_exportMethodPayment = 'om.export-method-payment'; //uri: /om/export-payout/payment -> App\Http\Controllers\OM\Export\PaymentMethodController.payment()

var om_exportMethodPrint = 'om.export-method-print'; //uri: /om/export-payout/print/{id} -> App\Http\Controllers\OM\Export\PaymentMethodController.print()

var om_exportMethodGetinfofordraft = 'om.export-method-getinfofordraft'; //uri: /om/export-payout/getinfofordraft -> App\Http\Controllers\OM\Export\PaymentMethodController.getinfofordraft()

var om_exportMethodGetvaluefromnumber = 'om.export-method-getvaluefromnumber'; //uri: /om/export-payout/getvaluefromnumber -> App\Http\Controllers\OM\Export\PaymentMethodController.getvaluefromnumber()

var om_exportMethodPaymentUpload = 'om.export-method-payment-upload'; //uri: /om/export-payout/payment/upload -> App\Http\Controllers\OM\Export\PaymentMethodController.paymentupload()

var om_exportMatchingIndex = 'om.export-matching-index'; //uri: /om/export-matching -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.index()

var om_exportMatchingUnmatching = 'om.export-matching-unmatching'; //uri: /om/export-matching/unmatching -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.unmatching()

var om_exportMatchingUploaded = 'om.export-matching-uploaded'; //uri: /om/export-matching/uploaded -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.uploaded()

var om_exportMatchingUploadDeleted = 'om.export-matching-upload-deleted'; //uri: /om/export-matching/upload/deleted -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.filesdelete()

var om_exportMatchingGetData = 'om.export-matching-getData'; //uri: /om/export-matching/getData -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.getDataFirsttime()

var om_exportMatchingMatching = 'om.export-matching-matching'; //uri: /om/export-matching/matching -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.matching()

var om_exportMatchingGetinvoice = 'om.export-matching-getinvoice'; //uri: /om/export-matching/getinvoice -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.getinvoice()

var om_exportMatchingGetamount = 'om.export-matching-getamount'; //uri: /om/export-matching/getamount -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.getamount()

var om_exportMatchingGetDataexchangerate = 'om.export-matching-getDataexchangerate'; //uri: /om/export-matching/getDataexchangerate -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.getDataexchangerate()

var om_taxAdjustIndex = 'om.tax-adjust-index'; //uri: /om/tax-adjust -> App\Http\Controllers\OM\TaxAdjustmentController.index()

var om_taxAdjustRecivedata = 'om.tax-adjust-recivedata'; //uri: /om/tax-adjust/recivedata -> App\Http\Controllers\OM\TaxAdjustmentController.recivedata()

var om_taxAdjustSenddata = 'om.tax-adjust-senddata'; //uri: /om/tax-adjust/senddata -> App\Http\Controllers\OM\TaxAdjustmentController.senddata()

var om_indexTransferCommission = 'om.index-transfer-commission'; //uri: /om/transfer-commission -> App\Http\Controllers\OM\TransferCommissionController.index()

var om_sendapTransferCommission = 'om.sendap-transfer-commission'; //uri: /om/transfer-commission/sndAP -> App\Http\Controllers\OM\TransferCommissionController.sendAP()

var om_indexTransferProvince = 'om.index-transfer-province'; //uri: /om/transfer-province -> App\Http\Controllers\OM\TransferProvinceController.index()

var om_calculateTransferProvince = 'om.calculate-transfer-province'; //uri: /om/transfer-province/calculate -> App\Http\Controllers\OM\TransferProvinceController.calculate()

var om_closeFlagIndex = 'om.close-flag-index'; //uri: /om/close-flag/{type} -> App\Http\Controllers\OM\ClosedFlagSaleController.index()

var om_closeFlagRelease = 'om.close-flag-release'; //uri: /om/close-flag/release -> App\Http\Controllers\OM\ClosedFlagSaleController.release()

var om_closeFlagProcess = 'om.close-flag-process'; //uri: /om/close-flag/process -> App\Http\Controllers\OM\ClosedFlagSaleController.process()

var om_closeFlagProcessExport = 'om.close-flag-process-export'; //uri: /om/close-flag/export/process -> App\Http\Controllers\OM\ClosedFlagSaleController.processExport()

var om_transferBiWeekly_ = 'om.transfer-bi-weekly.'; //uri: /om/transfer-bi-weekly/domestic/approved -> App\Http\Controllers\OM\Saleorder\Domestic\TransferBiWeeklyController.approved()

var om_overdueDebt_index = 'om.overdue-debt.index'; //uri: /om/overdue-debt -> App\Http\Controllers\OM\OverdueDebtController.index()

var om_overdueDebt_show = 'om.overdue-debt.show'; //uri: /om/overdue-debt/{overdue_debt} -> App\Http\Controllers\OM\OverdueDebtController.show()

var om_saleConfirmation_index = 'om.sale-confirmation.index'; //uri: /om/sale-confirmation -> App\Http\Controllers\OM\SaleConfirmationController.index()

var om_saleConfirmation_show = 'om.sale-confirmation.show'; //uri: /om/sale-confirmation/{sale_confirmation} -> App\Http\Controllers\OM\SaleConfirmationController.show()

var om_sequenceFortnightly_index = 'om.sequence-fortnightly.index'; //uri: /om/sequence-fortnightly -> App\Http\Controllers\OM\SequenceFortnightlyController.index()

var om_sequenceFortnightly_show = 'om.sequence-fortnightly.show'; //uri: /om/sequence-fortnightly/{sequence_fortnightly} -> App\Http\Controllers\OM\SequenceFortnightlyController.show()

var om_biweeklyPeriods_index = 'om.biweekly-periods.index'; //uri: /om/biweekly-periods -> App\Http\Controllers\OM\BiweeklyPeriodsController.index()

var om_transferMonthly_ = 'om.transfer-monthly.'; //uri: /om/transfer-monthly/domestic -> App\Http\Controllers\OM\Saleorder\Domestic\TransferMonthlyController.index()

var om_order_prepare_order = 'om.order.prepare.order'; //uri: /om/order/prepare -> App\Http\Controllers\OM\PrepareOrderController.index()

var om_order_prepare_search = 'om.order.prepare.search'; //uri: /om/order/prepare/search -> App\Http\Controllers\OM\PrepareOrderController.search()

var om_order_prepare_create_show = 'om.order.prepare.create.show'; //uri: /om/order/prepare/create -> App\Http\Controllers\OM\PrepareOrderController.showcreate()

var om_order_prepare_prepare_edit = 'om.order.prepare.prepare.edit'; //uri: /om/order/prepare/edit/{id} -> App\Http\Controllers\OM\PrepareOrderController.showedit()

var om_order_prepare_ = 'om.order.prepare.'; //uri: /om/order/prepare/edit/{id}/submit -> App\Http\Controllers\OM\PrepareOrderController.editsubmit()

var om_order_prepare_create_submit = 'om.order.prepare.create.submit'; //uri: /om/order/prepare/create/submit -> App\Http\Controllers\OM\PrepareOrderController.create()

var om_order_prepare_update_submit = 'om.order.prepare.update.submit'; //uri: /om/order/prepare/update/submit -> App\Http\Controllers\OM\PrepareOrderController.update()

var om_order_prepare_approve = 'om.order.prepare.approve'; //uri: /om/order/prepare/approve/{id} -> App\Http\Controllers\OM\PrepareOrderController.approve()

var om_order_prepare_cancel = 'om.order.prepare.cancel'; //uri: /om/order/prepare/cancel/{id} -> App\Http\Controllers\OM\PrepareOrderController.cancel()

var om_order_prepare_copy = 'om.order.prepare.copy'; //uri: /om/order/prepare/copy/{id} -> App\Http\Controllers\OM\PrepareOrderController.copy()

var om_order_approveapprove_index = 'om.order.approveapprove.index'; //uri: /om/order/approve -> App\Http\Controllers\OM\ApproveOrderController.index()

var om_getInvoiceHeader = 'om.get-invoice-header'; //uri: /om/invoice -> App\Http\Controllers\OM\InvoiceController.getInvoiceHeader()

var om_getInvoiceHeaderSave = 'om.get-invoice-header-save'; //uri: /om/invoice/save -> App\Http\Controllers\OM\InvoiceController.printInvoice()

var om_proformaInvoice_index = 'om.proforma-invoice.index'; //uri: /om/proforma-invoice -> App\Http\Controllers\OM\ProformaInvoiceController.index()

var om_proformaInvoice_show = 'om.proforma-invoice.show'; //uri: /om/proforma-invoice/{proforma_invoice} -> App\Http\Controllers\OM\ProformaInvoiceController.show()

var om_taxInvoiceExport_index = 'om.tax-invoice-export.index'; //uri: /om/tax-invoice-export -> App\Http\Controllers\OM\TaxInvoiceExportController.index()

var om_taxInvoiceExport_show = 'om.tax-invoice-export.show'; //uri: /om/tax-invoice-export/{tax_invoice_export} -> App\Http\Controllers\OM\TaxInvoiceExportController.show()

var om_transpotReportIndex = 'om.transpot-report-index'; //uri: /om/transpot-report -> App\Http\Controllers\OM\TranspotReportController.index()

var om_transpotReportDraftData = 'om.transpot-report-draftData'; //uri: /om/transpot-report/draftData -> App\Http\Controllers\OM\Ajex\TranspotReportController.draftData()

var om_transpotReportCreateDataone = 'om.transpot-report-createDataone'; //uri: /om/transpot-report/createDataone -> App\Http\Controllers\OM\Ajex\TranspotReportController.createDataone()

var om_transpotReportCreateDatatwo = 'om.transpot-report-createDatatwo'; //uri: /om/transpot-report/createDatatwo -> App\Http\Controllers\OM\Ajex\TranspotReportController.createDatatwo()

var om_order_direct_debit = 'om.order.direct.debit'; //uri: /om/order-direct-debit/domestic/save -> App\Http\Controllers\OM\OrderDirectDebitController.domesticSave()

var om_consignment = 'om.consignment'; //uri: /om/consignment/fillData -> App\Http\Controllers\OM\ConsignmentController.fillData()

var om_consignmentgetData = 'om.consignmentgetData'; //uri: /om/consignment/create -> App\Http\Controllers\OM\ConsignmentController.get()

var om_invoice_cancelInvoice = 'om.invoice.cancel-invoice'; //uri: /om/invoice/cancel -> App\Http\Controllers\OM\InvoiceController.cancel()

var om_invoice_canceledInvoice = 'om.invoice.canceled-invoice'; //uri: /om/invoice/canceled -> App\Http\Controllers\OM\InvoiceController.actionCancel()

var om_invoice_getlistCancelInvoice = 'om.invoice.getlist-cancel-invoice'; //uri: /om/invoice/list-cancel-invoice -> App\Http\Controllers\OM\InvoiceController.getAjaxListCancelInvoice()

var om_consignmentClub_index = 'om.consignment-club.index'; //uri: /om/consignment-club -> App\Http\Controllers\OM\ConsignmentClubController.index()

var om_consignmentClub_show = 'om.consignment-club.show'; //uri: /om/consignment-club/{consignment_club} -> App\Http\Controllers\OM\ConsignmentClubController.show()

var om_approvePrepare_index = 'om.approve-prepare.index'; //uri: /om/approve-prepare -> App\Http\Controllers\OM\ApprovePrepareOrderController.index()

var om_approvePrepare_show = 'om.approve-prepare.show'; //uri: /om/approve-prepare/{approve_prepare} -> App\Http\Controllers\OM\ApprovePrepareOrderController.show()

var om_rmaExport_index = 'om.rma-export.index'; //uri: /om/rma-export -> App\Http\Controllers\OM\RmaExportController.index()

var om_rmaExport_show = 'om.rma-export.show'; //uri: /om/rma-export/{rma_export} -> App\Http\Controllers\OM\RmaExportController.show()

var om_exchangeExport_index = 'om.exchange-export.index'; //uri: /om/exchange-export -> App\Http\Controllers\OM\ExchangeExportController.index()

var om_exchangeExport_show = 'om.exchange-export.show'; //uri: /om/exchange-export/{exchange_export} -> App\Http\Controllers\OM\ExchangeExportController.show()

var om_approvePrepare_print = 'om.approve-prepare.print'; //uri: /om/approve-prepare/print/{id} -> App\Http\Controllers\OM\ApprovePrepareOrderController.print()

var om_paoTaxMt_index = 'om.pao-tax-mt.index'; //uri: /om/pao-tax-mt -> App\Http\Controllers\OM\PaoTaxMtController.index()

var om_paoTaxMt_search = 'om.pao-tax-mt.search'; //uri: /om/pao-tax-mt/search -> App\Http\Controllers\OM\PaoTaxMtController.search()

var om_paoTaxMt_validate = 'om.pao-tax-mt.validate'; //uri: /om/pao-tax-mt/validate -> App\Http\Controllers\OM\PaoTaxMtController.validateData()

var om_paoTaxMt_store = 'om.pao-tax-mt.store'; //uri: /om/pao-tax-mt/store -> App\Http\Controllers\OM\PaoTaxMtController.store()

var om_paoTaxMt_update = 'om.pao-tax-mt.update'; //uri: /om/pao-tax-mt/update -> App\Http\Controllers\OM\PaoTaxMtController.update()

var om_paoTaxMt_exReport = 'om.pao-tax-mt.ex-report'; //uri: /om/pao-tax-mt/ex-report -> App\Http\Controllers\OM\PaoTaxMtController.exReport()

var ir_ajax_subGroups_show = 'ir.ajax.sub-groups.show'; //uri: /ir/ajax/sub-groups/show/{policy_set_header_id} -> App\Http\Controllers\IR\Settings\Ajax\SubGroupsController.show()

var ir_ajax_productGroups_updateActiveFlag = 'ir.ajax.product-groups.updateActiveFlag'; //uri: /ir/ajax/product-groups/updateActiveFlag -> App\Http\Controllers\IR\Settings\Ajax\GroupProductsController.updateActiveFlag()

var ir_ajax_subGroups_checkInactive = 'ir.ajax.sub-groups.checkInactive'; //uri: /ir/ajax/sub-groups/check-inactive -> App\Http\Controllers\IR\Settings\Ajax\SubGroupsController.checkInactive()

var ir_ajax_productGroup = 'ir.ajax.product-group'; //uri: /ir/ajax/product-group -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.index()

var ir_settings_productGroup = 'ir.settings.product-group'; //uri: /ir/ajax/product-group -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.index()

var ir_ajax_getLocator = 'ir.ajax.get-locator'; //uri: /ir/ajax/get-locator -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getLocator()

var ir_settings_getLocator = 'ir.settings.get-locator'; //uri: /ir/ajax/get-locator -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getLocator()

var ir_ajax_updateActiveFlag = 'ir.ajax.updateActiveFlag'; //uri: /ir/ajax/product-header/updateActiveFlag -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.updateActiveFlag()

var ir_ajax_destroy = 'ir.ajax.destroy'; //uri: /ir/ajax/destroy -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.destroy()

var ir_ajax_getValueSet = 'ir.ajax.getValueSet'; //uri: /ir/ajax/get-value-set -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getValueSet()

var ir_ajax_ = 'ir.ajax.'; //uri: /ir/ajax/product-header/getDataActiveFlag -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getDataActiveFlag()

var ir_ajax_subGroups_destroy = 'ir.ajax.sub-groups.destroy'; //uri: /ir/ajax/sub-groups/destroy -> App\Http\Controllers\IR\Settings\Ajax\SubGroupsController.destroy()

var ir_settings_productGroups_index = 'ir.settings.product-groups.index'; //uri: /ir/settings/product-groups -> App\Http\Controllers\IR\Settings\GroupProductsController.index()

var ir_settings_productGroups_create = 'ir.settings.product-groups.create'; //uri: /ir/settings/product-groups/create -> App\Http\Controllers\IR\Settings\GroupProductsController.create()

var ir_settings_productGroups_store = 'ir.settings.product-groups.store'; //uri: /ir/settings/product-groups/store -> App\Http\Controllers\IR\Settings\GroupProductsController.store()

var ir_settings_productGroups_update = 'ir.settings.product-groups.update'; //uri: /ir/settings/product-groups/update -> App\Http\Controllers\IR\Settings\GroupProductsController.update()

var ir_settings_productGroups_edit = 'ir.settings.product-groups.edit'; //uri: /ir/settings/product-groups/{id}/edit -> App\Http\Controllers\IR\Settings\GroupProductsController.edit()

var ir_settings_productHeader_index = 'ir.settings.product-header.index'; //uri: /ir/settings/product-header -> App\Http\Controllers\IR\Settings\ProductInvHeaderController.index()

var ir_settings_productHeader_create = 'ir.settings.product-header.create'; //uri: /ir/settings/product-header/create -> App\Http\Controllers\IR\Settings\ProductInvHeaderController.create()

var ir_settings_productHeader_store = 'ir.settings.product-header.store'; //uri: /ir/settings/product-header/store -> App\Http\Controllers\IR\Settings\ProductInvHeaderController.store()

var ir_settings_productHeader_search = 'ir.settings.product-header.search'; //uri: /ir/settings/product-header/search -> App\Http\Controllers\IR\Settings\ProductInvHeaderController.search()

var ir_settings_productHeader_edit = 'ir.settings.product-header.edit'; //uri: /ir/settings/product-header/{id}/edit -> App\Http\Controllers\IR\Settings\ProductInvHeaderController.edit()

var ir_settings_productHeader_update = 'ir.settings.product-header.update'; //uri: /ir/settings/product-header/update -> App\Http\Controllers\IR\Settings\ProductInvHeaderController.update()

var ir_settings_subGroups_index = 'ir.settings.sub-groups.index'; //uri: /ir/settings/sub-groups -> App\Http\Controllers\IR\Settings\SubGroupsController.index()

var ir_settings_subGroups_create = 'ir.settings.sub-groups.create'; //uri: /ir/settings/sub-groups/create -> App\Http\Controllers\IR\Settings\SubGroupsController.create()

var ir_settings_subGroups_update = 'ir.settings.sub-groups.update'; //uri: /ir/settings/sub-groups/update -> App\Http\Controllers\IR\Settings\SubGroupsController.update()

var ir_settings_subGroups_store = 'ir.settings.sub-groups.store'; //uri: /ir/settings/sub-groups/store -> App\Http\Controllers\IR\Settings\SubGroupsController.store()

var ir_settings_subGroups_search = 'ir.settings.sub-groups.search'; //uri: /ir/settings/sub-groups/search -> App\Http\Controllers\IR\Settings\SubGroupsController.search()

var ir_settings_subGroups_edit = 'ir.settings.sub-groups.edit'; //uri: /ir/settings/sub-groups/{id}/edit -> App\Http\Controllers\IR\Settings\SubGroupsController.edit()

var ir_ajax_Lov_lovCompanies = 'ir.ajax.Lov.lov-companies'; //uri: /ir/ajax/lov/companies -> App\Http\Controllers\IR\Ajax\Lov\LovController.companiesLov()

var ir_ajax_Lov_lovVendor = 'ir.ajax.Lov.lov-vendor'; //uri: /ir/ajax/lov/vendor -> App\Http\Controllers\IR\Ajax\Lov\LovController.supplierNumberLov()

var ir_ajax_Lov_lovBranchCode = 'ir.ajax.Lov.lov-branch-code'; //uri: /ir/ajax/lov/branch-code -> App\Http\Controllers\IR\Ajax\Lov\LovController.branchNumberLov()

var ir_ajax_Lov_lovCustomerNumber = 'ir.ajax.Lov.lov-customer-number'; //uri: /ir/ajax/lov/customer-number -> App\Http\Controllers\IR\Ajax\Lov\LovController.customerNumberLov()

var ir_ajax_Lov_lovPolicySetHeader = 'ir.ajax.Lov.lov-policy-set-header'; //uri: /ir/ajax/lov/policy-set-header -> App\Http\Controllers\IR\Ajax\Lov\LovController.policySetHeadersLov()

var ir_ajax_Lov_lovPolicyType = 'ir.ajax.Lov.lov-policy-type'; //uri: /ir/ajax/lov/policy-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.policyTypeLov()

var ir_ajax_Lov_lovAccountCodeCombine = 'ir.ajax.Lov.lov-account-code-combine'; //uri: /ir/ajax/lov/account-code-combine -> App\Http\Controllers\IR\Ajax\Lov\LovController.accountCodeCombineLov()

var ir_ajax_Lov_lovGasStationsGroups = 'ir.ajax.Lov.lov-gas-stations-groups'; //uri: /ir/ajax/lov/gas-station-group -> App\Http\Controllers\IR\Ajax\Lov\LovController.gasStationGroupLov()

var ir_ajax_Lov_lovGroup = 'ir.ajax.Lov.lov-group'; //uri: /ir/ajax/lov/group-code -> App\Http\Controllers\IR\Ajax\Lov\LovController.groupLov()

var ir_ajax_Lov_lovPolicyCategory = 'ir.ajax.Lov.lov-policy-category'; //uri: /ir/ajax/lov/policy-category -> App\Http\Controllers\IR\Ajax\Lov\LovController.policyCategoryLov()

var ir_ajax_Lov_lovPolicyGroupHeaders = 'ir.ajax.Lov.lov-policy-group-headers'; //uri: /ir/ajax/lov/policy-group-header -> App\Http\Controllers\IR\Ajax\Lov\LovController.policyGroupHeaderLov()

var ir_ajax_Lov_lovPremiumRate = 'ir.ajax.Lov.lov-premium-rate'; //uri: /ir/ajax/lov/premium-rate -> App\Http\Controllers\IR\Ajax\Lov\LovController.premiumRateLov()

var ir_ajax_Lov_companiesCode = 'ir.ajax.Lov.companies-code'; //uri: /ir/ajax/lov/company-code -> App\Http\Controllers\IR\Ajax\Lov\LovController.companiesCodeLov()

var ir_ajax_Lov_lovEvmCode = 'ir.ajax.Lov.lov-evm-code'; //uri: /ir/ajax/lov/evm-code -> App\Http\Controllers\IR\Ajax\Lov\LovController.evmCodeLov()

var ir_ajax_Lov_lovDepartmentCode = 'ir.ajax.Lov.lov-department-code'; //uri: /ir/ajax/lov/department-code -> App\Http\Controllers\IR\Ajax\Lov\LovController.departmentCodeLov()

var ir_ajax_Lov_lovCostCenterCode = 'ir.ajax.Lov.lov-cost-center-code'; //uri: /ir/ajax/lov/cost-center-code -> App\Http\Controllers\IR\Ajax\Lov\LovController.costCenterCodeLov()

var ir_ajax_Lov_lovBudgetYear = 'ir.ajax.Lov.lov-budget-year'; //uri: /ir/ajax/lov/budget-year -> App\Http\Controllers\IR\Ajax\Lov\LovController.budgetYearLov()

var ir_ajax_Lov_lovBudgetType = 'ir.ajax.Lov.lov-budget-type'; //uri: /ir/ajax/lov/budget-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.budgetTypeLov()

var ir_ajax_Lov_lovBudgetDetail = 'ir.ajax.Lov.lov-budget-detail'; //uri: /ir/ajax/lov/budget-detail -> App\Http\Controllers\IR\Ajax\Lov\LovController.budgetDetailLov()

var ir_ajax_Lov_lovBudgetReason = 'ir.ajax.Lov.lov-budget-reason'; //uri: /ir/ajax/lov/budget-reason -> App\Http\Controllers\IR\Ajax\Lov\LovController.budgetReasonLov()

var ir_ajax_Lov_lovMainAccount = 'ir.ajax.Lov.lov-main-account'; //uri: /ir/ajax/lov/main-account -> App\Http\Controllers\IR\Ajax\Lov\LovController.mainAccountLov()

var ir_ajax_Lov_lovSubAccount = 'ir.ajax.Lov.lov-sub-account'; //uri: /ir/ajax/lov/sub-account -> App\Http\Controllers\IR\Ajax\Lov\LovController.subAccountLov()

var ir_ajax_Lov_lovReserverd1 = 'ir.ajax.Lov.lov-reserverd1'; //uri: /ir/ajax/lov/reserved1 -> App\Http\Controllers\IR\Ajax\Lov\LovController.reserved1()

var ir_ajax_Lov_lovReserverd2 = 'ir.ajax.Lov.lov-reserverd2'; //uri: /ir/ajax/lov/reserved2 -> App\Http\Controllers\IR\Ajax\Lov\LovController.reserved2()

var ir_ajax_Lov_lovLicensePlate = 'ir.ajax.Lov.lov-license-plate'; //uri: /ir/ajax/lov/license-plate -> App\Http\Controllers\IR\Ajax\Lov\LovController.licensePlateLov()

var ir_ajax_Lov_lovVehiclesType = 'ir.ajax.Lov.lov-vehicles-type'; //uri: /ir/ajax/lov/vehicles-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.vehiclesTypeLov()

var ir_ajax_Lov_lovRenewType = 'ir.ajax.Lov.lov-renew-type'; //uri: /ir/ajax/lov/renew-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.renewTypeLov()

var ir_ajax_Lov_lovGasStationsType = 'ir.ajax.Lov.lov-gas-stations-type'; //uri: /ir/ajax/lov/gas-stations-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.gasStationTypeLov()

var ir_ajax_Lov_lovStatus = 'ir.ajax.Lov.lov-status'; //uri: /ir/ajax/lov/status -> App\Http\Controllers\IR\Ajax\Lov\LovController.statusLov()

var ir_ajax_Lov_lovPeriods = 'ir.ajax.Lov.lov-periods'; //uri: /ir/ajax/lov/periods -> App\Http\Controllers\IR\Ajax\Lov\LovController.periodsLov()

var ir_ajax_Lov_lovGroupLocation = 'ir.ajax.Lov.lov-group-location'; //uri: /ir/ajax/lov/group-location -> App\Http\Controllers\IR\Ajax\Lov\LovController.groupLocationLov()

var ir_ajax_Lov_lovSubGroup = 'ir.ajax.Lov.lov-sub-group'; //uri: /ir/ajax/lov/sub-group -> App\Http\Controllers\IR\Ajax\Lov\LovController.subGroupLov()

var ir_ajax_Lov_lovOrg = 'ir.ajax.Lov.lov-org'; //uri: /ir/ajax/lov/org -> App\Http\Controllers\IR\Ajax\Lov\LovController.orgLov()

var ir_ajax_Lov_lovSubInventory = 'ir.ajax.Lov.lov-sub-inventory'; //uri: /ir/ajax/lov/sub-inventory -> App\Http\Controllers\IR\Ajax\Lov\LovController.subInventoryLov()

var ir_ajax_Lov_lovUom = 'ir.ajax.Lov.lov-uom'; //uri: /ir/ajax/lov/uom -> App\Http\Controllers\IR\Ajax\Lov\LovController.uomLov()

var ir_ajax_Lov_lovInvoice = 'ir.ajax.Lov.lov-invoice'; //uri: /ir/ajax/lov/invoice-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.invoiceTypeLov()

var ir_ajax_Lov_lovGovernerPolicyType = 'ir.ajax.Lov.lov-governer-policy-type'; //uri: /ir/ajax/lov/governer-policy-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.governerPolicyTypeLov()

var ir_ajax_Lov_lovInvoiceNumber = 'ir.ajax.Lov.lov-invoice-number'; //uri: /ir/ajax/lov/invoice-number -> App\Http\Controllers\IR\Ajax\Lov\LovController.invoiceNumberLov()

var ir_ajax_Lov_lovInterfaceType = 'ir.ajax.Lov.lov-interface-type'; //uri: /ir/ajax/lov/interface-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.apInterfaceTypeLov()

var ir_ajax_Lov_lovInterfaceGlType = 'ir.ajax.Lov.lov-interface-gl-type'; //uri: /ir/ajax/lov/interface-gl-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.glInterfaceTypeLov()

var ir_ajax_Lov_lovDepartmentLocation = 'ir.ajax.Lov.lov-department-location'; //uri: /ir/ajax/lov/department-location -> App\Http\Controllers\IR\Ajax\Lov\LovController.departmentLocationLov()

var ir_ajax_Lov_lovLocation = 'ir.ajax.Lov.lov-location'; //uri: /ir/ajax/lov/location -> App\Http\Controllers\IR\Ajax\Lov\LovController.locationLov()

var ir_ajax_Lov_lovCatSegment1 = 'ir.ajax.Lov.lov-cat-segment1'; //uri: /ir/ajax/lov/cat-segment1 -> App\Http\Controllers\IR\Ajax\Lov\LovController.catSegment1Lov()

var ir_ajax_Lov_lovCatSegment3 = 'ir.ajax.Lov.lov-cat-segment3'; //uri: /ir/ajax/lov/cat-segment3 -> App\Http\Controllers\IR\Ajax\Lov\LovController.catSegment3Lov()

var ir_ajax_Lov_lovReceivableCharge = 'ir.ajax.Lov.lov-receivable-charge'; //uri: /ir/ajax/lov/receivable-charge -> App\Http\Controllers\IR\Ajax\Lov\LovController.receivableChargeLov()

var ir_ajax_Lov_lovEffectiveDate = 'ir.ajax.Lov.lov-effective-date'; //uri: /ir/ajax/lov/effective-date -> App\Http\Controllers\IR\Ajax\Lov\LovController.effectiveDateLov()

var ir_ajax_Lov_lovExpAssetStockType = 'ir.ajax.Lov.lov-exp-asset-stock-type'; //uri: /ir/ajax/lov/exp-asset-stock-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.expAssetStockTypeLov()

var ir_ajax_Lov_lovExpCarGasType = 'ir.ajax.Lov.lov-exp-car-gas-type'; //uri: /ir/ajax/lov/exp-car-gas-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.expCarGasTypeLov()

var ir_ajax_Lov_lovArInvoiceNum = 'ir.ajax.Lov.lov-ar-invoice-num'; //uri: /ir/ajax/lov/ar-invoice-num -> App\Http\Controllers\IR\Ajax\Lov\LovController.arInvoiceNumLov()

var ir_ajax_Lov_lovPolicyVehicle = 'ir.ajax.Lov.lov-policy-vehicle'; //uri: /ir/ajax/lov/policy-vehicles -> App\Http\Controllers\IR\Ajax\Lov\LovController.policySetHeadersVehicleLov()

var ir_ajax_Lov_lovGroupCodePolicy = 'ir.ajax.Lov.lov-group-code-policy'; //uri: /ir/ajax/lov/group-code-policy -> App\Http\Controllers\IR\Ajax\Lov\LovController.groupCodePolicyLov()

var ir_ajax_Lov_lovRevision = 'ir.ajax.Lov.lov-revision'; //uri: /ir/ajax/lov/revision -> App\Http\Controllers\IR\Ajax\Lov\LovController.revisionLov()

var ir_ajax_Lov_lovBudgetPeriodYear = 'ir.ajax.Lov.lov-budget-period_year'; //uri: /ir/ajax/lov/budget-period-year -> App\Http\Controllers\IR\Ajax\Lov\LovController.budgetPeriodYearLov()

var ir_ajax_Lov_lovAssetStatus = 'ir.ajax.Lov.lov-asset-status'; //uri: /ir/ajax/lov/asset-status -> App\Http\Controllers\IR\Ajax\Lov\LovController.assetStatusLov()

var ir_ajax_Lov_lovVehicleLicensePlate = 'ir.ajax.Lov.lov-vehicle-license-plate'; //uri: /ir/ajax/lov/vehicle-license-plate -> App\Http\Controllers\IR\Ajax\Lov\LovController.getVehicleLicensePlateLov()

var ir_ajax_Lov_lovGasStationTypeMaster = 'ir.ajax.Lov.lov-gas-station-type-master'; //uri: /ir/ajax/lov/gas-station-type-master -> App\Http\Controllers\IR\Ajax\Lov\LovController.gasStationTypeMasterLov()

var ir_ajax_Lov_lovClaimDocumentNumber = 'ir.ajax.Lov.lov-claim-document-number'; //uri: /ir/ajax/lov/claim-document-number -> App\Http\Controllers\IR\Ajax\Lov\LovController.claimDocumentNumberLov()

var ir_ajax_Lov_lovGenCompanyNumber = 'ir.ajax.Lov.lov-gen-company-number'; //uri: /ir/ajax/lov/gen-company-number -> App\Http\Controllers\IR\Ajax\Lov\LovController.genCompanyNumber()

var ir_ajax_Lov_lovClaimPolicyNumber = 'ir.ajax.Lov.lov-claim-policy-number'; //uri: /ir/ajax/lov/claim-policy-number -> App\Http\Controllers\IR\Ajax\Lov\LovController.policySetHeadersClaimLov()

var ir_ajax_Lov_lovCompanyPercent = 'ir.ajax.Lov.lov-company-percent'; //uri: /ir/ajax/lov/company-percent -> App\Http\Controllers\IR\Ajax\Lov\LovController.companyPercent()

var ir_ajax_Lov_lovPolicySetHeaderGroup = 'ir.ajax.Lov.lov-policy-set-header-group'; //uri: /ir/ajax/lov/policy-set-header-group -> App\Http\Controllers\IR\Ajax\Lov\LovController.policyFromPolicyGroup()

var ir_ajax_Lov_lovVehicleBrand = 'ir.ajax.Lov.lov-vehicle-brand'; //uri: /ir/ajax/lov/vehicle-brand -> App\Http\Controllers\IR\Ajax\Lov\LovController.vehicleBrand()

var ir_ajax_Lov_lovCategory4 = 'ir.ajax.Lov.lov-category4'; //uri: /ir/ajax/lov/category-seg4 -> App\Http\Controllers\IR\Ajax\Lov\LovController.categorySeg4()

var ir_ajax_Lov_lovCategory5 = 'ir.ajax.Lov.lov-category5'; //uri: /ir/ajax/lov/category-seg5 -> App\Http\Controllers\IR\Ajax\Lov\LovController.categorySeg5()

var ir_ajax_Lov_lovAssetGroup = 'ir.ajax.Lov.lov-asset-group'; //uri: /ir/ajax/lov/asset-group -> App\Http\Controllers\IR\Ajax\Lov\LovController.assetGroup()

var ir_ajax_Lov_lovApInterfaceType = 'ir.ajax.Lov.lov-ap-interface-type'; //uri: /ir/ajax/lov/ap-interface-type -> App\Http\Controllers\IR\Ajax\Lov\LovController.arInterfaceType()

var ir_ajax_Lov_lovVehicleRate = 'ir.ajax.Lov.lov-vehicle-rate'; //uri: /ir/ajax/lov/vehicle-rate -> App\Http\Controllers\IR\Ajax\Lov\LovController.vehicleRate()

var ir_ajax_companyIndex = 'ir.ajax.company-index'; //uri: /ir/ajax/company -> App\Http\Controllers\IR\Ajax\Settings\CompanyController.index()

var ir_ajax_companyShow = 'ir.ajax.company-show'; //uri: /ir/ajax/company/{company_id} -> App\Http\Controllers\IR\Ajax\Settings\CompanyController.show()

var ir_ajax_companyStore = 'ir.ajax.company-store'; //uri: /ir/ajax/company -> App\Http\Controllers\IR\Ajax\Settings\CompanyController.store()

var ir_ajax_companyUpdate = 'ir.ajax.company-update'; //uri: /ir/ajax/company -> App\Http\Controllers\IR\Ajax\Settings\CompanyController.update()

var ir_ajax_companyActiveFlag = 'ir.ajax.company-active-flag'; //uri: /ir/ajax/company/active-flag -> App\Http\Controllers\IR\Ajax\Settings\CompanyController.updateActiveFlag()

var ir_ajax_companyCheckUsedData = 'ir.ajax.company-check-used-data'; //uri: /ir/ajax/company/check-used-data/{company_id} -> App\Http\Controllers\IR\Ajax\Settings\CompanyController.checkUsedData()

var ir_ajax_policyIndex = 'ir.ajax.policy-index'; //uri: /ir/ajax/policy -> App\Http\Controllers\IR\Ajax\Settings\PolicyController.index()

var ir_ajax_policyShow = 'ir.ajax.policy-show'; //uri: /ir/ajax/policy/{policy_set_header_id} -> App\Http\Controllers\IR\Ajax\Settings\PolicyController.show()

var ir_ajax_policyStore = 'ir.ajax.policy-store'; //uri: /ir/ajax/policy/save -> App\Http\Controllers\IR\Ajax\Settings\PolicyController.store()

var ir_ajax_policyUpdate = 'ir.ajax.policy-update'; //uri: /ir/ajax/policy/update -> App\Http\Controllers\IR\Ajax\Settings\PolicyController.update()

var ir_ajax_policyUpdateActiveFlag = 'ir.ajax.policy-update-active-flag'; //uri: /ir/ajax/policy/active-flag -> App\Http\Controllers\IR\Ajax\Settings\PolicyController.updateActiveFlag()

var ir_ajax_policyCheckUsedData = 'ir.ajax.policy-check-used-data'; //uri: /ir/ajax/policy/check-used-data/{policy_set_header_id} -> App\Http\Controllers\IR\Ajax\Settings\PolicyController.checkUsedData()

var ir_ajax_policyGroupHeaderIndex = 'ir.ajax.policy-group-header-index'; //uri: /ir/ajax/policy-group -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.index()

var ir_ajax_policyGroupHeaderOverlapCheck = 'ir.ajax.policy-group-header-overlap-check'; //uri: /ir/ajax/policy-group/overlap-check -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.overlapCheck()

var ir_ajax_policyGroupHeaderShow = 'ir.ajax.policy-group-header-show'; //uri: /ir/ajax/policy-group/{group_header_id} -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.show()

var ir_ajax_policyGroupHeaderGroupDists = 'ir.ajax.policy-group-header-group-dists'; //uri: /ir/ajax/group-dists -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.subDetail()

var ir_ajax_policyGroupHeaderStore = 'ir.ajax.policy-group-header-store'; //uri: /ir/ajax/policy-group/save -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.store()

var ir_ajax_policyGroupHeaderStoreIndex = 'ir.ajax.policy-group-header-store-index'; //uri: /ir/ajax/policy-group/save-index -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.storeIndex()

var ir_ajax_policyGroupSetDelete = 'ir.ajax.policy-group-set-delete'; //uri: /ir/ajax/policy-group/group-sets -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.deletePolicyGroupSet()

var ir_ajax_policyGroupHeaderUpdateActiveFlag = 'ir.ajax.policy-group-header-update-active-flag'; //uri: /ir/ajax/policy-group/update-active-flag -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.updateActiveFlag()

var ir_ajax_policyGroupHeaderDuplicateCheck = 'ir.ajax.policy-group-header-duplicate-check'; //uri: /ir/ajax/policy-group/duplicate-check/{policy_set_header_id} -> App\Http\Controllers\IR\Ajax\Settings\PolicyGroupController.policyDuplicateCheck()

var ir_ajax_vehiclesIndex = 'ir.ajax.vehicles-index'; //uri: /ir/ajax/vehicles -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.index()

var ir_ajax_vehiclesShow = 'ir.ajax.vehicles-show'; //uri: /ir/ajax/vehicles/show -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.show()

var ir_ajax_vehiclesCreateOrUpdate = 'ir.ajax.vehicles-create-or-update'; //uri: /ir/ajax/vehicles -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.createOrUpdate()

var ir_ajax_vehiclesActiveFlag = 'ir.ajax.vehicles-active-flag'; //uri: /ir/ajax/vehicles/active-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateActiveFlag()

var ir_ajax_vehiclesUpdateActiveFlag = 'ir.ajax.vehicles-update-active-flag'; //uri: /ir/ajax/vehicles/active-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateActiveFlag()

var ir_ajax_vehiclesReturnVatFlag = 'ir.ajax.vehicles-return-vat-flag'; //uri: /ir/ajax/vehicles/return-vat-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateReturnVatFlag()

var ir_ajax_vehiclesUpdateReturnVatFlag = 'ir.ajax.vehicles-update-return-vat-flag'; //uri: /ir/ajax/vehicles/return-vat-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateReturnVatFlag()

var ir_ajax_vehiclesDuplicateCheck = 'ir.ajax.vehicles-duplicate-check'; //uri: /ir/ajax/vehicles/duplicate-check -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.duplicateCheck()

var ir_ajax_gasStationsIndex = 'ir.ajax.gas-stations-index'; //uri: /ir/ajax/gas-stations -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.index()

var ir_ajax_gasStationsShow = 'ir.ajax.gas-stations-show'; //uri: /ir/ajax/gas-stations/{gas_station_id} -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.show()

var ir_ajax_gasStationsStore = 'ir.ajax.gas-stations-store'; //uri: /ir/ajax/gas-stations/save -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.store()

var ir_ajax_gasStationsUpdate = 'ir.ajax.gas-stations-update'; //uri: /ir/ajax/gas-stations/update -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.update()

var ir_ajax_gasStationsReturnVatFlag = 'ir.ajax.gas-stations-return-vat-flag'; //uri: /ir/ajax/gas-stations/return-vat-flag -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.updateReturnVatFlag()

var ir_ajax_gasStationsUpdateReturnVatFlag = 'ir.ajax.gas-stations-update-return-vat-flag'; //uri: /ir/ajax/gas-stations/return-vat-flag -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.updateReturnVatFlag()

var ir_ajax_gasStationsActiveFlag = 'ir.ajax.gas-stations-active-flag'; //uri: /ir/ajax/gas-stations/active-flag -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.updateActiveFlag()

var ir_ajax_gasStationsUpdateActiveFlag = 'ir.ajax.gas-stations-update-active-flag'; //uri: /ir/ajax/gas-stations/active-flag -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.updateActiveFlag()

var ir_ajax_stocksIndex = 'ir.ajax.stocks-index'; //uri: /ir/ajax/stocks -> App\Http\Controllers\IR\Ajax\StockController.index()

var ir_ajax_stocksFetch = 'ir.ajax.stocks-fetch'; //uri: /ir/ajax/stocks/fetch -> App\Http\Controllers\IR\Ajax\StockController.fetch()

var ir_ajax_stocksShow = 'ir.ajax.stocks-show'; //uri: /ir/ajax/stocks/show -> App\Http\Controllers\IR\Ajax\StockController.show()

var ir_ajax_stocksCreateOrUpdate = 'ir.ajax.stocks-create-or-update'; //uri: /ir/ajax/stocks -> App\Http\Controllers\IR\Ajax\StockController.createOrUpdate()

var ir_ajax_assetIndex = 'ir.ajax.asset-index'; //uri: /ir/ajax/asset -> App\Http\Controllers\IR\Ajax\AssetController.index()

var ir_ajax_assetFetch = 'ir.ajax.asset-fetch'; //uri: /ir/ajax/asset/fetch -> App\Http\Controllers\IR\Ajax\AssetController.fetch()

var ir_ajax_assetIndexAdjust = 'ir.ajax.asset-index-adjust'; //uri: /ir/ajax/asset/asset-adjust -> App\Http\Controllers\IR\Ajax\AssetController.indexAdjustHeaders()

var ir_ajax_assetFetchAdjust = 'ir.ajax.asset-fetch-adjust'; //uri: /ir/ajax/asset/asset-adjust/fetch -> App\Http\Controllers\IR\Ajax\AssetController.fetchAdjustment()

var ir_ajax_assetShow = 'ir.ajax.asset-show'; //uri: /ir/ajax/asset/show -> App\Http\Controllers\IR\Ajax\AssetController.show()

var ir_ajax_assetShowAdjust = 'ir.ajax.asset-show-adjust'; //uri: /ir/ajax/asset/asset-adjust/show -> App\Http\Controllers\IR\Ajax\AssetController.showAdjustLines()

var ir_ajax_assetCreateOrUpdate = 'ir.ajax.asset-create-or-update'; //uri: /ir/ajax/asset -> App\Http\Controllers\IR\Ajax\AssetController.createOrUpdate()

var ir_ajax_carsIndex = 'ir.ajax.cars-index'; //uri: /ir/ajax/cars -> App\Http\Controllers\IR\Ajax\CarsController.index()

var ir_ajax_carsFetch = 'ir.ajax.cars-fetch'; //uri: /ir/ajax/cars/fetch -> App\Http\Controllers\IR\Ajax\CarsController.fetch()

var ir_ajax_carsCreateOrUpdate = 'ir.ajax.cars-create-or-update'; //uri: /ir/ajax/cars -> App\Http\Controllers\IR\Ajax\CarsController.createOrUpdate()

var ir_ajax_carsDuplicateCheck = 'ir.ajax.cars-duplicate-check'; //uri: /ir/ajax/cars/duplicate-check -> App\Http\Controllers\IR\Ajax\CarsController.duplicateCheck()

var ir_ajax_carsStatus = 'ir.ajax.cars-status'; //uri: /ir/ajax/cars/status -> App\Http\Controllers\IR\Ajax\CarsController.updateStatus()

var ir_ajax_extendGasStationsIndex = 'ir.ajax.extend-gas-stations-index'; //uri: /ir/ajax/extend-gas-stations -> App\Http\Controllers\IR\Ajax\ExtendGasStationController.index()

var ir_ajax_extendGasStationsFetch = 'ir.ajax.extend-gas-stations-fetch'; //uri: /ir/ajax/extend-gas-stations/fetch -> App\Http\Controllers\IR\Ajax\ExtendGasStationController.fetch()

var ir_ajax_extendGasStationsCreateOrUpdate = 'ir.ajax.extend-gas-stations-create-or-update'; //uri: /ir/ajax/extend-gas-stations -> App\Http\Controllers\IR\Ajax\ExtendGasStationController.createOrUpdate()

var ir_ajax_extendGasStationsDuplicateCheck = 'ir.ajax.extend-gas-stations-duplicate-check'; //uri: /ir/ajax/extend-gas-stations/duplicate-check -> App\Http\Controllers\IR\Ajax\ExtendGasStationController.duplicateCheck()

var ir_ajax_extendGasStationsStatus = 'ir.ajax.extend-gas-stations-status'; //uri: /ir/ajax/extend-gas-stations/status -> App\Http\Controllers\IR\Ajax\ExtendGasStationController.updateStatus()

var ir_ajax_personsIndex = 'ir.ajax.persons-index'; //uri: /ir/ajax/persons -> App\Http\Controllers\IR\Ajax\PersonsController.index()

var ir_ajax_personsCreateOrUpdate = 'ir.ajax.persons-create-or-update'; //uri: /ir/ajax/persons -> App\Http\Controllers\IR\Ajax\PersonsController.createOrUpdate()

var ir_ajax_personsDuplicateCheck = 'ir.ajax.persons-duplicate-check'; //uri: /ir/ajax/persons/duplicate-check -> App\Http\Controllers\IR\Ajax\PersonsController.duplicateCheck()

var ir_ajax_personsDuplicateCheckInvoiceNumber = 'ir.ajax.persons-duplicate-check-invoice-number'; //uri: /ir/ajax/persons/duplicate-check/invoice-number -> App\Http\Controllers\IR\Ajax\PersonsController.invoiceNumberCheck()

var ir_ajax_personsStatus = 'ir.ajax.persons-status'; //uri: /ir/ajax/persons/status -> App\Http\Controllers\IR\Ajax\PersonsController.updateStatus()

var ir_ajax_expenseAssetStockIndex = 'ir.ajax.expense-asset-stock-index'; //uri: /ir/ajax/expense-asset-stock -> App\Http\Controllers\IR\Ajax\ExpenseStockAssetsController.index()

var ir_ajax_expenseAssetStockStore = 'ir.ajax.expense-asset-stock-store'; //uri: /ir/ajax/expense-asset-stock -> App\Http\Controllers\IR\Ajax\ExpenseStockAssetsController.store()

var ir_ajax_expenseCarGasIndex = 'ir.ajax.expense-car-gas-index'; //uri: /ir/ajax/expense-car-gas -> App\Http\Controllers\IR\Ajax\ExpenseCarGasController.index()

var ir_ajax_expenseCarGasStore = 'ir.ajax.expense-car-gas-store'; //uri: /ir/ajax/expense-car-gas -> App\Http\Controllers\IR\Ajax\ExpenseCarGasController.store()

var ir_ajax_claimIndex = 'ir.ajax.claim-index'; //uri: /ir/ajax/claim -> App\Http\Controllers\IR\Ajax\ClaimController.index()

var ir_ajax_claimShow = 'ir.ajax.claim-show'; //uri: /ir/ajax/claim/{claim_header_id} -> App\Http\Controllers\IR\Ajax\ClaimController.show()

var ir_ajax_claimCreateOrUpdate = 'ir.ajax.claim-create-or-update'; //uri: /ir/ajax/claim -> App\Http\Controllers\IR\Ajax\ClaimController.createOrUpdate()

var ir_ajax_claimDelete = 'ir.ajax.claim-delete'; //uri: /ir/ajax/claim/{claim_header_id} -> App\Http\Controllers\IR\Ajax\ClaimController.delete()

var ir_ajax_claimDeleteCompany = 'ir.ajax.claim-delete-company'; //uri: /ir/ajax/claim/company/{claim_header_id} -> App\Http\Controllers\IR\Ajax\ClaimController.deleteCompany()

var ir_ajax_claimUpload = 'ir.ajax.claim-upload'; //uri: /ir/ajax/claim/upload -> App\Http\Controllers\IR\Ajax\ClaimController.uploadFile()

var ir_ajax_claimDeleteFile = 'ir.ajax.claim-delete-file'; //uri: /ir/ajax/claim/file/{attachment_id} -> App\Http\Controllers\IR\Ajax\ClaimController.deleteFile()

var ir_ajax_confirmApInterface = 'ir.ajax.confirm-ap-interface'; //uri: /ir/ajax/confirm-ap -> App\Http\Controllers\IR\Ajax\ConfirmToApController.interfaceAp()

var ir_ajax_confirmApCancel = 'ir.ajax.confirm-ap-cancel'; //uri: /ir/ajax/confirm-ap/cancel -> App\Http\Controllers\IR\Ajax\ConfirmToApController.cancel()

var ir_ajax_confirmGlInterface = 'ir.ajax.confirm-gl-interface'; //uri: /ir/ajax/confirm-gl -> App\Http\Controllers\IR\Ajax\ConfirmToGlController.interfaceGl()

var ir_ajax_confirmGlCancel = 'ir.ajax.confirm-gl-cancel'; //uri: /ir/ajax/confirm-gl/cancel -> App\Http\Controllers\IR\Ajax\ConfirmToGlController.cancel()

var ir_ajax_confirmArInterface = 'ir.ajax.confirm-ar-interface'; //uri: /ir/ajax/confirm-ar -> App\Http\Controllers\IR\Ajax\ConfirmToArController.interfaceAr()

var ir_ajax_confirmArCancel = 'ir.ajax.confirm-ar-cancel'; //uri: /ir/ajax/confirm-ar/cancel -> App\Http\Controllers\IR\Ajax\ConfirmToArController.cancel()

var ir_ajax_accountMapping_index = 'ir.ajax.account-mapping.index'; //uri: /ir/ajax/coa-mapping -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.index()

var ir_ajax_validateCombination = 'ir.ajax.validate-combination'; //uri: /ir/ajax/validate-combination -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.validateCombination()

var ir_ajax_showAccountMapping = 'ir.ajax.show-account-mapping'; //uri: /ir/ajax/account-mapping -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.showAccountMapping()

var ir_ajax_companiesCode = 'ir.ajax.companies-code'; //uri: /ir/ajax/companies-code/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.companiesCode()

var ir_ajax_evmCode = 'ir.ajax.evm-code'; //uri: /ir/ajax/evm-code/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.evmCode()

var ir_ajax_departmentCode = 'ir.ajax.department-code'; //uri: /ir/ajax/department-code/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.departmentCode()

var ir_ajax_costcenterCode = 'ir.ajax.costcenter-code'; //uri: /ir/ajax/costcenter-code/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.costCenterCode()

var ir_ajax_budgetYear = 'ir.ajax.budget-year'; //uri: /ir/ajax/budget-year/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.budgetYear()

var ir_ajax_budgetType = 'ir.ajax.budget-type'; //uri: /ir/ajax/budget-type/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.budgetType()

var ir_ajax_budgetDetail = 'ir.ajax.budget-detail'; //uri: /ir/ajax/budget-detail/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.budgetDetail()

var ir_ajax_budgetReason = 'ir.ajax.budget-reason'; //uri: /ir/ajax/budget-reason/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.budgetReason()

var ir_ajax_mainAccount = 'ir.ajax.main-account'; //uri: /ir/ajax/main-account/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.mainAccount()

var ir_ajax_subAccount = 'ir.ajax.sub-account'; //uri: /ir/ajax/sub-account/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.subAccount()

var ir_ajax_reserverd1 = 'ir.ajax.reserverd1'; //uri: /ir/ajax/reserved1/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.reserved1()

var ir_ajax_reserverd2 = 'ir.ajax.reserverd2'; //uri: /ir/ajax/reserved2/all -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.reserved2()

var ir_ajax_codeCombineLov = 'ir.ajax.code-combine-lov'; //uri: /ir/ajax/account-mapping/lov/account-code-combine -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.accountCodeCombineLov()

var ir_ajax_accountDesc = 'ir.ajax.account-desc'; //uri: /ir/ajax/get-account-desc -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.getAccountDesc()

var ir_ajax_vehiclesLovLicensePlate = 'ir.ajax.vehicles-lov-license-plate'; //uri: /ir/ajax/vehicles/lov/license-plate -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.licensePlateLov()

var ir_ajax_vehiclesLovType = 'ir.ajax.vehicles-lov-type'; //uri: /ir/ajax/vehicles/lov/vehicles-type -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.vehiclesTypeLov()

var ir_ajax_vehiclesUpdateOrCreate = 'ir.ajax.vehicles-update-or-create'; //uri: /ir/ajax/vehicles/updateOrCreate -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateOrCreate()

var ir_ajax_lookupGasStationsLovType = 'ir.ajax.lookup-gas-stations-lov-type'; //uri: /ir/ajax/gas-stations/lov/lookup-type -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.lookupGasStationTypeLov()

var ir_ajax_lookupGasStationsLovGroups = 'ir.ajax.lookup-gas-stations-lov-groups'; //uri: /ir/ajax/gas-stations/lov/lookup-group -> App\Http\Controllers\IR\Ajax\Settings\GasStationsController.lookupGasStationGroupsLov()

var ir_ajax_irReportGetInfo = 'ir.ajax.ir-report-get-info'; //uri: /ir/ajax/ir-report-get-info -> App\Http\Controllers\IR\Ajax\IrReportsController.getInfo()

var report_ajax_reportGetInfo = 'report.ajax.report-get-info'; //uri: /ir/ajax/ir-report-get-info -> App\Http\Controllers\IR\Ajax\IrReportsController.getInfo()

var ir_ajax_irReportGetInfoAttribute = 'ir.ajax.ir-report-get-info-attribute'; //uri: /ir/ajax/ir-report-get-info-attribute -> App\Http\Controllers\IR\Ajax\IrReportsController.getInfoAttribute()

var report_ajax_reportGetInfoAttribute = 'report.ajax.report-get-info-attribute'; //uri: /ir/ajax/ir-report-get-info-attribute -> App\Http\Controllers\IR\Ajax\IrReportsController.getInfoAttribute()

var ir_ajax_irReportSubmit = 'ir.ajax.ir-report-submit'; //uri: /ir/ajax/ir-report-submit -> App\Http\Controllers\IR\Ajax\IrReportsController.irReportSubmit()

var report_ajax_irReportSubmit = 'report.ajax.ir-report-submit'; //uri: /ir/ajax/ir-report-submit -> App\Http\Controllers\IR\Ajax\IrReportsController.irReportSubmit()

var ir_settings_storeAccountMapping = 'ir.settings.store-account-mapping'; //uri: /ir/settings/account-mapping/save -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.store()

var ir_settings_updateAccountMapping = 'ir.settings.update-account-mapping'; //uri: /ir/settings/account-mapping/update -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.update()

var ir_settings_policy_index = 'ir.settings.policy.index'; //uri: /ir/settings/policy -> App\Http\Controllers\IR\Settings\PolicyController.index()

var ir_settings_policies_index = 'ir.settings.policies.index'; //uri: /ir/settings/policy -> App\Http\Controllers\IR\Settings\PolicyController.index()

var ir_settings_policy_create = 'ir.settings.policy.create'; //uri: /ir/settings/policy/create -> App\Http\Controllers\IR\Settings\PolicyController.create()

var ir_settings_policies_create = 'ir.settings.policies.create'; //uri: /ir/settings/policy/create -> App\Http\Controllers\IR\Settings\PolicyController.create()

var ir_settings_policy_edit = 'ir.settings.policy.edit'; //uri: /ir/settings/policy/edit/{id} -> App\Http\Controllers\IR\Settings\PolicyController.edit()

var ir_settings_policies_edit = 'ir.settings.policies.edit'; //uri: /ir/settings/policy/edit/{id} -> App\Http\Controllers\IR\Settings\PolicyController.edit()

var ir_settings_vehicle_index = 'ir.settings.vehicle.index'; //uri: /ir/settings/vehicle -> App\Http\Controllers\IR\Settings\VehicleController.index()

var ir_settings_vehicle_create = 'ir.settings.vehicle.create'; //uri: /ir/settings/vehicle/create -> App\Http\Controllers\IR\Settings\VehicleController.create()

var ir_settings_vehicle_edit = 'ir.settings.vehicle.edit'; //uri: /ir/settings/vehicle/edit/{id} -> App\Http\Controllers\IR\Settings\VehicleController.edit()

var ir_settings_gasStations_index = 'ir.settings.gas-stations.index'; //uri: /ir/settings/gas-stations -> App\Http\Controllers\IR\GasStationsController.index()

var ir_gasStations_gasStation_index = 'ir.gas-stations.gas-station.index'; //uri: /ir/settings/gas-stations -> App\Http\Controllers\IR\GasStationsController.index()

var ir_settings_gasStations_create = 'ir.settings.gas-stations.create'; //uri: /ir/settings/gas-stations/create -> App\Http\Controllers\IR\GasStationsController.create()

var ir_settings_gasStations_edit = 'ir.settings.gas-stations.edit'; //uri: /ir/settings/gas-stations/edit -> App\Http\Controllers\IR\GasStationsController.edit()

var ir_settings_policyGroup_index = 'ir.settings.policy-group.index'; //uri: /ir/settings/policy-group -> App\Http\Controllers\IR\Settings\PolicyGroupController.index()

var ir_settings_policyGroup_edit = 'ir.settings.policy-group.edit'; //uri: /ir/settings/policy-group/edit/{id} -> App\Http\Controllers\IR\Settings\PolicyGroupController.edit()

var ir_settings_irp0008_index = 'ir.settings.irp-0008.index'; //uri: /ir/settings/irp-0008 -> App\Http\Controllers\IR\ExpenseStockAssetController.index()

var ir_expenseStockAsset_index = 'ir.expense-stock-asset.index'; //uri: /ir/settings/irp-0008 -> App\Http\Controllers\IR\ExpenseStockAssetController.index()

var ir_settings_reportInfo_index = 'ir.settings.report-info.index'; //uri: /ir/settings/report-info -> App\Http\Controllers\IR\Settings\ReportInfoController.index()

var report_reportInfo_reportInfo_index = 'report.report-info.report-info.index'; //uri: /ir/settings/report-info -> App\Http\Controllers\IR\Settings\ReportInfoController.index()

var ir_settings_reportInfo_show = 'ir.settings.report-info.show'; //uri: /ir/settings/report-info/{program} -> App\Http\Controllers\IR\Settings\ReportInfoController.show()

var report_reportInfo_reportInfo_show = 'report.report-info.report-info.show'; //uri: /ir/settings/report-info/{program} -> App\Http\Controllers\IR\Settings\ReportInfoController.show()

var ir_settings_reportInfo_store = 'ir.settings.report-info.store'; //uri: /ir/settings/report-info/{program} -> App\Http\Controllers\IR\Settings\ReportInfoController.store()

var report_reportInfo_reportInfo_store = 'report.report-info.report-info.store'; //uri: /ir/settings/report-info/{program} -> App\Http\Controllers\IR\Settings\ReportInfoController.store()

var ir_settings_reportInfo_update = 'ir.settings.report-info.update'; //uri: /ir/settings/report-info/{program}/{info} -> App\Http\Controllers\IR\Settings\ReportInfoController.update()

var report_reportInfo_reportInfo_update = 'report.report-info.report-info.update'; //uri: /ir/settings/report-info/{program}/{info} -> App\Http\Controllers\IR\Settings\ReportInfoController.update()

var ir_settings_reportInfo_destroy = 'ir.settings.report-info.destroy'; //uri: /ir/settings/report-info/{program}/{info}/delete -> App\Http\Controllers\IR\Settings\ReportInfoController.destroy()

var report_reportInfo_reportInfo_destroy = 'report.report-info.report-info.destroy'; //uri: /ir/settings/report-info/{program}/{info}/delete -> App\Http\Controllers\IR\Settings\ReportInfoController.destroy()

var ir_settings_company_index = 'ir.settings.company.index'; //uri: /ir/settings/company -> App\Http\Controllers\IR\Settings\CompanyController.index()

var ir_settings_company_create = 'ir.settings.company.create'; //uri: /ir/settings/company/create -> App\Http\Controllers\IR\Settings\CompanyController.create()

var ir_settings_company_edit = 'ir.settings.company.edit'; //uri: /ir/settings/company/edit/{id} -> App\Http\Controllers\IR\Settings\CompanyController.edit()

var ir_settings_gasStation_index = 'ir.settings.gas-station.index'; //uri: /ir/settings/gas-station -> App\Http\Controllers\IR\Settings\GasStationController.index()

var ir_settings_accountMapping_index = 'ir.settings.account-mapping.index'; //uri: /ir/settings/account-mapping -> App\Http\Controllers\IR\Settings\AccountMappingController.index()

var ir_settings_accountMapping_create = 'ir.settings.account-mapping.create'; //uri: /ir/settings/account-mapping/create -> App\Http\Controllers\IR\Settings\AccountMappingController.create()

var ir_settings_accountMapping_store = 'ir.settings.account-mapping.store'; //uri: /ir/settings/account-mapping -> App\Http\Controllers\IR\Settings\AccountMappingController.store()

var ir_settings_accountMapping_show = 'ir.settings.account-mapping.show'; //uri: /ir/settings/account-mapping/{account_mapping} -> App\Http\Controllers\IR\Settings\AccountMappingController.show()

var ir_settings_accountMapping_edit = 'ir.settings.account-mapping.edit'; //uri: /ir/settings/account-mapping/{account_mapping}/edit -> App\Http\Controllers\IR\Settings\AccountMappingController.edit()

var ir_settings_accountMapping_update = 'ir.settings.account-mapping.update'; //uri: /ir/settings/account-mapping/{account_mapping} -> App\Http\Controllers\IR\Settings\AccountMappingController.update()

var ir_settings_accountMapping_destroy = 'ir.settings.account-mapping.destroy'; //uri: /ir/settings/account-mapping/{account_mapping} -> App\Http\Controllers\IR\Settings\AccountMappingController.destroy()

var ir_settings_gasStation_create = 'ir.settings.gas-station.create'; //uri: /ir/settings/gas-station/create -> App\Http\Controllers\IR\Settings\GasStationController.create()

var ir_settings_gasStation_edit = 'ir.settings.gas-station.edit'; //uri: /ir/settings/gas-station/edit/{id} -> App\Http\Controllers\IR\Settings\GasStationController.edit()

var ir_stocks_yearly_index = 'ir.stocks.yearly.index'; //uri: /ir/stocks/yearly -> App\Http\Controllers\IR\StockController.yearly()

var ir_stocks_yearly_edit = 'ir.stocks.yearly.edit'; //uri: /ir/stocks/yearly/edit/{id} -> App\Http\Controllers\IR\StockController.yearlyEdit()

var ir_stocks_monthly_index = 'ir.stocks.monthly.index'; //uri: /ir/stocks/monthly -> App\Http\Controllers\IR\StockController.monthly()

var ir_stocks_monthly_edit = 'ir.stocks.monthly.edit'; //uri: /ir/stocks/monthly/edit/{id} -> App\Http\Controllers\IR\StockController.monthlyEdit()

var ir_assets_assetPlan_index = 'ir.assets.asset-plan.index'; //uri: /ir/assets/asset-plan -> App\Http\Controllers\IR\AssetController.plan()

var ir_assets_assetPlan_edit = 'ir.assets.asset-plan.edit'; //uri: /ir/assets/asset-plan/edit/{id} -> App\Http\Controllers\IR\AssetController.planEdit()

var ir_assets_assetIncrease_index = 'ir.assets.asset-increase.index'; //uri: /ir/assets/asset-increase -> App\Http\Controllers\IR\AssetController.increase()

var ir_assets_assetIncrease_edit = 'ir.assets.asset-increase.edit'; //uri: /ir/assets/asset-increase/edit/{id} -> App\Http\Controllers\IR\AssetController.increaseEdit()

var ir_cars_car_index = 'ir.cars.car.index'; //uri: /ir/cars/car -> App\Http\Controllers\IR\CarsController.index()

var ir_governors_governor_index = 'ir.governors.governor.index'; //uri: /ir/governors/governor -> App\Http\Controllers\IR\GovernorController.index()

var ir_calculateInsurance_index = 'ir.calculate-insurance.index'; //uri: /ir/calculate-insurance -> App\Http\Controllers\IR\CalculateInsuranceController.index()

var ir_calculateInsurance_report = 'ir.calculate-insurance.report'; //uri: /ir/calculate-insurance/report -> App\Http\Controllers\IR\CalculateInsuranceController.report()

var ir_calculateInsurance_interface = 'ir.calculate-insurance.interface'; //uri: /ir/calculate-insurance/interface -> App\Http\Controllers\IR\CalculateInsuranceController.interface()

var ir_calculateInsurance_cancel = 'ir.calculate-insurance.cancel'; //uri: /ir/calculate-insurance/cancel -> App\Http\Controllers\IR\CalculateInsuranceController.cancel()

var ir_expenseCarGas_index = 'ir.expense-car-gas.index'; //uri: /ir/expense-car-gas -> App\Http\Controllers\IR\ExpenseCarGasController.index()

var ir_claimInsurance_index = 'ir.claim-insurance.index'; //uri: /ir/claim-insurance -> App\Http\Controllers\IR\ClaimInsuranceController.index()

var ir_claimInsurance_create = 'ir.claim-insurance.create'; //uri: /ir/claim-insurance/create -> App\Http\Controllers\IR\ClaimInsuranceController.create()

var ir_claimInsurance_edit = 'ir.claim-insurance.edit'; //uri: /ir/claim-insurance/edit/{id} -> App\Http\Controllers\IR\ClaimInsuranceController.edit()

var ir_confirmToAp_index = 'ir.confirm-to-ap.index'; //uri: /ir/confirm-to-ap -> App\Http\Controllers\IR\ConfirmToAPController.index()

var ir_confirmToGl_index = 'ir.confirm-to-gl.index'; //uri: /ir/confirm-to-gl -> App\Http\Controllers\IR\ConfirmToGLController.index()

var ir_confirmToAr_index = 'ir.confirm-to-ar.index'; //uri: /ir/confirm-to-ar -> App\Http\Controllers\IR\ConfirmToARController.index()

var ir_report_export = 'ir.report.export'; //uri: /ir/reports/export -> App\Http\Controllers\IR\ReportsController.export()

var ir_report_index = 'ir.report.index'; //uri: /ir/reports -> App\Http\Controllers\IR\ReportsController.index()

var ir_report_getParam = 'ir.report.get-param'; //uri: /ir/reports/get-param -> App\Http\Controllers\IR\ReportsController.getParam()

var ie_ajax_icon_index = 'ie.ajax.icon.index'; //uri: /ie/ajax/icon -> App\Http\Controllers\IE\Ajax\IconController.index()

var ie_cashAdvances_getSuppliers = 'ie.cash-advances.get_suppliers'; //uri: /ie/cash-advances/get_suppliers -> App\Http\Controllers\IE\CashAdvanceController.getSuppliers()

var ie_cashAdvances_getSupplierSites = 'ie.cash-advances.get_supplier_sites'; //uri: /ie/cash-advances/get_supplier_sites -> App\Http\Controllers\IE\CashAdvanceController.getSupplierSites()

var ie_cashAdvances_getRequesterData = 'ie.cash-advances.get_requester_data'; //uri: /ie/cash-advances/get_requester_data -> App\Http\Controllers\IE\CashAdvanceController.getRequesterData()

var ie_cashAdvances_indexPending = 'ie.cash-advances.index-pending'; //uri: /ie/cash-advances/pending -> App\Http\Controllers\IE\CashAdvanceController.indexPending()

var ie_cashAdvances_getSubCategories = 'ie.cash-advances.get_sub_categories'; //uri: /ie/cash-advances/get_sub_categories -> App\Http\Controllers\IE\CashAdvanceController.getSubCategories()

var ie_cashAdvances_getFormInformations = 'ie.cash-advances.get_form_informations'; //uri: /ie/cash-advances/ca_sub_category/{ca_sub_category}/get_form_informations -> App\Http\Controllers\IE\CashAdvanceController.getInputFormInformations()

var ie_cashAdvances_index = 'ie.cash-advances.index'; //uri: /ie/cash-advances -> App\Http\Controllers\IE\CashAdvanceController.index()

var ie_cashAdvances_create = 'ie.cash-advances.create'; //uri: /ie/cash-advances/create -> App\Http\Controllers\IE\CashAdvanceController.create()

var ie_cashAdvances_show = 'ie.cash-advances.show'; //uri: /ie/cash-advances/{cashAdvance} -> App\Http\Controllers\IE\CashAdvanceController.show()

var ie_cashAdvances_update = 'ie.cash-advances.update'; //uri: /ie/cash-advances/{cashAdvance} -> App\Http\Controllers\IE\CashAdvanceController.update()

var ie_cashAdvances_store = 'ie.cash-advances.store'; //uri: /ie/cash-advances/store -> App\Http\Controllers\IE\CashAdvanceController.store()

var ie_cashAdvances_export = 'ie.cash-advances.export'; //uri: /ie/cash-advances/export -> App\Http\Controllers\IE\CashAdvanceController.export()

var ie_cashAdvances_updateCl = 'ie.cash-advances.update_cl'; //uri: /ie/cash-advances/{cashAdvance}/update_cl -> App\Http\Controllers\IE\CashAdvanceController.updateCL()

var ie_cashAdvances_formEdit = 'ie.cash-advances.form_edit'; //uri: /ie/cash-advances/{cashAdvance}/form_edit -> App\Http\Controllers\IE\CashAdvanceController.formEdit()

var ie_cashAdvances_formEditCl = 'ie.cash-advances.form_edit_cl'; //uri: /ie/cash-advances/{cashAdvance}/form_edit_cl -> App\Http\Controllers\IE\CashAdvanceController.formEditCL()

var ie_cashAdvances_report = 'ie.cash-advances.report'; //uri: /ie/cash-advances/{cashAdvance}/report -> App\Http\Controllers\IE\CashAdvanceController.report()

var ie_cashAdvances_getTotalAmount = 'ie.cash-advances.get_total_amount'; //uri: /ie/cash-advances/{cashAdvance}/get_total_amount -> App\Http\Controllers\IE\CashAdvanceController.getTotalAmount()

var ie_cashAdvances_updateDff = 'ie.cash-advances.update_dff'; //uri: /ie/cash-advances/{cashAdvance}/update_dff -> App\Http\Controllers\IE\CashAdvanceController.updateDFF()

var ie_cashAdvances_changeApprover = 'ie.cash-advances.change_approver'; //uri: /ie/cash-advances/{cashAdvance}/change_approver -> App\Http\Controllers\IE\CashAdvanceController.changeApprover()

var ie_cashAdvances_setStatus = 'ie.cash-advances.set_status'; //uri: /ie/cash-advances/{cashAdvance}/set_status -> App\Http\Controllers\IE\CashAdvanceController.setStatus()

var ie_cashAdvances_addAttachment = 'ie.cash-advances.add_attachment'; //uri: /ie/cash-advances/{cashAdvance}/add_attachment -> App\Http\Controllers\IE\CashAdvanceController.addAttachment()

var ie_cashAdvances_setDueDate = 'ie.cash-advances.set_due_date'; //uri: /ie/cash-advances/{cashAdvance}/set_due_date -> App\Http\Controllers\IE\CashAdvanceController.setDueDate()

var ie_cashAdvances_getDiffCaAndClearingAmount = 'ie.cash-advances.get_diff_ca_and_clearing_amount'; //uri: /ie/cash-advances/{cashAdvance}/get_diff_ca_and_clearing_amount -> App\Http\Controllers\IE\CashAdvanceController.getDiffCAAndClearingAmount()

var ie_cashAdvances_getDiffCaAndClearingData = 'ie.cash-advances.get_diff_ca_and_clearing_data'; //uri: /ie/cash-advances/{cashAdvance}/get_diff_ca_and_clearing_data -> App\Http\Controllers\IE\CashAdvanceController.getDiffCAAndClearingData()

var ie_cashAdvances_duplicate = 'ie.cash-advances.duplicate'; //uri: /ie/cash-advances/{cashAdvance}/duplicate -> App\Http\Controllers\IE\CashAdvanceController.duplicate()

var ie_cashAdvances_clearRequest = 'ie.cash-advances.clear-request'; //uri: /ie/cash-advances/{cashAdvance}/clear-request -> App\Http\Controllers\IE\CashAdvanceController.clearRequest()

var ie_cashAdvances_clear = 'ie.cash-advances.clear'; //uri: /ie/cash-advances/{cashAdvance}/clear -> App\Http\Controllers\IE\CashAdvanceController.clear()

var ie_cashAdvances_checkCaAttachment = 'ie.cash-advances.check_ca_attachment'; //uri: /ie/cash-advances/{cashAdvance}/check_ca_attachment -> App\Http\Controllers\IE\CashAdvanceController.checkCAAttachment()

var ie_cashAdvances_checkCaMinAmount = 'ie.cash-advances.check_ca_min_amount'; //uri: /ie/cash-advances/{cashAdvance}/check_ca_min_amount -> App\Http\Controllers\IE\CashAdvanceController.checkCAMinAmount()

var ie_cashAdvances_checkCaMaxAmount = 'ie.cash-advances.check_ca_max_amount'; //uri: /ie/cash-advances/{cashAdvance}/check_ca_max_amount -> App\Http\Controllers\IE\CashAdvanceController.checkCAMaxAmount()

var ie_cashAdvances_combineReceiptGlCodeCombination = 'ie.cash-advances.combine_receipt_gl_code_combination'; //uri: /ie/cash-advances/{cashAdvance}/combine_receipt_gl_code_combination -> App\Http\Controllers\IE\CashAdvanceController.combineReceiptGLCodeCombination()

var ie_cashAdvances_checkOverBudget = 'ie.cash-advances.check_over_budget'; //uri: /ie/cash-advances/{cashAdvance}/check_over_budget -> App\Http\Controllers\IE\CashAdvanceController.checkOverBudget()

var ie_cashAdvances_checkExceedPolicy = 'ie.cash-advances.check_exceed_policy'; //uri: /ie/cash-advances/{cashAdvance}/check_exceed_policy -> App\Http\Controllers\IE\CashAdvanceController.checkExceedPolicy()

var ie_cashAdvances_validateReceipt = 'ie.cash-advances.validate_receipt'; //uri: /ie/cash-advances/{cashAdvance}/validate_receipt -> App\Http\Controllers\IE\CashAdvanceController.validateReceipt()

var ie_cashAdvances_formSendRequestWithReason = 'ie.cash-advances.form_send_request_with_reason'; //uri: /ie/cash-advances/{cashAdvance}/form_send_request_with_reason -> App\Http\Controllers\IE\CashAdvanceController.formSendRequestWithReason()

var ie_reimbursements_getSuppliers = 'ie.reimbursements.get_suppliers'; //uri: /ie/reimbursements/get_suppliers -> App\Http\Controllers\IE\ReimbursementController.getSuppliers()

var ie_reimbursements_getSupplierSites = 'ie.reimbursements.get_supplier_sites'; //uri: /ie/reimbursements/get_supplier_sites -> App\Http\Controllers\IE\ReimbursementController.getSupplierSites()

var ie_reimbursements_getRequesterData = 'ie.reimbursements.get_requester_data'; //uri: /ie/reimbursements/get_requester_data -> App\Http\Controllers\IE\ReimbursementController.getRequesterData()

var ie_reimbursements_indexPending = 'ie.reimbursements.index-pending'; //uri: /ie/reimbursements/pending -> App\Http\Controllers\IE\ReimbursementController.indexPending()

var ie_reimbursements_index = 'ie.reimbursements.index'; //uri: /ie/reimbursements -> App\Http\Controllers\IE\ReimbursementController.index()

var ie_reimbursements_create = 'ie.reimbursements.create'; //uri: /ie/reimbursements/create -> App\Http\Controllers\IE\ReimbursementController.create()

var ie_reimbursements_show = 'ie.reimbursements.show'; //uri: /ie/reimbursements/{reimbursement} -> App\Http\Controllers\IE\ReimbursementController.show()

var ie_reimbursements_update = 'ie.reimbursements.update'; //uri: /ie/reimbursements/{reimbursement} -> App\Http\Controllers\IE\ReimbursementController.update()

var ie_reimbursements_store = 'ie.reimbursements.store'; //uri: /ie/reimbursements/store -> App\Http\Controllers\IE\ReimbursementController.store()

var ie_reimbursements_export = 'ie.reimbursements.export'; //uri: /ie/reimbursements/export -> App\Http\Controllers\IE\ReimbursementController.export()

var ie_reimbursements_formEdit = 'ie.reimbursements.form_edit'; //uri: /ie/reimbursements/{reimbursement}/form_edit -> App\Http\Controllers\IE\ReimbursementController.formEdit()

var ie_reimbursements_getTotalAmount = 'ie.reimbursements.get_total_amount'; //uri: /ie/reimbursements/{reimbursement}/get_total_amount -> App\Http\Controllers\IE\ReimbursementController.getTotalAmount()

var ie_reimbursements_updateDff = 'ie.reimbursements.update_dff'; //uri: /ie/reimbursements/{reimbursement}/update_dff -> App\Http\Controllers\IE\ReimbursementController.updateDFF()

var ie_reimbursements_changeApprover = 'ie.reimbursements.change_approver'; //uri: /ie/reimbursements/{reimbursement}/change_approver -> App\Http\Controllers\IE\ReimbursementController.changeApprover()

var ie_reimbursements_setStatus = 'ie.reimbursements.set_status'; //uri: /ie/reimbursements/{reimbursement}/set_status -> App\Http\Controllers\IE\ReimbursementController.setStatus()

var ie_reimbursements_addAttachment = 'ie.reimbursements.add_attachment'; //uri: /ie/reimbursements/{reimbursement}/add_attachment -> App\Http\Controllers\IE\ReimbursementController.addAttachment()

var ie_reimbursements_setDueDate = 'ie.reimbursements.set_due_date'; //uri: /ie/reimbursements/{reimbursement}/set_due_date -> App\Http\Controllers\IE\ReimbursementController.setDueDate()

var ie_reimbursements_duplicate = 'ie.reimbursements.duplicate'; //uri: /ie/reimbursements/{reimbursement}/duplicate -> App\Http\Controllers\IE\ReimbursementController.duplicate()

var ie_reimbursements_combineReceiptGlCodeCombination = 'ie.reimbursements.combine_receipt_gl_code_combination'; //uri: /ie/reimbursements/{reimbursement}/combine_receipt_gl_code_combination -> App\Http\Controllers\IE\ReimbursementController.combineReceiptGLCodeCombination()

var ie_reimbursements_checkOverBudget = 'ie.reimbursements.check_over_budget'; //uri: /ie/reimbursements/{reimbursement}/check_over_budget -> App\Http\Controllers\IE\ReimbursementController.checkOverBudget()

var ie_reimbursements_checkExceedPolicy = 'ie.reimbursements.check_exceed_policy'; //uri: /ie/reimbursements/{reimbursement}/check_exceed_policy -> App\Http\Controllers\IE\ReimbursementController.checkExceedPolicy()

var ie_reimbursements_validateReceipt = 'ie.reimbursements.validate_receipt'; //uri: /ie/reimbursements/{reimbursement}/validate_receipt -> App\Http\Controllers\IE\ReimbursementController.validateReceipt()

var ie_reimbursements_formSendRequestWithReason = 'ie.reimbursements.form_send_request_with_reason'; //uri: /ie/reimbursements/{reimbursement}/form_send_request_with_reason -> App\Http\Controllers\IE\ReimbursementController.formSendRequestWithReason()

var ie_receipts_getInvTobacco = 'ie.receipts.get_inv_tobacco'; //uri: /ie/receipts/get_inv_tobacco -> App\Http\Controllers\IE\ReceiptLineController.getInvTobacco()

var ie_receipts_getVendorSites = 'ie.receipts.get_vendor_sites'; //uri: /ie/receipts/get_vendor_sites/{vendor_id} -> App\Http\Controllers\IE\ReceiptController.getVendorSites()

var ie_receipts_getVendorDetail = 'ie.receipts.get_vendor_detail'; //uri: /ie/receipts/get_vendor_detail/{vendor_id}/site/{vendor_site_code} -> App\Http\Controllers\IE\ReceiptController.getVendorDetail()

var ie_receipts_getRows = 'ie.receipts.get_rows'; //uri: /ie/receipts/get_rows -> App\Http\Controllers\IE\ReceiptController.getRows()

var ie_receipts_getTableTotalRows = 'ie.receipts.get_table_total_rows'; //uri: /ie/receipts/get_table_total_rows -> App\Http\Controllers\IE\ReceiptController.getTableTotalRows()

var ie_receipts_formCreate = 'ie.receipts.form_create'; //uri: /ie/receipts/form_create -> App\Http\Controllers\IE\ReceiptController.formCreate()

var ie_receipts_indexPending = 'ie.receipts.index-pending'; //uri: /ie/receipts/pending -> App\Http\Controllers\IE\ReceiptController.indexPending()

var ie_receipts_create = 'ie.receipts.create'; //uri: /ie/receipts/create -> App\Http\Controllers\IE\ReceiptController.create()

var ie_receipts_show = 'ie.receipts.show'; //uri: /ie/receipts/{receipt} -> App\Http\Controllers\IE\ReceiptController.show()

var ie_receipts_update = 'ie.receipts.update'; //uri: /ie/receipts/{receipt}/update -> App\Http\Controllers\IE\ReceiptController.update()

var ie_receipts_store = 'ie.receipts.store'; //uri: /ie/receipts/store -> App\Http\Controllers\IE\ReceiptController.store()

var ie_receipts_export = 'ie.receipts.export'; //uri: /ie/receipts/export -> App\Http\Controllers\IE\ReceiptController.export()

var ie_receipts_setStatus = 'ie.receipts.set_status'; //uri: /ie/receipts/set_status -> App\Http\Controllers\IE\ReceiptController.set_status()

var ie_receipts_addAttachment = 'ie.receipts.add_attachment'; //uri: /ie/receipts/{receipt}/add_attachment -> App\Http\Controllers\IE\ReceiptController.addAttachment()

var ie_receipts_formEdit = 'ie.receipts.form_edit'; //uri: /ie/receipts/{receipt}/form_edit -> App\Http\Controllers\IE\ReceiptController.formEdit()

var ie_receipts_duplicate = 'ie.receipts.duplicate'; //uri: /ie/receipts/{receipt}/duplicate -> App\Http\Controllers\IE\ReceiptController.duplicate()

var ie_receipts_remove = 'ie.receipts.remove'; //uri: /ie/receipts/{receipt}/remove -> App\Http\Controllers\IE\ReceiptController.remove()

var ie_receipts_lines_store = 'ie.receipts.lines.store'; //uri: /ie/receipts/{receipt}/lines/store -> App\Http\Controllers\IE\ReceiptLineController.store()

var ie_receipts_lines_update = 'ie.receipts.lines.update'; //uri: /ie/receipts/{receipt}/lines/{line}/update -> App\Http\Controllers\IE\ReceiptLineController.update()

var ie_receipts_lines_updateCoa = 'ie.receipts.lines.update_coa'; //uri: /ie/receipts/{receipt}/lines/{line}/update_coa -> App\Http\Controllers\IE\ReceiptLineController.updateCOA()

var ie_receipts_lines_updateDff = 'ie.receipts.lines.update_dff'; //uri: /ie/receipts/{receipt}/lines/{line}/update_dff -> App\Http\Controllers\IE\ReceiptLineController.updateDFF()

var ie_receipts_lines_duplicate = 'ie.receipts.lines.duplicate'; //uri: /ie/receipts/{receipt}/lines/{line}/duplicate -> App\Http\Controllers\IE\ReceiptLineController.duplicate()

var ie_receipts_lines_remove = 'ie.receipts.lines.remove'; //uri: /ie/receipts/{receipt}/lines/{line}/remove -> App\Http\Controllers\IE\ReceiptLineController.remove()

var ie_receipts_lines_getShowInfos = 'ie.receipts.lines.get_show_infos'; //uri: /ie/receipts/{receipt}/lines/{line}/get_show_infos -> App\Http\Controllers\IE\ReceiptLineController.getShowInfos()

var ie_receipts_lines_formCreate = 'ie.receipts.lines.form_create'; //uri: /ie/receipts/{receipt}/lines/form_create -> App\Http\Controllers\IE\ReceiptLineController.formCreate()

var ie_receipts_lines_getSubCategories = 'ie.receipts.lines.get_sub_categories'; //uri: /ie/receipts/{receipt}/lines/get_sub_categories -> App\Http\Controllers\IE\ReceiptLineController.getSubCategories()

var ie_receipts_lines_subCategory_getFormInformations = 'ie.receipts.lines.sub_category.get_form_informations'; //uri: /ie/receipts/{receipt}/lines/sub_category/{sub_category}/get_form_informations -> App\Http\Controllers\IE\ReceiptLineController.getInputFormInformations()

var ie_receipts_lines_subCategory_getFormAmount = 'ie.receipts.lines.sub_category.get_form_amount'; //uri: /ie/receipts/{receipt}/lines/sub_category/{sub_category}/get_form_amount -> App\Http\Controllers\IE\ReceiptLineController.getInputFormAmount()

var ie_receipts_lines_formCoa = 'ie.receipts.lines.form_coa'; //uri: /ie/receipts/{receipt}/lines/{line}/form_coa -> App\Http\Controllers\IE\ReceiptLineController.formCOA()

var ie_receipts_lines_inputCostCenterCode = 'ie.receipts.lines.input_cost_center_code'; //uri: /ie/receipts/{receipt}/lines/{line}/input_cost_center_code -> App\Http\Controllers\IE\Settings\SubCategoryController.inputCostCenterCode()

var ie_settings_inputCostCenterCode = 'ie.settings.input_cost_center_code'; //uri: /ie/receipts/{receipt}/lines/{line}/input_cost_center_code -> App\Http\Controllers\IE\Settings\SubCategoryController.inputCostCenterCode()

var ie_receipts_lines_inputBudgetDetailCode = 'ie.receipts.lines.input_budget_detail_code'; //uri: /ie/receipts/{receipt}/lines/{line}/input_budget_detail_code -> App\Http\Controllers\IE\Settings\SubCategoryController.inputBudgetDetailCode()

var ie_settings_inputBudgetDetailCode = 'ie.settings.input_budget_detail_code'; //uri: /ie/receipts/{receipt}/lines/{line}/input_budget_detail_code -> App\Http\Controllers\IE\Settings\SubCategoryController.inputBudgetDetailCode()

var ie_receipts_lines_inputSubAccountCode = 'ie.receipts.lines.input_sub_account_code'; //uri: /ie/receipts/{receipt}/lines/{line}/input_sub_account_code -> App\Http\Controllers\IE\Settings\SubCategoryController.inputSubAccountCode()

var ie_settings_inputSubAccountCode = 'ie.settings.input_sub_account_code'; //uri: /ie/settings/ca-categories/{ca_category}/ca_sub_categories/input_sub_account_code -> App\Http\Controllers\IE\Settings\CASubCategoryController.inputSubAccountCode()

var ie_receipts_lines_validateCombination = 'ie.receipts.lines.validate_combination'; //uri: /ie/receipts/{receipt}/lines/{line}/validate_combination -> App\Http\Controllers\IE\ReceiptLineController.validateCombination()

var ie_receipts_lines_formEdit = 'ie.receipts.lines.form_edit'; //uri: /ie/receipts/{receipt}/lines/{line}/form_edit -> App\Http\Controllers\IE\ReceiptLineController.formEdit()

var ie_receipts_lines_getFormEditInformations = 'ie.receipts.lines.get_form_edit_informations'; //uri: /ie/receipts/{receipt}/lines/{line}/get_form_edit_informations -> App\Http\Controllers\IE\ReceiptLineController.getInputFormEditInformations()

var ie_receipts_lines_getFormEditAmount = 'ie.receipts.lines.get_form_edit_amount'; //uri: /ie/receipts/{receipt}/lines/{line}/get_form_edit_amount -> App\Http\Controllers\IE\ReceiptLineController.getInputFormEditAmount()

var ie_dff_getForm = 'ie.dff.get_form'; //uri: /ie/dff/get_form -> App\Http\Controllers\IE\DFFController.getForm()

var ie_dff_getFormHeader = 'ie.dff.get_form_header'; //uri: /ie/dff/get_form_header -> App\Http\Controllers\IE\DFFController.getFormHeader()

var ie_dff_getFormLine = 'ie.dff.get_form_line'; //uri: /ie/dff/get_form_line -> App\Http\Controllers\IE\DFFController.getformLine()

var ie_attachments_download = 'ie.attachments.download'; //uri: /ie/attachments/{attachment_id}/download -> App\Http\Controllers\IE\AttachmentsController.download()

var ie_attachments_image = 'ie.attachments.image'; //uri: /ie/attachments/{attachment_id}/image -> App\Http\Controllers\IE\AttachmentsController.image()

var ie_attachments_imageModal = 'ie.attachments.image_modal'; //uri: /ie/attachments/{attachment_id}/image -> App\Http\Controllers\IE\AttachmentsController.image()

var ie_attachments_remove = 'ie.attachments.remove'; //uri: /ie/attachments/{attachment_id}/remove -> App\Http\Controllers\IE\AttachmentsController.remove()

var ie_settings_locations_index = 'ie.settings.locations.index'; //uri: /ie/settings/locations -> App\Http\Controllers\IE\Settings\LocationController.index()

var ie_settings_locations_create = 'ie.settings.locations.create'; //uri: /ie/settings/locations/create -> App\Http\Controllers\IE\Settings\LocationController.create()

var ie_settings_locations_edit = 'ie.settings.locations.edit'; //uri: /ie/settings/locations/{location}/edit -> App\Http\Controllers\IE\Settings\LocationController.edit()

var ie_settings_locations_update = 'ie.settings.locations.update'; //uri: /ie/settings/locations/{location} -> App\Http\Controllers\IE\Settings\LocationController.update()

var ie_settings_categories_index = 'ie.settings.categories.index'; //uri: /ie/settings/categories -> App\Http\Controllers\IE\Settings\CategoriesController.index()

var ie_settings_categories_create = 'ie.settings.categories.create'; //uri: /ie/settings/categories/create -> App\Http\Controllers\IE\Settings\CategoriesController.create()

var ie_settings_categories_store = 'ie.settings.categories.store'; //uri: /ie/settings/categories -> App\Http\Controllers\IE\Settings\CategoriesController.store()

var ie_settings_categories_edit = 'ie.settings.categories.edit'; //uri: /ie/settings/categories/{category}/edit -> App\Http\Controllers\IE\Settings\CategoriesController.edit()

var ie_settings_categories_update = 'ie.settings.categories.update'; //uri: /ie/settings/categories/{category} -> App\Http\Controllers\IE\Settings\CategoriesController.update()

var ie_settings_categories_remove = 'ie.settings.categories.remove'; //uri: /ie/settings/categories/{category}/remove -> App\Http\Controllers\IE\Settings\CategoriesController.remove()

var ie_settings_validateCombination = 'ie.settings.validate_combination'; //uri: /ie/settings/categories/{category}/sub_categories/validate_combination -> App\Http\Controllers\IE\Settings\SubCategoryController.validateCombination()

var ie_settings_formSetAccount = 'ie.settings.form_set_account'; //uri: /ie/settings/categories/{category}/sub_categories/form_set_account -> App\Http\Controllers\IE\Settings\SubCategoryController.formSetAccount()

var ie_settings_subCategories_index = 'ie.settings.sub-categories.index'; //uri: /ie/settings/categories/{category}/sub-categories -> App\Http\Controllers\IE\Settings\SubCategoryController.index()

var ie_settings_subCategories_create = 'ie.settings.sub-categories.create'; //uri: /ie/settings/categories/{category}/sub-categories/create -> App\Http\Controllers\IE\Settings\SubCategoryController.create()

var ie_settings_subCategories_store = 'ie.settings.sub-categories.store'; //uri: /ie/settings/categories/{category}/sub-categories -> App\Http\Controllers\IE\Settings\SubCategoryController.store()

var ie_settings_subCategories_show = 'ie.settings.sub-categories.show'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category} -> App\Http\Controllers\IE\Settings\SubCategoryController.show()

var ie_settings_subCategories_edit = 'ie.settings.sub-categories.edit'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/edit -> App\Http\Controllers\IE\Settings\SubCategoryController.edit()

var ie_settings_subCategories_update = 'ie.settings.sub-categories.update'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category} -> App\Http\Controllers\IE\Settings\SubCategoryController.update()

var ie_settings_subCategories_destroy = 'ie.settings.sub-categories.destroy'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category} -> App\Http\Controllers\IE\Settings\SubCategoryController.destroy()

var ie_settings_subCategories_infos_index = 'ie.settings.sub-categories.infos.index'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.index()

var ie_settings_subCategories_infos_create = 'ie.settings.sub-categories.infos.create'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos/create -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.create()

var ie_settings_subCategories_infos_store = 'ie.settings.sub-categories.infos.store'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.store()

var ie_settings_subCategories_infos_show = 'ie.settings.sub-categories.infos.show'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info} -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.show()

var ie_settings_subCategories_infos_edit = 'ie.settings.sub-categories.infos.edit'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}/edit -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.edit()

var ie_settings_subCategories_infos_update = 'ie.settings.sub-categories.infos.update'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info} -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.update()

var ie_settings_subCategories_infos_destroy = 'ie.settings.sub-categories.infos.destroy'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info} -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.destroy()

var ie_settings_subCategories_inputFormType = 'ie.settings.sub-categories.input_form_type'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/input_form_type/{input_form_type} -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.inputFormType()

var ie_settings_subCategories_infos_inactive = 'ie.settings.sub-categories.infos.inactive'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}/inactive -> App\Http\Controllers\IE\Settings\SubCategoryInfoController.inactive()

var ie_settings_policies_index = 'ie.settings.policies.index'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies -> App\Http\Controllers\IE\Settings\PolicyController.index()

var ie_settings_policies_create = 'ie.settings.policies.create'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/create -> App\Http\Controllers\IE\Settings\PolicyController.create()

var ie_settings_policies_store = 'ie.settings.policies.store'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies -> App\Http\Controllers\IE\Settings\PolicyController.store()

var ie_settings_policies_inactive = 'ie.settings.policies.inactive'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/inactive -> App\Http\Controllers\IE\Settings\PolicyController.inactive()

var ie_settings_policies_rates_index = 'ie.settings.policies.rates.index'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates -> App\Http\Controllers\IE\Settings\PolicyRateController.index()

var ie_settings_policies_rates_create = 'ie.settings.policies.rates.create'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/create -> App\Http\Controllers\IE\Settings\PolicyRateController.create()

var ie_settings_policies_rates_store = 'ie.settings.policies.rates.store'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates -> App\Http\Controllers\IE\Settings\PolicyRateController.store()

var ie_settings_policies_rates_show = 'ie.settings.policies.rates.show'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate} -> App\Http\Controllers\IE\Settings\PolicyRateController.show()

var ie_settings_policies_rates_edit = 'ie.settings.policies.rates.edit'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}/edit -> App\Http\Controllers\IE\Settings\PolicyRateController.edit()

var ie_settings_policies_rates_update = 'ie.settings.policies.rates.update'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate} -> App\Http\Controllers\IE\Settings\PolicyRateController.update()

var ie_settings_policies_rates_destroy = 'ie.settings.policies.rates.destroy'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate} -> App\Http\Controllers\IE\Settings\PolicyRateController.destroy()

var ie_settings_policies_rates_inactive = 'ie.settings.policies.rates.inactive'; //uri: /ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}/inactive -> App\Http\Controllers\IE\Settings\PolicyRateController.inactive()

var ie_settings_caCategories_index = 'ie.settings.ca-categories.index'; //uri: /ie/settings/ca-categories -> App\Http\Controllers\IE\Settings\CACategoriesController.index()

var ie_settings_caCategories_create = 'ie.settings.ca-categories.create'; //uri: /ie/settings/ca-categories/create -> App\Http\Controllers\IE\Settings\CACategoriesController.create()

var ie_settings_caCategories_store = 'ie.settings.ca-categories.store'; //uri: /ie/settings/ca-categories -> App\Http\Controllers\IE\Settings\CACategoriesController.store()

var ie_settings_caCategories_edit = 'ie.settings.ca-categories.edit'; //uri: /ie/settings/ca-categories/{ca_category}/edit -> App\Http\Controllers\IE\Settings\CACategoriesController.edit()

var ie_settings_caCategories_update = 'ie.settings.ca-categories.update'; //uri: /ie/settings/ca-categories/{ca_category} -> App\Http\Controllers\IE\Settings\CACategoriesController.update()

var ie_settings_caCategories_remove = 'ie.settings.ca-categories.remove'; //uri: /ie/settings/ca-categories/{ca_category}/remove -> App\Http\Controllers\IE\Settings\CACategoriesController.remove()

var ie_settings_caSubCategories_index = 'ie.settings.ca-sub-categories.index'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories -> App\Http\Controllers\IE\Settings\CASubCategoryController.index()

var ie_settings_caSubCategories_create = 'ie.settings.ca-sub-categories.create'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/create -> App\Http\Controllers\IE\Settings\CASubCategoryController.create()

var ie_settings_caSubCategories_store = 'ie.settings.ca-sub-categories.store'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories -> App\Http\Controllers\IE\Settings\CASubCategoryController.store()

var ie_settings_caSubCategories_show = 'ie.settings.ca-sub-categories.show'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category} -> App\Http\Controllers\IE\Settings\CASubCategoryController.show()

var ie_settings_caSubCategories_edit = 'ie.settings.ca-sub-categories.edit'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/edit -> App\Http\Controllers\IE\Settings\CASubCategoryController.edit()

var ie_settings_caSubCategories_update = 'ie.settings.ca-sub-categories.update'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category} -> App\Http\Controllers\IE\Settings\CASubCategoryController.update()

var ie_settings_caSubCategories_destroy = 'ie.settings.ca-sub-categories.destroy'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category} -> App\Http\Controllers\IE\Settings\CASubCategoryController.destroy()

var ie_settings_caSubCategories_infos_index = 'ie.settings.ca-sub-categories.infos.index'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.index()

var ie_settings_caSubCategories_infos_create = 'ie.settings.ca-sub-categories.infos.create'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/create -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.create()

var ie_settings_caSubCategories_infos_store = 'ie.settings.ca-sub-categories.infos.store'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.store()

var ie_settings_caSubCategories_infos_show = 'ie.settings.ca-sub-categories.infos.show'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info} -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.show()

var ie_settings_caSubCategories_infos_edit = 'ie.settings.ca-sub-categories.infos.edit'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}/edit -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.edit()

var ie_settings_caSubCategories_infos_update = 'ie.settings.ca-sub-categories.infos.update'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info} -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.update()

var ie_settings_caSubCategories_infos_destroy = 'ie.settings.ca-sub-categories.infos.destroy'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info} -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.destroy()

var ie_settings_caSubCategories_inputFormType = 'ie.settings.ca-sub-categories.input_form_type'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/input_form_type/{input_form_type} -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.inputFormType()

var ie_settings_caSubCategories_infos_inactive = 'ie.settings.ca-sub-categories.infos.inactive'; //uri: /ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}/inactive -> App\Http\Controllers\IE\Settings\CASubCategoryInfoController.inactive()

var ie_settings_preferences_index = 'ie.settings.preferences.index'; //uri: /ie/settings/preferences -> App\Http\Controllers\IE\Settings\PreferenceController.index()

var ie_settings_preferences_update = 'ie.settings.preferences.update'; //uri: /ie/settings/preferences/update -> App\Http\Controllers\IE\Settings\PreferenceController.update()

var ie_settings_preferences_updateMappingOus = 'ie.settings.preferences.update_mapping_ous'; //uri: /ie/settings/preferences/update_mapping_ous -> App\Http\Controllers\IE\Settings\PreferenceController.updateMappingOU()

var ie_settings_preferences_sliceJson = 'ie.settings.preferences.slice_json'; //uri: /ie/settings/preferences/slice_json -> App\Http\Controllers\IE\Settings\PreferenceController.sliceJson()

var ie_settings_userAccounts_index = 'ie.settings.user-accounts.index'; //uri: /ie/settings/user-accounts -> App\Http\Controllers\IE\Settings\UserAccountController.index()

var ie_settings_userAccounts_store = 'ie.settings.user-accounts.store'; //uri: /ie/settings/user-accounts -> App\Http\Controllers\IE\Settings\UserAccountController.store()

var ie_settings_userAccounts_update = 'ie.settings.user-accounts.update'; //uri: /ie/settings/user-accounts/{user_account} -> App\Http\Controllers\IE\Settings\UserAccountController.update()

var ie_settings_userAccounts_destroy = 'ie.settings.user-accounts.destroy'; //uri: /ie/settings/user-accounts/{user_account} -> App\Http\Controllers\IE\Settings\UserAccountController.destroy()

var ie_settings_userAccounts_formEdit = 'ie.settings.user-accounts.form_edit'; //uri: /ie/settings/user-accounts/{account_id}/form_edit -> App\Http\Controllers\IE\Settings\UserAccountController.formEdit()

var ie_settings_userAccounts_sync = 'ie.settings.user-accounts.sync'; //uri: /ie/settings/user-accounts/sync -> App\Http\Controllers\IE\Settings\UserAccountController.sync()

var ie_report_index = 'ie.report.index'; //uri: /ie/report/index -> App\Http\Controllers\IE\ReportController.index()

var ie_report_ctInvoice = 'ie.report.ct-invoice'; //uri: /ie/report/ct-invoice -> App\Http\Controllers\IE\ReportController.ctInvoice()

var ie_report_ctWht = 'ie.report.ct-wht'; //uri: /ie/report/ct-wht -> App\Http\Controllers\IE\ReportController.ctWHT()

var ie_report_request = 'ie.report.request'; //uri: /ie/report/{type}/request/{parent} -> App\Http\Controllers\IE\ReportController.request()

var inv_requisitionStationery_summaryWebStationeryPdf = 'inv.requisition_stationery.summary-web-stationery-pdf'; //uri: /inv/requisition_stationery/summary-web-stationery-pdf -> App\Http\Controllers\INV\RequisitionStationeryController.createSummaryWebStationeryPDF()

var inv_requisitionStationery_orderHistoryPdf = 'inv.requisition_stationery.order-history-pdf'; //uri: /inv/requisition_stationery/order-history-pdf -> App\Http\Controllers\INV\RequisitionStationeryController.createOrderHistoryPDF()

var inv_requisitionStationery_summaryWebStationeryReport = 'inv.requisition_stationery.summary-web-stationery-report'; //uri: /inv/requisition_stationery/summary-web-stationery-report -> App\Http\Controllers\INV\RequisitionStationeryController.summaryWebStationeryReport()

var inv_requisitionStationery_orderHistoryReport = 'inv.requisition_stationery.order-history-report'; //uri: /inv/requisition_stationery/order-history-report -> App\Http\Controllers\INV\RequisitionStationeryController.orderHistoryReport()

var inv_requisitionStationery_copy = 'inv.requisition_stationery.copy'; //uri: /inv/requisition_stationery/{id}/copy -> App\Http\Controllers\INV\RequisitionStationeryController.copy()

var inv_requisitionStationery_approve = 'inv.requisition_stationery.approve'; //uri: /inv/requisition_stationery/{id}/approve -> App\Http\Controllers\INV\RequisitionStationeryController.approve()

var inv_requisitionStationery_cancel = 'inv.requisition_stationery.cancel'; //uri: /inv/requisition_stationery/{id}/cancel -> App\Http\Controllers\INV\RequisitionStationeryController.cancel()

var inv_requisitionStationery_index = 'inv.requisition_stationery.index'; //uri: /inv/requisition_stationery -> App\Http\Controllers\INV\RequisitionStationeryController.index()

var inv_requisitionStationery_create = 'inv.requisition_stationery.create'; //uri: /inv/requisition_stationery/create -> App\Http\Controllers\INV\RequisitionStationeryController.create()

var inv_requisitionStationery_store = 'inv.requisition_stationery.store'; //uri: /inv/requisition_stationery -> App\Http\Controllers\INV\RequisitionStationeryController.store()

var inv_requisitionStationery_show = 'inv.requisition_stationery.show'; //uri: /inv/requisition_stationery/{requisition_stationery} -> App\Http\Controllers\INV\RequisitionStationeryController.show()

var inv_requisitionStationery_edit = 'inv.requisition_stationery.edit'; //uri: /inv/requisition_stationery/{requisition_stationery}/edit -> App\Http\Controllers\INV\RequisitionStationeryController.edit()

var inv_requisitionStationery_update = 'inv.requisition_stationery.update'; //uri: /inv/requisition_stationery/{requisition_stationery} -> App\Http\Controllers\INV\RequisitionStationeryController.update()

var inv_issueApproveDetail_index = 'inv.issue_approve_detail.index'; //uri: /inv/issue_approve_detail -> App\Http\Controllers\INV\IssueApproveDetailController.index()

var inv_issueApproveDetail_store = 'inv.issue_approve_detail.store'; //uri: /inv/issue_approve_detail -> App\Http\Controllers\INV\IssueApproveDetailController.store()

var inv_disbursementFuel_updateCarInterface = 'inv.disbursement_fuel.update-car-interface'; //uri: /inv/disbursement_fuel/update-car-interface -> App\Http\Controllers\INV\DisbursementFuelController.updateCarInfoInterface()

var inv_disbursementFuel_addNewCar = 'inv.disbursement_fuel.add_new_car'; //uri: /inv/disbursement_fuel/add_new_car -> App\Http\Controllers\INV\DisbursementFuelController.save()

var inv_disbursementFuel_report = 'inv.disbursement_fuel.report'; //uri: /inv/disbursement_fuel/report -> App\Http\Controllers\INV\DisbursementFuelController.report()

var inv_disbursementFuel_show = 'inv.disbursement_fuel.show'; //uri: /inv/disbursement_fuel/show -> App\Http\Controllers\INV\DisbursementFuelController.show()

var inv_disbursementFuel_index = 'inv.disbursement_fuel.index'; //uri: /inv/disbursement_fuel -> App\Http\Controllers\INV\DisbursementFuelController.index()

var inv_disbursementFuel_create = 'inv.disbursement_fuel.create'; //uri: /inv/disbursement_fuel/create -> App\Http\Controllers\INV\DisbursementFuelController.create()

var inv_disbursementFuel_store = 'inv.disbursement_fuel.store'; //uri: /inv/disbursement_fuel -> App\Http\Controllers\INV\DisbursementFuelController.store()

var inv_disbursementFuel_edit = 'inv.disbursement_fuel.edit'; //uri: /inv/disbursement_fuel/{disbursement_fuel}/edit -> App\Http\Controllers\INV\DisbursementFuelController.edit()

var inv_disbursementFuel_update = 'inv.disbursement_fuel.update'; //uri: /inv/disbursement_fuel/{disbursement_fuel} -> App\Http\Controllers\INV\DisbursementFuelController.update()

var inv_ajax_issueHeader = 'inv.ajax.issue_header'; //uri: /inv/ajax/issue_header -> App\Http\Controllers\INV\Ajax\PtinvIssueHeadersController.index()

var inv_ajax_issueProfileV = 'inv.ajax.issue_profile_V'; //uri: /inv/ajax/issue_profile_V -> App\Http\Controllers\INV\Ajax\PtinvIssueProfilesVController.index()

var inv_ajax_coaDeptCode = 'inv.ajax.coa_dept_code'; //uri: /inv/ajax/coa_dept_code -> App\Http\Controllers\INV\Ajax\PtglCoaDeptCodeVController.index()

var inv_ajax_subinventory = 'inv.ajax.subinventory'; //uri: /inv/ajax/subinventory -> App\Http\Controllers\INV\Ajax\PtirSubinventoryController.index()

var inv_ajax_secondaryInventories = 'inv.ajax.secondary_inventories'; //uri: /inv/ajax/secondary_inventories -> App\Http\Controllers\INV\Ajax\MtlSecondaryInventoriesController.index()

var inv_ajax_aliasName = 'inv.ajax.alias_name'; //uri: /inv/ajax/alias_name -> App\Http\Controllers\INV\Ajax\PtglAliasNameVController.index()

var inv_ajax_systemItem = 'inv.ajax.system_item'; //uri: /inv/ajax/system_item -> App\Http\Controllers\INV\Ajax\MtlSystemItemsBController.index()

var inv_ajax_carInfo = 'inv.ajax.car_info'; //uri: /inv/ajax/car_info -> App\Http\Controllers\INV\Ajax\PtinvCarInfoVController.index()

var inv_ajax_carHistory = 'inv.ajax.car_history'; //uri: /inv/ajax/car_history -> App\Http\Controllers\INV\Ajax\PtinvCarHistoryVController.index()

var inv_ajax_glCodeCombinations = 'inv.ajax.gl_code_combinations'; //uri: /inv/ajax/gl_code_combinations -> App\Http\Controllers\INV\Ajax\GlCodeCombinationsKfvController.index()

var inv_ajax_webFuelDist = 'inv.ajax.web_fuel_dist'; //uri: /inv/ajax/web_fuel_dist -> App\Http\Controllers\INV\Ajax\PtinvWebFuelDistController.index()

var inv_ajax_webFuelOil = 'inv.ajax.web_fuel_oil'; //uri: /inv/ajax/web_fuel_oil -> App\Http\Controllers\INV\Ajax\PtinvWebFuelOilController.index()

var inv_ajax_itemLocations = 'inv.ajax.item_locations'; //uri: /inv/ajax/item_locations -> App\Http\Controllers\INV\Ajax\MtlItemLocationsController.index()

var inv_ajax_carTypes = 'inv.ajax.car_types'; //uri: /inv/ajax/car_types -> App\Http\Controllers\INV\Ajax\ToatInvCarTypeController.index()

var inv_ajax_carBrands = 'inv.ajax.car_brands'; //uri: /inv/ajax/car_brands -> App\Http\Controllers\INV\Ajax\ToatFaBrandController.index()

var inv_ajax_carFuels = 'inv.ajax.car_fuels'; //uri: /inv/ajax/car_fuels -> App\Http\Controllers\INV\Ajax\ToatInvFuelController.index()

var inv_ajax_employees = 'inv.ajax.employees'; //uri: /inv/ajax/employees -> App\Http\Controllers\INV\Ajax\PerPeopleFController.index()

var inv_ajax_lookupTypes = 'inv.ajax.lookup_types'; //uri: /inv/ajax/lookup_types -> App\Http\Controllers\INV\Ajax\FndLookupTypesController.index()

var inv_ajax_lookupValues = 'inv.ajax.lookup_values'; //uri: /inv/ajax/lookup_values -> App\Http\Controllers\INV\Ajax\FndLookupValuesController.index()

var inv_ajax_organizationUnits = 'inv.ajax.organization_units'; //uri: /inv/ajax/organization_units -> App\Http\Controllers\INV\Ajax\HrOrganizationUnitController.index()

var inv_ajax_poDistributionsAll = 'inv.ajax.po_distributions_all'; //uri: /inv/ajax/po_distributions_all -> App\Http\Controllers\INV\Ajax\PoDistributionsAllController.index()

var inv_ajax_poHeadersAll = 'inv.ajax.po_headers_all'; //uri: /inv/ajax/po_headers_all -> App\Http\Controllers\INV\Ajax\PoHeadersAllController.index()

var inv_ajax_poLinesAll = 'inv.ajax.po_lines_all'; //uri: /inv/ajax/po_lines_all -> App\Http\Controllers\INV\Ajax\PoLinesAllController.index()

var inv_ajax_lotOnhands = 'inv.ajax.lot_onhands'; //uri: /inv/ajax/lot_onhands -> App\Http\Controllers\INV\Ajax\MtlLotOnhandSumVController.index()

var qm_api_settings_specifications_store = 'qm.api.settings.specifications.store'; //uri: /qm/api/settings/specifications -> App\Http\Controllers\QM\Api\Settings\SpecificationController.store()

var qm_settings_checkPointsTobaccoLeaf_index = 'qm.settings.check-points-tobacco-leaf.index'; //uri: /qm/settings/check-points-tobacco-leaf -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoLeafController.index()

var qm_settings_checkPointsTobaccoLeaf_create = 'qm.settings.check-points-tobacco-leaf.create'; //uri: /qm/settings/check-points-tobacco-leaf/create -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoLeafController.create()

var qm_settings_checkPointsTobaccoLeaf_store = 'qm.settings.check-points-tobacco-leaf.store'; //uri: /qm/settings/check-points-tobacco-leaf/store -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoLeafController.store()

var qm_settings_checkPointsTobaccoLeaf_update = 'qm.settings.check-points-tobacco-leaf.update'; //uri: /qm/settings/check-points-tobacco-leaf/update -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoLeafController.update()

var qm_settings_checkPointsTobaccoLeaf_edit = 'qm.settings.check-points-tobacco-leaf.edit'; //uri: /qm/settings/check-points-tobacco-leaf/{id}/edit -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoLeafController.edit()

var qm_settings_checkPointsTobaccoBeetle_index = 'qm.settings.check-points-tobacco-beetle.index'; //uri: /qm/settings/check-points-tobacco-beetle -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoBeetleController.index()

var qm_settings_checkPointsTobaccoBeetle_create = 'qm.settings.check-points-tobacco-beetle.create'; //uri: /qm/settings/check-points-tobacco-beetle/create -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoBeetleController.create()

var qm_settings_checkPointsTobaccoBeetle_store = 'qm.settings.check-points-tobacco-beetle.store'; //uri: /qm/settings/check-points-tobacco-beetle/store -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoBeetleController.store()

var qm_settings_checkPointsTobaccoBeetle_edit = 'qm.settings.check-points-tobacco-beetle.edit'; //uri: /qm/settings/check-points-tobacco-beetle/{id}/edit -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoBeetleController.edit()

var qm_settings_checkPointsTobaccoBeetle_update = 'qm.settings.check-points-tobacco-beetle.update'; //uri: /qm/settings/check-points-tobacco-beetle/update -> App\Http\Controllers\QM\Settings\CheckPointsTobaccoBeetleController.update()

var qm_settings_attachments_download = 'qm.settings.attachments.download'; //uri: /qm/settings/attachments/{attachment}/download -> App\Http\Controllers\QM\Settings\AttachmentController.download()

var qm_settings_attachments_image = 'qm.settings.attachments.image'; //uri: /qm/settings/attachments/{attachment}/image -> App\Http\Controllers\QM\Settings\AttachmentController.image()

var qm_settings_testUnit_index = 'qm.settings.test-unit.index'; //uri: /qm/settings/test-unit -> App\Http\Controllers\QM\Settings\TestUnitController.index()

var qm_settings_testUnit_create = 'qm.settings.test-unit.create'; //uri: /qm/settings/test-unit/create -> App\Http\Controllers\QM\Settings\TestUnitController.create()

var qm_settings_testUnit_edit = 'qm.settings.test-unit.edit'; //uri: /qm/settings/test-unit/{qcunit_code}/edit -> App\Http\Controllers\QM\Settings\TestUnitController.edit()

var qm_settings_testUnit_store = 'qm.settings.test-unit.store'; //uri: /qm/settings/test-unit/store -> App\Http\Controllers\QM\Settings\TestUnitController.store()

var qm_settings_testUnit_update = 'qm.settings.test-unit.update'; //uri: /qm/settings/test-unit/update -> App\Http\Controllers\QM\Settings\TestUnitController.update()

var qm_settings_qcArea_index = 'qm.settings.qc-area.index'; //uri: /qm/settings/qc-area -> App\Http\Controllers\QM\Settings\QcAreaController.index()

var qm_settings_qcArea_update = 'qm.settings.qc-area.update'; //uri: /qm/settings/qc-area/update -> App\Http\Controllers\QM\Settings\QcAreaController.update()

var qm_settings_defineTestsTobaccoLeaf_index = 'qm.settings.define-tests-tobacco-leaf.index'; //uri: /qm/settings/define-tests-tobacco-leaf -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoLeafController.index()

var qm_settings_defineTestsTobaccoLeaf_create = 'qm.settings.define-tests-tobacco-leaf.create'; //uri: /qm/settings/define-tests-tobacco-leaf/create -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoLeafController.create()

var qm_settings_defineTestsTobaccoLeaf_store = 'qm.settings.define-tests-tobacco-leaf.store'; //uri: /qm/settings/define-tests-tobacco-leaf/store -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoLeafController.store()

var qm_settings_defineTestsTobaccoLeaf_update = 'qm.settings.define-tests-tobacco-leaf.update'; //uri: /qm/settings/define-tests-tobacco-leaf/update -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoLeafController.update()

var qm_settings_defineTestsTobaccoBeetle_index = 'qm.settings.define-tests-tobacco-beetle.index'; //uri: /qm/settings/define-tests-tobacco-beetle -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoBeetleController.index()

var qm_settings_defineTestsTobaccoBeetle_create = 'qm.settings.define-tests-tobacco-beetle.create'; //uri: /qm/settings/define-tests-tobacco-beetle/create -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoBeetleController.create()

var qm_settings_defineTestsTobaccoBeetle_store = 'qm.settings.define-tests-tobacco-beetle.store'; //uri: /qm/settings/define-tests-tobacco-beetle/store -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoBeetleController.store()

var qm_settings_defineTestsTobaccoBeetle_update = 'qm.settings.define-tests-tobacco-beetle.update'; //uri: /qm/settings/define-tests-tobacco-beetle/update -> App\Http\Controllers\QM\Settings\DefineTestsTobaccoBeetleController.update()

var qm_settings_defineTestsFinishedProducts_index = 'qm.settings.define-tests-finished-products.index'; //uri: /qm/settings/define-tests-finished-products -> App\Http\Controllers\QM\Settings\DefineTestsFinishedProductsController.index()

var qm_settings_defineTestsFinishedProducts_create = 'qm.settings.define-tests-finished-products.create'; //uri: /qm/settings/define-tests-finished-products/create -> App\Http\Controllers\QM\Settings\DefineTestsFinishedProductsController.create()

var qm_settings_defineTestsFinishedProducts_store = 'qm.settings.define-tests-finished-products.store'; //uri: /qm/settings/define-tests-finished-products/store -> App\Http\Controllers\QM\Settings\DefineTestsFinishedProductsController.store()

var qm_settings_defineTestsFinishedProducts_update = 'qm.settings.define-tests-finished-products.update'; //uri: /qm/settings/define-tests-finished-products/update -> App\Http\Controllers\QM\Settings\DefineTestsFinishedProductsController.update()

var qm_settings_defineTestsQtmMachines_index = 'qm.settings.define-tests-qtm-machines.index'; //uri: /qm/settings/define-tests-qtm-machines -> App\Http\Controllers\QM\Settings\DefineTestsQTMMachinesController.index()

var qm_settings_defineTestsQtmMachines_create = 'qm.settings.define-tests-qtm-machines.create'; //uri: /qm/settings/define-tests-qtm-machines/create -> App\Http\Controllers\QM\Settings\DefineTestsQTMMachinesController.create()

var qm_settings_defineTestsQtmMachines_store = 'qm.settings.define-tests-qtm-machines.store'; //uri: /qm/settings/define-tests-qtm-machines/store -> App\Http\Controllers\QM\Settings\DefineTestsQTMMachinesController.store()

var qm_settings_defineTestsQtmMachines_update = 'qm.settings.define-tests-qtm-machines.update'; //uri: /qm/settings/define-tests-qtm-machines/update -> App\Http\Controllers\QM\Settings\DefineTestsQTMMachinesController.update()

var qm_settings_defineTestsPacketAirLeaks_index = 'qm.settings.define-tests-packet-air-leaks.index'; //uri: /qm/settings/define-tests-packet-air-leaks -> App\Http\Controllers\QM\Settings\DefineTestsPacketAirLeaksController.index()

var qm_settings_defineTestsPacketAirLeaks_create = 'qm.settings.define-tests-packet-air-leaks.create'; //uri: /qm/settings/define-tests-packet-air-leaks/create -> App\Http\Controllers\QM\Settings\DefineTestsPacketAirLeaksController.create()

var qm_settings_defineTestsPacketAirLeaks_store = 'qm.settings.define-tests-packet-air-leaks.store'; //uri: /qm/settings/define-tests-packet-air-leaks/store -> App\Http\Controllers\QM\Settings\DefineTestsPacketAirLeaksController.store()

var qm_settings_defineTestsPacketAirLeaks_update = 'qm.settings.define-tests-packet-air-leaks.update'; //uri: /qm/settings/define-tests-packet-air-leaks/update -> App\Http\Controllers\QM\Settings\DefineTestsPacketAirLeaksController.update()

var qm_settings_specifications_index = 'qm.settings.specifications.index'; //uri: /qm/settings/specifications -> App\Http\Controllers\QM\Settings\SpecificationController.index()

var qm_ajax_tobaccos_getSampleSpecifications = 'qm.ajax.tobaccos.get-sample-specifications'; //uri: /qm/ajax/tobaccos/get-sample-specifications -> App\Http\Controllers\QM\Api\TobaccoController.getSampleSpecifications()

var qm_ajax_tobaccos_storeSampleResult = 'qm.ajax.tobaccos.store-sample-result'; //uri: /qm/ajax/tobaccos/result -> App\Http\Controllers\QM\Api\TobaccoController.storeSampleResult()

var qm_ajax_finishedProducts_getSampleSpecifications = 'qm.ajax.finished-products.get-sample-specifications'; //uri: /qm/ajax/finished-products/get-sample-specifications -> App\Http\Controllers\QM\Api\FinishedProductController.getSampleSpecifications()

var qm_ajax_finishedProducts_storeSampleResult = 'qm.ajax.finished-products.store-sample-result'; //uri: /qm/ajax/finished-products/result -> App\Http\Controllers\QM\Api\FinishedProductController.storeSampleResult()

var qm_ajax_qtmMachines_getSampleSpecifications = 'qm.ajax.qtm-machines.get-sample-specifications'; //uri: /qm/ajax/qtm-machines/get-sample-specifications -> App\Http\Controllers\QM\Api\QtmMachineController.getSampleSpecifications()

var qm_ajax_qtmMachines_storeSampleResult = 'qm.ajax.qtm-machines.store-sample-result'; //uri: /qm/ajax/qtm-machines/result -> App\Http\Controllers\QM\Api\QtmMachineController.storeSampleResult()

var qm_ajax_packetAirLeaks_getSampleSpecifications = 'qm.ajax.packet-air-leaks.get-sample-specifications'; //uri: /qm/ajax/packet-air-leaks/get-sample-specifications -> App\Http\Controllers\QM\Api\PacketAirLeakController.getSampleSpecifications()

var qm_ajax_packetAirLeaks_storeSampleResult = 'qm.ajax.packet-air-leaks.store-sample-result'; //uri: /qm/ajax/packet-air-leaks/result -> App\Http\Controllers\QM\Api\PacketAirLeakController.storeSampleResult()

var qm_ajax_mothOutbreaks_getSampleSpecifications = 'qm.ajax.moth-outbreaks.get-sample-specifications'; //uri: /qm/ajax/moth-outbreaks/get-sample-specifications -> App\Http\Controllers\QM\Api\MothOutbreakController.getSampleSpecifications()

var qm_ajax_mothOutbreaks_storeSampleResult = 'qm.ajax.moth-outbreaks.store-sample-result'; //uri: /qm/ajax/moth-outbreaks/result -> App\Http\Controllers\QM\Api\MothOutbreakController.storeSampleResult()

var qm_ajax_mothOutbreaks_uploadExcelFile = 'qm.ajax.moth-outbreaks.upload-excel-file'; //uri: /qm/ajax/moth-outbreaks/upload-excel-file -> App\Http\Controllers\QM\Api\MothOutbreakController.uploadExcelFile()

var qm_tobaccos_create = 'qm.tobaccos.create'; //uri: /qm/tobaccos/create -> App\Http\Controllers\QM\TobaccoController.create()

var qm_tobaccos_result = 'qm.tobaccos.result'; //uri: /qm/tobaccos/result -> App\Http\Controllers\QM\TobaccoController.result()

var qm_tobaccos_reportSummary = 'qm.tobaccos.report-summary'; //uri: /qm/tobaccos/report-summary -> App\Http\Controllers\QM\TobaccoController.reportSummary()

var qm_tobaccos_exportExcel_reportSummary = 'qm.tobaccos.export-excel.report-summary'; //uri: /qm/tobaccos/export-excel/report-summary -> App\Http\Controllers\QM\TobaccoController.exportExcelReportSummary()

var qm_tobaccos_store = 'qm.tobaccos.store'; //uri: /qm/tobaccos -> App\Http\Controllers\QM\TobaccoController.store()

var qm_finishedProducts_create = 'qm.finished-products.create'; //uri: /qm/finished-products/create -> App\Http\Controllers\QM\FinishedProductController.create()

var qm_finishedProducts_result = 'qm.finished-products.result'; //uri: /qm/finished-products/result -> App\Http\Controllers\QM\FinishedProductController.result()

var qm_finishedProducts_track = 'qm.finished-products.track'; //uri: /qm/finished-products/track -> App\Http\Controllers\QM\FinishedProductController.track()

var qm_finishedProducts_reportSummary = 'qm.finished-products.report-summary'; //uri: /qm/finished-products/report-summary -> App\Http\Controllers\QM\FinishedProductController.reportSummary()

var qm_finishedProducts_reportIssue = 'qm.finished-products.report-issue'; //uri: /qm/finished-products/report-issue -> App\Http\Controllers\QM\FinishedProductController.reportIssue()

var qm_finishedProducts_exportExcel_reportSummary = 'qm.finished-products.export-excel.report-summary'; //uri: /qm/finished-products/export-excel/report-summary -> App\Http\Controllers\QM\FinishedProductController.exportExcelReportSummary()

var qm_finishedProducts_exportExcel_reportIssue = 'qm.finished-products.export-excel.report-issue'; //uri: /qm/finished-products/export-excel/report-issue -> App\Http\Controllers\QM\FinishedProductController.exportExcelReportIssue()

var qm_finishedProducts_store = 'qm.finished-products.store'; //uri: /qm/finished-products -> App\Http\Controllers\QM\FinishedProductController.store()

var qm_finishedProducts_storeResult = 'qm.finished-products.store-result'; //uri: /qm/finished-products/result -> App\Http\Controllers\QM\FinishedProductController.storeResult()

var qm_qtmMachines_create = 'qm.qtm-machines.create'; //uri: /qm/qtm-machines/create -> App\Http\Controllers\QM\QtmMachineController.create()

var qm_qtmMachines_result = 'qm.qtm-machines.result'; //uri: /qm/qtm-machines/result -> App\Http\Controllers\QM\QtmMachineController.result()

var qm_qtmMachines_track = 'qm.qtm-machines.track'; //uri: /qm/qtm-machines/track -> App\Http\Controllers\QM\QtmMachineController.track()

var qm_qtmMachines_reportSummary = 'qm.qtm-machines.report-summary'; //uri: /qm/qtm-machines/report-summary -> App\Http\Controllers\QM\QtmMachineController.reportSummary()

var qm_qtmMachines_reportUnderAverage = 'qm.qtm-machines.report-under-average'; //uri: /qm/qtm-machines/report-under-average -> App\Http\Controllers\QM\QtmMachineController.reportUnderAverage()

var qm_qtmMachines_reportProductQuality = 'qm.qtm-machines.report-product-quality'; //uri: /qm/qtm-machines/report-product-quality -> App\Http\Controllers\QM\QtmMachineController.reportProductQuality()

var qm_qtmMachines_reportPhysicalValue = 'qm.qtm-machines.report-physical-value'; //uri: /qm/qtm-machines/report-physical-value -> App\Http\Controllers\QM\QtmMachineController.reportPhysicalValue()

var qm_qtmMachines_exportExcel_reportUnderAverage = 'qm.qtm-machines.export-excel.report-under-average'; //uri: /qm/qtm-machines/export-excel/report-under-average -> App\Http\Controllers\QM\QtmMachineController.exportExcelReportUnderAverage()

var qm_qtmMachines_exportExcel_reportProductQuality = 'qm.qtm-machines.export-excel.report-product-quality'; //uri: /qm/qtm-machines/export-excel/report-product-quality -> App\Http\Controllers\QM\QtmMachineController.exportExcelReportProductQuality()

var qm_qtmMachines_exportExcel_reportPhysicalValue = 'qm.qtm-machines.export-excel.report-physical-value'; //uri: /qm/qtm-machines/export-excel/report-physical-value -> App\Http\Controllers\QM\QtmMachineController.exportExcelReportPhysicalValue()

var qm_qtmMachines_store = 'qm.qtm-machines.store'; //uri: /qm/qtm-machines -> App\Http\Controllers\QM\QtmMachineController.store()

var qm_qtmMachines_storeResult = 'qm.qtm-machines.store-result'; //uri: /qm/qtm-machines/result -> App\Http\Controllers\QM\QtmMachineController.storeResult()

var qm_packetAirLeaks_create = 'qm.packet-air-leaks.create'; //uri: /qm/packet-air-leaks/create -> App\Http\Controllers\QM\PacketAirLeakController.create()

var qm_packetAirLeaks_result = 'qm.packet-air-leaks.result'; //uri: /qm/packet-air-leaks/result -> App\Http\Controllers\QM\PacketAirLeakController.result()

var qm_packetAirLeaks_track = 'qm.packet-air-leaks.track'; //uri: /qm/packet-air-leaks/track -> App\Http\Controllers\QM\PacketAirLeakController.track()

var qm_packetAirLeaks_reportSummary = 'qm.packet-air-leaks.report-summary'; //uri: /qm/packet-air-leaks/report-summary -> App\Http\Controllers\QM\PacketAirLeakController.reportSummary()

var qm_packetAirLeaks_reportLeakRate = 'qm.packet-air-leaks.report-leak-rate'; //uri: /qm/packet-air-leaks/report-leak-rate -> App\Http\Controllers\QM\PacketAirLeakController.reportLeakRate()

var qm_packetAirLeaks_exportExcel_reportSummary = 'qm.packet-air-leaks.export-excel.report-summary'; //uri: /qm/packet-air-leaks/export-excel/report-summary -> App\Http\Controllers\QM\PacketAirLeakController.exportExcelReportSummary()

var qm_packetAirLeaks_exportExcel_reportLeakRate = 'qm.packet-air-leaks.export-excel.report-leak-rate'; //uri: /qm/packet-air-leaks/export-excel/report-leak-rate -> App\Http\Controllers\QM\PacketAirLeakController.exportExcelReportLeakRate()

var qm_packetAirLeaks_store = 'qm.packet-air-leaks.store'; //uri: /qm/packet-air-leaks -> App\Http\Controllers\QM\PacketAirLeakController.store()

var qm_packetAirLeaks_storeResult = 'qm.packet-air-leaks.store-result'; //uri: /qm/packet-air-leaks/result -> App\Http\Controllers\QM\PacketAirLeakController.storeResult()

var qm_mothOutbreaks_create = 'qm.moth-outbreaks.create'; //uri: /qm/moth-outbreaks/create -> App\Http\Controllers\QM\MothOutbreakController.create()

var qm_mothOutbreaks_result = 'qm.moth-outbreaks.result'; //uri: /qm/moth-outbreaks/result -> App\Http\Controllers\QM\MothOutbreakController.result()

var qm_mothOutbreaks_track = 'qm.moth-outbreaks.track'; //uri: /qm/moth-outbreaks/track -> App\Http\Controllers\QM\MothOutbreakController.track()

var qm_mothOutbreaks_reportSummary = 'qm.moth-outbreaks.report-summary'; //uri: /qm/moth-outbreaks/report-summary -> App\Http\Controllers\QM\MothOutbreakController.reportSummary()

var qm_mothOutbreaks_exportExcel_reportSummary = 'qm.moth-outbreaks.export-excel.report-summary'; //uri: /qm/moth-outbreaks/export-excel/report-summary -> App\Http\Controllers\QM\MothOutbreakController.exportExcelReportSummary()

var qm_mothOutbreaks_store = 'qm.moth-outbreaks.store'; //uri: /qm/moth-outbreaks -> App\Http\Controllers\QM\MothOutbreakController.store()

var qm_mothOutbreaks_storeResult = 'qm.moth-outbreaks.store-result'; //uri: /qm/moth-outbreaks/result -> App\Http\Controllers\QM\MothOutbreakController.storeResult()

var qm_files_image = 'qm.files.image'; //uri: /qm/files/image/{module}/{menu}/{feature}/{fileName} -> App\Http\Controllers\QM\FileController.image()

var qm_files_imageThumbnail = 'qm.files.image-thumbnail'; //uri: /qm/files/image-thumbnail/{module}/{menu}/{feature}/{fileName} -> App\Http\Controllers\QM\FileController.imageThumbnail()

var qm_files_download = 'qm.files.download'; //uri: /qm/files/download/{module}/{menu}/{feature}/{fileType}/{fileName} -> App\Http\Controllers\QM\FileController.download()

var planning_machineYearly_index = 'planning.machine-yearly.index'; //uri: /planning/machine-yearly -> App\Http\Controllers\Planning\MachineYearlyController.index()

var planning_machineYearly_store = 'planning.machine-yearly.store'; //uri: /planning/machine-yearly -> App\Http\Controllers\Planning\MachineYearlyController.store()

var planning_machineYearly_update = 'planning.machine-yearly.update'; //uri: /planning/machine-yearly/{id}/update -> App\Http\Controllers\Planning\MachineYearlyController.update()

var planning_machineYearly_updateLines = 'planning.machine-yearly.update-lines'; //uri: /planning/machine-yearly/{id}/update-lines -> App\Http\Controllers\Planning\MachineYearlyController.updateLine()

var planning_machineYearly_machineDetail = 'planning.machine-yearly.machine-detail'; //uri: /planning/machine-detail -> App\Http\Controllers\Planning\MachineYearlyController.machineDetail()

var planning_machineYearly_updatePlanPmYearly = 'planning.machine-yearly.update_plan_pm_yearly'; //uri: /planning/update_plan_pm_yearly -> App\Http\Controllers\Planning\MachineYearlyController.UpdateEAMChangePm()

var planning_machineYearly_downtime = 'planning.machine-yearly.downtime'; //uri: /planning/machine-downtime-yearly -> App\Http\Controllers\Planning\MachineYearlyController.machinedDowntime()

var planning_machineBiweekly_index = 'planning.machine-biweekly.index'; //uri: /planning/machine-biweekly -> App\Http\Controllers\Planning\MachineBiWeeklyController.index()

var planning_machineBiweekly_store = 'planning.machine-biweekly.store'; //uri: /planning/machine-biweekly -> App\Http\Controllers\Planning\MachineBiWeeklyController.store()

var planning_machineBiweekly_update = 'planning.machine-biweekly.update'; //uri: /planning/machine-biweekly/{id}/update -> App\Http\Controllers\Planning\MachineBiWeeklyController.update()

var planning_machineBiweekly_updateLines = 'planning.machine-biweekly.update-lines'; //uri: /planning/machine-biweekly/{id}/update-lines -> App\Http\Controllers\Planning\MachineBiWeeklyController.updateLine()

var planning_machineBiweekly_updatePlanPmBiweekly = 'planning.machine-biweekly.update_plan_pm_biweekly'; //uri: /planning/update_plan_pm_biweekly -> App\Http\Controllers\Planning\MachineBiWeeklyController.UpdateEAMChangePm()

var planning_machineBiweekly_downtime = 'planning.machine-biweekly.downtime'; //uri: /planning/machine-downtime-biweekly -> App\Http\Controllers\Planning\MachineBiWeeklyController.machinedDowntime()

var planning_productionBiweekly_index = 'planning.production-biweekly.index'; //uri: /planning/production-biweekly -> App\Http\Controllers\Planning\ProductBiWeeklyController.index()

var planning_productionBiweekly_show = 'planning.production-biweekly.show'; //uri: /planning/production-biweekly/{production_biweekly} -> App\Http\Controllers\Planning\ProductBiWeeklyController.show()

var planning_adjusts_store = 'planning.adjusts.store'; //uri: /planning/adjusts -> App\Http\Controllers\Planning\AdjustController.store()

var planning_adjusts_show = 'planning.adjusts.show'; //uri: /planning/adjusts/{adjust} -> App\Http\Controllers\Planning\AdjustController.show()

var planning_followUps_index = 'planning.follow-ups.index'; //uri: /planning/follow-ups -> App\Http\Controllers\Planning\FollowUpController.index()

var planning_productionDaily_show = 'planning.production-daily.show'; //uri: /planning/production-daily/{id} -> App\Http\Controllers\Planning\ProductionDailyController.show()

var planning_stampMonthly_index = 'planning.stamp-monthly.index'; //uri: /planning/stamp-monthly -> App\Http\Controllers\Planning\StampMonthlyController.index()

var planning_stampFollow = 'planning.stamp-follow'; //uri: /planning/stamp-follow -> App\Http\Controllers\Planning\StampFollowController.index()

var planning_stampFollow_export = 'planning.stamp-follow.export'; //uri: /planning/stamp-follow/{stampFollowMain}/export -> App\Http\Controllers\Planning\StampFollowController.exportFollowStamp()

var planning_ajax_ = 'planning.ajax.'; //uri: /planning/ajax/get-biWeekly-machine -> App\Http\Controllers\Planning\Ajax\MachineController.findBiWeeklyMachine()

var planning_ajax_biWeekly_ = 'planning.ajax.biWeekly.'; //uri: /planning/ajax/biWeekly/get-plan-machine -> App\Http\Controllers\Planning\Ajax\ProductionPlanController.getPlanMachine()

var planning_ajax_biWeekly_prod_getEstData = 'planning.ajax.biWeekly.prod.get-est-data'; //uri: /planning/ajax/biWeekly/get-est-data -> App\Http\Controllers\Planning\Ajax\ProductionPlanController.getEstData()

var planning_ajax_biWeekly_prod_getAvgData = 'planning.ajax.biWeekly.prod.get-avg-data'; //uri: /planning/ajax/biWeekly/get-avg-data -> App\Http\Controllers\Planning\Ajax\ProductionPlanController.getAvgData()

var planning_ajax_productionBiweekly_modalCreateDetails = 'planning.ajax.production-biweekly.modal-create-details'; //uri: /planning/ajax/production-biweekly/modal-create-details -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.modalCreateDetail()

var planning_ajax_productionBiweekly_search = 'planning.ajax.production-biweekly.search'; //uri: /planning/ajax/production-biweekly/search -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.search()

var planning_ajax_productionBiweekly_store = 'planning.ajax.production-biweekly.store'; //uri: /planning/ajax/production-biweekly -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.store()

var planning_ajax_productionBiweekly_update = 'planning.ajax.production-biweekly.update'; //uri: /planning/ajax/production-biweekly/{productionBiweeklyMain} -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.update()

var planning_ajax_productionBiweekly_approve = 'planning.ajax.production-biweekly.approve'; //uri: /planning/ajax/production-biweekly/approve/{productionBiweeklyMain} -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.approve()

var planning_ajax_productionBiweekly_checkApprove = 'planning.ajax.production-biweekly.check-approve'; //uri: /planning/ajax/production-biweekly/check-approve/{productionBiweeklyMain} -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.checkApprove()

var planning_ajax_productionBiweekly_getPlanMachine = 'planning.ajax.production-biweekly.get-plan-machine'; //uri: /planning/ajax/production-biweekly/get-plan-machine -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.getPlanMachine()

var planning_ajax_productionBiweekly_getEstData = 'planning.ajax.production-biweekly.get-est-data'; //uri: /planning/ajax/production-biweekly/get-est-data -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.getEstData()

var planning_ajax_productionBiweekly_getAvgData = 'planning.ajax.production-biweekly.get-avg-data'; //uri: /planning/ajax/production-biweekly/get-avg-data -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.getAvgData()

var planning_ajax_productionBiweekly_getEstByBiweekly = 'planning.ajax.production-biweekly.get-est-by-biweekly'; //uri: /planning/ajax/production-biweekly/get-est-by-biweekly -> App\Http\Controllers\Planning\Ajax\ProductBiWeeklyController.getEstByBiweekly()

var planning_ajax_adjusts_search = 'planning.ajax.adjusts.search'; //uri: /planning/ajax/adjusts/search -> App\Http\Controllers\Planning\Ajax\AdjustController.search()

var planning_ajax_adjusts_searchCreate = 'planning.ajax.adjusts.search-create'; //uri: /planning/ajax/adjusts/search-create -> App\Http\Controllers\Planning\Ajax\AdjustController.searchCreate()

var planning_ajax_adjusts_searchItem = 'planning.ajax.adjusts.search-item'; //uri: /planning/ajax/adjusts/search-item -> App\Http\Controllers\Planning\Ajax\AdjustController.searchItem()

var planning_ajax_adjusts_update = 'planning.ajax.adjusts.update'; //uri: /planning/ajax/adjusts/{productionBiweeklyMain} -> App\Http\Controllers\Planning\Ajax\AdjustController.update()

var planning_ajax_adjusts_updateNote = 'planning.ajax.adjusts.update-note'; //uri: /planning/ajax/adjusts/update-note/{id} -> App\Http\Controllers\Planning\Ajax\AdjustController.updateNote()

var planning_ajax_adjusts_getAdjData = 'planning.ajax.adjusts.get-adj-data'; //uri: /planning/ajax/adjusts/get-adj-data -> App\Http\Controllers\Planning\Ajax\AdjustController.getAdjData()

var planning_ajax_adjusts_approve = 'planning.ajax.adjusts.approve'; //uri: /planning/ajax/adjusts/approve/{productionBiweeklyMain} -> App\Http\Controllers\Planning\Ajax\AdjustController.approve()

var planning_ajax_adjusts_checkApprove = 'planning.ajax.adjusts.check-approve'; //uri: /planning/ajax/adjusts/check-approve/{productionBiweeklyMain} -> App\Http\Controllers\Planning\Ajax\AdjustController.checkApprove()

var planning_ajax_followUps_search = 'planning.ajax.follow-ups.search'; //uri: /planning/ajax/follow-ups/search -> App\Http\Controllers\Planning\Ajax\FollowUpController.search()

var planning_ajax_followUps_getData = 'planning.ajax.follow-ups.get-data'; //uri: /planning/ajax/follow-ups/get-data -> App\Http\Controllers\Planning\Ajax\FollowUpController.getData()

var planning_ajax_productionDaily_modalCreateDetails = 'planning.ajax.production-daily.modal-create-details'; //uri: /planning/ajax/production-daily/modal-create-details -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.modalCreateDetail()

var planning_ajax_productionDaily_search = 'planning.ajax.production-daily.search'; //uri: /planning/ajax/production-daily/search -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.search()

var planning_ajax_productionDaily_create = 'planning.ajax.production-daily.create'; //uri: /planning/ajax/production-daily/create -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.create()

var planning_ajax_productionDaily_getOmSalesForecast = 'planning.ajax.production-daily.get-om-sales-forecast'; //uri: /planning/ajax/production-daily/get-om-sales-forecast -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.getOMSalesForecast()

var planning_ajax_productionDaily_getProductionMachine = 'planning.ajax.production-daily.get-production-machine'; //uri: /planning/ajax/production-daily/get-production-machine -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.getProductionMachine()

var planning_ajax_productionDaily_getProductionItem = 'planning.ajax.production-daily.get-production-item'; //uri: /planning/ajax/production-daily/get-production-item -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.getProductionItem()

var planning_ajax_productionDaily_submitProductionMachine = 'planning.ajax.production-daily.submit-production-machine'; //uri: /planning/ajax/production-daily/machine -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.submitChangeEfficiency()

var planning_ajax_productionDaily_checkApprove = 'planning.ajax.production-daily.check-approve'; //uri: /planning/ajax/production-daily/check-approve/{machineBiweekly}/daily-plan/{dailyPlan} -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.checkApprove()

var planning_ajax_productionDaily_approve = 'planning.ajax.production-daily.approve'; //uri: /planning/ajax/production-daily/approve/{dailyPlan} -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.approve()

var planning_ajax_productionDaily_checkUnapprove = 'planning.ajax.production-daily.check-unapprove'; //uri: /planning/ajax/production-daily/check-unapprove/{machineBiweekly}/daily-plan/{dailyPlan} -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.checkUnapprove()

var planning_ajax_productionDaily_unapprove = 'planning.ajax.production-daily.unapprove'; //uri: /planning/ajax/production-daily/unapprove/{dailyPlan} -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.unapprove()

var planning_ajax_productionDaily_getGrpEfficiencyProduct = 'planning.ajax.production-daily.get-grp-efficiency-product'; //uri: /planning/ajax/production-daily/get-grp-efficiency-product -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.getGrpEfficiencyProduct()

var planning_ajax_productionDaily_updateWorkingHour = 'planning.ajax.production-daily.update_working_hour'; //uri: /planning/ajax/production-daily/update-working-hour/{res_plan_h_id} -> App\Http\Controllers\Planning\Ajax\ProductionDailyController.updateWorkingHour()

var planning_ajax_stampMonthly_modalCreateDetails = 'planning.ajax.stamp-monthly.modal-create-details'; //uri: /planning/ajax/stamp-monthly/modal-create-details -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.modalCreateDetail()

var planning_ajax_stampMonthly_getEstData = 'planning.ajax.stamp-monthly.get-est-data'; //uri: /planning/ajax/stamp-monthly/get-est-data -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.getEstData()

var planning_ajax_stampMonthly_store = 'planning.ajax.stamp-monthly.store'; //uri: /planning/ajax/stamp-monthly -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.store()

var planning_ajax_stampMonthly_update = 'planning.ajax.stamp-monthly.update'; //uri: /planning/ajax/stamp-monthly/{ptppStampMonthly} -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.update()

var planning_ajax_stampMonthly_duplicate = 'planning.ajax.stamp-monthly.duplicate'; //uri: /planning/ajax/stamp-monthly/{ptppStampMonthly}/duplicate -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.duplicate()

var planning_ajax_stampMonthly_updateEst = 'planning.ajax.stamp-monthly.update-est'; //uri: /planning/ajax/stamp-monthly/{ptppStampMonthly}/update-est -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.updateEst()

var planning_ajax_stampMonthly_search = 'planning.ajax.stamp-monthly.search'; //uri: /planning/ajax/stamp-monthly/search -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.search()

var planning_ajax_stampMonthly_approve = 'planning.ajax.stamp-monthly.approve'; //uri: /planning/ajax/stamp-monthly/approve/{stampMonthlyV} -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.approve()

var planning_ajax_stampMonthly_checkApprove = 'planning.ajax.stamp-monthly.check-approve'; //uri: /planning/ajax/stamp-monthly/check-approve/{stampMonthlyV} -> App\Http\Controllers\Planning\Ajax\StampMonthlyController.checkApprove()

var planning_ajax_stampFollow_getStampDaily = 'planning.ajax.stamp-follow.get-stamp-daily'; //uri: /planning/ajax/stamp-follow/get-stamp-daily -> App\Http\Controllers\Planning\Ajax\StampFollowController.getStampDaily()

var planning_ajax_stampFollow_store = 'planning.ajax.stamp-follow.store'; //uri: /planning/ajax/stamp-follow -> App\Http\Controllers\Planning\Ajax\StampFollowController.store()

var planning_ajax_stampFollow_update = 'planning.ajax.stamp-follow.update'; //uri: /planning/ajax/stamp-follow/{stampFollowMain} -> App\Http\Controllers\Planning\Ajax\StampFollowController.update()

var pm_ajax_materialRequests_lines = 'pm.ajax.material-requests.lines'; //uri: /pm/ajax/material-requests/lines -> App\Http\Controllers\PM\Api\MaterialRequestController.lines()

var pm_ajax_materialRequests_getItem = 'pm.ajax.material-requests.get-item'; //uri: /pm/ajax/material-requests/get-item -> App\Http\Controllers\PM\Api\MaterialRequestController.getItem()

var pm_ajax_materialRequests_store = 'pm.ajax.material-requests.store'; //uri: /pm/ajax/material-requests/store -> App\Http\Controllers\PM\Api\MaterialRequestController.store()

var pm_ajax_materialRequests_setStatus = 'pm.ajax.material-requests.set-status'; //uri: /pm/ajax/material-requests/set-status/{requestHeader} -> App\Http\Controllers\PM\Api\MaterialRequestController.setStatus()

var pm_ajax_transferProducts_getLines = 'pm.ajax.transfer-products.get-lines'; //uri: /pm/ajax/transfer-products/get-lines -> App\Http\Controllers\PM\Api\TransferProductController.getLines()

var pm_ajax_transferProducts_getItem = 'pm.ajax.transfer-products.get-item'; //uri: /pm/ajax/transfer-products/get-item -> App\Http\Controllers\PM\Api\TransferProductController.getItem()

var pm_ajax_transferProducts_store = 'pm.ajax.transfer-products.store'; //uri: /pm/ajax/transfer-products/store -> App\Http\Controllers\PM\Api\TransferProductController.store()

var pm_ajax_transferProducts_setStatus = 'pm.ajax.transfer-products.set-status'; //uri: /pm/ajax/transfer-products/set-status/{header} -> App\Http\Controllers\PM\Api\TransferProductController.setStatus()

var pm_ajax_sendCigarettes_getLines = 'pm.ajax.send-cigarettes.get-lines'; //uri: /pm/ajax/send-cigarettes/get-lines -> App\Http\Controllers\PM\Api\SendCigaretteController.getLines()

var pm_ajax_sendCigarettes_getItem = 'pm.ajax.send-cigarettes.get-item'; //uri: /pm/ajax/send-cigarettes/get-item -> App\Http\Controllers\PM\Api\SendCigaretteController.getItem()

var pm_ajax_sendCigarettes_store = 'pm.ajax.send-cigarettes.store'; //uri: /pm/ajax/send-cigarettes/store -> App\Http\Controllers\PM\Api\SendCigaretteController.store()

var pm_ajax_sendCigarettes_setStatus = 'pm.ajax.send-cigarettes.set-status'; //uri: /pm/ajax/send-cigarettes/set-status/{header} -> App\Http\Controllers\PM\Api\SendCigaretteController.setStatus()

var pm_ajax_wipRequests_getLines = 'pm.ajax.wip-requests.get-lines'; //uri: /pm/ajax/wip-requests/get-lines -> App\Http\Controllers\PM\Api\WipRequestController.getLines()

var pm_ajax_wipRequests_getItem = 'pm.ajax.wip-requests.get-item'; //uri: /pm/ajax/wip-requests/get-item -> App\Http\Controllers\PM\Api\WipRequestController.getItem()

var pm_ajax_wipRequests_store = 'pm.ajax.wip-requests.store'; //uri: /pm/ajax/wip-requests/store -> App\Http\Controllers\PM\Api\WipRequestController.store()

var pm_ajax_wipRequests_setStatus = 'pm.ajax.wip-requests.set-status'; //uri: /pm/ajax/wip-requests/set-status/{header} -> App\Http\Controllers\PM\Api\WipRequestController.setStatus()

var pm_ajax_jams_getLines = 'pm.ajax.jams.get-lines'; //uri: /pm/ajax/jams/get-lines -> App\Http\Controllers\PM\Api\JamController.getLines()

var pm_ajax_jams_getItem = 'pm.ajax.jams.get-item'; //uri: /pm/ajax/jams/get-item -> App\Http\Controllers\PM\Api\JamController.getItem()

var pm_ajax_jams_store = 'pm.ajax.jams.store'; //uri: /pm/ajax/jams/store -> App\Http\Controllers\PM\Api\JamController.store()

var pm_ajax_jams_setStatus = 'pm.ajax.jams.set-status'; //uri: /pm/ajax/jams/set-status/{header} -> App\Http\Controllers\PM\Api\JamController.setStatus()

var pm_ajax_ingredientPreparationQrcode = 'pm.ajax.ingredient-preparation-qrcode'; //uri: /pm/ajax/ingredient-preparation-qrcode -> App\Http\Controllers\PM\Api\IngredientPreparationController.index()

var pm_ajax_ingredientPreparationDetail = 'pm.ajax.ingredient-preparation-detail'; //uri: /pm/ajax/ingredient-preparation-detail -> App\Http\Controllers\PM\Api\IngredientPreparationController.getLineDetail()

var pm_ajax_sprinkleTobaccos_getLines = 'pm.ajax.sprinkle-tobaccos.get-lines'; //uri: /pm/ajax/sprinkle-tobaccos/get-lines -> App\Http\Controllers\PM\Api\SprinkleTobaccoController.getLines()

var pm_ajax_sprinkleTobaccos_getItem = 'pm.ajax.sprinkle-tobaccos.get-item'; //uri: /pm/ajax/sprinkle-tobaccos/get-item -> App\Http\Controllers\PM\Api\SprinkleTobaccoController.getItem()

var pm_ajax_sprinkleTobaccos_store = 'pm.ajax.sprinkle-tobaccos.store'; //uri: /pm/ajax/sprinkle-tobaccos/store -> App\Http\Controllers\PM\Api\SprinkleTobaccoController.store()

var pm_ajax_sprinkleTobaccos_cancel = 'pm.ajax.sprinkle-tobaccos.cancel'; //uri: /pm/ajax/sprinkle-tobaccos/cancel -> App\Http\Controllers\PM\Api\SprinkleTobaccoController.cancel()

var pm_ajax_sprinkleTobaccos_setStatus = 'pm.ajax.sprinkle-tobaccos.set-status'; //uri: /pm/ajax/sprinkle-tobaccos/set-status/{header} -> App\Http\Controllers\PM\Api\SprinkleTobaccoController.setStatus()

var pm_materialRequests_index = 'pm.material-requests.index'; //uri: /pm/material-requests -> App\Http\Controllers\PM\MaterialRequestController.index()

var pm_transferProducts_index = 'pm.transfer-products.index'; //uri: /pm/transfer-products -> App\Http\Controllers\PM\TransferProductController.index()

var pm_sendCigarettes_index = 'pm.send-cigarettes.index'; //uri: /pm/send-cigarettes -> App\Http\Controllers\PM\SendCigaretteController.index()

var pm_wipRequests_index = 'pm.wip-requests.index'; //uri: /pm/wip-requests -> App\Http\Controllers\PM\WipRequestController.index()

var pm_jams_index = 'pm.jams.index'; //uri: /pm/jams -> App\Http\Controllers\PM\JamController.index()

var pm_ingredientPreparation_index = 'pm.ingredient-preparation.index'; //uri: /pm/ingredient-preparation -> App\Http\Controllers\PM\IngredientPreparationController.index()

var pm_ingredientPreparation_printPdf = 'pm.ingredient-preparation.print-pdf'; //uri: /pm/ingredient-preparation/print-pdf -> App\Http\Controllers\PM\IngredientPreparationController.printPdf()

var pm_sprinkleTobaccos_index = 'pm.sprinkle-tobaccos.index'; //uri: /pm/sprinkle-tobaccos -> App\Http\Controllers\PM\SprinkleTobaccoController.index()

var pm_ajax_qrcodeCheckMtls_detail = 'pm.ajax.qrcode-check-mtls.detail'; //uri: /pm/ajax/qrcode-check-mtls/detail -> App\Http\Controllers\PM\Api\QrcodeCheckMtlController.detail()

var pm_ajax_qrcodeTransferMtls_detail = 'pm.ajax.qrcode-transfer-mtls.detail'; //uri: /pm/ajax/qrcode-transfer-mtls/detail -> App\Http\Controllers\PM\Api\QrcodeTransferMtlController.detail()

var pm_ajax_qrcodeRcvTransferMtls_detail = 'pm.ajax.qrcode-rcv-transfer-mtls.detail'; //uri: /pm/ajax/qrcode-rcv-transfer-mtls/detail -> App\Http\Controllers\PM\Api\QrcodeRcvTransferMtlController.detail()

var pm_ajax_qrcodeReturnMtls_detail = 'pm.ajax.qrcode-return-mtls.detail'; //uri: /pm/ajax/qrcode-return-mtls/detail -> App\Http\Controllers\PM\Api\QrcodeReturnMtlController.detail()

var pm_qrcodeCheckMtls_index = 'pm.qrcode-check-mtls.index'; //uri: /pm/qrcode-check-mtls -> App\Http\Controllers\PM\QrcodeCheckMtlController.index()

var pm_qrcodeTransferMtls_index = 'pm.qrcode-transfer-mtls.index'; //uri: /pm/qrcode-transfer-mtls -> App\Http\Controllers\PM\QrcodeTransferMtlController.index()

var pm_qrcodeRcvTransferMtls_index = 'pm.qrcode-rcv-transfer-mtls.index'; //uri: /pm/qrcode-rcv-transfer-mtls -> App\Http\Controllers\PM\QrcodeRcvTransferMtlController.index()

var pm_qrcodeReturnMtls_index = 'pm.qrcode-return-mtls.index'; //uri: /pm/qrcode-return-mtls -> App\Http\Controllers\PM\QrcodeReturnMtlController.index()

var ajax_pm_planningJobs_index = 'ajax.pm.planning-jobs.index'; //uri: /ajax/pm/planning-jobs -> App\Http\Controllers\PM\Ajax\PlanningJobController.index()

var pm_planningJobs_index = 'pm.planning-jobs.index'; //uri: /pm/planning-jobs -> App\Http\Controllers\PM\Web\PlanningJobController.index()

var pm_ajax_confirmOrder_store = 'pm.ajax.confirm-order.store'; //uri: /pm/ajax/confirm-order -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.store()

var pm_ajax_confirmOrder_getLines = 'pm.ajax.confirm-order.get-lines'; //uri: /pm/ajax/confirm-order/get-lines -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.getLine()

var pm_ajax_confirmOrder_getDistributions = 'pm.ajax.confirm-order.get-distributions'; //uri: /pm/ajax/confirm-order/get-distributions -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.getDistribution()

var pm_ajax_confirmOrder_getWipstep = 'pm.ajax.confirm-order.get-wipstep'; //uri: /pm/ajax/confirm-order/get-wipstep -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.getWipStep()

var pm_ajax_confirmOrder_getSearch = 'pm.ajax.confirm-order.get-search'; //uri: /pm/ajax/confirm-order/get-search -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.getSearch()

var pm_ajax_confirmOrder_getHeadersByDate = 'pm.ajax.confirm-order.get-headers-by-date'; //uri: /pm/ajax/confirm-order/get-headers-by-date -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.getHeaderByDate()

var pm_ajax_confirmOrder_updateOrders = 'pm.ajax.confirm-order.update-orders'; //uri: /pm/ajax/confirm-order-update -> App\Http\Controllers\PM\Ajax\ConfirmLossOrderController.update()

var pm_confirmOrder_index = 'pm.confirm-order.index'; //uri: /pm/confirm-order -> App\Http\Controllers\PM\ConfirmLossOrderController.index()

var pm_sampleReport_report = 'pm.sample-report.report'; //uri: /pm/sample-report/{number} -> App\Http\Controllers\PM\TestReportController.report()

var pm_sampleReport_report1Pdf = 'pm.sample-report.report1-pdf'; //uri: /pm/sample-report1-pdf/{number} -> App\Http\Controllers\PM\TestReportController.report1Pdf()

var pm_sampleReport_reportInventoryPdf = 'pm.sample-report.report-inventory-pdf'; //uri: /pm/sample-report-inventory-pdf/{batchNo}/{departmentCode}/{txnDate} -> App\Http\Controllers\PM\TestReportController.reportInventory()

var pm_sampleReport_reportSummaryPdf = 'pm.sample-report.report-summary-pdf'; //uri: /pm/sample-report-summary-pdf/{departmentCode}/{startDate}/{endDate} -> App\Http\Controllers\PM\TestReportController.reportMasterList()

var pm_sampleReport_reportVue = 'pm.sample-report.report-vue'; //uri: /pm/sample-report-vue -> App\Http\Controllers\PM\TestReportController.reportVue()

var pm_sampleReport_report1 = 'pm.sample-report.report1'; //uri: /pm/sample-report1 -> App\Http\Controllers\PM\TestReportController.report1()

var pm_sampleReport_report2 = 'pm.sample-report.report2'; //uri: /pm/sample-report2 -> App\Http\Controllers\PM\TestReportController.report2()

var pm_sampleReport_testPdf = 'pm.sample-report.testPdf'; //uri: /pm/test-pdf -> App\Http\Controllers\PM\TestReportController.testPdf()

var pm_ajax_wipConfirm_importMesData = 'pm.ajax.wip-confirm.importMesData'; //uri: /pm/ajax/wip-confirm/importMesData -> App\Http\Controllers\PM\Api\WipConfirmApiController.importMesData()

var pm_ajax_wipConfirm_lines = 'pm.ajax.wip-confirm.lines'; //uri: /pm/ajax/wip-confirm/lines -> App\Http\Controllers\PM\Api\WipConfirmApiController.showJobLines()

var pm_ajax_wipConfirm_store = 'pm.ajax.wip-confirm.store'; //uri: /pm/ajax/wip-confirm/store -> App\Http\Controllers\PM\Api\WipConfirmApiController.updateJobLines()

var pm_wipConfirm_index = 'pm.wip-confirm.index'; //uri: /pm/wip-confirm -> App\Http\Controllers\PM\WipConfirmController.index()

var pm_wipConfirm_search = 'pm.wip-confirm.search'; //uri: /pm/wip-confirm/search -> App\Http\Controllers\PM\WipConfirmController.search()

var pm_wipConfirm_jobs = 'pm.wip-confirm.jobs'; //uri: /pm/wip-confirm/jobs -> App\Http\Controllers\PM\WipConfirmController.showJob()

var pm_wipConfirm_exportPdfParameters = 'pm.wip-confirm.export-pdf-parameters'; //uri: /pm/wip-confirm/export-pdf-parameters/{report_code} -> App\Http\Controllers\PM\WipConfirmController.exportPdfParameters()

var pm_wipConfirm_exportPdf = 'pm.wip-confirm.export-pdf'; //uri: /pm/wip-confirm/export-pdf -> App\Http\Controllers\PM\WipConfirmController.exportPdf()

var pm_ajax_getMeReviewIssuesV = 'pm.ajax.get-me-review-issues-v'; //uri: /pm/ajax/get-mes-review-issues -> App\Http\Controllers\PM\Api\WipIssuesApiController.getMesReviewIssuesV()

var pm_ajax_optFromBlendNo = 'pm.ajax.opt-from-blend-no'; //uri: /pm/ajax/get-opt-from-blend-no -> App\Http\Controllers\PM\Api\WipIssuesApiController.getOptsFromBlends()

var pm_ajax_getOprnByItem = 'pm.ajax.get-oprn-by-item'; //uri: /pm/ajax/get-oprn-by-item -> App\Http\Controllers\PM\Api\WipIssuesApiController.getOprnByItem()

var pm_ajax_getFormulas = 'pm.ajax.get-formulas'; //uri: /pm/ajax/get-formulas -> App\Http\Controllers\PM\Api\WipIssuesApiController.getFormula()

var pm_ajax_saveData = 'pm.ajax.save-data'; //uri: /pm/ajax/save-data -> App\Http\Controllers\PM\Api\WipIssuesApiController.saveData()

var pm_ajax_updateData = 'pm.ajax.update-data'; //uri: /pm/ajax/update-data -> App\Http\Controllers\PM\Api\WipIssuesApiController.updateData()

var pm_ajax_findClassification = 'pm.ajax.find-classification'; //uri: /pm/ajax/find-classification -> App\Http\Controllers\PM\Api\WipIssuesApiController.findClassification()

var pm_ajax_getHeaders = 'pm.ajax.get-headers'; //uri: /pm/ajax/get-headers -> App\Http\Controllers\PM\Api\WipIssuesApiController.getHeaders()

var pm_ajax_cancelData = 'pm.ajax.cancel-data'; //uri: /pm/ajax/cancel-data -> App\Http\Controllers\PM\Api\WipIssuesApiController.cancelData()

var pm_ajax_searchHeader = 'pm.ajax.search-header'; //uri: /pm/ajax/search-header -> App\Http\Controllers\PM\Api\WipIssuesApiController.searchHeader()

var pm_wipIssue_index = 'pm.wip-issue.index'; //uri: /pm/wip-issue -> App\Http\Controllers\PM\WipIssuesController.index()

var pm_wipIssue_casingFlavorIndex = 'pm.wip-issue.casing-flavor-index'; //uri: /pm/wip-issue/casing-flavor -> App\Http\Controllers\PM\WipIssuesController.casingFlavorIndex()

var pm_wipIssue_issue = 'pm.wip-issue.issue'; //uri: /pm/wip-issue/issue -> App\Http\Controllers\PM\WipIssuesController.wipIssueAll()

var pm_wipIssue_cutOf = 'pm.wip-issue.cut_of'; //uri: /pm/wip-issue/cut_of -> App\Http\Controllers\PM\WipIssuesController.wipIssueCutOF()

var pd_ajax_expFormulas_getLines = 'pd.ajax.exp-formulas.get-lines'; //uri: /pd/ajax/exp-formulas/get-lines -> App\Http\Controllers\PD\Api\ExpFormulaController.getLines()

var pd_ajax_expFormulas_getData = 'pd.ajax.exp-formulas.get-data'; //uri: /pd/ajax/exp-formulas/get-data -> App\Http\Controllers\PD\Api\ExpFormulaController.getData()

var pd_ajax_expFormulas_compareData = 'pd.ajax.exp-formulas.compare-data'; //uri: /pd/ajax/exp-formulas/compare-data -> App\Http\Controllers\PD\Api\ExpFormulaController.compareData()

var pd_ajax_expFormulas_store = 'pd.ajax.exp-formulas.store'; //uri: /pd/ajax/exp-formulas/store -> App\Http\Controllers\PD\Api\ExpFormulaController.store()

var pd_ajax_expFormulas_setStatus = 'pd.ajax.exp-formulas.set-status'; //uri: /pd/ajax/exp-formulas/set-status/{header} -> App\Http\Controllers\PD\Api\ExpFormulaController.setStatus()

var pd_ajax_adjSalForecasts_store = 'pd.ajax.adj-sal-forecasts.store'; //uri: /pd/ajax/adj-sal-forecasts/store -> App\Http\Controllers\PD\Api\AdjSalForecastController.store()

var pd_ajax_adjSalForecasts_update = 'pd.ajax.adj-sal-forecasts.update'; //uri: /pd/ajax/adj-sal-forecasts/{adjSalForecastHT}/update -> App\Http\Controllers\PD\Api\AdjSalForecastController.update()

var pd_ajax_adjSalForecasts_modalCreateDetails = 'pd.ajax.adj-sal-forecasts.modal-create-details'; //uri: /pd/ajax/adj-sal-forecasts/modal-create-details -> App\Http\Controllers\PD\Api\AdjSalForecastController.modalCreateDetail()

var pd_ajax_adjSalForecasts_modalSearchDetails = 'pd.ajax.adj-sal-forecasts.modal-search-details'; //uri: /pd/ajax/adj-sal-forecasts/modal-search-details -> App\Http\Controllers\PD\Api\AdjSalForecastController.modalSearchDetail()

var pd_expFormulas_index = 'pd.exp-formulas.index'; //uri: /pd/exp-formulas -> App\Http\Controllers\PD\ExpFormulaController.index()

var pd_adjSalForecasts_index = 'pd.adj-sal-forecasts.index'; //uri: /pd/adj-sal-forecasts -> App\Http\Controllers\PD\AdjSalForecastController.index()

var ct_costCenter_index = 'ct.cost_center.index'; //uri: /ct/cost_center -> App\Http\Controllers\CT\CostCenterController.index()

var ct_costCenter_create = 'ct.cost_center.create'; //uri: /ct/cost_center/create -> App\Http\Controllers\CT\CostCenterController.create()

var ct_costCenter_edit = 'ct.cost_center.edit'; //uri: /ct/cost_center/{cost_center_id} -> App\Http\Controllers\CT\CostCenterController.edit()

var ct_specifyPercentage_create = 'ct.specify_percentage.create'; //uri: /ct/specify_percentage -> App\Http\Controllers\CT\CostCenterController.specifyPercentage()

var ct_productGroup_index = 'ct.product_group.index'; //uri: /ct/product_group -> App\Http\Controllers\CT\ProductGroupController.index()

var ct_criterionAllocate_index = 'ct.criterion_allocate.index'; //uri: /ct/criterion_allocate -> App\Http\Controllers\CT\CriterionAllocateController.index()

var ct_setAccountType_index = 'ct.set_account_type.index'; //uri: /ct/set_account_type -> App\Http\Controllers\CT\SetAccountTypeController.index()

var ct_accountCodeLedger_index = 'ct.account_code_ledger.index'; //uri: /ct/account_code_ledger -> App\Http\Controllers\CT\AccountCodeLedgerController.index()

var ct_agency_show = 'ct.agency.show'; //uri: /ct/agency/{flex_value_set_id} -> App\Http\Controllers\CT\AgencyController.show()

var ct_specifyAgency_index = 'ct.specify_agency.index'; //uri: /ct/specify_agency -> App\Http\Controllers\CT\CostCenterController.specifyAgency()

var ct_productPlanAmount_index = 'ct.product_plan_amount.index'; //uri: /ct/product_plan_amount -> App\Http\Controllers\CT\ProductPlanAmountController.index()

var ct_purchasePriceInfo_index = 'ct.purchase_price_info.index'; //uri: /ct/purchase_price_info -> App\Http\Controllers\CT\PurchasePriceInfoController.index()

var ct_taxMedicine_index = 'ct.tax_medicine.index'; //uri: /ct/tax_medicine -> App\Http\Controllers\CT\TaxMedicineController.index()

var ct_taxMedicine_create = 'ct.tax_medicine.create'; //uri: /ct/tax_medicine/create -> App\Http\Controllers\CT\TaxMedicineController.create()

var ct_taxMedicine_edit = 'ct.tax_medicine.edit'; //uri: /ct/tax_medicine/{tax_medicine} -> App\Http\Controllers\CT\TaxMedicineController.edit()

var ct_ajax_account_index = 'ct.ajax.account.index'; //uri: /ct/ajax/account -> App\Http\Controllers\CT\Ajax\AccountController.index()

var ct_ajax_ptglAccountsInfo_getDataBySegment = 'ct.ajax.ptgl_accounts_info.get_data_by_segment'; //uri: /ct/ajax/get_data_by_segment/{segment} -> App\Http\Controllers\CT\Ajax\PtglAccountsInfoController.getDataBySegment()

var ct_ajax_ptpmItemNumberV_getCategory = 'ct.ajax.ptpm_item_number_v.get_category'; //uri: /ct/ajax/get_category -> App\Http\Controllers\CT\Ajax\PtpmItemNumberVController.getCategory()

var ct_ajax_ptpmItemNumberV_getOrganizations = 'ct.ajax.ptpm_item_number_v.get_organizations'; //uri: /ct/ajax/get_organizations -> App\Http\Controllers\CT\Ajax\PtinvOrganizationsInfoController.getOrganizations()

var ct_ajax_ptpmItemNumberV_organizationSourceItemCost = 'ct.ajax.ptpm_item_number_v.organizationSourceItemCost'; //uri: /ct/ajax/organization_source_item_cost -> App\Http\Controllers\CT\Ajax\PtinvOrganizationsInfoController.organizationSourceItemCost()

var ct_ajax_ = 'ct.ajax.'; //uri: /ct/ajax/inv_org -> App\Http\Controllers\CT\Ajax\OrgInvController.index()

var ct_ajax_ptpmItemNumberV_getRawMaterial = 'ct.ajax.ptpm_item_number_v.get_raw_material'; //uri: /ct/ajax/get_raw_material -> App\Http\Controllers\CT\Ajax\PtpmItemNumberVController.getRawMaterial()

var ct_ajax_costCenter_ = 'ct.ajax.cost_center.'; //uri: /ct/ajax/cost_center -> App\Http\Controllers\CT\Ajax\CostCenterController.store()

var ct_ajax_costCenter_index = 'ct.ajax.cost_center.index'; //uri: /ct/ajax/cost_center -> App\Http\Controllers\CT\Ajax\CostCenterController.index()

var ct_ajax_costCenter_find = 'ct.ajax.cost_center.find'; //uri: /ct/ajax/cost_center/find -> App\Http\Controllers\CT\Ajax\CostCenterController.find()

var ct_ajax_costCenter_updateActive = 'ct.ajax.cost_center.update_active'; //uri: /ct/ajax/cost_center/update_active -> App\Http\Controllers\CT\Ajax\CostCenterController.updateIsActive()

var ct_ajax_costCenter_periodYears = 'ct.ajax.cost_center.period_years'; //uri: /ct/ajax/cost_center/period_years -> App\Http\Controllers\CT\Ajax\CostCenterController.getPeriodYearForDropdown()

var ct_ajax_costCenter_updateCt = 'ct.ajax.cost_center.update_ct'; //uri: /ct/ajax/cost_center/update_ct -> App\Http\Controllers\CT\Ajax\CostCenterController.updateCostCenter()

var ct_ajax_costCenter_update = 'ct.ajax.cost_center.update'; //uri: /ct/ajax/cost_center/update -> App\Http\Controllers\CT\Ajax\CostCenterController.update()

var ct_ajax_costCenter_years = 'ct.ajax.cost_center.years'; //uri: /ct/ajax/cost_center/years -> App\Http\Controllers\CT\Ajax\CostCenterController.getYearForDropdown()

var ct_ajax_costCenter_codes = 'ct.ajax.cost_center.codes'; //uri: /ct/ajax/cost_center/codes -> App\Http\Controllers\CT\Ajax\CostCenterController.getCodeForDropdown()

var ct_ajax_costCenter_ptpmItems = 'ct.ajax.cost_center.ptpm_items'; //uri: /ct/ajax/cost_center/ptpm_items -> App\Http\Controllers\CT\Ajax\CostCenterController.getPtpmItemForDropdown()

var ct_ajax_productGroup_index = 'ct.ajax.product_group.index'; //uri: /ct/ajax/product_group -> App\Http\Controllers\CT\Ajax\ProductGroupController.index()

var ct_ajax_productGroup_find = 'ct.ajax.product_group.find'; //uri: /ct/ajax/product_group/find -> App\Http\Controllers\CT\Ajax\ProductGroupController.find()

var ct_ajax_productGroup_copy_get = 'ct.ajax.product_group.copy.get'; //uri: /ct/ajax/product_group/copy/{code} -> App\Http\Controllers\CT\Ajax\ProductGroupController.copyProductGroup()

var ct_ajax_productGroup_copy_post = 'ct.ajax.product_group.copy.post'; //uri: /ct/ajax/product_group/copy -> App\Http\Controllers\CT\Ajax\ProductGroupController.copy()

var ct_ajax_productGroupDetail_update = 'ct.ajax.product_group_detail.update'; //uri: /ct/ajax/product_group_detail/update -> App\Http\Controllers\CT\Ajax\ProductGroupDetailController.update()

var ct_ajax_productGroupDetail_findWithProductGroup = 'ct.ajax.product_group_detail.findWithProductGroup'; //uri: /ct/ajax/product_group_detail/find_pg/{product_group_id} -> App\Http\Controllers\CT\Ajax\ProductGroupDetailController.findWithProductGroup()

var ct_ajax_productPlanAmount_update = 'ct.ajax.product_plan_amount.update'; //uri: /ct/ajax/product_plan_amount/update -> App\Http\Controllers\CT\Ajax\ProductPlanAmountController.update()

var ct_ajax_productProcesses_update = 'ct.ajax.product_processes.update'; //uri: /ct/ajax/product_processes -> App\Http\Controllers\CT\Ajax\CostCenterProductionProcessController.update()

var ct_ajax_productProcesses_show = 'ct.ajax.product_processes.show'; //uri: /ct/ajax/product_processes/{cost_center_id} -> App\Http\Controllers\CT\Ajax\CostCenterProductionProcessController.show()

var ct_ajax_designateAgency_getDepartment = 'ct.ajax.designate_agency.get_department'; //uri: /ct/ajax/designate_agency/get_department -> App\Http\Controllers\CT\Ajax\DesignateAgencyController.getDepartment()

var ct_ajax_setAccountType_getListSetAccountType = 'ct.ajax.set_account_type.getListSetAccountType'; //uri: /ct/ajax/set_account_type -> App\Http\Controllers\CT\Ajax\SetAccountTypeController.getListSetAccountType()

var ct_ajax_setAccountType_update = 'ct.ajax.set_account_type.update'; //uri: /ct/ajax/set_account_type/update -> App\Http\Controllers\CT\Ajax\SetAccountTypeController.update()

var ct_ajax_agency_update = 'ct.ajax.agency.update'; //uri: /ct/ajax/agency/update -> App\Http\Controllers\CT\Ajax\AgencyController.update()

var ct_ajax_accountCodeLedger_store = 'ct.ajax.account_code_ledger.store'; //uri: /ct/ajax/account_code_ledger -> App\Http\Controllers\CT\Ajax\AccountCodeLedgerController.store()

var ct_ajax_criterionAllocate_index = 'ct.ajax.criterion_allocate.index'; //uri: /ct/ajax/criterion_allocate -> App\Http\Controllers\CT\Ajax\CriterionAllocateController.index()

var ct_ajax_criterionAllocate_update = 'ct.ajax.criterion_allocate.update'; //uri: /ct/ajax/criterion_allocate/update -> App\Http\Controllers\CT\Ajax\CriterionAllocateController.update()

var ct_ajax_taxMedicine_index = 'ct.ajax.tax_medicine.index'; //uri: /ct/ajax/tax_medicine -> App\Http\Controllers\CT\Ajax\TaxMedicineController.index()

var ct_ajax_taxMedicine_store = 'ct.ajax.tax_medicine.store'; //uri: /ct/ajax/tax_medicine -> App\Http\Controllers\CT\Ajax\TaxMedicineController.store()

var ct_ajax_taxMedicine_determine = 'ct.ajax.tax_medicine.determine'; //uri: /ct/ajax/tax_medicine/determine -> App\Http\Controllers\CT\Ajax\TaxMedicineController.determine()

var ct_ajax_taxMedicine_notDetermine = 'ct.ajax.tax_medicine.not_determine'; //uri: /ct/ajax/tax_medicine/not_determine -> App\Http\Controllers\CT\Ajax\TaxMedicineController.notDetermine()

var ct_ajax_taxMedicine_update = 'ct.ajax.tax_medicine.update'; //uri: /ct/ajax/tax_medicine/{item_number} -> App\Http\Controllers\CT\Ajax\TaxMedicineController.update()

var ct_ajax_taxMedicine_show = 'ct.ajax.tax_medicine.show'; //uri: /ct/ajax/tax_medicine/{item_number} -> App\Http\Controllers\CT\Ajax\TaxMedicineController.show()

var ct_ajax_purchasePriceInfo_index = 'ct.ajax.purchase_price_info.index'; //uri: /ct/ajax/purchase_price_info -> App\Http\Controllers\CT\Ajax\PurchasePriceInfoController.index()

var ct_ajax_purchasePriceInfo_store = 'ct.ajax.purchase_price_info.store'; //uri: /ct/ajax/purchase_price_info -> App\Http\Controllers\CT\Ajax\PurchasePriceInfoController.store()

var ct_ajax_purchasePriceInfo_updateLine = 'ct.ajax.purchase_price_info.updateLine'; //uri: /ct/ajax/purchase_price_info/line/{std_mcl_id} -> App\Http\Controllers\CT\Ajax\PurchasePriceInfoController.updateLine()

var ct_ajax_purchasePriceInfo_updateStatus = 'ct.ajax.purchase_price_info.updateStatus'; //uri: /ct/ajax/purchase_price_info/update_status/{std_mch_id} -> App\Http\Controllers\CT\Ajax\PurchasePriceInfoController.updateStatus()

var pm_ajax_additiveInventoryAlert_index = 'pm.ajax.additive-inventory-alert.index'; //uri: /pm/ajax/additive-inventory-alert -> App\Http\Controllers\PM\Api\AdditiveInventoryAlertController.index()

var pm_ajax_additiveInventoryAlert_store = 'pm.ajax.additive-inventory-alert.store'; //uri: /pm/ajax/additive-inventory-alert/store -> App\Http\Controllers\PM\Api\AdditiveInventoryAlertController.store()

var pm_ajax_additiveInventoryAlert_getTypeOrder = 'pm.ajax.additive-inventory-alert.getTypeOrder'; //uri: /pm/ajax/additive-inventory-alert/get-type-order -> App\Http\Controllers\PM\Api\AdditiveInventoryAlertController.getTypeOrder()

var pm_ajax_additiveInventoryAlert_saveReportNumber = 'pm.ajax.additive-inventory-alert.saveReportNumber'; //uri: /pm/ajax/additive-inventory-alert/save-report-number -> App\Http\Controllers\PM\Api\AdditiveInventoryAlertController.saveReportNumber()

var pm_ajax_additiveInventoryAlert_productLists = 'pm.ajax.additive-inventory-alert.productLists'; //uri: /pm/ajax/additive-inventory-alert/product-lists -> App\Http\Controllers\PM\Api\AdditiveInventoryAlertController.productLists()

var pm_ajax_rawMaterialInventoryAlert_index = 'pm.ajax.raw-material-inventory-alert.index'; //uri: /pm/ajax/raw-material-inventory-alert -> App\Http\Controllers\PM\Api\RawMaterialInventoryAlertController.index()

var pm_ajax_rawMaterialInventoryAlert_store = 'pm.ajax.raw-material-inventory-alert.store'; //uri: /pm/ajax/raw-material-inventory-alert/store -> App\Http\Controllers\PM\Api\RawMaterialInventoryAlertController.store()

var pm_ajax_rawMaterialInventoryAlert_productLists = 'pm.ajax.raw-material-inventory-alert.productLists'; //uri: /pm/ajax/raw-material-inventory-alert/product-lists -> App\Http\Controllers\PM\Api\RawMaterialInventoryAlertController.productLists()

var pm_ajax_rawMaterialReport_index = 'pm.ajax.raw_material_report.index'; //uri: /pm/ajax/raw_material_report -> App\Http\Controllers\PM\Api\RawMaterialReportController.index()

var pm_ajax_rawMaterialReport_updateFlag = 'pm.ajax.raw_material_report.update-flag'; //uri: /pm/ajax/raw_material_report/update-flag -> App\Http\Controllers\PM\Api\RawMaterialReportController.updateFlag()

var pm_ajax_rawMaterialList_index = 'pm.ajax.raw_material_list.index'; //uri: /pm/ajax/raw_material_list/get-cate -> App\Http\Controllers\PM\Api\RawMaterialListController.index()

var pm_ajax_rawMaterialList_find = 'pm.ajax.raw_material_list.find'; //uri: /pm/ajax/raw_material_list/find -> App\Http\Controllers\PM\Api\RawMaterialListController.find()

var pm_ajax_rawMaterialList_imageUpload = 'pm.ajax.raw_material_list.image-upload'; //uri: /pm/ajax/raw_material_list/image-upload -> App\Http\Controllers\PM\Api\RawMaterialListController.imageUpload()

var pm_ajax_rawMaterialList_imageRemove = 'pm.ajax.raw_material_list.image-remove'; //uri: /pm/ajax/raw_material_list/image-remove -> App\Http\Controllers\PM\Api\RawMaterialListController.imageRemove()

var pm_ajax_rawMaterialList_store = 'pm.ajax.raw_material_list.store'; //uri: /pm/ajax/raw_material_list/store -> App\Http\Controllers\PM\Api\RawMaterialListController.store()

var pm_rawMaterialList_index = 'pm.raw_material_list.index'; //uri: /pm/raw_material_list -> App\Http\Controllers\PM\Web\RawMaterialListController.index()

var pm_rawMaterialList_requestRawMaterial = 'pm.raw_material_list.request-raw-material'; //uri: /pm/raw_material_list/request-raw-material -> App\Http\Controllers\PM\Web\RawMaterialListController.requestRaMaterial()

var pm_rawMaterialList_informRawMaterial = 'pm.raw_material_list.inform-raw-material'; //uri: /pm/raw_material_list/inform-raw-material -> App\Http\Controllers\PM\Web\RawMaterialListController.informRaMaterial()

var pm_rawMaterialReport_index = 'pm.raw_material_report.index'; //uri: /pm/raw_material_report -> App\Http\Controllers\PM\Web\RawMaterialReportController.index()

var pm_ajax_store = 'pm.ajax.store'; //uri: /pm/ajax/request-raw-materials -> App\Http\Controllers\PM\RequestMaterialController.store()

var pm_ajax_update = 'pm.ajax.update'; //uri: /pm/ajax/request-raw-materials/{id} -> App\Http\Controllers\PM\RequestMaterialController.update()

var pm_ajax_getListItemConvUomV = 'pm.ajax.getListItemConvUomV'; //uri: /pm/ajax/get-list-item-conv-uomv -> App\Http\Controllers\PM\RequestMaterialController.getListItemConvUomV()

var pm_requestRawMaterials_ = 'pm.request-raw-materials.'; //uri: /pm/request-raw-materials -> App\Http\Controllers\PM\RequestMaterialController.index()

var pm_ajax_wipLossQuantity_lines = 'pm.ajax.wip-loss-quantity.lines'; //uri: /pm/ajax/wip-loss-quantity/lines -> App\Http\Controllers\PM\Api\WipLossQuantityApiController.getLines()

var pm_ajax_wipLossQuantity_store = 'pm.ajax.wip-loss-quantity.store'; //uri: /pm/ajax/wip-loss-quantity/store -> App\Http\Controllers\PM\Api\WipLossQuantityApiController.updateJobLines()

var pm_wipLossQuantity_index = 'pm.wip-loss-quantity.index'; //uri: /pm/wip-loss-quantity -> App\Http\Controllers\PM\WipLossQuantityController.index()

var report_ajax_getReportPrograms = 'report.ajax.get-report-programs'; //uri: /report/ajax/get-report-programs -> App\Http\Controllers\Report\Ajax\ReportsController.getReportProgram()

var report_reportInfo_index = 'report.report-info.index'; //uri: /report/report-info -> App\Http\Controllers\Report\ReportsController.index()

var report_reportInfo_report_index = 'report.report-info.report.index'; //uri: /report/report-info -> App\Http\Controllers\Report\ReportsController.index()

var report_reportInfo_report_export = 'report.report-info.report.export'; //uri: /report/report-info/reports/export -> App\Http\Controllers\Report\ReportsController.export()

var report_reportInfo_report_getParam = 'report.report-info.report.get-param'; //uri: /report/report-info/reports/get-param -> App\Http\Controllers\Report\ReportsController.getParam()

var pm_ajax_pmp0031_process = 'pm.ajax.pmp0031.process'; //uri: /pm/ajax/pmp0031/process -> App\Http\Controllers\PM\Api\PMP0031ApiController.process()

var pm_ajax_getSaleForecasts = 'pm.ajax.get-sale-forecasts'; //uri: /pm/ajax/pmp0031/get-sale-forecasts -> App\Http\Controllers\PM\Api\PMP0031ApiController.getSaleForecasts()

var pm_ajax_getBiweeklies = 'pm.ajax.get-biweeklies'; //uri: /pm/ajax/pmp0031/get-biweeklies -> App\Http\Controllers\PM\Api\PMP0031ApiController.getBiweeklies()

var pm_ajax_pmp0031_openJob = 'pm.ajax.pmp0031.open-Job'; //uri: /pm/ajax/pmp0031/open-Job -> App\Http\Controllers\PM\Api\PMP0031ApiController.openJob()

var pm_pmp0031_index = 'pm.pmp-0031.index'; //uri: /pm/pmp_0031 -> App\Http\Controllers\PM\PMP0031Controller.index()

var om_claim_claimApprove_index = 'om.claim/claim-approve.index'; //uri: /om/claim/claim-approve -> App\Http\Controllers\OM\Web\ClaimApproveController.index()

var om_claim_requestForChange_requestForChange = 'om.claim/request-for-change.requestForChange'; //uri: /om/claim/request-for-change -> App\Http\Controllers\OM\Web\ClaimApproveController.requestForChange()

var om_claim_requestForChange_requestPdf = 'om.claim/request-for-change.requestPdf'; //uri: /om/claim/request-for-change/v1/print-pdf -> App\Http\Controllers\OM\Web\ClaimApproveController.requestPdf()

var om_claim_requestForChange_requestClaimPdf = 'om.claim/request-for-change.requestClaimPdf'; //uri: /om/claim/request-for-change/v1/print-claim-pdf -> App\Http\Controllers\OM\Web\ClaimApproveController.requestClaimPdf()

var om_api_getClaimNumber = 'om.api.getClaimNumber'; //uri: /om/api/claim/get-claim-number -> App\Http\Controllers\OM\Api\ClaimApproveApiController.getClaimNumber()

var om_api_getListHeader = 'om.api.getListHeader'; //uri: /om/api/claim/get-claim-list -> App\Http\Controllers\OM\Api\ClaimApproveApiController.getListHeader()

var om_api_claimStatusList = 'om.api.claimStatusList'; //uri: /om/api/claim/get-status-list -> App\Http\Controllers\OM\Api\ClaimApproveApiController.claimStatusList()

var om_api_get_claimStatusList = 'om.api.get.claimStatusList'; //uri: /om/api/claim/get-status-list -> App\Http\Controllers\OM\Api\ClaimApproveApiController.claimStatusList()

var om_api_updateHeader = 'om.api.updateHeader'; //uri: /om/api/claim/update-header -> App\Http\Controllers\OM\Api\ClaimApproveApiController.updateHeader()

var om_api_closeHeaderClaim = 'om.api.closeHeaderClaim'; //uri: /om/api/claim/close-header -> App\Http\Controllers\OM\Api\ClaimApproveApiController.closeHeaderClaim()

var om_api_get_listInvoice = 'om.api.get.list-invoice'; //uri: /om/api/claim/list-invoice -> App\Http\Controllers\OM\Api\ClaimApproveApiController.getListInvoice()

var om_api_get_genarateClaimDoc = 'om.api.get.genarateClaimDoc'; //uri: /om/api/claim/gen-claim-doc -> App\Http\Controllers\OM\Api\ClaimApproveApiController.genarateClaimDoc()

var api_om_ = 'api.om.'; //uri: /api/om/track-claim/getSearch -> App\Http\Controllers\OM\Api\TrackClaimController.getSearch()

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "th[data-v-b6fd9ba8],\ntd[data-v-b6fd9ba8] {\n  vertical-align: middle !important;\n  text-align: center;\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_style_index_0_id_b6fd9ba8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_style_index_0_id_b6fd9ba8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_style_index_0_id_b6fd9ba8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/pages/PM0022.vue":
/*!******************************************!*\
  !*** ./resources/js/pm/pages/PM0022.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PM0022_vue_vue_type_template_id_b6fd9ba8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true& */ "./resources/js/pm/pages/PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true&");
/* harmony import */ var _PM0022_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PM0022.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/PM0022.vue?vue&type=script&lang=js&");
/* harmony import */ var _PM0022_vue_vue_type_style_index_0_id_b6fd9ba8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css& */ "./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _PM0022_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PM0022_vue_vue_type_template_id_b6fd9ba8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PM0022_vue_vue_type_template_id_b6fd9ba8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "b6fd9ba8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/PM0022.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/PM0022.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/pm/pages/PM0022.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0022.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_style_index_0_id_b6fd9ba8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=style&index=0&id=b6fd9ba8&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/pm/pages/PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true&":
/*!*************************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_template_id_b6fd9ba8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_template_id_b6fd9ba8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0022_vue_vue_type_template_id_b6fd9ba8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0022.vue?vue&type=template&id=b6fd9ba8&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-lg-12" }, [
        _c("div", { staticClass: "ibox " }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-lg-2 col-sm-4 col-form-label" },
                    [_vm._v("วันที่")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-10" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.reportDate,
                          expression: "reportDate"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "date" },
                      domProps: { value: _vm.reportDate },
                      on: {
                        change: function($event) {
                          return _vm.onRequestDateChanged($event)
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.reportDate = $event.target.value
                        }
                      }
                    })
                  ])
                ])
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox" }, [
          _c("div", { staticClass: "ibox-content" }, [
            _vm.isLoading ? _c("div", [_vm._m(1)]) : _vm._e(),
            _vm._v(" "),
            !_vm.isLoading
              ? _c("div", { staticClass: "table-responsive" }, [
                  _c("table", { staticClass: "table table-bordered" }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.dailyRawMaterials, function(dailyRawMaterial) {
                        return _c(
                          "fragment",
                          { key: dailyRawMaterial.report_id },
                          [
                            _c("tr", [
                              _c("td", { attrs: { colspan: "9" } }, [
                                _vm._v(_vm._s(dailyRawMaterial.itemGroup))
                              ])
                            ]),
                            _vm._v(" "),
                            _vm._l(dailyRawMaterial.reports, function(
                              report,
                              i
                            ) {
                              return _c("tr", [
                                _c("td", [_vm._v(_vm._s(i + 1))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(report.item_desc1))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(report.item_code))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(report.item_desc2))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(report.daily_qty))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(report.out_qty))]),
                                _vm._v(" "),
                                _c("td", [_vm._v(_vm._s(report.uom))]),
                                _vm._v(" "),
                                _c("td", [
                                  _c(
                                    "button",
                                    {
                                      staticClass: "btn btn-w-m btn-default",
                                      attrs: {
                                        type: "button",
                                        "data-toggle": "modal",
                                        "data-target": "#detailReportModal"
                                      },
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.onShowDetailClicked(report)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                            รายละเอียด\n                                        "
                                      )
                                    ]
                                  )
                                ])
                              ])
                            })
                          ],
                          2
                        )
                      }),
                      1
                    )
                  ])
                ])
              : _vm._e()
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        ref: "detailReportModalRef",
        staticClass: "modal bd-example-modal-xl fade",
        attrs: { id: "detailReportModal" }
      },
      [
        _c(
          "div",
          { staticClass: "modal-dialog modal-lg", attrs: { role: "document" } },
          [
            _c("div", { staticClass: "modal-content" }, [
              _vm._m(3),
              _vm._v(" "),
              _c("div", { staticClass: "modal-body" }, [
                _c("div", { staticClass: "ibox-content" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-lg-9 col-sm-12" }, [
                      _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                          [_vm._v("วันที่")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-lg-4" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.reportDate,
                                expression: "reportDate"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: { type: "text", disabled: "disabled" },
                            domProps: { value: _vm.reportDate },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.reportDate = $event.target.value
                              }
                            }
                          })
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _vm._m(4)
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                      _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          { staticClass: "col-lg-6 col-sm-4 col-form-label" },
                          [_vm._v("รายการพัสดุ")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-lg-6" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.currentItemDesc1,
                                expression: "currentItemDesc1"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: { type: "text", disabled: "disabled" },
                            domProps: { value: _vm.currentItemDesc1 },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.currentItemDesc1 = $event.target.value
                              }
                            }
                          })
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-group row" }, [
                        _c("div", { staticClass: "col-lg-6" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.currentItemCode,
                                expression: "currentItemCode"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: { type: "text", disabled: "disabled" },
                            domProps: { value: _vm.currentItemCode },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.currentItemCode = $event.target.value
                              }
                            }
                          })
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-lg-6" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.currentItemDesc2,
                                expression: "currentItemDesc2"
                              }
                            ],
                            staticClass: "form-control",
                            attrs: { type: "text", disabled: "disabled" },
                            domProps: { value: _vm.currentItemDesc2 },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.currentItemDesc2 = $event.target.value
                              }
                            }
                          })
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                      _c(
                        "div",
                        { staticClass: "col-lg-4 ml-auto" },
                        [
                          _c("qrcode-vue", {
                            attrs: { size: 100, level: "H" },
                            model: {
                              value: _vm.currentQRCode,
                              callback: function($$v) {
                                _vm.currentQRCode = $$v
                              },
                              expression: "currentQRCode"
                            }
                          })
                        ],
                        1
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _vm.isReportDetailsLoading ? _c("div", [_vm._m(5)]) : _vm._e(),
                _vm._v(" "),
                !_vm.isReportDetailsLoading
                  ? _c("table", { staticClass: "table table-bordered" }, [
                      _vm._m(6),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.reportDetails, function(reportDetail) {
                          return _c("tr", [
                            _c("td", [
                              _vm._v(_vm._s(reportDetail.machine_name))
                            ]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(reportDetail.origin_qty))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(reportDetail.start_qty))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(reportDetail.used_qty))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(reportDetail.paid_qty))]),
                            _vm._v(" "),
                            _c("td", [
                              _vm._v(_vm._s(reportDetail.machine_qty))
                            ]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(reportDetail.req_qty))]),
                            _vm._v(" "),
                            _c("td", [_vm._v(_vm._s(_vm.currentReport.uom))])
                          ])
                        }),
                        0
                      )
                    ])
                  : _vm._e()
              ])
            ])
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
    return _c("div", { staticClass: "ibox-title" }, [
      _c("div", { staticClass: "text-right" }, [
        _c(
          "button",
          { staticClass: "btn btn-w-m btn-info", attrs: { type: "button" } },
          [
            _c("i", { staticClass: "fa fa-print" }),
            _vm._v(
              "\n                            พิมพ์รายงาน\n                        "
            )
          ]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "sk-spinner sk-spinner-wave" }, [
      _c("div", { staticClass: "sk-rect1" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect2" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect3" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect4" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect5" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("ลำดับที่")]),
        _vm._v(" "),
        _c("th", [_vm._v("พัสดุห่อมวน(Item Category)")]),
        _vm._v(" "),
        _c("th", [_vm._v("รหัสวัตถุดิบ")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "400px" } }, [_vm._v("รายละเอียด")]),
        _vm._v(" "),
        _c("th", [_vm._v("จำนวนต่อวัน")]),
        _vm._v(" "),
        _c("th", [_vm._v("จำนวนที่จ่ายไปแล้ว")]),
        _vm._v(" "),
        _c("th", [_vm._v("หน่วย")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  },
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
        [_c("span", [_vm._v("×")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "text-right col-lg-3" }, [
      _c(
        "button",
        { staticClass: "btn btn-w-m btn-info", attrs: { type: "button" } },
        [
          _c("i", { staticClass: "fa fa-print" }),
          _vm._v(
            "\n                                    พิมพ์รายงาน\n                                "
          )
        ]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "sk-spinner sk-spinner-wave" }, [
      _c("div", { staticClass: "sk-rect1" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect2" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect3" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect4" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect5" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("เครื่องจักร")]),
        _vm._v(" "),
        _c("th", [_vm._v("ปริมาณที่ต้องใช้ตั้งต้น")]),
        _vm._v(" "),
        _c("th", [_vm._v("คงคลังหน้าเครื่องเช้า")]),
        _vm._v(" "),
        _c("th", [_vm._v("ปริมาณที่ต้องใช้")]),
        _vm._v(" "),
        _c("th", [_vm._v("จ่ายไปแล้ว")]),
        _vm._v(" "),
        _c("th", [_vm._v("วางหน้าเครื่องสูงสุด")]),
        _vm._v(" "),
        _c("th", [_vm._v("ปริมาณที่สามารถเบิกได้")]),
        _vm._v(" "),
        _c("th", [_vm._v("หน่วยนับ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/routes.json":
/*!**********************************!*\
  !*** ./resources/js/routes.json ***!
  \**********************************/
/***/ ((module) => {

"use strict";
module.exports = JSON.parse("{\"debugbar.openhandler\":\"/_debugbar/open\",\"debugbar.clockwork\":\"/_debugbar/clockwork/{id}\",\"debugbar.telescope\":\"/_debugbar/telescope/{id}\",\"debugbar.assets.css\":\"/_debugbar/assets/stylesheets\",\"debugbar.assets.js\":\"/_debugbar/assets/javascript\",\"debugbar.cache.delete\":\"/_debugbar/cache/{key}/{tags?}\",\"horizon.stats.index\":\"/horizon/api/stats\",\"horizon.workload.index\":\"/horizon/api/workload\",\"horizon.masters.index\":\"/horizon/api/masters\",\"horizon.monitoring.index\":\"/horizon/api/monitoring\",\"horizon.monitoring.store\":\"/horizon/api/monitoring\",\"horizon.monitoring-tag.paginate\":\"/horizon/api/monitoring/{tag}\",\"horizon.monitoring-tag.destroy\":\"/horizon/api/monitoring/{tag}\",\"horizon.jobs-metrics.index\":\"/horizon/api/metrics/jobs\",\"horizon.jobs-metrics.show\":\"/horizon/api/metrics/jobs/{id}\",\"horizon.queues-metrics.index\":\"/horizon/api/metrics/queues\",\"horizon.queues-metrics.show\":\"/horizon/api/metrics/queues/{id}\",\"horizon.jobs-batches.index\":\"/horizon/api/batches\",\"horizon.jobs-batches.show\":\"/horizon/api/batches/{id}\",\"horizon.jobs-batches.retry\":\"/horizon/api/batches/retry/{id}\",\"horizon.pending-jobs.index\":\"/horizon/api/jobs/pending\",\"horizon.completed-jobs.index\":\"/horizon/api/jobs/completed\",\"horizon.failed-jobs.index\":\"/horizon/api/jobs/failed\",\"horizon.failed-jobs.show\":\"/horizon/api/jobs/failed/{id}\",\"horizon.retry-jobs.show\":\"/horizon/api/jobs/retry/{id}\",\"horizon.jobs.show\":\"/horizon/api/jobs/{id}\",\"horizon.index\":\"/horizon/{view?}\",\"ajax.pm.plans.yearly.get-info\":\"/ajax/pm/plans/yearly/get-info\",\"ajax.pm.plans.yearly.get-source-versions\":\"/ajax/pm/plans/yearly/get-source-versions\",\"ajax.pm.plans.yearly.add-new-header\":\"/ajax/pm/plans/yearly/add-new-header\",\"ajax.pm.plans.yearly.get-sale-plans\":\"/ajax/pm/plans/yearly/get-sale-plans\",\"ajax.pm.plans.yearly.get-lines\":\"/ajax/pm/plans/yearly/get-lines\",\"ajax.pm.plans.yearly.generate-lines\":\"/ajax/pm/plans/yearly/generate-lines\",\"ajax.pm.plans.yearly.store-lines\":\"/ajax/pm/plans/yearly/store-lines\",\"ajax.pm.plans.yearly.submit-approval\":\"/ajax/pm/plans/yearly/submit-approval\",\"ajax.pm.plans.yearly.submit-plan\":\"/ajax/pm/plans/yearly/submit-plan\",\"ajax.pm.plans.yearly.approve\":\"/ajax/pm/plans/yearly/approve\",\"ajax.pm.plans.yearly.reject\":\"/ajax/pm/plans/yearly/reject\",\"ajax.pm.plans.monthly.get-info\":\"/ajax/pm/plans/monthly/get-info\",\"ajax.pm.plans.monthly.get-source-versions\":\"/ajax/pm/plans/monthly/get-source-versions\",\"ajax.pm.plans.monthly.add-new-header\":\"/ajax/pm/plans/monthly/add-new-header\",\"ajax.pm.plans.monthly.get-months\":\"/ajax/pm/plans/monthly/get-months\",\"ajax.pm.plans.monthly.get-sale-plans\":\"/ajax/pm/plans/monthly/get-sale-plans\",\"ajax.pm.plans.monthly.get-lines\":\"/ajax/pm/plans/monthly/get-lines\",\"ajax.pm.plans.monthly.generate-lines\":\"/ajax/pm/plans/monthly/generate-lines\",\"ajax.pm.plans.monthly.store-lines\":\"/ajax/pm/plans/monthly/store-lines\",\"ajax.pm.plans.monthly.submit-plan\":\"/ajax/pm/plans/monthly/submit-plan\",\"ajax.pm.plans.biweekly.get-info\":\"/ajax/pm/plans/biweekly/get-info\",\"ajax.pm.plans.biweekly.get-source-versions\":\"/ajax/pm/plans/biweekly/get-source-versions\",\"ajax.pm.plans.biweekly.add-new-header\":\"/ajax/pm/plans/biweekly/add-new-header\",\"ajax.pm.plans.biweekly.get-months\":\"/ajax/pm/plans/biweekly/get-months\",\"ajax.pm.plans.biweekly.get-biweeks\":\"/ajax/pm/plans/biweekly/get-biweeks\",\"ajax.pm.plans.biweekly.get-lines\":\"/ajax/pm/plans/biweekly/get-lines\",\"ajax.pm.plans.biweekly.generate-lines\":\"/ajax/pm/plans/biweekly/generate-lines\",\"ajax.pm.plans.biweekly.store-lines\":\"/ajax/pm/plans/biweekly/store-lines\",\"ajax.pm.plans.biweekly.submit-approval\":\"/ajax/pm/plans/biweekly/submit-approval\",\"ajax.pm.plans.biweekly.submit-open-order\":\"/ajax/pm/plans/biweekly/submit-open-order\",\"ajax.pm.plans.biweekly.approve\":\"/ajax/pm/plans/biweekly/approve\",\"ajax.pm.plans.biweekly.reject\":\"/ajax/pm/plans/biweekly/reject\",\"ajax.pm.plans.daily.get-info\":\"/ajax/pm/plans/daily/get-info\",\"ajax.pm.plans.daily.get-source-versions\":\"/ajax/pm/plans/daily/get-source-versions\",\"ajax.pm.plans.daily.add-new-header\":\"/ajax/pm/plans/daily/add-new-header\",\"ajax.pm.plans.daily.get-months\":\"/ajax/pm/plans/daily/get-months\",\"ajax.pm.plans.daily.get-biweeks\":\"/ajax/pm/plans/daily/get-biweeks\",\"ajax.pm.plans.daily.get-weeks\":\"/ajax/pm/plans/daily/get-weeks\",\"ajax.pm.plans.daily.get-lines\":\"/ajax/pm/plans/daily/get-lines\",\"ajax.pm.plans.daily.generate-lines\":\"/ajax/pm/plans/daily/generate-lines\",\"ajax.pm.plans.daily.get-remianing-items\":\"/ajax/pm/plans/daily/get-remianing-items\",\"ajax.pm.plans.daily.store-line\":\"/ajax/pm/plans/daily/store-line\",\"ajax.pm.plans.daily.add-new-machine-line\":\"/ajax/pm/plans/daily/add-new-machine-line\",\"ajax.pm.plans.daily.add-new-line\":\"/ajax/pm/plans/daily/add-new-line\",\"ajax.pm.plans.daily.delete-machine-line\":\"/ajax/pm/plans/daily/delete-machine-line\",\"ajax.pm.plans.daily.delete-line\":\"/ajax/pm/plans/daily/delete-line\",\"ajax.pm.plans.daily.submit-plan\":\"/ajax/pm/plans/daily/submit-plan\",\"ajax.pm.products.machine-requests.get-requests\":\"/ajax/pm/products/machine-requests/get-requests\",\"ajax.pm.products.machine-requests.generate-requests\":\"/ajax/pm/products/machine-requests/generate-requests\",\"ajax.pm.products.machine-requests.store-requests\":\"/ajax/pm/products/machine-requests/store-requests\",\"ajax.pm.products.machine-requests.export-pdf\":\"/ajax/pm/products/machine-requests/export-pdf\",\"ajax.pm.products.transfers.find-header\":\"/ajax/pm/products/transfers/find-header\",\"ajax.pm.products.transfers.get-headers\":\"/ajax/pm/products/transfers/get-headers\",\"ajax.pm.products.transfers.store-header\":\"/ajax/pm/products/transfers/store-header\",\"ajax.pm.products.transfers.get-lines\":\"/ajax/pm/products/transfers/get-lines\",\"ajax.pm.products.transfers.get-confirm-items\":\"/ajax/pm/products/transfers/get-confirm-items\",\"ajax.pm.products.transfers.get-onhands\":\"/ajax/pm/products/transfers/get-onhands\",\"ajax.pm.products.transfers.store-lines\":\"/ajax/pm/products/transfers/store-lines\",\"ajax.pm.products.transfers.confirm-request\":\"/ajax/pm/products/transfers/confirm-request\",\"ajax.pm.products.transfers.discard-confirmed-request\":\"/ajax/pm/products/transfers/discard-confirmed-request\",\"ajax.pm.products.transfers.cancel-request\":\"/ajax/pm/products/transfers/cancel-request\",\"ajax.pm.products.transfers.submit-request\":\"/ajax/pm/products/transfers/submit-request\",\"api.db.lookup\":\"/api/lookup\",\"outstanding-test.index\":\"/api/outstanding-test\",\"api.kms.expense-all\":\"/api/kms/expense-all/type/{type}/budget-year/{budgetYear}/period/{periodNo}\",\"api.kms.expense-dept\":\"/api/kms/expense-dept/department/{department}/budget-year/{budgetYear}/period/{periodNo}\",\"api.pd.lookup\":\"/api/pd/lookup/{table}\",\"api.pd.\":\"/api/pd/flavor-no\",\"api.pd.flavor-no.search\":\"/api/pd/flavor-no/search\",\"api.pd.flavor-no.store\":\"/api/pd/flavor-no/store\",\"api.pd.inv-material-item.update\":\"/api/pd/0004/{rawMaterialId}\",\"api.pd.inv-material-item.create\":\"/api/pd/flavor-no\",\"api.pd.0004.store\":\"/api/pd/0004\",\"api.pd.0004.show\":\"/api/pd/0004/{inventoryItemId}\",\"api.pd.0004.update\":\"/api/pd/0004/{rawMaterialId}\",\"api.pd.inv-material-item.store\":\"/api/pd/0004\",\"api.pd.inv-material-item.show\":\"/api/pd/0004/{inventoryItemId}\",\"api.pd.0005.search\":\"/api/pd/0005\",\"api.pd.0005.store\":\"/api/pd/0005\",\"api.pd.0005.show\":\"/api/pd/0005/{inventoryItemCode}\",\"api.pd.0005.update\":\"/api/pd/0005/{rawMaterialId}\",\"api.pd.example-cigarettes.search\":\"/api/pd/0005\",\"api.pd.example-cigarettes.store\":\"/api/pd/0005\",\"api.pd.example-cigarettes.show\":\"/api/pd/0005/{inventoryItemCode}\",\"api.pd.example-cigarettes.update\":\"/api/pd/0005/{rawMaterialId}\",\"api.pd.0006.blendFormulae.index\":\"/api/pd/0006/blendFormulae\",\"api.pd.0006.blendFormulae.show\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.0006.blendFormulae.update\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.0006.mfgFormulae.show\":\"/api/pd/0006/mfgFormulae\",\"api.pd.0006.leafFormulae.show\":\"/api/pd/0006/leafFormulae\",\"api.pd.0006.lookupItemNumbers.show\":\"/api/pd/0006/lookupItemNumbers\",\"api.pd.0006.lookupCasings.show\":\"/api/pd/0006/lookupCasings\",\"api.pd.0006.lookupFlavours.show\":\"/api/pd/0006/lookupFlavours\",\"api.pd.0006.lookupExampleCigarettes.show\":\"/api/pd/0006/lookupExampleCigarettes\",\"api.pd.create-trial-tobacco-formula.blendFormulae.index\":\"/api/pd/0006/blendFormulae\",\"api.pd.create-trial-tobacco-formula.blendFormulae.show\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.create-trial-tobacco-formula.blendFormulae.update\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.create-trial-tobacco-formula.mfgFormulae.show\":\"/api/pd/0006/mfgFormulae\",\"api.pd.create-trial-tobacco-formula.leafFormulae.show\":\"/api/pd/0006/leafFormulae\",\"api.pd.create-trial-tobacco-formula.lookupItemNumbers.show\":\"/api/pd/0006/lookupItemNumbers\",\"api.pd.create-trial-tobacco-formula.lookupCasings.show\":\"/api/pd/0006/lookupCasings\",\"api.pd.create-trial-tobacco-formula.lookupFlavours.show\":\"/api/pd/0006/lookupFlavours\",\"api.pd.create-trial-tobacco-formula.lookupExampleCigarettes.show\":\"/api/pd/0006/lookupExampleCigarettes\",\"api.pd.expanded-tobacco.index\":\"/api/pd/expanded-tobacco\",\"api.pd.expanded-tobacco.create\":\"/api/pd/expanded-tobacco/create\",\"api.pd.expanded-tobacco.store\":\"/api/pd/expanded-tobacco\",\"api.pd.expanded-tobacco.show\":\"/api/pd/expanded-tobacco/{expanded_tobacco}\",\"api.pd.expanded-tobacco.edit\":\"/api/pd/expanded-tobacco/{expanded_tobacco}/edit\",\"api.pd.expanded-tobacco.update\":\"/api/pd/expanded-tobacco/{expanded_tobacco}\",\"api.pd.expanded-tobacco.destroy\":\"/api/pd/expanded-tobacco/{expanded_tobacco}\",\"api.pd.0009.search\":\"/api/pd/0009/search\",\"api.pm.0001.search\":\"/api/pm/0001/search\",\"api.pm.0001.uom\":\"/api/pm/0001/uom\",\"api.pm.0001.store\":\"/api/pm/0001\",\"api.pm.0001.update\":\"/api/pm/0001\",\"api.pm.production-order.search\":\"/api/pm/0001/search\",\"api.pm.production-order.uom\":\"/api/pm/0001/uom\",\"api.pm.production-order.store\":\"/api/pm/0001\",\"api.pm.production-order.update\":\"/api/pm/0001\",\"api.pm.ajax.production-order.batchStatus\":\"/api/pm/ajax/batchStatus\",\"api.pm.ajax.production-order.jobType\":\"/api/pm/ajax/jobType\",\"api.pm.0005.index\":\"/api/pm/0005/index/{id?}\",\"api.pm.0005.lines\":\"/api/pm/0005/lines/{id?}\",\"api.pm.0005.save\":\"/api/pm/0005/save\",\"api.pm.0005.confirmTransfer\":\"/api/pm/0005/confirmTransfer\",\"api.pm.request-materials.index\":\"/api/pm/0005/index/{id?}\",\"api.pm.request-materials.lines\":\"/api/pm/0005/lines/{id?}\",\"api.pm.request-materials.save\":\"/api/pm/0005/save\",\"api.pm.request-materials.confirmTransfer\":\"/api/pm/0005/confirmTransfer\",\"api.pm.0005-2.index\":\"/api/pm/0005-2/index/{id?}\",\"api.pm.0005-2.lines\":\"/api/pm/0005-2/lines/{id?}\",\"api.pm.0005-2.save\":\"/api/pm/0005-2/save\",\"api.pm.0005-2.confirmTransfer\":\"/api/pm/0005-2/confirmTransfer\",\"api.pm.0006.jobs.index\":\"/api/pm/0006/jobs\",\"api.pm.0006.jobs.show\":\"/api/pm/0006/jobs/{batchNo}\",\"api.pm.0006.jobLines.show\":\"/api/pm/0006/jobLines\",\"api.pm.0006.jobLines.update\":\"/api/pm/0006/jobLines\",\"api.pm.0006.importMesData\":\"/api/pm/0006/importMesData/{id}\",\"api.pm.report-product-in-process.jobs.index\":\"/api/pm/0006/jobs\",\"api.pm.report-product-in-process.jobs.show\":\"/api/pm/0006/jobs/{batchNo}\",\"api.pm.report-product-in-process.jobLines.show\":\"/api/pm/0006/jobLines\",\"api.pm.report-product-in-process.jobLines.update\":\"/api/pm/0006/jobLines\",\"api.pm.report-product-in-process.importMesData\":\"/api/pm/0006/importMesData/{id}\",\"api.pm.0007.show\":\"/api/pm/0007\",\"api.pm.0007.lookupTransactionDate\":\"/api/pm/0007/lookupTransactionDate\",\"api.pm.0007.save\":\"/api/pm/0007/save\",\"api.pm.0007.cutIssue\":\"/api/pm/0007/cutIssue\",\"api.pm.cut-raw-material.show\":\"/api/pm/0007\",\"api.pm.cut-raw-material.lookupTransactionDate\":\"/api/pm/0007/lookupTransactionDate\",\"api.pm.cut-raw-material.save\":\"/api/pm/0007/save\",\"api.pm.cut-raw-material.cutIssue\":\"/api/pm/0007/cutIssue\",\"api.pm.\":\"/api/pm/transaction-pkg-product\",\"api.pm.review-complete.index\":\"/api/pm/review-complete\",\"api.pm.review-complete.search\":\"/api/pm/review-complete/search\",\"api.pm.review-complete.save\":\"/api/pm/review-complete/save\",\"api.pm.0011.index\":\"/api/pm/review-complete\",\"api.pm.0011.search\":\"/api/pm/review-complete/search\",\"api.pm.0011.save\":\"/api/pm/review-complete/save\",\"api.pm.planning-job-lines.lines\":\"/api/pm/planning-job-lines/lines\",\"api.pm.planning-job-lines.lookupBlendNo\":\"/api/pm/planning-job-lines/lookupBlendNo\",\"api.pm.planning-job-lines.updateLines\":\"/api/pm/planning-job-lines/updateLines\",\"api.pm.0011.lines\":\"/api/pm/planning-job-lines/lines\",\"api.pm.0011.lookupBlendNo\":\"/api/pm/planning-job-lines/lookupBlendNo\",\"api.pm.0011.updateLines\":\"/api/pm/planning-job-lines/updateLines\",\"api.pm.0018.\":\"/api/pm/0018\",\"api.pm.0019.\":\"/api/pm/0019/{id}\",\"api.pm.0020.show\":\"/api/pm/0020/{id}\",\"api.pm.0020.update\":\"/api/pm/0020/{id}\",\"api.pm.0020.store\":\"/api/pm/0020\",\"api.pm.0020.lines\":\"/api/pm/0020/lines\",\"api.pm.machine-ingredient-requests.show\":\"/api/pm/0020/{id}\",\"api.pm.machine-ingredient-requests.update\":\"/api/pm/0020/{id}\",\"api.pm.machine-ingredient-requests.store\":\"/api/pm/0020\",\"api.pm.machine-ingredient-requests.lines\":\"/api/pm/0020/lines\",\"api.pm.0021.index\":\"/api/pm/0021\",\"api.pm.ingredient-requests.index\":\"/api/pm/0021\",\"api.pm.0022.index\":\"/api/pm/0022\",\"api.pm.0022.reports\":\"/api/pm/0022/reports/{id}\",\"api.pm.ingredient-preparation-list.index\":\"/api/pm/0022\",\"api.pm.ingredient-preparation-list.reports\":\"/api/pm/0022/reports/{id}\",\"api.pm.0023.rawMaterials\":\"/api/pm/0023/rawMaterials/{id}\",\"api.pm.0023.compareRawMaterials\":\"/api/pm/0023/compareRawMaterials\",\"api.pm.transaction-pnk-check-material.rawMaterials\":\"/api/pm/0023/rawMaterials/{id}\",\"api.pm.transaction-pnk-check-material.compareRawMaterials\":\"/api/pm/0023/compareRawMaterials\",\"api.pm.0027.index\":\"/api/pm/0027\",\"api.pm.0027.show\":\"/api/pm/0027/{date}\",\"api.pm.0027.update\":\"/api/pm/0027/{date}\",\"api.pm.0027.delete\":\"/api/pm/0027\",\"api.pm.sample-cigarettes.index\":\"/api/pm/0027\",\"api.pm.sample-cigarettes.show\":\"/api/pm/0027/{date}\",\"api.pm.sample-cigarettes.update\":\"/api/pm/0027/{date}\",\"api.pm.sample-cigarettes.delete\":\"/api/pm/0027\",\"api.pm.0028.getProductByDate\":\"/api/pm/0028/{date}\",\"api.pm.0028.update\":\"/api/pm/0028/{date}\",\"api.pm.0028.deleteLines\":\"/api/pm/0028\",\"api.pm.free-products.getProductByDate\":\"/api/pm/0028/{date}\",\"api.pm.free-products.update\":\"/api/pm/0028/{date}\",\"api.pm.free-products.deleteLines\":\"/api/pm/0028\",\"api.pm.0031.index\":\"/api/pm/0031\",\"api.pm.0031.get-batches\":\"/api/pm/0031/get-batches\",\"api.pm.0031.get-list-batch-headers\":\"/api/pm/0031/get-list-batch-headers\",\"api.pm.0031.get-wip-steps\":\"/api/pm/0031/get-wip-steps\",\"api.pm.0031.search\":\"/api/pm/0031/search\",\"api.pm.0031.save\":\"/api/pm/0031/save\",\"api.pm.0032.index\":\"/api/pm/0032\",\"api.pm.0032.show\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.0032.store\":\"/api/pm/0032\",\"api.pm.0032.update\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.0032.search\":\"/api/pm/0032/search\",\"api.pm.0032.transferStamp\":\"/api/pm/0032/transfer\",\"api.pm.0032.deleteLines\":\"/api/pm/0032/lines\",\"api.pm.stamp-using.index\":\"/api/pm/0032\",\"api.pm.stamp-using.show\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.stamp-using.store\":\"/api/pm/0032\",\"api.pm.stamp-using.update\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.stamp-using.search\":\"/api/pm/0032/search\",\"api.pm.stamp-using.transferStamp\":\"/api/pm/0032/transfer\",\"api.pm.stamp-using.deleteLines\":\"/api/pm/0032/lines\",\"api.pm.0033.get\":\"/api/pm/0033\",\"api.pm.0033.update-stamp-usage\":\"/api/pm/0033\",\"api.pm.0033.use-stamp\":\"/api/pm/0033/useStamp\",\"api.pm.confirm-stamp-using.get\":\"/api/pm/0033\",\"api.pm.confirm-stamp-using.update-stamp-usage\":\"/api/pm/0033\",\"api.pm.confirm-stamp-using.use-stamp\":\"/api/pm/0033/useStamp\",\"api.pm.0036.index\":\"/api/pm/0036\",\"api.pm.0036.job-opt-relations\":\"/api/pm/0036/jobOptRelations\",\"api.pm.0036.close-batch\":\"/api/pm/0036/closeBatch\",\"api.pm.close-product-order.index\":\"/api/pm/0036\",\"api.pm.close-product-order.job-opt-relations\":\"/api/pm/0036/jobOptRelations\",\"api.pm.close-product-order.close-batch\":\"/api/pm/0036/closeBatch\",\"api.pm.0038.\":\"/api/pm/0038/close-job\",\"api.pm.0038.cancel-close-job\":\"/api/pm/0038/cancel-close-job\",\"api.pm.0038.product-detail\":\"/api/pm/0038/product-detail\",\"api.pm.0041.index\":\"/api/pm/0041\",\"api.pm.0041.updateExamineCasing\":\"/api/pm/0041/updateExamineCasing\",\"api.pm.0041.updateExpirationDate\":\"/api/pm/0041/updateExpirationDate\",\"api.pm.examine-casing-after-expiry-date.index\":\"/api/pm/0041\",\"api.pm.examine-casing-after-expiry-date.updateExamineCasing\":\"/api/pm/0041/updateExamineCasing\",\"api.pm.examine-casing-after-expiry-date.updateExpirationDate\":\"/api/pm/0041/updateExpirationDate\",\"api.pm.0042.index\":\"/api/pm/0042\",\"api.pm.0042.approveRequest\":\"/api/pm/0042/approveRequest\",\"api.pm.0042.rejectRequest\":\"/api/pm/0042/rejectRequest\",\"api.pm.0043.\":\"/api/pm/0043\",\"api.pm.0045.approveRequest\":\"/api/pm/0045/approveRequest\",\"api.pm.0045.cancelRequest\":\"/api/pm/0045/cancelRequest\",\"api.pm.0045.\":\"/api/pm/0045/{id}\",\"api.pm.examine-after-manufactured.approveRequest\":\"/api/pm/0045/approveRequest\",\"api.pm.examine-after-manufactured.cancelRequest\":\"/api/pm/0045/cancelRequest\",\"api.pm.examine-after-manufactured.\":\"/api/pm/0045/{id}\",\"api.pm.test/pat.get\":\"/api/pm/test/pat\",\"ajax.roles.get-menu-by-module\":\"/ajax/roles/get-menu-by-module\",\"ajax.roles.get-permission\":\"/ajax/roles/get-permission\",\"ajax.roles.assign-permission\":\"/ajax/roles/{role}/assign-permission\",\"ajax.roles.store\":\"/ajax/roles\",\"ajax.roles.update\":\"/ajax/roles/{role}\",\"ajax.users.store\":\"/ajax/users\",\"ajax.users.update\":\"/ajax/users/{user}\",\"ajax.users.get-user\":\"/ajax/users/get-user\",\"ajax.users.get-department\":\"/ajax/users/get-department\",\"ajax.users.get-oa-user\":\"/ajax/users/get-oa-user\",\"ajax.users.get-role\":\"/ajax/users/get-role\",\"menus.index\":\"/menus\",\"menus.create\":\"/menus/create\",\"menus.store\":\"/menus\",\"menus.edit\":\"/menus/{menu}/edit\",\"menus.update\":\"/menus/{menu}\",\"users.permissions\":\"/users/{user}/permissions\",\"users.assign-permission\":\"/users/{user}/assign-permission\",\"users.change-deparment\":\"/users/{user}/change-deparment\",\"users.change-org\":\"/users/{user}/change-org\",\"users.index\":\"/users\",\"users.create\":\"/users/create\",\"users.edit\":\"/users/{user}/edit\",\"roles.index\":\"/roles\",\"roles.create\":\"/roles/create\",\"roles.edit\":\"/roles/{role}/edit\",\"home\":\"/home\",\"funds.index\":\"/inquiry-funds\",\"funds.show\":\"/inquiry-funds\",\"program.type.index\":\"/program/type\",\"program.type.create\":\"/program/type/create\",\"program.type.store\":\"/program/type\",\"program.type.edit\":\"/program/type/{program_type}/edit\",\"program.type.update\":\"/program/type/update\",\"program.info.index\":\"/program/info\",\"program.info.create\":\"/program/info/create\",\"program.info.store\":\"/program/info\",\"program.info.edit\":\"/program/info/{program_code}/edit\",\"program.info.update\":\"/program/info/update\",\"lookup.index\":\"/lookup\",\"lookup.create\":\"/lookup/create\",\"lookup.store\":\"/lookup\",\"lookup.edit\":\"/lookup/{lookup}/edit\",\"lookup.update\":\"/lookup/{lookup}\",\"lookup.delete\":\"/lookup/{lookup}\",\"set-up.index\":\"/set-up\",\"set-up.show\":\"/set-up/{program_code}/show\",\"set-up.update\":\"/set-up/{program_code}/{column_name}\",\"running-number.index\":\"/running-number\",\"running-number.create\":\"/running-number/create\",\"running-number.store\":\"/running-number\",\"running-number.edit\":\"/running-number/{running_number}/edit\",\"running-number.update\":\"/running-number/{running_number}\",\"logout\":\"/logout\",\"login\":\"/login\",\"register\":\"/register\",\"password.request\":\"/password/reset\",\"password.email\":\"/password/email\",\"password.reset\":\"/password/reset/{token}\",\"password.update\":\"/password/reset\",\"password.confirm\":\"/password/confirm\",\"example.ajax.users.index\":\"/example/ajax/users\",\"example.users.export-excel\":\"/example/users/export-excel\",\"example.users.export-pdf\":\"/example/users/export-pdf\",\"example.users.interface\":\"/example/users/{user}/interface\",\"example.users.interface-error\":\"/example/users/interface-error\",\"example.users.index\":\"/example/users\",\"example.users.create\":\"/example/users/create\",\"example.users.store\":\"/example/users\",\"example.users.show\":\"/example/users/{user}\",\"example.users.edit\":\"/example/users/{user}/edit\",\"example.users.update\":\"/example/users/{user}\",\"example.users.destroy\":\"/example/users/{user}\",\"pd.ajax.\":\"/pd/ajax/ohhand-tobacco-forewarn/search\",\"pd.settings.simu-raw-material.index\":\"/pd/settings/simu-raw-material\",\"pd.settings.simu-raw-material.create\":\"/pd/settings/simu-raw-material/create\",\"pd.settings.simu-raw-material.store\":\"/pd/settings/simu-raw-material\",\"pd.settings.simu-raw-material.edit\":\"/pd/settings/simu-raw-material/{simu_raw_id}/edit\",\"pd.settings.simu-raw-material.update\":\"/pd/settings/simu-raw-material/{simu_raw_id}\",\"pd.settings.simu-raw-material.delete\":\"/pd/settings/simu-raw-material/{simu_raw_id}\",\"pd.settings.simu-raw-material.createInv\":\"/pd/settings/simu-raw-material/{simu_raw_id}/create-inv\",\"pd.settings.ohhand-tobacco-forewarn.index\":\"/pd/settings/ohhand-tobacco-forewarn\",\"pd.settings.ohhand-tobacco-forewarn.store\":\"/pd/settings/ohhand-tobacco-forewarn/store\",\"pd.settings.ohhand-tobacco-forewarn.update\":\"/pd/settings/ohhand-tobacco-forewarn/store/update/{forewarn_id}/{inventory_item_id}\",\"pd.0001.index\":\"/pd/0001\",\"pd.casing-simu-additive.index\":\"/pd/0001\",\"pd.0002.index\":\"/pd/0002\",\"pd.flavor-simu-additive.index\":\"/pd/0002\",\"pd.0003.index\":\"/pd/0003\",\"pd.pd-0003.index\":\"/pd/0003\",\"pd.0004.index\":\"/pd/0004\",\"pd.0004.show\":\"/pd/0004/{inventoryItemId}\",\"pd.inv-material-items.index\":\"/pd/0004\",\"pd.inv-material-items.show\":\"/pd/0004/{inventoryItemId}\",\"pd.0005.index\":\"/pd/0005\",\"pd.0005.show\":\"/pd/0005/{inventoryItemCode}\",\"pd.example-cigarettes.index\":\"/pd/0005\",\"pd.example-cigarettes.show\":\"/pd/0005/{inventoryItemCode}\",\"pd.0006.index\":\"/pd/0006\",\"pd.0006.show\":\"/pd/0006/{blendId}\",\"pd.0007.index\":\"/pd/0007\",\"pd.0008.index\":\"/pd/0008\",\"pd.0010.index\":\"/pd/0010\",\"pd.0011.index\":\"/pd/0011\",\"pd.0012.index\":\"/pd/0012\",\"pd.0013.index\":\"/pd/0013\",\"pd.0009.index\":\"/pd/0009/{id?}\",\"pd.0009.test\":\"/pd/0009/test\",\"pd.expanded-tobacco.index\":\"/pd/0009/{id?}\",\"pd.expanded-tobacco.test\":\"/pd/0009/test\",\"pd.0014.index\":\"/pd/0014\",\"pd.pd-0014.index\":\"/pd/0014\",\"pm.ajax.\":\"/pm/ajax/print-machine-group/store\",\"pm.ajax.get-organization\":\"/pm/ajax/setup-min-max-by-item/get-organization\",\"pm.ajax.get-locations\":\"/pm/ajax/setup-min-max-by-item/get-locations\",\"pm.ajax.get-item-number\":\"/pm/ajax/setup-min-max-by-item/get-item-number\",\"pm.ajax.get-uom\":\"/pm/ajax/setup-min-max-by-item/get-uom\",\"pm.ajax.destroy\":\"/pm/ajax/setup-min-max-by-item/destroy\",\"pm.ajax.search\":\"/pm/ajax/setup-min-max-by-item/search\",\"pm.ajax.print-conversion.destroy\":\"/pm/ajax/print-conversion/destroy\",\"pm.ajax.max-storage.getUom\":\"/pm/ajax/max-storage/get-uom\",\"pm.settings.material-group.index\":\"/pm/settings/material-group\",\"pm.settings.material-group.create\":\"/pm/settings/material-group/create\",\"pm.settings.material-group.store\":\"/pm/settings/material-group/store\",\"pm.settings.relation-feeder.index\":\"/pm/settings/relation-feeder\",\"pm.settings.relation-feeder.create\":\"/pm/settings/relation-feeder/create\",\"pm.settings.relation-feeder.store\":\"/pm/settings/relation-feeder/store\",\"pm.settings.relation-feeder.edit\":\"/pm/settings/relation-feeder/{machnie_group}/{feeder_code}/edit\",\"pm.settings.relation-feeder.update\":\"/pm/settings/relation-feeder/update\",\"pm.settings.org-tranfer.index\":\"/pm/settings/org-tranfer\",\"pm.settings.org-tranfer.create\":\"/pm/settings/org-tranfer/create\",\"pm.settings.org-tranfer.store\":\"/pm/settings/org-tranfer/store\",\"pm.settings.org-tranfer.edit\":\"/pm/settings/org-tranfer/edit/{id}\",\"pm.settings.org-tranfer.update\":\"/pm/settings/org-tranfer/update\",\"pm.settings.wip-step.index\":\"/pm/settings/wip-step\",\"pm.settings.wip-step.create\":\"/pm/settings/wip-step/create\",\"pm.settings.wip-step.store\":\"/pm/settings/wip-step\",\"pm.settings.wip-step.edit\":\"/pm/settings/wip-step/{id}/edit\",\"pm.settings.wip-step.update\":\"/pm/settings/wip-step/{id}\",\"pm.settings.wip-step.show\":\"/pm/settings/wip-step/{id}/show\",\"pm.settings.production-formula.index\":\"/pm/settings/production-formula\",\"pm.settings.production-formula.create\":\"/pm/settings/production-formula/create\",\"pm.settings.production-formula.store\":\"/pm/settings/production-formula\",\"pm.settings.production-formula.edit\":\"/pm/settings/production-formula/{id}/edit\",\"pm.settings.production-formula.update\":\"/pm/settings/production-formula/{id}\",\"pm.settings.production-formula.show\":\"/pm/settings/production-formula/{id}/show\",\"pm.settings.production-formula.copy\":\"/pm/settings/production-formula/copy/{id}\",\"pm.settings.production-formula.approve\":\"/pm/settings/production-formula/{id}/approve\",\"pm.settings.save-publication-layout.index\":\"/pm/settings/save-publication-layout\",\"pm.settings.save-publication-layout.edit\":\"/pm/settings/save-publication-layout/{id}/edit\",\"pm.settings.save-publication-layout.update\":\"/pm/settings/save-publication-layout/update\",\"pm.settings.machine-relation.index\":\"/pm/settings/machine-relation\",\"pm.settings.machine-relation.create\":\"/pm/settings/machine-relation/create\",\"pm.settings.machine-relation.store\":\"/pm/settings/machine-relation\",\"pm.settings.machine-relation.edit\":\"/pm/settings/machine-relation/{id}/edit\",\"pm.settings.machine-relation.update\":\"/pm/settings/machine-relation/{id}\",\"pm.settings.setup-min-max-by-item.index\":\"/pm/settings/setup-min-max-by-item\",\"pm.settings.setup-min-max-by-item.updateOrCreate\":\"/pm/settings/setup-min-max-by-item/updateOrCreate\",\"pm.settings.setup-transfer.index\":\"/pm/settings/setup-transfer\",\"pm.settings.setup-transfer.edit\":\"/pm/settings/setup-transfer/edit/{id}\",\"pm.settings.setup-transfer.update\":\"/pm/settings/setup-transfer/update\",\"pm.settings.setup-transfer.create\":\"/pm/settings/setup-transfer/create\",\"pm.settings.setup-transfer.store\":\"/pm/settings/setup-transfer/store\",\"pm.settings.print-conversion.index\":\"/pm/settings/print-conversion\",\"pm.settings.print-conversion.createOrUpdate\":\"/pm/settings/print-conversion/createOrUpdate\",\"pm.settings.print-product-type.index\":\"/pm/settings/print-product-type\",\"pm.settings.print-product-type.update\":\"/pm/settings/print-product-type/update\",\"pm.settings.max-storage.index\":\"/pm/settings/max-storage\",\"pm.settings.max-storage.create\":\"/pm/settings/max-storage/create\",\"pm.settings.max-storage.store\":\"/pm/settings/max-storage\",\"pm.settings.max-storage.edit\":\"/pm/settings/max-storage/{id}/edit\",\"pm.settings.max-storage.update\":\"/pm/settings/max-storage/{id}\",\"pm.settings.save-publication-layout.store\":\"/pm/settings/save-publication-layout-store\",\"pm.settings.setup-before-notice.index\":\"/pm/settings/setup-before-notice\",\"pm.settings.setup-before-notice.store\":\"/pm/settings/setup-before-notice\",\"pm.settings.\":\"/pm/settings/print-machine-group\",\"pm.0001.index\":\"/pm/0001\",\"pm.0001.show\":\"/pm/0001\",\"pm.production-order.index\":\"/pm/0001\",\"pm.production-order.show\":\"/pm/0001\",\"pm.0002.index\":\"/pm/0002\",\"pm.request-creation.index\":\"/pm/0002\",\"pm.0003.index\":\"/pm/0003\",\"pm.annual-production-plan.index\":\"/pm/0003\",\"pm.0004.index\":\"/pm/0004\",\"pm.0005.index\":\"/pm/0005/{id?}\",\"pm.request-materials.index\":\"/pm/0005/{id?}\",\"pm.0005-2.index\":\"/pm/0005-2/{id?}\",\"pm.0006.index\":\"/pm/0006\",\"pm.0006.jobs\":\"/pm/0006/jobs/{batchNo}\",\"pm.report-product-in-process.index\":\"/pm/0006\",\"pm.report-product-in-process.jobs\":\"/pm/0006/jobs/{batchNo}\",\"pm.0007.index\":\"/pm/0007\",\"pm.cut-raw-material.index\":\"/pm/0007\",\"pm.0008.index\":\"/pm/0008\",\"pm.inventory-list.index\":\"/pm/0008\",\"pm.0009.index\":\"/pm/0009\",\"pm.test-raw-material.index\":\"/pm/0009\",\"pm.0010.index\":\"/pm/0010\",\"pm.review-complete.index\":\"/pm/0010\",\"pm.0011.index\":\"/pm/0011\",\"pm.planning-job-lines.index\":\"/pm/0011\",\"pm.0012.index\":\"/pm/0012\",\"pm.0013.index\":\"/pm/0013\",\"pm.record-tobacco-usage-zone-c48.index\":\"/pm/0013\",\"pm.0014.index\":\"/pm/0014\",\"pm.0015.index\":\"/pm/0015\",\"pm.regional-tobacco-production-planning.index\":\"/pm/0015\",\"pm.0016.index\":\"/pm/0016\",\"pm.0017.index\":\"/pm/0017\",\"pm.domestic-printing-production-planning.index\":\"/pm/0017\",\"pm.0018.index\":\"/pm/0018\",\"pm.fortnightly-tobacco-production-order.index\":\"/pm/0018\",\"pm.0019.index\":\"/pm/0019\",\"pm.fortnightly-raw-material-request.index\":\"/pm/0019\",\"pm.0020.index\":\"/pm/0020\",\"pm.0020.show\":\"/pm/0020/{id}\",\"pm.machine-ingredient-requests.index\":\"/pm/0020\",\"pm.machine-ingredient-requests.show\":\"/pm/0020/{id}\",\"pm.0021.index\":\"/pm/0021\",\"pm.ingredient-requests.index\":\"/pm/0021\",\"pm.0022.index\":\"/pm/0022\",\"pm.ingredient-preparation-list.index\":\"/pm/0022\",\"pm.0023.index\":\"/pm/0023\",\"pm.0023.rawMaterials\":\"/pm/0023/rawMaterials/{id}\",\"pm.0023.compareRawMaterials\":\"/pm/0023/compareRawMaterials\",\"pm.transaction-pnk-check-material.index\":\"/pm/0023\",\"pm.transaction-pnk-check-material.rawMaterials\":\"/pm/0023/rawMaterials/{id}\",\"pm.transaction-pnk-check-material.compareRawMaterials\":\"/pm/0023/compareRawMaterials\",\"pm.0024.index\":\"/pm/0024\",\"pm.transaction-pnk-material-transfer.index\":\"/pm/0024\",\"pm.0025.index\":\"/pm/0025\",\"pm.confirm-orders.index\":\"/pm/0025\",\"pm.0026.index\":\"/pm/0026\",\"pm.finished-products-storing-record.index\":\"/pm/0026\",\"pm.0027.index\":\"/pm/0027\",\"pm.0027.show\":\"/pm/0027/{date}\",\"pm.sample-cigarettes.index\":\"/pm/0027\",\"pm.sample-cigarettes.show\":\"/pm/0027/{date}\",\"pm.0028.index\":\"/pm/0028\",\"pm.0028.date\":\"/pm/0028/{date}\",\"pm.free-products.index\":\"/pm/0028\",\"pm.free-products.date\":\"/pm/0028/{date}\",\"pm.0029.index\":\"/pm/0029\",\"pm.ingredient-inventory.index\":\"/pm/0029\",\"pm.0030.index\":\"/pm/0030\",\"pm.confirm-production-yield-loss-for-tips.index\":\"/pm/0030\",\"pm.0031.index\":\"/pm/0031\",\"pm.0032.index\":\"/pm/0032\",\"pm.0032.show\":\"/pm/0032/{stampHeaderId}\",\"pm.0032.create\":\"/pm/0032\",\"pm.stamp-using.index\":\"/pm/0032\",\"pm.stamp-using.show\":\"/pm/0032/{stampHeaderId}\",\"pm.stamp-using.create\":\"/pm/0032\",\"pm.0033.index\":\"/pm/0033\",\"pm.confirm-stamp-using.index\":\"/pm/0033\",\"pm.0034.index\":\"/pm/0034\",\"pm.planning-produce-monthly.index\":\"/pm/0034\",\"pm.0035.index\":\"/pm/0035\",\"pm.receive-raw-material-transfer-at-temporary-storage.index\":\"/pm/0035\",\"pm.0036.index\":\"/pm/0036\",\"pm.close-product-order.index\":\"/pm/0036\",\"pm.0037.index\":\"/pm/0037\",\"pm.raw-material-preparation.index\":\"/pm/0037\",\"pm.0038.index\":\"/pm/0038\",\"pm.production-order-list.index\":\"/pm/0038\",\"pm.0039.index\":\"/pm/0039\",\"pm.additive-inventory-alert.index\":\"/pm/additive-inventory-alert\",\"pm.0040.index\":\"/pm/0040\",\"pm.raw-material-inventory-alert.index\":\"/pm/raw-material-inventory-alert\",\"pm.0041.index\":\"/pm/0041\",\"pm.examine-casing-after-expiry-date.index\":\"/pm/0041\",\"pm.0042.index\":\"/pm/0042\",\"pm.approval-casing-new-expiry-date.index\":\"/pm/0042\",\"pm.0043.index\":\"/pm/0043\",\"pm.transfer-finish-goods.index\":\"/pm/0043\",\"pm.0044.index\":\"/pm/0044\",\"pm.0045.index\":\"/pm/0045\",\"pm.dbLookupExample.index\":\"/pm/dbLookupExample\",\"pm.plans.yearly\":\"/pm/plans/yearly\",\"pm.plans.monthly\":\"/pm/plans/monthly\",\"pm.plans.biweekly\":\"/pm/plans/biweekly\",\"pm.plans.daily\":\"/pm/plans/daily\",\"pm.plans.approvals.yearly\":\"/pm/plans/approvals/yearly\",\"pm.plans.approvals.biweekly\":\"/pm/plans/approvals/biweekly\",\"pm.products.machine-requests.index\":\"/pm/products/machine-requests\",\"pm.products.transfers.index\":\"/pm/products/transfers\",\"pm.files.image\":\"/pm/files/image/{module}/{menu}/{feature}/{fileName}\",\"pm.files.image-thumbnail\":\"/pm/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}\",\"pm.files.download\":\"/pm/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}\",\"pp.0000.index\":\"/pp/0000\",\"pp.example.index\":\"/pp/0000\",\"pp.0001.index\":\"/pp/0001\",\"pp.0002.index\":\"/pp/0002\",\"pp.0003.index\":\"/pp/0003\",\"pp.0004.index\":\"/pp/0004\",\"pp.0005.index\":\"/pp/0005\",\"pp.0006.index\":\"/pp/0006\",\"pp.0007.index\":\"/pp/0007\",\"pp.0008.index\":\"/pp/0008\",\"eam.ajax.lov.asset-number\":\"/eam/ajax/lov/assetnumber\",\"eam.ajax.lov.asset-v-asset-number\":\"/eam/ajax/lov/assetv/assetnumber\",\"eam.ajax.lov.child-asset-number\":\"/eam/ajax/lov/child-assetnumber/{p_parent}\",\"eam.ajax.lov.departments\":\"/eam/ajax/lov/departments\",\"eam.ajax.lov.work-request-status\":\"/eam/ajax/lov/work-request-status\",\"eam.ajax.lov.employee\":\"/eam/ajax/lov/employee\",\"eam.ajax.lov.work-request-type\":\"/eam/ajax/lov/work-request-type\",\"eam.ajax.lov.activity-priority\":\"/eam/ajax/lov/activity-priority\",\"eam.ajax.lov.work-request-number\":\"/eam/ajax/lov/work-request-number\",\"eam.ajax.lov.work-order-h-id\":\"/eam/ajax/lov/workorderhvid\",\"eam.ajax.lov.work-order-op-numseq\":\"/eam/ajax/lov/workorderopnumseq\",\"eam.ajax.lov.wip-class\":\"/eam/ajax/lov/wipclass\",\"eam.ajax.lov.dep-resource\":\"/eam/ajax/lov/dep-resource\",\"eam.ajax.lov.status-yn\":\"/eam/ajax/lov/status-yn\",\"eam.ajax.lov.item-inventory\":\"/eam/ajax/lov/item-inventory\",\"eam.ajax.lov.item-nonstock\":\"/eam/ajax/lov/item-nonstock\",\"eam.ajax.lov.material-type\":\"/eam/ajax/lov/material-type\",\"eam.ajax.lov.suvinventory\":\"/eam/ajax/lov/suvinventory\",\"eam.ajax.lov.locatorv\":\"/eam/ajax/lov/locatorv\",\"eam.ajax.lov.asset-activity\":\"/eam/ajax/lov/assetactivity\",\"eam.ajax.lov.issue\":\"/eam/ajax/lov/issue\",\"eam.ajax.lov.work-order-status\":\"/eam/ajax/lov/work-order-status\",\"eam.ajax.lov.work-order-type\":\"/eam/ajax/lov/work-order-type\",\"eam.ajax.lov.shutdown-type\":\"/eam/ajax/lov/shutdown-type\",\"eam.ajax.lov.work-order-re-numseq\":\"/eam/ajax/lov/workorderrenumseq\",\"eam.ajax.lov.work-order-re-resource\":\"/eam/ajax/lov/workorderreresource\",\"eam.ajax.lov.area\":\"/eam/ajax/lov/area\",\"eam.ajax.lov.resource-asset-number\":\"/eam/ajax/lov/resource-asset-number\",\"eam.ajax.lov.asset-group\":\"/eam/ajax/lov/asset-group\",\"eam.ajax.lov.production-organization\":\"/eam/ajax/lov/production-organization\",\"eam.ajax.lov.usage-uom\":\"/eam/ajax/lov/usage-uom\",\"eam.ajax.lov.resource-asset-locator\":\"/eam/ajax/lov/resource-asset-locator\",\"eam.ajax.lov.operation\":\"/eam/ajax/lov/operation\",\"eam.ajax.lov.machine-type\":\"/eam/ajax/lov/machine-type\",\"eam.ajax.lov.period-year\":\"/eam/ajax/lov/period-year\",\"eam.ajax.lov.activity\":\"/eam/ajax/lov/activity\",\"eam.ajax.lov.wo-mt-lot\":\"/eam/ajax/lov/wo-mt-lot\",\"eam.ajax.lov.organization\":\"/eam/ajax/lov/organization\",\"eam.ajax.lov.department-resources\":\"/eam/ajax/lov/department-resources\",\"eam.ajax.lov.asset-resources\":\"/eam/ajax/lov/asset-resources\",\"eam.ajax.lov.request-equip-no\":\"/eam/ajax/lov/request-equip-no\",\"eam.ajax.lov.request-status\":\"/eam/ajax/lov/request-status\",\"eam.ajax.lov.period-name\":\"/eam/ajax/lov/period-name\",\"eam.ajax.lov.resource\":\"/eam/ajax/lov/resource\",\"eam.ajax.lov.job-status\":\"/eam/ajax/lov/jobstatus\",\"eam.ajax.lov.resource-employee\":\"/eam/ajax/lov/resource-employee\",\"eam.ajax.work-requests.permission-approve\":\"/eam/ajax/work-requests/permission-approve\",\"eam.ajax.work-requests.cancel\":\"/eam/ajax/work-requests/cancel/{p_work_request_number}\",\"eam.ajax.work-requests.cancel-approval\":\"/eam/ajax/work-requests/cancel-approval/{p_work_request_number}\",\"eam.ajax.work-requests.store\":\"/eam/ajax/work-requests\",\"eam.ajax.work-requests.update-status\":\"/eam/ajax/work-requests/status\",\"eam.ajax.work-requests.report\":\"/eam/ajax/work-requests/report\",\"eam.ajax.work-requests.send-approve\":\"/eam/ajax/work-requests/send-approve/{p_work_request_id}\",\"eam.ajax.work-requests.search\":\"/eam/ajax/work-requests/search\",\"eam.ajax.work-requests.images.index\":\"/eam/ajax/work-requests/images/{p_work_request_id}\",\"eam.ajax.work-requests.images.upload\":\"/eam/ajax/work-requests/images/{p_work_request_id}\",\"eam.ajax.work-requests.images.delete\":\"/eam/ajax/work-requests/images/{p_attachment_id}\",\"eam.ajax.work-requests.images.show\":\"/eam/ajax/work-requests/images/show/{p_attachment_id}\",\"eam.ajax.work-requests.show\":\"/eam/ajax/work-requests/{p_work_request_number}\",\"eam.ajax.check-on-hand.search\":\"/eam/ajax/check-on-hand/search\",\"eam.ajax.check-on-hand.images\":\"/eam/ajax/check-on-hand/images/{p_item_code}\",\"eam.ajax.check-on-hand.image.upload\":\"/eam/ajax/check-on-hand/image/{p_item_code}\",\"eam.ajax.check-on-hand.image.delete\":\"/eam/ajax/check-on-hand/image/{p_attachment_id}\",\"eam.ajax.check-on-hand.image.show\":\"/eam/ajax/check-on-hand/image/{p_attachment_id}\",\"eam.ajax.check-transaction.search\":\"/eam/ajax/check-transaction/search\",\"eam.ajax.resource-asset.show\":\"/eam/ajax/resource-asset/show/{p_asset_number}\",\"eam.ajax.resource-asset.store\":\"/eam/ajax/resource-asset/save\",\"eam.ajax.resource-asset.asset-category\":\"/eam/ajax/resource-asset/asset-category\",\"eam.ajax.resource-asset.asset-category-subgroup\":\"/eam/ajax/resource-asset/asset-category/sub-group\",\"eam.ajax.resource-asset.asset-category-submachine\":\"/eam/ajax/resource-asset/asset-category/sub-machine\",\"eam.ajax.work-order.head.index\":\"/eam/ajax/work-order/head\",\"eam.ajax.work-order.head.show\":\"/eam/ajax/work-order/head/show/{p_wip_entity_name}\",\"eam.ajax.work-order.head.store\":\"/eam/ajax/work-order/head/save\",\"eam.ajax.work-order.head.delete\":\"/eam/ajax/work-order/head/delete\",\"eam.ajax.work-order.head.unclose\":\"/eam/ajax/work-order/head/unclose\",\"eam.ajax.work-order.head.waiting-confirm\":\"/eam/ajax/work-order/head/waiting-confirm\",\"eam.ajax.work-order.head.update-status\":\"/eam/ajax/work-order/head/status\",\"eam.ajax.work-order.head.close-jp\":\"/eam/ajax/work-order/head/close-jp/{p_wip_entity_name}\",\"eam.ajax.work-order.op.all\":\"/eam/ajax/work-order/op/all/{p_wip_entity_id}\",\"eam.ajax.work-order.op.store\":\"/eam/ajax/work-order/op/save\",\"eam.ajax.work-order.op.delete\":\"/eam/ajax/work-order/op/delete\",\"eam.ajax.work-order.re.all\":\"/eam/ajax/work-order/re/all/{p_wip_entity_id}\",\"eam.ajax.work-order.report\":\"/eam/ajax/work-order/report\",\"eam.ajax.work-order.report.part\":\"/eam/ajax/work-order/report-part\",\"eam.ajax.work-order.re.store\":\"/eam/ajax/work-order/re/save\",\"eam.ajax.work-order.re.delete\":\"/eam/ajax/work-order/re/delete\",\"eam.ajax.work-order.mt.all\":\"/eam/ajax/work-order/mt/all/{p_wip_entity_id}\",\"eam.ajax.work-order.mt.store\":\"/eam/ajax/work-order/mt/save\",\"eam.ajax.work-order.mt.delete\":\"/eam/ajax/work-order/mt/delete\",\"eam.ajax.work-order.mt.return\":\"/eam/ajax/work-order/mt/return\",\"eam.ajax.work-order.mt.issue\":\"/eam/ajax/work-order/mt/issue\",\"eam.ajax.work-order.lb.all\":\"/eam/ajax/work-order/lb/all/{p_wip_entity_id}\",\"eam.ajax.work-order.lb.store\":\"/eam/ajax/work-order/lb/save\",\"eam.ajax.work-order.lb.delete\":\"/eam/ajax/work-order/lb/delete\",\"eam.ajax.work-order.cp.all\":\"/eam/ajax/work-order/cp/all/{p_wip_entity_id}\",\"eam.ajax.work-order.cp.store\":\"/eam/ajax/work-order/cp/save\",\"eam.ajax.work-order.cost.all\":\"/eam/ajax/work-order/cost/all/{p_wip_entity_id}\",\"eam.ajax.work-order.itemcost.get\":\"/eam/ajax/work-order/item-cost\",\"eam.ajax.work-order.itemonhand.get\":\"/eam/ajax/work-order/item-onhand\",\"eam.ajax.work-order.default-wip-class\":\"/eam/ajax/work-order/defaultwipclass\",\"eam.ajax.work-order.report.summary-month\":\"/eam/ajax/work-order/report/summary-month\",\"eam.ajax.work-order.report.summary-month-excel\":\"/eam/ajax/work-order/report/summary-month-excel\",\"eam.ajax.work-order.report.payable\":\"/eam/ajax/work-order/report/payable\",\"eam.ajax.work-order.report.close-wo-jp\":\"/eam/ajax/work-order/report/close-wo-jp\",\"eam.ajax.work-order.report.mnt-history\":\"/eam/ajax/work-order/report/mnt-history\",\"eam.ajax.work-order.report.maintenance-excel\":\"/eam/ajax/work-order/report/maintenance-excel\",\"eam.ajax.work-order.report.purchase-excel\":\"/eam/ajax/work-order/report/purchase-excel\",\"eam.ajax.work-order.report.job-account\":\"/eam/ajax/work-order/report/job-account\",\"eam.ajax.work-order.report.labor-account\":\"/eam/ajax/work-order/report/labor-account\",\"eam.ajax.work-order.report.wo-cost\":\"/eam/ajax/work-order/report/wo-cost\",\"eam.ajax.work-order.report.labor-excel\":\"/eam/ajax/work-order/report/labor-excel\",\"eam.ajax.work-order.report.summary-labor\":\"/eam/ajax/work-order/report/summary-labor\",\"eam.ajax.work-order.report.receipt-mat\":\"/eam/ajax/work-order/report/receipt-mat\",\"eam.ajax.plan.version-plan\":\"/eam/ajax/plan/version_plan/{p_year}\",\"eam.ajax.plan.confirm\":\"/eam/ajax/plan/confirm/{p_plan_id}\",\"eam.ajax.plan.store\":\"/eam/ajax/plan\",\"eam.ajax.plan.search\":\"/eam/ajax/plan/{p_year}/{p_version}\",\"eam.ajax.plan.open-work-order\":\"/eam/ajax/plan/work-order\",\"eam.ajax.plan.delete-line\":\"/eam/ajax/plan/line/{p_plan_id}\",\"eam.ajax.plan.file-import\":\"/eam/ajax/plan/file-import\",\"eam.ajax.bill-materials.show\":\"/eam/ajax/bill-materials\",\"eam.ajax.bill-materials.store\":\"/eam/ajax/bill-materials\",\"eam.ajax.bill-materials.delete-line\":\"/eam/ajax/bill-materials\",\"eam.ajax.bill-materials.confirm\":\"/eam/ajax/bill-materials/{request_equip_no}/confirm\",\"eam.ajax.bill-materials.cancel\":\"/eam/ajax/bill-materials/{request_equip_no}/cancel\",\"eam.ajax.report.issue-mat-excel\":\"/eam/ajax/report/issue-mat-excel\",\"eam.ajax.report.closed-wo\":\"/eam/ajax/report/closed-wo\",\"eam.ajax.report.closed-wo2\":\"/eam/ajax/report/closed-wo2\",\"eam.ajax.report.job-account-del\":\"/eam/ajax/report/job-account-del\",\"eam.ajax.report.request-mat-inv\":\"/eam/ajax/report/request-mat-inv\",\"eam.ajax.report.request-mat-non\":\"/eam/ajax/report/request-mat-non\",\"eam.ajax.report.wo-com-status\":\"/eam/ajax/report/wo-com-status\",\"eam.ajax.report.summary-mat-status\":\"/eam/ajax/report/summary-mat-status\",\"eam.work-requests.create\":\"/eam/work-requests/create\",\"eam.work-requests.index\":\"/eam/work-requests\",\"eam.work-requests.waiting-approve\":\"/eam/work-requests/waiting-approve\",\"eam.work-orders.create\":\"/eam/work-orders/create\",\"eam.work-orders.waiting-open-work\":\"/eam/work-orders/waiting-open-work\",\"eam.work-orders.list-all-repair-jobs\":\"/eam/work-orders/list-all-repair-jobs\",\"eam.work-orders.list-repair-jobs-waiting-close\":\"/eam/work-orders/list-repair-jobs-waiting-close\",\"eam.work-orders.confirmed-list-repair-work\":\"/eam/work-orders/confirmed-list-repair-work\",\"eam.ask-for-information.parts-transferred-warehouse\":\"/eam/ask-for-information/parts-transferred-warehouse\",\"eam.ask-for-information.check-spare-parts-inventory\":\"/eam/ask-for-information/check-spare-parts-inventory\",\"eam.setup.machine\":\"/eam/setup/machine\",\"eam.transaction.preventive-maintenance-plan\":\"/eam/transaction/preventive-maintenance-plan\",\"eam.report.bill-materials\":\"/eam/report/bill-materials\",\"eam.report.summary-month\":\"/eam/report/summary-month\",\"eam.report.summary-month-excel\":\"/eam/report/summary-month-excel\",\"eam.report.issue-mat-excel\":\"/eam/report/issue-mat-excel\",\"eam.report.payable\":\"/eam/report/payable\",\"eam.report.closed-wo\":\"/eam/report/closed-wo\",\"eam.report.closed-wo2\":\"/eam/report/closed-wo2\",\"eam.report.closed-wo-jp\":\"/eam/report/closed-wo-jp\",\"eam.report.mnt-history\":\"/eam/report/mnt-history\",\"eam.report.maintenance\":\"/eam/report/maintenance\",\"eam.report.job-account-del\":\"/eam/report/job-account-del\",\"eam.report.purchase\":\"/eam/report/purchase\",\"eam.report.request-mat-inv\":\"/eam/report/request-mat-inv\",\"eam.report.request-mat-non\":\"/eam/report/request-mat-non\",\"eam.report.job-account\":\"/eam/report/job-account\",\"eam.report.labor-account\":\"/eam/report/labor-account\",\"eam.report.wo-com-status\":\"/eam/report/wo-com-status\",\"eam.report.labor\":\"/eam/report/labor\",\"eam.report.wo-cost\":\"/eam/report/wo-cost\",\"eam.report.summary-labor\":\"/eam/report/summary-labor\",\"eam.report.receipt-mat\":\"/eam/report/receipt-mat\",\"eam.report.summary-mat-status\":\"/eam/report/summary-mat-status\",\"om.ajax.\":\"/om/ajax/debitnote_ranchtran_export/getorderlist\",\"om.ajax.coa-mapping.index\":\"/om/ajax/coa-mapping\",\"om.ajax.vendor.index\":\"/om/ajax/vendor\",\"om.ajax.search-order.index\":\"/om/ajax/search-order\",\"om.ajax.get-order.index\":\"/om/ajax/get-order\",\"om.ajax.get-item-cate.index\":\"/om/ajax/get-item-cate\",\"om.ajax.get-item.index\":\"/om/ajax/get-item\",\"om.ajax.get-bank-branchs.index\":\"/om/ajax/get-bank-branchs\",\"om.ajax.get-check-header.index\":\"/om/ajax/get-check-header\",\"om.ajax.get-check-header-date-to.index\":\"/om/ajax/get-check-header-date-to\",\"om.settings.term.index\":\"/om/settings/term\",\"om.settings.term.create\":\"/om/settings/term/create\",\"om.settings.term.store\":\"/om/settings/term\",\"om.settings.term.edit\":\"/om/settings/term/{term}/edit\",\"om.settings.term.update\":\"/om/settings/term/{term}\",\"om.settings.term-export.index\":\"/om/settings/term-export\",\"om.settings.term-export.create\":\"/om/settings/term-export/create\",\"om.settings.term-export.store\":\"/om/settings/term-export\",\"om.settings.term-export.edit\":\"/om/settings/term-export/{term}/edit\",\"om.settings.term-export.update\":\"/om/settings/term-export/{term}\",\"om.settings.country.index\":\"/om/settings/country\",\"om.settings.country.create\":\"/om/settings/country/create\",\"om.settings.country.store\":\"/om/settings/country\",\"om.settings.country.edit\":\"/om/settings/country/{id}/edit\",\"om.settings.country.update\":\"/om/settings/country/{id}\",\"om.settings.customer.index\":\"/om/settings/customer\",\"om.settings.customer.create\":\"/om/settings/customer/create\",\"om.settings.customer.store\":\"/om/settings/customer\",\"om.settings.customer.edit\":\"/om/settings/customer/{id}/edit\",\"om.settings.customer.update\":\"/om/settings/customer/{id}\",\"om.settings.customer.primary-approval\":\"/om/settings/customer/primary-approval\",\"om.settings.sequence-ecom.index\":\"/om/settings/sequence-ecom\",\"om.settings.sequence-ecom.create\":\"/om/settings/sequence-ecom/create\",\"om.settings.sequence-ecom.store\":\"/om/settings/sequence-ecom\",\"om.settings.sequence-ecom.edit\":\"/om/settings/sequence-ecom/{ecom}/edit\",\"om.settings.sequence-ecom.update\":\"/om/settings/sequence-ecom/{ecom}\",\"om.settings.quota-credit-group.index\":\"/om/settings/quota-credit-group\",\"om.settings.quota-credit-group.create\":\"/om/settings/quota-credit-group/create\",\"om.settings.quota-credit-group.store\":\"/om/settings/quota-credit-group\",\"om.settings.quota-credit-group.edit\":\"/om/settings/quota-credit-group/{id}/edit\",\"om.settings.quota-credit-group.update\":\"/om/settings/quota-credit-group/{id}\",\"om.settings.grant-spacial-case.index\":\"/om/settings/grant-spacial-case\",\"om.settings.grant-spacial-case.create\":\"/om/settings/grant-spacial-case/create\",\"om.settings.grant-spacial-case.store\":\"/om/settings/grant-spacial-case\",\"om.settings.grant-spacial-case.edit\":\"/om/settings/grant-spacial-case/{id}/edit\",\"om.settings.grant-spacial-case.update\":\"/om/settings/grant-spacial-case/{id}\",\"om.settings.grant-spacial-case.delete\":\"/om/settings/grant-spacial-case/{id}\",\"om.settings.authority-list.index\":\"/om/settings/authority-list\",\"om.settings.authority-list.create\":\"/om/settings/authority-list/create\",\"om.settings.authority-list.store\":\"/om/settings/authority-list\",\"om.settings.authority-list.edit\":\"/om/settings/authority-list/{id}/edit\",\"om.settings.authority-list.update\":\"/om/settings/authority-list/{id}\",\"om.settings.over-quota-approval.index\":\"/om/settings/over-quota-approval\",\"om.settings.over-quota-approval.create\":\"/om/settings/over-quota-approval/create\",\"om.settings.over-quota-approval.store\":\"/om/settings/over-quota-approval\",\"om.settings.over-quota-approval.edit\":\"/om/settings/over-quota-approval/{id}/edit\",\"om.settings.over-quota-approval.update\":\"/om/settings/over-quota-approval/{id}\",\"om.settings.over-quota-approval.delete\":\"/om/settings/over-quota-approval/{id}\",\"om.settings.item-weight.index\":\"/om/settings/item-weight\",\"om.settings.item-weight.create\":\"/om/settings/item-weight/create\",\"om.settings.item-weight.store\":\"/om/settings/item-weight\",\"om.settings.item-weight.edit\":\"/om/settings/item-weight/{id}/edit\",\"om.settings.item-weight.update\":\"/om/settings/item-weight/{id}\",\"om.settings.thailand-territory.index\":\"/om/settings/thailand-territory\",\"om.settings.thailand-territory.preview-import\":\"/om/settings/thailand-territory/preview-import\",\"om.settings.thailand-territory.import\":\"/om/settings/thailand-territory/import\",\"om.settings.thailand-territory.download-excel-template\":\"/om/settings/thailand-territory/download-excel-template\",\"om.settings.direct-debit-domestic.index\":\"/om/settings/direct-debit-domestic\",\"om.settings.direct-debit-domestic.create\":\"/om/settings/direct-debit-domestic/create\",\"om.settings.direct-debit-domestic.store\":\"/om/settings/direct-debit-domestic\",\"om.settings.direct-debit-domestic.edit\":\"/om/settings/direct-debit-domestic/{id}/edit\",\"om.settings.direct-debit-domestic.update\":\"/om/settings/direct-debit-domestic/{id}\",\"om.settings.direct-debit-export.index\":\"/om/settings/direct-debit-export\",\"om.settings.direct-debit-export.create\":\"/om/settings/direct-debit-export/create\",\"om.settings.direct-debit-export.store\":\"/om/settings/direct-debit-export\",\"om.settings.direct-debit-export.edit\":\"/om/settings/direct-debit-export/{id}/edit\",\"om.settings.direct-debit-export.update\":\"/om/settings/direct-debit-export/{id}\",\"om.settings.not-auto-release.index\":\"/om/settings/not-auto-release\",\"om.settings.not-auto-release.create\":\"/om/settings/not-auto-release/create\",\"om.settings.not-auto-release.store\":\"/om/settings/not-auto-release\",\"om.settings.not-auto-release.edit\":\"/om/settings/not-auto-release/{id}/edit\",\"om.settings.not-auto-release.update\":\"/om/settings/not-auto-release/{id}\",\"om.settings.approver-order.index\":\"/om/settings/approver-order\",\"om.settings.approver-order.create\":\"/om/settings/approver-order/create\",\"om.settings.approver-order.store\":\"/om/settings/approver-order\",\"om.settings.approver-order.edit\":\"/om/settings/approver-order/{id}/edit\",\"om.settings.approver-order.update\":\"/om/settings/approver-order/{id}\",\"om.settings.account-mapping.index\":\"/om/settings/account-mapping\",\"om.settings.account-mapping.create\":\"/om/settings/account-mapping/create\",\"om.settings.account-mapping.store\":\"/om/settings/account-mapping\",\"om.settings.account-mapping.edit\":\"/om/settings/account-mapping/{id}/edit\",\"om.settings.account-mapping.update\":\"/om/settings/account-mapping/{id}\",\"om.settings.transport-owner.index\":\"/om/settings/transport-owner\",\"om.settings.transport-owner.create\":\"/om/settings/transport-owner/create\",\"om.settings.transport-owner.store\":\"/om/settings/transport-owner\",\"om.settings.transport-owner.edit\":\"/om/settings/transport-owner/{id}/edit\",\"om.settings.transport-owner.update\":\"/om/settings/transport-owner/{id}\",\"om.settings.transport-owner.delete\":\"/om/settings/transport-owner/{id}\",\"om.settings.transportation-route.index\":\"/om/settings/transportation-route\",\"om.settings.transportation-route.create\":\"/om/settings/transportation-route/create\",\"om.settings.transportation-route.store\":\"/om/settings/transportation-route\",\"om.settings.transportation-route.edit\":\"/om/settings/transportation-route/{id}/edit\",\"om.settings.transportation-route.update\":\"/om/settings/transportation-route/{id}\",\"om.settings.transportation-route.delete\":\"/om/settings/transportation-route/{id}\",\"om.settings.order-period.index\":\"/om/settings/order-period\",\"om.settings.order-period.create\":\"/om/settings/order-period/create\",\"om.settings.order-period.store\":\"/om/settings/order-period\",\"om.settings.order-period.edit\":\"/om/settings/order-period/{id}/edit\",\"om.settings.order-period.update\":\"/om/settings/order-period/{id}\",\"om.settings.approver-order-export.index\":\"/om/settings/approver-order-export\",\"om.settings.approver-order-export.create\":\"/om/settings/approver-order-export/create\",\"om.settings.approver-order-export.store\":\"/om/settings/approver-order-export\",\"om.settings.approver-order-export.edit\":\"/om/settings/approver-order-export/{id}/edit\",\"om.settings.approver-order-export.update\":\"/om/settings/approver-order-export/{id}\",\"om.approval-claim.index\":\"/om/approval-claim\",\"om.outstanding.index\":\"/om/outstanding\",\"om.outstanding.getData\":\"/om/outstanding-list\",\"om.outstanding.getYear\":\"/om/outstanding-year\",\"om.improve-fine.index\":\"/om/improve-fine\",\"om.improve-fine.store\":\"/om/improve-fine\",\"om.settings.price-list.index\":\"/om/settings/price-list\",\"om.settings.price-list.create\":\"/om/settings/price-list/create\",\"om.settings.price-list.store\":\"/om/settings/price-list\",\"om.settings.price-list.show\":\"/om/settings/price-list/{id}/show\",\"om.settings.price-list.edit\":\"/om/settings/price-list/{id}/edit\",\"om.settings.price-list.update\":\"/om/settings/price-list/{id}\",\"om.settings.price-list-export.index\":\"/om/settings/price-list-export\",\"om.settings.price-list-export.create\":\"/om/settings/price-list-export/create\",\"om.settings.price-list-export.store\":\"/om/settings/price-list-export\",\"om.settings.price-list-export.show\":\"/om/settings/price-list-export/{id}/show\",\"om.settings.price-list-export.edit\":\"/om/settings/price-list-export/{id}/edit\",\"om.settings.price-list-export.update\":\"/om/settings/price-list-export/{id}\",\"om.ajax.customers.exports.exports.list\":\"/om/ajax/customers/exports/list\",\"om.ajax.customers.exports.exports.type\":\"/om/ajax/customers/exports/type\",\"om.ajax.customers.exports.exports.country\":\"/om/ajax/customers/exports/country\",\"om.ajax.customers.exports.\":\"/om/ajax/customers/exports/delcustomershipping/{id}\",\"om.ajax.customers.exports.foreign.customercontact_list\":\"/om/ajax/customers/exports/customercontact_list/{id}\",\"om.ajax.customers.exports.foreign.customershipping_list\":\"/om/ajax/customers/exports/customershipping_list/{id}\",\"om.ajax.customers.exports.foreign.insertcustomercontact\":\"/om/ajax/customers/exports/insertcustomercontact/{id}\",\"om.ajax.customers.exports.foreign.updatecustomercontact\":\"/om/ajax/customers/exports/updatecustomercontact/{id}\",\"om.ajax.customers.exports.foreign.insertcustomershipping\":\"/om/ajax/customers/exports/insertcustomershipping/{id}\",\"om.ajax.customers.exports.foreign.updatecustomershipping\":\"/om/ajax/customers/exports/updatecustomershipping/{id}\",\"om.ajax.customers.domestics.\":\"/om/ajax/customers/domestics/remove\",\"om.ajax.customers.domestics.domestics.insert.customers\":\"/om/ajax/customers/domestics/insert-customers\",\"om.ajax.customers.domestics.domestics.insert.customers-shipsites\":\"/om/ajax/customers/domestics/insert-customers-shipsites\",\"om.ajax.customers.domestics.domestics.insert.customers-previous\":\"/om/ajax/customers/domestics/insert-customers-previous\",\"om.ajax.customers.domestics.domestics.insert.customers-owner\":\"/om/ajax/customers/domestics/insert-customers-owner\",\"om.ajax.customers.domestics.domestics.insert.customers-contracts\":\"/om/ajax/customers/domestics/insert-customers-contracts\",\"om.ajax.customers.domestics.domestics.insert.customers-contractbooks\":\"/om/ajax/customers/domestics/insert-customers-contractbooks\",\"om.ajax.customers.domestics.domestics.insert.customers-contractgroup\":\"/om/ajax/customers/domestics/insert-customers-contractgroup\",\"om.ajax.customers.domestics.domestics.insert.customers-quota\":\"/om/ajax/customers/domestics/insert-customers-quota\",\"om.ajax.customers.domestics.domestics.update.customers\":\"/om/ajax/customers/domestics/update-customers/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-previous\":\"/om/ajax/customers/domestics/update-customers-previous/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-owner\":\"/om/ajax/customers/domestics/update-customers-owner/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-shipsites\":\"/om/ajax/customers/domestics/update-customers-shipsites/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-quota\":\"/om/ajax/customers/domestics/update-customers-quota/{id}\",\"om.ajax.customers.domestics.previous\":\"/om/ajax/customers/domestics/previous/{id}\",\"om.ajax.customers.domestics.owner\":\"/om/ajax/customers/domestics/owner/{id}\",\"om.ajax.customers.domestics.quota-headers\":\"/om/ajax/customers/domestics/quota-headers/{id}\",\"om.ajax.customers.domestics.ship-sites\":\"/om/ajax/customers/domestics/ship-sites/{id}\",\"om.ajax.customers.domestics.quota.lines.items\":\"/om/ajax/customers/domestics/quota-lines-item/{id}\",\"om.ajax.customers.domestics.province.list\":\"/om/ajax/customers/domestics/province-list/{id}\",\"om.ajax.customers.domestics.city.list\":\"/om/ajax/customers/domestics/city-list/{id}\",\"om.ajax.customers.domestics.district.list\":\"/om/ajax/customers/domestics/district-list/{id}\",\"om.ajax.customers.domestics.postcode\":\"/om/ajax/customers/domestics/postcode/{id}\",\"om.ajax.customers.domestics.get.ship.site.name\":\"/om/ajax/customers/domestics/get-ship-site-name/{id}/{shipid}\",\"om.ajax.customers.domestics.get.customer.name\":\"/om/ajax/customers/domestics/get-customer-name/{id}\",\"om.ajax.customers.domestics.domestics.delete.customers-shipsites\":\"/om/ajax/customers/domestics/delete-customers-shipsites/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-previous\":\"/om/ajax/customers/domestics/delete-customers-previous/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-owner\":\"/om/ajax/customers/domestics/delete-customers-owner/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-contracts\":\"/om/ajax/customers/domestics/delete-customers-contracts/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-contractbooks\":\"/om/ajax/customers/domestics/delete-customers-contractbooks/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-contractgroups\":\"/om/ajax/customers/domestics/delete-customers-contractgroups/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-quota\":\"/om/ajax/customers/domestics/delete-customers-quota/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-quota-line\":\"/om/ajax/customers/domestics/delete-customers-quota-line/{id}\",\"om.ajax.promotions.\":\"/om/ajax/promotions/search-group-product/{itemId}\",\"om.ajax.promotions.store\":\"/om/ajax/promotions/store\",\"om.ajax.promotions.update\":\"/om/ajax/promotions/update\",\"om.ajax.promotions.remove\":\"/om/ajax/promotions/remove\",\"om.ajax.promotions.copy\":\"/om/ajax/promotions/copy\",\"om.ajax.release_credit.\":\"/om/ajax/release-credit/customers/{id}\",\"om.ajax.bank.\":\"/om/ajax/bank/by-short-name/{id}\",\"om.ajax.postpone-delivery.\":\"/om/ajax/postpone-delivery/next-date/{number}\",\"om.ajax.postpone-delivery.period_by_years\":\"/om/ajax/postpone-delivery/period-by-years/{year}\",\"om.ajax.transfer-bi-weekly.\":\"/om/ajax/transfer-bi-weekly-export/sendfactory\",\"om.ajax.overdue-debt.\":\"/om/ajax/overdue-debt/search\",\"om.ajax.overdue-debt.get-customer-name\":\"/om/ajax/overdue-debt/get-customer-name/{id}\",\"om.ajax.fortnightly\":\"/om/ajax/fortnightly/sequence-ecom\",\"om.ajax.fortnightlyupdate.sequence.ecom\":\"/om/ajax/fortnightly/update-sequence-ecom\",\"om.ajax.fortnightlydelete.sequence.ecom\":\"/om/ajax/fortnightly/delete-sequence-ecom\",\"om.ajax.fortnightlyfilter.sequence.ecom\":\"/om/ajax/fortnightly/filter-sequence-ecom\",\"om.ajax.biweeklyupdate.periods\":\"/om/ajax/biweekly/update-periods\",\"om.ajax.biweeklyget.holiday\":\"/om/ajax/biweekly/get-holiday/{number}\",\"om.ajax.biweeklysearch.periods\":\"/om/ajax/biweekly/search-periods/{number}\",\"om.ajax.transfer-monthly.\":\"/om/ajax/transfer-monthly/inportexcel\",\"om.ajax.consignment-clubsearch.consignment\":\"/om/ajax/consignment-club/search-create\",\"om.ajax.consignment-clubget.order.lines\":\"/om/ajax/consignment-club/get-order-lines/{number}\",\"om.ajax.consignment-clubsearch.consignment.club\":\"/om/ajax/consignment-club/search-consignment-club\",\"om.ajax.consignment-clubupdate.consignment.club\":\"/om/ajax/consignment-club/update-consignment-club\",\"om.ajax.sale-confirmationupdate.order\":\"/om/ajax/sale-confirmation/update-order\",\"om.ajax.sale-confirmationsearch\":\"/om/ajax/sale-confirmation/search\",\"om.ajax.sale-confirmationcreate.sale.confirmation\":\"/om/ajax/sale-confirmation/create-sale-confirmation\",\"om.ajax.sale-confirmationcopy.sale.number\":\"/om/ajax/sale-confirmation/copy-sale-number/{number}\",\"om.ajax.sale-confirmationcreate.sale.number\":\"/om/ajax/sale-confirmation/create-sale-number\",\"om.ajax.sale-confirmationupdate.sale.confirmation\":\"/om/ajax/sale-confirmation/update-sale-confirmation\",\"om.ajax.sale-confirmationconfirm.sale.confirmation\":\"/om/ajax/sale-confirmation/confirm-sale-confirmation\",\"om.ajax.sale-confirmationcopy.to.proforma.invoice\":\"/om/ajax/sale-confirmation/copy-to-proforma-invoice\",\"om.ajax.sale-confirmationcheck-cancel\":\"/om/ajax/sale-confirmation/check-cancel/{number}\",\"om.ajax.sale-confirmationcancel\":\"/om/ajax/sale-confirmation/cancel\",\"om.ajax.sale-confirmationcustomer-shipsite\":\"/om/ajax/sale-confirmation/customer-shipsite/{number}\",\"om.ajax.approve-prepare-ordersearch\":\"/om/ajax/approve-prepare-order/search\",\"om.ajax.approve-prepare-ordermanage\":\"/om/ajax/approve-prepare-order/manage\",\"om.ajax.order.approveprepare.search\":\"/om/ajax/order/approveprepara/search\",\"om.ajax.order.approveprepare.search.customer\":\"/om/ajax/order/approveprepara/search/customer\",\"om.ajax.order.approveprepare.confirm\":\"/om/ajax/order/approveprepara/confirm\",\"om.ajax.order.approveprepare.cancel\":\"/om/ajax/order/approveprepara/cancel\",\"om.ajax.order.prepare.run_number\":\"/om/ajax/order/prepare/run-number\",\"om.ajax.order.prepare.data_customer\":\"/om/ajax/order/prepare/data-customer\",\"om.ajax.order.prepare.data_item\":\"/om/ajax/order/prepare/data-item\",\"om.ajax.order.prepare.set_dayamount\":\"/om/ajax/order/prepare/set-dayamount\",\"om.ajax.order.approve.search.item\":\"/om/ajax/order/approve/search\",\"om.ajax.order.approve.submit\":\"/om/ajax/order/approve/approve\",\"om.ajax.order.approve.cancel\":\"/om/ajax/order/approve/cancel\",\"om.ajax.proforma-invoicesearch.sale.number\":\"/om/ajax/proforma-invoice/search-pi-number/{number}\",\"om.ajax.proforma-invoicesearch\":\"/om/ajax/proforma-invoice/search\",\"om.ajax.proforma-invoicecreate.proforma.invoice\":\"/om/ajax/proforma-invoice/create-proforma-invoice/{number}\",\"om.ajax.proforma-invoicemanage.proforma.invoice\":\"/om/ajax/proforma-invoice/manage-proforma-invoice\",\"om.ajax.proforma-invoicecreate.proforma.lot\":\"/om/ajax/proforma-invoice/create-proforma-lot/{number}\",\"om.ajax.proforma-invoiceget.proforma.lot\":\"/om/ajax/proforma-invoice/get-proforma-lot/{number}\",\"om.ajax.proforma-invoicecheck-cancel\":\"/om/ajax/proforma-invoice/check-cancel/{number}\",\"om.ajax.proforma-invoicecancel\":\"/om/ajax/proforma-invoice/cancel\",\"om.ajax.proforma-invoiceupdate-lot\":\"/om/ajax/proforma-invoice/update-lot\",\"om.ajax.proforma-invoicedelete.all.lot\":\"/om/ajax/proforma-invoice/delete-all-lot\",\"om.ajax.tax-invoice-exportcreate\":\"/om/ajax/tax-invoice-export/create\",\"om.ajax.tax-invoice-exportsearch\":\"/om/ajax/tax-invoice-export/search\",\"om.ajax.tax-invoice-exportmanage\":\"/om/ajax/tax-invoice-export/manage\",\"om.ajax.tax-invoice-exportcheck.cancel\":\"/om/ajax/tax-invoice-export/check-cancel/{number}\",\"om.ajax.tax-invoice-exportcancel\":\"/om/ajax/tax-invoice-export/cancel\",\"om.ajax.tax-invoice-exportclose.work\":\"/om/ajax/tax-invoice-export/close-work/{number}\",\"om.ajax.exchange-exportsearch\":\"/om/ajax/exchange-export/search\",\"om.ajax.exchange-exportupdate\":\"/om/ajax/exchange-export/update\",\"om.order.approveprepareapproveprepare.index\":\"/om/order/approveprepare\",\"om.order.approveprepare\":\"/om/ajax/print-receipt/print_data\",\"om.proforma-invoicesearch.sale.number\":\"/om/proforma-invoice/search-pi-number/{number}\",\"om.proforma-invoicecreate.proforma.invoice\":\"/om/ajax/proforma-invoice/create-proforma-invoice/{number}\",\"om.customers.exports.index\":\"/om/customers/exports\",\"om.customers.exports.show\":\"/om/customers/exports/{export}\",\"om.customers.exports.edit\":\"/om/customers/exports/{export}/edit\",\"om.customers.exports.update\":\"/om/customers/exports/{export}\",\"om.customers.approves.\":\"/om/customers/approves/reassign/{id}\",\"om.customers.approves.view\":\"/om/customers/approves/view/{id}\",\"om.customers.domestics-broker\":\"/om/customers/domestics/broker\",\"om.customers.domestics.index\":\"/om/customers/domestics\",\"om.customers.domestics.create\":\"/om/customers/domestics/create\",\"om.customers.domestics.show\":\"/om/customers/domestics/{domestic}\",\"om.customers.detail\":\"/om/customers/domestics/{domestic}\",\"om.release-credit.\":\"/om/release-credit/create\",\"om.release-credit.update\":\"/om/release-credit/update\",\"om.promotions.\":\"/om/transfer-bank/domestic\",\"om.promotions.store-header\":\"/om/promotions/store-header\",\"om.postpone-delivery.\":\"/om/postpone-delivery/search\",\"om.auto.\":\"/om/auto/postpone-delivery\",\"om.\":\"/om/credit-note-other-export\",\"om.addition-index\":\"/om/addition-quota\",\"om.addition-quota\":\"/om/addition-quota/approve/step/{id}/{step}\",\"om.addition-upload\":\"/om/addition-quota/upload/file\",\"om.addition-filesdelete\":\"/om/addition-quota/delete/file\",\"om.addition-quota-update\":\"/om/addition-quota/approve/step/update\",\"om.addition-download\":\"/om/addition-quota/download/files/{id}\",\"om.cancel-consignment\":\"/om/consignment/cancel\",\"om.canceled-consignment\":\"/om/consignment/canceled\",\"om.delivery-rate-index\":\"/om/delivery-rate\",\"om.delivery-rate-service-call\":\"/om/delivery-rate/service/ptt/call/date/{date}\",\"om.delivery-rate-getnewoil\":\"/om/delivery-rate/getnewoil\",\"om.delivery-rate-store\":\"/om/delivery-rate/store\",\"om.delivery-rate-price-new\":\"/om/delivery-rate/count/price/new\",\"om.draft-payout-index\":\"/om/draft-payout\",\"om.draft-payout-listproduct\":\"/om/draft-payout/listproduct\",\"om.draft-payout-storeDraft\":\"/om/draft-payout/storeDraft\",\"om.draft-payout-print\":\"/om/draft-payout/print/{id}\",\"om.domestic-matching-getData\":\"/om/domestic-matching/getData\",\"om.domestic-matching-uploaded\":\"/om/domestic-matching/uploaded\",\"om.domestic-matching-upload-deleted\":\"/om/domestic-matching/uploaded\",\"om.domestic-matching-unmatching\":\"/om/domestic-matching/unmatching\",\"om.domestic-matching-matching\":\"/om/domestic-matching/matching\",\"om.domestic-matching-getinvoice\":\"/om/domestic-matching/getinvoice\",\"om.domestic-matching-getamount\":\"/om/domestic-matching/getamount\",\"om.domestic-matching-upload\":\"/om/domestic-matching/upload\",\"om.domestic-matching-delete\":\"/om/domestic-matching/files/delete\",\"om.domestic-matching-download\":\"/om/domestic-matching/download/files/{id}\",\"om.payment-method-index\":\"/om/payment-method/{type}\",\"om.payment-method-print\":\"/om/payment-method/{type}/{id}\",\"om.payment-method-getlistbank\":\"/om/payment-method/getlistbank\",\"om.payment-method-getinfofordraft\":\"/om/payment-method/getinfofordraft\",\"om.payment-method-getvaluebank\":\"/om/payment-method/getvaluebank\",\"om.payment-method-getpaymentnumber\":\"/om/payment-method/getpaymentnumber\",\"om.payment-method-draftpayment\":\"/om/payment-method/draftpayment\",\"om.payment-method-payment\":\"/om/payment-method/payment\",\"om.payment-method-payment-upload\":\"/om/payment-method/payment/upload\",\"om.payment-method-payment-delete\":\"/om/payment-method/payment/files/delete\",\"om.payment-method-getvaluefromnumber\":\"/om/payment-method/getvaluefromnumber\",\"om.payment-method-paymentverify\":\"/om/payment-method/paymentverify\",\"om.payment-method-payment-upload-remove\":\"/om/payment-method/remove-attachment/{id}\",\"om.payment-method-download\":\"/om/payment-method/download/files/{id}\",\"om.export-payout-index\":\"/om/export-payout\",\"om.export-payout-getlistbank\":\"/om/export-payout/getlistbank\",\"om.export-payout-getvaluebank\":\"/om/export-payout/getvaluebank\",\"om.export-payout-getpaymentnumber\":\"/om/export-payout/getpaymentnumber\",\"om.export-payment-method-draftpayment\":\"/om/export-payout/draftpayment\",\"om.export-method-payment-delete\":\"/om/export-payout/payment/files/delete\",\"om.export-method-payment\":\"/om/export-payout/payment\",\"om.export-method-print\":\"/om/export-payout/print/{id}\",\"om.export-method-getinfofordraft\":\"/om/export-payout/getinfofordraft\",\"om.export-method-getvaluefromnumber\":\"/om/export-payout/getvaluefromnumber\",\"om.export-method-payment-upload\":\"/om/export-payout/payment/upload\",\"om.export-matching-index\":\"/om/export-matching\",\"om.export-matching-unmatching\":\"/om/export-matching/unmatching\",\"om.export-matching-uploaded\":\"/om/export-matching/uploaded\",\"om.export-matching-upload-deleted\":\"/om/export-matching/upload/deleted\",\"om.export-matching-getData\":\"/om/export-matching/getData\",\"om.export-matching-matching\":\"/om/export-matching/matching\",\"om.export-matching-getinvoice\":\"/om/export-matching/getinvoice\",\"om.export-matching-getamount\":\"/om/export-matching/getamount\",\"om.export-matching-getDataexchangerate\":\"/om/export-matching/getDataexchangerate\",\"om.tax-adjust-index\":\"/om/tax-adjust\",\"om.tax-adjust-recivedata\":\"/om/tax-adjust/recivedata\",\"om.tax-adjust-senddata\":\"/om/tax-adjust/senddata\",\"om.sendap-transfer-commission\":\"/om/transfer-commission/sndAP\",\"om.index-transfer-province\":\"/om/transfer-province\",\"om.calculate-transfer-province\":\"/om/transfer-province/calculate\",\"om.close-flag-release\":\"/om/close-flag/release\",\"om.close-flag-process\":\"/om/close-flag/process\",\"om.close-flag-process-export\":\"/om/close-flag/export/process\",\"om.transfer-bi-weekly.\":\"/om/transfer-bi-weekly/domestic/approved\",\"om.overdue-debt.index\":\"/om/overdue-debt\",\"om.overdue-debt.show\":\"/om/overdue-debt/{overdue_debt}\",\"om.sale-confirmation.index\":\"/om/sale-confirmation\",\"om.sale-confirmation.show\":\"/om/sale-confirmation/{sale_confirmation}\",\"om.sequence-fortnightly.index\":\"/om/sequence-fortnightly\",\"om.sequence-fortnightly.show\":\"/om/sequence-fortnightly/{sequence_fortnightly}\",\"om.biweekly-periods.index\":\"/om/biweekly-periods\",\"om.transfer-monthly.\":\"/om/transfer-monthly/domestic\",\"om.order.approvepreparaapproveprepara.index\":\"/om/order/approveprepare\",\"om.order.prepare.order\":\"/om/order/prepare\",\"om.order.prepare.search\":\"/om/order/prepare/search\",\"om.order.prepare.create.show\":\"/om/order/prepare/create\",\"om.order.prepare.prepare.edit\":\"/om/order/prepare/edit/{id}\",\"om.order.prepare.\":\"/om/order/prepare/edit/{id}/submit\",\"om.order.prepare.create.submit\":\"/om/order/prepare/create/submit\",\"om.order.prepare.update.submit\":\"/om/order/prepare/update/submit\",\"om.order.prepare.approve\":\"/om/order/prepare/approve/{id}\",\"om.order.prepare.cancel\":\"/om/order/prepare/cancel/{id}\",\"om.order.prepare.copy\":\"/om/order/prepare/copy/{id}\",\"om.order.approveapprove.index\":\"/om/order/approve\",\"om.get-invoice-header\":\"/om/test\",\"om.get-invoice-header-save\":\"/om/test/save\",\"om.proforma-invoice.index\":\"/om/proforma-invoice\",\"om.proforma-invoice.show\":\"/om/proforma-invoice/{proforma_invoice}\",\"om.tax-invoice-export.index\":\"/om/tax-invoice-export\",\"om.tax-invoice-export.show\":\"/om/tax-invoice-export/{tax_invoice_export}\",\"om.transpot-report-index\":\"/om/transpot-report\",\"om.transpot-report-createDataone\":\"/om/transpot-report/createDataone\",\"om.transpot-report-createDatatwo\":\"/om/transpot-report/createDatatwo\",\"om.order.direct.debit\":\"/om/order-direct-debit/domestic/save\",\"om.consignment\":\"/om/consignment/fillData\",\"om.consignmentgetData\":\"/om/consignment/create\",\"om.invoice.cancel-invoice\":\"/om/invoice/cancel\",\"om.invoice.canceled-invoice\":\"/om/invoice/canceled\",\"om.invoice.getlist-cancel-invoice\":\"/om/invoice/list-cancel-invoice\",\"om.consignment-club.index\":\"/om/consignment-club\",\"om.consignment-club.show\":\"/om/consignment-club/{consignment_club}\",\"om.approve-prepare.index\":\"/om/approve-prepare\",\"om.approve-prepare.show\":\"/om/approve-prepare/{approve_prepare}\",\"om.rma-export.index\":\"/om/rma-export\",\"om.rma-export.show\":\"/om/rma-export/{rma_export}\",\"om.exchange-export.index\":\"/om/exchange-export\",\"om.exchange-export.show\":\"/om/exchange-export/{exchange_export}\",\"om.approve-prepare.print\":\"/om/approve-prepare/print/{id}\",\"om.pao-tax-mt.index\":\"/om/pao-tax-mt\",\"om.pao-tax-mt.search\":\"/om/pao-tax-mt/search\",\"om.pao-tax-mt.validate\":\"/om/pao-tax-mt/validate\",\"om.pao-tax-mt.store\":\"/om/pao-tax-mt/store\",\"om.pao-tax-mt.update\":\"/om/pao-tax-mt/update\",\"om.pao-tax-mt.ex-report\":\"/om/pao-tax-mt/ex-report\",\"ir.ajax.sub-groups.show\":\"/ir/ajax/sub-groups/show/{policy_set_header_id}\",\"ir.ajax.product-groups.updateActiveFlag\":\"/ir/ajax/product-groups/updateActiveFlag\",\"ir.ajax.sub-groups.checkInactive\":\"/ir/ajax/sub-groups/check-inactive\",\"ir.ajax.product-group\":\"/ir/ajax/product-group\",\"ir.ajax.get-locator\":\"/ir/ajax/get-locator\",\"ir.ajax.updateActiveFlag\":\"/ir/ajax/product-header/updateActiveFlag\",\"ir.ajax.destroy\":\"/ir/ajax/destroy\",\"ir.ajax.getValueSet\":\"/ir/ajax/get-value-set\",\"ir.ajax.\":\"/ir/ajax/product-header/getDataActiveFlag\",\"ir.ajax.sub-groups.destroy\":\"/ir/ajax/sub-groups/destroy\",\"ir.settings.product-groups.index\":\"/ir/settings/product-groups\",\"ir.settings.product-groups.create\":\"/ir/settings/product-groups/create\",\"ir.settings.product-groups.store\":\"/ir/settings/product-groups/store\",\"ir.settings.product-groups.update\":\"/ir/settings/product-groups/update\",\"ir.settings.product-groups.edit\":\"/ir/settings/product-groups/{id}/edit\",\"ir.settings.product-header.index\":\"/ir/settings/product-header\",\"ir.settings.product-header.create\":\"/ir/settings/product-header/create\",\"ir.settings.product-header.store\":\"/ir/settings/product-header/store\",\"ir.settings.product-header.search\":\"/ir/settings/product-header/search\",\"ir.settings.product-header.edit\":\"/ir/settings/product-header/{id}/edit\",\"ir.settings.product-header.update\":\"/ir/settings/product-header/update\",\"ir.settings.sub-groups.index\":\"/ir/settings/sub-groups\",\"ir.settings.sub-groups.create\":\"/ir/settings/sub-groups/create\",\"ir.settings.sub-groups.update\":\"/ir/settings/sub-groups/update\",\"ir.settings.sub-groups.store\":\"/ir/settings/sub-groups/store\",\"ir.settings.sub-groups.search\":\"/ir/settings/sub-groups/search\",\"ir.settings.sub-groups.edit\":\"/ir/settings/sub-groups/{id}/edit\",\"ir.ajax.Lov.lov-companies\":\"/ir/ajax/lov/companies\",\"ir.ajax.Lov.lov-vendor\":\"/ir/ajax/lov/vendor\",\"ir.ajax.Lov.lov-branch-code\":\"/ir/ajax/lov/branch-code\",\"ir.ajax.Lov.lov-customer-number\":\"/ir/ajax/lov/customer-number\",\"ir.ajax.Lov.lov-policy-set-header\":\"/ir/ajax/lov/policy-set-header\",\"ir.ajax.Lov.lov-policy-type\":\"/ir/ajax/lov/policy-type\",\"ir.ajax.Lov.lov-account-code-combine\":\"/ir/ajax/lov/account-code-combine\",\"ir.ajax.Lov.lov-gas-stations-groups\":\"/ir/ajax/lov/gas-station-group\",\"ir.ajax.Lov.lov-group\":\"/ir/ajax/lov/group-code\",\"ir.ajax.Lov.lov-policy-category\":\"/ir/ajax/lov/policy-category\",\"ir.ajax.Lov.lov-policy-group-headers\":\"/ir/ajax/lov/policy-group-header\",\"ir.ajax.Lov.lov-premium-rate\":\"/ir/ajax/lov/premium-rate\",\"ir.ajax.Lov.companies-code\":\"/ir/ajax/lov/company-code\",\"ir.ajax.Lov.lov-evm-code\":\"/ir/ajax/lov/evm-code\",\"ir.ajax.Lov.lov-department-code\":\"/ir/ajax/lov/department-code\",\"ir.ajax.Lov.lov-cost-center-code\":\"/ir/ajax/lov/cost-center-code\",\"ir.ajax.Lov.lov-budget-year\":\"/ir/ajax/lov/budget-year\",\"ir.ajax.Lov.lov-budget-type\":\"/ir/ajax/lov/budget-type\",\"ir.ajax.Lov.lov-budget-detail\":\"/ir/ajax/lov/budget-detail\",\"ir.ajax.Lov.lov-budget-reason\":\"/ir/ajax/lov/budget-reason\",\"ir.ajax.Lov.lov-main-account\":\"/ir/ajax/lov/main-account\",\"ir.ajax.Lov.lov-sub-account\":\"/ir/ajax/lov/sub-account\",\"ir.ajax.Lov.lov-reserverd1\":\"/ir/ajax/lov/reserved1\",\"ir.ajax.Lov.lov-reserverd2\":\"/ir/ajax/lov/reserved2\",\"ir.ajax.Lov.lov-license-plate\":\"/ir/ajax/lov/license-plate\",\"ir.ajax.Lov.lov-vehicles-type\":\"/ir/ajax/lov/vehicles-type\",\"ir.ajax.Lov.lov-renew-type\":\"/ir/ajax/lov/renew-type\",\"ir.ajax.Lov.lov-gas-stations-type\":\"/ir/ajax/lov/gas-stations-type\",\"ir.ajax.Lov.lov-status\":\"/ir/ajax/lov/status\",\"ir.ajax.Lov.lov-periods\":\"/ir/ajax/lov/periods\",\"ir.ajax.Lov.lov-group-location\":\"/ir/ajax/lov/group-location\",\"ir.ajax.Lov.lov-sub-group\":\"/ir/ajax/lov/sub-group\",\"ir.ajax.Lov.lov-org\":\"/ir/ajax/lov/org\",\"ir.ajax.Lov.lov-sub-inventory\":\"/ir/ajax/lov/sub-inventory\",\"ir.ajax.Lov.lov-uom\":\"/ir/ajax/lov/uom\",\"ir.ajax.Lov.lov-invoice\":\"/ir/ajax/lov/invoice-type\",\"ir.ajax.Lov.lov-governer-policy-type\":\"/ir/ajax/lov/governer-policy-type\",\"ir.ajax.Lov.lov-invoice-number\":\"/ir/ajax/lov/invoice-number\",\"ir.ajax.Lov.lov-interface-type\":\"/ir/ajax/lov/interface-type\",\"ir.ajax.Lov.lov-interface-gl-type\":\"/ir/ajax/lov/interface-gl-type\",\"ir.ajax.Lov.lov-department-location\":\"/ir/ajax/lov/department-location\",\"ir.ajax.Lov.lov-location\":\"/ir/ajax/lov/location\",\"ir.ajax.Lov.lov-cat-segment1\":\"/ir/ajax/lov/cat-segment1\",\"ir.ajax.Lov.lov-cat-segment3\":\"/ir/ajax/lov/cat-segment3\",\"ir.ajax.Lov.lov-receivable-charge\":\"/ir/ajax/lov/receivable-charge\",\"ir.ajax.Lov.lov-effective-date\":\"/ir/ajax/lov/effective-date\",\"ir.ajax.Lov.lov-exp-asset-stock-type\":\"/ir/ajax/lov/exp-asset-stock-type\",\"ir.ajax.Lov.lov-exp-car-gas-type\":\"/ir/ajax/lov/exp-car-gas-type\",\"ir.ajax.Lov.lov-ar-invoice-num\":\"/ir/ajax/lov/ar-invoice-num\",\"ir.ajax.Lov.lov-policy-vehicle\":\"/ir/ajax/lov/policy-vehicles\",\"ir.ajax.Lov.lov-group-code-policy\":\"/ir/ajax/lov/group-code-policy\",\"ir.ajax.Lov.lov-revision\":\"/ir/ajax/lov/revision\",\"ir.ajax.Lov.lov-budget-period_year\":\"/ir/ajax/lov/budget-period-year\",\"ir.ajax.Lov.lov-asset-status\":\"/ir/ajax/lov/asset-status\",\"ir.ajax.Lov.lov-vehicle-license-plate\":\"/ir/ajax/lov/vehicle-license-plate\",\"ir.ajax.Lov.lov-gas-station-type-master\":\"/ir/ajax/lov/gas-station-type-master\",\"ir.ajax.Lov.lov-claim-document-number\":\"/ir/ajax/lov/claim-document-number\",\"ir.ajax.Lov.lov-gen-company-number\":\"/ir/ajax/lov/gen-company-number\",\"ir.ajax.Lov.lov-claim-policy-number\":\"/ir/ajax/lov/claim-policy-number\",\"ir.ajax.Lov.lov-company-percent\":\"/ir/ajax/lov/company-percent\",\"ir.ajax.Lov.lov-policy-set-header-group\":\"/ir/ajax/lov/policy-set-header-group\",\"ir.ajax.Lov.lov-vehicle-brand\":\"/ir/ajax/lov/vehicle-brand\",\"ir.ajax.Lov.lov-category4\":\"/ir/ajax/lov/category-seg4\",\"ir.ajax.Lov.lov-category5\":\"/ir/ajax/lov/category-seg5\",\"ir.ajax.Lov.lov-asset-group\":\"/ir/ajax/lov/asset-group\",\"ir.ajax.Lov.lov-ap-interface-type\":\"/ir/ajax/lov/ap-interface-type\",\"ir.ajax.Lov.lov-vehicle-rate\":\"/ir/ajax/lov/vehicle-rate\",\"ir.ajax.company-index\":\"/ir/ajax/company\",\"ir.ajax.company-show\":\"/ir/ajax/company/{company_id}\",\"ir.ajax.company-store\":\"/ir/ajax/company\",\"ir.ajax.company-update\":\"/ir/ajax/company\",\"ir.ajax.company-active-flag\":\"/ir/ajax/company/active-flag\",\"ir.ajax.company-check-used-data\":\"/ir/ajax/company/check-used-data/{company_id}\",\"ir.ajax.policy-index\":\"/ir/ajax/policy\",\"ir.ajax.policy-show\":\"/ir/ajax/policy/{policy_set_header_id}\",\"ir.ajax.policy-store\":\"/ir/ajax/policy/save\",\"ir.ajax.policy-update\":\"/ir/ajax/policy/update\",\"ir.ajax.policy-update-active-flag\":\"/ir/ajax/policy/active-flag\",\"ir.ajax.policy-check-used-data\":\"/ir/ajax/policy/check-used-data/{policy_set_header_id}\",\"ir.ajax.policy-group-header-index\":\"/ir/ajax/policy-group\",\"ir.ajax.policy-group-header-overlap-check\":\"/ir/ajax/policy-group/overlap-check\",\"ir.ajax.policy-group-header-show\":\"/ir/ajax/policy-group/{group_header_id}\",\"ir.ajax.policy-group-header-group-dists\":\"/ir/ajax/group-dists\",\"ir.ajax.policy-group-header-store\":\"/ir/ajax/policy-group/save\",\"ir.ajax.policy-group-header-store-index\":\"/ir/ajax/policy-group/save-index\",\"ir.ajax.policy-group-set-delete\":\"/ir/ajax/policy-group/group-sets\",\"ir.ajax.policy-group-header-update-active-flag\":\"/ir/ajax/policy-group/update-active-flag\",\"ir.ajax.policy-group-header-duplicate-check\":\"/ir/ajax/policy-group/duplicate-check/{policy_set_header_id}\",\"ir.ajax.vehicles-index\":\"/ir/ajax/vehicles\",\"ir.ajax.vehicles-show\":\"/ir/ajax/vehicles/edit\",\"ir.ajax.vehicles-create-or-update\":\"/ir/ajax/vehicles\",\"ir.ajax.vehicles-active-flag\":\"/ir/ajax/vehicles/active-flag\",\"ir.ajax.vehicles-return-vat-flag\":\"/ir/ajax/vehicles/return-vat-flag\",\"ir.ajax.vehicles-duplicate-check\":\"/ir/ajax/vehicles/duplicate-check\",\"ir.ajax.gas-stations-index\":\"/ir/ajax/gas-stations\",\"ir.ajax.gas-stations-show\":\"/ir/ajax/gas-stations/{gas_station_id}\",\"ir.ajax.gas-stations-store\":\"/ir/ajax/gas-stations\",\"ir.ajax.gas-stations-update\":\"/ir/ajax/gas-stations\",\"ir.ajax.gas-stations-return-vat-flag\":\"/ir/ajax/gas-stations/return-vat-flag\",\"ir.ajax.gas-stations-active-flag\":\"/ir/ajax/gas-stations/active-flag\",\"ir.ajax.stocks-index\":\"/ir/ajax/stocks\",\"ir.ajax.stocks-fetch\":\"/ir/ajax/stocks/fetch\",\"ir.ajax.stocks-show\":\"/ir/ajax/stocks/show\",\"ir.ajax.stocks-create-or-update\":\"/ir/ajax/stocks\",\"ir.ajax.asset-index\":\"/ir/ajax/asset\",\"ir.ajax.asset-fetch\":\"/ir/ajax/asset/fetch\",\"ir.ajax.asset-index-adjust\":\"/ir/ajax/asset/asset-adjust\",\"ir.ajax.asset-fetch-adjust\":\"/ir/ajax/asset/asset-adjust/fetch\",\"ir.ajax.asset-show\":\"/ir/ajax/asset/show\",\"ir.ajax.asset-show-adjust\":\"/ir/ajax/asset/asset-adjust/show\",\"ir.ajax.asset-create-or-update\":\"/ir/ajax/asset\",\"ir.ajax.cars-index\":\"/ir/ajax/cars\",\"ir.ajax.cars-fetch\":\"/ir/ajax/cars/fetch\",\"ir.ajax.cars-create-or-update\":\"/ir/ajax/cars\",\"ir.ajax.cars-duplicate-check\":\"/ir/ajax/cars/duplicate-check\",\"ir.ajax.cars-status\":\"/ir/ajax/cars/status\",\"ir.ajax.extend-gas-stations-index\":\"/ir/ajax/extend-gas-stations\",\"ir.ajax.extend-gas-stations-fetch\":\"/ir/ajax/extend-gas-stations/fetch\",\"ir.ajax.extend-gas-stations-create-or-update\":\"/ir/ajax/extend-gas-stations\",\"ir.ajax.extend-gas-stations-duplicate-check\":\"/ir/ajax/extend-gas-stations/duplicate-check\",\"ir.ajax.extend-gas-stations-status\":\"/ir/ajax/extend-gas-stations/status\",\"ir.ajax.persons-index\":\"/ir/ajax/persons\",\"ir.ajax.persons-create-or-update\":\"/ir/ajax/persons\",\"ir.ajax.persons-duplicate-check\":\"/ir/ajax/persons/duplicate-check\",\"ir.ajax.persons-duplicate-check-invoice-number\":\"/ir/ajax/persons/duplicate-check/invoice-number\",\"ir.ajax.persons-status\":\"/ir/ajax/persons/status\",\"ir.ajax.expense-asset-stock-index\":\"/ir/ajax/expense-asset-stock\",\"ir.ajax.expense-asset-stock-store\":\"/ir/ajax/expense-asset-stock\",\"ir.ajax.expense-car-gas-index\":\"/ir/ajax/expense-car-gas\",\"ir.ajax.expense-car-gas-store\":\"/ir/ajax/expense-car-gas\",\"ir.ajax.claim-index\":\"/ir/ajax/claim\",\"ir.ajax.claim-show\":\"/ir/ajax/claim/{claim_header_id}\",\"ir.ajax.claim-create-or-update\":\"/ir/ajax/claim\",\"ir.ajax.claim-delete\":\"/ir/ajax/claim/{claim_header_id}\",\"ir.ajax.claim-delete-company\":\"/ir/ajax/claim/company/{claim_header_id}\",\"ir.ajax.claim-upload\":\"/ir/ajax/claim/upload\",\"ir.ajax.claim-delete-file\":\"/ir/ajax/claim/file/{attachment_id}\",\"ir.ajax.confirm-ap-interface\":\"/ir/ajax/confirm-ap\",\"ir.ajax.confirm-ap-cancel\":\"/ir/ajax/confirm-ap/cancel\",\"ir.ajax.confirm-gl-interface\":\"/ir/ajax/confirm-gl\",\"ir.ajax.confirm-gl-cancel\":\"/ir/ajax/confirm-gl/cancel\",\"ir.ajax.confirm-ar-interface\":\"/ir/ajax/confirm-ar\",\"ir.ajax.confirm-ar-cancel\":\"/ir/ajax/confirm-ar/cancel\",\"ir.ajax.account-mapping.index\":\"/ir/ajax/coa-mapping\",\"ir.ajax.validate-combination\":\"/ir/ajax/validate-combination\",\"ir.ajax.show-account-mapping\":\"/ir/ajax/account-mapping\",\"ir.ajax.companies-code\":\"/ir/ajax/companies-code/all\",\"ir.ajax.evm-code\":\"/ir/ajax/evm-code/all\",\"ir.ajax.department-code\":\"/ir/ajax/department-code/all\",\"ir.ajax.costcenter-code\":\"/ir/ajax/costcenter-code/all\",\"ir.ajax.budget-year\":\"/ir/ajax/budget-year/all\",\"ir.ajax.budget-type\":\"/ir/ajax/budget-type/all\",\"ir.ajax.budget-detail\":\"/ir/ajax/budget-detail/all\",\"ir.ajax.budget-reason\":\"/ir/ajax/budget-reason/all\",\"ir.ajax.main-account\":\"/ir/ajax/main-account/all\",\"ir.ajax.sub-account\":\"/ir/ajax/sub-account/all\",\"ir.ajax.reserverd1\":\"/ir/ajax/reserved1/all\",\"ir.ajax.reserverd2\":\"/ir/ajax/reserved2/all\",\"ir.ajax.code-combine-lov\":\"/ir/ajax/account-mapping/lov/account-code-combine\",\"ir.ajax.account-desc\":\"/ir/ajax/get-account-desc\",\"ir.ajax.vehicles-lov-license-plate\":\"/ir/ajax/vehicles/lov/license-plate\",\"ir.ajax.vehicles-lov-type\":\"/ir/ajax/vehicles/lov/vehicles-type\",\"ir.ajax.vehicles-update-or-create\":\"/ir/ajax/vehicles/updateOrCreate\",\"ir.ajax.vehicles-update-active-flag\":\"/ir/ajax/vehicles/active-flag\",\"ir.ajax.vehicles-update-return-vat-flag\":\"/ir/ajax/vehicles/return-vat-flag\",\"ir.ajax.lookup-gas-stations-lov-type\":\"/ir/ajax/gas-stations/lov/lookup-type\",\"ir.ajax.lookup-gas-stations-lov-groups\":\"/ir/ajax/gas-stations/lov/lookup-group\",\"ir.ajax.gas-stations-update-return-vat-flag\":\"/ir/ajax/gas-stations/return-vat-flag\",\"ir.ajax.gas-stations-update-active-flag\":\"/ir/ajax/gas-stations/active-flag\",\"ir.ajax.ir-report-get-info\":\"/ir/ajax/ir-report-get-info\",\"ir.ajax.ir-report-get-info-attribute\":\"/ir/ajax/ir-report-get-info-attribute\",\"ir.ajax.ir-report-submit\":\"/ir/ajax/ir-report-submit\",\"ir.settings.store-account-mapping\":\"/ir/settings/account-mapping/save\",\"ir.settings.update-account-mapping\":\"/ir/settings/account-mapping/update\",\"ir.settings.policy.index\":\"/ir/settings/policy\",\"ir.settings.policy.create\":\"/ir/settings/policy/create\",\"ir.settings.policy.edit\":\"/ir/settings/policy/edit/{id}\",\"ir.settings.vehicle.index\":\"/ir/settings/vehicle\",\"ir.settings.vehicle.create\":\"/ir/settings/vehicle/create\",\"ir.settings.vehicle.edit\":\"/ir/settings/vehicle/edit/{asset_id}/{vehicle_id}\",\"ir.settings.gas-stations.index\":\"/ir/settings/gas-stations\",\"ir.settings.gas-stations.create\":\"/ir/settings/gas-stations/create\",\"ir.settings.gas-stations.edit\":\"/ir/settings/gas-stations/edit\",\"ir.settings.policies.index\":\"/ir/settings/policy\",\"ir.settings.policies.create\":\"/ir/settings/policy/create\",\"ir.settings.policies.edit\":\"/ir/settings/policy/edit/{id}\",\"ir.settings.policy-group.index\":\"/ir/settings/policy-group\",\"ir.settings.policy-group.edit\":\"/ir/settings/policy-group/edit/{id}\",\"ir.settings.irp-0008.index\":\"/ir/settings/irp-0008\",\"ir.settings.report-info.index\":\"/ir/settings/report-info\",\"ir.settings.report-info.show\":\"/ir/settings/report-info/{program}\",\"ir.settings.report-info.store\":\"/ir/settings/report-info/{program}\",\"ir.settings.report-info.update\":\"/ir/settings/report-info/{program}/{info}\",\"ir.settings.report-info.destroy\":\"/ir/settings/report-info/{program}/{info}/delete\",\"ir.settings.company.index\":\"/ir/settings/company\",\"ir.settings.company.create\":\"/ir/settings/company/create\",\"ir.settings.company.edit\":\"/ir/settings/company/edit/{id}\",\"ir.settings.gas-station.index\":\"/ir/settings/gas-station\",\"ir.settings.account-mapping.index\":\"/ir/settings/account-mapping\",\"ir.settings.account-mapping.create\":\"/ir/settings/account-mapping/create\",\"ir.settings.account-mapping.store\":\"/ir/settings/account-mapping\",\"ir.settings.account-mapping.show\":\"/ir/settings/account-mapping/{account_mapping}\",\"ir.settings.account-mapping.edit\":\"/ir/settings/account-mapping/{account_mapping}/edit\",\"ir.settings.account-mapping.update\":\"/ir/settings/account-mapping/{account_mapping}\",\"ir.settings.account-mapping.destroy\":\"/ir/settings/account-mapping/{account_mapping}\",\"ir.settings.product-group\":\"/ir/ajax/product-group\",\"ir.settings.get-locator\":\"/ir/ajax/get-locator\",\"ir.settings.gas-station.create\":\"/ir/settings/gas-station/create\",\"ir.settings.gas-station.edit\":\"/ir/settings/gas-station/edit/{id}\",\"ir.stocks.yearly.index\":\"/ir/stocks/yearly\",\"ir.stocks.yearly.edit\":\"/ir/stocks/yearly/edit/{id}\",\"ir.stocks.monthly.index\":\"/ir/stocks/monthly\",\"ir.stocks.monthly.edit\":\"/ir/stocks/monthly/edit/{id}\",\"ir.assets.asset-plan.index\":\"/ir/assets/asset-plan\",\"ir.assets.asset-plan.edit\":\"/ir/assets/asset-plan/edit/{id}\",\"ir.assets.asset-increase.index\":\"/ir/assets/asset-increase\",\"ir.assets.asset-increase.edit\":\"/ir/assets/asset-increase/edit/{id}\",\"ir.gas-stations.gas-station.index\":\"/ir/settings/gas-stations\",\"ir.cars.car.index\":\"/ir/cars/car\",\"ir.governors.governor.index\":\"/ir/governors/governor\",\"ir.calculate-insurance.index\":\"/ir/calculate-insurance\",\"ir.calculate-insurance.report\":\"/ir/calculate-insurance/report\",\"ir.calculate-insurance.interface\":\"/ir/calculate-insurance/interface\",\"ir.calculate-insurance.cancel\":\"/ir/calculate-insurance/cancel\",\"ir.expense-stock-asset.index\":\"/ir/settings/irp-0008\",\"ir.expense-car-gas.index\":\"/ir/expense-car-gas\",\"ir.claim-insurance.index\":\"/ir/claim-insurance\",\"ir.claim-insurance.create\":\"/ir/claim-insurance/create\",\"ir.claim-insurance.edit\":\"/ir/claim-insurance/edit/{id}\",\"ir.confirm-to-ap.index\":\"/ir/confirm-to-ap\",\"ir.confirm-to-gl.index\":\"/ir/confirm-to-gl\",\"ir.confirm-to-ar.index\":\"/ir/confirm-to-ar\",\"ir.report.export\":\"/ir/reports/export\",\"ir.report.index\":\"/ir/reports\",\"ir.report.get-param\":\"/ir/reports/get-param\",\"ie.ajax.icon.index\":\"/ie/ajax/icon\",\"ie.cash-advances.get_suppliers\":\"/ie/cash-advances/get_suppliers\",\"ie.cash-advances.get_supplier_sites\":\"/ie/cash-advances/get_supplier_sites\",\"ie.cash-advances.get_requester_data\":\"/ie/cash-advances/get_requester_data\",\"ie.cash-advances.index-pending\":\"/ie/cash-advances/pending\",\"ie.cash-advances.get_sub_categories\":\"/ie/cash-advances/get_sub_categories\",\"ie.cash-advances.get_form_informations\":\"/ie/cash-advances/ca_sub_category/{ca_sub_category}/get_form_informations\",\"ie.cash-advances.index\":\"/ie/cash-advances\",\"ie.cash-advances.create\":\"/ie/cash-advances/create\",\"ie.cash-advances.show\":\"/ie/cash-advances/{cashAdvance}\",\"ie.cash-advances.update\":\"/ie/cash-advances/{cashAdvance}\",\"ie.cash-advances.store\":\"/ie/cash-advances/store\",\"ie.cash-advances.export\":\"/ie/cash-advances/export\",\"ie.cash-advances.update_cl\":\"/ie/cash-advances/{cashAdvance}/update_cl\",\"ie.cash-advances.form_edit\":\"/ie/cash-advances/{cashAdvance}/form_edit\",\"ie.cash-advances.form_edit_cl\":\"/ie/cash-advances/{cashAdvance}/form_edit_cl\",\"ie.cash-advances.report\":\"/ie/cash-advances/{cashAdvance}/report\",\"ie.cash-advances.get_total_amount\":\"/ie/cash-advances/{cashAdvance}/get_total_amount\",\"ie.cash-advances.update_dff\":\"/ie/cash-advances/{cashAdvance}/update_dff\",\"ie.cash-advances.change_approver\":\"/ie/cash-advances/{cashAdvance}/change_approver\",\"ie.cash-advances.set_status\":\"/ie/cash-advances/{cashAdvance}/set_status\",\"ie.cash-advances.add_attachment\":\"/ie/cash-advances/{cashAdvance}/add_attachment\",\"ie.cash-advances.set_due_date\":\"/ie/cash-advances/{cashAdvance}/set_due_date\",\"ie.cash-advances.get_diff_ca_and_clearing_amount\":\"/ie/cash-advances/{cashAdvance}/get_diff_ca_and_clearing_amount\",\"ie.cash-advances.get_diff_ca_and_clearing_data\":\"/ie/cash-advances/{cashAdvance}/get_diff_ca_and_clearing_data\",\"ie.cash-advances.duplicate\":\"/ie/cash-advances/{cashAdvance}/duplicate\",\"ie.cash-advances.clear-request\":\"/ie/cash-advances/{cashAdvance}/clear-request\",\"ie.cash-advances.clear\":\"/ie/cash-advances/{cashAdvance}/clear\",\"ie.cash-advances.check_ca_attachment\":\"/ie/cash-advances/{cashAdvance}/check_ca_attachment\",\"ie.cash-advances.check_ca_min_amount\":\"/ie/cash-advances/{cashAdvance}/check_ca_min_amount\",\"ie.cash-advances.check_ca_max_amount\":\"/ie/cash-advances/{cashAdvance}/check_ca_max_amount\",\"ie.cash-advances.combine_receipt_gl_code_combination\":\"/ie/cash-advances/{cashAdvance}/combine_receipt_gl_code_combination\",\"ie.cash-advances.check_over_budget\":\"/ie/cash-advances/{cashAdvance}/check_over_budget\",\"ie.cash-advances.check_exceed_policy\":\"/ie/cash-advances/{cashAdvance}/check_exceed_policy\",\"ie.cash-advances.validate_receipt\":\"/ie/cash-advances/{cashAdvance}/validate_receipt\",\"ie.cash-advances.form_send_request_with_reason\":\"/ie/cash-advances/{cashAdvance}/form_send_request_with_reason\",\"ie.reimbursements.get_suppliers\":\"/ie/reimbursements/get_suppliers\",\"ie.reimbursements.get_supplier_sites\":\"/ie/reimbursements/get_supplier_sites\",\"ie.reimbursements.get_requester_data\":\"/ie/reimbursements/get_requester_data\",\"ie.reimbursements.index-pending\":\"/ie/reimbursements/pending\",\"ie.reimbursements.index\":\"/ie/reimbursements\",\"ie.reimbursements.create\":\"/ie/reimbursements/create\",\"ie.reimbursements.show\":\"/ie/reimbursements/{reimbursement}\",\"ie.reimbursements.update\":\"/ie/reimbursements/{reimbursement}\",\"ie.reimbursements.store\":\"/ie/reimbursements/store\",\"ie.reimbursements.export\":\"/ie/reimbursements/export\",\"ie.reimbursements.form_edit\":\"/ie/reimbursements/{reimbursement}/form_edit\",\"ie.reimbursements.get_total_amount\":\"/ie/reimbursements/{reimbursement}/get_total_amount\",\"ie.reimbursements.update_dff\":\"/ie/reimbursements/{reimbursement}/update_dff\",\"ie.reimbursements.change_approver\":\"/ie/reimbursements/{reimbursement}/change_approver\",\"ie.reimbursements.set_status\":\"/ie/reimbursements/{reimbursement}/set_status\",\"ie.reimbursements.add_attachment\":\"/ie/reimbursements/{reimbursement}/add_attachment\",\"ie.reimbursements.set_due_date\":\"/ie/reimbursements/{reimbursement}/set_due_date\",\"ie.reimbursements.duplicate\":\"/ie/reimbursements/{reimbursement}/duplicate\",\"ie.reimbursements.combine_receipt_gl_code_combination\":\"/ie/reimbursements/{reimbursement}/combine_receipt_gl_code_combination\",\"ie.reimbursements.check_over_budget\":\"/ie/reimbursements/{reimbursement}/check_over_budget\",\"ie.reimbursements.check_exceed_policy\":\"/ie/reimbursements/{reimbursement}/check_exceed_policy\",\"ie.reimbursements.validate_receipt\":\"/ie/reimbursements/{reimbursement}/validate_receipt\",\"ie.reimbursements.form_send_request_with_reason\":\"/ie/reimbursements/{reimbursement}/form_send_request_with_reason\",\"ie.receipts.get_inv_tobacco\":\"/ie/receipts/get_inv_tobacco\",\"ie.receipts.get_vendor_sites\":\"/ie/receipts/get_vendor_sites/{vendor_id}\",\"ie.receipts.get_vendor_detail\":\"/ie/receipts/get_vendor_detail/{vendor_id}/site/{vendor_site_code}\",\"ie.receipts.get_rows\":\"/ie/receipts/get_rows\",\"ie.receipts.get_table_total_rows\":\"/ie/receipts/get_table_total_rows\",\"ie.receipts.form_create\":\"/ie/receipts/form_create\",\"ie.receipts.index-pending\":\"/ie/receipts/pending\",\"ie.receipts.create\":\"/ie/receipts/create\",\"ie.receipts.show\":\"/ie/receipts/{receipt}\",\"ie.receipts.update\":\"/ie/receipts/{receipt}\",\"ie.receipts.store\":\"/ie/receipts/store\",\"ie.receipts.export\":\"/ie/receipts/export\",\"ie.receipts.set_status\":\"/ie/receipts/set_status\",\"ie.receipts.add_attachment\":\"/ie/receipts/{receipt}/add_attachment\",\"ie.receipts.form_edit\":\"/ie/receipts/{receipt}/form_edit\",\"ie.receipts.duplicate\":\"/ie/receipts/{receipt}/duplicate\",\"ie.receipts.remove\":\"/ie/receipts/{receipt}/remove\",\"ie.receipts.lines.store\":\"/ie/receipts/{receipt}/lines/store\",\"ie.receipts.lines.update\":\"/ie/receipts/{receipt}/lines/{line}/update\",\"ie.receipts.lines.update_coa\":\"/ie/receipts/{receipt}/lines/{line}/update_coa\",\"ie.receipts.lines.update_dff\":\"/ie/receipts/{receipt}/lines/{line}/update_dff\",\"ie.receipts.lines.duplicate\":\"/ie/receipts/{receipt}/lines/{line}/duplicate\",\"ie.receipts.lines.remove\":\"/ie/receipts/{receipt}/lines/{line}/remove\",\"ie.receipts.lines.get_show_infos\":\"/ie/receipts/{receipt}/lines/{line}/get_show_infos\",\"ie.receipts.lines.form_create\":\"/ie/receipts/{receipt}/lines/form_create\",\"ie.receipts.lines.get_sub_categories\":\"/ie/receipts/{receipt}/lines/get_sub_categories\",\"ie.receipts.lines.sub_category.get_form_informations\":\"/ie/receipts/{receipt}/lines/sub_category/{sub_category}/get_form_informations\",\"ie.receipts.lines.sub_category.get_form_amount\":\"/ie/receipts/{receipt}/lines/sub_category/{sub_category}/get_form_amount\",\"ie.receipts.lines.form_coa\":\"/ie/receipts/{receipt}/lines/{line}/form_coa\",\"ie.receipts.lines.input_cost_center_code\":\"/ie/receipts/{receipt}/lines/{line}/input_cost_center_code\",\"ie.receipts.lines.input_budget_detail_code\":\"/ie/receipts/{receipt}/lines/{line}/input_budget_detail_code\",\"ie.receipts.lines.input_sub_account_code\":\"/ie/receipts/{receipt}/lines/{line}/input_sub_account_code\",\"ie.receipts.lines.validate_combination\":\"/ie/receipts/{receipt}/lines/{line}/validate_combination\",\"ie.receipts.lines.form_edit\":\"/ie/receipts/{receipt}/lines/{line}/form_edit\",\"ie.receipts.lines.get_form_edit_informations\":\"/ie/receipts/{receipt}/lines/{line}/get_form_edit_informations\",\"ie.receipts.lines.get_form_edit_amount\":\"/ie/receipts/{receipt}/lines/{line}/get_form_edit_amount\",\"ie.dff.get_form\":\"/ie/dff/get_form\",\"ie.dff.get_form_header\":\"/ie/dff/get_form_header\",\"ie.dff.get_form_line\":\"/ie/dff/get_form_line\",\"ie.attachments.download\":\"/ie/attachments/{attachment_id}/download\",\"ie.attachments.image\":\"/ie/attachments/{attachment_id}/image\",\"ie.attachments.image_modal\":\"/ie/attachments/{attachment_id}/image\",\"ie.attachments.remove\":\"/ie/attachments/{attachment_id}/remove\",\"ie.settings.locations.index\":\"/ie/settings/locations\",\"ie.settings.locations.create\":\"/ie/settings/locations/create\",\"ie.settings.locations.edit\":\"/ie/settings/locations/{location}/edit\",\"ie.settings.locations.update\":\"/ie/settings/locations/{location}\",\"ie.settings.categories.index\":\"/ie/settings/categories\",\"ie.settings.categories.create\":\"/ie/settings/categories/create\",\"ie.settings.categories.store\":\"/ie/settings/categories\",\"ie.settings.categories.edit\":\"/ie/settings/categories/{category}/edit\",\"ie.settings.categories.update\":\"/ie/settings/categories/{category}\",\"ie.settings.categories.remove\":\"/ie/settings/categories/{category}/remove\",\"ie.settings.validate_combination\":\"/ie/settings/categories/{category}/sub_categories/validate_combination\",\"ie.settings.form_set_account\":\"/ie/settings/categories/{category}/sub_categories/form_set_account\",\"ie.settings.input_cost_center_code\":\"/ie/receipts/{receipt}/lines/{line}/input_cost_center_code\",\"ie.settings.input_budget_detail_code\":\"/ie/receipts/{receipt}/lines/{line}/input_budget_detail_code\",\"ie.settings.input_sub_account_code\":\"/ie/settings/ca-categories/{ca_category}/ca_sub_categories/input_sub_account_code\",\"ie.settings.sub-categories.index\":\"/ie/settings/categories/{category}/sub-categories\",\"ie.settings.sub-categories.create\":\"/ie/settings/categories/{category}/sub-categories/create\",\"ie.settings.sub-categories.store\":\"/ie/settings/categories/{category}/sub-categories\",\"ie.settings.sub-categories.show\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}\",\"ie.settings.sub-categories.edit\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/edit\",\"ie.settings.sub-categories.update\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}\",\"ie.settings.sub-categories.destroy\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}\",\"ie.settings.sub-categories.infos.index\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos\",\"ie.settings.sub-categories.infos.create\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/create\",\"ie.settings.sub-categories.infos.store\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos\",\"ie.settings.sub-categories.infos.show\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}\",\"ie.settings.sub-categories.infos.edit\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}/edit\",\"ie.settings.sub-categories.infos.update\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}\",\"ie.settings.sub-categories.infos.destroy\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}\",\"ie.settings.sub-categories.input_form_type\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/input_form_type/{input_form_type}\",\"ie.settings.sub-categories.infos.inactive\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}/inactive\",\"ie.settings.policies.index\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies\",\"ie.settings.policies.create\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/create\",\"ie.settings.policies.store\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies\",\"ie.settings.policies.inactive\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/inactive\",\"ie.settings.policies.rates.index\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates\",\"ie.settings.policies.rates.create\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/create\",\"ie.settings.policies.rates.store\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates\",\"ie.settings.policies.rates.show\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}\",\"ie.settings.policies.rates.edit\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}/edit\",\"ie.settings.policies.rates.update\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}\",\"ie.settings.policies.rates.destroy\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}\",\"ie.settings.policies.rates.inactive\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}/inactive\",\"ie.settings.ca-categories.index\":\"/ie/settings/ca-categories\",\"ie.settings.ca-categories.create\":\"/ie/settings/ca-categories/create\",\"ie.settings.ca-categories.store\":\"/ie/settings/ca-categories\",\"ie.settings.ca-categories.edit\":\"/ie/settings/ca-categories/{ca_category}/edit\",\"ie.settings.ca-categories.update\":\"/ie/settings/ca-categories/{ca_category}\",\"ie.settings.ca-categories.remove\":\"/ie/settings/ca-categories/{ca_category}/remove\",\"ie.settings.ca-sub-categories.index\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories\",\"ie.settings.ca-sub-categories.create\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/create\",\"ie.settings.ca-sub-categories.store\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories\",\"ie.settings.ca-sub-categories.show\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}\",\"ie.settings.ca-sub-categories.edit\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/edit\",\"ie.settings.ca-sub-categories.update\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}\",\"ie.settings.ca-sub-categories.destroy\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}\",\"ie.settings.ca-sub-categories.infos.index\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos\",\"ie.settings.ca-sub-categories.infos.create\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/create\",\"ie.settings.ca-sub-categories.infos.store\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos\",\"ie.settings.ca-sub-categories.infos.show\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}\",\"ie.settings.ca-sub-categories.infos.edit\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}/edit\",\"ie.settings.ca-sub-categories.infos.update\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}\",\"ie.settings.ca-sub-categories.infos.destroy\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}\",\"ie.settings.ca-sub-categories.input_form_type\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/input_form_type/{input_form_type}\",\"ie.settings.ca-sub-categories.infos.inactive\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}/inactive\",\"ie.settings.preferences.index\":\"/ie/settings/preferences\",\"ie.settings.preferences.update\":\"/ie/settings/preferences/update\",\"ie.settings.preferences.update_mapping_ous\":\"/ie/settings/preferences/update_mapping_ous\",\"ie.settings.preferences.slice_json\":\"/ie/settings/preferences/slice_json\",\"ie.settings.user-accounts.index\":\"/ie/settings/user-accounts\",\"ie.settings.user-accounts.store\":\"/ie/settings/user-accounts\",\"ie.settings.user-accounts.update\":\"/ie/settings/user-accounts/{user_account}\",\"ie.settings.user-accounts.destroy\":\"/ie/settings/user-accounts/{user_account}\",\"ie.settings.user-accounts.form_edit\":\"/ie/settings/user-accounts/{account_id}/form_edit\",\"ie.settings.user-accounts.sync\":\"/ie/settings/user-accounts/sync\",\"ie.report.index\":\"/ie/report/index\",\"ie.report.ct-invoice\":\"/ie/report/ct-invoice\",\"ie.report.ct-wht\":\"/ie/report/ct-wht\",\"ie.report.request\":\"/ie/report/{type}/request/{parent}\",\"inv.requisition_stationery.summary-web-stationery-pdf\":\"/inv/requisition_stationery/summary-web-stationery-pdf\",\"inv.requisition_stationery.order-history-pdf\":\"/inv/requisition_stationery/order-history-pdf\",\"inv.requisition_stationery.summary-web-stationery-report\":\"/inv/requisition_stationery/summary-web-stationery-report\",\"inv.requisition_stationery.order-history-report\":\"/inv/requisition_stationery/order-history-report\",\"inv.requisition_stationery.copy\":\"/inv/requisition_stationery/{id}/copy\",\"inv.requisition_stationery.approve\":\"/inv/requisition_stationery/{id}/approve\",\"inv.requisition_stationery.cancel\":\"/inv/requisition_stationery/{id}/cancel\",\"inv.requisition_stationery.index\":\"/inv/requisition_stationery\",\"inv.requisition_stationery.create\":\"/inv/requisition_stationery/create\",\"inv.requisition_stationery.store\":\"/inv/requisition_stationery\",\"inv.requisition_stationery.show\":\"/inv/requisition_stationery/{requisition_stationery}\",\"inv.requisition_stationery.edit\":\"/inv/requisition_stationery/{requisition_stationery}/edit\",\"inv.requisition_stationery.update\":\"/inv/requisition_stationery/{requisition_stationery}\",\"inv.issue_approve_detail.index\":\"/inv/issue_approve_detail\",\"inv.issue_approve_detail.store\":\"/inv/issue_approve_detail\",\"inv.disbursement_fuel.update-car-interface\":\"/inv/disbursement_fuel/update-car-interface\",\"inv.disbursement_fuel.add_new_car\":\"/inv/disbursement_fuel/add_new_car\",\"inv.disbursement_fuel.report\":\"/inv/disbursement_fuel/report\",\"inv.disbursement_fuel.show\":\"/inv/disbursement_fuel/show\",\"inv.disbursement_fuel.index\":\"/inv/disbursement_fuel\",\"inv.disbursement_fuel.create\":\"/inv/disbursement_fuel/create\",\"inv.disbursement_fuel.store\":\"/inv/disbursement_fuel\",\"inv.disbursement_fuel.edit\":\"/inv/disbursement_fuel/{disbursement_fuel}/edit\",\"inv.disbursement_fuel.update\":\"/inv/disbursement_fuel/{disbursement_fuel}\",\"inv.ajax.issue_header\":\"/inv/ajax/issue_header\",\"inv.ajax.issue_profile_V\":\"/inv/ajax/issue_profile_V\",\"inv.ajax.coa_dept_code\":\"/inv/ajax/coa_dept_code\",\"inv.ajax.subinventory\":\"/inv/ajax/subinventory\",\"inv.ajax.secondary_inventories\":\"/inv/ajax/secondary_inventories\",\"inv.ajax.alias_name\":\"/inv/ajax/alias_name\",\"inv.ajax.system_item\":\"/inv/ajax/system_item\",\"inv.ajax.car_info\":\"/inv/ajax/car_info\",\"inv.ajax.car_history\":\"/inv/ajax/car_history\",\"inv.ajax.gl_code_combinations\":\"/inv/ajax/gl_code_combinations\",\"inv.ajax.web_fuel_dist\":\"/inv/ajax/web_fuel_dist\",\"inv.ajax.web_fuel_oil\":\"/inv/ajax/web_fuel_oil\",\"inv.ajax.item_locations\":\"/inv/ajax/item_locations\",\"inv.ajax.car_types\":\"/inv/ajax/car_types\",\"inv.ajax.car_brands\":\"/inv/ajax/car_brands\",\"inv.ajax.car_fuels\":\"/inv/ajax/car_fuels\",\"inv.ajax.employees\":\"/inv/ajax/employees\",\"inv.ajax.lookup_types\":\"/inv/ajax/lookup_types\",\"inv.ajax.lookup_values\":\"/inv/ajax/lookup_values\",\"inv.ajax.organization_units\":\"/inv/ajax/organization_units\",\"inv.ajax.po_distributions_all\":\"/inv/ajax/po_distributions_all\",\"inv.ajax.po_headers_all\":\"/inv/ajax/po_headers_all\",\"inv.ajax.po_lines_all\":\"/inv/ajax/po_lines_all\",\"inv.ajax.lot_onhands\":\"/inv/ajax/lot_onhands\",\"qm.api.settings.specifications.store\":\"/qm/api/settings/specifications\",\"qm.settings.check-points-tobacco-leaf.index\":\"/qm/settings/check-points-tobacco-leaf\",\"qm.settings.check-points-tobacco-leaf.create\":\"/qm/settings/check-points-tobacco-leaf/create\",\"qm.settings.check-points-tobacco-leaf.store\":\"/qm/settings/check-points-tobacco-leaf/store\",\"qm.settings.check-points-tobacco-leaf.update\":\"/qm/settings/check-points-tobacco-leaf/update\",\"qm.settings.check-points-tobacco-leaf.edit\":\"/qm/settings/check-points-tobacco-leaf/{id}/edit\",\"qm.settings.check-points-tobacco-beetle.index\":\"/qm/settings/check-points-tobacco-beetle\",\"qm.settings.check-points-tobacco-beetle.create\":\"/qm/settings/check-points-tobacco-beetle/create\",\"qm.settings.check-points-tobacco-beetle.store\":\"/qm/settings/check-points-tobacco-beetle/store\",\"qm.settings.check-points-tobacco-beetle.edit\":\"/qm/settings/check-points-tobacco-beetle/{id}/edit\",\"qm.settings.check-points-tobacco-beetle.update\":\"/qm/settings/check-points-tobacco-beetle/update\",\"qm.settings.attachments.download\":\"/qm/settings/attachments/{attachment}/download\",\"qm.settings.attachments.image\":\"/qm/settings/attachments/{attachment}/image\",\"qm.settings.test-unit.index\":\"/qm/settings/test-unit\",\"qm.settings.test-unit.create\":\"/qm/settings/test-unit/create\",\"qm.settings.test-unit.edit\":\"/qm/settings/test-unit/{qcunit_code}/edit\",\"qm.settings.test-unit.store\":\"/qm/settings/test-unit/store\",\"qm.settings.test-unit.update\":\"/qm/settings/test-unit/update\",\"qm.settings.qc-area.index\":\"/qm/settings/qc-area\",\"qm.settings.qc-area.update\":\"/qm/settings/qc-area/update\",\"qm.settings.define-tests-tobacco-leaf.index\":\"/qm/settings/define-tests-tobacco-leaf\",\"qm.settings.define-tests-tobacco-leaf.create\":\"/qm/settings/define-tests-tobacco-leaf/create\",\"qm.settings.define-tests-tobacco-leaf.store\":\"/qm/settings/define-tests-tobacco-leaf/store\",\"qm.settings.define-tests-tobacco-leaf.update\":\"/qm/settings/define-tests-tobacco-leaf/update\",\"qm.settings.define-tests-tobacco-beetle.index\":\"/qm/settings/define-tests-tobacco-beetle\",\"qm.settings.define-tests-tobacco-beetle.create\":\"/qm/settings/define-tests-tobacco-beetle/create\",\"qm.settings.define-tests-tobacco-beetle.store\":\"/qm/settings/define-tests-tobacco-beetle/store\",\"qm.settings.define-tests-tobacco-beetle.update\":\"/qm/settings/define-tests-tobacco-beetle/update\",\"qm.settings.define-tests-finished-products.index\":\"/qm/settings/define-tests-finished-products\",\"qm.settings.define-tests-finished-products.create\":\"/qm/settings/define-tests-finished-products/create\",\"qm.settings.define-tests-finished-products.store\":\"/qm/settings/define-tests-finished-products/store\",\"qm.settings.define-tests-finished-products.update\":\"/qm/settings/define-tests-finished-products/update\",\"qm.settings.define-tests-qtm-machines.index\":\"/qm/settings/define-tests-qtm-machines\",\"qm.settings.define-tests-qtm-machines.create\":\"/qm/settings/define-tests-qtm-machines/create\",\"qm.settings.define-tests-qtm-machines.store\":\"/qm/settings/define-tests-qtm-machines/store\",\"qm.settings.define-tests-qtm-machines.update\":\"/qm/settings/define-tests-qtm-machines/update\",\"qm.settings.define-tests-packet-air-leaks.index\":\"/qm/settings/define-tests-packet-air-leaks\",\"qm.settings.define-tests-packet-air-leaks.create\":\"/qm/settings/define-tests-packet-air-leaks/create\",\"qm.settings.define-tests-packet-air-leaks.store\":\"/qm/settings/define-tests-packet-air-leaks/store\",\"qm.settings.define-tests-packet-air-leaks.update\":\"/qm/settings/define-tests-packet-air-leaks/update\",\"qm.settings.specifications.index\":\"/qm/settings/specifications\",\"qm.ajax.tobaccos.get-sample-specifications\":\"/qm/ajax/tobaccos/get-sample-specifications\",\"qm.ajax.tobaccos.store-sample-result\":\"/qm/ajax/tobaccos/result\",\"qm.ajax.finished-products.get-sample-specifications\":\"/qm/ajax/finished-products/get-sample-specifications\",\"qm.ajax.finished-products.store-sample-result\":\"/qm/ajax/finished-products/result\",\"qm.ajax.qtm-machines.get-sample-specifications\":\"/qm/ajax/qtm-machines/get-sample-specifications\",\"qm.ajax.qtm-machines.store-sample-result\":\"/qm/ajax/qtm-machines/result\",\"qm.ajax.packet-air-leaks.get-sample-specifications\":\"/qm/ajax/packet-air-leaks/get-sample-specifications\",\"qm.ajax.packet-air-leaks.store-sample-result\":\"/qm/ajax/packet-air-leaks/result\",\"qm.ajax.moth-outbreaks.get-sample-specifications\":\"/qm/ajax/moth-outbreaks/get-sample-specifications\",\"qm.ajax.moth-outbreaks.store-sample-result\":\"/qm/ajax/moth-outbreaks/result\",\"qm.ajax.moth-outbreaks.upload-excel-file\":\"/qm/ajax/moth-outbreaks/upload-excel-file\",\"qm.tobaccos.create\":\"/qm/tobaccos/create\",\"qm.tobaccos.result\":\"/qm/tobaccos/result\",\"qm.tobaccos.report-summary\":\"/qm/tobaccos/report-summary\",\"qm.tobaccos.export-excel.report-summary\":\"/qm/tobaccos/export-excel/report-summary\",\"qm.tobaccos.store\":\"/qm/tobaccos\",\"qm.finished-products.create\":\"/qm/finished-products/create\",\"qm.finished-products.result\":\"/qm/finished-products/result\",\"qm.finished-products.track\":\"/qm/finished-products/track\",\"qm.finished-products.report-summary\":\"/qm/finished-products/report-summary\",\"qm.finished-products.report-issue\":\"/qm/finished-products/report-issue\",\"qm.finished-products.export-excel.report-summary\":\"/qm/finished-products/export-excel/report-summary\",\"qm.finished-products.export-excel.report-issue\":\"/qm/finished-products/export-excel/report-issue\",\"qm.finished-products.store\":\"/qm/finished-products\",\"qm.finished-products.store-result\":\"/qm/finished-products/result\",\"qm.qtm-machines.create\":\"/qm/qtm-machines/create\",\"qm.qtm-machines.result\":\"/qm/qtm-machines/result\",\"qm.qtm-machines.track\":\"/qm/qtm-machines/track\",\"qm.qtm-machines.report-summary\":\"/qm/qtm-machines/report-summary\",\"qm.qtm-machines.report-under-average\":\"/qm/qtm-machines/report-under-average\",\"qm.qtm-machines.report-product-quality\":\"/qm/qtm-machines/report-product-quality\",\"qm.qtm-machines.report-physical-value\":\"/qm/qtm-machines/report-physical-value\",\"qm.qtm-machines.export-excel.report-under-average\":\"/qm/qtm-machines/export-excel/report-under-average\",\"qm.qtm-machines.export-excel.report-product-quality\":\"/qm/qtm-machines/export-excel/report-product-quality\",\"qm.qtm-machines.export-excel.report-physical-value\":\"/qm/qtm-machines/export-excel/report-physical-value\",\"qm.qtm-machines.store\":\"/qm/qtm-machines\",\"qm.qtm-machines.store-result\":\"/qm/qtm-machines/result\",\"qm.packet-air-leaks.create\":\"/qm/packet-air-leaks/create\",\"qm.packet-air-leaks.result\":\"/qm/packet-air-leaks/result\",\"qm.packet-air-leaks.track\":\"/qm/packet-air-leaks/track\",\"qm.packet-air-leaks.report-summary\":\"/qm/packet-air-leaks/report-summary\",\"qm.packet-air-leaks.report-leak-rate\":\"/qm/packet-air-leaks/report-leak-rate\",\"qm.packet-air-leaks.export-excel.report-summary\":\"/qm/packet-air-leaks/export-excel/report-summary\",\"qm.packet-air-leaks.export-excel.report-leak-rate\":\"/qm/packet-air-leaks/export-excel/report-leak-rate\",\"qm.packet-air-leaks.store\":\"/qm/packet-air-leaks\",\"qm.packet-air-leaks.store-result\":\"/qm/packet-air-leaks/result\",\"qm.moth-outbreaks.create\":\"/qm/moth-outbreaks/create\",\"qm.moth-outbreaks.result\":\"/qm/moth-outbreaks/result\",\"qm.moth-outbreaks.track\":\"/qm/moth-outbreaks/track\",\"qm.moth-outbreaks.report-summary\":\"/qm/moth-outbreaks/report-summary\",\"qm.moth-outbreaks.export-excel.report-summary\":\"/qm/moth-outbreaks/export-excel/report-summary\",\"qm.moth-outbreaks.store\":\"/qm/moth-outbreaks\",\"qm.moth-outbreaks.store-result\":\"/qm/moth-outbreaks/result\",\"qm.files.image\":\"/qm/files/image/{module}/{menu}/{feature}/{fileName}\",\"qm.files.image-thumbnail\":\"/qm/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}\",\"qm.files.download\":\"/qm/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}\",\"planning.machine-yearly.index\":\"/planning/machine-yearly\",\"planning.machine-yearly.store\":\"/planning/machine-yearly\",\"planning.machine-yearly.update\":\"/planning/machine-yearly/{id}/update\",\"planning.machine-yearly.update-lines\":\"/planning/machine-yearly/{id}/update-lines\",\"planning.machine-yearly.machine-detail\":\"/planning/machine-detail\",\"planning.machine-yearly.update_plan_pm_yearly\":\"/planning/update_plan_pm_yearly\",\"planning.machine-yearly.downtime\":\"/planning/machine-downtime-yearly\",\"planning.machine-biweekly.index\":\"/planning/machine-biweekly\",\"planning.machine-biweekly.store\":\"/planning/machine-biweekly\",\"planning.machine-biweekly.update\":\"/planning/machine-biweekly/{id}/update\",\"planning.machine-biweekly.update-lines\":\"/planning/machine-biweekly/{id}/update-lines\",\"planning.machine-biweekly.update_plan_pm_biweekly\":\"/planning/update_plan_pm_biweekly\",\"planning.machine-biweekly.downtime\":\"/planning/machine-downtime-biweekly\",\"planning.production-biweekly.index\":\"/planning/production-biweekly\",\"planning.production-biweekly.show\":\"/planning/production-biweekly/{production_biweekly}\",\"planning.adjusts.store\":\"/planning/adjusts\",\"planning.adjusts.show\":\"/planning/adjusts/{adjust}\",\"planning.follow-ups.index\":\"/planning/follow-ups\",\"planning.production-daily.show\":\"/planning/production-daily/{id}\",\"planning.stamp-monthly.index\":\"/planning/stamp-monthly\",\"planning.stamp-follow\":\"/planning/stamp-follow\",\"planning.stamp-follow.export\":\"/planning/stamp-follow/{stampFollowMain}/export\",\"planning.ajax.\":\"/planning/ajax/get-biWeekly-machine\",\"planning.ajax.biWeekly.\":\"/planning/ajax/biWeekly/get-plan-machine\",\"planning.ajax.biWeekly.prod.get-est-data\":\"/planning/ajax/biWeekly/get-est-data\",\"planning.ajax.biWeekly.prod.get-avg-data\":\"/planning/ajax/biWeekly/get-avg-data\",\"planning.ajax.production-biweekly.modal-create-details\":\"/planning/ajax/production-biweekly/modal-create-details\",\"planning.ajax.production-biweekly.search\":\"/planning/ajax/production-biweekly/search\",\"planning.ajax.production-biweekly.store\":\"/planning/ajax/production-biweekly\",\"planning.ajax.production-biweekly.update\":\"/planning/ajax/production-biweekly/{productionBiweeklyMain}\",\"planning.ajax.production-biweekly.approve\":\"/planning/ajax/production-biweekly/approve/{productionBiweeklyMain}\",\"planning.ajax.production-biweekly.check-approve\":\"/planning/ajax/production-biweekly/check-approve/{productionBiweeklyMain}\",\"planning.ajax.production-biweekly.get-plan-machine\":\"/planning/ajax/production-biweekly/get-plan-machine\",\"planning.ajax.production-biweekly.get-est-data\":\"/planning/ajax/production-biweekly/get-est-data\",\"planning.ajax.production-biweekly.get-avg-data\":\"/planning/ajax/production-biweekly/get-avg-data\",\"planning.ajax.production-biweekly.get-est-by-biweekly\":\"/planning/ajax/production-biweekly/get-est-by-biweekly\",\"planning.ajax.adjusts.search\":\"/planning/ajax/adjusts/search\",\"planning.ajax.adjusts.search-create\":\"/planning/ajax/adjusts/search-create\",\"planning.ajax.adjusts.search-item\":\"/planning/ajax/adjusts/search-item\",\"planning.ajax.adjusts.update\":\"/planning/ajax/adjusts/{productionBiweeklyMain}\",\"planning.ajax.adjusts.update-note\":\"/planning/ajax/adjusts/update-note/{id}\",\"planning.ajax.adjusts.get-adj-data\":\"/planning/ajax/adjusts/get-adj-data\",\"planning.ajax.adjusts.approve\":\"/planning/ajax/adjusts/approve/{productionBiweeklyMain}\",\"planning.ajax.adjusts.check-approve\":\"/planning/ajax/adjusts/check-approve/{productionBiweeklyMain}\",\"planning.ajax.follow-ups.search\":\"/planning/ajax/follow-ups/search\",\"planning.ajax.follow-ups.get-data\":\"/planning/ajax/follow-ups/get-data\",\"planning.ajax.production-daily.modal-create-details\":\"/planning/ajax/production-daily/modal-create-details\",\"planning.ajax.production-daily.search\":\"/planning/ajax/production-daily/search\",\"planning.ajax.production-daily.create\":\"/planning/ajax/production-daily/create\",\"planning.ajax.production-daily.get-om-sales-forecast\":\"/planning/ajax/production-daily/get-om-sales-forecast\",\"planning.ajax.production-daily.get-production-machine\":\"/planning/ajax/production-daily/get-production-machine\",\"planning.ajax.production-daily.get-production-item\":\"/planning/ajax/production-daily/get-production-item\",\"planning.ajax.production-daily.submit-production-machine\":\"/planning/ajax/production-daily/machine\",\"planning.ajax.production-daily.check-approve\":\"/planning/ajax/production-daily/check-approve/{machineBiweekly}/daily-plan/{dailyPlan}\",\"planning.ajax.production-daily.approve\":\"/planning/ajax/production-daily/approve/{dailyPlan}\",\"planning.ajax.production-daily.check-unapprove\":\"/planning/ajax/production-daily/check-unapprove/{machineBiweekly}/daily-plan/{dailyPlan}\",\"planning.ajax.production-daily.unapprove\":\"/planning/ajax/production-daily/unapprove/{dailyPlan}\",\"planning.ajax.production-daily.get-grp-efficiency-product\":\"/planning/ajax/production-daily/get-grp-efficiency-product\",\"planning.ajax.production-daily.update_working_hour\":\"/planning/ajax/production-daily/update-working-hour/{res_plan_h_id}\",\"planning.ajax.stamp-monthly.modal-create-details\":\"/planning/ajax/stamp-monthly/modal-create-details\",\"planning.ajax.stamp-monthly.get-est-data\":\"/planning/ajax/stamp-monthly/get-est-data\",\"planning.ajax.stamp-monthly.store\":\"/planning/ajax/stamp-monthly\",\"planning.ajax.stamp-monthly.update\":\"/planning/ajax/stamp-monthly/{ptppStampMonthly}\",\"planning.ajax.stamp-monthly.duplicate\":\"/planning/ajax/stamp-monthly/{ptppStampMonthly}/duplicate\",\"planning.ajax.stamp-monthly.update-est\":\"/planning/ajax/stamp-monthly/{ptppStampMonthly}/update-est\",\"planning.ajax.stamp-monthly.search\":\"/planning/ajax/stamp-monthly/search\",\"planning.ajax.stamp-monthly.approve\":\"/planning/ajax/stamp-monthly/approve/{stampMonthlyV}\",\"planning.ajax.stamp-monthly.check-approve\":\"/planning/ajax/stamp-monthly/check-approve/{stampMonthlyV}\",\"planning.ajax.stamp-follow.get-stamp-daily\":\"/planning/ajax/stamp-follow/get-stamp-daily\",\"planning.ajax.stamp-follow.store\":\"/planning/ajax/stamp-follow\",\"planning.ajax.stamp-follow.update\":\"/planning/ajax/stamp-follow/{stampFollowMain}\",\"pm.ajax.material-requests.lines\":\"/pm/ajax/material-requests/lines\",\"pm.ajax.material-requests.get-item\":\"/pm/ajax/material-requests/get-item\",\"pm.ajax.material-requests.store\":\"/pm/ajax/material-requests/store\",\"pm.ajax.material-requests.set-status\":\"/pm/ajax/material-requests/set-status/{requestHeader}\",\"pm.ajax.transfer-products.get-lines\":\"/pm/ajax/transfer-products/get-lines\",\"pm.ajax.transfer-products.get-item\":\"/pm/ajax/transfer-products/get-item\",\"pm.ajax.transfer-products.store\":\"/pm/ajax/transfer-products/store\",\"pm.ajax.transfer-products.set-status\":\"/pm/ajax/transfer-products/set-status/{header}\",\"pm.ajax.send-cigarettes.get-lines\":\"/pm/ajax/send-cigarettes/get-lines\",\"pm.ajax.send-cigarettes.get-item\":\"/pm/ajax/send-cigarettes/get-item\",\"pm.ajax.send-cigarettes.store\":\"/pm/ajax/send-cigarettes/store\",\"pm.ajax.send-cigarettes.set-status\":\"/pm/ajax/send-cigarettes/set-status/{header}\",\"pm.ajax.wip-requests.get-lines\":\"/pm/ajax/wip-requests/get-lines\",\"pm.ajax.wip-requests.get-item\":\"/pm/ajax/wip-requests/get-item\",\"pm.ajax.wip-requests.store\":\"/pm/ajax/wip-requests/store\",\"pm.ajax.wip-requests.set-status\":\"/pm/ajax/wip-requests/set-status/{header}\",\"pm.ajax.jams.get-lines\":\"/pm/ajax/jams/get-lines\",\"pm.ajax.jams.get-item\":\"/pm/ajax/jams/get-item\",\"pm.ajax.jams.store\":\"/pm/ajax/jams/store\",\"pm.ajax.jams.set-status\":\"/pm/ajax/jams/set-status/{header}\",\"pm.ajax.ingredient-preparation-qrcode\":\"/pm/ajax/ingredient-preparation-qrcode\",\"pm.ajax.ingredient-preparation-detail\":\"/pm/ajax/ingredient-preparation-detail\",\"pm.ajax.sprinkle-tobaccos.get-lines\":\"/pm/ajax/sprinkle-tobaccos/get-lines\",\"pm.ajax.sprinkle-tobaccos.get-item\":\"/pm/ajax/sprinkle-tobaccos/get-item\",\"pm.ajax.sprinkle-tobaccos.store\":\"/pm/ajax/sprinkle-tobaccos/store\",\"pm.ajax.sprinkle-tobaccos.cancel\":\"/pm/ajax/sprinkle-tobaccos/cancel\",\"pm.ajax.sprinkle-tobaccos.set-status\":\"/pm/ajax/sprinkle-tobaccos/set-status/{header}\",\"pm.material-requests.index\":\"/pm/material-requests\",\"pm.transfer-products.index\":\"/pm/transfer-products\",\"pm.send-cigarettes.index\":\"/pm/send-cigarettes\",\"pm.wip-requests.index\":\"/pm/wip-requests\",\"pm.jams.index\":\"/pm/jams\",\"pm.ingredient-preparation.index\":\"/pm/ingredient-preparation\",\"pm.ingredient-preparation.print-pdf\":\"/pm/ingredient-preparation/print-pdf\",\"pm.sprinkle-tobaccos.index\":\"/pm/sprinkle-tobaccos\",\"pm.ajax.qrcode-check-mtls.detail\":\"/pm/ajax/qrcode-check-mtls/detail\",\"pm.ajax.qrcode-transfer-mtls.detail\":\"/pm/ajax/qrcode-transfer-mtls/detail\",\"pm.ajax.qrcode-rcv-transfer-mtls.detail\":\"/pm/ajax/qrcode-rcv-transfer-mtls/detail\",\"pm.ajax.qrcode-return-mtls.detail\":\"/pm/ajax/qrcode-return-mtls/detail\",\"pm.qrcode-check-mtls.index\":\"/pm/qrcode-check-mtls\",\"pm.qrcode-transfer-mtls.index\":\"/pm/qrcode-transfer-mtls\",\"pm.qrcode-rcv-transfer-mtls.index\":\"/pm/qrcode-rcv-transfer-mtls\",\"pm.qrcode-return-mtls.index\":\"/pm/qrcode-return-mtls\",\"ajax.pm.planning-jobs.index\":\"/ajax/pm/planning-jobs\",\"pm.planning-jobs.index\":\"/pm/planning-jobs\",\"pm.ajax.confirm-order.store\":\"/pm/ajax/confirm-order\",\"pm.ajax.confirm-order.get-lines\":\"/pm/ajax/confirm-order/get-lines\",\"pm.ajax.confirm-order.get-distributions\":\"/pm/ajax/confirm-order/get-distributions\",\"pm.ajax.confirm-order.get-wipstep\":\"/pm/ajax/confirm-order/get-wipstep\",\"pm.ajax.confirm-order.get-search\":\"/pm/ajax/confirm-order/get-search\",\"pm.ajax.confirm-order.get-headers-by-date\":\"/pm/ajax/confirm-order/get-headers-by-date\",\"pm.ajax.confirm-order.update-orders\":\"/pm/ajax/confirm-order-update\",\"pm.confirm-order.index\":\"/pm/confirm-order\",\"pm.sample-report.report\":\"/pm/sample-report/{number}\",\"pm.sample-report.report1-pdf\":\"/pm/sample-report1-pdf/{number}\",\"pm.sample-report.report-inventory-pdf\":\"/pm/sample-report-inventory-pdf/{batchNo}/{departmentCode}/{txnDate}\",\"pm.sample-report.report-summary-pdf\":\"/pm/sample-report-summary-pdf/{departmentCode}/{startDate}/{endDate}\",\"pm.sample-report.report-vue\":\"/pm/sample-report-vue\",\"pm.sample-report.report1\":\"/pm/sample-report1\",\"pm.sample-report.report2\":\"/pm/sample-report2\",\"pm.sample-report.testPdf\":\"/pm/test-pdf\",\"pm.ajax.wip-confirm.importMesData\":\"/pm/ajax/wip-confirm/importMesData\",\"pm.ajax.wip-confirm.lines\":\"/pm/ajax/wip-confirm/lines\",\"pm.ajax.wip-confirm.store\":\"/pm/ajax/wip-confirm/store\",\"pm.wip-confirm.index\":\"/pm/wip-confirm\",\"pm.wip-confirm.search\":\"/pm/wip-confirm/search\",\"pm.wip-confirm.jobs\":\"/pm/wip-confirm/jobs\",\"pm.wip-confirm.export-pdf-parameters\":\"/pm/wip-confirm/export-pdf-parameters/{report_code}\",\"pm.wip-confirm.export-pdf\":\"/pm/wip-confirm/export-pdf\",\"pm.ajax.get-me-review-issues-v\":\"/pm/ajax/get-mes-review-issues\",\"pm.ajax.opt-from-blend-no\":\"/pm/ajax/get-opt-from-blend-no\",\"pm.ajax.get-oprn-by-item\":\"/pm/ajax/get-oprn-by-item\",\"pm.ajax.get-formulas\":\"/pm/ajax/get-formulas\",\"pm.ajax.save-data\":\"/pm/ajax/save-data\",\"pm.ajax.update-data\":\"/pm/ajax/update-data\",\"pm.ajax.find-classification\":\"/pm/ajax/find-classification\",\"pm.ajax.get-headers\":\"/pm/ajax/get-headers\",\"pm.ajax.cancel-data\":\"/pm/ajax/cancel-data\",\"pm.ajax.search-header\":\"/pm/ajax/search-header\",\"pm.wip-issue.index\":\"/pm/wip-issue\",\"pm.wip-issue.casing-flavor-index\":\"/pm/wip-issue/casing-flavor\",\"pm.wip-issue.issue\":\"/pm/wip-issue/issue\",\"pm.wip-issue.cut_of\":\"/pm/wip-issue/cut_of\",\"pd.ajax.exp-formulas.get-lines\":\"/pd/ajax/exp-formulas/get-lines\",\"pd.ajax.exp-formulas.get-data\":\"/pd/ajax/exp-formulas/get-data\",\"pd.ajax.exp-formulas.compare-data\":\"/pd/ajax/exp-formulas/compare-data\",\"pd.ajax.exp-formulas.store\":\"/pd/ajax/exp-formulas/store\",\"pd.ajax.exp-formulas.set-status\":\"/pd/ajax/exp-formulas/set-status/{header}\",\"pd.ajax.adj-sal-forecasts.store\":\"/pd/ajax/adj-sal-forecasts/store\",\"pd.ajax.adj-sal-forecasts.update\":\"/pd/ajax/adj-sal-forecasts/{adjSalForecastHT}/update\",\"pd.ajax.adj-sal-forecasts.modal-create-details\":\"/pd/ajax/adj-sal-forecasts/modal-create-details\",\"pd.ajax.adj-sal-forecasts.modal-search-details\":\"/pd/ajax/adj-sal-forecasts/modal-search-details\",\"pd.exp-formulas.index\":\"/pd/exp-formulas\",\"pd.adj-sal-forecasts.index\":\"/pd/adj-sal-forecasts\",\"ct.cost_center.index\":\"/ct/cost_center\",\"ct.cost_center.create\":\"/ct/cost_center/create\",\"ct.cost_center.edit\":\"/ct/cost_center/{cost_center_id}\",\"ct.specify_percentage.create\":\"/ct/specify_percentage\",\"ct.product_group.index\":\"/ct/product_group\",\"ct.criterion_allocate.index\":\"/ct/criterion_allocate\",\"ct.set_account_type.index\":\"/ct/set_account_type\",\"ct.account_code_ledger.index\":\"/ct/account_code_ledger\",\"ct.agency.show\":\"/ct/agency/{flex_value_set_id}\",\"ct.specify_agency.index\":\"/ct/specify_agency\",\"ct.product_plan_amount.index\":\"/ct/product_plan_amount\",\"ct.purchase_price_info.index\":\"/ct/purchase_price_info\",\"ct.tax_medicine.index\":\"/ct/tax_medicine\",\"ct.tax_medicine.create\":\"/ct/tax_medicine/create\",\"ct.tax_medicine.edit\":\"/ct/tax_medicine/{tax_medicine}\",\"ct.ajax.account.index\":\"/ct/ajax/account\",\"ct.ajax.ptgl_accounts_info.get_data_by_segment\":\"/ct/ajax/get_data_by_segment/{segment}\",\"ct.ajax.ptpm_item_number_v.get_category\":\"/ct/ajax/get_category\",\"ct.ajax.ptpm_item_number_v.get_organizations\":\"/ct/ajax/get_organizations\",\"ct.ajax.ptpm_item_number_v.organizationSourceItemCost\":\"/ct/ajax/organization_source_item_cost\",\"ct.ajax.\":\"/ct/ajax/inv_org\",\"ct.ajax.ptpm_item_number_v.get_raw_material\":\"/ct/ajax/get_raw_material\",\"ct.ajax.cost_center.\":\"/ct/ajax/cost_center\",\"ct.ajax.cost_center.index\":\"/ct/ajax/cost_center\",\"ct.ajax.cost_center.find\":\"/ct/ajax/cost_center/find\",\"ct.ajax.cost_center.update_active\":\"/ct/ajax/cost_center/update_active\",\"ct.ajax.cost_center.period_years\":\"/ct/ajax/cost_center/period_years\",\"ct.ajax.cost_center.update_ct\":\"/ct/ajax/cost_center/update_ct\",\"ct.ajax.cost_center.update\":\"/ct/ajax/cost_center/update\",\"ct.ajax.cost_center.years\":\"/ct/ajax/cost_center/years\",\"ct.ajax.cost_center.codes\":\"/ct/ajax/cost_center/codes\",\"ct.ajax.cost_center.ptpm_items\":\"/ct/ajax/cost_center/ptpm_items\",\"ct.ajax.product_group.index\":\"/ct/ajax/product_group\",\"ct.ajax.product_group.find\":\"/ct/ajax/product_group/find\",\"ct.ajax.product_group.copy.get\":\"/ct/ajax/product_group/copy/{code}\",\"ct.ajax.product_group.copy.post\":\"/ct/ajax/product_group/copy\",\"ct.ajax.product_group_detail.update\":\"/ct/ajax/product_group_detail/update\",\"ct.ajax.product_group_detail.findWithProductGroup\":\"/ct/ajax/product_group_detail/find_pg/{product_group_id}\",\"ct.ajax.product_plan_amount.update\":\"/ct/ajax/product_plan_amount/update\",\"ct.ajax.product_processes.update\":\"/ct/ajax/product_processes\",\"ct.ajax.product_processes.show\":\"/ct/ajax/product_processes/{cost_center_id}\",\"ct.ajax.designate_agency.get_department\":\"/ct/ajax/designate_agency/get_department\",\"ct.ajax.set_account_type.getListSetAccountType\":\"/ct/ajax/set_account_type\",\"ct.ajax.set_account_type.update\":\"/ct/ajax/set_account_type/update\",\"ct.ajax.agency.update\":\"/ct/ajax/agency/update\",\"ct.ajax.account_code_ledger.store\":\"/ct/ajax/account_code_ledger\",\"ct.ajax.criterion_allocate.index\":\"/ct/ajax/criterion_allocate\",\"ct.ajax.criterion_allocate.update\":\"/ct/ajax/criterion_allocate/update\",\"ct.ajax.tax_medicine.index\":\"/ct/ajax/tax_medicine\",\"ct.ajax.tax_medicine.store\":\"/ct/ajax/tax_medicine\",\"ct.ajax.tax_medicine.determine\":\"/ct/ajax/tax_medicine/determine\",\"ct.ajax.tax_medicine.not_determine\":\"/ct/ajax/tax_medicine/not_determine\",\"ct.ajax.tax_medicine.update\":\"/ct/ajax/tax_medicine/{item_number}\",\"ct.ajax.tax_medicine.show\":\"/ct/ajax/tax_medicine/{item_number}\",\"ct.ajax.purchase_price_info.index\":\"/ct/ajax/purchase_price_info\",\"ct.ajax.purchase_price_info.store\":\"/ct/ajax/purchase_price_info\",\"ct.ajax.purchase_price_info.updateLine\":\"/ct/ajax/purchase_price_info/line/{std_mcl_id}\",\"ct.ajax.purchase_price_info.updateStatus\":\"/ct/ajax/purchase_price_info/update_status/{std_mch_id}\",\"pm.ajax.additive-inventory-alert.index\":\"/pm/ajax/additive-inventory-alert\",\"pm.ajax.additive-inventory-alert.store\":\"/pm/ajax/additive-inventory-alert/store\",\"pm.ajax.additive-inventory-alert.getTypeOrder\":\"/pm/ajax/additive-inventory-alert/get-type-order\",\"pm.ajax.additive-inventory-alert.saveReportNumber\":\"/pm/ajax/additive-inventory-alert/save-report-number\",\"pm.ajax.additive-inventory-alert.productLists\":\"/pm/ajax/additive-inventory-alert/product-lists\",\"pm.ajax.raw-material-inventory-alert.index\":\"/pm/ajax/raw-material-inventory-alert\",\"pm.ajax.raw-material-inventory-alert.store\":\"/pm/ajax/raw-material-inventory-alert/store\",\"pm.ajax.raw-material-inventory-alert.productLists\":\"/pm/ajax/raw-material-inventory-alert/product-lists\",\"pm.ajax.raw_material_report.index\":\"/pm/ajax/raw_material_report\",\"pm.ajax.raw_material_report.update-flag\":\"/pm/ajax/raw_material_report/update-flag\",\"pm.ajax.raw_material_list.index\":\"/pm/ajax/raw_material_list/get-cate\",\"pm.ajax.raw_material_list.find\":\"/pm/ajax/raw_material_list/find\",\"pm.ajax.raw_material_list.image-upload\":\"/pm/ajax/raw_material_list/image-upload\",\"pm.ajax.raw_material_list.image-remove\":\"/pm/ajax/raw_material_list/image-remove\",\"pm.ajax.raw_material_list.store\":\"/pm/ajax/raw_material_list/store\",\"pm.additive_inventory_alert.index\":\"/pm/0039\",\"pm.raw_material_inventory_alert.index\":\"/pm/0040\",\"pm.raw_material_list.index\":\"/pm/raw_material_list\",\"pm.raw_material_list.request-raw-material\":\"/pm/raw_material_list/request-raw-material\",\"pm.raw_material_list.inform-raw-material\":\"/pm/raw_material_list/inform-raw-material\",\"pm.raw_material_report.index\":\"/pm/raw_material_report\",\"pm.ajax.store\":\"/pm/ajax/request-raw-materials\",\"pm.ajax.update\":\"/pm/ajax/request-raw-materials/{id}\",\"pm.ajax.getListItemConvUomV\":\"/pm/ajax/get-list-item-conv-uomv\",\"pm.request-raw-materials.\":\"/pm/request-raw-materials\",\"pm.ajax.wip-loss-quantity.lines\":\"/pm/ajax/wip-loss-quantity/lines\",\"pm.ajax.wip-loss-quantity.store\":\"/pm/ajax/wip-loss-quantity/store\",\"pm.wip-loss-quantity.index\":\"/pm/wip-loss-quantity\",\"report.ajax.get-report-programs\":\"/report/ajax/get-report-programs\",\"report.ajax.report-get-info\":\"/ir/ajax/ir-report-get-info\",\"report.ajax.report-get-info-attribute\":\"/ir/ajax/ir-report-get-info-attribute\",\"report.ajax.ir-report-submit\":\"/ir/ajax/ir-report-submit\",\"report.report-info.index\":\"/report/report-info\",\"report.report-info.report.export\":\"/report/report-info/reports/export\",\"report.report-info.report.index\":\"/report/report-info\",\"report.report-info.report.get-param\":\"/report/report-info/reports/get-param\",\"report.report-info.report-info.index\":\"/ir/settings/report-info\",\"report.report-info.report-info.show\":\"/ir/settings/report-info/{program}\",\"report.report-info.report-info.store\":\"/ir/settings/report-info/{program}\",\"report.report-info.report-info.update\":\"/ir/settings/report-info/{program}/{info}\",\"report.report-info.report-info.destroy\":\"/ir/settings/report-info/{program}/{info}/delete\",\"pm.ajax.pmp0031.process\":\"/pm/ajax/pmp0031/process\",\"pm.ajax.get-sale-forecasts\":\"/pm/ajax/pmp0031/get-sale-forecasts\",\"pm.ajax.get-biweeklies\":\"/pm/ajax/pmp0031/get-biweeklies\",\"pm.ajax.pmp0031.open-Job\":\"/pm/ajax/pmp0031/open-Job\",\"pm.pmp-0031.index\":\"/pm/pmp_0031\",\"om.claim/claim-approve.index\":\"/om/claim/claim-approve\",\"om.claim/request-for-change.requestForChange\":\"/om/claim/request-for-change\",\"om.claim/request-for-change.requestPdf\":\"/om/claim/request-for-change/v1/print-pdf\",\"om.claim/request-for-change.requestClaimPdf\":\"/om/claim/request-for-change/v1/print-claim-pdf\",\"om.api.getClaimNumber\":\"/om/api/claim/get-claim-number\",\"om.api.getListHeader\":\"/om/api/claim/get-claim-list\",\"om.api.claimStatusList\":\"/om/api/claim/get-status-list\",\"om.api.updateHeader\":\"/om/api/claim/update-header\",\"om.api.closeHeaderClaim\":\"/om/api/claim/close-header\",\"om.api.get.list-invoice\":\"/om/api/claim/list-invoice\",\"om.api.get.genarateClaimDoc\":\"/om/api/claim/gen-claim-doc\",\"om.api.get.claimStatusList\":\"/om/api/claim/get-status-list\",\"api.om.\":\"/api/om/track-claim/getSearch\"}");

/***/ })

}]);