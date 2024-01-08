(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_GrantSpacialCaseComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['customers', 'defaultValue', 'old'],
  data: function data() {
    return {
      customer_id: this.old.customer_id ? Number(this.old.customer_id) : this.defaultValue ? Number(this.defaultValue.customer_id) : '',
      grant_special_flag: this.old.grant_special_flag == 'Y' ? true : this.defaultValue ? this.defaultValue.grant_special_flag == 'Y' ? true : '' : '',
      second_order_flag: this.old.second_order_flag == 'Y' ? true : this.defaultValue ? this.defaultValue.second_order_flag == 'Y' ? true : '' : '',
      allowed_order_date: this.old.allowed_order_date ? this.old.allowed_order_date : this.defaultValue ? this.defaultValue.allowed_order_date : '' // start_date:         this.old.start_date                ? this.old.start_date          : this.defaultValue ? this.defaultValue.start_date : '',
      // end_date:           this.old.end_date                  ? this.old.end_date            : this.defaultValue ? this.defaultValue.end_date   : '',

    };
  },
  mounted: function mounted() {
    // console.log('old ----> ' + this.old);
    if (!this.old.allowed_order_date) {
      this.showDate();
    }
  },
  methods: {
    showDate: function showDate() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var date1;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log('date ----> ' + _this.allowed_order_date);

                if (!_this.allowed_order_date) {
                  _context.next = 6;
                  break;
                }

                _context.next = 4;
                return helperDate.parseToDateTh(_this.allowed_order_date, 'yyyy-MM-DD');

              case 4:
                date1 = _context.sent;
                _this.allowed_order_date = date1;

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/GrantSpacialCaseComponent.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/om/GrantSpacialCaseComponent.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _GrantSpacialCaseComponent_vue_vue_type_template_id_21ddd96e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e& */ "./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e&");
/* harmony import */ var _GrantSpacialCaseComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./GrantSpacialCaseComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _GrantSpacialCaseComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _GrantSpacialCaseComponent_vue_vue_type_template_id_21ddd96e___WEBPACK_IMPORTED_MODULE_0__.render,
  _GrantSpacialCaseComponent_vue_vue_type_template_id_21ddd96e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/GrantSpacialCaseComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GrantSpacialCaseComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./GrantSpacialCaseComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GrantSpacialCaseComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GrantSpacialCaseComponent_vue_vue_type_template_id_21ddd96e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GrantSpacialCaseComponent_vue_vue_type_template_id_21ddd96e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GrantSpacialCaseComponent_vue_vue_type_template_id_21ddd96e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/GrantSpacialCaseComponent.vue?vue&type=template&id=21ddd96e& ***!
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
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _vm._m(0),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "customer_id", autocomplete: "off" },
            domProps: { value: _vm.customer_id }
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
                value: _vm.customer_id,
                callback: function($$v) {
                  _vm.customer_id = $$v
                },
                expression: "customer_id"
              }
            },
            _vm._l(_vm.customers, function(customer) {
              return _c("el-option", {
                key: customer.customer_id,
                attrs: {
                  label: customer.customer_number
                    ? customer.customer_number + " : " + customer.customer_name
                    : customer.customer_name,
                  value: customer.customer_id
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
        { staticClass: "col-md-5" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("datepicker-th", {
            staticClass: "form-control md:tw-mb-0 tw-mb-2",
            staticStyle: { width: "100%" },
            attrs: {
              name: "allowed_order_date",
              placeholder: "โปรดเลือกวันที่อนุญาติให้สั่งซื้อได้",
              format: "DD-MM-YYYY"
            },
            model: {
              value: _vm.allowed_order_date,
              callback: function($$v) {
                _vm.allowed_order_date = $$v
              },
              expression: "allowed_order_date"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-5" }, [
        _vm._m(2),
        _c("br"),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.grant_special_flag,
              expression: "grant_special_flag"
            }
          ],
          attrs: { type: "checkbox", name: "grant_special_flag" },
          domProps: {
            checked: Array.isArray(_vm.grant_special_flag)
              ? _vm._i(_vm.grant_special_flag, null) > -1
              : _vm.grant_special_flag
          },
          on: {
            change: function($event) {
              var $$a = _vm.grant_special_flag,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 && (_vm.grant_special_flag = $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    (_vm.grant_special_flag = $$a
                      .slice(0, $$i)
                      .concat($$a.slice($$i + 1)))
                }
              } else {
                _vm.grant_special_flag = $$c
              }
            }
          }
        })
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-5" }, [
        _vm._m(3),
        _c("br"),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.second_order_flag,
              expression: "second_order_flag"
            }
          ],
          attrs: { type: "checkbox", name: "second_order_flag" },
          domProps: {
            checked: Array.isArray(_vm.second_order_flag)
              ? _vm._i(_vm.second_order_flag, null) > -1
              : _vm.second_order_flag
          },
          on: {
            change: function($event) {
              var $$a = _vm.second_order_flag,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 && (_vm.second_order_flag = $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    (_vm.second_order_flag = $$a
                      .slice(0, $$i)
                      .concat($$a.slice($$i + 1)))
                }
              } else {
                _vm.second_order_flag = $$c
              }
            }
          }
        })
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
      _vm._v(" รหัส - ชื่อลูกค้า "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" วันที่อนุญาติให้สั่งซื้อได้ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" สั่งซื้อกรณีพิเศษ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" สั่งซื้อครั้งที่ 2 ในวัน "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);