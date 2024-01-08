(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_oem-costs_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/Index.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/Index.vue?vue&type=script&lang=js& ***!
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
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _TableOemCostLines__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TableOemCostLines */ "./resources/js/components/ct/oem-costs/TableOemCostLines.vue");
/* harmony import */ var _ModalSearchOemCost__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./ModalSearchOemCost */ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue");


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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    TableOemCostLines: _TableOemCostLines__WEBPACK_IMPORTED_MODULE_5__.default,
    ModalSearchOemCost: _ModalSearchOemCost__WEBPACK_IMPORTED_MODULE_6__.default
  },
  props: ["defaultData", "periodYearValue", "prdgrpYearIdValue", "ct14VersionNoValue", "costCodeValue", "productGroupValue", "productItemValue", "prdgrpPlans", "ct14VersionNos", "periodYears", "existPeriodYears", "costCenters", "productGroups", "productItems", "accountCodes", "subAccountCodes", "accountTypes"],
  mounted: function mounted() {
    var _this = this;

    if (this.periodYearValue) {
      this.getListPrdgrps(this.periodYearValue);

      if (this.prdgrpYearIdValue) {
        this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpPlans, this.prdgrpYearIdValue);
        this.getListCostCenters(this.periodYearValue, this.prdgrpYearIdValue);

        if (this.costCodeValue) {
          this.costCode = this.costCodeValue;
          this.costCodeLabel = this.getCostCodeLabel(this.costCenters, this.costCode);
          this.getListVersionNos(this.periodYearValue, this.costCodeValue);

          if (this.ct14VersionNoValue) {
            this.ct14AllocateYearId = this.getAllocateYearId(this.ct14VersionNos, this.periodYearValue, this.ct14VersionNoValue, this.costCodeValue);
          }

          this.filteredProductGroups = this.productGroups.filter(function (item) {
            return item.period_year == _this.periodYearValue && item.cost_code == _this.costCodeValue && item.prdgrp_year_id == _this.prdgrpYearIdValue;
          });

          if (this.productGroupValue) {
            this.productGroup = this.productGroupValue;
            this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);
            this.filteredProductItems = this.productItems.filter(function (item) {
              return item.period_year == _this.periodYearValue && item.cost_code == _this.costCodeValue && item.prdgrp_year_id == _this.prdgrpYearIdValue && item.product_group == _this.productGroupValue;
            });

            if (this.productItemValue) {
              this.productItem = this.productItemValue;
              this.productItemLabel = this.getProductItemLabel(this.productItems, this.productItem);
            }
          }
        }
      }
    }

    if (this.periodYearValue && this.prdgrpYearIdValue && this.ct14VersionNoValue && this.costCodeValue && this.productGroupValue && this.productItemValue) {
      this.getOemCostHeaderData(this.periodYearValue, this.prdgrpYearIdValue, this.planVersionNo, this.ct14VersionNoValue, this.costCodeValue, this.productGroupValue, this.productItemValue, false);
    }
  },
  data: function data() {
    return {
      organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
      organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
      department: this.defaultData ? JSON.parse(this.defaultData).department : null,
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      filteredCt14VersionNos: [],
      ct14VersionNo: this.ct14VersionNoValue,
      ct14AllocateYearId: null,
      filteredCostCenters: [],
      costCode: this.costCodeValue,
      costCodeLabel: null,
      filteredProductGroups: [],
      productGroup: this.productGroupValue,
      productGroupLabel: null,
      filteredProductItems: [],
      productItem: this.productItemValue,
      productItemLabel: null,
      productQuantity: 0,
      filteredPrdgrpPlans: [],
      prdgrpYearId: this.prdgrpYearIdValue,
      planVersionNo: null,
      oemCostHeader: null,
      oemCostLines: [],
      selectedOemCostYearData: {},
      isLoading: false
    };
  },
  computed: {},
  methods: {
    setUrlParams: function setUrlParams() {
      var queryParams = new URLSearchParams(window.location.search);
      queryParams.set("period_year", this.periodYear ? this.periodYear : '');
      queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
      queryParams.set("prdgrp_year_id", this.prdgrpYearId ? this.prdgrpYearId : '');
      queryParams.set("ct14_version_no", this.ct14VersionNo ? this.ct14VersionNo : '');
      queryParams.set("cost_code", this.costCode ? this.costCode : '');
      queryParams.set("product_group", this.productGroup ? this.productGroup : '');
      queryParams.set("product_inventory_item_id", this.productItem ? this.productItem : ''); // queryParams.set("product_quantity", this.productQuantity ? this.productQuantity : '');

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


                _this2.oemCostHeader = null;
                _this2.oemCostLines = []; // REFRESH DATA

                _this2.productGroup = null;
                _this2.productItem = null;
                _this2.productQuantity = null;
                _this2.ct14VersionNo = null;
                _this2.ct14AllocateYearId = null;
                _this2.prdgrpYearId = null;

                _this2.getListPrdgrps(_this2.periodYear);

                _this2.getListCostCenters(_this2.periodYear, _this2.prdgrpYearId);

                _this2.getListVersionNos(_this2.periodYear, _this2.prdgrpYearId, _this2.costCode); // this.showTableOemCostLines = false;


              case 14:
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
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.prdgrpYearId = value;
                _this3.planVersionNo = _this3.getPrdgrpPlanVersionNo(_this3.prdgrpPlans, _this3.prdgrpYearId);
                _this3.oemCostHeader = null;
                _this3.oemCostLines = [];
                _this3.productQuantity = null;

                _this3.getListCostCenters(_this3.periodYear, _this3.prdgrpYearId);

                if (_this3.periodYear && _this3.costCode && _this3.prdgrpYearId) {
                  _this3.filteredProductGroups = _this3.productGroups.filter(function (item) {
                    return item.period_year == _this3.periodYear && item.cost_code == _this3.costCode && item.prdgrp_year_id == _this3.prdgrpYearId;
                  });
                } else {
                  _this3.filteredProductGroups = [];
                  _this3.filteredProductItems = [];
                }

                if (_this3.periodYear && _this3.prdgrpYearId && _this3.ct14VersionNo && _this3.costCode && _this3.productGroup && _this3.productItem) {
                  _this3.getOemCostHeaderData(_this3.periodYear, _this3.prdgrpYearId, _this3.planVersionNo, _this3.ct14VersionNo, _this3.costCode, _this3.productGroup, _this3.productItem, false);
                }

                _this3.setUrlParams();

              case 9:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onCt14VersionNoChanged: function onCt14VersionNoChanged(value) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.ct14VersionNo = value;
                _this4.ct14AllocateYearId = _this4.getAllocateYearId(_this4.ct14VersionNos, _this4.periodYear, _this4.ct14VersionNo, _this4.costCode);
                _this4.oemCostHeader = null;
                _this4.oemCostLines = [];
                _this4.productQuantity = null;

                if (_this4.periodYear && _this4.prdgrpYearId && _this4.ct14VersionNo && _this4.costCode && _this4.productGroup && _this4.productItem) {
                  _this4.getOemCostHeaderData(_this4.periodYear, _this4.prdgrpYearId, _this4.planVersionNo, _this4.ct14VersionNo, _this4.costCode, _this4.productGroup, _this4.productItem, false);
                }

                _this4.setUrlParams();

              case 7:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onCostCodeChanged: function onCostCodeChanged(value) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this5.costCode = value;
                _this5.costCodeLabel = _this5.getCostCodeLabel(_this5.costCenters, _this5.costCode);
                _this5.oemCostHeader = null;
                _this5.oemCostLines = [];

                _this5.getListVersionNos(_this5.periodYear, _this5.prdgrpYearId, _this5.costCode);

                if (_this5.periodYear && _this5.costCode && _this5.prdgrpYearId) {
                  _this5.filteredProductGroups = _this5.productGroups.filter(function (item) {
                    return item.period_year == _this5.periodYear && item.cost_code == _this5.costCode && item.prdgrp_year_id == _this5.prdgrpYearId;
                  });
                } else {
                  _this5.filteredProductGroups = [];
                  _this5.filteredProductItems = [];
                }

                _this5.productGroup = null;
                _this5.productGroupLabel = null;
                _this5.productItem = null;
                _this5.productItemLabel = null;

                _this5.setUrlParams();

              case 11:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onProductGroupChanged: function onProductGroupChanged(value) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this6.productGroup = value;
                _this6.productGroupLabel = _this6.getProductGroupLabel(_this6.productGroups, _this6.productGroup);
                _this6.oemCostHeader = null;
                _this6.oemCostLines = [];

                if (_this6.periodYear && _this6.costCode && _this6.prdgrpYearId && _this6.productGroup) {
                  _this6.filteredProductItems = _this6.productItems.filter(function (item) {
                    return item.period_year == _this6.periodYear && item.cost_code == _this6.costCode && item.prdgrp_year_id == _this6.prdgrpYearId && item.product_group == _this6.productGroup;
                  });
                } else {
                  _this6.filteredProductItems = [];
                }

                _this6.productItem = null;
                _this6.productItemLabel = null;
                _this6.productQuantity = null;

                _this6.setUrlParams();

              case 9:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    onProductItemChanged: function onProductItemChanged(value) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _this7.productItem = value;
                _this7.productItemLabel = _this7.getProductItemLabel(_this7.productItems, _this7.productItem);
                _this7.oemCostHeader = null;
                _this7.oemCostLines = [];
                _this7.productQuantity = null; // GET OEMCOST-HEADER DATA

                _context6.next = 7;
                return _this7.getOemCostHeaderData(_this7.periodYear, _this7.prdgrpYearId, _this7.planVersionNo, _this7.ct14VersionNo, _this7.costCode, _this7.productGroup, _this7.productItem, false);

              case 7:
                // // SAVE OEM COST HEADER
                // await this.onSaveOemCostHeader();
                _this7.setUrlParams();

              case 8:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onProductQuantityChanged: function onProductQuantityChanged(e) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _context7.next = 2;
                return _this8.onSaveOemCostHeader();

              case 2:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    isAllowUpdate: function isAllowUpdate() {
      var allowed = true;

      if (this.oemCostHeader && this.oemCostLines.length > 0) {
        var firstLine = this.oemCostLines[0];

        if (firstLine.transfer_data == "Y") {
          allowed = false;
        }
      }

      return allowed;
    },
    isAllowTransfer: function isAllowTransfer() {
      var allowed = false;

      if (this.oemCostHeader && this.oemCostLines.length > 0) {
        var firstLine = this.oemCostLines[0];
        var incompletedLine = this.oemCostLines.find(function (item) {
          return !item.expense_amount;
        });

        if (!incompletedLine && (!firstLine.transfer_data || firstLine.transfer_data == "N")) {
          allowed = true;
        }
      }

      return allowed;
    },
    isAllowCancelTransfer: function isAllowCancelTransfer() {
      var allowed = false;

      if (this.oemCostHeader && this.oemCostLines.length > 0) {
        var firstLine = this.oemCostLines[0];

        if (firstLine.transfer_data == "Y") {
          allowed = true;
        }
      }

      return allowed;
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
    getCostCodeLabel: function getCostCodeLabel(costCenters, costCode) {
      var result = null;

      if (costCode) {
        var foundCostCenter = costCenters.find(function (item) {
          return item.cost_code == costCode;
        });
        result = foundCostCenter ? foundCostCenter.cost_code_label : "";
      }

      return result;
    },
    getProductGroupLabel: function getProductGroupLabel(productGroups, productGroup) {
      var result = null;

      if (productGroup) {
        var foundProductGroup = productGroups.find(function (item) {
          return item.product_group == productGroup;
        });
        result = foundProductGroup ? foundProductGroup.product_group_label : "";
      }

      return result;
    },
    getProductItemLabel: function getProductItemLabel(productItems, productItem) {
      var result = null;

      if (productItem) {
        var foundProductItem = productItems.find(function (item) {
          return item.inventory_item_id == productItem;
        });
        result = foundProductItem ? foundProductItem.item_desc : "";
      }

      return result;
    },
    getPrdgrpPlanVersionNo: function getPrdgrpPlanVersionNo(prdgrpPlans, prdgrpYearIdValue) {
      var result = null;

      if (prdgrpYearIdValue) {
        var foundPrdgrp = prdgrpPlans.find(function (item) {
          return item.prdgrp_year_id == prdgrpYearIdValue;
        });
        result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
      }

      return result;
    },
    getAllocateYearId: function getAllocateYearId(ct14VersionNos, periodYearValue, ct14VersionNoValue, costCode) {
      var result = null;

      if (ct14VersionNoValue) {
        var foundVersion = ct14VersionNos.find(function (item) {
          return item.period_year == periodYearValue && item.ct14_version_no == ct14VersionNoValue && item.cost_code == costCode;
        });
        result = foundVersion ? foundVersion.ct14_allocate_year_id : "";
      }

      return result;
    },
    getAllocateVersionNo: function getAllocateVersionNo(ct14VersionNos, periodYearValue, ct14AllocateYearId, costCode) {
      var result = null;

      if (ct14AllocateYearId) {
        var foundVersion = ct14VersionNos.find(function (item) {
          return item.period_year == periodYearValue && item.ct14_allocate_year_id == ct14AllocateYearId && item.cost_code == costCode;
        });
        result = foundVersion ? foundVersion.ct14_version_no : "";
      }

      return result;
    },
    validateBeforeGetOemCostHeader: function validateBeforeGetOemCostHeader(periodYear, prdgrpYearId, ct14VersionNo, costCode, productGroup, productItem) {
      var valid = false;

      if (periodYear && prdgrpYearId && ct14VersionNo && costCode && productGroup && productItem) {
        valid = true;
      }

      return valid;
    },
    validateBeforeSaveOemCostHeader: function validateBeforeSaveOemCostHeader(periodYear, prdgrpYearId, ct14VersionNo, costCode, productGroup, productItem, productQuantity) {
      var valid = false;

      if (periodYear && prdgrpYearId && ct14VersionNo && costCode && productGroup && productItem && productQuantity) {
        valid = true;
      }

      return valid;
    },
    validateBeforeGetOemCostLines: function validateBeforeGetOemCostLines(periodYear, oemCostHeader) {
      var valid = false;

      if (periodYear && oemCostHeader) {
        valid = true;
      }

      return valid;
    },
    validateBeforeGenerateAccountTargets: function validateBeforeGenerateAccountTargets(periodYear, oemCostHeader) {
      var valid = false;

      if (periodYear && oemCostHeader) {
        valid = true;
      }

      return valid;
    },
    getOemCostHeaderData: function getOemCostHeaderData(periodYear, prdgrpYearId, planVersionNo, ct14VersionNo, costCode, productGroup, productItem, isCreateNew) {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var params, isValid, resGetOemCostYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                // SHOW LOADING
                _this9.isLoading = true; // REFRESH DATA

                _this9.oemCostHeader = null;
                params = {
                  period_year: periodYear,
                  prdgrp_year_id: prdgrpYearId,
                  plan_version_no: planVersionNo,
                  ct14_version_no: ct14VersionNo,
                  cost_code: costCode,
                  product_group: productGroup,
                  product_inventory_item_id: productItem
                };
                _this9.selectedOemCostYearData = {
                  period_year: periodYear,
                  prdgrp_year_id: prdgrpYearId,
                  plan_version_no: planVersionNo,
                  ct14_version_no: ct14VersionNo,
                  cost_code: costCode,
                  product_group: productGroup,
                  product_inventory_item_id: productItem,
                  product_quantity: _this9.productQuantity
                }; // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE

                isValid = _this9.validateBeforeGetOemCostHeader(periodYear, prdgrpYearId, ct14VersionNo, costCode, productGroup, productItem);

                if (!isValid) {
                  _context8.next = 15;
                  break;
                }

                _context8.next = 8;
                return axios.get("/ajax/ct/oem-costs/header", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22-\u0E23\u0E31\u0E1A\u0E08\u0E49\u0E32\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(resData.message), "error");
                  } else {
                    _this9.oemCostHeader = resData.oem_cost_header ? JSON.parse(resData.oem_cost_header) : null;

                    if (_this9.oemCostHeader && !isCreateNew) {
                      _this9.prdgrpYearId = _this9.oemCostHeader.prdgrp_year_id;
                      _this9.ct14AllocateYearId = _this9.oemCostHeader.ct14_allocate_year_id;
                      _this9.costCode = _this9.oemCostHeader.cost_code;
                      _this9.costCodeLabel = _this9.getCostCodeLabel(_this9.costCenters, _this9.costCode);
                      _this9.productGroup = _this9.oemCostHeader.product_group;
                      _this9.productGroupLabel = _this9.getProductGroupLabel(_this9.productGroups, _this9.productGroup);
                      _this9.productItem = _this9.oemCostHeader.product_inventory_item_id;
                      _this9.productQuantity = _this9.oemCostHeader.product_quantity;
                      _this9.planVersionNo = _this9.getPrdgrpPlanVersionNo(_this9.prdgrpPlans, _this9.prdgrpYearId);
                      _this9.ct14VersionNo = _this9.getAllocateVersionNo(_this9.ct14VersionNos, _this9.periodYear, _this9.ct14AllocateYearId, _this9.costCode);
                      _this9.productGroupLabel = _this9.getProductGroupLabel(_this9.productGroups, _this9.productGroup);
                      _this9.productItemLabel = _this9.getProductItemLabel(_this9.productItems, _this9.productItem);
                    }
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22-\u0E23\u0E31\u0E1A\u0E08\u0E49\u0E32\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(error.message), "error");
                  return;
                });

              case 8:
                resGetOemCostYear = _context8.sent;

                if (!(resGetOemCostYear.status != "error")) {
                  _context8.next = 12;
                  break;
                }

                _context8.next = 12;
                return _this9.getOemCostLines(_this9.periodYear, _this9.oemCostHeader);

              case 12:
                _this9.setUrlParams();

                _context8.next = 16;
                break;

              case 15:
                swal("เกิดข้อผิดพลาด", "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19", "error");

              case 16:
                // HIDE LOADING
                _this9.isLoading = false;

              case 17:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    onTransferOemCostData: function onTransferOemCostData(oemCostHeader, oemCostLines) {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                // SHOW LOADING
                _this10.isLoading = true;
                reqBody = {
                  period_year: _this10.periodYear,
                  input_oem_cost_header: JSON.stringify(oemCostHeader),
                  input_oem_cost_lines: JSON.stringify(oemCostLines)
                };
                _context9.next = 4;
                return axios.post("/ajax/ct/oem-costs/transfer", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E42\u0E2D\u0E19\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  } else {
                    _this10.oemCostLines = resData.oem_cost_lines ? JSON.parse(resData.oem_cost_lines) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E42\u0E2D\u0E19\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                  return;
                });

              case 4:
                // HIDE LOADING
                _this10.isLoading = false;

              case 5:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    onCancelTransferOemCostData: function onCancelTransferOemCostData(oemCostHeader, oemCostLines) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                // SHOW LOADING
                _this11.isLoading = true;
                reqBody = {
                  period_year: _this11.periodYear,
                  input_oem_cost_header: JSON.stringify(oemCostHeader),
                  input_oem_cost_lines: JSON.stringify(oemCostLines)
                };
                _context10.next = 4;
                return axios.post("/ajax/ct/oem-costs/cancel-transfer", reqBody).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01\u0E42\u0E2D\u0E19\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resData.message), "error");
                  } else {
                    _this11.oemCostLines = resData.oem_cost_lines ? JSON.parse(resData.oem_cost_lines) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01\u0E42\u0E2D\u0E19\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                  return;
                });

              case 4:
                // HIDE LOADING
                _this11.isLoading = false;

              case 5:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    getListPrdgrps: function getListPrdgrps(periodYear) {
      if (periodYear) {
        this.filteredPrdgrpPlans = this.prdgrpPlans.filter(function (item) {
          return item.period_year == periodYear;
        });
      } else {
        this.filteredPrdgrpPlans = [];
      }
    },
    getListCostCenters: function getListCostCenters(periodYear, prdgrpYearId) {
      if (periodYear && prdgrpYearId) {
        this.filteredCostCenters = this.costCenters.filter(function (item) {
          return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId;
        });
      } else {
        this.filteredCostCenters = [];
      }
    },
    getListVersionNos: function getListVersionNos(periodYear, prdgrpYearId, costCode) {
      if (periodYear && costCode) {
        this.filteredCt14VersionNos = this.ct14VersionNos.filter(function (item) {
          return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId && item.cost_code == costCode;
        });
      } else {
        this.filteredCt14VersionNos = [];
      }
    },
    getOemCostLines: function getOemCostLines(periodYear, oemCostHeader) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var resultData, params, isValid;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                resultData = null; // SHOW LOADING

                _this12.isLoading = true; // REFRESH DATA

                _this12.oemCostLines = [];
                params = {
                  period_year: periodYear,
                  input_oem_cost_header: JSON.stringify(oemCostHeader)
                };
                isValid = _this12.validateBeforeGetOemCostLines(periodYear, oemCostHeader);

                if (!isValid) {
                  _context11.next = 9;
                  break;
                }

                _context11.next = 8;
                return axios.get("/ajax/ct/oem-costs/lines", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22-\u0E23\u0E31\u0E1A\u0E08\u0E49\u0E32\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(resData.message), "error");
                  } else {
                    _this12.oemCostLines = resData.oem_cost_lines ? JSON.parse(resData.oem_cost_lines) : [];
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22-\u0E23\u0E31\u0E1A\u0E08\u0E49\u0E32\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(error.message), "error");
                  return;
                });

              case 8:
                resultData = _context11.sent;

              case 9:
                // HIDE LOADING
                _this12.isLoading = false;
                return _context11.abrupt("return", resultData);

              case 11:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
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
    onOemCostLinesChanged: function onOemCostLinesChanged(data) {
      this.oemCostLines = data.oemCostLines;
    },
    onSearchOemCostHeader: function onSearchOemCostHeader(data) {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                _this13.oemCostHeader = data.oem_cost_header;
                _this13.periodYear = _this13.oemCostHeader.period_year;
                _this13.periodYearLabel = _this13.getPeriodYearLabel(_this13.periodYears, _this13.periodYear);
                _this13.prdgrpYearId = _this13.oemCostHeader.prdgrp_year_id;
                _this13.costCode = _this13.oemCostHeader.cost_code;
                _this13.costCodeLabel = _this13.getCostCodeLabel(_this13.costCenters, _this13.costCode); // this.onCostCodeChanged(this.oemCostHeader.cost_code);

                _this13.ct14AllocateYearId = _this13.oemCostHeader.ct14_allocate_year_id;
                _this13.ct14VersionNo = _this13.getAllocateVersionNo(_this13.ct14VersionNos, _this13.periodYear, _this13.ct14AllocateYearId, _this13.costCode);
                _this13.productGroup = _this13.oemCostHeader.product_group;
                _this13.productGroupLabel = _this13.getProductGroupLabel(_this13.productGroups, _this13.productGroup); // this.onProductGroupChanged(this.oemCostHeader.product_group);

                _this13.productItem = _this13.oemCostHeader.product_inventory_item_id;
                _this13.productQuantity = _this13.oemCostHeader.product_quantity;
                _this13.planVersionNo = _this13.getPrdgrpPlanVersionNo(_this13.prdgrpPlans, _this13.prdgrpYearId);
                _this13.productGroupLabel = _this13.getProductGroupLabel(_this13.productGroups, _this13.productGroup);
                _this13.productItemLabel = _this13.getProductItemLabel(_this13.productItems, _this13.productItem);

                if (_this13.periodYear) {
                  _this13.getListPrdgrps(_this13.periodYear);

                  _this13.getListCostCenters(_this13.periodYear, _this13.prdgrpYearId);

                  _this13.getListVersionNos(_this13.periodYear, _this13.prdgrpYearId, _this13.costCode);

                  _this13.filteredProductGroups = _this13.productGroups.filter(function (item) {
                    return item.period_year == _this13.periodYearValue && item.cost_code == _this13.costCode && item.prdgrp_year_id == _this13.prdgrpYearId;
                  });
                  _this13.filteredProductItems = _this13.productItems.filter(function (item) {
                    return item.period_year == _this13.periodYearValue && item.cost_code == _this13.costCode && item.prdgrp_year_id == _this13.prdgrpYearId && item.product_group == _this13.productGroup;
                  });
                }

                _context12.next = 18;
                return _this13.getOemCostHeaderData(_this13.periodYear, _this13.prdgrpYearId, _this13.planVersionNo, _this13.ct14VersionNo, _this13.costCode, _this13.productGroup, _this13.productItem, false);

              case 18:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    onSaveOemCostHeader: function onSaveOemCostHeader() {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var reqBody, isValid;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                reqBody = {
                  period_year: _this14.periodYear,
                  prdgrp_year_id: _this14.prdgrpYearId,
                  plan_version_no: _this14.planVersionNo,
                  ct14_version_no: _this14.ct14VersionNo,
                  cost_code: _this14.costCode,
                  product_group: _this14.productGroup,
                  product_inventory_item_id: _this14.productItem,
                  product_quantity: _this14.productQuantity
                };
                isValid = _this14.validateBeforeSaveOemCostHeader(_this14.periodYear, _this14.prdgrpYearId, _this14.ct14VersionNo, _this14.costCode, _this14.productGroup, _this14.productItem, _this14.productQuantity);

                if (!isValid) {
                  _context13.next = 8;
                  break;
                }

                // SHOW LOADING
                _this14.isLoading = true; // call store oem-cost header

                _context13.next = 6;
                return axios.post("/ajax/ct/oem-costs/header", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    _this14.oemCostHeader = resData.oem_cost_header ? JSON.parse(resData.oem_cost_header) : null; // this.existPeriodYearOptions = resData.exist_period_years ? JSON.parse(resData.exist_period_years) : [];
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22-\u0E23\u0E31\u0E1A\u0E08\u0E49\u0E32\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19\u0E04\u0E48\u0E32\u0E41\u0E23\u0E07\u0E41\u0E25\u0E30\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22-\u0E23\u0E31\u0E1A\u0E08\u0E49\u0E32\u0E07\u0E1C\u0E25\u0E34\u0E15 | ".concat(error.message), "error");
                });

              case 6:
                _context13.next = 8;
                break;

              case 8:
                // HIDE LOADING
                _this14.isLoading = false;

              case 9:
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
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
  props: ["modalName", "modalWidth", "modalHeight", "organizationCode", "periodYearValue", "periodYears", "prdgrpPlans", "ct14VersionNos", "costCenters", "productGroups", "productItems"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default())
  },
  watch: {
    periodYears: function periodYears(value) {
      this.periodYearOptions = value;
    },
    periodYearValue: function periodYearValue(value) {
      this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, value);

      if (this.periodYearLabel) {
        this.periodYear = value;
        this.getListPrdgrps(this.periodYear);
        this.getListCostCenters(this.periodYear, this.prdgrpYearId);
        this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode);
      }
    }
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      periodYear: this.periodYearValue,
      periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
      periodYearOptions: this.periodYears,
      filteredPrdgrpPlans: [],
      prdgrpYearId: this.prdgrpYearIdValue,
      planVersionNo: null,
      filteredCostCenters: [],
      costCode: null,
      filteredCt14VersionNos: [],
      ct14VersionNo: null,
      oemCostHeaders: [],
      selectedOemCostHeader: null
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
      this.getListPrdgrps(this.periodYear);
      this.getListCostCenters(this.periodYear, this.prdgrpYearId);
      this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode);
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
                _this.prdgrpYearId = null;
                _this.costCode = null;
                _this.ct14VersionNo = null;

                _this.getListPrdgrps(_this.periodYear);

                _this.getListCostCenters(_this.periodYear, _this.prdgrpYearId);

                _this.getListCt14VersionNos(_this.periodYear, _this.prdgrpYearId, _this.costCode);

              case 10:
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
                _this2.planVersionNo = _this2.getPrdgrpPlanVersionNo(_this2.prdgrpPlans, _this2.prdgrpYearId);
                _this2.costCode = null;
                _this2.ct14VersionNo = null;

                _this2.getListCostCenters(_this2.periodYear, _this2.prdgrpYearId);

                _this2.getListCt14VersionNos(_this2.periodYear, _this2.prdgrpYearId, _this2.costCode);

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onCostCodeChanged: function onCostCodeChanged(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.costCode = value;
                _this3.ct14VersionNo = null;

                _this3.getListCt14VersionNos(_this3.periodYear, _this3.prdgrpYearId, _this3.costCode);

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onCt14VersionNoChanged: function onCt14VersionNoChanged(value) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.ct14VersionNo = value;

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
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
    getCostCodeLabel: function getCostCodeLabel(costCenters, costCode) {
      var result = null;

      if (costCode) {
        var foundCostCenter = costCenters.find(function (item) {
          return item.cost_code == costCode;
        });
        result = foundCostCenter ? foundCostCenter.cost_code_label : "";
      }

      return result;
    },
    getProductGroupLabel: function getProductGroupLabel(productGroups, productGroup) {
      var result = null;

      if (productGroup) {
        var foundProductGroup = productGroups.find(function (item) {
          return item.product_group == productGroup;
        });
        result = foundProductGroup ? foundProductGroup.product_group_label : "";
      }

      return result;
    },
    getProductItemLabel: function getProductItemLabel(productItems, productItem) {
      var result = null;

      if (productItem) {
        var foundProductItem = productItems.find(function (item) {
          return item.inventory_item_id == productItem;
        });
        result = foundProductItem ? foundProductItem.item_desc : "";
      }

      return result;
    },
    getPrdgrpPlanVersionNo: function getPrdgrpPlanVersionNo(prdgrpPlans, prdgrpYearId) {
      var result = null;

      if (prdgrpYearId) {
        var foundPrdgrp = prdgrpPlans.find(function (item) {
          return item.prdgrp_year_id == prdgrpYearId;
        });
        result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
      }

      return result;
    },
    getListOemCostHeaders: function getListOemCostHeaders() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var params, foundPeriodYear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // show loading
                _this5.isLoading = true; // REFRESH DATA

                _this5.oemCostHeaders = [];
                _this5.selectedOemCostHeader = null;
                params = {
                  period_year: _this5.periodYear,
                  plan_version_no: _this5.planVersionNo,
                  prdgrp_year_id: _this5.prdgrpYearId,
                  cost_code: _this5.costCode,
                  ct14_version_no: _this5.ct14VersionNo
                };
                foundPeriodYear = null;

                if (_this5.periodYearOptions && _this5.periodYear) {
                  if (_this5.periodYearOptions.length > 0) {
                    foundPeriodYear = _this5.periodYearOptions.find(function (item) {
                      return item.period_year_value == _this5.periodYear;
                    });
                  }
                } // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE


                if (!foundPeriodYear) {
                  _context5.next = 11;
                  break;
                }

                _context5.next = 9;
                return axios.get("/ajax/ct/oem-costs/list-headers", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E02\u0E2D\u0E07\u0E1B\u0E35\u0E1B\u0E31\u0E0D\u0E0A\u0E35 \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(resData.message), "error");
                  } else {
                    _this5.oemCostHeaders = resData.oem_cost_headers ? JSON.parse(resData.oem_cost_headers) : null;
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E14\u0E36\u0E07\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E1B\u0E31\u0E19\u0E2A\u0E48\u0E27\u0E19\u0E02\u0E2D\u0E07\u0E1B\u0E35\u0E1B\u0E31\u0E0D\u0E0A\u0E35 \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 | ".concat(error.message), "error");
                  return;
                });

              case 9:
                _context5.next = 12;
                break;

              case 11:
                swal("เกิดข้อผิดพลาด", "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19", "error");

              case 12:
                // hide loading
                _this5.isLoading = false;

              case 13:
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
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                if (periodYear) {
                  _this6.filteredPrdgrpPlans = _this6.prdgrpPlans.filter(function (item) {
                    return item.period_year == periodYear;
                  });
                } else {
                  _this6.filteredPrdgrpPlans = [];
                }

              case 1:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getListCostCenters: function getListCostCenters(periodYear, prdgrpYearId) {
      if (periodYear && prdgrpYearId) {
        this.filteredCostCenters = this.costCenters.filter(function (item) {
          return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId;
        });
      } else {
        this.filteredCostCenters = [];
      }
    },
    getListCt14VersionNos: function getListCt14VersionNos(periodYear, prdgrpYearId, costCode) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                if (periodYear && prdgrpYearId) {
                  if (costCode) {
                    _this7.filteredCt14VersionNos = _this7.ct14VersionNos.filter(function (item) {
                      return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId && item.cost_code == costCode && !!item.ct14_version_no;
                    }).filter(function (value, index, self) {
                      return index === self.findIndex(function (t) {
                        return t.ct14_version_no === value.ct14_version_no;
                      });
                    });
                  } else {
                    _this7.filteredCt14VersionNos = _this7.ct14VersionNos.filter(function (item) {
                      return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId && !!item.ct14_version_no;
                    }).filter(function (value, index, self) {
                      return index === self.findIndex(function (t) {
                        return t.ct14_version_no === value.ct14_version_no;
                      });
                    });
                  }
                } else {
                  _this7.filteredCt14VersionNos = [];
                }

              case 1:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onSelectOemCostHeaderVersion: function onSelectOemCostHeaderVersion(oemCostHeader) {
      this.selectedOemCostHeader = oemCostHeader;
      this.onSearchOemCostHeader();
    },
    onSearchOemCostHeader: function onSearchOemCostHeader() {
      this.$modal.hide(this.modalName);
      this.$emit("onSearchOemCostHeader", {
        oem_cost_header: this.selectedOemCostHeader
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["periodYearValue", "oemCostHeader", "oemCostLines", "accountCodes", "subAccountCodes", "accountTypes"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  watch: {
    periodYearValue: function periodYearValue(value) {
      this.periodYear = value;
    },
    oemCostHeader: function oemCostHeader(data) {
      this.oemCostHeaderData = data;
    },
    oemCostLines: function oemCostLines(data) {
      this.oemCostLineItems = data.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          sub_account_disp: item.sub_account_code ? "".concat(item.account_code).concat(item.sub_account_code) : "",
          expense_amount: !isNaN(item.expense_amount) ? item.expense_amount : 0
        });
      });
      this.calTotalSummaryAmount();
    }
  },
  data: function data() {
    return {
      periodYear: this.periodYearValue,
      oemCostHeaderData: this.oemCostHeader,
      oemCostLineItems: this.oemCostLines.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          sub_account_disp: item.sub_account_code ? "".concat(item.account_code).concat(item.sub_account_code) : "",
          expense_amount: !isNaN(item.expense_amount) ? item.expense_amount : 0
        });
      }),
      totalEstimateExpenseAmount: 0,
      isLoading: false
    };
  },
  mounted: function mounted() {// this.emitOemCostLinesChanged();
  },
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
    isAllowAddNewLine: function isAllowAddNewLine() {
      var allowed = false;

      if (this.oemCostHeaderData) {
        if (this.oemCostLineItems.length > 0) {
          var firstLine = this.oemCostLineItems[0];

          if (!firstLine.transfer_data || firstLine.transfer_data == "N") {
            allowed = true;
          }
        } else {
          allowed = true;
        }
      }

      return allowed;
    },
    isAllowUpdate: function isAllowUpdate() {
      var allowed = false;

      if (this.oemCostHeaderData) {
        if (this.oemCostLineItems.length > 0) {
          var firstLine = this.oemCostLineItems[0];

          if (!firstLine.transfer_data || firstLine.transfer_data == "N") {
            allowed = true;
          }
        }
      }

      return allowed;
    },
    validateBeforeSaveLine: function validateBeforeSaveLine(oemCostLineItem) {
      var result = {
        valid: true,
        message: ""
      };

      if (oemCostLineItem.expense_amount === undefined || oemCostLineItem.expense_amount == null) {
        result.valid = false;
        result.message = "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E04\u0E48\u0E32\u0E43\u0E0A\u0E49\u0E08\u0E48\u0E32\u0E22\u0E1B\u0E23\u0E30\u0E21\u0E32\u0E13\u0E01\u0E32\u0E23\" \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A";
      }

      return result;
    },
    calTotalSummaryAmount: function calTotalSummaryAmount() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.totalEstimateExpenseAmount = _this.oemCostLineItems.reduce(function (pv, cv) {
                  return pv + (cv.expense_amount ? parseFloat(cv.expense_amount) : 0);
                }, 0);

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onAddNewOemCostLine: function onAddNewOemCostLine() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var oemCostLineItem, resResult;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                oemCostLineItem = {
                  oem_cost_header_id: _this2.oemCostHeaderData.oem_cost_header_id,
                  oem_cost_line_id: null,
                  account_code: null,
                  account_desc: null,
                  sub_account_code: null,
                  sub_account_disp: null,
                  sub_account_desc: null,
                  account_type: null,
                  account_type_desc: null,
                  expense_amount: 0
                };
                _this2.oemCostLineItems = [].concat(_toConsumableArray(_this2.oemCostLineItems), [oemCostLineItem]);
                _context2.next = 4;
                return _this2.saveOemCostLine(oemCostLineItem);

              case 4:
                resResult = _context2.sent;
                oemCostLineItem.oem_cost_line_id = resResult ? resResult.oem_cost_line_id : null;

                _this2.calTotalSummaryAmount();

                _this2.emitOemCostLinesChanged();

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onSubAccountCodeChanged: function onSubAccountCodeChanged(value, oemCostLineItem) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var foundSubAccountCode, foundAccountCode, foundAccountType, resResult;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                oemCostLineItem.sub_account_disp = value;
                foundSubAccountCode = _this3.subAccountCodes.find(function (item) {
                  return item.sub_account_disp == value;
                });

                if (foundSubAccountCode) {
                  oemCostLineItem.account_code = foundSubAccountCode.account_code;
                  foundAccountCode = _this3.accountCodes.find(function (acItem) {
                    return acItem.account_code == foundSubAccountCode.account_code;
                  });
                  oemCostLineItem.account_desc = foundAccountCode ? foundAccountCode.account_desc : "";
                  oemCostLineItem.sub_account_code = foundSubAccountCode.sub_account_code;
                  oemCostLineItem.sub_account_desc = foundSubAccountCode.sub_account_desc;
                  oemCostLineItem.account_type = foundSubAccountCode.account_type;
                  foundAccountType = _this3.accountTypes.find(function (atItem) {
                    return atItem.account_type == foundSubAccountCode.account_type;
                  });
                  oemCostLineItem.account_type_desc = foundAccountType ? foundAccountType.account_type_desc : "";
                }

                _context3.next = 5;
                return _this3.saveOemCostLine(oemCostLineItem);

              case 5:
                resResult = _context3.sent;
                oemCostLineItem.oem_cost_line_id = resResult ? resResult.oem_cost_line_id : null;

                _this3.calTotalSummaryAmount();

                _this3.emitOemCostLinesChanged();

              case 9:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    onOemCostLineExpenseAmountChanged: function onOemCostLineExpenseAmountChanged(oemCostLineItem) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (!isNaN(oemCostLineItem.expense_amount)) {
                  _this4.$nextTick( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
                    var resResult;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
                      while (1) {
                        switch (_context4.prev = _context4.next) {
                          case 0:
                            _context4.next = 2;
                            return _this4.saveOemCostLine(oemCostLineItem);

                          case 2:
                            resResult = _context4.sent;
                            oemCostLineItem.oem_cost_line_id = resResult ? resResult.oem_cost_line_id : null;

                            _this4.calTotalSummaryAmount();

                            _this4.emitOemCostLinesChanged();

                          case 6:
                          case "end":
                            return _context4.stop();
                        }
                      }
                    }, _callee4);
                  })));
                } else {
                  _this4.$nextTick(function () {
                    oemCostLineItem.expense_amount = 0;

                    _this4.calTotalSummaryAmount();

                    _this4.emitOemCostLinesChanged();
                  });
                }

              case 1:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    onDeleteLine: function onDeleteLine(oemCostLineItem) {
      var _this5 = this;

      swal({
        title: "",
        text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 ".concat(oemCostLineItem.sub_account_disp ? oemCostLineItem.sub_account_disp : "", " ").concat(oemCostLineItem.sub_account_desc ? oemCostLineItem.sub_account_desc : "", "  ?"),
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "ลบ",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: true
      }, /*#__PURE__*/function () {
        var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6(isConfirm) {
          var foundIndex;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
            while (1) {
              switch (_context6.prev = _context6.next) {
                case 0:
                  if (!isConfirm) {
                    _context6.next = 5;
                    break;
                  }

                  _context6.next = 3;
                  return _this5.deleteOemCostLine(oemCostLineItem);

                case 3:
                  foundIndex = _this5.oemCostLineItems.findIndex(function (item) {
                    return item == oemCostLineItem;
                  });

                  _this5.oemCostLineItems.splice(foundIndex, 1);

                case 5:
                case "end":
                  return _context6.stop();
              }
            }
          }, _callee6);
        }));

        return function (_x) {
          return _ref2.apply(this, arguments);
        };
      }());
    },
    saveOemCostLine: function saveOemCostLine(oemCostLineItem) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var reqBody, result;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                reqBody = {
                  period_year: _this6.periodYear,
                  input_oem_cost_header: JSON.stringify(_this6.oemCostHeader),
                  input_oem_cost_line: JSON.stringify(oemCostLineItem)
                }; // SHOW LOADING

                _this6.isLoading = true;
                _context7.next = 4;
                return axios.post("/ajax/ct/oem-costs/line", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resOemCostLine = null;

                  if (resData.status == "success") {
                    resOemCostLine = resData.oem_cost_line ? JSON.parse(resData.oem_cost_line) : null;
                  }

                  if (resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(resMsg), "error");
                  }

                  return resOemCostLine;
                })["catch"](function (error) {
                  console.log(error);
                  swal("เกิดข้อผิดพลาด", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 | ".concat(error.message), "error");
                });

              case 4:
                result = _context7.sent;
                // HIDE LOADING
                _this6.isLoading = false;
                return _context7.abrupt("return", result);

              case 7:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    deleteOemCostLine: function deleteOemCostLine(oemCostLineItem) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                reqBody = {
                  period_year: _this7.periodYear,
                  input_oem_cost_header: JSON.stringify(_this7.oemCostHeader),
                  input_oem_cost_line: JSON.stringify(oemCostLineItem)
                }; // SHOW LOADING

                _this7.isLoading = true;
                _context8.next = 4;
                return axios.post("/ajax/ct/oem-costs/delete-line", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {}

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
                _this7.isLoading = false;

              case 5:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    emitOemCostLinesChanged: function emitOemCostLinesChanged() {
      this.$emit("onOemCostLinesChanged", {
        oemCostLines: this.oemCostLineItems
      });
    } // formatNumber(value) {
    //     let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //     return result;
    // },
    // isNumber: function(evt) {
    //     evt = (evt) ? evt : window.event;
    //     var charCode = (evt.which) ? evt.which : evt.keyCode;
    //     if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
    //         evt.preventDefault();;
    //     } else {
    //         return true;
    //     }
    // }

  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-41a964f1] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n.vm--overlay[data-modal=\"modal-search-allocate-year\"][data-v-41a964f1] {\n  height: 100% !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_style_index_0_id_41a964f1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_style_index_0_id_41a964f1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_style_index_0_id_41a964f1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/Index.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/Index.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_a243bcc0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=a243bcc0& */ "./resources/js/components/ct/oem-costs/Index.vue?vue&type=template&id=a243bcc0&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/oem-costs/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_a243bcc0___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_a243bcc0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/oem-costs/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearchOemCost_vue_vue_type_template_id_41a964f1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true& */ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true&");
/* harmony import */ var _ModalSearchOemCost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearchOemCost.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSearchOemCost_vue_vue_type_style_index_0_id_41a964f1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css& */ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSearchOemCost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearchOemCost_vue_vue_type_template_id_41a964f1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearchOemCost_vue_vue_type_template_id_41a964f1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "41a964f1",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/oem-costs/ModalSearchOemCost.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/TableOemCostLines.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/TableOemCostLines.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableOemCostLines_vue_vue_type_template_id_2e4f7ad7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableOemCostLines.vue?vue&type=template&id=2e4f7ad7& */ "./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=template&id=2e4f7ad7&");
/* harmony import */ var _TableOemCostLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableOemCostLines.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableOemCostLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableOemCostLines_vue_vue_type_template_id_2e4f7ad7___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableOemCostLines_vue_vue_type_template_id_2e4f7ad7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/oem-costs/TableOemCostLines.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/Index.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/Index.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchOemCost.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableOemCostLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableOemCostLines.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableOemCostLines_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css&":
/*!******************************************************************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css& ***!
  \******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_style_index_0_id_41a964f1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=style&index=0&id=41a964f1&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ct/oem-costs/Index.vue?vue&type=template&id=a243bcc0&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/Index.vue?vue&type=template&id=a243bcc0& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_a243bcc0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_a243bcc0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_a243bcc0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=a243bcc0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/Index.vue?vue&type=template&id=a243bcc0&");


/***/ }),

/***/ "./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_template_id_41a964f1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_template_id_41a964f1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearchOemCost_vue_vue_type_template_id_41a964f1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=template&id=2e4f7ad7&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=template&id=2e4f7ad7& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableOemCostLines_vue_vue_type_template_id_2e4f7ad7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableOemCostLines_vue_vue_type_template_id_2e4f7ad7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableOemCostLines_vue_vue_type_template_id_2e4f7ad7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableOemCostLines.vue?vue&type=template&id=2e4f7ad7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=template&id=2e4f7ad7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/Index.vue?vue&type=template&id=a243bcc0&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/Index.vue?vue&type=template&id=a243bcc0& ***!
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
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-7" }, [
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
                        "select-options": _vm.filteredPrdgrpPlans,
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
            _c("div", { staticClass: "col-md-5" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                  },
                  [_vm._v(" ศูนย์ต้นทุน  ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-8" },
                  [
                    _c("pm-el-select", {
                      attrs: {
                        name: "cost_code",
                        id: "input_cost_code",
                        "select-options": _vm.filteredCostCenters,
                        "option-key": "cost_code_value",
                        "option-value": "cost_code_value",
                        "option-label": "cost_code_label",
                        value: _vm.costCode,
                        filterable: true
                      },
                      on: { onSelected: _vm.onCostCodeChanged }
                    })
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-7" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                  },
                  [_vm._v(" ครั้งที่ ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-8" },
                  [
                    _c("pm-el-select", {
                      attrs: {
                        name: "ct14_version_no",
                        id: "input_ct14_version_no",
                        "select-options": _vm.filteredCt14VersionNos,
                        "option-key": "ct14_version_no",
                        "option-value": "ct14_version_no",
                        "option-label": "ct14_version_no",
                        value: _vm.ct14VersionNo,
                        filterable: true
                      },
                      on: { onSelected: _vm.onCt14VersionNoChanged }
                    })
                  ],
                  1
                )
              ])
            ])
          ]),
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
                  [_vm._v(" กลุ่มผลิตภัณฑ์  ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-8" },
                  [
                    _c("pm-el-select", {
                      attrs: {
                        name: "product_group",
                        id: "input_product_group",
                        "select-options": _vm.filteredProductGroups,
                        "option-key": "product_group_value",
                        "option-value": "product_group_value",
                        "option-label": "product_group_full_label",
                        value: _vm.productGroup,
                        filterable: true
                      },
                      on: { onSelected: _vm.onProductGroupChanged }
                    })
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-7" }, [
              _c("div", { staticClass: "row form-group" }, [
                _c(
                  "label",
                  {
                    staticClass:
                      "col-md-4 col-form-label tw-font-bold tw-pt-0 required"
                  },
                  [_vm._v(" ผลิตภัณฑ์ ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-8" },
                  [
                    _c("pm-el-select", {
                      attrs: {
                        name: "product_inventory_item_id",
                        id: "input_product_inventory_item_id",
                        "select-options": _vm.filteredProductItems,
                        "option-key": "inventory_item_id",
                        "option-value": "inventory_item_id",
                        "option-label": "item_full_desc",
                        value: _vm.productItem,
                        filterable: true
                      },
                      on: { onSelected: _vm.onProductItemChanged }
                    })
                  ],
                  1
                )
              ])
            ])
          ]),
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
                  [_vm._v(" ปริมาณผลิต ")]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-8" },
                  [
                    _c("vue-numeric", {
                      staticClass: "form-control input-sm text-right",
                      staticStyle: { width: "100%" },
                      attrs: {
                        name: "product_quantity",
                        id: "input_product_quantity",
                        minus: false,
                        precision: 2,
                        min: 0,
                        max: 999999999,
                        disabled: !_vm.isAllowUpdate(),
                        autocomplete: "off"
                      },
                      on: {
                        blur: function($event) {
                          return _vm.onProductQuantityChanged($event)
                        }
                      },
                      model: {
                        value: _vm.productQuantity,
                        callback: function($$v) {
                          _vm.productQuantity = $$v
                        },
                        expression: "productQuantity"
                      }
                    })
                  ],
                  1
                )
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row tw-mt-5" }, [
            _c("div", { staticClass: "col-md-12" }, [
              _c("div", { staticClass: "text-right" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-inline-block btn-white tw-w-32",
                    on: {
                      click: function($event) {
                        return _vm.$modal.show("modal-search-oem-cost")
                      }
                    }
                  },
                  [
                    _c("i", { staticClass: "fa fa-search tw-mr-1" }),
                    _vm._v(" ค้นหา \n                    ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-inline-block btn-primary tw-w-52",
                    attrs: { disabled: !_vm.isAllowTransfer() },
                    on: {
                      click: function($event) {
                        return _vm.onTransferOemCostData(
                          _vm.oemCostHeader,
                          _vm.oemCostLines
                        )
                      }
                    }
                  },
                  [
                    _c("i", { staticClass: "fa fa-arrow-down" }),
                    _vm._v(" โอนข้อมูล\n                    ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-inline-block btn-danger tw-w-52",
                    attrs: { disabled: !_vm.isAllowCancelTransfer() },
                    on: {
                      click: function($event) {
                        return _vm.onCancelTransferOemCostData(
                          _vm.oemCostHeader,
                          _vm.oemCostLines
                        )
                      }
                    }
                  },
                  [
                    _c("i", { staticClass: "fa fa-times" }),
                    _vm._v(" ยกเลิกโอนข้อมูล \n                    ")
                  ]
                )
              ])
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
                _c("table-oem-cost-lines", {
                  attrs: {
                    "period-year-value": _vm.periodYear,
                    "oem-cost-header": _vm.oemCostHeader,
                    "oem-cost-lines": _vm.oemCostLines,
                    "account-codes": _vm.accountCodes,
                    "sub-account-codes": _vm.subAccountCodes,
                    "account-types": _vm.accountTypes
                  },
                  on: { onOemCostLinesChanged: _vm.onOemCostLinesChanged }
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
      }),
      _vm._v(" "),
      _c("modal-search-oem-cost", {
        attrs: {
          "modal-name": "modal-search-oem-cost",
          "modal-width": "1024",
          "modal-height": "auto",
          "organization-code": _vm.organizationCode,
          "period-year-value": _vm.periodYear,
          "period-years": _vm.periodYears,
          "prdgrp-plans": _vm.prdgrpPlans,
          "ct14-version-nos": _vm.ct14VersionNos,
          "cost-centers": _vm.costCenters,
          "product-groups": _vm.productGroups,
          "product-items": _vm.productItems
        },
        on: { onSearchOemCostHeader: _vm.onSearchOemCostHeader }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/ModalSearchOemCost.vue?vue&type=template&id=41a964f1&scoped=true& ***!
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
              _c("div", { staticClass: "col-md-8" }, [
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
                          "select-options": _vm.filteredPrdgrpPlans,
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
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row form-group" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-md-4 col-form-label tw-font-bold tw-pt-0"
                    },
                    [_vm._v(" ศูนย์ต้นทุน  ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "cost_code",
                          id: "input_cost_code",
                          "select-options": _vm.filteredCostCenters,
                          "option-key": "cost_code_value",
                          "option-value": "cost_code_value",
                          "option-label": "cost_code_label",
                          value: _vm.costCode,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onCostCodeChanged }
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
                    [_vm._v(" ครั้งที่ ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-8" },
                    [
                      _c("pm-el-select", {
                        attrs: {
                          name: "ct14_version_no",
                          id: "input_ct14_version_no",
                          "select-options": _vm.filteredCt14VersionNos,
                          "option-key": "ct14_version_no",
                          "option-value": "ct14_version_no",
                          "option-label": "ct14_version_no",
                          value: _vm.ct14VersionNo,
                          filterable: true,
                          clearable: true
                        },
                        on: { onSelected: _vm.onCt14VersionNoChanged }
                      })
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-4" }, [
                _c("div", { staticClass: "text-right" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary tw-w-32",
                      attrs: { type: "button", disabled: !_vm.periodYear },
                      on: { click: _vm.getListOemCostHeaders }
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
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" ศูนย์ต้นทุน ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "7%" }
                          },
                          [_vm._v(" ครั้งที่ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" กลุ่มผลิตภัณฑ์ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "20%" }
                          },
                          [_vm._v(" ผลิตภัณฑ์ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell",
                            attrs: { width: "10%" }
                          },
                          [_vm._v(" จำนวนผลิต ")]
                        ),
                        _vm._v(" "),
                        _c("th", { attrs: { width: "10%" } })
                      ])
                    ]),
                    _vm._v(" "),
                    _vm.oemCostHeaders.length > 0
                      ? _c(
                          "tbody",
                          [
                            _vm._l(_vm.oemCostHeaders, function(
                              oemCostHeader,
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
                                            oemCostHeader.period_year_thai
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
                                            oemCostHeader.plan_version_no
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
                                            oemCostHeader.cost_code
                                              ? _vm.getCostCodeLabel(
                                                  _vm.costCenters,
                                                  oemCostHeader.cost_code
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
                                            oemCostHeader.ct14_version_no
                                          ) +
                                          " "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass: "text-left md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(oemCostHeader.product_group) +
                                          " : " +
                                          _vm._s(
                                            oemCostHeader.product_group_desc
                                          ) +
                                          " "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "td",
                                    {
                                      staticClass: "text-left md:tw-table-cell"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            oemCostHeader.product_item_number
                                          ) +
                                          " : " +
                                          _vm._s(
                                            oemCostHeader.product_item_desc
                                          )
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
                                        " " +
                                          _vm._s(
                                            oemCostHeader.product_quantity
                                              ? Number(
                                                  oemCostHeader.product_quantity
                                                ).toLocaleString(undefined, {
                                                  minimumFractionDigits: 9,
                                                  maximumFractionDigits: 9
                                                })
                                              : "0.000000000"
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
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-inline-block btn-primary",
                                          on: {
                                            click: function($event) {
                                              return _vm.onSelectOemCostHeaderVersion(
                                                oemCostHeader
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
                            _c("td", { attrs: { colspan: "8" } }, [
                              _c(
                                "h2",
                                { staticClass: "p-2 text-center text-muted" },
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=template&id=2e4f7ad7&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/oem-costs/TableOemCostLines.vue?vue&type=template&id=2e4f7ad7& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
      _vm.isAllowAddNewLine()
        ? _c("div", { staticClass: "text-right" }, [
            _c(
              "button",
              {
                staticClass:
                  "btn btn-sm btn-inline-block btn-primary tw-w-72 tw-mb-2",
                attrs: { type: "button", disabled: !_vm.oemCostHeader },
                on: { click: _vm.onAddNewOemCostLine }
              },
              [
                _c("i", { staticClass: "fa fa-plus tw-mr-1" }),
                _vm._v(" เพิ่มรายการค่าแรงและค่าใช้จ่าย-รับจ้างผลิต \n        ")
              ]
            )
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
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
              _c("thead", [
                _c("tr", [
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-xs md:tw-table-cell",
                      staticStyle: { "z-index": "2" },
                      attrs: { width: "15%" }
                    },
                    [_vm._v(" รหัสบัญชี ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-xs md:tw-table-cell",
                      staticStyle: { "z-index": "2" },
                      attrs: { width: "35%" }
                    },
                    [_vm._v(" ชื่อบัญชี ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-center tw-text-xs md:tw-table-cell",
                      staticStyle: { "z-index": "2" },
                      attrs: { width: "20%" }
                    },
                    [_vm._v(" ค่าแรง/ค่าใช้จ่าย  ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "th",
                    {
                      staticClass: "text-right tw-text-xs md:tw-table-cell",
                      staticStyle: { "z-index": "2" },
                      attrs: { width: "20%" }
                    },
                    [_vm._v(" ค่าใช้จ่าย (บาท)  ")]
                  ),
                  _vm._v(" "),
                  _vm.isAllowUpdate()
                    ? _c("th", { attrs: { width: "10%" } })
                    : _vm._e()
                ])
              ]),
              _vm._v(" "),
              _vm.oemCostLineItems.length > 0
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.oemCostLineItems, function(
                        oemCostLineItem,
                        index
                      ) {
                        return [
                          _c("tr", { key: "" + index }, [
                            _c(
                              "td",
                              { staticClass: "text-center md:tw-table-cell" },
                              [
                                _vm.isAllowUpdate()
                                  ? [
                                      _c("pm-el-select", {
                                        attrs: {
                                          name: "sub_account_code",
                                          id: "input_sub_account_code",
                                          "select-options": _vm.subAccountCodes,
                                          "option-key": "sub_account_disp",
                                          "option-value": "sub_account_disp",
                                          "option-label": "sub_account_disp",
                                          value:
                                            oemCostLineItem.sub_account_disp,
                                          filterable: true
                                        },
                                        on: {
                                          onSelected: function($event) {
                                            return _vm.onSubAccountCodeChanged(
                                              $event,
                                              oemCostLineItem
                                            )
                                          }
                                        }
                                      })
                                    ]
                                  : [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            oemCostLineItem.sub_account_disp
                                          ) +
                                          "\n                            "
                                      )
                                    ]
                              ],
                              2
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "text-left md:tw-table-cell" },
                              [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(oemCostLineItem.sub_account_desc) +
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
                                    _vm._s(oemCostLineItem.account_desc) +
                                    "\n                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "text-right md:tw-table-cell" },
                              [
                                _vm.isAllowUpdate()
                                  ? [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value:
                                              oemCostLineItem.expense_amount,
                                            expression:
                                              "oemCostLineItem.expense_amount"
                                          }
                                        ],
                                        staticClass:
                                          "form-control input-sm text-right",
                                        attrs: {
                                          type: "number",
                                          name: "expense_amount" + index,
                                          id: "input_expense_amount" + index,
                                          disabled: _vm.isLoading
                                        },
                                        domProps: {
                                          value: oemCostLineItem.expense_amount
                                        },
                                        on: {
                                          blur: function($event) {
                                            return _vm.onOemCostLineExpenseAmountChanged(
                                              oemCostLineItem
                                            )
                                          },
                                          input: function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.$set(
                                              oemCostLineItem,
                                              "expense_amount",
                                              $event.target.value
                                            )
                                          }
                                        }
                                      })
                                    ]
                                  : [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            oemCostLineItem.expense_amount
                                              ? Number(
                                                  oemCostLineItem.expense_amount
                                                ).toLocaleString(undefined, {
                                                  minimumFractionDigits: 9,
                                                  maximumFractionDigits: 9
                                                })
                                              : "0.000000000"
                                          ) +
                                          " \n                            "
                                      )
                                    ]
                              ],
                              2
                            ),
                            _vm._v(" "),
                            _vm.isAllowUpdate()
                              ? _c(
                                  "td",
                                  {
                                    staticClass: "text-center md:tw-table-cell"
                                  },
                                  [
                                    _vm.isAllowUpdate()
                                      ? [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-inline-block btn-danger",
                                              on: {
                                                click: function($event) {
                                                  return _vm.onDeleteLine(
                                                    oemCostLineItem
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-times"
                                              }),
                                              _vm._v(
                                                " ลบ\n                                "
                                              )
                                            ]
                                          )
                                        ]
                                      : _vm._e()
                                  ],
                                  2
                                )
                              : _vm._e()
                          ])
                        ]
                      })
                    ],
                    2
                  )
                : _c("tbody", [_vm._m(0)])
            ]
          )
        ]
      ),
      _vm._v(" "),
      _vm.oemCostLineItems.length > 0
        ? _c("div", [
            _c(
              "table",
              { staticClass: "table table-bordered table-sticky mb-0" },
              [
                _c("thead", [
                  _vm.oemCostLineItems.length > 0
                    ? _c("tr", [
                        _vm._m(1),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-right md:tw-table-cell",
                            staticStyle: { "border-left": "0" },
                            attrs: { width: "20%" }
                          },
                          [
                            _c("b", [
                              _vm._v(
                                " " +
                                  _vm._s(
                                    Number(
                                      _vm.totalEstimateExpenseAmount
                                    ).toLocaleString(undefined, {
                                      minimumFractionDigits: 9,
                                      maximumFractionDigits: 9
                                    })
                                  ) +
                                  "  "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _vm.isAllowUpdate()
                          ? _c("td", {
                              staticClass: "text-left md:tw-table-cell",
                              staticStyle: { "border-right": "0" },
                              attrs: { width: "10%" }
                            })
                          : _vm._e()
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
    return _c("tr", [
      _c("td", { attrs: { colspan: "7" } }, [
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
        staticClass: "text-right md:tw-table-cell",
        staticStyle: { "border-left": "0" },
        attrs: { width: "70%" }
      },
      [_c("b", [_vm._v(" รวม ")])]
    )
  }
]
render._withStripped = true



/***/ })

}]);