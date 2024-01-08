(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_moth-outbreaks_ElFileUploadMothOutbreakResult_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _ModalReviewSampleResults__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ModalReviewSampleResults */ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue");


function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

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
// Import loading-overlay component



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["id", "name", "action", "locators"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default()),
    ModalReviewSampleResults: _ModalReviewSampleResults__WEBPACK_IMPORTED_MODULE_3__.default
  },
  data: function data() {
    return {
      isLoading: false,
      isUploading: false,
      uploadingPercentage: 0,
      uploadingStatus: "warning",
      fileList: [],
      sheets: [],
      sampleDates: [],
      preparedLocators: [],
      samples: [],
      inputSamples: [],
      comparedInputSamples: []
    };
  },
  methods: {
    submitUpload: function submitUpload() {
      var _this = this;

      var formData = new FormData();

      if (this.fileList[0]) {
        // show loading
        this.isLoading = true;
        formData.append("file", this.fileList[0].raw);
        axios.post(this.action, formData).then(function (res) {
          var resData = res.data.data;
          var resMsg = resData.message;

          if (resData.status == "success") {
            // swal("Success", `บันทึกผลการทดสอบการระบาดของมอดยาสูบ สำเร็จ`, "success");
            _this.showModalReviewSampleResults(resData);
          }

          if (resData.status == "error") {
            swal("Error", "".concat(resMsg), "error");
          }

          _this.fileList = [];
          _this.isLoading = false;
          return resData;
        })["catch"](function (error) {
          _this.isLoading = false;
          console.log(error);
          swal("Error", "".concat(error.message), "error");
        });
      } else {
        this.isLoading = false;
        swal("Error", "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E44\u0E1F\u0E25\u0E4C\u0E17\u0E35\u0E48\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E2D\u0E31\u0E1E\u0E42\u0E2B\u0E25\u0E14", "error");
      }
    },
    handleUploadChange: function handleUploadChange(file, fileList) {
      this.fileList = fileList.slice(-1);
    },
    handleBeforeUpload: function handleBeforeUpload(file) {
      var allowedExcelMime = ["text/csv", "text/plain", "application/csv", "text/comma-separated-values", "application/excel", "application/vnd.ms-excel", "application/vnd.msexcel", "text/anytext", "application/octet-stream", "application/txt"];

      if (allowedExcelMime.includes(file.type)) {
        return true;
      } else {
        this.$message.error("ประเภทไฟล์ไม่ถูกต้อง (รองรับ .xlsx .csv เท่านั้น)");
        this.fileList.pop(file);
      }
    },
    showModalReviewSampleResults: function showModalReviewSampleResults(resData) {
      var _this2 = this;

      this.inputSamples = resData.inputSamples.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          sample_date_formatted: moment__WEBPACK_IMPORTED_MODULE_2___default()(item.sample_date).add(543, 'years').format('DD/MM/YYYY')
        });
      });
      this.samples = resData.samples.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          sample_date_formatted: moment__WEBPACK_IMPORTED_MODULE_2___default()(item.date_drawn).add(543, 'years').format('DD/MM/YYYY')
        });
      });
      this.sheets = resData.sheets;
      this.comparedInputSamples = this.inputSamples.map(function (inputSample) {
        var foundSample = _this2.samples.find(function (sample) {
          return sample.sample_date_formatted == inputSample.sample_date_formatted && sample.locator_id == inputSample.locator_id;
        });

        var oldResultValue = foundSample ? foundSample.results[0].result_value : null;
        var resultValueHasChanged = foundSample ? foundSample.results[0].result_value != inputSample.result_value : true;
        return _objectSpread(_objectSpread({}, inputSample), {}, {
          is_new_sample: foundSample ? false : true,
          old_result_value: oldResultValue,
          result_value_has_changed: resultValueHasChanged,
          selected: !!resultValueHasChanged ? true : false
        });
      });
      this.sampleDates = this.comparedInputSamples.map(function (item) {
        return {
          sample_date_formatted: item.sample_date_formatted
        };
      }).filter(function (value, index, self) {
        return index === self.findIndex(function (t) {
          return t.sample_date_formatted === value.sample_date_formatted;
        });
      });
      this.preparedLocators = this.comparedInputSamples.map(function (item) {
        var locatorData = _this2.getLocatorDesc(item);

        return {
          locator_id: item.locator_id,
          sheet_index: item.sheet_index,
          sheet_name: item.sheet_name,
          location_code: locatorData.location_code,
          location_desc: locatorData.location_desc,
          location_full_desc: locatorData.location_full_desc
        };
      }).filter(function (value, index, self) {
        return index === self.findIndex(function (t) {
          return t.locator_id === value.locator_id;
        });
      });
      window.scrollTo(0, 150);
      this.$modal.show('modal-review-sample-results');
    },
    onSampleResultSubmitted: function onSampleResultSubmitted(data) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var resInputSamples, errStoreSampleResponses, errStoreSampleResultResponses, errStoreSampleResultStatusResponses, percentage, countSampleDates, _iterator, _step, _loop2, resErrorMsg, _iterator2, _step2, _loop, _resErrorMsg;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                resInputSamples = data.input_samples;

                if (!(resInputSamples.length > 0)) {
                  _context3.next = 53;
                  break;
                }

                _this3.$modal.hide('modal-review-sample-results'); // show loading
                // this.isLoading = true;


                _this3.isUploading = true;
                errStoreSampleResponses = [];
                errStoreSampleResultResponses = [];
                errStoreSampleResultStatusResponses = [];
                percentage = 0;
                countSampleDates = _this3.sampleDates.length;
                _iterator = _createForOfIteratorHelper(_this3.sampleDates);
                _context3.prev = 10;
                _loop2 = /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _loop2() {
                  var sampleDate, sampleDateFormatted, filteredInputSamples, resStoreSamples;
                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _loop2$(_context2) {
                    while (1) {
                      switch (_context2.prev = _context2.next) {
                        case 0:
                          sampleDate = _step.value;
                          sampleDateFormatted = sampleDate.sample_date_formatted;
                          filteredInputSamples = resInputSamples.filter(function (inputSample) {
                            return inputSample.sample_date_formatted == sampleDateFormatted;
                          });
                          _context2.next = 5;
                          return _this3.storeSamples(filteredInputSamples);

                        case 5:
                          resStoreSamples = _context2.sent;

                          if (resStoreSamples.status == "error") {
                            errStoreSampleResponses.push(resStoreSamples.message);
                          }

                          percentage = percentage + parseFloat(50 / countSampleDates);
                          console.log("percentage : ", percentage);
                          _this3.uploadingPercentage = percentage;
                          _this3.uploadingStatus = percentage >= 49 ? "primary" : "warning";

                        case 11:
                        case "end":
                          return _context2.stop();
                      }
                    }
                  }, _loop2);
                });

                _iterator.s();

              case 13:
                if ((_step = _iterator.n()).done) {
                  _context3.next = 17;
                  break;
                }

                return _context3.delegateYield(_loop2(), "t0", 15);

              case 15:
                _context3.next = 13;
                break;

              case 17:
                _context3.next = 22;
                break;

              case 19:
                _context3.prev = 19;
                _context3.t1 = _context3["catch"](10);

                _iterator.e(_context3.t1);

              case 22:
                _context3.prev = 22;

                _iterator.f();

                return _context3.finish(22);

              case 25:
                ;
                console.log("errStoreSampleResponses : ", errStoreSampleResponses);

                if (!(errStoreSampleResponses.length > 0)) {
                  _context3.next = 33;
                  break;
                }

                // HIDE LOADING
                // this.isLoading = false;
                _this3.isUploading = false;
                resErrorMsg = errStoreSampleResponses.join(", ");
                swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E23\u0E49\u0E32\u0E07\u0E15\u0E31\u0E27\u0E2D\u0E22\u0E48\u0E32\u0E07\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A \u0E44\u0E21\u0E48\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08 : ".concat(resErrorMsg), "error");
                _context3.next = 52;
                break;

              case 33:
                _iterator2 = _createForOfIteratorHelper(_this3.sampleDates);
                _context3.prev = 34;
                _loop = /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _loop() {
                  var sampleDate, sampleDateFormatted, filteredInputSamples, resStoreResults, resSetSampleResultStatuses;
                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _loop$(_context) {
                    while (1) {
                      switch (_context.prev = _context.next) {
                        case 0:
                          sampleDate = _step2.value;
                          sampleDateFormatted = sampleDate.sample_date_formatted;
                          filteredInputSamples = resInputSamples.filter(function (inputSample) {
                            return inputSample.sample_date_formatted == sampleDateFormatted;
                          });
                          _context.next = 5;
                          return _this3.storeSampleResults(filteredInputSamples);

                        case 5:
                          resStoreResults = _context.sent;

                          if (resStoreResults.status == "error") {
                            errStoreSampleResultResponses.push(resStoreResults.message);
                          }

                          _context.next = 9;
                          return _this3.setSampleResultStatus(filteredInputSamples);

                        case 9:
                          resSetSampleResultStatuses = _context.sent;

                          if (resSetSampleResultStatuses.status == "error") {
                            errStoreSampleResultStatusResponses.push(resSetSampleResultStatuses.message);
                          }

                          percentage = percentage + parseFloat(50 / countSampleDates);
                          console.log("percentage : ", percentage);
                          _this3.uploadingPercentage = percentage;
                          _this3.uploadingStatus = percentage >= 99 ? "success" : "primary";

                        case 15:
                        case "end":
                          return _context.stop();
                      }
                    }
                  }, _loop);
                });

                _iterator2.s();

              case 37:
                if ((_step2 = _iterator2.n()).done) {
                  _context3.next = 41;
                  break;
                }

                return _context3.delegateYield(_loop(), "t2", 39);

              case 39:
                _context3.next = 37;
                break;

              case 41:
                _context3.next = 46;
                break;

              case 43:
                _context3.prev = 43;
                _context3.t3 = _context3["catch"](34);

                _iterator2.e(_context3.t3);

              case 46:
                _context3.prev = 46;

                _iterator2.f();

                return _context3.finish(46);

              case 49:
                console.log("errStoreSampleResultResponses : ", errStoreSampleResultResponses);
                console.log("errStoreSampleResultStatusResponses : ", errStoreSampleResultStatusResponses);

                if (errStoreSampleResultResponses.length <= 0) {
                  setTimeout(function () {
                    _this3.isUploading = false;
                    _this3.uploadingPercentage = 0;
                    _this3.uploadingStatus = "warning";
                  }, 5000); // SUCCESS

                  swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A", "success");
                } else {
                  // HIDE LOADING
                  // this.isLoading = false;
                  _this3.isUploading = false;
                  _resErrorMsg = errStoreSampleResultResponses.join(", ");
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A \u0E44\u0E21\u0E48\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08 : ".concat(_resErrorMsg), "error");
                }

              case 52:
                // HIDE LOADING
                _this3.isLoading = false;

              case 53:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee, null, [[10, 19, 22, 25], [34, 43, 46, 49]]);
      }))();
    },
    storeSamples: function storeSamples(inputSamples) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var reqBody, resStoreSamples;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                reqBody = {
                  input_samples: JSON.stringify(inputSamples)
                }; // call store samples

                _context4.next = 3;
                return axios.post("/qm/ajax/moth-outbreaks/samples", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message; // if(resData.status == "error") {
                  //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                  // }

                  return resData;
                })["catch"](function (error) {
                  _this4.isLoading = false;
                  console.log(error);
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A | ".concat(error.message), "error");
                });

              case 3:
                resStoreSamples = _context4.sent;
                return _context4.abrupt("return", resStoreSamples);

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee2);
      }))();
    },
    storeSampleResults: function storeSampleResults(inputSamples) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var reqBody, resStoreResults, resWebBatchNo, resCallPackage;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                reqBody = {
                  input_samples: JSON.stringify(inputSamples)
                }; // CALL STORE SAMPLE RESULTS

                _context5.next = 3;
                return axios.post("/qm/ajax/moth-outbreaks/results", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message; // if(resData.status == "error") {
                  //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                  // }

                  return resData;
                })["catch"](function (error) {
                  // this.isLoading = false;
                  _this5.isUploading = false;
                  console.log(error);
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A | ".concat(error.message), "error");
                });

              case 3:
                resStoreResults = _context5.sent;

                if (!(resStoreResults.status == "success")) {
                  _context5.next = 11;
                  break;
                }

                resWebBatchNo = resStoreResults.web_batch_no ? resStoreResults.web_batch_no : null;
                _context5.next = 8;
                return _this5.callPackageAddSampleResults(resWebBatchNo);

              case 8:
                resCallPackage = _context5.sent;

                if (!(resCallPackage.status == "error")) {
                  _context5.next = 11;
                  break;
                }

                return _context5.abrupt("return", resCallPackage);

              case 11:
                return _context5.abrupt("return", resStoreResults);

              case 12:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee3);
      }))();
    },
    callPackageAddSampleResults: function callPackageAddSampleResults(webBatchNo) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var reqBody, resCallPackage;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                reqBody = {
                  web_batch_no: webBatchNo
                }; // CALL STORE SAMPLE RESULTS

                _context6.next = 3;
                return axios.post("/qm/ajax/moth-outbreaks/call-pkg-add-results", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message; // if(resData.status == "error") {
                  //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                  // }

                  return resData;
                })["catch"](function (error) {
                  // this.isLoading = false;
                  _this6.isUploading = false;
                  console.log(error);
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A | ".concat(error.message), "error");
                });

              case 3:
                resCallPackage = _context6.sent;
                return _context6.abrupt("return", resCallPackage);

              case 5:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee4);
      }))();
    },
    setSampleResultStatus: function setSampleResultStatus(inputSamples) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var reqBody, resCallPackage;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                reqBody = {
                  input_samples: JSON.stringify(inputSamples)
                }; // CALL STORE SAMPLE RESULTS

                _context7.next = 3;
                return axios.post("/qm/ajax/moth-outbreaks/set-sample-result-status", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message; // if(resData.status == "error") {
                  //     swal("Error", `บันทึกลงผลการการระบาดของมอดยาสูบ | ${resMsg}`, "error");
                  // }

                  return resData;
                })["catch"](function (error) {
                  // this.isLoading = false;
                  _this7.isUploading = false;
                  console.log(error);
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E01\u0E32\u0E23\u0E23\u0E30\u0E1A\u0E32\u0E14\u0E02\u0E2D\u0E07\u0E21\u0E2D\u0E14\u0E22\u0E32\u0E2A\u0E39\u0E1A | ".concat(error.message), "error");
                });

              case 3:
                resCallPackage = _context7.sent;
                return _context7.abrupt("return", resCallPackage);

              case 5:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getLocatorDesc: function getLocatorDesc(item) {
      var foundLocator = this.locators.find(function (i) {
        return i.inventory_location_id == item.locator_id;
      });
      var locationCode = foundLocator ? "".concat(foundLocator.location_code ? foundLocator.location_code : "") : "";
      var locationDesc = foundLocator ? "".concat(foundLocator.location_desc ? foundLocator.location_desc : "") : "";
      var locationFullDesc = foundLocator ? "".concat(foundLocator.location_full_desc ? foundLocator.location_full_desc : "") : "";
      return {
        location_code: locationCode,
        location_desc: locationDesc,
        location_full_desc: locationFullDesc
      };
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight", "sheets", "sampleDates", "locators", "preparedLocators", "samples", "inputSamples", "comparedInputSamples"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    sheets: function sheets(data) {
      this.sheetItems = data ? data : [];
      this.sheetActiveStatuses = data ? data.map(function (item, index) {
        return {
          sheet_index: index,
          sheet_name: item,
          active: index === 0 ? true : false
        };
      }) : [];
      this.activatedLocatorLength = this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems).length;
    },
    sampleDates: function sampleDates(data) {
      this.sampleDateItems = data ? data.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          all_selected: true
        });
      }) : [];
    },
    locators: function locators(data) {
      this.locatorItems = data ? data : [];
    },
    preparedLocators: function preparedLocators(data) {
      this.preparedLocatorItems = data ? data : [];
      this.activatedLocatorLength = this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems).length;
    },
    samples: function samples(data) {
      this.sampleItems = data ? data : [];
    },
    inputSamples: function inputSamples(data) {
      this.inputSampleItems = data ? data : [];
    },
    comparedInputSamples: function comparedInputSamples(data) {
      this.cisItems = data ? data : [];
      this.isAllowConfirmUpload = data ? data.filter(function (item) {
        return item.selected;
      }).length > 0 : false;
    }
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      sheetItems: this.sheets ? this.sheets : [],
      activatedLocatorLength: this.getActivatedLocators([], []).length,
      sheetActiveStatuses: this.sheets ? this.sheets.map(function (item, index) {
        return {
          sheet_index: index,
          sheet_name: item,
          active: index === 0 ? true : false
        };
      }) : [],
      sampleDateItems: this.sampleDates ? this.sampleDates.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          all_selected: true
        });
      }) : [],
      locatorItems: this.locators ? this.locators : [],
      preparedLocatorItems: this.preparedLocators ? this.preparedLocators : [],
      sampleItems: this.samples ? this.samples : [],
      inputSampleItems: this.inputSamples ? this.inputSamples : [],
      cisItems: this.comparedInputSamples ? this.comparedInputSamples : [],
      isAllowConfirmUpload: this.comparedInputSamples ? this.comparedInputSamples.filter(function (item) {
        return item.selected;
      }).length > 0 : false
    };
  },
  created: function created() {
    this.handleResize();
  },
  mounted: function mounted() {
    this.activatedLocatorLength = this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems).length;
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
    toggleSheet: function toggleSheet(sheetIndex) {
      this.sheetActiveStatuses = this.sheetItems.map(function (item, index) {
        return {
          sheet_index: index,
          sheet_name: item,
          active: index === sheetIndex ? true : false
        };
      });
      this.activatedLocatorLength = this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems).length;
      this.sampleDateItems = this.sampleDateItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          all_selected: true
        });
      });
    },
    isLocatorShow: function isLocatorShow(locatorId) {
      var result = false;
      var foundLocator = this.preparedLocatorItems.find(function (locItem) {
        return locItem.locator_id === locatorId;
      });

      if (foundLocator) {
        var foundActiveStatus = this.sheetActiveStatuses.find(function (item) {
          return item.sheet_index === foundLocator.sheet_index;
        });
        result = foundActiveStatus ? foundActiveStatus.active : false;
      }

      return result;
    },
    getActivatedLocators: function getActivatedLocators(sheetActiveStatuses, preparedLocatorItems) {
      var activatedLocators = [];
      var activatedSheet = sheetActiveStatuses.find(function (item) {
        return item.active === true;
      });

      if (activatedSheet) {
        activatedLocators = preparedLocatorItems.filter(function (locItem) {
          return locItem.sheet_index == activatedSheet.sheet_index;
        });
      }

      return activatedLocators;
    },
    onToggleSelectAll: function onToggleSelectAll($event, sampleDate) {
      var checkedValue = sampleDate.all_selected;
      var foundActiveSheet = this.sheetActiveStatuses.find(function (item) {
        return item.active === true;
      });
      var activeSheetIndex = foundActiveSheet.sheet_index;
      this.cisItems = this.cisItems.map(function (item) {
        var selected = item.selected;

        if (item.sample_date_formatted == sampleDate.sample_date_formatted && item.sheet_index == activeSheetIndex && (item.is_new_sample || item.result_value_has_changed)) {
          console.log("found item : ", item);
          selected = checkedValue;
        }

        return _objectSpread(_objectSpread({}, item), {}, {
          selected: selected
        });
      });
    },
    onSampleItemHasChanged: function onSampleItemHasChanged(e) {
      this.isAllowConfirmUpload = this.comparedInputSamples ? this.comparedInputSamples.filter(function (item) {
        return item.selected;
      }).length > 0 : false;
    },
    onConfirmUpload: function onConfirmUpload(e) {
      var selectedSamples = this.cisItems.filter(function (item) {
        return item.selected;
      });
      this.$emit("onSampleResultSubmitted", {
        input_samples: selectedSamples
      });
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-82915dba] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_style_index_0_id_82915dba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_style_index_0_id_82915dba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_style_index_0_id_82915dba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ElFileUploadMothOutbreakResult_vue_vue_type_template_id_4d694ff8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8& */ "./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8&");
/* harmony import */ var _ElFileUploadMothOutbreakResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ElFileUploadMothOutbreakResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ElFileUploadMothOutbreakResult_vue_vue_type_template_id_4d694ff8___WEBPACK_IMPORTED_MODULE_0__.render,
  _ElFileUploadMothOutbreakResult_vue_vue_type_template_id_4d694ff8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalReviewSampleResults_vue_vue_type_template_id_82915dba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true& */ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true&");
/* harmony import */ var _ModalReviewSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalReviewSampleResults.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalReviewSampleResults_vue_vue_type_style_index_0_id_82915dba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css& */ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalReviewSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalReviewSampleResults_vue_vue_type_template_id_82915dba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalReviewSampleResults_vue_vue_type_template_id_82915dba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "82915dba",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUploadMothOutbreakResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUploadMothOutbreakResult_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalReviewSampleResults.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_style_index_0_id_82915dba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=style&index=0&id=82915dba&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUploadMothOutbreakResult_vue_vue_type_template_id_4d694ff8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUploadMothOutbreakResult_vue_vue_type_template_id_4d694ff8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUploadMothOutbreakResult_vue_vue_type_template_id_4d694ff8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8&");


/***/ }),

/***/ "./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_template_id_82915dba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_template_id_82915dba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReviewSampleResults_vue_vue_type_template_id_82915dba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8&":
/*!************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ElFileUploadMothOutbreakResult.vue?vue&type=template&id=4d694ff8& ***!
  \************************************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "row" }, [
        _c("label", { staticClass: "col-md-3 col-form-label" }, [
          _vm._v(" ลงผลการตรวจสอบ ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "col-md-9 text-center tw-border-2 tw-border-dashed tw-border-gray-200 tw-py-4 "
          },
          [
            _c(
              "el-upload",
              {
                ref: "upload",
                staticClass: "upload-demo",
                attrs: {
                  id: _vm.id,
                  name: _vm.name,
                  action: "",
                  "on-change": _vm.handleUploadChange,
                  "before-upload": _vm.handleBeforeUpload,
                  accept:
                    ".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel",
                  "file-list": _vm.fileList,
                  "auto-upload": false,
                  limit: 1,
                  disabled: _vm.isUploading
                }
              },
              [
                _c(
                  "el-button",
                  {
                    attrs: {
                      slot: "trigger",
                      disabled: _vm.isUploading,
                      size: "medium",
                      type: "success"
                    },
                    slot: "trigger"
                  },
                  [
                    _c("i", { staticClass: "fa fa fa-file-excel-o tw-mr-1" }),
                    _vm._v(" Choose file\n                ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "el-button",
                  {
                    attrs: {
                      disabled: _vm.isUploading,
                      type: "primary",
                      size: "medium"
                    },
                    on: { click: _vm.submitUpload }
                  },
                  [
                    _c("i", { staticClass: "fa fa-upload tw-mr-1" }),
                    _vm._v(" Upload ผลการทดสอบ\n                ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "el-upload__tip",
                    attrs: { slot: "tip" },
                    slot: "tip"
                  },
                  [
                    _vm._v(
                      "\n                    รองรับ .xlsx .csv เท่านั้น\n                "
                    )
                  ]
                )
              ],
              1
            )
          ],
          1
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
      }),
      _vm._v(" "),
      _c("modal-review-sample-results", {
        attrs: {
          "modal-name": "modal-review-sample-results",
          "modal-width": "1340",
          "modal-height": "640",
          locators: _vm.locators,
          sheets: _vm.sheets,
          "sample-dates": _vm.sampleDates,
          "prepared-locators": _vm.preparedLocators,
          samples: _vm.samples,
          "input-samples": _vm.inputSamples,
          "compared-input-samples": _vm.comparedInputSamples
        },
        on: { onSampleResultSubmitted: _vm.onSampleResultSubmitted }
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.isUploading,
              expression: "isUploading"
            }
          ],
          staticClass: "tw-mt-5"
        },
        [
          _c("p", { staticClass: "tw-mb-2" }, [_vm._v(" Uploading ... ")]),
          _vm._v(" "),
          _c("el-progress", {
            attrs: {
              "text-inside": true,
              "stroke-width": 20,
              percentage: _vm.uploadingPercentage,
              status: _vm.uploadingStatus
            }
          })
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/moth-outbreaks/ModalReviewSampleResults.vue?vue&type=template&id=82915dba&scoped=true& ***!
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
    { staticStyle: { "z-index": "100" } },
    [
      _c(
        "modal",
        {
          attrs: {
            name: _vm.modalName,
            width: _vm.width,
            scrollable: true,
            height: _vm.modalHeight,
            shiftX: 0.2,
            shiftY: 0.4
          }
        },
        [
          _c("div", { staticClass: "p-4 text-left" }, [
            _c("h3", { staticClass: "text-left" }, [
              _vm._v(" Upload ผลการทดสอบ ")
            ]),
            _vm._v(" "),
            _c("hr", { staticClass: "tw-mt-1" }),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "btn-group tw-pb-3", attrs: { role: "group" } },
              [
                _vm._l(_vm.sheetItems, function(sheetItem, sIndex) {
                  return [
                    _c(
                      "button",
                      {
                        key: "" + sIndex,
                        staticClass: "btn",
                        class: [
                          _vm.sheetActiveStatuses[sIndex].active
                            ? "btn-primary"
                            : "btn-white"
                        ],
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.toggleSheet(sIndex)
                          }
                        }
                      },
                      [
                        _vm._v(
                          " \n                        " +
                            _vm._s(sheetItem) +
                            " \n                    "
                        )
                      ]
                    )
                  ]
                })
              ],
              2
            ),
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
                              staticClass: "text-center",
                              attrs: { rowspan: "2" }
                            },
                            [
                              _vm._v(
                                "\n                                โซนที่ตั้ง  \n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-center",
                              attrs: { rowspan: "2" }
                            },
                            [
                              _vm._v(
                                "\n                                บริเวณที่ติดตั้ง\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm._l(_vm.sampleDateItems, function(
                            sampleDate,
                            sdIndex
                          ) {
                            return [
                              _c(
                                "th",
                                {
                                  key: "" + sdIndex,
                                  staticClass: "text-center",
                                  attrs: { colspan: "3" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(sampleDate.sample_date_formatted) +
                                      "\n                                "
                                  )
                                ]
                              )
                            ]
                          })
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "tr",
                        [
                          _vm._l(_vm.sampleDateItems, function(
                            sampleDate,
                            sdIndex
                          ) {
                            return [
                              _c(
                                "th",
                                {
                                  key: sdIndex + "_1",
                                  staticClass: "text-center",
                                  staticStyle: { top: "34px", padding: "0px" }
                                },
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "tw-p-2",
                                      staticStyle: {
                                        "border-top": "1px solid #e7eaec"
                                      }
                                    },
                                    [_vm._v(" เลือก ")]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass: "tw-p-2",
                                      staticStyle: {
                                        "border-top": "1px solid #e7eaec"
                                      }
                                    },
                                    [
                                      _c("span", [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value: sampleDate.all_selected,
                                              expression:
                                                "sampleDate.all_selected"
                                            }
                                          ],
                                          attrs: { type: "checkbox" },
                                          domProps: {
                                            checked: Array.isArray(
                                              sampleDate.all_selected
                                            )
                                              ? _vm._i(
                                                  sampleDate.all_selected,
                                                  null
                                                ) > -1
                                              : sampleDate.all_selected
                                          },
                                          on: {
                                            change: [
                                              function($event) {
                                                var $$a =
                                                    sampleDate.all_selected,
                                                  $$el = $event.target,
                                                  $$c = $$el.checked
                                                    ? true
                                                    : false
                                                if (Array.isArray($$a)) {
                                                  var $$v = null,
                                                    $$i = _vm._i($$a, $$v)
                                                  if ($$el.checked) {
                                                    $$i < 0 &&
                                                      _vm.$set(
                                                        sampleDate,
                                                        "all_selected",
                                                        $$a.concat([$$v])
                                                      )
                                                  } else {
                                                    $$i > -1 &&
                                                      _vm.$set(
                                                        sampleDate,
                                                        "all_selected",
                                                        $$a
                                                          .slice(0, $$i)
                                                          .concat(
                                                            $$a.slice($$i + 1)
                                                          )
                                                      )
                                                  }
                                                } else {
                                                  _vm.$set(
                                                    sampleDate,
                                                    "all_selected",
                                                    $$c
                                                  )
                                                }
                                              },
                                              function($event) {
                                                return _vm.onToggleSelectAll(
                                                  $event,
                                                  sampleDate
                                                )
                                              }
                                            ]
                                          }
                                        })
                                      ])
                                    ]
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  key: sdIndex + "_2",
                                  staticClass: "text-center",
                                  staticStyle: { top: "34px", padding: "0px" }
                                },
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "tw-py-6 tw-px-2",
                                      staticStyle: {
                                        "min-height": "70px",
                                        "border-top": "1px solid #e7eaec"
                                      }
                                    },
                                    [_vm._v(" มอดยาสูบ ")]
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  key: sdIndex + "_3",
                                  staticClass: "text-center",
                                  staticStyle: { top: "34px", padding: "0px" }
                                },
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "tw-py-6 tw-px-2",
                                      staticStyle: {
                                        "min-height": "70px",
                                        "border-top": "1px solid #e7eaec"
                                      }
                                    },
                                    [_vm._v(" สถานะการลงผล ")]
                                  )
                                ]
                              )
                            ]
                          })
                        ],
                        2
                      )
                    ]),
                    _vm._v(" "),
                    _vm.activatedLocatorLength > 0
                      ? _c(
                          "tbody",
                          [
                            _vm._l(_vm.preparedLocatorItems, function(
                              pl,
                              plIndex
                            ) {
                              return [
                                _c(
                                  "tr",
                                  {
                                    directives: [
                                      {
                                        name: "show",
                                        rawName: "v-show",
                                        value: _vm.isLocatorShow(pl.locator_id),
                                        expression:
                                          "isLocatorShow(pl.locator_id)"
                                      }
                                    ],
                                    key: "" + plIndex
                                  },
                                  [
                                    _c("td", { staticClass: "text-center" }, [
                                      _vm._v(
                                        "\n                                    " +
                                          _vm._s(pl.location_desc) +
                                          "\n                                "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-left" }, [
                                      _vm._v(
                                        "\n                                    " +
                                          _vm._s(pl.location_full_desc) +
                                          "\n                                "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(_vm.sampleDateItems, function(
                                      sd,
                                      sdIndex
                                    ) {
                                      return [
                                        _c(
                                          "td",
                                          {
                                            key: sdIndex + "_1",
                                            staticClass: "text-center"
                                          },
                                          [
                                            _vm.cisItems.find(function(item) {
                                              return (
                                                item.locator_id ==
                                                  pl.locator_id &&
                                                item.sample_date_formatted ==
                                                  sd.sample_date_formatted
                                              )
                                            })
                                              ? [
                                                  _vm.cisItems.find(function(
                                                    item
                                                  ) {
                                                    return (
                                                      item.locator_id ==
                                                        pl.locator_id &&
                                                      item.sample_date_formatted ==
                                                        sd.sample_date_formatted
                                                    )
                                                  }).is_new_sample
                                                    ? _c("span", [
                                                        _c("input", {
                                                          directives: [
                                                            {
                                                              name: "model",
                                                              rawName:
                                                                "v-model",
                                                              value: _vm.cisItems.find(
                                                                function(item) {
                                                                  return (
                                                                    item.locator_id ==
                                                                      pl.locator_id &&
                                                                    item.sample_date_formatted ==
                                                                      sd.sample_date_formatted
                                                                  )
                                                                }
                                                              ).selected,
                                                              expression:
                                                                "(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).selected"
                                                            }
                                                          ],
                                                          attrs: {
                                                            type: "checkbox"
                                                          },
                                                          domProps: {
                                                            checked: Array.isArray(
                                                              _vm.cisItems.find(
                                                                function(item) {
                                                                  return (
                                                                    item.locator_id ==
                                                                      pl.locator_id &&
                                                                    item.sample_date_formatted ==
                                                                      sd.sample_date_formatted
                                                                  )
                                                                }
                                                              ).selected
                                                            )
                                                              ? _vm._i(
                                                                  _vm.cisItems.find(
                                                                    function(
                                                                      item
                                                                    ) {
                                                                      return (
                                                                        item.locator_id ==
                                                                          pl.locator_id &&
                                                                        item.sample_date_formatted ==
                                                                          sd.sample_date_formatted
                                                                      )
                                                                    }
                                                                  ).selected,
                                                                  null
                                                                ) > -1
                                                              : _vm.cisItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.locator_id ==
                                                                        pl.locator_id &&
                                                                      item.sample_date_formatted ==
                                                                        sd.sample_date_formatted
                                                                    )
                                                                  }
                                                                ).selected
                                                          },
                                                          on: {
                                                            change: [
                                                              function($event) {
                                                                var $$a = _vm.cisItems.find(
                                                                    function(
                                                                      item
                                                                    ) {
                                                                      return (
                                                                        item.locator_id ==
                                                                          pl.locator_id &&
                                                                        item.sample_date_formatted ==
                                                                          sd.sample_date_formatted
                                                                      )
                                                                    }
                                                                  ).selected,
                                                                  $$el =
                                                                    $event.target,
                                                                  $$c = $$el.checked
                                                                    ? true
                                                                    : false
                                                                if (
                                                                  Array.isArray(
                                                                    $$a
                                                                  )
                                                                ) {
                                                                  var $$v = null,
                                                                    $$i = _vm._i(
                                                                      $$a,
                                                                      $$v
                                                                    )
                                                                  if (
                                                                    $$el.checked
                                                                  ) {
                                                                    $$i < 0 &&
                                                                      _vm.$set(
                                                                        _vm.cisItems.find(
                                                                          function(
                                                                            item
                                                                          ) {
                                                                            return (
                                                                              item.locator_id ==
                                                                                pl.locator_id &&
                                                                              item.sample_date_formatted ==
                                                                                sd.sample_date_formatted
                                                                            )
                                                                          }
                                                                        ),
                                                                        "selected",
                                                                        $$a.concat(
                                                                          [$$v]
                                                                        )
                                                                      )
                                                                  } else {
                                                                    $$i > -1 &&
                                                                      _vm.$set(
                                                                        _vm.cisItems.find(
                                                                          function(
                                                                            item
                                                                          ) {
                                                                            return (
                                                                              item.locator_id ==
                                                                                pl.locator_id &&
                                                                              item.sample_date_formatted ==
                                                                                sd.sample_date_formatted
                                                                            )
                                                                          }
                                                                        ),
                                                                        "selected",
                                                                        $$a
                                                                          .slice(
                                                                            0,
                                                                            $$i
                                                                          )
                                                                          .concat(
                                                                            $$a.slice(
                                                                              $$i +
                                                                                1
                                                                            )
                                                                          )
                                                                      )
                                                                  }
                                                                } else {
                                                                  _vm.$set(
                                                                    _vm.cisItems.find(
                                                                      function(
                                                                        item
                                                                      ) {
                                                                        return (
                                                                          item.locator_id ==
                                                                            pl.locator_id &&
                                                                          item.sample_date_formatted ==
                                                                            sd.sample_date_formatted
                                                                        )
                                                                      }
                                                                    ),
                                                                    "selected",
                                                                    $$c
                                                                  )
                                                                }
                                                              },
                                                              function($event) {
                                                                return _vm.onSampleItemHasChanged(
                                                                  $event
                                                                )
                                                              }
                                                            ]
                                                          }
                                                        })
                                                      ])
                                                    : _vm.cisItems.find(
                                                        function(item) {
                                                          return (
                                                            item.locator_id ==
                                                              pl.locator_id &&
                                                            item.sample_date_formatted ==
                                                              sd.sample_date_formatted
                                                          )
                                                        }
                                                      ).result_value_has_changed
                                                    ? _c("span", [
                                                        _c("input", {
                                                          directives: [
                                                            {
                                                              name: "model",
                                                              rawName:
                                                                "v-model",
                                                              value: _vm.cisItems.find(
                                                                function(item) {
                                                                  return (
                                                                    item.locator_id ==
                                                                      pl.locator_id &&
                                                                    item.sample_date_formatted ==
                                                                      sd.sample_date_formatted
                                                                  )
                                                                }
                                                              ).selected,
                                                              expression:
                                                                "(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).selected"
                                                            }
                                                          ],
                                                          attrs: {
                                                            type: "checkbox"
                                                          },
                                                          domProps: {
                                                            checked: Array.isArray(
                                                              _vm.cisItems.find(
                                                                function(item) {
                                                                  return (
                                                                    item.locator_id ==
                                                                      pl.locator_id &&
                                                                    item.sample_date_formatted ==
                                                                      sd.sample_date_formatted
                                                                  )
                                                                }
                                                              ).selected
                                                            )
                                                              ? _vm._i(
                                                                  _vm.cisItems.find(
                                                                    function(
                                                                      item
                                                                    ) {
                                                                      return (
                                                                        item.locator_id ==
                                                                          pl.locator_id &&
                                                                        item.sample_date_formatted ==
                                                                          sd.sample_date_formatted
                                                                      )
                                                                    }
                                                                  ).selected,
                                                                  null
                                                                ) > -1
                                                              : _vm.cisItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.locator_id ==
                                                                        pl.locator_id &&
                                                                      item.sample_date_formatted ==
                                                                        sd.sample_date_formatted
                                                                    )
                                                                  }
                                                                ).selected
                                                          },
                                                          on: {
                                                            change: [
                                                              function($event) {
                                                                var $$a = _vm.cisItems.find(
                                                                    function(
                                                                      item
                                                                    ) {
                                                                      return (
                                                                        item.locator_id ==
                                                                          pl.locator_id &&
                                                                        item.sample_date_formatted ==
                                                                          sd.sample_date_formatted
                                                                      )
                                                                    }
                                                                  ).selected,
                                                                  $$el =
                                                                    $event.target,
                                                                  $$c = $$el.checked
                                                                    ? true
                                                                    : false
                                                                if (
                                                                  Array.isArray(
                                                                    $$a
                                                                  )
                                                                ) {
                                                                  var $$v = null,
                                                                    $$i = _vm._i(
                                                                      $$a,
                                                                      $$v
                                                                    )
                                                                  if (
                                                                    $$el.checked
                                                                  ) {
                                                                    $$i < 0 &&
                                                                      _vm.$set(
                                                                        _vm.cisItems.find(
                                                                          function(
                                                                            item
                                                                          ) {
                                                                            return (
                                                                              item.locator_id ==
                                                                                pl.locator_id &&
                                                                              item.sample_date_formatted ==
                                                                                sd.sample_date_formatted
                                                                            )
                                                                          }
                                                                        ),
                                                                        "selected",
                                                                        $$a.concat(
                                                                          [$$v]
                                                                        )
                                                                      )
                                                                  } else {
                                                                    $$i > -1 &&
                                                                      _vm.$set(
                                                                        _vm.cisItems.find(
                                                                          function(
                                                                            item
                                                                          ) {
                                                                            return (
                                                                              item.locator_id ==
                                                                                pl.locator_id &&
                                                                              item.sample_date_formatted ==
                                                                                sd.sample_date_formatted
                                                                            )
                                                                          }
                                                                        ),
                                                                        "selected",
                                                                        $$a
                                                                          .slice(
                                                                            0,
                                                                            $$i
                                                                          )
                                                                          .concat(
                                                                            $$a.slice(
                                                                              $$i +
                                                                                1
                                                                            )
                                                                          )
                                                                      )
                                                                  }
                                                                } else {
                                                                  _vm.$set(
                                                                    _vm.cisItems.find(
                                                                      function(
                                                                        item
                                                                      ) {
                                                                        return (
                                                                          item.locator_id ==
                                                                            pl.locator_id &&
                                                                          item.sample_date_formatted ==
                                                                            sd.sample_date_formatted
                                                                        )
                                                                      }
                                                                    ),
                                                                    "selected",
                                                                    $$c
                                                                  )
                                                                }
                                                              },
                                                              function($event) {
                                                                return _vm.onSampleItemHasChanged(
                                                                  $event
                                                                )
                                                              }
                                                            ]
                                                          }
                                                        })
                                                      ])
                                                    : _c("span", [
                                                        _c("input", {
                                                          attrs: {
                                                            type: "checkbox",
                                                            disabled: ""
                                                          },
                                                          on: {
                                                            change: function(
                                                              $event
                                                            ) {
                                                              return _vm.onSampleItemHasChanged(
                                                                $event
                                                              )
                                                            }
                                                          }
                                                        })
                                                      ])
                                                ]
                                              : _vm._e()
                                          ],
                                          2
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            key: sdIndex + "_2",
                                            staticClass: "text-center"
                                          },
                                          [
                                            _vm.cisItems.find(function(item) {
                                              return (
                                                item.locator_id ==
                                                  pl.locator_id &&
                                                item.sample_date_formatted ==
                                                  sd.sample_date_formatted
                                              )
                                            })
                                              ? [
                                                  _vm.cisItems.find(function(
                                                    item
                                                  ) {
                                                    return (
                                                      item.locator_id ==
                                                        pl.locator_id &&
                                                      item.sample_date_formatted ==
                                                        sd.sample_date_formatted
                                                    )
                                                  }).is_new_sample
                                                    ? _c(
                                                        "span",
                                                        {
                                                          staticClass:
                                                            "tw-text-green-600 tw-font-bold"
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                " +
                                                              _vm._s(
                                                                _vm.cisItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.locator_id ==
                                                                        pl.locator_id &&
                                                                      item.sample_date_formatted ==
                                                                        sd.sample_date_formatted
                                                                    )
                                                                  }
                                                                ).result_value
                                                              ) +
                                                              "\n                                            "
                                                          )
                                                        ]
                                                      )
                                                    : _vm.cisItems.find(
                                                        function(item) {
                                                          return (
                                                            item.locator_id ==
                                                              pl.locator_id &&
                                                            item.sample_date_formatted ==
                                                              sd.sample_date_formatted
                                                          )
                                                        }
                                                      ).result_value_has_changed
                                                    ? _c(
                                                        "span",
                                                        {
                                                          staticClass:
                                                            "tw-text-red-600 tw-font-bold"
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                " +
                                                              _vm._s(
                                                                _vm.cisItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.locator_id ==
                                                                        pl.locator_id &&
                                                                      item.sample_date_formatted ==
                                                                        sd.sample_date_formatted
                                                                    )
                                                                  }
                                                                ).result_value
                                                              ) +
                                                              "\n                                            "
                                                          )
                                                        ]
                                                      )
                                                    : _c(
                                                        "span",
                                                        {
                                                          staticClass:
                                                            "tw-text-gray-400 tw-font-bold"
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                " +
                                                              _vm._s(
                                                                _vm.cisItems.find(
                                                                  function(
                                                                    item
                                                                  ) {
                                                                    return (
                                                                      item.locator_id ==
                                                                        pl.locator_id &&
                                                                      item.sample_date_formatted ==
                                                                        sd.sample_date_formatted
                                                                    )
                                                                  }
                                                                ).result_value
                                                              ) +
                                                              "\n                                            "
                                                          )
                                                        ]
                                                      )
                                                ]
                                              : _vm._e()
                                          ],
                                          2
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            key: sdIndex + "_3",
                                            staticClass: "text-center"
                                          },
                                          [
                                            _vm.cisItems.find(function(item) {
                                              return (
                                                item.locator_id ==
                                                  pl.locator_id &&
                                                item.sample_date_formatted ==
                                                  sd.sample_date_formatted
                                              )
                                            })
                                              ? [
                                                  _vm.cisItems.find(function(
                                                    item
                                                  ) {
                                                    return (
                                                      item.locator_id ==
                                                        pl.locator_id &&
                                                      item.sample_date_formatted ==
                                                        sd.sample_date_formatted
                                                    )
                                                  }).is_new_sample
                                                    ? _c(
                                                        "span",
                                                        {
                                                          staticClass:
                                                            "tw-text-green-600 tw-font-bold"
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                ยังไม่อัพโหลด\n                                            "
                                                          )
                                                        ]
                                                      )
                                                    : _vm.cisItems.find(
                                                        function(item) {
                                                          return (
                                                            item.locator_id ==
                                                              pl.locator_id &&
                                                            item.sample_date_formatted ==
                                                              sd.sample_date_formatted
                                                          )
                                                        }
                                                      ).result_value_has_changed
                                                    ? _c(
                                                        "span",
                                                        {
                                                          staticClass:
                                                            "tw-text-blue-600 tw-font-bold"
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                อัพโหลดแล้ว\n                                            "
                                                          )
                                                        ]
                                                      )
                                                    : _c(
                                                        "span",
                                                        {
                                                          staticClass:
                                                            "tw-text-gray-600 tw-font-bold"
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                                                อัพโหลดแล้ว\n                                            "
                                                          )
                                                        ]
                                                      )
                                                ]
                                              : _vm._e()
                                          ],
                                          2
                                        )
                                      ]
                                    })
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
                            _c("td", { attrs: { colspan: "10" } }, [
                              _c(
                                "h2",
                                { staticClass: "p-5 text-center text-muted" },
                                [_vm._v(" ไม่พบข้อมูล ")]
                              )
                            ])
                          ])
                        ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _c("div", { staticClass: "text-right tw-mt-2" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-primary tw-w-32",
                  attrs: {
                    type: "button",
                    disabled: !_vm.isAllowConfirmUpload
                  },
                  on: { click: _vm.onConfirmUpload }
                },
                [_vm._v(" \n                    ยืนยัน\n                ")]
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