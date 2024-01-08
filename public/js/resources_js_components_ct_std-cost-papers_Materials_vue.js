(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_std-cost-papers_Materials_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableStdCostPrds__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./TableStdCostPrds */ "./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



 // import TableStdCostItems from "./TableStdCostItems";

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default()),
    TableStdCostPrds: _TableStdCostPrds__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ["defaultData", "periodYearData", "periodFrom", "periodTo", "allocateTypes", "yearControl", "stdcostHead", "stdcostPrds", "stdcostPrdsNot", "stdcostMaterials"],
  mounted: function mounted() {
    if (!this.yearControl) {
      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19 \u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A , \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07", "error");
    } else {
      if (!this.stdcostHead) {
        swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19 \u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A \u0E1B\u0E35\u0E1A\u0E31\u0E0D\u0E0A\u0E35\u0E07\u0E1A\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13: ".concat(this.periodYearLabel, ", \u0E41\u0E1C\u0E19\u0E01\u0E32\u0E23\u0E1C\u0E25\u0E34\u0E15\u0E04\u0E23\u0E31\u0E49\u0E07\u0E17\u0E35\u0E48: ").concat(this.yearControl.plan_version_no, ", \u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19: ").concat(this.yearControl.cost_code, " ").concat(this.yearControl.cost_description, ", \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07"), "error");
      }
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
      periodYear: this.periodYearData.period_year,
      periodYearLabel: this.periodYearData.period_year_thai,
      // isTablePrdActive: true,
      // isTableItemActive: false,
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
    // toggleShowTable(showTable) {
    //     this.isTablePrdActive = false;
    //     this.isTableItemActive = false;
    //     this.$nextTick(() => {
    //         if(showTable == 'prd'){ this.isTablePrdActive = true; }
    //         if(showTable == 'item'){ this.isTableItemActive = true; }
    //     });
    // },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableStdCostTargets__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableStdCostTargets */ "./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue");
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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "stdcostHead", "stdcostPrdItem", "stdcostMaterials", "allocateTypes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default()),
    TableStdCostTargets: _TableStdCostTargets__WEBPACK_IMPORTED_MODULE_4__.default
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    stdcostHead: function stdcostHead(value) {
      this.stdcostHeadData = value;
    },
    stdcostPrdItem: function stdcostPrdItem(value) {
      this.stdcostPrdItemData = value;
    },
    stdcostMaterials: function stdcostMaterials(value) {
      this.stdcostMaterialItems = value.map(function (item) {
        return _objectSpread({}, item);
      });
    }
  },
  data: function data() {
    var _this = this;

    return {
      periodYear: this.periodYearValue,
      stdcostHeadData: this.stdcostHead,
      stdcostPrdItemData: this.stdcostPrdItem,
      stdcostMaterialItems: this.stdcostMaterials.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          allocate_type_label: _this.getAllocateTypeLabel(_this.allocateTypes, item.allocate_type)
        });
      }),
      isLoading: false
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _TableStdCostItems__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./TableStdCostItems */ "./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue");
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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "stdcostHead", "stdcostPrds", "stdcostMaterials", "allocateTypes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default()),
    TableStdCostItems: _TableStdCostItems__WEBPACK_IMPORTED_MODULE_4__.default
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    stdcostHead: function stdcostHead(value) {
      this.stdcostHeadData = value;
    },
    stdcostPrds: function stdcostPrds(data) {
      this.stdcostPrdItems = data.map(function (item) {
        return _objectSpread({}, item);
      });
    },
    stdcostMaterials: function stdcostMaterials(data) {
      this.stdcostMaterialItems = data.map(function (item) {
        return _objectSpread({}, item);
      });
    }
  },
  data: function data() {
    var _this = this;

    return {
      periodYear: this.periodYearValue,
      stdcostHeadData: this.stdcostHead,
      stdcostPrdItems: this.stdcostPrds.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          allocate_type_label: _this.getAllocateTypeLabel(_this.allocateTypes, item.allocate_type)
        });
      }),
      stdcostMaterialItems: this.stdcostMaterials.map(function (item) {
        return _objectSpread({}, item);
      }),
      selectedStdCostPrdItem: null,
      selectedStdcostMaterialItems: [],
      isLoading: false
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
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
    showStdcostMaterialItems: function showStdcostMaterialItems(stdcostPrdItem) {
      this.selectedStdCostPrdItem = stdcostPrdItem;
      this.selectedStdcostMaterialItems = this.stdcostMaterialItems.filter(function (item) {
        return item.product_group == stdcostPrdItem.product_group && item.product_item_number == stdcostPrdItem.product_item_number && item.product_lot_number == stdcostPrdItem.product_lot_number;
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "yearControl", "stdcostYear", "stdcostAccount", "stdcostTargets"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    yearControl: function yearControl(value) {
      this.yearControlData = value;
    },
    stdcostYear: function stdcostYear(value) {
      this.stdcostYearData = value;
    },
    stdcostAccount: function stdcostAccount(value) {
      this.stdcostAccountData = value;
    },
    stdcostTargets: function stdcostTargets(value) {
      this.stdcostTargetItems = value;
      this.stdcostTgPrdGroups = [];
      this.stdcostTgItems = [];

      if (this.stdcostTargetItems.length == 1) {
        this.getStdcostTgPrdGroups(this.stdcostTargetItems[0]);
      }
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      yearControlData: this.yearControl,
      stdcostYearData: this.stdcostYear,
      stdcostAccountData: this.stdcostAccount,
      stdcostTargetItems: this.stdcostTargets,
      stdcostTgPrdGroups: [],
      stdcostTgItems: [],
      isTableTargetActive: true,
      isTableTgItemActive: false,
      isTableTgPrdGroupActive: false,
      isLoading: false
    };
  },
  mounted: function mounted() {// this.emitStdcostTargetsChanged();
  },
  computed: {},
  methods: {
    toggleShowTable: function toggleShowTable(showTable) {
      var _this = this;

      this.isTableTargetActive = false;
      this.isTableTgItemActive = false;
      this.isTableTgPrdGroupActive = false;
      this.$nextTick(function () {
        if (showTable == 'target') {
          _this.isTableTargetActive = true;
        }

        if (showTable == 'tgItem') {
          _this.isTableTgItemActive = true;
        }

        if (showTable == 'tgPrdGroup') {
          _this.isTableTgPrdGroupActive = true;
        }
      });
    },
    onGetStdcostTgPrdGroups: function onGetStdcostTgPrdGroups(stdcostTarget) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this2.getStdcostTgPrdGroups(stdcostTarget);

              case 2:
                if (_this2.stdcostTgPrdGroups.length > 0) {
                  _this2.toggleShowTable('tgPrdGroup');
                }

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getStdcostTgPrdGroups: function getStdcostTgPrdGroups(stdcostTarget) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var stdcostYear, stdcostAccount, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                stdcostYear = _this3.stdcostYearData;
                stdcostAccount = _this3.stdcostAccountData; // show loading

                _this3.isLoading = true;
                params = {
                  period_year: _this3.periodYear,
                  year_control: JSON.stringify(_this3.yearControlData),
                  stdcost_year: JSON.stringify(stdcostYear),
                  stdcost_account: JSON.stringify(stdcostAccount),
                  stdcost_target: JSON.stringify(stdcostTarget)
                };
                _context2.next = 6;
                return axios.get("/ajax/ct/std-cost-papers/account-targets/tg-prd-groups", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this3.stdcostTgPrdGroups = resData.stdcost_tg_prd_groups ? JSON.parse(resData.stdcost_tg_prd_groups) : [];
                    _this3.stdcostTgItems = [];

                    if (_this3.stdcostTgPrdGroups.length <= 0) {
                      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C \u0E02\u0E2D\u0E07 \u0E23\u0E2B\u0E31\u0E2A\u0E1A\u0E31\u0E0D\u0E0A\u0E35 : ".concat(stdcostTarget.account_code, " ").concat(stdcostTarget.account_desc, " | ").concat(resData.message), "error");
                    } else {
                      if (_this3.stdcostTgPrdGroups.length == 1) {
                        _this3.getStdcostTgItems(_this3.stdcostTgPrdGroups[0]);
                      }
                    }
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 6:
                // hide loading
                _this3.isLoading = false;

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onGetStdcostTgItems: function onGetStdcostTgItems(stdcostTgPrdGroup) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _context3.next = 2;
                return _this4.getStdcostTgItems(stdcostTgPrdGroup);

              case 2:
                if (_this4.stdcostTgItems.length > 0) {
                  _this4.toggleShowTable('tgItem');
                }

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getStdcostTgItems: function getStdcostTgItems(stdcostTgPrdGroup) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var stdcostYear, stdcostAccount, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                stdcostYear = _this5.stdcostYearData;
                stdcostAccount = _this5.stdcostAccountData; // show loading

                _this5.isLoading = true;
                params = {
                  period_year: _this5.periodYear,
                  year_control: JSON.stringify(_this5.yearControlData),
                  stdcost_year: JSON.stringify(stdcostYear),
                  stdcost_account: JSON.stringify(stdcostAccount),
                  stdcost_tg_prd_group: JSON.stringify(stdcostTgPrdGroup)
                };
                _context4.next = 6;
                return axios.get("/ajax/ct/std-cost-papers/account-targets/tg-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "success") {
                    _this5.stdcostTgItems = resData.stdcost_tg_items ? JSON.parse(resData.stdcost_tg_items) : [];

                    if (_this5.stdcostTgItems.length <= 0) {
                      swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C \u0E02\u0E2D\u0E07 \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C : ".concat(stdcostTgPrdGroup.product_group, " ").concat(stdcostTgPrdGroup.product_group_desc, " | ").concat(resData.message), "error");
                    }
                  } else {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 6:
                // hide loading
                _this5.isLoading = false;

              case 7:
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

/***/ "./resources/js/components/ct/std-cost-papers/Materials.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/Materials.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Materials_vue_vue_type_template_id_475129e7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Materials.vue?vue&type=template&id=475129e7& */ "./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=template&id=475129e7&");
/* harmony import */ var _Materials_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Materials.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Materials_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Materials_vue_vue_type_template_id_475129e7___WEBPACK_IMPORTED_MODULE_0__.render,
  _Materials_vue_vue_type_template_id_475129e7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/Materials.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableStdCostItems_vue_vue_type_template_id_e8cc3c8e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableStdCostItems.vue?vue&type=template&id=e8cc3c8e& */ "./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=template&id=e8cc3c8e&");
/* harmony import */ var _TableStdCostItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableStdCostItems.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableStdCostItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableStdCostItems_vue_vue_type_template_id_e8cc3c8e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableStdCostItems_vue_vue_type_template_id_e8cc3c8e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableStdCostItems.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableStdCostPrds_vue_vue_type_template_id_5797cca8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableStdCostPrds.vue?vue&type=template&id=5797cca8& */ "./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=template&id=5797cca8&");
/* harmony import */ var _TableStdCostPrds_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableStdCostPrds.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableStdCostPrds_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableStdCostPrds_vue_vue_type_template_id_5797cca8___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableStdCostPrds_vue_vue_type_template_id_5797cca8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableStdCostTargets_vue_vue_type_template_id_0866148a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableStdCostTargets.vue?vue&type=template&id=0866148a& */ "./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=template&id=0866148a&");
/* harmony import */ var _TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableStdCostTargets.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableStdCostTargets_vue_vue_type_template_id_0866148a___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableStdCostTargets_vue_vue_type_template_id_0866148a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Materials_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Materials.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Materials_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostItems.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostPrds_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostPrds.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostPrds_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostTargets.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=template&id=475129e7&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=template&id=475129e7& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Materials_vue_vue_type_template_id_475129e7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Materials_vue_vue_type_template_id_475129e7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Materials_vue_vue_type_template_id_475129e7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Materials.vue?vue&type=template&id=475129e7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=template&id=475129e7&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=template&id=e8cc3c8e&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=template&id=e8cc3c8e& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostItems_vue_vue_type_template_id_e8cc3c8e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostItems_vue_vue_type_template_id_e8cc3c8e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostItems_vue_vue_type_template_id_e8cc3c8e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostItems.vue?vue&type=template&id=e8cc3c8e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=template&id=e8cc3c8e&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=template&id=5797cca8&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=template&id=5797cca8& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostPrds_vue_vue_type_template_id_5797cca8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostPrds_vue_vue_type_template_id_5797cca8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostPrds_vue_vue_type_template_id_5797cca8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostPrds.vue?vue&type=template&id=5797cca8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=template&id=5797cca8&");


/***/ }),

/***/ "./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=template&id=0866148a&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=template&id=0866148a& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_template_id_0866148a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_template_id_0866148a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableStdCostTargets_vue_vue_type_template_id_0866148a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableStdCostTargets.vue?vue&type=template&id=0866148a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=template&id=0866148a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=template&id=475129e7&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/Materials.vue?vue&type=template&id=475129e7& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
                      value: _vm.stdcostHead
                        ? _vm.stdcostHead.cost_group_desc
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
          _c("br"),
          _vm._v(" "),
          _c(
            "div",
            {
              staticStyle: {
                "background-color": "#d9d9d9",
                color: "black",
                "font-size": "16px",
                "font-weight": "bold",
                padding: "3px 5px 3px 5px"
              }
            },
            [
              _vm._v(
                "\n            ผลิตภัณฑ์ที่ยังไม่อนุมัติต้นทุนวัตถุดิบ\n        "
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }),
          _vm._v(" "),
          _c("table-std-cost-prds", {
            attrs: {
              "period-year-value": _vm.periodYear,
              "allocate-types": _vm.allocateTypes,
              "stdcost-head": _vm.stdcostHead,
              "stdcost-prds": _vm.stdcostPrdsNot,
              "stdcost-materials": _vm.stdcostMaterials
            }
          }),
          _vm._v(" "),
          _c("hr"),
          _vm._v(" "),
          _c("br"),
          _vm._v(" "),
          _c(
            "div",
            {
              staticStyle: {
                "background-color": "#d9d9d9",
                color: "black",
                "font-size": "16px",
                "font-weight": "bold",
                padding: "3px 5px 3px 5px"
              }
            },
            [
              _vm._v(
                "\n            ผลิตภัณฑ์ที่อนุมัติต้นทุนวัตถุดิบแล้ว\n         "
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mb-5" }),
          _vm._v(" "),
          _c(
            "div",
            [
              _c("table-std-cost-prds", {
                attrs: {
                  "period-year-value": _vm.periodYear,
                  "allocate-types": _vm.allocateTypes,
                  "stdcost-head": _vm.stdcostHead,
                  "stdcost-prds": _vm.stdcostPrds,
                  "stdcost-materials": _vm.stdcostMaterials
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=template&id=e8cc3c8e&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostItems.vue?vue&type=template&id=e8cc3c8e& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
    _c("hr"),
    _vm._v(" "),
    _c("h3", [_vm._v(" รายละเอียดวัตถุดิบ ")]),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-3" }, [
        _c("p", [
          _vm._v(
            " กลุ่มผลิตภัณฑ์ : " +
              _vm._s(_vm.stdcostPrdItemData.product_group) +
              " (" +
              _vm._s(_vm.stdcostPrdItemData.product_group_name) +
              ") "
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-3" }, [
        _c("p", [
          _vm._v(
            " ผลิตภัณฑ์ : " +
              _vm._s(
                _vm.stdcostPrdItemData.product_item_number
                  ? _vm.stdcostPrdItemData.product_item_number
                  : "-"
              ) +
              " "
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-3" }, [
        _c("p", [
          _vm._v(
            " ชื่อผลิตภัณฑ์ : " +
              _vm._s(
                _vm.stdcostPrdItemData.product_item_desc
                  ? _vm.stdcostPrdItemData.product_item_desc
                  : "-"
              ) +
              " "
          )
        ])
      ])
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
          "table",
          {
            staticClass: "table table-bordered table-sticky mb-0",
            staticStyle: { "min-width": "1600px" }
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm.stdcostMaterialItems.length > 0
              ? _c(
                  "tbody",
                  [
                    _vm._l(_vm.stdcostMaterialItems, function(
                      stdcostMaterialItem,
                      index
                    ) {
                      return [
                        _c("tr", { key: index }, [
                          _c(
                            "td",
                            { staticClass: "text-center md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(stdcostMaterialItem.product_group) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    stdcostMaterialItem.product_item_number
                                  ) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(stdcostMaterialItem.item_number) +
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
                                  _vm._s(stdcostMaterialItem.item_desc) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(stdcostMaterialItem.uom_code) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(stdcostMaterialItem.wip_step) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(stdcostMaterialItem.type_name) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-right md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    stdcostMaterialItem.quantity_used
                                      ? Number(
                                          stdcostMaterialItem.quantity_used
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
                            { staticClass: "text-right md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    stdcostMaterialItem.quantity_lost
                                      ? Number(
                                          stdcostMaterialItem.quantity_lost
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
                            { staticClass: "text-right md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    stdcostMaterialItem.last_cost
                                      ? Number(
                                          stdcostMaterialItem.last_cost
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
                            { staticClass: "text-right md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    stdcostMaterialItem.cost_raw_mate
                                      ? Number(
                                          stdcostMaterialItem.cost_raw_mate
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
                            { staticClass: "text-right md:tw-table-cell" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    stdcostMaterialItem.unit_std_cost
                                      ? Number(
                                          stdcostMaterialItem.unit_std_cost
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
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "6%" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "8%" }
          },
          [_vm._v(" ผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "10%" }
          },
          [_vm._v(" รหัสวัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" ชื่อวัตถุดิบ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "5%" }
          },
          [_vm._v(" หน่วย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "7%" }
          },
          [_vm._v(" ขึ้นตอน ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "7%" }
          },
          [_vm._v(" ประเภท ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" จำนวนที่ใช้ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" จำนวนที่สูญเสีย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" ราคาซื้อครั้งสุดท้าย ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" จำนวนรวม ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" อัตรามาตรฐาน/หน่วย ")]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "14" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" ไม่พบข้อมูล ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=template&id=5797cca8&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostPrds.vue?vue&type=template&id=5797cca8& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
        staticStyle: { "max-height": "300px" }
      },
      [
        _c("table", { staticClass: "table table-bordered table-sticky mb-0" }, [
          _vm._m(0),
          _vm._v(" "),
          _vm.stdcostPrdItems.length > 0
            ? _c(
                "tbody",
                [
                  _vm._l(_vm.stdcostPrdItems, function(stdcostPrdItem, index) {
                    return [
                      _c("tr", { key: index }, [
                        _c(
                          "td",
                          { staticClass: "text-left md:tw-table-cell" },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(stdcostPrdItem.product_group) +
                                " : " +
                                _vm._s(stdcostPrdItem.product_group_name) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          { staticClass: "text-center md:tw-table-cell" },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(stdcostPrdItem.product_item_number) +
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
                                _vm._s(stdcostPrdItem.product_item_desc) +
                                "\n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          { staticClass: "text-right md:tw-table-cell" },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(
                                  stdcostPrdItem.cost_raw_mate
                                    ? Number(
                                        stdcostPrdItem.cost_raw_mate
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
                          { staticClass: "text-right md:tw-table-cell" },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(
                                  stdcostPrdItem.unit_cost_raw_mate
                                    ? Number(
                                        stdcostPrdItem.unit_cost_raw_mate
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
                          { staticClass: "text-center md:tw-table-cell" },
                          [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "btn btn-xs btn-inline-block btn-primary tw-w-full",
                                on: {
                                  click: function($event) {
                                    return _vm.showStdcostMaterialItems(
                                      stdcostPrdItem
                                    )
                                  }
                                }
                              },
                              [
                                _c("i", { staticClass: "fa fa-arrow-down" }),
                                _vm._v(
                                  " รายละเอียดวัตถุดิบ\n                            "
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
            : _c("tbody", [_vm._m(1)])
        ])
      ]
    ),
    _vm._v(" "),
    _vm.selectedStdCostPrdItem
      ? _c("div", { staticClass: "row tw-my-5" }, [
          _c(
            "div",
            { staticClass: "col-12" },
            [
              _c("table-std-cost-items", {
                attrs: {
                  "period-year-value": _vm.periodYear,
                  "allocate-types": _vm.allocateTypes,
                  "stdcost-head": _vm.stdcostHead,
                  "stdcost-prd-item": _vm.selectedStdCostPrdItem,
                  "stdcost-materials": _vm.selectedStdcostMaterialItems
                }
              })
            ],
            1
          )
        ])
      : _vm._e()
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
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "12%" }
          },
          [_vm._v(" ผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell",
            attrs: { width: "20%" }
          },
          [_vm._v(" ชื่อผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "18%" }
          },
          [_vm._v(" ต้นทุนวัตถุดิบรวม(บาท) ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell",
            attrs: { width: "18%" }
          },
          [_vm._v(" ต้นทุนวัตถุดิบมาตรฐานต่อ 1 หน่วย ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center tw-text-xs md:tw-table-cell",
          attrs: { width: "13%" }
        })
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=template&id=0866148a&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std-cost-papers/TableStdCostTargets.vue?vue&type=template&id=0866148a& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
      _c("div", [
        _c("div", { staticClass: "btn-group", attrs: { role: "group" } }, [
          _c(
            "button",
            {
              staticClass: "btn",
              class: [_vm.isTableTargetActive ? "btn-primary" : "btn-white"],
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.toggleShowTable("target")
                }
              }
            },
            [_vm._v(" รายการบัญชีที่ปัน ")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn",
              class: [
                _vm.isTableTgPrdGroupActive ? "btn-primary" : "btn-white"
              ],
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.toggleShowTable("tgPrdGroup")
                }
              }
            },
            [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn",
              class: [_vm.isTableTgItemActive ? "btn-primary" : "btn-white"],
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.toggleShowTable("tgItem")
                }
              }
            },
            [_vm._v(" ผลิตภัณฑ์ ")]
          )
        ])
      ]),
      _vm._v(" "),
      _vm.isTableTargetActive
        ? _c(
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
                  _vm.stdcostTargetItems.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.stdcostTargetItems, function(
                            stdcostTargetItem,
                            index
                          ) {
                            return [
                              _c("tr", { key: index }, [
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTargetItem.account_type_desc
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
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
                                      "\n                            " +
                                        _vm._s(stdcostTargetItem.account_code) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "text-left md:tw-table-cell tw-hidden",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(stdcostTargetItem.account_desc) +
                                        "\n                        "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  {
                                    staticClass:
                                      "text-left md:tw-table-cell tw-hidden",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTargetItem.allocate_type_desc
                                        ) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTargetItem.acc_actual_amount
                                            ? Number(
                                                stdcostTargetItem.acc_actual_amount
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTargetItem.acc_avg_actual_amount
                                            ? Number(
                                                stdcostTargetItem.acc_avg_actual_amount
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTargetItem.acc_budget_amount
                                            ? Number(
                                                stdcostTargetItem.acc_budget_amount
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTargetItem.acc_estimate_expense_amount
                                            ? Number(
                                                stdcostTargetItem.acc_estimate_expense_amount
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
                                  { staticClass: "text-center text-nowrap" },
                                  [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-inline-block btn-xs btn-white",
                                        on: {
                                          click: function($event) {
                                            return _vm.onGetStdcostTgPrdGroups(
                                              stdcostTargetItem
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-list tw-mr-1"
                                        }),
                                        _vm._v(
                                          " กลุ่มผลิตภัณฑ์\n                            "
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
                    : _c("tbody", [_vm._m(1)])
                ]
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableTgPrdGroupActive
        ? _c(
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
                  _vm._m(2),
                  _vm._v(" "),
                  _vm.stdcostTgPrdGroups.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.stdcostTgPrdGroups, function(
                            stdcostTgPrdGroupItem,
                            index
                          ) {
                            return [
                              _c("tr", { key: index }, [
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgPrdGroupItem.product_group
                                        ) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgPrdGroupItem.product_group_desc
                                        ) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgPrdGroupItem.ratio_rate
                                        ) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgPrdGroupItem.prd_estimate_expense_amount
                                            ? Number(
                                                stdcostTgPrdGroupItem.prd_estimate_expense_amount
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgPrdGroupItem.prd_productivity_qty
                                            ? Number(
                                                stdcostTgPrdGroupItem.prd_productivity_qty
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgPrdGroupItem.prd_estimate_per_unit
                                            ? Number(
                                                stdcostTgPrdGroupItem.prd_estimate_per_unit
                                              ).toLocaleString(undefined, {
                                                minimumFractionDigits: 9,
                                                maximumFractsionDigits: 9
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
                                  { staticClass: "text-center text-nowrap" },
                                  [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-inline-block btn-xs btn-white",
                                        on: {
                                          click: function($event) {
                                            return _vm.onGetStdcostTgItems(
                                              stdcostTgPrdGroupItem
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-list tw-mr-1"
                                        }),
                                        _vm._v(
                                          " ผลิตภัณฑ์\n                            "
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
                    : _c("tbody", [_vm._m(3)])
                ]
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.isTableTgItemActive
        ? _c(
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
                  _vm._m(4),
                  _vm._v(" "),
                  _vm.stdcostTgItems.length > 0
                    ? _c(
                        "tbody",
                        [
                          _vm._l(_vm.stdcostTgItems, function(
                            stdcostTgItem,
                            index
                          ) {
                            return [
                              _c("tr", { key: index }, [
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgItem.product_item_number
                                        ) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgItem.product_item_desc
                                        ) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(stdcostTgItem.ratio_rate) +
                                        "\n                        "
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
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgItem.item_estimate_expense_amount
                                            ? Number(
                                                stdcostTgItem.item_estimate_expense_amount
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgItem.item_productivity_qty
                                            ? Number(
                                                stdcostTgItem.item_productivity_qty
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
                                    staticClass: "text-right md:tw-table-cell",
                                    staticStyle: {
                                      "border-left": "0",
                                      "border-right": "0"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          stdcostTgItem.item_estimate_per_unit
                                            ? Number(
                                                stdcostTgItem.item_estimate_per_unit
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
                            ]
                          })
                        ],
                        2
                      )
                    : _c("tbody", [_vm._m(5)])
                ]
              )
            ]
          )
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
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าแรง/ค่าใช้จ่าย ")]
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
            attrs: { width: "8%" }
          },
          [_vm._v(" รหัสบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "12%" }
          },
          [_vm._v(" ชื่อบัญชี ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "10%" }
          },
          [_vm._v(" เกณฑ์การปันส่วน ")]
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
            attrs: { width: "13%" }
          },
          [_vm._v(" ค่าแรง/ใช้จ่ายจริง (บาท) ")]
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
            attrs: { width: "10%" }
          },
          [_vm._v(" ค่าใช้จ่ายจริงเฉลี่ย ")]
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
            attrs: { width: "13%" }
          },
          [_vm._v(" ค่าแรง/ใช้จ่ายตามงบประมาณ (บาท) ")]
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
            attrs: { width: "13%" }
          },
          [_vm._v(" ค่าแรง/ใช้จ่ายประมาณการ (บาท) ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-right tw-text-xs md:tw-table-cell",
          staticStyle: {
            "background-color": "#fff0e0",
            "border-left": "0px",
            "border-right": "0px"
          },
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
          _vm._v(" กรุณาเลือก ค่าแรง/ค่าใช้จ่าย ")
        ])
      ])
    ])
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
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "15%", colspan: "2" }
          },
          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-right tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "10%" }
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
            attrs: { width: "15%" }
          },
          [_vm._v(" ค่าแรง/ใช้จ่าย ประมาณการ (บาท) ")]
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
            attrs: { width: "15%" }
          },
          [_vm._v(" ปริมาณผลผลิตมาตรฐาน (ชิ้น/กิโลกรัม/ตร.ซม.) ")]
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
            attrs: { width: "30%" }
          },
          [_vm._v(" ค่าประมาณการ(บาท) ต่อหนึ่งหน่วย ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-right tw-text-xs md:tw-table-cell",
          staticStyle: {
            "background-color": "#fff0e0",
            "border-left": "0px",
            "border-right": "0px"
          },
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
      _c("td", { attrs: { colspan: "8" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" กรุณาเลือก รายการบัญชีที่ปัน ")
        ])
      ])
    ])
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
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "10%" }
          },
          [_vm._v(" ผลิตภัณฑ์ ")]
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
            staticClass: "text-right tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: {
              "background-color": "#fff0e0",
              "border-left": "0px",
              "border-right": "0px"
            },
            attrs: { width: "10%" }
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
            attrs: { width: "15%" }
          },
          [_vm._v(" ค่าแรง/ใช้จ่าย ประมาณการ (บาท) ")]
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
            attrs: { width: "15%" }
          },
          [_vm._v(" ปริมาณผลผลิตมาตรฐาน (ชิ้น/กิโลกรัม/ตร.ซม.) ")]
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
            attrs: { width: "30%" }
          },
          [_vm._v(" ค่าประมาณการ(บาท) ต่อหนึ่งหน่วย ")]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "8" } }, [
        _c("h2", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" กรุณาเลือก กลุ่มผลิตภัณฑ์ ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);