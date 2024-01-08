(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_MaxStorageComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaxStorageComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaxStorageComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["old", "defaultValue", "itemGroups", "urlSave", "urlReset"],
  data: function data() {
    return {
      item_cat_code: this.old.item_cat_code ? this.old.item_cat_code : this.defaultValue ? this.defaultValue.item_cat_code : "",
      max_qty: this.old.max_qty ? this.old.max_qty : this.defaultValue ? this.defaultValue.max_qty : "",
      // uom_code:      this.old.uom_code      ? this.old.uom_code      : this.defaultValue ? this.defaultValue.uom_code : '',
      enable_flag: this.old.enable_flag ? this.old.enable_flag ? true : false : this.defaultValue ? this.defaultValue.enable_flag == "Y" ? true : false : true,
      // item_cat_code: '',
      // max_qty:       '',
      uom_code: "",
      uom_description: "",
      uomLists: [],
      // uomLoading: true,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    };
  },
  mounted: function mounted() {
    if (this.item_cat_code) {
      this.getItemData();
    }

    this.numbericBlur(); // this.getUom();
    // this.uom_code  = this.old.uom_code ? this.old.uom_code : this.defaultValue ? this.defaultValue.uom_code : '';
  },
  methods: {
    numbericFocus: function numbericFocus() {
      this.max_qty = this.max_qty.replaceAll(",", "");
    },
    numbericBlur: function numbericBlur() {
      this.max_qty = this.max_qty.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    onlyNumeric: function onlyNumeric() {
      this.max_qty = this.max_qty.replace(/[^0-9]/g, "");
    },
    getUom: function getUom(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                // this.uomLoading = true;
                _this.uomLists = [];
                axios.get("/pm/ajax/max-storage/get-uom", {
                  params: {
                    query: query
                  }
                }).then(function (res) {
                  _this.uomLists = res.data; // this.uomLoading = false;
                })["catch"](function (err) {
                  console.log(err);
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    checkForm: function checkForm(e) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var form, inputs;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                form = $("#submitForm");
                inputs = form.serialize();
                _this2.errors = [];

                if (!_this2.item_cat_code) {
                  _this2.errors.push("ประเภทวัตถุดิบ");

                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this2.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                if (!_this2.max_qty) {
                  _this2.errors.push("จำนวนพัสดุต่อพื้นที่");

                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this2.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                if (!_this2.uom_code) {
                  _this2.errors.push("หน่วยนับ");

                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this2.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                Vue.set(_this2, 'max_qty', _this2.max_qty.replaceAll(',', ''));

                if (!_this2.errors.length) {
                  form.submit();
                }

                e.preventDefault();

              case 9:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getItemData: function getItemData() {
      var _this3 = this;

      this.uom_description = "";
      this.uom_code = "";

      if (this.item_cat_code) {
        axios.get("/pm/ajax/max-storage/get-uom", {
          params: {
            item_cat_code: this.item_cat_code
          }
        }).then(function (res) {
          var uom = res.data;
          _this3.uom_description = uom.unit_of_measure;
          _this3.uom_code = uom.uom_code;
        })["catch"](function (err) {
          console.log(err);
        });
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/MaxStorageComponent.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/pm/MaxStorageComponent.vue ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _MaxStorageComponent_vue_vue_type_template_id_77e72dc2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MaxStorageComponent.vue?vue&type=template&id=77e72dc2& */ "./resources/js/components/pm/MaxStorageComponent.vue?vue&type=template&id=77e72dc2&");
/* harmony import */ var _MaxStorageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MaxStorageComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/MaxStorageComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _MaxStorageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MaxStorageComponent_vue_vue_type_template_id_77e72dc2___WEBPACK_IMPORTED_MODULE_0__.render,
  _MaxStorageComponent_vue_vue_type_template_id_77e72dc2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/MaxStorageComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/MaxStorageComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/pm/MaxStorageComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MaxStorageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MaxStorageComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaxStorageComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MaxStorageComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/MaxStorageComponent.vue?vue&type=template&id=77e72dc2&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/pm/MaxStorageComponent.vue?vue&type=template&id=77e72dc2& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MaxStorageComponent_vue_vue_type_template_id_77e72dc2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MaxStorageComponent_vue_vue_type_template_id_77e72dc2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MaxStorageComponent_vue_vue_type_template_id_77e72dc2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MaxStorageComponent.vue?vue&type=template&id=77e72dc2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaxStorageComponent.vue?vue&type=template&id=77e72dc2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaxStorageComponent.vue?vue&type=template&id=77e72dc2&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MaxStorageComponent.vue?vue&type=template&id=77e72dc2& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
  return _c(
    "form",
    {
      attrs: { id: "submitForm", action: _vm.urlSave, method: "post" },
      on: {
        submit: function($event) {
          $event.preventDefault()
          return _vm.checkForm($event)
        }
      }
    },
    [
      _c("input", {
        attrs: { type: "hidden", name: "_token" },
        domProps: { value: _vm.csrf }
      }),
      _vm._v(" "),
      this.defaultValue
        ? _c("input", {
            attrs: { type: "hidden", name: "_method", value: "PUT" }
          })
        : _vm._e(),
      _vm._v(" "),
      _c("div", [
        _c("div", { staticClass: "container" }, [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col" },
              [
                _vm._m(0),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "item_cat_code",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.item_cat_code }
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
                    on: {
                      change: function($event) {
                        return _vm.getItemData()
                      }
                    },
                    model: {
                      value: _vm.item_cat_code,
                      callback: function($$v) {
                        _vm.item_cat_code = $$v
                      },
                      expression: "item_cat_code"
                    }
                  },
                  _vm._l(_vm.itemGroups, function(group) {
                    return _c("el-option", {
                      key: group.item_cat_code,
                      attrs: {
                        label: group.item_cat_segment2_desc,
                        value: group.item_cat_code
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
              { staticClass: "col" },
              [
                _vm._m(1),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "max_qty" },
                  on: {
                    focus: _vm.numbericFocus,
                    blur: _vm.numbericBlur,
                    input: function($event) {
                      return _vm.onlyNumeric()
                    }
                  },
                  model: {
                    value: _vm.max_qty,
                    callback: function($$v) {
                      _vm.max_qty = $$v
                    },
                    expression: "max_qty"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col" },
              [
                _vm._m(2),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "uom_description", disabled: "" },
                  model: {
                    value: _vm.uom_description,
                    callback: function($$v) {
                      _vm.uom_description = $$v
                    },
                    expression: "uom_description"
                  }
                }),
                _vm._v(" "),
                _c("input", {
                  attrs: { type: "hidden", name: "uom_code" },
                  domProps: { value: _vm.uom_code }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col" }, [
              _c("label", [_vm._v(" สถานะการใช้งาน ")]),
              _vm._v(" "),
              _c("div", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.enable_flag,
                      expression: "enable_flag"
                    }
                  ],
                  attrs: { type: "checkbox", name: "enable_flag" },
                  domProps: {
                    checked: Array.isArray(_vm.enable_flag)
                      ? _vm._i(_vm.enable_flag, null) > -1
                      : _vm.enable_flag
                  },
                  on: {
                    change: function($event) {
                      var $$a = _vm.enable_flag,
                        $$el = $event.target,
                        $$c = $$el.checked ? true : false
                      if (Array.isArray($$a)) {
                        var $$v = null,
                          $$i = _vm._i($$a, $$v)
                        if ($$el.checked) {
                          $$i < 0 && (_vm.enable_flag = $$a.concat([$$v]))
                        } else {
                          $$i > -1 &&
                            (_vm.enable_flag = $$a
                              .slice(0, $$i)
                              .concat($$a.slice($$i + 1)))
                        }
                      } else {
                        _vm.enable_flag = $$c
                      }
                    }
                  }
                })
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("hr"),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-3 text-right" }, [
        _c("div", { staticClass: "col-sm-12" }, [
          _vm._m(3),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass: "btn btn-sm btn-warning",
              attrs: { href: this.urlReset, type: "button" }
            },
            [_c("i", { staticClass: "fa fa-times" }), _vm._v(" ยกเลิก\n      ")]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ประเภทวัตถุดิบ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" จำนวนพัสดุต่อพื้นที่ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" หน่วยนับ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      { staticClass: "btn btn-sm btn-primary", attrs: { type: "submit" } },
      [_c("i", { staticClass: "fa fa-save" }), _vm._v(" บันทึก\n      ")]
    )
  }
]
render._withStripped = true



/***/ })

}]);