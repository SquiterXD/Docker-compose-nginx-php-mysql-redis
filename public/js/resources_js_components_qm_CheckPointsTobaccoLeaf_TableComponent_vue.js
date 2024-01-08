(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_CheckPointsTobaccoLeaf_TableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['checkPoints', 'profile'],
  data: function data() {
    return {
      hrefTarget: '_blank'
    };
  },
  mounted: function mounted() {
    $('.dataTable').dataTable({
      "searching": false,
      "bInfo": false,
      columnDefs: [{
        orderable: false,
        targets: 4
      }, {
        orderable: false,
        targets: 5
      }]
    });
  },
  methods: {
    removeFile: function removeFile(id) {
      var programCode = this.profile.program_code;
      swal({
        title: "คุณแน่ใจ?",
        text: "คุณที่จะต้องการลบรูปภาพนี้ใช่ไหม ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-warning',
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          return axios.get('/qm/ajax/attachments/' + id + '/' + programCode + '/deleteByPKGCheckPoints').then(function (res) {
            console.log(res.data.message);

            if (res.data.message == "Success") {
              swal({
                title: "success !",
                text: "ลบรูปภาพสำเร็จ !",
                type: "success",
                showConfirmButton: true
              });
              setTimeout(function () {
                window.location.reload(false);
              }, 3000);
            }
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponent_vue_vue_type_template_id_62e03a0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=template&id=62e03a0e& */ "./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=template&id=62e03a0e&");
/* harmony import */ var _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponent_vue_vue_type_template_id_62e03a0e___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponent_vue_vue_type_template_id_62e03a0e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=template&id=62e03a0e&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=template&id=62e03a0e& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_62e03a0e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_62e03a0e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_62e03a0e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=template&id=62e03a0e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=template&id=62e03a0e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=template&id=62e03a0e&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/TableComponent.vue?vue&type=template&id=62e03a0e& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "table-responsive" }, [
    _c("table", { staticClass: "table program_info_tb dataTable" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "tbody",
        _vm._l(this.checkPoints, function(data, index) {
          return _c("tr", { key: index, attrs: { row: data } }, [
            _c(
              "td",
              {
                staticClass: "text-center",
                staticStyle: { "vertical-align": "middle" },
                attrs: { "data-sort": data.enabled_flag }
              },
              [
                data.enabled_flag == "Y"
                  ? _c("div", [
                      _c("i", {
                        staticClass: "fa fa-check-circle text-success"
                      })
                    ])
                  : _c("div", [
                      _c("i", { staticClass: "fa fa-circle text-muted" })
                    ])
              ]
            ),
            _vm._v(" "),
            _c(
              "td",
              {
                staticClass: "text-left",
                staticStyle: { "vertical-align": "middle" }
              },
              [
                _vm._v(
                  "\n                    " +
                    _vm._s(data.location_desc) +
                    "\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "td",
              {
                staticClass: "text-left",
                staticStyle: { "vertical-align": "middle" }
              },
              [
                _vm._v(
                  "\n                    " +
                    _vm._s(data.locator_desc) +
                    "\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "td",
              {
                staticClass: "text-left",
                staticStyle: { "vertical-align": "middle" }
              },
              [
                _vm._v(
                  "\n                    " +
                    _vm._s(data.qm_group) +
                    "\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "td",
              {
                staticClass: "text-center",
                staticStyle: { "vertical-align": "middle" }
              },
              [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-primary",
                    attrs: {
                      type: "button",
                      "data-toggle": "modal",
                      "data-target":
                        "#exampleModalScrollable" + data.inventory_location_id,
                      disabled: data.isAttachments
                    }
                  },
                  [
                    _c("i", {
                      staticClass: "fa fa-file-image-o",
                      attrs: { "aria-hidden": "true" }
                    }),
                    _vm._v(" ดูรูปภาพ\n                    ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "modal fade",
                    attrs: {
                      id: "exampleModalScrollable" + data.inventory_location_id,
                      tabindex: "-1",
                      role: "dialog",
                      "aria-labelledby":
                        "exampleModalScrollableTitle" +
                        data.inventory_location_id,
                      "aria-hidden": "true"
                    }
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass: "modal-dialog modal-dialog-scrollable",
                        attrs: { role: "document" }
                      },
                      [
                        _c("div", { staticClass: "modal-content" }, [
                          _vm._m(1, true),
                          _vm._v(" "),
                          _c("div", { staticClass: "modal-body" }, [
                            _c(
                              "ul",
                              _vm._l(data.attachments, function(attach) {
                                return _c(
                                  "li",
                                  {
                                    key: attach.attachment_id,
                                    staticStyle: { "text-align": "left" }
                                  },
                                  [
                                    _c(
                                      "a",
                                      {
                                        attrs: {
                                          target: _vm.hrefTarget,
                                          href:
                                            "attachments/" +
                                            attach.attachment_id +
                                            "/imageCheckPoints"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                            " +
                                            _vm._s(attach.file_name) +
                                            "\n                                        "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "a",
                                      {
                                        on: {
                                          click: function($event) {
                                            return _vm.removeFile(
                                              attach.attachment_id
                                            )
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "fa fa-close",
                                          staticStyle: {
                                            color: "red",
                                            "text-align": "right"
                                          }
                                        })
                                      ]
                                    )
                                  ]
                                )
                              }),
                              0
                            )
                          ]),
                          _vm._v(" "),
                          _vm._m(2, true)
                        ])
                      ]
                    )
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "td",
              {
                staticClass: "text-center",
                staticStyle: { "vertical-align": "middle" }
              },
              [
                _c(
                  "a",
                  {
                    staticClass: "btn btn-warning",
                    attrs: {
                      type: "button",
                      href:
                        "/qm/settings/check-points-tobacco-leaf/" +
                        data.inventory_location_id +
                        "/edit"
                    }
                  },
                  [
                    _c("i", {
                      staticClass: "fa fa-pencil-square-o",
                      attrs: { "aria-hidden": "true" }
                    }),
                    _vm._v(" แก้ไข\n                    ")
                  ]
                )
              ]
            )
          ])
        }),
        0
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
        _c("th", { staticClass: "text-center" }, [
          _c("div", [_vm._v("สถานะการใช้งาน")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-left" }, [
          _c("div", [_vm._v("ชื่อจุดตรวจสอบ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-left" }, [
          _c("div", [_vm._v("รายละเอียดจุดตรวจสอบ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-left" }, [
          _c("div", [_vm._v("กลุ่มงาน")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("div", [_vm._v("รูปภาพประกอบ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_c("div")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "h5",
        {
          staticClass: "modal-title",
          attrs: { id: "exampleModalScrollableTitle" }
        },
        [_vm._v("ดูแนบรูปภาพ")]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-label": "Close"
          }
        },
        [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-secondary",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("ปิด")]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);