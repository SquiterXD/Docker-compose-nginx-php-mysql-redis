(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_TransportOwnerComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportOwnerComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportOwnerComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  props: ["po-vendors", "url", "url-return", "url-update", "default-value", "vendor-selected"],
  data: function data() {
    return {
      start_date: this.defaultValue ? this.defaultValue.start_date : "",
      end_date: this.defaultValue ? this.defaultValue.end_date : "",
      stop_flag: this.defaultValue ? this.defaultValue.stop_flag == 'N' ? false : true : false,
      // enable_flag: true,
      vendor_id: this.defaultValue ? Number(this.defaultValue.vendor_id) : "",
      transport_owner_code: this.defaultValue ? this.defaultValue.transport_owner_code : "",
      transport_owner_name: this.defaultValue ? this.defaultValue.transport_owner_name : "",
      VendorList: [],
      // สำหรับ เช็ค วันที่
      disabledDateTo: this.start_date ? this.start_date : null,
      api_url: this.defaultValue ? this.defaultValue.api_url : "",
      api_token: this.defaultValue ? this.defaultValue.api_token : "",
      api_user: this.defaultValue ? this.defaultValue.api_user : ""
    };
  },
  mounted: function mounted() {
    this.getVendorList(); // if (this.defaultValue) {
    //         this.start_date     = this.defaultValue.format_date_start;
    //         this.end_date       = this.defaultValue.format_date_end;
    //         // this.stop_flag = this.defaultValue.stop_flag,
    //         this.stop_flag      = this.defaultValue.stop_flag == 'N'
    //                             ? false
    //                             : true;
    //         // this.enable_flag =  this.defaultValue.stop_flag == 'Y'
    //         //                     ? false
    //         //                     : true;
    //         this.vendor_id = this.defaultValue
    //                             ? Number(this.defaultValue.vendor_id)
    //                             : "";
    //         this.transport_owner_code = this.defaultValue.transport_owner_code;
    //         this.transport_owner_name = this.defaultValue.transport_owner_name;
    // }

    this.showDate();
  },
  methods: {
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
    getVendorList: function getVendorList(query) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vender;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                console.log('query --> ' + query); // this.vendor_id = '';

                vender = _this2.defaultValue ? _this2.defaultValue.vendor_id : "";
                console.log(vender);
                _context2.next = 5;
                return axios.get("/om/ajax/vendor", {
                  params: {
                    query: query,
                    vender: vender
                  }
                }).then(function (res) {
                  _this2.VendorList = res.data;
                })["catch"](function (err) {
                  console.log(err);
                }).then(function () {
                  _this2.loading = false;
                });

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    save: function save() {
      var _this3 = this;

      console.log('xxxxxxx');
      this.loading = true;
      axios.post(this.url, {
        start_date: this.start_date,
        end_date: this.end_date,
        stop_flag: this.stop_flag,
        vendor_id: this.vendor_id,
        transport_owner_code: this.transport_owner_code,
        transport_owner_name: this.transport_owner_name
      }).then(function (res) {
        alert('complete');
      }).then(function (res) {
        window.location.href = _this3.urlReturn;
      })["catch"](function (error) {
        alert(error);
      });
    },
    update: function update() {
      var _this4 = this;

      console.log('update');
      this.loading = true;
      axios.put(this.urlUpdate, {
        start_date: this.start_date,
        end_date: this.end_date,
        stop_flag: this.stop_flag,
        vendor_id: this.vendor_id,
        transport_owner_code: this.transport_owner_code,
        transport_owner_name: this.transport_owner_name
      }).then(function (res) {
        alert('complete');
      }).then(function (res) {
        window.location.href = _this4.urlReturn;
      })["catch"](function (error) {
        alert(error);
      });
    },
    enableFlag: function enableFlag(result) {
      this.enable_flag = false;
      this.stop_flag = false;

      if (result == 'N') {
        this.enable_flag = false;
        this.stop_flag = true;
      }

      if (result == 'Y') {
        this.enable_flag = true;
        this.stop_flag = false;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/TransportOwnerComponent.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/om/TransportOwnerComponent.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TransportOwnerComponent_vue_vue_type_template_id_b8220966___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TransportOwnerComponent.vue?vue&type=template&id=b8220966& */ "./resources/js/components/om/TransportOwnerComponent.vue?vue&type=template&id=b8220966&");
/* harmony import */ var _TransportOwnerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TransportOwnerComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/TransportOwnerComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TransportOwnerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TransportOwnerComponent_vue_vue_type_template_id_b8220966___WEBPACK_IMPORTED_MODULE_0__.render,
  _TransportOwnerComponent_vue_vue_type_template_id_b8220966___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/TransportOwnerComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/TransportOwnerComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/om/TransportOwnerComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportOwnerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TransportOwnerComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportOwnerComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportOwnerComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/TransportOwnerComponent.vue?vue&type=template&id=b8220966&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/om/TransportOwnerComponent.vue?vue&type=template&id=b8220966& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportOwnerComponent_vue_vue_type_template_id_b8220966___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportOwnerComponent_vue_vue_type_template_id_b8220966___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportOwnerComponent_vue_vue_type_template_id_b8220966___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TransportOwnerComponent.vue?vue&type=template&id=b8220966& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportOwnerComponent.vue?vue&type=template&id=b8220966&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportOwnerComponent.vue?vue&type=template&id=b8220966&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportOwnerComponent.vue?vue&type=template&id=b8220966& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
          _c("el-input", {
            attrs: { name: "transport_owner_code", size: "medium" },
            model: {
              value: _vm.transport_owner_code,
              callback: function($$v) {
                _vm.transport_owner_code = $$v
              },
              expression: "transport_owner_code"
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
          _vm._m(1),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "transport_owner_name", size: "medium" },
            model: {
              value: _vm.transport_owner_name,
              callback: function($$v) {
                _vm.transport_owner_name = $$v
              },
              expression: "transport_owner_name"
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
          _vm._m(2),
          _vm._v(" "),
          _c("datepicker-th", {
            staticClass: "form-control md:tw-mb-0 tw-mb-2",
            staticStyle: { width: "100%" },
            attrs: {
              size: "medium",
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
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" วันที่สิ้นสุด  ")]),
          _vm._v(" "),
          _c("datepicker-th", {
            staticClass: "form-control md:tw-mb-0 tw-mb-2",
            staticStyle: { width: "100%" },
            attrs: {
              size: "medium",
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
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _vm._m(3),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "vendor_id", autocomplete: "off" },
            domProps: { value: _vm.vendor_id }
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
                "remote-method": _vm.getVendorList,
                size: "medium"
              },
              model: {
                value: _vm.vendor_id,
                callback: function($$v) {
                  _vm.vendor_id = $$v
                },
                expression: "vendor_id"
              }
            },
            _vm._l(_vm.VendorList, function(poVendor) {
              return _c("el-option", {
                key: poVendor.vendor_id,
                attrs: {
                  label: poVendor.vendor_code + " - " + poVendor.vendor_name,
                  value: poVendor.vendor_id
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
          _vm._m(4),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "api_url", size: "medium" },
            model: {
              value: _vm.api_url,
              callback: function($$v) {
                _vm.api_url = $$v
              },
              expression: "api_url"
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
          _vm._m(5),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "api_token", size: "medium" },
            model: {
              value: _vm.api_token,
              callback: function($$v) {
                _vm.api_token = $$v
              },
              expression: "api_token"
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
          _vm._m(6),
          _vm._v(" "),
          _c("el-input", {
            attrs: { name: "api_user", size: "medium" },
            model: {
              value: _vm.api_user,
              callback: function($$v) {
                _vm.api_user = $$v
              },
              expression: "api_user"
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
        _c("label", [_vm._v(" หยุดการใช้งาน ")]),
        _c("br"),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.stop_flag,
              expression: "stop_flag"
            }
          ],
          attrs: { type: "checkbox", name: "stop_flag" },
          domProps: {
            checked: Array.isArray(_vm.stop_flag)
              ? _vm._i(_vm.stop_flag, null) > -1
              : _vm.stop_flag
          },
          on: {
            change: function($event) {
              var $$a = _vm.stop_flag,
                $$el = $event.target,
                $$c = $$el.checked ? true : false
              if (Array.isArray($$a)) {
                var $$v = null,
                  $$i = _vm._i($$a, $$v)
                if ($$el.checked) {
                  $$i < 0 && (_vm.stop_flag = $$a.concat([$$v]))
                } else {
                  $$i > -1 &&
                    (_vm.stop_flag = $$a
                      .slice(0, $$i)
                      .concat($$a.slice($$i + 1)))
                }
              } else {
                _vm.stop_flag = $$c
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
      _vm._v(" เจ้าของรถขนส่ง "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ชื่อเจ้าของรถขนส่ง "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" วันที่เริ่มต้น "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" รหัสเจ้าหนี้ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" API URL "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" API TOKEN "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" API USER "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);