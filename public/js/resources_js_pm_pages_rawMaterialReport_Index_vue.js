(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_rawMaterialReport_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue2_datepicker__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue2-datepicker */ "./node_modules/vue2-datepicker/index.esm.js");
/* harmony import */ var vue2_datepicker_index_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue2-datepicker/index.css */ "./node_modules/vue2-datepicker/index.css");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_4__);


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



var numeral = __webpack_require__(/*! numeral */ "./node_modules/numeral/numeral.js");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    date_trans: {},
    reset_filter: {},
    getProductLists: {},
    item: {
      type: Object
    },
    auth: {
      type: Object
    },
    btn_trans: {
      type: Object
    },
    url_ajax: {
      type: Object
    },
    machine_relations: {},
    item_cat: {}
  },
  data: function data() {
    return {
      time1: moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, "years").format(),
      time2: moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, "years").format(),
      el: {
        machine_relations: {},
        item_cat: {}
      },
      options: [],
      typeOrder: "",
      items: []
    };
  },
  components: {
    DatePicker: vue2_datepicker__WEBPACK_IMPORTED_MODULE_1__.default
  },
  computed: {
    nowDate: function nowDate() {
      return moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, "years").format(this.date_trans);
    }
  },
  mounted: function mounted() {
    console.log(this.date_trans); // this.getTypeOrder();

    this.initialize();
  },
  methods: {
    getTypeOrder: function getTypeOrder() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_4___default().post(_this.url_ajax.getTypeOrder).then(function (result) {
                  _this.options = result.data;
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    confirmOrder: function confirmOrder(item) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                swal({
                  title: "แจ้งเตือน",
                  text: "ต้องการทำการยืนยันข้อมูลหรือไม่?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonText: "ยืนยัน"
                }, function (e) {
                  // confirm upload
                  if (e) {
                    console.log(item);
                    axios__WEBPACK_IMPORTED_MODULE_4___default().post(_this2.url_ajax.raw_material_report_update_flag, item).then(function (result) {
                      return result.data;
                    }).then(function (result) {
                      console.log(result);
                    })["catch"](function (ex) {});

                    _this2.initialize();
                  }
                });

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    initialize: function initialize() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var filter, url;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                filter = {
                  auth: _this3.auth,
                  machine_relations: _this3.el.machine_relations,
                  item_cat: _this3.el.item_cat,
                  time1: _this3.time1,
                  time2: _this3.time2
                };
                url = _this3.url_ajax.raw_material_report_index;
                _context3.next = 4;
                return axios__WEBPACK_IMPORTED_MODULE_4___default().post(url, filter).then(function (result) {
                  return result.data;
                }).then(function (result) {
                  _this3.items = result.data;
                });

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    resetPopUp: function resetPopUp() {
      this.el = {
        machine_relations: {},
        item_cat: {}
      };
      this.time1 = moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, "years").format();
      this.time2 = moment__WEBPACK_IMPORTED_MODULE_3___default()().add(543, "years").format();
      this.initialize();
    },
    closeModal: function closeModal() {
      $(".bd-search-modal-lg").modal("hide");
    },
    handleFilterBtn: function handleFilterBtn() {
      this.initialize();
    },
    selectDateTime: function selectDateTime($date) {
      this.time1 = moment__WEBPACK_IMPORTED_MODULE_3___default()($date).format();
    },
    selectDateTime2: function selectDateTime2($date) {
      this.time2 = moment__WEBPACK_IMPORTED_MODULE_3___default()($date).format();
    },
    changeQtyCalc: function changeQtyCalc(item) {
      return numeral(Math.ceil(parseFloat(item))).format("0,0");
    }
  }
});

/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialReport/Index.vue":
/*!***********************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialReport/Index.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_91d1e572___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=91d1e572& */ "./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=template&id=91d1e572&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_91d1e572___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_91d1e572___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/rawMaterialReport/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=template&id=91d1e572&":
/*!******************************************************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=template&id=91d1e572& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_91d1e572___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_91d1e572___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_91d1e572___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=91d1e572& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=template&id=91d1e572&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=template&id=91d1e572&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialReport/Index.vue?vue&type=template&id=91d1e572& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "col-lg-12" }, [
        _c("div", { staticClass: "ibox" }, [
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-2" }, [_vm._v("วันที่")]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-3" },
                [
                  _c("datepicker-th", {
                    staticClass: "form-control md:tw-mb-0 tw-mb-2",
                    staticStyle: { width: "100%" },
                    attrs: {
                      value: _vm.nowDate,
                      format: _vm.date_trans,
                      placeholder: "โปรดเลือกวันที่"
                    },
                    on: { dateWasSelected: _vm.selectDateTime }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-3" },
                [
                  _c("datepicker-th", {
                    staticClass: "form-control md:tw-mb-0 tw-mb-2",
                    staticStyle: { width: "100%" },
                    attrs: {
                      value: _vm.nowDate,
                      format: _vm.date_trans,
                      placeholder: "โปรดเลือกวันที่"
                    },
                    on: { dateWasSelected: _vm.selectDateTime2 }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "row",
                staticStyle: { "align-items": "center", "margin-top": "5px" }
              },
              [
                _c("div", { staticClass: "col-md-2" }, [
                  _vm._v("ประเภทวัตถุดิบ")
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-3" },
                  [
                    _c("v-select", {
                      attrs: {
                        options: _vm.item_cat,
                        label: "item_cat_segment2_desc"
                      },
                      model: {
                        value: _vm.el.item_cat,
                        callback: function($$v) {
                          _vm.$set(_vm.el, "item_cat", $$v)
                        },
                        expression: "el.item_cat"
                      }
                    })
                  ],
                  1
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "row",
                staticStyle: {
                  "align-items": "center",
                  "margin-bottom": "15px",
                  "margin-top": "5px"
                }
              },
              [
                _c("div", { staticClass: "col-md-2" }, [
                  _vm._v("หมายเลขเครื่อง")
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-md-3" },
                  [
                    _c("v-select", {
                      attrs: {
                        options: _vm.machine_relations,
                        label: "machine_set",
                        items: _vm.items
                      },
                      model: {
                        value: _vm.el.machine_relations,
                        callback: function($$v) {
                          _vm.$set(_vm.el, "machine_relations", $$v)
                        },
                        expression: "el.machine_relations"
                      }
                    })
                  ],
                  1
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "row",
                staticStyle: {
                  "align-items": "center",
                  "margin-bottom": "15px"
                }
              },
              [
                _c(
                  "button",
                  {
                    class: _vm.btn_trans.create.class,
                    attrs: { type: "button" },
                    on: { click: _vm.handleFilterBtn }
                  },
                  [
                    _c("i", { class: _vm.btn_trans.search.icon }),
                    _vm._v("\n              ค้นหา\n            ")
                  ]
                ),
                _vm._v("\n             \n            "),
                _c(
                  "button",
                  {
                    class: _vm.btn_trans.reset.class,
                    attrs: { type: "button" },
                    on: { click: _vm.resetPopUp }
                  },
                  [
                    _c("i", { class: _vm.btn_trans.reset.icon }),
                    _vm._v(
                      "\n              " +
                        _vm._s(_vm.btn_trans.reset.text) +
                        "\n            "
                    )
                  ]
                )
              ]
            )
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-lg-12" }, [
        _c("div", { staticClass: "ibox" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "ibox-content table-responsive" }, [
            _c("table", { staticClass: "table table-bordered" }, [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.items, function(item) {
                  return _c(
                    "tr",
                    {
                      key: item.ptpm_raw_mtl_id,
                      class: item.flag == 0 ? "tw-bg-red-50" : "tw-bg-green-50"
                    },
                    [
                      _c("td", { staticClass: "col-readonly" }, [
                        _vm._v(
                          "\n                  " +
                            _vm._s(item.item_cat) +
                            "\n                  "
                        ),
                        item.flag == 0
                          ? _c(
                              "a",
                              {
                                attrs: { href: "#" },
                                on: {
                                  click: function($event) {
                                    return _vm.confirmOrder(item)
                                  }
                                }
                              },
                              [_c("small", [_vm._v("ยืนยัน")])]
                            )
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "col-readonly",
                          attrs: { align: "center" }
                        },
                        [
                          _vm._v(
                            "\n                  " +
                              _vm._s(item.machine_set) +
                              "\n                "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "col-readonly",
                          attrs: { align: "center" }
                        },
                        [
                          _vm._v(
                            "\n                  " +
                              _vm._s(item.ingradiant) +
                              "\n                "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "col-readonly",
                          attrs: { align: "center" }
                        },
                        [_vm._v(_vm._s(item.date))]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "col-readonly",
                          attrs: { align: "center" }
                        },
                        [_vm._v(_vm._s(item.time))]
                      )
                    ]
                  )
                }),
                0
              )
            ])
          ])
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
    return _c("div", { staticClass: "ibox-title" }, [
      _c("div", { staticClass: "row align-items-center" }, [
        _c("div", { staticClass: "col-sm-12 col-lg-4 align-middle" }, [
          _c("h4", [_vm._v("รายการร้องขอวัตถุดิบ")])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { attrs: { align: "center" } }, [
        _c("th", { staticStyle: { "min-width": "311px" } }, [
          _vm._v("ประเภทวัตถุดิบ")
        ]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "150px" } }, [
          _vm._v("หมายเลขเครื่อง")
        ]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "150px" } }, [
          _vm._v("ตราบุหรี่")
        ]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "150px" } }, [_vm._v("วันที่")]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "150px" } }, [_vm._v("เวลา")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);