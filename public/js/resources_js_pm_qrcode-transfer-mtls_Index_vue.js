(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_qrcode-transfer-mtls_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["data", 'oldIput', 'trans_date', "pRequest", "url", "trans_btn", "profile", "title"],
  computed: {
    secondaryUomList: function secondaryUomList() {}
  },
  watch: {
    step: function step(newValue, oldValue) {
      if (oldValue == 2 && newValue == 1) {
        this.input.machine_set = '';
      }

      if (oldValue == 4 && newValue == 3) {
        this.input.item = '';
        this.input.machine_set = '';
      }

      if (oldValue == 5 && newValue == 4) {
        this.input.assignee = '';
        this.input.tranfer_qty = '';
      }

      if (oldValue == 5 && newValue == 2) {
        this.input.item = '';
        this.input.machine_set = '';
        this.input.assignee = '';
        this.input.tranfer_qty = '';
      }

      if (oldValue == 7 && newValue == 1) {
        this.input.item = '';
        this.input.machine_set = '';
        this.input.assignee = '';
        this.input.tranfer_qty = '';
      }
    }
  },
  data: function data() {
    return {
      header: this.pHeader,
      user: this.profile,
      loading: false,
      itemDetail: false,
      items: [],
      deleteItem: '',
      input: {
        transfer_date: '',
        item: '',
        machine_set: '',
        assignee: '',
        tranfer_qty: ''
      },
      validate: {
        transfer_date: {
          msg: false
        },
        item: {
          msg: false
        },
        machine_set: {
          msg: false
        },
        assignee: {
          msg: false
        },
        tranfer_qty: {
          msg: false
        }
      },
      step: 1,
      newSession: false,
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
        },
        4: {
          html: '',
          can_next_step: false
        },
        5: {
          html: '',
          can_next_step: false
        },
        6: {
          html: '',
          can_next_step: false
        },
        7: {
          html: '',
          can_next_step: false
        },
        8: {
          html: '',
          can_next_step: false
        }
      }
    };
  },
  mounted: function mounted() {
    this.scanQr(1);
  },
  methods: {
    summary: function summary() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.step = 5;

                _this.scanQr();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    scanAssignee: function scanAssignee() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.step = 6;

                _this2.scanQr();

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    store: function store() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.step = 7;

                _this3.scanQr();

              case 2:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    deleteItemFunc: function deleteItemFunc(inventoryItemId) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.step = 8;
                _this4.deleteItem = inventoryItemId;

                _this4.scanQr();

              case 3:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    setdate: function setdate(date, key) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this5;
                _context5.next = 3;
                return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format(vm.trans_date['js-format']);

              case 3:
                vm.input[key] = _context5.sent;

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    validateInput: function validateInput(input) {
      var vm = this;

      switch (input) {
        case 'transfer_date':
          vm.validate.transfer_date.msg = false;

          if (vm.input.transfer_date == '' || vm.input.transfer_date == 'Invalid date') {
            vm.validate.transfer_date.msg = 'กรุณาระบุ วันที่ทำรายการ';
          }

          break;

        case 'item':
          vm.validate.item.msg = false;

          if (vm.input.item == '') {
            vm.validate.item.msg = 'กรุณาระบุ รหัสวัตถุดิบ';
          }

          break;

        case 'machine_set':
          vm.validate.machine_set.msg = false;

          if (vm.input.machine_set == '') {
            vm.validate.machine_set.msg = 'กรุณาระบุ เครื่องจักร';
          }

          break;

        case 'assignee':
          vm.validate.assignee.msg = false;

          if (vm.input.assignee == '') {
            vm.validate.assignee.msg = 'กรุณาระบุ QR Code ผู้รับโอน';
          }

          break;

        case 'tranfer_qty':
          vm.validate.tranfer_qty.msg = false;

          if (vm.input.tranfer_qty == '') {
            vm.validate.tranfer_qty.msg = 'กรุณาระบุ จำนวนที่รับโอน';
          }

          break;

        default:
      }
    },
    resetData: function resetData() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _this6.newSession = true;
                _this6.step = 1;

                _this6.scanQr();

              case 3:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    scanQr: function scanQr() {
      var _arguments = arguments,
          _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var firstLoad, vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                firstLoad = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 0;
                vm = _this7;
                vm.loading = true;
                _context7.next = 5;
                return axios.get(vm.url.ajax_detail, {
                  params: {
                    new_session: vm.newSession,
                    transfer_date: vm.input.transfer_date,
                    step: vm.step,
                    is_first_load: firstLoad,
                    item: vm.input.item,
                    machine_set: vm.input.machine_set,
                    assignee: vm.input.assignee,
                    tranfer_qty: vm.input.tranfer_qty,
                    delete_item_id: vm.deleteItem
                  }
                }).then(function (res) {
                  var data = res.data.data;

                  if (data.status == 'S') {
                    if (vm.step == 1) {
                      if (data.machine) {
                        vm.step = 3;
                      } else if (data.transfer_date) {
                        vm.step = 2;
                      }
                    } else if (vm.step == 2) {
                      if (data.machine) {
                        vm.step = 3;
                      } else if (data.transfer_date) {
                        vm.step = 2;
                      }
                    } else if (vm.step == 3) {
                      if (data.can_next_step) {
                        vm.step = 4;
                        vm.input.tranfer_qty = data.item_detail.plan_quantity;
                      } else {
                        vm.input.item = '';
                      }
                    } else if (vm.step == 4) {
                      vm.step = 3;
                      vm.input.tranfer_qty = '';
                    } else if (vm.step == 5) {} else if (vm.step == 6) {} else if (vm.step == 7) {
                      swal({
                        title: '<br>รับโอนวัตถุดิบสำเร็จ',
                        type: "success",
                        html: true
                      });
                      vm.newSession = true;
                    } else if (vm.step == 8) {
                      swal({
                        title: '<br>ลบ Item สำเร็จ',
                        type: "success",
                        html: true
                      });
                      vm.summary();
                    }

                    if (vm.newSession) {
                      vm.newSession = false;
                      vm.step = 1;
                    }

                    vm.process[vm.step]['can_next_step'] = data.can_next_step;
                    vm.process[vm.step]['html'] = data.html;
                    vm.itemDetail = data.item_detail;
                    vm.items = data.items;

                    if (!vm.input.transfer_date && data.def_transfer_date && vm.step == 1) {
                      vm.input.transfer_date = data.def_transfer_date;
                    }
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

              case 5:
                return _context7.abrupt("return");

              case 6:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/pm/qrcode-transfer-mtls/Index.vue":
/*!********************************************************!*\
  !*** ./resources/js/pm/qrcode-transfer-mtls/Index.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_72091410___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=72091410& */ "./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=template&id=72091410&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_72091410___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_72091410___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/qrcode-transfer-mtls/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=template&id=72091410&":
/*!***************************************************************************************!*\
  !*** ./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=template&id=72091410& ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_72091410___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_72091410___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_72091410___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=72091410& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=template&id=72091410&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=template&id=72091410&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/qrcode-transfer-mtls/Index.vue?vue&type=template&id=72091410& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
              _c(
                "h1",
                {
                  staticClass: "font-bold p-3 text-center",
                  attrs: { title: _vm.step }
                },
                [_vm._v(" " + _vm._s(_vm.title) + " ")]
              ),
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
                          return _vm.scanQr()
                        }
                      }
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass: "form-group  row",
                          on: {
                            mouseleave: function($event) {
                              return _vm.validateInput("transfer_date")
                            }
                          }
                        },
                        [
                          _vm._m(0),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-sm-8" },
                            [
                              _c("datepicker-th", {
                                staticClass: "form-control md:tw-mb-0 tw-mb-2",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  name: "input_date",
                                  id: "input_date",
                                  placeholder: "โปรดเลือกวันที่",
                                  value: _vm.input.transfer_date,
                                  format: _vm.trans_date["js-format"]
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
                        ]
                      ),
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
                                return _vm.scanQr()
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
                          return _vm.scanQr()
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
                                  value: _vm.input.machine_set,
                                  expression: "input.machine_set"
                                }
                              ],
                              staticClass: "form-control",
                              attrs: {
                                placeholder: "สแกน QR Code เครื่องจักร",
                                type: "text"
                              },
                              domProps: { value: _vm.input.machine_set },
                              on: {
                                blur: function($event) {
                                  return _vm.validateInput("machine_set")
                                },
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.input,
                                    "machine_set",
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
                                _vm.validate.machine_set.msg
                                  ? _c(
                                      "div",
                                      { staticClass: "error_msg text-left" },
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.validate.machine_set.msg
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
                                return _vm.resetData()
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
                          return _vm.scanQr()
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
                                  value: _vm.input.item,
                                  expression: "input.item"
                                }
                              ],
                              staticClass: "form-control",
                              attrs: {
                                placeholder: "สแกน QR Code วัตถุดิบ",
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
                            attrs: {
                              type: "button",
                              disabled: _vm.items.length == 0
                            },
                            on: { click: _vm.summary }
                          },
                          [
                            _c("i", { staticClass: "fa fa-qrcode" }),
                            _vm._v(
                              "\n                                สรุปรายการโอน\n                            "
                            )
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-warning btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.step = 2
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
              _vm.step == 4
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
                          return _vm.scanQr()
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
                      _vm.process[_vm.step]["can_next_step"]
                        ? _c(
                            "div",
                            {
                              staticClass: "form-group row text-left mt-2 mb-2"
                            },
                            [
                              _vm._m(1),
                              _vm._v(" "),
                              _vm.itemDetail
                                ? _c("div", { staticClass: "col-9" }, [
                                    _c(
                                      "h4",
                                      { staticClass: "text-muted no-margins" },
                                      [
                                        _vm._v(
                                          _vm._s(_vm.itemDetail.item_number) +
                                            ": " +
                                            _vm._s(_vm.itemDetail.description)
                                        )
                                      ]
                                    )
                                  ])
                                : _vm._e()
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.process[_vm.step]["can_next_step"]
                        ? _c("div", { staticClass: "form-group mb-0 row" }, [
                            _vm._m(2),
                            _vm._v(" "),
                            _c("div", { staticClass: "col-lg-9" }, [
                              _c(
                                "h4",
                                { staticClass: "font-bold no-margins pt-2" },
                                [
                                  _vm._v(
                                    "\n                                    - " +
                                      _vm._s(_vm.itemDetail.unit_of_measure) +
                                      "\n                                "
                                  )
                                ]
                              )
                            ])
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.process[_vm.step]["can_next_step"]
                        ? _c("div", { staticClass: "form-group  row" }, [
                            _vm._m(3),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "col-lg-9" },
                              [
                                _c("div", { staticClass: "input-group m-b" }, [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.input.tranfer_qty,
                                        expression: "input.tranfer_qty"
                                      }
                                    ],
                                    staticClass: "form-control text-right",
                                    attrs: {
                                      placeholder: "จำนวนที่รับโอน",
                                      step: "any",
                                      type: "number"
                                    },
                                    domProps: { value: _vm.input.tranfer_qty },
                                    on: {
                                      blur: function($event) {
                                        return _vm.validateInput("tranfer_qty")
                                      },
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          _vm.input,
                                          "tranfer_qty",
                                          $event.target.value
                                        )
                                      }
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "input-group-append" },
                                    [
                                      _c(
                                        "span",
                                        { staticClass: "input-group-addon" },
                                        [
                                          _vm.itemDetail
                                            ? _c("span", [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(
                                                      _vm.itemDetail
                                                        .unit_of_measure
                                                    ) +
                                                    "\n                                            "
                                                )
                                              ])
                                            : _c("span", [_vm._v("-")])
                                        ]
                                      )
                                    ]
                                  )
                                ]),
                                _vm._v(" "),
                                _c(
                                  "transition",
                                  {
                                    attrs: {
                                      "enter-active-class": "animated fadeInUp",
                                      "leave-active-class":
                                        "animated fadeOutDown"
                                    }
                                  },
                                  [
                                    _vm.validate.tranfer_qty.msg
                                      ? _c(
                                          "div",
                                          {
                                            staticClass: "error_msg text-left"
                                          },
                                          [
                                            _vm._v(
                                              "\n                                        " +
                                                _vm._s(
                                                  _vm.validate.tranfer_qty.msg
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
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-success btn-lg btn-block",
                            attrs: {
                              type: "button",
                              disabled: _vm.items.length == 0
                            },
                            on: { click: _vm.summary }
                          },
                          [
                            _c("i", { staticClass: "fa fa-qrcode" }),
                            _vm._v(
                              "\n                                สรุปรายการโอน\n                            "
                            )
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-warning btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.step = 3
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
              _vm.step == 5
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
                          return _vm.scanQr()
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
                      _c(
                        "table",
                        {
                          staticClass: "table table-bordered",
                          staticStyle: { "font-size": "13px" }
                        },
                        [
                          _vm._m(4),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            [
                              _vm._l(_vm.items, function(item) {
                                return Object.keys(_vm.items).length
                                  ? [
                                      _c("tr", [
                                        _c("td", [
                                          _c("div", [
                                            _c(
                                              "span",
                                              { staticClass: "text-muted" },
                                              [_vm._v("วัตถุดิบ: ")]
                                            ),
                                            _vm._v(
                                              " " +
                                                _vm._s(item.item_number) +
                                                "\n                                            "
                                            )
                                          ]),
                                          _vm._v(" "),
                                          _c("div", [
                                            _c(
                                              "span",
                                              { staticClass: "text-muted" },
                                              [_vm._v("รายละเอียด: ")]
                                            ),
                                            _vm._v(
                                              " " +
                                                _vm._s(item.description) +
                                                "\n                                            "
                                            )
                                          ])
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          { staticClass: "text-right" },
                                          [
                                            _vm._v(
                                              "\n                                            " +
                                                _vm._s(item.tranfer_qty)
                                            ),
                                            _c("br"),
                                            _vm._v(
                                              "\n                                            " +
                                                _vm._s(item.unit_of_measure) +
                                                "\n                                        "
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c("td", [
                                          _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-default btn-sm",
                                              staticStyle: { color: "red" }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-trash",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.deleteItemFunc(
                                                      item.inventory_item_id
                                                    )
                                                  }
                                                }
                                              })
                                            ]
                                          )
                                        ])
                                      ])
                                    ]
                                  : [_vm._m(5)]
                              })
                            ],
                            2
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-success btn-lg btn-block",
                            attrs: {
                              disabled: !Object.keys(_vm.items).length,
                              type: "button"
                            },
                            on: { click: _vm.scanAssignee }
                          },
                          [
                            _c("i", { staticClass: "fa fa-check" }),
                            _vm._v(" ยืนยัน\n                            ")
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-warning btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.step = 3
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
              _vm.step == 6 || _vm.step == 7
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
                          return _vm.store($event)
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
                      _vm.process[_vm.step]["can_next_step"]
                        ? _c("div", { staticClass: "form-group  row" }, [
                            _c(
                              "div",
                              { staticClass: "col-sm-12" },
                              [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.input.assignee,
                                      expression: "input.assignee"
                                    }
                                  ],
                                  staticClass: "form-control",
                                  attrs: {
                                    placeholder: "สแกน QR Code ผู้รับโอน",
                                    type: "text"
                                  },
                                  domProps: { value: _vm.input.assignee },
                                  on: {
                                    blur: function($event) {
                                      return _vm.validateInput("assignee")
                                    },
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.input,
                                        "assignee",
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
                                      "leave-active-class":
                                        "animated fadeOutDown"
                                    }
                                  },
                                  [
                                    _vm.validate.assignee.msg
                                      ? _c(
                                          "div",
                                          {
                                            staticClass: "error_msg text-left"
                                          },
                                          [
                                            _vm._v(
                                              "\n                                        " +
                                                _vm._s(
                                                  _vm.validate.assignee.msg
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
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            staticClass: "btn btn-warning btn-lg btn-block",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.step = 5
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
    return _c("div", { staticClass: "col-4 text-right col-form-label" }, [
      _c("h3", { staticClass: "font-bold no-margins" }, [
        _vm._v("วันที่ทำรายการ:")
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-lg-3 text-right" }, [
      _c("h4", { staticClass: "font-bold no-margins pt-2" }, [
        _vm._v("จำนวนสูงสุดที่สามารถรับโอน:")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-lg-3 text-right" }, [
      _c("h4", { staticClass: "font-bold no-margins pt-2" }, [
        _vm._v("จำนวนที่รับโอน:")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("วัตถุดิบ ")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-right", attrs: { width: "15%" } }, [
          _vm._v(" จำนวน ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "3%" } }, [
          _c("i", { staticClass: "fa fa-cog" })
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "4" } }, [
        _c("h4", { attrs: { align: "center" } }, [_vm._v(" NO DATA FOUND ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);