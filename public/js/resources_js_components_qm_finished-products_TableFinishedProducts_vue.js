(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_finished-products_TableFinishedProducts_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
// Import loading-overlay component
 // Import loading-overlay stylesheet



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["authUser", "showType", "listBrands", "listTestServerityCodes", "approvalData", "approvalRole", "items", "total"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    var _this = this;

    return {
      sampleItems: JSON.parse(this.items).map(function (item) {
        return _objectSpread(_objectSpread({}, item), {}, {
          remark: item.gmd_sample.attribute19 ? item.gmd_sample.attribute19 : "",
          approval_status_code: item.gmd_sample.attribute13 ? item.gmd_sample.attribute13 : "10",
          operator_approval_status: _this.getOperatorApprovalStatus(_this.approvalData, item.gmd_sample.attribute13),
          supervisor_approval_status: _this.getSupervisorApprovalStatus(_this.approvalData, item.gmd_sample.attribute13),
          leader_approval_status: _this.getLeaderApprovalStatus(_this.approvalData, item.gmd_sample.attribute13),
          date_drawn_show: item.date_drawn_formatted ? moment__WEBPACK_IMPORTED_MODULE_3___default()(item.date_drawn_formatted).add(543, 'years').format('DD/MM/YYYY') : "",
          specification_showed: false,
          specifications: [],
          resultHeaders: [],
          results: [],
          resultLines: [],
          attachments: [],
          defaultData: {}
        });
      }),
      // .sort((a, b) => {
      //     var aDate = moment(a.date_drawn_formatted, 'YYYY-MM-DD').format("X");
      //     var bDate = moment(b.date_drawn_formatted, 'YYYY-MM-DD').format("X");
      //     var aDateTime = moment(a.date_drawn, 'YYYY-MM-DD HH:mm:ss').format("X");
      //     var bDateTime = moment(b.date_drawn, 'YYYY-MM-DD HH:mm:ss').format("X");
      //     if(aDate == bDate) {
      //         return (aDateTime < bDateTime) ? -1 : (aDateTime > bDateTime) ? 1 : 0;
      //     } else {
      //         return (aDate > bDate) ? -1 : 1;
      //     }
      // }),
      isLoading: false
    };
  },
  methods: {
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
    isAllowApproval: function isAllowApproval(sample, approvalRole) {
      var allowed = false;

      if (sample.sample_operation_status == 'CP') {
        if (approvalRole) {
          var approvalLevelCode = approvalRole.level_code;

          if (approvalLevelCode == "1") {
            // Operator
            if (sample.approval_status_code == "10") {
              // Pending : Operator Approval 
              allowed = true;
            }
          } else if (approvalLevelCode == "2") {
            // Supervisor
            if (sample.approval_status_code == "11") {
              // Pending : Supervisor Approval (Operator Approved)
              allowed = true;
            }
          } else if (approvalLevelCode == "3") {
            // Leader
            if (sample.approval_status_code == "21") {
              // Pending : Leader Approval (Supervisor Approved)
              allowed = true;
            }
          }
        }
      }

      return allowed;
    },
    isAllowRejectApproval: function isAllowRejectApproval(sample, approvalRole) {
      var allowed = false;

      if (approvalRole) {
        var approvalLevelCode = approvalRole.level_code;

        if (approvalLevelCode == "1") {
          // Operator
          if (sample.approval_status_code == "10") {
            // Pending : Operator Approval 
            allowed = true;
          }
        } else if (approvalLevelCode == "2") {
          // Supervisor
          if (sample.approval_status_code == "11") {
            // Pending : Supervisor Approval (Operator Approved)
            allowed = true;
          }
        } else if (approvalLevelCode == "3") {
          // Leader
          if (sample.approval_status_code == "21") {
            // Pending : Leader Approval (Supervisor Approved)
            allowed = true;
          }
        }
      }

      return allowed;
    },
    isAllowReturnApproval: function isAllowReturnApproval(sample, approvalRole) {
      var allowed = false;

      if (approvalRole) {
        var approvalLevelCode = approvalRole.level_code;

        if (approvalLevelCode == "2") {
          // Supervisor
          if (sample.approval_status_code == "11") {
            // Pending : Supervisor Approval (Operator Approved)
            allowed = true;
          }
        } else if (approvalLevelCode == "3") {
          // Leader
          if (sample.approval_status_code == "21") {
            // Pending : Leader Approval (Supervisor Approved)
            allowed = true;
          }
        }
      }

      return allowed;
    },
    isAllowUnapproveApproval: function isAllowUnapproveApproval(sample, approvalRole) {
      var allowed = false;

      if (approvalRole) {
        var approvalLevelCode = approvalRole.level_code;

        if (approvalLevelCode == "3") {
          // Leader
          if (sample.approval_status_code == "31") {
            // Leader Approved
            allowed = true;
          }
        }
      }

      return allowed;
    },
    getOperatorApprovalStatus: function getOperatorApprovalStatus(approvalData, statusCode) {
      var levelCode = 1;
      var foundApprovalData = approvalData.find(function (item) {
        return item.level_code == levelCode;
      });
      var statusDesc = "";
      var statusColor = "";

      if (!statusCode || statusCode == "10") {
        statusDesc = foundApprovalData.pending_status;
        statusColor = "yellow";
      } else if (statusCode == "12") {
        statusDesc = foundApprovalData.reject_status;
        statusColor = "red";
      } else if (statusCode == "11" || statusCode == "21" || statusCode == "22" || statusCode == "31" || statusCode == "32") {
        statusDesc = foundApprovalData.approved_status;
        statusColor = "green";
      }

      return {
        status_desc: statusDesc,
        status_color: statusColor
      };
    },
    getSupervisorApprovalStatus: function getSupervisorApprovalStatus(approvalData, statusCode) {
      var levelCode = 2;
      var foundApprovalData = approvalData.find(function (item) {
        return item.level_code == levelCode;
      });
      var statusDesc = "";
      var statusColor = "";

      if (statusCode == "11") {
        statusDesc = foundApprovalData.pending_status;
        statusColor = "yellow";
      } else if (statusCode == "22") {
        statusDesc = foundApprovalData.reject_status;
        statusColor = "red";
      } else if (statusCode == "21" || statusCode == "31" || statusCode == "32") {
        statusDesc = foundApprovalData.approved_status;
        statusColor = "green";
      }

      return {
        status_desc: statusDesc,
        status_color: statusColor
      };
    },
    getLeaderApprovalStatus: function getLeaderApprovalStatus(approvalData, statusCode) {
      var levelCode = 3;
      var foundApprovalData = approvalData.find(function (item) {
        return item.level_code == levelCode;
      });
      var statusDesc = "";
      var statusColor = "";

      if (statusCode == "21") {
        statusDesc = foundApprovalData.pending_status;
        statusColor = "yellow";
      } else if (statusCode == "32") {
        statusDesc = foundApprovalData.reject_status;
        statusColor = "red";
      } else if (statusCode == "31") {
        statusDesc = foundApprovalData.approved_status;
        statusColor = "green";
      }

      return {
        status_desc: statusDesc,
        status_color: statusColor
      };
    },
    onResultButtonClicked: function onResultButtonClicked(sampleNo, organizationId, inventoryItemId, e) {
      var _this2 = this;

      this.sampleItems.forEach( /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(element, i) {
          var resGetSampleSpecifications;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  if (!(element.sample_no === sampleNo)) {
                    _context.next = 16;
                    break;
                  }

                  if (_this2.sampleItems[i].specification_showed) {
                    _context.next = 13;
                    break;
                  }

                  _this2.isLoading = true;
                  _context.next = 5;
                  return _this2.getSampleSpecifications(sampleNo, organizationId, inventoryItemId);

                case 5:
                  resGetSampleSpecifications = _context.sent;
                  _this2.sampleItems[i].specifications = resGetSampleSpecifications.specifications;
                  _this2.sampleItems[i].resultHeaders = resGetSampleSpecifications.resultHeaders;
                  _this2.sampleItems[i].results = resGetSampleSpecifications.results;
                  _this2.sampleItems[i].resultLines = resGetSampleSpecifications.resultLines;
                  _this2.sampleItems[i].attachments = resGetSampleSpecifications.attachments;
                  _this2.sampleItems[i].defaultData = resGetSampleSpecifications.defaultData;
                  _this2.isLoading = false;

                case 13:
                  _this2.sampleItems[i].specification_showed = !_this2.sampleItems[i].specification_showed;
                  _context.next = 17;
                  break;

                case 16:
                  _this2.sampleItems[i].specification_showed = false;

                case 17:
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
    },
    getSampleSpecifications: function getSampleSpecifications(sampleNo, organizationId, inventoryItemId) {
      var params = {
        sample_no: sampleNo,
        organization_id: organizationId,
        inventory_item_id: inventoryItemId
      };
      return axios.get("/qm/ajax/finished-products/get-sample-specifications", {
        params: params
      }).then(function (res) {
        return {
          specifications: JSON.parse(res.data.data.specifications),
          resultHeaders: JSON.parse(res.data.data.resultHeaders),
          results: JSON.parse(res.data.data.results),
          resultLines: JSON.parse(res.data.data.resultLines),
          attachments: JSON.parse(res.data.data.attachments),
          defaultData: JSON.parse(res.data.data.defaultData)
        };
      });
    },
    onSampleResultSubmitted: function onSampleResultSubmitted(data) {
      var _this3 = this;

      if (data.status == "success") {
        var resSampleNo = data.sample_no;
        var resSampleDisposition = data.sample_disposition;
        var resSampleDispositionDesc = data.sample_disposition_desc;
        var resSampleOperationStatus = data.sample_operation_status;
        var resSampleOperationStatusDesc = data.sample_operation_status_desc;
        var resSampleResultStatus = data.sample_result_status;
        var resSampleResultStatusDesc = data.sample_result_status_desc;
        var resSampleSeverityLevelMinor = data.severity_level_minor;
        var resSampleSeverityLevelMajor = data.severity_level_major;
        var resSampleSeverityLevelCritical = data.severity_level_critical;
        var resSampleTestServerityCodeMinor = data.test_serverity_code_minor;
        var resSampleTestServerityCodeMajor = data.test_serverity_code_major;
        var resSampleTestServerityCodeCritical = data.test_serverity_code_critical;
        var resSampleResultTestTime = data.sample_result_test_time;
        this.sampleItems.forEach(function (element, i) {
          // this.sampleItems[i].specification_showed = false;
          if (_this3.sampleItems[i].sample_no == resSampleNo) {
            _this3.sampleItems[i].sample_disposition = resSampleDisposition;
            _this3.sampleItems[i].sample_disposition_desc = resSampleDispositionDesc;
            _this3.sampleItems[i].sample_operation_status = resSampleOperationStatus;
            _this3.sampleItems[i].sample_operation_status_desc = resSampleOperationStatusDesc;
            _this3.sampleItems[i].sample_result_status = resSampleResultStatus;
            _this3.sampleItems[i].sample_result_status_desc = resSampleResultStatusDesc;
            _this3.sampleItems[i].severity_level_minor = resSampleSeverityLevelMinor;
            _this3.sampleItems[i].severity_level_major = resSampleSeverityLevelMajor;
            _this3.sampleItems[i].severity_level_critical = resSampleSeverityLevelCritical;
            _this3.sampleItems[i].test_serverity_code_minor = resSampleTestServerityCodeMinor;
            _this3.sampleItems[i].test_serverity_code_major = resSampleTestServerityCodeMajor;
            _this3.sampleItems[i].test_serverity_code_critical = resSampleTestServerityCodeCritical;
            _this3.sampleItems[i].sample_result_test_time = resSampleResultTestTime;
          }
        });
      }
    },
    onCancelSampleResult: function onCancelSampleResult(e) {
      var _this4 = this;

      this.sampleItems.forEach(function (element, i) {
        _this4.sampleItems[i].specification_showed = false;
      });
    },
    onApproveSampleClicked: function onApproveSampleClicked(sampleData, approvalRole, event) {
      var _this5 = this;

      var approvalProcessLabel = "";
      var approvalLevelCode = approvalRole.level_code;

      if (approvalLevelCode == "1") {
        approvalProcessLabel = "ส่งอนุมัติ";
      } else if (approvalLevelCode == "2" || approvalLevelCode == "3") {
        approvalProcessLabel = "อนุมัติผลการตรวจสอบ";
      }

      var sampleDispositionDesc = sampleData.sample_disposition_desc;
      var alertText = "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, " | \u0E2A\u0E16\u0E32\u0E19\u0E30 : ").concat(sampleDispositionDesc, " ) ?");
      swal({
        title: "",
        text: alertText,
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ปิด",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          _this5.approveSample(sampleData, approvalRole, approvalProcessLabel);
        }
      });
    },
    onApproveAllSampleClicked: function onApproveAllSampleClicked(approvalRole, event) {
      var _this6 = this;

      var approvalProcessLabel = "";
      var approvalLevelCode = approvalRole.level_code;

      if (approvalLevelCode == "1") {
        approvalProcessLabel = "ส่งอนุมัติ";
      } else if (approvalLevelCode == "2" || approvalLevelCode == "3") {
        approvalProcessLabel = "อนุมัติผลการตรวจสอบ";
      }

      var approvingSampleNos = this.sampleItems.filter(function (sample) {
        return _this6.isAllowApproval(sample, approvalRole);
      }).map(function (item) {
        return item.sample_no;
      });
      console.log("Approving SampleNos : ");
      console.log(approvingSampleNos);

      if (approvingSampleNos.length <= 0) {
        swal("Error", "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A \u0E17\u0E35\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16".concat(approvalProcessLabel, "\u0E44\u0E14\u0E49 "), "error");
      } else {
        var alertText = "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23 ".concat(approvalProcessLabel, " \u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14 ").concat(approvingSampleNos.length, " \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 ) ?");
        swal({
          title: "",
          text: alertText,
          showCancelButton: true,
          confirmButtonClass: "btn-primary",
          confirmButtonText: "ยืนยัน",
          cancelButtonText: "ปิด",
          closeOnConfirm: false
        }, function (isConfirm) {
          if (isConfirm) {
            _this6.approveAllSamples(approvingSampleNos, approvalRole, approvalProcessLabel);
          }
        });
      }
    },
    onRejectSampleClicked: function onRejectSampleClicked(sampleData, approvalRole, event) {
      var _this7 = this;

      var approvalProcessLabel = "";
      var approvalLevelCode = approvalRole.level_code;

      if (approvalLevelCode == "1") {
        approvalProcessLabel = "ยกเลิกผลการทดสอบ";
      } else if (approvalLevelCode == "2" || approvalLevelCode == "3") {
        approvalProcessLabel = "ไม่อนุมัติผลการตรวจสอบ";
      }

      var sampleDispositionDesc = sampleData.sample_disposition_desc;
      var alertText = "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, " | \u0E2A\u0E16\u0E32\u0E19\u0E30 : ").concat(sampleDispositionDesc, " ) ?");
      swal({
        title: "",
        text: alertText,
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ปิด",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          _this7.rejectSample(sampleData, approvalRole, approvalProcessLabel);
        }
      });
    },
    onReturnSampleClicked: function onReturnSampleClicked(sampleData, approvalRole, event) {
      var _this8 = this;

      var approvalProcessLabel = "ส่งกลับการอนุมัติ";
      swal({
        title: "",
        text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, " ) ?"),
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ปิด",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          _this8.returnSample(sampleData, approvalRole, approvalProcessLabel);
        }
      });
    },
    onUnapproveSampleClicked: function onUnapproveSampleClicked(sampleData, approvalRole, event) {
      var _this9 = this;

      var approvalProcessLabel = "ยกเลิกการอนุมัติ";
      swal({
        title: "",
        text: "\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, " ) ?"),
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ปิด",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          _this9.unapproveSample(sampleData, approvalRole, approvalProcessLabel);
        }
      });
    },
    approveSample: function approveSample(sampleData, approvalRole, approvalProcessLabel) {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                reqBody = {
                  organization_code: sampleData.organization_code,
                  oracle_sample_id: sampleData.oracle_sample_id,
                  sample_no: sampleData.sample_no,
                  approval_level_code: approvalRole.level_code
                }; // SHOW LOADING

                _this10.isLoading = true;
                _context2.next = 4;
                return axios.post("/qm/ajax/finished-products/approval/approve", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  var resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";

                  if (resData.status == "success") {
                    swal("Success", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, " )"), "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = _this10.getOperatorApprovalStatus(_this10.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = _this10.getSupervisorApprovalStatus(_this10.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = _this10.getLeaderApprovalStatus(_this10.approvalData, resApprovalStatusCode);
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this10.isLoading = false;

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    approveAllSamples: function approveAllSamples(sampleNos, approvalRole, approvalProcessLabel) {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                reqBody = {
                  sample_nos: JSON.stringify(sampleNos),
                  approval_level_code: approvalRole.level_code
                }; // SHOW LOADING

                _this11.isLoading = true;
                _context3.next = 4;
                return axios.post("/qm/ajax/finished-products/approval/approve-all", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;

                  if (resData.status == "success") {
                    swal("Success", "".concat(approvalProcessLabel, " ( \u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleNos.length, " \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 } )"), "success");
                    location.reload();
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleNos.length, " \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 }) | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleNos.length, " \u0E23\u0E32\u0E22\u0E01\u0E32\u0E23 }) | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this11.isLoading = false;

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    rejectSample: function rejectSample(sampleData, approvalRole, approvalProcessLabel) {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                reqBody = {
                  organization_code: sampleData.organization_code,
                  oracle_sample_id: sampleData.oracle_sample_id,
                  sample_no: sampleData.sample_no,
                  approval_level_code: approvalRole.level_code
                }; // SHOW LOADING

                _this12.isLoading = true;
                _context4.next = 4;
                return axios.post("/qm/ajax/finished-products/approval/reject", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  var resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";

                  if (resData.status == "success") {
                    swal("Success", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, " )"), "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = _this12.getOperatorApprovalStatus(_this12.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = _this12.getSupervisorApprovalStatus(_this12.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = _this12.getLeaderApprovalStatus(_this12.approvalData, resApprovalStatusCode);

                    if (resSample) {
                      sampleData.sample_operation_status = resSample.sample_operation_status;
                      sampleData.sample_operation_status_desc = resSample.sample_operation_status_desc;
                      sampleData.sample_result_status = resSample.sample_result_status;
                      sampleData.sample_result_status_desc = resSample.sample_result_status_desc;
                    }
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A : ").concat(sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this12.isLoading = false;

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    returnSample: function returnSample(sampleData, approvalRole, approvalProcessLabel) {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                reqBody = {
                  organization_code: sampleData.organization_code,
                  oracle_sample_id: sampleData.oracle_sample_id,
                  sample_no: sampleData.sample_no,
                  approval_level_code: approvalRole.level_code
                }; // SHOW LOADING

                _this13.isLoading = true;
                _context5.next = 4;
                return axios.post("/qm/ajax/finished-products/approval/return", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  var resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";

                  if (resData.status == "success") {
                    swal("Success", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, " )"), "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = _this13.getOperatorApprovalStatus(_this13.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = _this13.getSupervisorApprovalStatus(_this13.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = _this13.getLeaderApprovalStatus(_this13.approvalData, resApprovalStatusCode);
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this13.isLoading = false;

              case 5:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    unapproveSample: function unapproveSample(sampleData, approvalRole, approvalProcessLabel) {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                reqBody = {
                  organization_code: sampleData.organization_code,
                  oracle_sample_id: sampleData.oracle_sample_id,
                  sample_no: sampleData.sample_no,
                  approval_level_code: approvalRole.level_code
                }; // SHOW LOADING

                _this14.isLoading = true;
                _context6.next = 4;
                return axios.post("/qm/ajax/finished-products/approval/unapprove", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;
                  var resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";

                  if (resData.status == "success") {
                    swal("Success", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, " )"), "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = _this14.getOperatorApprovalStatus(_this14.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = _this14.getSupervisorApprovalStatus(_this14.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = _this14.getLeaderApprovalStatus(_this14.approvalData, resApprovalStatusCode);
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16 ".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  resStoreSampleResultStatus = "error";
                  swal("Error", "".concat(approvalProcessLabel, " (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ").concat(sampleData.sample_no, ") | ").concat(error.message), "error");
                });

              case 4:
                // HIDE LOADING
                _this14.isLoading = false;

              case 5:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    onSampleRemarkChanged: function onSampleRemarkChanged(e, sampleItem) {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var reqBody;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                // SHOW LOADING
                _this15.isLoading = true;
                reqBody = {
                  organization_code: sampleItem.organization_code,
                  oracle_sample_id: sampleItem.oracle_sample_id,
                  sample_no: sampleItem.sample_no,
                  remark: sampleItem.remark
                }; // SHOW LOADING

                _this15.isLoading = true; // call store cause of remark

                _context7.next = 5;
                return axios.post("/qm/ajax/finished-products/remark", reqBody).then(function (res) {
                  var resData = res.data.data;
                  var resMsg = resData.message;
                  var resSample = resData.sample ? JSON.parse(resData.sample) : null;

                  if (resData.status == "success") {// swal("Success", `บันทึกข้อมูล หมายเหตุ สำเร็จ (เลขที่การตรวจสอบ	: ${sampleItem.sample_no} )`, "success");
                  }

                  if (resData.status == "error") {
                    swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E2B\u0E21\u0E32\u0E22\u0E40\u0E2B\u0E15\u0E38 \u0E44\u0E21\u0E48\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(sampleItem.sample_no, ") | ").concat(resMsg), "error");
                  }

                  return resData;
                })["catch"](function (error) {
                  console.log(error);
                  swal("Error", "\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 \u0E2B\u0E21\u0E32\u0E22\u0E40\u0E2B\u0E15\u0E38 \u0E44\u0E21\u0E48\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08 (\u0E40\u0E25\u0E02\u0E17\u0E35\u0E48\u0E01\u0E32\u0E23\u0E15\u0E23\u0E27\u0E08\u0E2A\u0E2D\u0E1A\t: ".concat(sampleItem.sample_no, ") | ").concat(error.message), "error");
                });

              case 5:
                // HIDE LOADING
                _this15.isLoading = false;

              case 6:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProducts.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProducts.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableFinishedProducts_vue_vue_type_template_id_a70275a8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableFinishedProducts.vue?vue&type=template&id=a70275a8& */ "./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=template&id=a70275a8&");
/* harmony import */ var _TableFinishedProducts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableFinishedProducts.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableFinishedProducts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableFinishedProducts_vue_vue_type_template_id_a70275a8___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableFinishedProducts_vue_vue_type_template_id_a70275a8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/finished-products/TableFinishedProducts.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProducts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableFinishedProducts.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProducts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=template&id=a70275a8&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=template&id=a70275a8& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProducts_vue_vue_type_template_id_a70275a8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProducts_vue_vue_type_template_id_a70275a8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableFinishedProducts_vue_vue_type_template_id_a70275a8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableFinishedProducts.vue?vue&type=template&id=a70275a8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=template&id=a70275a8&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=template&id=a70275a8&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/finished-products/TableFinishedProducts.vue?vue&type=template&id=a70275a8& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "table-responsive",
      staticStyle: { "max-height": "1000px" }
    },
    [
      _c(
        "table",
        {
          staticClass: "table table-bordered table-sticky mb-0",
          staticStyle: { "min-width": "2300px" }
        },
        [
          _c("thead", [
            _c("tr", [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs pt-3 md:tw-table-cell tw-hidden",
                  attrs: { rowspan: "2", width: "5%" }
                },
                [
                  _vm._v(
                    "\n                    เขตตรวจคุณภาพ\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs pt-3 md:tw-table-cell tw-hidden",
                  attrs: { rowspan: "2", width: "5%" }
                },
                [
                  _vm._v(
                    "\n                    เลขชุดเครื่องจักร\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs pt-3 md:tw-table-cell tw-hidden",
                  attrs: { rowspan: "2", width: "8%" }
                },
                [
                  _vm._v(
                    "\n                    วันที่เก็บตัวอย่าง\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs pt-3 md:tw-table-cell tw-hidden",
                  attrs: { rowspan: "2", width: "7%" }
                },
                [
                  _vm._v(
                    "\n                    เวลาที่เก็บตัวอย่าง\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs pt-3 md:tw-table-cell tw-hidden",
                  attrs: { rowspan: "2", width: "12%" }
                },
                [_vm._v("\n                    สถานะการลงผล\n                ")]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs pt-3 md:tw-table-cell tw-hidden",
                  attrs: { rowspan: "2", width: "12%" }
                },
                [
                  _vm._v(
                    "\n                    สถานะผลการทดสอบ\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs md:tw-table-cell tw-hidden",
                  staticStyle: { "min-width": "150px" },
                  attrs: { rowspan: "2", width: "13%" }
                },
                [
                  _vm._v(
                    "\n                    สถานะการอนุมัติ\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "text-center tw-text-xs md:tw-table-cell tw-hidden",
                  staticStyle: { "min-width": "150px" },
                  attrs: { rowspan: "2", width: "8%" }
                },
                [_vm._v("\n                    หมายเหตุ\n                ")]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "tw-text-xs text-center md:tw-table-cell tw-hidden",
                  attrs: { colspan: "3" }
                },
                [
                  _vm._v(
                    " \n                    ระดับความรุนแรงของความผิดปกติ (จำนวน)\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "tw-text-xs text-center md:tw-table-cell tw-hidden",
                  attrs: { colspan: "3" }
                },
                [
                  _vm._v(
                    " \n                    ระดับความรุนแรงของความผิดปกติ (อาการ)\n                "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass:
                    "tw-text-xs text-center pt-3 md:tw-table-cell tw-hidden",
                  staticStyle: { "min-width": "140px" },
                  attrs: { rowspan: "2", width: "10%" }
                },
                [
                  _vm.showType == "result"
                    ? _c("div", [
                        _vm._v(
                          "\n                        สามารถแก้ไขผลการตรวจสอบได้ \n                    "
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.showType == "track"
                    ? _c("div", [
                        _c("div", [_vm._v(" ยืนยันการรับทราบความผิดปกติ ")]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "tw-text-2xs tw-text-gray-400" },
                          [_vm._v(" (จากหน่วยงานต้นทาง) ")]
                        )
                      ])
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "freeze-col-right",
                  staticStyle: { "min-width": "100px" },
                  attrs: { rowspan: "2", width: "10%" }
                },
                [
                  _c("div", { staticClass: "freeze-col-content" }, [
                    (_vm.approvalRole.level_code == "2" ||
                      _vm.approvalRole.level_code == "3") &&
                    _vm.sampleItems.length > 0
                      ? _c("div", { staticClass: "tw-py-4" }, [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-success tw-w-32",
                              on: {
                                click: function($event) {
                                  return _vm.onApproveAllSampleClicked(
                                    _vm.approvalRole,
                                    $event
                                  )
                                }
                              }
                            },
                            [
                              _c("i", { staticClass: "fa fa-check-square-o " }),
                              _vm._v(
                                " Approve All\n                            "
                              )
                            ]
                          )
                        ])
                      : _c("div", [_vm._v("   ")])
                  ])
                ]
              )
            ]),
            _vm._v(" "),
            _vm._m(1)
          ]),
          _vm._v(" "),
          _vm.sampleItems.length > 0
            ? _c(
                "tbody",
                [
                  _vm._l(_vm.sampleItems, function(sampleItem, index) {
                    return [
                      _c("tr", { key: index }, [
                        _c(
                          "td",
                          {
                            staticClass: "freeze-col",
                            staticStyle: { "min-width": "300px" }
                          },
                          [
                            _c("div", { staticClass: "freeze-col-content" }, [
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "tw-inline-block tw-align-top tw-pr-2 tw-py-2",
                                  staticStyle: {
                                    "min-width": "60px",
                                    "max-width": "60px"
                                  }
                                },
                                [
                                  _c("div", { staticClass: "text-center" }, [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(index + 1) +
                                        "\n                                "
                                    )
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "tw-inline-block tw-align-top tw-pl-4 tw-py-2",
                                  staticStyle: {
                                    "min-height": "100px",
                                    "min-width": "190px",
                                    "max-width": "190px",
                                    "border-left": "1px solid #ddd"
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(sampleItem.sample_no) +
                                      "\n                            "
                                  )
                                ]
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center text-nowarp md:tw-table-cell tw-hidden"
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(sampleItem.qc_area) +
                                "\n                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(sampleItem.machine_set) +
                                "\n                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(sampleItem.date_drawn_show) +
                                "\n                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(sampleItem.sample_result_test_time) +
                                "\n                    "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.sample_operation_status == "PD"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_operation_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : sampleItem.sample_operation_status == "IP"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_operation_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : sampleItem.sample_operation_status == "CP"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_operation_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : sampleItem.sample_operation_status == "RJ"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_operation_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.sample_result_status == "PD"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_result_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : sampleItem.sample_result_status == "CF"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_result_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : sampleItem.sample_result_status == "NC"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-red-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_result_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : sampleItem.sample_result_status == "RJ"
                              ? _c(
                                  "div",
                                  {
                                    staticClass:
                                      "tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold"
                                  },
                                  [
                                    _c("span", { staticClass: "tw-text-2xs" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.sample_result_status_desc
                                          ) +
                                          " "
                                      )
                                    ])
                                  ]
                                )
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass: "text-left md:tw-table-cell tw-hidden"
                          },
                          [
                            _c(
                              "div",
                              {
                                staticClass: "tw-pb-1",
                                staticStyle: {
                                  "border-bottom": "1px solid #eee"
                                }
                              },
                              [
                                _c(
                                  "span",
                                  { staticClass: "tw-font-semibold" },
                                  [_vm._v(" O : ")]
                                ),
                                _vm._v(" "),
                                sampleItem.operator_approval_status
                                  .status_color == "yellow"
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-yellow-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .operator_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                                  : sampleItem.operator_approval_status
                                      .status_color == "green"
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-green-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .operator_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                                  : sampleItem.operator_approval_status
                                      .status_color == "red"
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-red-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .operator_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                                  : _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-gray-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .operator_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass: "tw-py-1",
                                staticStyle: {
                                  "border-bottom": "1px solid #eee"
                                }
                              },
                              [
                                _c(
                                  "span",
                                  { staticClass: "tw-font-semibold" },
                                  [_vm._v(" S : ")]
                                ),
                                _vm._v(" "),
                                sampleItem.supervisor_approval_status
                                  .status_color == "yellow"
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-yellow-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .supervisor_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                                  : sampleItem.supervisor_approval_status
                                      .status_color == "green"
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-green-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .supervisor_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                                  : sampleItem.supervisor_approval_status
                                      .status_color == "red"
                                  ? _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-red-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .supervisor_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                                  : _c(
                                      "span",
                                      {
                                        staticClass:
                                          "tw-text-gray-600 tw-text-xs tw-font-semibold"
                                      },
                                      [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              sampleItem
                                                .supervisor_approval_status
                                                .status_desc
                                            ) +
                                            " "
                                        )
                                      ]
                                    )
                              ]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "tw-pt-1" }, [
                              _c("span", { staticClass: "tw-font-semibold" }, [
                                _vm._v(" L : ")
                              ]),
                              _vm._v(" "),
                              sampleItem.leader_approval_status.status_color ==
                              "yellow"
                                ? _c(
                                    "span",
                                    {
                                      staticClass:
                                        "tw-text-yellow-600 tw-text-xs tw-font-semibold"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.leader_approval_status
                                              .status_desc
                                          ) +
                                          " "
                                      )
                                    ]
                                  )
                                : sampleItem.leader_approval_status
                                    .status_color == "green"
                                ? _c(
                                    "span",
                                    {
                                      staticClass:
                                        "tw-text-green-600 tw-text-xs tw-font-semibold"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.leader_approval_status
                                              .status_desc
                                          ) +
                                          " "
                                      )
                                    ]
                                  )
                                : sampleItem.leader_approval_status
                                    .status_color == "red"
                                ? _c(
                                    "span",
                                    {
                                      staticClass:
                                        "tw-text-red-600 tw-text-xs tw-font-semibold"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.leader_approval_status
                                              .status_desc
                                          ) +
                                          " "
                                      )
                                    ]
                                  )
                                : _c(
                                    "span",
                                    {
                                      staticClass:
                                        "tw-text-gray-600 tw-text-xs tw-font-semibold"
                                    },
                                    [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            sampleItem.leader_approval_status
                                              .status_desc
                                          ) +
                                          " "
                                      )
                                    ]
                                  )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            _vm.showType == "result" &&
                            _vm.isAllowEdit(sampleItem, _vm.approvalRole)
                              ? [
                                  _c("textarea", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: sampleItem.remark,
                                        expression: "sampleItem.remark"
                                      }
                                    ],
                                    staticClass:
                                      "form-control input-sm tw-text-xs text-left",
                                    staticStyle: {
                                      "max-height": "70px",
                                      height: "70px"
                                    },
                                    attrs: { rows: "2", placeholder: "" },
                                    domProps: { value: sampleItem.remark },
                                    on: {
                                      blur: function($event) {
                                        return _vm.onSampleRemarkChanged(
                                          $event,
                                          sampleItem
                                        )
                                      },
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          sampleItem,
                                          "remark",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  })
                                ]
                              : [
                                  _c(
                                    "pre",
                                    {
                                      staticClass:
                                        "text-left tw-bg-white tw-border-none tw-text-xs"
                                    },
                                    [_vm._v(_vm._s(sampleItem.remark))]
                                  )
                                ]
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.severity_level_minor == "true"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check tw-text-blue-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.severity_level_major == "true"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check tw-text-yellow-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.severity_level_critical == "true"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check tw-text-red-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.test_serverity_code_minor == "true"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check tw-text-blue-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.test_serverity_code_major == "true"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check tw-text-yellow-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            sampleItem.test_serverity_code_critical == "true"
                              ? _c("span", {
                                  staticClass:
                                    "fa fa-2x fa-check tw-text-red-500"
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "text-center md:tw-table-cell tw-hidden"
                          },
                          [
                            _vm.showType == "result"
                              ? _c("div", [
                                  _vm._v(
                                    "\n                            -\n                        "
                                  )
                                ])
                              : _c("div", [
                                  _vm._v(
                                    "\n                            -\n                        "
                                  )
                                ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          {
                            staticClass:
                              "freeze-col-right text-center text-nowrap",
                            staticStyle: { "min-width": "100px" }
                          },
                          [
                            _c("div", { staticClass: "freeze-col-content" }, [
                              _c("div", { staticClass: "tw-pb-2" }, [
                                _c(
                                  "button",
                                  {
                                    staticClass:
                                      "btn btn-sm btn-default tw-text-xs tw-w-20",
                                    on: {
                                      click: function($event) {
                                        return _vm.onResultButtonClicked(
                                          sampleItem.sample_no,
                                          sampleItem.organization_id,
                                          sampleItem.inventory_item_id,
                                          $event
                                        )
                                      }
                                    }
                                  },
                                  [
                                    _c("i", { staticClass: "fa fa-edit" }),
                                    _vm._v(
                                      " Result\n                                "
                                    )
                                  ]
                                )
                              ]),
                              _vm._v(" "),
                              (_vm.showType == "result" ||
                                _vm.showType == "approval") &&
                              _vm.isAllowApproval(sampleItem, _vm.approvalRole)
                                ? _c(
                                    "div",
                                    {
                                      staticClass: "tw-pt-2",
                                      staticStyle: {
                                        "border-top": "1px solid #eee"
                                      }
                                    },
                                    [
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-sm btn-success tw-text-xs tw-w-20",
                                          on: {
                                            click: function($event) {
                                              return _vm.onApproveSampleClicked(
                                                sampleItem,
                                                _vm.approvalRole,
                                                $event
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-check-square-o "
                                          }),
                                          _vm._v(
                                            " Approve\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.showType == "result" ||
                                _vm.showType == "approval") &&
                              _vm.isAllowRejectApproval(
                                sampleItem,
                                _vm.approvalRole
                              )
                                ? _c("div", { staticClass: "tw-pt-2" }, [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-sm btn-danger tw-text-xs tw-w-20",
                                        on: {
                                          click: function($event) {
                                            return _vm.onRejectSampleClicked(
                                              sampleItem,
                                              _vm.approvalRole,
                                              $event
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", { staticClass: "fa fa-times" }),
                                        _vm._v(
                                          " Reject\n                                "
                                        )
                                      ]
                                    )
                                  ])
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.showType == "result" ||
                                _vm.showType == "approval") &&
                              _vm.isAllowReturnApproval(
                                sampleItem,
                                _vm.approvalRole
                              )
                                ? _c("div", { staticClass: "tw-pt-2" }, [
                                    _c(
                                      "button",
                                      {
                                        staticClass:
                                          "btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-20",
                                        on: {
                                          click: function($event) {
                                            return _vm.onReturnSampleClicked(
                                              sampleItem,
                                              _vm.approvalRole,
                                              $event
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-reply "
                                        }),
                                        _vm._v(
                                          " Return\n                                "
                                        )
                                      ]
                                    )
                                  ])
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.showType == "result" ||
                                _vm.showType == "approval") &&
                              _vm.isAllowUnapproveApproval(
                                sampleItem,
                                _vm.approvalRole
                              )
                                ? _c(
                                    "div",
                                    {
                                      staticClass: "tw-pt-2",
                                      staticStyle: {
                                        "border-top": "1px solid #eee"
                                      }
                                    },
                                    [
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-24",
                                          on: {
                                            click: function($event) {
                                              return _vm.onUnapproveSampleClicked(
                                                sampleItem,
                                                _vm.approvalRole,
                                                $event
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-times "
                                          }),
                                          _vm._v(
                                            " Unapprove\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ])
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      sampleItem.specification_showed
                        ? _c("tr", { key: index + "_line" }, [
                            _c(
                              "td",
                              { attrs: { colspan: "17" } },
                              [
                                _c("qm-table-finished-product-results", {
                                  attrs: {
                                    "auth-user": _vm.authUser,
                                    "show-type": _vm.showType,
                                    "list-brands": _vm.listBrands,
                                    "list-test-serverity-codes":
                                      _vm.listTestServerityCodes,
                                    "approval-data": _vm.approvalData,
                                    "approval-role": _vm.approvalRole,
                                    sample: sampleItem,
                                    items: sampleItem.specifications,
                                    "result-header-items":
                                      sampleItem.resultHeaders,
                                    "result-items": sampleItem.results,
                                    "result-item-lines": sampleItem.resultLines,
                                    attachments: sampleItem.attachments,
                                    "default-data": sampleItem.defaultData
                                  },
                                  on: {
                                    onSampleResultSubmitted:
                                      _vm.onSampleResultSubmitted,
                                    onCancelSampleResult:
                                      _vm.onCancelSampleResult
                                  }
                                })
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c("td", { attrs: { colspan: "2" } })
                          ])
                        : _vm._e()
                    ]
                  })
                ],
                2
              )
            : _c("tbody", [_vm._m(2)])
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
      "th",
      {
        staticClass: "freeze-col",
        staticStyle: { "min-width": "300px" },
        attrs: { rowspan: "2" }
      },
      [
        _c("div", { staticClass: "freeze-col-content" }, [
          _c(
            "div",
            {
              staticClass:
                "text-center tw-text-xs tw-inline-block tw-align-top tw-py-6",
              staticStyle: { "min-width": "60px", "max-width": "60px" }
            },
            [
              _vm._v(
                "\n                            ลำดับที่\n                        "
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "text-center tw-text-xs tw-inline-block tw-align-top tw-py-6",
              staticStyle: {
                "min-height": "50px",
                "min-width": "190px",
                "max-width": "190px",
                "border-left": "1px solid #ddd"
              }
            },
            [
              _vm._v(
                "\n                            เลขที่การตรวจสอบ\n                        "
              )
            ]
          )
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "th",
        {
          staticClass: "tw-text-xs text-center md:tw-table-cell tw-hidden",
          staticStyle: { top: "2.55rem" },
          attrs: { width: "6%" }
        },
        [_vm._v(" Minor ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "tw-text-xs text-center md:tw-table-cell tw-hidden",
          staticStyle: { top: "2.55rem" },
          attrs: { width: "6%" }
        },
        [_vm._v(" Major ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "tw-text-xs text-center md:tw-table-cell tw-hidden",
          staticStyle: { top: "2.55rem" },
          attrs: { width: "6%" }
        },
        [_vm._v(" Critical ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "tw-text-xs text-center md:tw-table-cell tw-hidden",
          staticStyle: { top: "2.55rem" },
          attrs: { width: "6%" }
        },
        [_vm._v(" Minor ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "tw-text-xs text-center md:tw-table-cell tw-hidden",
          staticStyle: { top: "2.55rem" },
          attrs: { width: "6%" }
        },
        [_vm._v(" Major ")]
      ),
      _vm._v(" "),
      _c(
        "th",
        {
          staticClass: "tw-text-xs text-center md:tw-table-cell tw-hidden",
          staticStyle: { top: "2.55rem" },
          attrs: { width: "6%" }
        },
        [_vm._v(" Critical ")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "17" } }, [
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