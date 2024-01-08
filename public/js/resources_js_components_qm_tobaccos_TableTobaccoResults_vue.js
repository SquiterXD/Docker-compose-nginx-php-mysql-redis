(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_tobaccos_TableTobaccoResults_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight", "sample", "sampleResult", "batchItems"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    sample: function sample(data) {
      this.sampleItem = data ? data : [];
    },
    sampleResult: function sampleResult(data) {
      this.sampleResultItem = data ? data : [];
    },
    batchItems: function batchItems(data) {
      this.inputBatchItems = data ? data : [];
    }
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      height: this.modalHeight,
      isTabMesActive: true,
      sampleItem: this.sample ? this.sample : null,
      sampleResultItem: this.sampleResult ? this.sampleResult : null,
      inputBatchItems: this.batchItems ? this.batchItems : [],
      inputMoistureValue: null
    };
  },
  created: function created() {
    this.handleResize();
  },
  mounted: function mounted() {},
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
    toggleTab: function toggleTab(tab) {
      this.isTabMesActive = tab == "MES" ? true : false;
      this.height = tab == "MES" ? 440 : 240;
    },
    onSelectMesBatchItem: function onSelectMesBatchItem(e, batchItem) {
      this.$modal.hide(this.modalName);
      this.$emit("onSelectMesBatchItem", {
        sample: this.sampleItem,
        sample_result: this.sampleResultItem,
        batch_item: batchItem
      });
    },
    onSubmitInputMoistureValue: function onSubmitInputMoistureValue(e) {
      this.$modal.hide(this.modalName);
      this.$emit("onSubmitInputMoistureValue", {
        sample: this.sampleItem,
        sample_result: this.sampleResultItem,
        moisture_value: this.inputMoistureValue
      });
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _ModalMesFlagSampleResults__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalMesFlagSampleResults */ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue");


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
// Import loading-overlay component





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["authUser", "showType", "approvalData", "approvalRole", "sample", "items", "resultItems"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default()),
    ModalMesFlagSampleResults: _ModalMesFlagSampleResults__WEBPACK_IMPORTED_MODULE_5__.default
  },
  watch: {
    sample: function sample(data) {
      this.sampleData = data;
      this.getMesBatchItems(this.sampleData);
    },
    items: function items(data) {
      this.specifications = data;
    },
    resultItems: function resultItems(data) {
      var _this = this;

      this.sampleResults = data.map(function (tem) {
        return _objectSpread(_objectSpread({}, item), {}, {
          // optimal_value: this.getOptimalValue(this.items, item),
          result_status: _this.calResultStatus(_objectSpread(_objectSpread({}, item), {}, {
            result_value: item.result_value
          })),
          failed_status: _this.calFailedStatus(_objectSpread(_objectSpread({}, item), {}, {
            result_value: item.result_value
          }))
        });
      });
    }
  },
  data: function data() {
    var _this2 = this;

    return {
      sampleData: this.sample,
      specifications: this.items,
      sampleResults: this.resultItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          // optimal_value: this.getOptimalValue(this.items, item),
          result_status: _this2.calResultStatus(_objectSpread(_objectSpread({}, item), {}, {
            result_value: item.result_value
          })),
          failed_status: _this2.calFailedStatus(_objectSpread(_objectSpread({}, item), {}, {
            result_value: item.result_value
          }))
        });
      }),
      mesBatchItems: [],
      selectedMesSampleResult: null,
      is_loading: false
    };
  },
  mounted: function mounted() {
    if (this.sample) {
      this.getMesBatchItems(this.sample);
    }
  },
  methods: {
    // getOptimalValue(specifications, item) {
    //     const foundResultItem = specifications.find(spec => (spec.spec_id == item.spec_id && spec.test_id == item.test_id));
    //     const optimalValue = foundResultItem ? foundResultItem.optimal_value : "";
    //     return optimalValue;
    // },
    getResultValue: function getResultValue(item) {
      var foundResultItem = this.resultItems.find(function (i) {
        return i.test_id == item.test_id;
      });
      var resultValue = foundResultItem ? foundResultItem.result_value : "";
      return resultValue;
    },
    getMesBatchItems: function getMesBatchItems(sampleData) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                params = {
                  sample_no: sampleData.sample_no
                };
                return _context.abrupt("return", axios.get("/qm/ajax/tobaccos/get-mes-batch-items", {
                  params: params
                }).then(function (res) {
                  var resData = res.data.data;
                  _this3.mesBatchItems = resData.batch_items ? JSON.parse(resData.batch_items) : [];
                  return resData.batch_items ? JSON.parse(resData.batch_items) : [];
                }));

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    isAllowEdit: function isAllowEdit(sample, approvalRole) {
      var allowed = false;

      if (approvalRole) {
        var approvalLevelCode = approvalRole.level_code;

        if (approvalLevelCode == "1") {
          // Operator
          if (sample.approval_status_code == "10") {
            // Pending : Operator Approval 
            allowed = true;
          }
        }
      }

      return allowed;
    },
    calResultStatus: function calResultStatus(item) {
      var resultStatus = "";

      if (item.min_value && item.max_value && item.result_value !== "" && item.result_value !== null) {
        if (parseFloat(item.result_value) >= parseFloat(item.min_value) && parseFloat(item.result_value) <= parseFloat(item.max_value)) {
          resultStatus = "PASSED";
        } else {
          resultStatus = "FAILED";
        }

        this.calFailedStatus(item);
      }

      item.result_status = resultStatus;
      return resultStatus;
    },
    calFailedStatus: function calFailedStatus(item) {
      var failedStatus = "";

      if (item.min_value && item.max_value && item.result_value !== "" && item.result_value !== null) {
        if (parseFloat(item.result_value) < parseFloat(item.min_value)) {
          failedStatus = "UNDER";
        }

        if (parseFloat(item.result_value) > parseFloat(item.max_value)) {
          failedStatus = "OVER";
        }
      }

      item.failed_status = failedStatus;
      return failedStatus;
    },
    onShowModalUpdateMesResultValue: function onShowModalUpdateMesResultValue(event, sampleResult) {
      this.selectedMesSampleResult = sampleResult;
      window.scrollTo(0, 150);
      this.$modal.show('modal-mes-flag-sample-results');
    },
    onSelectMesBatchItem: function onSelectMesBatchItem(data) {
      var foundSampleResult = this.sampleResults.find(function (item) {
        return item.test_id == data.sample_result.test_id;
      });

      if (foundSampleResult) {
        foundSampleResult.result_value = data.batch_item.moisture_value;
      }
    },
    onSubmitInputMoistureValue: function onSubmitInputMoistureValue(data) {
      var foundSampleResult = this.sampleResults.find(function (item) {
        return item.test_id == data.sample_result.test_id;
      });

      if (foundSampleResult) {
        foundSampleResult.result_value = data.moisture_value;
      }
    },
    onSubmitSampleResult: function onSubmitSampleResult(event) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var resultQualityLines, reqBody, resValidate, resStoreSampleResultStatus, resSampleDisposition, resSampleDispositionDesc, resSampleOperationStatus, resSampleOperationStatusDesc, resSampleResultStatus, resSampleResultStatusDesc, resSampleSeverityLevelMinor, resSampleSeverityLevelMajor, resSampleSeverityLevelCritical;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                resultQualityLines = _this4.sampleResults.map(function (item) {
                  return {
                    result_id: item.result_id,
                    test_id: item.test_id,
                    test_code: item.test_code,
                    test_desc: item.test_desc,
                    optimal_value: item.optimal_value,
                    min_value: item.min_value,
                    max_value: item.max_value,
                    result_value: item.result_value,
                    remark_no_result: item.remark_no_result ? item.remark_no_result : ""
                  };
                });
                reqBody = {
                  organization_code: _this4.sampleData.organization_code,
                  oracle_sample_id: _this4.sampleData.oracle_sample_id,
                  sample_no: _this4.sampleData.sample_no,
                  sample_desc: _this4.sampleData.sample_desc,
                  inventory_item_id: _this4.sampleData.inventory_item_id,
                  item_number: _this4.sampleData.item_number,
                  item_desc: _this4.sampleData.item_desc,
                  date_drawn: _this4.sampleData.date_drawn,
                  sample_disposition: _this4.sampleData.sample_disposition,
                  sample_disposition_desc: _this4.sampleData.sample_disposition_desc,
                  sample_operation_status: _this4.sampleData.sample_operation_status,
                  sample_result_status: _this4.sampleData.sample_result_status,
                  sample_id: _this4.sampleData.sample_id,
                  department_code: _this4.sampleData.department_code,
                  qm_group: _this4.sampleData.qm_group,
                  organization_id: _this4.sampleData.organization_id,
                  subinventory_code: _this4.sampleData.subinventory_code,
                  locator_id: _this4.sampleData.locator_id,
                  sample_date: _this4.sampleData.sample_date,
                  // batch_id: this.sampleData.batch_id,
                  opt: _this4.sampleData.opt,
                  qc_area: _this4.sampleData.qc_area,
                  machine_set: _this4.sampleData.machine_set,
                  program_code: _this4.sampleData.program_code,
                  result_quality_lines: JSON.stringify(resultQualityLines)
                }; // SHOW LOADING

                _this4.is_loading = true; // VALIDATE BEFORE SUBMIT RESULT

                resValidate = _this4.validateBeforeSave(_this4.sampleData, _this4.sampleResults);

                if (!resValidate.valid) {
                  _context2.next = 20;
                  break;
                }

                // CALL STORE SAMPLE RESULT
                resStoreSampleResultStatus = "success";
                resSampleDisposition = _this4.sampleData.sample_disposition;
                resSampleDispositionDesc = _this4.sampleData.sample_disposition_desc;
                resSampleOperationStatus = _this4.sampleData.sample_operation_status;
                resSampleOperationStatusDesc = _this4.sampleData.sample_operation_status_desc;
                resSampleResultStatus = _this4.sampleData.sample_result_status;
                resSampleResultStatusDesc = _this4.sampleData.sample_result_status_desc;
                resSampleSeverityLevelMinor = _this4.sampleData.severity_level_minor;
                resSampleSeverityLevelMajor = _this4.sampleData.severity_level_major;
                resSampleSeverityLevelCritical = _this4.sampleData.severity_level_critical;
                _context2.next = 17;
                return axios.post("/qm/ajax/tobaccos/result", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  resStoreSampleResultStatus = resData.status;

                  if (resSample) {
                    resSampleDisposition = resSample.sample_disposition;
                    resSampleDispositionDesc = resSample.sample_disposition_desc;
                    resSampleOperationStatus = resSample.sample_operation_status;
                    resSampleOperationStatusDesc = resSample.sample_operation_status_desc;
                    resSampleResultStatus = resSample.sample_result_status;
                    resSampleResultStatusDesc = resSample.sample_result_status_desc;
                    resSampleSeverityLevelMinor = resSample.severity_level_minor;
                    resSampleSeverityLevelMajor = resSample.severity_level_major;
                    resSampleSeverityLevelCritical = resSample.severity_level_critical;
                  }

                  if (resData.status == "success") {
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E04\u0E38\u0E13\u0E20\u0E32\u0E1E \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E14\u0E49\u0E32\u0E19\u0E43\u0E1A\u0E22\u0E32 (\u0E08\u0E38\u0E14\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"".concat(_this4.sampleData.location_full_desc, "\", \u0E27\u0E31\u0E19/\u0E40\u0E27\u0E25\u0E32 : \"").concat(_this4.sampleData.date_drawn_show, " ").concat(_this4.sampleData.time_drawn_formatted, "\", \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"").concat(_this4.sampleData.sample_no, "\" )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E04\u0E38\u0E13\u0E20\u0E32\u0E1E \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E14\u0E49\u0E32\u0E19\u0E43\u0E1A\u0E22\u0E32 (\u0E08\u0E38\u0E14\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"".concat(_this4.sampleData.location_full_desc, "\", \u0E27\u0E31\u0E19/\u0E40\u0E27\u0E25\u0E32 : \"").concat(_this4.sampleData.date_drawn_show, " ").concat(_this4.sampleData.time_drawn_formatted, "\", \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"").concat(_this4.sampleData.sample_no, "\" ) | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E04\u0E38\u0E13\u0E20\u0E32\u0E1E \u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E14\u0E49\u0E32\u0E19\u0E43\u0E1A\u0E22\u0E32 (\u0E08\u0E38\u0E14\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"".concat(_this4.sampleData.location_full_desc, "\", \u0E27\u0E31\u0E19/\u0E40\u0E27\u0E25\u0E32 : \"").concat(_this4.sampleData.date_drawn_show, " ").concat(_this4.sampleData.time_drawn_formatted, "\", \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"").concat(_this4.sampleData.sample_no, "\" ) | ").concat(error.message), "error");
                });

              case 17:
                // emit sample result sumitted
                _this4.$emit("onSampleResultSubmitted", {
                  status: resStoreSampleResultStatus,
                  sample_no: _this4.sampleData.sample_no,
                  sample_disposition: resSampleDisposition,
                  sample_disposition_desc: resSampleDispositionDesc,
                  sample_operation_status: resSampleOperationStatus,
                  sample_operation_status_desc: resSampleOperationStatusDesc,
                  sample_result_status: resSampleResultStatus,
                  sample_result_status_desc: resSampleResultStatusDesc,
                  severity_level_minor: resSampleSeverityLevelMinor,
                  severity_level_major: resSampleSeverityLevelMajor,
                  severity_level_critical: resSampleSeverityLevelCritical
                });

                _context2.next = 21;
                break;

              case 20:
                swal("เกิดข้อผิดพลาด", "".concat(resValidate.message), "error");

              case 21:
                // HIDE LOADING
                _this4.is_loading = false;

              case 22:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    onCancelSampleResult: function onCancelSampleResult(e) {
      // emit sample result sumitted
      this.$emit("onCancelSampleResult", e);
    },
    validateBeforeSave: function validateBeforeSave(sampleData, sampleResults) {
      var result = {
        valid: true,
        message: ""
      }; // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE INCOMPLETED

      var incompletedResultValueLines = sampleResults.filter(function (item) {
        return (item.result_value === "" || item.result_value === null) && !item.remark_no_result && item.read_only != 'Y';
      });

      if (incompletedResultValueLines.length > 0) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\" \u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19";
      } else {
        // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE < MIN_VALUE_NUM OR > MAX_VALUE_NUM
        var invalidMinMaxResultValueLines = sampleResults.filter(function (item) {
          return item.data_type_code == "N" && (parseFloat(item.result_value) < parseFloat(item.test_min_value_num) || parseFloat(item.result_value) > parseFloat(item.test_max_value_num));
        });

        if (invalidMinMaxResultValueLines.length > 0) {
          result.valid = false;
          result.message = "\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : \"".concat(invalidMinMaxResultValueLines[0].test_desc, "\" \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A (\u0E04\u0E48\u0E32\u0E15\u0E48\u0E33\u0E2A\u0E38\u0E14: ").concat(invalidMinMaxResultValueLines[0].test_min_value_num, ", \u0E04\u0E48\u0E32\u0E2A\u0E39\u0E07\u0E2A\u0E38\u0E14: ").concat(invalidMinMaxResultValueLines[0].test_max_value_num, ")");
        }
      }

      return result;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-52e7b679] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_style_index_0_id_52e7b679_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_style_index_0_id_52e7b679_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_style_index_0_id_52e7b679_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalMesFlagSampleResults_vue_vue_type_template_id_52e7b679_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true& */ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true&");
/* harmony import */ var _ModalMesFlagSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalMesFlagSampleResults.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalMesFlagSampleResults_vue_vue_type_style_index_0_id_52e7b679_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css& */ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalMesFlagSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalMesFlagSampleResults_vue_vue_type_template_id_52e7b679_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalMesFlagSampleResults_vue_vue_type_template_id_52e7b679_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "52e7b679",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/tobaccos/TableTobaccoResults.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/TableTobaccoResults.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableTobaccoResults_vue_vue_type_template_id_e8ef0314___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableTobaccoResults.vue?vue&type=template&id=e8ef0314& */ "./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=template&id=e8ef0314&");
/* harmony import */ var _TableTobaccoResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableTobaccoResults.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableTobaccoResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableTobaccoResults_vue_vue_type_template_id_e8ef0314___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableTobaccoResults_vue_vue_type_template_id_e8ef0314___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/tobaccos/TableTobaccoResults.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMesFlagSampleResults.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableTobaccoResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableTobaccoResults.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableTobaccoResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css&":
/*!************************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css& ***!
  \************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_style_index_0_id_52e7b679_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=style&index=0&id=52e7b679&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_template_id_52e7b679_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_template_id_52e7b679_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMesFlagSampleResults_vue_vue_type_template_id_52e7b679_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true&");


/***/ }),

/***/ "./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=template&id=e8ef0314&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=template&id=e8ef0314& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableTobaccoResults_vue_vue_type_template_id_e8ef0314___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableTobaccoResults_vue_vue_type_template_id_e8ef0314___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableTobaccoResults_vue_vue_type_template_id_e8ef0314___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableTobaccoResults.vue?vue&type=template&id=e8ef0314& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=template&id=e8ef0314&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/ModalMesFlagSampleResults.vue?vue&type=template&id=52e7b679&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
    { staticStyle: { "z-index": "100" } },
    [
      _c(
        "modal",
        {
          attrs: {
            name: _vm.modalName,
            width: _vm.width,
            scrollable: true,
            height: _vm.height,
            shiftX: 0.5,
            shiftY: 0.5
          }
        },
        [
          _c("div", { staticClass: "p-2 text-left" }, [
            _c(
              "div",
              { staticClass: "btn-group tw-pb-3", attrs: { role: "group" } },
              [
                _c(
                  "button",
                  {
                    staticClass: "btn",
                    class: _vm.isTabMesActive ? "btn-primary" : "btn-white",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.toggleTab("MES")
                      }
                    }
                  },
                  [
                    _vm._v(
                      " \n                    รายการความชื้นจาก MES\n                "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn",
                    class: _vm.isTabMesActive ? "btn-white" : "btn-primary",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.toggleTab("INPUT")
                      }
                    }
                  },
                  [
                    _vm._v(
                      " \n                    กรอกค่าความชื้นเอง\n                "
                    )
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _vm.isTabMesActive
              ? _c(
                  "div",
                  {
                    staticClass: "table-responsive",
                    staticStyle: { "max-height": "480px" }
                  },
                  [
                    _c(
                      "table",
                      {
                        staticClass: "table table-bordered table-sticky mb-0",
                        staticStyle: { "min-width": "600px" }
                      },
                      [
                        _c("thead", [
                          _c("tr", [
                            _c(
                              "th",
                              {
                                staticClass:
                                  "tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden",
                                staticStyle: { "z-index": "auto" },
                                attrs: { width: "15%" }
                              },
                              [
                                _vm._v(
                                  "\n                                BATCH ID\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass:
                                  "tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden",
                                staticStyle: { "z-index": "auto" },
                                attrs: { width: "15%" }
                              },
                              [
                                _vm._v(
                                  "\n                                หัววัดความชื้น\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass:
                                  "tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden",
                                staticStyle: { "z-index": "auto" },
                                attrs: { width: "15%" }
                              },
                              [
                                _vm._v(
                                  "\n                                เวลา\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass:
                                  "tw-text-gray-600 tw-bg-opacity-40 text-right md:tw-table-cell tw-hidden",
                                staticStyle: { "z-index": "auto" },
                                attrs: { width: "30%" }
                              },
                              [
                                _vm._v(
                                  "\n                                ค่าความชื้น\n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("th", {
                              staticClass:
                                "tw-text-gray-600 tw-bg-opacity-40 text-center",
                              staticStyle: { "z-index": "auto" },
                              attrs: { width: "10%" }
                            })
                          ])
                        ]),
                        _vm._v(" "),
                        _vm.inputBatchItems.length > 0
                          ? _c(
                              "tbody",
                              [
                                _vm._l(_vm.inputBatchItems, function(
                                  batchItem,
                                  index
                                ) {
                                  return [
                                    _c("tr", { key: index }, [
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden"
                                        },
                                        [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(batchItem.batch_id) +
                                              "\n                                "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden"
                                        },
                                        [
                                          _vm._v(
                                            "\n                                    " +
                                              _vm._s(batchItem.moisture_point) +
                                              "\n                                "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden"
                                        },
                                        [
                                          _c("strong", [
                                            _vm._v(
                                              " " +
                                                _vm._s(batchItem.blend_time) +
                                                " "
                                            )
                                          ])
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "tw-text-gray-600 tw-bg-opacity-40 text-right md:tw-table-cell tw-hidden"
                                        },
                                        [
                                          _c("strong", [
                                            _vm._v(
                                              " " +
                                                _vm._s(
                                                  batchItem.moisture_value
                                                ) +
                                                " "
                                            )
                                          ])
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c("td", { staticClass: "text-center" }, [
                                        _c(
                                          "button",
                                          {
                                            staticClass:
                                              "btn btn-xs btn-primary",
                                            attrs: { type: "button" },
                                            on: {
                                              click: function($event) {
                                                return _vm.onSelectMesBatchItem(
                                                  $event,
                                                  batchItem
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _vm._v(
                                              " \n                                        เลือก\n                                    "
                                            )
                                          ]
                                        )
                                      ])
                                    ])
                                  ]
                                })
                              ],
                              2
                            )
                          : _c("tbody", [
                              _c("tr", [
                                _c("td", { attrs: { colspan: "6" } }, [
                                  _c(
                                    "h2",
                                    {
                                      staticClass:
                                        "px-5 tw-py-32 text-center text-muted"
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
              : _c("div", { staticClass: "tw-p-2" }, [
                  _c("div", { staticClass: "form-group tw-mb-2" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.inputMoistureValue,
                          expression: "inputMoistureValue"
                        }
                      ],
                      staticClass: "form-control input-sm text-right",
                      attrs: {
                        id: "input_moisture_value",
                        type: "number",
                        name: "moisture_value",
                        placeholder: "กรอกค่าความชื้น"
                      },
                      domProps: { value: _vm.inputMoistureValue },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.inputMoistureValue = $event.target.value
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "text-right" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.onSubmitInputMoistureValue($event)
                          }
                        }
                      },
                      [
                        _vm._v(
                          " \n                        บันทึก\n                    "
                        )
                      ]
                    )
                  ])
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=template&id=e8ef0314&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/tobaccos/TableTobaccoResults.vue?vue&type=template&id=e8ef0314& ***!
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
    { staticClass: "tw-ml-10 tw-mr-10 tw-py-2" },
    [
      _c("table", { staticClass: "table table-borderless-horizontal mb-0" }, [
        _vm._m(0),
        _vm._v(" "),
        _vm.sampleResults.length > 0
          ? _c(
              "tbody",
              [
                _vm._l(_vm.sampleResults, function(sampleResult, index) {
                  return [
                    _c(
                      "tr",
                      {
                        key: index,
                        class:
                          sampleResult.read_only == "Y"
                            ? "tw-bg-gray-100 tw-bg-opacity-60"
                            : ""
                      },
                      [
                        _c("td", { staticClass: "text-center" }, [
                          _vm._v(
                            "\n                        " +
                              _vm._s(sampleResult.seq) +
                              "\n                    "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", {}, [
                          _vm._v(
                            "\n                        " +
                              _vm._s(sampleResult.test_desc) +
                              "\n                        "
                          ),
                          sampleResult.optional_ind != "Y"
                            ? _c("span", { staticClass: "tw-text-red-600" }, [
                                _vm._v(" * ")
                              ])
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(
                                  sampleResult.min_value
                                    ? parseFloat(sampleResult.min_value)
                                    : ""
                                ) +
                                " -\n                        " +
                                _vm._s(
                                  sampleResult.max_value
                                    ? parseFloat(sampleResult.max_value)
                                    : ""
                                ) +
                                "\n                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell tw-text-green-600 tw-font-bold tw-hidden"
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(
                                  sampleResult.optimal_value
                                    ? parseFloat(sampleResult.optimal_value)
                                    : ""
                                ) +
                                "\n                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center" }, [
                          _vm.showType == "result" &&
                          sampleResult.read_only != "Y" &&
                          _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                            ? _c(
                                "div",
                                [
                                  sampleResult.data_type_code == "N"
                                    ? [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: sampleResult.result_value,
                                              expression:
                                                "sampleResult.result_value"
                                            }
                                          ],
                                          staticClass:
                                            "form-control input-sm text-center",
                                          attrs: {
                                            id: "input_result_value_" + index,
                                            type: "number",
                                            name: "result_value_" + index,
                                            placeholder: ""
                                          },
                                          domProps: {
                                            value: sampleResult.result_value
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.calResultStatus(
                                                sampleResult
                                              )
                                            },
                                            input: function($event) {
                                              if ($event.target.composing) {
                                                return
                                              }
                                              _vm.$set(
                                                sampleResult,
                                                "result_value",
                                                $event.target.value
                                              )
                                            }
                                          }
                                        })
                                      ]
                                    : [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: sampleResult.result_value,
                                              expression:
                                                "sampleResult.result_value"
                                            }
                                          ],
                                          staticClass:
                                            "form-control input-sm text-center",
                                          attrs: {
                                            id: "input_result_value_" + index,
                                            type: "text",
                                            name: "result_value_" + index,
                                            placeholder: ""
                                          },
                                          domProps: {
                                            value: sampleResult.result_value
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.calResultStatus(
                                                sampleResult
                                              )
                                            },
                                            input: function($event) {
                                              if ($event.target.composing) {
                                                return
                                              }
                                              _vm.$set(
                                                sampleResult,
                                                "result_value",
                                                $event.target.value
                                              )
                                            }
                                          }
                                        })
                                      ]
                                ],
                                2
                              )
                            : _c(
                                "div",
                                { staticClass: "tw-px-2" },
                                [
                                  _vm.showType == "result" &&
                                  _vm.isAllowEdit(
                                    _vm.sampleData,
                                    _vm.approvalRole
                                  ) &&
                                  sampleResult.mes_flag == "Y" &&
                                  !_vm.sampleData.batch_id
                                    ? [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: sampleResult.result_value,
                                              expression:
                                                "sampleResult.result_value"
                                            }
                                          ],
                                          staticClass:
                                            "form-control input-sm text-center",
                                          attrs: {
                                            id: "input_result_value_" + index,
                                            type: "number",
                                            name: "result_value_" + index,
                                            placeholder: ""
                                          },
                                          domProps: {
                                            value: sampleResult.result_value
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.calResultStatus(
                                                sampleResult
                                              )
                                            },
                                            input: function($event) {
                                              if ($event.target.composing) {
                                                return
                                              }
                                              _vm.$set(
                                                sampleResult,
                                                "result_value",
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
                                              sampleResult.result_value != null
                                                ? parseFloat(
                                                    sampleResult.result_value
                                                  )
                                                : "-"
                                            ) +
                                            "\n                            "
                                        )
                                      ]
                                ],
                                2
                              )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center" }, [
                          _vm._v(
                            "\n                        " +
                              _vm._s(
                                sampleResult.test_unit
                                  ? "" + sampleResult.test_unit
                                  : ""
                              ) +
                              "\n                    "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center" }, [
                          sampleResult.mes_flag == "Y" &&
                          _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                            ? _c(
                                "button",
                                {
                                  staticClass: "btn btn-xs btn-warning",
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      return _vm.onShowModalUpdateMesResultValue(
                                        $event,
                                        sampleResult
                                      )
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            แก้ไขผล\n                        "
                                  )
                                ]
                              )
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleResult.result_status == "PASSED"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check-circle tw-text-green-500"
                                })
                              : _vm._e(),
                            _vm._v(" "),
                            sampleResult.result_status == "FAILED"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-times tw-text-red-500"
                                })
                              : _vm._e(),
                            _vm._v(" "),
                            !sampleResult.result_status
                              ? _c("span", { staticClass: "fa fa-2x fa-minus" })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center tw-text-xs md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleResult.failed_status == "UNDER"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-arrow-down tw-text-blue-500"
                                })
                              : _vm._e(),
                            _vm._v(" "),
                            sampleResult.failed_status == "OVER"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-arrow-up tw-text-red-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center" }, [
                          _vm.showType == "result" &&
                          sampleResult.read_only != "Y" &&
                          _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                            ? _c("div", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: sampleResult.remark_no_result,
                                      expression:
                                        "sampleResult.remark_no_result"
                                    }
                                  ],
                                  staticClass:
                                    "form-control input-sm text-center",
                                  attrs: {
                                    id: "input_remark_no_result_" + index,
                                    type: "text",
                                    name: "remark_no_result_" + index,
                                    placeholder: ""
                                  },
                                  domProps: {
                                    value: sampleResult.remark_no_result
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        sampleResult,
                                        "remark_no_result",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ])
                            : _c("div", { staticClass: "tw-px-2" }, [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(
                                      sampleResult.remark_no_result
                                        ? sampleResult.remark_no_result
                                        : "-"
                                    ) +
                                    "\n                        "
                                )
                              ])
                        ])
                      ]
                    )
                  ]
                }),
                _vm._v(" "),
                _vm.showType == "result" &&
                _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "7" } }, [
                        _c(
                          "div",
                          {
                            staticClass:
                              "row justify-content-center clearfix tw-my-4"
                          },
                          [
                            _c("div", { staticClass: "col text-center" }, [
                              _c(
                                "button",
                                {
                                  staticClass: "btn btn-md btn-success tw-w-32",
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      return _vm.onSubmitSampleResult($event)
                                    }
                                  }
                                },
                                [
                                  _c("i", { staticClass: "fa fa-save" }),
                                  _vm._v(
                                    " บันทึก\n                            "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "button",
                                {
                                  staticClass:
                                    "btn btn-md btn-danger tw-w-32 tw-ml-4",
                                  attrs: { type: "button" },
                                  on: { click: _vm.onCancelSampleResult }
                                },
                                [
                                  _c("i", { staticClass: "fa fa-times" }),
                                  _vm._v(" ปิด\n                            ")
                                ]
                              )
                            ])
                          ]
                        )
                      ])
                    ])
                  : _vm._e()
              ],
              2
            )
          : _c("tbody", [_vm._m(1)])
      ]),
      _vm._v(" "),
      _c("loading", {
        attrs: { active: _vm.is_loading, "is-full-page": true },
        on: {
          "update:active": function($event) {
            _vm.is_loading = $event
          }
        }
      }),
      _vm._v(" "),
      _c("modal-mes-flag-sample-results", {
        attrs: {
          "modal-name": "modal-mes-flag-sample-results",
          "modal-width": "640",
          "modal-height": "440",
          sample: _vm.sampleData,
          "sample-result": _vm.selectedMesSampleResult,
          "batch-items": _vm.mesBatchItems
        },
        on: {
          onSelectMesBatchItem: _vm.onSelectMesBatchItem,
          onSubmitInputMoistureValue: _vm.onSubmitInputMoistureValue
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
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "7%" }
          },
          [_vm._v("\n                    ลำดับที่\n                ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "25%" }
          },
          [_vm._v("\n                    ชื่อการทดสอบ\n                ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "15%" }
          },
          [_vm._v("\n                    ค่ามาตรฐาน\n                ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "10%" }
          },
          [_vm._v("\n                    ค่าOPTIMAL\n                ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "12%" }
          },
          [_vm._v("\n                    ผลการทดสอบ\n                ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "5%" }
          },
          [_vm._v("\n                    หน่วยนับ\n                ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass:
            "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center",
          staticStyle: { "z-index": "auto" },
          attrs: { width: "6%" }
        }),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "8%" }
          },
          [_vm._v("\n                    อยู่ในเกณฑ์มาตรฐาน\n                ")]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass:
            "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
          staticStyle: { "z-index": "auto" },
          attrs: { width: "5%" }
        }),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass:
              "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
            staticStyle: { "z-index": "auto" },
            attrs: { width: "12%" }
          },
          [
            _vm._v(
              "\n                    หมายเหตุไม่ลงผลการทดสอบ\n                "
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
    return _c("tr", [
      _c("td", { attrs: { colspan: "8" } }, [
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