(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_sub-groups_editComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["policySets", "header", 'subLines', 'btnTrans'],
  data: function data() {
    return {
      lines: [],
      id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
      policyHeader: this.header.policy_set_header_id,
      activeRow: ''
    };
  },
  mounted: function mounted() {
    var _this = this;

    this.subLines.forEach(function (subLine) {
      _this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
        subId: subLine.sub_group_id,
        subCode: subLine.sub_group_code,
        subGroupSource: subLine.sub_group_source,
        subDescription: subLine.sub_group_description,
        active: subLine.active_flag == 'Y' ? true : false,
        openRow: true,
        delRow: false
      });
    });
  },
  methods: {
    addLine: function addLine() {
      this.lines.push({
        id: "Item #" + this.lines.length,
        subGroupCode: '',
        subGroupDescription: '',
        subGroupSource: '',
        active: true,
        openRow: false,
        // delRow: false,
        delRow: true
      });
      window.scrollTo({
        top: document.body.scrollHeight,
        left: 0,
        behavior: 'smooth'
      }); // scrollTo.top = Specifies the number of pixels along the Y axis to scroll the window or element.
      // scrollTo.left = Specifies the number of pixels along the X axis to scroll the window or element.
    },
    removeRow: function removeRow(index, delRow, row) {
      // var params = {
      //     sub_group_id    : row.subId,
      //     index           : index,
      // };
      // var dataLines = this;
      if (delRow) {
        this.lines.splice(index, 1); // swal({
        //     title: "Are you sure?",
        //     text: "You will not be able to recover this data!",
        //     type: "warning",
        //     showCancelButton: true,
        //     confirmButtonClass: 'btn btn-warning',
        //     confirmButtonText: "Confirm",
        //     closeOnConfirm: false
        // },                    
        // function (isConfirm) {
        //     if(isConfirm){
        //         axios   .get('/ir/ajax/sub-groups/destroy',{ params })
        //                 .then( res =>{ 
        //                     if(res.data.status === 's'){
        //                         swal({  title: "success !", 
        //                                 text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว", 
        //                                 type: "success",
        //                                 showConfirmButton: false
        //                         });
        //                         // dataLines.lines.splice(index, 1);
        //                         window.location.reload(false); 
        //                     }else if(res.data.status === 'e'){
        //                         swal({  title: "Error !", 
        //                                 text: "ไม่สามารถลบข้อมูลได้ เนื่อจากมีการใช้งานข้อมูลนี้อยู่", 
        //                                 type: "error",
        //                                 showConfirmButton: true
        //                         });
        //                     }
        //                 });
        //     }
        // });  
      } else {// this.lines.splice(index, 1);
        }
    },
    checkInactive: function checkInactive(row, index) {
      var params = {
        active: row.active ? 'Y' : 'N',
        sub_group_code: row.subCode,
        id: row.subId
      };
      return axios.get('/ir/ajax/sub-groups/check-inactive', {
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
            text: "ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่ที่หน้าจอ IRM0005",
            type: "error",
            showConfirmButton: true
          });
          row.active = true;
        }
      });
    },
    checkDuplicateSubGroupCode: function checkDuplicateSubGroupCode(index) {
      var _this2 = this;

      this.lines.forEach(function (element, i) {
        if (i != index) {
          if (_this2.lines[index].subCode == element.subCode) {
            swal({
              title: "warning !",
              text: "รหัสข้อมูลซ้ำ",
              type: "warning",
              showConfirmButton: true
            });
          }
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/sub-groups/editComponent.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/ir/sub-groups/editComponent.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _editComponent_vue_vue_type_template_id_e1152fa0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editComponent.vue?vue&type=template&id=e1152fa0& */ "./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=template&id=e1152fa0&");
/* harmony import */ var _editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _editComponent_vue_vue_type_template_id_e1152fa0___WEBPACK_IMPORTED_MODULE_0__.render,
  _editComponent_vue_vue_type_template_id_e1152fa0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/sub-groups/editComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./editComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=template&id=e1152fa0&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=template&id=e1152fa0& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_template_id_e1152fa0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_template_id_e1152fa0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_editComponent_vue_vue_type_template_id_e1152fa0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./editComponent.vue?vue&type=template&id=e1152fa0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=template&id=e1152fa0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=template&id=e1152fa0&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/sub-groups/editComponent.vue?vue&type=template&id=e1152fa0& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.policyHeader,
          expression: "policyHeader"
        }
      ],
      attrs: { type: "hidden", name: "policyHeader", autocomplete: "off" },
      domProps: { value: _vm.policyHeader },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.policyHeader = $event.target.value
        }
      }
    }),
    _vm._v(" "),
    _c("div", { staticClass: "text-right" }, [
      _c(
        "button",
        {
          class: _vm.btnTrans.add.class + " btn-sm",
          attrs: { type: "submit", id: "myBtn" },
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.addLine($event)
            }
          }
        },
        [
          _c("i", {
            class: _vm.btnTrans.add.icon,
            attrs: { "aria-hidden": "true" }
          }),
          _vm._v(
            " \n            " + _vm._s(_vm.btnTrans.add.text) + " \n        "
          )
        ]
      )
    ]),
    _c("br"),
    _vm._v(" "),
    _c("table", { staticClass: "table table-responsive-sm" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "tbody",
        [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.policyHeader,
                expression: "policyHeader"
              }
            ],
            attrs: {
              type: "hidden",
              name: "policyHeader",
              autocomplete: "off"
            },
            domProps: { value: _vm.policyHeader },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.policyHeader = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _vm._l(_vm.lines, function(row, index) {
            return _c("tr", { key: index, attrs: { row: row } }, [
              _c(
                "td",
                {
                  staticClass: "text-center",
                  staticStyle: { "vertical-align": "middle" }
                },
                [_vm._v(" " + _vm._s(index + 1) + " ")]
              ),
              _vm._v(" "),
              _c(
                "td",
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: row.subId,
                        expression: "row.subId"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "dataGroup[" + row.id + "][sub_group_id]",
                      autocomplete: "off"
                    },
                    domProps: { value: row.subId },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(row, "subId", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: row.subCode,
                        expression: "row.subCode"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "dataGroup[" + row.id + "][sub_group_code]",
                      autocomplete: "off"
                    },
                    domProps: { value: row.subCode },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(row, "subCode", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-input", {
                    attrs: {
                      placeholder: "ระบุรหัส",
                      size: "mediem",
                      disabled: row.openRow
                    },
                    on: {
                      change: function($event) {
                        return _vm.checkDuplicateSubGroupCode(index)
                      }
                    },
                    model: {
                      value: row.subCode,
                      callback: function($$v) {
                        _vm.$set(row, "subCode", $$v)
                      },
                      expression: "row.subCode"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "td",
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: row.subDescription,
                        expression: "row.subDescription"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "dataGroup[" + row.id + "][sub_group_description]",
                      autocomplete: "off"
                    },
                    domProps: { value: row.subDescription },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(row, "subDescription", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-input", {
                    attrs: { placeholder: "ระบุคำอธิบาย", size: "mediem" },
                    model: {
                      value: row.subDescription,
                      callback: function($$v) {
                        _vm.$set(row, "subDescription", $$v)
                      },
                      expression: "row.subDescription"
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
                  staticStyle: { "vertical-align": "middle" }
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: row.active,
                        expression: "row.active"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "dataGroup[" + row.id + "][active_flag]",
                      autocomplete: "off"
                    },
                    domProps: { value: row.active },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(row, "active", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("el-checkbox", {
                    staticClass: "text-center",
                    on: {
                      change: function($event) {
                        return _vm.checkInactive(row, index)
                      }
                    },
                    model: {
                      value: row.active,
                      callback: function($$v) {
                        _vm.$set(row, "active", $$v)
                      },
                      expression: "row.active"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              row.delRow
                ? _c(
                    "td",
                    {
                      staticClass: "text-center",
                      staticStyle: { "vertical-align": "middle" }
                    },
                    [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-sm btn-danger",
                          attrs: { id: "click" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.removeRow(index, row.delRow, row)
                            }
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "fa fa-times",
                            attrs: { "aria-hidden": "true" }
                          })
                        ]
                      )
                    ]
                  )
                : _c("td", {
                    staticClass: "text-center",
                    staticStyle: { "vertical-align": "middle" }
                  })
            ])
          })
        ],
        2
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "1%" } }),
        _vm._v(" "),
        _c("th", { attrs: { width: "10%" } }, [
          _vm._v(" รหัส (Code) "),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "20%" } }, [
          _vm._v(" คำอธิบาย (Description) "),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } }, [
          _vm._v(" Active "),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);