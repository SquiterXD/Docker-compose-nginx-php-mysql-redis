(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_packet-air-leaks_TablePacketAirLeakResults_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=script&lang=js& ***!
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
// Import loading-overlay component




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["authUser", "showType", "sample", "items", "resultItems", "listBrands", "listLeakPositions", "approvalData", "approvalRole"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    var _this = this;

    return {
      sampleData: this.sample,
      specifications: this.items,
      sampleResults: this.resultItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          // optimal_value: this.getOptimalValue(this.items, item),
          result_status: _this.calResultStatus(_objectSpread(_objectSpread({}, item), {}, {
            result_value: item.result_value
          })),
          failed_status: _this.calFailedStatus(_objectSpread(_objectSpread({}, item), {}, {
            result_value: item.result_value
          })),
          cause_of_defect: item.cause_of_defect ? item.cause_of_defect : ""
        });
      }),
      listRequiredLeakPositions: this.listLeakPositions.filter(function (item) {
        return item.position_leak_value != 'NONE';
      }),
      is_loading: false
    };
  },
  mounted: function mounted() {
    var _this2 = this;

    this.sampleResults.map(function (item) {
      _this2.setDefaultLeakSampleInput(item);

      return item;
    });
  },
  methods: {
    getOptimalValue: function getOptimalValue(specifications, item) {
      var foundResultItem = specifications.find(function (spec) {
        return spec.spec_id == item.spec_id && spec.test_id == item.test_id;
      });
      var optimalValue = foundResultItem ? foundResultItem.optimal_value : "";
      return optimalValue;
    },
    getResultValue: function getResultValue(item) {
      var foundResultItem = this.resultItems.find(function (i) {
        return i.test_id == item.test_id;
      });
      var resultValue = foundResultItem ? foundResultItem.result_value : "";
      return resultValue;
    },
    getBrandLabel: function getBrandLabel(resultValue) {
      var result = "";

      if (resultValue) {
        var foundBrand = this.listBrands.find(function (item) {
          return item.brand_value == resultValue;
        });
        result = foundBrand ? foundBrand.brand_label : "";
      }

      return result;
    },
    getLeakPositionLabel: function getLeakPositionLabel(resultValue) {
      var result = "";

      if (resultValue) {
        var foundLeakPosition = this.listLeakPositions.find(function (item) {
          return item.position_leak_value == resultValue;
        });
        result = foundLeakPosition ? foundLeakPosition.position_leak_label : "";
      }

      return result;
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
    onSampleResultChanged: function onSampleResultChanged(resultValue, sampleResult) {
      sampleResult.result_value = resultValue;
    },
    calResultStatus: function calResultStatus(sampleResult) {
      var resultStatus = "";

      if (sampleResult.min_value && sampleResult.max_value && sampleResult.result_value) {
        if (parseFloat(sampleResult.result_value) >= parseFloat(sampleResult.min_value) && parseFloat(sampleResult.result_value) <= parseFloat(sampleResult.max_value)) {
          resultStatus = "PASSED";
        } else {
          resultStatus = "FAILED";
        }
      }

      this.calFailedStatus(sampleResult);
      sampleResult.result_status = resultStatus;
      this.setPositionLeakSampleResult(sampleResult);
      return resultStatus;
    },
    setPositionLeakSampleResult: function setPositionLeakSampleResult(sampleResult) {
      if (this.sampleResults) {
        var groupNo = sampleResult.group_no;
        var positionLeakSampleResult = this.sampleResults.find(function (item) {
          return item.position_leak_flag == 'Y' && item.group_no == groupNo;
        });

        if (sampleResult.min_value && sampleResult.max_value && sampleResult.result_value) {
          if (parseFloat(sampleResult.result_value) >= parseFloat(sampleResult.min_value) && parseFloat(sampleResult.result_value) <= parseFloat(sampleResult.max_value)) {
            if (positionLeakSampleResult) {
              positionLeakSampleResult.position_leak_required = null;
              positionLeakSampleResult.position_leak_entered = 'Y'; // positionLeakSampleResult.position_leak_none = null;

              if (sampleResult.result_value == 0 || sampleResult.result_value == '0') {
                // positionLeakSampleResult.position_leak_entered = null;
                // positionLeakSampleResult.position_leak_none = 'Y';
                positionLeakSampleResult.result_value = 'NONE';
              } else {
                // positionLeakSampleResult.position_leak_entered = 'Y';
                // positionLeakSampleResult.position_leak_none = null;
                if (!positionLeakSampleResult.result_value) {
                  positionLeakSampleResult.result_value = 'NONE';
                }
              }
            }
          } else {
            if (positionLeakSampleResult) {
              positionLeakSampleResult.position_leak_required = 'Y';
              positionLeakSampleResult.position_leak_entered = null; // positionLeakSampleResult.position_leak_none = null;

              if (!positionLeakSampleResult.result_value || positionLeakSampleResult.result_value == 'NONE') {
                positionLeakSampleResult.result_value = this.listRequiredLeakPositions[0].position_leak_value;
              }
            }
          }
        }
      }
    },
    setDefaultLeakSampleInput: function setDefaultLeakSampleInput(sampleResult) {
      var groupNo = sampleResult.group_no;
      var positionLeakSampleResult = this.sampleResults.find(function (item) {
        return item.position_leak_flag == 'Y' && item.group_no == groupNo;
      });

      if (sampleResult.min_value && sampleResult.max_value && sampleResult.result_value) {
        if (parseFloat(sampleResult.result_value) >= parseFloat(sampleResult.min_value) && parseFloat(sampleResult.result_value) <= parseFloat(sampleResult.max_value)) {
          if (positionLeakSampleResult) {
            positionLeakSampleResult.position_leak_required = null;
            positionLeakSampleResult.position_leak_entered = 'Y'; // positionLeakSampleResult.position_leak_none = null;

            if (sampleResult.result_value == 0 || sampleResult.result_value == '0') {// positionLeakSampleResult.position_leak_entered = null;
              // positionLeakSampleResult.position_leak_none = 'Y';
            } else {// positionLeakSampleResult.position_leak_entered = 'Y';
                // positionLeakSampleResult.position_leak_none = null;
              }
          }
        } else {
          if (positionLeakSampleResult) {
            positionLeakSampleResult.position_leak_required = 'Y';
            positionLeakSampleResult.position_leak_entered = null; // positionLeakSampleResult.position_leak_none = null;
          }
        }
      }
    },
    calFailedStatus: function calFailedStatus(sampleResult) {
      var failedStatus = "";

      if (sampleResult.min_value && sampleResult.max_value && sampleResult.result_value) {
        if (parseFloat(sampleResult.result_value) < parseFloat(sampleResult.min_value)) {
          failedStatus = "UNDER";
        }

        if (parseFloat(sampleResult.result_value) > parseFloat(sampleResult.max_value)) {
          failedStatus = "OVER";
        }
      }

      sampleResult.failed_status = failedStatus;
      return failedStatus;
    },
    onSubmitSampleResult: function onSubmitSampleResult(event) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, resultQualityLines, reqBody, resValidate, resStoreSampleResultStatus, resSampleDisposition, resSampleDispositionDesc, resSampleOperationStatus, resSampleOperationStatusDesc, resSampleResultStatus, resSampleResultStatusDesc, resSampleSeverityLevelMinor, resSampleSeverityLevelMajor, resSampleSeverityLevelCritical, resSampleTestTime;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this3; // const sample = this.sample;

                resultQualityLines = _this3.sampleResults.map(function (item) {
                  return {
                    result_id: item.result_id,
                    test_id: item.test_id,
                    test_code: item.test_code,
                    test_desc: item.test_desc,
                    optimal_value: item.optimal_value,
                    min_value: item.min_value,
                    max_value: item.max_value,
                    result_value: item.result_value
                  };
                });
                reqBody = {
                  organization_code: _this3.sampleData.organization_code,
                  oracle_sample_id: _this3.sampleData.oracle_sample_id,
                  sample_no: _this3.sampleData.sample_no,
                  sample_desc: _this3.sampleData.sample_desc,
                  inventory_item_id: _this3.sampleData.inventory_item_id,
                  item_number: _this3.sampleData.item_number,
                  item_desc: _this3.sampleData.item_desc,
                  date_drawn: _this3.sampleData.date_drawn,
                  sample_disposition: _this3.sampleData.sample_disposition,
                  sample_disposition_desc: _this3.sampleData.sample_disposition_desc,
                  sample_operation_status: _this3.sampleData.sample_operation_status,
                  sample_result_status: _this3.sampleData.sample_result_status,
                  sample_id: _this3.sampleData.sample_id,
                  department_code: _this3.sampleData.department_code,
                  qm_group: _this3.sampleData.qm_group,
                  organization_id: _this3.sampleData.organization_id,
                  subinventory_code: _this3.sampleData.subinventory_code,
                  locator_id: _this3.sampleData.locator_id,
                  sample_date: _this3.sampleData.sample_date,
                  batch_id: _this3.sampleData.batch_id,
                  // opt: this.sampleData.opt,
                  qc_area: _this3.sampleData.qc_area,
                  machine_set: _this3.sampleData.machine_set,
                  program_code: _this3.sampleData.program_code,
                  result_quality_lines: JSON.stringify(resultQualityLines)
                }; // SHOW LOADING

                _this3.is_loading = true; // VALIDATE BEFORE SUBMIT RESULT

                resValidate = _this3.validateBeforeSave(_this3.sampleData, _this3.sampleResults);

                if (!resValidate.valid) {
                  _context.next = 22;
                  break;
                }

                // CALL STORE SAMPLE RESULT
                resStoreSampleResultStatus = "success";
                resSampleDisposition = _this3.sampleData.sample_disposition;
                resSampleDispositionDesc = _this3.sampleData.sample_disposition_desc;
                resSampleOperationStatus = _this3.sampleData.sample_operation_status;
                resSampleOperationStatusDesc = _this3.sampleData.sample_operation_status_desc;
                resSampleResultStatus = _this3.sampleData.sample_result_status;
                resSampleResultStatusDesc = _this3.sampleData.sample_result_status_desc;
                resSampleSeverityLevelMinor = _this3.sampleData.severity_level_minor;
                resSampleSeverityLevelMajor = _this3.sampleData.severity_level_major;
                resSampleSeverityLevelCritical = _this3.sampleData.severity_level_critical;
                resSampleTestTime = _this3.sampleData.test_time;
                _context.next = 19;
                return axios.post("/qm/ajax/packet-air-leaks/result", reqBody).then(function (res) {
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
                    resSampleTestTime = resSample.test_time;
                  }

                  if (resData.status == "success") {
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2D\u0E31\u0E15\u0E23\u0E32\u0E25\u0E21\u0E23\u0E31\u0E48\u0E27\u0E02\u0E2D\u0E07\u0E0B\u0E2D\u0E07\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2D\u0E31\u0E15\u0E23\u0E32\u0E25\u0E21\u0E23\u0E31\u0E48\u0E27\u0E02\u0E2D\u0E07\u0E0B\u0E2D\u0E07\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2D\u0E31\u0E15\u0E23\u0E32\u0E25\u0E21\u0E23\u0E31\u0E48\u0E27\u0E02\u0E2D\u0E07\u0E0B\u0E2D\u0E07\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 19:
                // emit sample result sumitted
                _this3.$emit("onSampleResultSubmitted", {
                  status: resStoreSampleResultStatus,
                  sample_no: _this3.sampleData.sample_no,
                  sample_disposition: resSampleDisposition,
                  sample_disposition_desc: resSampleDispositionDesc,
                  sample_operation_status: resSampleOperationStatus,
                  sample_operation_status_desc: resSampleOperationStatusDesc,
                  sample_result_status: resSampleResultStatus,
                  sample_result_status_desc: resSampleResultStatusDesc,
                  severity_level_minor: resSampleSeverityLevelMinor,
                  severity_level_major: resSampleSeverityLevelMajor,
                  severity_level_critical: resSampleSeverityLevelCritical,
                  test_time: resSampleTestTime
                });

                _context.next = 23;
                break;

              case 22:
                swal("เกิดข้อผิดพลาด", "".concat(resValidate.message), "error");

              case 23:
                // HIDE LOADING
                _this3.is_loading = false;

              case 24:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    onSubmitCauseOfDefect: function onSubmitCauseOfDefect(event) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, resultQualityLines, reqBody, resStoreCauseOfDefectStatus;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this4; // const sample = this.sample;

                resultQualityLines = _this4.sampleResults.map(function (item) {
                  return {
                    result_id: item.result_id,
                    test_id: item.test_id,
                    test_code: item.test_code,
                    test_desc: item.test_desc,
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : ""
                  };
                });
                reqBody = {
                  organization_code: _this4.sampleData.organization_code,
                  oracle_sample_id: _this4.sampleData.oracle_sample_id,
                  sample_no: _this4.sampleData.sample_no,
                  result_quality_lines: JSON.stringify(resultQualityLines)
                }; // SHOW LOADING

                _this4.is_loading = true; // CALL STORE SAMPLE RESULT

                resStoreCauseOfDefectStatus = "success";
                _context2.next = 7;
                return axios.post("/qm/ajax/packet-air-leaks/defect", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  resStoreCauseOfDefectStatus = resData.status;

                  if (resData.status == "success") {
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E32\u0E40\u0E2B\u0E15\u0E38\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2D\u0E31\u0E15\u0E23\u0E32\u0E25\u0E21\u0E23\u0E31\u0E48\u0E27\u0E02\u0E2D\u0E07\u0E0B\u0E2D\u0E07\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E32\u0E40\u0E2B\u0E15\u0E38\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2D\u0E31\u0E15\u0E23\u0E32\u0E25\u0E21\u0E23\u0E31\u0E48\u0E27\u0E02\u0E2D\u0E07\u0E0B\u0E2D\u0E07\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreCauseOfDefectStatus = "error";
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E32\u0E40\u0E2B\u0E15\u0E38\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2D\u0E31\u0E15\u0E23\u0E32\u0E25\u0E21\u0E23\u0E31\u0E48\u0E27\u0E02\u0E2D\u0E07\u0E0B\u0E2D\u0E07\u0E1A\u0E38\u0E2B\u0E23\u0E35\u0E48 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 7:
                // HIDE LOADING
                _this4.is_loading = false; // // emit cause of defect sumitted
                // this.$emit("onCauseOfDefectSubmitted", {
                //     status: resStoreCauseOfDefectStatus,
                //     sample_no: this.sampleData.sample_no,
                // });

              case 8:
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
        return (item.result_value === "" || item.result_value === null) && item.read_only != 'Y';
      });

      if (incompletedResultValueLines.length > 0) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\" \u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19";
        return result;
      } // VALIDATE SAMPLE_RESULT : TEST_TIME


      var sampleResultTestTime = sampleResults.find(function (item) {
        return item.test.time_flag == 'Y';
      });

      if (sampleResultTestTime) {
        if (!sampleResultTestTime.result_value) {
          result.valid = false;
          result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"".concat(sampleResultTestTime.test.test_desc, "\"");
          return result;
        } else {
          if (!moment__WEBPACK_IMPORTED_MODULE_4___default()(sampleResultTestTime.result_value, "HH:mm", true).isValid()) {
            result.valid = false;
            result.message = "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"".concat(sampleResultTestTime.test.test_desc, "\" \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A");
            return result;
          }
        }
      }

      return result;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TablePacketAirLeakResults_vue_vue_type_template_id_5434ebd0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0& */ "./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0&");
/* harmony import */ var _TablePacketAirLeakResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TablePacketAirLeakResults.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TablePacketAirLeakResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TablePacketAirLeakResults_vue_vue_type_template_id_5434ebd0___WEBPACK_IMPORTED_MODULE_0__.render,
  _TablePacketAirLeakResults_vue_vue_type_template_id_5434ebd0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePacketAirLeakResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePacketAirLeakResults.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePacketAirLeakResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePacketAirLeakResults_vue_vue_type_template_id_5434ebd0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePacketAirLeakResults_vue_vue_type_template_id_5434ebd0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TablePacketAirLeakResults_vue_vue_type_template_id_5434ebd0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/packet-air-leaks/TablePacketAirLeakResults.vue?vue&type=template&id=5434ebd0& ***!
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
    { staticClass: "tw-ml-10 tw-mr-10 tw-py-2" },
    [
      _c("table", { staticClass: "table table-borderless-horizontal mb-0" }, [
        _c("thead", [
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
                attrs: { width: "12%" }
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
                attrs: { width: "8%" }
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
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "8%" }
              },
              [
                _vm._v(
                  "\n                    อยู่ในช่วงควบคุม\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c("th", {
              staticClass:
                "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
              staticStyle: { "z-index": "auto" },
              attrs: { width: "5%" }
            }),
            _vm._v(" "),
            _vm.showType == "defect"
              ? _c(
                  "th",
                  {
                    staticClass:
                      "tw-text-gray-600 tw-bg-opacity-40 tw-bg-blue-100 text-center tw-text-xs md:tw-table-cell tw-hidden",
                    staticStyle: { "z-index": "auto" },
                    attrs: { width: "20%" }
                  },
                  [_vm._v("\n                    สาเหตุ\n                ")]
                )
              : _vm._e()
          ])
        ]),
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
                                _vm._s(sampleResult.optimal_value) +
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
                                  sampleResult.brand_flag == "Y"
                                    ? [
                                        _c("qm-el-select", {
                                          attrs: {
                                            id: "input_result_value_" + index,
                                            name: "result_value_" + index,
                                            "option-key": "brand_value",
                                            "option-value": "brand_value",
                                            "option-label": "brand_label",
                                            "select-options": _vm.listBrands,
                                            value: sampleResult.result_value,
                                            size: "small",
                                            clearable: true,
                                            filterable: true
                                          },
                                          on: {
                                            onSelected: function($event) {
                                              return _vm.onSampleResultChanged(
                                                $event,
                                                sampleResult
                                              )
                                            }
                                          }
                                        })
                                      ]
                                    : sampleResult.position_leak_flag == "Y"
                                    ? [
                                        sampleResult.position_leak_required ==
                                        "Y"
                                          ? [
                                              _c(
                                                "div",
                                                {
                                                  staticClass:
                                                    "qm-el-select-required"
                                                },
                                                [
                                                  _c("qm-el-select", {
                                                    attrs: {
                                                      id:
                                                        "input_result_value_" +
                                                        index,
                                                      name:
                                                        "result_value_" + index,
                                                      "option-key":
                                                        "position_leak_value",
                                                      "option-value":
                                                        "position_leak_value",
                                                      "option-label":
                                                        "position_leak_label",
                                                      "select-options":
                                                        _vm.listRequiredLeakPositions,
                                                      value:
                                                        sampleResult.result_value,
                                                      size: "small",
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onSampleResultChanged(
                                                          $event,
                                                          sampleResult
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            ]
                                          : sampleResult.position_leak_entered ==
                                            "Y"
                                          ? [
                                              _c(
                                                "div",
                                                {
                                                  staticClass:
                                                    "qm-el-select-required"
                                                },
                                                [
                                                  _c("qm-el-select", {
                                                    attrs: {
                                                      id:
                                                        "input_result_value_" +
                                                        index,
                                                      name:
                                                        "result_value_" + index,
                                                      "option-key":
                                                        "position_leak_value",
                                                      "option-value":
                                                        "position_leak_value",
                                                      "option-label":
                                                        "position_leak_label",
                                                      "select-options":
                                                        _vm.listLeakPositions,
                                                      value:
                                                        sampleResult.result_value,
                                                      size: "small",
                                                      filterable: true
                                                    },
                                                    on: {
                                                      onSelected: function(
                                                        $event
                                                      ) {
                                                        return _vm.onSampleResultChanged(
                                                          $event,
                                                          sampleResult
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            ]
                                          : [
                                              _c("qm-el-select", {
                                                attrs: {
                                                  id:
                                                    "input_result_value_" +
                                                    index,
                                                  name: "result_value_" + index,
                                                  "option-key":
                                                    "position_leak_value",
                                                  "option-value":
                                                    "position_leak_value",
                                                  "option-label":
                                                    "position_leak_label",
                                                  "select-options":
                                                    _vm.listLeakPositions,
                                                  value:
                                                    sampleResult.result_value,
                                                  size: "small",
                                                  clearable: true,
                                                  filterable: true
                                                },
                                                on: {
                                                  onSelected: function($event) {
                                                    return _vm.onSampleResultChanged(
                                                      $event,
                                                      sampleResult
                                                    )
                                                  }
                                                }
                                              })
                                            ]
                                      ]
                                    : (sampleResult.test
                                      ? sampleResult.test.time_flag == "Y"
                                      : false)
                                    ? [
                                        _c("qm-timepicker", {
                                          attrs: {
                                            id: "input_result_value_" + index,
                                            name: "result_value_" + index,
                                            value: sampleResult.result_value
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.onSampleResultChanged(
                                                $event,
                                                sampleResult
                                              )
                                            }
                                          }
                                        })
                                      ]
                                    : sampleResult.data_type_code == "N"
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
                                            min: "0",
                                            oninput:
                                              "this.value = Math.abs(this.value)",
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
                                  sampleResult.brand_flag == "Y"
                                    ? [
                                        _vm._v(
                                          "\n                                " +
                                            _vm._s(
                                              sampleResult.result_value
                                                ? _vm.getBrandLabel(
                                                    sampleResult.result_value
                                                  )
                                                : "-"
                                            ) +
                                            "\n                            "
                                        )
                                      ]
                                    : sampleResult.position_leak_flag == "Y"
                                    ? [
                                        _vm._v(
                                          "\n                                " +
                                            _vm._s(
                                              sampleResult.result_value
                                                ? _vm.getLeakPositionLabel(
                                                    sampleResult.result_value
                                                  )
                                                : "-"
                                            ) +
                                            "\n                            "
                                        )
                                      ]
                                    : [
                                        _vm._v(
                                          "\n                                " +
                                            _vm._s(
                                              sampleResult.result_value
                                                ? sampleResult.result_value
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
                        _vm.showType == "defect"
                          ? _c(
                              "td",
                              {
                                staticClass:
                                  "text-left tw-text-xs md:tw-table-cell",
                                staticStyle: { "padding-right": "0px" }
                              },
                              [
                                sampleResult.result_status == "FAILED"
                                  ? [
                                      _c("input", {
                                        directives: [
                                          {
                                            name: "model",
                                            rawName: "v-model",
                                            value: sampleResult.cause_of_defect,
                                            expression:
                                              "sampleResult.cause_of_defect"
                                          }
                                        ],
                                        staticClass:
                                          "form-control input-sm text-left",
                                        attrs: {
                                          type: "text",
                                          disabled: !_vm.isAllowEdit(
                                            _vm.sampleData,
                                            _vm.approvalRole
                                          ),
                                          placeholder: "ระบุสาเหตุ"
                                        },
                                        domProps: {
                                          value: sampleResult.cause_of_defect
                                        },
                                        on: {
                                          input: function($event) {
                                            if ($event.target.composing) {
                                              return
                                            }
                                            _vm.$set(
                                              sampleResult,
                                              "cause_of_defect",
                                              $event.target.value
                                            )
                                          }
                                        }
                                      })
                                    ]
                                  : [
                                      _c("input", {
                                        staticClass:
                                          "form-control input-sm text-left",
                                        attrs: { type: "text", disabled: "" }
                                      })
                                    ]
                              ],
                              2
                            )
                          : _vm._e()
                      ]
                    )
                  ]
                }),
                _vm._v(" "),
                (_vm.showType == "result" || _vm.showType == "defect") &&
                _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "8" } }, [
                        _c(
                          "div",
                          {
                            staticClass:
                              "row justify-content-center clearfix tw-my-4"
                          },
                          [
                            _c("div", { staticClass: "col text-center" }, [
                              _vm.showType == "result"
                                ? _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn btn-md btn-success tw-w-32",
                                      attrs: { type: "button" },
                                      on: {
                                        click: function($event) {
                                          return _vm.onSubmitSampleResult(
                                            $event
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _c("i", { staticClass: "fa fa-save" }),
                                      _vm._v(
                                        " บันทึก\n                            "
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.showType == "defect"
                                ? _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn btn-md btn-success tw-w-32",
                                      attrs: { type: "button" },
                                      on: {
                                        click: function($event) {
                                          return _vm.onSubmitCauseOfDefect(
                                            $event
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _c("i", { staticClass: "fa fa-save" }),
                                      _vm._v(
                                        " บันทึก\n                            "
                                      )
                                    ]
                                  )
                                : _vm._e(),
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
          : _c("tbody", [_vm._m(0)])
      ]),
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
  }
]
render._withStripped = true



/***/ })

}]);