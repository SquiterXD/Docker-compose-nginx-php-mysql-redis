(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_wip-confirm_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var lodash_isEqual__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash/isEqual */ "./node_modules/lodash/isEqual.js");
/* harmony import */ var lodash_isEqual__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash_isEqual__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash/cloneDeep */ "./node_modules/lodash/cloneDeep.js");
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _httpClient__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../httpClient */ "./resources/js/pm/httpClient.js");
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../router */ "./resources/js/pm/router.js");
/* harmony import */ var _commonDialogs__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../commonDialogs */ "./resources/js/commonDialogs.js");
/* harmony import */ var lodash_isNil__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! lodash/isNil */ "./node_modules/lodash/isNil.js");
/* harmony import */ var lodash_isNil__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(lodash_isNil__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _dateUtils__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../../dateUtils */ "./resources/js/dateUtils.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["pJobHeaders", "pFromDate", "pToDate", 'transDate', "transBtn", "url", "pOrgId"],
  created: function created() {
    var _this = this;

    Vue.nextTick(function () {
      _this.setDefaultValue();
    });
  },
  mounted: function mounted() {},
  data: function data() {
    return {
      lodash: {
        get: (lodash_get__WEBPACK_IMPORTED_MODULE_2___default()),
        isEqual: (lodash_isEqual__WEBPACK_IMPORTED_MODULE_0___default()),
        cloneDeep: (lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_1___default()),
        isNil: (lodash_isNil__WEBPACK_IMPORTED_MODULE_6___default())
      },
      jobHeaders: _.groupBy(this.pJobHeaders, 'batch_no'),
      isInRange: _dateUtils__WEBPACK_IMPORTED_MODULE_8__.isInRange,
      jsDateToString: _dateUtils__WEBPACK_IMPORTED_MODULE_8__.jsDateToString,
      toJSDate: _dateUtils__WEBPACK_IMPORTED_MODULE_8__.toJSDate,
      toThDateString: _dateUtils__WEBPACK_IMPORTED_MODULE_8__.toThDateString,
      search: {
        from_date: null,
        to_date: null
      },
      searching: false,
      fdate: null,
      ldate: null
    };
  },
  methods: {
    setDefaultValue: function setDefaultValue() {
      this.search.from_date = this.pFromDate;
      this.search.to_date = this.pToDate;
    },
    onViewDescriptionClicked: function onViewDescriptionClicked(header) {
      var _this2 = this;

      console.debug('onViewDescriptionClicked', header[0].batch_no, header); // let joblines = header[0].job_lines;
      // if (joblines) {
      //     joblines.map((jobline, i) => {
      //         if(i == 0) {
      //             console.debug('first...', jobline.transaction_date, jobline);
      //             this.fdate = jobline.transaction_date;
      //         }
      //         if(i == joblines.length - 1) {
      //             console.debug('last...', jobline.transaction_date, jobline);
      //             this.ldate = jobline.transaction_date;
      //         }
      //     });
      // }

      var errors = [];

      if (!this.search.from_date) {
        errors.push('กรุณากรอกวันที่ได้ผลผลิตเริ่มต้น.');
      }

      if (!this.search.to_date) {
        errors.push('กรุณากรอกวันที่ได้ผลผลิตสิ้นสุด.');
      }

      if (errors.length > 0) {
        return (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_5__.showValidationFailedDialog)(errors);
      }

      var batchNo = header[0].batch_no;
      var from_date = this.search.from_date;
      var to_date = this.search.to_date; // let from_date = this.search.from_date ?? this.fdate;
      // let to_date = this.search.to_date ?? this.ldate;
      // let url = this.url.wip_confirm_import_mes_data;
      // if (batchNo != '' && batchNo != undefined) {
      //     this.url.wip_confirm_import_mes_data = this.url.wip_confirm_import_mes_data.replace("-1", batchNo)
      // }

      console.debug('wip_confirm_import_mes_data', this.url.wip_confirm_import_mes_data);
      console.debug('url', this.url.wip_confirm_jobs);
      console.debug('batchNo', batchNo);
      console.debug('from_date', from_date);
      console.debug('to_date', to_date);
      (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_5__.showLoadingDialog)();
      axios.post(this.url.wip_confirm_import_mes_data, {
        id: batchNo
      }).then(function (result) {
        console.debug('result.................');
        console.debug(result); // swal.close();

        location.href = _this2.url.wip_confirm_jobs + "?batch_no=" + batchNo + "&from_date=" + from_date + "&to_date=" + to_date;
      })["catch"](function (err) {
        console.debug(err.response);

        var errorMessage = _this2.lodash.get(err, 'response.data.errorMessage', null);

        if (!_this2.lodash.isNil(errorMessage)) {
          (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_5__.showGenericFailureDialog)(errorMessage);
        } else {
          (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_5__.showGenericFailureDialog)();
        }
      });
    },
    searchData: function searchData() {
      var _this3 = this;

      var vm = this;
      var action = 'search';
      var errors = [];

      if (!vm.search.from_date) {
        errors.push('กรุณากรอกวันที่ได้ผลผลิตเริ่มต้น.');
      }

      if (!vm.search.to_date) {
        errors.push('กรุณากรอกวันที่ได้ผลผลิตสิ้นสุด.');
      }

      if (errors.length > 0) {
        return (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_5__.showValidationFailedDialog)(errors);
      }

      this.searching = true;
      axios.get(vm.url.wip_confirm_search, {
        params: {
          start_date: vm.search.from_date,
          to_date: vm.search.to_date,
          action: action
        }
      }).then(function (res) {
        _this3.searching = false;
        var data = res.data.data;
        console.debug('xx', data);
        vm.jobHeaders = _.groupBy(data.jobHeaders, 'batch_no');
      })["catch"](function (err) {// let data = err.response.data;
        // alert(data.message);
      });
    },
    indexView: function indexView() {
      window.location = this.url.wip_confirm_index;
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

/***/ "./resources/js/dateUtils.js":
/*!***********************************!*\
  !*** ./resources/js/dateUtils.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "customBuddhistYearDatePicker": () => /* binding */ customBuddhistYearDatePicker,
/* harmony export */   "toJSDate": () => /* binding */ toJSDate,
/* harmony export */   "toDateTime": () => /* binding */ toDateTime,
/* harmony export */   "isInRange": () => /* binding */ isInRange,
/* harmony export */   "dateTimeToString": () => /* binding */ dateTimeToString,
/* harmony export */   "jsDateToString": () => /* binding */ jsDateToString,
/* harmony export */   "toThDateString": () => /* binding */ toThDateString
/* harmony export */ });
/* harmony import */ var luxon__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! luxon */ "./node_modules/luxon/build/cjs-browser/luxon.js");
/* harmony import */ var lodash_merge__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash/merge */ "./node_modules/lodash/merge.js");
/* harmony import */ var lodash_merge__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash_merge__WEBPACK_IMPORTED_MODULE_0__);


/**
 * return helper and config object for setting vue2-datepicker display buddhist year
 * @param customConfig object
 * @param yearDisplayQuerySelector string|null
 * @returns object
 */

function customBuddhistYearDatePicker() {
  var customConfig = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var yearDisplayQuerySelector = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

  if (yearDisplayQuerySelector === null) {
    yearDisplayQuerySelector = '.mx-datepicker-main .mx-btn-current-year, .mx-datepicker-main .mx-calendar-header-label span, .mx-datepicker-main .mx-table-year div, .mx-datepicker-main .mx-calendar-header-label .mx-btn-text';
  }

  var config = {
    lang: {
      formatLocale: {
        months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        weekdays: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        weekdaysShort: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        weekdaysMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
        firstDayOfWeek: 0
      },
      yearFormat: 'YYYY',
      monthFormat: 'MMM',
      monthBeforeYear: true
    },
    formatter: {
      //[optional] Date to String
      stringify: function stringify(date) {
        var d = luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(date);
        return date ? "".concat(d.toFormat('dd/MM'), "/").concat(parseInt(d.toFormat('yyyy')) + 543) : '';
      },
      //[optional]  String to Date
      parse: function parse(value) {
        var ds = value.split('/');
        if (ds.length !== 3 || ds.filter(function (it) {
          return isNaN(it);
        }).length > 0) return null;
        var d = "".concat(ds[0], "/").concat(ds[1], "/").concat(ds[2] - 543);
        return value ? luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromFormat(value, 'DD/MM/YYYY').toJSDate() : null;
      }
    },
    onUiFrameChange: function onUiFrameChange() {
      for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      Vue.nextTick(function () {
        var currentYear = args.length === 3 && args[0] instanceof Date ? args[0].getFullYear() : null;
        var els = $(yearDisplayQuerySelector);
        els.each(function () {
          var el = $(this);
          var text = el.text();
          if (isNaN(text.trim())) return;
          var displayYear = currentYear ? currentYear : parseInt(text);
          if (displayYear < 2100) el.text(displayYear + 543);
        });
      });
    },
    dateInRange: function dateInRange(minDate, maxDate) {
      var isIncludeTargetDate = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
      //return true for disabled date
      return function (targetDate) {
        return !isInRange(targetDate, minDate, maxDate, isIncludeTargetDate);
      };
    }
  };
  return lodash_merge__WEBPACK_IMPORTED_MODULE_0___default()(config, customConfig);
}
/**
 * convert value to JavaScript Date
 * if value is string, it will convert to Date by luxon's format (https://moment.github.io/luxon/docs/manual/formatting)
 * if format is null, it will convert string by ISO format
 * return null if it cannot convert to Date
 *
 * Test Case
 * toJSDate(null) null
 * toJSDate(1621267465092) Mon May 17 2021 23:04:25 GMT+0700 (Indochina Time)
 * toJSDate('2021-02-01') Mon Feb 01 2021 00:00:00 GMT+0700 (Indochina Time)
 * toJSDate('01/02/2021') null
 * toJSDate('01/02/2021', 'dd/MM/yyyy') Mon Feb 01 2021 00:00:00 GMT+0700 (Indochina Time)
 * toJSDate(new Date('2021-02-01')) Mon Feb 01 2021 07:00:00 GMT+0700 (Indochina Time)
 * toJSDate(DateTime.fromJSDate(new Date('2021-02-01'))) Mon Feb 01 2021 07:00:00 GMT+0700 (Indochina Time)
 * toJSDate(DateTime.fromJSDate(new Date('2021-99-99'))) null
 *
 * @param value Date|DateTime|number|string|null
 * @param format string|null
 * @returns {Date|null}
 */

function toJSDate(value) {
  var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  if (value === null) return null;
  if (value instanceof Date) return value;
  if (value instanceof luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime) return value.isValid ? value.toJSDate() : null;
  if (typeof value === 'number') return new Date(value);

  if (typeof value === 'string') {
    var d = typeof format === 'string' ? luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromFormat(value, format) : luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromISO(value);
    return d.isValid ? d.toJSDate() : null;
  }

  return null;
}
/**
 * convert value to luxon DateTime
 * if value is string, it will convert to Date by luxon's format (https://moment.github.io/luxon/docs/manual/formatting)
 * if format is null, it will convert string by ISO format
 *
 * Test Case
 * toDateTime(null) DateTime >> {ts: 1621321275092, _zone: LocalZone, loc: Locale, invalid: Invalid, weekData: null, >> …}
 * toDateTime(1621267465092) DateTime >> {ts: 1621267465092, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime('2021-02-01') DateTime >> {ts: 1612112400000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime('01/02/2021') DateTime >> {ts: 1621321275121, _zone: LocalZone, loc: Locale, invalid: Invalid, weekData: null, >> …}
 * toDateTime('01/02/2021', 'dd/MM/yyyy') DateTime >> {ts: 1612112400000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime(new Date('2021-02-01')) DateTime >> {ts: 1612137600000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime(DateTime.fromJSDate(new Date('2021-02-01'))) DateTime >> {ts: 1612137600000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime(DateTime.fromJSDate(new Date('2021-99-99'))) DateTime >> {ts: 1621321275131, _zone: LocalZone, loc: Locale, invalid: Invalid, week
 *
 * @param value Date|DateTime|number|string|null
 * @param format string|null
 * @returns {DateTime}
 */

function toDateTime(value) {
  var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  if (value instanceof luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime) return value;
  return luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(toJSDate(value, format));
}
/**
 * check targetDate is in range between minDate to maxDate
 * if isIncludeTargetDate is true (default) minDate and maxDate will included in check range [minDate, maxDate]
 * else minDate and maxDate will not included in check range (minDate, maxDate)
 *
 * Test Case
 * isInRange('2021-01-15', '2021-01-01', '2021-01-31', true) true
 * isInRange('2021-02-15', '2021-01-01', '2021-01-31', true) false
 * isInRange('2021-01-01', '2021-01-01', '2021-01-31', true) true
 * isInRange('2021-01-01', '2021-01-01', '2021-01-31', false) false
 * isInRange('2021-01-31', '2021-01-01', '2021-01-31', true) true
 * isInRange('2021-01-31', '2021-01-01', '2021-01-31', false) false
 * isInRange('2021-01-15', '2021-01-01', null) true
 * isInRange('2021-01-15', null, '2021-01-31') true
 * isInRange('2021-01-01', '2021-01-15', null) false
 * isInRange('2021-01-31', null, '2021-01-15') false
 *
 * @param targetDate Date|DateTime|number|string|null
 * @param minDate Date|DateTime|number|string|null
 * @param maxDate Date|DateTime|number|string|null
 * @param isIncludeTargetDate bool
 * @returns {boolean}
 */

function isInRange(targetDate, minDate, maxDate) {
  var isIncludeTargetDate = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : true;
  //convert targetDate/minDate/maxDate to DateTime
  targetDate = luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(toJSDate(targetDate));
  minDate = luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(toJSDate(minDate));
  maxDate = luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(toJSDate(maxDate));
  var isMinDateValid = !!(minDate && minDate instanceof luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime && minDate.isValid);
  var isMaxDateValid = !!(maxDate && maxDate instanceof luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime && maxDate.isValid);

  if (!isMinDateValid && !isMaxDateValid || !targetDate) {
    return true;
  }

  minDate = isMinDateValid ? minDate.startOf('day') : null;
  maxDate = isMaxDateValid ? maxDate.startOf('day') : null;

  if (minDate && maxDate) {
    if (isIncludeTargetDate) {
      if (minDate.hasSame(targetDate, 'day') || maxDate.hasSame(targetDate, 'day')) {
        return true;
      }
    }

    return minDate < targetDate && targetDate < maxDate;
  }

  if (minDate) {
    if (minDate.hasSame(targetDate, 'day')) {
      return isIncludeTargetDate;
    }

    return minDate.startOf('day') <= targetDate;
  }

  if (maxDate) {
    if (maxDate.hasSame(targetDate, 'day')) {
      return isIncludeTargetDate;
    }

    return maxDate.startOf('day') >= targetDate;
  }

  return false;
}
/**
 * convert DateTime to string based on format
 * @param dateTime DateTime
 * @param dateFormat string
 * @param defaultValue string|null
 * @returns {string|null}
 */

function dateTimeToString(dateTime) {
  var dateFormat = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'yyyy-MM-dd';
  var defaultValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

  if (!dateTime || dateTime instanceof luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime) {
    return defaultValue;
  }

  if (dateTime && dateTime.isValid) {
    return dateTime.toFormat(dateFormat);
  } else {
    return defaultValue;
  }
}
/**
 * convert Date to string based on format
 * @param jsDate Date
 * @param dateFormat string
 * @param defaultValue string
 * @returns {string|null}
 */

function jsDateToString(jsDate) {
  var dateFormat = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'yyyy-MM-dd';
  var defaultValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

  if (!jsDate) {
    return defaultValue;
  }

  var dateTime = luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(jsDate);

  if (dateTime && dateTime.isValid) {
    return dateTime.toFormat(dateFormat);
  } else {
    return defaultValue;
  }
}
/**
 * return date string with buddhist year (ex. 31/01/2564)
 *
 * Test Case
 * toThDateString(1621267465092) 17/05/2564
 * toThDateString('2021-02-01') 01/02/2564
 * toThDateString('2021-99-99') null
 * toThDateString('01/02/2021', 'dd/MM/yyyy') 01/02/2564
 * toThDateString(new Date('2021-02-01')) 01/02/2564
 * toThDateString(new Date('2021-99-99')) null
 * toThDateString(DateTime.fromISO('2021-02-01')) 01/02/2564
 * toThDateString(DateTime.fromISO('2021-99-99')) null
 *
 * @param value Date|DateTime|number|string|null
 * @param format string|null
 * @returns {string|null}
 */

function toThDateString(value) {
  var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var date = toJSDate(value, format);
  if (!date) return null;
  var dateTime = luxon__WEBPACK_IMPORTED_MODULE_1__.DateTime.fromJSDate(date);
  return dateTime.isValid ? dateTime.toFormat('dd/MM/') + (date.getFullYear() + 543) : null;
} // export function customBuddhistYearDatePicker(customConfig, yearDisplayQuerySelector = null) {
//
//     if (yearDisplayQuerySelector === null) {
//         yearDisplayQuerySelector = '.mx-datepicker-main .mx-btn-current-year, .mx-datepicker-main .mx-calendar-header-label span, .mx-datepicker-main .mx-table-year div, .mx-datepicker-main .mx-calendar-header-label .mx-btn-text';
//     }
//
//     let config = {
//         lang: {
//             formatLocale: {
//                 months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
//                 monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
//                 weekdays: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
//                 weekdaysShort: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
//                 weekdaysMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
//                 firstDayOfWeek: 0,
//             },
//             yearFormat: 'YYYY',
//             monthFormat: 'MMM',
//             monthBeforeYear: true
//         },
//         formatter: {
//             //[optional] Date to String
//             stringify: (date) => {
//                 let d = DateTime.fromJSDate(date);
//                 return date ? `${d.toFormat('dd/MM')}/${parseInt(d.toFormat('yyyy')) + 543}` : '';
//             },
//             //[optional]  String to Date
//             parse: (value) => {
//                 let ds = value.split('/');
//                 if (ds.length !== 3 || ds.filter(it => isNaN(it)).length > 0) return null;
//                 let d = `${ds[0]}/${ds[1]}/${ds[2] - 543}`;
//                 return value ? DateTime.fromFormat(value, 'DD/MM/YYYY').toJSDate() : null;
//             },
//         },
//         onUiFrameChange(...args) {
//             Vue.nextTick(() => {
//                 let currentYear = args.length === 3 && args[0] instanceof Date ? args[0].getFullYear() : null;
//                 let els = $(yearDisplayQuerySelector);
//                 els.each(function () {
//                     let el = $(this);
//                     let text = el.text();
//                     if (isNaN(text.trim())) return;
//                     let displayYear = currentYear ? currentYear : parseInt(text);
//                     if (displayYear < 2100) el.text(displayYear + 543);
//                 });
//             });
//         },
//         // dateInRange(min, max) {
//         //     return (date) => {
//         //         //console.log({min, max, date});
//         //         //console.log(DateTime.fromISO(min).toJSDate());
//         //         let minDate = min instanceof Date ? min : DateTime.fromISO(min).toJSDate();
//         //         let maxDate = max instanceof Date ? max : DateTime.fromISO(max).toJSDate();
//         //         if (min && date < minDate) return true;
//         //         if (max && date > maxDate) return true;
//         //         return false;
//         //     };
//         // },
//         toDateTime(dateString, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             console.debug('dateString 00');
//             if (!dateString) {
//                 console.debug('dateString 01');
//                 return defaultValue;
//             }
//
//             console.debug('dateString 02', dateString);
//             let dateTime = DateTime.fromFormat(dateString, dateFormat);
//             console.debug('dateString 03');
//             if (dateTime.isValid) {
//                 console.debug('dateString 04');
//                 return dateTime;
//             } else {
//                 console.debug('dateString 05');
//                 return defaultValue;
//             }
//         },
//         toJsDate(dateString, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             console.debug('toJsDate 00', dateString);
//             let dateTime = this.toDateTime(dateString, dateFormat, defaultValue);
//             console.debug('toJsDate 01');
//             if ((dateTime instanceof DateTime) && dateTime.isValid) {
//                 console.debug('toJsDate 02');
//                 return dateTime.toJSDate();
//             }
//             console.debug('toJsDate 03');
//             console.warn('toJsDate: conversion failed return default value');
//             return defaultValue;
//         },
//         dateTimeToString(dateTime, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             if (!dateTime || (dateTime instanceof DateTime)) {
//                 return defaultValue;
//             }
//
//             if (dateTime && dateTime.isValid) {
//                 return dateTime.toFormat(dateFormat);
//             } else {
//                 return defaultValue;
//             }
//         },
//         jsDateToString(jsDate, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             if (!jsDate) {
//                 return defaultValue;
//             }
//
//             let dateTime = DateTime.fromJSDate(jsDate);
//             if (dateTime && dateTime.isValid) {
//                 return dateTime.toFormat(dateFormat);
//             } else {
//                 return defaultValue;
//             }
//         },
//         dateInRange(minDate, maxDate, isIncludeTargetDate = true) {
//             //return true for disabled date
//             return (targetDate) => {
//
//                 let isMinDateValid = !!(minDate && minDate instanceof DateTime && minDate.isValid);
//                 let isMaxDateValid = !!(maxDate && maxDate instanceof DateTime && maxDate.isValid);
//
//                 if ((!isMinDateValid && !isMaxDateValid) || !targetDate) {
//                     return false;
//                 }
//
//                 minDate = isMinDateValid ? minDate.startOf('day') : null;
//                 maxDate = isMaxDateValid ? maxDate.startOf('day') : null;
//
//                 if (minDate && maxDate) {
//                     if (isIncludeTargetDate) {
//                         if (minDate.hasSame(targetDate, 'day') || maxDate.hasSame(targetDate, 'day')) {
//                             return false;
//                         }
//                     }
//
//                     return !(minDate < targetDate && targetDate < maxDate);
//                 }
//
//                 if (minDate) {
//                     if (minDate.hasSame(targetDate, 'day')) {
//                         return !isIncludeTargetDate;
//                     }
//                     return (minDate.startOf('day') > targetDate);
//                 }
//
//                 if (maxDate) {
//                     if (maxDate.hasSame(targetDate, 'day')) {
//                         return !isIncludeTargetDate;
//                     }
//                     return (maxDate.startOf('day') < targetDate);
//                 }
//
//                 return true;
//             };
//         },
//     };
//
//     return _merge(config, customConfig);
// }

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

/***/ "./resources/js/pm/router.js":
/*!***********************************!*\
  !*** ./resources/js/pm/router.js ***!
  \***********************************/
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
/* harmony export */   "ajax_pm_plans_yearly_getInfo": () => /* binding */ ajax_pm_plans_yearly_getInfo,
/* harmony export */   "ajax_pm_plans_yearly_getSourceVersions": () => /* binding */ ajax_pm_plans_yearly_getSourceVersions,
/* harmony export */   "ajax_pm_plans_yearly_addNewHeader": () => /* binding */ ajax_pm_plans_yearly_addNewHeader,
/* harmony export */   "ajax_pm_plans_yearly_getSalePlans": () => /* binding */ ajax_pm_plans_yearly_getSalePlans,
/* harmony export */   "ajax_pm_plans_yearly_getLines": () => /* binding */ ajax_pm_plans_yearly_getLines,
/* harmony export */   "ajax_pm_plans_yearly_generateLines": () => /* binding */ ajax_pm_plans_yearly_generateLines,
/* harmony export */   "ajax_pm_plans_yearly_storeLines": () => /* binding */ ajax_pm_plans_yearly_storeLines,
/* harmony export */   "ajax_pm_plans_yearly_submitApproval": () => /* binding */ ajax_pm_plans_yearly_submitApproval,
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
/* harmony export */   "ajax_pm_products_transfers_storeLines": () => /* binding */ ajax_pm_products_transfers_storeLines,
/* harmony export */   "ajax_pm_products_transfers_confirmRequest": () => /* binding */ ajax_pm_products_transfers_confirmRequest,
/* harmony export */   "ajax_pm_products_transfers_discardConfirmedRequest": () => /* binding */ ajax_pm_products_transfers_discardConfirmedRequest,
/* harmony export */   "ajax_pm_products_transfers_cancelRequest": () => /* binding */ ajax_pm_products_transfers_cancelRequest,
/* harmony export */   "ajax_pm_products_transfers_submitRequest": () => /* binding */ ajax_pm_products_transfers_submitRequest,
/* harmony export */   "api_db_lookup": () => /* binding */ api_db_lookup,
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
/* harmony export */   "pm_ajax_getItemNumber": () => /* binding */ pm_ajax_getItemNumber,
/* harmony export */   "pm_ajax_getDataTable": () => /* binding */ pm_ajax_getDataTable,
/* harmony export */   "pm_ajax_getOrganization": () => /* binding */ pm_ajax_getOrganization,
/* harmony export */   "pm_ajax_getLocations": () => /* binding */ pm_ajax_getLocations,
/* harmony export */   "pm_ajax_getUom": () => /* binding */ pm_ajax_getUom,
/* harmony export */   "pm_ajax_destroy": () => /* binding */ pm_ajax_destroy,
/* harmony export */   "pm_ajax_search": () => /* binding */ pm_ajax_search,
/* harmony export */   "pm_ajax_printConversion_destroy": () => /* binding */ pm_ajax_printConversion_destroy,
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
/* harmony export */   "pm_settings_savePublicationLayout_store": () => /* binding */ pm_settings_savePublicationLayout_store,
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
/* harmony export */   "eam_ajax_plan_search_noversion": () => /* binding */ eam_ajax_plan_search_noversion,
/* harmony export */   "eam_ajax_plan_openWorkOrder": () => /* binding */ eam_ajax_plan_openWorkOrder,
/* harmony export */   "eam_ajax_plan_deleteLine": () => /* binding */ eam_ajax_plan_deleteLine,
/* harmony export */   "eam_ajax_plan_fileImport": () => /* binding */ eam_ajax_plan_fileImport,
/* harmony export */   "eam_ajax_billMaterials_show": () => /* binding */ eam_ajax_billMaterials_show,
/* harmony export */   "eam_ajax_billMaterials_store": () => /* binding */ eam_ajax_billMaterials_store,
/* harmony export */   "eam_ajax_billMaterials_deleteLine": () => /* binding */ eam_ajax_billMaterials_deleteLine,
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
/* harmony export */   "om_ajax_proformaInvoicecreate_proforma_invoice": () => /* binding */ om_ajax_proformaInvoicecreate_proforma_invoice,
/* harmony export */   "om_proformaInvoicecreate_proforma_invoice": () => /* binding */ om_proformaInvoicecreate_proforma_invoice,
/* harmony export */   "om_ajax_proformaInvoicemanage_proforma_invoice": () => /* binding */ om_ajax_proformaInvoicemanage_proforma_invoice,
/* harmony export */   "om_ajax_proformaInvoicecreate_proforma_lot": () => /* binding */ om_ajax_proformaInvoicecreate_proforma_lot,
/* harmony export */   "om_ajax_proformaInvoiceget_proforma_lot": () => /* binding */ om_ajax_proformaInvoiceget_proforma_lot,
/* harmony export */   "om_ajax_proformaInvoicecheckCancel": () => /* binding */ om_ajax_proformaInvoicecheckCancel,
/* harmony export */   "om_ajax_proformaInvoicecancel": () => /* binding */ om_ajax_proformaInvoicecancel,
/* harmony export */   "om_ajax_taxInvoiceExportcreate": () => /* binding */ om_ajax_taxInvoiceExportcreate,
/* harmony export */   "om_ajax_taxInvoiceExportsearch": () => /* binding */ om_ajax_taxInvoiceExportsearch,
/* harmony export */   "om_ajax_taxInvoiceExportmanage": () => /* binding */ om_ajax_taxInvoiceExportmanage,
/* harmony export */   "om_ajax_taxInvoiceExportcheckCancel": () => /* binding */ om_ajax_taxInvoiceExportcheckCancel,
/* harmony export */   "om_ajax_taxInvoiceExportcancel": () => /* binding */ om_ajax_taxInvoiceExportcancel,
/* harmony export */   "om_ajax_taxInvoiceExportcloseWork": () => /* binding */ om_ajax_taxInvoiceExportcloseWork,
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
/* harmony export */   "om_cancelConsignment": () => /* binding */ om_cancelConsignment,
/* harmony export */   "om_canceledConsignment": () => /* binding */ om_canceledConsignment,
/* harmony export */   "om_deliveryRateIndex": () => /* binding */ om_deliveryRateIndex,
/* harmony export */   "om_deliveryRateStore": () => /* binding */ om_deliveryRateStore,
/* harmony export */   "om_draftPayoutIndex": () => /* binding */ om_draftPayoutIndex,
/* harmony export */   "om_draftPayoutListproduct": () => /* binding */ om_draftPayoutListproduct,
/* harmony export */   "om_draftPayoutStoreDraft": () => /* binding */ om_draftPayoutStoreDraft,
/* harmony export */   "om_domesticMatchingIndex": () => /* binding */ om_domesticMatchingIndex,
/* harmony export */   "om_domesticMatchingGetData": () => /* binding */ om_domesticMatchingGetData,
/* harmony export */   "om_domesticMatchingUploaded": () => /* binding */ om_domesticMatchingUploaded,
/* harmony export */   "om_domesticMatchingUploadDeleted": () => /* binding */ om_domesticMatchingUploadDeleted,
/* harmony export */   "om_domesticMatchingUnmatching": () => /* binding */ om_domesticMatchingUnmatching,
/* harmony export */   "om_domesticMatchingMatching": () => /* binding */ om_domesticMatchingMatching,
/* harmony export */   "om_domesticMatchingGetinvoice": () => /* binding */ om_domesticMatchingGetinvoice,
/* harmony export */   "om_domesticMatchingGetamount": () => /* binding */ om_domesticMatchingGetamount,
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
/* harmony export */   "om_exportPayoutIndex": () => /* binding */ om_exportPayoutIndex,
/* harmony export */   "om_exportPayoutGetlistbank": () => /* binding */ om_exportPayoutGetlistbank,
/* harmony export */   "om_exportPayoutGetvaluebank": () => /* binding */ om_exportPayoutGetvaluebank,
/* harmony export */   "om_exportPayoutGetpaymentnumber": () => /* binding */ om_exportPayoutGetpaymentnumber,
/* harmony export */   "om_exportPaymentMethodDraftpayment": () => /* binding */ om_exportPaymentMethodDraftpayment,
/* harmony export */   "om_exportMethodPaymentUpload": () => /* binding */ om_exportMethodPaymentUpload,
/* harmony export */   "om_exportMethodPaymentDelete": () => /* binding */ om_exportMethodPaymentDelete,
/* harmony export */   "om_exportMethodPayment": () => /* binding */ om_exportMethodPayment,
/* harmony export */   "om_exportMethodPrint": () => /* binding */ om_exportMethodPrint,
/* harmony export */   "om_exportMatchingIndex": () => /* binding */ om_exportMatchingIndex,
/* harmony export */   "om_exportMatchingUnmatching": () => /* binding */ om_exportMatchingUnmatching,
/* harmony export */   "om_exportMatchingUploaded": () => /* binding */ om_exportMatchingUploaded,
/* harmony export */   "om_exportMatchingUploadDeleted": () => /* binding */ om_exportMatchingUploadDeleted,
/* harmony export */   "om_exportMatchingGetData": () => /* binding */ om_exportMatchingGetData,
/* harmony export */   "om_exportMatchingMatching": () => /* binding */ om_exportMatchingMatching,
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
/* harmony export */   "om_approvePrepare_print": () => /* binding */ om_approvePrepare_print,
/* harmony export */   "om_outstanding_index": () => /* binding */ om_outstanding_index,
/* harmony export */   "om_outstanding_getData": () => /* binding */ om_outstanding_getData,
/* harmony export */   "om_outstanding_getYear": () => /* binding */ om_outstanding_getYear,
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
/* harmony export */   "ir_ajax_vehiclesUpdate": () => /* binding */ ir_ajax_vehiclesUpdate,
/* harmony export */   "ir_ajax_vehiclesActiveFlag": () => /* binding */ ir_ajax_vehiclesActiveFlag,
/* harmony export */   "ir_ajax_vehiclesUpdateActiveFlag": () => /* binding */ ir_ajax_vehiclesUpdateActiveFlag,
/* harmony export */   "ir_ajax_vehiclesReturnVatFlag": () => /* binding */ ir_ajax_vehiclesReturnVatFlag,
/* harmony export */   "ir_ajax_vehiclesUpdateReturnVatFlag": () => /* binding */ ir_ajax_vehiclesUpdateReturnVatFlag,
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
/* harmony export */   "ir_ajax_irReportGetInfoAttribute": () => /* binding */ ir_ajax_irReportGetInfoAttribute,
/* harmony export */   "ir_ajax_irReportSubmit": () => /* binding */ ir_ajax_irReportSubmit,
/* harmony export */   "ir_settings_storeAccountMapping": () => /* binding */ ir_settings_storeAccountMapping,
/* harmony export */   "ir_settings_updateAccountMapping": () => /* binding */ ir_settings_updateAccountMapping,
/* harmony export */   "ir_settings_policy_index": () => /* binding */ ir_settings_policy_index,
/* harmony export */   "ir_settings_policies_index": () => /* binding */ ir_settings_policies_index,
/* harmony export */   "ir_settings_policy_create": () => /* binding */ ir_settings_policy_create,
/* harmony export */   "ir_settings_policies_create": () => /* binding */ ir_settings_policies_create,
/* harmony export */   "ir_settings_policy_edit": () => /* binding */ ir_settings_policy_edit,
/* harmony export */   "ir_settings_policies_edit": () => /* binding */ ir_settings_policies_edit,
/* harmony export */   "ir_settings_gasStations_index": () => /* binding */ ir_settings_gasStations_index,
/* harmony export */   "ir_gasStations_gasStation_index": () => /* binding */ ir_gasStations_gasStation_index,
/* harmony export */   "ir_settings_gasStations_create": () => /* binding */ ir_settings_gasStations_create,
/* harmony export */   "ir_settings_gasStations_edit": () => /* binding */ ir_settings_gasStations_edit,
/* harmony export */   "ir_settings_policyGroup_index": () => /* binding */ ir_settings_policyGroup_index,
/* harmony export */   "ir_settings_policyGroup_edit": () => /* binding */ ir_settings_policyGroup_edit,
/* harmony export */   "ir_settings_irp0008_index": () => /* binding */ ir_settings_irp0008_index,
/* harmony export */   "ir_expenseStockAsset_index": () => /* binding */ ir_expenseStockAsset_index,
/* harmony export */   "ir_settings_reportInfo_index": () => /* binding */ ir_settings_reportInfo_index,
/* harmony export */   "ir_settings_reportInfo_show": () => /* binding */ ir_settings_reportInfo_show,
/* harmony export */   "ir_settings_reportInfo_store": () => /* binding */ ir_settings_reportInfo_store,
/* harmony export */   "ir_settings_reportInfo_update": () => /* binding */ ir_settings_reportInfo_update,
/* harmony export */   "ir_settings_reportInfo_destroy": () => /* binding */ ir_settings_reportInfo_destroy,
/* harmony export */   "ir_settings_company_index": () => /* binding */ ir_settings_company_index,
/* harmony export */   "ir_settings_company_create": () => /* binding */ ir_settings_company_create,
/* harmony export */   "ir_settings_company_edit": () => /* binding */ ir_settings_company_edit,
/* harmony export */   "ir_settings_vehicle_index": () => /* binding */ ir_settings_vehicle_index,
/* harmony export */   "ir_settings_vehicle_edit": () => /* binding */ ir_settings_vehicle_edit,
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
/* harmony export */   "ie_report_pdf": () => /* binding */ ie_report_pdf,
/* harmony export */   "inv_requisitionStationery_copy": () => /* binding */ inv_requisitionStationery_copy,
/* harmony export */   "inv_requisitionStationery_approve": () => /* binding */ inv_requisitionStationery_approve,
/* harmony export */   "inv_requisitionStationery_index": () => /* binding */ inv_requisitionStationery_index,
/* harmony export */   "inv_requisitionStationery_create": () => /* binding */ inv_requisitionStationery_create,
/* harmony export */   "inv_requisitionStationery_store": () => /* binding */ inv_requisitionStationery_store,
/* harmony export */   "inv_requisitionStationery_show": () => /* binding */ inv_requisitionStationery_show,
/* harmony export */   "inv_requisitionStationery_edit": () => /* binding */ inv_requisitionStationery_edit,
/* harmony export */   "inv_requisitionStationery_update": () => /* binding */ inv_requisitionStationery_update,
/* harmony export */   "inv_disbursementFuel_addNewCar": () => /* binding */ inv_disbursementFuel_addNewCar,
/* harmony export */   "inv_disbursementFuel_print": () => /* binding */ inv_disbursementFuel_print,
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
/* harmony export */   "planning_machineBiweekly_index": () => /* binding */ planning_machineBiweekly_index,
/* harmony export */   "planning_machineBiweekly_store": () => /* binding */ planning_machineBiweekly_store,
/* harmony export */   "planning_machineBiweekly_update": () => /* binding */ planning_machineBiweekly_update,
/* harmony export */   "planning_machineBiweekly_updateLines": () => /* binding */ planning_machineBiweekly_updateLines,
/* harmony export */   "planning_machineBiweekly_updatePlanPm": () => /* binding */ planning_machineBiweekly_updatePlanPm,
/* harmony export */   "planning_machineBiweekly_downtime": () => /* binding */ planning_machineBiweekly_downtime,
/* harmony export */   "planning_productionBiweekly_index": () => /* binding */ planning_productionBiweekly_index,
/* harmony export */   "planning_productionBiweekly_show": () => /* binding */ planning_productionBiweekly_show,
/* harmony export */   "planning_adjusts_store": () => /* binding */ planning_adjusts_store,
/* harmony export */   "planning_adjusts_show": () => /* binding */ planning_adjusts_show,
/* harmony export */   "planning_followUps_index": () => /* binding */ planning_followUps_index,
/* harmony export */   "planning_productionDaily_show": () => /* binding */ planning_productionDaily_show,
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
/* harmony export */   "pm_materialRequests_index": () => /* binding */ pm_materialRequests_index,
/* harmony export */   "pm_transferProducts_index": () => /* binding */ pm_transferProducts_index,
/* harmony export */   "pm_sendCigarettes_index": () => /* binding */ pm_sendCigarettes_index,
/* harmony export */   "pm_wipRequests_index": () => /* binding */ pm_wipRequests_index,
/* harmony export */   "pm_jams_index": () => /* binding */ pm_jams_index,
/* harmony export */   "pm_ingredientPreparation_index": () => /* binding */ pm_ingredientPreparation_index,
/* harmony export */   "pm_ingredientPreparation_printPdf": () => /* binding */ pm_ingredientPreparation_printPdf,
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
/* harmony export */   "pd_expFormulas_index": () => /* binding */ pd_expFormulas_index,
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
/* harmony export */   "ct_taxMedicine_index": () => /* binding */ ct_taxMedicine_index,
/* harmony export */   "ct_taxMedicine_create": () => /* binding */ ct_taxMedicine_create,
/* harmony export */   "ct_taxMedicine_edit": () => /* binding */ ct_taxMedicine_edit,
/* harmony export */   "ct_ajax_account_index": () => /* binding */ ct_ajax_account_index,
/* harmony export */   "ct_ajax_ptglAccountsInfo_getDataBySegment": () => /* binding */ ct_ajax_ptglAccountsInfo_getDataBySegment,
/* harmony export */   "ct_ajax_ptpmItemNumberV_getCategory": () => /* binding */ ct_ajax_ptpmItemNumberV_getCategory,
/* harmony export */   "ct_ajax_ptpmItemNumberV_getOrganizations": () => /* binding */ ct_ajax_ptpmItemNumberV_getOrganizations,
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
/* harmony export */   "om_0083_index": () => /* binding */ om_0083_index,
/* harmony export */   "om_claim_claimApprove_index": () => /* binding */ om_claim_claimApprove_index
/* harmony export */ });
/* harmony import */ var _routes_json__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./routes.json */ "./resources/js/pm/routes.json");

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

var ajax_pm_plans_yearly_getInfo = 'ajax.pm.plans.yearly.get-info'; //uri: /ajax/pm/plans/yearly/get-info -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getInfo()

var ajax_pm_plans_yearly_getSourceVersions = 'ajax.pm.plans.yearly.get-source-versions'; //uri: /ajax/pm/plans/yearly/get-source-versions -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getSourceVersions()

var ajax_pm_plans_yearly_addNewHeader = 'ajax.pm.plans.yearly.add-new-header'; //uri: /ajax/pm/plans/yearly/add-new-header -> App\Http\Controllers\PM\Ajax\PlanYearlyController.addNewHeader()

var ajax_pm_plans_yearly_getSalePlans = 'ajax.pm.plans.yearly.get-sale-plans'; //uri: /ajax/pm/plans/yearly/get-sale-plans -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getSalePlans()

var ajax_pm_plans_yearly_getLines = 'ajax.pm.plans.yearly.get-lines'; //uri: /ajax/pm/plans/yearly/get-lines -> App\Http\Controllers\PM\Ajax\PlanYearlyController.getLines()

var ajax_pm_plans_yearly_generateLines = 'ajax.pm.plans.yearly.generate-lines'; //uri: /ajax/pm/plans/yearly/generate-lines -> App\Http\Controllers\PM\Ajax\PlanYearlyController.generateLines()

var ajax_pm_plans_yearly_storeLines = 'ajax.pm.plans.yearly.store-lines'; //uri: /ajax/pm/plans/yearly/store-lines -> App\Http\Controllers\PM\Ajax\PlanYearlyController.storeLines()

var ajax_pm_plans_yearly_submitApproval = 'ajax.pm.plans.yearly.submit-approval'; //uri: /ajax/pm/plans/yearly/submit-approval -> App\Http\Controllers\PM\Ajax\PlanYearlyController.submitApproval()

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

var ajax_pm_products_transfers_storeLines = 'ajax.pm.products.transfers.store-lines'; //uri: /ajax/pm/products/transfers/store-lines -> App\Http\Controllers\PM\Ajax\ProductTransferController.storeLines()

var ajax_pm_products_transfers_confirmRequest = 'ajax.pm.products.transfers.confirm-request'; //uri: /ajax/pm/products/transfers/confirm-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.confirmRequest()

var ajax_pm_products_transfers_discardConfirmedRequest = 'ajax.pm.products.transfers.discard-confirmed-request'; //uri: /ajax/pm/products/transfers/discard-confirmed-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.discardConfirmedRequest()

var ajax_pm_products_transfers_cancelRequest = 'ajax.pm.products.transfers.cancel-request'; //uri: /ajax/pm/products/transfers/cancel-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.cancelRequest()

var ajax_pm_products_transfers_submitRequest = 'ajax.pm.products.transfers.submit-request'; //uri: /ajax/pm/products/transfers/submit-request -> App\Http\Controllers\PM\Ajax\ProductTransferController.submitRequest()

var api_db_lookup = 'api.db.lookup'; //uri: /api/lookup -> App\Http\Controllers\DbLookupController.lookup()

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

var pd_ajax_ = 'pd.ajax.'; //uri: /pd/ajax/ohhand-tobacco-forewarn/create/findTobaccoForewarn -> App\Http\Controllers\PD\Settings\Ajax\OhhandTobaccoForewarnController.findTobaccoForewarn()

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

var pm_ajax_ = 'pm.ajax.'; //uri: /pm/ajax/setup-transfer/get-subinventory -> App\Http\Controllers\PM\Settings\Ajax\SetupTransferController.getSubinventory()

var pm_ajax_getItemNumber = 'pm.ajax.get-item-number'; //uri: /pm/ajax/setup-min-max-by-item/get-item-number -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getItemNumber()

var pm_ajax_getDataTable = 'pm.ajax.get-data-table'; //uri: /pm/ajax/get-data-table -> App\Http\Controllers\PM\Settings\Ajex\SavePublicationLayoutController.getDataTable()

var pm_ajax_getOrganization = 'pm.ajax.get-organization'; //uri: /pm/ajax/setup-min-max-by-item/get-organization -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getOrganization()

var pm_ajax_getLocations = 'pm.ajax.get-locations'; //uri: /pm/ajax/setup-min-max-by-item/get-locations -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getLocations()

var pm_ajax_getUom = 'pm.ajax.get-uom'; //uri: /pm/ajax/setup-min-max-by-item/get-uom -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.getUom()

var pm_ajax_destroy = 'pm.ajax.destroy'; //uri: /pm/ajax/setup-min-max-by-item/destroy -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.destroy()

var pm_ajax_search = 'pm.ajax.search'; //uri: /pm/ajax/setup-min-max-by-item/search -> App\Http\Controllers\PM\Settings\Ajax\SetupMinMaxByItemController.search()

var pm_ajax_printConversion_destroy = 'pm.ajax.print-conversion.destroy'; //uri: /pm/ajax/print-conversion/destroy -> App\Http\Controllers\PM\Settings\Ajax\PrintConversionController.destroy()

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

var pm_settings_savePublicationLayout_store = 'pm.settings.save-publication-layout.store'; //uri: /pm/settings/save-publication-layout-store -> App\Http\Controllers\PM\Settings\SavePublicationLayoutController.store()

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

var eam_ajax_plan_search_noversion = 'eam.ajax.plan.search'; //uri: /eam/ajax/plan/{p_year}/version -> App\Http\Controllers\EAM\Ajax\PMPlanController.search()

var eam_ajax_plan_openWorkOrder = 'eam.ajax.plan.open-work-order'; //uri: /eam/ajax/plan/work-order -> App\Http\Controllers\EAM\Ajax\PMPlanController.openWorkOrder()

var eam_ajax_plan_deleteLine = 'eam.ajax.plan.delete-line'; //uri: /eam/ajax/plan/line/{p_plan_id} -> App\Http\Controllers\EAM\Ajax\PMPlanController.deleteLine()

var eam_ajax_plan_fileImport = 'eam.ajax.plan.file-import'; //uri: /eam/ajax/plan/file-import -> App\Http\Controllers\EAM\Ajax\PMPlanController.fileImport()

var eam_ajax_billMaterials_show = 'eam.ajax.bill-materials.show'; //uri: /eam/ajax/bill-materials -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.show()

var eam_ajax_billMaterials_store = 'eam.ajax.bill-materials.store'; //uri: /eam/ajax/bill-materials -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.store()

var eam_ajax_billMaterials_deleteLine = 'eam.ajax.bill-materials.delete-line'; //uri: /eam/ajax/bill-materials -> App\Http\Controllers\EAM\Ajax\BillMaterialsController.deleteLine()

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

var om_ajax_ = 'om.ajax.'; //uri: /om/ajax/debitnote_ranchtran/getorderlist -> App\Http\Controllers\OM\Ajex\DebitNote\DebitNoteAjaxController.getOrderList()

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

var om_ajax_transferBiWeekly_ = 'om.ajax.transfer-bi-weekly.'; //uri: /om/ajax/transfer-bi-weekly/testcash -> App\Http\Controllers\OM\Ajex\Saleorder\Domestic\TransferBiWeeklyAjaxController.testcash()

var om_ajax_overdueDebt_ = 'om.ajax.overdue-debt.'; //uri: /om/ajax/overdue-debt/search -> App\Http\Controllers\OM\Ajex\OverdueDebtAjaxController.searchOverdueDebt()

var om_ajax_overdueDebt_getCustomerName = 'om.ajax.overdue-debt.get-customer-name'; //uri: /om/ajax/overdue-debt/get-customer-name/{id} -> App\Http\Controllers\OM\Ajex\OverdueDebtAjaxController.getCustomersName()

var om_ajax_fortnightly = 'om.ajax.fortnightly'; //uri: /om/ajax/fortnightly/sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.sequenceEcoms()

var om_ajax_fortnightlyupdate_sequence_ecom = 'om.ajax.fortnightlyupdate.sequence.ecom'; //uri: /om/ajax/fortnightly/update-sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.updateSequenceEcoms()

var om_ajax_fortnightlydelete_sequence_ecom = 'om.ajax.fortnightlydelete.sequence.ecom'; //uri: /om/ajax/fortnightly/delete-sequence-ecom -> App\Http\Controllers\OM\Ajex\SequenceFortnightlyAjaxController.deleteSequenceEcoms()

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

var om_ajax_proformaInvoicecreate_proforma_invoice = 'om.ajax.proforma-invoicecreate.proforma.invoice'; //uri: /om/ajax/proforma-invoice/create-proforma-invoice/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.createProformaInvoice()

var om_proformaInvoicecreate_proforma_invoice = 'om.proforma-invoicecreate.proforma.invoice'; //uri: /om/ajax/proforma-invoice/create-proforma-invoice/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.createProformaInvoice()

var om_ajax_proformaInvoicemanage_proforma_invoice = 'om.ajax.proforma-invoicemanage.proforma.invoice'; //uri: /om/ajax/proforma-invoice/manage-proforma-invoice -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.manageProformaInvoice()

var om_ajax_proformaInvoicecreate_proforma_lot = 'om.ajax.proforma-invoicecreate.proforma.lot'; //uri: /om/ajax/proforma-invoice/create-proforma-lot/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.createProformaLot()

var om_ajax_proformaInvoiceget_proforma_lot = 'om.ajax.proforma-invoiceget.proforma.lot'; //uri: /om/ajax/proforma-invoice/get-proforma-lot/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.getProformaLot()

var om_ajax_proformaInvoicecheckCancel = 'om.ajax.proforma-invoicecheck-cancel'; //uri: /om/ajax/proforma-invoice/check-cancel/{number} -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.checkCancel()

var om_ajax_proformaInvoicecancel = 'om.ajax.proforma-invoicecancel'; //uri: /om/ajax/proforma-invoice/cancel -> App\Http\Controllers\OM\Ajex\ProformaInvoiceAjaxController.cancel()

var om_ajax_taxInvoiceExportcreate = 'om.ajax.tax-invoice-exportcreate'; //uri: /om/ajax/tax-invoice-export/create/{number} -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.create()

var om_ajax_taxInvoiceExportsearch = 'om.ajax.tax-invoice-exportsearch'; //uri: /om/ajax/tax-invoice-export/search/{number} -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.search()

var om_ajax_taxInvoiceExportmanage = 'om.ajax.tax-invoice-exportmanage'; //uri: /om/ajax/tax-invoice-export/manage -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.manage()

var om_ajax_taxInvoiceExportcheckCancel = 'om.ajax.tax-invoice-exportcheck-cancel'; //uri: /om/ajax/tax-invoice-export/check-cancel/{number} -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.checkCancel()

var om_ajax_taxInvoiceExportcancel = 'om.ajax.tax-invoice-exportcancel'; //uri: /om/ajax/tax-invoice-export/cancel -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.cancel()

var om_ajax_taxInvoiceExportcloseWork = 'om.ajax.tax-invoice-exportclose-work'; //uri: /om/ajax/tax-invoice-export/close-work/{number} -> App\Http\Controllers\OM\Ajex\TaxInvoiceExportAjaxController.closeWork()

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

var om_ = 'om.'; //uri: /om/debit-note -> App\Http\Controllers\OM\DebitNote\DebitNoteController.index()

var om_additionIndex = 'om.addition-index'; //uri: /om/addition-quota -> App\Http\Controllers\OM\AdditionQuotaController.index()

var om_additionQuota = 'om.addition-quota'; //uri: /om/addition-quota/approve/step/{id}/{step} -> App\Http\Controllers\OM\AdditionQuotaController.stepone()

var om_additionUpload = 'om.addition-upload'; //uri: /om/addition-quota/upload/file -> App\Http\Controllers\OM\AdditionQuotaController.upload()

var om_additionFilesdelete = 'om.addition-filesdelete'; //uri: /om/addition-quota/delete/file -> App\Http\Controllers\OM\AdditionQuotaController.filesdelete()

var om_additionQuotaUpdate = 'om.addition-quota-update'; //uri: /om/addition-quota/approve/step/update -> App\Http\Controllers\OM\AdditionQuotaController.stepupdate()

var om_cancelConsignment = 'om.cancel-consignment'; //uri: /om/consignment/cancel -> App\Http\Controllers\OM\ConsignmentController.cancel()

var om_canceledConsignment = 'om.canceled-consignment'; //uri: /om/consignment/canceled -> App\Http\Controllers\OM\ConsignmentController.canceled()

var om_deliveryRateIndex = 'om.delivery-rate-index'; //uri: /om/delivery-rate -> App\Http\Controllers\OM\DeliveryRateController.index()

var om_deliveryRateStore = 'om.delivery-rate-store'; //uri: /om/delivery-rate/store -> App\Http\Controllers\OM\DeliveryRateController.store()

var om_draftPayoutIndex = 'om.draft-payout-index'; //uri: /om/draft-payout -> App\Http\Controllers\OM\DraftPayOutController.index()

var om_draftPayoutListproduct = 'om.draft-payout-listproduct'; //uri: /om/draft-payout/listproduct -> App\Http\Controllers\OM\DraftPayOutController.listProduct()

var om_draftPayoutStoreDraft = 'om.draft-payout-storeDraft'; //uri: /om/draft-payout/storeDraft -> App\Http\Controllers\OM\DraftPayOutController.storeDraft()

var om_domesticMatchingIndex = 'om.domestic-matching-index'; //uri: /om/domestic-matching -> App\Http\Controllers\OM\PaymentMethodMatchingController.index()

var om_domesticMatchingGetData = 'om.domestic-matching-getData'; //uri: /om/domestic-matching/getData -> App\Http\Controllers\OM\PaymentMethodMatchingController.getDataFirsttime()

var om_domesticMatchingUploaded = 'om.domestic-matching-uploaded'; //uri: /om/domestic-matching/uploaded -> App\Http\Controllers\OM\PaymentMethodMatchingController.uploaded()

var om_domesticMatchingUploadDeleted = 'om.domestic-matching-upload-deleted'; //uri: /om/domestic-matching/uploaded -> App\Http\Controllers\OM\PaymentMethodMatchingController.uploaded()

var om_domesticMatchingUnmatching = 'om.domestic-matching-unmatching'; //uri: /om/domestic-matching/unmatching -> App\Http\Controllers\OM\PaymentMethodMatchingController.unmatching()

var om_domesticMatchingMatching = 'om.domestic-matching-matching'; //uri: /om/domestic-matching/matching -> App\Http\Controllers\OM\PaymentMethodMatchingController.matching()

var om_domesticMatchingGetinvoice = 'om.domestic-matching-getinvoice'; //uri: /om/domestic-matching/getinvoice -> App\Http\Controllers\OM\PaymentMethodMatchingController.getinvoice()

var om_domesticMatchingGetamount = 'om.domestic-matching-getamount'; //uri: /om/domestic-matching/getamount -> App\Http\Controllers\OM\PaymentMethodMatchingController.getamount()

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

var om_exportPayoutIndex = 'om.export-payout-index'; //uri: /om/export-payout -> App\Http\Controllers\OM\Export\PaymentMethodController.index()

var om_exportPayoutGetlistbank = 'om.export-payout-getlistbank'; //uri: /om/export-payout/getlistbank -> App\Http\Controllers\OM\Export\PaymentMethodController.getBankfromLogic()

var om_exportPayoutGetvaluebank = 'om.export-payout-getvaluebank'; //uri: /om/export-payout/getvaluebank -> App\Http\Controllers\OM\Export\PaymentMethodController.getvaluebank()

var om_exportPayoutGetpaymentnumber = 'om.export-payout-getpaymentnumber'; //uri: /om/export-payout/getpaymentnumber -> App\Http\Controllers\OM\Export\PaymentMethodController.getPaymentNumber()

var om_exportPaymentMethodDraftpayment = 'om.export-payment-method-draftpayment'; //uri: /om/export-payout/draftpayment -> App\Http\Controllers\OM\Export\PaymentMethodController.draftpayment()

var om_exportMethodPaymentUpload = 'om.export-method-payment-upload'; //uri: /om/export-payout/payment/upload -> App\Http\Controllers\OM\Export\PaymentMethodController.paymentupload()

var om_exportMethodPaymentDelete = 'om.export-method-payment-delete'; //uri: /om/export-payout/payment/files/delete -> App\Http\Controllers\OM\Export\PaymentMethodController.filesdelete()

var om_exportMethodPayment = 'om.export-method-payment'; //uri: /om/export-payout/payment -> App\Http\Controllers\OM\Export\PaymentMethodController.payment()

var om_exportMethodPrint = 'om.export-method-print'; //uri: /om/export-payout/print/{id} -> App\Http\Controllers\OM\Export\PaymentMethodController.print()

var om_exportMatchingIndex = 'om.export-matching-index'; //uri: /om/export-matching -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.index()

var om_exportMatchingUnmatching = 'om.export-matching-unmatching'; //uri: /om/export-matching/unmatching -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.unmatching()

var om_exportMatchingUploaded = 'om.export-matching-uploaded'; //uri: /om/export-matching/uploaded -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.uploaded()

var om_exportMatchingUploadDeleted = 'om.export-matching-upload-deleted'; //uri: /om/export-matching/upload/deleted -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.filesdelete()

var om_exportMatchingGetData = 'om.export-matching-getData'; //uri: /om/export-matching/getData -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.getDataFirsttime()

var om_exportMatchingMatching = 'om.export-matching-matching'; //uri: /om/export-matching/matching -> App\Http\Controllers\OM\Export\PaymentMethodMatchingController.matching()

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

var om_approvePrepare_print = 'om.approve-prepare.print'; //uri: /om/approve-prepare/print/{id} -> App\Http\Controllers\OM\ApprovePrepareOrderController.print()

var om_outstanding_index = 'om.outstanding.index'; //uri: /om/outstanding -> App\Http\Controllers\OM\OutstandingController.index()

var om_outstanding_getData = 'om.outstanding.getData'; //uri: /om/outstanding-list -> App\Http\Controllers\OM\OutstandingController.getData()

var om_outstanding_getYear = 'om.outstanding.getYear'; //uri: /om/outstanding-year -> App\Http\Controllers\OM\OutstandingController.getYear()

var ir_ajax_subGroups_show = 'ir.ajax.sub-groups.show'; //uri: /ir/ajax/sub-groups/show/{policy_set_header_id} -> App\Http\Controllers\IR\Settings\Ajax\SubGroupsController.show()

var ir_ajax_productGroups_updateActiveFlag = 'ir.ajax.product-groups.updateActiveFlag'; //uri: /ir/ajax/product-groups/updateActiveFlag -> App\Http\Controllers\IR\Settings\Ajax\GroupProductsController.updateActiveFlag()

var ir_ajax_subGroups_checkInactive = 'ir.ajax.sub-groups.checkInactive'; //uri: /ir/ajax/sub-groups/check-inactive -> App\Http\Controllers\IR\Settings\Ajax\SubGroupsController.checkInactive()

var ir_ajax_productGroup = 'ir.ajax.product-group'; //uri: /ir/ajax/product-group -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.index()

var ir_settings_productGroup = 'ir.settings.product-group'; //uri: /ir/ajax/product-group -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.index()

var ir_ajax_getLocator = 'ir.ajax.get-locator'; //uri: /ir/ajax/get-locator -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getLocator()

var ir_settings_getLocator = 'ir.settings.get-locator'; //uri: /ir/ajax/get-locator -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getLocator()

var ir_ajax_updateActiveFlag = 'ir.ajax.updateActiveFlag'; //uri: /ir/ajax/updateActiveFlag -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.updateActiveFlag()

var ir_ajax_destroy = 'ir.ajax.destroy'; //uri: /ir/ajax/destroy -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.destroy()

var ir_ajax_getValueSet = 'ir.ajax.getValueSet'; //uri: /ir/ajax/get-value-set -> App\Http\Controllers\IR\Settings\Ajax\ProductGroupController.getValueSet()

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

var ir_ajax_vehiclesUpdate = 'ir.ajax.vehicles-update'; //uri: /ir/ajax/vehicles -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.update()

var ir_ajax_vehiclesActiveFlag = 'ir.ajax.vehicles-active-flag'; //uri: /ir/ajax/vehicles/active-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateActiveFlag()

var ir_ajax_vehiclesUpdateActiveFlag = 'ir.ajax.vehicles-update-active-flag'; //uri: /ir/ajax/vehicles/active-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateActiveFlag()

var ir_ajax_vehiclesReturnVatFlag = 'ir.ajax.vehicles-return-vat-flag'; //uri: /ir/ajax/vehicles/return-vat-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateReturnVatFlag()

var ir_ajax_vehiclesUpdateReturnVatFlag = 'ir.ajax.vehicles-update-return-vat-flag'; //uri: /ir/ajax/vehicles/return-vat-flag -> App\Http\Controllers\IR\Ajax\Settings\VehiclesController.updateReturnVatFlag()

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

var ir_ajax_irReportGetInfoAttribute = 'ir.ajax.ir-report-get-info-attribute'; //uri: /ir/ajax/ir-report-get-info-attribute -> App\Http\Controllers\IR\Ajax\IrReportsController.getInfoAttribute()

var ir_ajax_irReportSubmit = 'ir.ajax.ir-report-submit'; //uri: /ir/ajax/ir-report-submit -> App\Http\Controllers\IR\Ajax\IrReportsController.irReportSubmit()

var ir_settings_storeAccountMapping = 'ir.settings.store-account-mapping'; //uri: /ir/settings/account-mapping/save -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.store()

var ir_settings_updateAccountMapping = 'ir.settings.update-account-mapping'; //uri: /ir/settings/account-mapping/update -> App\Http\Controllers\IR\Settings\Ajax\AccountMappingController.update()

var ir_settings_policy_index = 'ir.settings.policy.index'; //uri: /ir/settings/policy -> App\Http\Controllers\IR\Settings\PolicyController.index()

var ir_settings_policies_index = 'ir.settings.policies.index'; //uri: /ir/settings/policy -> App\Http\Controllers\IR\Settings\PolicyController.index()

var ir_settings_policy_create = 'ir.settings.policy.create'; //uri: /ir/settings/policy/create -> App\Http\Controllers\IR\Settings\PolicyController.create()

var ir_settings_policies_create = 'ir.settings.policies.create'; //uri: /ir/settings/policy/create -> App\Http\Controllers\IR\Settings\PolicyController.create()

var ir_settings_policy_edit = 'ir.settings.policy.edit'; //uri: /ir/settings/policy/edit/{id} -> App\Http\Controllers\IR\Settings\PolicyController.edit()

var ir_settings_policies_edit = 'ir.settings.policies.edit'; //uri: /ir/settings/policy/edit/{id} -> App\Http\Controllers\IR\Settings\PolicyController.edit()

var ir_settings_gasStations_index = 'ir.settings.gas-stations.index'; //uri: /ir/settings/gas-stations -> App\Http\Controllers\IR\GasStationsController.index()

var ir_gasStations_gasStation_index = 'ir.gas-stations.gas-station.index'; //uri: /ir/settings/gas-stations -> App\Http\Controllers\IR\GasStationsController.index()

var ir_settings_gasStations_create = 'ir.settings.gas-stations.create'; //uri: /ir/settings/gas-stations/create -> App\Http\Controllers\IR\GasStationsController.create()

var ir_settings_gasStations_edit = 'ir.settings.gas-stations.edit'; //uri: /ir/settings/gas-stations/edit -> App\Http\Controllers\IR\GasStationsController.edit()

var ir_settings_policyGroup_index = 'ir.settings.policy-group.index'; //uri: /ir/settings/policy-group -> App\Http\Controllers\IR\Settings\PolicyGroupController.index()

var ir_settings_policyGroup_edit = 'ir.settings.policy-group.edit'; //uri: /ir/settings/policy-group/edit/{id} -> App\Http\Controllers\IR\Settings\PolicyGroupController.edit()

var ir_settings_irp0008_index = 'ir.settings.irp-0008.index'; //uri: /ir/settings/irp-0008 -> App\Http\Controllers\IR\ExpenseStockAssetController.index()

var ir_expenseStockAsset_index = 'ir.expense-stock-asset.index'; //uri: /ir/settings/irp-0008 -> App\Http\Controllers\IR\ExpenseStockAssetController.index()

var ir_settings_reportInfo_index = 'ir.settings.report-info.index'; //uri: /ir/settings/report-info -> App\Http\Controllers\IR\Settings\ReportInfoController.index()

var ir_settings_reportInfo_show = 'ir.settings.report-info.show'; //uri: /ir/settings/report-info/{program} -> App\Http\Controllers\IR\Settings\ReportInfoController.show()

var ir_settings_reportInfo_store = 'ir.settings.report-info.store'; //uri: /ir/settings/report-info/{program}/store -> App\Http\Controllers\IR\Settings\ReportInfoController.store()

var ir_settings_reportInfo_update = 'ir.settings.report-info.update'; //uri: /ir/settings/report-info/{program}/{info} -> App\Http\Controllers\IR\Settings\ReportInfoController.update()

var ir_settings_reportInfo_destroy = 'ir.settings.report-info.destroy'; //uri: /ir/settings/report-info/{program}/{info}/delete -> App\Http\Controllers\IR\Settings\ReportInfoController.destroy()

var ir_settings_company_index = 'ir.settings.company.index'; //uri: /ir/settings/company -> App\Http\Controllers\IR\Settings\CompanyController.index()

var ir_settings_company_create = 'ir.settings.company.create'; //uri: /ir/settings/company/create -> App\Http\Controllers\IR\Settings\CompanyController.create()

var ir_settings_company_edit = 'ir.settings.company.edit'; //uri: /ir/settings/company/edit/{id} -> App\Http\Controllers\IR\Settings\CompanyController.edit()

var ir_settings_vehicle_index = 'ir.settings.vehicle.index'; //uri: /ir/settings/vehicle -> App\Http\Controllers\IR\Settings\VehicleController.index()

var ir_settings_vehicle_edit = 'ir.settings.vehicle.edit'; //uri: /ir/settings/vehicle/edit/{id} -> App\Http\Controllers\IR\Settings\VehicleController.edit()

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

var ie_report_pdf = 'ie.report.pdf'; //uri: /ie/report/{parent} -> App\Http\Controllers\IE\ReportController.pdf()

var inv_requisitionStationery_copy = 'inv.requisition_stationery.copy'; //uri: /inv/requisition_stationery/{id}/copy -> App\Http\Controllers\INV\RequisitionStationeryController.copy()

var inv_requisitionStationery_approve = 'inv.requisition_stationery.approve'; //uri: /inv/requisition_stationery/{id}/approve -> App\Http\Controllers\INV\RequisitionStationeryController.approve()

var inv_requisitionStationery_index = 'inv.requisition_stationery.index'; //uri: /inv/requisition_stationery -> App\Http\Controllers\INV\RequisitionStationeryController.index()

var inv_requisitionStationery_create = 'inv.requisition_stationery.create'; //uri: /inv/requisition_stationery/create -> App\Http\Controllers\INV\RequisitionStationeryController.create()

var inv_requisitionStationery_store = 'inv.requisition_stationery.store'; //uri: /inv/requisition_stationery -> App\Http\Controllers\INV\RequisitionStationeryController.store()

var inv_requisitionStationery_show = 'inv.requisition_stationery.show'; //uri: /inv/requisition_stationery/{requisition_stationery} -> App\Http\Controllers\INV\RequisitionStationeryController.show()

var inv_requisitionStationery_edit = 'inv.requisition_stationery.edit'; //uri: /inv/requisition_stationery/{requisition_stationery}/edit -> App\Http\Controllers\INV\RequisitionStationeryController.edit()

var inv_requisitionStationery_update = 'inv.requisition_stationery.update'; //uri: /inv/requisition_stationery/{requisition_stationery} -> App\Http\Controllers\INV\RequisitionStationeryController.update()

var inv_disbursementFuel_addNewCar = 'inv.disbursement_fuel.add_new_car'; //uri: /inv/disbursement_fuel/add_new_car -> App\Http\Controllers\INV\DisbursementFuelController.save()

var inv_disbursementFuel_print = 'inv.disbursement_fuel.print'; //uri: /inv/disbursement_fuel/print -> App\Http\Controllers\INV\DisbursementFuelController.printReport()

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

var planning_machineBiweekly_index = 'planning.machine-biweekly.index'; //uri: /planning/machine-biweekly -> App\Http\Controllers\Planning\MachineBiWeeklyController.index()

var planning_machineBiweekly_store = 'planning.machine-biweekly.store'; //uri: /planning/machine-biweekly -> App\Http\Controllers\Planning\MachineBiWeeklyController.store()

var planning_machineBiweekly_update = 'planning.machine-biweekly.update'; //uri: /planning/machine-biweekly/{id}/update -> App\Http\Controllers\Planning\MachineBiWeeklyController.update()

var planning_machineBiweekly_updateLines = 'planning.machine-biweekly.update-lines'; //uri: /planning/machine-biweekly/{id}/update-lines -> App\Http\Controllers\Planning\MachineBiWeeklyController.updateLine()

var planning_machineBiweekly_updatePlanPm = 'planning.machine-biweekly.update_plan_pm'; //uri: /planning/update_plan_pm/{biweeklyId} -> App\Http\Controllers\Planning\MachineBiWeeklyController.UpdateEAMChangePm()

var planning_machineBiweekly_downtime = 'planning.machine-biweekly.downtime'; //uri: /planning/machine-downtime -> App\Http\Controllers\Planning\MachineBiWeeklyController.machinedDowntime()

var planning_productionBiweekly_index = 'planning.production-biweekly.index'; //uri: /planning/production-biweekly -> App\Http\Controllers\Planning\ProductBiWeeklyController.index()

var planning_productionBiweekly_show = 'planning.production-biweekly.show'; //uri: /planning/production-biweekly/{production_biweekly} -> App\Http\Controllers\Planning\ProductBiWeeklyController.show()

var planning_adjusts_store = 'planning.adjusts.store'; //uri: /planning/adjusts -> App\Http\Controllers\Planning\AdjustController.store()

var planning_adjusts_show = 'planning.adjusts.show'; //uri: /planning/adjusts/{adjust} -> App\Http\Controllers\Planning\AdjustController.show()

var planning_followUps_index = 'planning.follow-ups.index'; //uri: /planning/follow-ups -> App\Http\Controllers\Planning\FollowUpController.index()

var planning_productionDaily_show = 'planning.production-daily.show'; //uri: /planning/production-daily/{id} -> App\Http\Controllers\Planning\ProductionDailyController.show()

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

var pm_materialRequests_index = 'pm.material-requests.index'; //uri: /pm/material-requests -> App\Http\Controllers\PM\MaterialRequestController.index()

var pm_transferProducts_index = 'pm.transfer-products.index'; //uri: /pm/transfer-products -> App\Http\Controllers\PM\TransferProductController.index()

var pm_sendCigarettes_index = 'pm.send-cigarettes.index'; //uri: /pm/send-cigarettes -> App\Http\Controllers\PM\SendCigaretteController.index()

var pm_wipRequests_index = 'pm.wip-requests.index'; //uri: /pm/wip-requests -> App\Http\Controllers\PM\WipRequestController.index()

var pm_jams_index = 'pm.jams.index'; //uri: /pm/jams -> App\Http\Controllers\PM\JamController.index()

var pm_ingredientPreparation_index = 'pm.ingredient-preparation.index'; //uri: /pm/ingredient-preparation -> App\Http\Controllers\PM\IngredientPreparationController.index()

var pm_ingredientPreparation_printPdf = 'pm.ingredient-preparation.print-pdf'; //uri: /pm/ingredient-preparation/print-pdf -> App\Http\Controllers\PM\IngredientPreparationController.printPdf()

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

var pd_expFormulas_index = 'pd.exp-formulas.index'; //uri: /pd/exp-formulas -> App\Http\Controllers\PD\ExpFormulaController.index()

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

var ct_taxMedicine_index = 'ct.tax_medicine.index'; //uri: /ct/tax_medicine -> App\Http\Controllers\CT\TaxMedicineController.index()

var ct_taxMedicine_create = 'ct.tax_medicine.create'; //uri: /ct/tax_medicine/create -> App\Http\Controllers\CT\TaxMedicineController.create()

var ct_taxMedicine_edit = 'ct.tax_medicine.edit'; //uri: /ct/tax_medicine/{tax_medicine} -> App\Http\Controllers\CT\TaxMedicineController.edit()

var ct_ajax_account_index = 'ct.ajax.account.index'; //uri: /ct/ajax/account -> App\Http\Controllers\CT\Ajax\AccountController.index()

var ct_ajax_ptglAccountsInfo_getDataBySegment = 'ct.ajax.ptgl_accounts_info.get_data_by_segment'; //uri: /ct/ajax/get_data_by_segment/{segment} -> App\Http\Controllers\CT\Ajax\PtglAccountsInfoController.getDataBySegment()

var ct_ajax_ptpmItemNumberV_getCategory = 'ct.ajax.ptpm_item_number_v.get_category'; //uri: /ct/ajax/get_category -> App\Http\Controllers\CT\Ajax\PtpmItemNumberVController.getCategory()

var ct_ajax_ptpmItemNumberV_getOrganizations = 'ct.ajax.ptpm_item_number_v.get_organizations'; //uri: /ct/ajax/get_organizations -> App\Http\Controllers\CT\Ajax\PtinvOrganizationsInfoController.getOrganizations()

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

var om_0083_index = 'om.0083.index'; //uri: /om/0083 -> App\Http\Controllers\OM\Web\ClaimApproveController.index()

var om_claim_claimApprove_index = 'om.claim/claim-approve.index'; //uri: /om/0083 -> App\Http\Controllers\OM\Web\ClaimApproveController.index()

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "th,\ntd {\n  vertical-align: middle !important;\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/luxon/build/cjs-browser/luxon.js":
/*!*******************************************************!*\
  !*** ./node_modules/luxon/build/cjs-browser/luxon.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({ value: true }));

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

function _inheritsLoose(subClass, superClass) {
  subClass.prototype = Object.create(superClass.prototype);
  subClass.prototype.constructor = subClass;
  subClass.__proto__ = superClass;
}

function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

function _isNativeReflectConstruct() {
  if (typeof Reflect === "undefined" || !Reflect.construct) return false;
  if (Reflect.construct.sham) return false;
  if (typeof Proxy === "function") return true;

  try {
    Date.prototype.toString.call(Reflect.construct(Date, [], function () {}));
    return true;
  } catch (e) {
    return false;
  }
}

function _construct(Parent, args, Class) {
  if (_isNativeReflectConstruct()) {
    _construct = Reflect.construct;
  } else {
    _construct = function _construct(Parent, args, Class) {
      var a = [null];
      a.push.apply(a, args);
      var Constructor = Function.bind.apply(Parent, a);
      var instance = new Constructor();
      if (Class) _setPrototypeOf(instance, Class.prototype);
      return instance;
    };
  }

  return _construct.apply(null, arguments);
}

function _isNativeFunction(fn) {
  return Function.toString.call(fn).indexOf("[native code]") !== -1;
}

function _wrapNativeSuper(Class) {
  var _cache = typeof Map === "function" ? new Map() : undefined;

  _wrapNativeSuper = function _wrapNativeSuper(Class) {
    if (Class === null || !_isNativeFunction(Class)) return Class;

    if (typeof Class !== "function") {
      throw new TypeError("Super expression must either be null or a function");
    }

    if (typeof _cache !== "undefined") {
      if (_cache.has(Class)) return _cache.get(Class);

      _cache.set(Class, Wrapper);
    }

    function Wrapper() {
      return _construct(Class, arguments, _getPrototypeOf(this).constructor);
    }

    Wrapper.prototype = Object.create(Class.prototype, {
      constructor: {
        value: Wrapper,
        enumerable: false,
        writable: true,
        configurable: true
      }
    });
    return _setPrototypeOf(Wrapper, Class);
  };

  return _wrapNativeSuper(Class);
}

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;

  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }

  return target;
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(n);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

  return arr2;
}

function _createForOfIteratorHelperLoose(o) {
  var i = 0;

  if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) {
    if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) return function () {
      if (i >= o.length) return {
        done: true
      };
      return {
        done: false,
        value: o[i++]
      };
    };
    throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }

  i = o[Symbol.iterator]();
  return i.next.bind(i);
}

// these aren't really private, but nor are they really useful to document

/**
 * @private
 */
var LuxonError = /*#__PURE__*/function (_Error) {
  _inheritsLoose(LuxonError, _Error);

  function LuxonError() {
    return _Error.apply(this, arguments) || this;
  }

  return LuxonError;
}( /*#__PURE__*/_wrapNativeSuper(Error));
/**
 * @private
 */


var InvalidDateTimeError = /*#__PURE__*/function (_LuxonError) {
  _inheritsLoose(InvalidDateTimeError, _LuxonError);

  function InvalidDateTimeError(reason) {
    return _LuxonError.call(this, "Invalid DateTime: " + reason.toMessage()) || this;
  }

  return InvalidDateTimeError;
}(LuxonError);
/**
 * @private
 */

var InvalidIntervalError = /*#__PURE__*/function (_LuxonError2) {
  _inheritsLoose(InvalidIntervalError, _LuxonError2);

  function InvalidIntervalError(reason) {
    return _LuxonError2.call(this, "Invalid Interval: " + reason.toMessage()) || this;
  }

  return InvalidIntervalError;
}(LuxonError);
/**
 * @private
 */

var InvalidDurationError = /*#__PURE__*/function (_LuxonError3) {
  _inheritsLoose(InvalidDurationError, _LuxonError3);

  function InvalidDurationError(reason) {
    return _LuxonError3.call(this, "Invalid Duration: " + reason.toMessage()) || this;
  }

  return InvalidDurationError;
}(LuxonError);
/**
 * @private
 */

var ConflictingSpecificationError = /*#__PURE__*/function (_LuxonError4) {
  _inheritsLoose(ConflictingSpecificationError, _LuxonError4);

  function ConflictingSpecificationError() {
    return _LuxonError4.apply(this, arguments) || this;
  }

  return ConflictingSpecificationError;
}(LuxonError);
/**
 * @private
 */

var InvalidUnitError = /*#__PURE__*/function (_LuxonError5) {
  _inheritsLoose(InvalidUnitError, _LuxonError5);

  function InvalidUnitError(unit) {
    return _LuxonError5.call(this, "Invalid unit " + unit) || this;
  }

  return InvalidUnitError;
}(LuxonError);
/**
 * @private
 */

var InvalidArgumentError = /*#__PURE__*/function (_LuxonError6) {
  _inheritsLoose(InvalidArgumentError, _LuxonError6);

  function InvalidArgumentError() {
    return _LuxonError6.apply(this, arguments) || this;
  }

  return InvalidArgumentError;
}(LuxonError);
/**
 * @private
 */

var ZoneIsAbstractError = /*#__PURE__*/function (_LuxonError7) {
  _inheritsLoose(ZoneIsAbstractError, _LuxonError7);

  function ZoneIsAbstractError() {
    return _LuxonError7.call(this, "Zone is an abstract class") || this;
  }

  return ZoneIsAbstractError;
}(LuxonError);

/**
 * @private
 */
var n = "numeric",
    s = "short",
    l = "long";
var DATE_SHORT = {
  year: n,
  month: n,
  day: n
};
var DATE_MED = {
  year: n,
  month: s,
  day: n
};
var DATE_MED_WITH_WEEKDAY = {
  year: n,
  month: s,
  day: n,
  weekday: s
};
var DATE_FULL = {
  year: n,
  month: l,
  day: n
};
var DATE_HUGE = {
  year: n,
  month: l,
  day: n,
  weekday: l
};
var TIME_SIMPLE = {
  hour: n,
  minute: n
};
var TIME_WITH_SECONDS = {
  hour: n,
  minute: n,
  second: n
};
var TIME_WITH_SHORT_OFFSET = {
  hour: n,
  minute: n,
  second: n,
  timeZoneName: s
};
var TIME_WITH_LONG_OFFSET = {
  hour: n,
  minute: n,
  second: n,
  timeZoneName: l
};
var TIME_24_SIMPLE = {
  hour: n,
  minute: n,
  hour12: false
};
/**
 * {@link toLocaleString}; format like '09:30:23', always 24-hour.
 */

var TIME_24_WITH_SECONDS = {
  hour: n,
  minute: n,
  second: n,
  hour12: false
};
/**
 * {@link toLocaleString}; format like '09:30:23 EDT', always 24-hour.
 */

var TIME_24_WITH_SHORT_OFFSET = {
  hour: n,
  minute: n,
  second: n,
  hour12: false,
  timeZoneName: s
};
/**
 * {@link toLocaleString}; format like '09:30:23 Eastern Daylight Time', always 24-hour.
 */

var TIME_24_WITH_LONG_OFFSET = {
  hour: n,
  minute: n,
  second: n,
  hour12: false,
  timeZoneName: l
};
/**
 * {@link toLocaleString}; format like '10/14/1983, 9:30 AM'. Only 12-hour if the locale is.
 */

var DATETIME_SHORT = {
  year: n,
  month: n,
  day: n,
  hour: n,
  minute: n
};
/**
 * {@link toLocaleString}; format like '10/14/1983, 9:30:33 AM'. Only 12-hour if the locale is.
 */

var DATETIME_SHORT_WITH_SECONDS = {
  year: n,
  month: n,
  day: n,
  hour: n,
  minute: n,
  second: n
};
var DATETIME_MED = {
  year: n,
  month: s,
  day: n,
  hour: n,
  minute: n
};
var DATETIME_MED_WITH_SECONDS = {
  year: n,
  month: s,
  day: n,
  hour: n,
  minute: n,
  second: n
};
var DATETIME_MED_WITH_WEEKDAY = {
  year: n,
  month: s,
  day: n,
  weekday: s,
  hour: n,
  minute: n
};
var DATETIME_FULL = {
  year: n,
  month: l,
  day: n,
  hour: n,
  minute: n,
  timeZoneName: s
};
var DATETIME_FULL_WITH_SECONDS = {
  year: n,
  month: l,
  day: n,
  hour: n,
  minute: n,
  second: n,
  timeZoneName: s
};
var DATETIME_HUGE = {
  year: n,
  month: l,
  day: n,
  weekday: l,
  hour: n,
  minute: n,
  timeZoneName: l
};
var DATETIME_HUGE_WITH_SECONDS = {
  year: n,
  month: l,
  day: n,
  weekday: l,
  hour: n,
  minute: n,
  second: n,
  timeZoneName: l
};

/*
  This is just a junk drawer, containing anything used across multiple classes.
  Because Luxon is small(ish), this should stay small and we won't worry about splitting
  it up into, say, parsingUtil.js and basicUtil.js and so on. But they are divided up by feature area.
*/
/**
 * @private
 */
// TYPES

function isUndefined(o) {
  return typeof o === "undefined";
}
function isNumber(o) {
  return typeof o === "number";
}
function isInteger(o) {
  return typeof o === "number" && o % 1 === 0;
}
function isString(o) {
  return typeof o === "string";
}
function isDate(o) {
  return Object.prototype.toString.call(o) === "[object Date]";
} // CAPABILITIES

function hasIntl() {
  try {
    return typeof Intl !== "undefined" && Intl.DateTimeFormat;
  } catch (e) {
    return false;
  }
}
function hasFormatToParts() {
  return !isUndefined(Intl.DateTimeFormat.prototype.formatToParts);
}
function hasRelative() {
  try {
    return typeof Intl !== "undefined" && !!Intl.RelativeTimeFormat;
  } catch (e) {
    return false;
  }
} // OBJECTS AND ARRAYS

function maybeArray(thing) {
  return Array.isArray(thing) ? thing : [thing];
}
function bestBy(arr, by, compare) {
  if (arr.length === 0) {
    return undefined;
  }

  return arr.reduce(function (best, next) {
    var pair = [by(next), next];

    if (!best) {
      return pair;
    } else if (compare(best[0], pair[0]) === best[0]) {
      return best;
    } else {
      return pair;
    }
  }, null)[1];
}
function pick(obj, keys) {
  return keys.reduce(function (a, k) {
    a[k] = obj[k];
    return a;
  }, {});
}
function hasOwnProperty(obj, prop) {
  return Object.prototype.hasOwnProperty.call(obj, prop);
} // NUMBERS AND STRINGS

function integerBetween(thing, bottom, top) {
  return isInteger(thing) && thing >= bottom && thing <= top;
} // x % n but takes the sign of n instead of x

function floorMod(x, n) {
  return x - n * Math.floor(x / n);
}
function padStart(input, n) {
  if (n === void 0) {
    n = 2;
  }

  var minus = input < 0 ? "-" : "";
  var target = minus ? input * -1 : input;
  var result;

  if (target.toString().length < n) {
    result = ("0".repeat(n) + target).slice(-n);
  } else {
    result = target.toString();
  }

  return "" + minus + result;
}
function parseInteger(string) {
  if (isUndefined(string) || string === null || string === "") {
    return undefined;
  } else {
    return parseInt(string, 10);
  }
}
function parseMillis(fraction) {
  // Return undefined (instead of 0) in these cases, where fraction is not set
  if (isUndefined(fraction) || fraction === null || fraction === "") {
    return undefined;
  } else {
    var f = parseFloat("0." + fraction) * 1000;
    return Math.floor(f);
  }
}
function roundTo(number, digits, towardZero) {
  if (towardZero === void 0) {
    towardZero = false;
  }

  var factor = Math.pow(10, digits),
      rounder = towardZero ? Math.trunc : Math.round;
  return rounder(number * factor) / factor;
} // DATE BASICS

function isLeapYear(year) {
  return year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0);
}
function daysInYear(year) {
  return isLeapYear(year) ? 366 : 365;
}
function daysInMonth(year, month) {
  var modMonth = floorMod(month - 1, 12) + 1,
      modYear = year + (month - modMonth) / 12;

  if (modMonth === 2) {
    return isLeapYear(modYear) ? 29 : 28;
  } else {
    return [31, null, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][modMonth - 1];
  }
} // covert a calendar object to a local timestamp (epoch, but with the offset baked in)

function objToLocalTS(obj) {
  var d = Date.UTC(obj.year, obj.month - 1, obj.day, obj.hour, obj.minute, obj.second, obj.millisecond); // for legacy reasons, years between 0 and 99 are interpreted as 19XX; revert that

  if (obj.year < 100 && obj.year >= 0) {
    d = new Date(d);
    d.setUTCFullYear(d.getUTCFullYear() - 1900);
  }

  return +d;
}
function weeksInWeekYear(weekYear) {
  var p1 = (weekYear + Math.floor(weekYear / 4) - Math.floor(weekYear / 100) + Math.floor(weekYear / 400)) % 7,
      last = weekYear - 1,
      p2 = (last + Math.floor(last / 4) - Math.floor(last / 100) + Math.floor(last / 400)) % 7;
  return p1 === 4 || p2 === 3 ? 53 : 52;
}
function untruncateYear(year) {
  if (year > 99) {
    return year;
  } else return year > 60 ? 1900 + year : 2000 + year;
} // PARSING

function parseZoneInfo(ts, offsetFormat, locale, timeZone) {
  if (timeZone === void 0) {
    timeZone = null;
  }

  var date = new Date(ts),
      intlOpts = {
    hour12: false,
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit"
  };

  if (timeZone) {
    intlOpts.timeZone = timeZone;
  }

  var modified = Object.assign({
    timeZoneName: offsetFormat
  }, intlOpts),
      intl = hasIntl();

  if (intl && hasFormatToParts()) {
    var parsed = new Intl.DateTimeFormat(locale, modified).formatToParts(date).find(function (m) {
      return m.type.toLowerCase() === "timezonename";
    });
    return parsed ? parsed.value : null;
  } else if (intl) {
    // this probably doesn't work for all locales
    var without = new Intl.DateTimeFormat(locale, intlOpts).format(date),
        included = new Intl.DateTimeFormat(locale, modified).format(date),
        diffed = included.substring(without.length),
        trimmed = diffed.replace(/^[, \u200e]+/, "");
    return trimmed;
  } else {
    return null;
  }
} // signedOffset('-5', '30') -> -330

function signedOffset(offHourStr, offMinuteStr) {
  var offHour = parseInt(offHourStr, 10); // don't || this because we want to preserve -0

  if (Number.isNaN(offHour)) {
    offHour = 0;
  }

  var offMin = parseInt(offMinuteStr, 10) || 0,
      offMinSigned = offHour < 0 || Object.is(offHour, -0) ? -offMin : offMin;
  return offHour * 60 + offMinSigned;
} // COERCION

function asNumber(value) {
  var numericValue = Number(value);
  if (typeof value === "boolean" || value === "" || Number.isNaN(numericValue)) throw new InvalidArgumentError("Invalid unit value " + value);
  return numericValue;
}
function normalizeObject(obj, normalizer, nonUnitKeys) {
  var normalized = {};

  for (var u in obj) {
    if (hasOwnProperty(obj, u)) {
      if (nonUnitKeys.indexOf(u) >= 0) continue;
      var v = obj[u];
      if (v === undefined || v === null) continue;
      normalized[normalizer(u)] = asNumber(v);
    }
  }

  return normalized;
}
function formatOffset(offset, format) {
  var hours = Math.trunc(Math.abs(offset / 60)),
      minutes = Math.trunc(Math.abs(offset % 60)),
      sign = offset >= 0 ? "+" : "-";

  switch (format) {
    case "short":
      return "" + sign + padStart(hours, 2) + ":" + padStart(minutes, 2);

    case "narrow":
      return "" + sign + hours + (minutes > 0 ? ":" + minutes : "");

    case "techie":
      return "" + sign + padStart(hours, 2) + padStart(minutes, 2);

    default:
      throw new RangeError("Value format " + format + " is out of range for property format");
  }
}
function timeObject(obj) {
  return pick(obj, ["hour", "minute", "second", "millisecond"]);
}
var ianaRegex = /[A-Za-z_+-]{1,256}(:?\/[A-Za-z_+-]{1,256}(\/[A-Za-z_+-]{1,256})?)?/;

function stringify(obj) {
  return JSON.stringify(obj, Object.keys(obj).sort());
}
/**
 * @private
 */


var monthsLong = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var monthsShort = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var monthsNarrow = ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"];
function months(length) {
  switch (length) {
    case "narrow":
      return [].concat(monthsNarrow);

    case "short":
      return [].concat(monthsShort);

    case "long":
      return [].concat(monthsLong);

    case "numeric":
      return ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];

    case "2-digit":
      return ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

    default:
      return null;
  }
}
var weekdaysLong = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
var weekdaysShort = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
var weekdaysNarrow = ["M", "T", "W", "T", "F", "S", "S"];
function weekdays(length) {
  switch (length) {
    case "narrow":
      return [].concat(weekdaysNarrow);

    case "short":
      return [].concat(weekdaysShort);

    case "long":
      return [].concat(weekdaysLong);

    case "numeric":
      return ["1", "2", "3", "4", "5", "6", "7"];

    default:
      return null;
  }
}
var meridiems = ["AM", "PM"];
var erasLong = ["Before Christ", "Anno Domini"];
var erasShort = ["BC", "AD"];
var erasNarrow = ["B", "A"];
function eras(length) {
  switch (length) {
    case "narrow":
      return [].concat(erasNarrow);

    case "short":
      return [].concat(erasShort);

    case "long":
      return [].concat(erasLong);

    default:
      return null;
  }
}
function meridiemForDateTime(dt) {
  return meridiems[dt.hour < 12 ? 0 : 1];
}
function weekdayForDateTime(dt, length) {
  return weekdays(length)[dt.weekday - 1];
}
function monthForDateTime(dt, length) {
  return months(length)[dt.month - 1];
}
function eraForDateTime(dt, length) {
  return eras(length)[dt.year < 0 ? 0 : 1];
}
function formatRelativeTime(unit, count, numeric, narrow) {
  if (numeric === void 0) {
    numeric = "always";
  }

  if (narrow === void 0) {
    narrow = false;
  }

  var units = {
    years: ["year", "yr."],
    quarters: ["quarter", "qtr."],
    months: ["month", "mo."],
    weeks: ["week", "wk."],
    days: ["day", "day", "days"],
    hours: ["hour", "hr."],
    minutes: ["minute", "min."],
    seconds: ["second", "sec."]
  };
  var lastable = ["hours", "minutes", "seconds"].indexOf(unit) === -1;

  if (numeric === "auto" && lastable) {
    var isDay = unit === "days";

    switch (count) {
      case 1:
        return isDay ? "tomorrow" : "next " + units[unit][0];

      case -1:
        return isDay ? "yesterday" : "last " + units[unit][0];

      case 0:
        return isDay ? "today" : "this " + units[unit][0];

    }
  }

  var isInPast = Object.is(count, -0) || count < 0,
      fmtValue = Math.abs(count),
      singular = fmtValue === 1,
      lilUnits = units[unit],
      fmtUnit = narrow ? singular ? lilUnits[1] : lilUnits[2] || lilUnits[1] : singular ? units[unit][0] : unit;
  return isInPast ? fmtValue + " " + fmtUnit + " ago" : "in " + fmtValue + " " + fmtUnit;
}
function formatString(knownFormat) {
  // these all have the offsets removed because we don't have access to them
  // without all the intl stuff this is backfilling
  var filtered = pick(knownFormat, ["weekday", "era", "year", "month", "day", "hour", "minute", "second", "timeZoneName", "hour12"]),
      key = stringify(filtered),
      dateTimeHuge = "EEEE, LLLL d, yyyy, h:mm a";

  switch (key) {
    case stringify(DATE_SHORT):
      return "M/d/yyyy";

    case stringify(DATE_MED):
      return "LLL d, yyyy";

    case stringify(DATE_MED_WITH_WEEKDAY):
      return "EEE, LLL d, yyyy";

    case stringify(DATE_FULL):
      return "LLLL d, yyyy";

    case stringify(DATE_HUGE):
      return "EEEE, LLLL d, yyyy";

    case stringify(TIME_SIMPLE):
      return "h:mm a";

    case stringify(TIME_WITH_SECONDS):
      return "h:mm:ss a";

    case stringify(TIME_WITH_SHORT_OFFSET):
      return "h:mm a";

    case stringify(TIME_WITH_LONG_OFFSET):
      return "h:mm a";

    case stringify(TIME_24_SIMPLE):
      return "HH:mm";

    case stringify(TIME_24_WITH_SECONDS):
      return "HH:mm:ss";

    case stringify(TIME_24_WITH_SHORT_OFFSET):
      return "HH:mm";

    case stringify(TIME_24_WITH_LONG_OFFSET):
      return "HH:mm";

    case stringify(DATETIME_SHORT):
      return "M/d/yyyy, h:mm a";

    case stringify(DATETIME_MED):
      return "LLL d, yyyy, h:mm a";

    case stringify(DATETIME_FULL):
      return "LLLL d, yyyy, h:mm a";

    case stringify(DATETIME_HUGE):
      return dateTimeHuge;

    case stringify(DATETIME_SHORT_WITH_SECONDS):
      return "M/d/yyyy, h:mm:ss a";

    case stringify(DATETIME_MED_WITH_SECONDS):
      return "LLL d, yyyy, h:mm:ss a";

    case stringify(DATETIME_MED_WITH_WEEKDAY):
      return "EEE, d LLL yyyy, h:mm a";

    case stringify(DATETIME_FULL_WITH_SECONDS):
      return "LLLL d, yyyy, h:mm:ss a";

    case stringify(DATETIME_HUGE_WITH_SECONDS):
      return "EEEE, LLLL d, yyyy, h:mm:ss a";

    default:
      return dateTimeHuge;
  }
}

function stringifyTokens(splits, tokenToString) {
  var s = "";

  for (var _iterator = _createForOfIteratorHelperLoose(splits), _step; !(_step = _iterator()).done;) {
    var token = _step.value;

    if (token.literal) {
      s += token.val;
    } else {
      s += tokenToString(token.val);
    }
  }

  return s;
}

var _macroTokenToFormatOpts = {
  D: DATE_SHORT,
  DD: DATE_MED,
  DDD: DATE_FULL,
  DDDD: DATE_HUGE,
  t: TIME_SIMPLE,
  tt: TIME_WITH_SECONDS,
  ttt: TIME_WITH_SHORT_OFFSET,
  tttt: TIME_WITH_LONG_OFFSET,
  T: TIME_24_SIMPLE,
  TT: TIME_24_WITH_SECONDS,
  TTT: TIME_24_WITH_SHORT_OFFSET,
  TTTT: TIME_24_WITH_LONG_OFFSET,
  f: DATETIME_SHORT,
  ff: DATETIME_MED,
  fff: DATETIME_FULL,
  ffff: DATETIME_HUGE,
  F: DATETIME_SHORT_WITH_SECONDS,
  FF: DATETIME_MED_WITH_SECONDS,
  FFF: DATETIME_FULL_WITH_SECONDS,
  FFFF: DATETIME_HUGE_WITH_SECONDS
};
/**
 * @private
 */

var Formatter = /*#__PURE__*/function () {
  Formatter.create = function create(locale, opts) {
    if (opts === void 0) {
      opts = {};
    }

    return new Formatter(locale, opts);
  };

  Formatter.parseFormat = function parseFormat(fmt) {
    var current = null,
        currentFull = "",
        bracketed = false;
    var splits = [];

    for (var i = 0; i < fmt.length; i++) {
      var c = fmt.charAt(i);

      if (c === "'") {
        if (currentFull.length > 0) {
          splits.push({
            literal: bracketed,
            val: currentFull
          });
        }

        current = null;
        currentFull = "";
        bracketed = !bracketed;
      } else if (bracketed) {
        currentFull += c;
      } else if (c === current) {
        currentFull += c;
      } else {
        if (currentFull.length > 0) {
          splits.push({
            literal: false,
            val: currentFull
          });
        }

        currentFull = c;
        current = c;
      }
    }

    if (currentFull.length > 0) {
      splits.push({
        literal: bracketed,
        val: currentFull
      });
    }

    return splits;
  };

  Formatter.macroTokenToFormatOpts = function macroTokenToFormatOpts(token) {
    return _macroTokenToFormatOpts[token];
  };

  function Formatter(locale, formatOpts) {
    this.opts = formatOpts;
    this.loc = locale;
    this.systemLoc = null;
  }

  var _proto = Formatter.prototype;

  _proto.formatWithSystemDefault = function formatWithSystemDefault(dt, opts) {
    if (this.systemLoc === null) {
      this.systemLoc = this.loc.redefaultToSystem();
    }

    var df = this.systemLoc.dtFormatter(dt, Object.assign({}, this.opts, opts));
    return df.format();
  };

  _proto.formatDateTime = function formatDateTime(dt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var df = this.loc.dtFormatter(dt, Object.assign({}, this.opts, opts));
    return df.format();
  };

  _proto.formatDateTimeParts = function formatDateTimeParts(dt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var df = this.loc.dtFormatter(dt, Object.assign({}, this.opts, opts));
    return df.formatToParts();
  };

  _proto.resolvedOptions = function resolvedOptions(dt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var df = this.loc.dtFormatter(dt, Object.assign({}, this.opts, opts));
    return df.resolvedOptions();
  };

  _proto.num = function num(n, p) {
    if (p === void 0) {
      p = 0;
    }

    // we get some perf out of doing this here, annoyingly
    if (this.opts.forceSimple) {
      return padStart(n, p);
    }

    var opts = Object.assign({}, this.opts);

    if (p > 0) {
      opts.padTo = p;
    }

    return this.loc.numberFormatter(opts).format(n);
  };

  _proto.formatDateTimeFromString = function formatDateTimeFromString(dt, fmt) {
    var _this = this;

    var knownEnglish = this.loc.listingMode() === "en",
        useDateTimeFormatter = this.loc.outputCalendar && this.loc.outputCalendar !== "gregory" && hasFormatToParts(),
        string = function string(opts, extract) {
      return _this.loc.extract(dt, opts, extract);
    },
        formatOffset = function formatOffset(opts) {
      if (dt.isOffsetFixed && dt.offset === 0 && opts.allowZ) {
        return "Z";
      }

      return dt.isValid ? dt.zone.formatOffset(dt.ts, opts.format) : "";
    },
        meridiem = function meridiem() {
      return knownEnglish ? meridiemForDateTime(dt) : string({
        hour: "numeric",
        hour12: true
      }, "dayperiod");
    },
        month = function month(length, standalone) {
      return knownEnglish ? monthForDateTime(dt, length) : string(standalone ? {
        month: length
      } : {
        month: length,
        day: "numeric"
      }, "month");
    },
        weekday = function weekday(length, standalone) {
      return knownEnglish ? weekdayForDateTime(dt, length) : string(standalone ? {
        weekday: length
      } : {
        weekday: length,
        month: "long",
        day: "numeric"
      }, "weekday");
    },
        maybeMacro = function maybeMacro(token) {
      var formatOpts = Formatter.macroTokenToFormatOpts(token);

      if (formatOpts) {
        return _this.formatWithSystemDefault(dt, formatOpts);
      } else {
        return token;
      }
    },
        era = function era(length) {
      return knownEnglish ? eraForDateTime(dt, length) : string({
        era: length
      }, "era");
    },
        tokenToString = function tokenToString(token) {
      // Where possible: http://cldr.unicode.org/translation/date-time-1/date-time#TOC-Standalone-vs.-Format-Styles
      switch (token) {
        // ms
        case "S":
          return _this.num(dt.millisecond);

        case "u": // falls through

        case "SSS":
          return _this.num(dt.millisecond, 3);
        // seconds

        case "s":
          return _this.num(dt.second);

        case "ss":
          return _this.num(dt.second, 2);
        // minutes

        case "m":
          return _this.num(dt.minute);

        case "mm":
          return _this.num(dt.minute, 2);
        // hours

        case "h":
          return _this.num(dt.hour % 12 === 0 ? 12 : dt.hour % 12);

        case "hh":
          return _this.num(dt.hour % 12 === 0 ? 12 : dt.hour % 12, 2);

        case "H":
          return _this.num(dt.hour);

        case "HH":
          return _this.num(dt.hour, 2);
        // offset

        case "Z":
          // like +6
          return formatOffset({
            format: "narrow",
            allowZ: _this.opts.allowZ
          });

        case "ZZ":
          // like +06:00
          return formatOffset({
            format: "short",
            allowZ: _this.opts.allowZ
          });

        case "ZZZ":
          // like +0600
          return formatOffset({
            format: "techie",
            allowZ: _this.opts.allowZ
          });

        case "ZZZZ":
          // like EST
          return dt.zone.offsetName(dt.ts, {
            format: "short",
            locale: _this.loc.locale
          });

        case "ZZZZZ":
          // like Eastern Standard Time
          return dt.zone.offsetName(dt.ts, {
            format: "long",
            locale: _this.loc.locale
          });
        // zone

        case "z":
          // like America/New_York
          return dt.zoneName;
        // meridiems

        case "a":
          return meridiem();
        // dates

        case "d":
          return useDateTimeFormatter ? string({
            day: "numeric"
          }, "day") : _this.num(dt.day);

        case "dd":
          return useDateTimeFormatter ? string({
            day: "2-digit"
          }, "day") : _this.num(dt.day, 2);
        // weekdays - standalone

        case "c":
          // like 1
          return _this.num(dt.weekday);

        case "ccc":
          // like 'Tues'
          return weekday("short", true);

        case "cccc":
          // like 'Tuesday'
          return weekday("long", true);

        case "ccccc":
          // like 'T'
          return weekday("narrow", true);
        // weekdays - format

        case "E":
          // like 1
          return _this.num(dt.weekday);

        case "EEE":
          // like 'Tues'
          return weekday("short", false);

        case "EEEE":
          // like 'Tuesday'
          return weekday("long", false);

        case "EEEEE":
          // like 'T'
          return weekday("narrow", false);
        // months - standalone

        case "L":
          // like 1
          return useDateTimeFormatter ? string({
            month: "numeric",
            day: "numeric"
          }, "month") : _this.num(dt.month);

        case "LL":
          // like 01, doesn't seem to work
          return useDateTimeFormatter ? string({
            month: "2-digit",
            day: "numeric"
          }, "month") : _this.num(dt.month, 2);

        case "LLL":
          // like Jan
          return month("short", true);

        case "LLLL":
          // like January
          return month("long", true);

        case "LLLLL":
          // like J
          return month("narrow", true);
        // months - format

        case "M":
          // like 1
          return useDateTimeFormatter ? string({
            month: "numeric"
          }, "month") : _this.num(dt.month);

        case "MM":
          // like 01
          return useDateTimeFormatter ? string({
            month: "2-digit"
          }, "month") : _this.num(dt.month, 2);

        case "MMM":
          // like Jan
          return month("short", false);

        case "MMMM":
          // like January
          return month("long", false);

        case "MMMMM":
          // like J
          return month("narrow", false);
        // years

        case "y":
          // like 2014
          return useDateTimeFormatter ? string({
            year: "numeric"
          }, "year") : _this.num(dt.year);

        case "yy":
          // like 14
          return useDateTimeFormatter ? string({
            year: "2-digit"
          }, "year") : _this.num(dt.year.toString().slice(-2), 2);

        case "yyyy":
          // like 0012
          return useDateTimeFormatter ? string({
            year: "numeric"
          }, "year") : _this.num(dt.year, 4);

        case "yyyyyy":
          // like 000012
          return useDateTimeFormatter ? string({
            year: "numeric"
          }, "year") : _this.num(dt.year, 6);
        // eras

        case "G":
          // like AD
          return era("short");

        case "GG":
          // like Anno Domini
          return era("long");

        case "GGGGG":
          return era("narrow");

        case "kk":
          return _this.num(dt.weekYear.toString().slice(-2), 2);

        case "kkkk":
          return _this.num(dt.weekYear, 4);

        case "W":
          return _this.num(dt.weekNumber);

        case "WW":
          return _this.num(dt.weekNumber, 2);

        case "o":
          return _this.num(dt.ordinal);

        case "ooo":
          return _this.num(dt.ordinal, 3);

        case "q":
          // like 1
          return _this.num(dt.quarter);

        case "qq":
          // like 01
          return _this.num(dt.quarter, 2);

        case "X":
          return _this.num(Math.floor(dt.ts / 1000));

        case "x":
          return _this.num(dt.ts);

        default:
          return maybeMacro(token);
      }
    };

    return stringifyTokens(Formatter.parseFormat(fmt), tokenToString);
  };

  _proto.formatDurationFromString = function formatDurationFromString(dur, fmt) {
    var _this2 = this;

    var tokenToField = function tokenToField(token) {
      switch (token[0]) {
        case "S":
          return "millisecond";

        case "s":
          return "second";

        case "m":
          return "minute";

        case "h":
          return "hour";

        case "d":
          return "day";

        case "M":
          return "month";

        case "y":
          return "year";

        default:
          return null;
      }
    },
        tokenToString = function tokenToString(lildur) {
      return function (token) {
        var mapped = tokenToField(token);

        if (mapped) {
          return _this2.num(lildur.get(mapped), token.length);
        } else {
          return token;
        }
      };
    },
        tokens = Formatter.parseFormat(fmt),
        realTokens = tokens.reduce(function (found, _ref) {
      var literal = _ref.literal,
          val = _ref.val;
      return literal ? found : found.concat(val);
    }, []),
        collapsed = dur.shiftTo.apply(dur, realTokens.map(tokenToField).filter(function (t) {
      return t;
    }));

    return stringifyTokens(tokens, tokenToString(collapsed));
  };

  return Formatter;
}();

var Invalid = /*#__PURE__*/function () {
  function Invalid(reason, explanation) {
    this.reason = reason;
    this.explanation = explanation;
  }

  var _proto = Invalid.prototype;

  _proto.toMessage = function toMessage() {
    if (this.explanation) {
      return this.reason + ": " + this.explanation;
    } else {
      return this.reason;
    }
  };

  return Invalid;
}();

/**
 * @interface
 */

var Zone = /*#__PURE__*/function () {
  function Zone() {}

  var _proto = Zone.prototype;

  /**
   * Returns the offset's common name (such as EST) at the specified timestamp
   * @abstract
   * @param {number} ts - Epoch milliseconds for which to get the name
   * @param {Object} opts - Options to affect the format
   * @param {string} opts.format - What style of offset to return. Accepts 'long' or 'short'.
   * @param {string} opts.locale - What locale to return the offset name in.
   * @return {string}
   */
  _proto.offsetName = function offsetName(ts, opts) {
    throw new ZoneIsAbstractError();
  }
  /**
   * Returns the offset's value as a string
   * @abstract
   * @param {number} ts - Epoch milliseconds for which to get the offset
   * @param {string} format - What style of offset to return.
   *                          Accepts 'narrow', 'short', or 'techie'. Returning '+6', '+06:00', or '+0600' respectively
   * @return {string}
   */
  ;

  _proto.formatOffset = function formatOffset(ts, format) {
    throw new ZoneIsAbstractError();
  }
  /**
   * Return the offset in minutes for this zone at the specified timestamp.
   * @abstract
   * @param {number} ts - Epoch milliseconds for which to compute the offset
   * @return {number}
   */
  ;

  _proto.offset = function offset(ts) {
    throw new ZoneIsAbstractError();
  }
  /**
   * Return whether this Zone is equal to another zone
   * @abstract
   * @param {Zone} otherZone - the zone to compare
   * @return {boolean}
   */
  ;

  _proto.equals = function equals(otherZone) {
    throw new ZoneIsAbstractError();
  }
  /**
   * Return whether this Zone is valid.
   * @abstract
   * @type {boolean}
   */
  ;

  _createClass(Zone, [{
    key: "type",

    /**
     * The type of zone
     * @abstract
     * @type {string}
     */
    get: function get() {
      throw new ZoneIsAbstractError();
    }
    /**
     * The name of this zone.
     * @abstract
     * @type {string}
     */

  }, {
    key: "name",
    get: function get() {
      throw new ZoneIsAbstractError();
    }
    /**
     * Returns whether the offset is known to be fixed for the whole year.
     * @abstract
     * @type {boolean}
     */

  }, {
    key: "universal",
    get: function get() {
      throw new ZoneIsAbstractError();
    }
  }, {
    key: "isValid",
    get: function get() {
      throw new ZoneIsAbstractError();
    }
  }]);

  return Zone;
}();

var singleton = null;
/**
 * Represents the local zone for this JavaScript environment.
 * @implements {Zone}
 */

var LocalZone = /*#__PURE__*/function (_Zone) {
  _inheritsLoose(LocalZone, _Zone);

  function LocalZone() {
    return _Zone.apply(this, arguments) || this;
  }

  var _proto = LocalZone.prototype;

  /** @override **/
  _proto.offsetName = function offsetName(ts, _ref) {
    var format = _ref.format,
        locale = _ref.locale;
    return parseZoneInfo(ts, format, locale);
  }
  /** @override **/
  ;

  _proto.formatOffset = function formatOffset$1(ts, format) {
    return formatOffset(this.offset(ts), format);
  }
  /** @override **/
  ;

  _proto.offset = function offset(ts) {
    return -new Date(ts).getTimezoneOffset();
  }
  /** @override **/
  ;

  _proto.equals = function equals(otherZone) {
    return otherZone.type === "local";
  }
  /** @override **/
  ;

  _createClass(LocalZone, [{
    key: "type",

    /** @override **/
    get: function get() {
      return "local";
    }
    /** @override **/

  }, {
    key: "name",
    get: function get() {
      if (hasIntl()) {
        return new Intl.DateTimeFormat().resolvedOptions().timeZone;
      } else return "local";
    }
    /** @override **/

  }, {
    key: "universal",
    get: function get() {
      return false;
    }
  }, {
    key: "isValid",
    get: function get() {
      return true;
    }
  }], [{
    key: "instance",

    /**
     * Get a singleton instance of the local zone
     * @return {LocalZone}
     */
    get: function get() {
      if (singleton === null) {
        singleton = new LocalZone();
      }

      return singleton;
    }
  }]);

  return LocalZone;
}(Zone);

var matchingRegex = RegExp("^" + ianaRegex.source + "$");
var dtfCache = {};

function makeDTF(zone) {
  if (!dtfCache[zone]) {
    dtfCache[zone] = new Intl.DateTimeFormat("en-US", {
      hour12: false,
      timeZone: zone,
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit"
    });
  }

  return dtfCache[zone];
}

var typeToPos = {
  year: 0,
  month: 1,
  day: 2,
  hour: 3,
  minute: 4,
  second: 5
};

function hackyOffset(dtf, date) {
  var formatted = dtf.format(date).replace(/\u200E/g, ""),
      parsed = /(\d+)\/(\d+)\/(\d+),? (\d+):(\d+):(\d+)/.exec(formatted),
      fMonth = parsed[1],
      fDay = parsed[2],
      fYear = parsed[3],
      fHour = parsed[4],
      fMinute = parsed[5],
      fSecond = parsed[6];
  return [fYear, fMonth, fDay, fHour, fMinute, fSecond];
}

function partsOffset(dtf, date) {
  var formatted = dtf.formatToParts(date),
      filled = [];

  for (var i = 0; i < formatted.length; i++) {
    var _formatted$i = formatted[i],
        type = _formatted$i.type,
        value = _formatted$i.value,
        pos = typeToPos[type];

    if (!isUndefined(pos)) {
      filled[pos] = parseInt(value, 10);
    }
  }

  return filled;
}

var ianaZoneCache = {};
/**
 * A zone identified by an IANA identifier, like America/New_York
 * @implements {Zone}
 */

var IANAZone = /*#__PURE__*/function (_Zone) {
  _inheritsLoose(IANAZone, _Zone);

  /**
   * @param {string} name - Zone name
   * @return {IANAZone}
   */
  IANAZone.create = function create(name) {
    if (!ianaZoneCache[name]) {
      ianaZoneCache[name] = new IANAZone(name);
    }

    return ianaZoneCache[name];
  }
  /**
   * Reset local caches. Should only be necessary in testing scenarios.
   * @return {void}
   */
  ;

  IANAZone.resetCache = function resetCache() {
    ianaZoneCache = {};
    dtfCache = {};
  }
  /**
   * Returns whether the provided string is a valid specifier. This only checks the string's format, not that the specifier identifies a known zone; see isValidZone for that.
   * @param {string} s - The string to check validity on
   * @example IANAZone.isValidSpecifier("America/New_York") //=> true
   * @example IANAZone.isValidSpecifier("Fantasia/Castle") //=> true
   * @example IANAZone.isValidSpecifier("Sport~~blorp") //=> false
   * @return {boolean}
   */
  ;

  IANAZone.isValidSpecifier = function isValidSpecifier(s) {
    return !!(s && s.match(matchingRegex));
  }
  /**
   * Returns whether the provided string identifies a real zone
   * @param {string} zone - The string to check
   * @example IANAZone.isValidZone("America/New_York") //=> true
   * @example IANAZone.isValidZone("Fantasia/Castle") //=> false
   * @example IANAZone.isValidZone("Sport~~blorp") //=> false
   * @return {boolean}
   */
  ;

  IANAZone.isValidZone = function isValidZone(zone) {
    try {
      new Intl.DateTimeFormat("en-US", {
        timeZone: zone
      }).format();
      return true;
    } catch (e) {
      return false;
    }
  } // Etc/GMT+8 -> -480

  /** @ignore */
  ;

  IANAZone.parseGMTOffset = function parseGMTOffset(specifier) {
    if (specifier) {
      var match = specifier.match(/^Etc\/GMT(0|[+-]\d{1,2})$/i);

      if (match) {
        return -60 * parseInt(match[1]);
      }
    }

    return null;
  };

  function IANAZone(name) {
    var _this;

    _this = _Zone.call(this) || this;
    /** @private **/

    _this.zoneName = name;
    /** @private **/

    _this.valid = IANAZone.isValidZone(name);
    return _this;
  }
  /** @override **/


  var _proto = IANAZone.prototype;

  /** @override **/
  _proto.offsetName = function offsetName(ts, _ref) {
    var format = _ref.format,
        locale = _ref.locale;
    return parseZoneInfo(ts, format, locale, this.name);
  }
  /** @override **/
  ;

  _proto.formatOffset = function formatOffset$1(ts, format) {
    return formatOffset(this.offset(ts), format);
  }
  /** @override **/
  ;

  _proto.offset = function offset(ts) {
    var date = new Date(ts);
    if (isNaN(date)) return NaN;

    var dtf = makeDTF(this.name),
        _ref2 = dtf.formatToParts ? partsOffset(dtf, date) : hackyOffset(dtf, date),
        year = _ref2[0],
        month = _ref2[1],
        day = _ref2[2],
        hour = _ref2[3],
        minute = _ref2[4],
        second = _ref2[5],
        adjustedHour = hour === 24 ? 0 : hour;

    var asUTC = objToLocalTS({
      year: year,
      month: month,
      day: day,
      hour: adjustedHour,
      minute: minute,
      second: second,
      millisecond: 0
    });
    var asTS = +date;
    var over = asTS % 1000;
    asTS -= over >= 0 ? over : 1000 + over;
    return (asUTC - asTS) / (60 * 1000);
  }
  /** @override **/
  ;

  _proto.equals = function equals(otherZone) {
    return otherZone.type === "iana" && otherZone.name === this.name;
  }
  /** @override **/
  ;

  _createClass(IANAZone, [{
    key: "type",
    get: function get() {
      return "iana";
    }
    /** @override **/

  }, {
    key: "name",
    get: function get() {
      return this.zoneName;
    }
    /** @override **/

  }, {
    key: "universal",
    get: function get() {
      return false;
    }
  }, {
    key: "isValid",
    get: function get() {
      return this.valid;
    }
  }]);

  return IANAZone;
}(Zone);

var singleton$1 = null;
/**
 * A zone with a fixed offset (meaning no DST)
 * @implements {Zone}
 */

var FixedOffsetZone = /*#__PURE__*/function (_Zone) {
  _inheritsLoose(FixedOffsetZone, _Zone);

  /**
   * Get an instance with a specified offset
   * @param {number} offset - The offset in minutes
   * @return {FixedOffsetZone}
   */
  FixedOffsetZone.instance = function instance(offset) {
    return offset === 0 ? FixedOffsetZone.utcInstance : new FixedOffsetZone(offset);
  }
  /**
   * Get an instance of FixedOffsetZone from a UTC offset string, like "UTC+6"
   * @param {string} s - The offset string to parse
   * @example FixedOffsetZone.parseSpecifier("UTC+6")
   * @example FixedOffsetZone.parseSpecifier("UTC+06")
   * @example FixedOffsetZone.parseSpecifier("UTC-6:00")
   * @return {FixedOffsetZone}
   */
  ;

  FixedOffsetZone.parseSpecifier = function parseSpecifier(s) {
    if (s) {
      var r = s.match(/^utc(?:([+-]\d{1,2})(?::(\d{2}))?)?$/i);

      if (r) {
        return new FixedOffsetZone(signedOffset(r[1], r[2]));
      }
    }

    return null;
  };

  _createClass(FixedOffsetZone, null, [{
    key: "utcInstance",

    /**
     * Get a singleton instance of UTC
     * @return {FixedOffsetZone}
     */
    get: function get() {
      if (singleton$1 === null) {
        singleton$1 = new FixedOffsetZone(0);
      }

      return singleton$1;
    }
  }]);

  function FixedOffsetZone(offset) {
    var _this;

    _this = _Zone.call(this) || this;
    /** @private **/

    _this.fixed = offset;
    return _this;
  }
  /** @override **/


  var _proto = FixedOffsetZone.prototype;

  /** @override **/
  _proto.offsetName = function offsetName() {
    return this.name;
  }
  /** @override **/
  ;

  _proto.formatOffset = function formatOffset$1(ts, format) {
    return formatOffset(this.fixed, format);
  }
  /** @override **/
  ;

  /** @override **/
  _proto.offset = function offset() {
    return this.fixed;
  }
  /** @override **/
  ;

  _proto.equals = function equals(otherZone) {
    return otherZone.type === "fixed" && otherZone.fixed === this.fixed;
  }
  /** @override **/
  ;

  _createClass(FixedOffsetZone, [{
    key: "type",
    get: function get() {
      return "fixed";
    }
    /** @override **/

  }, {
    key: "name",
    get: function get() {
      return this.fixed === 0 ? "UTC" : "UTC" + formatOffset(this.fixed, "narrow");
    }
  }, {
    key: "universal",
    get: function get() {
      return true;
    }
  }, {
    key: "isValid",
    get: function get() {
      return true;
    }
  }]);

  return FixedOffsetZone;
}(Zone);

/**
 * A zone that failed to parse. You should never need to instantiate this.
 * @implements {Zone}
 */

var InvalidZone = /*#__PURE__*/function (_Zone) {
  _inheritsLoose(InvalidZone, _Zone);

  function InvalidZone(zoneName) {
    var _this;

    _this = _Zone.call(this) || this;
    /**  @private */

    _this.zoneName = zoneName;
    return _this;
  }
  /** @override **/


  var _proto = InvalidZone.prototype;

  /** @override **/
  _proto.offsetName = function offsetName() {
    return null;
  }
  /** @override **/
  ;

  _proto.formatOffset = function formatOffset() {
    return "";
  }
  /** @override **/
  ;

  _proto.offset = function offset() {
    return NaN;
  }
  /** @override **/
  ;

  _proto.equals = function equals() {
    return false;
  }
  /** @override **/
  ;

  _createClass(InvalidZone, [{
    key: "type",
    get: function get() {
      return "invalid";
    }
    /** @override **/

  }, {
    key: "name",
    get: function get() {
      return this.zoneName;
    }
    /** @override **/

  }, {
    key: "universal",
    get: function get() {
      return false;
    }
  }, {
    key: "isValid",
    get: function get() {
      return false;
    }
  }]);

  return InvalidZone;
}(Zone);

/**
 * @private
 */
function normalizeZone(input, defaultZone) {
  var offset;

  if (isUndefined(input) || input === null) {
    return defaultZone;
  } else if (input instanceof Zone) {
    return input;
  } else if (isString(input)) {
    var lowered = input.toLowerCase();
    if (lowered === "local") return defaultZone;else if (lowered === "utc" || lowered === "gmt") return FixedOffsetZone.utcInstance;else if ((offset = IANAZone.parseGMTOffset(input)) != null) {
      // handle Etc/GMT-4, which V8 chokes on
      return FixedOffsetZone.instance(offset);
    } else if (IANAZone.isValidSpecifier(lowered)) return IANAZone.create(input);else return FixedOffsetZone.parseSpecifier(lowered) || new InvalidZone(input);
  } else if (isNumber(input)) {
    return FixedOffsetZone.instance(input);
  } else if (typeof input === "object" && input.offset && typeof input.offset === "number") {
    // This is dumb, but the instanceof check above doesn't seem to really work
    // so we're duck checking it
    return input;
  } else {
    return new InvalidZone(input);
  }
}

var now = function now() {
  return Date.now();
},
    defaultZone = null,
    // not setting this directly to LocalZone.instance bc loading order issues
defaultLocale = null,
    defaultNumberingSystem = null,
    defaultOutputCalendar = null,
    throwOnInvalid = false;
/**
 * Settings contains static getters and setters that control Luxon's overall behavior. Luxon is a simple library with few options, but the ones it does have live here.
 */


var Settings = /*#__PURE__*/function () {
  function Settings() {}

  /**
   * Reset Luxon's global caches. Should only be necessary in testing scenarios.
   * @return {void}
   */
  Settings.resetCaches = function resetCaches() {
    Locale.resetCache();
    IANAZone.resetCache();
  };

  _createClass(Settings, null, [{
    key: "now",

    /**
     * Get the callback for returning the current timestamp.
     * @type {function}
     */
    get: function get() {
      return now;
    }
    /**
     * Set the callback for returning the current timestamp.
     * The function should return a number, which will be interpreted as an Epoch millisecond count
     * @type {function}
     * @example Settings.now = () => Date.now() + 3000 // pretend it is 3 seconds in the future
     * @example Settings.now = () => 0 // always pretend it's Jan 1, 1970 at midnight in UTC time
     */
    ,
    set: function set(n) {
      now = n;
    }
    /**
     * Get the default time zone to create DateTimes in.
     * @type {string}
     */

  }, {
    key: "defaultZoneName",
    get: function get() {
      return Settings.defaultZone.name;
    }
    /**
     * Set the default time zone to create DateTimes in. Does not affect existing instances.
     * @type {string}
     */
    ,
    set: function set(z) {
      if (!z) {
        defaultZone = null;
      } else {
        defaultZone = normalizeZone(z);
      }
    }
    /**
     * Get the default time zone object to create DateTimes in. Does not affect existing instances.
     * @type {Zone}
     */

  }, {
    key: "defaultZone",
    get: function get() {
      return defaultZone || LocalZone.instance;
    }
    /**
     * Get the default locale to create DateTimes with. Does not affect existing instances.
     * @type {string}
     */

  }, {
    key: "defaultLocale",
    get: function get() {
      return defaultLocale;
    }
    /**
     * Set the default locale to create DateTimes with. Does not affect existing instances.
     * @type {string}
     */
    ,
    set: function set(locale) {
      defaultLocale = locale;
    }
    /**
     * Get the default numbering system to create DateTimes with. Does not affect existing instances.
     * @type {string}
     */

  }, {
    key: "defaultNumberingSystem",
    get: function get() {
      return defaultNumberingSystem;
    }
    /**
     * Set the default numbering system to create DateTimes with. Does not affect existing instances.
     * @type {string}
     */
    ,
    set: function set(numberingSystem) {
      defaultNumberingSystem = numberingSystem;
    }
    /**
     * Get the default output calendar to create DateTimes with. Does not affect existing instances.
     * @type {string}
     */

  }, {
    key: "defaultOutputCalendar",
    get: function get() {
      return defaultOutputCalendar;
    }
    /**
     * Set the default output calendar to create DateTimes with. Does not affect existing instances.
     * @type {string}
     */
    ,
    set: function set(outputCalendar) {
      defaultOutputCalendar = outputCalendar;
    }
    /**
     * Get whether Luxon will throw when it encounters invalid DateTimes, Durations, or Intervals
     * @type {boolean}
     */

  }, {
    key: "throwOnInvalid",
    get: function get() {
      return throwOnInvalid;
    }
    /**
     * Set whether Luxon will throw when it encounters invalid DateTimes, Durations, or Intervals
     * @type {boolean}
     */
    ,
    set: function set(t) {
      throwOnInvalid = t;
    }
  }]);

  return Settings;
}();

var intlDTCache = {};

function getCachedDTF(locString, opts) {
  if (opts === void 0) {
    opts = {};
  }

  var key = JSON.stringify([locString, opts]);
  var dtf = intlDTCache[key];

  if (!dtf) {
    dtf = new Intl.DateTimeFormat(locString, opts);
    intlDTCache[key] = dtf;
  }

  return dtf;
}

var intlNumCache = {};

function getCachedINF(locString, opts) {
  if (opts === void 0) {
    opts = {};
  }

  var key = JSON.stringify([locString, opts]);
  var inf = intlNumCache[key];

  if (!inf) {
    inf = new Intl.NumberFormat(locString, opts);
    intlNumCache[key] = inf;
  }

  return inf;
}

var intlRelCache = {};

function getCachedRTF(locString, opts) {
  if (opts === void 0) {
    opts = {};
  }

  var _opts = opts,
      base = _opts.base,
      cacheKeyOpts = _objectWithoutPropertiesLoose(_opts, ["base"]); // exclude `base` from the options


  var key = JSON.stringify([locString, cacheKeyOpts]);
  var inf = intlRelCache[key];

  if (!inf) {
    inf = new Intl.RelativeTimeFormat(locString, opts);
    intlRelCache[key] = inf;
  }

  return inf;
}

var sysLocaleCache = null;

function systemLocale() {
  if (sysLocaleCache) {
    return sysLocaleCache;
  } else if (hasIntl()) {
    var computedSys = new Intl.DateTimeFormat().resolvedOptions().locale; // node sometimes defaults to "und". Override that because that is dumb

    sysLocaleCache = !computedSys || computedSys === "und" ? "en-US" : computedSys;
    return sysLocaleCache;
  } else {
    sysLocaleCache = "en-US";
    return sysLocaleCache;
  }
}

function parseLocaleString(localeStr) {
  // I really want to avoid writing a BCP 47 parser
  // see, e.g. https://github.com/wooorm/bcp-47
  // Instead, we'll do this:
  // a) if the string has no -u extensions, just leave it alone
  // b) if it does, use Intl to resolve everything
  // c) if Intl fails, try again without the -u
  var uIndex = localeStr.indexOf("-u-");

  if (uIndex === -1) {
    return [localeStr];
  } else {
    var options;
    var smaller = localeStr.substring(0, uIndex);

    try {
      options = getCachedDTF(localeStr).resolvedOptions();
    } catch (e) {
      options = getCachedDTF(smaller).resolvedOptions();
    }

    var _options = options,
        numberingSystem = _options.numberingSystem,
        calendar = _options.calendar; // return the smaller one so that we can append the calendar and numbering overrides to it

    return [smaller, numberingSystem, calendar];
  }
}

function intlConfigString(localeStr, numberingSystem, outputCalendar) {
  if (hasIntl()) {
    if (outputCalendar || numberingSystem) {
      localeStr += "-u";

      if (outputCalendar) {
        localeStr += "-ca-" + outputCalendar;
      }

      if (numberingSystem) {
        localeStr += "-nu-" + numberingSystem;
      }

      return localeStr;
    } else {
      return localeStr;
    }
  } else {
    return [];
  }
}

function mapMonths(f) {
  var ms = [];

  for (var i = 1; i <= 12; i++) {
    var dt = DateTime.utc(2016, i, 1);
    ms.push(f(dt));
  }

  return ms;
}

function mapWeekdays(f) {
  var ms = [];

  for (var i = 1; i <= 7; i++) {
    var dt = DateTime.utc(2016, 11, 13 + i);
    ms.push(f(dt));
  }

  return ms;
}

function listStuff(loc, length, defaultOK, englishFn, intlFn) {
  var mode = loc.listingMode(defaultOK);

  if (mode === "error") {
    return null;
  } else if (mode === "en") {
    return englishFn(length);
  } else {
    return intlFn(length);
  }
}

function supportsFastNumbers(loc) {
  if (loc.numberingSystem && loc.numberingSystem !== "latn") {
    return false;
  } else {
    return loc.numberingSystem === "latn" || !loc.locale || loc.locale.startsWith("en") || hasIntl() && new Intl.DateTimeFormat(loc.intl).resolvedOptions().numberingSystem === "latn";
  }
}
/**
 * @private
 */


var PolyNumberFormatter = /*#__PURE__*/function () {
  function PolyNumberFormatter(intl, forceSimple, opts) {
    this.padTo = opts.padTo || 0;
    this.floor = opts.floor || false;

    if (!forceSimple && hasIntl()) {
      var intlOpts = {
        useGrouping: false
      };
      if (opts.padTo > 0) intlOpts.minimumIntegerDigits = opts.padTo;
      this.inf = getCachedINF(intl, intlOpts);
    }
  }

  var _proto = PolyNumberFormatter.prototype;

  _proto.format = function format(i) {
    if (this.inf) {
      var fixed = this.floor ? Math.floor(i) : i;
      return this.inf.format(fixed);
    } else {
      // to match the browser's numberformatter defaults
      var _fixed = this.floor ? Math.floor(i) : roundTo(i, 3);

      return padStart(_fixed, this.padTo);
    }
  };

  return PolyNumberFormatter;
}();
/**
 * @private
 */


var PolyDateFormatter = /*#__PURE__*/function () {
  function PolyDateFormatter(dt, intl, opts) {
    this.opts = opts;
    this.hasIntl = hasIntl();
    var z;

    if (dt.zone.universal && this.hasIntl) {
      // UTC-8 or Etc/UTC-8 are not part of tzdata, only Etc/GMT+8 and the like.
      // That is why fixed-offset TZ is set to that unless it is:
      // 1. Representing offset 0 when UTC is used to maintain previous behavior and does not become GMT.
      // 2. Unsupported by the browser:
      //    - some do not support Etc/
      //    - < Etc/GMT-14, > Etc/GMT+12, and 30-minute or 45-minute offsets are not part of tzdata
      var gmtOffset = -1 * (dt.offset / 60);
      var offsetZ = gmtOffset >= 0 ? "Etc/GMT+" + gmtOffset : "Etc/GMT" + gmtOffset;
      var isOffsetZoneSupported = IANAZone.isValidZone(offsetZ);

      if (dt.offset !== 0 && isOffsetZoneSupported) {
        z = offsetZ;
        this.dt = dt;
      } else {
        // Not all fixed-offset zones like Etc/+4:30 are present in tzdata.
        // So we have to make do. Two cases:
        // 1. The format options tell us to show the zone. We can't do that, so the best
        // we can do is format the date in UTC.
        // 2. The format options don't tell us to show the zone. Then we can adjust them
        // the time and tell the formatter to show it to us in UTC, so that the time is right
        // and the bad zone doesn't show up.
        z = "UTC";

        if (opts.timeZoneName) {
          this.dt = dt;
        } else {
          this.dt = dt.offset === 0 ? dt : DateTime.fromMillis(dt.ts + dt.offset * 60 * 1000);
        }
      }
    } else if (dt.zone.type === "local") {
      this.dt = dt;
    } else {
      this.dt = dt;
      z = dt.zone.name;
    }

    if (this.hasIntl) {
      var intlOpts = Object.assign({}, this.opts);

      if (z) {
        intlOpts.timeZone = z;
      }

      this.dtf = getCachedDTF(intl, intlOpts);
    }
  }

  var _proto2 = PolyDateFormatter.prototype;

  _proto2.format = function format() {
    if (this.hasIntl) {
      return this.dtf.format(this.dt.toJSDate());
    } else {
      var tokenFormat = formatString(this.opts),
          loc = Locale.create("en-US");
      return Formatter.create(loc).formatDateTimeFromString(this.dt, tokenFormat);
    }
  };

  _proto2.formatToParts = function formatToParts() {
    if (this.hasIntl && hasFormatToParts()) {
      return this.dtf.formatToParts(this.dt.toJSDate());
    } else {
      // This is kind of a cop out. We actually could do this for English. However, we couldn't do it for intl strings
      // and IMO it's too weird to have an uncanny valley like that
      return [];
    }
  };

  _proto2.resolvedOptions = function resolvedOptions() {
    if (this.hasIntl) {
      return this.dtf.resolvedOptions();
    } else {
      return {
        locale: "en-US",
        numberingSystem: "latn",
        outputCalendar: "gregory"
      };
    }
  };

  return PolyDateFormatter;
}();
/**
 * @private
 */


var PolyRelFormatter = /*#__PURE__*/function () {
  function PolyRelFormatter(intl, isEnglish, opts) {
    this.opts = Object.assign({
      style: "long"
    }, opts);

    if (!isEnglish && hasRelative()) {
      this.rtf = getCachedRTF(intl, opts);
    }
  }

  var _proto3 = PolyRelFormatter.prototype;

  _proto3.format = function format(count, unit) {
    if (this.rtf) {
      return this.rtf.format(count, unit);
    } else {
      return formatRelativeTime(unit, count, this.opts.numeric, this.opts.style !== "long");
    }
  };

  _proto3.formatToParts = function formatToParts(count, unit) {
    if (this.rtf) {
      return this.rtf.formatToParts(count, unit);
    } else {
      return [];
    }
  };

  return PolyRelFormatter;
}();
/**
 * @private
 */


var Locale = /*#__PURE__*/function () {
  Locale.fromOpts = function fromOpts(opts) {
    return Locale.create(opts.locale, opts.numberingSystem, opts.outputCalendar, opts.defaultToEN);
  };

  Locale.create = function create(locale, numberingSystem, outputCalendar, defaultToEN) {
    if (defaultToEN === void 0) {
      defaultToEN = false;
    }

    var specifiedLocale = locale || Settings.defaultLocale,
        // the system locale is useful for human readable strings but annoying for parsing/formatting known formats
    localeR = specifiedLocale || (defaultToEN ? "en-US" : systemLocale()),
        numberingSystemR = numberingSystem || Settings.defaultNumberingSystem,
        outputCalendarR = outputCalendar || Settings.defaultOutputCalendar;
    return new Locale(localeR, numberingSystemR, outputCalendarR, specifiedLocale);
  };

  Locale.resetCache = function resetCache() {
    sysLocaleCache = null;
    intlDTCache = {};
    intlNumCache = {};
    intlRelCache = {};
  };

  Locale.fromObject = function fromObject(_temp) {
    var _ref = _temp === void 0 ? {} : _temp,
        locale = _ref.locale,
        numberingSystem = _ref.numberingSystem,
        outputCalendar = _ref.outputCalendar;

    return Locale.create(locale, numberingSystem, outputCalendar);
  };

  function Locale(locale, numbering, outputCalendar, specifiedLocale) {
    var _parseLocaleString = parseLocaleString(locale),
        parsedLocale = _parseLocaleString[0],
        parsedNumberingSystem = _parseLocaleString[1],
        parsedOutputCalendar = _parseLocaleString[2];

    this.locale = parsedLocale;
    this.numberingSystem = numbering || parsedNumberingSystem || null;
    this.outputCalendar = outputCalendar || parsedOutputCalendar || null;
    this.intl = intlConfigString(this.locale, this.numberingSystem, this.outputCalendar);
    this.weekdaysCache = {
      format: {},
      standalone: {}
    };
    this.monthsCache = {
      format: {},
      standalone: {}
    };
    this.meridiemCache = null;
    this.eraCache = {};
    this.specifiedLocale = specifiedLocale;
    this.fastNumbersCached = null;
  }

  var _proto4 = Locale.prototype;

  _proto4.listingMode = function listingMode(defaultOK) {
    if (defaultOK === void 0) {
      defaultOK = true;
    }

    var intl = hasIntl(),
        hasFTP = intl && hasFormatToParts(),
        isActuallyEn = this.isEnglish(),
        hasNoWeirdness = (this.numberingSystem === null || this.numberingSystem === "latn") && (this.outputCalendar === null || this.outputCalendar === "gregory");

    if (!hasFTP && !(isActuallyEn && hasNoWeirdness) && !defaultOK) {
      return "error";
    } else if (!hasFTP || isActuallyEn && hasNoWeirdness) {
      return "en";
    } else {
      return "intl";
    }
  };

  _proto4.clone = function clone(alts) {
    if (!alts || Object.getOwnPropertyNames(alts).length === 0) {
      return this;
    } else {
      return Locale.create(alts.locale || this.specifiedLocale, alts.numberingSystem || this.numberingSystem, alts.outputCalendar || this.outputCalendar, alts.defaultToEN || false);
    }
  };

  _proto4.redefaultToEN = function redefaultToEN(alts) {
    if (alts === void 0) {
      alts = {};
    }

    return this.clone(Object.assign({}, alts, {
      defaultToEN: true
    }));
  };

  _proto4.redefaultToSystem = function redefaultToSystem(alts) {
    if (alts === void 0) {
      alts = {};
    }

    return this.clone(Object.assign({}, alts, {
      defaultToEN: false
    }));
  };

  _proto4.months = function months$1(length, format, defaultOK) {
    var _this = this;

    if (format === void 0) {
      format = false;
    }

    if (defaultOK === void 0) {
      defaultOK = true;
    }

    return listStuff(this, length, defaultOK, months, function () {
      var intl = format ? {
        month: length,
        day: "numeric"
      } : {
        month: length
      },
          formatStr = format ? "format" : "standalone";

      if (!_this.monthsCache[formatStr][length]) {
        _this.monthsCache[formatStr][length] = mapMonths(function (dt) {
          return _this.extract(dt, intl, "month");
        });
      }

      return _this.monthsCache[formatStr][length];
    });
  };

  _proto4.weekdays = function weekdays$1(length, format, defaultOK) {
    var _this2 = this;

    if (format === void 0) {
      format = false;
    }

    if (defaultOK === void 0) {
      defaultOK = true;
    }

    return listStuff(this, length, defaultOK, weekdays, function () {
      var intl = format ? {
        weekday: length,
        year: "numeric",
        month: "long",
        day: "numeric"
      } : {
        weekday: length
      },
          formatStr = format ? "format" : "standalone";

      if (!_this2.weekdaysCache[formatStr][length]) {
        _this2.weekdaysCache[formatStr][length] = mapWeekdays(function (dt) {
          return _this2.extract(dt, intl, "weekday");
        });
      }

      return _this2.weekdaysCache[formatStr][length];
    });
  };

  _proto4.meridiems = function meridiems$1(defaultOK) {
    var _this3 = this;

    if (defaultOK === void 0) {
      defaultOK = true;
    }

    return listStuff(this, undefined, defaultOK, function () {
      return meridiems;
    }, function () {
      // In theory there could be aribitrary day periods. We're gonna assume there are exactly two
      // for AM and PM. This is probably wrong, but it's makes parsing way easier.
      if (!_this3.meridiemCache) {
        var intl = {
          hour: "numeric",
          hour12: true
        };
        _this3.meridiemCache = [DateTime.utc(2016, 11, 13, 9), DateTime.utc(2016, 11, 13, 19)].map(function (dt) {
          return _this3.extract(dt, intl, "dayperiod");
        });
      }

      return _this3.meridiemCache;
    });
  };

  _proto4.eras = function eras$1(length, defaultOK) {
    var _this4 = this;

    if (defaultOK === void 0) {
      defaultOK = true;
    }

    return listStuff(this, length, defaultOK, eras, function () {
      var intl = {
        era: length
      }; // This is problematic. Different calendars are going to define eras totally differently. What I need is the minimum set of dates
      // to definitely enumerate them.

      if (!_this4.eraCache[length]) {
        _this4.eraCache[length] = [DateTime.utc(-40, 1, 1), DateTime.utc(2017, 1, 1)].map(function (dt) {
          return _this4.extract(dt, intl, "era");
        });
      }

      return _this4.eraCache[length];
    });
  };

  _proto4.extract = function extract(dt, intlOpts, field) {
    var df = this.dtFormatter(dt, intlOpts),
        results = df.formatToParts(),
        matching = results.find(function (m) {
      return m.type.toLowerCase() === field;
    });
    return matching ? matching.value : null;
  };

  _proto4.numberFormatter = function numberFormatter(opts) {
    if (opts === void 0) {
      opts = {};
    }

    // this forcesimple option is never used (the only caller short-circuits on it, but it seems safer to leave)
    // (in contrast, the rest of the condition is used heavily)
    return new PolyNumberFormatter(this.intl, opts.forceSimple || this.fastNumbers, opts);
  };

  _proto4.dtFormatter = function dtFormatter(dt, intlOpts) {
    if (intlOpts === void 0) {
      intlOpts = {};
    }

    return new PolyDateFormatter(dt, this.intl, intlOpts);
  };

  _proto4.relFormatter = function relFormatter(opts) {
    if (opts === void 0) {
      opts = {};
    }

    return new PolyRelFormatter(this.intl, this.isEnglish(), opts);
  };

  _proto4.isEnglish = function isEnglish() {
    return this.locale === "en" || this.locale.toLowerCase() === "en-us" || hasIntl() && new Intl.DateTimeFormat(this.intl).resolvedOptions().locale.startsWith("en-us");
  };

  _proto4.equals = function equals(other) {
    return this.locale === other.locale && this.numberingSystem === other.numberingSystem && this.outputCalendar === other.outputCalendar;
  };

  _createClass(Locale, [{
    key: "fastNumbers",
    get: function get() {
      if (this.fastNumbersCached == null) {
        this.fastNumbersCached = supportsFastNumbers(this);
      }

      return this.fastNumbersCached;
    }
  }]);

  return Locale;
}();

/*
 * This file handles parsing for well-specified formats. Here's how it works:
 * Two things go into parsing: a regex to match with and an extractor to take apart the groups in the match.
 * An extractor is just a function that takes a regex match array and returns a { year: ..., month: ... } object
 * parse() does the work of executing the regex and applying the extractor. It takes multiple regex/extractor pairs to try in sequence.
 * Extractors can take a "cursor" representing the offset in the match to look at. This makes it easy to combine extractors.
 * combineExtractors() does the work of combining them, keeping track of the cursor through multiple extractions.
 * Some extractions are super dumb and simpleParse and fromStrings help DRY them.
 */

function combineRegexes() {
  for (var _len = arguments.length, regexes = new Array(_len), _key = 0; _key < _len; _key++) {
    regexes[_key] = arguments[_key];
  }

  var full = regexes.reduce(function (f, r) {
    return f + r.source;
  }, "");
  return RegExp("^" + full + "$");
}

function combineExtractors() {
  for (var _len2 = arguments.length, extractors = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
    extractors[_key2] = arguments[_key2];
  }

  return function (m) {
    return extractors.reduce(function (_ref, ex) {
      var mergedVals = _ref[0],
          mergedZone = _ref[1],
          cursor = _ref[2];

      var _ex = ex(m, cursor),
          val = _ex[0],
          zone = _ex[1],
          next = _ex[2];

      return [Object.assign(mergedVals, val), mergedZone || zone, next];
    }, [{}, null, 1]).slice(0, 2);
  };
}

function parse(s) {
  if (s == null) {
    return [null, null];
  }

  for (var _len3 = arguments.length, patterns = new Array(_len3 > 1 ? _len3 - 1 : 0), _key3 = 1; _key3 < _len3; _key3++) {
    patterns[_key3 - 1] = arguments[_key3];
  }

  for (var _i = 0, _patterns = patterns; _i < _patterns.length; _i++) {
    var _patterns$_i = _patterns[_i],
        regex = _patterns$_i[0],
        extractor = _patterns$_i[1];
    var m = regex.exec(s);

    if (m) {
      return extractor(m);
    }
  }

  return [null, null];
}

function simpleParse() {
  for (var _len4 = arguments.length, keys = new Array(_len4), _key4 = 0; _key4 < _len4; _key4++) {
    keys[_key4] = arguments[_key4];
  }

  return function (match, cursor) {
    var ret = {};
    var i;

    for (i = 0; i < keys.length; i++) {
      ret[keys[i]] = parseInteger(match[cursor + i]);
    }

    return [ret, null, cursor + i];
  };
} // ISO and SQL parsing


var offsetRegex = /(?:(Z)|([+-]\d\d)(?::?(\d\d))?)/,
    isoTimeBaseRegex = /(\d\d)(?::?(\d\d)(?::?(\d\d)(?:[.,](\d{1,30}))?)?)?/,
    isoTimeRegex = RegExp("" + isoTimeBaseRegex.source + offsetRegex.source + "?"),
    isoTimeExtensionRegex = RegExp("(?:T" + isoTimeRegex.source + ")?"),
    isoYmdRegex = /([+-]\d{6}|\d{4})(?:-?(\d\d)(?:-?(\d\d))?)?/,
    isoWeekRegex = /(\d{4})-?W(\d\d)(?:-?(\d))?/,
    isoOrdinalRegex = /(\d{4})-?(\d{3})/,
    extractISOWeekData = simpleParse("weekYear", "weekNumber", "weekDay"),
    extractISOOrdinalData = simpleParse("year", "ordinal"),
    sqlYmdRegex = /(\d{4})-(\d\d)-(\d\d)/,
    // dumbed-down version of the ISO one
sqlTimeRegex = RegExp(isoTimeBaseRegex.source + " ?(?:" + offsetRegex.source + "|(" + ianaRegex.source + "))?"),
    sqlTimeExtensionRegex = RegExp("(?: " + sqlTimeRegex.source + ")?");

function int(match, pos, fallback) {
  var m = match[pos];
  return isUndefined(m) ? fallback : parseInteger(m);
}

function extractISOYmd(match, cursor) {
  var item = {
    year: int(match, cursor),
    month: int(match, cursor + 1, 1),
    day: int(match, cursor + 2, 1)
  };
  return [item, null, cursor + 3];
}

function extractISOTime(match, cursor) {
  var item = {
    hours: int(match, cursor, 0),
    minutes: int(match, cursor + 1, 0),
    seconds: int(match, cursor + 2, 0),
    milliseconds: parseMillis(match[cursor + 3])
  };
  return [item, null, cursor + 4];
}

function extractISOOffset(match, cursor) {
  var local = !match[cursor] && !match[cursor + 1],
      fullOffset = signedOffset(match[cursor + 1], match[cursor + 2]),
      zone = local ? null : FixedOffsetZone.instance(fullOffset);
  return [{}, zone, cursor + 3];
}

function extractIANAZone(match, cursor) {
  var zone = match[cursor] ? IANAZone.create(match[cursor]) : null;
  return [{}, zone, cursor + 1];
} // ISO time parsing


var isoTimeOnly = RegExp("^T?" + isoTimeBaseRegex.source + "$"); // ISO duration parsing

var isoDuration = /^-?P(?:(?:(-?\d{1,9})Y)?(?:(-?\d{1,9})M)?(?:(-?\d{1,9})W)?(?:(-?\d{1,9})D)?(?:T(?:(-?\d{1,9})H)?(?:(-?\d{1,9})M)?(?:(-?\d{1,20})(?:[.,](-?\d{1,9}))?S)?)?)$/;

function extractISODuration(match) {
  var s = match[0],
      yearStr = match[1],
      monthStr = match[2],
      weekStr = match[3],
      dayStr = match[4],
      hourStr = match[5],
      minuteStr = match[6],
      secondStr = match[7],
      millisecondsStr = match[8];
  var hasNegativePrefix = s[0] === "-";
  var negativeSeconds = secondStr && secondStr[0] === "-";

  var maybeNegate = function maybeNegate(num, force) {
    if (force === void 0) {
      force = false;
    }

    return num !== undefined && (force || num && hasNegativePrefix) ? -num : num;
  };

  return [{
    years: maybeNegate(parseInteger(yearStr)),
    months: maybeNegate(parseInteger(monthStr)),
    weeks: maybeNegate(parseInteger(weekStr)),
    days: maybeNegate(parseInteger(dayStr)),
    hours: maybeNegate(parseInteger(hourStr)),
    minutes: maybeNegate(parseInteger(minuteStr)),
    seconds: maybeNegate(parseInteger(secondStr), secondStr === "-0"),
    milliseconds: maybeNegate(parseMillis(millisecondsStr), negativeSeconds)
  }];
} // These are a little braindead. EDT *should* tell us that we're in, say, America/New_York
// and not just that we're in -240 *right now*. But since I don't think these are used that often
// I'm just going to ignore that


var obsOffsets = {
  GMT: 0,
  EDT: -4 * 60,
  EST: -5 * 60,
  CDT: -5 * 60,
  CST: -6 * 60,
  MDT: -6 * 60,
  MST: -7 * 60,
  PDT: -7 * 60,
  PST: -8 * 60
};

function fromStrings(weekdayStr, yearStr, monthStr, dayStr, hourStr, minuteStr, secondStr) {
  var result = {
    year: yearStr.length === 2 ? untruncateYear(parseInteger(yearStr)) : parseInteger(yearStr),
    month: monthsShort.indexOf(monthStr) + 1,
    day: parseInteger(dayStr),
    hour: parseInteger(hourStr),
    minute: parseInteger(minuteStr)
  };
  if (secondStr) result.second = parseInteger(secondStr);

  if (weekdayStr) {
    result.weekday = weekdayStr.length > 3 ? weekdaysLong.indexOf(weekdayStr) + 1 : weekdaysShort.indexOf(weekdayStr) + 1;
  }

  return result;
} // RFC 2822/5322


var rfc2822 = /^(?:(Mon|Tue|Wed|Thu|Fri|Sat|Sun),\s)?(\d{1,2})\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{2,4})\s(\d\d):(\d\d)(?::(\d\d))?\s(?:(UT|GMT|[ECMP][SD]T)|([Zz])|(?:([+-]\d\d)(\d\d)))$/;

function extractRFC2822(match) {
  var weekdayStr = match[1],
      dayStr = match[2],
      monthStr = match[3],
      yearStr = match[4],
      hourStr = match[5],
      minuteStr = match[6],
      secondStr = match[7],
      obsOffset = match[8],
      milOffset = match[9],
      offHourStr = match[10],
      offMinuteStr = match[11],
      result = fromStrings(weekdayStr, yearStr, monthStr, dayStr, hourStr, minuteStr, secondStr);
  var offset;

  if (obsOffset) {
    offset = obsOffsets[obsOffset];
  } else if (milOffset) {
    offset = 0;
  } else {
    offset = signedOffset(offHourStr, offMinuteStr);
  }

  return [result, new FixedOffsetZone(offset)];
}

function preprocessRFC2822(s) {
  // Remove comments and folding whitespace and replace multiple-spaces with a single space
  return s.replace(/\([^)]*\)|[\n\t]/g, " ").replace(/(\s\s+)/g, " ").trim();
} // http date


var rfc1123 = /^(Mon|Tue|Wed|Thu|Fri|Sat|Sun), (\d\d) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) (\d{4}) (\d\d):(\d\d):(\d\d) GMT$/,
    rfc850 = /^(Monday|Tuesday|Wedsday|Thursday|Friday|Saturday|Sunday), (\d\d)-(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)-(\d\d) (\d\d):(\d\d):(\d\d) GMT$/,
    ascii = /^(Mon|Tue|Wed|Thu|Fri|Sat|Sun) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) ( \d|\d\d) (\d\d):(\d\d):(\d\d) (\d{4})$/;

function extractRFC1123Or850(match) {
  var weekdayStr = match[1],
      dayStr = match[2],
      monthStr = match[3],
      yearStr = match[4],
      hourStr = match[5],
      minuteStr = match[6],
      secondStr = match[7],
      result = fromStrings(weekdayStr, yearStr, monthStr, dayStr, hourStr, minuteStr, secondStr);
  return [result, FixedOffsetZone.utcInstance];
}

function extractASCII(match) {
  var weekdayStr = match[1],
      monthStr = match[2],
      dayStr = match[3],
      hourStr = match[4],
      minuteStr = match[5],
      secondStr = match[6],
      yearStr = match[7],
      result = fromStrings(weekdayStr, yearStr, monthStr, dayStr, hourStr, minuteStr, secondStr);
  return [result, FixedOffsetZone.utcInstance];
}

var isoYmdWithTimeExtensionRegex = combineRegexes(isoYmdRegex, isoTimeExtensionRegex);
var isoWeekWithTimeExtensionRegex = combineRegexes(isoWeekRegex, isoTimeExtensionRegex);
var isoOrdinalWithTimeExtensionRegex = combineRegexes(isoOrdinalRegex, isoTimeExtensionRegex);
var isoTimeCombinedRegex = combineRegexes(isoTimeRegex);
var extractISOYmdTimeAndOffset = combineExtractors(extractISOYmd, extractISOTime, extractISOOffset);
var extractISOWeekTimeAndOffset = combineExtractors(extractISOWeekData, extractISOTime, extractISOOffset);
var extractISOOrdinalDateAndTime = combineExtractors(extractISOOrdinalData, extractISOTime, extractISOOffset);
var extractISOTimeAndOffset = combineExtractors(extractISOTime, extractISOOffset);
/**
 * @private
 */

function parseISODate(s) {
  return parse(s, [isoYmdWithTimeExtensionRegex, extractISOYmdTimeAndOffset], [isoWeekWithTimeExtensionRegex, extractISOWeekTimeAndOffset], [isoOrdinalWithTimeExtensionRegex, extractISOOrdinalDateAndTime], [isoTimeCombinedRegex, extractISOTimeAndOffset]);
}
function parseRFC2822Date(s) {
  return parse(preprocessRFC2822(s), [rfc2822, extractRFC2822]);
}
function parseHTTPDate(s) {
  return parse(s, [rfc1123, extractRFC1123Or850], [rfc850, extractRFC1123Or850], [ascii, extractASCII]);
}
function parseISODuration(s) {
  return parse(s, [isoDuration, extractISODuration]);
}
var extractISOTimeOnly = combineExtractors(extractISOTime);
function parseISOTimeOnly(s) {
  return parse(s, [isoTimeOnly, extractISOTimeOnly]);
}
var sqlYmdWithTimeExtensionRegex = combineRegexes(sqlYmdRegex, sqlTimeExtensionRegex);
var sqlTimeCombinedRegex = combineRegexes(sqlTimeRegex);
var extractISOYmdTimeOffsetAndIANAZone = combineExtractors(extractISOYmd, extractISOTime, extractISOOffset, extractIANAZone);
var extractISOTimeOffsetAndIANAZone = combineExtractors(extractISOTime, extractISOOffset, extractIANAZone);
function parseSQL(s) {
  return parse(s, [sqlYmdWithTimeExtensionRegex, extractISOYmdTimeOffsetAndIANAZone], [sqlTimeCombinedRegex, extractISOTimeOffsetAndIANAZone]);
}

var INVALID = "Invalid Duration"; // unit conversion constants

var lowOrderMatrix = {
  weeks: {
    days: 7,
    hours: 7 * 24,
    minutes: 7 * 24 * 60,
    seconds: 7 * 24 * 60 * 60,
    milliseconds: 7 * 24 * 60 * 60 * 1000
  },
  days: {
    hours: 24,
    minutes: 24 * 60,
    seconds: 24 * 60 * 60,
    milliseconds: 24 * 60 * 60 * 1000
  },
  hours: {
    minutes: 60,
    seconds: 60 * 60,
    milliseconds: 60 * 60 * 1000
  },
  minutes: {
    seconds: 60,
    milliseconds: 60 * 1000
  },
  seconds: {
    milliseconds: 1000
  }
},
    casualMatrix = Object.assign({
  years: {
    quarters: 4,
    months: 12,
    weeks: 52,
    days: 365,
    hours: 365 * 24,
    minutes: 365 * 24 * 60,
    seconds: 365 * 24 * 60 * 60,
    milliseconds: 365 * 24 * 60 * 60 * 1000
  },
  quarters: {
    months: 3,
    weeks: 13,
    days: 91,
    hours: 91 * 24,
    minutes: 91 * 24 * 60,
    seconds: 91 * 24 * 60 * 60,
    milliseconds: 91 * 24 * 60 * 60 * 1000
  },
  months: {
    weeks: 4,
    days: 30,
    hours: 30 * 24,
    minutes: 30 * 24 * 60,
    seconds: 30 * 24 * 60 * 60,
    milliseconds: 30 * 24 * 60 * 60 * 1000
  }
}, lowOrderMatrix),
    daysInYearAccurate = 146097.0 / 400,
    daysInMonthAccurate = 146097.0 / 4800,
    accurateMatrix = Object.assign({
  years: {
    quarters: 4,
    months: 12,
    weeks: daysInYearAccurate / 7,
    days: daysInYearAccurate,
    hours: daysInYearAccurate * 24,
    minutes: daysInYearAccurate * 24 * 60,
    seconds: daysInYearAccurate * 24 * 60 * 60,
    milliseconds: daysInYearAccurate * 24 * 60 * 60 * 1000
  },
  quarters: {
    months: 3,
    weeks: daysInYearAccurate / 28,
    days: daysInYearAccurate / 4,
    hours: daysInYearAccurate * 24 / 4,
    minutes: daysInYearAccurate * 24 * 60 / 4,
    seconds: daysInYearAccurate * 24 * 60 * 60 / 4,
    milliseconds: daysInYearAccurate * 24 * 60 * 60 * 1000 / 4
  },
  months: {
    weeks: daysInMonthAccurate / 7,
    days: daysInMonthAccurate,
    hours: daysInMonthAccurate * 24,
    minutes: daysInMonthAccurate * 24 * 60,
    seconds: daysInMonthAccurate * 24 * 60 * 60,
    milliseconds: daysInMonthAccurate * 24 * 60 * 60 * 1000
  }
}, lowOrderMatrix); // units ordered by size

var orderedUnits = ["years", "quarters", "months", "weeks", "days", "hours", "minutes", "seconds", "milliseconds"];
var reverseUnits = orderedUnits.slice(0).reverse(); // clone really means "create another instance just like this one, but with these changes"

function clone(dur, alts, clear) {
  if (clear === void 0) {
    clear = false;
  }

  // deep merge for vals
  var conf = {
    values: clear ? alts.values : Object.assign({}, dur.values, alts.values || {}),
    loc: dur.loc.clone(alts.loc),
    conversionAccuracy: alts.conversionAccuracy || dur.conversionAccuracy
  };
  return new Duration(conf);
}

function antiTrunc(n) {
  return n < 0 ? Math.floor(n) : Math.ceil(n);
} // NB: mutates parameters


function convert(matrix, fromMap, fromUnit, toMap, toUnit) {
  var conv = matrix[toUnit][fromUnit],
      raw = fromMap[fromUnit] / conv,
      sameSign = Math.sign(raw) === Math.sign(toMap[toUnit]),
      // ok, so this is wild, but see the matrix in the tests
  added = !sameSign && toMap[toUnit] !== 0 && Math.abs(raw) <= 1 ? antiTrunc(raw) : Math.trunc(raw);
  toMap[toUnit] += added;
  fromMap[fromUnit] -= added * conv;
} // NB: mutates parameters


function normalizeValues(matrix, vals) {
  reverseUnits.reduce(function (previous, current) {
    if (!isUndefined(vals[current])) {
      if (previous) {
        convert(matrix, vals, previous, vals, current);
      }

      return current;
    } else {
      return previous;
    }
  }, null);
}
/**
 * A Duration object represents a period of time, like "2 months" or "1 day, 1 hour". Conceptually, it's just a map of units to their quantities, accompanied by some additional configuration and methods for creating, parsing, interrogating, transforming, and formatting them. They can be used on their own or in conjunction with other Luxon types; for example, you can use {@link DateTime.plus} to add a Duration object to a DateTime, producing another DateTime.
 *
 * Here is a brief overview of commonly used methods and getters in Duration:
 *
 * * **Creation** To create a Duration, use {@link Duration.fromMillis}, {@link Duration.fromObject}, or {@link Duration.fromISO}.
 * * **Unit values** See the {@link Duration.years}, {@link Duration.months}, {@link Duration.weeks}, {@link Duration.days}, {@link Duration.hours}, {@link Duration.minutes}, {@link Duration.seconds}, {@link Duration.milliseconds} accessors.
 * * **Configuration** See  {@link Duration.locale} and {@link Duration.numberingSystem} accessors.
 * * **Transformation** To create new Durations out of old ones use {@link Duration.plus}, {@link Duration.minus}, {@link Duration.normalize}, {@link Duration.set}, {@link Duration.reconfigure}, {@link Duration.shiftTo}, and {@link Duration.negate}.
 * * **Output** To convert the Duration into other representations, see {@link Duration.as}, {@link Duration.toISO}, {@link Duration.toFormat}, and {@link Duration.toJSON}
 *
 * There's are more methods documented below. In addition, for more information on subtler topics like internationalization and validity, see the external documentation.
 */


var Duration = /*#__PURE__*/function () {
  /**
   * @private
   */
  function Duration(config) {
    var accurate = config.conversionAccuracy === "longterm" || false;
    /**
     * @access private
     */

    this.values = config.values;
    /**
     * @access private
     */

    this.loc = config.loc || Locale.create();
    /**
     * @access private
     */

    this.conversionAccuracy = accurate ? "longterm" : "casual";
    /**
     * @access private
     */

    this.invalid = config.invalid || null;
    /**
     * @access private
     */

    this.matrix = accurate ? accurateMatrix : casualMatrix;
    /**
     * @access private
     */

    this.isLuxonDuration = true;
  }
  /**
   * Create Duration from a number of milliseconds.
   * @param {number} count of milliseconds
   * @param {Object} opts - options for parsing
   * @param {string} [opts.locale='en-US'] - the locale to use
   * @param {string} opts.numberingSystem - the numbering system to use
   * @param {string} [opts.conversionAccuracy='casual'] - the conversion system to use
   * @return {Duration}
   */


  Duration.fromMillis = function fromMillis(count, opts) {
    return Duration.fromObject(Object.assign({
      milliseconds: count
    }, opts));
  }
  /**
   * Create a Duration from a JavaScript object with keys like 'years' and 'hours'.
   * If this object is empty then a zero milliseconds duration is returned.
   * @param {Object} obj - the object to create the DateTime from
   * @param {number} obj.years
   * @param {number} obj.quarters
   * @param {number} obj.months
   * @param {number} obj.weeks
   * @param {number} obj.days
   * @param {number} obj.hours
   * @param {number} obj.minutes
   * @param {number} obj.seconds
   * @param {number} obj.milliseconds
   * @param {string} [obj.locale='en-US'] - the locale to use
   * @param {string} obj.numberingSystem - the numbering system to use
   * @param {string} [obj.conversionAccuracy='casual'] - the conversion system to use
   * @return {Duration}
   */
  ;

  Duration.fromObject = function fromObject(obj) {
    if (obj == null || typeof obj !== "object") {
      throw new InvalidArgumentError("Duration.fromObject: argument expected to be an object, got " + (obj === null ? "null" : typeof obj));
    }

    return new Duration({
      values: normalizeObject(obj, Duration.normalizeUnit, ["locale", "numberingSystem", "conversionAccuracy", "zone" // a bit of debt; it's super inconvenient internally not to be able to blindly pass this
      ]),
      loc: Locale.fromObject(obj),
      conversionAccuracy: obj.conversionAccuracy
    });
  }
  /**
   * Create a Duration from an ISO 8601 duration string.
   * @param {string} text - text to parse
   * @param {Object} opts - options for parsing
   * @param {string} [opts.locale='en-US'] - the locale to use
   * @param {string} opts.numberingSystem - the numbering system to use
   * @param {string} [opts.conversionAccuracy='casual'] - the conversion system to use
   * @see https://en.wikipedia.org/wiki/ISO_8601#Durations
   * @example Duration.fromISO('P3Y6M1W4DT12H30M5S').toObject() //=> { years: 3, months: 6, weeks: 1, days: 4, hours: 12, minutes: 30, seconds: 5 }
   * @example Duration.fromISO('PT23H').toObject() //=> { hours: 23 }
   * @example Duration.fromISO('P5Y3M').toObject() //=> { years: 5, months: 3 }
   * @return {Duration}
   */
  ;

  Duration.fromISO = function fromISO(text, opts) {
    var _parseISODuration = parseISODuration(text),
        parsed = _parseISODuration[0];

    if (parsed) {
      var obj = Object.assign(parsed, opts);
      return Duration.fromObject(obj);
    } else {
      return Duration.invalid("unparsable", "the input \"" + text + "\" can't be parsed as ISO 8601");
    }
  }
  /**
   * Create a Duration from an ISO 8601 time string.
   * @param {string} text - text to parse
   * @param {Object} opts - options for parsing
   * @param {string} [opts.locale='en-US'] - the locale to use
   * @param {string} opts.numberingSystem - the numbering system to use
   * @param {string} [opts.conversionAccuracy='casual'] - the conversion system to use
   * @see https://en.wikipedia.org/wiki/ISO_8601#Times
   * @example Duration.fromISOTime('11:22:33.444').toObject() //=> { hours: 11, minutes: 22, seconds: 33, milliseconds: 444 }
   * @example Duration.fromISOTime('11:00').toObject() //=> { hours: 11, minutes: 0, seconds: 0 }
   * @example Duration.fromISOTime('T11:00').toObject() //=> { hours: 11, minutes: 0, seconds: 0 }
   * @example Duration.fromISOTime('1100').toObject() //=> { hours: 11, minutes: 0, seconds: 0 }
   * @example Duration.fromISOTime('T1100').toObject() //=> { hours: 11, minutes: 0, seconds: 0 }
   * @return {Duration}
   */
  ;

  Duration.fromISOTime = function fromISOTime(text, opts) {
    var _parseISOTimeOnly = parseISOTimeOnly(text),
        parsed = _parseISOTimeOnly[0];

    if (parsed) {
      var obj = Object.assign(parsed, opts);
      return Duration.fromObject(obj);
    } else {
      return Duration.invalid("unparsable", "the input \"" + text + "\" can't be parsed as ISO 8601");
    }
  }
  /**
   * Create an invalid Duration.
   * @param {string} reason - simple string of why this datetime is invalid. Should not contain parameters or anything else data-dependent
   * @param {string} [explanation=null] - longer explanation, may include parameters and other useful debugging information
   * @return {Duration}
   */
  ;

  Duration.invalid = function invalid(reason, explanation) {
    if (explanation === void 0) {
      explanation = null;
    }

    if (!reason) {
      throw new InvalidArgumentError("need to specify a reason the Duration is invalid");
    }

    var invalid = reason instanceof Invalid ? reason : new Invalid(reason, explanation);

    if (Settings.throwOnInvalid) {
      throw new InvalidDurationError(invalid);
    } else {
      return new Duration({
        invalid: invalid
      });
    }
  }
  /**
   * @private
   */
  ;

  Duration.normalizeUnit = function normalizeUnit(unit) {
    var normalized = {
      year: "years",
      years: "years",
      quarter: "quarters",
      quarters: "quarters",
      month: "months",
      months: "months",
      week: "weeks",
      weeks: "weeks",
      day: "days",
      days: "days",
      hour: "hours",
      hours: "hours",
      minute: "minutes",
      minutes: "minutes",
      second: "seconds",
      seconds: "seconds",
      millisecond: "milliseconds",
      milliseconds: "milliseconds"
    }[unit ? unit.toLowerCase() : unit];
    if (!normalized) throw new InvalidUnitError(unit);
    return normalized;
  }
  /**
   * Check if an object is a Duration. Works across context boundaries
   * @param {object} o
   * @return {boolean}
   */
  ;

  Duration.isDuration = function isDuration(o) {
    return o && o.isLuxonDuration || false;
  }
  /**
   * Get  the locale of a Duration, such 'en-GB'
   * @type {string}
   */
  ;

  var _proto = Duration.prototype;

  /**
   * Returns a string representation of this Duration formatted according to the specified format string. You may use these tokens:
   * * `S` for milliseconds
   * * `s` for seconds
   * * `m` for minutes
   * * `h` for hours
   * * `d` for days
   * * `M` for months
   * * `y` for years
   * Notes:
   * * Add padding by repeating the token, e.g. "yy" pads the years to two digits, "hhhh" pads the hours out to four digits
   * * The duration will be converted to the set of units in the format string using {@link Duration.shiftTo} and the Durations's conversion accuracy setting.
   * @param {string} fmt - the format string
   * @param {Object} opts - options
   * @param {boolean} [opts.floor=true] - floor numerical values
   * @example Duration.fromObject({ years: 1, days: 6, seconds: 2 }).toFormat("y d s") //=> "1 6 2"
   * @example Duration.fromObject({ years: 1, days: 6, seconds: 2 }).toFormat("yy dd sss") //=> "01 06 002"
   * @example Duration.fromObject({ years: 1, days: 6, seconds: 2 }).toFormat("M S") //=> "12 518402000"
   * @return {string}
   */
  _proto.toFormat = function toFormat(fmt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    // reverse-compat since 1.2; we always round down now, never up, and we do it by default
    var fmtOpts = Object.assign({}, opts, {
      floor: opts.round !== false && opts.floor !== false
    });
    return this.isValid ? Formatter.create(this.loc, fmtOpts).formatDurationFromString(this, fmt) : INVALID;
  }
  /**
   * Returns a JavaScript object with this Duration's values.
   * @param opts - options for generating the object
   * @param {boolean} [opts.includeConfig=false] - include configuration attributes in the output
   * @example Duration.fromObject({ years: 1, days: 6, seconds: 2 }).toObject() //=> { years: 1, days: 6, seconds: 2 }
   * @return {Object}
   */
  ;

  _proto.toObject = function toObject(opts) {
    if (opts === void 0) {
      opts = {};
    }

    if (!this.isValid) return {};
    var base = Object.assign({}, this.values);

    if (opts.includeConfig) {
      base.conversionAccuracy = this.conversionAccuracy;
      base.numberingSystem = this.loc.numberingSystem;
      base.locale = this.loc.locale;
    }

    return base;
  }
  /**
   * Returns an ISO 8601-compliant string representation of this Duration.
   * @see https://en.wikipedia.org/wiki/ISO_8601#Durations
   * @example Duration.fromObject({ years: 3, seconds: 45 }).toISO() //=> 'P3YT45S'
   * @example Duration.fromObject({ months: 4, seconds: 45 }).toISO() //=> 'P4MT45S'
   * @example Duration.fromObject({ months: 5 }).toISO() //=> 'P5M'
   * @example Duration.fromObject({ minutes: 5 }).toISO() //=> 'PT5M'
   * @example Duration.fromObject({ milliseconds: 6 }).toISO() //=> 'PT0.006S'
   * @return {string}
   */
  ;

  _proto.toISO = function toISO() {
    // we could use the formatter, but this is an easier way to get the minimum string
    if (!this.isValid) return null;
    var s = "P";
    if (this.years !== 0) s += this.years + "Y";
    if (this.months !== 0 || this.quarters !== 0) s += this.months + this.quarters * 3 + "M";
    if (this.weeks !== 0) s += this.weeks + "W";
    if (this.days !== 0) s += this.days + "D";
    if (this.hours !== 0 || this.minutes !== 0 || this.seconds !== 0 || this.milliseconds !== 0) s += "T";
    if (this.hours !== 0) s += this.hours + "H";
    if (this.minutes !== 0) s += this.minutes + "M";
    if (this.seconds !== 0 || this.milliseconds !== 0) // this will handle "floating point madness" by removing extra decimal places
      // https://stackoverflow.com/questions/588004/is-floating-point-math-broken
      s += roundTo(this.seconds + this.milliseconds / 1000, 3) + "S";
    if (s === "P") s += "T0S";
    return s;
  }
  /**
   * Returns an ISO 8601-compliant string representation of this Duration, formatted as a time of day.
   * Note that this will return null if the duration is invalid, negative, or equal to or greater than 24 hours.
   * @see https://en.wikipedia.org/wiki/ISO_8601#Times
   * @param {Object} opts - options
   * @param {boolean} [opts.suppressMilliseconds=false] - exclude milliseconds from the format if they're 0
   * @param {boolean} [opts.suppressSeconds=false] - exclude seconds from the format if they're 0
   * @param {boolean} [opts.includePrefix=false] - include the `T` prefix
   * @param {string} [opts.format='extended'] - choose between the basic and extended format
   * @example Duration.fromObject({ hours: 11 }).toISOTime() //=> '11:00:00.000'
   * @example Duration.fromObject({ hours: 11 }).toISOTime({ suppressMilliseconds: true }) //=> '11:00:00'
   * @example Duration.fromObject({ hours: 11 }).toISOTime({ suppressSeconds: true }) //=> '11:00'
   * @example Duration.fromObject({ hours: 11 }).toISOTime({ includePrefix: true }) //=> 'T11:00:00.000'
   * @example Duration.fromObject({ hours: 11 }).toISOTime({ format: 'basic' }) //=> '110000.000'
   * @return {string}
   */
  ;

  _proto.toISOTime = function toISOTime(opts) {
    if (opts === void 0) {
      opts = {};
    }

    if (!this.isValid) return null;
    var millis = this.toMillis();
    if (millis < 0 || millis >= 86400000) return null;
    opts = Object.assign({
      suppressMilliseconds: false,
      suppressSeconds: false,
      includePrefix: false,
      format: "extended"
    }, opts);
    var value = this.shiftTo("hours", "minutes", "seconds", "milliseconds");
    var fmt = opts.format === "basic" ? "hhmm" : "hh:mm";

    if (!opts.suppressSeconds || value.seconds !== 0 || value.milliseconds !== 0) {
      fmt += opts.format === "basic" ? "ss" : ":ss";

      if (!opts.suppressMilliseconds || value.milliseconds !== 0) {
        fmt += ".SSS";
      }
    }

    var str = value.toFormat(fmt);

    if (opts.includePrefix) {
      str = "T" + str;
    }

    return str;
  }
  /**
   * Returns an ISO 8601 representation of this Duration appropriate for use in JSON.
   * @return {string}
   */
  ;

  _proto.toJSON = function toJSON() {
    return this.toISO();
  }
  /**
   * Returns an ISO 8601 representation of this Duration appropriate for use in debugging.
   * @return {string}
   */
  ;

  _proto.toString = function toString() {
    return this.toISO();
  }
  /**
   * Returns an milliseconds value of this Duration.
   * @return {number}
   */
  ;

  _proto.toMillis = function toMillis() {
    return this.as("milliseconds");
  }
  /**
   * Returns an milliseconds value of this Duration. Alias of {@link toMillis}
   * @return {number}
   */
  ;

  _proto.valueOf = function valueOf() {
    return this.toMillis();
  }
  /**
   * Make this Duration longer by the specified amount. Return a newly-constructed Duration.
   * @param {Duration|Object|number} duration - The amount to add. Either a Luxon Duration, a number of milliseconds, the object argument to Duration.fromObject()
   * @return {Duration}
   */
  ;

  _proto.plus = function plus(duration) {
    if (!this.isValid) return this;
    var dur = friendlyDuration(duration),
        result = {};

    for (var _iterator = _createForOfIteratorHelperLoose(orderedUnits), _step; !(_step = _iterator()).done;) {
      var k = _step.value;

      if (hasOwnProperty(dur.values, k) || hasOwnProperty(this.values, k)) {
        result[k] = dur.get(k) + this.get(k);
      }
    }

    return clone(this, {
      values: result
    }, true);
  }
  /**
   * Make this Duration shorter by the specified amount. Return a newly-constructed Duration.
   * @param {Duration|Object|number} duration - The amount to subtract. Either a Luxon Duration, a number of milliseconds, the object argument to Duration.fromObject()
   * @return {Duration}
   */
  ;

  _proto.minus = function minus(duration) {
    if (!this.isValid) return this;
    var dur = friendlyDuration(duration);
    return this.plus(dur.negate());
  }
  /**
   * Scale this Duration by the specified amount. Return a newly-constructed Duration.
   * @param {function} fn - The function to apply to each unit. Arity is 1 or 2: the value of the unit and, optionally, the unit name. Must return a number.
   * @example Duration.fromObject({ hours: 1, minutes: 30 }).mapUnit(x => x * 2) //=> { hours: 2, minutes: 60 }
   * @example Duration.fromObject({ hours: 1, minutes: 30 }).mapUnit((x, u) => u === "hour" ? x * 2 : x) //=> { hours: 2, minutes: 30 }
   * @return {Duration}
   */
  ;

  _proto.mapUnits = function mapUnits(fn) {
    if (!this.isValid) return this;
    var result = {};

    for (var _i = 0, _Object$keys = Object.keys(this.values); _i < _Object$keys.length; _i++) {
      var k = _Object$keys[_i];
      result[k] = asNumber(fn(this.values[k], k));
    }

    return clone(this, {
      values: result
    }, true);
  }
  /**
   * Get the value of unit.
   * @param {string} unit - a unit such as 'minute' or 'day'
   * @example Duration.fromObject({years: 2, days: 3}).get('years') //=> 2
   * @example Duration.fromObject({years: 2, days: 3}).get('months') //=> 0
   * @example Duration.fromObject({years: 2, days: 3}).get('days') //=> 3
   * @return {number}
   */
  ;

  _proto.get = function get(unit) {
    return this[Duration.normalizeUnit(unit)];
  }
  /**
   * "Set" the values of specified units. Return a newly-constructed Duration.
   * @param {Object} values - a mapping of units to numbers
   * @example dur.set({ years: 2017 })
   * @example dur.set({ hours: 8, minutes: 30 })
   * @return {Duration}
   */
  ;

  _proto.set = function set(values) {
    if (!this.isValid) return this;
    var mixed = Object.assign(this.values, normalizeObject(values, Duration.normalizeUnit, []));
    return clone(this, {
      values: mixed
    });
  }
  /**
   * "Set" the locale and/or numberingSystem.  Returns a newly-constructed Duration.
   * @example dur.reconfigure({ locale: 'en-GB' })
   * @return {Duration}
   */
  ;

  _proto.reconfigure = function reconfigure(_temp) {
    var _ref = _temp === void 0 ? {} : _temp,
        locale = _ref.locale,
        numberingSystem = _ref.numberingSystem,
        conversionAccuracy = _ref.conversionAccuracy;

    var loc = this.loc.clone({
      locale: locale,
      numberingSystem: numberingSystem
    }),
        opts = {
      loc: loc
    };

    if (conversionAccuracy) {
      opts.conversionAccuracy = conversionAccuracy;
    }

    return clone(this, opts);
  }
  /**
   * Return the length of the duration in the specified unit.
   * @param {string} unit - a unit such as 'minutes' or 'days'
   * @example Duration.fromObject({years: 1}).as('days') //=> 365
   * @example Duration.fromObject({years: 1}).as('months') //=> 12
   * @example Duration.fromObject({hours: 60}).as('days') //=> 2.5
   * @return {number}
   */
  ;

  _proto.as = function as(unit) {
    return this.isValid ? this.shiftTo(unit).get(unit) : NaN;
  }
  /**
   * Reduce this Duration to its canonical representation in its current units.
   * @example Duration.fromObject({ years: 2, days: 5000 }).normalize().toObject() //=> { years: 15, days: 255 }
   * @example Duration.fromObject({ hours: 12, minutes: -45 }).normalize().toObject() //=> { hours: 11, minutes: 15 }
   * @return {Duration}
   */
  ;

  _proto.normalize = function normalize() {
    if (!this.isValid) return this;
    var vals = this.toObject();
    normalizeValues(this.matrix, vals);
    return clone(this, {
      values: vals
    }, true);
  }
  /**
   * Convert this Duration into its representation in a different set of units.
   * @example Duration.fromObject({ hours: 1, seconds: 30 }).shiftTo('minutes', 'milliseconds').toObject() //=> { minutes: 60, milliseconds: 30000 }
   * @return {Duration}
   */
  ;

  _proto.shiftTo = function shiftTo() {
    for (var _len = arguments.length, units = new Array(_len), _key = 0; _key < _len; _key++) {
      units[_key] = arguments[_key];
    }

    if (!this.isValid) return this;

    if (units.length === 0) {
      return this;
    }

    units = units.map(function (u) {
      return Duration.normalizeUnit(u);
    });
    var built = {},
        accumulated = {},
        vals = this.toObject();
    var lastUnit;

    for (var _iterator2 = _createForOfIteratorHelperLoose(orderedUnits), _step2; !(_step2 = _iterator2()).done;) {
      var k = _step2.value;

      if (units.indexOf(k) >= 0) {
        lastUnit = k;
        var own = 0; // anything we haven't boiled down yet should get boiled to this unit

        for (var ak in accumulated) {
          own += this.matrix[ak][k] * accumulated[ak];
          accumulated[ak] = 0;
        } // plus anything that's already in this unit


        if (isNumber(vals[k])) {
          own += vals[k];
        }

        var i = Math.trunc(own);
        built[k] = i;
        accumulated[k] = own - i; // we'd like to absorb these fractions in another unit
        // plus anything further down the chain that should be rolled up in to this

        for (var down in vals) {
          if (orderedUnits.indexOf(down) > orderedUnits.indexOf(k)) {
            convert(this.matrix, vals, down, built, k);
          }
        } // otherwise, keep it in the wings to boil it later

      } else if (isNumber(vals[k])) {
        accumulated[k] = vals[k];
      }
    } // anything leftover becomes the decimal for the last unit
    // lastUnit must be defined since units is not empty


    for (var key in accumulated) {
      if (accumulated[key] !== 0) {
        built[lastUnit] += key === lastUnit ? accumulated[key] : accumulated[key] / this.matrix[lastUnit][key];
      }
    }

    return clone(this, {
      values: built
    }, true).normalize();
  }
  /**
   * Return the negative of this Duration.
   * @example Duration.fromObject({ hours: 1, seconds: 30 }).negate().toObject() //=> { hours: -1, seconds: -30 }
   * @return {Duration}
   */
  ;

  _proto.negate = function negate() {
    if (!this.isValid) return this;
    var negated = {};

    for (var _i2 = 0, _Object$keys2 = Object.keys(this.values); _i2 < _Object$keys2.length; _i2++) {
      var k = _Object$keys2[_i2];
      negated[k] = -this.values[k];
    }

    return clone(this, {
      values: negated
    }, true);
  }
  /**
   * Get the years.
   * @type {number}
   */
  ;

  /**
   * Equality check
   * Two Durations are equal iff they have the same units and the same values for each unit.
   * @param {Duration} other
   * @return {boolean}
   */
  _proto.equals = function equals(other) {
    if (!this.isValid || !other.isValid) {
      return false;
    }

    if (!this.loc.equals(other.loc)) {
      return false;
    }

    function eq(v1, v2) {
      // Consider 0 and undefined as equal
      if (v1 === undefined || v1 === 0) return v2 === undefined || v2 === 0;
      return v1 === v2;
    }

    for (var _iterator3 = _createForOfIteratorHelperLoose(orderedUnits), _step3; !(_step3 = _iterator3()).done;) {
      var u = _step3.value;

      if (!eq(this.values[u], other.values[u])) {
        return false;
      }
    }

    return true;
  };

  _createClass(Duration, [{
    key: "locale",
    get: function get() {
      return this.isValid ? this.loc.locale : null;
    }
    /**
     * Get the numbering system of a Duration, such 'beng'. The numbering system is used when formatting the Duration
     *
     * @type {string}
     */

  }, {
    key: "numberingSystem",
    get: function get() {
      return this.isValid ? this.loc.numberingSystem : null;
    }
  }, {
    key: "years",
    get: function get() {
      return this.isValid ? this.values.years || 0 : NaN;
    }
    /**
     * Get the quarters.
     * @type {number}
     */

  }, {
    key: "quarters",
    get: function get() {
      return this.isValid ? this.values.quarters || 0 : NaN;
    }
    /**
     * Get the months.
     * @type {number}
     */

  }, {
    key: "months",
    get: function get() {
      return this.isValid ? this.values.months || 0 : NaN;
    }
    /**
     * Get the weeks
     * @type {number}
     */

  }, {
    key: "weeks",
    get: function get() {
      return this.isValid ? this.values.weeks || 0 : NaN;
    }
    /**
     * Get the days.
     * @type {number}
     */

  }, {
    key: "days",
    get: function get() {
      return this.isValid ? this.values.days || 0 : NaN;
    }
    /**
     * Get the hours.
     * @type {number}
     */

  }, {
    key: "hours",
    get: function get() {
      return this.isValid ? this.values.hours || 0 : NaN;
    }
    /**
     * Get the minutes.
     * @type {number}
     */

  }, {
    key: "minutes",
    get: function get() {
      return this.isValid ? this.values.minutes || 0 : NaN;
    }
    /**
     * Get the seconds.
     * @return {number}
     */

  }, {
    key: "seconds",
    get: function get() {
      return this.isValid ? this.values.seconds || 0 : NaN;
    }
    /**
     * Get the milliseconds.
     * @return {number}
     */

  }, {
    key: "milliseconds",
    get: function get() {
      return this.isValid ? this.values.milliseconds || 0 : NaN;
    }
    /**
     * Returns whether the Duration is invalid. Invalid durations are returned by diff operations
     * on invalid DateTimes or Intervals.
     * @return {boolean}
     */

  }, {
    key: "isValid",
    get: function get() {
      return this.invalid === null;
    }
    /**
     * Returns an error code if this Duration became invalid, or null if the Duration is valid
     * @return {string}
     */

  }, {
    key: "invalidReason",
    get: function get() {
      return this.invalid ? this.invalid.reason : null;
    }
    /**
     * Returns an explanation of why this Duration became invalid, or null if the Duration is valid
     * @type {string}
     */

  }, {
    key: "invalidExplanation",
    get: function get() {
      return this.invalid ? this.invalid.explanation : null;
    }
  }]);

  return Duration;
}();
function friendlyDuration(durationish) {
  if (isNumber(durationish)) {
    return Duration.fromMillis(durationish);
  } else if (Duration.isDuration(durationish)) {
    return durationish;
  } else if (typeof durationish === "object") {
    return Duration.fromObject(durationish);
  } else {
    throw new InvalidArgumentError("Unknown duration argument " + durationish + " of type " + typeof durationish);
  }
}

var INVALID$1 = "Invalid Interval"; // checks if the start is equal to or before the end

function validateStartEnd(start, end) {
  if (!start || !start.isValid) {
    return Interval.invalid("missing or invalid start");
  } else if (!end || !end.isValid) {
    return Interval.invalid("missing or invalid end");
  } else if (end < start) {
    return Interval.invalid("end before start", "The end of an interval must be after its start, but you had start=" + start.toISO() + " and end=" + end.toISO());
  } else {
    return null;
  }
}
/**
 * An Interval object represents a half-open interval of time, where each endpoint is a {@link DateTime}. Conceptually, it's a container for those two endpoints, accompanied by methods for creating, parsing, interrogating, comparing, transforming, and formatting them.
 *
 * Here is a brief overview of the most commonly used methods and getters in Interval:
 *
 * * **Creation** To create an Interval, use {@link fromDateTimes}, {@link after}, {@link before}, or {@link fromISO}.
 * * **Accessors** Use {@link start} and {@link end} to get the start and end.
 * * **Interrogation** To analyze the Interval, use {@link count}, {@link length}, {@link hasSame}, {@link contains}, {@link isAfter}, or {@link isBefore}.
 * * **Transformation** To create other Intervals out of this one, use {@link set}, {@link splitAt}, {@link splitBy}, {@link divideEqually}, {@link merge}, {@link xor}, {@link union}, {@link intersection}, or {@link difference}.
 * * **Comparison** To compare this Interval to another one, use {@link equals}, {@link overlaps}, {@link abutsStart}, {@link abutsEnd}, {@link engulfs}.
 * * **Output** To convert the Interval into other representations, see {@link toString}, {@link toISO}, {@link toISODate}, {@link toISOTime}, {@link toFormat}, and {@link toDuration}.
 */


var Interval = /*#__PURE__*/function () {
  /**
   * @private
   */
  function Interval(config) {
    /**
     * @access private
     */
    this.s = config.start;
    /**
     * @access private
     */

    this.e = config.end;
    /**
     * @access private
     */

    this.invalid = config.invalid || null;
    /**
     * @access private
     */

    this.isLuxonInterval = true;
  }
  /**
   * Create an invalid Interval.
   * @param {string} reason - simple string of why this Interval is invalid. Should not contain parameters or anything else data-dependent
   * @param {string} [explanation=null] - longer explanation, may include parameters and other useful debugging information
   * @return {Interval}
   */


  Interval.invalid = function invalid(reason, explanation) {
    if (explanation === void 0) {
      explanation = null;
    }

    if (!reason) {
      throw new InvalidArgumentError("need to specify a reason the Interval is invalid");
    }

    var invalid = reason instanceof Invalid ? reason : new Invalid(reason, explanation);

    if (Settings.throwOnInvalid) {
      throw new InvalidIntervalError(invalid);
    } else {
      return new Interval({
        invalid: invalid
      });
    }
  }
  /**
   * Create an Interval from a start DateTime and an end DateTime. Inclusive of the start but not the end.
   * @param {DateTime|Date|Object} start
   * @param {DateTime|Date|Object} end
   * @return {Interval}
   */
  ;

  Interval.fromDateTimes = function fromDateTimes(start, end) {
    var builtStart = friendlyDateTime(start),
        builtEnd = friendlyDateTime(end);
    var validateError = validateStartEnd(builtStart, builtEnd);

    if (validateError == null) {
      return new Interval({
        start: builtStart,
        end: builtEnd
      });
    } else {
      return validateError;
    }
  }
  /**
   * Create an Interval from a start DateTime and a Duration to extend to.
   * @param {DateTime|Date|Object} start
   * @param {Duration|Object|number} duration - the length of the Interval.
   * @return {Interval}
   */
  ;

  Interval.after = function after(start, duration) {
    var dur = friendlyDuration(duration),
        dt = friendlyDateTime(start);
    return Interval.fromDateTimes(dt, dt.plus(dur));
  }
  /**
   * Create an Interval from an end DateTime and a Duration to extend backwards to.
   * @param {DateTime|Date|Object} end
   * @param {Duration|Object|number} duration - the length of the Interval.
   * @return {Interval}
   */
  ;

  Interval.before = function before(end, duration) {
    var dur = friendlyDuration(duration),
        dt = friendlyDateTime(end);
    return Interval.fromDateTimes(dt.minus(dur), dt);
  }
  /**
   * Create an Interval from an ISO 8601 string.
   * Accepts `<start>/<end>`, `<start>/<duration>`, and `<duration>/<end>` formats.
   * @param {string} text - the ISO string to parse
   * @param {Object} [opts] - options to pass {@link DateTime.fromISO} and optionally {@link Duration.fromISO}
   * @see https://en.wikipedia.org/wiki/ISO_8601#Time_intervals
   * @return {Interval}
   */
  ;

  Interval.fromISO = function fromISO(text, opts) {
    var _split = (text || "").split("/", 2),
        s = _split[0],
        e = _split[1];

    if (s && e) {
      var start, startIsValid;

      try {
        start = DateTime.fromISO(s, opts);
        startIsValid = start.isValid;
      } catch (e) {
        startIsValid = false;
      }

      var end, endIsValid;

      try {
        end = DateTime.fromISO(e, opts);
        endIsValid = end.isValid;
      } catch (e) {
        endIsValid = false;
      }

      if (startIsValid && endIsValid) {
        return Interval.fromDateTimes(start, end);
      }

      if (startIsValid) {
        var dur = Duration.fromISO(e, opts);

        if (dur.isValid) {
          return Interval.after(start, dur);
        }
      } else if (endIsValid) {
        var _dur = Duration.fromISO(s, opts);

        if (_dur.isValid) {
          return Interval.before(end, _dur);
        }
      }
    }

    return Interval.invalid("unparsable", "the input \"" + text + "\" can't be parsed as ISO 8601");
  }
  /**
   * Check if an object is an Interval. Works across context boundaries
   * @param {object} o
   * @return {boolean}
   */
  ;

  Interval.isInterval = function isInterval(o) {
    return o && o.isLuxonInterval || false;
  }
  /**
   * Returns the start of the Interval
   * @type {DateTime}
   */
  ;

  var _proto = Interval.prototype;

  /**
   * Returns the length of the Interval in the specified unit.
   * @param {string} unit - the unit (such as 'hours' or 'days') to return the length in.
   * @return {number}
   */
  _proto.length = function length(unit) {
    if (unit === void 0) {
      unit = "milliseconds";
    }

    return this.isValid ? this.toDuration.apply(this, [unit]).get(unit) : NaN;
  }
  /**
   * Returns the count of minutes, hours, days, months, or years included in the Interval, even in part.
   * Unlike {@link length} this counts sections of the calendar, not periods of time, e.g. specifying 'day'
   * asks 'what dates are included in this interval?', not 'how many days long is this interval?'
   * @param {string} [unit='milliseconds'] - the unit of time to count.
   * @return {number}
   */
  ;

  _proto.count = function count(unit) {
    if (unit === void 0) {
      unit = "milliseconds";
    }

    if (!this.isValid) return NaN;
    var start = this.start.startOf(unit),
        end = this.end.startOf(unit);
    return Math.floor(end.diff(start, unit).get(unit)) + 1;
  }
  /**
   * Returns whether this Interval's start and end are both in the same unit of time
   * @param {string} unit - the unit of time to check sameness on
   * @return {boolean}
   */
  ;

  _proto.hasSame = function hasSame(unit) {
    return this.isValid ? this.isEmpty() || this.e.minus(1).hasSame(this.s, unit) : false;
  }
  /**
   * Return whether this Interval has the same start and end DateTimes.
   * @return {boolean}
   */
  ;

  _proto.isEmpty = function isEmpty() {
    return this.s.valueOf() === this.e.valueOf();
  }
  /**
   * Return whether this Interval's start is after the specified DateTime.
   * @param {DateTime} dateTime
   * @return {boolean}
   */
  ;

  _proto.isAfter = function isAfter(dateTime) {
    if (!this.isValid) return false;
    return this.s > dateTime;
  }
  /**
   * Return whether this Interval's end is before the specified DateTime.
   * @param {DateTime} dateTime
   * @return {boolean}
   */
  ;

  _proto.isBefore = function isBefore(dateTime) {
    if (!this.isValid) return false;
    return this.e <= dateTime;
  }
  /**
   * Return whether this Interval contains the specified DateTime.
   * @param {DateTime} dateTime
   * @return {boolean}
   */
  ;

  _proto.contains = function contains(dateTime) {
    if (!this.isValid) return false;
    return this.s <= dateTime && this.e > dateTime;
  }
  /**
   * "Sets" the start and/or end dates. Returns a newly-constructed Interval.
   * @param {Object} values - the values to set
   * @param {DateTime} values.start - the starting DateTime
   * @param {DateTime} values.end - the ending DateTime
   * @return {Interval}
   */
  ;

  _proto.set = function set(_temp) {
    var _ref = _temp === void 0 ? {} : _temp,
        start = _ref.start,
        end = _ref.end;

    if (!this.isValid) return this;
    return Interval.fromDateTimes(start || this.s, end || this.e);
  }
  /**
   * Split this Interval at each of the specified DateTimes
   * @param {...[DateTime]} dateTimes - the unit of time to count.
   * @return {[Interval]}
   */
  ;

  _proto.splitAt = function splitAt() {
    var _this = this;

    if (!this.isValid) return [];

    for (var _len = arguments.length, dateTimes = new Array(_len), _key = 0; _key < _len; _key++) {
      dateTimes[_key] = arguments[_key];
    }

    var sorted = dateTimes.map(friendlyDateTime).filter(function (d) {
      return _this.contains(d);
    }).sort(),
        results = [];
    var s = this.s,
        i = 0;

    while (s < this.e) {
      var added = sorted[i] || this.e,
          next = +added > +this.e ? this.e : added;
      results.push(Interval.fromDateTimes(s, next));
      s = next;
      i += 1;
    }

    return results;
  }
  /**
   * Split this Interval into smaller Intervals, each of the specified length.
   * Left over time is grouped into a smaller interval
   * @param {Duration|Object|number} duration - The length of each resulting interval.
   * @return {[Interval]}
   */
  ;

  _proto.splitBy = function splitBy(duration) {
    var dur = friendlyDuration(duration);

    if (!this.isValid || !dur.isValid || dur.as("milliseconds") === 0) {
      return [];
    }

    var s = this.s,
        idx = 1,
        next;
    var results = [];

    while (s < this.e) {
      var added = this.start.plus(dur.mapUnits(function (x) {
        return x * idx;
      }));
      next = +added > +this.e ? this.e : added;
      results.push(Interval.fromDateTimes(s, next));
      s = next;
      idx += 1;
    }

    return results;
  }
  /**
   * Split this Interval into the specified number of smaller intervals.
   * @param {number} numberOfParts - The number of Intervals to divide the Interval into.
   * @return {[Interval]}
   */
  ;

  _proto.divideEqually = function divideEqually(numberOfParts) {
    if (!this.isValid) return [];
    return this.splitBy(this.length() / numberOfParts).slice(0, numberOfParts);
  }
  /**
   * Return whether this Interval overlaps with the specified Interval
   * @param {Interval} other
   * @return {boolean}
   */
  ;

  _proto.overlaps = function overlaps(other) {
    return this.e > other.s && this.s < other.e;
  }
  /**
   * Return whether this Interval's end is adjacent to the specified Interval's start.
   * @param {Interval} other
   * @return {boolean}
   */
  ;

  _proto.abutsStart = function abutsStart(other) {
    if (!this.isValid) return false;
    return +this.e === +other.s;
  }
  /**
   * Return whether this Interval's start is adjacent to the specified Interval's end.
   * @param {Interval} other
   * @return {boolean}
   */
  ;

  _proto.abutsEnd = function abutsEnd(other) {
    if (!this.isValid) return false;
    return +other.e === +this.s;
  }
  /**
   * Return whether this Interval engulfs the start and end of the specified Interval.
   * @param {Interval} other
   * @return {boolean}
   */
  ;

  _proto.engulfs = function engulfs(other) {
    if (!this.isValid) return false;
    return this.s <= other.s && this.e >= other.e;
  }
  /**
   * Return whether this Interval has the same start and end as the specified Interval.
   * @param {Interval} other
   * @return {boolean}
   */
  ;

  _proto.equals = function equals(other) {
    if (!this.isValid || !other.isValid) {
      return false;
    }

    return this.s.equals(other.s) && this.e.equals(other.e);
  }
  /**
   * Return an Interval representing the intersection of this Interval and the specified Interval.
   * Specifically, the resulting Interval has the maximum start time and the minimum end time of the two Intervals.
   * Returns null if the intersection is empty, meaning, the intervals don't intersect.
   * @param {Interval} other
   * @return {Interval}
   */
  ;

  _proto.intersection = function intersection(other) {
    if (!this.isValid) return this;
    var s = this.s > other.s ? this.s : other.s,
        e = this.e < other.e ? this.e : other.e;

    if (s >= e) {
      return null;
    } else {
      return Interval.fromDateTimes(s, e);
    }
  }
  /**
   * Return an Interval representing the union of this Interval and the specified Interval.
   * Specifically, the resulting Interval has the minimum start time and the maximum end time of the two Intervals.
   * @param {Interval} other
   * @return {Interval}
   */
  ;

  _proto.union = function union(other) {
    if (!this.isValid) return this;
    var s = this.s < other.s ? this.s : other.s,
        e = this.e > other.e ? this.e : other.e;
    return Interval.fromDateTimes(s, e);
  }
  /**
   * Merge an array of Intervals into a equivalent minimal set of Intervals.
   * Combines overlapping and adjacent Intervals.
   * @param {[Interval]} intervals
   * @return {[Interval]}
   */
  ;

  Interval.merge = function merge(intervals) {
    var _intervals$sort$reduc = intervals.sort(function (a, b) {
      return a.s - b.s;
    }).reduce(function (_ref2, item) {
      var sofar = _ref2[0],
          current = _ref2[1];

      if (!current) {
        return [sofar, item];
      } else if (current.overlaps(item) || current.abutsStart(item)) {
        return [sofar, current.union(item)];
      } else {
        return [sofar.concat([current]), item];
      }
    }, [[], null]),
        found = _intervals$sort$reduc[0],
        final = _intervals$sort$reduc[1];

    if (final) {
      found.push(final);
    }

    return found;
  }
  /**
   * Return an array of Intervals representing the spans of time that only appear in one of the specified Intervals.
   * @param {[Interval]} intervals
   * @return {[Interval]}
   */
  ;

  Interval.xor = function xor(intervals) {
    var _Array$prototype;

    var start = null,
        currentCount = 0;

    var results = [],
        ends = intervals.map(function (i) {
      return [{
        time: i.s,
        type: "s"
      }, {
        time: i.e,
        type: "e"
      }];
    }),
        flattened = (_Array$prototype = Array.prototype).concat.apply(_Array$prototype, ends),
        arr = flattened.sort(function (a, b) {
      return a.time - b.time;
    });

    for (var _iterator = _createForOfIteratorHelperLoose(arr), _step; !(_step = _iterator()).done;) {
      var i = _step.value;
      currentCount += i.type === "s" ? 1 : -1;

      if (currentCount === 1) {
        start = i.time;
      } else {
        if (start && +start !== +i.time) {
          results.push(Interval.fromDateTimes(start, i.time));
        }

        start = null;
      }
    }

    return Interval.merge(results);
  }
  /**
   * Return an Interval representing the span of time in this Interval that doesn't overlap with any of the specified Intervals.
   * @param {...Interval} intervals
   * @return {[Interval]}
   */
  ;

  _proto.difference = function difference() {
    var _this2 = this;

    for (var _len2 = arguments.length, intervals = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      intervals[_key2] = arguments[_key2];
    }

    return Interval.xor([this].concat(intervals)).map(function (i) {
      return _this2.intersection(i);
    }).filter(function (i) {
      return i && !i.isEmpty();
    });
  }
  /**
   * Returns a string representation of this Interval appropriate for debugging.
   * @return {string}
   */
  ;

  _proto.toString = function toString() {
    if (!this.isValid) return INVALID$1;
    return "[" + this.s.toISO() + " \u2013 " + this.e.toISO() + ")";
  }
  /**
   * Returns an ISO 8601-compliant string representation of this Interval.
   * @see https://en.wikipedia.org/wiki/ISO_8601#Time_intervals
   * @param {Object} opts - The same options as {@link DateTime.toISO}
   * @return {string}
   */
  ;

  _proto.toISO = function toISO(opts) {
    if (!this.isValid) return INVALID$1;
    return this.s.toISO(opts) + "/" + this.e.toISO(opts);
  }
  /**
   * Returns an ISO 8601-compliant string representation of date of this Interval.
   * The time components are ignored.
   * @see https://en.wikipedia.org/wiki/ISO_8601#Time_intervals
   * @return {string}
   */
  ;

  _proto.toISODate = function toISODate() {
    if (!this.isValid) return INVALID$1;
    return this.s.toISODate() + "/" + this.e.toISODate();
  }
  /**
   * Returns an ISO 8601-compliant string representation of time of this Interval.
   * The date components are ignored.
   * @see https://en.wikipedia.org/wiki/ISO_8601#Time_intervals
   * @param {Object} opts - The same options as {@link DateTime.toISO}
   * @return {string}
   */
  ;

  _proto.toISOTime = function toISOTime(opts) {
    if (!this.isValid) return INVALID$1;
    return this.s.toISOTime(opts) + "/" + this.e.toISOTime(opts);
  }
  /**
   * Returns a string representation of this Interval formatted according to the specified format string.
   * @param {string} dateFormat - the format string. This string formats the start and end time. See {@link DateTime.toFormat} for details.
   * @param {Object} opts - options
   * @param {string} [opts.separator =  ' – '] - a separator to place between the start and end representations
   * @return {string}
   */
  ;

  _proto.toFormat = function toFormat(dateFormat, _temp2) {
    var _ref3 = _temp2 === void 0 ? {} : _temp2,
        _ref3$separator = _ref3.separator,
        separator = _ref3$separator === void 0 ? " – " : _ref3$separator;

    if (!this.isValid) return INVALID$1;
    return "" + this.s.toFormat(dateFormat) + separator + this.e.toFormat(dateFormat);
  }
  /**
   * Return a Duration representing the time spanned by this interval.
   * @param {string|string[]} [unit=['milliseconds']] - the unit or units (such as 'hours' or 'days') to include in the duration.
   * @param {Object} opts - options that affect the creation of the Duration
   * @param {string} [opts.conversionAccuracy='casual'] - the conversion system to use
   * @example Interval.fromDateTimes(dt1, dt2).toDuration().toObject() //=> { milliseconds: 88489257 }
   * @example Interval.fromDateTimes(dt1, dt2).toDuration('days').toObject() //=> { days: 1.0241812152777778 }
   * @example Interval.fromDateTimes(dt1, dt2).toDuration(['hours', 'minutes']).toObject() //=> { hours: 24, minutes: 34.82095 }
   * @example Interval.fromDateTimes(dt1, dt2).toDuration(['hours', 'minutes', 'seconds']).toObject() //=> { hours: 24, minutes: 34, seconds: 49.257 }
   * @example Interval.fromDateTimes(dt1, dt2).toDuration('seconds').toObject() //=> { seconds: 88489.257 }
   * @return {Duration}
   */
  ;

  _proto.toDuration = function toDuration(unit, opts) {
    if (!this.isValid) {
      return Duration.invalid(this.invalidReason);
    }

    return this.e.diff(this.s, unit, opts);
  }
  /**
   * Run mapFn on the interval start and end, returning a new Interval from the resulting DateTimes
   * @param {function} mapFn
   * @return {Interval}
   * @example Interval.fromDateTimes(dt1, dt2).mapEndpoints(endpoint => endpoint.toUTC())
   * @example Interval.fromDateTimes(dt1, dt2).mapEndpoints(endpoint => endpoint.plus({ hours: 2 }))
   */
  ;

  _proto.mapEndpoints = function mapEndpoints(mapFn) {
    return Interval.fromDateTimes(mapFn(this.s), mapFn(this.e));
  };

  _createClass(Interval, [{
    key: "start",
    get: function get() {
      return this.isValid ? this.s : null;
    }
    /**
     * Returns the end of the Interval
     * @type {DateTime}
     */

  }, {
    key: "end",
    get: function get() {
      return this.isValid ? this.e : null;
    }
    /**
     * Returns whether this Interval's end is at least its start, meaning that the Interval isn't 'backwards'.
     * @type {boolean}
     */

  }, {
    key: "isValid",
    get: function get() {
      return this.invalidReason === null;
    }
    /**
     * Returns an error code if this Interval is invalid, or null if the Interval is valid
     * @type {string}
     */

  }, {
    key: "invalidReason",
    get: function get() {
      return this.invalid ? this.invalid.reason : null;
    }
    /**
     * Returns an explanation of why this Interval became invalid, or null if the Interval is valid
     * @type {string}
     */

  }, {
    key: "invalidExplanation",
    get: function get() {
      return this.invalid ? this.invalid.explanation : null;
    }
  }]);

  return Interval;
}();

/**
 * The Info class contains static methods for retrieving general time and date related data. For example, it has methods for finding out if a time zone has a DST, for listing the months in any supported locale, and for discovering which of Luxon features are available in the current environment.
 */

var Info = /*#__PURE__*/function () {
  function Info() {}

  /**
   * Return whether the specified zone contains a DST.
   * @param {string|Zone} [zone='local'] - Zone to check. Defaults to the environment's local zone.
   * @return {boolean}
   */
  Info.hasDST = function hasDST(zone) {
    if (zone === void 0) {
      zone = Settings.defaultZone;
    }

    var proto = DateTime.now().setZone(zone).set({
      month: 12
    });
    return !zone.universal && proto.offset !== proto.set({
      month: 6
    }).offset;
  }
  /**
   * Return whether the specified zone is a valid IANA specifier.
   * @param {string} zone - Zone to check
   * @return {boolean}
   */
  ;

  Info.isValidIANAZone = function isValidIANAZone(zone) {
    return IANAZone.isValidSpecifier(zone) && IANAZone.isValidZone(zone);
  }
  /**
   * Converts the input into a {@link Zone} instance.
   *
   * * If `input` is already a Zone instance, it is returned unchanged.
   * * If `input` is a string containing a valid time zone name, a Zone instance
   *   with that name is returned.
   * * If `input` is a string that doesn't refer to a known time zone, a Zone
   *   instance with {@link Zone.isValid} == false is returned.
   * * If `input is a number, a Zone instance with the specified fixed offset
   *   in minutes is returned.
   * * If `input` is `null` or `undefined`, the default zone is returned.
   * @param {string|Zone|number} [input] - the value to be converted
   * @return {Zone}
   */
  ;

  Info.normalizeZone = function normalizeZone$1(input) {
    return normalizeZone(input, Settings.defaultZone);
  }
  /**
   * Return an array of standalone month names.
   * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
   * @param {string} [length='long'] - the length of the month representation, such as "numeric", "2-digit", "narrow", "short", "long"
   * @param {Object} opts - options
   * @param {string} [opts.locale] - the locale code
   * @param {string} [opts.numberingSystem=null] - the numbering system
   * @param {string} [opts.locObj=null] - an existing locale object to use
   * @param {string} [opts.outputCalendar='gregory'] - the calendar
   * @example Info.months()[0] //=> 'January'
   * @example Info.months('short')[0] //=> 'Jan'
   * @example Info.months('numeric')[0] //=> '1'
   * @example Info.months('short', { locale: 'fr-CA' } )[0] //=> 'janv.'
   * @example Info.months('numeric', { locale: 'ar' })[0] //=> '١'
   * @example Info.months('long', { outputCalendar: 'islamic' })[0] //=> 'Rabiʻ I'
   * @return {[string]}
   */
  ;

  Info.months = function months(length, _temp) {
    if (length === void 0) {
      length = "long";
    }

    var _ref = _temp === void 0 ? {} : _temp,
        _ref$locale = _ref.locale,
        locale = _ref$locale === void 0 ? null : _ref$locale,
        _ref$numberingSystem = _ref.numberingSystem,
        numberingSystem = _ref$numberingSystem === void 0 ? null : _ref$numberingSystem,
        _ref$locObj = _ref.locObj,
        locObj = _ref$locObj === void 0 ? null : _ref$locObj,
        _ref$outputCalendar = _ref.outputCalendar,
        outputCalendar = _ref$outputCalendar === void 0 ? "gregory" : _ref$outputCalendar;

    return (locObj || Locale.create(locale, numberingSystem, outputCalendar)).months(length);
  }
  /**
   * Return an array of format month names.
   * Format months differ from standalone months in that they're meant to appear next to the day of the month. In some languages, that
   * changes the string.
   * See {@link months}
   * @param {string} [length='long'] - the length of the month representation, such as "numeric", "2-digit", "narrow", "short", "long"
   * @param {Object} opts - options
   * @param {string} [opts.locale] - the locale code
   * @param {string} [opts.numberingSystem=null] - the numbering system
   * @param {string} [opts.locObj=null] - an existing locale object to use
   * @param {string} [opts.outputCalendar='gregory'] - the calendar
   * @return {[string]}
   */
  ;

  Info.monthsFormat = function monthsFormat(length, _temp2) {
    if (length === void 0) {
      length = "long";
    }

    var _ref2 = _temp2 === void 0 ? {} : _temp2,
        _ref2$locale = _ref2.locale,
        locale = _ref2$locale === void 0 ? null : _ref2$locale,
        _ref2$numberingSystem = _ref2.numberingSystem,
        numberingSystem = _ref2$numberingSystem === void 0 ? null : _ref2$numberingSystem,
        _ref2$locObj = _ref2.locObj,
        locObj = _ref2$locObj === void 0 ? null : _ref2$locObj,
        _ref2$outputCalendar = _ref2.outputCalendar,
        outputCalendar = _ref2$outputCalendar === void 0 ? "gregory" : _ref2$outputCalendar;

    return (locObj || Locale.create(locale, numberingSystem, outputCalendar)).months(length, true);
  }
  /**
   * Return an array of standalone week names.
   * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
   * @param {string} [length='long'] - the length of the weekday representation, such as "narrow", "short", "long".
   * @param {Object} opts - options
   * @param {string} [opts.locale] - the locale code
   * @param {string} [opts.numberingSystem=null] - the numbering system
   * @param {string} [opts.locObj=null] - an existing locale object to use
   * @example Info.weekdays()[0] //=> 'Monday'
   * @example Info.weekdays('short')[0] //=> 'Mon'
   * @example Info.weekdays('short', { locale: 'fr-CA' })[0] //=> 'lun.'
   * @example Info.weekdays('short', { locale: 'ar' })[0] //=> 'الاثنين'
   * @return {[string]}
   */
  ;

  Info.weekdays = function weekdays(length, _temp3) {
    if (length === void 0) {
      length = "long";
    }

    var _ref3 = _temp3 === void 0 ? {} : _temp3,
        _ref3$locale = _ref3.locale,
        locale = _ref3$locale === void 0 ? null : _ref3$locale,
        _ref3$numberingSystem = _ref3.numberingSystem,
        numberingSystem = _ref3$numberingSystem === void 0 ? null : _ref3$numberingSystem,
        _ref3$locObj = _ref3.locObj,
        locObj = _ref3$locObj === void 0 ? null : _ref3$locObj;

    return (locObj || Locale.create(locale, numberingSystem, null)).weekdays(length);
  }
  /**
   * Return an array of format week names.
   * Format weekdays differ from standalone weekdays in that they're meant to appear next to more date information. In some languages, that
   * changes the string.
   * See {@link weekdays}
   * @param {string} [length='long'] - the length of the weekday representation, such as "narrow", "short", "long".
   * @param {Object} opts - options
   * @param {string} [opts.locale=null] - the locale code
   * @param {string} [opts.numberingSystem=null] - the numbering system
   * @param {string} [opts.locObj=null] - an existing locale object to use
   * @return {[string]}
   */
  ;

  Info.weekdaysFormat = function weekdaysFormat(length, _temp4) {
    if (length === void 0) {
      length = "long";
    }

    var _ref4 = _temp4 === void 0 ? {} : _temp4,
        _ref4$locale = _ref4.locale,
        locale = _ref4$locale === void 0 ? null : _ref4$locale,
        _ref4$numberingSystem = _ref4.numberingSystem,
        numberingSystem = _ref4$numberingSystem === void 0 ? null : _ref4$numberingSystem,
        _ref4$locObj = _ref4.locObj,
        locObj = _ref4$locObj === void 0 ? null : _ref4$locObj;

    return (locObj || Locale.create(locale, numberingSystem, null)).weekdays(length, true);
  }
  /**
   * Return an array of meridiems.
   * @param {Object} opts - options
   * @param {string} [opts.locale] - the locale code
   * @example Info.meridiems() //=> [ 'AM', 'PM' ]
   * @example Info.meridiems({ locale: 'my' }) //=> [ 'နံနက်', 'ညနေ' ]
   * @return {[string]}
   */
  ;

  Info.meridiems = function meridiems(_temp5) {
    var _ref5 = _temp5 === void 0 ? {} : _temp5,
        _ref5$locale = _ref5.locale,
        locale = _ref5$locale === void 0 ? null : _ref5$locale;

    return Locale.create(locale).meridiems();
  }
  /**
   * Return an array of eras, such as ['BC', 'AD']. The locale can be specified, but the calendar system is always Gregorian.
   * @param {string} [length='short'] - the length of the era representation, such as "short" or "long".
   * @param {Object} opts - options
   * @param {string} [opts.locale] - the locale code
   * @example Info.eras() //=> [ 'BC', 'AD' ]
   * @example Info.eras('long') //=> [ 'Before Christ', 'Anno Domini' ]
   * @example Info.eras('long', { locale: 'fr' }) //=> [ 'avant Jésus-Christ', 'après Jésus-Christ' ]
   * @return {[string]}
   */
  ;

  Info.eras = function eras(length, _temp6) {
    if (length === void 0) {
      length = "short";
    }

    var _ref6 = _temp6 === void 0 ? {} : _temp6,
        _ref6$locale = _ref6.locale,
        locale = _ref6$locale === void 0 ? null : _ref6$locale;

    return Locale.create(locale, null, "gregory").eras(length);
  }
  /**
   * Return the set of available features in this environment.
   * Some features of Luxon are not available in all environments. For example, on older browsers, timezone support is not available. Use this function to figure out if that's the case.
   * Keys:
   * * `zones`: whether this environment supports IANA timezones
   * * `intlTokens`: whether this environment supports internationalized token-based formatting/parsing
   * * `intl`: whether this environment supports general internationalization
   * * `relative`: whether this environment supports relative time formatting
   * @example Info.features() //=> { intl: true, intlTokens: false, zones: true, relative: false }
   * @return {Object}
   */
  ;

  Info.features = function features() {
    var intl = false,
        intlTokens = false,
        zones = false,
        relative = false;

    if (hasIntl()) {
      intl = true;
      intlTokens = hasFormatToParts();
      relative = hasRelative();

      try {
        zones = new Intl.DateTimeFormat("en", {
          timeZone: "America/New_York"
        }).resolvedOptions().timeZone === "America/New_York";
      } catch (e) {
        zones = false;
      }
    }

    return {
      intl: intl,
      intlTokens: intlTokens,
      zones: zones,
      relative: relative
    };
  };

  return Info;
}();

function dayDiff(earlier, later) {
  var utcDayStart = function utcDayStart(dt) {
    return dt.toUTC(0, {
      keepLocalTime: true
    }).startOf("day").valueOf();
  },
      ms = utcDayStart(later) - utcDayStart(earlier);

  return Math.floor(Duration.fromMillis(ms).as("days"));
}

function highOrderDiffs(cursor, later, units) {
  var differs = [["years", function (a, b) {
    return b.year - a.year;
  }], ["quarters", function (a, b) {
    return b.quarter - a.quarter;
  }], ["months", function (a, b) {
    return b.month - a.month + (b.year - a.year) * 12;
  }], ["weeks", function (a, b) {
    var days = dayDiff(a, b);
    return (days - days % 7) / 7;
  }], ["days", dayDiff]];
  var results = {};
  var lowestOrder, highWater;

  for (var _i = 0, _differs = differs; _i < _differs.length; _i++) {
    var _differs$_i = _differs[_i],
        unit = _differs$_i[0],
        differ = _differs$_i[1];

    if (units.indexOf(unit) >= 0) {
      var _cursor$plus;

      lowestOrder = unit;
      var delta = differ(cursor, later);
      highWater = cursor.plus((_cursor$plus = {}, _cursor$plus[unit] = delta, _cursor$plus));

      if (highWater > later) {
        var _cursor$plus2;

        cursor = cursor.plus((_cursor$plus2 = {}, _cursor$plus2[unit] = delta - 1, _cursor$plus2));
        delta -= 1;
      } else {
        cursor = highWater;
      }

      results[unit] = delta;
    }
  }

  return [cursor, results, highWater, lowestOrder];
}

function _diff (earlier, later, units, opts) {
  var _highOrderDiffs = highOrderDiffs(earlier, later, units),
      cursor = _highOrderDiffs[0],
      results = _highOrderDiffs[1],
      highWater = _highOrderDiffs[2],
      lowestOrder = _highOrderDiffs[3];

  var remainingMillis = later - cursor;
  var lowerOrderUnits = units.filter(function (u) {
    return ["hours", "minutes", "seconds", "milliseconds"].indexOf(u) >= 0;
  });

  if (lowerOrderUnits.length === 0) {
    if (highWater < later) {
      var _cursor$plus3;

      highWater = cursor.plus((_cursor$plus3 = {}, _cursor$plus3[lowestOrder] = 1, _cursor$plus3));
    }

    if (highWater !== cursor) {
      results[lowestOrder] = (results[lowestOrder] || 0) + remainingMillis / (highWater - cursor);
    }
  }

  var duration = Duration.fromObject(Object.assign(results, opts));

  if (lowerOrderUnits.length > 0) {
    var _Duration$fromMillis;

    return (_Duration$fromMillis = Duration.fromMillis(remainingMillis, opts)).shiftTo.apply(_Duration$fromMillis, lowerOrderUnits).plus(duration);
  } else {
    return duration;
  }
}

var numberingSystems = {
  arab: "[\u0660-\u0669]",
  arabext: "[\u06F0-\u06F9]",
  bali: "[\u1B50-\u1B59]",
  beng: "[\u09E6-\u09EF]",
  deva: "[\u0966-\u096F]",
  fullwide: "[\uFF10-\uFF19]",
  gujr: "[\u0AE6-\u0AEF]",
  hanidec: "[〇|一|二|三|四|五|六|七|八|九]",
  khmr: "[\u17E0-\u17E9]",
  knda: "[\u0CE6-\u0CEF]",
  laoo: "[\u0ED0-\u0ED9]",
  limb: "[\u1946-\u194F]",
  mlym: "[\u0D66-\u0D6F]",
  mong: "[\u1810-\u1819]",
  mymr: "[\u1040-\u1049]",
  orya: "[\u0B66-\u0B6F]",
  tamldec: "[\u0BE6-\u0BEF]",
  telu: "[\u0C66-\u0C6F]",
  thai: "[\u0E50-\u0E59]",
  tibt: "[\u0F20-\u0F29]",
  latn: "\\d"
};
var numberingSystemsUTF16 = {
  arab: [1632, 1641],
  arabext: [1776, 1785],
  bali: [6992, 7001],
  beng: [2534, 2543],
  deva: [2406, 2415],
  fullwide: [65296, 65303],
  gujr: [2790, 2799],
  khmr: [6112, 6121],
  knda: [3302, 3311],
  laoo: [3792, 3801],
  limb: [6470, 6479],
  mlym: [3430, 3439],
  mong: [6160, 6169],
  mymr: [4160, 4169],
  orya: [2918, 2927],
  tamldec: [3046, 3055],
  telu: [3174, 3183],
  thai: [3664, 3673],
  tibt: [3872, 3881]
}; // eslint-disable-next-line

var hanidecChars = numberingSystems.hanidec.replace(/[\[|\]]/g, "").split("");
function parseDigits(str) {
  var value = parseInt(str, 10);

  if (isNaN(value)) {
    value = "";

    for (var i = 0; i < str.length; i++) {
      var code = str.charCodeAt(i);

      if (str[i].search(numberingSystems.hanidec) !== -1) {
        value += hanidecChars.indexOf(str[i]);
      } else {
        for (var key in numberingSystemsUTF16) {
          var _numberingSystemsUTF = numberingSystemsUTF16[key],
              min = _numberingSystemsUTF[0],
              max = _numberingSystemsUTF[1];

          if (code >= min && code <= max) {
            value += code - min;
          }
        }
      }
    }

    return parseInt(value, 10);
  } else {
    return value;
  }
}
function digitRegex(_ref, append) {
  var numberingSystem = _ref.numberingSystem;

  if (append === void 0) {
    append = "";
  }

  return new RegExp("" + numberingSystems[numberingSystem || "latn"] + append);
}

var MISSING_FTP = "missing Intl.DateTimeFormat.formatToParts support";

function intUnit(regex, post) {
  if (post === void 0) {
    post = function post(i) {
      return i;
    };
  }

  return {
    regex: regex,
    deser: function deser(_ref) {
      var s = _ref[0];
      return post(parseDigits(s));
    }
  };
}

var NBSP = String.fromCharCode(160);
var spaceOrNBSP = "( |" + NBSP + ")";
var spaceOrNBSPRegExp = new RegExp(spaceOrNBSP, "g");

function fixListRegex(s) {
  // make dots optional and also make them literal
  // make space and non breakable space characters interchangeable
  return s.replace(/\./g, "\\.?").replace(spaceOrNBSPRegExp, spaceOrNBSP);
}

function stripInsensitivities(s) {
  return s.replace(/\./g, "") // ignore dots that were made optional
  .replace(spaceOrNBSPRegExp, " ") // interchange space and nbsp
  .toLowerCase();
}

function oneOf(strings, startIndex) {
  if (strings === null) {
    return null;
  } else {
    return {
      regex: RegExp(strings.map(fixListRegex).join("|")),
      deser: function deser(_ref2) {
        var s = _ref2[0];
        return strings.findIndex(function (i) {
          return stripInsensitivities(s) === stripInsensitivities(i);
        }) + startIndex;
      }
    };
  }
}

function offset(regex, groups) {
  return {
    regex: regex,
    deser: function deser(_ref3) {
      var h = _ref3[1],
          m = _ref3[2];
      return signedOffset(h, m);
    },
    groups: groups
  };
}

function simple(regex) {
  return {
    regex: regex,
    deser: function deser(_ref4) {
      var s = _ref4[0];
      return s;
    }
  };
}

function escapeToken(value) {
  // eslint-disable-next-line no-useless-escape
  return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
}

function unitForToken(token, loc) {
  var one = digitRegex(loc),
      two = digitRegex(loc, "{2}"),
      three = digitRegex(loc, "{3}"),
      four = digitRegex(loc, "{4}"),
      six = digitRegex(loc, "{6}"),
      oneOrTwo = digitRegex(loc, "{1,2}"),
      oneToThree = digitRegex(loc, "{1,3}"),
      oneToSix = digitRegex(loc, "{1,6}"),
      oneToNine = digitRegex(loc, "{1,9}"),
      twoToFour = digitRegex(loc, "{2,4}"),
      fourToSix = digitRegex(loc, "{4,6}"),
      literal = function literal(t) {
    return {
      regex: RegExp(escapeToken(t.val)),
      deser: function deser(_ref5) {
        var s = _ref5[0];
        return s;
      },
      literal: true
    };
  },
      unitate = function unitate(t) {
    if (token.literal) {
      return literal(t);
    }

    switch (t.val) {
      // era
      case "G":
        return oneOf(loc.eras("short", false), 0);

      case "GG":
        return oneOf(loc.eras("long", false), 0);
      // years

      case "y":
        return intUnit(oneToSix);

      case "yy":
        return intUnit(twoToFour, untruncateYear);

      case "yyyy":
        return intUnit(four);

      case "yyyyy":
        return intUnit(fourToSix);

      case "yyyyyy":
        return intUnit(six);
      // months

      case "M":
        return intUnit(oneOrTwo);

      case "MM":
        return intUnit(two);

      case "MMM":
        return oneOf(loc.months("short", true, false), 1);

      case "MMMM":
        return oneOf(loc.months("long", true, false), 1);

      case "L":
        return intUnit(oneOrTwo);

      case "LL":
        return intUnit(two);

      case "LLL":
        return oneOf(loc.months("short", false, false), 1);

      case "LLLL":
        return oneOf(loc.months("long", false, false), 1);
      // dates

      case "d":
        return intUnit(oneOrTwo);

      case "dd":
        return intUnit(two);
      // ordinals

      case "o":
        return intUnit(oneToThree);

      case "ooo":
        return intUnit(three);
      // time

      case "HH":
        return intUnit(two);

      case "H":
        return intUnit(oneOrTwo);

      case "hh":
        return intUnit(two);

      case "h":
        return intUnit(oneOrTwo);

      case "mm":
        return intUnit(two);

      case "m":
        return intUnit(oneOrTwo);

      case "q":
        return intUnit(oneOrTwo);

      case "qq":
        return intUnit(two);

      case "s":
        return intUnit(oneOrTwo);

      case "ss":
        return intUnit(two);

      case "S":
        return intUnit(oneToThree);

      case "SSS":
        return intUnit(three);

      case "u":
        return simple(oneToNine);
      // meridiem

      case "a":
        return oneOf(loc.meridiems(), 0);
      // weekYear (k)

      case "kkkk":
        return intUnit(four);

      case "kk":
        return intUnit(twoToFour, untruncateYear);
      // weekNumber (W)

      case "W":
        return intUnit(oneOrTwo);

      case "WW":
        return intUnit(two);
      // weekdays

      case "E":
      case "c":
        return intUnit(one);

      case "EEE":
        return oneOf(loc.weekdays("short", false, false), 1);

      case "EEEE":
        return oneOf(loc.weekdays("long", false, false), 1);

      case "ccc":
        return oneOf(loc.weekdays("short", true, false), 1);

      case "cccc":
        return oneOf(loc.weekdays("long", true, false), 1);
      // offset/zone

      case "Z":
      case "ZZ":
        return offset(new RegExp("([+-]" + oneOrTwo.source + ")(?::(" + two.source + "))?"), 2);

      case "ZZZ":
        return offset(new RegExp("([+-]" + oneOrTwo.source + ")(" + two.source + ")?"), 2);
      // we don't support ZZZZ (PST) or ZZZZZ (Pacific Standard Time) in parsing
      // because we don't have any way to figure out what they are

      case "z":
        return simple(/[a-z_+-/]{1,256}?/i);

      default:
        return literal(t);
    }
  };

  var unit = unitate(token) || {
    invalidReason: MISSING_FTP
  };
  unit.token = token;
  return unit;
}

var partTypeStyleToTokenVal = {
  year: {
    "2-digit": "yy",
    numeric: "yyyyy"
  },
  month: {
    numeric: "M",
    "2-digit": "MM",
    short: "MMM",
    long: "MMMM"
  },
  day: {
    numeric: "d",
    "2-digit": "dd"
  },
  weekday: {
    short: "EEE",
    long: "EEEE"
  },
  dayperiod: "a",
  dayPeriod: "a",
  hour: {
    numeric: "h",
    "2-digit": "hh"
  },
  minute: {
    numeric: "m",
    "2-digit": "mm"
  },
  second: {
    numeric: "s",
    "2-digit": "ss"
  }
};

function tokenForPart(part, locale, formatOpts) {
  var type = part.type,
      value = part.value;

  if (type === "literal") {
    return {
      literal: true,
      val: value
    };
  }

  var style = formatOpts[type];
  var val = partTypeStyleToTokenVal[type];

  if (typeof val === "object") {
    val = val[style];
  }

  if (val) {
    return {
      literal: false,
      val: val
    };
  }

  return undefined;
}

function buildRegex(units) {
  var re = units.map(function (u) {
    return u.regex;
  }).reduce(function (f, r) {
    return f + "(" + r.source + ")";
  }, "");
  return ["^" + re + "$", units];
}

function match(input, regex, handlers) {
  var matches = input.match(regex);

  if (matches) {
    var all = {};
    var matchIndex = 1;

    for (var i in handlers) {
      if (hasOwnProperty(handlers, i)) {
        var h = handlers[i],
            groups = h.groups ? h.groups + 1 : 1;

        if (!h.literal && h.token) {
          all[h.token.val[0]] = h.deser(matches.slice(matchIndex, matchIndex + groups));
        }

        matchIndex += groups;
      }
    }

    return [matches, all];
  } else {
    return [matches, {}];
  }
}

function dateTimeFromMatches(matches) {
  var toField = function toField(token) {
    switch (token) {
      case "S":
        return "millisecond";

      case "s":
        return "second";

      case "m":
        return "minute";

      case "h":
      case "H":
        return "hour";

      case "d":
        return "day";

      case "o":
        return "ordinal";

      case "L":
      case "M":
        return "month";

      case "y":
        return "year";

      case "E":
      case "c":
        return "weekday";

      case "W":
        return "weekNumber";

      case "k":
        return "weekYear";

      case "q":
        return "quarter";

      default:
        return null;
    }
  };

  var zone;

  if (!isUndefined(matches.Z)) {
    zone = new FixedOffsetZone(matches.Z);
  } else if (!isUndefined(matches.z)) {
    zone = IANAZone.create(matches.z);
  } else {
    zone = null;
  }

  if (!isUndefined(matches.q)) {
    matches.M = (matches.q - 1) * 3 + 1;
  }

  if (!isUndefined(matches.h)) {
    if (matches.h < 12 && matches.a === 1) {
      matches.h += 12;
    } else if (matches.h === 12 && matches.a === 0) {
      matches.h = 0;
    }
  }

  if (matches.G === 0 && matches.y) {
    matches.y = -matches.y;
  }

  if (!isUndefined(matches.u)) {
    matches.S = parseMillis(matches.u);
  }

  var vals = Object.keys(matches).reduce(function (r, k) {
    var f = toField(k);

    if (f) {
      r[f] = matches[k];
    }

    return r;
  }, {});
  return [vals, zone];
}

var dummyDateTimeCache = null;

function getDummyDateTime() {
  if (!dummyDateTimeCache) {
    dummyDateTimeCache = DateTime.fromMillis(1555555555555);
  }

  return dummyDateTimeCache;
}

function maybeExpandMacroToken(token, locale) {
  if (token.literal) {
    return token;
  }

  var formatOpts = Formatter.macroTokenToFormatOpts(token.val);

  if (!formatOpts) {
    return token;
  }

  var formatter = Formatter.create(locale, formatOpts);
  var parts = formatter.formatDateTimeParts(getDummyDateTime());
  var tokens = parts.map(function (p) {
    return tokenForPart(p, locale, formatOpts);
  });

  if (tokens.includes(undefined)) {
    return token;
  }

  return tokens;
}

function expandMacroTokens(tokens, locale) {
  var _Array$prototype;

  return (_Array$prototype = Array.prototype).concat.apply(_Array$prototype, tokens.map(function (t) {
    return maybeExpandMacroToken(t, locale);
  }));
}
/**
 * @private
 */


function explainFromTokens(locale, input, format) {
  var tokens = expandMacroTokens(Formatter.parseFormat(format), locale),
      units = tokens.map(function (t) {
    return unitForToken(t, locale);
  }),
      disqualifyingUnit = units.find(function (t) {
    return t.invalidReason;
  });

  if (disqualifyingUnit) {
    return {
      input: input,
      tokens: tokens,
      invalidReason: disqualifyingUnit.invalidReason
    };
  } else {
    var _buildRegex = buildRegex(units),
        regexString = _buildRegex[0],
        handlers = _buildRegex[1],
        regex = RegExp(regexString, "i"),
        _match = match(input, regex, handlers),
        rawMatches = _match[0],
        matches = _match[1],
        _ref6 = matches ? dateTimeFromMatches(matches) : [null, null],
        result = _ref6[0],
        zone = _ref6[1];

    if (hasOwnProperty(matches, "a") && hasOwnProperty(matches, "H")) {
      throw new ConflictingSpecificationError("Can't include meridiem when specifying 24-hour format");
    }

    return {
      input: input,
      tokens: tokens,
      regex: regex,
      rawMatches: rawMatches,
      matches: matches,
      result: result,
      zone: zone
    };
  }
}
function parseFromTokens(locale, input, format) {
  var _explainFromTokens = explainFromTokens(locale, input, format),
      result = _explainFromTokens.result,
      zone = _explainFromTokens.zone,
      invalidReason = _explainFromTokens.invalidReason;

  return [result, zone, invalidReason];
}

var nonLeapLadder = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334],
    leapLadder = [0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335];

function unitOutOfRange(unit, value) {
  return new Invalid("unit out of range", "you specified " + value + " (of type " + typeof value + ") as a " + unit + ", which is invalid");
}

function dayOfWeek(year, month, day) {
  var js = new Date(Date.UTC(year, month - 1, day)).getUTCDay();
  return js === 0 ? 7 : js;
}

function computeOrdinal(year, month, day) {
  return day + (isLeapYear(year) ? leapLadder : nonLeapLadder)[month - 1];
}

function uncomputeOrdinal(year, ordinal) {
  var table = isLeapYear(year) ? leapLadder : nonLeapLadder,
      month0 = table.findIndex(function (i) {
    return i < ordinal;
  }),
      day = ordinal - table[month0];
  return {
    month: month0 + 1,
    day: day
  };
}
/**
 * @private
 */


function gregorianToWeek(gregObj) {
  var year = gregObj.year,
      month = gregObj.month,
      day = gregObj.day,
      ordinal = computeOrdinal(year, month, day),
      weekday = dayOfWeek(year, month, day);
  var weekNumber = Math.floor((ordinal - weekday + 10) / 7),
      weekYear;

  if (weekNumber < 1) {
    weekYear = year - 1;
    weekNumber = weeksInWeekYear(weekYear);
  } else if (weekNumber > weeksInWeekYear(year)) {
    weekYear = year + 1;
    weekNumber = 1;
  } else {
    weekYear = year;
  }

  return Object.assign({
    weekYear: weekYear,
    weekNumber: weekNumber,
    weekday: weekday
  }, timeObject(gregObj));
}
function weekToGregorian(weekData) {
  var weekYear = weekData.weekYear,
      weekNumber = weekData.weekNumber,
      weekday = weekData.weekday,
      weekdayOfJan4 = dayOfWeek(weekYear, 1, 4),
      yearInDays = daysInYear(weekYear);
  var ordinal = weekNumber * 7 + weekday - weekdayOfJan4 - 3,
      year;

  if (ordinal < 1) {
    year = weekYear - 1;
    ordinal += daysInYear(year);
  } else if (ordinal > yearInDays) {
    year = weekYear + 1;
    ordinal -= daysInYear(weekYear);
  } else {
    year = weekYear;
  }

  var _uncomputeOrdinal = uncomputeOrdinal(year, ordinal),
      month = _uncomputeOrdinal.month,
      day = _uncomputeOrdinal.day;

  return Object.assign({
    year: year,
    month: month,
    day: day
  }, timeObject(weekData));
}
function gregorianToOrdinal(gregData) {
  var year = gregData.year,
      month = gregData.month,
      day = gregData.day,
      ordinal = computeOrdinal(year, month, day);
  return Object.assign({
    year: year,
    ordinal: ordinal
  }, timeObject(gregData));
}
function ordinalToGregorian(ordinalData) {
  var year = ordinalData.year,
      ordinal = ordinalData.ordinal,
      _uncomputeOrdinal2 = uncomputeOrdinal(year, ordinal),
      month = _uncomputeOrdinal2.month,
      day = _uncomputeOrdinal2.day;

  return Object.assign({
    year: year,
    month: month,
    day: day
  }, timeObject(ordinalData));
}
function hasInvalidWeekData(obj) {
  var validYear = isInteger(obj.weekYear),
      validWeek = integerBetween(obj.weekNumber, 1, weeksInWeekYear(obj.weekYear)),
      validWeekday = integerBetween(obj.weekday, 1, 7);

  if (!validYear) {
    return unitOutOfRange("weekYear", obj.weekYear);
  } else if (!validWeek) {
    return unitOutOfRange("week", obj.week);
  } else if (!validWeekday) {
    return unitOutOfRange("weekday", obj.weekday);
  } else return false;
}
function hasInvalidOrdinalData(obj) {
  var validYear = isInteger(obj.year),
      validOrdinal = integerBetween(obj.ordinal, 1, daysInYear(obj.year));

  if (!validYear) {
    return unitOutOfRange("year", obj.year);
  } else if (!validOrdinal) {
    return unitOutOfRange("ordinal", obj.ordinal);
  } else return false;
}
function hasInvalidGregorianData(obj) {
  var validYear = isInteger(obj.year),
      validMonth = integerBetween(obj.month, 1, 12),
      validDay = integerBetween(obj.day, 1, daysInMonth(obj.year, obj.month));

  if (!validYear) {
    return unitOutOfRange("year", obj.year);
  } else if (!validMonth) {
    return unitOutOfRange("month", obj.month);
  } else if (!validDay) {
    return unitOutOfRange("day", obj.day);
  } else return false;
}
function hasInvalidTimeData(obj) {
  var hour = obj.hour,
      minute = obj.minute,
      second = obj.second,
      millisecond = obj.millisecond;
  var validHour = integerBetween(hour, 0, 23) || hour === 24 && minute === 0 && second === 0 && millisecond === 0,
      validMinute = integerBetween(minute, 0, 59),
      validSecond = integerBetween(second, 0, 59),
      validMillisecond = integerBetween(millisecond, 0, 999);

  if (!validHour) {
    return unitOutOfRange("hour", hour);
  } else if (!validMinute) {
    return unitOutOfRange("minute", minute);
  } else if (!validSecond) {
    return unitOutOfRange("second", second);
  } else if (!validMillisecond) {
    return unitOutOfRange("millisecond", millisecond);
  } else return false;
}

var INVALID$2 = "Invalid DateTime";
var MAX_DATE = 8.64e15;

function unsupportedZone(zone) {
  return new Invalid("unsupported zone", "the zone \"" + zone.name + "\" is not supported");
} // we cache week data on the DT object and this intermediates the cache


function possiblyCachedWeekData(dt) {
  if (dt.weekData === null) {
    dt.weekData = gregorianToWeek(dt.c);
  }

  return dt.weekData;
} // clone really means, "make a new object with these modifications". all "setters" really use this
// to create a new object while only changing some of the properties


function clone$1(inst, alts) {
  var current = {
    ts: inst.ts,
    zone: inst.zone,
    c: inst.c,
    o: inst.o,
    loc: inst.loc,
    invalid: inst.invalid
  };
  return new DateTime(Object.assign({}, current, alts, {
    old: current
  }));
} // find the right offset a given local time. The o input is our guess, which determines which
// offset we'll pick in ambiguous cases (e.g. there are two 3 AMs b/c Fallback DST)


function fixOffset(localTS, o, tz) {
  // Our UTC time is just a guess because our offset is just a guess
  var utcGuess = localTS - o * 60 * 1000; // Test whether the zone matches the offset for this ts

  var o2 = tz.offset(utcGuess); // If so, offset didn't change and we're done

  if (o === o2) {
    return [utcGuess, o];
  } // If not, change the ts by the difference in the offset


  utcGuess -= (o2 - o) * 60 * 1000; // If that gives us the local time we want, we're done

  var o3 = tz.offset(utcGuess);

  if (o2 === o3) {
    return [utcGuess, o2];
  } // If it's different, we're in a hole time. The offset has changed, but the we don't adjust the time


  return [localTS - Math.min(o2, o3) * 60 * 1000, Math.max(o2, o3)];
} // convert an epoch timestamp into a calendar object with the given offset


function tsToObj(ts, offset) {
  ts += offset * 60 * 1000;
  var d = new Date(ts);
  return {
    year: d.getUTCFullYear(),
    month: d.getUTCMonth() + 1,
    day: d.getUTCDate(),
    hour: d.getUTCHours(),
    minute: d.getUTCMinutes(),
    second: d.getUTCSeconds(),
    millisecond: d.getUTCMilliseconds()
  };
} // convert a calendar object to a epoch timestamp


function objToTS(obj, offset, zone) {
  return fixOffset(objToLocalTS(obj), offset, zone);
} // create a new DT instance by adding a duration, adjusting for DSTs


function adjustTime(inst, dur) {
  var oPre = inst.o,
      year = inst.c.year + Math.trunc(dur.years),
      month = inst.c.month + Math.trunc(dur.months) + Math.trunc(dur.quarters) * 3,
      c = Object.assign({}, inst.c, {
    year: year,
    month: month,
    day: Math.min(inst.c.day, daysInMonth(year, month)) + Math.trunc(dur.days) + Math.trunc(dur.weeks) * 7
  }),
      millisToAdd = Duration.fromObject({
    years: dur.years - Math.trunc(dur.years),
    quarters: dur.quarters - Math.trunc(dur.quarters),
    months: dur.months - Math.trunc(dur.months),
    weeks: dur.weeks - Math.trunc(dur.weeks),
    days: dur.days - Math.trunc(dur.days),
    hours: dur.hours,
    minutes: dur.minutes,
    seconds: dur.seconds,
    milliseconds: dur.milliseconds
  }).as("milliseconds"),
      localTS = objToLocalTS(c);

  var _fixOffset = fixOffset(localTS, oPre, inst.zone),
      ts = _fixOffset[0],
      o = _fixOffset[1];

  if (millisToAdd !== 0) {
    ts += millisToAdd; // that could have changed the offset by going over a DST, but we want to keep the ts the same

    o = inst.zone.offset(ts);
  }

  return {
    ts: ts,
    o: o
  };
} // helper useful in turning the results of parsing into real dates
// by handling the zone options


function parseDataToDateTime(parsed, parsedZone, opts, format, text) {
  var setZone = opts.setZone,
      zone = opts.zone;

  if (parsed && Object.keys(parsed).length !== 0) {
    var interpretationZone = parsedZone || zone,
        inst = DateTime.fromObject(Object.assign(parsed, opts, {
      zone: interpretationZone,
      // setZone is a valid option in the calling methods, but not in fromObject
      setZone: undefined
    }));
    return setZone ? inst : inst.setZone(zone);
  } else {
    return DateTime.invalid(new Invalid("unparsable", "the input \"" + text + "\" can't be parsed as " + format));
  }
} // if you want to output a technical format (e.g. RFC 2822), this helper
// helps handle the details


function toTechFormat(dt, format, allowZ) {
  if (allowZ === void 0) {
    allowZ = true;
  }

  return dt.isValid ? Formatter.create(Locale.create("en-US"), {
    allowZ: allowZ,
    forceSimple: true
  }).formatDateTimeFromString(dt, format) : null;
} // technical time formats (e.g. the time part of ISO 8601), take some options
// and this commonizes their handling


function toTechTimeFormat(dt, _ref) {
  var _ref$suppressSeconds = _ref.suppressSeconds,
      suppressSeconds = _ref$suppressSeconds === void 0 ? false : _ref$suppressSeconds,
      _ref$suppressMillisec = _ref.suppressMilliseconds,
      suppressMilliseconds = _ref$suppressMillisec === void 0 ? false : _ref$suppressMillisec,
      includeOffset = _ref.includeOffset,
      _ref$includePrefix = _ref.includePrefix,
      includePrefix = _ref$includePrefix === void 0 ? false : _ref$includePrefix,
      _ref$includeZone = _ref.includeZone,
      includeZone = _ref$includeZone === void 0 ? false : _ref$includeZone,
      _ref$spaceZone = _ref.spaceZone,
      spaceZone = _ref$spaceZone === void 0 ? false : _ref$spaceZone,
      _ref$format = _ref.format,
      format = _ref$format === void 0 ? "extended" : _ref$format;
  var fmt = format === "basic" ? "HHmm" : "HH:mm";

  if (!suppressSeconds || dt.second !== 0 || dt.millisecond !== 0) {
    fmt += format === "basic" ? "ss" : ":ss";

    if (!suppressMilliseconds || dt.millisecond !== 0) {
      fmt += ".SSS";
    }
  }

  if ((includeZone || includeOffset) && spaceZone) {
    fmt += " ";
  }

  if (includeZone) {
    fmt += "z";
  } else if (includeOffset) {
    fmt += format === "basic" ? "ZZZ" : "ZZ";
  }

  var str = toTechFormat(dt, fmt);

  if (includePrefix) {
    str = "T" + str;
  }

  return str;
} // defaults for unspecified units in the supported calendars


var defaultUnitValues = {
  month: 1,
  day: 1,
  hour: 0,
  minute: 0,
  second: 0,
  millisecond: 0
},
    defaultWeekUnitValues = {
  weekNumber: 1,
  weekday: 1,
  hour: 0,
  minute: 0,
  second: 0,
  millisecond: 0
},
    defaultOrdinalUnitValues = {
  ordinal: 1,
  hour: 0,
  minute: 0,
  second: 0,
  millisecond: 0
}; // Units in the supported calendars, sorted by bigness

var orderedUnits$1 = ["year", "month", "day", "hour", "minute", "second", "millisecond"],
    orderedWeekUnits = ["weekYear", "weekNumber", "weekday", "hour", "minute", "second", "millisecond"],
    orderedOrdinalUnits = ["year", "ordinal", "hour", "minute", "second", "millisecond"]; // standardize case and plurality in units

function normalizeUnit(unit) {
  var normalized = {
    year: "year",
    years: "year",
    month: "month",
    months: "month",
    day: "day",
    days: "day",
    hour: "hour",
    hours: "hour",
    minute: "minute",
    minutes: "minute",
    quarter: "quarter",
    quarters: "quarter",
    second: "second",
    seconds: "second",
    millisecond: "millisecond",
    milliseconds: "millisecond",
    weekday: "weekday",
    weekdays: "weekday",
    weeknumber: "weekNumber",
    weeksnumber: "weekNumber",
    weeknumbers: "weekNumber",
    weekyear: "weekYear",
    weekyears: "weekYear",
    ordinal: "ordinal"
  }[unit.toLowerCase()];
  if (!normalized) throw new InvalidUnitError(unit);
  return normalized;
} // this is a dumbed down version of fromObject() that runs about 60% faster
// but doesn't do any validation, makes a bunch of assumptions about what units
// are present, and so on.


function quickDT(obj, zone) {
  // assume we have the higher-order units
  for (var _iterator = _createForOfIteratorHelperLoose(orderedUnits$1), _step; !(_step = _iterator()).done;) {
    var u = _step.value;

    if (isUndefined(obj[u])) {
      obj[u] = defaultUnitValues[u];
    }
  }

  var invalid = hasInvalidGregorianData(obj) || hasInvalidTimeData(obj);

  if (invalid) {
    return DateTime.invalid(invalid);
  }

  var tsNow = Settings.now(),
      offsetProvis = zone.offset(tsNow),
      _objToTS = objToTS(obj, offsetProvis, zone),
      ts = _objToTS[0],
      o = _objToTS[1];

  return new DateTime({
    ts: ts,
    zone: zone,
    o: o
  });
}

function diffRelative(start, end, opts) {
  var round = isUndefined(opts.round) ? true : opts.round,
      format = function format(c, unit) {
    c = roundTo(c, round || opts.calendary ? 0 : 2, true);
    var formatter = end.loc.clone(opts).relFormatter(opts);
    return formatter.format(c, unit);
  },
      differ = function differ(unit) {
    if (opts.calendary) {
      if (!end.hasSame(start, unit)) {
        return end.startOf(unit).diff(start.startOf(unit), unit).get(unit);
      } else return 0;
    } else {
      return end.diff(start, unit).get(unit);
    }
  };

  if (opts.unit) {
    return format(differ(opts.unit), opts.unit);
  }

  for (var _iterator2 = _createForOfIteratorHelperLoose(opts.units), _step2; !(_step2 = _iterator2()).done;) {
    var unit = _step2.value;
    var count = differ(unit);

    if (Math.abs(count) >= 1) {
      return format(count, unit);
    }
  }

  return format(start > end ? -0 : 0, opts.units[opts.units.length - 1]);
}
/**
 * A DateTime is an immutable data structure representing a specific date and time and accompanying methods. It contains class and instance methods for creating, parsing, interrogating, transforming, and formatting them.
 *
 * A DateTime comprises of:
 * * A timestamp. Each DateTime instance refers to a specific millisecond of the Unix epoch.
 * * A time zone. Each instance is considered in the context of a specific zone (by default the local system's zone).
 * * Configuration properties that effect how output strings are formatted, such as `locale`, `numberingSystem`, and `outputCalendar`.
 *
 * Here is a brief overview of the most commonly used functionality it provides:
 *
 * * **Creation**: To create a DateTime from its components, use one of its factory class methods: {@link local}, {@link utc}, and (most flexibly) {@link fromObject}. To create one from a standard string format, use {@link fromISO}, {@link fromHTTP}, and {@link fromRFC2822}. To create one from a custom string format, use {@link fromFormat}. To create one from a native JS date, use {@link fromJSDate}.
 * * **Gregorian calendar and time**: To examine the Gregorian properties of a DateTime individually (i.e as opposed to collectively through {@link toObject}), use the {@link year}, {@link month},
 * {@link day}, {@link hour}, {@link minute}, {@link second}, {@link millisecond} accessors.
 * * **Week calendar**: For ISO week calendar attributes, see the {@link weekYear}, {@link weekNumber}, and {@link weekday} accessors.
 * * **Configuration** See the {@link locale} and {@link numberingSystem} accessors.
 * * **Transformation**: To transform the DateTime into other DateTimes, use {@link set}, {@link reconfigure}, {@link setZone}, {@link setLocale}, {@link plus}, {@link minus}, {@link endOf}, {@link startOf}, {@link toUTC}, and {@link toLocal}.
 * * **Output**: To convert the DateTime to other representations, use the {@link toRelative}, {@link toRelativeCalendar}, {@link toJSON}, {@link toISO}, {@link toHTTP}, {@link toObject}, {@link toRFC2822}, {@link toString}, {@link toLocaleString}, {@link toFormat}, {@link toMillis} and {@link toJSDate}.
 *
 * There's plenty others documented below. In addition, for more information on subtler topics like internationalization, time zones, alternative calendars, validity, and so on, see the external documentation.
 */


var DateTime = /*#__PURE__*/function () {
  /**
   * @access private
   */
  function DateTime(config) {
    var zone = config.zone || Settings.defaultZone;
    var invalid = config.invalid || (Number.isNaN(config.ts) ? new Invalid("invalid input") : null) || (!zone.isValid ? unsupportedZone(zone) : null);
    /**
     * @access private
     */

    this.ts = isUndefined(config.ts) ? Settings.now() : config.ts;
    var c = null,
        o = null;

    if (!invalid) {
      var unchanged = config.old && config.old.ts === this.ts && config.old.zone.equals(zone);

      if (unchanged) {
        var _ref2 = [config.old.c, config.old.o];
        c = _ref2[0];
        o = _ref2[1];
      } else {
        var ot = zone.offset(this.ts);
        c = tsToObj(this.ts, ot);
        invalid = Number.isNaN(c.year) ? new Invalid("invalid input") : null;
        c = invalid ? null : c;
        o = invalid ? null : ot;
      }
    }
    /**
     * @access private
     */


    this._zone = zone;
    /**
     * @access private
     */

    this.loc = config.loc || Locale.create();
    /**
     * @access private
     */

    this.invalid = invalid;
    /**
     * @access private
     */

    this.weekData = null;
    /**
     * @access private
     */

    this.c = c;
    /**
     * @access private
     */

    this.o = o;
    /**
     * @access private
     */

    this.isLuxonDateTime = true;
  } // CONSTRUCT

  /**
   * Create a DateTime for the current instant, in the system's time zone.
   *
   * Use Settings to override these default values if needed.
   * @example DateTime.now().toISO() //~> now in the ISO format
   * @return {DateTime}
   */


  DateTime.now = function now() {
    return new DateTime({});
  }
  /**
   * Create a local DateTime
   * @param {number} [year] - The calendar year. If omitted (as in, call `local()` with no arguments), the current time will be used
   * @param {number} [month=1] - The month, 1-indexed
   * @param {number} [day=1] - The day of the month, 1-indexed
   * @param {number} [hour=0] - The hour of the day, in 24-hour time
   * @param {number} [minute=0] - The minute of the hour, meaning a number between 0 and 59
   * @param {number} [second=0] - The second of the minute, meaning a number between 0 and 59
   * @param {number} [millisecond=0] - The millisecond of the second, meaning a number between 0 and 999
   * @example DateTime.local()                            //~> now
   * @example DateTime.local(2017)                        //~> 2017-01-01T00:00:00
   * @example DateTime.local(2017, 3)                     //~> 2017-03-01T00:00:00
   * @example DateTime.local(2017, 3, 12)                 //~> 2017-03-12T00:00:00
   * @example DateTime.local(2017, 3, 12, 5)              //~> 2017-03-12T05:00:00
   * @example DateTime.local(2017, 3, 12, 5, 45)          //~> 2017-03-12T05:45:00
   * @example DateTime.local(2017, 3, 12, 5, 45, 10)      //~> 2017-03-12T05:45:10
   * @example DateTime.local(2017, 3, 12, 5, 45, 10, 765) //~> 2017-03-12T05:45:10.765
   * @return {DateTime}
   */
  ;

  DateTime.local = function local(year, month, day, hour, minute, second, millisecond) {
    if (isUndefined(year)) {
      return DateTime.now();
    } else {
      return quickDT({
        year: year,
        month: month,
        day: day,
        hour: hour,
        minute: minute,
        second: second,
        millisecond: millisecond
      }, Settings.defaultZone);
    }
  }
  /**
   * Create a DateTime in UTC
   * @param {number} [year] - The calendar year. If omitted (as in, call `utc()` with no arguments), the current time will be used
   * @param {number} [month=1] - The month, 1-indexed
   * @param {number} [day=1] - The day of the month
   * @param {number} [hour=0] - The hour of the day, in 24-hour time
   * @param {number} [minute=0] - The minute of the hour, meaning a number between 0 and 59
   * @param {number} [second=0] - The second of the minute, meaning a number between 0 and 59
   * @param {number} [millisecond=0] - The millisecond of the second, meaning a number between 0 and 999
   * @example DateTime.utc()                            //~> now
   * @example DateTime.utc(2017)                        //~> 2017-01-01T00:00:00Z
   * @example DateTime.utc(2017, 3)                     //~> 2017-03-01T00:00:00Z
   * @example DateTime.utc(2017, 3, 12)                 //~> 2017-03-12T00:00:00Z
   * @example DateTime.utc(2017, 3, 12, 5)              //~> 2017-03-12T05:00:00Z
   * @example DateTime.utc(2017, 3, 12, 5, 45)          //~> 2017-03-12T05:45:00Z
   * @example DateTime.utc(2017, 3, 12, 5, 45, 10)      //~> 2017-03-12T05:45:10Z
   * @example DateTime.utc(2017, 3, 12, 5, 45, 10, 765) //~> 2017-03-12T05:45:10.765Z
   * @return {DateTime}
   */
  ;

  DateTime.utc = function utc(year, month, day, hour, minute, second, millisecond) {
    if (isUndefined(year)) {
      return new DateTime({
        ts: Settings.now(),
        zone: FixedOffsetZone.utcInstance
      });
    } else {
      return quickDT({
        year: year,
        month: month,
        day: day,
        hour: hour,
        minute: minute,
        second: second,
        millisecond: millisecond
      }, FixedOffsetZone.utcInstance);
    }
  }
  /**
   * Create a DateTime from a JavaScript Date object. Uses the default zone.
   * @param {Date} date - a JavaScript Date object
   * @param {Object} options - configuration options for the DateTime
   * @param {string|Zone} [options.zone='local'] - the zone to place the DateTime into
   * @return {DateTime}
   */
  ;

  DateTime.fromJSDate = function fromJSDate(date, options) {
    if (options === void 0) {
      options = {};
    }

    var ts = isDate(date) ? date.valueOf() : NaN;

    if (Number.isNaN(ts)) {
      return DateTime.invalid("invalid input");
    }

    var zoneToUse = normalizeZone(options.zone, Settings.defaultZone);

    if (!zoneToUse.isValid) {
      return DateTime.invalid(unsupportedZone(zoneToUse));
    }

    return new DateTime({
      ts: ts,
      zone: zoneToUse,
      loc: Locale.fromObject(options)
    });
  }
  /**
   * Create a DateTime from a number of milliseconds since the epoch (meaning since 1 January 1970 00:00:00 UTC). Uses the default zone.
   * @param {number} milliseconds - a number of milliseconds since 1970 UTC
   * @param {Object} options - configuration options for the DateTime
   * @param {string|Zone} [options.zone='local'] - the zone to place the DateTime into
   * @param {string} [options.locale] - a locale to set on the resulting DateTime instance
   * @param {string} options.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @param {string} options.numberingSystem - the numbering system to set on the resulting DateTime instance
   * @return {DateTime}
   */
  ;

  DateTime.fromMillis = function fromMillis(milliseconds, options) {
    if (options === void 0) {
      options = {};
    }

    if (!isNumber(milliseconds)) {
      throw new InvalidArgumentError("fromMillis requires a numerical input, but received a " + typeof milliseconds + " with value " + milliseconds);
    } else if (milliseconds < -MAX_DATE || milliseconds > MAX_DATE) {
      // this isn't perfect because because we can still end up out of range because of additional shifting, but it's a start
      return DateTime.invalid("Timestamp out of range");
    } else {
      return new DateTime({
        ts: milliseconds,
        zone: normalizeZone(options.zone, Settings.defaultZone),
        loc: Locale.fromObject(options)
      });
    }
  }
  /**
   * Create a DateTime from a number of seconds since the epoch (meaning since 1 January 1970 00:00:00 UTC). Uses the default zone.
   * @param {number} seconds - a number of seconds since 1970 UTC
   * @param {Object} options - configuration options for the DateTime
   * @param {string|Zone} [options.zone='local'] - the zone to place the DateTime into
   * @param {string} [options.locale] - a locale to set on the resulting DateTime instance
   * @param {string} options.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @param {string} options.numberingSystem - the numbering system to set on the resulting DateTime instance
   * @return {DateTime}
   */
  ;

  DateTime.fromSeconds = function fromSeconds(seconds, options) {
    if (options === void 0) {
      options = {};
    }

    if (!isNumber(seconds)) {
      throw new InvalidArgumentError("fromSeconds requires a numerical input");
    } else {
      return new DateTime({
        ts: seconds * 1000,
        zone: normalizeZone(options.zone, Settings.defaultZone),
        loc: Locale.fromObject(options)
      });
    }
  }
  /**
   * Create a DateTime from a JavaScript object with keys like 'year' and 'hour' with reasonable defaults.
   * @param {Object} obj - the object to create the DateTime from
   * @param {number} obj.year - a year, such as 1987
   * @param {number} obj.month - a month, 1-12
   * @param {number} obj.day - a day of the month, 1-31, depending on the month
   * @param {number} obj.ordinal - day of the year, 1-365 or 366
   * @param {number} obj.weekYear - an ISO week year
   * @param {number} obj.weekNumber - an ISO week number, between 1 and 52 or 53, depending on the year
   * @param {number} obj.weekday - an ISO weekday, 1-7, where 1 is Monday and 7 is Sunday
   * @param {number} obj.hour - hour of the day, 0-23
   * @param {number} obj.minute - minute of the hour, 0-59
   * @param {number} obj.second - second of the minute, 0-59
   * @param {number} obj.millisecond - millisecond of the second, 0-999
   * @param {string|Zone} [obj.zone='local'] - interpret the numbers in the context of a particular zone. Can take any value taken as the first argument to setZone()
   * @param {string} [obj.locale='system's locale'] - a locale to set on the resulting DateTime instance
   * @param {string} obj.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @param {string} obj.numberingSystem - the numbering system to set on the resulting DateTime instance
   * @example DateTime.fromObject({ year: 1982, month: 5, day: 25}).toISODate() //=> '1982-05-25'
   * @example DateTime.fromObject({ year: 1982 }).toISODate() //=> '1982-01-01'
   * @example DateTime.fromObject({ hour: 10, minute: 26, second: 6 }) //~> today at 10:26:06
   * @example DateTime.fromObject({ hour: 10, minute: 26, second: 6, zone: 'utc' }),
   * @example DateTime.fromObject({ hour: 10, minute: 26, second: 6, zone: 'local' })
   * @example DateTime.fromObject({ hour: 10, minute: 26, second: 6, zone: 'America/New_York' })
   * @example DateTime.fromObject({ weekYear: 2016, weekNumber: 2, weekday: 3 }).toISODate() //=> '2016-01-13'
   * @return {DateTime}
   */
  ;

  DateTime.fromObject = function fromObject(obj) {
    var zoneToUse = normalizeZone(obj.zone, Settings.defaultZone);

    if (!zoneToUse.isValid) {
      return DateTime.invalid(unsupportedZone(zoneToUse));
    }

    var tsNow = Settings.now(),
        offsetProvis = zoneToUse.offset(tsNow),
        normalized = normalizeObject(obj, normalizeUnit, ["zone", "locale", "outputCalendar", "numberingSystem"]),
        containsOrdinal = !isUndefined(normalized.ordinal),
        containsGregorYear = !isUndefined(normalized.year),
        containsGregorMD = !isUndefined(normalized.month) || !isUndefined(normalized.day),
        containsGregor = containsGregorYear || containsGregorMD,
        definiteWeekDef = normalized.weekYear || normalized.weekNumber,
        loc = Locale.fromObject(obj); // cases:
    // just a weekday -> this week's instance of that weekday, no worries
    // (gregorian data or ordinal) + (weekYear or weekNumber) -> error
    // (gregorian month or day) + ordinal -> error
    // otherwise just use weeks or ordinals or gregorian, depending on what's specified

    if ((containsGregor || containsOrdinal) && definiteWeekDef) {
      throw new ConflictingSpecificationError("Can't mix weekYear/weekNumber units with year/month/day or ordinals");
    }

    if (containsGregorMD && containsOrdinal) {
      throw new ConflictingSpecificationError("Can't mix ordinal dates with month/day");
    }

    var useWeekData = definiteWeekDef || normalized.weekday && !containsGregor; // configure ourselves to deal with gregorian dates or week stuff

    var units,
        defaultValues,
        objNow = tsToObj(tsNow, offsetProvis);

    if (useWeekData) {
      units = orderedWeekUnits;
      defaultValues = defaultWeekUnitValues;
      objNow = gregorianToWeek(objNow);
    } else if (containsOrdinal) {
      units = orderedOrdinalUnits;
      defaultValues = defaultOrdinalUnitValues;
      objNow = gregorianToOrdinal(objNow);
    } else {
      units = orderedUnits$1;
      defaultValues = defaultUnitValues;
    } // set default values for missing stuff


    var foundFirst = false;

    for (var _iterator3 = _createForOfIteratorHelperLoose(units), _step3; !(_step3 = _iterator3()).done;) {
      var u = _step3.value;
      var v = normalized[u];

      if (!isUndefined(v)) {
        foundFirst = true;
      } else if (foundFirst) {
        normalized[u] = defaultValues[u];
      } else {
        normalized[u] = objNow[u];
      }
    } // make sure the values we have are in range


    var higherOrderInvalid = useWeekData ? hasInvalidWeekData(normalized) : containsOrdinal ? hasInvalidOrdinalData(normalized) : hasInvalidGregorianData(normalized),
        invalid = higherOrderInvalid || hasInvalidTimeData(normalized);

    if (invalid) {
      return DateTime.invalid(invalid);
    } // compute the actual time


    var gregorian = useWeekData ? weekToGregorian(normalized) : containsOrdinal ? ordinalToGregorian(normalized) : normalized,
        _objToTS2 = objToTS(gregorian, offsetProvis, zoneToUse),
        tsFinal = _objToTS2[0],
        offsetFinal = _objToTS2[1],
        inst = new DateTime({
      ts: tsFinal,
      zone: zoneToUse,
      o: offsetFinal,
      loc: loc
    }); // gregorian data + weekday serves only to validate


    if (normalized.weekday && containsGregor && obj.weekday !== inst.weekday) {
      return DateTime.invalid("mismatched weekday", "you can't specify both a weekday of " + normalized.weekday + " and a date of " + inst.toISO());
    }

    return inst;
  }
  /**
   * Create a DateTime from an ISO 8601 string
   * @param {string} text - the ISO string
   * @param {Object} opts - options to affect the creation
   * @param {string|Zone} [opts.zone='local'] - use this zone if no offset is specified in the input string itself. Will also convert the time to this zone
   * @param {boolean} [opts.setZone=false] - override the zone with a fixed-offset zone specified in the string itself, if it specifies one
   * @param {string} [opts.locale='system's locale'] - a locale to set on the resulting DateTime instance
   * @param {string} [opts.outputCalendar] - the output calendar to set on the resulting DateTime instance
   * @param {string} [opts.numberingSystem] - the numbering system to set on the resulting DateTime instance
   * @example DateTime.fromISO('2016-05-25T09:08:34.123')
   * @example DateTime.fromISO('2016-05-25T09:08:34.123+06:00')
   * @example DateTime.fromISO('2016-05-25T09:08:34.123+06:00', {setZone: true})
   * @example DateTime.fromISO('2016-05-25T09:08:34.123', {zone: 'utc'})
   * @example DateTime.fromISO('2016-W05-4')
   * @return {DateTime}
   */
  ;

  DateTime.fromISO = function fromISO(text, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var _parseISODate = parseISODate(text),
        vals = _parseISODate[0],
        parsedZone = _parseISODate[1];

    return parseDataToDateTime(vals, parsedZone, opts, "ISO 8601", text);
  }
  /**
   * Create a DateTime from an RFC 2822 string
   * @param {string} text - the RFC 2822 string
   * @param {Object} opts - options to affect the creation
   * @param {string|Zone} [opts.zone='local'] - convert the time to this zone. Since the offset is always specified in the string itself, this has no effect on the interpretation of string, merely the zone the resulting DateTime is expressed in.
   * @param {boolean} [opts.setZone=false] - override the zone with a fixed-offset zone specified in the string itself, if it specifies one
   * @param {string} [opts.locale='system's locale'] - a locale to set on the resulting DateTime instance
   * @param {string} opts.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @param {string} opts.numberingSystem - the numbering system to set on the resulting DateTime instance
   * @example DateTime.fromRFC2822('25 Nov 2016 13:23:12 GMT')
   * @example DateTime.fromRFC2822('Fri, 25 Nov 2016 13:23:12 +0600')
   * @example DateTime.fromRFC2822('25 Nov 2016 13:23 Z')
   * @return {DateTime}
   */
  ;

  DateTime.fromRFC2822 = function fromRFC2822(text, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var _parseRFC2822Date = parseRFC2822Date(text),
        vals = _parseRFC2822Date[0],
        parsedZone = _parseRFC2822Date[1];

    return parseDataToDateTime(vals, parsedZone, opts, "RFC 2822", text);
  }
  /**
   * Create a DateTime from an HTTP header date
   * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec3.3.1
   * @param {string} text - the HTTP header date
   * @param {Object} opts - options to affect the creation
   * @param {string|Zone} [opts.zone='local'] - convert the time to this zone. Since HTTP dates are always in UTC, this has no effect on the interpretation of string, merely the zone the resulting DateTime is expressed in.
   * @param {boolean} [opts.setZone=false] - override the zone with the fixed-offset zone specified in the string. For HTTP dates, this is always UTC, so this option is equivalent to setting the `zone` option to 'utc', but this option is included for consistency with similar methods.
   * @param {string} [opts.locale='system's locale'] - a locale to set on the resulting DateTime instance
   * @param {string} opts.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @param {string} opts.numberingSystem - the numbering system to set on the resulting DateTime instance
   * @example DateTime.fromHTTP('Sun, 06 Nov 1994 08:49:37 GMT')
   * @example DateTime.fromHTTP('Sunday, 06-Nov-94 08:49:37 GMT')
   * @example DateTime.fromHTTP('Sun Nov  6 08:49:37 1994')
   * @return {DateTime}
   */
  ;

  DateTime.fromHTTP = function fromHTTP(text, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var _parseHTTPDate = parseHTTPDate(text),
        vals = _parseHTTPDate[0],
        parsedZone = _parseHTTPDate[1];

    return parseDataToDateTime(vals, parsedZone, opts, "HTTP", opts);
  }
  /**
   * Create a DateTime from an input string and format string.
   * Defaults to en-US if no locale has been specified, regardless of the system's locale.
   * @see https://moment.github.io/luxon/docs/manual/parsing.html#table-of-tokens
   * @param {string} text - the string to parse
   * @param {string} fmt - the format the string is expected to be in (see the link below for the formats)
   * @param {Object} opts - options to affect the creation
   * @param {string|Zone} [opts.zone='local'] - use this zone if no offset is specified in the input string itself. Will also convert the DateTime to this zone
   * @param {boolean} [opts.setZone=false] - override the zone with a zone specified in the string itself, if it specifies one
   * @param {string} [opts.locale='en-US'] - a locale string to use when parsing. Will also set the DateTime to this locale
   * @param {string} opts.numberingSystem - the numbering system to use when parsing. Will also set the resulting DateTime to this numbering system
   * @param {string} opts.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @return {DateTime}
   */
  ;

  DateTime.fromFormat = function fromFormat(text, fmt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    if (isUndefined(text) || isUndefined(fmt)) {
      throw new InvalidArgumentError("fromFormat requires an input string and a format");
    }

    var _opts = opts,
        _opts$locale = _opts.locale,
        locale = _opts$locale === void 0 ? null : _opts$locale,
        _opts$numberingSystem = _opts.numberingSystem,
        numberingSystem = _opts$numberingSystem === void 0 ? null : _opts$numberingSystem,
        localeToUse = Locale.fromOpts({
      locale: locale,
      numberingSystem: numberingSystem,
      defaultToEN: true
    }),
        _parseFromTokens = parseFromTokens(localeToUse, text, fmt),
        vals = _parseFromTokens[0],
        parsedZone = _parseFromTokens[1],
        invalid = _parseFromTokens[2];

    if (invalid) {
      return DateTime.invalid(invalid);
    } else {
      return parseDataToDateTime(vals, parsedZone, opts, "format " + fmt, text);
    }
  }
  /**
   * @deprecated use fromFormat instead
   */
  ;

  DateTime.fromString = function fromString(text, fmt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    return DateTime.fromFormat(text, fmt, opts);
  }
  /**
   * Create a DateTime from a SQL date, time, or datetime
   * Defaults to en-US if no locale has been specified, regardless of the system's locale
   * @param {string} text - the string to parse
   * @param {Object} opts - options to affect the creation
   * @param {string|Zone} [opts.zone='local'] - use this zone if no offset is specified in the input string itself. Will also convert the DateTime to this zone
   * @param {boolean} [opts.setZone=false] - override the zone with a zone specified in the string itself, if it specifies one
   * @param {string} [opts.locale='en-US'] - a locale string to use when parsing. Will also set the DateTime to this locale
   * @param {string} opts.numberingSystem - the numbering system to use when parsing. Will also set the resulting DateTime to this numbering system
   * @param {string} opts.outputCalendar - the output calendar to set on the resulting DateTime instance
   * @example DateTime.fromSQL('2017-05-15')
   * @example DateTime.fromSQL('2017-05-15 09:12:34')
   * @example DateTime.fromSQL('2017-05-15 09:12:34.342')
   * @example DateTime.fromSQL('2017-05-15 09:12:34.342+06:00')
   * @example DateTime.fromSQL('2017-05-15 09:12:34.342 America/Los_Angeles')
   * @example DateTime.fromSQL('2017-05-15 09:12:34.342 America/Los_Angeles', { setZone: true })
   * @example DateTime.fromSQL('2017-05-15 09:12:34.342', { zone: 'America/Los_Angeles' })
   * @example DateTime.fromSQL('09:12:34.342')
   * @return {DateTime}
   */
  ;

  DateTime.fromSQL = function fromSQL(text, opts) {
    if (opts === void 0) {
      opts = {};
    }

    var _parseSQL = parseSQL(text),
        vals = _parseSQL[0],
        parsedZone = _parseSQL[1];

    return parseDataToDateTime(vals, parsedZone, opts, "SQL", text);
  }
  /**
   * Create an invalid DateTime.
   * @param {string} reason - simple string of why this DateTime is invalid. Should not contain parameters or anything else data-dependent
   * @param {string} [explanation=null] - longer explanation, may include parameters and other useful debugging information
   * @return {DateTime}
   */
  ;

  DateTime.invalid = function invalid(reason, explanation) {
    if (explanation === void 0) {
      explanation = null;
    }

    if (!reason) {
      throw new InvalidArgumentError("need to specify a reason the DateTime is invalid");
    }

    var invalid = reason instanceof Invalid ? reason : new Invalid(reason, explanation);

    if (Settings.throwOnInvalid) {
      throw new InvalidDateTimeError(invalid);
    } else {
      return new DateTime({
        invalid: invalid
      });
    }
  }
  /**
   * Check if an object is a DateTime. Works across context boundaries
   * @param {object} o
   * @return {boolean}
   */
  ;

  DateTime.isDateTime = function isDateTime(o) {
    return o && o.isLuxonDateTime || false;
  } // INFO

  /**
   * Get the value of unit.
   * @param {string} unit - a unit such as 'minute' or 'day'
   * @example DateTime.local(2017, 7, 4).get('month'); //=> 7
   * @example DateTime.local(2017, 7, 4).get('day'); //=> 4
   * @return {number}
   */
  ;

  var _proto = DateTime.prototype;

  _proto.get = function get(unit) {
    return this[unit];
  }
  /**
   * Returns whether the DateTime is valid. Invalid DateTimes occur when:
   * * The DateTime was created from invalid calendar information, such as the 13th month or February 30
   * * The DateTime was created by an operation on another invalid date
   * @type {boolean}
   */
  ;

  /**
   * Returns the resolved Intl options for this DateTime.
   * This is useful in understanding the behavior of formatting methods
   * @param {Object} opts - the same options as toLocaleString
   * @return {Object}
   */
  _proto.resolvedLocaleOpts = function resolvedLocaleOpts(opts) {
    if (opts === void 0) {
      opts = {};
    }

    var _Formatter$create$res = Formatter.create(this.loc.clone(opts), opts).resolvedOptions(this),
        locale = _Formatter$create$res.locale,
        numberingSystem = _Formatter$create$res.numberingSystem,
        calendar = _Formatter$create$res.calendar;

    return {
      locale: locale,
      numberingSystem: numberingSystem,
      outputCalendar: calendar
    };
  } // TRANSFORM

  /**
   * "Set" the DateTime's zone to UTC. Returns a newly-constructed DateTime.
   *
   * Equivalent to {@link setZone}('utc')
   * @param {number} [offset=0] - optionally, an offset from UTC in minutes
   * @param {Object} [opts={}] - options to pass to `setZone()`
   * @return {DateTime}
   */
  ;

  _proto.toUTC = function toUTC(offset, opts) {
    if (offset === void 0) {
      offset = 0;
    }

    if (opts === void 0) {
      opts = {};
    }

    return this.setZone(FixedOffsetZone.instance(offset), opts);
  }
  /**
   * "Set" the DateTime's zone to the host's local zone. Returns a newly-constructed DateTime.
   *
   * Equivalent to `setZone('local')`
   * @return {DateTime}
   */
  ;

  _proto.toLocal = function toLocal() {
    return this.setZone(Settings.defaultZone);
  }
  /**
   * "Set" the DateTime's zone to specified zone. Returns a newly-constructed DateTime.
   *
   * By default, the setter keeps the underlying time the same (as in, the same timestamp), but the new instance will report different local times and consider DSTs when making computations, as with {@link plus}. You may wish to use {@link toLocal} and {@link toUTC} which provide simple convenience wrappers for commonly used zones.
   * @param {string|Zone} [zone='local'] - a zone identifier. As a string, that can be any IANA zone supported by the host environment, or a fixed-offset name of the form 'UTC+3', or the strings 'local' or 'utc'. You may also supply an instance of a {@link Zone} class.
   * @param {Object} opts - options
   * @param {boolean} [opts.keepLocalTime=false] - If true, adjust the underlying time so that the local time stays the same, but in the target zone. You should rarely need this.
   * @return {DateTime}
   */
  ;

  _proto.setZone = function setZone(zone, _temp) {
    var _ref3 = _temp === void 0 ? {} : _temp,
        _ref3$keepLocalTime = _ref3.keepLocalTime,
        keepLocalTime = _ref3$keepLocalTime === void 0 ? false : _ref3$keepLocalTime,
        _ref3$keepCalendarTim = _ref3.keepCalendarTime,
        keepCalendarTime = _ref3$keepCalendarTim === void 0 ? false : _ref3$keepCalendarTim;

    zone = normalizeZone(zone, Settings.defaultZone);

    if (zone.equals(this.zone)) {
      return this;
    } else if (!zone.isValid) {
      return DateTime.invalid(unsupportedZone(zone));
    } else {
      var newTS = this.ts;

      if (keepLocalTime || keepCalendarTime) {
        var offsetGuess = zone.offset(this.ts);
        var asObj = this.toObject();

        var _objToTS3 = objToTS(asObj, offsetGuess, zone);

        newTS = _objToTS3[0];
      }

      return clone$1(this, {
        ts: newTS,
        zone: zone
      });
    }
  }
  /**
   * "Set" the locale, numberingSystem, or outputCalendar. Returns a newly-constructed DateTime.
   * @param {Object} properties - the properties to set
   * @example DateTime.local(2017, 5, 25).reconfigure({ locale: 'en-GB' })
   * @return {DateTime}
   */
  ;

  _proto.reconfigure = function reconfigure(_temp2) {
    var _ref4 = _temp2 === void 0 ? {} : _temp2,
        locale = _ref4.locale,
        numberingSystem = _ref4.numberingSystem,
        outputCalendar = _ref4.outputCalendar;

    var loc = this.loc.clone({
      locale: locale,
      numberingSystem: numberingSystem,
      outputCalendar: outputCalendar
    });
    return clone$1(this, {
      loc: loc
    });
  }
  /**
   * "Set" the locale. Returns a newly-constructed DateTime.
   * Just a convenient alias for reconfigure({ locale })
   * @example DateTime.local(2017, 5, 25).setLocale('en-GB')
   * @return {DateTime}
   */
  ;

  _proto.setLocale = function setLocale(locale) {
    return this.reconfigure({
      locale: locale
    });
  }
  /**
   * "Set" the values of specified units. Returns a newly-constructed DateTime.
   * You can only set units with this method; for "setting" metadata, see {@link reconfigure} and {@link setZone}.
   * @param {Object} values - a mapping of units to numbers
   * @example dt.set({ year: 2017 })
   * @example dt.set({ hour: 8, minute: 30 })
   * @example dt.set({ weekday: 5 })
   * @example dt.set({ year: 2005, ordinal: 234 })
   * @return {DateTime}
   */
  ;

  _proto.set = function set(values) {
    if (!this.isValid) return this;
    var normalized = normalizeObject(values, normalizeUnit, []),
        settingWeekStuff = !isUndefined(normalized.weekYear) || !isUndefined(normalized.weekNumber) || !isUndefined(normalized.weekday),
        containsOrdinal = !isUndefined(normalized.ordinal),
        containsGregorYear = !isUndefined(normalized.year),
        containsGregorMD = !isUndefined(normalized.month) || !isUndefined(normalized.day),
        containsGregor = containsGregorYear || containsGregorMD,
        definiteWeekDef = normalized.weekYear || normalized.weekNumber;

    if ((containsGregor || containsOrdinal) && definiteWeekDef) {
      throw new ConflictingSpecificationError("Can't mix weekYear/weekNumber units with year/month/day or ordinals");
    }

    if (containsGregorMD && containsOrdinal) {
      throw new ConflictingSpecificationError("Can't mix ordinal dates with month/day");
    }

    var mixed;

    if (settingWeekStuff) {
      mixed = weekToGregorian(Object.assign(gregorianToWeek(this.c), normalized));
    } else if (!isUndefined(normalized.ordinal)) {
      mixed = ordinalToGregorian(Object.assign(gregorianToOrdinal(this.c), normalized));
    } else {
      mixed = Object.assign(this.toObject(), normalized); // if we didn't set the day but we ended up on an overflow date,
      // use the last day of the right month

      if (isUndefined(normalized.day)) {
        mixed.day = Math.min(daysInMonth(mixed.year, mixed.month), mixed.day);
      }
    }

    var _objToTS4 = objToTS(mixed, this.o, this.zone),
        ts = _objToTS4[0],
        o = _objToTS4[1];

    return clone$1(this, {
      ts: ts,
      o: o
    });
  }
  /**
   * Add a period of time to this DateTime and return the resulting DateTime
   *
   * Adding hours, minutes, seconds, or milliseconds increases the timestamp by the right number of milliseconds. Adding days, months, or years shifts the calendar, accounting for DSTs and leap years along the way. Thus, `dt.plus({ hours: 24 })` may result in a different time than `dt.plus({ days: 1 })` if there's a DST shift in between.
   * @param {Duration|Object|number} duration - The amount to add. Either a Luxon Duration, a number of milliseconds, the object argument to Duration.fromObject()
   * @example DateTime.now().plus(123) //~> in 123 milliseconds
   * @example DateTime.now().plus({ minutes: 15 }) //~> in 15 minutes
   * @example DateTime.now().plus({ days: 1 }) //~> this time tomorrow
   * @example DateTime.now().plus({ days: -1 }) //~> this time yesterday
   * @example DateTime.now().plus({ hours: 3, minutes: 13 }) //~> in 3 hr, 13 min
   * @example DateTime.now().plus(Duration.fromObject({ hours: 3, minutes: 13 })) //~> in 3 hr, 13 min
   * @return {DateTime}
   */
  ;

  _proto.plus = function plus(duration) {
    if (!this.isValid) return this;
    var dur = friendlyDuration(duration);
    return clone$1(this, adjustTime(this, dur));
  }
  /**
   * Subtract a period of time to this DateTime and return the resulting DateTime
   * See {@link plus}
   * @param {Duration|Object|number} duration - The amount to subtract. Either a Luxon Duration, a number of milliseconds, the object argument to Duration.fromObject()
   @return {DateTime}
  */
  ;

  _proto.minus = function minus(duration) {
    if (!this.isValid) return this;
    var dur = friendlyDuration(duration).negate();
    return clone$1(this, adjustTime(this, dur));
  }
  /**
   * "Set" this DateTime to the beginning of a unit of time.
   * @param {string} unit - The unit to go to the beginning of. Can be 'year', 'quarter', 'month', 'week', 'day', 'hour', 'minute', 'second', or 'millisecond'.
   * @example DateTime.local(2014, 3, 3).startOf('month').toISODate(); //=> '2014-03-01'
   * @example DateTime.local(2014, 3, 3).startOf('year').toISODate(); //=> '2014-01-01'
   * @example DateTime.local(2014, 3, 3).startOf('week').toISODate(); //=> '2014-03-03', weeks always start on Mondays
   * @example DateTime.local(2014, 3, 3, 5, 30).startOf('day').toISOTime(); //=> '00:00.000-05:00'
   * @example DateTime.local(2014, 3, 3, 5, 30).startOf('hour').toISOTime(); //=> '05:00:00.000-05:00'
   * @return {DateTime}
   */
  ;

  _proto.startOf = function startOf(unit) {
    if (!this.isValid) return this;
    var o = {},
        normalizedUnit = Duration.normalizeUnit(unit);

    switch (normalizedUnit) {
      case "years":
        o.month = 1;
      // falls through

      case "quarters":
      case "months":
        o.day = 1;
      // falls through

      case "weeks":
      case "days":
        o.hour = 0;
      // falls through

      case "hours":
        o.minute = 0;
      // falls through

      case "minutes":
        o.second = 0;
      // falls through

      case "seconds":
        o.millisecond = 0;
        break;
      // no default, invalid units throw in normalizeUnit()
    }

    if (normalizedUnit === "weeks") {
      o.weekday = 1;
    }

    if (normalizedUnit === "quarters") {
      var q = Math.ceil(this.month / 3);
      o.month = (q - 1) * 3 + 1;
    }

    return this.set(o);
  }
  /**
   * "Set" this DateTime to the end (meaning the last millisecond) of a unit of time
   * @param {string} unit - The unit to go to the end of. Can be 'year', 'quarter', 'month', 'week', 'day', 'hour', 'minute', 'second', or 'millisecond'.
   * @example DateTime.local(2014, 3, 3).endOf('month').toISO(); //=> '2014-03-31T23:59:59.999-05:00'
   * @example DateTime.local(2014, 3, 3).endOf('year').toISO(); //=> '2014-12-31T23:59:59.999-05:00'
   * @example DateTime.local(2014, 3, 3).endOf('week').toISO(); // => '2014-03-09T23:59:59.999-05:00', weeks start on Mondays
   * @example DateTime.local(2014, 3, 3, 5, 30).endOf('day').toISO(); //=> '2014-03-03T23:59:59.999-05:00'
   * @example DateTime.local(2014, 3, 3, 5, 30).endOf('hour').toISO(); //=> '2014-03-03T05:59:59.999-05:00'
   * @return {DateTime}
   */
  ;

  _proto.endOf = function endOf(unit) {
    var _this$plus;

    return this.isValid ? this.plus((_this$plus = {}, _this$plus[unit] = 1, _this$plus)).startOf(unit).minus(1) : this;
  } // OUTPUT

  /**
   * Returns a string representation of this DateTime formatted according to the specified format string.
   * **You may not want this.** See {@link toLocaleString} for a more flexible formatting tool. For a table of tokens and their interpretations, see [here](https://moment.github.io/luxon/docs/manual/formatting.html#table-of-tokens).
   * Defaults to en-US if no locale has been specified, regardless of the system's locale.
   * @see https://moment.github.io/luxon/docs/manual/formatting.html#table-of-tokens
   * @param {string} fmt - the format string
   * @param {Object} opts - opts to override the configuration options
   * @example DateTime.now().toFormat('yyyy LLL dd') //=> '2017 Apr 22'
   * @example DateTime.now().setLocale('fr').toFormat('yyyy LLL dd') //=> '2017 avr. 22'
   * @example DateTime.now().toFormat('yyyy LLL dd', { locale: "fr" }) //=> '2017 avr. 22'
   * @example DateTime.now().toFormat("HH 'hours and' mm 'minutes'") //=> '20 hours and 55 minutes'
   * @return {string}
   */
  ;

  _proto.toFormat = function toFormat(fmt, opts) {
    if (opts === void 0) {
      opts = {};
    }

    return this.isValid ? Formatter.create(this.loc.redefaultToEN(opts)).formatDateTimeFromString(this, fmt) : INVALID$2;
  }
  /**
   * Returns a localized string representing this date. Accepts the same options as the Intl.DateTimeFormat constructor and any presets defined by Luxon, such as `DateTime.DATE_FULL` or `DateTime.TIME_SIMPLE`.
   * The exact behavior of this method is browser-specific, but in general it will return an appropriate representation
   * of the DateTime in the assigned locale.
   * Defaults to the system's locale if no locale has been specified
   * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
   * @param opts {Object} - Intl.DateTimeFormat constructor options and configuration options
   * @example DateTime.now().toLocaleString(); //=> 4/20/2017
   * @example DateTime.now().setLocale('en-gb').toLocaleString(); //=> '20/04/2017'
   * @example DateTime.now().toLocaleString({ locale: 'en-gb' }); //=> '20/04/2017'
   * @example DateTime.now().toLocaleString(DateTime.DATE_FULL); //=> 'April 20, 2017'
   * @example DateTime.now().toLocaleString(DateTime.TIME_SIMPLE); //=> '11:32 AM'
   * @example DateTime.now().toLocaleString(DateTime.DATETIME_SHORT); //=> '4/20/2017, 11:32 AM'
   * @example DateTime.now().toLocaleString({ weekday: 'long', month: 'long', day: '2-digit' }); //=> 'Thursday, April 20'
   * @example DateTime.now().toLocaleString({ weekday: 'short', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' }); //=> 'Thu, Apr 20, 11:27 AM'
   * @example DateTime.now().toLocaleString({ hour: '2-digit', minute: '2-digit', hour12: false }); //=> '11:32'
   * @return {string}
   */
  ;

  _proto.toLocaleString = function toLocaleString(opts) {
    if (opts === void 0) {
      opts = DATE_SHORT;
    }

    return this.isValid ? Formatter.create(this.loc.clone(opts), opts).formatDateTime(this) : INVALID$2;
  }
  /**
   * Returns an array of format "parts", meaning individual tokens along with metadata. This is allows callers to post-process individual sections of the formatted output.
   * Defaults to the system's locale if no locale has been specified
   * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat/formatToParts
   * @param opts {Object} - Intl.DateTimeFormat constructor options, same as `toLocaleString`.
   * @example DateTime.now().toLocaleParts(); //=> [
   *                                   //=>   { type: 'day', value: '25' },
   *                                   //=>   { type: 'literal', value: '/' },
   *                                   //=>   { type: 'month', value: '05' },
   *                                   //=>   { type: 'literal', value: '/' },
   *                                   //=>   { type: 'year', value: '1982' }
   *                                   //=> ]
   */
  ;

  _proto.toLocaleParts = function toLocaleParts(opts) {
    if (opts === void 0) {
      opts = {};
    }

    return this.isValid ? Formatter.create(this.loc.clone(opts), opts).formatDateTimeParts(this) : [];
  }
  /**
   * Returns an ISO 8601-compliant string representation of this DateTime
   * @param {Object} opts - options
   * @param {boolean} [opts.suppressMilliseconds=false] - exclude milliseconds from the format if they're 0
   * @param {boolean} [opts.suppressSeconds=false] - exclude seconds from the format if they're 0
   * @param {boolean} [opts.includeOffset=true] - include the offset, such as 'Z' or '-04:00'
   * @param {string} [opts.format='extended'] - choose between the basic and extended format
   * @example DateTime.utc(1982, 5, 25).toISO() //=> '1982-05-25T00:00:00.000Z'
   * @example DateTime.now().toISO() //=> '2017-04-22T20:47:05.335-04:00'
   * @example DateTime.now().toISO({ includeOffset: false }) //=> '2017-04-22T20:47:05.335'
   * @example DateTime.now().toISO({ format: 'basic' }) //=> '20170422T204705.335-0400'
   * @return {string}
   */
  ;

  _proto.toISO = function toISO(opts) {
    if (opts === void 0) {
      opts = {};
    }

    if (!this.isValid) {
      return null;
    }

    return this.toISODate(opts) + "T" + this.toISOTime(opts);
  }
  /**
   * Returns an ISO 8601-compliant string representation of this DateTime's date component
   * @param {Object} opts - options
   * @param {string} [opts.format='extended'] - choose between the basic and extended format
   * @example DateTime.utc(1982, 5, 25).toISODate() //=> '1982-05-25'
   * @example DateTime.utc(1982, 5, 25).toISODate({ format: 'basic' }) //=> '19820525'
   * @return {string}
   */
  ;

  _proto.toISODate = function toISODate(_temp3) {
    var _ref5 = _temp3 === void 0 ? {} : _temp3,
        _ref5$format = _ref5.format,
        format = _ref5$format === void 0 ? "extended" : _ref5$format;

    var fmt = format === "basic" ? "yyyyMMdd" : "yyyy-MM-dd";

    if (this.year > 9999) {
      fmt = "+" + fmt;
    }

    return toTechFormat(this, fmt);
  }
  /**
   * Returns an ISO 8601-compliant string representation of this DateTime's week date
   * @example DateTime.utc(1982, 5, 25).toISOWeekDate() //=> '1982-W21-2'
   * @return {string}
   */
  ;

  _proto.toISOWeekDate = function toISOWeekDate() {
    return toTechFormat(this, "kkkk-'W'WW-c");
  }
  /**
   * Returns an ISO 8601-compliant string representation of this DateTime's time component
   * @param {Object} opts - options
   * @param {boolean} [opts.suppressMilliseconds=false] - exclude milliseconds from the format if they're 0
   * @param {boolean} [opts.suppressSeconds=false] - exclude seconds from the format if they're 0
   * @param {boolean} [opts.includeOffset=true] - include the offset, such as 'Z' or '-04:00'
   * @param {boolean} [opts.includePrefix=false] - include the `T` prefix
   * @param {string} [opts.format='extended'] - choose between the basic and extended format
   * @example DateTime.utc().set({ hour: 7, minute: 34 }).toISOTime() //=> '07:34:19.361Z'
   * @example DateTime.utc().set({ hour: 7, minute: 34, seconds: 0, milliseconds: 0 }).toISOTime({ suppressSeconds: true }) //=> '07:34Z'
   * @example DateTime.utc().set({ hour: 7, minute: 34 }).toISOTime({ format: 'basic' }) //=> '073419.361Z'
   * @example DateTime.utc().set({ hour: 7, minute: 34 }).toISOTime({ includePrefix: true }) //=> 'T07:34:19.361Z'
   * @return {string}
   */
  ;

  _proto.toISOTime = function toISOTime(_temp4) {
    var _ref6 = _temp4 === void 0 ? {} : _temp4,
        _ref6$suppressMillise = _ref6.suppressMilliseconds,
        suppressMilliseconds = _ref6$suppressMillise === void 0 ? false : _ref6$suppressMillise,
        _ref6$suppressSeconds = _ref6.suppressSeconds,
        suppressSeconds = _ref6$suppressSeconds === void 0 ? false : _ref6$suppressSeconds,
        _ref6$includeOffset = _ref6.includeOffset,
        includeOffset = _ref6$includeOffset === void 0 ? true : _ref6$includeOffset,
        _ref6$includePrefix = _ref6.includePrefix,
        includePrefix = _ref6$includePrefix === void 0 ? false : _ref6$includePrefix,
        _ref6$format = _ref6.format,
        format = _ref6$format === void 0 ? "extended" : _ref6$format;

    return toTechTimeFormat(this, {
      suppressSeconds: suppressSeconds,
      suppressMilliseconds: suppressMilliseconds,
      includeOffset: includeOffset,
      includePrefix: includePrefix,
      format: format
    });
  }
  /**
   * Returns an RFC 2822-compatible string representation of this DateTime, always in UTC
   * @example DateTime.utc(2014, 7, 13).toRFC2822() //=> 'Sun, 13 Jul 2014 00:00:00 +0000'
   * @example DateTime.local(2014, 7, 13).toRFC2822() //=> 'Sun, 13 Jul 2014 00:00:00 -0400'
   * @return {string}
   */
  ;

  _proto.toRFC2822 = function toRFC2822() {
    return toTechFormat(this, "EEE, dd LLL yyyy HH:mm:ss ZZZ", false);
  }
  /**
   * Returns a string representation of this DateTime appropriate for use in HTTP headers.
   * Specifically, the string conforms to RFC 1123.
   * @see https://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec3.3.1
   * @example DateTime.utc(2014, 7, 13).toHTTP() //=> 'Sun, 13 Jul 2014 00:00:00 GMT'
   * @example DateTime.utc(2014, 7, 13, 19).toHTTP() //=> 'Sun, 13 Jul 2014 19:00:00 GMT'
   * @return {string}
   */
  ;

  _proto.toHTTP = function toHTTP() {
    return toTechFormat(this.toUTC(), "EEE, dd LLL yyyy HH:mm:ss 'GMT'");
  }
  /**
   * Returns a string representation of this DateTime appropriate for use in SQL Date
   * @example DateTime.utc(2014, 7, 13).toSQLDate() //=> '2014-07-13'
   * @return {string}
   */
  ;

  _proto.toSQLDate = function toSQLDate() {
    return toTechFormat(this, "yyyy-MM-dd");
  }
  /**
   * Returns a string representation of this DateTime appropriate for use in SQL Time
   * @param {Object} opts - options
   * @param {boolean} [opts.includeZone=false] - include the zone, such as 'America/New_York'. Overrides includeOffset.
   * @param {boolean} [opts.includeOffset=true] - include the offset, such as 'Z' or '-04:00'
   * @example DateTime.utc().toSQL() //=> '05:15:16.345'
   * @example DateTime.now().toSQL() //=> '05:15:16.345 -04:00'
   * @example DateTime.now().toSQL({ includeOffset: false }) //=> '05:15:16.345'
   * @example DateTime.now().toSQL({ includeZone: false }) //=> '05:15:16.345 America/New_York'
   * @return {string}
   */
  ;

  _proto.toSQLTime = function toSQLTime(_temp5) {
    var _ref7 = _temp5 === void 0 ? {} : _temp5,
        _ref7$includeOffset = _ref7.includeOffset,
        includeOffset = _ref7$includeOffset === void 0 ? true : _ref7$includeOffset,
        _ref7$includeZone = _ref7.includeZone,
        includeZone = _ref7$includeZone === void 0 ? false : _ref7$includeZone;

    return toTechTimeFormat(this, {
      includeOffset: includeOffset,
      includeZone: includeZone,
      spaceZone: true
    });
  }
  /**
   * Returns a string representation of this DateTime appropriate for use in SQL DateTime
   * @param {Object} opts - options
   * @param {boolean} [opts.includeZone=false] - include the zone, such as 'America/New_York'. Overrides includeOffset.
   * @param {boolean} [opts.includeOffset=true] - include the offset, such as 'Z' or '-04:00'
   * @example DateTime.utc(2014, 7, 13).toSQL() //=> '2014-07-13 00:00:00.000 Z'
   * @example DateTime.local(2014, 7, 13).toSQL() //=> '2014-07-13 00:00:00.000 -04:00'
   * @example DateTime.local(2014, 7, 13).toSQL({ includeOffset: false }) //=> '2014-07-13 00:00:00.000'
   * @example DateTime.local(2014, 7, 13).toSQL({ includeZone: true }) //=> '2014-07-13 00:00:00.000 America/New_York'
   * @return {string}
   */
  ;

  _proto.toSQL = function toSQL(opts) {
    if (opts === void 0) {
      opts = {};
    }

    if (!this.isValid) {
      return null;
    }

    return this.toSQLDate() + " " + this.toSQLTime(opts);
  }
  /**
   * Returns a string representation of this DateTime appropriate for debugging
   * @return {string}
   */
  ;

  _proto.toString = function toString() {
    return this.isValid ? this.toISO() : INVALID$2;
  }
  /**
   * Returns the epoch milliseconds of this DateTime. Alias of {@link toMillis}
   * @return {number}
   */
  ;

  _proto.valueOf = function valueOf() {
    return this.toMillis();
  }
  /**
   * Returns the epoch milliseconds of this DateTime.
   * @return {number}
   */
  ;

  _proto.toMillis = function toMillis() {
    return this.isValid ? this.ts : NaN;
  }
  /**
   * Returns the epoch seconds of this DateTime.
   * @return {number}
   */
  ;

  _proto.toSeconds = function toSeconds() {
    return this.isValid ? this.ts / 1000 : NaN;
  }
  /**
   * Returns an ISO 8601 representation of this DateTime appropriate for use in JSON.
   * @return {string}
   */
  ;

  _proto.toJSON = function toJSON() {
    return this.toISO();
  }
  /**
   * Returns a BSON serializable equivalent to this DateTime.
   * @return {Date}
   */
  ;

  _proto.toBSON = function toBSON() {
    return this.toJSDate();
  }
  /**
   * Returns a JavaScript object with this DateTime's year, month, day, and so on.
   * @param opts - options for generating the object
   * @param {boolean} [opts.includeConfig=false] - include configuration attributes in the output
   * @example DateTime.now().toObject() //=> { year: 2017, month: 4, day: 22, hour: 20, minute: 49, second: 42, millisecond: 268 }
   * @return {Object}
   */
  ;

  _proto.toObject = function toObject(opts) {
    if (opts === void 0) {
      opts = {};
    }

    if (!this.isValid) return {};
    var base = Object.assign({}, this.c);

    if (opts.includeConfig) {
      base.outputCalendar = this.outputCalendar;
      base.numberingSystem = this.loc.numberingSystem;
      base.locale = this.loc.locale;
    }

    return base;
  }
  /**
   * Returns a JavaScript Date equivalent to this DateTime.
   * @return {Date}
   */
  ;

  _proto.toJSDate = function toJSDate() {
    return new Date(this.isValid ? this.ts : NaN);
  } // COMPARE

  /**
   * Return the difference between two DateTimes as a Duration.
   * @param {DateTime} otherDateTime - the DateTime to compare this one to
   * @param {string|string[]} [unit=['milliseconds']] - the unit or array of units (such as 'hours' or 'days') to include in the duration.
   * @param {Object} opts - options that affect the creation of the Duration
   * @param {string} [opts.conversionAccuracy='casual'] - the conversion system to use
   * @example
   * var i1 = DateTime.fromISO('1982-05-25T09:45'),
   *     i2 = DateTime.fromISO('1983-10-14T10:30');
   * i2.diff(i1).toObject() //=> { milliseconds: 43807500000 }
   * i2.diff(i1, 'hours').toObject() //=> { hours: 12168.75 }
   * i2.diff(i1, ['months', 'days']).toObject() //=> { months: 16, days: 19.03125 }
   * i2.diff(i1, ['months', 'days', 'hours']).toObject() //=> { months: 16, days: 19, hours: 0.75 }
   * @return {Duration}
   */
  ;

  _proto.diff = function diff(otherDateTime, unit, opts) {
    if (unit === void 0) {
      unit = "milliseconds";
    }

    if (opts === void 0) {
      opts = {};
    }

    if (!this.isValid || !otherDateTime.isValid) {
      return Duration.invalid(this.invalid || otherDateTime.invalid, "created by diffing an invalid DateTime");
    }

    var durOpts = Object.assign({
      locale: this.locale,
      numberingSystem: this.numberingSystem
    }, opts);

    var units = maybeArray(unit).map(Duration.normalizeUnit),
        otherIsLater = otherDateTime.valueOf() > this.valueOf(),
        earlier = otherIsLater ? this : otherDateTime,
        later = otherIsLater ? otherDateTime : this,
        diffed = _diff(earlier, later, units, durOpts);

    return otherIsLater ? diffed.negate() : diffed;
  }
  /**
   * Return the difference between this DateTime and right now.
   * See {@link diff}
   * @param {string|string[]} [unit=['milliseconds']] - the unit or units units (such as 'hours' or 'days') to include in the duration
   * @param {Object} opts - options that affect the creation of the Duration
   * @param {string} [opts.conversionAccuracy='casual'] - the conversion system to use
   * @return {Duration}
   */
  ;

  _proto.diffNow = function diffNow(unit, opts) {
    if (unit === void 0) {
      unit = "milliseconds";
    }

    if (opts === void 0) {
      opts = {};
    }

    return this.diff(DateTime.now(), unit, opts);
  }
  /**
   * Return an Interval spanning between this DateTime and another DateTime
   * @param {DateTime} otherDateTime - the other end point of the Interval
   * @return {Interval}
   */
  ;

  _proto.until = function until(otherDateTime) {
    return this.isValid ? Interval.fromDateTimes(this, otherDateTime) : this;
  }
  /**
   * Return whether this DateTime is in the same unit of time as another DateTime.
   * Higher-order units must also be identical for this function to return `true`.
   * Note that time zones are **ignored** in this comparison, which compares the **local** calendar time. Use {@link setZone} to convert one of the dates if needed.
   * @param {DateTime} otherDateTime - the other DateTime
   * @param {string} unit - the unit of time to check sameness on
   * @example DateTime.now().hasSame(otherDT, 'day'); //~> true if otherDT is in the same current calendar day
   * @return {boolean}
   */
  ;

  _proto.hasSame = function hasSame(otherDateTime, unit) {
    if (!this.isValid) return false;
    var inputMs = otherDateTime.valueOf();
    var otherZoneDateTime = this.setZone(otherDateTime.zone, {
      keepLocalTime: true
    });
    return otherZoneDateTime.startOf(unit) <= inputMs && inputMs <= otherZoneDateTime.endOf(unit);
  }
  /**
   * Equality check
   * Two DateTimes are equal iff they represent the same millisecond, have the same zone and location, and are both valid.
   * To compare just the millisecond values, use `+dt1 === +dt2`.
   * @param {DateTime} other - the other DateTime
   * @return {boolean}
   */
  ;

  _proto.equals = function equals(other) {
    return this.isValid && other.isValid && this.valueOf() === other.valueOf() && this.zone.equals(other.zone) && this.loc.equals(other.loc);
  }
  /**
   * Returns a string representation of a this time relative to now, such as "in two days". Can only internationalize if your
   * platform supports Intl.RelativeTimeFormat. Rounds down by default.
   * @param {Object} options - options that affect the output
   * @param {DateTime} [options.base=DateTime.now()] - the DateTime to use as the basis to which this time is compared. Defaults to now.
   * @param {string} [options.style="long"] - the style of units, must be "long", "short", or "narrow"
   * @param {string|string[]} options.unit - use a specific unit or array of units; if omitted, or an array, the method will pick the best unit. Use an array or one of "years", "quarters", "months", "weeks", "days", "hours", "minutes", or "seconds"
   * @param {boolean} [options.round=true] - whether to round the numbers in the output.
   * @param {number} [options.padding=0] - padding in milliseconds. This allows you to round up the result if it fits inside the threshold. Don't use in combination with {round: false} because the decimal output will include the padding.
   * @param {string} options.locale - override the locale of this DateTime
   * @param {string} options.numberingSystem - override the numberingSystem of this DateTime. The Intl system may choose not to honor this
   * @example DateTime.now().plus({ days: 1 }).toRelative() //=> "in 1 day"
   * @example DateTime.now().setLocale("es").toRelative({ days: 1 }) //=> "dentro de 1 día"
   * @example DateTime.now().plus({ days: 1 }).toRelative({ locale: "fr" }) //=> "dans 23 heures"
   * @example DateTime.now().minus({ days: 2 }).toRelative() //=> "2 days ago"
   * @example DateTime.now().minus({ days: 2 }).toRelative({ unit: "hours" }) //=> "48 hours ago"
   * @example DateTime.now().minus({ hours: 36 }).toRelative({ round: false }) //=> "1.5 days ago"
   */
  ;

  _proto.toRelative = function toRelative(options) {
    if (options === void 0) {
      options = {};
    }

    if (!this.isValid) return null;
    var base = options.base || DateTime.fromObject({
      zone: this.zone
    }),
        padding = options.padding ? this < base ? -options.padding : options.padding : 0;
    var units = ["years", "months", "days", "hours", "minutes", "seconds"];
    var unit = options.unit;

    if (Array.isArray(options.unit)) {
      units = options.unit;
      unit = undefined;
    }

    return diffRelative(base, this.plus(padding), Object.assign(options, {
      numeric: "always",
      units: units,
      unit: unit
    }));
  }
  /**
   * Returns a string representation of this date relative to today, such as "yesterday" or "next month".
   * Only internationalizes on platforms that supports Intl.RelativeTimeFormat.
   * @param {Object} options - options that affect the output
   * @param {DateTime} [options.base=DateTime.now()] - the DateTime to use as the basis to which this time is compared. Defaults to now.
   * @param {string} options.locale - override the locale of this DateTime
   * @param {string} options.unit - use a specific unit; if omitted, the method will pick the unit. Use one of "years", "quarters", "months", "weeks", or "days"
   * @param {string} options.numberingSystem - override the numberingSystem of this DateTime. The Intl system may choose not to honor this
   * @example DateTime.now().plus({ days: 1 }).toRelativeCalendar() //=> "tomorrow"
   * @example DateTime.now().setLocale("es").plus({ days: 1 }).toRelative() //=> ""mañana"
   * @example DateTime.now().plus({ days: 1 }).toRelativeCalendar({ locale: "fr" }) //=> "demain"
   * @example DateTime.now().minus({ days: 2 }).toRelativeCalendar() //=> "2 days ago"
   */
  ;

  _proto.toRelativeCalendar = function toRelativeCalendar(options) {
    if (options === void 0) {
      options = {};
    }

    if (!this.isValid) return null;
    return diffRelative(options.base || DateTime.fromObject({
      zone: this.zone
    }), this, Object.assign(options, {
      numeric: "auto",
      units: ["years", "months", "days"],
      calendary: true
    }));
  }
  /**
   * Return the min of several date times
   * @param {...DateTime} dateTimes - the DateTimes from which to choose the minimum
   * @return {DateTime} the min DateTime, or undefined if called with no argument
   */
  ;

  DateTime.min = function min() {
    for (var _len = arguments.length, dateTimes = new Array(_len), _key = 0; _key < _len; _key++) {
      dateTimes[_key] = arguments[_key];
    }

    if (!dateTimes.every(DateTime.isDateTime)) {
      throw new InvalidArgumentError("min requires all arguments be DateTimes");
    }

    return bestBy(dateTimes, function (i) {
      return i.valueOf();
    }, Math.min);
  }
  /**
   * Return the max of several date times
   * @param {...DateTime} dateTimes - the DateTimes from which to choose the maximum
   * @return {DateTime} the max DateTime, or undefined if called with no argument
   */
  ;

  DateTime.max = function max() {
    for (var _len2 = arguments.length, dateTimes = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      dateTimes[_key2] = arguments[_key2];
    }

    if (!dateTimes.every(DateTime.isDateTime)) {
      throw new InvalidArgumentError("max requires all arguments be DateTimes");
    }

    return bestBy(dateTimes, function (i) {
      return i.valueOf();
    }, Math.max);
  } // MISC

  /**
   * Explain how a string would be parsed by fromFormat()
   * @param {string} text - the string to parse
   * @param {string} fmt - the format the string is expected to be in (see description)
   * @param {Object} options - options taken by fromFormat()
   * @return {Object}
   */
  ;

  DateTime.fromFormatExplain = function fromFormatExplain(text, fmt, options) {
    if (options === void 0) {
      options = {};
    }

    var _options = options,
        _options$locale = _options.locale,
        locale = _options$locale === void 0 ? null : _options$locale,
        _options$numberingSys = _options.numberingSystem,
        numberingSystem = _options$numberingSys === void 0 ? null : _options$numberingSys,
        localeToUse = Locale.fromOpts({
      locale: locale,
      numberingSystem: numberingSystem,
      defaultToEN: true
    });
    return explainFromTokens(localeToUse, text, fmt);
  }
  /**
   * @deprecated use fromFormatExplain instead
   */
  ;

  DateTime.fromStringExplain = function fromStringExplain(text, fmt, options) {
    if (options === void 0) {
      options = {};
    }

    return DateTime.fromFormatExplain(text, fmt, options);
  } // FORMAT PRESETS

  /**
   * {@link toLocaleString} format like 10/14/1983
   * @type {Object}
   */
  ;

  _createClass(DateTime, [{
    key: "isValid",
    get: function get() {
      return this.invalid === null;
    }
    /**
     * Returns an error code if this DateTime is invalid, or null if the DateTime is valid
     * @type {string}
     */

  }, {
    key: "invalidReason",
    get: function get() {
      return this.invalid ? this.invalid.reason : null;
    }
    /**
     * Returns an explanation of why this DateTime became invalid, or null if the DateTime is valid
     * @type {string}
     */

  }, {
    key: "invalidExplanation",
    get: function get() {
      return this.invalid ? this.invalid.explanation : null;
    }
    /**
     * Get the locale of a DateTime, such 'en-GB'. The locale is used when formatting the DateTime
     *
     * @type {string}
     */

  }, {
    key: "locale",
    get: function get() {
      return this.isValid ? this.loc.locale : null;
    }
    /**
     * Get the numbering system of a DateTime, such 'beng'. The numbering system is used when formatting the DateTime
     *
     * @type {string}
     */

  }, {
    key: "numberingSystem",
    get: function get() {
      return this.isValid ? this.loc.numberingSystem : null;
    }
    /**
     * Get the output calendar of a DateTime, such 'islamic'. The output calendar is used when formatting the DateTime
     *
     * @type {string}
     */

  }, {
    key: "outputCalendar",
    get: function get() {
      return this.isValid ? this.loc.outputCalendar : null;
    }
    /**
     * Get the time zone associated with this DateTime.
     * @type {Zone}
     */

  }, {
    key: "zone",
    get: function get() {
      return this._zone;
    }
    /**
     * Get the name of the time zone.
     * @type {string}
     */

  }, {
    key: "zoneName",
    get: function get() {
      return this.isValid ? this.zone.name : null;
    }
    /**
     * Get the year
     * @example DateTime.local(2017, 5, 25).year //=> 2017
     * @type {number}
     */

  }, {
    key: "year",
    get: function get() {
      return this.isValid ? this.c.year : NaN;
    }
    /**
     * Get the quarter
     * @example DateTime.local(2017, 5, 25).quarter //=> 2
     * @type {number}
     */

  }, {
    key: "quarter",
    get: function get() {
      return this.isValid ? Math.ceil(this.c.month / 3) : NaN;
    }
    /**
     * Get the month (1-12).
     * @example DateTime.local(2017, 5, 25).month //=> 5
     * @type {number}
     */

  }, {
    key: "month",
    get: function get() {
      return this.isValid ? this.c.month : NaN;
    }
    /**
     * Get the day of the month (1-30ish).
     * @example DateTime.local(2017, 5, 25).day //=> 25
     * @type {number}
     */

  }, {
    key: "day",
    get: function get() {
      return this.isValid ? this.c.day : NaN;
    }
    /**
     * Get the hour of the day (0-23).
     * @example DateTime.local(2017, 5, 25, 9).hour //=> 9
     * @type {number}
     */

  }, {
    key: "hour",
    get: function get() {
      return this.isValid ? this.c.hour : NaN;
    }
    /**
     * Get the minute of the hour (0-59).
     * @example DateTime.local(2017, 5, 25, 9, 30).minute //=> 30
     * @type {number}
     */

  }, {
    key: "minute",
    get: function get() {
      return this.isValid ? this.c.minute : NaN;
    }
    /**
     * Get the second of the minute (0-59).
     * @example DateTime.local(2017, 5, 25, 9, 30, 52).second //=> 52
     * @type {number}
     */

  }, {
    key: "second",
    get: function get() {
      return this.isValid ? this.c.second : NaN;
    }
    /**
     * Get the millisecond of the second (0-999).
     * @example DateTime.local(2017, 5, 25, 9, 30, 52, 654).millisecond //=> 654
     * @type {number}
     */

  }, {
    key: "millisecond",
    get: function get() {
      return this.isValid ? this.c.millisecond : NaN;
    }
    /**
     * Get the week year
     * @see https://en.wikipedia.org/wiki/ISO_week_date
     * @example DateTime.local(2014, 12, 31).weekYear //=> 2015
     * @type {number}
     */

  }, {
    key: "weekYear",
    get: function get() {
      return this.isValid ? possiblyCachedWeekData(this).weekYear : NaN;
    }
    /**
     * Get the week number of the week year (1-52ish).
     * @see https://en.wikipedia.org/wiki/ISO_week_date
     * @example DateTime.local(2017, 5, 25).weekNumber //=> 21
     * @type {number}
     */

  }, {
    key: "weekNumber",
    get: function get() {
      return this.isValid ? possiblyCachedWeekData(this).weekNumber : NaN;
    }
    /**
     * Get the day of the week.
     * 1 is Monday and 7 is Sunday
     * @see https://en.wikipedia.org/wiki/ISO_week_date
     * @example DateTime.local(2014, 11, 31).weekday //=> 4
     * @type {number}
     */

  }, {
    key: "weekday",
    get: function get() {
      return this.isValid ? possiblyCachedWeekData(this).weekday : NaN;
    }
    /**
     * Get the ordinal (meaning the day of the year)
     * @example DateTime.local(2017, 5, 25).ordinal //=> 145
     * @type {number|DateTime}
     */

  }, {
    key: "ordinal",
    get: function get() {
      return this.isValid ? gregorianToOrdinal(this.c).ordinal : NaN;
    }
    /**
     * Get the human readable short month name, such as 'Oct'.
     * Defaults to the system's locale if no locale has been specified
     * @example DateTime.local(2017, 10, 30).monthShort //=> Oct
     * @type {string}
     */

  }, {
    key: "monthShort",
    get: function get() {
      return this.isValid ? Info.months("short", {
        locObj: this.loc
      })[this.month - 1] : null;
    }
    /**
     * Get the human readable long month name, such as 'October'.
     * Defaults to the system's locale if no locale has been specified
     * @example DateTime.local(2017, 10, 30).monthLong //=> October
     * @type {string}
     */

  }, {
    key: "monthLong",
    get: function get() {
      return this.isValid ? Info.months("long", {
        locObj: this.loc
      })[this.month - 1] : null;
    }
    /**
     * Get the human readable short weekday, such as 'Mon'.
     * Defaults to the system's locale if no locale has been specified
     * @example DateTime.local(2017, 10, 30).weekdayShort //=> Mon
     * @type {string}
     */

  }, {
    key: "weekdayShort",
    get: function get() {
      return this.isValid ? Info.weekdays("short", {
        locObj: this.loc
      })[this.weekday - 1] : null;
    }
    /**
     * Get the human readable long weekday, such as 'Monday'.
     * Defaults to the system's locale if no locale has been specified
     * @example DateTime.local(2017, 10, 30).weekdayLong //=> Monday
     * @type {string}
     */

  }, {
    key: "weekdayLong",
    get: function get() {
      return this.isValid ? Info.weekdays("long", {
        locObj: this.loc
      })[this.weekday - 1] : null;
    }
    /**
     * Get the UTC offset of this DateTime in minutes
     * @example DateTime.now().offset //=> -240
     * @example DateTime.utc().offset //=> 0
     * @type {number}
     */

  }, {
    key: "offset",
    get: function get() {
      return this.isValid ? +this.o : NaN;
    }
    /**
     * Get the short human name for the zone's current offset, for example "EST" or "EDT".
     * Defaults to the system's locale if no locale has been specified
     * @type {string}
     */

  }, {
    key: "offsetNameShort",
    get: function get() {
      if (this.isValid) {
        return this.zone.offsetName(this.ts, {
          format: "short",
          locale: this.locale
        });
      } else {
        return null;
      }
    }
    /**
     * Get the long human name for the zone's current offset, for example "Eastern Standard Time" or "Eastern Daylight Time".
     * Defaults to the system's locale if no locale has been specified
     * @type {string}
     */

  }, {
    key: "offsetNameLong",
    get: function get() {
      if (this.isValid) {
        return this.zone.offsetName(this.ts, {
          format: "long",
          locale: this.locale
        });
      } else {
        return null;
      }
    }
    /**
     * Get whether this zone's offset ever changes, as in a DST.
     * @type {boolean}
     */

  }, {
    key: "isOffsetFixed",
    get: function get() {
      return this.isValid ? this.zone.universal : null;
    }
    /**
     * Get whether the DateTime is in a DST.
     * @type {boolean}
     */

  }, {
    key: "isInDST",
    get: function get() {
      if (this.isOffsetFixed) {
        return false;
      } else {
        return this.offset > this.set({
          month: 1
        }).offset || this.offset > this.set({
          month: 5
        }).offset;
      }
    }
    /**
     * Returns true if this DateTime is in a leap year, false otherwise
     * @example DateTime.local(2016).isInLeapYear //=> true
     * @example DateTime.local(2013).isInLeapYear //=> false
     * @type {boolean}
     */

  }, {
    key: "isInLeapYear",
    get: function get() {
      return isLeapYear(this.year);
    }
    /**
     * Returns the number of days in this DateTime's month
     * @example DateTime.local(2016, 2).daysInMonth //=> 29
     * @example DateTime.local(2016, 3).daysInMonth //=> 31
     * @type {number}
     */

  }, {
    key: "daysInMonth",
    get: function get() {
      return daysInMonth(this.year, this.month);
    }
    /**
     * Returns the number of days in this DateTime's year
     * @example DateTime.local(2016).daysInYear //=> 366
     * @example DateTime.local(2013).daysInYear //=> 365
     * @type {number}
     */

  }, {
    key: "daysInYear",
    get: function get() {
      return this.isValid ? daysInYear(this.year) : NaN;
    }
    /**
     * Returns the number of weeks in this DateTime's year
     * @see https://en.wikipedia.org/wiki/ISO_week_date
     * @example DateTime.local(2004).weeksInWeekYear //=> 53
     * @example DateTime.local(2013).weeksInWeekYear //=> 52
     * @type {number}
     */

  }, {
    key: "weeksInWeekYear",
    get: function get() {
      return this.isValid ? weeksInWeekYear(this.weekYear) : NaN;
    }
  }], [{
    key: "DATE_SHORT",
    get: function get() {
      return DATE_SHORT;
    }
    /**
     * {@link toLocaleString} format like 'Oct 14, 1983'
     * @type {Object}
     */

  }, {
    key: "DATE_MED",
    get: function get() {
      return DATE_MED;
    }
    /**
     * {@link toLocaleString} format like 'Fri, Oct 14, 1983'
     * @type {Object}
     */

  }, {
    key: "DATE_MED_WITH_WEEKDAY",
    get: function get() {
      return DATE_MED_WITH_WEEKDAY;
    }
    /**
     * {@link toLocaleString} format like 'October 14, 1983'
     * @type {Object}
     */

  }, {
    key: "DATE_FULL",
    get: function get() {
      return DATE_FULL;
    }
    /**
     * {@link toLocaleString} format like 'Tuesday, October 14, 1983'
     * @type {Object}
     */

  }, {
    key: "DATE_HUGE",
    get: function get() {
      return DATE_HUGE;
    }
    /**
     * {@link toLocaleString} format like '09:30 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "TIME_SIMPLE",
    get: function get() {
      return TIME_SIMPLE;
    }
    /**
     * {@link toLocaleString} format like '09:30:23 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "TIME_WITH_SECONDS",
    get: function get() {
      return TIME_WITH_SECONDS;
    }
    /**
     * {@link toLocaleString} format like '09:30:23 AM EDT'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "TIME_WITH_SHORT_OFFSET",
    get: function get() {
      return TIME_WITH_SHORT_OFFSET;
    }
    /**
     * {@link toLocaleString} format like '09:30:23 AM Eastern Daylight Time'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "TIME_WITH_LONG_OFFSET",
    get: function get() {
      return TIME_WITH_LONG_OFFSET;
    }
    /**
     * {@link toLocaleString} format like '09:30', always 24-hour.
     * @type {Object}
     */

  }, {
    key: "TIME_24_SIMPLE",
    get: function get() {
      return TIME_24_SIMPLE;
    }
    /**
     * {@link toLocaleString} format like '09:30:23', always 24-hour.
     * @type {Object}
     */

  }, {
    key: "TIME_24_WITH_SECONDS",
    get: function get() {
      return TIME_24_WITH_SECONDS;
    }
    /**
     * {@link toLocaleString} format like '09:30:23 EDT', always 24-hour.
     * @type {Object}
     */

  }, {
    key: "TIME_24_WITH_SHORT_OFFSET",
    get: function get() {
      return TIME_24_WITH_SHORT_OFFSET;
    }
    /**
     * {@link toLocaleString} format like '09:30:23 Eastern Daylight Time', always 24-hour.
     * @type {Object}
     */

  }, {
    key: "TIME_24_WITH_LONG_OFFSET",
    get: function get() {
      return TIME_24_WITH_LONG_OFFSET;
    }
    /**
     * {@link toLocaleString} format like '10/14/1983, 9:30 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_SHORT",
    get: function get() {
      return DATETIME_SHORT;
    }
    /**
     * {@link toLocaleString} format like '10/14/1983, 9:30:33 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_SHORT_WITH_SECONDS",
    get: function get() {
      return DATETIME_SHORT_WITH_SECONDS;
    }
    /**
     * {@link toLocaleString} format like 'Oct 14, 1983, 9:30 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_MED",
    get: function get() {
      return DATETIME_MED;
    }
    /**
     * {@link toLocaleString} format like 'Oct 14, 1983, 9:30:33 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_MED_WITH_SECONDS",
    get: function get() {
      return DATETIME_MED_WITH_SECONDS;
    }
    /**
     * {@link toLocaleString} format like 'Fri, 14 Oct 1983, 9:30 AM'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_MED_WITH_WEEKDAY",
    get: function get() {
      return DATETIME_MED_WITH_WEEKDAY;
    }
    /**
     * {@link toLocaleString} format like 'October 14, 1983, 9:30 AM EDT'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_FULL",
    get: function get() {
      return DATETIME_FULL;
    }
    /**
     * {@link toLocaleString} format like 'October 14, 1983, 9:30:33 AM EDT'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_FULL_WITH_SECONDS",
    get: function get() {
      return DATETIME_FULL_WITH_SECONDS;
    }
    /**
     * {@link toLocaleString} format like 'Friday, October 14, 1983, 9:30 AM Eastern Daylight Time'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_HUGE",
    get: function get() {
      return DATETIME_HUGE;
    }
    /**
     * {@link toLocaleString} format like 'Friday, October 14, 1983, 9:30:33 AM Eastern Daylight Time'. Only 12-hour if the locale is.
     * @type {Object}
     */

  }, {
    key: "DATETIME_HUGE_WITH_SECONDS",
    get: function get() {
      return DATETIME_HUGE_WITH_SECONDS;
    }
  }]);

  return DateTime;
}();
function friendlyDateTime(dateTimeish) {
  if (DateTime.isDateTime(dateTimeish)) {
    return dateTimeish;
  } else if (dateTimeish && dateTimeish.valueOf && isNumber(dateTimeish.valueOf())) {
    return DateTime.fromJSDate(dateTimeish);
  } else if (dateTimeish && typeof dateTimeish === "object") {
    return DateTime.fromObject(dateTimeish);
  } else {
    throw new InvalidArgumentError("Unknown datetime argument: " + dateTimeish + ", of type " + typeof dateTimeish);
  }
}

var VERSION = "1.28.0";

exports.DateTime = DateTime;
exports.Duration = Duration;
exports.FixedOffsetZone = FixedOffsetZone;
exports.IANAZone = IANAZone;
exports.Info = Info;
exports.Interval = Interval;
exports.InvalidZone = InvalidZone;
exports.LocalZone = LocalZone;
exports.Settings = Settings;
exports.VERSION = VERSION;
exports.Zone = Zone;
//# sourceMappingURL=luxon.js.map


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/wip-confirm/Index.vue":
/*!***********************************************!*\
  !*** ./resources/js/pm/wip-confirm/Index.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_57151c40___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=57151c40& */ "./resources/js/pm/wip-confirm/Index.vue?vue&type=template&id=57151c40&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/wip-confirm/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _Index_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Index.vue?vue&type=style&index=0&lang=css& */ "./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_57151c40___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_57151c40___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/wip-confirm/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/wip-confirm/Index.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/pm/wip-confirm/Index.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************!*\
  !*** ./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/pm/wip-confirm/Index.vue?vue&type=template&id=57151c40&":
/*!******************************************************************************!*\
  !*** ./resources/js/pm/wip-confirm/Index.vue?vue&type=template&id=57151c40& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_57151c40___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_57151c40___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_57151c40___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=57151c40& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=template&id=57151c40&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=template&id=57151c40&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/wip-confirm/Index.vue?vue&type=template&id=57151c40& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
        _c("div", { staticClass: "ibox" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-12" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-2 font-weight-bold col-form-label text-right"
                    },
                    [_vm._v("วันที่ได้ผลผลิต:")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-3" },
                    [
                      _c("ct-datepicker", {
                        staticClass: "form-control my-1",
                        staticStyle: { width: "250px" },
                        attrs: {
                          placeholder: "โปรดเลือกวันที่",
                          enableDate: function(date) {
                            return _vm.isInRange(
                              date,
                              null,
                              _vm.toJSDate(_vm.search.to_date),
                              true
                            )
                          },
                          value: _vm.toJSDate(
                            _vm.search.from_date,
                            "yyyy-MM-dd"
                          )
                        },
                        on: {
                          change: function(date) {
                            _vm.search.from_date = _vm.jsDateToString(date)
                            _vm.search = Object.assign({}, _vm.search)
                          }
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "label",
                    {
                      staticClass: "my-1 m-3 text-right",
                      staticStyle: { width: "25px" }
                    },
                    [_vm._v("ถึง:")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-3" },
                    [
                      _c("ct-datepicker", {
                        staticClass: "form-control my-1",
                        staticStyle: { width: "250px" },
                        attrs: {
                          placeholder: "โปรดเลือกวันที่",
                          enableDate: function(date) {
                            return _vm.isInRange(
                              date,
                              _vm.toJSDate(_vm.search.from_date),
                              null,
                              true
                            )
                          },
                          value: _vm.toJSDate(_vm.search.to_date, "yyyy-MM-dd")
                        },
                        on: {
                          change: function(date) {
                            _vm.search.to_date = _vm.jsDateToString(date)
                            _vm.search = Object.assign({}, _vm.search)
                          }
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-2" }, [
                    _c(
                      "button",
                      {
                        class: _vm.transBtn.search.class,
                        attrs: { disabled: _vm.searching, type: "button" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.searchData()
                          }
                        }
                      },
                      [
                        _c("i", { class: _vm.transBtn.search.icon }),
                        _vm._v(
                          "\n                                        " +
                            _vm._s(_vm.transBtn.search.text) +
                            "\n                                    "
                        )
                      ]
                    )
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticStyle: { "text-align": "center" } }, [
              _vm.searching ? _c("hr") : _vm._e(),
              _vm._v(" "),
              _vm.searching
                ? _c("div", { staticClass: "lead text-center" }, [
                    _vm._v(
                      "\n                            กำลังค้นหา\n                            "
                    ),
                    _vm._m(1)
                  ])
                : _vm._e(),
              _vm._v(" "),
              !_vm.searching
                ? _c("table", { staticClass: "table table-bordered" }, [
                    _c("thead", [
                      _c("tr", { staticStyle: { "text-align": "center" } }, [
                        _c("th", { attrs: { rowspan: "2" } }, [
                          _vm._v("เลขที่คำสั่งการผลิต")
                        ]),
                        _vm._v(" "),
                        _vm.pOrgId != 183
                          ? _c("th", { attrs: { rowspan: "2" } }, [
                              _vm._v("Blend no.")
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("th", { attrs: { rowspan: "2" } }, [
                          _vm._v("รหัสสินค้าสำเร็จรูป")
                        ]),
                        _vm._v(" "),
                        _c("th", { attrs: { rowspan: "2" } }, [
                          _vm._v("รายการ")
                        ]),
                        _vm._v(" "),
                        _c("th", { attrs: { rowspan: "2" } }, [
                          _vm._v("หน่วยนับ")
                        ]),
                        _vm._v(" "),
                        _c("th", { attrs: { rowspan: "2" } })
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      [
                        _vm._l(_vm.jobHeaders, function(header) {
                          return !_vm.searching
                            ? _c(
                                "tr",
                                { key: header[0].batch_no + header[0].opt },
                                [
                                  _c("td", [
                                    _vm._v(_vm._s(header[0].batch_no))
                                  ]),
                                  _vm._v(" "),
                                  _vm.pOrgId != 183
                                    ? _c("td", [
                                        _vm._v(_vm._s(header[0].blend_no))
                                      ])
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c("td", [
                                    _vm._v(_vm._s(header[0].item_number))
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    header[0].item_data
                                      ? _c("span", [
                                          _vm._v(
                                            "\n                                        " +
                                              _vm._s(
                                                header[0].item_data.item_desc
                                              ) +
                                              "\n                                    "
                                          )
                                        ])
                                      : _vm._e()
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    header[0].item_data
                                      ? _c("span", [
                                          _vm._v(
                                            "\n                                        " +
                                              _vm._s(
                                                header[0].item_data
                                                  .primary_unit_of_measure
                                              ) +
                                              "\n                                    "
                                          )
                                        ])
                                      : _vm._e()
                                  ]),
                                  _vm._v(" "),
                                  _c("td", [
                                    _c(
                                      "button",
                                      {
                                        staticClass: "btn btn-w-m btn-default",
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            return _vm.onViewDescriptionClicked(
                                              header
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-file-text-o"
                                        }),
                                        _vm._v(
                                          "\n                                        ยืนยันยอดผลผลิต\n                                    "
                                        )
                                      ]
                                    )
                                  ])
                                ]
                              )
                            : _vm._e()
                        }),
                        _vm._v(" "),
                        Object.keys(_vm.jobHeaders).length === 0
                          ? _c("tr", { staticClass: "text-center" }, [
                              _vm.pOrgId == 183
                                ? _c("td", { attrs: { colspan: "5" } }, [
                                    _vm._m(2)
                                  ])
                                : _c("td", { attrs: { colspan: "6" } }, [
                                    _vm._m(3)
                                  ])
                            ])
                          : _vm._e()
                      ],
                      2
                    )
                  ])
                : _vm._e()
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
      _c("h3", [_vm._v("บันทึกผลผลิตประจำวัน")])
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
    return _c("div", { staticStyle: { color: "red" } }, [
      _c("h3", [_vm._v("ไม่พบข้อมูล")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticStyle: { color: "red" } }, [
      _c("h3", [_vm._v("ไม่พบข้อมูล")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/pm/routes.json":
/*!*************************************!*\
  !*** ./resources/js/pm/routes.json ***!
  \*************************************/
/***/ ((module) => {

"use strict";
module.exports = JSON.parse("{\"debugbar.openhandler\":\"/_debugbar/open\",\"debugbar.clockwork\":\"/_debugbar/clockwork/{id}\",\"debugbar.telescope\":\"/_debugbar/telescope/{id}\",\"debugbar.assets.css\":\"/_debugbar/assets/stylesheets\",\"debugbar.assets.js\":\"/_debugbar/assets/javascript\",\"debugbar.cache.delete\":\"/_debugbar/cache/{key}/{tags?}\",\"ajax.pm.plans.yearly.get-info\":\"/ajax/pm/plans/yearly/get-info\",\"ajax.pm.plans.yearly.get-source-versions\":\"/ajax/pm/plans/yearly/get-source-versions\",\"ajax.pm.plans.yearly.add-new-header\":\"/ajax/pm/plans/yearly/add-new-header\",\"ajax.pm.plans.yearly.get-sale-plans\":\"/ajax/pm/plans/yearly/get-sale-plans\",\"ajax.pm.plans.yearly.get-lines\":\"/ajax/pm/plans/yearly/get-lines\",\"ajax.pm.plans.yearly.generate-lines\":\"/ajax/pm/plans/yearly/generate-lines\",\"ajax.pm.plans.yearly.store-lines\":\"/ajax/pm/plans/yearly/store-lines\",\"ajax.pm.plans.yearly.submit-approval\":\"/ajax/pm/plans/yearly/submit-approval\",\"ajax.pm.plans.monthly.get-info\":\"/ajax/pm/plans/monthly/get-info\",\"ajax.pm.plans.monthly.get-source-versions\":\"/ajax/pm/plans/monthly/get-source-versions\",\"ajax.pm.plans.monthly.add-new-header\":\"/ajax/pm/plans/monthly/add-new-header\",\"ajax.pm.plans.monthly.get-months\":\"/ajax/pm/plans/monthly/get-months\",\"ajax.pm.plans.monthly.get-sale-plans\":\"/ajax/pm/plans/monthly/get-sale-plans\",\"ajax.pm.plans.monthly.get-lines\":\"/ajax/pm/plans/monthly/get-lines\",\"ajax.pm.plans.monthly.generate-lines\":\"/ajax/pm/plans/monthly/generate-lines\",\"ajax.pm.plans.monthly.store-lines\":\"/ajax/pm/plans/monthly/store-lines\",\"ajax.pm.plans.monthly.submit-plan\":\"/ajax/pm/plans/monthly/submit-plan\",\"ajax.pm.plans.biweekly.get-info\":\"/ajax/pm/plans/biweekly/get-info\",\"ajax.pm.plans.biweekly.get-source-versions\":\"/ajax/pm/plans/biweekly/get-source-versions\",\"ajax.pm.plans.biweekly.add-new-header\":\"/ajax/pm/plans/biweekly/add-new-header\",\"ajax.pm.plans.biweekly.get-months\":\"/ajax/pm/plans/biweekly/get-months\",\"ajax.pm.plans.biweekly.get-biweeks\":\"/ajax/pm/plans/biweekly/get-biweeks\",\"ajax.pm.plans.biweekly.get-lines\":\"/ajax/pm/plans/biweekly/get-lines\",\"ajax.pm.plans.biweekly.generate-lines\":\"/ajax/pm/plans/biweekly/generate-lines\",\"ajax.pm.plans.biweekly.store-lines\":\"/ajax/pm/plans/biweekly/store-lines\",\"ajax.pm.plans.biweekly.submit-approval\":\"/ajax/pm/plans/biweekly/submit-approval\",\"ajax.pm.plans.biweekly.submit-open-order\":\"/ajax/pm/plans/biweekly/submit-open-order\",\"ajax.pm.plans.daily.get-info\":\"/ajax/pm/plans/daily/get-info\",\"ajax.pm.plans.daily.get-source-versions\":\"/ajax/pm/plans/daily/get-source-versions\",\"ajax.pm.plans.daily.add-new-header\":\"/ajax/pm/plans/daily/add-new-header\",\"ajax.pm.plans.daily.get-months\":\"/ajax/pm/plans/daily/get-months\",\"ajax.pm.plans.daily.get-biweeks\":\"/ajax/pm/plans/daily/get-biweeks\",\"ajax.pm.plans.daily.get-weeks\":\"/ajax/pm/plans/daily/get-weeks\",\"ajax.pm.plans.daily.get-lines\":\"/ajax/pm/plans/daily/get-lines\",\"ajax.pm.plans.daily.generate-lines\":\"/ajax/pm/plans/daily/generate-lines\",\"ajax.pm.plans.daily.get-remianing-items\":\"/ajax/pm/plans/daily/get-remianing-items\",\"ajax.pm.plans.daily.store-line\":\"/ajax/pm/plans/daily/store-line\",\"ajax.pm.plans.daily.add-new-machine-line\":\"/ajax/pm/plans/daily/add-new-machine-line\",\"ajax.pm.plans.daily.add-new-line\":\"/ajax/pm/plans/daily/add-new-line\",\"ajax.pm.plans.daily.delete-machine-line\":\"/ajax/pm/plans/daily/delete-machine-line\",\"ajax.pm.plans.daily.delete-line\":\"/ajax/pm/plans/daily/delete-line\",\"ajax.pm.plans.daily.submit-plan\":\"/ajax/pm/plans/daily/submit-plan\",\"ajax.pm.products.machine-requests.get-requests\":\"/ajax/pm/products/machine-requests/get-requests\",\"ajax.pm.products.machine-requests.generate-requests\":\"/ajax/pm/products/machine-requests/generate-requests\",\"ajax.pm.products.machine-requests.store-requests\":\"/ajax/pm/products/machine-requests/store-requests\",\"ajax.pm.products.machine-requests.export-pdf\":\"/ajax/pm/products/machine-requests/export-pdf\",\"ajax.pm.products.transfers.find-header\":\"/ajax/pm/products/transfers/find-header\",\"ajax.pm.products.transfers.get-headers\":\"/ajax/pm/products/transfers/get-headers\",\"ajax.pm.products.transfers.store-header\":\"/ajax/pm/products/transfers/store-header\",\"ajax.pm.products.transfers.get-lines\":\"/ajax/pm/products/transfers/get-lines\",\"ajax.pm.products.transfers.store-lines\":\"/ajax/pm/products/transfers/store-lines\",\"ajax.pm.products.transfers.confirm-request\":\"/ajax/pm/products/transfers/confirm-request\",\"ajax.pm.products.transfers.discard-confirmed-request\":\"/ajax/pm/products/transfers/discard-confirmed-request\",\"ajax.pm.products.transfers.cancel-request\":\"/ajax/pm/products/transfers/cancel-request\",\"ajax.pm.products.transfers.submit-request\":\"/ajax/pm/products/transfers/submit-request\",\"api.db.lookup\":\"/api/lookup\",\"api.kms.expense-all\":\"/api/kms/expense-all/type/{type}/budget-year/{budgetYear}/period/{periodNo}\",\"api.kms.expense-dept\":\"/api/kms/expense-dept/department/{department}/budget-year/{budgetYear}/period/{periodNo}\",\"api.pd.lookup\":\"/api/pd/lookup/{table}\",\"api.pd.\":\"/api/pd/flavor-no\",\"api.pd.flavor-no.search\":\"/api/pd/flavor-no/search\",\"api.pd.flavor-no.store\":\"/api/pd/flavor-no/store\",\"api.pd.inv-material-item.update\":\"/api/pd/0004/{rawMaterialId}\",\"api.pd.inv-material-item.create\":\"/api/pd/flavor-no\",\"api.pd.0004.store\":\"/api/pd/0004\",\"api.pd.0004.show\":\"/api/pd/0004/{inventoryItemId}\",\"api.pd.0004.update\":\"/api/pd/0004/{rawMaterialId}\",\"api.pd.inv-material-item.store\":\"/api/pd/0004\",\"api.pd.inv-material-item.show\":\"/api/pd/0004/{inventoryItemId}\",\"api.pd.0005.search\":\"/api/pd/0005\",\"api.pd.0005.store\":\"/api/pd/0005\",\"api.pd.0005.show\":\"/api/pd/0005/{inventoryItemCode}\",\"api.pd.0005.update\":\"/api/pd/0005/{rawMaterialId}\",\"api.pd.example-cigarettes.search\":\"/api/pd/0005\",\"api.pd.example-cigarettes.store\":\"/api/pd/0005\",\"api.pd.example-cigarettes.show\":\"/api/pd/0005/{inventoryItemCode}\",\"api.pd.example-cigarettes.update\":\"/api/pd/0005/{rawMaterialId}\",\"api.pd.0006.blendFormulae.index\":\"/api/pd/0006/blendFormulae\",\"api.pd.0006.blendFormulae.show\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.0006.blendFormulae.update\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.0006.mfgFormulae.show\":\"/api/pd/0006/mfgFormulae\",\"api.pd.0006.leafFormulae.show\":\"/api/pd/0006/leafFormulae\",\"api.pd.0006.lookupItemNumbers.show\":\"/api/pd/0006/lookupItemNumbers\",\"api.pd.0006.lookupCasings.show\":\"/api/pd/0006/lookupCasings\",\"api.pd.0006.lookupFlavours.show\":\"/api/pd/0006/lookupFlavours\",\"api.pd.0006.lookupExampleCigarettes.show\":\"/api/pd/0006/lookupExampleCigarettes\",\"api.pd.create-trial-tobacco-formula.blendFormulae.index\":\"/api/pd/0006/blendFormulae\",\"api.pd.create-trial-tobacco-formula.blendFormulae.show\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.create-trial-tobacco-formula.blendFormulae.update\":\"/api/pd/0006/blendFormulae/{blendId}\",\"api.pd.create-trial-tobacco-formula.mfgFormulae.show\":\"/api/pd/0006/mfgFormulae\",\"api.pd.create-trial-tobacco-formula.leafFormulae.show\":\"/api/pd/0006/leafFormulae\",\"api.pd.create-trial-tobacco-formula.lookupItemNumbers.show\":\"/api/pd/0006/lookupItemNumbers\",\"api.pd.create-trial-tobacco-formula.lookupCasings.show\":\"/api/pd/0006/lookupCasings\",\"api.pd.create-trial-tobacco-formula.lookupFlavours.show\":\"/api/pd/0006/lookupFlavours\",\"api.pd.create-trial-tobacco-formula.lookupExampleCigarettes.show\":\"/api/pd/0006/lookupExampleCigarettes\",\"api.pd.expanded-tobacco.index\":\"/api/pd/expanded-tobacco\",\"api.pd.expanded-tobacco.create\":\"/api/pd/expanded-tobacco/create\",\"api.pd.expanded-tobacco.store\":\"/api/pd/expanded-tobacco\",\"api.pd.expanded-tobacco.show\":\"/api/pd/expanded-tobacco/{expanded_tobacco}\",\"api.pd.expanded-tobacco.edit\":\"/api/pd/expanded-tobacco/{expanded_tobacco}/edit\",\"api.pd.expanded-tobacco.update\":\"/api/pd/expanded-tobacco/{expanded_tobacco}\",\"api.pd.expanded-tobacco.destroy\":\"/api/pd/expanded-tobacco/{expanded_tobacco}\",\"api.pd.0009.search\":\"/api/pd/0009/search\",\"api.pm.0001.search\":\"/api/pm/0001/search\",\"api.pm.0001.uom\":\"/api/pm/0001/uom\",\"api.pm.0001.store\":\"/api/pm/0001\",\"api.pm.0001.update\":\"/api/pm/0001\",\"api.pm.production-order.search\":\"/api/pm/0001/search\",\"api.pm.production-order.uom\":\"/api/pm/0001/uom\",\"api.pm.production-order.store\":\"/api/pm/0001\",\"api.pm.production-order.update\":\"/api/pm/0001\",\"api.pm.ajax.production-order.batchStatus\":\"/api/pm/ajax/batchStatus\",\"api.pm.ajax.production-order.jobType\":\"/api/pm/ajax/jobType\",\"api.pm.0005.index\":\"/api/pm/0005/index/{id?}\",\"api.pm.0005.lines\":\"/api/pm/0005/lines/{id?}\",\"api.pm.0005.save\":\"/api/pm/0005/save\",\"api.pm.0005.confirmTransfer\":\"/api/pm/0005/confirmTransfer\",\"api.pm.request-materials.index\":\"/api/pm/0005/index/{id?}\",\"api.pm.request-materials.lines\":\"/api/pm/0005/lines/{id?}\",\"api.pm.request-materials.save\":\"/api/pm/0005/save\",\"api.pm.request-materials.confirmTransfer\":\"/api/pm/0005/confirmTransfer\",\"api.pm.0005-2.index\":\"/api/pm/0005-2/index/{id?}\",\"api.pm.0005-2.lines\":\"/api/pm/0005-2/lines/{id?}\",\"api.pm.0005-2.save\":\"/api/pm/0005-2/save\",\"api.pm.0005-2.confirmTransfer\":\"/api/pm/0005-2/confirmTransfer\",\"api.pm.0006.jobs.index\":\"/api/pm/0006/jobs\",\"api.pm.0006.jobs.show\":\"/api/pm/0006/jobs/{batchNo}\",\"api.pm.0006.jobLines.show\":\"/api/pm/0006/jobLines\",\"api.pm.0006.jobLines.update\":\"/api/pm/0006/jobLines\",\"api.pm.0006.importMesData\":\"/api/pm/0006/importMesData/{id}\",\"api.pm.report-product-in-process.jobs.index\":\"/api/pm/0006/jobs\",\"api.pm.report-product-in-process.jobs.show\":\"/api/pm/0006/jobs/{batchNo}\",\"api.pm.report-product-in-process.jobLines.show\":\"/api/pm/0006/jobLines\",\"api.pm.report-product-in-process.jobLines.update\":\"/api/pm/0006/jobLines\",\"api.pm.report-product-in-process.importMesData\":\"/api/pm/0006/importMesData/{id}\",\"api.pm.0007.show\":\"/api/pm/0007\",\"api.pm.0007.lookupTransactionDate\":\"/api/pm/0007/lookupTransactionDate\",\"api.pm.0007.save\":\"/api/pm/0007/save\",\"api.pm.0007.cutIssue\":\"/api/pm/0007/cutIssue\",\"api.pm.cut-raw-material.show\":\"/api/pm/0007\",\"api.pm.cut-raw-material.lookupTransactionDate\":\"/api/pm/0007/lookupTransactionDate\",\"api.pm.cut-raw-material.save\":\"/api/pm/0007/save\",\"api.pm.cut-raw-material.cutIssue\":\"/api/pm/0007/cutIssue\",\"api.pm.\":\"/api/pm/transaction-pkg-product\",\"api.pm.review-complete.index\":\"/api/pm/review-complete\",\"api.pm.review-complete.search\":\"/api/pm/review-complete/search\",\"api.pm.review-complete.save\":\"/api/pm/review-complete/save\",\"api.pm.0011.index\":\"/api/pm/review-complete\",\"api.pm.0011.search\":\"/api/pm/review-complete/search\",\"api.pm.0011.save\":\"/api/pm/review-complete/save\",\"api.pm.planning-job-lines.lines\":\"/api/pm/planning-job-lines/lines\",\"api.pm.planning-job-lines.lookupBlendNo\":\"/api/pm/planning-job-lines/lookupBlendNo\",\"api.pm.planning-job-lines.updateLines\":\"/api/pm/planning-job-lines/updateLines\",\"api.pm.0011.lines\":\"/api/pm/planning-job-lines/lines\",\"api.pm.0011.lookupBlendNo\":\"/api/pm/planning-job-lines/lookupBlendNo\",\"api.pm.0011.updateLines\":\"/api/pm/planning-job-lines/updateLines\",\"api.pm.0018.\":\"/api/pm/0018\",\"api.pm.0019.\":\"/api/pm/0019/{id}\",\"api.pm.0020.show\":\"/api/pm/0020/{id}\",\"api.pm.0020.update\":\"/api/pm/0020/{id}\",\"api.pm.0020.store\":\"/api/pm/0020\",\"api.pm.0020.lines\":\"/api/pm/0020/lines\",\"api.pm.machine-ingredient-requests.show\":\"/api/pm/0020/{id}\",\"api.pm.machine-ingredient-requests.update\":\"/api/pm/0020/{id}\",\"api.pm.machine-ingredient-requests.store\":\"/api/pm/0020\",\"api.pm.machine-ingredient-requests.lines\":\"/api/pm/0020/lines\",\"api.pm.0021.index\":\"/api/pm/0021\",\"api.pm.ingredient-requests.index\":\"/api/pm/0021\",\"api.pm.0022.index\":\"/api/pm/0022\",\"api.pm.0022.reports\":\"/api/pm/0022/reports/{id}\",\"api.pm.ingredient-preparation-list.index\":\"/api/pm/0022\",\"api.pm.ingredient-preparation-list.reports\":\"/api/pm/0022/reports/{id}\",\"api.pm.0023.rawMaterials\":\"/api/pm/0023/rawMaterials/{id}\",\"api.pm.0023.compareRawMaterials\":\"/api/pm/0023/compareRawMaterials\",\"api.pm.transaction-pnk-check-material.rawMaterials\":\"/api/pm/0023/rawMaterials/{id}\",\"api.pm.transaction-pnk-check-material.compareRawMaterials\":\"/api/pm/0023/compareRawMaterials\",\"api.pm.0027.index\":\"/api/pm/0027\",\"api.pm.0027.show\":\"/api/pm/0027/{date}\",\"api.pm.0027.update\":\"/api/pm/0027/{date}\",\"api.pm.0027.delete\":\"/api/pm/0027\",\"api.pm.sample-cigarettes.index\":\"/api/pm/0027\",\"api.pm.sample-cigarettes.show\":\"/api/pm/0027/{date}\",\"api.pm.sample-cigarettes.update\":\"/api/pm/0027/{date}\",\"api.pm.sample-cigarettes.delete\":\"/api/pm/0027\",\"api.pm.0028.getProductByDate\":\"/api/pm/0028/{date}\",\"api.pm.0028.update\":\"/api/pm/0028/{date}\",\"api.pm.0028.deleteLines\":\"/api/pm/0028\",\"api.pm.free-products.getProductByDate\":\"/api/pm/0028/{date}\",\"api.pm.free-products.update\":\"/api/pm/0028/{date}\",\"api.pm.free-products.deleteLines\":\"/api/pm/0028\",\"api.pm.0031.index\":\"/api/pm/0031\",\"api.pm.0031.get-batches\":\"/api/pm/0031/get-batches\",\"api.pm.0031.get-list-batch-headers\":\"/api/pm/0031/get-list-batch-headers\",\"api.pm.0031.get-wip-steps\":\"/api/pm/0031/get-wip-steps\",\"api.pm.0031.search\":\"/api/pm/0031/search\",\"api.pm.0031.save\":\"/api/pm/0031/save\",\"api.pm.0032.index\":\"/api/pm/0032\",\"api.pm.0032.show\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.0032.store\":\"/api/pm/0032\",\"api.pm.0032.update\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.0032.search\":\"/api/pm/0032/search\",\"api.pm.0032.transferStamp\":\"/api/pm/0032/transfer\",\"api.pm.0032.deleteLines\":\"/api/pm/0032/lines\",\"api.pm.stamp-using.index\":\"/api/pm/0032\",\"api.pm.stamp-using.show\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.stamp-using.store\":\"/api/pm/0032\",\"api.pm.stamp-using.update\":\"/api/pm/0032/{stampHeaderId}\",\"api.pm.stamp-using.search\":\"/api/pm/0032/search\",\"api.pm.stamp-using.transferStamp\":\"/api/pm/0032/transfer\",\"api.pm.stamp-using.deleteLines\":\"/api/pm/0032/lines\",\"api.pm.0033.get\":\"/api/pm/0033\",\"api.pm.0033.update-stamp-usage\":\"/api/pm/0033\",\"api.pm.0033.use-stamp\":\"/api/pm/0033/useStamp\",\"api.pm.confirm-stamp-using.get\":\"/api/pm/0033\",\"api.pm.confirm-stamp-using.update-stamp-usage\":\"/api/pm/0033\",\"api.pm.confirm-stamp-using.use-stamp\":\"/api/pm/0033/useStamp\",\"api.pm.0036.index\":\"/api/pm/0036\",\"api.pm.0036.job-opt-relations\":\"/api/pm/0036/jobOptRelations\",\"api.pm.0036.close-batch\":\"/api/pm/0036/closeBatch\",\"api.pm.close-product-order.index\":\"/api/pm/0036\",\"api.pm.close-product-order.job-opt-relations\":\"/api/pm/0036/jobOptRelations\",\"api.pm.close-product-order.close-batch\":\"/api/pm/0036/closeBatch\",\"api.pm.0038.\":\"/api/pm/0038/close-job\",\"api.pm.0041.index\":\"/api/pm/0041\",\"api.pm.0041.updateExamineCasing\":\"/api/pm/0041/updateExamineCasing\",\"api.pm.0041.updateExpirationDate\":\"/api/pm/0041/updateExpirationDate\",\"api.pm.examine-casing-after-expiry-date.index\":\"/api/pm/0041\",\"api.pm.examine-casing-after-expiry-date.updateExamineCasing\":\"/api/pm/0041/updateExamineCasing\",\"api.pm.examine-casing-after-expiry-date.updateExpirationDate\":\"/api/pm/0041/updateExpirationDate\",\"api.pm.0042.index\":\"/api/pm/0042\",\"api.pm.0042.approveRequest\":\"/api/pm/0042/approveRequest\",\"api.pm.0042.rejectRequest\":\"/api/pm/0042/rejectRequest\",\"api.pm.0043.\":\"/api/pm/0043\",\"api.pm.0045.approveRequest\":\"/api/pm/0045/approveRequest\",\"api.pm.0045.cancelRequest\":\"/api/pm/0045/cancelRequest\",\"api.pm.0045.\":\"/api/pm/0045/{id}\",\"api.pm.examine-after-manufactured.approveRequest\":\"/api/pm/0045/approveRequest\",\"api.pm.examine-after-manufactured.cancelRequest\":\"/api/pm/0045/cancelRequest\",\"api.pm.examine-after-manufactured.\":\"/api/pm/0045/{id}\",\"api.pm.test/pat.get\":\"/api/pm/test/pat\",\"ajax.roles.get-menu-by-module\":\"/ajax/roles/get-menu-by-module\",\"ajax.roles.get-permission\":\"/ajax/roles/get-permission\",\"ajax.roles.assign-permission\":\"/ajax/roles/{role}/assign-permission\",\"ajax.roles.store\":\"/ajax/roles\",\"ajax.roles.update\":\"/ajax/roles/{role}\",\"ajax.users.store\":\"/ajax/users\",\"ajax.users.update\":\"/ajax/users/{user}\",\"ajax.users.get-user\":\"/ajax/users/get-user\",\"ajax.users.get-department\":\"/ajax/users/get-department\",\"ajax.users.get-oa-user\":\"/ajax/users/get-oa-user\",\"ajax.users.get-role\":\"/ajax/users/get-role\",\"menus.index\":\"/menus\",\"menus.create\":\"/menus/create\",\"menus.store\":\"/menus\",\"menus.edit\":\"/menus/{menu}/edit\",\"menus.update\":\"/menus/{menu}\",\"users.permissions\":\"/users/{user}/permissions\",\"users.assign-permission\":\"/users/{user}/assign-permission\",\"users.change-deparment\":\"/users/{user}/change-deparment\",\"users.index\":\"/users\",\"users.create\":\"/users/create\",\"users.edit\":\"/users/{user}/edit\",\"roles.index\":\"/roles\",\"roles.create\":\"/roles/create\",\"roles.edit\":\"/roles/{role}/edit\",\"home\":\"/home\",\"funds.index\":\"/inquiry-funds\",\"funds.show\":\"/inquiry-funds\",\"program.type.index\":\"/program/type\",\"program.type.create\":\"/program/type/create\",\"program.type.store\":\"/program/type\",\"program.type.edit\":\"/program/type/{program_type}/edit\",\"program.type.update\":\"/program/type/update\",\"program.info.index\":\"/program/info\",\"program.info.create\":\"/program/info/create\",\"program.info.store\":\"/program/info\",\"program.info.edit\":\"/program/info/{program_code}/edit\",\"program.info.update\":\"/program/info/update\",\"lookup.index\":\"/lookup\",\"lookup.create\":\"/lookup/create\",\"lookup.store\":\"/lookup\",\"lookup.edit\":\"/lookup/{lookup}/edit\",\"lookup.update\":\"/lookup/{lookup}\",\"lookup.delete\":\"/lookup/{lookup}\",\"set-up.index\":\"/set-up\",\"set-up.show\":\"/set-up/{program_code}/show\",\"set-up.update\":\"/set-up/{program_code}/{column_name}\",\"running-number.index\":\"/running-number\",\"running-number.create\":\"/running-number/create\",\"running-number.store\":\"/running-number\",\"running-number.edit\":\"/running-number/{running_number}/edit\",\"running-number.update\":\"/running-number/{running_number}\",\"logout\":\"/logout\",\"login\":\"/login\",\"register\":\"/register\",\"password.request\":\"/password/reset\",\"password.email\":\"/password/email\",\"password.reset\":\"/password/reset/{token}\",\"password.update\":\"/password/reset\",\"password.confirm\":\"/password/confirm\",\"example.ajax.users.index\":\"/example/ajax/users\",\"example.users.export-excel\":\"/example/users/export-excel\",\"example.users.export-pdf\":\"/example/users/export-pdf\",\"example.users.interface\":\"/example/users/{user}/interface\",\"example.users.interface-error\":\"/example/users/interface-error\",\"example.users.index\":\"/example/users\",\"example.users.create\":\"/example/users/create\",\"example.users.store\":\"/example/users\",\"example.users.show\":\"/example/users/{user}\",\"example.users.edit\":\"/example/users/{user}/edit\",\"example.users.update\":\"/example/users/{user}\",\"example.users.destroy\":\"/example/users/{user}\",\"pd.ajax.\":\"/pd/ajax/ohhand-tobacco-forewarn/create/findTobaccoForewarn\",\"pd.settings.simu-raw-material.index\":\"/pd/settings/simu-raw-material\",\"pd.settings.simu-raw-material.create\":\"/pd/settings/simu-raw-material/create\",\"pd.settings.simu-raw-material.store\":\"/pd/settings/simu-raw-material\",\"pd.settings.simu-raw-material.edit\":\"/pd/settings/simu-raw-material/{simu_raw_id}/edit\",\"pd.settings.simu-raw-material.update\":\"/pd/settings/simu-raw-material/{simu_raw_id}\",\"pd.settings.simu-raw-material.delete\":\"/pd/settings/simu-raw-material/{simu_raw_id}\",\"pd.settings.simu-raw-material.createInv\":\"/pd/settings/simu-raw-material/{simu_raw_id}/create-inv\",\"pd.settings.ohhand-tobacco-forewarn.index\":\"/pd/settings/ohhand-tobacco-forewarn\",\"pd.settings.ohhand-tobacco-forewarn.store\":\"/pd/settings/ohhand-tobacco-forewarn/store\",\"pd.settings.ohhand-tobacco-forewarn.update\":\"/pd/settings/ohhand-tobacco-forewarn/store/update/{forewarn_id}/{inventory_item_id}\",\"pd.0001.index\":\"/pd/0001\",\"pd.casing-simu-additive.index\":\"/pd/0001\",\"pd.0002.index\":\"/pd/0002\",\"pd.flavor-simu-additive.index\":\"/pd/0002\",\"pd.0003.index\":\"/pd/0003\",\"pd.pd-0003.index\":\"/pd/0003\",\"pd.0004.index\":\"/pd/0004\",\"pd.0004.show\":\"/pd/0004/{inventoryItemId}\",\"pd.inv-material-items.index\":\"/pd/0004\",\"pd.inv-material-items.show\":\"/pd/0004/{inventoryItemId}\",\"pd.0005.index\":\"/pd/0005\",\"pd.0005.show\":\"/pd/0005/{inventoryItemCode}\",\"pd.example-cigarettes.index\":\"/pd/0005\",\"pd.example-cigarettes.show\":\"/pd/0005/{inventoryItemCode}\",\"pd.0006.index\":\"/pd/0006\",\"pd.0006.show\":\"/pd/0006/{blendId}\",\"pd.0007.index\":\"/pd/0007\",\"pd.0008.index\":\"/pd/0008\",\"pd.0010.index\":\"/pd/0010\",\"pd.0011.index\":\"/pd/0011\",\"pd.0012.index\":\"/pd/0012\",\"pd.0013.index\":\"/pd/0013\",\"pd.0009.index\":\"/pd/0009/{id?}\",\"pd.0009.test\":\"/pd/0009/test\",\"pd.expanded-tobacco.index\":\"/pd/0009/{id?}\",\"pd.expanded-tobacco.test\":\"/pd/0009/test\",\"pd.0014.index\":\"/pd/0014\",\"pd.pd-0014.index\":\"/pd/0014\",\"pm.ajax.\":\"/pm/ajax/setup-transfer/get-subinventory\",\"pm.ajax.get-item-number\":\"/pm/ajax/setup-min-max-by-item/get-item-number\",\"pm.ajax.get-data-table\":\"/pm/ajax/get-data-table\",\"pm.ajax.get-organization\":\"/pm/ajax/setup-min-max-by-item/get-organization\",\"pm.ajax.get-locations\":\"/pm/ajax/setup-min-max-by-item/get-locations\",\"pm.ajax.get-uom\":\"/pm/ajax/setup-min-max-by-item/get-uom\",\"pm.ajax.destroy\":\"/pm/ajax/setup-min-max-by-item/destroy\",\"pm.ajax.search\":\"/pm/ajax/setup-min-max-by-item/search\",\"pm.ajax.print-conversion.destroy\":\"/pm/ajax/print-conversion/destroy\",\"pm.settings.material-group.index\":\"/pm/settings/material-group\",\"pm.settings.material-group.create\":\"/pm/settings/material-group/create\",\"pm.settings.material-group.store\":\"/pm/settings/material-group/store\",\"pm.settings.relation-feeder.index\":\"/pm/settings/relation-feeder\",\"pm.settings.relation-feeder.create\":\"/pm/settings/relation-feeder/create\",\"pm.settings.relation-feeder.store\":\"/pm/settings/relation-feeder/store\",\"pm.settings.relation-feeder.edit\":\"/pm/settings/relation-feeder/{machnie_group}/{feeder_code}/edit\",\"pm.settings.relation-feeder.update\":\"/pm/settings/relation-feeder/update\",\"pm.settings.org-tranfer.index\":\"/pm/settings/org-tranfer\",\"pm.settings.org-tranfer.create\":\"/pm/settings/org-tranfer/create\",\"pm.settings.org-tranfer.store\":\"/pm/settings/org-tranfer/store\",\"pm.settings.org-tranfer.edit\":\"/pm/settings/org-tranfer/edit/{id}\",\"pm.settings.org-tranfer.update\":\"/pm/settings/org-tranfer/update\",\"pm.settings.wip-step.index\":\"/pm/settings/wip-step\",\"pm.settings.wip-step.create\":\"/pm/settings/wip-step/create\",\"pm.settings.wip-step.store\":\"/pm/settings/wip-step\",\"pm.settings.wip-step.edit\":\"/pm/settings/wip-step/{id}/edit\",\"pm.settings.wip-step.update\":\"/pm/settings/wip-step/{id}\",\"pm.settings.wip-step.show\":\"/pm/settings/wip-step/{id}/show\",\"pm.settings.production-formula.index\":\"/pm/settings/production-formula\",\"pm.settings.production-formula.create\":\"/pm/settings/production-formula/create\",\"pm.settings.production-formula.store\":\"/pm/settings/production-formula\",\"pm.settings.production-formula.edit\":\"/pm/settings/production-formula/{id}/edit\",\"pm.settings.production-formula.update\":\"/pm/settings/production-formula/{id}\",\"pm.settings.production-formula.show\":\"/pm/settings/production-formula/{id}/show\",\"pm.settings.production-formula.copy\":\"/pm/settings/production-formula/copy/{id}\",\"pm.settings.production-formula.approve\":\"/pm/settings/production-formula/{id}/approve\",\"pm.settings.save-publication-layout.index\":\"/pm/settings/save-publication-layout\",\"pm.settings.save-publication-layout.store\":\"/pm/settings/save-publication-layout-store\",\"pm.settings.machine-relation.index\":\"/pm/settings/machine-relation\",\"pm.settings.machine-relation.create\":\"/pm/settings/machine-relation/create\",\"pm.settings.machine-relation.store\":\"/pm/settings/machine-relation\",\"pm.settings.machine-relation.edit\":\"/pm/settings/machine-relation/{id}/edit\",\"pm.settings.machine-relation.update\":\"/pm/settings/machine-relation/{id}\",\"pm.settings.setup-min-max-by-item.index\":\"/pm/settings/setup-min-max-by-item\",\"pm.settings.setup-min-max-by-item.updateOrCreate\":\"/pm/settings/setup-min-max-by-item/updateOrCreate\",\"pm.settings.setup-transfer.index\":\"/pm/settings/setup-transfer\",\"pm.settings.setup-transfer.edit\":\"/pm/settings/setup-transfer/edit/{id}\",\"pm.settings.setup-transfer.update\":\"/pm/settings/setup-transfer/update\",\"pm.settings.setup-transfer.create\":\"/pm/settings/setup-transfer/create\",\"pm.settings.setup-transfer.store\":\"/pm/settings/setup-transfer/store\",\"pm.settings.print-conversion.index\":\"/pm/settings/print-conversion\",\"pm.settings.print-conversion.createOrUpdate\":\"/pm/settings/print-conversion/createOrUpdate\",\"pm.settings.print-product-type.index\":\"/pm/settings/print-product-type\",\"pm.settings.print-product-type.update\":\"/pm/settings/print-product-type/update\",\"pm.0001.index\":\"/pm/0001\",\"pm.0001.show\":\"/pm/0001\",\"pm.production-order.index\":\"/pm/0001\",\"pm.production-order.show\":\"/pm/0001\",\"pm.0002.index\":\"/pm/0002\",\"pm.request-creation.index\":\"/pm/0002\",\"pm.0003.index\":\"/pm/0003\",\"pm.annual-production-plan.index\":\"/pm/0003\",\"pm.0004.index\":\"/pm/0004\",\"pm.0005.index\":\"/pm/0005/{id?}\",\"pm.request-materials.index\":\"/pm/0005/{id?}\",\"pm.0005-2.index\":\"/pm/0005-2/{id?}\",\"pm.0006.index\":\"/pm/0006\",\"pm.0006.jobs\":\"/pm/0006/jobs/{batchNo}\",\"pm.report-product-in-process.index\":\"/pm/0006\",\"pm.report-product-in-process.jobs\":\"/pm/0006/jobs/{batchNo}\",\"pm.0007.index\":\"/pm/0007\",\"pm.cut-raw-material.index\":\"/pm/0007\",\"pm.0008.index\":\"/pm/0008\",\"pm.inventory-list.index\":\"/pm/0008\",\"pm.0009.index\":\"/pm/0009\",\"pm.test-raw-material.index\":\"/pm/0009\",\"pm.0010.index\":\"/pm/0010\",\"pm.review-complete.index\":\"/pm/0010\",\"pm.0011.index\":\"/pm/0011\",\"pm.planning-job-lines.index\":\"/pm/0011\",\"pm.0012.index\":\"/pm/0012\",\"pm.0013.index\":\"/pm/0013\",\"pm.record-tobacco-usage-zone-c48.index\":\"/pm/0013\",\"pm.0014.index\":\"/pm/0014\",\"pm.0015.index\":\"/pm/0015\",\"pm.regional-tobacco-production-planning.index\":\"/pm/0015\",\"pm.0016.index\":\"/pm/0016\",\"pm.0017.index\":\"/pm/0017\",\"pm.domestic-printing-production-planning.index\":\"/pm/0017\",\"pm.0018.index\":\"/pm/0018\",\"pm.fortnightly-tobacco-production-order.index\":\"/pm/0018\",\"pm.0019.index\":\"/pm/0019\",\"pm.fortnightly-raw-material-request.index\":\"/pm/0019\",\"pm.0020.index\":\"/pm/0020\",\"pm.0020.show\":\"/pm/0020/{id}\",\"pm.machine-ingredient-requests.index\":\"/pm/0020\",\"pm.machine-ingredient-requests.show\":\"/pm/0020/{id}\",\"pm.0021.index\":\"/pm/0021\",\"pm.ingredient-requests.index\":\"/pm/0021\",\"pm.0022.index\":\"/pm/0022\",\"pm.ingredient-preparation-list.index\":\"/pm/0022\",\"pm.0023.index\":\"/pm/0023\",\"pm.0023.rawMaterials\":\"/pm/0023/rawMaterials/{id}\",\"pm.0023.compareRawMaterials\":\"/pm/0023/compareRawMaterials\",\"pm.transaction-pnk-check-material.index\":\"/pm/0023\",\"pm.transaction-pnk-check-material.rawMaterials\":\"/pm/0023/rawMaterials/{id}\",\"pm.transaction-pnk-check-material.compareRawMaterials\":\"/pm/0023/compareRawMaterials\",\"pm.0024.index\":\"/pm/0024\",\"pm.transaction-pnk-material-transfer.index\":\"/pm/0024\",\"pm.0025.index\":\"/pm/0025\",\"pm.confirm-orders.index\":\"/pm/0025\",\"pm.0026.index\":\"/pm/0026\",\"pm.finished-products-storing-record.index\":\"/pm/0026\",\"pm.0027.index\":\"/pm/0027\",\"pm.0027.show\":\"/pm/0027/{date}\",\"pm.sample-cigarettes.index\":\"/pm/0027\",\"pm.sample-cigarettes.show\":\"/pm/0027/{date}\",\"pm.0028.index\":\"/pm/0028\",\"pm.0028.date\":\"/pm/0028/{date}\",\"pm.free-products.index\":\"/pm/0028\",\"pm.free-products.date\":\"/pm/0028/{date}\",\"pm.0029.index\":\"/pm/0029\",\"pm.ingredient-inventory.index\":\"/pm/0029\",\"pm.0030.index\":\"/pm/0030\",\"pm.confirm-production-yield-loss-for-tips.index\":\"/pm/0030\",\"pm.0031.index\":\"/pm/0031\",\"pm.0032.index\":\"/pm/0032\",\"pm.0032.show\":\"/pm/0032/{stampHeaderId}\",\"pm.0032.create\":\"/pm/0032\",\"pm.stamp-using.index\":\"/pm/0032\",\"pm.stamp-using.show\":\"/pm/0032/{stampHeaderId}\",\"pm.stamp-using.create\":\"/pm/0032\",\"pm.0033.index\":\"/pm/0033\",\"pm.confirm-stamp-using.index\":\"/pm/0033\",\"pm.0034.index\":\"/pm/0034\",\"pm.planning-produce-monthly.index\":\"/pm/0034\",\"pm.0035.index\":\"/pm/0035\",\"pm.receive-raw-material-transfer-at-temporary-storage.index\":\"/pm/0035\",\"pm.0036.index\":\"/pm/0036\",\"pm.close-product-order.index\":\"/pm/0036\",\"pm.0037.index\":\"/pm/0037\",\"pm.raw-material-preparation.index\":\"/pm/0037\",\"pm.0038.index\":\"/pm/0038\",\"pm.production-order-list.index\":\"/pm/0038\",\"pm.0039.index\":\"/pm/0039\",\"pm.additive-inventory-alert.index\":\"/pm/additive-inventory-alert\",\"pm.0040.index\":\"/pm/0040\",\"pm.raw-material-inventory-alert.index\":\"/pm/raw-material-inventory-alert\",\"pm.0041.index\":\"/pm/0041\",\"pm.examine-casing-after-expiry-date.index\":\"/pm/0041\",\"pm.0042.index\":\"/pm/0042\",\"pm.approval-casing-new-expiry-date.index\":\"/pm/0042\",\"pm.0043.index\":\"/pm/0043\",\"pm.transfer-finish-goods.index\":\"/pm/0043\",\"pm.0044.index\":\"/pm/0044\",\"pm.0045.index\":\"/pm/0045\",\"pm.dbLookupExample.index\":\"/pm/dbLookupExample\",\"pm.plans.yearly\":\"/pm/plans/yearly\",\"pm.plans.monthly\":\"/pm/plans/monthly\",\"pm.plans.biweekly\":\"/pm/plans/biweekly\",\"pm.plans.daily\":\"/pm/plans/daily\",\"pm.products.machine-requests.index\":\"/pm/products/machine-requests\",\"pm.products.transfers.index\":\"/pm/products/transfers\",\"pm.files.image\":\"/pm/files/image/{module}/{menu}/{feature}/{fileName}\",\"pm.files.image-thumbnail\":\"/pm/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}\",\"pm.files.download\":\"/pm/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}\",\"pp.0000.index\":\"/pp/0000\",\"pp.example.index\":\"/pp/0000\",\"pp.0001.index\":\"/pp/0001\",\"pp.0002.index\":\"/pp/0002\",\"pp.0003.index\":\"/pp/0003\",\"pp.0004.index\":\"/pp/0004\",\"pp.0005.index\":\"/pp/0005\",\"pp.0006.index\":\"/pp/0006\",\"pp.0007.index\":\"/pp/0007\",\"pp.0008.index\":\"/pp/0008\",\"eam.ajax.lov.asset-number\":\"/eam/ajax/lov/assetnumber\",\"eam.ajax.lov.asset-v-asset-number\":\"/eam/ajax/lov/assetv/assetnumber\",\"eam.ajax.lov.child-asset-number\":\"/eam/ajax/lov/child-assetnumber/{p_parent}\",\"eam.ajax.lov.departments\":\"/eam/ajax/lov/departments\",\"eam.ajax.lov.work-request-status\":\"/eam/ajax/lov/work-request-status\",\"eam.ajax.lov.employee\":\"/eam/ajax/lov/employee\",\"eam.ajax.lov.work-request-type\":\"/eam/ajax/lov/work-request-type\",\"eam.ajax.lov.activity-priority\":\"/eam/ajax/lov/activity-priority\",\"eam.ajax.lov.work-request-number\":\"/eam/ajax/lov/work-request-number\",\"eam.ajax.lov.work-order-h-id\":\"/eam/ajax/lov/workorderhvid\",\"eam.ajax.lov.work-order-op-numseq\":\"/eam/ajax/lov/workorderopnumseq\",\"eam.ajax.lov.wip-class\":\"/eam/ajax/lov/wipclass\",\"eam.ajax.lov.dep-resource\":\"/eam/ajax/lov/dep-resource\",\"eam.ajax.lov.status-yn\":\"/eam/ajax/lov/status-yn\",\"eam.ajax.lov.item-inventory\":\"/eam/ajax/lov/item-inventory\",\"eam.ajax.lov.item-nonstock\":\"/eam/ajax/lov/item-nonstock\",\"eam.ajax.lov.material-type\":\"/eam/ajax/lov/material-type\",\"eam.ajax.lov.suvinventory\":\"/eam/ajax/lov/suvinventory\",\"eam.ajax.lov.locatorv\":\"/eam/ajax/lov/locatorv\",\"eam.ajax.lov.asset-activity\":\"/eam/ajax/lov/assetactivity\",\"eam.ajax.lov.issue\":\"/eam/ajax/lov/issue\",\"eam.ajax.lov.work-order-status\":\"/eam/ajax/lov/work-order-status\",\"eam.ajax.lov.work-order-type\":\"/eam/ajax/lov/work-order-type\",\"eam.ajax.lov.shutdown-type\":\"/eam/ajax/lov/shutdown-type\",\"eam.ajax.lov.work-order-re-numseq\":\"/eam/ajax/lov/workorderrenumseq\",\"eam.ajax.lov.work-order-re-resource\":\"/eam/ajax/lov/workorderreresource\",\"eam.ajax.lov.area\":\"/eam/ajax/lov/area\",\"eam.ajax.lov.resource-asset-number\":\"/eam/ajax/lov/resource-asset-number\",\"eam.ajax.lov.asset-group\":\"/eam/ajax/lov/asset-group\",\"eam.ajax.lov.production-organization\":\"/eam/ajax/lov/production-organization\",\"eam.ajax.lov.usage-uom\":\"/eam/ajax/lov/usage-uom\",\"eam.ajax.lov.resource-asset-locator\":\"/eam/ajax/lov/resource-asset-locator\",\"eam.ajax.lov.operation\":\"/eam/ajax/lov/operation\",\"eam.ajax.lov.machine-type\":\"/eam/ajax/lov/machine-type\",\"eam.ajax.lov.period-year\":\"/eam/ajax/lov/period-year\",\"eam.ajax.lov.activity\":\"/eam/ajax/lov/activity\",\"eam.ajax.lov.wo-mt-lot\":\"/eam/ajax/lov/wo-mt-lot\",\"eam.ajax.lov.organization\":\"/eam/ajax/lov/organization\",\"eam.ajax.lov.department-resources\":\"/eam/ajax/lov/department-resources\",\"eam.ajax.lov.asset-resources\":\"/eam/ajax/lov/asset-resources\",\"eam.ajax.lov.request-equip-no\":\"/eam/ajax/lov/request-equip-no\",\"eam.ajax.lov.request-status\":\"/eam/ajax/lov/request-status\",\"eam.ajax.lov.period-name\":\"/eam/ajax/lov/period-name\",\"eam.ajax.lov.resource\":\"/eam/ajax/lov/resource\",\"eam.ajax.lov.job-status\":\"/eam/ajax/lov/jobstatus\",\"eam.ajax.lov.resource-employee\":\"/eam/ajax/lov/resource-employee\",\"eam.ajax.work-requests.permission-approve\":\"/eam/ajax/work-requests/permission-approve\",\"eam.ajax.work-requests.cancel\":\"/eam/ajax/work-requests/cancel/{p_work_request_number}\",\"eam.ajax.work-requests.cancel-approval\":\"/eam/ajax/work-requests/cancel-approval/{p_work_request_number}\",\"eam.ajax.work-requests.store\":\"/eam/ajax/work-requests\",\"eam.ajax.work-requests.update-status\":\"/eam/ajax/work-requests/status\",\"eam.ajax.work-requests.report\":\"/eam/ajax/work-requests/report\",\"eam.ajax.work-requests.send-approve\":\"/eam/ajax/work-requests/send-approve/{p_work_request_id}\",\"eam.ajax.work-requests.search\":\"/eam/ajax/work-requests/search\",\"eam.ajax.work-requests.images.index\":\"/eam/ajax/work-requests/images/{p_work_request_id}\",\"eam.ajax.work-requests.images.upload\":\"/eam/ajax/work-requests/images/{p_work_request_id}\",\"eam.ajax.work-requests.images.delete\":\"/eam/ajax/work-requests/images/{p_attachment_id}\",\"eam.ajax.work-requests.images.show\":\"/eam/ajax/work-requests/images/show/{p_attachment_id}\",\"eam.ajax.work-requests.show\":\"/eam/ajax/work-requests/{p_work_request_number}\",\"eam.ajax.check-on-hand.search\":\"/eam/ajax/check-on-hand/search\",\"eam.ajax.check-on-hand.images\":\"/eam/ajax/check-on-hand/images/{p_item_code}\",\"eam.ajax.check-on-hand.image.upload\":\"/eam/ajax/check-on-hand/image/{p_item_code}\",\"eam.ajax.check-on-hand.image.delete\":\"/eam/ajax/check-on-hand/image/{p_attachment_id}\",\"eam.ajax.check-on-hand.image.show\":\"/eam/ajax/check-on-hand/image/{p_attachment_id}\",\"eam.ajax.check-transaction.search\":\"/eam/ajax/check-transaction/search\",\"eam.ajax.resource-asset.show\":\"/eam/ajax/resource-asset/show/{p_asset_number}\",\"eam.ajax.resource-asset.store\":\"/eam/ajax/resource-asset/save\",\"eam.ajax.resource-asset.asset-category\":\"/eam/ajax/resource-asset/asset-category\",\"eam.ajax.resource-asset.asset-category-subgroup\":\"/eam/ajax/resource-asset/asset-category/sub-group\",\"eam.ajax.resource-asset.asset-category-submachine\":\"/eam/ajax/resource-asset/asset-category/sub-machine\",\"eam.ajax.work-order.head.index\":\"/eam/ajax/work-order/head\",\"eam.ajax.work-order.head.show\":\"/eam/ajax/work-order/head/show/{p_wip_entity_name}\",\"eam.ajax.work-order.head.store\":\"/eam/ajax/work-order/head/save\",\"eam.ajax.work-order.head.delete\":\"/eam/ajax/work-order/head/delete\",\"eam.ajax.work-order.head.waiting-confirm\":\"/eam/ajax/work-order/head/waiting-confirm\",\"eam.ajax.work-order.head.update-status\":\"/eam/ajax/work-order/head/status\",\"eam.ajax.work-order.head.close-jp\":\"/eam/ajax/work-order/head/close-jp/{p_wip_entity_name}\",\"eam.ajax.work-order.op.all\":\"/eam/ajax/work-order/op/all/{p_wip_entity_id}\",\"eam.ajax.work-order.op.store\":\"/eam/ajax/work-order/op/save\",\"eam.ajax.work-order.op.delete\":\"/eam/ajax/work-order/op/delete\",\"eam.ajax.work-order.re.all\":\"/eam/ajax/work-order/re/all/{p_wip_entity_id}\",\"eam.ajax.work-order.report\":\"/eam/ajax/work-order/report\",\"eam.ajax.work-order.report.part\":\"/eam/ajax/work-order/report-part\",\"eam.ajax.work-order.re.store\":\"/eam/ajax/work-order/re/save\",\"eam.ajax.work-order.re.delete\":\"/eam/ajax/work-order/re/delete\",\"eam.ajax.work-order.mt.all\":\"/eam/ajax/work-order/mt/all/{p_wip_entity_id}\",\"eam.ajax.work-order.mt.store\":\"/eam/ajax/work-order/mt/save\",\"eam.ajax.work-order.mt.delete\":\"/eam/ajax/work-order/mt/delete\",\"eam.ajax.work-order.mt.return\":\"/eam/ajax/work-order/mt/return\",\"eam.ajax.work-order.mt.issue\":\"/eam/ajax/work-order/mt/issue\",\"eam.ajax.work-order.lb.all\":\"/eam/ajax/work-order/lb/all/{p_wip_entity_id}\",\"eam.ajax.work-order.lb.store\":\"/eam/ajax/work-order/lb/save\",\"eam.ajax.work-order.lb.delete\":\"/eam/ajax/work-order/lb/delete\",\"eam.ajax.work-order.cp.all\":\"/eam/ajax/work-order/cp/all/{p_wip_entity_id}\",\"eam.ajax.work-order.cp.store\":\"/eam/ajax/work-order/cp/save\",\"eam.ajax.work-order.cost.all\":\"/eam/ajax/work-order/cost/all/{p_wip_entity_id}\",\"eam.ajax.work-order.itemcost.get\":\"/eam/ajax/work-order/item-cost\",\"eam.ajax.work-order.itemonhand.get\":\"/eam/ajax/work-order/item-onhand\",\"eam.ajax.work-order.default-wip-class\":\"/eam/ajax/work-order/defaultwipclass\",\"eam.ajax.work-order.report.summary-month\":\"/eam/ajax/work-order/report/summary-month\",\"eam.ajax.work-order.report.summary-month-excel\":\"/eam/ajax/work-order/report/summary-month-excel\",\"eam.ajax.work-order.report.payable\":\"/eam/ajax/work-order/report/payable\",\"eam.ajax.work-order.report.close-wo-jp\":\"/eam/ajax/work-order/report/close-wo-jp\",\"eam.ajax.work-order.report.mnt-history\":\"/eam/ajax/work-order/report/mnt-history\",\"eam.ajax.work-order.report.maintenance-excel\":\"/eam/ajax/work-order/report/maintenance-excel\",\"eam.ajax.work-order.report.purchase-excel\":\"/eam/ajax/work-order/report/purchase-excel\",\"eam.ajax.work-order.report.job-account\":\"/eam/ajax/work-order/report/job-account\",\"eam.ajax.work-order.report.labor-account\":\"/eam/ajax/work-order/report/labor-account\",\"eam.ajax.work-order.report.wo-cost\":\"/eam/ajax/work-order/report/wo-cost\",\"eam.ajax.work-order.report.labor-excel\":\"/eam/ajax/work-order/report/labor-excel\",\"eam.ajax.work-order.report.summary-labor\":\"/eam/ajax/work-order/report/summary-labor\",\"eam.ajax.work-order.report.receipt-mat\":\"/eam/ajax/work-order/report/receipt-mat\",\"eam.ajax.plan.version-plan\":\"/eam/ajax/plan/version_plan/{p_year}\",\"eam.ajax.plan.confirm\":\"/eam/ajax/plan/confirm/{p_plan_id}\",\"eam.ajax.plan.store\":\"/eam/ajax/plan\",\"eam.ajax.plan.search\":\"/eam/ajax/plan/{p_year}/{p_version}\",\"eam.ajax.plan.open-work-order\":\"/eam/ajax/plan/work-order\",\"eam.ajax.plan.delete-line\":\"/eam/ajax/plan/line/{p_plan_id}\",\"eam.ajax.plan.file-import\":\"/eam/ajax/plan/file-import\",\"eam.ajax.bill-materials.show\":\"/eam/ajax/bill-materials\",\"eam.ajax.bill-materials.store\":\"/eam/ajax/bill-materials\",\"eam.ajax.bill-materials.delete-line\":\"/eam/ajax/bill-materials\",\"eam.ajax.report.issue-mat-excel\":\"/eam/ajax/report/issue-mat-excel\",\"eam.ajax.report.closed-wo\":\"/eam/ajax/report/closed-wo\",\"eam.ajax.report.closed-wo2\":\"/eam/ajax/report/closed-wo2\",\"eam.ajax.report.job-account-del\":\"/eam/ajax/report/job-account-del\",\"eam.ajax.report.request-mat-inv\":\"/eam/ajax/report/request-mat-inv\",\"eam.ajax.report.request-mat-non\":\"/eam/ajax/report/request-mat-non\",\"eam.ajax.report.wo-com-status\":\"/eam/ajax/report/wo-com-status\",\"eam.ajax.report.summary-mat-status\":\"/eam/ajax/report/summary-mat-status\",\"eam.work-requests.create\":\"/eam/work-requests/create\",\"eam.work-requests.index\":\"/eam/work-requests\",\"eam.work-requests.waiting-approve\":\"/eam/work-requests/waiting-approve\",\"eam.work-orders.create\":\"/eam/work-orders/create\",\"eam.work-orders.waiting-open-work\":\"/eam/work-orders/waiting-open-work\",\"eam.work-orders.list-all-repair-jobs\":\"/eam/work-orders/list-all-repair-jobs\",\"eam.work-orders.list-repair-jobs-waiting-close\":\"/eam/work-orders/list-repair-jobs-waiting-close\",\"eam.work-orders.confirmed-list-repair-work\":\"/eam/work-orders/confirmed-list-repair-work\",\"eam.ask-for-information.parts-transferred-warehouse\":\"/eam/ask-for-information/parts-transferred-warehouse\",\"eam.ask-for-information.check-spare-parts-inventory\":\"/eam/ask-for-information/check-spare-parts-inventory\",\"eam.setup.machine\":\"/eam/setup/machine\",\"eam.transaction.preventive-maintenance-plan\":\"/eam/transaction/preventive-maintenance-plan\",\"eam.report.bill-materials\":\"/eam/report/bill-materials\",\"eam.report.summary-month\":\"/eam/report/summary-month\",\"eam.report.summary-month-excel\":\"/eam/report/summary-month-excel\",\"eam.report.issue-mat-excel\":\"/eam/report/issue-mat-excel\",\"eam.report.payable\":\"/eam/report/payable\",\"eam.report.closed-wo\":\"/eam/report/closed-wo\",\"eam.report.closed-wo2\":\"/eam/report/closed-wo2\",\"eam.report.closed-wo-jp\":\"/eam/report/closed-wo-jp\",\"eam.report.mnt-history\":\"/eam/report/mnt-history\",\"eam.report.maintenance\":\"/eam/report/maintenance\",\"eam.report.job-account-del\":\"/eam/report/job-account-del\",\"eam.report.purchase\":\"/eam/report/purchase\",\"eam.report.request-mat-inv\":\"/eam/report/request-mat-inv\",\"eam.report.request-mat-non\":\"/eam/report/request-mat-non\",\"eam.report.job-account\":\"/eam/report/job-account\",\"eam.report.labor-account\":\"/eam/report/labor-account\",\"eam.report.wo-com-status\":\"/eam/report/wo-com-status\",\"eam.report.labor\":\"/eam/report/labor\",\"eam.report.wo-cost\":\"/eam/report/wo-cost\",\"eam.report.summary-labor\":\"/eam/report/summary-labor\",\"eam.report.receipt-mat\":\"/eam/report/receipt-mat\",\"eam.report.summary-mat-status\":\"/eam/report/summary-mat-status\",\"om.ajax.\":\"/om/ajax/debitnote_ranchtran/getorderlist\",\"om.ajax.coa-mapping.index\":\"/om/ajax/coa-mapping\",\"om.ajax.vendor.index\":\"/om/ajax/vendor\",\"om.ajax.search-order.index\":\"/om/ajax/search-order\",\"om.ajax.get-order.index\":\"/om/ajax/get-order\",\"om.ajax.get-item-cate.index\":\"/om/ajax/get-item-cate\",\"om.ajax.get-item.index\":\"/om/ajax/get-item\",\"om.ajax.get-bank-branchs.index\":\"/om/ajax/get-bank-branchs\",\"om.ajax.get-check-header.index\":\"/om/ajax/get-check-header\",\"om.ajax.get-check-header-date-to.index\":\"/om/ajax/get-check-header-date-to\",\"om.settings.term.index\":\"/om/settings/term\",\"om.settings.term.create\":\"/om/settings/term/create\",\"om.settings.term.store\":\"/om/settings/term\",\"om.settings.term.edit\":\"/om/settings/term/{term}/edit\",\"om.settings.term.update\":\"/om/settings/term/{term}\",\"om.settings.term-export.index\":\"/om/settings/term-export\",\"om.settings.term-export.create\":\"/om/settings/term-export/create\",\"om.settings.term-export.store\":\"/om/settings/term-export\",\"om.settings.term-export.edit\":\"/om/settings/term-export/{term}/edit\",\"om.settings.term-export.update\":\"/om/settings/term-export/{term}\",\"om.settings.country.index\":\"/om/settings/country\",\"om.settings.country.create\":\"/om/settings/country/create\",\"om.settings.country.store\":\"/om/settings/country\",\"om.settings.country.edit\":\"/om/settings/country/{id}/edit\",\"om.settings.country.update\":\"/om/settings/country/{id}\",\"om.settings.customer.index\":\"/om/settings/customer\",\"om.settings.customer.create\":\"/om/settings/customer/create\",\"om.settings.customer.store\":\"/om/settings/customer\",\"om.settings.customer.edit\":\"/om/settings/customer/{id}/edit\",\"om.settings.customer.update\":\"/om/settings/customer/{id}\",\"om.settings.customer.primary-approval\":\"/om/settings/customer/primary-approval\",\"om.settings.sequence-ecom.index\":\"/om/settings/sequence-ecom\",\"om.settings.sequence-ecom.create\":\"/om/settings/sequence-ecom/create\",\"om.settings.sequence-ecom.store\":\"/om/settings/sequence-ecom\",\"om.settings.sequence-ecom.edit\":\"/om/settings/sequence-ecom/{ecom}/edit\",\"om.settings.sequence-ecom.update\":\"/om/settings/sequence-ecom/{ecom}\",\"om.settings.quota-credit-group.index\":\"/om/settings/quota-credit-group\",\"om.settings.quota-credit-group.create\":\"/om/settings/quota-credit-group/create\",\"om.settings.quota-credit-group.store\":\"/om/settings/quota-credit-group\",\"om.settings.quota-credit-group.edit\":\"/om/settings/quota-credit-group/{id}/edit\",\"om.settings.quota-credit-group.update\":\"/om/settings/quota-credit-group/{id}\",\"om.settings.grant-spacial-case.index\":\"/om/settings/grant-spacial-case\",\"om.settings.grant-spacial-case.create\":\"/om/settings/grant-spacial-case/create\",\"om.settings.grant-spacial-case.store\":\"/om/settings/grant-spacial-case\",\"om.settings.grant-spacial-case.edit\":\"/om/settings/grant-spacial-case/{id}/edit\",\"om.settings.grant-spacial-case.update\":\"/om/settings/grant-spacial-case/{id}\",\"om.settings.grant-spacial-case.delete\":\"/om/settings/grant-spacial-case/{id}\",\"om.settings.authority-list.index\":\"/om/settings/authority-list\",\"om.settings.authority-list.create\":\"/om/settings/authority-list/create\",\"om.settings.authority-list.store\":\"/om/settings/authority-list\",\"om.settings.authority-list.edit\":\"/om/settings/authority-list/{id}/edit\",\"om.settings.authority-list.update\":\"/om/settings/authority-list/{id}\",\"om.settings.over-quota-approval.index\":\"/om/settings/over-quota-approval\",\"om.settings.over-quota-approval.create\":\"/om/settings/over-quota-approval/create\",\"om.settings.over-quota-approval.store\":\"/om/settings/over-quota-approval\",\"om.settings.over-quota-approval.edit\":\"/om/settings/over-quota-approval/{id}/edit\",\"om.settings.over-quota-approval.update\":\"/om/settings/over-quota-approval/{id}\",\"om.settings.over-quota-approval.delete\":\"/om/settings/over-quota-approval/{id}\",\"om.settings.item-weight.index\":\"/om/settings/item-weight\",\"om.settings.item-weight.create\":\"/om/settings/item-weight/create\",\"om.settings.item-weight.store\":\"/om/settings/item-weight\",\"om.settings.item-weight.edit\":\"/om/settings/item-weight/{id}/edit\",\"om.settings.item-weight.update\":\"/om/settings/item-weight/{id}\",\"om.settings.thailand-territory.index\":\"/om/settings/thailand-territory\",\"om.settings.thailand-territory.preview-import\":\"/om/settings/thailand-territory/preview-import\",\"om.settings.thailand-territory.import\":\"/om/settings/thailand-territory/import\",\"om.settings.thailand-territory.download-excel-template\":\"/om/settings/thailand-territory/download-excel-template\",\"om.settings.direct-debit-domestic.index\":\"/om/settings/direct-debit-domestic\",\"om.settings.direct-debit-domestic.create\":\"/om/settings/direct-debit-domestic/create\",\"om.settings.direct-debit-domestic.store\":\"/om/settings/direct-debit-domestic\",\"om.settings.direct-debit-domestic.edit\":\"/om/settings/direct-debit-domestic/{id}/edit\",\"om.settings.direct-debit-domestic.update\":\"/om/settings/direct-debit-domestic/{id}\",\"om.settings.direct-debit-export.index\":\"/om/settings/direct-debit-export\",\"om.settings.direct-debit-export.create\":\"/om/settings/direct-debit-export/create\",\"om.settings.direct-debit-export.store\":\"/om/settings/direct-debit-export\",\"om.settings.direct-debit-export.edit\":\"/om/settings/direct-debit-export/{id}/edit\",\"om.settings.direct-debit-export.update\":\"/om/settings/direct-debit-export/{id}\",\"om.settings.not-auto-release.index\":\"/om/settings/not-auto-release\",\"om.settings.not-auto-release.create\":\"/om/settings/not-auto-release/create\",\"om.settings.not-auto-release.store\":\"/om/settings/not-auto-release\",\"om.settings.not-auto-release.edit\":\"/om/settings/not-auto-release/{id}/edit\",\"om.settings.not-auto-release.update\":\"/om/settings/not-auto-release/{id}\",\"om.settings.approver-order.index\":\"/om/settings/approver-order\",\"om.settings.approver-order.create\":\"/om/settings/approver-order/create\",\"om.settings.approver-order.store\":\"/om/settings/approver-order\",\"om.settings.approver-order.edit\":\"/om/settings/approver-order/{id}/edit\",\"om.settings.approver-order.update\":\"/om/settings/approver-order/{id}\",\"om.settings.account-mapping.index\":\"/om/settings/account-mapping\",\"om.settings.account-mapping.create\":\"/om/settings/account-mapping/create\",\"om.settings.account-mapping.store\":\"/om/settings/account-mapping\",\"om.settings.account-mapping.edit\":\"/om/settings/account-mapping/{id}/edit\",\"om.settings.account-mapping.update\":\"/om/settings/account-mapping/{id}\",\"om.settings.transport-owner.index\":\"/om/settings/transport-owner\",\"om.settings.transport-owner.create\":\"/om/settings/transport-owner/create\",\"om.settings.transport-owner.store\":\"/om/settings/transport-owner\",\"om.settings.transport-owner.edit\":\"/om/settings/transport-owner/{id}/edit\",\"om.settings.transport-owner.update\":\"/om/settings/transport-owner/{id}\",\"om.settings.transport-owner.delete\":\"/om/settings/transport-owner/{id}\",\"om.settings.transportation-route.index\":\"/om/settings/transportation-route\",\"om.settings.transportation-route.create\":\"/om/settings/transportation-route/create\",\"om.settings.transportation-route.store\":\"/om/settings/transportation-route\",\"om.settings.transportation-route.edit\":\"/om/settings/transportation-route/{id}/edit\",\"om.settings.transportation-route.update\":\"/om/settings/transportation-route/{id}\",\"om.settings.transportation-route.delete\":\"/om/settings/transportation-route/{id}\",\"om.settings.order-period.index\":\"/om/settings/order-period\",\"om.settings.order-period.create\":\"/om/settings/order-period/create\",\"om.settings.order-period.store\":\"/om/settings/order-period\",\"om.settings.order-period.edit\":\"/om/settings/order-period/{id}/edit\",\"om.settings.order-period.update\":\"/om/settings/order-period/{id}\",\"om.settings.price-list.index\":\"/om/settings/price-list\",\"om.settings.price-list.create\":\"/om/settings/price-list/create\",\"om.settings.price-list.store\":\"/om/settings/price-list\",\"om.settings.price-list.show\":\"/om/settings/price-list/{id}/show\",\"om.settings.price-list.edit\":\"/om/settings/price-list/{id}/edit\",\"om.settings.price-list.update\":\"/om/settings/price-list/{id}\",\"om.settings.price-list-export.index\":\"/om/settings/price-list-export\",\"om.settings.price-list-export.create\":\"/om/settings/price-list-export/create\",\"om.settings.price-list-export.store\":\"/om/settings/price-list-export\",\"om.settings.price-list-export.show\":\"/om/settings/price-list-export/{id}/show\",\"om.settings.price-list-export.edit\":\"/om/settings/price-list-export/{id}/edit\",\"om.settings.price-list-export.update\":\"/om/settings/price-list-export/{id}\",\"om.ajax.customers.exports.exports.list\":\"/om/ajax/customers/exports/list\",\"om.ajax.customers.exports.exports.type\":\"/om/ajax/customers/exports/type\",\"om.ajax.customers.exports.exports.country\":\"/om/ajax/customers/exports/country\",\"om.ajax.customers.exports.\":\"/om/ajax/customers/exports/delcustomershipping/{id}\",\"om.ajax.customers.exports.foreign.customercontact_list\":\"/om/ajax/customers/exports/customercontact_list/{id}\",\"om.ajax.customers.exports.foreign.customershipping_list\":\"/om/ajax/customers/exports/customershipping_list/{id}\",\"om.ajax.customers.exports.foreign.insertcustomercontact\":\"/om/ajax/customers/exports/insertcustomercontact/{id}\",\"om.ajax.customers.exports.foreign.updatecustomercontact\":\"/om/ajax/customers/exports/updatecustomercontact/{id}\",\"om.ajax.customers.exports.foreign.insertcustomershipping\":\"/om/ajax/customers/exports/insertcustomershipping/{id}\",\"om.ajax.customers.exports.foreign.updatecustomershipping\":\"/om/ajax/customers/exports/updatecustomershipping/{id}\",\"om.ajax.customers.domestics.\":\"/om/ajax/customers/domestics/remove\",\"om.ajax.customers.domestics.domestics.insert.customers\":\"/om/ajax/customers/domestics/insert-customers\",\"om.ajax.customers.domestics.domestics.insert.customers-shipsites\":\"/om/ajax/customers/domestics/insert-customers-shipsites\",\"om.ajax.customers.domestics.domestics.insert.customers-previous\":\"/om/ajax/customers/domestics/insert-customers-previous\",\"om.ajax.customers.domestics.domestics.insert.customers-owner\":\"/om/ajax/customers/domestics/insert-customers-owner\",\"om.ajax.customers.domestics.domestics.insert.customers-contracts\":\"/om/ajax/customers/domestics/insert-customers-contracts\",\"om.ajax.customers.domestics.domestics.insert.customers-contractbooks\":\"/om/ajax/customers/domestics/insert-customers-contractbooks\",\"om.ajax.customers.domestics.domestics.insert.customers-contractgroup\":\"/om/ajax/customers/domestics/insert-customers-contractgroup\",\"om.ajax.customers.domestics.domestics.insert.customers-quota\":\"/om/ajax/customers/domestics/insert-customers-quota\",\"om.ajax.customers.domestics.domestics.update.customers\":\"/om/ajax/customers/domestics/update-customers/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-previous\":\"/om/ajax/customers/domestics/update-customers-previous/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-owner\":\"/om/ajax/customers/domestics/update-customers-owner/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-shipsites\":\"/om/ajax/customers/domestics/update-customers-shipsites/{id}\",\"om.ajax.customers.domestics.domestics.update.customers-quota\":\"/om/ajax/customers/domestics/update-customers-quota/{id}\",\"om.ajax.customers.domestics.previous\":\"/om/ajax/customers/domestics/previous/{id}\",\"om.ajax.customers.domestics.owner\":\"/om/ajax/customers/domestics/owner/{id}\",\"om.ajax.customers.domestics.quota-headers\":\"/om/ajax/customers/domestics/quota-headers/{id}\",\"om.ajax.customers.domestics.ship-sites\":\"/om/ajax/customers/domestics/ship-sites/{id}\",\"om.ajax.customers.domestics.quota.lines.items\":\"/om/ajax/customers/domestics/quota-lines-item/{id}\",\"om.ajax.customers.domestics.province.list\":\"/om/ajax/customers/domestics/province-list/{id}\",\"om.ajax.customers.domestics.city.list\":\"/om/ajax/customers/domestics/city-list/{id}\",\"om.ajax.customers.domestics.district.list\":\"/om/ajax/customers/domestics/district-list/{id}\",\"om.ajax.customers.domestics.postcode\":\"/om/ajax/customers/domestics/postcode/{id}\",\"om.ajax.customers.domestics.get.ship.site.name\":\"/om/ajax/customers/domestics/get-ship-site-name/{id}/{shipid}\",\"om.ajax.customers.domestics.get.customer.name\":\"/om/ajax/customers/domestics/get-customer-name/{id}\",\"om.ajax.customers.domestics.domestics.delete.customers-shipsites\":\"/om/ajax/customers/domestics/delete-customers-shipsites/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-previous\":\"/om/ajax/customers/domestics/delete-customers-previous/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-owner\":\"/om/ajax/customers/domestics/delete-customers-owner/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-contracts\":\"/om/ajax/customers/domestics/delete-customers-contracts/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-contractbooks\":\"/om/ajax/customers/domestics/delete-customers-contractbooks/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-contractgroups\":\"/om/ajax/customers/domestics/delete-customers-contractgroups/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-quota\":\"/om/ajax/customers/domestics/delete-customers-quota/{id}/{customer_id}\",\"om.ajax.customers.domestics.domestics.delete.customers-quota-line\":\"/om/ajax/customers/domestics/delete-customers-quota-line/{id}\",\"om.ajax.promotions.\":\"/om/ajax/promotions/search-group-product/{itemId}\",\"om.ajax.promotions.store\":\"/om/ajax/promotions/store\",\"om.ajax.promotions.update\":\"/om/ajax/promotions/update\",\"om.ajax.promotions.remove\":\"/om/ajax/promotions/remove\",\"om.ajax.promotions.copy\":\"/om/ajax/promotions/copy\",\"om.ajax.release_credit.\":\"/om/ajax/release-credit/customers/{id}\",\"om.ajax.bank.\":\"/om/ajax/bank/by-short-name/{id}\",\"om.ajax.postpone-delivery.\":\"/om/ajax/postpone-delivery/next-date/{number}\",\"om.ajax.postpone-delivery.period_by_years\":\"/om/ajax/postpone-delivery/period-by-years/{year}\",\"om.ajax.transfer-bi-weekly.\":\"/om/ajax/transfer-bi-weekly/testcash\",\"om.ajax.overdue-debt.\":\"/om/ajax/overdue-debt/search\",\"om.ajax.overdue-debt.get-customer-name\":\"/om/ajax/overdue-debt/get-customer-name/{id}\",\"om.ajax.fortnightly\":\"/om/ajax/fortnightly/sequence-ecom\",\"om.ajax.fortnightlyupdate.sequence.ecom\":\"/om/ajax/fortnightly/update-sequence-ecom\",\"om.ajax.fortnightlydelete.sequence.ecom\":\"/om/ajax/fortnightly/delete-sequence-ecom\",\"om.ajax.biweeklyupdate.periods\":\"/om/ajax/biweekly/update-periods\",\"om.ajax.biweeklyget.holiday\":\"/om/ajax/biweekly/get-holiday/{number}\",\"om.ajax.biweeklysearch.periods\":\"/om/ajax/biweekly/search-periods/{number}\",\"om.ajax.transfer-monthly.\":\"/om/ajax/transfer-monthly/inportexcel\",\"om.ajax.consignment-clubsearch.consignment\":\"/om/ajax/consignment-club/search-create\",\"om.ajax.consignment-clubget.order.lines\":\"/om/ajax/consignment-club/get-order-lines/{number}\",\"om.ajax.consignment-clubsearch.consignment.club\":\"/om/ajax/consignment-club/search-consignment-club\",\"om.ajax.consignment-clubupdate.consignment.club\":\"/om/ajax/consignment-club/update-consignment-club\",\"om.ajax.sale-confirmationupdate.order\":\"/om/ajax/sale-confirmation/update-order\",\"om.ajax.sale-confirmationsearch\":\"/om/ajax/sale-confirmation/search\",\"om.ajax.sale-confirmationcreate.sale.confirmation\":\"/om/ajax/sale-confirmation/create-sale-confirmation\",\"om.ajax.sale-confirmationcopy.sale.number\":\"/om/ajax/sale-confirmation/copy-sale-number/{number}\",\"om.ajax.sale-confirmationcreate.sale.number\":\"/om/ajax/sale-confirmation/create-sale-number\",\"om.ajax.sale-confirmationupdate.sale.confirmation\":\"/om/ajax/sale-confirmation/update-sale-confirmation\",\"om.ajax.sale-confirmationconfirm.sale.confirmation\":\"/om/ajax/sale-confirmation/confirm-sale-confirmation\",\"om.ajax.sale-confirmationcopy.to.proforma.invoice\":\"/om/ajax/sale-confirmation/copy-to-proforma-invoice\",\"om.ajax.sale-confirmationcheck-cancel\":\"/om/ajax/sale-confirmation/check-cancel/{number}\",\"om.ajax.sale-confirmationcancel\":\"/om/ajax/sale-confirmation/cancel\",\"om.ajax.sale-confirmationcustomer-shipsite\":\"/om/ajax/sale-confirmation/customer-shipsite/{number}\",\"om.ajax.approve-prepare-ordersearch\":\"/om/ajax/approve-prepare-order/search\",\"om.ajax.approve-prepare-ordermanage\":\"/om/ajax/approve-prepare-order/manage\",\"om.ajax.order.approveprepare.search\":\"/om/ajax/order/approveprepara/search\",\"om.ajax.order.approveprepare.search.customer\":\"/om/ajax/order/approveprepara/search/customer\",\"om.ajax.order.approveprepare.confirm\":\"/om/ajax/order/approveprepara/confirm\",\"om.ajax.order.approveprepare.cancel\":\"/om/ajax/order/approveprepara/cancel\",\"om.ajax.order.prepare.run_number\":\"/om/ajax/order/prepare/run-number\",\"om.ajax.order.prepare.data_customer\":\"/om/ajax/order/prepare/data-customer\",\"om.ajax.order.prepare.data_item\":\"/om/ajax/order/prepare/data-item\",\"om.ajax.order.prepare.set_dayamount\":\"/om/ajax/order/prepare/set-dayamount\",\"om.ajax.order.approve.search.item\":\"/om/ajax/order/approve/search\",\"om.ajax.order.approve.submit\":\"/om/ajax/order/approve/approve\",\"om.ajax.order.approve.cancel\":\"/om/ajax/order/approve/cancel\",\"om.ajax.proforma-invoicesearch.sale.number\":\"/om/ajax/proforma-invoice/search-pi-number/{number}\",\"om.ajax.proforma-invoicecreate.proforma.invoice\":\"/om/ajax/proforma-invoice/create-proforma-invoice/{number}\",\"om.ajax.proforma-invoicemanage.proforma.invoice\":\"/om/ajax/proforma-invoice/manage-proforma-invoice\",\"om.ajax.proforma-invoicecreate.proforma.lot\":\"/om/ajax/proforma-invoice/create-proforma-lot/{number}\",\"om.ajax.proforma-invoiceget.proforma.lot\":\"/om/ajax/proforma-invoice/get-proforma-lot/{number}\",\"om.ajax.proforma-invoicecheck-cancel\":\"/om/ajax/proforma-invoice/check-cancel/{number}\",\"om.ajax.proforma-invoicecancel\":\"/om/ajax/proforma-invoice/cancel\",\"om.ajax.tax-invoice-exportcreate\":\"/om/ajax/tax-invoice-export/create/{number}\",\"om.ajax.tax-invoice-exportsearch\":\"/om/ajax/tax-invoice-export/search/{number}\",\"om.ajax.tax-invoice-exportmanage\":\"/om/ajax/tax-invoice-export/manage\",\"om.ajax.tax-invoice-exportcheck-cancel\":\"/om/ajax/tax-invoice-export/check-cancel/{number}\",\"om.ajax.tax-invoice-exportcancel\":\"/om/ajax/tax-invoice-export/cancel\",\"om.ajax.tax-invoice-exportclose-work\":\"/om/ajax/tax-invoice-export/close-work/{number}\",\"om.order.approveprepareapproveprepare.index\":\"/om/order/approveprepare\",\"om.order.approveprepare\":\"/om/ajax/print-receipt/print_data\",\"om.proforma-invoicesearch.sale.number\":\"/om/proforma-invoice/search-pi-number/{number}\",\"om.proforma-invoicecreate.proforma.invoice\":\"/om/ajax/proforma-invoice/create-proforma-invoice/{number}\",\"om.customers.exports.index\":\"/om/customers/exports\",\"om.customers.exports.show\":\"/om/customers/exports/{export}\",\"om.customers.exports.edit\":\"/om/customers/exports/{export}/edit\",\"om.customers.exports.update\":\"/om/customers/exports/{export}\",\"om.customers.approves.\":\"/om/customers/approves/reassign/{id}\",\"om.customers.approves.view\":\"/om/customers/approves/view/{id}\",\"om.customers.domestics-broker\":\"/om/customers/domestics/broker\",\"om.customers.domestics.index\":\"/om/customers/domestics\",\"om.customers.domestics.create\":\"/om/customers/domestics/create\",\"om.customers.domestics.show\":\"/om/customers/domestics/{domestic}\",\"om.customers.detail\":\"/om/customers/domestics/{domestic}\",\"om.release-credit.\":\"/om/release-credit/create\",\"om.release-credit.update\":\"/om/release-credit/update\",\"om.promotions.\":\"/om/transfer-bank/domestic\",\"om.promotions.store-header\":\"/om/promotions/store-header\",\"om.postpone-delivery.\":\"/om/postpone-delivery/search\",\"om.auto.\":\"/om/auto/postpone-delivery\",\"om.\":\"/om/debit-note\",\"om.addition-index\":\"/om/addition-quota\",\"om.addition-quota\":\"/om/addition-quota/approve/step/{id}/{step}\",\"om.addition-upload\":\"/om/addition-quota/upload/file\",\"om.addition-filesdelete\":\"/om/addition-quota/delete/file\",\"om.addition-quota-update\":\"/om/addition-quota/approve/step/update\",\"om.cancel-consignment\":\"/om/consignment/cancel\",\"om.canceled-consignment\":\"/om/consignment/canceled\",\"om.delivery-rate-index\":\"/om/delivery-rate\",\"om.delivery-rate-store\":\"/om/delivery-rate/store\",\"om.draft-payout-index\":\"/om/draft-payout\",\"om.draft-payout-listproduct\":\"/om/draft-payout/listproduct\",\"om.draft-payout-storeDraft\":\"/om/draft-payout/storeDraft\",\"om.domestic-matching-index\":\"/om/domestic-matching\",\"om.domestic-matching-getData\":\"/om/domestic-matching/getData\",\"om.domestic-matching-uploaded\":\"/om/domestic-matching/uploaded\",\"om.domestic-matching-upload-deleted\":\"/om/domestic-matching/uploaded\",\"om.domestic-matching-unmatching\":\"/om/domestic-matching/unmatching\",\"om.domestic-matching-matching\":\"/om/domestic-matching/matching\",\"om.domestic-matching-getinvoice\":\"/om/domestic-matching/getinvoice\",\"om.domestic-matching-getamount\":\"/om/domestic-matching/getamount\",\"om.payment-method-index\":\"/om/payment-method/{type}\",\"om.payment-method-print\":\"/om/payment-method/{type}/{id}\",\"om.payment-method-getlistbank\":\"/om/payment-method/getlistbank\",\"om.payment-method-getinfofordraft\":\"/om/payment-method/getinfofordraft\",\"om.payment-method-getvaluebank\":\"/om/payment-method/getvaluebank\",\"om.payment-method-getpaymentnumber\":\"/om/payment-method/getpaymentnumber\",\"om.payment-method-draftpayment\":\"/om/payment-method/draftpayment\",\"om.payment-method-payment\":\"/om/payment-method/payment\",\"om.payment-method-payment-upload\":\"/om/payment-method/payment/upload\",\"om.payment-method-payment-delete\":\"/om/payment-method/payment/files/delete\",\"om.payment-method-getvaluefromnumber\":\"/om/payment-method/getvaluefromnumber\",\"om.payment-method-paymentverify\":\"/om/payment-method/paymentverify\",\"om.export-payout-index\":\"/om/export-payout\",\"om.export-payout-getlistbank\":\"/om/export-payout/getlistbank\",\"om.export-payout-getvaluebank\":\"/om/export-payout/getvaluebank\",\"om.export-payout-getpaymentnumber\":\"/om/export-payout/getpaymentnumber\",\"om.export-payment-method-draftpayment\":\"/om/export-payout/draftpayment\",\"om.export-method-payment-upload\":\"/om/export-payout/payment/upload\",\"om.export-method-payment-delete\":\"/om/export-payout/payment/files/delete\",\"om.export-method-payment\":\"/om/export-payout/payment\",\"om.export-method-print\":\"/om/export-payout/print/{id}\",\"om.export-matching-index\":\"/om/export-matching\",\"om.export-matching-unmatching\":\"/om/export-matching/unmatching\",\"om.export-matching-uploaded\":\"/om/export-matching/uploaded\",\"om.export-matching-upload-deleted\":\"/om/export-matching/upload/deleted\",\"om.export-matching-getData\":\"/om/export-matching/getData\",\"om.export-matching-matching\":\"/om/export-matching/matching\",\"om.tax-adjust-index\":\"/om/tax-adjust\",\"om.tax-adjust-recivedata\":\"/om/tax-adjust/recivedata\",\"om.tax-adjust-senddata\":\"/om/tax-adjust/senddata\",\"om.sendap-transfer-commission\":\"/om/transfer-commission/sndAP\",\"om.index-transfer-province\":\"/om/transfer-province\",\"om.calculate-transfer-province\":\"/om/transfer-province/calculate\",\"om.close-flag-release\":\"/om/close-flag/release\",\"om.close-flag-process\":\"/om/close-flag/process\",\"om.transfer-bi-weekly.\":\"/om/transfer-bi-weekly/domestic/approved\",\"om.overdue-debt.index\":\"/om/overdue-debt\",\"om.overdue-debt.show\":\"/om/overdue-debt/{overdue_debt}\",\"om.sale-confirmation.index\":\"/om/sale-confirmation\",\"om.sale-confirmation.show\":\"/om/sale-confirmation/{sale_confirmation}\",\"om.sequence-fortnightly.index\":\"/om/sequence-fortnightly\",\"om.sequence-fortnightly.show\":\"/om/sequence-fortnightly/{sequence_fortnightly}\",\"om.biweekly-periods.index\":\"/om/biweekly-periods\",\"om.transfer-monthly.\":\"/om/transfer-monthly/domestic\",\"om.order.approvepreparaapproveprepara.index\":\"/om/order/approveprepare\",\"om.order.prepare.order\":\"/om/order/prepare\",\"om.order.prepare.search\":\"/om/order/prepare/search\",\"om.order.prepare.create.show\":\"/om/order/prepare/create\",\"om.order.prepare.prepare.edit\":\"/om/order/prepare/edit/{id}\",\"om.order.prepare.\":\"/om/order/prepare/edit/{id}/submit\",\"om.order.prepare.create.submit\":\"/om/order/prepare/create/submit\",\"om.order.prepare.update.submit\":\"/om/order/prepare/update/submit\",\"om.order.prepare.approve\":\"/om/order/prepare/approve/{id}\",\"om.order.prepare.cancel\":\"/om/order/prepare/cancel/{id}\",\"om.order.prepare.copy\":\"/om/order/prepare/copy/{id}\",\"om.order.approveapprove.index\":\"/om/order/approve\",\"om.get-invoice-header\":\"/om/test\",\"om.get-invoice-header-save\":\"/om/test/save\",\"om.proforma-invoice.index\":\"/om/proforma-invoice\",\"om.proforma-invoice.show\":\"/om/proforma-invoice/{proforma_invoice}\",\"om.tax-invoice-export.index\":\"/om/tax-invoice-export\",\"om.tax-invoice-export.show\":\"/om/tax-invoice-export/{tax_invoice_export}\",\"om.transpot-report-index\":\"/om/transpot-report\",\"om.transpot-report-createDataone\":\"/om/transpot-report/createDataone\",\"om.transpot-report-createDatatwo\":\"/om/transpot-report/createDatatwo\",\"om.order.direct.debit\":\"/om/order-direct-debit/domestic/save\",\"om.consignment\":\"/om/consignment/fillData\",\"om.consignmentgetData\":\"/om/consignment/create\",\"om.invoice.cancel-invoice\":\"/om/invoice/cancel\",\"om.invoice.canceled-invoice\":\"/om/invoice/canceled\",\"om.invoice.getlist-cancel-invoice\":\"/om/invoice/list-cancel-invoice\",\"om.consignment-club.index\":\"/om/consignment-club\",\"om.consignment-club.show\":\"/om/consignment-club/{consignment_club}\",\"om.approve-prepare.index\":\"/om/approve-prepare\",\"om.approve-prepare.show\":\"/om/approve-prepare/{approve_prepare}\",\"om.rma-export.index\":\"/om/rma-export\",\"om.rma-export.show\":\"/om/rma-export/{rma_export}\",\"om.approve-prepare.print\":\"/om/approve-prepare/print/{id}\",\"om.outstanding.index\":\"/om/outstanding\",\"om.outstanding.getData\":\"/om/outstanding-list\",\"om.outstanding.getYear\":\"/om/outstanding-year\",\"ir.ajax.sub-groups.show\":\"/ir/ajax/sub-groups/show/{policy_set_header_id}\",\"ir.ajax.product-groups.updateActiveFlag\":\"/ir/ajax/product-groups/updateActiveFlag\",\"ir.ajax.sub-groups.checkInactive\":\"/ir/ajax/sub-groups/check-inactive\",\"ir.ajax.product-group\":\"/ir/ajax/product-group\",\"ir.ajax.get-locator\":\"/ir/ajax/get-locator\",\"ir.ajax.updateActiveFlag\":\"/ir/ajax/updateActiveFlag\",\"ir.ajax.destroy\":\"/ir/ajax/destroy\",\"ir.ajax.getValueSet\":\"/ir/ajax/get-value-set\",\"ir.ajax.sub-groups.destroy\":\"/ir/ajax/sub-groups/destroy\",\"ir.settings.product-groups.index\":\"/ir/settings/product-groups\",\"ir.settings.product-groups.create\":\"/ir/settings/product-groups/create\",\"ir.settings.product-groups.store\":\"/ir/settings/product-groups/store\",\"ir.settings.product-groups.update\":\"/ir/settings/product-groups/update\",\"ir.settings.product-groups.edit\":\"/ir/settings/product-groups/{id}/edit\",\"ir.settings.product-header.index\":\"/ir/settings/product-header\",\"ir.settings.product-header.create\":\"/ir/settings/product-header/create\",\"ir.settings.product-header.store\":\"/ir/settings/product-header/store\",\"ir.settings.product-header.search\":\"/ir/settings/product-header/search\",\"ir.settings.product-header.edit\":\"/ir/settings/product-header/{id}/edit\",\"ir.settings.product-header.update\":\"/ir/settings/product-header/update\",\"ir.settings.sub-groups.index\":\"/ir/settings/sub-groups\",\"ir.settings.sub-groups.create\":\"/ir/settings/sub-groups/create\",\"ir.settings.sub-groups.update\":\"/ir/settings/sub-groups/update\",\"ir.settings.sub-groups.store\":\"/ir/settings/sub-groups/store\",\"ir.settings.sub-groups.search\":\"/ir/settings/sub-groups/search\",\"ir.settings.sub-groups.edit\":\"/ir/settings/sub-groups/{id}/edit\",\"ir.ajax.Lov.lov-companies\":\"/ir/ajax/lov/companies\",\"ir.ajax.Lov.lov-vendor\":\"/ir/ajax/lov/vendor\",\"ir.ajax.Lov.lov-branch-code\":\"/ir/ajax/lov/branch-code\",\"ir.ajax.Lov.lov-customer-number\":\"/ir/ajax/lov/customer-number\",\"ir.ajax.Lov.lov-policy-set-header\":\"/ir/ajax/lov/policy-set-header\",\"ir.ajax.Lov.lov-policy-type\":\"/ir/ajax/lov/policy-type\",\"ir.ajax.Lov.lov-account-code-combine\":\"/ir/ajax/lov/account-code-combine\",\"ir.ajax.Lov.lov-gas-stations-groups\":\"/ir/ajax/lov/gas-station-group\",\"ir.ajax.Lov.lov-group\":\"/ir/ajax/lov/group-code\",\"ir.ajax.Lov.lov-policy-category\":\"/ir/ajax/lov/policy-category\",\"ir.ajax.Lov.lov-policy-group-headers\":\"/ir/ajax/lov/policy-group-header\",\"ir.ajax.Lov.lov-premium-rate\":\"/ir/ajax/lov/premium-rate\",\"ir.ajax.Lov.companies-code\":\"/ir/ajax/lov/company-code\",\"ir.ajax.Lov.lov-evm-code\":\"/ir/ajax/lov/evm-code\",\"ir.ajax.Lov.lov-department-code\":\"/ir/ajax/lov/department-code\",\"ir.ajax.Lov.lov-cost-center-code\":\"/ir/ajax/lov/cost-center-code\",\"ir.ajax.Lov.lov-budget-year\":\"/ir/ajax/lov/budget-year\",\"ir.ajax.Lov.lov-budget-type\":\"/ir/ajax/lov/budget-type\",\"ir.ajax.Lov.lov-budget-detail\":\"/ir/ajax/lov/budget-detail\",\"ir.ajax.Lov.lov-budget-reason\":\"/ir/ajax/lov/budget-reason\",\"ir.ajax.Lov.lov-main-account\":\"/ir/ajax/lov/main-account\",\"ir.ajax.Lov.lov-sub-account\":\"/ir/ajax/lov/sub-account\",\"ir.ajax.Lov.lov-reserverd1\":\"/ir/ajax/lov/reserved1\",\"ir.ajax.Lov.lov-reserverd2\":\"/ir/ajax/lov/reserved2\",\"ir.ajax.Lov.lov-license-plate\":\"/ir/ajax/lov/license-plate\",\"ir.ajax.Lov.lov-vehicles-type\":\"/ir/ajax/lov/vehicles-type\",\"ir.ajax.Lov.lov-renew-type\":\"/ir/ajax/lov/renew-type\",\"ir.ajax.Lov.lov-gas-stations-type\":\"/ir/ajax/lov/gas-stations-type\",\"ir.ajax.Lov.lov-status\":\"/ir/ajax/lov/status\",\"ir.ajax.Lov.lov-periods\":\"/ir/ajax/lov/periods\",\"ir.ajax.Lov.lov-group-location\":\"/ir/ajax/lov/group-location\",\"ir.ajax.Lov.lov-sub-group\":\"/ir/ajax/lov/sub-group\",\"ir.ajax.Lov.lov-org\":\"/ir/ajax/lov/org\",\"ir.ajax.Lov.lov-sub-inventory\":\"/ir/ajax/lov/sub-inventory\",\"ir.ajax.Lov.lov-uom\":\"/ir/ajax/lov/uom\",\"ir.ajax.Lov.lov-invoice\":\"/ir/ajax/lov/invoice-type\",\"ir.ajax.Lov.lov-governer-policy-type\":\"/ir/ajax/lov/governer-policy-type\",\"ir.ajax.Lov.lov-invoice-number\":\"/ir/ajax/lov/invoice-number\",\"ir.ajax.Lov.lov-interface-type\":\"/ir/ajax/lov/interface-type\",\"ir.ajax.Lov.lov-interface-gl-type\":\"/ir/ajax/lov/interface-gl-type\",\"ir.ajax.Lov.lov-department-location\":\"/ir/ajax/lov/department-location\",\"ir.ajax.Lov.lov-location\":\"/ir/ajax/lov/location\",\"ir.ajax.Lov.lov-cat-segment1\":\"/ir/ajax/lov/cat-segment1\",\"ir.ajax.Lov.lov-cat-segment3\":\"/ir/ajax/lov/cat-segment3\",\"ir.ajax.Lov.lov-receivable-charge\":\"/ir/ajax/lov/receivable-charge\",\"ir.ajax.Lov.lov-effective-date\":\"/ir/ajax/lov/effective-date\",\"ir.ajax.Lov.lov-exp-asset-stock-type\":\"/ir/ajax/lov/exp-asset-stock-type\",\"ir.ajax.Lov.lov-exp-car-gas-type\":\"/ir/ajax/lov/exp-car-gas-type\",\"ir.ajax.Lov.lov-ar-invoice-num\":\"/ir/ajax/lov/ar-invoice-num\",\"ir.ajax.Lov.lov-policy-vehicle\":\"/ir/ajax/lov/policy-vehicles\",\"ir.ajax.Lov.lov-group-code-policy\":\"/ir/ajax/lov/group-code-policy\",\"ir.ajax.Lov.lov-revision\":\"/ir/ajax/lov/revision\",\"ir.ajax.Lov.lov-budget-period_year\":\"/ir/ajax/lov/budget-period-year\",\"ir.ajax.Lov.lov-asset-status\":\"/ir/ajax/lov/asset-status\",\"ir.ajax.Lov.lov-vehicle-license-plate\":\"/ir/ajax/lov/vehicle-license-plate\",\"ir.ajax.Lov.lov-gas-station-type-master\":\"/ir/ajax/lov/gas-station-type-master\",\"ir.ajax.Lov.lov-claim-document-number\":\"/ir/ajax/lov/claim-document-number\",\"ir.ajax.Lov.lov-gen-company-number\":\"/ir/ajax/lov/gen-company-number\",\"ir.ajax.Lov.lov-claim-policy-number\":\"/ir/ajax/lov/claim-policy-number\",\"ir.ajax.Lov.lov-company-percent\":\"/ir/ajax/lov/company-percent\",\"ir.ajax.Lov.lov-policy-set-header-group\":\"/ir/ajax/lov/policy-set-header-group\",\"ir.ajax.company-index\":\"/ir/ajax/company\",\"ir.ajax.company-show\":\"/ir/ajax/company/{company_id}\",\"ir.ajax.company-store\":\"/ir/ajax/company\",\"ir.ajax.company-update\":\"/ir/ajax/company\",\"ir.ajax.company-active-flag\":\"/ir/ajax/company/active-flag\",\"ir.ajax.company-check-used-data\":\"/ir/ajax/company/check-used-data/{company_id}\",\"ir.ajax.policy-index\":\"/ir/ajax/policy\",\"ir.ajax.policy-show\":\"/ir/ajax/policy/{policy_set_header_id}\",\"ir.ajax.policy-store\":\"/ir/ajax/policy/save\",\"ir.ajax.policy-update\":\"/ir/ajax/policy/update\",\"ir.ajax.policy-update-active-flag\":\"/ir/ajax/policy/active-flag\",\"ir.ajax.policy-check-used-data\":\"/ir/ajax/policy/check-used-data/{policy_set_header_id}\",\"ir.ajax.policy-group-header-index\":\"/ir/ajax/policy-group\",\"ir.ajax.policy-group-header-overlap-check\":\"/ir/ajax/policy-group/overlap-check\",\"ir.ajax.policy-group-header-show\":\"/ir/ajax/policy-group/{group_header_id}\",\"ir.ajax.policy-group-header-group-dists\":\"/ir/ajax/group-dists\",\"ir.ajax.policy-group-header-store\":\"/ir/ajax/policy-group/save\",\"ir.ajax.policy-group-header-store-index\":\"/ir/ajax/policy-group/save-index\",\"ir.ajax.policy-group-set-delete\":\"/ir/ajax/policy-group/group-sets\",\"ir.ajax.policy-group-header-update-active-flag\":\"/ir/ajax/policy-group/update-active-flag\",\"ir.ajax.policy-group-header-duplicate-check\":\"/ir/ajax/policy-group/duplicate-check/{policy_set_header_id}\",\"ir.ajax.vehicles-index\":\"/ir/ajax/vehicles\",\"ir.ajax.vehicles-show\":\"/ir/ajax/vehicles/{asset_id}\",\"ir.ajax.vehicles-update\":\"/ir/ajax/vehicles\",\"ir.ajax.vehicles-active-flag\":\"/ir/ajax/vehicles/active-flag\",\"ir.ajax.vehicles-return-vat-flag\":\"/ir/ajax/vehicles/return-vat-flag\",\"ir.ajax.gas-stations-index\":\"/ir/ajax/gas-stations\",\"ir.ajax.gas-stations-show\":\"/ir/ajax/gas-stations/{gas_station_id}\",\"ir.ajax.gas-stations-store\":\"/ir/ajax/gas-stations\",\"ir.ajax.gas-stations-update\":\"/ir/ajax/gas-stations\",\"ir.ajax.gas-stations-return-vat-flag\":\"/ir/ajax/gas-stations/return-vat-flag\",\"ir.ajax.gas-stations-active-flag\":\"/ir/ajax/gas-stations/active-flag\",\"ir.ajax.stocks-index\":\"/ir/ajax/stocks\",\"ir.ajax.stocks-fetch\":\"/ir/ajax/stocks/fetch\",\"ir.ajax.stocks-show\":\"/ir/ajax/stocks/show\",\"ir.ajax.stocks-create-or-update\":\"/ir/ajax/stocks\",\"ir.ajax.asset-index\":\"/ir/ajax/asset\",\"ir.ajax.asset-fetch\":\"/ir/ajax/asset/fetch\",\"ir.ajax.asset-index-adjust\":\"/ir/ajax/asset/asset-adjust\",\"ir.ajax.asset-fetch-adjust\":\"/ir/ajax/asset/asset-adjust/fetch\",\"ir.ajax.asset-show\":\"/ir/ajax/asset/show\",\"ir.ajax.asset-show-adjust\":\"/ir/ajax/asset/asset-adjust/show\",\"ir.ajax.asset-create-or-update\":\"/ir/ajax/asset\",\"ir.ajax.cars-index\":\"/ir/ajax/cars\",\"ir.ajax.cars-fetch\":\"/ir/ajax/cars/fetch\",\"ir.ajax.cars-create-or-update\":\"/ir/ajax/cars\",\"ir.ajax.cars-duplicate-check\":\"/ir/ajax/cars/duplicate-check\",\"ir.ajax.cars-status\":\"/ir/ajax/cars/status\",\"ir.ajax.extend-gas-stations-index\":\"/ir/ajax/extend-gas-stations\",\"ir.ajax.extend-gas-stations-fetch\":\"/ir/ajax/extend-gas-stations/fetch\",\"ir.ajax.extend-gas-stations-create-or-update\":\"/ir/ajax/extend-gas-stations\",\"ir.ajax.extend-gas-stations-duplicate-check\":\"/ir/ajax/extend-gas-stations/duplicate-check\",\"ir.ajax.extend-gas-stations-status\":\"/ir/ajax/extend-gas-stations/status\",\"ir.ajax.persons-index\":\"/ir/ajax/persons\",\"ir.ajax.persons-create-or-update\":\"/ir/ajax/persons\",\"ir.ajax.persons-duplicate-check\":\"/ir/ajax/persons/duplicate-check\",\"ir.ajax.persons-duplicate-check-invoice-number\":\"/ir/ajax/persons/duplicate-check/invoice-number\",\"ir.ajax.persons-status\":\"/ir/ajax/persons/status\",\"ir.ajax.expense-asset-stock-index\":\"/ir/ajax/expense-asset-stock\",\"ir.ajax.expense-asset-stock-store\":\"/ir/ajax/expense-asset-stock\",\"ir.ajax.expense-car-gas-index\":\"/ir/ajax/expense-car-gas\",\"ir.ajax.expense-car-gas-store\":\"/ir/ajax/expense-car-gas\",\"ir.ajax.claim-index\":\"/ir/ajax/claim\",\"ir.ajax.claim-show\":\"/ir/ajax/claim/{claim_header_id}\",\"ir.ajax.claim-create-or-update\":\"/ir/ajax/claim\",\"ir.ajax.claim-delete\":\"/ir/ajax/claim/{claim_header_id}\",\"ir.ajax.claim-upload\":\"/ir/ajax/claim/upload\",\"ir.ajax.claim-delete-file\":\"/ir/ajax/claim/file/{attachment_id}\",\"ir.ajax.confirm-ap-interface\":\"/ir/ajax/confirm-ap\",\"ir.ajax.confirm-ap-cancel\":\"/ir/ajax/confirm-ap/cancel\",\"ir.ajax.confirm-gl-interface\":\"/ir/ajax/confirm-gl\",\"ir.ajax.confirm-gl-cancel\":\"/ir/ajax/confirm-gl/cancel\",\"ir.ajax.confirm-ar-interface\":\"/ir/ajax/confirm-ar\",\"ir.ajax.confirm-ar-cancel\":\"/ir/ajax/confirm-ar/cancel\",\"ir.ajax.account-mapping.index\":\"/ir/ajax/coa-mapping\",\"ir.ajax.validate-combination\":\"/ir/ajax/validate-combination\",\"ir.ajax.show-account-mapping\":\"/ir/ajax/account-mapping\",\"ir.ajax.companies-code\":\"/ir/ajax/companies-code/all\",\"ir.ajax.evm-code\":\"/ir/ajax/evm-code/all\",\"ir.ajax.department-code\":\"/ir/ajax/department-code/all\",\"ir.ajax.costcenter-code\":\"/ir/ajax/costcenter-code/all\",\"ir.ajax.budget-year\":\"/ir/ajax/budget-year/all\",\"ir.ajax.budget-type\":\"/ir/ajax/budget-type/all\",\"ir.ajax.budget-detail\":\"/ir/ajax/budget-detail/all\",\"ir.ajax.budget-reason\":\"/ir/ajax/budget-reason/all\",\"ir.ajax.main-account\":\"/ir/ajax/main-account/all\",\"ir.ajax.sub-account\":\"/ir/ajax/sub-account/all\",\"ir.ajax.reserverd1\":\"/ir/ajax/reserved1/all\",\"ir.ajax.reserverd2\":\"/ir/ajax/reserved2/all\",\"ir.ajax.code-combine-lov\":\"/ir/ajax/account-mapping/lov/account-code-combine\",\"ir.ajax.account-desc\":\"/ir/ajax/get-account-desc\",\"ir.ajax.vehicles-lov-license-plate\":\"/ir/ajax/vehicles/lov/license-plate\",\"ir.ajax.vehicles-lov-type\":\"/ir/ajax/vehicles/lov/vehicles-type\",\"ir.ajax.vehicles-update-or-create\":\"/ir/ajax/vehicles/updateOrCreate\",\"ir.ajax.vehicles-update-active-flag\":\"/ir/ajax/vehicles/active-flag\",\"ir.ajax.vehicles-update-return-vat-flag\":\"/ir/ajax/vehicles/return-vat-flag\",\"ir.ajax.lookup-gas-stations-lov-type\":\"/ir/ajax/gas-stations/lov/lookup-type\",\"ir.ajax.lookup-gas-stations-lov-groups\":\"/ir/ajax/gas-stations/lov/lookup-group\",\"ir.ajax.gas-stations-update-return-vat-flag\":\"/ir/ajax/gas-stations/return-vat-flag\",\"ir.ajax.gas-stations-update-active-flag\":\"/ir/ajax/gas-stations/active-flag\",\"ir.ajax.ir-report-get-info\":\"/ir/ajax/ir-report-get-info\",\"ir.ajax.ir-report-get-info-attribute\":\"/ir/ajax/ir-report-get-info-attribute\",\"ir.ajax.ir-report-submit\":\"/ir/ajax/ir-report-submit\",\"ir.settings.store-account-mapping\":\"/ir/settings/account-mapping/save\",\"ir.settings.update-account-mapping\":\"/ir/settings/account-mapping/update\",\"ir.settings.policy.index\":\"/ir/settings/policy\",\"ir.settings.policy.create\":\"/ir/settings/policy/create\",\"ir.settings.policy.edit\":\"/ir/settings/policy/edit/{id}\",\"ir.settings.gas-stations.index\":\"/ir/settings/gas-stations\",\"ir.settings.gas-stations.create\":\"/ir/settings/gas-stations/create\",\"ir.settings.gas-stations.edit\":\"/ir/settings/gas-stations/edit\",\"ir.settings.policies.index\":\"/ir/settings/policy\",\"ir.settings.policies.create\":\"/ir/settings/policy/create\",\"ir.settings.policies.edit\":\"/ir/settings/policy/edit/{id}\",\"ir.settings.policy-group.index\":\"/ir/settings/policy-group\",\"ir.settings.policy-group.edit\":\"/ir/settings/policy-group/edit/{id}\",\"ir.settings.irp-0008.index\":\"/ir/settings/irp-0008\",\"ir.settings.report-info.index\":\"/ir/settings/report-info\",\"ir.settings.report-info.show\":\"/ir/settings/report-info/{program}\",\"ir.settings.report-info.store\":\"/ir/settings/report-info/{program}/store\",\"ir.settings.report-info.update\":\"/ir/settings/report-info/{program}/{info}\",\"ir.settings.report-info.destroy\":\"/ir/settings/report-info/{program}/{info}/delete\",\"ir.settings.company.index\":\"/ir/settings/company\",\"ir.settings.company.create\":\"/ir/settings/company/create\",\"ir.settings.company.edit\":\"/ir/settings/company/edit/{id}\",\"ir.settings.vehicle.index\":\"/ir/settings/vehicle\",\"ir.settings.vehicle.edit\":\"/ir/settings/vehicle/edit/{id}\",\"ir.settings.gas-station.index\":\"/ir/settings/gas-station\",\"ir.settings.account-mapping.index\":\"/ir/settings/account-mapping\",\"ir.settings.account-mapping.create\":\"/ir/settings/account-mapping/create\",\"ir.settings.account-mapping.store\":\"/ir/settings/account-mapping\",\"ir.settings.account-mapping.show\":\"/ir/settings/account-mapping/{account_mapping}\",\"ir.settings.account-mapping.edit\":\"/ir/settings/account-mapping/{account_mapping}/edit\",\"ir.settings.account-mapping.update\":\"/ir/settings/account-mapping/{account_mapping}\",\"ir.settings.account-mapping.destroy\":\"/ir/settings/account-mapping/{account_mapping}\",\"ir.settings.product-group\":\"/ir/ajax/product-group\",\"ir.settings.get-locator\":\"/ir/ajax/get-locator\",\"ir.settings.gas-station.create\":\"/ir/settings/gas-station/create\",\"ir.settings.gas-station.edit\":\"/ir/settings/gas-station/edit/{id}\",\"ir.stocks.yearly.index\":\"/ir/stocks/yearly\",\"ir.stocks.yearly.edit\":\"/ir/stocks/yearly/edit/{id}\",\"ir.stocks.monthly.index\":\"/ir/stocks/monthly\",\"ir.stocks.monthly.edit\":\"/ir/stocks/monthly/edit/{id}\",\"ir.assets.asset-plan.index\":\"/ir/assets/asset-plan\",\"ir.assets.asset-plan.edit\":\"/ir/assets/asset-plan/edit/{id}\",\"ir.assets.asset-increase.index\":\"/ir/assets/asset-increase\",\"ir.assets.asset-increase.edit\":\"/ir/assets/asset-increase/edit/{id}\",\"ir.gas-stations.gas-station.index\":\"/ir/settings/gas-stations\",\"ir.cars.car.index\":\"/ir/cars/car\",\"ir.governors.governor.index\":\"/ir/governors/governor\",\"ir.calculate-insurance.index\":\"/ir/calculate-insurance\",\"ir.calculate-insurance.report\":\"/ir/calculate-insurance/report\",\"ir.expense-stock-asset.index\":\"/ir/settings/irp-0008\",\"ir.expense-car-gas.index\":\"/ir/expense-car-gas\",\"ir.claim-insurance.index\":\"/ir/claim-insurance\",\"ir.claim-insurance.create\":\"/ir/claim-insurance/create\",\"ir.claim-insurance.edit\":\"/ir/claim-insurance/edit/{id}\",\"ir.confirm-to-ap.index\":\"/ir/confirm-to-ap\",\"ir.confirm-to-gl.index\":\"/ir/confirm-to-gl\",\"ir.confirm-to-ar.index\":\"/ir/confirm-to-ar\",\"ir.report.export\":\"/ir/reports/export\",\"ir.report.index\":\"/ir/reports\",\"ir.report.get-param\":\"/ir/reports/get-param\",\"ie.ajax.icon.index\":\"/ie/ajax/icon\",\"ie.cash-advances.get_suppliers\":\"/ie/cash-advances/get_suppliers\",\"ie.cash-advances.get_supplier_sites\":\"/ie/cash-advances/get_supplier_sites\",\"ie.cash-advances.get_requester_data\":\"/ie/cash-advances/get_requester_data\",\"ie.cash-advances.index-pending\":\"/ie/cash-advances/pending\",\"ie.cash-advances.get_sub_categories\":\"/ie/cash-advances/get_sub_categories\",\"ie.cash-advances.get_form_informations\":\"/ie/cash-advances/ca_sub_category/{ca_sub_category}/get_form_informations\",\"ie.cash-advances.index\":\"/ie/cash-advances\",\"ie.cash-advances.create\":\"/ie/cash-advances/create\",\"ie.cash-advances.show\":\"/ie/cash-advances/{cashAdvance}\",\"ie.cash-advances.update\":\"/ie/cash-advances/{cashAdvance}\",\"ie.cash-advances.store\":\"/ie/cash-advances/store\",\"ie.cash-advances.export\":\"/ie/cash-advances/export\",\"ie.cash-advances.update_cl\":\"/ie/cash-advances/{cashAdvance}/update_cl\",\"ie.cash-advances.form_edit\":\"/ie/cash-advances/{cashAdvance}/form_edit\",\"ie.cash-advances.form_edit_cl\":\"/ie/cash-advances/{cashAdvance}/form_edit_cl\",\"ie.cash-advances.report\":\"/ie/cash-advances/{cashAdvance}/report\",\"ie.cash-advances.get_total_amount\":\"/ie/cash-advances/{cashAdvance}/get_total_amount\",\"ie.cash-advances.update_dff\":\"/ie/cash-advances/{cashAdvance}/update_dff\",\"ie.cash-advances.change_approver\":\"/ie/cash-advances/{cashAdvance}/change_approver\",\"ie.cash-advances.set_status\":\"/ie/cash-advances/{cashAdvance}/set_status\",\"ie.cash-advances.add_attachment\":\"/ie/cash-advances/{cashAdvance}/add_attachment\",\"ie.cash-advances.set_due_date\":\"/ie/cash-advances/{cashAdvance}/set_due_date\",\"ie.cash-advances.get_diff_ca_and_clearing_amount\":\"/ie/cash-advances/{cashAdvance}/get_diff_ca_and_clearing_amount\",\"ie.cash-advances.get_diff_ca_and_clearing_data\":\"/ie/cash-advances/{cashAdvance}/get_diff_ca_and_clearing_data\",\"ie.cash-advances.duplicate\":\"/ie/cash-advances/{cashAdvance}/duplicate\",\"ie.cash-advances.clear-request\":\"/ie/cash-advances/{cashAdvance}/clear-request\",\"ie.cash-advances.clear\":\"/ie/cash-advances/{cashAdvance}/clear\",\"ie.cash-advances.check_ca_attachment\":\"/ie/cash-advances/{cashAdvance}/check_ca_attachment\",\"ie.cash-advances.check_ca_min_amount\":\"/ie/cash-advances/{cashAdvance}/check_ca_min_amount\",\"ie.cash-advances.check_ca_max_amount\":\"/ie/cash-advances/{cashAdvance}/check_ca_max_amount\",\"ie.cash-advances.combine_receipt_gl_code_combination\":\"/ie/cash-advances/{cashAdvance}/combine_receipt_gl_code_combination\",\"ie.cash-advances.check_over_budget\":\"/ie/cash-advances/{cashAdvance}/check_over_budget\",\"ie.cash-advances.check_exceed_policy\":\"/ie/cash-advances/{cashAdvance}/check_exceed_policy\",\"ie.cash-advances.validate_receipt\":\"/ie/cash-advances/{cashAdvance}/validate_receipt\",\"ie.cash-advances.form_send_request_with_reason\":\"/ie/cash-advances/{cashAdvance}/form_send_request_with_reason\",\"ie.reimbursements.get_suppliers\":\"/ie/reimbursements/get_suppliers\",\"ie.reimbursements.get_supplier_sites\":\"/ie/reimbursements/get_supplier_sites\",\"ie.reimbursements.get_requester_data\":\"/ie/reimbursements/get_requester_data\",\"ie.reimbursements.index-pending\":\"/ie/reimbursements/pending\",\"ie.reimbursements.index\":\"/ie/reimbursements\",\"ie.reimbursements.create\":\"/ie/reimbursements/create\",\"ie.reimbursements.show\":\"/ie/reimbursements/{reimbursement}\",\"ie.reimbursements.update\":\"/ie/reimbursements/{reimbursement}\",\"ie.reimbursements.store\":\"/ie/reimbursements/store\",\"ie.reimbursements.export\":\"/ie/reimbursements/export\",\"ie.reimbursements.form_edit\":\"/ie/reimbursements/{reimbursement}/form_edit\",\"ie.reimbursements.get_total_amount\":\"/ie/reimbursements/{reimbursement}/get_total_amount\",\"ie.reimbursements.update_dff\":\"/ie/reimbursements/{reimbursement}/update_dff\",\"ie.reimbursements.change_approver\":\"/ie/reimbursements/{reimbursement}/change_approver\",\"ie.reimbursements.set_status\":\"/ie/reimbursements/{reimbursement}/set_status\",\"ie.reimbursements.add_attachment\":\"/ie/reimbursements/{reimbursement}/add_attachment\",\"ie.reimbursements.set_due_date\":\"/ie/reimbursements/{reimbursement}/set_due_date\",\"ie.reimbursements.duplicate\":\"/ie/reimbursements/{reimbursement}/duplicate\",\"ie.reimbursements.combine_receipt_gl_code_combination\":\"/ie/reimbursements/{reimbursement}/combine_receipt_gl_code_combination\",\"ie.reimbursements.check_over_budget\":\"/ie/reimbursements/{reimbursement}/check_over_budget\",\"ie.reimbursements.check_exceed_policy\":\"/ie/reimbursements/{reimbursement}/check_exceed_policy\",\"ie.reimbursements.validate_receipt\":\"/ie/reimbursements/{reimbursement}/validate_receipt\",\"ie.reimbursements.form_send_request_with_reason\":\"/ie/reimbursements/{reimbursement}/form_send_request_with_reason\",\"ie.receipts.get_vendor_sites\":\"/ie/receipts/get_vendor_sites/{vendor_id}\",\"ie.receipts.get_vendor_detail\":\"/ie/receipts/get_vendor_detail/{vendor_id}/site/{vendor_site_code}\",\"ie.receipts.get_rows\":\"/ie/receipts/get_rows\",\"ie.receipts.get_table_total_rows\":\"/ie/receipts/get_table_total_rows\",\"ie.receipts.form_create\":\"/ie/receipts/form_create\",\"ie.receipts.index-pending\":\"/ie/receipts/pending\",\"ie.receipts.create\":\"/ie/receipts/create\",\"ie.receipts.show\":\"/ie/receipts/{receipt}\",\"ie.receipts.update\":\"/ie/receipts/{receipt}\",\"ie.receipts.store\":\"/ie/receipts/store\",\"ie.receipts.export\":\"/ie/receipts/export\",\"ie.receipts.set_status\":\"/ie/receipts/set_status\",\"ie.receipts.add_attachment\":\"/ie/receipts/{receipt}/add_attachment\",\"ie.receipts.form_edit\":\"/ie/receipts/{receipt}/form_edit\",\"ie.receipts.duplicate\":\"/ie/receipts/{receipt}/duplicate\",\"ie.receipts.remove\":\"/ie/receipts/{receipt}/remove\",\"ie.receipts.lines.store\":\"/ie/receipts/{receipt}/lines/store\",\"ie.receipts.lines.update\":\"/ie/receipts/{receipt}/lines/{line}/update\",\"ie.receipts.lines.update_coa\":\"/ie/receipts/{receipt}/lines/{line}/update_coa\",\"ie.receipts.lines.update_dff\":\"/ie/receipts/{receipt}/lines/{line}/update_dff\",\"ie.receipts.lines.duplicate\":\"/ie/receipts/{receipt}/lines/{line}/duplicate\",\"ie.receipts.lines.remove\":\"/ie/receipts/{receipt}/lines/{line}/remove\",\"ie.receipts.lines.get_show_infos\":\"/ie/receipts/{receipt}/lines/{line}/get_show_infos\",\"ie.receipts.lines.form_create\":\"/ie/receipts/{receipt}/lines/form_create\",\"ie.receipts.lines.get_sub_categories\":\"/ie/receipts/{receipt}/lines/get_sub_categories\",\"ie.receipts.lines.sub_category.get_form_informations\":\"/ie/receipts/{receipt}/lines/sub_category/{sub_category}/get_form_informations\",\"ie.receipts.lines.sub_category.get_form_amount\":\"/ie/receipts/{receipt}/lines/sub_category/{sub_category}/get_form_amount\",\"ie.receipts.lines.form_coa\":\"/ie/receipts/{receipt}/lines/{line}/form_coa\",\"ie.receipts.lines.input_cost_center_code\":\"/ie/receipts/{receipt}/lines/{line}/input_cost_center_code\",\"ie.receipts.lines.input_budget_detail_code\":\"/ie/receipts/{receipt}/lines/{line}/input_budget_detail_code\",\"ie.receipts.lines.input_sub_account_code\":\"/ie/receipts/{receipt}/lines/{line}/input_sub_account_code\",\"ie.receipts.lines.validate_combination\":\"/ie/receipts/{receipt}/lines/{line}/validate_combination\",\"ie.receipts.lines.form_edit\":\"/ie/receipts/{receipt}/lines/{line}/form_edit\",\"ie.receipts.lines.get_form_edit_informations\":\"/ie/receipts/{receipt}/lines/{line}/get_form_edit_informations\",\"ie.receipts.lines.get_form_edit_amount\":\"/ie/receipts/{receipt}/lines/{line}/get_form_edit_amount\",\"ie.dff.get_form\":\"/ie/dff/get_form\",\"ie.dff.get_form_header\":\"/ie/dff/get_form_header\",\"ie.dff.get_form_line\":\"/ie/dff/get_form_line\",\"ie.attachments.download\":\"/ie/attachments/{attachment_id}/download\",\"ie.attachments.image\":\"/ie/attachments/{attachment_id}/image\",\"ie.attachments.image_modal\":\"/ie/attachments/{attachment_id}/image\",\"ie.attachments.remove\":\"/ie/attachments/{attachment_id}/remove\",\"ie.settings.locations.index\":\"/ie/settings/locations\",\"ie.settings.locations.create\":\"/ie/settings/locations/create\",\"ie.settings.locations.edit\":\"/ie/settings/locations/{location}/edit\",\"ie.settings.locations.update\":\"/ie/settings/locations/{location}\",\"ie.settings.categories.index\":\"/ie/settings/categories\",\"ie.settings.categories.create\":\"/ie/settings/categories/create\",\"ie.settings.categories.store\":\"/ie/settings/categories\",\"ie.settings.categories.edit\":\"/ie/settings/categories/{category}/edit\",\"ie.settings.categories.update\":\"/ie/settings/categories/{category}\",\"ie.settings.categories.remove\":\"/ie/settings/categories/{category}/remove\",\"ie.settings.validate_combination\":\"/ie/settings/categories/{category}/sub_categories/validate_combination\",\"ie.settings.form_set_account\":\"/ie/settings/categories/{category}/sub_categories/form_set_account\",\"ie.settings.input_cost_center_code\":\"/ie/receipts/{receipt}/lines/{line}/input_cost_center_code\",\"ie.settings.input_budget_detail_code\":\"/ie/receipts/{receipt}/lines/{line}/input_budget_detail_code\",\"ie.settings.input_sub_account_code\":\"/ie/settings/ca-categories/{ca_category}/ca_sub_categories/input_sub_account_code\",\"ie.settings.sub-categories.index\":\"/ie/settings/categories/{category}/sub-categories\",\"ie.settings.sub-categories.create\":\"/ie/settings/categories/{category}/sub-categories/create\",\"ie.settings.sub-categories.store\":\"/ie/settings/categories/{category}/sub-categories\",\"ie.settings.sub-categories.show\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}\",\"ie.settings.sub-categories.edit\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/edit\",\"ie.settings.sub-categories.update\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}\",\"ie.settings.sub-categories.destroy\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}\",\"ie.settings.sub-categories.infos.index\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos\",\"ie.settings.sub-categories.infos.create\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/create\",\"ie.settings.sub-categories.infos.store\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos\",\"ie.settings.sub-categories.infos.show\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}\",\"ie.settings.sub-categories.infos.edit\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}/edit\",\"ie.settings.sub-categories.infos.update\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}\",\"ie.settings.sub-categories.infos.destroy\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}\",\"ie.settings.sub-categories.input_form_type\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/input_form_type/{input_form_type}\",\"ie.settings.sub-categories.infos.inactive\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/infos/{info}/inactive\",\"ie.settings.policies.index\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies\",\"ie.settings.policies.create\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/create\",\"ie.settings.policies.store\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies\",\"ie.settings.policies.inactive\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/inactive\",\"ie.settings.policies.rates.index\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates\",\"ie.settings.policies.rates.create\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/create\",\"ie.settings.policies.rates.store\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates\",\"ie.settings.policies.rates.show\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}\",\"ie.settings.policies.rates.edit\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}/edit\",\"ie.settings.policies.rates.update\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}\",\"ie.settings.policies.rates.destroy\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}\",\"ie.settings.policies.rates.inactive\":\"/ie/settings/categories/{category}/sub-categories/{sub_category}/policies/{policy}/rates/{rate}/inactive\",\"ie.settings.ca-categories.index\":\"/ie/settings/ca-categories\",\"ie.settings.ca-categories.create\":\"/ie/settings/ca-categories/create\",\"ie.settings.ca-categories.store\":\"/ie/settings/ca-categories\",\"ie.settings.ca-categories.edit\":\"/ie/settings/ca-categories/{ca_category}/edit\",\"ie.settings.ca-categories.update\":\"/ie/settings/ca-categories/{ca_category}\",\"ie.settings.ca-categories.remove\":\"/ie/settings/ca-categories/{ca_category}/remove\",\"ie.settings.ca-sub-categories.index\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories\",\"ie.settings.ca-sub-categories.create\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/create\",\"ie.settings.ca-sub-categories.store\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories\",\"ie.settings.ca-sub-categories.show\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}\",\"ie.settings.ca-sub-categories.edit\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/edit\",\"ie.settings.ca-sub-categories.update\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}\",\"ie.settings.ca-sub-categories.destroy\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}\",\"ie.settings.ca-sub-categories.infos.index\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos\",\"ie.settings.ca-sub-categories.infos.create\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/create\",\"ie.settings.ca-sub-categories.infos.store\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos\",\"ie.settings.ca-sub-categories.infos.show\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}\",\"ie.settings.ca-sub-categories.infos.edit\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}/edit\",\"ie.settings.ca-sub-categories.infos.update\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}\",\"ie.settings.ca-sub-categories.infos.destroy\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}\",\"ie.settings.ca-sub-categories.input_form_type\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/input_form_type/{input_form_type}\",\"ie.settings.ca-sub-categories.infos.inactive\":\"/ie/settings/ca-categories/{ca_category}/ca-sub-categories/{ca_sub_category}/infos/{info}/inactive\",\"ie.settings.preferences.index\":\"/ie/settings/preferences\",\"ie.settings.preferences.update\":\"/ie/settings/preferences/update\",\"ie.settings.preferences.update_mapping_ous\":\"/ie/settings/preferences/update_mapping_ous\",\"ie.settings.preferences.slice_json\":\"/ie/settings/preferences/slice_json\",\"ie.settings.user-accounts.index\":\"/ie/settings/user-accounts\",\"ie.settings.user-accounts.store\":\"/ie/settings/user-accounts\",\"ie.settings.user-accounts.update\":\"/ie/settings/user-accounts/{user_account}\",\"ie.settings.user-accounts.destroy\":\"/ie/settings/user-accounts/{user_account}\",\"ie.settings.user-accounts.form_edit\":\"/ie/settings/user-accounts/{account_id}/form_edit\",\"ie.settings.user-accounts.sync\":\"/ie/settings/user-accounts/sync\",\"ie.report.pdf\":\"/ie/report/{parent}\",\"inv.requisition_stationery.copy\":\"/inv/requisition_stationery/{id}/copy\",\"inv.requisition_stationery.approve\":\"/inv/requisition_stationery/{id}/approve\",\"inv.requisition_stationery.index\":\"/inv/requisition_stationery\",\"inv.requisition_stationery.create\":\"/inv/requisition_stationery/create\",\"inv.requisition_stationery.store\":\"/inv/requisition_stationery\",\"inv.requisition_stationery.show\":\"/inv/requisition_stationery/{requisition_stationery}\",\"inv.requisition_stationery.edit\":\"/inv/requisition_stationery/{requisition_stationery}/edit\",\"inv.requisition_stationery.update\":\"/inv/requisition_stationery/{requisition_stationery}\",\"inv.disbursement_fuel.add_new_car\":\"/inv/disbursement_fuel/add_new_car\",\"inv.disbursement_fuel.print\":\"/inv/disbursement_fuel/print\",\"inv.disbursement_fuel.show\":\"/inv/disbursement_fuel/show\",\"inv.disbursement_fuel.index\":\"/inv/disbursement_fuel\",\"inv.disbursement_fuel.create\":\"/inv/disbursement_fuel/create\",\"inv.disbursement_fuel.store\":\"/inv/disbursement_fuel\",\"inv.disbursement_fuel.edit\":\"/inv/disbursement_fuel/{disbursement_fuel}/edit\",\"inv.disbursement_fuel.update\":\"/inv/disbursement_fuel/{disbursement_fuel}\",\"inv.ajax.issue_header\":\"/inv/ajax/issue_header\",\"inv.ajax.issue_profile_V\":\"/inv/ajax/issue_profile_V\",\"inv.ajax.coa_dept_code\":\"/inv/ajax/coa_dept_code\",\"inv.ajax.subinventory\":\"/inv/ajax/subinventory\",\"inv.ajax.secondary_inventories\":\"/inv/ajax/secondary_inventories\",\"inv.ajax.alias_name\":\"/inv/ajax/alias_name\",\"inv.ajax.system_item\":\"/inv/ajax/system_item\",\"inv.ajax.car_info\":\"/inv/ajax/car_info\",\"inv.ajax.car_history\":\"/inv/ajax/car_history\",\"inv.ajax.gl_code_combinations\":\"/inv/ajax/gl_code_combinations\",\"inv.ajax.web_fuel_dist\":\"/inv/ajax/web_fuel_dist\",\"inv.ajax.web_fuel_oil\":\"/inv/ajax/web_fuel_oil\",\"inv.ajax.item_locations\":\"/inv/ajax/item_locations\",\"inv.ajax.car_types\":\"/inv/ajax/car_types\",\"inv.ajax.car_brands\":\"/inv/ajax/car_brands\",\"inv.ajax.car_fuels\":\"/inv/ajax/car_fuels\",\"inv.ajax.employees\":\"/inv/ajax/employees\",\"inv.ajax.lookup_types\":\"/inv/ajax/lookup_types\",\"inv.ajax.lookup_values\":\"/inv/ajax/lookup_values\",\"inv.ajax.organization_units\":\"/inv/ajax/organization_units\",\"qm.api.settings.specifications.store\":\"/qm/api/settings/specifications\",\"qm.settings.check-points-tobacco-leaf.index\":\"/qm/settings/check-points-tobacco-leaf\",\"qm.settings.check-points-tobacco-leaf.create\":\"/qm/settings/check-points-tobacco-leaf/create\",\"qm.settings.check-points-tobacco-leaf.store\":\"/qm/settings/check-points-tobacco-leaf/store\",\"qm.settings.check-points-tobacco-leaf.update\":\"/qm/settings/check-points-tobacco-leaf/update\",\"qm.settings.check-points-tobacco-leaf.edit\":\"/qm/settings/check-points-tobacco-leaf/{id}/edit\",\"qm.settings.check-points-tobacco-beetle.index\":\"/qm/settings/check-points-tobacco-beetle\",\"qm.settings.check-points-tobacco-beetle.create\":\"/qm/settings/check-points-tobacco-beetle/create\",\"qm.settings.check-points-tobacco-beetle.store\":\"/qm/settings/check-points-tobacco-beetle/store\",\"qm.settings.check-points-tobacco-beetle.edit\":\"/qm/settings/check-points-tobacco-beetle/{id}/edit\",\"qm.settings.check-points-tobacco-beetle.update\":\"/qm/settings/check-points-tobacco-beetle/update\",\"qm.settings.attachments.download\":\"/qm/settings/attachments/{attachment}/download\",\"qm.settings.attachments.image\":\"/qm/settings/attachments/{attachment}/image\",\"qm.settings.test-unit.index\":\"/qm/settings/test-unit\",\"qm.settings.test-unit.create\":\"/qm/settings/test-unit/create\",\"qm.settings.test-unit.edit\":\"/qm/settings/test-unit/{qcunit_code}/edit\",\"qm.settings.test-unit.store\":\"/qm/settings/test-unit/store\",\"qm.settings.test-unit.update\":\"/qm/settings/test-unit/update\",\"qm.settings.qc-area.index\":\"/qm/settings/qc-area\",\"qm.settings.qc-area.update\":\"/qm/settings/qc-area/update\",\"qm.settings.define-tests-tobacco-leaf.index\":\"/qm/settings/define-tests-tobacco-leaf\",\"qm.settings.define-tests-tobacco-leaf.create\":\"/qm/settings/define-tests-tobacco-leaf/create\",\"qm.settings.define-tests-tobacco-leaf.store\":\"/qm/settings/define-tests-tobacco-leaf/store\",\"qm.settings.define-tests-tobacco-leaf.update\":\"/qm/settings/define-tests-tobacco-leaf/update\",\"qm.settings.define-tests-tobacco-beetle.index\":\"/qm/settings/define-tests-tobacco-beetle\",\"qm.settings.define-tests-tobacco-beetle.create\":\"/qm/settings/define-tests-tobacco-beetle/create\",\"qm.settings.define-tests-tobacco-beetle.store\":\"/qm/settings/define-tests-tobacco-beetle/store\",\"qm.settings.define-tests-tobacco-beetle.update\":\"/qm/settings/define-tests-tobacco-beetle/update\",\"qm.settings.define-tests-finished-products.index\":\"/qm/settings/define-tests-finished-products\",\"qm.settings.define-tests-finished-products.create\":\"/qm/settings/define-tests-finished-products/create\",\"qm.settings.define-tests-finished-products.store\":\"/qm/settings/define-tests-finished-products/store\",\"qm.settings.define-tests-finished-products.update\":\"/qm/settings/define-tests-finished-products/update\",\"qm.settings.define-tests-qtm-machines.index\":\"/qm/settings/define-tests-qtm-machines\",\"qm.settings.define-tests-qtm-machines.create\":\"/qm/settings/define-tests-qtm-machines/create\",\"qm.settings.define-tests-qtm-machines.store\":\"/qm/settings/define-tests-qtm-machines/store\",\"qm.settings.define-tests-qtm-machines.update\":\"/qm/settings/define-tests-qtm-machines/update\",\"qm.settings.define-tests-packet-air-leaks.index\":\"/qm/settings/define-tests-packet-air-leaks\",\"qm.settings.define-tests-packet-air-leaks.create\":\"/qm/settings/define-tests-packet-air-leaks/create\",\"qm.settings.define-tests-packet-air-leaks.store\":\"/qm/settings/define-tests-packet-air-leaks/store\",\"qm.settings.define-tests-packet-air-leaks.update\":\"/qm/settings/define-tests-packet-air-leaks/update\",\"qm.settings.specifications.index\":\"/qm/settings/specifications\",\"qm.ajax.tobaccos.get-sample-specifications\":\"/qm/ajax/tobaccos/get-sample-specifications\",\"qm.ajax.tobaccos.store-sample-result\":\"/qm/ajax/tobaccos/result\",\"qm.ajax.finished-products.get-sample-specifications\":\"/qm/ajax/finished-products/get-sample-specifications\",\"qm.ajax.finished-products.store-sample-result\":\"/qm/ajax/finished-products/result\",\"qm.ajax.qtm-machines.get-sample-specifications\":\"/qm/ajax/qtm-machines/get-sample-specifications\",\"qm.ajax.qtm-machines.store-sample-result\":\"/qm/ajax/qtm-machines/result\",\"qm.ajax.packet-air-leaks.get-sample-specifications\":\"/qm/ajax/packet-air-leaks/get-sample-specifications\",\"qm.ajax.packet-air-leaks.store-sample-result\":\"/qm/ajax/packet-air-leaks/result\",\"qm.ajax.moth-outbreaks.get-sample-specifications\":\"/qm/ajax/moth-outbreaks/get-sample-specifications\",\"qm.ajax.moth-outbreaks.store-sample-result\":\"/qm/ajax/moth-outbreaks/result\",\"qm.ajax.moth-outbreaks.upload-excel-file\":\"/qm/ajax/moth-outbreaks/upload-excel-file\",\"qm.tobaccos.create\":\"/qm/tobaccos/create\",\"qm.tobaccos.result\":\"/qm/tobaccos/result\",\"qm.tobaccos.report-summary\":\"/qm/tobaccos/report-summary\",\"qm.tobaccos.export-excel.report-summary\":\"/qm/tobaccos/export-excel/report-summary\",\"qm.tobaccos.store\":\"/qm/tobaccos\",\"qm.finished-products.create\":\"/qm/finished-products/create\",\"qm.finished-products.result\":\"/qm/finished-products/result\",\"qm.finished-products.track\":\"/qm/finished-products/track\",\"qm.finished-products.report-summary\":\"/qm/finished-products/report-summary\",\"qm.finished-products.report-issue\":\"/qm/finished-products/report-issue\",\"qm.finished-products.export-excel.report-summary\":\"/qm/finished-products/export-excel/report-summary\",\"qm.finished-products.export-excel.report-issue\":\"/qm/finished-products/export-excel/report-issue\",\"qm.finished-products.store\":\"/qm/finished-products\",\"qm.finished-products.store-result\":\"/qm/finished-products/result\",\"qm.qtm-machines.create\":\"/qm/qtm-machines/create\",\"qm.qtm-machines.result\":\"/qm/qtm-machines/result\",\"qm.qtm-machines.track\":\"/qm/qtm-machines/track\",\"qm.qtm-machines.report-summary\":\"/qm/qtm-machines/report-summary\",\"qm.qtm-machines.report-under-average\":\"/qm/qtm-machines/report-under-average\",\"qm.qtm-machines.report-product-quality\":\"/qm/qtm-machines/report-product-quality\",\"qm.qtm-machines.report-physical-value\":\"/qm/qtm-machines/report-physical-value\",\"qm.qtm-machines.export-excel.report-under-average\":\"/qm/qtm-machines/export-excel/report-under-average\",\"qm.qtm-machines.export-excel.report-product-quality\":\"/qm/qtm-machines/export-excel/report-product-quality\",\"qm.qtm-machines.export-excel.report-physical-value\":\"/qm/qtm-machines/export-excel/report-physical-value\",\"qm.qtm-machines.store\":\"/qm/qtm-machines\",\"qm.qtm-machines.store-result\":\"/qm/qtm-machines/result\",\"qm.packet-air-leaks.create\":\"/qm/packet-air-leaks/create\",\"qm.packet-air-leaks.result\":\"/qm/packet-air-leaks/result\",\"qm.packet-air-leaks.track\":\"/qm/packet-air-leaks/track\",\"qm.packet-air-leaks.report-summary\":\"/qm/packet-air-leaks/report-summary\",\"qm.packet-air-leaks.report-leak-rate\":\"/qm/packet-air-leaks/report-leak-rate\",\"qm.packet-air-leaks.export-excel.report-summary\":\"/qm/packet-air-leaks/export-excel/report-summary\",\"qm.packet-air-leaks.export-excel.report-leak-rate\":\"/qm/packet-air-leaks/export-excel/report-leak-rate\",\"qm.packet-air-leaks.store\":\"/qm/packet-air-leaks\",\"qm.packet-air-leaks.store-result\":\"/qm/packet-air-leaks/result\",\"qm.moth-outbreaks.create\":\"/qm/moth-outbreaks/create\",\"qm.moth-outbreaks.result\":\"/qm/moth-outbreaks/result\",\"qm.moth-outbreaks.track\":\"/qm/moth-outbreaks/track\",\"qm.moth-outbreaks.report-summary\":\"/qm/moth-outbreaks/report-summary\",\"qm.moth-outbreaks.export-excel.report-summary\":\"/qm/moth-outbreaks/export-excel/report-summary\",\"qm.moth-outbreaks.store\":\"/qm/moth-outbreaks\",\"qm.moth-outbreaks.store-result\":\"/qm/moth-outbreaks/result\",\"qm.files.image\":\"/qm/files/image/{module}/{menu}/{feature}/{fileName}\",\"qm.files.image-thumbnail\":\"/qm/files/image-thumbnail/{module}/{menu}/{feature}/{fileName}\",\"qm.files.download\":\"/qm/files/download/{module}/{menu}/{feature}/{fileType}/{fileName}\",\"planning.machine-yearly.index\":\"/planning/machine-yearly\",\"planning.machine-yearly.store\":\"/planning/machine-yearly\",\"planning.machine-yearly.update\":\"/planning/machine-yearly/{id}/update\",\"planning.machine-yearly.update-lines\":\"/planning/machine-yearly/{id}/update-lines\",\"planning.machine-biweekly.index\":\"/planning/machine-biweekly\",\"planning.machine-biweekly.store\":\"/planning/machine-biweekly\",\"planning.machine-biweekly.update\":\"/planning/machine-biweekly/{id}/update\",\"planning.machine-biweekly.update-lines\":\"/planning/machine-biweekly/{id}/update-lines\",\"planning.machine-biweekly.update_plan_pm\":\"/planning/update_plan_pm/{biweeklyId}\",\"planning.machine-biweekly.downtime\":\"/planning/machine-downtime\",\"planning.production-biweekly.index\":\"/planning/production-biweekly\",\"planning.production-biweekly.show\":\"/planning/production-biweekly/{production_biweekly}\",\"planning.adjusts.store\":\"/planning/adjusts\",\"planning.adjusts.show\":\"/planning/adjusts/{adjust}\",\"planning.follow-ups.index\":\"/planning/follow-ups\",\"planning.production-daily.show\":\"/planning/production-daily/{id}\",\"planning.ajax.\":\"/planning/ajax/get-biWeekly-machine\",\"planning.ajax.biWeekly.\":\"/planning/ajax/biWeekly/get-plan-machine\",\"planning.ajax.biWeekly.prod.get-est-data\":\"/planning/ajax/biWeekly/get-est-data\",\"planning.ajax.biWeekly.prod.get-avg-data\":\"/planning/ajax/biWeekly/get-avg-data\",\"planning.ajax.production-biweekly.modal-create-details\":\"/planning/ajax/production-biweekly/modal-create-details\",\"planning.ajax.production-biweekly.search\":\"/planning/ajax/production-biweekly/search\",\"planning.ajax.production-biweekly.store\":\"/planning/ajax/production-biweekly\",\"planning.ajax.production-biweekly.update\":\"/planning/ajax/production-biweekly/{productionBiweeklyMain}\",\"planning.ajax.production-biweekly.approve\":\"/planning/ajax/production-biweekly/approve/{productionBiweeklyMain}\",\"planning.ajax.production-biweekly.check-approve\":\"/planning/ajax/production-biweekly/check-approve/{productionBiweeklyMain}\",\"planning.ajax.production-biweekly.get-plan-machine\":\"/planning/ajax/production-biweekly/get-plan-machine\",\"planning.ajax.production-biweekly.get-est-data\":\"/planning/ajax/production-biweekly/get-est-data\",\"planning.ajax.production-biweekly.get-avg-data\":\"/planning/ajax/production-biweekly/get-avg-data\",\"planning.ajax.production-biweekly.get-est-by-biweekly\":\"/planning/ajax/production-biweekly/get-est-by-biweekly\",\"planning.ajax.adjusts.search\":\"/planning/ajax/adjusts/search\",\"planning.ajax.adjusts.search-create\":\"/planning/ajax/adjusts/search-create\",\"planning.ajax.adjusts.search-item\":\"/planning/ajax/adjusts/search-item\",\"planning.ajax.adjusts.update\":\"/planning/ajax/adjusts/{productionBiweeklyMain}\",\"planning.ajax.adjusts.update-note\":\"/planning/ajax/adjusts/update-note/{id}\",\"planning.ajax.adjusts.get-adj-data\":\"/planning/ajax/adjusts/get-adj-data\",\"planning.ajax.adjusts.approve\":\"/planning/ajax/adjusts/approve/{productionBiweeklyMain}\",\"planning.ajax.adjusts.check-approve\":\"/planning/ajax/adjusts/check-approve/{productionBiweeklyMain}\",\"planning.ajax.follow-ups.search\":\"/planning/ajax/follow-ups/search\",\"planning.ajax.follow-ups.get-data\":\"/planning/ajax/follow-ups/get-data\",\"planning.ajax.production-daily.modal-create-details\":\"/planning/ajax/production-daily/modal-create-details\",\"planning.ajax.production-daily.search\":\"/planning/ajax/production-daily/search\",\"planning.ajax.production-daily.create\":\"/planning/ajax/production-daily/create\",\"planning.ajax.production-daily.get-om-sales-forecast\":\"/planning/ajax/production-daily/get-om-sales-forecast\",\"planning.ajax.production-daily.get-production-machine\":\"/planning/ajax/production-daily/get-production-machine\",\"planning.ajax.production-daily.get-production-item\":\"/planning/ajax/production-daily/get-production-item\",\"planning.ajax.production-daily.submit-production-machine\":\"/planning/ajax/production-daily/machine\",\"planning.ajax.production-daily.check-approve\":\"/planning/ajax/production-daily/check-approve/{machineBiweekly}/daily-plan/{dailyPlan}\",\"planning.ajax.production-daily.approve\":\"/planning/ajax/production-daily/approve/{dailyPlan}\",\"planning.ajax.production-daily.check-unapprove\":\"/planning/ajax/production-daily/check-unapprove/{machineBiweekly}/daily-plan/{dailyPlan}\",\"planning.ajax.production-daily.unapprove\":\"/planning/ajax/production-daily/unapprove/{dailyPlan}\",\"planning.ajax.production-daily.get-grp-efficiency-product\":\"/planning/ajax/production-daily/get-grp-efficiency-product\",\"planning.ajax.production-daily.update_working_hour\":\"/planning/ajax/production-daily/update-working-hour/{res_plan_h_id}\",\"pm.ajax.material-requests.lines\":\"/pm/ajax/material-requests/lines\",\"pm.ajax.material-requests.get-item\":\"/pm/ajax/material-requests/get-item\",\"pm.ajax.material-requests.store\":\"/pm/ajax/material-requests/store\",\"pm.ajax.material-requests.set-status\":\"/pm/ajax/material-requests/set-status/{requestHeader}\",\"pm.ajax.transfer-products.get-lines\":\"/pm/ajax/transfer-products/get-lines\",\"pm.ajax.transfer-products.get-item\":\"/pm/ajax/transfer-products/get-item\",\"pm.ajax.transfer-products.store\":\"/pm/ajax/transfer-products/store\",\"pm.ajax.transfer-products.set-status\":\"/pm/ajax/transfer-products/set-status/{header}\",\"pm.ajax.send-cigarettes.get-lines\":\"/pm/ajax/send-cigarettes/get-lines\",\"pm.ajax.send-cigarettes.get-item\":\"/pm/ajax/send-cigarettes/get-item\",\"pm.ajax.send-cigarettes.store\":\"/pm/ajax/send-cigarettes/store\",\"pm.ajax.send-cigarettes.set-status\":\"/pm/ajax/send-cigarettes/set-status/{header}\",\"pm.ajax.wip-requests.get-lines\":\"/pm/ajax/wip-requests/get-lines\",\"pm.ajax.wip-requests.get-item\":\"/pm/ajax/wip-requests/get-item\",\"pm.ajax.wip-requests.store\":\"/pm/ajax/wip-requests/store\",\"pm.ajax.wip-requests.set-status\":\"/pm/ajax/wip-requests/set-status/{header}\",\"pm.ajax.jams.get-lines\":\"/pm/ajax/jams/get-lines\",\"pm.ajax.jams.get-item\":\"/pm/ajax/jams/get-item\",\"pm.ajax.jams.store\":\"/pm/ajax/jams/store\",\"pm.ajax.jams.set-status\":\"/pm/ajax/jams/set-status/{header}\",\"pm.ajax.ingredient-preparation-qrcode\":\"/pm/ajax/ingredient-preparation-qrcode\",\"pm.ajax.ingredient-preparation-detail\":\"/pm/ajax/ingredient-preparation-detail\",\"pm.material-requests.index\":\"/pm/material-requests\",\"pm.transfer-products.index\":\"/pm/transfer-products\",\"pm.send-cigarettes.index\":\"/pm/send-cigarettes\",\"pm.wip-requests.index\":\"/pm/wip-requests\",\"pm.jams.index\":\"/pm/jams\",\"pm.ingredient-preparation.index\":\"/pm/ingredient-preparation\",\"pm.ingredient-preparation.print-pdf\":\"/pm/ingredient-preparation/print-pdf\",\"pm.ajax.qrcode-check-mtls.detail\":\"/pm/ajax/qrcode-check-mtls/detail\",\"pm.ajax.qrcode-transfer-mtls.detail\":\"/pm/ajax/qrcode-transfer-mtls/detail\",\"pm.ajax.qrcode-rcv-transfer-mtls.detail\":\"/pm/ajax/qrcode-rcv-transfer-mtls/detail\",\"pm.ajax.qrcode-return-mtls.detail\":\"/pm/ajax/qrcode-return-mtls/detail\",\"pm.qrcode-check-mtls.index\":\"/pm/qrcode-check-mtls\",\"pm.qrcode-transfer-mtls.index\":\"/pm/qrcode-transfer-mtls\",\"pm.qrcode-rcv-transfer-mtls.index\":\"/pm/qrcode-rcv-transfer-mtls\",\"pm.qrcode-return-mtls.index\":\"/pm/qrcode-return-mtls\",\"ajax.pm.planning-jobs.index\":\"/ajax/pm/planning-jobs\",\"pm.planning-jobs.index\":\"/pm/planning-jobs\",\"pm.ajax.confirm-order.store\":\"/pm/ajax/confirm-order\",\"pm.ajax.confirm-order.get-lines\":\"/pm/ajax/confirm-order/get-lines\",\"pm.ajax.confirm-order.get-distributions\":\"/pm/ajax/confirm-order/get-distributions\",\"pm.ajax.confirm-order.get-wipstep\":\"/pm/ajax/confirm-order/get-wipstep\",\"pm.ajax.confirm-order.get-search\":\"/pm/ajax/confirm-order/get-search\",\"pm.ajax.confirm-order.update-orders\":\"/pm/ajax/confirm-order-update\",\"pm.confirm-order.index\":\"/pm/confirm-order\",\"pm.sample-report.report\":\"/pm/sample-report/{number}\",\"pm.sample-report.report1-pdf\":\"/pm/sample-report1-pdf/{number}\",\"pm.sample-report.report-inventory-pdf\":\"/pm/sample-report-inventory-pdf/{batchNo}/{departmentCode}/{txnDate}\",\"pm.sample-report.report-summary-pdf\":\"/pm/sample-report-summary-pdf/{departmentCode}/{startDate}/{endDate}\",\"pm.sample-report.report-vue\":\"/pm/sample-report-vue\",\"pm.sample-report.report1\":\"/pm/sample-report1\",\"pm.sample-report.report2\":\"/pm/sample-report2\",\"pm.sample-report.testPdf\":\"/pm/test-pdf\",\"pm.ajax.wip-confirm.importMesData\":\"/pm/ajax/wip-confirm/importMesData\",\"pm.ajax.wip-confirm.lines\":\"/pm/ajax/wip-confirm/lines\",\"pm.ajax.wip-confirm.store\":\"/pm/ajax/wip-confirm/store\",\"pm.wip-confirm.index\":\"/pm/wip-confirm\",\"pm.wip-confirm.search\":\"/pm/wip-confirm/search\",\"pm.wip-confirm.jobs\":\"/pm/wip-confirm/jobs\",\"pm.wip-confirm.export-pdf-parameters\":\"/pm/wip-confirm/export-pdf-parameters/{report_code}\",\"pm.wip-confirm.export-pdf\":\"/pm/wip-confirm/export-pdf\",\"pm.ajax.get-me-review-issues-v\":\"/pm/ajax/get-mes-review-issues\",\"pm.ajax.opt-from-blend-no\":\"/pm/ajax/get-opt-from-blend-no\",\"pm.ajax.get-oprn-by-item\":\"/pm/ajax/get-oprn-by-item\",\"pm.ajax.get-formulas\":\"/pm/ajax/get-formulas\",\"pm.ajax.save-data\":\"/pm/ajax/save-data\",\"pm.ajax.update-data\":\"/pm/ajax/update-data\",\"pm.ajax.find-classification\":\"/pm/ajax/find-classification\",\"pm.ajax.get-headers\":\"/pm/ajax/get-headers\",\"pm.ajax.cancel-data\":\"/pm/ajax/cancel-data\",\"pm.ajax.search-header\":\"/pm/ajax/search-header\",\"pm.wip-issue.index\":\"/pm/wip-issue\",\"pm.wip-issue.casing-flavor-index\":\"/pm/wip-issue/casing-flavor\",\"pm.wip-issue.issue\":\"/pm/wip-issue/issue\",\"pm.wip-issue.cut_of\":\"/pm/wip-issue/cut_of\",\"pd.ajax.exp-formulas.get-lines\":\"/pd/ajax/exp-formulas/get-lines\",\"pd.ajax.exp-formulas.get-data\":\"/pd/ajax/exp-formulas/get-data\",\"pd.ajax.exp-formulas.compare-data\":\"/pd/ajax/exp-formulas/compare-data\",\"pd.ajax.exp-formulas.store\":\"/pd/ajax/exp-formulas/store\",\"pd.ajax.exp-formulas.set-status\":\"/pd/ajax/exp-formulas/set-status/{header}\",\"pd.exp-formulas.index\":\"/pd/exp-formulas\",\"ct.cost_center.index\":\"/ct/cost_center\",\"ct.cost_center.create\":\"/ct/cost_center/create\",\"ct.cost_center.edit\":\"/ct/cost_center/{cost_center_id}\",\"ct.specify_percentage.create\":\"/ct/specify_percentage\",\"ct.product_group.index\":\"/ct/product_group\",\"ct.criterion_allocate.index\":\"/ct/criterion_allocate\",\"ct.set_account_type.index\":\"/ct/set_account_type\",\"ct.account_code_ledger.index\":\"/ct/account_code_ledger\",\"ct.agency.show\":\"/ct/agency/{flex_value_set_id}\",\"ct.specify_agency.index\":\"/ct/specify_agency\",\"ct.product_plan_amount.index\":\"/ct/product_plan_amount\",\"ct.tax_medicine.index\":\"/ct/tax_medicine\",\"ct.tax_medicine.create\":\"/ct/tax_medicine/create\",\"ct.tax_medicine.edit\":\"/ct/tax_medicine/{tax_medicine}\",\"ct.ajax.account.index\":\"/ct/ajax/account\",\"ct.ajax.ptgl_accounts_info.get_data_by_segment\":\"/ct/ajax/get_data_by_segment/{segment}\",\"ct.ajax.ptpm_item_number_v.get_category\":\"/ct/ajax/get_category\",\"ct.ajax.ptpm_item_number_v.get_organizations\":\"/ct/ajax/get_organizations\",\"ct.ajax.\":\"/ct/ajax/inv_org\",\"ct.ajax.ptpm_item_number_v.get_raw_material\":\"/ct/ajax/get_raw_material\",\"ct.ajax.cost_center.\":\"/ct/ajax/cost_center\",\"ct.ajax.cost_center.index\":\"/ct/ajax/cost_center\",\"ct.ajax.cost_center.find\":\"/ct/ajax/cost_center/find\",\"ct.ajax.cost_center.update_active\":\"/ct/ajax/cost_center/update_active\",\"ct.ajax.cost_center.period_years\":\"/ct/ajax/cost_center/period_years\",\"ct.ajax.cost_center.update_ct\":\"/ct/ajax/cost_center/update_ct\",\"ct.ajax.cost_center.update\":\"/ct/ajax/cost_center/update\",\"ct.ajax.cost_center.years\":\"/ct/ajax/cost_center/years\",\"ct.ajax.cost_center.codes\":\"/ct/ajax/cost_center/codes\",\"ct.ajax.cost_center.ptpm_items\":\"/ct/ajax/cost_center/ptpm_items\",\"ct.ajax.product_group.index\":\"/ct/ajax/product_group\",\"ct.ajax.product_group.find\":\"/ct/ajax/product_group/find\",\"ct.ajax.product_group.copy.get\":\"/ct/ajax/product_group/copy/{code}\",\"ct.ajax.product_group.copy.post\":\"/ct/ajax/product_group/copy\",\"ct.ajax.product_group_detail.update\":\"/ct/ajax/product_group_detail/update\",\"ct.ajax.product_group_detail.findWithProductGroup\":\"/ct/ajax/product_group_detail/find_pg/{product_group_id}\",\"ct.ajax.product_plan_amount.update\":\"/ct/ajax/product_plan_amount/update\",\"ct.ajax.product_processes.update\":\"/ct/ajax/product_processes\",\"ct.ajax.product_processes.show\":\"/ct/ajax/product_processes/{cost_center_id}\",\"ct.ajax.designate_agency.get_department\":\"/ct/ajax/designate_agency/get_department\",\"ct.ajax.set_account_type.getListSetAccountType\":\"/ct/ajax/set_account_type\",\"ct.ajax.set_account_type.update\":\"/ct/ajax/set_account_type/update\",\"ct.ajax.agency.update\":\"/ct/ajax/agency/update\",\"ct.ajax.account_code_ledger.store\":\"/ct/ajax/account_code_ledger\",\"ct.ajax.criterion_allocate.index\":\"/ct/ajax/criterion_allocate\",\"ct.ajax.criterion_allocate.update\":\"/ct/ajax/criterion_allocate/update\",\"ct.ajax.tax_medicine.index\":\"/ct/ajax/tax_medicine\",\"ct.ajax.tax_medicine.store\":\"/ct/ajax/tax_medicine\",\"ct.ajax.tax_medicine.determine\":\"/ct/ajax/tax_medicine/determine\",\"ct.ajax.tax_medicine.not_determine\":\"/ct/ajax/tax_medicine/not_determine\",\"ct.ajax.tax_medicine.update\":\"/ct/ajax/tax_medicine/{item_number}\",\"ct.ajax.tax_medicine.show\":\"/ct/ajax/tax_medicine/{item_number}\",\"pm.ajax.additive-inventory-alert.index\":\"/pm/ajax/additive-inventory-alert\",\"pm.ajax.additive-inventory-alert.store\":\"/pm/ajax/additive-inventory-alert/store\",\"pm.ajax.additive-inventory-alert.getTypeOrder\":\"/pm/ajax/additive-inventory-alert/get-type-order\",\"pm.ajax.additive-inventory-alert.saveReportNumber\":\"/pm/ajax/additive-inventory-alert/save-report-number\",\"pm.ajax.additive-inventory-alert.productLists\":\"/pm/ajax/additive-inventory-alert/product-lists\",\"pm.ajax.raw-material-inventory-alert.index\":\"/pm/ajax/raw-material-inventory-alert\",\"pm.ajax.raw-material-inventory-alert.store\":\"/pm/ajax/raw-material-inventory-alert/store\",\"pm.ajax.raw-material-inventory-alert.productLists\":\"/pm/ajax/raw-material-inventory-alert/product-lists\",\"pm.ajax.raw_material_report.index\":\"/pm/ajax/raw_material_report\",\"pm.ajax.raw_material_report.update-flag\":\"/pm/ajax/raw_material_report/update-flag\",\"pm.ajax.raw_material_list.index\":\"/pm/ajax/raw_material_list/get-cate\",\"pm.ajax.raw_material_list.find\":\"/pm/ajax/raw_material_list/find\",\"pm.ajax.raw_material_list.image-upload\":\"/pm/ajax/raw_material_list/image-upload\",\"pm.ajax.raw_material_list.image-remove\":\"/pm/ajax/raw_material_list/image-remove\",\"pm.ajax.raw_material_list.store\":\"/pm/ajax/raw_material_list/store\",\"pm.additive_inventory_alert.index\":\"/pm/0039\",\"pm.raw_material_inventory_alert.index\":\"/pm/0040\",\"pm.raw_material_list.index\":\"/pm/raw_material_list\",\"pm.raw_material_list.request-raw-material\":\"/pm/raw_material_list/request-raw-material\",\"pm.raw_material_list.inform-raw-material\":\"/pm/raw_material_list/inform-raw-material\",\"pm.raw_material_report.index\":\"/pm/raw_material_report\",\"pm.ajax.store\":\"/pm/ajax/request-raw-materials\",\"pm.ajax.update\":\"/pm/ajax/request-raw-materials/{id}\",\"pm.ajax.getListItemConvUomV\":\"/pm/ajax/get-list-item-conv-uomv\",\"pm.request-raw-materials.\":\"/pm/request-raw-materials\",\"pm.ajax.wip-loss-quantity.lines\":\"/pm/ajax/wip-loss-quantity/lines\",\"pm.ajax.wip-loss-quantity.store\":\"/pm/ajax/wip-loss-quantity/store\",\"pm.wip-loss-quantity.index\":\"/pm/wip-loss-quantity\",\"om.0083.index\":\"/om/0083\",\"om.claim/claim-approve.index\":\"/om/0083\"}");

/***/ })

}]);