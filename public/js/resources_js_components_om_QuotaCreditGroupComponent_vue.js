(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_QuotaCreditGroupComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['items', 'quotaGroups', 'creditGroups', 'defaultValue', 'old'],
  data: function data() {
    return {
      item_id: this.old.item_id ? this.old.item_id : this.defaultValue ? this.defaultValue.item_id : '',
      quota_group_code: this.old.quota_group_code ? this.old.quota_group_code : this.defaultValue ? this.defaultValue.quota_group_code : '',
      credit_group_code: this.old.credit_group_code ? this.old.credit_group_code : this.defaultValue ? this.defaultValue.credit_group_code : '',
      disabledEdit: this.defaultValue ? true : false,
      start_date: this.old.start_date ? this.old.start_date : this.defaultValue ? this.defaultValue.start_date : '',
      end_date: this.old.end_date ? this.old.end_date : this.defaultValue ? this.defaultValue.end_date : '',
      item_description: '',
      // สำหรับ เช็ค วันที่
      disabledDateTo: this.start_date ? this.start_date : null
    };
  },
  mounted: function mounted() {
    // console.log('xxx -->' + this.old);
    if (this.item_id) {
      this.getSelectedItem();
    }

    if (!this.old.start_date || !this.old.end_date) {
      this.showDate();
    }
  },
  methods: {
    getSelectedItem: function getSelectedItem() {
      var _this = this;

      this.selectedItem = this.items.find(function (i) {
        return i.item_id == _this.item_id;
      });

      if (this.item_id) {
        this.item_description = this.defaultValue ? this.defaultValue.item_description : this.selectedItem.ecom_item_description;
      } else {
        this.item_description = '';
      }
    },
    checkDate: function checkDate() {
      if (this.start_date) {
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
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var date1, date2;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this2.start_date) {
                  _context.next = 5;
                  break;
                }

                _context.next = 3;
                return helperDate.parseToDateTh(_this2.start_date, 'yyyy-MM-DD');

              case 3:
                date1 = _context.sent;
                _this2.start_date = date1;

              case 5:
                if (!_this2.end_date) {
                  _context.next = 10;
                  break;
                }

                _context.next = 8;
                return helperDate.parseToDateTh(_this2.end_date, 'yyyy-MM-DD');

              case 8:
                date2 = _context.sent;
                _this2.end_date = date2;

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
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/QuotaCreditGroupComponent.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/om/QuotaCreditGroupComponent.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _QuotaCreditGroupComponent_vue_vue_type_template_id_52531ce9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9& */ "./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9&");
/* harmony import */ var _QuotaCreditGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./QuotaCreditGroupComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _QuotaCreditGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _QuotaCreditGroupComponent_vue_vue_type_template_id_52531ce9___WEBPACK_IMPORTED_MODULE_0__.render,
  _QuotaCreditGroupComponent_vue_vue_type_template_id_52531ce9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/QuotaCreditGroupComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_QuotaCreditGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./QuotaCreditGroupComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_QuotaCreditGroupComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_QuotaCreditGroupComponent_vue_vue_type_template_id_52531ce9___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_QuotaCreditGroupComponent_vue_vue_type_template_id_52531ce9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_QuotaCreditGroupComponent_vue_vue_type_template_id_52531ce9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/QuotaCreditGroupComponent.vue?vue&type=template&id=52531ce9& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(0),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "item_id", autocomplete: "off" },
            domProps: { value: _vm.item_id }
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
                disabled: this.disabledEdit
              },
              on: {
                change: function($event) {
                  return _vm.getSelectedItem()
                }
              },
              model: {
                value: _vm.item_id,
                callback: function($$v) {
                  _vm.item_id = $$v
                },
                expression: "item_id"
              }
            },
            _vm._l(_vm.items, function(item) {
              return _c("el-option", {
                key: item.item_id,
                attrs: {
                  label: item.item_code + " : " + item.ecom_item_description,
                  value: item.item_id
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
          _c("label", [_vm._v(" ชื่อผลิตภัณฑ์ ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: "" },
            model: {
              value: _vm.item_description,
              callback: function($$v) {
                _vm.item_description = $$v
              },
              expression: "item_description"
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
          _c("label", [_vm._v(" กลุ่มโควต้า")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "quota_group_code",
              autocomplete: "off"
            },
            domProps: { value: _vm.quota_group_code }
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
                clearable: ""
              },
              model: {
                value: _vm.quota_group_code,
                callback: function($$v) {
                  _vm.quota_group_code = $$v
                },
                expression: "quota_group_code"
              }
            },
            _vm._l(_vm.quotaGroups, function(quota) {
              return _c("el-option", {
                key: quota.lookup_code,
                attrs: {
                  label: quota.meaning + " : " + quota.description,
                  value: quota.lookup_code
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
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "credit_group_code",
              autocomplete: "off"
            },
            domProps: { value: _vm.credit_group_code }
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
                clearable: ""
              },
              model: {
                value: _vm.credit_group_code,
                callback: function($$v) {
                  _vm.credit_group_code = $$v
                },
                expression: "credit_group_code"
              }
            },
            _vm._l(_vm.creditGroups, function(credit) {
              return _c("el-option", {
                key: credit.lookup_code,
                attrs: { label: credit.description, value: credit.lookup_code }
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
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" รหัสผลิตภัณฑ์ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" กลุ่มวงเงินเขื่อ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);