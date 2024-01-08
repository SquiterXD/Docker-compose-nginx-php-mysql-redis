(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_groupProducts_tableComponies_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["groupProducts", "btnTrans"],
  data: function data() {
    return {
      loading: false // groupProductsList: this.groupProducts,
      // currentPage: 1,
      // perPage: 10,

    };
  },
  computed: {// rows() {
    //     return this.groupProducts.length;
    // },
    // groupProductsList() {
    //     return this.groupProducts.slice(
    //         (   this.currentPage - 1) * this.perPage,
    //             this.currentPage * this.perPage,
    //     );
    // }
  },
  mounted: function mounted() {
    $('.table-test').dataTable({
      "searching": false,
      "bInfo": false,
      "order": [[0, 'asc'], [1, 'asc'], [2, 'asc']],
      columnDefs: [{
        orderable: false,
        targets: 5
      }]
    });
  },
  methods: {
    changeActive: function changeActive(data, flag) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.loading = true;
                params = {
                  group_product_id: data.group_product_id,
                  active_flag: flag ? 'Y' :  true ? 'N' : 0
                };
                _context.next = 4;
                return axios.get('/ir/ajax/product-groups/updateActiveFlag', {
                  params: params
                }).then(function (res) {
                  if (res.data.status == 'success') {
                    swal({
                      title: "Success !",
                      text: "บันทึกสำเร็จ",
                      type: "success",
                      showConfirmButton: true
                    });
                    _this.loading = false;
                    setTimeout(function () {
                      window.location.reload(false);
                    }, 3000);
                  } else {
                    swal({
                      title: "Error !",
                      text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่",
                      type: "error",
                      showConfirmButton: true
                    });
                    _this.loading = false;
                    setTimeout(function () {
                      window.location.reload(false);
                    }, 3000);
                  }
                });

              case 4:
                return _context.abrupt("return", _context.sent);

              case 5:
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

/***/ "./resources/js/components/ir/groupProducts/tableComponies.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/tableComponies.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _tableComponies_vue_vue_type_template_id_10e9f71c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tableComponies.vue?vue&type=template&id=10e9f71c& */ "./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=template&id=10e9f71c&");
/* harmony import */ var _tableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./tableComponies.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _tableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _tableComponies_vue_vue_type_template_id_10e9f71c___WEBPACK_IMPORTED_MODULE_0__.render,
  _tableComponies_vue_vue_type_template_id_10e9f71c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/groupProducts/tableComponies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./tableComponies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=template&id=10e9f71c&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=template&id=10e9f71c& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponies_vue_vue_type_template_id_10e9f71c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponies_vue_vue_type_template_id_10e9f71c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponies_vue_vue_type_template_id_10e9f71c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./tableComponies.vue?vue&type=template&id=10e9f71c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=template&id=10e9f71c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=template&id=10e9f71c&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/groupProducts/tableComponies.vue?vue&type=template&id=10e9f71c& ***!
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
  return _c(
    "div",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      staticClass: "table-responsive",
      staticStyle: { "max-height": "500px" }
    },
    [
      _c(
        "table",
        {
          staticClass: "table table-test table table-bordered",
          staticStyle: { position: "sticky" }
        },
        [
          _vm._m(0),
          _vm._v(" "),
          this.groupProducts.length != 0
            ? _c(
                "tbody",
                _vm._l(_vm.groupProducts, function(data, index) {
                  return _c("tr", { key: index }, [
                    _c(
                      "td",
                      {
                        staticClass: "text-left",
                        staticStyle: {
                          "font-size": "12px",
                          "vertical-align": "middle"
                        },
                        attrs: {
                          "data-sort": data.policy_set_headers.policy_set_number
                        }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(
                              data.policy_set_headers != null
                                ? data.policy_set_headers.policy_set_number +
                                    " : " +
                                    data.policy_set_headers
                                      .policy_set_description
                                : ""
                            ) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-left",
                        staticStyle: {
                          "font-size": "12px",
                          "vertical-align": "middle"
                        },
                        attrs: {
                          "data-sort": data.asset_group
                            ? data.asset_group.meaning
                            : ""
                        }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(
                              data.asset_group
                                ? data.asset_group.meaning +
                                    " : " +
                                    data.asset_group.description
                                : ""
                            ) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-left",
                        staticStyle: {
                          "font-size": "12px",
                          "vertical-align": "middle"
                        }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(data.description) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-left",
                        staticStyle: {
                          "font-size": "12px",
                          "vertical-align": "middle"
                        }
                      },
                      [
                        _vm._v(
                          "\n                    " +
                            _vm._s(
                              data.mapping_acc
                                ? data.mapping_acc.account_combine
                                : ""
                            ) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: { "vertical-align": "middle" },
                        attrs: {
                          "data-sort": data.active_flag == "Y" ? true : false
                        }
                      },
                      [
                        _c("el-checkbox", {
                          attrs: {
                            checked: data.active_flag == "Y" ? true : false
                          },
                          on: {
                            change: function($event) {
                              return _vm.changeActive(data, data.flag)
                            }
                          },
                          model: {
                            value: data.flag,
                            callback: function($$v) {
                              _vm.$set(data, "flag", $$v)
                            },
                            expression: "data.flag"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-center",
                        staticStyle: {
                          "font-size": "12px",
                          "vertical-align": "middle"
                        }
                      },
                      [
                        _c(
                          "a",
                          {
                            class: _vm.btnTrans.edit.class + " btn-xs",
                            attrs: {
                              type: "button",
                              href:
                                "/ir/settings/product-groups/" +
                                data.group_product_id +
                                "/edit"
                            }
                          },
                          [
                            _c("i", {
                              class: _vm.btnTrans.edit.icon,
                              attrs: { "aria-hidden": "true" }
                            }),
                            _vm._v(
                              " \n                        " +
                                _vm._s(_vm.btnTrans.edit.text) +
                                "\n                    "
                            )
                          ]
                        )
                      ]
                    )
                  ])
                }),
                0
              )
            : _c("tbody", [_vm._m(1)])
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "font-size": "12px",
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            },
            attrs: { width: "15%" }
          },
          [_c("div", [_vm._v("กรมธรรม์ชุดที่")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "font-size": "12px",
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            },
            attrs: { width: "20%" }
          },
          [_c("div", [_vm._v("กลุ่มของทรัพย์สิน")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "font-size": "12px",
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            },
            attrs: { width: "20%" }
          },
          [_c("div", [_vm._v("รายการ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "font-size": "12px",
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            },
            attrs: { width: "20%" }
          },
          [_c("div", [_vm._v("รหัสบัญชี")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "font-size": "12px",
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            },
            attrs: { width: "1%" }
          },
          [_c("div", [_vm._v("Active")])]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center",
          staticStyle: {
            "font-size": "12px",
            "background-color": "#f7f7f7",
            position: "sticky",
            "z-index": "9999",
            top: "0"
          },
          attrs: { width: "10%" }
        })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "td",
        {
          staticClass: "text-center",
          staticStyle: { "font-size": "18px", "vertical-align": "middle" },
          attrs: { colspan: "6" }
        },
        [_vm._v("ไม่พบข้อมูล")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);