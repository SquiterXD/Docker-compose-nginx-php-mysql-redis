(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_PM0029_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['data'],
  data: function data() {
    return {
      rows: this.data,
      seg: '',
      desc: '',
      grp: '',
      inv: '',
      loc: '',
      displayLotNo: false,
      underInv: false,
      closeToExp: false,
      hold: false
    };
  },
  mounted: function mounted() {
    console.log('mounted !!!');
  },
  computed: {
    segments: function segments() {
      var segments = _toConsumableArray(new Set(this.data.map(function (row) {
        return row.segment1;
      })));

      return segments.sort();
    },
    descriptions: function descriptions() {
      var descriptions = _toConsumableArray(new Set(this.data.map(function (row) {
        return row.description;
      })));

      return descriptions.sort();
    },
    groups: function groups() {
      var groups = _toConsumableArray(new Set(this.data.map(function (row) {
        return row.tobacco_group;
      })));

      return groups.sort();
    },
    inventories: function inventories() {
      var inventories = _toConsumableArray(new Set(this.data.map(function (row) {
        return row.subinventory_code;
      })));

      return inventories.sort();
    },
    locators: function locators() {
      var locators = _toConsumableArray(new Set(this.data.map(function (row) {
        return row.locator_code;
      })));

      return locators.sort();
    }
  },
  methods: {
    onClickResetBtn: function onClickResetBtn() {
      this.seg = '';
      this.desc = '';
      this.grp = '';
      this.inv = '';
      this.loc = '';
      this.displayLotNo = false;
      this.underInv = false;
      this.closeToExp = false;
      this.hold = false; // this.rows = this.data
    },
    onClickSearchBtn: function onClickSearchBtn() {
      var _this = this;

      console.log('onClickSearchBtn');
      (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_0__.showLoadingDialog)();
      var params = {
        segment1: this.seg,
        description: this.desc,
        tobacco_group: this.grp,
        subinventory_code: this.inv,
        locator_code: this.loc,
        display_lot_no: this.displayLotNo,
        under_inv: this.underInv,
        close_to_exp: this.closeToExp,
        hold: this.hold
      };
      axios.post('/api/pm/pm0029/', params).then(function (response) {
        if (response.status == 200) {
          _this.rows = response.data;
          swal.close();
          console.log('status 200');
          console.log(response);
        }
      })["catch"](function (error) {
        console.log(error);
      });
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, "th[data-v-b638529a],\n    td[data-v-b638529a] {\n  vertical-align: middle !important;\n  text-align: center;\n}\n.form-check-input[data-v-b638529a] {\n  width: 20px;\n  height: 45px;\n  border: 1px solid #e5e6e7;\n}\n.checkbox label[data-v-b638529a]::before {\n  content: \"\";\n  display: inline-block;\n  width: 17px;\n  height: 17px;\n  left: 0;\n  margin-left: -20px;\n  border: 1px solid #cccccc;\n}\n.container[data-v-b638529a] {\n  display: block;\n  position: relative;\n  padding-left: 35px;\n  margin-bottom: 12px;\n  cursor: pointer;\n  font-size: 22px;\n  -webkit-user-select: none;\n  -moz-user-select: none;\n  -ms-user-select: none;\n  user-select: none;\n}\n\n/* Hide the browser's default checkbox */\n.container input[data-v-b638529a] {\n  position: absolute;\n  opacity: 0;\n  cursor: pointer;\n  height: 0;\n  width: 0;\n}\n\n/* Create a custom checkbox */\n.checkmark[data-v-b638529a] {\n  position: absolute;\n  top: 10px;\n  left: 0;\n  height: 20px;\n  width: 20px;\n  border: 1px solid #e5e6e7;\n  border-radius: 4px;\n}\n\n/* On mouse-over, add a grey background color */\n.container:hover input ~ .checkmark[data-v-b638529a] {\n  border: 1px solid #e5e6e7;\n  border-radius: 4px;\n}\n\n/* When the checkbox is checked, add a blue background */\n.container input:checked ~ .checkmark[data-v-b638529a] {\n  background-color: #1ab394;\n}\n\n/* Create the checkmark/indicator (hidden when not checked) */\n.checkmark[data-v-b638529a]:after {\n  content: \"\";\n  position: absolute;\n  display: none;\n}\n\n/* Show the checkmark when checked */\n.container input:checked ~ .checkmark[data-v-b638529a]:after {\n  display: block;\n}\n\n/* Style the checkmark/indicator */\n.container .checkmark[data-v-b638529a]:after {\n  left: 9px;\n  top: 5px;\n  width: 5px;\n  height: 10px;\n  border: solid white;\n  border-width: 0 3px 3px 0;\n  transform: rotate(45deg);\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_style_index_0_id_b638529a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_style_index_0_id_b638529a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_style_index_0_id_b638529a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/pages/PM0029.vue":
/*!******************************************!*\
  !*** ./resources/js/pm/pages/PM0029.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PM0029_vue_vue_type_template_id_b638529a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PM0029.vue?vue&type=template&id=b638529a&scoped=true& */ "./resources/js/pm/pages/PM0029.vue?vue&type=template&id=b638529a&scoped=true&");
/* harmony import */ var _PM0029_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PM0029.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/PM0029.vue?vue&type=script&lang=js&");
/* harmony import */ var _PM0029_vue_vue_type_style_index_0_id_b638529a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css& */ "./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _PM0029_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PM0029_vue_vue_type_template_id_b638529a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PM0029_vue_vue_type_template_id_b638529a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "b638529a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/PM0029.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/PM0029.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/pm/pages/PM0029.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0029.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_style_index_0_id_b638529a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=style&index=0&id=b638529a&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/pm/pages/PM0029.vue?vue&type=template&id=b638529a&scoped=true&":
/*!*************************************************************************************!*\
  !*** ./resources/js/pm/pages/PM0029.vue?vue&type=template&id=b638529a&scoped=true& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_template_id_b638529a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_template_id_b638529a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PM0029_vue_vue_type_template_id_b638529a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PM0029.vue?vue&type=template&id=b638529a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=template&id=b638529a&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=template&id=b638529a&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/PM0029.vue?vue&type=template&id=b638529a&scoped=true& ***!
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
  return _c("div", [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-lg-12" }, [
        _c("div", { staticClass: "ibox" }, [
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-4 col-sm-12" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                    [_vm._v("รหัสวัตถุดิบ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-8" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            clearable: "",
                            filterable: "",
                            remote: "",
                            placeholder: "เลือกประเภทวัตฤติบ",
                            loading: false
                          },
                          model: {
                            value: _vm.seg,
                            callback: function($$v) {
                              _vm.seg = $$v
                            },
                            expression: "seg"
                          }
                        },
                        _vm._l(_vm.segments, function(segment) {
                          return _c("el-option", {
                            key: segment,
                            attrs: { label: segment, value: segment }
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
                    { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                    [_vm._v("ประเภทวัตฤติบ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-8" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            clearable: "",
                            filterable: "",
                            remote: "",
                            placeholder: "เลือกประเภทวัตฤติบ",
                            loading: false
                          },
                          model: {
                            value: _vm.desc,
                            callback: function($$v) {
                              _vm.desc = $$v
                            },
                            expression: "desc"
                          }
                        },
                        _vm._l(_vm.descriptions, function(description) {
                          return _c("el-option", {
                            key: description,
                            attrs: { label: description, value: description }
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
                    { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                    [_vm._v("กลุ่มวัตถุดิบ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-8" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            clearable: "",
                            filterable: "",
                            remote: "",
                            placeholder: "เลือกกลุ่มวัตถุดิบ",
                            loading: false
                          },
                          model: {
                            value: _vm.grp,
                            callback: function($$v) {
                              _vm.grp = $$v
                            },
                            expression: "grp"
                          }
                        },
                        _vm._l(_vm.groups, function(group) {
                          return _c("el-option", {
                            key: group,
                            attrs: { label: group, value: group }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-4" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                    [_vm._v("คลังจัดเก็บ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-8" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            clearable: "",
                            filterable: "",
                            remote: "",
                            placeholder: "เลือกคลังจัดเก็บ",
                            loading: false
                          },
                          model: {
                            value: _vm.inv,
                            callback: function($$v) {
                              _vm.inv = $$v
                            },
                            expression: "inv"
                          }
                        },
                        _vm._l(_vm.inventories, function(inventory) {
                          return _c("el-option", {
                            key: inventory,
                            attrs: { label: inventory, value: inventory }
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
                    { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                    [_vm._v("สถานที่จัดเก็บ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-8" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            clearable: "",
                            filterable: "",
                            remote: "",
                            placeholder: "เลือกสถานที่จัดเก็บ",
                            loading: false
                          },
                          model: {
                            value: _vm.loc,
                            callback: function($$v) {
                              _vm.loc = $$v
                            },
                            expression: "loc"
                          }
                        },
                        _vm._l(_vm.locators, function(locator) {
                          return _c("el-option", {
                            key: locator,
                            attrs: { label: locator, value: locator }
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
                    { staticClass: "col-lg-4 col-sm-4 col-form-label" },
                    [_vm._v("แสดง Lot")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("label", { staticClass: "container" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.displayLotNo,
                            expression: "displayLotNo"
                          }
                        ],
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.displayLotNo)
                            ? _vm._i(_vm.displayLotNo, null) > -1
                            : _vm.displayLotNo
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.displayLotNo,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  (_vm.displayLotNo = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.displayLotNo = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.displayLotNo = $$c
                            }
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "checkmark" })
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-lg-4" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-lg-6 col-sm-4 col-form-label" },
                    [_vm._v("ปริมาณคงคลังต่ำกว่าที่กำหนด")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("label", { staticClass: "container" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.underInv,
                            expression: "underInv"
                          }
                        ],
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.underInv)
                            ? _vm._i(_vm.underInv, null) > -1
                            : _vm.underInv
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.underInv,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 && (_vm.underInv = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.underInv = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.underInv = $$c
                            }
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "checkmark" })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-lg-6 col-sm-4 col-form-label" },
                    [_vm._v("วัตถุดิบใกล้หมดอายุ")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("label", { staticClass: "container" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.closeToExp,
                            expression: "closeToExp"
                          }
                        ],
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.closeToExp)
                            ? _vm._i(_vm.closeToExp, null) > -1
                            : _vm.closeToExp
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.closeToExp,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 && (_vm.closeToExp = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.closeToExp = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.closeToExp = $$c
                            }
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "checkmark" })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-lg-6 col-sm-4 col-form-label" },
                    [_vm._v("Hold")]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-6" }, [
                    _c("label", { staticClass: "container" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.hold,
                            expression: "hold"
                          }
                        ],
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.hold)
                            ? _vm._i(_vm.hold, null) > -1
                            : _vm.hold
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.hold,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 && (_vm.hold = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.hold = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.hold = $$c
                            }
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "checkmark" })
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "text-right" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-w-m btn-default",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.onClickResetBtn($event)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-refresh" }),
                  _vm._v(" ล้างค่า\n                        ")
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-w-m btn-default",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.onClickSearchBtn($event)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-search" }),
                  _vm._v(" ค้นหา\n                        ")
                ]
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox" }, [
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "table-responsive" }, [
              _c("table", { staticClass: "table table-bordered" }, [
                _vm._m(0),
                _vm._v(" "),
                _vm.rows.length
                  ? _c(
                      "tbody",
                      _vm._l(_vm.rows, function(row) {
                        return _c("tr", [
                          _c("td", [_vm._v(_vm._s(row.segment1))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.lookup_code))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.description))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.tobacco_group))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.subinventory_code))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.locator_code))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.lot_number))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.onhand_quantity))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.primary_uom_code))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.min_qty))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.max_qty))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.origination_date))]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(row.expiration_date))]),
                          _vm._v(" "),
                          _c("td", [
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-check abc-checkbox form-check-inline m-l-md"
                              },
                              [
                                _c("input", {
                                  staticClass: "form-check-input",
                                  attrs: { type: "checkbox", disabled: "" },
                                  domProps: { checked: row.hold_date == "Y" }
                                })
                              ]
                            )
                          ])
                        ])
                      }),
                      0
                    )
                  : _c("tbody", [_vm._m(1)])
              ])
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
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("รหัสวัตถุดิบ")]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "250px" } }, [
          _vm._v("รายละเอียด")
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("ประเภทวัตถุดิบ")]),
        _vm._v(" "),
        _c("th", [_vm._v("กลุ่มวัตถุดิบ")]),
        _vm._v(" "),
        _c("th", [_vm._v("คลังจัดเก็บ")]),
        _vm._v(" "),
        _c("th", [_vm._v("สถานที่จัดเก็บ")]),
        _vm._v(" "),
        _c("th", [_vm._v("Lot No.")]),
        _vm._v(" "),
        _c("th", [_vm._v("ปริมาณคงคลัง")]),
        _vm._v(" "),
        _c("th", [_vm._v("หน่วย")]),
        _vm._v(" "),
        _c("th", [_vm._v("ปริมาณจัดเก็บต่ำสุด")]),
        _vm._v(" "),
        _c("th", [_vm._v("ปริมาณจัดเก็บมากสุด")]),
        _vm._v(" "),
        _c("th", [_vm._v("วันที่ได้รับ")]),
        _vm._v(" "),
        _c("th", [_vm._v("วันหมดอายุ")]),
        _vm._v(" "),
        _c("th", [_vm._v("hold")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "14" } }, [_vm._v("ไม่พบข้อมูล")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);