(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_OverQuotaApprovalComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);


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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['authoRityLists', 'defaultValue', 'old'],
  data: function data() {
    return {
      cbb_range_from: this.old.cbb_range_from ? this.old.cbb_range_from : this.defaultValue ? this.defaultValue.cbb_range_from : '',
      cbb_range_to: this.old.cbb_range_to ? this.old.cbb_range_to : this.defaultValue ? this.defaultValue.cbb_range_to : '',
      authority_id1: this.old.authority_id1 ? Number(this.old.authority_id1) : this.defaultValue ? this.defaultValue.authority_id1 ? Number(this.defaultValue.authority_id1) : '' : '',
      authority_id2: this.old.authority_id2 ? Number(this.old.authority_id2) : this.defaultValue ? this.defaultValue.authority_id2 ? Number(this.defaultValue.authority_id2) : '' : '',
      authority_id3: this.old.authority_id3 ? Number(this.old.authority_id3) : this.defaultValue ? this.defaultValue.authority_id3 ? Number(this.defaultValue.authority_id3) : '' : '',
      sales_division_id: this.old.sales_division_id ? Number(this.old.sales_division_id) : this.defaultValue ? this.defaultValue.sales_division_id ? Number(this.defaultValue.sales_division_id) : '' : '',
      start_date: this.old.start_date ? this.old.start_date : this.defaultValue ? this.defaultValue.start_date : '',
      end_date: this.old.end_date ? this.old.end_date : this.defaultValue ? this.defaultValue.end_date : '',
      authority_id1_additional: this.old.authority_id1_additional ? this.old.authority_id1_additional : this.defaultValue ? this.defaultValue.authority_id1_additional : '',
      authority_id2_additional: this.old.authority_id2_additional ? this.old.authority_id2_additional : this.defaultValue ? this.defaultValue.authority_id2_additional : '',
      authority_id3_additional: this.old.authority_id3_additional ? this.old.authority_id3_additional : this.defaultValue ? this.defaultValue.authority_id3_additional : '',
      sales_division_additional: this.old.sales_division_additional ? this.old.sales_division_additional : this.defaultValue ? this.defaultValue.sales_division_additional : '',
      // สำหรับ เช็ค วันที่
      disabledDateTo: this.start_date ? this.start_date : null
    };
  },
  mounted: function mounted() {
    console.log('xxxxxxxxxxxxxxxxxx', this.start_date);

    if (!this.old.start_date || !this.old.end_date) {
      this.showDate();
    }
  },
  methods: {
    checkDate: function checkDate() {
      console.log('1111 --->' + this.start_date);

      if (this.start_date) {
        console.log('start -----> ' + moment__WEBPACK_IMPORTED_MODULE_1___default()(String(this.end_date)).format('yyyy-MM-DD'));
        console.log('end -----> ' + moment__WEBPACK_IMPORTED_MODULE_1___default()(String(this.start_date)).format('yyyy-MM-DD'));

        if (moment__WEBPACK_IMPORTED_MODULE_1___default()(String(this.end_date)).format('yyyy-MM-DD') < moment__WEBPACK_IMPORTED_MODULE_1___default()(String(this.start_date)).format('yyyy-MM-DD')) {
          this.$notify.error({
            title: 'มีข้อผิดพลาด',
            message: 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น'
          });
          this.end_date = '';
        }
      }
    },
    showDate: function showDate() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var date1, date2;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.start_date) {
                  _context.next = 5;
                  break;
                }

                _context.next = 3;
                return helperDate.parseToDateTh(_this.start_date, 'yyyy-MM-DD');

              case 3:
                date1 = _context.sent;
                _this.start_date = date1;

              case 5:
                if (!_this.end_date) {
                  _context.next = 10;
                  break;
                }

                _context.next = 8;
                return helperDate.parseToDateTh(_this.end_date, 'yyyy-MM-DD');

              case 8:
                date2 = _context.sent;
                _this.end_date = date2;

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    fromDateWasSelected: function fromDateWasSelected(date) {
      // change disabled_date_to of to_date = from_date
      this.disabledDateTo = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY");
    },
    getDivisionAdditional: function getDivisionAdditional() {
      var _this2 = this;

      // sales_division_id
      // authority_id1_additional
      this.sales_division_additional = '';
      this.selectedData = this.authoRityLists.find(function (i) {
        return i.authority_id == _this2.sales_division_id;
      });

      if (this.sales_division_id) {
        this.sales_division_additional = this.selectedData.position_name;
      } else {
        this.sales_division_additional = '';
      }
    },
    getId1Additional: function getId1Additional() {
      var _this3 = this;

      // authority_id1
      // authority_id1_additional
      this.authority_id1_additional = '';
      this.selectedData = this.authoRityLists.find(function (i) {
        return i.authority_id == _this3.authority_id1;
      });

      if (this.authority_id1) {
        this.authority_id1_additional = this.selectedData.position_name;
      } else {
        this.authority_id1_additional = '';
      }
    },
    getId2Additional: function getId2Additional() {
      var _this4 = this;

      // authority_id2
      // authority_id2_additional
      this.authority_id2_additional = '';
      this.selectedData = this.authoRityLists.find(function (i) {
        return i.authority_id == _this4.authority_id2;
      });

      if (this.authority_id2) {
        this.authority_id2_additional = this.selectedData.position_name;
      } else {
        this.authority_id2_additional = '';
      }
    },
    getId3Additional: function getId3Additional() {
      var _this5 = this;

      // authority_id3
      // authority_id3_additional
      this.authority_id3_additional = '';
      this.selectedData = this.authoRityLists.find(function (i) {
        return i.authority_id == _this5.authority_id3;
      });

      if (this.authority_id3) {
        this.authority_id3_additional = this.selectedData.position_name;
      } else {
        this.authority_id3_additional = '';
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/OverQuotaApprovalComponent.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/om/OverQuotaApprovalComponent.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OverQuotaApprovalComponent_vue_vue_type_template_id_e4e8dce8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8& */ "./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8&");
/* harmony import */ var _OverQuotaApprovalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OverQuotaApprovalComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _OverQuotaApprovalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _OverQuotaApprovalComponent_vue_vue_type_template_id_e4e8dce8___WEBPACK_IMPORTED_MODULE_0__.render,
  _OverQuotaApprovalComponent_vue_vue_type_template_id_e4e8dce8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/OverQuotaApprovalComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OverQuotaApprovalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OverQuotaApprovalComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OverQuotaApprovalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OverQuotaApprovalComponent_vue_vue_type_template_id_e4e8dce8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OverQuotaApprovalComponent_vue_vue_type_template_id_e4e8dce8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OverQuotaApprovalComponent_vue_vue_type_template_id_e4e8dce8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/OverQuotaApprovalComponent.vue?vue&type=template&id=e4e8dce8& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "col-md-2" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(0),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "cbb_range_from" },
            model: {
              value: _vm.cbb_range_from,
              callback: function($$v) {
                _vm.cbb_range_from = $$v
              },
              expression: "cbb_range_from"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "cbb_range_to" },
            model: {
              value: _vm.cbb_range_to,
              callback: function($$v) {
                _vm.cbb_range_to = $$v
              },
              expression: "cbb_range_to"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-2" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" วันที่เริ่มต้น")]),
          _vm._v(" "),
          _c("datepicker-th", {
            staticClass: "form-control md:tw-mb-0 tw-mb-2",
            staticStyle: { width: "100%" },
            attrs: {
              name: "start_date",
              placeholder: "โปรดเลือกวันที่",
              format: "DD-MM-YYYY"
            },
            on: { dateWasSelected: _vm.fromDateWasSelected },
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
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" วันที่สิ้นสุด")]),
          _vm._v(" "),
          _c("datepicker-th", {
            staticClass: "form-control md:tw-mb-0 tw-mb-2",
            staticStyle: { width: "100%" },
            attrs: {
              name: "end_date",
              placeholder: "โปรดเลือกวันที่",
              format: "DD-MM-YYYY",
              "disabled-date-to": _vm.disabledDateTo
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
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-2" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(2),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "sales_division_id",
              autocomplete: "off"
            },
            domProps: { value: _vm.sales_division_id }
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
                placeholder: "โปรดเลือก"
              },
              on: {
                change: function($event) {
                  return _vm.getDivisionAdditional()
                }
              },
              model: {
                value: _vm.sales_division_id,
                callback: function($$v) {
                  _vm.sales_division_id = $$v
                },
                expression: "sales_division_id"
              }
            },
            _vm._l(_vm.authoRityLists, function(authoRityList) {
              return _c("el-option", {
                key: authoRityList.authority_id,
                attrs: {
                  label:
                    authoRityList.employee_name +
                    " : " +
                    authoRityList.position_name,
                  value: authoRityList.authority_id
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
        { staticClass: "col-md-4" },
        [
          _vm._m(3),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "sales_division_additional",
              autocomplete: "off"
            },
            domProps: { value: _vm.sales_division_additional }
          }),
          _vm._v(" "),
          _c("el-input", {
            attrs: { clearable: "" },
            model: {
              value: _vm.sales_division_additional,
              callback: function($$v) {
                _vm.sales_division_additional = $$v
              },
              expression: "sales_division_additional"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-2" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ผู้เรียนพิจารณา 1 ")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id1",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id1 }
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
                placeholder: "โปรดเลือก"
              },
              on: {
                change: function($event) {
                  return _vm.getId1Additional()
                }
              },
              model: {
                value: _vm.authority_id1,
                callback: function($$v) {
                  _vm.authority_id1 = $$v
                },
                expression: "authority_id1"
              }
            },
            _vm._l(_vm.authoRityLists, function(authoRityList) {
              return _c("el-option", {
                key: authoRityList.authority_id,
                attrs: {
                  label:
                    authoRityList.employee_name +
                    " : " +
                    authoRityList.position_name,
                  value: authoRityList.authority_id
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
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ตำแหน่งที่แสดงในรายงาน  ")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id1_additional",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id1_additional }
          }),
          _vm._v(" "),
          _c("el-input", {
            attrs: { clearable: "" },
            model: {
              value: _vm.authority_id1_additional,
              callback: function($$v) {
                _vm.authority_id1_additional = $$v
              },
              expression: "authority_id1_additional"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-2" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ผู้เรียนพิจารณา 2 ")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id2",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id2 }
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
                placeholder: "โปรดเลือก"
              },
              on: {
                change: function($event) {
                  return _vm.getId2Additional()
                }
              },
              model: {
                value: _vm.authority_id2,
                callback: function($$v) {
                  _vm.authority_id2 = $$v
                },
                expression: "authority_id2"
              }
            },
            _vm._l(_vm.authoRityLists, function(authoRityList) {
              return _c("el-option", {
                key: authoRityList.authority_id,
                attrs: {
                  label:
                    authoRityList.employee_name +
                    " : " +
                    authoRityList.position_name,
                  value: authoRityList.authority_id
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
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ตำแหน่งที่แสดงในรายงาน ")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id2_additional",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id2_additional }
          }),
          _vm._v(" "),
          _c("el-input", {
            attrs: { clearable: "" },
            model: {
              value: _vm.authority_id2_additional,
              callback: function($$v) {
                _vm.authority_id2_additional = $$v
              },
              expression: "authority_id2_additional"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-2" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(4),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id3",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id3 }
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
                placeholder: "โปรดเลือก"
              },
              on: {
                change: function($event) {
                  return _vm.getId3Additional()
                }
              },
              model: {
                value: _vm.authority_id3,
                callback: function($$v) {
                  _vm.authority_id3 = $$v
                },
                expression: "authority_id3"
              }
            },
            _vm._l(_vm.authoRityLists, function(authoRityList) {
              return _c("el-option", {
                key: authoRityList.authority_id,
                attrs: {
                  label:
                    authoRityList.employee_name +
                    " : " +
                    authoRityList.position_name,
                  value: authoRityList.authority_id
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
        { staticClass: "col-md-4" },
        [
          _vm._m(5),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id3_additional",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id3_additional }
          }),
          _vm._v(" "),
          _c("el-input", {
            attrs: { clearable: "" },
            model: {
              value: _vm.authority_id3_additional,
              callback: function($$v) {
                _vm.authority_id3_additional = $$v
              },
              expression: "authority_id3_additional"
            }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ช่วงหีบ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ถึง "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" กองบริหารขาย "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ตำแหน่งที่แสดงในรายงาน "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ผู้มีอำนาจอนุมัติ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ตำแหน่งที่แสดงในรายงาน  "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);