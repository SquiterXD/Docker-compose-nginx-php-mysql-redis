(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_qrcode-check-mtls_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  // components: {
  //     SearchItem
  // },
  props: ["data", 'oldIput', 'transDate', "pRequest", "url", "transBtn", "profile"],
  computed: {
    secondaryUomList: function secondaryUomList() {}
  },
  watch: {
    step: function step(newValue, oldValue) {
      if (oldValue == 2 && newValue == 1) {
        this.input.item = '';
        this.input.compare_item = '';
      }

      if (oldValue == 3 && newValue == 2) {
        this.input.compare_item = '';
      }

      if (oldValue == 3 && newValue == 1) {
        this.input.item = '';
        this.input.compare_item = '';
      }
    }
  },
  data: function data() {
    return {
      header: this.pHeader,
      user: this.profile,
      loading: false,
      input: {
        item: '',
        compare_item: '',
        transfer_date: ''
      },
      validate: {
        item: {
          msg: false
        },
        compare_item: {
          msg: false
        },
        transfer_date: {
          msg: false
        }
      },
      step: 1,
      process: {
        1: {
          html: '',
          can_next_step: false
        },
        2: {
          html: '',
          can_next_step: false
        },
        3: {
          html: '',
          can_next_step: false
        }
      }
    };
  },
  mounted: function mounted() {},
  methods: {
    setdate: function setdate(date, key) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                _context.next = 3;
                return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format(vm.transDate['js-format']);

              case 3:
                vm.input[key] = _context.sent;

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    validateInput: function validateInput(input) {
      var vm = this;

      switch (input) {
        case 'transfer_date':
          vm.validate.transfer_date.msg = false;

          if (vm.input.transfer_date == '' || vm.input.transfer_date == 'Invalid date') {
            vm.validate.transfer_date.msg = 'กรุณาระบุ วันที่';
          }

          break;

        case 'item':
          vm.validate.item.msg = false;

          if (vm.input.item == '') {
            vm.validate.item.msg = 'กรุณาระบุ รหัสวัตถุดิบ';
          }

          break;

        case 'compare_item':
          vm.validate.compare_item.msg = false;

          if (vm.input.compare_item == '') {
            vm.validate.compare_item.msg = 'กรุณาระบุ รหัสวัตถุดิบบนชั้นวางของ';
          }

          break;

        default:
      }
    },
    scanMaterial: function scanMaterial() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;

                if (!(vm.step == 1)) {
                  _context2.next = 4;
                  break;
                }

                if (!(!vm.input.transfer_date || !vm.input.item)) {
                  _context2.next = 4;
                  break;
                }

                return _context2.abrupt("return");

              case 4:
                vm.loading = true;
                _context2.next = 7;
                return axios.get(vm.url.ajax_qrcode_check_materials_detail, {
                  params: {
                    item: vm.input.item,
                    transfer_date: vm.input.transfer_date,
                    compare_item: vm.input.compare_item,
                    step: vm.step
                  }
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    if (vm.step == 1) {
                      vm.step = 2;
                    } else if (vm.step == 2) {
                      if (data.can_next_step) {
                        vm.step = 3;
                        vm.scanMaterial();
                      }
                    } else if (vm.step == 3) {
                      swal({
                        title: '<br>ตรวจสอบวัตถุดิบสำเร็จ',
                        type: "success",
                        html: true
                      });
                      vm.step = 1;
                    }

                    vm.process[vm.step]['can_next_step'] = data.can_next_step;
                    vm.process[vm.step]['html'] = data.html;
                  }

                  if (res.data.data.status != 'S') {
                    swal({
                      title: "Error !",
                      text: res.data.data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading = false; // swal.close();
                });

              case 7:
                return _context2.abrupt("return");

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/pm/qrcode-check-mtls/Index.vue":
/*!*****************************************************!*\
  !*** ./resources/js/pm/qrcode-check-mtls/Index.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_34a4cefe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=34a4cefe& */ "./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=template&id=34a4cefe&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_34a4cefe___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_34a4cefe___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/qrcode-check-mtls/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=template&id=34a4cefe&":
/*!************************************************************************************!*\
  !*** ./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=template&id=34a4cefe& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_34a4cefe___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_34a4cefe___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_34a4cefe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=34a4cefe& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=template&id=34a4cefe&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=template&id=34a4cefe&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-check-mtls/Index.vue?vue&type=template&id=34a4cefe& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "ibox float-e-margins" }, [
      _c("div", { staticClass: "ibox-content" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass:
                "form-group mb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12 offset-md-3"
            },
            [
              _c("h1", { staticClass: "font-bold p-3 text-center" }, [
                _vm._v(" ตรวจสอบวัตถุดิบ ")
              ]),
              _vm._v(" "),
              _vm.step == 1
                ? _c(
                    "form",
                    {
                      directives: [
                        {
                          name: "loading",
                          rawName: "v-loading",
                          value: _vm.loading,
                          expression: "loading"
                        }
                      ],
                      on: {
                        submit: function($event) {
                          $event.preventDefault()
                          return _vm.scanMaterial($event)
                        }
                      }
                    },
                    [
                      _c("div", { staticClass: "form-group  row" }, [
                        _vm._m(0),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass: "col-9",
                            on: {
                              mouseleave: function($event) {
                                return _vm.validateInput("transfer_date")
                              }
                            }
                          },
                          [
                            _c("datepicker-th", {
                              staticClass: "form-control md:tw-mb-0 tw-mb-2",
                              staticStyle: { width: "100%" },
                              attrs: {
                                name: "input_date",
                                id: "input_date",
                                placeholder: "โปรดเลือกวันที่",
                                value: _vm.input.transfer_date,
                                format: _vm.transDate["js-format"]
                              },
                              on: {
                                dateWasSelected: function($event) {
                                  var i = arguments.length,
                                    argsArray = Array(i)
                                  while (i--) argsArray[i] = arguments[i]
                                  return _vm.setdate.apply(
                                    void 0,
                                    argsArray.concat(["transfer_date"])
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "transition",
                              {
                                attrs: {
                                  "enter-active-class": "animated fadeInUp",
                                  "leave-active-class": "animated fadeOutDown"
                                }
                              },
                              [
                                _vm.validate.transfer_date.msg
                                  ? _c(
                                      "div",
                                      { staticClass: "error_msg text-left" },
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.validate.transfer_date.msg
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]
                            )
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-group  row" }, [
                        _vm._m(1),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-9" },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.input.item,
                                  expression: "input.item"
                                }
                              ],
                              staticClass: "form-control",
                              attrs: {
                                placeholder: "สแกน QR Code ที่ชั้นวางของ",
                                type: "text"
                              },
                              domProps: { value: _vm.input.item },
                              on: {
                                blur: function($event) {
                                  return _vm.validateInput("item")
                                },
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.input,
                                    "item",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "transition",
                              {
                                attrs: {
                                  "enter-active-class": "animated fadeInUp",
                                  "leave-active-class": "animated fadeOutDown"
                                }
                              },
                              [
                                _vm.validate.item.msg
                                  ? _c(
                                      "div",
                                      { staticClass: "error_msg text-left" },
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(_vm.validate.item.msg) +
                                            "\n                                    "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]
                            )
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-success btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.scanMaterial($event)
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-qrcode" }),
                            _vm._v(
                              "\n                                ตกลง\n                            "
                            )
                          ]
                        )
                      ])
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.step == 2
                ? _c(
                    "form",
                    {
                      directives: [
                        {
                          name: "loading",
                          rawName: "v-loading",
                          value: _vm.loading,
                          expression: "loading"
                        }
                      ],
                      on: {
                        submit: function($event) {
                          $event.preventDefault()
                          return _vm.scanMaterial($event)
                        }
                      }
                    },
                    [
                      _c("div", {
                        domProps: {
                          innerHTML: _vm._s(_vm.process[_vm.step]["html"])
                        }
                      }),
                      _vm._v(" "),
                      _c("div", { staticClass: "hr-line-dashed" }),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-group  row" }, [
                        _c(
                          "div",
                          { staticClass: "col-sm-12" },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.input.compare_item,
                                  expression: "input.compare_item"
                                }
                              ],
                              staticClass: "form-control",
                              attrs: {
                                placeholder: "รหัสวัตถุดิบบนชั้นวางของ",
                                type: "text"
                              },
                              domProps: { value: _vm.input.compare_item },
                              on: {
                                blur: function($event) {
                                  return _vm.validateInput("compare_item")
                                },
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.input,
                                    "compare_item",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "transition",
                              {
                                attrs: {
                                  "enter-active-class": "animated fadeInUp",
                                  "leave-active-class": "animated fadeOutDown"
                                }
                              },
                              [
                                _vm.validate.compare_item.msg
                                  ? _c(
                                      "div",
                                      { staticClass: "error_msg text-left" },
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.validate.compare_item.msg
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]
                            )
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-danger btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.step = 1
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-times" }),
                            _vm._v(" กลับ\n                            ")
                          ]
                        )
                      ])
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.step == 3
                ? _c(
                    "form",
                    {
                      directives: [
                        {
                          name: "loading",
                          rawName: "v-loading",
                          value: _vm.loading,
                          expression: "loading"
                        }
                      ],
                      on: {
                        submit: function($event) {
                          $event.preventDefault()
                          return _vm.scanMaterial($event)
                        }
                      }
                    },
                    [
                      _c("div", {
                        domProps: {
                          innerHTML: _vm._s(_vm.process[_vm.step]["html"])
                        }
                      }),
                      _vm._v(" "),
                      _c("div", { staticClass: "hr-line-dashed" }),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _vm.process[_vm.step]["can_next_step"]
                          ? _c(
                              "button",
                              {
                                staticClass: "btn btn-success btn-lg btn-block",
                                attrs: {
                                  disabled: !_vm.process[_vm.step][
                                    "can_next_step"
                                  ],
                                  type: "button"
                                },
                                on: { click: _vm.scanMaterial }
                              },
                              [
                                _c("i", { staticClass: "fa fa-check" }),
                                _vm._v(
                                  " ยืนยันตรวจสอบวัตถุดิบ\n                            "
                                )
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-danger btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.step = 2
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fa fa-times" }),
                            _vm._v(" ยกเลิก\n                            ")
                          ]
                        )
                      ])
                    ]
                  )
                : _vm._e()
            ]
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
    return _c("div", { staticClass: "col-3 text-right" }, [
      _c("h3", { staticClass: "font-bold no-margins" }, [
        _vm._v("วันที่ในเอกสาร:")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-3 text-right" }, [
      _c("h3", { staticClass: "font-bold no-margins" }, [
        _vm._v("รหัสวัตถุดิบ:")
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);