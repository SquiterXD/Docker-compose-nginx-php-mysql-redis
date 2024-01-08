(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_finished-products_TableFinishedProductResults_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["modalName", "modalWidth", "modalHeight", "specifications", "testIdValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  watch: {
    specifications: function specifications(items) {
      this.specificationItems = items ? items : [];
      this.testData = this.getTestData(this.specificationItems, this.testId);
    },
    testIdValue: function testIdValue(data) {
      this.testId = data ? data : null;
      this.testData = this.getTestData(this.specificationItems, this.testId);
    }
  },
  data: function data() {
    return {
      isLoading: false,
      width: this.modalWidth,
      specificationItems: this.specifications ? this.specifications : [],
      testId: this.testIdVaue ? this.testIdVaue : null,
      testData: null
    };
  },
  created: function created() {
    this.handleResize();
  },
  mounted: function mounted() {
    this.testData = this.getTestData(this.specificationItems, this.testId);
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
    getTestData: function getTestData(specifications, testId) {
      var result = null;

      if (specifications && testId) {
        result = specifications.find(function (item) {
          return item.test_id == testId;
        });
      }

      return result;
    },
    onModalClosed: function onModalClosed(event) {
      this.$emit("onModalTestImageClosed");
    },
    formatDateTh: function formatDateTh(date) {
      return date ? moment__WEBPACK_IMPORTED_MODULE_2___default()(date).add(543, 'years').format('DD/MM/YYYY') : "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _ModalShowTestImages__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalShowTestImages */ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue");


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
// Import loading-overlay component



 // import ModalShowResultLineImages from "./ModalShowResultLineImages";


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["authUser", "showType", "listBrands", "listTestServerityCodes", "approvalData", "approvalRole", "sample", "items", "resultHeaderItems", "resultItems", "resultItemLines", "attachments", "defaultData"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_2___default()),
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default()),
    ModalShowTestImages: _ModalShowTestImages__WEBPACK_IMPORTED_MODULE_5__.default
  },
  data: function data() {
    var _this = this;

    return {
      sampleData: this.sample,
      specifications: this.items.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          test_serverity_code: item.test_serverity_code ? item.test_serverity_code.toUpperCase() : ""
        });
      }),
      sampleResultHeaders: this.resultHeaderItems.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          selected_test_id: item.test_id,
          selected_test_code: item.test_code,
          selected_test_desc: item.test_desc,
          selected_test_unit: item.test_unit,
          selected_test_unit_desc: item.test_unit_desc,
          // selected_optimal_value: this.getOptimalValue(this.items, item),
          selected_optimal_value: item.optimal_value,
          selected_min_value: item.min_value,
          selected_max_value: item.max_value,
          result_status: "",
          severity_level: "",
          test_serverity_code: "",
          additional_line_flag: null,
          uploadedImages: [],
          result_value: item.test_code == 'RESULT_BY' ? _this.authUser.name : item.result_value,
          images: []
        });
      }).sort(function (a, b) {
        return a.seq - b.seq;
      }),
      sampleResults: this.resultItems.map(function (item) {
        return {
          qm_process_seq: item.qm_process_seq,
          qm_process: item.qm_process,
          sample_qty: item.sample_qty,
          qc_unit_code: item.qc_unit_code,
          machine_description: item.machine_description,
          issue_not_found: _this.checkIssueNotFoundValue(item, _this.resultItemLines),
          show_input_issue_not_found: _this.checkDisplayInputIssueNotFound(item, _this.resultItemLines)
        };
      }).sort(function (a, b) {
        return a.qm_process_seq - b.qm_process_seq;
      }),
      sampleResultLines: this.resultItemLines.map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          check_list_seq: item.check_list_seq,
          check_list: item.check_list ? item.check_list.trim() : null,
          selected_test_id: item.test_id,
          selected_test_code: item.test_code,
          selected_test_desc: item.test_desc,
          selected_test_unit: item.test_unit,
          selected_test_unit_desc: item.test_unit_desc,
          // selected_optimal_value: this.getOptimalValue(this.items, item),
          selected_optimal_value: item.optimal_value,
          selected_min_value: item.min_value,
          selected_max_value: item.max_value,
          result_value: item.result_value ? item.result_value : item.data_type_code == 'N' ? 0 : "",
          result_status: _this.calResultStatus(_objectSpread(_objectSpread({}, item), {}, {
            selected_min_value: item.min_value,
            selected_max_value: item.max_value,
            result_value: item.result_value ? item.result_value : item.data_type_code == 'N' ? 0 : ""
          })),
          failed_status: _this.calFailedStatus(_objectSpread(_objectSpread({}, item), {}, {
            selected_min_value: item.min_value,
            selected_max_value: item.max_value,
            result_value: item.result_value ? item.result_value : item.data_type_code == 'N' ? 0 : ""
          })),
          cause_of_defect: item.cause_of_defect,
          cannot_get_result_flag: item.cannot_get_result_flag,
          cannot_get_result_reason: item.cannot_get_result_reason,
          optimal_result_flag: item.optimal_result_flag,
          severity_level: _this.calSeverityLevel(item),
          test_serverity_code: item.test_serverity_code ? item.test_serverity_code.toUpperCase() : null,
          test_type_code: item.test_type_code ? item.test_type_code : null,
          test_attachment_id: item.test_attachment_id ? item.test_attachment_id : null,
          test_image_path: item.test_image_path ? item.test_image_path : null,
          test_file_name: item.test_file_name ? item.test_file_name : null,
          additional_line_flag: item.additional_line_flag ? item.additional_line_flag : null,
          uploadedImages: _this.getUplodedImages(item),
          images: []
        });
      }).filter(function (value, index, self) {
        return value.show_header_flag != "Y";
      }).sort(function (a, b) {
        return a.check_list_seq - b.check_list_seq;
      }),
      checkListItems: this.items.map(function (item) {
        return {
          qm_process: item.qm_process ? item.qm_process.trim() : null,
          check_list: item.check_list ? item.check_list.trim() : null,
          check_list_seq: item.check_list_seq ? item.check_list_seq.trim() : null
        };
      }).filter(function (value, index, self) {
        return index === self.findIndex(function (t) {
          return t.qm_process === value.qm_process && t.check_list === value.check_list;
        });
      }).sort(function (a, b) {
        return a.check_list_seq - b.check_list_seq;
      }),
      availableCheckListItems: [],
      checkListTestItems: this.items.map(function (item) {
        return {
          qm_process: item.qm_process ? item.qm_process.trim() : null,
          check_list: item.check_list ? item.check_list.trim() : null,
          check_list_seq: item.check_list_seq ? item.check_list_seq.trim() : null,
          result_id: item.result_id,
          result_line_id: item.result_line_id,
          test_id: item.test_id,
          test_code: item.test_code,
          test_desc: item.test_desc,
          test_unit: item.test_unit,
          test_unit_desc: item.test_unit_desc,
          test_serverity_code: item.test_serverity_code ? item.test_serverity_code.toUpperCase() : null,
          // optimal_value: this.getOptimalValue(this.items, item),
          optimal_value: item.optimal_value,
          min_value: item.min_value,
          max_value: item.max_value
        };
      }).filter(function (value, index, self) {
        return index === self.findIndex(function (t) {
          return t.qm_process === value.qm_process && t.check_list === value.check_list && t.test_id === value.test_id;
        });
      }).sort(function (a, b) {
        return a.check_list_seq - b.check_list_seq;
      }),
      availableCheckListTestItems: [],
      // showedModalSampleResultLine: null,
      showedModalTestId: null,
      // isCannotGetResult: false,
      isLoading: false
    };
  },
  mounted: function mounted() {
    var _this2 = this;

    // SET DEFAULT TEST_SEVERITY_CODE
    this.sampleResultLines.forEach( /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(item, i) {
        var testItem, testServerityCode;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                testItem = _this2.checkListTestItems.find(function (clt) {
                  return clt.check_list == item.check_list && clt.test_id == item.test_id;
                });
                testServerityCode = testItem ? testItem.test_serverity_code.toUpperCase() : "";
                item.test_serverity_code = item.test_serverity_code ? item.test_serverity_code.toUpperCase() : testServerityCode;

                _this2.calResultStatus(item);

                _this2.calFailedStatus(item);

                _this2.calSeverityLevel(item);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      return function (_x, _x2) {
        return _ref.apply(this, arguments);
      };
    }());
    var foundCannotGetResultFlag = this.sampleResultLines.find(function (item) {
      return item.cannot_get_result_flag == true;
    }); // this.isCannotGetResult = foundCannotGetResultFlag ? true : false;
    // SET AVAILABLE_CHECK_LIST_ITEMS 

    this.availableCheckListItems = this.getAvailableCheckListItems(this.checkListItems); // SET AVAILABLE_CHECK_LIST_TEST_ITEMS 

    this.availableCheckListTestItems = this.getAvailableCheckListTestItems(this.checkListTestItems);
  },
  methods: {
    getTestData: function getTestData(item) {
      var foundResultItem = this.resultItems.find(function (i) {
        return i.test_id == item.test_id;
      });
      var testData = {
        test_id: foundResultItem ? foundResultItem.test_id : "",
        test_code: foundResultItem ? foundResultItem.test_code : "",
        test_desc: foundResultItem ? foundResultItem.test_desc : "",
        test_unit: foundResultItem ? foundResultItem.test_unit : "",
        // optimal_value: foundResultItem ? this.getOptimalValue(this.specifications, foundResultItem) : "",
        optimal_value: foundResultItem ? foundResultItem.optimal_value : "",
        min_value: foundResultItem ? foundResultItem.min_value : "",
        max_value: foundResultItem ? foundResultItem.max_value : ""
      };
      return testData;
    },
    getUplodedImages: function getUplodedImages(item) {
      // REMINDER : PT_ATTACHMENTS.ATTRIBUTE2 == PTQM_RESULTS_V.RESULT_ID
      var uploadedImages = this.attachments.filter(function (i) {
        return i.attribute2 == item.result_id;
      });
      return uploadedImages;
    },
    getOptimalValue: function getOptimalValue(specifications, item) {
      var foundResultItem = specifications.find(function (spec) {
        return spec.spec_id == item.spec_id && spec.test_id == item.test_id;
      });
      var optimalValue = foundResultItem ? foundResultItem.optimal_value : "";
      return optimalValue;
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
    onResultValueChanged: function onResultValueChanged($event, sampleResult, sampleResultLine) {
      var _this3 = this;

      this.calResultStatus(sampleResultLine);
      this.calSeverityLevel(sampleResultLine); // this.calTestSeverityCode(sampleResultLine);

      if (sampleResultLine.result_value != "0") {
        sampleResult.issue_not_found = false;
      }

      sampleResult.show_input_issue_not_found = this.checkDisplayInputIssueNotFound(sampleResult, this.sampleResultLines); // AUTO SET RESULT_VALUE TO "SAME-ENTITY" RESULT LINE

      this.$nextTick(function () {
        var sameCheckListResultLines = _this3.sampleResultLines.filter(function (srl) {
          return srl.qm_process == sampleResultLine.qm_process && srl.check_list == sampleResultLine.check_list && srl.test_id != sampleResultLine.test_id;
        });

        sameCheckListResultLines.forEach( /*#__PURE__*/function () {
          var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(item, i) {
            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
              while (1) {
                switch (_context2.prev = _context2.next) {
                  case 0:
                    if (item.result_value === "" || item.result_value === null) {
                      item.result_value = "0";

                      _this3.calResultStatus(item);

                      _this3.calSeverityLevel(item);
                    }

                  case 1:
                  case "end":
                    return _context2.stop();
                }
              }
            }, _callee2);
          }));

          return function (_x3, _x4) {
            return _ref2.apply(this, arguments);
          };
        }());
      });
    },
    checkDisplayInputIssueNotFound: function checkDisplayInputIssueNotFound(sampleResult, sampleResultLines) {
      // let displayed = false;
      var displayed = true;
      var filteredSampleResultLines = sampleResultLines.filter(function (srl) {
        return sampleResult.qm_process == srl.qm_process;
      });
      var foundCannotGetResult = filteredSampleResultLines.find(function (fsrl) {
        return fsrl.cannot_get_result_flag == true;
      });

      if (foundCannotGetResult) {
        displayed = false;
      } // const foundEnterredResultValue = filteredSampleResultLines.find(fsrl => {
      //     return fsrl.result_value != null && fsrl.result_value != ""
      // });
      // if(!foundEnterredResultValue){
      //     displayed = true;
      // }


      return displayed;
    },
    checkIssueNotFoundValue: function checkIssueNotFoundValue(sampleResult, sampleResultLines) {
      var filteredSampleResultLines = sampleResultLines.filter(function (srl) {
        return srl.qm_process == sampleResult.qm_process;
      });
      var zeroValueSampleResultLines = filteredSampleResultLines.filter(function (fsrl) {
        return fsrl.result_value == "0";
      });
      var issueNotFound = filteredSampleResultLines.length == zeroValueSampleResultLines.length ? true : false;
      return issueNotFound;
    },
    calSeverityLevel: function calSeverityLevel(item) {
      var severityLevel = "";

      if (item.result_value) {
        severityLevel = "NONE";

        if (item.high_level_minor) {
          if (parseFloat(item.result_value) >= parseFloat(item.high_level_minor)) {
            severityLevel = "MINOR";
          }
        }

        if (item.high_level_major) {
          if (parseFloat(item.result_value) >= parseFloat(item.high_level_major)) {
            severityLevel = "MAJOR";
          }
        }

        if (item.high_level_critical) {
          if (parseFloat(item.result_value) >= parseFloat(item.high_level_critical)) {
            severityLevel = "CRITICAL";
          }
        }
      }

      item.severity_level = severityLevel;
      return severityLevel;
    },
    calResultStatus: function calResultStatus(item) {
      var resultStatus = "";

      if (item.selected_min_value && item.selected_max_value && item.result_value !== "" && item.result_value !== null) {
        if (parseFloat(item.result_value) >= parseFloat(item.selected_min_value) && parseFloat(item.result_value) <= parseFloat(item.selected_max_value)) {
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

      if (item.selected_min_value && item.selected_max_value && item.result_value !== "" && item.result_value !== null) {
        if (parseFloat(item.result_value) < parseFloat(item.selected_min_value)) {
          failedStatus = "UNDER";
        }

        if (parseFloat(item.result_value) > parseFloat(item.selected_max_value)) {
          failedStatus = "OVER";
        }
      }

      item.failed_status = failedStatus;
      return failedStatus;
    },
    // calTestSeverityCode(item) {
    //     const testItem = this.checkListTestItems.find((clt) => {
    //         return clt.check_list == item.check_list && clt.test_id == item.test_id;
    //     });
    //     const testServerityCode = testItem ? testItem.test_serverity_code.toUpperCase() : "";
    //     item.test_serverity_code = testServerityCode;
    //     return testServerityCode;
    // },
    // GET AVAILABLE_CHECK_LIST_ITEMS 
    getAvailableCheckListItems: function getAvailableCheckListItems(checkListItems) {
      var _this4 = this;

      // let availableItems = checkListItems;
      var availableItems = checkListItems.filter(function (item) {
        var foundSampleResultLine = _this4.sampleResultLines.find(function (srl) {
          return srl.qm_process == item.qm_process && srl.check_list == item.check_list && srl.optimal_result_flag == true;
        });

        return !foundSampleResultLine;
      });
      return availableItems;
    },
    // GET AVAILABLE_CHECK_LIST_TEST_ITEMS 
    getAvailableCheckListTestItems: function getAvailableCheckListTestItems(checkListTestItems) {
      var _this5 = this;

      // let availableItems = checkListTestItems;
      var availableItems = checkListTestItems.filter(function (item) {
        var foundSampleResultLine = _this5.sampleResultLines.find(function (srl) {
          return srl.qm_process == item.qm_process && srl.check_list == item.check_list && srl.optimal_result_flag == true;
        });

        return !foundSampleResultLine;
      });
      return availableItems;
    },
    onHeaderResultChanged: function onHeaderResultChanged(resultValue, sampleResultHeader) {
      sampleResultHeader.result_value = resultValue;
    },
    onIssueNotFouldCheckBoxChanged: function onIssueNotFouldCheckBoxChanged(value, sampleResult) {
      var _this6 = this;

      sampleResult.issue_not_found = value;

      if (value == true) {
        var filteredSampleResultLines = this.sampleResultLines.filter(function (srl) {
          return srl.qm_process == sampleResult.qm_process;
        });
        filteredSampleResultLines.forEach(function (item) {
          _this6.setOptimalResultLine(true, item);

          _this6.calResultStatus(item);

          _this6.calSeverityLevel(item); // this.calTestSeverityCode(item);

        });
      } // SET AVAILABLE_CHECK_LIST_ITEMS 


      this.availableCheckListItems = this.getAvailableCheckListItems(this.checkListItems); // SET AVAILABLE_CHECK_LIST_TEST_ITEMS 

      this.availableCheckListTestItems = this.getAvailableCheckListTestItems(this.checkListTestItems);
    },
    onOptimalResultCheckBoxChanged: function onOptimalResultCheckBoxChanged(value, sampleResultLine) {
      var _this7 = this;

      var optimalResultFlag = value;
      this.setOptimalResultLine(optimalResultFlag, sampleResultLine);
      var cannotGetResultFlag = null;
      var cannotGetResultReason = null;
      var resultValue = null;

      if (optimalResultFlag == true) {
        cannotGetResultFlag = false;
        cannotGetResultReason = "";
        resultValue = "0";
      } // AUTO SET OPTIMAL_RESULT_FLAG VALUE TO "SAME-ENTITY" RESULT LINE


      var sameCheckListResultLines = this.sampleResultLines.filter(function (srl) {
        return srl.qm_process == sampleResultLine.qm_process && srl.check_list == sampleResultLine.check_list;
      });
      sameCheckListResultLines.forEach( /*#__PURE__*/function () {
        var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(item, i) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
            while (1) {
              switch (_context3.prev = _context3.next) {
                case 0:
                  item.optimal_result_flag = optimalResultFlag;
                  item.cannot_get_result_flag = cannotGetResultFlag !== null ? cannotGetResultFlag : item.cannot_get_result_flag;
                  item.cannot_get_result_reason = cannotGetResultReason !== null ? cannotGetResultReason : item.cannot_get_result_reason;
                  item.result_value = resultValue !== null || resultValue !== '' ? resultValue : item.result_value;

                  _this7.calResultStatus(item);

                  _this7.calSeverityLevel(item); // this.calTestSeverityCode(item);


                case 6:
                case "end":
                  return _context3.stop();
              }
            }
          }, _callee3);
        }));

        return function (_x5, _x6) {
          return _ref3.apply(this, arguments);
        };
      }()); // SET AVAILABLE_CHECK_LIST_ITEMS 

      this.availableCheckListItems = this.getAvailableCheckListItems(this.checkListItems); // SET AVAILABLE_CHECK_LIST_TEST_ITEMS 

      this.availableCheckListTestItems = this.getAvailableCheckListTestItems(this.checkListTestItems);
    },
    setOptimalResultLine: function setOptimalResultLine(optimalResultFlag, sampleResultLine) {
      var cannotGetResultFlag = null;
      var cannotGetResultReason = null;
      var resultValue = null;

      if (optimalResultFlag == true) {
        cannotGetResultFlag = false;
        cannotGetResultReason = "";
        resultValue = "0";
      }

      sampleResultLine.optimal_result_flag = optimalResultFlag;
      sampleResultLine.cannot_get_result_flag = cannotGetResultFlag !== null ? cannotGetResultFlag : sampleResultLine.cannot_get_result_flag;
      sampleResultLine.cannot_get_result_reason = cannotGetResultReason !== null ? cannotGetResultReason : sampleResultLine.cannot_get_result_reason;
      sampleResultLine.result_value = resultValue !== null || resultValue !== '' ? resultValue : sampleResultLine.result_value;
      this.calResultStatus(sampleResultLine);
      this.calSeverityLevel(sampleResultLine);
    },
    onCannotGetResultCheckBoxChanged: function onCannotGetResultCheckBoxChanged(cannotGetResultFlag, sampleResult, sampleResultLine) {
      var _this8 = this;

      var cannotGetResultReason = null;
      var optimalResultFlag = null;
      var resultValue = null; // this.isCannotGetResult = cannotGetResultFlag;

      if (cannotGetResultFlag == true) {
        optimalResultFlag = false;
        resultValue = "0";
      } else {
        cannotGetResultReason = "";
      } // AUTO SET SAME QM_PROCESS


      var filteredSampleResultLines = this.sampleResultLines.filter(function (srl) {
        return srl.qm_process == sampleResultLine.qm_process;
      }); // this.sampleResultLines.forEach(async (item, i) => {

      filteredSampleResultLines.forEach( /*#__PURE__*/function () {
        var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(item, i) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
            while (1) {
              switch (_context4.prev = _context4.next) {
                case 0:
                  item.cannot_get_result_flag = cannotGetResultFlag;
                  item.cannot_get_result_reason = cannotGetResultReason !== null ? cannotGetResultReason : item.cannot_get_result_reason;
                  item.optimal_result_flag = optimalResultFlag !== null ? optimalResultFlag : item.optimal_result_flag;
                  item.result_value = resultValue !== null || resultValue !== '' ? resultValue : item.result_value;

                  _this8.calResultStatus(item);

                  _this8.calSeverityLevel(item); // this.calTestSeverityCode(item);


                case 6:
                case "end":
                  return _context4.stop();
              }
            }
          }, _callee4);
        }));

        return function (_x7, _x8) {
          return _ref4.apply(this, arguments);
        };
      }());
      sampleResult.show_input_issue_not_found = this.checkDisplayInputIssueNotFound(sampleResult, filteredSampleResultLines);
    },
    onCannotGetResultReasonChanged: function onCannotGetResultReasonChanged(e, sampleResultLine) {
      var cannotGetResultReason = sampleResultLine.cannot_get_result_reason; // AUTO SET SAME QM_PROCESS

      var filteredSampleResultLines = this.sampleResultLines.filter(function (srl) {
        return srl.qm_process == sampleResultLine.qm_process;
      }); // this.sampleResultLines.forEach(async (item, i) => {

      filteredSampleResultLines.forEach( /*#__PURE__*/function () {
        var _ref5 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(item, i) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
            while (1) {
              switch (_context5.prev = _context5.next) {
                case 0:
                  item.cannot_get_result_reason = cannotGetResultReason;

                case 1:
                case "end":
                  return _context5.stop();
              }
            }
          }, _callee5);
        }));

        return function (_x9, _x10) {
          return _ref5.apply(this, arguments);
        };
      }());
    },
    onSelectedCheckListItem: function onSelectedCheckListItem(selectedCheckList, sampleResultLine) {
      // const checkListItem = this.checkListItems.find((cl) => {
      //     return cl.qm_process == sampleResultLine.qm_process && cl.check_list == selectedCheckList;
      // });
      sampleResultLine.check_list = selectedCheckList;
      var defaultTestItem = this.checkListTestItems.find(function (clt) {
        return clt.qm_process == sampleResultLine.qm_process && clt.check_list == selectedCheckList;
      });
      this.onSelectedCheckListTestItem(defaultTestItem.test_id, sampleResultLine);
    },
    onSelectedCheckListTestItem: function onSelectedCheckListTestItem(selectedTestId, sampleResultLine) {
      var testItem = this.checkListTestItems.find(function (clt) {
        return clt.check_list == sampleResultLine.check_list && clt.test_id == selectedTestId;
      });
      sampleResultLine.result_id = testItem.result_id;
      sampleResultLine.result_line_id = testItem.result_line_id;
      sampleResultLine.selected_test_id = testItem.test_id;
      sampleResultLine.selected_test_code = testItem.test_code;
      sampleResultLine.selected_test_desc = testItem.test_desc; // sampleResultLine.selected_optimal_value = this.getOptimalValue(this.specifications, testItem);

      sampleResultLine.selected_optimal_value = testItem.optimal_value;
      sampleResultLine.selected_min_value = testItem.min_value;
      sampleResultLine.selected_max_value = testItem.max_value;
      sampleResultLine.test_serverity_code = testItem.test_serverity_code ? testItem.test_serverity_code.toUpperCase() : "";
      ;
      this.calResultStatus(sampleResultLine);
      this.calSeverityLevel(sampleResultLine); // this.calTestSeverityCode(sampleResultLine);
    },
    onSelectedTestServerityCode: function onSelectedTestServerityCode(value, sampleResultLine) {
      // UPDATE TEST_SERVERITY_CODE VALUE
      sampleResultLine.test_serverity_code = value;
    },
    onAddNewResultLine: function onAddNewResultLine(sampleResult) {
      sampleResult.issue_not_found = false;

      var cloneSampleResultLine = _objectSpread({}, this.sampleResultLines.find(function (srl) {
        return srl.qm_process == sampleResult.qm_process;
      }));

      var defaultCheckListItem = this.availableCheckListItems.find(function (cl) {
        return cl.qm_process == sampleResult.qm_process;
      });
      cloneSampleResultLine.check_list = defaultCheckListItem ? defaultCheckListItem.check_list : null;
      cloneSampleResultLine.check_list_code = defaultCheckListItem ? defaultCheckListItem.check_list_code : null;
      cloneSampleResultLine.additional_line_flag = "Y";
      cloneSampleResultLine.result_value = "";
      cloneSampleResultLine.result_status = null;
      cloneSampleResultLine.severity_level = "";
      cloneSampleResultLine.test_serverity_code = "";
      cloneSampleResultLine.optimal_result_flag = false;
      cloneSampleResultLine.cannot_get_result_flag = false;
      cloneSampleResultLine.cannot_get_result_reason = "";
      cloneSampleResultLine.uploadedImages = [];
      cloneSampleResultLine.images = [];
      var defaultTestItem = this.availableCheckListTestItems.find(function (clt) {
        return clt.qm_process == sampleResult.qm_process && clt.check_list == cloneSampleResultLine.check_list && clt.test_id != cloneSampleResultLine.selected_test_id;
      });
      cloneSampleResultLine.result_id = defaultTestItem ? defaultTestItem.result_id : null;
      cloneSampleResultLine.result_line_id = defaultTestItem ? defaultTestItem.result_line_id : null;
      cloneSampleResultLine.selected_test_id = defaultTestItem ? defaultTestItem.test_id : null;
      cloneSampleResultLine.selected_test_code = defaultTestItem ? defaultTestItem.test_code : null;
      cloneSampleResultLine.selected_test_desc = defaultTestItem ? defaultTestItem.test_desc : null;
      cloneSampleResultLine.selected_test_unit = defaultTestItem ? defaultTestItem.test_unit : null;
      cloneSampleResultLine.selected_test_unit_desc = defaultTestItem ? defaultTestItem.test_unit_desc : null; // cloneSampleResultLine.selected_optimal_value = defaultTestItem ? this.getOptimalValue(this.specifications, defaultTestItem) : null;

      cloneSampleResultLine.selected_optimal_value = defaultTestItem ? defaultTestItem.optimal_value : null;
      cloneSampleResultLine.selected_min_value = defaultTestItem ? defaultTestItem.min_value : null;
      cloneSampleResultLine.selected_max_value = defaultTestItem ? defaultTestItem.max_value : null;
      this.sampleResultLines.push(cloneSampleResultLine);
    },
    onRemoveResultLine: function onRemoveResultLine(sampleResultLine) {
      var sampleResultLineIndex = this.sampleResultLines.findIndex(function (item) {
        return item == sampleResultLine;
      });

      if (sampleResultLineIndex > 0) {
        this.sampleResultLines.splice(sampleResultLineIndex, 1);
      }
    },
    validateBeforeChooseImages: function validateBeforeChooseImages(sampleResultLine, index, lineIndex) {
      var _this9 = this;

      var refName = "finished_products_result_quality_line_image_".concat(index, "_").concat(lineIndex);

      if (sampleResultLine.result_status == "PASSED") {
        swal({
          title: "",
          text: "ค่าที่ตรวจสอบอยู่ในเกณฑ์มาตรฐาน ต้องการที่จะแนบรูปภาพใช่หรือไม่ ?",
          showCancelButton: true,
          confirmButtonClass: "btn-primary",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ยกเลิก",
          closeOnConfirm: true
        }, function (isConfirm) {
          if (isConfirm) {
            _this9.$refs[refName][0].click();
          }
        });
      } else {
        this.$refs[refName][0].click();
      }
    },
    validateImages: function validateImages(event, sampleResultLine) {
      // const uploadMaxFiles = this.defaultData.upload_max_files;
      var uploadMaxFiles = 1;
      var uploadMaxFileSizeMB = this.defaultData.upload_max_file_size;
      var uploadMaxFileSize = uploadMaxFileSizeMB * 1024 * 1024;

      var files = _toConsumableArray(event.target.files); // VALIDATE FILE SIZE


      var validSizeFiles = files.filter(function (file) {
        return file.size < uploadMaxFileSize;
      });

      if (validSizeFiles.length < files.length) {
        swal("Error", "\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E41\u0E19\u0E1A\u0E23\u0E39\u0E1B \u0E44\u0E14\u0E49\u0E02\u0E19\u0E32\u0E14\u0E44\u0E21\u0E48\u0E40\u0E01\u0E34\u0E19 ".concat(uploadMaxFileSizeMB, " MB, \u0E01\u0E23\u0E38\u0E13\u0E32\u0E2D\u0E31\u0E1E\u0E42\u0E2B\u0E25\u0E14\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07"), "error");
      } else {
        // VALIDATE MAX FILES
        if (files.length > uploadMaxFiles) {
          swal("Error", "\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E41\u0E19\u0E1A\u0E23\u0E39\u0E1B \u0E44\u0E14\u0E49\u0E44\u0E21\u0E48\u0E40\u0E01\u0E34\u0E19 ".concat(uploadMaxFiles, " \u0E23\u0E39\u0E1B"), "error");
          sampleResultLine.images = files.slice(0, uploadMaxFiles);
        } else {
          sampleResultLine.images = files;
        }
      }
    },
    onDeleteResultLineImage: function onDeleteResultLineImage(sampleResultLine, imageIndex) {
      sampleResultLine.images.splice(imageIndex, 1);
    },
    onSubmitSampleResult: function onSubmitSampleResult(event) {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var vm, resValidate, reqData, allSampleResults, resultQualityLines, resStoreSampleResultStatus, resSampleDisposition, resSampleDispositionDesc, resSampleOperationStatus, resSampleOperationStatusDesc, resSampleResultStatus, resSampleResultStatusDesc, resSampleSeverityLevelMinor, resSampleSeverityLevelMajor, resSampleSeverityLevelCritical, resSampleTestServerityCodeMinor, resSampleTestServerityCodeMajor, resSampleTestServerityCodeCritical, resSampleResultTestTime;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                vm = _this10; // VALIDATE BEFORE SUBMIT RESULT

                resValidate = _this10.validateBeforeSave(_this10.sampleData, _this10.sampleResultHeaders, _this10.sampleResultLines);

                if (!resValidate.valid) {
                  _context6.next = 51;
                  break;
                }

                reqData = new FormData();
                reqData.append('organization_code', _this10.sampleData.organization_code ? _this10.sampleData.organization_code : "");
                reqData.append('oracle_sample_id', _this10.sampleData.oracle_sample_id ? _this10.sampleData.oracle_sample_id : "");
                reqData.append('sample_no', _this10.sampleData.sample_no ? _this10.sampleData.sample_no : "");
                reqData.append('sample_desc', _this10.sampleData.sample_desc ? _this10.sampleData.sample_desc : "");
                reqData.append('inventory_item_id', _this10.sampleData.inventory_item_id ? _this10.sampleData.inventory_item_id : "");
                reqData.append('item_number', _this10.sampleData.item_number ? _this10.sampleData.item_number : "");
                reqData.append('item_desc', _this10.sampleData.item_desc ? _this10.sampleData.item_desc : "");
                reqData.append('date_drawn', _this10.sampleData.date_drawn ? _this10.sampleData.date_drawn : "");
                reqData.append('sample_disposition', _this10.sampleData.sample_disposition ? _this10.sampleData.sample_disposition : "");
                reqData.append('sample_disposition_desc', _this10.sampleData.sample_disposition_desc ? _this10.sampleData.sample_disposition_desc : "");
                reqData.append('sample_operation_status', _this10.sampleData.sample_operation_status ? _this10.sampleData.sample_operation_status : "");
                reqData.append('sample_result_status', _this10.sampleData.sample_result_status ? _this10.sampleData.sample_result_status : "");
                reqData.append('sample_id', _this10.sampleData.sample_id ? _this10.sampleData.sample_id : "");
                reqData.append('department_code', _this10.sampleData.department_code ? _this10.sampleData.department_code : "");
                reqData.append('qm_group', _this10.sampleData.qm_group ? _this10.sampleData.qm_group : "");
                reqData.append('organization_id', _this10.sampleData.organization_id ? _this10.sampleData.organization_id : "");
                reqData.append('subinventory_code', _this10.sampleData.subinventory_code ? _this10.sampleData.subinventory_code : "");
                reqData.append('locator_id', _this10.sampleData.locator_id ? _this10.sampleData.locator_id : "");
                reqData.append('sample_date', _this10.sampleData.sample_date ? _this10.sampleData.sample_date : "");
                reqData.append('batch_id', _this10.sampleData.batch_id ? _this10.sampleData.batch_id : "");
                reqData.append('qc_area', _this10.sampleData.qc_area ? _this10.sampleData.qc_area : "");
                reqData.append('machine_set', _this10.sampleData.machine_set ? _this10.sampleData.machine_set : "");
                reqData.append('program_code', _this10.sampleData.program_code ? _this10.sampleData.program_code : "");
                allSampleResults = [].concat(_toConsumableArray(_this10.sampleResultHeaders), _toConsumableArray(_this10.sampleResultLines)); // const resultQualityLines = this.sampleResultLines.map((item, srlIndex) => {

                resultQualityLines = allSampleResults.map(function (item, srlIndex) {
                  var result = {
                    result_id: item.result_id,
                    qm_process: item.qm_process,
                    check_list: item.check_list,
                    check_list_code: item.check_list_code,
                    test_id: item.selected_test_id,
                    test_code: item.selected_test_code,
                    test_desc: item.selected_test_desc,
                    optimal_value: item.selected_optimal_value,
                    min_value: item.selected_min_value,
                    max_value: item.selected_max_value,
                    result_status: item.result_status,
                    result_value: item.result_value,
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : "",
                    cannot_get_result_flag: item.cannot_get_result_flag == true ? "Y" : "N",
                    cannot_get_result_reason: item.cannot_get_result_reason ? item.cannot_get_result_reason : "",
                    optimal_result_flag: item.optimal_result_flag == true ? "Y" : "N",
                    test_serverity_code: item.test_serverity_code ? item.test_serverity_code : "",
                    show_header_flag: item.show_header_flag,
                    additional_line_flag: item.additional_line_flag ? item.additional_line_flag : null,
                    images: ""
                  };

                  if (item.images.length > 0) {
                    result.images = item.images.map(function (image, imgIndex) {
                      reqData.append("image_".concat(srlIndex, "_").concat(imgIndex), image);
                      return "image_".concat(srlIndex, "_").concat(imgIndex);
                    });
                  }

                  return result;
                });
                reqData.append('result_quality_lines', JSON.stringify(resultQualityLines)); // SHOW LOADING

                _this10.isLoading = true; // CALL STORE SAMPLE RESULT

                resStoreSampleResultStatus = "success";
                resSampleDisposition = _this10.sampleData.sample_disposition;
                resSampleDispositionDesc = _this10.sampleData.sample_disposition_desc;
                resSampleOperationStatus = _this10.sampleData.sample_operation_status;
                resSampleOperationStatusDesc = _this10.sampleData.sample_operation_status_desc;
                resSampleResultStatus = _this10.sampleData.sample_result_status;
                resSampleResultStatusDesc = _this10.sampleData.sample_result_status_desc;
                resSampleSeverityLevelMinor = _this10.sampleData.severity_level_minor;
                resSampleSeverityLevelMajor = _this10.sampleData.severity_level_major;
                resSampleSeverityLevelCritical = _this10.sampleData.severity_level_critical;
                resSampleTestServerityCodeMinor = _this10.sampleData.test_serverity_code_minor;
                resSampleTestServerityCodeMajor = _this10.sampleData.test_serverity_code_major;
                resSampleTestServerityCodeCritical = _this10.sampleData.test_serverity_code_critical;
                resSampleResultTestTime = _this10.sampleData.sample_result_test_time;
                _context6.next = 47;
                return axios.post("/qm/ajax/finished-products/result", reqData).then(function (res) {
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
                    resSampleTestServerityCodeMinor = resSample.test_serverity_code_minor;
                    resSampleTestServerityCodeMajor = resSample.test_serverity_code_major;
                    resSampleTestServerityCodeCritical = resSample.test_serverity_code_critical;
                    resSampleResultTestTime = resSample.sample_result_test_time;
                  }

                  if (resData.status == "success") {
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E04\u0E38\u0E13\u0E20\u0E32\u0E1E\u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E04\u0E38\u0E13\u0E20\u0E32\u0E1E\u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E25\u0E07\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E04\u0E38\u0E13\u0E20\u0E32\u0E1E\u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(_this10.sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 47:
                // HIDE LOADING
                _this10.isLoading = false; // emit sample result sumitted

                _this10.$emit("onSampleResultSubmitted", {
                  status: resStoreSampleResultStatus,
                  sample_no: _this10.sampleData.sample_no,
                  sample_disposition: resSampleDisposition,
                  sample_disposition_desc: resSampleDispositionDesc,
                  sample_operation_status: resSampleOperationStatus,
                  sample_operation_status_desc: resSampleOperationStatusDesc,
                  sample_result_status: resSampleResultStatus,
                  sample_result_status_desc: resSampleResultStatusDesc,
                  severity_level_minor: resSampleSeverityLevelMinor,
                  severity_level_major: resSampleSeverityLevelMajor,
                  severity_level_critical: resSampleSeverityLevelCritical,
                  test_serverity_code_minor: resSampleTestServerityCodeMinor,
                  test_serverity_code_major: resSampleTestServerityCodeMajor,
                  test_serverity_code_critical: resSampleTestServerityCodeCritical,
                  sample_result_test_time: resSampleResultTestTime
                });

                _context6.next = 52;
                break;

              case 51:
                swal("เกิดข้อผิดพลาด", "".concat(resValidate.message), "error");

              case 52:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    validateBeforeSave: function validateBeforeSave(sampleData, sampleResultHeaders, sampleResultLines) {
      var result = {
        valid: true,
        message: ""
      }; // ####################################################
      // ## VALIDATION OF SAMPLE_RESULT_HEADERS INCOMPLETED
      // HEADER : BRAND

      var sampleResultHeaderBrand = sampleResultHeaders.find(function (item) {
        return item.brand_flag == 'Y';
      });

      if (sampleResultHeaderBrand) {
        if (!sampleResultHeaderBrand.result_value) {
          result.valid = false;
          result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"".concat(sampleResultHeaderBrand.selected_test_desc, "\"");
          return result;
        }
      } // HEADER : TEST_TIME


      var sampleResultHeaderTestTime = sampleResultHeaders.find(function (item) {
        return item.test.time_flag == 'Y';
      });

      if (sampleResultHeaderTestTime) {
        if (!sampleResultHeaderTestTime.result_value) {
          result.valid = false;
          result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"".concat(sampleResultHeaderTestTime.selected_test_desc, "\"");
          return result;
        } else {
          if (!moment__WEBPACK_IMPORTED_MODULE_4___default()(sampleResultHeaderTestTime.result_value, "HH:mm", true).isValid()) {
            result.valid = false;
            result.message = "\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"".concat(sampleResultHeaderTestTime.selected_test_desc, "\" \u0E44\u0E21\u0E48\u0E16\u0E39\u0E01\u0E15\u0E49\u0E2D\u0E07 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A");
            return result;
          }
        }
      } // ####################################################
      // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE INCOMPLETED


      var incompletedResultValueLines = sampleResultLines.filter(function (item) {
        return !item.check_list || !item.test_id || item.result_value === "" || item.result_value === null;
      });

      if (incompletedResultValueLines.length > 0) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\" \u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19";
        return result;
      } else {
        // IF THERE SAMPLE_RESULT_LINES : RESULT_VALUE == 0 BUT OPTIMAL_FLAG IS NOT CHECKED
        var invalidOptimalResultValueLines = sampleResultLines.filter(function (item) {
          return parseInt(item.result_value) === 0 && item.optimal_result_flag === false;
        });

        if (invalidOptimalResultValueLines.length > 0) {
          result.valid = false;
          result.message = "\u0E1C\u0E25\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A \"".concat(invalidOptimalResultValueLines[0].qm_process, " : ").concat(invalidOptimalResultValueLines[0].check_list, " : ").concat(invalidOptimalResultValueLines[0].selected_test_desc, "\" \u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E1A\u0E01\u0E1E\u0E23\u0E48\u0E2D\u0E07\u0E40\u0E1B\u0E47\u0E19 0, \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E34\u0E4A\u0E01 Check Box \"\u0E1C\u0E25\u0E1B\u0E01\u0E15\u0E34\" \u0E01\u0E48\u0E2D\u0E19\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25");
          return result;
        }
      } // IF THERE SAMPLE_RESULT_LINES : CANNOT_GET_RESULT_FLAG & CANNOT_GET_RESULT_REASON INCOMPLETED


      var incompletedCannotGetResultLines = sampleResultLines.filter(function (item) {
        return item.cannot_get_result_flag == true && !item.cannot_get_result_reason;
      }); // IF THERE DUPPLICATE TEST_ID

      var sampleResultLineTestIds = sampleResultLines.map(function (item) {
        return item.selected_test_id;
      });
      var dupplicateResultLineTestIds = sampleResultLineTestIds.filter(function (item, index) {
        return index !== sampleResultLineTestIds.indexOf(item);
      });

      if (incompletedCannotGetResultLines.length > 0) {
        result.valid = false;
        result.message = "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E01\u0E23\u0E2D\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E40\u0E2B\u0E15\u0E38\u0E1C\u0E25\u0E17\u0E35\u0E48\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E40\u0E01\u0E47\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E14\u0E49\" \u0E43\u0E2B\u0E49\u0E04\u0E23\u0E1A\u0E16\u0E49\u0E27\u0E19";
        return result;
      }

      if (dupplicateResultLineTestIds.length > 0) {
        result.valid = false;
        result.message = "\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \"\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A/\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\" \u0E0B\u0E49\u0E33 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07";
        return result;
      }

      return result;
    },
    onSubmitCauseOfDefect: function onSubmitCauseOfDefect(event) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm, reqData, allSampleResults, resultQualityLines, resStoreCauseOfDefectStatus;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this11;
                reqData = new FormData();
                reqData.append('organization_code', _this11.sampleData.organization_code ? _this11.sampleData.organization_code : "");
                reqData.append('oracle_sample_id', _this11.sampleData.oracle_sample_id ? _this11.sampleData.oracle_sample_id : "");
                reqData.append('sample_no', _this11.sampleData.sample_no ? _this11.sampleData.sample_no : "");
                allSampleResults = [].concat(_toConsumableArray(_this11.sampleResultHeaders), _toConsumableArray(_this11.sampleResultLines)); // const resultQualityLines = this.sampleResultLines.map((item, srlIndex) => {

                resultQualityLines = allSampleResults.map(function (item, srlIndex) {
                  var result = {
                    result_id: item.result_id,
                    test_id: item.selected_test_id,
                    test_code: item.selected_test_code,
                    test_desc: item.selected_test_desc,
                    optimal_value: item.selected_optimal_value,
                    cause_of_defect: item.cause_of_defect ? item.cause_of_defect : ""
                  };
                  return result;
                });
                reqData.append('result_quality_lines', JSON.stringify(resultQualityLines)); // SHOW LOADING

                _this11.isLoading = true; // call store cause of defect

                resStoreCauseOfDefectStatus = "success";
                _context7.next = 12;
                return axios.post("/qm/ajax/finished-products/defect", reqData).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  resStoreCauseOfDefectStatus = resData.status;

                  if (resData.status == "success") {
                    swal("Success", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E32\u0E40\u0E2B\u0E15\u0E38\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, " )"), "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E32\u0E40\u0E2B\u0E15\u0E38\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(vm.sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreCauseOfDefectStatus = "error";
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E2A\u0E32\u0E40\u0E2B\u0E15\u0E38\u0E04\u0E27\u0E32\u0E21\u0E1C\u0E34\u0E14\u0E1B\u0E01\u0E15\u0E34\u0E01\u0E25\u0E38\u0E48\u0E21\u0E1C\u0E25\u0E34\u0E15\u0E20\u0E31\u0E13\u0E11\u0E4C\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08\u0E23\u0E39\u0E1B (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(_this11.sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 12:
                // HIDE LOADING
                _this11.isLoading = false; // emit cause of defect sumitted
                // this.$emit("onCauseOfDefectSubmitted", {
                //     status: resStoreCauseOfDefectStatus,
                //     sample_no: this.sampleData.sample_no,
                // });

              case 13:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    onDeleteResultLineUplodedImage: function onDeleteResultLineUplodedImage(sampleResultLine, imageIndex) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var uploadedImage;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                uploadedImage = _objectSpread({}, sampleResultLine.uploadedImages[imageIndex]);
                swal({
                  title: "",
                  text: "ต้องการที่จะลบรูปภาพใช่หรือไม่ ?",
                  showCancelButton: true,
                  confirmButtonClass: "btn-primary",
                  confirmButtonText: "ยืนยัน",
                  cancelButtonText: "ยกเลิก",
                  closeOnConfirm: true
                }, /*#__PURE__*/function () {
                  var _ref6 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8(isConfirm) {
                    var responseResult;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
                      while (1) {
                        switch (_context8.prev = _context8.next) {
                          case 0:
                            if (!isConfirm) {
                              _context8.next = 5;
                              break;
                            }

                            _context8.next = 3;
                            return _this12.deleteResultLineUplodedImage(sampleResultLine, uploadedImage);

                          case 3:
                            responseResult = _context8.sent;

                            if (responseResult.status == "success") {
                              sampleResultLine.uploadedImages.splice(imageIndex, 1);
                            }

                          case 5:
                          case "end":
                            return _context8.stop();
                        }
                      }
                    }, _callee8);
                  }));

                  return function (_x11) {
                    return _ref6.apply(this, arguments);
                  };
                }());

              case 2:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    deleteResultLineUplodedImage: function deleteResultLineUplodedImage(sampleResultLine, uploadedImage) {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var reqBody, responseResult;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                reqBody = {
                  sample_result_line: JSON.stringify(sampleResultLine),
                  uploaded_image: JSON.stringify(uploadedImage)
                }; // SHOW LOADING

                _this13.isLoading = true;
                _context10.next = 4;
                return axios.post("/qm/ajax/finished-products/delete-result-quality-line-image", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    swal("Success", "\u0E25\u0E1A\u0E23\u0E39\u0E1B\u0E20\u0E32\u0E1E: ".concat(uploadedImage.attribute1), "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 \u0E25\u0E1A\u0E23\u0E39\u0E1B\u0E20\u0E32\u0E1E: ".concat(uploadedImage.attribute1, " | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 \u0E25\u0E1A\u0E23\u0E39\u0E1B\u0E20\u0E32\u0E1E: ".concat(uploadedImage.attribute1, " | ").concat(error.message), "error");
                });

              case 4:
                responseResult = _context10.sent;
                // HIDE LOADING
                _this13.isLoading = false;
                return _context10.abrupt("return", responseResult);

              case 7:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    onCancelSampleResult: function onCancelSampleResult(e) {
      // emit sample result sumitted
      this.$emit("onCancelSampleResult", e);
    },
    // onShowModalSampleResultLineImages(sampleResultLine) {
    //     this.showedModalSampleResultLine = sampleResultLine;
    //     window.scrollTo(0,150);
    //     this.$modal.show('modal-show-result-line-images');
    // },
    onShowModalTestImages: function onShowModalTestImages(sampleResultLine) {
      this.showedModalTestId = sampleResultLine.selected_test_id;
      window.scrollTo(0, 150);
      this.$modal.show('modal-show-test-images');
    },
    onModalTestImageClosed: function onModalTestImageClosed() {
      window.scrollTo(0, 800);
    },
    onModalResultLineImageChanged: function onModalResultLineImageChanged(data) {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var changedSampleResultLine;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                changedSampleResultLine = data.sampleResultLine;
                _this14.sampleResultLines = _this14.sampleResultLines.map(function (item) {
                  var sampleResultLineUploadedImages = [];

                  if (changedSampleResultLine.result_line_id == item.result_line_id && changedSampleResultLine.selected_test_id == item.selected_test_id) {
                    sampleResultLineUploadedImages = changedSampleResultLine.uploadedImages;
                  } else {
                    sampleResultLineUploadedImages = item.uploadedImages;
                  }

                  return _objectSpread(_objectSpread({}, item), {}, {
                    uploadedImages: sampleResultLineUploadedImages
                  });
                });

              case 2:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".v--modal-overlay[data-v-1e097c48] {\n  z-index: 2000;\n  padding-top: 3rem;\n  padding-bottom: 3rem;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_style_index_0_id_1e097c48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_style_index_0_id_1e097c48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_style_index_0_id_1e097c48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/ModalShowTestImages.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalShowTestImages_vue_vue_type_template_id_1e097c48_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true& */ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true&");
/* harmony import */ var _ModalShowTestImages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalShowTestImages.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalShowTestImages_vue_vue_type_style_index_0_id_1e097c48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css& */ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalShowTestImages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalShowTestImages_vue_vue_type_template_id_1e097c48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalShowTestImages_vue_vue_type_template_id_1e097c48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "1e097c48",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/finished-products/ModalShowTestImages.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProductResults.vue":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProductResults.vue ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableFinishedProductResults_vue_vue_type_template_id_355d9b62___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableFinishedProductResults.vue?vue&type=template&id=355d9b62& */ "./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=template&id=355d9b62&");
/* harmony import */ var _TableFinishedProductResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableFinishedProductResults.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableFinishedProductResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableFinishedProductResults_vue_vue_type_template_id_355d9b62___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableFinishedProductResults_vue_vue_type_template_id_355d9b62___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/finished-products/TableFinishedProductResults.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalShowTestImages.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableFinishedProductResults.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductResults_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css&":
/*!***************************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_style_index_0_id_1e097c48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=style&index=0&id=1e097c48&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_template_id_1e097c48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_template_id_1e097c48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalShowTestImages_vue_vue_type_template_id_1e097c48_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true&");


/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=template&id=355d9b62&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=template&id=355d9b62& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductResults_vue_vue_type_template_id_355d9b62___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductResults_vue_vue_type_template_id_355d9b62___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProductResults_vue_vue_type_template_id_355d9b62___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableFinishedProductResults.vue?vue&type=template&id=355d9b62& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=template&id=355d9b62&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/ModalShowTestImages.vue?vue&type=template&id=1e097c48&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
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
            shiftX: 0.45,
            shiftY: 0.3
          },
          on: { "before-close": _vm.onModalClosed }
        },
        [
          _c("div", { staticClass: "p-4 text-left" }, [
            _c("h3", { staticClass: "text-left" }, [_vm._v(" ดูแนบรูปภาพ ")]),
            _vm._v(" "),
            _c("hr", { staticClass: "tw-mt-1" }),
            _vm._v(" "),
            _vm.testData && _vm.testData.test_attachments.length > 0
              ? _c(
                  "div",
                  { staticStyle: { "min-height": "300px" } },
                  _vm._l(_vm.testData.test_attachments, function(
                    testAttachment,
                    i
                  ) {
                    return _c(
                      "div",
                      {
                        key: i,
                        staticClass: "tw-py-2",
                        staticStyle: { "border-bottom": "1px solid #f0f0f0" }
                      },
                      [
                        testAttachment.attachment_id
                          ? _c(
                              "a",
                              {
                                staticClass:
                                  "btn btn-xs btn-outline tw-w-full tw-bg-opacity-20 tw-bg-purple-200 tw-border-purple-400 hover:tw-bg-purple-200 hover:tw-border-purple-400 tw-py-2 tw-px-5 text-left tw-font-bold tw-text-purple-600",
                                attrs: {
                                  href:
                                    "/qm/settings/attachments/" +
                                    testAttachment.attachment_id +
                                    "/" +
                                    _vm.testData.test_type_code +
                                    "/imageDefineTests",
                                  target: "_blank"
                                }
                              },
                              [
                                _c("span", {
                                  staticClass: "fa fa-picture-o tw-mr-1"
                                }),
                                _vm._v(
                                  " " +
                                    _vm._s(testAttachment.file_name) +
                                    "\n                    "
                                )
                              ]
                            )
                          : _vm._e()
                      ]
                    )
                  }),
                  0
                )
              : _c("div", [
                  _c("h2", { staticClass: "p-5 text-center text-muted" }, [
                    _vm._v(" ไม่พบข้อมูล ")
                  ])
                ]),
            _vm._v(" "),
            _c("hr", { staticClass: "tw-mt-1" }),
            _vm._v(" "),
            _c("div", { staticClass: "text-right" }, [
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
                [_vm._v(" \n                    ปิด \n                ")]
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=template&id=355d9b62&":
/*!************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProductResults.vue?vue&type=template&id=355d9b62& ***!
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
    { staticClass: "tw-ml-5 tw-mr-20 tw-py-2" },
    [
      _c("table", { staticClass: "table table-borderless-horizontal mb-0" }, [
        _c("thead", [
          _c("tr", { staticClass: "tw-bg-opacity-40 tw-bg-blue-100" }, [
            _c(
              "th",
              {
                staticClass: "tw-text-gray-600",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "2%" }
              },
              [_vm._v("\n                    กระบวนการ\n                ")]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "10%" }
              },
              [_vm._v("\n                    รายการตรวจสอบ\n                ")]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass: "tw-text-gray-600",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "15%" }
              },
              [
                _vm._v(
                  "\n                    ข้อมูลการตรวจสอบ/ความผิดปกติ\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { colspan: "2", width: "12%" }
              },
              [
                _vm._v(
                  "\n                    จำนวนที่พบ/ผลการตรวจสอบ\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "10%" }
              },
              [_vm._v("\n                    สาเหตุ\n                ")]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "5%" }
              },
              [
                _vm._v(
                  "\n                    อยู่ในช่วงควบคุม\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "4%" }
              },
              [_vm._v("\n                    ผลปกติ\n                ")]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "4%" }
              },
              [
                _vm._v(
                  "\n                    ไม่สามารถลงผลการตรวจสอบได้\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "10%" }
              },
              [
                _vm._v(
                  "\n                    เหตุผลที่ไม่สามารถเก็บข้อมูลได้\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c("th", {
              staticClass:
                "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
              staticStyle: { "z-index": "auto" },
              attrs: { width: "4%" }
            }),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "6%" }
              },
              [
                _vm._v(
                  "\n                    ระดับความรุนแรงของความผิดปกติ (จำนวน)\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto" },
                attrs: { width: "6%" }
              },
              [
                _vm._v(
                  "\n                    ระดับความรุนแรงของความผิดปกติ (อาการ)\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto", "min-width": "160px" },
                attrs: { width: "7%" }
              },
              [
                _vm.showType != "result"
                  ? _c("span", [_vm._v(" รูปภาพ ")])
                  : _vm._e()
              ]
            ),
            _vm._v(" "),
            _vm.showType == "result"
              ? _c(
                  "th",
                  {
                    staticClass:
                      "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                    staticStyle: { "z-index": "auto", "min-width": "100px" },
                    attrs: { width: "7%" }
                  },
                  [_vm._v("\n                    แนบรูปภาพ\n                ")]
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "th",
              {
                staticClass:
                  "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                staticStyle: { "z-index": "auto", "min-width": "100px" },
                attrs: { width: "7%" }
              },
              [_vm._v("\n                    รูปภาพตัวอย่าง\n                ")]
            ),
            _vm._v(" "),
            _vm.showType == "defect"
              ? _c(
                  "th",
                  {
                    staticClass:
                      "tw-text-gray-600 text-center tw-text-xs md:tw-table-cell tw-hidden",
                    staticStyle: { "z-index": "auto", "min-width": "200px" },
                    attrs: { width: "10%" }
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
                _vm._m(0),
                _vm._v(" "),
                _vm._l(_vm.sampleResultHeaders, function(
                  sampleResultHeader,
                  indexH
                ) {
                  return _c("tr", { key: "header_" + indexH }, [
                    _c("td", {
                      staticClass:
                        "tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"
                    }),
                    _vm._v(" "),
                    _c("td", { staticClass: "tw-text-xs" }),
                    _vm._v(" "),
                    _c("td", { staticClass: "tw-text-xs" }, [
                      _c("div", { staticClass: "tw-py-2" }, [
                        _vm._v(
                          "\n                        " +
                            _vm._s(sampleResultHeader.selected_test_desc) +
                            "\n                        "
                        ),
                        _c("span", { staticClass: "tw-text-red-600" }, [
                          _vm._v(" * ")
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "2" } }, [
                      _vm.showType == "result" &&
                      sampleResultHeader.read_only != "Y" &&
                      _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                        ? _c(
                            "div",
                            [
                              sampleResultHeader.brand_flag == "Y"
                                ? [
                                    _c(
                                      "div",
                                      { staticClass: "qm-el-select-required" },
                                      [
                                        _c("qm-el-select", {
                                          attrs: {
                                            id:
                                              "input_header_result_value_" +
                                              indexH,
                                            name:
                                              "header_result_value_" + indexH,
                                            "option-key": "brand_value",
                                            "option-value": "brand_value",
                                            "option-label": "brand_label",
                                            "select-options": _vm.listBrands,
                                            value:
                                              sampleResultHeader.result_value,
                                            size: "small",
                                            clearable: true,
                                            filterable: true
                                          },
                                          on: {
                                            onSelected: function($event) {
                                              return _vm.onHeaderResultChanged(
                                                $event,
                                                sampleResultHeader
                                              )
                                            }
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ]
                                : (sampleResultHeader.test
                                  ? sampleResultHeader.test.time_flag == "Y"
                                  : false)
                                ? [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "qm-time-picker-required"
                                      },
                                      [
                                        _c("qm-timepicker", {
                                          attrs: {
                                            id:
                                              "input_header_result_value_" +
                                              indexH,
                                            name:
                                              "header_result_value_" + indexH,
                                            value:
                                              sampleResultHeader.result_value
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.onHeaderResultChanged(
                                                $event,
                                                sampleResultHeader
                                              )
                                            }
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ]
                                : sampleResultHeader.selected_test_code ==
                                  "RESULT_BY"
                                ? [
                                    _c("div", { staticClass: "tw-py-2" }, [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            _vm.authUser
                                              ? _vm.authUser.name
                                              : "-"
                                          ) +
                                          "\n                            "
                                      )
                                    ])
                                  ]
                                : sampleResultHeader.data_type_code == "N"
                                ? [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value:
                                            sampleResultHeader.result_value,
                                          expression:
                                            "sampleResultHeader.result_value"
                                        }
                                      ],
                                      staticClass:
                                        "form-control input-sm text-center",
                                      attrs: {
                                        id:
                                          "input_header_result_value_" + indexH,
                                        type: "number",
                                        name: "header_result_value_" + indexH,
                                        placeholder: ""
                                      },
                                      domProps: {
                                        value: sampleResultHeader.result_value
                                      },
                                      on: {
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            sampleResultHeader,
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
                                          value:
                                            sampleResultHeader.result_value,
                                          expression:
                                            "sampleResultHeader.result_value"
                                        }
                                      ],
                                      staticClass:
                                        "form-control input-sm text-center",
                                      attrs: {
                                        id:
                                          "input_header_result_value_" + indexH,
                                        type: "text",
                                        name: "header_result_value_" + indexH,
                                        placeholder: ""
                                      },
                                      domProps: {
                                        value: sampleResultHeader.result_value
                                      },
                                      on: {
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            sampleResultHeader,
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
                              sampleResultHeader.brand_flag == "Y"
                                ? [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          sampleResultHeader.result_value
                                            ? _vm.getBrandLabel(
                                                sampleResultHeader.result_value
                                              )
                                            : "-"
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                                : [
                                    _vm._v(
                                      "\n                            " +
                                        _vm._s(
                                          sampleResultHeader.result_value
                                        ) +
                                        "\n                        "
                                    )
                                  ]
                            ],
                            2
                          )
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { colspan: "11" } })
                  ])
                }),
                _vm._v(" "),
                _vm._l(_vm.sampleResults, function(sampleResult, index) {
                  return [
                    _c("tr", { key: "" + index }, [
                      _c(
                        "td",
                        {
                          staticClass:
                            "tw-text-xs tw-bg-opacity-60 tw-bg-gray-200 tw-font-bold",
                          attrs: { colspan: "16" }
                        },
                        [
                          _c("div", [
                            _vm._v(
                              " " +
                                _vm._s(sampleResult.qm_process) +
                                " : " +
                                _vm._s(sampleResult.machine_description) +
                                " จำนวนตัวอย่าง " +
                                _vm._s(sampleResult.sample_qty) +
                                " " +
                                _vm._s(sampleResult.qc_unit_code) +
                                "  "
                            )
                          ])
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm._l(
                      _vm.sampleResultLines.filter(function(srl) {
                        return srl.qm_process == sampleResult.qm_process
                      }),
                      function(sampleResultLine, lineIndex) {
                        return _c("tr", { key: index + "-" + lineIndex }, [
                          _c(
                            "td",
                            {
                              staticClass:
                                "tw-text-right tw-text-xs md:tw-table-cell tw-text-blue-600 tw-font-bold tw-hidden"
                            },
                            [
                              sampleResultLine.additional_line_flag == "Y" &&
                              _vm.showType == "result" &&
                              _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                                ? _c("div", { staticClass: "tw-pt-1" }, [
                                    _c(
                                      "button",
                                      {
                                        staticClass: "btn btn-xs btn-danger",
                                        on: {
                                          click: function($event) {
                                            return _vm.onRemoveResultLine(
                                              sampleResultLine
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("span", {
                                          staticClass: "fa fa-times"
                                        })
                                      ]
                                    )
                                  ])
                                : _vm._e()
                            ]
                          ),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs" }, [
                            sampleResultLine.additional_line_flag != "Y" ||
                            _vm.showType != "result" ||
                            !_vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                              ? _c("div", {}, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(sampleResultLine.check_list) +
                                      "\n                            "
                                  ),
                                  sampleResultLine.optional_ind != "Y"
                                    ? _c(
                                        "span",
                                        { staticClass: "tw-text-red-600" },
                                        [_vm._v(" * ")]
                                      )
                                    : _vm._e()
                                ])
                              : _c(
                                  "div",
                                  [
                                    _c("qm-el-select", {
                                      attrs: {
                                        id:
                                          "input_check_list_" +
                                          index +
                                          "_" +
                                          lineIndex,
                                        name:
                                          "check_list[" +
                                          index +
                                          "][" +
                                          lineIndex +
                                          "]",
                                        "option-key": "check_list",
                                        "option-value": "check_list",
                                        "option-label": "check_list",
                                        "select-options": _vm.availableCheckListItems.filter(
                                          function(item) {
                                            return (
                                              item.qm_process ==
                                              sampleResultLine.qm_process
                                            )
                                          }
                                        ),
                                        value: sampleResultLine.check_list,
                                        size: "small",
                                        clearable: false,
                                        filterable: true
                                      },
                                      on: {
                                        onSelected: function($event) {
                                          return _vm.onSelectedCheckListItem(
                                            $event,
                                            sampleResultLine
                                          )
                                        }
                                      }
                                    })
                                  ],
                                  1
                                )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs" }, [
                            _vm.showType == "result" &&
                            sampleResultLine.read_only != "Y" &&
                            _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                              ? _c(
                                  "div",
                                  [
                                    sampleResultLine.additional_line_flag != "Y"
                                      ? [
                                          _c("qm-el-select", {
                                            attrs: {
                                              id:
                                                "input_test_id_" +
                                                index +
                                                "_" +
                                                lineIndex,
                                              name:
                                                "test_id[" +
                                                index +
                                                "][" +
                                                lineIndex +
                                                "]",
                                              "option-key": "test_id",
                                              "option-value": "test_id",
                                              "option-label": "test_desc",
                                              "select-options": _vm.checkListTestItems.filter(
                                                function(item) {
                                                  return (
                                                    item.qm_process ==
                                                      sampleResultLine.qm_process &&
                                                    item.check_list ==
                                                      sampleResultLine.check_list
                                                  )
                                                }
                                              ),
                                              value:
                                                sampleResultLine.selected_test_id,
                                              size: "small",
                                              clearable: false,
                                              filterable: true
                                            },
                                            on: {
                                              onSelected: function($event) {
                                                return _vm.onSelectedCheckListTestItem(
                                                  $event,
                                                  sampleResultLine
                                                )
                                              }
                                            }
                                          })
                                        ]
                                      : [
                                          _c("qm-el-select", {
                                            attrs: {
                                              id:
                                                "input_test_id_" +
                                                index +
                                                "_" +
                                                lineIndex,
                                              name:
                                                "test_id[" +
                                                index +
                                                "][" +
                                                lineIndex +
                                                "]",
                                              "option-key": "test_id",
                                              "option-value": "test_id",
                                              "option-label": "test_desc",
                                              "select-options": _vm.availableCheckListTestItems.filter(
                                                function(item) {
                                                  return (
                                                    item.qm_process ==
                                                      sampleResultLine.qm_process &&
                                                    item.check_list ==
                                                      sampleResultLine.check_list
                                                  )
                                                }
                                              ),
                                              value:
                                                sampleResultLine.selected_test_id,
                                              size: "small",
                                              clearable: false,
                                              filterable: true
                                            },
                                            on: {
                                              onSelected: function($event) {
                                                return _vm.onSelectedCheckListTestItem(
                                                  $event,
                                                  sampleResultLine
                                                )
                                              }
                                            }
                                          })
                                        ]
                                  ],
                                  2
                                )
                              : _c("div", [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        sampleResultLine.selected_test_desc
                                      ) +
                                      "\n                        "
                                  )
                                ])
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                              ? _c(
                                  "div",
                                  [
                                    _vm.showType != "result" ||
                                    sampleResultLine.read_only == "Y"
                                      ? [
                                          _c("input", {
                                            staticClass:
                                              "form-control input-sm text-right tw-border-white",
                                            staticStyle: {
                                              "background-color": "#ffffff",
                                              "max-width": "100px"
                                            },
                                            attrs: {
                                              type: "text",
                                              disabled: ""
                                            },
                                            domProps: {
                                              value: sampleResultLine.result_value
                                                ? sampleResultLine.result_value
                                                : "-"
                                            }
                                          })
                                        ]
                                      : sampleResultLine.data_type_code == "N"
                                      ? [
                                          _c("input", {
                                            directives: [
                                              {
                                                name: "model",
                                                rawName: "v-model",
                                                value:
                                                  sampleResultLine.result_value,
                                                expression:
                                                  "sampleResultLine.result_value"
                                              }
                                            ],
                                            staticClass:
                                              "form-control input-sm text-center",
                                            staticStyle: {
                                              "max-width": "100px"
                                            },
                                            attrs: {
                                              id:
                                                "input_result_value_" +
                                                index +
                                                "_" +
                                                lineIndex,
                                              name:
                                                "result_value_" +
                                                index +
                                                "_" +
                                                lineIndex,
                                              type: "number",
                                              disabled:
                                                sampleResultLine.optimal_result_flag ||
                                                sampleResultLine.cannot_get_result_flag,
                                              placeholder: ""
                                            },
                                            domProps: {
                                              value:
                                                sampleResultLine.result_value
                                            },
                                            on: {
                                              change: function($event) {
                                                return _vm.onResultValueChanged(
                                                  $event,
                                                  sampleResult,
                                                  sampleResultLine
                                                )
                                              },
                                              input: function($event) {
                                                if ($event.target.composing) {
                                                  return
                                                }
                                                _vm.$set(
                                                  sampleResultLine,
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
                                                value:
                                                  sampleResultLine.result_value,
                                                expression:
                                                  "sampleResultLine.result_value"
                                              }
                                            ],
                                            staticClass:
                                              "form-control input-sm text-center",
                                            staticStyle: {
                                              "max-width": "100px"
                                            },
                                            attrs: {
                                              id:
                                                "input_result_value_" +
                                                index +
                                                "_" +
                                                lineIndex,
                                              name:
                                                "result_value_" +
                                                index +
                                                "_" +
                                                lineIndex,
                                              type: "text",
                                              disabled:
                                                sampleResultLine.optimal_result_flag ||
                                                sampleResultLine.cannot_get_result_flag,
                                              placeholder: ""
                                            },
                                            domProps: {
                                              value:
                                                sampleResultLine.result_value
                                            },
                                            on: {
                                              change: function($event) {
                                                return _vm.onResultValueChanged(
                                                  $event,
                                                  sampleResult,
                                                  sampleResultLine
                                                )
                                              },
                                              input: function($event) {
                                                if ($event.target.composing) {
                                                  return
                                                }
                                                _vm.$set(
                                                  sampleResultLine,
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
                              : _c("div", [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        sampleResultLine.result_value
                                          ? parseFloat(
                                              sampleResultLine.result_value
                                            )
                                          : ""
                                      ) +
                                      "\n                        "
                                  )
                                ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass:
                                "text-left tw-text-xs md:tw-table-cell tw-hidden"
                            },
                            [
                              _c("div", {}, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      sampleResultLine.selected_test_unit_desc
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
                              staticClass:
                                "text-left tw-text-xs md:tw-table-cell tw-hidden"
                            },
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: sampleResultLine.cause_of_defect,
                                    expression:
                                      "sampleResultLine.cause_of_defect"
                                  }
                                ],
                                staticClass: "form-control input-sm text-left",
                                attrs: {
                                  type: "text",
                                  disabled: !_vm.isAllowEdit(
                                    _vm.sampleData,
                                    _vm.approvalRole
                                  ),
                                  placeholder: "ระบุสาเหตุ"
                                },
                                domProps: {
                                  value: sampleResultLine.cause_of_defect
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      sampleResultLine,
                                      "cause_of_defect",
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
                                "text-center tw-text-xs md:tw-table-cell tw-hidden"
                            },
                            [
                              sampleResultLine.result_status == "PASSED"
                                ? _c("span", {
                                    staticClass:
                                      "fa fa-2x fa-check-circle tw-text-green-500"
                                  })
                                : _vm._e(),
                              _vm._v(" "),
                              sampleResultLine.result_status == "FAILED"
                                ? _c("span", {
                                    staticClass:
                                      "fa fa-2x fa-times tw-text-red-500"
                                  })
                                : _vm._e(),
                              _vm._v(" "),
                              !sampleResultLine.result_status
                                ? _c("span", {
                                    staticClass: "fa fa-2x fa-minus"
                                  })
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
                              _vm.showType == "result" &&
                              _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                                ? _c(
                                    "div",
                                    { staticClass: "tw-mt-2" },
                                    [
                                      _c("qm-el-checkbox", {
                                        attrs: {
                                          value:
                                            sampleResultLine.optimal_result_flag,
                                          label: "",
                                          name: "optimal_result_flag_" + index,
                                          id: "optimal_result_flag_" + index,
                                          size: "medium"
                                        },
                                        on: {
                                          change: function($event) {
                                            return _vm.onOptimalResultCheckBoxChanged(
                                              $event,
                                              sampleResultLine
                                            )
                                          }
                                        }
                                      })
                                    ],
                                    1
                                  )
                                : _c("div", [
                                    sampleResultLine.optimal_result_flag
                                      ? _c("span", {
                                          staticClass:
                                            "fa fa-2x fa-check-circle tw-text-green-500"
                                        })
                                      : _vm._e()
                                  ])
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
                              _vm.showType == "result" &&
                              _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                                ? _c(
                                    "div",
                                    { staticClass: "tw-mt-2" },
                                    [
                                      _c("qm-el-checkbox", {
                                        attrs: {
                                          value:
                                            sampleResultLine.cannot_get_result_flag,
                                          label: "",
                                          name:
                                            "cannot_get_result_flag_" + index,
                                          id:
                                            "input_cannot_get_result_flag_" +
                                            index,
                                          size: "medium"
                                        },
                                        on: {
                                          change: function($event) {
                                            return _vm.onCannotGetResultCheckBoxChanged(
                                              $event,
                                              sampleResult,
                                              sampleResultLine
                                            )
                                          }
                                        }
                                      })
                                    ],
                                    1
                                  )
                                : _c("div", [
                                    sampleResultLine.cannot_get_result_flag
                                      ? _c("span", {
                                          staticClass:
                                            "fa fa-2x fa-check-circle tw-text-red-500"
                                        })
                                      : _vm._e()
                                  ])
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
                              _vm.showType == "result" &&
                              _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                                ? _c("div", [
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value:
                                            sampleResultLine.cannot_get_result_reason,
                                          expression:
                                            "sampleResultLine.cannot_get_result_reason"
                                        }
                                      ],
                                      staticClass:
                                        "form-control input-sm tw-text-xs text-left",
                                      style: {
                                        backgroundColor: sampleResultLine.cannot_get_result_flag
                                          ? "#fffbe4"
                                          : ""
                                      },
                                      attrs: {
                                        type: "text",
                                        disabled: !sampleResultLine.cannot_get_result_flag,
                                        placeholder:
                                          "เหตุผลที่ไม่สามารถเก็บข้อมูล"
                                      },
                                      domProps: {
                                        value:
                                          sampleResultLine.cannot_get_result_reason
                                      },
                                      on: {
                                        blur: function($event) {
                                          return _vm.onCannotGetResultReasonChanged(
                                            $event,
                                            sampleResultLine
                                          )
                                        },
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            sampleResultLine,
                                            "cannot_get_result_reason",
                                            $event.target.value
                                          )
                                        }
                                      }
                                    })
                                  ])
                                : _c("div", { staticClass: "tw-py-2" }, [
                                    sampleResultLine.cannot_get_result_flag
                                      ? _c("span", [
                                          _vm._v(
                                            "\n                                " +
                                              _vm._s(
                                                sampleResultLine.cannot_get_result_reason
                                              ) +
                                              "\n                            "
                                          )
                                        ])
                                      : _vm._e()
                                  ])
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
                              sampleResultLine.failed_status == "UNDER"
                                ? _c("span", {
                                    staticClass:
                                      "fa fa-2x fa-arrow-down tw-text-blue-500"
                                  })
                                : sampleResultLine.failed_status == "OVER"
                                ? _c("span", {
                                    staticClass:
                                      "fa fa-2x fa-arrow-up tw-text-red-500"
                                  })
                                : _vm._e()
                            ]
                          ),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center tw-text-xs" }, [
                            !sampleResultLine.severity_level
                              ? _c(
                                  "div",
                                  {
                                    staticClass: "tw-text-gray-500 tw-font-bold"
                                  },
                                  [_vm._v(" - ")]
                                )
                              : sampleResultLine.severity_level == "NONE"
                              ? _c(
                                  "div",
                                  {
                                    staticClass: "tw-text-gray-500 tw-font-bold"
                                  },
                                  [_vm._v(" - ")]
                                )
                              : sampleResultLine.severity_level == "MINOR"
                              ? _c(
                                  "div",
                                  {
                                    staticClass: "tw-text-blue-500 tw-font-bold"
                                  },
                                  [_vm._v(" MINOR ")]
                                )
                              : sampleResultLine.severity_level == "MAJOR"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-yellow-500 tw-font-bold"
                                  },
                                  [_vm._v(" MAJOR ")]
                                )
                              : sampleResultLine.severity_level == "CRITICAL"
                              ? _c(
                                  "div",
                                  {
                                    staticClass: "tw-text-red-700 tw-font-bold"
                                  },
                                  [_vm._v(" CRITICAL ")]
                                )
                              : _vm._e()
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center tw-text-xs" }, [
                            _vm.showType == "result" &&
                            sampleResultLine.read_only != "Y" &&
                            _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                              ? _c(
                                  "div",
                                  [
                                    _c("qm-el-select", {
                                      attrs: {
                                        id:
                                          "input_test_serverity_code_" +
                                          index +
                                          "_" +
                                          lineIndex,
                                        name:
                                          "test_serverity_code[" +
                                          index +
                                          "][" +
                                          lineIndex +
                                          "]",
                                        "option-key": "value",
                                        "option-value": "value",
                                        "option-label": "label",
                                        "select-options":
                                          _vm.listTestServerityCodes,
                                        value:
                                          sampleResultLine.test_serverity_code,
                                        size: "small",
                                        clearable: false,
                                        filterable: true
                                      },
                                      on: {
                                        onSelected: function($event) {
                                          return _vm.onSelectedTestServerityCode(
                                            $event,
                                            sampleResultLine
                                          )
                                        }
                                      }
                                    })
                                  ],
                                  1
                                )
                              : _c("div", [
                                  !sampleResultLine.test_serverity_code
                                    ? _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-text-gray-500 tw-font-bold"
                                        },
                                        [_vm._v(" - ")]
                                      )
                                    : sampleResultLine.test_serverity_code ==
                                      "NONE"
                                    ? _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-text-gray-500 tw-font-bold"
                                        },
                                        [_vm._v(" - ")]
                                      )
                                    : sampleResultLine.test_serverity_code ==
                                      "MINOR"
                                    ? _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-text-blue-500 tw-font-bold"
                                        },
                                        [_vm._v(" MINOR ")]
                                      )
                                    : sampleResultLine.test_serverity_code ==
                                      "MAJOR"
                                    ? _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-text-yellow-500 tw-font-bold"
                                        },
                                        [_vm._v(" MAJOR ")]
                                      )
                                    : sampleResultLine.test_serverity_code ==
                                      "CRITICAL"
                                    ? _c(
                                        "div",
                                        {
                                          staticClass:
                                            "tw-text-red-700 tw-font-bold"
                                        },
                                        [_vm._v(" CRITICAL ")]
                                      )
                                    : _vm._e()
                                ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "text-center tw-text-xs" },
                            _vm._l(sampleResultLine.uploadedImages, function(
                              uploadedImage,
                              i
                            ) {
                              return _c(
                                "div",
                                { key: i, staticClass: "tw-py-2 tw-block" },
                                [
                                  _c(
                                    "a",
                                    {
                                      staticClass:
                                        "btn btn-outline btn-primary tw-py-2 tw-px-1 tw-inline-block",
                                      attrs: {
                                        href:
                                          "/qm/files/image/qm/finished-products/result-quality-line/" +
                                          uploadedImage.file_name,
                                        target: "_blank"
                                      }
                                    },
                                    [
                                      _c("span", {
                                        staticClass: "fa fa-picture-o tw-mr-1"
                                      }),
                                      _vm._v(
                                        " ดูแนบรูปภาพ\n                            "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _vm.isAllowEdit(
                                    _vm.sampleData,
                                    _vm.approvalRole
                                  )
                                    ? _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-danger btn-outline tw-inline-block tw-text-red-700 tw-py-2 tw-px-2",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              return _vm.onDeleteResultLineUplodedImage(
                                                sampleResultLine,
                                                i
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("span", {
                                            staticClass: "fa fa-times"
                                          })
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              )
                            }),
                            0
                          ),
                          _vm._v(" "),
                          _vm.showType == "result"
                            ? _c(
                                "td",
                                { staticClass: "text-center tw-text-xs" },
                                [
                                  _vm.isAllowEdit(
                                    _vm.sampleData,
                                    _vm.approvalRole
                                  )
                                    ? _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-xs btn-outline btn-success tw-py-2",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              return _vm.validateBeforeChooseImages(
                                                sampleResultLine,
                                                index,
                                                lineIndex
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass:
                                              "fa fa fa-upload tw-mr-1"
                                          }),
                                          _vm._v(
                                            " เลือกรูปภาพ\n                        "
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "tw-hidden" }, [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "custom-file custom-file-th"
                                      },
                                      [
                                        _c("input", {
                                          ref:
                                            "finished_products_result_quality_line_image_" +
                                            index +
                                            "_" +
                                            lineIndex,
                                          refInFor: true,
                                          staticClass: "custom-file-input",
                                          attrs: {
                                            type: "file",
                                            accept:
                                              "image/jpeg,image/gif,image/png",
                                            id:
                                              "input_image_" +
                                              index +
                                              "_" +
                                              lineIndex,
                                            name:
                                              "image_" +
                                              index +
                                              "_" +
                                              lineIndex,
                                            "ref-label":
                                              "label_image_" +
                                              index +
                                              "_" +
                                              lineIndex,
                                            multiple: ""
                                          },
                                          on: {
                                            change: function($event) {
                                              return _vm.validateImages(
                                                $event,
                                                sampleResultLine
                                              )
                                            }
                                          }
                                        })
                                      ]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _vm._l(sampleResultLine.images, function(
                                    image,
                                    i
                                  ) {
                                    return _c("div", { key: i }, [
                                      _c(
                                        "label",
                                        {
                                          staticClass:
                                            "tw-mt-2 tw-mb-1 tw-text-gray-500",
                                          staticStyle: {
                                            "max-width": "80px",
                                            "white-space": "nowrap",
                                            overflow: "hidden",
                                            "text-overflow": "ellipsis"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                " +
                                              _vm._s(image.name) +
                                              "\n                            "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm.isAllowEdit(
                                        _vm.sampleData,
                                        _vm.approvalRole
                                      )
                                        ? _c("label", {
                                            staticClass:
                                              "tw-mb-1 tw-ml-2 tw-text-red-700 fa fa-times tw-cursor-pointer tw-inline-block",
                                            staticStyle: { overflow: "hidden" },
                                            on: {
                                              click: function($event) {
                                                return _vm.onDeleteResultLineImage(
                                                  sampleResultLine,
                                                  i
                                                )
                                              }
                                            }
                                          })
                                        : _vm._e()
                                    ])
                                  })
                                ],
                                2
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center tw-text-xs" }, [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "btn btn-xs btn-outline tw-w-20 tw-bg-opacity-20 tw-bg-purple-200 tw-border-purple-400 hover:tw-bg-purple-200 hover:tw-border-purple-400 tw-py-2 tw-text-purple-600",
                                attrs: { type: "button" },
                                on: {
                                  click: function($event) {
                                    return _vm.onShowModalTestImages(
                                      sampleResultLine
                                    )
                                  }
                                }
                              },
                              [
                                _c("span", {
                                  staticClass: "fa fa-picture-o tw-mr-1"
                                }),
                                _vm._v(" ดูภาพ\n                        ")
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _vm.showType == "defect"
                            ? _c(
                                "td",
                                {
                                  staticClass: "text-left tw-text-xs",
                                  staticStyle: { "padding-right": "0px" }
                                },
                                [
                                  sampleResultLine.result_status == "FAILED"
                                    ? [
                                        _c("input", {
                                          directives: [
                                            {
                                              name: "model",
                                              rawName: "v-model",
                                              value:
                                                sampleResultLine.cause_of_defect,
                                              expression:
                                                "sampleResultLine.cause_of_defect"
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
                                            value:
                                              sampleResultLine.cause_of_defect
                                          },
                                          on: {
                                            input: function($event) {
                                              if ($event.target.composing) {
                                                return
                                              }
                                              _vm.$set(
                                                sampleResultLine,
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
                        ])
                      }
                    ),
                    _vm._v(" "),
                    _vm.showType == "result" &&
                    sampleResult.show_input_issue_not_found &&
                    _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                      ? _c("tr", { key: index + "-issue_not_found" }, [
                          _c("td"),
                          _vm._v(" "),
                          _vm._m(1, true),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "qm_issue_not_found_checkbox" },
                            [
                              _c(
                                "div",
                                { staticClass: "tw-pt-2" },
                                [
                                  _c("qm-el-checkbox", {
                                    attrs: {
                                      value: sampleResult.issue_not_found,
                                      label: "",
                                      name: "issue_not_found_" + index,
                                      id: "input_issue_not_found_" + index,
                                      size: "medium",
                                      disabled: !_vm.isAllowEdit(
                                        _vm.sampleData,
                                        _vm.approvalRole
                                      )
                                    },
                                    on: {
                                      change: function($event) {
                                        return _vm.onIssueNotFouldCheckBoxChanged(
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
                          ),
                          _vm._v(" "),
                          _c("td", { attrs: { colspan: "8" } })
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.showType == "result" &&
                    !sampleResult.cannot_get_result_flag &&
                    !sampleResult.issue_not_found
                      ? _c("tr", { key: index + "-add_button" }, [
                          _c("td"),
                          _vm._v(" "),
                          _c("td", { attrs: { colspan: "15" } }, [
                            _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                              ? _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-xs btn-primary",
                                    attrs: {
                                      disabled:
                                        sampleResult.cannot_get_result_flag &&
                                        sampleResult.issue_not_found
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.onAddNewResultLine(
                                          sampleResult
                                        )
                                      }
                                    }
                                  },
                                  [_c("span", { staticClass: "fa fa-plus" })]
                                )
                              : _vm._e()
                          ])
                        ])
                      : _vm._e()
                  ]
                }),
                _vm._v(" "),
                (_vm.showType == "result" || _vm.showType == "defect") &&
                _vm.isAllowEdit(_vm.sampleData, _vm.approvalRole)
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "16" } }, [
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
          : _c("tbody", [_vm._m(2)])
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
      _c("modal-show-test-images", {
        attrs: {
          "modal-name": "modal-show-test-images",
          "modal-width": "640",
          "modal-height": "auto",
          specifications: _vm.specifications,
          "test-id-value": _vm.showedModalTestId
        },
        on: { onModalTestImageClosed: _vm.onModalTestImageClosed }
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
        "td",
        {
          staticClass:
            "tw-text-xs tw-bg-opacity-60 tw-bg-gray-200 tw-font-bold",
          attrs: { colspan: "16" }
        },
        [_c("div", [_vm._v(" ข้อมูลการตรวจสอบ ")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "tw-text-xs" }, [
      _c("div", {}, [_vm._v(" ไม่พบความผิดปกติ ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "16" } }, [
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