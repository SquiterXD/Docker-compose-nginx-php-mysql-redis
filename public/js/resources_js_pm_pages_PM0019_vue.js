(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_PM0019_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _commonDialogs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../commonDialogs */ "./resources/js/commonDialogs.js");
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
// import showLoadingDialog from "../../commonDialogs"

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['lookups', 'items', 'dep_code', 'req_by', 'def_period_year'],
  mounted: function mounted() {// To do
  },
  data: function data() {
    return {
      current_date: this.getCurrentDate(),
      header_id: '',
      // thai_year: new Date().getFullYear() + 543,
      thai_year: this.def_period_year,
      thai_month: '',
      biweekly: '',
      biweekly_id: '',
      req_date: this.getCurrentDate(),
      item_code: '',
      start_date: '',
      end_date: '',
      min_date: '',
      max_date: '',
      send_date: this.getCurrentDate(),
      lines: [],
      isCheckedAll: false,
      checked: []
    };
  },
  computed: {
    maxSelectedDate: function maxSelectedDate() {
      var today = new Date();
      var max = new Date();
      max.setDate(today.getDate() + 365);
      var thaiYear = max.getFullYear() + 543;
      var month = max.getMonth() + 1;
      var day = max.getDate();
      return thaiYear + '-' + month + '-' + day;
    },
    checkDisableBtn: function checkDisableBtn() {
      return !(this.thai_year && this.thai_month && this.biweekly && this.item_code);
    },
    yearLists: function yearLists() {
      return _toConsumableArray(new Set(Array.from(this.lookups, function (lookup) {
        return lookup.thai_year;
      })));
    },
    monthLists: function monthLists() {
      var _this = this;

      var lookups = this.lookups.filter(function (lookup) {
        return lookup.thai_year == _this.thai_year;
      });
      return _toConsumableArray(new Set(Array.from(lookups, function (lookup) {
        return lookup.thai_month;
      })));
    },
    biweeklyLists: function biweeklyLists() {
      var _this2 = this;

      var lookups = this.lookups.filter(function (lookup) {
        return lookup.thai_year == _this2.thai_year && lookup.thai_month == _this2.thai_month;
      });
      return _toConsumableArray(new Set(Array.from(lookups, function (lookup) {
        return lookup.biweekly;
      })));
    }
  },
  methods: {
    onClickCreate: function onClickCreate() {
      // To do
      // this.thai_year = new Date().getFullYear() + 543,
      this.thai_year = this.def_period_year, this.thai_month = '';
      this.biweekly = '';
      this.biweekly_id = '';
      this.req_date = this.getCurrentDate();
      this.item_code = '';
      this.start_date = '';
      this.end_date = '';
      this.send_date = this.getCurrentDate(), this.lines = '';
    },
    onClickSave: function onClickSave() {
      var _this3 = this;

      var params = {
        biweekly_id: this.biweekly_id,
        department_code: this.dep_code,
        request_date: this.convertFormatDate(this.req_date),
        tobacco_group: this.item_code,
        product_date_from: this.convertFormatDate(this.start_date),
        product_date_to: this.convertFormatDate(this.end_date),
        request_by: this.req_by,
        send_date: this.convertFormatDate(this.send_date)
      };
      (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_0__.showLoadingDialog)();
      axios.post('/api/pm/0019/', params).then(function (response) {
        if (response.status == 200) {
          console.log(response);
          (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_0__.showSaveSuccessDialog)();
          _this3.lines = response.data.lines;
          _this3.header_id = response.data.header.bi_request_header_id;
        }
      })["catch"](function (error) {
        console.log(error);
      });
    },
    getCurrentDate: function getCurrentDate() {
      var y = new Date().getFullYear() + 543;
      var m = new Date().getMonth() + 1;
      var d = new Date().getDate();
      return y + '-' + m + '-' + d;
    },
    convertToThaiDate: function convertToThaiDate(d) {
      var yearThai = parseInt(d.split('-')[0]) + 543;
      return yearThai + '-' + d.split('-')[1] + '-' + d.split('-')[2];
    },
    convertFormatDate: function convertFormatDate(d) {
      var yyyy = new Date(d).getFullYear() - 543;
      var mm = new Date(d).getMonth() + 1;
      var dd = new Date(d).getDate();
      return yyyy + '-' + mm + '-' + dd;
    },
    onChangeYear: function onChangeYear() {// To do
      // this.thai_month = ''
      // this.biweekly = ''
      // this.display_date = ''
    },
    onChangeMonth: function onChangeMonth() {// To do
      // this.biweekly = ''
      // this.display_date = ''
    },
    onChangeBiweekly: function onChangeBiweekly() {
      var _this4 = this;

      // To do
      var lookup = this.lookups.filter(function (lookup) {
        return lookup.thai_year == _this4.thai_year && lookup.thai_month == _this4.thai_month && lookup.biweekly == _this4.biweekly;
      })[0];
      this.biweekly_id = lookup.biweekly_id;
      this.start_date = this.convertToThaiDate(lookup.start_date);
      this.min_date = this.convertToThaiDate(lookup.start_date);
      this.end_date = this.convertToThaiDate(lookup.end_date);
      this.max_date = this.convertToThaiDate(lookup.end_date);
    },
    validate: function validate() {
      var _this5 = this;

      var errors = [];

      if (this.checked.length > 0) {
        this.checked.forEach(function (lineId) {
          var line = _this5.lines.filter(function (line) {
            return line.bi_request_line_id == lineId;
          })[0];

          if (!line.request_qty) {
            errors.push('ปริมาณเบิก');
          }
        });
      }

      if (errors.length > 0) {
        (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_0__.showValidationFailedDialog)(_toConsumableArray(new Set(errors)));
        return false;
      }

      return true;
    },
    onClickSaveLines: function onClickSaveLines() {
      if (!this.validate()) {
        return;
      }

      var params = {
        lines: this.lines,
        checked: this.checked
      };
      (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_0__.showLoadingDialog)();
      axios.put('/api/pm/0019/' + this.header_id, params).then(function (response) {
        if (response.status == 200) {
          swal.close();

          if (response.data.req_header_id.length > 0) {
            window.location.href = '/pm/0005/' + response.data.req_header_id[0];
          } else {
            (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_0__.showValidationFailedDialog)(response.data.errors);
          }
        }
      })["catch"](function (error) {
        swal.close();
        console.log(error);
      });
    },
    checkedAll: function checkedAll() {
      var _this6 = this;

      this.checked = [];
      this.isCheckedAll = !this.isCheckedAll;

      if (this.isCheckedAll) {
        this.lines.forEach(function (line) {
          if (line.request_qty) {
            _this6.checked.push(line.bi_request_line_id);
          }
        });
      }
    },
    updateChecked: function updateChecked() {
      this.isCheckedAll = this.checked.length === this.lines.length;
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "th[data-v-b9a203d8], td[data-v-b9a203d8] {\n  vertical-align: middle !important;\n  text-align: center;\n}\ninput.form-control.input-field[data-v-b9a203d8] { border: 0px;\n}\n.mx-datepicker[data-v-b9a203d8] { width: inherit !important;\n}\n.col-readonly[data-v-b9a203d8] { background: #e9ecef42 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_style_index_0_id_b9a203d8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_style_index_0_id_b9a203d8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_style_index_0_id_b9a203d8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/pages/PM0019.vue":
/*!******************************************!*\
  !*** ./resources/js/pm/pages/PM0019.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PM0019_vue_vue_type_template_id_b9a203d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PM0019.vue?vue&type=template&id=b9a203d8&scoped=true& */ "./resources/js/pm/pages/PM0019.vue?vue&type=template&id=b9a203d8&scoped=true&");
/* harmony import */ var _PM0019_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PM0019.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/PM0019.vue?vue&type=script&lang=js&");
/* harmony import */ var _PM0019_vue_vue_type_style_index_0_id_b9a203d8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css& */ "./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _PM0019_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PM0019_vue_vue_type_template_id_b9a203d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PM0019_vue_vue_type_template_id_b9a203d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "b9a203d8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/PM0019.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/PM0019.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/pm/pages/PM0019.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0019.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_style_index_0_id_b9a203d8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=style&index=0&id=b9a203d8&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/pm/pages/PM0019.vue?vue&type=template&id=b9a203d8&scoped=true&":
/*!*************************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0019.vue?vue&type=template&id=b9a203d8&scoped=true& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_template_id_b9a203d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_template_id_b9a203d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0019_vue_vue_type_template_id_b9a203d8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0019.vue?vue&type=template&id=b9a203d8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=template&id=b9a203d8&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=template&id=b9a203d8&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0019.vue?vue&type=template&id=b9a203d8&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "float-right mb-3" }, [
        _c(
          "button",
          { staticClass: "btn btn-success", on: { click: _vm.onClickCreate } },
          [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" สร้าง")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "btn btn-primary",
            attrs: { disabled: _vm.checkDisableBtn }
          },
          [_vm._v("\n            แผนประจำปักษ์")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "btn btn-primary",
            attrs: { disabled: _vm.checkDisableBtn },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.onClickSave($event)
              }
            }
          },
          [_c("i", { staticClass: "fa fa-save" }), _vm._v(" ประมาณการเบิก")]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ibox" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-6 b-r" }, [
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกปี"
                        },
                        on: { change: _vm.onChangeYear },
                        model: {
                          value: _vm.thai_year,
                          callback: function($$v) {
                            _vm.thai_year = $$v
                          },
                          expression: "thai_year"
                        }
                      },
                      _vm._l(_vm.yearLists, function(year) {
                        return _c("el-option", {
                          key: year,
                          attrs: { label: year, value: year }
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
                _vm._m(2),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกเดือน"
                        },
                        on: { change: _vm.onChangeMonth },
                        model: {
                          value: _vm.thai_month,
                          callback: function($$v) {
                            _vm.thai_month = $$v
                          },
                          expression: "thai_month"
                        }
                      },
                      _vm._l(_vm.monthLists, function(month) {
                        return _c("el-option", {
                          key: month,
                          attrs: { label: month, value: month }
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
                _vm._m(3),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกปักษ์"
                        },
                        on: { change: _vm.onChangeBiweekly },
                        model: {
                          value: _vm.biweekly,
                          callback: function($$v) {
                            _vm.biweekly = $$v
                          },
                          expression: "biweekly"
                        }
                      },
                      _vm._l(_vm.biweeklyLists, function(biweekly) {
                        return _c("el-option", {
                          key: biweekly,
                          attrs: { label: biweekly, value: biweekly }
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
                _vm._m(4),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c("datepicker-th", {
                      staticClass: "form-control",
                      attrs: {
                        placeholder: "เลือกวันที่ขอเบิก",
                        "not-before-date": _vm.current_date,
                        "not-after-date": _vm.maxSelectedDate,
                        value: _vm.req_date,
                        format: "YYYY-MM-DD"
                      },
                      on: {
                        dateWasSelected: function(dateObject) {
                          return (_vm.req_date = dateObject)
                        }
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(5),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกประเภทวัตถุดิบ"
                        },
                        model: {
                          value: _vm.item_code,
                          callback: function($$v) {
                            _vm.item_code = $$v
                          },
                          expression: "item_code"
                        }
                      },
                      _vm._l(_vm.items, function(item) {
                        return _c("el-option", {
                          key: item.item_classification_code,
                          attrs: {
                            label: item.item_classification,
                            value: item.item_classification_code
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
                _vm._m(6),
                _vm._v(" "),
                _c("label", { staticClass: "col-lg-1 col-form-label" }, [
                  _vm._v("ตั้งแต่")
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-4" },
                  [
                    _c("datepicker-th", {
                      staticClass: "form-control",
                      attrs: {
                        placeholder: "เลือกวันที่",
                        "not-before-date": _vm.min_date,
                        "not-after-date": _vm.max_date,
                        value: _vm.start_date,
                        format: "YYYY-MM-DD"
                      },
                      on: {
                        dateWasSelected: function(dateObject) {
                          return (_vm.start_date = dateObject)
                        }
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c("label", { staticClass: "col-lg-1 col-form-label" }, [
                  _vm._v("ถึง")
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-4" },
                  [
                    _c("datepicker-th", {
                      staticClass: "form-control",
                      attrs: {
                        placeholder: "เลือกวันที่",
                        "not-before-date": _vm.min_date,
                        "not-after-date": _vm.max_date,
                        value: _vm.end_date,
                        format: "YYYY-MM-DD"
                      },
                      on: {
                        dateWasSelected: function(dateObject) {
                          return (_vm.end_date = dateObject)
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
                _c("label", { staticClass: "col-lg-4 col-form-label" }, [
                  _vm._v("หน่วยงานที่ขอเบิก:")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-8" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.dep_code,
                        expression: "dep_code"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.dep_code },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.dep_code = $event.target.value
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("label", { staticClass: "col-lg-4 col-form-label" }, [
                  _vm._v("ผู้ขอเบิก:")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-8" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.req_by,
                        expression: "req_by"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.req_by },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.req_by = $event.target.value
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(7),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c("datepicker-th", {
                      staticClass: "form-control",
                      attrs: {
                        placeholder: "เลือกวันที่นำส่ง ยสท.",
                        "not-before-date": _vm.req_date,
                        "not-after-date": _vm.maxSelectedDate,
                        value: _vm.send_date,
                        format: "YYYY-MM-DD"
                      },
                      on: {
                        dateWasSelected: function(dateObject) {
                          return (_vm.send_date = dateObject)
                        }
                      }
                    })
                  ],
                  1
                )
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "float-right mb-3" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-w-m btn-success",
            attrs: { type: "button", disabled: _vm.checked.length == 0 },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.onClickSaveLines($event)
              }
            }
          },
          [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" สร้างรายการขอเบิก")]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ibox" }, [
        _vm._m(8),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table table-bordered" }, [
              _c("thead", [
                _c("tr", [
                  _c("th", [
                    _c("label", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.isCheckedAll,
                            expression: "isCheckedAll"
                          }
                        ],
                        staticClass: "align-middle",
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.isCheckedAll)
                            ? _vm._i(_vm.isCheckedAll, null) > -1
                            : _vm.isCheckedAll
                        },
                        on: {
                          click: _vm.checkedAll,
                          change: function($event) {
                            var $$a = _vm.isCheckedAll,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  (_vm.isCheckedAll = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.isCheckedAll = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.isCheckedAll = $$c
                            }
                          }
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("th", [_vm._v("กลุ่มใบยา")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("รหัสวัตถุดิบ")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("รายละเอียด")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณที่ต้องใช้+สูญเสีย")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("หน่วยนับ")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณคงคลังฝ่ายจัดหา")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณที่คงคลังฝ่ายผลิต")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("หน่วยนับ2")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณจัดเก็บต่ำสุด")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณจัดเก็บสูงสุด")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณเต็มแป้น")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณเบิก")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("หน่วยเบิก")])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.lines, function(line, index) {
                  return _c("tr", { key: index }, [
                    _c("td", [
                      _c("label", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.checked,
                              expression: "checked"
                            }
                          ],
                          staticClass: "align-middle",
                          attrs: {
                            type: "checkbox",
                            disabled: !line.request_qty
                          },
                          domProps: {
                            value: line.bi_request_line_id,
                            checked: Array.isArray(_vm.checked)
                              ? _vm._i(_vm.checked, line.bi_request_line_id) >
                                -1
                              : _vm.checked
                          },
                          on: {
                            change: [
                              function($event) {
                                var $$a = _vm.checked,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = line.bi_request_line_id,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 && (_vm.checked = $$a.concat([$$v]))
                                  } else {
                                    $$i > -1 &&
                                      (_vm.checked = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)))
                                  }
                                } else {
                                  _vm.checked = $$c
                                }
                              },
                              _vm.updateChecked
                            ]
                          }
                        })
                      ])
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.item_type))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.item_code))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.description))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.total_qty))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.uom))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.request_onhand))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.product_onhand))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.uom2))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.min_qty))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.max_qty))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.machine_max))
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: line.request_qty,
                            expression: "line.request_qty"
                          }
                        ],
                        staticClass: "form-control input-field",
                        attrs: { type: "number", min: "0" },
                        domProps: { value: line.request_qty },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(line, "request_qty", $event.target.value)
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.request_uom))
                    ])
                  ])
                }),
                0
              )
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
      _c("h5", [_vm._v("ขอเบิกวัตถุดิบตามแผนรายปักษ์")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("แผนการผลิตประจำปี: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("แผนการผลิตประจำเดือน: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("ปักษ์ที่: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("วันที่ขอเบิก: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("ประเภทวัตถุดิบ: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-2 col-form-label" }, [
      _vm._v("วันที่ผลิต"),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("วันที่นำส่ง ยสท."),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
      _vm._v(":")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h5", [_vm._v("รายการวัตถุดิบ")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);