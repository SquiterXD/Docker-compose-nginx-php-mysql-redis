(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_product-inv_TableComponies_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['headers'],
  data: function data() {
    return {};
  },
  mounted: function mounted() {
    $('.myTable').dataTable({
      "searching": false,
      "bInfo": false
    });
  },
  computed: {},
  methods: {
    changeActive: function changeActive(data) {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var flag, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                flag = $("#checkbox".concat(data)).is(':checked');
                params = {
                  header_id: data,
                  active_flag: flag ? 'Y' :  true ? 'N' : 0
                };
                _context.next = 4;
                return axios.get('/ir/ajax/product-header/updateActiveFlag', {
                  params: params
                }).then(function (res) {
                  if (res.data.status == 'success') {
                    swal({
                      title: "Success !",
                      text: "บันทึกสำเร็จ",
                      type: "success",
                      showConfirmButton: true
                    });
                  } else {
                    swal({
                      title: "Error !",
                      text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่",
                      type: "error",
                      showConfirmButton: true
                    });
                  }

                  if (res.data.status == 'IRM0004Close') {
                    swal({
                      title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                      text: "ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 และ IRM0005 ใช่ไหม?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: 'btn btn-warning',
                      confirmButtonText: "เปิดการใช้งาน",
                      closeOnConfirm: false
                    }, function (isConfirm) {
                      var params = {
                        header_id: data,
                        confirm: isConfirm,
                        active_flag: flag ? 'Y' :  true ? 'N' : 0
                      };

                      if (isConfirm) {
                        axios.get('/ir/ajax/product-header/updateActiveFlag', {
                          params: params
                        }).then(function (res) {
                          swal({
                            title: "success !",
                            text: "บันทึกสำเร็จ",
                            type: "success",
                            showConfirmButton: true
                          }); // window.location.reload(false); 

                          $("#checkbox".concat(data)).prop('checked', true);
                        });
                      } else {
                        $("#checkbox".concat(data)).prop('checked', false);
                      }
                    });
                  }

                  if (res.data.status == 'twoClose') {
                    swal({
                      title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                      text: "ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า และ IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 IRM0009 และ IRM0005 ใช่ไหม?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: 'btn btn-warning',
                      confirmButtonText: "เปิดการใช้งาน",
                      closeOnConfirm: false
                    }, function (isConfirm) {
                      var params = {
                        header_id: data,
                        confirm: isConfirm,
                        active_flag: flag ? 'Y' :  true ? 'N' : 0
                      };

                      if (isConfirm) {
                        axios.get('/ir/ajax/product-header/updateActiveFlag', {
                          params: params
                        }).then(function (res) {
                          swal({
                            title: "success !",
                            text: "บันทึกสำเร็จ",
                            type: "success",
                            showConfirmButton: true
                          }); // window.location.reload(false); 

                          $("#checkbox".concat(data)).prop('checked', true);
                        });
                      } else {
                        $("#checkbox".concat(data)).prop('checked', false);
                      }
                    });
                  }

                  if (res.data.status == 'IRM0009Close') {
                    swal({
                      title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                      text: "ข้อมูลหน้า IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0009 และ IRM0005 ใช่ไหม?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: 'btn btn-warning',
                      confirmButtonText: "เปิดการใช้งาน",
                      closeOnConfirm: false
                    }, function (isConfirm) {
                      var params = {
                        header_id: data,
                        confirm: isConfirm,
                        active_flag: flag ? 'Y' :  true ? 'N' : 0
                      };

                      if (isConfirm) {
                        axios.get('/ir/ajax/product-header/updateActiveFlag', {
                          params: params
                        }).then(function (res) {
                          swal({
                            title: "success !",
                            text: "บันทึกสำเร็จ",
                            type: "success",
                            showConfirmButton: true
                          }); // window.location.reload(false);

                          $("#checkbox".concat(data)).prop('checked', true);
                        });
                      } else {
                        $("#checkbox".concat(data)).prop('checked', false);
                      }
                    });
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

/***/ "./resources/js/components/ir/product-inv/TableComponies.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/TableComponies.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponies_vue_vue_type_template_id_4bfa6242___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponies.vue?vue&type=template&id=4bfa6242& */ "./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=template&id=4bfa6242&");
/* harmony import */ var _TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponies.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponies_vue_vue_type_template_id_4bfa6242___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponies_vue_vue_type_template_id_4bfa6242___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/product-inv/TableComponies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=template&id=4bfa6242&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=template&id=4bfa6242& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_template_id_4bfa6242___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_template_id_4bfa6242___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponies_vue_vue_type_template_id_4bfa6242___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponies.vue?vue&type=template&id=4bfa6242& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=template&id=4bfa6242&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=template&id=4bfa6242&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/TableComponies.vue?vue&type=template&id=4bfa6242& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "table-responsive", staticStyle: { "max-height": "500px" } },
    [
      _c("div", { staticClass: "table", attrs: { id: "table" } }, [
        _c(
          "table",
          {
            staticClass: "table table table-bordered myTable",
            staticStyle: { position: "sticky" }
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _vm.headers.length != 0
              ? _c(
                  "tbody",
                  _vm._l(_vm.headers, function(header, index) {
                    return _c("tr", { key: index }, [
                      _c(
                        "td",
                        {
                          staticClass: "text-left",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          },
                          attrs: {
                            "data-sort":
                              header.group_product.policy_set_header
                                .policy_set_number
                          }
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                (header.group_product
                                ? header.group_product.policy_set_header
                                : "")
                                  ? header.group_product.policy_set_header
                                      .policy_set_number +
                                      " : " +
                                      header.group_product.policy_set_header
                                        .policy_set_description
                                  : ""
                              ) +
                              "\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "text-left",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                (header.group_product
                                ? header.group_product.asset_group
                                : "")
                                  ? header.group_product.asset_group.meaning +
                                      " : " +
                                      header.group_product.asset_group
                                        .description
                                  : ""
                              ) +
                              "\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "text-left",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                header.group_product
                                  ? header.group_product.description
                                  : ""
                              ) +
                              "\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "text-left",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                header.department_code +
                                  " : " +
                                  header.department_desc
                              ) +
                              "\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "text-left",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                header.subinventory_code +
                                  " : " +
                                  header.subinventory_desc
                              ) +
                              "\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "text-left",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(
                                header.sub_group_code +
                                  " : " +
                                  header.sub_group_desc
                              ) +
                              "\n                        "
                          )
                        ]
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
                          _c("input", {
                            attrs: {
                              type: "checkbox",
                              id: "checkbox" + header.header_id
                            },
                            domProps: { checked: header.showFlag },
                            on: {
                              change: function($event) {
                                return _vm.changeActive(header.header_id)
                              }
                            }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        {
                          staticClass: "text-center",
                          staticStyle: {
                            "font-size": "11px",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _c(
                            "a",
                            {
                              staticClass: "btn btn-warning btn-xs",
                              attrs: {
                                type: "button",
                                href:
                                  "/ir/settings/product-header/" +
                                  header.header_id +
                                  "/edit"
                              }
                            },
                            [
                              _c("i", {
                                staticClass: "fa fa-pencil-square-o",
                                attrs: { "aria-hidden": "true" }
                              }),
                              _vm._v(" แก้ไข\n                            ")
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
      ])
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
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("กรมธรรม์ชุดที่")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("กลุ่มของทรัพย์สิน")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("รายการ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("รหัสหน่วยงาน")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("รหัสคลังสินค้า")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("กลุ่มสินค้าย่อย")]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              position: "sticky",
              "background-color": "#f7f7f7",
              "z-index": "9999",
              top: "0"
            }
          },
          [_vm._v("Active")]
        ),
        _vm._v(" "),
        _c("th", {
          staticStyle: {
            width: "78px",
            position: "sticky",
            "background-color": "#f7f7f7",
            "z-index": "9999",
            top: "0"
          }
        })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { attrs: { colspan: "8" } }, [
        _c("h3", { staticClass: "p-5 text-center text-muted" }, [
          _vm._v(" ไม่พบข้อมูล ")
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);