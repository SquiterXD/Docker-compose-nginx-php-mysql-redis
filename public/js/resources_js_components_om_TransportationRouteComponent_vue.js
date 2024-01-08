(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_TransportationRouteComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportationRouteComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportationRouteComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["days", "customers", "url", "url-return", "url-update", "defaultValue" // "vendor-selected"
  ],
  data: function data() {
    return {
      transport_number: this.defaultValue ? this.defaultValue.transport_number : "",
      customer_id: this.defaultValue ? Number(this.defaultValue.customer_id) : "",
      transport_day: this.defaultValue ? this.defaultValue.transport_day : "",
      time_of_day: this.defaultValue ? this.defaultValue.time_of_day : "",
      standard_transport_day: this.defaultValue ? this.defaultValue.standard_transport_day : "",
      standard_transport_time: this.defaultValue ? this.defaultValue.standard_transport_time : "",
      customer_name: "",
      city: "",
      province_name: "",
      start_date: this.defaultValue ? this.defaultValue.start_date : "",
      end_date: this.defaultValue ? this.defaultValue.end_date : "",
      times: [{
        value: 'เช้า',
        label: 'เช้า'
      }, {
        value: 'บ่าย',
        label: 'บ่าย'
      }],
      disableData: this.defaultValue ? this.defaultValue.customer_id ? true : false : false,
      // สำหรับ เช็ค วันที่
      disabledDateTo: this.start_date ? this.start_date : null
    };
  },
  mounted: function mounted() {
    // if (!this.old.start_date || !this.old.end_date) {
    this.showDate(); // }

    if (this.customer_id) {
      this.checkCustomer();
    }

    if (this.standard_transport_time) {
      var today = new Date();
      this.setDate = moment__WEBPACK_IMPORTED_MODULE_1___default()(today).format('yyyy-MM-DD');
      this.standard_transport_time = this.setDate + ' ' + this.standard_transport_time;
    }
  },
  methods: {
    // checkCustomer() {
    //     this.ship_to_site_id = '';
    //     this.loading         = true;
    //     if (this.customer_id) {
    //         // om/ajax/ship-to-site 
    //         axios.get("/om/ajax/ship-to-site", {
    //             params: {
    //                 customer_id: this.customer_id,
    //             }
    //         })
    //         .then(res => {
    //             this.customerShipToSites = res.data;
    //             // console.log(this.customerShipToSites);
    //             this.loading = false;
    //         })
    //         .catch(err => {
    //             console.log(err)
    //         });
    //     } 
    // },
    checkCustomer: function checkCustomer() {
      var _this = this;

      this.customer_name = '';
      this.city = '';
      this.province_name = '';
      this.transport_day = '';
      this.selectedData = this.customers.find(function (i) {
        return i.customer_id == _this.customer_id;
      });
      this.customer_name = this.selectedData.customer_name;
      this.city = this.selectedData.city;
      this.province_name = this.selectedData.province_name;
      this.transport_day = this.selectedData.delivery_date;
    },
    onlyNumeric: function onlyNumeric() {
      this.transport_number = this.transport_number.replace(/[^0-9 .]/g, '');
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
    } // save() {
    //     console.log('xxxxxxx');
    //     this.loading = true;
    //     axios
    //         .post(this.url, {
    //             transport_number        : this.transport_number,
    //             customer_id             : this.customer_id,
    //             ship_to_site_id         : this.ship_to_site_id,
    //             transport_day           : this.transport_day,
    //             time_of_day             : this.time_of_day,
    //             standard_transport_day  : this.standard_transport_day,
    //             standard_transport_time : this.standard_transport_time,
    //             start_date              : this.start_date,
    //             end_date                : this.end_date,
    //         })
    //         .then(res => {
    //             alert('complete');
    //         })
    //         // .then(res => {
    //         //     window.location.href = this.urlReturn;
    //         // })
    //         // .catch(error => {
    //         //     alert(error);
    //         // });
    // },
    // update() {
    //     console.log('update');
    //     this.loading = true;
    //     axios
    //         .put(this.urlUpdate, {
    //             start_date : this.start_date,
    //             end_date : this.end_date,
    //             stop_flag : this.stop_flag,
    //             vendor_id : this.vendor_id,
    //             transport_owner_code : this.transport_owner_code,
    //             transport_owner_name : this.transport_owner_name,
    //         })
    //         .then(res => {
    //             alert('complete');
    //         })
    //         .then(res => {
    //             window.location.href = this.urlReturn;
    //         })
    //         .catch(error => {
    //             alert(error);
    //         });
    // },
    // enableFlag(result){
    //     this.enable_flag = false;
    //     this.stop_flag = false;
    //     if (result == 'N') {
    //         this.enable_flag = false;
    //         this.stop_flag = true;
    //     }
    //     if (result == 'Y') {
    //         this.enable_flag = true;
    //         this.stop_flag = false;
    //     }
    // },

  }
});

/***/ }),

/***/ "./resources/js/components/om/TransportationRouteComponent.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/om/TransportationRouteComponent.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TransportationRouteComponent_vue_vue_type_template_id_4c84cc14___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TransportationRouteComponent.vue?vue&type=template&id=4c84cc14& */ "./resources/js/components/om/TransportationRouteComponent.vue?vue&type=template&id=4c84cc14&");
/* harmony import */ var _TransportationRouteComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TransportationRouteComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/TransportationRouteComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TransportationRouteComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TransportationRouteComponent_vue_vue_type_template_id_4c84cc14___WEBPACK_IMPORTED_MODULE_0__.render,
  _TransportationRouteComponent_vue_vue_type_template_id_4c84cc14___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/TransportationRouteComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/TransportationRouteComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/om/TransportationRouteComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportationRouteComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TransportationRouteComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportationRouteComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportationRouteComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/TransportationRouteComponent.vue?vue&type=template&id=4c84cc14&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/om/TransportationRouteComponent.vue?vue&type=template&id=4c84cc14& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportationRouteComponent_vue_vue_type_template_id_4c84cc14___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportationRouteComponent_vue_vue_type_template_id_4c84cc14___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TransportationRouteComponent_vue_vue_type_template_id_4c84cc14___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TransportationRouteComponent.vue?vue&type=template&id=4c84cc14& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportationRouteComponent.vue?vue&type=template&id=4c84cc14&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportationRouteComponent.vue?vue&type=template&id=4c84cc14&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/TransportationRouteComponent.vue?vue&type=template&id=4c84cc14& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
                clearable: "",
                disabled: this.disableData
              },
              on: {
                change: function($event) {
                  return _vm.checkCustomer()
                }
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
          _c("label", [_vm._v(" ชื่อร้านค้า ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: "" },
            model: {
              value: _vm.customer_name,
              callback: function($$v) {
                _vm.customer_name = $$v
              },
              expression: "customer_name"
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
          _c("label", [_vm._v(" อำเภอ/เขต ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: "" },
            model: {
              value: _vm.city,
              callback: function($$v) {
                _vm.city = $$v
              },
              expression: "city"
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
          _c("label", [_vm._v(" จังหวัด ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: "" },
            model: {
              value: _vm.province_name,
              callback: function($$v) {
                _vm.province_name = $$v
              },
              expression: "province_name"
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
          _c("label", [_vm._v(" วันที่ขนส่ง ")]),
          _vm._v(" "),
          _c("el-input", {
            attrs: { disabled: "" },
            model: {
              value: _vm.transport_day,
              callback: function($$v) {
                _vm.transport_day = $$v
              },
              expression: "transport_day"
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
          _c("input", {
            attrs: { type: "hidden", name: "time_of_day", autocomplete: "off" },
            domProps: { value: _vm.time_of_day }
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
                value: _vm.time_of_day,
                callback: function($$v) {
                  _vm.time_of_day = $$v
                },
                expression: "time_of_day"
              }
            },
            _vm._l(_vm.times, function(time) {
              return _c("el-option", {
                key: time.value,
                attrs: { label: time.label, value: time.value }
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
      _c("div", { staticClass: "col-md-1" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" วันมาตราฐานการส่งมอบ ")]),
          _vm._v(" "),
          _c("input", {
            attrs: {
              type: "hidden",
              name: "standard_transport_day",
              autocomplete: "off"
            },
            domProps: { value: _vm.standard_transport_day }
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
                value: _vm.standard_transport_day,
                callback: function($$v) {
                  _vm.standard_transport_day = $$v
                },
                expression: "standard_transport_day"
              }
            },
            _vm._l(_vm.days, function(day) {
              return _c("el-option", {
                key: day.meaning,
                attrs: { label: day.meaning, value: day.meaning }
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
          _c("label", [_vm._v(" เวลามาตราฐานการส่งมอบ ")]),
          _vm._v(" "),
          _c("el-time-picker", {
            staticStyle: { width: "100%" },
            attrs: {
              placeholder: "เวลามาตราฐานการส่งมอบ",
              name: "standard_transport_time",
              format: "H:mm"
            },
            model: {
              value: _vm.standard_transport_time,
              callback: function($$v) {
                _vm.standard_transport_time = $$v
              },
              expression: "standard_transport_time"
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
        { staticClass: "col-md-5" },
        [
          _c("label", [_vm._v(" วันที่สิ้นสุด  ")]),
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
      _vm._v(" รหัสร้านค้า "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ช่วงเวลามาตราฐานการส่งมอบ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);