(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_RunningComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RunningComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RunningComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["programs", "modules", "groupFormats", "resetAts", "dateFormats", "yearTypes", 'getAssignments', 'numDocuments', 'headers', 'old', 'defaultFormValue'],
  data: function data() {
    return {
      running_code: this.old.running_code ? this.old.running_code : this.defaultFormValue ? this.defaultFormValue.doc_seq_code : '',
      description: this.old.description ? this.old.description : this.defaultFormValue ? this.defaultFormValue.doc_seq_description : '',
      programs_code: this.old.programs_code ? this.old.programs_code : this.getAssignments ? this.getAssignments : [],
      start_date: this.old.start_date ? this.old.start_date : this.defaultFormValue ? this.defaultFormValue.start_date : '',
      end_date: this.old.end_date ? this.old.end_date : this.defaultFormValue ? this.defaultFormValue.end_date : '',
      reset_at: this.old.reset_at ? this.old.reset_at : this.defaultFormValue ? this.defaultFormValue.reset_every : '',
      start_digit: this.old.start_digit ? this.old.start_digit : this.defaultFormValue ? this.defaultFormValue.start_with : '',
      number_digit: this.old.number_digit ? this.old.number_digit : this.defaultFormValue ? this.defaultFormValue.prefix_number_digit : '',
      module_code: this.old.module_code ? this.old.module_code : this.defaultFormValue ? this.defaultFormValue.module_code : '',
      lines: [],
      disabledData: this.defaultFormValue ? true : false,
      active_flag: this.old.active_flag == 'Y' ? true : this.defaultFormValue ? this.defaultFormValue.active_flag == 'Y' ? true : '' : true,
      year_type: '',
      date_format: '',
      detail: '' // ----------------------------------------------------------------------------------------------------------------------
      // running_code   : this.defaultFormValue   ? this.defaultFormValue.doc_seq_code        : '',
      // description    : this.defaultFormValue   ? this.defaultFormValue.doc_seq_description : '',
      // systemModule   : this.defaultFormValue   ? this.defaultFormValue.module_code         : '',
      // programs_code  : this.getAssignments     ? this.getAssignments                       : [],
      // start_date     : this.defaultFormValue   ? this.defaultFormValue.start_date          : '',
      // end_date       : this.defaultFormValue   ? this.defaultFormValue.end_date            : '',
      // reset_at       : this.defaultFormValue   ? this.defaultFormValue.reset_every         : '',
      // active_flag    : this.defaultFormValue   ? this.defaultFormValue.active_flag         : true,
      // detail         : '',
      // start_digit    : this.defaultFormValue   ? this.defaultFormValue.start_with          : '',
      // year_type      : '',
      // date_format    : '',
      // number_digit   : this.defaultFormValue   ? this.defaultFormValue.prefix_number_digit : '',
      // lines          : [],
      // disabledData   : this.defaultFormValue   ?  true : false,
      // test_date      : this.defaultFormValue   ? this.defaultFormValue.start_date          : '',
      // module_code    : this.defaultFormValue   ? this.defaultFormValue.module_code         : '',

    };
  },
  mounted: function mounted() {
    var _this = this;

    if (this.old.running_code) {
      this.getModule();
    }

    if (this.old.group_format) {
      this.old.group_format.forEach(function (element) {
        var _this$old$date_format, _this$old$year_type, _this$old$detail;

        _this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          lineId: '',
          group_format: element == '$DATE_FORMAT' ? element : '$PREFIX',
          date_format: (_this$old$date_format = _this.old.date_format) !== null && _this$old$date_format !== void 0 ? _this$old$date_format : '',
          year_type: (_this$old$year_type = _this.old.year_type) !== null && _this$old$year_type !== void 0 ? _this$old$year_type : '',
          detail: (_this$old$detail = _this.old.detail) !== null && _this$old$detail !== void 0 ? _this$old$detail : '',
          disabledFormat: false
        });
      });
    } // if (this.old.format1) {
    //     this.lines.push({
    //         id             : uuidv1(),
    //         lineId         : '',
    //         group_format   : this.old.format1 == '$DATE_FORMAT' ? this.old.format1 : '$PREFIX',
    //         date_format    : this.old.format_date  ?? '',
    //         year_type      : this.old.year_type    ?? '',
    //         detail         : this.old.format1      ?? '',
    //         disabledFormat : true,
    //     });
    // }
    // if (this.old.format2) {
    //     this.lines.push({
    //         id             : uuidv1(),
    //         lineId         : '',
    //         group_format   : this.old.format2 == '$DATE_FORMAT' ? this.old.format2 : '$PREFIX',
    //         date_format    : this.old.format_date  ?? '',
    //         year_type      : this.old.year_type    ?? '',
    //         detail         : this.old.format2      ?? '',
    //         disabledFormat : true,
    //     });
    // }
    // if (this.old.format3) {
    //     this.lines.push({
    //         id             : uuidv1(),
    //         lineId         : '',
    //         group_format   : this.old.format3 == '$DATE_FORMAT' ? this.old.format3 : '$PREFIX',
    //         date_format    : this.old.format_date  ?? '',
    //         year_type      : this.old.year_type    ?? '',
    //         detail         : this.old.format3      ?? '',
    //         disabledFormat : true,
    //     });
    // }
    // if (this.old.format4) {
    //     this.lines.push({
    //         id             : uuidv1(),
    //         lineId         : '',
    //         group_format   : this.old.format4 == '$DATE_FORMAT' ? this.old.format4 : '$PREFIX',
    //         date_format    : this.old.format_date  ?? '',
    //         year_type      : this.old.year_type    ?? '',
    //         detail         : this.old.format4      ?? '',
    //         disabledFormat : true,
    //     });
    // }
    // if (this.old.format5) {
    //     this.lines.push({
    //         id             : uuidv1(),
    //         lineId         : '',
    //         group_format   : this.old.format5 == '$DATE_FORMAT' ? this.old.format5 : '$PREFIX',
    //         date_format    : this.old.format_date  ?? '',
    //         year_type      : this.old.year_type    ?? '',
    //         detail         : this.old.format5      ?? '',
    //         disabledFormat : true,
    //     });
    // }


    if (this.defaultFormValue) {
      // this.addLine();
      if (this.defaultFormValue.format1) {
        var _this$defaultFormValu, _this$defaultFormValu2, _this$defaultFormValu3;

        this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          lineId: '',
          group_format: this.defaultFormValue.format1 == '$DATE_FORMAT' ? this.defaultFormValue.format1 : '$PREFIX',
          date_format: (_this$defaultFormValu = this.defaultFormValue.format_date) !== null && _this$defaultFormValu !== void 0 ? _this$defaultFormValu : '',
          year_type: (_this$defaultFormValu2 = this.defaultFormValue.year_type) !== null && _this$defaultFormValu2 !== void 0 ? _this$defaultFormValu2 : '',
          detail: (_this$defaultFormValu3 = this.defaultFormValue.format1) !== null && _this$defaultFormValu3 !== void 0 ? _this$defaultFormValu3 : '',
          disabledFormat: true
        });
      }

      if (this.defaultFormValue.format2) {
        var _this$defaultFormValu4, _this$defaultFormValu5, _this$defaultFormValu6;

        this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          lineId: '',
          group_format: this.defaultFormValue.format2 == '$DATE_FORMAT' ? this.defaultFormValue.format2 : '$PREFIX',
          date_format: (_this$defaultFormValu4 = this.defaultFormValue.format_date) !== null && _this$defaultFormValu4 !== void 0 ? _this$defaultFormValu4 : '',
          year_type: (_this$defaultFormValu5 = this.defaultFormValue.year_type) !== null && _this$defaultFormValu5 !== void 0 ? _this$defaultFormValu5 : '',
          detail: (_this$defaultFormValu6 = this.defaultFormValue.format2) !== null && _this$defaultFormValu6 !== void 0 ? _this$defaultFormValu6 : '',
          disabledFormat: true
        });
      }

      if (this.defaultFormValue.format3) {
        var _this$defaultFormValu7, _this$defaultFormValu8, _this$defaultFormValu9;

        this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          lineId: '',
          group_format: this.defaultFormValue.format3 == '$DATE_FORMAT' ? this.defaultFormValue.format3 : '$PREFIX',
          date_format: (_this$defaultFormValu7 = this.defaultFormValue.format_date) !== null && _this$defaultFormValu7 !== void 0 ? _this$defaultFormValu7 : '',
          year_type: (_this$defaultFormValu8 = this.defaultFormValue.year_type) !== null && _this$defaultFormValu8 !== void 0 ? _this$defaultFormValu8 : '',
          detail: (_this$defaultFormValu9 = this.defaultFormValue.format3) !== null && _this$defaultFormValu9 !== void 0 ? _this$defaultFormValu9 : '',
          disabledFormat: true
        });
      }

      if (this.defaultFormValue.format4) {
        var _this$defaultFormValu10, _this$defaultFormValu11, _this$defaultFormValu12;

        this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          lineId: '',
          group_format: this.defaultFormValue.format4 == '$DATE_FORMAT' ? this.defaultFormValue.format4 : '$PREFIX',
          date_format: (_this$defaultFormValu10 = this.defaultFormValue.format_date) !== null && _this$defaultFormValu10 !== void 0 ? _this$defaultFormValu10 : '',
          year_type: (_this$defaultFormValu11 = this.defaultFormValue.year_type) !== null && _this$defaultFormValu11 !== void 0 ? _this$defaultFormValu11 : '',
          detail: (_this$defaultFormValu12 = this.defaultFormValue.format4) !== null && _this$defaultFormValu12 !== void 0 ? _this$defaultFormValu12 : '',
          disabledFormat: true
        });
      }

      if (this.defaultFormValue.format5) {
        var _this$defaultFormValu13, _this$defaultFormValu14, _this$defaultFormValu15;

        this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          lineId: '',
          group_format: this.defaultFormValue.format5 == '$DATE_FORMAT' ? this.defaultFormValue.format5 : '$PREFIX',
          date_format: (_this$defaultFormValu13 = this.defaultFormValue.format_date) !== null && _this$defaultFormValu13 !== void 0 ? _this$defaultFormValu13 : '',
          year_type: (_this$defaultFormValu14 = this.defaultFormValue.year_type) !== null && _this$defaultFormValu14 !== void 0 ? _this$defaultFormValu14 : '',
          detail: (_this$defaultFormValu15 = this.defaultFormValue.format5) !== null && _this$defaultFormValu15 !== void 0 ? _this$defaultFormValu15 : '',
          disabledFormat: true
        });
      }
    }
  },
  computed: {
    expRunningNumber: function expRunningNumber() {
      var formatted = '';

      for (var i = 1; i < this.number_digit; i++) {
        var a = '0';
        formatted += a;
      }

      return formatted + this.start_digit;
    }
  },
  methods: {
    addLine: function addLine() {
      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
        lineId: '',
        group_format: ''
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);
    },
    checkDup: function checkDup() {
      var _this2 = this;

      this.selectedData = this.headers.find(function (i) {
        return i.doc_seq_description == _this2.description;
      });

      if (this.selectedData) {
        this.$notify.error({
          title: 'มีข้อผิดพลาด',
          message: 'คำอธิบายซ้ำกับในระบบ'
        });
        this.description = '';
      }
    },
    checkDate: function checkDate() {
      if (this.start_date) {
        if (moment__WEBPACK_IMPORTED_MODULE_2___default()(String(this.end_date)).format('yyyy-MM-DD') < moment__WEBPACK_IMPORTED_MODULE_2___default()(String(this.start_date)).format('yyyy-MM-DD')) {
          this.$notify.error({
            title: 'มีข้อผิดพลาด',
            message: 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น'
          });
          this.end_date = '';
        }
      }
    },
    showDate: function showDate() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var date1, date2;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this3.start_date) {
                  _context.next = 7;
                  break;
                }

                console.log('start_date -->' + _this3.start_date);
                console.log(moment__WEBPACK_IMPORTED_MODULE_2___default()(String(_this3.start_date)).format('yyyy-MM-DD'));
                _context.next = 5;
                return helperDate.parseToDateTh(_this3.start_date, 'yyyy-MM-DD');

              case 5:
                date1 = _context.sent;
                _this3.start_date = date1;

              case 7:
                if (!_this3.end_date) {
                  _context.next = 13;
                  break;
                }

                console.log('end_date -->' + _this3.end_date);
                _context.next = 11;
                return helperDate.parseToDateTh(_this3.end_date, 'yyyy-MM-DD');

              case 11:
                date2 = _context.sent;
                _this3.end_date = date2;

              case 13:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getModule: function getModule() {
      var _this4 = this;

      this.module_code = '';
      this.selectedData = this.numDocuments.find(function (i) {
        return i.lookup_code == _this4.running_code;
      });

      if (this.selectedData) {
        this.module_code = this.selectedData.tag;
      }

      console.log('ระบบงาน  ---->  ' + this.module_code);
    },
    checkFormat: function checkFormat(row, index) {
      var _this5 = this;

      if (index > 0) {
        this.lines.find(function (line) {
          if (line.id != row.id) {
            console.log('group_format -->' + line.group_format);

            if (line.group_format == '$DATE_FORMAT' && row.group_format == '$DATE_FORMAT') {
              _this5.$notify.error({
                title: 'มีข้อผิดพลาด',
                message: 'ไม่สามารถเลือกรูปแบบวันที่ซ้ำกันภายใต้ Document ชุดเดียวกันได้'
              });

              row.group_format = '';
            }
          }
        });
      }
    },
    onlyNumeric: function onlyNumeric() {
      this.number_digit = this.number_digit.replace(/[^0-9 .]/g, '');
      this.start_digit = this.start_digit.replace(/[^0-9 .]/g, '');
    }
  }
});

/***/ }),

/***/ "./resources/js/components/RunningComponent.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/RunningComponent.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _RunningComponent_vue_vue_type_template_id_1c5e9169___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RunningComponent.vue?vue&type=template&id=1c5e9169& */ "./resources/js/components/RunningComponent.vue?vue&type=template&id=1c5e9169&");
/* harmony import */ var _RunningComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RunningComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/RunningComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _RunningComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _RunningComponent_vue_vue_type_template_id_1c5e9169___WEBPACK_IMPORTED_MODULE_0__.render,
  _RunningComponent_vue_vue_type_template_id_1c5e9169___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/RunningComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/RunningComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/RunningComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RunningComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RunningComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RunningComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RunningComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/RunningComponent.vue?vue&type=template&id=1c5e9169&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/RunningComponent.vue?vue&type=template&id=1c5e9169& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_RunningComponent_vue_vue_type_template_id_1c5e9169___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_RunningComponent_vue_vue_type_template_id_1c5e9169___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_RunningComponent_vue_vue_type_template_id_1c5e9169___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RunningComponent.vue?vue&type=template&id=1c5e9169& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RunningComponent.vue?vue&type=template&id=1c5e9169&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RunningComponent.vue?vue&type=template&id=1c5e9169&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RunningComponent.vue?vue&type=template&id=1c5e9169& ***!
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
    _c("div", { staticClass: "card" }, [
      _c("div", { staticClass: "card-body" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-6" }, [
            _c("div", { staticClass: "form-group row" }, [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-sm-8" },
                [
                  _c("input", {
                    attrs: {
                      type: "hidden",
                      name: "running_code",
                      autocomplete: "off"
                    },
                    domProps: { value: _vm.running_code }
                  }),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        filterable: "",
                        remote: "",
                        "reserve-keyword": "",
                        clearable: "",
                        disabled: this.disabledData
                      },
                      on: {
                        change: function($event) {
                          return _vm.getModule()
                        }
                      },
                      model: {
                        value: _vm.running_code,
                        callback: function($$v) {
                          _vm.running_code = $$v
                        },
                        expression: "running_code"
                      }
                    },
                    _vm._l(_vm.numDocuments, function(document) {
                      return _c("el-option", {
                        key: document.lookup_code,
                        attrs: {
                          label: document.meaning,
                          value: document.lookup_code
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
                { staticClass: "col-sm-4 form-control-label text-right" },
                [_vm._v("คำอธิบาย")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-sm-8" },
                [
                  _c("el-input", {
                    attrs: {
                      type: "text",
                      name: "description",
                      size: "medium",
                      autocomplete: "off",
                      disabled: this.disabledData
                    },
                    on: {
                      input: function($event) {
                        return _vm.checkDup()
                      }
                    },
                    model: {
                      value: _vm.description,
                      callback: function($$v) {
                        _vm.description = $$v
                      },
                      expression: "description"
                    }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-sm-8" },
                [
                  _c("el-input", {
                    attrs: {
                      type: "text",
                      name: "module_code",
                      size: "medium",
                      autocomplete: "off",
                      disabled: ""
                    },
                    model: {
                      value: _vm.module_code,
                      callback: function($$v) {
                        _vm.module_code = $$v
                      },
                      expression: "module_code"
                    }
                  })
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
                { staticClass: "col-sm-8" },
                [
                  _c("input", {
                    attrs: {
                      type: "hidden",
                      name: "programs_code",
                      autocomplete: "off"
                    },
                    domProps: { value: _vm.programs_code }
                  }),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        filterable: "",
                        remote: "",
                        "reserve-keyword": "",
                        multiple: "",
                        disabled: this.disabledData
                      },
                      model: {
                        value: _vm.programs_code,
                        callback: function($$v) {
                          _vm.programs_code = $$v
                        },
                        expression: "programs_code"
                      }
                    },
                    _vm._l(_vm.programs, function(program) {
                      return _c("el-option", {
                        key: program.program_code,
                        attrs: {
                          label:
                            program.program_code + " : " + program.description,
                          value: program.program_code
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
              _vm._m(3),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-sm-8" },
                [
                  _c("el-date-picker", {
                    staticStyle: { width: "100%" },
                    attrs: {
                      type: "date",
                      placeholder: "วันที่เริ่มต้น",
                      name: "start_date",
                      format: "dd-MM-yyyy",
                      disabled: this.disabledData
                    },
                    model: {
                      value: _vm.start_date,
                      callback: function($$v) {
                        _vm.start_date = $$v
                      },
                      expression: "start_date"
                    }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c(
                "label",
                { staticClass: "col-sm-4 form-control-label text-right" },
                [_vm._v("วันที่สิ้นสุด")]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-sm-8" },
                [
                  _c("el-date-picker", {
                    staticStyle: { width: "100%" },
                    attrs: {
                      type: "date",
                      placeholder: "วันที่สิ้นสุด",
                      name: "end_date",
                      format: "dd-MM-yyyy"
                    },
                    on: {
                      change: function($event) {
                        return _vm.checkDate()
                      }
                    },
                    model: {
                      value: _vm.end_date,
                      callback: function($$v) {
                        _vm.end_date = $$v
                      },
                      expression: "end_date"
                    }
                  })
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
                { staticClass: "col-sm-8" },
                [
                  _c("input", {
                    attrs: {
                      type: "hidden",
                      name: "reset_at",
                      autocomplete: "off"
                    },
                    domProps: { value: _vm.reset_at }
                  }),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        filterable: "",
                        remote: "",
                        "reserve-keyword": "",
                        disabled: this.disabledData
                      },
                      model: {
                        value: _vm.reset_at,
                        callback: function($$v) {
                          _vm.reset_at = $$v
                        },
                        expression: "reset_at"
                      }
                    },
                    _vm._l(_vm.resetAts, function(resetAt) {
                      return _c("el-option", {
                        key: resetAt.lookup_code,
                        attrs: {
                          label: resetAt.description,
                          value: resetAt.lookup_code
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
                { staticClass: "col-sm-4 form-control-label text-right" },
                [_vm._v("Active")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-sm-8" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.active_flag,
                      expression: "active_flag"
                    }
                  ],
                  attrs: { type: "checkbox", name: "active_flag" },
                  domProps: {
                    checked: Array.isArray(_vm.active_flag)
                      ? _vm._i(_vm.active_flag, null) > -1
                      : _vm.active_flag
                  },
                  on: {
                    change: function($event) {
                      var $$a = _vm.active_flag,
                        $$el = $event.target,
                        $$c = $$el.checked ? true : false
                      if (Array.isArray($$a)) {
                        var $$v = null,
                          $$i = _vm._i($$a, $$v)
                        if ($$el.checked) {
                          $$i < 0 && (_vm.active_flag = $$a.concat([$$v]))
                        } else {
                          $$i > -1 &&
                            (_vm.active_flag = $$a
                              .slice(0, $$i)
                              .concat($$a.slice($$i + 1)))
                        }
                      } else {
                        _vm.active_flag = $$c
                      }
                    }
                  }
                })
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _vm._m(5),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-sm-8" },
                [
                  _c("el-input", {
                    staticStyle: { width: "30%" },
                    attrs: {
                      type: "text",
                      name: "number_digit",
                      autocomplete: "off",
                      disabled: this.disabledData
                    },
                    on: { input: _vm.onlyNumeric },
                    model: {
                      value: _vm.number_digit,
                      callback: function($$v) {
                        _vm.number_digit = $$v
                      },
                      expression: "number_digit"
                    }
                  }),
                  _vm._v(
                    "\n                            Digits เริ่มจาก\n                            "
                  ),
                  _c("el-input", {
                    staticStyle: { width: "30%" },
                    attrs: {
                      type: "text",
                      name: "start_digit",
                      autocomplete: "off",
                      disabled: this.disabledData
                    },
                    on: { input: _vm.onlyNumeric },
                    model: {
                      value: _vm.start_digit,
                      callback: function($$v) {
                        _vm.start_digit = $$v
                      },
                      expression: "start_digit"
                    }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c(
                "label",
                { staticClass: "col-sm-4 form-control-label text-right" },
                [_vm._v("ตัวอย่าง")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "col-sm-8" }, [
                _vm._v(
                  "\n                            " +
                    _vm._s(_vm.expRunningNumber) +
                    "\n                        "
                )
              ])
            ])
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _vm._m(6),
              _vm._v(" "),
              _vm._l(_vm.lines, function(row, index) {
                return _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    { staticClass: "col-sm-3 form-control-label text-right" },
                    [
                      _vm._v("ลำดับที่ " + _vm._s(index + 1)),
                      _c("span", { staticStyle: { color: "red" } }, [
                        _vm._v(" * ")
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-4" },
                    [
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "dataGroup[" + index + "][group_format]",
                          autocomplete: "off"
                        },
                        domProps: { value: row.group_format }
                      }),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            remote: "",
                            "reserve-keyword": "",
                            disabled: row.disabledFormat
                          },
                          on: {
                            change: function($event) {
                              return _vm.checkFormat(row, index)
                            }
                          },
                          model: {
                            value: row.group_format,
                            callback: function($$v) {
                              _vm.$set(row, "group_format", $$v)
                            },
                            expression: "row.group_format"
                          }
                        },
                        _vm._l(_vm.groupFormats, function(groupFormat) {
                          return _c("el-option", {
                            key: groupFormat.lookup_code,
                            attrs: {
                              label: groupFormat.description,
                              value: groupFormat.lookup_code
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  row.group_format == "$DATE_FORMAT"
                    ? _c("div", { staticClass: "col-sm-4" }, [
                        _c(
                          "div",
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "date_format",
                                autocomplete: "off"
                              },
                              domProps: { value: row.date_format }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  remote: "",
                                  "reserve-keyword": "",
                                  disabled: row.disabledFormat
                                },
                                model: {
                                  value: row.date_format,
                                  callback: function($$v) {
                                    _vm.$set(row, "date_format", $$v)
                                  },
                                  expression: "row.date_format"
                                }
                              },
                              _vm._l(_vm.dateFormats, function(dateFormat) {
                                return _c("el-option", {
                                  key: dateFormat.lookup_code,
                                  attrs: {
                                    label: dateFormat.description,
                                    value: dateFormat.lookup_code
                                  }
                                })
                              }),
                              1
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "mt-2" },
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "year_type",
                                autocomplete: "off"
                              },
                              domProps: { value: row.year_type }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                attrs: {
                                  filterable: "",
                                  remote: "",
                                  "reserve-keyword": "",
                                  disabled: row.disabledFormat
                                },
                                model: {
                                  value: row.year_type,
                                  callback: function($$v) {
                                    _vm.$set(row, "year_type", $$v)
                                  },
                                  expression: "row.year_type"
                                }
                              },
                              _vm._l(_vm.yearTypes, function(yearType) {
                                return _c("el-option", {
                                  key: yearType.lookup_code,
                                  attrs: {
                                    label: yearType.description,
                                    value: yearType.lookup_code
                                  }
                                })
                              }),
                              1
                            )
                          ],
                          1
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  row.group_format == "$PREFIX"
                    ? _c(
                        "div",
                        { staticClass: "col-sm-4" },
                        [
                          _c("el-input", {
                            attrs: {
                              type: "text",
                              name: "dataGroup[" + index + "][detail]",
                              size: "medium",
                              autocomplete: "off",
                              disabled: row.disabledFormat
                            },
                            model: {
                              value: row.detail,
                              callback: function($$v) {
                                _vm.$set(row, "detail", $$v)
                              },
                              expression: "row.detail"
                            }
                          })
                        ],
                        1
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  !_vm.disabledData
                    ? _c("div", { staticClass: "col-sm-1" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-sm btn-danger",
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.removeRow(index)
                              }
                            }
                          },
                          [_c("i", { staticClass: "fa fa-times" })]
                        )
                      ])
                    : _vm._e()
                ])
              }),
              _vm._v(" "),
              !_vm.disabledData
                ? _c("div", { staticClass: "text-right" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-sm btn-success",
                        attrs: { type: "submit" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.addLine($event)
                          }
                        }
                      },
                      [
                        _c("i", { staticClass: "fa fa-plus" }),
                        _vm._v(" เพิ่ม ")
                      ]
                    )
                  ])
                : _vm._e()
            ],
            2
          )
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
    return _c(
      "label",
      { staticClass: "col-sm-4 form-control-label text-right" },
      [
        _vm._v("Document Code "),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v(" * ")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-sm-4 form-control-label text-right" },
      [
        _vm._v("ระบบงาน"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v(" * ")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-sm-4 form-control-label text-right" },
      [
        _vm._v("ชื่อเมนู"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v(" * ")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-sm-4 form-control-label text-right" },
      [
        _vm._v("วันที่เริ่มใช้งาน"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v(" * ")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-sm-4 form-control-label text-right" },
      [
        _vm._v("เริ่ม Running ใหม่"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v(" * ")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "col-sm-4 form-control-label text-right" },
      [
        _vm._v("Running Number"),
        _c("span", { staticStyle: { color: "red" } }, [_vm._v(" * ")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group row" }, [
      _c("label", { staticClass: "col-sm-12 form-control-label" }, [
        _c("strong", [_vm._v("เลือกตำแหน่งและรูปแบบ Format")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);