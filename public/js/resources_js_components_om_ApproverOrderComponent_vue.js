(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_ApproverOrderComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ApproverOrderComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ApproverOrderComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['authoRityLists', 'defaultValue', 'old'],
  data: function data() {
    return {
      authority_id: this.old.authority_id ? this.old.authority_id : this.defaultValue ? Number(this.defaultValue.authority_id) : '',
      start_date: this.old.start_date ? this.old.start_date : this.defaultValue ? this.defaultValue.start_date : '',
      end_date: this.old.end_date ? this.old.end_date : this.defaultValue ? this.defaultValue.end_date : '',
      approver_number: this.old.approver_number ? this.old.approver_number : this.defaultValue ? this.defaultValue.approver_number : '',
      default_flag: this.old.default_flag ? true : this.defaultValue ? this.defaultValue.default_flag == 'Y' ? true : false : false,
      // สำหรับ เช็ค วันที่
      disabledDateTo: this.start_date ? this.start_date : null // customer_id: this.old.customer_id                      ? Number(this.old.customer_id) : this.defaultValue ? Number(this.defaultValue.customer_id) : '',
      // grant_special_flag: this.old.grant_special_flag == 'Y' ? true : this.defaultValue     ? this.defaultValue.grant_special_flag == 'Y' ? true : '' : '',
      // second_order_flag: this.old.second_order_flag == 'Y'   ? true : this.defaultValue     ? this.defaultValue.second_order_flag == 'Y' ? true : '' : '',
      // allowed_order_date: this.old.allowed_order_date        ? this.old.allowed_order_date  : this.defaultValue ? this.defaultValue.allowed_order_date : '',

    };
  },
  mounted: function mounted() {
    console.log(this.start_date);

    if (!this.old.start_date || !this.old.end_date) {
      this.showDate();
    } // if (this.start_date) {
    //     this.disabledDateTo = this.start_date;
    //     // console.log('xxxx ---> ' + this.disabledDateTo);
    //     this.fromDateWasSelected();
    // }

  },
  methods: {
    onlyNumeric: function onlyNumeric() {
      this.approver_number = this.approver_number.replace(/[^0-9 .]/g, '');
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
      console.log('bbb ---> ' + this.disabledDateTo);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/ApproverOrderComponent.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/om/ApproverOrderComponent.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ApproverOrderComponent_vue_vue_type_template_id_a0cfdeac___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac& */ "./resources/js/components/om/ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac&");
/* harmony import */ var _ApproverOrderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ApproverOrderComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/ApproverOrderComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ApproverOrderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ApproverOrderComponent_vue_vue_type_template_id_a0cfdeac___WEBPACK_IMPORTED_MODULE_0__.render,
  _ApproverOrderComponent_vue_vue_type_template_id_a0cfdeac___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/ApproverOrderComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/ApproverOrderComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/om/ApproverOrderComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ApproverOrderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ApproverOrderComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ApproverOrderComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ApproverOrderComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/om/ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ApproverOrderComponent_vue_vue_type_template_id_a0cfdeac___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ApproverOrderComponent_vue_vue_type_template_id_a0cfdeac___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ApproverOrderComponent_vue_vue_type_template_id_a0cfdeac___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ApproverOrderComponent.vue?vue&type=template&id=a0cfdeac& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
            attrs: { name: "approver_number", type: "text" },
            model: {
              value: _vm.approver_number,
              callback: function($$v) {
                _vm.approver_number = $$v
              },
              expression: "approver_number"
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
          _c("input", {
            attrs: {
              type: "hidden",
              name: "authority_id",
              autocomplete: "off"
            },
            domProps: { value: _vm.authority_id }
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
                value: _vm.authority_id,
                callback: function($$v) {
                  _vm.authority_id = $$v
                },
                expression: "authority_id"
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
          _c("label", [_vm._v(" วันที่เริ่มต้น ")]),
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
          _c("label", [_vm._v(" วันที่สิ้นสุด ")]),
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
      _c("div", { staticClass: "col-md-2" }, [
        _c("label", [_vm._v(" Default ")]),
        _vm._v(" "),
        _c("div", [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.default_flag,
                expression: "default_flag"
              }
            ],
            attrs: { type: "checkbox", name: "default_flag" },
            domProps: {
              checked: Array.isArray(_vm.default_flag)
                ? _vm._i(_vm.default_flag, null) > -1
                : _vm.default_flag
            },
            on: {
              change: function($event) {
                var $$a = _vm.default_flag,
                  $$el = $event.target,
                  $$c = $$el.checked ? true : false
                if (Array.isArray($$a)) {
                  var $$v = null,
                    $$i = _vm._i($$a, $$v)
                  if ($$el.checked) {
                    $$i < 0 && (_vm.default_flag = $$a.concat([$$v]))
                  } else {
                    $$i > -1 &&
                      (_vm.default_flag = $$a
                        .slice(0, $$i)
                        .concat($$a.slice($$i + 1)))
                  }
                } else {
                  _vm.default_flag = $$c
                }
              }
            }
          })
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
    return _c("label", [
      _vm._v(" ลำดับที่ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ผู้อนุมัติ"),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);