(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_wip-loss-quantity_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _commonDialogs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../commonDialogs */ "./resources/js/commonDialogs.js");
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash/cloneDeep */ "./node_modules/lodash/cloneDeep.js");
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);


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



Vue.filter('formatDate', function (value) {
  if (value) {
    return moment__WEBPACK_IMPORTED_MODULE_3___default()(moment__WEBPACK_IMPORTED_MODULE_3___default()(String(value)).add(543, 'years').toDate()).format('DD/MM/YYYY');
  }
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  created: function created() {
    var _this = this;

    Vue.nextTick(function () {
      _this.setDefaultValue();
    });
  },
  props: ["pHeaders", "url", "transBtn", "transDate"],
  data: function data() {
    return {
      lodash: {
        cloneDeep: (lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_2___default())
      },
      headers: this.pHeaders,
      headerBlendNumbers: {},
      headerOpts: {},
      selectedBlendNo: {},
      selectedOpt: {},
      selectedJob: {},
      jobHeaderLines: {},
      jobLines: {},
      lossQty: null,
      batchNo: null,
      itemNumber: null,
      itemDesc: null,
      uom: null,
      wipStep: null,
      wipStepDesc: null,
      isLoading: false,
      isEditing: false,
      isShowLines: false,
      isOpenFlag: false,
      transactionDate: moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, 'years').toDate(),
      notAfterDate: moment__WEBPACK_IMPORTED_MODULE_3___default()(moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, 'years').toDate()).format(this.transDate['js-format']),
      transactDate: null
    };
  },
  mounted: function mounted() {
    console.log('Component mounted.');
  },
  methods: {
    indexPage: function indexPage() {
      location.href = this.url.wip_loss_quantity_index;
    },
    setdate: function setdate(date, key) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this2;
                vm.transactionDate = date;

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    setDefaultValue: function setDefaultValue() {
      this.transactDate = moment__WEBPACK_IMPORTED_MODULE_3___default()(moment__WEBPACK_IMPORTED_MODULE_3___default()(this.transactionDate).subtract(543, 'years').toDate()).format('YYYY-MM-D');

      if (this.transactDate) {
        this.filterBlendNumbers(this.transactDate);
      }
    },
    onDateChanged: function onDateChanged() {
      if (this.transactionDate) {
        this.transactDate = moment__WEBPACK_IMPORTED_MODULE_3___default()(moment__WEBPACK_IMPORTED_MODULE_3___default()(this.transactionDate).subtract(543, 'years').toDate()).format('YYYY-MM-DD');
        this.filterBlendNumbers(this.transactDate);
      } else {
        this.emptyBlendNoAndOpt();
      }
    },
    filterBlendNumbers: function filterBlendNumbers(transactDate) {
      this.headerBlendNumbers = this.headers.filter(function (header) {
        return header.transaction_date == transactDate;
      });
      console.debug('count.......', Object.keys(this.headerBlendNumbers).length);

      if (Object.keys(this.headerBlendNumbers).length > 0) {
        this.headerBlendNumbers = _.orderBy(this.headerBlendNumbers, 'blend_no', 'asc');
        this.selectedBlendNo = this.headerBlendNumbers[0]['blend_no'];

        if (this.selectedBlendNo) {
          this.filterOpts(this.selectedBlendNo);
        }
      } else {
        this.emptyBlendNoAndOpt();
      }
    },
    onBlendNoChanged: function onBlendNoChanged() {
      console.debug('onBlendNoChanged', this.selectedBlendNo);

      if (this.selectedBlendNo) {
        this.filterOpts(this.selectedBlendNo);
      } else {
        this.emptyOpt();
      }
    },
    filterOpts: function filterOpts(blendNo) {
      console.debug('filterOpts(blendNo)', blendNo);
      this.headerOpts = this.headers.filter(function (header) {
        return header.blend_no == blendNo;
      });

      if (this.headerOpts) {
        this.headerOpts = _.orderBy(this.headerOpts, 'opt', 'asc');
        this.selectedOpt = this.headerOpts[0]['opt'];

        if (this.selectedOpt) {
          this.changeSelectedJob(this.selectedOpt);
        }
      }
    },
    onOptChanged: function onOptChanged() {
      console.debug('onOptChanged', this.selectedOpt);

      if (this.selectedOpt) {
        this.changeSelectedJob(this.selectedOpt);
      } else {
        this.emptyDatas();
      }
    },
    changeSelectedJob: function changeSelectedJob(opt) {
      console.debug('changeSelectedJob', opt);
      this.selectedOpt = opt;
      this.selectedJob = this.headers.find(function (header) {
        return header.opt === opt;
      });

      if (Object.keys(this.selectedJob).length > 0) {
        this.batchNo = this.selectedJob.batch_no;
        this.lossQty = this.selectedJob.loss_qty; // this.itemNumber = this.selectedJob.item_data ?? this.selectedJob.item_data.item_number;
        // this.itemDesc = this.selectedJob.item_data ?? this.selectedJob.item_data.item_desc;
        // this.uom = this.selectedJob.item_data ?? this.selectedJob.item_data.primary_unit_of_measure;
        // this.wipStep = this.selectedJob.wip_steps ?? this.selectedJob.wip_steps[0].oprn_class_desc;
        // this.wipStepDesc = this.selectedJob.wip_steps ?? this.selectedJob.wip_steps[0].oprn_desc;

        this.itemNumber = this.selectedJob.item_data.item_number;
        this.itemDesc = this.selectedJob.item_data.item_desc;
        this.uom = this.selectedJob.item_data.primary_unit_of_measure;
        this.wipStep = this.selectedJob.wip_steps[0].oprn_class_desc;
        this.wipStepDesc = this.selectedJob.wip_steps[0].oprn_desc;
        this.isShowLines = true;
        this.jobLines = this.selectedJob.jobLines;
        this.isOpenFlag = this.selectedJob.open_flag == 'Y' ? true : false;
      } else {
        this.emptyDatas();
      }
    },
    emptyOpt: function emptyOpt() {
      this.headerOpts = {};
      this.selectedBlendNo = null;
      this.selectedOpt = null;
      this.selectedJob = null;
      this.emptyDatas();
    },
    emptyBlendNoAndOpt: function emptyBlendNoAndOpt() {
      this.headerBlendNumbers = {};
      this.headerOpts = {};
      this.selectedBlendNo = null;
      this.selectedOpt = null;
      this.selectedJob = null;
      this.emptyDatas();
    },
    emptyDatas: function emptyDatas() {
      this.batchNo = null;
      this.lossQty = null;
      this.itemNumber = null;
      this.itemDesc = null;
      this.uom = null;
      this.wipStep = null;
      this.wipStepDesc = null;
      this.isShowLines = false;
      this.jobLines = {};
    },
    onEditButtonClicked: function onEditButtonClicked() {
      var _this3 = this;

      console.debug('onEditButtonClicked');
      this.isEditing = true;
      Vue.nextTick(function () {
        _this3.$refs['input-confirm-quantity-ref'][0].focus();
      });
    },
    onSaveButtonClicked: function onSaveButtonClicked() {
      var _this4 = this;

      console.debug('onSaveButtonClicked');
      this.jobHeaderLines.jobHeader = this.lodash.cloneDeep(this.selectedJob);
      console.debug('cloneDeep this.jobHeaderLines', this.jobHeaderLines); // alert('isOpenFlag..'+ this.isOpenFlag);
      // alert(this.isOpenFlag);

      var lines = this.jobHeaderLines.jobHeader.jobLines;
      var totalLossQtyFromInput = 0;
      lines.forEach(function (line) {
        if (_this4.isOpenFlag) {
          totalLossQtyFromInput += parseInt(line.loss_qty === null ? 0 : line.loss_qty);
        } else {
          totalLossQtyFromInput += parseInt(line.attribute1 === null ? 0 : line.attribute1);
        }
      });

      if (totalLossQtyFromInput > this.lossQty) {
        // alert('YOU COULD NOT SAVE BECAUSE SUM OF LOSSQTY IS GREATER THEN TOTAL LOSSQTY!!!!!');
        swal({
          title: "\n\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
          // new line is a workaround for icon cover text
          text: 'รายการที่ระบุไม่สามารถบันทึกเกินจำนวนสูญเสียได้',
          type: 'error',
          showConfirmButton: true,
          closeOnConfirm: true,
          confirmButtonText: 'ปิด'
        });
      } else {
        // alert('YOU COULD SAVE!!!!!');
        (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_1__.showLoadingDialog)();
        axios.put(this.url.ajax_store, {
          isOpenFlag: this.isOpenFlag,
          jobHeaderLines: this.jobHeaderLines
        }).then(function (result) {
          console.debug(result, result.data);
          _this4.isShowLines = true;
          _this4.isEditing = false;
          _this4.jobHeaderLines = result.data;
          _this4.jobLines = _this4.jobHeaderLines.jobLines; // this.jobLines = _.orderBy(this.jobHeaderLines.jobLines, 'lookup_code', 'asc');

          (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_1__.showSaveSuccessDialog)();
        })["catch"](function (err) {
          console.debug(err);
          swal.close();
          _this4.isEditing = false;
          (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_1__.showSaveFailureDialog)();
        });
      }
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

/***/ "./resources/js/pm/wip-loss-quantity/Index.vue":
/*!*****************************************************!*\
  !*** ./resources/js/pm/wip-loss-quantity/Index.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_e0d955d6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=e0d955d6& */ "./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=template&id=e0d955d6&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_e0d955d6___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_e0d955d6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/wip-loss-quantity/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=template&id=e0d955d6&":
/*!************************************************************************************!*\
  !*** ./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=template&id=e0d955d6& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_e0d955d6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_e0d955d6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_e0d955d6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=e0d955d6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=template&id=e0d955d6&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=template&id=e0d955d6&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-loss-quantity/Index.vue?vue&type=template&id=e0d955d6& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "ibox float-e-margins" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "ibox-content" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-lg-12" }, [
            _c("div", { staticClass: "form-group row" }, [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-lg-3" },
                [
                  _c("datepicker-th", {
                    staticClass: "form-control md:tw-mb-0 tw-mb-2",
                    staticStyle: { width: "100%" },
                    attrs: {
                      name: "transaction_date",
                      id: "transaction_date",
                      placeholder: "โปรดเลือกวันที่",
                      "not-after-date": _vm.notAfterDate,
                      value: _vm.transactionDate,
                      format: _vm.transDate["js-format"]
                    },
                    on: {
                      dateWasSelected: function($event) {
                        var i = arguments.length,
                          argsArray = Array(i)
                        while (i--) argsArray[i] = arguments[i]
                        _vm.setdate.apply(
                          void 0,
                          argsArray.concat(["transaction_date"])
                        ),
                          _vm.onDateChanged($event)
                      }
                    }
                  })
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-lg-6" }, [
            _c("div", { staticClass: "form-group row" }, [
              _vm._m(2),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-lg-6" },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: { placeholder: "", filterable: "", clearable: "" },
                      on: {
                        change: function($event) {
                          return _vm.onBlendNoChanged($event)
                        }
                      },
                      model: {
                        value: _vm.selectedBlendNo,
                        callback: function($$v) {
                          _vm.selectedBlendNo = $$v
                        },
                        expression: "selectedBlendNo"
                      }
                    },
                    _vm._l(_vm.headerBlendNumbers, function(headerBlendNumber) {
                      return _c("el-option", {
                        key: headerBlendNumber.blend_no,
                        attrs: {
                          label: headerBlendNumber.blend_no,
                          value: headerBlendNumber.blend_no
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
                {
                  staticClass:
                    "col-lg-4 font-weight-bold col-form-label text-right",
                  attrs: { for: "lb-3" }
                },
                [_vm._v("เลขที่คำสั่งผลิต: ")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-6" }, [
                _c("input", {
                  staticClass: "form-control",
                  attrs: {
                    type: "text",
                    autocomplete: "off",
                    disabled: "disabled"
                  },
                  domProps: { value: _vm.batchNo }
                })
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c(
                "label",
                {
                  staticClass:
                    "col-lg-4 font-weight-bold col-form-label text-right"
                },
                [_vm._v("จำนวนที่สูญเสีย:")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-6" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-lg-6 pr-0" }, [
                    _c("input", {
                      staticClass: "form-control pr-0",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: "disabled"
                      },
                      domProps: { value: Number(_vm.lossQty).toLocaleString() }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("input", {
                      staticClass: "form-control",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: "disabled"
                      },
                      domProps: { value: _vm.uom }
                    })
                  ])
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-lg-6" }, [
            _c("div", { staticClass: "form-group row" }, [
              _vm._m(3),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-lg-6" },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: { placeholder: "", filterable: "", clearable: "" },
                      on: {
                        change: function($event) {
                          return _vm.onOptChanged($event)
                        }
                      },
                      model: {
                        value: _vm.selectedOpt,
                        callback: function($$v) {
                          _vm.selectedOpt = $$v
                        },
                        expression: "selectedOpt"
                      }
                    },
                    _vm._l(_vm.headerOpts, function(headerOpt) {
                      return _c("el-option", {
                        key: headerOpt.opt,
                        attrs: { label: headerOpt.opt, value: headerOpt.opt }
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
                {
                  staticClass:
                    "col-lg-4 font-weight-bold col-form-label text-right",
                  attrs: { for: "lb-2" }
                },
                [_vm._v("รหัสวัตถุดิบ: ")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-6" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-lg-5" }, [
                    _c("input", {
                      staticClass: "form-control pr-0",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: "disabled"
                      },
                      domProps: { value: _vm.itemNumber }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-7 pl-0" }, [
                    _c("input", {
                      staticClass: "form-control pr-0",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: "disabled"
                      },
                      domProps: { value: _vm.itemDesc }
                    })
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c(
                "label",
                {
                  staticClass:
                    "col-lg-4 font-weight-bold col-form-label text-right",
                  attrs: { for: "lb-2" }
                },
                [_vm._v("ขั้นตอนการทำงาน: ")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-6" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-lg-5" }, [
                    _c("input", {
                      staticClass: "form-control pr-0",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: "disabled"
                      },
                      domProps: { value: _vm.wipStep }
                    })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-7 pl-0" }, [
                    _c("input", {
                      staticClass: "form-control pr-0",
                      attrs: {
                        type: "text",
                        autocomplete: "off",
                        disabled: "disabled"
                      },
                      domProps: { value: _vm.wipStepDesc }
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
    _c("div", { staticClass: "ibox float-e-margins" }, [
      _c("div", { staticClass: "ibox-content" }, [
        _c("div", { staticClass: "table-responsive" }, [
          _vm.isShowLines && Object.keys(_vm.jobLines).length > 0
            ? _c("table", { staticClass: "table text-nowrap table-bordered" }, [
                _vm._m(4),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.jobLines, function(jobLine, i) {
                    return _c(
                      "tr",
                      { staticStyle: { "text-align": "center" } },
                      [
                        _c("td", { staticClass: "col-readonly" }, [
                          _vm.isOpenFlag
                            ? _c("span", [
                                jobLine.loss_data
                                  ? _c("span", [
                                      _vm._v(
                                        "\n                                        " +
                                          _vm._s(jobLine.loss_data.meaning) +
                                          "\n                                    "
                                      )
                                    ])
                                  : _c("span", [_vm._v("-")])
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !_vm.isOpenFlag && jobLine.meaning
                            ? _c("span", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(jobLine.meaning) +
                                    "\n                                "
                                )
                              ])
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm.isOpenFlag
                            ? _c("span", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: jobLine.loss_qty,
                                      expression: "jobLine.loss_qty"
                                    }
                                  ],
                                  ref: "input-confirm-quantity-ref",
                                  refInFor: true,
                                  staticClass: "form-control",
                                  attrs: {
                                    id: "input-confirm-quantity",
                                    type: "number",
                                    min: "0",
                                    autocomplete: "off",
                                    disabled: !_vm.isEditing
                                  },
                                  domProps: { value: jobLine.loss_qty },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        jobLine,
                                        "loss_qty",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !_vm.isOpenFlag
                            ? _c("span", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: jobLine.attribute1,
                                      expression: "jobLine.attribute1"
                                    }
                                  ],
                                  ref: "input-confirm-quantity-ref",
                                  refInFor: true,
                                  staticClass: "form-control",
                                  attrs: {
                                    id: "input-confirm-quantity",
                                    type: "number",
                                    min: "0",
                                    autocomplete: "off"
                                  },
                                  domProps: { value: jobLine.attribute1 },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        jobLine,
                                        "attribute1",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ])
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-readonly" }, [
                          _vm.uom
                            ? _c("span", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(_vm.uom) +
                                    "\n                                "
                                )
                              ])
                            : _vm._e()
                        ])
                      ]
                    )
                  }),
                  0
                )
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        !_vm.isShowLines
          ? _c("div", { staticClass: "text-center mb-5" }, [
              _c("h2", { staticStyle: { color: "red" } }, [
                _vm._v("ไม่พบข้อมูล")
              ])
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.isShowLines && Object.keys(_vm.jobLines).length > 0
          ? _c("div", { staticClass: "text-center m-t" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-w-m btn-warning",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.onEditButtonClicked($event)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-pencil-square-o" }),
                  _vm._v(" \n                    แก้ไข\n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-w-m btn-primary",
                  attrs: { type: "button", disabled: !_vm.isEditing },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.onSaveButtonClicked($event)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-save (alias)" }),
                  _vm._v(" \n                    บันทึก\n                ")
                ]
              )
            ])
          : _vm._e()
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-content" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-3" }, [
          _c("h3", { staticClass: "no-margins" }, [_vm._v(" บันทึกสูญเสีย ")])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-2 font-weight-bold col-form-label text-right",
        attrs: { for: "lb-1" }
      },
      [
        _vm._v("วันที่บันทึกสูญเสีย"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
        _vm._v(": ")
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-4 font-weight-bold col-form-label text-right",
        attrs: { for: "lb-2" }
      },
      [
        _vm._v("Blend no"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
        _vm._v(": ")
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-4 font-weight-bold col-form-label text-right",
        attrs: { for: "lb-2" }
      },
      [
        _vm._v("OPT."),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
        _vm._v(": ")
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center" }, [_vm._v("รายการสูญเสีย")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("จำนวนสูญเสีย")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("หน่วยนับ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);