(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_PM0025_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _commonDialogs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../commonDialogs */ "./resources/js/commonDialogs.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['headers', 'lines', 'distributions', 'steps'],
  data: function data() {
    return {
      header: {
        batch_no: '',
        product_type: '',
        item_code: '',
        item_desc: '',
        request_qty: '',
        uom: '',
        blend_no: '',
        start_date: '',
        product_qty: ''
      },
      lookupSteps: [],
      stepCode: '',
      stepDesc: '',
      selectedLines: [],
      displayProdDate: '',
      selectedDistributions: [],
      lineIdx: ''
    };
  },
  // mounted() {
  //     console.log(this.distributions)
  // },
  computed: {
    sumTotal1: function sumTotal1() {
      var _this = this;

      var total = 0;
      this.selectedDistributions.forEach(function (dist, i) {
        total += _this.total1(i);
      });
      return total;
    },
    sumTotalLoss: function sumTotalLoss() {
      var total = 0;
      this.selectedDistributions.forEach(function (distribution) {
        if (distribution.loss_qty > 0) {
          total += parseInt(distribution.loss_qty);
        }
      });
      return total;
    },
    sumTotalResultLoss: function sumTotalResultLoss() {
      var total = 0;
      this.selectedDistributions.forEach(function (distribution) {
        if (distribution.result_loss_qty > 0) {
          total += parseInt(distribution.result_loss_qty);
        }
      });

      if (this.lineIdx != null) {
        this.selectedLines[this.lineIdx].loss_qty = total;
      }

      return total;
    },
    sumTotalSample: function sumTotalSample() {
      var total = 0;
      this.selectedDistributions.forEach(function (distribution) {
        total += 0;

        if (distribution.sample_qty > 0) {
          total += parseInt(distribution.sample_qty);
        }
      });
      return total;
    },
    sumTotalProd: function sumTotalProd() {
      var _this2 = this;

      var total = 0;
      this.selectedDistributions.forEach(function (dist, i) {
        total += _this2.total2(i);
      });

      if (this.lineIdx != null) {
        this.selectedLines[this.lineIdx].product_qty = total;
      }

      return total;
    }
  },
  methods: {
    resetForm: function resetForm() {
      // console.log('resetForm')
      this.header = {
        batch_no: '',
        product_type: '',
        item_code: '',
        item_desc: '',
        request_qty: '',
        uom: '',
        blend_no: '',
        start_date: '',
        product_qty: ''
      }, this.lookupSteps = [];
      this.stepCode = '';
      this.stepDesc = '';
      this.selectedLines = [];
      this.displayProdDate = '';
      this.selectedDistributions = [];
    },
    validate: function validate() {
      var errors = [];

      if (!this.header.batch_no) {
        errors.push('ยังไม่ได้เลือก Header');
      }

      if (this.selectedLines.length == 0) {
        errors.push('ยังไม่ได้เลือก Line');
      }

      if (this.selectedDistributions.length == 0) {
        errors.push('ยังไม่ได้เลือก Distribution');
      }

      if (errors.length > 0) {
        (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_1__.showValidationFailedDialog)(errors);
        return false;
      }

      return true;
    },
    saveForm: function saveForm() {
      var showSaveSuccessDialogWhenDone = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
      console.log('saveForm!!!');

      if (!this.validate()) {
        return;
      }

      var params = {
        header: this.header,
        lines: this.selectedLines,
        distributions: this.selectedDistributions
      };
      return axios.put('/api/pm/pm0025/' + this.header.batch_id, params).then(function (response) {
        if (response.status == 200) {
          // this.setterData(response.data)
          console.log(response);
          if (showSaveSuccessDialogWhenDone) (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_1__.showSaveSuccessDialog)();
        }
      })["catch"](function (error) {
        swal.close();
        console.log(error);
      });
    },
    // calTransferQty(idx) {
    //     let transferQty = 0
    //     if(this.selectedLines[idx].receive_wip > 0) {
    //         transferQty += parseInt(this.selectedLines[idx].receive_wip)
    //     }
    //     if(this.selectedLines[idx].product_qty > 0) {
    //         transferQty += parseInt(this.selectedLines[idx].product_qty)
    //     }
    //     if(this.selectedLines[idx].loss_qty > 0) {
    //         transferQty -= parseInt(this.selectedLines[idx].loss_qty)
    //     }
    //     if(this.selectedLines[idx].transfer_qty > 0) {
    //         transferQty -= parseInt(this.selectedLines[idx].transfer_qty)
    //     }
    //     this.selectedLines[idx].transfer_wip = transferQty
    //     if(this.selectedLines[idx + 1]) {
    //         this.selectedLines[idx + 1].receive_wip = transferQty
    //         this.calTransferQty(idx + 1)
    //     }
    // },
    // updProdQty(idx) {
    //     let prodQty = 0
    //     if(this.selectedDistributions[idx].result_qty_01 > 0) {
    //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_01)
    //     }
    //     if(this.selectedDistributions[idx].result_qty_02 > 0) {
    //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_02)
    //     }
    //     if(this.selectedDistributions[idx].result_qty_03 > 0) {
    //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_03)
    //     }
    //     if(this.selectedDistributions[idx].result_qty_04 > 0) {
    //         prodQty += parseInt(this.selectedDistributions[idx].result_qty_04)
    //     }
    //     // add for pm0025
    //     if(this.selectedDistributions[idx].sample_qty > 0) {
    //         prodQty += parseInt(this.selectedDistributions[idx].sample_qty)
    //     }
    //     this.selectedDistributions[idx].product_qty = prodQty
    // },
    onChangeLookupHeader: function onChangeLookupHeader() {
      var _this3 = this;

      this.lookupSteps = [];
      var idx = this.headers.findIndex(function (header) {
        return header.batch_no == _this3.header.batch_no;
      });
      this.header = this.headers[idx];
      var steps = this.lines.filter(function (line) {
        return line.batch_id == _this3.header.batch_id;
      });

      var distinctSteps = _toConsumableArray(new Set(steps.map(function (line) {
        return line.wip_step;
      })));

      distinctSteps.map(function (step) {
        return _this3.lookupSteps.push({
          code: step
        });
      }); // console.log(this.selectedLines)
    },
    onChangeLookupStep: function onChangeLookupStep() {
      var _this4 = this;

      var idx = this.steps.findIndex(function (step) {
        return step.lookup_code == _this4.stepCode;
      });
      this.stepDesc = idx >= 0 ? this.steps[idx].meaning : '-';
      this.selectedLines = [];
      this.selectedLines = this.lines.filter(function (line) {
        return line.batch_id == _this4.header.batch_id && line.wip_step == _this4.stepCode;
      });
      this.selectedDistributions = [];
    },
    selectLine: function selectLine(batchId, productDate, wipStep, lineIdx) {
      var _this5 = this;

      // console.log('batchId => ' + batchId + ' productDate => ' + productDate + ' wipStep => ' + wipStep + ' lineIdx => ' + lineIdx)
      this.displayProdDate = productDate;
      this.lineIdx = lineIdx;
      this.selectedDistributions = this.distributions.filter(function (distribution) {
        return distribution.batch_id == _this5.header.batch_id && distribution.product_date == productDate && distribution.wip_step == wipStep;
      });
    },
    onClickUseProd: function onClickUseProd(distributionIdx) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return _this6.saveForm(false);

              case 2:
                params = {
                  batch_id: _this6.selectedDistributions[distributionIdx].batch_id,
                  wip_step: _this6.selectedDistributions[distributionIdx].wip_step,
                  product_date: _this6.selectedDistributions[distributionIdx].product_date,
                  machine_set: _this6.selectedDistributions[distributionIdx].machine_set
                };
                axios.put('/api/pm/transaction-pkg-product', params).then(function (response) {
                  if (response.status == 200) {
                    // this.setterData(response.data)
                    _this6.selectedDistributions[distributionIdx].transaction_flag = true;

                    _this6.setLineTxFlg();

                    console.log(response);
                    (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_1__.showSaveSuccessDialog)();
                  }
                })["catch"](function (error) {
                  console.log(error);
                });

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    setLineTxFlg: function setLineTxFlg() {
      var lineTxFlg = true;
      this.selectedDistributions.forEach(function (distribution) {
        if (!distribution.transaction_flag) {
          lineTxFlg = false;
        }
      });
      this.selectedLines[this.lineIdx].transaction_flag = lineTxFlg;
    },
    total1: function total1(distIdx) {
      var total = 0;

      if (this.selectedDistributions[distIdx].result_qty_01 > 0) {
        total += parseInt(this.selectedDistributions[distIdx].result_qty_01);
      }

      if (this.selectedDistributions[distIdx].result_qty_02 > 0) {
        total += parseInt(this.selectedDistributions[distIdx].result_qty_02);
      }

      if (this.selectedDistributions[distIdx].result_qty_03 > 0) {
        total += parseInt(this.selectedDistributions[distIdx].result_qty_03);
      }

      if (this.selectedDistributions[distIdx].result_qty_04 > 0) {
        total += parseInt(this.selectedDistributions[distIdx].result_qty_04);
      } // add for pm0025
      // if(this.selectedDistributions[idx].sample_qty > 0) {
      //     prodQty += parseInt(this.selectedDistributions[idx].sample_qty)
      // }


      return total; // this.selectedDistributions[idx].product_qty = prodQty
    },
    total2: function total2(distIdx) {
      var total1 = this.total1(distIdx);
      var sampleQty = this.selectedDistributions[distIdx].sample_qty > 0 ? this.selectedDistributions[distIdx].sample_qty : 0;
      var total2 = parseInt(total1) + parseInt(sampleQty);
      return total2;
    },
    totalTranWip: function totalTranWip(idx) {
      var total = 0;

      if (this.selectedLines[idx].receive_wip > 0) {
        total += parseInt(this.selectedLines[idx].receive_wip);
      }

      if (this.selectedLines[idx].product_qty > 0) {
        total += parseInt(this.selectedLines[idx].product_qty);
      }

      if (this.selectedLines[idx].loss_qty > 0) {
        total -= parseInt(this.selectedLines[idx].loss_qty);
      }

      if (this.selectedLines[idx].transfer_qty > 0) {
        total -= parseInt(this.selectedLines[idx].transfer_qty);
      }

      this.selectedLines[idx].transfer_wip = total;

      if (this.selectedLines[idx + 1]) {
        this.selectedLines[idx + 1].receive_wip = total;
        this.totalTranWip(idx + 1);
      }

      return total;
    }
  }
});

/***/ }),

/***/ "./resources/js/commonDialogs.js":
/*!***************************************!*\
  !*** ./resources/js/commonDialogs.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showSimpleConfirmationDialog": () => /* binding */ showSimpleConfirmationDialog,
/* harmony export */   "showProgressWithUnsavedChangesWarningDialog": () => /* binding */ showProgressWithUnsavedChangesWarningDialog,
/* harmony export */   "showValidationFailedDialog": () => /* binding */ showValidationFailedDialog,
/* harmony export */   "showLoadingDialog": () => /* binding */ showLoadingDialog,
/* harmony export */   "showSaveSuccessDialog": () => /* binding */ showSaveSuccessDialog,
/* harmony export */   "showSaveFailureDialog": () => /* binding */ showSaveFailureDialog,
/* harmony export */   "showGenericFailureDialog": () => /* binding */ showGenericFailureDialog,
/* harmony export */   "showRemoveLineConfirmationDialog": () => /* binding */ showRemoveLineConfirmationDialog
/* harmony export */ });
function showSimpleConfirmationDialog(title) {
  return new Promise(function (resolve) {
    swal({
      title: title,
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ยืนยัน'
    }, function (value) {
      resolve(value);
    });
  });
}
function showProgressWithUnsavedChangesWarningDialog() {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E04\u0E38\u0E13\u0E41\u0E19\u0E48\u0E43\u0E08\u0E44\u0E2B\u0E21?",
      // new line is a workaround for icon cover text
      text: 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก คุณต้องการดำเนินการต่อหรือไม่',
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ดำเนินการต่อ',
      allowClickOutside: true,
      closeOnClickOutside: true
    }, function (value) {
      resolve(value);
    });
  });
}
function showValidationFailedDialog(errorMessages) {
  var errorText = '<div style="text-align:left;">' + 'ข้อมูลที่คุณใส่ไม่ถูกต้องหรือไม่ครบถ้วน กรุณาตรวจสอบข้อมูลและลองใหม่อีกครั้ง<br/><br/>' + '</div>';
  errorText += '<div style="text-align:left;color:red">';
  errorText += '<ul>';
  errorMessages.forEach(function (message) {
    errorText += "<li>".concat(message, "<br/></li>");
  });
  errorText += '</ul>';
  errorText += '</div>';
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      html: true,
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ตกลง'
    }, function (value) {
      resolve(value);
    });
  });
}
function showLoadingDialog() {
  console.debug('showLoadingDialog');
  return new Promise(function (resolve) {
    swal({
      // new line is a workaround for icon cover text
      title: "\n                    <div class=\"sk-spinner sk-spinner-wave mb-4\">\n                        <div class=\"sk-rect1\"></div>\n                        <div class=\"sk-rect2\"></div>\n                        <div class=\"sk-rect3\"></div>\n                        <div class=\"sk-rect4\"></div>\n                        <div class=\"sk-rect5\"></div>\n                    </div>\n                    \u0E01\u0E33\u0E25\u0E31\u0E07\u0E14\u0E33\u0E40\u0E19\u0E34\u0E19\u0E01\u0E32\u0E23\n                    ",
      html: true,
      showConfirmButton: false,
      closeOnConfirm: false
    }, function (value) {
      resolve(value);
    });
  });
}
function showSaveSuccessDialog() {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08",
      // new line is a workaround for icon cover text
      text: 'บันทึกข้อมูลเรียบร้อย',
      type: 'success',
      dangerMode: false,
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showSaveFailureDialog() {
  var errorText = "\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14\u0E40\u0E01\u0E34\u0E14\u0E02\u0E36\u0E49\u0E19 \u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E14\u0E49 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E25\u0E2D\u0E07\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07\n";
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showGenericFailureDialog() {
  var errorText = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14\u0E40\u0E01\u0E34\u0E14\u0E02\u0E36\u0E49\u0E19 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E25\u0E2D\u0E07\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07\n";
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showRemoveLineConfirmationDialog(rowCount) {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E04\u0E38\u0E13\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E17\u0E35\u0E48\u0E16\u0E39\u0E01\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14 ".concat(rowCount, " \u0E41\u0E16\u0E27\u0E43\u0E0A\u0E48\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48?"),
      // new line is a workaround for icon cover text
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ยืนยัน'
    }, function (value) {
      resolve(value);
    });
  });
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".table tbody tr.disable {\n  background-color: #F2F2F2;\n}\n.table td.g {\n  background-color: #F2F2F2;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0025.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/pages/PM0025.vue":
/*!******************************************!*\
  !*** ./resources/js/pm/pages/PM0025.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PM0025_vue_vue_type_template_id_b6a90ea2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PM0025.vue?vue&type=template&id=b6a90ea2& */ "./resources/js/pm/pages/PM0025.vue?vue&type=template&id=b6a90ea2&");
/* harmony import */ var _PM0025_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PM0025.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/PM0025.vue?vue&type=script&lang=js&");
/* harmony import */ var _PM0025_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PM0025.vue?vue&type=style&index=0&lang=css& */ "./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _PM0025_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PM0025_vue_vue_type_template_id_b6a90ea2___WEBPACK_IMPORTED_MODULE_0__.render,
  _PM0025_vue_vue_type_template_id_b6a90ea2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/PM0025.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/PM0025.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/pm/pages/PM0025.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0025.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0025.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/pm/pages/PM0025.vue?vue&type=template&id=b6a90ea2&":
/*!*************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0025.vue?vue&type=template&id=b6a90ea2& ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_template_id_b6a90ea2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_template_id_b6a90ea2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0025_vue_vue_type_template_id_b6a90ea2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0025.vue?vue&type=template&id=b6a90ea2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=template&id=b6a90ea2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=template&id=b6a90ea2&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0025.vue?vue&type=template&id=b6a90ea2& ***!
  \****************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-lg-12" }, [
      _c("div", { staticClass: "ibox " }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-9" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "ระบุเลขที่คำสั่งผลิต",
                          loading: false
                        },
                        on: { change: _vm.onChangeLookupHeader },
                        model: {
                          value: _vm.header.batch_no,
                          callback: function($$v) {
                            _vm.$set(_vm.header, "batch_no", $$v)
                          },
                          expression: "header.batch_no"
                        }
                      },
                      _vm._l(this.headers, function(lookupHeader) {
                        return _c("el-option", {
                          key: lookupHeader.batch_no,
                          attrs: {
                            label: lookupHeader.batch_no,
                            value: lookupHeader.batch_no
                          }
                        })
                      }),
                      1
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  { staticClass: "col-lg-3 col-sm-4 col-form-label" },
                  [_vm._v("สินค้าที่จะผลิต:")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-lg-6" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.header.item_code,
                            expression: "header.item_code"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.header.item_code },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.header,
                              "item_code",
                              $event.target.value
                            )
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
                            value: _vm.header.item_desc,
                            expression: "header.item_desc"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.header.item_desc },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.header,
                              "item_desc",
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
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  { staticClass: "col-lg-3 col-sm-4 col-form-label" },
                  [_vm._v("จำนวนที่สั่งผลิต:")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-lg-6" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.header.request_qty,
                            expression: "header.request_qty"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.header.request_qty },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.header,
                              "request_qty",
                              $event.target.value
                            )
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
                            value: _vm.header.uom,
                            expression: "header.uom"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.header.uom },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.header, "uom", $event.target.value)
                          }
                        }
                      })
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(2),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      { staticClass: "col-lg-6" },
                      [
                        _c(
                          "el-select",
                          {
                            attrs: {
                              filterable: "",
                              remote: "",
                              placeholder: "ระบุขั้นตอนการทำงาน",
                              loading: false,
                              disabled: _vm.header.batch_no == ""
                            },
                            on: { change: _vm.onChangeLookupStep },
                            model: {
                              value: _vm.stepCode,
                              callback: function($$v) {
                                _vm.stepCode = $$v
                              },
                              expression: "stepCode"
                            }
                          },
                          _vm._l(this.lookupSteps, function(step) {
                            return _c("el-option", {
                              key: step.code,
                              attrs: { label: step.code, value: step.code }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-lg-6" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.stepDesc,
                            expression: "stepDesc"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.stepDesc },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.stepDesc = $event.target.value
                          }
                        }
                      })
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  { staticClass: "col-lg-3 col-sm-4 col-form-label" },
                  [_vm._v("ประเภทคำสั่งผลิต:")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.header.product_type,
                        expression: "header.product_type"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { disabled: "" },
                    domProps: { value: _vm.header.product_type },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.header,
                          "product_type",
                          $event.target.value
                        )
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  { staticClass: "col-lg-3 col-sm-4 col-form-label" },
                  [_vm._v("Blend No.:")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.header.blend_no,
                        expression: "header.blend_no"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { disabled: "" },
                    domProps: { value: _vm.header.blend_no },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.header, "blend_no", $event.target.value)
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  { staticClass: "col-lg-3 col-sm-4 col-form-label" },
                  [_vm._v("วันที่เริ่มผลิต:")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.header.start_date,
                        expression: "header.start_date"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { disabled: "" },
                    domProps: { value: _vm.header.start_date },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.header, "start_date", $event.target.value)
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  { staticClass: "col-lg-3 col-sm-4 col-form-label" },
                  [_vm._v("ผลผลิตที่ได้:")]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-9" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-lg-8" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.header.product_qty,
                            expression: "header.product_qty"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.header.product_qty },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.header,
                              "product_qty",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-lg-4" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.header.uom,
                            expression: "header.uom"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: { type: "text", disabled: "" },
                        domProps: { value: _vm.header.uom },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.header, "uom", $event.target.value)
                          }
                        }
                      })
                    ])
                  ])
                ])
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "text-right" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-default",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.resetForm($event)
              }
            }
          },
          [
            _c("i", { staticClass: "fa fa-refresh" }),
            _vm._v("\n                ล้างค่า\n            ")
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "btn btn-primary",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.saveForm($event)
              }
            }
          },
          [
            _c("i", { staticClass: "fa fa-save" }),
            _vm._v("\n                บันทึก\n            ")
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ibox" }, [
        _vm._m(3),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table table-bordered" }, [
              _vm._m(4),
              _vm._v(" "),
              _vm.selectedLines.length
                ? _c(
                    "tbody",
                    _vm._l(_vm.selectedLines, function(line, lineIdx) {
                      return _c(
                        "tr",
                        {
                          key: lineIdx,
                          class: { disable: line.transaction_flag }
                        },
                        [
                          _c("td", { staticClass: "g" }, [
                            _c(
                              "a",
                              {
                                staticClass: "text-info",
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.selectLine(
                                      line.batch_id,
                                      line.product_date,
                                      line.wip_step,
                                      lineIdx
                                    )
                                  }
                                }
                              },
                              [_vm._v(_vm._s(line.product_date))]
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "g" }, [
                            _vm._v(_vm._s(line.receive_wip))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "g" }, [
                            _vm._v(_vm._s(line.product_qty))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "g" }, [
                            _vm._v(_vm._s(line.loss_qty))
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: line.transfer_qty,
                                  expression: "line.transfer_qty"
                                }
                              ],
                              staticClass: "form-control form-control-sm",
                              attrs: {
                                type: "number",
                                disabled: line.transaction_flag,
                                min: "0"
                              },
                              domProps: { value: line.transfer_qty },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    line,
                                    "transfer_qty",
                                    $event.target.value
                                  )
                                }
                              }
                            })
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "g" }, [
                            _vm._v(_vm._s(_vm.totalTranWip(lineIdx)))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "g" }, [
                            _vm._v(_vm._s(line.uom))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "g" }, [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: line.transaction_flag,
                                  expression: "line.transaction_flag"
                                }
                              ],
                              attrs: { type: "checkbox", disabled: "" },
                              domProps: {
                                checked: Array.isArray(line.transaction_flag)
                                  ? _vm._i(line.transaction_flag, null) > -1
                                  : line.transaction_flag
                              },
                              on: {
                                change: function($event) {
                                  var $$a = line.transaction_flag,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        _vm.$set(
                                          line,
                                          "transaction_flag",
                                          $$a.concat([$$v])
                                        )
                                    } else {
                                      $$i > -1 &&
                                        _vm.$set(
                                          line,
                                          "transaction_flag",
                                          $$a
                                            .slice(0, $$i)
                                            .concat($$a.slice($$i + 1))
                                        )
                                    }
                                  } else {
                                    _vm.$set(line, "transaction_flag", $$c)
                                  }
                                }
                              }
                            })
                          ])
                        ]
                      )
                    }),
                    0
                  )
                : _c("tbody", [_vm._m(5)])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ibox" }, [
        _c("div", { staticClass: "ibox-title" }, [
          _c("h3", [
            _vm._v(
              "บันทึกผลผลิตรายวันรายเครื่อง " + _vm._s(_vm.displayProdDate)
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table table-bordered" }, [
              _vm._m(6),
              _vm._v(" "),
              _vm.selectedDistributions.length
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.selectedDistributions, function(
                        distribution,
                        distributionIdx
                      ) {
                        return _c(
                          "tr",
                          {
                            key: distributionIdx,
                            class: { disable: distribution.transaction_flag }
                          },
                          [
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.machine_set))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.machine_number))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.qty_01))
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: distribution.result_qty_01,
                                    expression: "distribution.result_qty_01"
                                  }
                                ],
                                staticClass: "form-control form-control-sm",
                                attrs: {
                                  type: "number",
                                  disabled: distribution.transaction_flag,
                                  min: "0"
                                },
                                domProps: { value: distribution.result_qty_01 },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      distribution,
                                      "result_qty_01",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.qty_02))
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: distribution.result_qty_02,
                                    expression: "distribution.result_qty_02"
                                  }
                                ],
                                staticClass: "form-control form-control-sm",
                                attrs: {
                                  type: "number",
                                  disabled: distribution.transaction_flag,
                                  min: "0"
                                },
                                domProps: { value: distribution.result_qty_02 },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      distribution,
                                      "result_qty_02",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.qty_03))
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: distribution.result_qty_03,
                                    expression: "distribution.result_qty_03"
                                  }
                                ],
                                staticClass: "form-control form-control-sm",
                                attrs: {
                                  type: "number",
                                  disabled: distribution.transaction_flag,
                                  min: "0"
                                },
                                domProps: { value: distribution.result_qty_03 },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      distribution,
                                      "result_qty_03",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.qty_04))
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              { class: { g: distribution.qty_04 == null } },
                              [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: distribution.result_qty_04,
                                      expression: "distribution.result_qty_04"
                                    }
                                  ],
                                  staticClass: "form-control form-control-sm",
                                  attrs: {
                                    type: "number",
                                    disabled:
                                      distribution.transaction_flag ||
                                      distribution.qty_04 == null,
                                    min: "0"
                                  },
                                  domProps: {
                                    value: distribution.result_qty_04
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        distribution,
                                        "result_qty_04",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ]
                            ),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(_vm.total1(distributionIdx)))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.loss_qty))
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: distribution.result_loss_qty,
                                    expression: "distribution.result_loss_qty"
                                  }
                                ],
                                staticClass: "form-control form-control-sm",
                                attrs: {
                                  type: "number",
                                  disabled: distribution.transaction_flag,
                                  min: "0"
                                },
                                domProps: {
                                  value: distribution.result_loss_qty
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      distribution,
                                      "result_loss_qty",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: distribution.sample_qty,
                                    expression: "distribution.sample_qty"
                                  }
                                ],
                                staticClass: "form-control form-control-sm",
                                attrs: {
                                  type: "number",
                                  disabled: distribution.transaction_flag,
                                  min: "0"
                                },
                                domProps: { value: distribution.sample_qty },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      distribution,
                                      "sample_qty",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(_vm.total2(distributionIdx)))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _vm._v(_vm._s(distribution.unit_of_measure))
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "g" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: distribution.transaction_flag,
                                    expression: "distribution.transaction_flag"
                                  }
                                ],
                                attrs: { type: "checkbox", disabled: "" },
                                domProps: {
                                  checked: Array.isArray(
                                    distribution.transaction_flag
                                  )
                                    ? _vm._i(
                                        distribution.transaction_flag,
                                        null
                                      ) > -1
                                    : distribution.transaction_flag
                                },
                                on: {
                                  change: function($event) {
                                    var $$a = distribution.transaction_flag,
                                      $$el = $event.target,
                                      $$c = $$el.checked ? true : false
                                    if (Array.isArray($$a)) {
                                      var $$v = null,
                                        $$i = _vm._i($$a, $$v)
                                      if ($$el.checked) {
                                        $$i < 0 &&
                                          _vm.$set(
                                            distribution,
                                            "transaction_flag",
                                            $$a.concat([$$v])
                                          )
                                      } else {
                                        $$i > -1 &&
                                          _vm.$set(
                                            distribution,
                                            "transaction_flag",
                                            $$a
                                              .slice(0, $$i)
                                              .concat($$a.slice($$i + 1))
                                          )
                                      }
                                    } else {
                                      _vm.$set(
                                        distribution,
                                        "transaction_flag",
                                        $$c
                                      )
                                    }
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c(
                                "button",
                                {
                                  staticClass: "btn btn-default",
                                  attrs: {
                                    type: "button",
                                    disabled: distribution.transaction_flag
                                  },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.onClickUseProd(distributionIdx)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "ตัดใช้วัตถุดิบ\n                                "
                                  )
                                ]
                              )
                            ])
                          ]
                        )
                      }),
                      _vm._v(" "),
                      _c("tr", [
                        _c(
                          "td",
                          {
                            staticClass: "g text-right",
                            attrs: { colspan: "10" }
                          },
                          [_vm._v("ยอดรวมทุกเครื่อง")]
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }, [
                          _vm._v(_vm._s(_vm.sumTotal1))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }, [
                          _vm._v(_vm._s(_vm.sumTotalLoss))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }, [
                          _vm._v(_vm._s(_vm.sumTotalResultLoss))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }, [
                          _vm._v(_vm._s(_vm.sumTotalSample))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }, [
                          _vm._v(_vm._s(_vm.sumTotalProd))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }, [
                          _vm._v(_vm._s(_vm.selectedLines[_vm.lineIdx].uom))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" }),
                        _vm._v(" "),
                        _c("td", { staticClass: "g" })
                      ])
                    ],
                    2
                  )
                : _c("tbody", [_vm._m(7)])
            ])
          ])
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h3", [_vm._v("ยืนยันยอดผลผลิตสูญ,สูญเสีย (มวน)")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-3 col-sm-4 col-form-label" }, [
      _vm._v("เลขที่คำสั่งผลิต "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
      _vm._v(":")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-3 col-sm-4 col-form-label" }, [
      _vm._v("ขั้นตอนการทำงาน"),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
      _vm._v(":")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h3", [_vm._v("บันทึกผลผลิตรายวัน")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("วันที่ได้ผลผลิต")]),
        _vm._v(" "),
        _c("th", [_vm._v("คงคลังเช้า")]),
        _vm._v(" "),
        _c("th", [_vm._v("ผลผลิตที่ได้")]),
        _vm._v(" "),
        _c("th", [_vm._v("สูญเสีย")]),
        _vm._v(" "),
        _c("th", [
          _vm._v("จ่ายออก"),
          _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("คงคลังเย็น(WIP)")]),
        _vm._v(" "),
        _c("th", [_vm._v("หน่วยนับ")]),
        _vm._v(" "),
        _c("th", [_vm._v("ตัดใช้วัตถุดิบ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "8" } }, [_vm._v("ไม่มีข้อมูล")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { attrs: { align: "center" } }, [
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("ชุดเครื่องจักร")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "150px" }, attrs: { rowspan: "2" } }, [
          _vm._v("หมายเลขเครื่องจักร")
        ]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "2" } }, [_vm._v("ช่วงเวลา 07.30-11.30")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "2" } }, [_vm._v("ช่วงเวลา 11.30-12.30")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "2" } }, [_vm._v("ช่วงเวลา 12.30-16.30")]),
        _vm._v(" "),
        _c("th", { attrs: { colspan: "2" } }, [
          _vm._v("ช่วงเวลา 16.30เป็นต้นไป")
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("ยอดผลผลิตรวมทั้งวัน")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("ยอดสูญเสียรวมทั้งวัน")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [
          _vm._v("ยืนยันยอดสูญเสียรวมทั้งวัน")
        ]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("จำนวนบุหรี่ตัวอย่าง")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("รวมยอดบุหรี่")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("หน่วยนับ")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } }, [_vm._v("ตัดใช้วัตถุดิบ")]),
        _vm._v(" "),
        _c("th", { attrs: { rowspan: "2" } })
      ]),
      _vm._v(" "),
      _c("tr", { attrs: { align: "center" } }, [
        _c("th", [_vm._v("ผลผลิตที่ได้")]),
        _vm._v(" "),
        _c("th", [_vm._v("ยืนยันยอดผลผลิต")]),
        _vm._v(" "),
        _c("th", [_vm._v("ผลผลิตที่ได้")]),
        _vm._v(" "),
        _c("th", [_vm._v("ยืนยันยอดผลผลิต")]),
        _vm._v(" "),
        _c("th", [_vm._v("ผลผลิตที่ได้")]),
        _vm._v(" "),
        _c("th", [_vm._v("ยืนยันยอดผลผลิต")]),
        _vm._v(" "),
        _c("th", [_vm._v("ผลผลิตที่ได้")]),
        _vm._v(" "),
        _c("th", [_vm._v("ยืนยันยอดผลผลิต")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "18" } }, [_vm._v("ไม่มีข้อมูล")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);