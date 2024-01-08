(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_ItemWeightComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ItemWeightComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ItemWeightComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['sequenceEcoms', 'uoms', 'defaultValue', 'old', 'transDate'],
  data: function data() {
    return {
      item_id: this.old.item_id ? this.old.item_id : this.defaultValue ? this.defaultValue.item_id : '',
      // start_date:       this.old.start_date  ? this.old.start_date  : this.defaultValue ? this.defaultValue.start_date  : '',
      // end_date:         this.old.end_date    ? this.old.end_date    : this.defaultValue ? this.defaultValue.end_date    : '',
      uom_code: this.old.uom ? this.old.uom : this.defaultValue ? this.defaultValue.uom : '',
      net_weight: this.old.net_weight ? this.old.net_weight : this.defaultValue ? this.defaultValue.net_weight : '',
      net_gross: this.old.net_gross ? this.old.net_gross : this.defaultValue ? this.defaultValue.net_gross : '',
      item_description: '',
      uom_description: '',
      active_flag: this.old.active_flag == 'Y' ? true : this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : '' : true,
      disabledEdit: this.defaultValue ? true : false,
      start_date: '',
      end_date: '',
      start_date_format: this.old.start_date_format ? this.old.start_date_format : this.defaultValue ? this.defaultValue.start_date_format : '',
      end_date_format: this.old.end_date_format ? this.old.end_date_format : this.defaultValue ? this.defaultValue.end_date_format : '',
      length: this.old.length ? this.old.length : this.defaultValue ? this.defaultValue.length : '',
      width: this.old.width ? this.old.width : this.defaultValue ? this.defaultValue.width : '',
      height: this.old.height ? this.old.height : this.defaultValue ? this.defaultValue.height : ''
    };
  },
  mounted: function mounted() {
    if (this.item_id) {
      this.getSelectedItem();
    }

    if (this.uom_code) {
      this.getSelectedUom();
    } // if (this.old.start_date) {
    //     // this.start_date = moment(String((this.old.start_date)).format('yyyy-MM-DD'));
    //     this.start_date = moment(String(this.old.start_date)).format('yyyy-MM-DD');
    // } else if (this.defaultValue){
    //     if (this.defaultValue.start_date) {
    //         this.start_date = this.defaultValue.start_date;
    //     }
    // }
    // if (this.old.end_date) {
    //     this.end_date = this.old.end_date;
    // } else if (this.defaultValue){
    //     if (this.defaultValue.end_date) {
    //         this.end_date = this.defaultValue.end_date;
    //     }
    // }


    this.onlyNumeric();
  },
  methods: {
    setdate: function setdate(date, input) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                _context.next = 3;
                return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format(vm.transDate['js-format']);

              case 3:
                data = _context.sent;

                if (data == 'Invalid date') {
                  data = '';
                }

                vm[input] = data;

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getSelectedItem: function getSelectedItem() {
      var _this2 = this;

      this.selectedItem = this.sequenceEcoms.find(function (i) {
        return i.item_id == _this2.item_id;
      });

      if (this.item_id) {
        this.item_description = this.defaultValue ? this.defaultValue.item_description : this.selectedItem.ecom_item_description;
      } else {
        this.item_description = '';
      }
    },
    getSelectedUom: function getSelectedUom() {
      var _this3 = this;

      this.selectedUom = this.uoms.find(function (i) {
        return i.uom_code == _this3.uom_code;
      });

      if (this.uom_code) {
        this.uom_description = this.selectedUom.description;
      } else {
        this.uom_description = '';
      }
    },
    onlyNumeric: function onlyNumeric() {
      this.net_weight = this.net_weight.replace(/[^0-9 .]/g, '');
      this.net_gross = this.net_gross.replace(/[^0-9 .]/g, ''); // this.length = this.length.replace(/[^0-9 .]/g, '');
      // this.width = this.width.replace(/[^0-9 .]/g, '');
      // this.height = this.height.replace(/[^0-9 .]/g, '');

      if (this.length) {
        this.length = this.length.replace(/[^0-9 .]/g, '');
        this.length = this.length.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      if (this.width) {
        this.width = this.width.replace(/[^0-9 .]/g, '');
        this.width = this.width.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }

      if (this.height) {
        this.height = this.height.replace(/[^0-9 .]/g, '');
        this.height = this.height.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/ItemWeightComponent.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/om/ItemWeightComponent.vue ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ItemWeightComponent_vue_vue_type_template_id_3bbbcf8c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c& */ "./resources/js/components/om/ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c&");
/* harmony import */ var _ItemWeightComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ItemWeightComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/ItemWeightComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ItemWeightComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ItemWeightComponent_vue_vue_type_template_id_3bbbcf8c___WEBPACK_IMPORTED_MODULE_0__.render,
  _ItemWeightComponent_vue_vue_type_template_id_3bbbcf8c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/ItemWeightComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/ItemWeightComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/om/ItemWeightComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemWeightComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ItemWeightComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ItemWeightComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemWeightComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/om/ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemWeightComponent_vue_vue_type_template_id_3bbbcf8c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemWeightComponent_vue_vue_type_template_id_3bbbcf8c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemWeightComponent_vue_vue_type_template_id_3bbbcf8c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/ItemWeightComponent.vue?vue&type=template&id=3bbbcf8c& ***!
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
            _vm._l(_vm.sequenceEcoms, function(sequenceEcom) {
              return _c("el-option", {
                key: sequenceEcom.item_id,
                attrs: {
                  label:
                    sequenceEcom.item_code +
                    " : " +
                    sequenceEcom.ecom_item_description,
                  value: sequenceEcom.item_id
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
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "uom_code", autocomplete: "off" },
            domProps: { value: _vm.uom_code }
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
                  return _vm.getSelectedUom()
                }
              },
              model: {
                value: _vm.uom_code,
                callback: function($$v) {
                  _vm.uom_code = $$v
                },
                expression: "uom_code"
              }
            },
            _vm._l(_vm.uoms, function(uom) {
              return _c("el-option", {
                key: uom.uom_code,
                attrs: {
                  label: uom.uom_code + " : " + uom.description,
                  value: uom.uom_code
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
          _c("label", [_vm._v(" หน่วยนับ ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: "" },
            model: {
              value: _vm.uom_description,
              callback: function($$v) {
                _vm.uom_description = $$v
              },
              expression: "uom_description"
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
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" Net ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "net_weight" },
            on: { input: _vm.onlyNumeric },
            model: {
              value: _vm.net_weight,
              callback: function($$v) {
                _vm.net_weight = $$v
              },
              expression: "net_weight"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" Gross ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "net_gross" },
            on: { input: _vm.onlyNumeric },
            model: {
              value: _vm.net_gross,
              callback: function($$v) {
                _vm.net_gross = $$v
              },
              expression: "net_gross"
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
        _c("label", [_vm._v(" Dimensions กว้าง x ยาว x สูง ")]),
        _vm._v(" "),
        _c("div", { staticClass: "input-group " }, [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.length,
                expression: "length"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "text", name: "length", placeholder: "กว้าง" },
            domProps: { value: _vm.length },
            on: {
              input: [
                function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.length = $event.target.value
                },
                _vm.onlyNumeric
              ]
            }
          }),
          _vm._v(" "),
          _vm._m(2),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.width,
                expression: "width"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "text", name: "width", placeholder: "ยาว" },
            domProps: { value: _vm.width },
            on: {
              input: [
                function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.width = $event.target.value
                },
                _vm.onlyNumeric
              ]
            }
          }),
          _vm._v(" "),
          _vm._m(3),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.height,
                expression: "height"
              }
            ],
            staticClass: "form-control",
            attrs: { type: "text", name: "height", placeholder: "สูง" },
            domProps: { value: _vm.height },
            on: {
              input: [
                function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.height = $event.target.value
                },
                _vm.onlyNumeric
              ]
            }
          })
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" วันที่เริ่มต้น ")]),
          _vm._v(" "),
          _c("el-date-picker", {
            staticStyle: { width: "100%" },
            attrs: {
              type: "date",
              placeholder: "วันที่เริ่มต้น",
              name: "start_date",
              format: "dd/MM/yyyy",
              "value-format": "dd/MM/yyyy"
            },
            model: {
              value: _vm.start_date_format,
              callback: function($$v) {
                _vm.start_date_format = $$v
              },
              expression: "start_date_format"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" วันที่สิ้นสุด ")]),
          _vm._v(" "),
          _c("el-date-picker", {
            staticStyle: { width: "100%" },
            attrs: {
              type: "date",
              placeholder: "วันที่สิ้นสุด",
              name: "end_date",
              format: "dd/MM/yyyy",
              "value-format": "dd/MM/yyyy"
            },
            model: {
              value: _vm.end_date_format,
              callback: function($$v) {
                _vm.end_date_format = $$v
              },
              expression: "end_date_format"
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
        _c("label", [_vm._v(" Active")]),
        _c("br"),
        _vm._v(" "),
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
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" รหัสสินค้า "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" UOM "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        { staticClass: "input-group-addon", staticStyle: { border: "0px" } },
        [_vm._v("X")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-prepend" }, [
      _c(
        "span",
        { staticClass: "input-group-addon", staticStyle: { border: "0px" } },
        [_vm._v("X")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);